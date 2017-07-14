<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Mensaje;
use App\Alumno;
use App\Visitante;
use DB;
use Session;
use Image;

class ConfigMensajeController extends BaseController {

	public function principal(){

    	$mensajes = Mensaje::where('academia_id', Auth::user()->academia_id)->get();

        return view('configuracion.mensajes.principal')->with(['mensajes' => $mensajes]);
    }

    public function create(){

        return view('configuracion.mensajes.create');

    }

    public function store(Request $request){


		$rules = [
			'titulo' => 'required',
	        'contenido' => 'required|min:3|max:159',
	    ];

	    $messages = [
	        'titulo.required' => 'Ups! El titulo es requerido',
	        'contenido.required' => 'Ups! El mensaje es requerido',
	        'contenido.min' => 'El mínimo de caracteres permitidos son 3',
        	'contenido.max' => 'El máximo de caracteres permitidos son 159',
	    ];


	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){
	        
	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }else{

			$mensaje = new Mensaje;

			$mensaje->academia_id = Auth::user()->academia_id;
	        $mensaje->contenido = $request->contenido;
	        $mensaje->titulo = $request->titulo;

	        if($mensaje->save())
	        {
		        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);

		 	}else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
    	}
	}

	public function edit($id)
    {   
        $mensaje = Mensaje::find($id);

        if($mensaje){
            return view('configuracion.mensajes.planilla')->with(['mensaje' => $mensaje , 'id' => $id]);
        }else{
           return redirect("configuracion/mensajes"); 
        }
    }

    public function updateTitulo(Request $request){

    	$rules = [
	        'titulo' => 'required',
	    ];

	    $messages = [
	        'titulo.required' => 'Ups! El titulo es requerido',
	    ];


	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){
	        
	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }else{

	        $mensaje = Mensaje::find($request->id);
	        $mensaje->titulo = $request->titulo;

	        if($mensaje->save()){
	            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
    	}
    }

    public function updateContenido(Request $request){

    	$rules = [
	        'contenido' => 'required|min:3|max:159',
	    ];

	    $messages = [
	        'contenido.required' => 'Ups! El mensaje es requerido',
	        'contenido.min' => 'El mínimo de caracteres permitidos son 3',
        	'contenido.max' => 'El máximo de caracteres permitidos son 159',
	    ];


	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){
	        
	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }else{

	        $mensaje = Mensaje::find($request->id);
	        $mensaje->contenido = $request->contenido;

	        if($mensaje->save()){
	            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
    	}
    }

	public function destroy($id)
    {

        $mensaje = Mensaje::find($id);
        
        if($mensaje->delete()){
            return response()->json(['mensaje' => '¡Excelente! El mensaje ha sido eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

}