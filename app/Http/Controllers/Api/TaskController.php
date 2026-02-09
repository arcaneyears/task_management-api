<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService) {}

    public function index(Request $request): JsonResponse
    {
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $tasks = $this->taskService->getAllTasks($request->all(), $sortBy, $sortDirection);
        return response()->json(TaskResource::collection($tasks)->response()->getData());
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $this->authorize('create', \App\Models\Task::class);
        $data = array_merge($request->validated(), ['created_by' => $request->user()->id]);
        $task = $this->taskService->createTask($data);
        return response()->json(['message' => 'Task created', 'data' => new TaskResource($task)], 201);
    }

    public function show(int $id): JsonResponse
    {
        $task = $this->taskService->getTaskById($id);
        $this->authorize('view', $task);
        return response()->json(['data' => new TaskResource($task)]);
    }

    public function update(UpdateTaskRequest $request, int $id): JsonResponse
    {
        $task = $this->taskService->getTaskById($id);
        $this->authorize('update', $task);
        $this->taskService->updateTask($id, $request->validated());
        return response()->json(['message' => 'Task updated']);
    }

    public function destroy(int $id): JsonResponse
    {
        $task = $this->taskService->getTaskById($id);
        $this->authorize('delete', $task);
        $this->taskService->deleteTask($id);
        return response()->json(['message' => 'Task deleted']);
    }
}
