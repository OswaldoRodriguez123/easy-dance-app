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
use App\Academia;
use App\User;
use App\CorreoInformacion;
use Validator;
use DB;
use Mail;
use Illuminate\Support\Facades\Auth;
use Session;
use Image;

class CorreoController extends BaseController {

	public function index(){

		Session::forget('tipo');

		$alumnos = Alumno::where('academia_id', '=', Auth::user()->academia_id)->get();
		// $clasegrupal = ClaseGrupal::where('academia_id', '=', Auth::user()->academia_id)->get();

		$clasegrupal = DB::table('config_clases_grupales')
                    ->join('clases_grupales', 'config_clases_grupales.id', '=', 'clases_grupales.clase_grupal_id')
                    ->select('config_clases_grupales.nombre', 'clases_grupales.id')
                    ->where('clases_grupales.academia_id', '=', Auth::user()->academia_id)
                ->get();
	
		return view('correo.index')->with(['alumnos' => $alumnos, 'clasegrupal' => $clasegrupal]);

	}

	public function correoInformacion(Request $request){

		$array = array(2, 4);
		$alumnos = User::whereIn('usuario_tipo', $array)->where('academia_id', Auth::user()->academia_id)->get();

		foreach($alumnos as $alumno)
		{

			$subj = 'Información';

			$msj_html = $request->msj_html;

			$array = [
				'msj_html' => $request->msj_html,
				'email' => $alumno->email,
				'subj' => $subj
			];

				Mail::send('correo.informacion', $array, function($msj) use ($array){
					$msj->subject($array['subj']);
				    $msj->to($array['email']);
				});
		}

		return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
	 }

