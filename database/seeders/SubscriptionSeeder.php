<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Plan;
use App\Models\Subscription;
use App\SubscriptionStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = Plan::all()->keyBy('name');
        $organizations = Organization::all();

        $subscriptions = [
            [
                'organization_id' => $organizations->first()?->id,
                'plan_id' => $plans->get('Growth')?->id,
                'provider_subscription_id' => 'sub_growth_001',
                'status' => SubscriptionStatus::ACTIVE->value,
                'trial_ends_at' => now()->addDays(7),
                'starts_at' => now()->subDays(3),
                'ends_at' => now()->addMonths(1),
                'canceled_at' => null,
                'auto_renew' => true,
                'metadata' => json_encode(['seats' => 15]),
            ],
            [
                'organization_id' => $organizations->skip(1)->first()?->id,
                'plan_id' => $plans->get('Starter')?->id,
                'provider_subscription_id' => 'sub_starter_002',
                'status' => SubscriptionStatus::ACTIVE->value,
                'trial_ends_at' => now()->addDays(14),
                'starts_at' => now()->subDays(1),
                'ends_at' => now()->addMonths(1),
                'canceled_at' => null,
                'auto_renew' => true,
                'metadata' => json_encode(['seats' => 5]),
            ],
        ];

        Subscription::query()->truncate();
        Subscription::insert(
            collect($subscriptions)
                ->filter(fn ($sub) => $sub['organization_id'] && $sub['plan_id'])
                ->map(function (array $subscription) {
                    return [
                        ...$subscription,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                })
                ->all()
        );
    }
}
