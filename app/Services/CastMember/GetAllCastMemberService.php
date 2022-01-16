<?php

namespace App\Services\CastMember;

use App\Enums\RedisKeysEnum;
use App\Enums\RedisTimeToLiveEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\LazyCollection;

class GetAllCastMemberService extends CastMemberAbstractService
{
    /** @return LazyCollection<Model> */
    public function execute(): LazyCollection
    {
        return Cache::remember(
            RedisKeysEnum::REDIS_KEY_ALL_CAST_MEMBER->value,
            RedisTimeToLiveEnum::REDIS_TIME_TO_LIVE->value,
            fn () => $this->repository->all(),
        );
    }
}
