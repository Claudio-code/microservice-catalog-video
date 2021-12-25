<?php

namespace App\Services\CastMember;

use App\DTO\DataTransferObject;
use Illuminate\Database\Eloquent\Model;

class UpdateCastMemberService extends CastMemberAbstractService
{
    public function execute(DataTransferObject $castMemberDTO, string $castMemberId): Model
    {
        $castMember = $this->repository->show($castMemberId);

        return $this->repository
            ->setModel($castMember)
            ->update($castMemberDTO);
    }
}
