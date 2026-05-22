<?php

namespace App\Domains\Task\DTOs;

use App\Domains\Task\Enums\TaskStatus;

final readonly class UpdateTaskDTO
{
    public function __construct(
        public string $title,
        public ?string $description,
        public TaskStatus $status,
    ) {}

    /**
     * @param  array{title: string, description?: string|null, status: string}  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'] ?? null,
            status: TaskStatus::from($data['status']),
        );
    }
}
