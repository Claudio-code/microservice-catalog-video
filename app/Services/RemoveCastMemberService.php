<?php

namespace App\Services;

use App\Models\CastMember;
use App\Repositories\Repository;

class RemoveCastMemberService
{
    private Repository $repository;

    public function __construct(CastMember $castMember)
    {
        $this->repository = new Repository($castMember);
    }

    public function execute(string $castMemberId): void
    {
        $this->repository->delete($castMemberId);
    }
}
