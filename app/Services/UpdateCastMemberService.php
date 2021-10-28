<?php

namespace App\Services;

use App\DTO\CastMemberDTO;
use Illuminate\Database\Eloquent\Model;

class UpdateCastMemberService extends AbstractService
{
    public function execute(CastMemberDTO $castMemberDTO, string $castMemberId): Model
    {
        $castMember = $this->repository->show($castMemberId);

        return $this->repository
            ->setModel($castMember)
            ->update($castMemberDTO);
    }
}
