<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use JetBrains\PhpStorm\Pure;

abstract class CategoryAbstractService
{
    protected CategoryRepository $repository;

    #[Pure]
    public function __construct(Category $category)
    {
        $this->repository = new CategoryRepository($category);
    }
}
