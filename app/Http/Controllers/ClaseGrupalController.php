<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\ClaseGrupal;
use App\Factura;
use App\ItemsFactura;
use App\Alumno;
use App\Academia;
use App\Cuotas;
use App\DiasDeSemana;
use App\ConfigEstudios;
use App\ConfigEspecialidades;
use App\ConfigClasesGrupales;
use App\ConfigNiveles;
use App\Instructor;
use App\InscripcionClaseGrupal;
use App\ItemsFacturaProforma;
use Carbon\Carbon;
use Validator;
use DB;
use Mail;
use Session;
use Illuminate\Support\Facades\Auth;
use Image;

class ClaseGrupalController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function principal(){

        $clase_grupal_join = DB::table('clases_grupales')
            ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.id', 'clases_grupales.fecha_inicio')
            ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
            ->where('clases_grupales.deleted_at', '=', null)
            ->OrderBy('clases_grupales.hora_inicio')
        ->get();

        $array = array();

        foreach($clase_grupal_join as $clase_grupal){
            $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
            $dia_de_semana = $fecha->dayOfWeek;

            // switch($dia){
            //     case 1:
            //         $dia_de_semana = 'Lunes';
            //     break;

            //     case 2:
            //         $dia_de_semana = 'Martes';
            //     break;

            //     case 3:
            //         $dia_de_semana = 'Miercoles';
            //     break;

            //     case 4:
            //         $dia_de_semana = 'Jueves';
            //     break;

            //     case 5:
            //         $dia_de_semana = 'Viernes';
            //     break;

            //     case 6:
            //         $dia_de_semana = 'Sabado';
            //     break;

            //     case 7:
            //         $dia_de_semana = 'Domingo';
            //     break;
            // }

            $collection=collect($clase_grupal);     
            $clase_grupal_array = $collection->toArray();
            
            $clase_grupal_array['dia_de_semana']=$dia_de_semana;
            $array[$clase_grupal->id] = $clase_grupal_array;
        }
        
