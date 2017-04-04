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
use App\EntradaBlog;
use App\CategoriaBlog;
use App\Academia;
use App\User;
use File;
use Mail;

class BlogController extends BaseController {


	public function index(){

		if(Auth::check()){
			$usuario_tipo = Auth::user()->usuario_tipo;
			$id = Auth::user()->academia_id;
		}else{
			$usuario_tipo = 0;
			$id = 7;
		}

		$academia = Academia::find($id);

		$array = array();

		$query = EntradaBlog::join('users', 'entradas_blog.usuario_id' , '=', 'users.id')
			->select('entradas_blog.academia_id', 'entradas_blog.categoria', 'users.nombre', 'users.apellido', 'entradas_blog.id', 'entradas_blog.created_at', 'entradas_blog.imagen', 'entradas_blog.contenido', 'entradas_blog.titulo', 'entradas_blog.usuario_id','users.sexo', 'entradas_blog.boolean_mostrar')
			->where('users.academia_id', $id)
			->orderBy('entradas_blog.created_at', 'desc');

		if(!$usuario_tipo){
			$query->where('entradas_blog.boolean_mostrar', 1)
		}

		$entradas = $query->get();

		$categoria_array = array();

		$categorias = CategoriaBlog::where('academia_id', $id)->orWhere('academia_id', null)->orderBy('nombre')->get();

		$cantidad_total = 0;

		foreach($categorias as $categoria){


			$query = EntradaBlog::where('categoria', $categoria->id)->where('academia_id', $id);

			if(!$usuario_tipo){
				$query->where('entradas_blog.boolean_mostrar', 1)
			}

			$cantidad = $query->count();

			$cantidad_total = $cantidad_total + $cantidad;

			$categoria_array[$categoria->id] = ['nombre' => $categoria->nombre, 'cantidad' => $cantidad];
		}

		$i = 1;
                
		foreach($entradas as $entrada){

			$usuario = User::find($entrada->usuario_id);


            if($usuario->imagen){
                $usuario_imagen = $usuario->imagen;
            }else{
                $usuario_imagen = '';
            }

			$contenido = File::get('assets/uploads/entradas/entrada-'.$entrada->id.'.txt');

			$collection=collect($entrada);     
            $entrada_array = $collection->toArray();

            if($entrada->imagen){
                $imagen = "/assets/uploads/entradas/{$entrada->imagen}";
            }else{
                $imagen = '';
            }

            $fecha_tmp = Carbon::parse($entrada->created_at);

            $dia = $fecha_tmp->format('d'); 

            switch ($fecha_tmp->month) {
                case 1:
                    $mes = "Enero";
                    break;
                case 2:
                    $mes = "Febrero";
                    break;
                case 3:
                    $mes = "Marzo";
                    break;
                case 4:
                    $mes = "Abril";
                    break;
                case 5:
                    $mes = "Mayo";
                    break;
                case 6:
                    $mes = "Junio";
                    break;
                case 7:
                    $mes = "Julio";
                    break;
                case 8:
                    $mes = "Agosto";
                    break;
                case 9:
                    $mes = "Septiembre";
                    break;
                case 10:
                    $mes = "Octubre";
                    break;
                case 11:
                    $mes = "Noviembre";
                    break;
                case 12:
                    $mes = "Diciembre";
                    break;
            }

            $ano = $fecha_tmp->format('Y'); 

            $hora = Carbon::parse($entrada->created_at)->format('h:i:s A');

            $fecha = $dia . ' de ' . $mes . ' ' . $ano . ' ' . $hora;
            
            $entrada_array['fecha'] = $fecha;  
            $entrada_array['contenido'] = $contenido;
            $entrada_array['imagen'] = $imagen;
            $entrada_array['usuario_imagen'] = $usuario_imagen;
            $entrada_array['sexo'] = $usuario->sexo;
            $entrada_array['url']= "/blog/entrada/{$entrada->id}";
            $entrada_array['contador'] = $i;
            $array[$entrada->id] = $entrada_array;

            $i = $i + 1;

		}

    	return view('blog.index')->with(['academia' => $academia, 'entradas' => $array, 'categorias' => $categoria_array, 'cantidad' => $cantidad_total]);
 	}

