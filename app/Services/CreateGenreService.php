<?php

namespace App\Services;

use App\DTO\GenreDTO;
use Illuminate\Database\Eloquent\Model;

class CreateGenreService extends AbstractService
{
    public function execute(GenreDTO $genreDTO): Model
    {
        return $this->repository->create($genreDTO);
    }
}
