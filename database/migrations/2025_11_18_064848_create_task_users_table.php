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
        Schema::create('task_users', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable()->unique();
            $table->jsonb('profile')->nullable();
            $table->jsonb('settings')->nullable();
            $table->timestamp('last_active_at')->nullable();
//            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->index('email');
            $table->index('last_active_at');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_users');
    }
};
