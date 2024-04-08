<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreReefRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //TODO: Add authorisation logic.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:reefs,name|string|max:255',
            'placedOn' => 'required|date',
            'longitude' => 'required|decimal:6',
            'latitude' => 'required|decimal:6',
            'diagram' => 'nullable|image|mimes:jpeg,png,jpg',
            'points.*.sensors.*.type' => 'required|string',
            'points.*.sensors.*.unit' => 'required|string',
        ];
    }
}
