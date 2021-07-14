<?php

namespace Catalog;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Repository
{
    public function __construct(
        protected Model $model
    ) {
    }

    public function all(): Collection
    {
        return $this->model::all();
    }

    public function create(AbstractDataTransferObject $dataTransferObject): Model
    {
        /** @var Model */
        $model = $this->model::create($dataTransferObject->getAllData());
        $model->refresh();

        return $model;
    }

    public function update(AbstractDataTransferObject $dataTransferObject): Model
    {
        $this->model->update($dataTransferObject->getAllData());
        $this->model->refresh();

        return $this->model;
    }

    public function delete(string | null $id = null): void
    {
        if (!$id) {
            $this->model->delete();

            return;
        }

        $this->show($id)?->delete();
    }

    public function show(string $id): ?Model
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
