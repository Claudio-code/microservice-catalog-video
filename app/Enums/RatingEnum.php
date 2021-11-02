<?php

namespace App\Enums;

class RatingEnum
{
    public const FREE = 'L';
    public const TEEN_YEARS = '10';
    public const TWELVE_YEARS = '12';
    public const FOURTEEN_YEARS = '14';
    public const SIXTEEN_YEARS = '16';
    public const EIGHTEEN_YEARS = '18';

    public static function formatter(int $positionRating): string
    {
        return match ($positionRating) {
            1 => self::TEEN_YEARS,
            2 => self::TWELVE_YEARS,
            3 => self::FOURTEEN_YEARS,
            4 => self::SIXTEEN_YEARS,
            5 => self::EIGHTEEN_YEARS,
            default => self::FREE,
        };
    }
}