        return view('agendar.clase_grupal.principal')->with(['clase_grupal_join' => $array]);
    }

    public function index()
    {
        // $clases_grupales_join = ClaseGrupal::table('clases_grupales')
        //     ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
        //     ->select('config_clases_grupales.*')
        //     ->get();

        $clase_grupal_join = DB::table('clases_grupales')
            ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.id')
            ->get();

        $alumnosclasegrupal = DB::table('alumnos')
                ->join('inscripcion_clase_grupal', 'alumnos.id', '=', 'inscripcion_clase_grupal.alumno_id')
                ->join('clases_grupales', 'clases_grupales.id', '=', 'inscripcion_clase_grupal.clase_grupal_id')
                ->select('alumnos.nombre', 'alumnos.apellido', 'alumnos.telefono', 'alumnos.id', 'alumnos.identificacion', 'alumnos.sexo')
                ->get();

            //dd($clase_grupal_join);

        return view('agendar.clase_grupal.index')->with(['clase_grupal' => ClaseGrupal::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'config_clases_grupales' => ConfigClasesGrupales::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'config_especialidades' => ConfigEspecialidades::all(), 'config_estudios' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'config_niveles' => ConfigNiveles::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->get(), 'instructor' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'alumno' => Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get(),'alumnosclasegrupal' => $alumnosclasegrupal, 'clase_grupal_join' => $clase_grupal_join]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function inscribir($id)
    {
        $clasegrupal = DB::table('config_clases_grupales')
                ->join('clases_grupales', 'config_clases_grupales.id', '=', 'clases_grupales.clase_grupal_id')
                ->select('config_clases_grupales.*', 'clases_grupales.fecha_inicio_preferencial')
                ->where('clases_grupales.id', '=', $id)
                ->where('clases_grupales.deleted_at', '=', null)
        ->first();

        return view('agendar.clase_grupal.inscripcion')->with(['alumno' => Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'id' => $id, 'clasegrupal' => $clasegrupal]);
    }

    public function participantes($id)
    {
        // $clasegrupal = ClaseGrupal::find($id);

        $clasegrupal = DB::table('config_clases_grupales')
                ->join('clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('config_clases_grupales.*', 'clases_grupales.fecha_inicio_preferencial', 'clases_grupales.fecha_inicio')
                ->where('clases_grupales.id', '=', $id)
        ->first();

        $alumnos_inscritos = DB::table('inscripcion_clase_grupal')
                ->join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
                ->select('alumnos.*', 'inscripcion_clase_grupal.fecha_pago', 'inscripcion_clase_grupal.costo_mensualidad', 'inscripcion_clase_grupal.id as inscripcion_id')
                ->where('inscripcion_clase_grupal.clase_grupal_id', '=', $id)
                ->where('inscripcion_clase_grupal.deleted_at', '=', null)
        ->get();

        // $alumnos = DB::table('alumnos')
        //         ->select('alumnos.*')
        // ->get();

        // dd($alumnos_inscritos);

        $alumnos = Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

        // for($i=0; $i<=count($alumnos_inscritos) - 1; $i++) {
        //     for($j=0; $j<=count($alumnos) - 1; $j++) {
        //         if($alumnos[$j]['id'] == $alumnos_inscritos[$i]->id){
        //             $alumnos[$j]->setAttribute('inscrito', 'inscrito');
        //         }
        //     }
        // }

        return view('agendar.clase_grupal.participantes')->with(['alumnos_inscritos' => $alumnos_inscritos, 'id' => $id, 'clasegrupal' => $clasegrupal, 'alumnos' => $alumnos]);
    }

    public function eliminarinscripcion($id)
    {
        // $inscripcion = InscripcionClaseGrupal::find($id);
        $inscripcion = InscripcionClaseGrupal::find($id);
        
        if($inscripcion->delete()){
            return response()->json(['mensaje' => '¡Excelente! La Clase Grupal se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

    public function progreso($id)
    {

        $clase_grupal_join = DB::table('clases_grupales')
            ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->join('academias', 'clases_grupales.academia_id', '=', 'academias.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.id', 'clases_grupales.cupo_reservacion', 'clases_grupales.fecha_inicio', 'clases_grupales.imagen', 'config_clases_grupales.descripcion', 'academias.imagen as imagen_academia', 'clases_grupales.link_video', 'config_clases_grupales.condiciones', 'academias.direccion', 'academias.estado', 'academias.facebook', 'academias.twitter', 'academias.instagram', 'academias.linkedin', 'academias.youtube', 'academias.pagina_web', 'academias.nombre as academia_nombre', 'academias.id as academia_id', 'config_clases_grupales.costo_inscripcion', 'config_clases_grupales.costo_mensualidad')
            ->where('clases_grupales.id','=', $id)
        ->first();

        $fecha_inicio = Carbon::createFromFormat('Y-m-d', $clase_grupal_join->fecha_inicio);

        if(Carbon::now() > $fecha_inicio){
            $inicio = 1;
        }else{
            $inicio = 0;
        }

        $academia = Academia::find($clase_grupal_join->academia_id);

        if($clase_grupal_join->link_video){

            $parts = parse_url($clase_grupal_join->link_video);
            $partes = explode( '=', $parts['query'] );
            $link_video = $partes[1];

            }
            else{
                $link_video = '';
            }

         $cantidad_reservaciones = DB::table('reservaciones')
             ->select('reservaciones.*')
             ->where('tipo_id', '=', $id)
             ->where('tipo_reservacion', '=', 1)
         ->count();

         if($clase_grupal_join->cupo_reservacion == 0){
            $cupo_reservacion = 1;
         }
         else{
            $cupo_reservacion = $clase_grupal_join->cupo_reservacion;
         }

         $cupos_restantes = $cupo_reservacion - $cantidad_reservaciones;

         if($cupos_restantes < 0){
            $cupos_restantes = 0;
         }

        $porcentaje = intval(($cantidad_reservaciones / $cupo_reservacion) * 100);

        if(Auth::check()){

            $usuario_tipo = Auth::user()->usuario_tipo;

        }else{
            $usuario_tipo = 0;
        
        }

        return view('agendar.clase_grupal.reserva')->with(['clase_grupal' => $clase_grupal_join, 'id' => $id, 'porcentaje' => $porcentaje, 'link_video' => $link_video, 'academia' => $academia, 'cupos_restantes' => $cupos_restantes, 'usuario_tipo' => $usuario_tipo, 'inicio' => $inicio]);
    }

    public function create()
    {
        if (Session::has('horario')) {
            Session::forget('horario'); 
        }

        return view('agendar.clase_grupal.create')->with(['config_clases_grupales' => ConfigClasesGrupales::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'dias_de_semana' => DiasDeSemana::all(), 'config_especialidades' => ConfigEspecialidades::all(), 'config_estudios' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'config_niveles' => ConfigNiveles::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->get() , 'instructores' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get()]);
    }

    public function agregarhorario(Request $request){
        
    $rules = [

        'instructor_acordeon_id' => 'required',
        'especialidad_acordeon_id' => 'required',
        'dia_de_semana_id' => 'required',
        'hora_inicio_acordeon' => 'required',
        'hora_final_acordeon' => 'required',
    ];

    $messages = [

        'instructor_acordeon_id.required' => 'Ups! El Instructor es requerido',
        'dia_de_semana_id.required' => 'Ups! El Dia es requerido',
        'especialidad_acordeon_id.required' => 'Ups! La Especialidad es requerida',
        'hora_inicio_acordeon.required' => 'Ups! La hora de inicio es requerida',
        'hora_final_acordeon.required' => 'Ups! La hora final es requerida',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{


        $find = Instructor::find($request->instructor_acordeon_id);
        $instructor = $find->nombre . " " . $find->apellido;

        $find = DiasDeSemana::find($request->instructor_acordeon_id);
        $dia_de_semana = $find->nombre;

        $find = ConfigEspecialidades::find($request->instructor_acordeon_id);
        $especialidad = $find->nombre;
 

        $array = array(['instructor' => $instructor , 'dia_de_semana' => $dia_de_semana, 'especialidad' => $especialidad, 'hora_inicio' => $request->hora_inicio_acordeon, 'hora_final' => $request->hora_final_acordeon]);

        Session::push('horario', $array);

        $contador = count(Session::get('horario'));
        $contador = $contador - 1;

         return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'id' => $contador, 200]);

    }
    }

    public function eliminarhorario($id){

        $arreglo = Session::get('horario');

        // unset($arreglo[$id]);
        unset($arreglo[$id]);
        Session::forget('horario');
        Session::push('horario', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

    $rules = [
        'clase_grupal_id' => 'required',
        'fecha' => 'required',
        'hora_inicio' => 'required',
        'hora_final' => 'required',
        'color_etiqueta' => 'required',
        'especialidad_id' => 'required',
        'nivel_baile_id' => 'required',
        'instructor_id' => 'required',
        'estudio_id' => 'required',
        'cupo_minimo' => 'required|numeric',
        'cupo_maximo' => 'required|numeric',
        'cupo_reservacion' => 'required|numeric',
        

    ];

    $messages = [

        'clase_grupal_id.required' => 'Ups! El Nombre  es requerido',
        'fecha.required' => 'Ups! La fecha es requerida',
        'hora_inicio.required' => 'Ups! La hora de inicio es requerida',
        'hora_final.required' => 'Ups! La hora final es requerida',
        'color_etiqueta.required' => 'Ups! La etiqueta es requerida',
        'especialidad_id.required' => 'Ups! La especialidad es requerida ',
        'nivel_baile_id.required' => 'Ups! El nivel de baile es requerido ',
        'instructor_id.required' => 'Ups! El instructor es requerido',
        'estudio_id.required' => 'Ups! El estudio o salón es requerido',
        'cupo_minimo.required' => 'Ups! La cantidad de cupos es requerida',
        'cupo_maximo.required' => 'Ups! La cantidad de cupos es requerida',
        'cupo_reservacion.required' => 'Ups! La cantidad de cupos de reservacion es requerida',
        'cupo_minimo.numeric' => 'Ups! La cantidad de cupos es inválido , debe contener sólo números',
        'cupo_maximo.numeric' => 'Ups! La cantidad de cupos es inválido , debe contener sólo números',
        'cupo_reservacion.numeric' => 'Ups! La cantidad de cupos es inválido , debe contener sólo números',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

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

        $fecha = explode(" - ", $request->fecha);

        $fecha_inicio = Carbon::createFromFormat('d/m/Y', $fecha[0]);
        $fechatmp = Carbon::createFromFormat('d/m/Y', $fecha[0]);
        $fecha_final = Carbon::createFromFormat('d/m/Y', $fecha[1]);

        // $diferencia = $fecha_inicio->diffInDays($fecha_final)->format('%d');

        $diferencia = $fecha_inicio->diffInDays($fecha_final);

        // if($diferencia > 30)
        // {
        $fecha_inicio_preferencial = $fechatmp->addMonth()->toDateString();

        // }else{

        //     $fecha_inicio_preferencial = "0000-00-00";

        // }

        if($fecha_inicio < Carbon::now()){

            return response()->json(['errores' => ['fecha' => [0, 'Ups! ha ocurrido un error. La fecha de inicio no puede ser menor al dia de hoy']], 'status' => 'ERROR'],422);
        }

        $fecha_inicio = $fecha_inicio->toDateString();
        $fecha_final = $fecha_final->toDateString();


        // if($fecha_inicio > $fecha_final)
        // {
        //     return response()->json(['errores' => ['fecha' => [0, 'Ups! La fecha de inicio es mayor a la fecha final']], 'status' => 'ERROR'],422);
        // }

        $hora_inicio = strtotime($request->hora_inicio);
        $hora_final = strtotime($request->hora_final);

        if($hora_inicio > $hora_final)
        {

            return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
        }


        // $fecha_inicio_preferencial = Carbon::createFromFormat('d/m/Y', $request->fecha_inicio_preferencial)->toDateString();

        //     if($fecha_inicio_preferencial < $fecha_inicio)
        //     {
        //         return response()->json(['errores' => ['fecha_inicio_preferencial' => [0, 'Ups! La fecha de primer cobro automático es menor a la fecha de inicio']], 'status' => 'ERROR'],422);
        //     }
        //     else{
        //         if( $fecha_inicio_preferencial > $fecha_final)
        //             {
        //                 return response()->json(['errores' => ['fecha_inicio_preferencial' => [0, 'Ups! La fecha de primer cobro automático es mayor a la fecha final']], 'status' => 'ERROR'],422);
        //             }
        // }

        if($request->cupo_minimo > $request->cupo_maximo)
        {

            return response()->json(['errores' => ['cupo_minimo' => [0, 'Ups! El cupo minimo es mayor al cupo maximo']], 'status' => 'ERROR'],422);
        }

        $clasegrupal = new ClaseGrupal;
        
        $clasegrupal->academia_id = Auth::user()->academia_id;
        $clasegrupal->clase_grupal_id = $request->clase_grupal_id;
        $clasegrupal->fecha_inicio = $fecha_inicio;
        $clasegrupal->fecha_final = $fecha_final;
        $clasegrupal->fecha_inicio_preferencial = $fecha_inicio_preferencial;
        $clasegrupal->especialidad_id = $request->especialidad_id;
        $clasegrupal->instructor_id = $request->instructor_id;
        $clasegrupal->estudio_id = $request->estudio_id;
        $clasegrupal->hora_inicio = $request->hora_inicio;
        $clasegrupal->hora_final = $request->hora_final;
        $clasegrupal->color_etiqueta = $request->color_etiqueta;
        $clasegrupal->nivel_baile_id = $request->nivel_baile_id;
        $clasegrupal->cupo_minimo = $request->cupo_minimo;
        $clasegrupal->cupo_maximo = $request->cupo_maximo;
        $clasegrupal->cupo_reservacion = $request->cupo_reservacion;
        $clasegrupal->link_video = $request->link_video;
        // $clasegrupal->cantidad_hombres = $request->cantidad_hombre;
        // $clasegrupal->cantidad_mujeres = $request->cantidad_mujer;

        if($clasegrupal->save()){

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

                $nombre_img = "clasegrupal-". $clasegrupal->id . $extension;
                $image = base64_decode($base64_string);

                // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
                $img = Image::make($image)->resize(1440, 500);
                $img->save('assets/uploads/clase_grupal/'.$nombre_img);

                $clasegrupal->imagen = $nombre_img;
                $clasegrupal->save();

            }

            $academia = Academia::find(Auth::user()->academia_id);
            $instructor = Instructor::find($request->instructor_id);
            $clase_grupal = ConfigClasesGrupales::find($request->clase_grupal_id);

            $subj = 'Te han asignado una Clase Grupal';

            $array = [

               'nombre_clase' => $clase_grupal->nombre,
               'nombre_instructor' => $instructor->nombre,
               'correo' => $instructor->correo,
               'academia' => $academia->nombre,
               'hora_inicio' => $request->hora_inicio,
               'hora_final' => $request->hora_final,
               'fecha' => $fecha_inicio,
               'subj' => $subj
            ];

            /*Mail::send('correo.clase_grupal_instructor', $array, function($msj) use ($array){
                    $msj->subject($array['subj']);
                    $msj->to($array['correo']);
                });*/
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function storeInscripcion(Request $request)
    {

    Session::forget('id_alumno');

    $rules = [
        'clase_grupal_id' => 'required',
        'alumno_id' => 'required',
        'costo_inscripcion' => 'required|numeric',
        'costo_mensualidad' => 'required|numeric',
        'fecha_pago' => 'required',
    ];

    $messages = [

        'clase_grupal_id.required' => 'Ups! El Nombre  es requerido',
        'alumno_id.required' => 'Ups! El Alumno es requerido',
        'costo_inscripcion.required' => 'Ups! El costo de la inscripción es requerido',
        'costo_mensualidad.required' => 'Ups! El costo de la mensualidad es requerida',
        'costo_inscripcion.numeric' => 'Ups! El campo del costo de la inscripcion en inválido , debe contener sólo números',
        'costo_mensualidad.numeric' => 'Ups! El campo del costo de la mensualidad en inválido , debe contener sólo números',        
        'fecha_pago.required' => 'Ups! La fecha de pago es requerida',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $alumnosclasegrupal = InscripcionClaseGrupal::where('alumno_id', $request->alumno_id)->where('clase_grupal_id', $request->clase_grupal_id)->first();

        // comprobar si esta inscrito
        if(!$alumnosclasegrupal){ 

            // $clasegrupal = ClaseGrupal::find($request->clase_grupal_id);

            // $count = DB::table('inscripcion_clase_grupal')
            //     ->select('inscripcion_clase_grupal.*')
            //     ->where('inscripcion_clase_grupal.clase_grupal_id', '=', $request->clase_grupal_id)
            //     ->count();

            // $estudio = DB::table('config_estudios')
            //     ->join('clases_grupales', 'config_estudios.id', '=', 'clases_grupales.estudio_id')
            //     ->select('config_estudios.capacidad')
            //     ->where('clases_grupales.id', '=', $request->clase_grupal_id)
            // ->first();

            // if($estudio->capacidad - $clasegrupal->cantidad_reservaciones <= $count){
            //     return response()->json(['errores'=>'CAPACIDAD LLENA', 'status' => 'ERROR-SERVIDOR'],422);
            // }

            // if($clasegrupal->cantidad_hombres >= 0){

            //     $hombres = DB::table('inscripcion_clase_grupal')
            //     ->join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
            //     ->select('inscripcion_clase_grupal.*')
            //     ->where('inscripcion_clase_grupal.clase_grupal_id', '=', $request->clase_grupal_id)
            //     ->where('alumnos.sexo', '=', 'M')
            //     ->count();
            //     if($clasegrupal->cantidad_hombres <= $hombres){
            //         return response()->json(['errores'=>'Cantidad Hombres Llena', 'status' => 'ERROR-SERVIDOR'],422);
            //     }
            // }

            // if($clasegrupal->cantidad_mujeres >= 0){

            //     $mujeres = DB::table('inscripcion_clase_grupal')
            //     ->join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
            //     ->select('inscripcion_clase_grupal.*')
            //     ->where('inscripcion_clase_grupal.clase_grupal_id', '=', $request->clase_grupal_id)
            //     ->where('alumnos.sexo', '=', 'F')
            //     ->count();

            //     if($clasegrupal->cantidad_hombres <= $mujeres){
            //         return response()->json(['errores'=>'Cantidad Mujeres Llena', 'status' => 'ERROR-SERVIDOR'],422);
            //     }
            // }

            // $alumnos = explode('-',$request->alumno_id);

            $fecha_pago = trim($request->fecha_pago);
            $proxima_fecha = Carbon::createFromFormat('d/m/Y', $fecha_pago);
            // $proxima_fecha = $proxima_fecha->addMonth();
            $proxima_fecha = $proxima_fecha->toDateString();

            $clasegrupal = DB::table('config_clases_grupales')
                    ->join('clases_grupales', 'config_clases_grupales.id', '=', 'clases_grupales.clase_grupal_id')
                    ->select('config_clases_grupales.nombre', 'clases_grupales.fecha_inicio')
                    ->where('clases_grupales.id', '=', $request->clase_grupal_id)
                ->first();

             $array=array();

            // for($i = 1 ; $i<count($alumnos) ; $i++)
            // {
                $inscripcion = new InscripcionClaseGrupal;

                $inscripcion->clase_grupal_id = $request->clase_grupal_id;
                $inscripcion->alumno_id = $request->alumno_id;
                $inscripcion->fecha_pago = $proxima_fecha;
                $inscripcion->fecha_inscripcion = Carbon::now()->toDateString();
                $inscripcion->costo_mensualidad = $request->costo_mensualidad;

                $inscripcion->save();

                if($request->costo_inscripcion != 0)
                {

                    $item_factura = new ItemsFacturaProforma;
                        
                    $item_factura->alumno_id = $request->alumno_id;
                    $item_factura->academia_id = Auth::user()->academia_id;
                    $item_factura->fecha = Carbon::now()->toDateString();
                    $item_factura->item_id = $request->clase_grupal_id;
                    $item_factura->nombre = 'Inscripcion ' . $clasegrupal->nombre;
                    $item_factura->tipo = 3;
                    $item_factura->cantidad = 1;
                    $item_factura->precio_neto = 0;
                    $item_factura->impuesto = 0;
                    $item_factura->importe_neto = $request->costo_inscripcion;
                    $item_factura->fecha_vencimiento = $clasegrupal->fecha_inicio;
                        
                    $item_factura->save();

                }

                if($request->costo_mensualidad != 0)
                {

                    $item_factura = new ItemsFacturaProforma;
                        
                    $item_factura->alumno_id = $request->alumno_id;
                    $item_factura->academia_id = Auth::user()->academia_id;
                    $item_factura->fecha = Carbon::now()->toDateString();
                    $item_factura->item_id = $request->clase_grupal_id;
                    $item_factura->nombre = 'Cuota ' . $clasegrupal->nombre;
                    $item_factura->tipo = 4;
                    $item_factura->cantidad = 1;
                    $item_factura->precio_neto = 0;
                    $item_factura->impuesto = 0;
                    $item_factura->importe_neto = $request->costo_mensualidad;
                    $item_factura->fecha_vencimiento = $clasegrupal->fecha_inicio;
                        
                    $item_factura->save();

                }

                $alumno = Alumno::find($request->alumno_id);

                // $array[$i] = $alumno;

            // }

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'uno' => 'uno', 'id' => $alumno->id, 200]);

            // if(count($alumnos) > 2)
            // {
            //     return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 200]);
            // }
            // else{
            //     return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'uno' => 'uno', 'id' => $array[1]->id, 200]);
            // }

                // $config_clase_grupal = DB::table('config_clases_grupales')
                //     ->join('clases_grupales', 'config_clases_grupales.id', '=', 'clases_grupales.clase_grupal_id')
                //     ->select('config_clases_grupales.*')
                //     ->where('clases_grupales.id', '=', $request->clase_grupal_id)
                //     ->first();

                // if($config_clase_grupal->impuesto == 0)
                // {
                //     $precio_neto = $config_clase_grupal->costo_inscripcion;
                //     $impuesto = 0;
                // }

                // else{

                //     $academia = Academia::find(Auth::user()->academia_id);
                //     $iva = $config_clase_grupal->costo_inscripcion * ($academia->porcentaje_impuesto / 100);

                //     $precio_neto = $config_clase_grupal->costo_inscripcion - $iva;
                //     $impuesto = $academia->porcentaje_impuesto;

                // }

                // $numerofactura = DB::table('facturas')
                //     ->select('facturas.*')
                //     ->where('facturas.academia_id', '=', Auth::user()->academia_id)
                // ->count();


                // $factura = new Factura;

                // $factura->alumno_id = $request->alumno_id;
                // $factura->academia_id = Auth::user()->academia_id;
                // $factura->fecha = Carbon::now()->toDateString();
                // $factura->numero_factura = $numerofactura + 1;
               
                // if($factura->save()){
                
                //     $item_factura = new ItemsFactura;

                //     $item_factura->factura_id = $factura->id;
                //     $item_factura->item_id = 1;
                //     $item_factura->nombre = "Inscripcion";
                //     $item_factura->tipo = "servicio";
                //     $item_factura->cantidad = 1;
                //     $item_factura->precio_neto = $precio_neto;
                //     $item_factura->impuesto = $impuesto;
                //     $item_factura->importe_neto =  $config_clase_grupal->costo_inscripcion;

                //     if($item_factura->save())
                //     {

                //     // $clasegrupal = DB::table('clases_grupales') 
                //     // ->select('clases_grupales.*')
                //     // ->where('clases_grupales.id', '=', $request->clase_grupal_id)
                //     // ->first();

                //     // $fecha_final = Carbon::createFromFormat('Y-m-d' , $clasegrupal->fecha_final);

                //     // $partes = $fecha_final->diffInMonths(Carbon::now());

                //     // dd($request->fecha_pago_personalizada);

                //     // if(!$request->fecha_pago_personalizada){



                //     //     $fs=$request->fecha_pago_personalizada;
                //     // }
                //     // else{
                //     //     $fs = Carbon::createFromFormat('Y-m-d' , $config_clase_grupal->fecha_inicio_preferencial);
                //     // }

                //     // for($i=1; $i<=$partes; $i++) {


                //     //    // $fecha="";

                //     //     $fecha=$fs->addMonth()->toDateString();
                       
                //     //    // $ff = Carbon::createFromFormat('Y-m-d', $fs->toDateString())->format('d-m-Y');
                        
                //     //     $cuota = new Cuotas;

                //     //     $cuota->alumno_id = $request->alumno_id;
                //     //     $cuota->fecha = $ff;
                //     //     $cuota->descripcion = "Cuota " . $i . " " . $config_clase_grupal->nombre;
                //     //     $cuota->clase_grupal_id = $request->clase_grupal_id;
                        
                //     //     $cuota->save();
                //     // }

                //         return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
                //     }
            //         else{
            //             $destroy = Factura::find($factura->id);
            //             $destroy->delete();
            //             return response()->json(['errores'=>'error', 'status' => 'ERROR-FACTURAITEM'],422);
            //         }

            // }else{
            //     return response()->json(['errores'=>'error', 'status' => 'ERROR-FACTURA'],422);
            // }
    // }
    }else{

            return response()->json(['errores' => ['alumno_id' => [0, 'Ya este alumno esta inscrito']], 'status' => 'ERROR'],422);
        }
        }
    }

    public function storeInscripcionVistaAlumno(Request $request)
    {

        $alumnosclasegrupal = InscripcionClaseGrupal::where('alumno_id', Auth::user()->usuario_id)->where('clase_grupal_id', $request->clase_grupal_id)->first();

        if(!$alumnosclasegrupal){ 

            $clasegrupal = DB::table('config_clases_grupales')
                    ->join('clases_grupales', 'config_clases_grupales.id', '=', 'clases_grupales.clase_grupal_id')
                    ->select('config_clases_grupales.nombre', 'clases_grupales.fecha_inicio', 'clases_grupales.fecha_inicio_preferencial', 'config_clases_grupales.costo_mensualidad', 'config_clases_grupales.costo_inscripcion')
                    ->where('clases_grupales.id', '=', $request->clase_grupal_id)
                ->first();

                $inscripcion = new InscripcionClaseGrupal;

                $inscripcion->clase_grupal_id = $request->clase_grupal_id;
                $inscripcion->alumno_id = Auth::user()->usuario_id;
                $inscripcion->fecha_pago = $clasegrupal->fecha_inicio_preferencial;
                $inscripcion->fecha_inscripcion = Carbon::now()->toDateString();
                $inscripcion->costo_mensualidad = $clasegrupal->costo_mensualidad;

                $inscripcion->save();

                $item_factura = new ItemsFacturaProforma;
                    
                $item_factura->alumno_id = Auth::user()->usuario_id;
                $item_factura->academia_id = Auth::user()->academia_id;
                $item_factura->fecha = Carbon::now()->toDateString();
                $item_factura->item_id = $request->clase_grupal_id;
                $item_factura->nombre = 'Inscripcion ' . $clasegrupal->nombre;
                $item_factura->tipo = 3;
                $item_factura->cantidad = 1;
                $item_factura->precio_neto = 0;
                $item_factura->impuesto = 0;
                $item_factura->importe_neto = $clasegrupal->costo_inscripcion;
                $item_factura->fecha_vencimiento = $clasegrupal->fecha_inicio;
                    
                $item_factura->save();

                $item_factura = new ItemsFacturaProforma;
                    
                $item_factura->alumno_id = Auth::user()->usuario_id;
                $item_factura->academia_id = Auth::user()->academia_id;
                $item_factura->fecha = Carbon::now()->toDateString();
                $item_factura->item_id = $request->clase_grupal_id;
                $item_factura->nombre = 'Cuota ' . $clasegrupal->nombre;
                $item_factura->tipo = 4;
                $item_factura->cantidad = 1;
                $item_factura->precio_neto = 0;
                $item_factura->impuesto = 0;
                $item_factura->importe_neto = $clasegrupal->costo_mensualidad;
                $item_factura->fecha_vencimiento = $clasegrupal->fecha_inicio;
                    
                $item_factura->save();

                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'uno' => 'uno', 200]);


            }else{

                return response()->json(['error_mensaje' => 'Ups! Ya te encuentras inscrito en esta clase grupal', 'status' => 'ERROR'],422);
            }
        }

    public function editarinscripcion(Request $request)
    {

    $rules = [
        'costo_mensualidad_edicion' => 'required|numeric',
        'fecha_pago_edicion' => 'required',
    ];

    $messages = [

        'costo_mensualidad_edicion.required' => 'Ups! El costo de la mensualidad es requerida',
        'costo_mensualidad_edicion.numeric' => 'Ups! El campo del costo de la mensualidad en inválido , debe contener sólo números',        
        'fecha_pago_edicion.required' => 'Ups! La fecha de pago es requerida',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

            $fecha_pago = trim($request->fecha_pago_edicion);
            
            $rest = substr($fecha_pago, -3, 1);
            if($rest != "-")
            {
                $fecha_pago = Carbon::createFromFormat('d/m/Y', $fecha_pago);
            }else{
                $fecha_pago = Carbon::createFromFormat('Y-m-d', $fecha_pago);
            }

            $inscripcion = InscripcionClaseGrupal::find($request->id_edicion);

            $inscripcion->fecha_pago = $fecha_pago;
            $inscripcion->costo_mensualidad = $request->costo_mensualidad_edicion;

            
            if($inscripcion->save())
            {
                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'inscripcion' => $request->all(), 200]);

            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }

        }
    }

     public function updateNombre(Request $request){

        $clasegrupal = ClaseGrupal::find($request->id);
        $clasegrupal->clase_grupal_id = $request->clase_grupal_id;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateFecha(Request $request){

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

        $clasegrupal = ClaseGrupal::find($request->id);

        $fecha = explode(" - ", $request->fecha);

        $fecha_inicio = Carbon::createFromFormat('d/m/Y', $fecha[0]);
        $fecha_final = Carbon::createFromFormat('d/m/Y', $fecha[1]);

        if($fecha_inicio < Carbon::now()){

            return response()->json(['errores' => ['fecha' => [0, 'Ups! ha ocurrido un error. La fecha de inicio no puede ser menor al dia de hoy']], 'status' => 'ERROR'],422);
        }

        $fecha_inicio = $fecha_inicio->toDateString();
        $fecha_final = $fecha_final->toDateString();

        $clasegrupal->fecha_inicio = $fecha_inicio;
        $clasegrupal->fecha_final = $fecha_final;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateEspecialidad(Request $request){
        $clasegrupal = ClaseGrupal::find($request->id);
        $clasegrupal->especialidad_id = $request->especialidad_id;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateNivelBaile(Request $request){
        
        $clasegrupal = ClaseGrupal::find($request->id);
        $clasegrupal->nivel_baile_id = $request->nivel_baile_id;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateInstructor(Request $request){
        $clasegrupal = ClaseGrupal::find($request->id);
        $clasegrupal->instructor_id = $request->instructor_id;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEstudio(Request $request){
        $clasegrupal = ClaseGrupal::find($request->id);
        $clasegrupal->estudio_id = $request->estudio_id;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEtiqueta(Request $request){
        $clasegrupal = ClaseGrupal::find($request->id);
        $clasegrupal->color_etiqueta = $request->color_etiqueta;

        if($clasegrupal->save()){
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

        'hora_inicio.required' => 'Ups! La hora de inicio es requerida',
        'hora_final.required' => 'Ups! La hora final es requerida',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{
        $clasegrupal = ClaseGrupal::find($request->id);

        $hora_inicio = strtotime($request->hora_inicio);
        $hora_final = strtotime($request->hora_final);

        if($hora_inicio > $hora_final)
        {

            return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
        }

        $clasegrupal->hora_inicio = $request->hora_inicio;
        $clasegrupal->hora_final = $request->hora_final;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
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
        'cupo_minimo.numeric' => 'Ups! La cantidad de cupos es inválido , debe contener sólo números',
        'cupo_maximo.numeric' => 'Ups! La cantidad de cupos es inválido , debe contener sólo números',
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

        $clasegrupal = ClaseGrupal::find($request->id);
        $clasegrupal->cupo_minimo = $request->cupo_minimo;
        $clasegrupal->cupo_maximo = $request->cupo_maximo;

        if( $request->cupo_minimo > $request->cupo_maximo)
        {
            return response()->json(['errores'=>'Cupo Minimo Mayor', 'status' => 'ERROR-SERVIDOR'],422);
        }

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
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
        'cupo_reservacion.numeric' => 'Ups! La cantidad de cupos es inválido , debe contener sólo números',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        // return redirect("/home")

        // ->withErrors($validator)
        // ->withInput();

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }

        $clasegrupal = ClaseGrupal::find($request->id);
        $clasegrupal->cupo_reservacion = $request->cupo_reservacion;


        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
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

        $clasegrupal = ClaseGrupal::find($request->id);
        $clasegrupal->link_video = $request->link_video;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateImagen(Request $request)
    {
                $clasegrupal = ClaseGrupal::find($request->id);
                
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

                    $nombre_img = "clasegrupal-". $clasegrupal->id . $extension;
                    $image = base64_decode($base64_string);

                    // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
                    $img = Image::make($image)->resize(1440, 500);
                    $img->save('assets/uploads/clase_grupal/'.$nombre_img);
                }
                else{
                    $nombre_img = "";
                }

                $clasegrupal->imagen = $nombre_img;
                $clasegrupal->save();

                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
    }

    public function updateInscripcion(Request $request){

        

    $rules = [

        'costo_inscripcion' => 'required|numeric',
    ];

    $messages = [

        'costo_inscripcion.required' => 'Ups! El costo es requerido',
        'costo_inscripcion.numeric' => 'Ups! El costo es inválido , debe contener sólo números',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function updateMensualidad(Request $request){

    $rules = [

        'costo_mensualidad' => 'required|numeric',
    ];

    $messages = [

        'costo_mensualidad.required' => 'Ups! El costo es requerido',
        'costo_mensualidad.numeric' => 'Ups! El costo es inválido , debe contener sólo números',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function updateFechaCobro(Request $request){

    $rules = [
        'fecha_inicio_preferencial' => 'required',
    ];

    $messages = [

        'fecha_inicio_preferencial.required' => 'Ups! La fecha es requerida',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $fecha_inicio_preferencial = Carbon::createFromFormat('d/m/Y', $request->fecha_inicio_preferencial);

        if($fecha_inicio_preferencial < Carbon::now()){

            return response()->json(['errores' => ['fecha_inicio_preferencial' => [0, 'Ups! ha ocurrido un error. La fecha de próximo pago no puede ser menor al dia de hoy']], 'status' => 'ERROR'],422);
        }

        $fecha_inicio_preferencial = $fecha_inicio_preferencial->toDateString();

        $clasegrupal = ClaseGrupal::find($request->id);
        $clasegrupal->fecha_inicio_preferencial = $fecha_inicio_preferencial;

        $inscripcion_clase_grupal = InscripcionClaseGrupal::where('clase_grupal_id', $clasegrupal->id)->get();

        foreach ($inscripcion_clase_grupal as $inscripcion) {

            $inscripcion->fecha_pago = $fecha_inicio_preferencial;
            $inscripcion->save();

        }

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function updateFechaPago(Request $request){

    $rules = [

        'fecha_pago' => 'required',
    ];

    $messages = [

        'fecha_pago.required' => 'Ups! La fecha es requerida',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

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
        $clasegrupal = DB::table('clases_grupales')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->select('config_clases_grupales.nombre as nombre')
            ->where('clases_grupales.id', '=', $id)
            ->first();

        return view('agendar.clase_grupal.operacion')->with(['id' => $id, 'clasegrupal' => $clasegrupal]);        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

        $find = ClaseGrupal::find($id);

        if($find){

            $clase_grupal_join = DB::table('clases_grupales')
                ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->join('config_niveles_baile', 'clases_grupales.nivel_baile_id', '=', 'config_niveles_baile.id')
                ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','config_estudios.nombre as estudio_nombre', 'config_niveles_baile.nombre as nivel_nombre' , 'clases_grupales.fecha_inicio as fecha_inicio', 'clases_grupales.fecha_final as fecha_final' , 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.id' , 'clases_grupales.fecha_inicio_preferencial', 'clases_grupales.link_video', 'clases_grupales.cupo_minimo' , 'clases_grupales.cupo_maximo', 'clases_grupales.cupo_reservacion', 'clases_grupales.imagen', 'clases_grupales.color_etiqueta')
                ->where('clases_grupales.id', '=', $id)
                ->first();

                //dd($clase_grupal_join);

            return view('agendar.clase_grupal.planilla')->with(['config_clases_grupales' => ConfigClasesGrupales::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'config_especialidades' => ConfigEspecialidades::all(), 'config_estudios' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'config_niveles' => ConfigNiveles::all(), 'instructores' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'clasegrupal' => $clase_grupal_join,  'id' => $id, 'dias_de_semana' => DiasDeSemana::all()]);

        }else{
           return redirect("agendar/clases-grupales"); 
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function getAlumnos(Request $request)
    {
        $alumnosclasegrupal = DB::table('alumnos')
                ->join('inscripcion_clase_grupal', 'alumnos.id', '=', 'inscripcion_clase_grupal.alumno_id')
                ->join('clases_grupales', 'clases_grupales.id', '=', 'inscripcion_clase_grupal.clase_grupal_id')
                ->select('alumnos.nombre', 'alumnos.apellido', 'alumnos.telefono')
                ->where('clases_grupales.id', '=', $request->id)
                ->get();

        if($alumnosclasegrupal){
            return response()->json(['alumnosclasegrupal' => $alumnosclasegrupal]);
        }
    }

    public function eliminarAlumnos(Request $request)
    {
        $alumno = InscripcionClaseGrupal::where('alumno_id', $request->id_alumno)
        ->where('clase_grupal_id', '=', $request->id_clasegrupal)
        ->first();

        // $alumno = DB::table('inscripcion_clase_grupal')
        //         // ->select('inscripcion_clase_grupal.*')
        //         ->where('inscripcion_clase_grupal.clase_grupal_id', '=', $request->id_clasegrupal)
        //         ->where('alumno_id', '=', $request->id_alumno)
        //         ->first();

        if($alumno->delete()){
            return response()->json(['mensaje' => '¡Excelente! El Alumno se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function enhorabuena($id)
    {
        return view('agendar.clase_grupal.enhorabuena')->with('id', $id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */

    public function destroy($id)
    {

        $exist = InscripcionClaseGrupal::where('clase_grupal_id', $id)->first();

        if(!$exist)
        {
           $clasegrupal = ClaseGrupal::find($id);
        
            if($clasegrupal->delete()){
                return response()->json(['mensaje' => '¡Excelente! La Clase Grupal se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
        else{
            return response()->json(['error_mensaje'=> 'Ups! Esta clase grupal no puede ser eliminada ya que posee alumnos registrados' , 'status' => 'ERROR-BORRADO'],422);
        }
    }
}