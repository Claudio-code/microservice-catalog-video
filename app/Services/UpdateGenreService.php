<?php

namespace App\Services;

use App\DTO\GenreDTO;
use Illuminate\Database\Eloquent\Model;

class UpdateGenreService extends AbstractService
{
    public function execute(GenreDTO $genreDTO, string $genreId): Model
    {
        $genre = $this->repository->show($genreId);

        return $this->repository
            ->setModel($genre)
            ->update($genreDTO);
    }
}
