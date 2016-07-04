<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Academia;
use Mail;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->middleware('guest', ['except' => ['getLogout', 'checkSession']]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

       $data['email'] = trim($data['email']);
       $data['email_confirmation'] = trim($data['email_confirmation']);

       $rules = [
        'nombre' => 'required|min:3|max:30|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'telefono' => 'required',
        'email' => 'required|email|max:255|confirmed|unique:users',
        'email_confirmation' => 'required',
        'password' => 'required|min:6|confirmed',
        'password_confirmation' => 'required',
        'como_nos_conociste_id' => 'required',

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
        'password.required' => 'Ups! La contraseña es requerida',
        'password.confirmed' => 'Ups! Las contraseñas introducidas no coinciden, intenta de nuevo',
        'password.min' => 'Ups! La contraseña debe contener un mínimo de 6 caracteres',
        'password_confirmation.required' => 'Ups! La contraseña es requerida',
        'como_nos_conociste_id.required' => 'Ups! La pregunta de ¿Cómo nos conociste? es requerida ',
    ];

        return Validator::make($data, $rules, $messages);

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $academia = new Academia;

        $data['email'] = trim($data['email']);

        $academia->save();

        $array = [
           'nombre' => $data['nombre'],
           'email' => $data['email']
        ];

        Mail::send('correo.correo', $array, function($msj) use ($array){
                $msj->subject('ESTAMOS MUY FELICES DE TENERTE A BORDO');
                $msj->to($array['email']);
            });


        $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($data['nombre']))));

        return User::create([

            'academia_id' => $academia->id,
            'nombre' => $nombre,
            'telefono' => $data['telefono'],
            'como_nos_conociste_id' => $data['como_nos_conociste_id'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])

        ]);
    }

    protected function getLogin(){
        return view('login.index');
    }

    protected $loginPath = '/login';
    protected $redirectPath = '/inicio';
}
