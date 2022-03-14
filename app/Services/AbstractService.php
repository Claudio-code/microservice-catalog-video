<?php

namespace App\Services;

use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\Pure;

abstract class AbstractService
{
    protected Repository $repository;

    #[Pure]
    public function __construct(Model $model)
    {
        $this->repository = new Repository($model);
    }
}
