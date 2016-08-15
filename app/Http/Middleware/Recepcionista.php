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
        if($request->user()->isType()=='recepcionista' || $request->user()->isType()=='admin' || $request->user()->isType()=='sucursal'){
            return $next($request);
        }
        abort(403);

    }
}
