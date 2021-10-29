<?php

namespace App\Http\Controllers\Api\Genre;

use Illuminate\Foundation\Http\FormRequest as IlluminateFormRequest;
use JetBrains\PhpStorm\ArrayShape;

class FormRequest extends IlluminateFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape(['name' => "string", 'is_active' => "string"])]
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ];
    }
}
