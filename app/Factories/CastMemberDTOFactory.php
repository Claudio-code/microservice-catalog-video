<?php

namespace App\Factories;

use App\DTO\CastMemberDTO;
use Illuminate\Http\Request;

class CastMemberDTOFactory extends AbstractFactory
{
    protected function build(Request $request): CastMemberDTO
    {
        return new CastMemberDTO(...$request->all());
    }
}
