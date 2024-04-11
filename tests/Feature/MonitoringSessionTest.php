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

    public function testOnStoringSessionSuccess()
    {
        Storage::fake('public');
        /* Create models in database for testing
         * Create a Reef with 2 points.
         * 1 point with position 0 for environmental monitoring.
         * 1 point with a sensor.
         */
        $fakeReef = Reef::factory()->has(
            Point::factory(['position' => 1])->hasSensors()
        )->create();
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
            'id' => $fakeReef->points[0]->id,
            'photos' => [
                UploadedFile::fake()->image('left.jpg'),
                UploadedFile::fake()->image('front.jpg'),
                UploadedFile::fake()->image('right.jpg'),
            ],
            'entries' => [
                [
                    'photo' => UploadedFile::fake()->image('entry1.jpg'),
                    'count' => 1,
                    'species' => fake()->plant
                ],
                [
                    'photo' => UploadedFile::fake()->image('entry2.jpg'),
                    'count' => 2,
                    'species' => fake()->plant
                ]
            ]
        ];
        $point1 = [
            'id' => $fakeReef->points[1]->id,
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
                    'species' => fake()->plant
                ],
                [
                    'photo' => UploadedFile::fake()->image('entry4.jpg'),
                    'count' => 4,
                    'species' => null
                ],
            ]
        ];
        $data = [
            'points' => [$point0, $point1] //Index corresponds with point position.
        ];

        $response = $this->post(route('reefs.session.store', ['reef' => $fakeReef->id]), $data);
        $response->assertStatus(302);

        //Session created?
        $this->assertDatabaseHas('sessions', [
            'id' => $correctSessionId,
        ]);

        //Environment assertions (point 0)
        //assert photos are stored.
        foreach ($point0['photos'] as $photo) {
            $this->assertDatabaseHas('point_photos', [
                'point_id' => $fakeReef->points[0]->id,
                'monitoring_session_id' => $correctSessionId,
                'url' => $photo->hashName()
            ]);
        }
        //assert biodiversity entries have been stored.
        foreach ($point0['entries'] as $entry) {
            $this->assertDatabaseHas('biodiversity_entries', [
                'monitoring_session_id' => $correctSessionId,
                'point_id' => $fakeReef->points[0]->id,
                'photo' => $entry['photo']->hashName(),
                'species' => $entry['species'],
                'count' => $entry['count']
            ]);
        }

        //Point assertions (point 1)
        $this->assertDatabaseHas('point_photos', [
            'point_id' => $fakeReef->points[1]->id,
            'monitoring_session_id' => $correctSessionId,
            'url' => $point1['photos'][0]->hashName()
        ]);
        $this->assertDatabaseHas('samples', [
            'id' => $correctSampleId,
            'monitoring_session_id' => $correctSessionId,
            'point_id' => $fakeReef->points[1]->id,
        ]);
        $this->assertDatabaseHas('sensor_data', [
            'sensor_id' => $fakeReef->points[1]->sensors[0]->id,
            'value' => $point1['sensors'][0]['value'],
            'measured_at' => $point1['sensors'][0]['measuredAt']
        ]);
        foreach ($point1['entries'] as $entry) {
            $this->assertDatabaseHas('biodiversity_entries', [
                'monitoring_session_id' => $correctSessionId,
                'point_id' => $fakeReef->points[1]->id,
                'photo' => $entry['photo']->hashName(),
                'species' => $entry['species'],
                'count' => $entry['count']
            ]);
        }
    }
    public function testOnValidationFail()
    {
        $fakeReef = Reef::factory()
            ->has(Point::factory(['position' => 1])->hasSensors())
            ->create();
        //sort the points array based on position so position reflects the index.
        $fakeReef->points->sortBy('position')->values();

        $point0 = [
            //Only 2 photos should be 3
            'id' => null, //should be required.
            'photos' => [
                UploadedFile::fake()->image('left.jpg'),
                UploadedFile::fake()->image('front.web'), //should not accept .web format
            ],
            'sample' => false, //sample should be prohibited on point 0
            'sensors' => [["something"]], //sensor should be prohibited on point 0
            'entries' => [
                [
                    'photo' => null, //photo should be required.
                    'count' => null, //count should be required.
                    'species' => 10 //should be a string
                ],
            ]
        ];
        $point1 = [
            'id' => 'notAnInteger', //should be an integer
            'photos' => [UploadedFile::fake()->image('closeUpPhoto.jpg'), UploadedFile::fake()->image('closeUpPhoto.jpg')], //should only accept 1 photo.
            'sample' => null, //sample should be required and a bool.
            'sensors' => [
                [
                    'id' => $fakeReef->points[1]['sensors'][0]->id + 1, //sensor ID should exist.
                    'value' => 'notNumeric', //number should be numeric
                    'measuredAt' => Carbon::now()
                ]
            ],
            'entries' => 'notAnArray' // should be an array.
        ];
        $point2 = [
            'id' => Point::max('id') + 1, //should not exist
            'photos' => 'notAnArray', //should be an array
            'sample' => true, //sample should be required and a bool.
            'sensors' => 'notAnArray',
            'entries' => []
        ];

        $data = [
            'points' => [$point0, $point1,$point2]
        ];

        $response = $this->post(route('reefs.session.store', ['reef' => $fakeReef->id]), $data);
        $response->assertStatus(302)->assertSessionHasErrors([
            'points.0.id', 'points.0.photos', 'points.0.sample', 'points.0.sensors',
            'points.0.entries.0.photo', 'points.0.entries.0.count', 'points.0.entries.0.species',
            'points.1.id', 'points.1.photos', 'points.1.sample', 'points.1.entries',
            'points.2.id', 'points.2.photos', 'points.2.sensors'
        ]);
    }
}
