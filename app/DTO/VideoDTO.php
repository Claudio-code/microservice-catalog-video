<?php

namespace App\DTO;

use App\Enums\RatingEnum;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class VideoDTO extends DataTransferObject
{
    public string $title;
    public string $description;
    public bool $opened;
    public string $rating;
    public int $duration;
    public int $year_launched;

    /** @var array<string> */
    public array $categories_ids = [];

    /** @var array<string> */
    public array $genres_ids = [];

    /**
     * @param array<string, mixed> $data
     *
     * @throws UnknownProperties
     */
    public static function factory(array $data): self
    {
        $data['rating'] = RatingEnum::formatter($data['rating'] ?? 0);
        return new self($data);
    }
}
