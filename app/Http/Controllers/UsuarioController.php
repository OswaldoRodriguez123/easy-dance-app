<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\ConfigEspecialidades;
use App\Paises;
use App\ComoNosConociste;
use Validator;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function perfil()
    {
        $config['center'] = '10.6913156,-71.6800493';
        $config['zoom'] = 14;
        \Gmaps::initialize($config);

        $marker = array();
        $marker['position'] = '10.6913156,-71.6800493';
        $marker['draggable'] = true;
        $marker['ondragend'] = 'addFieldText(event.latLng.lat(), event.latLng.lng());';
        \Gmaps::add_marker($marker);

        $map = \Gmaps::create_map();

        return view('usuario.planilla' , compact('map'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    public function updateNombre(Request $request){

        $rules = [
            'nombre' => 'required|min:3|max:16|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            'apellido' => 'required|min:3|max:16|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        ];

        $messages = [

            'nombre.required' => 'Ups! El Nombre  es requerido ',
            'nombre.min' => 'El mínimo de caracteres permitidos son 3',
            'nombre.max' => 'El máximo de caracteres permitidos son 16',
            'nombre.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
            'apellido.required' => 'Ups! El Apellido  es requerido ',
            'apellido.min' => 'El mínimo de caracteres permitidos son 3',
            'apellido.max' => 'El máximo de caracteres permitidos son 16',
            'apellido.regex' => 'Ups! El apellido es inválido , debe ingresar sólo letras',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }
        $usuario = User::find(Auth::user()->id);

        $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->nombre))));

        $apellido = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->apellido))));

        $usuario->nombre = $nombre;
        $usuario->apellido = $apellido;

        if($usuario->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateSexo(Request $request){
        $usuario = User::find(Auth::user()->id);
        $usuario->sexo = $request->sexo;

        // return redirect("alumno/edit/{$request->id}");
        if($usuario->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateCorreo(Request $request){

    $rules = [
        'email' => 'email|max:255|unique:users,email, '.Auth::user()->id.'',
    ];

    $messages = [

        'email.email' => 'Ups! El correo tiene una dirección inválida',
        'email.max' => 'El máximo de caracteres permitidos son 255',
        'email.unique' => 'Ups! Ya este correo ha sido registrado',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        // return redirect("alumno/edit/{$request->id}")

        // ->withErrors($validator)
        // ->withInput();

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }

    else{

        $usuario = User::find(Auth::user()->id);
        $usuario->email = $request->email;

        if($usuario->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function updateTelefono(Request $request){

        $usuario = User::find(Auth::user()->id);
        $usuario->telefono = $request->telefono;
        $usuario->celular = $request->celular;

        if($usuario->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateDireccion(Request $request){
        $usuario = User::find(Auth::user()->id);
        $usuario->direccion = $request->direccion;
        
        if($usuario->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }


    public function updateRedes(Request $request){

        $usuario = User::find(Auth::user()->id);
        $usuario->facebook = $request->facebook;
        $usuario->twitter = $request->twitter;
        $usuario->instagram = $request->instagram;
        $usuario->pagina_web = $request->pagina_web;
        $usuario->linkedin = $request->linkedin;
        $usuario->youtube = $request->youtube;
        
        if($usuario->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updatePassword(Request $request){

    $rules = [
        'password' => 'required|min:6|confirmed',
        'password_confirmation' => 'required',
    ];

    $messages = [

        'password.required' => 'Ups! La contraseña es requerida',
        'password.confirmed' => 'Ups! Las contraseñas introducidas no coinciden, intenta de nuevo',
        'password.min' => 'Ups! La contraseña debe contener un mínimo de 6 caracteres',
        'password_confirmation.required' => 'Ups! La contraseña es requerida',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        // return redirect("alumno/edit/{$request->id}")

        // ->withErrors($validator)
        // ->withInput();

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }

    else{
        
        $usuario = User::find(Auth::user()->id);
        $usuario->password = bcrypt($request->password);

        if($usuario->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function updateImagen(Request $request)
    {

                $base64_string = substr($request->imageBase64, strpos($request->imageBase64, ",")+1);
                $path = storage_path();
                $split = explode( ';', $request->imageBase64 );
                $type =  explode( '/',  $split[0]);

                $ext = $type[1];
                
                if($ext == 'jpeg' || 'jpg'){
                    $extension = '.jpg';
                }

                if($ext == 'png'){
                    $extension = '.png';
                }

                $nombre_img = "usuario-". Auth::user()->id . $extension;
                $image = base64_decode($base64_string);

                \Storage::disk('usuario')->put($nombre_img,  $image);

                $usuario = User::find(Auth::user()->id);

                $usuario->imagen = $nombre_img;
                $usuario->save();

                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
    }

}