<?php

namespace App\Services;

use App\Enums\RedisKeysEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class GetOneCategoryService extends AbstractService
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
