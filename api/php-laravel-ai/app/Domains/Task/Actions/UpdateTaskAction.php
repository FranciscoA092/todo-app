<?php

namespace App\Domains\Task\Actions;

use App\Domains\Task\DTOs\UpdateTaskDTO;
use App\Domains\Task\Enums\TaskStatus;
use App\Domains\Task\Models\Task;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UpdateTaskAction
{
    public function execute(UpdateTaskDTO $dto, Task $task): Task
    {
        if ($task->status === TaskStatus::Running) {
            throw new HttpException(Response::HTTP_FORBIDDEN, 'Atividade em andamento não pode ser editada.');
        }

        $task->update([
            'title' => $dto->title,
            'description' => $dto->description,
            'status' => $dto->status,
        ]);

        return $task->fresh();
    }
}
