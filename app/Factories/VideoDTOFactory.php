<?php

namespace App\Factories;

use App\DTO\VideoDTO;
use App\Enums\RatingEnum;
use Illuminate\Http\Request;

class VideoDTOFactory extends AbstractFactory
{
    protected function build(Request $request): VideoDTO
    {
        $data = $request->all();
        /** @var int | string $rating */
        $rating = $data['rating'] ?? 0;
        $data['rating'] = RatingEnum::formatter(positionRating: $rating);
        return new VideoDTO(...$data);
    }
}
