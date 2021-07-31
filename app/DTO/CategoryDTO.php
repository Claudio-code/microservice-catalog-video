<?php

namespace App\DTO;

use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CategoryDTO extends DataTransferObject
{
    public string $name;

    public string $description;

    public bool $is_active;

    /**
     * @param array<string, mixed> $data
     *
     * @throws UnknownProperties
     */
    public static function factory(array $data): self
    {
        return new self($data);
    }
}
