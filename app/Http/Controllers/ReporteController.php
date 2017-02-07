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
use App\ItemsFactura;

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

        if($request->Fecha){
            $fechas = explode('-', $request->Fecha);
            $start = Carbon::createFromFormat('d/m/Y',$fechas[0])->toDateString();
            $end = Carbon::createFromFormat('d/m/Y',$fechas[1])->toDateString();
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

        // $sexo = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
        //     ->selectRaw('sexo, count(sexo) as CantSex')
        //     ->where('alumnos.academia_id','=', Auth::user()->academia_id)
        //     ->whereBetween('inscripcion_clase_grupal.fecha_inscripcion', [$start,$end])
        //     ->groupBy('alumnos.sexo')
        //     ->get();

        $mujeres = 0;
        $hombres = 0;

        foreach($inscritos as $inscrito){
            if($inscrito->sexo == 'F'){
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
                        FROM inscripcion_clase_grupal
                        INNER JOIN  alumnos ON alumno_id=alumnos.id
                        WHERE inscripcion_clase_grupal.fecha_inscripcion >= '".$start."' AND inscripcion_clase_grupal.fecha_inscripcion <= '".$end."' AND alumnos.academia_id = '".Auth::user()->academia_id."')  as alumnos
                        GROUP BY age_range
                        ORDER BY age_range");            
        
        return response()->json(
            [
                'inscritos'         => $inscritos,
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

        return view('reportes.presenciales')->with(['presenciales' => $presenciales, 'sexos' => $sexo, 'mujeres' => $mujeres, 'hombres' => $hombres, 'edades' => $forAge, 'total' => $total]);
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

        if($request->Fecha){
            $fechas = explode('-', $request->Fecha);
            $start = Carbon::createFromFormat('d/m/Y',$fechas[0])->toDateString();
            $end = Carbon::createFromFormat('d/m/Y',$fechas[1])->toDateString();
        }

        $presenciales = DB::table('visitantes_presenciales')
            ->Leftjoin('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
            ->select('visitantes_presenciales.nombre', 'visitantes_presenciales.apellido', 'visitantes_presenciales.fecha_registro as fecha', 'config_especialidades.nombre as especialidad', 'visitantes_presenciales.celular', 'visitantes_presenciales.id', 'visitantes_presenciales.sexo', 'visitantes_presenciales.cliente')
            ->where('visitantes_presenciales.academia_id','=', Auth::user()->academia_id)
            ->where('visitantes_presenciales.cliente','=', $request->cliente)
            ->whereBetween('visitantes_presenciales.fecha_registro', [$start,$end])
        ->get();

        $total = DB::table('visitantes_presenciales')
            ->where('visitantes_presenciales.academia_id','=', Auth::user()->academia_id)
            ->whereBetween('visitantes_presenciales.fecha_registro', [$start,$end])
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
                        WHERE visitantes_presenciales.fecha_registro >= '".$start."' AND visitantes_presenciales.fecha_registro <= '".$end."')  as visitantes
                        GROUP BY age_range
                        ORDER BY age_range");

        return response()->json(
            [
                'presenciales'      => $presenciales,
                'mujeres'           => $mujeres,
                'hombres'           => $hombres,
                'edades'            => $forAge,
                'total'             => $total
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

        $presenciales = DB::table('visitantes_presenciales')
            ->Leftjoin('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
            ->select('visitantes_presenciales.nombre', 'visitantes_presenciales.apellido', 'visitantes_presenciales.fecha_registro as fecha', 'config_especialidades.nombre as especialidad', 'visitantes_presenciales.celular', 'visitantes_presenciales.id', 'visitantes_presenciales.sexo', 'visitantes_presenciales.cliente')
            ->where('visitantes_presenciales.academia_id','=', Auth::user()->academia_id)
            ->where('visitantes_presenciales.instructor_id','=', $request->instructor_id)
            ->where('visitantes_presenciales.cliente','=', $request->cliente)
            ->whereBetween('visitantes_presenciales.fecha_registro', [$start,$end])
        ->get();

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
                'presenciales'      => $presenciales,
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

        //dd($asistencia);
        return view('reportes.asistencias')->with(['clases_grupales' => $array, 'sexos' => $sexo, 'asistencias' => $asistencias, 'deuda' => $deuda, 'hombres' => $hombres, 'mujeres' => $mujeres, 'instructores' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get()]);
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
        ];

        $messages = [

            'participante_id.required' => 'Ups! Tiene que seleccionar una opción',
            'fecha.required' => 'Ups! La fecha es requerida',
            'clase_grupal_id.required' => 'Ups! La Clase Grupal es requerida',
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

    public function estatus_alumnos()
    {
        $inscripciones = DB::table('clases_grupales')
                ->join('inscripcion_clase_grupal', 'clases_grupales.id', '=', 'inscripcion_clase_grupal.clase_grupal_id')
                ->join('config_clases_grupales','clases_grupales.clase_grupal_id','=','config_clases_grupales.id')
                ->select('inscripcion_clase_grupal.id as inscripcion_id',
                         'inscripcion_clase_grupal.alumno_id as alumno_id',
                         'config_clases_grupales.nombre as clase_nombre',
                         'config_clases_grupales.id as id_clase',
                         'clases_grupales.fecha_inicio_preferencial',
                         'clases_grupales.fecha_inicio',
                         'clases_grupales.fecha_final',
                         'config_clases_grupales.asistencia_rojo',
                         'config_clases_grupales.asistencia_amarilla')
                ->where('clases_grupales.academia_id', '=', Auth::user()->academia_id)
        ->get();

        $alumnos = DB::table('alumnos')
                ->select('alumnos.id',
                         'alumnos.nombre',
                         'alumnos.apellido',
                         'alumnos.identificacion',
                         'alumnos.sexo',
                         'alumnos.celular',
                         'alumnos.fecha_nacimiento')
                ->where('alumnos.academia_id', '=', Auth::user()->academia_id)
        ->get();

        $asistencias = DB::table('asistencias')
                ->join('clases_grupales', 'asistencias.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('alumnos', 'asistencias.alumno_id', '=', 'alumnos.id')
                ->select('asistencias.clase_grupal_id', 'asistencias.id', 'asistencias.alumno_id')
                ->where('alumnos.academia_id','=', Auth::user()->academia_id)
        ->get();

        $clases_grupales = DB::table('clases_grupales')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
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

        $sexo = Asistencia::join('alumnos', 'asistencias.alumno_id', '=', 'alumnos.id')
            ->selectRaw('sexo, count(sexo) as CantSex')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
            ->groupBy('alumnos.sexo')
        ->get();

        $asistio = array();
        $reporte_estatus = array();
        $hoy = Carbon::now();

        foreach ($inscripciones as $inscritos) {
            $fecha_de_inicio = $inscritos->fecha_inicio;
            $fecha_de_inicio = Carbon::parse($fecha_de_inicio);
            $fecha_de_finalizacion = $inscritos->fecha_final;
            $fecha_de_finalizacion = Carbon::parse($fecha_de_finalizacion);
            $clases_completadas = 0;
            $numero_de_asistencias = 0;
            $asistencia_roja = $inscritos->asistencia_rojo;
            $asistencia_amarilla = $inscritos->asistencia_amarilla;

            if($hoy<$fecha_de_finalizacion){
                while($fecha_de_inicio<$hoy){
                    $clases_completadas++;
                    $fecha_de_inicio->addWeek();
                }
            }else{
                while($fecha_de_inicio<$fecha_de_finalizacion){
                    $clases_completadas++;
                    $fecha_de_inicio->addWeek();
                }
            }
            foreach($asistencias as $asistencia) {
                if($inscritos->alumno_id==$asistencia->alumno_id)
                {
                    $numero_de_asistencias++;
                }
            }

            if(($clases_completadas-$numero_de_asistencias)>=$asistencia_roja){
                $asistio[$inscritos->inscripcion_id]="c-youtube";
            }else if(($clases_completadas-$numero_de_asistencias)>=$asistencia_amarilla){
                $asistio[$inscritos->inscripcion_id]="c-amarillo";
            }else{
                $asistio[$inscritos->inscripcion_id]="c-verde";
            }

            foreach ($alumnos as $alumno) {
                if($inscritos->alumno_id == $alumno->id){
                    $reporte_estatus[$inscritos->inscripcion_id]['alumno_nombre'] = $alumno->nombre;
                    $reporte_estatus[$inscritos->inscripcion_id]['alumno_apellido'] = $alumno->apellido;
                    $reporte_estatus[$inscritos->inscripcion_id]['alumno_identificacion'] = $alumno->identificacion;
                    $reporte_estatus[$inscritos->inscripcion_id]['alumno_sexo'] = $alumno->sexo;
                    $reporte_estatus[$inscritos->inscripcion_id]['alumno_nacimiento'] = $alumno->fecha_nacimiento;
                    $reporte_estatus[$inscritos->inscripcion_id]['alumno_celular'] = $alumno->celular;
                    $reporte_estatus[$inscritos->inscripcion_id]['clase_grupal'] = $inscritos->clase_nombre;
                    $reporte_estatus[$inscritos->inscripcion_id]['estatus_alumno'] = $asistio[$inscritos->inscripcion_id];
                }
            }
        }

        return view('reportes.estatus_alumnos')->with(['alumnos' => $inscripciones, 'reporte_datos' => $reporte_estatus, 'clases_grupales' => $clases, 'sexos' => $sexo]);
    }

    public function filtrar_estatus_alumnos(Request $request){
        $rules = [

            'estatus_alumno_id' => 'required',
            'clase_grupal_id' => 'required',
        ];

        $messages = [

            'estatus_alumno_id.required' => 'Ups! Tiene que seleccionar una opción',
            'clase_grupal_id.required' => 'Ups! La Clase Grupal es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
        }

        else{

            $inscripciones = DB::table('clases_grupales')
                ->join('inscripcion_clase_grupal', 'clases_grupales.id', '=', 'inscripcion_clase_grupal.clase_grupal_id')
                ->join('config_clases_grupales','clases_grupales.clase_grupal_id','=','config_clases_grupales.id')
                ->select('inscripcion_clase_grupal.id as inscripcion_id',
                         'inscripcion_clase_grupal.alumno_id as alumno_id',
                         'config_clases_grupales.nombre as clase_nombre',
                         'config_clases_grupales.id as id_clase',
                         'clases_grupales.fecha_inicio_preferencial',
                         'clases_grupales.fecha_inicio',
                         'clases_grupales.fecha_final',
                         'config_clases_grupales.asistencia_rojo',
                         'config_clases_grupales.asistencia_amarilla')
                ->where('clases_grupales.id', '=', $request->clase_grupal_id)
            ->get();

            $alumnos = DB::table('alumnos')
                ->join('inscripcion_clase_grupal', 'alumnos.id', '=', 'inscripcion_clase_grupal.alumno_id')
                ->select('alumnos.id',
                         'alumnos.nombre',
                         'alumnos.apellido',
                         'alumnos.identificacion',
                         'alumnos.sexo',
                         'alumnos.celular',
                         'alumnos.fecha_nacimiento')
                ->where('inscripcion_clase_grupal.clase_grupal_id', '=', $request->clase_grupal_id)
            ->get();

            $asistencias = DB::table('asistencias')
                ->join('clases_grupales', 'asistencias.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('alumnos', 'asistencias.alumno_id', '=', 'alumnos.id')
                ->select('asistencias.clase_grupal_id', 'asistencias.id', 'asistencias.alumno_id')
                ->where('asistencias.clase_grupal_id','=', $request->clase_grupal_id)
            ->get();

            $sexo = Asistencia::join('alumnos', 'asistencias.alumno_id', '=', 'alumnos.id')
                ->selectRaw('sexo, count(sexo) as CantSex')
                ->where('asistencias.clase_grupal_id','=', $request->clase_grupal_id)
                ->groupBy('alumnos.sexo')
            ->get();

            $asistio = array();
            $reporte_estatus = array();
            $hoy = Carbon::now();

            foreach ($inscripciones as $inscritos) {
                $fecha_de_inicio = $inscritos->fecha_inicio;
                $fecha_de_inicio = Carbon::parse($fecha_de_inicio);
                $fecha_de_finalizacion = $inscritos->fecha_final;
                $fecha_de_finalizacion = Carbon::parse($fecha_de_finalizacion);
                $clases_completadas = 0;
                $numero_de_asistencias = 0;
                $asistencia_roja = $inscritos->asistencia_rojo;
                $asistencia_amarilla = $inscritos->asistencia_amarilla;

                if($hoy<$fecha_de_finalizacion)
                {
                    while($fecha_de_inicio<$hoy)
                    {
                        $clases_completadas++;
                        $fecha_de_inicio->addWeek();
                    }
                }else{
                    while($fecha_de_inicio<$fecha_de_finalizacion){
                        $clases_completadas++;
                        $fecha_de_inicio->addWeek();
                    }
                }
                foreach($asistencias as $asistencia) {
                    if($inscritos->alumno_id==$asistencia->alumno_id)
                    {
                        $numero_de_asistencias++;
                    }
                }

                if(($clases_completadas-$numero_de_asistencias)>=$asistencia_roja){
                    $asistio[$inscritos->inscripcion_id]="c-youtube";
                }else if(($clases_completadas-$numero_de_asistencias)>=$asistencia_amarilla){
                    $asistio[$inscritos->inscripcion_id]="c-amarillo";
                }else{
                    $asistio[$inscritos->inscripcion_id]="c-verde";
                }

                foreach ($alumnos as $alumno) {
                    if($inscritos->alumno_id == $alumno->id){
                        if($request->estatus_alumno_id== 1 && $asistio[$inscritos->inscripcion_id]=="c-verde"){
                            $reporte_estatus[$inscritos->inscripcion_id]['alumno_nombre'] = $alumno->nombre;
                            $reporte_estatus[$inscritos->inscripcion_id]['alumno_apellido'] = $alumno->apellido;
                            $reporte_estatus[$inscritos->inscripcion_id]['alumno_identificacion'] = $alumno->identificacion;
                            $reporte_estatus[$inscritos->inscripcion_id]['alumno_sexo'] = $alumno->sexo;
                            $reporte_estatus[$inscritos->inscripcion_id]['alumno_nacimiento'] = $alumno->fecha_nacimiento;
                            $reporte_estatus[$inscritos->inscripcion_id]['alumno_celular'] = $alumno->celular;
                            $reporte_estatus[$inscritos->inscripcion_id]['clase_grupal'] = $inscritos->clase_nombre;
                            $reporte_estatus[$inscritos->inscripcion_id]['estatus_alumno'] = $asistio[$inscritos->inscripcion_id];

                        }else if($request->estatus_alumno_id== 2 && $asistio[$inscritos->inscripcion_id]=="c-amarillo"){
                            $reporte_estatus[$inscritos->inscripcion_id]['alumno_nombre'] = $alumno->nombre;
                            $reporte_estatus[$inscritos->inscripcion_id]['alumno_apellido'] = $alumno->apellido;
                            $reporte_estatus[$inscritos->inscripcion_id]['alumno_identificacion'] = $alumno->identificacion;
                            $reporte_estatus[$inscritos->inscripcion_id]['alumno_sexo'] = $alumno->sexo;
                            $reporte_estatus[$inscritos->inscripcion_id]['alumno_nacimiento'] = $alumno->fecha_nacimiento;
                            $reporte_estatus[$inscritos->inscripcion_id]['alumno_celular'] = $alumno->celular;
                            $reporte_estatus[$inscritos->inscripcion_id]['clase_grupal'] = $inscritos->clase_nombre;
                            $reporte_estatus[$inscritos->inscripcion_id]['estatus_alumno'] = $asistio[$inscritos->inscripcion_id];

                        }else if($request->estatus_alumno_id== 3 && $asistio[$inscritos->inscripcion_id]=="c-youtube"){
                            $reporte_estatus[$inscritos->inscripcion_id]['alumno_nombre'] = $alumno->nombre;
                            $reporte_estatus[$inscritos->inscripcion_id]['alumno_apellido'] = $alumno->apellido;
                            $reporte_estatus[$inscritos->inscripcion_id]['alumno_identificacion'] = $alumno->identificacion;
                            $reporte_estatus[$inscritos->inscripcion_id]['alumno_sexo'] = $alumno->sexo;
                            $reporte_estatus[$inscritos->inscripcion_id]['alumno_nacimiento'] = $alumno->fecha_nacimiento;
                            $reporte_estatus[$inscritos->inscripcion_id]['alumno_celular'] = $alumno->celular;
                            $reporte_estatus[$inscritos->inscripcion_id]['clase_grupal'] = $inscritos->clase_nombre;
                            $reporte_estatus[$inscritos->inscripcion_id]['estatus_alumno'] = $asistio[$inscritos->inscripcion_id];
                        }
                    }
                }
            }

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'reporte_datos' => $reporte_estatus, 'alumnos'=>$alumnos, 'sexos' => $sexo, 200]);
            }
    }

    public function Administrativo()
    {
        
        
        $array = array();

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
            $collection=collect($factura);     
            $factura_array = $collection->toArray();
            
            $factura_array['total']=$total;
            $total_de_informe+=$total;
            $array[$factura->id] = $factura_array;

        }

        return view('reportes.administrativo')->with(['facturas'=> $array, 'total'=>$total_de_informe]);
    }

    public function AdministrativoFiltros(Request $request)
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

        if($request->Fecha){
            $fechas = explode('-', $request->Fecha);
            $start = Carbon::createFromFormat('d/m/Y',$fechas[0])->toDateString();
            $end = Carbon::createFromFormat('d/m/Y',$fechas[1])->toDateString();
        }

        $array = array();

        $factura_join = DB::table('facturas')
            ->Leftjoin('alumnos', 'facturas.alumno_id', '=', 'alumnos.id')
            ->Leftjoin('usuario_externos','facturas.externo_id', '=', 'usuario_externos.id')
            // ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'facturas.numero_factura as factura', 'facturas.fecha as fecha', 'facturas.id', 'facturas.concepto')
            ->selectRaw('IF(alumnos.nombre is null AND alumnos.apellido is null, usuario_externos.nombre, CONCAT(alumnos.nombre, " " , alumnos.apellido)) as nombre, facturas.numero_factura as factura, facturas.fecha as fecha, facturas.id, facturas.concepto')
            ->where('facturas.academia_id' , '=' , Auth::user()->academia_id)
            ->where('alumnos.deleted_at' , '=' , null)
            ->whereBetween('facturas.fecha', [$start,$end])
            ->OrderBy('facturas.created_at')
        ->get();

        foreach($factura_join as $factura){


            $total = ItemsFactura::where('factura_id', '=' ,  $factura->id)->sum('importe_neto');
            $collection=collect($factura);     
            $factura_array = $collection->toArray();
            
            $factura_array['total']=$total;
            $array[$factura->id] = $factura_array;

        }

        
        
        return response()->json(['mensaje' => '¡Excelente! El reporte se ha generado satisfactoriamente', 'status' => 'OK', 'facturas' => $array, 200]);

    }

}