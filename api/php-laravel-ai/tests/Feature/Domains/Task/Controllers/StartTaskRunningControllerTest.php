<?php

use App\Domains\Project\Models\Project;
use App\Domains\Task\Enums\TaskStatus;
use App\Domains\Task\Models\Runner;
use App\Domains\Task\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

test('it starts task execution and creates an open runner', function () {
    $project = Project::factory()->create();
    $task = Task::factory()->create([
        'project_id' => $project->id,
        'status' => TaskStatus::Pending,
    ]);

    $response = $this->postJson(route('projects.tasks.start', ['project' => $project->id, 'task' => $task->id]));

    $response->assertOk();
    $response->assertJson(['message' => 'Execução da atividade iniciada com sucesso']);

    assertDatabaseHas('tasks', [
        'id' => $task->id,
        'status' => TaskStatus::Running->value,
    ]);

    assertDatabaseHas('runners', [
        'task_id' => $task->id,
        'stop_at' => null,
    ]);

    expect(Runner::query()->where('task_id', $task->id)->whereNull('stop_at')->first())
        ->not->toBeNull();
});

test('it returns 403 when task is already running', function () {
    $project = Project::factory()->create();
    $task = Task::factory()->create([
        'project_id' => $project->id,
        'status' => TaskStatus::Running,
    ]);

    $response = $this->postJson(route('projects.tasks.start', ['project' => $project->id, 'task' => $task->id]));

    $response->assertForbidden();
});

test('it returns 403 when task has an open runner', function () {
    $project = Project::factory()->create();
    $task = Task::factory()->create([
        'project_id' => $project->id,
        'status' => TaskStatus::Pending,
    ]);

    Runner::factory()->create([
        'task_id' => $task->id,
        'stop_at' => null,
    ]);

    $response = $this->postJson(route('projects.tasks.start', ['project' => $project->id, 'task' => $task->id]));

    $response->assertForbidden();
});

test('it returns not found when project does not exist while starting a task', function () {
    $task = Task::factory()->create();

    $response = $this->postJson(route('projects.tasks.start', ['project' => 999999, 'task' => $task->id]));

    $response->assertNotFound();
});

test('it returns not found when task does not exist while starting a task', function () {
    $project = Project::factory()->create();

    $response = $this->postJson(route('projects.tasks.start', ['project' => $project->id, 'task' => 999999]));

    $response->assertNotFound();
});
