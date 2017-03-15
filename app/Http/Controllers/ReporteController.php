<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Alumno;
use App\ClaseGrupal;
use App\Examen;
use App\Instructor;
use App\Staff;
use App\InscripcionTaller;
use App\InscripcionClaseGrupal;
use App\InscripcionCoreografia;
use App\ClasePersonalizada;
use App\ItemsFacturaProforma;
use App\Academia;
use App\Visitante;
use App\Asistencia;
use App\ConfigTipoExamen;
use App\ConfigServicios;
use App\ComoNosConociste;
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

        $inscritos = DB::table('alumnos')
            ->join('evaluaciones', 'evaluaciones.alumno_id', '=', 'alumnos.id')
            ->join('examenes', 'evaluaciones.examen_id', '=', 'examenes.id')
            ->join('clases_grupales', 'examenes.clase_grupal_id', '=', 'clases_grupales.id')
            ->select('alumnos.nombre', 'alumnos.apellido', 'alumnos.sexo', 'alumnos.fecha_nacimiento', 'alumnos.celular', 'evaluaciones.id as evaluacion_id', 'alumnos.id', 'examenes.nombre as valoracion')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
            ->where('examenes.boolean_grupal','=',1)
        ->get();

        $sexo = Alumno::Leftjoin('evaluaciones', 'evaluaciones.alumno_id', '=', 'alumnos.id')
            ->join('examenes', 'evaluaciones.examen_id', '=', 'examenes.id')
            ->selectRaw('sexo, count(sexo) as CantSex')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
            ->groupBy('alumnos.sexo')
        ->get();

        // $total = DB::table('alumnos')
        //     ->Leftjoin('evaluaciones', 'evaluaciones.alumno_id', '=', 'alumnos.id')
        //     ->Leftjoin('examenes', 'evaluaciones.examen_id', '=', 'examenes.id')
        //     ->where('alumnos.academia_id','=', Auth::user()->academia_id)
        //     ->where('evaluaciones.id', '!=', null)
        // ->count();

        $mujeres = 0;
        $hombres = 0;
        $array = array();

        foreach($inscritos as $inscrito){

            $alumnoc = DB::table('users')
                ->join('alumnos', 'alumnos.id', '=', 'users.usuario_id')
                ->select('alumnos.id as id')
                ->where('alumnos.id','=', $inscrito->id)
                ->where('alumnos.deleted_at', '=', null)
                ->where('users.usuario_tipo', '=', 2)
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

        $clases_grupales= DB::table('clases_grupales')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_clases_grupales.nombre as nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido',  'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.fecha_inicio','clases_grupales.fecha_final', 'clases_grupales.id')
            ->where('clases_grupales.deleted_at', '=', null)
            ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
      ->get();

    $config_examenes = ConfigTipoExamen::all();
    $examenes = Examen::where('boolean_grupal',1)->where('academia_id', Auth::user()->academia_id)->get();

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

        return view('reportes.diagnostico')->with(['inscritos' => $array, 'sexos' => $sexo, 'mujeres' => $mujeres, 'hombres' => $hombres, 'edades' => $forAge, 'clases_grupales' => $clases_grupales, 'config_examenes' => $config_examenes, 'examenes' => $examenes]);
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

        foreach($inscritos as $inscrito){

            $alumnoc = DB::table('users')
                ->join('alumnos', 'alumnos.id', '=', 'users.usuario_id')
                ->select('alumnos.id as id')
                ->where('alumnos.id','=', $inscrito->id)
                ->where('alumnos.deleted_at', '=', null)
                ->where('users.usuario_tipo', '=', 2)
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

    // public function Diagnosticos(){

    //     $inscritos = DB::table('alumnos')
    //         ->Leftjoin('evaluaciones', 'evaluaciones.alumno_id', '=', 'alumnos.id')
    //         ->Leftjoin('examenes', 'evaluaciones.examen_id', '=', 'examenes.id')
    //         ->select('alumnos.nombre', 'alumnos.apellido', 'alumnos.sexo', 'alumnos.fecha_nacimiento', 'alumnos.celular', 'evaluaciones.id as evaluacion_id', 'alumnos.id')
    //         ->where('alumnos.academia_id','=', Auth::user()->academia_id)
    //     ->get();

    //     $sexo = Alumno::Leftjoin('evaluaciones', 'evaluaciones.alumno_id', '=', 'alumnos.id')
    //         ->Leftjoin('examenes', 'evaluaciones.examen_id', '=', 'examenes.id')
    //         ->selectRaw('sexo, count(sexo) as CantSex')
    //         ->where('alumnos.academia_id','=', Auth::user()->academia_id)
    //         ->groupBy('alumnos.sexo')
    //         ->get();

    //     $total = DB::table('alumnos')
    //         ->Leftjoin('evaluaciones', 'evaluaciones.alumno_id', '=', 'alumnos.id')
    //         ->Leftjoin('examenes', 'evaluaciones.examen_id', '=', 'examenes.id')
    //         ->where('alumnos.academia_id','=', Auth::user()->academia_id)
    //         ->where('evaluaciones.id', '!=', null)
    //     ->count();

    //     $mujeres = 0;
    //     $hombres = 0;

    //     foreach($inscritos as $inscrito){

    //         $alumnoc = DB::table('users')
    //             ->join('alumnos', 'alumnos.id', '=', 'users.usuario_id')
    //             ->select('alumnos.id as id')
    //             ->where('alumnos.id','=', $inscrito->id)
    //             ->where('alumnos.deleted_at', '=', null)
    //             ->where('users.usuario_tipo', '=', 2)
    //             ->where('users.confirmation_token', '!=', null)
    //         ->first();

    //         if($alumnoc){
    //             $activacion = 0;
    //         }else{
    //             $activacion = 1;
    //         }

    //         $collection=collect($inscrito); 
    //         $inscrito_array = $collection->toArray();
            
    //         $inscrito_array['activacion']=$activacion;
    //         $array[$inscrito->id] = $inscrito_array;

    //         if($inscrito->sexo == 'F'){
    //             $mujeres++;
    //         }else{
    //             $hombres++;
    //         }
    //     }

    //     $clases_grupales= DB::table('clases_grupales')
    //         ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
    //         ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
    //         ->select('config_clases_grupales.nombre as nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido',  'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.fecha_inicio','clases_grupales.fecha_final', 'clases_grupales.id')
    //         ->where('clases_grupales.deleted_at', '=', null)
    //         ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
    //   ->get();


    //     $forAge = DB::select('SELECT CASE
    //                         WHEN age BETWEEN 3 and 10 THEN "3 - 10"
    //                         WHEN age BETWEEN 11 and 20 THEN "11 - 20"
    //                         WHEN age BETWEEN 21 and 35 THEN "21 - 35"
    //                         WHEN age BETWEEN 36 and 50 THEN "36 - 50"
    //                         WHEN age >= 51 THEN "+51"
    //                         WHEN age IS NULL THEN "Sin fecha (NULL)"
    //                     END as age_range, COUNT(*) AS count
    //                     FROM (SELECT TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS age
    //                     FROM alumnos)  as alumnos
    //                     GROUP BY age_range
    //                     ORDER BY age_range');     

    //     return view('reportes.diagnostico')->with(['inscritos' => $array, 'sexos' => $sexo, 'mujeres' => $mujeres, 'hombres' => $hombres, 'edades' => $forAge, 'total' => $total, 'clases_grupales' => $clases_grupales]);
    // }

    // public function DiagnosticosFiltros(Request $request)
    // {
    //     $actual = Carbon::now();
    //     $geoip = new GeoIP();
    //     $geoip->setIp($request->ip());
    //     $actual->tz = $geoip->getTimezone();

    //     # code...
    //     //dd($request->all());
    //     if($request->mesActual){
    //         $start = $actual->startOfMonth()->toDateString();
    //         $end = $actual->endOfMonth()->toDateString();  
    //     }
    //     if($request->mesPasado){
    //         $start = $actual->startOfMonth()->subMonth()->toDateString();
    //         $end = $actual->subMonth()->endOfMonth()->toDateString();  

    //     }
    //     if($request->today){
    //         $end = $actual->toDateString();
    //         $start = $actual->subDay()->toDateString();
    //     }
    //     if($request->rango){
    //         //$fechas = explode(' - ', $request->dateRange);
    //         $start = Carbon::createFromFormat('d/m/Y',$request->fechaInicio)->toDateString();
    //         $end = Carbon::createFromFormat('d/m/Y',$request->fechaFin)->toDateString();
    //     }

    //     if($request->Fecha){
    //         $fechas = explode('-', $request->Fecha);
    //         $start = Carbon::createFromFormat('d/m/Y',$fechas[0])->toDateString();
    //         $end = Carbon::createFromFormat('d/m/Y',$fechas[1])->toDateString();
    //     }

    //     if($request->clase_grupal_id){

    //         $inscritos = DB::table('alumnos')
    //             ->join('evaluaciones', 'evaluaciones.alumno_id', '=', 'alumnos.id')
    //             ->join('examenes', 'evaluaciones.examen_id', '=', 'examenes.id')
    //             ->join('clases_grupales', 'examenes.clase_grupal_id', '=', 'clases_grupales.id')
    //             ->select('alumnos.nombre', 'alumnos.apellido', 'alumnos.sexo', 'alumnos.fecha_nacimiento', 'alumnos.celular', 'evaluaciones.id as evaluacion_id', 'alumnos.id')
    //             ->where('examenes.clase_grupal_id','=', $request->clase_grupal_id)
    //             ->where('alumnos.academia_id','=', Auth::user()->academia_id)
    //             ->where('examenes.boolean_grupal','=',1)
    //             ->whereBetween('evaluaciones.created_at', [$start,$end])
    //         ->get();


    //         $total = DB::table('alumnos')
    //             ->join('evaluaciones', 'evaluaciones.alumno_id', '=', 'alumnos.id')
    //             ->join('examenes', 'evaluaciones.examen_id', '=', 'examenes.id')
    //             ->join('clases_grupales', 'examenes.clase_grupal_id', '=', 'clases_grupales.id')
    //             ->where('examenes.clase_grupal_id','=', $request->clase_grupal_id)
    //             ->where('alumnos.academia_id','=', Auth::user()->academia_id)
    //             ->where('evaluaciones.id', '!=', null)
    //             ->where('examenes.boolean_grupal','=',1)
    //             ->whereBetween('evaluaciones.created_at', [$start,$end])
    //         ->count();


    //         $forAge = DB::select("SELECT CASE
    //                         WHEN age BETWEEN 3 and 10 THEN '3 - 10'
    //                         WHEN age BETWEEN 11 and 20 THEN '11 - 20'
    //                         WHEN age BETWEEN 21 and 35 THEN '21 - 35'
    //                         WHEN age BETWEEN 36 and 50 THEN '36 - 50'
    //                         WHEN age >= 51 THEN '+51'
    //                         WHEN age IS NULL THEN 'Sin fecha (NULL)'
    //                     END as age_range, COUNT(*) AS count
    //                     FROM (SELECT TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS age
    //                     FROM alumnos 
    //                     WHERE alumnos.created_at >= '".$start."' AND alumnos.created_at <= '".$end."' AND alumnos.academia_id = '".Auth::user()->academia_id."')  as alumnos
    //                     GROUP BY age_range
    //                     ORDER BY age_range");      
    //     }else{
    //         $inscritos = DB::table('alumnos')
    //             ->Leftjoin('evaluaciones', 'evaluaciones.alumno_id', '=', 'alumnos.id')
    //             ->Leftjoin('examenes', 'evaluaciones.examen_id', '=', 'examenes.id')
    //             ->select('alumnos.nombre', 'alumnos.apellido', 'alumnos.sexo', 'alumnos.fecha_nacimiento', 'alumnos.celular', 'evaluaciones.id as evaluacion_id', 'alumnos.id')
    //             ->where('alumnos.academia_id','=', Auth::user()->academia_id)
    //             ->whereBetween('alumnos.created_at', [$start,$end])
    //         ->get(); 

    //         $total = DB::table('alumnos')
    //             ->Leftjoin('evaluaciones', 'evaluaciones.alumno_id', '=', 'alumnos.id')
    //             ->Leftjoin('examenes', 'evaluaciones.examen_id', '=', 'examenes.id')
    //             ->where('alumnos.academia_id','=', Auth::user()->academia_id)
    //             ->where('evaluaciones.id', '!=', null)
    //             ->whereBetween('alumnos.created_at', [$start,$end])
    //         ->count();


    //         $forAge = DB::select("SELECT CASE
    //                         WHEN age BETWEEN 3 and 10 THEN '3 - 10'
    //                         WHEN age BETWEEN 11 and 20 THEN '11 - 20'
    //                         WHEN age BETWEEN 21 and 35 THEN '21 - 35'
    //                         WHEN age BETWEEN 36 and 50 THEN '36 - 50'
    //                         WHEN age >= 51 THEN '+51'
    //                         WHEN age IS NULL THEN 'Sin fecha (NULL)'
    //                     END as age_range, COUNT(*) AS count
    //                     FROM (SELECT TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS age
    //                     FROM alumnos 
    //                     WHERE alumnos.created_at >= '".$start."' AND alumnos.created_at <= '".$end."' AND alumnos.academia_id = '".Auth::user()->academia_id."')  as alumnos
    //                     GROUP BY age_range
    //                     ORDER BY age_range");      
    //     }

        

    //     // $sexo = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
    //     //     ->selectRaw('sexo, count(sexo) as CantSex')
    //     //     ->where('alumnos.academia_id','=', Auth::user()->academia_id)
    //     //     ->whereBetween('inscripcion_clase_grupal.fecha_inscripcion', [$start,$end])
    //     //     ->groupBy('alumnos.sexo')
    //     //     ->get();
    //     //     
    //     //     
        
    //     $array = array();
    //     $mujeres = 0;
    //     $hombres = 0;

    //     foreach($inscritos as $inscrito){

    //         $alumnoc = DB::table('users')
    //             ->join('alumnos', 'alumnos.id', '=', 'users.usuario_id')
    //             ->select('alumnos.id as id')
    //             ->where('alumnos.id','=', $inscrito->id)
    //             ->where('alumnos.deleted_at', '=', null)
    //             ->where('users.usuario_tipo', '=', 2)
    //             ->where('users.confirmation_token', '!=', null)
    //         ->first();

    //         if($alumnoc){
    //             $activacion = 0;
    //         }else{
    //             $activacion = 1;
    //         }

    //         $collection=collect($inscrito); 
    //         $inscrito_array = $collection->toArray();
            
    //         $inscrito_array['activacion']=$activacion;
    //         $array[$inscrito->id] = $inscrito_array;

    //         if($inscrito->sexo == 'F'){
    //             $mujeres++;
    //         }else{
    //             $hombres++;
    //         }
    //     }      
        
    //     return response()->json(
    //         [
    //             'inscritos'         => $array,
    //             'mujeres'           => $mujeres,
    //             'hombres'           => $hombres,
    //             'edades'            => $forAge,
    //             'total'             => $total
    //         ]);

    // }

	public function Inscritos(){

		$inscritos = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
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

    // public function InscritosFiltros(Request $request)
    // {

    //     if($request->mesActual){
    //         $start = Carbon::now()->startOfMonth()->toDateString();
    //         $end = Carbon::now()->endOfMonth()->toDateString();  
    //     }
    //     if($request->mesPasado){
    //         $start = Carbon::now()->startOfMonth()->subMonth()->toDateString();
    //         $end = Carbon::now()->subMonth()->endOfMonth()->toDateString();  

    //     }
    //     if($request->today){
    //         $start = Carbon::now()->toDateString();
    //         $end = Carbon::now()->toDateString();  
    //     }
    //     if($request->rango){
    //         //$fechas = explode(' - ', $request->dateRange);
    //         $start = Carbon::createFromFormat('d/m/Y',$request->fechaInicio)->toDateString();
    //         $end = Carbon::createFromFormat('d/m/Y',$request->fechaFin)->toDateString();
    //     }

    //     if($request->Fecha){
    //         $fechas = explode('-', $request->Fecha);
    //         $start = Carbon::createFromFormat('d/m/Y',$fechas[0])->toDateString();
    //         $end = Carbon::createFromFormat('d/m/Y',$fechas[1])->toDateString();
    //     }

    //     $inscritos = DB::table('inscripcion_clase_grupal')
    //         ->join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
    //         ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
    //         ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
    //         ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
    //         ->select('alumnos.nombre', 'alumnos.apellido', 'alumnos.sexo', 'alumnos.fecha_nacimiento','inscripcion_clase_grupal.fecha_inscripcion as fecha', 'config_especialidades.nombre as especialidad', 'config_clases_grupales.nombre as curso', 'inscripcion_clase_grupal.id', 'alumnos.celular')
    //         ->where('alumnos.academia_id','=', Auth::user()->academia_id)
    //         ->whereBetween('inscripcion_clase_grupal.fecha_inscripcion', [$start,$end])
    //     ->get();

    //     // $sexo = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
    //     //     ->selectRaw('sexo, count(sexo) as CantSex')
    //     //     ->where('alumnos.academia_id','=', Auth::user()->academia_id)
    //     //     ->whereBetween('inscripcion_clase_grupal.fecha_inscripcion', [$start,$end])
    //     //     ->groupBy('alumnos.sexo')
    //     //     ->get();

    //     $mujeres = 0;
    //     $hombres = 0;

    //     foreach($inscritos as $inscrito){
    //         if($inscrito->sexo == 'F'){
    //             $mujeres++;
    //         }else{
    //             $hombres++;
    //         }
    //     }

    //     $forAge = DB::select("SELECT CASE
    //                         WHEN age BETWEEN 3 and 10 THEN '3 - 10'
    //                         WHEN age BETWEEN 11 and 20 THEN '11 - 20'
    //                         WHEN age BETWEEN 21 and 35 THEN '21 - 35'
    //                         WHEN age BETWEEN 36 and 50 THEN '36 - 50'
    //                         WHEN age >= 51 THEN '+51'
    //                         WHEN age IS NULL THEN 'Sin fecha (NULL)'
    //                     END as age_range, COUNT(*) AS count
    //                     FROM (SELECT TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS age
    //                     FROM inscripcion_clase_grupal
    //                     INNER JOIN  alumnos ON alumno_id=alumnos.id
    //                     WHERE inscripcion_clase_grupal.fecha_inscripcion >= '".$start."' AND inscripcion_clase_grupal.fecha_inscripcion <= '".$end."' AND alumnos.academia_id = '".Auth::user()->academia_id."')  as alumnos
    //                     GROUP BY age_range
    //                     ORDER BY age_range");            
        
    //     return response()->json(
    //         [
    //             'inscritos'         => $inscritos,
    //             'mujeres'           => $mujeres,
    //             'hombres'           => $hombres,
    //             'edades'            => $forAge
    //         ]);

    // }

    public function InscritosFiltros(Request $request)
    {


        $query = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
            ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->select('alumnos.nombre', 'alumnos.apellido', 'alumnos.sexo', 'alumnos.fecha_nacimiento','inscripcion_clase_grupal.fecha_inscripcion as fecha', 'config_especialidades.nombre as especialidad', 'config_clases_grupales.nombre as curso', 'inscripcion_clase_grupal.id', 'alumnos.celular')
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
                    $end = Carbon::now()->toDateString();  
                }else if($request->tipo == 2){
                    $start = Carbon::now()->startOfMonth()->toDateString();
                    $end = Carbon::now()->endOfMonth()->toDateString();  
                }else if($request->tipo == 3){
                    $start = Carbon::now()->startOfMonth()->subMonth()->toDateString();
                    $end = Carbon::now()->subMonth()->endOfMonth()->toDateString();  
                }

                $query->whereBetween('inscripcion_clase_grupal.fecha_inscripcion', [$start,$end]);
            }
        }

            
        $inscritos = $query->get();

        $array = array();

        $total = 0;
        $mujeres = 0;
        $hombres = 0;

        foreach($inscritos as $inscrito){

            if($inscrito->sexo == 'F'){
                $mujeres++;
            }else{
                $hombres++;
            }

            if($request->edad_inicio OR $request->edad_final)
            {
                $edad = Carbon::createFromFormat('Y-m-d', $inscrito->fecha_nacimiento)->diff(Carbon::now())->format('%y');

                if($request->edad_inicio && $request->edad_final){
                    if($edad >= $request->edad_inicio && $edad <= $request->edad_final){
                        $collection=collect($inscrito);     
                        $inscrito_array = $collection->toArray();   
                        $array[$inscrito->id] = $inscrito_array;
                    }
                }else if($request->edad_inicio){
                   if($edad >= $request->edad_inicio){
                        $collection=collect($inscrito);     
                        $inscrito_array = $collection->toArray();   
                        $array[$inscrito->id] = $inscrito_array;
                    } 
                }else if($request->edad_final){
                    if($edad <= $request->edad_inicio){
                        $collection=collect($inscrito);     
                        $inscrito_array = $collection->toArray();   
                        $array[$inscrito->id] = $inscrito_array;
                    }
                }

            }else{
                $collection=collect($inscrito);     
                $inscrito_array = $collection->toArray();   
                $array[$inscrito->id] = $inscrito_array;
            }
            
        }

        $array_sexo = array();

        $array_hombres = array('M', $hombres);
        $array_mujeres = array('F', $mujeres);

        array_push($array_sexo, $array_hombres);
        array_push($array_sexo, $array_mujeres);   

        return response()->json(
            [
                'inscritos'         => $array,
                'mujeres'           => $mujeres,
                'hombres'           => $hombres,
                'total'             => $total,
                'sexos'             => $array_sexo,
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

		$presenciales = DB::table('visitantes_presenciales')
            ->Leftjoin('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
            ->select('visitantes_presenciales.nombre', 'visitantes_presenciales.apellido', 'visitantes_presenciales.fecha_registro as fecha', 'config_especialidades.nombre as especialidad', 'visitantes_presenciales.celular', 'visitantes_presenciales.id','visitantes_presenciales.cliente')
            ->where('visitantes_presenciales.academia_id','=', Auth::user()->academia_id)
        ->get();

        $total = DB::table('visitantes_presenciales')
            ->where('visitantes_presenciales.academia_id','=', Auth::user()->academia_id)
            ->where('visitantes_presenciales.cliente','=', 1)
        ->count();


        $sexo = Visitante::Leftjoin('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
            ->selectRaw('sexo, count(sexo) as CantSex')
            ->where('visitantes_presenciales.academia_id','=', Auth::user()->academia_id)
            ->groupBy('visitantes_presenciales.sexo')
            ->get();

        $mujeres = Visitante::where('sexo', 'F')->where('academia_id',Auth::user()->academia_id)->count();
        $hombres = Visitante::where('sexo', 'M')->where('academia_id',Auth::user()->academia_id)->count();

        $promotores = Staff::where('cargo',1)->where('academia_id', Auth::user()->academia_id)->get();

        $como_nos_conociste = ComoNosConociste::all();
                        

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

        return view('reportes.presenciales')->with(['presenciales' => $presenciales, 'sexos' => $sexo, 'mujeres' => $mujeres, 'hombres' => $hombres, 'edades' => $forAge, 'total' => $total, 'promotores' => $promotores, 'como_nos_conociste' => $como_nos_conociste]);
	}

public function PresencialesFiltros(Request $request)
    {

        // if($request->mesActual){
        //     $start = Carbon::now()->startOfMonth()->toDateString();
        //     $end = Carbon::now()->endOfMonth()->toDateString();  
        // }
        // if($request->mesPasado){
        //     $start = Carbon::now()->startOfMonth()->subMonth()->toDateString();
        //     $end = Carbon::now()->subMonth()->endOfMonth()->toDateString();  

        // }
        // if($request->today){
        //     $start = Carbon::now()->toDateString();
        //     $end = Carbon::now()->toDateString();  

        // }
        // if($request->rango){
        //     $start = Carbon::createFromFormat('d/m/Y',$request->fechaInicio)->toDateString();
        //     $end = Carbon::createFromFormat('d/m/Y',$request->fechaFin)->toDateString();
        // }

        // if($request->Fecha){
        //     $fechas = explode('-', $request->Fecha);
        //     $start = Carbon::createFromFormat('d/m/Y',$fechas[0])->toDateString();
        //     $end = Carbon::createFromFormat('d/m/Y',$fechas[1])->toDateString();
        // }

        // $presenciales = DB::table('visitantes_presenciales')
        //     ->Leftjoin('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
        //     ->select('visitantes_presenciales.nombre', 'visitantes_presenciales.apellido', 'visitantes_presenciales.fecha_registro as fecha', 'config_especialidades.nombre as especialidad', 'visitantes_presenciales.celular', 'visitantes_presenciales.id', 'visitantes_presenciales.sexo', 'visitantes_presenciales.cliente')
        //     ->where('visitantes_presenciales.academia_id','=', Auth::user()->academia_id)
        //     ->whereBetween('visitantes_presenciales.fecha_registro', [$start,$end])
        // ->get();

        $query = DB::table('visitantes_presenciales')
            ->Leftjoin('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
            ->select('visitantes_presenciales.nombre', 'visitantes_presenciales.apellido', 'visitantes_presenciales.fecha_registro as fecha', 'config_especialidades.nombre as especialidad', 'visitantes_presenciales.celular', 'visitantes_presenciales.id', 'visitantes_presenciales.sexo', 'visitantes_presenciales.cliente', 'visitantes_presenciales.como_nos_conociste_id')
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
                $geoip = new GeoIP();
                $geoip->setIp($request->ip());
                $actual->tz = $geoip->getTimezone();

                if($request->tipo == 1){
                    $start = $actual->toDateString();
                    $end = $actual->toDateString();  
                }else if($request->tipo == 2){
                    $start = $actual->startOfMonth()->toDateString();
                    $end = $actual->endOfMonth()->toDateString();  
                }else if($request->tipo == 3){
                    $start = $actual->startOfMonth()->subMonth()->toDateString();
                    $end = $actual->subMonth()->endOfMonth()->toDateString();  
                }

                $query->whereBetween('visitantes_presenciales.fecha_registro', [$start,$end]);
            }
        }

            
        $presenciales = $query->get();

        $array = array();

        $total = 0;
        $mujeres = 0;
        $hombres = 0;
        
        
        $amigo = 0;
        $redes = 0;
        $prensa = 0;
        $television = 0;
        $radio = 0;
        $lugar = 0;
        $otros = 0;

        foreach($presenciales as $presencial){

            if($presencial->cliente){
                $total = $total + 1;
            }

            if($presencial->sexo == 'F'){
                $mujeres++;
            }else{
                $hombres++;
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

            $collection=collect($presencial);     
            $presencial_array = $collection->toArray();
            if($presencial->especialidad == '' OR $presencial->especialidad == null){
                $presencial_array['especialidad']='Sin Especificar';
            }   
            $array[$presencial->id] = $presencial_array;
        }

        // $array_sexo = array();
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

        // $array_hombres = array('M', $hombres);
        // $array_mujeres = array('F', $mujeres);

        // array_push($array_sexo, $array_hombres);
        // array_push($array_sexo, $array_mujeres);   


        // $forAge = DB::select("SELECT CASE
        //     WHEN age BETWEEN 3 and 10 THEN '3 - 10'
        //     WHEN age BETWEEN 11 and 20 THEN '11 - 20'
        //     WHEN age BETWEEN 21 and 35 THEN '21 - 35'
        //     WHEN age BETWEEN 36 and 50 THEN '36 - 50'
        //     WHEN age >= 51 THEN '+51'
        //     WHEN age IS NULL THEN 'Sin fecha (NULL)'
        // END as age_range, COUNT(*) AS count
        // FROM (SELECT TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS age
        // FROM visitantes_presenciales
        // LEFT JOIN  config_especialidades ON visitantes_presenciales.especialidad_id=config_especialidades.id
        // WHERE visitantes_presenciales.fecha_registro >= '".$start."' AND visitantes_presenciales.fecha_registro <= '".$end."')  as visitantes
        // GROUP BY age_range
        // ORDER BY age_range");

        return response()->json(
            [
                'presenciales'      => $array,
                'mujeres'           => $mujeres,
                'hombres'           => $hombres,
                'total'             => $total,
                'conociste'         => $array_conociste,
                'mensaje'           => '¡Excelente! El reporte se ha generado satisfactoriamente'

            ]);

    }


    public function Promotores(){

        $visitantes = DB::table('visitantes_presenciales')
            ->Leftjoin('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
            ->select('visitantes_presenciales.nombre', 'visitantes_presenciales.apellido', 'visitantes_presenciales.fecha_registro as fecha', 'config_especialidades.nombre as especialidad', 'visitantes_presenciales.celular', 'visitantes_presenciales.id', 'visitantes_presenciales.cliente')
            ->where('visitantes_presenciales.academia_id','=', Auth::user()->academia_id)
        ->get();

        $total = DB::table('visitantes_presenciales')
            ->where('visitantes_presenciales.academia_id','=', Auth::user()->academia_id)
            ->where('visitantes_presenciales.cliente','=', 1)
        ->count();


        $sexo = Visitante::Leftjoin('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
            ->selectRaw('sexo, count(sexo) as CantSex')
            ->where('visitantes_presenciales.academia_id','=', Auth::user()->academia_id)
            ->groupBy('visitantes_presenciales.sexo')
            ->get();
        //dd($sexo);
        $mujeres = Visitante::where('sexo', 'F')->where('academia_id',Auth::user()->academia_id)->count();
        $hombres = Visitante::where('sexo', 'M')->where('academia_id',Auth::user()->academia_id)->count();

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

        return view('reportes.promotores')->with(['visitantes' => $visitantes, 'sexos' => $sexo, 'mujeres' => $mujeres, 'hombres' => $hombres, 'edades' => $forAge, 'instructores' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'total' => $total]);
    }

    public function PromotoresFiltros(Request $request)
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

        if($request->Fecha){
            $fechas = explode('-', $request->Fecha);
            $start = Carbon::createFromFormat('d/m/Y',$fechas[0])->toDateString();
            $end = Carbon::createFromFormat('d/m/Y',$fechas[1])->toDateString();
        }

        if($request->instructor_id){
           $presenciales = DB::table('visitantes_presenciales')
                ->Leftjoin('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
                ->select('visitantes_presenciales.nombre', 'visitantes_presenciales.apellido', 'visitantes_presenciales.fecha_registro as fecha', 'config_especialidades.nombre as especialidad', 'visitantes_presenciales.celular', 'visitantes_presenciales.id', 'visitantes_presenciales.sexo', 'visitantes_presenciales.cliente')
                ->where('visitantes_presenciales.academia_id','=', Auth::user()->academia_id)
                ->where('visitantes_presenciales.instructor_id','=', $request->instructor_id)
                ->whereBetween('visitantes_presenciales.fecha_registro', [$start,$end])
            ->get(); 
        }else{
            $presenciales = DB::table('visitantes_presenciales')
                ->Leftjoin('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
                ->select('visitantes_presenciales.nombre', 'visitantes_presenciales.apellido', 'visitantes_presenciales.fecha_registro as fecha', 'config_especialidades.nombre as especialidad', 'visitantes_presenciales.celular', 'visitantes_presenciales.id', 'visitantes_presenciales.sexo', 'visitantes_presenciales.cliente')
                ->where('visitantes_presenciales.academia_id','=', Auth::user()->academia_id)
                ->whereBetween('visitantes_presenciales.fecha_registro', [$start,$end])
            ->get();
        }

        

         $array = array();

        foreach($presenciales as $presencial){
            $collection=collect($presencial);     
            $presencial_array = $collection->toArray();
            if($presencial->especialidad == '' OR $presencial->especialidad == null){
                $presencial_array['especialidad']='Sin Especificar';
            }   
            $array[$presencial->id] = $presencial_array;
        }

        $total = DB::table('visitantes_presenciales')
            ->where('visitantes_presenciales.academia_id','=', Auth::user()->academia_id)
            ->whereBetween('visitantes_presenciales.fecha_registro', [$start,$end])
            ->where('visitantes_presenciales.instructor_id','=', $request->instructor_id)
            ->where('visitantes_presenciales.cliente','=', 1)
        ->count();

        // $sexo = Visitante::Leftjoin('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
        //     ->selectRaw('sexo, count(sexo) as CantSex')
        //     ->where('visitantes_presenciales.academia_id','=', Auth::user()->academia_id)
        //     ->whereBetween('visitantes_presenciales.fecha_registro', [$start,$end])
        //     ->groupBy('visitantes_presenciales.sexo')
        //     ->get();


        $mujeres = 0;
        $hombres = 0;

        foreach($presenciales as $presencial){
            if($presencial->sexo == 'F'){
                $mujeres++;
            }else{
                $hombres++;
            }
        }

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
                        WHERE visitantes_presenciales.fecha_registro >= '".$start."' AND visitantes_presenciales.fecha_registro <= '".$end."'
                         AND visitantes_presenciales.instructor_id = '".$request->instructor_id."')  as visitantes
                        GROUP BY age_range
                        ORDER BY age_range");

        return response()->json(
            [
                'presenciales'      => $array,
                'mujeres'           => $mujeres,
                'hombres'           => $hombres,
                'edades'            => $forAge,
                'total'             => $total
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
            ->select('config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.id as instructor_id','clases_grupales.id as clase_grupal_id' , 'clases_grupales.fecha_inicio as fecha_inicio', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final')
            ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
            ->where('clases_grupales.deleted_at', '=', null)
        ->get();

        $horarios = DB::table('clases_grupales')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('horario_clase_grupales', 'horario_clase_grupales.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('instructores', 'horario_clase_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.id as instructor_id','clases_grupales.id as clase_grupal_id' , 'horario_clase_grupales.fecha as fecha_inicio', 'horario_clase_grupales.id as horario_id','instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final')
            ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
            ->where('horario_clase_grupales.deleted_at', '=', null)
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
            $clase_array['tipo']=1;
            $clase_array['tipo_id']=$clase_grupal->clase_grupal_id;
            $array['1'.$clase_grupal->clase_grupal_id] = $clase_array;
        }


        foreach($horarios as $clase_grupal){
            $fecha_inicio = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
            $dia = $fecha_inicio->dayOfWeek;   

            $collection=collect($clase_grupal);     
            $clase_array = $collection->toArray();
                
            $clase_array['dia']=$dia;
            $clase_array['tipo']=2;
            $clase_array['tipo_id']=$clase_grupal->horario_id;
            $array['2'.$clase_grupal->clase_grupal_id] = $clase_array;
        }

        $alumnos = Alumno::where('academia_id',Auth::user()->academia_id)->get();

        //dd($asistencia);
        return view('reportes.asistencias')->with(['clases_grupales' => $array, 'sexos' => $sexo, 'asistencias' => $asistencias, 'deuda' => $deuda, 'hombres' => $hombres, 'mujeres' => $mujeres, 'instructores' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'alumnos' => $alumnos]);
    }

    public function AsistenciasFiltros(Request $request)
    {
        
         $query = DB::table('asistencias')
            ->join('clases_grupales', 'asistencias.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->join('alumnos', 'asistencias.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'alumnos.sexo as sexo', 'alumnos.fecha_nacimiento as fecha_nacimiento', 'alumnos.sexo as sexo', 'alumnos.telefono as telefono', 'alumnos.celular as celular', 'asistencias.fecha as fecha', 'asistencias.hora as hora', 'alumnos.id as alumno_id', 'alumnos.identificacion as identificacion', 'asistencias.clase_grupal_id', 'asistencias.id');


        $query2 = DB::table('inscripcion_clase_grupal')
            ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'alumnos.sexo as sexo', 'alumnos.fecha_nacimiento as fecha_nacimiento', 'alumnos.sexo as sexo', 'alumnos.telefono as telefono', 'alumnos.celular as celular', 'alumnos.id as alumno_id', 'clases_grupales.id as clase_grupal_id', 'alumnos.identificacion as identificacion', 'inscripcion_clase_grupal.id');

        if($request->clase_grupal_id)
        {
            $query->where('asistencias.clase_grupal_id','=', $request->clase_grupal_id);
            $query2->where('inscripcion_clase_grupal.clase_grupal_id','=', $request->clase_grupal_id);
        }

        if($request->alumno_id)
        {
            $query->where('asistencias.alumno_id','=', $request->alumno_id);
            $query2->where('inscripcion_clase_grupal.alumno_id','=', $request->alumno_id);
        }

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
                    if($asistencia->sexo == 'M'){
                        $pertenece = '<i class="icon_f-consultarle-al-instructor c-azul" data-original-title="" data-content="Invitado" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';
                    }else{
                        $pertenece = '<i class="icon_f-consultarle-al-instructor c-rosado" data-original-title="" data-content="Invitado" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';
                    }
                    
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

        }else if($request->participante_id == 2){

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
        }else{

            $array = array();
            $array_inscripcion = array();

            foreach($inscripciones as $inscripcion){

                $asistio = 0;

                foreach($asistencias as $asistencia){
                    if($asistencia->alumno_id == $inscripcion->alumno_id){
                        $asistio = 1;
                        $fecha = $asistencia->fecha;
                        $hora = $asistencia->hora;
                    }
                }

                if($asistio){
                    $pertenece = '<i class="zmdi c-verde zmdi-check zmdi-hc-fw"></i>';

                    if($inscripcion->sexo == 'F'){
                        $mujeres = $mujeres + 1;
                    }else{
                        $hombres = $hombres + 1;
                    }

                }else{
                    $pertenece = '<i class="zmdi c-amarillo zmdi-dot-circle zmdi-hc-fw"></i>';
                    $fecha = '';
                    $hora = '';
                }

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
                $asistencia_array = $collection->toArray();
                $asistencia_array['pertenece']=$pertenece;
                $asistencia_array['deuda']=$deuda;
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

                    $deuda = DB::table('items_factura_proforma')
                        ->select('items_factura_proforma.*')
                        ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
                        ->where('items_factura_proforma.alumno_id', $asistencia->alumno_id)
                    ->first();

  
                    if($asistencia->sexo == 'M'){
                        $pertenece = '<i class="icon_f-consultarle-al-instructor c-azul" data-original-title="" data-content="Invitado" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';
                        $hombres = $hombres + 1;
                    }else{
                        $pertenece = '<i class="icon_f-consultarle-al-instructor c-rosado" data-original-title="" data-content="Invitado" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';
                        $mujeres = $mujeres + 1;
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
                    $array['2-'.$asistencia->id] = $asistencia_array;

                }
            }

            $array_hombres = array('M', $hombres);
            $array_mujeres = array('F', $mujeres);

            array_push($array_sexo, $array_hombres);
            array_push($array_sexo, $array_mujeres);

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'tipo' => $request->participante_id, 'sexos' => $array_sexo, 'mujeres' => $mujeres, 'hombres' => $hombres, 200]);
            
        }
    }

    public function Estatus_Alumnos()
    {
        // $inscripciones = DB::table('clases_grupales')
        //     ->join('inscripcion_clase_grupal', 'clases_grupales.id', '=', 'inscripcion_clase_grupal.clase_grupal_id')
        //     ->join('config_clases_grupales','clases_grupales.clase_grupal_id','=','config_clases_grupales.id')
        //     ->join('alumnos','inscripcion_clase_grupal.alumno_id','=','alumnos.id')
        //     ->select('inscripcion_clase_grupal.id as inscripcion_id',
        //              'inscripcion_clase_grupal.alumno_id as alumno_id',
        //              'config_clases_grupales.nombre as clase_nombre',
        //              'config_clases_grupales.id as id_clase',
        //              'clases_grupales.fecha_inicio_preferencial',
        //              'clases_grupales.fecha_inicio',
        //              'clases_grupales.fecha_final',
        //              'config_clases_grupales.asistencia_rojo',
        //              'config_clases_grupales.asistencia_amarilla',
        //              'alumnos.id',
        //              'alumnos.nombre',
        //              'alumnos.apellido',
        //              'alumnos.identificacion',
        //              'alumnos.sexo',
        //              'alumnos.celular',
        //              'alumnos.fecha_nacimiento')
        //     ->where('alumnos.academia_id', '=', Auth::user()->academia_id)
        // ->get();

        $alumnos = Alumno::select('alumnos.id',
                         'alumnos.nombre',
                         'alumnos.apellido',
                         'alumnos.identificacion',
                         'alumnos.sexo',
                         'alumnos.celular',
                         'alumnos.fecha_nacimiento')
                ->where('alumnos.academia_id', '=', Auth::user()->academia_id)
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


        // $asistio = array();
        // $array = array();
        // $hoy = Carbon::now();

        // foreach ($inscripciones as $inscritos) {
        //     $fecha_de_inicio = $inscritos->fecha_inicio;
        //     $fecha_de_inicio = Carbon::parse($fecha_de_inicio);
        //     $fecha_de_finalizacion = $inscritos->fecha_final;
        //     $fecha_de_finalizacion = Carbon::parse($fecha_de_finalizacion);
        //     $clases_completadas = 0;
        //     $numero_de_asistencias = 0;
        //     $asistencia_roja = $inscritos->asistencia_rojo;
        //     $asistencia_amarilla = $inscritos->asistencia_amarilla;

        //     $ultima_asistencia = Asistencia::where('tipo',1)->where('tipo_id',$inscritos->id_clase)->where('alumno_id',$inscritos->id)->orderBy('created_at', 'desc')->first();

        //     if($ultima_asistencia){

        //         $fecha = Carbon::parse($ultima_asistencia->fecha);

        //     }else{
        //         $fecha = $fecha_de_inicio;
        //     }

        //     if($hoy<$fecha_de_finalizacion)
        //     {
        //         while($fecha<$hoy)
        //         {
        //             $clases_completadas++;
        //             $fecha->addWeek();
        //         }
        //     }else{
        //         while($fecha<$fecha_de_finalizacion){
        //             $clases_completadas++;
        //             $fecha->addWeek();
        //         }
        //     }

        //     if($clases_completadas>=$asistencia_roja){
        //         $estatus="c-youtube";
        //     }else if($clases_completadas>=$asistencia_amarilla){
        //         $estatus="c-amarillo";
        //     }else{
        //         $estatus="c-verde";
        //     }

        //     $collection=collect($inscritos);     
        //     $alumno_array = $collection->toArray();
        //     $alumno_array['estatus'] = $estatus;
        //     $array[$inscritos->inscripcion_id] = $alumno_array;
        // }

        return view('reportes.estatus_alumnos')->with(['alumnos' => $alumnos, 'clases_grupales' => $clases]);
    }

    public function Estatus_AlumnosFiltros(Request $request){

        $rules = [

            'estatus_alumno_id' => 'required',
        ];

        $messages = [

            'estatus_alumno_id.required' => 'Ups! Tiene que seleccionar una opción',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
        }

        else{

            $query = ClaseGrupal::join('inscripcion_clase_grupal', 'clases_grupales.id', '=', 'inscripcion_clase_grupal.clase_grupal_id')
                ->join('config_clases_grupales','clases_grupales.clase_grupal_id','=','config_clases_grupales.id')
                ->join('alumnos','inscripcion_clase_grupal.alumno_id','=','alumnos.id')
                ->select('inscripcion_clase_grupal.id as inscripcion_id',
                         'inscripcion_clase_grupal.alumno_id as alumno_id',
                         'config_clases_grupales.nombre as clase_nombre',
                         'clases_grupales.id as clase_grupal_id',
                         'clases_grupales.fecha_inicio_preferencial',
                         'clases_grupales.fecha_inicio',
                         'clases_grupales.fecha_final',
                         'config_clases_grupales.asistencia_rojo',
                         'config_clases_grupales.asistencia_amarilla',
                         'alumnos.id',
                         'alumnos.nombre',
                         'alumnos.apellido',
                         'alumnos.identificacion',
                         'alumnos.sexo',
                         'alumnos.celular',
                         'alumnos.fecha_nacimiento')
                ->where('clases_grupales.deleted_at', '=', null)
                ->where('config_clases_grupales.deleted_at', '=', null)
                ->where('alumnos.academia_id', '=', Auth::user()->academia_id);


            if($request->clase_grupal_id){

                $query->where('clases_grupales.id', '=', $request->clase_grupal_id);


            }

            $inscripciones = $query->get();

            $array = array();
            $reporte_estatus = array();
            $hoy = Carbon::now();

            $activos = 0;
            $riesgo = 0;
            $inactivos = 0;

            foreach ($inscripciones as $inscritos) {
                $fecha_de_inicio = $inscritos->fecha_inicio;
                $fecha_de_inicio = Carbon::parse($fecha_de_inicio);
                $fecha_de_finalizacion = $inscritos->fecha_final;
                $fecha_de_finalizacion = Carbon::parse($fecha_de_finalizacion);
                $clases_completadas = 0;
                $numero_de_asistencias = 0;
                $asistencia_roja = $inscritos->asistencia_rojo;
                $asistencia_amarilla = $inscritos->asistencia_amarilla;

                $ultima_asistencia = Asistencia::where('tipo',1)->where('tipo_id',$inscritos->clase_grupal_id)->where('alumno_id',$inscritos->alumno_id)->orderBy('created_at', 'desc')->first();

                if($ultima_asistencia){

                    $fecha = Carbon::parse($ultima_asistencia->fecha);

                }else{
                    $fecha = $fecha_de_inicio;
                }

                if($hoy<$fecha_de_finalizacion)
                {
                    while($fecha<$hoy)
                    {
                        $clases_completadas++;
                        $fecha->addWeek();
                    }
                }else{
                    while($fecha<$fecha_de_finalizacion){
                        $clases_completadas++;
                        $fecha->addWeek();
                    }
                }

                if($clases_completadas>=$asistencia_roja){
                    $estatus="c-youtube";
                    $inactivos = $inactivos + 1;
                }else if($clases_completadas>=$asistencia_amarilla){
                    $estatus="c-amarillo";
                    $riesgo = $riesgo + 1;
                }else{
                    $estatus="c-verde";
                    $activos = $activos + 1;
                }

                $collection=collect($inscritos);     
                $alumno_array = $collection->toArray();
                $alumno_array['estatus'] = $estatus;

                if($request->estatus_alumno_id == 1 && $estatus=="c-verde"){
                    $array[$inscritos->inscripcion_id] = $alumno_array;
                }else if($request->estatus_alumno_id== 2 && $estatus=="c-amarillo"){
                    $array[$inscritos->inscripcion_id] = $alumno_array;
                }else if($request->estatus_alumno_id== 3 && $estatus=="c-youtube"){
                    $array[$inscritos->inscripcion_id] = $alumno_array;
                }else if(!$request->estatus_alumno_id){
                    $array[$inscritos->inscripcion_id] = $alumno_array;
                }
           
            }

            $array_estatus = array();

            $array_activos = array('I', $inactivos);
            $array_riesgo = array('R', $riesgo);
            $array_inactivos = array('A', $activos);

            array_push($array_estatus, $array_activos);
            array_push($array_estatus, $array_riesgo);
            array_push($array_estatus, $array_inactivos);  


            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'reporte_datos' => $array, 'estatus' => $array_estatus, 200]);
            }
    }

    public function Administrativo()
    {
        $clases_grupales= DB::table('clases_grupales')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_clases_grupales.nombre as nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido',  'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.fecha_inicio','clases_grupales.fecha_final', 'clases_grupales.id')
            ->where('clases_grupales.deleted_at', '=', null)
            ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
        ->get();  

        $servicios = ConfigServicios::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

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

        $factura_join = DB::table('facturas')
            ->Leftjoin('alumnos', 'facturas.alumno_id', '=', 'alumnos.id')
            ->Leftjoin('usuario_externos','facturas.externo_id', '=', 'usuario_externos.id')
            // ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'facturas.numero_factura as factura', 'facturas.fecha as fecha', 'facturas.id', 'facturas.concepto')
            ->selectRaw('IF(alumnos.nombre is null AND alumnos.apellido is null, usuario_externos.nombre, CONCAT(alumnos.nombre, " " , alumnos.apellido)) as nombre, facturas.numero_factura as factura, facturas.fecha as fecha, facturas.id, facturas.concepto')
            ->where('facturas.academia_id' , '=' , Auth::user()->academia_id)
            ->where('alumnos.deleted_at' , '=' , null)
            ->OrderBy('facturas.created_at')
        ->get();

        $total_de_informe=0;

        foreach($factura_join as $factura){

            $total = ItemsFactura::where('factura_id', '=' ,  $factura->id)->sum('importe_neto');
            $total_de_informe+=$total;

        }

        return view('reportes.administrativo')->with(['total'=>$total_de_informe, 'clases_grupales' => $array, 'servicios' => $servicios]);
    }

    public function AdministrativoFiltros(Request $request)
    {

        $array = array();
        $total = 0;

        $query = Alumno::join('inscripcion_clase_grupal','inscripcion_clase_grupal.alumno_id','=','alumnos.id')
                ->select('alumnos.id as id',
                         'alumnos.nombre',
                         'alumnos.apellido')
                ->where('alumnos.academia_id', '=', Auth::user()->academia_id);
                

        if($request->clase_grupal_id)
        {
            $query->where('inscripcion_clase_grupal.clase_grupal_id','=', $request->clase_grupal_id);
        }

        $query->distinct('id');

        $alumnos = $query->get();

        foreach($alumnos as $alumno){

            $query = ItemsFacturaProforma::where('alumno_id', $alumno->id);

            if($request->servicio_id)
            {

                $servicio = explode("-", $request->servicio_id);
                $servicio_tmp = ConfigServicios::find($servicio[0]);

                if($servicio_tmp)
                {
                    $query->where('nombre','=', $servicio_tmp->nombre);
                }else{
                    $query->where('tipo','=', $servicio[1]);
                    $query->where('item_id','=', $servicio[0]);
                }
            }

            if($request->tipo == 1)
            {
                $query->where('fecha_vencimiento','<=', Carbon::now()->toDateString());
            }else{
                $query->where('fecha_vencimiento','>=', Carbon::now()->toDateString());
            }

            $facturas = $query->get();

            foreach($facturas as $factura){

                $collection=collect($factura);     
                $factura_array = $collection->toArray();
                $factura_array['cliente'] = $alumno->nombre . ' ' . $alumno->apellido;
                $array[$factura->id] = $factura_array;

                $total = $total + $factura->importe_neto;

            }
        }

        return response()->json(['mensaje' => '¡Excelente! El reporte se ha generado satisfactoriamente', 'status' => 'OK', 'facturas' => $array, 'total' => $total, 200]);

    }

    // public function Administrativo()
    // {
    //     $array = array();

    //     $factura_join = DB::table('facturas')
    //         ->Leftjoin('alumnos', 'facturas.alumno_id', '=', 'alumnos.id')
    //         ->Leftjoin('usuario_externos','facturas.externo_id', '=', 'usuario_externos.id')
    //         // ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'facturas.numero_factura as factura', 'facturas.fecha as fecha', 'facturas.id', 'facturas.concepto')
    //         ->selectRaw('IF(alumnos.nombre is null AND alumnos.apellido is null, usuario_externos.nombre, CONCAT(alumnos.nombre, " " , alumnos.apellido)) as nombre, facturas.numero_factura as factura, facturas.fecha as fecha, facturas.id, facturas.concepto')
    //         ->where('facturas.academia_id' , '=' , Auth::user()->academia_id)
    //         ->where('alumnos.deleted_at' , '=' , null)
    //         ->OrderBy('facturas.created_at')
    //     ->get();

    //     $total_de_informe=0;

    //     foreach($factura_join as $factura){

    //         $total = ItemsFactura::where('factura_id', '=' ,  $factura->id)->sum('importe_neto');
    //         $collection=collect($factura);     
    //         $factura_array = $collection->toArray();
            
    //         $factura_array['total']=$total;
    //         $total_de_informe+=$total;
    //         $array[$factura->id] = $factura_array;

    //     }

    //     return view('reportes.administrativo')->with(['facturas'=> $array, 'total'=>$total_de_informe]);
    // }

    // public function AdministrativoFiltros(Request $request)
    // {
    //     if($request->mesActual){
    //         $start = Carbon::now()->startOfMonth()->toDateString();
    //         $end = Carbon::now()->endOfMonth()->toDateString();  
    //     }
    //     if($request->mesPasado){
    //         $start = Carbon::now()->startOfMonth()->subMonth()->toDateString();
    //         $end = Carbon::now()->subMonth()->endOfMonth()->toDateString();  

    //     }
    //     if($request->today){
    //         $start = Carbon::now()->toDateString();
    //         $end = Carbon::now()->toDateString();  
    //     }
    //     if($request->rango){
    //         //$fechas = explode(' - ', $request->dateRange);
    //         $start = Carbon::createFromFormat('d/m/Y',$request->fechaInicio)->toDateString();
    //         $end = Carbon::createFromFormat('d/m/Y',$request->fechaFin)->toDateString();
    //     }

    //     if($request->Fecha){
    //         $fechas = explode('-', $request->Fecha);
    //         $start = Carbon::createFromFormat('d/m/Y',$fechas[0])->toDateString();
    //         $end = Carbon::createFromFormat('d/m/Y',$fechas[1])->toDateString();
    //     }

    //     $array = array();

    //     $factura_join = DB::table('facturas')
    //         ->Leftjoin('alumnos', 'facturas.alumno_id', '=', 'alumnos.id')
    //         ->Leftjoin('usuario_externos','facturas.externo_id', '=', 'usuario_externos.id')
    //         // ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'facturas.numero_factura as factura', 'facturas.fecha as fecha', 'facturas.id', 'facturas.concepto')
    //         ->selectRaw('IF(alumnos.nombre is null AND alumnos.apellido is null, usuario_externos.nombre, CONCAT(alumnos.nombre, " " , alumnos.apellido)) as nombre, facturas.numero_factura as factura, facturas.fecha as fecha, facturas.id, facturas.concepto')
    //         ->where('facturas.academia_id' , '=' , Auth::user()->academia_id)
    //         ->where('alumnos.deleted_at' , '=' , null)
    //         ->whereBetween('facturas.fecha', [$start,$end])
    //         ->OrderBy('facturas.created_at')
    //     ->get();

    //     foreach($factura_join as $factura){

    //         $total = ItemsFactura::where('factura_id', '=' ,  $factura->id)->sum('importe_neto');
    //         $collection=collect($factura);     
    //         $factura_array = $collection->toArray();
            
    //         $factura_array['total']=$total;
    //         $array[$factura->id] = $factura_array;
    //     }

    //     return response()->json(['mensaje' => '¡Excelente! El reporte se ha generado satisfactoriamente', 'status' => 'OK', 'facturas' => $array, 200]);

    // }

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

        $alumnos = Alumno::where('academia_id','=', Auth::user()->academia_id)
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
                    $end = Carbon::now()->toDateString();  
                }else if($request->tipo == 2){
                    $start = Carbon::now()->startOfMonth()->toDateString();
                    $end = Carbon::now()->endOfMonth()->toDateString();  
                }else if($request->tipo == 3){
                    $start = Carbon::now()->startOfMonth()->subMonth()->toDateString();
                    $end = Carbon::now()->subMonth()->endOfMonth()->toDateString();  
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

        $alumnos = Alumno::where('academia_id','=', Auth::user()->academia_id)
        ->get();

        $clases_grupales= DB::table('clases_grupales')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_clases_grupales.nombre as nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido',  'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.fecha_inicio','clases_grupales.fecha_final', 'clases_grupales.id')
            ->where('clases_grupales.deleted_at', '=', null)
            ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
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
                    $end = Carbon::now()->toDateString();  
                }else if($request->tipo == 2){
                    $start = Carbon::now()->startOfMonth()->toDateString();
                    $end = Carbon::now()->endOfMonth()->toDateString();  
                }else if($request->tipo == 3){
                    $start = Carbon::now()->startOfMonth()->subMonth()->toDateString();
                    $end = Carbon::now()->subMonth()->endOfMonth()->toDateString();  
                }

                $query->whereBetween('asistencias.fecha', [$start,$end]);
            }
        }
        

        $asistencias = $query->get();
        $array = array();

        foreach($asistencias as $asistencia){

            $deuda = DB::table('items_factura_proforma')
                ->select('items_factura_proforma.*')
                ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
                ->where('items_factura_proforma.alumno_id', $asistencia->alumno_id)
            ->first();

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

}