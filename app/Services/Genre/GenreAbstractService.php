<?php

namespace App\Services\Genre;

use App\Models\Genre;
use App\Services\AbstractService;

abstract class GenreAbstractService extends AbstractService
{
    public function __construct(Genre $genre)
    {
        parent::__construct($genre);
    }
}
