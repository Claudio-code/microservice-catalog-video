<?php

namespace App\DTO;

class GenreDTO extends DataTransferObject
{
    public string $name;
    public bool $is_active;

    /** @var array<string> */
    public array $categories_ids = [];

    /** @var array<string> */
    public array $videos_ids = [];
}
