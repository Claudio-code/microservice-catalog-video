<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Services\AbstractService;
use JetBrains\PhpStorm\Pure;

abstract class CategoryAbstractService extends AbstractService
{
    #[Pure]
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }
}
