<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsVerified
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
        $user = Auth::user();

        if ($user->confirmation_token != null) {
            Auth::logout();
            return redirect('login')->with('alert_confirmacion', 'Tu cuenta no se encuentra activa por favor confima tu cuenta de correo');
        }

        return $next($request);
    }
}
