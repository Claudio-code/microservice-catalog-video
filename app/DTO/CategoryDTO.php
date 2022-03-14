<?php

namespace App\DTO;

class CategoryDTO extends DataTransferObject
{
    public function __construct(
        public readonly string $name,
        public readonly bool $is_active,
        public readonly ?string $description = null,
        public readonly array $genres_ids = [],
        public readonly array $videos_ids = [],
    ) {}
}
