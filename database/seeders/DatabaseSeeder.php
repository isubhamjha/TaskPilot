<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $this->call([
            PlanSeeder::class,
            OrganizationSeeder::class,
            TaskUserSeeder::class,
            MembershipSeeder::class,
            ProjectSeeder::class,
            SubscriptionSeeder::class,
            InvoiceSeeder::class,
            TaskSeeder::class,
            TagSeeder::class,
            TaskTagSeeder::class,
            CommentSeeder::class,
            AttachmentSeeder::class,
            NotificationSeeder::class,
            AuditLogSeeder::class,
        ]);

        // Keep a default Laravel user for quick login/testing.
        User::query()->truncate();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
