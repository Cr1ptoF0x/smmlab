<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Models\Order;
use App\Models\Refill;
use App\Lib\CurlRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RefillController extends Controller
{
    public function index()
    {
        $pageTitle = 'Refill';
        $refills = Refill::authUserRefill()->with(['order'])->orderByDesc('id')->paginate(getPaginate());

        return view('Template::user.refill.index', compact('pageTitle', 'refills'));
    }

    public function store(Request $request, $id)
    {
        $order = Order::completed()->where('user_id', auth()->id())->with('service')->findOrFail($id);
        $refill = Refill::where('status', Status::NO)->where('order_id', $order->id)->first();
        if ($refill) {
            $notify[] = ['error', 'You have already make a refill request for this order'];
            return back()->withNotify($notify);
        }

        $service = $order->service;
        if (!$service->refill) {
            $notify[] = ['error' => 'This service doesn\'t allow refill'];
            return back()->withNotify($notify);
        }

        $providerRefillId = 0;
        if ($service->api_provider_id) {
            $data = [
                'key'      => $order->provider->api_key,
                'action'   => "refill",
                'order'    => $order->api_order_id,
            ];
            $response = CurlRequest::curlPostContent($order->provider->api_url, $data);
            $response = json_decode($response);
            if (@$response->success) {
                $providerRefillId = $response->refill;
            }
        }

        $refill                      = new Refill();
        $refill->order_id            = $id;
        $refill->provider_refill_id  = $providerRefillId;
        $refill->request_to_provider = $providerRefillId ? Status::YES : Status::NO;
        $refill->save();

        $notify[] = ['success' => 'Refill request taken successfully'];
        return to_route('user.refill.index')->withNotify($notify);
    }
}
