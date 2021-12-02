<?php

namespace App\Services\Video;

use App\Enums\RedisKeysEnum;
use App\Enums\RedisTimeToLiveEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class GetAllVideoService extends VideoAbstractService
{
    public function execute(): Collection
    {
        return Cache::remember(
            RedisKeysEnum::REDIS_KEY_ALL_VIDEOS->value,
            RedisTimeToLiveEnum::REDIS_TIME_TO_LIVE->value,
            fn () => $this->repository->all()
        );
    }
}
