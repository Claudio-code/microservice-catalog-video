<?php

namespace App\Services\Genre;

use App\Models\Genre;
use App\Repositories\GenreRepository;
use App\Services\AbstractService;

abstract class GenreAbstractService extends AbstractService
{
    public function __construct(Genre $genre)
    {
        $this->repository = new GenreRepository($genre);
    }
}
