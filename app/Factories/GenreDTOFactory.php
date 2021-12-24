<?php

namespace App\Factories;

use App\DTO\GenreDTO;

class GenreDTOFactory
{
    public static function make(array $data): GenreDTO
    {
        return new GenreDTO($data);
    }
}
