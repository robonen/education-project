<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        auth()->user()->token()->revoke();

        return response()->json(['message' => 'You are logged out'], 200);
    }
}
