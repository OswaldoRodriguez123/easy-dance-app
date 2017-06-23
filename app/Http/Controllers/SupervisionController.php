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
use App\ConfiguracionSupervision;
use App\HorarioSupervision;
use App\DetalleSupervisionEvaluacion;
use App\ConfigSupervisionEvaluacion;
use App\SupervisionEvaluacion;
use App\SupervisionProcedimiento;
use App\Academia;
use App\Instructor;
use DB;
use Session;

class SupervisionController extends BaseController {

	public function principal()
	{

        $supervisiones = Supervision::join('staff', 'staff.id', '=', 'supervisiones.staff_id')
        	->join('config_staff', 'supervisiones.cargo', '=', 'config_staff.id')
            ->select('staff.*', 'supervisiones.supervisor_id', 'config_staff.nombre as cargo', 'supervisiones.id')
            ->where('staff.academia_id', Auth::user()->academia_id)
        ->get();

        $array = array();

        foreach($supervisiones as $supervision){
        	$staff = Staff::find($supervision->supervisor_id);

        	if($staff){
        		$supervisor = $staff->nombre . ' ' . $staff->apellido;
        	}else{
        		$supervisor = '';
        	}

        	$collection=collect($supervision);   

            $supervision_array = $collection->toArray();
            $supervision_array['supervisor']=$supervisor;
            $array[$supervision->id] = $supervision_array;
        }

		return view('supervisiones.principal')->with(['supervisiones' => $array]);
	}

	public function create()
    {
        $dias_de_semana = DiasDeSemana::all();

        $config_staff = ConfigStaff::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->get();

        $config_supervision = ConfiguracionSupervision::join('config_supervision', 'config_supervision.config_supervision_id', '=', 'configuracion_supervisiones.id')
        	->select('config_supervision.*', 'configuracion_supervisiones.cargo_id')
        	->where('configuracion_supervisiones.academia_id', Auth::user()->academia_id)
        ->get();

        $staffs = Staff::where('academia_id', Auth::user()->academia_id)->get();
        $instructores = Instructor::where('academia_id', Auth::user()->academia_id)->get();

        $array = array();

        foreach($staffs as $item){

            $array[]=array('id' => $item['id'], 'nombre' => $item['nombre'] . ' ' . $item['apellido'], 'tipo' => 1, 'cargo' => 'Staff', 'cargo_id' => $item['cargo']);

        }

        foreach($instructores as $item){

            $array[]=array('id' => $item['id'], 'nombre' => $item['nombre'] . ' ' . $item['apellido'], 'tipo' => 2, 'cargo' => 'Instructor', 'cargo_id' => 20);

        }

        return view('supervisiones.create')->with(['dias_de_semana' => $dias_de_semana, 'config_staff' => $config_staff, 'staffs' => $staffs, 'staffs_instructores' => $array, 'config_supervision' => $config_supervision]);
    }

