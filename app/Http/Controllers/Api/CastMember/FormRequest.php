<?php

namespace App\Http\Controllers\Api\CastMember;

use Illuminate\Foundation\Http\FormRequest as IlluminateFormRequest;
use JetBrains\PhpStorm\ArrayShape;

class FormRequest extends IlluminateFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape(['name' => "string", 'type' => "string"])]
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'numeric|min:1|max:2',
        ];
    }
}
