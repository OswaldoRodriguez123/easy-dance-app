<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ComoNosConociste;
use App\Reservacion;
use App\ReservacionVisitante;
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

class ReservaController extends BaseController
{

    public function principal($id){

        $clase_grupal_join = DB::table('clases_grupales')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->select('config_clases_grupales.nombre', 'clases_grupales.id', 'clases_grupales.fecha_inicio', 'clases_grupales.cantidad_hombres', 'clases_grupales.cantidad_mujeres')
            ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
            ->where('clases_grupales.deleted_at', '=', null)
        ->get();

        $talleres_join = DB::table('talleres')
            ->select('talleres.nombre', 'talleres.id', 'talleres.fecha_inicio', 'talleres.cantidad_hombres', 'talleres.cantidad_mujeres')
            ->where('talleres.academia_id','=', Auth::user()->academia_id)
            ->where('talleres.deleted_at', '=', null)
        ->get();

        $array = array();

        $academia = Academia::find(Auth::user()->academia_id);


            foreach($clase_grupal_join as $clase_grupal){
                $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);

                if($fecha > Carbon::now()){

                    $cantidad_hombres_inscripcion = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
                        ->where('inscripcion_clase_grupal.clase_grupal_id',$clase_grupal->id)
                        ->where('alumnos.sexo','M')
                    ->count();

                    $cantidad_hombres_reserva = ReservacionVisitante::join('visitantes_presenciales', 'reservaciones_visitantes.visitante_id', '=', 'visitantes_presenciales.id')
                        ->where('reservaciones_visitantes.tipo_id',$clase_grupal->id)
                        ->where('reservaciones_visitantes.tipo_reservacion','1')
                        ->where('visitantes_presenciales.sexo','M')
                    ->count();

                    $cantidad_hombres = $cantidad_hombres_inscripcion + $cantidad_hombres_reserva;

                    $cantidad_hombres = $clase_grupal->cantidad_hombres - $cantidad_hombres;

                    if($cantidad_hombres < 0){
                        $cantidad_hombres = 0;
                    }

                    $cantidad_mujeres_inscripcion = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
                        ->where('inscripcion_clase_grupal.clase_grupal_id',$clase_grupal->id)
                        ->where('alumnos.sexo','F')
                    ->count();

                    $cantidad_mujeres_reserva = ReservacionVisitante::join('visitantes_presenciales', 'reservaciones_visitantes.visitante_id', '=', 'visitantes_presenciales.id')
                        ->where('reservaciones_visitantes.tipo_id',$clase_grupal->id)
                        ->where('reservaciones_visitantes.tipo_reservacion','1')
                        ->where('visitantes_presenciales.sexo','F')
                    ->count();

                    $cantidad_mujeres = $cantidad_mujeres_inscripcion + $cantidad_mujeres_reserva;

                    $cantidad_mujeres = $clase_grupal->cantidad_mujeres - $cantidad_mujeres;

                    if($cantidad_mujeres < 0){
                        $cantidad_mujeres = 0;
                    }


                    $clase_grupal_find = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                        ->select('config_clases_grupales.imagen', 'clases_grupales.id')
                        ->where('clases_grupales.id',$clase_grupal->id)
                    ->first();

                    $collection=collect($clase_grupal);     
                    $clase_grupal_array = $collection->toArray();
                    $clase_grupal_array['cantidad_hombres'] = $cantidad_hombres;
                    $clase_grupal_array['cantidad_mujeres'] = $cantidad_mujeres;

                    $clase_grupal_array['id'] = '1-'.$clase_grupal->id;

                    $clase_grupal_array['disponible'] = $cantidad_mujeres + $cantidad_hombres;

                    if($clase_grupal_find->imagen){
                        $clase_grupal_array['imagen'] = "/assets/uploads/clase_grupal/{$clase_grupal->imagen}";
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

                    $cantidad_hombres_reserva = ReservacionVisitante::join('visitantes_presenciales', 'reservaciones_visitantes.visitante_id', '=', 'visitantes_presenciales.id')
                        ->where('reservaciones_visitantes.tipo_id',$taller->id)
                        ->where('reservaciones_visitantes.tipo_reservacion','2')
                        ->where('visitantes_presenciales.sexo','M')
                    ->count();

                    $cantidad_hombres = $cantidad_hombres_inscripcion + $cantidad_hombres_reserva;

                    $cantidad_hombres = $taller->cantidad_hombres - $cantidad_hombres;

                    if($cantidad_hombres < 0){
                        $cantidad_hombres = 0;
                    }

                    $cantidad_mujeres_inscripcion = InscripcionTaller::join('alumnos', 'inscripcion_taller.alumno_id', '=', 'alumnos.id')
                        ->where('inscripcion_taller.taller_id',$taller->id)
                        ->where('alumnos.sexo','F')
                    ->count();

                    $cantidad_mujeres_reserva = ReservacionVisitante::join('visitantes_presenciales', 'reservaciones_visitantes.visitante_id', '=', 'visitantes_presenciales.id')
                        ->where('reservaciones_visitantes.tipo_id',$taller->id)
                        ->where('reservaciones_visitantes.tipo_reservacion','2')
                        ->where('visitantes_presenciales.sexo','F')
                    ->count();

                    $cantidad_mujeres = $cantidad_mujeres_inscripcion + $cantidad_mujeres_reserva;

                    $cantidad_mujeres = $taller->cantidad_mujeres - $cantidad_mujeres;

                    if($cantidad_mujeres < 0){
                        $cantidad_mujeres = 0;
                    }

                    $taller_find = Taller::find($taller->id);

                    $collection=collect($taller);     
                    $taller_array = $collection->toArray();
                    $taller_array['cantidad_hombres'] = $cantidad_hombres;
                    $taller_array['cantidad_mujeres'] = $cantidad_mujeres;

                    $taller_array['id'] = '2-'.$taller->id;

                    $taller_array['disponible'] = $cantidad_mujeres + $cantidad_hombres;

                    $taller_array['disponible'] = $cantidad_mujeres + $cantidad_hombres;

                    if($taller_find->imagen){
                        $taller_array['imagen'] = "/assets/uploads/taller/{$taller->imagen}";
                    }else{
                        $taller_array['imagen'] = "/assets/img/EASY_DANCE_3_.jpg";
                    }
                    
                    $array['2-'.$taller->id] = $taller_array;

                }
            }

            return view('agendar.reservacion.principal')->with(['actividades' => $array, 'academia' => $academia, 'visitante_id' => $id]);
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

            $tmp = Reservacion::where('tipo_reservacion', $tipo_reservacion)->where('tipo_id', $request->tipo_id)->where('correo', $request->email)->orderBy('created_at', 'desc')->first();

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

                $reservacion = New Reservacion;

                $reservacion->academia_id = $academia->id;
                $reservacion->nombre = $request->nombre;
                $reservacion->correo = $request->email;
                $reservacion->sexo = $request->sexo;
                $reservacion->telefono = $request->telefono;
                $reservacion->celular = $request->celular;
                $reservacion->tipo_reservacion = $tipo_reservacion;
                $reservacion->tipo_id = $request->tipo_id;

                $participante = New Participante;

                $participante->nombre = $request->nombre;
                $participante->correo = $request->email;
                $participante->sexo = $request->sexo;
                $participante->telefono = $request->telefono;
                $participante->celular = $request->celular;
                $participante->password = $request->password;

                $participante->save();

                if($reservacion->save()){

                    $codigo = New Codigo;

                    $codigo->academia_id = $reservacion->academia_id;
                    $codigo->item_id = $reservacion->id;
                    $codigo->tipo = 1;
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

                    $tmp = Reservacion::where('tipo_reservacion', $tipo_reservacion)->where('tipo_id', $request->tipo_id)->where('correo', $request->correo_registro)->orderBy('created_at', 'desc')->first();

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

                        $reservacion = New Reservacion;

                        $reservacion->academia_id = $academia->id;
                        $reservacion->nombre = $participante->nombre;
                        $reservacion->correo = $participante->correo;
                        $reservacion->sexo = $participante->sexo;
                        $reservacion->telefono = $participante->telefono;
                        $reservacion->celular = $participante->celular;
                        $reservacion->tipo_reservacion = $tipo_reservacion;
                        $reservacion->tipo_id = $request->tipo_id;

                        if($reservacion->save()){

                            $codigo = New Codigo;

                            $codigo->academia_id = $reservacion->academia_id;
                            $codigo->item_id = $reservacion->id;
                            $codigo->tipo = 1;
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

            $id_explode=explode('-', $request->reservacion);
            $find = ReservacionVisitante::where('tipo_id', $id_explode[1])->where('tipo_reservacion',$id_explode[0])->first();

            if($find){
                return response()->json(['error_mensaje'=> 'Ups! Este visitante ya posee una reservación en esta actividad', 'status' => 'ERROR-RESERVA'],422);
            }

            $now = Carbon::now();

            if($request->dias_expiracion){
                $fecha_vencimiento = $now->addDays($request->dias_expiracion);
            }else{
                $fecha_vencimiento = $now->addDays(3);
            }

            $reservacion = New ReservacionVisitante;

            $reservacion->academia_id = Auth::user()->academia_id;
            $reservacion->visitante_id = $request->visitante_id;
            $reservacion->tipo_reservacion = $id_explode[0];
            $reservacion->tipo_id = $id_explode[1];
            $reservacion->fecha_vencimiento = $fecha_vencimiento;

            if($reservacion->save()){

                $visitante = Visitante::find($request->visitante_id);

                if($visitante->correo){

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
                        'correo' => $visitante->correo,
                        'nombre' => $visitante->nombre,
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

                return response()->json(['mensaje' => '¡Excelente! La reserva se ha guardado satisfactoriamente', 'status' => 'OK', 'reservacion' => $request->reservacion, 'sexo' => $visitante->sexo, 200]);

            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
            }

        }
    }
}
