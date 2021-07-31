<?php

namespace App\Services;

use App\Models\Genre;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class GetAllGenreService
{
    private Repository $repository;

    private const REDIS_KEY = 'micro-videos-all-genre';

    private const REDIS_TIME_TO_LIVE = 1440;

    public function __construct(Genre $genre)
    {
        $this->repository = new Repository($genre);
    }

    public function execute(): Collection
    {
        return Cache::remember(
            self::REDIS_KEY,
            self::REDIS_TIME_TO_LIVE,
            fn () => $this->repository->all()
        );
    }
}
