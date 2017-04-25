<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\DiasDeSemana;
use App\ClasePersonalizada;
use App\ConfigEstudios;
use App\ConfigEspecialidades;
use App\ConfigClasesPersonalizadas;
use App\ConfigNiveles;
use App\Instructor;
use App\Alumno;
use App\Academia;
use App\CitaClasePersonalizada;
use App\CostoClasePersonalizada;
use App\ItemsFacturaProforma;
use App\InscripcionClasePersonalizada;
use App\User;
use App\Asistencia;
use App\Staff;
use App\Visitante;
use App\HorarioClasePersonalizada;
use Mail;
use Validator;
use DB;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;
use Image;
use PulkitJalan\GeoIP\GeoIP;

class ClasePersonalizadaController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index(Request $request)
    {


        if(Auth::user()->usuario_tipo != 2 AND Auth::user()->usuario_tipo != 4){

            $fechaActual = Carbon::now();
            $geoip = new GeoIP();
            $geoip->setIp($request->ip());
            $fechaActual->tz = $geoip->getTimezone();

            // $activas = ClasePersonalizada::join('inscripcion_clase_personalizada', 'clases_personalizadas.id', '=', 'inscripcion_clase_personalizada.clase_personalizada_id')
            //         ->where('clases_personalizadas.academia_id', Auth::user()->academia_id)
            //         ->where('inscripcion_clase_personalizada.estatus', 1)
            // ->get();


            // foreach($activas as $activa){

            //     $horarios = HorarioClasePersonalizada::where('clase_personalizada_id',$activa->id)->get();
            //     $fecha_inicio = Carbon::createFromFormat('Y-m-d', $activa->fecha_inicio);

            //     if($horarios){
                    
            //         foreach($horarios as $horario){

            //             $fecha_horario = Carbon::createFromFormat('Y-m-d', $horario->fecha);

            //             if($fecha_horario > $fecha_inicio){
            //                 $fecha_inicio = $fecha_horario;
            //             }
            //         }
            //     }

            //     if($fecha_inicio <= $fechaActual->format('Y-m-d')){

            //         if($fecha_inicio < $fechaActual->format('Y-m-d')){
            //             $clase_personalizada = InscripcionClasePersonalizada::find($activa->id);
            //             $clase_personalizada->estatus = 2;
            //             $clase_personalizada->save();
            //         }else{

            //             $hora_final = Carbon::createFromFormat('H:i:s', $activa->hora_final);

            //             if($hora_final <= $fechaActual->format('H:i:s')){
            //                 $clase_personalizada = InscripcionClasePersonalizada::find($activa->id);
            //                 $clase_personalizada->estatus = 2;
            //                 $clase_personalizada->save();
            //             }

            //         }
            //     }
            // }


            $array = array();

            $clases_personalizadas = InscripcionClasePersonalizada::join('alumnos', 'inscripcion_clase_personalizada.alumno_id', '=', 'alumnos.id')
                ->join('clases_personalizadas', 'inscripcion_clase_personalizada.clase_personalizada_id', '=', 'clases_personalizadas.id')
                ->join('instructores', 'inscripcion_clase_personalizada.instructor_id', '=', 'instructores.id')
                ->select('inscripcion_clase_personalizada.*', 'clases_personalizadas.nombre as clase_personalizada_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'alumnos.nombre as alumno_nombre', 'alumnos.apellido as alumno_apellido')
                ->where('clases_personalizadas.academia_id','=', Auth::user()->academia_id)
            ->get();

            foreach($clases_personalizadas as $clase_personalizada){
                $fecha_inicio = Carbon::createFromFormat('Y-m-d', $clase_personalizada->fecha_inicio);

                if($fecha_inicio >= Carbon::now() && $clase_personalizada->estatus != 0){
                    $tipo = 'A';
                }else if($fecha_inicio >= Carbon::now() && $clase_personalizada->estatus != 0){
                    $tipo = 'F';
                }else{
                    $tipo = 'C';
                }

                $collection=collect($clase_personalizada);     
                $personalizada_array = $collection->toArray();
                $personalizada_array['tipo']=$tipo;
                $array[] = $personalizada_array;
            }

            $clases_personalizadas = InscripcionClasePersonalizada::join('alumnos', 'inscripcion_clase_personalizada.alumno_id', '=', 'alumnos.id')
                ->join('clases_personalizadas', 'inscripcion_clase_personalizada.clase_personalizada_id', '=', 'clases_personalizadas.id')
                ->join('horarios_clases_personalizadas', 'horarios_clases_personalizadas.clase_personalizada_id', '=', 'inscripcion_clase_personalizada.id')
                ->join('instructores', 'horarios_clases_personalizadas.instructor_id', '=', 'instructores.id')
                ->select('inscripcion_clase_personalizada.*', 'clases_personalizadas.nombre as clase_personalizada_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'alumnos.nombre as alumno_nombre', 'alumnos.apellido as alumno_apellido', 'horarios_clases_personalizadas.fecha', 'horarios_clases_personalizadas.hora_inicio', 'horarios_clases_personalizadas.hora_final')
                ->where('clases_personalizadas.academia_id','=', Auth::user()->academia_id)
            ->get();
            
            foreach($clases_personalizadas as $clase_personalizada){
                $fecha_inicio = Carbon::createFromFormat('Y-m-d', $clase_personalizada->fecha_inicio);

                if($fecha_inicio >= Carbon::now() && $clase_personalizada->estatus != 0){
                    $tipo = 'A';
                }else if($fecha_inicio >= Carbon::now() && $clase_personalizada->estatus != 0){
                    $tipo = 'F';
                }else{
                    $tipo = 'C';
                }

                $collection=collect($clase_personalizada);     
                $personalizada_array = $collection->toArray();
                $personalizada_array['tipo']=$tipo;
                $array[] = $personalizada_array;
            }

            $asistencias = Asistencia::where('tipo', '3')->where('academia_id', Auth::user()->academia_id)->get();

            $collection=collect($asistencias);
            $grouped = $collection->groupBy('tipo_id');     
            $asistencias = $grouped->toArray();

            return view('agendar.clase_personalizada.index')->with(['clases_personalizadas' => $array, 'asistencias' => $asistencias]);
        }else{

            $clases_personalizadas = ClasePersonalizada::where('academia_id', Auth::user()->academia_id)->get();

            $academia = Academia::find(Auth::user()->academia_id);

            return view('agendar.clase_personalizada.principal_alumno')->with(['clases_personalizadas' => $clases_personalizadas, 'academia' => $academia]);

        }
    }

    public function indexconacademia($id)
    {

        $clases_personalizadas = ClasePersonalizada::where('academia_id', $id)->get();

        $config_clase_personalizada = ConfigClasesPersonalizadas::where('academia_id', $id)->first();

        if(!$config_clase_personalizada)
        {
            $config_clase_personalizada = new ConfigClasesPersonalizadas;

            $config_clase_personalizada->academia_id = $id;
            $config_clase_personalizada->imagen_principal = '';
            $config_clase_personalizada->descripcion = '';
            $config_clase_personalizada->video_promocional = '';
            $config_clase_personalizada->imagen1 = '';
            $config_clase_personalizada->imagen2 = '';
            $config_clase_personalizada->imagen3 = '';
            $config_clase_personalizada->ventajas = '';
            $config_clase_personalizada->condiciones = '';

            $config_clase_personalizada->save();
            
        }

        $academia = Academia::find($id);

        return view('agendar.clase_personalizada.principal_alumno')->with(['clases_personalizadas' => $clases_personalizadas, 'academia' => $academia]);

        
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


        $config_clase_personalizada = ConfigClasesPersonalizadas::where('academia_id', Auth::user()->academia_id)->first();

        if(!$config_clase_personalizada)
        {

            $config_clase_personalizada = new ConfigClasesPersonalizadas;

            $config_clase_personalizada->academia_id = Auth::user()->academia_id;
            $config_clase_personalizada->imagen_principal = '';
            $config_clase_personalizada->descripcion = '';
            $config_clase_personalizada->video_promocional = '';
            $config_clase_personalizada->imagen1 = '';
            $config_clase_personalizada->imagen2 = '';
            $config_clase_personalizada->imagen3 = '';
            $config_clase_personalizada->ventajas = '';
            $config_clase_personalizada->condiciones = '';

            $config_clase_personalizada->save();
            
        }

        $id = Auth::user()->academia_id;

        $alumnos = Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

        $precios = CostoClasePersonalizada::join('clases_personalizadas', 'costo_clases_personalizadas.clase_personalizada_id', '=', 'clases_personalizadas.id')
        ->select('clases_personalizadas.academia_id', 'costo_clases_personalizadas.precio', 'clases_personalizadas.id', 'costo_clases_personalizadas.id as precio_id', 'costo_clases_personalizadas.participantes')
        ->where('clases_personalizadas.academia_id','=', Auth::user()->academia_id)
        ->get();

        $alumno_id = Session::get('id_alumno');

        return view('agendar.clase_personalizada.reservar')->with(['alumnos' => $alumnos, 'especialidad' => ConfigEspecialidades::all(), 'instructoresacademia' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->where('boolean_disponibilidad' , 1)->get(), 'condiciones' => $config_clase_personalizada->condiciones, 'clases_personalizadas' => ClasePersonalizada::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'config_estudios' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'precios' => $precios, 'alumno_id' => $alumno_id, 'promotores' => Staff::where('cargo',1)->where('academia_id', Auth::user()->academia_id)->get()]);
        
    }

    public function reservacion($id)
    {
        $clase_personalizada = ClasePersonalizada::find($id);
        $academia_id = $clase_personalizada->academia_id;
        $config_clase_personalizada = ConfigClasesPersonalizadas::where('academia_id', $academia_id)->first();
        
        if(!$config_clase_personalizada)
        {

            $config_clase_personalizada = new ConfigClasesPersonalizadas;

            $config_clase_personalizada->academia_id = $academia_id;
            $config_clase_personalizada->imagen_principal = '';
            $config_clase_personalizada->descripcion = '';
            $config_clase_personalizada->video_promocional = '';
            $config_clase_personalizada->imagen1 = '';
            $config_clase_personalizada->imagen2 = '';
            $config_clase_personalizada->imagen3 = '';
            $config_clase_personalizada->ventajas = '';
            $config_clase_personalizada->condiciones = '';

            $config_clase_personalizada->save();
            
        }

        $instructor_id = Session::get('instructor_id');

        $academia_id = Auth::user()->academia_id;

        $alumnos = Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

        $precios = CostoClasePersonalizada::join('clases_personalizadas', 'costo_clases_personalizadas.clase_personalizada_id', '=', 'clases_personalizadas.id')
        ->select('clases_personalizadas.academia_id', 'costo_clases_personalizadas.precio', 'clases_personalizadas.id', 'costo_clases_personalizadas.id as precio_id', 'costo_clases_personalizadas.participantes')
        ->where('clases_personalizadas.academia_id','=', Auth::user()->academia_id)
        ->get();

        return view('agendar.clase_personalizada.reservar')->with(['alumnos' => $alumnos, 'especialidad' => ConfigEspecialidades::all(), 'instructoresacademia' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->where('boolean_disponibilidad' , 1)->get(), 'condiciones' => $config_clase_personalizada->condiciones, 'clases_personalizadas' => ClasePersonalizada::where('academia_id', '=' ,  $academia_id)->get(), 'id' => $academia_id, 'clase_personalizada_id' => $id, 'instructor_id' => $instructor_id, 'config_estudios' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'precios' => $precios]);
        
    }

    public function operar($id)
    {   


        $clase_personalizada = DB::table('inscripcion_clase_personalizada')
            ->join('alumnos', 'inscripcion_clase_personalizada.alumno_id', '=', 'alumnos.id')
            ->join('config_especialidades', 'inscripcion_clase_personalizada.especialidad_id', '=', 'config_especialidades.id')
            ->join('clases_personalizadas', 'inscripcion_clase_personalizada.clase_personalizada_id', '=', 'clases_personalizadas.id')
            ->join('instructores', 'inscripcion_clase_personalizada.instructor_id', '=', 'instructores.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'clases_personalizadas.nombre as clase_personalizada_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','inscripcion_clase_personalizada.hora_inicio','inscripcion_clase_personalizada.hora_final', 'inscripcion_clase_personalizada.id', 'inscripcion_clase_personalizada.fecha_inicio', 'alumnos.nombre as alumno_nombre', 'alumnos.apellido as alumno_apellido')
            ->where('inscripcion_clase_personalizada.id','=', $id)
        ->first();

        if($clase_personalizada)
        {

            return view('agendar.clase_personalizada.operacion')->with(['id' => $id, 'clasepersonalizada' => $clase_personalizada]); 

        }else{
            return redirect("agendar/clases-personalizadas"); 
        }    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

    // dd($request->all());
    

    $rules = [

        'nombre' => 'required',
        'costo' => 'required|numeric',
        'color_etiqueta' => 'required',
        'tiempo_expiracion' => 'numeric',

    ];

    $messages = [

        'nombre.required' => 'Ups! El Nombre  es requerido',
        'costo.numeric' => 'Ups! El costo es inválido, debe contener sólo  números',
        'costo.required' => 'Ups! El costo es requerido',
        'color_etiqueta.required' => 'Ups! La etiqueta es requerida',
        'tiempo_expiracion.numeric' => 'Ups! El Tiempo de expiración es inválido, debe contener sólo  números',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $nombre = title_case($request->nombre);

        $clasepersonalizada = new ClasePersonalizada;

        $clasepersonalizada->academia_id = Auth::user()->academia_id;
        $clasepersonalizada->nombre = $nombre;
        $clasepersonalizada->costo = $request->costo;
        $clasepersonalizada->descripcion = $request->descripcion;
        $clasepersonalizada->color_etiqueta = $request->color_etiqueta;
        $clasepersonalizada->tiempo_expiracion = $request->tiempo_expiracion;

        // return redirect("/home");
        if($clasepersonalizada->save()){

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

                $nombre_img = "clasepersonalizada2-". $clasepersonalizada->id . $extension;
                $image = base64_decode($base64_string);

                // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
                $img = Image::make($image)->resize(300, 300);
                $img->save('assets/uploads/clase_personalizada/'.$nombre_img);

                $clasepersonalizada->imagen = $nombre_img;
                $clasepersonalizada->save();

            }

           
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function reservar(Request $request)
    {

    if(Auth::user()->usuario_tipo == 1 OR Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6)

    {

        $rules = [

            'alumno_id' => 'required',

        ];

        $messages = [

            'alumno_id.required' => 'Ups! El Alumno es requerido',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        $usuario_id = $request->alumno_id;

    }else{
        $usuario_id = Auth::user()->usuario_id;
    }

    

    $rules = [

        'clase_personalizada_id' => 'required',
        'fecha' => 'required',
        'especialidad_id' => 'required',
        'instructor_id' => 'required',
        'hora_inicio' => 'required',
        'hora_final' => 'required',
    ];

    $messages = [

        'clase_personalizada_id.required' => 'Ups! El nombre es requerido',
        'fecha.required' => 'Ups! La fecha es requerida',
        'instructor_id.required' => 'Ups! El instructor es requerido',
        'hora_inicio.required' => 'Ups! La hora de inicio es requerida',
        'hora_final.required' => 'Ups! La hora final es requerida',
        'especialidad_id.required' => 'Ups! La especialidad es requerida ',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $fecha = explode(" - ", $request->fecha);

        $hora_inicio = strtotime($request->hora_inicio);
        $hora_final = strtotime($request->hora_final);

        $fecha_inicio = Carbon::createFromFormat('d/m/Y', $fecha[0]);
        $fecha_final = Carbon::createFromFormat('d/m/Y', $fecha[1]);

        if($hora_inicio > $hora_final)
        {

            return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
        }

        if($fecha_inicio < Carbon::now()){

            return response()->json(['errores' => ['fecha' => [0, 'Ups! ha ocurrido un error. La fecha de la clase no puede ser menor al dia de hoy']], 'status' => 'ERROR'],422);
        }

        $fecha_inicio = $fecha_inicio->toDateString();
        $fecha_final = $fecha_final->toDateString();

        $clasepersonalizada = new CitaClasePersonalizada;
        
        
        $clasepersonalizada->academia_id = Auth::user()->academia_id;
        $clasepersonalizada->usuario_id = $usuario_id;
        $clasepersonalizada->clase_personalizada_id = $request->clase_personalizada_id;
        $clasepersonalizada->fecha_inicio = $fecha_inicio;
        $clasepersonalizada->instructor_id = $request->instructor_id;
        $clasepersonalizada->hora_inicio = $request->hora_inicio;
        $clasepersonalizada->hora_final = $request->hora_final;
        $clasepersonalizada->especialidad_id = $request->especialidad_id;

        // return redirect("/home");
        if($clasepersonalizada->save()){

            $academia = Academia::find(Auth::user()->academia_id);
            $alumno = Alumno::find($usuario_id);
            $instructor = Instructor::find($request->instructor_id);

            $subj = 'Han reservado una Clase Personalizada';

            $array = [
               'nombre_instructor' => $instructor->nombre,
               'apellido_instructor' => $instructor->apellido,
               'correo' => $academia->correo,
               'academia' => $academia->nombre,
               'nombre_alumno' => $alumno->nombre,
               'apellido_alumno' => $alumno->apellido,
               'cedula' => $alumno->identificacion,
               'hora_inicio' => $request->hora_inicio,
               'hora_final' => $request->hora_final,
               'fecha' => $fecha_inicio,
               'subj' => $subj
            ];

            Mail::send('correo.cita_clase_personalizada_academia', $array, function($msj) use ($array){
                    $msj->subject($array['subj']);
                    $msj->to($array['correo']);
            });

            $subj2 = 'Has reservado una Clase Personalizada';


            $array2 = [
               'nombre_instructor' => $instructor->nombre,
               'apellido_instructor' => $instructor->apellido,
               'correo' => $alumno->correo,
               'academia' => $academia->nombre,
               'nombre_alumno' => $alumno->nombre,
               'hora_inicio' => $request->hora_inicio,
               'hora_final' => $request->hora_final,
               'fecha' => $fecha_inicio,
               'subj' => $subj2
            ];

            Mail::send('correo.cita_clase_personalizada_alumno', $array2, function($msj) use ($array2){
                    $msj->subject($array2['subj']);
                    $msj->to($array2['correo']);
            });

            Session::forget('instructor_id');
            Session::forget('id_alumno');

            if(Auth::user()->usuario_tipo == 1 OR Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6)

            {

                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'id' => $usuario_id, 200]);
            }else{

                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
            }
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function completado()
    {
        return view('agendar.clase_personalizada.reservar_completado');
    }

     public function updateNombre(Request $request){

        $clasepersonalizada = ClasePersonalizada::find($request->id);
        $clasepersonalizada->nombre = $request->nombre;

        if($clasepersonalizada->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'nombre' => 'nombre', 'valor' => $nombre, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }


    public function updateFecha(Request $request){

    $request->merge(array('fecha_inicio' => trim($request->fecha_inicio)));

    $rules = [
        'fecha' => 'required',
    ];

    $messages = [

        'fecha.required' => 'Ups! La fecha es requerida',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

            $fecha = explode(" - ", $request->fecha);

            $fecha_inicio = Carbon::createFromFormat('d/m/Y', $fecha[0]);
            $fecha_final = Carbon::createFromFormat('d/m/Y', $fecha[1]);

            if($fecha_inicio < Carbon::now()){

                return response()->json(['errores' => ['fecha_inicio' => [0, 'Ups! ha ocurrido un error. La fecha de la clase no puede ser menor al dia de hoy']], 'status' => 'ERROR'],422);
            }

            $clasepersonalizada = InscripcionClasePersonalizada::find($request->id);

            $fecha_inicio = $fecha_inicio->toDateString();
            $fecha_final = $fecha_final->toDateString();

            $clasepersonalizada->fecha_inicio = $fecha_inicio;
            $clasepersonalizada->fecha_final = $fecha_final;

            if($clasepersonalizada->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateEspecialidad(Request $request){
        $clasepersonalizada = InscripcionClasePersonalizada::find($request->id);
        $clasepersonalizada->especialidad_id = $request->especialidad_id;

        if($clasepersonalizada->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateAlumno(Request $request){
        $clasepersonalizada = ClasePersonalizada::find($request->id);
        $clasepersonalizada->alumno_id = $request->alumno_id;

        if($clasepersonalizada->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateInstructor(Request $request){
        $clasepersonalizada = InscripcionClasePersonalizada::find($request->id);
        $clasepersonalizada->instructor_id = $request->instructor_id;

        if($clasepersonalizada->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
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

        // return redirect("/home")

        // ->withErrors($validator)
        // ->withInput();

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }

    else{

            $hora_inicio = strtotime($request->hora_inicio);
            $hora_final = strtotime($request->hora_final);

            if($hora_inicio > $hora_final)
            {

                return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
            }

            $clasepersonalizada = InscripcionClasePersonalizada::find($request->id);
            $clasepersonalizada->hora_inicio = $request->hora_inicio;
            $clasepersonalizada->hora_final = $request->hora_final;

            if($clasepersonalizada->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $find = InscripcionClasePersonalizada::find($id);

        if ($find) {

            $clase_personalizada_join = InscripcionClasePersonalizada::join('clases_personalizadas', 'inscripcion_clase_personalizada.clase_personalizada_id', '=', 'clases_personalizadas.id')
                ->join('config_especialidades', 'inscripcion_clase_personalizada.especialidad_id', '=', 'config_especialidades.id')
                ->join('instructores', 'inscripcion_clase_personalizada.instructor_id', '=', 'instructores.id')
                ->join('alumnos', 'inscripcion_clase_personalizada.alumno_id', '=', 'alumnos.id')
                ->select('config_especialidades.nombre as especialidad_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'inscripcion_clase_personalizada.fecha_inicio as fecha_inicio', 'inscripcion_clase_personalizada.fecha_final as fecha_final', 'inscripcion_clase_personalizada.hora_inicio','inscripcion_clase_personalizada.hora_final',  'inscripcion_clase_personalizada.id', 'clases_personalizadas.tiempo_expiracion', 'alumnos.nombre as alumno_nombre', 'alumnos.apellido as alumno_apellido', 'clases_personalizadas.nombre')
                ->where('inscripcion_clase_personalizada.id', '=', $id)
            ->first();

            $hora_string = $find->fecha_inicio . ' ' . $find->hora_inicio;
        
            $hora = Carbon::createFromFormat('Y-m-d H:i:s', $hora_string);
            $hora_limite = $hora->subHours($find->tiempo_expiracion);

            if(Carbon::now() > $hora_limite)
            {
                $cancelacion = 'Cancelación Tardia';
            }else{
                $cancelacion = 'Cancelación Temprana';
            }

            $horario_clase_grupal=HorarioClasePersonalizada::where('clase_personalizada_id',$id)
                ->join('config_especialidades', 
                    'horarios_clases_personalizadas.especialidad_id',
                    '=', 
                    'config_especialidades.id'
                    )
                ->join('instructores', 
                    'horarios_clases_personalizadas.instructor_id',
                    '=',
                    'instructores.id'
                     )
                ->join('config_estudios', 
                    'horarios_clases_personalizadas.estudio_id',
                    '=',
                    'config_estudios.id'
                     )
                ->select('horarios_clases_personalizadas.*', 
                    'instructores.nombre as instructor_nombre',
                    'instructores.apellido as instructor_apellido',
                    'config_especialidades.nombre as especialidad_nombre', 
                    'config_estudios.nombre as estudio_nombre'
                     )
            ->get();

        $arrayHorario= array();

        foreach ($horario_clase_grupal as $horario) {
            $instructor=$horario->instructor_nombre.' '.$horario->instructor_apellido;
            $especialidad=$horario->especialidad_nombre;
            $estudio = $horario->estudio_nombre;
            $fecha=$horario->fecha;
            $hora_inicio=$horario->hora_inicio;
            $hora_final=$horario->hora_final;
            $id_horario=$horario->id;

            $fc=explode('-',$fecha);
            $fecha_curso=Carbon::create($fc[0], $fc[1], $fc[2], 00, 00, 00);
            $dia_curso = $fecha_curso->format('l');

            $dia_de_semana="";

            $dia_curso=strtoupper($dia_curso);

            if($dia_curso=="SUNDAY")
            {
                $dia="6";
                $dia_de_semana="Domingo";
            }
            elseif($dia_curso=="MONDAY")
            {
                $dia="0";
                $dia_de_semana="Lunes";
            }
            elseif($dia_curso=="TUESDAY")
            {
                $dia="1";
                $dia_de_semana="Martes";

            }
            elseif($dia_curso=="WEDNESDAY")
            {
                $dia="2";
                $dia_de_semana="Míercoles";                
            }
            elseif($dia_curso=="THURSDAY")
            {
                $dia="3";
                $dia_de_semana="Jueves";                
            }
            elseif($dia_curso=="FRIDAY")
            {
                $dia="4";
                $dia_de_semana="Viernes";
            }
            elseif($dia_curso=="SATURDAY")
            {
                $dia="5";
                $dia_de_semana="Sábado";
            }

            $dia_de_semana = $fecha;

            $arrayHorario[$id_horario] = array(
                    'instructor' => $instructor,
                    'dia_de_semana' => $dia_de_semana,
                    'new_dia_de_semama'=>$dia_curso,
                    'especialidad' => $especialidad,
                    'estudio' => $estudio,
                    'hora_inicio' => $hora_inicio,
                    'new_hora_inicio' => $hora_inicio,
                    'hora_final' => $hora_final,
                    'new_hora_final' => $hora_final,
                    'fecha'=> $fecha,
                    'id'=>$id_horario
            );
        }

            return view('agendar.clase_personalizada.planilla')->with(['clases_personalizadas' => ClasePersonalizada::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'config_especialidades' => ConfigEspecialidades::all(), 'instructores' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get(), 'clasepersonalizada' => $clase_personalizada_join, 'arrayHorario' => $arrayHorario]);

        }else{
           return redirect("agendar/clases-personalizadas"); 
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */


    public function storeInscripcion(Request $request)
    {

    $rules = [

        'clase_personalizada_id' => 'required',
        'alumno_id' => 'required',
        'fecha' => 'required',
        'hora_inicio' => 'required',
        'hora_final' => 'required',
        'especialidad_id' => 'required',
        'instructor_id' => 'required',
        'estudio_id' => 'required',
        
    ];

    $messages = [
        'clase_personalizada_id.required' => 'Ups! El Nombre es requerido',
        'alumno_id.required' => 'Ups! El Alumno es requerido',
        'fecha.required' => 'Ups! La fecha es requerida',
        'instructor_id.required' => 'Ups! El instructor es requerido',
        'hora_inicio.required' => 'Ups! La hora de inicio es requerida',
        'hora_final.required' => 'Ups! La hora final es requerida',
        'especialidad_id.required' => 'Ups! La especialidad es requerida ',
        'estudio_id.required' => 'Ups! El estudio o salón es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $hora_inicio = strtotime($request->hora_inicio);
        $hora_final = strtotime($request->hora_final);
        $fecha = explode(" - ", $request->fecha);

        $fecha_inicio = Carbon::createFromFormat('d/m/Y', $fecha[0]);
        $fecha_final = Carbon::createFromFormat('d/m/Y', $fecha[1]);

        if($hora_inicio > $hora_final)
        {

            return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
        }

        if($fecha_inicio < Carbon::now()){

            return response()->json(['errores' => ['fecha' => [0, 'Ups! ha ocurrido un error. La fecha de la clase no puede ser menor al dia de hoy']], 'status' => 'ERROR'],422);
        }

        $clasepersonalizada = new InscripcionClasePersonalizada;
        $clase_personalizada = ClasePersonalizada::find($request->clase_personalizada_id);
        
        $fecha_inicio = $fecha_inicio->toDateString();
        $fecha_final = $fecha_final->toDateString();

        $clasepersonalizada->clase_personalizada_id =  $request->clase_personalizada_id;
        $clasepersonalizada->fecha_inicio = $fecha_inicio;
        $clasepersonalizada->fecha_final = $fecha_final;
        $clasepersonalizada->instructor_id = $request->instructor_id;
        $clasepersonalizada->hora_inicio = $request->hora_inicio;
        $clasepersonalizada->hora_final = $request->hora_final;
        $clasepersonalizada->alumno_id = $request->alumno_id;
        $clasepersonalizada->especialidad_id = $request->especialidad_id;
        $clasepersonalizada->estudio_id = $request->estudio_id;
        $clasepersonalizada->promotor_id =  $request->promotor_id;
        $clasepersonalizada->cantidad_horas =  $clase_personalizada->cantidad_horas;

        // return redirect("/home");
        if($clasepersonalizada->save()){

            $visitante = Visitante::where('alumno_id', $request->alumno_id)->first();

            if($visitante){
                $visitante->cliente = 1;
                $visitante->save();
            }
            
            if($request->precio_id)
            {
                $precio_id = explode("-", $request->precio_id);

                if($precio_id[0] == '1'){
                    $costo = $clase_personalizada->costo;
                }else{
                    $costo_clases_personalizadas = CostoClasePersonalizada::find($precio_id[1]);
                    $costo = $costo_clases_personalizadas->precio;
                }
            }else{
                $costo = $clase_personalizada->costo;
            }

            $item_factura = new ItemsFacturaProforma;
                    
            $item_factura->alumno_id = $request->alumno_id;
            $item_factura->academia_id = Auth::user()->academia_id;
            $item_factura->fecha = Carbon::now()->toDateString();
            $item_factura->item_id = $clasepersonalizada->id;
            $item_factura->nombre = $clase_personalizada->nombre;
            $item_factura->tipo = 9;
            $item_factura->cantidad = 1;
            $item_factura->precio_neto = 0;
            $item_factura->impuesto = 0;
            $item_factura->importe_neto = $costo;
            $item_factura->fecha_vencimiento = Carbon::now()->toDateString();

            $item_factura->save();

            $academia = Academia::find(Auth::user()->academia_id);
            $alumno = Alumno::find($request->alumno_id);
            $instructor = Instructor::find($request->instructor_id);

            $subj = 'Te han asignado una Clase Personalizada';
            $subj2 = 'Has confirmado una Clase Personalizada';

            $array = [
               'nombre_instructor' => $instructor->nombre,
               'correo' => $instructor->correo,
               'academia' => $academia->nombre,
               'nombre_alumno' => $alumno->nombre,
               'apellido_alumno' => $alumno->apellido,
               'hora_inicio' => $request->hora_inicio,
               'hora_final' => $request->hora_final,
               'fecha' => $fecha_inicio,
               'subj' => $subj
            ];

            $array2 = [
               'nombre_instructor' => $instructor->nombre,
               'apellido_instructor' => $instructor->apellido,
               'correo' => $alumno->correo,
               'academia' => $academia->nombre,
               'nombre_alumno' => $alumno->nombre,
               'hora_inicio' => $request->hora_inicio,
               'hora_final' => $request->hora_final,
               'fecha' => $fecha_inicio,
               'subj' => $subj2,
               'id' => $clasepersonalizada->id
            ];

            Mail::send('correo.clase_personalizada_instructor', $array, function($msj) use ($array){
                $msj->subject($array['subj']);
                $msj->to($array['correo']);
            });

            Mail::send('correo.clase_personalizada_alumno', $array2, function($msj) use ($array2){
                $msj->subject($array2['subj']);
                $msj->to($array2['correo']);
            });

            Session::forget('id_alumno');

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'id' => $request->alumno_id, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */

    public function cancelar(Request $request)
    {

        if($request->tipo == 1){

            $inscripcion_clase_personalizada = InscripcionClasePersonalizada::find($request->clasepersonalizada_id);
            $id = $inscripcion_clase_personalizada->id;

            $clasepersonalizada = ClasePersonalizada::find($inscripcion_clase_personalizada->clase_personalizada_id);

            $hora_string = $inscripcion_clase_personalizada->fecha_inicio . ' ' . $inscripcion_clase_personalizada->hora_inicio;
        }else{
            $inscripcion_clase_personalizada = HorarioClasePersonalizada::find($request->clasepersonalizada_id);

            $tmp = InscripcionClasePersonalizada::find($inscripcion_clase_personalizada->clase_personalizada_id);

            $id = $tmp->id;

            $clasepersonalizada = ClasePersonalizada::find($tmp->clase_personalizada_id);

            $hora_string = $inscripcion_clase_personalizada->fecha . ' ' . $inscripcion_clase_personalizada->hora_inicio;
        }

        
        
        $hora = Carbon::createFromFormat('Y-m-d H:i:s', $hora_string);
        $hora_limite = $hora->subHours($clasepersonalizada->tiempo_expiracion);

        if(Carbon::now() < $hora_limite)
        {
            $item_proforma = ItemsFacturaProforma::where('tipo', 9)->where('item_id', $id)->first();

            if($item_proforma){
                if($item_proforma->delete()){

                    $inscripcion_clase_personalizada->estatus = 0;
                    $inscripcion_clase_personalizada->razon_cancelacion = $request->razon_cancelacion;
                    
                    if($inscripcion_clase_personalizada->save()){
                        return response()->json(['mensaje' => '¡Excelente! La Clase Personalizada se ha cancelado satisfactoriamente', 'status' => 'OK', 200]);
                    }else{
                        return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                    }
                }
            }else{
                    $inscripcion_clase_personalizada->estatus = 0;
                    $inscripcion_clase_personalizada->razon_cancelacion = $request->razon_cancelacion;
                    
                    if($inscripcion_clase_personalizada->save()){
                        return response()->json(['mensaje' => '¡Excelente! La Clase Personalizada se ha cancelado satisfactoriamente', 'status' => 'OK', 200, 'id' => $inscripcion_clase_personalizada->id]);
                    }else{
                        return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                    }
            }
        }else{
            return response()->json(['error_mensaje'=> 'Ups! Esta clase personalizada no puede ser cancelada ya que posee cancelaciòn tardia' , 'status' => 'ERROR-BORRADO'],422);
        }
    }

    public function cancelarpermitir(Request $request)
    {
        if($request->tipo == 1){

            $inscripcion_clase_personalizada = InscripcionClasePersonalizada::find($request->clasepersonalizada_id);

        }else{
            $inscripcion_clase_personalizada = HorarioClasePersonalizada::find($request->clasepersonalizada_id);
        }

        $inscripcion_clase_personalizada->estatus = 0;
        $inscripcion_clase_personalizada->razon_cancelacion = $request->razon_cancelacion;
            
        if($inscripcion_clase_personalizada->save()){
            return response()->json(['mensaje' => '¡Excelente! La Clase Personalizada se ha cancelado satisfactoriamente', 'status' => 'OK', 'id' => $inscripcion_clase_personalizada->id, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function progreso($id)
    {

        $clase_personalizada = DB::table('inscripcion_clase_personalizada')
            ->join('clases_personalizadas', 'inscripcion_clase_personalizada.clase_personalizada_id', '=', 'clases_personalizadas.id')
            ->join('instructores', 'inscripcion_clase_personalizada.instructor_id', '=', 'instructores.id')
            ->join('config_especialidades', 'inscripcion_clase_personalizada.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_estudios', 'inscripcion_clase_personalizada.estudio_id', '=', 'config_estudios.id')
            ->select('instructores.nombre as instructor_nombre' , 'instructores.apellido as instructor_apellido', 'config_especialidades.nombre as especialidad_nombre', 'inscripcion_clase_personalizada.hora_inicio', 'inscripcion_clase_personalizada.hora_final', 'inscripcion_clase_personalizada.fecha_inicio', 'clases_personalizadas.academia_id', 'config_estudios.nombre as estudio_nombre', 'clases_personalizadas.imagen', 'clases_personalizadas.descripcion')
            ->where('inscripcion_clase_personalizada.id', $id)
        ->first();


        $academia = Academia::find($clase_personalizada->academia_id);


        $config_clase_personalizada = ConfigClasesPersonalizadas::where('academia_id', $id)->first();

        if(!$config_clase_personalizada)
        {
            $config_clase_personalizada = new ConfigClasesPersonalizadas;

            $config_clase_personalizada->academia_id = Auth::user()->academia_id;
            $config_clase_personalizada->imagen_principal = '';
            $config_clase_personalizada->descripcion = '';
            $config_clase_personalizada->video_promocional = '';
            $config_clase_personalizada->imagen1 = '';
            $config_clase_personalizada->imagen2 = '';
            $config_clase_personalizada->imagen3 = '';
            $config_clase_personalizada->ventajas = '';
            $config_clase_personalizada->condiciones = '';

            $config_clase_personalizada->save();
            
        }


        if($config_clase_personalizada->video_promocional){

            $parts = parse_url($config_clase_personalizada->video_promocional);
            $partes = explode( '=', $parts['query'] );
            $link_video = $partes[1];

            }
            else{
                $link_video = '';
            }

        return view('agendar.clase_personalizada.promocionar')->with(['link_video' => $link_video, 'academia' => $academia, 'id' => $id, 'clase_personalizada' => $clase_personalizada, 'config_clase_personalizada' => $config_clase_personalizada]);
    }

    public function aceptarcondiciones($id)
    {
        $clasepersonalizada = InscripcionClasePersonalizada::find($id);
        $clasepersonalizada->boolean_alumno_aceptacion = 1;
        
        if($clasepersonalizada->save()){
            return response()->json(['mensaje' => '¡Excelente! La Clase Personalizada se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function destroy($id)
    {
        $clasepersonalizada = InscripcionClasePersonalizada::find($id);
        
        if($clasepersonalizada->delete()){
            return response()->json(['mensaje' => '¡Excelente! La Clase Personalizada se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function agenda($id){

        $clase = InscripcionClasePersonalizada::join('clases_personalizadas', 'inscripcion_clase_personalizada.clase_personalizada_id', '=', 'clases_personalizadas.id')
            ->join('instructores', 'inscripcion_clase_personalizada.instructor_id', '=', 'instructores.id')
            ->join('config_especialidades', 'inscripcion_clase_personalizada.especialidad_id', '=', 'config_especialidades.id')
            ->select('inscripcion_clase_personalizada.*', 'clases_personalizadas.nombre', 'clases_personalizadas.descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'config_especialidades.nombre as especialidad', 'clases_personalizadas.cantidad_horas as horas_asignadas')
            ->where('inscripcion_clase_personalizada.id', '=' ,  $id)
        ->first();

        $horarios = InscripcionClasePersonalizada::join('clases_personalizadas', 'inscripcion_clase_personalizada.clase_personalizada_id', '=', 'clases_personalizadas.id')
            ->join('horarios_clases_personalizadas', 'inscripcion_clase_personalizada.id', '=', 'horarios_clases_personalizadas.clase_personalizada_id')
            ->join('instructores', 'horarios_clases_personalizadas.instructor_id', '=', 'instructores.id')
            ->join('config_especialidades', 'horarios_clases_personalizadas.especialidad_id', '=', 'config_especialidades.id')
            ->select('inscripcion_clase_personalizada.*', 'clases_personalizadas.nombre', 'clases_personalizadas.descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'config_especialidades.nombre as especialidad', 'horarios_clases_personalizadas.fecha', 'horarios_clases_personalizadas.id', 'horarios_clases_personalizadas.estatus', 'horarios_clases_personalizadas.hora_inicio', 'horarios_clases_personalizadas.hora_final')
            ->where('inscripcion_clase_personalizada.id', '=' ,  $id)
        ->get();

        $activas = array();
        $finalizadas = array();
        $canceladas = array();
        $i = 0;
        $horas_restantes = 0;

        $nombre = $clase->nombre;
        $horas_asignadas = $clase->horas_asignadas;
 
        $fecha_start=explode('-',$clase->fecha_inicio);
        $fecha_end=explode('-',$clase->fecha_final);

        $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
        $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

        $hora_inicio=$clase->hora_inicio;
        $hora_final=$clase->hora_final;
        $instructor = $clase->instructor_nombre . ' ' .$clase->instructor_apellido;

        $hie = explode(':',$hora_inicio);
        $hora_inicio = Carbon::createFromTime($hie[0], $hie[1], '00');

        $hfe = explode(':',$hora_final);
        $hora_final = Carbon::createFromTime($hfe[0], $hfe[1], '00');

        $hora_asignada = $hora_inicio->diffInHours($hora_final);
        $horas_restantes = $horas_restantes + $hora_asignada;

        if($clase->estatus != 0){

            if($dt >= Carbon::now()){
                $activas[]=array("id" => $clase->id, "fecha_inicio"=>$dt->toDateString(), "hora_inicio"=>$clase->hora_inicio, 'hora_final'=>$clase->hora_final, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido, 'tipo' => 1, 'hora_asignada' => $hora_asignada);
                $i++;
            }else{
                $finalizadas[]=array("id" => $clase->id,"fecha_inicio"=>$dt->toDateString(), "hora_inicio"=>$clase->hora_inicio, 'hora_final'=>$clase->hora_final, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido, 'tipo' => 1, 'hora_asignada' => $hora_asignada);
                $i++;
            }
        }else{
            $canceladas[]=array("id" => $clase->id,"fecha_inicio"=>$dt->toDateString(), "hora_inicio"=>$clase->hora_inicio, 'hora_final'=>$clase->hora_final, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido, 'tipo' => 1, 'hora_asignada' => $hora_asignada);
                $i++;
        }

        foreach ($horarios as $clase) {

            $fecha_start=explode('-',$clase->fecha);
            $fecha_end=explode('-',$clase->fecha);

            $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
            $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

            $hora_inicio=$clase->hora_inicio;
            $hora_final=$clase->hora_final;
            $instructor = $clase->instructor_nombre . ' ' .$clase->instructor_apellido;

            $hie = explode(':',$hora_inicio);
            $hora_inicio = Carbon::createFromTime($hie[0], $hie[1], '00');

            $hfe = explode(':',$hora_final);
            $hora_final = Carbon::createFromTime($hfe[0], $hfe[1], '00');

            $hora_asignada = $hora_inicio->diffInHours($hora_final);

            $horas_restantes = $horas_restantes + $hora_asignada;

            if($clase->estatus != 0){
        
                if($dt >= Carbon::now()){
                    $activas[]=array("id" => $clase->id,"fecha_inicio"=>$dt->toDateString(), "hora_inicio"=>$clase->hora_inicio, 'hora_final'=>$clase->hora_final, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido, 'tipo' => 2, 'hora_asignada' => $hora_asignada);
                    $i++;
                }else{
                    $finalizadas[]=array("id" => $clase->id,"fecha_inicio"=>$dt->toDateString(), "hora_inicio"=>$clase->hora_inicio, 'hora_final'=>$clase->hora_final, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido, 'tipo' => 2, 'hora_asignada' => $hora_asignada);
                    $i++;
                }

            }else{
                $canceladas[]=array("id" => $clase->id,"fecha_inicio"=>$dt->toDateString(), "hora_inicio"=>$clase->hora_inicio, 'hora_final'=>$clase->hora_final, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido, 'tipo' => 2, 'hora_asignada' => $hora_asignada);
                $i++;
            }

        }

        $horas_restantes = $horas_restantes - $horas_asignadas;

        return view('agendar.clase_personalizada.agenda')->with(['activas' => $activas, 'finalizadas' => $finalizadas, 'canceladas' => $canceladas, 'nombre' => $nombre, 'id' => $id, 'horas_restantes' => $horas_restantes, 'horas_asignadas' => $horas_asignadas]);
    }

}