 	public function categoria($id){

		if(Auth::check()){
			$usuario_tipo = Auth::user()->usuario_tipo;
			$id = Auth::user()->academia_id;
		}else{
			$usuario_tipo = 0;
			$id = 7;
		}

		$academia = Academia::find($academia_id);

		$array = array();

		$query = EntradaBlog::join('users', 'entradas_blog.usuario_id' , '=', 'users.id')
			->join('categorias_blog', 'entradas_blog.categoria' , '=', 'categorias_blog.id')
			->select('users.nombre', 'users.apellido', 'entradas_blog.id', 'entradas_blog.created_at', 'entradas_blog.imagen', 'entradas_blog.contenido', 'entradas_blog.titulo', 'entradas_blog.usuario_id', 'users.sexo', 'entradas_blog.boolean_mostrar')
			->where('users.academia_id', $academia_id)
			->where('categorias_blog.nombre', $id)
			->orderBy('entradas_blog.created_at', 'desc');

		if(!$usuario_tipo){
			$query->where('entradas_blog.boolean_mostrar', 1)
		}

		$entradas = $query->get();

		$categoria_array = array();

		$categorias = CategoriaBlog::where('academia_id', $academia_id)->orWhere('academia_id', null)->orderBy('nombre')->get();

		$cantidad_total = 0;
		

		foreach($categorias as $categoria){

			$query = EntradaBlog::where('categoria', $categoria->id)->where('academia_id', $id);

			if(!$usuario_tipo){
				$query->where('entradas_blog.boolean_mostrar', 1)
			}

			$cantidad = $query->count();

			$cantidad_total = $cantidad_total + $cantidad;

			$categoria_array[$categoria->id] = ['nombre' => $categoria->nombre, 'cantidad' => $cantidad];
		}

		$i = 1;

		foreach($entradas as $entrada){

			$usuario = User::find($entrada->usuario_id);


            if($usuario->imagen){
                $usuario_imagen = $usuario->imagen;
            }else{
                $usuario_imagen = '';
            }

			$contenido = File::get('assets/uploads/entradas/entrada-'.$entrada->id.'.txt');

			$collection=collect($entrada);     
            $entrada_array = $collection->toArray();

            if($entrada->imagen){
                $imagen = "/assets/uploads/entradas/{$entrada->imagen}";
            }else{
                $imagen = '';
            }

            $fecha_tmp = Carbon::parse($entrada->created_at);

            $dia = $fecha_tmp->format('d'); 

            switch ($fecha_tmp->month) {
                case 1:
                    $mes = "Enero";
                    break;
                case 2:
                    $mes = "Febrero";
                    break;
                case 3:
                    $mes = "Marzo";
                    break;
                case 4:
                    $mes = "Abril";
                    break;
                case 5:
                    $mes = "Mayo";
                    break;
                case 6:
                    $mes = "Junio";
                    break;
                case 7:
                    $mes = "Julio";
                    break;
                case 8:
                    $mes = "Agosto";
                    break;
                case 9:
                    $mes = "Septiembre";
                    break;
                case 10:
                    $mes = "Octubre";
                    break;
                case 11:
                    $mes = "Noviembre";
                    break;
                case 12:
                    $mes = "Diciembre";
                    break;
            }

            $ano = $fecha_tmp->format('Y'); 

            $hora = Carbon::parse($entrada->created_at)->format('h:i:s A');

            $fecha = $dia . ' de ' . $mes . ' ' . $ano . ' ' . $hora;
            
            $entrada_array['fecha'] = $fecha;  
            $entrada_array['contenido'] = $contenido;
            $entrada_array['imagen'] = $imagen;
            $entrada_array['usuario_imagen'] = $usuario_imagen;
            $entrada_array['sexo'] = $usuario->sexo;
            $entrada_array['url']= "/blog/entrada/{$entrada->id}";
            $entrada_array['contador'] = $i;
            $array[$entrada->id] = $entrada_array;

            $i = $i + 1;

		}

    	return view('blog.index')->with(['academia' => $academia, 'entradas' => $array, 'categorias' => $categoria_array, 'cantidad' => $cantidad_total]);
	    
 	}

