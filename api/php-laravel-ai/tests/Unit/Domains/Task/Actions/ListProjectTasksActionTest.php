<?php

use App\Domains\Project\Models\Project;
use App\Domains\Task\Actions\ListProjectTasksAction;
use App\Domains\Task\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('it returns project tasks paginated with fixed size', function () {
    $project = Project::factory()->create();
    $anotherProject = Project::factory()->create();

    Task::factory()->count(15)->create([
        'project_id' => $project->id,
    ]);

    Task::factory()->count(3)->create([
        'project_id' => $anotherProject->id,
    ]);

    $paginator = (new ListProjectTasksAction())->execute($project);

    expect($paginator)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($paginator->perPage())->toBe(10);
    expect($paginator->total())->toBe(15);
    expect($paginator->items())->toHaveCount(10);
});
