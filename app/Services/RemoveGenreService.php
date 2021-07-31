<?php

namespace App\Services;

use App\Models\Genre;
use App\Repositories\Repository;

class RemoveGenreService
{
    private Repository $repository;

    public function __construct(Genre $genre)
    {
        $this->repository = new Repository($genre);
    }

    public function execute(string $genreId): void
    {
        $this->repository->delete($genreId);
    }
}
