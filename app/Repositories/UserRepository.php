<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository
{
    protected function getModel(): Model
    {
        return new User();
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    public function getActiveUsers()
    {
        $this->query->where('status', 'active');
        return $this;
    }

    public function getByRole(string $role)
    {
        $this->query->whereHas('role', function ($query) use ($role) {
            $query->where('slug', $role);
        });
        return $this;
    }
}
