<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class GetOneCategoryService
{
    private Repository $repository;

    private const REDIS_KEY = 'micro-videos-category-id:';

    private const REDIS_TIME_TO_LIVE = 1440;

    public function __construct(Category $category)
    {
        $this->repository = new Repository($category);
    }

    public function execute(string $categoryId): Model
    {
        return Cache::remember(
            self::REDIS_KEY.$categoryId,
            self::REDIS_TIME_TO_LIVE,
            fn () => $this->repository->show($categoryId)
        );
    }
}
