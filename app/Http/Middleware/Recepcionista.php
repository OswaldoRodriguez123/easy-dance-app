<?php

namespace App\Http\Middleware;

use Closure;

class Recepcionista
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
        if($request->user()->isType()=='recepcionista' || $request->user()->isType()=='admin' || $request->user()->isType()=='alumno'){
            return $next($request);
        }
        ;

        /*switch ($request->user()->isType()) {
            case 'admin':
                return $next($request);
                //abort(403);
                break;

            case 'alumno':
                return $next($request);
                //abort(403);
                break;

            case 'recepcionista':
                return $next($request);
                break;

        }*/

    }
}
