<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CreateAgentTasksTable sets up the core task storage.
 *
 * Tasks capture lifecycle details for Codex agent workflows.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('atlas-agent-tasks.database.tables.tasks', 'atlas_agent_tasks'), static function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('stage')->index();
            $table->string('status')->index();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->unsignedBigInteger('created_by_user_id')->nullable()->index();
            $table->string('assigned_agent')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('atlas-agent-tasks.database.tables.tasks', 'atlas_agent_tasks'));
    }
};
