<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;

use App\Http\Requests;
use App\ConfigStaff;
use App\Staff;
use App\EventoLaboral;
use Validator;
use DB;
use Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventoLaboralController extends BaseController
{
	public function calendario()
    {
    	$eventos_laborales = EventoLaboral::join('staff', 'eventos_laborales.staff_id', '=', 'staff.id')
            ->select('eventos_laborales.*', 'staff.nombre as staff_nombre', 'staff.apellido as staff_apellido', 'staff.cargo')
            ->where('staff.academia_id','=', Auth::user()->academia_id)
        ->get();

        $cargos = ConfigStaff::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->get();

        return view('configuracion.eventos_laborales.calendario')->with(['eventos' => $eventos_laborales, 'cargos' => $cargos]);
    }

	public function principal()
    {
    	$eventos_laborales = EventoLaboral::join('staff', 'eventos_laborales.staff_id', '=', 'staff.id')
            ->select('eventos_laborales.*', 'staff.nombre as staff_nombre', 'staff.apellido as staff_apellido')
            ->where('staff.academia_id','=', Auth::user()->academia_id)
        ->get();

        $array = array();

        foreach($eventos_laborales as $evento){

        	$collection=collect($evento);
            $evento_array = $collection->toArray();
        	$fecha_inicio = Carbon::createFromFormat('Y-m-d', $evento->fecha);

            if($fecha_inicio >= Carbon::now()){
            	$evento_array['tipo'] = 'A';
            }else{
            	$evento_array['tipo'] = 'F';
            }	

            $array[$evento->id] = $evento_array;
        }

        return view('configuracion.eventos_laborales.principal')->with(['eventos' => $array]);
    }

    public function create()
    {

        $config_staff = ConfigStaff::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->get();
        $staffs = Staff::where('academia_id', Auth::user()->academia_id)->get();

        return view('configuracion.eventos_laborales.create')->with([ 'staffs' => $staffs, 'config_staff' => $config_staff]);
    }

    public function store(Request $request)
    {

	    $rules = [
	        'staff_id' => 'required',
	        'fecha' => 'required',
	        'nombre' => 'required',
	        'hora_inicio' => 'required',
	        'hora_final' => 'required',
	    ];

	    $messages = [

	        'staff_id.required' => 'Ups! El Staff es requerido',
	        'fecha.required' => 'Ups! La fecha es requerida',
	       	'nombre.required' => 'Ups! La actividad es requerida',
	        'hora_inicio.required' => 'Ups! La hora de inicio es requerida',
	        'hora_final.required' => 'Ups! La hora final es requerida',

	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

	    else{

	        $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);

	        if($fecha < Carbon::now()){

	            return response()->json(['errores' => ['fecha' => [0, 'Ups! ha ocurrido un error. La fecha de inicio no puede ser menor al dia de hoy']], 'status' => 'ERROR'],422);
	        }

	        $fecha = $fecha->toDateString();

	        $hora_inicio = strtotime($request->hora_inicio);
	        $hora_final = strtotime($request->hora_final);

	        if($hora_inicio > $hora_final)
	        {
	            return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
	        }

	        $evento = new EventoLaboral;
	        
	        $evento->staff_id = $request->staff_id;
	        $evento->fecha = $fecha;
	        $evento->nombre = $request->nombre;
	        $evento->hora_inicio = $request->hora_inicio;
	        $evento->hora_final = $request->hora_final;
	        $evento->color_etiqueta = $request->color_etiqueta;

	        if($evento->save()){
	        	return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
		}
   	}

   	public function edit($id)
    {

        $evento = EventoLaboral::join('staff', 'eventos_laborales.staff_id', '=', 'staff.id')
	        ->select('eventos_laborales.*', 'staff.nombre as staff_nombre', 'staff.apellido as staff_apellido')
	        ->where('eventos_laborales.id', '=', $id)
        ->first();

        if($evento){

        	$staffs = Staff::where('academia_id', Auth::user()->academia_id)->get();

        	return view('configuracion.eventos_laborales.planilla')->with(['staffs' => $staffs, 'evento' => $evento, 'id' => $id]);

        }else{
           return redirect("configuracion/eventos-laborales"); 
        }

    }

    public function updateStaff(Request $request){
        $evento = EventoLaboral::find($request->id);
        $evento->staff_id = $request->staff_id;

        if($evento->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateNombre(Request $request){

	    $rules = [
	        'nombre' => 'required',
	    ];

	    $messages = [

	        'nombre.required' => 'Ups! La actividad es requerida',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

	    else{

	        $evento = EventoLaboral::find($request->id);

	        $evento->nombre =  $request->nombre;

	        if($evento->save()){
	            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
   		}
    }

    public function updateEtiqueta(Request $request){
        $evento = EventoLaboral::find($request->id);
        $evento->color_etiqueta = $request->color_etiqueta;

        if($evento->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateFecha(Request $request){

	    $rules = [
	        'fecha' => 'required',
	    ];

	    $messages = [

	        'fecha.required' => 'Ups! La fecha es requerida',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

	    else{

	        $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);

	        if($fecha < Carbon::now()){

	            return response()->json(['errores' => ['fecha' => [0, 'Ups! ha ocurrido un error. La fecha no puede ser menor al dia de hoy']], 'status' => 'ERROR'],422);
	        }

	        $fecha = $fecha->toDateString();

	        $evento = EventoLaboral::find($request->id);

	        $evento->fecha = $fecha;

	        if($evento->save()){
	            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
   		}
    }

    public function updateHorario(Request $request){

	    $rules = [
	        'hora_inicio' => 'required',
	        'hora_final' => 'required',
	    ];

	    $messages = [

	        'hora_inicio.required' => 'Ups! La hora de inicio es requerida',
	        'hora_final.required' => 'Ups! La hora final es requerida',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

	    else{

	        $hora_inicio = strtotime($request->hora_inicio);
	        $hora_final = strtotime($request->hora_final);

	        if($hora_inicio > $hora_final)
	        {

	            return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
	        }

	        $evento = EventoLaboral::find($request->id);

	        $evento->hora_inicio = $request->hora_inicio;
	        $evento->hora_final = $request->hora_final;

	        if($evento->save()){
	            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
	    }
    }

    public function destroy($id)
    {
        $evento = EventoLaboral::find($id);
        
        if($evento->delete()){
            return response()->json(['mensaje' => '¡Excelente! El evento se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
}