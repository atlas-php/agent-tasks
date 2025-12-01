<?php

declare(strict_types=1);

return [
    'database' => [
        'connection' => env('ATLAS_AGENT_TASKS_DATABASE_CONNECTION'),
        'tables' => [
            'tasks' => 'agent_tasks',
            'attempts' => 'agent_task_attempts',
        ],
    ],
];
