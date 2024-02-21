<?php

namespace Tests\Feature;

use App\Models\MonitoringSession;
use App\Models\Point;
use App\Models\Reef;
use App\Models\Sample;
use App\Models\Sensor;
use Carbon\Carbon;
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
        //create models in database for testing
        $fakeReef = Reef::factory()->has(
            Point::factory()->has(
                Sensor::factory()
            )
        )->create();
        $latestSession = MonitoringSession::latest()->first();
        $correctSessionId = $latestSession ? $latestSession->id + 1 : 1;
        $latestSample = Sample::latest()->first();
        $correctSampleId = $latestSample ? $latestSample->id : 1;


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
                    'id' => $fakeReef->points[0]['sensors'][0]->id,
                    'value' => 10,
                    'measuredAt' => Carbon::now()
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
            'points' => [$point] //track points though array index. Sort array on 'position'.
        ];

        $response = $this->post('/session', $data);

        $response->assertStatus(302);

        $this->assertDatabaseHas('sessions', [
            'id' => $correctSessionId,
            'photo_right' => $data['environment']['right']->hashName(),
            'photo_front' => $data['environment']['front']->hashName(),
            'photo_left' => $data['environment']['left']->hashName()
        ]);

        $this->assertDatabaseHas('point_photos', [
            'point_id' => $fakeReef->points[0]->id,
            'session_id' => $correctSessionId,
            'url' => $point['photo']->hashName()
        ]);
        $this->assertDatabaseHas('samples', [
            'id' => $correctSampleId,
            'session_id' => $correctSessionId,
            'point_id' => $fakeReef->points[0]->id,
        ]);
        $this->assertDatabaseHas('sensor_data', [
            'sensor_id' => $fakeReef->points[0]->sensors[0]->id,
            'value' => $point['sensors'][0]['value'],
            'measured_at' => $point['sensors'][0]['measuredAt']
        ]);

        //TODO: Assert biodiversityEntries

    }
}
