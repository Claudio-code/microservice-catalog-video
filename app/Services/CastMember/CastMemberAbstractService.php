<?php

namespace App\Services\CastMember;

use App\Models\CastMember;
use App\Repositories\Repository;
use App\Services\AbstractService;
use JetBrains\PhpStorm\Pure;

abstract class CastMemberAbstractService extends AbstractService
{
    #[Pure]
    public function __construct(CastMember $castMember)
    {
        $this->repository = new Repository($castMember);
    }
}
