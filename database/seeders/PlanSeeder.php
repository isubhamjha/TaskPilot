<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\PlanInterval;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'provider_plan_id' => 'starter_monthly',
                'price' => 0,
                'currency' => 'INR',
                'interval' => PlanInterval::MONTHLY->value,
                'limits' => [
                    'projects' => 3,
                    'users' => 5,
                    'storage_mb' => 500,
                ],
                'description' => 'Free tier for trying the platform with small teams.',
            ],
            [
                'name' => 'Growth',
                'provider_plan_id' => 'growth_monthly',
                'price' => 1499,
                'currency' => 'INR',
                'interval' => PlanInterval::MONTHLY->value,
                'limits' => [
                    'projects' => 15,
                    'users' => 25,
                    'storage_mb' => 5000,
                    'support' => 'email',
                ],
                'description' => 'Popular plan for growing teams that need collaboration.',
            ],
            [
                'name' => 'Enterprise',
                'provider_plan_id' => 'enterprise_yearly',
                'price' => 17999,
                'currency' => 'INR',
                'interval' => PlanInterval::YEARLY->value,
                'limits' => [
                    'projects' => null,
                    'users' => null,
                    'storage_mb' => 50000,
                    'support' => 'priority',
                    'sla' => '99.9%',
                ],
                'description' => 'Full access with priority support and flexible limits.',
            ],
        ];

        Plan::query()->truncate();
        Plan::insert(
            collect($plans)->map(function (array $plan) {
                return [
                    'name' => $plan['name'],
                    'provider_plan_id' => $plan['provider_plan_id'],
                    'price' => $plan['price'],
                    'currency' => $plan['currency'],
                    'interval' => $plan['interval'],
                    // encode limits so Postgres jsonb accepts it during bulk insert
                    'limits' => json_encode($plan['limits']),
                    'description' => $plan['description'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->all()
        );
    }
}
