<?php

use App\TaskPriority;
use App\TaskStatus;
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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('task_users')->nullOnDelete();

            $table->string('title', 255);
            $table->text('description')->nullable();

            $table->string('status', 50)->default(TaskStatus::CREATED->value);
            $table->string('priority', 30)->default(TaskPriority::NORMAL->value);

            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->unsignedInteger('estimate')->nullable(); // hours or story points
            $table->unsignedInteger('position')->nullable()->comment('manual ordering');

            $table->foreignId('created_by')->nullable()->constrained('task_users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('task_users')->nullOnDelete();

            $table->jsonb('metadata')->nullable();

            $table->unsignedInteger('version')->default(1);

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['organization_id', 'project_id']);
            $table->index(['organization_id', 'assigned_to']);
            $table->index(['organization_id', 'status']);
            $table->index(['project_id', 'status']);
        });

        // Postgres full-text search support
        if (config('database.default') === 'pgsql') {
            DB::statement('ALTER TABLE tasks ADD COLUMN search_vector tsvector');
            DB::statement("CREATE INDEX tasks_search_vector_idx ON tasks USING GIN (search_vector)");
            DB::statement("
                CREATE FUNCTION tasks_search_vector_trigger() RETURNS trigger LANGUAGE plpgsql AS \$\$
                begin
                  new.search_vector :=
                    to_tsvector('english', coalesce(new.title,'') || ' ' || coalesce(new.description,''));
                  return new;
                end
                \$\$;
            ");
            DB::statement("
                CREATE TRIGGER tsvectorupdate_tasks BEFORE INSERT OR UPDATE
                ON tasks FOR EACH ROW EXECUTE PROCEDURE tasks_search_vector_trigger();
            ");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (config('database.default') === 'pgsql') {
            DB::statement('DROP TRIGGER IF EXISTS tsvectorupdate_tasks ON tasks');
            DB::statement('DROP FUNCTION IF EXISTS tasks_search_vector_trigger()');
            DB::statement('DROP INDEX IF EXISTS tasks_search_vector_idx');
            DB::statement('ALTER TABLE tasks DROP COLUMN IF EXISTS search_vector');
        }
        Schema::dropIfExists('tasks');

    }

};
