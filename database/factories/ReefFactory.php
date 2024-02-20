<?php

namespace Database\Factories;

use App\Models\Reef;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ReefFactory extends Factory
{
    protected $model = Reef::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'longitude' => $this->faker->longitude(),
            'latitude' => $this->faker->latitude(),
            'diagram' => $this->faker->imageUrl(),
            'placed_on' => Carbon::now(),
        ];
    }
}
