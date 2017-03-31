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
use File;

class BlogController extends BaseController {


	public function index(){

		$academia = Academia::find(Auth::user()->academia_id);

		$array = array();

		$entradas = EntradaBlog::join('users', 'entradas_blog.usuario_id' , '=', 'users.id')
			->select('users.nombre', 'users.apellido', 'entradas_blog.id', 'entradas_blog.created_at', 'entradas_blog.imagen', 'entradas_blog.contenido', 'entradas_blog.titulo')
			->where('users.academia_id', $academia->id)
		->get();

		$categoria_array = array();

		$categorias = CategoriaBlog::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->orderBy('nombre')->get();

		foreach($categorias as $categoria){
			$cantidad = EntradaBlog::where('categoria',$categoria->id)->count();

			$categoria_array[$categoria->id] = ['nombre' => $categoria->nombre, 'cantidad' => $cantidad];
		}

		foreach($entradas as $entrada){

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
            $entrada_array['url']= "/blog/entrada/{$entrada->id}";
            $array[$entrada->id] = $entrada_array;

		}

    	return view('blog.index')->with(['academia' => $academia, 'entradas' => $array, 'categorias' => $categoria_array]);
 	}

 	public function categoria($id){

		$academia = Academia::find(Auth::user()->academia_id);

		$array = array();

		$entradas = EntradaBlog::join('users', 'entradas_blog.usuario_id' , '=', 'users.id')
			->join('categorias_blog', 'entradas_blog.categoria' , '=', 'categorias_blog.id')
			->select('users.nombre', 'users.apellido', 'entradas_blog.id', 'entradas_blog.created_at', 'entradas_blog.imagen', 'entradas_blog.contenido', 'entradas_blog.titulo')
			->where('users.academia_id', $academia->id)
			->where('categorias_blog.nombre', $id)
		->get();

		if($entradas){


			$categoria_array = array();

			$categorias = CategoriaBlog::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->orderBy('nombre')->get();

			foreach($categorias as $categoria){
				$cantidad = EntradaBlog::where('categoria',$categoria->id)->count();

				$categoria_array[$categoria->id] = ['nombre' => $categoria->nombre, 'cantidad' => $cantidad];
			}

			foreach($entradas as $entrada){

				$contenido = File::get('assets\uploads\entradas\entrada-'.$entrada->id.'.txt');

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
	            $entrada_array['url']= "/blog/entrada/{$entrada->id}";
	            $array[$entrada->id] = $entrada_array;

			}

	    	return view('blog.index')->with(['academia' => $academia, 'entradas' => $array, 'categorias' => $categoria_array]);
	    }else{
	    	return redirect("blog"); 
	    }

 	}

 	public function entrada($id){

		$academia = Academia::find(Auth::user()->academia_id);

		$entrada = EntradaBlog::join('users', 'entradas_blog.usuario_id' , '=', 'users.id')
			->select('users.nombre', 'users.apellido', 'entradas_blog.id', 'entradas_blog.created_at', 'entradas_blog.imagen', 'entradas_blog.contenido', 'entradas_blog.titulo')
			->where('entradas_blog.id', $id)
		->first();;

		if($entrada)
		{
			$categoria_array = array();

			$categorias = CategoriaBlog::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->orderBy('nombre')->get();

			foreach($categorias as $categoria){
				$cantidad = EntradaBlog::where('categoria',$categoria->id)->count();

				$categoria_array[$categoria->id] = ['nombre' => $categoria->nombre, 'cantidad' => $cantidad];
			}

			$contenido = File::get('assets\uploads\entradas\entrada-'.$entrada->id.'.txt');

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
            $entrada_array['url']= "/blog/entrada/{$entrada->id}";

            return view('blog.entrada')->with(['academia' => $academia, 'entrada' => $entrada_array, 'categorias' => $categoria_array]);

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

	            }
	            
	            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
	    }
    }
}