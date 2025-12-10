<?php

namespace Database\Seeders;

use App\Models\Attachment;
use App\Models\Task;
use App\Models\TaskUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = Task::all();
        $users = TaskUser::all()->keyBy('email');
        $now = now();

        $attachments = $tasks->flatMap(function (Task $task) use ($users, $now) {
            return [
                [
                    'organization_id' => $task->organization_id,
                    'attachable_type' => Task::class,
                    'attachable_id' => $task->id,
                    'disk' => 'local',
                    'storage_path' => "attachments/{$task->id}/requirements.pdf",
                    'filename' => 'requirements.pdf',
                    'mime_type' => 'application/pdf',
                    'size' => 24576,
                    'checksum' => md5('requirements'),
                    'uploaded_by' => $users['alice@example.com']->id ?? null,
                    'metadata' => json_encode(['description' => 'Requirements document']),
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'organization_id' => $task->organization_id,
                    'attachable_type' => Task::class,
                    'attachable_id' => $task->id,
                    'disk' => 'local',
                    'storage_path' => "attachments/{$task->id}/screenshot.png",
                    'filename' => 'screenshot.png',
                    'mime_type' => 'image/png',
                    'size' => 102400,
                    'checksum' => md5('screenshot'),
                    'uploaded_by' => $users['bob@example.com']->id ?? null,
                    'metadata' => json_encode(['description' => 'UI screenshot']),
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ];
        });

        Attachment::query()->truncate();
        Attachment::insert($attachments->all());
    }
}
