<?php

namespace App\DTO;

class VideoDTO extends DataTransferObject
{
    public string $title;
    public string $description;
    public bool $opened;
    public int $rating;
    public int $duration;
    public int $year_launched;
}
