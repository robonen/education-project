<?php

namespace App\Http\Requests;

class StudentRequest extends ApiFormRequest
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
        ];
    }
}
