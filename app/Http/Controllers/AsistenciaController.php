<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Academia;

use App\Taller;

use App\ClaseGrupal;

use App\InscripcionClaseGrupal;

use App\HorarioClaseGrupal;

use App\ClasePersonalizada;

use App\HorarioClasePersonalizada;

use App\InscripcionClasePersonalizada;

use App\Asistencia;

use App\AsistenciaInstructor;

use App\AsistenciaStaff;

use App\HorarioStaff;

use App\Instructor;

use App\ConfigPagosInstructor;

use App\PagoInstructor;

use App\Alumno;

use App\Cita;

use App\Staff;

use App\CredencialAlumno;

use App\HorarioBloqueado;

use App\ItemsFacturaProforma;

use App\NotaAdministrativa;

use Carbon\Carbon;

use DB;

use Validator;

use App\User;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Session;

use PulkitJalan\GeoIP\GeoIP;

class AsistenciaController extends BaseController
{

    public function principal()
    {

      $usuario_tipo = Session::get('easydance_usuario_tipo');
      $usuario_id = Session::get('easydance_usuario_id');

      if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
      {
        $alumnos = Alumno::join('asistencias', 'asistencias.alumno_id', '=', 'alumnos.id')
            ->join('clases_grupales', 'asistencias.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('academias', 'asistencias.academia_id', '=', 'academias.id')
            ->select('asistencias.fecha', 'asistencias.hora', 'config_clases_grupales.nombre as clase', 'alumnos.nombre', 'alumnos.apellido', 'asistencias.tipo', 'asistencias.tipo_id', 'asistencias.clase_grupal_id as clase_grupal_id', 'asistencias.id', 'alumnos.id as alumno_id')
            ->where('academias.id','=',Auth::user()->academia_id)
            ->orderBy('asistencias.created_at','desc')
            ->limit(150)
        ->get();

        $clases_personalizadas = Alumno::join('asistencias', 'asistencias.alumno_id', '=', 'alumnos.id')
            ->join('inscripcion_clase_personalizada', 'asistencias.tipo_id', '=', 'inscripcion_clase_personalizada.id')
            ->leftJoin('instructores', 'inscripcion_clase_personalizada.instructor_id', '=', 'instructores.id')
            ->join('clases_personalizadas', 'inscripcion_clase_personalizada.clase_personalizada_id', '=', 'clases_personalizadas.id')
            ->select('asistencias.fecha', 'asistencias.hora', 'clases_personalizadas.nombre as clase', 'alumnos.nombre', 'alumnos.apellido', 'asistencias.tipo', 'asistencias.tipo_id', 'asistencias.id', 'instructores.nombre as nombre_instructor', 'instructores.apellido as apellido_instructor')
            ->where('clases_personalizadas.academia_id','=',Auth::user()->academia_id)
            ->where('asistencias.tipo','=',3)
        ->get();

        $citas = Alumno::join('asistencias', 'asistencias.alumno_id', '=', 'alumnos.id')
            ->join('citas', 'asistencias.tipo_id', '=', 'citas.id')
            ->join('config_citas', 'citas.tipo_id', '=', 'config_citas.id')
            ->leftJoin('instructores', 'citas.instructor_id', '=', 'instructores.id')
            ->select('asistencias.fecha', 'asistencias.hora', 'config_citas.nombre as clase', 'alumnos.nombre', 'alumnos.apellido', 'asistencias.tipo', 'asistencias.tipo_id', 'asistencias.id', 'instructores.nombre as nombre_instructor', 'instructores.apellido as apellido_instructor')
            ->where('citas.academia_id','=',Auth::user()->academia_id)
            ->where('asistencias.tipo','=',4)
        ->get();

        $instructores = AsistenciaInstructor::join('clases_grupales', 'asistencias_instructor.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('academias', 'asistencias_instructor.academia_id', '=', 'academias.id')
            ->leftJoin('instructores', 'asistencias_instructor.instructor_id', '=', 'instructores.id')
            ->select('asistencias_instructor.fecha', 'asistencias_instructor.hora', 'config_clases_grupales.nombre as clase', 'instructores.nombre', 'instructores.apellido', 'asistencias_instructor.hora_salida')
            ->where('academias.id','=',Auth::user()->academia_id)
        ->get();

        $staff = AsistenciaStaff::join('academias', 'asistencias_staff.academia_id', '=', 'academias.id')
            ->join('staff', 'asistencias_staff.staff_id', '=', 'staff.id')
            ->join('config_staff', 'staff.cargo', '=', 'config_staff.id')
            ->select('asistencias_staff.fecha', 'asistencias_staff.hora', 'staff.nombre', 'staff.apellido', 'asistencias_staff.hora_salida', 'config_staff.nombre as cargo')
            ->where('academias.id','=',Auth::user()->academia_id)
        ->get();

        $staffs = Staff::where('academia_id','=',Auth::user()->academia_id)->get();

        $array = array();

        foreach($alumnos as $asistencia){

          if($asistencia->tipo == 1)
          {
            $clasegrupal = ClaseGrupal::find($asistencia->clase_grupal_id);
            if($clasegrupal){
              $instructor = Instructor::find($clasegrupal->instructor_id);
            }
            
          }else{
            $clasegrupal = HorarioClaseGrupal::find($asistencia->tipo_id);
            if($clasegrupal){
              $instructor = Instructor::find($clasegrupal->instructor_id);
            }
          }

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

          if($clasegrupal){

            $collection=collect($asistencia);     
            $asistencia_array = $collection->toArray();
            
            $asistencia_array['dia']=$dia;
            $asistencia_array['nombre']=$instructor->nombre;
            $asistencia_array['apellido']=$instructor->nombre;
            $asistencia_array['hora']=$asistencia->nombre . ' ' . $asistencia->apellido;
            $asistencia_array['hora_salida']=$asistencia->hora;
            $asistencia_array['tipo']='A';
            $array[] = $asistencia_array;
          }
        }

        foreach($clases_personalizadas as $asistencia){

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

          $collection=collect($asistencia);     
          $asistencia_array = $collection->toArray();
          $asistencia_array['dia']=$dia;
          $asistencia_array['hora']=$asistencia->nombre_instructor . ' ' . $instructor->apellido_instructor;
          $asistencia_array['hora_salida']=$asistencia->hora;
          $asistencia_array['tipo']='A';
          $array[] = $asistencia_array;
        }

        foreach($citas as $asistencia){

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

          $collection=collect($asistencia);     
          $asistencia_array = $collection->toArray();
          $asistencia_array['dia']=$dia;
          $asistencia_array['hora']=$asistencia->nombre_instructor . ' ' . $instructor->apellido_instructor;
          $asistencia_array['hora_salida']=$asistencia->hora;
          $asistencia_array['tipo']='A';
          $array[] = $asistencia_array;
        }

        foreach($instructores as $asistencia){

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

          $collection=collect($asistencia);     
          $asistencia_array = $collection->toArray();
          $asistencia_array['dia']=$dia;
          $asistencia_array['tipo']='I';
          $array[] = $asistencia_array;
        }

        foreach($staffs as $staff){

          $horarios = HorarioStaff::join('dias_de_semana', 'horarios_staff.dia_de_semana_id', '=', 'dias_de_semana.id')
            ->select('horarios_staff.*', 'dias_de_semana.nombre as dia')
            ->where('staff_id' , $staff->id)
          ->get();

          foreach($horarios as $horario){

            $entrada_horario = Carbon::createFromFormat('H:i:s', $horario->hora_inicio);
            $salida_horario = Carbon::createFromFormat('H:i:s', $horario->hora_final);

            $fecha_inicio = Carbon::createFromFormat('Y-m-d H:i:s', $staff->created_at)->toDateString();
            $fecha_inicio = Carbon::createFromFormat('Y-m-d H:i:s', $fecha_inicio . " 00:00:00");
            $fecha_final = Carbon::now()->toDateString();
            $fecha_final = Carbon::createFromFormat('Y-m-d H:i:s', $fecha_final . " 00:00:00");

            while($fecha_inicio <= $fecha_final){

              $asistencia = AsistenciaStaff::where('fecha',$fecha_inicio)->where('staff_id',$staff->id)->first();

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

                  $array[] = array('fecha' => $asistencia->fecha, "hora" => $asistencia->hora, 'clase' => '<i class="zmdi zmdi-check c-verde f-15"></i>', 'nombre' => $staff->nombre, 'apellido' => $staff->apellido, 'hora_salida' => $asistencia->hora_salida, 'dia' => $dia, 'tipo' => 'S', 'tipo_asistencia_staff' => 1);

                }else{
                  $array[] = array('fecha' => $asistencia->fecha, "hora" => $asistencia->hora, 'clase' => '<i class="zmdi zmdi-alert-circle-o c-amarillo f-15"></i>', 'nombre' => $staff->nombre, 'apellido' => $staff->apellido, 'hora_salida' => $asistencia->hora_salida, 'dia' => $dia, 'tipo' => 'S', 'tipo_asistencia_staff' => 2);
                }

              }else{
                $array[] = array('fecha' => $fecha_inicio->toDateString(), "hora" => '', 'clase' => '<i class="zmdi zmdi-close c-youtube f-15"></i>', 'nombre' => $staff->nombre, 'apellido' => $staff->apellido, 'hora_salida' => '', 'dia' => $horario->dia, 'tipo' => 'S', 'tipo_asistencia_staff' => 3);
              }

              $fecha_inicio->addWeek();

            }

          }
        }

        return view('asistencia.asistencia')->with(['asistencias' => $array]);  

      }  

      if($usuario_tipo == 2 OR $usuario_tipo == 4){       

        $clases_grupales = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
          ->join('inscripcion_clase_grupal', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'inscripcion_clase_grupal.id')
          ->leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
          ->select('clases_grupales.*', 'config_clases_grupales.nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido')
          ->where('inscripcion_clase_grupal.alumno_id','=',$usuario_id)
        ->get();

        $horarios_clase_grupales = HorarioClaseGrupal::join('clases_grupales', 'horarios_clases_grupales.clase_grupal_id', '=', 'clases_grupales.id')
          ->join('inscripcion_clase_grupal', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'inscripcion_clase_grupal.id')
          ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
          ->leftJoin('instructores', 'horarios_clases_grupales.instructor_id', '=', 'instructores.id')
          ->select('horarios_clases_grupales.*', 'config_clases_grupales.nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido')
          ->where('inscripcion_clase_grupal.alumno_id','=',$usuario_id)
        ->get();

        $alumno_id = $usuario_id;
        $array = array();

        $j = 0;

        foreach($clases_grupales as $clase_grupal){

          $fecha_inicio = Carbon::parse($clase_grupal->fecha_inicio);

          while($fecha_inicio < Carbon::now())
          {
              $fecha_a_comparar = $fecha_inicio;
              $fecha_a_comparar = $fecha_a_comparar->toDateString();
              $asistencia = Asistencia::where('alumno_id',$alumno_id)->where('clase_grupal_id',$clase_grupal->id)->where('fecha',$fecha_a_comparar)->first();
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

              $array[]=array('id' => $j, 'fecha' => $fecha_a_comparar, 'asistio' => $asistio, 'hora' => $hora, 'dia' => $dia, 'clase' => $clase_grupal->nombre, 'instructor' => $clase_grupal->instructor_nombre . ' ' . $clase_grupal->instructor_apellido);

              $fecha_inicio->addWeek();
              $j = $j + 1;
          }
        }

        foreach($horarios_clase_grupales as $horario){

            $fecha_horario = Carbon::parse($horario->fecha);

            while($fecha_horario < Carbon::now()){

                $fecha_a_comparar = $fecha_horario;
                $fecha_a_comparar = $fecha_a_comparar->toDateString();

                $asistencia = Asistencia::where('alumno_id',$alumno_id)
                  ->where('tipo',2)->where('tipo_id',$horario->id)
                  ->where('fecha',$fecha_a_comparar)
                ->first();

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
                $array[]=array('id' => $j, 'fecha' => $fecha_a_comparar, 'asistio' => $asistio, 'hora' => $hora, 'dia' => $dia, 'clase' => $horario->nombre, 'instructor' => $horario->instructor_nombre . ' ' . $horario->instructor_apellido);

                $fecha_horario->addWeek();
                $j = $j + 1;
            }
        }

        return view('vista_alumno.asistencia')->with(['alumnos_asistencia' => $array]); 

      }  

      if($usuario_tipo == 3){       

        $clases_grupales = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
          ->select('clases_grupales.*', 'config_clases_grupales.nombre')
          ->where('clases_grupales.instructor_id','=',$usuario_id)
        ->get();

        $horarios_clase_grupales = HorarioClaseGrupal::join('clases_grupales', 'horarios_clases_grupales.clase_grupal_id', '=', 'clases_grupales.id')
          ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
          ->select('horarios_clases_grupales.*', 'config_clases_grupales.nombre')
          ->where('horarios_clases_grupales.instructor_id','=',$usuario_id)
        ->get();

        $instructor_id = $usuario_id;
        $array = array();

        $j = 0;

        foreach($clases_grupales as $clase_grupal){

          $fecha_inicio = Carbon::parse($clase_grupal->fecha_inicio);

          while($fecha_inicio < Carbon::now()){

              $fecha_a_comparar = $fecha_inicio;
              $fecha_a_comparar = $fecha_a_comparar->toDateString();

              $asistencia = AsistenciaInstructor::where('instructor_id',$instructor_id)
                ->where('clase_grupal_id',$clase_grupal->id)
                ->where('fecha',$fecha_a_comparar)
              ->first();

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

              $array[]=array('id' => $j, 'fecha' => $fecha_a_comparar, 'asistio' => $asistio, 'hora' => $hora, 'dia' => $dia, 'clase' => $clase_grupal->nombre);

              $fecha_inicio->addWeek();
              $j = $j + 1;
          }
        }

        foreach($horarios_clase_grupales as $horario){

            $fecha_horario = Carbon::parse($horario->fecha);

            while($fecha_horario < Carbon::now())
            {
                $fecha_a_comparar = $fecha_horario;
                $fecha_a_comparar = $fecha_a_comparar->toDateString();
                $asistencia = AsistenciaInstructor::where('instructor_id',$instructor_id)->where('tipo',2)->where('tipo_id',$horario->id)->where('fecha',$fecha_a_comparar)->first();
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
                $array[]=array('id' => $j, 'fecha' => $fecha_a_comparar, 'asistio' => $asistio, 'hora' => $hora, 'dia' => $dia, 'clase' => $horario->nombre);

                $fecha_horario->addWeek();
                $j = $j + 1;
            }
        }

        return view('vista_instructor.asistencia')->with(['asistencias' => $array]); 

      }        
    }

