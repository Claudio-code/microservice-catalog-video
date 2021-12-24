<?php

namespace App\Factories;

use App\DTO\CategoryDTO;

class CategoryDTOFactory implements DTOFactoryInterface
{
    public static function make(array $data): CategoryDTO
    {
        return new CategoryDTO($data);
    }
}
