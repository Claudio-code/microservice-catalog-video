<?php


namespace Catalog\Category\FindOneCategory;


use App\Models\Category;
use Catalog\Repository;
use Illuminate\Database\Eloquent\Model;

class FindOneCategoryFeature
{
    private Repository $repository;

    public function __construct(Category $category)
    {
        $this->repository = new Repository($category);
    }

    public function execute(string $categoryId): ?Model
    {
        return $this->repository->show($categoryId);
    }
}
