<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class ValidateException extends ValidationException
{
    public function __construct(Validator $validator)
    {
        parent::__construct($validator);
    }
}
