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
use App\ConfiguracionSupervision;
use App\ConfigSupervision;
use App\HorarioSupervision;
use App\DetalleSupervisionEvaluacion;
use App\SupervisionEvaluacion;
use App\SupervisionProcedimiento;
use App\Academia;
use App\Instructor;
use DB;
use Session;

class ConfigSupervisionController extends BaseController {

	public function configuracion(){

    	$config_supervision = ConfiguracionSupervision::join('config_staff', 'configuracion_supervisiones.cargo_id', '=', 'config_staff.id')
            ->select('configuracion_supervisiones.*','config_staff.nombre')
            ->where('configuracion_supervisiones.academia_id', Auth::user()->academia_id)
        ->get();

    	$array = array();

    	foreach($config_supervision as $supervision){

    		$items = ConfigSupervision::where('config_supervision_id',$supervision->id)->count();
    		$collection=collect($supervision);   

            $supervision_array = $collection->toArray();
            $supervision_array['items']=$items;
            $array[$supervision->id] = $supervision_array;

    	}
        
        return view('configuracion.supervision.principal')->with(['config_supervision' => $array]);
    }


    public function agregar_configuracion(){

    	Session::forget('supervisiones');

    	$cargos = ConfigStaff::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->get();
    	$array = array();

    	foreach($cargos as $cargo){

	    	$items = ConfigSupervision::where('cargo_id',$cargo->id)->count();

			if($items > 0){

	    		$array[] = $cargo->id;
	        }
        }

        return view('configuracion.supervision.agregar_configuracion')->with(['cargos' => $cargos, 'cargos_usados' => $array]);

    }

    // public function editar_configuracion($id){

    // 	Session::forget('supervisiones');

    // 	$cargos = ConfigStaff::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->get();
    // 	$cargo = ConfigStaff::find($id);

    // 	$config_supervision = ConfigSupervision::join('config_staff', 'config_supervision.cargo_id', '=', 'config_staff.id')
    // 		->select('config_supervision.*', 'config_staff.nombre as cargo')
    // 		->where('config_supervision.cargo_id', $id)
	   //  	->where('config_supervision.academia_id', Auth::user()->academia_id)
    // 	->get();
    	
    //     return view('configuracion.supervision.agregar_configuracion')->with(['cargos' => $cargos, 'config_supervision' => $config_supervision, 'id' => $id, 'cargo' => $cargo, 'cargos_usados' => '']);

    // }


