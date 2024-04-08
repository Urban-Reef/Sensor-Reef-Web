<?php

namespace Tests\Feature;

use App\Models\Point;
use App\Models\Reef;
use App\Models\Sensor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreSensorDataTest extends TestCase
{
    use RefreshDatabase;

    public function testOnStoreSuccess()
    {
        $fakeReef = Reef::factory()
            ->has(Point::factory()->has(Sensor::factory()->count(2))->count(2))
            ->create();

        $uplinkMessage = [
            'decoded_payload' => [
                'points' => [
                    [
                        'position' => $fakeReef->points[0]->position,
                        $fakeReef->points[0]->sensors[0]->type => 47.5,
                        $fakeReef->points[0]->sensors[1]->type => 20.1
                    ],
                    [
                        'position' => $fakeReef->points[1]->position,
                        $fakeReef->points[1]->sensors[0]->type => 49,
                        $fakeReef->points[1]->sensors[1]->type => 19.9
                    ],
                ],
                'reefId' => $fakeReef->id
            ]];

        $response = $this->postJson('/api/storeSensorData', $uplinkMessage);
        $response->assertStatus(200);

        //assert if values have been stored in database.
        foreach ($fakeReef->points as $pointIndex => $point){
            foreach ($point->sensors as $sensorIndex => $sensor) {
                $this->assertDatabaseHas('sensor_data', [
                    'sensor_id' => $sensor->id,
                    'value' => $uplinkMessage['decoded_payload']['points'][$pointIndex][$sensor->type]
                ]);
            }
        }
    }
}
