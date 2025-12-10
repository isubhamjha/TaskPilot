<?php

namespace Database\Seeders;

use App\MembershipRole;
use App\MembershipStatus;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\TaskUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = Organization::all();
        $users = TaskUser::all()->keyBy('email');

        $memberships = [
            [
                'user_id' => $users['alice@example.com']->id ?? null,
                'organization_id' => $organizations->first()?->id,
                'role' => MembershipRole::ADMIN->value,
                'status' => MembershipStatus::ACCEPTED->value,
            ],
            [
                'user_id' => $users['bob@example.com']->id ?? null,
                'organization_id' => $organizations->first()?->id,
                'role' => MembershipRole::MANAGER->value,
                'status' => MembershipStatus::ACCEPTED->value,
            ],
            [
                'user_id' => $users['chloe@example.com']->id ?? null,
                'organization_id' => $organizations->first()?->id,
                'role' => MembershipRole::MEMBER->value,
                'status' => MembershipStatus::ACCEPTED->value,
            ],
            [
                'user_id' => $users['alice@example.com']->id ?? null,
                'organization_id' => $organizations->skip(1)->first()?->id,
                'role' => MembershipRole::MANAGER->value,
                'status' => MembershipStatus::ACCEPTED->value,
            ],
            [
                'user_id' => $users['bob@example.com']->id ?? null,
                'organization_id' => $organizations->skip(1)->first()?->id,
                'role' => MembershipRole::MEMBER->value,
                'status' => MembershipStatus::PENDING->value,
            ],
        ];

        Membership::query()->truncate();
        Membership::insert(
            collect($memberships)
                ->filter(fn ($member) => $member['user_id'] && $member['organization_id'])
                ->map(function (array $member) {
                    return [
                        ...$member,
                        'invited_at' => now()->subDays(5),
                        'accepted_at' => now()->subDays(3),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                })->all()
        );
    }
}
