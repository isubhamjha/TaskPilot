<?php

use App\MembershipRole;
use App\MembershipStatus;
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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('task_users')->cascadeOnDelete();
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->string('role', 50)->default(MembershipRole::MEMBER->value);
            $table->string('status', 30)->default(MembershipStatus::ACCEPTED->value);
            $table->foreignId('invited_by')->nullable()->constrained('task_users')->nullOnDelete();
            $table->timestamp('invited_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id','organization_id']);
            $table->index(['organization_id','role']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
