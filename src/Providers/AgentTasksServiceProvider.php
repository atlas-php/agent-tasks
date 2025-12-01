<?php

declare(strict_types=1);

namespace Atlas\Agent\Tasks\Providers;

use Atlas\Core\Providers\PackageServiceProvider;

/**
 * AgentTasksServiceProvider wires configuration and migrations for the package.
 *
 * This keeps the package installable and ready for future workflow features.
 */
class AgentTasksServiceProvider extends PackageServiceProvider
{
    protected string $packageBasePath = __DIR__.'/../..';

    public function register(): void
    {
        $this->mergeConfigFrom($this->packageConfigPath('atlas-agent-tasks.php'), 'atlas-agent-tasks');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->packageConfigPath('atlas-agent-tasks.php') => config_path('atlas-agent-tasks.php'),
            ], $this->tags()->config());

            $this->publishes([
                $this->packageDatabasePath('migrations') => database_path('migrations'),
            ], $this->tags()->migrations());

            $this->notifyPendingInstallSteps(
                'Atlas Agent Tasks',
                'atlas-agent-tasks.php',
                $this->tags()->config(),
                '*agent_task*',
                $this->tags()->migrations()
            );
        }

        $this->loadMigrationsFrom($this->packageDatabasePath('migrations'));
    }

    protected function packageSlug(): string
    {
        return 'atlas agent tasks';
    }
}
