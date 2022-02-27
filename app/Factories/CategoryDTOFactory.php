<?php

namespace App\Factories;

use App\DTO\CategoryDTO;
use Illuminate\Http\Request;

class CategoryDTOFactory extends AbstractFactory
{
    protected function build(Request $request): CategoryDTO
    {
        return new CategoryDTO($request->all());
    }
}
