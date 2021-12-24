<?php

namespace App\Factories;

use App\DTO\GenreDTO;

class GenreDTOFactory implements DTOFactoryInterface
{
    public static function make(array $data): GenreDTO
    {
        return new GenreDTO($data);
    }
}
