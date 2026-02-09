<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;

class ProjectRepository extends BaseRepository
{
    protected function getModel(): Model
    {
        return new Project();
    }

    public function getByStatus(string $status)
    {
        $this->query->where('status', $status);
        return $this;
    }

    public function getByCreator(int $userId)
    {
        $this->query->where('created_by', $userId);
        return $this;
    }

    public function withTasks()
    {
        $this->query->with('tasks');
        return $this;
    }

    public function withCreator()
    {
        $this->query->with('creator');
        return $this;
    }
}
