<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->only('login', 'password');

        if (auth()->attempt($credentials))
            return response()->json('You cannot sign with those credentials!', 401);

        $token = auth()->user()->makeToken($request->get('remember_me'));

        return response()->json([
            'token_type' => 'Bearer',
            'token' => $token->accessToken,
            ], 200);
    }
}
