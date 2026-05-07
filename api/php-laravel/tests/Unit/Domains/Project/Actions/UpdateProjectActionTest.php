<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function Pest\Laravel\assertDatabaseHas;

uses(TestCase::class, RefreshDatabase::class);

test('it updates a project', function () {
    $project = \App\Domains\Project\Models\Project::factory()->create();

    $action = new \App\Domains\Project\Actions\UpdateProjectAction();

    $updatedProject = $action->execute(
        new \App\Domains\Project\DTOs\UpdateProjectDTO(
            title: fake()->title(),
            description: fake()->paragraph(),
        ),
        $project->id
    );

    expect($updatedProject)->toBeInstanceOf(\App\Domains\Project\Models\Project::class);

    assertDatabaseHas('projects', [
        'id' => $updatedProject->id,
        'title' => $updatedProject->title,
        'description' => $updatedProject->description,
    ]);
});

test('it throws an exception if the project does not exist', function () {
    $action = new \App\Domains\Project\Actions\UpdateProjectAction();

    $action->execute(
        new \App\Domains\Project\DTOs\UpdateProjectDTO(
            title: fake()->title(),
            description: fake()->paragraph(),
        ),
        999
    );
})->throws(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

test('it updates a project with only a title', function () {
    $project = \App\Domains\Project\Models\Project::factory()->create();

    $action = new \App\Domains\Project\Actions\UpdateProjectAction();

    $updatedProject = $action->execute(
        new \App\Domains\Project\DTOs\UpdateProjectDTO(
            title: fake()->title(),
        ),
        $project->id
    );

    expect($updatedProject)->toBeInstanceOf(\App\Domains\Project\Models\Project::class);

    assertDatabaseHas('projects', [
        'id' => $updatedProject->id,
        'title' => $updatedProject->title,
        'description' => $project->description,
    ]);
});
