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
use Validator;
use DB;
use Mail;
use Illuminate\Support\Facades\Auth;
use Session;

class CorreoController extends Controller {

	public function __construct()
    {
        $this->middleware('auth');
    }

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

	public function indexsinselector($id){

		$tipo = Session::get('tipo');

		if($tipo){

			if($tipo == 1)
			{
				$alumno = Alumno::find($id);
				return view('correo.indexsinselector')->with(['usuario' => $alumno, 'id' => $id]);
			}

			if($tipo == 2)
			{
				$usuario = Instructor::find($id);
				return view('correo.indexsinselector')->with(['usuario' => $usuario, 'id' => $id]);
			}

			if($tipo == 3)
			{
				$usuario = Visitante::find($id);
				return view('correo.indexsinselector')->with(['usuario' => $usuario, 'id' => $id]);
			}

			if($tipo == 4)
			{
				$usuario = Proveedor::find($id);
				return view('correo.indexsinselector')->with(['usuario' => $usuario, 'id' => $id]);
			}


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

 		// dd($request->all());

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

			          	return response()->json(['errores'=>'Este visitante no tiene correo electrónico configurado', 'status' => 'ERROR-CORREO'],422);
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

			          	return response()->json(['errores'=>'Este proveedor no tiene correo electrónico configurado', 'status' => 'ERROR-CORREO'],422);
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

			          	return response()->json(['errores'=>'Este visitante no tiene correo electrónico configurado', 'status' => 'ERROR-CORREO'],422);
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

			          	return response()->json(['errores'=>'Este proveedor no tiene correo electrónico configurado', 'status' => 'ERROR-CORREO'],422);
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

			          	return response()->json(['errores'=>'Este visitante no tiene correo electrónico configurado', 'status' => 'ERROR-CORREO'],422);
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

			          	return response()->json(['errores'=>'Este proveedor no tiene correo electrónico configurado', 'status' => 'ERROR-CORREO'],422);
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

			            Mail::send('correo.cobro', $array, function($msj) use ($array){
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

			          	return response()->json(['errores'=>'Este visitante no tiene correo electrónico configurado', 'status' => 'ERROR-CORREO'],422);
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

			          	return response()->json(['errores'=>'Este proveedor no tiene correo electrónico configurado', 'status' => 'ERROR-CORREO'],422);
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

			          	return response()->json(['errores'=>'Este visitante no tiene correo electrónico configurado', 'status' => 'ERROR-CORREO'],422);
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

			          	return response()->json(['errores'=>'Este proveedor no tiene correo electrónico configurado', 'status' => 'ERROR-CORREO'],422);
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
 }