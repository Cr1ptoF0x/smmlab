<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\CurlRequest;
use App\Models\ApiProvider;
use App\Models\Service;
use Illuminate\Http\Request;

class ApiProviderController extends Controller {
    public function index() {
        $pageTitle    = "Api Providers";
        $apiProviders = ApiProvider::orderBy('name')->withCount('services')->paginate(getPaginate());
        return view('admin.api_provider.index', compact('pageTitle', 'apiProviders'));
    }

    public function store(Request $request) {
        $request->validate([
            'name'       => 'required',
            'api_url'    => 'required|url',
            'api_key'    => 'required',
            'short_name' => 'required|max:4',

        ]);
        if ($request->id) {
            $apiProvider = ApiProvider::findOrFail($request->id);
            $message     = "API provider updated successfully";
        } else {
            $apiProvider = new ApiProvider();
            $message     = "API provider added successfully";
        }

        $apiProvider->name       = $request->name;
        $apiProvider->short_name = $request->short_name;
        $apiProvider->api_url    = $request->api_url;
        $apiProvider->api_key    = $request->api_key;
        $apiProvider->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function status($id) {
        return ApiProvider::changeStatus($id);
    }

    public function balanceUpdate($id) {
        $apiProvider = ApiProvider::active()->find($id);
        if (!$apiProvider) {
            return response()->json(['error' => 'API provider not found'], 422);
        }
        $arr = [
            'key'    => $apiProvider->api_key,
            'action' => 'balance',
        ];

        $response = CurlRequest::curlPostContent($apiProvider->api_url, $arr);
        $response = json_decode($response);

        if (@$response->error) {
            return response()->json(['error' => $response->error], 422);
        }

        $apiProvider->balance  = $response->balance;
        $apiProvider->currency = @$response->currency ?? gs('cur_text');
        $apiProvider->save();

        return response()->json([
            'success'  => 'API provider balance updated successfully',
            'balance'  => showAmount($apiProvider->balance, currencyFormat: false),
            'currency' => $apiProvider->currency,
        ]);
    }

    public function serviceSync($id) {
        $apiProvider = ApiProvider::active()->find($id);
        if (!$apiProvider) {
            return response()->json(['error' => 'API provider not found'], 422);
        }
        $arr = [
            'key'    => $apiProvider->api_key,
            'action' => 'services',
        ];

        $response = CurlRequest::curlPostContent($apiProvider->api_url, $arr);
        $response = json_decode($response);
        if (@$response->error) {
            return response()->json(['error' => $response->error], 422);
        }
        $serviceIds    = Service::where('api_provider_id', $id)->pluck('api_service_id')->toArray();
        $apiServiceIds = array_map(function ($service) {
            return $service->service;
        }, $response);

        $relevantServiceIds = array_intersect($apiServiceIds, $serviceIds);

        $filteredServices = array_filter($response, function ($service) use ($relevantServiceIds) {
            return in_array($service->service, $relevantServiceIds);
        });

        foreach ($filteredServices as $filterService) {
            $service = Service::where('api_service_id', $filterService->service)->first();
            if (!$service) {
                continue;
            }
            $service->original_price = $filterService->rate;
            $service->min            = $filterService->min;
            $service->max            = $filterService->max;
            $service->dripfeed       = $filterService->dripfeed ? Status::YES : Status::NO;
            $service->refill         = $filterService->refill ? Status::YES : Status::NO;
            $service->save();
        }

        return response()->json(['success' => 'API provider service sync completed successfully']);
    }
}
