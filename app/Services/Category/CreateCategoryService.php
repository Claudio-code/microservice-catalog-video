<?php

namespace App\Services\Category;

use App\DTO\CategoryDTO;
use Illuminate\Database\Eloquent\Model;

class CreateCategoryService extends CategoryAbstractService
{
    public function execute(CategoryDTO $categoryDTO): Model
    {
        return $this->repository->create($categoryDTO);
    }
}
