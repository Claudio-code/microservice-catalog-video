<?php

namespace App\Factories;

use App\DTO\VideoDTO;
use App\Enums\RatingEnum;

class VideoDTOFactory
{
    public static function make(array $data): VideoDTO
    {
        /** @var int | string $rating */
        $rating = $data['rating'] ?? 0;
        $data['rating'] = RatingEnum::formatter(positionRating: $rating);

        return new VideoDTO($data);
    }
}