 	public function entrada($id){


 		if(Auth::check()){
			$usuario_tipo = Auth::user()->usuario_tipo;
			$id = Auth::user()->academia_id;
		}else{
			$usuario_tipo = 0;
			$id = 7;
		}
		
		$entrada = EntradaBlog::join('users', 'entradas_blog.usuario_id' , '=', 'users.id')
			->select('users.nombre', 'users.apellido', 'entradas_blog.id', 'entradas_blog.created_at', 'entradas_blog.imagen', 'entradas_blog.contenido', 'entradas_blog.titulo', 'entradas_blog.academia_id', 'entradas_blog.usuario_id', 'users.sexo', 'entradas_blog.imagen_footer', 'entradas_blog.boolean_mostrar')
			->where('entradas_blog.id', $id)
		->first();

		if($entrada)
		{
			$usuario = User::find($entrada->usuario_id);

            if($usuario->imagen){
                $usuario_imagen = $usuario->imagen;
            }else{
                $usuario_imagen = '';
            }

			$academia = Academia::find($entrada->academia_id);

			$entradas = EntradaBlog::where('academia_id', $entrada->academia_id)
				->orderBy('created_at', 'desc')
			->get();

			$entradas = $entradas->toArray();

			$categoria_array = array();

			$categorias = CategoriaBlog::where('academia_id', $entrada->academia_id)->orWhere('academia_id', null)->orderBy('nombre')->get();

			$cantidad_total = 0;

			foreach($categorias as $categoria){

				$query = EntradaBlog::where('categoria', $categoria->id)->where('academia_id', $id);

				if(!$usuario_tipo){
					$query->where('entradas_blog.boolean_mostrar', 1)
				}

				$cantidad = $query->count();

				$cantidad_total = $cantidad_total + $cantidad;

				$categoria_array[$categoria->id] = ['nombre' => $categoria->nombre, 'cantidad' => $cantidad];
			}

			$contenido = File::get('assets/uploads/entradas/entrada-'.$entrada->id.'.txt');

			$collection=collect($entrada);     
            $entrada_array = $collection->toArray();

            if($entrada->imagen){
                $imagen = "/assets/uploads/entradas/{$entrada->imagen}";
            }else{
                $imagen = '';
            }

            if($entrada->imagen_footer){
                $imagen_footer = "/assets/uploads/entradas/{$entrada->imagen_footer}";
            }else{
                $imagen_footer = '';
            }

            $fecha_tmp = Carbon::parse($entrada->created_at);

            $dia = $fecha_tmp->format('d'); 

            switch ($fecha_tmp->month) {
                case 1:
                    $mes = "Enero";
                    break;
                case 2:
                    $mes = "Febrero";
                    break;
                case 3:
                    $mes = "Marzo";
                    break;
                case 4:
                    $mes = "Abril";
                    break;
                case 5:
                    $mes = "Mayo";
                    break;
                case 6:
                    $mes = "Junio";
                    break;
                case 7:
                    $mes = "Julio";
                    break;
                case 8:
                    $mes = "Agosto";
                    break;
                case 9:
                    $mes = "Septiembre";
                    break;
                case 10:
                    $mes = "Octubre";
                    break;
                case 11:
                    $mes = "Noviembre";
                    break;
                case 12:
                    $mes = "Diciembre";
                    break;
            }

            $ano = $fecha_tmp->format('Y'); 

            $hora = Carbon::parse($entrada->created_at)->format('h:i:s A');

            $fecha = $dia . ' de ' . $mes . ' ' . $ano . ' ' . $hora;
            
            $entrada_array['fecha'] = $fecha;  
            $entrada_array['contenido'] = $contenido;
            $entrada_array['imagen_footer'] = $imagen_footer;
            $entrada_array['imagen'] = $imagen;
            $entrada_array['usuario_imagen'] = $usuario_imagen;
            $entrada_array['url']= "/blog/entrada/{$entrada->id}";

            return view('blog.entrada')->with(['academia' => $academia, 'entrada' => $entrada_array, 'categorias' => $categoria_array, 'entradas' => $entradas, 'cantidad' => $cantidad_total]);

		}else{
			return redirect("blog"); 
		}
    	
 	}

	public function publicar(){

		$categorias = CategoriaBlog::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->orderBy('nombre')->get();

    	return view('blog.publicar')->with(['categorias' => $categorias]);
 	}

