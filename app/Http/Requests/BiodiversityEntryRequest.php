<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BiodiversityEntryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'photo' => ['required' || 'file'],
            'species' => ['nullable' || 'string'],
            'count' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
