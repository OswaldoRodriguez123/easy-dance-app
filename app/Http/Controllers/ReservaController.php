<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ComoNosConociste;
use App\Reservacion;
use App\ClaseGrupal;
use App\Taller;
use App\InscripcionClaseGrupal;
use App\InscripcionTaller;
use App\ClasePersonalizada;
use App\Academia;
use App\Codigo;
use App\Participante;
use App\Visitante;
use App\Alumno;
use App\User;
use App\ItemsFacturaProforma;
use Session;
use Validator;
use Mail;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class ReservaController extends BaseController
{

    public function principal(){

        $reservaciones = Reservacion::withTrashed()->where('academia_id',Auth::user()->academia_id)->get();

        $in = array(2,4);

        $array = array();

        foreach($reservaciones as $reservacion){

            if($reservacion->tipo_reservacion == 1){
                $actividad = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id') 
                    ->select('config_clases_grupales.nombre')
                    ->where('clases_grupales.id',$reservacion->tipo_reservacion_id)
                ->first();
                if($actividad){
                    $actividad = $actividad->nombre;
                }else{
                    continue;
                }
            }else{
                $actividad = Taller::find($reservacion->tipo_reservacion_id);
                if($actividad){
                    $actividad = $actividad->nombre;
                }else{
                    continue;
                } 
            }

            if($reservacion->tipo_usuario == 1){

                $alumno = Alumno::withTrashed()->find($reservacion->tipo_usuario_id);

                if($alumno){
                    $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                        ->where('usuarios_tipo.tipo_id',$alumno->id)
                        ->whereIn('usuarios_tipo.tipo',$in)
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
                }else{
                   continue; 
                }
            }else if($reservacion->tipo_usuario == 2){
                $alumno = Visitante::withTrashed()->find($reservacion->tipo_usuario_id);
                if(!$alumno){
                    continue; 
                }
                $imagen = '';
            }else{
                $alumno = Participante::find($reservacion->tipo_usuario_id);
                if(!$alumno){
                    continue; 
                }
                $imagen = '';
            }

            if($reservacion->deleted_at){
                $estatus = 0;
            }else{
                $estatus = 1;
            }

            if($alumno->fecha_nacimiento){
                $edad = Carbon::createFromFormat('Y-m-d', $alumno->fecha_nacimiento)->diff(Carbon::now())->format('%y');
            }else{
                $edad = 21;
            }

            $collection=collect($reservacion);     
            $reservacion_array = $collection->toArray();
            $reservacion_array['imagen'] = $imagen;
            $reservacion_array['nombre'] = $alumno->nombre;
            $reservacion_array['apellido'] = $alumno->apellido;
            $reservacion_array['actividad'] = $actividad;
            $reservacion_array['sexo'] = $alumno->sexo;
            $reservacion_array['edad'] = $edad;
            $reservacion_array['estatus'] = $estatus;
            $array[] = $reservacion_array;
        
        }

        return view('agendar.reservacion.principal')->with(['reservaciones' => $array]);
    }

    public function actividades($id){

        $clase_grupal_join = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->select('config_clases_grupales.nombre', 'clases_grupales.id', 'clases_grupales.fecha_inicio', 'clases_grupales.cantidad_hombres', 'clases_grupales.cantidad_mujeres', 'clases_grupales.hora_inicio','clases_grupales.hora_final')
            ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
        ->get();

        $talleres_join = Taller::where('academia_id','=', Auth::user()->academia_id)->get();

        $array = array();
        $academia = Academia::find(Auth::user()->academia_id);
        $cantidad_mujeres_reserva = 0;
        $cantidad_hombres_reserva = 0;

        foreach($clase_grupal_join as $clase_grupal){

            $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);

            if($fecha > Carbon::now()){

                $cantidad_hombres_inscripcion = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
                    ->where('inscripcion_clase_grupal.clase_grupal_id',$clase_grupal->id)
                    ->where('alumnos.sexo','M')
                ->count();

                $cantidad_mujeres_inscripcion = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
                    ->where('inscripcion_clase_grupal.clase_grupal_id',$clase_grupal->id)
                    ->where('alumnos.sexo','F')
                ->count();

                $reservaciones = Reservacion::where('reservaciones.tipo_reservacion_id',$clase_grupal->id)
                    ->where('tipo_reservacion','1')
                ->get();

                foreach($reservaciones as $reservacion){
                    if($reservacion->tipo_usuario == 1){
                        $usuario = Alumno::withTrashed()->find($reservacion->tipo_usuario_id);
                        if($usuario->sexo == 'M'){
                            $cantidad_hombres_reserva++;
                        }else{
                            $cantidad_mujeres_reserva++;
                        }
                    }else if($reservacion->tipo_usuario == 2){
                        $usuario = Visitante::withTrashed()->find($reservacion->tipo_usuario_id);
                        if($usuario->sexo == 'M'){
                            $cantidad_hombres_reserva++;
                        }else{
                            $cantidad_mujeres_reserva++;
                        }
                    }else{
                        $usuario = Participante::find($reservacion->tipo_usuario_id);
                        if($usuario->sexo == 'M'){
                            $cantidad_hombres_reserva++;
                        }else{
                            $cantidad_mujeres_reserva++;
                        }
                    }
                }

                $cantidad_hombres = $cantidad_hombres_inscripcion + $cantidad_hombres_reserva;
                $cantidad_hombres = $clase_grupal->cantidad_hombres - $cantidad_hombres;

                if($cantidad_hombres < 0){
                    $cantidad_hombres = 0;
                }

                $cantidad_mujeres = $cantidad_mujeres_inscripcion + $cantidad_mujeres_reserva;
                $cantidad_mujeres = $clase_grupal->cantidad_mujeres - $cantidad_mujeres;

                if($cantidad_mujeres < 0){
                    $cantidad_mujeres = 0;
                }


                $clase_grupal_find = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                    ->select('config_clases_grupales.imagen', 'clases_grupales.id')
                    ->where('clases_grupales.id',$clase_grupal->id)
                ->first();

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
                $clase_grupal_array['cantidad_hombres'] = $cantidad_hombres;
                $clase_grupal_array['cantidad_mujeres'] = $cantidad_mujeres;
                $clase_grupal_array['dia_de_semana']=$dia;
                $clase_grupal_array['tipo']=1;

                $clase_grupal_array['disponible'] = $cantidad_mujeres + $cantidad_hombres;

                if($clase_grupal_find->imagen){
                    $clase_grupal_array['imagen'] = "/assets/uploads/clase_grupal/{$clase_grupal_find->imagen}";
                }else{
                    $clase_grupal_array['imagen'] = "/assets/img/EASY_DANCE_3_.jpg";
                }
                
                $array[] = $clase_grupal_array;

            }
        }

        foreach($talleres_join as $taller){

            $fecha = Carbon::createFromFormat('Y-m-d', $taller->fecha_inicio);

            if($fecha > Carbon::now()){

                $cantidad_hombres_inscripcion = InscripcionTaller::join('alumnos', 'inscripcion_taller.alumno_id', '=', 'alumnos.id')
                    ->where('inscripcion_taller.taller_id',$taller->id)
                    ->where('alumnos.sexo','M')
                ->count();

                $cantidad_mujeres_inscripcion = InscripcionTaller::join('alumnos', 'inscripcion_taller.alumno_id', '=', 'alumnos.id')
                    ->where('inscripcion_taller.taller_id',$taller->id)
                    ->where('alumnos.sexo','F')
                ->count();

                $reservaciones = Reservacion::where('tipo_reservacion_id',$taller->id)
                    ->where('tipo_reservacion','2')
                ->get();

                foreach($reservaciones as $reservacion){
                    if($reservacion->tipo_usuario == 1){
                        $usuario = Alumno::withTrashed()->find($reservacion->tipo_usuario_id);
                        if($usuario->sexo == 'M'){
                            $cantidad_hombres_reserva++;
                        }else{
                            $cantidad_mujeres_reserva++;
                        }
                    }else if($reservacion->tipo_usuario == 2){
                        $usuario = Visitante::withTrashed()->find($reservacion->tipo_usuario_id);
                        if($usuario->sexo == 'M'){
                            $cantidad_hombres_reserva++;
                        }else{
                            $cantidad_mujeres_reserva++;
                        }
                    }else{
                        $usuario = Participante::find($reservacion->tipo_usuario_id);
                        if($usuario->sexo == 'M'){
                            $cantidad_hombres_reserva++;
                        }else{
                            $cantidad_mujeres_reserva++;
                        }
                    }
                }


                $cantidad_hombres = $cantidad_hombres_inscripcion + $cantidad_hombres_reserva;

                $cantidad_hombres = $taller->cantidad_hombres - $cantidad_hombres;

                if($cantidad_hombres < 0){
                    $cantidad_hombres = 0;
                }

                $cantidad_mujeres = $cantidad_mujeres_inscripcion + $cantidad_mujeres_reserva;

                $cantidad_mujeres = $taller->cantidad_mujeres - $cantidad_mujeres;

                if($cantidad_mujeres < 0){
                    $cantidad_mujeres = 0;
                }

                $taller_find = Taller::find($taller->id);

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

                $collection=collect($taller);     
                $taller_array = $collection->toArray();
                $taller_array['cantidad_hombres'] = $cantidad_hombres;
                $taller_array['cantidad_mujeres'] = $cantidad_mujeres;
                $taller_array['disponible'] = $cantidad_mujeres + $cantidad_hombres;
                $taller_array['dia_de_semana'] = $dia;
                $taller_array['tipo']=2;

                if($taller_find->imagen){
                    $taller_array['imagen'] = "/assets/uploads/taller/{$taller_find->imagen}";
                }else{
                    $taller_array['imagen'] = "/assets/img/EASY_DANCE_3_.jpg";
                }
                
                $array[] = $taller_array;

            }
        }

        return view('agendar.reservacion.actividades')->with(['actividades' => $array, 'academia' => $academia, 'tipo_usuario_id' => $id]);
    }
   
	public function reserva($id)
	{
        $tipo_reservacion = Session::get('tipo');

        if($tipo_reservacion == 1){
            $clasegrupal = ClaseGrupal::find($id);
            $academia = Academia::find($clasegrupal->academia_id);
        }else if($tipo_reservacion == 2){
            $taller = Taller::find($id);
            $academia = Academia::find($taller->academia_id);
        }
        else{
            $clase_personalizada = ClasePersonalizada::find($id);
            $academia = Academia::find($clase_personalizada->academia_id);
        }

		return view('agendar.reservacion.registro')->with(['id' => $id, 'como_nos_conociste' => ComoNosConociste::all(), 'academia' => $academia]);
	}

    public function completado(){
        return view('agendar.reservacion.reserva_completado');
    }

    public function GuardarTipo($id)
    {

        Session::put('tipo', $id);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function GuardarTipoUsuario($id)
    {

        Session::put('tipo_usuario', $id);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }


    public function store(Request $request)
    {
        $request->merge(array('email' => trim($request->email)));
        $request->merge(array('email_confirmation' => trim($request->email_confirmation)));

        $rules = [
            'nombre' => 'required|min:3|max:30|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            'celular' => 'required',
            'email' => 'required|email|max:255|confirmed|unique:participantes,correo',
            'email_confirmation' => 'required',
            'sexo' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',

        ];

        $messages = [

            'nombre.required' => 'Ups! El Nombre  es requerido',
            'celular.required' => 'Ups! El Número móvil es requerido',
            'email.required' => 'Ups! El Correo es requerido',
            'email.email' => 'Ups! El Correo tiene una dirección inválida',
            'email.max' => 'El máximo de caracteres permitidos son 255',
            'email.unique' => 'Ups! Ya este correo ha sido registrado',
            'email.confirmed' => 'Ups! Los correos introducidos no coinciden, intenta de nuevo',
            'email_confirmation.required' => 'Ups! El Correo es requerido',
            'sexo.required' => 'Ups! El sexo es requerido ',
            'password.required' => 'Ups! La contraseña es requerida',
            'password.confirmed' => 'Ups! Las contraseñas introducidas no coinciden, intenta de nuevo',
            'password.min' => 'Ups! La contraseña debe contener un mínimo de 6 caracteres',
            'password_confirmation.required' => 'Ups! La contraseña es requerida',
            'correo.unique' => 'Ups! Ya este correo ha sido registrado',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{


            $tipo_reservacion = Session::get('tipo');

            $participante = Participante::where('correo',$request->correo)->first();

            if($participante){

                $reservacion = Reservacion::where('tipo_reservacion', $tipo_reservacion)
                    ->where('tipo_reservacion_id', $request->tipo_id)
                    ->where('tipo_usuario_id',$participante->id)
                    ->where('tipo_usuario',3)
                    ->orderBy('created_at', 'desc')
                ->first();

                if($reservacion){

                    $fecha_creacion = $reservacion->created_at;
                    $hora_limite = $fecha_creacion->addHours(48);

                    if(Carbon::now() > $hora_limite){
                        $tiene_reservacion = null;
                    }else{
                        $tiene_reservacion = 'Si';
                    }

                }else{
                    $tiene_reservacion = null;
                }
            }else{
                $tiene_reservacion = null;
            }

            if(!$tiene_reservacion){

                do{

                    $codigo_validacion = str_random(8);
                    $find = Codigo::where('codigo_validacion', $codigo_validacion)->first();

                }while ($find);

                if($tipo_reservacion == 1){
                    $actividad = 'una Clase Grupal';
                    $actividad2 = 'la Clase Grupal';
                    $actividad_nombre = ClaseGrupal::find($request->tipo_id);

                    $academia = Academia::find($actividad_nombre->academia_id);
                }else if($tipo_reservacion == 2){

                    $actividad = 'un Taller';
                    $actividad2 = 'el Taller';
                    $actividad_nombre = Taller::find($request->tipo_id);
                    $academia = Academia::find($actividad_nombre->academia_id);
                }else{
                    $actividad = 'una Clase Personalizada';
                    $actividad2 = 'la Clase Personalizada';
                    $actividad_nombre = ClasePersonalizada::find($request->tipo_id);
                    $academia = Academia::find($actividad_nombre->academia_id);
                }

                $participante = New Participante;

                $participante->nombre = $request->nombre;
                $participante->correo = $request->email;
                $participante->sexo = $request->sexo;
                $participante->telefono = $request->telefono;
                $participante->celular = $request->celular;
                $participante->password = $request->password;

                $participante->save();

                $fecha_vencimiento = Carbon::now()->addDays(3);

                $reservacion = New Reservacion;

                $reservacion->academia_id = $academia->id;
                $reservacion->tipo_reservacion = $tipo_reservacion;
                $reservacion->tipo_reservacion_id = $request->tipo_id;
                $reservacion->tipo_usuario = 3;
                $reservacion->tipo_usuario_id = $participante->id;
                $reservacion->fecha_vencimiento = $fecha_vencimiento;
                $reservacion->fecha_reservacion = Carbon::now()->toDateString();

                if($reservacion->save()){

                    $codigo = New Codigo;

                    $codigo->academia_id = $reservacion->academia_id;
                    $codigo->item_id = $reservacion->id;
                    $codigo->tipo = 2;
                    $codigo->codigo_validacion = $codigo_validacion;
                    $codigo->fecha_vencimiento = Carbon::now()->addMonth()->toDateString();

                    if($codigo->save()){

                        $subj = 'Has realizado una reservación';
                        $subj2 = 'Han realizado una reservación';

                        $array = [
                            'correo' => $request->email,
                            'nombre' => $request->nombre,
                            'actividad' => $actividad,
                            'academia' => $academia->nombre,
                            'codigo' => $codigo_validacion,
                            'correo_academia' => $academia->correo,
                            'telefono' => $academia->telefono,
                            'celular' => $academia->celular,
                            'subj' => $subj
                        ];

                        $array2 = [
                            'correo' => $request->email,
                            'nombre' => $request->nombre,
                            'actividad' => $actividad2,
                            'actividad_nombre' => $actividad_nombre->nombre,
                            'correo_academia' => $academia->correo,
                            'telefono' => $request->telefono,
                            'celular' => $request->celular,
                            'subj' => $subj2
                        ];

                        Mail::send('correo.reservacion_alumno', $array, function($msj) use ($array){
                            $msj->subject($array['subj']);
                            $msj->to($array['correo']);
                        });


                        Mail::send('correo.reservacion_academia', $array2, function($msj) use ($array){
                            $msj->subject($array['subj']);
                            $msj->to($array['correo_academia']);
                        });

                        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

                        }else{
                            return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
                        }

                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
                }
            }else{
                return response()->json(['error_mensaje'=> 'Ups! Ya posees una reservación para esta actividad', 'status' => 'ERROR'],422);
            }
        }
    }

    public function storeconusuario(Request $request)
    {
        $request->merge(array('correo_registro' => trim($request->correo_registro)));

        $rules = [
            'correo_registro' => 'required|email',
            'password_registro' => 'required',

        ];

        $messages = [

            'correo_registro.required' => 'Ups! El Correo es requerido',
            'correo_registro.email' => 'Ups! El Correo tiene una dirección inválida',
            'password_registro.required' => 'Ups! La contraseña es requerida',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{

            $participante = Participante::where('correo', $request->correo_registro)->first();

            if($participante){

                if($participante->password == $request->password_registro){

                    $tipo_reservacion = Session::get('tipo');

                    $reservacion = Reservacion::where('tipo_reservacion', $tipo_reservacion)
                        ->where('tipo_reservacion_id', $request->tipo_id)
                        ->where('tipo_usuario_id',$participante->id)
                        ->where('tipo_usuario',3)
                        ->orderBy('created_at', 'desc')
                    ->first();

                    if($reservacion){

                        $fecha_creacion = $reservacion->created_at;
                        $hora_limite = $fecha_creacion->addHours(48);

                        if(Carbon::now() > $hora_limite){
                            $tiene_reservacion = null;
                        }else{
                            $tiene_reservacion = 'Si';
                        }

                    }else{
                        $tiene_reservacion = null;
                    }

                    if(!$tiene_reservacion){

                        do{

                            $codigo_validacion = str_random(8);
                            $find = Codigo::where('codigo_validacion', $codigo_validacion)->first();

                        }while ($find);

                        if($tipo_reservacion == 1){
                            $actividad = 'una Clase Grupal';
                            $actividad2 = 'la Clase Grupal';
                            $actividad_nombre = ClaseGrupal::find($request->tipo_id);

                            $academia = Academia::find($actividad_nombre->academia_id);
                        }else if($tipo_reservacion == 2){

                            $actividad = 'un Taller';
                            $actividad2 = 'el Taller';
                            $actividad_nombre = Taller::find($request->tipo_id);
                            $academia = Academia::find($actividad_nombre->academia_id);
                        }else{
                            $actividad = 'una Clase Personalizada';
                            $actividad2 = 'la Clase Personalizada';
                            $actividad_nombre = ClasePersonalizada::find($request->tipo_id);
                            $academia = Academia::find($actividad_nombre->academia_id);
                        }

                        $fecha_vencimiento = Carbon::now()->addDays(3);

                        $reservacion = New Reservacion;

                        $reservacion->academia_id = $academia->id;
                        $reservacion->tipo_reservacion = $tipo_reservacion;
                        $reservacion->tipo_reservacion_id = $request->tipo_id;
                        $reservacion->tipo_usuario = 3;
                        $reservacion->tipo_usuario_id = $participante->id;
                        $reservacion->fecha_vencimiento = $fecha_vencimiento;
                        $reservacion->fecha_reservacion = Carbon::now()->toDateString();

                        if($reservacion->save()){

                            $codigo = New Codigo;

                            $codigo->academia_id = $reservacion->academia_id;
                            $codigo->item_id = $reservacion->id;
                            $codigo->tipo = 2;
                            $codigo->codigo_validacion = $codigo_validacion;
                            $codigo->fecha_vencimiento = Carbon::now()->addMonth()->toDateString();

                            if($codigo->save()){

                                $subj = 'Has realizado una reservación';
                                $subj2 = 'Han realizado una reservación';

                                $array = [
                                    'correo' => $participante->correo,
                                    'nombre' => $participante->nombre,
                                    'actividad' => $actividad,
                                    'academia' => $academia->nombre,
                                    'codigo' => $codigo_validacion,
                                    'correo_academia' => $academia->correo,
                                    'telefono' => $academia->telefono,
                                    'celular' => $academia->celular,
                                    'subj' => $subj
                                ];

                                $array2 = [
                                    'correo' => $participante->correo,
                                    'nombre' => $participante->nombre,
                                    'actividad' => $actividad2,
                                    'actividad_nombre' => $actividad_nombre->nombre,
                                    'correo_academia' => $academia->correo,
                                    'telefono' => $participante->telefono,
                                    'celular' => $participante->celular,
                                    'subj' => $subj2
                                ];

                                Mail::send('correo.reservacion_alumno', $array, function($msj) use ($array){
                                        $msj->subject($array['subj']);
                                        $msj->to($array['correo']);
                                    });


                                Mail::send('correo.reservacion_academia', $array2, function($msj) use ($array){
                                        $msj->subject($array['subj']);
                                        $msj->to($array['correo_academia']);
                                    });

                                 return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

                                }else{
                                    return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
                                }

                        }else{
                            return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
                        }
                    }else{
                        return response()->json(['error_mensaje'=> 'Ups! Ya posees una reservación para esta actividad', 'status' => 'ERROR'],422);
                    }
                }else{
                    return response()->json(['errores' => ['password_registro' => [0, 'Ups! La contraseña es incorrecta, intente nuevamente']], 'status' => 'ERROR'],422);
                }
            }else{
                return response()->json(['errores' => ['correo_registro' => [0, 'Ups! No Hemos encontrado la siguiente información del correo asociada a tu cuenta']], 'status' => 'ERROR'],422);
            }
        }
    }

    public function guardar_reservacion(Request $request){

        $rules = [
            'dias_expiracion' => 'numeric'

        ];

        $messages = [

            'dias_expiracion.required' => 'Ups! El campo debe ser numerico',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $tipo_usuario = Session::get('tipo_usuario');

            $find = Reservacion::where('tipo_reservacion_id', $request->id)
                ->where('tipo_reservacion',$request->tipo)
                ->where('tipo_usuario', $tipo_usuario)
                ->where('tipo_usuario_id',$request->tipo_usuario_id)
            ->first();

            if($find){
                return response()->json(['error_mensaje'=> 'Ups! Este usuario ya posee una reservación en esta actividad', 'status' => 'ERROR-RESERVA'],422);
            }

            $now = Carbon::now();

            if($request->dias_expiracion){
                $fecha_vencimiento = $now->addDays($request->dias_expiracion);
            }else{
                $fecha_vencimiento = $now->addDays(3);
            }

            $reservacion = New Reservacion;

            $reservacion->academia_id = Auth::user()->academia_id;
            $reservacion->tipo_usuario = $tipo_usuario;
            $reservacion->tipo_usuario_id = $request->tipo_usuario_id;
            $reservacion->tipo_reservacion = $request->tipo;
            $reservacion->tipo_reservacion_id = $request->id;
            $reservacion->fecha_vencimiento = $fecha_vencimiento;
            $reservacion->fecha_reservacion = Carbon::now()->toDateString();

            if($reservacion->save()){

                if($tipo_usuario == 1){
                    $usuario = Alumno::find($request->tipo_usuario_id);
                }else{
                    $usuario = Visitante::find($request->tipo_usuario_id);
                }

                if($usuario->correo){

                    do{

                        $codigo_validacion = str_random(8);
                        $find = Codigo::where('codigo_validacion', $codigo_validacion)->first();

                    }while ($find);

                    $academia = Academia::find($reservacion->academia_id);

                    $codigo = New Codigo;

                    $codigo->academia_id = $reservacion->academia_id;
                    $codigo->item_id = $reservacion->id;
                    $codigo->tipo = 2;
                    $codigo->codigo_validacion = $codigo_validacion;
                    $codigo->fecha_vencimiento = $fecha_vencimiento;

                    if($codigo->save()){

                        if($request->tipo == 1){
                            $actividad = 'una Clase Grupal';

                        }else{
                            $actividad = 'un Taller';
                        }

                        $subj = 'Has realizado una reservación';

                        $array = [
                            'correo' => $usuario->correo,
                            'nombre' => $usuario->nombre,
                            'actividad' => $actividad,
                            'academia' => $academia->nombre,
                            'codigo' => $codigo_validacion,
                            'correo_academia' => $academia->correo,
                            'telefono' => $academia->telefono,
                            'celular' => $academia->celular,
                            'subj' => $subj
                        ];

                        Mail::send('correo.reservacion_alumno', $array, function($msj) use ($array){
                            $msj->subject($array['subj']);
                            $msj->to($array['correo']);
                        });
                    }
                }

                if($usuario->celular){

                    $celular = getLimpiarNumero($usuario->celular);
                    $academia = Academia::find(Auth::user()->academia_id);

                    if($academia->pais_id == 11 && strlen($celular) == 10){
                        
                        $mensaje = $usuario->nombre.'. Hemos reservado para ti una clase de baile para la fecha '.$fecha_vencimiento.', tu código para confirmar tu inscripcion es '.$codigo_validacion.'.';

                        $client = new Client();
                        
                        $result = $client->get('https://sistemasmasivos.com/c3colombia/api/sendsms/send.php?user=coliseodelasalsa@gmail.com&password=k1-9L6A1rn&GSM='.$celular.'&SMSText='.urlencode($mensaje));

                    }

                }

                return response()->json(['mensaje' => '¡Excelente! La reserva se ha guardado satisfactoriamente', 'status' => 'OK', 'id' => $request->tipo.'-'.$request->id, 'sexo' => $usuario->sexo, 200]);

            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
            }

        }
    }

    public function inscribir($id){

        $reservacion = Reservacion::withTrashed()->find($id);

        if($reservacion){

            if($reservacion->tipo_usuario == 1){

                $alumno = Alumno::withTrashed()->find($reservacion->tipo_usuario_id);

            }else if($reservacion->tipo_usuario == 2){

                $visitante = Visitante::withTrashed()->find($reservacion->tipo_usuario_id);
                $alumno = Alumno::withTrashed()->where('correo',$visitante->correo)->first();

                if(!$alumno){

                    do{
                        $codigo_referido = str_random(8);
                        $find = Alumno::where('codigo_referido', $codigo_referido)->first();
                    }while ($find);

                    $alumno = new Alumno;

                    $alumno->academia_id = $visitante->academia_id;
                    $alumno->nombre = $visitante->nombre;
                    $alumno->apellido = $visitante->apellido;
                    $alumno->sexo = $visitante->sexo;
                    $alumno->correo = $visitante->correo;
                    $alumno->telefono = $visitante->telefono;
                    $alumno->celular = $visitante->celular;
                    $alumno->fecha_nacimiento = $visitante->fecha_nacimiento;
                    $alumno->direccion = $visitante->direccion;
                    $alumno->codigo_referido = $codigo_referido;

                    if($alumno->save()){

                        if($alumno->correo){

                            $password = str_random(8);

                            $usuario = new User;

                            $usuario->academia_id = $visitante->academia_id;
                            $usuario->nombre = $alumno->nombre;
                            $usuario->apellido = $alumno->apellido;
                            $usuario->telefono = $alumno->telefono;
                            $usuario->celular = $alumno->celular;
                            $usuario->sexo = $alumno->sexo;
                            $usuario->email = $alumno->correo;
                            $usuario->como_nos_conociste_id = 1;
                            $usuario->direccion = $alumno->direccion;
                            $usuario->confirmation_token = str_random(40);
                            $usuario->password = bcrypt($password);
                            $usuario->usuario_id = $alumno->id;
                            $usuario->usuario_tipo = 2;

                            $usuario->save();

                            $usuario_tipo = new UsuarioTipo;
                            $usuario_tipo->usuario_id = $usuario->id;
                            $usuario_tipo->tipo = 2;
                            $usuario_tipo->tipo_id = $alumno->id;
                            $usuario_tipo->save();

                        }

                    }
                }

                $visitante->cliente = 1;
                $visitante->save();

            }else{

                $participante = Participante::find($reservacion->tipo_usuario_id);
                $alumno = Alumno::withTrashed()->where('correo',$participante->correo)->first();

                if(!$alumno){

                    do{
                        $codigo_referido = str_random(8);
                        $find = Alumno::where('codigo_referido', $codigo_referido)->first();
                    }while ($find);

                    $alumno = new Alumno;

                    $alumno->academia_id = Auth::user()->academia_id;
                    $alumno->nombre = $participante->nombre;
                    $alumno->apellido = $participante->apellido;
                    $alumno->sexo = $participante->sexo;
                    $alumno->correo = $participante->correo;
                    $alumno->telefono = $participante->telefono;
                    $alumno->celular = $participante->celular;
                    $alumno->fecha_nacimiento = Carbon::now()->toDateString();
                    $alumno->direccion = '';
                    $alumno->codigo_referido = $codigo_referido;

                    if($alumno->save()){

                        if($alumno->correo){

                            $password = str_random(8);

                            $usuario = new User;

                            $usuario->academia_id = Auth::user()->academia_id;
                            $usuario->nombre = $alumno->nombre;
                            $usuario->apellido = $alumno->apellido;
                            $usuario->telefono = $alumno->telefono;
                            $usuario->celular = $alumno->celular;
                            $usuario->sexo = $alumno->sexo;
                            $usuario->email = $alumno->correo;
                            $usuario->como_nos_conociste_id = 1;
                            $usuario->direccion = $alumno->direccion;
                            $usuario->confirmation_token = str_random(40);
                            $usuario->password = bcrypt($password);
                            $usuario->usuario_id = $alumno->id;
                            $usuario->usuario_tipo = 2;

                            $usuario->save();

                        }

                    }
                }
            }
        
            if($reservacion->tipo_reservacion == 1){

                $alumnosclasegrupal = InscripcionClaseGrupal::where('alumno_id', $alumno->id)
                    ->where('clase_grupal_id', $reservacion->tipo_id)
                ->first();
                
                if(!$alumnosclasegrupal){

                    $clasegrupal = ClaseGrupal::join('config_clases_grupales', 'config_clases_grupales.id', '=', 'clases_grupales.clase_grupal_id')
                        ->select('config_clases_grupales.*', 'clases_grupales.id', 'clases_grupales.fecha_inicio_preferencial', 'clases_grupales.fecha_inicio', 'config_clases_grupales.id as clase_grupal_id')
                        ->where('clases_grupales.id', $reservacion->tipo_reservacion_id)
                    ->first();

                    $inscripcion = new InscripcionClaseGrupal;

                    $inscripcion->clase_grupal_id = $reservacion->tipo_reservacion_id;
                    $inscripcion->alumno_id = $alumno->id;
                    $inscripcion->fecha_pago = $clasegrupal->fecha_inicio_preferencial;
                    $inscripcion->fecha_inscripcion = Carbon::now()->toDateString();
                    $inscripcion->costo_mensualidad = $clasegrupal->costo_mensualidad;

                    $inscripcion->save();

                    if($clasegrupal->costo_inscripcion != 0)
                    {

                        $item_factura = new ItemsFacturaProforma;
                            
                        $item_factura->usuario_id = $alumno->id;
                        $item_factura->usuario_tipo = 1;
                        $item_factura->academia_id =  $alumno->academia_id;
                        $item_factura->fecha = Carbon::now()->toDateString();
                        $item_factura->item_id = $clasegrupal->clase_grupal_id;
                        $item_factura->nombre = 'Inscripcion ' . $clasegrupal->nombre;
                        $item_factura->tipo = 3;
                        $item_factura->cantidad = 1;
                        $item_factura->precio_neto = 0;
                        $item_factura->impuesto = 0;
                        $item_factura->importe_neto = $clasegrupal->costo_inscripcion;
                        $item_factura->fecha_vencimiento = $clasegrupal->fecha_inicio;
                            
                        $item_factura->save();

                    }

                    if($clasegrupal->costo_mensualidad != 0)
                    {

                        $item_factura = new ItemsFacturaProforma;
                            
                        $item_factura->usuario_id = $alumno->id;
                        $item_factura->usuario_tipo = 1;
                        $item_factura->academia_id = $alumno->academia_id;
                        $item_factura->fecha = Carbon::now()->toDateString();
                        $item_factura->item_id = $clasegrupal->clase_grupal_id;
                        $item_factura->nombre = 'Cuota ' . $clasegrupal->nombre;
                        $item_factura->tipo = 4;
                        $item_factura->cantidad = 1;
                        $item_factura->precio_neto = 0;
                        $item_factura->impuesto = 0;
                        $item_factura->importe_neto = $clasegrupal->costo_mensualidad;
                        $item_factura->fecha_vencimiento = $clasegrupal->fecha_inicio;
                            
                        $item_factura->save();

                    }
                }

            }else{

                $alumnostaller = InscripcionTaller::where('alumno_id', $alumno->id)
                    ->where('taller_id', $reservacion->tipo_id)
                ->first();
                
                if(!$alumnostaller){

                    $taller = Taller::find($reservacion->tipo_id);

                    $inscripcion = new InscripcionTaller;

                    $inscripcion->taller_id = $reservacion->tipo_id;
                    $inscripcion->alumno_id = $alumno->id;

                    $inscripcion->save();

                    $item_factura = new ItemsFacturaProforma;
                        
                    $item_factura->usuario_id = $alumno->id;
                    $item_factura->usuario_tipo = 1;
                    $item_factura->academia_id = $alumno->academia_id;
                    $item_factura->fecha = Carbon::now()->toDateString();
                    $item_factura->item_id = $reservacion->tipo_id;
                    $item_factura->nombre = 'Inscripcion ' . $taller->nombre;
                    $item_factura->tipo = 5;
                    $item_factura->cantidad = 1;
                    $item_factura->precio_neto = 0;
                    $item_factura->impuesto = 0;
                    $item_factura->importe_neto = $taller->costo;
                    $item_factura->fecha_vencimiento = $taller->fecha_inicio;
                        
                    $item_factura->save();

                }
            }

            $deuda = Alumno::join('items_factura_proforma', 'items_factura_proforma.usuario_id', '=', 'alumnos.id')
                ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
                ->where('alumnos.id','=', $alumno->id)
            ->sum('items_factura_proforma.importe_neto');
            
            $reservacion->boolean_confirmacion = 1;
            $reservacion->save();
            $reservacion->delete();

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'id' => $alumno->id, 'inscripcion' => $inscripcion, 'deuda' => $deuda, 'alumno' => $alumno, 200]);
        }else{
            return response()->json(['error_mensaje'=> 'Ups! La reservación no existe', 'status' => 'ERROR'],422);
        }
    
    }


    public function destroy($id){

        $reserva = Reservacion::find($id);
        
        if($reserva->forceDelete()){

            $codigo = Codigo::where('item_id',$id)->where('tipo',2)->first();

            if($codigo){

                if($codigo->delete()){
                    return response()->json(['mensaje' => '¡Excelente! La Clase Grupal se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
                }else{
                    return response()->json(['mensaje' => '¡Excelente! La Clase Grupal se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
                }
            }else{
                return response()->json(['mensaje' => '¡Excelente! La Clase Grupal se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
            }
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

    public function storeReservaVistaAlumno(Request $request){

        $rules = [
            'actividad_id' => 'required',
            'actividad_tipo' => 'required',
        ];

        $messages = [
            'actividad_id.required' => 'Ups! El Nombre  es requerido',
            'actividad_tipo.required' => 'Ups! El Nombre  es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{

            $datos = $this->getDatosUsuario();

            $alumno_id = $datos[0]['usuario_id'];
            $alumno = Alumno::find($alumno_id);

            if($request->actividad_tipo == 1){
                $actividad = ClaseGrupal::find($request->actividad_id);
            }else{
                $actividad = Taller::find($request->actividad_id);
            }
            
            if($request->permitir == 0){
                
                if($alumno->sexo == 'M'){

                    if(!is_null($actividad->cantidad_hombres)){

                        if($request->actividad_tipo == 1){
                               $hombres = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
                                ->where('inscripcion_clase_grupal.clase_grupal_id', '=', $request->actividad_id)
                                ->where('alumnos.sexo', '=', 'M')
                            ->count(); 
                        }else{
                            $hombres = InscripcionTaller::join('alumnos', 'inscripcion_taller.alumno_id', '=', 'alumnos.id')
                                ->where('inscripcion_taller.taller_id', '=', $request->actividad_id)
                                ->where('alumnos.sexo', '=', 'M')
                            ->count();
                        }

                        if($actividad->cantidad_hombres <= $hombres){
                            return response()->json(['error_mensaje'=>'Ups! La cantidad de hombres permitida en esta actividad ha llegado a su limite', 'status' => 'CANTIDAD-FULL'],422);
                        }
                    }

                }else{

                    if(!is_null($actividad->cantidad_mujeres)){

                        if($request->actividad_tipo == 1){
                            $mujeres = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
                                ->where('inscripcion_clase_grupal.clase_grupal_id', '=', $request->actividad_id)
                                ->where('alumnos.sexo', '=', 'F')
                            ->count(); 
                        }else{
                            $mujeres = InscripcionTaller::join('alumnos', 'inscripcion_taller.alumno_id', '=', 'alumnos.id')
                                ->where('inscripcion_taller.taller_id', '=', $request->actividad_id)
                                ->where('alumnos.sexo', '=', 'F')
                            ->count();
                        }

                        if($actividad->cantidad_mujeres <= $mujeres){
                            return response()->json(['error_mensaje'=>'Ups! La cantidad de mujeres permitida en esta actividad ha llegado a su limite', 'status' => 'CANTIDAD-FULL'],422);
                        }
                    }

                }
            }

            $find = Reservacion::where('tipo_reservacion_id', $request->actividad_id)
                ->where('tipo_reservacion',$request->actividad_tipo)
                ->where('tipo_usuario', 1)
                ->where('tipo_usuario_id',$alumno_id)
            ->first();

            if($find){
                return response()->json(['error_mensaje'=> 'Ups! Ya posees una reservación en esta actividad', 'status' => 'ERROR-RESERVA'],422);
            }

            $now = Carbon::now();

            if($request->dias_expiracion){
                $fecha_vencimiento = $now->addDays($request->dias_expiracion);
            }else{
                $fecha_vencimiento = $now->addDays(3);
            }

            $reservacion = New Reservacion;

            $reservacion->academia_id = Auth::user()->academia_id;
            $reservacion->tipo_usuario = 1;
            $reservacion->tipo_usuario_id = $alumno_id;
            $reservacion->tipo_reservacion = $request->actividad_tipo;
            $reservacion->tipo_reservacion_id = $request->actividad_id;
            $reservacion->fecha_vencimiento = $fecha_vencimiento;
            $reservacion->fecha_reservacion = Carbon::now()->toDateString();

            if($reservacion->save()){

                if($alumno->correo){

                    do{

                        $codigo_validacion = str_random(8);
                        $find = Codigo::where('codigo_validacion', $codigo_validacion)->first();

                    }while ($find);

                    $academia = Academia::find($reservacion->academia_id);

                    $codigo = New Codigo;

                    $codigo->academia_id = $reservacion->academia_id;
                    $codigo->item_id = $reservacion->id;
                    $codigo->tipo = 2;
                    $codigo->codigo_validacion = $codigo_validacion;
                    $codigo->fecha_vencimiento = $fecha_vencimiento;

                    if($codigo->save()){

                        if($request->tipo == 1){
                            $actividad = 'una Clase Grupal';

                        }else{
                            $actividad = 'un Taller';
                        }

                        $subj = 'Has realizado una reservación';

                        $array = [
                            'correo' => $alumno->correo,
                            'nombre' => $alumno->nombre,
                            'actividad' => $actividad,
                            'academia' => $academia->nombre,
                            'codigo' => $codigo_validacion,
                            'correo_academia' => $academia->correo,
                            'telefono' => $academia->telefono,
                            'celular' => $academia->celular,
                            'subj' => $subj
                        ];

                        Mail::send('correo.reservacion_alumno', $array, function($msj) use ($array){
                            $msj->subject($array['subj']);
                            $msj->to($array['correo']);
                        });
                    }
                }

                if($alumno->celular){

                    $celular = getLimpiarNumero($alumno->celular);
                    $academia = Academia::find(Auth::user()->academia_id);

                    if($academia->pais_id == 11 && strlen($celular) == 10){
                        
                        $mensaje = $alumno->nombre.'. Hemos reservado para ti una clase de baile para la fecha '.$fecha_vencimiento.', tu código para confirmar tu inscripcion es '.$codigo_validacion.'.';

                        $client = new Client();
                        
                        $result = $client->get('https://sistemasmasivos.com/c3colombia/api/sendsms/send.php?user=coliseodelasalsa@gmail.com&password=k1-9L6A1rn&GSM='.$celular.'&SMSText='.urlencode($mensaje));

                    }

                }

                return response()->json(['mensaje' => '¡Excelente! La reserva se ha guardado satisfactoriamente', 'status' => 'OK', 200]);

            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
            }
        }
    }
}
