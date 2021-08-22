<?php

namespace Database\Factories;

use App\Models\CastMember;
use Illuminate\Database\Eloquent\Factories\Factory;

class CastMemberFactory extends Factory
{
    protected $model = CastMember::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'type' => array_rand([CastMember::TYPE_ACTOR, CastMember::TYPE_DIRECTOR]),
        ];
    }
}
