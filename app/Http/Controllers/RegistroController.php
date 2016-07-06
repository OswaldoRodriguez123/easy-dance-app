<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Usuario;
use App\ConfigEspecialidades;
use App\Paises;
use App\ComoNosConociste;
use Validator;
use Mail;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Academia;


class RegistroController extends Controller {

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
        $sucursal = new Sucursal;
        $sucursal->save();

        $academia = new Academia;
        $academia->sucursal_id = $sucursal->id;
        $academia->save();

        $data['email'] = trim($data['email']);

        
        
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

    public function getRegister()
    {
        return $this->showRegistrationForm();
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }

        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function postRegister(Request $request)
    // {
    //     return $this->register($request);
    // }

    public function postRegister(Request $request)
    {
    $validator = $this->validator($request->all());

        if ($validator->fails()) {
            // $this->throwValidationException(
            //     $request, $validator
            // );
            
            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
        }

        Auth::guard($this->getGuard())->login($this->create($request->all()));

        // return redirect($this->redirectPath());
        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            // $this->throwValidationException(
            //     $request, $validator
            // );
            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
        }

        Auth::guard($this->getGuard())->login($this->create($request->all()));

        // return redirect($this->redirectPath());

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return string|null
     */
    protected function getGuard()
    {
        return property_exists($this, 'guard') ? $this->guard : null;
    }

    protected function getLogin(){
        return view('login.index');
    }

    protected $loginPath = '/login';
    protected $redirectPath = '/inicio';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function registrar()
    {
        return view('flujo_registro.registro')->with('como_nos_conociste' ,ComoNosConociste::all());
    }



}