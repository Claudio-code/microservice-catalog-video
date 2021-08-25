<?php

namespace App\Services;

use App\Enums\RedisKeysEnum;
use App\Models\Category;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class GetOneCategoryService
{
    private Repository $repository;

    public function __construct(Category $category)
    {
        $this->repository = new Repository($category);
    }

    public function execute(string $categoryId): Model
    {
        $key = RedisKeysEnum::REDIS_KEY_CATEGORY_BY_ID.$categoryId;

        return Cache::remember(
            $key,
            RedisKeysEnum::REDIS_TIME_TO_LIVE,
            fn () => $this->repository->show($categoryId)
        );
    }
}
