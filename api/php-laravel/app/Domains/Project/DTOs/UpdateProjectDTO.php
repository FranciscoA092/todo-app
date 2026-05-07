<?php
namespace App\Domains\Project\DTOs;

use App\Shared\Base\DataTransferObject;

class UpdateProjectDTO extends DataTransferObject
{
    public function __construct(
        public readonly string $title,
        public readonly ?string $description = null,
    ) {}
}
