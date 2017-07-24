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
use App\Correo;
use App\CorreoPersonalizado;
use Validator;
use DB;
use Mail;
use Illuminate\Support\Facades\Auth;
use Session;
use Image;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class CorreoController extends BaseController {

	
	public function Sesion(Request $request){

		Session::put('tipo_usuario_correo', $request->usuario_tipo);
		Session::put('id_usuario_correo', $request->usuario_id);

		return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
	
	}

	public function index(){

		Session::put('tipo', 1);

		$alumnos = Alumno::where('academia_id', '=', Auth::user()->academia_id)
			->where('correo', '!=', '')
			->orderBy('nombre', 'asc')
		->get();

		$visitantes = Visitante::where('academia_id', '=' ,  Auth::user()->academia_id)
			->where('correo', '!=', '')
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


		$correos = Correo::where('academia_id', '=', Auth::user()->academia_id)->get();

		$array = array();

		foreach($correos as $correo){

			$contenido_cortado = $this->cut_html($correo->contenido, 150);

			$collection=collect($correo);     
            $correo_array = $collection->toArray();
            $correo_array['contenido_cortado']=$contenido_cortado;
            $array[$correo->id] = $correo_array;
		}

		return view('correo.index')->with(['alumnos' => $alumnos, 'visitantes' => $visitantes, 'clases_grupales' => $clases, 'correos' => $array]);

	}

	public function indexconusuario($id){

		$tipo = Session::get('tipo_usuario_correo');

		if($tipo){

			if($tipo == 1){
				$usuario = Alumno::withTrashed()->find($id);

				if($usuario->correo){

					$in = array(2,4);
					$sin_confirmar = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
						->select('users.id')
			            ->where('usuarios_tipo.tipo_id', $id)
			            ->where('users.confirmation_token', '!=', null)
			            ->whereIn('usuarios_tipo.tipo',$in)
			        ->count();
					
				}else{
					$sin_confirmar = 0;
				}
			}else if($tipo == 2){
				$usuario = Instructor::find($id);
				$sin_confirmar = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
		            ->where('usuarios_tipo.tipo_id', $id)
		            ->where('users.confirmation_token', '!=', null)
		            ->where('usuarios_tipo.tipo',3)
		        ->count();
			}else if($tipo == 3){
				$usuario = Visitante::find($id);
				$sin_confirmar = 0;
			}else if($tipo == 4){
				$usuario = Proveedor::find($id);
				$sin_confirmar = 0;
			}

			$alumnos = Alumno::where('academia_id', '=', Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

			$visitantes = Visitante::where('academia_id', '=' ,  Auth::user()->academia_id)
				->where('correo', '!=', '')
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
			$correos = Correo::where('academia_id', '=', Auth::user()->academia_id)->get();

			$array = array();

			foreach($correos as $correo){

				$contenido_cortado = $this->cut_html($correo->contenido, 150);

				$collection=collect($correo);     
	            $correo_array = $collection->toArray();
	            $correo_array['contenido_cortado']=$contenido_cortado;
	            $array[$correo->id] = $correo_array;
			}

			return view('correo.index')->with(['usuario' => $usuario, 'id' => $id, 'sin_confirmar' => $sin_confirmar, 'tipo' => $tipo, 'correos' => $correos, 'alumnos' => $alumnos, 'visitantes' => $visitantes, 'clases_grupales' => $clases]);

		}else{
			return redirect("inicio"); 
		}
	
	}

	public function detalle($id){

    	$correo = Correo::find($id);

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

        $tipo = Session::get('tipo_usuario_correo');

		if($tipo){

			$id = Session::get('id_usuario_correo');

			if($tipo == 1){
				$usuario = Alumno::withTrashed()->find($id);
			}else if($tipo == 2){
				$usuario = Instructor::withTrashed()->find($id);
			}else if($tipo == 3){
				$usuario = Visitante::withTrashed()->find($id);
			}else if($tipo == 4){
				$usuario = Proveedor::withTrashed()->find($id);
			}

			if($usuario){
				if(!$usuario->correo){
					$usuario = '';
				}else{

			        $fecha = Carbon::createFromFormat('Y-m-d H:i:s',$usuario->created_at)->format('d-m-Y');

			        $collection=collect($usuario);    
			        $usuario = '';
			        $usuario_array = $collection->toArray();
			            
			        $usuario_array['fecha']=$fecha;
			        $usuario[] = $usuario_array;

				}
			}
		}

        return view('correo.detalle')->with(['correo' => $correo, 'clases_grupales' => $clases, 'usuario' => $usuario]);
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
    		->where('alumnos.correo', '!=', '')
    		->orderBy('alumnos.nombre', 'asc');
    	}else{
    		$query = Visitante::where('academia_id',Auth::user()->academia_id)
    		->where('correo', '!=', '')
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
    	}else{
    		if($request->tipo == 1){
    			$query->whereBetween('alumnos.created_at', [$start,$end]);
    		}
    	}

      $usuarios = $query->get();
      $array = array();

      foreach ($usuarios as $usuario) {
        $fecha = Carbon::createFromFormat('Y-m-d H:i:s',$usuario->created_at)->format('d-m-Y');

        $collection=collect($usuario);     
        $usuario_array = $collection->toArray();
            
        $usuario_array['fecha']=$fecha;
        $array[$usuario->id] = $usuario_array;

      }

      return response()->json(['mensaje' => '¡Excelente! Los usuarios han sido filtrados exitosamente', 'status' => 'OK', 'usuarios' => $array, 200]);
    } 

 	public function Enviar(Request $request){

 		if($request->tipo){
 			$tipo = $request->tipo;
 		}else{
			$tipo = Session::get('tipo');
		}

		if(!$request->usuarios){
			if($tipo == 1){
				$usuarios = Alumno::where('academia_id',Auth::user()->academia_id)->where('correo', '!=', '')->get();
			}else if($tipo == 2){
				$usuarios = Instructor::where('academia_id',Auth::user()->academia_id)->where('correo', '!=', '')->get();
			}else if($tipo == 3){
				$usuarios = Visitante::where('academia_id',Auth::user()->academia_id)->where('correo', '!=', '')->get();
			}else if($tipo == 4){
				$usuarios = Proveedor::where('academia_id',Auth::user()->academia_id)->where('correo', '!=', '')->get();
			}else{
				$usuarios = Alumno::join('inscripcion_clase_grupal', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
					->select('alumnos.*')
					->where('alumnos.academia_id',Auth::user()->academia_id)
					->where('alumnos.correo', '!=', '')
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
		
		$correos = array();

		foreach($usuarios as $usuario){

			if($usuario->correo){

				if(trim($usuario->correo) != ''){
					$correos[] = $usuario->correo;
				}

		    }else{
				return response()->json(['errores' => ['usuario_id' => [0, 'Ups! Este usuario no posee correo electrónico configurado']], 'status' => 'ERROR'],422);
		    }  
		}

		$correos = array_unique($correos);

		$correo = Correo::find($request->correo_id);

		if($correo){

			if($correo->imagen){
                $imagen = "http://app.easydancelatino.com/assets/uploads/correos/".$correo->imagen;

	        }else{
	        	$imagen = "http://oi65.tinypic.com/v4cuuf.jpg";
	        }


	        $array = [
				'imagen' => $imagen,
				'url' => $correo->url,
				'msj_html' => $correo->contenido,
				'correos' => $correos,
				'subj' => $correo->titulo
			];

	        Mail::send('correo.personalizado', $array, function($msj) use ($array){
              	$msj->subject($array['subj']);
              	$msj->to($array['correos']);
            });

            Session::forget('tipo');

            return response()->json(['mensaje' => '¡Excelente! El correo ha sido enviado satisfactoriamente', 'status' => 'OK',  200]);
        }else{
        	return response()->json(['errores' => ['usuario_id' => [0, 'Ups! Este correo no existe']], 'status' => 'ERROR'],422);
        }   
	
	}

 	public function correoPersonalizado(Request $request){


		$rules = [
	        'url' => 'required|active_url',
	        'subj' => 'required',
	        'msj_html' => 'required',
	    ];

	    $messages = [

	    	'url.required' => 'Ups! La URL es requerida',
	        'url.active_url' => 'Ups! La URL no es valida',
	        'subj.required' => 'Ups! El titulo es requerido',
	        'msj_html.required' => 'Ups! El mensaje es requerido',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){
	        
	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }else{

	        if($request->tipo){
 				$tipo = $request->tipo;
	 		}else{
				$tipo = Session::get('tipo');
			}

			if(!$request->usuario_id){
				if($tipo == 1){
					$usuarios = Alumno::where('academia_id',Auth::user()->academia_id)->where('correo', '!=', '')->get();
				}else if($tipo == 2){
					$usuarios = Instructor::where('academia_id',Auth::user()->academia_id)->where('correo', '!=', '')->get();
				}else if($tipo == 3){
					$usuarios = Visitante::where('academia_id',Auth::user()->academia_id)->where('correo', '!=', '')->get();
				}else if($tipo == 4){
					$usuarios = Proveedor::where('academia_id',Auth::user()->academia_id)->where('correo', '!=', '')->get();
				}else{
					$usuarios = Alumno::join('inscripcion_clase_grupal', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
						->select('alumnos.*')
						->where('alumnos.academia_id',Auth::user()->academia_id)
						->where('alumnos.correo', '!=', '')
						->distinct('alumnos.id')
					->get();
				}
			}else{
				if($tipo == 1){
					$usuarios = Alumno::where('id',$request->usuario_id)->get();
				}else if($tipo == 2){
					$usuarios = Instructor::where('id',$request->usuario_id)->get();
				}else if($tipo == 3){
					$usuarios = Visitante::where('id',$request->usuario_id)->get();
				}else if($tipo == 4){
					$usuarios = Proveedor::where('id',$request->usuario_id)->get();
				}else{
					$usuarios = Alumno::join('inscripcion_clase_grupal', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
						->select('alumnos.*')
						->where('inscripcion_clase_grupal.clase_grupal_id',$request->usuario_id)
					->get();
				}
			}

			$correos = array();

			foreach($usuarios as $usuario){

				if($usuario->correo){

					if(trim($usuario->correo) != ''){
						$correos[] = $usuario->correo;
					}

			    }else{
					return response()->json(['errores' => ['usuario_id' => [0, 'Ups! Este usuario no posee correo electrónico configurado']], 'status' => 'ERROR'],422);
			    }  
			}

	        $correos = array_unique($correos);

			$personalizado = new CorreoPersonalizado;

			$personalizado->academia_id = Auth::user()->academia_id;
	        $personalizado->url = $request->url;
	        $personalizado->msj_html = $request->msj_html;
	        $personalizado->titulo = $request->subj;

	        if($personalizado->save()){

				if($request->imageBase64 && $request->imageBase64 != "data:,"){

	                $base64_string = substr($request->imageBase64, strpos($request->imageBase64, ",")+1);
	                $path = storage_path();
	                $split = explode( ';', $request->imageBase64 );
	                $type =  explode( '/',  $split[0]);
	                $ext = $type[1];
	                
	                if($ext == 'jpeg' || 'jpg'){
	                    $extension = '.jpg';
	                }

	                if($ext == 'png'){
	                    $extension = '.png';
	                }

	                $nombre_img = "correo-". $personalizado->id . $extension;
	                $image = base64_decode($base64_string);

	                // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
	                $img = Image::make($image)->resize(1440, 500);
	                $img->save('assets/uploads/correos_personalizados/'.$nombre_img);

	                $personalizado->imagen = $nombre_img;
	                $personalizado->save();

	                $imagen = "http://app.easydancelatino.com/assets/uploads/correos_personalizados/".$nombre_img;

		        }else{
		        	$imagen = "http://oi65.tinypic.com/v4cuuf.jpg";
		        }

				$array = [
					'imagen' => $imagen,
					'url' => $personalizado->url,
					'msj_html' => $request->msj_html,
					'correos' => $correos,
					'subj' => $personalizado->titulo
				];

				Mail::send('correo.personalizado', $array, function($msj) use ($array){
					$msj->subject($array['subj']);
				    $msj->to($array['correos']);
				});

				return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);

		 	}else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
	    }
	}

	public function correoActivacion(Request $request){

 		$request->merge(array('email' => trim($request->email)));

	 	$rules = [
	        'email' => 'required|email',
	    ];

	    $messages = [

	        'email.required' => 'Ups! El correo  es requerido ',
	        'email.email' => 'Ups! El correo tiene una dirección inválida',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }else{

 			$usuario = User::where('email', $request->email)->first();

 			if($usuario){

 				// if($usuario->confirmation_token != null)
 				// {

		 			$academia = Academia::find($usuario->academia_id);

		 			$password = str_random(8);
					$usuario->password = bcrypt($password);

					$usuario->save();

		            $subj = 'Activa tu cuenta en Easy Dance';
		            $link = "confirmacion/?token=".$usuario->confirmation_token;

		        	$array = [
		            	'nombre' => $usuario->nombre,
		                'academia' => $academia->nombre,
		                'usuario' => $request->email,
		                'contrasena' => $password,
		                'subj' => $subj,
		                'link' => $link
		            ];

		            Mail::send('correo.activacion', $array, function($msj) use ($array){
		                $msj->subject($array['subj']);
		                $msj->to($array['usuario']);
		            });

		            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
	            // }else{
            	// 	return response()->json(['error_mensaje' => 'Ups! Esta cuenta ya esta activada'], 422);
           	 // 	}	
            }else{
            	return response()->json(['error_mensaje' => 'Ups! No Hemos encontrado la siguiente información del correo  asociada a tu cuenta'], 422);
            }
        }
 	}


 	public function correoVisitante(Request $request){

      	$rules = [
        	'tipo' => 'required',
        	'url'  => 'required|active_url',
        	'subj' => 'required',
      	];

      	$messages = [
        	'tipo.required' => 'Ups! El tipo es requerido',
        	'url.required' => 'Ups! La URL es requerida',
        	'url.active_url' => 'Ups! La URL no es valida',
        	'subj.required' => 'Ups! El titulo es requerido',
      	];

     	$validator = Validator::make($request->all(), $rules, $messages);

      	if ($validator->fails()){

        	return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);


      	}else{

	        if($request->tipo == 2){

	          	if($request->visitante_id == ''){
	            	return response()->json(['errores' => ['visitante_id' => [0, 'Ups! El interesado es requerido']], 'status' => 'ERROR'],422);
	          	}
	        }

	        $personalizado = new CorreoPersonalizado;

	        $personalizado->url = $request->url;
	        $personalizado->msj_html = $request->msj_html;
	        $personalizado->subj = $request->subj;

	        if($personalizado->save()){

	        	if($request->imageBase64){

		            $base64_string = substr($request->imageBase64, strpos($request->imageBase64, ",")+1);
		            $path = storage_path();
		            $split = explode( ';', $request->imageBase64 );
		            $type =  explode( '/',  $split[0]);
		            $ext = $type[1];
		            
		            if($ext == 'jpeg' || 'jpg'){
		                $extension = '.jpg';
		            }

		            if($ext == 'png'){
		                $extension = '.png';
		            }

		            $nombre_img = "correo-". $personalizado->id . $extension;
		            $image = base64_decode($base64_string);

		            // \Storage::disk('correo')->put($nombre_img,  $image);
		            $img = Image::make($image)->resize(1440, 500);
		            $img->save('assets/uploads/correos/'.$nombre_img);

		            $personalizado->imagen = $nombre_img;
		            $personalizado->save();

		            $imagen = "http://app.easydancelatino.com/assets/uploads/correos/".$nombre_img;

		        }else{
		        	$imagen = "http://oi65.tinypic.com/v4cuuf.jpg";
		        }

		          // $interesados=Interesado::where('id',120)->get();
		        $subj = $request->subj;
		        $msj_html = $request->msj_html;
		        $url = $request->url;

	         	if($request->tipo == 1){

		            $interesados=Visitante::where('academia_id', Auth::user()->academia_id)->get();

		            foreach($interesados as $interesado)
		            {
		            	if($interesado->correo){
			              
				              $array = [
				                'msj_html' => $request->msj_html,
				                'email' => $interesado->correo,
				                'subj' => $subj,
				                'url' => $url,
				                'imagen' => $imagen
				              ];

			                Mail::send('correo.informacion', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                    $msj->to($array['email']);
			                });
		                }
		            }

		        }else{

		            $interesado=Visitante::find($request->visitante_id);

		            $array = [
		                'msj_html' => $request->msj_html,
		                'email' => $interesado->correo,
		                'subj' => $subj,
		                'url' => $url,
		                'imagen' => $imagen
		            ];

		            Mail::send('correo.personalizado', $array, function($msj) use ($array){
		              $msj->subject($array['subj']);
		                $msj->to($array['email']);
		            });
		        }

	         	return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
	      	}
	    }
	}
}