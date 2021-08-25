<?php

namespace App\Services;

use App\Enums\RedisKeysEnum;
use App\Models\Category;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class GetAllCategoriesService
{
    private Repository $repository;

    public function __construct(Category $category)
    {
        $this->repository = new Repository($category);
    }

    public function execute(): Collection
    {
        return Cache::remember(
            RedisKeysEnum::REDIS_KEY_ALL_CATEGORIES,
            RedisKeysEnum::REDIS_TIME_TO_LIVE,
            fn () => $this->repository->all()
        );
    }
}
