<?php

namespace App\Services;

use App\DTO\GenreDTO;
use App\Models\Genre;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class UpdateGenreService
{
    private Repository $repository;
    private GetOneGenreService $service;

    public function __construct(Genre $genre, GetOneGenreService $service)
    {
        $this->repository = new Repository($genre);
        $this->service = $service;
    }

    public function execute(GenreDTO $genreDTO, string $genreId): Model
    {
        $genre = $this->service->execute($genreId);

        return $this->repository
            ->setModel($genre)
            ->update($genreDTO);
    }
}
