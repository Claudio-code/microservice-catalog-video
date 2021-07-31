<?php

namespace App\Services;

use App\DTO\CategoryDTO;
use App\Models\Category;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class CreateCategoryService
{
    private Repository $repository;

    public function __construct(Category $category)
    {
        $this->repository = new Repository($category);
    }

    public function execute(CategoryDTO $categoryDTO): Model
    {
        return $this->repository->create($categoryDTO);
    }
}
