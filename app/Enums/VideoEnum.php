<?php

namespace App\Enums;

enum VideoEnum: int
{
    case THUMB_FILE_MAX_SIZE = 5120; //5MB
    case BANNER_FILE_MAX_SIZE = 10240; //10MB
    case TRAILER_FILE_MAX_SIZE = 1048576; //1GB
    case VIDEO_FILE_MAX_SIZE = 52428800; //50GB
}
