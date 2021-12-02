<?php

namespace App\Services\Category;

use App\Enums\RedisKeysEnum;
use App\Enums\RedisTimeToLiveEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class GetOneCategoryService extends CategoryAbstractService
{
    public function execute(string $categoryId): Model
    {
        $key = RedisKeysEnum::REDIS_KEY_CATEGORY_BY_ID->value . $categoryId;

        return Cache::remember(
            $key,
            RedisTimeToLiveEnum::REDIS_TIME_TO_LIVE->value,
            fn () => $this->repository->show($categoryId)
        );
    }
}
