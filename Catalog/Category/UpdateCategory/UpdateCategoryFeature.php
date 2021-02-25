<?php

namespace Catalog\Category\UpdateCategory;

use App\Models\Category;
use Catalog\Category\CreateCategory\CategoryDTO;
use Catalog\Repository;
use Illuminate\Database\Eloquent\Model;

class UpdateCategoryFeature
{
    private Repository $repository;

    public function __construct(Category $category)
    {
        $this->repository = new Repository($category);
    }

    public function execute(CategoryDTO $categoryDTO, Category $category): Model
    {
        $this->repository->setModel($category);

        return $this->repository->update($categoryDTO);
    }
}
