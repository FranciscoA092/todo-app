<?php

use App\Domains\Project\Models\Project;
use App\Domains\Task\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it lists project tasks with pagination', function () {
    $project = Project::factory()->create();
    Project::factory()->create();

    Task::factory()->count(15)->create([
        'project_id' => $project->id,
    ]);

    $response = $this->getJson(route('projects.tasks.index', ['project' => $project->id]));

    $response->assertOk();
    $response->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'title',
                'description',
                'status',
                'created_at',
                'project_id',
            ],
        ],
        'links' => [
            'first',
            'last',
            'prev',
            'next',
        ],
        'meta' => [
            'current_page',
            'from',
            'last_page',
            'path',
            'per_page',
            'to',
            'total',
        ],
    ]);

    expect($response->json('data'))->toHaveCount(10);
    expect($response->json('meta.per_page'))->toBe(10);
    expect($response->json('meta.total'))->toBe(15);
    expect($response->json('meta.current_page'))->toBe(1);
    expect($response->json('meta.last_page'))->toBe(2);
});

test('it lists requested page of project tasks', function () {
    $project = Project::factory()->create();

    Task::factory()->count(15)->create([
        'project_id' => $project->id,
    ]);

    $response = $this->getJson(route('projects.tasks.index', [
        'project' => $project->id,
        'page' => 2,
    ]));

    $response->assertOk();

    expect($response->json('data'))->toHaveCount(5);
    expect($response->json('meta.current_page'))->toBe(2);
    expect($response->json('meta.per_page'))->toBe(10);
});

test('it returns not found when project does not exist while listing tasks', function () {
    $response = $this->getJson(route('projects.tasks.index', ['project' => 999999]));

    $response->assertNotFound();
});