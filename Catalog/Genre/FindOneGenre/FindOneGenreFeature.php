<?php


namespace Catalog\Genre\FindOneGenre;


use App\Models\Genre;
use Catalog\Repository;
use Illuminate\Database\Eloquent\Model;

class FindOneGenreFeature
{
    private Repository $repository;

    public function __construct(Genre $genre)
    {
        $this->repository = new Repository($genre);
    }

    public function execute(string $genreId): ?Model
    {
        return $this->repository->show($genreId);
    }
}
