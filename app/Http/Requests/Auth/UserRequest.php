<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class UserRequest extends ApiFormRequest
{
    public function specific()
    {
        return [];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge([
            'login' => 'required|string',
            'password' => 'required|string|min:6',
        ], $this->specific());
    }
}
