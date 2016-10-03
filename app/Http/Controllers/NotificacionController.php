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
        return response()->json(['status' => 'OK', 200]);
    }

    public function eliminarNotificaciones(){
        $notificacion = NotificacionUsuario::where('notificacion_usuario.id_usuario','=',Auth::user()->id)
        ->delete();
    }

    public function nuevaNotificaion(){
        $notificaciones = DB::table('notificacion_usuario')
            ->join('notificacion','notificacion_usuario.id_notificacion', '=','notificacion.id')
            ->join('users','notificacion_usuario.id_usuario','=','users.id')
            ->select('notificacion.*','notificacion_usuario.visto as visto')
            ->where('notificacion_usuario.id_usuario','=',Auth::user()->id)
            ->orderBy('created_at','desc')
        ->get();

        $numero_de_notificaciones = 0;

        foreach( $notificaciones as $notificacion){
            if($notificacion->visto == 0){
                $numero_de_notificaciones++;
            }
        }

        $notificaciones = DB::table('notificacion_usuario')
            ->join('notificacion','notificacion_usuario.id_notificacion', '=','notificacion.id')
            ->join('users','notificacion_usuario.id_usuario','=','users.id')
            ->join('academias','users.academia_id','=','academias.id')
            ->select('notificacion.*','notificacion_usuario.visto as visto','academias.imagen as imagen','academias.nombre as nombre')
            ->where('notificacion_usuario.id_usuario','=',Auth::user()->id)
            ->orderBy('created_at','desc')
            ->limit(10)
        ->get();

        $hoy = Carbon::now();
        $hoy = $hoy->format('d-m-Y');
        $nueva_notificacion = "";
        
        foreach ($notificaciones as $notificacion) {
            $creada = $notificacion->created_at;
            $creada = Carbon::parse($creada);
            $creada = $creada->format('d-m-Y');
            if(($notificacion->visto==0)&&($creada==$hoy)){
                $nueva_notificacion = "!! tienes una nueva notificacion de ".$notificacion->nombre." !!";
            }
        }

        return response()->json(['mensaje' => $nueva_notificacion,'sin_ver' => $numero_de_notificaciones, 'notificaciones' => $notificaciones, 'status' => 'OK', 200]);
    }
}