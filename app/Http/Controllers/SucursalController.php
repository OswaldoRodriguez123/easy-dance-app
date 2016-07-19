<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Sucursal;
use App\Academia;
use Illuminate\Support\Facades\Auth;
use Validator;

class SucursalController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function principal()
    {
        return view('configuracion.sucursales.principal')->with('usuarios', User::all());
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('configuracion.sucursales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());


        $rules = [

            'email' => 'required|email|max:255|confirmed|unique:users',
            'email_confirmation' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'responsable' => 'required'

        ];

        $messages = [

            'email.required' => 'Ups! El Correo es requerido',
            'email.email' => 'Ups! El Correo tiene una dirección inválida',
            'email.max' => 'El máximo de caracteres permitidos son 255',
            'email.unique' => 'Ups! Ya este correo ha sido registrado',
            'email.confirmed' => 'Ups! Los correos introducidos no coinciden, intenta de nuevo',
            'email_confirmation.required' => 'Ups! El Correo es requerido',
            'password.required' => 'Ups! La contraseña es requerida',
            'password.confirmed' => 'Ups! Las contraseñas introducidas no coinciden, intenta de nuevo',
            'password.min' => 'Ups! La contraseña debe contener un mínimo de 6 caracteres',
            'password_confirmation.required' => 'Ups! La contraseña es requerida',
            'responsable.required' => 'Ups! Debe agregar un Responsable o Coordinaor'

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{

            $sucursal = Academia::select('academias.sucursal_id')
                            ->where('academias.id','=',Auth::user()->academia_id)
                            ->first();


            $academia = new Academia;
            $academia->sucursal_id = $sucursal->sucursal_id;
            $academia->save();

            $request->email = trim($request->email);


            //$nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($data['nombre']))));

            User::create([

                'academia_id' => $academia->id,
                //'nombre' => $nombre,
                //'telefono' => $data['telefono'],
                'como_nos_conociste_id' => 1,
                'email' => strtolower($request->email),
                'password' => bcrypt($request->password)

            ]);

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);            

        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
