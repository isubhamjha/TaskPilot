<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = Plan::all()->keyBy('name');

        $organizations = [
            [
                'name' => 'Acme Corporation',
                'plan_id' => $plans->get('Growth')?->id,
                'settings' => ['timezone' => 'Asia/Kolkata', 'theme' => 'light'],
            ],
            [
                'name' => 'Beta Ventures',
                'plan_id' => $plans->get('Starter')?->id,
                'settings' => ['timezone' => 'UTC', 'theme' => 'dark'],
            ],
        ];

        Organization::query()->truncate();
        Organization::insert(
            collect($organizations)->map(function (array $org) {
                return [
                    'uuid' => (string) Str::uuid(),
                    'name' => $org['name'],
                    'plan_id' => $org['plan_id'],
                    // encode for bulk insert into jsonb
                    'settings' => json_encode($org['settings']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->all()
        );
    }
}
