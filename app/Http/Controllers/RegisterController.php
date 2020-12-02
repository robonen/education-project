<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;

use App\Models\HeadTeacher;
use App\Models\Parentt;
use App\Models\Role;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        $role = Role::where('name', $request->get('role'));

        if ($role->isEmpty())
            return response()->json('Role not found', 404);

        $user = User::create(array_merge(
            $request->only('login', 'class_id'),
            [
                'password' => bcrypt($request->get('password')),
                'role_id' => $role->first()->id,
            ]
        ));

        $user_id = [
            'user_id' => $user->id,
        ];

        switch($request->get('role'))
        {
            case 'headteacher':
                HeadTeacher::create($user_id);
                break;

            case 'teacher':
                Teacher::create($user_id);
                break;

            case 'student':
                Student::create($user_id);
                break;

            case 'parent':
                Parentt::create($user_id);
                break;
        }

        return response()->json('ok', 200);
    }
}
