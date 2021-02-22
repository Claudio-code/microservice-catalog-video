<?php

namespace Catalog\Category;

use App\Models\Category;
use Catalog\Repository;
use Illuminate\Database\Eloquent\Model;

class UpdateCategory
{
    private Repository $repository;

    public function __construct(Category $category)
    {
        $this->repository = new Repository($category);
    }

    public function execute(array $data, Category $category): Model
    {
        $this->repository->setModel($category);

        return $this->repository->update($data);
    }
}
