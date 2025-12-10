<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskUser;
use App\TaskPriority;
use App\TaskStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $users = TaskUser::all()->keyBy('email');
        $now = now();

        $tasks = collect();

        foreach ($projects as $project) {
            $tasks->push([
                'uuid' => (string) Str::uuid(),
                'organization_id' => $project->organization_id,
                'project_id' => $project->id,
                'assigned_to' => $users['alice@example.com']->id ?? null,
                'title' => 'Set up project scaffolding',
                'description' => 'Initialize repository, CI, and coding standards.',
                'status' => TaskStatus::IN_PROGRESS->value,
                'priority' => TaskPriority::HIGH->value,
                'start_date' => $now->copy()->subDays(5),
                'due_date' => $now->copy()->addDays(7),
                'started_at' => $now->copy()->subDays(4),
                'completed_at' => null,
                'estimate' => 8,
                'position' => 1,
                'created_by' => $users['alice@example.com']->id ?? null,
                'updated_by' => $users['alice@example.com']->id ?? null,
                'metadata' => json_encode(['labels' => ['infra']]),
                'version' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $tasks->push([
                'uuid' => (string) Str::uuid(),
                'organization_id' => $project->organization_id,
                'project_id' => $project->id,
                'assigned_to' => $users['bob@example.com']->id ?? null,
                'title' => 'Design review',
                'description' => 'Review new UI flows with the design team.',
                'status' => TaskStatus::CREATED->value,
                'priority' => TaskPriority::NORMAL->value,
                'start_date' => $now->copy()->addDays(1),
                'due_date' => $now->copy()->addDays(5),
                'started_at' => null,
                'completed_at' => null,
                'estimate' => 5,
                'position' => 2,
                'created_by' => $users['chloe@example.com']->id ?? null,
                'updated_by' => $users['chloe@example.com']->id ?? null,
                'metadata' => json_encode(['labels' => ['design']]),
                'version' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $tasks->push([
                'uuid' => (string) Str::uuid(),
                'organization_id' => $project->organization_id,
                'project_id' => $project->id,
                'assigned_to' => $users['chloe@example.com']->id ?? null,
                'title' => 'QA smoke tests',
                'description' => 'Run smoke tests before the release.',
                'status' => TaskStatus::COMPLETED->value,
                'priority' => TaskPriority::LOW->value,
                'start_date' => $now->copy()->subDays(10),
                'due_date' => $now->copy()->subDays(2),
                'started_at' => $now->copy()->subDays(9),
                'completed_at' => $now->copy()->subDays(1),
                'estimate' => 3,
                'position' => 3,
                'created_by' => $users['alice@example.com']->id ?? null,
                'updated_by' => $users['bob@example.com']->id ?? null,
                'metadata' => json_encode(['labels' => ['qa']]),
                'version' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        Task::query()->truncate();
        Task::insert($tasks->all());
    }
}
