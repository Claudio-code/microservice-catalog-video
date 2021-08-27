<?php

namespace App\Services;

use App\DTO\GenreDTO;
use App\Models\Genre;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class UpdateGenreService
{
    private Repository $repository;

    public function __construct(Genre $genre)
    {
        $this->repository = new Repository($genre);
    }

    public function execute(GenreDTO $genreDTO, string $genreId): Model
    {
        $genre = $this->repository->show($genreId);

        return $this->repository
            ->setModel($genre)
            ->update($genreDTO);
    }
}
