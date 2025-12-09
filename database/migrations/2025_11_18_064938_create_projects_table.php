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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('task_users')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['organization_id']);
            $table->index(['organization_id', 'is_archived']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
