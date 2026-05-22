<?php

namespace App\Domains\Task\Models;

use Database\Factories\RunnerFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @use HasFactory<RunnerFactory> */
#[Fillable(['task_id', 'start_at', 'stop_at'])]
class Runner extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'stop_at' => 'datetime',
        ];
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    protected static function newFactory(): RunnerFactory
    {
        return RunnerFactory::new();
    }
}
