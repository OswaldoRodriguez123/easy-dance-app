<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Taller;
use App\HorarioTaller;
use App\Visitante;
use App\Participante;
use App\Alumno;
use App\Academia;
use App\ConfigEstudios;
use App\ConfigEspecialidades;
use App\ConfigServicios;
use App\ConfigNiveles;
use App\Instructor;
use App\DiasDeSemana;
use App\InscripcionTaller;
use App\ItemsFacturaProforma;
use App\Egreso;
use App\ConfigEgreso;
use App\Reservacion;
use App\User;
use App\Notificacion;
use App\NotificacionUsuario;
use Validator;
use DB;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;
use Image;

class TallerController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */


    public function index(){

        $talleres = Taller::join('config_especialidades', 'talleres.especialidad_id', '=', 'config_especialidades.id')
            ->leftJoin('instructores', 'talleres.instructor_id', '=', 'instructores.id')
            ->select('talleres.*','config_especialidades.nombre as especialidad', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido')
            ->where('talleres.academia_id', '=' ,  Auth::user()->academia_id)
        ->get();

        $horarios_talleres = HorarioTaller::join('talleres', 'horarios_talleres.taller_id', '=', 'talleres.id')
            ->join('config_especialidades', 'horarios_talleres.especialidad_id', '=', 'config_especialidades.id')
            ->leftJoin('instructores', 'horarios_talleres.instructor_id', '=', 'instructores.id')
            ->select('horarios_talleres.*', 'talleres.id', 'talleres.costo', 'talleres.nombre', 'horarios_talleres.fecha as fecha_inicio', 'config_especialidades.nombre as especialidad', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido')
            ->where('talleres.academia_id', '=' ,  Auth::user()->academia_id)
        ->get();

        $array = array();

        $academia = Academia::find(Auth::user()->academia_id);
        $usuario_tipo = Session::get('easydance_usuario_tipo');

        if($usuario_tipo == 1 OR $usuario_tipo == 3 OR $usuario_tipo == 5 || $usuario_tipo == 6){

            foreach($talleres as $taller){

                $fecha = Carbon::createFromFormat('Y-m-d', $taller->fecha_inicio);
                $i = $fecha->dayOfWeek;

                if($i == 1){

                  $dia = 'Lunes';

                }else if($i == 2){

                  $dia = 'Martes';

                }else if($i == 3){

                  $dia = 'Miercoles';

                }else if($i == 4){

                  $dia = 'Jueves';

                }else if($i == 5){

                  $dia = 'Viernes';

                }else if($i == 6){

                  $dia = 'Sabado';

                }else if($i == 0){

                  $dia = 'Domingo';

                }
                
                $cantidad_participantes = InscripcionTaller::where('taller_id',$taller->id)->count();

                $fecha = Carbon::createFromFormat('Y-m-d', $taller->fecha_inicio);
                if($fecha >= Carbon::now()){

                    $dias_restantes = $fecha->diffInDays();
                    $status = 'Activa';

                }else{
                    $dias_restantes = 0;
                    $status = 'Vencida';
                }

                if($academia->tipo_horario == 2){
                    $hora_inicio = Carbon::createFromFormat('H:i:s',$taller->hora_inicio)->toTimeString();
                    $hora_final = Carbon::createFromFormat('H:i:s',$taller->hora_final)->toTimeString();
                }else{
                    $hora_inicio = Carbon::createFromFormat('H:i:s',$taller->hora_inicio)->format('g:i a');
                    $hora_final = Carbon::createFromFormat('H:i:s',$taller->hora_final)->format('g:i a');
                }

                $collection=collect($taller);  
                $taller_array = $collection->toArray(); 
                $taller_array['cantidad_participantes']=$cantidad_participantes;  
                $taller_array['dias']=$dia;
                $taller_array['especialidades']=$taller->especialidad;
                $taller_array['status']=$status;
                $taller_array['dias_restantes']=$dias_restantes;
                $taller_array['hora_inicio']=$hora_inicio;
                $taller_array['hora_final']=$hora_final;
                
                $array[] = $taller_array;
            }

            foreach($horarios_talleres as $taller){

                $fecha = Carbon::createFromFormat('Y-m-d', $taller->fecha_inicio);
                $i = $fecha->dayOfWeek;

                if($i == 1){

                  $dia = 'Lunes';

                }else if($i == 2){

                  $dia = 'Martes';

                }else if($i == 3){

                  $dia = 'Miercoles';

                }else if($i == 4){

                  $dia = 'Jueves';

                }else if($i == 5){

                  $dia = 'Viernes';

                }else if($i == 6){

                  $dia = 'Sabado';

                }else if($i == 0){

                  $dia = 'Domingo';

                }
                
                $cantidad_participantes = InscripcionTaller::where('taller_id',$taller->id)->count();

                if($fecha >= Carbon::now()){

                    $dias_restantes = $fecha->diffInDays();
                    $status = 'Activa';

                }else{
                    $dias_restantes = 0;
                    $status = 'Vencida';
                }

                if($academia->tipo_horario == 2){
                    $hora_inicio = Carbon::createFromFormat('H:i:s',$taller->hora_inicio)->toTimeString();
                    $hora_final = Carbon::createFromFormat('H:i:s',$taller->hora_final)->toTimeString();
                }else{
                    $hora_inicio = Carbon::createFromFormat('H:i:s',$taller->hora_inicio)->format('g:i a');
                    $hora_final = Carbon::createFromFormat('H:i:s',$taller->hora_final)->format('g:i a');
                }

                $collection=collect($taller);  
                $taller_array = $collection->toArray(); 
                $taller_array['cantidad_participantes']=$cantidad_participantes;  
                $taller_array['dias']=$dia;
                $taller_array['especialidades']=$taller->especialidad;
                $taller_array['status']=$status;
                $taller_array['dias_restantes']=$dias_restantes;
                $taller_array['hora_inicio']=$hora_inicio;
                $taller_array['hora_final']=$hora_final;
                
                $array[] = $taller_array;
            }

            return view('agendar.taller.principal')->with(['talleres' => $array, 'academia' => $academia, 'usuario_tipo' => $usuario_tipo]);
        }else{
            
            foreach($talleres as $taller){

                $fecha = Carbon::createFromFormat('Y-m-d', $taller->fecha_inicio);
                $dia_de_semana = $fecha->dayOfWeek;

                if($fecha >= Carbon::now() && $taller->boolean_promocionar == 1){

                    $dia_string = '';

                    $i = $fecha->dayOfWeek;

                    if($i == 1){

                      $dia = 'Lunes';

                    }else if($i == 2){

                      $dia = 'Martes';

                    }else if($i == 3){

                      $dia = 'Miercoles';

                    }else if($i == 4){

                      $dia = 'Jueves';

                    }else if($i == 5){

                      $dia = 'Viernes';

                    }else if($i == 6){

                      $dia = 'Sabado';

                    }else if($i == 0){

                      $dia = 'Domingo';

                    }
     
                    $dia_string = $dia;
                    

                    $collection=collect($taller);     
                    $taller_array = $collection->toArray();

                    $taller_array['dias_de_semana']=$dia_string;
                    $array[$taller->id] = $taller_array;
                }
            }

            return view('agendar.taller.principal_alumno')->with(['talleres' => $array, 'academia' => $academia]);
        }
        
    }

    public function indexconacademia($id)
    {

        $talleres = Taller::join('config_especialidades', 'talleres.especialidad_id', '=', 'config_especialidades.id')
            ->leftJoin('instructores', 'talleres.instructor_id', '=', 'instructores.id')
            ->select('talleres.*','config_especialidades.nombre as especialidad', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido')
            ->where('talleres.academia_id', '=' ,  $id)
        ->get();

        $array = array();

        $academia = Academia::find($id);

        foreach($talleres as $taller){

            $fecha = Carbon::createFromFormat('Y-m-d', $taller->fecha_inicio);
            $dia_de_semana = $fecha->dayOfWeek;

            if($fecha >= Carbon::now() && $taller->boolean_promocionar == 1){

                $dia_string = '';

                $i = $fecha->dayOfWeek;

                if($i == 1){

                  $dia = 'Lunes';

                }else if($i == 2){

                  $dia = 'Martes';

                }else if($i == 3){

                  $dia = 'Miercoles';

                }else if($i == 4){

                  $dia = 'Jueves';

                }else if($i == 5){

                  $dia = 'Viernes';

                }else if($i == 6){

                  $dia = 'Sabado';

                }else if($i == 0){

                  $dia = 'Domingo';

                }
 
                $dia_string = $dia;
                

                $collection=collect($taller);     
                $taller_array = $collection->toArray();

                $taller_array['dias_de_semana']=$dia_string;
                $array[$taller->id] = $taller_array;
            }
        }

        return view('agendar.taller.principal_alumno')->with(['talleres' => $array, 'academia' => $academia]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (Session::has('horario')) {
            Session::forget('horario'); 
        }

        return view('agendar.taller.create')->with(['especialidad' => ConfigEspecialidades::all(), 'dias_de_semana' => DiasDeSemana::all(), 'nivel_baile' => ConfigNiveles::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->orderBy('nombre')->get(), 'estudio' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'instructores' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {


        $rules = [
            'nombre' => 'required|min:3|max:50',
            'costo' => 'required|numeric',
            'fecha' => 'required',
            'hora_inicio' => 'required',
            'hora_final' => 'required',
            'color_etiqueta' => 'required',
            'especialidad_id' => 'required',
            'nivel_baile_id' => 'required',
            'instructor_id' => 'required',
            'estudio_id' => 'required',
            'cupo_minimo' => 'numeric',
            'cupo_maximo' => 'numeric',
            'cupo_reservacion' => 'numeric',
            
            
        ];

        $messages = [

            'nombre.required' => 'Ups! El Nombre es requerido ',
            'nombre.min' => 'El m??nimo de caracteres permitidos son 3',
            'nombre.max' => 'El m??ximo de caracteres permitidos son 50',
            'costo.required' => 'Ups! El Costo es requerido',
            'costo.numeric' => 'Ups! El Costo es inv??lido , debe contener s??lo n??meros',
            'fecha.required' => 'Ups! La fecha es requerida',
            'hora_inicio.required' => 'Ups! El horario es requerido',
            'hora_final.required' => 'Ups! El horario es requerido',
            'especialidad_id.required' => 'Ups! La especialidad es requerida',
            'nivel_baile_id.required' => 'Ups! El nivel de baile es requerido ',
            'instructor_id.required' => 'Ups! El Instructor es requerido',
            'estudio_id.required' => 'Ups! La Sala o Estudio requerida',
            'etiqueta.required' => 'Ups! El color de la etiqueta es requerido',
            'cupo_minimo.numeric' => 'Ups! La cantidad de cupos es inv??lido , debe contener s??lo n??meros',
            'cupo_maximo.numeric' => 'Ups! La cantidad de cupos es inv??lido , debe contener s??lo n??meros',
            'cupo_reservacion.numeric' => 'Ups! La cantidad de cupos  para reservacion es inv??lido , debe contener s??lo n??meros',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            if($request->color_etiqueta == "#"){
                return response()->json(['errores' => ['color_etiqueta' => [0, 'Ups! El color de la etiqueta es requerido']], 'status' => 'ERROR'],422);
            }

            $fecha = explode(" - ", $request->fecha);

            $fecha_inicio = Carbon::createFromFormat('d/m/Y', $fecha[0]);
            $fecha_final = Carbon::createFromFormat('d/m/Y', $fecha[1]);

            if($fecha_inicio < Carbon::now()){

                return response()->json(['errores' => ['fecha' => [0, 'Ups! ha ocurrido un error. La fecha de inicio no puede ser menor al dia de hoy']], 'status' => 'ERROR'],422);
            }

            if($fecha_inicio > $fecha_final)
            {
                return response()->json(['errores' => ['fecha' => [0, 'Ups! La fecha de inicio es mayor a la fecha final']], 'status' => 'ERROR'],422);
            }

            $fecha_inicio = $fecha_inicio->toDateString();
            $fecha_final = $fecha_final->toDateString();

            $academia = Academia::find(Auth::user()->academia_id);
            if($academia->tipo_horario == 2){
                $hora_inicio = Carbon::createFromFormat('H:i',$request->hora_inicio)->toTimeString();
                $hora_final = Carbon::createFromFormat('H:i',$request->hora_final)->toTimeString();
            }else{
                $hora_inicio = Carbon::createFromFormat('H:i a',$request->hora_inicio)->toTimeString();
                $hora_final = Carbon::createFromFormat('H:i a',$request->hora_final)->toTimeString();
            }

            if($hora_inicio > $hora_final){
                return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
            }

            if($request->cupo_minimo > $request->cupo_maximo)
            {

                return response()->json(['errores' => ['cupo_minimo' => [0, 'Ups! El cupo minimo es mayor al cupo maximo']], 'status' => 'ERROR'],422);
            }

            if(trim($request->cantidad_hombres) == '')
            {
                $cantidad_hombres = null;
            }else{
                $cantidad_hombres = $request->cantidad_hombres;
            }

            if(trim($request->cantidad_mujeres) == '')
            {
                $cantidad_mujeres = null;
            }else{
                $cantidad_mujeres = $request->cantidad_mujeres;
            }

            $cupos = $cantidad_mujeres + $cantidad_hombres;

            if($request->cupo_minimo > $request->cupo_maximo)
            {

                return response()->json(['errores' => ['cupo_minimo' => [0, 'Ups! El cupo minimo es mayor al cupo maximo']], 'status' => 'ERROR'],422);
            }

            if($cupos < $request->cupo_minimo)
            {
                return response()->json(['errores' => ['cupo_minimo' => [0, 'Ups! El cupo minimo sobrepasa la suma de los cupos de hombres y mujeres']], 'status' => 'ERROR'],422);
            }

            if($cupos > $request->cupo_maximo)
            {
                return response()->json(['errores' => ['cupo_minimo' => [0, 'Ups! La suma de los cupos de hombres y mujeres sobrepasa el cupo maximo']], 'status' => 'ERROR'],422);
            }

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

            $taller = new Taller;

            $nombre = $this->slugify($request->nombre);
            $nombre = title_case($nombre);
            $descripcion = $request->descripcion;

            $taller->academia_id = Auth::user()->academia_id;
            $taller->descripcion = $descripcion;
            $taller->nombre = $nombre;
            $taller->costo = $request->costo;
            $taller->fecha_inicio = $fecha_inicio;
            $taller->fecha_final = $fecha_final;
            $taller->hora_inicio = $hora_inicio;
            $taller->hora_final = $hora_final;
            $taller->especialidad_id = $request->especialidad_id;
            $taller->instructor_id = $request->instructor_id;
            $taller->estudio_id = $request->estudio_id;
            $taller->color_etiqueta = $request->color_etiqueta;
            $taller->cupo_minimo = $request->cupo_minimo;
            $taller->cupo_maximo = $request->cupo_maximo;
            $taller->cupo_reservacion = $request->cupo_reservacion;
            $taller->condiciones = $request->condiciones;
            $taller->link_video = $request->link_video;
            $taller->cantidad_hombres = $cantidad_hombres;
            $taller->cantidad_mujeres = $cantidad_mujeres;
            $taller->boolean_promocionar = $request->boolean_promocionar;

            if($taller->save()){

                $notificacion = new Notificacion; 

                $notificacion->tipo_evento = 2;
                $notificacion->evento_id = $taller->id;
                $notificacion->mensaje = "Tu academia ha creado un taller llamado ".$taller->nombre;
                $notificacion->titulo = "Nuevo Taller";

                if($notificacion->save()){

                    $in = array(2,4);

                    $usuarios = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                        ->select('users.id')
                        ->whereIn('usuarios_tipo.tipo',$in)
                        ->where('users.academia_id', '=', Auth::user()->academia_id)
                    ->get();
                    
                    foreach ($usuarios as $usuario) {
                        $usuarios_notificados = new NotificacionUsuario;
                        $usuarios_notificados->id_usuario = $usuario->id;
                        $usuarios_notificados->id_notificacion = $notificacion->id;
                        $usuarios_notificados->visto = 0;
                        $usuarios_notificados->save();
                    }
                }

                $instructor = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                        ->select('users.id')
                        ->where('usuarios_tipo.tipo',3)    
                        ->where('usuarios_tipo.tipo_id',$request->instructor_id) 
                    ->first();

                if($instructor){

                    $notificacion = new Notificacion; 

                    $notificacion->tipo_evento = 2;
                    $notificacion->evento_id = $taller->id;
                    $notificacion->mensaje = "Te han asignado un taller llamado ".$taller->nombre;
                    $notificacion->titulo = "Nuevo Taller";

                    if($notificacion->save()){

                        $usuarios_notificados = new NotificacionUsuario;
                        $usuarios_notificados->id_usuario = $instructor->id;
                        $usuarios_notificados->id_notificacion = $notificacion->id;
                        $usuarios_notificados->visto = 0;
                        $usuarios_notificados->save();
                    }
                }

                if($request->costo){

                    $servicio = new ConfigServicios;

                    $servicio->academia_id = Auth::user()->academia_id;
                    $servicio->nombre = 'Inscripci??n ' . $nombre;
                    $servicio->costo = $request->costo;
                    $servicio->imagen = '';
                    $servicio->descripcion = $descripcion;
                    $servicio->incluye_iva = 1;
                    $servicio->tipo = 5;
                    $servicio->tipo_id = $taller->id;

                    $servicio->save();
                }

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

                    $nombre_img = "taller-". $taller->id . $extension;
                    $image = base64_decode($base64_string);

                    // \Storage::disk('taller')->put($nombre_img,  $image);
                    $img = Image::make($image)->resize(1440, 500);
                    $img->save('assets/uploads/taller/'.$nombre_img);

                    $taller->imagen = $nombre_img;
                    $taller->save();

                }
                
                return response()->json(['mensaje' => '??Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

     public function updateNombre(Request $request){

    $rules = [
        'nombre' => 'required|min:3|max:50',

    ];

    $messages = [

        'nombre.required' => 'Ups! El Nombre es requerido ',
        'nombre.min' => 'El m??nimo de caracteres permitidos son 3',
        'nombre.max' => 'El m??ximo de caracteres permitidos son 50',

    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
    }

    else{

        $taller = Taller::find($request->id);

        $nombre = $this->slugify($request->nombre);
        $nombre = title_case($nombre);

        $taller->nombre = $nombre;

        if($taller->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

        }
    }

    public function updateCosto(Request $request){

    $rules = [
      
        'costo' => 'required|numeric',

    ];

    $messages = [

        'costo.required' => 'Ups! El Costo es requerido',
        'costo.numeric' => 'Ups! El Costo es inv??lido , debe contener s??lo n??meros',

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

        $taller = Taller::find($request->id);
        $taller->costo = $request->costo;

        if($taller->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }


    public function updateDescripcion(Request $request){

    $rules = [

        'descripcion' => 'required',
    ];

    $messages = [

        'descripcion.required' => 'Ups! La Descripcion es requerida',

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

        $taller = Taller::find($request->id);

        $descripcion = $request->descripcion;

        $taller->descripcion = $descripcion;

        if($taller->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        }
    }


    public function updateFecha(Request $request){

    $rules = [

        'fecha' => 'required',

    ];

    $messages = [

        'fecha.required' => 'Ups! La fecha de inicio es requerida',

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


        $taller = Taller::find($request->id);

        $fecha = explode(" - ", $request->fecha);

        $fecha_inicio = Carbon::createFromFormat('d/m/Y', $fecha[0]);
        $fecha_final = Carbon::createFromFormat('d/m/Y', $fecha[1]);

        if($fecha_inicio < Carbon::now()){

            return response()->json(['errores' => ['fecha' => [0, 'Ups! ha ocurrido un error. La fecha de inicio no puede ser menor al dia de hoy']], 'status' => 'ERROR'],422);
        }
        
        $fecha_inicio = $fecha_inicio->toDateString();
        $fecha_final = $fecha_final->toDateString();

        $taller->fecha_inicio = $fecha_inicio;
        $taller->fecha_final = $fecha_final;

        if($taller->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function updateHorario(Request $request){

        $rules = [

            'hora_inicio' => 'required',
            'hora_final' => 'required',

        ];

        $messages = [

            'hora_inicio.required' => 'Ups! El horario es requerido',
            'hora_final.required' => 'Ups! El horario es requerido',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $academia = Academia::find(Auth::user()->academia_id);

            if($academia->tipo_horario == 2){
                $hora_inicio = Carbon::createFromFormat('H:i',$request->hora_inicio)->toTimeString();
                $hora_final = Carbon::createFromFormat('H:i',$request->hora_final)->toTimeString();
            }else{
                $hora_inicio = Carbon::createFromFormat('H:i a',$request->hora_inicio)->toTimeString();
                $hora_final = Carbon::createFromFormat('H:i a',$request->hora_final)->toTimeString();
            }

            if($hora_inicio > $hora_final){
                return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
            }

            $taller = Taller::find($request->id);
            $taller->hora_inicio = $hora_inicio;
            $taller->hora_final = $hora_final;

            if($taller->save()){

                return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateEspecialidad(Request $request){
        $taller = Taller::find($request->id);
        $taller->especialidad_id = $request->especialidad_id;

        if($taller->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateInstructor(Request $request){
        $taller = Taller::find($request->id);
        $taller->instructor_id = $request->instructor_id;

        if($taller->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEstudio(Request $request){
        $taller = Taller::find($request->id);
        $taller->estudio_id = $request->estudio_id;

        if($taller->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateCupos(Request $request){

    $rules = [

        'cupo_minimo' => 'required|numeric',
        'cupo_maximo' => 'required|numeric',
    ];

    $messages = [

        'cupo_minimo.required' => 'Ups! La cantidad de cupos son requerido',
        'cupo_maximo.required' => 'Ups! La cantidad de cupos son requerido',
        'cupo_minimo.numeric' => 'Ups! La cantidad de cupos es inv??lido , debe contener s??lo n??meros',
        'cupo_maximo.numeric' => 'Ups! La cantidad de cupos es inv??lido , debe contener s??lo n??meros',
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

        $taller = Taller::find($request->id);
        $taller->cupo_minimo = $request->cupo_minimo;
        $taller->cupo_maximo = $request->cupo_maximo;

        if( $request->cupo_minimo > $request->cupo_maximo)
        {
            return response()->json(['errores'=>'Cupo Minimo Mayor', 'status' => 'ERROR-SERVIDOR'],422);
        }

        if($taller->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        }

    }

    public function updateCantidad(Request $request){

    $rules = [

        'cantidad_hombres' => 'numeric',
        'cantidad_mujeres' => 'numeric',
    ];

    $messages = [

        'cantidad_hombres.numeric' => 'Ups! La cantidad es inv??lida , debe contener s??lo n??meros',
        'cantidad_mujeres.numeric' => 'Ups! La cantidad es inv??lida , debe contener s??lo n??meros',
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

        if(trim($request->cantidad_hombres) == '')
        {
            $cantidad_hombres = null;
        }else{
            $cantidad_hombres = $request->cantidad_hombres;
        }

        if(trim($request->cantidad_mujeres) == '')
        {
            $cantidad_mujeres = null;
        }else{
            $cantidad_mujeres = $request->cantidad_mujeres;
        }

        $taller = Taller::find($request->id);
        $taller->cantidad_hombres = $cantidad_hombres;
        $taller->cantidad_mujeres = $cantidad_mujeres;

        if($taller->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    }

    public function updateCuposOnline(Request $request){

    $rules = [

        'cupo_reservacion' => 'required|numeric',
    ];

    $messages = [

        'cupo_reservacion.required' => 'Ups! La cantidad de cupos son requerido',
        'cupo_reservacion.numeric' => 'Ups! La cantidad de cupos es inv??lido , debe contener s??lo n??meros',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        // return redirect("/home")

        // ->withErrors($validator)
        // ->withInput();

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }

        $taller = Taller::find($request->id);
        $taller->cupo_reservacion = $request->cupo_reservacion;


        if($taller->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

    public function updateEtiqueta(Request $request){

        if($request->color_etiqueta == "#"){
            return response()->json(['errores' => ['color_etiqueta' => [0, 'Ups! El color de la etiqueta es requerido']], 'status' => 'ERROR'],422);
        }
        
        $taller = Taller::find($request->id);
        $taller->color_etiqueta = $request->color_etiqueta;

        if($taller->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateLink(Request $request){

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

        $taller = Taller::find($request->id);
        $taller->link_video = $request->link_video;

        if($taller->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateCostoTaller(Request $request){

    $rules = [

        'costo' => 'required|numeric',
    ];

    $messages = [

        'costo.required' => 'Ups! El costo es requerido',
        'costo.numeric' => 'Ups! El costo es inv??lido , debe contener s??lo n??meros',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function updateImagen(Request $request)
    {
                $taller = Taller::find($request->id);
                
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

                    $nombre_img = "taller-". $taller->id . $extension;
                    $image = base64_decode($base64_string);

                    // \Storage::disk('taller')->put($nombre_img,  $image);
                    $img = Image::make($image)->resize(1440, 500);
                    $img->save('assets/uploads/taller/'.$nombre_img);

                }else{
                    $nombre_img = "";
                }

                $taller->imagen = $nombre_img;
                $taller->save();

                return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
    }

    public function updateCondiciones(Request $request){
        $taller = Taller::find($request->id);
        $taller->condiciones = $request->condiciones;

        if($taller->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateMostrar(Request $request){

        $taller = Taller::find($request->id);
        $taller->boolean_promocionar = $request->boolean_promocionar;

        if($taller->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function participantes($id)
    {

        $taller = Taller::find($id);

        if($taller){

            $usuario_tipo = Session::get('easydance_usuario_tipo');
            $mujeres = 0;
            $hombres = 0;
            $array = array();
            $in = array(2,4);

            $reservaciones = Reservacion::where('tipo_reservacion_id', '=', $id)
                ->where('tipo_reservacion', '=', '2')
                ->where('boolean_confirmacion', '=', 0)
            ->get();

            $now = Carbon::now();

            foreach($reservaciones as $reservacion){

                if($reservacion->tipo_usuario == 1){
                    $alumno = Alumno::withTrashed()->find($reservacion->tipo_usuario_id);
                    $edad = Carbon::createFromFormat('Y-m-d', $alumno->fecha_nacimiento)->diff(Carbon::now())->format('%y');
                }else if($reservacion->tipo_usuario == 2){
                    $alumno = Visitante::withTrashed()->find($reservacion->tipo_usuario_id);
                    $edad = Carbon::createFromFormat('Y-m-d', $alumno->fecha_nacimiento)->diff(Carbon::now())->format('%y');
                }else{
                    $alumno = Participante::find($reservacion->tipo_usuario_id);
                    $edad = 21;
                }

                if($alumno){

                    if($alumno->sexo == 'F'){
                        $mujeres++;
                    }else{
                        $hombres++;
                    }

                    $fecha_vencimiento = Carbon::createFromFormat('Y-m-d',$reservacion->fecha_vencimiento);
                    $diferencia_tiempo = $now->diffInWeeks($fecha_vencimiento);

                    if($diferencia_tiempo<1){

                        $fecha_vencimiento = Carbon::createFromFormat('Y-m-d',$reservacion->fecha_vencimiento);
                        $diferencia_tiempo = $now->diffInDays($fecha_vencimiento);

                        if($diferencia_tiempo<1){

                            $fecha_vencimiento = Carbon::createFromFormat('Y-m-d',$reservacion->fecha_vencimiento);
                            $diferencia_tiempo = $now->diffInHours($fecha_vencimiento);

                            if($diferencia_tiempo<1){

                                $fecha_vencimiento = Carbon::createFromFormat('Y-m-d',$reservacion->fecha_vencimiento);
                                $diferencia_tiempo = $now->diffInMinutes($fecha_vencimiento);

                                if($diferencia_tiempo<1){

                                    $fecha_vencimiento = Carbon::createFromFormat('Y-m-d',$reservacion->fecha_vencimiento);
                                    $diferencia_tiempo = $now->diffInSeconds($fecha_vencimiento);

                                    if($diferencia_tiempo==1){
                                        $fecha_de_realizacion = "en ".$diferencia_tiempo." segundo";
                                    }else{
                                        $fecha_de_realizacion = "en ".$diferencia_tiempo." Segundos";
                                    }
                                }else{

                                    if($diferencia_tiempo==1){
                                        $fecha_de_realizacion = "en ".$diferencia_tiempo." minuto";
                                    }else{
                                        $fecha_de_realizacion = "en ".$diferencia_tiempo." minutos";
                                    }
                                }
                            }else{

                                if($diferencia_tiempo==1){
                                    $fecha_de_realizacion = "en ".$diferencia_tiempo." hora";
                                }else{
                                    $fecha_de_realizacion = "en ".$diferencia_tiempo." horas";
                                }
                            }
                        }else{

                            if($diferencia_tiempo==1){
                                $hora_segundos = $fecha_vencimiento->format('H:i');
                                $fecha_de_realizacion = "Ma??ana a las ".$hora_segundos;
                            }else{
                                 $fecha_de_realizacion = "en ".$diferencia_tiempo." d??as";
                            }
                                
                        }
                    }else{
                        
                        if($diferencia_tiempo==1){
                            $fecha_de_realizacion = "en ".$diferencia_tiempo." semana";
                        }else{
                            $fecha_de_realizacion = "en ".$diferencia_tiempo." semanas";
                        }
                    }

                    $collection=collect($alumno);     
                    $alumno_array = $collection->toArray();
                    $alumno_array['imagen'] = '';
                    $alumno_array['nombre'] = $alumno->nombre;
                    $alumno_array['apellido'] = $alumno->apellido;
                    $alumno_array['sexo'] = $alumno->sexo;
                    $alumno_array['tipo'] = 2;
                    $alumno_array['alumno_id'] = $alumno->id;
                    $alumno_array['inscripcion_id'] = $reservacion->id;
                    $alumno_array['tiempo_vencimiento'] = $fecha_de_realizacion;
                    $alumno_array['fecha_vencimiento'] = $reservacion->fecha_vencimiento;
                    $alumno_array['llamadas'] = 0;
                    $alumno_array['edad'] = $edad;
                    $array[] = $alumno_array;
                }
            
            }

            $alumnos_inscritos = InscripcionTaller::join('alumnos', 'inscripcion_taller.alumno_id', '=', 'alumnos.id')
                ->select('alumnos.*', 'inscripcion_taller.id as inscripcion_id')
                ->where('inscripcion_taller.taller_id', '=', $id)
            ->get();

            foreach($alumnos_inscritos as $alumno){

                $deuda = ItemsFacturaProforma::where('fecha_vencimiento','<=',Carbon::today())
                    ->where('usuario_id','=',$alumno->id)
                    ->where('usuario_tipo',1)
                ->sum('importe_neto');

                $activacion = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                    ->where('usuarios_tipo.tipo_id', $alumno->id)
                    ->whereIn('usuarios_tipo.tipo', $in)
                    ->where('users.confirmation_token', '!=', null)
                ->first();

                if($activacion){
                    $activacion = 1;
                }else{
                    $activacion = 0;
                }

                $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                    ->where('usuarios_tipo.tipo_id',$alumno->id)
                    ->whereIn('usuarios_tipo.tipo',$in)
                ->first();

                if($usuario){

                    if($usuario->imagen){
                        $imagen = $usuario->imagen;
                    }else{
                        $imagen = '';
                    }

                }else{
                    $imagen = '';
                }

                $edad = Carbon::createFromFormat('Y-m-d', $alumno->fecha_nacimiento)->diff(Carbon::now())->format('%y');

                $collection=collect($alumno);     
                $alumno_array = $collection->toArray();

                $alumno_array['imagen'] = $imagen;
                $alumno_array['activacion']=$activacion;
                $alumno_array['deuda']=$deuda;
                $alumno_array['edad'] = $edad;

                $array[] = $alumno_array;

                if($alumno->sexo == 'F'){
                    $mujeres++;
                }else{
                    $hombres++;
                }

            }

            $alumnos = Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

            return view('agendar.taller.participantes')->with(['alumnos_inscritos' => $array, 'id' => $id, 'taller' => $taller, 'alumnos' => $alumnos, 'mujeres' => $mujeres, 'hombres' => $hombres, 'usuario_tipo' => $usuario_tipo]);
        }else{
            return redirect("agendar/talleres"); 
        }
    }

    public function storeInscripcion(Request $request)
    {


        $rules = [
            'taller_id' => 'required',
            'alumno_id' => 'required',
            'costo' => 'required|numeric',
        ];

        $messages = [

            'taller_id.required' => 'Ups! El Nombre es requerido',
            'alumno_id.required' => 'Ups! El Alumno es requerido',
            'costo.required' => 'Ups! El costo es requerido',
            'costo.numeric' => 'Ups! El costo es inv??lido , debe contener s??lo n??meros',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{

            $inscripcion = InscripcionTaller::where('alumno_id', '=', $request->alumno_id)
                ->where('taller_id', '=', $request->taller_id)
            ->first(); 

            // comprobar si esta inscrito
            if(!$inscripcion){ 

                $taller = Taller::find($request->taller_id);

                $inscripcion = new InscripcionTaller;

                $inscripcion->taller_id = $request->taller_id;
                $inscripcion->alumno_id = $request->alumno_id;
                $inscripcion->observacion_cambio_costo = $request->observacion_cambio_costo;

                if($inscripcion->save()){

                    if($request->costo){

                        $item_factura = new ItemsFacturaProforma;
                            
                        $item_factura->usuario_id = $request->alumno_id;
                        $item_factura->usuario_tipo = 1;
                        $item_factura->academia_id = Auth::user()->academia_id;
                        $item_factura->fecha = Carbon::now()->toDateString();
                        $item_factura->item_id = $request->taller_id;
                        $item_factura->nombre = 'Inscripcion ' . $taller->nombre;
                        $item_factura->tipo = 5;
                        $item_factura->cantidad = 1;
                        $item_factura->precio_neto = 0;
                        $item_factura->impuesto = 0;
                        $item_factura->importe_neto = $request->costo;
                        $item_factura->fecha_vencimiento = Carbon::now()->toDateString();
                            
                        $item_factura->save();
                    }

                    Session::forget('id_alumno');

                    return response()->json(['mensaje' => '??Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'uno' => 'uno', 'id' => $request->alumno_id, 200]);
                }

            }else{
                return response()->json(['errores' => ['alumno_id' => [0, 'Ya este alumno esta inscrito']], 'status' => 'ERROR'],422);
            }
            
        }
    }

    public function eliminarinscripcion($id){

        $inscripcion = InscripcionTaller::find($id);
        
        if($inscripcion->delete()){
            return response()->json(['mensaje' => '??Excelente! El Taller se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function progreso($id)
    {

        $taller_join = Taller::join('config_especialidades', 'talleres.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_estudios', 'talleres.estudio_id', '=', 'config_estudios.id')
            ->leftJoin('instructores', 'talleres.instructor_id', '=', 'instructores.id')
            ->join('academias', 'talleres.academia_id', '=', 'academias.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'talleres.nombre as taller_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'config_estudios.nombre as estudio_nombre', 'talleres.hora_inicio','talleres.hora_final', 'talleres.id', 'talleres.cupo_reservacion', 'talleres.fecha_inicio', 'talleres.imagen', 'talleres.descripcion', 'academias.imagen as imagen_academia', 'talleres.link_video', 'talleres.condiciones', 'academias.direccion', 'academias.estado', 'academias.facebook', 'academias.twitter', 'academias.instagram', 'academias.linkedin', 'academias.youtube', 'academias.pagina_web', 'academias.nombre as academia_nombre', 'academias.id as academia_id', 'talleres.costo')
            ->where('talleres.id','=', $id)
        ->first();

        $fecha_inicio = Carbon::createFromFormat('Y-m-d', $taller_join->fecha_inicio);

        if(Carbon::now() > $fecha_inicio){
            $inicio = 1;
        }else{
            $inicio = 0;
        }

        $academia = Academia::find($taller_join->academia_id);

        if($taller_join->link_video){

            $parts = parse_url($taller_join->link_video);
            $partes = explode( '=', $parts['query'] );
            $link_video = $partes[1];

            }
            else{
                $link_video = '';
            }

         $cantidad_reservaciones = Reservacion::where('tipo_reservacion_id', '=', $id)
             ->where('tipo_reservacion', '=', 2)
         ->count();

         if($taller_join->cupo_reservacion == 0){
            $cupo_reservacion = 1;
         }
         else{
            $cupo_reservacion = $taller_join->cupo_reservacion;
         }

         $cupos_restantes = $cupo_reservacion - $cantidad_reservaciones;

         if($cupos_restantes < 0){
            $cupos_restantes = 0;
         }

         $porcentaje = intval(($cantidad_reservaciones / $cupo_reservacion) * 100);

         if(Auth::check()){

            $usuario_tipo = Session::get('easydance_usuario_tipo');

        }else{
            $usuario_tipo = 0;
        
        }

        return view('agendar.taller.reserva')->with(['taller' => $taller_join, 'id' => $id, 'porcentaje' => $porcentaje, 'link_video' => $link_video, 'academia' => $academia, 'cupos_restantes' => $cupos_restantes, 'usuario_tipo' => $usuario_tipo, 'inicio' => $inicio]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    public function operar($id)
    {   
        $taller = Taller::find($id);
        return view('agendar.taller.operacion')->with(['id'=> $id , 'taller' => $taller]);         
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    
    public function edit($id)
    {

        $taller = Taller::join('config_especialidades', 'talleres.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_estudios', 'talleres.estudio_id', '=', 'config_estudios.id')
            ->leftJoin('instructores', 'talleres.instructor_id', '=', 'instructores.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','config_estudios.nombre as estudio_nombre', 'talleres.fecha_inicio as fecha_inicio', 'talleres.fecha_final as fecha_final' , 'talleres.hora_inicio','talleres.hora_final', 'talleres.id', 'talleres.id', 'talleres.nombre', 'talleres.costo', 'talleres.descripcion', 'talleres.cupo_minimo', 'talleres.cupo_maximo' , 'talleres.cupo_reservacion', 'talleres.link_video', 'talleres.imagen', 'talleres.color_etiqueta', 'talleres.condiciones', 'talleres.cantidad_hombres', 'talleres.cantidad_mujeres', 'talleres.boolean_promocionar')
            ->where('talleres.id', '=', $id)
        ->first();

        if($taller){

            $horarios = HorarioTaller::where('taller_id',$id)
            ->join('config_especialidades', 
                'horarios_talleres.especialidad_id',
                '=', 
                'config_especialidades.id'
                )
            ->leftJoin('instructores', 
                'horarios_talleres.instructor_id',
                '=',
                'instructores.id'
                 )
            ->join('config_estudios', 
                'horarios_talleres.estudio_id',
                '=',
                'config_estudios.id'
                 )
            ->select('horarios_talleres.*', 
                'instructores.nombre as instructor_nombre',
                'instructores.apellido as instructor_apellido',
                'config_especialidades.nombre as especialidad_nombre', 
                'config_estudios.nombre as estudio_nombre'
                 )
            ->get();

            $arrayHorario = array();

            foreach ($horarios as $horario) {
                $instructor=$horario->instructor_nombre.' '.$horario->instructor_apellido;
                $especialidad=$horario->especialidad_nombre;
                $estudio = $horario->estudio_nombre;
                $fecha=$horario->fecha;
                $hora_inicio=$horario->hora_inicio;
                $hora_final=$horario->hora_final;
                $id_horario=$horario->id;

                $arrayHorario[$id_horario] = array(
                    'instructor' => $instructor,
                    'especialidad' => $especialidad,
                    'estudio' => $estudio,
                    'hora_inicio' => $hora_inicio,
                    'hora_final' => $hora_final,
                    'fecha'=> $fecha,
                    'id'=>$id_horario
                );
            }

            return view('agendar.taller.planilla')->with(['config_especialidades' => ConfigEspecialidades::all(), 'config_estudios' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'instructores' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get(), 'taller' => $taller, 'arrayHorario' => $arrayHorario]);

        }else{
           return redirect("agendar/talleres"); 
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        // $exist = InscripcionTaller::where('taller_id', $id)->first();

        // if(!$exist)
        // {
            $horarios = HorarioTaller::where('taller_id', $id)->delete();
            $taller = Taller::find($id);
            
            if($taller->delete()){
                $notificacion = Notificacion::where('tipo_evento',2)->where('evento_id',$id)->first();
                if($notificacion){
                    $notificacion_usuario = NotificacionUsuario::where('id_notificacion',$notificacion->id)->delete();
                    $notificacion->delete();
                }
                $delete = ConfigServicios::where('tipo',5)->where('tipo_id',$id)->delete();
                return response()->json(['mensaje' => '??Excelente! El Taller se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }

        // }else{
        //     return response()->json(['error_mensaje'=> 'Ups! Este taller no puede ser eliminado ya que posee alumnos registrados' , 'status' => 'ERROR-BORRADO'],422);
        // }
    }

    public function egresos($id)
    {
        $taller = Taller::find($id);

        if($taller){
            $config_egresos = ConfigEgreso::all();

            $egresos = Egreso::Leftjoin('config_egresos', 'egresos.tipo' , '=', 'config_egresos.id')
                ->select('egresos.*', 'config_egresos.nombre as config_tipo')
                ->where('tipo_id',$id)
                ->where('tipo',3)
            ->get();

            $total = Egreso::Leftjoin('config_egresos', 'egresos.tipo' , '=', 'config_egresos.id')
                ->select('egresos.*', 'config_egresos.nombre as config_tipo')
                ->where('tipo_id',$id)
                ->where('tipo',3)
            ->sum('cantidad');

            return view('agendar.taller.egresos')->with(['taller' => $taller, 'egresos' => $egresos, 'total' => $total, 'config_egresos' => $config_egresos, 'id' => $id]);
        }else{
           return redirect("agendar/talleres"); 
        }
    }

}