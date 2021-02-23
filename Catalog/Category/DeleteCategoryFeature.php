<?php

namespace Catalog\Category;

use App\Models\Category;
use Catalog\Repository;

class DeleteCategoryFeature
{
    private Repository $repository;

    public function __construct(Category $category)
    {
        $this->repository = new Repository($category);
    }

    public function execute(Category $category): void
    {
        $this->repository->setModel($category);
        $this->repository->delete();
    }
}
