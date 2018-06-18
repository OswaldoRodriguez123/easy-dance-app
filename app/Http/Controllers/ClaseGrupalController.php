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
use App\ConfigProductos;
use App\ConfigServicios;
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
use App\Reservacion;
use App\Participante;
use App\Codigo;
use App\Examen;
use App\CredencialAlumno;
use App\CredencialInstructor;
use App\Staff;
use App\Visitante;
use App\User;
use App\Promocion;
use App\LlamadaAlumno;
use App\Tipologia;
use App\Certificado;
use App\ConfigComision;
use App\ConfigPagosInstructor;
use PulkitJalan\GeoIP\GeoIP;


class ClaseGrupalController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function principal(Request $request){

        $clase_grupal_join = ClaseGrupal::join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
            ->leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->join('config_niveles_baile', 'clases_grupales.nivel_baile_id', '=', 'config_niveles_baile.id')
            ->select('clases_grupales.*', 'config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id', 'instructores.sexo', 'config_estudios.nombre as salon', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'config_niveles_baile.nombre as nivel')
            ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
            ->OrderBy('clases_grupales.hora_inicio')
        ->get();

        $horarios_clase_grupales = HorarioClaseGrupal::join('config_especialidades', 'horarios_clases_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_estudios', 'horarios_clases_grupales.estudio_id', '=', 'config_estudios.id')
            ->leftJoin('instructores', 'horarios_clases_grupales.instructor_id', '=', 'instructores.id')
            ->join('clases_grupales', 'horarios_clases_grupales.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('config_niveles_baile', 'clases_grupales.nivel_baile_id', '=', 'config_niveles_baile.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id', 'instructores.sexo', 'config_estudios.nombre as salon', 'horarios_clases_grupales.hora_inicio','horarios_clases_grupales.hora_final', 'clases_grupales.id', 'horarios_clases_grupales.fecha as fecha_inicio', 'clases_grupales.fecha_inicio as fecha_inicio_clase', 'clases_grupales.fecha_final', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'clases_grupales.boolean_promocionar', 'clases_grupales.dias_prorroga', 'horarios_clases_grupales.id as horario_id', 'config_niveles_baile.nombre as nivel')
            ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
            ->where('clases_grupales.deleted_at', '=', null)
            ->OrderBy('horarios_clases_grupales.hora_inicio')
        ->get();

        $array = array();

        $academia = Academia::find(Auth::user()->academia_id);
        $usuario_tipo = Session::get('easydance_usuario_tipo');
        $usuario_id = Session::get('easydance_usuario_id');

        if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6){

            foreach($clase_grupal_join as $clase_grupal){

                $cantidad_participantes = InscripcionClaseGrupal::where('clase_grupal_id',$clase_grupal->id)->count();

                $fecha_inicio = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
                
                if($fecha_inicio >= Carbon::now()){
                    $inicio = 0;
                }else{
                    $inicio = 1;
                }

                $dia_de_semana = $fecha_inicio->dayOfWeek;

                if($dia_de_semana == 0){
                    $dia_de_semana = 7;
                } 

                $fecha_final = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_final);

                if($fecha_final > Carbon::now()){
                    $estatus = 1;
                }else{
                    $estatus = 2;
                }

                if($academia->tipo_horario == 2){
                    $hora_inicio = Carbon::createFromFormat('H:i:s',$clase_grupal->hora_inicio)->toTimeString();
                    $hora_final = Carbon::createFromFormat('H:i:s',$clase_grupal->hora_final)->toTimeString();
                }else{
                    $hora_inicio = Carbon::createFromFormat('H:i:s',$clase_grupal->hora_inicio)->format('g:i a');
                    $hora_final = Carbon::createFromFormat('H:i:s',$clase_grupal->hora_final)->format('g:i a');
                }

                $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                    ->where('usuarios_tipo.tipo_id',$clase_grupal->instructor_id)
                    ->where('usuarios_tipo.tipo',3)
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

                $collection=collect($clase_grupal);     
                $clase_grupal_array = $collection->toArray();

                $clase_grupal_array['imagen']=$imagen;
                $clase_grupal_array['cantidad_participantes']=$cantidad_participantes;
                $clase_grupal_array['dia_de_semana']=$dia_de_semana;
                $clase_grupal_array['hora_inicio']=$hora_inicio;
                $clase_grupal_array['hora_final']=$hora_final;
                $clase_grupal_array['inicio']=$inicio;
                $clase_grupal_array['estatus']=$estatus;
                $array['1-'.$clase_grupal->id] = $clase_grupal_array;
            }

            foreach($horarios_clase_grupales as $clase_grupal){

                $cantidad_participantes = InscripcionClaseGrupal::where('clase_grupal_id',$clase_grupal->id)->count();

                $fecha_inicio_clase = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio_clase);

                if($fecha_inicio_clase >= Carbon::now()){
                    $inicio = 0;
                }else{
                    $inicio = 1;
                }

