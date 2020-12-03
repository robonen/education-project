<?php

namespace App\Http\Requests;


class BankTaskRequest extends ApiFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'author' => 'required|max:128',
            'short_description' => 'required',
            'theme_id' => 'nullable|integer|gt:0',
            'subject_id' => 'required|integer|gt:0'
        ];
    }
}
