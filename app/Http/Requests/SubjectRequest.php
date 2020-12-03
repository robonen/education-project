<?php

namespace App\Http\Requests;


class SubjectRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:subjects',
        ];
    }
}
