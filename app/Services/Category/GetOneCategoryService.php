<?php

namespace App\Services\Category;

use App\Enums\RedisKeysEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class GetOneCategoryService extends CategoryAbstractService
{
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