	 public function correoPersonalizado(Request $request){

	 $rules = [
        'url' => 'required|active_url',
        'subj' => 'required',
    ];

    $messages = [

    	'url.required' => 'Ups! La URL es requerida',
        'url.active_url' => 'Ups! La URL no es valida',
        'subj.required' => 'Ups! El titulo es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        // return redirect("/home")

        // ->withErrors($validator)
        // ->withInput();

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }

    else{

		$array = array(2, 4);
		$alumnos = User::whereIn('usuario_tipo', $array)->where('academia_id', Auth::user()->academia_id)->get();

		$subj = $request->subj;
		$msj_html = $request->msj_html;

		$correo_informacion = new CorreoInformacion;

		$correo_informacion->academia_id = Auth::user()->academia_id;
        $correo_informacion->url = $request->url;
        $correo_informacion->msj_html = $request->msj_html;
        $correo_informacion->titulo = $request->subj;

        if($correo_informacion->save())
        {

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

	                $nombre_img = "correo-". $correo_informacion->id . $extension;
	                $image = base64_decode($base64_string);

	                // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
	                $img = Image::make($image)->resize(1440, 500);
	                $img->save('assets/uploads/correo/'.$nombre_img);

	                $correo_informacion->imagen = $nombre_img;
	                $correo_informacion->save();

	                $imagen = "http://app.easydancelatino.com/assets/uploads/correo/".$nombre_img;

	        }else{
	        	$imagen = "http://oi65.tinypic.com/v4cuuf.jpg";
	        }

			foreach($alumnos as $alumno)
			{
				
				$array = [
					'imagen' => $imagen,
					'url' => $request->url,
					'msj_html' => $request->msj_html,
					'email' => $alumno->email,
					'subj' => $subj
				];

					Mail::send('correo.personalizado', $array, function($msj) use ($array){
						$msj->subject($array['subj']);
					    $msj->to($array['email']);
					});
			}

			return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);

		 	}else{
            	return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        	}
	 	}
	}

	public function correoPersonalizadoVisitante(Request $request){

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

    }

    else{

    	if($request->tipo == 2){

          if($request->visitante_id == ''){
            return response()->json(['errores' => ['visitante_id' => [0, 'Ups! El interesado es requerido']], 'status' => 'ERROR'],422);
          }
        }

        $subj = $request->subj;
        $msj_html = $request->msj_html;
        $url = $request->url;

		$correo_informacion = new CorreoInformacion;

		$correo_informacion->academia_id = Auth::user()->academia_id;
        $correo_informacion->url = $request->url;
        $correo_informacion->msj_html = $request->msj_html;
        $correo_informacion->titulo = $request->subj;

        if($correo_informacion->save())
        {
			if($request->imageBase64 AND $request->imageBase64 != 'data:,'){

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

	                $nombre_img = "correo-". $correo_informacion->id . $extension;
	                $image = base64_decode($base64_string);

	                // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
	                $img = Image::make($image)->resize(1440, 500);
	                $img->save('assets/uploads/correo/'.$nombre_img);

	                $correo_informacion->imagen = $nombre_img;
	                $correo_informacion->save();

	                $imagen = "http://app.easydancelatino.com/assets/uploads/correo/".$nombre_img;

	        }else{
	        	$imagen = "http://oi65.tinypic.com/v4cuuf.jpg";
	        }

	        if($request->tipo == 1){

		        $visitantes=Visitante::where('academia_id', Auth::user()->academia_id)->get();

				foreach($visitantes as $visitante)
				{
					if($visitante->correo)
					{

						$array = [
							'imagen' => $imagen,
							'url' => $url,
							'msj_html' => $msj_html,
							'email' => $visitante->correo,
							'subj' => $subj
						];

							Mail::send('correo.personalizado', $array, function($msj) use ($array){
								$msj->subject($array['subj']);
							    $msj->to($array['email']);
							});
					}
				}
			}else{

		        $visitante=Visitante::find($request->visitante_id);

		        if($visitante->correo){

			        $array = [
			            'msj_html' => $msj_html,
			            'email' => $visitante->correo,
			            'subj' => $subj,
			            'url' => $url,
			            'imagen' => $imagen
			        ];

			        Mail::send('correo.personalizado', $array, function($msj) use ($array){
			          $msj->subject($array['subj']);
			            $msj->to($array['email']);
			        });

		        }else{
		        	return response()->json(['error_mensaje' => 'Ups! Este visitante no posee correo electrónico', 'status' => 'ERROR-CORREO'],422);
		        }
	      	}

			return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);

		 	}else{
            	return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        	}
	 	}
	}
	

	public function indexsinselector($id){

		$tipo = Session::get('tipo');

		if($tipo){

			if($tipo == 1)
			{
				$usuario = Alumno::withTrashed()->find($id);
				$tiene_cuenta = User::where('usuario_id', $id)->where('usuario_tipo', 2)->where('confirmation_token', null)->count();

				if(!$tiene_cuenta){
					$tiene_cuenta = User::where('usuario_id', $id)->where('usuario_tipo', 4)->where('confirmation_token', null)->count();
				}
			}

			if($tipo == 2)
			{
				$usuario = Instructor::find($id);
				$tiene_cuenta = User::where('usuario_id', $id)->where('usuario_tipo', 3)->where('confirmation_token', null)->count();
			}

			if($tipo == 3)
			{
				$usuario = Visitante::find($id);
				$tiene_cuenta = 0;
			}

			if($tipo == 4)
			{
				$usuario = Proveedor::find($id);
				$tiene_cuenta = 0;
			}

			return view('correo.indexsinselector')->with(['usuario' => $usuario, 'id' => $id, 'tiene_cuenta' => $tiene_cuenta, 'tipo' => $tipo]);

		}
		else{
			return redirect("inicio"); 
		}
	
	}

	public function Sesion($id){

		Session::put('tipo', $id);

		return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
	
	}

 	public function correoCumpleaños(Request $request){

 		$tipo = Session::get('tipo');

		if($tipo){

			if($tipo == 1)
			{
				$alumno = Alumno::withTrashed()->find($request->id);

				    $subj = 'Feliz cumpleaños';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.cumpleanos', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			            });

				return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
			}

			if($tipo == 2)
			{
				$alumno = Instructor::find($request->id);

				    $subj = 'Feliz cumpleaños';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.cumpleanos', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			            });
			            
				return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
			}

			if($tipo == 3)
			{
				$alumno = Visitante::find($request->id);

				if($alumno->correo){

				    $subj = 'Feliz cumpleaños';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.cumpleanos', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			            });

			          }
			          else{

			          	return response()->json(['errores' => ['combo_cumpleaños' => [0, 'Este visitante no tiene correo electrónico configurado']], 'status' => 'ERROR'],422);
			          }
			            
				return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
			}

			if($tipo == 4)
			{
				$alumno = Proveedor::find($request->id);

				if($alumno->correo){

				    $subj = 'Feliz cumpleaños';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.cumpleanos', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			            });

			          }
			          else{

			          	return response()->json(['errores' => ['combo_cumpleaños' => [0, 'Este proveedor no tiene correo electrónico configurado']], 'status' => 'ERROR'],422);
			          }
			            
				return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
			}
		}


	 	$combo = explode('-',$request->arreglo);

	 	// if($request->tipo_cumpleaños == 'alumno_cumpleaños'){

	 		foreach($combo as $id){

	 			if($id != '')
	 			{

		 			$alumno = Alumno::withTrashed()->find($id);

				    $subj = 'Feliz cumpleaños';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.cumpleanos', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			                 });

					//Envio de SMS
				    if($request->birthday_SMS == 1){
						$data = collect([
							'nombre' => $alumno->nombre,
							'apellido' => $alumno->apellido,
							'celular' => $alumno->celular
						]);
			            $academia = Academia::find($alumno->academia_id);
			            $msg = 'Hola '.$alumno->nombre.', '.$academia->nombre.' te desea un feliz cumpleaños, en este día tan especial';
					    $sms = $this->sendAlumno($data, $msg);
					}

	 			}
			}
	 	// }else{

	 	// 	foreach($combo as $id){

	 	// 		if($id != '')
	 	// 		{
	 	// 			$clasegrupal = DB::table('inscripcion_clase_grupal')
		 //                ->join('alumnos', 'alumnos.id', '=', 'inscripcion_clase_grupal.alumno_id')
		 //                ->select('alumnos.correo')
		 //                ->where('inscripcion_clase_grupal.clase_grupal_id', '=', $id)
	  //           	->get();

	  //           	foreach($clasegrupal as $clase){

			// 		    $subj = 'Feliz cumpleaños';

			//         	$msj_html = $request->msj_html;

			// 	        $array = [
			// 	            'msj_html' => $request->msj_html,
			// 	            'email' => $clase->correo,
			// 	            'subj' => $subj
			// 	             ];

			// 	            Mail::send('correo.cumpleanos', $array, function($msj) use ($array){
			// 	                  $msj->subject($array['subj']);
			// 	                  $msj->to($array['email']);
			// 	                 });
			//         	}
	 	// 			}

	 	// 		}
	 	// 	}
 		}

 		public function correoAusencia(Request $request){

 				$tipo = Session::get('tipo');

		if($tipo){

			if($tipo == 1)
			{
				$alumno = Alumno::withTrashed()->find($request->id);

				    $subj = 'Riesgo de ausencia';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.ausencia', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			                 });

				return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
			}

			if($tipo == 2)
			{
				$alumno = Instructor::find($request->id);

				   $subj = 'Riesgo de ausencia';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.ausencia', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			                 });
			            
				return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
			}

			if($tipo == 3)
			{
				$alumno = Visitante::find($request->id);

				if($alumno->correo){

				    $subj = 'Riesgo de ausencia';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.ausencia', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			                 });

			          }
			          else{

			          	return response()->json(['errores' => ['combo_ausencia' => [0, 'Este visitante no tiene correo electrónico configurado']], 'status' => 'ERROR'],422);
			          }
			            
				return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
			}

			if($tipo == 4)
			{
				$alumno = Proveedor::find($request->id);

				if($alumno->correo){

				    $subj = 'Riesgo de ausencia';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.ausencia', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			                 });

			          }
			          else{


			          	return response()->json(['errores' => ['combo_ausencia' => [0, 'Este proveedor no tiene correo electrónico configurado']], 'status' => 'ERROR'],422);
			          }
			            
				return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
			}
		}

	 	$combo = explode('-',$request->arreglo);

	 	// if($request->tipo_ausencia == 'alumno_ausencia'){

	 		foreach($combo as $id){

	 			if($id != '')
	 			{
		 			$alumno = Alumno::withTrashed()->find($id);

				    $subj = 'Riesgo de ausencia';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.ausencia', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			                 });
	 			}
			}
	 	// }else{

	 	// 	foreach($combo as $id){

	 	// 		if($id != '')
	 	// 		{
	 	// 			$clasegrupal = DB::table('inscripcion_clase_grupal')
		 //                ->join('alumnos', 'alumnos.id', '=', 'inscripcion_clase_grupal.alumno_id')
		 //                ->select('alumnos.correo')
		 //                ->where('inscripcion_clase_grupal.clase_grupal_id', '=', $id)
	  //           	->get();

	  //           	foreach($clasegrupal as $clase){

			// 		    $subj = 'Riesgo de ausencia';

			//         	$msj_html = $request->msj_html;

			// 	        $array = [
			// 	            'msj_html' => $request->msj_html,
			// 	            'email' => $clase->correo,
			// 	            'subj' => $subj
			// 	             ];

			// 	            Mail::send('correo.ausencia', $array, function($msj) use ($array){
			// 	                  $msj->subject($array['subj']);
			// 	                  $msj->to($array['email']);
			// 	                 });
			//         	}
	 	// 			}

	 	// 		}
	 	// 	}
 		}

 		public function correoCobro(Request $request){

 		//dd($request->all());
		$tipo = Session::get('tipo');

		if($tipo){

			if($tipo == 1)
			{
				$alumno = Alumno::withTrashed()->find($request->id);

				    $subj = 'Aviso de cobro';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.cobro', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			                 });

				return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
			}

			if($tipo == 2)
			{
				$alumno = Instructor::find($request->id);

				   $subj = 'Aviso de cobro';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.cobro', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			                 });
			            
				return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
			}

			if($tipo == 3)
			{
				$alumno = Visitante::find($request->id);

				if($alumno->correo){

				    $subj = 'Aviso de cobro';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.cobro', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			                 });

			          }
			          else{

			          	return response()->json(['errores' => ['combo_cobro' => [0, 'Este visitante no tiene correo electrónico configurado']], 'status' => 'ERROR'],422);
			          }
			            
				return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
			}

			if($tipo == 4)
			{
				$alumno = Proveedor::find($request->id);

				if($alumno->correo){

				    $subj = 'Aviso de cobro';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.cobro', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			                 });

			          }
			          else{

			          	return response()->json(['errores' => ['combo_cobro' => [0, 'Este proveedor no tiene correo electrónico configurado']], 'status' => 'ERROR'],422);
			          }
			            
				return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
			}
		}

	 	$combo = explode('-',$request->arreglo);

	 	// if($request->tipo_cobro == 'alumno_cobro'){

	 		foreach($combo as $id){

	 			if($id != '')
	 			{
		 			$alumno = Alumno::withTrashed()->find($id);

				    $subj = 'Aviso de cobro';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            /*Mail::send('correo.cobro', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			                 });*/

					//Envio de SMS
			        if($request->cobro_SMS == 1){
						$data = collect([
							'nombre' => $alumno->nombre,
							'apellido' => $alumno->apellido,
							'celular' => $alumno->celular
						]);
			            $academia = Academia::find($alumno->academia_id);
			            $msg = 'Saludos '.$alumno->nombre.' en '.$academia->nombre.' te recordamos que el /_/_/ vence tu mensualidad. Gracias...';
					    $sms = $this->sendAlumno($data, $msg);
					}

	 			}
			}
	 	// }else{

	 	// 	foreach($combo as $id){

	 	// 		if($id != '')
	 	// 		{
	 	// 			$clasegrupal = DB::table('inscripcion_clase_grupal')
		 //                ->join('alumnos', 'alumnos.id', '=', 'inscripcion_clase_grupal.alumno_id')
		 //                ->select('alumnos.correo')
		 //                ->where('inscripcion_clase_grupal.clase_grupal_id', '=', $id)
	  //           	->get();

	  //           	foreach($clasegrupal as $clase){

			// 		    $subj = 'Aviso de cobro';

			//         	$msj_html = $request->msj_html;

			// 	        $array = [
			// 	            'msj_html' => $request->msj_html,
			// 	            'email' => $clase->correo,
			// 	            'subj' => $subj
			// 	             ];

			// 	            Mail::send('correo.cobro', $array, function($msj) use ($array){
			// 	                  $msj->subject($array['subj']);
			// 	                  $msj->to($array['email']);
			// 	                 });
			//         	}
	 	// 			}

	 	// 		}
	 	// 	}
 		}


 		public function correoSuspension(Request $request){


 					$tipo = Session::get('tipo');

		if($tipo){

			if($tipo == 1)
			{
				$alumno = Alumno::withTrashed()->find($request->id);

				    $subj = 'Suspensión de clases';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.suspension', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			                 });

				return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
			}

			if($tipo == 2)
			{
				$alumno = Instructor::find($request->id);

				   $subj = 'Suspensión de clases';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.suspension', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			                 });
			            
				return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
			}

			if($tipo == 3)
			{
				$alumno = Visitante::find($request->id);

				if($alumno->correo){

				    $subj = 'Suspensión de clases';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.suspension', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			                 });

			          }
			          else{

			          	return response()->json(['errores' => ['combo_suspension' => [0, 'Este visitante no tiene correo electrónico configurado']], 'status' => 'ERROR'],422);
			          }
			            
				return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
			}

			if($tipo == 4)
			{
				$alumno = Proveedor::find($request->id);

				if($alumno->correo){

				    $subj = 'Suspensión de clases';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.suspension', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			                 });

			          }
			          else{

			          	return response()->json(['errores' => ['combo_suspension' => [0, 'Este proveedor no tiene correo electrónico configurado']], 'status' => 'ERROR'],422);
			          }
			            
				return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
			}
		}

	 	$combo = explode('-',$request->arreglo);

	 	// if($request->tipo_cobro == 'alumno_suspension'){

	 		foreach($combo as $id){

	 			if($id != '')
	 			{
		 			$alumno = Alumno::withTrashed()->find($id);

				    $subj = 'Suspensión de clases';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.suspension', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			                 });
	 			}
			}
	 	// }else{

	 	// 	foreach($combo as $id){

	 	// 		if($id != '')
	 	// 		{
	 	// 			$clasegrupal = DB::table('inscripcion_clase_grupal')
		 //                ->join('alumnos', 'alumnos.id', '=', 'inscripcion_clase_grupal.alumno_id')
		 //                ->select('alumnos.correo')
		 //                ->where('inscripcion_clase_grupal.clase_grupal_id', '=', $id)
	  //           	->get();

	  //           	foreach($clasegrupal as $clase){

			// 		    $subj = 'Suspensión de clases';

			//         	$msj_html = $request->msj_html;

			// 	        $array = [
			// 	            'msj_html' => $request->msj_html,
			// 	            'email' => $clase->correo,
			// 	            'subj' => $subj
			// 	             ];

			// 	            Mail::send('correo.suspension', $array, function($msj) use ($array){
			// 	                  $msj->subject($array['subj']);
			// 	                  $msj->to($array['email']);
			// 	                 });
			//         	}
	 	// 			}

	 	// 		}
	 	// 	}
 		}

 		public function correoAdelanto(Request $request){

 						$tipo = Session::get('tipo');

		if($tipo){

			if($tipo == 1)
			{
				$alumno = Alumno::withTrashed()->find($request->id);

				    $subj = 'Adelanto de nuevas aperturas';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.adelanto', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			                 });

				return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
			}

			if($tipo == 2)
			{
				$alumno = Instructor::find($request->id);

				   $subj = 'Adelanto de nuevas aperturas';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.adelanto', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			                 });
			            
				return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
			}

			if($tipo == 3)
			{
				$alumno = Visitante::find($request->id);

				if($alumno->correo){

				   $subj = 'Adelanto de nuevas aperturas';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.adelanto', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			                 });

			          }
			          else{

			          	return response()->json(['errores' => ['combo_adelanto' => [0, 'Este visitante no tiene correo electrónico configurado']], 'status' => 'ERROR'],422);
			          }
			            
				return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
			}

			if($tipo == 4)
			{
				$alumno = Proveedor::find($request->id);

				if($alumno->correo){

				    $subj = 'Adelanto de nuevas aperturas';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.adelanto', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			                 });

			          }
			          else{

			          	return response()->json(['errores' => ['combo_adelanto' => [0, 'Este proveedor no tiene correo electrónico configurado']], 'status' => 'ERROR'],422);
			          }
			            
				return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
			}
		}

	 	$combo = explode('-',$request->arreglo);

	 	// if($request->tipo_adelanto == 'alumno_adelanto'){

	 		foreach($combo as $id){

	 			if($id != '')
	 			{
		 			$alumno = Alumno::withTrashed()->find($id);

				    $subj = 'Adelanto de nuevas aperturas';

		        	$msj_html = $request->msj_html;

			        $array = [
			            'msj_html' => $request->msj_html,
			            'email' => $alumno->correo,
			            'subj' => $subj
			             ];

			            Mail::send('correo.adelanto', $array, function($msj) use ($array){
			                  $msj->subject($array['subj']);
			                  $msj->to($array['email']);
			                 });
	 			}
			}
	 	// }else{

	 	// 	foreach($combo as $id){

	 	// 		if($id != '')
	 	// 		{
	 	// 			$clasegrupal = DB::table('inscripcion_clase_grupal')
		 //                ->join('alumnos', 'alumnos.id', '=', 'inscripcion_clase_grupal.alumno_id')
		 //                ->select('alumnos.correo')
		 //                ->where('inscripcion_clase_grupal.clase_grupal_id', '=', $id)
	  //           	->get();

	  //           	foreach($clasegrupal as $clase){

			// 		    $subj = 'Adelanto de nuevas aperturas';

			//         	$msj_html = $request->msj_html;

			// 	        $array = [
			// 	            'msj_html' => $request->msj_html,
			// 	            'email' => $clase->correo,
			// 	            'subj' => $subj
			// 	             ];

			// 	            Mail::send('correo.adelanto', $array, function($msj) use ($array){
			// 	                  $msj->subject($array['subj']);
			// 	                  $msj->to($array['email']);
			// 	                 });
			//         	}
	 	// 			}

	 	// 		}
	 	// 	}
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

		        // return redirect("/home")

		        // ->withErrors($validator)
		        // ->withInput();

		        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

		        //dd($validator);

		    }

		    else{

	 			$usuario = User::where('email', $request->email)->first();

	 			if($usuario){

	 				if($usuario->confirmation_token != null)
	 				{

			 			$academia = Academia::find($usuario->academia_id);

			            $subj = 'Activa tu cuenta en Easy Dance';
			            $link = route('confirmacion', ['token' => $usuario->confirmation_token]);

			        	$array = [
			            	'nombre' => $usuario->nombre,
			                'academia' => $academia->nombre,
			                'usuario' => $request->email,
			                'subj' => $subj,
			                'link' => $link
			            ];


			            Mail::send('correo.activacion', $array, function($msj) use ($array){
			                $msj->subject($array['subj']);
			                $msj->to($array['usuario']);
			            });

			            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
		            }
		            else{
	            		return response()->json(['error_mensaje' => 'Ups! Esta cuenta ya esta activada'], 422);
	           	 	}	
	            }else{
	            	return response()->json(['error_mensaje' => 'Ups! No Hemos encontrado la siguiente información del correo  asociada a tu cuenta'], 422);
	            }
	        }
	 	}

 		public function correoAyuda(Request $request)
 		{
 	        $array = [
 	            'msj_html' => $request->mensaje_ayuda,
 	            'email' => 'siriusdla@gmail.com',
 	            'subj' => 'Soporte / Ayuda'
 	             ];
			Mail::send('correo.ayuda', $array, function($msj) use ($array){
		      $msj->subject($array['subj']);
		      $msj->to($array['email']);
		    });

		    return 'Enviado';
 		}

 		public function indexayuda(){
 			return view('correo.ayuda');
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

          // return redirect("/home")

          // ->withErrors($validator)
          // ->withInput();

          return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

          //dd($validator);

      }

      else{

        if($request->tipo == 2){

          if($request->visitante_id == ''){
            return response()->json(['errores' => ['visitante_id' => [0, 'Ups! El interesado es requerido']], 'status' => 'ERROR'],422);
          }
        }

        $correo_informacion = new CorreoInformacion;

        $correo_informacion->url = $request->url;
        $correo_informacion->msj_html = $request->msj_html;
        $correo_informacion->subj = $request->subj;

        if($correo_informacion->save())
        {

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

            $nombre_img = "correo-". $correo_informacion->id . $extension;
            $image = base64_decode($base64_string);

            // \Storage::disk('correo')->put($nombre_img,  $image);
            $img = Image::make($image)->resize(1440, 500);
            $img->save('assets/uploads/correo/'.$nombre_img);

            $correo_informacion->imagen = $nombre_img;
            $correo_informacion->save();

            $imagen = "http://app.easydancelatino.com/assets/uploads/correo/".$nombre_img;

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