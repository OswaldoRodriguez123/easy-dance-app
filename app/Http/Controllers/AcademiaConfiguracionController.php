<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Academia;
use App\Alumno;
use App\Impuesto;
use App\Instructor;
use App\ConfigProductos;
use App\ClaseGrupal;
use App\ConfigServicios;
use App\ConfigClasesGrupales;
use App\ConfigEspecialidades;
use App\ConfigEstudios;
use App\ConfigNiveles;
use App\Taller;
use App\Fiesta;
use App\Campana;
use App\ClasePersonalizada;
use App\InscripcionClaseGrupal;
use App\ItemsFacturaProforma;
use App\Paises;
use App\Regalo;
use App\PerfilEvaluativo;
use App\User;
use App\Factura;
use App\Pago;
use App\ItemsFactura;
use App\ConfigPagosInstructor;
use App\PagoInstructor;
use Validator;
use Carbon\Carbon;
use Storage;
use Session;
use Illuminate\Support\Facades\Auth;
use DB;
use Image;
use Illuminate\Support\Facades\Input;

class AcademiaConfiguracionController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index()
	{
        $academia = Academia::find(Auth::user()->academia_id);


        // $array = array(2, 4);

        // $usuarios = User::whereIn('usuario_tipo', $array)->get();

        // foreach($usuarios as $usuario){

        //     if($usuario->confirmation_token = null OR $usuario->confirmation_token == ''){

        //         $usuario->confirmation_token = str_random(40);
        //         $usuario->boolean_condiciones = 0;
        //         $usuario->save();

        //     }

        // }

        // $array = array(2, 4);


        // // $results = User::whereIn('id', function ( $query ) {
        // //     $query->select('id')->from('users')->groupBy('email')->havingRaw('count(*) > 1');
        // // })->get();

        // $alumnos = DB::table('alumnos')
        //     ->Leftjoin('users', 'users.usuario_id', '=', 'alumnos.id')
        //     ->select('alumnos.*')
        //     ->where('users.id', null)
        //     // ->whereIn('users.usuario_tipo', $array)
        // ->get();

        // foreach($alumnos as $alumno)
        // {
        //     $usuario = User::whereIn('usuario_tipo', $array)->Where('usuario_id', $alumno->id)->first();

        //     if(!$usuario)
        //     {
        //         if($alumno->correo)
        //         {

        //             $password = str_random(8);

        //             $usuario = new User;

        //             $usuario->academia_id = $alumno->academia_id;
        //             $usuario->nombre = $alumno->nombre;
        //             $usuario->apellido = $alumno->apellido;
        //             $usuario->telefono = $alumno->telefono;
        //             $usuario->celular = $alumno->celular;
        //             $usuario->sexo = $alumno->sexo;
        //             $usuario->email = $alumno->correo;
        //             $usuario->como_nos_conociste_id = 1;
        //             $usuario->direccion = $alumno->id;
        //             // $usuario->confirmation_token = str_random(40);
        //             $usuario->password = bcrypt($password);
        //             $usuario->usuario_id = $alumno->id;
        //             $usuario->usuario_tipo = 2;

        //             $usuario->save();

        //         }

        //     }

        // }
        
        //ADMINISTRADOR
        if(Auth::user()->usuario_tipo == 1 || Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6){

            $fecha_comprobacion = Carbon::createFromFormat('Y-m-d', $academia->fecha_comprobacion);
            $hoy = Carbon::now();

            if($fecha_comprobacion < $hoy){
                if($hoy == $hoy->lastOfMonth()){

                    $config_pagos = ConfigPagosInstructor::where('tipo', 2)->get();

                    foreach($config_pagos as $config_pago){
                        $pago = new PagoInstructor;

                        $pago->instructor_id=$config_pago->instructor_id;
                        $pago->tipo=$config_pago->tipo;
                        $pago->monto=$config_pago->monto;
                        $pago->clase_grupal_id=$config_pago->clase_grupal_id;

                        $pago->save();
                    }

                }

                return $this->pagorecurrente();
            }

            return view('inicio.index')->with(['paises' => Paises::all() , 'especialidades' => ConfigEspecialidades::all(), 'academia' => $academia]); 
        }

        //ALUMNOS
        if(Auth::user()->boolean_condiciones){

            $contador_clase = 0;
            $contador_taller = 0;
            $contador_fiesta = 0;
            $contador_campana = 0;

            $array=array();

            $clase_grupal_join = DB::table('clases_grupales')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('config_clases_grupales.nombre','clases_grupales.id', 'config_clases_grupales.descripcion', 'clases_grupales.imagen', 'clases_grupales.created_at', 'clases_grupales.fecha_inicio', 'clases_grupales.dias_prorroga')
                ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
                ->where('clases_grupales.boolean_promocionar','=', 1)
                ->where('clases_grupales.deleted_at', '=', null)
            ->get();

            $alumno_examenes = DB::table('evaluaciones')
                ->join('alumnos','evaluaciones.alumno_id','=','alumnos.id')
                ->join('examenes','evaluaciones.examen_id','=','examenes.id')
                ->select('examenes.nombre','evaluaciones.id')
                ->where('evaluaciones.alumno_id','=',Auth::user()->usuario_id)
                ->get();


            foreach($clase_grupal_join as $clase){

                $fecha = Carbon::createFromFormat('Y-m-d', $clase->fecha_inicio);
                $fecha->addDays($clase->dias_prorroga);
                if($fecha >= Carbon::now()){

                    if($clase->imagen){
                        $imagen = "/assets/uploads/clase_grupal/{$clase->imagen}";
                    }else{
                        $imagen = '';
                    }

                    $array[]=array('nombre' => $clase->nombre , 'descripcion' => $clase->descripcion ,'imagen' => $imagen , 'url' => "/agendar/clases-grupales/progreso/{$clase->id}", 'facebook' => "/agendar/clases-grupales/progreso/{$clase->id}", 'twitter' => "Participa en la clase grupal {$clase->nombre} te invita @EasyDanceLatino", 'twitter_url' => "/agendar/clases-grupales/progreso/{$clase->id}", 'creacion' => $clase->created_at);

                    $contador_clase = $contador_clase + 1;
                }

            }

            $talleres = Taller::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

            foreach($talleres as $taller){

                $fecha = Carbon::createFromFormat('Y-m-d', $taller->fecha_inicio);

                if($fecha >= Carbon::now()){

                    if($taller->imagen){
                        $imagen = "/assets/uploads/taller/{$taller->imagen}";
                    }else{
                        $imagen = '';
                    }

                    $array[]=array('nombre' => $taller->nombre , 'descripcion' => $taller->descripcion ,'imagen' => $imagen , 'url' => "/agendar/talleres/progreso/{$taller->id}", 'facebook' => "/agendar/talleres/progreso/{$taller->id}", 'twitter' => "Participa en el taller {$taller->nombre} te invita @EasyDanceLatino", 'twitter_url' => "/agendar/talleres/progreso/{$taller->id}" , 'creacion' => $taller->created_at);

                    $contador_taller = $contador_taller + 1;
                }

            }

            $fiestas = Fiesta::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

            foreach($fiestas as $fiesta){

                $fecha = Carbon::createFromFormat('Y-m-d', $fiesta->fecha_inicio);

                if($fecha >= Carbon::now()){

                    if($fiesta->imagen){
                        $imagen = "/assets/uploads/fiesta/{$fiesta->imagen}";
                    }else{
                        $imagen = '';
                    }

                    $array[]=array('nombre' => $fiesta->nombre , 'descripcion' => $fiesta->descripcion ,'imagen' => $imagen , 'url' => "/agendar/fiestas/progreso/{$fiesta->id}", 'facebook' => "/agendar/fiesta/progreso/{$fiesta->id}", 'twitter' => "Participa en la fiesta {$fiesta->nombre} te invita @EasyDanceLatino", 'twitter_url' => "/agendar/fiestas/progreso/{$fiesta->id}", 'creacion' => $fiesta->created_at);

                    $contador_fiesta = $contador_fiesta + 1;
                }

            }

            $campanas = Campana::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

            foreach($campanas as $campana){

                $fecha = Carbon::createFromFormat('Y-m-d', $campana->fecha_inicio);

                if($fecha >= Carbon::now()){

                    $contador_campana = $contador_campana + 1;
                }

            }

            $collection = collect($array);

            $sorted = $collection->sortByDesc('creacion');

            $i = 0;

            $arreglo=array();

            foreach($sorted as $tmp){

                $tmp['contador'] = $i;
                $arreglo[$i] = $tmp;
                $i = $i + 1;

            }

            $instructor_contador = Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->where('instructores.boolean_promocionar', 1)->count();
            $clase_personalizada_contador = ClasePersonalizada::where('academia_id', '=' ,  Auth::user()->academia_id)->count();

                $perfil = PerfilEvaluativo::where('usuario_id', Auth::user()->usuario_id)->first();

                if($perfil){
                    $tiene_perfil = 1;
                }else{
                    $tiene_perfil = 0;
                }

                $array_deuda = array();

                $proformas = ItemsFacturaProforma::where('alumno_id', '=' ,  Auth::user()->usuario_id)->get();

                foreach($proformas as $proforma){

                $fecha = Carbon::createFromFormat('Y-m-d', $proforma->fecha_vencimiento);

                if($fecha > Carbon::now()){

                    $array_deuda[]=array('nombre' => $proforma->nombre , 'fecha_vencimiento' => $proforma->fecha_vencimiento ,'monto' => $proforma->importe_neto);

                    }

                }  

                if (Session::has('fecha_sesion')) {                
                   
                }else{
                   $fecha_sesion=Carbon::now();
                   Session::put('fecha_sesion',$fecha_sesion);
                }
                

                return view('vista_alumno.index')->with(['academia' => $academia, 'enlaces' => $arreglo , 'clases_grupales' => $contador_clase, 'talleres' => $contador_taller , 'fiestas' =>  $contador_fiesta ,'campanas' => $contador_campana ,'regalos' => Regalo::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'perfil' => $tiene_perfil, 'instructor_contador' => $instructor_contador, 'clase_personalizada_contador' => $clase_personalizada_contador, 'proformas' => $array_deuda, 'alumno_examenes' => $alumno_examenes]);  
            
        }else{
            return view('vista_alumno.condiciones')->with('academia', $academia);
        }
                           
	}

    public function menu(){

        if(Auth::user()->usuario_tipo == 1 || Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6){

        return view('menu.index');
        }else{
            return redirect("/inicio"); 
        }
        
    }

    public function principal()
    {
        // $academia= Academia::where('id',Auth::user()->academia_id)
        //            ->select('nombre', 'imagen', 'descripcion', 'telefono', 'celular', 'correo', 'direccion', 'normativa' , 'manual', 'programacion','link_video')
        //            ->get();

        // $academiaRedes= Academia::where('id',Auth::user()->academia_id)
        //            ->select('facebook','twitter','linkedin','instagram','pagina_web','youtube')
        //            ->get();

        // $academiaEstudios= ConfigEstudios::where('academia_id',Auth::user()->academia_id)
        //            ->get();

        // $academiaNiveles= ConfigNiveles::where('academia_id',Auth::user()->academia_id)
        //            ->get();

        $academiaGrupales= ConfigClasesGrupales::where('academia_id',Auth::user()->academia_id)
                   ->get();
        
        $academiaServicios= ConfigServicios::where('academia_id',Auth::user()->academia_id)
                   ->get();

        $clasepersonalizada= ClasePersonalizada::where('academia_id',Auth::user()->academia_id)
                   ->get();


        // $collection = collect($academia[0]);
        // $keys = $collection->keys();
        // $arrayCampos=$keys->all();

        // $collectionRedes = collect($academiaRedes[0]);
        // $keysRedes = $collection->keys();
        // $arrayCamposRedes=$keysRedes->all();

        // $cantCampos=count($arrayCampos)+4;

        // $lleno=1;
        // $vacio=0;
        // $redes=1;

        // if(!collect($academiaEstudios)->isEmpty()){
        //     $lleno=$lleno+1;
        // }else{
        //     $vacio=$vacio+1;
        // } 

        // if(!collect($academiaNiveles)->isEmpty()){
        //     $lleno=$lleno+1;
        // }else{
        //     $vacio=$vacio+1;
        // }    

        // foreach ($arrayCampos as $campo) {
        //     if($academia[0]->$campo!=""){
        //         $lleno=$lleno+1;
        //     }else{
        //         $vacio=$vacio+1;
        //     }
        // }

        // foreach ($arrayCamposRedes as $campo) {
        //     if($academiaRedes[0]->$campo!=""){
        //         $lleno=$lleno+1;
        //         $redes=0;
        //         breack;
        //     }
        // }

        // if($redes!=0){
        //     $vacio=$vacio+$redes;
        // }        
        

        // $porcentajeAcademia=($lleno/$cantCampos)*100;

        // $porcentajeAcademia=round($porcentajeAcademia,2);


        // if(!collect($academiaGrupales)->isEmpty()){
        //     $porcentajeGrupales=100;
        // }else{
        //     $porcentajeGrupales=0;
        // } 


        // if(!collect($academiaServicios)->isEmpty()){
        //     $porcentajeServicios=100;
        // }else{
        //     $porcentajeServicios=0;
        // } 


        // $porcentajeTotal=(($porcentajeAcademia+$porcentajeGrupales+$porcentajeServicios)/300)*100;

        // $porcentajeTotal=round($porcentajeTotal,2);

        // //dd(round($porcentaje,2));

        // //dd($vacio);


        //$= ClasePersonalizada::where('academia_id',Auth::user()->academia_id)->get();
        $campos_array=array("imagen","telefono","celular","correo","direccion","facebook","twitter","linkedin","instagram","pagina_web","youtube","normativa","manual","programacion","incluye_iva","link_video");
        $porcentajeAcademia=0;
        $campos_ocupados=0;

         $academias_datos = Academia::where('id',Auth::user()->id)->get();
         $info_de_academias=DB::getSchemaBuilder()->getColumnListing('academias');

         for ($i=0; $i < count($info_de_academias); $i++) {

             for ($j=0; $j < count($campos_array); $j++) { 

                 if($info_de_academias[$i]==$campos_array[$j]){

                    if($academias_datos[0]['attributes'][$info_de_academias[$i]])
                    {
                        $campos_ocupados++;
                    }
                 }
             }
         }

        $porcentajeAcademia=($campos_ocupados*100)/count($campos_array);

        if($academiaGrupales){
             $porcentajeGrupales=100;
        }else{
             $porcentajeGrupales=0;
        }

        if($clasepersonalizada){
             $porcentajePersonalizado=100;
        }else{
             $porcentajePersonalizado=0;
        }

        if($academiaServicios){
             $porcentajeServicios=100;
        }else{
             $porcentajeServicios=0;
        } 
        
        return view('configuracion.index',compact('porcentajeGrupales','porcentajeServicios','porcentajePersonalizado','porcentajeAcademia'));                  
    }

    public function listo()
    {       
        return view('flujo_registro.listo');                    
    }


    public function configuracion(){

        if (Session::has('academia')) {
            Session::forget('academia'); 
        }

        if (Session::has('estudio')) {
            Session::forget('estudio'); 
        }

        if (Session::has('niveles')) {
            Session::forget('niveles'); 
        }
        
        $academia = Academia::find(Auth::user()->academia_id);
        $estudios = ConfigEstudios::where('academia_id' , Auth::user()->academia_id)->get();
        $niveles = ConfigNiveles::where('academia_id' , Auth::user()->academia_id)->get();

        if($academia){
        //Simple Marker
        $config['center'] = '10.6913156,-71.6800493';
        $config['zoom'] = 14;
        \Gmaps::initialize($config);

        $marker = array();
        $marker['position'] = '10.6913156,-71.6800493';
        $marker['draggable'] = true;
        $marker['ondragend'] = 'addFieldText(event.latLng.lat(), event.latLng.lng());';
        \Gmaps::add_marker($marker);

        $map = \Gmaps::create_map();

        if($academia->correo)
        {

            return view('configuracion.academia.planilla',['academia'=>$academia], compact('map'))->with(['id' => Auth::user()->academia_id, 'niveles' => $niveles, 'estudios' => $estudios]);
 
        }

        else{

            return view('configuracion.academia.configuracion' , compact('map'))->with(['academia' => $academia , 'especialidades' => ConfigEspecialidades::all(), 'estudios' => $estudios, 'niveles' => $niveles]);
        }

        //Devolver vista con datos del mapa
        

        }else{
           return redirect("/"); 
        }
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */

    public function error(){
        return view('errors.error_sistema');
    }

    public function store(Request $request)
    {

        $request->merge(array('correo' => trim($request->correo)));

        $rules = [
            'correo' => 'required|email|max:255|unique:academias,correo',
            // 'telefono' => 'required',
            'celular' => 'required',
            'numero_factura' => 'numeric',
        ];


        $messages = [

            'correo.required' => 'Ups! El correo es requerido',
            'correo.email' => 'Ups! El correo tiene una dirección inválida',
            'correo.max' => 'El máximo de caracteres permitidos son 255',
            'correo.unique' => 'Ups! Ya este correo ha sido registrado',
            'telefono.required' => 'Ups! El Teléfono Local es requerido',
            'celular.required' => 'Ups! El Teléfono Móvil es requerido',
            'numero_factura.numeric' => 'Ups! El campo de “ Próximo número de factura ” es inválido, debe contener sólo  números',
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
    

            $academia = Academia::find(Auth::user()->academia_id);

            // $arreglo = Session::get('academia');

            // $correo = $arreglo[0]['correo'];
            // $telefono = $arreglo[0]['telefono'];
            // $celular = $arreglo[0]['celular'];
            // $direccion = $arreglo[0]['direccion'];
            // $facebook = $arreglo[0]['facebook'];
            // $twitter = $arreglo[0]['twitter'];
            // $linkedin = $arreglo[0]['linkedin'];
            // $instagram = $arreglo[0]['instagram'];
            // $pagina_web = $arreglo[0]['pagina_web'];
            // $youtube = $arreglo[0]['youtube'];
            // $normativa = $arreglo[0]['normativa'];
            // $manual = $arreglo[0]['manual'];
            // $programacion = $arreglo[0]['programacion'];
            // $numero_factura = $arreglo[0]['numero_factura'];
            // $incluye_iva = $arreglo[0]['incluye_iva'];

            if($request->link_video){

            $parts = parse_url($request->link_video);

            if(isset($parts['host']))
            {
                if($parts['host'] == "www.youtube.com" || $parts['host'] == "www.youtu.be"){

                
                }else{
                    return response()->json(['errores' => ['link_video' => [0, 'Ups! ha ocurrido un error, debes ingresar un enlace de YouTube']], 'status' => 'ERROR'],422);
                }
            }else{
                    return response()->json(['errores' => ['link_video' => [0, 'Ups! ha ocurrido un error, debes ingresar un enlace de YouTube']], 'status' => 'ERROR'],422);
                }
            
            }

            if($request->numero_factura){
                $numero_factura = $request->numero_factura;
            }
            else{
                $numero_factura = 1;
            }

            $correo = strtolower($request->correo);

            $direccion = title_case($request->direccion);

            $academia->correo = $correo;
            $academia->telefono = $request->telefono;
            $academia->celular = $request->celular;
            $academia->direccion = $direccion;
            $academia->facebook = $request->facebook;
            $academia->twitter = $request->twitter;
            $academia->linkedin = $request->linkedin;
            $academia->instagram = $request->instagram;
            $academia->pagina_web = $request->pagina_web;
            $academia->youtube = $request->youtube;
            $academia->link_video = $request->link_video;
            $academia->normativa = $request->normativa;
            $academia->manual = $request->manual;
            $academia->numero_factura = $numero_factura;
            $academia->incluye_iva = $request->incluye_iva;
            
            if($academia->save()){

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

                    $nombre_img = "academia-". $academia->id . $extension;
                    $image = base64_decode($base64_string);

                    // \Storage::disk('academia')->put($nombre_img,  $image);
                    $img = Image::make($image)->resize(640, 480);
                    $img->save('assets/uploads/academia/'.$nombre_img);

                    $academia->imagen = $nombre_img;
                    $academia->save();

                }


                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function PrimerPaso(Request $request)
    {
        //dd($request->all());


    $rules = [
        'nombre' => 'required|min:3|max:60',
        'identificacion' => 'min:6|max:20',
        'especialidades_id' => 'required',
        'pais_id' => 'required',
        'estado' => 'required|min:3|max:40',
    ];

    $messages = [

        'nombre.required' => 'Ups! El campo Nombre es requerido',
        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre.max' => 'El maximo de caracteres permitidos son 60',
        'indentificacion.min' => 'El mínimo de caracteres permitidos son 6',
        'indentificacion.max' => 'El maximo de caracteres permitidos son 20',
        'especialidades_id.required' => 'Ups! La Especialidad es requerida',
        'pais_id.required' => 'Ups! El Pais es requerido',
        'estado.required' => 'Ups! El Estado es requerido',
        'estado.min' => 'El mínimo de caracteres permitidos son 3',
        'estado.max' => 'El máximo de caracteres permitidos son 40',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $academia = Academia::find(Auth::user()->academia_id);

        $pais = Paises::find($request->pais_id);

        $porcentaje_impuesto = Impuesto::where('pais_id' , '=', $request->pais_id)->first();

        $nombre = title_case($request->nombre);

        $academia->nombre = $nombre;
        $academia->identificacion = $request->identificacion;
        $academia->especialidades_id = $request->especialidades_id;
        $academia->pais_id = $request->pais_id;
        $academia->estado = $request->estado;
        $academia->moneda = $pais->moneda;
        $academia->porcentaje_impuesto = $porcentaje_impuesto->impuesto;

        if($academia->save()){
            // return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("/home");
        //return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }
    }

	public function SegundoPaso(Request $request)
	{
		//dd($request->all());

    $rules = [
    	'identificacion' => 'required|min:8|max:20|unique:academias,identificacion',
        'imagen' => 'required',
        'descripcion' => 'required|min:3|max:300',
    ];

    $messages = [

        'identificacion.required' => 'Ups! El campo RIF es requerido',
        'identificacion.min' => 'El mínimo de caracteres permitidos son 8',
        'identificacion.max' => 'El maximo de caracteres permitidos son 20',
        'identificacion.unique' => 'Ups! Ya el campo RIF esta registrado, intente con otra identidad fiscal.',
        'imagen.required' => 'Ups! La imagen es requerida',
        'descripcion.required' => 'Ups! La Descripcion es requerida',
        'descripcion.min' => 'El mínimo de caracteres permitidos son 3',
        'descripcion.max' => 'El máximo de caracteres permitidos son 300',
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

        $academia = Academia::find($request->academia_id);

		$academia->identificacion = $request->identificacion;
		$academia->imagen = $request->imagen;
		$academia->descripcion = $request->descripcion;

		if($academia->save()){
            // return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
            return view('academia.contacto')->with('academia', $academia);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
	}
	}

	public function storeContacto(Request $request){

    $request->merge(array('correo' => trim($request->correo)));

    $rules = [
        'correo' => 'required|email|max:255|unique:academias,correo',
        // 'telefono' => 'required',
        'celular' => 'required',
    ];

    $messages = [

        'correo.required' => 'Ups! El correo es requerido',
        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'correo.max' => 'El máximo de caracteres permitidos son 255',
        'correo.unique' => 'Ups! Ya este correo ha sido registrado',
        'telefono.required' => 'Ups! El Teléfono Local es requerido',
        'celular.required' => 'Ups! El Teléfono Móvil es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
    }

    else{

        $array = array(['correo' => $request->correo , 'telefono' => $request->telefono , 'celular' => $request->celular, 'direccion' => $request->direccion, 'facebook' => $request->facebook, 'twitter' => $request->twitter, 'linkedin' => $request->linkedin, 'instagram' => $request->instagram, 'pagina_web' => $request->pagina_web, 'youtube' => $request->youtube]);

            Session::put('academia', $array);

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

            }
		}

	public function storeEspeciales(Request $request){

        // dd($request->all());

        $arreglo = Session::get('academia');

        $correo = $arreglo[0]['correo'];
        $telefono = $arreglo[0]['telefono'];
        $celular = $arreglo[0]['celular'];
        $direccion = $arreglo[0]['direccion'];
        $facebook = $arreglo[0]['facebook'];
        $twitter = $arreglo[0]['twitter'];
        $linkedin = $arreglo[0]['linkedin'];
        $instagram = $arreglo[0]['instagram'];
        $pagina_web = $arreglo[0]['pagina_web'];
        $youtube = $arreglo[0]['youtube'];

        $array = array(['correo' => $correo , 'telefono' => $telefono , 'celular' => $celular, 'direccion' => $direccion, 'facebook' => $facebook, 'twitter' => $twitter, 'linkedin' => $linkedin, 'instagram' => $instagram, 'pagina_web' => $pagina_web, 'youtube' => $youtube, 'normativa' => $request->normativa , 'manual' => $request->manual , 'programacion' => $request->programacion]);

        Session::put('academia', $array);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);


	}

    public function storeAdministrativo(Request $request){

        // dd($request->all());

    $rules = [

        'numero_factura' => 'numeric',

    ];

    $messages = [
        
        'porcentaje_retraso.numeric' => 'Ups! El campo de “ Porcentaje de retraso de pago ” es inválido , debe contener sólo números',
        'numero_factura.numeric' => 'Ups! El campo de “ Próximo número de factura ” es inválido, debe contener sólo  números',
        'tiempo_tolerancia.numeric' => 'Ups! El campo de “ Tiempo de Tolerancia ” es inválido, debe contener sólo  números',

    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $arreglo = Session::get('academia');

        $correo = $arreglo[0]['correo'];
        $telefono = $arreglo[0]['telefono'];
        $celular = $arreglo[0]['celular'];
        $direccion = $arreglo[0]['direccion'];
        $facebook = $arreglo[0]['facebook'];
        $twitter = $arreglo[0]['twitter'];
        $linkedin = $arreglo[0]['linkedin'];
        $instagram = $arreglo[0]['instagram'];
        $pagina_web = $arreglo[0]['pagina_web'];
        $youtube = $arreglo[0]['youtube'];
        $normativa = $arreglo[0]['normativa'];
        $manual = $arreglo[0]['manual'];
        $programacion = $arreglo[0]['programacion'];

        $array = array(['correo' => $correo , 'telefono' => $telefono , 'celular' => $celular, 'direccion' => $direccion, 'facebook' => $facebook, 'twitter' => $twitter, 'linkedin' => $linkedin, 'instagram' => $instagram, 'pagina_web' => $pagina_web, 'youtube' => $youtube, 'normativa' => $normativa , 'manual' => $manual , 'programacion' => $programacion,  'numero_factura' => $request->numero_factura , 'incluye_iva' => $request->incluye_iva]);

        Session::put('academia', $array);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

        // $academia = Academia::find($request->academia_id);

        // $academia->porcentaje_impuesto = $request->porcentaje_impuesto;
        // $academia->numero_factura = $request->numero_factura;

        
        // if($academia->save()){
        //     // return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        //     return view('alumno.index')->with('academia', $academia);
        // }else{
        //     return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        // }
        // return redirect("alumno/edit/{$request->id}");
        }
    }

    public function agregarestudio(Request $request){
        
    $rules = [

        'nombre_estudio' => 'required',
        'cantidad_estudio' => 'required|numeric|min:1',
    ];

    $messages = [

        'nombre_estudio.required' => 'Ups! El Nombre es requerido',
        'cantidad_estudio.required' => 'Ups! El Cantidad es invalida, solo se aceptan numeros',
        'cantidad_estudio.numeric' => 'Ups! La Cantidad es requerida',
        'cantidad_estudio.min' => 'El mínimo de cantidad permitida es 1',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $nombre = title_case($request->nombre_estudio);
        
        $array = array(['nombre' => $nombre , 'cantidad' => $request->cantidad_estudio]);

        // Session::push('estudio', $array);

        // $contador = count(Session::get('estudio'));
        // $contador = $contador - 1;
        // 
        $estudio = new ConfigEstudios;
                                        
        $estudio->academia_id = Auth::user()->academia_id;
        $estudio->nombre = $nombre;
        $estudio->capacidad = $request->cantidad_estudio;

        $estudio->save();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $estudio, 'id' => $estudio->id, 200]);

        }
    }

    public function agregarnivel(Request $request){
        
    $rules = [

        'nombre_nivel' => 'required',
    ];

    $messages = [

        'nombre_nivel.required' => 'Ups! El Nombre es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $nombre = title_case($request->nombre_nivel);

        // $array = array(['nombre' => $nombre]);

        // Session::push('niveles', $array);

        // $contador = count(Session::get('niveles'));
        // $contador = $contador - 1;
        // 
        
        $nivel = new ConfigNiveles;
                                        
        $nivel->academia_id = Auth::user()->academia_id;
        $nivel->nombre = $nombre;

        $nivel->save();

         return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $nivel, 'id' => $nivel->id, 200]);

        }
    }

    public function eliminarestudio($id){

        // $arreglo = Session::get('estudio');

        // unset($arreglo[$id]);
        // Session::put('estudio', $arreglo);
        // 
        $estudio = ConfigEstudios::find($id);

        $estudio->delete();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function eliminarniveles($id){

        // $arreglo = Session::get('niveles');

        // unset($arreglo[$id]);
        // Session::put('niveles', $arreglo);
        // 
        
        $nivel = ConfigNiveles::find($id);

        $nivel->delete();


        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
    {   
        $academia = Academia::find($id);
        if($academia){
            
            $config['center'] = '10.6913156,-71.6800493';
            $config['zoom'] = 14;
            \Gmaps::initialize($config);

            $marker = array();
            $marker['position'] = '10.6913156,-71.6800493';
            $marker['draggable'] = true;
            $marker['ondragend'] = 'addFieldText(event.latLng.lat(), event.latLng.lng());';
            \Gmaps::add_marker($marker);

            $map = \Gmaps::create_map();

           return view('configuracion.academia.planilla',['academia'=>$academia], compact('map'));
        }else{
           return redirect("/"); 
        }
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */

    public function updateContacto(Request $request){

    $rules = [
        'correo' => 'required|email|max:255|unique:academias,correo, '.$request->id.'',
        'celular' => 'required',
    ];

    $messages = [
        'correo.required' => 'Ups! El correo es requerido',
        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'correo.max' => 'El máximo de caracteres permitidos son 255',
        'correo.unique' => 'Ups! Ya este correo ha sido registrado',
        'celular.required' => 'Ups! El Teléfono Móvil es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        // return redirect("alumno/edit/{$request->id}")

        // ->withErrors($validator)
        // ->withInput();

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }

    else{

        $direccion = title_case($request->direccion);

        $correo = strtolower($request->correo);

        $academia = Academia::find(Auth::user()->academia_id);
        $academia->correo = $correo;
        $academia->telefono = $request->telefono;
        $academia->celular = $request->celular;
        $academia->direccion = $direccion;

        if($academia->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function updateImagen(Request $request)
    {       
            
            //dd($request->all());
            if($request->imageBase64){
                    $base64_string = substr($request->imageBase64, strpos($request->imageBase64, ",")+1);
                    $path = storage_path();
                    $split = explode( ';', $request->imageBase64 );
                    $type =  explode( '/',  $split[0]);

                    $ext = $type[1];
                    
                    if($ext == 'jpeg' || 'jpg'){
                        $extension = '.jpg';
                    }elseif($ext == 'png'){
                        $extension = '.png';
                    }

                    $nombre_img = "academia-". Auth::user()->academia_id . $extension;
                    $image = base64_decode($base64_string);

                    // \Storage::disk('academia')->put($nombre_img,  $image);

                    $img = Image::make($image)->resize(640, 480);
                    $img->save('assets/uploads/academia/'.$nombre_img);

                }else{
                    $nombre_img = "";
                }

                $academia = Academia::find(Auth::user()->academia_id);

                $academia->imagen = $nombre_img;
                $academia->save();

                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
    }

    public function updateRedes(Request $request){

        if($request->link_video){

            $parts = parse_url($request->link_video);

            if(isset($parts['host']))
            {
                if($parts['host'] == "www.youtube.com" || $parts['host'] == "www.youtu.be"){

                
                }else{
                    return response()->json(['errores' => ['link_video' => [0, 'Ups! ha ocurrido un error, debes ingresar un enlace de YouTube']], 'status' => 'ERROR'],422);
                }
            }else{
                    return response()->json(['errores' => ['link_video' => [0, 'Ups! ha ocurrido un error, debes ingresar un enlace de YouTube']], 'status' => 'ERROR'],422);
                }
            
            }

        $academia = Academia::find(Auth::user()->academia_id);
        $academia->facebook = $request->facebook;
        $academia->twitter = $request->twitter;
        $academia->instagram = $request->instagram;
        $academia->pagina_web = $request->pagina_web;
        $academia->linkedin = $request->linkedin;
        $academia->youtube = $request->youtube;
        $academia->link_video = $request->link_video;
        
        if($academia->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

        public function updateEspeciales(Request $request){

        //dd($request->all());

        $academia = Academia::find(Auth::user()->academia_id);
        $academia->normativa = $request->normativa;
        $academia->manual = $request->manual;

        if($request->programacion){

            $extension = $request->programacion->getClientOriginalExtension();
            $nombre_archivo = 'programacion-'.Auth::user()->academia_id.'.'.$extension;

            \Storage::disk('programacion')->put($nombre_archivo,  \File::get($request->programacion));

            $academia->programacion = $nombre_archivo;
        }
        
        if($academia->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateAdministrativo(Request $request){

        $academia = Academia::find(Auth::user()->academia_id);
        $academia->incluye_iva = $request->incluye_iva;
        
        if($academia->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }



    /**
      * PAGOS RECURRENTES o MENSUALIDADES
      * Var $tipo => Tipo de Accion,
      *     $result => Arreglo donde se guarda
                       la respuesta a mostrar, podria
                       no usuarse mas adelante.
      *     $cantidad => Valor Cantidad de la Base de Datos,
                         en este caso sera una constante.
      *     $ConfigClasesGrupales => consulta al modelo de Configuracion
                                    de clases grupales para obtener los
                                    datos de la clase
            $InscripcionClaseGrupal => Consulta al modelo de Inscripcion de
                                    de clase grupales para verificar si hay
                                    alumnos inscritos, para luego cargarles
                                    una deuda en caso de tenerla
            $FacturaProforma => Consulta al modelo de detalles de
                                Proforma para verificar si hay deuda para
                                no cargarle una misma deuda mas de una vez           
      */
    public function pagorecurrente()
    {
        $result = array();
        $tipo = 4;
        $cantidad = 1;
        $id = 0;
        $academia = Academia::find(Auth::user()->academia_id);
        $academia->fecha_comprobacion = Carbon::now()->toDateString();
        $academia->save();

        $ConfigClasesGrupales = ConfigClasesGrupales::select('config_clases_grupales.id',
                'config_clases_grupales.nombre','config_clases_grupales.costo_inscripcion',
                'config_clases_grupales.costo_mensualidad', 'clases_grupales.id',
                'clases_grupales.fecha_inicio', 'clases_grupales.fecha_final',
                'clases_grupales.fecha_inicio_preferencial', 'clases_grupales.id as clase_grupal_id')
                ->join('clases_grupales', 'clases_grupales.clase_grupal_id','=','config_clases_grupales.id')
                ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
                ->where('clases_grupales.deleted_at', '=', null)
                ->where('clases_grupales.fecha_final', '>', Carbon::now()->format("Y-m-d"))
                ->get();

        $InscripcionClaseGrupal = InscripcionClaseGrupal::select('inscripcion_clase_grupal.clase_grupal_id AS ClaseGrupalID', 
            'inscripcion_clase_grupal.alumno_id AS AlumnoId',
            'inscripcion_clase_grupal.fecha_pago', 
            'alumnos.identificacion AS Identificacion', 'alumnos.nombre AS NombreAlumno', 
            'alumnos.apellido AS ApellidoAlumno', 'alumnos.telefono AS TelefonoAlumno', 
            'alumnos.celular as CelularAlumno','config_clases_grupales.nombre AS ClaseNombre', 'inscripcion_clase_grupal.id as InscripcionID', 'inscripcion_clase_grupal.costo_mensualidad AS Costo')
                ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id','=',
                       'clases_grupales.id')
                ->join('alumnos', 'inscripcion_clase_grupal.alumno_id','=','alumnos.id')
                ->join('config_clases_grupales', 'config_clases_grupales.id','=',
                       'clases_grupales.clase_grupal_id')
                ->where('inscripcion_clase_grupal.deleted_at', '=', null)
                ->get();
        
            //Desgloso la Fecha Preferencial
                foreach ($InscripcionClaseGrupal as $InscripcionClase ) {

                    $fecha_cuota_explode=explode('-', $InscripcionClase->fecha_pago);

                            foreach ($ConfigClasesGrupales as $configClases) {

                                $fecha_inicio_preferencial = Carbon::createFromFormat('Y-m-d', $configClases->fecha_inicio_preferencial);

                                if ($fecha_inicio_preferencial <= Carbon::now()){

                                    $fecha_inicio_preferencial = $fecha_inicio_preferencial->addMonth()->toDateString();

                                    $clase_grupal = ClaseGrupal::find($configClases->clase_grupal_id);
                                    $clase_grupal->fecha_inicio_preferencial = $fecha_inicio_preferencial;
                                    $clase_grupal->save();

                                }

                                $fecha_pago = Carbon::createFromFormat('Y-m-d', $InscripcionClase->fecha_pago);

                                if ($fecha_pago <= Carbon::now()){

                                    if($configClases->id == $InscripcionClase->ClaseGrupalID){

                                        $FacturaProforma = ItemsFacturaProforma::select(
                                        'items_factura_proforma.tipo', 
                                        'items_factura_proforma.alumno_id')
                                        ->where('items_factura_proforma.tipo','=',$tipo)
                                        ->where('items_factura_proforma.alumno_id', '=', $InscripcionClase->AlumnoId)
                                        ->where('items_factura_proforma.item_id', '=', $configClases->clase_grupal_id)
                                        ->get()->count();

                                        /** AQUI CONVERTIMOS LA FECHA PREFERENCIAL PARA PODER
                                            OBTENER LA FECHA LIMITE DE PAGO **/
                                        $fecha_cuota = Carbon::create($fecha_cuota_explode[0], $fecha_cuota_explode[1], $fecha_cuota_explode[2],0);

                                        /** AQUI CALCULAMOS LA FECHA FECHA LIMITE DE PAGO **/
                                        $tolerancia = $fecha_cuota->addDay($configClases->tiempo_tolerancia)->toDateString();
                                        
                                        if($FacturaProforma == 0 AND $InscripcionClase->Costo > 0){

                                            $fecha_final = Carbon::createFromFormat('Y-m-d', $configClases->fecha_final);

                                            if($fecha_final > Carbon::now()){
                                                
                                                $fecha_cuota = $fecha_cuota->addMonth()->toDateString();
                                                
                                                $clasegrupal = InscripcionClaseGrupal::find($InscripcionClase->InscripcionID);

                                                $clasegrupal->fecha_pago = $fecha_cuota;
                                                $clasegrupal->save();

                                                $item_factura = new ItemsFacturaProforma;
                                                
                                                $item_factura->alumno_id = $InscripcionClase->AlumnoId;
                                                $item_factura->academia_id = Auth::user()->academia_id;
                                                $item_factura->fecha = Carbon::now()->toDateString();
                                                $item_factura->item_id = $configClases->id;
                                                $item_factura->nombre = 'Cuota ' . $configClases->nombre;
                                                $item_factura->tipo = $tipo;
                                                $item_factura->cantidad = $cantidad;
                                                $item_factura->importe_neto = $InscripcionClase->Costo;
                                                $item_factura->fecha_vencimiento = Carbon::now()->toDateString();

                                                $item_factura->save();

                                            }

                                            }else{
                                                $result[] = array(
                                                    'mensaje' => 'Ya hay Deuda Asignada para la Clase '.$configClases->nombre,
                                                    'alumno' => $InscripcionClase->NombreAlumno.' '.$InscripcionClase->ApellidoAlumno,
                                                    );
                                            }
                                            

                            //                 $result[] = array(
                            //                     'mensaje' => 'Fecha Limite de Pago, se le cargara un porcentaje adicional a su factura',
                            //                     'alumno' => $InscripcionClase->NombreAlumno.' '.$InscripcionClase->ApellidoAlumno,
                            //                     'monto' => $configClases->costo_mensualidad,
                            //                     'mora' => $mora,

                            // );
                        }
                                     
                   
                }    

                // $result[] = array(
                //     'id' => $configClases->id,
                //     'mensaje' => 'La Clase Grupal '.$configClases->nombre.' tiene deuda',
                //     'fecha_de_pago' => $configClases->fecha_inicio_preferencial,
                //     'monto' => $configClases->costo_mensualidad,  );
            }
                // else{
            //     $result[] = array(
            //         'id' => $configClases->id,
            //         'mensaje' => 'La Clase Grupal '.$configClases->nombre.' no tiene deuda',
            //         'fecha_de_pago' => $configClases->fecha_inicio_preferencial,
            //         'monto' => $configClases->costo_mensualidad,  );
            // }
            // $result;
        }

        return $this->tiempotolerancia();
        


    }

    public function tiempotolerancia(){

        $academia = Academia::find(Auth::user()->academia_id);
        $contador_clase = 0;
        $contador_taller = 0;
        $contador_fiesta = 0;
        $contador_campana = 0;

        $tipo = 8;

        $ConfigClasesGrupales = ConfigClasesGrupales::select('config_clases_grupales.id',
                'config_clases_grupales.nombre','config_clases_grupales.costo_inscripcion',
                'config_clases_grupales.costo_mensualidad', 'clases_grupales.id',
                'clases_grupales.fecha_inicio', 'clases_grupales.fecha_final',
                'clases_grupales.fecha_inicio_preferencial', 'config_clases_grupales.tiempo_tolerancia', 'config_clases_grupales.porcentaje_retraso')
                        ->join('clases_grupales', 'clases_grupales.clase_grupal_id','=','config_clases_grupales.id')
                        ->get();

        $InscripcionClaseGrupal = InscripcionClaseGrupal::select('inscripcion_clase_grupal.clase_grupal_id AS ClaseGrupalID', 
            'inscripcion_clase_grupal.alumno_id AS AlumnoId',
            'inscripcion_clase_grupal.fecha_pago', 
            'alumnos.identificacion AS Identificacion', 'alumnos.nombre AS NombreAlumno', 
            'alumnos.apellido AS ApellidoAlumno', 'alumnos.telefono AS TelefonoAlumno', 
            'alumnos.celular as CelularAlumno','config_clases_grupales.nombre AS ClaseNombre', 'inscripcion_clase_grupal.id as InscripcionID', 'inscripcion_clase_grupal.costo_mensualidad AS Costo')
                ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id','=',
                       'clases_grupales.id')
                ->join('alumnos', 'inscripcion_clase_grupal.alumno_id','=','alumnos.id')
                ->join('config_clases_grupales', 'config_clases_grupales.id','=',
                       'clases_grupales.clase_grupal_id')
                ->get();
        
        
            //Desgloso la Fecha Preferencial
                foreach ($InscripcionClaseGrupal as $InscripcionClase ) {

                            foreach ($ConfigClasesGrupales as $configClases) {

                                    if($configClases->id == $InscripcionClase->ClaseGrupalID){

                                        $FacturaProforma = ItemsFacturaProforma::select(
                                        'items_factura_proforma.tipo', 
                                        'items_factura_proforma.alumno_id')
                                        ->where('items_factura_proforma.tipo','=',$tipo)
                                        ->where('items_factura_proforma.alumno_id', '=', $InscripcionClase->AlumnoId)
                                        ->get()->count();

                                        /** AQUI CONVERTIMOS LA FECHA PREFERENCIAL PARA PODER
                                            OBTENER LA FECHA LIMITE DE PAGO **/

                                        $fecha_cuota_explode=explode('-', $InscripcionClase->fecha_pago);
                                        $fecha_cuota = Carbon::create($fecha_cuota_explode[0], $fecha_cuota_explode[1], $fecha_cuota_explode[2],0);

                                        /** AQUI CALCULAMOS LA FECHA FECHA LIMITE DE PAGO **/
                                        $tolerancia = $fecha_cuota->addDay($configClases->tiempo_tolerancia)->toDateString();
                                        
                                            //CONDICION PARA EL TIEMPO DE TOLERANCIA, SI SE CUMPLE
                                            //CALCULARA SEGUN EL PORCENTAJE CONFIGURADO Y SE LE SUMARA
                                            //AL MONTO DE LA CUOTA
                                        $clasegrupal = InscripcionClaseGrupal::find($InscripcionClase->InscripcionID);

                                            
                                           if($FacturaProforma != 0 && Carbon::now()->format('Y-m-d') > $tolerancia && $clasegrupal->tiene_mora == 0){

                                                $mora = ($configClases->costo_mensualidad * $configClases->porcentaje_retraso)/100;

                                                $item_factura = new ItemsFacturaProforma;
                                                                            
                                                $item_factura->alumno_id = $InscripcionClase->AlumnoId;
                                                $item_factura->academia_id = Auth::user()->academia_id;
                                                $item_factura->fecha = Carbon::now()->toDateString();
                                                                                //$item_factura->item_id = $id;
                                                $item_factura->nombre = 'Retraso de pago ' .  $configClases->nombre;
                                                $item_factura->tipo = 8;
                                                $item_factura->cantidad = 1;
                                                                                // $item_factura->precio_neto = $configClases->costo_mensualidad;
                                                                                //$item_factura->impuesto = $impuesto;
                                                $item_factura->importe_neto = $mora;
                                                $item_factura->fecha_vencimiento = Carbon::now()->toDateString();

                                                $item_factura->save();

                                                $clasegrupal->tiene_mora = 1;
                                                $clasegrupal->save();

                                            }
                                        }
                                    }
                                }

                                if(Auth::user()->usuario_tipo == 1 || Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6){

                                    return view('inicio.index')->with(['paises' => Paises::all() , 'especialidades' => ConfigEspecialidades::all(), 'academia' => $academia]); 
                                }
                                else{

                                    $array=array();

                                    $clase_grupal_join = DB::table('clases_grupales')
                                        ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                                        ->select('config_clases_grupales.nombre','clases_grupales.id', 'config_clases_grupales.descripcion', 'clases_grupales.imagen', 'clases_grupales.created_at', 'clases_grupales.fecha_inicio', 'clases_grupales.dias_prorroga')
                                        ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
                                        ->where('clases_grupales.deleted_at', '=', null)
                                        ->where('clases_grupales.boolean_promocionar','=', 1)
                                    ->get();

                                    foreach($clase_grupal_join as $clase){

                                        $fecha = Carbon::createFromFormat('Y-m-d', $clase->fecha_inicio);
                                        $fecha->addDays($clase->dias_prorroga);

                                        if($fecha >= Carbon::now()){

                                            if($clase->imagen){
                                                $imagen = "/assets/uploads/clase_grupal/{$clase->imagen}";
                                            }else{
                                                $imagen = '';
                                            }

                                            $array[]=array('nombre' => $clase->nombre , 'descripcion' => $clase->descripcion ,'imagen' => $imagen , 'url' => "/agendar/clases-grupales/progreso/{$clase->id}", 'facebook' => "/agendar/clases-grupales/progreso/{$clase->id}", 'twitter' => "Participa en la clase grupal {$clase->nombre} te invita @EasyDanceLatino", 'twitter_url' => "/agendar/clases-grupales/progreso/{$clase->id}", 'creacion' => $clase->created_at);


                                            $contador_clase = $contador_clase + 1;
                                        }

                                    }

                                    $talleres = Taller::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

                                    foreach($talleres as $taller){

                                        $fecha = Carbon::createFromFormat('Y-m-d', $taller->fecha_inicio);

                                        if($fecha >= Carbon::now()){

                                            if($taller->imagen){
                                                $imagen = "/assets/uploads/taller/{$taller->imagen}";
                                            }else{
                                                $imagen = '';
                                            }

                                            $array[]=array('nombre' => $taller->nombre , 'descripcion' => $taller->descripcion ,'imagen' => $imagen , 'url' => "/agendar/talleres/progreso/{$taller->id}", 'facebook' => "/agendar/talleres/progreso/{$taller->id}", 'twitter' => "Participa en el taller {$taller->nombre} te invita @EasyDanceLatino", 'twitter_url' => "/agendar/talleres/progreso/{$taller->id}" , 'creacion' => $taller->created_at);

                                            $contador_taller = $contador_taller + 1;
                                        }

                                    }

                                    $fiestas = Fiesta::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

                                    foreach($fiestas as $fiesta){

                                        $fecha = Carbon::createFromFormat('Y-m-d', $fiesta->fecha_inicio);

                                        if($fecha >= Carbon::now()){

                                            if($fiesta->imagen){
                                                $imagen = "/assets/uploads/fiesta/{$fiesta->imagen}";
                                            }else{
                                                $imagen = '';
                                            }

                                            $array[]=array('nombre' => $fiesta->nombre , 'descripcion' => $fiesta->descripcion ,'imagen' => $imagen , 'url' => "/agendar/fiestas/progreso/{$fiesta->id}", 'facebook' => "/agendar/fiesta/progreso/{$fiesta->id}", 'twitter' => "Participa en la fiesta {$fiesta->nombre} te invita @EasyDanceLatino", 'twitter_url' => "/agendar/fiestas/progreso/{$fiesta->id}", 'creacion' => $fiesta->created_at);

                                            $contador_fiesta = $contador_fiesta + 1;
                                        }

                                    }

                                    $campanas = Campana::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

                                    foreach($campanas as $campana){

                                        $fecha = Carbon::createFromFormat('Y-m-d', $campana->fecha_inicio);

                                        if($fecha >= Carbon::now()){

                                            $contador_campana = $contador_campana + 1;
                                        }

                                    }

                                    $collection = collect($array);

                                    $sorted = $collection->sortByDesc('creacion');

                                    $i = 0;

                                    $arreglo=array();

                                    foreach($sorted as $tmp){

                                        $arreglo[$i] = $tmp;
                                        $i = $i + 1;

                                    }

                                    $perfil = PerfilEvaluativo::where('usuario_id', Auth::user()->usuario_id)->first();
                                    $instructor_contador = Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->where('instructores.boolean_promocionar', 1)->count();
                                    $clase_personalizada_contador = ClasePersonalizada::where('academia_id', '=' ,  Auth::user()->academia_id)->count();

                                    if($perfil){
                                        $tiene_perfil = 1;
                                    }else{
                                        $tiene_perfil = 0;
                                    }

                                    $array_deuda = array();

                                    $proformas = ItemsFacturaProforma::where('alumno_id', '=' ,  Auth::user()->usuario_id)->get();

                                    foreach($proformas as $proforma){

                                        $fecha = Carbon::createFromFormat('Y-m-d', $proforma->fecha_vencimiento);

                                        if($fecha > Carbon::now()){

                                            $array_deuda[]=array('nombre' => $proforma->nombre , 'fecha_vencimiento' => $proforma->fecha_vencimiento ,'monto' => $proforma->importe_neto);

                                        }

                                    }

                                    if (Session::has('fecha_sesion')) {                
               
                                    }else{
                                       $fecha_sesion=Carbon::now();
                                       Session::put('fecha_sesion',$fecha_sesion);
                                    }


                                    return view('vista_alumno.index')->with(['academia' => $academia, 'enlaces' => $arreglo , 'clases_grupales' => $contador_clase, 'talleres' => $contador_taller , 'fiestas' =>  $contador_fiesta ,'campanas' => $contador_campana ,'regalos' => Regalo::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'perfil' => $tiene_perfil, 'instructor_contador' => $instructor_contador, 'clase_personalizada_contador' => $clase_personalizada_contador, 'proformas' => $array_deuda]); 
                                   
                                }
    }

}
