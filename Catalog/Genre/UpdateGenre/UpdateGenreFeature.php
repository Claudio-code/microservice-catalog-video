<?php

namespace Catalog\Genre\UpdateGenre;

use App\Models\Genre;
use Catalog\Genre\CreateGenre\GenreDTO;
use Catalog\Repository;
use Illuminate\Database\Eloquent\Model;

class UpdateGenreFeature
{
    private Repository $repository;

    public function __construct(Genre $genre)
    {
        $this->repository = new Repository($genre);
    }

    public function execute(GenreDTO $genreDTO, Genre $genre): Model
    {
        $this->repository->setModel($genre);

        return $this->repository->update($genreDTO);
    }
}
