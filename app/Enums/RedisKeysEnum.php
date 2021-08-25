<?php

namespace App\Enums;

class RedisKeysEnum
{
    public const REDIS_TIME_TO_LIVE = 1440;
    public const REDIS_KEY_ALL_CATEGORIES = 'micro-videos-all-categories';
    public const REDIS_KEY_CATEGORY_BY_ID = 'micro-videos-category-id=';
    public const REDIS_KEY_ALL_GENRES = 'micro-videos-all-genres';
    public const REDIS_KEY_GENRE_BY_ID = 'micro-videos-genre-id=';
    public const REDIS_KEY_ALL_CAST_MEMBER = 'micro-videos-all-cast-member';
    public const REDIS_KEY_CAST_MEMBER_BY_ID = 'micro-videos-cast-member-id=';
}
