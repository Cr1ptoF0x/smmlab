<?php

namespace App\Lib;

use App\Models\Order;
use App\Constants\Status;
use App\Models\Transaction;

class SMM
{
    public static function placeOrderToProvider($scope = null)
    {
        if ($scope) {
            $apiOrders = Order::$scope();
        } else {
            $apiOrders = Order::query();
        }

        $apiOrders = $apiOrders->pending()->with(['provider', 'service'])
            ->where('api_provider_id', '!=', Status::API_ORDER_NOT_PLACE)
            ->where('order_placed_to_api', Status::API_ORDER_NOT_PLACE)
            ->get();

        $notify = [];

        foreach ($apiOrders as $order) {

            if ($order->service->dripfeed) {
                $data = [
                    'key'      => $order->provider->api_key,
                    'action'   => "add",
                    'service'  => $order->api_service_id,
                    'link'     => $order->link,
                    'quantity' => $order->quantity,
                    'runs'     => $order->runs,
                    'interval' => $order->interval
                ];
            } else {
                $data = [
                    'key'      => $order->provider->api_key,
                    'action'   => "add",
                    'service'  => $order->api_service_id,
                    'link'     => $order->link,
                    'quantity' => $order->quantity,
                ];
            }
            $response = CurlRequest::curlPostContent($order->provider->api_url, $data);
            $response = json_decode($response);
            if (@$response->error) {
                $notify[] = ['info', $response->error];
                echo response()->json(['error' => @$response->error]) . '<br>';
                continue;
            }

            $order->status              = Status::ORDER_PROCESSING;
            $order->order_placed_to_api = Status::YES;
            $order->api_order_id        = $response->order;
            $order->save();
        }
        return $notify;
    }

    public static function providerInformationUpdate()
    {
        $orders = Order::processing()->with('provider')->where('api_provider_id', '!=', 0)->where('order_placed_to_api', Status::YES)->get();

        foreach ($orders as $order) {
            $response = CurlRequest::curlPostContent($order->provider->api_url, [
                'key'    => $order->provider->api_key,
                'action' => "status",
                'order'  => $order->api_order_id,
            ]);
            $response = json_decode($response);
            if (@$response->error) {
                echo response()->json(['error' => @$response->error]) . '<br>';
                continue;
            }
            $order->start_counter = $response->start_count;
            $order->remain        = $response->remains;
            $user                 = $order->user;
            if ($response->status == 'Completed') {
                $order->status = Status::ORDER_COMPLETED;
                $order->save();
                //Send email to user
                notify($user, 'COMPLETED_ORDER', [
                    'service_name' => $order->service->name,
                    'username'     => $order->user->username,
                    'price'        => $order->price,
                    'full_name'    => $order->user->fullname,
                    'category'     => $order->category->name,
                ]);
            }

            if ($response->status == 'Canceled') {
                $order->status = Status::ORDER_CANCELLED;
                $order->save();
                //Send email to user
                notify($user, 'CANCELLED_ORDER', [
                    'service_name' => $order->service->name,
                    'username'     => $order->user->username,
                    'full_name'    => $order->user->fullname,
                    'price'        => $order->price,
                    'category'     => $order->category->name,
                ]);
            }
            if ($response->status == 'Refunded') {
                if ($order->status == Status::ORDER_COMPLETED || $order->status == Status::ORDER_CANCELLED) {
                    $notify[] = ['error', 'This order is not refundable'];
                    return back()->withNotify($notify);
                }
                $order->status = Status::ORDER_REFUNDED;
                $order->save();
                //Refund balance
                $user->balance += $order->price;
                $user->save();
                //Create Transaction
                $transaction               = new Transaction();
                $transaction->user_id      = $user->id;
                $transaction->amount       = $order->price;
                $transaction->post_balance = $user->balance;
                $transaction->trx_type     = '+';
                $transaction->remark       = "refund_order";
                $transaction->details      = 'Refund for Order ' . $order->service->name;
                $transaction->trx          = getTrx();
                $transaction->save();
                //Send email to user
                notify($user, 'REFUNDED_ORDER', [
                    'service_name' => $order->service->name,
                    'price'        => getAmount($order->price),
                    'currency'     => gs()->cur_text,
                    'post_balance' => getAmount($user->balance),
                    'trx'          => $transaction->trx,
                ]);
            }
            $order->save();
        }
    }
}
