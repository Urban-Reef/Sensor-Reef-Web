<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BiodiversityEntryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'photo' => 'required|image|mimes:jpeg,jpg,png',
            'count' => 'required|integer',
            'species' => 'nullable|string', //species is allowed to be empty if person does not know.
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
