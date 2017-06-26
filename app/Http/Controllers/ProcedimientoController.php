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
use App\Procedimiento;
use App\HorarioSupervision;
use App\DetalleSupervisionEvaluacion;
use App\SupervisionEvaluacion;
use App\ItemProcedimiento;
use App\Academia;
use App\Instructor;
use DB;
use Session;

class ProcedimientoController extends BaseController {
	
	public function principal_procedimientos($id){

        Session::forget('procedimientos');

    	$procedimientos = Procedimiento::join('config_supervisiones', 'procedimientos.config_supervision_id', '=', 'config_supervisiones.id')
    		->select('procedimientos.*')
    		->where('config_supervisiones.id', $id)
    	->get();

    	$array = array();

    	foreach($procedimientos as $procedimiento){

    		$items = ItemProcedimiento::where('procedimiento_id',$procedimiento->id)->count();

    		$collection=collect($procedimiento);   

            $procedimiento_array = $collection->toArray();
            $procedimiento_array['items']=$items;
            $array[$procedimiento->id] = $procedimiento_array;
            

    	}

        return view('configuracion.supervision.procedimientos')->with(['procedimientos' => $array, 'id' => $id]);

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

                $procedimiento = new Procedimiento;
                $procedimiento->nombre = $request->procedimiento_session;
                $procedimiento->config_supervision_id = $request->id;

                if($procedimiento->save()){

                    $cantidad = 0;
                    $items = array();

    	            foreach($procedimientos as $tmp){
    	                foreach($tmp as $tmp_procedimiento){

    	                    $item_procedimiento = new ItemProcedimiento();

    	                    $item_procedimiento->procedimiento_id=$procedimiento->id;
    	                    $item_procedimiento->nombre=$tmp_procedimiento['nombre'];

    	                    $item_procedimiento->save();

                            $items[] = $item_procedimiento;
                            $cantidad++;
    	 
    	                }
    	            }

                    Session::forget('procedimientos');

                    return response()->json(['mensaje' => '¡Excelente! Los campos se han eliminado satisfactoriamente', 'status' => 'OK', 'id' => $procedimiento->id, 'nombre' => $request->procedimiento_session, 'cantidad' => $cantidad, 'items' => $items, 200]);

                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }

	        }else{
	            return response()->json(['errores' => ['item_session' => [0, 'Ups! ha ocurrido un error, debes agregar un item']], 'status' => 'ERROR'],422);
	        }
    	}
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

        $item_procedimiento = new ItemProcedimiento;
                                        
        $item_procedimiento->nombre = $nombre;
        $item_procedimiento->procedimiento_id = $request->procedimiento_id;

        $item_procedimiento->save();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $item_procedimiento, 'id' => $item_procedimiento->id, 200]);

        }
    }

    public function eliminar_procedimiento_fijo($id){

        $item_procedimiento = ItemProcedimiento::find($id);
        $item_procedimiento->delete();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function consultar_items_procedimientos($id){

        $items = ItemProcedimiento::where('procedimiento_id',$id)->get();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $items, 200]);

    }


    public function eliminar_procedimiento($id){

        $items_procedimientos = ItemProcedimiento::where('procedimiento_id',$id)->delete();
        $procedimiento = Procedimiento::find($id);
        $procedimiento->delete();

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

        $procedimiento = Procedimiento::find($request->procedimiento_id);
        $procedimiento->nombre = $request->procedimiento_fijo;

        if($procedimiento->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'id' => $procedimiento->id, 'nombre' =>  $procedimiento->nombre, 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }
}