# Atlas Agent Tasks

[![Build](https://github.com/atlas-php/agent-tasks/actions/workflows/tests.yml/badge.svg)](https://github.com/atlas-php/agent-tasks/actions/workflows/tests.yml)
[![coverage](https://codecov.io/github/atlas-php/agent-tasks/branch/main/graph/badge.svg)](https://codecov.io/github/atlas-php/agent-tasks)
[![License](https://img.shields.io/github/license/atlas-php/agent-tasks.svg)](LICENSE)

Headless Laravel package that ships the task lifecycle scaffolding for Codex agent workflows. This package only contains the installable plumbing for now (config, migrations, and service provider) so downstream apps can start integrating while the business logic is built out.

## Install

```bash
composer require atlas-php/agent-tasks
```

## Publish configuration and migrations

```bash
php artisan vendor:publish --tag=atlas-agent-tasks-config
php artisan vendor:publish --tag=atlas-agent-tasks-migrations
```

## PRD

See `docs/PRD/Overview.md` for the task lifecycle, statuses, and data model that will drive the upcoming implementation.
