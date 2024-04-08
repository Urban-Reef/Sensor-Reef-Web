<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SensorDataController extends Controller
{
    public function __invoke(Request $request)
    {
        return response('success',200);
    }
}
