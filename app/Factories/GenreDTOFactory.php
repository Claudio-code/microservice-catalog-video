<?php

namespace App\Factories;

use App\DTO\GenreDTO;
use Illuminate\Http\Request;

class GenreDTOFactory extends AbstractFactory
{
    protected function build(Request $request): GenreDTO
    {
        return new GenreDTO(...$request->all());
    }
}
