<?php

declare(strict_types=1);

namespace Atlas\Agent\Tasks\Tests;

use Atlas\Agent\Tasks\Providers\AgentTasksServiceProvider;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as Orchestra;

/**
 * Base TestCase bootstraps the package service provider for integration testing.
 */
abstract class TestCase extends Orchestra
{
    /**
     * @param  Application  $app
     */
    protected function getPackageProviders($app): array
    {
        return [
            AgentTasksServiceProvider::class,
        ];
    }
}
