<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

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
        // $alumnos = Asistencia::where('academia_id','=', Auth::user()->academia_id)->get();
      $usuario_tipo = Session::get('easydance_usuario_tipo');
      $usuario_id = Session::get('easydance_usuario_id');

      if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
      {
        $alumnos = DB::table('alumnos')
            ->join('asistencias', 'asistencias.alumno_id', '=', 'alumnos.id')
            ->join('clases_grupales', 'asistencias.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('academias', 'asistencias.academia_id', '=', 'academias.id')
            ->select('asistencias.fecha', 'asistencias.hora', 'config_clases_grupales.nombre as clase', 'alumnos.nombre', 'alumnos.apellido', 'asistencias.tipo', 'asistencias.tipo_id', 'asistencias.clase_grupal_id as clase_grupal_id', 'asistencias.id', 'alumnos.id as alumno_id')
            ->where('academias.id','=',Auth::user()->academia_id)
            ->orderBy('asistencias.created_at','desc')
            ->limit(150)
        ->get();

        $clases_personalizadas = DB::table('alumnos')
            ->join('asistencias', 'asistencias.alumno_id', '=', 'alumnos.id')
            ->join('inscripcion_clase_personalizada', 'asistencias.tipo_id', '=', 'inscripcion_clase_personalizada.id')
            ->join('instructores', 'inscripcion_clase_personalizada.instructor_id', '=', 'instructores.id')
            ->join('clases_personalizadas', 'inscripcion_clase_personalizada.clase_personalizada_id', '=', 'clases_personalizadas.id')
            ->select('asistencias.fecha', 'asistencias.hora', 'clases_personalizadas.nombre as clase', 'alumnos.nombre', 'alumnos.apellido', 'asistencias.tipo', 'asistencias.tipo_id', 'asistencias.id', 'instructores.nombre as nombre_instructor', 'instructores.apellido as apellido_instructor')
            ->where('clases_personalizadas.academia_id','=',Auth::user()->academia_id)
            ->where('asistencias.tipo','=',3)
        ->get();

        $citas = DB::table('alumnos')
            ->join('asistencias', 'asistencias.alumno_id', '=', 'alumnos.id')
            ->join('citas', 'asistencias.tipo_id', '=', 'citas.id')
            ->join('config_citas', 'citas.tipo_id', '=', 'config_citas.id')
            ->join('instructores', 'citas.instructor_id', '=', 'instructores.id')
            ->select('asistencias.fecha', 'asistencias.hora', 'config_citas.nombre as clase', 'alumnos.nombre', 'alumnos.apellido', 'asistencias.tipo', 'asistencias.tipo_id', 'asistencias.id', 'instructores.nombre as nombre_instructor', 'instructores.apellido as apellido_instructor')
            ->where('citas.academia_id','=',Auth::user()->academia_id)
            ->where('asistencias.tipo','=',4)
        ->get();

        $instructores = DB::table('asistencias_instructor')
            ->join('clases_grupales', 'asistencias_instructor.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('academias', 'asistencias_instructor.academia_id', '=', 'academias.id')
            ->join('instructores', 'asistencias_instructor.instructor_id', '=', 'instructores.id')
            ->select('asistencias_instructor.fecha', 'asistencias_instructor.hora', 'config_clases_grupales.nombre as clase', 'instructores.nombre', 'instructores.apellido', 'asistencias_instructor.hora_salida')
            ->where('academias.id','=',Auth::user()->academia_id)
        ->get();

        $staff = DB::table('asistencias_staff')
            ->join('academias', 'asistencias_staff.academia_id', '=', 'academias.id')
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

          if($clasegrupal)
          {
            $collection=collect($asistencia);     
            $asistencia_array = $collection->toArray();
            
            $asistencia_array['dia']=$dia;
            $asistencia_array['hora']=$instructor->nombre . ' ' . $instructor->apellido;
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

        // foreach($staff as $asistencia){

        //   $fecha = Carbon::createFromFormat('Y-m-d', $asistencia->fecha);
        //   $i = $fecha->dayOfWeek;

        //   if($i == 1){

        //     $dia = 'Lunes';

        //   }else if($i == 2){

        //     $dia = 'Martes';

        //   }else if($i == 3){

        //     $dia = 'Miercoles';

        //   }else if($i == 4){

        //     $dia = 'Jueves';

        //   }else if($i == 5){

        //     $dia = 'Viernes';

        //   }else if($i == 6){

        //     $dia = 'Sabado';

        //   }else if($i == 0){

        //     $dia = 'Domingo';

        //   }

        //   $collection=collect($asistencia);     
        //   $asistencia_array = $collection->toArray();
        //   $asistencia_array['clase']='';
        //   $asistencia_array['dia']=$dia;
        //   $asistencia_array['tipo']='S';
        //   $array[] = $asistencia_array;
        // }

        return view('asistencia.asistencia')->with(['asistencias' => $array]);  

        }  

        if($usuario_tipo == 2 OR $usuario_tipo == 4)
        {       

          $clases_grupales = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('inscripcion_clase_grupal', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'inscripcion_clase_grupal.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('clases_grupales.*', 'config_clases_grupales.nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido')
            ->where('inscripcion_clase_grupal.alumno_id','=',$usuario_id)
          ->get();

          $horarios_clase_grupales = HorarioClaseGrupal::join('clases_grupales', 'horario_clase_grupales.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('inscripcion_clase_grupal', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'inscripcion_clase_grupal.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('instructores', 'horario_clase_grupales.instructor_id', '=', 'instructores.id')
            ->select('horario_clase_grupales.*', 'config_clases_grupales.nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido')
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

              while($fecha_horario < Carbon::now())
              {
                  $fecha_a_comparar = $fecha_horario;
                  $fecha_a_comparar = $fecha_a_comparar->toDateString();
                  $asistencia = Asistencia::where('alumno_id',$alumno_id)->where('tipo',2)->where('tipo_id',$horario->id)->where('fecha',$fecha_a_comparar)->first();
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

        if($usuario_tipo == 3)
        {       

          $clases_grupales = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->select('clases_grupales.*', 'config_clases_grupales.nombre')
            ->where('clases_grupales.instructor_id','=',$usuario_id)
          ->get();

          $horarios_clase_grupales = HorarioClaseGrupal::join('clases_grupales', 'horario_clase_grupales.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->select('horario_clase_grupales.*', 'config_clases_grupales.nombre')
            ->where('horario_clase_grupales.instructor_id','=',$usuario_id)
          ->get();

          $instructor_id = $usuario_id;
      

          $array = array();

          $j = 0;

          foreach($clases_grupales as $clase_grupal){

            $fecha_inicio = Carbon::parse($clase_grupal->fecha_inicio);

            while($fecha_inicio < Carbon::now())
            {
                $fecha_a_comparar = $fecha_inicio;
                $fecha_a_comparar = $fecha_a_comparar->toDateString();
                $asistencia = AsistenciaInstructor::where('instructor_id',$instructor_id)->where('clase_grupal_id',$clase_grupal->id)->where('fecha',$fecha_a_comparar)->first();
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

      // $array = array(2, 4);

      // $alumnos = DB::table('alumnos')
      //     ->Leftjoin('users', 'users.usuario_id', '=', 'alumnos.id')
      //     ->select('alumnos.*', 'users.imagen', 'users.usuario_tipo')
      //     ->where('alumnos.academia_id','=', Auth::user()->academia_id)
      //     ->where('alumnos.deleted_at', '=', null)
      //     ->whereIn('users.usuario_tipo', $array)
      //     ->orWhere('users.usuario_tipo', null)
      //     ->orderBy('nombre', 'asc')
      // ->get();

      $array = array(2,4);

      $alumnos = Alumno::where('alumnos.academia_id','=', Auth::user()->academia_id)
        ->orderBy('nombre', 'asc')
      ->get();

      $alumnos_inscritos = DB::table('inscripcion_clase_grupal')
        ->join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
        ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
        ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
        ->select('alumnos.*', 'inscripcion_clase_grupal.id as inscripcion_id', 'inscripcion_clase_grupal.clase_grupal_id as clase_grupal_id', 'clases_grupales.fecha_inicio', 'clases_grupales.fecha_final', 'config_clases_grupales.asistencia_amarilla', 'config_clases_grupales.asistencia_rojo')
        ->where('alumnos.academia_id', '=', Auth::user()->academia_id)
        ->where('inscripcion_clase_grupal.deleted_at', '=', null)
      ->get();

      $array_alumno = array();
      $array_instructor = array();
      $hoy = Carbon::now();
      $array_estatus = array();


    foreach($alumnos_inscritos as $alumno){
      $clases_completadas = 0; 
      $fecha_de_inicio = Carbon::parse($alumno->fecha_inicio);
      $fecha_de_finalizacion = Carbon::parse($alumno->fecha_final); 
      $asistencia_roja = $alumno->asistencia_rojo;
      $asistencia_amarilla = $alumno->asistencia_amarilla; 

      $ultima_asistencia = Asistencia::where('tipo',1)->where('tipo_id',$alumno->clase_grupal_id)->where('alumno_id',$alumno->id)->orderBy('created_at', 'desc')->first();

      if($ultima_asistencia){

          $fecha = Carbon::parse($ultima_asistencia->fecha);

      }else{
          $fecha = $fecha_de_inicio;
      }

      if($hoy<$fecha_de_finalizacion){
          while($fecha<$hoy){
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
      }else if($clases_completadas>=$asistencia_amarilla){
          $estatus="c-amarillo";
      }else{
          $estatus="c-verde";
      }

      $array_estatus[]=array('alumno_id' => $alumno->id, 'clase_grupal_id' => $alumno->clase_grupal_id , 'estatus' => $estatus);

  }
    
      foreach($alumnos as $alumno){

        $usuario = User::where('usuario_id',$alumno->id)->whereIn('usuario_tipo',$array)->first();
        $inscripcion = InscripcionClaseGrupal::join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'config_clases_grupales.nombre', 'clases_grupales.fecha_inicio', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final', 'clases_grupales.id')
            ->where('inscripcion_clase_grupal.alumno_id', $alumno->id)
            ->orderBy('inscripcion_clase_grupal.created_at', 'desc')
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

        $usuario = User::where('usuario_id',$instructor->id)->where('usuario_tipo',3)->first();

        if($usuario){

          if($usuario->imagen){
            $imagen = $usuario->imagen;
          }else{
            $imagen = '';
          }

        }

        $collection=collect($instructor);     
        $instructor_array = $collection->toArray();
            
        $instructor_array['imagen']=$imagen;
        $array_instructor[$instructor->id] = $instructor_array;


      }


      $staff = Staff::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

      $alumnoc = DB::table('alumnos')
        ->join('users', 'users.usuario_id', '=', 'alumnos.id')
        ->select('alumnos.id as id')
        ->where('alumnos.academia_id','=', Auth::user()->academia_id)
        ->where('alumnos.deleted_at', '=', null)
        ->where('users.usuario_tipo', '=', 2)
        ->where('users.confirmation_token', '!=', null)
      ->get();

      $collection=collect($alumnoc);
      $grouped = $collection->groupBy('id');     
      $activacion = $grouped->toArray();


      return view('asistencia.generar')->with(['alumnosacademia' => $array_alumno, 'instructores' => $array_instructor, 'activacion' => $activacion, 'staff' => $staff, 'estatus' => $array_estatus]);

    }

    private function deuda($id){
        $alumnod = DB::table('alumnos')
            ->join('items_factura_proforma', 'items_factura_proforma.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.id as id', 'items_factura_proforma.importe_neto', 'items_factura_proforma.fecha_vencimiento')
            ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
            ->where('items_factura_proforma.alumno_id', $id)
        ->get();

        if(count($alumnod)>0){
            $collection = collect($alumnod);
            $cuenta=$collection->sum('importe_neto');
        }else{
            $cuenta=0;
        }

        return $cuenta;

    }

    public function consulta_clase_grupales(Request $request)
    {
      //$ClaseGrupal=ClaseGrupal::all();

      $claseGrupal= DB::table('clases_grupales')
            ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as nombre', 'config_clases_grupales.descripcion as descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido',  'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.fecha_inicio','clases_grupales.fecha_final', 'clases_grupales.color_etiqueta', 'clases_grupales.id')
            ->where('clases_grupales.deleted_at', '=', null)
            ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
      ->get();

      $horarios_clase_grupales= DB::table('horario_clase_grupales')
            ->join('config_especialidades', 'horario_clase_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_estudios', 'horario_clase_grupales.estudio_id', '=', 'config_estudios.id')
            ->join('instructores', 'horario_clase_grupales.instructor_id', '=', 'instructores.id')
            ->join('clases_grupales', 'horario_clase_grupales.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as nombre', 'config_clases_grupales.descripcion as descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido',  'config_estudios.nombre as estudio_nombre', 'horario_clase_grupales.hora_inicio','horario_clase_grupales.hora_final', 'horario_clase_grupales.fecha as fecha_inicio','clases_grupales.fecha_final', 'clases_grupales.color_etiqueta', 'clases_grupales.id', 'horario_clase_grupales.id as horario_id')
            ->where('horario_clase_grupales.deleted_at', '=', null)
            ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
        ->get();



     // dd($claseGrupal);

      $arrayClaseGrupal=array();

      $fechaActual = Carbon::now();
      $geoip = new GeoIP();
      $geoip->setIp($request->ip());
      $fechaActual->tz = $geoip->getTimezone();
      $diaActual = $fechaActual->dayOfWeek;

      $collection = collect($claseGrupal);


      foreach ($claseGrupal as $grupal) {

        $fecha_start=explode('-',$grupal->fecha_inicio);
        $fecha_end=explode('-',$grupal->fecha_final);
        $id=$grupal->id;
        $nombre=$grupal->nombre;
        $descripcion=$grupal->descripcion;
        $hora_inicio=$grupal->hora_inicio;
        $hora_final=$grupal->hora_final;
        $etiqueta=$grupal->color_etiqueta;
        $instructor=$grupal->instructor_nombre . ' ' . $grupal->instructor_apellido;

        // $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);

        // $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0); 

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
          $hora_inicio=$grupal->hora_inicio;
          $hora_final=$grupal->hora_final;
          $etiqueta=$grupal->color_etiqueta;
          $instructor=$grupal->instructor_nombre . ' ' . $grupal->instructor_apellido;


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

      //dd($arrayClaseGrupal);
      return response()->json(['status' => 'OK', 'clases_grupales'=>$arrayClaseGrupal, 200]);


    }

    public function consulta_clase_grupales_alumno(Request $request)
    {
    	
        $clases_grupales= DB::table('clases_grupales')
            ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as nombre', 'config_clases_grupales.descripcion as descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido',  'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.fecha_inicio','clases_grupales.fecha_final', 'clases_grupales.color_etiqueta', 'clases_grupales.id')
            ->where('clases_grupales.deleted_at', '=', null)
            ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
        ->get();

        $horarios_clase_grupales= DB::table('horario_clase_grupales')
            ->join('config_especialidades', 'horario_clase_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_estudios', 'horario_clase_grupales.estudio_id', '=', 'config_estudios.id')
            ->join('instructores', 'horario_clase_grupales.instructor_id', '=', 'instructores.id')
            ->join('clases_grupales', 'horario_clase_grupales.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as nombre', 'config_clases_grupales.descripcion as descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido',  'config_estudios.nombre as estudio_nombre', 'horario_clase_grupales.hora_inicio','horario_clase_grupales.hora_final', 'horario_clase_grupales.fecha as fecha_inicio','clases_grupales.fecha_final', 'clases_grupales.color_etiqueta', 'clases_grupales.id', 'horario_clase_grupales.id as horario_id')
            ->where('horario_clase_grupales.deleted_at', '=', null)
            ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
        ->get();

         $inscripciones = DB::table('inscripcion_clase_grupal')
                ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('config_clases_grupales.nombre', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final', 'clases_grupales.fecha_inicio', 'inscripcion_clase_grupal.id', 'inscripcion_clase_grupal.fecha_pago')
                ->where('inscripcion_clase_grupal.alumno_id', '=', $request->id)
                ->where('inscripcion_clase_grupal.deleted_at', '=', null)
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

     	$alumno=Alumno::all();
  
	    $arrayClases=array();

      $fechaActual = Carbon::now();
      $geoip = new GeoIP();
      $geoip->setIp($request->ip());
      $fechaActual->tz = $geoip->getTimezone();
      $diaActual = $fechaActual->dayOfWeek;

      $collection = collect($clases_grupales);

     	foreach ($clases_grupales as $grupal) {

     		$fecha_start=explode('-',$grupal->fecha_inicio);
     		$fecha_end=explode('-',$grupal->fecha_final);
     		$id=$grupal->id;
     		$nombre=$grupal->nombre;
     		$descripcion=$grupal->descripcion;
     		$hora_inicio=$grupal->hora_inicio;
     		$hora_final=$grupal->hora_final;
     		$etiqueta=$grupal->color_etiqueta;
        $instructor=$grupal->instructor_nombre . ' ' . $grupal->instructor_apellido;


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

     			$arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$grupal->fecha_inicio,"fecha_final"=>$grupal->fecha_final, "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta, "instructor" => $instructor, 'tipo' => 1, 'tipo_id' => $id, 'bloqueado' => $bloqueado);

     	  }
		    
		}

    foreach ($horarios_clase_grupales as $grupal) {

        $fecha_start=explode('-',$grupal->fecha_inicio);
        $fecha_end=explode('-',$grupal->fecha_final);
        $id=$grupal->id;
        $nombre=$grupal->nombre;
        $descripcion=$grupal->descripcion;
        $hora_inicio=$grupal->hora_inicio;
        $hora_final=$grupal->hora_final;
        $etiqueta=$grupal->color_etiqueta;
        $instructor=$grupal->instructor_nombre . ' ' . $grupal->instructor_apellido;


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

          $arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$grupal->fecha_inicio,"fecha_final"=>$grupal->fecha_final, "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta, "instructor" => $instructor, 'tipo' => 2, 'tipo_id' => $grupal->horario_id, 'bloqueado' => $bloqueado);

        }
        
    }

    $deuda=$this->deuda($request->id);

		return response()->json(['status' => 'OK', 'clases_grupales'=>$arrayClases, 'deuda'=>$deuda, 'inscripciones' => $array, 200]);



    	//return ['talleres' => $arrayTalleres];
    	
    }

    public function consulta_clase_personalizadas_alumno(Request $request)
    {

    $inscripciones = DB::table('inscripcion_clase_grupal')
        ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
        ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
        ->select('config_clases_grupales.nombre', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final', 'clases_grupales.fecha_inicio', 'inscripcion_clase_grupal.id', 'inscripcion_clase_grupal.fecha_pago')
        ->where('inscripcion_clase_grupal.alumno_id', '=', $request->id)
        ->where('inscripcion_clase_grupal.deleted_at', '=', null)
    ->get();

    $clases_personalizadas = DB::table('inscripcion_clase_personalizada')
      ->join('config_especialidades', 'inscripcion_clase_personalizada.especialidad_id', '=', 'config_especialidades.id')
      ->join('clases_personalizadas', 'inscripcion_clase_personalizada.clase_personalizada_id', '=', 'clases_personalizadas.id')
      ->join('instructores', 'inscripcion_clase_personalizada.instructor_id', '=', 'instructores.id')
      ->select('config_especialidades.nombre as especialidad_nombre', 'clases_personalizadas.nombre as nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','inscripcion_clase_personalizada.hora_inicio','inscripcion_clase_personalizada.hora_final', 'inscripcion_clase_personalizada.id', 'inscripcion_clase_personalizada.fecha_inicio', 'inscripcion_clase_personalizada.boolean_alumno_aceptacion', 'clases_personalizadas.color_etiqueta', 'clases_personalizadas.descripcion')
      ->where('inscripcion_clase_personalizada.alumno_id','=', $request->id)
      ->where('inscripcion_clase_personalizada.fecha_inicio', '>=', Carbon::now()->format('Y-m-d'))
      // ->where('inscripcion_clase_personalizada.estatus','=', 1)
    ->get();

    $horarios = DB::table('horarios_clases_personalizadas')
      ->join('inscripcion_clase_personalizada', 'horarios_clases_personalizadas.clase_personalizada_id', '=', 'inscripcion_clase_personalizada.id')
      ->join('config_especialidades', 'horarios_clases_personalizadas.especialidad_id', '=', 'config_especialidades.id')
      ->join('clases_personalizadas', 'inscripcion_clase_personalizada.clase_personalizada_id', '=', 'clases_personalizadas.id')
      ->join('instructores', 'horarios_clases_personalizadas.instructor_id', '=', 'instructores.id')
      ->select('config_especialidades.nombre as especialidad_nombre', 'clases_personalizadas.nombre as nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','horarios_clases_personalizadas.hora_inicio','horarios_clases_personalizadas.hora_final', 'inscripcion_clase_personalizada.id', 'horarios_clases_personalizadas.fecha', 'inscripcion_clase_personalizada.boolean_alumno_aceptacion', 'clases_personalizadas.color_etiqueta', 'clases_personalizadas.descripcion')
      ->where('inscripcion_clase_personalizada.alumno_id','=', $request->id)
      ->where('horarios_clases_personalizadas.fecha', '>=', Carbon::now()->format('Y-m-d'))
      // ->where('inscripcion_clase_personalizada.estatus','=', 1)
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
  
      $arrayClases=array();

      $fechaActual = Carbon::now();
      $geoip = new GeoIP();
      $geoip->setIp($request->ip());
      $fechaActual->tz = $geoip->getTimezone();

      $collection = collect($inscripciones);

      foreach ($clases_personalizadas as $grupal) {

        $fecha_start=explode('-',$grupal->fecha_inicio);
        $fecha_end=explode('-',$grupal->fecha_inicio);
        $id=$grupal->id;
        $nombre=$grupal->nombre;
        $descripcion=$grupal->descripcion;
        $hora_inicio=$grupal->hora_inicio;
        $hora_final=$grupal->hora_final;
        $etiqueta=$grupal->color_etiqueta;
        $instructor=$grupal->instructor_nombre . ' ' . $grupal->instructor_apellido;


        $fecha_inicio = Carbon::createFromFormat('Y-m-d', $grupal->fecha_inicio)->format('Y-m-d');

        if($fechaActual->format('Y-m-d')==$fecha_inicio){       

          $arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$grupal->fecha_inicio,"fecha_final"=>$grupal->fecha_inicio, "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta, "instructor" => $instructor, 'tipo' => 3, 'tipo_id' => $id);

        }
        
      }

      foreach ($horarios as $grupal) {

        $fecha_start=explode('-',$grupal->fecha);
        $fecha_end=explode('-',$grupal->fecha);
        $id=$grupal->id;
        $nombre=$grupal->nombre;
        $descripcion=$grupal->descripcion;
        $hora_inicio=$grupal->hora_inicio;
        $hora_final=$grupal->hora_final;
        $etiqueta=$grupal->color_etiqueta;
        $instructor=$grupal->instructor_nombre . ' ' . $grupal->instructor_apellido;


        $fecha_inicio = Carbon::createFromFormat('Y-m-d', $grupal->fecha)->format('Y-m-d');

        if($fechaActual->format('Y-m-d')==$fecha_inicio){       

          $arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$grupal->fecha,"fecha_final"=>$grupal->fecha, "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta, "instructor" => $instructor, 'tipo' => 3, 'tipo_id' => $id);

        }
        
      }
        

    $deuda=$this->deuda($request->id);

    return response()->json(['status' => 'OK', 'clases_grupales'=>$arrayClases, 'deuda'=>$deuda, 'inscripciones' => $array, 200]);
      
    }

    public function consulta_citas_alumno(Request $request)
    {

      $fechaActual = Carbon::now();
      $geoip = new GeoIP();
      $geoip->setIp($request->ip());
      $fechaActual->tz = $geoip->getTimezone();
      
    $citas = DB::table('citas')
      ->join('alumnos', 'citas.alumno_id', '=', 'alumnos.id')
      ->join('instructores', 'citas.instructor_id', '=', 'instructores.id')
      ->join('config_citas', 'citas.tipo_id', '=', 'config_citas.id')
      ->select('alumnos.nombre as alumno_nombre', 'alumnos.apellido as alumno_apellido', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','citas.hora_inicio','citas.hora_final', 'citas.id', 'citas.fecha', 'citas.tipo_id', 'config_citas.nombre as nombre', 'citas.color_etiqueta')
      ->where('citas.alumno_id','=', $request->id)
      ->where('citas.estatus', 1)
      ->where('citas.fecha', '=', $fechaActual->format('Y-m-d'))
    ->get();

    $inscripciones = DB::table('inscripcion_clase_grupal')
        ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
        ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
        ->select('config_clases_grupales.nombre', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final', 'clases_grupales.fecha_inicio', 'inscripcion_clase_grupal.id', 'inscripcion_clase_grupal.fecha_pago')
        ->where('inscripcion_clase_grupal.alumno_id', '=', $request->id)
        ->where('inscripcion_clase_grupal.deleted_at', '=', null)
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
  
      $arrayClases=array();

      $fechaActual = Carbon::now();
      $geoip = new GeoIP();
      $geoip->setIp($request->ip());
      $fechaActual->tz = $geoip->getTimezone();

      $collection = collect($inscripciones);

      foreach ($citas as $grupal) {

        $fecha_start=explode('-',$grupal->fecha);
        $fecha_end=explode('-',$grupal->fecha);
        $id=$grupal->id;
        $nombre=$grupal->nombre;
        $descripcion=$grupal->nombre;
        $hora_inicio=$grupal->hora_inicio;
        $hora_final=$grupal->hora_final;
        $etiqueta=$grupal->color_etiqueta;
        $instructor=$grupal->instructor_nombre . ' ' . $grupal->instructor_apellido;

        $fecha_inicio = Carbon::createFromFormat('Y-m-d', $grupal->fecha)->format('Y-m-d');
   
        $arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$grupal->fecha,"fecha_final"=>$grupal->fecha, "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta, "instructor" => $instructor, 'tipo' => 4, 'tipo_id' => $id);

        
        
    }
        

    $deuda=$this->deuda($request->id);

    return response()->json(['status' => 'OK', 'clases_grupales'=>$arrayClases, 'deuda'=>$deuda, 'inscripciones' => $array, 200]);
      
    }

    public function store(Request $request)
    {


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

            $clase=$request->asistencia_clase_grupal_id;
            $id_alumno=$request->asistencia_id_alumno;

            $ClasesAsociadas=InscripcionClaseGrupal::where('alumno_id',$id_alumno)->get();
            $clase_id=explode('-', $clase);

            $estatu="no_asociado";


            foreach ($ClasesAsociadas as $clasegrupal) {
              if($clasegrupal->clase_grupal_id==$clase_id[0]){
                  $estatu="inscrito";
              }
            }

              
            if($estatu=="inscrito" OR $request->pertenece){

              $clase_grupal = ClaseGrupal::find($clase);

              $credencial_alumno = CredencialAlumno::where('alumno_id',$id_alumno)->where('instructor_id',$clase_grupal->instructor_id)->first();

              if(!$credencial_alumno){

                $credencial_alumno = new CredencialAlumno;

                $credencial_alumno->alumno_id = $id_alumno;
                $credencial_alumno->instructor_id = $clase_grupal->instructor_id;
                $credencial_alumno->cantidad = 0;
                $credencial_alumno->dias_vencimiento = 0;
                $credencial_alumno->fecha_vencimiento = Carbon::now();

                $credencial_alumno->save();

              }

              if($estatu=="inscrito" OR $credencial_alumno->cantidad > 0 OR $request->credencial)
              {

                if(Session::has('pertenece')){
                  $pertenece = 0;
                }else{
                  $pertenece = 1;
                }

                $actual = Carbon::now();
                $geoip = new GeoIP();
                $geoip->setIp($request->ip());

                $actual->tz = $geoip->getTimezone();

                $fecha_actual=$actual->toDateString();
                $hora_actual=$actual->toTimeString();

                $asistencia = Asistencia::where('alumno_id',$id_alumno)->where('clase_grupal_id',$clase)->where('fecha',$fecha_actual)->first();

                if(!$asistencia)
                {

                  $asistencia = new Asistencia;
                  $asistencia->fecha=$fecha_actual;
                  $asistencia->hora=$hora_actual;
                  $asistencia->clase_grupal_id=$clase;
                  $asistencia->alumno_id=$id_alumno;
                  $asistencia->academia_id=Auth::user()->academia_id;
                  $asistencia->tipo = $clase_id[2];
                  $asistencia->tipo_id = $clase_id[3];
                  $asistencia->pertenece = $pertenece;
                }

                if($asistencia->save()){
            
                  $inscripcion_clase_grupal = InscripcionClaseGrupal::onlyTrashed()->where('alumno_id',$id_alumno)->where('clase_grupal_id',$clase)->whereNotNull('deleted_at')->first();

                  if($inscripcion_clase_grupal){
                    $inscripcion_clase_grupal->deleted_at = null;
                    $inscripcion_clase_grupal->save();
                  }

                  $credencial_alumno->cantidad = $credencial_alumno->cantidad - 1;
                  $credencial_alumno->save();

                  Session::forget('pertenece');

                  return response()->json(['mensaje' => '¡Excelente! La Asistencia se han guardado satisfactoriamente','status' => 'OK', 200]);
                }

              }else{

                Session::put('pertenece',0);
                return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR_CREDENCIAL','text' => "El alumno no posee las credenciales necesarias!", 'campo' => 'credencial'],422);
              }
              
            }elseif($estatu=="no_asociado") {

              return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR_ASOCIADO', 'text' => "El alumno no se encuentra asociado a esta clase!", 'campo' => 'pertenece'],422);

            }

        }

    }

    public function storeOtros(Request $request)
    {

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

            $clase=$request->asistencia_clase_grupal_id;
            $alumno_id=$request->asistencia_id_alumno;

            $clase_id=explode('-', $clase);

                $actual = Carbon::now();
                $geoip = new GeoIP();
                $geoip->setIp($request->ip());

                // $actual->tz = 'America/Caracas';
                // $actual->tz = $request->timezone;
                $actual->tz = $geoip->getTimezone();
                
                $fecha_actual=$actual->toDateString();
                $hora_actual=$actual->toTimeString();

                $asistencia = new Asistencia;
                $asistencia->fecha=$fecha_actual;
                $asistencia->hora=$hora_actual;
                $asistencia->clase_grupal_id=$clase_id[0];
                $asistencia->alumno_id=$alumno_id;
                $asistencia->academia_id=Auth::user()->academia_id;
                $asistencia->tipo = $clase_id[2];
                $asistencia->tipo_id = $clase_id[3];

                if($asistencia->save()){

                  if($clase_id[2] == '3'){

                    $clase_personalizada = InscripcionClasePersonalizada::find($clase_id[3]);

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
                    
                  }else if($clase_id[2] == '4'){
                    $clase_personalizada = Cita::find($clase_id[3]);
                    $clase_personalizada->estatus = '2';
                    $clase_personalizada->save();
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

          $clase=$request->asistencia_clase_grupal_id_instructor;
          $id_instructor=$request->asistencia_id_instructor;

          $clase_id=explode('-', $clase);

          if($clase_id[2] == '2'){
            $ClasesAsociadas=HorarioClaseGrupal::where('instructor_id',$id_instructor)
              ->where('id',$clase_id[3])
            ->get();
          }else{
            $ClasesAsociadas=ClaseGrupal::where('instructor_id',$id_instructor)
              ->where('id',$clase_id[0])
            ->get();
          }
          
          $estatu="no_asociado";
          
          if(count($ClasesAsociadas)>0){              
            $estatu="asociado";              
          }
            
          if($estatu=="asociado" OR $request->es_instructor) {

            $actual = Carbon::now();
            $geoip = new GeoIP();
            $geoip->setIp($request->ip());

            $actual->tz = $geoip->getTimezone();
            $fecha_actual=$actual->toDateString();
            $hora_actual=$actual->toTimeString();

            $asistencia = AsistenciaInstructor::where('instructor_id', $id_instructor)->where('hora_salida', '00:00:00')->where('clase_grupal_id' , '=', $clase_id[0])->where('fecha',$fecha_actual)->first();

            if($asistencia)
            {
              $asistencia->hora_salida = $hora_actual;
              $asistencia->save();
            }else{

              $asistencia = AsistenciaInstructor::where('instructor_id', $id_instructor)->where('clase_grupal_id' , '=', $clase_id[0])->where('fecha',$fecha_actual)->first();

              if(!$asistencia)
              {

                $asistencia = new AsistenciaInstructor;
                $asistencia->fecha=$fecha_actual;
                $asistencia->hora=$hora_actual;
                $asistencia->clase_grupal_id=$clase_id[0];
                $asistencia->instructor_id=$id_instructor;
                $asistencia->academia_id=Auth::user()->academia_id;
                $asistencia->tipo = $clase_id[2];
                $asistencia->tipo_id = $clase_id[3];

                $asistencia->save();

                $config_pago = ConfigPagosInstructor::where('clase_grupal_id', $clase_id[0])->where('instructor_id', $id_instructor)->first();

                if($config_pago){
                  if($config_pago->tipo == 1)
                  {

                    $pago = new PagoInstructor;

                    $pago->instructor_id=$id_instructor;
                    $pago->tipo=$config_pago->tipo;
                    $pago->monto=$config_pago->monto;
                    $pago->clase_grupal_id=$clase_id[0];
                    $pago->asistencia_id=$asistencia->id;

                    $pago->save();
                  }
                }
              }
            }

            return response()->json(['mensaje' => '¡Excelente! La Asistencia se ha guardado satisfactoriamente','status' => 'OK', 200]);

          }else{
            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR_ASOCIADO', 'text' => "El instructor no se encuentra asociado a esta clase!", 'campo' => 'es_instructor'],422);
          }
       }

    }


    public function storeStaff(Request $request)
    {
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

        $id = $request->asistencia_id_staff;

        $asistencia = AsistenciaStaff::where('staff_id', $id)->where('hora_salida', '00:00:00')->first();

        $actual = Carbon::now();
        $geoip = new GeoIP();
        $geoip->setIp($request->ip());
        $actual->tz = $geoip->getTimezone();
        $fecha_actual=$actual->toDateString();
        $hora_actual=$actual->toTimeString();

        if($asistencia)
        {

          $asistencia->hora_salida = $hora_actual;
          $asistencia->save();

        }else{

          $asistencia = new AsistenciaStaff;
          $asistencia->fecha=$fecha_actual;
          $asistencia->hora=$hora_actual;
          $asistencia->staff_id=$id;
          $asistencia->academia_id=Auth::user()->academia_id;

          $asistencia->save();

          if($asistencia->save())
          {
            return response()->json(['mensaje' => '¡Excelente! La Asistencia se ha guardado satisfactoriamente','status' => 'OK', 200]);
          }else{

          }
        }            
      }
    }

}