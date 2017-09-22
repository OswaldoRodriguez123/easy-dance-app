<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Academia;
use App\InscripcionClaseGrupal;
use App\ClaseGrupal;
use App\HorarioClaseGrupal;
use App\Progreso;
use App\Paso;
use App\ProgresoPaso;
use App\ConfigEspecialidades;
use App\ConfigNiveles;
use App\Examen;
use App\Instructor;
use App\Evaluacion;
use App\DetalleEvaluacion;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Session;

class ProgresoController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    
    public function index()
    {

        $usuario_id = Session::get('easydance_usuario_id');

        $clase_grupal_join = InscripcionClaseGrupal::join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->select('config_clases_grupales.nombre as clase_grupal_nombre', 'clases_grupales.id', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion')
            ->where('inscripcion_clase_grupal.alumno_id','=', $usuario_id)
            ->where('clases_grupales.deleted_at', '=', null)
            ->OrderBy('clases_grupales.hora_inicio')
        ->get();

        $academia = Academia::find(Auth::user()->academia_id);

        return view('progreso.principal')->with(['clase_grupal_join' => $clase_grupal_join]);
    
    }

    public function principalprogramacion()
    {
        $usuario_tipo = Session::get('easydance_usuario_tipo');
        $usuario_id = Session::get('easydance_usuario_id');


        $instructor = Instructor::find($usuario_id);

        if(!$instructor->boolean_administrador){

            $clase_grupal_join = ClaseGrupal::join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.id', 'clases_grupales.fecha_inicio', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'clases_grupales.boolean_promocionar', 'clases_grupales.dias_prorroga')
                ->where('clases_grupales.instructor_id','=', $usuario_id)
                ->OrderBy('clases_grupales.hora_inicio')
            ->get();

            $horarios_clase_grupales = HorarioClaseGrupal::join('config_especialidades', 'horarios_clases_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->join('config_estudios', 'horarios_clases_grupales.estudio_id', '=', 'config_estudios.id')
                ->join('instructores', 'horarios_clases_grupales.instructor_id', '=', 'instructores.id')
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
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.id', 'clases_grupales.fecha_inicio', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion','config_clases_grupales.costo_mensualidad', 'clases_grupales.boolean_promocionar', 'clases_grupales.dias_prorroga')
                ->OrderBy('clases_grupales.hora_inicio')
            ->get();

            $horarios_clase_grupales = HorarioClaseGrupal::join('config_especialidades', 'horarios_clases_grupales.especialidad_id', '=', 'config_especialidades.id')
                ->join('config_estudios', 'horarios_clases_grupales.estudio_id', '=', 'config_estudios.id')
                ->join('instructores', 'horarios_clases_grupales.instructor_id', '=', 'instructores.id')
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

        return view('vista_instructor.clase_grupal')->with(['clase_grupal_join' => $array, 'hoy' => $hoy, 'academia' => $academia, 'tipo' => 3]);
         
    }

    public function programacionsalsa()
    {
        $usuario_tipo = Session::get('easydance_usuario_tipo');
        $usuario_id = Session::get('easydance_usuario_id');

        $clases_grupales = ClaseGrupal::join('inscripcion_clase_grupal', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->select('config_clases_grupales.nombre as clase_grupal_nombre', 'clases_grupales.id', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion')
            ->where('inscripcion_clase_grupal.alumno_id','=', $usuario_id)
            ->where('clases_grupales.especialidad_id','=', 20)
        ->get();

        $horarios_clase_grupales = ClaseGrupal::join('inscripcion_clase_grupal', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('horarios_clases_grupales', 'horarios_clases_grupales.clase_grupal_id', '=', 'clases_grupales.id')
            ->select('config_clases_grupales.nombre as clase_grupal_nombre', 'horarios_clases_grupales.id', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion')
            ->where('inscripcion_clase_grupal.alumno_id','=', $usuario_id)
            ->where('horarios_clases_grupales.especialidad_id','=', 20)
        ->get();

        $array = array();

        foreach($clases_grupales as $clase_grupal){

            $collection=collect($clase_grupal);     
            $clase_grupal_array = $collection->toArray();
            $clase_grupal_array['tipo'] = 1;
            $array[] = $clase_grupal_array;
        }

        foreach($horarios_clase_grupales as $clase_grupal){
            $collection=collect($clase_grupal);     
            $clase_grupal_array = $collection->toArray();
            $clase_grupal_array['tipo'] = 2;
            $array[] = $clase_grupal_array;
        }

        return view('progreso.principalprogramacion')->with(['clase_grupal_join' => $array]);

    }

    public function programacionbachata()
    {
        $usuario_tipo = Session::get('easydance_usuario_tipo');
        $usuario_id = Session::get('easydance_usuario_id');

        $clases_grupales = ClaseGrupal::join('inscripcion_clase_grupal', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->select('config_clases_grupales.nombre as clase_grupal_nombre', 'clases_grupales.id', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion')
            ->where('inscripcion_clase_grupal.alumno_id','=', $usuario_id)
            ->where('clases_grupales.especialidad_id','=', 1)
        ->get();

        $horarios_clase_grupales = ClaseGrupal::join('inscripcion_clase_grupal', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('horarios_clases_grupales', 'horarios_clases_grupales.clase_grupal_id', '=', 'horarios_clases_grupales.id')
            ->select('config_clases_grupales.nombre as clase_grupal_nombre', 'clases_grupales.id', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion')
            ->where('inscripcion_clase_grupal.alumno_id','=', $usuario_id)
            ->where('horarios_clases_grupales.especialidad_id','=', 1)
        ->get();

        $array = array();

        foreach($clases_grupales as $clase_grupal){

            $collection=collect($clase_grupal);     
            $clase_grupal_array = $collection->toArray();
            $clase_grupal_array['tipo'] = 1;
            $array[] = $clase_grupal_array;
        }

        foreach($horarios_clase_grupales as $clase_grupal){
            $collection=collect($clase_grupal);     
            $clase_grupal_array = $collection->toArray();
            $clase_grupal_array['tipo'] = 2;
            $array[] = $clase_grupal_array;
        }

        return view('progreso.principalprogramacion')->with(['clase_grupal_join' => $array]);
    }

    public function programacion($id){
        
        $usuario_tipo = Session::get('easydance_usuario_tipo');
        $usuario_id = Session::get('easydance_usuario_id');

        $explode = explode("-",$id);
        $id = $explode[0];
        $tipo = $explode[1];

        if($tipo == 1){
            $clase_grupal = ClaseGrupal::find($id);
            $especialidad_id = $clase_grupal->especialidad_id;
        }else{
            $horario = HorarioClaseGrupal::find($id);
            $clase_grupal = ClaseGrupal::find($horario->clase_grupal_id);
            $id = $clase_grupal->id;
            $especialidad_id = $horario->especialidad_id;
        }

        if($clase_grupal){

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

            $tmp = ProgresoPaso::where('clase_grupal_id',$id)->where('status',1)->get();
            $collection=collect($tmp);
            $grouped = $collection->groupBy('codigo');     
            $permisos = $grouped->toArray();
            
            if($usuario_tipo == 2 OR $usuario_tipo == 4){

                $find = InscripcionClaseGrupal::where('clase_grupal_id', $id)->where('alumno_id',$usuario_id)->first();

                $examen = Examen::where('boolean_grupal',1)->where('clase_grupal_id', $id)->first();

                if($examen){

                    $evaluacion = Evaluacion::where('examen_id',$examen->id)->where('alumno_id', $usuario_id)->first();

                    if($evaluacion){
                        $detalles_notas = DetalleEvaluacion::select('nombre', 'nota')
                           ->where('evaluacion_id','=',$evaluacion->id)
                        ->count();

                        $notas = ['nota' => $evaluacion->total, 'total' => $detalles_notas*10, 'porcentaje' => $evaluacion->porcentaje];
                    }else{
                        $notas = ['nota' => '', 'total' => '', 'porcentaje' => ''];
                    }

                }else{
                    $notas = ['nota' => '', 'total' => '', 'porcentaje' => ''];
                }
                
            }else{
                $notas = '';
            }

            $pasos = Paso::where('academia_id',$clase_grupal->academia_id)
                ->where('especialidad_id',$especialidad_id)
            ->get();

            if($especialidad_id != 1){
                return view('progreso.programacion-salsa')->with(['clase_1' => $clase_1, 'clase_2' => $clase_2, 'clase_3' => $clase_3, 'clase_4' => $clase_4, 'clase_5' => $clase_5, 'clase_6' => $clase_6, 'clase_7' => $clase_7, 'clase_8' => $clase_8, 'clase_9' => $clase_9, 'clase_10' => $clase_10, 'clase_11' => $clase_11, 'clase_12' => $clase_12, 'notas' => $notas, 'id' => $id, 'pasos' => $pasos, 'permisos' => $permisos]); 
            }else{
                return view('progreso.programacion-bachata')->with(['clase_1' => $clase_1, 'clase_2' => $clase_2, 'clase_3' => $clase_3, 'clase_4' => $clase_4, 'clase_5' => $clase_5, 'clase_6' => $clase_6, 'clase_7' => $clase_7, 'clase_8' => $clase_8, 'clase_9' => $clase_9, 'clase_10' => $clase_10, 'clase_11' => $clase_11, 'clase_12' => $clase_12, 'notas' => $notas, 'id' => $id, 'pasos' => $pasos, 'permisos' => $permisos]);
            }

            
        }else{
            return redirect("/inicio"); 
        }
    }

    public function progreso($id)
    {
        $usuario_id = Session::get('easydance_usuario_id');
    	$find = InscripcionClaseGrupal::where('clase_grupal_id', $id)->where('alumno_id',$usuario_id)->first();

    	if($find){

            $academia = Academia::find(Auth::user()->academia_id);

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
    			
    		}
    		else{

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

            $examen = Examen::where('clase_grupal_id',$id)->first();
            $evaluacion_array = array();

            if($examen){

                $evaluaciones = Evaluacion::where('alumno_id',$usuario_id)->where('examen_id',$examen->id)->get();
                $i = 1;

                foreach($evaluaciones as $evaluacion){

                    $evaluacion_array[$i] = intval($evaluacion->porcentaje);
                    $i++;
                    
                }
            }

	        return view('progreso.progreso')->with(['clase_1' => $clase_1, 'clase_2' => $clase_2, 'clase_3' => $clase_3, 'clase_4' => $clase_4, 'clase_5' => $clase_5, 'clase_6' => $clase_6, 'clase_7' => $clase_7, 'clase_8' => $clase_8, 'clase_9' => $clase_9, 'clase_10' => $clase_10, 'clase_11' => $clase_11, 'clase_12' => $clase_12, 'id' => $id, 'academia' => $academia, 'evaluaciones' => $evaluacion_array]);

        }else{
       		return redirect("progreso"); 
       	}
        
    
    }

    public function certificado()
    {

        $academia = Academia::find(Auth::user()->academia_id);
        $usuario_id = Session::get('easydance_usuario_id');

        $id = $_GET['id'];
        $tipo = $_GET['tipo'];

        $find = InscripcionClaseGrupal::where('clase_grupal_id', $id)->where('alumno_id',$usuario_id)->first();

        if($find){

            $progreso = Progreso::where('clase_grupal_id',$id)->first();

            if($progreso){
                if($tipo == 1){
                    $clase = Progreso::where('clase_grupal_id',$id)->where('tipo',3)->first();

                    if($clase){

                        if($clase->clase_4){
                            return view('progreso.certificado')->with(['certificado' => 'basico.jpg', 'academia' => $academia, 'nivel' => 'BÁSICO']);
                        }else{
                            return redirect("/inicio"); 
                        }
                    }
                }else if($tipo == 2){
                    $clase = Progreso::where('clase_grupal_id',$id)->where('tipo',6)->first();

                    if($clase){

                        if($clase->clase_4){
                            return view('progreso.certificado')->with(['certificado' => 'intermedio.jpg', 'academia' => $academia, 'nivel' => 'INTERMEDIO']);
                        }else{
                            return redirect("/inicio"); 
                        }
                    }
                }
                else if($tipo == 3){
                    $clase = Progreso::where('clase_grupal_id',$id)->where('tipo',9)->first();

                    if($clase){

                        if($clase->clase_4){
                           return view('progreso.certificado')->with(['certificado' => 'avanzado.jpg', 'academia' => $academia, 'nivel' => 'AVANZADO']);
                        }else{
                            return redirect("/inicio"); 
                        }
                    }
                }
                else if($tipo == 4){
                    $clase = Progreso::where('clase_grupal_id',$id)->where('tipo',12)->first();

                    if($clase){

                        if($clase->clase_4){
                            return view('progreso.certificado')->with(['certificado' => 'master.jpg', 'academia' => $academia, 'nivel' => 'MASTER']);
                        }else{
                            return redirect("/inicio"); 
                        }
                    }
                }else{
                    return redirect("/inicio"); 
                }
                
            }else{
                return redirect("/inicio"); 
            }

        }else{
            return redirect("/inicio"); 
        }
    }

    public function updatePaso(Request $request)
    {
        $paso = ProgresoPaso::where('clase_grupal_id',$request->clase_grupal_id)->where('codigo',$request->id)->first();

        if(!$paso){
            $paso = new ProgresoPaso;
            $paso->clase_grupal_id = $request->clase_grupal_id;
            $paso->codigo = $request->id;
        }

        $paso->status = $request->valor;

        if($paso->save()){
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
            
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
        }

    }

    public function principal_pasos(){

        $pasos = Paso::join('config_especialidades', 'pasos.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_niveles_baile', 'pasos.nivel_id', '=', 'config_niveles_baile.id')
            ->select('pasos.*','config_niveles_baile.nombre as nivel', 'config_especialidades.nombre as especialidad')
            ->where('pasos.academia_id', Auth::user()->academia_id)
        ->get();

        return view('configuracion.herramientas.pasos.principal')->with(['pasos' => $pasos, 'config_especialidades' => ConfigEspecialidades::all(), 'config_niveles' => ConfigNiveles::where('academia_id', null)->get()]);

    }

    public function agregar_paso(Request $request)
    {

        $rules = [
            'nombre' => 'required|min:3|max:50',
            'especialidad_id' => 'required',
            'nivel_id' => 'required',
            'ciclo' => 'required',
            'link_video' => 'required|active_url',
        ];

        $messages = [

            'nombre.required' => 'Ups! El Nombre es requerido ',
            'nombre.min' => 'El mínimo de caracteres permitidos son 3',
            'nombre.max' => 'El máximo de caracteres permitidos son 50',
            'especialidad_id.required' => 'Ups! La especialidad es requerida',
            'nivel_id.required' => 'Ups! El nivel es requerido',
            'ciclo.required' => 'Ups! El ciclo es requerido',
            'link_video.required' => 'Ups! La URL es requerida',
            'link_video.active_url' => 'Ups! La URL no es valida',
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

            $paso = new Paso;

            $nombre = title_case($request->nombre);

            $paso->academia_id = Auth::user()->academia_id;
            $paso->nombre = $nombre;
            $paso->especialidad_id = $request->especialidad_id;
            $paso->nivel_id = $request->nivel_id;
            $paso->ciclo = $request->ciclo;
            $paso->link_video = $request->link_video;

            if($paso->save()){

                $especialidad = ConfigEspecialidades::find($request->especialidad_id);
                $nivel = ConfigNiveles::find($request->nivel_id);
             
                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'paso' => $paso, 'especialidad' => $especialidad->nombre, 'nivel' => $nivel->nombre, 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function eliminar_paso($id)
    {
        $permisos = ProgresoPaso::where('codigo',$id)->delete();
        $paso = Paso::find($id);
        
        if($paso->delete()){
            return response()->json(['mensaje' => '¡Excelente! El correo ha sido eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

}