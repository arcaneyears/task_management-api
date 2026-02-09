<?php

namespace App\Services;

use App\Jobs\SendTaskAssignedNotification;
use App\Jobs\SendTaskStatusChangedNotification;
use App\Models\Task;
use App\Repositories\TaskRepository;

class TaskService
{
    public function __construct(
        protected TaskRepository $taskRepository
    ) {}

    public function getAllTasks(array $filters = [], string $sortBy = 'created_at', string $sortDirection = 'desc')
    {
        $query = $this->taskRepository
            ->withRelations()
            ->applyFilters($filters)
            ->applySorting($sortBy, $sortDirection);

        return $query->paginate(15);
    }

    public function getTaskById(int $id): ?Task
    {
        return $this->taskRepository
            ->withRelations()
            ->find($id);
    }

    public function createTask(array $data): Task
    {
        $task = $this->taskRepository->create($data);

        if (isset($data['assigned_to']) && $data['assigned_to']) {
            $task->load('assignedUser', 'project');
            SendTaskAssignedNotification::dispatch($task);
        }

        return $task;
    }

    public function updateTask(int $id, array $data): bool
    {
        $task = $this->taskRepository->find($id);
        $oldStatus = $task->status;
        $oldAssignee = $task->assigned_to;
        
        $updated = $this->taskRepository->update($id, $data);

        if ($updated) {
            $task->refresh();

            if (isset($data['status']) && $data['status'] !== $oldStatus) {
                $task->load('assignedUser', 'project');
                SendTaskStatusChangedNotification::dispatch($task, $oldStatus);
            }

            if (isset($data['assigned_to']) && $data['assigned_to'] !== $oldAssignee) {
                $task->load('assignedUser', 'project');
                SendTaskAssignedNotification::dispatch($task);
            }
        }

        return $updated;
    }

    public function deleteTask(int $id): bool
    {
        return $this->taskRepository->delete($id);
    }
}
