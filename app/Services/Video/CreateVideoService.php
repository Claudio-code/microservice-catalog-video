<?php

namespace App\Services\Video;

use App\DTO\DataTransferObject;
use Illuminate\Database\Eloquent\Model;

class CreateVideoService extends VideoAbstractService
{
    public function execute(DataTransferObject $videoDTO): Model
    {
        return $this->repository->create($videoDTO);
    }
}
