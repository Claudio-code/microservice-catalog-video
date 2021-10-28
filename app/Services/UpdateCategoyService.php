<?php

namespace App\Services;

use App\DTO\CategoryDTO;
use Illuminate\Database\Eloquent\Model;

class UpdateCategoyService extends AbstractService
{
    public function execute(CategoryDTO $categoryDTO, string $categoryId): Model
    {
        $category = $this->repository->show($categoryId);

        return $this->repository
            ->setModel($category)
            ->update($categoryDTO);
    }
}
