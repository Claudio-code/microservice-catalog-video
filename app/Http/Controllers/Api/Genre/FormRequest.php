<?php

namespace App\Http\Controllers\Api\Genre;

use Illuminate\Foundation\Http\FormRequest as IlluminateFormRequest;

class FormRequest extends IlluminateFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ];
    }
}
