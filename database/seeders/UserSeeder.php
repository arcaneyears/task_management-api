<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first();
        $managerRole = Role::where('slug', 'manager')->first();
        $userRole = Role::where('slug', 'user')->first();

        // Создание 1 админа
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $adminRole->id,
            'status' => 'active',
            'phone' => '+1234567890',
        ]);

        // Создание 2 менеджеров
        User::create([
            'first_name' => 'John',
            'last_name' => 'Manager',
            'email' => 'john.manager@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $managerRole->id,
            'status' => 'active',
            'phone' => '+1234567891',
        ]);

        User::create([
            'first_name' => 'Sarah',
            'last_name' => 'Manager',
            'email' => 'sarah.manager@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $managerRole->id,
            'status' => 'active',
            'phone' => '+1234567892',
        ]);

        // Создание 5 обычных пользователей
        $userNames = [
            ['Alice', 'Smith'],
            ['Bob', 'Johnson'],
            ['Charlie', 'Williams'],
            ['Diana', 'Brown'],
            ['Eve', 'Jones'],
        ];

        foreach ($userNames as $index => $name) {
            User::create([
                'first_name' => $name[0],
                'last_name' => $name[1],
                'email' => strtolower($name[0]) . '.' . strtolower($name[1]) . '@example.com',
                'password' => Hash::make('password123'),
                'role_id' => $userRole->id,
                'status' => 'active',
                'phone' => '+123456789' . (3 + $index),
            ]);
        }
    }
}
