<?php

namespace App\Repositories;

use App\DTO\DataTransferObject;
use Illuminate\Database\Eloquent\Model;

class VideoRepository extends Repository
{
    public function create(DataTransferObject $dataTransferObject): Model
    {
        parent::create($dataTransferObject);
        return $this->matchRelationship($dataTransferObject);
    }

    public function update(DataTransferObject $dataTransferObject): Model
    {
        parent::update($dataTransferObject);
        return $this->matchRelationship($dataTransferObject);
    }

    private function matchRelationship(DataTransferObject $dataTransferObject): Model
    {
        return match (true) {
            !empty($dataTransferObject->categories_ids) => $this->syncCategories($dataTransferObject->categories_ids),
            !empty($dataTransferObject->genres_ids) => $this->syncGenres($dataTransferObject->genres_ids),
            default => $this->model,
        };
    }

    /** @param array<string> $categoriesIds */
    private function syncCategories(array $categoriesIds): Model
    {
        $this->model->categories()->sync($categoriesIds);
        $this->model->refresh();

        return $this->model;
    }

    /** @param array<string> $genresIds */
    private function syncGenres(array $genresIds): Model
    {
        $this->model->genres()->sync($genresIds);
        $this->model->refresh();

        return $this->model;
    }
}
