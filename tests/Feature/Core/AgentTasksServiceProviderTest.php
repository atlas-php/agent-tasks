<?php

declare(strict_types=1);

namespace Atlas\Agent\Tasks\Tests\Feature\Core;

use Atlas\Agent\Tasks\Tests\TestCase;
use Illuminate\Foundation\Application;

/**
 * AgentTasksServiceProviderTest validates base package wiring.
 */
class AgentTasksServiceProviderTest extends TestCase
{
    public function test_config_defaults_are_registered(): void
    {
        $this->assertSame('atlas_agent_tasks', config('atlas-agent-tasks.database.tables.tasks'));
        $this->assertSame('atlas_agent_task_sessions', config('atlas-agent-tasks.database.tables.sessions'));
        $this->assertNull(config('atlas-agent-tasks.defaults'));
    }

    public function test_migrations_are_registered_with_migrator(): void
    {
        /** @var Application $app */
        $app = $this->app;

        $expectedPath = realpath(__DIR__.'/../../../database/migrations') ?: __DIR__.'/../../../database/migrations';

        $paths = array_map(
            static fn (string $path): string => realpath($path) ?: $path,
            $app->make('migrator')->paths(),
        );

        $this->assertContains($expectedPath, $paths);
        $this->assertNotEmpty(glob($expectedPath.'/*.php'));
    }
}
