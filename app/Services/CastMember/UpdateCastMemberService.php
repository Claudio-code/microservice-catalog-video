<?php

namespace App\Services\CastMember;

use App\DTO\CastMemberDTO;
use Illuminate\Database\Eloquent\Model;

class UpdateCastMemberService extends CastMemberAbstractService
{
    public function execute(CastMemberDTO $castMemberDTO, string $castMemberId): Model
    {
        $castMember = $this->repository->show($castMemberId);

        return $this->repository
            ->setModel($castMember)
            ->update($castMemberDTO);
    }
}
