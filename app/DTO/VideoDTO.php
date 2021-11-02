<?php

namespace App\DTO;

use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class VideoDTO extends DataTransferObject
{
    public string $title;
    public string $description;
    public bool $opened;
    public int $rating;
    public int $duration;
    public int $year_launched;

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
