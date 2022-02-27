<?php

namespace App\Services\Video;

class RemoveVideoService extends VideoAbstractService
{
    public function execute(string $videoId): void
    {
        $this->repository->deleteVideo($videoId);
    }
}
