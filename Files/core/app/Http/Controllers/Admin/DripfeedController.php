<?php

namespace App\Http\Controllers\Admin;

use App\Lib\SMM;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Category;
use App\Constants\Status;
use App\Models\ApiProvider;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DripfeedController extends Controller
{
    public function index()
    {
        $pageTitle = "All Dripfeed";
        $orders    = $this->orderData(null, true);
        $categories = Category::active()->orderBy('name')->get();
        $apiLists   = ApiProvider::active()->get();
        return view('admin.dripfeed.index', compact('pageTitle', 'orders', 'categories', 'apiLists'));
    }

    public function pending()
    {
        $pageTitle = "Pending Dripfeed";
        $orders    = $this->orderData('pending');
        return view('admin.dripfeed.index', compact('pageTitle', 'orders'));
    }

    public function processing()
    {
        $pageTitle = "Processing Dripfeed";
        $orders    = $this->orderData('processing');
        return view('admin.dripfeed.index', compact('pageTitle', 'orders'));
    }

    public function completed()
    {
        $pageTitle = "Completed Dripfeed";
        $orders    = $this->orderData('completed');
        return view('admin.dripfeed.index', compact('pageTitle', 'orders'));
    }

    public function cancelled()
    {
        $pageTitle = "Cancelled Dripfeed";
        $orders    = $this->orderData('cancelled');
        return view('admin.dripfeed.index', compact('pageTitle', 'orders'));
    }

    public function refunded()
    {
        $pageTitle = "Refunded Dripfeed";
        $orders    = $this->orderData('refunded');
        return view('admin.dripfeed.index', compact('pageTitle', 'orders'));
    }

    protected function orderData($scope = null, $customFilter = false)
    {
        if ($scope) {
            $orders = Order::$scope();
        } else {
            $orders = Order::query();
        }
        if ($customFilter) {
            $orders = $orders->searchable(['user:username', 'id'])
                ->dateFilter()
                ->filter(['category_id', 'api_provider_id', 'service:refill']);
        } else {
            $orders = $orders->searchable(['user:username', 'category:name', 'service:name']);
        }
        return $orders->dripfeedOrder()->with(['category', 'user', 'service'])->orderBy('id', 'desc')->paginate(getPaginate());
    }

    public function details($id)
    {
        $pageTitle = 'Dripfeed Details';
        $order     = Order::dripfeedOrder()->findOrFail($id);
        return view('admin.order.details', compact('pageTitle', 'order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::with('user', 'category')->dripfeedOrder()->findOrFail($id);
        $dripfeedSize  = $order->quantity / $order->runs;

        $request->validate([
            'start_count' => 'required|integer|size:' . $dripfeedSize,
            'status'      => 'required|integer|in:0,1,2,3,4',
        ], [
            'start_count' => 'Start count must be equal to dripfeed quantity',
        ]);

        if (!$order->updated_at->lte(Carbon::now()->subMinutes($order->interval))) {
            $notify[] = ['error', "This dripfeed order can't exceed" . " " . $order->interval . " " . "minutes"];
            return back()->withNotify($notify);
        }

        $order->start_counter = $request->start_count;
        $order->remain        = ($order->quantity - $request->start_count);
        $user                 = $order->user;

        if ($request->status == Status::ORDER_PROCESSING) {
            $order->status = Status::ORDER_PROCESSING;
            $order->save();

            notify($user, 'PROCESSING_ORDER', [
                'service_name' => $order->service->name,
                'username'     => $order->user->username,
                'price'        => $order->price,
                'full_name'    => $order->user->fullname,
                'category'     => $order->category->name

            ]);
        }

        //Complete Order
        if ($request->status == Status::ORDER_COMPLETED) {
            $order->status = Status::ORDER_COMPLETED;
            $order->save();
            //Send email to user
            notify($user, 'COMPLETED_ORDER', [
                'service_name' => $order->service->name,
                'username'     => $order->user->username,
                'price'        => $order->price,
                'full_name'    => $order->user->fullname,
                'category'     => $order->category->name
            ]);
        }

        //Cancelled
        if ($request->status == Status::ORDER_CANCELLED) {
            $order->status = Status::ORDER_CANCELLED;
            $order->save();

            //Send email to user
            notify($user, 'CANCELLED_ORDER', [
                'service_name' => $order->service->name,
                'username'     => $order->user->username,
                'full_name'    => $order->user->fullname,
                'price'        => $order->price,
                'category'     => $order->category->name
            ]);
        }

        //Refunded
        if ($request->status == Status::ORDER_REFUNDED) {
            if ($order->status == Status::ORDER_COMPLETED || $order->status == Status::ORDER_CANCELLED) {
                $notify[] = ['error', 'This dripfeed order is not refundable'];
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
            $transaction->details      = 'Refund for dripfeed order ' . $order->service->name;
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
        $notify[] = ['success', 'Dripfeed order successfully updated'];
        return back()->withNotify($notify);
    }

    public function apiOrder()
    {
        $pageTitle = 'Orders To Provider';
        $orders = Order::dripfeedOrder()
            ->pending()
            ->where('api_order', '!=', 0)
            ->where('api_order_id', 0)
            ->with(['category', 'user', 'service', 'provider'])
            ->orderByDesc('id')
            ->paginate(getPaginate());

        $providers = ApiProvider::active()->get();

        return view('admin.order.api_order', compact('pageTitle', 'orders', 'providers'));
    }

    public function apiOrderSubmit(Request $request)
    {
        $notify = SMM::placeOrderToProvider('dripfeedOrder');

        $notify[] = ['success', 'Selected orders placed to the API provider successfully'];
        return back()->withNotify($notify);
    }

    public function providerInformationUpdate(Request $request)
    {
        SMM::providerInformationUpdate();

        $notify[] = ['success', 'Provider information updated successfully'];
        return back()->withNotify($notify);
    }
}
