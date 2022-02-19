<?php

namespace App\Factories;

use App\DTO\CastMemberDTO;
use Illuminate\Http\Request;

class CastMemberDTOFactory
{
    public static function make(Request $request): CastMemberDTO
    {
        return new CastMemberDTO($request->all());
    }
}
