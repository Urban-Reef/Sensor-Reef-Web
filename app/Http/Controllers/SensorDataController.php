<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostSensorDataRequest;
use App\Models\Point;
use App\Models\Sensor;
use App\Models\SensorData;

class SensorDataController extends Controller
{
    public function __invoke(PostSensorDataRequest $request)
    {
        //TODO: Return error message when point or sensor isn't found.

        $data = $request->uplink_message['decoded_payload'];
        //loop through all points
        foreach ($data['points'] as $point){
            //get point id.
            $pointId = Point::where('reef_id', '=', $data['reefId'])
                ->where('position', '=', $point['position'])
                ->first()->id;

            //create an array of keys. Keys should be equal to a sensor's type.
            //remove 'position' from this array.
            $keys = array_diff(array_keys($point), ['position']);

            //Loop through keys array
            foreach ($keys as $key){
                //get sensor id using pointId and the key. Key should be equal to the sensor type.
                $sensorId = Sensor::where('point_id', '=', $pointId)
                    ->where('type', '=', $key)->first()->id;

                //insert new sensor_data.
                $sensorData = new SensorData();
                $sensorData->sensor_id = $sensorId;
                $sensorData->value = $point[$key];
                $sensorData->save();
            }
        }

        return response('success',200);
    }
}
