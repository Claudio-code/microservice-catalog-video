<?php

namespace App\Repositories;

use App\DTO\DataTransferObject;
use App\DTO\VideoDTO;
use App\Models\Video;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VideoRepository extends Repository
{
    /**
     * @throws \Exception
     */
    public function create(VideoDTO | DataTransferObject $dataTransferObject): Model
    {
        if ($this->model instanceof Video && $dataTransferObject instanceof VideoDTO) {
            $this->model->create($dataTransferObject);
        }

        return $this->model;
    }

    public function update(VideoDTO | DataTransferObject $dataTransferObject): Model
    {
        DB::transaction(function () use ($dataTransferObject) {
            parent::update($dataTransferObject);
            $this->matchRelationship($dataTransferObject);
        });

        return $this->model;
    }

    private function matchRelationship(VideoDTO | DataTransferObject $dataTransferObject): void
    {
        if (!($dataTransferObject instanceof VideoDTO)) {
            return;
        }

        $this->syncCategories($dataTransferObject->categories_ids);
        $this->syncGenres($dataTransferObject->genres_ids);
    }

    /** @param array<string> $categoriesIds */
    private function syncCategories(array $categoriesIds): void
    {
        if (!($this->model instanceof Video)) {
            return;
        }

        $this->model->categories()->sync($categoriesIds);
        $this->model->refresh();
    }

    /** @param array<string> $genresIds */
    private function syncGenres(array $genresIds): void
    {
        if (!($this->model instanceof Video)) {
            return;
        }

        $this->model->genres()->sync($genresIds);
        $this->model->refresh();
    }
}
