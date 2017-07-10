<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Correo;
use DB;
use Session;
use Image;

class ConfigCorreoController extends BaseController {

	public function principal(){

    	$correos = Correo::where('academia_id', Auth::user()->academia_id)->get();

        return view('configuracion.correos.principal')->with(['correos' => $correos]);
    }

    public function create(){

        return view('configuracion.correos.create');

    }

    public function store(Request $request){


		$rules = [
			'titulo' => 'required',
	        'url' => 'required|active_url',
	        'contenido' => 'required',
	    ];

	    $messages = [

	    	'url.required' => 'Ups! La URL es requerida',
	        'url.active_url' => 'Ups! La URL no es valida',
	        'titulo.required' => 'Ups! El titulo es requerido',
	        'contenido.required' => 'Ups! El mensaje es requerido',
	    ];


	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){
	        
	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }else{

			$correo = new Correo;

			$correo->academia_id = Auth::user()->academia_id;
	        $correo->url = $request->url;
	        $correo->contenido = $request->contenido;
	        $correo->titulo = $request->titulo;

	        if($correo->save())
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

	                $nombre_img = "correo-". $correo->id . $extension;
	                $image = base64_decode($base64_string);

	                // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
	                $img = Image::make($image)->resize(1440, 500);
	                $img->save('assets/uploads/correos/'.$nombre_img);

	                $correo->imagen = $nombre_img;
	                $correo->save();

		        }

		        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);

		 	}else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
    	}
	}

	public function edit($id)
    {   
        $correo = Correo::find($id);

        if($correo){
            return view('configuracion.correos.planilla')->with(['correo' => $correo , 'id' => $id]);
        }else{
           return redirect("configuracion/correos"); 
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

	        $correo = Correo::find($request->id);
	        $correo->titulo = $request->titulo;

	        if($correo->save()){
	            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
    	}
    }

    public function updateUrl(Request $request){

    	$rules = [
	        'url' => 'required|active_url',
	    ];

	    $messages = [

	    	'url.required' => 'Ups! La URL es requerida',
	        'url.active_url' => 'Ups! La URL no es valida',
	    ];


	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){
	        
	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }else{

	        $correo = Correo::find($request->id);
	        $correo->url = $request->url;

	        if($correo->save()){
	            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
    	}
    }

    public function updateImagen(Request $request)
    {
        $correo = Correo::find($request->id);
        
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

            $nombre_img = "correo-". $correo->id . $extension;
            $image = base64_decode($base64_string);

            // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
            $img = Image::make($image)->resize(1440, 500);
            $img->save('assets/uploads/correos/'.$nombre_img);
        }
        else{
            $nombre_img = "";
        }

        $correo->imagen = $nombre_img;

        if($correo->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateContenido(Request $request){

    	$rules = [
	        'contenido' => 'required',
	    ];

	    $messages = [
	        'contenido.required' => 'Ups! El mensaje es requerido',
	    ];


	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){
	        
	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }else{

	        $correo = Correo::find($request->id);
	        $correo->contenido = $request->contenido;

	        if($correo->save()){
	            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
    	}
    }

	public function destroy($id)
    {

        $correo = Correo::find($id);
        
        if($correo->delete()){
            return response()->json(['mensaje' => '¡Excelente! El correo ha sido eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
}