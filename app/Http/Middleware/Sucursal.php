<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Sucursal
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
        // if($request->user()->isType()=='sucursal'){
        //     return $next($request);
        // }
        // abort(403);

        $usuario_tipo = Session::get('easydance_usuario_tipo');

        if($usuario_tipo){
            if($usuario_tipo == 5){
                return $next($request);
            }
            abort(403);
        }
        return redirect("/seleccionar-tipo");
    }
}
