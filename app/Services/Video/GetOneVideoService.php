<?php

namespace App\Services\Video;

use App\Enums\RedisKeysEnum;
use App\Models\Video;
use Illuminate\Support\Facades\Cache;

class GetOneVideoService extends VideoAbstractService
{
    public function execute(string $videoId): Video
    {
        $key = RedisKeysEnum::REDIS_KEY_VIDEO_BY_ID.$videoId;

        return Cache::remember(
            $key,
            RedisKeysEnum::REDIS_TIME_TO_LIVE,
            fn () => $this->repository->show($videoId)
        );
    }
}
