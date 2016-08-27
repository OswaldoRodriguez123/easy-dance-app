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

        return view('reportes.inscritos')->with(['inscritos' => $inscritos, 'sexos' => $sexo, 'total_inscritos' => $total, 'edades' => $forAge]);
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

        $total = InscripcionClaseGrupal::whereBetween('inscripcion_clase_grupal.fecha_inscripcion', [$start,$end])->count();

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
                'total_inscritos'   => $total,
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
        $asistencia = Asistencia::join('alumnos', 'asistencias.alumno_id', '=', 'alumnos.id')
                        ->select('alumnos.nombre as alumno_nombre','alumnos.apellido as alumno_apellido','alumnos.identificacion as cedula', 'alumnos.fecha_nacimiento as fecha_nacimiento','alumnos.sexo as sexo', 'alumnos.telefono as telefono', 'alumnos.celular as celular','asistencias.fecha as fecha', 'asistencias.hora as hora')
                        ->where('asistencias.academia_id','=', Auth::user()->academia_id)
                        ->get();
        //dd($asistencia);
        return view('reportes.asistencias')->with(['asistencias' => $asistencia]);
    }

    public function charts()
    {
        return view('reportes.procesos_inscripcion');
    }

}