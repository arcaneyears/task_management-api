<?php

namespace App\Http\Middleware;

use App\Models\Task;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskOwnerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $taskId = $request->route('task');
        $task = Task::find($taskId);

        if (!$task) {
            return response()->json([
                'message' => 'Task not found',
            ], 404);
        }

        $user = $request->user();

        // Admin имеет полный доступ
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Создатель задачи имеет доступ
        if ($task->created_by === $user->id) {
            return $next($request);
        }

        return response()->json([
            'message' => 'Forbidden. You are not the owner of this task.',
        ], 403);
    }
}
