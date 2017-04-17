<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Taller;
use App\ClaseGrupal;
use App\ClasePersonalizada;
use App\Cita;
use App\ConfigClasesPersonalizadas;
use App\Fiesta;
use App\Transmision;
use App\User;
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

        if(Auth::user()->usuario_tipo == 1 || Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6)
        {

        	$talleres=Taller::where('academia_id', '=' ,  Auth::user()->academia_id)
                ->where('talleres.fecha_inicio', '>=', Carbon::now()->format('Y-m-d'))
            ->get();

        	foreach ($talleres as $taller) {
        		$fecha_start=explode('-',$taller['fecha_inicio']);
        		$fecha_end=explode('-',$taller['fecha_final']);
        		$id=$taller['id'];
        		$nombre=$taller['nombre'];
        		$descripcion=$taller['descripcion'];
        		$hora_inicio=$taller['hora_inicio'];
        		$hora_final=$taller['hora_final'];
        		$etiqueta=$taller['color_etiqueta'];

        		$dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);

        		$df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

        		$arrayTalleres[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/talleres/operaciones/".$id);

    			$c=0;

    			
    			while($dt->timestamp<$df->timestamp){
    				$fecha="";
    				$fecha=$dt->addWeek()->toDateString();
    				$arrayTalleres[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/talleres/operaciones/".$id);
    				$c++;
    			}

    		}

    		$clasegrupal = ClaseGrupal::join('config_clases_grupales', 'config_clases_grupales.id', '=', 'clases_grupales.clase_grupal_id')
                    ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                    ->join('config_especialidades', 'config_especialidades.id', '=', 'clases_grupales.especialidad_id')
                    ->join('config_niveles_baile', 'config_niveles_baile.id', '=', 'clases_grupales.nivel_baile_id')
                    ->select('clases_grupales.*', 'config_clases_grupales.nombre', 'config_clases_grupales.descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id', 'instructores.sexo', 'config_especialidades.nombre as especialidad', 'config_niveles_baile.nombre as nivel')
                    ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
                    ->where('clases_grupales.deleted_at', '=', null)
            ->get();

            $horarios_clasegrupal = ClaseGrupal::join('config_clases_grupales', 'config_clases_grupales.id', '=', 'clases_grupales.clase_grupal_id')
                    ->join('horario_clase_grupales', 'clases_grupales.id', '=', 'horario_clase_grupales.clase_grupal_id')
                    ->join('config_especialidades', 'config_especialidades.id', '=', 'horario_clase_grupales.especialidad_id')
                    ->join('config_niveles_baile', 'config_niveles_baile.id', '=', 'clases_grupales.nivel_baile_id')
                    ->join('instructores', 'horario_clase_grupales.instructor_id', '=', 'instructores.id')
                    ->select('clases_grupales.fecha_final', 'horario_clase_grupales.fecha as fecha_inicio', 'horario_clase_grupales.hora_inicio', 'horario_clase_grupales.hora_final', 'clases_grupales.color_etiqueta as clase_etiqueta', 'horario_clase_grupales.color_etiqueta', 'config_clases_grupales.nombre', 'config_clases_grupales.descripcion', 'clases_grupales.id', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id', 'instructores.sexo', 'config_especialidades.nombre as especialidad', 'config_niveles_baile.nombre as nivel')
                    ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
                    ->where('clases_grupales.deleted_at', '=', null)
                    ->where('horario_clase_grupales.deleted_at', '=', null)
            ->get();

        	foreach ($clasegrupal as $clase) {
        		$fecha_start=explode('-',$clase->fecha_inicio);
        		$fecha_end=explode('-',$clase->fecha_final);

                $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
                $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

                if($dt <= Carbon::now()){
                    $nombre_principal = $clase->nombre;
                }else{
                    $nombre_principal = $clase->nombre . ' ★'; 
                }


        		$nombre=$nombre_principal;
        		$descripcion=$clase->descripcion;
        		$hora_inicio=$clase->hora_inicio;
        		$hora_final=$clase->hora_final;
                $fecha_inicio = $dt->toDateString();
                $fecha_final = $df->toDateString();
                $instructor = $clase->instructor_nombre . ' ' .$clase->instructor_apellido;
                $sexo = $clase->sexo;
                $especialidad = $clase->especialidad;
                $nivel = $clase->nivel;
                $instructor_usuario = User::where('usuario_id',$clase->instructor_id)->where('usuario_tipo',3)->first();                
                
                if($instructor_usuario->imagen){
                    $imagen = $instructor_usuario->imagen;
                }else{
                    $imagen = '';
                }

                $id=$instructor."!".$especialidad."!".$nivel."!".$imagen."!".$sexo;

                if($clase->color_etiqueta){
                    $etiqueta=$clase->color_etiqueta;
                }else{
                    $etiqueta=$clase->clase_etiqueta;
                }

        		$arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$fecha_inicio,"fecha_final"=>$fecha_final, "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-grupales/operaciones/".$clase->id);

    			$c=0;

    			
    			while($dt->timestamp<$df->timestamp){
                    $nombre = $clase->nombre;
    				$fecha="";
    				$fecha=$dt->addWeek()->toDateString();

                    $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', $fecha)
                        ->where('fecha_final', '>=', $fecha)
                        ->where('tipo_id', $id)
                        ->where('tipo', 1)
                    ->first();

                    if(!$horario_bloqueado){

                        $arrayClases[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-grupales/operaciones/".$clase->id);
                    }else{
                        if($horario_bloqueado->boolean_mostrar == 1)
                        {
                            $arrayClases[]=array("id"=>$id,"nombre"=>"CANCELADA","descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$horario_bloqueado->id."!".$horario_bloqueado->razon_cancelacion."!".$instructor."!".$fecha_inicio." - ".$fecha_final."!".$hora_inicio." - ".$hora_final."!".$imagen."!".$sexo);
                         }
                    }
    				
    				$c++;
    			}

    		}

            foreach ($horarios_clasegrupal as $clase) {
                $fecha_start=explode('-',$clase->fecha_inicio);
                $fecha_end=explode('-',$clase->fecha_final);

                $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
                $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

                $nombre=$clase->nombre;
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
                $instructor_usuario = User::where('usuario_id',$clase->instructor_id)->where('usuario_tipo',3)->first();           
                
                if($instructor_usuario->imagen){
                    $imagen = $instructor_usuario->imagen;
                }else{
                    $imagen = '';
                }

                $id=$instructor."!".$especialidad."!".$nivel."!".$imagen."!".$sexo;

                $fecha_inicio = $dt->toDateString();
                $fecha_final = $df->toDateString();

                $arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-grupales/operaciones/".$clase->id);

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

                        $arrayClases[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-grupales/operaciones/".$clase->id);
                    }else{
                        if($horario_bloqueado->boolean_mostrar == 1)
                        {
                            $arrayClases[]=array("id"=>$id,"nombre"=>"CANCELADA","descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$horario_bloqueado->id."!".$horario_bloqueado->razon_cancelacion."!".$instructor."!".$fecha_inicio." - ".$fecha_final."!".$hora_inicio." - ".$hora_final."!".$imagen."!".$sexo);
                         }
                    }
                    $c++;
                }

            }

            $config_clases_personalizadas = ConfigClasesPersonalizadas::where('academia_id',Auth::user()->academia_id)->first();

    		$clasespersonalizadas = ClasePersonalizada::join('inscripcion_clase_personalizada', 'clases_personalizadas.id', '=', 'inscripcion_clase_personalizada.clase_personalizada_id')
    				->join('alumnos', 'alumnos.id', '=', 'inscripcion_clase_personalizada.alumno_id')
                    ->join('config_especialidades', 'config_especialidades.id', '=', 'inscripcion_clase_personalizada.especialidad_id')
                    ->join('instructores', 'instructores.id', '=', 'inscripcion_clase_personalizada.instructor_id')
                    ->select('clases_personalizadas.color_etiqueta', 'alumnos.nombre', 'alumnos.apellido', 'inscripcion_clase_personalizada.*', 'config_especialidades.nombre as especialidad', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_personalizadas.nombre as clase_personalizada_nombre', 'instructores.id as instructor_id')
                    ->where('clases_personalizadas.academia_id', '=' ,  Auth::user()->academia_id)
                    ->where('clases_personalizadas.deleted_at', '=', null)
                    ->where('inscripcion_clase_personalizada.estatus', '=', 1)
                    ->where('inscripcion_clase_personalizada.fecha_inicio', '>=', Carbon::now()->format('Y-m-d'))
            ->get();

            $horarios_clasespersonalizadas = ClasePersonalizada::join('inscripcion_clase_personalizada', 'clases_personalizadas.id', '=', 'inscripcion_clase_personalizada.clase_personalizada_id')
                    ->join('horarios_clases_personalizadas', 'inscripcion_clase_personalizada.id', '=', 'horarios_clases_personalizadas.clase_personalizada_id')
                    ->join('config_especialidades', 'config_especialidades.id', '=', 'horarios_clases_personalizadas.especialidad_id')
                    ->join('instructores', 'instructores.id', '=', 'horarios_clases_personalizadas.instructor_id')
                    ->join('alumnos', 'alumnos.id', '=', 'inscripcion_clase_personalizada.alumno_id')
                    ->select('inscripcion_clase_personalizada.fecha_final', 'horarios_clases_personalizadas.fecha as fecha_inicio', 'horarios_clases_personalizadas.hora_inicio', 'horarios_clases_personalizadas.hora_final', 'clases_personalizadas.color_etiqueta as clase_etiqueta', 'horarios_clases_personalizadas.color_etiqueta', 'clases_personalizadas.nombre', 'clases_personalizadas.descripcion', 'inscripcion_clase_personalizada.id', 'alumnos.nombre', 'alumnos.apellido', 'config_especialidades.nombre as especialidad', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_personalizadas.nombre as clase_personalizada_nombre', 'instructores.id as instructor_id')
                    ->where('clases_personalizadas.academia_id', '=' ,  Auth::user()->academia_id)
                    ->where('clases_personalizadas.deleted_at', '=', null)
                    ->where('inscripcion_clase_personalizada.estatus', '=', 1)
                    ->where('horarios_clases_personalizadas.fecha', '>=', Carbon::now()->format('Y-m-d'))
            ->get();


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
                $instructor_usuario = User::where('usuario_id',$clasepersonalizada->instructor_id)->where('usuario_tipo',3)->first(); 
                

                if($instructor_usuario->imagen){
                    $imagen = $instructor_usuario->imagen;
                }else{
                    $imagen = '';
                }

                $id=$instructor."!".$especialidad."!".$clase_personalizada_nombre."!".$imagen."!".$sexo;

        		$arrayClasespersonalizadas[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-personalizadas/agenda/".$clasepersonalizada->id);

    			$c=0;
    			
    			while($dt->timestamp<$df->timestamp){
    				$fecha="";
    				$fecha=$dt->addWeek()->toDateString();
    				$arrayClasespersonalizadas[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-personalizadas/agenda/".$clasepersonalizada->id);
    				$c++;
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
                $instructor_usuario = User::where('usuario_id',$clasepersonalizada->instructor_id)->where('usuario_tipo',3)->first(); 
                
                if($instructor_usuario->imagen){
                    $imagen = $instructor_usuario->imagen;
                }else{
                    $imagen = '';
                }

                $id=$instructor."!".$especialidad."!".$clase_personalizada_nombre."!".$imagen."!".$sexo;

                $arrayClasespersonalizadas[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-personalizadas/agenda/".$clasepersonalizada->id);

                $c=0;
                
                while($dt->timestamp<$df->timestamp){
                    $fecha="";
                    $fecha=$dt->addWeek()->toDateString();
                    $arrayClasespersonalizadas[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-personalizadas/agenda/".$clasepersonalizada->id);
                    $c++;
                }

            }

    		$fiestas = Fiesta::where('fiestas.academia_id', '=' ,  Auth::user()->academia_id)
                ->where('fiestas.deleted_at', '=', null)
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

        		$arrayFiestas[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/fiestas/operaciones/".$id);

    			$c=0;
    			
    			while($dt->timestamp<$df->timestamp){
    				$fecha="";
    				$fecha=$dt->addWeek()->toDateString();
    				$arrayFiestas[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/fiestas/operaciones/".$id);
    				$c++;
    			}

    		}

            $citas = Cita::join('alumnos', 'citas.alumno_id', '=', 'alumnos.id')
                ->join('instructores', 'citas.instructor_id', '=', 'instructores.id')
                ->join('config_citas', 'citas.tipo_id', '=', 'config_citas.id')
                ->select('alumnos.nombre as alumno_nombre', 'alumnos.apellido as alumno_apellido', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','citas.hora_inicio','citas.hora_final', 'citas.id', 'citas.fecha', 'citas.tipo_id', 'config_citas.nombre as nombre', 'citas.color_etiqueta', 'instructores.id as instructor_id')
                ->where('citas.academia_id','=', Auth::user()->academia_id)
                ->where('citas.estatus','=','1')
                ->where('citas.boolean_mostrar','=','2')
                ->where('citas.fecha', '>=', Carbon::now()->format('Y-m-d'))
            ->get();

            foreach ($citas as $cita) {
                $fecha_start=explode('-',$cita->fecha);
                $fecha_end=explode('-',$cita->fecha);

                $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
                $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

                
                $nombre = $cita->alumno_nombre . ' ' . $cita->alumno_apellido;
                $descripcion=$cita->nombre;
                $hora_inicio=$cita->hora_inicio;
                $hora_final=$cita->hora_final;
                $etiqueta=$cita->color_etiqueta;
                $etiqueta=$cita->color_etiqueta;
                $instructor = $cita->instructor_nombre . ' ' .$cita->instructor_apellido;

                $instructor_usuario = User::where('usuario_id',$cita->instructor_id)->where('usuario_tipo',3)->first(); 
                
                if($instructor_usuario->imagen){
                    $imagen = $instructor_usuario->imagen;
                }else{
                    $imagen = '';
                }

                $id=$instructor."!".$descripcion."!".$imagen."!".$sexo;

                $arrayCitas[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/citas/operaciones/".$cita->id);

            }

            $transmisiones = Transmision::where('academia_id', Auth::user()->academia_id)->get();

            return view('agendar.index')->with(['talleres' => $arrayTalleres, 'clases_grupales' => $arrayClases, 'clases_personalizadas' => $arrayClasespersonalizadas, 'fiestas' => $arrayFiestas, 'citas' => $arrayCitas, 'transmisiones' => $transmisiones]);

        }

        // ALUMNO AGENDAR
        else{


            $talleres = DB::table('talleres')
                // ->join('inscripcion_taller', 'inscripcion_taller.taller_id', '=', 'talleres.id')
                ->select('talleres.*')
                // ->where('inscripcion_taller.alumno_id', Auth::user()->usuario_id)
                ->where('talleres.deleted_at', '=', null)
            ->get();

            foreach ($talleres as $taller) {

                $fecha_start=explode('-',$taller->fecha_inicio);
                $fecha_end=explode('-',$taller->fecha_final);
                $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
                $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

                $id=$taller->id;
                $nombre=$taller->nombre;
                $descripcion=$taller->descripcion;
                $hora_inicio=$taller->hora_inicio;
                $hora_final=$taller->hora_final;
                $etiqueta=$taller->color_etiqueta;

                $arrayTalleres[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/talleres/progreso/".$id);

                $c=0;

                
                while($dt->timestamp<$df->timestamp){
                    $fecha="";
                    $fecha=$dt->addWeek()->toDateString();
                    $arrayTalleres[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/talleres/progreso/".$id);
                    $c++;
                }

            }

            // $clases_grupales=ClaseGrupal::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

            
            $clasegrupal = DB::table('config_clases_grupales')
                    ->join('clases_grupales', 'config_clases_grupales.id', '=', 'clases_grupales.clase_grupal_id')
                    ->select('clases_grupales.*', 'config_clases_grupales.nombre', 'config_clases_grupales.descripcion')
                    ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
                    ->where('clases_grupales.deleted_at', '=', null)
            ->get();

            $horarios_clasegrupal = DB::table('config_clases_grupales')
                    ->join('clases_grupales', 'config_clases_grupales.id', '=', 'clases_grupales.clase_grupal_id')
                    ->join('horario_clase_grupales', 'clases_grupales.id', '=', 'horario_clase_grupales.clase_grupal_id')
                    ->select('clases_grupales.fecha_final', 'horario_clase_grupales.fecha as fecha_inicio', 'horario_clase_grupales.hora_inicio', 'horario_clase_grupales.hora_final', 'clases_grupales.color_etiqueta as clase_etiqueta', 'horario_clase_grupales.color_etiqueta', 'config_clases_grupales.nombre', 'config_clases_grupales.descripcion', 'clases_grupales.id')
                    ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
                    ->where('horario_clase_grupales.deleted_at', '=', null)
            ->get();


            foreach ($clasegrupal as $clase) {

                $fecha_start=explode('-',$clase->fecha_inicio);
                $fecha_end=explode('-',$clase->fecha_final);
                $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
                $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

                $id=$clase->id;
                $nombre=$clase->nombre;
                $descripcion=$clase->descripcion;
                $hora_inicio=$clase->hora_inicio;
                $hora_final=$clase->hora_final;
                $etiqueta=$clase->color_etiqueta;

                $arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-grupales/progreso/".$id);

                $c=0;

                
                while($dt->timestamp<$df->timestamp){
                    $fecha="";
                    $fecha=$dt->addWeek()->toDateString();
                    $arrayClases[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-grupales/progreso/".$id);
                    $c++;
                }

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
                $etiqueta=$clase->color_etiqueta;

                $arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-grupales/progreso/".$id);

                $c=0;

                
                while($dt->timestamp<$df->timestamp){
                    $fecha="";
                    $fecha=$dt->addWeek()->toDateString();
                    $arrayClases[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-grupales/progreso/".$id);
                    $c++;
                }

            }

            $config_clases_personalizadas = ConfigClasesPersonalizadas::where('academia_id',Auth::user()->academia_id)->first();

            $clasespersonalizadas = DB::table('clases_personalizadas')
                    ->join('inscripcion_clase_personalizada', 'clases_personalizadas.id', '=', 'inscripcion_clase_personalizada.clase_personalizada_id')
                    ->join('alumnos', 'alumnos.id', '=', 'inscripcion_clase_personalizada.alumno_id')
                    ->select('clases_personalizadas.color_etiqueta', 'clases_personalizadas.nombre', 'inscripcion_clase_personalizada.*')
                    ->where('inscripcion_clase_personalizada.alumno_id', '=' ,  Auth::user()->usuario_id)
                    ->where('clases_personalizadas.deleted_at', '=', null)
                    ->where('inscripcion_clase_personalizada.estatus', '=', 1)
            ->get();

            $horarios_clasespersonalizadas = DB::table('clases_personalizadas')
                ->join('inscripcion_clase_personalizada', 'clases_personalizadas.id', '=', 'inscripcion_clase_personalizada.clase_personalizada_id')
                ->join('horarios_clases_personalizadas', 'inscripcion_clase_personalizada.id', '=', 'horarios_clases_personalizadas.clase_personalizada_id')
                ->join('alumnos', 'alumnos.id', '=', 'inscripcion_clase_personalizada.alumno_id')
                ->select('clases_personalizadas.color_etiqueta', 'alumnos.nombre', 'alumnos.apellido', 'inscripcion_clase_personalizada.fecha')
                   ->select('inscripcion_clase_personalizada.fecha_final', 'horarios_clases_personalizadas.fecha as fecha_inicio', 'horarios_clases_personalizadas.hora_inicio', 'horarios_clases_personalizadas.hora_final', 'clases_personalizadas.color_etiqueta as clase_etiqueta', 'horarios_clases_personalizadas.color_etiqueta', 'clases_personalizadas.nombre', 'clases_personalizadas.descripcion', 'inscripcion_clase_personalizada.id', 'alumnos.nombre', 'alumnos.apellido')
                ->where('inscripcion_clase_personalizada.alumno_id', '=' ,  Auth::user()->usuario_id)
                ->where('clases_personalizadas.deleted_at', '=', null)
                ->where('inscripcion_clase_personalizada.estatus', '=', 1)
            ->get();

            foreach ($clasespersonalizadas as $clasepersonalizada) {
                $fecha_start=explode('-',$clasepersonalizada->fecha_inicio);
                $fecha_end=explode('-',$clasepersonalizada->fecha_final);
                $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
                $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

                $id=$clasepersonalizada->id;
                $nombre= 'Clase Personalizada ' . $clasepersonalizada->nombre;
                $descripcion=$config_clases_personalizadas->descripcion;
                $hora_inicio=$clasepersonalizada->hora_inicio;
                $hora_final=$clasepersonalizada->hora_final;
                $etiqueta=$clasepersonalizada->color_etiqueta;

                $arrayClasespersonalizadas[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-personalizadas/progreso/".Auth::user()->academia_id);

                $c=0;
                
                while($dt->timestamp<$df->timestamp){
                    $fecha="";
                    $fecha=$dt->addWeek()->toDateString();
                    $arrayClasespersonalizadas[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-personalizadas/progreso/".Auth::user()->academia_id);
                    $c++;
                }

            }

            foreach ($horarios_clasespersonalizadas as $clasepersonalizada) {
                $fecha_start=explode('-',$clasepersonalizada->fecha_inicio);
                $fecha_end=explode('-',$clasepersonalizada->fecha_final);
                $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
                $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

                $id=$clasepersonalizada->id;
                $nombre= 'Clase P ' . $clasepersonalizada->nombre . ' ' . $clasepersonalizada->apellido;
                $descripcion=$config_clases_personalizadas->descripcion;
                $hora_inicio=$clasepersonalizada->hora_inicio;
                $hora_final=$clasepersonalizada->hora_final;
                if($clasepersonalizada->color_etiqueta){
                    $etiqueta=$clasepersonalizada->color_etiqueta;
                }else{
                    $etiqueta=$clasepersonalizada->clase_etiqueta;
                }

                $arrayClasespersonalizadas[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-personalizadas/progreso/".Auth::user()->academia_id);

                $c=0;
                
                while($dt->timestamp<$df->timestamp){
                    $fecha="";
                    $fecha=$dt->addWeek()->toDateString();
                    $arrayClasespersonalizadas[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-personalizadas/progreso/".Auth::user()->academia_id);
                    $c++;
                }

            }

            $fiestas = DB::table('fiestas')
                    ->select('fiestas.*')
                    ->where('fiestas.academia_id', '=' ,  Auth::user()->academia_id)
                    ->where('fiestas.deleted_at', '=', null)
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

                $arrayFiestas[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/fiestas/progreso/".$id);

                $c=0;
                
                while($dt->timestamp<$df->timestamp){
                    $fecha="";
                    $fecha=$dt->addWeek()->toDateString();
                    $arrayFiestas[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/fiestas/progreso/".$id);
                    $c++;
                }

            }

            return view('vista_alumno.agendar')->with(['talleres' => $arrayTalleres, 'clases_grupales' => $arrayClases, 'clases_personalizadas' => $arrayClasespersonalizadas, 'fiestas' => $arrayFiestas]);
        }
    	

    }

    public function store(Request $request)
	{
		//dd($request->all());
		/*$date = Carbon::now($request->getStart);
 		$date = $date->format('l jS \\of F Y h:i:s A');
 		echo $date;*/

 		$fecha =explode("GMT", $request->getStart);

 		$dt = new \DateTime($fecha[0]); // <== instance from another API
		$fecha_carbon = Carbon::instance($dt);
		//echo get_class($carbon);                               // 'Carbon\Carbon'
		//echo $carbon->format('d-m-Y'); 

	    //return redirect('home/dashboard'); 
	    $fecha_inicio= $fecha_carbon->format('d-m-Y');

        //dd($fecha_inicio);

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

        $dt = new \DateTime($fecha[0]); // <== instance from another API
        $fecha_carbon = Carbon::instance($dt);
        //echo get_class($carbon);                               // 'Carbon\Carbon'
        //echo $carbon->format('d-m-Y'); 

        //return redirect('home/dashboard'); 
        $fecha_inicio = $fecha_carbon->format('d/m/Y');

        Session::put('fecha_inicio', $fecha_inicio);

        return response()->json(['mensaje' => '¡Excelente! El Alumno se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);

    }
}
