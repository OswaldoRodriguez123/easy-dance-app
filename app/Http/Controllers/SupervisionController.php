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
use App\Academia;
use DB;
use Session;

class SupervisionController extends BaseController {

	public function principal()
	{

        $supervisiones = Supervision::join('staff', 'staff.id', '=', 'supervisiones.staff_id')
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

		return view('configuracion.supervision.principal')->with(['supervisiones' => $array]);
	}

	public function create()
    {
        $dias_de_semana = DiasDeSemana::all();

        $config_staff = ConfigStaff::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->get();
        $config_supervision = ConfigSupervision::where('academia_id', Auth::user()->academia_id)->get();
        $staffs = Staff::where('academia_id', Auth::user()->academia_id)->get();
        $instructores = Staff::where('academia_id', Auth::user()->academia_id)->get();

        $array = array();

        foreach($staffs as $item){

            $array[]=array('id' => $item['id'], 'nombre' => $item['nombre'] . ' ' . $item['apellido'], 'tipo' => 1, 'cargo' => 'Staff', 'cargo_id' => $item['cargo']);

        }

        foreach($instructores as $item){

            $array[]=array('id' => $item['id'], 'nombre' => $item['nombre'] . ' ' . $item['apellido'], 'tipo' => 2, 'cargo' => 'Instructor', 'cargo_id' => 1);

        }

        return view('configuracion.supervision.create')->with(['dias_de_semana' => $dias_de_semana, 'config_staff' => $config_staff, 'staffs' => $staffs, 'staffs_instructores' => $array, 'config_supervision' => $config_supervision]);
    }

