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

        Session::forget('procedimientos');

    	$config_supervisiones = ConfigSupervision::join('configuracion_supervisiones', 'config_supervision.config_supervision_id', '=', 'configuracion_supervisiones.id')
    		->select('config_supervision.*')
    		->where('configuracion_supervisiones.id', $id)
    	->get();

    	$array = array();

    	foreach($config_supervisiones as $configuracion){

    		$items = SupervisionProcedimiento::where('config_supervision_id',$configuracion->id)->count();

    		$collection=collect($configuracion);   

            $configuracion_array = $collection->toArray();
            $configuracion_array['items']=$items;
            $array[$configuracion->id] = $configuracion_array;
            

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

	        'item_session' => 'required|min:3|max:150',
	    ];

	    $messages = [

	        'item_session.required' => 'Ups! El Nombre es requerido',
	        'item_session.min' => 'El mínimo de caracteres permitidos son 3',
	        'item_session.max' => 'El máximo de caracteres permitidos son 50',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

    	$array = array(['nombre' => $request->item_session]);


        Session::push('procedimientos', $array);

        $items = Session::get('procedimientos');
        end( $items );
        $contador = key( $items );

        $array=array(
            'nombre' => $request->item_session,
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
		    'procedimiento_session' => 'required',
	    ];

	    $messages = [
	        'procedimiento_session.required' => 'Ups! El Procedimiento es requerido',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }else{

            $procedimientos = Session::get('procedimientos');

            if (count($procedimientos) > 0){

                $config_supervision = new ConfigSupervision;
                $config_supervision->nombre = $request->procedimiento_session;
                $config_supervision->config_supervision_id = $request->id;

                if($config_supervision->save()){

                    $cantidad = 0;
                    $items = array();

    	            foreach($procedimientos as $tmp){
    	                foreach($tmp as $supervision){

    	                    $procedimiento = new SupervisionProcedimiento();

    	                    $procedimiento->config_supervision_id=$config_supervision->id;
    	                    $procedimiento->nombre=$supervision['nombre'];

    	                    $procedimiento->save();

                            $items[] = $procedimiento;
                            $cantidad++;
    	 
    	                }
    	            }

                    return response()->json(['mensaje' => '¡Excelente! Los campos se han eliminado satisfactoriamente', 'status' => 'OK', 'id' => $config_supervision->id, 'nombre' => $request->procedimiento_session, 'cantidad' => $cantidad, 'items' => $items, 200]);

                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }

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

        'item_fijo' => 'required|min:3|max:150',
        'procedimiento_id' => 'required',
    ];

    $messages = [

        'item_fijo.required' => 'Ups! El Nombre es requerido',
        'item_fijo.min' => 'El mínimo de caracteres permitidos son 3',
        'item_fijo.max' => 'El máximo de caracteres permitidos son 50',
        'procedimiento_id.required' => 'Ups! El Procedimiento es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $nombre = title_case($request->item_fijo);

        $supervision = new SupervisionProcedimiento;
                                        
        $supervision->nombre = $nombre;
        $supervision->config_supervision_id = $request->procedimiento_id;

        $supervision->save();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $supervision, 'id' => $supervision->id, 200]);

        }
    }

    public function eliminar_procedimiento_fijo($id){

        $supervision = SupervisionProcedimiento::find($id);

        $supervision->delete();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function consultar_items_procedimientos($id){

        $items = SupervisionProcedimiento::where('config_supervision_id',$id)->get();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $items, 200]);

    }


    public function eliminar_procedimiento($id){

        $procedimientos = SupervisionProcedimiento::where('config_supervision_id',$id)->delete();

        $supervision = ConfigSupervision::find($id);

        $supervision->delete();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function updateProcedimiento(Request $request){

        $rules = [

            'procedimiento_fijo' => 'required|min:3|max:150',
        ];

        $messages = [

            'procedimiento_fijo.required' => 'Ups! El Nombre es requerido',
            'procedimiento_fijo.min' => 'El mínimo de caracteres permitidos son 3',
            'procedimiento_fijo.max' => 'El máximo de caracteres permitidos son 50',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        $supervision = ConfigSupervision::find($request->procedimiento_id);
        $supervision->nombre = $request->procedimiento_fijo;

        if($supervision->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'id' => $supervision->id, 'nombre' =>  $supervision->nombre, 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }
}