<?php

namespace App\Http\Middleware;

use Closure;

class Alumno
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user()->isType()=='alumno' || $request->user()->isType()=='admin' || $request->user()->isType()=='recepcionista'){
            return $next($request);
        }
        abort(403);
    }
}
