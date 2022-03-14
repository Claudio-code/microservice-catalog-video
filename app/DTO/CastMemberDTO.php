<?php

namespace App\DTO;

class CastMemberDTO extends DataTransferObject
{
    public function __construct(
        public readonly string $name,
        public readonly ?int $type = null,
    ) {}
}
