<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\ClaseGrupal;
use App\HorarioClaseGrupal;
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
use App\Asistencia;
use App\Notificacion;
use App\NotificacionUsuario;
use App\HorarioBloqueado;
use App\Progreso;
use App\ReservacionVisitante;
use App\Codigo;
use App\Examen;
use App\CredencialAlumno;
use App\CredencialInstructor;
use PulkitJalan\GeoIP\GeoIP;


class ClaseGrupalController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function principal(Request $request){

        $clase_grupal_join = DB::table('clases_grupales')
            ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.id', 'clases_grupales.fecha_inicio', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'clases_grupales.boolean_promocionar', 'clases_grupales.dias_prorroga')
            ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
            ->where('clases_grupales.deleted_at', '=', null)
            ->OrderBy('clases_grupales.hora_inicio')
        ->get();

        $horarios_clase_grupales = DB::table('horario_clase_grupales')
            ->join('config_especialidades', 'horario_clase_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_estudios', 'horario_clase_grupales.estudio_id', '=', 'config_estudios.id')
            ->join('instructores', 'horario_clase_grupales.instructor_id', '=', 'instructores.id')
            ->join('clases_grupales', 'horario_clase_grupales.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'config_estudios.nombre as estudio_nombre', 'horario_clase_grupales.hora_inicio','horario_clase_grupales.hora_final', 'clases_grupales.id', 'horario_clase_grupales.fecha as fecha_inicio', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'clases_grupales.boolean_promocionar', 'clases_grupales.dias_prorroga', 'horario_clase_grupales.id as horario_id')
            ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
            ->where('horario_clase_grupales.deleted_at', '=', null)
            ->OrderBy('horario_clase_grupales.hora_inicio')
        ->get();

        $array = array();

        $academia = Academia::find(Auth::user()->academia_id);

        
        if(Auth::user()->usuario_tipo == 1 OR Auth::user()->usuario_tipo == 3 OR Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6){

            foreach($clase_grupal_join as $clase_grupal){
                $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
                $dia_de_semana = $fecha->dayOfWeek;

                if($fecha > Carbon::now()){
                    $inicio = 0;
                }else{
                    $inicio = 1;
                }

                $collection=collect($clase_grupal);     
                $clase_grupal_array = $collection->toArray();
                
                $clase_grupal_array['dia_de_semana']=$dia_de_semana;
                $clase_grupal_array['inicio']=$inicio;
                $array['1-'.$clase_grupal->id] = $clase_grupal_array;
            }

            foreach($horarios_clase_grupales as $clase_grupal){
                $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
                $dia_de_semana = $fecha->dayOfWeek;

                if($fecha > Carbon::now()){
                    $inicio = 0;
                }else{
                    $inicio = 1;
                }

                $collection=collect($clase_grupal);     
                $clase_grupal_array = $collection->toArray();
                
                $clase_grupal_array['dia_de_semana']=$dia_de_semana;
                $clase_grupal_array['inicio']=$inicio;
                $array['2-'.$clase_grupal->horario_id] = $clase_grupal_array;
            }

            $actual = Carbon::now();
            $geoip = new GeoIP();
            $geoip->setIp($request->ip());
            $actual->tz = $geoip->getTimezone();
            $hoy = $actual->dayOfWeek;

            $alumnos = Alumno::where('academia_id',Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

            $asistencia_amarilla = 3;
            $asistencia_roja = 6;
            $riesgo = 0;
            $activos = 0;
            $inactivos = 0;

            foreach($alumnos as $alumno){

                $semanas = 0;

                $ultima_asistencia = Asistencia::where('alumno_id',$alumno->id)->orderBy('created_at', 'desc')->first();

                if($ultima_asistencia){

                    $fecha = Carbon::parse($ultima_asistencia->fecha);

                }else{
                    $inactivos = $inactivos + 1;
                    continue;
                }

                while($fecha < Carbon::now())
                {
                    $semanas++;
                    $fecha->addWeek();
                }
                
                if($semanas >= $asistencia_roja){
                    $inactivos = $inactivos + 1;
                }
                else if($semanas >= $asistencia_amarilla){
                    $riesgo = $riesgo + 1;
                }else{
                    $activos = $activos + 1;
                }

            }

            $fecha_inicio = Session::get('fecha_inicio');

            return view('agendar.clase_grupal.principal')->with(['clase_grupal_join' => $array, 'hoy' => $hoy, 'academia' => $academia, 'riesgo' => $riesgo, 'activos' => $activos, 'fecha_inicio' => $fecha_inicio]);

        }else{

            $i = 0;

            foreach($clase_grupal_join as $clase_grupal){


                $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
                $fecha->addDays($clase_grupal->dias_prorroga);
                $dia_de_semana = $fecha->dayOfWeek;

                if($fecha >= Carbon::now() && $clase_grupal->boolean_promocionar == 1){

                    $collection=collect($clase_grupal);     
                    $clase_grupal_array = $collection->toArray();

                    $clase_grupal_array['dia_de_semana']=$dia_de_semana;
                    $array['1-'.$clase_grupal->id] = $clase_grupal_array;
                }
            }

            foreach($horarios_clase_grupales as $clase_grupal){
                $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
                $fecha->addDays($clase_grupal->dias_prorroga);
                $dia_de_semana = $fecha->dayOfWeek;

                if($fecha >= Carbon::now() && $clase_grupal->boolean_promocionar == 1){

                    $collection=collect($clase_grupal);     
                    $clase_grupal_array = $collection->toArray();

                    $clase_grupal_array['dia_de_semana']=$dia_de_semana;
                    $array['2-'.$clase_grupal->horario_id] = $clase_grupal_array;
                }
            }

             return view('agendar.clase_grupal.principal_alumno')->with(['clase_grupal_join' => $array, 'academia' => $academia]);

        }
    }

    public function indexconacademia($id)
    {

        $clase_grupal_join = DB::table('clases_grupales')
            ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.id', 'clases_grupales.fecha_inicio', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'clases_grupales.boolean_promocionar', 'clases_grupales.dias_prorroga')
            ->where('clases_grupales.academia_id','=', $id)
            ->where('clases_grupales.deleted_at', '=', null)
            ->OrderBy('clases_grupales.hora_inicio')
        ->get();

        $array = array();

        $academia = Academia::find($id);

        foreach($clase_grupal_join as $clase_grupal){

            $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
            $fecha->addDays($clase_grupal->dias_prorroga);
            $dia_de_semana = $fecha->dayOfWeek;

            if($fecha >= Carbon::now() && $clase_grupal->boolean_promocionar == 1){

                $horarios = HorarioClaseGrupal::where('clase_grupal_id', $clase_grupal->id)->get();
                $i = 0;
                $len = count($horarios);
                $dia_string = '';

                $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
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
 
                $dia_string = $dia_string . $dia;
                
                foreach($horarios as $horario){

                    if($dia_string != ''){
                        $dia_string = $dia_string . ', ';
                    }

                    $fecha = Carbon::createFromFormat('Y-m-d', $horario->fecha);
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
                    if ($i != $len - 1) {
                        $dia_string = $dia_string . $dia;
                    }else{
                        $dia_string = $dia_string . 'y ' . $dia;
                    }

                    $i++;

                }

                $collection=collect($clase_grupal);     
                $clase_grupal_array = $collection->toArray();

                $clase_grupal_array['dias_de_semana']=$dia_string;
                $array[$clase_grupal->id] = $clase_grupal_array;
            }
        }

        return view('agendar.clase_grupal.principal_alumno')->with(['clase_grupal_join' => $array, 'academia' => $academia]);
        
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

        $clasegrupal = DB::table('config_clases_grupales')
                ->join('clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('config_clases_grupales.*', 'clases_grupales.fecha_inicio_preferencial', 'clases_grupales.fecha_inicio', 'clases_grupales.fecha_final', 'clases_grupales.id as clase_grupal_id', 'instructores.id as instructor_id')
                ->where('clases_grupales.id', '=', $id)
        ->first();

        $alumnos_inscritos = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
                ->select('alumnos.*', 'inscripcion_clase_grupal.fecha_pago', 'inscripcion_clase_grupal.costo_mensualidad', 'inscripcion_clase_grupal.id as inscripcion_id', 'inscripcion_clase_grupal.alumno_id', 'inscripcion_clase_grupal.boolean_franela', 'inscripcion_clase_grupal.boolean_programacion', 'inscripcion_clase_grupal.talla_franela')
            ->where('inscripcion_clase_grupal.clase_grupal_id', '=', $id)
            ->where('inscripcion_clase_grupal.deleted_at', '=', null)
        ->get();

        $alumnod = DB::table('alumnos')
            ->join('items_factura_proforma', 'items_factura_proforma.alumno_id', '=', 'alumnos.id')
            ->join('inscripcion_clase_grupal', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
            ->select('inscripcion_clase_grupal.id as id', 'items_factura_proforma.importe_neto', 'items_factura_proforma.fecha_vencimiento')
            ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
            ->where('alumnos.deleted_at', '=', null)
        ->get();

        $collection=collect($alumnod);
        $grouped = $collection->groupBy('id');     
        $deuda = $grouped->toArray();

        $alumnoc = DB::table('users')
            ->join('alumnos', 'alumnos.id', '=', 'users.usuario_id')
            ->select('alumnos.id as id')
            ->where('users.academia_id','=', Auth::user()->academia_id)
            ->where('alumnos.deleted_at', '=', null)
            ->where('users.usuario_tipo', '=', 2)
            ->where('users.confirmation_token', '!=', null)
        ->get();

        $collection=collect($alumnoc);
        $grouped = $collection->groupBy('id');     
        $activacion = $grouped->toArray();

        $reservaciones = DB::table('reservaciones_visitantes')
            ->join('visitantes_presenciales', 'reservaciones_visitantes.visitante_id', '=', 'visitantes_presenciales.id')
            ->select('visitantes_presenciales.*','reservaciones_visitantes.id as inscripcion_id', 'visitantes_presenciales.id as alumno_id')
            ->where('reservaciones_visitantes.tipo_id', '=', $id)
            ->where('reservaciones_visitantes.tipo_reservacion', '=', '1')
        ->get();

        $array = array();
        $mujeres = 0;
        $hombres = 0;

        $fecha_de_inicio = Carbon::parse($clasegrupal->fecha_inicio);
        $fecha_de_finalizacion = Carbon::parse($clasegrupal->fecha_final);
        $asistencia_roja = $clasegrupal->asistencia_rojo;
        $asistencia_amarilla = $clasegrupal->asistencia_amarilla;

        foreach($alumnos_inscritos as $alumno){

            $clases_completadas = 0;
                
            $ultima_asistencia = Asistencia::where('tipo',1)->where('tipo_id',$id)->where('alumno_id',$alumno->id)->orderBy('created_at', 'desc')->first();

            if($ultima_asistencia){

                $fecha = Carbon::parse($ultima_asistencia->fecha);

            }else{
                $fecha = $fecha_de_inicio;
            }

            if(Carbon::now() < $fecha_de_finalizacion){
                while($fecha < Carbon::now()){
                    $clases_completadas++;
                    $fecha->addWeek();
                }
            }else{
                while($fecha < $fecha_de_finalizacion){
                    $clases_completadas++;
                    $fecha->addWeek();
                }
            }

            if($clases_completadas >= $asistencia_roja){
                $estatus="c-youtube";

                if($asistencia_roja > 0)
                {
                    $alumno->deleted_at = Carbon::now();
                    $alumno->save();
                }
                
                continue;
            }else if($clases_completadas >= $asistencia_amarilla){
                $estatus="c-amarillo";
            }else{
                $estatus="c-verde";
            }

            $collection=collect($alumno);     
            $alumno_array = $collection->toArray();
            $alumno_array['estatus'] = $estatus;

            // ----------

            $credencial = CredencialAlumno::where('alumno_id',$alumno->id)->where('instructor_id',$clasegrupal->instructor_id)->first();

            if(!$credencial){
                $credencial = new CredencialAlumno;

                $credencial->alumno_id = $alumno->id;
                $credencial->instructor_id = $clasegrupal->instructor_id;
                $credencial->cantidad = 0;
                $credencial->dias_vencimiento = 0;
                $credencial->fecha_vencimiento = Carbon::now();

                $credencial->save();
            }

            $alumno_array['tipo'] = 1;
            $alumno_array['cantidad'] = $credencial->cantidad;
            $alumno_array['dias_vencimiento'] = $credencial->dias_vencimiento;

            $array[$alumno->id] = $alumno_array;

            if($alumno->sexo == 'F'){
                $mujeres++;
            }else{
                $hombres++;
            }

        }

        foreach($reservaciones as $alumno){

            if($alumno->sexo == 'F'){
                $mujeres++;
            }else{
                $hombres++;
            }

            $collection=collect($alumno);     
            $alumno_array = $collection->toArray();

            $alumno_array['tipo'] = 2;
            $array['2-'.$alumno->id] = $alumno_array;
        }

        $alumnos = Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();
        $examen = Examen::where('boolean_grupal',1)->where('clase_grupal_id', $id)->first();

        if($examen){
            $examen = $examen->id;
        }else{
            $examen = '';
        }

        if(Auth::user()->usuario_tipo == 3){
            $credenciales = CredencialInstructor::where('instructor_id',Auth::user()->usuario_id)->first();

            $total_credenciales = $credenciales->cantidad;
        }else{
            $total_credenciales = 0;
        }

        return view('agendar.clase_grupal.participantes')->with(['alumnos_inscritos' => $array, 'id' => $id, 'clasegrupal' => $clasegrupal, 'alumnos' => $alumnos, 'mujeres' => $mujeres, 'hombres' => $hombres, 'deuda' => $deuda, 'activacion' => $activacion, 'examen' => $examen, 'total_credenciales' => $total_credenciales]);
    }

    public function eliminarinscripcion($id)
    {
        // $inscripcion = InscripcionClaseGrupal::find($id);
        $inscripcion = InscripcionClaseGrupal::find($id);
        
        if($inscripcion->delete()){

            // $asistencias = Asistencia::where('clase_grupal_id', $inscripcion->clase_grupal_id)->where('alumno_id', $inscripcion->alumno_id)->get();

            // if($asistencias)
            // {
                
            //     $detele = Asistencia::where('clase_grupal_id', $inscripcion->clase_grupal_id)->where('alumno_id', $inscripcion->alumno_id)->delete();

            //     return response()->json(['mensaje' => '¡Excelente! La Clase Grupal se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);

               
            // }else{

            //     return response()->json(['mensaje' => '¡Excelente! La Clase Grupal se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
            // }
            // 
            return response()->json(['mensaje' => '¡Excelente! La Clase Grupal se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

    public function eliminar_reserva($id)
    {
        $reserva = ReservacionVisitante::find($id);
        $codigo = Codigo::where('item_id',$id)->where('tipo',2)->first();
        
        if($reserva->delete()){
            if($codigo){

                if($codigo->delete())
                {
                    return response()->json(['mensaje' => '¡Excelente! La Clase Grupal se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);

                }else{

                    return response()->json(['mensaje' => '¡Excelente! La Clase Grupal se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
                }
            }else{
                return response()->json(['mensaje' => '¡Excelente! La Clase Grupal se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);

            }
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

    public function congelarInscripcion(Request $request)
    {

    $rules = [
        'razon_congelacion' => 'required',
        'fecha' => 'required',
     
    ];

    $messages = [

        'razon_congelacion.required' => 'Ups! El La razon de la congelación es requerida',
        'fecha.required' => 'Ups! La fecha es requerida',

    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $clasegrupal = InscripcionClaseGrupal::find($request->inscripcion_clase_grupal_id);

        $fecha = explode(" - ", $request->fecha);

        $fecha_inicio = Carbon::createFromFormat('d/m/Y', $fecha[0]);
        $fecha_final = Carbon::createFromFormat('d/m/Y', $fecha[1]);
        
        $clasegrupal->razon_congelacion = $request->razon_congelacion;
        $clasegrupal->fecha_inicio = $fecha_inicio;
        $clasegrupal->fecha_final = $fecha_final;
        $clasegrupal->boolean_congelacion = 1;
       

        if($clasegrupal->save()){
           
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'id' => $request->inscripcion_clase_grupal_id, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
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
            ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.id', 'clases_grupales.cupo_reservacion', 'clases_grupales.fecha_inicio', 'clases_grupales.imagen', 'config_clases_grupales.descripcion', 'academias.imagen as imagen_academia', 'clases_grupales.link_video', 'config_clases_grupales.condiciones', 'academias.direccion', 'academias.estado', 'academias.facebook', 'academias.twitter', 'academias.instagram', 'academias.linkedin', 'academias.youtube', 'academias.pagina_web', 'academias.nombre as academia_nombre', 'academias.id as academia_id', 'config_clases_grupales.costo_inscripcion', 'config_clases_grupales.costo_mensualidad', 'clases_grupales.titulo_video', 'clases_grupales.cantidad_mujeres', 'clases_grupales.cantidad_hombres', 'clases_grupales.cupo_maximo')
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

         // $cantidad_reservaciones = DB::table('reservaciones')
         //     ->select('reservaciones.*')
         //     ->where('tipo_id', '=', $id)
         //     ->where('tipo_reservacion', '=', 1)
         // ->count();

         // if($clase_grupal_join->cupo_reservacion == 0){
         //    $cupo_reservacion = 1;
         // }
         // else{
         //    $cupo_reservacion = $clase_grupal_join->cupo_reservacion;
         // }

         // $cupos_restantes = $cupo_reservacion - $cantidad_reservaciones;

         // if($cupos_restantes < 0){
         //    $cupos_restantes = 0;
         // }

         $cantidad_hombres_inscripcion = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
            ->where('inscripcion_clase_grupal.clase_grupal_id',$id)
            ->where('alumnos.sexo','M')
        ->count();

        $cantidad_hombres_reserva = ReservacionVisitante::join('visitantes_presenciales', 'reservaciones_visitantes.visitante_id', '=', 'visitantes_presenciales.id')
            ->where('reservaciones_visitantes.tipo_id',$id)
            ->where('reservaciones_visitantes.tipo_reservacion','1')
            ->where('visitantes_presenciales.sexo','M')
        ->count();

        $cantidad_hombres = $cantidad_hombres_inscripcion + $cantidad_hombres_reserva;

        $cantidad_hombres = $clase_grupal_join->cantidad_hombres - $cantidad_hombres;

        if($cantidad_hombres < 0){
            $cantidad_hombres = 0;
        }

        $cantidad_mujeres_inscripcion = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
            ->where('inscripcion_clase_grupal.clase_grupal_id',$id)
            ->where('alumnos.sexo','F')
        ->count();

        $cantidad_mujeres_reserva = ReservacionVisitante::join('visitantes_presenciales', 'reservaciones_visitantes.visitante_id', '=', 'visitantes_presenciales.id')
            ->where('reservaciones_visitantes.tipo_id',$id)
            ->where('reservaciones_visitantes.tipo_reservacion','1')
            ->where('visitantes_presenciales.sexo','F')
        ->count();

        $cantidad_mujeres = $cantidad_mujeres_inscripcion + $cantidad_mujeres_reserva;

        $cantidad_mujeres = $clase_grupal_join->cantidad_mujeres - $cantidad_mujeres;

        if($cantidad_mujeres < 0){
            $cantidad_mujeres = 0;
        }

        $cupos_restantes = $clase_grupal_join->cupo_maximo - $cantidad_mujeres + $cantidad_hombres;

        $cupos_totales = $cantidad_mujeres_inscripcion + $cantidad_mujeres_reserva + $cantidad_hombres_inscripcion + $cantidad_hombres_reserva;



        // $porcentaje = intval(($cantidad_reservaciones / $cupo_reservacion) * 100);

        $porcentaje = intval(($cupos_totales / $clase_grupal_join->cupo_maximo) * 100);

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

        return view('agendar.clase_grupal.create')->with(['config_clases_grupales' => ConfigClasesGrupales::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get(), 'dias_de_semana' => DiasDeSemana::all(), 'config_especialidades' => ConfigEspecialidades::all(), 'config_estudios' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'config_niveles' => ConfigNiveles::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->get() , 'instructores' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get()]);
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
        'cantidad_hombres' => 'numeric',
        'cantidad_mujeres' => 'numeric',
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
        'cantidad_hombres.numeric' => 'Ups! La cantidad es inválida , debe contener sólo números',
        'cantidad_mujeres.numeric' => 'Ups! La cantidad es inválida , debe contener sólo números',
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


        if($fecha_inicio > $fecha_final)
        {
            return response()->json(['errores' => ['fecha' => [0, 'Ups! La fecha de inicio es mayor a la fecha final']], 'status' => 'ERROR'],422);
        }

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
        // 

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
        $clasegrupal->titulo_video = $request->titulo_video;
        $clasegrupal->boolean_promocionar = $request->boolean_promocionar;
        $clasegrupal->dias_prorroga = $request->dias_prorroga;
        $clasegrupal->cantidad_hombres = $cantidad_hombres;
        $clasegrupal->cantidad_mujeres = $cantidad_mujeres;

        if($clasegrupal->save()){
            $nombre = DB::table('config_clases_grupales')
                ->join('clases_grupales','config_clases_grupales.id','=','clases_grupales.clase_grupal_id')
                ->select('config_clases_grupales.nombre')
                ->where('clases_grupales.clase_grupal_id','=',$request->clase_grupal_id)
            ->first();

            $notificacion = new Notificacion; 

            $notificacion->tipo_evento = 1;
            $notificacion->evento_id = $clasegrupal->id;
            $notificacion->mensaje = "Tu academia a creado una nueva clase grupal llamada ".$nombre->nombre;
            $notificacion->titulo = "Nueva Clase Grupal";

            if($notificacion->save()){
                $alumnos_a_notificar = DB::table('users')
                    ->select('users.id')
                    ->where('users.usuario_tipo','=',2)
                    ->where('users.academia_id', '=', Auth::user()->academia_id)
                ->get();
                
                foreach ($alumnos_a_notificar as $alumnos) {
                    $usuarios_notificados = new NotificacionUsuario;
                    $usuarios_notificados->id_usuario = $alumnos->id;
                    $usuarios_notificados->id_notificacion = $notificacion->id;
                    $usuarios_notificados->visto = 0;
                    $usuarios_notificados->save();
                }
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

                $nombre_img = "clasegrupal-". $clasegrupal->id . $extension;
                $image = base64_decode($base64_string);

                // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
                $img = Image::make($image)->resize(1440, 500);
                $img->save('assets/uploads/clase_grupal/'.$nombre_img);

                $clasegrupal->imagen = $nombre_img;
                $clasegrupal->save();

            }

            // $academia = Academia::find(Auth::user()->academia_id);
            // $instructor = Instructor::find($request->instructor_id);
            // $clase_grupal = ConfigClasesGrupales::find($request->clase_grupal_id);

            // $subj = 'Te han asignado una Clase Grupal';

            // $array = [

            //    'nombre_clase' => $clase_grupal->nombre,
            //    'nombre_instructor' => $instructor->nombre,
            //    'correo' => $instructor->correo,
            //    'academia' => $academia->nombre,
            //    'hora_inicio' => $request->hora_inicio,
            //    'hora_final' => $request->hora_final,
            //    'fecha' => $fecha_inicio,
            //    'subj' => $subj
            // ];

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

        $alumnosclasegrupal = InscripcionClaseGrupal::withTrashed()->where('alumno_id', $request->alumno_id)->where('clase_grupal_id', $request->clase_grupal_id)->first();

        if($alumnosclasegrupal){
            $alumnosclasegrupal->deleted_at = null;
            $alumnosclasegrupal->save();

            $deuda = DB::table('alumnos')
                ->join('items_factura_proforma', 'items_factura_proforma.alumno_id', '=', 'alumnos.id')
                ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
                ->where('alumnos.id','=', $alumnosclasegrupal->alumno_id)
            ->sum('items_factura_proforma.importe_neto');

            $alumno = Alumno::find($alumnosclasegrupal->alumno_id);

            Session::forget('id_alumno');

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'id' => $alumnosclasegrupal->alumno_id, 'inscripcion' => $alumnosclasegrupal, 'array'=> $alumno, 'deuda' => $deuda, 200]);
        }

        // comprobar si esta inscrito
        // if(!$alumnosclasegrupal){ 


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

            

            if($request->permitir == 0)
            {
                $alumno = Alumno::find($request->alumno_id);
                $clasegrupal = ClaseGrupal::find($request->clase_grupal_id);


                if($alumno->sexo == 'M')
                {
                    if(!is_null($clasegrupal->cantidad_hombres)){

                        $hombres = DB::table('inscripcion_clase_grupal')
                            ->join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
                            ->select('inscripcion_clase_grupal.*')
                            ->where('inscripcion_clase_grupal.clase_grupal_id', '=', $request->clase_grupal_id)
                            ->where('alumnos.sexo', '=', 'M')
                        ->count();


                        if($clasegrupal->cantidad_hombres <= $hombres){
                            return response()->json(['mensaje'=>'Ups! La cantidad de hombres permitida en esta clase grupal ha llegado a su limite, deseas inscribir al alumno de todas maneras?', 'status' => 'CANTIDAD-FULL'],422);
                        }
                    }

                }

                else{

                    if(!is_null($clasegrupal->cantidad_mujeres)){

                        $mujeres = DB::table('inscripcion_clase_grupal')
                            ->join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
                            ->select('inscripcion_clase_grupal.*')
                            ->where('inscripcion_clase_grupal.clase_grupal_id', '=', $request->clase_grupal_id)
                            ->where('alumnos.sexo', '=', 'F')
                        ->count();

                        if($clasegrupal->cantidad_mujeres <= $mujeres){
                            return response()->json(['mensaje'=>'Ups! La cantidad de mujeres permitida en esta clase grupal ha llegado a su limite, deseas inscribir al alumno de todas maneras?', 'status' => 'CANTIDAD-FULL'],422);
                        }
                    }

                }
            }

            // $alumnos = explode('-',$request->alumno_id);

            $fecha_pago = trim($request->fecha_pago);
            $proxima_fecha = Carbon::createFromFormat('d/m/Y', $fecha_pago);
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
                $inscripcion->boolean_franela = $request->boolean_franela;
                $inscripcion->boolean_programacion = $request->boolean_programacion;
                $inscripcion->razon_entrega = $request->razon_entrega;
                $inscripcion->talla_franela = $request->talla_franela;

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

                $deuda = DB::table('alumnos')
                    ->join('items_factura_proforma', 'items_factura_proforma.alumno_id', '=', 'alumnos.id')
                    ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
                    ->where('alumnos.id','=', $request->alumno_id)
                ->sum('items_factura_proforma.importe_neto');


                $alumno = Alumno::find($request->alumno_id);

                // $array[$i] = $alumno;

            // }
            

            Session::forget('id_alumno');

            // return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'uno' => 'uno', 'id' => $alumno->id, 'array' => $alumno, 'inscripcion' => $inscripcion, 'deuda' => $deuda, 200]);

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'id' => $request->alumno_id, 'inscripcion' => $inscripcion, 'deuda' => $deuda, 'array' => $alumno, 200]);

            // if(count($alumnos) > 2)
            // {
            //     return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 200]);
            // }
            // else{
            //     return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'uno' => 'uno', 'id' => $array[1]->id, 200]);
            // }

    
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

    public function editarcredencial(Request $request)
    {

    $rules = [
        'cantidad' => 'numeric',
        'dias_vencimiento' => 'numeric',
    ];

    $messages = [

        'cantidad.numeric' => 'Ups! El campo de credenciales en inválido , debe contener sólo números', 
        'dias_vencimiento.numeric' => 'Ups! El campo de dias de vencimiento en inválido , debe contener sólo números',         

    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

            $credencial_instructor = CredencialInstructor::where('instructor_id', Auth::user()->usuario_id)->first();

            if($credencial_instructor){

                $total = $credencial_instructor->cantidad - $request->cantidad;

                if($total > 0){
                    $credencial_alumno = CredencialAlumno::where('alumno_id', $request->alumno_id_credencial)->where('instructor_id', Auth::user()->usuario_id)->first();

                    if($credencial_alumno){
                        
                        $credencial_alumno->cantidad = $request->cantidad;
                        $credencial_alumno->dias_vencimiento = $request->dias_vencimiento;
                        $credencial_alumno->fecha_vencimiento = Carbon::now()->AddDays($request->dias_vencimiento);

                        $credencial_alumno->save();

                    }else{

                        $credencial_alumno = new CredencialAlumno;

                        $credencial_alumno->alumno_id = $request->alumno_id_credencial;
                        $credencial_alumno->instructor_id = Auth::user()->usuario_id;
                        $credencial_alumno->cantidad = $request->cantidad;
                        $credencial_alumno->dias_vencimiento = $request->dias_vencimiento;
                        $credencial_alumno->fecha_vencimiento = Carbon::now()->AddDays($request->dias_vencimiento);

                        $credencial_alumno->save();

                    }

                    $credencial_instructor->cantidad = $total;

                    if($credencial_instructor->save())
                    {
                        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'inscripcion' => $request->all(), 200]);

                    }else{
                        return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                    }
                }else{
                    return response()->json(['error_mensaje'=> 'Ups! No posees la cantidad de credenciales necesarias' , 'status' => 'ERROR-CREDENCIAL2'],422);
                }

            }else{
                return response()->json(['error_mensaje'=> 'Ups! No posees la cantidad de credenciales necesarias' , 'status' => 'ERROR-CREDENCIAL1'],422);
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
        $clasegrupal->titulo_video = $request->titulo_video;

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

    public function updateCantidad(Request $request){

    $rules = [

        'cantidad_hombres' => 'numeric',
        'cantidad_mujeres' => 'numeric',
    ];

    $messages = [

        'cantidad_hombres.numeric' => 'Ups! La cantidad es inválida , debe contener sólo números',
        'cantidad_mujeres.numeric' => 'Ups! La cantidad es inválida , debe contener sólo números',
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

        $clasegrupal = ClaseGrupal::find($request->id);
        $clasegrupal->cantidad_hombres = $cantidad_hombres;
        $clasegrupal->cantidad_mujeres = $cantidad_mujeres;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

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

    public function updateMostrar(Request $request){

        $clasegrupal = ClaseGrupal::find($request->id);
        $clasegrupal->boolean_promocionar = $request->boolean_promocionar;
        $clasegrupal->dias_prorroga = $request->dias_prorroga;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
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

    public function operar($id)
    {   
        $clasegrupal = DB::table('clases_grupales')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_clases_grupales.nombre as nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final')
            ->where('clases_grupales.id', '=', $id)
            ->first();
        if($clasegrupal)
       	{
            $fecha_inicio = Session::get('fecha_inicio');

       		$clases_grupales = ClaseGrupal::join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
		        ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
		        ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
		        ->select('instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final', 'config_clases_grupales.nombre as clase_grupal_nombre', 'config_especialidades.nombre as especialidad_nombre' , 'clases_grupales.id', 'clases_grupales.fecha_inicio')
		        ->where('clases_grupales.id', '!=' , $id)
		        ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
        	->get();

        	$array = array();

        	foreach($clases_grupales as $clase_grupal)
        	{
        		$fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
      
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

        		$array[$clase_grupal->id] = array(
        			'nombre' => $clase_grupal->clase_grupal_nombre,
                    'instructor' => $clase_grupal->instructor_nombre . ' ' . $clase_grupal->instructor_apellido,
                    'dia_de_semana' => $dia,
                    'especialidad' => $clase_grupal->especialidad_nombre,
                    'hora_inicio' => $clase_grupal->hora_inicio,
                    'hora_final' => $clase_grupal->hora_final,
                    'id'=>$clase_grupal->id
            	);
        	}

        	return view('agendar.clase_grupal.operacion')->with(['id' => $id, 'clasegrupal' => $clasegrupal, 'grupales' => $array, 'fecha_inicio' => $fecha_inicio]);
       	}else{
       		return redirect("agendar/clases-grupales"); 
       	}
                
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

        $clase_grupal_join = DB::table('clases_grupales')
            ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->join('config_niveles_baile', 'clases_grupales.nivel_baile_id', '=', 'config_niveles_baile.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'config_clases_grupales.asistencia_rojo as inasistencia_max', 'config_clases_grupales.asistencia_amarilla as inasistencia_min', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','config_estudios.nombre as estudio_nombre', 'config_niveles_baile.nombre as nivel_nombre' , 'clases_grupales.fecha_inicio as fecha_inicio', 'clases_grupales.fecha_final as fecha_final' , 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.id' , 'clases_grupales.fecha_inicio_preferencial', 'clases_grupales.link_video', 'clases_grupales.cupo_minimo' , 'clases_grupales.cupo_maximo', 'clases_grupales.cupo_reservacion', 'clases_grupales.imagen', 'clases_grupales.color_etiqueta', 'clases_grupales.boolean_promocionar', 'clases_grupales.titulo_video', 'clases_grupales.dias_prorroga', 'clases_grupales.cantidad_hombres', 'clases_grupales.cantidad_mujeres')
            ->where('clases_grupales.id', '=', $id)
        ->first();

        if($clase_grupal_join){

        	$clases_grupales = ClaseGrupal::join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
		        ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
		        ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
		        ->select('instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final', 'config_clases_grupales.nombre as clase_grupal_nombre', 'config_especialidades.nombre as especialidad_nombre' , 'clases_grupales.id', 'clases_grupales.fecha_inicio')
		        ->where('clases_grupales.id', '!=' , $id)
		        ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
        	->get();

        	$array = array();

        	foreach($clases_grupales as $clase_grupal)
        	{
        		$fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
      
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

        		$array[$clase_grupal->id] = array(
        			'nombre' => $clase_grupal->clase_grupal_nombre,
                    'instructor' => $clase_grupal->instructor_nombre . ' ' . $clase_grupal->instructor_apellido,
                    'dia_de_semana' => $dia,
                    'especialidad' => $clase_grupal->especialidad_nombre,
                    'hora_inicio' => $clase_grupal->hora_inicio,
                    'hora_final' => $clase_grupal->hora_final,
                    'id'=>$clase_grupal->id
            	);
        	}

            $horario_clase_grupal=HorarioClaseGrupal::where('clase_grupal_id',$id)
            ->join('config_especialidades', 
                'horario_clase_grupales.especialidad_id',
                '=', 
                'config_especialidades.id'
                )
            ->join('instructores', 
                'horario_clase_grupales.instructor_id',
                '=',
                'instructores.id'
                 )
            ->join('config_estudios', 
                'horario_clase_grupales.estudio_id',
                '=',
                'config_estudios.id'
                 )
            ->select('horario_clase_grupales.*', 
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

            return view('agendar.clase_grupal.planilla')->with(['config_clases_grupales' => ConfigClasesGrupales::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get(), 'config_especialidades' => ConfigEspecialidades::all(), 'config_estudios' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'config_niveles' => ConfigNiveles::all(), 'instructores' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get(), 'clasegrupal' => $clase_grupal_join,  'id' => $id, 'dias_de_semana' => DiasDeSemana::all(), 'grupales' => $array, 'arrayHorario' => $arrayHorario]);

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
            $horario_clase_grupal = HorarioClaseGrupal::where('clase_grupal_id', $id)->delete();
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

    public function Trasladar(Request $request)
    {
    	$rules = [

	        'clasegrupal_id' => 'required',
	        'id' => 'required',
        ];

        $messages = [

            'clasegrupal_id.required' => 'Ups! La Clase Grupal es requerida',
            'id.required' => 'Ups! La Clase Grupal es requerida',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            
            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);           

        }else{

	        $inscritos = InscripcionClaseGrupal::where('clase_grupal_id', $request->id)->get();
	        $clasegrupal = ClaseGrupal::find($request->id);

	        if($clasegrupal)
	        {
		        if($inscritos)
		        {

		        	$config_clase_grupal = ConfigClasesGrupales::find($clasegrupal->clase_grupal_id);

		        	foreach($inscritos as $inscrito){
		        		$existe = InscripcionClaseGrupal::where('alumno_id', $inscrito->alumno_id)->where('clase_grupal_id', $request->clasegrupal_id)->first();
		        		if(!$existe){
		        			$inscrito->clase_grupal_id = $request->clasegrupal_id;
		        			$inscrito->costo_mensualidad = $config_clase_grupal->costo_mensualidad;
		        			$inscrito->save();
		        		}else{
		        			$inscrito->delete();
		        		}
		        	}
		        }

		        $horarios = HorarioClaseGrupal::where('clase_grupal_id', $request->id)->delete();
		        $asistencias = Asistencia::where('clase_grupal_id', $request->id)->delete();

	
	    		if($clasegrupal->delete()){
	        		return response()->json(['mensaje' => '¡Excelente! La Clase Grupal se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
		        }else{
		            return response()->json(['errores'=>'error', 'status' => 'ERROR-CLASEGRUPAL'],422);
		        }
		        	
		    }else{
		    	return response()->json(['mensaje' => '¡Excelente! La Clase Grupal se ha eliminado satisfactoriamente', 'status' => 'OK', 200]); 
		    }
	    }
	}

    public function nivelaciones($id)
    {
        $progreso = Progreso::where('clase_grupal_id',$id)->first();

        if($progreso){

            $clase_1 = Progreso::where('clase_grupal_id',$id)->where('tipo',1)->first();
            $clase_2 = Progreso::where('clase_grupal_id',$id)->where('tipo',2)->first();
            $clase_3 = Progreso::where('clase_grupal_id',$id)->where('tipo',3)->first();
            $clase_4 = Progreso::where('clase_grupal_id',$id)->where('tipo',4)->first();
            $clase_5 = Progreso::where('clase_grupal_id',$id)->where('tipo',5)->first();
            $clase_6 = Progreso::where('clase_grupal_id',$id)->where('tipo',6)->first();
            $clase_7 = Progreso::where('clase_grupal_id',$id)->where('tipo',7)->first();
            $clase_8 = Progreso::where('clase_grupal_id',$id)->where('tipo',8)->first();
            $clase_9 = Progreso::where('clase_grupal_id',$id)->where('tipo',9)->first();
            $clase_10 = Progreso::where('clase_grupal_id',$id)->where('tipo',10)->first();
            $clase_11 = Progreso::where('clase_grupal_id',$id)->where('tipo',11)->first();
            $clase_12 = Progreso::where('clase_grupal_id',$id)->where('tipo',12)->first();

        }else{
            $clase_1 = new Progreso;
            $clase_1->clase_grupal_id = $id;
            $clase_1->tipo = 1;
            $clase_1->save();

            $clase_2 = new Progreso;
            $clase_2->clase_grupal_id = $id;
            $clase_2->tipo = 2;
            $clase_2->save();

            $clase_3 = new Progreso;
            $clase_3->clase_grupal_id = $id;
            $clase_3->tipo = 3;
            $clase_3->save();

            $clase_4 = new Progreso;
            $clase_4->clase_grupal_id = $id;
            $clase_4->tipo = 4;
            $clase_4->save();

            $clase_5 = new Progreso;
            $clase_5->clase_grupal_id = $id;
            $clase_5->tipo = 5;
            $clase_5->save();

            $clase_6 = new Progreso;
            $clase_6->clase_grupal_id = $id;
            $clase_6->tipo = 6;
            $clase_6->save();

            $clase_7 = new Progreso;
            $clase_7->clase_grupal_id = $id;
            $clase_7->tipo = 7;
            $clase_7->save();

            $clase_8 = new Progreso;
            $clase_8->clase_grupal_id = $id;
            $clase_8->tipo = 8;
            $clase_8->save();

            $clase_9 = new Progreso;
            $clase_9->clase_grupal_id = $id;
            $clase_9->tipo = 9;
            $clase_9->save();

            $clase_10 = new Progreso;
            $clase_10->clase_grupal_id = $id;
            $clase_10->tipo = 10;
            $clase_10->save();

            $clase_11 = new Progreso;
            $clase_11->clase_grupal_id = $id;
            $clase_11->tipo = 11;
            $clase_11->save();

            $clase_12 = new Progreso;
            $clase_12->clase_grupal_id = $id;
            $clase_12->tipo = 12;
            $clase_12->save();


        }

        return view('agendar.clase_grupal.progreso')->with(['clase_1' => $clase_1, 'clase_2' => $clase_2, 'clase_3' => $clase_3, 'clase_4' => $clase_4, 'clase_5' => $clase_5, 'clase_6' => $clase_6, 'clase_7' => $clase_7, 'clase_8' => $clase_8, 'clase_9' => $clase_9, 'clase_10' => $clase_10, 'clase_11' => $clase_11, 'clase_12' => $clase_12, 'id' => $id]);
    }

    public function storeNivelaciones(Request $request)
    {
        $id = $request->id;

        $clase_1 = Progreso::where('clase_grupal_id',$id)->where('tipo',1)->first();
        $clase_2 = Progreso::where('clase_grupal_id',$id)->where('tipo',2)->first();
        $clase_3 = Progreso::where('clase_grupal_id',$id)->where('tipo',3)->first();
        $clase_4 = Progreso::where('clase_grupal_id',$id)->where('tipo',4)->first();
        $clase_5 = Progreso::where('clase_grupal_id',$id)->where('tipo',5)->first();
        $clase_6 = Progreso::where('clase_grupal_id',$id)->where('tipo',6)->first();
        $clase_7 = Progreso::where('clase_grupal_id',$id)->where('tipo',7)->first();
        $clase_8 = Progreso::where('clase_grupal_id',$id)->where('tipo',8)->first();
        $clase_9 = Progreso::where('clase_grupal_id',$id)->where('tipo',9)->first();
        $clase_10 = Progreso::where('clase_grupal_id',$id)->where('tipo',10)->first();
        $clase_11 = Progreso::where('clase_grupal_id',$id)->where('tipo',11)->first();
        $clase_12 = Progreso::where('clase_grupal_id',$id)->where('tipo',12)->first();



        $clase_1->clase_1 = $request->b1c1;
        $clase_1->clase_2 = $request->b1c2;
        $clase_1->clase_3 = $request->b1c3;
        $clase_1->clase_4 = $request->b1c4;
        $clase_1->save();


        $clase_2->clase_1 = $request->b2c1;
        $clase_2->clase_2 = $request->b2c2;
        $clase_2->clase_3 = $request->b2c3;
        $clase_2->clase_4 = $request->b2c4;
        $clase_2->save();


        $clase_3->clase_1 = $request->b3c1;
        $clase_3->clase_2 = $request->b3c2;
        $clase_3->clase_3 = $request->b3c3;
        $clase_3->clase_4 = $request->b3c4;
        $clase_3->save();

        $clase_4->clase_1 = $request->i1c1;
        $clase_4->clase_2 = $request->i1c2;
        $clase_4->clase_3 = $request->i1c3;
        $clase_4->clase_4 = $request->i1c4;
        $clase_4->save();


        $clase_5->clase_1 = $request->i2c1;
        $clase_5->clase_2 = $request->i2c2;
        $clase_5->clase_3 = $request->i2c3;
        $clase_5->clase_4 = $request->i2c4;
        $clase_5->save();


        $clase_6->clase_1 = $request->i3c1;
        $clase_6->clase_2 = $request->i3c2;
        $clase_6->clase_3 = $request->i3c3;
        $clase_6->clase_4 = $request->i3c4;
        $clase_6->save();



        $clase_7->clase_1 = $request->a1c1;
        $clase_7->clase_2 = $request->a1c2;
        $clase_7->clase_3 = $request->a1c3;
        $clase_7->clase_4 = $request->a1c4;
        $clase_7->save();


        $clase_8->clase_1 = $request->a2c1;
        $clase_8->clase_2 = $request->a2c2;
        $clase_8->clase_3 = $request->a2c3;
        $clase_8->clase_4 = $request->a2c4;
        $clase_8->save();


        $clase_9->clase_1 = $request->a3c1;
        $clase_9->clase_2 = $request->a3c2;
        $clase_9->clase_3 = $request->a3c3;
        $clase_9->clase_4 = $request->a3c4;
        $clase_9->save();

        $clase_10->clase_1 = $request->m1c1;
        $clase_10->clase_2 = $request->m1c2;
        $clase_10->clase_3 = $request->m1c3;
        $clase_10->clase_4 = $request->m1c4;
        $clase_10->save();

        $clase_11->clase_1 = $request->m2c1;
        $clase_11->clase_2 = $request->m2c2;
        $clase_11->clase_3 = $request->m2c3;
        $clase_11->clase_4 = $request->m2c4;
        $clase_11->save();

        $clase_12->clase_1 = $request->m3c1;
        $clase_12->clase_2 = $request->m3c2;
        $clase_12->clase_3 = $request->m3c3;
        $clase_12->clase_4 = $request->m3c4;
        $clase_12->save();

        return response()->json(['mensaje' => '¡Excelente! El Alumno se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
    
    }

    public function cancelarClase(Request $request){

        if($request->tipo == 1)
        {

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

            $fecha = explode(" - ", $request->fecha);

            $fecha_inicio = Carbon::createFromFormat('d/m/Y', $request->fecha);
            $fecha_final = $fecha_inicio;
            

        }else if($request->tipo == 2){

            $rules = [

                'fecha2' => 'required',

            ];

            $messages = [

                'fecha2.required' => 'Ups! La fecha es requerida',

            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()){

                return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

            }

            $fecha = explode(" - ", $request->fecha2);

            $fecha_inicio = Carbon::createFromFormat('d/m/Y', $fecha[0]);
            $fecha_final = Carbon::createFromFormat('d/m/Y', $fecha[1]);
            
        }else{

            $fecha_inicio = "1969-01-31";
            $fecha_final = "1969-01-31";

            $horario_clase_grupal = HorarioClaseGrupal::where('clase_grupal_id', $request->id)->delete();
            $clasegrupal = ClaseGrupal::find($request->id)->delete();
        }

        $clasegrupal = new HorarioBloqueado;
        $clasegrupal->tipo_id = $request->id;
        $clasegrupal->tipo = 1;
        $clasegrupal->fecha_inicio = $fecha_inicio;
        $clasegrupal->fecha_final = $fecha_final;
        $clasegrupal->razon_cancelacion = $request->razon_cancelacion;
        $clasegrupal->boolean_mostrar = $request->boolean_mostrar;

        if($clasegrupal->save()){
            Session::forget('fecha_inicio');
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        
    }

    public function principalnivelaciones(Request $request){

        $instructor = Instructor::find(Auth::user()->usuario_id);

        if(!$instructor->boolean_administrador){

            $clase_grupal_join = DB::table('clases_grupales')
                ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.id', 'clases_grupales.fecha_inicio', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'clases_grupales.boolean_promocionar', 'clases_grupales.dias_prorroga')
                ->where('clases_grupales.instructor_id','=', Auth::user()->usuario_id)
                ->where('clases_grupales.deleted_at', '=', null)
                ->OrderBy('clases_grupales.hora_inicio')
            ->get();

            $horarios_clase_grupales = DB::table('horario_clase_grupales')
                ->join('config_especialidades', 'horario_clase_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->join('config_estudios', 'horario_clase_grupales.estudio_id', '=', 'config_estudios.id')
                ->join('instructores', 'horario_clase_grupales.instructor_id', '=', 'instructores.id')
                ->join('clases_grupales', 'horario_clase_grupales.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'config_estudios.nombre as estudio_nombre', 'horario_clase_grupales.hora_inicio','horario_clase_grupales.hora_final', 'clases_grupales.id', 'horario_clase_grupales.fecha as fecha_inicio', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'clases_grupales.boolean_promocionar', 'clases_grupales.dias_prorroga', 'horario_clase_grupales.id as horario_id')
                ->where('clases_grupales.instructor_id','=', Auth::user()->usuario_id)
                ->where('horario_clase_grupales.deleted_at', '=', null)
                ->OrderBy('horario_clase_grupales.hora_inicio')
            ->get();

        }else{

            $clase_grupal_join = DB::table('clases_grupales')
                ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.id', 'clases_grupales.fecha_inicio', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'clases_grupales.boolean_promocionar', 'clases_grupales.dias_prorroga')
                ->where('clases_grupales.deleted_at', '=', null)
                ->OrderBy('clases_grupales.hora_inicio')
            ->get();

            $horarios_clase_grupales = DB::table('horario_clase_grupales')
                ->join('config_especialidades', 'horario_clase_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->join('config_estudios', 'horario_clase_grupales.estudio_id', '=', 'config_estudios.id')
                ->join('instructores', 'horario_clase_grupales.instructor_id', '=', 'instructores.id')
                ->join('clases_grupales', 'horario_clase_grupales.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'config_estudios.nombre as estudio_nombre', 'horario_clase_grupales.hora_inicio','horario_clase_grupales.hora_final', 'clases_grupales.id', 'horario_clase_grupales.fecha as fecha_inicio', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'clases_grupales.boolean_promocionar', 'clases_grupales.dias_prorroga', 'horario_clase_grupales.id as horario_id')
                ->where('horario_clase_grupales.deleted_at', '=', null)
                ->OrderBy('horario_clase_grupales.hora_inicio')
            ->get();

        }

        $array = array();

        $academia = Academia::find(Auth::user()->academia_id);

        foreach($clase_grupal_join as $clase_grupal){
            $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
            $dia_de_semana = $fecha->dayOfWeek;

            if($fecha > Carbon::now()){
                $inicio = 0;
            }else{
                $inicio = 1;
            }

            $collection=collect($clase_grupal);     
            $clase_grupal_array = $collection->toArray();
            
            $clase_grupal_array['dia_de_semana']=$dia_de_semana;
            $clase_grupal_array['inicio']=$inicio;
            $array['1-'.$clase_grupal->id] = $clase_grupal_array;
        }

        foreach($horarios_clase_grupales as $clase_grupal){
            $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
            $dia_de_semana = $fecha->dayOfWeek;

            if($fecha > Carbon::now()){
                $inicio = 0;
            }else{
                $inicio = 1;
            }

            $collection=collect($clase_grupal);     
            $clase_grupal_array = $collection->toArray();
            
            $clase_grupal_array['dia_de_semana']=$dia_de_semana;
            $clase_grupal_array['inicio']=$inicio;
            $array['2-'.$clase_grupal->horario_id] = $clase_grupal_array;
        }

        $actual = Carbon::now();
        $geoip = new GeoIP();
        $geoip->setIp($request->ip());
        $actual->tz = $geoip->getTimezone();
        $hoy = $actual->dayOfWeek;

        return view('vista_instructor.nivelaciones')->with(['clase_grupal_join' => $array, 'hoy' => $hoy, 'academia' => $academia]);

        
    }

    public function clases_grupales_vista_instructor(Request $request){

        $instructor = Instructor::find(Auth::user()->usuario_id);

        if(!$instructor->boolean_administrador){

            $clase_grupal_join = DB::table('clases_grupales')
                ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.id', 'clases_grupales.fecha_inicio', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'clases_grupales.boolean_promocionar', 'clases_grupales.dias_prorroga')
                ->where('clases_grupales.instructor_id','=', Auth::user()->usuario_id)
                ->where('clases_grupales.deleted_at', '=', null)
                ->OrderBy('clases_grupales.hora_inicio')
            ->get();

            $horarios_clase_grupales = DB::table('horario_clase_grupales')
                ->join('config_especialidades', 'horario_clase_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->join('config_estudios', 'horario_clase_grupales.estudio_id', '=', 'config_estudios.id')
                ->join('instructores', 'horario_clase_grupales.instructor_id', '=', 'instructores.id')
                ->join('clases_grupales', 'horario_clase_grupales.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'config_estudios.nombre as estudio_nombre', 'horario_clase_grupales.hora_inicio','horario_clase_grupales.hora_final', 'clases_grupales.id', 'horario_clase_grupales.fecha as fecha_inicio', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'clases_grupales.boolean_promocionar', 'clases_grupales.dias_prorroga', 'horario_clase_grupales.id as horario_id')
                ->where('clases_grupales.instructor_id','=', Auth::user()->usuario_id)
                ->where('horario_clase_grupales.deleted_at', '=', null)
                ->OrderBy('horario_clase_grupales.hora_inicio')
            ->get();

        }else{

            $clase_grupal_join = DB::table('clases_grupales')
                ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.id', 'clases_grupales.fecha_inicio', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'clases_grupales.boolean_promocionar', 'clases_grupales.dias_prorroga')
                ->where('clases_grupales.deleted_at', '=', null)
                ->OrderBy('clases_grupales.hora_inicio')
            ->get();

            $horarios_clase_grupales = DB::table('horario_clase_grupales')
                ->join('config_especialidades', 'horario_clase_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->join('config_estudios', 'horario_clase_grupales.estudio_id', '=', 'config_estudios.id')
                ->join('instructores', 'horario_clase_grupales.instructor_id', '=', 'instructores.id')
                ->join('clases_grupales', 'horario_clase_grupales.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'config_estudios.nombre as estudio_nombre', 'horario_clase_grupales.hora_inicio','horario_clase_grupales.hora_final', 'clases_grupales.id', 'horario_clase_grupales.fecha as fecha_inicio', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'clases_grupales.boolean_promocionar', 'clases_grupales.dias_prorroga', 'horario_clase_grupales.id as horario_id')
                ->where('horario_clase_grupales.deleted_at', '=', null)
                ->OrderBy('horario_clase_grupales.hora_inicio')
            ->get();

        }

        $array = array();

        $academia = Academia::find(Auth::user()->academia_id);

        foreach($clase_grupal_join as $clase_grupal){
            $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
            $dia_de_semana = $fecha->dayOfWeek;

            if($fecha > Carbon::now()){
                $inicio = 0;
            }else{
                $inicio = 1;
            }

            $collection=collect($clase_grupal);     
            $clase_grupal_array = $collection->toArray();
            
            $clase_grupal_array['dia_de_semana']=$dia_de_semana;
            $clase_grupal_array['inicio']=$inicio;
            $array['1-'.$clase_grupal->id] = $clase_grupal_array;
        }

        foreach($horarios_clase_grupales as $clase_grupal){
            $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
            $dia_de_semana = $fecha->dayOfWeek;

            if($fecha > Carbon::now()){
                $inicio = 0;
            }else{
                $inicio = 1;
            }

            $collection=collect($clase_grupal);     
            $clase_grupal_array = $collection->toArray();
            
            $clase_grupal_array['dia_de_semana']=$dia_de_semana;
            $clase_grupal_array['inicio']=$inicio;
            $array['2-'.$clase_grupal->horario_id] = $clase_grupal_array;
        }

        $actual = Carbon::now();
        $geoip = new GeoIP();
        $geoip->setIp($request->ip());
        $actual->tz = $geoip->getTimezone();
        $hoy = $actual->dayOfWeek;

        return view('vista_instructor.clase_grupal')->with(['clase_grupal_join' => $array, 'hoy' => $hoy, 'academia' => $academia]);

        
    }
    public function historial_asistencia($id){

        $inscripcion_clase_grupal = InscripcionClaseGrupal::find($id);

        $clase_grupal = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
          ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
          ->select('clases_grupales.*', 'config_clases_grupales.nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido')
          ->where('clases_grupales.id',$inscripcion_clase_grupal->clase_grupal_id)
        ->first();

        $horarios_clase_grupales = HorarioClaseGrupal::join('clases_grupales', 'horario_clase_grupales.clase_grupal_id', '=', 'clases_grupales.id')
          ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
          ->join('instructores', 'horario_clase_grupales.instructor_id', '=', 'instructores.id')
          ->select('horario_clase_grupales.*')
          ->where('clases_grupales.id',$inscripcion_clase_grupal->clase_grupal_id)
        ->get();

        $alumno = Alumno::find($inscripcion_clase_grupal->alumno_id);
        $alumno_id = $inscripcion_clase_grupal->alumno_id;
        $clase_grupal_id = $inscripcion_clase_grupal->clase_grupal_id;
        $fecha_clase_grupal = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);

        $i = $fecha_clase_grupal->dayOfWeek;

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

        $dia_principal = $dia;

        $array = array();

        $j = 0;

        while($fecha_clase_grupal < Carbon::now())
        {
            $fecha_a_comparar = $fecha_clase_grupal;
            $fecha_a_comparar = $fecha_a_comparar->toDateString();
            $asistencia = Asistencia::where('alumno_id',$alumno_id)->where('clase_grupal_id',$clase_grupal_id)->where('fecha',$fecha_a_comparar)->first();
            if($asistencia){
                $asistio = 'zmdi c-verde zmdi-check zmdi-hc-fw f-20';
                $hora = $asistencia->hora;

                $fecha = Carbon::createFromFormat('Y-m-d', $asistencia->fecha);
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
            }else{
                $asistio = 'zmdi c-youtube zmdi-close zmdi-hc-fw f-20';
                $hora = '';
                $dia = '';
            }
            $array[]=array('id' => $j, 'fecha' => $fecha_a_comparar, 'asistio' => $asistio, 'hora' => $hora, 'dia' => $dia);

            $fecha_clase_grupal->addWeek();
            $j = $j + 1;
        }

        foreach($horarios_clase_grupales as $horario){

            $fecha_horario = Carbon::parse($horario->fecha);

            while($fecha_horario < Carbon::now())
            {
                $fecha_a_comparar = $fecha_horario;
                $fecha_a_comparar = $fecha_a_comparar->toDateString();
                $asistencia = Asistencia::where('alumno_id',$alumno_id)->where('tipo',2)->where('tipo_id',$horario->id)->where('fecha',$fecha_a_comparar)->first();
                if($asistencia){
                    $asistio = 'zmdi c-verde zmdi-check zmdi-hc-fw f-20';
                    $hora = $asistencia->hora;

                    $fecha = Carbon::createFromFormat('Y-m-d', $asistencia->fecha);
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
                }else{
                    $asistio = 'zmdi c-youtube zmdi-close zmdi-hc-fw f-20';
                    $hora = '';
                    $dia = '';
                }
                $array[]=array('id' => $j, 'fecha' => $fecha_a_comparar, 'asistio' => $asistio, 'hora' => $hora, 'dia' => $dia);

                $fecha_horario->addWeek();
                $j = $j + 1;
            }
        }

        return view('agendar.clase_grupal.historial')->with(['asistencias' => $array, 'clase_grupal' => $clase_grupal, 'alumno' => $alumno, 'dia' => $dia_principal]);
        
    }

    public function agenda($id){

        $clase = DB::table('config_clases_grupales')
                ->join('clases_grupales', 'config_clases_grupales.id', '=', 'clases_grupales.clase_grupal_id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->select('clases_grupales.*', 'config_clases_grupales.nombre', 'config_clases_grupales.descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'config_especialidades.nombre as especialidad', 'config_clases_grupales.nombre')
                ->where('clases_grupales.id', '=' ,  $id)
        ->first();

        $nombre = $clase->nombre;

        $horarios_clasegrupal = DB::table('config_clases_grupales')
                ->join('clases_grupales', 'config_clases_grupales.id', '=', 'clases_grupales.clase_grupal_id')
                ->join('horario_clase_grupales', 'clases_grupales.id', '=', 'horario_clase_grupales.clase_grupal_id')
                ->join('config_especialidades', 'horario_clase_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->join('instructores', 'horario_clase_grupales.instructor_id', '=', 'instructores.id')
                ->select('clases_grupales.fecha_final', 'horario_clase_grupales.fecha as fecha_inicio', 'horario_clase_grupales.hora_inicio', 'horario_clase_grupales.hora_final', 'clases_grupales.color_etiqueta as clase_etiqueta', 'horario_clase_grupales.color_etiqueta', 'config_clases_grupales.nombre', 'config_clases_grupales.descripcion', 'clases_grupales.id', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'config_especialidades.nombre as especialidad')
                ->where('clases_grupales.id', '=' ,  $id)
        ->get();


        $fecha_start=explode('-',$clase->fecha_inicio);
        $fecha_end=explode('-',$clase->fecha_final);

        $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
        $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

        $id=$clase->id;
        $nombre=$clase->nombre;
        $descripcion=$clase->descripcion;
        $hora_inicio=$clase->hora_inicio;
        $hora_final=$clase->hora_final;
        $fecha_inicio = $dt->toDateString();
        $fecha_final = $df->toDateString();
        $instructor = $clase->instructor_nombre . ' ' .$clase->instructor_apellido;
        if($clase->color_etiqueta){
            $etiqueta=$clase->color_etiqueta;
        }else{
            $etiqueta=$clase->clase_etiqueta;
        }

        $arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-grupales/operaciones/".$id, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido);

        $c=0;

        
        while($dt->timestamp<$df->timestamp){
            $fecha="";
            $fecha=$dt->addWeek()->toDateString();

            $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', $fecha)
                ->where('fecha_final', '>=', $fecha)
                ->where('tipo_id', $id)
                ->where('tipo', 1)
            ->first();

            if(!$horario_bloqueado){

                $arrayClases[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-grupales/operaciones/".$id, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido);
            }else{
                if($horario_bloqueado->boolean_mostrar == 1)
                {
                    $arrayClases[]=array("id"=>$id,"nombre"=>"CLASE CANCELADA","descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"cancelada!".$horario_bloqueado->razon_cancelacion."!".$instructor."!".$fecha_inicio." - ".$fecha_final."!".$hora_inicio." - ".$hora_final, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido);
                 }
            }
            
            $c++;
        }

 

        foreach ($horarios_clasegrupal as $clase) {
            $fecha_start=explode('-',$clase->fecha_inicio);
            $fecha_end=explode('-',$clase->fecha_final);

            $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
            $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

            $id=$clase->id;
            $nombre=$clase->nombre;
            $descripcion=$clase->descripcion;
            $hora_inicio=$clase->hora_inicio;
            $hora_final=$clase->hora_final;
            $fecha_inicio = $dt->toDateString();
            $fecha_final = $df->toDateString();
            $etiqueta=$clase->color_etiqueta;
            $instructor = $clase->instructor_nombre . ' ' .$clase->instructor_apellido;


            $fecha_inicio = $dt->toDateString();
            $fecha_final = $df->toDateString();

            $arrayClases[]=array("id"=>$id, "fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-grupales/operaciones/".$id, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido);

            $c=0;

            
            while($dt->timestamp<$df->timestamp){
                $fecha="";
                $fecha=$dt->addWeek()->toDateString();

                $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', $fecha)
                    ->where('fecha_final', '>=', $fecha)
                    ->where('tipo_id', $id)
                    ->where('tipo', 1)
                ->first();

                 if(!$horario_bloqueado){

                    $arrayClases[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-grupales/operaciones/".$id, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido);
                }else{
                    if($horario_bloqueado->boolean_mostrar == 1)
                    {
                        $arrayClases[]=array("id"=>$id,"nombre"=>"CLASE CANCELADA","descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"cancelada!".$horario_bloqueado->razon_cancelacion."!".$instructor."!".$fecha_inicio." - ".$fecha_final."!".$hora_inicio." - ".$hora_final, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido);
                     }
                }
                $c++;
            }

        }

        return view('agendar.clase_grupal.agenda')->with(['fechas' => $arrayClases, 'nombre' => $nombre, 'id' => $id]);
    }


}