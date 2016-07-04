<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ComoNosConociste;
use App\Reservacion;
use Session;
use Validator;

class ReservaController extends Controller
{
   
	public function reserva($id)
	{
		return view('reserva.registro')->with(['id' => $id, 'como_nos_conociste' => ComoNosConociste::all()]);
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
            'email' => 'required|email|max:255|confirmed',
            'email_confirmation' => 'required',
            'sexo' => 'required',

        ];

        $messages = [

            'nombre.required' => 'Ups! El Nombre  es requerido',
            'telefono.required' => 'Ups! El Telefono es requerido',
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

            $reservacion = New Reservacion;

            $reservacion->nombre = $request->nombre;
            $reservacion->email = $request->email;
            $reservacion->sexo = $request->sexo;
            $reservacion->telefono = $request->telefono;
            $reservacion->tipo_reservacion = $tipo_reservacion;
            $reservacion->tipo_id = $request->tipo_id;

            if($reservacion->save()){

                 return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
                }
        }
    }
}
