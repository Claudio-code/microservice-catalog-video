<?php

namespace App\Services;

use App\Enums\RedisKeysEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class GetAllCategoriesService extends AbstractService
{
    public function execute(): Collection
    {
        return Cache::remember(
            RedisKeysEnum::REDIS_KEY_ALL_CATEGORIES,
            RedisKeysEnum::REDIS_TIME_TO_LIVE,
            fn () => $this->repository->all()
        );
    }
}
