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
        /* Create models in database for testing
         * Create a Reef with 2 points.
         * 1 point with position 0 for environmental monitoring.
         * 1 point with a random position for point monitoring.
         */
        $fakeReef = Reef::factory()
            ->has(Point::factory(['position' => 1])
                ->has(Sensor::factory())
            )
            ->has(Point::factory(['position' => 0]))
            ->create();
        //sort the points array based on position so position reflects the index.
        $fakeReef->points->sortBy('position')->values();

        //Get the id of the latest monitoring session and add 1.
        //If none exist set to 1.
        $correctSessionId = (MonitoringSession::latest()->first()?->id ?? 0) + 1;
        //Do the same for sample.
        $correctSampleId = (Sample::latest()->first()?->id ?? 0) + 1;

        //data object has been broken up for the sake of readability.
        //Environment = point 0.
        $point0 = [
            'photos' => [
                UploadedFile::fake()->image('left.jpg'),
                UploadedFile::fake()->image('front.jpg'),
                UploadedFile::fake()->image('right.jpg'),
            ],
            'entries' => [
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
            ]
        ];
        $point1 = [
            'photos' => [UploadedFile::fake()->image('closeUpPhoto.jpg')],
            'sample' => true,
            'sensors' => [
                [
                    'id' => $fakeReef->points[1]['sensors'][0]->id,
                    'value' => 10,
                    'measuredAt' => Carbon::now()
                ]
            ],
            'entries' => [
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
            ]
        ];
        $data = [
            'reefId' => $fakeReef->id,
            'points' => [$point0, $point1] //Index corresponds with point position.
        ];

        $response = $this->post('/session', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('sessions', [
            'id' => $correctSessionId,
        ]);
        //Environment assertions (point 0)
        foreach ($point0['photos'] as $photo) {
            $this->assertDatabaseHas('point_photos', [
                'point_id' => $fakeReef->points[0]->id,
                'session_id' => $correctSessionId,
                'url' => $photo->hashName()
            ]);
        }
        foreach ($point0['entries'] as $entry) {
            $this->assertDatabaseHas('biodiversity_entries', [
                'session_id' => $correctSessionId,
                'point_id' => $fakeReef->points[0]->id,
                'photo' => $entry['photo']->hashName(),
                'species' => $entry['species'],
                'count' => $entry['count']
            ]);
        }

        //Point assertions (point 1)
        $this->assertDatabaseHas('point_photos', [
            'point_id' => $fakeReef->points[1]->id,
            'session_id' => $correctSessionId,
            'url' => $point1['photos'][0]->hashName()
        ]);
        $this->assertDatabaseHas('samples', [
            'id' => $correctSampleId,
            'session_id' => $correctSessionId,
            'point_id' => $fakeReef->points[1]->id,
        ]);
        $this->assertDatabaseHas('sensor_data', [
            'sensor_id' => $fakeReef->points[1]->sensors[0]->id,
            'value' => $point1['sensors'][0]['value'],
            'measured_at' => $point1['sensors'][0]['measuredAt']
        ]);
        foreach ($point1['entries'] as $entry) {
            $this->assertDatabaseHas('biodiversity_entries', [
                'session_id' => $correctSessionId,
                'point_id' => $fakeReef->points[0]->id,
                'photo' => $entry['photo']->hashName(),
                'species' => $entry['species'],
                'count' => $entry['count']
            ]);
        }

    }
}
