<?php

namespace App\Services\Genre;

use App\DTO\GenreDTO;
use Illuminate\Database\Eloquent\Model;

class UpdateGenreService extends GenreAbstractService
{
    public function execute(GenreDTO $genreDTO, string $genreId): Model
    {
        $genre = $this->repository->show($genreId);

        return $this->repository
            ->setModel($genre)
            ->update($genreDTO);
    }
}
