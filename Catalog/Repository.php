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

    public function create(DataTransferObjectDecorator $dataTransferObjectDecorator): Model
    {
        return $this->model::create($dataTransferObjectDecorator->getAllData());
    }

    public function update(DataTransferObjectDecorator $dataTransferObjectDecorator): Model
    {
        $this->model->update($dataTransferObjectDecorator->getAllData());

        return $this->model;
    }

    public function delete(int | null $id = null): void
    {
        if (!$id) {
            $this->model->delete();

            return;
        }

        $this->show($id)?->delete();
    }

    public function show(int $id): ?Model
    {
        return $this->model::find($id);
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
