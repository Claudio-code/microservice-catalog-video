<?php

namespace App\Repositories;

use App\DTO\DataTransferObject;
use App\DTO\VideoDTO;
use App\Models\Video;
use Exception;
use Illuminate\Database\Eloquent\Model;

class VideoRepository extends Repository
{
    /**
     * @throws Exception
     */
    public function create(VideoDTO | DataTransferObject $dataTransferObject): Model
    {
        if ($this->model instanceof Video && $dataTransferObject instanceof VideoDTO) {
            $videoCreated = $this->model->createVideo($dataTransferObject);
            $this->setModel($videoCreated);
        }

        return $this->model;
    }

    /** @throws Exception */
    public function update(VideoDTO | DataTransferObject $dataTransferObject): Model
    {
        if ($this->model instanceof Video && $dataTransferObject instanceof VideoDTO) {
            $this->model->updateVideo($dataTransferObject);
        }

        return $this->model;
    }
}
