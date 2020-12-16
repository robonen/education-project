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
        return response()->json([
            'id'=> $user->id,
            'photo'=> $user->photo,
            'name'=> $user->name,
            'surname'=> $user->surname,
            'patronymic'=> $user->patronymic,
            'information_about_me'=> $user->information_about_me,
            'experience'=> $user->experience,
            'created_at'=> $user->created_at,
            'updated_at'=> $user->updated_at,
            'role'=> auth()->user()->role->name,
        ], 200);
    }

}
