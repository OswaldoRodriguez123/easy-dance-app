<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Taller;
use App\HorarioClaseGrupal;
use App\ClaseGrupal;
use App\InscripcionClaseGrupal;
use App\Alumno;
use App\ClasePersonalizada;
use App\InscripcionClasePersonalizada;
use App\Cita;
use App\ConfigClasesPersonalizadas;
use App\Fiesta;
use App\Transmision;
use App\Instructor;
use App\User;
use App\Asistencia;
use App\Academia;
use DB;

use Carbon\Carbon;

use Redirect;

use Session;

use App\HorarioBloqueado;

use Illuminate\Support\Facades\Auth;

class AgendarController extends BaseController
{

    public function index()
    {
        $arrayTalleres=array();
        $arrayClases=array();
        $arrayClasespersonalizadas=array();
        $arrayFiestas=array();
        $arrayCitas=array();
        $arrayTransmisiones=array();

        $usuario_tipo = Session::get('easydance_usuario_tipo');
        $usuario_id = Session::get('easydance_usuario_id');
        $academia = Academia::find(Auth::user()->academia_id);

    	$talleres = Taller::leftJoin('instructores', 'talleres.instructor_id', '=', 'instructores.id')
            ->join('config_especialidades', 'config_especialidades.id', '=', 'talleres.especialidad_id')
            ->select('talleres.*', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id', 'instructores.sexo', 'config_especialidades.nombre as especialidad')
            ->where('talleres.academia_id', '=' ,  Auth::user()->academia_id)
            ->where('talleres.fecha_inicio', '>=', Carbon::now()->toDateString())
        ->get();

        $horarios_talleres = Taller::join('horarios_talleres', 'talleres.id', '=', 'horarios_talleres.taller_id')
            ->leftJoin('instructores', 'horarios_talleres.instructor_id', '=', 'instructores.id')
            ->join('config_especialidades', 'config_especialidades.id', '=', 'horarios_talleres.especialidad_id')
            ->select('talleres.id','horarios_talleres.fecha as fecha_inicio', 'horarios_talleres.hora_inicio', 'horarios_talleres.hora_final', 'talleres.color_etiqueta as taller_etiqueta', 'horarios_talleres.color_etiqueta', 'talleres.nombre', 'talleres.descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id', 'instructores.sexo', 'config_especialidades.nombre as especialidad')
            ->where('talleres.academia_id', '=' ,  Auth::user()->academia_id)
            ->where('talleres.fecha_inicio', '>=', Carbon::now()->toDateString())
        ->get();

    	foreach ($talleres as $taller) {

    		$fecha_start=explode('-',$taller->fecha_inicio);
            $fecha_end=explode('-',$taller->fecha_final);

            $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
            $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

            $nombre = $taller->nombre;
            $descripcion=$taller->descripcion;
            $hora_inicio=$taller->hora_inicio;
            $hora_final=$taller->hora_final;
            $fecha_inicio = $dt->toDateString();
            $fecha_final = $df->toDateString();
            $etiqueta=$taller->color_etiqueta;
            $instructor = $taller->instructor_nombre . ' ' .$taller->instructor_apellido;
            $sexo = $taller->sexo;
            $especialidad = $taller->especialidad;
            $instructor_imagen = Instructor::find($taller->instructor_id);      
            $instructor_id = $taller->instructor_id;         
            
            if($instructor_imagen){
                if($instructor_imagen->imagen){
                    $imagen = $instructor_imagen->imagen;
                }else{
                    $imagen = '';
                }
            }else{
                $imagen = '';
            }

            $id=$instructor."!".$especialidad."!".$imagen."!".$sexo."!".$hora_inicio. ' - ' .$hora_final;

            $fecha_inicio = $dt->toDateString();
            $fecha_final = $df->toDateString();

            if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){
                $url = "/agendar/talleres/detalle/".$taller->id;
            }else{
                $url = "/agendar/talleres/progreso/".$taller->id;
            }

            if($academia->tipo_horario == 2){
                $hora_inicio_tooltip = Carbon::createFromFormat('H:i:s',$taller->hora_inicio)->toTimeString();
                $hora_final_tooltip = Carbon::createFromFormat('H:i:s',$taller->hora_final)->toTimeString();
            }else{
                $hora_inicio_tooltip = Carbon::createFromFormat('H:i:s',$taller->hora_inicio)->format('g:i a');
                $hora_final_tooltip = Carbon::createFromFormat('H:i:s',$taller->hora_final)->format('g:i a');
            }

            $arrayTalleres[] = array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url, "hora_inicio_tooltip"=>$hora_inicio_tooltip, 'hora_final_tooltip'=>$hora_final_tooltip, 'instructor_id' => $instructor_id);
		}

