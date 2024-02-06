<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReefRequest;
use App\Models\Point;
use App\Models\Reef;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReefController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Currently return object with all reefs.
        return Reef::with('points.sensors')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('Reef/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReefRequest $request)
    {
        //Create the reef.
        //TODO: Set fillable feelds, change to create method.
        $reef = new Reef;
        $reef->name = $request->name;
        $reef->longitude = $request->longitude;
        $reef->latitude = $request->latitude;
        $reef->placed_on = $request->placedOn;
        $reef->url = 'test';
        $reef->save();

        //Get the id of the newly created Reef.
        $createdReef = Reef::OrderBy('id', 'desc')->select('id')->first();
        //Loop through all the points.
        foreach ($request->points as $pointIndex => $point) {
            $newPoint = new Point;
            $newPoint->reef_id = $createdReef->id;
            //Use the index of the foreach loop to define position.
            $newPoint->position = $pointIndex + 1;
            $newPoint->save();

            //get the id of the newly created point
            $createdPoint = Point::OrderBy('id', 'desc')->select('id')->first();
            //Loop through all the sensor in the point.
            foreach ($point['sensors'] as $sensor){
                $newSensor = new Sensor;
                $newSensor->point_id = $createdPoint->id;
                $newSensor->type = $sensor['type'];
                $newSensor->unit = $sensor['unit'];
                $newSensor->save();
            }
        }
//        TODO: Return or alert
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
