<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Alumno;

use Carbon\Carbon;

use DB;

use Validator;

use Illuminate\Support\Facades\Auth;

class BuscadorController extends BaseController
{
	public function index(){
        return view('buscador.index');
    }

	public function buscarAlumno(Request $request){

 		$request->merge(array('identificacion' => trim($request->identificacion)));

	 	$rules = [
	        'identificacion' => 'required|numeric',
	    ];

	    $messages = [

	        'identificacion.required' => 'Ups! El identificador es requerido',
	        'identificacion.numeric' => 'Ups! El identificador es inválido , debe contener sólo números',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        // return redirect("/home")

	        // ->withErrors($validator)
	        // ->withInput();

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	        //dd($validator);

	    }

	    else{

 			$alumno = Alumno::where('identificacion', $request->identificacion)->first();

 			if($alumno){

		        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'id' => $alumno->id,  200]);
	           
            }else{
            	return response()->json(['error_mensaje' => 'Ups! No Hemos encontrado la siguiente información del identificador  asociada a tu cuenta'], 422);
            }
        }
 	}

 	public function perfil($id)
    {   
        $alumno = Alumno::find($id);

        if($alumno){

            $inscripciones = DB::table('inscripcion_clase_grupal')
                ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('config_clases_grupales.nombre', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final', 'clases_grupales.fecha_inicio', 'inscripcion_clase_grupal.id', 'inscripcion_clase_grupal.fecha_pago')
                ->where('inscripcion_clase_grupal.alumno_id', '=', $id)
                ->where('inscripcion_clase_grupal.deleted_at', '=', null)
          ->get();

      $array = array();

      foreach($inscripciones as $inscripcion){

      $fecha = Carbon::createFromFormat('Y-m-d', $inscripcion->fecha_inicio);
      
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

        $diferencia = Carbon::createFromFormat('Y-m-d',$inscripcion->fecha_pago)->diffInDays(Carbon::now());

        $collection=collect($inscripcion);     
        $inscripcion_array = $collection->toArray();
            
        $inscripcion_array['dia']=$dia;
        $inscripcion_array['diferencia']=$diferencia;
        $array[$inscripcion->id] = $inscripcion_array;
      }

            $usuario = DB::table('users')
                ->join('alumnos', 'users.usuario_id', '=', 'alumnos.id')
                ->select('users.imagen')
                ->where('alumnos.id', $id)
            ->first();

            if($usuario){
                $imagen = $usuario->imagen;
            }else{
                $imagen = '';
            }

            $deuda=$this->deuda($id);

           return view('buscador.perfil')->with(['alumno' => $alumno , 'id' => $id, 'deuda' => $deuda, 'inscripciones' => $array, 'imagen' => $imagen]);
        }else{
           return redirect("participante/alumno"); 
        }
    }

    private function deuda($id){
        $alumnod = DB::table('alumnos')
            ->join('items_factura_proforma', 'items_factura_proforma.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.id as id', 'items_factura_proforma.importe_neto', 'items_factura_proforma.fecha_vencimiento')
            ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
            ->where('items_factura_proforma.alumno_id', $id)
        ->get();

        if(count($alumnod)>0){
            $collection = collect($alumnod);
            $cuenta=$collection->sum('importe_neto');
        }else{
            $cuenta=0;
        }

        return $cuenta;

    }
 }