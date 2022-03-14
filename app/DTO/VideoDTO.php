<?php

namespace App\DTO;

use Illuminate\Http\UploadedFile;

class VideoDTO extends DataTransferObject
{
    public function __construct(
        public readonly string $title,
        public readonly bool $opened,
        public readonly string $rating,
        public readonly int $duration,
        public readonly int $year_launched,
        public readonly ?string $description = null,
        public readonly array $categories_ids = [],
        public readonly array $genres_ids = [],
        public readonly ?UploadedFile $video_file = null,
        public readonly ?UploadedFile $thumb_file = null,
        public readonly ?UploadedFile $banner_file = null,
        public readonly ?UploadedFile $trailer_file = null,
    ) {}
}
