<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isManager();
    }

    public function update(User $user, Project $project): bool
    {
        return $user->isAdmin() || $project->isOwnedBy($user);
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->isAdmin() || $project->isOwnedBy($user);
    }
}