        foreach ($horarios_talleres as $taller) {

            $fecha_start=explode('-',$taller->fecha_inicio);
            $fecha_end=explode('-',$taller->fecha_final);

            $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);

            $nombre = $taller->nombre;
            $descripcion=$taller->descripcion;
            $hora_inicio=$taller->hora_inicio;
            $hora_final=$taller->hora_final;
            $fecha_inicio = $dt->toDateString();
            $fecha_final = $dt->toDateString();
            $etiqueta=$taller->color_etiqueta;
            $instructor = $taller->instructor_nombre . ' ' .$taller->instructor_apellido;
            $sexo = $taller->sexo;
            $especialidad = $taller->especialidad;
            $instructor_imagen = Instructor::find($taller->instructor_id);   
            $instructor_id = $taller->instructor_id;            
            
            if($instructor_imagen){
                if($instructor_imagen->imagen){
                    $imagen = $instructor_imagen->imagen;
                }else{
                    $imagen = '';
                }
            }else{
                $imagen = '';
            }

            $id=$instructor."!".$especialidad."!".$imagen."!".$sexo."!".$hora_inicio. ' - ' .$hora_final;

            $fecha_inicio = $dt->toDateString();
            $fecha_final = $df->toDateString();

            if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){
                $url = "/agendar/talleres/detalle/".$taller->id;
            }else{
                $url = "/agendar/talleres/progreso/".$taller->id;
            }

            if($academia->tipo_horario == 2){
                $hora_inicio_tooltip = Carbon::createFromFormat('H:i:s',$taller->hora_inicio)->toTimeString();
                $hora_final_tooltip = Carbon::createFromFormat('H:i:s',$taller->hora_final)->toTimeString();
            }else{
                $hora_inicio_tooltip = Carbon::createFromFormat('H:i:s',$taller->hora_inicio)->format('g:i a');
                $hora_final_tooltip = Carbon::createFromFormat('H:i:s',$taller->hora_final)->format('g:i a');
            }

            $arrayTalleres[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url, "hora_inicio_tooltip"=>$hora_inicio_tooltip, 'hora_final_tooltip'=>$hora_final_tooltip, 'instructor_id' => $instructor_id);

            
        }

		$clasegrupal = ClaseGrupal::join('config_clases_grupales', 'config_clases_grupales.id', '=', 'clases_grupales.clase_grupal_id')
            ->leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->join('config_especialidades', 'config_especialidades.id', '=', 'clases_grupales.especialidad_id')
            ->join('config_niveles_baile', 'config_niveles_baile.id', '=', 'clases_grupales.nivel_baile_id')
            ->select('clases_grupales.*', 'config_clases_grupales.nombre', 'config_clases_grupales.descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.sexo', 'config_especialidades.nombre as especialidad', 'config_niveles_baile.nombre as nivel')
            ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
            // ->where('clases_grupales.fecha_inicio', '<=', Carbon::now()->toDateString())
            ->where('clases_grupales.fecha_final', '>=', Carbon::now()->toDateString())
        ->get();

        $horarios_clasegrupal = HorarioClaseGrupal::join('clases_grupales', 'clases_grupales.id', '=', 'horarios_clases_grupales.clase_grupal_id')
            ->join('config_clases_grupales', 'config_clases_grupales.id', '=', 'clases_grupales.clase_grupal_id')
            ->join('config_especialidades', 'config_especialidades.id', '=', 'horarios_clases_grupales.especialidad_id')
            ->join('config_niveles_baile', 'config_niveles_baile.id', '=', 'clases_grupales.nivel_baile_id')
            ->leftJoin('instructores', 'horarios_clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('clases_grupales.id', 'clases_grupales.fecha_final', 'clases_grupales.cantidad_hombres','clases_grupales.cantidad_mujeres', 'horarios_clases_grupales.fecha as fecha_inicio', 'horarios_clases_grupales.hora_inicio', 'horarios_clases_grupales.hora_final', 'clases_grupales.color_etiqueta as clase_etiqueta', 'horarios_clases_grupales.color_etiqueta', 'config_clases_grupales.nombre', 'config_clases_grupales.descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'horarios_clases_grupales.instructor_id', 'instructores.sexo', 'config_especialidades.nombre as especialidad', 'config_niveles_baile.nombre as nivel')
            ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
            ->where('clases_grupales.deleted_at', '=', null)
            // ->where('clases_grupales.fecha_inicio', '<=', Carbon::now()->toDateString())
            ->where('clases_grupales.fecha_final', '>=', Carbon::now()->toDateString())
        ->get();

        foreach ($clasegrupal as $clase) {


    		$fecha_start=explode('-',$clase->fecha_inicio);
    		$fecha_end=explode('-',$clase->fecha_final);

            $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
            $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

            $nombre_principal = '';

            if($dt <= Carbon::now()){

                $cantidad_hombres = InscripcionClaseGrupal::join('alumnos', 'alumnos.id', '=', 'inscripcion_clase_grupal.alumno_id')
                ->where('alumnos.sexo','M')
                    ->where('inscripcion_clase_grupal.clase_grupal_id',$clase->id)
                ->count();

                $cantidad_mujeres = InscripcionClaseGrupal::join('alumnos', 'alumnos.id', '=', 'inscripcion_clase_grupal.alumno_id')
                    ->where('alumnos.sexo','F')
                    ->where('inscripcion_clase_grupal.clase_grupal_id',$clase->id)
                ->count();

                if($clase->cantidad_hombres <= $cantidad_hombres && $clase->cantidad_mujeres <= $cantidad_mujeres){
                    $nombre_principal = 'AGOTADA';
                }else{
                    $nombre_principal = $clase->nombre;
                }

                $inicio = 1;

            }else{
                
                $nombre_principal = $clase->nombre . ' ???'; 
                $inicio = 0;
            }
          

    		$nombre=$nombre_principal;
            $nombre_clase = $clase->nombre;
    		$descripcion=$clase->descripcion;
    		$hora_inicio=$clase->hora_inicio;
    		$hora_final=$clase->hora_final;
            $fecha_inicio = $dt->toDateString();
            $fecha_final = $df->toDateString();
            $instructor = $clase->instructor_nombre . ' ' .$clase->instructor_apellido;
            $sexo = $clase->sexo;
            $especialidad = $clase->especialidad;
            $nivel = $clase->nivel;
            $instructor_imagen = Instructor::find($clase->instructor_id);
            $instructor_id = $clase->instructor_id;               
            
            if($instructor_imagen){
                if($instructor_imagen->imagen){
                    $imagen = $instructor_imagen->imagen;
                }else{
                    $imagen = '';
                }
            }else{
                $imagen = '';
            }

            $id=$instructor."!".$especialidad."!".$nivel."!".$imagen."!".$sexo."!".$hora_inicio. ' - ' .$hora_final;

            if($clase->color_etiqueta){
                $etiqueta=$clase->color_etiqueta;
            }else{
                $etiqueta=$clase->clase_etiqueta;
            }
 

            if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){
                $url = "/agendar/clases-grupales/detalle/".$clase->id;
            }else{
                $url = "/agendar/clases-grupales/progreso/".$clase->id;
            }

            if($academia->tipo_horario == 2){
                $hora_inicio_tooltip = Carbon::createFromFormat('H:i:s',$clase->hora_inicio)->toTimeString();
                $hora_final_tooltip = Carbon::createFromFormat('H:i:s',$clase->hora_final)->toTimeString();
            }else{
                $hora_inicio_tooltip = Carbon::createFromFormat('H:i:s',$clase->hora_inicio)->format('g:i a');
                $hora_final_tooltip = Carbon::createFromFormat('H:i:s',$clase->hora_final)->format('g:i a');
            }

    		$arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$fecha_inicio,"fecha_final"=>$fecha_final, "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url, 'inicio' => $inicio, "nombre_clase" => $nombre_clase, "hora_inicio_tooltip"=>$hora_inicio_tooltip, 'hora_final_tooltip'=>$hora_final_tooltip, 'instructor_id' => $instructor_id);
			
			while($dt->timestamp<$df->timestamp){
                $nombre = $clase->nombre;
				$fecha="";
				$fecha=$dt->addWeek()->toDateString();

                $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', $fecha)
                    ->where('fecha_final', '>=', $fecha)
                    ->where('tipo_id', $clase->id)
                    ->where('tipo', 1)
                ->first();

                if(!$horario_bloqueado){

                    $arrayClases[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url, "nombre_clase" => $nombre_clase, "hora_inicio_tooltip"=>$hora_inicio_tooltip, 'hora_final_tooltip'=>$hora_final_tooltip, 'instructor_id' => $instructor_id);
                }else{
                    if($horario_bloqueado->boolean_mostrar == 1)
                    {
                        $arrayClases[]=array("id"=>$clase->id,"nombre"=>"CANCELADA","descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$horario_bloqueado->id."!".$horario_bloqueado->razon_cancelacion."!".$instructor."!".$fecha_inicio." - ".$fecha_final."!".$hora_inicio." - ".$hora_final."!".$imagen."!".$sexo, "nombre_clase" => $nombre_clase, "hora_inicio_tooltip"=>$hora_inicio_tooltip, 'hora_final_tooltip'=>$hora_final_tooltip, 'instructor_id' => $instructor_id);
                     }
                }
			}
		}

        foreach ($horarios_clasegrupal as $clase) {

            $fecha_start=explode('-',$clase->fecha_inicio);
            $fecha_end=explode('-',$clase->fecha_final);

            $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
            $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

            $nombre_principal = '';

            $cantidad_hombres = InscripcionClaseGrupal::join('alumnos', 'alumnos.id', '=', 'inscripcion_clase_grupal.alumno_id')
            ->where('alumnos.sexo','M')
                ->where('inscripcion_clase_grupal.clase_grupal_id',$clase->id)
            ->count();

            $cantidad_mujeres = InscripcionClaseGrupal::join('alumnos', 'alumnos.id', '=', 'inscripcion_clase_grupal.alumno_id')
                ->where('alumnos.sexo','F')
                ->where('inscripcion_clase_grupal.clase_grupal_id',$clase->id)
            ->count();

            if($clase->cantidad_hombres <= $cantidad_hombres && $clase->cantidad_mujeres <= $cantidad_mujeres){
                $nombre_principal = 'AGOTADA';
            }else{
                $nombre_principal = $clase->nombre;
            }
            
            $nombre=$nombre_principal;
            $nombre_clase = $clase->nombre;
            $descripcion=$clase->descripcion;
            $hora_inicio=$clase->hora_inicio;
            $hora_final=$clase->hora_final;
            $fecha_inicio = $dt->toDateString();
            $fecha_final = $df->toDateString();
            $etiqueta=$clase->color_etiqueta;
            $instructor = $clase->instructor_nombre . ' ' .$clase->instructor_apellido;
            $sexo = $clase->sexo;
            $especialidad = $clase->especialidad;
            $nivel = $clase->nivel;
            $instructor_imagen = Instructor::find($clase->instructor_id); 
            $instructor_id = $clase->instructor_id;              
            
            if($instructor_imagen){
                if($instructor_imagen->imagen){
                    $imagen = $instructor_imagen->imagen;
                }else{
                    $imagen = '';
                }
            }else{
                $imagen = '';
            }

            $id=$instructor."!".$especialidad."!".$nivel."!".$imagen."!".$sexo."!".$hora_inicio. ' - ' .$hora_final;

            $fecha_inicio = $dt->toDateString();
            $fecha_final = $df->toDateString();

            if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){
                $url = "/agendar/clases-grupales/detalle/".$clase->id;
            }else{
                $url = "/agendar/clases-grupales/progreso/".$clase->id;
            }

            if($academia->tipo_horario == 2){
                $hora_inicio_tooltip = Carbon::createFromFormat('H:i:s',$clase->hora_inicio)->toTimeString();
                $hora_final_tooltip = Carbon::createFromFormat('H:i:s',$clase->hora_final)->toTimeString();
            }else{
                $hora_inicio_tooltip = Carbon::createFromFormat('H:i:s',$clase->hora_inicio)->format('g:i a');
                $hora_final_tooltip = Carbon::createFromFormat('H:i:s',$clase->hora_final)->format('g:i a');
            }

            $arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url, "nombre_clase" => $nombre_clase, "hora_inicio_tooltip"=>$hora_inicio_tooltip, 'hora_final_tooltip'=>$hora_final_tooltip, 'instructor_id' => $instructor_id);

            while($dt->timestamp<$df->timestamp){
                $fecha="";
                $fecha=$dt->addWeek()->toDateString();

                $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', $fecha)
                    ->where('fecha_final', '>=', $fecha)
                    ->where('tipo_id', $clase->id)
                    ->where('tipo', 1)
                ->first();

                 if(!$horario_bloqueado){

                    $arrayClases[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url, "nombre_clase" => $nombre_clase, "hora_inicio_tooltip"=>$hora_inicio_tooltip, 'hora_final_tooltip'=>$hora_final_tooltip, 'instructor_id' => $instructor_id);
                }else{
                    if($horario_bloqueado->boolean_mostrar == 1)
                    {
                        $arrayClases[]=array("id"=>$clase->id,"nombre"=>"CANCELADA","descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$horario_bloqueado->id."!".$horario_bloqueado->razon_cancelacion."!".$instructor."!".$fecha_inicio." - ".$fecha_final."!".$hora_inicio." - ".$hora_final."!".$imagen."!".$sexo, "nombre_clase" => $nombre_clase, "hora_inicio_tooltip"=>$hora_inicio_tooltip, 'hora_final_tooltip'=>$hora_final_tooltip, 'instructor_id' => $instructor_id);
                     }
                }
            }
        }

        $config_clases_personalizadas = ConfigClasesPersonalizadas::where('academia_id',Auth::user()->academia_id)->first();

		$query = InscripcionClasePersonalizada::join('clases_personalizadas', 'clases_personalizadas.id', '=', 'inscripcion_clase_personalizada.clase_personalizada_id')
			->join('alumnos', 'alumnos.id', '=', 'inscripcion_clase_personalizada.alumno_id')
            ->join('config_especialidades', 'config_especialidades.id', '=', 'inscripcion_clase_personalizada.especialidad_id')
            ->leftJoin('instructores', 'instructores.id', '=', 'inscripcion_clase_personalizada.instructor_id')
            ->select('inscripcion_clase_personalizada.*','clases_personalizadas.color_etiqueta', 'alumnos.nombre', 'alumnos.apellido', 'alumnos.correo', 'alumnos.celular', 'alumnos.telefono', 'config_especialidades.nombre as especialidad', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_personalizadas.nombre as clase_personalizada_nombre', 'instructores.id as instructor_id', 'instructores.sexo')
            ->where('clases_personalizadas.academia_id', '=' ,  Auth::user()->academia_id)
            ->where('inscripcion_clase_personalizada.fecha_inicio', '>=', Carbon::now()->toDateString());

        if($usuario_tipo == 2 || $usuario_tipo == 4){
            $query->where('inscripcion_clase_personalizada.alumno_id', '=', $usuario_id);
        }

        $clasespersonalizadas = $query->get();

        $query = InscripcionClasePersonalizada::join('clases_personalizadas', 'clases_personalizadas.id', '=', 'inscripcion_clase_personalizada.clase_personalizada_id')
            ->join('horarios_clases_personalizadas', 'inscripcion_clase_personalizada.id', '=', 'horarios_clases_personalizadas.clase_personalizada_id')
            ->join('config_especialidades', 'config_especialidades.id', '=', 'horarios_clases_personalizadas.especialidad_id')
            ->leftJoin('instructores', 'instructores.id', '=', 'horarios_clases_personalizadas.instructor_id')
            ->join('alumnos', 'alumnos.id', '=', 'inscripcion_clase_personalizada.alumno_id')
            ->select('inscripcion_clase_personalizada.fecha_final', 'horarios_clases_personalizadas.fecha as fecha_inicio', 'horarios_clases_personalizadas.hora_inicio', 'horarios_clases_personalizadas.hora_final', 'clases_personalizadas.color_etiqueta as clase_etiqueta', 'horarios_clases_personalizadas.color_etiqueta', 'clases_personalizadas.nombre', 'clases_personalizadas.descripcion', 'inscripcion_clase_personalizada.id', 'alumnos.nombre', 'alumnos.apellido', 'alumnos.correo', 'alumnos.celular', 'alumnos.telefono', 'config_especialidades.nombre as especialidad', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_personalizadas.nombre as clase_personalizada_nombre', 'instructores.id as instructor_id', 'instructores.sexo')
            ->where('clases_personalizadas.academia_id', '=' ,  Auth::user()->academia_id)
            ->where('horarios_clases_personalizadas.fecha', '>=', Carbon::now()->toDateString());

        if($usuario_tipo == 2 || $usuario_tipo == 4){
            $query->where('inscripcion_clase_personalizada.alumno_id', '=', $usuario_id);
        }

        $horarios_clasespersonalizadas = $query->get();

    	foreach ($clasespersonalizadas as $clasepersonalizada) {

    		$fecha_start=explode('-',$clasepersonalizada->fecha_inicio);
    		$fecha_end=explode('-',$clasepersonalizada->fecha_inicio);
            $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
            $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

    		$nombre= 'Clase P ' . $clasepersonalizada->nombre . ' ' . $clasepersonalizada->apellido;
    		$descripcion=$config_clases_personalizadas->descripcion;
    		$hora_inicio=$clasepersonalizada->hora_inicio;
    		$hora_final=$clasepersonalizada->hora_final;
    		$etiqueta=$clasepersonalizada->color_etiqueta;
            $instructor = $clasepersonalizada->instructor_nombre . ' ' .$clasepersonalizada->instructor_apellido;
            $especialidad = $clasepersonalizada->especialidad;    
            $clase_personalizada_nombre = $clasepersonalizada->clase_personalizada_nombre;
            $sexo = $clasepersonalizada->sexo;
            $instructor_imagen = Instructor::find($clasepersonalizada->instructor_id); 
            $instructor_id = $clasepersonalizada->instructor_id;              
            
            if($instructor_imagen){
                if($instructor_imagen->imagen){
                    $imagen = $instructor_imagen->imagen;
                }else{
                    $imagen = '';
                }
            }else{
                $imagen = '';
            }

            if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){
                $url = "/agendar/clases-personalizadas/detalle/".$clasepersonalizada->id;
            }else{
                $url  = "/agendar/clases-personalizadas/progreso/".Auth::user()->academia_id;
            }

            $id=$instructor."!".$especialidad."!".$clase_personalizada_nombre."!".$imagen."!".$sexo."!".$hora_inicio. ' - ' .$hora_final;

            $asistencia = Asistencia::where('tipo',3)->where('tipo_id',$clasepersonalizada->id)->where('fecha',$dt->toDateString());

            if($academia->tipo_horario == 2){
                $hora_inicio_tooltip = Carbon::createFromFormat('H:i:s',$clasepersonalizada->hora_inicio)->toTimeString();
                $hora_final_tooltip = Carbon::createFromFormat('H:i:s',$clasepersonalizada->hora_final)->toTimeString();
            }else{
                $hora_inicio_tooltip = Carbon::createFromFormat('H:i:s',$clasepersonalizada->hora_inicio)->format('g:i a');
                $hora_final_tooltip = Carbon::createFromFormat('H:i:s',$clasepersonalizada->hora_final)->format('g:i a');
            }

            // if(!$asistencia){
                $arrayClasespersonalizadas[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url, "hora_inicio_tooltip"=>$hora_inicio_tooltip, 'hora_final_tooltip'=>$hora_final_tooltip, 'instructor_id' => $instructor_id, 'correo' => $clasepersonalizada->correo, 'telefono' => $clasepersonalizada->telefono, 'celular' => $clasepersonalizada->celular);
            // }
			
			while($dt->timestamp<$df->timestamp){
				$fecha="";
				$fecha=$dt->addWeek()->toDateString();
				$arrayClasespersonalizadas[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url, "hora_inicio_tooltip"=>$hora_inicio_tooltip, 'hora_final_tooltip'=>$hora_final_tooltip, 'instructor_id' => $instructor_id, 'correo' => $clasepersonalizada->correo, 'telefono' => $clasepersonalizada->telefono, 'celular' => $clasepersonalizada->celular);
			}
		}

        foreach ($horarios_clasespersonalizadas as $clasepersonalizada) {

            $fecha_start=explode('-',$clasepersonalizada->fecha_inicio);
            $fecha_end=explode('-',$clasepersonalizada->fecha_inicio);
            $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
            $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

            $nombre= 'Clase P ' . $clasepersonalizada->nombre . ' ' . $clasepersonalizada->apellido;
            $descripcion=$config_clases_personalizadas->descripcion;
            $hora_inicio=$clasepersonalizada->hora_inicio;
            $hora_final=$clasepersonalizada->hora_final;
            if($clasepersonalizada->color_etiqueta){
                $etiqueta=$clasepersonalizada->color_etiqueta;
            }else{
                $etiqueta=$clasepersonalizada->clase_etiqueta;
            }
            $instructor = $clasepersonalizada->instructor_nombre . ' ' .$clasepersonalizada->instructor_apellido;
            $especialidad = $clasepersonalizada->especialidad;    
            $clase_personalizada_nombre = $clasepersonalizada->clase_personalizada_nombre;
            $sexo = $clasepersonalizada->sexo;
            $instructor_imagen = Instructor::find($clasepersonalizada->instructor_id);     
            $instructor_id = $clasepersonalizada->instructor_id;          
            
            if($instructor_imagen){
                if($instructor_imagen->imagen){
                    $imagen = $instructor_imagen->imagen;
                }else{
                    $imagen = '';
                }
            }else{
                $imagen = '';
            }

            $id=$instructor."!".$especialidad."!".$clase_personalizada_nombre."!".$imagen."!".$sexo."!".$hora_inicio. ' - ' .$hora_final;

            if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){
                $url = "/agendar/clases-personalizadas/detalle/".$clasepersonalizada->id;
            }else{
                $url  = "/agendar/clases-personalizadas/progreso/".Auth::user()->academia_id;
            }

            $asistencia = Asistencia::where('tipo',3)->where('tipo_id',$clasepersonalizada->id)->where('fecha',$dt->toDateString());

            if($academia->tipo_horario == 2){
                $hora_inicio_tooltip = Carbon::createFromFormat('H:i:s',$clasepersonalizada->hora_inicio)->toTimeString();
                $hora_final_tooltip = Carbon::createFromFormat('H:i:s',$clasepersonalizada->hora_final)->toTimeString();
            }else{
                $hora_inicio_tooltip = Carbon::createFromFormat('H:i:s',$clasepersonalizada->hora_inicio)->format('g:i a');
                $hora_final_tooltip = Carbon::createFromFormat('H:i:s',$clasepersonalizada->hora_final)->format('g:i a');
            }

            // if(!$asistencia){
                $arrayClasespersonalizadas[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url, "hora_inicio_tooltip"=>$hora_inicio_tooltip, 'hora_final_tooltip'=>$hora_final_tooltip, 'instructor_id' => $instructor_id, 'correo' => $clasepersonalizada->correo, 'telefono' => $clasepersonalizada->telefono, 'celular' => $clasepersonalizada->celular);
            // }

            while($dt->timestamp<$df->timestamp){
                $fecha="";
                $fecha=$dt->addWeek()->toDateString();
                $arrayClasespersonalizadas[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url, "hora_inicio_tooltip"=>$hora_inicio_tooltip, 'hora_final_tooltip'=>$hora_final_tooltip, 'instructor_id' => $instructor_id, 'correo' => $clasepersonalizada->correo, 'telefono' => $clasepersonalizada->telefono, 'celular' => $clasepersonalizada->celular);
            }

        }

		$fiestas = Fiesta::where('fiestas.academia_id', '=' ,  Auth::user()->academia_id)
            ->where('fiestas.fecha_inicio', '>=', Carbon::now()->format('Y-m-d'))
        ->get();

    	foreach ($fiestas as $fiesta) {
    		$fecha_start=explode('-',$fiesta->fecha_inicio);
    		$fecha_end=explode('-',$fiesta->fecha_final);

            $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
            $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

    		$id=$fiesta->id;
    		$nombre= $fiesta->nombre;
    		$descripcion=$fiesta->descripcion;
    		$hora_inicio=$fiesta->hora_inicio;
    		$hora_final=$fiesta->hora_final;
    		$etiqueta=$fiesta->color_etiqueta;

            if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){
                $url = "/agendar/fiestas/detalle/".$fiesta->id;
            }else{
                $url = "/agendar/fiestas/progreso/".$fiesta->id;
            }

            if($academia->tipo_horario == 2){
                $hora_inicio_tooltip = Carbon::createFromFormat('H:i:s',$fiesta->hora_inicio)->toTimeString();
                $hora_final_tooltip = Carbon::createFromFormat('H:i:s',$fiesta->hora_final)->toTimeString();
            }else{
                $hora_inicio_tooltip = Carbon::createFromFormat('H:i:s',$fiesta->hora_inicio)->format('g:i a');
                $hora_final_tooltip = Carbon::createFromFormat('H:i:s',$fiesta->hora_final)->format('g:i a');
            }

    		$arrayFiestas[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url, "hora_inicio_tooltip"=>$hora_inicio_tooltip, 'hora_final_tooltip'=>$hora_final_tooltip, 'instructor_id' => 0);

			while($dt->timestamp<$df->timestamp){
				$fecha="";
				$fecha=$dt->addWeek()->toDateString();
				$arrayFiestas[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url, "hora_inicio_tooltip"=>$hora_inicio_tooltip, 'hora_final_tooltip'=>$hora_final_tooltip, 'instructor_id' => 0);
			}

		}

        $query = Cita::join('alumnos', 'citas.alumno_id', '=', 'alumnos.id')
            ->leftJoin('instructores', 'citas.instructor_id', '=', 'instructores.id')
            ->join('config_citas', 'citas.tipo_id', '=', 'config_citas.id')
            ->select('citas.*','alumnos.nombre as alumno_nombre', 'alumnos.apellido as alumno_apellido', 'alumnos.id as alumno_id', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'config_citas.nombre as nombre', 'instructores.id as instructor_id', 'instructores.sexo')
            ->where('citas.academia_id','=', Auth::user()->academia_id)
            ->where('citas.estatus','=','1')
            ->where('citas.fecha', '>=', Carbon::now()->format('Y-m-d'));

        if($usuario_tipo == 2 || $usuario_tipo == 4){
            $query->where('citas.alumno_id', '=', $usuario_id);
        }else{
            $query->where('citas.boolean_mostrar','=','2');
        }

        $citas = $query->get();

        foreach ($citas as $cita) {

            if($cita->tipo_id != 5){
                $nombre = $cita->alumno_nombre . ' ' . $cita->alumno_apellido;
            }else{
                $nombre = $cita->alumno_nombre . ' ' . $cita->alumno_apellido . ' ???'; 
            }

            $fecha_start=explode('-',$cita->fecha);
            $fecha_end=explode('-',$cita->fecha);

            $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
            $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);
            
            $descripcion=$cita->nombre;
            $hora_inicio=$cita->hora_inicio;
            $hora_final=$cita->hora_final;
            $etiqueta=$cita->color_etiqueta;
            $etiqueta=$cita->color_etiqueta;
            $instructor = $cita->instructor_nombre . ' ' .$cita->instructor_apellido;
            $sexo = $cita->sexo;
            $instructor_imagen = Instructor::find($cita->instructor_id);  
            $instructor_id = $cita->instructor_id;             
            
            if($instructor_imagen){
                if($instructor_imagen->imagen){
                    $imagen = $instructor_imagen->imagen;
                }else{
                    $imagen = '';
                }
            }else{
                $imagen = '';
            }


            $alumno = Alumno::withTrashed()->find($cita->alumno_id);

            if($alumno){
                if($alumno->tipo_pago == 1){
                    $tipo_pago = 'Contado';
                }else if($alumno->tipo_pago == 2){
                    $tipo_pago = 'Credito';
                }else{
                    $tipo_pago = 'Sin Confirmar';
                }
            }else{
                $tipo_pago = '';
            }

            $id=$instructor."!".$descripcion."!".$imagen."!".$sexo."!".$hora_inicio. ' - ' .$hora_final."!".$tipo_pago;

            if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){
                $url = "/agendar/citas/detalle/".$cita->id;
            }else{
                $url = "";
            }

            if($academia->tipo_horario == 2){
                $hora_inicio_tooltip = Carbon::createFromFormat('H:i:s',$cita->hora_inicio)->toTimeString();
                $hora_final_tooltip = Carbon::createFromFormat('H:i:s',$cita->hora_final)->toTimeString();
            }else{
                $hora_inicio_tooltip = Carbon::createFromFormat('H:i:s',$cita->hora_inicio)->format('g:i a');
                $hora_final_tooltip = Carbon::createFromFormat('H:i:s',$cita->hora_final)->format('g:i a');
            }

            $arrayCitas[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url, "hora_inicio_tooltip"=>$hora_inicio_tooltip, 'hora_final_tooltip'=>$hora_final_tooltip, 'instructor_id' => $instructor_id);

        }

        $transmisiones = Transmision::where('academia_id', Auth::user()->academia_id)->where('fecha', '>=', Carbon::now()->format('Y-m-d'))->get();

        foreach ($transmisiones as $transmision) {

            $fecha=explode('-',$transmision->fecha);
            $fecha = Carbon::createFromFormat('Y-m-d', $transmision->fecha)->toDateString();
            $tema=$transmision->tema;
            $hora=$transmision->hora;
            $presentador=$transmision->presentador;
            $etiqueta=$transmision->color_etiqueta;

            $id=$tema."!".$fecha."!".$hora."!".$presentador;

            if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){
                $url = "/agendar/transmisiones/detalle/".$transmision->id;
            }else{
                $url = "";
            }

            if($academia->tipo_horario == 2){
                $hora_tooltip = Carbon::createFromFormat('H:i:s',$transmision->hora)->toTimeString();
            }else{
                $hora_tooltip = Carbon::createFromFormat('H:i:s',$transmision->hora)->format('g:i a');
            }

            $arrayTransmisiones[]=array("id"=>$id,"nombre"=>'Transmisi??n', "fecha"=> $fecha, "hora"=>$hora, "etiqueta"=>$etiqueta,"url"=>$url, "hora_tooltip"=>$hora_tooltip, 'instructor_id' => 0);
        }

        $instructores = Instructor::where('academia_id',Auth::user()->academia_id)->get();

        return view('agendar.index')->with(['talleres' => $arrayTalleres, 'clases_grupales' => $arrayClases, 'clases_personalizadas' => $arrayClasespersonalizadas, 'fiestas' => $arrayFiestas, 'citas' => $arrayCitas, 'transmisiones' => $arrayTransmisiones, 'usuario_tipo' => $usuario_tipo, 'instructores' => $instructores]);

    }

    public function store(Request $request)
	{

 		$fecha =explode("GMT", $request->getStart);
 		$dt = new \DateTime($fecha[0]);
		$fecha_carbon = Carbon::instance($dt);

	    $fecha_inicio= $fecha_carbon->format('d-m-Y');

	    if($request->agendar=="clases-grupales"){
			return redirect('agendar/clases-grupales/agregar')->with('fecha_inicio', $fecha_inicio);
	    }elseif($request->agendar=="clases-personalizadas"){
	    	return redirect('agendar/clases-personalizadas/agregar')->with(compact('fecha_inicio'));
	    }elseif($request->agendar=="talleres"){
	    	return redirect('agendar/talleres/agregar')->with(compact('fecha_inicio'));
	    }elseif($request->agendar=="fiestas-eventos"){
	    	return redirect('agendar/fiestas/agregar')->with(compact('fecha_inicio'));
	    }elseif($request->agendar=="citas"){
            Session::put('boolean_mostrar', 2);
            return redirect('agendar/citas/agregar')->with(compact('fecha_inicio'));
        }elseif($request->agendar=="transmision"){
            return redirect('agendar/transmisiones/agregar')->with(compact('fecha_inicio'));
        }else{
	    	return redirect('agendar');
	    }
	}

    public function guardarFecha(Request $request)
    {

        $fecha =explode("GMT", $request->fecha_inicio);

        $dt = new \DateTime($fecha[0]);
        $fecha_carbon = Carbon::instance($dt);
        $fecha_inicio = $fecha_carbon->format('d/m/Y');

        Session::put('fecha_inicio', $fecha_inicio);

        return response()->json(['mensaje' => '??Excelente! El Alumno se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);

    }
}
