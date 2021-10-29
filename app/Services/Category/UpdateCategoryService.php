<?php

namespace App\Services\Category;

use App\DTO\DataTransferObject;
use Illuminate\Database\Eloquent\Model;

class UpdateCategoryService extends CategoryAbstractService
{
    public function execute(DataTransferObject $categoryDTO, string $categoryId): Model
    {
        $category = $this->repository->show($categoryId);

        return $this->repository
            ->setModel($category)
            ->update($categoryDTO);
    }
}