	public function generarAsistencia(){

		$array_alumno = array();
      	$array_instructor = array();
      	$array_staff = array();
    
      	$array = array(2,4);

      	$alumnos = Alumno::where('academia_id','=', Auth::user()->academia_id)
			->orderBy('nombre', 'asc')
      	->get();

    	foreach($alumnos as $alumno){

	        $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
	            ->where('usuarios_tipo.tipo_id',$alumno->id)
	            ->whereIn('usuarios_tipo.tipo',$array)
	        ->first();

	        $inscripcion = InscripcionClaseGrupal::join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
    	            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
    	            ->leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
    	            ->select('instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'config_clases_grupales.nombre', 'clases_grupales.fecha_inicio', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final', 'clases_grupales.id')
    	            ->where('inscripcion_clase_grupal.alumno_id', $alumno->id)
    	            ->orderBy('inscripcion_clase_grupal.fecha_inscripcion', 'desc')
    			->first();

			     if($inscripcion){

	            $fecha = Carbon::createFromFormat('Y-m-d', $inscripcion->fecha_inicio);
	            $i = $fecha->dayOfWeek;

	            if($i == 1){

	              	$dia_clase = 'Lunes';

	            }else if($i == 2){

	              	$dia_clase = 'Martes';

	            }else if($i == 3){

	              	$dia_clase = 'Miercoles';

	            }else if($i == 4){

	              	$dia_clase = 'Jueves';

	            }else if($i == 5){

	              	$dia_clase = 'Viernes';

	            }else if($i == 6){

	              	$dia_clase = 'Sabado';

	            }else if($i == 0){

	              	$dia_clase = 'Domingo';

	            }

	            $instructor_clase = $inscripcion->instructor_nombre . ' ' . $inscripcion->instructor_apellido;
	            $nombre_clase = $inscripcion->nombre;
	            $hora_clase = $inscripcion->hora_inicio . ' / ' . $inscripcion->hora_final;

			}else{

	            $instructor_clase = '';
	            $nombre_clase = '';
	            $hora_clase = '';
	            $dia_clase = '';
			}

	        if($usuario){

	        	if($usuario->imagen){
	            	$imagen = $usuario->imagen;
	          	}else{
	            	$imagen = '';
	          	}

	        }else{
	          	$imagen = '';
	        }

	        $collection=collect($alumno);     
	        $alumno_array = $collection->toArray();
	        
	        $alumno_array['nombre_clase']=$nombre_clase;
	        $alumno_array['hora_clase']=$hora_clase;
	        $alumno_array['instructor_clase']=$instructor_clase;
	        $alumno_array['dia_clase']=$dia_clase;
	        $alumno_array['imagen']=$imagen;
	        $array_alumno[$alumno->id] = $alumno_array;


    	}

	    $instructores = Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

	    foreach($instructores as $instructor){

	        $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
	            ->where('usuarios_tipo.tipo',3)
	            ->where('usuarios_tipo.tipo_id',$instructor->id)
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

	        $collection=collect($instructor);     
	        $instructor_array = $collection->toArray();
	            
	        $instructor_array['imagen']=$imagen;
	        $array_instructor[$instructor->id] = $instructor_array;


	    }

	    $staffs = Staff::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

	    foreach($staffs as $staff){

	        $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
	            ->where('usuarios_tipo.tipo',8)
	            ->where('usuarios_tipo.tipo_id',$staff->id)
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

	        $collection=collect($staff);     
	        $staff_array = $collection->toArray();
	            
	        $staff_array['imagen']=$imagen;
	        $array_staff[$staff->id] = $staff_array;


	    }

	    $alumnoc = User::join('alumnos', 'alumnos.id', '=', 'users.usuario_id')
	    	->join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
	        ->select('alumnos.id as id')
	        ->where('users.academia_id','=', Auth::user()->academia_id)
	        ->where('alumnos.deleted_at', '=', null)
	        ->whereIn('usuarios_tipo.tipo', $array)
	        ->where('users.confirmation_token', '!=', null)
	    ->get();

	    $collection=collect($alumnoc);
	    $grouped = $collection->groupBy('id');     
	    $activacion = $grouped->toArray();

	    Session::forget('no_pertenece');
	    Session::forget('boolean_credencial');

	    return view('asistencia.generar')->with(['alumnos' => $array_alumno, 'instructores' => $array_instructor, 'staffs' => $array_staff, 'activacion' => $activacion]);

    }

