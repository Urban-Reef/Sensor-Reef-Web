<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMonitoringSessionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'points.*.id' => 'required|integer|exists:points,id', //point id should exist.
            'points.*.photos' => 'array|size:1', // 1 close-up photo per point
            'points.*.photos.*' => 'image|mimes:jpeg,png,jpg', // photo should be jpeg, png or jpg
            'points.*.sample' => 'required|boolean', //check if a sample has been taken yes/no
            'points.*.sensors' => 'present|nullable|array', //sensor array is allowed to be empty if no sensors exist.
            'points.*.sensors.*.id' => 'required|integer|exists:sensors', //ID is required.
            'points.*.sensors.*.value' => 'present|nullable|numeric', //Should be present but is allowed to be null.
            'points.*.entries' => 'present|nullable|array', //entries allowed to be null if no organisms are spotted.
            'points.*.entries.*.photo' => 'required|image|mimes:jpeg,jpg,png',
            'points.*.entries.*.count' => 'required|integer',
            'points.*.entries.*.species' => 'nullable|string', //species is allowed to be empty if person does not know.

            'points.0.photos' => 'required|array|size:3', //collecting
            'points.0.sample' => 'prohibited', //not collecting samples for environment
            'points.0.sensors' => 'prohibited', //environment does not have sensors
        ];
    }
}
