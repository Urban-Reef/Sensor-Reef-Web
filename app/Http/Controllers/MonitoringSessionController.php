<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMonitoringSessionRequest;
use App\Models\BiodiversityEntry;
use App\Models\MonitoringSession;
use App\Models\PointPhoto;
use App\Models\Sample;
use App\Models\SensorData;
use Illuminate\Http\Request;

class MonitoringSessionController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
    }

    public function store(StoreMonitoringSessionRequest $request, $reef)
    {
        //create new session
        $monitoringSession = new MonitoringSession();
        $monitoringSession->reef_id = $reef;
        $monitoringSession->save();

        //Loop through points.
        foreach ($request->points as $point) {
            //Loop through photos and store.
            foreach ($point['photos'] as $photo) {
                //insert a PointPhoto into the database.
                $pointPhoto =  new PointPhoto();
                $pointPhoto->point_id = $point['id'];
                $pointPhoto->monitoring_session_id = $monitoringSession->id;
                //store file and store url in database.
                $pointPhoto->url = $photo->storeAs('/', $photo->hashName(), 'public');
                $pointPhoto->save();
            }

            //Loop through entries.
            foreach ($point['entries'] as $entry){
                //Create new entry
                $newEntry = new BiodiversityEntry;
                $newEntry->point_id = $point['id'];
                $newEntry->monitoring_session_id = $monitoringSession->id;
                $newEntry->count = $entry['count'];
                //check if species is not null
                if (isset($entry['species'])){
                    $newEntry->species = $entry['species'];
                }
                //store image on disc and store URL in database.
                $newEntry->photo = $entry['photo']->storeAs('/', $entry['photo']->hashName(), 'public');
                //insert entry into database.
                $newEntry->save();
            }

            //Create sample if true. Point 0 does not have this field set.
            if (isset($point['sample']) && $point['sample']) {
                Sample::create([
                    'point_id' => $point['id'],
                    'monitoring_session_id' => $monitoringSession->id
                ]);
            }

            //If sensors are set loop through sensors.
            if (isset($point['sensors'])) {
                foreach ($point['sensors'] as $sensor) {
                    //check if value is set.
                    if (!isset($sensor['value'])) return;
                    //else store value in database
                    $newSensorData = new SensorData();
                    $newSensorData->sensor_id = $sensor['id'];
                    $newSensorData->value = $sensor['value'];
                    //insert Sensor Data into database.
                    $newSensorData->save();
                }
            }
        }

        //Redirect to session index.
        return redirect(route('reefs.session.index', ['reef' => $reef]));
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
