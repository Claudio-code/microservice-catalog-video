<?php

namespace App\Services\CastMember;

use App\Enums\RedisKeysEnum;
use App\Enums\RedisTimeToLiveEnum;
use App\Models\CastMember;
use Illuminate\Support\Facades\Cache;

class GetOneCastMemberService extends CastMemberAbstractService
{
    public function execute(string $castMemberId): CastMember
    {
        $key = RedisKeysEnum::REDIS_KEY_CAST_MEMBER_BY_ID->value . $castMemberId;

        return Cache::remember(
            $key,
            RedisTimeToLiveEnum::REDIS_TIME_TO_LIVE->value,
            fn () => $this->repository->show($castMemberId)
        );
    }
}
