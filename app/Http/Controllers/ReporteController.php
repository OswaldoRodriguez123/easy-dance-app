<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use App\Alumno;
use App\Factura;
use App\ClaseGrupal;
use App\HorarioClaseGrupal;
use App\HorarioBloqueado;
use App\Examen;
use App\Instructor;
use App\Staff;
use App\HorarioStaff;
use App\AsistenciaStaff;
use App\InscripcionTaller;
use App\InscripcionClaseGrupal;
use App\InscripcionCoreografia;
use App\ClasePersonalizada;
use App\ItemsFacturaProforma;
use App\Academia;
use App\Visitante;
use App\Asistencia;
use App\ConfigTipoExamen;
use App\ConfigProductos;
use App\ConfigServicios;
use App\ComoNosConociste;
use App\Egreso;
use App\TipoEgreso;
use App\ConfigEgreso;
use App\Pago;
use App\Comision;
use App\PagoInstructor;
use App\FormasPago;
use App\Reservacion;
use App\Participante;
use App\Tipologia;
use Mail;
use DB;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;
use App\ItemsFactura;
use PulkitJalan\GeoIP\GeoIP;

class ReporteController extends BaseController
{

    public function Principal(){

        return view('reportes.principal');

    }
   
   public function Diagnosticos(){

        $clases_grupales= DB::table('clases_grupales')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_clases_grupales.nombre as nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido',  'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.fecha_inicio','clases_grupales.fecha_final', 'clases_grupales.id')
            ->where('clases_grupales.deleted_at', '=', null)
            ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
            ->orderBy('clases_grupales.hora_inicio', 'asc')
      ->get();

        $config_examenes = ConfigTipoExamen::all();
        $examenes = Examen::where('boolean_grupal',1)->where('academia_id', Auth::user()->academia_id)->get();

        return view('reportes.diagnostico')->with(['clases_grupales' => $clases_grupales, 'config_examenes' => $config_examenes, 'examenes' => $examenes]);
    }

