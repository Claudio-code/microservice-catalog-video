<?php

namespace App\Services;

class RemoveCategoryService extends AbstractService
{
    public function execute(string $categoryId): void
    {
        $this->repository->delete($categoryId);
    }
}
