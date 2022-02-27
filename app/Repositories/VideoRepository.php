<?php

namespace App\Repositories;

use App\DTO\DataTransferObject;
use App\DTO\VideoDTO;
use App\Models\Video;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class VideoRepository extends Repository
{
    /** @throws Exception */
    public function createVideo(VideoDTO | DataTransferObject $dataTransferObject): Model
    {
        if ($this->model instanceof Video && $dataTransferObject instanceof VideoDTO) {
            $videoCreated = $this->model->createVideo($dataTransferObject);
            $this->setModel($videoCreated);
        }

        return $this->model;
    }

    /** @throws Exception */
    public function updateVideo(VideoDTO | DataTransferObject $dataTransferObject): Model
    {
        if ($this->model instanceof Video && $dataTransferObject instanceof VideoDTO) {
            $this->model->updateVideo($dataTransferObject);
        }

        return $this->model;
    }

    public function deleteVideo(string $videoId): void
    {
        /** @var Video $video */
        $video = $this->show($videoId);
        $video->deleteFile($video->video_file);
        $this->delete($videoId);
    }
}
