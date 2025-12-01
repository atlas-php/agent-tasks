# Atlas Agent Tasks

A headless Laravel package that manages task lifecycles for AI-driven planning, implementation, and review workflows.

## Table of Contents

* [Overview](#overview)
* [Projects](#projects)
* [Terminology](#terminology)
* [Core Concepts](#core-concepts)
* [Stages and Statuses](#stages-and-statuses)
* [Workflow Rules](#workflow-rules)
* [Data Model](#data-model)
* [Events](#events)
* [Agent Responsibilities](#agent-responsibilities)
* [Human Responsibilities](#human-responsibilities)
* [Sessions](#sessions)

## Overview

Atlas Agent Tasks provides a structured, UI-agnostic lifecycle for AI coding agents and human stakeholders. It standardizes task planning, implementation, QA, and review through consistent rules and stage transitions.

## Core Concepts

* Humans create tasks.
* Agents enrich, plan, implement, and validate work.
* Humans confirm final acceptance.
* Stages and statuses follow strict transition rules.
* Sessions track all agent activity and retries.

## Stages and Statuses

### Stages

A stage represents the task’s position within the lifecycle. It defines what phase of work the task is in (planning, implementation, review, etc.) and controls the allowed transitions between phases. **Stages describe progression**.

* **Todo**: Human-created starting point with initial requirements.
* **Plan**: Agents analyze requirements, add missing details, or generate child tasks; may advance to Final Review.
* **Blocked**: Agents cannot proceed; human intervention is required.
* **Ready**: Requirements verified; ready for implementation.
* **Implement**: Agents execute coding or content generation.
* **QA Review**: Agents validate whether implementation meets requirements.
* **Final Review**: Human evaluates deliverables and accepts or declines.
* **Done**: Work fully completed.
* **Declined**: Task rejected or unnecessary.

### Statuses

A status represents the task’s activity state inside its current stage. It indicates whether the task is idle, being worked on, or finished for that stage. **Statuses describe real-time state rather than workflow progress**.

* **Pending**: Waiting to be picked up.
* **Processing**: Being actively worked on.
* **Completed**: Work for the current stage is finished.

## Workflow Rules

* Todo → Plan
* Plan → Ready
* Plan → Final Review
* Plan → Blocked
* Blocked → Plan
* Ready → Implement
* Implement → QA Review
* QA Review → Implement
* QA Review → Final Review
* Final Review → Done
* Final Review → Implement
* Final Review → Declined

## Data Model

### Projects

Projects act as containers for tasks. Each project maintains its own configuration and workflow context.

* `id`
* `name`
* `workspace_location` (string)
* `task_template` (text)
* `instructions` (text)
* `metadata` (json)
* Timestamps (soft-deletes)

### Tasks

A unit of work that flows through the lifecycle.

* `id`
* `project_id` (unsignedBigInteger)
* `title`
* `description` (text)
* `stage` (enum)
* `status` (enum)
* `parent_task_id` (nullable, unsignedBigInteger)
* `assigned_agent` (nullable, string)
* `metadata` (json)
* Timestamps (soft-deletes)

### Sessions

Sessions track agent thread (chain-of-thought) execution for a task.

* `id`
* `task_id` (unsignedBigInteger)
* `type` (planning, implementation, qa)
* `input` (json)
* `output` (json)
* `outcome` (enum)
* `metadata` (json)
* Timestamps (soft-deletes)

#### Session Rules

* Retries during **Implement** restart implementation within the same session unless explicitly reset.
* Retries with new human feedback send the task back to **Plan**; the same session continues unless a new one is requested.
* All sessions are logged and attached to the task for audit.
