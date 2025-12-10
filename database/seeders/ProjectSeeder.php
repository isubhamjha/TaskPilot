<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = Organization::all();

        $projects = $organizations->flatMap(function (Organization $org, int $index) {
            $now = now();

            return [
                [
                    'uuid' => (string) Str::uuid(),
                    'organization_id' => $org->id,
                    'title' => 'Website Revamp',
                    'description' => 'Redesign the marketing site with a new brand system.',
                    'is_archived' => false,
                    'start_date' => $now->copy()->subWeeks(3),
                    'end_date' => $now->copy()->addWeeks(6),
                    'metadata' => json_encode(['color' => '#1E90FF', 'priority' => 'high']),
                    'created_by' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'uuid' => (string) Str::uuid(),
                    'organization_id' => $org->id,
                    'title' => 'Internal Tools',
                    'description' => 'Improve internal tooling for support and ops.',
                    'is_archived' => false,
                    'start_date' => $now->copy()->subWeeks(1),
                    'end_date' => $now->copy()->addWeeks(10),
                    'metadata' => json_encode(['color' => '#00A878', 'priority' => 'medium']),
                    'created_by' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ];
        });

        Project::query()->truncate();
        Project::insert($projects->all());
    }
}
