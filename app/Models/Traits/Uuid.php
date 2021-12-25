<?php

namespace App\Models\Traits;

use Ramsey\Uuid\Uuid as RamseyUuid;

trait Uuid
{
    public static function boot(): void
    {
        parent::boot();
        static::creating(fn(object $object) => $object->id ?? $object->id = RamseyUuid::uuid4());
    }
}
