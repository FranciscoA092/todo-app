<?php
namespace App\Domains\Task\Enum;

enum StatusTask: string
{
    case PENDING = 'pending';
    case RUNNING = 'running';
    case COMPLETED = 'completed';
}
