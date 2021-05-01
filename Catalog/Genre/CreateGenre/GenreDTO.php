<?php

namespace Catalog\Genre\CreateGenre;

use Catalog\AbstractDataTransferObject;

class GenreDTO extends AbstractDataTransferObject
{
    public function __construct(
        private string $name,
        private bool $is_active = true,
    ) {
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getIsActive() : bool
    {
        return $this->is_active;
    }

    /** @param mixed[] $data */
    public static function factory(array $data): self
    {
        return new self(...$data);
    }

    /** @return mixed[] */
    public function getAllData(): array
    {
        return [
            'name' => $this->name,
            'is_active' => $this->is_active,
        ];
    }
}
