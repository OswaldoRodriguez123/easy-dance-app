<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Academia;
use App\Llamada;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class LlamadaController extends BaseController {


	public function index(){

		$array = array();

		$llamadas = Llamada::join('visitantes_presenciales', 'llamadas.usuario_id', '=', 'visitantes_presenciales.id')
			->leftJoin('tipologias', 'visitantes_presenciales.tipologia_id', '=', 'tipologias.id')
		   	->select('llamadas.*','visitantes_presenciales.nombre','visitantes_presenciales.apellido','tipologias.nombre as tipologia', 'visitantes_presenciales.fecha_registro', 'visitantes_presenciales.id as usuario_id')
		   	->where('llamadas.fecha_siguiente','!=','0000-00-00')
			->where('llamadas.usuario_tipo',1)
			->where('visitantes_presenciales.academia_id',Auth::user()->academia_id)
		->get();

		foreach($llamadas as $llamada){

			$fecha = Carbon::createFromFormat('Y-m-d', $llamada->fecha_siguiente);
	        $i = $fecha->dayOfWeek;

	        if($i == 1){

	          $dia = 'Lunes';

	        }else if($i == 2){

	          $dia = 'Martes';

	        }else if($i == 3){

	          $dia = 'Miercoles';

	        }else if($i == 4){

	          $dia = 'Jueves';

	        }else if($i == 5){

	          $dia = 'Viernes';

	        }else if($i == 6){

	          $dia = 'Sabado';

	        }else if($i == 0){

	          $dia = 'Domingo';

	        }

	        if($fecha > Carbon::now()){
	        	$tipo = 1;
	        }else{
	        	$tipo = 0;
	        }

	        $collection=collect($llamada);     
	        $llamada_array = $collection->toArray();

	        $llamada_array['fecha_visita']=$llamada->fecha_registro;
	        $llamada_array['dia']=$dia;
	        $llamada_array['tipo']=$tipo;
	        $llamada_array['usuario_tipo']=1;
	        $array[] = $llamada_array;
		}

		$llamadas = Llamada::join('alumnos', 'llamadas.usuario_id', '=', 'alumnos.id')
			->leftJoin('tipologias', 'alumnos.tipologia_id', '=', 'tipologias.id')
		   	->select('llamadas.*','alumnos.nombre','alumnos.apellido','tipologias.nombre as tipologia', 'alumnos.id as usuario_id')
		   	->where('llamadas.fecha_siguiente','!=','0000-00-00')
			->where('llamadas.usuario_tipo',2)
			->where('alumnos.academia_id',Auth::user()->academia_id)
		->get();

		foreach($llamadas as $llamada){

			$fecha = Carbon::createFromFormat('Y-m-d', $llamada->fecha_siguiente);
	        $i = $fecha->dayOfWeek;

	        if($i == 1){

	          $dia = 'Lunes';

	        }else if($i == 2){

	          $dia = 'Martes';

	        }else if($i == 3){

	          $dia = 'Miercoles';

	        }else if($i == 4){

	          $dia = 'Jueves';

	        }else if($i == 5){

	          $dia = 'Viernes';

	        }else if($i == 6){

	          $dia = 'Sabado';

	        }else if($i == 0){

	          $dia = 'Domingo';

	        }

	        if($fecha > Carbon::now()){
	        	$tipo = 1;
	        }else{
	        	$tipo = 0;
	        }

	        $fecha_visita = Carbon::createFromFormat('Y-m-d H:i:s', $llamada->created_at)->toDateString();

	        $collection=collect($llamada);     
	        $llamada_array = $collection->toArray();

	        $llamada_array['fecha_visita']=$fecha_visita;
	        $llamada_array['dia']=$dia;
	        $llamada_array['tipo']=$tipo;
	        $llamada_array['usuario_tipo']=2;
	        $array[] = $llamada_array;
		}

		return view('llamadas.principal')->with(['llamadas' => $array]);
	}

}