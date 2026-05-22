<?php

use App\Domains\Project\Models\Project;
use App\Domains\Task\Enums\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

test('it creates a task for a project with default pending status', function () {
    $project = Project::factory()->create();

    $response = $this->postJson(route('projects.tasks.store', ['project' => $project->id]), [
        'title' => 'Minha atividade',
    ]);

    $response->assertCreated();
    $response->assertJson([
        'title' => 'Minha atividade',
        'description' => null,
        'status' => TaskStatus::Pending->value,
        'project_id' => $project->id,
    ]);
    $response->assertJsonStructure([
        'id',
        'title',
        'description',
        'status',
        'created_at',
        'project_id',
    ]);

    assertDatabaseHas('tasks', [
        'title' => 'Minha atividade',
        'description' => null,
        'status' => TaskStatus::Pending->value,
        'project_id' => $project->id,
    ]);
});

test('it validates required title when creating a task', function () {
    $project = Project::factory()->create();

    $response = $this->postJson(route('projects.tasks.store', ['project' => $project->id]), [
        'description' => 'Descrição opcional',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['title']);
});

test('it validates max length for title when creating a task', function () {
    $project = Project::factory()->create();

    $response = $this->postJson(route('projects.tasks.store', ['project' => $project->id]), [
        'title' => str_repeat('a', 256),
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['title']);
});

test('it returns not found when project does not exist while creating a task', function () {
    $response = $this->postJson(route('projects.tasks.store', ['project' => 999999]), [
        'title' => 'Minha atividade',
    ]);

    $response->assertNotFound();
});