<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
        $role = Role::where('name', $request->get('role'))->get();

        if ($role->isEmpty())
            return response()->json(['message'=>'Role not found'], 404);

        $user = User::create(array_merge(
            $request->only('login', 'class_id'),
            [
                'password' => bcrypt($request->get('password')),
                'role_id' => $role->first()->id,
            ]
        ));

        switch($request->get('role'))
        {
            case 'headteacher':
                $user->headteacher()->create();
                break;

            case 'teacher':
                $user->teacher()->create();
                break;

            case 'student':
                $user->student()->create();
                break;

            case 'parent':
                $user->parent()->create();
                break;
        }

        return response()->json(null, 201);
    }
}
