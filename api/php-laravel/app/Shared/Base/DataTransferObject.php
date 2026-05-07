<?php
namespace App\Shared\Base;

abstract class DataTransferObject
{
    public static function fromArray(array $data): static
    {
        return new static(...$data);
    }
}
