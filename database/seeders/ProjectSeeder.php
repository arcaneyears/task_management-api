<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $managers = User::whereHas('role', function ($query) {
            $query->whereIn('slug', ['admin', 'manager']);
        })->get();

        $projects = [
            [
                'name' => 'Website Redesign',
                'description' => 'Complete redesign of the company website with modern UI/UX',
                'status' => 'active',
                'created_by' => $managers[0]->id,
            ],
            [
                'name' => 'Mobile App Development',
                'description' => 'Development of iOS and Android mobile applications',
                'status' => 'active',
                'created_by' => $managers[1]->id,
            ],
            [
                'name' => 'Database Migration',
                'description' => 'Migration from MySQL to PostgreSQL for better performance',
                'status' => 'completed',
                'created_by' => $managers[2]->id,
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
