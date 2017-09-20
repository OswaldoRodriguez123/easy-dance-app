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
use Illuminate\Support\Facades\Hash;
use App\Supervision;
use App\ConfigSupervision;
use App\Procedimiento;
use App\HorarioSupervision;
use App\DetalleSupervisionEvaluacion;
use App\ConceptoSupervision;
use App\SupervisionEvaluacion;
use App\ItemProcedimiento;
use App\Academia;
use App\Instructor;
use App\User;
use App\Notificacion;
use App\NotificacionUsuario;
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

        	$conceptos = ConceptoSupervision::where('supervision_id',$supervision->id)->count();

        	$collection=collect($supervision);   

            $supervision_array = $collection->toArray();
            $supervision_array['supervisor']=$supervisor;
            $supervision_array['conceptos']=$conceptos;
            $array[$supervision->id] = $supervision_array;
        }

		return view('supervisiones.principal')->with(['supervisiones' => $array]);
	}

	public function create()
    {

        $config_staff = ConfigStaff::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->get();

        $staffs = Staff::where('academia_id', Auth::user()->academia_id)->get();
        $instructores = Instructor::where('academia_id', Auth::user()->academia_id)->get();

        $array = array();

        foreach($staffs as $item){

            $array[]=array('id' => $item['id'], 'nombre' => $item['nombre'] . ' ' . $item['apellido'], 'tipo' => 1, 'cargo' => 'Staff', 'cargo_id' => $item['cargo']);

        }

        foreach($instructores as $item){

            $array[]=array('id' => $item['id'], 'nombre' => $item['nombre'] . ' ' . $item['apellido'], 'tipo' => 2, 'cargo' => 'Instructor', 'cargo_id' => 20);

        }

        return view('supervisiones.create')->with(['config_staff' => $config_staff, 'staffs' => $staffs, 'staffs_instructores' => $array]);
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

        $concepto = ConceptoSupervision::join('supervisiones', 'conceptos_supervisiones.supervision_id', '=', 'supervisiones.id')
        	->select('conceptos_supervisiones.*', 'supervisiones.tipo_staff', 'supervisiones.supervisor_id', 'supervisiones.staff_id')
        	->where('conceptos_supervisiones.id',$id)
        ->first();

        if($concepto){
        	
        	$staff = Staff::find($concepto->supervisor_id);

        	if($concepto->tipo_staff == 1){
        		$staffs = Staff::where('academia_id', Auth::user()->academia_id)->where('id', '!=', $concepto->staff_id)->get();
        		$staff = Staff::find($concepto->staff_id);
        		$nombre = $staff->nombre . ' ' . $staff->apellido;
        		$cargo = ConfigStaff::find($staff->cargo);
        		$cargo = $cargo->nombre;
        	}else{
        		$staffs = Staff::where('academia_id', Auth::user()->academia_id)->get();
        		$instructor = Instructor::find($concepto->staff_id);
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

    		$items_a_evaluar = ItemProcedimiento::where('procedimiento_id',$concepto->procedimiento_id)->get();

			foreach($items_a_evaluar as $item){
				$array[] = $item->nombre;
				$numero_de_items++;
			}

            $hoy = Carbon::now()->format('d-m-Y');
            $academia = Academia::find(Auth::user()->academia_id);

            return view('supervisiones.evaluar')
                   ->with(['staffs' => $staffs, 'concepto' => $concepto, 'fecha' => $hoy, 'items_a_evaluar' => $array, 'id' => $id, 'numero_de_items'=>$numero_de_items, 'academia' => $academia, 'nombre' => $nombre, 'cargo' => $cargo, 'supervision_id'=> $concepto->supervision_id]);
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

            $evaluacion = new SupervisionEvaluacion;

            $evaluacion->supervisor_id = $request->supervisor_id;
            $evaluacion->concepto_id = $request->concepto_id;
            $evaluacion->total = $request->total_nota;
            $evaluacion->observacion = $request->observacion;
            $evaluacion->porcentaje = $request->barra_de_progreso;

            if($evaluacion->save()){

            	$concepto = ConceptoSupervision::find($request->concepto_id);
            	$items_a_evaluar = ItemProcedimiento::where('procedimiento_id',$concepto->procedimiento_id)->get();

            	$i = 0;

            	foreach($items_a_evaluar as $item){

                    $detalle = new DetalleSupervisionEvaluacion;

                    $detalle->nombre = $item->nombre;
                    $detalle->nota = intval($notas[$i]);
                    $detalle->evaluacion_id = $evaluacion->id;
                    $detalle->save();

                }

                $supervision = Supervision::join('conceptos_supervisiones', 'conceptos_supervisiones.supervision_id', '=', 'supervisiones.id')
        			->join('supervisiones_evaluaciones', 'supervisiones_evaluaciones.concepto_id', '=', 'conceptos_supervisiones.id')
        			->select('supervisiones.*')
        			->where('supervisiones_evaluaciones.id',$evaluacion->id)
        		->first();

        		if($supervision){

        			if($supervision->tipo_staff == 1){
        				$tipo = 8;
        			}else{
        				$tipo = 3;
        			}

        			$usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
        				->select('users.id')
                        ->where('usuarios_tipo.tipo_id',$supervision->staff_id)
                        ->where('usuarios_tipo.tipo',$tipo)
                    ->first();

                    if($usuario){

		                $notificacion = new Notificacion; 

		                $notificacion->tipo_evento = 8;
		                $notificacion->evento_id = $evaluacion->id;
		                $notificacion->mensaje = "Tienes una nueva supervisión. Verifica los resultados";
		                $notificacion->titulo = "Nueva Supervisión";

		                if($notificacion->save()){

	                      	$usuarios_notificados = new NotificacionUsuario;
	                      	$usuarios_notificados->id_usuario = $usuario->id;
	                      	$usuarios_notificados->id_notificacion = $notificacion->id;
	                      	$usuarios_notificados->visto = 0;
	                      	$usuarios_notificados->save();
		                }
	                }
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

        $evaluaciones = SupervisionEvaluacion::join('conceptos_supervisiones', 'supervisiones_evaluaciones.concepto_id', '=', 'conceptos_supervisiones.id')
        	->join('supervisiones', 'conceptos_supervisiones.supervision_id', '=', 'supervisiones.id')
            ->join('staff', 'supervisiones.staff_id', '=', 'staff.id')
            ->select('supervisiones_evaluaciones.*','staff.nombre', 'staff.apellido')
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

        return view('supervisiones.evaluaciones')->with(['evaluaciones' => $array, 'id_evaluacion' => $id_evaluacion]);
    }

    public function evaluaciones_vista_staff(){

        $evaluaciones = SupervisionEvaluacion::join('conceptos_supervisiones', 'supervisiones_evaluaciones.concepto_id', '=', 'conceptos_supervisiones.id')
        	->join('supervisiones', 'conceptos_supervisiones.supervision_id', '=', 'supervisiones.id')
            ->join('staff', 'supervisiones.staff_id', '=', 'staff.id')
            ->join('usuarios_tipo', 'usuarios_tipo.tipo_id', '=', 'staff.id')
            ->join('users', 'usuarios_tipo.usuario_id', '=', 'users.id')
            ->select('supervisiones_evaluaciones.*','staff.nombre', 'staff.apellido')
            ->where('users.id', '=' ,  Auth::user()->id)
            ->where('usuarios_tipo.tipo',8)
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

        return view('supervisiones.evaluaciones')->with(['evaluaciones' => $array]);
    }

    public function evaluaciones_por_supervision($id)
    {

        $evaluaciones = SupervisionEvaluacion::join('conceptos_supervisiones', 'supervisiones_evaluaciones.concepto_id', '=', 'conceptos_supervisiones.id')
        	->join('supervisiones', 'conceptos_supervisiones.supervision_id', '=', 'supervisiones.id')
            ->join('staff', 'supervisiones.staff_id', '=', 'staff.id')
            ->select('supervisiones_evaluaciones.*','staff.nombre', 'staff.apellido')
            ->where('conceptos_supervisiones.id', '=' ,  $id)
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

        $concepto = ConceptoSupervision::find($id);

        return view('supervisiones.evaluaciones')->with(['evaluaciones' => $array, 'id' => $concepto->supervision_id, 'porcentaje' => $porcentaje]);
    }


    public function getDetalle($id){

        //DATOS DE ENCABEZADO
        
        $evaluacion = SupervisionEvaluacion::join('conceptos_supervisiones', 'supervisiones_evaluaciones.concepto_id', '=', 'conceptos_supervisiones.id')
        	->join('supervisiones', 'conceptos_supervisiones.supervision_id', '=', 'supervisiones.id')
    		->join('staff', 'supervisiones.supervisor_id','=','staff.id')
	        ->join('config_staff', 'supervisiones.cargo','=','config_staff.id')
	        ->select('supervisiones.*', 'config_staff.nombre as cargo', 'staff.nombre', 'staff.apellido', 'supervisiones_evaluaciones.total', 'supervisiones_evaluaciones.porcentaje', 'supervisiones_evaluaciones.observacion')
	        ->where('supervisiones_evaluaciones.id', $id)
        ->first();

        if($evaluacion){
	        
	        $staff = SupervisionEvaluacion::join('conceptos_supervisiones', 'supervisiones_evaluaciones.concepto_id', '=', 'conceptos_supervisiones.id')
	        	->join('supervisiones', 'conceptos_supervisiones.supervision_id', '=', 'supervisiones.id')
	    		->join('staff', 'supervisiones.staff_id','=','staff.id')
	            ->select('staff.*')
	            ->where('supervisiones_evaluaciones.id','=',$id)
	        ->first();

	        $academia = SupervisionEvaluacion::join('conceptos_supervisiones', 'supervisiones_evaluaciones.concepto_id', '=', 'conceptos_supervisiones.id')
	        	->join('supervisiones', 'conceptos_supervisiones.supervision_id', '=', 'supervisiones.id')
				->join('staff', 'supervisiones.staff_id','=','staff.id')
				->join('academias', 'staff.academia_id','=','academias.id')
	            ->select('academias.*')
	            ->where('supervisiones_evaluaciones.id','=',$id)
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
    	}else{
    		return redirect("inicio");
    	}
    }

    public function eliminar_evaluacion(Request $request)
    {
        $academia = Academia::find(Auth::user()->academia_id);

        if($academia->password_supervision){
            if(!Hash::check($request->password_supervision, $academia->password_supervision)) {
                return response()->json(['error_mensaje'=> 'Ups! La contraseña no coincide', 'status' => 'ERROR-PASSWORD'],422);
            }
        }

        $evaluacion = SupervisionEvaluacion::find($request->id);

        if($evaluacion->delete()){

        	$detalle_evaluacion = DetalleSupervisionEvaluacion::where('evaluacion_id',$request->id)->delete();

        	$notificacion = Notificacion::where('tipo_evento',8)->where('evento_id',$request->id)->first();
            if($notificacion){
                $notificacion_usuario = NotificacionUsuario::where('id_notificacion',$notificacion->id)->delete();
                $notificacion->delete();
            }

            return response()->json(['mensaje' => '¡Excelente! La evaluación se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function destroy($id)
    {	
    	$config_supervisiones = ConceptoSupervision::where('supervision_id',$id)->get();

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

    	$concepto = ConceptoSupervision::find($id);
    	$horarios = HorarioSupervision::where('concepto_id',$id)->delete();
 
        if($concepto->delete()){
            return response()->json(['mensaje' => '¡Excelente! La supervision se ha eliminado satisfactoriamente', 'procedimiento_id' => $concepto->procedimiento_id, 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function agenda($id){

    	$concepto = ConceptoSupervision::find($id);

    	if($concepto){

	    	$activas = array();
	    	$finalizadas = array();

	    	$horarios = HorarioSupervision::join('staff', 'staff.id', '=', 'horarios_supervision.supervisor_id')
	    		->select('horarios_supervision.*', 'staff.nombre', 'staff.apellido')
	    		->where('concepto_id',$id)
	    	->get();

	    	foreach($horarios as $horario){

	    		$fecha = Carbon::createFromFormat('Y-m-d',$horario->fecha);

		    	if($fecha >= Carbon::now()){
		            $activas[]=array("id" => $horario->id,"fecha"=>$fecha->toDateString(), "supervisor" => $horario->nombre . ' ' . $horario->apellido);
		        }else{
		            $finalizadas[]=array("id" => $horario->id,"fecha"=>$fecha->toDateString(), "supervisor" => $horario->nombre . ' ' . $horario->apellido);
		        }
	        }

	        return view('supervisiones.agenda')->with(['activas' => $activas, 'finalizadas' => $finalizadas, 'id'=> $concepto->supervision_id]);
        }else{
        	return redirect("supervisiones");
        }
    }

    public function eliminadas()
	{

        $supervisiones = Supervision::onlyTrashed()->join('staff', 'staff.id', '=', 'supervisiones.staff_id')
        	->join('config_staff', 'staff.cargo', '=', 'config_staff.id')
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

	        $procedimientos = Procedimiento::join('config_supervisiones', 'config_supervisiones.id', '=', 'procedimientos.config_supervision_id')
	        	->select('procedimientos.*')
	        	->where('config_supervisiones.cargo_id',$supervision->cargo)
	        ->get();

	        $conceptos = ConceptoSupervision::join('procedimientos', 'conceptos_supervisiones.procedimiento_id', '=', 'procedimientos.id')
	        	->select('conceptos_supervisiones.*', 'procedimientos.nombre')
	        	->where('conceptos_supervisiones.supervision_id',$id)
	        ->get();

	        $array = array();
	        $procedimientos_usados = array();

	        foreach($conceptos as $concepto){

	        	$items_a_evaluar = ItemProcedimiento::where('procedimiento_id',$concepto->procedimiento_id)->count();

	        	$collection=collect($concepto);   

	            $concepto_array = $collection->toArray();
	            $concepto_array['items']=$items_a_evaluar;
	            $array[$concepto->id] = $concepto_array;

	            $procedimientos_usados[] = $concepto->procedimiento_id;
	        }

			return view('supervisiones.conceptos')->with(['conceptos' => $array, 'procedimientos' => $procedimientos, 'procedimientos_usados' => $procedimientos_usados, 'dias_de_semana' => $dias_de_semana, 'id' => $id]);
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
	        
	        $concepto = new ConceptoSupervision;

	        $concepto->supervision_id = $request->id;
	        $concepto->procedimiento_id = $request->procedimiento_id;
	        $concepto->fecha_inicio = $fecha_inicio_original;
	        $concepto->fecha_final = $fecha_final;

	        if($concepto->save()){

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

		        $supervision = Supervision::find($request->id);

	        	foreach($array as $key=>$value) {

				    $horario = new HorarioSupervision;

			        $horario->concepto_id = $concepto->id;
			        $horario->fecha = $key;
			        $horario->supervisor_id = $supervision->supervisor_id;

			        $horario->save();
				}

				$procedimiento = Procedimiento::find($request->procedimiento_id);
				$cantidad = ItemProcedimiento::where('procedimiento_id',$procedimiento->id)->count();
				$fecha = $concepto->fecha_inicio . ' / ' . $concepto->fecha_final;

	        	return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'id' => $concepto->id, 'nombre' => $procedimiento->nombre, 'cantidad' => $cantidad, 'fecha' => $fecha, 'procedimiento_id' => $concepto->procedimiento_id, 'status' => 'OK', 200]);
	           
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
	        }
	    }
    }

    public function updateConcepto(Request $request)
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
	        
	        $concepto = ConceptoSupervision::find($request->concepto_id);

	        $procedimiento_id = $concepto->procedimiento_id;

	        $concepto->procedimiento_id = $request->procedimiento_id;
	        $concepto->fecha_inicio = $fecha_inicio_original;
	        $concepto->fecha_final = $fecha_final;

	        if($concepto->save()){

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

		        $horarios = HorarioSupervision::where('concepto_id',$concepto->id)->delete();
		        $supervision = Supervision::find($concepto->supervision_id);

	        	foreach($array as $key=>$value) {

				    $horario = new HorarioSupervision;

			        $horario->concepto_id = $concepto->id;
			        $horario->fecha = $key;
			        $horario->supervisor_id = $supervision->supervisor_id;

			        $horario->save();
				}

				$fecha = explode(" - ", $request->fecha);
				$fecha_inicio = Carbon::createFromFormat('d/m/Y H:i:s', $fecha[0] . ' 00:00:00')->format('Y-m-d');
	        	$fecha_final = Carbon::createFromFormat('d/m/Y H:i:s', $fecha[1] . ' 00:00:00')->format('Y-m-d');

				$fecha = $fecha_inicio . ' / ' . $fecha_final;

				$procedimiento = Procedimiento::find($request->procedimiento_id);
				$cantidad = ItemProcedimiento::where('procedimiento_id',$procedimiento->id)->count();

	        	return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'id' => $concepto->id, 'nombre' => $procedimiento->nombre, 'cantidad' => $cantidad, 'fecha' => $fecha, 'procedimiento_id' => $procedimiento->id, 'procedimiento_id_anterior' => $procedimiento_id, 'status' => 'OK', 200]);
	           
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
	        }
	    }
    }
    
}