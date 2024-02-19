<?php

namespace Tests\Feature;

use App\Models\Reef;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ReefCreationTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithoutMiddleware;

    /** @test */
    public function test_storing_reef_with_points_sensors()
    {
        Storage::fake('public');
        $data = [
            'name' => 'Feature Test',
            'longitude' => 123.123456,
            'latitude' => 67.123456,
            'placedOn' => '2023-12-01',
            'diagram' => UploadedFile::fake()->image('diagram.jpg'),
            'points' => [
                ['sensors' => [
                    ['type' => 'humidity', 'unit' => '%'],
                    ['type' => 'temperature', 'unit' => 'C°']
                ]],
                ['sensors' => [
                    ['type' => 'humidity', 'unit' => '%']
                ]]
            ]
        ];

        $response = $this->post('/reefs', $data);

        $response->assertStatus(302); // Assuming successful redirect

        $this->assertDatabaseHas('reefs', [
            'name' => $data['name'],
            'longitude' => $data['longitude'],
            'latitude' => $data['latitude'],
            'placed_on' => $data['placedOn'],
            'diagram' => $data['diagram']->hashName()
        ]);
        // Add assertions for diagram storage
        Storage::disk('public')->assertExists($data['diagram']->hashName());

        //assert points
        $this->assertDatabaseHas('points', [
            'reef_id' => 1,
            'position' => 1
        ]);
        $this->assertDatabaseHas('points', [
            'reef_id' => 1,
            'position' => 2
        ]);

        //assert sensors
        $this->assertDatabaseHas('sensors', [
            'point_id' => 1,
            'type' => $data['points'][0]['sensors'][0]['type'],
            'unit' => $data['points'][0]['sensors'][0]['unit']
        ]);
        $this->assertDatabaseHas('sensors', [
            'point_id' => 1,
            'type' => $data['points'][0]['sensors'][1]['type'],
            'unit' => $data['points'][0]['sensors'][1]['unit']
        ]);
        $this->assertDatabaseHas('sensors', [
            'point_id' => 2,
            'type' => $data['points'][1]['sensors'][0]['type'],
            'unit' => $data['points'][1]['sensors'][0]['unit']
        ]);
    }
}
