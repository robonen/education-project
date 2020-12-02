<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\UserRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends UserRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function specific()
    {
        return [
            'role' => 'required|string',
            'class_id' => 'required|integer|gt:0',
        ];
    }
}