    Public function agregar_supervision_fija(Request $request){
        
    $rules = [

        'nombre_procedimiento' => 'required|min:3|max:150',
        'cargo_supervision' => 'required',
    ];

    $messages = [

        'nombre_procedimiento.required' => 'Ups! El Nombre es requerido',
        'nombre_procedimiento.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre_procedimiento.max' => 'El máximo de caracteres permitidos son 50',
        'cargo_supervision.required' => 'Ups! El Cargo es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $nombre = title_case($request->nombre_procedimiento);

        $supervision = new ConfigSupervision;
                                        
        $supervision->academia_id = Auth::user()->academia_id;
        $supervision->nombre = $nombre;
        $supervision->cargo_id = $request->cargo_supervision;

        $supervision->save();

        $config_staff = ConfigStaff::find($request->cargo_supervision);
        $cargo = $config_staff->nombre;

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $supervision, 'id' => $supervision->id, 'cargo' => $cargo, 200]);

        }
    }

    public function eliminar_supervision_fija($id){

    	$procedimientos = SupervisionProcedimiento::where('config_supervision_id',$id)->delete();

        $supervision = ConfigSupervision::find($id);

        $supervision->delete();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function GuardarConfiguracion(Request $request)
    {   
    	$rules = [
		    'cargo_supervision' => 'required',
            'descripcion' => 'required',
	    ];

	    $messages = [
	        'cargo_supervision.required' => 'Ups! El Cargo es requerido',
            'descripcion.required' => 'Ups! La descripción es requerida',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }else{

            $config_supervision = new ConfiguracionSupervision();

            $config_supervision->academia_id = Auth::user()->academia_id;
            $config_supervision->cargo_id=$request->cargo_supervision;
            $config_supervision->descripcion=$request->descripcion;

            if($config_supervision->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }

        	// $supervisiones = Session::get('supervisiones');

        	// if (count($supervisiones) > 0){
	        //     foreach($supervisiones as $tmp){
	        //         foreach($tmp as $supervision){

	        //             $config_supervision = new ConfigSupervision();

	        //             $config_supervision->academia_id = Auth::user()->academia_id;
	        //             $config_supervision->cargo_id=$request->cargo_supervision;
	        //             $config_supervision->nombre=$supervision['nombre'];

	        //             $config_supervision->save();
	 
	        //         }
	        //     }

         //    	return response()->json(['mensaje' => '¡Excelente! Los campos se han eliminado satisfactoriamente', 'status' => 'OK', 200]);
	        // }else{
	        //     return response()->json(['errores' => ['linea' => [0, 'Ups! ha ocurrido un error, debes agregar un procedimiento']], 'status' => 'ERROR'],422);
	        // }
    	}
    }

    public function eliminar_configuracion($id){

    	$supervisiones = Supervision::withTrashed()
    		->join('staff', 'supervisiones.staff_id','=','staff.id')
    		->select('supervisiones.id')
	        ->where('staff.academia_id',Auth::user()->academia_id)
	        ->where('supervisiones.cargo',$id)
        ->get();
        
        foreach($supervisiones as $supervision){

        	$evaluaciones = SupervisionEvaluacion::withTrashed()->where('supervision_id',$supervision->id)->get();

        	foreach($evaluaciones as $evaluacion){
        		$detalles_evaluacion = DetalleSupervisionEvaluacion::where('evaluacion_id',$evaluacion->id)->delete();
        		$evaluacion->forceDelete();
        	}

        	$horarios_supervision = HorarioSupervision::where('supervision_id',$supervision->id)->delete();
        	$supervision->forceDelete();
        }

        $procedimientos = SupervisionProcedimiento::where('config_supervision_id',$id)->delete();

        $config_supervision = ConfigSupervision::where('cargo_id',$id)
        	->where('academia_id',Auth::user()->academia_id)
        ->forceDelete();

		return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function agregar_supervision_session(Request $request){

    	$rules = [

	        'nombre_procedimiento' => 'required|min:3|max:150',
	    ];

	    $messages = [

	        'nombre_procedimiento.required' => 'Ups! El Nombre es requerido',
	        'nombre_procedimiento.min' => 'El mínimo de caracteres permitidos son 3',
	        'nombre_procedimiento.max' => 'El máximo de caracteres permitidos son 50',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

    	$array = array(['nombre' => $request->nombre_procedimiento]);


        Session::push('supervisiones', $array);


        $items = Session::get('supervisiones');
        end( $items );
        $contador = key( $items );

        $array=array(
            'nombre' => $request->nombre_procedimiento,
            'id'=>$contador
        );


        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 200]);

    }

    public function updateConfiguracion(Request $request){

	    $rules = [

	        'nombre' => 'required|min:3|max:150',
	    ];

	    $messages = [

	        'nombre.required' => 'Ups! El Nombre es requerido',
	        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
	        'nombre.max' => 'El máximo de caracteres permitidos son 50',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

        $supervision = ConfigSupervision::find($request->supervision_id);
        $supervision->nombre = $request->nombre;


        if($supervision->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'id' => $supervision->id, 'nombre' =>  $supervision->nombre, 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

    public function eliminar_supervision_session($id){

        // $horario=HorarioClaseGrupal::find($id);
        // $horario->delete();

        $arreglo = Session::get('supervisiones');
        unset($arreglo[$id]);
        Session::put('supervisiones', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han eliminado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function cancelar_supervision()
    {   
        if (Session::has('supervisiones')) {

            Session::forget('supervisiones');
            return response()->json(['status' => 'OK', 200]);  
        }
        else
        {
            return response()->json(['status' => 'OK', 200]);
        }
    }
}