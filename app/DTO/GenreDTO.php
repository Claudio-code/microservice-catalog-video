<?php

namespace App\DTO;

class GenreDTO extends DataTransferObject
{
    public function __construct(
        public readonly string $name,
        public readonly bool $is_active,
        public readonly array $categories_ids = [],
        public readonly array $videos_ids = [],
    ) {}
}
