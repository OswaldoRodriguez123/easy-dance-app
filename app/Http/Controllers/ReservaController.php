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

    public function principal($id){

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

                $clase_grupal_array['id'] = '1-'.$clase_grupal->id;

                $clase_grupal_array['disponible'] = $cantidad_mujeres + $cantidad_hombres;

                if($clase_grupal_find->imagen){
                    $clase_grupal_array['imagen'] = "/assets/uploads/clase_grupal/{$clase_grupal_find->imagen}";
                }else{
                    $clase_grupal_array['imagen'] = "/assets/img/EASY_DANCE_3_.jpg";
                }
                
                $array['1-'.$clase_grupal->id] = $clase_grupal_array;

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

                $reservaciones = Reservacion::where('reservaciones.tipo_reservacion_id',$taller->id)
                    ->where('reservaciones_visitantes.tipo_reservacion','2')
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

                $taller_array['dia_de_semana'] = $dia;


                $taller_array['id'] = '2-'.$taller->id;

                $taller_array['disponible'] = $cantidad_mujeres + $cantidad_hombres;

                $taller_array['disponible'] = $cantidad_mujeres + $cantidad_hombres;

                if($taller_find->imagen){
                    $taller_array['imagen'] = "/assets/uploads/taller/{$taller_find->imagen}";
                }else{
                    $taller_array['imagen'] = "/assets/img/EASY_DANCE_3_.jpg";
                }
                
                $array['2-'.$taller->id] = $taller_array;

            }
        }

        return view('agendar.reservacion.principal')->with(['actividades' => $array, 'academia' => $academia, 'tipo_usuario_id' => $id]);
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

		return view('reserva.registro')->with(['id' => $id, 'como_nos_conociste' => ComoNosConociste::all(), 'academia' => $academia]);
	}

    public function completado(){
        return view('reserva.reserva_completado');
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

        }

        else{


            $tipo_reservacion = Session::get('tipo');

            $participante = Participante::where('correo',$request->correo)->first();

            if($participante){

                $tmp = Reservacion::where('tipo_reservacion', $tipo_reservacion)
                    ->where('tipo_reservacion_id', $request->tipo_id)
                    ->where('tipo_usuario_id',$participante->id)
                    ->where('tipo_usuario',3)
                    ->orderBy('created_at', 'desc')
                ->first();

                if($tmp){

                    $fecha_creacion = $tmp->created_at;
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

        }

        else{

            $participante = Participante::where('correo', $request->correo_registro)->first();

            if($participante){

                if($participante->password == $request->password_registro)
                {

                    $tipo_reservacion = Session::get('tipo');

                    $tmp = Reservacion::where('tipo_reservacion', $tipo_reservacion)
                        ->where('tipo_reservacion_id', $request->tipo_id)
                        ->where('tipo_usuario_id',$participante->id)
                        ->where('tipo_usuario',3)
                        ->orderBy('created_at', 'desc')
                    ->first();

                    if($tmp){

                        $fecha_creacion = $tmp->created_at;
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

    public function guardar_reservacion_visitante(Request $request)
    {
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

            $id_explode=explode('-', $request->reservacion);

            $find = Reservacion::where('tipo_reservacion_id', $id_explode[1])
                ->where('tipo_reservacion',$id_explode[0])
                ->where('tipo_usuario', $tipo_usuario)
                ->where('tipo_usuario_id',$request->tipo_usuario_id)
            ->first();

            if($find){
                return response()->json(['error_mensaje'=> 'Ups! Este visitante ya posee una reservación en esta actividad', 'status' => 'ERROR-RESERVA'],422);
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
            $reservacion->tipo_reservacion = $id_explode[0];
            $reservacion->tipo_reservacion_id = $id_explode[1];
            $reservacion->fecha_vencimiento = $fecha_vencimiento;

            if($reservacion->save()){

                if($tipo_reservacion == 1){
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

                        if($id_explode[0] == 1){
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

                        $client = new Client(); //GuzzleHttp\Client
                        $result = $client->get('https://sistemasmasivos.com/c3colombia/api/sendsms/send.php?user=coliseodelasalsa@gmail.com&password=k1-9L6A1rn&GSM='.$celular.'&SMSText='.urlencode($mensaje));

                    }

                }

                return response()->json(['mensaje' => '¡Excelente! La reserva se ha guardado satisfactoriamente', 'status' => 'OK', 'reservacion' => $request->reservacion, 'sexo' => $usuario->sexo, 200]);

            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
            }

        }
    }
}
