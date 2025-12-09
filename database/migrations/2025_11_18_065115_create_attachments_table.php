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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('organization_id')
                ->constrained('organizations')
                ->cascadeOnDelete();
            $table->morphs('attachable');

            $table->string('disk')->nullable();
            $table->string('storage_path');
            $table->string('filename')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->string('checksum')->nullable();

            $table->foreignId('uploaded_by')
                ->nullable()
                ->constrained('task_users')
                ->nullOnDelete();

            $table->json('metadata')->nullable();

            $table->timestamps();

            $table->index('organization_id');
            $table->index('uploaded_by');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
