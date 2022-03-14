<?php

namespace App\DTO;

use Illuminate\Support\Collection;

abstract class DataTransferObject
{
    public final function toArray(): array
    {
        return get_object_vars($this);
    }

    public final function toCollection(): Collection
    {
        return Collection::make($this->toArray());
    }
}
