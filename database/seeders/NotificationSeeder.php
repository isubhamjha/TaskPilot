<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\Organization;
use App\Models\TaskUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = TaskUser::all()->keyBy('email');
        $organizations = Organization::all()->keyBy('name');
        $now = now();

        $notifications = [
            [
                'organization_id' => $organizations->get('Acme Corporation')?->id,
                'user_id' => $users['alice@example.com']->id ?? null,
                'type' => 'task.assigned',
                'payload' => json_encode(['message' => 'You were assigned a new task']),
                'read_at' => null,
                'is_archived' => false,
            ],
            [
                'organization_id' => $organizations->get('Acme Corporation')?->id,
                'user_id' => $users['bob@example.com']->id ?? null,
                'type' => 'comment.mention',
                'payload' => json_encode(['message' => 'You were mentioned in a comment']),
                'read_at' => $now,
                'is_archived' => false,
            ],
            [
                'organization_id' => $organizations->get('Beta Ventures')?->id,
                'user_id' => $users['chloe@example.com']->id ?? null,
                'type' => 'subscription.trial',
                'payload' => json_encode(['message' => 'Trial ending in 3 days']),
                'read_at' => null,
                'is_archived' => false,
            ],
        ];

        Notification::query()->truncate();
        Notification::insert(
            collect($notifications)
                ->filter(fn ($note) => $note['user_id'])
                ->map(fn ($note) => [
                    ...$note,
                    'created_at' => $now,
                    'updated_at' => $now,
                ])
                ->all()
        );
    }
}
