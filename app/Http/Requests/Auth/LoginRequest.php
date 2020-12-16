<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\UserRequest;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends UserRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function specific()
    {
        return [
            'remember_me' => 'integer'
        ];
    }
}
