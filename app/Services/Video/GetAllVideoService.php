<?php

namespace App\Services\Video;

use App\Enums\RedisKeysEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class GetAllVideoService extends VideoAbstractService
{
    public function execute(): Collection
    {
        return Cache::remember(
            RedisKeysEnum::REDIS_KEY_ALL_VIDEOS,
            RedisKeysEnum::REDIS_TIME_TO_LIVE,
            fn () => $this->repository->all()
        );
    }
}
