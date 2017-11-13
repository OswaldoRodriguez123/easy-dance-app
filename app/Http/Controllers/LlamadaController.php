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
			->where('llamadas.usuario_tipo',1)
			->where('visitantes_presenciales.academia_id',Auth::user()->academia_id)
		->get();

		foreach($llamadas as $llamada){

	        $collection=collect($llamada);     
	        $llamada_array = $collection->toArray();

	        $llamada_array['fecha_visita']=$llamada->fecha_registro;
	        $llamada_array['usuario_tipo']=1;
	        $array[] = $llamada_array;
		}

		$llamadas = Llamada::join('alumnos', 'llamadas.usuario_id', '=', 'alumnos.id')
			->leftJoin('tipologias', 'alumnos.tipologia_id', '=', 'tipologias.id')
		   	->select('llamadas.*','alumnos.nombre','alumnos.apellido','tipologias.nombre as tipologia', 'alumnos.id as usuario_id')
			->where('llamadas.usuario_tipo',2)
			->where('alumnos.academia_id',Auth::user()->academia_id)
		->get();

		foreach($llamadas as $llamada){

	        $fecha_visita = Carbon::createFromFormat('Y-m-d H:i:s', $llamada->created_at)->toDateString();

	        $collection=collect($llamada);     
	        $llamada_array = $collection->toArray();

	        $llamada_array['fecha_visita']=$fecha_visita;
	        $llamada_array['usuario_tipo']=2;
	        $array[] = $llamada_array;
		}

		return view('llamadas.principal')->with(['llamadas' => $array]);
	}

}