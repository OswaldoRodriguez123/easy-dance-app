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
use DB;

class SupervisionController extends BaseController {

	public function principal()
	{

        $supervisiones = Supervision::join('staff', 'staff.id', '=', 'supervisiones.staff_id')
        	->join('config_staff', 'staff.cargo', '=', 'config_staff.id')
            ->select('staff.*', 'supervisiones.supervisor_id', 'supervisiones.fecha_inicio', 'supervisiones.fecha_final', 'config_staff.nombre as cargo')
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
        $staffs = Staff::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->get();

        return view('configuracion.supervision.create')->with(['dias_de_semana' => $dias_de_semana, 'config_staff' => $config_staff, 'staffs' => $staffs, 'config_supervision' => $config_supervision]);
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

	    	$frecuencia = $request->frecuencia;
	        $fecha_inicio = Carbon::createFromFormat('d/m/Y H:i:s', $fecha[0] . ' 00:00:00');
	        $fecha_inicio_original = Carbon::createFromFormat('d/m/Y H:i:s', $fecha[0] . ' 00:00:00');
	        $fecha_final = Carbon::createFromFormat('d/m/Y H:i:s', $fecha[1] . ' 00:00:00');
	        
	        $supervision = new Supervision;

	        $supervision->supervisor_id = $request->supervisor_id;
	        $supervision->staff_id = $request->staff_id;
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

			        $horario->save();
				}

	        	return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
	           
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
	        }
	    }
    }

}