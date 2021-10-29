<?php

namespace App\Services\Genre;

use App\Enums\RedisKeysEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class GetAllGenreService extends GenreAbstractService
{
    public function execute(): Collection
    {
        return Cache::remember(
            RedisKeysEnum::REDIS_KEY_ALL_GENRES,
            RedisKeysEnum::REDIS_TIME_TO_LIVE,
            fn () => $this->repository->all()
        );
    }
}