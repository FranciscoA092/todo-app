<?php

use App\Domains\Project\DTOs\CreateProjectDTO;
use App\Domains\Project\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function Pest\Laravel\assertDatabaseHas;

uses(TestCase::class, RefreshDatabase::class);

test('it creates a project', function () {
    $action = new \App\Domains\Project\Actions\CreateProjectAction();

    $project = $action->execute(
        new CreateProjectDTO(
            title: fake()->title(),
            description: fake()->paragraph(),
        )
    );

    expect($project)->toBeInstanceOf(Project::class);

    assertDatabaseHas('projects', [
        'id' => $project->id,
        'title' => $project->title,
        'description' => $project->description,
    ]);
});
