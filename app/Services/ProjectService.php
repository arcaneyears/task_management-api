<?php

namespace App\Services;

use App\Jobs\SendProjectStatusChangedNotification;
use App\Models\Project;
use App\Repositories\ProjectRepository;

class ProjectService
{
    public function __construct(
        protected ProjectRepository $projectRepository
    ) {}

    public function getAllProjects(array $filters = [])
    {
        $query = $this->projectRepository->withCreator();

        if (isset($filters['status'])) {
            $query = $query->getByStatus($filters['status']);
        }

        return $query->paginate(15);
    }

    public function getProjectById(int $id): ?Project
    {
        return $this->projectRepository
            ->withCreator()
            ->withTasks()
            ->find($id);
    }

    public function createProject(array $data): Project
    {
        return $this->projectRepository->create($data);
    }

    public function updateProject(int $id, array $data): bool
    {
        $project = $this->projectRepository->find($id);
        $oldStatus = $project->status;
        
        $updated = $this->projectRepository->update($id, $data);

        if ($updated && isset($data['status']) && $data['status'] !== $oldStatus) {
            $project->refresh();
            SendProjectStatusChangedNotification::dispatch($project, $oldStatus);
        }

        return $updated;
    }

    public function deleteProject(int $id): bool
    {
        return $this->projectRepository->delete($id);
    }
}
