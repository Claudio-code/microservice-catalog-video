<?php

namespace App\Services;

class RemoveCastMemberService extends AbstractService
{
    public function execute(string $castMemberId): void
    {
        $this->repository->delete($castMemberId);
    }
}
