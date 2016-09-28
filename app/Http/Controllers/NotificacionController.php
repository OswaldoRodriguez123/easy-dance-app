<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Taller;
use App\Fiesta;
use App\Campana;
use App\ClaseGrupal;
use App\Notificacion;
use App\NotificacionUsuario;
use Session;
use DB;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    public function consulta(){
        
    	$fecha_sesion="";
    	if (Session::has('fecha_sesion')) {
            $fecha_sesion = Session::get('fecha_sesion');
        }       
         
		$date = Carbon::now();

		if(Session::has('fecha_ultima_consulta')){
			Session::put('fecha_ultima_consulta', $date);
		}else{
			Session::put('fecha_ultima_consulta', $date);
		}

        $clases_grupales=ClaseGrupal::whereBetween('created_at', [ new Carbon($fecha_carga), new Carbon($date)])->get();
    }

    public function revisarNotificacion(){
        $notificacion= NotificacionUsuario::where('notificacion_usuario.id_usuario','=',Auth::user()->id)
        ->get();

        foreach ($notificacion as $revisadas) {
            if (($revisadas->visto)==0) {
                $revisadas->visto=1;
                $revisadas->save();
            }
        }
        dd("reviso notificacion");
    }

    public function eliminarNotificaciones(){
        $notificacion = NotificacionUsuario::where('notificacion_usuario.id_usuario','=',Auth::user()->id)
        ->delete();
        dd("eliminar notificaciones");
    }
}