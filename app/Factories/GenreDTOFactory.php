<?php

namespace App\Factories;

use App\DTO\GenreDTO;
use Illuminate\Http\Request;

class GenreDTOFactory
{
    public static function make(Request $request): GenreDTO
    {
        return new GenreDTO($request->all());
    }
}
