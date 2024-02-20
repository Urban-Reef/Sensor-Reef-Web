<?php

namespace Tests\Feature;

use App\Models\Point;
use App\Models\Reef;
use App\Models\Sensor;
use Faker\Core\Number;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MonitoringSessionTest extends TestCase
{
    use RefreshDatabase;

    public function testStoringSession()
    {
        Storage::fake('public');
        $fakeReef = Reef::factory()->create();
        $fakeSensor = Sensor::factory()->create();

        //data object has been broken up for the sake of readability.
        $environmentEntries = [
            [
                'photo' => UploadedFile::fake()->image('entry1.jpg'),
                'count' => 1,
                'species' => 'ant'
            ],
            [
                'photo' => UploadedFile::fake()->image('entry2.jpg'),
                'count' => 2,
                'species' => 'lichen'
            ]
        ];
        $pointEntries = [
            [
                'photo' => UploadedFile::fake()->image('entry3.jpg'),
                'count' => 3,
                'species' => 'spider'
            ],
            [
                'photo' => UploadedFile::fake()->image('entry4.jpg'),
                'count' => 4,
                'species' => 'woodlouse'
            ],
        ];
        $point = [
            'photo' => UploadedFile::fake()->image('closeUpPhoto.jpg'),
            'sample' => true,
            'sensors' => [
                [
                    'id' => $fakeSensor->id,
                    'value' => 10,
                ]
            ],
            'entries' => $pointEntries
        ];
        $data = [
            'reefId' => $fakeReef->id,
            'environment' => [
                'left' => UploadedFile::fake()->image('left.jpg'),
                'front' => UploadedFile::fake()->image('front.jpg'),
                'right' => UploadedFile::fake()->image('right.jpg'),
                'entries' => $environmentEntries
            ],
            'points' => [$point]
        ];

        $response = $this->post('/session', $data);

        /* TODO: Assert
         * environment photos.
         * environment entries.
         * point photo
         * sample
         * sensor data
         * entries
         */

        $response->assertStatus(302);
    }
}
