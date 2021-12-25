<?php

namespace App\Services\Genre;

use App\Models\Genre;
use App\Repositories\GenreRepository;
use JetBrains\PhpStorm\Pure;

abstract class GenreAbstractService
{
    protected GenreRepository $repository;

    #[Pure]
    public function __construct(Genre $genre)
    {
        $this->repository = new GenreRepository($genre);
    }
}
