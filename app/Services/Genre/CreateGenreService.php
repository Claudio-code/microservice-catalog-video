<?php

namespace App\Services\Genre;

use App\DTO\DataTransferObject;
use Illuminate\Database\Eloquent\Model;

class CreateGenreService extends GenreAbstractService
{
    public function execute(DataTransferObject $genreDTO): Model
    {
        return $this->repository->create($genreDTO);
    }
}
