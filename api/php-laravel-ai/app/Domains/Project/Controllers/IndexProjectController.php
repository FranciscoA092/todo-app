<?php

namespace App\Domains\Project\Controllers;

use App\Domains\Project\Actions\ListProjectsAction;
use App\Domains\Project\Resources\ProjectResource;
use Illuminate\Http\JsonResponse;

class IndexProjectController
{
    public function __construct(
        private readonly ListProjectsAction $listProjectsAction,
    ) {}

    public function __invoke(): JsonResponse
    {
        $projects = $this->listProjectsAction->execute();

        return ProjectResource::collection($projects)->response();
    }
}
