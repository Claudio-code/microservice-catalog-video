<?php

use App\Models\Genre;
use Catalog\Repository;
use Illuminate\Database\Eloquent\Model;

class CreateGenreFeature
{
    private Repository $repository;

    public function __construct(Genre $genre)
    {
        $this->repository = new Repository($genre);
    }

    public function execute(array $data): Model
    {
        return $this->repository->create($data);
    }
}
