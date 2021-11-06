<?php

namespace App\Repositories;

use App\DTO\DataTransferObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VideoRepository extends Repository
{
    public function create(DataTransferObject $dataTransferObject): Model
    {
        DB::transaction(function () use ($dataTransferObject) {
            parent::create($dataTransferObject);
            $this->matchRelationship($dataTransferObject);
        });

        return $this->model;
    }

    public function update(DataTransferObject $dataTransferObject): Model
    {
        DB::transaction(function () use ($dataTransferObject) {
            parent::update($dataTransferObject);
            return $this->matchRelationship($dataTransferObject);
        });

        return $this->model;
    }

    private function matchRelationship(DataTransferObject $dataTransferObject): Model
    {
        $this->syncCategories($dataTransferObject->categories_ids);
        $this->syncGenres($dataTransferObject->genres_ids);

        return $this->model;
    }

    /** @param array<string> $categoriesIds */
    private function syncCategories(array $categoriesIds): void
    {
        $this->model->categories()->sync($categoriesIds);
        $this->model->refresh();
    }

    /** @param array<string> $genresIds */
    private function syncGenres(array $genresIds): void
    {
        $this->model->genres()->sync($genresIds);
        $this->model->refresh();
    }
}
