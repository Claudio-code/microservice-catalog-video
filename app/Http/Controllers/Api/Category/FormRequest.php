<?php

namespace App\Http\Controllers\Api\Category;

use Illuminate\Foundation\Http\FormRequest as IlluminateFormRequest;
use JetBrains\PhpStorm\ArrayShape;

class FormRequest extends IlluminateFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape([
        'name' => "string",
        'is_active' => "string",
        'genres_ids' => "string",
        'videos_ids' => "string"
    ])]
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
            'genres_ids' => 'array|exists:genres,id,deleted_at,NULL',
            'videos_ids' => 'array|exists:genres,id,deleted_at,NULL',
        ];
    }
}
