<?php

namespace App\Services;

use App\DTO\CategoryDTO;
use Illuminate\Database\Eloquent\Model;

class CreateCategoryService extends AbstractService
{
    public function execute(CategoryDTO $categoryDTO): Model
    {
        return $this->repository->create($categoryDTO);
    }
}
