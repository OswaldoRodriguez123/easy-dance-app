<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Instructor;
use App\ClaseGrupal;
use App\HorarioClaseGrupal;
use App\Academia;
use App\User;
use App\UsuarioTipo;
use App\PerfilInstructor;
use Mail;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Image;
use DB;
use Illuminate\Support\Facades\Session;
use App\ConfigPagosInstructor;
use App\AsistenciaInstructor;
use App\PagoInstructor;
use App\CredencialInstructor;
use App\ConfigServicios;
use App\ConfigProductos;
use App\Comision;
use App\ConfigComision;
use App\Alumno;
use App\Staff;

class InstructorController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    
    public function index()
    {
        $usuario_tipo = Session::get('easydance_usuario_tipo');

        if($usuario_tipo != 2 AND $usuario_tipo != 4){

            $instructores = Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

            $array = array();

            foreach($instructores as $instructor){

                $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                    ->where('usuarios_tipo.tipo',3)
                    ->where('usuarios_tipo.tipo_id',$instructor->id)
                ->first();

                if($usuario){

                    if($usuario->imagen){
                        $imagen = $usuario->imagen;
                        $usuario = 1;
                    }else{
                        $imagen = '';
                        $usuario = 0;
                    }

                }else{
                    $imagen = '';
                    $usuario = 0;
                }


                $collection=collect($instructor);     
                $instructor_array = $collection->toArray();

                $instructor_array['usuario']=$usuario;
                $instructor_array['imagen']=$imagen;
                $array[$instructor->id] = $instructor_array;

            }

            return view('participante.instructor.principal')->with('instructores', $array);

        }else{

            $academia = Academia::find(Auth::user()->academia_id);

            $instructores = Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->where('instructores.boolean_promocionar', 1)->get();

            return view('participante.instructor.principal_alumno')->with(['instructor_reserva' => $instructores, 'academia' => $academia]);

        }

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('participante.instructor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $request->merge(array('correo' => trim($request->correo)));


    $rules = [
        'identificacion' => 'required|min:7|numeric',
        'nombre' => 'required|min:3|max:20|regex:/^[a-z????????????????????????????????\s]+$/i',
        'apellido' => 'required|min:3|max:20|regex:/^[a-z????????????????????????????????\s]+$/i',
        'fecha_nacimiento' => 'required',
        'sexo' => 'required',
        'correo' => 'email|max:255',
    ];

    $messages = [

        'identificacion.required' => 'Ups! El identificador es requerido',
        'identificacion.min' => 'El m??nimo de numeros permitidos son 5',
        'identificacion.max' => 'El maximo de numeros permitidos son 20',
        'identificacion.numeric' => 'Ups! El identificador es inv??lido , debe contener s??lo n??meros',
        'identificacion.unique' => 'Ups! Ya este usuario ha sido registrado',
        'nombre.required' => 'Ups! El Nombre  es requerido ',
        'nombre.min' => 'El m??nimo de caracteres permitidos son 3',
        'nombre.max' => 'El m??ximo de caracteres permitidos son 20',
        'nombre.regex' => 'Ups! El nombre es inv??lido ,debe ingresar s??lo letras',
        'apellido.required' => 'Ups! El Apellido  es requerido ',
        'apellido.min' => 'El m??nimo de caracteres permitidos son 3',
        'apellido.max' => 'El m??ximo de caracteres permitidos son 20',
        'apellido.regex' => 'Ups! El apellido es inv??lido , debe ingresar s??lo letras',
        'sexo.required' => 'Ups! El Sexo  es requerido ',
        'fecha_nacimiento.required' => 'Ups! La fecha de nacimiento es requerida',
        'correo.email' => 'Ups! El correo tiene una direcci??n inv??lida',
        'correo.max' => 'El m??ximo de caracteres permitidos son 255',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        if($request->video_promocional){

            $parts = parse_url($request->video_promocional);

            if(isset($parts['host']))
            {
                if($parts['host'] == "www.youtube.com" || $parts['host'] == "www.youtu.be"){

                
                }else{
                    return response()->json(['errores' => ['video_promocional' => [0, 'Ups! ha ocurrido un error, debes ingresar un enlace de YouTube']], 'status' => 'ERROR'],422);
                }
            }else{
                    return response()->json(['errores' => ['video_promocional' => [0, 'Ups! ha ocurrido un error, debes ingresar un enlace de YouTube']], 'status' => 'ERROR'],422);
                }
            
            }

            if($request->video_testimonial){

                $parts = parse_url($request->video_testimonial);

                if(isset($parts['host']))
                {
                    if($parts['host'] == "www.youtube.com" || $parts['host'] == "www.youtu.be"){

                    
                    }else{
                        return response()->json(['errores' => ['video_testimonial' => [0, 'Ups! ha ocurrido un error, debes ingresar un enlace de YouTube']], 'status' => 'ERROR'],422);
                    }
                }else{
                        return response()->json(['errores' => ['video_testimonial' => [0, 'Ups! ha ocurrido un error, debes ingresar un enlace de YouTube']], 'status' => 'ERROR'],422);
                    }
                
            }

            $edad = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->diff(Carbon::now())->format('%y');


            if($edad < 1){
                return response()->json(['errores' => ['fecha_nacimiento' => [0, 'Ups! Esta fecha es invalida, debes ingresar una fecha superior a 1 a??o de edad']], 'status' => 'ERROR'],422);
            }

            $nombre = title_case($request->nombre);
            $apellido = title_case($request->apellido);
            $direccion = $request->direccion;
            $correo = trim(strtolower($request->correo));

            if($correo){

                $usuario = User::where('email',$correo)->first();

                if($usuario){

                    $usuario_tipo = UsuarioTipo::where('tipo',3)
                        ->where('usuario_id',$usuario->id)
                    ->first();

                    if($usuario_tipo){
                        return response()->json(['errores' => ['correo' => [0, 'Ups! Ups! Ya este correo ha sido registrado']], 'status' => 'ERROR'],422);
                    }
                }
            }

            $instructor = new Instructor;

            $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->toDateString();

            $instructor->academia_id = Auth::user()->academia_id;
            $instructor->identificacion = $request->identificacion;
            $instructor->nombre = $nombre;
            $instructor->apellido = $apellido;
            $instructor->sexo = $request->sexo;
            $instructor->fecha_nacimiento = $fecha_nacimiento;
            $instructor->correo = $correo;
            $instructor->telefono = $request->telefono;
            $instructor->celular = $request->celular;
            $instructor->direccion = $direccion;
            $instructor->alergia = $request->alergia;
            $instructor->asma = $request->asma;
            $instructor->convulsiones = $request->convulsiones;
            $instructor->cefalea = $request->cefalea;
            $instructor->hipertension = $request->hipertension;
            $instructor->lesiones = $request->lesiones;
            $instructor->descripcion = $request->descripcion;
            $instructor->video_promocional = $request->video_promocional;
            $instructor->resumen_artistico = $request->resumen_artistico;
            $instructor->video_testimonial = $request->video_testimonial;
            $instructor->boolean_promocionar = $request->boolean_promocionar;
            $instructor->boolean_disponibilidad = $request->boolean_disponibilidad;
            $instructor->boolean_administrador = $request->boolean_administrador;

            if($instructor->save()){

                if($request->imageBase64){

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

                    $nombre_img = "instructor-". $instructor->id . $extension;
                    $image = base64_decode($base64_string);

                    $img = Image::make($image)->resize(1440, 500);
                    $img->save('assets/uploads/instructor/'.$nombre_img);

                    $instructor->imagen_artistica = $nombre_img;
                    $instructor->save();

                }

                if($request->imagePerfilBase64){

                    $base64_string = substr($request->imagePerfilBase64, strpos($request->imagePerfilBase64, ",")+1);
                    $path = storage_path();
                    $split = explode( ';', $request->imagePerfilBase64 );
                    $type =  explode( '/',  $split[0]);
                    $ext = $type[1];
                    
                    if($ext == 'jpeg' || 'jpg'){
                        $extension = '.jpg';
                    }

                    if($ext == 'png'){
                        $extension = '.png';
                    }

                    $nombre_img = "instructorp-". $instructor->id . $extension;
                    $image = base64_decode($base64_string);

                    $img = Image::make($image)->resize(300, 300);
                    $img->save('assets/uploads/instructor/'.$nombre_img);

                    $instructor->imagen = $nombre_img;
                    $instructor->save();

                }

                if($correo){
                    if(!$usuario){

                        $usuario = new User;

                        $usuario->academia_id = Auth::user()->academia_id;
                        $usuario->nombre = $nombre;
                        $usuario->apellido = $apellido;
                        $usuario->telefono = $request->telefono;
                        $usuario->celular = $request->celular;
                        $usuario->sexo = $request->sexo;
                        $usuario->email = $correo;
                        $usuario->como_nos_conociste_id = 1;
                        $usuario->direccion = $direccion;
                        $usuario->password = bcrypt(str_random(8));
                        $usuario->usuario_id = $instructor->id;
                        $usuario->usuario_tipo = 3;

                        $usuario->save();
                    }

                    $usuario_tipo = new UsuarioTipo;
                    $usuario_tipo->usuario_id = $usuario->id;
                    $usuario_tipo->tipo = 3;
                    $usuario_tipo->tipo_id = $instructor->id;

                    $usuario_tipo->save();
                }

                
                if($request->imagePerfilBase64){

                    $nombre_img = "usuario-". $usuario->id . $extension;
                    $image = base64_decode($base64_string);

                    // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
                    $img = Image::make($image)->resize(300, 300);
                    $img->save('assets/uploads/usuario/'.$nombre_img);

                    $usuario->imagen = $nombre_img;
                    $usuario->save();

                }

                // $academia = Academia::find(Auth::user()->academia_id);
                // $contrasena = $usuario->password;
                // $subj = $instructor->nombre . ' , ' . $academia->nombre . ' te ha agregado a Easy Dance, por favor confirma tu correo electronico';

                // $array = [
                //    'nombre' => $request->nombre,
                //    'academia' => $academia->nombre,
                //    'usuario' => $request->correo,
                //    'contrasena' => $contrasena,
                //    'subj' => $subj
                // ];

                // Mail::send('correo.inscripcion', $array, function($msj) use ($array){
                //         $msj->subject($array['subj']);
                //         $msj->to($array['usuario']);
                //     });

                return response()->json(['mensaje' => '??Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $instructor, 200]);
                
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateID(Request $request){

        $rules = [
            'identificacion' => 'required|min:7|numeric',
        ];

        $messages = [

            'identificacion.required' => 'Ups! El identificador es requerido',
            'identificacion.min' => 'El m??nimo de numeros permitidos son 5',
            'identificacion.max' => 'El maximo de numeros permitidos son 20',
            'identificacion.numeric' => 'Ups! El identificador es inv??lido , debe contener s??lo n??meros',
            'identificacion.unique' => 'Ups! Ya este usuario ha sido registrado',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $instructor = Instructor::find($request->id);
            $instructor->identificacion = $request->identificacion;
            
            if($instructor->save()){

                $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                    ->select('users.id')
                    ->where('usuarios_tipo.tipo_id',$request->id)
                    ->where('usuarios_tipo.tipo',3)
                ->first();

                if($usuario){

                    $usuario->identificacion = $request->identificacion;  

                    if($usuario->save()){

                        $usuarios_tipo = UsuarioTipo::where('usuario_id',$usuario->id)->get();

                        foreach($usuarios_tipo as $tipo_usuario){

                            if($tipo_usuario->tipo == 2 OR $tipo_usuario->tipo == 4){

                                $usuario = Alumno::find($tipo_usuario->tipo_id);

                                if($usuario){

                                    $usuario->identificacion = $request->identificacion;

                                    $usuario->save();

                                     
                                }

                            }else if($tipo_usuario->tipo == 3){

                               $usuario = Instructor::find($tipo_usuario->tipo_id);

                                if($usuario){

                                    $usuario->identificacion = $request->identificacion;

                                    $usuario->save();

                                     
                                } 
                            }else if($tipo_usuario->tipo == 8){

                               $usuario = Staff::find($tipo_usuario->tipo_id);

                                if($usuario){

                                    $usuario->identificacion = $request->identificacion;

                                    $usuario->save();

                                     
                                } 
                            }            
                        }
                        return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                    }else{
                        return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                    }

                }else{
                    return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                }

            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateNombre(Request $request){

        $rules = [
            'nombre' => 'required|min:3|max:20|regex:/^[a-z????????????????????????????????\s]+$/i',
            'apellido' => 'required|min:3|max:20|regex:/^[a-z????????????????????????????????\s]+$/i',
        ];

        $messages = [

            'nombre.required' => 'Ups! El Nombre  es requerido ',
            'nombre.min' => 'El m??nimo de caracteres permitidos son 3',
            'nombre.max' => 'El m??ximo de caracteres permitidos son 20',
            'nombre.regex' => 'Ups! El nombre es inv??lido ,debe ingresar s??lo letras',
            'apellido.required' => 'Ups! El Apellido  es requerido ',
            'apellido.min' => 'El m??nimo de caracteres permitidos son 3',
            'apellido.max' => 'El m??ximo de caracteres permitidos son 20',
            'apellido.regex' => 'Ups! El apellido es inv??lido , debe ingresar s??lo letras',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        $instructor = Instructor::find($request->id);

        $nombre = title_case($request->nombre);
        $apellido = title_case($request->apellido);

        $instructor->nombre = $nombre;
        $instructor->apellido = $apellido;

        if($instructor->save()){

            $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->select('users.id')
                ->where('usuarios_tipo.tipo_id',$request->id)
                ->where('usuarios_tipo.tipo',3)
            ->first();

            if($usuario){

                $usuario->nombre = $nombre;
                $usuario->apellido = $apellido;

                if($usuario->save()){

                    $usuarios_tipo = UsuarioTipo::where('usuario_id',$usuario->id)->get();

                    foreach($usuarios_tipo as $tipo_usuario){

                        if($tipo_usuario->tipo == 2 OR $tipo_usuario->tipo == 4){

                            $usuario = Alumno::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->nombre = $nombre;
                                $usuario->apellido = $apellido;

                                $usuario->save();

                                 
                            }

                        }else if($tipo_usuario->tipo == 3){

                           $usuario = Instructor::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->nombre = $nombre;
                                $usuario->apellido = $apellido;

                                $usuario->save();

                                 
                            } 
                        }else if($tipo_usuario->tipo == 8){

                           $usuario = Staff::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->nombre = $nombre;
                                $usuario->apellido = $apellido;

                                $usuario->save();

                                 
                            } 
                        }            
                    }

                    return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }
             
            }else{
                return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateFecha(Request $request){

        $instructor = Instructor::find($request->id);
        
        $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->toDateString();

        $instructor->fecha_nacimiento = $fecha_nacimiento;

        if($instructor->save()){

            $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->select('users.id')
                ->where('usuarios_tipo.tipo_id',$request->id)
                ->where('usuarios_tipo.tipo',3)
            ->first();

            if($usuario){

                $usuario->fecha_nacimiento = $fecha_nacimiento;  

                if($usuario->save()){

                    $usuarios_tipo = UsuarioTipo::where('usuario_id',$usuario->id)->get();

                    foreach($usuarios_tipo as $tipo_usuario){

                        if($tipo_usuario->tipo == 2 OR $tipo_usuario->tipo == 4){

                            $usuario = Alumno::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->fecha_nacimiento = $fecha_nacimiento;

                                $usuario->save();

                                 
                            }

                        }else if($tipo_usuario->tipo == 3){

                           $usuario = Instructor::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->fecha_nacimiento = $fecha_nacimiento;

                                $usuario->save();

                                 
                            } 
                        }else if($tipo_usuario->tipo == 8){

                           $usuario = Staff::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->fecha_nacimiento = $fecha_nacimiento;

                                $usuario->save();

                                 
                            } 
                        }            
                    }
            
                    return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }
            }else{
                return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateSexo(Request $request){

        $instructor = Instructor::find($request->id);
        $instructor->sexo = $request->sexo;

        if($instructor->save()){

            $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->select('users.id')
                ->where('usuarios_tipo.tipo_id',$request->id)
                ->where('usuarios_tipo.tipo',3)
            ->first();
     
            if($usuario){

                $usuario->sexo = $request->sexo;

                if($usuario->save()){

                    $usuarios_tipo = UsuarioTipo::where('usuario_id',$usuario->id)->get();

                    foreach($usuarios_tipo as $tipo_usuario){

                        if($tipo_usuario->tipo == 2 OR $tipo_usuario->tipo == 4){

                            $usuario = Alumno::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->sexo = $request->sexo;

                                $usuario->save();

                                 
                            }

                        }else if($tipo_usuario->tipo == 3){

                           $usuario = Instructor::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->sexo = $request->sexo;

                                $usuario->save();

                                 
                            } 
                        }else if($tipo_usuario->tipo == 8){

                           $usuario = Staff::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->sexo = $request->sexo;

                                $usuario->save();

                                 
                            } 
                        }            
                    }

                    return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }
             
            }else{
                return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateCorreo(Request $request){

        $rules = [
            'correo' => 'required|email|max:255|unique:users,email',
        ];

        $messages = [
            'correo.required' => 'Ups! El correo es requerido',
            'correo.email' => 'Ups! El correo tiene una direcci??n inv??lida',
            'correo.max' => 'El m??ximo de caracteres permitidos son 255',
            'correo.unique' => 'Ups! Ya este correo ha sido registrado',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $instructor = Instructor::find($request->id);
            $correo = strtolower($request->correo);
            $instructor->correo = $correo;

            if($instructor->save()){

                $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                    ->select('users.id')
                    ->where('usuarios_tipo.tipo_id',$request->id)
                    ->where('usuarios_tipo.tipo',3)
                ->first();
         
                if($usuario){

                    $usuario->email = $correo;

                    if($usuario->save()){

                        $usuarios_tipo = UsuarioTipo::where('usuario_id',$usuario->id)->get();

                        foreach($usuarios_tipo as $tipo_usuario){

                            if($tipo_usuario->tipo == 2 OR $tipo_usuario->tipo == 4){

                                $usuario = Alumno::find($tipo_usuario->tipo_id);

                                if($usuario){

                                    $usuario->correo = $correo;

                                    $usuario->save();

                                     
                                }

                            }else if($tipo_usuario->tipo == 3){

                               $usuario = Instructor::find($tipo_usuario->tipo_id);

                                if($usuario){

                                    $usuario->correo = $correo;

                                    $usuario->save();

                                     
                                } 
                            }else if($tipo_usuario->tipo == 8){

                               $usuario = Staff::find($tipo_usuario->tipo_id);

                                if($usuario){

                                    $usuario->correo = $correo;

                                    $usuario->save();

                                     
                                } 
                            }
                        }

                        return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                    }else{
                        return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                    }
                 
                }else{
                    return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                }
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateTelefono(Request $request){

        $instructor = Instructor::find($request->id);
        $instructor->telefono = $request->telefono;
        $instructor->celular = $request->celular;

        if($instructor->save()){

            $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->select('users.id')
                ->where('usuarios_tipo.tipo_id',$request->id)
                ->where('usuarios_tipo.tipo',3)
            ->first();
         
            if($usuario){

                $usuario->telefono = $request->telefono;
                $usuario->celular = $request->celular;

                if($usuario->save()){

                    $usuarios_tipo = UsuarioTipo::where('usuario_id',$usuario->id)->get();

                    foreach($usuarios_tipo as $tipo_usuario){

                        if($tipo_usuario->tipo == 2 OR $tipo_usuario->tipo == 4){

                            $usuario = Alumno::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->telefono = $request->telefono;
                                $usuario->celular = $request->celular;

                                $usuario->save();

                                 
                            }

                        }else if($tipo_usuario->tipo == 3){

                           $usuario = Instructor::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->telefono = $request->telefono;
                                $usuario->celular = $request->celular;

                                $usuario->save();

                                 
                            } 
                        }else if($tipo_usuario->tipo == 8){

                           $usuario = Staff::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->telefono = $request->telefono;
                                $usuario->celular = $request->celular;

                                $usuario->save();

                                 
                            } 
                        }            
                    }

                    return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }
             
            }else{
                return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }
 
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }


    public function updateDireccion(Request $request){

        $instructor = Instructor::find($request->id);
        $instructor->direccion = $request->direccion;

        if($instructor->save()){

            $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->select('users.id')
                ->where('usuarios_tipo.tipo_id',$request->id)
                ->where('usuarios_tipo.tipo',3)
            ->first();
         
            if($usuario){

                $usuario->direccion = $request->direccion;

                if($usuario->save()){

                    $usuarios_tipo = UsuarioTipo::where('usuario_id',$usuario->id)->get();

                    foreach($usuarios_tipo as $tipo_usuario){

                        if($tipo_usuario->tipo == 2 OR $tipo_usuario->tipo == 4){

                            $usuario = Alumno::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->direccion = $direccion;

                                $usuario->save();

                                 
                            }

                        }else if($tipo_usuario->tipo == 3){

                           $usuario = Instructor::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->direccion = $direccion;

                                $usuario->save();

                                 
                            } 
                        }else if($tipo_usuario->tipo == 8){

                           $usuario = Staff::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->direccion = $direccion;

                                $usuario->save();

                                 
                            } 
                        }
                    } 

                    return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }
             
            }else{
                return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateDiagnostico(Request $request){

        $instructor = Instructor::find($request->id);
        $instructor->experiencia_artistica = $request->experiencia_artistica;
        $instructor->experiencia_laboral = $request->experiencia_laboral;
        $instructor->nivel = $request->nivel;
        $instructor->especialidad = $request->especialidad;
        $instructor->observacion = $request->observacion;

        if($instructor->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateFicha(Request $request){

        $instructor = Instructor::find($request->id);
        $instructor->asma = $request->asma;
        $instructor->alergia = $request->alergia;
        $instructor->convulsiones = $request->convulsiones;
        $instructor->cefalea = $request->cefalea;
        $instructor->hipertension = $request->hipertension;
        $instructor->lesiones = $request->lesiones;

        if($instructor->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEstatus(Request $request){

        $instructor = Instructor::find($request->id);
        $instructor->estatus = $request->estatus;

        if($instructor->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateRedes(Request $request){

        $instructor = Instructor::find($request->id);
        $instructor->facebook = $request->facebook;
        $instructor->twitter = $request->twitter;
        $instructor->instagram = $request->instagram;
        $instructor->pagina_web = $request->pagina_web;
        $instructor->linkedin = $request->linkedin;
        $instructor->youtube = $request->youtube;
        
        if($instructor->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateAvanzado(Request $request){

        $instructor = Instructor::find($request->id);

        $instructor->descripcion = $request->descripcion;
        $instructor->video_promocional = $request->video_promocional;
        $instructor->resumen_artistico = $request->resumen_artistico;
        $instructor->video_testimonial = $request->video_testimonial;
        $instructor->boolean_promocionar = $request->boolean_promocionar;
        $instructor->boolean_disponibilidad = $request->boolean_disponibilidad;
        $instructor->boolean_administrador = $request->boolean_administrador;

        if($request->imageBase64){

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

                $nombre_img = "instructor-". $instructor->id . $extension;
                $image = base64_decode($base64_string);

                // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
                $img = Image::make($image)->resize(1440, 500);
                $img->save('assets/uploads/instructor/'.$nombre_img);

                $instructor->imagen_artistica = $nombre_img;

        }

        if($instructor->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateImagen(Request $request)
    {
        $instructor = Instructor::find($request->id);
        
        if($request->imagePerfilBase64){
            $base64_string = substr($request->imagePerfilBase64, strpos($request->imagePerfilBase64, ",")+1);
            $path = storage_path();
            $split = explode( ';', $request->imagePerfilBase64 );
            $type =  explode( '/',  $split[0]);

            $ext = $type[1];
            
            if($ext == 'jpeg' || 'jpg'){
                $extension = '.jpg';
            }

            if($ext == 'png'){
                $extension = '.png';
            }

            $nombre_img = "instructorp-". $instructor->id . $extension;
            $image = base64_decode($base64_string);

            // \Storage::disk('taller')->put($nombre_img,  $image);
            $img = Image::make($image)->resize(300, 300);
            $img->save('assets/uploads/instructor/'.$nombre_img);

        }else{
            $nombre_img = "";
        }

        $instructor->imagen = $nombre_img;
        $instructor->save();

        $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
            ->select('users.id')
            ->where('usuarios_tipo.tipo_id',$request->id)
            ->where('usuarios_tipo.tipo',3)
        ->first();

        if($usuario){

            if($request->imagePerfilBase64){

                $nombre_img = "usuario-". $usuario->id . $extension;
                $image = base64_decode($base64_string);

                // \Storage::disk('usuario')->put($nombre_img,  $image);
                $img = Image::make($image)->resize(300, 300);
                $img->save('assets/uploads/usuario/'.$nombre_img);

            }else{
                $nombre_img = "";
            }

            $usuario->imagen = $nombre_img;
            $usuario->save();

        }

        return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
    }

    public function updatePassword(Request $request){

        $rules = [
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ];

        $messages = [

            'password.required' => 'Ups! La contrase??a es requerida',
            'password.confirmed' => 'Ups! Las contrase??as introducidas no coinciden, intenta de nuevo',
            'password.min' => 'Ups! La contrase??a debe contener un m??nimo de 6 caracteres',
            'password_confirmation.required' => 'Ups! La contrase??a es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{

            $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->select('users.id')
                ->where('usuarios_tipo.tipo_id',$request->id)
                ->where('usuarios_tipo.tipo',3)
            ->first();

            if($usuario){

                $usuario->password = bcrypt($request->password);

                if($usuario->save()){
                    return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }
            }else{
                return response()->json(['mensaje' => '??Excelente!', 'status' => 'OK', 200]);
            }
        }
    }


    public function updateCredencial(Request $request){
        $credencial = CredencialInstructor::where('instructor_id',$request->id)->first();

        if($credencial){

            $credencial->cantidad = $request->cantidad;
            $credencial->dias_vencimiento = $request->dias_vencimiento;
            $credencial->fecha_vencimiento = Carbon::now()->addDays($request->dias_vencimiento);

        }else{
            $credencial = new CredencialInstructor;

            $credencial->instructor_id = $request->id;
            $credencial->cantidad = $request->cantidad;
            $credencial->dias_vencimiento = $request->dias_vencimiento;
            $credencial->fecha_vencimiento = Carbon::now()->addDays($request->dias_vencimiento);
        }


        if($credencial->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */

    public function edit($id)
    {   
        $instructor = Instructor::find($id);
        if($instructor){

            $credencial = CredencialInstructor::where('instructor_id',$id)->first();

            if(!$credencial){
                $credencial = new CredencialInstructor;

                $credencial->instructor_id = $id;
                $credencial->cantidad = 0;
                $credencial->dias_vencimiento = 0;
                $credencial->fecha_vencimiento = Carbon::now();
                $credencial->save();
            }

            $clases_grupales = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('clases_grupales.*','config_clases_grupales.nombre')
                ->where('clases_grupales.instructor_id', $id)
                ->where('clases_grupales.fecha_final', '>=', Carbon::now()->toDateString())
                ->OrderBy('clases_grupales.hora_inicio')
            ->get();

            $array = array();

            $academia = Academia::find($id);

            foreach($clases_grupales as $clase_grupal){

                $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
                $i = $fecha->dayOfWeek;

                if($i == 1){

                  $dia = 'Lunes';

                }else if($i == 2){

                  $dia = 'Martes';

                }else if($i == 3){

                  $dia = 'Miercoles';

                }else if($i == 4){

                  $dia = 'Jueves';

                }else if($i == 5){

                  $dia = 'Viernes';

                }else if($i == 6){

                  $dia = 'Sabado';

                }else if($i == 0){

                  $dia = 'Domingo';

                }


                $collection=collect($clase_grupal);     
                $clase_grupal_array = $collection->toArray();

                $clase_grupal_array['dia']=$dia;
                $array[$clase_grupal->id] = $clase_grupal_array;
            }

            $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->where('usuarios_tipo.tipo_id',$id)
                ->where('usuarios_tipo.tipo',3)
            ->first();

            if($usuario){

              if($usuario->imagen){
                $imagen = $usuario->imagen;
              }else{
                $imagen = '';
              }

            }else{
                $imagen = '';
            }

            $pagos_instructor = ConfigPagosInstructor::join('clases_grupales', 'configuracion_pagos_instructor.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('configuracion_pagos_instructor.*', 'config_clases_grupales.nombre as nombre', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final', 'clases_grupales.fecha_inicio', 'clases_grupales.fecha_final')
                ->where('configuracion_pagos_instructor.instructor_id', $id)
            ->get();

            $pagos = array();

            foreach($pagos_instructor as $pago){

                $fecha = Carbon::createFromFormat('Y-m-d', $pago->fecha_inicio);
                $i = $fecha->dayOfWeek;

                if($i == 1){

                  $dia = 'Lunes';

                }else if($i == 2){

                  $dia = 'Martes';

                }else if($i == 3){

                  $dia = 'Miercoles';

                }else if($i == 4){

                  $dia = 'Jueves';

                }else if($i == 5){

                  $dia = 'Viernes';

                }else if($i == 6){

                  $dia = 'Sabado';

                }else if($i == 0){

                  $dia = 'Domingo';

                }

                $fecha_final = Carbon::createFromFormat('Y-m-d', $pago->fecha_final);


                if($fecha_final >= Carbon::now()){
                    $finalizo = 0;
                }else{
                    $finalizo = 1;
                }


                $collection=collect($pago);     
                $pago_array = $collection->toArray();

                $pago_array['dia']=$dia;
                $pago_array['finalizo']=$finalizo;
                $pagos[] = $pago_array;
            }

            $comisiones = ConfigComision::where('config_comisiones.usuario_id', $id)
                ->where('config_comisiones.usuario_tipo',2)
            ->get();

            $tmp = array();
            $tmp2 = array();

            $config_servicio=ConfigServicios::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

            foreach($config_servicio as $item){

                $tmp[]=array('id' => '1-'.$item['id'], 'nombre' => $item['nombre'] , 'tipo' => $item['tipo'], 'costo' => $item['costo']);
            }

            $config_producto=ConfigProductos::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

            foreach($config_producto as $item){

                $tmp[]=array('id' => '2-'.$item['id'], 'nombre' => $item['nombre'] , 'tipo' => $item['tipo'], 'costo' => $item['costo']);
               
            }

            foreach($comisiones as $pago){
               
                if($pago->servicio_producto_tipo == 1){
                    $servicio_producto = ConfigServicios::find($pago->servicio_producto_id);
                }else{
                    $servicio_producto = ConfigProductos::find($pago->servicio_producto_id);
                }

                if($servicio_producto){

                    $tmp2[]=array('id' => $pago->id, 'nombre' => $servicio_producto->nombre , 'tipo' => $pago->tipo, 'monto' => $pago->monto, 'monto_porcentaje' => $pago->monto_porcentaje, 'servicio_producto_id' => $pago->servicio_producto_id, 'servicio_producto_tipo' => $pago->servicio_producto_tipo, 'monto_minimo' => $pago->monto_minimo);
                }

            }

            $collection=collect($tmp);   
            $linea_servicio = $collection->toArray();
            $collection=collect($tmp2);   
            $comisiones = $collection->toArray();

            $cantidad_clases = ClaseGrupal::where('instructor_id',$instructor->id)->count();

            $cantidad_horarios = HorarioClaseGrupal::where('instructor_id',$instructor->id)->count();

            $cantidad_clases = $cantidad_clases + $cantidad_horarios;

            return view('participante.instructor.planilla')->with(['instructor' => $instructor, 'credencial' => $credencial, 'clases_grupales' => $array, 'pagos_instructor' => $pagos, 'imagen' => $imagen, 'comisiones' => $comisiones,  'linea_servicio' => $linea_servicio, 'id' => $id, 'cantidad_clases' => $cantidad_clases, 'usuario' => $usuario]);
        }else{
           return redirect("participante/instructor"); 
        }
    }

    public function perfil_evaluativo($id)
    {
        $perfil = PerfilInstructor::where('instructor_id', $id)->first();

        if(!$perfil){
            $perfil = new PerfilInstructor;
            $perfil->instructor_id = $id;
            $perfil->save();
        }

        return view('participante.instructor.planilla_evaluacion')->with(['id' => $id, 'perfil' => $perfil]);
    }

    public function perfil_instructor()
    {

        $usuario_id = Session::get('easydance_usuario_id');

        $instructores = Instructor::Leftjoin('perfil_instructor', 'perfil_instructor.instructor_id', '=', 'instructores.id')
            ->select('instructores.*' , 'perfil_instructor.*', 'instructores.id as id')
            ->where('instructores.id', $usuario_id)
        ->first();

        $academia = Academia::find($instructores->academia_id);

  
        return view('participante.instructor.promocionar')->with(['academia' => $academia, 'instructores_academia' => $instructores, 'id' => $usuario_id]);
    }

    public function storeExperiencia(Request $request)
    {
        
        $rules = [
            'tiempo_experiencia_instructor' => 'numeric',
            'genero_instructor' => 'numeric',
            'cantidad_horas' => 'numeric',
            'titulos_instructor' => 'numeric',
            'invitacion_evento' => 'numeric',
            'organizador' => 'numeric',
            'tiempo_experiencia_bailador' => 'numeric',
            'genero_bailador' => 'numeric',
            'participacion_coreografia' => 'numeric',
            'montajes' => 'numeric',
            'titulos_bailador' => 'numeric',
            'participacion_escenario' => 'numeric',
            
        ];

        $messages = [

            'tiempo_experiencia_instructor.numeric' => 'Ups! El campo es inv??lido , debe contener s??lo n??meros',
            'genero_instructor.numeric' => 'Ups! El campo es inv??lido , debe contener s??lo n??meros',
            'cantidad_horas.numeric' => 'Ups! El campo es inv??lido , debe contener s??lo n??meros',
            'titulos_instructor.numeric' => 'Ups! El campo es inv??lido , debe contener s??lo n??meros',
            'invitacion_evento.numeric' => 'Ups! El campo es inv??lido , debe contener s??lo n??meros',
            'organizador.numeric' => 'Ups! El campo es inv??lido , debe contener s??lo n??meros',
            'tiempo_experiencia_bailador.numeric' => 'Ups! El campo es inv??lido , debe contener s??lo n??meros',
            'genero_bailador.numeric' => 'Ups! El campo es inv??lido , debe contener s??lo n??meros',
            'participacion_coreografia.numeric' => 'Ups! El campo es inv??lido , debe contener s??lo n??meros',
            'montajes.numeric' => 'Ups! El campo es inv??lido , debe contener s??lo n??meros',
            'titulos_bailador.numeric' => 'Ups! El campo es inv??lido , debe contener s??lo n??meros',
            'participacion_escenario.numeric' => 'Ups! El campo es inv??lido , debe contener s??lo n??meros',

     
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $instructor = PerfilInstructor::where('instructor_id' , $request->id)->first();

            if(!$instructor){

                $instructor = new PerfilInstructor;
            }

            $instructor->instructor_id = $request->id;
            $instructor->tiempo_experiencia_instructor = $request->tiempo_experiencia_instructor;
            $instructor->genero_instructor = $request->genero_instructor;
            $instructor->cantidad_horas = $request->cantidad_horas;
            $instructor->titulos_instructor = $request->titulos_instructor;
            $instructor->invitacion_evento = $request->invitacion_evento;
            $instructor->organizador = $request->organizador;
            $instructor->tiempo_experiencia_bailador = $request->tiempo_experiencia_bailador;
            $instructor->genero_bailador = $request->genero_bailador;
            $instructor->participacion_coreografia = $request->participacion_coreografia;
            $instructor->montajes = $request->montajes;
            $instructor->titulos_bailador = $request->titulos_bailador;
            $instructor->participacion_escenario = $request->participacion_escenario;

            if($instructor->save()){
                return response()->json(['mensaje' => '??Excelente! El instructor se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function operar($id)
    {   
        $instructor = Instructor::find($id);
        
        return view('participante.instructor.operacion')->with(['id' => $id, 'instructor' => $instructor]);       
    }

    public function progreso($id)
    {

        $instructores = Instructor::Leftjoin('perfil_instructor', 'perfil_instructor.instructor_id', '=', 'instructores.id')
            ->select('instructores.*' , 'perfil_instructor.*', 'instructores.id as id')
            ->where('instructores.id', $id)
        ->first();

        $academia = Academia::find($instructores->academia_id);

  
        return view('participante.instructor.promocionar')->with(['academia' => $academia, 'instructores_academia' => $instructores, 'id' => $id]);
    }

    public function sesion(Request $request)
    {

        Session::put('instructor_id', $request->instructor_id);

        return response()->json(['mensaje' => '??Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {

        $instructor = Instructor::find($id);
        $delete = CredencialInstructor::where('instructor_id',$id)->delete();
        $delete = AsistenciaInstructor::where('instructor_id',$id)->delete();
        $delete = PerfilInstructor::where('instructor_id',$id)->delete();
        $delete = ConfigPagosInstructor::where('instructor_id',$id)->delete();
        
        if($instructor->forceDelete()){
            $usuario_tipo = UsuarioTipo::where('tipo',3)
                ->where('usuario_id',$id)
            ->first();

            if($usuario_tipo){
                $usuario_tipo->delete();
            }
            return response()->json(['mensaje' => '??Excelente! El instructor se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function pagos_vista_instructor()
    {

        $id = Session::get('easydance_usuario_id');
        $instructor = Instructor::find($id);

        if($instructor)
        {

            $array = array();

            $pagos_instructor = PagoInstructor::join('clases_grupales', 'pagos_instructor.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('pagos_instructor.*', 'config_clases_grupales.nombre as servicio_producto', 'instructores.nombre as nombre_instructor', 'instructores.apellido as apellido_instructor', 'config_clases_grupales.costo_mensualidad as servicio_producto_costo')
                ->where('instructores.id', $id)
                ->limit(100)
            ->get();

            $total_pagos = PagoInstructor::where('instructor_id', $id)
                ->where('boolean_pago', 0)
            ->sum('monto');

            foreach($pagos_instructor as $pago){

                $fecha = Carbon::createFromFormat('Y-m-d', $pago->fecha);
                $i = $fecha->dayOfWeek;

                if($i == 1){

                    $dia = 'Lunes';

                }else if($i == 2){

                    $dia = 'Martes';

                }else if($i == 3){

                    $dia = 'Miercoles';

                }else if($i == 4){

                    $dia = 'Jueves';

                }else if($i == 5){

                    $dia = 'Viernes';

                }else if($i == 6){

                    $dia = 'Sabado';

                }else if($i == 0){

                    $dia = 'Domingo';

                }

                $collection=collect($pago);     
                $pago_array = $collection->toArray();
                $pago_array['dia']=$dia;
                $pago_array['id']='1-'.$pago->id;
                $pago_array['cliente']='';
                $array['1-'.$pago->id] = $pago_array;
                
            }

            $comisiones = Comision::join('staff', 'comisiones.usuario_id', '=', 'staff.id')
                ->select('comisiones.*', 'comisiones.hora','staff.nombre as nombre_staff', 'staff.apellido as apellido_staff')
                ->where('comisiones.usuario_id', $id)
                ->where('comisiones.usuario_tipo',2)
                ->limit(100)
            ->get();

            foreach($comisiones as $comision){

                if($comision->servicio_producto_tipo == 1){
                    $servicio_producto = ConfigServicios::find($comision->servicio_producto_id);
                }else{
                    $servicio_producto = ConfigProductos::find($comision->servicio_producto_id);
                }

                if($servicio_producto){

                    if($comision->cliente_tipo == 1){
                        $usuario = Alumno::find($comision->cliente_id);
                    }else{
                        $usuario = Staff::find($comision->cliente_id);
                    }

                    if($usuario){
                        $cliente = $usuario->nombre . ' ' . $usuario->apellido;
                    }else{
                        $cliente = '';
                    }

                    $fecha = Carbon::createFromFormat('Y-m-d', $comision->fecha);
                    $i = $fecha->dayOfWeek;

                    if($i == 1){

                        $dia = 'Lunes';

                    }else if($i == 2){

                        $dia = 'Martes';

                    }else if($i == 3){

                        $dia = 'Miercoles';

                    }else if($i == 4){

                        $dia = 'Jueves';

                    }else if($i == 5){

                        $dia = 'Viernes';

                    }else if($i == 6){

                        $dia = 'Sabado';

                    }else if($i == 0){

                        $dia = 'Domingo';

                    }

                    $collection=collect($comision);     
                    $comision_array = $collection->toArray();
                    
                    $comision_array['servicio_producto']=$servicio_producto->nombre;
                    $comision_array['dia']=$dia;
                    $comision_array['id']='2-'.$comision->id;
                    $comision_array['cliente']=$cliente;
                    $array['2-'.$comision->id] = $comision_array;
                }
            }

            $total_comisiones = Comision::where('usuario_id', $id)
                ->where('usuario_tipo',2)
                ->where('boolean_pago', 0)
            ->sum('monto');

            $total = $total_pagos + $total_comisiones;

            return view('participante.instructor.pagos')->with(['pagos_comisiones'=> $array, 'total' => $total, 'instructor' => $instructor, 'id' => $id ]);
        }else{ 

            return redirect("participante/instructor"); 
        }
    }

    public function principalpagos($id)
    {

        $instructor = Instructor::find($id);

        if($instructor)
        {

            $array = array();

            $pagos_instructor = PagoInstructor::join('clases_grupales', 'pagos_instructor.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->leftJoin('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('pagos_instructor.*', 'config_clases_grupales.nombre as servicio_producto', 'instructores.nombre as nombre_instructor', 'instructores.apellido as apellido_instructor', 'config_clases_grupales.costo_mensualidad as servicio_producto_costo')
                ->where('instructores.id', $id)
                ->limit(100)
            ->get();

            $total_pagos = PagoInstructor::where('instructor_id', $id)
                ->where('boolean_pago', 0)
            ->sum('monto');

            foreach($pagos_instructor as $pago){

                $fecha = Carbon::createFromFormat('Y-m-d', $pago->fecha);
                $i = $fecha->dayOfWeek;

                if($i == 1){

                    $dia = 'Lunes';

                }else if($i == 2){

                    $dia = 'Martes';

                }else if($i == 3){

                    $dia = 'Miercoles';

                }else if($i == 4){

                    $dia = 'Jueves';

                }else if($i == 5){

                    $dia = 'Viernes';

                }else if($i == 6){

                    $dia = 'Sabado';

                }else if($i == 0){

                    $dia = 'Domingo';

                }

                $collection=collect($pago);     
                $pago_array = $collection->toArray();
                $pago_array['dia']=$dia;
                $pago_array['id']='1-'.$pago->id;
                $pago_array['cliente']='';
                $array['1-'.$pago->id] = $pago_array;
                
            }

            $comisiones = Comision::join('staff', 'comisiones.usuario_id', '=', 'staff.id')
                ->select('comisiones.*', 'comisiones.hora','staff.nombre as nombre_staff', 'staff.apellido as apellido_staff')
                ->where('comisiones.usuario_id', $id)
                ->where('comisiones.usuario_tipo',2)
                ->limit(100)
            ->get();

            foreach($comisiones as $comision){

                if($comision->servicio_producto_tipo == 1){
                    $servicio_producto = ConfigServicios::withTrashed()->find($comision->servicio_producto_id);
                }else{
                    $servicio_producto = ConfigProductos::withTrashed()->find($comision->servicio_producto_id);
                }

                if($servicio_producto){

                    if($comision->cliente_tipo == 1){
                        $usuario = Alumno::find($comision->cliente_id);
                    }else{
                        $usuario = Staff::find($comision->cliente_id);
                    }

                    if($usuario){
                        $cliente = $usuario->nombre . ' ' . $usuario->apellido;
                    }else{
                        $cliente = '';
                    }

                    $fecha = Carbon::createFromFormat('Y-m-d', $comision->fecha);
                    $i = $fecha->dayOfWeek;

                    if($i == 1){

                        $dia = 'Lunes';

                    }else if($i == 2){

                        $dia = 'Martes';

                    }else if($i == 3){

                        $dia = 'Miercoles';

                    }else if($i == 4){

                        $dia = 'Jueves';

                    }else if($i == 5){

                        $dia = 'Viernes';

                    }else if($i == 6){

                        $dia = 'Sabado';

                    }else if($i == 0){

                        $dia = 'Domingo';

                    }

                    $collection=collect($comision);     
                    $comision_array = $collection->toArray();
                    
                    $comision_array['servicio_producto']=$servicio_producto->nombre;
                    $comision_array['dia']=$dia;
                    $comision_array['id']='2-'.$comision->id;
                    $comision_array['cliente']=$cliente;
                    $array['2-'.$comision->id] = $comision_array;
                }
            }

            $total_comisiones = Comision::where('usuario_id', $id)
                ->where('usuario_tipo',2)
                ->where('boolean_pago', 0)
            ->sum('monto');

            $total = $total_pagos + $total_comisiones;

            return view('participante.instructor.pagos')->with(['pagos_comisiones'=> $array, 'total' => $total, 'instructor' => $instructor, 'id' => $id ]);
        }else{ 

            return redirect("participante/instructor"); 
        }
    }


    public function agregarpagofijo(Request $request)
    {
        
        $rules = [
            'cantidad' => 'required|numeric',
            'tipo_pago' => 'required'
        ];

        $messages = [

            'cantidad.required' => 'Ups! El Monto es requerido',
            'cantidad.numeric' => 'Ups! El Monto es invalido, solo se aceptan numeros',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $array = array();

            if($request->clase_grupal_id != 'null'){

                $clases_grupales = explode(",", $request->clase_grupal_id);

                foreach($clases_grupales as $clase_grupal){

                    $posee_pago = ConfigPagosInstructor::where('instructor_id', $request->id)
                        ->where('clase_grupal_id', $clase_grupal)
                    ->first();

                    if(!$posee_pago){

                        $config_pagos = new ConfigPagosInstructor;

                        $config_pagos->clase_grupal_id = $clase_grupal;
                        $config_pagos->instructor_id = $request->id;
                        $config_pagos->tipo = $request->tipo_pago;
                        $config_pagos->monto = $request->cantidad;

                        $config_pagos->save();

                        $clase_grupal_join = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                            ->select('config_clases_grupales.nombre', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final', 'clases_grupales.fecha_inicio')
                            ->where('clases_grupales.id', $clase_grupal)
                        ->first();

                        $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal_join->fecha_inicio);
                        $i = $fecha->dayOfWeek;

                        if($i == 1){

                          $dia = 'Lunes';

                        }else if($i == 2){

                          $dia = 'Martes';

                        }else if($i == 3){

                          $dia = 'Miercoles';

                        }else if($i == 4){

                          $dia = 'Jueves';

                        }else if($i == 5){

                          $dia = 'Viernes';

                        }else if($i == 6){

                          $dia = 'Sabado';

                        }else if($i == 0){

                          $dia = 'Domingo';

                        }

                        $config_pagos['nombre'] = $clase_grupal_join->nombre;
                        $config_pagos['dia'] = $dia;
                        $config_pagos['hora'] = $clase_grupal_join->hora_inicio . ' / ' . $clase_grupal_join->hora_final;

                        array_push($array, $config_pagos);


                    }

                }


            }else{

                $clases_grupales = ClaseGrupal::where('instructor_id', $request->id)->get();

                foreach($clases_grupales as $clase_grupal){

                    $posee_pago = ConfigPagosInstructor::where('instructor_id', $request->id)
                        ->where('clase_grupal_id', $clase_grupal->id)
                    ->first();


                    if(!$posee_pago){

                        $config_pagos = new ConfigPagosInstructor;

                        $config_pagos->clase_grupal_id = $clase_grupal->id;
                        $config_pagos->instructor_id = $request->id;
                        $config_pagos->tipo = $request->tipo_pago;
                        $config_pagos->monto = $request->cantidad;

                        $config_pagos->save();

                        $clase_grupal_join = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                            ->select('config_clases_grupales.nombre', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final', 'clases_grupales.fecha_inicio')
                            ->where('clases_grupales.id', $clase_grupal->id)
                        ->first();

                        $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal_join->fecha_inicio);
                        $i = $fecha->dayOfWeek;

                        if($i == 1){

                          $dia = 'Lunes';

                        }else if($i == 2){

                          $dia = 'Martes';

                        }else if($i == 3){

                          $dia = 'Miercoles';

                        }else if($i == 4){

                          $dia = 'Jueves';

                        }else if($i == 5){

                          $dia = 'Viernes';

                        }else if($i == 6){

                          $dia = 'Sabado';

                        }else if($i == 0){

                          $dia = 'Domingo';

                        }

                        $config_pagos['nombre'] = $clase_grupal_join->nombre;
                        $config_pagos['dia'] = $dia;
                        $config_pagos['hora'] = $clase_grupal_join->hora_inicio . ' / ' . $clase_grupal_join->hora_final;

                        array_push($array, $config_pagos);


                    }

                }

            }

            return response()->json(['mensaje' => '??Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 200]);   
        }
    }

    public function eliminarpagofijo($id)
    {

        $pago = ConfigPagosInstructor::find($id);
        
        if($pago->delete()){
            return response()->json(['mensaje' => '??Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 'id' => $pago->clase_grupal_id, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function pagar(Request $request){

        $rules = [
            'pendientes' => 'required',
        ];

        $messages = [

            'pendientes.required' => 'Ups! Debe seleccionar un pago',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{
        
            $pendientes = explode(",", $request->pendientes);
            $array = array();

            foreach($pendientes as $pendiente)
            {   
                if($pendiente != ''){

                    $explode = explode('-',$pendiente);
                    $tipo = $explode[0];
                    $id = $explode[1];

                    if($tipo == 1){
                        $pago = PagoInstructor::find($id);
                    }else{
                        $pago = Comision::find($id);
                    }

                    $pago->boolean_pago = 1;
                    $pago->save();

                    array_push($array,$pendiente);

                }
            }

            return response()->json(['mensaje' => '??Excelente! El pago ha sido realizado satisfactoriamente', 'status' => 'OK', 'array' => $array, 200]);

        }
    }

    public function devolver(Request $request){

        $rules = [
            'pendientes' => 'required',
        ];

        $messages = [

            'pendientes.required' => 'Ups! Debe seleccionar un pago',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{
        
            $pendientes = explode(",", $request->pendientes);
            $array = array();

            foreach($pendientes as $pendiente)
            {   
                if($pendiente != ''){

                    $explode = explode('-',$pendiente);
                    $tipo = $explode[0];
                    $id = $explode[1];

                    if($tipo == 1){
                        $pago = PagoInstructor::find($id);
                    }else{
                        $pago = Comision::find($id);
                    }

                    $pago->boolean_pago = 0;
                    $pago->save();

                    array_push($array,$pendiente);

                }
            }

            return response()->json(['mensaje' => '??Excelente! El pago ha sido realizado satisfactoriamente', 'status' => 'OK', 'array' => $array, 200]);

        }
    }

    public function agregarcomisionfija(Request $request)
    {
        
        $rules = [
            'cantidad' => 'required|min:1',
            'tipo_pago' => 'required',
            'servicio_producto_id' => 'required',
        ];

        $messages = [

            'cantidad.required' => 'Ups! El Monto es requerido',
            'cantidad.numeric' => 'Ups! El Monto es invalido, solo se aceptan numeros',
            'servicio_producto_id.required' => 'Ups! El Servicio es requerido',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $monto = floatval(str_replace(',', '', $request->cantidad));

            if($request->tipo_pago == 1){
                if($monto > 100){
                    return response()->json(['errores' => ['cantidad' => [0, 'Ups! El porcentaje no puede ser mayor a 100']], 'status' => 'ERROR'],422);
                }
            }

            $array = array();

            if($request->servicio_producto_id == '0-0' || !$request->servicio_producto_id){
                return response()->json(['errores' => ['servicio_producto_id' => [0, 'Ups! Debe seleccionar un servicio']], 'status' => 'ERROR'],422);
            }

            $explode = explode('-',$request->servicio_producto_id);

            $servicio_producto_tipo = $explode[0];
            $servicio_producto_id = $explode[1];

            if($servicio_producto_tipo == 1){
                $servicio_producto = ConfigServicios::withTrashed()->find($servicio_producto_id);
            }else{
                $servicio_producto = ConfigProductos::withTrashed()->find($servicio_producto_id);
            }
            
            if($monto  > $servicio_producto->costo){
                return response()->json(['errores' => ['cantidad' => [0, 'Ups! La comisi??n no puede ser mayor al costo']], 'status' => 'ERROR'],422);
            }


            if($request->monto_minimo){

                $monto_minimo = floatval(str_replace(',', '', $request->monto_minimo));

                if($monto_minimo  > $servicio_producto->costo){
                    return response()->json(['errores' => ['monto_minimo' => [0, 'Ups! El monto m??nimo no puede ser mayor al costo']], 'status' => 'ERROR'],422);
                }
            }else{
                $monto_minimo = '';
            }

            $config_pagos = ConfigComision::where('usuario_id', $request->id)
                ->where('usuario_tipo',2)
                ->where('servicio_producto_id', $servicio_producto_id)
                ->where('servicio_producto_tipo', $servicio_producto_tipo)
            ->first();

            if(!$config_pagos){
                $config_pagos = new ConfigComision;
            }

            if($request->tipo == 1){
                $porcentaje = $monto / 100;
                $monto_porcentaje = $servicio_producto->costo * $porcentaje;
            }else{
                $monto_porcentaje = '';
            }

            $config_pagos->servicio_producto_id = $servicio_producto_id;
            $config_pagos->servicio_producto_tipo = $servicio_producto_tipo;
            $config_pagos->usuario_id = $request->id;
            $config_pagos->usuario_tipo = 2;
            $config_pagos->tipo = $request->tipo_pago;
            $config_pagos->monto = $monto;
            $config_pagos->monto_porcentaje = $monto_porcentaje;
            $config_pagos->monto_minimo = $monto_minimo;

            $config_pagos->save();
            
            $config_pagos['nombre'] = $servicio_producto->nombre;

            array_push($array, $config_pagos);

            return response()->json(['mensaje' => '??Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 200]);   
        }
    }

    public function eliminarcomisionfija($id)
    {

        $comision_explode = explode('-',$id);
        $comision_id = $comision_explode[0];

        $comision = ConfigComision::find($comision_id);
        
        if($comision->delete()){

            return response()->json(['mensaje' => '??Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function agregarpago(Request $request){
        
        $rules = [
            'cantidad' => 'required|numeric',
            'tipo_pago' => 'required'
        ];

        $messages = [

            'cantidad.required' => 'Ups! El Monto es requerido',
            'cantidad.numeric' => 'Ups! El Monto es invalido, solo se aceptan numeros',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{

            $array = array('tipo' => $request->tipo_pago , 'monto' => $request->cantidad);
            Session::push('pagos_instructor', $array);

            $items = Session::get('pagos_instructor');
            end( $items );
            $contador = key( $items );

            return response()->json(['mensaje' => '??Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'id' => $contador, 200]);

        }
    }

    public function eliminarpago($id){

        $arreglo = Session::get('pagos_instructor');
        unset($arreglo[$id]);
        Session::forget('pagos_instructor');
        Session::push('pagos_instructor', $arreglo);

        return response()->json(['mensaje' => '??Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function agregarcomision(Request $request){

        $rules = [
            'cantidad' => 'required|min:1',
            'tipo_pago' => 'required',
            'servicio_producto_id' => 'required',
        ];

        $messages = [

            'cantidad.required' => 'Ups! El Monto es requerido',
            'cantidad.numeric' => 'Ups! El Monto es invalido, solo se aceptan numeros',
            'servicio_producto_id.required' => 'Ups! El Servicio es requerido',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{

            $monto = floatval(str_replace(',', '', $request->cantidad));

            if($request->tipo_pago == 1){
                if($monto > 100){
                    return response()->json(['errores' => ['cantidad' => [0, 'Ups! El porcentaje no puede ser mayor a 100']], 'status' => 'ERROR'],422);
                }
            }

            if($request->servicio_producto_id == '0-0' || !$request->servicio_producto_id){
                return response()->json(['errores' => ['servicio_producto_id' => [0, 'Ups! Debe seleccionar un servicio']], 'status' => 'ERROR'],422);
            }

            $explode = explode('-',$request->servicio_producto_id);

            $servicio_producto_tipo = $explode[0];
            $servicio_producto_id = $explode[1];

            if($servicio_producto_tipo == 1){
                $servicio_producto = ConfigServicios::withTrashed()->find($servicio_producto_id);
            }else{
                $servicio_producto = ConfigProductos::withTrashed()->find($servicio_producto_id);
            }
            
            if($monto  > $servicio_producto->costo){
                return response()->json(['errores' => ['cantidad' => [0, 'Ups! La comisi??n no puede ser mayor al costo']], 'status' => 'ERROR'],422);
            }

            if($request->monto_minimo){

                $monto_minimo = floatval(str_replace(',', '', $request->monto_minimo));

                if($monto_minimo  > $servicio_producto->costo){
                    return response()->json(['errores' => ['monto_minimo' => [0, 'Ups! El monto m??nimo no puede ser mayor al costo']], 'status' => 'ERROR'],422);
                }
            }else{
                $monto_minimo = '';
            }

            if($request->tipo == 1){
                $porcentaje = $monto / 100;
                $monto_porcentaje = $servicio_producto->costo * $porcentaje;
            }else{
                $monto_porcentaje = '';
            }

            $array = array('servicio_producto_id' => $servicio_producto_id, 'servicio_producto_tipo' => $servicio_producto_tipo, 'tipo' => $request->tipo_pago, 'monto' => $monto, 'monto_porcentaje' => $monto_porcentaje, 'monto_minimo' => $monto_minimo, 'nombre' => $servicio_producto->nombre);
            Session::push('comisiones', $array);

            $items = Session::get('comisiones');
            end( $items );
            $contador = key( $items );

            return response()->json(['mensaje' => '??Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'id' => $contador, 200]);

        }
    }

    public function eliminarcomision($id){

        $arreglo = Session::get('comisiones');
        unset($arreglo[$id]);
        Session::forget('comisiones');
        Session::push('comisiones', $arreglo);

        return response()->json(['mensaje' => '??Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function crearCuenta($id){

        $instructor = Instructor::find($id);

        if($instructor){

            if($instructor->correo){

                $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                    ->where('usuarios_tipo.tipo_id',$instructor->id)
                    ->where('usuarios_tipo.tipo',3)
                ->first();

                if(!$usuario){

                    $password = str_random(8);
                                
                    $usuario = new User;

                    $usuario->academia_id = Auth::user()->academia_id;
                    $usuario->nombre = $instructor->nombre;
                    $usuario->apellido = $instructor->apellido;
                    $usuario->telefono = $instructor->telefono;
                    $usuario->celular = $instructor->celular;
                    $usuario->sexo = $instructor->sexo;
                    $usuario->email = $instructor->correo;
                    $usuario->como_nos_conociste_id = 1;
                    $usuario->direccion = $instructor->direccion;
                    // $usuario->confirmation_token = str_random(40);
                    $usuario->password = bcrypt($password);
                    $usuario->usuario_id = $instructor->id;
                    $usuario->usuario_tipo = 3; 

                    $usuario->save();

                    $usuario_tipo = new UsuarioTipo;
                    $usuario_tipo->usuario_id = $usuario->id;
                    $usuario_tipo->tipo = 3;
                    $usuario_tipo->tipo_id = $instructor->id;
                    $usuario_tipo->save();
                  
                    return response()->json(['mensaje' => '??Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

                }else{
                    return response()->json(['error_mensaje' => 'Ups! El instructor ya posee una cuenta'], 422);
                }

            }else{
                return response()->json(['error_mensaje' => 'Ups! El instructor no posee correo electronico para crear su cuenta'], 422);
            }

        }else{
            return response()->json(['error_mensaje' => 'Ups! No Hemos encontrado la siguiente informaci??n del identificador asociada a tu cuenta', 'status' => 'ERROR'],422);
        }
    }
}