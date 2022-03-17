<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\Repository;
use App\Services\AbstractService;
use JetBrains\PhpStorm\Pure;

abstract class CategoryAbstractService extends AbstractService
{
    #[Pure]
    public function __construct(Category $category)
    {
        $this->repository = new Repository($category);
    }
}
