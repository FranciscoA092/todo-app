<?php

use App\Domains\Project\Actions\DeleteProjectAction;
use App\Domains\Project\Models\Project;
use App\Domains\Task\Enums\TaskStatus;
use App\Domains\Task\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

use function Pest\Laravel\assertDatabaseMissing;

uses(TestCase::class, RefreshDatabase::class);

test('it deletes a project', function () {
    $project = Project::factory()->create();

    (new DeleteProjectAction())->execute($project);

    assertDatabaseMissing('projects', [
        'id' => $project->id,
    ]);
});

test('it throws 403 when project has running task', function () {
    $project = Project::factory()->create();

    Task::factory()->create([
        'project_id' => $project->id,
        'status' => TaskStatus::Running,
    ]);

    expect(fn () => (new DeleteProjectAction())->execute($project))
        ->toThrow(HttpException::class);
});
