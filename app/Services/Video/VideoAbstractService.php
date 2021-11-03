<?php

namespace App\Services\Video;

use App\Models\Video;
use App\Repositories\VideoRepository;
use App\Services\AbstractService;

abstract class VideoAbstractService extends AbstractService
{
    public function __construct(Video $video)
    {
        $this->repository = new VideoRepository($video);
    }
}
