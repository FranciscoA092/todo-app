<?php

use App\Domains\Project\Models\Project;
use App\Domains\Task\Enums\TaskStatus;
use App\Domains\Task\Models\Runner;
use App\Domains\Task\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

test('it stops task execution using latest open runner', function () {
    $project = Project::factory()->create();
    $task = Task::factory()->create([
        'project_id' => $project->id,
        'status' => TaskStatus::Running,
    ]);

    Runner::factory()->create([
        'task_id' => $task->id,
        'start_at' => now()->subHour(),
        'stop_at' => now()->subMinutes(30),
    ]);

    $openRunner = Runner::factory()->create([
        'task_id' => $task->id,
        'start_at' => now()->subMinutes(10),
        'stop_at' => null,
    ]);

    $response = $this->postJson(route('projects.tasks.stop', ['project' => $project->id, 'task' => $task->id]));

    $response->assertOk();
    $response->assertJson(['message' => 'Execução parada']);

    assertDatabaseHas('tasks', [
        'id' => $task->id,
        'status' => TaskStatus::Pending->value,
    ]);

    expect($openRunner->fresh()->stop_at)->not->toBeNull();
});

test('it returns 400 when latest runner is already closed', function () {
    $project = Project::factory()->create();
    $task = Task::factory()->create([
        'project_id' => $project->id,
        'status' => TaskStatus::Running,
    ]);

    Runner::factory()->create([
        'task_id' => $task->id,
        'stop_at' => now(),
    ]);

    $response = $this->postJson(route('projects.tasks.stop', ['project' => $project->id, 'task' => $task->id]));

    $response->assertBadRequest();
});

test('it returns 400 when task has no runner history', function () {
    $project = Project::factory()->create();
    $task = Task::factory()->create([
        'project_id' => $project->id,
        'status' => TaskStatus::Running,
    ]);

    $response = $this->postJson(route('projects.tasks.stop', ['project' => $project->id, 'task' => $task->id]));

    $response->assertBadRequest();
});

test('it returns not found when project does not exist while stopping a task', function () {
    $task = Task::factory()->create();

    $response = $this->postJson(route('projects.tasks.stop', ['project' => 999999, 'task' => $task->id]));

    $response->assertNotFound();
});

test('it returns not found when task does not exist while stopping a task', function () {
    $project = Project::factory()->create();

    $response = $this->postJson(route('projects.tasks.stop', ['project' => $project->id, 'task' => 999999]));

    $response->assertNotFound();
});
