# Atlas Agent Tasks

A headless Laravel package that manages task lifecycles for AI-driven planning, implementation, and review workflows.

## Table of Contents

* [Overview](#overview)
* [Goals](#goals)
* [Non-Goals](#non-goals)
* [Terminology](#terminology)
* [Core Concepts](#core-concepts)
* [Stages](#stages)
* [Statuses](#statuses)
* [Workflow Rules](#workflow-rules)
* [Data Model](#data-model)
* [Events](#events)
* [Agent Responsibilities](#agent-responsibilities)
* [Human Responsibilities](#human-responsibilities)

## Overview

Atlas Agent Tasks is a headless PHP package that defines and manages a structured task pipeline for AI coding agents. It provides a consistent lifecycle for task planning, implementation, QA, and final review. The system is fully UI-agnostic, allowing any frontend or platform to integrate with it.

## Goals

* Provide a strict task lifecycle to ensure high-quality agent-driven development.
* Enable AI agents to plan, implement, and validate work.
* Allow humans to create tasks and approve final outputs.
* Maintain stage integrity and transitions through a rules-based engine.
* Provide an extendable foundation for Codex-oriented workflows.

## Terminology

### Task

A single unit of work that moves through the workflow.

### Stage

The high-level position of a task within the lifecycle (e.g., Todo → Plan → Implement).

### Status

The real-time activity state of the task (e.g., Pending, Processing).

## Core Concepts

* Humans create tasks.
* Agents enrich requirements, break down tasks, write code, and validate outputs.
* Humans perform final review and decide Done/Declined.
* Each stage has strict rules for entry and exit.

## Stages

### Todo (`todo`)

Created by a human with initial requirements. First step in the workflow.

### Plan (`plan`)

Agents analyze requirements, create missing details, and optionally generate child tasks. May skip ahead to Final Review.

### Blocked (`blocked`)

Agents cannot proceed due to missing details or required decisions. Humans must resolve or decline.

### Ready (`ready`)

Agents verify requirements and confirm the task is ready for implementation.

### Implement (`implement`)

Agents write code, generate documentation, or execute other implementation tasks.

### QA Review (`qa_review`)

Agents validate implementation and confirm requirements satisfaction. May loop back to Implement.

### Final Review (`final_review`)

Human validates completeness and determines the final acceptance state.

### Done (`done`)

Task is fully completed and accepted.

### Declined (`declined`)

Task is rejected or requires no work.

## Statuses

### Pending (`pending`)

Task is waiting to be picked up.

### Processing (`processing`)

Task is being actively worked on by an agent.

### Completed (`completed`)

Agent has completed its effort for the current stage.

## Workflow Rules

* **Todo → Plan** when an agent begins planning.
* **Plan → Ready** when requirements are complete.
* **Plan → Final Review** if no work is required.
* **Plan → Blocked** if agents cannot proceed.
* **Blocked → Plan** after human provides missing details.
* **Ready → Implement** when picked up for execution.
* **Implement → QA Review** when code generation is finished.
* **QA Review → Implement** if corrections are needed.
* **QA Review → Final Review** if work is validated.
* **Final Review → Done** when human accepts.
* **Final Review → Implement** if more changes needed.
* **Final Review → Declined** if rejected.

## Data Model

### Task Table

* `id`
* `title`
* `description`
* `stage` (enum)
* `status` (enum)
* `parent_id` (nullable)
* `created_by_user_id` (nullable)
* `assigned_agent` (nullable)
* `metadata` (json)
* Timestamps

### Child Tasks

Tasks may link to a parent to support multi-step plans.

## Events

The package should dispatch events for:

* Stage changed
* Status changed
* Task created
* Task completed
* Task declined

## Agent Responsibilities

* Planning tasks
* Generating code
* Running QA validation
* Enforcing checklist requirements
* Handling stage transitions within allowed rules

## Human Responsibilities

* Creating tasks
* Providing missing details
* Reviewing final outputs
* Approving or declining

## Attempts

Attempts represent logged tries for any work performed by agents. Each attempt records the input, output, and outcome. Humans may trigger a retry if the result is unsatisfactory.

### Attempt Rules

* A retry during **Implement** restarts the implementation stage with a fresh attempt.
* A retry with additional human feedback sends the task back to the **Plan** stage and starts a new planning session.
* All attempts are logged and attached to the task for auditing.