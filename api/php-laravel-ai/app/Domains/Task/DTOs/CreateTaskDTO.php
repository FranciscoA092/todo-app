<?php

namespace App\Domains\Task\DTOs;

final readonly class CreateTaskDTO
{
    public function __construct(
        public string $title,
        public ?string $description,
    ) {}

    /**
     * @param  array{title: string, description?: string|null}  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'] ?? null,
        );
    }
}
