<?php

namespace Catalog\Genre;

use App\Models\Genre;
use Catalog\Repository;
use Illuminate\Database\Eloquent\Collection;

class ListAllGenreFeature
{
    private Repository $repository;

    public function __construct(Genre $genre)
    {
        $this->repository = new Repository($genre);
    }

    public function execute(): Collection
    {
        return $this->repository->all();
    }
}
