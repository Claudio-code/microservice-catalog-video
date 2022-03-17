<?php

namespace Tests\Traits;

use Illuminate\Http\UploadedFile;

trait VideoFileUpdateTrait
{
    use StorageFakeTrait;

    private function getValidFileVideo(): UploadedFile
    {
        $this->setStorageFake();
        return UploadedFile::fake()->create("{$this->getStringRandomName()}.mp4");
    }

    private function getInvalidFilePhoto(): UploadedFile
    {
        $this->setStorageFake();
        return UploadedFile::fake()->create($this->getStringRandomName());
    }
}
