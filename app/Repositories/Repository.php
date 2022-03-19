<?php

namespace App\Repositories;

use App\DTO\DataTransferObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\LazyCollection;

class Repository
{
    public function __construct(
        protected Model $model
    ) {
    }

    /** @return LazyCollection<Model> */
    public function all(): LazyCollection
    {
        return $this->model::all()->lazy();
    }

    public function create(DataTransferObject $dataTransferObject): Model
    {
        /** @var Model */
        $model = $this->model::create($dataTransferObject->toArray());
        $model->refresh();
        $this->setModel($model);
        return $model;
    }

    public function update(DataTransferObject $dataTransferObject): Model
    {
        $this->model->update($dataTransferObject->toArray());
        $this->model->refresh();
        return $this->model;
    }

    public function delete(?string $id = null): void
    {
        if (!$id) {
            $this->model->delete();
            return;
        }
        $this->show($id)->delete();
    }

    public function show(string $id): Model
    {
        return $this->model::findOrFail($id);
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function setModel(Model $model): self
    {
        $this->model = $model;
        return $this;
    }
}
