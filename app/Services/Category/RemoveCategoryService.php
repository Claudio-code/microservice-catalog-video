<?php

namespace App\Services\Category;

class RemoveCategoryService extends CategoryAbstractService
{
    public function execute(string $categoryId): void
    {
        $this->repository->delete($categoryId);
    }
}
