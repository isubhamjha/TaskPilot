<?php

use App\InvoiceStatus;
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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->string('provider_invoice_id')->nullable();
            $table->string('status')->default(InvoiceStatus::PENDING);
            $table->unsignedBigInteger('amount')->default(0);
            $table->string('currency', 10)->default('INR');
            $table->timestamp('issued_at')->nullable();
            $table->timestamp('due_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->jsonb('payload')->nullable();
            $table->timestamps();

            $table->index(['organization_id','status']);
            $table->index('provider_invoice_id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
