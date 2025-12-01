# Atlas Agent Tasks Installation

1. Require the package:

```bash
composer require atlas-php/agent-tasks
```

2. Publish configuration and migrations (optional if you want to customize table names or edit migrations):

```bash
php artisan vendor:publish --tag=atlas-agent-tasks-config
php artisan vendor:publish --tag=atlas-agent-tasks-migrations
```

3. Run migrations:

```bash
php artisan migrate
```

The PRD lives at `docs/PRD/Overview.md` and defines the lifecycle, statuses, and data model that will be implemented next.
