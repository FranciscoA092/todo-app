<?php
namespace App\Domains\Task\DTOs;

use App\Shared\Base\DataTransferObject;

class CreateTaskDTO extends DataTransferObject
{
    public function __construct(
        public string $title,
        public ?string $description = null,
    ) {}
}
