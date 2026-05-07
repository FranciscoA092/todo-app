<?php
namespace App\Domains\Project\DTOs;

use App\Shared\Base\DataTransferObject;

class CreateProjectDTO extends DataTransferObject
{
    public function __construct(
        public string $title,
        public string $description,
    ) {
    }
}
