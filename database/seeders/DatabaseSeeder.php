<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Point;
use App\Models\Reef;
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
            for ($i2 = 0; $i2 < 5; $i2++) {
                Point::factory([
                    'reef_id' => $reef->id,
                    'position' => $i2 + 1
                ])->hasSensors(2)->create();
            }
        }
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
