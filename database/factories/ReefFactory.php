<?php

namespace Database\Factories;

use App\Models\Point;
use App\Models\Reef;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ReefFactory extends Factory
{
    protected $model = Reef::class;

    public function definition(): array
    {
        return [
            'name' => fake()->scientist,
            'longitude' => $this->faker->longitude(),
            'latitude' => $this->faker->latitude(),
            'diagram' => $this->faker->imageUrl(),
            'placed_on' => Carbon::now(),
        ];
    }

    public function configure(): ReefFactory
    {
        return $this->afterCreating(function (Reef $reef) {
            // Create point with position 0
            $reef->points()->create([
                'position' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        });
    }
}
