<?php

namespace App\DTO;

use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class GenreDTO extends DataTransferObject
{
    public string $name;
    public bool $is_active;

    /** @var array<string> */
    public array $categories_ids = [];

    /** @var array<string> */
    public array $videos_ids = [];

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
