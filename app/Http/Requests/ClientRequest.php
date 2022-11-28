<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'full_name' => 'required|string|min:3|max:128',
            'gender' => 'required|in:male,female,unspecified',
            'phone_number' => 'required|string|max:32',
            'address' => 'nullable|string|max:128',
            'brand.*' => 'nullable|string|max:64',
            'model.*' => 'nullable|string|max:128',
            'color.*' => 'nullable|string|max:64',
            'ru_vehicle_registration.*' => 'nullable|string|max:8',
            'in_parking.*' => 'nullable|string|max:8',

        ];
    }
}
