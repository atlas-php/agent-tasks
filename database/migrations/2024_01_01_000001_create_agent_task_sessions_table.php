<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CreateAgentTaskSessionsTable stores per-stage agent activity logs.
 *
 * Sessions capture inputs, outputs, and outcomes for auditing.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('atlas-agent-tasks.database.tables.sessions', 'atlas_agent_task_sessions'), static function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('task_id')->index();
            $table->string('stage')->index();
            $table->string('status')->index();
            $table->string('outcome')->nullable();
            $table->longText('input')->nullable();
            $table->longText('output')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('atlas-agent-tasks.database.tables.sessions', 'atlas_agent_task_sessions'));
    }
};
