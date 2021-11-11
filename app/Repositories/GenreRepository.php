<?php

namespace App\Repositories;

use App\DTO\DataTransferObject;
use App\DTO\GenreDTO;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GenreRepository extends Repository
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

    private function matchRelationship(GenreDTO | DataTransferObject $dataTransferObject): void
    {
        if (!($dataTransferObject instanceof GenreDTO)) {
            return;
        }

        $this->syncCategories($dataTransferObject->categories_ids);
        $this->syncVideos($dataTransferObject->videos_ids);
    }

    /** @param array<string> $categoriesIds */
    private function syncCategories(array $categoriesIds): void
    {
        if (!($this->model instanceof Genre)) {
            return;
        }

        $this->model->categories()->sync($categoriesIds);
        $this->model->refresh();
    }

    /** @param array<string> $videosIds */
    private function syncVideos(array $videosIds): void
    {
        if (!($this->model instanceof Genre)) {
            return;
        }

        $this->model->videos()->sync($videosIds);
        $this->model->refresh();
    }
}
