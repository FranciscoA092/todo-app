<?php

namespace App\Domains\Task\Controllers;

use App\Domains\Project\Models\Project;
use App\Domains\Task\Resources\TaskResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexTaskController
{
    public function __invoke(
        Project $project_id
    ): JsonResponse
    {
        $tasks = $project_id->tasks()->paginate(10);

        return TaskResource::collection($tasks)->response();
    }
}
