<?php

namespace App\Http\Controllers;

use App\Http\Requests\BiodiversityEntryRequest;
use App\Models\BiodiversityEntry;

class BiodiversityEntryController extends Controller
{
    public function index()
    {
        return BiodiversityEntry::all();
    }

    public function store(BiodiversityEntryRequest $request)
    {
        return BiodiversityEntry::create($request->validated());
    }

    public function show(BiodiversityEntry $biodiversityEntry)
    {
        return $biodiversityEntry;
    }

    public function update(BiodiversityEntryRequest $request, BiodiversityEntry $biodiversityEntry)
    {
        $biodiversityEntry->update($request->validated());

        return $biodiversityEntry;
    }

    public function destroy(BiodiversityEntry $biodiversityEntry)
    {
        $biodiversityEntry->delete();

        return response()->json();
    }
}
