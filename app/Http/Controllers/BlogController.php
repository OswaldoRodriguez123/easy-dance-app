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
use App\Blogger;
use App\Alumno;
use App\Visitante;
use App\CorreoBlog;
use File;
use Mail;

class BlogController extends BaseController {


	public function index(){

		if(Auth::check()){
            $usuario_tipo = Session::get('easydance_usuario_tipo');
			$id = Auth::user()->academia_id;
		}else{
			$usuario_tipo = 0;
			$id = 7;
		}

		$academia = Academia::find($id);

		$array = array();

		$query = EntradaBlog::join('bloggers', 'entradas_blog.usuario_id' , '=', 'bloggers.id')
			->select('entradas_blog.*', 'bloggers.nombre')
			->where('entradas_blog.academia_id', $id)
			->orderBy('entradas_blog.created_at', 'desc');

        $recientes = EntradaBlog::join('bloggers', 'entradas_blog.usuario_id' , '=', 'bloggers.id')
            ->select('entradas_blog.*', 'bloggers.nombre')
            ->where('entradas_blog.academia_id', $id)
            ->orderBy('entradas_blog.created_at', 'desc')
            ->where('entradas_blog.boolean_mostrar', 1)
            ->limit(4)
        ->get();

        $populares = EntradaBlog::join('bloggers', 'entradas_blog.usuario_id' , '=', 'bloggers.id')
            ->select('entradas_blog.*', 'bloggers.nombre')
            ->where('entradas_blog.academia_id', $id)
            ->orderBy('entradas_blog.cantidad_visitas', 'desc')
            ->where('entradas_blog.boolean_mostrar', 1)
            ->limit(4)
        ->get();

		if(!$usuario_tipo){
			$query->where('entradas_blog.boolean_mostrar', 1);
		}

		$entradas = $query->get();

		$categoria_array = array();

		$categorias = CategoriaBlog::where('academia_id', $id)->orWhere('academia_id', null)->orderBy('nombre')->get();

		$cantidad_total = 0;

		foreach($categorias as $categoria){


			$query = EntradaBlog::where('categoria', $categoria->id)->where('academia_id', $id);

			if(!$usuario_tipo){
				$query->where('entradas_blog.boolean_mostrar', 1);
			}

			$cantidad = $query->count();

			$cantidad_total = $cantidad_total + $cantidad;

			$categoria_array[$categoria->id] = ['nombre' => $categoria->nombre, 'cantidad' => $cantidad];
		}

		$i = 1;
                
		foreach($entradas as $entrada){

			$usuario = Blogger::find($entrada->usuario_id);

            if($usuario->imagen){
                $usuario_imagen = $usuario->imagen;
            }else{
                $usuario_imagen = '';
            }

			$contenido = File::get('assets/uploads/entradas/entrada-'.$entrada->id.'.txt');

            $contenido = $this->cut_html($contenido, 350);

			$collection=collect($entrada);     
            $entrada_array = $collection->toArray();

            if($entrada->imagen_poster){
                $imagen = "/assets/uploads/entradas/{$entrada->imagen_poster}";
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
            $entrada_array['url']= "/blog/entrada/{$entrada->id}";
            $entrada_array['contador'] = $i;
            $array[$entrada->id] = $entrada_array;

            $i = $i + 1;

		}

    	return view('blog.index')->with(['academia' => $academia, 'entradas' => $array, 'categorias' => $categoria_array, 'cantidad' => $cantidad_total, 'populares' => $populares, 'recientes' => $recientes, 'usuario_tipo' => $usuario_tipo]);
 	}

 	public function categoria($id){

		if(Auth::check()){
            $usuario_tipo = Session::get('easydance_usuario_tipo');
			$academia_id = Auth::user()->academia_id;
		}else{
			$usuario_tipo = 0;
			$academia_id = 7;
		}

		$academia = Academia::find($academia_id);

		$array = array();

		$query = EntradaBlog::join('bloggers', 'entradas_blog.usuario_id' , '=', 'bloggers.id')
			->join('categorias_blog', 'entradas_blog.categoria' , '=', 'categorias_blog.id')
			->select('bloggers.nombre', 'entradas_blog.*')
			->where('entradas_blog.academia_id', $academia_id)
			->where('categorias_blog.nombre', $id)
			->orderBy('entradas_blog.created_at', 'desc');

		if(!$usuario_tipo){
			$query->where('entradas_blog.boolean_mostrar', 1);
		}

		$entradas = $query->get();

		$categoria_array = array();

		$categorias = CategoriaBlog::where('academia_id', $academia_id)->orWhere('academia_id', null)->orderBy('nombre')->get();

		$cantidad_total = 0;
		

		foreach($categorias as $categoria){

			$query = EntradaBlog::where('categoria', $categoria->id)->where('academia_id', $academia_id);

			if(!$usuario_tipo){
				$query->where('entradas_blog.boolean_mostrar', 1);
			}

			$cantidad = $query->count();

			$cantidad_total = $cantidad_total + $cantidad;

			$categoria_array[$categoria->id] = ['nombre' => $categoria->nombre, 'cantidad' => $cantidad];
		}

		$i = 1;

		foreach($entradas as $entrada){

			$usuario = Blogger::find($entrada->usuario_id);


            if($usuario->imagen){
                $usuario_imagen = $usuario->imagen;
            }else{
                $usuario_imagen = '';
            }

			$contenido = File::get('assets/uploads/entradas/entrada-'.$entrada->id.'.txt');
            $contenido = $this->cut_html($contenido, 350);

			$collection=collect($entrada);     
            $entrada_array = $collection->toArray();

            if($entrada->imagen_poster){
                $imagen = "/assets/uploads/entradas/{$entrada->imagen_poster}";
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
            $entrada_array['url']= "/blog/entrada/{$entrada->id}";
            $entrada_array['contador'] = $i;
            $array[$entrada->id] = $entrada_array;

            $i = $i + 1;

		}

        $recientes = EntradaBlog::join('bloggers', 'entradas_blog.usuario_id' , '=', 'bloggers.id')
            ->select('entradas_blog.*', 'bloggers.nombre')
            ->where('entradas_blog.academia_id', $academia_id)
            ->orderBy('entradas_blog.created_at', 'desc')
            ->where('entradas_blog.boolean_mostrar', 1)
            ->limit(4)
        ->get();

        $populares = EntradaBlog::join('bloggers', 'entradas_blog.usuario_id' , '=', 'bloggers.id')
            ->select('entradas_blog.*', 'bloggers.nombre')
            ->where('entradas_blog.academia_id', $academia_id)
            ->orderBy('entradas_blog.cantidad_visitas', 'desc')
            ->where('entradas_blog.boolean_mostrar', 1)
            ->limit(4)
        ->get();

    	return view('blog.index')->with(['academia' => $academia, 'entradas' => $array, 'categorias' => $categoria_array, 'cantidad' => $cantidad_total, 'recientes' => $recientes, 'populares' => $populares, 'usuario_tipo' => $usuario_tipo]);
	    
 	}

 	public function entradas_por_autor($id){

		if(Auth::check()){
            $usuario_tipo = Session::get('easydance_usuario_tipo');
			$academia_id = Auth::user()->academia_id;
		}else{
			$usuario_tipo = 0;
			$academia_id = 7;
		}

		$academia = Academia::find($academia_id);

		$array = array();

		$query = EntradaBlog::join('bloggers', 'entradas_blog.usuario_id' , '=', 'bloggers.id')
			->join('categorias_blog', 'entradas_blog.categoria' , '=', 'categorias_blog.id')
			->select('bloggers.nombre', 'entradas_blog.*')
			->where('bloggers.id', $id)
			->orderBy('entradas_blog.created_at', 'desc');

		if(!$usuario_tipo){
			$query->where('entradas_blog.boolean_mostrar', 1);
		}

		$entradas = $query->get();

		$categoria_array = array();

		$categorias = CategoriaBlog::where('academia_id', $academia_id)->orWhere('academia_id', null)->orderBy('nombre')->get();

		$cantidad_total = 0;
		
		foreach($categorias as $categoria){

			$query = EntradaBlog::where('categoria', $categoria->id)->where('academia_id', $id);

			if(!$usuario_tipo){
				$query->where('entradas_blog.boolean_mostrar', 1);
			}

			$cantidad = $query->count();

			$cantidad_total = $cantidad_total + $cantidad;

			$categoria_array[$categoria->id] = ['nombre' => $categoria->nombre, 'cantidad' => $cantidad];
		}

		$i = 1;

		foreach($entradas as $entrada){

			$usuario = Blogger::find($entrada->usuario_id);


            if($usuario->imagen){
                $usuario_imagen = $usuario->imagen;
            }else{
                $usuario_imagen = '';
            }

			$contenido = File::get('assets/uploads/entradas/entrada-'.$entrada->id.'.txt');
            $contenido = $this->cut_html($contenido, 350);

			$collection=collect($entrada);     
            $entrada_array = $collection->toArray();

            if($entrada->imagen_poster){
                $imagen = "/assets/uploads/entradas/{$entrada->imagen_poster}";
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
            $entrada_array['url']= "/blog/entrada/{$entrada->id}";
            $entrada_array['contador'] = $i;
            $array[$entrada->id] = $entrada_array;

            $i = $i + 1;

		}

        $recientes = EntradaBlog::join('bloggers', 'entradas_blog.usuario_id' , '=', 'bloggers.id')
            ->select('entradas_blog.*', 'bloggers.nombre')
            ->where('entradas_blog.academia_id', $id)
            ->orderBy('entradas_blog.created_at', 'desc')
            ->where('entradas_blog.boolean_mostrar', 1)
            ->limit(4)
        ->get();

        $populares = EntradaBlog::join('bloggers', 'entradas_blog.usuario_id' , '=', 'bloggers.id')
            ->select('entradas_blog.*', 'bloggers.nombre')
            ->where('entradas_blog.academia_id', $id)
            ->orderBy('entradas_blog.cantidad_visitas', 'desc')
            ->where('entradas_blog.boolean_mostrar', 1)
            ->limit(4)
        ->get();

    	return view('blog.index')->with(['academia' => $academia, 'entradas' => $array, 'categorias' => $categoria_array, 'cantidad' => $cantidad_total, 'recientes' => $recientes, 'populares' => $populares, 'usuario_tipo' => $usuario_tipo]);
	    
 	}

 	public function entrada($id){


 		if(Auth::check()){
			$usuario_tipo = Session::get('easydance_usuario_tipo');
			$academia_id = Auth::user()->academia_id;
		}else{
			$usuario_tipo = 0;
			$academia_id = 7;
		}

        $count = strlen($id);

        if($count <= 7){
            $entrada = EntradaBlog::find($id);
        }else{
            $correo = CorreoBlog::where('url',$id)->first();
            $entrada = EntradaBlog::find($correo->entrada_id);
        }

		if($entrada)
		{
			$usuario = Blogger::find($entrada->usuario_id);

            if($usuario->imagen){
                $usuario_imagen = "assets/uploads/bloggers/{$usuario->imagen}";
            }else{
                $usuario_imagen = "assets/img/EASY_DANCE_3_.jpg";
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

				$query = EntradaBlog::where('categoria', $categoria->id)->where('academia_id', $academia_id);

				if(!$usuario_tipo){
					$query->where('entradas_blog.boolean_mostrar', 1);
				}

				$cantidad = $query->count();

				$cantidad_total = $cantidad_total + $cantidad;

				$categoria_array[$categoria->id] = ['nombre' => $categoria->nombre, 'cantidad' => $cantidad];
			}

			$contenido = File::get('assets/uploads/entradas/entrada-'.$entrada->id.'.txt');

			$collection=collect($entrada);     
            $entrada_array = $collection->toArray();

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

            if (!Session::has('entrada_'.$id)) {  
                $entrada->cantidad_visitas = $entrada->cantidad_visitas + 1;
                $entrada->save();
                $fecha_sesion=Carbon::now();
                Session::put('entrada_'.$id,$fecha_sesion);
            }

            $recientes = EntradaBlog::join('bloggers', 'entradas_blog.usuario_id' , '=', 'bloggers.id')
                ->select('entradas_blog.*', 'bloggers.nombre')
                ->where('entradas_blog.academia_id', $academia_id)
                ->orderBy('entradas_blog.created_at', 'desc')
                ->where('entradas_blog.boolean_mostrar', 1)
                ->limit(4)
            ->get();

            $populares = EntradaBlog::join('bloggers', 'entradas_blog.usuario_id' , '=', 'bloggers.id')
                ->select('entradas_blog.*', 'bloggers.nombre')
                ->where('entradas_blog.academia_id', $academia_id)
                ->orderBy('entradas_blog.cantidad_visitas', 'desc')
                ->where('entradas_blog.boolean_mostrar', 1)
                ->limit(4)
            ->get();

            if($count > 7){
     
                $correo->boolean_visto = 1;
                $correo->save();           
            }

            return view('blog.entrada')->with(['academia' => $academia, 'entrada' => $entrada_array, 'categorias' => $categoria_array, 'entradas' => $entradas, 'cantidad' => $cantidad_total, 'usuario_imagen' => $usuario_imagen, 'blogger' => $usuario, 'recientes' => $recientes, 'populares' => $populares, 'usuario_tipo' => $usuario_tipo]);

		}else{
			return redirect("blog"); 
		}
    	
 	}

	public function publicar(){

        $bloggers = Blogger::where('academia_id', Auth::user()->academia_id)->get();

		$categorias = CategoriaBlog::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->orderBy('nombre')->get();

    	return view('blog.publicar')->with(['categorias' => $categorias, 'bloggers' => $bloggers]);
 	}

 	public function store(Request $request)
    {

	    $rules = [
            'usuario_id' => 'required',
	        'titulo' => 'required|min:3|max:60',
	        'categoria' => 'required',
	        'contenido' => 'required',
	    ];

	    $messages = [
            'usuario_id.required' => 'Ups! El Autor es requerido ',
	        'titulo.required' => 'Ups! El Titulo es requerido ',
	        'titulo.min' => 'El mínimo de caracteres permitidos son 3',
	        'titulo.max' => 'El máximo de caracteres permitidos son 60',
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

	        $entrada->usuario_id = $request->usuario_id;
	        $entrada->academia_id = Auth::user()->academia_id;
	        $entrada->titulo = $titulo;
	        $entrada->categoria = $request->categoria;
            $entrada->dirigido = $request->dirigido;

	        if($entrada->save()){

	            $nombre_archivo = 'entrada-'.$entrada->id.'.txt';

	            \Storage::disk('entradas')->put($nombre_archivo,  $request->contenido);

	        	$entrada->contenido = $nombre_archivo;

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

	            if($request->imagePoster64 && $request->imagePoster64 != "data:,"){

	                $base64_string = substr($request->imagePoster64, strpos($request->imagePoster64, ",")+1);
	                $path = storage_path();
	                $split = explode( ';', $request->imagePoster64 );
	                $type =  explode( '/',  $split[0]);
	                $ext = $type[1];
	                
	                if($ext == 'jpeg' || 'jpg'){
	                    $extension = '.jpg';
	                }

	                if($ext == 'png'){
	                    $extension = '.png';
	                }

	                $nombre_img = "imagen_poster-". $entrada->id . $extension;
	                $image = base64_decode($base64_string);

	                $img = Image::make($image)->resize(300, 300);
	                $img->save('assets/uploads/entradas/'.$nombre_img);

	                $entrada->imagen_poster = $nombre_img;
	                $entrada->save();

	            }
	            
	            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
	    }
    }

    public function enviar($id){

        $entrada = EntradaBlog::find($id);

        if($entrada)
        {
            if($entrada->imagen){
                $imagen = "http://app.easydancelatino.com/assets/uploads/entradas/".$entrada->imagen;

            }else{
                $imagen = "http://oi65.tinypic.com/v4cuuf.jpg";

            }

            $contenido = File::get('assets/uploads/entradas/entrada-'.$entrada->id.'.txt');
            $correos = array();

            if($entrada->dirigido == 1 OR $entrada->dirigido == 2){

                $alumnos = Alumno::where('academia_id',$entrada->academia_id)->whereNotNull('correo')->get();

                foreach($alumnos as $alumno){

                    if($alumno->correo){

                        $correos[] = $alumno->correo;

                        // $correo = CorreoBlog::where('entrada_id',$id)->where('usuario_tipo',1)->where('usuario_id',$alumno->id)->first();

                        // if($correo){
                        //     $url = $correo->url;
                        // }else{
                        //     do{
                        //         $url = str_random(8);
                        //         $find = CorreoBlog::where('url', $url)->first();
                        //     }while ($find);

                        //     $correo = new CorreoBlog;

                        //     $correo->entrada_id = $id;
                        //     $correo->usuario_tipo = 1;
                        //     $correo->usuario_id = $alumno->id;
                        //     $correo->url = $url;
                        //     $correo->save();
                        // }

                        // $array = [
                        //     'imagen' => $imagen,
                        //     'url' => 'http://app.easydancelatino.com/blog/entrada/'.$url,
                        //     'msj_html' => $this->cut_html($contenido, 350),
                        //     'email' => $alumno->correo,
                        //     'subj' => $entrada->titulo
                        // ];

                        // Mail::send('correo.personalizado', $array, function($msj) use ($array){
                        //     $msj->subject($array['subj']);
                        //     $msj->to($array['email']);
                        // });

                    }
                }

                $array = [
                    'imagen' => $imagen,
                    'url' => 'http://app.easydancelatino.com/blog/entrada/'.$id,
                    'msj_html' => $this->cut_html($contenido, 350),
                    'correos' => $correos,
                    'subj' => $entrada->titulo
                ];

                Mail::send('correo.personalizado', $array, function($msj) use ($array){
                    $msj->subject($array['subj']);
                    $msj->to($array['correos']);
                });
            }

            else if($entrada->dirigido == 1 OR $entrada->dirigido == 3){

                $visitantes = Visitante::where('academia_id',$entrada->academia_id)->whereNotNull('correo')->get();

                foreach($visitantes as $visitante){

                    if($visitante->correo){

                        $correos[] = $visitante->correo;

                        // $correo = CorreoBlog::where('entrada_id',$id)->where('usuario_tipo',2)->where('usuario_id',$visitante->id)->first();

                        // if($correo){
                        //     $url = $correo->url;
                        // }else{
                        //     do{
                        //         $url = str_random(8);
                        //         $find = CorreoBlog::where('url', $url)->first();
                        //     }while ($find);

                        //     $correo = new CorreoBlog;

                        //     $correo->entrada_id = $id;
                        //     $correo->usuario_tipo = 2;
                        //     $correo->usuario_id = $visitante->id;
                        //     $correo->url = $url;
                        //     $correo->save();
                        // }

                        // $array = [
                        //     'imagen' => $imagen,
                        //     'url' => 'http://app.easydancelatino.com/blog/entrada/'.$url,
                        //     'msj_html' => $this->cut_html($contenido, 350),
                        //     'email' => $visitante->correo,
                        //     'subj' => $entrada->titulo
                        // ];

                        // Mail::send('correo.personalizado', $array, function($msj) use ($array){
                        //     $msj->subject($array['subj']);
                        //     $msj->to($array['email']);
                        // });

                    }
                }

                 $array = [
                    'imagen' => $imagen,
                    'url' => 'http://app.easydancelatino.com/blog/entrada/'.$id,
                    'msj_html' => $this->cut_html($contenido, 350),
                    'correos' => $correos,
                    'subj' => $entrada->titulo
                ];

                Mail::send('correo.personalizado', $array, function($msj) use ($array){
                    $msj->subject($array['subj']);
                    $msj->to($array['correos']);
                });

            }

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        
    }


    public function visitas($id){

        $visitas = CorreoBlog::where('entrada_id', $id)
            ->where('boolean_visto', 1)
        ->get();

        foreach($visitas as $visita){
            if($visita->usuario_tipo == 1){
                $alumno = Alumno::find($visita->usuario_id);

                if($alumno){

                    $collection=collect($alumno);     
                    $alumno_array = $collection->toArray();

                    $array['1-'.$alumno->id] = $alumno_array;
                }
            }else{
                $visitante = Visitante::find($visita->usuario_id);

                if($visitante){

                    $collection=collect($visitante);     
                    $visitante_array = $collection->toArray();

                    $array['2-'.$visitante->id] = $visitante_array;
                }
            }
        }

        return view('blog.visitas')->with(['visitas' => $array, 'id' => $id]);
    }

    public function edit($id){

		$entrada = EntradaBlog::join('categorias_blog', 'entradas_blog.categoria' , '=', 'categorias_blog.id')
            ->join('bloggers', 'entradas_blog.usuario_id' , '=', 'bloggers.id')
			->select('entradas_blog.*', 'categorias_blog.nombre as categoria', 'categorias_blog.id as categoria_id', 'bloggers.nombre as blogger')
			->where('entradas_blog.id', $id)
		->first();

		if($entrada)
		{
            $bloggers = Blogger::where('academia_id', Auth::user()->academia_id)->get();
			$categorias = CategoriaBlog::where('academia_id', $id)->orWhere('academia_id', null)->orderBy('nombre')->get();
			$contenido = File::get('assets/uploads/entradas/entrada-'.$entrada->id.'.txt');

            return view('blog.planilla')->with(['contenido' => $contenido, 'entrada' => $entrada, 'categorias' => $categorias, 'id' => $id, 'bloggers' => $bloggers]);

		}else{
			return redirect("blog"); 
		}
 	}

    public function updateAutor(Request $request){

        $rules = [

            'usuario_id' => 'required',
        ];

        $messages = [

            'usuario_id.required' => 'Ups! El Autor es requerido',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        $entrada = EntradaBlog::find($request->id);

        $entrada->usuario_id = $request->usuario_id;

        if($entrada->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

 	public function updateTitulo(Request $request){

	    $rules = [
	        'titulo' => 'required|min:3|max:60',
	    ];

	    $messages = [

	        'titulo.required' => 'Ups! El Nombre  es requerido ',
	        'titulo.min' => 'El mínimo de caracteres permitidos son 3',
	        'titulo.max' => 'El máximo de caracteres permitidos son 60',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

        $entrada = EntradaBlog::find($request->id);

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

        $entrada = EntradaBlog::find($request->id);

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

    public function updateImagenPoster(Request $request)
    {
        $entrada = EntradaBlog::find($request->id);
        
        if($request->imagePoster64 && $request->imagePoster64 != "data:,"){
            $base64_string = substr($request->imagePoster64, strpos($request->imagePoster64, ",")+1);
            $path = storage_path();
            $split = explode( ';', $request->imagePoster64 );
            $type =  explode( '/',  $split[0]);

            $ext = $type[1];
            
            if($ext == 'jpeg' || 'jpg'){
                $extension = '.jpg';
            }

            if($ext == 'png'){
                $extension = '.png';
            }

            $nombre_img = "imagen_poster-". $entrada->id . $extension;
            $image = base64_decode($base64_string);

            $img = Image::make($image)->resize(300, 300);
            $img->save('assets/uploads/entradas/'.$nombre_img);
        }
        else{
            $nombre_img = "";
        }

        $entrada->imagen_poster = $nombre_img;

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

    public function directorio()
    {

	    if(Auth::check()){
			$usuario_tipo = Session::get('easydance_usuario_tipo');
			$id = Auth::user()->academia_id;
		}else{
			$usuario_tipo = 0;
			$id = 7;
		}

		$categorias = CategoriaBlog::where('academia_id', $id)->orWhere('academia_id', null)->orderBy('nombre')->get();

		$cantidad_total = 0;

		foreach($categorias as $categoria){


			$query = EntradaBlog::where('categoria', $categoria->id)->where('academia_id', $id);

			if(!$usuario_tipo){
				$query->where('entradas_blog.boolean_mostrar', 1);
			}

			$cantidad = $query->count();

			$cantidad_total = $cantidad_total + $cantidad;

			$categoria_array[$categoria->id] = ['nombre' => $categoria->nombre, 'cantidad' => $cantidad];
		}

	    $bloggers = Blogger::where('academia_id', $id)->get();

        $recientes = EntradaBlog::join('bloggers', 'entradas_blog.usuario_id' , '=', 'bloggers.id')
            ->select('entradas_blog.*', 'bloggers.nombre')
            ->where('entradas_blog.academia_id', $id)
            ->orderBy('entradas_blog.created_at', 'desc')
            ->where('entradas_blog.boolean_mostrar', 1)
            ->limit(4)
        ->get();

        $populares = EntradaBlog::join('bloggers', 'entradas_blog.usuario_id' , '=', 'bloggers.id')
            ->select('entradas_blog.*', 'bloggers.nombre')
            ->where('entradas_blog.academia_id', $id)
            ->orderBy('entradas_blog.cantidad_visitas', 'desc')
            ->where('entradas_blog.boolean_mostrar', 1)
            ->limit(4)
        ->get();

	    return view('blog.autores')->with(['bloggers' => $bloggers,'categorias' => $categoria_array, 'cantidad' => $cantidad_total, 'recientes' => $recientes, 'populares' => $populares]);
	}
    
}