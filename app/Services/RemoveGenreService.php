<?php

namespace App\Services;

class RemoveGenreService extends AbstractService
{
    public function execute(string $genreId): void
    {
        $this->repository->delete($genreId);
    }
}
