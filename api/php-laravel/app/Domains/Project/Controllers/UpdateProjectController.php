<?php

namespace App\Domains\Project\Controllers;

use App\Domains\Project\Actions\UpdateProjectAction;
use App\Domains\Project\Requests\UpdateProjectRequest;
use Illuminate\Http\JsonResponse;

class UpdateProjectController
{
    public function __construct(
        private UpdateProjectAction $action,
    ) {}

    public function __invoke(
        UpdateProjectRequest $request, int $id
    ): JsonResponse
    {
        $updatedProject = $this->action->execute(
            \App\Domains\Project\DTOs\UpdateProjectDTO::fromArray($request->validated()),
            $id
        );

        return response()->json($updatedProject);
    }
}
