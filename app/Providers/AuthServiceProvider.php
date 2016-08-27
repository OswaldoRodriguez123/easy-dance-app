<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //VER ALUMNOS
        $gate->define('view-alumnos', function($user , $alumno){
            if($user->isType()=='admin' || $user->isType()=='recepcionista' || $user->isType()=='sucursal'){
                return $user->academia_id === $alumno->academia_id;
            }
        });

        $gate->define('view-examenes', function($user , $examen){
            if($user->isType()=='admin' || $user->isType()=='recepcionista' || $user->isType()=='sucursal'){
                return $user->academia_id === $examen->academia_id;
            }
        });

        //ELIMINAR ALUMNO
        $gate->define('delete-alumnos', function($user, $alumno){
            if($user->isType()=='admin'){
                return $user->academia_id === $alumno->academia_id;   
            }
        });

        //MOSTRAR BOTON MERCADO PAGO SOLO A ALUMNOS
        //EN MODULO DE CAMPAÑAS -> CONTRIBUCIONES
        $gate->define('view-mercadopago-button', function($user){
            if($user->isType()=='alumno'){
                return $user->id;
            }
        });        

    }
}
