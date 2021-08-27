<?php

namespace App\Services;

use App\DTO\CastMemberDTO;
use App\Models\CastMember;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class UpdateCastMemberService
{
    private Repository $repository;
    private GetOneCastMemberService $service;

    public function __construct(CastMember $castMember, GetOneCastMemberService $service)
    {
        $this->service = $service;
        $this->repository = new Repository($castMember);
    }

    public function execute(CastMemberDTO $castMemberDTO, string $castMemberId): Model
    {
        $castMember = $this->service->execute($castMemberId);

        return $this->repository
            ->setModel($castMember)
            ->update($castMemberDTO);
    }
}
