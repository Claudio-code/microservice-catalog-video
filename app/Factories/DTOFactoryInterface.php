<?php

namespace App\Factories;

use App\DTO\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

interface DTOFactoryInterface
{
    /**
     * @param array<string, mixed> $data
     * @throws UnknownProperties
     */
    public static function make(array $data): DataTransferObject;
}