    public function store(Request $request)
	{

	    $rules = [
	        'supervisor_id' => 'required',
	        'cargo' => 'required',
	        'staff_id' => 'required',
	    ];

	    $messages = [

	        'supervisor_id.required' => 'Ups! El Supervisor es requerido',
	       	'cargo.required' => 'Ups! El Cargo es requerido',
	        'staff_id.required' => 'Ups! El Staff  es requerido ',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

	    else{
	
	    	$staff = explode("-", $request->staff_id);
	        
	        $supervision = new Supervision;

	        $supervision->supervisor_id = $request->supervisor_id;
	        $supervision->staff_id = $staff[0];
	        $supervision->tipo_staff = $staff[1];
	        $supervision->cargo = $request->cargo;

	        if($supervision->save()){

	        	return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
	           
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
	        }
	    }
    }

    public function updateSupervisor(Request $request){

	    $rules = [

	        'supervisor_id' => 'required',
	    ];

	    $messages = [

	        'supervisor_id.required' => 'Ups! El supervisor es requerido',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

        $supervision = Supervision::find($request->id);
        $supervision->supervisor_id = $request->supervisor_id;


        if($supervision->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

    public function updateCargo(Request $request){

	    $rules = [

	        'cargo' => 'required',
	    ];

	    $messages = [

	        'cargo.required' => 'Ups! El cargo es requerido',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

        $supervision = Supervision::find($request->id);
        $supervision->cargo = $request->cargo;

        if($supervision->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

    public function updateStaff(Request $request){

	    $rules = [

	        'staff_id' => 'required',
	    ];

	    $messages = [

	        'staff_id.required' => 'Ups! El staff es requerido',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

        $supervision = Supervision::find($request->id);
        $supervision->staff_id = $request->staff_id;


        if($supervision->save()){
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
	        'fecha.required' => 'Ups! El rango de fecha es requerido',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

	    $fecha = explode(" - ", $request->fecha);
	    $frecuencia = $request->frecuencia;
        $fecha_inicio = Carbon::createFromFormat('d/m/Y H:i:s', $fecha[0] . ' 00:00:00');
        $fecha_inicio_original = Carbon::createFromFormat('d/m/Y H:i:s', $fecha[0] . ' 00:00:00');
        $fecha_final = Carbon::createFromFormat('d/m/Y H:i:s', $fecha[1] . ' 00:00:00');

        $supervision = Supervision::find($request->id);	

        $supervision->fecha_inicio = $fecha_inicio_original;
	    $supervision->fecha_final = $fecha_final;

	    if($supervision->save()){

	    	$array = array();
	        $dia = $fecha_inicio->dayOfWeek;
	       	$status = false;
	       	$entro = false;
	       	$i = 0;

	        while($fecha_inicio <= $fecha_final){

	        	$status = false;
	        	$entro = false;

	        	//DOMINGO

	        	if($request->dia_7){

	        		if($dia == 0){

	        			if($fecha_inicio <= $fecha_final){
	        				$fecha = $fecha_inicio->toDateString();
	        				$array[$fecha] = '';
	        			}

	        		}else{

	        			while($status == false){

	        				if($fecha_inicio > $fecha_inicio_original){

	        					$tipo = 1;

	        				}else{
	        					$tipo = 2;
	        					
	        				}

	        				$dia = $fecha_inicio->dayOfWeek;

	        				while($dia != 0){

		        				if($entro){
	        						$fecha_inicio->addDay();
	        					}else{

			        				if($tipo == 1){
			        					$fecha_inicio->subDay();
			        				}else{
			        					$fecha_inicio->addDay();
			        				}
		        				}

		        				$dia = $fecha_inicio->dayOfWeek;

	        				}

		        			if($fecha_inicio <= $fecha_final){
		        				$fecha = $fecha_inicio->toDateString();
		        				$array[$fecha] = '';
		        				$status = true;
		        			}else{
		        				$status = true;
		        			}
		        			
	        			}

	        		}

	        		$entro = true;
	        	}

	        	//LUNES

	        	$status = false;

	        	if($request->dia_1){

	        		if($dia == 1){

	        			if($fecha_inicio <= $fecha_final){
	        				$fecha = $fecha_inicio->toDateString();
	        				$array[$fecha] = '';
	        			}

	        		}else{

	        			while($status == false){

	        				if($fecha_inicio > $fecha_inicio_original){

	        					$tipo = 1;

	        				}else{
	        					$tipo = 2;
	        					
	        				}

	        				$dia = $fecha_inicio->dayOfWeek;

	        				while($dia != 1){

		        				if($entro){
	        						$fecha_inicio->addDay();
	        					}else{

			        				if($tipo == 1){
			        					$fecha_inicio->subDay();
			        				}else{
			        					$fecha_inicio->addDay();
			        				}
		        				}

		        				$dia = $fecha_inicio->dayOfWeek;

	        				}

		        			if($fecha_inicio <= $fecha_final){
		        				$fecha = $fecha_inicio->toDateString();
		        				$array[$fecha] = '';
		        				$status = true;
		        			}else{
		        				$status = true;
		        			}
		        			
	        			}

	        		}

	        		$entro = true;
	        	}

	        	//MARTES

	        	$status = false;

	        	if($request->dia_2){

	        		if($dia == 2){

	        			if($fecha_inicio <= $fecha_final){
	        				$fecha = $fecha_inicio->toDateString();
	        				$array[$fecha] = '';
	        			}

	        		}else{

	        			while($status == false){

	        				if($fecha_inicio > $fecha_inicio_original){

	        					$tipo = 1;

	        				}else{
	        					$tipo = 2;
	        					
	        				}

	        				$dia = $fecha_inicio->dayOfWeek;

	        				while($dia != 2){

		        				if($entro){
	        						$fecha_inicio->addDay();
	        					}else{

			        				if($tipo == 1){
			        					$fecha_inicio->subDay();
			        				}else{
			        					$fecha_inicio->addDay();
			        				}
		        				}

		        				$dia = $fecha_inicio->dayOfWeek;

	        				}

		        			if($fecha_inicio <= $fecha_final){
		        				$fecha = $fecha_inicio->toDateString();
		        				$array[$fecha] = '';
		        				$status = true;
		        			}else{
		        				$status = true;
		        			}
		        			
	        			}

	        		}

	        		$entro = true;
	        	}

	        	//MIERCOLES

	        	$status = false;

	        	if($request->dia_3){

	        		if($dia == 3){

	        			if($fecha_inicio <= $fecha_final){
	        				$fecha = $fecha_inicio->toDateString();
	        				$array[$fecha] = '';
	        			}

	        		}else{

	        			while($status == false){

	        				if($fecha_inicio > $fecha_inicio_original){

	        					$tipo = 1;

	        				}else{
	        					$tipo = 2;
	        					
	        				}

	        				$dia = $fecha_inicio->dayOfWeek;

	        				while($dia != 3){

		        				if($entro){
	        						$fecha_inicio->addDay();
	        					}else{

			        				if($tipo == 1){
			        					$fecha_inicio->subDay();
			        				}else{
			        					$fecha_inicio->addDay();
			        				}
		        				}

		        				$dia = $fecha_inicio->dayOfWeek;

	        				}

		        			if($fecha_inicio <= $fecha_final){
		        				$fecha = $fecha_inicio->toDateString();
		        				$array[$fecha] = '';
		        				$status = true;
		        			}else{
		        				$status = true;
		        			}
		        			
	        			}

	        		}

	        		$entro = true;
	        	}

	        	//JUEVES

	        	$status = false;

	        	if($request->dia_4){

	        		if($dia == 4){

	        			if($fecha_inicio <= $fecha_final){
	        				$fecha = $fecha_inicio->toDateString();
	        				$array[$fecha] = '';
	        			}

	        		}else{

	        			while($status == false){

	        				if($fecha_inicio > $fecha_inicio_original){

	        					$tipo = 1;

	        				}else{
	        					$tipo = 2;
	        					
	        				}

	        				$dia = $fecha_inicio->dayOfWeek;

	        				while($dia != 4){

		        				if($entro){
	        						$fecha_inicio->addDay();
	        					}else{

			        				if($tipo == 1){
			        					$fecha_inicio->subDay();
			        				}else{
			        					$fecha_inicio->addDay();
			        				}
		        				}

		        				$dia = $fecha_inicio->dayOfWeek;

	        				}

		        			if($fecha_inicio <= $fecha_final){
		        				$fecha = $fecha_inicio->toDateString();
		        				$array[$fecha] = '';
		        				$status = true;
		        			}else{
		        				$status = true;
		        			}
		        			
	        			}

	        		}

	        		$entro = true;
	        	}

	        	//VIERNES

	        	$status = false;

	        	if($request->dia_5){

	        		if($dia == 5){

	        			if($fecha_inicio <= $fecha_final){
	        				$fecha = $fecha_inicio->toDateString();
	        				$array[$fecha] = '';
	        			}

	        		}else{

	        			while($status == false){

	        				if($fecha_inicio > $fecha_inicio_original){

	        					$tipo = 1;

	        				}else{
	        					$tipo = 2;
	        					
	        				}

	        				$dia = $fecha_inicio->dayOfWeek;

	        				while($dia != 5){

		        				if($entro){
	        						$fecha_inicio->addDay();
	        					}else{

			        				if($tipo == 1){
			        					$fecha_inicio->subDay();
			        				}else{
			        					$fecha_inicio->addDay();
			        				}
		        				}

		        				$dia = $fecha_inicio->dayOfWeek;

	        				}

		        			if($fecha_inicio <= $fecha_final){
		        				$fecha = $fecha_inicio->toDateString();
		        				$array[$fecha] = '';
		        				$status = true;
		        			}else{
		        				$status = true;
		        			}
		        			
	        			}

	        		}

	        		$entro = true;
	        	}

	        	//SABADO

	        	$status = false;

	        	if($request->dia_6){

	        		if($dia == 6){

	        			if($fecha_inicio <= $fecha_final){
	        				$fecha = $fecha_inicio->toDateString();
	        				$array[$fecha] = '';
	        			}

	        		}else{

	        			while($status == false){

	        				if($fecha_inicio > $fecha_inicio_original){

	        					$tipo = 1;

	        				}else{
	        					$tipo = 2;
	        					
	        				}

	        				$dia = $fecha_inicio->dayOfWeek;

	        				while($dia != 6){

		        				if($entro){
	        						$fecha_inicio->addDay();
	        					}else{

			        				if($tipo == 1){
			        					$fecha_inicio->subDay();
			        				}else{
			        					$fecha_inicio->addDay();
			        				}
		        				}

		        				$dia = $fecha_inicio->dayOfWeek;

	        				}

		        			if($fecha_inicio <= $fecha_final){
		        				$fecha = $fecha_inicio->toDateString();
		        				$array[$fecha] = '';
		        				$status = true;
		        			}else{
		        				$status = true;
		        			}
		        			
	        			}

	        		}

	        		$entro = true;
	        	}

	        	if($frecuencia=='1'){
	               	$fecha_inicio->addWeek(); 
	           	}elseif($frecuencia=="3"){
	               	$fecha_inicio->addMonth(); 
	           	}else{
	               	$fecha_inicio->addDays(15); 
	           	}

	           	$i++;

	        }

	        $horarios = HorarioSupervision::where('supervision_id',$request->id)->delete();

	        foreach($array as $key=>$value) {

			    $horario = new HorarioSupervision;

		        $horario->supervision_id = $request->id;
		        $horario->fecha = $key;
		        $horario->supervisor_id = $supervision->supervisor_id;

		        $horario->save();
			}

			return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
		}else{
			return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
		}
    }

    public function updateItems(Request $request){

        $supervision = Supervision::find($request->id);
        $supervision->items_a_evaluar = $request->items_a_evaluar;

        if($supervision->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

    public function edit($id)
    {

        $supervision = Supervision::find($id);

        if($supervision){

        	$supervisor = Staff::withTrashed()->find($supervision->supervisor_id);

        	if($supervisor){
        		$supervisor = $supervisor->nombre . ' ' . $supervisor->apellido;
        	}else{
        		$supervisor = '';
        	}

        	$staff = Staff::withTrashed()->find($supervision->staff_id);

        	if($staff){
        		$staff_a_supervisar = $staff->nombre . ' ' . $staff->apellido;
        	}else{
        		$staff_a_supervisar = '';
        	}

        	$cargo = ConfigStaff::withTrashed()->find($supervision->cargo);

        	if($cargo){
        		$cargo_a_supervisar = $cargo->nombre;
        		$cargo_id = $cargo->id;
        	}else{
        		$cargo_a_supervisar = '';
        		$cargo_id = 0;
        	}
        	
        	$staffs = Staff::where('academia_id', Auth::user()->academia_id)->get();
        	$config_staff = ConfigStaff::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->get();

        	$instructores = Instructor::where('academia_id', Auth::user()->academia_id)->get();

	        $array = array();

	        foreach($staffs as $item){

	            $array[]=array('id' => $item['id'], 'nombre' => $item['nombre'] . ' ' . $item['apellido'], 'tipo' => 1, 'cargo' => 'Staff', 'cargo_id' => $item['cargo']);

	        }

	        foreach($instructores as $item){

	            $array[]=array('id' => $item['id'], 'nombre' => $item['nombre'] . ' ' . $item['apellido'], 'tipo' => 2, 'cargo' => 'Instructor', 'cargo_id' => 20);

	        }

            return view('supervisiones.planilla')->with(['staffs' => $staffs, 'supervision' => $supervision, 'supervisor' => $supervisor, 'config_staff' => $config_staff, 'id' => $id, 'cargo_a_supervisar' => $cargo_a_supervisar, 'staff_a_supervisar' => $staff_a_supervisar, 'cargo_id' => $cargo_id, 'staffs_instructores' => $array]);

        }else{
           return redirect("supervisiones");
        }
    }

    public function evaluar($id)
    {   
    	Session::put('id_supervision_evaluacion', $id);

        $supervision = ConfigSupervisionEvaluacion::join('supervisiones', 'config_supervisiones_evaluaciones.supervision_id', '=', 'supervisiones.id')
        	->select('config_supervisiones_evaluaciones.*', 'supervisiones.tipo_staff', 'supervisiones.supervisor_id', 'supervisiones.staff_id')
        	->where('config_supervisiones_evaluaciones.id',$id)
        ->first();

        if($supervision){
        	
        	$staff = Staff::find($supervision->supervisor_id);

        	if($supervision->tipo_staff == 1){
        		$staffs = Staff::where('academia_id', Auth::user()->academia_id)->where('id', '!=', $supervision->staff_id)->get();
        		$staff = Staff::find($supervision->staff_id);
        		$nombre = $staff->nombre . ' ' . $staff->apellido;
        		$cargo = ConfigStaff::find($staff->cargo);
        		$cargo = $cargo->nombre;
        	}else{
        		$staffs = Staff::where('academia_id', Auth::user()->academia_id)->get();
        		$instructor = Instructor::find($supervision->staff_id);
        		$nombre = $instructor->nombre . ' ' . $instructor->apellido;
        		$cargo = 'Instructor';
        	}
        
	    	if($staff){
	    		$supervisor = $staff->nombre . ' ' . $staff->apellido;
	    	}else{
	    		$supervisor = '';
	    	}

	    	$array = array();
	    	$numero_de_items = 0;

    		$items_a_evaluar = SupervisionProcedimiento::where('config_supervision_id',$supervision->procedimiento_id)->get();

			foreach($items_a_evaluar as $item){
				$array[] = $item->nombre;
				$numero_de_items++;
			}

            $hoy = Carbon::now()->format('d-m-Y');
            $academia = Academia::find(Auth::user()->academia_id);

            return view('supervisiones.evaluar')
                   ->with(['staffs' => $staffs, 'supervision' => $supervision, 'fecha' => $hoy, 'items_a_evaluar' => $array, 'id' => $id, 'numero_de_items'=>$numero_de_items, 'academia' => $academia, 'nombre' => $nombre, 'cargo' => $cargo]);
        }else{
           return redirect("supervisiones"); 
        }
    }

    public function storeEvaluacion(Request $request)
    {

        $rules = [

            'supervisor_id' => 'required',
            'total_nota' => 'required',
            'observacion' => 'max:1000',
        ];

        $messages = [

            'supervisor_id.required' => 'Ups! Debe seleccionar un Supervisor',
            'total_nota.required' => 'Ups! Debe evaluar para poder guardar',
            'observacion.max' => 'Ups! no pueden ser mas de 1000 caracteres',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{

            $notas=explode(",",$request->nota_detalle);
            $nombres=explode(",",$request->nombre_detalle);

            $evaluacion = new SupervisionEvaluacion;

            $evaluacion->supervisor_id = $request->supervisor_id;
            $evaluacion->supervision_id = $request->supervision_id;
            $evaluacion->total = $request->total_nota;
            $evaluacion->observacion = $request->observacion;
            $evaluacion->porcentaje = $request->barra_de_progreso;

            if($evaluacion->save()){

            	$i = 0;

            	foreach($nombres as $nombre){

                    $detalle = new DetalleSupervisionEvaluacion;

                    $detalle->nombre = $nombre;
                    $detalle->nota = intval($notas[$i]);
                    $detalle->evaluacion_id = $evaluacion->id;
                    $detalle->save();

                    $i++;
                }
                
                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function evaluaciones()
    {
        $id_evaluacion = Session::get('id_supervision_evaluacion');

        $evaluaciones= SupervisionEvaluacion::join('config_supervisiones_evaluaciones', 'supervision_evaluacion.supervision_id', '=', 'config_supervisiones_evaluaciones.id')
        	->join('supervisiones', 'config_supervisiones_evaluaciones.supervision_id', '=', 'supervisiones.id')
            ->join('staff', 'supervisiones.staff_id', '=', 'staff.id')
            ->select('supervision_evaluacion.*','staff.nombre', 'staff.apellido')
            ->where('staff.academia_id', '=' ,  Auth::user()->academia_id)
        ->get();

        $array = array();

        foreach($evaluaciones as $evaluacion){

        	$staff = Staff::find($evaluacion->supervisor_id);

        	if($staff){
        		$supervisor = $staff->nombre . ' ' . $staff->apellido;
        	}else{
        		$supervisor = '';
        	}

        	$collection=collect($evaluacion);   

            $supervision_array = $collection->toArray();
            $supervision_array['supervisor']=$supervisor;
            $array[$evaluacion->id] = $supervision_array;
        }

        return view('supervisiones.evaluaciones')->with(['evaluaciones' => $array,'id_evaluacion'=>$id_evaluacion]);
    }

    public function evaluaciones_por_supervision($id)
    {

        $evaluaciones= SupervisionEvaluacion::join('config_supervisiones_evaluaciones', 'supervision_evaluacion.supervision_id', '=', 'config_supervisiones_evaluaciones.id')
        	->join('supervisiones', 'config_supervisiones_evaluaciones.supervision_id', '=', 'supervisiones.id')
            ->join('staff', 'supervisiones.staff_id', '=', 'staff.id')
            ->select('supervision_evaluacion.*','staff.nombre', 'staff.apellido')
            ->where('config_supervisiones_evaluaciones.id', '=' ,  $id)
        ->get();

        $array = array();
        $porcentaje_total = 0;

        foreach($evaluaciones as $evaluacion){

        	$staff = Staff::find($evaluacion->supervisor_id);

        	if($staff){
        		$supervisor = $staff->nombre . ' ' . $staff->apellido;
        	}else{
        		$supervisor = '';
        	}

        	$collection=collect($evaluacion);   

            $supervision_array = $collection->toArray();
            $supervision_array['supervisor']=$supervisor;
            $array[$evaluacion->id] = $supervision_array;
            $porcentaje_total = $porcentaje_total + $evaluacion->porcentaje;
        }

        $cantidad = count($array);

        if($cantidad > 0){

	        $porcentaje = $porcentaje_total / $cantidad;
	        $porcentaje = intval($porcentaje);
        }else{
        	$porcentaje = 0;
        }

        return view('supervisiones.evaluaciones')->with(['evaluaciones' => $array, 'id'=>$id, 'porcentaje' => $porcentaje]);
    }


    public function getDetalle($id){

        //DATOS DE ENCABEZADO
        
        $evaluacion = SupervisionEvaluacion::join('config_supervisiones_evaluaciones', 'supervision_evaluacion.supervision_id', '=', 'config_supervisiones_evaluaciones.id')
        	->join('supervisiones', 'config_supervisiones_evaluaciones.supervision_id', '=', 'supervisiones.id')
    		->join('staff', 'supervisiones.supervisor_id','=','staff.id')
	        ->join('config_staff', 'supervisiones.cargo','=','config_staff.id')
	        ->select('supervisiones.*', 'config_staff.nombre as cargo', 'staff.nombre', 'staff.apellido', 'supervision_evaluacion.total', 'supervision_evaluacion.porcentaje')
	        ->where('supervision_evaluacion.id', $id)
        ->first();
        
        $staff = SupervisionEvaluacion::join('config_supervisiones_evaluaciones', 'supervision_evaluacion.supervision_id', '=', 'config_supervisiones_evaluaciones.id')
        	->join('supervisiones', 'config_supervisiones_evaluaciones.supervision_id', '=', 'supervisiones.id')
    		->join('staff', 'supervisiones.staff_id','=','staff.id')
            ->select('staff.*')
            ->where('supervision_evaluacion.id','=',$id)
        ->first();

        $academia = SupervisionEvaluacion::join('config_supervisiones_evaluaciones', 'supervision_evaluacion.supervision_id', '=', 'config_supervisiones_evaluaciones.id')
        	->join('supervisiones', 'config_supervisiones_evaluaciones.supervision_id', '=', 'supervisiones.id')
			->join('staff', 'supervisiones.staff_id','=','staff.id')
			->join('academias', 'staff.academia_id','=','academias.id')
            ->select('academias.*')
            ->where('supervision_evaluacion.id','=',$id)
        ->first();
            
        //DATOS DE DETALLE
        $detalles_notas = DetalleSupervisionEvaluacion::select('nombre', 'nota')
            ->where('evaluacion_id','=',$id)
        ->get();
        
        return view('supervisiones.detalle')->with([
        	'evaluacion'               => $evaluacion,
            'staff'                    => $staff, 
            'academia'                 => $academia, 
            'detalle_notas'            => $detalles_notas,

        ]);
    }

    public function destroy($id)
    {	
    	$config_supervisiones = ConfigSupervisionEvaluacion::where('supervision_id',$id)->get();

    	foreach($config_supervisiones as $configuracion){
    		$horarios = HorarioSupervision::where('supervision_id',$configuracion->id)->delete();
    		$configuracion->delete();
    	}
    	
        $supervision = Supervision::find($id);
        
        if($supervision->delete()){
            return response()->json(['mensaje' => '¡Excelente! La supervision se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function deleteConcepto($id)
    {

    	$config_supervisiones = ConfigSupervisionEvaluacion::find($id);
    	$horarios = HorarioSupervision::where('supervision_id',$id)->delete();
 
        if($config_supervisiones->delete()){
            return response()->json(['mensaje' => '¡Excelente! La supervision se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function agenda($id){

    	$supervision = ConfigSupervisionEvaluacion::find($id);

    	if($supervision){

	    	$activas = array();
	    	$finalizadas = array();

	    	$horarios = HorarioSupervision::join('staff', 'staff.id', '=', 'horarios_supervision.supervisor_id')
	    		->select('horarios_supervision.*', 'staff.nombre', 'staff.apellido')
	    		->where('supervision_id',$id)
	    	->get();

	    	foreach($horarios as $horario){

	    		$fecha = Carbon::createFromFormat('Y-m-d',$horario->fecha);

		    	if($fecha >= Carbon::now()){
		            $activas[]=array("id" => $horario->id,"fecha"=>$fecha->toDateString(), "supervisor" => $horario->nombre . ' ' . $horario->apellido);
		        }else{
		            $finalizadas[]=array("id" => $horario->id,"fecha"=>$fecha->toDateString(), "supervisor" => $horario->nombre . ' ' . $horario->apellido);
		        }
	        }

	        return view('supervisiones.agenda')->with(['activas' => $activas, 'finalizadas' => $finalizadas, 'id'=> $supervision->supervision_id]);
        }else{
        	return redirect("supervisiones");
        }
    }

    public function eliminadas()
	{

        $supervisiones = Supervision::onlyTrashed()->join('staff', 'staff.id', '=', 'supervisiones.staff_id')
        	->join('config_staff', 'staff.cargo', '=', 'config_staff.id')
            ->select('staff.*', 'supervisiones.supervisor_id', 'supervisiones.fecha_inicio', 'supervisiones.fecha_final', 'config_staff.nombre as cargo', 'supervisiones.id')
            ->where('staff.academia_id', Auth::user()->academia_id)
        ->get();

        $array = array();

        foreach($supervisiones as $supervision){
        	$staff = Staff::find($supervision->supervisor_id);

        	if($staff){
        		$supervisor = $staff->nombre . ' ' . $staff->apellido;
        	}else{
        		$supervisor = '';
        	}

        	$collection=collect($supervision);   

            $supervision_array = $collection->toArray();
            $supervision_array['supervisor']=$supervisor;
            $array[$supervision->id] = $supervision_array;
        }

		return view('supervisiones.eliminadas')->with(['supervisiones' => $array]);
	}

	public function eliminar_permanentemente($id)
    {
        
     	$supervision = Supervision::withTrashed()->find($id);

     	if($supervision){

     	    $evaluaciones = SupervisionEvaluacion::withTrashed()->where('supervision_id',$id)->get();

        	foreach($evaluaciones as $evaluacion){
        		$detalle_evaluacion = DetalleSupervisionEvaluacion::where('evaluacion_id',$evaluacion->id)->delete();
        		$evaluacion->forceDelete();
        	}

	        if($supervision->forceDelete()){
	            return response()->json(['mensaje' => '¡Excelente! La supervision ha sido eliminada permanentemente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
        }else{
    		return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        
    	}

    }

    public function restore($id)
    {
            
        $supervision = Supervision::withTrashed()->find($id);

        if($supervision){
	        
	        if($supervision->restore()){
	            return response()->json(['mensaje' => '¡Excelente! La supervision ha sido restaurada satisfactoriamente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
    	}else{
    		return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        
    	}

    }

    public function conceptos($id)
	{
		$supervision = Supervision::find($id);

		if($supervision){

			$dias_de_semana = DiasDeSemana::all();

	        $procedimientos = ConfigSupervision::join('configuracion_supervisiones', 'configuracion_supervisiones.id', '=', 'config_supervision.config_supervision_id')
	        	->select('config_supervision.*')
	        	->where('configuracion_supervisiones.cargo_id',$supervision->cargo)
	        ->get();

	        $config_supervisiones = ConfigSupervisionEvaluacion::join('config_supervision', 'config_supervisiones_evaluaciones.procedimiento_id', '=', 'config_supervision.id')
	        	->select('config_supervisiones_evaluaciones.*', 'config_supervision.nombre')
	        	->where('config_supervisiones_evaluaciones.supervision_id',$id)
	        ->get();

	        $array = array();

	        foreach($config_supervisiones as $configuracion){

	        	$items_a_evaluar = SupervisionProcedimiento::where('config_supervision_id',$configuracion->procedimiento_id)->count();

	        	$collection=collect($configuracion);   

	            $configuracion_array = $collection->toArray();
	            $configuracion_array['items']=$items_a_evaluar;
	            $array[$configuracion->id] = $configuracion_array;
	        }

			return view('supervisiones.conceptos')->with(['config_supervisiones' => $array, 'procedimientos' => $procedimientos, 'dias_de_semana' => $dias_de_semana, 'id' => $id]);
		}else{
			return redirect("supervisiones");
		}
	}

	public function storeConcepto(Request $request)
	{

	    $rules = [
	        'procedimiento_id' => 'required',
	        'fecha' => 'required',
	        'frecuencia' => 'required',
	    ];

	    $messages = [

	        'procedimiento_id.required' => 'Ups! El Concepto a Evaluar es requerido',
	        'fecha.required' => 'Ups! El rango de fecha es requerido',
	        'frecuencia.required' => 'Ups! La frecuencia es requerida',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

	    else{

	    	$fecha = explode(" - ", $request->fecha);	

	    	$frecuencia = $request->frecuencia;
	        $fecha_inicio = Carbon::createFromFormat('d/m/Y H:i:s', $fecha[0] . ' 00:00:00');
	        $fecha_inicio_original = Carbon::createFromFormat('d/m/Y H:i:s', $fecha[0] . ' 00:00:00');
	        $fecha_final = Carbon::createFromFormat('d/m/Y H:i:s', $fecha[1] . ' 00:00:00');
	        
	        $supervision = new ConfigSupervisionEvaluacion;

	        $supervision->supervision_id = $request->id;
	        $supervision->procedimiento_id = $request->procedimiento_id;
	        $supervision->fecha_inicio = $fecha_inicio_original;
	        $supervision->fecha_final = $fecha_final;

	        if($supervision->save()){

	        	$array = array();
		        $dia = $fecha_inicio->dayOfWeek;
		       	$status = false;
		       	$entro = false;
		       	$i = 0;

		        while($fecha_inicio <= $fecha_final){

		        	$status = false;
		        	$entro = false;

		        	//DOMINGO

		        	if($request->dia_7){

		        		if($dia == 0){

		        			if($fecha_inicio <= $fecha_final){
		        				$fecha = $fecha_inicio->toDateString();
		        				$array[$fecha] = '';
		        			}

		        		}else{

		        			while($status == false){

		        				if($fecha_inicio > $fecha_inicio_original){

		        					$tipo = 1;

		        				}else{
		        					$tipo = 2;
		        					
		        				}

		        				$dia = $fecha_inicio->dayOfWeek;

		        				while($dia != 0){

			        				if($entro){
		        						$fecha_inicio->addDay();
		        					}else{

				        				if($tipo == 1){
				        					$fecha_inicio->subDay();
				        				}else{
				        					$fecha_inicio->addDay();
				        				}
			        				}

			        				$dia = $fecha_inicio->dayOfWeek;

		        				}

			        			if($fecha_inicio <= $fecha_final){
			        				$fecha = $fecha_inicio->toDateString();
			        				$array[$fecha] = '';
			        				$status = true;
			        			}else{
			        				$status = true;
			        			}
			        			
		        			}
		
		        		}

		        		$entro = true;
		        	}

		        	//LUNES

		        	$status = false;

		        	if($request->dia_1){

		        		if($dia == 1){

		        			if($fecha_inicio <= $fecha_final){
		        				$fecha = $fecha_inicio->toDateString();
		        				$array[$fecha] = '';
		        			}

		        		}else{

		        			while($status == false){

		        				if($fecha_inicio > $fecha_inicio_original){

		        					$tipo = 1;

		        				}else{
		        					$tipo = 2;
		        					
		        				}

		        				$dia = $fecha_inicio->dayOfWeek;

		        				while($dia != 1){

			        				if($entro){
		        						$fecha_inicio->addDay();
		        					}else{

				        				if($tipo == 1){
				        					$fecha_inicio->subDay();
				        				}else{
				        					$fecha_inicio->addDay();
				        				}
			        				}

			        				$dia = $fecha_inicio->dayOfWeek;

		        				}

			        			if($fecha_inicio <= $fecha_final){
			        				$fecha = $fecha_inicio->toDateString();
			        				$array[$fecha] = '';
			        				$status = true;
			        			}else{
			        				$status = true;
			        			}
			        			
		        			}
		
		        		}

		        		$entro = true;
		        	}

		        	//MARTES

		        	$status = false;

		        	if($request->dia_2){

		        		if($dia == 2){

		        			if($fecha_inicio <= $fecha_final){
		        				$fecha = $fecha_inicio->toDateString();
		        				$array[$fecha] = '';
		        			}

		        		}else{

		        			while($status == false){

		        				if($fecha_inicio > $fecha_inicio_original){

		        					$tipo = 1;

		        				}else{
		        					$tipo = 2;
		        					
		        				}

		        				$dia = $fecha_inicio->dayOfWeek;

		        				while($dia != 2){

			        				if($entro){
		        						$fecha_inicio->addDay();
		        					}else{

				        				if($tipo == 1){
				        					$fecha_inicio->subDay();
				        				}else{
				        					$fecha_inicio->addDay();
				        				}
			        				}

			        				$dia = $fecha_inicio->dayOfWeek;

		        				}

			        			if($fecha_inicio <= $fecha_final){
			        				$fecha = $fecha_inicio->toDateString();
			        				$array[$fecha] = '';
			        				$status = true;
			        			}else{
			        				$status = true;
			        			}
			        			
		        			}
		
		        		}

		        		$entro = true;
		        	}

		        	//MIERCOLES

		        	$status = false;

		        	if($request->dia_3){

		        		if($dia == 3){

		        			if($fecha_inicio <= $fecha_final){
		        				$fecha = $fecha_inicio->toDateString();
		        				$array[$fecha] = '';
		        			}

		        		}else{

		        			while($status == false){

		        				if($fecha_inicio > $fecha_inicio_original){

		        					$tipo = 1;

		        				}else{
		        					$tipo = 2;
		        					
		        				}

		        				$dia = $fecha_inicio->dayOfWeek;

		        				while($dia != 3){

			        				if($entro){
		        						$fecha_inicio->addDay();
		        					}else{

				        				if($tipo == 1){
				        					$fecha_inicio->subDay();
				        				}else{
				        					$fecha_inicio->addDay();
				        				}
			        				}

			        				$dia = $fecha_inicio->dayOfWeek;

		        				}

			        			if($fecha_inicio <= $fecha_final){
			        				$fecha = $fecha_inicio->toDateString();
			        				$array[$fecha] = '';
			        				$status = true;
			        			}else{
			        				$status = true;
			        			}
			        			
		        			}
		
		        		}

		        		$entro = true;
		        	}

		        	//JUEVES

		        	$status = false;

		        	if($request->dia_4){

		        		if($dia == 4){

		        			if($fecha_inicio <= $fecha_final){
		        				$fecha = $fecha_inicio->toDateString();
		        				$array[$fecha] = '';
		        			}

		        		}else{

		        			while($status == false){

		        				if($fecha_inicio > $fecha_inicio_original){

		        					$tipo = 1;

		        				}else{
		        					$tipo = 2;
		        					
		        				}

		        				$dia = $fecha_inicio->dayOfWeek;

		        				while($dia != 4){

			        				if($entro){
		        						$fecha_inicio->addDay();
		        					}else{

				        				if($tipo == 1){
				        					$fecha_inicio->subDay();
				        				}else{
				        					$fecha_inicio->addDay();
				        				}
			        				}

			        				$dia = $fecha_inicio->dayOfWeek;

		        				}

			        			if($fecha_inicio <= $fecha_final){
			        				$fecha = $fecha_inicio->toDateString();
			        				$array[$fecha] = '';
			        				$status = true;
			        			}else{
			        				$status = true;
			        			}
			        			
		        			}
		
		        		}

		        		$entro = true;
		        	}

		        	//VIERNES

		        	$status = false;

		        	if($request->dia_5){

		        		if($dia == 5){

		        			if($fecha_inicio <= $fecha_final){
		        				$fecha = $fecha_inicio->toDateString();
		        				$array[$fecha] = '';
		        			}

		        		}else{

		        			while($status == false){

		        				if($fecha_inicio > $fecha_inicio_original){

		        					$tipo = 1;

		        				}else{
		        					$tipo = 2;
		        					
		        				}

		        				$dia = $fecha_inicio->dayOfWeek;

		        				while($dia != 5){

			        				if($entro){
		        						$fecha_inicio->addDay();
		        					}else{

				        				if($tipo == 1){
				        					$fecha_inicio->subDay();
				        				}else{
				        					$fecha_inicio->addDay();
				        				}
			        				}

			        				$dia = $fecha_inicio->dayOfWeek;

		        				}

			        			if($fecha_inicio <= $fecha_final){
			        				$fecha = $fecha_inicio->toDateString();
			        				$array[$fecha] = '';
			        				$status = true;
			        			}else{
			        				$status = true;
			        			}
			        			
		        			}
		
		        		}

		        		$entro = true;
		        	}

		        	//SABADO

		        	$status = false;

		        	if($request->dia_6){

		        		if($dia == 6){

		        			if($fecha_inicio <= $fecha_final){
		        				$fecha = $fecha_inicio->toDateString();
		        				$array[$fecha] = '';
		        			}

		        		}else{

		        			while($status == false){

		        				if($fecha_inicio > $fecha_inicio_original){

		        					$tipo = 1;

		        				}else{
		        					$tipo = 2;
		        					
		        				}

		        				$dia = $fecha_inicio->dayOfWeek;

		        				while($dia != 6){

			        				if($entro){
		        						$fecha_inicio->addDay();
		        					}else{

				        				if($tipo == 1){
				        					$fecha_inicio->subDay();
				        				}else{
				        					$fecha_inicio->addDay();
				        				}
			        				}

			        				$dia = $fecha_inicio->dayOfWeek;

		        				}

			        			if($fecha_inicio <= $fecha_final){
			        				$fecha = $fecha_inicio->toDateString();
			        				$array[$fecha] = '';
			        				$status = true;
			        			}else{
			        				$status = true;
			        			}
			        			
		        			}
		
		        		}

		        		$entro = true;
		        	}

		        	if($frecuencia=='1'){
	                   	$fecha_inicio->addWeek(); 
	               	}elseif($frecuencia=="3"){
	                   	$fecha_inicio->addMonth(); 
	               	}else{
	                   	$fecha_inicio->addDays(15); 
	               	}

	               	$i++;

		        }	

		        $tmp_supervision = Supervision::find($request->id);

	        	foreach($array as $key=>$value) {

				    $horario = new HorarioSupervision;

			        $horario->supervision_id = $supervision->id;
			        $horario->fecha = $key;
			        $horario->supervisor_id = $tmp_supervision->supervisor_id;

			        $horario->save();
				}

				$procedimiento = ConfigSupervision::find($request->procedimiento_id);
				$cantidad = SupervisionProcedimiento::where('config_supervision_id',$procedimiento->id)->count();

	        	return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'id' => $supervision->id, 'nombre' => $procedimiento->nombre, 'cantidad' => $cantidad, 'fecha' => $request->fecha, 'status' => 'OK', 200]);
	           
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
	        }
	    }
    }
    
}