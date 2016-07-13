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
        /*if($request->user()->isType()=='alumno' || $request->user()->isType()=='admin'){
            return $next($request);
        }
        abort(403);*/

        switch ($request->user()->isType()) {
            case 'admin':
                return $next($request);
                //abort(403);
                break;

            case 'alumno':
                return $next($request);
                break;

            case 'recepcionista':
                return $next($request);
                //abort(403);
                break;
                
        }


    }
}
