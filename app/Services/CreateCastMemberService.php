<?php

namespace App\Services;

use App\DTO\CastMemberDTO;
use Illuminate\Database\Eloquent\Model;

class CreateCastMemberService extends AbstractService
{
    public function execute(CastMemberDTO $castMemberDTO): Model
    {
        return $this->repository->create($castMemberDTO);
    }
}
