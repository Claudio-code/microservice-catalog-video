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

    public static function formatter(int | string $positionRating): RatingEnum
    {
        return match ($positionRating) {
            1, '1' => RatingEnum::TEEN_YEARS,
            2, '2' => RatingEnum::TWELVE_YEARS,
            3, '3' => RatingEnum::FOURTEEN_YEARS,
            4, '4' => RatingEnum::SIXTEEN_YEARS,
            5, '5' => RatingEnum::EIGHTEEN_YEARS,
            default => RatingEnum::FREE,
        };
    }
}
