<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostSensorDataRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uplink_message' => 'required',
            'uplink_message.decoded_payload' => 'required',
            'uplink_message.decoded_payload.points' => 'required|array',
            'uplink_message.decoded_payload.points.*.position' => 'required|integer',
            'uplink_message.decoded_payload.points.*.*' => 'numeric',
            'uplink_message.decoded_payload.reefId' => 'required|integer|exists:reefs,id'
        ];
    }

    public function authorize(): bool
    {
        //TODO: Implement authorisation
        return true;
    }
}
