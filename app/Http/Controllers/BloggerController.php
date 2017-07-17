<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use DB;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;
use Image;
use App\Blogger;
use App\Academia;
use App\User;
use Mail;

class BloggerController extends BaseController {

	public function index(){

		$bloggers = Blogger::where('academia_id', Auth::user()->academia_id)->get();
		$usuario_tipo = Session::get('easydance_usuario_tipo');

		return view('configuracion.blogger.principal')->with(['bloggers' => $bloggers, 'usuario_tipo' => $usuario_tipo]);

	}

	public function create(){

		return view('configuracion.blogger.create')->with([]);

	}

	public function store(Request $request)
    {

	    $rules = [
	        'nombre' => 'required|min:3|max:20',
	        'descripcion' => 'required',
	    ];

	    $messages = [

	        'nombre.required' => 'Ups! El Nombre es requerido ',
	        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
	        'nombre.max' => 'El máximo de caracteres permitidos son 20',
	        'descripcion.required' => 'Ups! La descripción es requerida',

	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

	    else{

	        $blogger = new Blogger;

	        $nombre = title_case($request->nombre);

	        $blogger->academia_id = Auth::user()->academia_id;
	        $blogger->nombre = $nombre;
	        $blogger->descripcion = $request->descripcion;
	        $blogger->facebook = $request->facebook;
            $blogger->twitter = $request->twitter;
            $blogger->linkedin = $request->linkedin;
            $blogger->instagram = $request->instagram;
            $blogger->pagina_web = $request->pagina_web;
            $blogger->youtube = $request->youtube;

	        if($blogger->save()){

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

	                $nombre_img = "blogger-". $blogger->id . $extension;
	                $image = base64_decode($base64_string);

	                // \Storage::disk('fiesta')->put($nombre_img,  $image);
	                $img = Image::make($image)->resize(300, 300);
	                $img->save('assets/uploads/bloggers/'.$nombre_img);

	                $blogger->imagen = $nombre_img;
	                $blogger->save();

	            }

	            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
	    }
    }

    public function edit($id){

		$blogger = Blogger::find($id);

		if($blogger)
		{
			
            return view('configuracion.blogger.planilla')->with(['blogger' => $blogger, 'id' => $id]);

		}else{
			return redirect("configuracion/blogger"); 
		}
 	}

    public function destroy($id)
    {

        $blogger = Blogger::find($id);
        
        if($blogger->delete()){
            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateNombre(Request $request){

	    $rules = [
	        'nombre' => 'required|min:3|max:20',
	    ];

	    $messages = [

	        'nombre.required' => 'Ups! El Nombre  es requerido ',
	        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
	        'nombre.max' => 'El máximo de caracteres permitidos son 20',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

        $blogger = Blogger::find($request->id);

        $blogger->nombre = $request->nombre;

        if($blogger->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateDescripcion(Request $request){

	    $rules = [

	        'descripcion' => 'required',
	    ];

	    $messages = [

	        'descripcion.required' => 'Ups! La categoria es requerida',

	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

        $blogger = Blogger::find($request->id);

        $blogger->descripcion = $request->descripcion;

        if($blogger->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateImagen(Request $request)
    {
        $blogger = Blogger::find($request->id);
        
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

            $nombre_img = "blogger-". $blogger->id . $extension;
            $image = base64_decode($base64_string);

            $img = Image::make($image)->resize(300, 300);
            $img->save('assets/uploads/bloggers/'.$nombre_img);
        }
        else{
            $nombre_img = "";
        }

        $blogger->imagen = $nombre_img;

        if($blogger->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateRedes(Request $request){

        $blogger = Blogger::find($request->id);

        $blogger->facebook = $request->facebook;
        $blogger->twitter = $request->twitter;
        $blogger->instagram = $request->instagram;
        $blogger->pagina_web = $request->pagina_web;
        $blogger->linkedin = $request->linkedin;
        $blogger->youtube = $request->youtube;
        
        if($blogger->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }


}