<?php

namespace App\Http\Requests;

class SchoolClassRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'number' => 'required|integer|between:1,11',
            'letter' => 'required|max:1|regex:/[а-я]/',
            'profile' => 'required',
        ];
    }

}
