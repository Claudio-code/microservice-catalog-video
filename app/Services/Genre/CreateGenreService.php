<?php

namespace App\Services\Genre;

use App\DTO\GenreDTO;
use Illuminate\Database\Eloquent\Model;

class CreateGenreService extends GenreAbstractService
{
    public function execute(GenreDTO $genreDTO): Model
    {
        return $this->repository->create($genreDTO);
    }
}
