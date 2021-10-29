<?php

namespace App\Services\CastMember;

use App\DTO\CastMemberDTO;
use Illuminate\Database\Eloquent\Model;

class CreateCastMemberService extends CastMemberAbstractService
{
    public function execute(CastMemberDTO $castMemberDTO): Model
    {
        return $this->repository->create($castMemberDTO);
    }
}
