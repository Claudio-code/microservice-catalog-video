<?php

namespace App\Services\Video;

use App\DTO\DataTransferObject;
use Illuminate\Database\Eloquent\Model;

class CreateVideoService extends VideoAbstractService
{
    public function execute(DataTransferObject $videoDTO): Model
    {
        $videoCreated = $this->repository->create($videoDTO);

        return $videoCreated;
    }
}
