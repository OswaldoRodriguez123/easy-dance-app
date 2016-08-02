<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ComoNosConociste;
use App\Reservacion;
use App\ClaseGrupal;
use App\Taller;
use App\Academia;
use Session;
use Validator;
use Mail;
use Carbon\Carbon;

class ReservaController extends BaseController
{
   
	public function reserva($id)
	{
        $tipo_reservacion = Session::get('tipo');

        if($tipo_reservacion = 1){
            $clasegrupal = ClaseGrupal::find($id);
            $academia = Academia::find($clasegrupal->academia_id);
        }else{
            $taller = Taller::find($id);
            $academia = Academia::find($taller->academia_id);
        }

		return view('reserva.registro')->with(['id' => $id, 'como_nos_conociste' => ComoNosConociste::all(), 'academia' => $academia]);
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
            'telefono' => 'required',
            'celular' => 'required',
            'email' => 'required|email|max:255|confirmed',
            'email_confirmation' => 'required',
            'sexo' => 'required',

        ];

        $messages = [

            'nombre.required' => 'Ups! El Nombre  es requerido',
            'telefono.required' => 'Ups! El Número local es requerido',
            'celular.required' => 'Ups! El Número móvil es requerido',
            'email.required' => 'Ups! El Correo es requerido',
            'email.email' => 'Ups! El Correo tiene una dirección inválida',
            'email.max' => 'El máximo de caracteres permitidos son 255',
            'email.unique' => 'Ups! Ya este correo ha sido registrado',
            'email.confirmed' => 'Ups! Los correos introducidos no coinciden, intenta de nuevo',
            'email_confirmation.required' => 'Ups! El Correo es requerido',
            'sexo.required' => 'Ups! El sexo es requerido ',
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

                    $codigo_reservacion = str_random(8);
                    $find = Reservacion::where('codigo_reservacion', $codigo_reservacion)->first();

                }while ($find);

                $reservacion = New Reservacion;

                $reservacion->nombre = $request->nombre;
                $reservacion->correo = $request->email;
                $reservacion->sexo = $request->sexo;
                $reservacion->telefono = $request->telefono;
                $reservacion->celular = $request->celular;
                $reservacion->tipo_reservacion = $tipo_reservacion;
                $reservacion->tipo_id = $request->tipo_id;
                $reservacion->codigo_reservacion = $codigo_reservacion;

                if($reservacion->save()){

                    if($tipo_reservacion = 1){
                        $actividad = 'una Clase Grupal';
                        $clasegrupal = ClaseGrupal::find($request->tipo_id);
                        $academia = Academia::find($clasegrupal->academia_id);
                    }else{
                        $actividad = 'un Taller';
                        $taller = Taller::find($request->tipo_id);
                        $academia = Academia::find($taller->academia_id);
                    }

                    $subj = 'Has realizado una reservación';

                    $array = [
                        'correo' => $request->email,
                        'nombre' => $request->nombre,
                        'actividad' => $actividad,
                        'academia' => $academia->nombre,
                        'codigo' => $codigo_reservacion,
                        'correo_academia' => $academia->correo,
                        'telefono' => $academia->telefono,
                        'celular' => $academia->celular,
                        'subj' => $subj
                    ];

                    Mail::send('correo.reservacion_alumno', $array, function($msj) use ($array){
                            $msj->subject($array['subj']);
                            $msj->to($array['correo']);
                        });

                     return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
                }
            }else{
                return response()->json(['error_mensaje'=> 'Ups! Ya posees una reservación para esta actividad', 'status' => 'ERROR'],422);
            }
        }
    }
}
