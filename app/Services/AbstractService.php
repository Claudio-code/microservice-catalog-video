<?php

namespace App\Services;

use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractService
{
    protected Repository $repository;

    public function __construct(Model $model)
    {
        $this->repository = new Repository($model);
    }
}
