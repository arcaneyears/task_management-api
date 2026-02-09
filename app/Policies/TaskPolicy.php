<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isManager();
    }

    public function view(User $user, Task $task): bool
    {
        return $user->isAdmin() || $task->isOwnedBy($user) || $task->isAssignedTo($user);
    }

    public function update(User $user, Task $task): bool
    {
        if ($user->isAdmin() || $task->isOwnedBy($user)) {
            return true;
        }
        if ($task->isAssignedTo($user)) {
            return true;
        }
        return false;
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->isAdmin() || $task->isOwnedBy($user);
    }
}