                $fecha_inicio = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);

                $dia_de_semana = $fecha_inicio->dayOfWeek;

                if($dia_de_semana == 0){
                    $dia_de_semana = 7;
                } 

                $fecha_final = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_final);
                
                if($fecha_final > Carbon::now()){
                    $estatus = 1;
                }else{
                    $estatus = 2;
                }

                if($academia->tipo_horario == 2){
                    $hora_inicio = Carbon::createFromFormat('H:i:s',$clase_grupal->hora_inicio)->toTimeString();
                    $hora_final = Carbon::createFromFormat('H:i:s',$clase_grupal->hora_final)->toTimeString();
                }else{
                    $hora_inicio = Carbon::createFromFormat('H:i:s',$clase_grupal->hora_inicio)->format('g:i a');
                    $hora_final = Carbon::createFromFormat('H:i:s',$clase_grupal->hora_final)->format('g:i a');
                }

                $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                    ->where('usuarios_tipo.tipo_id',$clase_grupal->instructor_id)
                    ->where('usuarios_tipo.tipo',3)
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

                $collection=collect($clase_grupal);     
                $clase_grupal_array = $collection->toArray();
                
                $clase_grupal_array['imagen']=$imagen;
                $clase_grupal_array['cantidad_participantes']=$cantidad_participantes;
                $clase_grupal_array['dia_de_semana']=$dia_de_semana;
                $clase_grupal_array['hora_inicio']=$hora_inicio;
                $clase_grupal_array['hora_final']=$hora_final;
                $clase_grupal_array['inicio']=$inicio;
                $clase_grupal_array['estatus']=$estatus;
                $array['2-'.$clase_grupal->horario_id] = $clase_grupal_array;
            }

            $actual = Carbon::now();
            // $geoip = new GeoIP();
            // $geoip->setIp($request->ip());
            // $actual->tz = $geoip->getTimezone();

            $hoy = $actual->dayOfWeek;
            if($hoy == 0){
                $hoy = 7;
            } 

            $fecha_inicio = Session::get('fecha_inicio');

            return view('agendar.clase_grupal.principal')->with(['clase_grupal_join' => $array, 'hoy' => $hoy, 'academia' => $academia, 'fecha_inicio' => $fecha_inicio]);

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
            ->leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
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

    public function participantes($id)
    {

        $array = array();
        $credenciales = array();

        $usuario_tipo = Session::get('easydance_usuario_tipo');

        $mujeres = 0;
        $hombres = 0;

        $clasegrupal = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_clases_grupales.*', 'clases_grupales.fecha_inicio_preferencial', 'clases_grupales.fecha_inicio', 'clases_grupales.fecha_final', 'clases_grupales.id as clase_grupal_id', 'instructores.id as instructor_id')
            ->where('clases_grupales.id', '=', $id)
        ->first();

        if($clasegrupal){

            $alumnos_inscritos = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
                ->select('alumnos.*', 'inscripcion_clase_grupal.fecha_pago', 'inscripcion_clase_grupal.costo_mensualidad', 'inscripcion_clase_grupal.id as inscripcion_id', 'inscripcion_clase_grupal.alumno_id', 'inscripcion_clase_grupal.boolean_franela', 'inscripcion_clase_grupal.boolean_programacion', 'inscripcion_clase_grupal.talla_franela', 'inscripcion_clase_grupal.fecha_inscripcion','inscripcion_clase_grupal.fecha_a_comprobar', 'inscripcion_clase_grupal.nota_administrativa')
                ->where('inscripcion_clase_grupal.clase_grupal_id', '=', $id)
                ->where('inscripcion_clase_grupal.boolean_congelacion',0)
                ->where('alumnos.deleted_at', '=', null)
            ->get();

            $fecha_inicio = Carbon::createFromFormat('Y-m-d', $clasegrupal->fecha_inicio);
            $fecha_final = Carbon::createFromFormat('Y-m-d', $clasegrupal->fecha_final);
            $dia_inicio = $fecha_inicio->dayOfWeek;

            $tipo_clase = array(1,2);
            $in = array(2,4);
            $in_credencial = array(0,$clasegrupal->instructor_id);

            //RESERVACIONES

            $reservaciones = Reservacion::where('tipo_reservacion_id', '=', $id)
                ->where('tipo_reservacion', '=', '1')
            ->get();

            foreach($reservaciones as $reservacion){

                $fecha_vencimiento = Carbon::createFromFormat('Y-m-d', $reservacion->fecha_vencimiento);
                if($fecha_vencimiento < Carbon::now()->format('Y-m-d')){

                    $reservacion->deleted_at = Carbon::now();
                    $reservacion->save();
             
                }
            }

            $reservaciones = Reservacion::where('tipo_reservacion_id', '=', $id)
                ->where('tipo_reservacion', '=', '1')
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
                                $fecha_de_realizacion = "Mañana a las ".$hora_segundos;
                            }else{
                                 $fecha_de_realizacion = "en ".$diferencia_tiempo." días";
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
                    $array['2-'.$alumno->id] = $alumno_array;
                }
            
            }

            //ALUMNOS

            if(Carbon::now() >= $fecha_inicio){

                //CONFIGURACIONES DE ASISTENCIAS

                $asistencia_roja = $clasegrupal->asistencia_rojo;
                $asistencia_amarilla = $clasegrupal->asistencia_amarilla;

                //CREAR ARREGLO DE CLASES GRUPALES A CONSULTAR EN LA ASISTENCIA

                if(Carbon::now() <= $fecha_final){
                    $fecha_de_finalizacion = Carbon::now();
                }else{
                    $fecha_de_finalizacion = $fecha_final;
                }

                $dia_inicio_clase = $fecha_inicio->dayOfWeek;

                if($dia_inicio_clase == 0){
                    $dia_inicio_clase = 7;
                }

                //CREAR ARREGLO DE CLASES GRUPALES A CONSULTAR EN LA ASISTENCIA

                $horarios_clases_grupales = HorarioClaseGrupal::where('clase_grupal_id', $id)
                    ->orderBy('fecha')
                ->get();

                //ARRAYS CREADO CON EL FIN DE ESTABLECER LOS SALTOS DE DIAS ENTRE CADA CLASE Y SUS MULTIHORARIOS QUE TENDRA LA CONSULTA DE ASISTENCIA, EL ORGANIZADOR ESTABLECE EN LA PRIMERA POSICIÓN EL PRIMER MULTIHORARIO QUE TENGA, Y DE ULTIMO LA CLASE PRINCIPAL PARA PODER REALIZAR EL CICLO CORRECTAMENTE, EL ARRAY DE DIAS SIMPLEMENTE SE USARA PARA LAS CONSULTAS

                $array_organizador = array();
                $array_organizador_before = array();
                $array_organizador_after = array();
                $array_dias = array();

                //ARRAY DE BUSQUEDA EN ASISTENCIAS

                $tipo_id = array();
                $tipo_id[] = intval($id);

                // 1.1 -- ARRAY CREADO PARA ESTABLECER EL INDEX CON EL QUE SE COMENZARA A REALIZAR LA BUSQUEDA POR SI LA ULTIMA ASISTENCIA FUE REALIZADA EN UN MULTIHORARIO, ESTO CON LA FINALIDAD DE SABER QUE INDEX CORRESPONDE DESPUES EN LA CONSULTA

                $array_dias_clases = array();
                $array_dias_clases_before = array();
                $array_dias_clases_after = array();

                //ESTABLECE EL DIA PRINCIPAL COMO PRIMER INDEX DEL ARRAY DE DIAS

                $array_dias_clases[] = $dia_inicio_clase;

                //SE CREA EL ARRAY ORGANIZADOR Y EL ARRAY DE DIAS

                foreach($horarios_clases_grupales as $horario){

                    $tipo_id[] = $horario->id;
                    $fecha_horario = Carbon::createFromFormat('Y-m-d', $horario->fecha);
                    $dia_horario = $fecha_horario->dayOfWeek;

                    if($dia_horario == 0){
                        $dia_horario = 7;
                    }

                    if($dia_inicio_clase >= $dia_horario){
                        $array_dias_clases_before[] = $dia_horario;
                        $array_organizador_before[] = $dia_horario;
                    }else{
                        $array_dias_clases_after[] = $dia_horario;
                        $array_organizador_after[] = $dia_horario;
                    }

                }

                //SE ORDENA EL ARREGLO DE DIAS ANTERIORES A LA CLASE PRINCIPAL

                usort($array_dias_clases_before, function($a, $b) {
                    return $a - $b;
                });

                usort($array_organizador_before, function($a, $b) {
                    return $a - $b;
                });

                //ESTE PROCESO SE HACE PARA QUE LA CLASE PRINCIPAL SEA LA PRIMERA EN CONSULTAR, LUEGO SERAN LAS CLASES POSTERIORES A ELLA Y POR ULTIMO LAS CLASES ANTERIORES, PARA QUE EL CICLO AGREGUE UNA SEMANA ANTES DE CONSULTAR LAS CLASES ANTERIORES

                $merge = array_merge($array_dias_clases, $array_dias_clases_after);
                $array_dias_clases = array_merge($merge, $array_dias_clases_before);
                $array_organizador = array_merge($array_organizador_after, $array_dias_clases_before);

                //SE ESTABLECE QUE SI NO HAY MULTIHORARIO, EL ARRAY DE DIA SOLO TENDRA UNA POSICIÓN DE 7, PARA QUE LAS CONSULTAS SE HAGAN SEMANALMENTE

                //SI SOLO TIENE UN MULTIHORARIO, LA PRIMERA POSICIÓN SERA LA CANTIDAD DE DIAS QUE LE FALTA A LA CLASE PRINCIPAL PARA LLEGAR AL DIA DEL MULTIHORARIO, LA ULTIMA SERA LA CANTIDAD DE DIAS PARA LLEGAR DE NUEVO A LA CLASE PRINCIPAL, TENDRA SOLO 2 POSICIONES

                // SI TIENE MAS DE UN MULTIHORARIO, ESTABLECERA UN CICLO PARA VER CUANTOS DIAS HAY ENTRE CADA MULTIHORARIO, DEJANDO POR ULTIMO LA CLASE PRINCIPAL PARA REPETIR EL CICLO

                //LA CONSULTA DE LOS MULTIHORARIOS LOS ORDENARA POR FECHA PARA ASI SOLO TENER QUE ESTABLECER LA CANTIDAD DE DIAS ENTRE ELLOS

                if($array_organizador){

                    $dias_a_sumar = 0;
                    
                    if(count($array_organizador) == 1){

                        $dia_inicio_horario = $array_organizador[0];

                        if($dia_inicio_clase  > $dia_inicio_horario){

                            while ($dia_inicio_clase != 7){
                                $dias_a_sumar++;
                                $dia_inicio_clase++;
                            }

                            $array_dias[] = $dias_a_sumar + $dia_inicio_horario;
                            $dia_inicio_clase = $fecha_inicio->dayOfWeek;
                            $dias = abs(intval($dia_inicio_horario) - intval($dia_inicio_clase));
                            $array_dias[] = $dias;

                        }else{

                            $dias = abs(intval($dia_inicio_clase) - intval($dia_inicio_horario));
                            $array_dias[] = $dias;

                            while ($dia_inicio_horario != 7){
                                $dias_a_sumar++;
                                $dia_inicio_horario++;
                            }

                            $array_dias[] = $dias_a_sumar + $dia_inicio_clase;
                        }
                    }else{

                        $dias_a_restar = $dia_inicio_clase;

                        foreach($array_organizador as $index => $organizador){

                            //SE MIDE LA CANTIDAD DE DIAS ENTRE LA CLASE PRINCIPAL Y EL PRIMER MULTIHORARIO, Y LUEGO ENTRE CADA UNO DE LOS MULTIHORARIOS

                            if($dias_a_restar < $organizador){
                                $dias_a_añadir = abs($organizador - $dias_a_restar);
                            }else{
                                $dias_a_añadir = abs(($organizador + 7) - $dias_a_restar);
                            }

                            $array_dias[] = $dias_a_añadir;
                            $dias_a_restar = $organizador;

                        }

                        if($dias_a_restar > $dia_inicio_clase){
                            $dias_a_sumar = 0;

                            while ($dias_a_restar != 7){
                                $dias_a_sumar++;
                                $dias_a_restar++;

                            }

                            $dias_a_sumar = $dias_a_sumar + $dia_inicio_clase;
                        }else{
                            $dias_a_sumar = abs($dias_a_restar - $dia_inicio_clase);
                        }

                        $array_dias[] = $dias_a_sumar;
                    }
                }else{
                    $array_dias[] = 7;
                }
            }

            $k = 0;

            foreach($alumnos_inscritos as $alumno){

                $inasistencias = 0;

                if(Carbon::now() >= $fecha_inicio){

                    //CONSULTAR LA ULTIMA ASISTENCIA, EL TIPO ES 1 (CLASE PRINCIPAL) Y 2 (MULTIHORARIO), EL TIPO_ID ES UN ARRAY CON EL ID DE LA CLASE PRINCIPAL Y LOS MULTIHORARIOS QUE POSEA
     
                    $ultima_asistencia = Asistencia::whereIn('tipo',$tipo_clase)
                        ->whereIn('tipo_id',$tipo_id)
                        ->where('alumno_id', $alumno->id)
                        ->orderBy('created_at', 'desc')
                    ->first();

                    //SI POSEE UNA ASISTENCIA, EL COMPARARA DESDE ESE DIA, SINO, ESTE TOMARA EL DIA EN QUE EL ALUMNO SE INSCRIBIO

                    //NOTA IMPORTANTE: PARA NO ROMPER EL CICLO CON LA FECHA DE LA INSCRIPCION, EL PROCESO CONVERTIRA ESTA FECHA A UNA QUE CONCUERDE CON LA CLASE PRINCIPAL O ALGUN MULTIHORARIO, SINO LAS CONSULTAS NUNCA FUNCIONARAN

                    if($ultima_asistencia){
                        $fecha_asistencia_inicio = Carbon::createFromFormat('Y-m-d', $ultima_asistencia->fecha);
                        $j = 0;
                    }else{
                        $fecha_asistencia_inicio = Carbon::createFromFormat('Y-m-d', $clasegrupal->fecha_inicio);     
                        $j = 1;               
                    }

                    if($clasegrupal->fecha_inscripcion){
                        $fecha_inscripcion = Carbon::createFromFormat('Y-m-d', $clasegrupal->fecha_inscripcion);
                    }else{
                        $fecha_inscripcion = '1969-01-31';
                    }

                    if($clasegrupal->fecha_a_comprobar){
                        $fecha_traspaso_admin = Carbon::createFromFormat('Y-m-d', $clasegrupal->fecha_a_comprobar);
                    }else{
                        $fecha_traspaso_admin = '1969-01-31';
                    }

                    if($fecha_asistencia_inicio > $fecha_inscripcion){
                        $fecha_a_comparar = $fecha_asistencia_inicio;
                    }else{
                        $fecha_a_comparar = $fecha_inscripcion;
                        $j = 1;
                    }

                    if($fecha_traspaso_admin > $fecha_a_comparar){
                        $fecha_a_comparar = $fecha_traspaso_admin;
                        $j = 1;
                    }

                    $dia_a_comparar = $fecha_a_comparar->dayOfWeek;

                    while(!in_array($dia_a_comparar,$array_dias_clases)){

                        $fecha_a_comparar->addDay();
                        $dia_a_comparar = $fecha_a_comparar->dayOfWeek;

                        if($dia_a_comparar != 0){
                            $dia_a_comparar = $fecha_a_comparar->dayOfWeek;
                        }else{
                            $dia_a_comparar = 7;
                        }
                    }

                    //EL INDEX INICIAL SE CREA PARA SABER DESDE DONDE SE COMENZARA A BUSCAR EN EL CICLO FOR DE ABAJO, YA DESCRITO EN LA NOTA 1.1

                    $index_inicial = array_search($dia_a_comparar, $array_dias_clases);

                    //EL CICLO WHILE SE ENCARGA DE ESTABLECER LA CANTIDAD DE INASISTENCIAS QUE POSEE LA PERSONA, ESTE AÑADERA LOS DIAS CORRESPONDIENTES DEL ARRAY DE DIAS CREADO ANTERIORMENTE

                    //1.2 -- EL $J != 0 ESTA ESTABLECIDO PARA QUE SI LA PERSONA POSEE ASISTENCIAS, ESTE NO CONTABILICE LAS INASISTENCIAS DESDE LA PRIMERA FECHA, SINO QUE REALICE UN SALTO AL SIGUIENTE INDEX

                    while($fecha_a_comparar < $fecha_de_finalizacion){
                        if($fecha_a_comparar < Carbon::now()->subDay()){
                            for($i = $index_inicial; $i < count($array_dias); $i++){

                                $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', $fecha_a_comparar)
                                    ->where('fecha_final', '>=', $fecha_a_comparar)
                                    ->where('tipo_id', $id)
                                    ->where('tipo', 1)
                                ->first();

                                if(!$horario_bloqueado){
                                    if($j != 0){
                                        $inasistencias++;
                                    }
                                }

                                $fecha_a_comparar->addDays($array_dias[$i]);

                                //PARA QUE LAS INASISTENCIAS SE EMPIECEN A CONTABILIZAR 

                                $j++;
                            }
                        }else{
                            break;
                        }

                        //EL INDEX VUELVE A 0 PARA PODER REALIZAR EL CICLO FOR DESDE EL PRINCIPIO HASTA QUE LA FECHA A COMPARAR SEA MAYOR A LA FECHA DE FINALIZACIÓN

                        $k++;
                        $index_inicial = 0;
                    }
                    
                    if($inasistencias >= $asistencia_roja && $asistencia_roja != 0){
                        $estatus="c-youtube";

                        // if($asistencia_roja > 0)
                        // {
                        //     // $alumno->deleted_at = Carbon::now();
                        //     // $alumno->save();
                        // }
                        
                        // continue;
                    }else if($inasistencias >= $asistencia_amarilla && $asistencia_amarilla != 0){
                        $estatus="c-amarillo";
                    }else{
                        $estatus="c-verde";
                    }
                }else{
                    $estatus="c-verde";
                }
                
                // ----------
             

                $deuda = ItemsFacturaProforma::where('fecha_vencimiento','<=',Carbon::today())
                    ->where('usuario_id','=',$alumno->id)
                    ->where('usuario_tipo',1)
                ->sum('importe_neto');

                $activacion = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                    ->where('usuarios_tipo.tipo_id', $alumno->id)
                    ->whereIn('usuarios_tipo.tipo', $tipo_clase)
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

                $llamadas = LlamadaAlumno::where('usuario_id',$alumno->id)->where('usuario_tipo',2)->count();
                $edad = Carbon::createFromFormat('Y-m-d', $alumno->fecha_nacimiento)->diff(Carbon::now())->format('%y');

                $collection=collect($alumno);     
                $alumno_array = $collection->toArray();

                $alumno_array['imagen'] = $imagen;
                $alumno_array['estatus'] = $estatus;
                $alumno_array['activacion']=$activacion;
                $alumno_array['deuda']=$deuda;
                $alumno_array['tipo'] = 1;
                $alumno_array['llamadas'] = $llamadas;
                $alumno_array['edad'] = $edad;

                $array[$alumno->id] = $alumno_array;

                if($alumno->sexo == 'F'){
                    $mujeres++;
                }else{
                    $hombres++;
                }

            }

            $alumnos = Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

            if($usuario_tipo == 3){
                $usuario_id = Session::get('easydance_usuario_id');
                $credenciales_instructor = CredencialInstructor::where('instructor_id',$usuario_id)->first();
                if($credenciales_instructor){
                    $total_credenciales = $credenciales_instructor->cantidad;
                }else{
                    $total_credenciales = 0;
                }
            }else{
                $total_credenciales = 0;
            }

            $clases_grupales = ClaseGrupal::leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->select('instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final', 'config_clases_grupales.nombre as clase_grupal_nombre', 'config_especialidades.nombre as especialidad_nombre' , 'clases_grupales.id', 'clases_grupales.fecha_inicio')
                ->where('clases_grupales.id', '!=' , $id)
                ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
            ->get();

            $array_clase_grupal = array();

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

                $array_clase_grupal[$clase_grupal->id] = array(
                    'nombre' => $clase_grupal->clase_grupal_nombre,
                    'instructor' => $clase_grupal->instructor_nombre . ' ' . $clase_grupal->instructor_apellido,
                    'dia_de_semana' => $dia,
                    'especialidad' => $clase_grupal->especialidad_nombre,
                    'hora_inicio' => $clase_grupal->hora_inicio,
                    'hora_final' => $clase_grupal->hora_final,
                    'id'=>$clase_grupal->id
                );
            }

            $hoy = Carbon::now()->toDateString();

            $promociones = Promocion::where('academia_id', Auth::user()->academia_id)->where('fecha_inicio', '<=', $hoy)->where('fecha_final', '>=', $hoy)->get();

            $promotores = array();

            $staffs = Staff::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

            foreach($staffs as $staff){

                $collection=collect($staff);     
                $promotor_array = $collection->toArray();

                $promotor_array['tipo']=1;
                $promotor_array['id']='1-'.$staff->id;
                $promotor_array['icono']="<i class='icon_f-staff'></i>";
                $promotores['1-'.$staff->id] = $promotor_array;
            }

            $instructores = Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

            foreach($instructores as $instructor){

                $collection=collect($instructor);     
                $promotor_array = $collection->toArray();

                $promotor_array['tipo']=2;
                $promotor_array['id']='2-'.$instructor->id;
                $promotor_array['icono']="<i class='icon_a-instructor'></i>";
                $promotores['2-'.$instructor->id] = $promotor_array;
            }

            $tipologias = Tipologia::all();

            return view('agendar.clase_grupal.participantes')->with(['alumnos_inscritos' => $array, 'id' => $id, 'clasegrupal' => $clasegrupal, 'alumnos' => $alumnos, 'mujeres' => $mujeres, 'hombres' => $hombres, 'total_credenciales' => $total_credenciales, 'clases_grupales' => $array_clase_grupal, 'promotores' => $promotores, 'promociones' => $promociones, 'usuario_tipo' => $usuario_tipo, 'tipologias' => $tipologias, 'credenciales' => $credenciales, 'in_credencial' => $in_credencial]);

        }else{
            return redirect("agendar/clases-grupales"); 
        }
        
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

            $clasegrupal = InscripcionClaseGrupal::withTrashed()->find($request->inscripcion_clase_grupal_id);

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

        $clase_grupal_join = ClaseGrupal::join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
            ->leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->join('academias', 'clases_grupales.academia_id', '=', 'academias.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.id', 'clases_grupales.cupo_reservacion', 'clases_grupales.fecha_inicio', 'clases_grupales.imagen', 'config_clases_grupales.descripcion', 'academias.imagen as imagen_academia', 'clases_grupales.link_video', 'config_clases_grupales.condiciones', 'academias.direccion', 'academias.estado', 'academias.facebook', 'academias.twitter', 'academias.instagram', 'academias.linkedin', 'academias.youtube', 'academias.pagina_web', 'academias.nombre as academia_nombre', 'academias.id as academia_id', 'config_clases_grupales.costo_inscripcion', 'config_clases_grupales.costo_mensualidad', 'clases_grupales.titulo_video', 'clases_grupales.cantidad_mujeres', 'clases_grupales.cantidad_hombres', 'clases_grupales.cupo_maximo')
            ->where('clases_grupales.id','=', $id)
        ->first();

        if($clase_grupal_join){

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

            }else{
                $link_video = '';
            }

            $cantidad_hombres_reserva = 0;
            $cantidad_mujeres_reserva = 0;

             $cantidad_hombres_inscripcion = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
                ->where('inscripcion_clase_grupal.clase_grupal_id',$id)
                ->where('alumnos.sexo','M')
            ->count();

            $reservaciones = Reservacion::where('tipo_reservacion_id',$id)
                ->where('tipo_reservacion','1')
            ->get();

            foreach($reservaciones as $reservacion){

                if($reservacion->tipo_usuario == 1){
                    $usuario = Alumno::withTrashed()->find($reservacion->tipo_usuario_id);
                    if($usuario->sexo == 'M'){
                        $cantidad_hombres_reserva++;
                    }else{
                        $cantidad_mujeres_reserva++;
                    }
                }else if($reservacion->tipo_usuario == 2){
                    $usuario = Visitante::withTrashed()->find($reservacion->tipo_usuario_id);
                    if($usuario->sexo == 'M'){
                        $cantidad_hombres_reserva++;
                    }else{
                        $cantidad_mujeres_reserva++;
                    }
                }else{
                    $usuario = Participante::find($reservacion->tipo_usuario_id);
                    if($usuario->sexo == 'M'){
                        $cantidad_hombres_reserva++;
                    }else{
                        $cantidad_mujeres_reserva++;
                    }
                }
            }

            $cantidad_hombres = $cantidad_hombres_inscripcion + $cantidad_hombres_reserva;
            $cantidad_hombres = $clase_grupal_join->cantidad_hombres - $cantidad_hombres;

            if($cantidad_hombres < 0){
                $cantidad_hombres = 0;
            }

            $cantidad_mujeres_inscripcion = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
                ->where('inscripcion_clase_grupal.clase_grupal_id',$id)
                ->where('alumnos.sexo','F')
            ->count();

            $cantidad_mujeres = $cantidad_mujeres_inscripcion + $cantidad_mujeres_reserva;
            $cantidad_mujeres = $clase_grupal_join->cantidad_mujeres - $cantidad_mujeres;

            if($cantidad_mujeres < 0){
                $cantidad_mujeres = 0;
            }

            $cupos_restantes = $clase_grupal_join->cupo_maximo - $cantidad_mujeres + $cantidad_hombres;

            $cupos_totales = $cantidad_mujeres_inscripcion + $cantidad_mujeres_reserva + $cantidad_hombres_inscripcion + $cantidad_hombres_reserva;

            // $porcentaje = intval(($cantidad_reservaciones / $cupo_reservacion) * 100);

            if($clase_grupal_join->cupo_maximo > 0){
                $porcentaje = intval(($cupos_totales / $clase_grupal_join->cupo_maximo) * 100);
            }else{
                $porcentaje = 0;
            }

            if(Auth::check()){

                $usuario_tipo = Session::get('easydance_usuario_tipo');

            }else{
                $usuario_tipo = 0;
            
            }

            return view('agendar.clase_grupal.reserva')->with(['clase_grupal' => $clase_grupal_join, 'id' => $id, 'porcentaje' => $porcentaje, 'link_video' => $link_video, 'academia' => $academia, 'cupos_restantes' => $cupos_restantes, 'usuario_tipo' => $usuario_tipo, 'inicio' => $inicio]);
        }else{
            return redirect("agendar/clases-grupales"); 
        }
    }

    public function create()
    {
        if (Session::has('horario')) {
            Session::forget('horario'); 
        }

        if (Session::has('pagos_instructor')) {
            Session::forget('pagos_instructor'); 
        }

        if (Session::has('comisiones')) {
            Session::forget('comisiones'); 
        }

        $academia = Academia::find(Auth::user()->academia_id);

        $array = array();

        $config_servicio=ConfigServicios::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

        foreach($config_servicio as $item){

            $array[]=array('id' => '1-'.$item['id'], 'nombre' => $item['nombre'] , 'tipo' => $item['tipo'], 'costo' => $item['costo']);
        }

        $config_producto=ConfigProductos::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

        foreach($config_producto as $item){

            $array[]=array('id' => '2-'.$item['id'], 'nombre' => $item['nombre'] , 'tipo' => $item['tipo'], 'costo' => $item['costo']);
           
        }

        $collection=collect($array);   
        $linea_servicio = $collection->toArray();

        return view('agendar.clase_grupal.create')->with(['config_clases_grupales' => ConfigClasesGrupales::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get(), 'dias_de_semana' => DiasDeSemana::all(), 'config_especialidades' => ConfigEspecialidades::all(), 'config_estudios' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'config_niveles' => ConfigNiveles::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->orderBy('nombre')->get(), 'instructores' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get(), 'incluye_iva' => $academia->incluye_iva, 'linea_servicio' => $linea_servicio]);
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
            // 'cupo_minimo' => 'required|numeric',
            // 'cupo_maximo' => 'required|numeric',
            // 'cupo_reservacion' => 'required|numeric',
            // 'cantidad_hombres' => 'numeric',
            // 'cantidad_mujeres' => 'numeric',
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
            // 'cupo_minimo.required' => 'Ups! La cantidad de cupos es requerida',
            // 'cupo_maximo.required' => 'Ups! La cantidad de cupos es requerida',
            // 'cupo_reservacion.required' => 'Ups! La cantidad de cupos de reservacion es requerida',
            // 'cupo_minimo.numeric' => 'Ups! La cantidad de cupos es inválido , debe contener sólo números',
            // 'cupo_maximo.numeric' => 'Ups! La cantidad de cupos es inválido , debe contener sólo números',
            // 'cupo_reservacion.numeric' => 'Ups! La cantidad de cupos es inválido , debe contener sólo números',
            // 'cantidad_hombres.numeric' => 'Ups! La cantidad es inválida , debe contener sólo números',
            // 'cantidad_mujeres.numeric' => 'Ups! La cantidad es inválida , debe contener sólo números',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            if($request->color_etiqueta == "#"){
                return response()->json(['errores' => ['color_etiqueta' => [0, 'Ups! El color de la etiqueta es requerido']], 'status' => 'ERROR'],422);
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

            if($fecha_inicio > $fecha_final){
                return response()->json(['errores' => ['fecha' => [0, 'Ups! La fecha de inicio es mayor a la fecha final']], 'status' => 'ERROR'],422);
            }

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
            $clasegrupal->hora_inicio = $hora_inicio;
            $clasegrupal->hora_final = $hora_final;
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

                $pagos_instructor = Session::get('pagos_instructor');

                if($pagos_instructor){
                    foreach($pagos_instructor as $pago){

                        $tipo = $pago['tipo'];
                        $monto = $pago['monto'];

                        $config_pagos = new ConfigPagosInstructor;

                        $config_pagos->clase_grupal_id = $clasegrupal->id;
                        $config_pagos->instructor_id = $request->instructor_id;
                        $config_pagos->tipo = $tipo;
                        $config_pagos->monto = $monto;

                        $config_pagos->save();
                    }
                }

                $comisiones = Session::get('comisiones');

                if($comisiones){
                    foreach($comisiones as $comision){

                        $servicio_producto_id = $comision['servicio_producto_id'];
                        $servicio_producto_tipo = $comision['servicio_producto_tipo'];
                        $tipo = $comision['tipo'];
                        $monto = $comision['monto'];
                        $monto_porcentaje = $comision['monto_porcentaje'];
                        $monto_minimo = $comision['monto_minimo'];

                        $config_pagos = new ConfigComision;
                        
                        $config_pagos->usuario_id = $request->instructor_id;
                        $config_pagos->usuario_tipo = 2;
                        $config_pagos->servicio_producto_id = $servicio_producto_id;
                        $config_pagos->servicio_producto_tipo = $servicio_producto_tipo;
                        $config_pagos->tipo = $tipo;
                        $config_pagos->monto = $monto;
                        $config_pagos->monto_porcentaje = $monto_porcentaje;
                        $config_pagos->monto_minimo = $monto_minimo;

                        $config_pagos->save();
                    }
                }


                $config_clase_grupal = ConfigClasesGrupales::withTrashed()->join('clases_grupales','config_clases_grupales.id','=','clases_grupales.clase_grupal_id')
                    ->select('config_clases_grupales.nombre')
                    ->where('clases_grupales.clase_grupal_id','=',$request->clase_grupal_id)
                ->first();

                $notificacion = new Notificacion; 

                $notificacion->tipo_evento = 1;
                $notificacion->evento_id = $clasegrupal->id;
                $notificacion->mensaje = "Tu academia ha creado una nueva clase grupal llamada ".$config_clase_grupal->nombre;
                $notificacion->titulo = "Nueva Clase Grupal";

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

                    $notificacion->tipo_evento = 1;
                    $notificacion->evento_id = $clasegrupal->id;
                    $notificacion->mensaje = "Te han asignado una Clase Grupal llamada ".$config_clase_grupal->nombre;
                    $notificacion->titulo = "Nueva Clase Grupal";

                    if($notificacion->save()){

                        $usuarios_notificados = new NotificacionUsuario;
                        $usuarios_notificados->id_usuario = $instructor->id;
                        $usuarios_notificados->id_notificacion = $notificacion->id;
                        $usuarios_notificados->visto = 0;
                        $usuarios_notificados->save();
                    }
                }

                if($request->imageBase64 AND $request->imageBase64 != 'data:,'){

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

    public function storeInscripcion(Request $request){

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

        }else{

            $alumnosclasegrupal = InscripcionClaseGrupal::withTrashed()->where('alumno_id', $request->alumno_id)->where('clase_grupal_id', $request->clase_grupal_id)->first();

            if($alumnosclasegrupal){

                $alumnosclasegrupal->deleted_at = null;
                $alumnosclasegrupal->save();

                $deuda = Alumno::join('items_factura_proforma', 'items_factura_proforma.usuario_id', '=', 'alumnos.id')
                    ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
                    ->where('alumnos.id','=', $alumnosclasegrupal->alumno_id)
                ->sum('items_factura_proforma.importe_neto');

                $alumno = Alumno::find($alumnosclasegrupal->alumno_id);

                Session::forget('id_alumno');

                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'id' => $alumnosclasegrupal->alumno_id, 'inscripcion' => $alumnosclasegrupal, 'array'=> $alumno, 'deuda' => $deuda, 200]);
            }

            $alumno = Alumno::find($request->alumno_id);
            $clasegrupal = ClaseGrupal::find($request->clase_grupal_id);

            if($request->permitir == 0){
                
                if($alumno->sexo == 'M')
                {
                    if(!is_null($clasegrupal->cantidad_hombres)){

                        $hombres = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
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

                        $mujeres = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
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

            $array=array();

            // for($i = 1 ; $i<count($alumnos) ; $i++)
            // {
                $inscripcion = new InscripcionClaseGrupal;

                $inscripcion->clase_grupal_id = $request->clase_grupal_id;
                $inscripcion->alumno_id = $request->alumno_id;
                $inscripcion->fecha_pago = $proxima_fecha;
                $inscripcion->fecha_inscripcion = Carbon::now()->toDateString();
                $inscripcion->costo_inscripcion = $request->costo_inscripcion;
                $inscripcion->costo_mensualidad = $request->costo_mensualidad;
                $inscripcion->boolean_franela = $request->boolean_franela;
                $inscripcion->boolean_programacion = $request->boolean_programacion;
                $inscripcion->razon_entrega = $request->razon_entrega;
                $inscripcion->talla_franela = $request->talla_franela;
                $inscripcion->tipo_pago = $request->tipo_pago;
                $inscripcion->observacion_cambio_costo = $request->observacion_cambio_costo;

                if($inscripcion->save()){
                                        
                    $in = array(3,4);
                    $config_clase_grupal = ConfigClasesGrupales::withTrashed()->find($clasegrupal->clase_grupal_id);

                    if($config_clase_grupal){
                        $servicio_id = $config_clase_grupal->servicio_id;
                        $nombre = $config_clase_grupal->nombre;
                    }else{
                        $servicio_id = 1;
                        $nombre = '';
                    }

                    $visitante = Visitante::where('alumno_id', $request->alumno_id)->first();

                    if($visitante){
                        $visitante->cliente = 1;
                        $visitante->save();
                    }

                    $explode = $request->promotores;
                    $promotores = explode(',',$explode);
                    $tipo_promotor = '';
                    $promotor_id = '';

                    foreach($promotores as $promotor){
                        if($promotor){
                            $explode = explode('-',$promotor);
                            if($tipo_promotor){
                                $coma = ',';
                            }else{
                                $coma = '';
                            }
                            $tipo_promotor = $tipo_promotor .$coma.$explode[0];
                            $promotor_id = $promotor_id .$coma.$explode[1];
                        }
                    }

                    if($request->costo_inscripcion != 0){

                        $item_factura = new ItemsFacturaProforma;
                            
                        $item_factura->usuario_id = $request->alumno_id;
                        $item_factura->usuario_tipo = 1;
                        $item_factura->academia_id = Auth::user()->academia_id;
                        $item_factura->fecha = Carbon::now()->toDateString();
                        $item_factura->item_id = $servicio_id;
                        $item_factura->nombre = 'Inscripción ' . $nombre;
                        $item_factura->tipo = 3;
                        $item_factura->cantidad = 1;
                        $item_factura->precio_neto = 0;
                        $item_factura->impuesto = 0;
                        $item_factura->importe_neto = $request->costo_inscripcion;
                        $item_factura->fecha_vencimiento = $clasegrupal->fecha_inicio;
                        $item_factura->tipo_promotor = $tipo_promotor;
                        $item_factura->promotor_id = $promotor_id;
                            
                        $item_factura->save();

                    }

                    if($request->costo_mensualidad != 0){

                        $item_factura = new ItemsFacturaProforma;
                            
                        $item_factura->usuario_id = $request->alumno_id;
                        $item_factura->usuario_tipo = 1;
                        $item_factura->academia_id = Auth::user()->academia_id;
                        $item_factura->fecha = Carbon::now()->toDateString();
                        $item_factura->item_id = $servicio_id;
                        $item_factura->nombre = 'Cuota ' . $nombre;
                        $item_factura->tipo = 4;
                        $item_factura->cantidad = 1;
                        $item_factura->precio_neto = 0;
                        $item_factura->impuesto = 0;
                        $item_factura->importe_neto = $request->costo_mensualidad;
                        $item_factura->fecha_vencimiento = $clasegrupal->fecha_inicio;
                        $item_factura->tipo_promotor = $tipo_promotor;
                        $item_factura->promotor_id = $promotor_id;
                            
                        $item_factura->save();

                    }

                    $alumno = Alumno::find($request->alumno_id);

                    if($alumno){
                        $alumno->tipo_pago = $request->tipo_pago;
                        $alumno->save();
                    }

                    $deuda = Alumno::join('items_factura_proforma', 'items_factura_proforma.usuario_id', '=', 'alumnos.id')
                        ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
                        ->where('alumnos.id','=', $request->alumno_id)
                    ->sum('items_factura_proforma.importe_neto');

                    // $array[$i] = $alumno;

                // }
                

                Session::forget('id_alumno');

                // return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'uno' => 'uno', 'id' => $alumno->id, 'array' => $alumno, 'inscripcion' => $inscripcion, 'deuda' => $deuda, 200]);

                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'id' => $request->alumno_id, 'inscripcion' => $inscripcion, 'deuda' => $deuda, 'alumno' => $alumno, 200]);
            }

            // if(count($alumnos) > 2)
            // {
            //     return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 200]);
            // }
            // else{
            //     return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'uno' => 'uno', 'id' => $array[1]->id, 200]);
            // }

    
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

    public function actualizar_participante(Request $request)
    {

        $inscripcion = InscripcionClaseGrupal::find($request->id_participante);
        $alumno = Alumno::find($inscripcion->alumno_id);
        $alumno->tipologia_id = $request->tipologia_id_participante;

        if($alumno->save())
        {
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'tipologia_id' => $request->tipologia_id_participante, 'id' => $request->id_participante, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function agregar_credencial(Request $request){

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

        }else{

            $datos = $this->getDatosUsuario();

            $usuario_id = $datos[0]['usuario_id'];
            $usuario_tipo = $datos[0]['usuario_tipo'];

            if($usuario_tipo != 3){
                $instructor_id = '';
                $total_credenciales = 0;
            
            }else{

                $credencial_instructor = CredencialInstructor::where('instructor_id', $usuario_id)->first();

                if($credencial_instructor){

                    $total = $credencial_instructor->cantidad - $request->cantidad;

                    if($total >= 0){

                        $credencial_instructor->cantidad = $total;

                        if($credencial_instructor->save()){

                            $instructor_id = $usuario_id;
                            $total_credenciales = $credencial_instructor->cantidad;

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

            $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->select('users.id')
                ->where('usuarios_tipo.tipo',3)
                ->where('usuarios_tipo.tipo_id',$instructor_id)
            ->first();

            if($usuario){
                $usuario_id_vendedor = $usuario->id;
            }else{
                $usuario_id_vendedor = 0;
            }
            
            $credencial_alumno = new CredencialAlumno;

            $credencial_alumno->alumno_id = $request->alumno_id_credencial;
            $credencial_alumno->instructor_id = $instructor_id;
            $credencial_alumno->cantidad = $request->cantidad;
            $credencial_alumno->cantidad_restante = $request->cantidad;
            $credencial_alumno->usuario_id_vendedor = $usuario_id_vendedor;
            $credencial_alumno->dias_vencimiento = $request->dias_vencimiento;
            $credencial_alumno->fecha_vencimiento = Carbon::now()->AddDays($request->dias_vencimiento);

            if($credencial_alumno->save()){

                $cantidad = $credencial_alumno->cantidad;

                $fecha_vencimiento = $credencial_alumno->fecha_vencimiento;
                $fecha_vencimiento = $fecha_vencimiento->toDateString();

                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'credencial_alumno' => $credencial_alumno, 'total_credenciales' => $total_credenciales, 'fecha_vencimiento' => $fecha_vencimiento, 'cantidad' => $cantidad, 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function eliminar_credencial($id)
    {
        $credencial_alumno = CredencialAlumno::find($id);

        if($credencial_alumno){

            $datos = $this->getDatosUsuario();

            $usuario_id = $datos[0]['usuario_id'];
            $usuario_tipo = $datos[0]['usuario_tipo'];

            $cantidad = $credencial_alumno->cantidad;

            if($usuario_tipo == 3){

                $cantidad = $credencial_alumno->cantidad;

                $credenciales_instructor = CredencialInstructor::where('instructor_id',$usuario_id)->first();

                if($credenciales_instructor){

                    $credenciales_instructor->cantidad = $credenciales_instructor->cantidad + $cantidad;

                    if($credenciales_instructor->save()){
                        $total_credenciales = $credenciales_instructor->cantidad;

                    }else{
                        $total_credenciales = 0;
                    }
                }
            }else{
                $total_credenciales = 0;
            }

            if($credencial_alumno->delete()){

                return response()->json(['mensaje' => '¡Excelente! La credencial se ha eliminado satisfactoriamente', 'status' => 'OK', 'total_credenciales' => $total_credenciales, 'cantidad' => $cantidad, 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }else{
            return response()->json(['mensaje' => '¡Excelente! La credencial se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
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

            $horarios = HorarioClaseGrupal::where('clase_grupal_id',$request->id)->get();

            foreach($horarios as $horario){

                $fecha_inicio = Carbon::createFromFormat('Y-m-d', $clasegrupal->fecha_inicio);
                $dia_de_semana = $fecha_inicio->dayOfWeek;

                $fecha_horario = Carbon::createFromFormat('Y-m-d', $horario->fecha);
                $dia_horario = $fecha_horario->dayOfWeek;

                if($dia_horario >= $dia_de_semana){
                    $dias = intval($dia_horario) - intval($dia_de_semana);
                    $fecha_inicio->addDays($dias)->toDateString();
                }else{
                    $dias = intval($dia_de_semana) - intval($dia_horario);
                    $fecha_inicio->addWeek();
                    $fecha_inicio->subDays($dias)->toDateString();
                }

                $horario->fecha = $fecha_inicio;
                $horario->save();
            }

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

        if($request->color_etiqueta == "#"){
            return response()->json(['errores' => ['color_etiqueta' => [0, 'Ups! El color de la etiqueta es requerido']], 'status' => 'ERROR'],422);
        }
        
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

            $clasegrupal->hora_inicio = $hora_inicio;
            $clasegrupal->hora_final = $hora_final;

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
                
                if($request->imageBase64 AND $request->imageBase64 != 'data:,'){
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
        $clasegrupal = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_clases_grupales.nombre as nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final', 'clases_grupales.id')
            ->where('clases_grupales.id', '=', $id)
            ->first();
        if($clasegrupal)
       	{
            $fecha_inicio = Session::get('fecha_inicio');

       		$clases_grupales = ClaseGrupal::leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
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

            $usuario_tipo = Session::get('easydance_usuario_tipo');

        	return view('agendar.clase_grupal.operacion')->with(['id' => $id, 'clasegrupal' => $clasegrupal, 'grupales' => $array, 'fecha_inicio' => $fecha_inicio, 'usuario_tipo' => $usuario_tipo]);
       	}else{
       		return redirect("agendar/clases-grupales"); 
       	}
                
    }

    public function canceladas($id)
    {   
        $clasegrupal = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_clases_grupales.nombre as nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final', 'clases_grupales.id')
            ->where('clases_grupales.id', '=', $id)
            ->first();

        if($clasegrupal)
        {

            $canceladas = HorarioBloqueado::where('tipo_id',$id)->where('tipo', 1)->get();
            $fecha_inicio = Session::get('fecha_inicio');
    
            return view('agendar.clase_grupal.canceladas')->with(['id' => $id, 'clasegrupal' => $clasegrupal, 'canceladas' => $canceladas, 'fecha_inicio' => $fecha_inicio]);
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

        $clase_grupal_join = ClaseGrupal::join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
            ->leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->join('config_niveles_baile', 'clases_grupales.nivel_baile_id', '=', 'config_niveles_baile.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'config_clases_grupales.asistencia_rojo as inasistencia_max', 'config_clases_grupales.asistencia_amarilla as inasistencia_min','instructores.id as instructor_id', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','instructores.sexo', 'config_estudios.nombre as estudio_nombre', 'config_niveles_baile.nombre as nivel_nombre' , 'clases_grupales.fecha_inicio as fecha_inicio', 'clases_grupales.fecha_final as fecha_final' , 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.id' , 'clases_grupales.fecha_inicio_preferencial', 'clases_grupales.link_video', 'clases_grupales.cupo_minimo' , 'clases_grupales.cupo_maximo', 'clases_grupales.cupo_reservacion', 'clases_grupales.imagen', 'clases_grupales.color_etiqueta', 'clases_grupales.boolean_promocionar', 'clases_grupales.titulo_video', 'clases_grupales.dias_prorroga', 'clases_grupales.cantidad_hombres', 'clases_grupales.cantidad_mujeres')
            ->where('clases_grupales.id', '=', $id)
        ->first();

        if($clase_grupal_join){

        	$clases_grupales = ClaseGrupal::leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
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
                'horarios_clases_grupales.especialidad_id',
                '=', 
                'config_especialidades.id'
                )
            ->leftJoin('instructores', 
                'horarios_clases_grupales.instructor_id',
                '=',
                'instructores.id'
                 )
            ->join('config_estudios', 
                'horarios_clases_grupales.estudio_id',
                '=',
                'config_estudios.id'
                 )
            ->select('horarios_clases_grupales.*', 
                'instructores.nombre as instructor_nombre',
                'instructores.apellido as instructor_apellido',
                'config_especialidades.nombre as especialidad_nombre', 
                'config_estudios.nombre as estudio_nombre'
                 )
            ->get();

            $arrayHorario= array();
            $academia = Academia::find(Auth::user()->academia_id);

            foreach ($horario_clase_grupal as $horario) {

                $instructor=$horario->instructor_nombre.' '.$horario->instructor_apellido;
                $especialidad=$horario->especialidad_nombre;
                $estudio = $horario->estudio_nombre;
                $fecha=$horario->fecha;

                if($academia->tipo_horario == 2){
                    $hora_inicio = Carbon::createFromFormat('H:i:s',$horario->hora_inicio)->toTimeString();
                    $hora_final = Carbon::createFromFormat('H:i:s',$horario->hora_final)->toTimeString();
                }else{
                    $hora_inicio = Carbon::createFromFormat('H:i:s',$horario->hora_inicio)->format('g:i a');
                    $hora_final = Carbon::createFromFormat('H:i:s',$horario->hora_final)->format('g:i a');
                }
                
                $id_horario=$horario->id;

                $fc=explode('-',$fecha);
                $fecha_curso=Carbon::create($fc[0], $fc[1], $fc[2], 00, 00, 00);
                $dia_curso = $fecha_curso->format('l');

                $dia_de_semana="";

                $dia_curso=strtoupper($dia_curso);

                if($dia_curso=="SUNDAY")
                {
                    $dia_de_semana="Domingo";
                }
                elseif($dia_curso=="MONDAY")
                {
                    $dia_de_semana="Lunes";
                }
                elseif($dia_curso=="TUESDAY")
                {
                    $dia_de_semana="Martes";
                }
                elseif($dia_curso=="WEDNESDAY")
                {
                    $dia_de_semana="Míercoles";                
                }
                elseif($dia_curso=="THURSDAY")
                {
                    $dia_de_semana="Jueves";                
                }
                elseif($dia_curso=="FRIDAY")
                {
                    $dia_de_semana="Viernes";
                }
                elseif($dia_curso=="SATURDAY")
                {
                    $dia_de_semana="Sábado";
                }

                $arrayHorario[$id_horario] = array(
                    'instructor' => $instructor,
                    'dia_de_semana' => $dia_de_semana,
                    'new_dia_de_semama'=>$dia_curso,
                    'especialidad' => $especialidad,
                    'estudio' => $estudio,
                    'hora_inicio' => $hora_inicio,
                    'hora_final' => $hora_final,
                    'fecha'=> $fecha,
                    'id'=>$id_horario
                );
            }

            $usuario_tipo = Session::get('easydance_usuario_tipo');

            $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->where('usuarios_tipo.tipo_id',$clase_grupal_join->instructor_id)
                ->where('usuarios_tipo.tipo',3)
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

            return view('agendar.clase_grupal.planilla')->with(['config_clases_grupales' => ConfigClasesGrupales::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get(), 'config_especialidades' => ConfigEspecialidades::all(), 'config_estudios' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'config_niveles' => ConfigNiveles::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->orderBy('nombre')->get(), 'instructores' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get(), 'clasegrupal' => $clase_grupal_join,  'id' => $id, 'dias_de_semana' => DiasDeSemana::all(), 'grupales' => $array, 'arrayHorario' => $arrayHorario, 'usuario_tipo' => $usuario_tipo, 'imagen' => $imagen]);

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

    public function destroy(Request $request)
    {

        // $exist = InscripcionClaseGrupal::where('clase_grupal_id', $id)->first();
        
        // if(!$exist)
        // {

            $academia = Academia::find(Auth::user()->academia_id);

            if($academia->password_supervision){
                if(!Hash::check($request->password_supervision, $academia->password_supervision)) {
                    return response()->json(['error_mensaje'=> 'Ups! La contraseña no coincide', 'status' => 'ERROR-PASSWORD'],422);
                }
            }
            
            $id = $request->id;
            $horario_clase_grupal = HorarioClaseGrupal::where('clase_grupal_id', $id)->delete();
            $clasegrupal = ClaseGrupal::find($id);
        
            if($clasegrupal->delete()){

                $notificacion = Notificacion::where('tipo_evento',1)->where('evento_id',$id)->first();
                if($notificacion){
                    $notificacion_usuario = NotificacionUsuario::where('id_notificacion',$notificacion->id)->delete();
                    $notificacion->delete();
                }
                return response()->json(['mensaje' => '¡Excelente! La Clase Grupal se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        // }
        // else{
        //     return response()->json(['error_mensaje'=> 'Ups! Esta clase grupal no puede ser eliminada ya que posee alumnos registrados' , 'status' => 'ERROR-BORRADO'],422);
        // }
    }

    public function Trasladar(Request $request)
    {
    	$rules = [

	        'clase_grupal_id' => 'required',
	        'id' => 'required',
        ];

        $messages = [

            'clase_grupal_id.required' => 'Ups! La Clase Grupal es requerida',
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
		        

	        	$config_clase_grupal = ConfigClasesGrupales::find($clasegrupal->clase_grupal_id);

	        	foreach($inscritos as $inscrito){

	        		$existe = InscripcionClaseGrupal::where('alumno_id', $inscrito->alumno_id)->where('clase_grupal_id', $request->clase_grupal_id)->first();

	        		if(!$existe){
	        			$inscrito->clase_grupal_id = $request->clase_grupal_id;
	        			$inscrito->costo_mensualidad = $config_clase_grupal->costo_mensualidad;
	        			$inscrito->save();
	        		}else{

                        $delete = InscripcionClaseGrupal::where('alumno_id', $inscrito->alumno_id)->where('clase_grupal_id', $request->id)->delete();
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

    public function Transferir(Request $request)
    {
        $rules = [
            'transferir_inscripcion_id' => 'required',
            'clase_grupal_id' => 'required',
        ];

        $messages = [

            'transferir_inscripcion_id.required' => 'Ups! La Clase Grupal es requerida',
            'clase_grupal_id.required' => 'Ups! La Clase Grupal es requerida',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            
            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);           

        }else{

            $id = $request->transferir_inscripcion_id;

            $inscripcion = InscripcionClaseGrupal::find($id);
            $clasegrupal = ClaseGrupal::find($request->clase_grupal_id);

            if($clasegrupal && $inscripcion)
            {

                $config_clase_grupal = ConfigClasesGrupales::find($clasegrupal->clase_grupal_id);

                if($config_clase_grupal){
                    $costo_mensualidad = $config_clase_grupal->costo_mensualidad;
                }else{
                    $costo_mensualidad = $inscripcion->costo_mensualidad;
                }
                
                $inscripcion_anterior = InscripcionClaseGrupal::withTrashed()
                    ->where('alumno_id', $inscripcion->alumno_id)
                    ->where('clase_grupal_id', $request->clase_grupal_id)
                ->first();

                if(!$inscripcion_anterior){

                    $inscripcion->fecha_a_comprobar = Carbon::now()->addWeeks(2)->toDateString();
                    $inscripcion->clase_grupal_id = $request->clase_grupal_id;
                    $inscripcion->costo_mensualidad = $costo_mensualidad;
                    $inscripcion->save();
                    
                }else{

                    $inscripcion_anterior->fecha_a_comprobar = Carbon::now()->addWeeks(2)->toDateString();
                    $inscripcion_anterior->costo_mensualidad = $costo_mensualidad;
                    $inscripcion_anterior->deleted_at = null;
                    $inscripcion_anterior->save();
                    $inscripcion->forceDelete();
                }
                
                return response()->json(['mensaje' => '¡Excelente! La Clase Grupal se ha actualizado satisfactoriamente', 'status' => 'OK', 'id' => $id, 200]);
                    
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

        $usuario_tipo = Session::get('easydance_usuario_tipo');

        return view('agendar.clase_grupal.progreso')->with(['clase_1' => $clase_1, 'clase_2' => $clase_2, 'clase_3' => $clase_3, 'clase_4' => $clase_4, 'clase_5' => $clase_5, 'clase_6' => $clase_6, 'clase_7' => $clase_7, 'clase_8' => $clase_8, 'clase_9' => $clase_9, 'clase_10' => $clase_10, 'clase_11' => $clase_11, 'clase_12' => $clase_12, 'id' => $id, 'usuario_tipo' => $usuario_tipo]);
    }

    public function storeNivelaciones(Request $request)
    {
        $id = $request->id;

        $inscripciones = InscripcionClaseGrupal::where('clase_grupal_id',$id)->get();

        $nivel_1 = Progreso::where('clase_grupal_id',$id)->where('tipo',1)->first();
        $nivel_2 = Progreso::where('clase_grupal_id',$id)->where('tipo',2)->first();
        $nivel_3 = Progreso::where('clase_grupal_id',$id)->where('tipo',3)->first();
        $nivel_4 = Progreso::where('clase_grupal_id',$id)->where('tipo',4)->first();
        $nivel_5 = Progreso::where('clase_grupal_id',$id)->where('tipo',5)->first();
        $nivel_6 = Progreso::where('clase_grupal_id',$id)->where('tipo',6)->first();
        $nivel_7 = Progreso::where('clase_grupal_id',$id)->where('tipo',7)->first();
        $nivel_8 = Progreso::where('clase_grupal_id',$id)->where('tipo',8)->first();
        $nivel_9 = Progreso::where('clase_grupal_id',$id)->where('tipo',9)->first();
        $nivel_10 = Progreso::where('clase_grupal_id',$id)->where('tipo',10)->first();
        $nivel_11 = Progreso::where('clase_grupal_id',$id)->where('tipo',11)->first();
        $nivel_12 = Progreso::where('clase_grupal_id',$id)->where('tipo',12)->first();

        $nivel_1->clase_1 = $request->b1c1;
        $nivel_1->clase_2 = $request->b1c2;
        $nivel_1->clase_3 = $request->b1c3;
        $nivel_1->clase_4 = $request->b1c4;
        $nivel_1->save();

        $nivel_2->clase_1 = $request->b2c1;
        $nivel_2->clase_2 = $request->b2c2;
        $nivel_2->clase_3 = $request->b2c3;
        $nivel_2->clase_4 = $request->b2c4;
        $nivel_2->save();

        $nivel_3->clase_1 = $request->b3c1;
        $nivel_3->clase_2 = $request->b3c2;
        $nivel_3->clase_3 = $request->b3c3;
        $nivel_3->clase_4 = $request->b3c4;
        $nivel_3->save();

        if($request->b3c4){
            foreach($inscripciones as $inscripcion){

                $certificado = Certificado::where('nivel',1)->where('alumno_id',$inscripcion->alumno_id)->first();

                if(!$certificado){

                    do{
                        $hash_id = str_random(8);
                        $find = Certificado::where('hash_id', $hash_id)->first();
                    }while ($find);

                    $certificado = new Certificado;
                    $certificado->alumno_id = $inscripcion->alumno_id;
                    $certificado->clase_grupal_id = $id;
                    $certificado->nivel = 1;
                    $certificado->fecha = Carbon::now();
                    $certificado->hora = Carbon::now();
                    $certificado->hash_id = $hash_id;

                    $certificado->save();
                }
            }
        }

        $nivel_4->clase_1 = $request->i1c1;
        $nivel_4->clase_2 = $request->i1c2;
        $nivel_4->clase_3 = $request->i1c3;
        $nivel_4->clase_4 = $request->i1c4;
        $nivel_4->save();

        $nivel_5->clase_1 = $request->i2c1;
        $nivel_5->clase_2 = $request->i2c2;
        $nivel_5->clase_3 = $request->i2c3;
        $nivel_5->clase_4 = $request->i2c4;
        $nivel_5->save();

        $nivel_6->clase_1 = $request->i3c1;
        $nivel_6->clase_2 = $request->i3c2;
        $nivel_6->clase_3 = $request->i3c3;
        $nivel_6->clase_4 = $request->i3c4;
        $nivel_6->save();

        if($request->i3c4){
            foreach($inscripciones as $inscripcion){

                $certificado = Certificado::where('nivel',2)->where('alumno_id',$inscripcion->alumno_id)->first();

                if(!$certificado){

                    do{
                        $hash_id = str_random(8);
                        $find = Certificado::where('hash_id', $hash_id)->first();
                    }while ($find);

                    $certificado = new Certificado;
                    $certificado->alumno_id = $inscripcion->alumno_id;
                    $certificado->clase_grupal_id = $id;
                    $certificado->nivel = 2;
                    $certificado->fecha = Carbon::now();
                    $certificado->hora = Carbon::now();
                    $certificado->hash_id = $hash_id;

                    $certificado->save();
                }
            }
        }

        $nivel_7->clase_1 = $request->a1c1;
        $nivel_7->clase_2 = $request->a1c2;
        $nivel_7->clase_3 = $request->a1c3;
        $nivel_7->clase_4 = $request->a1c4;
        $nivel_7->save();

        $nivel_8->clase_1 = $request->a2c1;
        $nivel_8->clase_2 = $request->a2c2;
        $nivel_8->clase_3 = $request->a2c3;
        $nivel_8->clase_4 = $request->a2c4;
        $nivel_8->save();

        $nivel_9->clase_1 = $request->a3c1;
        $nivel_9->clase_2 = $request->a3c2;
        $nivel_9->clase_3 = $request->a3c3;
        $nivel_9->clase_4 = $request->a3c4;
        $nivel_9->save();

        if($request->a3c4){
            foreach($inscripciones as $inscripcion){

                $certificado = Certificado::where('nivel',3)->where('alumno_id',$inscripcion->alumno_id)->first();

                if(!$certificado){

                    do{
                        $hash_id = str_random(8);
                        $find = Certificado::where('hash_id', $hash_id)->first();
                    }while ($find);

                    $certificado = new Certificado;
                    $certificado->alumno_id = $inscripcion->alumno_id;
                    $certificado->clase_grupal_id = $id;
                    $certificado->nivel = 3;
                    $certificado->fecha = Carbon::now();
                    $certificado->hora = Carbon::now();
                    $certificado->hash_id = $hash_id;

                    $certificado->save();
                }
            }
        }

        $nivel_10->clase_1 = $request->m1c1;
        $nivel_10->clase_2 = $request->m1c2;
        $nivel_10->clase_3 = $request->m1c3;
        $nivel_10->clase_4 = $request->m1c4;
        $nivel_10->save();

        $nivel_11->clase_1 = $request->m2c1;
        $nivel_11->clase_2 = $request->m2c2;
        $nivel_11->clase_3 = $request->m2c3;
        $nivel_11->clase_4 = $request->m2c4;
        $nivel_11->save();

        $nivel_12->clase_1 = $request->m3c1;
        $nivel_12->clase_2 = $request->m3c2;
        $nivel_12->clase_3 = $request->m3c3;
        $nivel_12->clase_4 = $request->m3c4;
        $nivel_12->save();

        if($request->m3c4){
            foreach($inscripciones as $inscripcion){

                $certificado = Certificado::where('nivel',4)->where('alumno_id',$inscripcion->alumno_id)->first();

                if(!$certificado){

                    do{
                        $hash_id = str_random(8);
                        $find = Certificado::where('hash_id', $hash_id)->first();
                    }while ($find);

                    $certificado = new Certificado;
                    $certificado->alumno_id = $inscripcion->alumno_id;
                    $certificado->clase_grupal_id = $id;
                    $certificado->nivel = 4;
                    $certificado->fecha = Carbon::now();
                    $certificado->hora = Carbon::now();
                    $certificado->hash_id = $hash_id;

                    $certificado->save();
                }
            }
        }

        return response()->json(['mensaje' => '¡Excelente! El Alumno se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
    
    }

    public function cancelarClase(Request $request){

        if($request->tipo == 1)
        {

            $rules = [

                'fecha_cancelacion' => 'required',

            ];

            $messages = [

                'fecha_cancelacion.required' => 'Ups! La fecha es requerida',

            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()){

                return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

            }

            $fecha = explode(" - ", $request->fecha);

            $fecha_inicio = Carbon::createFromFormat('d/m/Y', $request->fecha_cancelacion);
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

            $fecha_inicio = Carbon::parse("1969-01-31");
            $fecha_final = Carbon::parse("1969-01-31");

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
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han guardado satisfactoriamente', 'status' => 'OK', 'cancelada' => $clasegrupal, 'fecha_inicio' => $fecha_inicio->toDateString(), 'fecha_final' => $fecha_final->toDateString(), 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        
    }

    public function update_cancelacion(Request $request)
    {
        $clasegrupal = HorarioBloqueado::find($request->id);

        $clasegrupal->razon_cancelacion = $request->razon_cancelacion;
    
        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        
    }

    public function eliminar_cancelacion($id)
    {

        
        $clasegrupal = HorarioBloqueado::find($id);
    
        if($clasegrupal->delete()){
            return response()->json(['mensaje' => '¡Excelente! La Clase Grupal se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        
        
    }

    public function principalnivelaciones(Request $request){

        $usuario_id = Session::get('easydance_usuario_id');
        $instructor = Instructor::find($usuario_id);

        if(!$instructor->boolean_administrador){

            $clase_grupal_join = ClaseGrupal::join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
                ->leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.id', 'clases_grupales.fecha_inicio', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'clases_grupales.boolean_promocionar', 'clases_grupales.dias_prorroga')
                ->where('clases_grupales.instructor_id','=', $usuario_id)
                ->OrderBy('clases_grupales.hora_inicio')
            ->get();

            $horarios_clase_grupales = HorarioClaseGrupal::join('config_especialidades', 'horarios_clases_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->join('config_estudios', 'horarios_clases_grupales.estudio_id', '=', 'config_estudios.id')
                ->leftJoin('instructores', 'horarios_clases_grupales.instructor_id', '=', 'instructores.id')
                ->join('clases_grupales', 'horarios_clases_grupales.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'config_estudios.nombre as estudio_nombre', 'horarios_clases_grupales.hora_inicio','horarios_clases_grupales.hora_final', 'clases_grupales.id', 'horarios_clases_grupales.fecha as fecha_inicio', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'clases_grupales.boolean_promocionar', 'clases_grupales.dias_prorroga', 'horarios_clases_grupales.id as horario_id')
                ->where('clases_grupales.instructor_id','=', $usuario_id)
                ->where('clases_grupales.deleted_at', '=', null)
                ->OrderBy('horarios_clases_grupales.hora_inicio')
            ->get();

        }else{

            $clase_grupal_join = ClaseGrupal::join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
                ->leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.id', 'clases_grupales.fecha_inicio', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'clases_grupales.boolean_promocionar', 'clases_grupales.dias_prorroga')
                ->OrderBy('clases_grupales.hora_inicio')
            ->get();

            $horarios_clase_grupales = HorarioClaseGrupal::join('config_especialidades', 'horarios_clases_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->join('config_estudios', 'horarios_clases_grupales.estudio_id', '=', 'config_estudios.id')
                ->leftJoin('instructores', 'horarios_clases_grupales.instructor_id', '=', 'instructores.id')
                ->join('clases_grupales', 'horarios_clases_grupales.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'config_estudios.nombre as estudio_nombre', 'horarios_clases_grupales.hora_inicio','horarios_clases_grupales.hora_final', 'clases_grupales.id', 'horarios_clases_grupales.fecha as fecha_inicio', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'clases_grupales.boolean_promocionar', 'clases_grupales.dias_prorroga', 'horarios_clases_grupales.id as horario_id')
                ->where('clases_grupales.deleted_at', '=', null)
                ->OrderBy('horarios_clases_grupales.hora_inicio')
            ->get();

        }

        $array = array();

        $academia = Academia::find(Auth::user()->academia_id);

        foreach($clase_grupal_join as $clase_grupal){
            $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
            $dia_de_semana = $fecha->dayOfWeek;

            if($dia_de_semana == 0){
                $dia_de_semana = 7;
            }

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

            if($dia_de_semana == 0){
                $dia_de_semana = 7;
            } 

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
        // $geoip = new GeoIP();
        // $geoip->setIp($request->ip());
        // $actual->tz = $geoip->getTimezone();

        $hoy = $actual->dayOfWeek;

        return view('vista_instructor.clase_grupal')->with(['clase_grupal_join' => $array, 'hoy' => $hoy, 'academia' => $academia, 'tipo' => 2]);

        
    }

    public function clases_grupales_vista_instructor(Request $request){

        $usuario_id = Session::get('easydance_usuario_id');
        $instructor = Instructor::find($usuario_id);

        if(!$instructor->boolean_administrador){

            $clase_grupal_join = ClaseGrupal::join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
                ->leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.id', 'clases_grupales.fecha_inicio', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'clases_grupales.boolean_promocionar', 'clases_grupales.dias_prorroga')
                ->where('clases_grupales.instructor_id','=', $usuario_id)
                ->OrderBy('clases_grupales.hora_inicio')
            ->get();

            $horarios_clase_grupales = HorarioClaseGrupal::join('config_especialidades', 'horarios_clases_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->join('config_estudios', 'horarios_clases_grupales.estudio_id', '=', 'config_estudios.id')
                ->leftJoin('instructores', 'horarios_clases_grupales.instructor_id', '=', 'instructores.id')
                ->join('clases_grupales', 'horarios_clases_grupales.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'config_estudios.nombre as estudio_nombre', 'horarios_clases_grupales.hora_inicio','horarios_clases_grupales.hora_final', 'clases_grupales.id', 'horarios_clases_grupales.fecha as fecha_inicio', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'clases_grupales.boolean_promocionar', 'clases_grupales.dias_prorroga', 'horarios_clases_grupales.id as horario_id')
                ->where('clases_grupales.instructor_id','=', $usuario_id)
                ->where('clases_grupales.deleted_at', '=', null)
                ->OrderBy('horarios_clases_grupales.hora_inicio')
            ->get();

        }else{

            $clase_grupal_join = ClaseGrupal::join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
                ->leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.id', 'clases_grupales.fecha_inicio', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'clases_grupales.boolean_promocionar', 'clases_grupales.dias_prorroga')
                ->OrderBy('clases_grupales.hora_inicio')
            ->get();

            $horarios_clase_grupales = HorarioClaseGrupal::join('config_especialidades', 'horarios_clases_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->join('config_estudios', 'horarios_clases_grupales.estudio_id', '=', 'config_estudios.id')
                ->leftJoin('instructores', 'horarios_clases_grupales.instructor_id', '=', 'instructores.id')
                ->join('clases_grupales', 'horarios_clases_grupales.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'config_estudios.nombre as estudio_nombre', 'horarios_clases_grupales.hora_inicio','horarios_clases_grupales.hora_final', 'clases_grupales.id', 'horarios_clases_grupales.fecha as fecha_inicio', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'clases_grupales.boolean_promocionar', 'clases_grupales.dias_prorroga', 'horarios_clases_grupales.id as horario_id')
                ->where('clases_grupales.deleted_at', '=', null)
                ->OrderBy('horarios_clases_grupales.hora_inicio')
            ->get();

        }

        $array = array();

        $academia = Academia::find(Auth::user()->academia_id);

        foreach($clase_grupal_join as $clase_grupal){
            $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
            $dia_de_semana = $fecha->dayOfWeek;

            if($dia_de_semana == 0){
                $dia_de_semana = 7;
            } 

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

            if($dia_de_semana == 0){
                $dia_de_semana = 7;
            } 

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
        // $geoip = new GeoIP();
        // $geoip->setIp($request->ip());
        // $actual->tz = $geoip->getTimezone();
        
        $hoy = $actual->dayOfWeek;

        return view('vista_instructor.clase_grupal')->with(['clase_grupal_join' => $array, 'hoy' => $hoy, 'academia' => $academia, 'tipo' => 1]);

        
    }
    public function historial_asistencia($id){

        $inscripcion_clase_grupal = InscripcionClaseGrupal::find($id);
        $academia = Academia::find(Auth::user()->academia_id);

        $clase_grupal = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
          ->leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
          ->select('clases_grupales.*', 'config_clases_grupales.nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido')
          ->where('clases_grupales.id',$inscripcion_clase_grupal->clase_grupal_id)
        ->first();

        $horarios_clase_grupales = HorarioClaseGrupal::join('clases_grupales', 'horarios_clases_grupales.clase_grupal_id', '=', 'clases_grupales.id')
          ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
          ->leftJoin('instructores', 'horarios_clases_grupales.instructor_id', '=', 'instructores.id')
          ->select('horarios_clases_grupales.*')
          ->where('clases_grupales.id',$inscripcion_clase_grupal->clase_grupal_id)
        ->get();

        $alumno = Alumno::find($inscripcion_clase_grupal->alumno_id);
        $alumno_id = $inscripcion_clase_grupal->alumno_id;
        $clase_grupal_id = $inscripcion_clase_grupal->clase_grupal_id;
        $fecha_clase_grupal = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
        $fecha_inscripcion = Carbon::createFromFormat('Y-m-d', $inscripcion_clase_grupal->fecha_inscripcion);

        $fecha_principal = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);

        $i = $fecha_clase_grupal->dayOfWeek;

        $total_asistencia = 0;
        $total_inasistencia = 0;
        $array = array();

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

        $j = 0;

        if($fecha_inscripcion >= $fecha_clase_grupal){
            $dia_inscripcion = $fecha_inscripcion->dayOfWeek;

            while($i != $dia_inscripcion){

                $fecha_inscripcion->addDay();
                $dia_inscripcion = $fecha_inscripcion->dayOfWeek;
            }

            $fecha = $fecha_inscripcion;
        }else{
            $fecha = $fecha_clase_grupal;
        }

        while($fecha < Carbon::now())
        {
            
            $fecha_a_comparar = $fecha->toDateString();

            $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', $fecha_a_comparar)
                ->where('fecha_final', '>=', $fecha_a_comparar)
                ->where('tipo_id', $id)
                ->where('tipo', 1)
            ->first();

            if(!$horario_bloqueado){

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


                $asistencia = Asistencia::where('tipo',1)->where('tipo_id',$clase_grupal_id)->where('alumno_id',$alumno_id)->where('fecha',$fecha_a_comparar)->first();

                if($asistencia){

                    $asistio = 'zmdi c-verde zmdi-check zmdi-hc-fw f-20';
                    
                    if($academia->tipo_horario == 2){
                        $hora = Carbon::createFromFormat('H:i:s',$asistencia->hora)->toTimeString();
                    }else{
                        $hora = Carbon::createFromFormat('H:i:s',$asistencia->hora)->format('g:i a');
                    }
     
                    $total_asistencia++;
                }else{

                    if(Carbon::now()->toDateString() != $fecha_a_comparar){
                        $asistio = 'zmdi c-youtube zmdi-close zmdi-hc-fw f-20';
                    }else{
                        $asistio = '';
                    }
                    
                    $hora = '';
                    $total_inasistencia++;
                }

                $array[]=array('id' => $j, 'fecha' => $fecha_a_comparar, 'asistio' => $asistio, 'hora' => $hora, 'dia' => $dia);
                $j = $j + 1;
            }

            $fecha->addWeek();
            
        }

        foreach($horarios_clase_grupales as $horario){

            $fecha_horario = Carbon::createFromFormat('Y-m-d',$horario->fecha);
            $i = $fecha_horario->dayOfWeek;
            $fecha_inscripcion = Carbon::createFromFormat('Y-m-d', $inscripcion_clase_grupal->fecha_inscripcion);

            if($fecha_inscripcion >= $fecha_horario){

                $dia_inscripcion = $fecha_inscripcion->dayOfWeek;

                while($i != $dia_inscripcion){

                    $fecha_inscripcion->addDay();
                    $dia_inscripcion = $fecha_inscripcion->dayOfWeek;
                }
                $fecha = $fecha_inscripcion;
            }else{
                $fecha = $fecha_horario;
            }

            while($fecha < Carbon::now())
            {
                if($fecha_principal > $fecha_horario)
                {
                    $fecha->addWeek();
                    continue;
                }

                $fecha_a_comparar = $fecha->toDateString();

                $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', $fecha_a_comparar)
                    ->where('fecha_final', '>=', $fecha_a_comparar)
                    ->where('tipo_id', $id)
                    ->where('tipo', 1)
                ->first();

                if(!$horario_bloqueado){

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

                    $asistencia = Asistencia::where('alumno_id',$alumno_id)->where('tipo',2)->where('tipo_id',$horario->id)->where('fecha',$fecha_a_comparar)->first();

                    if($asistencia){
                        $asistio = 'zmdi c-verde zmdi-check zmdi-hc-fw f-20';

                        if($academia->tipo_horario == 2){
                            $hora = Carbon::createFromFormat('H:i:s',$asistencia->hora)->toTimeString();
                        }else{
                            $hora = Carbon::createFromFormat('H:i:s',$asistencia->hora)->format('g:i a');
                        }

                        $total_asistencia++;
                    }else{
                        if(Carbon::now()->toDateString() != $fecha_a_comparar){
                            $asistio = 'zmdi c-youtube zmdi-close zmdi-hc-fw f-20';
                        }else{
                            $asistio = '';
                        }
                        $hora = '';

                        $total_inasistencia++;
                    }

                    $array[]=array('id' => $j, 'fecha' => $fecha_a_comparar, 'asistio' => $asistio, 'hora' => $hora, 'dia' => $dia);

                    $j = $j + 1;
                }

                $fecha->addWeek();
                
            }
        }

        $total = $total_asistencia + $total_inasistencia;

        if($total > 0){
            $porcentaje = intval(($total_asistencia / $total) * 100);
        }else{
            $porcentaje = 0;
        }

        return view('agendar.clase_grupal.historial')->with(['asistencias' => $array, 'clase_grupal' => $clase_grupal, 'alumno' => $alumno, 'dia' => $dia_principal, 'total_asistencia' => $total_asistencia, 'total_inasistencia' => $total_inasistencia, 'porcentaje' => $porcentaje]);
        
    }

    public function agenda($id){

        $clase = ClaseGrupal::join('config_clases_grupales', 'config_clases_grupales.id', '=', 'clases_grupales.clase_grupal_id')
                ->leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->select('clases_grupales.*', 'config_clases_grupales.nombre', 'config_clases_grupales.descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'config_especialidades.nombre as especialidad', 'config_clases_grupales.nombre')
                ->where('clases_grupales.id', '=' ,  $id)
        ->first();

        $horarios_clasegrupal = HorarioClaseGrupal::join('clases_grupales', 'clases_grupales.id', '=', 'horarios_clases_grupales.clase_grupal_id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('config_especialidades', 'horarios_clases_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->leftJoin('instructores', 'horarios_clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('clases_grupales.fecha_final', 'horarios_clases_grupales.fecha as fecha_inicio', 'horarios_clases_grupales.hora_inicio', 'horarios_clases_grupales.hora_final', 'clases_grupales.color_etiqueta as clase_etiqueta', 'horarios_clases_grupales.color_etiqueta', 'config_clases_grupales.nombre', 'config_clases_grupales.descripcion', 'clases_grupales.id', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'config_especialidades.nombre as especialidad')
            ->where('clases_grupales.id', '=' ,  $id)
        ->get();

        $activas = array();
        $finalizadas = array();

        $nombre = $clase->nombre;

        $fecha_start=explode('-',$clase->fecha_inicio);
        $fecha_end=explode('-',$clase->fecha_final);

        $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
        $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

        $hora_inicio=$clase->hora_inicio;
        $hora_final=$clase->hora_final;
        $instructor = $clase->instructor_nombre . ' ' .$clase->instructor_apellido;

        $tipo = 'activa';
        $bloqueo_id = 0;

        $i = $dt->dayOfWeek;

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

        $i = 0;
        $dadas = 0;
        $restantes = 0;

        $hora_final_carbon = Carbon::createFromFormat('H:i:s', $hora_final);

        if($dt >= Carbon::now()){

            if($hora_final_carbon > Carbon::now()->format('H:i:s')){
                $activas[]=array("id" => $i, "fecha_inicio"=>$dt->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido,'tipo' => $tipo, 'bloqueo_id' => $bloqueo_id, 'dia' => $dia);
                $dadas++;
            }else{
                $finalizadas[]=array("id" => $i,"fecha_inicio"=>$dt->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido,'tipo' => $tipo, 'bloqueo_id' => $bloqueo_id, 'dia' => $dia);
                $restantes++;
            }
            $i++;
        }else{
            $finalizadas[]=array("id" => $i,"fecha_inicio"=>$dt->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido,'tipo' => $tipo, 'bloqueo_id' => $bloqueo_id, 'dia' => $dia);
            $i++;
            $restantes++;
        }

        while($dt->timestamp<$df->timestamp){

            $fecha="";
            $fecha=$dt->addWeek()->toDateString();

            $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', $fecha)
                ->where('fecha_final', '>=', $fecha)
                ->where('tipo_id', $id)
                ->where('tipo', 1)
            ->first();

            if(!$horario_bloqueado){

                $tipo = 'activa';
                $bloqueo_id = 0;
                
            }else{
                
                $tipo = 'cancelada';
                $bloqueo_id = $horario_bloqueado->id;
            }

            $i = $dt->dayOfWeek;

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

            if($dt >= Carbon::now()){
                
                if($hora_final_carbon > Carbon::now()->format('H:i:s')){
                    $activas[]=array("id" => $i, "fecha_inicio"=>$dt->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido,'tipo' => $tipo, 'bloqueo_id' => $bloqueo_id, 'dia' => $dia);
                    $dadas++;
                }else{
                    $finalizadas[]=array("id" => $i,"fecha_inicio"=>$dt->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido,'tipo' => $tipo, 'bloqueo_id' => $bloqueo_id, 'dia' => $dia);
                    $restantes++;
                }
                $i++;
            }else{
                $finalizadas[]=array("id" => $i,"fecha_inicio"=>$dt->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido,'tipo' => $tipo, 'bloqueo_id' => $bloqueo_id, 'dia' => $dia);
                $i++;
                $restantes++;
            }
            
        }
 
        foreach ($horarios_clasegrupal as $clase) {

            $fecha_start=explode('-',$clase->fecha_inicio);
            $fecha_end=explode('-',$clase->fecha_final);

            $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
            $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

            $hora_inicio=$clase->hora_inicio;
            $hora_final=$clase->hora_final;
            $instructor = $clase->instructor_nombre . ' ' .$clase->instructor_apellido;

            $tipo = 'activa';
            $bloqueo_id = 0;

            $i = $dt->dayOfWeek;

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

            $hora_final_carbon = Carbon::createFromFormat('H:i:s', $hora_final);

            if($dt >= Carbon::now()){

                if($hora_final_carbon > Carbon::now()->format('H:i:s')){
                    $activas[]=array("id" => $i, "fecha_inicio"=>$dt->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido,'tipo' => $tipo, 'bloqueo_id' => $bloqueo_id, 'dia' => $dia);
                    $dadas++;
                }else{
                    $finalizadas[]=array("id" => $i,"fecha_inicio"=>$dt->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido,'tipo' => $tipo, 'bloqueo_id' => $bloqueo_id, 'dia' => $dia);
                    $restantes++;
                }
                $i++;
            }else{
                $finalizadas[]=array("id" => $i,"fecha_inicio"=>$dt->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido,'tipo' => $tipo, 'bloqueo_id' => $bloqueo_id, 'dia' => $dia);
                $i++;
                $restantes++;
            }

            
            while($dt->timestamp<$df->timestamp){
                $fecha="";
                $fecha=$dt->addWeek()->toDateString();

                $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', $fecha)
                    ->where('fecha_final', '>=', $fecha)
                    ->where('tipo_id', $id)
                    ->where('tipo', 1)
                ->first();

                if(!$horario_bloqueado){

                    $tipo = 'activa';
                    $bloqueo_id = 0;

                }else{
                    
                    $tipo = 'cancelada';
                    $bloqueo_id = $horario_bloqueado->id;
                }

                $i = $dt->dayOfWeek;

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

                if($dt >= Carbon::now()){

                    if($hora_final_carbon > Carbon::now()->format('H:i:s')){
                        $activas[]=array("id" => $i, "fecha_inicio"=>$dt->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido,'tipo' => $tipo, 'bloqueo_id' => $bloqueo_id, 'dia' => $dia);
                        $dadas++;
                    }else{
                        $finalizadas[]=array("id" => $i,"fecha_inicio"=>$dt->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido,'tipo' => $tipo, 'bloqueo_id' => $bloqueo_id, 'dia' => $dia);
                        $restantes++;
                    }
                    $i++;
                }else{
                    $finalizadas[]=array("id" => $i,"fecha_inicio"=>$dt->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, 'especialidad' => $clase->especialidad, 'instructor' => $clase->instructor_nombre . ' ' . $clase->instructor_apellido,'tipo' => $tipo, 'bloqueo_id' => $bloqueo_id, 'dia' => $dia);
                    $i++;
                    $restantes++;
                }
            }

        }

        return view('agendar.clase_grupal.agenda')->with(['activas' => $activas, 'finalizadas' => $finalizadas, 'nombre' => $nombre, 'id' => $id, 'dadas' => $dadas, 'restantes' => $restantes]);
    }

    public function reservaciones_vencidas($id){

        $reservaciones = Reservacion::onlyTrashed()->where('tipo_reservacion_id', '=', $id)
            ->where('tipo_reservacion', '=', '1')
            ->whereNotNull('deleted_at')
        ->get();

        $array = array();
        
        foreach($reservaciones as $reservacion){

            if($reservacion->tipo_usuario == 1){
                $alumno = Alumno::withTrashed()->find($reservacion->tipo_usuario_id);
            }else if($reservacion->tipo_usuario == 2){
                $alumno = Visitante::withTrashed()->find($reservacion->tipo_usuario_id);
            }else{
                $alumno = Participante::find($reservacion->tipo_usuario_id);
            }

            $collection=collect($alumno);     
            $alumno_array = $collection->toArray();
            $alumno_array['nombre'] = $alumno->nombre;
            $alumno_array['apellido'] = $alumno->apellido;
            $alumno_array['sexo'] = $alumno->sexo;
            $alumno_array['tipo'] = 2;
            $alumno_array['alumno_id'] = $alumno->id;
            $alumno_array['inscripcion_id'] = $reservacion->id;
            $alumno_array['fecha_vencimiento'] = $reservacion->fecha_vencimiento;
            $array[$reservacion->id] = $alumno_array;
        
        }

        return view('agendar.clase_grupal.reservaciones_vencidas')->with(['reservaciones' => $array, 'id' => $id]);
    }

    public function historial_asistencia_general($id){

        $inscripciones = InscripcionClaseGrupal::join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('clases_grupales.*', 'config_clases_grupales.nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'inscripcion_clase_grupal.alumno_id', 'inscripcion_clase_grupal.clase_grupal_id', 'inscripcion_clase_grupal.fecha_inscripcion', 'clases_grupales.fecha_inicio')
            ->where('inscripcion_clase_grupal.alumno_id',$id)
        ->get();

        $total_asistencia = 0;
        $total_inasistencia = 0;
        $array = array();

        foreach($inscripciones as $inscripcion_clase_grupal){

            $horarios_clase_grupales = HorarioClaseGrupal::join('clases_grupales', 'horarios_clases_grupales.clase_grupal_id', '=', 'clases_grupales.id')
              ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
              ->leftJoin('instructores', 'horarios_clases_grupales.instructor_id', '=', 'instructores.id')
              ->select('horarios_clases_grupales.*')
              ->where('clases_grupales.id',$inscripcion_clase_grupal->clase_grupal_id)
            ->get();

            $alumno = Alumno::find($inscripcion_clase_grupal->alumno_id);
            $alumno_id = $inscripcion_clase_grupal->alumno_id;
            $clase_grupal_id = $inscripcion_clase_grupal->clase_grupal_id;
            $fecha_clase_grupal = Carbon::createFromFormat('Y-m-d', $inscripcion_clase_grupal->fecha_inicio);
            $fecha_inscripcion = Carbon::createFromFormat('Y-m-d', $inscripcion_clase_grupal->fecha_inscripcion);

            $fecha_principal = Carbon::createFromFormat('Y-m-d', $inscripcion_clase_grupal->fecha_inicio);

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

            $j = 0;

            if($fecha_inscripcion >= $fecha_clase_grupal){
                $dia_inscripcion = $fecha_inscripcion->dayOfWeek;

                while($i != $dia_inscripcion){

                    $fecha_inscripcion->addDay();
                    $dia_inscripcion = $fecha_inscripcion->dayOfWeek;
                }

                $fecha = $fecha_inscripcion;
            }else{
                $fecha = $fecha_clase_grupal;
            }

            while($fecha < Carbon::now())
            {
                
                $fecha_a_comparar = $fecha->toDateString();

                $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', $fecha_a_comparar)
                    ->where('fecha_final', '>=', $fecha_a_comparar)
                    ->where('tipo_id', $id)
                    ->where('tipo', 1)
                ->first();

                if(!$horario_bloqueado){

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


                    $asistencia = Asistencia::where('tipo',1)->where('tipo_id',$clase_grupal_id)->where('alumno_id',$alumno_id)->where('fecha',$fecha_a_comparar)->first();

                    if($asistencia){

                        $asistio = 'zmdi c-verde zmdi-check zmdi-hc-fw f-20';
                        $hora = $asistencia->hora;
         
                        $total_asistencia++;
                    }else{

                        if(Carbon::now()->toDateString() != $fecha_a_comparar){
                            $asistio = 'zmdi c-youtube zmdi-close zmdi-hc-fw f-20';
                        }else{
                            $asistio = '';
                        }
                        
                        $hora = '';
                        $total_inasistencia++;
                    }

                    $array[]=array('id' => $j, 'fecha' => $fecha_a_comparar, 'asistio' => $asistio, 'hora' => $hora, 'dia' => $dia);
                    $j = $j + 1;
                }

                $fecha->addWeek();
                
            }

            foreach($horarios_clase_grupales as $horario){

                $fecha_horario = Carbon::createFromFormat('Y-m-d',$horario->fecha);
                $i = $fecha_horario->dayOfWeek;
                $fecha_inscripcion = Carbon::createFromFormat('Y-m-d', $inscripcion_clase_grupal->fecha_inscripcion);

                if($fecha_inscripcion >= $fecha_horario){

                    $dia_inscripcion = $fecha_inscripcion->dayOfWeek;

                    while($i != $dia_inscripcion){

                        $fecha_inscripcion->addDay();
                        $dia_inscripcion = $fecha_inscripcion->dayOfWeek;
                    }
                    $fecha = $fecha_inscripcion;
                }else{
                    $fecha = $fecha_horario;
                }

                while($fecha < Carbon::now())
                {
                    if($fecha_principal > $fecha_horario)
                    {
                        $fecha->addWeek();
                        continue;
                    }

                    $fecha_a_comparar = $fecha->toDateString();

                    $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', $fecha_a_comparar)
                        ->where('fecha_final', '>=', $fecha_a_comparar)
                        ->where('tipo_id', $id)
                        ->where('tipo', 1)
                    ->first();

                    if(!$horario_bloqueado){

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

                        $asistencia = Asistencia::where('alumno_id',$alumno_id)->where('tipo',2)->where('tipo_id',$horario->id)->where('fecha',$fecha_a_comparar)->first();

                        if($asistencia){
                            $asistio = 'zmdi c-verde zmdi-check zmdi-hc-fw f-20';
                            $hora = $asistencia->hora;

                            $total_asistencia++;
                        }else{
                            if(Carbon::now()->toDateString() != $fecha_a_comparar){
                                $asistio = 'zmdi c-youtube zmdi-close zmdi-hc-fw f-20';
                            }else{
                                $asistio = '';
                            }
                            $hora = '';

                            $total_inasistencia++;
                        }

                        $array[]=array('id' => $j, 'fecha' => $fecha_a_comparar, 'asistio' => $asistio, 'hora' => $hora, 'dia' => $dia);

                        $j = $j + 1;
                    }

                    $fecha->addWeek();
                    
                }
            }
        }

        $total = $total_asistencia + $total_inasistencia;

        if($total > 0){
            $porcentaje = intval(($total_asistencia / $total) * 100);
        }else{
            $porcentaje = 0;
        }

        $alumno = Alumno::find($id);

        return view('agendar.clase_grupal.historial_general')->with(['asistencias' => $array, 'alumno' => $alumno, 'total_asistencia' => $total_asistencia, 'total_inasistencia' => $total_inasistencia, 'porcentaje' => $porcentaje]);
        
    }

    public function consulta_estatus_alumnos(){

        //1.0 -- EL MODULO DE CONSULTA DE ESTATUS ESTABLECE QUE LA PRIMERA FECHA DEBE SER LA DE LA CLASE PRINCIPAL, LOS SIGUIENTES DEBEN SER LOS MULTIHORARIOS PARA NO TENER NINGUN PROBLEMA

        $alumnos = Alumno::where('academia_id',Auth::user()->academia_id)
            ->orderBy('created_at', 'desc')
        ->get();

        $activos = 0;
        $riesgo = 0;
        $inactivos = 0;

        //ARRAY DE BUSQUEDA EN ASISTENCIAS

        $tipo_clase = array(1,2);

        foreach($alumnos as $alumno){

            $inasistencias = 0;

            $clase_grupal = InscripcionClaseGrupal::join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('clases_grupales.fecha_inicio', 'clases_grupales.fecha_final', 'config_clases_grupales.asistencia_rojo', 'config_clases_grupales.asistencia_amarilla', 'inscripcion_clase_grupal.fecha_inscripcion','inscripcion_clase_grupal.fecha_a_comprobar', 'clases_grupales.id')
                ->where('inscripcion_clase_grupal.alumno_id', $alumno->id)
                ->where('inscripcion_clase_grupal.boolean_congelacion', 0)
                ->where('clases_grupales.deleted_at', null)
                ->orderBy('inscripcion_clase_grupal.fecha_inscripcion', 'desc')
            ->first();

            if($clase_grupal){

                $fecha_inicio = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);

                //CONFIGURACIONES DE ASISTENCIAS

                $asistencia_amarilla = $clase_grupal->asistencia_amarilla;
                $asistencia_roja = $clase_grupal->asistencia_rojo;

                if(Carbon::now() > $fecha_inicio){

                    $fecha_final = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_final);

                    //COMPROBAR HASTA QUE DIA SE HARA EL CICLO, SI LA CLASE AUN NO HA FINALIZADO, SE HARA HASTA EL DIA DE HOY

                    if(Carbon::now() <= $fecha_final){
                        $fecha_de_finalizacion = Carbon::now();
                    }else{
                        $fecha_de_finalizacion = $fecha_final;
                    }

                    $dia_inicio_clase = $fecha_inicio->dayOfWeek;

                    if($dia_inicio_clase == 0){
                        $dia_inicio_clase = 7;
                    }

                    //CREAR ARREGLO DE CLASES GRUPALES A CONSULTAR EN LA ASISTENCIA

                    $horarios_clases_grupales = HorarioClaseGrupal::where('clase_grupal_id', $clase_grupal->id)
                        ->orderBy('fecha')
                    ->get();

                    //ARRAYS CREADO CON EL FIN DE ESTABLECER LOS SALTOS DE DIAS ENTRE CADA CLASE Y SUS MULTIHORARIOS QUE TENDRA LA CONSULTA DE ASISTENCIA, EL ORGANIZADOR ESTABLECE EN LA PRIMERA POSICIÓN EL PRIMER MULTIHORARIO QUE TENGA, Y DE ULTIMO LA CLASE PRINCIPAL PARA PODER REALIZAR EL CICLO CORRECTAMENTE, EL ARRAY DE DIAS SIMPLEMENTE SE USARA PARA LAS CONSULTAS

                    $array_organizador = array();
                    $array_organizador_before = array();
                    $array_organizador_after = array();
                    $array_dias = array();

                    //ARRAY DE BUSQUEDA EN ASISTENCIAS

                    $tipo_id = array();
                    $tipo_id[] = intval($clase_grupal->id);

                    // 1.1 -- ARRAY CREADO PARA ESTABLECER EL INDEX CON EL QUE SE COMENZARA A REALIZAR LA BUSQUEDA POR SI LA ULTIMA ASISTENCIA FUE REALIZADA EN UN MULTIHORARIO, ESTO CON LA FINALIDAD DE SABER QUE INDEX CORRESPONDE DESPUES EN LA CONSULTA

                    $array_dias_clases = array();
                    $array_dias_clases_before = array();
                    $array_dias_clases_after = array();

                    //ESTABLECE EL DIA PRINCIPAL COMO PRIMER INDEX DEL ARRAY DE DIAS

                    $array_dias_clases[] = $dia_inicio_clase;

                    //SE CREA EL ARRAY ORGANIZADOR Y EL ARRAY DE DIAS

                    foreach($horarios_clases_grupales as $horario){

                        $tipo_id[] = $horario->id;
                        $fecha_horario = Carbon::createFromFormat('Y-m-d', $horario->fecha);
                        $dia_horario = $fecha_horario->dayOfWeek;

                        if($dia_horario == 0){
                            $dia_horario = 7;
                        }

                        if($dia_inicio_clase >= $dia_horario){
                            $array_dias_clases_before[] = $dia_horario;
                            $array_organizador_before[] = $dia_horario;
                        }else{
                            $array_dias_clases_after[] = $dia_horario;
                            $array_organizador_after[] = $dia_horario;
                        }

                    }

                    //SE ORDENA EL ARREGLO DE DIAS ANTERIORES A LA CLASE PRINCIPAL

                    usort($array_dias_clases_before, function($a, $b) {
                        return $a - $b;
                    });

                    usort($array_organizador_before, function($a, $b) {
                        return $a - $b;
                    });

                    //ESTE PROCESO SE HACE PARA QUE LA CLASE PRINCIPAL SEA LA PRIMERA EN CONSULTAR, LUEGO SERAN LAS CLASES POSTERIORES A ELLA Y POR ULTIMO LAS CLASES ANTERIORES, PARA QUE EL CICLO AGREGUE UNA SEMANA ANTES DE CONSULTAR LAS CLASES ANTERIORES

                    $merge = array_merge($array_dias_clases, $array_dias_clases_after);
                    $array_dias_clases = array_merge($merge, $array_dias_clases_before);
                    $array_organizador = array_merge($array_organizador_after, $array_dias_clases_before);

                    //SE ESTABLECE QUE SI NO HAY MULTIHORARIO, EL ARRAY DE DIA SOLO TENDRA UNA POSICIÓN DE 7, PARA QUE LAS CONSULTAS SE HAGAN SEMANALMENTE

                    //SI SOLO TIENE UN MULTIHORARIO, LA PRIMERA POSICIÓN SERA LA CANTIDAD DE DIAS QUE LE FALTA A LA CLASE PRINCIPAL PARA LLEGAR AL DIA DEL MULTIHORARIO, LA ULTIMA SERA LA CANTIDAD DE DIAS PARA LLEGAR DE NUEVO A LA CLASE PRINCIPAL, TENDRA SOLO 2 POSICIONES

                    // SI TIENE MAS DE UN MULTIHORARIO, ESTABLECERA UN CICLO PARA VER CUANTOS DIAS HAY ENTRE CADA MULTIHORARIO, DEJANDO POR ULTIMO LA CLASE PRINCIPAL PARA REPETIR EL CICLO

                    //LA CONSULTA DE LOS MULTIHORARIOS LOS ORDENARA POR FECHA PARA ASI SOLO TENER QUE ESTABLECER LA CANTIDAD DE DIAS ENTRE ELLOS

                    if($array_organizador){

                        $dias_a_sumar = 0;
                        
                        if(count($array_organizador) == 1){

                            $dia_inicio_horario = $array_organizador[0];

                            if($dia_inicio_clase  > $dia_inicio_horario){

                                while ($dia_inicio_clase != 7){
                                    $dias_a_sumar++;
                                    $dia_inicio_clase++;
                                }

                                $array_dias[] = $dias_a_sumar + $dia_inicio_horario;
                                $dia_inicio_clase = $fecha_inicio->dayOfWeek;
                                $dias = abs(intval($dia_inicio_horario) - intval($dia_inicio_clase));
                                $array_dias[] = $dias;

                            }else{

                                $dias = abs(intval($dia_inicio_clase) - intval($dia_inicio_horario));
                                $array_dias[] = $dias;

                                while ($dia_inicio_horario != 7){
                                    $dias_a_sumar++;
                                    $dia_inicio_horario++;
                                }

                                $array_dias[] = $dias_a_sumar + $dia_inicio_clase;
                            }
                        }else{

                            $dias_a_restar = $dia_inicio_clase;

                            foreach($array_organizador as $index => $organizador){

                                //SE MIDE LA CANTIDAD DE DIAS ENTRE LA CLASE PRINCIPAL Y EL PRIMER MULTIHORARIO, Y LUEGO ENTRE CADA UNO DE LOS MULTIHORARIOS

                                if($dias_a_restar < $organizador){
                                    $dias_a_añadir = abs($organizador - $dias_a_restar);
                                }else{
                                    $dias_a_añadir = abs(($organizador + 7) - $dias_a_restar);
                                }

                                $array_dias[] = $dias_a_añadir;
                                $dias_a_restar = $organizador;

                            }

                            if($dias_a_restar > $dia_inicio_clase){
                                $dias_a_sumar = 0;

                                while ($dias_a_restar != 7){
                                    $dias_a_sumar++;
                                    $dias_a_restar++;

                                }

                                $dias_a_sumar = $dias_a_sumar + $dia_inicio_clase;
                            }else{
                                $dias_a_sumar = abs($dias_a_restar - $dia_inicio_clase);
                            }

                            $array_dias[] = $dias_a_sumar;
                        }
                    }else{
                        $array_dias[] = 7;
                    }

                    //CONSULTAR LA ULTIMA ASISTENCIA, EL TIPO ES 1 (CLASE PRINCIPAL) Y 2 (MULTIHORARIO), EL TIPO_ID ES UN ARRAY CON EL ID DE LA CLASE PRINCIPAL Y LOS MULTIHORARIOS QUE POSEA
     
                    $ultima_asistencia = Asistencia::whereIn('tipo',$tipo_clase)
                        ->whereIn('tipo_id',$tipo_id)
                        ->where('alumno_id', $alumno->id)
                        ->orderBy('created_at', 'desc')
                    ->first();

                    //SI POSEE UNA ASISTENCIA, EL COMPARARA DESDE ESE DIA, SINO, ESTE TOMARA EL DIA EN QUE EL ALUMNO SE INSCRIBIO

                    //NOTA IMPORTANTE: PARA NO ROMPER EL CICLO CON LA FECHA DE LA INSCRIPCION, EL PROCESO CONVERTIRA ESTA FECHA A UNA QUE CONCUERDE CON LA CLASE PRINCIPAL O ALGUN MULTIHORARIO, SINO LAS CONSULTAS NUNCA FUNCIONARAN

                    if($ultima_asistencia){
                        $fecha_asistencia_inicio = Carbon::createFromFormat('Y-m-d', $ultima_asistencia->fecha);
                        $j = 0;
                    }else{
                        $fecha_asistencia_inicio = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);     
                        $j = 1;               
                    }

                    if($clase_grupal->fecha_inscripcion){
                        $fecha_inscripcion = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inscripcion);
                    }else{
                        $fecha_inscripcion = '1969-01-31';
                    }

                    if($clase_grupal->fecha_a_comprobar){
                        $fecha_traspaso_admin = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_a_comprobar);
                    }else{
                        $fecha_traspaso_admin = '1969-01-31';
                    }

                    if($fecha_asistencia_inicio > $fecha_inscripcion){
                        $fecha_a_comparar = $fecha_asistencia_inicio;
                    }else{
                        $fecha_a_comparar = $fecha_inscripcion;
                        $j = 1;
                    }

                    if($fecha_traspaso_admin > $fecha_a_comparar){
                        $fecha_a_comparar = $fecha_traspaso_admin;
                        $j = 1;
                    }

                    $dia_a_comparar = $fecha_a_comparar->dayOfWeek;

                    while(!in_array($dia_a_comparar,$array_dias_clases)){

                        $fecha_a_comparar->addDay();
                        $dia_a_comparar = $fecha_a_comparar->dayOfWeek;

                        if($dia_a_comparar != 0){
                            $dia_a_comparar = $fecha_a_comparar->dayOfWeek;
                        }else{
                            $dia_a_comparar = 7;
                        }
                    }

                    //EL INDEX INICIAL SE CREA PARA SABER DESDE DONDE SE COMENZARA A BUSCAR EN EL CICLO FOR DE ABAJO, YA DESCRITO EN LA NOTA 1.1

                    $index_inicial = array_search($dia_a_comparar, $array_dias_clases);

                    // $index_inicial = 0;


                    //DATOS DE PRUEBA

                    // $fecha_ultima_asistencia = $fecha_a_comparar->toDateString();
                    // $array_fecha_a_comparar = array();
                    // $array_dias_tmp = array();

                    //EL CICLO WHILE SE ENCARGA DE ESTABLECER LA CANTIDAD DE INASISTENCIAS QUE POSEE LA PERSONA, ESTE AÑADERA LOS DIAS CORRESPONDIENTES DEL ARRAY DE DIAS CREADO ANTERIORMENTE

                    //1.2 -- EL $J != 0 ESTA ESTABLECIDO PARA QUE SI LA PERSONA POSEE ASISTENCIAS, ESTE NO CONTABILICE LAS INASISTENCIAS DESDE LA PRIMERA FECHA, SINO QUE REALICE UN SALTO AL SIGUIENTE INDEX

                    // if($index_inicial > count($array_dias)){
                    //     $index_inicial = 0;
                    // }

                    // $cantidad_inasistencias = count($array_dias);

                    while($fecha_a_comparar < $fecha_de_finalizacion){
                        if($fecha_a_comparar < Carbon::now()->subDay()){
                            for($i = $index_inicial; $i < count($array_dias); $i++){

                                // $array_fecha_a_comparar[] = $fecha_a_comparar->toDateString();
                                // $array_dias_tmp[] = $array_dias[$i];

                                $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', $fecha_a_comparar)
                                    ->where('fecha_final', '>=', $fecha_a_comparar)
                                    ->where('tipo_id', $clase_grupal->id)
                                    ->where('tipo', 1)
                                ->first();

                                if(!$horario_bloqueado){
                                    if($j != 0){
                                        $inasistencias++;
                                    }
                                }

                                $fecha_a_comparar->addDays($array_dias[$i]);

                                //PARA QUE LAS INASISTENCIAS SE EMPIECEN A CONTABILIZAR 

                                $j++;
                            }
                        }else{
                            break;
                        }

                        //EL INDEX VUELVE A 0 PARA PODER REALIZAR EL CICLO FOR DESDE EL PRINCIPIO HASTA QUE LA FECHA A COMPARAR SEA MAYOR A LA FECHA DE FINALIZACIÓN

                        $index_inicial = 0;
                    }
                    
                }

                // LA CONFIGURACIÓN DE LAS ASISTENCIAS DEBEN ESTAR ESTABLECIDAS PARA QUE LAS CONTABILIZACIONES SE HAGAN (!= 0)

                if($inasistencias >= $asistencia_roja && $asistencia_roja != 0){
                    $inactivos++;
                }else if($inasistencias >= $asistencia_amarilla && $asistencia_amarilla != 0){
                    $riesgo++;
                }else{
                    $activos++;
                }
            }else{
                $inactivos++;
            }

        }

        return response()->json(['mensaje' => '¡Excelente! Los datos se han generado satisfactoriamente', 'status' => 'OK', 'inactivos' => $inactivos, 'riesgo' => $riesgo, 'activos' => $activos, 200]);

    }

    public function riesgo_ausencia(){

        $alumnos = Alumno::where('academia_id',Auth::user()->academia_id)
            ->orderBy('created_at', 'desc')
        ->get();

        $array = array();
        $array_inasistencia = array();

        //ARRAY DE BUSQUEDA EN ASISTENCIAS

        $tipo_clase = array(1,2);

        foreach($alumnos as $alumno){

            $inasistencias = 0;

            $clase_grupal = InscripcionClaseGrupal::join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('clases_grupales.fecha_inicio', 'clases_grupales.fecha_final', 'config_clases_grupales.asistencia_rojo', 'config_clases_grupales.asistencia_amarilla', 'inscripcion_clase_grupal.fecha_inscripcion', 'inscripcion_clase_grupal.fecha_a_comprobar','clases_grupales.id')
                ->where('inscripcion_clase_grupal.alumno_id', $alumno->id)
                ->where('inscripcion_clase_grupal.boolean_congelacion', 0)
                ->where('clases_grupales.deleted_at', null)
                ->orderBy('inscripcion_clase_grupal.fecha_inscripcion', 'desc')
            ->first();

            if($clase_grupal){

                $fecha_inicio = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);

                if(Carbon::now() > $fecha_inicio){

                    $fecha_final = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_final);

                    //COMPROBAR HASTA QUE DIA SE HARA EL CICLO, SI LA CLASE AUN NO HA FINALIZADO, SE HARA HASTA EL DIA DE HOY

                    if(Carbon::now() <= $fecha_final){
                        $fecha_de_finalizacion = Carbon::now();
                    }else{
                        $fecha_de_finalizacion = $fecha_final;
                    }

                    $dia_inicio_clase = $fecha_inicio->dayOfWeek;

                    if($dia_inicio_clase == 0){
                        $dia_inicio_clase = 7;
                    }

                    //CONFIGURACIONES DE ASISTENCIAS

                    $asistencia_amarilla = $clase_grupal->asistencia_amarilla;
                    $asistencia_roja = $clase_grupal->asistencia_rojo;

                    //CREAR ARREGLO DE CLASES GRUPALES A CONSULTAR EN LA ASISTENCIA

                    $horarios_clases_grupales = HorarioClaseGrupal::where('clase_grupal_id', $clase_grupal->id)
                        ->orderBy('fecha')
                    ->get();

                    //ARRAYS CREADO CON EL FIN DE ESTABLECER LOS SALTOS DE DIAS ENTRE CADA CLASE Y SUS MULTIHORARIOS QUE TENDRA LA CONSULTA DE ASISTENCIA, EL ORGANIZADOR ESTABLECE EN LA PRIMERA POSICIÓN EL PRIMER MULTIHORARIO QUE TENGA, Y DE ULTIMO LA CLASE PRINCIPAL PARA PODER REALIZAR EL CICLO CORRECTAMENTE, EL ARRAY DE DIAS SIMPLEMENTE SE USARA PARA LAS CONSULTAS

                    $array_organizador = array();
                    $array_organizador_before = array();
                    $array_organizador_after = array();
                    $array_dias = array();

                    //ARRAY DE BUSQUEDA EN ASISTENCIAS

                    $tipo_id = array();
                    $tipo_id[] = intval($clase_grupal->id);

                    // 1.1 -- ARRAY CREADO PARA ESTABLECER EL INDEX CON EL QUE SE COMENZARA A REALIZAR LA BUSQUEDA POR SI LA ULTIMA ASISTENCIA FUE REALIZADA EN UN MULTIHORARIO, ESTO CON LA FINALIDAD DE SABER QUE INDEX CORRESPONDE DESPUES EN LA CONSULTA

                    $array_dias_clases = array();
                    $array_dias_clases_before = array();
                    $array_dias_clases_after = array();

                    //ESTABLECE EL DIA PRINCIPAL COMO PRIMER INDEX DEL ARRAY DE DIAS

                    $array_dias_clases[] = $dia_inicio_clase;

                    //SE CREA EL ARRAY ORGANIZADOR Y EL ARRAY DE DIAS

                    foreach($horarios_clases_grupales as $horario){

                        $tipo_id[] = $horario->id;
                        $fecha_horario = Carbon::createFromFormat('Y-m-d', $horario->fecha);
                        $dia_horario = $fecha_horario->dayOfWeek;

                        if($dia_horario == 0){
                            $dia_horario = 7;
                        }

                        if($dia_inicio_clase >= $dia_horario){
                            $array_dias_clases_before[] = $dia_horario;
                            $array_organizador_before[] = $dia_horario;
                        }else{
                            $array_dias_clases_after[] = $dia_horario;
                            $array_organizador_after[] = $dia_horario;
                        }

                    }

                    //SE ORDENA EL ARREGLO DE DIAS ANTERIORES A LA CLASE PRINCIPAL

                    usort($array_dias_clases_before, function($a, $b) {
                        return $a - $b;
                    });

                    usort($array_organizador_before, function($a, $b) {
                        return $a - $b;
                    });

                    //ESTE PROCESO SE HACE PARA QUE LA CLASE PRINCIPAL SEA LA PRIMERA EN CONSULTAR, LUEGO SERAN LAS CLASES POSTERIORES A ELLA Y POR ULTIMO LAS CLASES ANTERIORES, PARA QUE EL CICLO AGREGUE UNA SEMANA ANTES DE CONSULTAR LAS CLASES ANTERIORES

                    $merge = array_merge($array_dias_clases, $array_dias_clases_after);
                    $array_dias_clases = array_merge($merge, $array_dias_clases_before);
                    $array_organizador = array_merge($array_organizador_after, $array_dias_clases_before);

                    //SE ESTABLECE QUE SI NO HAY MULTIHORARIO, EL ARRAY DE DIA SOLO TENDRA UNA POSICIÓN DE 7, PARA QUE LAS CONSULTAS SE HAGAN SEMANALMENTE

                    //SI SOLO TIENE UN MULTIHORARIO, LA PRIMERA POSICIÓN SERA LA CANTIDAD DE DIAS QUE LE FALTA A LA CLASE PRINCIPAL PARA LLEGAR AL DIA DEL MULTIHORARIO, LA ULTIMA SERA LA CANTIDAD DE DIAS PARA LLEGAR DE NUEVO A LA CLASE PRINCIPAL, TENDRA SOLO 2 POSICIONES

                    // SI TIENE MAS DE UN MULTIHORARIO, ESTABLECERA UN CICLO PARA VER CUANTOS DIAS HAY ENTRE CADA MULTIHORARIO, DEJANDO POR ULTIMO LA CLASE PRINCIPAL PARA REPETIR EL CICLO

                    //LA CONSULTA DE LOS MULTIHORARIOS LOS ORDENARA POR FECHA PARA ASI SOLO TENER QUE ESTABLECER LA CANTIDAD DE DIAS ENTRE ELLOS

                    if($array_organizador){

                        $dias_a_sumar = 0;
                        
                        if(count($array_organizador) == 1){

                            $dia_inicio_horario = $array_organizador[0];

                            if($dia_inicio_clase  > $dia_inicio_horario){

                                while ($dia_inicio_clase != 7){
                                    $dias_a_sumar++;
                                    $dia_inicio_clase++;
                                }

                                $array_dias[] = $dias_a_sumar + $dia_inicio_horario;
                                $dia_inicio_clase = $fecha_inicio->dayOfWeek;
                                $dias = abs(intval($dia_inicio_horario) - intval($dia_inicio_clase));
                                $array_dias[] = $dias;

                            }else{

                                $dias = abs(intval($dia_inicio_clase) - intval($dia_inicio_horario));
                                $array_dias[] = $dias;

                                while ($dia_inicio_horario != 7){
                                    $dias_a_sumar++;
                                    $dia_inicio_horario++;
                                }

                                $array_dias[] = $dias_a_sumar + $dia_inicio_clase;
                            }
                        }else{

                            $dias_a_restar = $dia_inicio_clase;

                            foreach($array_organizador as $index => $organizador){

                                //SE MIDE LA CANTIDAD DE DIAS ENTRE LA CLASE PRINCIPAL Y EL PRIMER MULTIHORARIO, Y LUEGO ENTRE CADA UNO DE LOS MULTIHORARIOS

                                if($dias_a_restar < $organizador){
                                    $dias_a_añadir = abs($organizador - $dias_a_restar);
                                }else{
                                    $dias_a_añadir = abs(($organizador + 7) - $dias_a_restar);
                                }

                                $array_dias[] = $dias_a_añadir;
                                $dias_a_restar = $organizador;

                            }

                            if($dias_a_restar > $dia_inicio_clase){
                                $dias_a_sumar = 0;

                                while ($dias_a_restar != 7){
                                    $dias_a_sumar++;
                                    $dias_a_restar++;

                                }

                                $dias_a_sumar = $dias_a_sumar + $dia_inicio_clase;
                            }else{
                                $dias_a_sumar = abs($dias_a_restar - $dia_inicio_clase);
                            }

                            $array_dias[] = $dias_a_sumar;
                        }
                    }else{
                        $array_dias[] = 7;
                    }

                    //CONSULTAR LA ULTIMA ASISTENCIA, EL TIPO ES 1 (CLASE PRINCIPAL) Y 2 (MULTIHORARIO), EL TIPO_ID ES UN ARRAY CON EL ID DE LA CLASE PRINCIPAL Y LOS MULTIHORARIOS QUE POSEA
     
                    $ultima_asistencia = Asistencia::whereIn('tipo',$tipo_clase)
                        ->whereIn('tipo_id',$tipo_id)
                        ->where('alumno_id', $alumno->id)
                        ->orderBy('created_at', 'desc')
                    ->first();

                    //SI POSEE UNA ASISTENCIA, EL COMPARARA DESDE ESE DIA, SINO, ESTE TOMARA EL DIA EN QUE EL ALUMNO SE INSCRIBIO

                    //NOTA IMPORTANTE: PARA NO ROMPER EL CICLO CON LA FECHA DE LA INSCRIPCION, EL PROCESO CONVERTIRA ESTA FECHA A UNA QUE CONCUERDE CON LA CLASE PRINCIPAL O ALGUN MULTIHORARIO, SINO LAS CONSULTAS NUNCA FUNCIONARAN

                    if($ultima_asistencia){
                        $fecha_asistencia_inicio = Carbon::createFromFormat('Y-m-d', $ultima_asistencia->fecha);
                        $j = 0;
                    }else{
                        $fecha_asistencia_inicio = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);     
                        $j = 1;               
                    }

                    if($clase_grupal->fecha_inscripcion){
                        $fecha_inscripcion = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inscripcion);
                    }else{
                        $fecha_inscripcion = '1969-01-31';
                    }

                    if($clase_grupal->fecha_a_comprobar){
                        $fecha_traspaso_admin = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_a_comprobar);
                    }else{
                        $fecha_traspaso_admin = '1969-01-31';
                    }

                    if($fecha_asistencia_inicio > $fecha_inscripcion){
                        $fecha_a_comparar = $fecha_asistencia_inicio;
                    }else{
                        $fecha_a_comparar = $fecha_inscripcion;
                        $j = 1;
                    }

                    if($fecha_traspaso_admin > $fecha_a_comparar){
                        $fecha_a_comparar = $fecha_traspaso_admin;
                        $j = 1;
                    }

                    $dia_a_comparar = $fecha_a_comparar->dayOfWeek;

                    while(!in_array($dia_a_comparar,$array_dias_clases)){

                        $fecha_a_comparar->addDay();
                        $dia_a_comparar = $fecha_a_comparar->dayOfWeek;

                        if($dia_a_comparar != 0){
                            $dia_a_comparar = $fecha_a_comparar->dayOfWeek;
                        }else{
                            $dia_a_comparar = 7;
                        }
                    }

                    //EL INDEX INICIAL SE CREA PARA SABER DESDE DONDE SE COMENZARA A BUSCAR EN EL CICLO FOR DE ABAJO, YA DESCRITO EN LA NOTA 1.1

                    $index_inicial = array_search($dia_a_comparar, $array_dias_clases);

                    // $index_inicial = 0;


                    //DATOS DE PRUEBA

                    // $fecha_ultima_asistencia = $fecha_a_comparar->toDateString();
                    // $array_fecha_a_comparar = array();
                    // $array_dias_tmp = array();

                    //EL CICLO WHILE SE ENCARGA DE ESTABLECER LA CANTIDAD DE INASISTENCIAS QUE POSEE LA PERSONA, ESTE AÑADERA LOS DIAS CORRESPONDIENTES DEL ARRAY DE DIAS CREADO ANTERIORMENTE

                    //1.2 -- EL $J != 0 ESTA ESTABLECIDO PARA QUE SI LA PERSONA POSEE ASISTENCIAS, ESTE NO CONTABILICE LAS INASISTENCIAS DESDE LA PRIMERA FECHA, SINO QUE REALICE UN SALTO AL SIGUIENTE INDEX

                    // if($index_inicial > count($array_dias)){
                    //     $index_inicial = 0;
                    // }

                    // $cantidad_inasistencias = count($array_dias);

                    while($fecha_a_comparar < $fecha_de_finalizacion){
                        if($fecha_a_comparar < Carbon::now()->subDay()){
                            for($i = $index_inicial; $i < count($array_dias); $i++){

                                // $array_fecha_a_comparar[] = $fecha_a_comparar->toDateString();
                                // $array_dias_tmp[] = $array_dias[$i];

                                $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', $fecha_a_comparar)
                                    ->where('fecha_final', '>=', $fecha_a_comparar)
                                    ->where('tipo_id', $clase_grupal->id)
                                    ->where('tipo', 1)
                                ->first();

                                if(!$horario_bloqueado){
                                    if($j != 0){
                                        $inasistencias++;
                                    }
                                }

                                $fecha_a_comparar->addDays($array_dias[$i]);

                                //PARA QUE LAS INASISTENCIAS SE EMPIECEN A CONTABILIZAR 

                                $j++;
                            }
                        }else{
                            break;
                        }

                        //EL INDEX VUELVE A 0 PARA PODER REALIZAR EL CICLO FOR DESDE EL PRINCIPIO HASTA QUE LA FECHA A COMPARAR SEA MAYOR A LA FECHA DE FINALIZACIÓN

                        $index_inicial = 0;
                    }
                    
                    // LA CONFIGURACIÓN DE LAS ASISTENCIAS DEBEN ESTAR ESTABLECIDAS PARA QUE LAS CONTABILIZACIONES SE HAGAN (!= 0)
     
                    if($inasistencias >= $asistencia_roja && $asistencia_roja != 0){
                        // $array[] = $alumno;
                    }
                    else if($inasistencias >= $asistencia_amarilla && $asistencia_amarilla != 0){
                        $array[] = $alumno;
                        $array_inasistencia[$alumno->id] = $inasistencias;
                    }
                }
            }
        }

        return view('agendar.clase_grupal.ausencia')->with(['alumnos' => $array, 'inasistencias' => $array_inasistencia]);

    }

    function consulta_credenciales_alumno(Request $request){

        $total_credenciales = 0;

        $credenciales = CredencialAlumno::where('alumno_id',$request->alumno_id)
            ->whereIn('instructor_id', explode(',',$request->in_credencial))
            ->where('fecha_vencimiento','>=', Carbon::now()->toDateString())
        ->get();

        foreach($credenciales as $credencial){
            $fecha_vencimiento = Carbon::createFromFormat('Y-m-d',$credencial->fecha_vencimiento);
            $dias_vencimiento = $fecha_vencimiento->diffInDays(Carbon::now());
            $credencial['dias_vencimiento'] = $dias_vencimiento;

            $total_credenciales += $credencial->cantidad; 
        }

        return response()->json(['mensaje' => '¡Excelente! Los datos se han generado satisfactoriamente', 'status' => 'OK', 'credenciales' => $credenciales, 'total_credenciales' => $total_credenciales, 200]);

    }

    function consulta_examen_clase_grupal($id){

        $examen = Examen::where('boolean_grupal',1)->where('clase_grupal_id', $id)->first();

        if($examen){
            $examen = $examen->id;
        }else{
            $examen = '';
        }

        return response()->json(['mensaje' => '¡Excelente! Los datos se han generado satisfactoriamente', 'status' => 'OK', 'examen' => $examen, 200]);
    }
}