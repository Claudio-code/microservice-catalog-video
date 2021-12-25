<?php

namespace App\Services\CastMember;

use App\DTO\DataTransferObject;
use Illuminate\Database\Eloquent\Model;

class CreateCastMemberService extends CastMemberAbstractService
{
    public function execute(DataTransferObject $castMemberDTO): Model
    {
        return $this->repository->create($castMemberDTO);
    }
}
