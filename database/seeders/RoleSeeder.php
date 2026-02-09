<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'slug' => 'admin',
                'name' => 'Administrator',
                'permissions' => [
                    'users.view',
                    'users.create',
                    'users.update',
                    'users.delete',
                    'projects.view',
                    'projects.create',
                    'projects.update',
                    'projects.delete',
                    'tasks.view',
                    'tasks.create',
                    'tasks.update',
                    'tasks.delete',
                    'statistics.view',
                ],
                'is_active' => true,
            ],
            [
                'slug' => 'manager',
                'name' => 'Manager',
                'permissions' => [
                    'users.view',
                    'projects.view',
                    'projects.create',
                    'projects.update',
                    'tasks.view',
                    'tasks.create',
                    'tasks.update',
                    'tasks.delete',
                    'statistics.view',
                ],
                'is_active' => true,
            ],
            [
                'slug' => 'user',
                'name' => 'User',
                'permissions' => [
                    'tasks.view',
                    'tasks.update',
                ],
                'is_active' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
