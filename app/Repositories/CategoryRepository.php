<?php

namespace App\Repositories;

use App\DTO\CategoryDTO;
use App\DTO\DataTransferObject;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends Repository
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
            $this->matchRelationship($dataTransferObject);
        });

        return $this->model;
    }


    private function matchRelationship(CategoryDTO | DataTransferObject $dataTransferObject): void
    {
        if (!($dataTransferObject instanceof CategoryDTO)) {
            return;
        }

        $this->syncVideos($dataTransferObject->videos_ids);
        $this->syncGenres($dataTransferObject->genres_ids);
    }


    /** @param array<string> $videosIds */
    private function syncVideos(array $videosIds): void
    {
        if (!($this->model instanceof Category)) {
            return;
        }

        $this->model->videos()->sync($videosIds);
        $this->model->refresh();
    }

    /** @param array<string> $genresIds */
    private function syncGenres(array $genresIds): void
    {
        if (!($this->model instanceof Category)) {
            return;
        }

        $this->model->genres()->sync($genresIds);
        $this->model->refresh();
    }
}
