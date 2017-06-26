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
use App\ConfigSupervision;
use App\Procedimiento;
use App\ItemProcedimiento;
use App\HorarioSupervision;
use App\Supervision;
use App\ConceptoSupervision;
use App\SupervisionEvaluacion;
use App\DetalleSupervisionEvaluacion;
use App\Academia;
use App\Instructor;
use DB;
use Session;

class ConfigSupervisionController extends BaseController {

	public function principal(){

    	$config_supervision = ConfigSupervision::join('config_staff', 'config_supervisiones.cargo_id', '=', 'config_staff.id')
            ->select('config_supervisiones.*','config_staff.nombre')
            ->where('config_supervisiones.academia_id', Auth::user()->academia_id)
        ->get();

        return view('configuracion.supervision.principal')->with(['config_supervision' => $config_supervision]);
    }


    public function create(){

        $config_supervision = ConfigSupervision::join('config_staff', 'config_supervisiones.cargo_id', '=', 'config_staff.id')
            ->select('config_supervisiones.*','config_staff.nombre')
            ->where('config_supervisiones.academia_id', Auth::user()->academia_id)
        ->get();

        $cargos_usados = array();

        foreach($config_supervision as $configuracion){
            $cargos_usados[] = $configuracion->cargo_id;
        }

    	$cargos = ConfigStaff::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->get();

        return view('configuracion.supervision.create')->with(['cargos' => $cargos, 'cargos_usados' => $cargos_usados]);

    }

    public function planilla($id){

        $config_supervision = ConfigSupervision::join('config_staff', 'config_supervisiones.cargo_id', '=', 'config_staff.id')
             ->select('config_supervisiones.*', 'config_staff.nombre as cargo')
             ->where('config_supervisiones.id', $id)
        ->first();

        if($config_supervision){

            $configuraciones = ConfigSupervision::join('config_staff', 'config_supervisiones.cargo_id', '=', 'config_staff.id')
                ->select('config_supervisiones.*','config_staff.nombre')
                ->where('config_supervisiones.academia_id', Auth::user()->academia_id)
            ->get();

            $cargos_usados = array();

            foreach($configuraciones as $configuracion){
                $cargos_usados[] = $configuracion->cargo_id;
            }

            $cargos = ConfigStaff::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->get();
            
            return view('configuracion.supervision.planilla')->with(['config_supervision' => $config_supervision, 'id' => $id, 'cargos' => $cargos, 'cargos_usados' => $cargos_usados]);

        }else{
            return redirect("configuracion/supervisiones");
        }
    }

    public function operar($id){

        $config_supervision = ConfigSupervision::join('config_staff', 'config_supervisiones.cargo_id', '=', 'config_staff.id')
             ->select('config_supervisiones.*', 'config_staff.nombre as cargo')
             ->where('config_supervisiones.id', $id)
        ->first();

        if($config_supervision){;
            return view('configuracion.supervision.operacion')->with(['config_supervision' => $config_supervision, 'id' => $id]);

        }else{
            return redirect("configuracion/supervisiones");
        }
    }

    public function updateCargo(Request $request){

        $config_supervision = ConfigSupervision::find($request->id);
        $config_supervision->cargo_id = $request->cargo_id;

        if($config_supervision->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }


    public function updateDescripcion(Request $request){

        $config_supervision = ConfigSupervision::find($request->id);
        $config_supervision->descripcion = $request->descripcion;

        if($config_supervision->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
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

            $config_supervision = new ConfigSupervision();

            $config_supervision->academia_id = Auth::user()->academia_id;
            $config_supervision->cargo_id=$request->cargo_supervision;
            $config_supervision->descripcion=$request->descripcion;

            if($config_supervision->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
    	}
    }

    public function eliminar_configuracion($id){

        $config_supervision = ConfigSupervision::find($id);

    	$supervisiones = Supervision::withTrashed()
	        ->where('supervisiones.cargo',$config_supervision->cargo_id)
        ->get();
        
        foreach($supervisiones as $supervision){

            $conceptos = ConceptoSupervision::withTrashed()->where('supervision_id',$supervision->id)->get();

            foreach($conceptos as $concepto){

                $evaluaciones = SupervisionEvaluacion::withTrashed()->where('concepto_id',$concepto->id)->get();

                foreach($evaluaciones as $evaluacion){
                    $detalles_evaluacion = DetalleSupervisionEvaluacion::where('evaluacion_id',$evaluacion->id)->delete();
                    $evaluacion->forceDelete();
                }

                $horarios_supervision = HorarioSupervision::where('concepto_id',$concepto->id)->delete();
                $concepto->forceDelete();
            }

        	$supervision->forceDelete();
        }

        $procedimientos = Procedimiento::where('config_supervision_id',$id)->get();

        foreach($procedimientos as $procedimiento){

            $items_procedimientos = ItemProcedimiento::where('procedimiento_id',$procedimiento->id)->delete();
            $procedimiento->forceDelete();
        }

        $config_supervision->forceDelete();

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