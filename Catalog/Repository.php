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

    public function create(array $data): Model
    {
        foreach ($data as $key => $value) {
            if ('password' == $key) {
                $options = ['memory_cost' => 2048, 'time_cost' => 4, 'threads' => 3];
                $this->model[$key] = password_hash($value, PASSWORD_ARGON2I, $options);

                continue;
            }
            $this->model[$key] = $value;
        }
        $this->model->save();

        return $this->model;
    }

    public function update(array $data): Model
    {
        $this->setModel($this->show($data['id']));
        foreach ($data as $key => $value) {
            $this->model[$key] = $value;
        }
        $this->model->update();

        return $this->model;
    }

    public function delete(int $id): void
    {
        $this->show($id)->delete();
    }

    public function show(int $id): Model
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
