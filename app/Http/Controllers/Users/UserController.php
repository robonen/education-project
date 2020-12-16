<?php


namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;


class UserController extends Controller
{

    public function getUser()
    {
        switch(auth()->user()->role->name)
        {
            case 'student':
                $user = auth()->user()->student;
                break;

            case 'teacher':
                $user = auth()->user()->teacher;
                break;

            case 'headteacher':
            $user = auth()->user()->headteacher;
                break;

            case 'parent':
                $user = auth()->user()->parent;
                break;
        }
        $user->toArray();
        $user['role'] = auth()->user()->role->name;
        return response()->json($user, 200);
    }

}
