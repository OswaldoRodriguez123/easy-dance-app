<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Staff;
use App\ConfigStaff;
use App\DiasDeSemana;
use Validator;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Supervision;
use App\ConfigSupervision;
use App\HorarioSupervision;
use App\DetalleSupervisionEvaluacion;
use App\SupervisionEvaluacion;
use App\SupervisionProcedimiento;
use App\Academia;
use App\Instructor;
use DB;
use Session;

class ProcedimientoController extends BaseController {
	
	public function principal_procedimientos($id){

    	$config_supervisiones = ConfigSupervision::join('config_staff', 'config_supervision.cargo_id', '=', 'config_staff.id')
    		->select('config_supervision.*')
    		->where('config_supervision.academia_id', Auth::user()->academia_id)
    		->where('config_staff.id', $id)
    		->orWhere('config_supervision.academia_id', null)
    	->get();

    	$array = array();

    	foreach($config_supervisiones as $configuracion){

    		$items = SupervisionProcedimiento::where('config_supervision_id',$configuracion->id)->count();

    		if($items > 0){

	    		$collection=collect($configuracion);   

	            $configuracion_array = $collection->toArray();
	            $configuracion_array['items']=$items;
	            $array[$configuracion->id] = $configuracion_array;
            }

    	}

        return view('configuracion.supervision.procedimientos')->with(['config_supervisiones' => $array, 'id' => $id]);

    }

    public function agregar_procedimiento($id){

    	Session::forget('procedimientos');

    	$procedimientos = ConfigSupervision::join('config_staff', 'config_supervision.cargo_id', '=', 'config_staff.id')
    		->select('config_supervision.*')
    		->where('config_supervision.academia_id', Auth::user()->academia_id)
    		->where('config_staff.id', $id)
    		->orWhere('config_supervision.academia_id', null)
    	->get();

    	$array = array();

    	foreach($procedimientos as $configuracion){

	    	$items = SupervisionProcedimiento::where('config_supervision_id',$configuracion->id)->count();

			if($items > 0){

	    		$array[] = $configuracion->id;
	        }
        }
    	
        return view('configuracion.supervision.agregar_procedimiento')->with(['procedimientos' => $procedimientos, 'procedimientos_usados' => $array, 'id' => $id]);

    }

    public function agregar_procedimiento_session(Request $request){

    	$rules = [

	        'nombre_supervision' => 'required|min:3|max:150',
	    ];

	    $messages = [

	        'nombre_supervision.required' => 'Ups! El Nombre es requerido',
	        'nombre_supervision.min' => 'El mínimo de caracteres permitidos son 3',
	        'nombre_supervision.max' => 'El máximo de caracteres permitidos son 50',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

    	$array = array(['nombre' => $request->nombre_supervision]);


        Session::push('procedimientos', $array);

        $items = Session::get('procedimientos');
        end( $items );
        $contador = key( $items );

        $array=array(
            'nombre' => $request->nombre_supervision,
            'id'=>$contador
        );

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 200]);

    }

    public function eliminar_procedimiento_session($id){

        $arreglo = Session::get('procedimientos');
        unset($arreglo[$id]);
        Session::put('procedimientos', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han eliminado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function cancelar_procedimiento()
    {   
        if (Session::has('procedimientos')) {

            Session::forget('procedimientos');
            return response()->json(['status' => 'OK', 200]);  
        }
        else
        {
            return response()->json(['status' => 'OK', 200]);
        }
    }

    public function GuardarProcedimiento(Request $request)
    {   
    	$rules = [
		    'config_supervision_id' => 'required',
	    ];

	    $messages = [
	        'config_supervision_id.required' => 'Ups! El Procedimiento es requerido',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }else{

	        $procedimientos = Session::get('procedimientos');

	        if (count($procedimientos) > 0){
	            foreach($procedimientos as $tmp){
	                foreach($tmp as $supervision){

	                    $procedimiento = new SupervisionProcedimiento();

	                    $procedimiento->config_supervision_id=$request->config_supervision_id;
	                    $procedimiento->nombre=$supervision['nombre'];

	                    $procedimiento->save();
	 
	                }
	            }

	            return response()->json(['mensaje' => '¡Excelente! Los campos se han eliminado satisfactoriamente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores' => ['linea' => [0, 'Ups! ha ocurrido un error, debes agregar un item']], 'status' => 'ERROR'],422);
	        }
    	}
    }

    public function editar_procedimiento($id){

    	Session::forget('procedimientos');

    	$config_supervision = ConfigSupervision::find($id);

    	$procedimientos = ConfigSupervision::join('supervisiones_procedimientos', 'supervisiones_procedimientos.config_supervision_id', '=', 'config_supervision.id')
    		->select('supervisiones_procedimientos.*', 'config_supervision.nombre as supervision')
    		->where('supervisiones_procedimientos.config_supervision_id', $id)
	    	->where('config_supervision.academia_id', Auth::user()->academia_id)
    	->get();
    	
        return view('configuracion.supervision.agregar_procedimiento')->with(['procedimientos' => '', 'config_supervision' => $config_supervision, 'config_supervision_id' => $id, 'procedimientos' => $procedimientos, 'procedimientos_usados' => '','id' => $config_supervision->cargo_id]);

    }

    Public function agregar_procedimiento_fijo(Request $request){
        
    $rules = [

        'nombre_supervision' => 'required|min:3|max:150',
        'config_supervision_id' => 'required',
    ];

    $messages = [

        'nombre_supervision.required' => 'Ups! El Nombre es requerido',
        'nombre_supervision.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre_supervision.max' => 'El máximo de caracteres permitidos son 50',
        'config_supervision_id.required' => 'Ups! El Procedimiento es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $nombre = title_case($request->nombre_supervision);

        $supervision = new SupervisionProcedimiento;
                                        
        $supervision->nombre = $nombre;
        $supervision->config_supervision_id = $request->config_supervision_id;

        $supervision->save();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $supervision, 'id' => $supervision->id, 200]);

        }
    }

    public function eliminar_procedimiento_fijo($id){

        $supervision = SupervisionProcedimiento::find($id);

        $supervision->delete();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }
}