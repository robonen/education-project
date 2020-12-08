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
            'timetables' => 'required|array',
            'timetables.*.class_id' => 'required|integer|gt:0',
            'timetables.*.teacher_id' => 'required|integer|gt:0',
            'timetables.*.subject_id' => 'required|integer|gt:0',
            'timetables.*.date' => 'required|date_format:Y/m/d|',
            'timetables.*.time_start' => 'required|date_format:H:i',
            'timetables.*.time_end' => 'required|date_format:H:i',
        ];
    }
}