    public function DiagnosticosFiltros(Request $request)
    {
        
        $query = DB::table('alumnos')
        ->join('evaluaciones', 'evaluaciones.alumno_id', '=', 'alumnos.id')
        ->join('examenes', 'evaluaciones.examen_id', '=', 'examenes.id')
        ->join('clases_grupales', 'examenes.clase_grupal_id', '=', 'clases_grupales.id')
        ->select('alumnos.nombre', 'alumnos.apellido', 'alumnos.sexo', 'alumnos.fecha_nacimiento', 'alumnos.celular', 'evaluaciones.id as evaluacion_id', 'alumnos.id', 'examenes.nombre as valoracion')
        ->where('alumnos.academia_id','=', Auth::user()->academia_id)
        ->where('examenes.boolean_grupal','=',1);

        if($request->clase_grupal_id)
        {
            $query->where('examenes.clase_grupal_id','=', $request->clase_grupal_id);
        }

        if($request->tipo)
        {
            $query->where('examenes.tipo','=', $request->tipo);
        }

        if($request->tipo)
        {
            $query->where('examenes.tipo','=', $request->tipo);
        }

        if($request->examen_id)
        {
            $query->where('examenes.id','=', $request->examen_id);
        }
        
        
        if($request->boolean_fecha){
            $fecha = explode(' - ', $request->fecha);
            $start = Carbon::createFromFormat('d/m/Y',$fecha[0])->toDateString();
            $end = Carbon::createFromFormat('d/m/Y',$fecha[1])->toDateString();
            $query->whereBetween('evaluaciones.created_at', [$start,$end]);
        }
            
        $inscritos = $query->get();

        $forAge = DB::select("SELECT CASE
                        WHEN age BETWEEN 3 and 10 THEN '3 - 10'
                        WHEN age BETWEEN 11 and 20 THEN '11 - 20'
                        WHEN age BETWEEN 21 and 35 THEN '21 - 35'
                        WHEN age BETWEEN 36 and 50 THEN '36 - 50'
                        WHEN age >= 51 THEN '+51'
                        WHEN age IS NULL THEN 'Sin fecha (NULL)'
                    END as age_range, COUNT(*) AS count
                    FROM (SELECT TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS age
                    FROM alumnos
                    JOIN  evaluaciones ON evaluaciones.alumno_id=alumnos.id
                    JOIN  examenes ON evaluaciones.examen_id=examenes.id
                    WHERE alumnos.academia_id = '".Auth::user()->academia_id."')  as alumnos
                    GROUP BY age_range
                    ORDER BY age_range");  

                    // WHERE evaluaciones.created_at >= '".$start."' AND evaluaciones.created_at <= '".$end."' AND alumnos.academia_id = '".Auth::user()->academia_id."')  as alumnos 

        
        $array = array();
        $mujeres = 0;
        $hombres = 0;
        $array_sexo = array();
        $in = array(2,4);

        foreach($inscritos as $inscrito){

            $alumnoc = User::join('alumnos', 'alumnos.id', '=', 'users.usuario_id')
                ->join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->where('alumnos.id','=', $inscrito->id)
                ->whereIn('usuarios_tipo.tipo', $array)
                ->where('users.confirmation_token', '!=', null)
            ->first();

            if($alumnoc){
                $activacion = 0;
            }else{
                $activacion = 1;
            }

            $collection=collect($inscrito); 
            $inscrito_array = $collection->toArray();
            
            $inscrito_array['activacion']=$activacion;
            $array[$inscrito->evaluacion_id] = $inscrito_array;

            if($inscrito->sexo == 'F'){
                $mujeres++;
            }else{
                $hombres++;
            }
        }  

        $array_hombres = array('M', $hombres);
        $array_mujeres = array('F', $mujeres);

        array_push($array_sexo, $array_hombres);
        array_push($array_sexo, $array_mujeres);    
        
        return response()->json(
            [
                'inscritos'         => $array,
                'mujeres'           => $mujeres,
                'hombres'           => $hombres,
                'edades'            => $forAge,
                'mensaje'           => '¡Excelente! Los campos se han guardado satisfactoriamente', 
                'status'            => 'OK',
                'sexos'             => $array_sexo,
                200
            ]);

    }
	public function Inscritos(){

        return view('reportes.inscritos')->with([]);
	}

    public function InscritosFiltros(Request $request)
    {

        $query = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
            ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_niveles_baile', 'clases_grupales.nivel_baile_id', '=', 'config_niveles_baile.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('alumnos.nombre', 'alumnos.apellido', 'alumnos.sexo', 'alumnos.fecha_nacimiento','inscripcion_clase_grupal.fecha_inscripcion as fecha', 'config_especialidades.nombre as especialidad', 'config_clases_grupales.nombre as curso', 'inscripcion_clase_grupal.id', 'alumnos.celular', 'config_niveles_baile.nombre as nivel', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final', 'clases_grupales.fecha_inicio', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'inscripcion_clase_grupal.tipo_pago')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id);

        if($request->sexo)
        {
            $query->where('alumnos.sexo','=', $request->sexo);
        }

        if($request->boolean_fecha){
            $fecha = explode(' - ', $request->fecha);
            $start = Carbon::createFromFormat('d/m/Y',$fecha[0])->toDateString();
            $end = Carbon::createFromFormat('d/m/Y',$fecha[1])->toDateString();
            $query->whereBetween('inscripcion_clase_grupal.fecha_inscripcion', [$start,$end]);
        }else{

            if($request->tipo){
                if($request->tipo == 1){
                    $start = Carbon::now()->toDateString();
                    $end = Carbon::now()->addDay()->toDateString();  
                }else if($request->tipo == 2){
                    $start = Carbon::now()->startOfMonth()->toDateString();
                    $end = Carbon::now()->endOfMonth()->toDateString();  
                }else if($request->tipo == 3){
                    $start = Carbon::now()->startOfMonth()->subMonth()->toDateString();
                    $end = Carbon::now()->endOfMonth()->subMonth()->toDateString();  
                }

                $query->whereBetween('inscripcion_clase_grupal.fecha_inscripcion', [$start,$end]);
            }
        }

            
        $inscritos = $query->get();

        $array = array();

        $total = 0;
        $mujeres = 0;
        $hombres = 0;
        $credito = 0;
        $contado = 0;
        $total_inscritos = 0;
        $manana = 0;
        $tarde = 0;
        $noche = 0;

        foreach($inscritos as $inscrito){

            $total_inscritos++;

            $fecha = Carbon::createFromFormat('Y-m-d', $inscrito->fecha_inicio);
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
 
            if($inscrito->tipo_pago == 1){
                $contado++;
            }else{
                $credito++;
            }

            if($inscrito->sexo == 'F'){
                $mujeres++;
            }else{
                $hombres++;
            }

            $edad = Carbon::createFromFormat('Y-m-d', $inscrito->fecha_nacimiento)->diff(Carbon::now())->format('%y');

            $hora_inicio = strtotime($inscrito->hora_inicio);
            $hora_final = strtotime($inscrito->hora_final);
                
            if($request->edad_inicio OR $request->edad_final)
            {
                if($hora_inicio >= strtotime("07:00:00") && $hora_final <= strtotime("12:00:00")){
                    $manana++;
                }else if($hora_inicio >= strtotime("12:01:00") && $hora_final <= strtotime("17:00:00")){
                    $tarde++;
                }else if($hora_inicio >= strtotime("17:01:00") && $hora_final <= strtotime("22:00:00")){
                    $noche++;
                }

                if($request->edad_inicio && $request->edad_final){
                    if($edad >= $request->edad_inicio && $edad <= $request->edad_final){
                        $collection=collect($inscrito);     
                        $inscrito_array = $collection->toArray(); 
                        $inscrito_array['edad'] = $edad;  
                        $inscrito_array['dia'] = $dia;
                        $array[$inscrito->id] = $inscrito_array;
                    }
                }else if($request->edad_inicio){
                   if($edad >= $request->edad_inicio){
                        $collection=collect($inscrito);     
                        $inscrito_array = $collection->toArray();   
                        $inscrito_array['edad'] = $edad;  
                        $inscrito_array['dia'] = $dia;
                        $array[$inscrito->id] = $inscrito_array;
                    } 
                }else if($request->edad_final){
                    if($edad <= $request->edad_inicio){
                        $collection=collect($inscrito);     
                        $inscrito_array = $collection->toArray(); 
                        $inscrito_array['edad'] = $edad;  
                        $inscrito_array['dia'] = $dia; 
                        $array[$inscrito->id] = $inscrito_array;
                    }
                }

            }else{

                if($hora_inicio >= strtotime("07:00:00") && $hora_final <= strtotime("12:00:00")){
                    $manana++;
                }else if($hora_inicio >= strtotime("12:01:00") && $hora_final <= strtotime("17:00:00")){
                    $tarde++;
                }else if($hora_inicio >= strtotime("17:01:00") && $hora_final <= strtotime("22:00:00")){
                    $noche++;
                }

                $collection=collect($inscrito);     
                $inscrito_array = $collection->toArray();  
                $inscrito_array['edad'] = $edad;  
                $inscrito_array['dia'] = $dia;
                $array[$inscrito->id] = $inscrito_array;
            }
            
        }

        $array_sexo = array();

        $array_hombres = array('M', $hombres);
        $array_mujeres = array('F', $mujeres);

        array_push($array_sexo, $array_hombres);
        array_push($array_sexo, $array_mujeres);   

        $array_hora = array();

        $array_manana = array('Mañana / 7:00 - 12:00', $manana);
        $array_tarde = array('Tarde / 12:01 - 5:00', $tarde);
        $array_noche = array('Noche / 5:01 - 10:00', $noche);

        array_push($array_hora, $array_manana);
        array_push($array_hora, $array_tarde);
        array_push($array_hora, $array_noche);

        return response()->json(
            [
                'inscritos'         => $array,
                'mujeres'           => $mujeres,
                'hombres'           => $hombres,
                'total'             => $total,
                'sexos'             => $array_sexo,
                'horas'             => $array_hora,
                'contado'           => $contado,
                'credito'           => $credito,
                'total_inscritos'   => $total_inscritos,
                'mensaje'           => '¡Excelente! El reporte se ha generado satisfactoriamente',
                'status'            => 'OK'

            ]);

    }


    /**
        *   Reportes Visitas Presenciales
        *   Reportes Visitas Presenciales con Filtros
        *
    */    
	public function Presenciales(){


        $como_nos_conociste = ComoNosConociste::all();
        $promotores = Staff::where('cargo',1)->where('academia_id', Auth::user()->academia_id)->get();

        return view('reportes.presenciales')->with([ 'promotores' => $promotores, 'como_nos_conociste' => $como_nos_conociste]);
	}

    public function PresencialesFiltros(Request $request)
    {

        $query = Visitante::Leftjoin('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
            ->select('visitantes_presenciales.*', 'config_especialidades.nombre as especialidad')
            ->where('visitantes_presenciales.academia_id','=', Auth::user()->academia_id);

        if($request->instructor_id)
        {
            $query->where('visitantes_presenciales.instructor_id','=', $request->instructor_id);
        }

        if($request->como_nos_conociste_id)
        {
            $query->where('visitantes_presenciales.como_nos_conociste_id','=', $request->como_nos_conociste_id);
        }

        if($request->boolean_fecha){
            $fecha = explode(' - ', $request->fecha);
            $start = Carbon::createFromFormat('d/m/Y',$fecha[0])->toDateString();
            $end = Carbon::createFromFormat('d/m/Y',$fecha[1])->toDateString();
            $query->whereBetween('visitantes_presenciales.fecha_registro', [$start,$end]);
        }else{

            if($request->tipo){

                $actual = Carbon::now();
                // $geoip = new GeoIP();
                // $geoip->setIp($request->ip());
                // $actual->tz = $geoip->getTimezone();

                if($request->tipo == 1){
                    $start = $actual->toDateString();
                    $end = $actual->toDateString();  
                }else if($request->tipo == 2){
                    $start = $actual->startOfMonth()->toDateString();
                    $end = $actual->endOfMonth()->toDateString();  
                }else if($request->tipo == 3){
                    $start = $actual->startOfMonth()->subMonth()->toDateString();
                    $end = Carbon::now()->endOfMonth()->subMonth()->toDateString();  
                }

                $query->whereBetween('visitantes_presenciales.fecha_registro', [$start,$end]);
            }
        }

            
        $presenciales = $query->get();

        $array = array();

        $total_clientes = 0;
        $total_visitantes = 0;
        $mujeres = 0;
        $hombres = 0;
        
        
        $amigo = 0;
        $redes = 0;
        $prensa = 0;
        $television = 0;
        $radio = 0;
        $lugar = 0;
        $otros = 0;

        $niños = 0;
        $adultos = 0;

        $entre_semana = 0;
        $fines_de_semana = 0;
        $ambos = 0;
        $total_dias_clase = 0;

        $cantidad_1 = 0;
        $cantidad_2 = 0;
        $cantidad_3 = 0;
        $cantidad_4 = 0;
        $cantidad_5 = 0;

        $promotores = Staff::where('cargo',1)->where('academia_id', Auth::user()->academia_id)->get();

        $array_promotor = array();

        foreach($promotores as $promotor){
            $array_promotor[$promotor->id] = ['nombre' => $promotor->nombre . ' ' . $promotor->apellido, 'cantidad' => 0];

        }

        foreach($presenciales as $presencial){

            $collection=collect($presencial);     
            $presencial_array = $collection->toArray();

            if($presencial->alumno_id){

                $inscripcion = InscripcionClaseGrupal::where('alumno_id', $presencial->alumno_id)->first();

                if($inscripcion){

                    if(isset($array_promotor[$inscripcion->instructor_id]))
                    {
                        $array_promotor[$inscripcion->instructor_id]['cantidad']++;
                    }

                    $presencial_array['cliente'] = 1;
                    
                    $total_clientes = $total_clientes + 1;
                }else{
                    $presencial_array['cliente'] = 0;
                }
            }else{
                $presencial_array['cliente'] = 0;
            }

            $total_visitantes = $total_visitantes + 1;

            if($presencial->interes_id == '1'){
                $adultos++;
            }else{
                $niños++;
            }

            if($presencial->sexo == 'F'){
                $mujeres++;
            }else{
                $hombres++;
            }

            if($presencial->dias_clase_id == '1'){
                $entre_semana++;
                $total_dias_clase++;
            }else if($presencial->dias_clase_id == '2'){
                $fines_de_semana++;
                $total_dias_clase++;
            }else if($presencial->dias_clase_id == '3'){
                $ambos++;
                $total_dias_clase++;
            }
            
            if($presencial->como_nos_conociste_id == 1){
                $amigo++;
            }else if($presencial->como_nos_conociste_id == 2){
                $redes++;
            }else if($presencial->como_nos_conociste_id == 3){
                $prensa++;
            }else if($presencial->como_nos_conociste_id == 4){
                $television++;
            }else if($presencial->como_nos_conociste_id == 5){
                $radio++;
            }else if($presencial->como_nos_conociste_id == 6){
                $lugar++;
            }else{
                $otros++;
            }

            $edad = Carbon::createFromFormat('Y-m-d', $presencial->fecha_nacimiento)->diff(Carbon::now())->format('%y');
            
            if($edad >= 3 AND $edad <= 10 ){
                $cantidad_1++;
            }else if($edad >= 11 AND $edad <= 20 ){
                $cantidad_2++;
            }else if($edad >= 21 AND $edad <= 35 ){
                $cantidad_3++;
            }else if($edad >= 36 AND $edad <= 50 ){
                $cantidad_4++;
            }else{
                $cantidad_5++;
            }

            if($presencial->especialidad == '' OR $presencial->especialidad == null){
                $presencial_array['especialidad']='Sin Especificar';
            }   

            $array[$presencial->id] = $presencial_array;
        }

        $array_conociste = array();
        $array_edad = array();
        $array_dias = array();

        $array_amigo = array('Por un amigo', $amigo);
        $array_redes = array('Redes sociales / internet', $redes);
        $array_prensas = array('Prensa', $prensa);
        $array_television = array('Televisión', $television);
        $array_radios = array('Radio', $radio);
        $array_lugar = array('Ubicación/Lugar', $lugar);
        $array_otros = array('Otros', $otros);

        array_push($array_conociste, $array_amigo);
        array_push($array_conociste, $array_redes);
        array_push($array_conociste, $array_prensas);
        array_push($array_conociste, $array_television);
        array_push($array_conociste, $array_radios);
        array_push($array_conociste, $array_lugar);
        array_push($array_conociste, $array_otros);

        $array_3 = array('3 - 10', $cantidad_1);
        $array_11 = array('11 - 20', $cantidad_2);
        $array_21 = array('21 - 35', $cantidad_3);
        $array_36 = array('36 - 50', $cantidad_4);
        $array_51 = array('+51', $cantidad_5);

        array_push($array_edad, $array_3);
        array_push($array_edad, $array_11);
        array_push($array_edad, $array_21);
        array_push($array_edad, $array_36);
        array_push($array_edad, $array_51);

        $array_entre_semana = array('Entre Semana', $entre_semana);
        $array_fines_de_semana = array('Fines de Semana', $fines_de_semana);
        $array_ambos = array('Ambos', $ambos);

        array_push($array_dias, $array_entre_semana);
        array_push($array_dias, $array_fines_de_semana);
        array_push($array_dias, $array_ambos);

        return response()->json([
            
            'presenciales'      => $array,
            'mujeres'           => $mujeres,
            'hombres'           => $hombres,
            'adultos'           => $adultos,
            'niños'             => $niños,
            'entre_semana'      => $entre_semana,
            'fines_de_semana'   => $fines_de_semana,
            'ambos'             => $ambos,
            'total_dias_clase'  => $total_dias_clase,
            'total_clientes'    => $total_clientes,
            'total_visitantes'  => $total_visitantes,
            'conociste'         => $array_conociste,
            'edades'            => $array_edad,
            'dias'              => $array_dias,
            'promotores'        => $array_promotor,
            'mensaje'           => '¡Excelente! El reporte se ha generado satisfactoriamente'

        ]);

    }

    /**
        *   Reportes Visitas Presenciales
        *   Reportes Visitas Presenciales con Filtros
        *
    */    
	public function Contactos(){

		$alumnos = Alumno::where('alumnos.academia_id','=', Auth::user()->academia_id)->get();
        $array_alumno = array();
        $array_clase_grupal = array();

        foreach($alumnos as $alumno){

            $inscripcion_clase_grupal = InscripcionClaseGrupal::where('alumno_id',$alumno->id)->first();

            if($inscripcion_clase_grupal){

                $collection=collect($alumno);     
                $alumno_array = $collection->toArray();
                $alumno_array['clase_grupal_id'] = $inscripcion_clase_grupal->clase_grupal_id;
                $array_alumno[$alumno->id] = $alumno_array;

            }

        }

        $clases_grupales = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_clases_grupales.nombre as nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido',  'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.fecha_inicio','clases_grupales.fecha_final', 'clases_grupales.id')
            ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
            ->orderBy('clases_grupales.hora_inicio', 'asc')
        ->get();  

        $array = array();

        foreach($clases_grupales as $clase_grupal){

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

            $collection=collect($clase_grupal);     
            $clase_grupal_array = $collection->toArray();

            $clase_grupal_array['dia']=$dia;
            $array_clase_grupal[$clase_grupal->id] = $clase_grupal_array;

        }

        return view('reportes.contactos')->with(['alumnos' => $array_alumno, 'clases_grupales' => $array_clase_grupal]);
	}

    public function Asistencias()
    {
        $clase_grupal_join = ClaseGrupal::join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->select('config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.id as instructor_id','clases_grupales.id as clase_grupal_id' , 'clases_grupales.fecha_inicio as fecha_inicio', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final')
            ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
            ->where('clases_grupales.fecha_inicio', '<=', Carbon::now()->toDateString())
        	->where('clases_grupales.fecha_final', '>=', Carbon::now()->toDateString())
        ->get();

        $horarios = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('horarios_clases_grupales', 'horarios_clases_grupales.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('instructores', 'horarios_clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.id as instructor_id','clases_grupales.id as clase_grupal_id' , 'horarios_clases_grupales.fecha as fecha_inicio', 'horarios_clases_grupales.id as horario_id','instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final')
            ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
            ->where('clases_grupales.deleted_at', '=', null)
            ->where('clases_grupales.fecha_inicio', '<=', Carbon::now()->toDateString())
        	->where('clases_grupales.fecha_final', '>=', Carbon::now()->toDateString())
        ->get();

        $array = array();

        foreach($clase_grupal_join as $clase_grupal){
            $fecha_inicio = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
            $dia = $fecha_inicio->dayOfWeek;

            if($dia == 0){
                $dia = 7;
            }

            $collection=collect($clase_grupal);     
            $clase_array = $collection->toArray();
                
            $clase_array['dia']=$dia;
            $clase_array['tipo']=1;
            $clase_array['tipo_id']=$clase_grupal->clase_grupal_id;
            $array['1'.$clase_grupal->clase_grupal_id] = $clase_array;
        }


        foreach($horarios as $clase_grupal){
            $fecha_inicio = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
            $dia = $fecha_inicio->dayOfWeek;   

            if($dia == 0){
                $dia = 7;
            }

            $collection=collect($clase_grupal);     
            $clase_array = $collection->toArray();
                
            $clase_array['dia']=$dia;
            $clase_array['tipo']=2;
            $clase_array['tipo_id']=$clase_grupal->horario_id;
            $array['2'.$clase_grupal->clase_grupal_id] = $clase_array;
        }

        return view('reportes.asistencias')->with(['clases_grupales' => $array]);
    }

    public function AsistenciasFiltros(Request $request){
        
        $query = Asistencia::join('clases_grupales', 'asistencias.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('alumnos', 'asistencias.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.*', 'asistencias.fecha as fecha', 'asistencias.hora as hora', 'alumnos.id as alumno_id', 'asistencias.clase_grupal_id', 'asistencias.id', 'config_clases_grupales.nombre as clase_grupal_nombre', 'asistencias.boolean_credencial')
            ->where('alumnos.deleted_at',null)
            ->where('clases_grupales.fecha_inicio', '<=', Carbon::now()->toDateString())
        	->where('clases_grupales.fecha_final', '>=', Carbon::now()->toDateString())
            ->where('clases_grupales.deleted_at',null);



        $query2 = InscripcionClaseGrupal::join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'alumnos.sexo as sexo', 'alumnos.fecha_nacimiento as fecha_nacimiento', 'alumnos.sexo as sexo', 'alumnos.telefono as telefono', 'alumnos.celular as celular', 'alumnos.id as alumno_id', 'clases_grupales.id as clase_grupal_id', 'alumnos.identificacion as identificacion', 'inscripcion_clase_grupal.id', 'config_clases_grupales.nombre as clase_grupal_nombre')
            ->where('alumnos.deleted_at',null)
            ->where('clases_grupales.fecha_inicio', '<=', Carbon::now()->toDateString())
        	->where('clases_grupales.fecha_final', '>=', Carbon::now()->toDateString())
            ->where('clases_grupales.deleted_at',null);


        if($request->clase_grupal_id)
        {
            $query->where('asistencias.clase_grupal_id','=', $request->clase_grupal_id);
            $query2->where('inscripcion_clase_grupal.clase_grupal_id','=', $request->clase_grupal_id);
        }else{
            $clases_grupales = explode(",", $request->clases_grupales);
            $query->whereIn('asistencias.clase_grupal_id', $clases_grupales);
            $query2->whereIn('inscripcion_clase_grupal.clase_grupal_id', $clases_grupales);
        }

        // if($request->alumno_id)
        // {
        //     $query->where('asistencias.alumno_id','=', $request->alumno_id);
        //     $query2->where('inscripcion_clase_grupal.alumno_id','=', $request->alumno_id);
        // }

        if($request->fecha){
            $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);

            if($fecha > Carbon::now()){
                return response()->json(['errores' => ['linea' => [0, 'Ups! Esta fecha es invalida, debes ingresar una fecha menor al dia de hoy']], 'status' => 'ERROR'],422);

            }

            $fecha = $fecha->toDateString();
            $query->where('asistencias.fecha','=', $fecha);
        }
        

        $asistencias = $query->get();
        $inscripciones = $query2->get();
        $in = array(2,4);

        $mujeres = 0;
        $hombres = 0;
        $total = 0;
        $array_estatus = array();

        if($request->participante_id == 1){

            $array = array();

            foreach($asistencias as $asistencia){

                $pertenece = InscripcionClaseGrupal::where('inscripcion_clase_grupal.clase_grupal_id', '=', $asistencia->clase_grupal_id)
                    ->where('inscripcion_clase_grupal.alumno_id', '=', $asistencia->alumno_id)
                ->first();

                $deuda = ItemsFacturaProforma::where('fecha_vencimiento','<=',Carbon::today())
                    ->where('usuario_id', $asistencia->alumno_id)
                ->sum('importe_neto');

                if($pertenece){
                    $pertenece = '<i class="zmdi c-verde zmdi-check zmdi-hc-fw"></i>';
                }else{
                    if($asistencia->boolean_credencial){
                        $pertenece = '<i class="icon_e-reglamentos c-amarillo" data-original-title="" data-content="Credencial" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';
                    }else{
                        if($asistencia->sexo == 'M'){
                            $pertenece = '<i class="icon_f-consultarle-al-instructor c-azul" data-original-title="" data-content="Invitado" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';
                        }else{
                            $pertenece = '<i class="icon_f-consultarle-al-instructor c-rosado" data-original-title="" data-content="Invitado" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';
                        }
                    }
                    
                }

                if($deuda){
                    $estatus = '<i class="zmdi zmdi-money c-youtube zmdi-hc-fw f-20"></i>';
                }else{
                    $estatus = '<i class="zmdi zmdi-money c-verde zmdi-hc-fw f-20"></i>';
                    $deuda = 0;
                }

                $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                    ->where('usuarios_tipo.tipo_id',$asistencia->alumno_id)
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

                $collection=collect($asistencia);     
                $asistencia_array = $collection->toArray();
                $asistencia_array['imagen']=$imagen;
                $asistencia_array['pertenece']=$pertenece;
                $asistencia_array['deuda']=$deuda;
                $asistencia_array['estatus']=$estatus;
                $array[$asistencia->id] = $asistencia_array;

                if($asistencia->sexo == 'F'){
                    $mujeres = $mujeres + 1;
                }else{
                    $hombres = $hombres + 1;
                }
            }

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'tipo' => $request->participante_id, 'mujeres' => $mujeres, 'hombres' => $hombres, 200]);

        }else if($request->participante_id == 2){

            $inasistencias = array();

            foreach($inscripciones as $inscripcion){

                $asistio = Asistencia::where('clase_grupal_id', $inscripcion->clase_grupal_id)->where('alumno_id',$inscripcion->alumno_id)->where('fecha', $fecha)->first();

                if(!$asistio)
                {
              
                    $pertenece = '';

                    $deuda = ItemsFacturaProforma::where('fecha_vencimiento','<=',Carbon::today())
                        ->where('usuario_id', $inscripcion->alumno_id)
                    ->sum('importe_neto');

                    if($deuda){
                        $estatus = '<i class="zmdi zmdi-money c-youtube zmdi-hc-fw f-20"></i>';
                    }else{
                        $estatus = '<i class="zmdi zmdi-money c-verde zmdi-hc-fw f-20"></i>';
                        $deuda = 0;
                    }

                    $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                        ->where('usuarios_tipo.tipo_id',$inscripcion->alumno_id)
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

                    $collection=collect($inscripcion);     
                    $inasistencias_array = $collection->toArray();
                    $inasistencias_array['imagen']=$imagen;
                    $inasistencias_array['pertenece']=$pertenece;
                    $inasistencias_array['deuda']=$deuda;
                    $inasistencias_array['estatus']=$estatus;
                    $inasistencias[$inscripcion->id] = $inasistencias_array;

                    if($inscripcion->sexo == 'F'){
                        $mujeres = $mujeres + 1;
                    }else{
                        $hombres = $hombres + 1;
                    }
                    
                }               
            }

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $inasistencias, 'tipo' => $request->participante_id, 'mujeres' => $mujeres, 'hombres' => $hombres, 200]);
        }else{

            $array = array();
            $array_inscripcion = array();
            $total_asistencias = 0;
            $total_inasistencias = 0;

            foreach($inscripciones as $inscripcion){

                $asistio = 0;

                foreach($asistencias as $asistencia){
                    if($asistencia->alumno_id == $inscripcion->alumno_id){
                        $asistio = 1;
                        $fecha = $asistencia->fecha;
                        $hora = $asistencia->hora;
                        break;
                    }
                }

                if($asistio){
                    $total_asistencias++;
                    $pertenece = '<i class="zmdi c-verde zmdi-check zmdi-hc-fw"></i>';

                    if($inscripcion->sexo == 'F'){
                        $mujeres = $mujeres + 1;
                    }else{
                        $hombres = $hombres + 1;
                    }

                }else{
                    $total_inasistencias++;
                    $pertenece = '<i class="zmdi c-amarillo zmdi-dot-circle zmdi-hc-fw"></i>';
                    $fecha = '';
                    $hora = '';
                }

                $deuda = ItemsFacturaProforma::where('fecha_vencimiento','<=',Carbon::today())
                    ->where('usuario_id', $inscripcion->alumno_id)
                ->sum('importe_neto');

                if($deuda){
                    $estatus = '<i class="zmdi zmdi-money c-youtube zmdi-hc-fw f-20"></i>';
                }else{
                    $estatus = '<i class="zmdi zmdi-money c-verde zmdi-hc-fw f-20"></i>';
                    $deuda = 0;
                }

                $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                    ->where('usuarios_tipo.tipo_id',$inscripcion->alumno_id)
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

                $collection=collect($inscripcion);     
                $asistencia_array = $collection->toArray();
                $asistencia_array['imagen']=$imagen;
                $asistencia_array['pertenece']=$pertenece;
                $asistencia_array['deuda']=$deuda;
                $asistencia_array['estatus']=$estatus;
                $asistencia_array['fecha']=$fecha;
                $asistencia_array['hora']=$hora;
                $array[$inscripcion->id] = $asistencia_array;

                $array_inscripcion[] = $inscripcion->alumno_id;
            }

            foreach($asistencias as $asistencia){
                $existe = false;
                foreach($array_inscripcion as $inscripcion){
                    if($asistencia->alumno_id == $inscripcion){
                        $existe = true;
                    }
                }

                if($existe == false){

                    $total_asistencias++;

                    $deuda = ItemsFacturaProforma::where('fecha_vencimiento','<=',Carbon::today())
                        ->where('usuario_id', $asistencia->alumno_id)
                    ->sum('importe_neto');
  
                    if($asistencia->sexo == 'M'){
                        $pertenece = '<i class="icon_f-consultarle-al-instructor c-azul" data-original-title="" data-content="Invitado" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';
                        $hombres = $hombres + 1;
                    }else{
                        $pertenece = '<i class="icon_f-consultarle-al-instructor c-rosado" data-original-title="" data-content="Invitado" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';
                        $mujeres = $mujeres + 1;
                    }

                    if($asistencia->boolean_credencial){

                        $pertenece = '<i class="icon_e-reglamentos c-amarillo" data-original-title="" data-content="Credencial" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';

                        if($asistencia->sexo == 'M'){
                            $hombres = $hombres + 1;
                        }else{
                            $mujeres = $mujeres + 1;
                        }
                    }else{
                        if($asistencia->sexo == 'M'){
                            $pertenece = '<i class="icon_f-consultarle-al-instructor c-azul" data-original-title="" data-content="Invitado" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';
                            $hombres = $hombres + 1;
                        }else{
                            $pertenece = '<i class="icon_f-consultarle-al-instructor c-rosado" data-original-title="" data-content="Invitado" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';
                            $mujeres = $mujeres + 1;
                        }
                    }
                        
                    if($deuda){
                        $estatus = '<i class="zmdi zmdi-money c-youtube zmdi-hc-fw f-20"></i>';
                    }else{
                        $estatus = '<i class="zmdi zmdi-money c-verde zmdi-hc-fw f-20"></i>';
                        $deuda = 0;
                    }

                    $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                        ->where('usuarios_tipo.tipo_id',$asistencia->alumno_id)
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

                    $collection=collect($asistencia);     
                    $asistencia_array = $collection->toArray();
                    $asistencia_array['imagen']=$imagen;
                    $asistencia_array['pertenece']=$pertenece;
                    $asistencia_array['deuda']=$deuda;
                    $asistencia_array['estatus']=$estatus;
                    $array['2-'.$asistencia->id] = $asistencia_array;

                }
            }

            $array_asistencias = array('Asistencias', $total_asistencias);
            $array_inasistencias = array('Inasistencias', $total_inasistencias);

            array_push($array_estatus, $array_asistencias);
            array_push($array_estatus, $array_inasistencias);

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'tipo' => $request->participante_id, 'estatus' => $array_estatus, 'mujeres' => $mujeres, 'hombres' => $hombres, 200]);
            
        }
    }

    public function Estatus_Alumnos()
    {

        $alumnos = Alumno::where('alumnos.academia_id', '=', Auth::user()->academia_id)
                ->orderBy('nombre', 'asc')
        ->get();


        $clases_grupales = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('clases_grupales.id',
                         'clases_grupales.hora_inicio',
                         'clases_grupales.hora_final',
                         'clases_grupales.fecha_inicio',
                         'config_clases_grupales.nombre',
                         'instructores.nombre as instructor_nombre',
                         'instructores.apellido as instructor_apellido')
                ->where('clases_grupales.academia_id','=',Auth::user()->academia_id)
                ->orderBy('clases_grupales.hora_inicio', 'asc')
        ->get();

        foreach($clases_grupales as $clase){

            $fecha = Carbon::createFromFormat('Y-m-d', $clase->fecha_inicio);
          
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

            $collection=collect($clase);     
            $clase_array = $collection->toArray();
                
            $clase_array['dia']=$dia;
            $clases[$clase->id] = $clase_array;
        }

        return view('reportes.estatus_alumnos')->with(['alumnos' => $alumnos, 'clases_grupales' => $clases]);
    }

    public function Estatus_AlumnosFiltros(Request $request){

        $alumnos = Alumno::where('academia_id',Auth::user()->academia_id)
            ->orderBy('created_at', 'desc')
        ->get();

        $tipo_clase = array(1,2);
        $array = array();

        $activos = 0;
        $riesgo = 0;
        $inactivos = 0;

        foreach($alumnos as $alumno){

            $inasistencias = 0;

            $query = InscripcionClaseGrupal::join('clases_grupales', 'clases_grupales.id', '=', 'inscripcion_clase_grupal.clase_grupal_id')
            ->join('config_clases_grupales','clases_grupales.clase_grupal_id','=','config_clases_grupales.id')
            ->select('inscripcion_clase_grupal.id as inscripcion_id',
                    'inscripcion_clase_grupal.fecha_inscripcion',
                     'config_clases_grupales.nombre as clase_nombre',
                     'clases_grupales.id',
                     'clases_grupales.fecha_inicio',
                     'clases_grupales.fecha_final',
                     'config_clases_grupales.asistencia_rojo',
                     'config_clases_grupales.asistencia_amarilla'
                    )
            ->where('inscripcion_clase_grupal.alumno_id', $alumno->id)
            ->where('clases_grupales.deleted_at', null)
            ->orderBy('inscripcion_clase_grupal.fecha_inscripcion', 'desc');

            if($request->clase_grupal_id){
                $query->where('clases_grupales.id', '=', $request->clase_grupal_id);
            }

            $clase_grupal = $query->first();

            if($clase_grupal){

                //CONFIGURACIONES DE ASISTENCIAS

                $asistencia_amarilla = $clase_grupal->asistencia_amarilla;
                $asistencia_roja = $clase_grupal->asistencia_rojo;

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

                        $fecha_a_comparar = Carbon::createFromFormat('Y-m-d',$ultima_asistencia->fecha);
                        $dia_a_comparar = $fecha_a_comparar->dayOfWeek;
                        
                        if($dia_a_comparar != 0){
                            $dia_a_comparar = $fecha_a_comparar->dayOfWeek;
                        }else{
                            $dia_a_comparar = 7;
                        }

                        $j = 0;

                    }else{

                        $fecha_tmp = Carbon::createFromFormat('Y-m-d',$clasegrupal->fecha_inscripcion);
                        $fecha_tmp2 = Carbon::createFromFormat('Y-m-d', $clasegrupal->fecha_inicio);

                        if($fecha_tmp > $fecha_tmp2){
                            $fecha_a_comparar = $fecha_tmp;
                        }else{
                            $fecha_a_comparar = $fecha_tmp2;
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
                        
                        $j = 1;
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

                    if($inasistencias >= $asistencia_roja && $asistencia_roja != 0){
                        $estatus="c-youtube";
                        $inactivos = $inactivos + 1;
                    }else if($inasistencias >= $asistencia_amarilla && $asistencia_amarilla != 0){
                        $estatus="c-amarillo";
                        $riesgo = $riesgo + 1;
                    }else{
                        $estatus="c-verde";
                        $activos = $activos + 1;
                    }
                    
                }else{
                    $estatus="c-verde";
                    $activos = $activos + 1;
                }
            }else{
                $estatus="c-youtube";
                $inactivos = $inactivos + 1;
            }

            if($clase_grupal){
                $clase_nombre = $clase_grupal->clase_nombre;
                $inscripcion_id = $clase_grupal->inscripcion_id;
            }else{
                $clase_nombre = '';
                $inscripcion_id = '';
            }

            $collection=collect($alumno);     
            $alumno_array = $collection->toArray();
            $alumno_array['estatus'] = $estatus;
            $alumno_array['clase_nombre'] = $clase_nombre;
            $alumno_array['inscripcion_id'] = $inscripcion_id;

            if($request->estatus_alumno_id){
                if($request->estatus_alumno_id == 1 && $estatus=="c-verde"){
                    $array[] = $alumno_array;
                }else if($request->estatus_alumno_id == 2 && $estatus=="c-amarillo"){
                    $array[] = $alumno_array;
                }else if($request->estatus_alumno_id == 3 && $estatus=="c-youtube"){
                    $array[] = $alumno_array;
                }
            }else{
                $array[] = $alumno_array;
            }
        }

        $array_estatus = array();

        $array_activos = array('Inactivos', $inactivos);
        $array_riesgo = array('Riesgo de Ausencia', $riesgo);
        $array_inactivos = array('Activos', $activos);

        array_push($array_estatus, $array_activos);
        array_push($array_estatus, $array_riesgo);
        array_push($array_estatus, $array_inactivos);  


        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'reporte_datos' => $array, 'estatus' => $array_estatus, 200]);
    }

    public function Administrativo()
    {
        $clases_grupales = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_clases_grupales.nombre as nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido',  'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.fecha_inicio','clases_grupales.fecha_final', 'clases_grupales.id')
            ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
            ->orderBy('clases_grupales.hora_inicio', 'asc')
        ->get();  

        $array = array();

        foreach($clases_grupales as $clase_grupal){

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

            $collection=collect($clase_grupal);     
            $clase_grupal_array = $collection->toArray();

            $clase_grupal_array['dia']=$dia;
            $array[$clase_grupal->id] = $clase_grupal_array;

        }

        $config_servicio=ConfigServicios::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

        foreach($config_servicio as $item){

            $tmp[]=array('id' => $item['id'], 'nombre' => $item['nombre'] , 'tipo' => $item['tipo']);
        }

        $config_producto=ConfigProductos::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

        foreach($config_producto as $item){

            $tmp[]=array('id' => $item['id'], 'nombre' => $item['nombre'] , 'tipo' => $item['tipo']);
           
        }

        $collection=collect($tmp);   
        $linea_servicio = $collection->toArray();

        $config_egresos = ConfigEgreso::all();

        return view('reportes.administrativo')->with(['clases_grupales' => $array, 'linea_servicio' => $linea_servicio, 'config_egresos' => $config_egresos]);
    }

    public function AdministrativoFiltros(Request $request)
    {

        $array = array();
        $array_pago = array();
        $array_config_egreso = array();
        $array_ingreso = array();
        $total = 0;
        $total_ingreso = 0;
        $total_egreso = 0;
        $total_proforma = 0;

        //INGRESOS

        if($request->tipo == 1 OR $request->tipo == 2){

            $tipos_pago = FormasPago::all();

            foreach($tipos_pago as $tipo_pago){
                $array_pago[$tipo_pago->id] = ['nombre' => $tipo_pago->nombre, 'cantidad' => 0];

            }

            $array_ingreso[0] = ['nombre' => 'Academía Recepción', 'cantidad' => 0];
            $array_ingreso[1] = ['nombre' => 'Fiestas y Eventos', 'cantidad' => 0];
            $array_ingreso[2] = ['nombre' => 'Talleres', 'cantidad' => 0];
            $array_ingreso[3] = ['nombre' => 'Campañas', 'cantidad' => 0];

            $query = Factura::join('items_factura', 'items_factura.factura_id', '=', 'facturas.id')
                ->join('alumnos', 'facturas.usuario_id', '=', 'alumnos.id')
                ->select('facturas.*',
                     'items_factura.tipo',
                     'items_factura.item_id',
                     'alumnos.nombre',
                     'alumnos.apellido')
                ->where('alumnos.academia_id', '=', Auth::user()->academia_id)
                ->distinct('facturas.id');

            //CLASE GRUPAL

            if($request->clase_grupal_id)
            {
                $query->join('inscripcion_clase_grupal','inscripcion_clase_grupal.alumno_id','=','alumnos.id')
                    ->where('inscripcion_clase_grupal.clase_grupal_id','=', $request->clase_grupal_id);
            }

            //LINEA DE SERVICIO

            if($request->servicio_tipo)
            {
                if($request->servicio_tipo == 99)
                {
                    $not_in = array(5,11,14);
                    $query->whereNotIn('items_factura.tipo', $not_in);
                }else if($request->servicio_tipo == 3){
                    $in = array(3,4);
                    $query->whereIn('items_factura.tipo', $in);
                }else{
                    $query->where('items_factura.tipo', $request->servicio_tipo);
                }
            }

            //DETALLE

            // if($request->nombre)
            // {
            //     $array_explode = explode(",", $request->nombre);
            //     $tipo = array();

            //     foreach($array_explode as $explode){
            //         $tipo[] = $explode;
            //     }

            //     $query->whereIn('items_factura.nombre', $tipo);
            // }

            if($request->servicio_id)
            {
                if($request->tipo_dropdown == 2){

                    $query->where('items_factura.item_id', $request->servicio_id);

                }
            }

            //FECHA

            if($request->boolean_fecha){

                $fecha = explode(' - ', $request->fecha2);
                $start = Carbon::createFromFormat('d/m/Y',$fecha[0])->toDateString();
                $end = Carbon::createFromFormat('d/m/Y',$fecha[1])->toDateString();
                $query->whereBetween('facturas.fecha', [$start,$end]);

            }else{

                if($request->tipo){
                    if($request->fecha == 1){
                        $start = Carbon::now()->toDateString();
                        $end = Carbon::now()->addDay()->toDateString();  
                    }else if($request->fecha == 2){
                        $start = Carbon::now()->startOfMonth()->toDateString();
                        $end = Carbon::now()->endOfMonth()->toDateString();  
                    }else if($request->fecha == 3){
                        $start = Carbon::now()->startOfMonth()->subMonth()->toDateString();
                        $end = Carbon::now()->endOfMonth()->subMonth()->subDay()->toDateString();  
                    }

                    $query->whereBetween('facturas.fecha', [$start,$end]);
                }
            }

            $facturas = $query->get();

            foreach($facturas as $factura){

                $tipos_pago = Pago::join('formas_pago', 'pagos.forma_pago', '=', 'formas_pago.id')
                    ->where('factura_id', $factura->id)
                ->get();

                $pago = '';
                $importe_neto = 0;

                if($tipos_pago){

                    foreach($tipos_pago as $tipo_pago){

                        if(!$pago){
                            $pago = $tipo_pago->nombre;
                        }

                        $array_pago[$tipo_pago->forma_pago]['cantidad'] += $tipo_pago->monto;

                        $importe_neto += $tipo_pago->monto;
                        
                    }

                }else{
                    $pago = 'Efectivo';
                }

                if($factura->tipo == 14){
                    $array_ingreso[1]['cantidad'] += $importe_neto;
                }else if($factura->tipo == 5){
                    $array_ingreso[2]['cantidad'] += $importe_neto;
                }else if($factura->tipo == 11){
                    $array_ingreso[3]['cantidad'] += $importe_neto;
                }else{
                    $array_ingreso[0]['cantidad'] += $importe_neto;
                }

                $collection=collect($factura);     
                $factura_array = $collection->toArray();
                $factura_array['cliente'] = $factura->nombre . ' ' . $factura->apellido;
                $factura_array['fecha'] = Carbon::parse($factura->fecha)->toDateString();
                $factura_array['hora'] = Carbon::parse($factura->created_at)->toTimeString();
                $factura_array['tipo_pago'] = $pago;
                $factura_array['tipo'] = 1;
                $factura_array['nombre'] = $factura->concepto;
                $factura_array['importe_neto'] = $importe_neto;
                $array[$factura->id] = $factura_array;

                $total_ingreso = $total_ingreso + $importe_neto;

            }
          
        }

        if($request->tipo == 1 OR $request->tipo == 3){

            //EGRESOS

            // $query = Egreso::join('tipos_egresos', 'egresos.tipo', '=', 'tipos_egresos.id')
            // ->join('users', 'egresos.administrador_id', '=', 'users.id')
            // ->select('egresos.*', 'tipos_egresos.nombre as nombre_egreso', 'users.nombre as administrador_nombre','users.apellido as administrador_apellido')
            // ->where('egresos.academia_id', '=', Auth::user()->academia_id);

             $query = Egreso::join('tipos_egresos', 'egresos.tipo', '=', 'tipos_egresos.id')
                ->select('egresos.*', 'tipos_egresos.nombre as nombre_egreso')
            ->where('egresos.academia_id', '=', Auth::user()->academia_id);

            //LINEA DE SERVICIO

            if($request->tipo_servicio)
            {
                if($request->tipo_servicio == 99){
                    $query->where('egresos.tipo', 1);
                }else if($request->tipo_servicio == 14){
                    $query->where('egresos.tipo', 2);
                }else if($request->tipo_servicio == 5){
                    $query->where('egresos.tipo', 3);
                }else if($request->tipo_servicio == 11){
                    $query->where('egresos.tipo', 4);
                }
            }

            if($request->servicio_tipo)
            {
                $query->where('egresos.config_tipo', $request->servicio_tipo);
            }

            //FECHA

            if($request->boolean_fecha){
                $fecha = explode(' - ', $request->fecha2);
                $start = Carbon::createFromFormat('d/m/Y',$fecha[0])->toDateString();
                $end = Carbon::createFromFormat('d/m/Y',$fecha[1])->toDateString();
                $query->whereBetween('egresos.fecha', [$start,$end]);
            }else{

                if($request->fecha){
                    if($request->fecha == 1){
                        $start = Carbon::now()->toDateString();
                        $end = Carbon::now()->addDay()->toDateString();  
                    }else if($request->fecha == 2){
                        $start = Carbon::now()->startOfMonth()->toDateString();
                        $end = Carbon::now()->endOfMonth()->toDateString();  
                    }else if($request->fecha == 3){
                        $start = Carbon::now()->startOfMonth()->subMonth()->toDateString();
                        $end = Carbon::now()->endOfMonth()->subMonth()->subDay()->toDateString();  
                    }

                    $query->whereBetween('egresos.fecha', [$start,$end]);
                }
            }

            $egresos = $query->get();

            $config_egreso = ConfigEgreso::all();

            foreach($config_egreso as $egreso){
                $array_config_egreso[$egreso->id] = ['nombre' => $egreso->nombre, 'cantidad' => 0];

            }

            if($request->servicio_tipo == 0 || $request->servicio_tipo == 6){

                $comisiones = Comision::join('staff','comisiones.usuario_id','=','staff.id')
                    ->select('comisiones.*')
                    ->where('staff.academia_id',Auth::user()->academia_id)
                    ->whereBetween('comisiones.fecha', [$start,$end])
                    ->where('comisiones.boolean_pago',1)
                ->sum('comisiones.monto');

                if(!$comisiones){
                    $comisiones = 0;
                }

                $array_config_egreso[6]['cantidad'] += $comisiones;
            }

            if($request->servicio_tipo == 0 || $request->servicio_tipo == 7){

                $nomina = PagoInstructor::join('instructores','pagos_instructor.instructor_id','=','instructores.id')
                    ->select('pagos_instructor.*')
                    ->where('instructores.academia_id',Auth::user()->academia_id)
                    ->whereBetween('pagos_instructor.fecha', [$start,$end])
                    ->where('pagos_instructor.boolean_pago',1)
                ->sum('pagos_instructor.monto');

                if(!$nomina){
                    $nomina = 0;
                }

                $array_config_egreso[7]['cantidad'] += $nomina;
            }

            foreach($egresos as $egreso){

                $array_config_egreso[$egreso->config_tipo]['cantidad'] += $egreso->cantidad;

                $collection=collect($egreso);     
                $egreso_array = $collection->toArray();
                // $egreso_array['cliente'] = $egreso->administrador_nombre . ' ' . $egreso->administrador_apellido;
                $egreso_array['cliente'] = $egreso->proveedor;
                $egreso_array['nombre'] = $egreso->concepto;
                $egreso_array['importe_neto'] = $egreso->cantidad;
                $egreso_array['fecha'] = Carbon::parse($egreso->fecha)->toDateString();
                $egreso_array['hora'] = Carbon::parse($egreso->created_at)->toTimeString();
                $egreso_array['tipo_pago'] = $egreso->nombre_egreso;
                $egreso_array['tipo'] = 2;
                $array['2-'.$egreso->id] = $egreso_array;

                $total_egreso = $total_egreso + $egreso->cantidad;

            }
        }

        //CUENTAS POR COBRAR

        if($request->tipo == 1 OR $request->tipo == 4){

            $query = Alumno::join('inscripcion_clase_grupal','inscripcion_clase_grupal.alumno_id','=','alumnos.id')
            ->select('alumnos.id as id',
                     'alumnos.nombre',
                     'alumnos.apellido')
            ->where('alumnos.academia_id', '=', Auth::user()->academia_id)
            ->orderBy('nombre', 'asc');
                    
            //CLASE GRUPAL

            if($request->clase_grupal_id)
            {
                $query->where('inscripcion_clase_grupal.clase_grupal_id','=', $request->clase_grupal_id);
            }

            $query->distinct('id');

            $alumnos = $query->get();

            foreach($alumnos as $alumno){

                $query = ItemsFacturaProforma::where('usuario_id', $alumno->id)->where('usuario_tipo',1);

                //LINEA DE SERVICIO

                if($request->tipo_servicio)
                {

                    if($request->tipo_servicio == 99)
                    {
                        $not_in = array(1,2,3,4,5,11,14);
                        $query->whereNotIn('tipo', $not_in);
                    }else if($request->tipo_servicio == 3){
                        $in = array(3,4);
                        $query->whereIn('tipo', $in);
                    }else{
                        $query->where('tipo', $request->tipo_servicio);
                    }
                }

                //DETALLE

                if($request->nombre)
                {
                    $array_explode = explode(",", $request->nombre);
                    $tipo = array();

                    foreach($array_explode as $explode){
                        $tipo[] = $explode;
                    }

                    $query->whereIn('nombre', $tipo);
                }

                //FECHA

                // if($request->boolean_fecha){
                //     $fecha = explode(' - ', $request->fecha2);
                //     $start = Carbon::createFromFormat('d/m/Y',$fecha[0])->toDateString();
                //     $end = Carbon::createFromFormat('d/m/Y',$fecha[1])->toDateString();
                //     $query->whereBetween('fecha', [$start,$end]);
                // }else{

                //     if($request->tipo){
                //         if($request->fecha == 1){
                //             $start = Carbon::now()->toDateString();
                //             $end = Carbon::now()->toDateString();  
                //         }else if($request->fecha == 2){
                //             $start = Carbon::now()->startOfMonth()->toDateString();
                //             $end = Carbon::now()->endOfMonth()->toDateString();  
                //         }else if($request->fecha == 3){
                //             $start = Carbon::now()->startOfMonth()->subMonth()->toDateString();
                //             $end = Carbon::now()->endOfMonth()->subMonth()->toDateString();  
                //         }

                //         $query->whereBetween('fecha', [$start,$end]);
                //     }
                // }

                $proformas = $query->get();

                foreach($proformas as $proforma){

                    $collection=collect($proforma);     
                    $proforma_array = $collection->toArray();
                    $proforma_array['cliente'] = $alumno->nombre . ' ' . $alumno->apellido;
                    $proforma_array['fecha'] = Carbon::parse($proforma->fecha)->toDateString();
                    $proforma_array['hora'] = Carbon::parse($proforma->created_at)->toTimeString();
                    $proforma_array['tipo_pago']='Cuentas por Cobrar';
                    $proforma_array['tipo'] = 3;
                    $array['3-'.$proforma->id] = $proforma_array;

                    $total_proforma = $total_proforma + $proforma->importe_neto;

                }
            }
        }

        return response()->json(['mensaje' => '¡Excelente! El reporte se ha generado satisfactoriamente', 'status' => 'OK', 'facturas' => $array, 'total_ingreso' => $total_ingreso,'total_egreso' => $total_egreso, 'total_proforma' => $total_proforma, 'array_pago' => $array_pago, 'array_ingreso' => $array_ingreso, 'config_egreso' => $array_config_egreso, 200]);

    }

    public function Camiseta_Programacion(){

        $inscritos = DB::table('inscripcion_clase_grupal')
            ->join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
            ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->select('alumnos.nombre', 'alumnos.apellido', 'alumnos.sexo', 'alumnos.fecha_nacimiento','inscripcion_clase_grupal.fecha_inscripcion as fecha', 'config_especialidades.nombre as especialidad', 'config_clases_grupales.nombre as curso', 'inscripcion_clase_grupal.id', 'alumnos.celular', 'inscripcion_clase_grupal.boolean_franela', 'inscripcion_clase_grupal.boolean_programacion')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
        ->get();

        $clases_grupales= DB::table('clases_grupales')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_clases_grupales.nombre as nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido',  'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.fecha_inicio','clases_grupales.fecha_final', 'clases_grupales.id')
            ->where('clases_grupales.deleted_at', '=', null)
            ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
            ->orderBy('clases_grupales.hora_inicio', 'asc')
      ->get();   

      $array = array();

      foreach($clases_grupales as $clase_grupal){

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

        $collection=collect($clase_grupal);     
        $clase_grupal_array = $collection->toArray();

        $clase_grupal_array['dia']=$dia;
        $array[$clase_grupal->id] = $clase_grupal_array;

      }

    

        return view('reportes.camiseta_programacion')->with(['inscritos' => $inscritos, 'clases_grupales' => $array]);
    }


    public function Camiseta_ProgramacionFiltros(Request $request)
    {

        $query = DB::table('inscripcion_clase_grupal')
            ->join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
            ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->select('alumnos.nombre', 'alumnos.apellido', 'alumnos.sexo', 'alumnos.fecha_nacimiento','inscripcion_clase_grupal.fecha_inscripcion as fecha', 'config_especialidades.nombre as especialidad', 'config_clases_grupales.nombre as curso', 'inscripcion_clase_grupal.id', 'alumnos.celular')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id);


        if($request->clase_grupal_id)
        {
            $query->where('clases_grupales.id','=', $request->clase_grupal_id);
        }


        if($request->tipo == 0){
            $query->where('inscripcion_clase_grupal.boolean_franela',1);
            $query->where('inscripcion_clase_grupal.boolean_programacion',1);
        }else if($request->tipo == 1){
            $query->where('inscripcion_clase_grupal.boolean_franela',1);
        }else if($request->tipo == 2){
            $query->where('inscripcion_clase_grupal.boolean_programacion',1);
        }

        $inscritos = $query->get();

        return response()->json(
            [
                'inscritos'         => $inscritos,
                'mensaje'           => '¡Excelente! El reporte se ha generado satisfactoriamente',
                'status'            => 'OK'

            ]);

    }

    public function Referidos(){

        $referidos = Alumno::where('academia_id','=', Auth::user()->academia_id)
        ->where('referido_id', '!=', null)
        ->get();

        $alumnos = Alumno::where('academia_id','=', Auth::user()->academia_id)->orderBy('nombre', 'asc')
        ->get();

        $total = Alumno::where('academia_id','=', Auth::user()->academia_id)
        ->where('referido_id', '!=', null)
        ->count();

        $sexo = Alumno::selectRaw('sexo, count(sexo) as CantSex')
            ->where('academia_id','=', Auth::user()->academia_id)
            ->where('referido_id', '!=', null)
            ->groupBy('.sexo')
            ->get();

        $mujeres = Alumno::where('sexo', 'F')->where('academia_id',Auth::user()->academia_id)->where('referido_id', '!=', null)->count();
        $hombres = Alumno::where('sexo', 'M')->where('academia_id',Auth::user()->academia_id)->where('referido_id', '!=', null)->count();
                        

        return view('reportes.referidos')->with(['referidos' => $referidos, 'sexos' => $sexo, 'mujeres' => $mujeres, 'hombres' => $hombres, 'total' => $total, 'alumnos' => $alumnos]);
    }

    public function ReferidosFiltros(Request $request)
    {

        $query = Alumno::where('academia_id','=', Auth::user()->academia_id)
        ->where('referido_id', '!=', null);

        if($request->alumno_id)
        {
            $query->where('referido_id','=', $request->alumno_id);
        }

        if($request->boolean_fecha){
            $fecha = explode(' - ', $request->fecha);
            $start = Carbon::createFromFormat('d/m/Y',$fecha[0])->toDateString();
            $end = Carbon::createFromFormat('d/m/Y',$fecha[1])->toDateString();
            $query->whereBetween('created_at', [$start,$end]);
        }else{

            if($request->tipo){
                if($request->tipo == 1){
                    $start = Carbon::now()->toDateString();
                    $end = Carbon::now()->addDay()->toDateString();  
                }else if($request->tipo == 2){
                    $start = Carbon::now()->startOfMonth()->toDateString();
                    $end = Carbon::now()->endOfMonth()->toDateString();  
                }else if($request->tipo == 3){
                    $start = Carbon::now()->startOfMonth()->subMonth()->toDateString();
                    $end = Carbon::now()->endOfMonth()->subMonth()->toDateString();  
                }

                $query->whereBetween('created_at', [$start,$end]);
            }
        }

            
        $referidos = $query->get();

        $array = array();

        $total = 0;
        $mujeres = 0;
        $hombres = 0;

        foreach($referidos as $referido){

            $total = $total + 1;
            
            if($referido->sexo == 'F'){
                $mujeres++;
            }else{
                $hombres++;
            }

            $collection=collect($referido);     
            $referido_array = $collection->toArray();  
            $array[$referido->id] = $referido_array;
        }

        $array_sexo = array();

        $array_hombres = array('M', $hombres);
        $array_mujeres = array('F', $mujeres);

        array_push($array_sexo, $array_hombres);
        array_push($array_sexo, $array_mujeres);   

        return response()->json(
            [
                'referidos'         => $array,
                'mujeres'           => $mujeres,
                'hombres'           => $hombres,
                'total'             => $total,
                'sexos'             => $array_sexo,
                'mensaje'           => '¡Excelente! El reporte se ha generado satisfactoriamente'

            ]);

    }

    public function Credenciales(){

        $alumnos = Alumno::where('academia_id','=', Auth::user()->academia_id)->orderBy('nombre', 'asc')
        ->get();

        $clases_grupales= DB::table('clases_grupales')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_clases_grupales.nombre as nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido',  'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.fecha_inicio','clases_grupales.fecha_final', 'clases_grupales.id')
            ->where('clases_grupales.deleted_at', '=', null)
            ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
            ->orderBy('clases_grupales.hora_inicio', 'asc')
        ->get();

        return view('reportes.credenciales')->with(['alumnos' => $alumnos, 'clases_grupales' => $clases_grupales]);
    }

    public function CredencialesFiltros(Request $request)
    {
        
         $query = DB::table('asistencias')
            ->join('clases_grupales', 'asistencias.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->join('alumnos', 'asistencias.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'alumnos.sexo as sexo', 'alumnos.fecha_nacimiento as fecha_nacimiento', 'alumnos.sexo as sexo', 'alumnos.telefono as telefono', 'alumnos.celular as celular', 'asistencias.fecha as fecha', 'asistencias.hora as hora', 'alumnos.id as alumno_id', 'alumnos.identificacion as identificacion', 'asistencias.clase_grupal_id', 'asistencias.id')
            ->where('asistencias.pertenece', 0);

        if($request->clase_grupal_id)
        {
            $query->where('asistencias.clase_grupal_id','=', $request->clase_grupal_id);
        }

        if($request->alumno_id)
        {
            $query->where('asistencias.alumno_id','=', $request->alumno_id);
        }

        if($request->boolean_fecha){
            $fecha = explode(' - ', $request->fecha);
            $start = Carbon::createFromFormat('d/m/Y',$fecha[0])->toDateString();
            $end = Carbon::createFromFormat('d/m/Y',$fecha[1])->toDateString();
            $query->whereBetween('asistencias.fecha', [$start,$end]);
        }else{

            if($request->tipo){
                if($request->tipo == 1){
                    $start = Carbon::now()->toDateString();
                    $end = Carbon::now()->addDay()->toDateString();  
                }else if($request->tipo == 2){
                    $start = Carbon::now()->startOfMonth()->toDateString();
                    $end = Carbon::now()->endOfMonth()->toDateString();  
                }else if($request->tipo == 3){
                    $start = Carbon::now()->startOfMonth()->subMonth()->toDateString();
                    $end = Carbon::now()->endOfMonth()->subMonth()->toDateString();  
                }

                $query->whereBetween('asistencias.fecha', [$start,$end]);
            }
        }
        

        $asistencias = $query->get();
        $array = array();

        foreach($asistencias as $asistencia){

            $deuda = ItemsFacturaProforma::where('fecha_vencimiento','<=',Carbon::today())
                ->where('usuario_id', $asistencia->alumno_id)
            ->sum('importe_neto');

            if($deuda){
                $deuda = '<i class="zmdi zmdi-money c-youtube zmdi-hc-fw f-20"></i>';
            }else{
                $deuda = '<i class="zmdi zmdi-money c-verde zmdi-hc-fw f-20"></i>';
            }

            $collection=collect($asistencia);     
            $asistencia_array = $collection->toArray();
            $asistencia_array['deuda']=$deuda;
            $array[$asistencia->id] = $asistencia_array;
            
        }

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 200]);

        
    }

    public function Master(Request $request){

        $actual = Carbon::now();
        // $geoip = new GeoIP();
        // $geoip->setIp($request->ip());
        // $actual->tz = $geoip->getTimezone();

        $start = $actual->startOfMonth()->toDateString();
        $end = $actual->endOfMonth()->toDateString(); 

        $talleres = 0;
        $eventos = 0;
        $generales = 0;
        $campanas = 0;

        $egresos_generales = Egreso::where('egresos.academia_id', Auth::user()->academia_id)->where('tipo',1)->whereBetween('egresos.fecha', [$start,$end])->sum('egresos.cantidad');

        if(!$egresos_generales){
            $egresos_generales = 0;
        }

        $egresos_eventos = Egreso::where('egresos.academia_id', Auth::user()->academia_id)->where('tipo',2)->whereBetween('egresos.fecha', [$start,$end])->sum('egresos.cantidad');

        if(!$egresos_eventos){
            $egresos_eventos = 0;
        }

        $egresos_talleres = Egreso::where('egresos.academia_id', Auth::user()->academia_id)->where('tipo',3)->whereBetween('egresos.fecha', [$start,$end])->sum('egresos.cantidad');

        if(!$egresos_talleres){
            $egresos_talleres = 0;
        }

        $egresos_campanas = Egreso::where('egresos.academia_id', Auth::user()->academia_id)->where('tipo',4)->whereBetween('egresos.fecha', [$start,$end])->sum('egresos.cantidad');

        if(!$egresos_campanas){
            $egresos_campanas = 0;
        }

        $visitantes_mujeres = 0;
        $visitantes_hombres = 0;

        $inscritos_mujeres = 0;
        $inscritos_hombres = 0;

        $referidos_mujeres = 0;
        $referidos_hombres = 0;

        $inscritos= Alumno::join('inscripcion_clase_grupal','inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')->where('alumnos.academia_id', Auth::user()->academia_id)->whereBetween('inscripcion_clase_grupal.created_at', [$start,$end])->get();

        $cantidad_1 = 0;
        $cantidad_2 = 0;
        $cantidad_3 = 0;
        $cantidad_4 = 0;
        $cantidad_5 = 0;

        foreach($inscritos as $inscrito){

            if($inscrito->sexo == 'F'){
                $inscritos_mujeres++;
            }else{
                $inscritos_hombres++;
            }

            $edad = Carbon::createFromFormat('Y-m-d', $inscrito->fecha_nacimiento)->diff(Carbon::now())->format('%y');
            
            if($edad >= 3 AND $edad <= 10 ){
                $cantidad_1++;
            }else if($edad >= 11 AND $edad <= 20 ){
                $cantidad_2++;
            }else if($edad >= 21 AND $edad <= 35 ){
                $cantidad_3++;
            }else if($edad >= 36 AND $edad <= 50 ){
                $cantidad_4++;
            }else{
                $cantidad_5++;
            }
        }

        $array_inscrito = array();

        $array_3 = array('3 - 10', $cantidad_1);
        $array_11 = array('11 - 20', $cantidad_2);
        $array_21 = array('21 - 35', $cantidad_3);
        $array_36 = array('36 - 50', $cantidad_4);
        $array_51 = array('+51', $cantidad_5);

        array_push($array_inscrito, $array_3);
        array_push($array_inscrito, $array_11);
        array_push($array_inscrito, $array_21);
        array_push($array_inscrito, $array_36);
        array_push($array_inscrito, $array_51);


        $visitantes = Visitante::where('academia_id', Auth::user()->academia_id)->whereBetween('created_at', [$start,$end])->get();

        $amigo = 0;
        $redes = 0;
        $prensa = 0;
        $television = 0;
        $radio = 0;
        $lugar = 0;
        $otros = 0;

        $visitantes_mujeres = 0;
        $visitantes_hombres = 0;

        foreach($visitantes as $presencial){

            if($presencial->sexo == 'F'){
                $visitantes_mujeres++;
            }else{
                $visitantes_hombres++;
            }
            
            if($presencial->como_nos_conociste_id == 1){
                $amigo++;
            }else if($presencial->como_nos_conociste_id == 2){
                $redes++;
            }else if($presencial->como_nos_conociste_id == 3){
                $prensa++;
            }else if($presencial->como_nos_conociste_id == 4){
                $television++;
            }else if($presencial->como_nos_conociste_id == 5){
                $radio++;
            }else if($presencial->como_nos_conociste_id == 6){
                $lugar++;
            }else{
                $otros++;
            }
        }

        $array_conociste = array();

        $array_amigo = array('Por un amigo', $amigo);
        $array_redes = array('Redes sociales / internet', $redes);
        $array_prensas = array('Prensa', $prensa);
        $array_television = array('Televisión', $television);
        $array_radios = array('Radio', $radio);
        $array_lugar = array('Ubicación/Lugar', $lugar);
        $array_otros = array('Otros', $otros);

        array_push($array_conociste, $array_amigo);
        array_push($array_conociste, $array_redes);
        array_push($array_conociste, $array_prensas);
        array_push($array_conociste, $array_television);
        array_push($array_conociste, $array_radios);
        array_push($array_conociste, $array_lugar);
        array_push($array_conociste, $array_otros);

        $referidos = Alumno::where('academia_id', Auth::user()->academia_id)->whereBetween('created_at', [$start,$end])->where('referido_id', '!=', null)->get();

        $cantidad_1 = 0;
        $cantidad_2 = 0;
        $cantidad_3 = 0;
        $cantidad_4 = 0;
        $cantidad_5 = 0;

        foreach($referidos as $inscrito){

            if($inscrito->sexo == 'F'){
                $referidos_mujeres++;
            }else{
                $referidos_hombres++;
            }

            $edad = Carbon::createFromFormat('Y-m-d', $inscrito->fecha_nacimiento)->diff(Carbon::now())->format('%y');
            
            if($edad >= 3 AND $edad <= 10 ){
                $cantidad_1++;
            }else if($edad >= 11 AND $edad <= 20 ){
                $cantidad_2++;
            }else if($edad >= 21 AND $edad <= 35 ){
                $cantidad_3++;
            }else if($edad >= 36 AND $edad <= 50 ){
                $cantidad_4++;
            }else{
                $cantidad_5++;
            }
        }

        $array_referido = array();

        $array_3 = array('3 - 10', $cantidad_1);
        $array_11 = array('11 - 20', $cantidad_2);
        $array_21 = array('21 - 35', $cantidad_3);
        $array_36 = array('36 - 50', $cantidad_4);
        $array_51 = array('+51', $cantidad_5);

        array_push($array_referido, $array_3);
        array_push($array_referido, $array_11);
        array_push($array_referido, $array_21);
        array_push($array_referido, $array_36);
        array_push($array_referido, $array_51);


        $ingresos = Factura::where('academia_id', Auth::user()->academia_id)->whereBetween('created_at', [$start,$end])->get();

        foreach($ingresos as $ingreso){
            $facturas = ItemsFactura::where('factura_id', $ingreso->id)->get();
            foreach($facturas as $factura){
                if($factura->tipo == 5){

                    $talleres += floatval($factura->importe_neto);

                }else if($factura->tipo == 14){

                    $eventos += floatval($factura->importe_neto);

                }else if($factura->tipo == 11 OR $factura->tipo == 12){

                    $campanas += floatval($factura->importe_neto);

                }else{
                    $generales += floatval($factura->importe_neto);
                }
            }
        }

        return view('reportes.master')->with(['talleres' => $talleres, 'eventos' => $eventos, 'generales' => $generales, 'campanas' => $campanas, 'egresos_talleres' => $egresos_talleres, 'egresos_eventos' => $egresos_eventos, 'egresos_generales' => $egresos_generales, 'egresos_campanas' => $egresos_campanas, 'inscritos_hombres' => $inscritos_hombres, 'inscritos_mujeres' => $inscritos_mujeres, 'visitantes_hombres' => $visitantes_hombres, 'visitantes_mujeres' => $visitantes_mujeres, 'referidos_hombres' => $referidos_hombres, 'referidos_mujeres' => $referidos_mujeres, 'array_visitante' => $array_conociste, 'array_inscrito' => $array_inscrito, 'array_referido' => $array_referido]);

    }

    public function MasterFiltros(Request $request){


        if($request->boolean_fecha){
            $fecha = explode(' - ', $request->fecha);
            $start = Carbon::createFromFormat('d/m/Y',$fecha[0])->toDateString();
            $end = Carbon::createFromFormat('d/m/Y',$fecha[1])->toDateString();
        }else{

            if($request->tipo){

                $actual = Carbon::now();
                // $geoip = new GeoIP();
                // $geoip->setIp($request->ip());
                // $actual->tz = $geoip->getTimezone();

                if($request->tipo == 1){
                    $start = $actual->toDateString();
                    $end = $actual->toDateString();  
                }else if($request->tipo == 2){
                    $start = $actual->startOfMonth()->toDateString();
                    $end = $actual->endOfMonth()->toDateString();  
                }else if($request->tipo == 3){
                    $start = $actual->startOfMonth()->subMonth()->toDateString();
                    $end = Carbon::now()->endOfMonth()->subMonth()->toDateString();  
                }
            }
        }
        

        $talleres = 0;
        $eventos = 0;
        $generales = 0;
        $campanas = 0;

        $egresos_generales = Egreso::where('egresos.academia_id', Auth::user()->academia_id)->where('tipo',1)->whereBetween('egresos.fecha', [$start,$end])->sum('egresos.cantidad');

        if(!$egresos_generales){
            $egresos_generales = 0;
        }

        $egresos_eventos = Egreso::where('egresos.academia_id', Auth::user()->academia_id)->where('tipo',2)->whereBetween('egresos.fecha', [$start,$end])->sum('egresos.cantidad');

        if(!$egresos_eventos){
            $egresos_eventos = 0;
        }

        $egresos_talleres = Egreso::where('egresos.academia_id', Auth::user()->academia_id)->where('tipo',3)->whereBetween('egresos.fecha', [$start,$end])->sum('egresos.cantidad');

        if(!$egresos_talleres){
            $egresos_talleres = 0;
        }

        $egresos_campanas = Egreso::where('egresos.academia_id', Auth::user()->academia_id)->where('tipo',4)->whereBetween('egresos.fecha', [$start,$end])->sum('egresos.cantidad');

        if(!$egresos_campanas){
            $egresos_campanas = 0;
        }

        $visitantes_mujeres = 0;
        $visitantes_hombres = 0;

        $inscritos_mujeres = 0;
        $inscritos_hombres = 0;

        $referidos_mujeres = 0;
        $referidos_hombres = 0;

        $inscritos= Alumno::join('inscripcion_clase_grupal','inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')->where('alumnos.academia_id', Auth::user()->academia_id)->whereBetween('inscripcion_clase_grupal.created_at', [$start,$end])->get();

        $cantidad_1 = 0;
        $cantidad_2 = 0;
        $cantidad_3 = 0;
        $cantidad_4 = 0;
        $cantidad_5 = 0;

        foreach($inscritos as $inscrito){

            if($inscrito->sexo == 'F'){
                $inscritos_mujeres++;
            }else{
                $inscritos_hombres++;
            }

            $edad = Carbon::createFromFormat('Y-m-d', $inscrito->fecha_nacimiento)->diff(Carbon::now())->format('%y');
            
            if($edad >= 3 AND $edad <= 10 ){
                $cantidad_1++;
            }else if($edad >= 11 AND $edad <= 20 ){
                $cantidad_2++;
            }else if($edad >= 21 AND $edad <= 35 ){
                $cantidad_3++;
            }else if($edad >= 36 AND $edad <= 50 ){
                $cantidad_4++;
            }else{
                $cantidad_5++;
            }
        }

        $array_inscrito = array();

        $array_3 = array('3 - 10', $cantidad_1);
        $array_11 = array('11 - 20', $cantidad_2);
        $array_21 = array('21 - 35', $cantidad_3);
        $array_36 = array('36 - 50', $cantidad_4);
        $array_51 = array('+51', $cantidad_5);

        array_push($array_inscrito, $array_3);
        array_push($array_inscrito, $array_11);
        array_push($array_inscrito, $array_21);
        array_push($array_inscrito, $array_36);
        array_push($array_inscrito, $array_51);


        $visitantes = Visitante::where('academia_id', Auth::user()->academia_id)->whereBetween('fecha_registro', [$start,$end])->get();

        $amigo = 0;
        $redes = 0;
        $prensa = 0;
        $television = 0;
        $radio = 0;
        $lugar = 0;
        $otros = 0;

        $visitantes_mujeres = 0;
        $visitantes_hombres = 0;

        foreach($visitantes as $presencial){

            if($presencial->sexo == 'F'){
                $visitantes_mujeres++;
            }else{
                $visitantes_hombres++;
            }
            
            if($presencial->como_nos_conociste_id == 1){
                $amigo++;
            }else if($presencial->como_nos_conociste_id == 2){
                $redes++;
            }else if($presencial->como_nos_conociste_id == 3){
                $prensa++;
            }else if($presencial->como_nos_conociste_id == 4){
                $television++;
            }else if($presencial->como_nos_conociste_id == 5){
                $radio++;
            }else if($presencial->como_nos_conociste_id == 6){
                $lugar++;
            }else{
                $otros++;
            }
        }

        $array_conociste = array();

        $array_amigo = array('Por un amigo', $amigo);
        $array_redes = array('Redes sociales / internet', $redes);
        $array_prensas = array('Prensa', $prensa);
        $array_television = array('Televisión', $television);
        $array_radios = array('Radio', $radio);
        $array_lugar = array('Ubicación/Lugar', $lugar);
        $array_otros = array('Otros', $otros);

        array_push($array_conociste, $array_amigo);
        array_push($array_conociste, $array_redes);
        array_push($array_conociste, $array_prensas);
        array_push($array_conociste, $array_television);
        array_push($array_conociste, $array_radios);
        array_push($array_conociste, $array_lugar);
        array_push($array_conociste, $array_otros);

        $referidos = Alumno::where('academia_id', Auth::user()->academia_id)->whereBetween('created_at', [$start,$end])->where('referido_id', '!=', null)->get();

        $cantidad_1 = 0;
        $cantidad_2 = 0;
        $cantidad_3 = 0;
        $cantidad_4 = 0;
        $cantidad_5 = 0;

        foreach($referidos as $inscrito){

            if($inscrito->sexo == 'F'){
                $referidos_mujeres++;
            }else{
                $referidos_hombres++;
            }

            $edad = Carbon::createFromFormat('Y-m-d', $inscrito->fecha_nacimiento)->diff(Carbon::now())->format('%y');
            
            if($edad >= 3 AND $edad <= 10 ){
                $cantidad_1++;
            }else if($edad >= 11 AND $edad <= 20 ){
                $cantidad_2++;
            }else if($edad >= 21 AND $edad <= 35 ){
                $cantidad_3++;
            }else if($edad >= 36 AND $edad <= 50 ){
                $cantidad_4++;
            }else{
                $cantidad_5++;
            }
        }

        $array_referido = array();

        $array_3 = array('3 - 10', $cantidad_1);
        $array_11 = array('11 - 20', $cantidad_2);
        $array_21 = array('21 - 35', $cantidad_3);
        $array_36 = array('36 - 50', $cantidad_4);
        $array_51 = array('+51', $cantidad_5);

        array_push($array_referido, $array_3);
        array_push($array_referido, $array_11);
        array_push($array_referido, $array_21);
        array_push($array_referido, $array_36);
        array_push($array_referido, $array_51);

        $ingresos = Factura::where('academia_id', Auth::user()->academia_id)->whereBetween('created_at', [$start,$end])->get();

        foreach($ingresos as $ingreso){
            $facturas = ItemsFactura::where('factura_id', $ingreso->id)->get();
            foreach($facturas as $factura){
                if($factura->tipo == 5){

                    $talleres += floatval($factura->importe_neto);

                }else if($factura->tipo == 14){

                    $eventos += floatval($factura->importe_neto);

                }else if($factura->tipo == 11 OR $factura->tipo == 12){

                    $campanas += floatval($factura->importe_neto);

                }else{
                    $generales += floatval($factura->importe_neto);
                }
            }
        }

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'talleres' => $talleres, 'eventos' => $eventos, 'generales' => $generales, 'campanas' => $campanas, 'egresos_talleres' => $egresos_talleres, 'egresos_eventos' => $egresos_eventos, 'egresos_generales' => $egresos_generales, 'egresos_campanas' => $egresos_campanas, 'inscritos_hombres' => $inscritos_hombres, 'inscritos_mujeres' => $inscritos_mujeres, 'visitantes_hombres' => $visitantes_hombres, 'visitantes_mujeres' => $visitantes_mujeres, 'referidos_hombres' => $referidos_hombres, 'referidos_mujeres' => $referidos_mujeres, 'array_visitante' => $array_conociste, 'array_inscrito' => $array_inscrito, 'array_referido' => $array_referido, 200]);
    }

    public function AsistenciasPersonal()
    {
        $staffs = Staff::where('academia_id', Auth::user()->academia_id)->get();

        return view('reportes.asistencias_personal')->with(['staffs' => $staffs]);
    }

    public function AsistenciasPersonalFiltros(Request $request)
    {
        
        $query = Staff::where('academia_id','=',Auth::user()->academia_id);

        if($request->boolean_fecha){
            $fecha = explode(' - ', $request->fecha2);
            $start = Carbon::createFromFormat('d/m/Y',$fecha[0])->toDateString();
            $end = Carbon::createFromFormat('d/m/Y',$fecha[1])->toDateString();
        }else{

            if($request->fecha){

                $actual = Carbon::now();
                // $geoip = new GeoIP();
                // $geoip->setIp($request->ip());
                // $actual->tz = $geoip->getTimezone();

                if($request->fecha == 1){
                    $start = $actual->toDateString();
                    $end = $actual->toDateString();  
                }else if($request->fecha == 2){
                    $start = $actual->startOfMonth()->toDateString();
                    $end = $actual->endOfMonth()->toDateString();  
                }else if($request->fecha == 3){
                    $start = $actual->startOfMonth()->subMonth()->toDateString();
                    $end = Carbon::now()->endOfMonth()->subMonth()->toDateString();  
                }
            }
        }

        if($request->staff_id){
            $query->where('id',$request->staff_id);
        }

        $staffs = $query->get();

        $hoy = Carbon::now()->toDateString();
        $fecha_final_limite = Carbon::createFromFormat('Y-m-d H:i:s', $hoy . " 00:00:00");
        $fecha_final = Carbon::createFromFormat('Y-m-d H:i:s', $end . " 00:00:00");

        if($fecha_final > $fecha_final_limite){
            $fecha_final = $fecha_final_limite;
        }

        $efectivos = 0;
        $retrasos = 0;
        $inasistencias = 0;
        $array_estatus = array();
        $array = array();

        foreach($staffs as $staff){

            $fecha_creacion = Carbon::createFromFormat('Y-m-d H:i:s', $staff->created_at)->toDateString();
            $fecha_inicio_limite = Carbon::createFromFormat('Y-m-d H:i:s', $fecha_creacion . " 00:00:00");

            $horarios = HorarioStaff::join('dias_de_semana', 'horarios_staff.dia_de_semana_id', '=', 'dias_de_semana.id')
                ->select('horarios_staff.*', 'dias_de_semana.nombre as dia')
                ->where('staff_id' , $staff->id)
            ->get();

            foreach($horarios as $horario){

                $fecha_inicio = Carbon::createFromFormat('Y-m-d H:i:s', $start . " 00:00:00");
                $dia_creacion = $fecha_inicio->dayOfWeek;
                $dia_horario = $horario->dia_de_semana_id;
                $dias_a_sumar = 0; 

                if($dia_creacion == 0){
                	$dia_creacion = 7;
                }

                if($dia_creacion  > $dia_horario){

                    while ($dia_creacion != 7){
                        $dias_a_sumar++;
                        $dia_creacion++;
                    }

                    $dias = $dias_a_sumar + $dia_horario;
                    $fecha_inicio->addDays($dias);

                }else{
                    $dias = abs(intval($dia_creacion) - intval($dia_horario));
                    $fecha_inicio->addDays($dias);
                }

                $entrada_horario = Carbon::createFromFormat('H:i:s', $horario->hora_inicio);
                $salida_horario = Carbon::createFromFormat('H:i:s', $horario->hora_final);

                while($fecha_inicio <= $fecha_final){

                    if($fecha_inicio >= $fecha_inicio_limite){

                        $asistencia = AsistenciaStaff::where('fecha', $fecha_inicio)
                        ->where('staff_id',$staff->id)
                        ->first();

                        if($asistencia){

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

                            $hora_entrada = Carbon::createFromFormat('H:i:s', $asistencia->hora);
                            $hora_salida = Carbon::createFromFormat('H:i:s', $asistencia->hora_salida);

                            if($hora_entrada <= $entrada_horario && $hora_salida >= $salida_horario){

                                if($request->tipo == 1 OR $request->tipo == 2){

                                    $array[] = array('fecha' => $asistencia->fecha, "hora" => $asistencia->hora, 'clase' => '<i class="zmdi zmdi-check c-verde f-15"></i>', 'nombre' => $staff->nombre, 'apellido' => $staff->apellido, 'hora_salida' => $asistencia->hora_salida, 'dia' => $dia, 'tipo' => 'S', 'tipo_asistencia_staff' => 1);
                                    $efectivos++;
                                }

                            }else{

                                if($request->tipo == 1 OR $request->tipo == 3){
                                    $array[] = array('fecha' => $asistencia->fecha, "hora" => $asistencia->hora, 'clase' => '<i class="zmdi zmdi-alert-circle-o c-amarillo f-15"></i>', 'nombre' => $staff->nombre, 'apellido' => $staff->apellido, 'hora_salida' => $asistencia->hora_salida, 'dia' => $dia, 'tipo' => 'S', 'tipo_asistencia_staff' => 2);
                                    $retrasos++;
                                }
                            }

                        }else{

                            if($request->tipo == 1 OR $request->tipo == 4){

                                $array[] = array('fecha' => $fecha_inicio->toDateString(), "hora" => '', 'clase' => '<i class="zmdi zmdi-close c-youtube f-15"></i>', 'nombre' => $staff->nombre, 'apellido' => $staff->apellido, 'hora_salida' => '', 'dia' => $horario->dia, 'tipo' => 'S', 'tipo_asistencia_staff' => 3);
                                $inasistencias++;
                            }
                        }
                    }

                    $fecha_inicio->addWeek();

                }

            }
        }

        $array_efectivos = array('Horario efectivo', $efectivos);
        $array_retrasos = array('Retraso de horario', $retrasos);
        $array_inasistencias = array('Inasistencias', $inasistencias);

        array_push($array_estatus, $array_efectivos);
        array_push($array_estatus, $array_retrasos);
        array_push($array_estatus, $array_inasistencias);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'estatus' => $array_estatus, 200]);

    }

    public function Reservaciones(){

        $clases_grupales = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('clases_grupales.id',
                         'clases_grupales.hora_inicio',
                         'clases_grupales.hora_final',
                         'clases_grupales.fecha_inicio',
                         'config_clases_grupales.nombre',
                         'instructores.nombre as instructor_nombre',
                         'instructores.apellido as instructor_apellido')
                ->where('clases_grupales.academia_id','=',Auth::user()->academia_id)
                ->orderBy('clases_grupales.hora_inicio', 'asc')
        ->get();

        $array = array();

        foreach($clases_grupales as $clase){

            $fecha = Carbon::createFromFormat('Y-m-d', $clase->fecha_inicio);
          
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

            $collection=collect($clase);     
            $clase_array = $collection->toArray();
                
            $clase_array['dia']=$dia;
            $array[$clase->id] = $clase_array;
        }

        return view('reportes.reservaciones')->with(['clases_grupales' => $array]);
    }

    public function ReservacionesFiltros(Request $request)
    {

        $query = Reservacion::withTrashed()->where('academia_id', '=', Auth::user()->academia_id);

        if($request->tipo)
        {
            if($request->tipo == 1){
                $query->where('fecha_vencimiento','>=', Carbon::now()->toDateString())->whereNull('deleted_at');
            }else{
                $query->where('fecha_vencimiento','<', Carbon::now()->toDateString());
            }
            
        }

        if($request->clase_grupal_id)
        {
            $query->where('tipo_reservacion',1)->where('tipo_reservacion_id',$request->clase_grupal_id);
        }

        if($request->boolean_fecha){
            $fecha = explode(' - ', $request->fecha2);
            $start = Carbon::createFromFormat('d/m/Y',$fecha[0])->toDateString();
            $end = Carbon::createFromFormat('d/m/Y',$fecha[1])->toDateString();
            $query->whereBetween('fecha_reservacion', [$start,$end]);
        }else{

            if($request->fecha){
                if($request->fecha == 1){
                    $start = Carbon::now()->toDateString();
                    $end = Carbon::now()->addDay()->toDateString();  
                }else if($request->fecha == 2){
                    $start = Carbon::now()->startOfMonth()->toDateString();
                    $end = Carbon::now()->endOfMonth()->toDateString();  
                }else if($request->fecha == 3){
                    $start = Carbon::now()->startOfMonth()->subMonth()->toDateString();
                    $end = Carbon::now()->endOfMonth()->subMonth()->toDateString();  
                }

                $query->whereBetween('fecha_reservacion', [$start,$end]);
            }
        }

            
        $reservaciones = $query->get();

        $array = array();

        $total_confirmaciones = 0;
        $total = 0;
        $mujeres = 0;
        $hombres = 0;
        $interna = 0;
        $externa = 0;

        foreach($reservaciones as $reservacion){

            if($reservacion->boolean_confirmacion){
                $boolean_confirmacion = '<i class="zmdi c-verde zmdi-check zmdi-hc-fw"></i>';
                $total_confirmaciones++; 
            }else{
                $boolean_confirmacion = '<i class="zmdi c-amarillo zmdi-dot-circle zmdi-hc-fw"></i>';
            }

            $total++;
            
            if($reservacion->tipo_usuario == 1){
                $alumno = Alumno::withTrashed()->find($reservacion->tipo_usuario_id);
                $interna++;
            }else if($reservacion->tipo_usuario == 2){
                $alumno = Visitante::withTrashed()->find($reservacion->tipo_usuario_id);
                $interna++;
            }else{
                $alumno = Participante::find($reservacion->tipo_usuario_id);
                $externa++;
            }

            if($alumno->sexo == 'F'){
                $mujeres++;
            }else{
                $hombres++;
            }

            $clase_grupal = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('config_clases_grupales.nombre')
                ->where('clases_grupales.id','=',$reservacion->tipo_reservacion_id)
            ->first();

            if($clase_grupal){

                $collection=collect($reservacion);     
                $reservacion_array = $collection->toArray();   
                $reservacion_array['nombre'] = $alumno->nombre;
                $reservacion_array['apellido'] = $alumno->apellido;
                $reservacion_array['sexo'] = $alumno->sexo;
                $reservacion_array['celular'] = $alumno->celular;
                $reservacion_array['clase'] = $clase_grupal->nombre;
                $reservacion_array['boolean_confirmacion'] = $boolean_confirmacion;
                $array[$reservacion->id] = $reservacion_array;
            }
        }

        $array_reservacion = array();

        $array_interna = array('Interna', $interna);
        $array_externa = array('Externa', $externa);

        array_push($array_reservacion, $array_interna);
        array_push($array_reservacion, $array_externa);   

        return response()->json(
            [
                'reservaciones'                 => $array,
                'mujeres'                       => $mujeres,
                'hombres'                       => $hombres,
                'total'                         => $total,
                'tipos'                         => $array_reservacion,
                'total_confirmaciones'          => $total_confirmaciones,
                'mensaje'                       => '¡Excelente! El reporte se ha generado satisfactoriamente',
                'status'                        => 'OK'

            ]);

    }

    public function Comisiones()
    {
        $staffs = Staff::where('academia_id', Auth::user()->academia_id)->get();

        $promotores = array();

        foreach($staffs as $staff)
        {
            $collection=collect($staff);     
            $promotor_array = $collection->toArray();

            $promotor_array['tipo']=1;
            $promotor_array['id']='1-'.$staff->id;
            $promotor_array['icono']="<i class='icon_f-staff'></i>";
            $promotores['1-'.$staff->id] = $promotor_array;
        }

        $instructores = Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

        foreach($instructores as $instructor)
        {
            $collection=collect($instructor);     
            $promotor_array = $collection->toArray();

            $promotor_array['tipo']=2;
            $promotor_array['id']='2-'.$instructor->id;
            $promotor_array['icono']="<i class='icon_a-instructor'></i>";
            $promotores['2-'.$instructor->id] = $promotor_array;
        }

        $config_servicio=ConfigServicios::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

        foreach($config_servicio as $item){

            $tmp[]=array('id' => $item['id'], 'nombre' => $item['nombre'] , 'tipo' => $item['tipo'], 'servicio_producto_tipo' => 1);
        }

        $config_producto=ConfigProductos::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

        foreach($config_producto as $item){

            $tmp[]=array('id' => $item['id'], 'nombre' => $item['nombre'] , 'tipo' => $item['tipo'], 'servicio_producto_tipo' => 2);
           
        }

        $collection=collect($tmp);   
        $linea_servicio = $collection->toArray();

        return view('reportes.comisiones')->with(['promotores' => $promotores, 'linea_servicio' => $linea_servicio]);
    }

    public function ComisionesFiltros(Request $request)
    {
        
        $query = Comision::where('comisiones.academia_id','=',Auth::user()->academia_id);

        if($request->boolean_fecha){
            $fecha = explode(' - ', $request->fecha2);
            $start = Carbon::createFromFormat('d/m/Y',$fecha[0])->toDateString();
            $end = Carbon::createFromFormat('d/m/Y',$fecha[1])->toDateString();
            $query->whereBetween('fecha', [$start,$end]);
        }else{

            if($request->fecha){
                if($request->fecha == 1){
                    $start = Carbon::now()->toDateString();
                    $end = Carbon::now()->addDay()->toDateString();  
                }else if($request->fecha == 2){
                    $start = Carbon::now()->startOfMonth()->toDateString();
                    $end = Carbon::now()->endOfMonth()->toDateString();  
                }else if($request->fecha == 3){
                    $start = Carbon::now()->startOfMonth()->subMonth()->toDateString();
                    $end = Carbon::now()->endOfMonth()->subMonth()->toDateString();  
                }

                $query->whereBetween('fecha', [$start,$end]);
            }
        }

        if($request->usuario){
            $explode = explode('-', $request->usuario);
            $query->where('usuario_tipo', $explode[0]);
            $query->where('usuario_id', $explode[1]);
        }

        if($request->servicio_producto_tipo){
            $query->where('servicio_producto_tipo', $request->servicio_producto_tipo);
        }

        if($request->servicio_producto_id){
            $query->where('servicio_producto_id', $request->servicio_producto_id);
        }

        // if($request->servicio_producto){
        //     $explode = explode('-', $request->servicio_producto);
        //     $query->where('servicio_producto_tipo', $explode[0]);
        //     $query->where('servicio_producto_id', $explode[1]);
        // }

        $comisiones = $query->get();

        $pagadas = 0;
        $pendientes = 0;

        $array_estatus = array();
        $array = array();

        foreach($comisiones as $comision){

            if($request->tipo){
                if($request->tipo == 1 && $comision->boolean_pago){

                    if($comision->servicio_producto_tipo == 1){
                        $servicio_producto = ConfigServicios::withTrashed()->find($comision->servicio_producto_id);
                    }else{
                        $servicio_producto = ConfigProductos::withTrashed()->find($comision->servicio_producto_id);
                    }

                    if($comision->usuario_tipo == 1){
                        $usuario = Staff::withTrashed()->find($comision->usuario_id);
                    }else{
                        $usuario = Instructor::withTrashed()->find($comision->usuario_id);
                    }

                    $collection=collect($comision);     
                    $comision_array = $collection->toArray();
                    $comision_array['servicio_producto']=$servicio_producto->nombre;
                    $comision_array['usuario']=$usuario->nombre . ' ' . $usuario->apellido;
                    $array[$comision->id] = $comision_array;

                    $pagadas += $comision->monto;

                }else if($request->tipo == 2 && !$comision->boolean_pago){

                    if($comision->servicio_producto_tipo == 1){
                        $servicio_producto = ConfigServicios::withTrashed()->find($comision->servicio_producto_id);
                    }else{
                        $servicio_producto = ConfigProductos::withTrashed()->find($comision->servicio_producto_id);
                    }

                    if($comision->usuario_tipo == 1){
                        $usuario = Staff::withTrashed()->find($comision->usuario_id);
                    }else{
                        $usuario = Instructor::withTrashed()->find($comision->usuario_id);
                    }

                    $collection=collect($comision);     
                    $comision_array = $collection->toArray();
                    $comision_array['servicio_producto']=$servicio_producto->nombre;
                    $comision_array['usuario']=$usuario->nombre . ' ' . $usuario->apellido;
                    $array[$comision->id] = $comision_array;

                    $pendientes += $comision->monto;

                }
            }else{

                if($comision->servicio_producto_tipo == 1){
                    $servicio_producto = ConfigServicios::withTrashed()->find($comision->servicio_producto_id);
                }else{
                    $servicio_producto = ConfigProductos::withTrashed()->find($comision->servicio_producto_id);
                }

                if($comision->usuario_tipo == 1){
                    $usuario = Staff::withTrashed()->find($comision->usuario_id);
                }else{
                    $usuario = Instructor::withTrashed()->find($comision->usuario_id);
                }

                $collection=collect($comision);     
                $comision_array = $collection->toArray();
                $comision_array['servicio_producto']=$servicio_producto->nombre;
                $comision_array['usuario']=$usuario->nombre . ' ' . $usuario->apellido;
                $array[$comision->id] = $comision_array;

                if($comision->boolean_pago){
                    $pagadas += $comision->monto;
                }else{
                    $pendientes += $comision->monto; 
                }
            }
        }
           
        $array_pagadas = array('Pagadas', $pagadas);
        $array_pendientes = array('Pendientes por Pagar', $pendientes);

        array_push($array_estatus, $array_pagadas);
        array_push($array_estatus, $array_pendientes);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'estatus' => $array_estatus, 'pagadas' => $pagadas, 'pendientes' => $pendientes, 200]);

    }

    public function Eliminados(){

        $clases_grupales = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('clases_grupales.id',
                         'clases_grupales.hora_inicio',
                         'clases_grupales.hora_final',
                         'clases_grupales.fecha_inicio',
                         'config_clases_grupales.nombre',
                         'instructores.nombre as instructor_nombre',
                         'instructores.apellido as instructor_apellido')
                ->where('clases_grupales.academia_id','=',Auth::user()->academia_id)
                ->orderBy('clases_grupales.hora_inicio', 'asc')
        ->get();

        $array = array();

        foreach($clases_grupales as $clase){

            $fecha = Carbon::createFromFormat('Y-m-d', $clase->fecha_inicio);
          
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

            $collection=collect($clase);     
            $clase_array = $collection->toArray();
                
            $clase_array['dia']=$dia;
            $array[$clase->id] = $clase_array;
        }

        return view('reportes.eliminados')->with(['clases_grupales' => $array]);
    }

    public function EliminadosFiltros(Request $request)
    {

        $query =  Alumno::onlyTrashed()->join('users', 'alumnos.deleted_at_usuario_id', '=', 'users.id')
            ->select('alumnos.*', 'users.nombre as administrador_nombre', 'users.apellido as administrador_apellido')
        ->where('alumnos.academia_id', Auth::user()->academia_id);

        if($request->clase_grupal_id)
        {
            $query->join('inscripcion_clase_grupal', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
                ->where('inscripcion_clase_grupal.clase_grupal_id','=', $request->clase_grupal_id)
                ->distinct('alumnos.id');
        }

        if($request->boolean_fecha){
            $fecha = explode(' - ', $request->fecha);
            $start = Carbon::createFromFormat('d/m/Y',$fecha[0])->toDateString();
            $end = Carbon::createFromFormat('d/m/Y',$fecha[1])->toDateString();
            $query->whereBetween('alumnos.deleted_at', [$start,$end]);
        }else{

            if($request->tipo){
                if($request->tipo == 1){
                    $start = Carbon::now()->toDateString();
                    $end = Carbon::now()->addDay()->toDateString();  
                }else if($request->tipo == 2){
                    $start = Carbon::now()->startOfMonth()->toDateString();
                    $end = Carbon::now()->endOfMonth()->toDateString();  
                }else if($request->tipo == 3){
                    $start = Carbon::now()->startOfMonth()->subMonth()->toDateString();
                    $end = Carbon::now()->endOfMonth()->subMonth()->toDateString();  
                }

                $query->whereBetween('alumnos.deleted_at', [$start,$end]);
            }
        }

        $eliminados = $query->get();

        return response()->json(
            [
                'eliminados'         => $eliminados,
                'mensaje'           => '¡Excelente! El reporte se ha generado satisfactoriamente'

            ]);

    }

    public function Clientes(){

        $clases_grupales = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('clases_grupales.id',
                         'clases_grupales.hora_inicio',
                         'clases_grupales.hora_final',
                         'clases_grupales.fecha_inicio',
                         'config_clases_grupales.nombre',
                         'instructores.nombre as instructor_nombre',
                         'instructores.apellido as instructor_apellido')
                ->where('clases_grupales.academia_id','=',Auth::user()->academia_id)
                ->orderBy('clases_grupales.hora_inicio', 'asc')
        ->get();

        $array = array();

        foreach($clases_grupales as $clase){

            $fecha = Carbon::createFromFormat('Y-m-d', $clase->fecha_inicio);
          
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

            $collection=collect($clase);     
            $clase_array = $collection->toArray();
                
            $clase_array['dia']=$dia;
            $array[$clase->id] = $clase_array;
        }

        $tipologias = Tipologia::all();

        return view('reportes.clientes')->with(['clases_grupales' => $array, 'tipologias' => $tipologias]);
    }

    public function ClientesFiltros(Request $request)
    {

        $query = Alumno::join('tipologias','alumnos.tipologia_id','=','tipologias.id')
        ->select('alumnos.*','tipologias.nombre as tipologia')
        ->where('alumnos.academia_id','=', Auth::user()->academia_id)
        ->whereNotNull('alumnos.tipologia_id');

        if($request->tipologia_id)
        {
            $query->where('tipologia_id','=', $request->tipologia_id);
        }

        if($request->boolean_fecha){
            $fecha = explode(' - ', $request->fecha2);
            $start = Carbon::createFromFormat('d/m/Y',$fecha2[0])->toDateString();
            $end = Carbon::createFromFormat('d/m/Y',$fecha2[1])->toDateString();
            $query->whereBetween('alumnos.updated_at', [$start,$end]);
        }else{

            if($request->fecha){
                if($request->fecha == 1){
                    $start = Carbon::now()->toDateString();
                    $end = Carbon::now()->addDay()->toDateString();  
                }else if($request->fecha == 2){
                    $start = Carbon::now()->startOfMonth()->toDateString();
                    $end = Carbon::now()->endOfMonth()->toDateString();  
                }else if($request->fecha == 3){
                    $start = Carbon::now()->startOfMonth()->subMonth()->toDateString();
                    $end = Carbon::now()->endOfMonth()->subMonth()->toDateString();  
                }

                $query->whereBetween('alumnos.updated_at', [$start,$end]);
            }
        }

        if($request->clase_grupal_id)
        {
            $query->join('inscripcion_clase_grupal','inscripcion_clase_grupal.alumno_id','=','alumnos.id')
                ->where('inscripcion_clase_grupal.clase_grupal_id','=', $request->clase_grupal_id);
        }

            
        $clientes = $query->get();

        $array = array();

        $mujeres = 0;
        $hombres = 0;
        $array_tipologia = array();

        $tipologias = Tipologia::all();

        foreach($tipologias as $tipologia){
            $array_tipologia[$tipologia->id] = ['nombre' => $tipologia->nombre, 'cantidad' => 0];

        }

        foreach($clientes as $cliente){

            $array_tipologia[$cliente->tipologia_id]['cantidad']++;
            
            if($cliente->sexo == 'F'){
                $mujeres++;
            }else{
                $hombres++;
            }

            $collection=collect($cliente);     
            $cliente_array = $collection->toArray();  
            $array[$cliente->id] = $cliente_array;

        }

        $array_sexo = array();
        $tipologias = array();
        $array_tmp = array();

        foreach($array_tipologia as $tipologia){
            $array_tmp[] = array($tipologia['nombre'],$tipologia['cantidad']);
        }

        foreach($array_tmp as $tmp){
            array_push($tipologias, $tmp);
        }

        // $array_hombres = array('M', $hombres);
        // $array_mujeres = array('F', $mujeres);

        // array_push($array_sexo, $array_hombres);
        // array_push($array_sexo, $array_mujeres);   

        return response()->json(
            [
                'clientes'          => $array,
                'mujeres'           => $mujeres,
                'hombres'           => $hombres,
                'tipologias'        => $tipologias,
                'mensaje'           => '¡Excelente! El reporte se ha generado satisfactoriamente'

            ]);

    }

}