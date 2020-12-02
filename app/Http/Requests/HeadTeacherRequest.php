<?php

namespace App\Http\Requests;

class HeadTeacherRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date_of_birth' => 'date_format:Y/m/d|before:today|after:1900-01-01',
            'phone_number' => 'regex:/^\+?7\d{10}$/',
        ];
    }
}
