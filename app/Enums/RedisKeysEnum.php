<?php

namespace App\Enums;

enum RedisKeysEnum: string
{
    case REDIS_KEY_ALL_CATEGORIES = 'micro-videos-all-categories';
    case REDIS_KEY_CATEGORY_BY_ID = 'micro-videos-category-id=';
    case REDIS_KEY_ALL_GENRES = 'micro-videos-all-genres';
    case REDIS_KEY_GENRE_BY_ID = 'micro-videos-genre-id=';
    case REDIS_KEY_ALL_CAST_MEMBER = 'micro-videos-all-cast-member';
    case REDIS_KEY_CAST_MEMBER_BY_ID = 'micro-videos-cast-member-id=';
    case REDIS_KEY_VIDEO_BY_ID = 'micro-videos-video-id=';
    case REDIS_KEY_ALL_VIDEOS = 'micro-videos-all-videos';
}
