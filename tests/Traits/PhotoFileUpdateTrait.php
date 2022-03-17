<?php

namespace Tests\Traits;

use Illuminate\Http\UploadedFile;

trait PhotoFileUpdateTrait
{
    use StorageFakeTrait;

    private function getValidPhoto(): UploadedFile
    {
        $this->setStorageFake();
        return UploadedFile::fake()->image("{$this->getStringRandomName()}.jpg");
    }

    private function getInvalidPhoto(): UploadedFile
    {
        $this->setStorageFake();
        return UploadedFile::fake()->image(
            name: "{$this->getStringRandomName()}.jpg",
            width: 900000,
            height: 900000,
        );
    }
}
