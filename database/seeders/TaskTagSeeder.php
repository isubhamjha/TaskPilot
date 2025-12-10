<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Task;
use App\Models\TaskTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class TaskTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = Task::all()->groupBy('organization_id');
        $tags = Tag::all()->groupBy('organization_id');

        $taskTags = collect();

        foreach ($tasks as $organizationId => $orgTasks) {
            $orgTags = $tags->get($organizationId) ?? collect();
            if ($orgTags->isEmpty()) {
                continue;
            }

            foreach ($orgTasks as $task) {
                $sample = $orgTags->random(min(2, $orgTags->count()));
                $selected = $sample instanceof Collection ? $sample : collect([$sample]);

                foreach ($selected as $tag) {
                    $taskTags->push([
                        'task_id' => $task->id,
                        'tag_id' => $tag->id,
                        'organization_id' => $organizationId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        TaskTag::query()->truncate();
        TaskTag::insert($taskTags->all());
    }
}
