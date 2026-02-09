<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Roles
        $adminRole = Role::create([
            'slug' => 'admin',
            'name' => 'Administrator',
            'permissions' => ['all'],
            'is_active' => true,
        ]);

        $managerRole = Role::create([
            'slug' => 'manager',
            'name' => 'Manager',
            'permissions' => ['create_projects', 'manage_tasks'],
            'is_active' => true,
        ]);

        $userRole = Role::create([
            'slug' => 'user',
            'name' => 'User',
            'permissions' => ['view_tasks', 'update_own_tasks'],
            'is_active' => true,
        ]);

        // Create Admin
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'status' => 'active',
            'phone' => '+1234567890',
        ]);

        // Create Managers
        $manager1 = User::create([
            'first_name' => 'John',
            'last_name' => 'Manager',
            'email' => 'manager1@example.com',
            'password' => Hash::make('password'),
            'role_id' => $managerRole->id,
            'status' => 'active',
            'phone' => '+1234567891',
        ]);

        $manager2 = User::create([
            'first_name' => 'Jane',
            'last_name' => 'Manager',
            'email' => 'manager2@example.com',
            'password' => Hash::make('password'),
            'role_id' => $managerRole->id,
            'status' => 'active',
            'phone' => '+1234567892',
        ]);

        // Create Users
        $users = [];
        for ($i = 1; $i <= 5; $i++) {
            $users[] = User::create([
                'first_name' => "User{$i}",
                'last_name' => "Test",
                'email' => "user{$i}@example.com",
                'password' => Hash::make('password'),
                'role_id' => $userRole->id,
                'status' => 'active',
                'phone' => "+123456789{$i}",
            ]);
        }

        // Create Projects
        $projects = [];
        for ($i = 1; $i <= 3; $i++) {
            $projects[] = Project::create([
                'name' => "Project {$i}",
                'description' => "Description for project {$i}",
                'status' => ['active', 'completed', 'archived'][array_rand(['active', 'completed', 'archived'])],
                'created_by' => $i === 1 ? $manager1->id : $manager2->id,
            ]);
        }

        // Create Tasks
        $statuses = ['pending', 'in_progress', 'completed'];
        $priorities = ['low', 'medium', 'high'];

        for ($i = 1; $i <= 20; $i++) {
            Task::create([
                'title' => "Task {$i}",
                'description' => "Description for task {$i}",
                'status' => $statuses[array_rand($statuses)],
                'priority' => $priorities[array_rand($priorities)],
                'project_id' => $projects[array_rand($projects)]->id,
                'assigned_to' => $users[array_rand($users)]->id,
                'created_by' => [$manager1->id, $manager2->id, $admin->id][array_rand([$manager1->id, $manager2->id, $admin->id])],
                'due_date' => now()->addDays(rand(1, 30)),
            ]);
        }
    }
}
