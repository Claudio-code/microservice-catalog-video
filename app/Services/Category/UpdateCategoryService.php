<?php

namespace App\Services\Category;

use App\DTO\CategoryDTO;
use Illuminate\Database\Eloquent\Model;

class UpdateCategoryService extends CategoryAbstractService
{
    public function execute(CategoryDTO $categoryDTO, string $categoryId): Model
    {
        $category = $this->repository->show($categoryId);

        return $this->repository
            ->setModel($category)
            ->update($categoryDTO);
    }
}
