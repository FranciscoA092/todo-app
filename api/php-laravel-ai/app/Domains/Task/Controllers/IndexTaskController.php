<?php

namespace App\Domains\Task\Controllers;

use App\Domains\Project\Models\Project;
use App\Domains\Task\Actions\ListProjectTasksAction;
use App\Domains\Task\Resources\TaskResource;
use Illuminate\Http\JsonResponse;

class IndexTaskController
{
    public function __construct(
        private readonly ListProjectTasksAction $listProjectTasksAction,
    ) {}

    public function __invoke(Project $project): JsonResponse
    {
        $tasks = $this->listProjectTasksAction->execute($project);

        return TaskResource::collection($tasks)->response();
    }
}
