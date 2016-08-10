<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Taller;
use App\Fiesta;
use App\Campana;
use App\ClaseGrupal;
use Session;
use Carbon\Carbon;
use App\Http\Requests;

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

        dd($clases_grupales);
    }
}