    private function deuda($id){

      $alumnod = Alumno::join('items_factura_proforma', 'items_factura_proforma.usuario_id', '=', 'alumnos.id')
          ->select('alumnos.id as id', 'items_factura_proforma.importe_neto', 'items_factura_proforma.fecha_vencimiento')
          ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
          ->where('items_factura_proforma.usuario_id', $id)
      ->get();

      if(count($alumnod)>0){
          $collection = collect($alumnod);
          $cuenta=$collection->sum('importe_neto');
      }else{
          $cuenta=0;
      }

      return $cuenta;

    }

    private function credenciales($id){

      $credenciales = CredencialAlumno::where('alumno_id',$id)
        ->where('cantidad' ,'>', 0)
        ->where('fecha_vencimiento','>=', Carbon::now()->toDateString())
      ->sum('cantidad');

      if(!$credenciales){
        $credenciales = 0;
      }

      return $credenciales;
    }

    private function items_factura($id){

      $items_factura = ItemsFacturaProforma::where('usuario_id', '=', $id)->where('usuario_tipo',1)->get();
      $array_items = array();

      foreach($items_factura as $item_factura){

          $fecha_vencimiento = Carbon::createFromFormat('Y-m-d',$item_factura->fecha_vencimiento);

          if($fecha_vencimiento < Carbon::now()){
              $estatus = 0;
          }else{
              $estatus = 1;
          }

          $array_items[] = array(['id' => $item_factura->id, 'item_id' => $item_factura->item_id , 'nombre' => $item_factura->nombre , 'tipo' => $item_factura->tipo, 'cantidad' => $item_factura->cantidad, 'precio_neto' => $item_factura->precio_neto, 'impuesto' => intval($item_factura->impuesto), 'importe_neto' => $item_factura->importe_neto, 'estatus' =>$estatus, 'fecha_vencimiento' => $item_factura->fecha_vencimiento]);
      }

      return $array_items;
    }

    private function notas_administrativas($id){

      $notas_administrativas = NotaAdministrativa::join('users', 'notas_administrativas.usuario_id', '=', 'users.id')
        ->select('notas_administrativas.*', 'users.nombre as usuario')
        ->where('notas_administrativas.alumno_id',$id)
      ->get();

      return $notas_administrativas;

    }

    private function inscripciones($id){

      $inscripciones = InscripcionClaseGrupal::join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
        ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
        ->select('inscripcion_clase_grupal.*' ,'config_clases_grupales.nombre', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final', 'clases_grupales.fecha_inicio')
        ->where('inscripcion_clase_grupal.alumno_id', '=', $id)
        ->where('clases_grupales.fecha_final', '>=', Carbon::now()->toDateString())
        ->where('clases_grupales.deleted_at', '=', null)
      ->get();

      $array = array();

      foreach($inscripciones as $inscripcion){

        $fecha = Carbon::createFromFormat('Y-m-d', $inscripcion->fecha_inicio);
      
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

        $diferencia = Carbon::createFromFormat('Y-m-d',$inscripcion->fecha_pago)->diffInDays(Carbon::now());

        $collection=collect($inscripcion);     
        $inscripcion_array = $collection->toArray();
            
        $inscripcion_array['dia']=$dia;
        $inscripcion_array['diferencia']=$diferencia;
        $array[$inscripcion->id] = $inscripcion_array;
      }

      return $array;
    }

    private function estatus($id){

      //1.0 -- EL MODULO DE CONSULTA DE ESTATUS ESTABLECE QUE LA PRIMERA FECHA DEBE SER LA DE LA CLASE PRINCIPAL, LOS SIGUIENTES DEBEN SER LOS MULTIHORARIOS PARA NO TENER NINGUN PROBLEMA

      //ARRAY DE BUSQUEDA EN ASISTENCIAS

      $inasistencias = 0;

      $tipo_clase = array(1,2);

      $clase_grupal = InscripcionClaseGrupal::join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
          ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
          ->select('clases_grupales.fecha_inicio', 'clases_grupales.fecha_final', 'config_clases_grupales.asistencia_rojo', 'config_clases_grupales.asistencia_amarilla', 'inscripcion_clase_grupal.fecha_inscripcion','inscripcion_clase_grupal.fecha_a_comprobar','clases_grupales.id', 'clases_grupales.instructor_id')
          ->where('inscripcion_clase_grupal.alumno_id', $id)
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
                ->where('alumno_id', $id)
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
            
        }

        // LA CONFIGURACIÓN DE LAS ASISTENCIAS DEBEN ESTAR ESTABLECIDAS PARA QUE LAS CONTABILIZACIONES SE HAGAN (!= 0)

        if($inasistencias >= $asistencia_roja && $asistencia_roja != 0){
          $estatus="c-youtube";
        }else if($inasistencias >= $asistencia_amarilla && $asistencia_amarilla != 0){
          $estatus="c-amarillo";
        }else{
          $estatus="c-verde";
        }
      }else{
          $estatus="";
      }

