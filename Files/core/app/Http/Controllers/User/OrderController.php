<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\Service;
use App\Lib\CurlRequest;
use App\Models\Category;
use App\Constants\Status;
use App\Models\ApiProvider;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\AdminNotification;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function orderOverview($sId = 0)
    {
        $pageTitle = "Make New Order";
        $categories = Category::active()
            ->whereHas('services', function ($query) {
                return $query->active()->withoutDripfeed();
            })->with(['services' => function ($query) {
                $query->active()->withoutDripfeed()->with('userServices', function ($userServices) {
                    $userServices->where('user_id',  auth()->id());
                });
            }])
            ->withCount('services')->orderBy('name')->get()->map(function ($category) {
                $minService = $category->services()
                    ->orderBy('price_per_k', 'asc')
                    ->orderBy('min', 'asc')
                    ->first();
                $category->service_min_start = $minService->min;
                $category->price_per_k = $minService->price_per_k;
                return $category;
            });

        $service = Service::active()->with('category')->find($sId);

        if (!auth()->user()) {
            $notify[] = ["error", 'Login is required for order overview!'];
            return to_route('services')->withNotify($notify);
        }
        return view('Template::user.orders.overview', compact('pageTitle', 'categories', 'service'));
    }

    public function order(Request $request, $serviceId = 0)
    {
        $user    = auth()->user();
        $service = Service::with(['category', 'userServices' => function ($userServices) {
            $userServices->where('user_id',  auth()->id());
        }])->active()->findOrFail($serviceId);
        $request->validate([
            'link'     => 'required|url',
            'quantity' => 'required|integer|gte:' . $service->min . '|lte:' . $service->max,
        ]);

        $pricePerK = $service->price_per_k;
        if (@$service->userServices[0]) {
            $pricePerK = $service->userServices[0]->price;
        }
        $price = ($pricePerK / 1000) * $request->quantity;

        if ($user->balance < $price) {
            $notify[] = ["error", 'Insufficient balance. Please deposit and try again'];
            return to_route('user.deposit.index')->withNotify($notify);
        }

        $user->balance -= $price;
        $user->save();

        //Create Transaction
        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $price;
        $transaction->post_balance = $user->balance;
        $transaction->trx_type     = '-';
        $transaction->details      = 'Order for ' . $service->name;
        $transaction->trx          = getTrx();
        $transaction->remark       = 'order';
        $transaction->save();

        //Make order
        $order                  = new Order();
        $order->user_id         = $user->id;
        $order->category_id     = $service->category->id;
        $order->service_id      = $serviceId;
        $order->api_service_id  = $service->api_service_id ?? Status::NO;
        $order->api_provider_id = $service->api_provider_id ?? Status::NO;
        $order->link            = $request->link;
        $order->quantity        = $request->quantity;
        $order->price           = $price;
        $order->remain          = $request->quantity;
        $order->api_order       = $service->api_service_id ? Status::YES : Status::NO;
        $order->save();

        //Create admin notification
        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $user->id;
        $adminNotification->title     = 'New order request for ' . $service->name;
        $adminNotification->click_url = urlPath('admin.orders.details', $order->id);
        $adminNotification->save();

        notify($user, 'PENDING_ORDER', [
            'service_name' => $service->name,
            'category'     => $service->category->name,
            'username'     =>  $user->username,
            'full_name'    => $user->fullname,
            'price'        => $price,
            'post_balance' => getAmount($user->balance),
        ]);

        if ($service->api_provider_id) {
            $apiProvider = ApiProvider::active()->findOrFail($service->api_provider_id);
            $arr = [
                'key'    => $apiProvider->api_key,
                'action' => 'add',
                'service' => $service->api_service_id,
                'link' => $order->link,
                'quantity' => $order->quantity
            ];

            $response = CurlRequest::curlPostContent($apiProvider->api_url, $arr);
            $response = json_decode($response);
            if (!@$response->error) {
                $order->status              = Status::ORDER_PROCESSING;
                $order->order_placed_to_api = Status::YES;
                $order->api_order_id        = $response->order;
                $order->save();
            }
        }

        $notify[] = ['success', 'Successfully placed your order!'];
        return to_route('user.order.details', $order->id)->withNotify($notify);
    }

    public function orderDetails($orderId)
    {
        $pageTitle = "Order Details";
        $order = Order::where('id', $orderId)->with('service', 'category')->firstOrFail();
        return view('Template::user.orders.details', compact('pageTitle', 'order'));
    }

    public function history()
    {
        $pageTitle   = 'Order History';
        $orders      = $this->orderData();
        $categories  = $this->categoryData();
        return view('Template::user.orders.history', compact('pageTitle', 'orders', 'categories'));
    }

    public function pending()
    {
        $pageTitle  = "Pending Orders";
        $orders     = $this->orderData('pending');
        $categories = $this->categoryData();
        return view('Template::user.orders.history', compact('pageTitle', 'orders', 'categories'));
    }

    public function processing()
    {
        $pageTitle  = "Processing Orders";
        $orders     = $this->orderData('processing');
        $categories = $this->categoryData();
        return view('Template::user.orders.history', compact('pageTitle', 'orders', 'categories'));
    }

    public function completed()
    {
        $pageTitle  = "Completed Orders";
        $orders     = $this->orderData('completed');
        $categories = $this->categoryData();
        return view('Template::user.orders.history', compact('pageTitle', 'orders', 'categories'));
    }

    public function cancelled()
    {
        $pageTitle  = "Cancelled Orders";
        $orders     = $this->orderData('cancelled');
        $categories = $this->categoryData();
        return view('Template::user.orders.history', compact('pageTitle', 'orders', 'categories'));
    }

    public function refunded()
    {
        $pageTitle  = "Refunded Orders";
        $orders     = $this->orderData('refunded');
        $categories = $this->categoryData();
        return view('Template::user.orders.history', compact('pageTitle', 'orders', 'categories'));
    }

    protected function categoryData()
    {
        $order       = Order::where('user_id', auth()->id())->get();
        $categoryIds = $order->pluck('category_id')->unique();
        return    Category::active()
            ->whereIn('id', $categoryIds)
            ->whereHas('services', function ($query) {
                $query->active();
            })
            ->orderBy('name')
            ->get();
    }

    protected function orderData($scope = null)
    {
        if ($scope) {
            $orders = Order::$scope();
        } else {
            $orders = Order::query();
        }
        return $orders->directOrder()->where('user_id', auth()->id())->searchable(['id', 'service:name'])->filter(['category_id'])->dateFilter()->with(['category', 'user', 'service'])->orderBy('id', 'desc')->paginate(getPaginate());
    }

    public function massOrder()
    {
        $pageTitle = 'Mass Order';
        return view('Template::user.orders.mass', compact('pageTitle'));
    }

    public function massOrderStore(Request $request)
    {
        if (substr_count($request->mass_order, '|') < 2) {
            $notify[] = ['error', 'Service structures are not correct. Please retype!'];
            return back()->withNotify($notify);
        }

        $separateNewLine = explode(PHP_EOL, $request->mass_order);

        foreach ($separateNewLine as $item) {
            $serviceArray = explode('|', $item);

            //Start Validations
            if (count($serviceArray) != 3) {
                $notify[] = ['error', 'Service structures are not correct. Please retype!'];
                return back()->withNotify($notify)->withInput();
            }

            $service = Service::find($serviceArray[0]);
            if (!$service) {
                $notify[] = ['error', 'Service ID not found!'];
                return back()->withNotify($notify)->withInput();
            }

            if (filter_var($serviceArray[2], FILTER_VALIDATE_INT) == false) {
                $notify[] = ['error', 'Quantity should be an integer value!'];
                return back()->withNotify($notify)->withInput();
            }

            if ($serviceArray[2] < $service->min) {
                $notify[] = ['error', 'Quantity should be greater than or equal to ' . $service->min];
                return back()->withNotify($notify)->withInput();
            }

            if ($serviceArray[2] > $service->max) {
                $notify[] = ['error', 'Quantity should be less than or equal to ' . $service->max];
                return back()->withNotify($notify)->withInput();
            }

            // End validation

            $price = getAmount(($service->price_per_k / 1000) * $serviceArray[2]);
            $user  = auth()->user();

            if ($user->balance < $price) {
                $notify[] = ['error', 'Insufficient balance. Please deposit and try again!'];
                return back()->withNotify($notify);
            }

            $user->balance -= $price;
            $user->save();

            //Make order
            $order              = new Order();
            $order->user_id     = $user->id;
            $order->category_id = $service->category->id;
            $order->service_id  = $service->id;
            $order->link        = $serviceArray[1];
            $order->quantity    = $serviceArray[2];
            $order->price       = $price;
            $order->remain      = $serviceArray[2];
            $order->save();

            //Create Transaction
            $transaction               = new Transaction();
            $transaction->user_id      = $user->id;
            $transaction->amount       = $price;
            $transaction->post_balance = getAmount($user->balance);
            $transaction->trx_type     = '-';
            $transaction->details      = 'Order for ' . $service->name;
            $transaction->trx          = getTrx();
            $transaction->remark       = "Order";
            $transaction->save();

            //Create admin notification
            $adminNotification            = new AdminNotification();
            $adminNotification->user_id   = $user->id;
            $adminNotification->title     = 'New order request for ' . $service->name;
            $adminNotification->click_url = urlPath('admin.orders.details', $order->id);
            $adminNotification->save();

            //Send email to user

            notify($user, 'PENDING_ORDER', [
                'service_name' => $service->name,
                'price'        => $price,
                'currency'     => gs()->cur_text,
                'post_balance' => getAmount($user->balance),
            ]);
        }

        $notify[] = ['success', 'Successfully placed your order!'];
        return back()->withNotify($notify);
    }
}
