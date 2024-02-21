<?php

namespace Database\Factories;

use App\Models\Point;
use App\Models\Reef;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PointFactory extends Factory
{
    protected $model = Point::class;

    public function definition(): array
    {
        return [
            'reef_id' => Reef::factory(),
            'position' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
