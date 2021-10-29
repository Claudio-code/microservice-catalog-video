<?php

namespace App\Services\Video;

use App\DTO\VideoDTO;
use Illuminate\Database\Eloquent\Model;

class CreateVideoService extends VideoAbstractService
{
    public function execute(VideoDTO $videoDTO): Model
    {
        return $this->repository->create($videoDTO);
    }
}
