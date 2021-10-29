<?php

namespace App\Services\Video;

use App\Models\Video;
use App\Services\AbstractService;

class VideoAbstractService extends AbstractService
{
    public function __construct(Video $video)
    {
        parent::__construct($video);
    }
}
