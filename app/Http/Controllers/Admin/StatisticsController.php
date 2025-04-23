<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\StatisticsService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RevenueExport;

class StatisticsController extends Controller
{
    protected $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    public function revenue(Request $request)
    {
        $year = $request->input('year', now()->year);
        $availableYears = $this->statisticsService->getAvailableYears();
        $data = $this->statisticsService->getMonthlyRevenue($year);
        
        return view('admin.statistics.revenue', compact('data', 'availableYears'));
    }

    public function exportRevenue(Request $request)
    {
        $year = $request->input('year', now()->year);
        $data = $this->statisticsService->getMonthlyRevenue($year);
        
        return Excel::download(new RevenueExport($data), "doanh-so-{$year}.xlsx");
    }
} 