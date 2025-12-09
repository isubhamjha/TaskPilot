<?php

use App\SubscriptionStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained('plans')->cascadeOnDelete();

            $table->string('provider_subscription_id')->nullable();
            $table->string('status')->default(SubscriptionStatus::ACTIVE->value);
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->boolean('auto_renew')->default(true);
            $table->jsonb('metadata')->nullable();
            $table->timestamps();

            $table->index(['organization_id','status']);
            $table->index('provider_subscription_id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
