<?php

namespace App\DTO;

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
}
