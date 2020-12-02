<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Role
{
    private $delimetr = '|';

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        $roles = explode($this->delimetr, $roles);

        if (!auth()->user()->hasRole($roles)) {
            return response()->json('',404);
        }
        return $next($request);
    }
}
