<?php

namespace App\Http\Requests;

class TimetableRequest extends ApiFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'class_id' => 'required|integer|gt:0',
            'teacher_id' => 'required|integer|gt:0',
            'subject_id' => 'required|integer|gt:0',
            'date' => 'required|date_format:Y/m/d|',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i',
        ];
    }
}
