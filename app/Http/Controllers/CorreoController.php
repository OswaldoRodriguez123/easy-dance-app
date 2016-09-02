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
use Validator;
use DB;
use Mail;
use Illuminate\Support\Facades\Auth;
use Session;

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
	

	public function indexsinselector($id){

		$tipo = Session::get('tipo');

		if($tipo){

			if($tipo == 1)
			{
				$usuario = Alumno::find($id);
				$tiene_cuenta = User::where('usuario_id', $id)->where('usuario_tipo', 2)->where('confirmation_token', null)->count();
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
				$alumno = Alumno::find($request->id);

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

		 			$alumno = Alumno::find($id);

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
				$alumno = Alumno::find($request->id);

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
		 			$alumno = Alumno::find($id);

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
				$alumno = Alumno::find($request->id);

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
		 			$alumno = Alumno::find($id);

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
				$alumno = Alumno::find($request->id);

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
		 			$alumno = Alumno::find($id);

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
				$alumno = Alumno::find($request->id);

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
		 			$alumno = Alumno::find($id);

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
			            $link = route('confirmacion', ['token' => $usuario->confirmation_token, 'email'=>$usuario->email]);

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
 }