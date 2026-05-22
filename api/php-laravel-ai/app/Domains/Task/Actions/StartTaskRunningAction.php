<?php

namespace App\Domains\Task\Actions;

use App\Domains\Task\Enums\TaskStatus;
use App\Domains\Task\Models\Runner;
use App\Domains\Task\Models\Task;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class StartTaskRunningAction
{
    public function execute(Task $task): Task
    {
        if ($task->status === TaskStatus::Running) {
            throw new HttpException(Response::HTTP_FORBIDDEN, 'Atividade já está em execução.');
        }

        if ($task->runners()->whereNull('stop_at')->exists()) {
            throw new HttpException(Response::HTTP_FORBIDDEN, 'Atividade possui execução em aberto.');
        }

        DB::transaction(function () use ($task): void {
            Runner::query()->create([
                'task_id' => $task->id,
                'start_at' => now(),
                'stop_at' => null,
            ]);

            $task->update([
                'status' => TaskStatus::Running,
            ]);
        });

        return $task->fresh();
    }
}
