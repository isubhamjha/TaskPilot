<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Task;
use App\Models\TaskUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = Task::all();
        $users = TaskUser::all()->keyBy('email');
        $now = now();

        $comments = collect();

        foreach ($tasks as $task) {
            $comments->push([
                'organization_id' => $task->organization_id,
                'task_id' => $task->id,
                'user_id' => $users['alice@example.com']->id ?? $users->first()->id,
                'body' => 'Can we confirm the acceptance criteria?',
                'parent_id' => null,
                'is_deleted' => false,
                'metadata' => json_encode(['mentions' => ['bob@example.com']]),
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ]);

            $comments->push([
                'organization_id' => $task->organization_id,
                'task_id' => $task->id,
                'user_id' => $users['bob@example.com']->id ?? $users->first()->id,
                'body' => 'Yes, I added them to the ticket description.',
                'parent_id' => null,
                'is_deleted' => false,
                'metadata' => json_encode(['reply_to' => 'alice@example.com']),
                'created_at' => $now->copy()->addMinutes(10),
                'updated_at' => $now->copy()->addMinutes(10),
                'deleted_at' => null,
            ]);
        }

        Comment::query()->truncate();
        Comment::insert($comments->all());
    }
}
