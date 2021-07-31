<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\Repository;

class RemoveCategoryService
{
    private Repository $repository;

    public function __construct(Category $category)
    {
        $this->repository = new Repository($category);
    }

    public function execute(string $categoryId): void
    {
        $this->repository->delete($categoryId);
    }
}
