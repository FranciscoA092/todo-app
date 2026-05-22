<?php

use App\Domains\Project\Models\Project;
use App\Domains\Task\Enums\TaskStatus;
use App\Domains\Task\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

test('it updates a task successfully', function () {
    $project = Project::factory()->create();
    $task = Task::factory()->create([
        'project_id' => $project->id,
        'status' => TaskStatus::Pending,
    ]);

    $response = $this->putJson(route('projects.tasks.update', ['project' => $project->id, 'task' => $task->id]), [
        'title' => 'Atividade atualizada',
        'description' => 'Nova descrição',
        'status' => TaskStatus::Completed->value,
    ]);

    $response->assertOk();
    $response->assertJson(['message' => 'Atividade atualizada com sucesso']);

    assertDatabaseHas('tasks', [
        'id' => $task->id,
        'title' => 'Atividade atualizada',
        'description' => 'Nova descrição',
        'status' => TaskStatus::Completed->value,
    ]);
});

test('it returns 403 when task status is running', function () {
    $project = Project::factory()->create();
    $task = Task::factory()->create([
        'project_id' => $project->id,
        'status' => TaskStatus::Running,
    ]);

    $response = $this->putJson(route('projects.tasks.update', ['project' => $project->id, 'task' => $task->id]), [
        'title' => 'Tentativa de atualização',
        'status' => TaskStatus::Completed->value,
    ]);

    $response->assertForbidden();
});

test('it validates required title when updating a task', function () {
    $project = Project::factory()->create();
    $task = Task::factory()->create(['project_id' => $project->id]);

    $response = $this->putJson(route('projects.tasks.update', ['project' => $project->id, 'task' => $task->id]), [
        'status' => TaskStatus::Completed->value,
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['title']);
});

test('it validates required status when updating a task', function () {
    $project = Project::factory()->create();
    $task = Task::factory()->create(['project_id' => $project->id]);

    $response = $this->putJson(route('projects.tasks.update', ['project' => $project->id, 'task' => $task->id]), [
        'title' => 'Título',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['status']);
});

test('it rejects running as a status when updating a task', function () {
    $project = Project::factory()->create();
    $task = Task::factory()->create([
        'project_id' => $project->id,
        'status' => TaskStatus::Pending,
    ]);

    $response = $this->putJson(route('projects.tasks.update', ['project' => $project->id, 'task' => $task->id]), [
        'title' => 'Título',
        'status' => TaskStatus::Running->value,
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['status']);
});

test('it validates max length for title when updating a task', function () {
    $project = Project::factory()->create();
    $task = Task::factory()->create(['project_id' => $project->id]);

    $response = $this->putJson(route('projects.tasks.update', ['project' => $project->id, 'task' => $task->id]), [
        'title' => str_repeat('a', 256),
        'status' => TaskStatus::Completed->value,
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['title']);
});

test('it returns not found when project does not exist while updating a task', function () {
    $task = Task::factory()->create();

    $response = $this->putJson(route('projects.tasks.update', ['project' => 999999, 'task' => $task->id]), [
        'title' => 'Título',
        'status' => TaskStatus::Completed->value,
    ]);

    $response->assertNotFound();
});

test('it returns not found when task does not exist while updating', function () {
    $project = Project::factory()->create();

    $response = $this->putJson(route('projects.tasks.update', ['project' => $project->id, 'task' => 999999]), [
        'title' => 'Título',
        'status' => TaskStatus::Completed->value,
    ]);

    $response->assertNotFound();
});
