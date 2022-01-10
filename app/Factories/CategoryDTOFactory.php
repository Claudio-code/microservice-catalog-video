<?php

namespace App\Factories;

use App\DTO\CategoryDTO;
use Illuminate\Http\Request;

class CategoryDTOFactory
{
    public static function make(Request $request): CategoryDTO
    {
        return new CategoryDTO($request->all());
    }
}
