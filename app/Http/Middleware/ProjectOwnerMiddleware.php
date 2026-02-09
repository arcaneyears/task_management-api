<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectOwnerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $projectId = $request->route('project');
        $project = Project::find($projectId);

        if (!$project) {
            return response()->json([
                'message' => 'Project not found',
            ], 404);
        }

        $user = $request->user();

        // Admin имеет полный доступ
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Создатель проекта имеет доступ
        if ($project->created_by === $user->id) {
            return $next($request);
        }

        return response()->json([
            'message' => 'Forbidden. You are not the owner of this project.',
        ], 403);
    }
}
