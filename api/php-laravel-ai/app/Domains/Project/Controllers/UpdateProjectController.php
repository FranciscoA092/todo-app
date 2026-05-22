<?php

namespace App\Domains\Project\Controllers;

use App\Domains\Project\Actions\UpdateProjectAction;
use App\Domains\Project\DTOs\UpdateProjectDTO;
use App\Domains\Project\Models\Project;
use App\Domains\Project\Requests\UpdateProjectRequest;
use Illuminate\Http\JsonResponse;

class UpdateProjectController
{
    public function __construct(
        private readonly UpdateProjectAction $updateProjectAction,
    ) {}

    public function __invoke(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        $this->updateProjectAction->execute(
            UpdateProjectDTO::fromArray($request->validated()),
            $project,
        );

        return response()->json([
            'message' => 'Projeto atualizado com sucesso',
        ]);
    }
}
