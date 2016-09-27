<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Alumno;
use App\Instructor;
use App\InscripcionTaller;
use App\InscripcionClaseGrupal;
use App\InscripcionCoreografia;
use App\ClasePersonalizada;
use App\ItemsFacturaProforma;
use App\Academia;
use App\Visitante;
use App\Asistencia;
use Mail;
use DB;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;

class ReporteController extends BaseController
{

    /**
        *   Reportes Alumnos Inscritos
        *   Reportes ALumnos Inscritos con Filtros
        *
    */    
	public function Inscritos(){

		$inscritos = DB::table('inscripcion_clase_grupal')
			->join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
            ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->select('alumnos.nombre', 'alumnos.apellido', 'alumnos.sexo', 'alumnos.fecha_nacimiento','inscripcion_clase_grupal.fecha_inscripcion as fecha', 'config_especialidades.nombre as especialidad', 'config_clases_grupales.nombre as curso', 'inscripcion_clase_grupal.id', 'alumnos.celular')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
        ->get();

        $sexo = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
            ->selectRaw('sexo, count(sexo) as CantSex')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
            ->groupBy('alumnos.sexo')
            ->get();

        $total = InscripcionClaseGrupal::count();

        $mujeres = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.*')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
            ->where('alumnos.sexo','=', 'F')
        ->count();

        $hombres = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.*')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
            ->where('alumnos.sexo','=', 'M')
        ->count();

        $forAge = DB::select('SELECT CASE
                            WHEN age BETWEEN 3 and 10 THEN "3 - 10"
                            WHEN age BETWEEN 11 and 20 THEN "11 - 20"
                            WHEN age BETWEEN 21 and 35 THEN "21 - 35"
                            WHEN age BETWEEN 36 and 50 THEN "36 - 50"
                            WHEN age >= 51 THEN "+51"
                            WHEN age IS NULL THEN "Sin fecha (NULL)"
                        END as age_range, COUNT(*) AS count
                        FROM (SELECT TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS age
                        FROM inscripcion_clase_grupal
                        INNER JOIN  alumnos ON alumno_id=alumnos.id)  as alumnos
                        GROUP BY age_range
                        ORDER BY age_range');       

        return view('reportes.inscritos')->with(['inscritos' => $inscritos, 'sexos' => $sexo, 'mujeres' => $mujeres, 'hombres' => $hombres, 'edades' => $forAge]);
	}

    public function InscritosFiltros(Request $request)
    {
        # code...
        //dd($request->all());
        if($request->mesActual){
            $start = Carbon::now()->startOfMonth()->toDateString();
            $end = Carbon::now()->endOfMonth()->toDateString();  
        }
        if($request->mesPasado){
            $start = Carbon::now()->startOfMonth()->subMonth()->toDateString();
            $end = Carbon::now()->subMonth()->endOfMonth()->toDateString();  

        }
        if($request->today){
            $start = Carbon::now()->toDateString();
            $end = Carbon::now()->toDateString();  
        }
        if($request->rango){
            //$fechas = explode(' - ', $request->dateRange);
            $start = Carbon::createFromFormat('d/m/Y',$request->fechaInicio)->toDateString();
            $end = Carbon::createFromFormat('d/m/Y',$request->fechaFin)->toDateString();
        }

        $inscritos = DB::table('inscripcion_clase_grupal')
            ->join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
            ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->select('alumnos.nombre', 'alumnos.apellido', 'alumnos.sexo', 'alumnos.fecha_nacimiento','inscripcion_clase_grupal.fecha_inscripcion as fecha', 'config_especialidades.nombre as especialidad', 'config_clases_grupales.nombre as curso', 'inscripcion_clase_grupal.id', 'alumnos.celular')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
            ->whereBetween('inscripcion_clase_grupal.fecha_inscripcion', [$start,$end])
            
        ->get();

        $sexo = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
            ->selectRaw('sexo, count(sexo) as CantSex')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
            ->whereBetween('inscripcion_clase_grupal.fecha_inscripcion', [$start,$end])
            ->groupBy('alumnos.sexo')
            ->get();

        $mujeres = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')->whereBetween('inscripcion_clase_grupal.fecha_inscripcion', [$start,$end])->where('alumnos.sexo','F')->count();

        $hombres = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')->whereBetween('inscripcion_clase_grupal.fecha_inscripcion', [$start,$end])->where('alumnos.sexo','M')->count();

        $forAge = DB::select("SELECT CASE
                            WHEN age BETWEEN 3 and 10 THEN '3 - 10'
                            WHEN age BETWEEN 11 and 20 THEN '11 - 20'
                            WHEN age BETWEEN 21 and 35 THEN '21 - 35'
                            WHEN age BETWEEN 36 and 50 THEN '36 - 50'
                            WHEN age >= 51 THEN '+51'
                            WHEN age IS NULL THEN 'Sin fecha (NULL)'
                        END as age_range, COUNT(*) AS count
                        FROM (SELECT TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS age
                        FROM inscripcion_clase_grupal
                        INNER JOIN  alumnos ON alumno_id=alumnos.id
                        WHERE inscripcion_clase_grupal.fecha_inscripcion >= '".$start."' AND inscripcion_clase_grupal.fecha_inscripcion <= '".$end."')  as alumnos
                        GROUP BY age_range
                        ORDER BY age_range");            
        
        return response()->json(
            [
                'inscritos'         => $inscritos,
                'sexos'             => $sexo,
                'mujeres'           => $mujeres,
                'hombres'           => $hombres,
                'edades'            => $forAge
            ]);

    }

    /**
        *   Reportes Visitas Presenciales
        *   Reportes Visitas Presenciales con Filtros
        *
    */    
	public function Presenciales(){

		$presenciales = DB::table('visitantes_presenciales')
            ->Leftjoin('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
            ->select('visitantes_presenciales.nombre', 'visitantes_presenciales.apellido', 'visitantes_presenciales.fecha_registro as fecha', 'config_especialidades.nombre as especialidad', 'visitantes_presenciales.celular', 'visitantes_presenciales.id')
            ->where('visitantes_presenciales.academia_id','=', Auth::user()->academia_id)
        ->get();


        $sexo = Visitante::Leftjoin('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
            ->selectRaw('sexo, count(sexo) as CantSex')
            ->where('visitantes_presenciales.academia_id','=', Auth::user()->academia_id)
            ->groupBy('visitantes_presenciales.sexo')
            ->get();
        //dd($sexo);
        $total = Visitante::count();

        $forAge = DB::select('SELECT CASE
                            WHEN age BETWEEN 3 and 10 THEN "3 - 10"
                            WHEN age BETWEEN 11 and 20 THEN "11 - 20"
                            WHEN age BETWEEN 21 and 35 THEN "21 - 35"
                            WHEN age BETWEEN 36 and 50 THEN "36 - 50"
                            WHEN age >= 51 THEN "+51"
                            WHEN age IS NULL THEN "Sin fecha (NULL)"
                        END as age_range, COUNT(*) AS count
                        FROM (SELECT TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS age
                        FROM visitantes_presenciales
                        LEFT JOIN  config_especialidades ON visitantes_presenciales.especialidad_id=config_especialidades.id)  as visitantes
                        GROUP BY age_range
                        ORDER BY age_range');

        return view('reportes.presenciales')->with(['presenciales' => $presenciales, 'sexos' => $sexo, 'total_visitantes' => $total, 'edades' => $forAge]);
	}


public function PresencialesFiltros(Request $request)
    {
        # code...
        if($request->mesActual){
            $start = Carbon::now()->startOfMonth()->toDateString();
            $end = Carbon::now()->endOfMonth()->toDateString();  
        }
        if($request->mesPasado){
            $start = Carbon::now()->startOfMonth()->subMonth()->toDateString();
            $end = Carbon::now()->subMonth()->endOfMonth()->toDateString();  

        }
        if($request->today){
            $start = Carbon::now()->toDateString();
            $end = Carbon::now()->toDateString();  

        }
        if($request->rango){
            $start = Carbon::createFromFormat('d/m/Y',$request->fechaInicio)->toDateString();
            $end = Carbon::createFromFormat('d/m/Y',$request->fechaFin)->toDateString();
        }

        $presenciales = DB::table('visitantes_presenciales')
            ->Leftjoin('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
            ->select('visitantes_presenciales.nombre', 'visitantes_presenciales.apellido', 'visitantes_presenciales.fecha_registro as fecha', 'config_especialidades.nombre as especialidad', 'visitantes_presenciales.celular', 'visitantes_presenciales.id')
            ->where('visitantes_presenciales.academia_id','=', Auth::user()->academia_id)
            ->whereBetween('visitantes_presenciales.fecha_registro', [$start,$end])
        ->get();

        $sexo = Visitante::Leftjoin('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
            ->selectRaw('sexo, count(sexo) as CantSex')
            ->where('visitantes_presenciales.academia_id','=', Auth::user()->academia_id)
            ->whereBetween('visitantes_presenciales.fecha_registro', [$start,$end])
            ->groupBy('visitantes_presenciales.sexo')
            ->get();

        
        $total = Visitante::whereBetween('visitantes_presenciales.fecha_registro', [$start,$end])->count();

        $forAge = DB::select("SELECT CASE
                            WHEN age BETWEEN 3 and 10 THEN '3 - 10'
                            WHEN age BETWEEN 11 and 20 THEN '11 - 20'
                            WHEN age BETWEEN 21 and 35 THEN '21 - 35'
                            WHEN age BETWEEN 36 and 50 THEN '36 - 50'
                            WHEN age >= 51 THEN '+51'
                            WHEN age IS NULL THEN 'Sin fecha (NULL)'
                        END as age_range, COUNT(*) AS count
                        FROM (SELECT TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS age
                        FROM visitantes_presenciales
                        LEFT JOIN  config_especialidades ON visitantes_presenciales.especialidad_id=config_especialidades.id
                        WHERE visitantes_presenciales.fecha_registro >= '".$start."' AND visitantes_presenciales.fecha_registro <= '".$end."')  as visitantes
                        GROUP BY age_range
                        ORDER BY age_range");

        return response()->json(
            [
                'presenciales'      => $presenciales,
                'sexos'             => $sexo,
                'total_visitantes'  => $total,
                'edades'            => $forAge
            ]);

    }


    /**
        *   Reportes Visitas Presenciales
        *   Reportes Visitas Presenciales con Filtros
        *
    */    
	public function Contactos(){

		$alumnos = DB::table('alumnos')
            ->select('alumnos.nombre', 'alumnos.apellido', 'alumnos.correo',  'alumnos.telefono', 'alumnos.celular', 'alumnos.id')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
        ->get();

        return view('reportes.contactos')->with('alumnoscontacto', $alumnos);
	}

    public function asistencias()
    {
        $clase_grupal_join = DB::table('clases_grupales')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->select('config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.id as instructor_id','clases_grupales.id as clase_grupal_id' , 'clases_grupales.fecha_inicio as fecha_inicio')
            ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
            ->where('clases_grupales.deleted_at', '=', null)
        ->get();

        $sexo = Asistencia::join('alumnos', 'asistencias.alumno_id', '=', 'alumnos.id')
            ->selectRaw('sexo, count(sexo) as CantSex')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
            ->groupBy('alumnos.sexo')
        ->get();

        $asistencias = DB::table('asistencias')
                ->join('clases_grupales', 'asistencias.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->join('alumnos', 'asistencias.alumno_id', '=', 'alumnos.id')
                ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'alumnos.sexo as sexo', 'alumnos.fecha_nacimiento as fecha_nacimiento', 'alumnos.sexo as sexo', 'alumnos.telefono as telefono', 'alumnos.celular as celular', 'asistencias.fecha as fecha', 'asistencias.hora as hora', 'alumnos.id as alumno_id', 'alumnos.identificacion as identificacion', 'asistencias.clase_grupal_id', 'asistencias.id')
                ->where('alumnos.academia_id','=', Auth::user()->academia_id)
        ->get();

        $alumnod = DB::table('alumnos')
            ->join('items_factura_proforma', 'items_factura_proforma.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.id as id', 'items_factura_proforma.importe_neto', 'items_factura_proforma.fecha_vencimiento')
            ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
            ->where('alumnos.deleted_at', '=', null)
        ->get();

        $collection=collect($alumnod);
        $grouped = $collection->groupBy('id');     
        $deuda = $grouped->toArray();
      
        $array = array();

        $mujeres = Asistencia::join('alumnos', 'asistencias.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.*')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
            ->where('alumnos.sexo','=', 'F')
        ->count();

        $hombres = Asistencia::join('alumnos', 'asistencias.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.*')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
            ->where('alumnos.sexo','=', 'M')
        ->count();



        foreach($clase_grupal_join as $clase_grupal){
            $fecha_inicio = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
            $dia = $fecha_inicio->dayOfWeek;   

            $collection=collect($clase_grupal);     
            $clase_array = $collection->toArray();
                
            $clase_array['dia']=$dia;
            $array[$clase_grupal->clase_grupal_id] = $clase_array;
        }

        //dd($asistencia);
        return view('reportes.asistencias')->with(['clases_grupales' => $array, 'sexos' => $sexo, 'asistencias' => $asistencias, 'deuda' => $deuda, 'hombres' => $hombres, 'mujeres' => $mujeres]);
    }

    public function charts()
    {
        return view('reportes.procesos_inscripcion');
    }

    public function filtrarAsistencias(Request $request)
    {
        $rules = [

            'participante_id' => 'required',
            'fecha' => 'required',
            'clase_grupal_id' => 'required',
            'instructor_id' => 'required',
        ];

        $messages = [

            'participante_id.required' => 'Ups! Tiene que seleccionar una opción',
            'fecha.required' => 'Ups! La fecha es requerida',
            'clase_grupal_id.required' => 'Ups! La Clase Grupal es requerida',
            'instructor_id.required' => 'Ups! El instructor es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);

            if($fecha > Carbon::now()){
                return response()->json(['errores' => ['linea' => [0, 'Ups! Esta fecha es invalida, debes ingresar una fecha menor al dia de hoy']], 'status' => 'ERROR'],422);
            }

            $fecha = $fecha->toDateString();

            $asistencias = DB::table('asistencias')
                ->join('clases_grupales', 'asistencias.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->join('alumnos', 'asistencias.alumno_id', '=', 'alumnos.id')
                ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'alumnos.sexo as sexo', 'alumnos.fecha_nacimiento as fecha_nacimiento', 'alumnos.sexo as sexo', 'alumnos.telefono as telefono', 'alumnos.celular as celular', 'asistencias.fecha as fecha', 'asistencias.hora as hora', 'alumnos.id as alumno_id', 'alumnos.identificacion as identificacion', 'asistencias.clase_grupal_id', 'asistencias.id')
                ->where('clases_grupales.id', '=', $request->clase_grupal_id)
                // ->where('instructores.id', '=', $request->instructor_id)
                ->where('asistencias.fecha', '=', $fecha)
            ->get();

            $inscripciones = DB::table('inscripcion_clase_grupal')
                ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
                ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'alumnos.sexo as sexo', 'alumnos.fecha_nacimiento as fecha_nacimiento', 'alumnos.sexo as sexo', 'alumnos.telefono as telefono', 'alumnos.celular as celular', 'alumnos.id as alumno_id', 'clases_grupales.id as clase_grupal_id', 'alumnos.identificacion as identificacion', 'inscripcion_clase_grupal.id')
                ->where('clases_grupales.id', '=', $request->clase_grupal_id)
            ->get();

            $mujeres = 0;
            $hombres = 0;
            $total = 0;
            $array_sexo = array();

            if($request->participante_id == 1){

                $array = array();

                foreach($asistencias as $asistencia){

                    $pertenece = DB::table('inscripcion_clase_grupal')
                        ->select('inscripcion_clase_grupal.*')
                        ->where('inscripcion_clase_grupal.clase_grupal_id', '=', $asistencia->clase_grupal_id)
                        ->where('inscripcion_clase_grupal.alumno_id', '=', $asistencia->alumno_id)
                    ->first();

                    $deuda = DB::table('items_factura_proforma')
                        ->select('items_factura_proforma.*')
                        ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
                        ->where('items_factura_proforma.alumno_id', $asistencia->alumno_id)
                    ->first();

                    if($pertenece){
                        $pertenece = '<i class="zmdi c-verde zmdi-check zmdi-hc-fw"></i>';
                    }else{
                        $pertenece = '<i class="zmdi c-amarillo zmdi-dot-circle zmdi-hc-fw"></i>';
                    }

                    if($deuda){
                        $deuda = '<i class="zmdi zmdi-money c-youtube zmdi-hc-fw f-20"></i>';
                    }else{
                        $deuda = '<i class="zmdi zmdi-money c-verde zmdi-hc-fw f-20"></i>';
                    }

                    $collection=collect($asistencia);     
                    $asistencia_array = $collection->toArray();
                    $asistencia_array['pertenece']=$pertenece;
                    $asistencia_array['deuda']=$deuda;
                    $array[$asistencia->id] = $asistencia_array;

                    if($asistencia->sexo == 'F'){
                        $mujeres = $mujeres + 1;
                    }else{
                        $hombres = $hombres + 1;
                    }

                    
                }

                $array_hombres = array('M', $hombres);
                $array_mujeres = array('F', $mujeres);

                array_push($array_sexo, $array_hombres);
                array_push($array_sexo, $array_mujeres);

                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'tipo' => $request->participante_id, 'sexos' => $array_sexo, 'mujeres' => $mujeres, 'hombres' => $hombres, 200]);

            }else{

                $inasistencias = array();

                foreach($inscripciones as $inscripcion){

                    $asistio = 0;

                    foreach($asistencias as $asistencia){
                        if($asistencia->alumno_id == $inscripcion->alumno_id){
                            $asistio = 1;
                        }
                    }

                    if($asistio == 0)
                    {
                        $pertenece = DB::table('inscripcion_clase_grupal')
                            ->select('inscripcion_clase_grupal.*')
                            ->where('inscripcion_clase_grupal.clase_grupal_id', '=', $inscripcion->clase_grupal_id)
                            ->where('inscripcion_clase_grupal.alumno_id', '=', $inscripcion->alumno_id)
                        ->first();

                        if($pertenece){

                            $pertenece = '';

                            $deuda = DB::table('items_factura_proforma')
                                ->select('items_factura_proforma.*')
                                ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
                                ->where('items_factura_proforma.alumno_id', $inscripcion->alumno_id)
                            ->first();


                            if($deuda){
                                $deuda = '<i class="zmdi zmdi-money c-youtube zmdi-hc-fw f-20"></i>';
                            }else{
                                $deuda = '<i class="zmdi zmdi-money c-verde zmdi-hc-fw f-20"></i>';
                            }

                            $collection=collect($inscripcion);     
                            $inasistencias_array = $collection->toArray();
                            $inasistencias_array['pertenece']=$pertenece;
                            $inasistencias_array['deuda']=$deuda;
                            $inasistencias[$inscripcion->id] = $inasistencias_array;

                            if($inscripcion->sexo == 'F'){
                                $mujeres = $mujeres + 1;
                            }else{
                                $hombres = $hombres + 1;
                            }
                            

                        }


                    }               

                }

                $array_hombres = array('M', $hombres);
                $array_mujeres = array('F', $mujeres);

                array_push($array_sexo, $array_hombres);
                array_push($array_sexo, $array_mujeres);

                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $inasistencias, 'tipo' => $request->participante_id, 'sexos' => $array_sexo, 'mujeres' => $mujeres, 'hombres' => $hombres, 200]);
            }

        }
    }

}