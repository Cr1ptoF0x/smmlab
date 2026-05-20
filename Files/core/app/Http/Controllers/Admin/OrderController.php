<?php

namespace App\Http\Controllers\Admin;

use App\Lib\SMM;
use App\Models\Order;
use App\Models\Category;
use App\Constants\Status;
use App\Models\ApiProvider;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rules\FileTypeValidate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class OrderController extends Controller
{
    public function index()
    {
        $pageTitle = "All Orders";
        $categories = Category::active()->orderBy('name')->get();
        $apiLists   = ApiProvider::active()->get();
        $orders    = $this->orderData(null, true);
        return view('admin.order.index', compact('pageTitle', 'orders', 'categories', 'apiLists'));
    }

    public function pending()
    {
        $pageTitle = "Pending Orders";
        $orders    = $this->orderData('pending');
        $scope = 'pending';
        return view('admin.order.index', compact('pageTitle', 'orders', 'scope'));
    }

    public function processing()
    {
        $pageTitle = "Processing Orders";
        $orders    = $this->orderData('processing');
        $scope = 'processing';
        return view('admin.order.index', compact('pageTitle', 'orders', 'scope'));
    }

    public function completed()
    {
        $pageTitle = "Completed Orders";
        $orders    = $this->orderData('completed');
        $scope = 'completed';
        return view('admin.order.index', compact('pageTitle', 'orders', 'scope'));
    }

    public function cancelled()
    {
        $pageTitle = "Cancelled Orders";
        $orders    = $this->orderData('cancelled');
        $scope = 'cancelled';
        return view('admin.order.index', compact('pageTitle', 'orders', 'scope'));
    }

    public function refunded()
    {
        $pageTitle = "Refunded Orders";
        $orders    = $this->orderData('refunded');
        $scope = 'refunded';
        return view('admin.order.index', compact('pageTitle', 'orders', 'scope'));
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

        $orders = $orders->directOrder()->with(['category', 'user', 'service'])->orderBy('id', 'desc');

        if (request()->routeIs('admin.orders.export')) {
            return $orders;
        }

        return $orders->paginate(getPaginate());

    }

    public function details($id)
    {
        $pageTitle = 'Order Details';
        $order     = Order::directOrder()->findOrFail($id);
        return view('admin.order.details', compact('pageTitle', 'order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::with('user', 'category')->findOrFail($id);

        $request->validate([
            'start_count' => 'required|integer|gte:0|lte:' . $order->quantity,
            'status'      => 'required|integer|in:0,1,2,3,4',
        ]);
        $order->start_counter = $request->start_count;
        $order->remain        = ($order->quantity - $request->start_count);
        $user                 = $order->user;

        if ($request->status == Status::ORDER_PROCESSING) {
            $order->status = Status::ORDER_PROCESSING;
            $order->save();

            notify($user, 'PROCESSING_ORDER', [
                'service_name'  => $order->service->name,
                'username' => $order->user->username,
                'price' => $order->price,
                'full_name' => $order->user->fullname,
                'category' => $order->category->name

            ]);
        }

        //Complete Order
        if ($request->status == Status::ORDER_COMPLETED) {
            $order->status = Status::ORDER_COMPLETED;
            $order->save();
            //Send email to user
            notify($user, 'COMPLETED_ORDER', [
                'service_name' => $order->service->name,
                'username' => $order->user->username,
                'price' => $order->price,
                'full_name' => $order->user->fullname,
                'category' =>  $order->category->name
            ]);
        }

        //Cancelled
        if ($request->status == Status::ORDER_CANCELLED) {
            $order->status = Status::ORDER_CANCELLED;
            $order->save();

            //Send email to user
            notify($user, 'CANCELLED_ORDER', [
                'service_name' => $order->service->name,
                'username' => $order->user->username,
                'full_name' => $order->user->fullname,
                'price' => $order->price,
                'category' => $order->category->name
            ]);
        }

        //Refunded
        if ($request->status == Status::ORDER_REFUNDED) {
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
        $notify[] = ['success', 'Order successfully updated'];
        return back()->withNotify($notify);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'ids'  => 'required',
            'type' => 'required|in:processing,completed,cancel',
        ]);

        $ids = explode(",", $request->ids);
        $orders = Order::with('user', 'service', 'category')->whereIn('id', $ids)->get();

        $updatedCount = 0;

        foreach ($orders as $order) {

            if (in_array($order->status, [Status::ORDER_COMPLETED, Status::ORDER_CANCELLED, Status::ORDER_REFUNDED])) {
                continue;
            }

            $user = $order->user;
            $updatedCount++;

            if ($request->type == 'processing') {
                $order->status = Status::ORDER_PROCESSING;

                notify($user, 'PROCESSING_ORDER', [
                    'service_name' => $order->service->name,
                    'username'     => $user->username,
                    'price'        => $order->price,
                    'full_name'    => $user->fullname,
                    'category'     => $order->category->name
                ]);
            }

            if ($request->type == 'completed') {
                $order->status = Status::ORDER_COMPLETED;

                notify($user, 'COMPLETED_ORDER', [
                    'service_name' => $order->service->name,
                    'username'     => $user->username,
                    'price'        => $order->price,
                    'full_name'    => $user->fullname,
                    'category'     => $order->category->name
                ]);
            }

            if ($request->type == 'cancel') {
                $order->status = Status::ORDER_CANCELLED;

                notify($user, 'CANCELLED_ORDER', [
                    'service_name' => $order->service->name,
                    'username'     => $user->username,
                    'full_name'    => $user->fullname,
                    'price'        => $order->price,
                    'category'     => $order->category->name
                ]);
            }

            $order->save();
        }

        $actionMsg = match ($request->type) {
            'processing' => 'set to processing',
            'completed' => 'completed',
            'cancel' => 'cancelled',
        };

        $notify[] = ['success', $updatedCount . ' orders successfully ' . $actionMsg];
        return back()->withNotify($notify);
    }

    public function apiOrder()
    {
        $pageTitle = 'Orders To Provider';
        $orders = Order::directOrder()
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
        $notify = SMM::placeOrderToProvider('directOrder');

        $notify[] = ['success', 'Selected orders placed to the API provider successfully'];
        return back()->withNotify($notify);
    }

    public function providerInformationUpdate()
    {
        SMM::providerInformationUpdate();

        $notify[] = ['success', 'Provider information updated successfully'];
        return back()->withNotify($notify);
    }

    public function export(Request $request, $scope = null)
    {

        $request->validate([
            'export_type' => 'required|in:all,limit',
            'limit' => [
                'required_if:export_type,limit',
                'nullable',
                'integer',
                'gt:0',
            ],
        ]);

        $limit = $request->limit;
        $query = $this->orderData($scope, true);

        if ($request->export_type === 'limit' && is_numeric($limit) && $limit > 0) {
            $orders = $query->limit($limit)->get();
        } else {
            $orders = $query->get();
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray([
            'Order Id',
            'User',
            'Service',
            'Quantity',
            'Start Counter',
            'Remain'
        ], null, 'A1');

        $row = 2;
        foreach ($orders as $order) {
            $user = optional($order->user);
            $service = optional($order->service);
            $provider = optional($service->provider);

            $sheet->fromArray([
                $order->id,
                $user->fullname . ' (@' . $user->username . ')',
                $service->name . ($provider->short_name ? ' (' . $provider->short_name . ')' : ''),
                $order->quantity,
                $order->start_counter == 0 ? '0' : $order->start_counter,
                $order->remain
            ], null, "A{$row}");

            $sheet->setCellValue("F{$row}", "=IF(D{$row}-E{$row}=0, 0, D{$row}-E{$row})");

            $row++;
        }

        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $filename = 'orders_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Cache-Control' => 'max-age=0',
        ];

        ob_start();
        $writer->save('php://output');
        $content = ob_get_clean();

        return response($content, 200, $headers);
    }


    public function import(Request $request)
    {
        $request->validate(
            [
                'file' => ['required', 'file', new FileTypeValidate(['xlsx'])],
            ]
        );

        $file = $request->file('file');

        try {
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet       = $spreadsheet->getActiveSheet();
            $rows        = $sheet->toArray();

            unset($rows[0]);

            foreach ($rows as $row) {
                $orderId = $row[0] ?? null;
                $quantity = $row[3] ?? null;
                $startCounter = $row[4] ?? null;
                $remain = $row[5] ?? null;

                if ($orderId && is_numeric($quantity)) {
                    if (!is_null($remain) && is_numeric($remain)) {
                        $startCounter = $quantity - $remain;
                    } elseif (!is_null($startCounter) && is_numeric($startCounter)) {
                        $remain = $quantity - $startCounter;
                    }

                    $order = Order::with('user', 'service', 'category')->findOrFail($orderId);
                    $order->start_counter = $startCounter;
                    $order->remain = $remain;

                    if($remain == 0 ){
                        $order->status = Status::ORDER_COMPLETED;

                        $user = $order->user;

                        notify($user, 'COMPLETED_ORDER', [
                            'service_name' => $order->service->name,
                            'username'     => $order->user->username,
                            'price'        => $order->price,
                            'full_name'    => $order->user->fullname,
                            'category'     =>  $order->category->name
                        ]);
                    }

                    $order->save();

                }
            }

            $notify[] = ['success', 'Orders updated successfully'];
            return back()->withNotify($notify);
        } catch (\Exception $e) {
            $notify[] = ['error', 'Failed to import orders: ' . $e->getMessage()];
            return back()->withNotify($notify);
        }
    }

}
