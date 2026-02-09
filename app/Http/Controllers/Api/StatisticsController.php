<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StatisticsService;
use Illuminate\Http\JsonResponse;

class StatisticsController extends Controller
{
    public function __construct(protected StatisticsService $statisticsService) {}

    public function index(): JsonResponse
    {
        $statistics = $this->statisticsService->getDashboardStatistics();
        return response()->json(['data' => $statistics]);
    }
}
