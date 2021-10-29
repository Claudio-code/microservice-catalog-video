<?php

namespace App\Services\Category;

use App\DTO\DataTransferObject;
use Illuminate\Database\Eloquent\Model;

class CreateCategoryService extends CategoryAbstractService
{
    public function execute(DataTransferObject $categoryDTO): Model
    {
        return $this->repository->create($categoryDTO);
    }
}
