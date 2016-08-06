<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Sucursal;
use App\Academia;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use Mail;

class SucursalController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function principal()
    {

        $academia = Academia::find(Auth::user()->academia_id);

        $usuarios = DB::table('users')
            ->join('academias', 'users.academia_id', '=', 'academias.id')
            ->join('sucursales', 'academias.sucursal_id', '=', 'sucursales.id')
            ->select('academias.nombre as nombre_academia', 'users.*', 'sucursales.id')
            ->where('sucursales.id','=', $academia->sucursal_id)
            ->where('users.usuario_tipo', 5)
        ->get();

        return view('configuracion.sucursales.principal')->with('usuarios', $usuarios);
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
        $request->merge(array('email' => trim($request->email)));
        $request->merge(array('email_confirmation' => trim($request->email_confirmation)));

        $rules = [

            'email' => 'required|email|max:255|confirmed|unique:users,email',
            'email_confirmation' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'responsable' => 'required|min:3|max:40|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',

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
            'responsable.required' => 'Ups! Debe agregar un Responsable o Coordinador',
            'responsable.min' => 'El mínimo de caracteres permitidos son 3',
            'responsable.max' => 'El máximo de caracteres permitidos son 40',
            'responsable.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',

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


            $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->responsable))));

            $usuario = new User;

            $usuario->academia_id = $academia->id;
            $usuario->nombre = $nombre;
            $usuario->email = strtolower($request->email);
            $usuario->como_nos_conociste_id = 1;
            $usuario->confirmation_token = str_random(40);
            $usuario->password = bcrypt($request->password);
            $usuario->usuario_tipo = 5;

            if($usuario->save())
            {

                // $link = Autologin::user($usuario);
                //$link = Autologin::to($usuario, '/inicio');
                $link = route('confirmacion', ['token' => $usuario->confirmation_token, 'email'=>$usuario->email]);

                $array = [
                   'nombre' => $usuario->nombre,
                   'email' => $usuario->email,
                   'link' => $link,
                   'contrasena' => $request->password
                ];

                Mail::send('correo.sucursal', $array, function($msj) use ($array){
                        $msj->subject('ESTAMOS MUY FELICES DE TENERTE A BORDO');
                        $msj->to($array['email']);
                    });

                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);   
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
            }
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
