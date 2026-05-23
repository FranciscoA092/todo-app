<?php

use App\Domains\Project\Actions\UpdateProjectAction;
use App\Domains\Project\DTOs\UpdateProjectDTO;
use App\Domains\Project\Models\Project;
use App\Domains\Task\Enums\TaskStatus;
use App\Domains\Task\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

use function Pest\Laravel\assertDatabaseHas;

uses(TestCase::class, RefreshDatabase::class);

test('it updates a project', function () {
    $project = Project::factory()->create();

    $updatedProject = (new UpdateProjectAction())->execute(
        new UpdateProjectDTO(
            title: fake()->unique()->sentence(3),
            description: fake()->paragraph(),
        ),
        $project,
    );

    expect($updatedProject)->toBeInstanceOf(Project::class);
    expect($updatedProject->id)->toBe($project->id);

    assertDatabaseHas('projects', [
        'id' => $project->id,
        'title' => $updatedProject->title,
        'description' => $updatedProject->description,
    ]);
});

test('it throws 403 when project has running task', function () {
    $project = Project::factory()->create();

    Task::factory()->create([
        'project_id' => $project->id,
        'status' => TaskStatus::Running,
    ]);

    expect(fn () => (new UpdateProjectAction())->execute(
        new UpdateProjectDTO(
            title: fake()->unique()->sentence(3),
            description: fake()->paragraph(),
        ),
        $project,
    ))->toThrow(HttpException::class);
});
