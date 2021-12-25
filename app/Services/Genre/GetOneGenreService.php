<?php

namespace App\Services\Genre;

use App\Enums\RedisKeysEnum;
use App\Enums\RedisTimeToLiveEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class GetOneGenreService extends GenreAbstractService
{
    public function execute(string $genreId): Model
    {
        $key = RedisKeysEnum::REDIS_KEY_GENRE_BY_ID->value . $genreId;

        return Cache::remember(
            $key,
            RedisTimeToLiveEnum::REDIS_TIME_TO_LIVE->value,
            fn () => $this->repository->show($genreId)
        );
    }
}
