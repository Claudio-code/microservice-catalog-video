<?php

namespace App\Services\Category;

use App\Enums\RedisKeysEnum;
use App\Enums\RedisTimeToLiveEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class GetAllCategoriesService extends CategoryAbstractService
{
    public function execute(): Collection
    {
        return Cache::remember(
            RedisKeysEnum::REDIS_KEY_ALL_CATEGORIES->value,
            RedisTimeToLiveEnum::REDIS_TIME_TO_LIVE->value,
            fn () => $this->repository->all()
        );
    }
}
