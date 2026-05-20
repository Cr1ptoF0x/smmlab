<?php

namespace App\Http\Controllers\Admin;

use App\Models\Refill;
use App\Lib\CurlRequest;
use App\Constants\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RefillController extends Controller
{
    public function index()
    {
        $pageTitle = 'Pending Refills';
        $refills   = Refill::with('order.user')
            ->orderByDesc('id')
            ->paginate(getPaginate());

        return view('admin.refill.index', compact('pageTitle', 'refills'));
    }

    public function pending()
    {
        $pageTitle = 'Pending Refills';
        $refills   = Refill::where('status', Status::NO)
            ->where('request_to_provider', Status::NO)
            ->with('order.user')
            ->orderByDesc('id')
            ->paginate(getPaginate());

        return view('admin.refill.index', compact('pageTitle', 'refills'));
    }

    public function updateInformation(Request $request, $id)
    {
        $refill = Refill::findOrFail($id);
        $refill->status = Status::YES;
        $refill->save();

        $user = $refill->order->user;

        notify($user, 'REFILL', [
            "service_name" => $refill->order->service->name,
            "order_id" => $refill->order->id,
            "link" => $refill->order->link
        ]);

        $notify[] =  ['success', 'Refill completed successfully'];
        return back()->withNotify($notify);
    }

    public function providerRequest(Request $request)
    {
        $refills = Refill::pending()->where('request_to_provider', Status::NO)
            ->whereHas('order', function ($order) {
                $order->whereHas('provider');
            })->get();

        if (!$refills->count()) {
            $notify[] = ['error', 'No refills available for provider request'];
            return back()->withNotify($notify);
        }

        foreach ($refills as $refill) {
            $data = [
                'key'      => $refill->order->provider->api_key,
                'action'   => "refill",
                "order"    => $refill->order->api_order_id
            ];
            $response = CurlRequest::curlPostContent($refill->order->provider->api_url, $data);
            $response = json_decode($response);
            if (@$response->success) {
                $refill->provider_refill_id = $response->refill;
                $refill->request_to_provider = Status::YES;
                $refill->save();
            }
        }

        $notify[] = ['success', 'Refill request sent to the provider successfully'];
        return back()->withNotify($notify);
    }

    public function updateProviderInformation(Request $request)
    {
        $refills = Refill::pending()->where('request_to_provider', Status::YES)->get();

        if (!$refills->count()) {
            $notify[] = ['error', 'No refills were pending'];
            return back()->withNotify($notify);
        }

        foreach ($refills as $refill) {
            $data = [
                'key'      => $refill->order->provider->api_key,
                'action'   => "refill",
                "refill"   => $refill->provider_refill_id
            ];
            $response = CurlRequest::curlPostContent($refill->order->provider->api_url, $data);
            $response = json_decode($response);
            if (@$response->status) {
                $refill->status = Status::YES;
                $refill->save();

                $user = $refill->order->user;

                notify($user, 'REFILL', [
                    "service_name" => $refill->order->service->name,
                    "order_id" => $refill->order->id,
                    "link" => $refill->order->link
                ]);
            }
        }

        $notify[] = ['success', 'Providers refill information updated successfully'];
        return back()->withNotify($notify);
    }
}
