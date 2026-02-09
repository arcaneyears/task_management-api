<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\TaskRepository;

class StatisticsService
{
    public function __construct(
        protected TaskRepository $taskRepository
    ) {}

    public function getDashboardStatistics(): array
    {
        $taskStats = $this->taskRepository->getStatistics();
        $topCreators = $this->taskRepository->getTopCreators(5);

        return [
            'projects' => [
                'total' => Project::count(),
                'by_status' => Project::selectRaw('status, count(*) as count')
                    ->groupBy('status')
                    ->pluck('count', 'status')
                    ->toArray(),
            ],
            'tasks' => [
                'total' => $taskStats['total'],
                'by_status' => $taskStats['by_status'],
                'overdue' => $taskStats['overdue'],
            ],
            'top_creators' => $topCreators,
        ];
    }
}
