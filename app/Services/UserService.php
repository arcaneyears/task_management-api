<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    public function getAllUsers(array $filters = [])
    {
        $query = $this->userRepository;

        if (isset($filters['role'])) {
            $query = $query->getByRole($filters['role']);
        }

        if (isset($filters['status'])) {
            $query = $query->where('status', $filters['status']);
        }

        return $query->paginate(15);
    }

    public function getUserById(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function updateUser(int $id, array $data): bool
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        if (isset($data['avatar']) && $data['avatar']) {
            $user = $this->userRepository->find($id);
            
            if ($user && $user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $data['avatar'] = $data['avatar']->store('avatars', 'public');
        }

        return $this->userRepository->update($id, $data);
    }

    public function deleteUser(int $id): bool
    {
        $user = $this->userRepository->find($id);
        
        if ($user && $user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        return $this->userRepository->delete($id);
    }
}
