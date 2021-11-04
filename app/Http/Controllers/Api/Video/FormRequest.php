<?php

namespace App\Http\Controllers\Api\Video;

use Illuminate\Foundation\Http\FormRequest as IlluminateFormRequest;
use JetBrains\PhpStorm\ArrayShape;

class FormRequest extends IlluminateFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape([
        'title' => "string",
        'description' => "string",
        'opened' => "string",
        'rating' => "string",
        'duration' => "string",
        'year_launched' => "string",
        'categories_ids' => "string",
        'genres_ids' => "string"
    ])]
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'opened' => 'boolean',
            'rating' => 'numeric',
            'duration' => 'numeric',
            'year_launched' => 'numeric',
            'categories_ids' => 'array|exists:categories,id',
            'genres_ids' => 'array|exists:genres,id',
        ];
    }
}
