<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatLinkRequest extends ApiFormRequest
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
            'link' => 'required',
            'class_id' => 'required|integer|gt:0',
        ];
    }
}
