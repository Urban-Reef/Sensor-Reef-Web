<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Point;
use App\Models\Reef;
use App\Models\Sensor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $reef = Reef::factory()->create();
            for ($i2 = 0; $i2 < 7; $i2++) {
                Point::factory([
                    'reef_id' => $reef->id,
                    'position' => $i2 + 1
                ])->has(Sensor::factory([
                    'type' => 'humidity',
                    'unit' => '%'
                ]))->has(Sensor::factory([
                    'type' => 'temperature',
                    'unit' => '°C'
                ]))->create();
            }
        }
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
