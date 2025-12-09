<?php

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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('task_id')->constrained('tasks')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('task_users')->cascadeOnDelete();

            $table->text('body');
            $table->foreignId('parent_id')->nullable()->constrained('comments')->nullOnDelete();
            $table->boolean('is_deleted')->default(false);
            $table->jsonb('metadata')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['organization_id','task_id']);
            $table->index(['task_id','user_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
