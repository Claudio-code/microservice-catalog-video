<?php

namespace App\Services;

use App\Enums\RedisKeysEnum;
use App\Models\Genre;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class GetAllGenreService
{
    private Repository $repository;

    public function __construct(Genre $genre)
    {
        $this->repository = new Repository($genre);
    }

    public function execute(): Collection
    {
        return Cache::remember(
            RedisKeysEnum::REDIS_KEY_ALL_GENRES,
            RedisKeysEnum::REDIS_TIME_TO_LIVE,
            fn () => $this->repository->all()
        );
    }
}
