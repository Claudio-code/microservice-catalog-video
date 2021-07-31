<?php

namespace App\Services;

use App\DTO\GenreDTO;
use App\Models\Genre;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class CreateGenreService
{
    private Repository $repository;

    public function __construct(Genre $genre)
    {
        $this->repository = new Repository($genre);
    }

    public function execute(GenreDTO $genreDTO): Model
    {
        return $this->repository->create($genreDTO);
    }
}
