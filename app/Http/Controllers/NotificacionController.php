<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Academia;
use App\Taller;
use App\Fiesta;
use App\Campana;
use App\ClaseGrupal;
use App\Instructor;
use App\Staff;
use App\Notificacion;
use App\NotificacionUsuario;
use Session;
use DB;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Sugerencia;
use App\User;

class NotificacionController extends BaseController
{
    public function principal(Request $request){

        $academia = Academia::find(Auth::user()->academia_id);

        if($academia->pais_id == 11){
            $timezone = 'America/Bogota';
        }else{
            $timezone = 'America/Caracas';
        }

        $notificaciones = NotificacionUsuario::join('notificacion','notificacion_usuario.id_notificacion', '=','notificacion.id')
            ->join('users','notificacion_usuario.id_usuario','=','users.id')
            ->select('notificacion.*','notificacion_usuario.visto as visto')
            ->where('notificacion_usuario.id_usuario','=',Auth::user()->id)
            ->orderBy('created_at','desc')
        ->get();

        $array = array();

        $j = 0;

        foreach($notificaciones as $notificacion){

            if($notificacion->tipo_evento == 1){

                $usuario = Instructor::leftjoin('usuarios_tipo', 'usuarios_tipo.tipo_id', '=', 'instructores.id')
                    ->leftjoin('users', 'usuarios_tipo.usuario_id', '=', 'users.id')
                    ->join('clases_grupales', 'clases_grupales.instructor_id', '=', 'instructores.id')
                    ->select('instructores.*', 'users.imagen', 'users.id')
                    ->where('usuarios_tipo.tipo',3)
                    ->where('clases_grupales.id',$notificacion->evento_id)
                ->first();

            }else if($notificacion->tipo_evento == 5){

                $usuario = User::join('sugerencias', 'sugerencias.usuario_id', '=', 'users.id')
                    ->select('users.*','sugerencias.mensaje')
                    ->where('sugerencias.id',$notificacion->evento_id)
                ->first();

            }else if($notificacion->tipo_evento == 6){

                $usuario = Instructor::leftjoin('usuarios_tipo', 'usuarios_tipo.tipo_id', '=', 'instructores.id')
                    ->leftjoin('users', 'usuarios_tipo.usuario_id', '=', 'users.id')
                    ->join('evaluaciones', 'evaluaciones.instructor_id', '=', 'instructores.id')
                    ->select('instructores.*', 'users.imagen', 'users.id')
                    ->where('usuarios_tipo.tipo',3)
                    ->where('evaluaciones.id',$notificacion->evento_id)
                ->first();

            }else if($notificacion->tipo_evento == 7){

                $usuario = User::join('incidencias', 'incidencias.administrador_id', '=', 'users.id')
                    ->select('users.*')
                    ->where('incidencias.id',$notificacion->evento_id)
                ->first();

            }else if($notificacion->tipo_evento == 8){

                // $usuario = Staff::leftjoin('usuarios_tipo', 'usuarios_tipo.tipo_id', '=', 'staff.id')
                //     ->leftjoin('users', 'usuarios_tipo.usuario_id', '=', 'users.id')
                //     ->join('supervisiones_evaluaciones', 'supervisiones_evaluaciones.supervisor_id', '=', 'staff.id')
                //     ->select('staff.*','users.imagen', 'users.id')
                //     ->where('usuarios_tipo.tipo',8)
                //     ->where('supervisiones_evaluaciones.id',$notificacion->evento_id)
                // ->first();

                $usuario = Staff::join('supervisiones_evaluaciones', 'supervisiones_evaluaciones.supervisor_id', '=', 'staff.id')
                    ->select('staff.*')
                    ->where('supervisiones_evaluaciones.id',$notificacion->evento_id)
                ->first();

            }else{
                $usuario = '';
            }

            if($usuario){

                $collection=collect($notificacion);     
                $notificacion_array = $collection->toArray();
            
                $fecha_tmp = Carbon::createFromFormat('Y-m-d H:i:s', $notificacion->created_at, $timezone);

                $dia = $fecha_tmp->format('d'); 

                switch ($fecha_tmp->month) {
                    case 1:
                        $mes = "Enero";
                        break;
                    case 2:
                        $mes = "Febrero";
                        break;
                    case 3:
                        $mes = "Marzo";
                        break;
                    case 4:
                        $mes = "Abril";
                        break;
                    case 5:
                        $mes = "Mayo";
                        break;
                    case 6:
                        $mes = "Junio";
                        break;
                    case 7:
                        $mes = "Julio";
                        break;
                    case 8:
                        $mes = "Agosto";
                        break;
                    case 9:
                        $mes = "Septiembre";
                        break;
                    case 10:
                        $mes = "Octubre";
                        break;
                    case 11:
                        $mes = "Noviembre";
                        break;
                    case 12:
                        $mes = "Diciembre";
                        break;
                }

                $ano = $fecha_tmp->format('Y'); 

                $fecha = $dia . ' de ' . $mes . ' ' . $ano;

                $i = $fecha_tmp->dayOfWeek;

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

                $hora = Carbon::createFromFormat('Y-m-d H:i:s', $notificacion->created_at)->format('h:i:s A'); 

                if($usuario->mensaje){
                    $notificacion_array['mensaje']=$usuario->mensaje;
                }

                $notificacion_array['imagen']=$usuario->imagen;
                $notificacion_array['usuario_nombre'] = $usuario->nombre;
                $notificacion_array['usuario_apellido'] = $usuario->apellido;
                $notificacion_array['usuario_id'] = $usuario->id;
                $notificacion_array['sexo']=$usuario->sexo;
                $notificacion_array['fecha']=$fecha;
                $notificacion_array['dia']=$dia;
                $notificacion_array['hora']=$hora;
                $notificacion_array['contador'] = intval($j);

                $array[$notificacion->id] = $notificacion_array;

                $j = $j + 1;
            }
        }

        
        return view('notificacion.principal')->with(['notificaciones_principal' => $array]);
    }


            
    public function responderNotificacion(Request $request){

        $rules = [
            'mensaje' => 'required',

        ];

        $messages = [

            'mensaje.required' => 'Ups! El Mensaje es requerido',
      
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        $sugerencia = new Sugerencia;

        $sugerencia->usuario_id = Auth::user()->id;
        $sugerencia->fecha = Carbon::now();
        $sugerencia->mensaje = $request->mensaje;
        $sugerencia->academia_id = Auth::user()->academia_id;

        if($sugerencia->save()){

            $usuario = User::find(Auth::user()->id);

            $notificacion = new Notificacion; 

            $notificacion->tipo_evento = 5;
            $notificacion->evento_id = $sugerencia->id;
            $notificacion->mensaje = $usuario->nombre . " " . $usuario->apellido . " ha respondido tu mensaje";
            $notificacion->titulo = "Nueva Respuesta";

            if($notificacion->save()){

                $usuarios_notificados = new NotificacionUsuario;
                $usuarios_notificados->id_usuario = $request->usuario_id;
                $usuarios_notificados->id_notificacion = $notificacion->id;
                $usuarios_notificados->visto = 0;

                if($usuarios_notificados->save()){

                    return response()->json(['mensaje' => '??Excelente! La respuesta ha sido enviada satisfactoriamente', 'status' => 'OK', 200]);

                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
                }
                
            }
        }

    }
    public function consulta(){
        
    	$fecha_sesion="";
    	if (Session::has('fecha_sesion')) {
            $fecha_sesion = Session::get('fecha_sesion');
        }       
         
		$date = Carbon::now();

		if(Session::has('fecha_ultima_consulta')){
			Session::put('fecha_ultima_consulta', $date);
		}else{
			Session::put('fecha_ultima_consulta', $date);
		}

        $clases_grupales=ClaseGrupal::whereBetween('created_at', [ new Carbon($fecha_carga), new Carbon($date)])->get();
    }

    public function revisarNotificacion(){

        $notificaciones = NotificacionUsuario::where('id_usuario',Auth::user()->id)->where('visto',0)->get();

        foreach($notificaciones as $notificacion){
            $notificacion->visto = 1;
            $notificacion->save();
        }

        return response()->json(['status' => 'OK', 200]);
    }

    public function eliminarNotificaciones(){
        $notificacion = NotificacionUsuario::where('notificacion_usuario.id_usuario','=',Auth::user()->id)
        ->delete();
    }

    public function nuevaNotificaion(){
        $notificaciones = DB::table('notificacion_usuario')
            ->join('notificacion','notificacion_usuario.id_notificacion', '=','notificacion.id')
            ->join('users','notificacion_usuario.id_usuario','=','users.id')
            ->select('notificacion.*','notificacion_usuario.visto as visto')
            ->where('notificacion_usuario.id_usuario','=',Auth::user()->id)
            ->orderBy('created_at','desc')
        ->get();

        $numero_de_notificaciones = 0;

        foreach( $notificaciones as $notificacion){
            if($notificacion->visto == 0){
                $numero_de_notificaciones++;
            }
        }

        $notificaciones = DB::table('notificacion_usuario')
            ->join('notificacion','notificacion_usuario.id_notificacion', '=','notificacion.id')
            ->join('users','notificacion_usuario.id_usuario','=','users.id')
            ->join('academias','users.academia_id','=','academias.id')
            ->select('notificacion.*','notificacion_usuario.visto as visto','academias.imagen as imagen','academias.nombre as nombre')
            ->where('notificacion_usuario.id_usuario','=',Auth::user()->id)
            ->orderBy('created_at','desc')
            ->limit(10)
        ->get();

        $hoy = Carbon::now();
        $hoy = $hoy->format('d-m-Y');
        $nueva_notificacion = "";
        
        foreach ($notificaciones as $notificacion) {
            $creada = $notificacion->created_at;
            $creada = Carbon::parse($creada);
            $creada = $creada->format('d-m-Y');
            if(($notificacion->visto==0)&&($creada==$hoy)){
                $nueva_notificacion = "!! tienes una nueva notificacion de ".$notificacion->nombre." !!";
            }
        }

        return response()->json(['mensaje' => $nueva_notificacion,'sin_ver' => $numero_de_notificaciones, 'notificaciones' => $notificaciones, 'status' => 'OK', 200]);
    }
}