    public function store(Request $request)
	{

	    $rules = [
	        'supervisor_id' => 'required',
	        'cargo' => 'required',
	        'staff_id' => 'required',
	        'fecha' => 'required',
	        'frecuencia' => 'required',
	    ];

	    $messages = [

	        'supervisor_id.required' => 'Ups! El Supervisor es requerido',
	       	'cargo.required' => 'Ups! El Cargo es requerido',
	        'staff_id.required' => 'Ups! El Staff  es requerido ',
	        'fecha.required' => 'Ups! El rango de fecha es requerido',
	        'frecuencia.required' => 'Ups! La frecuencia es requerida',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

	    else{

	    	$fecha = explode(" - ", $request->fecha);	
	    	$staff = explode("-", $request->staff_id);

	    	$frecuencia = $request->frecuencia;
	        $fecha_inicio = Carbon::createFromFormat('d/m/Y H:i:s', $fecha[0] . ' 00:00:00');
	        $fecha_inicio_original = Carbon::createFromFormat('d/m/Y H:i:s', $fecha[0] . ' 00:00:00');
	        $fecha_final = Carbon::createFromFormat('d/m/Y H:i:s', $fecha[1] . ' 00:00:00');
	        
	        $supervision = new Supervision;

	        $supervision->supervisor_id = $request->supervisor_id;
	        $supervision->staff_id = $staff[0];
	        $supervision->tipo_staff = $staff[1];
	        $supervision->cargo = $request->cargo;
	        $supervision->fecha_inicio = $fecha_inicio_original;
	        $supervision->fecha_final = $fecha_final;
	        $supervision->items_a_evaluar = $request->items_a_evaluar;

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

	        	foreach($array as $key=>$value) {

				    $horario = new HorarioSupervision;

			        $horario->supervision_id = $supervision->id;
			        $horario->fecha = $key;
			        $horario->supervisor_id = $request->supervisor_id;

			        $horario->save();
				}

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

        	$supervisor = Staff::find($supervision->supervisor_id);

        	if($supervisor){
        		$supervisor = $supervisor->nombre . ' ' . $supervisor->apellido;
        	}else{
        		$supervisor = '';
        	}

        	$staff = Staff::find($supervision->staff_id);
        	$staff_a_supervisar = $staff->nombre . ' ' . $staff->apellido;

        	$staffs = Staff::where('academia_id', Auth::user()->academia_id)->get();
        	$config_staff = ConfigStaff::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->get();
        	$dias_de_semana = DiasDeSemana::all();
        	$config_supervision = ConfigSupervision::where('academia_id', Auth::user()->academia_id)->get();

        	$fecha_inicio = Carbon::createFromFormat('Y-m-d H:i:s', $supervision->fecha_inicio . ' 00:00:00')->format('d/m/Y');
        	$fecha_final = Carbon::createFromFormat('Y-m-d H:i:s', $supervision->fecha_final . ' 00:00:00')->format('d/m/Y');

        	$cargo = ConfigStaff::find($supervision->cargo);
        	$cargo_a_supervisar = $cargo->nombre;
        	$cargo_id = $cargo->id;

        	$items_a_evaluar = explode(',', $supervision->items_a_evaluar);

        	$instructores = Staff::where('academia_id', Auth::user()->academia_id)->get();

	        $array = array();

	        foreach($staffs as $item){

	            $array[]=array('id' => $item['id'], 'nombre' => $item['nombre'] . ' ' . $item['apellido'], 'tipo' => 1, 'cargo' => 'Staff', 'cargo_id' => $item['cargo']);

	        }

	        foreach($instructores as $item){

	            $array[]=array('id' => $item['id'], 'nombre' => $item['nombre'] . ' ' . $item['apellido'], 'tipo' => 2, 'cargo' => 'Instructor', 'cargo_id' => 1);

	        }

            return view('configuracion.supervision.planilla')->with(['staffs' => $staffs, 'supervision' => $supervision, 'supervisor' => $supervisor, 'config_staff' => $config_staff, 'id' => $id, 'dias_de_semana' => $dias_de_semana, 'config_supervision' => $config_supervision, 'fecha_inicio' => $fecha_inicio, 'fecha_final' => $fecha_final, 'cargo_a_supervisar' => $cargo_a_supervisar, 'staff_a_supervisar' => $staff_a_supervisar, 'items_a_evaluar' => $items_a_evaluar, 'cargo_id' => $cargo_id, 'staffs_instructores' => $array]);

        }else{
           return redirect("configuracion/supervisiones");
        }
    }

    public function evaluar($id)
    {   
    	Session::put('id_supervision_evaluacion', $id);

        $supervision = Supervision::join('staff', 'staff.id', '=', 'supervisiones.staff_id')
        	->join('config_staff', 'staff.cargo', '=', 'config_staff.id')
            ->select('supervisiones.*', 'config_staff.nombre as cargo', 'staff.nombre', 'staff.apellido')
            ->where('supervisiones.id', $id)
        ->first();

        if($supervision){

        	$staffs = Staff::where('academia_id', Auth::user()->academia_id)->where('id', '!=', $supervision->staff_id)->get();
        	$staff = Staff::find($supervision->supervisor_id);

	    	if($staff){
	    		$supervisor = $staff->nombre . ' ' . $staff->apellido;
	    	}else{
	    		$supervisor = '';
	    	}

	    	$items_a_evaluar = explode(',', $supervision->items_a_evaluar);
            $hoy = Carbon::now()->format('d-m-Y');
            $academia = Academia::find(Auth::user()->academia_id);
            $numero_de_items = count($items_a_evaluar);

            return view('configuracion.supervision.evaluar')
                   ->with(['staffs' => $staffs, 'supervision' => $supervision, 'fecha' => $hoy, 'items_a_evaluar' => $items_a_evaluar, 'id' => $id, 'numero_de_items'=>$numero_de_items, 'academia' => $academia]);
        }else{
           return redirect("configuracion/supervisiones"); 
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

            $detalle_nota=explode(",",$request->nota_detalle);
            $detalle_nombre=explode(",",$request->nombre_detalle);

            $evaluacion = new SupervisionEvaluacion;

            $evaluacion->supervisor_id = $request->supervisor_id;
            $evaluacion->supervision_id = $request->supervision_id;
            $evaluacion->total = $request->total_nota;
            $evaluacion->observacion = $request->observacion;
            $evaluacion->porcentaje = $request->barra_de_progreso;

            if($evaluacion->save()){

                for ($i=0; $i < count($detalle_nota)-1; $i++) {

                    $detalles = new DetalleSupervisionEvaluacion;

                    $detalles->nombre = $detalle_nombre[$i];
                    $detalles->nota = intval($detalle_nota[$i]);
                    $detalles->evaluacion_id = $evaluacion->id;
                    $detalles->save();
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

        $evaluaciones= SupervisionEvaluacion::join('supervisiones', 'supervision_evaluacion.supervision_id', '=', 'supervisiones.id')
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

        return view('configuracion.supervision.evaluaciones')->with(['evaluaciones' => $array,'id_evaluacion'=>$id_evaluacion]);
    }

    public function evaluaciones_por_supervision($id)
    {

        $evaluaciones= SupervisionEvaluacion::join('supervisiones', 'supervision_evaluacion.supervision_id', '=', 'supervisiones.id')
            ->join('staff', 'supervisiones.staff_id', '=', 'staff.id')
            ->select('supervision_evaluacion.*','staff.nombre', 'staff.apellido')
            ->where('supervisiones.id', '=' ,  $id)
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

        return view('configuracion.supervision.evaluaciones')->with(['evaluaciones' => $array, 'id'=>$id, 'porcentaje' => $porcentaje]);
    }


    public function getDetalle($id){

        //DATOS DE ENCABEZADO
        
        $evaluacion = SupervisionEvaluacion::join('supervisiones', 'supervision_evaluacion.supervision_id','=','supervisiones.id')
    		->join('staff', 'supervisiones.supervisor_id','=','staff.id')
	        ->join('config_staff', 'supervisiones.cargo','=','config_staff.id')
	        ->select('supervisiones.*', 'config_staff.nombre as cargo', 'staff.nombre', 'staff.apellido', 'supervision_evaluacion.total', 'supervision_evaluacion.porcentaje')
	        ->where('supervision_evaluacion.id', $id)
        ->first();
        
        $staff = SupervisionEvaluacion::join('supervisiones', 'supervision_evaluacion.supervision_id','=','supervisiones.id')
    		->join('staff', 'supervisiones.staff_id','=','staff.id')
            ->select('staff.*')
            ->where('supervision_evaluacion.id','=',$id)
        ->first();

        $academia = SupervisionEvaluacion::join('supervisiones', 'supervision_evaluacion.supervision_id','=','supervisiones.id')
			->join('staff', 'supervisiones.staff_id','=','staff.id')
			->join('academias', 'staff.academia_id','=','academias.id')
            ->select('academias.*')
            ->where('supervision_evaluacion.id','=',$id)
        ->first();
            
        //DATOS DE DETALLE
        $detalles_notas = DetalleSupervisionEvaluacion::select('nombre', 'nota')
            ->where('evaluacion_id','=',$id)
        ->get();
        
        return view('configuracion.supervision.detalle')->with([
        	'evaluacion'               => $evaluacion,
            'staff'                    => $staff, 
            'academia'                 => $academia, 
            'detalle_notas'            => $detalles_notas,

        ]);
    }

    public function destroy($id)
    {

    	$horarios = HorarioSupervision::where('supervision_id',$id)->delete();
        $supervision = Supervision::find($id);
        
        if($supervision->delete()){
            return response()->json(['mensaje' => '¡Excelente! La supervision se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function agenda($id){

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

        return view('configuracion.supervision.agenda')->with(['activas' => $activas, 'finalizadas' => $finalizadas, 'id'=>$id]);
    }

    public function configuracion(){

    	$cargos = ConfigStaff::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->get();

    	$array = array();

    	foreach($cargos as $cargo){

    		$items = ConfigSupervision::where('cargo_id',$cargo->id)->count();

    		if($items > 0){

	    		$collection=collect($cargo);   

	            $cargo_array = $collection->toArray();
	            $cargo_array['items']=$items;
	            $array[$cargo->id] = $cargo_array;
            }

    	}

        return view('configuracion.supervision.configuracion')->with(['cargos' => $array]);

    }


    public function agregar_configuracion(){

    	$cargos = ConfigStaff::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->get();

    	$config_supervision = ConfigSupervision::join('config_staff', 'config_supervision.cargo_id', '=', 'config_staff.id')
    		->select('config_supervision.*', 'config_staff.nombre as cargo')
	    	->where('config_supervision.academia_id', Auth::user()->academia_id)
	    	->orWhere('config_supervision.academia_id', null)
    	->get();
    	
        return view('configuracion.supervision.agregar_configuracion')->with(['cargos' => $cargos, 'config_supervision' => $config_supervision]);

    }

    public function eliminar_configuracion($id){

    	$cargos = ConfigSupervision::where('cargo_id', $id)->where('academia_id', Auth::user()->academia_id);

    	if($cargos->delete()){
			return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
		}else{
			return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
		}

    }

}