<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();
        $users = User::whereHas('role', function ($query) {
            $query->where('slug', 'user');
        })->get();
        
        $managers = User::whereHas('role', function ($query) {
            $query->whereIn('slug', ['admin', 'manager']);
        })->get();

        $tasks = [
            // Проект 1
            [
                'title' => 'Design Homepage Mockup',
                'description' => 'Create wireframes and mockups for the new homepage',
                'status' => 'completed',
                'priority' => 'high',
                'project_id' => $projects[0]->id,
                'assigned_to' => $users[0]->id,
                'created_by' => $managers[0]->id,
                'due_date' => now()->subDays(5),
            ],
            [
                'title' => 'Develop Header Component',
                'description' => 'Implement responsive header with navigation',
                'status' => 'in_progress',
                'priority' => 'high',
                'project_id' => $projects[0]->id,
                'assigned_to' => $users[1]->id,
                'created_by' => $managers[0]->id,
                'due_date' => now()->addDays(3),
            ],
            [
                'title' => 'Write Content for About Page',
                'description' => 'Create compelling copy for the about us section',
                'status' => 'pending',
                'priority' => 'medium',
                'project_id' => $projects[0]->id,
                'assigned_to' => $users[2]->id,
                'created_by' => $managers[0]->id,
                'due_date' => now()->addDays(7),
            ],
            [
                'title' => 'Optimize Images',
                'description' => 'Compress and optimize all website images',
                'status' => 'pending',
                'priority' => 'low',
                'project_id' => $projects[0]->id,
                'assigned_to' => $users[3]->id,
                'created_by' => $managers[0]->id,
                'due_date' => now()->addDays(10),
            ],
            [
                'title' => 'Setup SEO Meta Tags',
                'description' => 'Add proper meta tags for search engine optimization',
                'status' => 'in_progress',
                'priority' => 'medium',
                'project_id' => $projects[0]->id,
                'assigned_to' => $users[4]->id,
                'created_by' => $managers[0]->id,
                'due_date' => now()->addDays(5),
            ],
            [
                'title' => 'Test Cross-browser Compatibility',
                'description' => 'Test website on Chrome, Firefox, Safari, and Edge',
                'status' => 'pending',
                'priority' => 'high',
                'project_id' => $projects[0]->id,
                'assigned_to' => $users[0]->id,
                'created_by' => $managers[0]->id,
                'due_date' => now()->addDays(14),
            ],
            
            // Проект 2
            [
                'title' => 'Design App UI/UX',
                'description' => 'Create user interface designs for mobile app',
                'status' => 'completed',
                'priority' => 'high',
                'project_id' => $projects[1]->id,
                'assigned_to' => $users[1]->id,
                'created_by' => $managers[1]->id,
                'due_date' => now()->subDays(10),
            ],
            [
                'title' => 'Implement User Authentication',
                'description' => 'Add login and registration functionality',
                'status' => 'in_progress',
                'priority' => 'high',
                'project_id' => $projects[1]->id,
                'assigned_to' => $users[2]->id,
                'created_by' => $managers[1]->id,
                'due_date' => now()->addDays(5),
            ],
            [
                'title' => 'Develop Push Notifications',
                'description' => 'Implement push notification system for both platforms',
                'status' => 'pending',
                'priority' => 'medium',
                'project_id' => $projects[1]->id,
                'assigned_to' => $users[3]->id,
                'created_by' => $managers[1]->id,
                'due_date' => now()->addDays(12),
            ],
            [
                'title' => 'Create API Integration',
                'description' => 'Integrate mobile app with backend API',
                'status' => 'in_progress',
                'priority' => 'high',
                'project_id' => $projects[1]->id,
                'assigned_to' => $users[4]->id,
                'created_by' => $managers[1]->id,
                'due_date' => now()->addDays(8),
            ],
            [
                'title' => 'Write Unit Tests',
                'description' => 'Create comprehensive unit tests for app components',
                'status' => 'pending',
                'priority' => 'medium',
                'project_id' => $projects[1]->id,
                'assigned_to' => $users[0]->id,
                'created_by' => $managers[1]->id,
                'due_date' => now()->addDays(15),
            ],
            [
                'title' => 'Setup Analytics Tracking',
                'description' => 'Implement Google Analytics and Firebase tracking',
                'status' => 'pending',
                'priority' => 'low',
                'project_id' => $projects[1]->id,
                'assigned_to' => $users[1]->id,
                'created_by' => $managers[1]->id,
                'due_date' => now()->addDays(20),
            ],
            [
                'title' => 'Optimize App Performance',
                'description' => 'Improve app loading time and responsiveness',
                'status' => 'pending',
                'priority' => 'medium',
                'project_id' => $projects[1]->id,
                'assigned_to' => $users[2]->id,
                'created_by' => $managers[1]->id,
                'due_date' => now()->addDays(18),
            ],
            
            // Проект 3
            [
                'title' => 'Backup Existing Database',
                'description' => 'Create full backup of MySQL database',
                'status' => 'completed',
                'priority' => 'high',
                'project_id' => $projects[2]->id,
                'assigned_to' => $users[3]->id,
                'created_by' => $managers[2]->id,
                'due_date' => now()->subDays(30),
            ],
            [
                'title' => 'Setup PostgreSQL Server',
                'description' => 'Install and configure PostgreSQL server',
                'status' => 'completed',
                'priority' => 'high',
                'project_id' => $projects[2]->id,
                'assigned_to' => $users[4]->id,
                'created_by' => $managers[2]->id,
                'due_date' => now()->subDays(25),
            ],
            [
                'title' => 'Migrate Data',
                'description' => 'Transfer all data from MySQL to PostgreSQL',
                'status' => 'completed',
                'priority' => 'high',
                'project_id' => $projects[2]->id,
                'assigned_to' => $users[0]->id,
                'created_by' => $managers[2]->id,
                'due_date' => now()->subDays(20),
            ],
            [
                'title' => 'Update Application Config',
                'description' => 'Update database configuration in all applications',
                'status' => 'completed',
                'priority' => 'high',
                'project_id' => $projects[2]->id,
                'assigned_to' => $users[1]->id,
                'created_by' => $managers[2]->id,
                'due_date' => now()->subDays(15),
            ],
            [
                'title' => 'Test Database Performance',
                'description' => 'Run performance tests and benchmarks',
                'status' => 'completed',
                'priority' => 'medium',
                'project_id' => $projects[2]->id,
                'assigned_to' => $users[2]->id,
                'created_by' => $managers[2]->id,
                'due_date' => now()->subDays(10),
            ],
            [
                'title' => 'Monitor Production Database',
                'description' => 'Set up monitoring and alerts for PostgreSQL',
                'status' => 'completed',
                'priority' => 'medium',
                'project_id' => $projects[2]->id,
                'assigned_to' => $users[3]->id,
                'created_by' => $managers[2]->id,
                'due_date' => now()->subDays(5),
            ],
            [
                'title' => 'Document Migration Process',
                'description' => 'Create documentation for the migration process',
                'status' => 'completed',
                'priority' => 'low',
                'project_id' => $projects[2]->id,
                'assigned_to' => $users[4]->id,
                'created_by' => $managers[2]->id,
                'due_date' => now()->subDays(2),
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
