<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;

use App\Models\Role;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Database\QueryException;

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
                try {
                    $user->student()->create(['class_id'=>$request->input('class_id')]);
                    $class = SchoolClass::find($request->input('class_id'));
                    if ($class) {
                        $class->count_students++;;
                        $class->save();
                    }
                } catch (QueryException $e) {
                    $user->delete();
                    return response()->json(['message'=>'Class not found'],404);
                }
                break;

            case 'parent':
                $user->parent()->create();
                break;
        }

        return response()->json(null, 201);
    }
}
