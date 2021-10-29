<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Services\AbstractService;

abstract class CategoryAbstractService extends AbstractService
{
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }
}
