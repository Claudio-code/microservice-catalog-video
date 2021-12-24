<?php

namespace App\Factories;

use App\DTO\CastMemberDTO;

class CastMemberDTOFactory implements DTOFactoryInterface
{
    public static function make(array $data): CastMemberDTO
    {
        return new CastMemberDTO($data);
    }
}
