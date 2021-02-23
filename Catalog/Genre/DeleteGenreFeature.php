<?php

namespace Catalog\Genre;

use App\Models\Genre;
use Catalog\Repository;

class DeleteGenreFeature
{
    private Repository $repository;

    public function __construct(Genre $genre)
    {
        $this->repository = new Repository($genre);
    }

    public function execute(Genre $genre): void
    {
        $this->repository->setModel($genre);
        $this->repository->delete();
    }
}
