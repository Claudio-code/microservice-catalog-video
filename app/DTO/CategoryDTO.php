<?php

namespace App\DTO;

class CategoryDTO extends DataTransferObject
{
    public string $name;
    public string $description;
    public bool $is_active;

    /** @var array<string> */
    public array $genres_ids = [];

    /** @var array<string> */
    public array $videos_ids = [];
}
