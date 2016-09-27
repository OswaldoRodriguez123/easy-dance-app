<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ComoNosConociste;
use App\Reservacion;
use App\ClaseGrupal;
use App\Taller;
use App\ClasePersonalizada;
use App\Academia;
use App\Codigo;
use App\Participante;
use Session;
use Validator;
use Mail;
use Carbon\Carbon;

class ReservaController extends BaseController
{
   
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
}
