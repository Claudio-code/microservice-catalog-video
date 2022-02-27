<?php

namespace Tests\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait VideoFileUpdateTrait
{
    private function getValidFileVideo(): UploadedFile
    {
        $this->setStorageFake();
        return UploadedFile::fake()->create("{$this->getStringVideoName()}.mp4");
    }

    private function getInvalidFilePhoto(): UploadedFile
    {
        $this->setStorageFake();
        return UploadedFile::fake()->create($this->getStringVideoName());
    }

    private function setStorageFake(): void
    {
        Storage::fake();
    }

    private function getStringVideoName(): string
    {
        return Str::random(8);
    }
}
