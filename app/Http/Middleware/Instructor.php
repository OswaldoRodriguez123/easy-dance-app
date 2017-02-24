<?php

namespace App\Http\Middleware;

use Closure;

class Instructor
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
        if($request->user()->isType()=='instructor' || $request->user()->isType()=='alumno' || $request->user()->isType()=='admin' || $request->user()->isType()=='recepcionista' || $request->user()->isType()=='sucursal'){
            return $next($request);
        }
        abort(403);
    }
}
