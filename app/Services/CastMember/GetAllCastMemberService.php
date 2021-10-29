<?php

namespace App\Services\CastMember;

use App\Enums\RedisKeysEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class GetAllCastMemberService extends CastMemberAbstractService
{
    public function execute(): Collection
    {
        return Cache::remember(
            RedisKeysEnum::REDIS_KEY_ALL_CAST_MEMBER,
            RedisKeysEnum::REDIS_TIME_TO_LIVE,
            fn () => $this->repository->all(),
        );
    }
}
