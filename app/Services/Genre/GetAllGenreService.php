<?php

namespace App\Services\Genre;

use App\Enums\RedisKeysEnum;
use App\Enums\RedisTimeToLiveEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\LazyCollection;

class GetAllGenreService extends GenreAbstractService
{
    /** @return LazyCollection<Model> */
    public function execute(): LazyCollection
    {
        return Cache::remember(
            RedisKeysEnum::REDIS_KEY_ALL_GENRES->value,
            RedisTimeToLiveEnum::REDIS_TIME_TO_LIVE->value,
            fn () => $this->repository->all()
        );
    }
}
