<?php

namespace App\Services\Video;

use App\Enums\RedisKeysEnum;
use App\Enums\RedisTimeToLiveEnum;
use App\Models\Video;
use Illuminate\Support\Facades\Cache;

class GetOneVideoService extends VideoAbstractService
{
    public function execute(string $videoId): Video
    {
        $key = RedisKeysEnum::REDIS_KEY_VIDEO_BY_ID->value . $videoId;
        return Cache::remember(
            $key,
            RedisTimeToLiveEnum::REDIS_TIME_TO_LIVE->value,
            fn () => $this->repository->show($videoId)
        );
    }
}
