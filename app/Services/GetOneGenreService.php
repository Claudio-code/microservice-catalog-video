<?php

namespace App\Services;

use App\Models\Genre;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class GetOneGenreService
{
    private Repository $repository;

    private const REDIS_KEY = 'micro-videos-genre-id:';

    private const REDIS_TIME_TO_LIVE = 1440;

    public function __construct(Genre $genre)
    {
        $this->repository = new Repository($genre);
    }

    public function execute(string $genreId): Model
    {
        $key = self::REDIS_KEY.$genreId;

        return Cache::remember(
            $key,
            self::REDIS_TIME_TO_LIVE,
            fn () => $this->repository->show($genreId)
        );
    }
}
