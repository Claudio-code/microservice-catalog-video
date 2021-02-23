<?php

namespace Catalog\Category;

use App\Models\Category;
use Catalog\Repository;
use Illuminate\Database\Eloquent\Model;

class CreateCategoryFeature
{
    private Repository $repository;

    public function __construct(Category $category)
    {
        $this->repository = new Repository($category);
    }

    public function execute(array $data): Model
    {
        return $this->repository->create($data);
    }
}
