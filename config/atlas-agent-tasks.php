<?php

declare(strict_types=1);

return [
    'database' => [
        'connection' => env('ATLAS_AGENT_TASKS_DATABASE_CONNECTION'),
        'tables' => [
            'tasks' => 'atlas_agent_tasks',
            'attempts' => 'atlas_agent_task_attempts',
        ],
    ],
];
