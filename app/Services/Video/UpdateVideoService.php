<?php

namespace App\Services\Video;

use App\DTO\DataTransferObject;
use Illuminate\Database\Eloquent\Model;

class UpdateVideoService extends VideoAbstractService
{
    public function execute(DataTransferObject $videoDTO, string $videoId): Model
    {
        $video = $this->repository->show($videoId);

        return $this->repository
            ->setModel($video)
            ->updateVideo($videoDTO);
    }
}
