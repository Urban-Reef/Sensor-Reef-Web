<?php

namespace App\Http\Controllers;

use App\Models\Reef;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReefController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        $reef = new Reef;
        $reef->name = $request->name;
        $reef->longitude = $request->long;
        $reef->latitude = $request->lat;
        $reef->placed_on = $request->placedOn;
        $reef->url = 'test';
        $reef->save();

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
