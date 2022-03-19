<?php

namespace App\Services\Genre;

use App\Models\Genre;
use App\Repositories\GenreRepository;
use App\Services\AbstractService;
use JetBrains\PhpStorm\Pure;

abstract class GenreAbstractService extends AbstractService
{
    protected GenreRepository $repository;

    #[Pure]
    public function __construct(Genre $genre)
    {
        $this->repository = new GenreRepository($genre);
    }
}
