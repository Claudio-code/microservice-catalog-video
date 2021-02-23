<?php

namespace Catalog\Category;

use App\Models\Category;
use Catalog\Repository;
use Illuminate\Database\Eloquent\Collection;

class ListAllCategoryFeature
{
    private Repository $repository;

    public function __construct(Category $category)
    {
        $this->repository = new Repository($category);
    }

    public function execute(): Collection
    {
        return $this->repository->all();
    }
}