      return $estatus;
    }

    public function consulta_clase_grupales(Request $request)
    {
      $academia = Academia::find(Auth::user()->academia_id);

      $claseGrupal= ClaseGrupal::join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
        ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
        ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
        ->leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
        ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as nombre', 'config_clases_grupales.descripcion as descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido',  'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.fecha_inicio','clases_grupales.fecha_final', 'clases_grupales.color_etiqueta', 'clases_grupales.id')
        ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
        ->where('clases_grupales.fecha_inicio', '<=', Carbon::now()->toDateString())
        ->where('clases_grupales.fecha_final', '>=', Carbon::now()->toDateString())
      ->get();

      $horarios_clase_grupales= HorarioClaseGrupal::join('config_especialidades', 'horarios_clases_grupales.especialidad_id', '=', 'config_especialidades.id')
          ->join('config_estudios', 'horarios_clases_grupales.estudio_id', '=', 'config_estudios.id')
          ->leftJoin('instructores', 'horarios_clases_grupales.instructor_id', '=', 'instructores.id')
          ->join('clases_grupales', 'horarios_clases_grupales.clase_grupal_id', '=', 'clases_grupales.id')
          ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
          ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as nombre', 'config_clases_grupales.descripcion as descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido',  'config_estudios.nombre as estudio_nombre', 'horarios_clases_grupales.hora_inicio','horarios_clases_grupales.hora_final', 'horarios_clases_grupales.fecha as fecha_inicio','clases_grupales.fecha_final', 'clases_grupales.color_etiqueta', 'clases_grupales.id', 'horarios_clases_grupales.id as horario_id')
          ->where('clases_grupales.deleted_at', '=', null)
          ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
          ->where('clases_grupales.fecha_inicio', '<=', Carbon::now()->toDateString())
          ->where('clases_grupales.fecha_final', '>=', Carbon::now()->toDateString())
        ->get();

      $arrayClaseGrupal=array();

      $fechaActual = Carbon::now();
      $diaActual = $fechaActual->dayOfWeek;
      $collection = collect($claseGrupal);

      foreach ($claseGrupal as $grupal) {

        $fecha_start=explode('-',$grupal->fecha_inicio);
        $fecha_end=explode('-',$grupal->fecha_final);
        $id=$grupal->id;
        $nombre=$grupal->nombre;
        $descripcion=$grupal->descripcion;
        $etiqueta=$grupal->color_etiqueta;
        $instructor=$grupal->instructor_nombre . ' ' . $grupal->instructor_apellido;

        if($academia->tipo_horario == 2){
          $hora_inicio = Carbon::createFromFormat('H:i:s',$grupal->hora_inicio)->toTimeString();
          $hora_final = Carbon::createFromFormat('H:i:s',$grupal->hora_final)->toTimeString();
        }else{
          $hora_inicio = Carbon::createFromFormat('H:i:s',$grupal->hora_inicio)->format('g:i a');
          $hora_final = Carbon::createFromFormat('H:i:s',$grupal->hora_final)->format('g:i a');
        }

        $fecha_inicio = Carbon::createFromFormat('Y-m-d', $grupal->fecha_inicio);
        $dia_de_semana = $fecha_inicio->dayOfWeek;

        if($diaActual==$dia_de_semana){   

          $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', Carbon::now()->toDateString())
            ->where('fecha_final', '>=', Carbon::now()->toDateString())
            ->where('tipo_id', $id)
            ->where('tipo', 1)
          ->first();  

          if(!$horario_bloqueado){
            $bloqueado = 0;

          }else{
            $bloqueado = 1;
          }

          $arrayClaseGrupal[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$grupal->fecha_inicio,"fecha_final"=>$grupal->fecha_final, "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta, "instructor" => $instructor, 'tipo' => 1, 'tipo_id' => $id, 'bloqueado' => $bloqueado);

          }
        }

        foreach ($horarios_clase_grupales as $grupal) {

          $fecha_start=explode('-',$grupal->fecha_inicio);
          $fecha_end=explode('-',$grupal->fecha_final);
          $id=$grupal->id;
          $nombre=$grupal->nombre;
          $descripcion=$grupal->descripcion;
          $etiqueta=$grupal->color_etiqueta;
          $instructor=$grupal->instructor_nombre . ' ' . $grupal->instructor_apellido;

          if($academia->tipo_horario == 2){
            $hora_inicio = Carbon::createFromFormat('H:i:s',$grupal->hora_inicio)->toTimeString();
            $hora_final = Carbon::createFromFormat('H:i:s',$grupal->hora_final)->toTimeString();
          }else{
            $hora_inicio = Carbon::createFromFormat('H:i:s',$grupal->hora_inicio)->format('g:i a');
            $hora_final = Carbon::createFromFormat('H:i:s',$grupal->hora_final)->format('g:i a');
          }

          $fecha_inicio = Carbon::createFromFormat('Y-m-d', $grupal->fecha_inicio);
          $dia_de_semana = $fecha_inicio->dayOfWeek;

          if($diaActual==$dia_de_semana){ 

            $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', Carbon::now()->toDateString())
              ->where('fecha_final', '>=', Carbon::now()->toDateString())
              ->where('tipo_id', $id)
              ->where('tipo', 1)
            ->first();  

            if(!$horario_bloqueado){
              $bloqueado = 0;

            }else{
              $bloqueado = 1;
            }      

            $arrayClaseGrupal[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$grupal->fecha_inicio,"fecha_final"=>$grupal->fecha_final, "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta, "instructor" => $instructor, 'tipo' => 2, 'tipo_id' => $grupal->horario_id, 'bloqueado' => $bloqueado);

          }
        
      }

      usort($arrayClaseGrupal, function($a, $b) {
          return $a['hora_inicio'] > $b['hora_inicio'];
      });

      return response()->json(['status' => 'OK', 'clases_grupales'=>$arrayClaseGrupal, 200]);

    }

    public function consulta_clase_grupales_alumno(Request $request)
    {
      $academia = Academia::find(Auth::user()->academia_id);
    	
      $clases_grupales= ClaseGrupal::join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
        ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
        ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
        ->leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
        ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as nombre', 'config_clases_grupales.descripcion as descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido',  'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.fecha_inicio','clases_grupales.fecha_final', 'clases_grupales.color_etiqueta', 'clases_grupales.id')
        ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
        ->where('clases_grupales.fecha_inicio', '<=', Carbon::now()->toDateString())
        ->where('clases_grupales.fecha_final', '>=', Carbon::now()->toDateString())
      ->get();

      $horarios_clase_grupales= HorarioClaseGrupal::join('config_especialidades', 'horarios_clases_grupales.especialidad_id', '=', 'config_especialidades.id')
        ->join('config_estudios', 'horarios_clases_grupales.estudio_id', '=', 'config_estudios.id')
        ->leftJoin('instructores', 'horarios_clases_grupales.instructor_id', '=', 'instructores.id')
        ->join('clases_grupales', 'horarios_clases_grupales.clase_grupal_id', '=', 'clases_grupales.id')
        ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
        ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as nombre', 'config_clases_grupales.descripcion as descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido',  'config_estudios.nombre as estudio_nombre', 'horarios_clases_grupales.hora_inicio','horarios_clases_grupales.hora_final', 'horarios_clases_grupales.fecha as fecha_inicio','clases_grupales.fecha_final', 'clases_grupales.color_etiqueta', 'clases_grupales.id', 'horarios_clases_grupales.id as horario_id')
        ->where('clases_grupales.deleted_at', '=', null)
        ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
        ->where('clases_grupales.fecha_inicio', '<=', Carbon::now()->toDateString())
        ->where('clases_grupales.fecha_final', '>=', Carbon::now()->toDateString())
      ->get();

	    $arrayClases=array();

      $fechaActual = Carbon::now();
      $diaActual = $fechaActual->dayOfWeek;
      $fecha_actual=$fechaActual->toDateString();

      $collection = collect($clases_grupales);

     	foreach ($clases_grupales as $grupal) {

     		$fecha_start=explode('-',$grupal->fecha_inicio);
     		$fecha_end=explode('-',$grupal->fecha_final);
     		$id=$grupal->id;
     		$nombre=$grupal->nombre;
     		$descripcion=$grupal->descripcion;
     		$etiqueta=$grupal->color_etiqueta;
        $instructor=$grupal->instructor_nombre . ' ' . $grupal->instructor_apellido;

        if($academia->tipo_horario == 2){
          $hora_inicio = Carbon::createFromFormat('H:i:s',$grupal->hora_inicio)->toTimeString();
          $hora_final = Carbon::createFromFormat('H:i:s',$grupal->hora_final)->toTimeString();
        }else{
          $hora_inicio = Carbon::createFromFormat('H:i:s',$grupal->hora_inicio)->format('g:i a');
          $hora_final = Carbon::createFromFormat('H:i:s',$grupal->hora_final)->format('g:i a');
        }

        $fecha_inicio = Carbon::createFromFormat('Y-m-d', $grupal->fecha_inicio);
        $dia_de_semana = $fecha_inicio->dayOfWeek;

        if($diaActual==$dia_de_semana){   	

          $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', Carbon::now()->toDateString())
            ->where('fecha_final', '>=', Carbon::now()->toDateString())
            ->where('tipo_id', $id)
            ->where('tipo', 1)
          ->first();  

          if(!$horario_bloqueado){
            $bloqueado = 0;

          }else{
            $bloqueado = 1;
          } 	

          $asistencia = Asistencia::where('alumno_id',$request->id)
            ->where('clase_grupal_id',$id)
            ->where('fecha',$fecha_actual)
          ->first();

          if(!$asistencia){
            $asistencia = 0;
          }else{
            $asistencia = 1;
          }  

     			$arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$grupal->fecha_inicio,"fecha_final"=>$grupal->fecha_final, "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta, "instructor" => $instructor, 'tipo' => 1, 'tipo_id' => $id, 'bloqueado' => $bloqueado, 'asistencia' => $asistencia);

     	  }
		    
		  }

      foreach ($horarios_clase_grupales as $grupal) {

        $fecha_start=explode('-',$grupal->fecha_inicio);
        $fecha_end=explode('-',$grupal->fecha_final);
        $id=$grupal->id;
        $nombre=$grupal->nombre;
        $descripcion=$grupal->descripcion;
        $etiqueta=$grupal->color_etiqueta;
        $instructor=$grupal->instructor_nombre . ' ' . $grupal->instructor_apellido;

        if($academia->tipo_horario == 2){
          $hora_inicio = Carbon::createFromFormat('H:i:s',$grupal->hora_inicio)->toTimeString();
          $hora_final = Carbon::createFromFormat('H:i:s',$grupal->hora_final)->toTimeString();
        }else{
          $hora_inicio = Carbon::createFromFormat('H:i:s',$grupal->hora_inicio)->format('g:i a');
          $hora_final = Carbon::createFromFormat('H:i:s',$grupal->hora_final)->format('g:i a');
        }

        $fecha_inicio = Carbon::createFromFormat('Y-m-d', $grupal->fecha_inicio);
        $dia_de_semana = $fecha_inicio->dayOfWeek;

        if($diaActual==$dia_de_semana){

          $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', Carbon::now()->toDateString())
            ->where('fecha_final', '>=', Carbon::now()->toDateString())
            ->where('tipo_id', $id)
            ->where('tipo', 1)
          ->first();  

          if(!$horario_bloqueado){
            $bloqueado = 0;
          }else{
            $bloqueado = 1;
          }          

          $asistencia = Asistencia::where('alumno_id',$request->id)
            ->where('clase_grupal_id',$id)
            ->where('fecha',$fecha_actual)
          ->first();

          if(!$asistencia){
            $asistencia = 0;
          }else{
            $asistencia = 1;
          }  

          $arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$grupal->fecha_inicio,"fecha_final"=>$grupal->fecha_final, "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta, "instructor" => $instructor, 'tipo' => 2, 'tipo_id' => $grupal->horario_id, 'bloqueado' => $bloqueado, 'asistencia' => $asistencia);

        }
      }

      usort($arrayClases, function($a, $b) {
          return $a['hora_inicio'] > $b['hora_inicio'];
      });

      $deuda = $this->deuda($request->id);
      $inscripciones = $this->inscripciones($request->id);
      $credenciales = $this->credenciales($request->id);
      $estatus = $this->estatus($request->id);
      $notas_administrativas = $this->notas_administrativas($request->id);
      $items_factura = $this->items_factura($request->id);

		  return response()->json(['status' => 'OK', 'clases_grupales'=>$arrayClases, 'deuda' => $deuda, 'inscripciones' => $inscripciones, 'credenciales' => $credenciales, 'estatus' => $estatus, 'items' => $items_factura, 'notas_administrativas' => $notas_administrativas, 200]);
    	
    }

  public function consulta_clase_personalizadas_alumno(Request $request){

    $academia = Academia::find(Auth::user()->academia_id);

    $clases_personalizadas = InscripcionClasePersonalizada::join('config_especialidades', 'inscripcion_clase_personalizada.especialidad_id', '=', 'config_especialidades.id')
      ->join('clases_personalizadas', 'inscripcion_clase_personalizada.clase_personalizada_id', '=', 'clases_personalizadas.id')
      ->leftJoin('instructores', 'inscripcion_clase_personalizada.instructor_id', '=', 'instructores.id')
      ->select('config_especialidades.nombre as especialidad_nombre', 'clases_personalizadas.nombre as nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','inscripcion_clase_personalizada.hora_inicio','inscripcion_clase_personalizada.hora_final', 'inscripcion_clase_personalizada.id', 'inscripcion_clase_personalizada.fecha_inicio', 'inscripcion_clase_personalizada.boolean_alumno_aceptacion', 'clases_personalizadas.color_etiqueta', 'clases_personalizadas.descripcion')
      ->where('inscripcion_clase_personalizada.alumno_id','=', $request->id)
      ->where('inscripcion_clase_personalizada.fecha_inicio', '>=', Carbon::now()->format('Y-m-d'))
    ->get();

    $horarios = InscripcionClasePersonalizada::join('horarios_clases_personalizadas', 'horarios_clases_personalizadas.clase_personalizada_id', '=', 'inscripcion_clase_personalizada.id')
      ->join('config_especialidades', 'horarios_clases_personalizadas.especialidad_id', '=', 'config_especialidades.id')
      ->join('clases_personalizadas', 'inscripcion_clase_personalizada.clase_personalizada_id', '=', 'clases_personalizadas.id')
      ->leftJoin('instructores', 'horarios_clases_personalizadas.instructor_id', '=', 'instructores.id')
      ->select('config_especialidades.nombre as especialidad_nombre', 'clases_personalizadas.nombre as nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','horarios_clases_personalizadas.hora_inicio','horarios_clases_personalizadas.hora_final', 'inscripcion_clase_personalizada.id', 'horarios_clases_personalizadas.fecha', 'inscripcion_clase_personalizada.boolean_alumno_aceptacion', 'clases_personalizadas.color_etiqueta', 'clases_personalizadas.descripcion')
      ->where('inscripcion_clase_personalizada.alumno_id','=', $request->id)
      ->where('horarios_clases_personalizadas.fecha', '>=', Carbon::now()->format('Y-m-d'))
      ->where('horarios_clases_personalizadas.deleted_at','=', null)
    ->get();
  
      $arrayClases=array();

      $fechaActual = Carbon::now();
      // $geoip = new GeoIP();
      // $geoip->setIp($request->ip());
      // $fechaActual->tz = $geoip->getTimezone();

      foreach ($clases_personalizadas as $grupal) {

        if($academia->tipo_horario == 2){
          $hora_inicio = Carbon::createFromFormat('H:i:s',$grupal->hora_inicio)->toTimeString();
          $hora_final = Carbon::createFromFormat('H:i:s',$grupal->hora_final)->toTimeString();
        }else{
          $hora_inicio = Carbon::createFromFormat('H:i:s',$grupal->hora_inicio)->format('g:i a');
          $hora_final = Carbon::createFromFormat('H:i:s',$grupal->hora_final)->format('g:i a');
        }

        $fecha_start=explode('-',$grupal->fecha_inicio);
        $fecha_end=explode('-',$grupal->fecha_inicio);
        $id=$grupal->id;
        $nombre=$grupal->nombre;
        $descripcion=$grupal->descripcion;
        $etiqueta=$grupal->color_etiqueta;
        $instructor=$grupal->instructor_nombre . ' ' . $grupal->instructor_apellido;


        $fecha_inicio = Carbon::createFromFormat('Y-m-d', $grupal->fecha_inicio)->format('Y-m-d');

        if($fechaActual->format('Y-m-d')==$fecha_inicio){       

          $arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$grupal->fecha_inicio,"fecha_final"=>$grupal->fecha_inicio, "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta, "instructor" => $instructor, 'tipo' => 3, 'tipo_id' => $id);

        }
        
      }

      foreach ($horarios as $grupal) {

        if($academia->tipo_horario == 2){
          $hora_inicio = Carbon::createFromFormat('H:i:s',$grupal->hora_inicio)->toTimeString();
          $hora_final = Carbon::createFromFormat('H:i:s',$grupal->hora_final)->toTimeString();
        }else{
          $hora_inicio = Carbon::createFromFormat('H:i:s',$grupal->hora_inicio)->format('g:i a');
          $hora_final = Carbon::createFromFormat('H:i:s',$grupal->hora_final)->format('g:i a');
        }

        $fecha_start=explode('-',$grupal->fecha);
        $fecha_end=explode('-',$grupal->fecha);
        $id=$grupal->id;
        $nombre=$grupal->nombre;
        $descripcion=$grupal->descripcion;
        $etiqueta=$grupal->color_etiqueta;
        $instructor=$grupal->instructor_nombre . ' ' . $grupal->instructor_apellido;

        $fecha_inicio = Carbon::createFromFormat('Y-m-d', $grupal->fecha)->format('Y-m-d');

        if($fechaActual->format('Y-m-d')==$fecha_inicio){       

          $arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$grupal->fecha,"fecha_final"=>$grupal->fecha, "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta, "instructor" => $instructor, 'tipo' => 3, 'tipo_id' => $id);

        }
        
      }

      $deuda = $this->deuda($request->id);
      $inscripciones = $this->inscripciones($request->id);
      $credenciales = $this->credenciales($request->id);
      $estatus = $this->estatus($request->id);
      $notas_administrativas = $this->notas_administrativas($request->id);
      $items_factura = $this->items_factura($request->id);

      return response()->json(['status' => 'OK', 'clases_grupales'=>$arrayClases, 'deuda' => $deuda, 'inscripciones' => $inscripciones, 'credenciales' => $credenciales, 'estatus' => $estatus, 'items' => $items_factura, 'notas_administrativas' => $notas_administrativas, 200]);
      
  }

  public function consulta_citas_alumno(Request $request){

    $academia = Academia::find(Auth::user()->academia_id);

    $fechaActual = Carbon::now();
    // $geoip = new GeoIP();
    // $geoip->setIp($request->ip());
    // $fechaActual->tz = $geoip->getTimezone();
      
    $citas = Cita::join('alumnos', 'citas.alumno_id', '=', 'alumnos.id')
      ->leftJoin('instructores', 'citas.instructor_id', '=', 'instructores.id')
      ->join('config_citas', 'citas.tipo_id', '=', 'config_citas.id')
      ->select('alumnos.nombre as alumno_nombre', 'alumnos.apellido as alumno_apellido', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','citas.hora_inicio','citas.hora_final', 'citas.id', 'citas.fecha', 'citas.tipo_id', 'config_citas.nombre as nombre', 'citas.color_etiqueta')
      ->where('citas.alumno_id','=', $request->id)
      ->where('citas.estatus', 1)
      ->where('citas.fecha', '=', $fechaActual->format('Y-m-d'))
    ->get();

    $arrayClases=array();

    $fechaActual = Carbon::now();
    // $geoip = new GeoIP();
    // $geoip->setIp($request->ip());
    // $fechaActual->tz = $geoip->getTimezone();

    foreach ($citas as $grupal) {

      if($academia->tipo_horario == 2){
        $hora_inicio = Carbon::createFromFormat('H:i:s',$grupal->hora_inicio)->toTimeString();
        $hora_final = Carbon::createFromFormat('H:i:s',$grupal->hora_final)->toTimeString();
      }else{
        $hora_inicio = Carbon::createFromFormat('H:i:s',$grupal->hora_inicio)->format('g:i a');
        $hora_final = Carbon::createFromFormat('H:i:s',$grupal->hora_final)->format('g:i a');
      }

      $fecha_start=explode('-',$grupal->fecha);
      $fecha_end=explode('-',$grupal->fecha);
      $id=$grupal->id;
      $nombre=$grupal->nombre;
      $descripcion=$grupal->nombre;
      $etiqueta=$grupal->color_etiqueta;
      $instructor=$grupal->instructor_nombre . ' ' . $grupal->instructor_apellido;

      $fecha_inicio = Carbon::createFromFormat('Y-m-d', $grupal->fecha)->format('Y-m-d');
 
      $arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$grupal->fecha,"fecha_final"=>$grupal->fecha, "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta, "instructor" => $instructor, 'tipo' => 4, 'tipo_id' => $id);
        
    }
        
    $deuda = $this->deuda($request->id);
    $inscripciones = $this->inscripciones($request->id);
    $credenciales = $this->credenciales($request->id);
    $estatus = $this->estatus($request->id);
    $notas_administrativas = $this->notas_administrativas($request->id);
    $items_factura = $this->items_factura($request->id);

    return response()->json(['status' => 'OK', 'clases_grupales'=>$arrayClases, 'deuda' => $deuda, 'inscripciones' => $inscripciones, 'credenciales' => $credenciales, 'estatus' => $estatus, 'items' => $items_factura, 'notas_administrativas' => $notas_administrativas, 200]);
      
  }

  public function store(Request $request){

    $rules = [
      'asistencia_clase_grupal_id' => 'required',
      'asistencia_id_alumno' => 'required',
    ];

    $messages = [
      'asistencia_clase_grupal_id.required' => 'Ups! La Clase Grupal es requerida',
      'asistencia_id_alumno.required' => 'Ups! El Alumno es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){
        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);           
    }else{

      $asistencia_clase_grupal_id=$request->asistencia_clase_grupal_id;
      $explode_clase_grupal=explode('-', $asistencia_clase_grupal_id);
      $clase_grupal_id = $explode_clase_grupal[0];
      $alumno_id=$request->asistencia_id_alumno;

      $actual = Carbon::now();

      $fecha_actual=$actual->toDateString();
      $hora_actual=$actual->toTimeString();

      $asistencia = Asistencia::where('alumno_id',$alumno_id)
        ->where('clase_grupal_id',$clase_grupal_id)
        ->where('fecha',$fecha_actual)
      ->first();

      if(!$asistencia){

        $clase_grupal = ClaseGrupal::find($clase_grupal_id);
        
        if($clase_grupal){
          $instructor_id = $clase_grupal->instructor_id;
        }else{
          $instructor_id = '';
        }

        $in_credencial = array(0,$instructor_id);

        $inscripcion_clase_grupal=InscripcionClaseGrupal::where('alumno_id',$alumno_id)
          ->where('clase_grupal_id',$clase_grupal_id)
        ->first();

        if($inscripcion_clase_grupal){

          $estatu="inscrito";

        }else{

          $estatu="credencial";

          $credenciales = CredencialAlumno::where('alumno_id',$alumno_id)
            ->whereIn('instructor_id',$in_credencial)
            ->where('fecha_vencimiento','>=', Carbon::now()->toDateString())
            ->where('cantidad' ,'>', 0)
          ->sum('cantidad');

          if(!$credenciales){

            $credenciales = CredencialAlumno::where('alumno_id',$alumno_id)
              ->where('fecha_vencimiento','>=', Carbon::now()->toDateString())
              ->where('cantidad' ,'>', 0)
            ->sum('cantidad');

            if(!$credenciales){
              $estatu="no_asociado";
            }else{
              $credencial_mensaje = 'Ups! El alumno posee ' .$credenciales. ' credenciales pero no estan asociadas a esta clase grupal';
            }

          }else{
            $credencial_mensaje = 'El alumno no se encuentra asociado a esta clase pero posee ' .$credenciales. ' credenciales, desea utilizar una ?';
          }
        }
          
        if($estatu=="inscrito" OR $request->pertenece OR $request->credencial){

          if(Session::has('no_pertenece')){
            $pertenece = 0;
          }else{
            $pertenece = 1;
          }

          if(Session::has('boolean_credencial')){
            $boolean_credencial = 1;
          }else{
            $boolean_credencial = 0;
          }

          $asistencia = new Asistencia;
          $asistencia->fecha=$fecha_actual;
          $asistencia->hora=$hora_actual;
          $asistencia->clase_grupal_id=$clase_grupal_id;
          $asistencia->alumno_id=$alumno_id;
          $asistencia->academia_id=Auth::user()->academia_id;
          $asistencia->tipo = $explode_clase_grupal[2];
          $asistencia->tipo_id = $explode_clase_grupal[3];
          $asistencia->pertenece = $pertenece;
          $asistencia->boolean_credencial = $boolean_credencial;
        
          if($asistencia->save()){
      
            $inscripcion_clase_grupal = InscripcionClaseGrupal::onlyTrashed()
              ->where('alumno_id',$alumno_id)
              ->where('clase_grupal_id',$clase_grupal_id)
              ->whereNotNull('deleted_at')
            ->first();

            if($inscripcion_clase_grupal){
              $inscripcion_clase_grupal->deleted_at = null;
              $inscripcion_clase_grupal->save();
            }

            if($boolean_credencial && $estatu != "inscrito"){

              $credencial_alumno = CredencialAlumno::where('alumno_id',$alumno_id)
                ->whereIn('instructor_id', $in_credencial)
              ->first();

              if(!$credencial_alumno){
                $credencial_alumno = CredencialAlumno::where('alumno_id',$alumno_id)->first();
              }

              if($credencial_alumno){

                if($credencial_alumno->boolean_uso == 0){

                  if($credencial_alumno->dias_vencimiento){
                    $fecha_vencimiento = Carbon::now()->addDays($credencial_alumno->dias_vencimiento);
                  }else{
                    $fecha_vencimiento = Carbon::now()->addMonth();
                  }

                  $credencial_alumno->boolean_uso = 1;
                  $credencial_alumno->fecha_vencimiento = $fecha_vencimiento;
                } 

                $cantidad = $credencial_alumno->cantidad_restante - 1;
                $credencial_alumno->cantidad_restante = $cantidad;
                $credencial_alumno->save();

                if($cantidad <= 0){
                  $credencial_alumno->delete();
                }
              }
            }

            Session::forget('no_pertenece');
            Session::forget('boolean_credencial');

            return response()->json(['mensaje' => '¡Excelente! La Asistencia se han guardado satisfactoriamente','status' => 'OK', 200]);
          }

        }else if($estatu=="credencial"){

          Session::put('boolean_credencial',1);
          return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR_CREDENCIAL','text' => $credencial_mensaje, 'campo' => 'credencial'],422);
          
        }else{

          Session::put('no_pertenece',1);
          return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR_ASOCIADO', 'text' => "El alumno no se encuentra asociado a esta clase!", 'campo' => 'pertenece'],422);

        }
      }else{
        return response()->json(['errores' => ['asistencia_clase_grupal_id' => [0, 'Ups! El alumno ya posee una asistencia para esta clase el dia de hoy']], 'status' => 'ERROR'],422);
            
      }
    }
  }

  public function storeOtros(Request $request){

      $rules = [

      'asistencia_clase_grupal_id' => 'required',
      'asistencia_id_alumno' => 'required',

      ];

      $messages = [

          'asistencia_clase_grupal_id.required' => 'Ups! La Clase Grupal es requerida',
          'asistencia_id.required' => 'Ups! El alumno es requerido',
          
      ];

      $validator = Validator::make($request->all(), $rules, $messages);

      if ($validator->fails()){
          
          return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);           

      }else{

          $alumno_id=$request->asistencia_id_alumno;

          $explode = explode('-', $request->asistencia_clase_grupal_id);
          $tipo = $explode[2];
          $tipo_id = $explode[3];

          $actual = Carbon::now();
          // $geoip = new GeoIP();
          // $geoip->setIp($request->ip());
          // $actual->tz = $geoip->getTimezone();
          
          $fecha_actual=$actual->toDateString();
          $hora_actual=$actual->toTimeString();

          $asistencia = new Asistencia;
          $asistencia->fecha=$fecha_actual;
          $asistencia->hora=$hora_actual;
          $asistencia->clase_grupal_id=$tipo_id;
          $asistencia->alumno_id=$alumno_id;
          $asistencia->academia_id=Auth::user()->academia_id;
          $asistencia->tipo = $tipo;
          $asistencia->tipo_id = $tipo_id;

          if($asistencia->save()){

            if($tipo == 3){

              $clase_personalizada = InscripcionClasePersonalizada::find($tipo_id);

              if($clase_personalizada){

                $fecha_inicio = Carbon::createFromFormat('Y-m-d', $clase_personalizada->fecha_inicio)->toDateString();

                if($fecha_inicio != Carbon::now()->toDateString()){

                  $horario = HorarioClasePersonalizada::where('clase_personalizada_id', $clase_personalizada->id)->where('fecha', Carbon::now()->toDateString())->first();

                  if($horario){

                    $hie = explode(':',$horario->hora_inicio);
                    $hora_inicio = Carbon::createFromTime($hie[0], $hie[1], $hie[2]);

                    $hfe = explode(':',$horario->hora_final);
                    $hora_final = Carbon::createFromTime($hfe[0], $hfe[1], $hfe[2]);

                    $resta_horas = $hora_inicio->diffInHours($hora_final);

                  }else{
                    $resta_horas = 0;
                  }

                }else{
                  $hie = explode(':',$clase_personalizada->hora_inicio);
                  $hora_inicio = Carbon::createFromTime($hie[0], $hie[1], $hie[2]);

                  $hfe = explode(':',$clase_personalizada->hora_final);
                  $hora_final = Carbon::createFromTime($hfe[0], $hfe[1], $hfe[2]);

                  $resta_horas = $hora_inicio->diffInHours($hora_final); 
                }

                $cantidad_horas = $clase_personalizada->cantidad_horas - $resta_horas;

                $clase_personalizada->cantidad_horas = $cantidad_horas;
                $clase_personalizada->save();
              }
              
            }else if($tipo == 4){

              $cita = Cita::find($tipo_id);

              if($cita){
                $cita->estatus = 2;
                $cita->save();
              }
            }

            return response()->json(['mensaje' => '¡Excelente! La Asistencia se ha guardado satisfactoriamente','status' => 'OK', 200]);

          }else{
              return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
          }
              
       }

    }


    public function storeInstructor(Request $request)
    {

        $rules = [

          'asistencia_clase_grupal_id_instructor' => 'required',
          'asistencia_id_instructor' => 'required',
        ];

        $messages = [

          'asistencia_clase_grupal_id_instructor.required' => 'Ups! La Clase Grupal es requerida',
          'asistencia_id_instructor.required' => 'Ups! El Instructor es requerido',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            
          return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);           

        }else{

          $clase_grupal_id=$request->asistencia_clase_grupal_id_instructor;
          $instructor_id=$request->asistencia_id_instructor;

          $explode_clase_grupal=explode('-', $clase_grupal_id);
          $tipo_clase = $explode_clase_grupal[2];
          $clase_grupal_id = $explode_clase_grupal[0];
          $horario_id = $explode_clase_grupal[3];

          if($tipo_clase == 2){
            $clase_grupal = HorarioClaseGrupal::find($horario_id);
          }else{
            $clase_grupal = ClaseGrupal::find($clase_grupal_id);
          }
          
          if($clase_grupal->instructor_id == $instructor_id){              
            $estatu="asociado";              
          }else{
            $estatu="no_asociado";
          }
            
          if($estatu=="asociado" OR $request->es_instructor) {

            $actual = Carbon::now();

            $fecha_actual=$actual->toDateString();
            $hora_actual=$actual->toTimeString();

            $asistencia = AsistenciaInstructor::where('instructor_id', $instructor_id)
              ->where('clase_grupal_id' , '=', $clase_grupal_id)
              ->where('fecha',$fecha_actual)
            ->first();

            if(!$asistencia){

              $asistencia = new AsistenciaInstructor;
              $asistencia->fecha=$fecha_actual;
              $asistencia->hora=$hora_actual;
              $asistencia->clase_grupal_id=$clase_grupal_id;
              $asistencia->instructor_id=$instructor_id;
              $asistencia->academia_id=Auth::user()->academia_id;
              $asistencia->tipo = $tipo_clase;
              $asistencia->tipo_id = $horario_id;

              $config_pago = ConfigPagosInstructor::where('clase_grupal_id', $clase_grupal_id)
                ->where('instructor_id', $instructor_id)
              ->first();

              if($config_pago){
                if($config_pago->tipo == 1){

                  $pago = new PagoInstructor;

                  $pago->instructor_id=$instructor_id;
                  $pago->tipo=$config_pago->tipo;
                  $pago->monto=$config_pago->monto;
                  $pago->clase_grupal_id=$clase_grupal_id;
                  $pago->fecha = Carbon::now()->toDateString();
                  $pago->hora = Carbon::now()->toTimeString();

                  $pago->save();
                }
              }
            }else{
              // if($asistencia->hora_salida == '00:00:00'){
              //   $asistencia->hora_salida = $hora_actual;
              // }else{
                return response()->json(['status' => 'ERROR', 'mensaje' => "Ups! El instructor ya posee una asistencia en esta clase grupal el dia de hoy"],422);
              // }
            }

            if($asistencia->save()){
              return response()->json(['mensaje' => '¡Excelente! La Asistencia se ha guardado satisfactoriamente','status' => 'OK', 200]);
            }else{
              return response()->json(['status' => 'ERROR', 'mensaje' => "ERROR"],422);
            }
          }else{
            return response()->json(['status' => 'ERROR_ASOCIADO', 'mensaje' => "El instructor no se encuentra asociado a esta clase!", 'campo' => 'es_instructor'],422);
          }
       }

    }


    public function storeStaff(Request $request){

      $rules = [
        'asistencia_id_staff' => 'required',
      ];

      $messages = [
        'asistencia_id_staff.required' => 'Ups! El Staff es requerido',
      ];

      $validator = Validator::make($request->all(), $rules, $messages);

      if ($validator->fails()){
          
        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);           

      }else{

        $staff_id = $request->asistencia_id_staff;
        
        $actual = Carbon::now();
        
        $fecha_actual=$actual->toDateString();
        $hora_actual=$actual->toTimeString();
        $dia_actual = $actual->dayOfWeek;

        if($dia_actual == 0){
          $dia_actual = 7;
        }

        $horario_staff = HorarioStaff::where('dia_de_semana_id',$dia_actual)
          ->where('staff_id',$staff_id)
        ->first();

        if($horario_staff){

          $asistencia = AsistenciaStaff::where('staff_id', $staff_id)
            ->where('fecha', $fecha_actual)
          ->first();

          if(!$asistencia){

            $asistencia = new AsistenciaStaff;
            
            $asistencia->fecha=$fecha_actual;
            $asistencia->hora=$hora_actual;
            $asistencia->staff_id=$staff_id;
            $asistencia->academia_id=Auth::user()->academia_id;

          }else{

            if($asistencia->hora_salida == '00:00:00'){
              $asistencia->hora_salida = $hora_actual;
            }else{
              return response()->json(['status' => 'ERROR', 'mensaje' => "Ups! El staff ya checkeo entrada y salida de asistencia el día de hoy"],422);
            }
          } 

          if($asistencia->save()){
            return response()->json(['mensaje' => '¡Excelente! La Asistencia se ha guardado satisfactoriamente','status' => 'OK', 200]);
          }else{
            return response()->json(['status' => 'ERROR', 'mensaje' => "Ups! Ha ocurrido un error"],422);
          }        
        }else{
          return response()->json(['status' => 'ERROR', 'mensaje' => "Ups! El staff no posee un horario configurado para el dia de hoy"],422);
        }
      }
    }
}