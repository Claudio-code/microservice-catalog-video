<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class GetAllCategoriesService
{
    private Repository $repository;

    private const REDIS_KEY = 'micro-videos-all-categories';

    private const REDIS_TIME_TO_LIVE = 1440;

    public function __construct(Category $category)
    {
        $this->repository = new Repository($category);
    }

    public function execute(): Collection
    {
        return Cache::remember(
            self::REDIS_KEY,
            self::REDIS_TIME_TO_LIVE,
            fn () => $this->repository->all()
        );
    }
}
