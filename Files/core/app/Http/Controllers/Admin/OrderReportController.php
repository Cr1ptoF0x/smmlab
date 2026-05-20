<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\ApiProvider;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderReportController extends Controller
{
    public function index()
    {
        $pageTitle = 'SMM Order Statistics';
        $providers =  ApiProvider::active()->orderBy('name')->whereHas('order')->get();
        $orders = Order::whereNotIn('status', [Status::ORDER_CANCELLED, Status::ORDER_REFUNDED])
            ->selectRaw('service_id, COUNT(*) as service_count')
            ->groupBy('service_id')
            ->with('service')
            ->take(10)
            ->orderByDesc('service_count')
            ->get();

        return view('admin.statistics.index', compact('pageTitle', 'providers', 'orders'));
    }

    public function orderStatistics(Request $request)
    {
        $chartData = [];
        $statuses = ['pending', 'processing', 'completed', 'cancelled', 'refunded'];
        $statusData = [];

        if ($request->time == 'month') {
            foreach (getDaysOfMonth() as $day) {
                foreach ($statuses as $status) {
                    $statusData[$status] = Order::{$status}()
                        ->whereYear('created_at', now())
                        ->whereMonth('created_at', now())
                        ->whereDay('created_at', $day)
                        ->selectRaw('DATE(created_at) as date , count(*) as count')
                        ->groupBy('date')
                        ->first()->count ?? 0;
                }
                $chartData[$day] = $statusData;
            }
        }

        if ($request->time == 'week') {
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();

            for ($i = $startOfWeek->copy(); $i <= $endOfWeek; $i->addDay()) {
                $day = Carbon::parse($i)->format('l');
                foreach ($statuses as $status) {
                    $statusData[$status] = Order::{$status}()
                        ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                        ->whereDay('created_at', $i)
                        ->selectRaw('DATE(created_at) as date , count(*) as count')
                        ->groupBy('date')
                        ->first()->count ?? 0;
                }
                $chartData[$day] = $statusData;
            }
        }

        if ($request->time == 'year') {
            foreach ($this->months() as $month) {
                $parsedMonth = Carbon::parse("1 $month");
                foreach ($statuses as $status) {
                    $statusData[$status] = Order::{$status}()
                        ->whereYear('created_at', now())
                        ->whereMonth('created_at', $parsedMonth)
                        ->selectRaw('MONTH(created_at) as month , count(*) as count')
                        ->groupBy('month')
                        ->first()->count ?? 0;
                }
                $chartData[$month] = $statusData;
            }
        }

        return response()->json([
            'chart_data' => $chartData,
            'statuses' => $statuses
        ]);
    }

    private function months()
    {
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = Carbon::create()->month($i)->format('F');
        }
        return $months;
    }

    public function orderStatisticsByAPI(Request $request)
    {
        if ($request->time == 'year') {
            $time = now()->startOfYear();
        } elseif ($request->time == 'month') {
            $time = now()->startOfMonth();
        } elseif ($request->time == 'week') {
            $time = now()->startOfWeek();
        } else {
            $time = null;
        }

        $orderChart = Order::with('provider')
            ->when(isset($time), function ($query) use ($time) {
                return $query->where('created_at', '>=', $time);
            })
            ->groupBy('api_provider_id')
            ->selectRaw("SUM(price) as orderPrice, api_provider_id")
            ->orderBy('orderPrice', 'desc')
            ->get();

        return [
            'order_data'  => $orderChart,
            'total_order' => $orderChart->sum('orderPrice'),
        ];
    }
}
