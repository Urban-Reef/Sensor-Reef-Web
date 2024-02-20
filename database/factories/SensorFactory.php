<?php

namespace Database\Factories;

use App\Models\Point;
use App\Models\Sensor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SensorFactory extends Factory
{
    protected $model = Sensor::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->word(),
            'unit' => $this->faker->randomLetter(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'point_id' => Point::factory(),
        ];
    }
}
