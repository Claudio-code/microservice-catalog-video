<?php

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class VideoFactory extends Factory
{
    /** @var string */
    protected $model = Video::class;

    #[ArrayShape([
        'title' => "string",
        'description' => "string",
        'year_launched' => "int",
        'opened' => "int",
        'rating' => "string",
        'duration' => "int"
    ])]
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(10),
            'year_launched' => rand(1866, 2000),
            'opened' => rand(0, 1),
            'rating' => '',
            'duration' => rand(1, 30),
        ];
    }
}
