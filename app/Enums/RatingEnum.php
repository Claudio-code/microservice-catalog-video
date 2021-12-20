<?php

namespace App\Enums;

enum RatingEnum: string
{
    case FREE = 'L';
    case TEEN_YEARS = '10';
    case TWELVE_YEARS = '12';
    case FOURTEEN_YEARS = '14';
    case SIXTEEN_YEARS = '16';
    case EIGHTEEN_YEARS = '18';

    public static function formatter(int | string $positionRating): string
    {
        return match ($positionRating) {
            1, '1' => RatingEnum::TEEN_YEARS->value,
            2, '2' => RatingEnum::TWELVE_YEARS->value,
            3, '3' => RatingEnum::FOURTEEN_YEARS->value,
            4, '4' => RatingEnum::SIXTEEN_YEARS->value,
            5, '5' => RatingEnum::EIGHTEEN_YEARS->value,
            default => RatingEnum::FREE->value,
        };
    }
}
