<?php

namespace App\Services;

use App\DTO\CategoryDTO;
use App\Models\Category;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class UpdateCategoyService
{
    private Repository $repository;

    public function __construct(Category $category)
    {
        $this->repository = new Repository($category);
    }

    public function execute(CategoryDTO $categoryDTO, string $categoryId): Model
    {
        $category = $this->repository->show($categoryId);

        return $this->repository
            ->setModel($category)
            ->update($categoryDTO);
    }
}
