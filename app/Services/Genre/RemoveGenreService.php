<?php

namespace App\Services\Genre;

class RemoveGenreService extends GenreAbstractService
{
    public function execute(string $genreId): void
    {
        $this->repository->delete($genreId);
    }
}
