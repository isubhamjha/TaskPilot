<?php

namespace Database\Seeders;

use App\Models\TaskUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TaskUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Alice Johnson',
                'email' => 'alice@example.com',
                'phone' => '+91-9876543210',
                'profile' => ['title' => 'Product Manager'],
                'settings' => ['notifications' => true],
            ],
            [
                'name' => 'Bob Singh',
                'email' => 'bob@example.com',
                'phone' => '+91-9123456780',
                'profile' => ['title' => 'Engineer'],
                'settings' => ['notifications' => true],
            ],
            [
                'name' => 'Chloe Fernandes',
                'email' => 'chloe@example.com',
                'phone' => '+91-9988776655',
                'profile' => ['title' => 'Designer'],
                'settings' => ['notifications' => false],
            ],
        ];

        TaskUser::query()->truncate();
        TaskUser::insert(
            collect($users)->map(function (array $user) {
                $now = now();

                return [
                    'uuid' => (string) Str::uuid(),
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => Hash::make('password'),
                    'phone' => $user['phone'],
                    'profile' => json_encode($user['profile']),
                    'settings' => json_encode($user['settings']),
                    'last_active_at' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            })->all()
        );
    }
}
