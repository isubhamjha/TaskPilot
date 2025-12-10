<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = Organization::all();

        $tags = $organizations->flatMap(function (Organization $org) {
            return [
                [
                    'organization_id' => $org->id,
                    'name' => 'backend',
                ],
                [
                    'organization_id' => $org->id,
                    'name' => 'frontend',
                ],
                [
                    'organization_id' => $org->id,
                    'name' => 'urgent',
                ],
            ];
        });

        Tag::query()->truncate();
        Tag::insert(
            $tags->map(fn ($tag) => [
                ...$tag,
                'created_at' => now(),
                'updated_at' => now(),
            ])->all()
        );
    }
}
