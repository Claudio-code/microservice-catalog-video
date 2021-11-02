<?php

namespace App\DTO;

use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CastMemberDTO extends DataTransferObject
{
    public string $name;
    public int $type;

    /**
     * @param array<string, mixed> $data
     *
     * @throws UnknownProperties
     */
    public static function factory(array $data): self
    {
        return new self($data);
    }
}
