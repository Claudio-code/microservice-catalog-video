<?php

namespace App\Services;

use App\Enums\RedisKeysEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class GetOneGenreService extends AbstractService
{
    public function execute(string $genreId): Model
    {
        $key = RedisKeysEnum::REDIS_KEY_GENRE_BY_ID.$genreId;

        return Cache::remember(
            $key,
            RedisKeysEnum::REDIS_TIME_TO_LIVE,
            fn () => $this->repository->show($genreId)
        );
    }
}
