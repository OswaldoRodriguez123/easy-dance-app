<?php

namespace App\Http\Middleware;

use Closure;
use Session;

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
        // if($request->user()->isType()=='instructor' || $request->user()->isType()=='alumno' || $request->user()->isType()=='admin' || $request->user()->isType()=='recepcionista' || $request->user()->isType()=='sucursal'){
        //     return $next($request);
        // }
        // abort(403);

        $usuario_tipo = Session::get('easydance_usuario_tipo');

        if($usuario_tipo){
            if($usuario_tipo == 3 || $usuario_tipo == 2 || $usuario_tipo == 1 || $usuario_tipo == 6 || $usuario_tipo == 5){
                return $next($request);
            }
            abort(403);
        }
        return redirect("/seleccionar-tipo");
    }
}
