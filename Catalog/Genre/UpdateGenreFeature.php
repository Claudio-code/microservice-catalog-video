<?php

namespace Catalog\Genre;

use App\Models\Genre;
use Catalog\Repository;
use Illuminate\Database\Eloquent\Model;

class UpdateGenreFeature
{
    private Repository $repository;

    public function __construct(Genre $genre)
    {
        $this->repository = new Repository($genre);
    }

    public function execute(array $data, Genre $genre): Model
    {
        $this->repository->setModel($genre);

        return $this->repository->update($data);
    }
}
