<?php

namespace App\Services\Video;

use App\Models\Video;
use App\Repositories\VideoRepository;
use JetBrains\PhpStorm\Pure;

abstract class VideoAbstractService
{
    protected VideoRepository $repository;

    #[Pure]
    public function __construct(Video $video)
    {
        $this->repository = new VideoRepository($video);
    }
}
