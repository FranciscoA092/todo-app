<?php

use App\Domains\Project\Models\Project;
use App\Domains\Task\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can list tasks of a project', function () {

    $project = Project::factory()->create();

    Task::factory()->count(3)->create([
        'project_id' => $project->id,
    ]);

    $response = $this->getJson(route('projects.tasks.index', ['project_id' => $project->id]));

    $response->assertOk();

    expect($response->json('data'))->toHaveCount(3);

});

it('returns empty when there are no tasks for a project', function () {

    $project = Project::factory()->create();

    $response = $this->getJson(route('projects.tasks.index', ['project_id' => $project->id]));

    $response->assertOk();

    expect($response->json('data'))->toHaveCount(0);

});

it('returns paginated tasks', function () {

    $project = Project::factory()->create();

    Task::factory()->count(15)->create([
        'project_id' => $project->id,
    ]);

    $response = $this->getJson(route('projects.tasks.index', ['project_id' => $project->id]));

    $response->assertOk();

    expect($response->json('data'))->toHaveCount(10);
    expect($response->json('links'))->toHaveKeys(['first', 'last', 'prev', 'next']);
    expect($response->json('meta'))->toHaveKeys(['current_page', 'from', 'last_page', 'path', 'per_page', 'to', 'total']);

});
