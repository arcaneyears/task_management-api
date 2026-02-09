<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(protected ProjectService $projectService) {}

    public function index(Request $request): JsonResponse
    {
        $projects = $this->projectService->getAllProjects($request->all());
        return response()->json(ProjectResource::collection($projects)->response()->getData());
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        $this->authorize('create', \App\Models\Project::class);
        $data = array_merge($request->validated(), ['created_by' => $request->user()->id]);
        $project = $this->projectService->createProject($data);
        return response()->json(['message' => 'Project created', 'data' => new ProjectResource($project)], 201);
    }

    public function show(int $id): JsonResponse
    {
        $project = $this->projectService->getProjectById($id);
        return response()->json(['data' => new ProjectResource($project)]);
    }

    public function update(UpdateProjectRequest $request, int $id): JsonResponse
    {
        $project = $this->projectService->getProjectById($id);
        $this->authorize('update', $project);
        $this->projectService->updateProject($id, $request->validated());
        return response()->json(['message' => 'Project updated']);
    }

    public function destroy(int $id): JsonResponse
    {
        $project = $this->projectService->getProjectById($id);
        $this->authorize('delete', $project);
        $this->projectService->deleteProject($id);
        return response()->json(['message' => 'Project deleted']);
    }
}
