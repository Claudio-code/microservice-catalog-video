<?php

namespace Catalog\Category\CreateCategory;

use Catalog\DataTransferObjectDecorator;

class CategoryDTO extends DataTransferObjectDecorator
{
    public function __construct(
        private string $name,
        private string $description,
        private bool $is_active = true,
    ) {
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function getIsActive() : bool
    {
        return $this->is_active;
    }

    /** @param mixed[] $data */
    public static function factory(array $data): self
    {
        [
            'name' => $name,
            'description' => $description,
            'is_active' => $is_active,

        ] = $data;

        return new self(
            $name,
            $description,
            $is_active
        );
    }

    /** @return mixed[] */
    public function getAllData(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];
    }
}