<?php

namespace App\Services\CastMember;

use App\Models\CastMember;
use App\Services\AbstractService;

abstract class CastMemberAbstractService extends AbstractService
{
    public function __construct(CastMember $castMember)
    {
        parent::__construct($castMember);
    }
}
