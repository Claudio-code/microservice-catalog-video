<?php

namespace App\Factories;

use App\DTO\DataTransferObject;
use Illuminate\Http\Request;

abstract class AbstractFactory
{
    public function make(Request $request): DataTransferObject
    {
        return $this->build($request);
    }

    abstract protected function build(Request $request): DataTransferObject;
}
