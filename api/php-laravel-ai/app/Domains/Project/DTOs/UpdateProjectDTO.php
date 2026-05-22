<?php

namespace App\Domains\Project\DTOs;

final readonly class UpdateProjectDTO
{
    public function __construct(
        public string $title,
        public string $description,
    ) {}

    /**
     * @param  array{title: string, description: string}  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'],
        );
    }
}