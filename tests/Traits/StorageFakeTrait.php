<?php

namespace Tests\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait StorageFakeTrait
{
    private function setStorageFake(): void
    {
        Storage::fake();
    }

    private function getStringRandomName(): string
    {
        return Str::random(8);
    }
}
