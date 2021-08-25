<?php

namespace App\Services;

use App\Enums\RedisKeysEnum;
use App\Models\CastMember;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class GetAllCastMemberService
{
    private Repository $repository;

    public function __construct(CastMember $castMember)
    {
        $this->repository = new Repository($castMember);
    }

    public function execute(): Collection
    {
        return Cache::remember(
            RedisKeysEnum::REDIS_KEY_ALL_CAST_MEMBER,
            RedisKeysEnum::REDIS_TIME_TO_LIVE,
            fn () => $this->repository->all(),
        );
    }
}
