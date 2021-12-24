<?php

namespace App\Factories;

use App\DTO\CastMemberDTO;

class CastMemberDTOFactory
{
    public static function make(array $data): CastMemberDTO
    {
        return new CastMemberDTO($data);
    }
}
