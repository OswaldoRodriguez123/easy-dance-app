<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\ConfigEspecialidades;
use App\Paises;
use App\Alumno;
use App\Instructor;
use App\ComoNosConociste;
use App\Academia;
use App\PerfilEvaluativo;
use App\ConfigClasesPersonalizadas;
use Validator;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Image;
use DB;
use Session;

class UsuarioController extends BaseController {


    public function perfil()
    {   
        $usuario_tipo = Session::get('easydance_usuario_tipo');
        $usuario_id = Session::get('easydance_usuario_id');
        if($usuario_tipo == 2 OR $usuario_tipo == 4){
            $alumno = Alumno::find($usuario_id);
            return view('usuario.planilla')->with('alumno',$alumno);
        }else{
            return view('usuario.planilla');
        }
    }

    public function perfil_evaluativo()
    {   
        $usuario_id = Session::get('easydance_usuario_id');
        $perfil = PerfilEvaluativo::where('usuario_id', $usuario_id)->first();

        if(!$perfil){
            $perfil = new PerfilEvaluativo;
            $perfil->usuario_id = $usuario_id;
            $perfil->save();
        }

        return view('usuario.planilla_evaluacion')->with('perfil', $perfil);
    }

    public function aceptar_condiciones()
    {
        $usuario = User::find(Auth::user()->id);
        $usuario->boolean_condiciones = 1;

        $usuario->save();

        return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
    }

    public function store(Request $request)
    {

        $alumno = PerfilEvaluativo::where('usuario_id', $request->usuario_id)->first();

        if(!$alumno){
            
            $alumno = new PerfilEvaluativo;
        }

        $alumno->usuario_id = $request->usuario_id;
        $alumno->aprendizaje = $request->aprendizaje;
        $alumno->actividad = $request->actividad;
        $alumno->beneficio = $request->beneficio;
        $alumno->motivado = $request->motivado;
        $alumno->dedicacion = $request->dedicacion;
        $alumno->velocidad = $request->velocidad;
        $alumno->seguridad = $request->seguridad;
        $alumno->participacion = $request->participacion;

        if($alumno->save()){

            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
        }

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

        $nombre = title_case($request->nombre);
        $apellido = title_case($request->apellido);

        $usuario->nombre = $nombre;
        $usuario->apellido = $apellido;

        if($usuario->save()){

            $usuario_tipo = Session::get('easydance_usuario_tipo');
            $usuario_id = Session::get('easydance_usuario_id');

            if($usuario_tipo == 2){

                $alumno = Alumno::find($usuario_id);

                if($alumno){

                    $alumno->nombre = $nombre;
                    $alumno->apellido = $apellido;

                    if($alumno->save()){

                        return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

                    }else{
                        return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                    }
                }
            }

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

            $usuario_tipo = Session::get('easydance_usuario_tipo');
            $usuario_id = Session::get('easydance_usuario_id');

            if($usuario_tipo == 2){

                $alumno = Alumno::find($usuario_id);

                if($alumno){

                    $alumno->sexo = $request->sexo;

                    if($alumno->save()){

                        return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

                    }else{
                        return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                    }
                }
            }

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
        $email = strtolower($request->email);
        $usuario->email = $email;

        if($usuario->save()){

            $usuario_tipo = Session::get('easydance_usuario_tipo');
            $usuario_id = Session::get('easydance_usuario_id');

            if($usuario_tipo == 2){

                $alumno = Alumno::find($usuario_id);

                if($alumno){

                    $alumno->correo = $email;

                    if($alumno->save()){

                        return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

                    }else{
                        return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                    }
                }
            }

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

            $usuario_tipo = Session::get('easydance_usuario_tipo');
            $usuario_id = Session::get('easydance_usuario_id');

            if($usuario_tipo == 2){

                $alumno = Alumno::find($usuario_id);

                if($alumno){

                    $alumno->telefono = $request->telefono;
                    $alumno->celular = $request->celular;

                    if($alumno->save()){

                        return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

                    }else{
                        return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                    }
                }
            }

            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateDireccion(Request $request){
        $usuario = User::find(Auth::user()->id);

        $direccion = $request->direccion;

        $usuario->direccion = $direccion;
        
        if($usuario->save()){

            $usuario_tipo = Session::get('easydance_usuario_tipo');
            $usuario_id = Session::get('easydance_usuario_id');
            
            if($usuario_tipo == 2){

                $alumno = Alumno::find($usuario_id);

                if($alumno){

                    $alumno->direccion = $direccion;

                    if($alumno->save()){

                        return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

                    }else{
                        return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                    }
                }
            }
            
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
        if($request->imageBase64 AND $request->imageBase64 != 'data:,'){

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

            // \Storage::disk('usuario')->put($nombre_img,  $image);
            $img = Image::make($image)->resize(300, 300);
            $img->save('assets/uploads/usuario/'.$nombre_img);

        }else{
            $nombre_img = "";
        }

        $usuario = User::find(Auth::user()->id);

        $usuario->imagen = $nombre_img;
        $usuario->save();

        $usuario_tipo = Session::get('easydance_usuario_tipo');

        if($usuario_tipo == 3){

            if($request->imageBase64 AND $request->imageBase64 != 'data:,'){

                $nombre_img = "instructorp-". Auth::user()->id . $extension;
                $image = base64_decode($base64_string);

                // \Storage::disk('usuario')->put($nombre_img,  $image);
                $img = Image::make($image)->resize(300, 300);
                $img->save('assets/uploads/instructor/'.$nombre_img);

            }else{
                $nombre_img = "";
            }

            $instructor = Instructor::find($usuario_id);

            $instructor->imagen = $nombre_img;
            $instructor->save();

        }

        return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'imagen' => $nombre_img, 200]);
    }

    public function documentos(){

        $academia = Academia::find(Auth::user()->academia_id);
        $usuario_id = Session::get('easydance_usuario_id');

        $clase_grupal_join = DB::table('clases_grupales')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('inscripcion_clase_grupal', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
            ->select('config_clases_grupales.nombre','config_clases_grupales.condiciones', 'config_clases_grupales.id')
            ->where('inscripcion_clase_grupal.alumno_id','=', $usuario_id)
        ->get();

        $taller_join = DB::table('talleres')
            ->join('inscripcion_taller', 'inscripcion_taller.taller_id', '=', 'talleres.id')
            ->select('talleres.nombre','talleres.condiciones', 'talleres.id')
            ->where('inscripcion_taller.alumno_id','=', $usuario_id)
        ->get();

        $config_clase_personalizada = ConfigClasesPersonalizadas::where('academia_id', Auth::user()->academia_id)->first();
        
        return view('vista_alumno.normativas')->with(['academia' => $academia, 'clases_grupales' => $clase_grupal_join, 'config_clase_personalizada' => $config_clase_personalizada, 'talleres' => $taller_join]);

    }

    public function generales(){
        
        return view('normativas.generales');

    }

    public function clases_grupales(){
        
        return view('normativas.clases_grupales');

    }

    public function clases_personalizadas(){
        
        return view('normativas.clases_personalizadas');

    }

    public function diagnostico(){
        
        return view('normativas.diagnostico');

    }

}