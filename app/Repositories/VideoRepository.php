<?php

namespace App\Repositories;

use App\DTO\DataTransferObject;
use App\DTO\VideoDTO;
use App\Models\Video;
use Exception;
use Illuminate\Database\Eloquent\Model;

class VideoRepository extends Repository
{
    /** @throws Exception */
    public function createVideo(VideoDTO | DataTransferObject $dataTransferObject): Model
    {
        $model = match ($this->model instanceof Video && $dataTransferObject instanceof VideoDTO) {
            true => $this->model->createVideo($dataTransferObject),
            default => $this->getModel(),
        };
        $this->setModel($model);
        return $model;
    }

    /** @throws Exception */
    public function updateVideo(VideoDTO | DataTransferObject $dataTransferObject): Model
    {
        $model = match ($this->model instanceof Video && $dataTransferObject instanceof VideoDTO) {
            true => $this->model->updateVideo($dataTransferObject),
            default => $this->getModel(),
        };
        $this->setModel($model);
        return $model;
    }

    public function deleteVideo(string $videoId): void
    {
        /** @var Video $video */
        $video = $this->show($videoId);
        $this->deleteFiles($video);
        $this->delete($videoId);
    }

    private function deleteFiles(Video $video): void
    {
        $video->deleteFile($video->video_file);
        $video->deleteFile($video->banner_file);
        $video->deleteFile($video->thumb_file);
        $video->deleteFile($video->trailer_file);
    }
}
