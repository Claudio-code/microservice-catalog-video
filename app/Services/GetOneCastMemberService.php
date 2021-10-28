<?php

namespace App\Services;

use App\Enums\RedisKeysEnum;
use App\Models\CastMember;
use Illuminate\Support\Facades\Cache;

class GetOneCastMemberService extends AbstractService
{
    public function execute(string $castMemberId): CastMember
    {
        $key = RedisKeysEnum::REDIS_KEY_CAST_MEMBER_BY_ID.$castMemberId;

        return Cache::remember(
            $key,
            RedisKeysEnum::REDIS_TIME_TO_LIVE,
            fn () => $this->repository->show($castMemberId)
        );
    }
}
