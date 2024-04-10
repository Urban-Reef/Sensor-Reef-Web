<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMonitoringSessionRequest;
use App\Models\MonitoringSession;
use App\Models\PointPhoto;
use App\Models\Sample;
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
        foreach ($request->points as $index => $point) {
            //Loop through photos and store.
            foreach ($point['photos'] as $photo) {
                dump($photo);
                //insert a PointPhoto into the database.
                $pointPhoto =  new PointPhoto();
                $pointPhoto->point_id = $point['id'];
                $pointPhoto->monitoring_session_id = $monitoringSession->id;
                //store file and store url in database.
                $pointPhoto->url = $photo->storeAs('/', $photo->hashName(), 'public');
                $pointPhoto->save();
            }
            //Create sample if true. Point 0 does not have this field set.
            if (isset($point['sample']) && $point['sample']) {
                Sample::create([
                    'point_id' => $point['id'],
                    'monitoring_session_id' => $monitoringSession->id
                ]);
            }
            //Loop through sensors.
                //If value is not null store.
            //Loop through entries.
                //store image.
            //store count and species.

        }
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
