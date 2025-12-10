<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\Organization;
use App\Models\TaskUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuditLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = Organization::all()->keyBy('name');
        $users = TaskUser::all()->keyBy('email');
        $now = now();

        $logs = [
            [
                'actor_id' => $users['alice@example.com']->id ?? null,
                'organization_id' => $organizations->get('Acme Corporation')?->id,
                'action' => 'project.created',
                'target_type' => 'projects',
                'target_id' => 1,
                'payload' => json_encode(['title' => 'Website Revamp']),
                'ip_address' => '192.168.0.10',
                'user_agent' => 'LaravelSeeder',
                'created_at' => $now,
            ],
            [
                'actor_id' => $users['bob@example.com']->id ?? null,
                'organization_id' => $organizations->get('Acme Corporation')?->id,
                'action' => 'task.completed',
                'target_type' => 'tasks',
                'target_id' => 1,
                'payload' => json_encode(['status' => 'completed']),
                'ip_address' => '192.168.0.11',
                'user_agent' => 'LaravelSeeder',
                'created_at' => $now->copy()->addMinutes(15),
            ],
            [
                'actor_id' => $users['chloe@example.com']->id ?? null,
                'organization_id' => $organizations->get('Beta Ventures')?->id,
                'action' => 'subscription.updated',
                'target_type' => 'subscriptions',
                'target_id' => 2,
                'payload' => json_encode(['status' => 'active']),
                'ip_address' => '192.168.0.12',
                'user_agent' => 'LaravelSeeder',
                'created_at' => $now->copy()->addMinutes(30),
            ],
        ];

        AuditLog::query()->truncate();
        AuditLog::insert(
            collect($logs)
                ->filter(fn ($log) => $log['actor_id'] && $log['organization_id'])
                ->all()
        );
    }
}
