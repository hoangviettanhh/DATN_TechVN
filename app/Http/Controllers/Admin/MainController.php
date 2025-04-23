<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\StatisticsService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    public function index(Request $request)
    {
        $year = $request->input('year', now()->year);
        $availableYears = $this->statisticsService->getAvailableYears();

        $revenueChart = $this->statisticsService->getRevenueChartData($year);
        $cancelledChart = $this->statisticsService->getCancelledChartData($year);
        $pendingChart = $this->statisticsService->getPendingChartData();

        return view('admin.dashboard', compact(
            'year',
            'availableYears',
            'revenueChart',
            'cancelledChart',
            'pendingChart'
        ));
    }
} 