<?php

namespace App\Services;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticsService
{
    /**
     * Lấy doanh số theo tháng
     *
     * @param int|null $year Năm cần thống kê, mặc định là năm hiện tại
     * @return array
     */
    public function getMonthlyRevenue(?int $year = null): array
    {
        $year = $year ?? Carbon::now()->year;

        $monthlyRevenue = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total_orders'),
            DB::raw('SUM(total_amount) as revenue')
        )
        ->whereYear('created_at', $year)
        ->whereHas('orderStatus', function($query) {
            $query->where('name', 'Success');
        })
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy('month')
        ->get();

        // Chuẩn bị dữ liệu cho cả 12 tháng
        $result = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthData = $monthlyRevenue->firstWhere('month', $i);
            $result[] = [
                'month' => $i,
                'month_name' => Carbon::create()->month($i)->format('F'),
                'total_orders' => $monthData ? $monthData->total_orders : 0,
                'revenue' => $monthData ? $monthData->revenue : 0,
                'revenue_formatted' => $monthData ? number_format($monthData->revenue, 0, ',', '.') . 'đ' : '0đ'
            ];
        }

        return [
            'year' => $year,
            'total_revenue' => $monthlyRevenue->sum('revenue'),
            'total_revenue_formatted' => number_format($monthlyRevenue->sum('revenue'), 0, ',', '.') . 'đ',
            'total_orders' => $monthlyRevenue->sum('total_orders'),
            'monthly_data' => $result
        ];
    }

    /**
     * Lấy số đơn hàng bị hủy theo tháng
     */
    public function getMonthlyCancelledOrders(?int $year = null): array
    {
        $year = $year ?? Carbon::now()->year;

        $monthlyCancelled = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total_orders')
        )
        ->whereYear('created_at', $year)
        ->whereHas('orderStatus', function($query) {
            $query->where('name', 'Cancelled');
        })
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy('month')
        ->get();

        $result = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthData = $monthlyCancelled->firstWhere('month', $i);
            $result[] = [
                'month' => $i,
                'month_name' => Carbon::create()->month($i)->format('F'),
                'total_orders' => $monthData ? $monthData->total_orders : 0
            ];
        }

        return [
            'year' => $year,
            'total_cancelled' => $monthlyCancelled->sum('total_orders'),
            'monthly_data' => $result
        ];
    }

    /**
     * Lấy số đơn hàng pending trong ngày
     */
    public function getDailyPendingOrders(): array
    {
        $today = Carbon::today();
        
        $pendingOrders = Order::select(
            DB::raw('HOUR(created_at) as hour'),
            DB::raw('COUNT(*) as total_orders')
        )
        ->whereDate('created_at', $today)
        ->whereHas('orderStatus', function($query) {
            $query->where('name', 'Pending');
        })
        ->groupBy(DB::raw('HOUR(created_at)'))
        ->orderBy('hour')
        ->get();

        $result = [];
        for ($i = 0; $i < 24; $i++) {
            $hourData = $pendingOrders->firstWhere('hour', $i);
            $result[] = [
                'hour' => $i,
                'hour_label' => sprintf('%02d:00', $i),
                'total_orders' => $hourData ? $hourData->total_orders : 0
            ];
        }

        return [
            'date' => $today->format('Y-m-d'),
            'total_pending' => $pendingOrders->sum('total_orders'),
            'hourly_data' => $result
        ];
    }

    /**
     * Lấy dữ liệu cho biểu đồ doanh số
     */
    public function getRevenueChartData(?int $year = null): array
    {
        $data = $this->getMonthlyRevenue($year);
        
        return [
            'labels' => array_map(fn($item) => $item['month_name'], $data['monthly_data']),
            'datasets' => [
                [
                    'label' => 'Doanh số',
                    'data' => array_map(fn($item) => $item['revenue'], $data['monthly_data']),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1
                ]
            ]
        ];
    }

    /**
     * Lấy dữ liệu cho biểu đồ đơn hàng hủy
     */
    public function getCancelledChartData(?int $year = null): array
    {
        $data = $this->getMonthlyCancelledOrders($year);
        
        return [
            'labels' => array_map(fn($item) => $item['month_name'], $data['monthly_data']),
            'datasets' => [
                [
                    'label' => 'Đơn hàng hủy',
                    'data' => array_map(fn($item) => $item['total_orders'], $data['monthly_data']),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1
                ]
            ]
        ];
    }

    /**
     * Lấy dữ liệu cho biểu đồ đơn hàng pending
     */
    public function getPendingChartData(): array
    {
        $data = $this->getDailyPendingOrders();
        
        return [
            'labels' => array_map(fn($item) => $item['hour_label'], $data['hourly_data']),
            'datasets' => [
                [
                    'label' => 'Đơn hàng chờ xử lý',
                    'data' => array_map(fn($item) => $item['total_orders'], $data['hourly_data']),
                    'backgroundColor' => 'rgba(255, 206, 86, 0.2)',
                    'borderColor' => 'rgba(255, 206, 86, 1)',
                    'borderWidth' => 1
                ]
            ]
        ];
    }

    /**
     * Lấy danh sách các năm có dữ liệu
     *
     * @return array
     */
    public function getAvailableYears(): array
    {
        return Order::select(DB::raw('YEAR(created_at) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();
    }
} 