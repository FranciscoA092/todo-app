<?php

use App\Domains\Project\Actions\ListProjectsAction;
use App\Domains\Project\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('it returns paginated projects with fixed size', function () {
    Project::factory()->count(15)->create();

    $paginator = (new ListProjectsAction())->execute();

    expect($paginator)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($paginator->perPage())->toBe(10);
    expect($paginator->total())->toBe(15);
    expect($paginator->items())->toHaveCount(10);
});