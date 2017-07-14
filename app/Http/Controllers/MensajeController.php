<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Alumno;
use App\Instructor;
use App\Proveedor;
use App\Visitante;
use App\ClaseGrupal;
use App\ConfigClasesGrupales;
use App\Academia;
use App\User;
use App\Mensaje;
use Validator;
use DB;
use Mail;
use Illuminate\Support\Facades\Auth;
use Session;
use Image;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class MensajeController extends BaseController {

	public function index(){

		Session::put('tipo', 1);

		$alumnos = Alumno::where('academia_id', '=', Auth::user()->academia_id)
			->where('celular', '!=', '')
			->orderBy('nombre', 'asc')
		->get();

		$visitantes = Visitante::where('academia_id', '=' ,  Auth::user()->academia_id)
			->where('celular', '!=', '')
			->orderBy('nombre', 'asc')
		->get();

		$clases_grupales = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('clases_grupales.id',
                     'clases_grupales.hora_inicio',
                     'clases_grupales.hora_final',
                     'clases_grupales.fecha_inicio',
                     'config_clases_grupales.nombre',
                     'instructores.nombre as instructor_nombre',
                     'instructores.apellido as instructor_apellido')
            ->where('clases_grupales.academia_id','=',Auth::user()->academia_id)
            ->orderBy('clases_grupales.hora_inicio', 'asc')
        ->get();

        $clases = array();

        foreach($clases_grupales as $clase){

            $fecha = Carbon::createFromFormat('Y-m-d', $clase->fecha_inicio);
          
            $i = $fecha->dayOfWeek;

            if($i == 1){

              $dia = 'Lunes';

            }else if($i == 2){

              $dia = 'Martes';

            }else if($i == 3){

              $dia = 'Miercoles';

            }else if($i == 4){

              $dia = 'Jueves';

            }else if($i == 5){

              $dia = 'Viernes';

            }else if($i == 6){

              $dia = 'Sabado';

            }else if($i == 0){

              $dia = 'Domingo';

            }

            $collection=collect($clase);     
            $clase_array = $collection->toArray();
                
            $clase_array['dia']=$dia;
            $clases[$clase->id] = $clase_array;
        }


		$mensajes = Mensaje::where('academia_id', '=', Auth::user()->academia_id)->get();

		return view('mensajes.index')->with(['alumnos' => $alumnos, 'visitantes' => $visitantes, 'clases_grupales' => $clases, 'mensajes' => $mensajes]);

	}

	public function detalle($id){

    	$mensaje = Mensaje::find($id);

    	$clases_grupales = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('clases_grupales.id',
                     'clases_grupales.hora_inicio',
                     'clases_grupales.hora_final',
                     'clases_grupales.fecha_inicio',
                     'config_clases_grupales.nombre',
                     'instructores.nombre as instructor_nombre',
                     'instructores.apellido as instructor_apellido')
            ->where('clases_grupales.academia_id','=',Auth::user()->academia_id)
            ->orderBy('clases_grupales.hora_inicio', 'asc')
        ->get();

        $clases = array();

        foreach($clases_grupales as $clase){

            $fecha = Carbon::createFromFormat('Y-m-d', $clase->fecha_inicio);
          
            $i = $fecha->dayOfWeek;

            if($i == 1){

              $dia = 'Lunes';

            }else if($i == 2){

              $dia = 'Martes';

            }else if($i == 3){

              $dia = 'Miercoles';

            }else if($i == 4){

              $dia = 'Jueves';

            }else if($i == 5){

              $dia = 'Viernes';

            }else if($i == 6){

              $dia = 'Sabado';

            }else if($i == 0){

              $dia = 'Domingo';

            }

            $collection=collect($clase);     
            $clase_array = $collection->toArray();
                
            $clase_array['dia']=$dia;
            $clases[$clase->id] = $clase_array;
        }

        return view('mensajes.detalle')->with(['mensaje' => $mensaje, 'clases_grupales' => $clases]);
    }

    public function Filtrar(Request $request){

    	if($request->boolean_fecha){

            $fecha = explode(' - ', $request->fecha2);
            $start = Carbon::createFromFormat('d/m/Y',$fecha[0])->toDateString();
            $end = Carbon::createFromFormat('d/m/Y',$fecha[1])->addDay()->toDateString();

        }else{

            if($request->tipo){
                if($request->fecha == 1){
                    $start = Carbon::now()->toDateString();
                    $end = Carbon::now()->addDay()->toDateString();  
                }else if($request->fecha == 2){
                    $start = Carbon::now()->startOfMonth()->toDateString();
                    $end = Carbon::now()->endOfMonth()->toDateString();  
                }else if($request->fecha == 3){
                    $start = Carbon::now()->startOfMonth()->subMonth()->toDateString();
                    $end = Carbon::now()->endOfMonth()->subMonth()->subDay()->toDateString();  
                }
            }
        }

    	if($request->tipo == 1){
    		$query = Alumno::where('alumnos.academia_id',Auth::user()->academia_id)
    		->where('alumnos.celular', '!=', '')
    		->whereBetween('alumnos.created_at', [$start,$end])
    		->orderBy('alumnos.nombre', 'asc');
    	}else{
    		$query = Visitante::where('academia_id',Auth::user()->academia_id)->where('celular', '!=', '')
    		->whereBetween('created_at', [$start,$end])
    		->orderBy('nombre', 'asc');
    	}

    	if($request->tipo2){
    		if($request->tipo == 1){
    			$query->leftJoin('inscripcion_clase_grupal', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
    				->select('alumnos.*')
    				->where('inscripcion_clase_grupal.clase_grupal_id',$request->tipo2)
					->groupBy('alumnos.id');
    		}else{
    			if($request->tipo2 == 1){
    				$query->where('cliente',1);
    			}else{
    				$query->where('cliente',0);
    			}
    		}
    	}

        $usuarios = $query->get();

        return response()->json(['mensaje' => '¡Excelente! Los usuarios han sido filtrados exitosamente', 'status' => 'OK', 'usuarios' => $usuarios, 200]);
    } 

	public function Enviar(Request $request){

		$rules = [
			'usuarios' => 'required',
	    ];

	    $messages = [
	        'usuarios.required' => 'Ups! El destinatario es requerido',
	    ];


	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){
	        
	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }else{

			$academia = Academia::find(Auth::user()->academia_id);

			if($academia->pais_id == 11){

	            $mensaje = Mensaje::find($request->mensaje_id);

				if($mensaje){

		            if(strlen($mensaje->contenido) > 159){
		            	return response()->json(['errores' => ['tipo' => [0, 'Ups! Este mensaje es muy largo para enviarlo como SMS']], 'status' => 'ERROR'],422);
		            }

					if($request->tipo){
			 			$tipo = $request->tipo;
			 		}else{
						$tipo = Session::get('tipo');
					}

					if(!$request->usuarios){
						if($tipo == 1){
							$usuarios = Alumno::where('academia_id',Auth::user()->academia_id)->where('celular', '!=', '')->get();
						}else if($tipo == 2){
							$usuarios = Instructor::where('academia_id',Auth::user()->academia_id)->where('celular', '!=', '')->get();
						}else if($tipo == 3){
							$usuarios = Visitante::where('academia_id',Auth::user()->academia_id)->where('celular', '!=', '')->get();
						}else if($tipo == 4){
							$usuarios = Proveedor::where('academia_id',Auth::user()->academia_id)->where('celular', '!=', '')->get();
						}else{
							$usuarios = Alumno::join('inscripcion_clase_grupal', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
								->select('alumnos.*')
								->where('alumnos.academia_id',Auth::user()->academia_id)
								->where('alumnos.celular', '!=', '')
								->distinct('alumnos.id')
							->get();
						}
					}else{

						$explode = explode(',',$request->usuarios);

						if($tipo == 1){
							$usuarios = Alumno::whereIn('id',$explode)->get();
						}else if($tipo == 2){
							$usuarios = Instructor::whereIn('id',$explode)->get();
						}else if($tipo == 3){
							$usuarios = Visitante::whereIn('id',$explode)->get();
						}else if($tipo == 4){
							$usuarios = Proveedor::whereIn('id',$explode)->get();
						}else{
							$usuarios = Alumno::join('inscripcion_clase_grupal', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
								->select('alumnos.*')
								->whereIn('inscripcion_clase_grupal.clase_grupal_id',$explode)
							->get();
						}
					}
							
					$numeros = '';
					$i = 0;

		        	foreach($usuarios as $usuario){
		        		if($usuario->celular){
			        		if($i <= 500){
				        		$celular = getLimpiarNumero($usuario->celular);
				        		if(trim($celular) != '' && strlen($celular) == 10){
									if($numeros){
										$numeros = $numeros . ',' .  $celular;
									}else{
										$numeros = $celular;
									}

									$i++;
								}
							}else{
								break;
							}
						}else{
							return response()->json(['errores' => ['usuario_id' => [0, 'Ups! Este usuario no posee telefono movil configurado']], 'status' => 'ERROR'],422);
					    }
					}

					$client = new Client(); //GuzzleHttp\Client
		        	$result = $client->get('https://sistemasmasivos.com/c3colombia/api/sendsms/send.php?user=coliseodelasalsa@gmail.com&password=k1-9L6A1rn&GSM='.$numeros.'&SMSText='.urlencode($mensaje->contenido));
			   
					return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
		        

		        }else{
		        	return response()->json(['errores' => ['tipo' => [0, 'Ups! Este mensaje no existe']], 'status' => 'ERROR'],422);
		        }
		    }else{
		    	return response()->json(['errores' => ['tipo' => [0, 'Ups! El envio de mensajes de texto solo esta disponible en Colombia']], 'status' => 'ERROR'],422);

	        }
    	}

	}
}