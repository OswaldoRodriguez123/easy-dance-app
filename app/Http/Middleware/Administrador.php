<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Administrador
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
        $usuario_tipo = Session::get('easydance_usuario_tipo');

        if($usuario_tipo){
            if($usuario_tipo == 1 || $usuario_tipo == 5){
                return $next($request);
            }
            abort(403);
            // if($request->user()->isType()=='admin' || $request->user()->isType()=='sucursal'){
            //     return $next($request);
            // }
        }
        return redirect("/seleccionar-tipo");
        
    }
}
