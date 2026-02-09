<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TaskRepository extends BaseRepository
{
    protected function getModel(): Model
    {
        return new Task();
    }

    public function getByStatus(string $status)
    {
        $this->query->where('status', $status);
        return $this;
    }

    public function getByPriority(string $priority)
    {
        $this->query->where('priority', $priority);
        return $this;
    }

    public function getByProject(int $projectId)
    {
        $this->query->where('project_id', $projectId);
        return $this;
    }

    public function getByAssignee(int $userId)
    {
        $this->query->where('assigned_to', $userId);
        return $this;
    }

    public function getByCreator(int $userId)
    {
        $this->query->where('created_by', $userId);
        return $this;
    }

    public function getOverdue()
    {
        $this->query->where('due_date', '<', now())
            ->where('status', '!=', 'completed');
        return $this;
    }

    public function withRelations()
    {
        $this->query->with(['project', 'assignedUser', 'creator']);
        return $this;
    }

    public function applyFilters(array $filters)
    {
        if (isset($filters['status'])) {
            $this->query->where('status', $filters['status']);
        }

        if (isset($filters['priority'])) {
            $this->query->where('priority', $filters['priority']);
        }

        if (isset($filters['project_id'])) {
            $this->query->where('project_id', $filters['project_id']);
        }

        if (isset($filters['assigned_to'])) {
            $this->query->where('assigned_to', $filters['assigned_to']);
        }

        if (isset($filters['created_by'])) {
            $this->query->where('created_by', $filters['created_by']);
        }

        return $this;
    }

    public function applySorting(string $sortBy, string $sortDirection = 'asc')
    {
        $allowedSorts = ['created_at', 'due_date', 'priority', 'status'];
        
        if (in_array($sortBy, $allowedSorts)) {
            $this->query->orderBy($sortBy, $sortDirection);
        }

        return $this;
    }

    public function getStatistics(): array
    {
        return [
            'total' => $this->model->count(),
            'by_status' => $this->model->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray(),
            'overdue' => $this->model->where('due_date', '<', now())
                ->where('status', '!=', 'completed')
                ->count(),
        ];
    }

    public function getTopCreators(int $limit = 5): array
    {
        return $this->model->select('created_by', DB::raw('count(*) as tasks_count'))
            ->with('creator:id,first_name,last_name,email')
            ->groupBy('created_by')
            ->orderByDesc('tasks_count')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
