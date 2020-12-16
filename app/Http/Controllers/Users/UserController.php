<?php


namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\HeadTeacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class UserController
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
        return response()->json($user);
    }

}
