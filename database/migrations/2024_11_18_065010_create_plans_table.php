<?php

use App\PlanInterval;
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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('provider_plan_id')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('currency', 10)->default('INR');
            $table->string('interval', 20)->default(PlanInterval::MONTHLY->value);
            $table->jsonb('limits')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('provider_plan_id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