 	public function store(Request $request)
    {

	    $rules = [
	        'titulo' => 'required|min:3|max:50',
	        'categoria' => 'required',
	        'contenido' => 'required',
	    ];

	    $messages = [

	        'titulo.required' => 'Ups! El Titulo es requerido ',
	        'titulo.min' => 'El mínimo de caracteres permitidos son 3',
	        'titulo.max' => 'El máximo de caracteres permitidos son 50',
	        'categoria.required' => 'Ups! La categoria es requerida',
	        'contenido.required' => 'Ups! El contenido es requerido',

	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

	    else{

	        $entrada = new EntradaBlog;

	        $titulo = title_case($request->titulo);

	        $entrada->usuario_id = Auth::user()->id;
	        $entrada->academia_id = Auth::user()->academia_id;
	        $entrada->titulo = $titulo;
	        $entrada->categoria = $request->categoria;

	        if($entrada->save()){

	            $nombre_archivo = 'entrada-'.$entrada->id.'.txt';

	            \Storage::disk('entradas')->put($nombre_archivo,  $request->contenido);

	        	$entrada->contenido = $nombre_archivo;

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

	                $nombre_img = "imagen_entrada-". $entrada->id . $extension;
	                $image = base64_decode($base64_string);

	                // \Storage::disk('fiesta')->put($nombre_img,  $image);
	                $img = Image::make($image)->resize(1440, 500);
	                $img->save('assets/uploads/entradas/'.$nombre_img);

	                $entrada->imagen = $nombre_img;
	                $entrada->save();

	               	$imagen = "http://app.easydancelatino.com/assets/uploads/entradas/".$nombre_img;

	            }else{
	            	$imagen = "http://oi65.tinypic.com/v4cuuf.jpg";

	            }

	            $array = [
					'imagen' => $imagen,
					'url' => 'http://app.easydancelatino.com/blog/entrada/'.$entrada->id,
					'msj_html' => str_limit($request->contenido, $limit = 350, $end = '...'),
					'email' => 'coliseodelasalsa@gmail.com',
					'subj' => $request->titulo
				];

				// Mail::send('correo.personalizado', $array, function($msj) use ($array){
				// 	$msj->subject($array['subj']);
				//     $msj->to($array['email']);
				// });
	            
	            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
	    }
    }

    public function edit($id){

		$entrada = EntradaBlog::join('categorias_blog', 'entradas_blog.categoria' , '=', 'categorias_blog.id')
			->select('entradas_blog.*', 'categorias_blog.nombre as categoria', 'categorias_blog.id as categoria_id')
			->where('entradas_blog.id', $id)
		->first();

		if($entrada)
		{
			$categorias = CategoriaBlog::where('academia_id', $id)->orWhere('academia_id', null)->orderBy('nombre')->get();
			$contenido = File::get('assets/uploads/entradas/entrada-'.$entrada->id.'.txt');

            return view('blog.planilla')->with(['contenido' => $contenido, 'entrada' => $entrada, 'categorias' => $categorias, 'id' => $id]);

		}else{
			return redirect("blog"); 
		}
 	}

 	public function updateTitulo(Request $request){

	    $rules = [
	        'titulo' => 'required|min:3|max:20',
	    ];

	    $messages = [

	        'titulo.required' => 'Ups! El Nombre  es requerido ',
	        'titulo.min' => 'El mínimo de caracteres permitidos son 3',
	        'titulo.max' => 'El máximo de caracteres permitidos son 20',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

        $entrada = EntradaBlog::find($request->id);;

        $entrada->titulo = $request->titulo;

        if($entrada->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateCategoria(Request $request){

	    $rules = [

	        'categoria' => 'required',
	    ];

	    $messages = [

	        'categoria.required' => 'Ups! La categoria es requerida',

	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

        $entrada = EntradaBlog::find($request->id);;

        $entrada->categoria = $request->categoria;

        if($entrada->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateImagen(Request $request)
    {
        $entrada = EntradaBlog::find($request->id);
        
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

            $nombre_img = "imagen_entrada-". $entrada->id . $extension;
            $image = base64_decode($base64_string);

            $img = Image::make($image)->resize(1440, 500);
            $img->save('assets/uploads/entradas/'.$nombre_img);
        }
        else{
            $nombre_img = "";
        }

        $entrada->imagen = $nombre_img;

        if($entrada->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateMostrar(Request $request){

	    $rules = [

	        'boolean_mostrar' => 'required',
	    ];

	    $messages = [

	        'boolean_mostrar.required' => 'Ups! La categoria es requerida',

	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

        $entrada = EntradaBlog::find($request->id);

        $entrada->boolean_mostrar = $request->boolean_mostrar;

        if($entrada->save()){
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

	        'contenido.required' => 'Ups! El contenido es requerida',

	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

        $entrada = EntradaBlog::find($request->id);

        $nombre_archivo = 'entrada-'.$entrada->id.'.txt';

	    \Storage::disk('entradas')->put($nombre_archivo,  $request->contenido);

	    $entrada->contenido = $nombre_archivo;

        if($entrada->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function destroy($id)
    {

        $entrada = EntradaBlog::find($id);
        
        if($entrada->delete()){
            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    
}