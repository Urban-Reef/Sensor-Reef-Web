<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReefRequest;
use App\Models\Point;
use App\Models\Reef;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $reef = Reef::create([
            'name' => $request->name,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'placed_on' => $request->placedOn
        ]);
        $this->storeDiagram($request, $reef);

        //Loop through all the points.
        foreach ($request->points as $pointIndex => $point) {
            $newPoint = Point::create([
               'reef_id' => $reef->id,
               'position' => $pointIndex + 1 //Use the index to define position.
            ]);

            //Loop through all the sensors.
            foreach ($point['sensors'] as $sensor){
                Sensor::create([
                    'point_id' => $newPoint->id,
                    'type' => $sensor['type'],
                    'unit' => $sensor['unit']
                ]);
            }
        }
//        TODO: Return or alert
    }
    protected function storeDiagram($request, $reef): void
    {
        //if file is not present return out of the function.
        if (!$request->hasFile('diagram')) return;
        $diagram = $request->file('diagram'); //grab file from request.
        $reef->diagram = $diagram->storeAs('/', $diagram->hashName(), 'public'); //store image in public disk and save url in database.
        $reef->save();
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
