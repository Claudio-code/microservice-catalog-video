<?php

namespace App\Services\CastMember;

class RemoveCastMemberService extends CastMemberAbstractService
{
    public function execute(string $castMemberId): void
    {
        $this->repository->delete($castMemberId);
    }
}
