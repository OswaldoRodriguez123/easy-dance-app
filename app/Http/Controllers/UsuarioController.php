<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\ConfigEspecialidades;
use App\Paises;
use App\Alumno;
use App\AlumnoRemuneracion;
use App\Instructor;
use App\ComoNosConociste;
use App\Academia;
use App\PerfilEvaluativo;
use App\ConfigClasesPersonalizadas;
use App\UsuarioTipo;
use App\CredencialAlumno;
use App\ClaseGrupal;
use App\ConfigClasesGrupales;
use App\VencimientoClaseGrupal;
use App\Reservacion;
use App\ConfigPagosInstructor;
use App\InscripcionClaseGrupal;
use App\HorarioClaseGrupal;
use App\HorarioBloqueado;
use App\Asistencia;
use App\Evaluacion;
use App\Taller;
use App\HorarioTaller;
use App\Fiesta;
use App\Campana;
use App\ClasePersonalizada;
use App\InscripcionClasePersonalizada;
use App\Regalo;
use App\ItemsFacturaProforma;
use App\Acuerdo;
use App\Staff;
use App\Cita;
use App\Transmision;
use App\Visitante;
use App\Egreso;
use App\Factura;
use App\ItemsFactura;
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
        $datos = $this->getDatosUsuario();

        $usuario_id = $datos[0]['usuario_id'];
        $usuario_tipo = $datos[0]['usuario_tipo'];

        if($usuario_tipo == 2 OR $usuario_tipo == 4){
            $alumno = Alumno::find($usuario_id);
            return view('usuario.planilla')->with('alumno',$alumno);
        }else{
            return view('usuario.planilla');
        }
    }

    public function perfil_evaluativo()
    {   
        $datos = $this->getDatosUsuario();

        $usuario_id = $datos[0]['usuario_id'];

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

    public function updateID(Request $request){
        $rules = [
            'identificacion' => 'required|min:7|numeric',
        ];

        $messages = [
            'identificacion.required' => 'Ups! El identificador es requerido',
            'identificacion.min' => 'El mínimo de numeros permitidos son 5',
            'identificacion.max' => 'El maximo de numeros permitidos son 20',
            'identificacion.numeric' => 'Ups! El identificador es inválido , debe contener sólo números',
            'identificacion.unique' => 'Ups! Ya este usuario ha sido registrado',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
        }else{


            $usuario = User::find(Auth::user()->id);

            $usuario->identificacion = $request->identificacion;

            if($usuario->save()){

                $usuarios_tipo = UsuarioTipo::where('usuario_id',Auth::user()->id)->get();

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
                
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }
        }
    }

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

            $usuarios_tipo = UsuarioTipo::where('usuario_id',Auth::user()->id)->get();

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
            
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateFecha(Request $request){


        $usuario = User::find(Auth::user()->id);
        $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->toDateString();
        $usuario->fecha_nacimiento = $fecha_nacimiento;

        if($usuario->save()){

            $usuarios_tipo = UsuarioTipo::where('usuario_id',Auth::user()->id)->get();

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
            
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateSexo(Request $request){
        $usuario = User::find(Auth::user()->id);
        $usuario->sexo = $request->sexo;

        if($usuario->save()){

            $usuarios_tipo = UsuarioTipo::where('usuario_id',Auth::user()->id)->get();

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

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $usuario = User::find(Auth::user()->id);
            $email = strtolower($request->email);
            $usuario->email = $email;

            if($usuario->save()){

                $usuarios_tipo = UsuarioTipo::where('usuario_id',Auth::user()->id)->get();

                foreach($usuarios_tipo as $tipo_usuario){

                    if($tipo_usuario->tipo == 2 OR $tipo_usuario->tipo == 4){

                        $usuario = Alumno::find($tipo_usuario->tipo_id);

                        if($usuario){

                            $usuario->correo = $email;

                            $usuario->save();

                             
                        }

                    }else if($tipo_usuario->tipo == 3){

                       $usuario = Instructor::find($tipo_usuario->tipo_id);

                        if($usuario){

                            $usuario->correo = $email;

                            $usuario->save();

                             
                        } 
                    }else if($tipo_usuario->tipo == 8){

                       $usuario = Staff::find($tipo_usuario->tipo_id);

                        if($usuario){

                            $usuario->correo = $email;

                            $usuario->save();

                             
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

            $usuarios_tipo = UsuarioTipo::where('usuario_id',Auth::user()->id)->get();

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

            $usuarios_tipo = UsuarioTipo::where('usuario_id',Auth::user()->id)->get();

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

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

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

        $datos = $this->getDatosUsuario();

        $usuario_tipo = $datos[0]['usuario_tipo'];

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

    public function seleccionar_tipo()
    {
        $usuario_tipo = Session::get('easydance_usuario_tipo');
        
        if(!$usuario_tipo){

            $tipos = UsuarioTipo::where('usuario_id',Auth::user()->id)->get();
            
            foreach($tipos as $tipo){
                $usuario_tipo = $tipo->tipo;
                $usuario_id = $tipo->tipo_id;
            }

            if(count($tipos) > 1){
                return view('login.seleccionar-tipo')->with('tipos',$tipos);
            }else{
                Session::put('easydance_usuario_tipo',$usuario_tipo);
                Session::put('easydance_usuario_id',$usuario_id);
                return redirect('/inicio');
            }
        }else{
            return redirect('/inicio');
        }
    }

    public function PostSeleccionar($id)
    {
        $tipos = UsuarioTipo::where('usuario_id',Auth::user()->id)->get();
        $i = 0;
        foreach($tipos as $tipo){
            if($tipo->tipo == $id){
                Session::put('easydance_usuario_id',$tipo->tipo_id);
                break;
            }
        }
        Session::put('easydance_usuario_tipo',$id);
        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
    }

    public function index_con_reportes()
    {

        return view('inicio.index-con-reportes')->with(['talleres' => $arrayTalleres, 'clases_grupales' => $arrayClases, 'clases_personalizadas' => $arrayClasespersonalizadas, 'fiestas' => $arrayFiestas, 'citas' => $arrayCitas, 'transmisiones' => $arrayTransmisiones, 'mujeres' => $mujeres, 'hombres' => $hombres, 'egresos_generales' => $egresos_generales, 'egresos_eventos' => $egresos_eventos, 'egresos_talleres' => $egresos_talleres, 'egresos_campanas' => $egresos_campanas, 'porcentaje_general' => $porcentaje_general, 'porcentaje_evento' => $porcentaje_evento, 'porcentaje_taller' => $porcentaje_taller, 'porcentaje_campana' => $porcentaje_campana, 'ingresos_generales' => $ingresos_generales, 'ingresos_eventos' => $ingresos_eventos, 'ingresos_talleres' => $ingresos_talleres, 'ingresos_campanas' => $ingresos_campanas, 'porcentaje_ingreso_general' => $porcentaje_ingreso_general, 'porcentaje_ingreso_evento' => $porcentaje_ingreso_evento, 'porcentaje_ingreso_taller' => $porcentaje_ingreso_taller, 'porcentaje_ingreso_campana' => $porcentaje_ingreso_campana]);
    }

    public function index()
    {

        $academia = Academia::find(Auth::user()->academia_id);

        $datos = $this->getDatosUsuario();

        $usuario_id = $datos[0]['usuario_id'];
        $usuario_tipo = $datos[0]['usuario_tipo'];

        if($usuario_tipo){

            //ADMINISTRADOR
            if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){

                $fecha_comprobacion = Carbon::createFromFormat('Y-m-d', $academia->fecha_comprobacion);
                $hoy = Carbon::now();

                if($fecha_comprobacion < $hoy){

                    $congelados = InscripcionClaseGrupal::join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
                        ->where('inscripcion_clase_grupal.fecha_final','<',Carbon::now()->toDateString())
                        ->where('inscripcion_clase_grupal.boolean_congelacion',1)
                        ->where('clases_grupales.academia_id',Auth::user()->academia_id)
                    ->get();

                    foreach($congelados as $congelado){
                        $congelado->fecha_inicio = '0000-00-00';
                        $congelado->fecha_final = '0000-00-00';
                        $congelado->boolean_congelacion = 0;

                        $congelado->save();
                    }

                    $evaluaciones_vencidas = Evaluacion::where('fecha_vencimiento','<',Carbon::now()->toDateString())
                        ->where('estatus',0)
                        ->where('academia_id',Auth::user()->academia_id)
                    ->get();

                    foreach($evaluaciones_vencidas as $evaluacion){
                        $evaluacion->estatus = 1;
                        $evaluacion->save();
                    }

                    $credenciales_vencidas = CredencialAlumno::where('cantidad', '<=', 0)->delete();

                    $clases_grupales = ClaseGrupal::where('boolean_vencimiento',0)
                        ->where('academia_id',Auth::user()->academia_id)
                    ->get();

                    foreach($clases_grupales as $clase_grupal){

                        $fecha_final = Carbon::createFromFormat('Y-m-d',$clase_grupal->fecha_final);

                        if(Carbon::now()->addMonth() > $fecha_final && $fecha_final > Carbon::now()){

                            $usuarios = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                                ->select('users.id','usuarios_tipo.tipo')
                                ->where('academia_id',Auth::user()->academia_id)
                            ->get();

                            foreach($usuarios as $usuario){

                                if($usuario->tipo == 1 OR $usuario->tipo == 3 OR $usuario->tipo == 5 OR $usuario->tipo == 6){
                                    $vencimiento = new VencimientoClaseGrupal;

                                    $vencimiento->clase_grupal_id = $clase_grupal->id;
                                    $vencimiento->usuario_id = $usuario->id;
                                    $vencimiento->save();

                                    break;
                                }
                                
                            }
                        }

                        $clase_grupal->boolean_vencimiento = 1;
                        $clase_grupal->save();
                    }

                    $reservaciones = Reservacion::all();

                    foreach($reservaciones as $reservacion){

                        $fecha_vencimiento = Carbon::parse($reservacion->fecha_vencimiento);

                        if(Carbon::now() > $fecha_vencimiento){
                            $reservacion->delete();
                        }

                    }

                    if($hoy == $hoy->lastOfMonth()){

                        $config_pagos = ConfigPagosInstructor::where('tipo', 2)->get();

                        foreach($config_pagos as $config_pago){
                            
                            $pago = new PagoInstructor;

                            $pago->instructor_id=$config_pago->instructor_id;
                            $pago->tipo=$config_pago->tipo;
                            $pago->monto=$config_pago->monto;
                            $pago->clase_grupal_id=$config_pago->clase_grupal_id;
                            $pago->fecha = Carbon::now()->toDateString();
                            $pago->hora = Carbon::now()->toTimeString();

                            $pago->save();
                        }

                    }

                    return $this->pagorecurrente();
                }

                $vencimiento = VencimientoClaseGrupal::join('clases_grupales', 'vencimiento_clases_grupales.clase_grupal_id', '=', 'clases_grupales.id')
                    ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                    ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
                    ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                    ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_grupales.hora_inicio','clases_grupales.hora_final','clases_grupales.fecha_inicio', 'clases_grupales.fecha_final','vencimiento_clases_grupales.id')
                    ->where('vencimiento_clases_grupales.usuario_id','=', Auth::user()->id)
                ->first();

                $arrayTalleres=array();
                $arrayClases=array();
                $arrayClasespersonalizadas=array();
                $arrayFiestas=array();
                $arrayCitas=array();
                $arrayTransmisiones=array();

                $usuario_tipo = Session::get('easydance_usuario_tipo');
                $usuario_id = Session::get('easydance_usuario_id');

                $talleres = Taller::join('instructores', 'talleres.instructor_id', '=', 'instructores.id')
                    ->join('config_especialidades', 'config_especialidades.id', '=', 'talleres.especialidad_id')
                    ->select('talleres.*', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id', 'instructores.sexo', 'config_especialidades.nombre as especialidad')
                    ->where('talleres.academia_id', '=' ,  Auth::user()->academia_id)
                    ->where('talleres.fecha_inicio', '>=', Carbon::now()->toDateString())
                ->get();

                $horarios_talleres = Taller::join('horarios_talleres', 'talleres.id', '=', 'horarios_talleres.taller_id')
                    ->join('instructores', 'horarios_talleres.instructor_id', '=', 'instructores.id')
                    ->join('config_especialidades', 'config_especialidades.id', '=', 'horarios_talleres.especialidad_id')
                    ->select('talleres.id','horarios_talleres.fecha as fecha_inicio', 'horarios_talleres.hora_inicio', 'horarios_talleres.hora_final', 'talleres.color_etiqueta as taller_etiqueta', 'horarios_talleres.color_etiqueta', 'talleres.nombre', 'talleres.descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id', 'instructores.sexo', 'config_especialidades.nombre as especialidad')
                    ->where('talleres.academia_id', '=' ,  Auth::user()->academia_id)
                    ->where('talleres.fecha_inicio', '>=', Carbon::now()->toDateString())
                ->get();

                foreach ($talleres as $taller) {

                    $fecha_start=explode('-',$taller->fecha_inicio);
                    $fecha_end=explode('-',$taller->fecha_final);

                    $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
                    $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

                    $nombre = $taller->nombre;
                    $descripcion=$taller->descripcion;
                    $hora_inicio=$taller->hora_inicio;
                    $hora_final=$taller->hora_final;
                    $fecha_inicio = $dt->toDateString();
                    $fecha_final = $df->toDateString();
                    $etiqueta=$taller->color_etiqueta;
                    $instructor = $taller->instructor_nombre . ' ' .$taller->instructor_apellido;
                    $sexo = $taller->sexo;
                    $especialidad = $taller->especialidad;
                    $instructor_imagen = Instructor::find($taller->instructor_id);               
                    
                    if($instructor_imagen){
                        if($instructor_imagen->imagen){
                            $imagen = $instructor_imagen->imagen;
                        }else{
                            $imagen = '';
                        }
                    }else{
                        $imagen = '';
                    }
                    

                    $id=$instructor."!".$especialidad."!".$imagen."!".$sexo."!".$hora_inicio. ' - ' .$hora_final;

                    $fecha_inicio = $dt->toDateString();
                    $fecha_final = $df->toDateString();

                    if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){
                        $url = "/agendar/talleres/detalle/".$taller->id;
                    }else{
                        $url = "/agendar/talleres/progreso/".$taller->id;
                    }

                    $arrayTalleres[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url);

                    while($dt->timestamp<$df->timestamp){
                        $fecha="";
                        $fecha=$dt->addWeek()->toDateString();
                        $arrayTalleres[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url);
                    }
                }

                foreach ($horarios_talleres as $taller) {

                    $fecha_start=explode('-',$taller->fecha_inicio);
                    $fecha_end=explode('-',$taller->fecha_final);

                    $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);

                    $nombre = $taller->nombre;
                    $descripcion=$taller->descripcion;
                    $hora_inicio=$taller->hora_inicio;
                    $hora_final=$taller->hora_final;
                    $fecha_inicio = $dt->toDateString();
                    $fecha_final = $dt->toDateString();
                    $etiqueta=$taller->color_etiqueta;
                    $instructor = $taller->instructor_nombre . ' ' .$taller->instructor_apellido;
                    $sexo = $taller->sexo;
                    $especialidad = $taller->especialidad;
                    $instructor_imagen = Instructor::find($taller->instructor_id);               
                    
                    if($instructor_imagen){
                        if($instructor_imagen->imagen){
                            $imagen = $instructor_imagen->imagen;
                        }else{
                            $imagen = '';
                        }
                    }else{
                        $imagen = '';
                    }

                    $id=$instructor."!".$especialidad."!".$imagen."!".$sexo."!".$hora_inicio. ' - ' .$hora_final;

                    $fecha_inicio = $dt->toDateString();
                    $fecha_final = $df->toDateString();

                    if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){
                        $url = "/agendar/talleres/detalle/".$taller->id;
                    }else{
                        $url = "/agendar/talleres/progreso/".$taller->id;
                    }

                    $arrayTalleres[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url);

                    
                }

                $clasegrupal = ClaseGrupal::join('config_clases_grupales', 'config_clases_grupales.id', '=', 'clases_grupales.clase_grupal_id')
                    ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                    ->join('config_especialidades', 'config_especialidades.id', '=', 'clases_grupales.especialidad_id')
                    ->join('config_niveles_baile', 'config_niveles_baile.id', '=', 'clases_grupales.nivel_baile_id')
                    ->select('clases_grupales.*', 'config_clases_grupales.nombre', 'config_clases_grupales.descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id', 'instructores.sexo', 'config_especialidades.nombre as especialidad', 'config_niveles_baile.nombre as nivel')
                    ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
                    ->where('clases_grupales.fecha_inicio', '<=', Carbon::now()->toDateString())
                    ->where('clases_grupales.fecha_final', '>=', Carbon::now()->toDateString())
                ->get();

                $horarios_clasegrupal = HorarioClaseGrupal::join('clases_grupales', 'clases_grupales.id', '=', 'horarios_clases_grupales.clase_grupal_id')
                    ->join('config_clases_grupales', 'config_clases_grupales.id', '=', 'clases_grupales.clase_grupal_id')
                    ->join('config_especialidades', 'config_especialidades.id', '=', 'horarios_clases_grupales.especialidad_id')
                    ->join('config_niveles_baile', 'config_niveles_baile.id', '=', 'clases_grupales.nivel_baile_id')
                    ->join('instructores', 'horarios_clases_grupales.instructor_id', '=', 'instructores.id')
                    ->select('clases_grupales.id', 'clases_grupales.fecha_final', 'clases_grupales.cantidad_hombres','clases_grupales.cantidad_mujeres', 'horarios_clases_grupales.fecha as fecha_inicio', 'horarios_clases_grupales.hora_inicio', 'horarios_clases_grupales.hora_final', 'clases_grupales.color_etiqueta as clase_etiqueta', 'horarios_clases_grupales.color_etiqueta', 'config_clases_grupales.nombre', 'config_clases_grupales.descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id', 'instructores.sexo', 'config_especialidades.nombre as especialidad', 'config_niveles_baile.nombre as nivel')
                    ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
                    ->where('clases_grupales.deleted_at', '=', null)
                    ->where('clases_grupales.fecha_inicio', '<=', Carbon::now()->toDateString())
                    ->where('clases_grupales.fecha_final', '>=', Carbon::now()->toDateString())
                ->get();

                foreach ($clasegrupal as $clase) {


                    $fecha_start=explode('-',$clase->fecha_inicio);
                    $fecha_end=explode('-',$clase->fecha_final);

                    $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
                    $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

                    $nombre_principal = '';

                    if($dt <= Carbon::now()){

                        $cantidad_hombres = InscripcionClaseGrupal::join('alumnos', 'alumnos.id', '=', 'inscripcion_clase_grupal.alumno_id')
                        ->where('alumnos.sexo','M')
                            ->where('inscripcion_clase_grupal.clase_grupal_id',$clase->id)
                        ->count();

                        $cantidad_mujeres = InscripcionClaseGrupal::join('alumnos', 'alumnos.id', '=', 'inscripcion_clase_grupal.alumno_id')
                            ->where('alumnos.sexo','F')
                            ->where('inscripcion_clase_grupal.clase_grupal_id',$clase->id)
                        ->count();

                        if($clase->cantidad_hombres >= $cantidad_hombres && $clase->cantidad_mujeres >= $cantidad_mujeres){
                            $nombre_principal = 'AGOTADA';
                        }else{
                            $nombre_principal = $clase->nombre;
                        }

                        $inicio = 1;

                    }else{
                        
                        $nombre_principal = $clase->nombre . ' ★'; 
                        $inicio = 0;
                    }
                  

                    $nombre=$nombre_principal;
                    $nombre_clase = $clase->nombre;
                    $descripcion=$clase->descripcion;
                    $hora_inicio=$clase->hora_inicio;
                    $hora_final=$clase->hora_final;
                    $fecha_inicio = $dt->toDateString();
                    $fecha_final = $df->toDateString();
                    $instructor = $clase->instructor_nombre . ' ' .$clase->instructor_apellido;
                    $sexo = $clase->sexo;
                    $especialidad = $clase->especialidad;
                    $nivel = $clase->nivel;
                    $instructor_imagen = Instructor::find($clase->instructor_id);               
                    
                    if($instructor_imagen){
                        if($instructor_imagen->imagen){
                            $imagen = $instructor_imagen->imagen;
                        }else{
                            $imagen = '';
                        }
                    }else{
                        $imagen = '';
                    }

                    $id=$instructor."!".$especialidad."!".$nivel."!".$imagen."!".$sexo."!".$hora_inicio. ' - ' .$hora_final;

                    if($clase->color_etiqueta){
                        $etiqueta=$clase->color_etiqueta;
                    }else{
                        $etiqueta=$clase->clase_etiqueta;
                    }
         

                    if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){
                        $url = "/agendar/clases-grupales/detalle/".$clase->id;
                    }else{
                        $url = "/agendar/clases-grupales/progreso/".$clase->id;
                    }

                    $arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$fecha_inicio,"fecha_final"=>$fecha_final, "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url, 'inicio' => $inicio, "nombre_clase" => $nombre_clase);
                    
                    while($dt->timestamp<$df->timestamp){
                        $nombre = $clase->nombre;
                        $fecha="";
                        $fecha=$dt->addWeek()->toDateString();

                        $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', $fecha)
                            ->where('fecha_final', '>=', $fecha)
                            ->where('tipo_id', $clase->id)
                            ->where('tipo', 1)
                        ->first();

                        if(!$horario_bloqueado){

                            $arrayClases[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url, "nombre_clase" => $nombre_clase);
                        }else{
                            if($horario_bloqueado->boolean_mostrar == 1)
                            {
                                $arrayClases[]=array("id"=>$clase->id,"nombre"=>"CANCELADA","descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$horario_bloqueado->id."!".$horario_bloqueado->razon_cancelacion."!".$instructor."!".$fecha_inicio." - ".$fecha_final."!".$hora_inicio." - ".$hora_final."!".$imagen."!".$sexo, "nombre_clase" => $nombre_clase);
                             }
                        }
                    }
                }

                foreach ($horarios_clasegrupal as $clase) {

                    $fecha_start=explode('-',$clase->fecha_inicio);
                    $fecha_end=explode('-',$clase->fecha_final);

                    $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
                    $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

                    $nombre_principal = '';

                    $cantidad_hombres = InscripcionClaseGrupal::join('alumnos', 'alumnos.id', '=', 'inscripcion_clase_grupal.alumno_id')
                    ->where('alumnos.sexo','M')
                        ->where('inscripcion_clase_grupal.clase_grupal_id',$clase->id)
                    ->count();

                    $cantidad_mujeres = InscripcionClaseGrupal::join('alumnos', 'alumnos.id', '=', 'inscripcion_clase_grupal.alumno_id')
                        ->where('alumnos.sexo','F')
                        ->where('inscripcion_clase_grupal.clase_grupal_id',$clase->id)
                    ->count();

                    if($clase->cantidad_hombres >= $cantidad_hombres && $clase->cantidad_mujeres >= $cantidad_mujeres){
                        $nombre_principal = 'AGOTADA';
                    }else{
                        $nombre_principal = $clase->nombre;
                    }
                    
                    $nombre=$nombre_principal;
                    $nombre_clase = $clase->nombre;
                    $descripcion=$clase->descripcion;
                    $hora_inicio=$clase->hora_inicio;
                    $hora_final=$clase->hora_final;
                    $fecha_inicio = $dt->toDateString();
                    $fecha_final = $df->toDateString();
                    $etiqueta=$clase->color_etiqueta;
                    $instructor = $clase->instructor_nombre . ' ' .$clase->instructor_apellido;
                    $sexo = $clase->sexo;
                    $especialidad = $clase->especialidad;
                    $nivel = $clase->nivel;
                    $instructor_imagen = Instructor::find($clase->instructor_id);               
                    
                    if($instructor_imagen){
                        if($instructor_imagen->imagen){
                            $imagen = $instructor_imagen->imagen;
                        }else{
                            $imagen = '';
                        }
                    }else{
                        $imagen = '';
                    }

                    $id=$instructor."!".$especialidad."!".$nivel."!".$imagen."!".$sexo."!".$hora_inicio. ' - ' .$hora_final;

                    $fecha_inicio = $dt->toDateString();
                    $fecha_final = $df->toDateString();

                    if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){
                        $url = "/agendar/clases-grupales/detalle/".$clase->id;
                    }else{
                        $url = "/agendar/clases-grupales/progreso/".$clase->id;
                    }

                    $arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url, "nombre_clase" => $nombre_clase);

                    while($dt->timestamp<$df->timestamp){
                        $fecha="";
                        $fecha=$dt->addWeek()->toDateString();

                        $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', $fecha)
                            ->where('fecha_final', '>=', $fecha)
                            ->where('tipo_id', $clase->id)
                            ->where('tipo', 1)
                        ->first();

                         if(!$horario_bloqueado){

                            $arrayClases[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url, "nombre_clase" => $nombre_clase);
                        }else{
                            if($horario_bloqueado->boolean_mostrar == 1)
                            {
                                $arrayClases[]=array("id"=>$clase->id,"nombre"=>"CANCELADA","descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$horario_bloqueado->id."!".$horario_bloqueado->razon_cancelacion."!".$instructor."!".$fecha_inicio." - ".$fecha_final."!".$hora_inicio." - ".$hora_final."!".$imagen."!".$sexo, "nombre_clase" => $nombre_clase);
                             }
                        }
                    }
                }

                $config_clases_personalizadas = ConfigClasesPersonalizadas::where('academia_id',Auth::user()->academia_id)->first();

                $query = InscripcionClasePersonalizada::join('clases_personalizadas', 'clases_personalizadas.id', '=', 'inscripcion_clase_personalizada.clase_personalizada_id')
                    ->join('alumnos', 'alumnos.id', '=', 'inscripcion_clase_personalizada.alumno_id')
                    ->join('config_especialidades', 'config_especialidades.id', '=', 'inscripcion_clase_personalizada.especialidad_id')
                    ->join('instructores', 'instructores.id', '=', 'inscripcion_clase_personalizada.instructor_id')
                    ->select('inscripcion_clase_personalizada.*','clases_personalizadas.color_etiqueta', 'alumnos.nombre', 'alumnos.apellido', 'config_especialidades.nombre as especialidad', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_personalizadas.nombre as clase_personalizada_nombre', 'instructores.id as instructor_id', 'instructores.sexo')
                    ->where('clases_personalizadas.academia_id', '=' ,  Auth::user()->academia_id)
                    ->where('inscripcion_clase_personalizada.fecha_inicio', '>=', Carbon::now()->toDateString());

                if($usuario_tipo == 2 || $usuario_tipo == 4){
                    $query->where('inscripcion_clase_personalizada.alumno_id', '=', $usuario_id);
                }

                $clasespersonalizadas = $query->get();

                $query = InscripcionClasePersonalizada::join('clases_personalizadas', 'clases_personalizadas.id', '=', 'inscripcion_clase_personalizada.clase_personalizada_id')
                    ->join('horarios_clases_personalizadas', 'inscripcion_clase_personalizada.id', '=', 'horarios_clases_personalizadas.clase_personalizada_id')
                    ->join('config_especialidades', 'config_especialidades.id', '=', 'horarios_clases_personalizadas.especialidad_id')
                    ->join('instructores', 'instructores.id', '=', 'horarios_clases_personalizadas.instructor_id')
                    ->join('alumnos', 'alumnos.id', '=', 'inscripcion_clase_personalizada.alumno_id')
                    ->select('inscripcion_clase_personalizada.fecha_final', 'horarios_clases_personalizadas.fecha as fecha_inicio', 'horarios_clases_personalizadas.hora_inicio', 'horarios_clases_personalizadas.hora_final', 'clases_personalizadas.color_etiqueta as clase_etiqueta', 'horarios_clases_personalizadas.color_etiqueta', 'clases_personalizadas.nombre', 'clases_personalizadas.descripcion', 'inscripcion_clase_personalizada.id', 'alumnos.nombre', 'alumnos.apellido', 'config_especialidades.nombre as especialidad', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_personalizadas.nombre as clase_personalizada_nombre', 'instructores.id as instructor_id', 'instructores.sexo')
                    ->where('clases_personalizadas.academia_id', '=' ,  Auth::user()->academia_id)
                    ->where('horarios_clases_personalizadas.fecha', '>=', Carbon::now()->toDateString());

                if($usuario_tipo == 2 || $usuario_tipo == 4){
                    $query->where('inscripcion_clase_personalizada.alumno_id', '=', $usuario_id);
                }

                $horarios_clasespersonalizadas = $query->get();

                foreach ($clasespersonalizadas as $clasepersonalizada) {

                    $fecha_start=explode('-',$clasepersonalizada->fecha_inicio);
                    $fecha_end=explode('-',$clasepersonalizada->fecha_inicio);
                    $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
                    $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

                    $nombre= 'Clase P ' . $clasepersonalizada->nombre . ' ' . $clasepersonalizada->apellido;
                    $descripcion=$config_clases_personalizadas->descripcion;
                    $hora_inicio=$clasepersonalizada->hora_inicio;
                    $hora_final=$clasepersonalizada->hora_final;
                    $etiqueta=$clasepersonalizada->color_etiqueta;
                    $instructor = $clasepersonalizada->instructor_nombre . ' ' .$clasepersonalizada->instructor_apellido;
                    $especialidad = $clasepersonalizada->especialidad;    
                    $clase_personalizada_nombre = $clasepersonalizada->clase_personalizada_nombre;
                    $sexo = $clasepersonalizada->sexo;
                    $instructor_imagen = Instructor::find($clasepersonalizada->instructor_id);               
                    
                    if($instructor_imagen->imagen){
                        $imagen = $instructor_imagen->imagen;
                    }else{
                        $imagen = '';
                    }

                    if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){
                        $url = "/agendar/clases-personalizadas/detalle/".$clasepersonalizada->id;
                    }else{
                        $url  = "/agendar/clases-personalizadas/progreso/".Auth::user()->academia_id;
                    }

                    $id=$instructor."!".$especialidad."!".$clase_personalizada_nombre."!".$imagen."!".$sexo."!".$hora_inicio. ' - ' .$hora_final;

                    $asistencia = Asistencia::where('tipo',3)->where('tipo_id',$clasepersonalizada->id)->where('fecha',$dt->toDateString());

                    // if(!$asistencia){
                        $arrayClasespersonalizadas[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url);
                    // }
                    
                    while($dt->timestamp<$df->timestamp){
                        $fecha="";
                        $fecha=$dt->addWeek()->toDateString();
                        $arrayClasespersonalizadas[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url);
                    }
                }

                foreach ($horarios_clasespersonalizadas as $clasepersonalizada) {

                    $fecha_start=explode('-',$clasepersonalizada->fecha_inicio);
                    $fecha_end=explode('-',$clasepersonalizada->fecha_inicio);
                    $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
                    $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

                    $nombre= 'Clase P ' . $clasepersonalizada->nombre . ' ' . $clasepersonalizada->apellido;
                    $descripcion=$config_clases_personalizadas->descripcion;
                    $hora_inicio=$clasepersonalizada->hora_inicio;
                    $hora_final=$clasepersonalizada->hora_final;
                    if($clasepersonalizada->color_etiqueta){
                        $etiqueta=$clasepersonalizada->color_etiqueta;
                    }else{
                        $etiqueta=$clasepersonalizada->clase_etiqueta;
                    }
                    $instructor = $clasepersonalizada->instructor_nombre . ' ' .$clasepersonalizada->instructor_apellido;
                    $especialidad = $clasepersonalizada->especialidad;    
                    $clase_personalizada_nombre = $clasepersonalizada->clase_personalizada_nombre;
                    $sexo = $clasepersonalizada->sexo;
                    
                    $instructor_imagen = Instructor::find($clasepersonalizada->instructor_id);               
                    
                    if($instructor_imagen->imagen){
                        $imagen = $instructor_imagen->imagen;
                    }else{
                        $imagen = '';
                    }

                    $id=$instructor."!".$especialidad."!".$clase_personalizada_nombre."!".$imagen."!".$sexo."!".$hora_inicio. ' - ' .$hora_final;

                    if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){
                        $url = "/agendar/clases-personalizadas/detalle/".$clasepersonalizada->id;
                    }else{
                        $url  = "/agendar/clases-personalizadas/progreso/".Auth::user()->academia_id;
                    }

                    $asistencia = Asistencia::where('tipo',3)->where('tipo_id',$clasepersonalizada->id)->where('fecha',$dt->toDateString());

                    // if(!$asistencia){
                        $arrayClasespersonalizadas[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url);
                    // }

                    while($dt->timestamp<$df->timestamp){
                        $fecha="";
                        $fecha=$dt->addWeek()->toDateString();
                        $arrayClasespersonalizadas[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url);
                    }

                }

                $fiestas = Fiesta::where('fiestas.academia_id', '=' ,  Auth::user()->academia_id)
                    ->where('fiestas.fecha_inicio', '>=', Carbon::now()->format('Y-m-d'))
                ->get();

                foreach ($fiestas as $fiesta) {
                    $fecha_start=explode('-',$fiesta->fecha_inicio);
                    $fecha_end=explode('-',$fiesta->fecha_final);

                    $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
                    $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

                    $id=$fiesta->id;
                    $nombre= $fiesta->nombre;
                    $descripcion=$fiesta->descripcion;
                    $hora_inicio=$fiesta->hora_inicio;
                    $hora_final=$fiesta->hora_final;
                    $etiqueta=$fiesta->color_etiqueta;

                    if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){
                        $url = "/agendar/fiestas/detalle/".$fiesta->id;
                    }else{
                        $url = "/agendar/fiestas/progreso/".$fiesta->id;
                    }

                    $arrayFiestas[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url);

                    while($dt->timestamp<$df->timestamp){
                        $fecha="";
                        $fecha=$dt->addWeek()->toDateString();
                        $arrayFiestas[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url);
                    }

                }

                $query = Cita::join('alumnos', 'citas.alumno_id', '=', 'alumnos.id')
                    ->join('instructores', 'citas.instructor_id', '=', 'instructores.id')
                    ->join('config_citas', 'citas.tipo_id', '=', 'config_citas.id')
                    ->select('citas.*','alumnos.nombre as alumno_nombre', 'alumnos.apellido as alumno_apellido', 'alumnos.id as alumno_id', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'config_citas.nombre as nombre', 'instructores.id as instructor_id', 'instructores.sexo')
                    ->where('citas.academia_id','=', Auth::user()->academia_id)
                    ->where('citas.estatus','=','1')
                    ->where('citas.fecha', '>=', Carbon::now()->format('Y-m-d'));

                if($usuario_tipo == 2 || $usuario_tipo == 4){
                    $query->where('citas.alumno_id', '=', $usuario_id);
                }else{
                    $query->where('citas.boolean_mostrar','=','2');
                }

                $citas = $query->get();

                foreach ($citas as $cita) {

                    if($cita->tipo_id != 5){
                        $nombre = $cita->alumno_nombre . ' ' . $cita->alumno_apellido;
                    }else{
                        $nombre = $cita->alumno_nombre . ' ' . $cita->alumno_apellido . ' ★'; 
                    }

                    $fecha_start=explode('-',$cita->fecha);
                    $fecha_end=explode('-',$cita->fecha);

                    $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);
                    $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);
                    
                    $descripcion=$cita->nombre;
                    $hora_inicio=$cita->hora_inicio;
                    $hora_final=$cita->hora_final;
                    $etiqueta=$cita->color_etiqueta;
                    $etiqueta=$cita->color_etiqueta;
                    $instructor = $cita->instructor_nombre . ' ' .$cita->instructor_apellido;
                    $sexo = $cita->sexo;
                    $instructor_imagen = Instructor::find($cita->instructor_id);               
                    
                    if($instructor_imagen->imagen){
                        $imagen = $instructor_imagen->imagen;
                    }else{
                        $imagen = '';
                    }


                    $alumno = Alumno::find($cita->alumno_id);

                    if($alumno->tipo_pago == 1){
                        $tipo_pago = 'Contado';
                    }else if($alumno->tipo_pago == 2){
                        $tipo_pago = 'Credito';
                    }else{
                        $tipo_pago = 'Sin Confirmar';
                    }

                    $id=$instructor."!".$descripcion."!".$imagen."!".$sexo."!".$hora_inicio. ' - ' .$hora_final."!".$tipo_pago;

                    if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){
                        $url = "/agendar/citas/detalle/".$cita->id;
                    }else{
                        $url = "";
                    }

                    $arrayCitas[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>$url);

                }

                $transmisiones = Transmision::where('academia_id', Auth::user()->academia_id)->where('fecha', '>=', Carbon::now()->format('Y-m-d'))->get();

                foreach ($transmisiones as $transmision) {

                    $fecha=explode('-',$transmision->fecha);
                    $fecha = Carbon::createFromFormat('Y-m-d', $transmision->fecha)->toDateString();
                    $tema=$transmision->tema;
                    $hora=$transmision->hora;
                    $presentador=$transmision->presentador;
                    $etiqueta=$transmision->color_etiqueta;

                    $id=$tema."!".$fecha."!".$hora."!".$presentador;

                    if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){
                        $url = "/agendar/transmisiones/detalle/".$transmision->id;
                    }else{
                        $url = "";
                    }

                    $arrayTransmisiones[]=array("id"=>$id,"nombre"=>'Transmisión', "fecha"=> $fecha, "hora"=>$hora, "etiqueta"=>$etiqueta,"url"=>$url);
                }


                $start = Carbon::now()->startOfMonth()->toDateString();
                $end = Carbon::now()->endOfMonth()->toDateString();  

                $mujeres = Visitante::where('academia_id','=', Auth::user()->academia_id)
                    ->where('sexo','F')
                    ->whereBetween('fecha_registro', [$start,$end])
                ->count();

                $hombres = Visitante::where('academia_id','=', Auth::user()->academia_id)
                    ->where('sexo','M')
                    ->whereBetween('fecha_registro', [$start,$end])
                ->count();

                $egresos_generales = Egreso::where('egresos.academia_id', Auth::user()->academia_id)->where('tipo',1)->whereBetween('egresos.fecha', [$start,$end])->sum('egresos.cantidad');

                if(!$egresos_generales){
                    $egresos_generales = 0;
                }

                $egresos_eventos = Egreso::where('egresos.academia_id', Auth::user()->academia_id)->where('tipo',2)->whereBetween('egresos.fecha', [$start,$end])->sum('egresos.cantidad');

                if(!$egresos_eventos){
                    $egresos_eventos = 0;
                }

                $egresos_talleres = Egreso::where('egresos.academia_id', Auth::user()->academia_id)->where('tipo',3)->whereBetween('egresos.fecha', [$start,$end])->sum('egresos.cantidad');

                if(!$egresos_talleres){
                    $egresos_talleres = 0;
                }

                $egresos_campanas = Egreso::where('egresos.academia_id', Auth::user()->academia_id)->where('tipo',4)->whereBetween('egresos.fecha', [$start,$end])->sum('egresos.cantidad');

                if(!$egresos_campanas){
                    $egresos_campanas = 0;
                }

                $egresos_totales = $egresos_generales + $egresos_eventos + $egresos_talleres + $egresos_campanas;

                if($egresos_totales){
                    $porcentaje_general = intval(($egresos_generales / $egresos_totales) * 100);
                    $porcentaje_evento = intval(($egresos_eventos / $egresos_totales) * 100);
                    $porcentaje_taller = intval(($egresos_talleres / $egresos_totales) * 100);
                    $porcentaje_campana = intval(($egresos_campanas / $egresos_totales) * 100);
                }else{
                    $porcentaje_general = 0;
                    $porcentaje_evento = 0;
                    $porcentaje_taller = 0;
                    $porcentaje_campana = 0;
                }

                $ingresos_generales = 0;
                $ingresos_eventos = 0;
                $ingresos_talleres = 0;
                $ingresos_campanas = 0;

                $ingresos = Factura::where('academia_id', Auth::user()->academia_id)->whereBetween('created_at', [$start,$end])->get();

                foreach($ingresos as $ingreso){
                    $facturas = ItemsFactura::where('factura_id', $ingreso->id)->get();
                    foreach($facturas as $factura){
                        if($factura->tipo == 5){

                            $ingresos_talleres += floatval($factura->importe_neto);

                        }else if($factura->tipo == 14){

                            $ingresos_eventos += floatval($factura->importe_neto);

                        }else if($factura->tipo == 11 OR $factura->tipo == 12){

                            $ingresos_campanas += floatval($factura->importe_neto);

                        }else{
                            $ingresos_generales += floatval($factura->importe_neto);
                        }
                    }
                }


                $ingresos_totales = $ingresos_generales + $ingresos_eventos + $ingresos_talleres + $ingresos_campanas;

                if($ingresos_totales){
                    $porcentaje_ingreso_general = intval(($ingresos_generales / $ingresos_totales) * 100);
                    $porcentaje_ingreso_evento = intval(($ingresos_eventos / $ingresos_totales) * 100);
                    $porcentaje_ingreso_taller = intval(($ingresos_talleres / $ingresos_totales) * 100);
                    $porcentaje_ingreso_campana = intval(($ingresos_campanas / $ingresos_totales) * 100);
                }else{
                    $porcentaje_ingreso_general = 0;
                    $porcentaje_ingreso_evento = 0;
                    $porcentaje_ingreso_taller = 0;
                    $porcentaje_ingreso_campana = 0;
                }

                // return view('inicio.index')->with(['paises' => Paises::all() , 'especialidades' => ConfigEspecialidades::all(), 'academia' => $academia, 'vencimiento' => $vencimiento]); 

                return view('inicio.index-con-reportes')->with(['paises' => Paises::all() , 'especialidades' => ConfigEspecialidades::all(), 'academia' => $academia, 'vencimiento' => $vencimiento, 'talleres' => $arrayTalleres, 'clases_grupales' => $arrayClases, 'clases_personalizadas' => $arrayClasespersonalizadas, 'fiestas' => $arrayFiestas, 'citas' => $arrayCitas, 'transmisiones' => $arrayTransmisiones, 'mujeres' => $mujeres, 'hombres' => $hombres, 'egresos_generales' => $egresos_generales, 'egresos_eventos' => $egresos_eventos, 'egresos_talleres' => $egresos_talleres, 'egresos_campanas' => $egresos_campanas, 'porcentaje_general' => $porcentaje_general, 'porcentaje_evento' => $porcentaje_evento, 'porcentaje_taller' => $porcentaje_taller, 'porcentaje_campana' => $porcentaje_campana, 'ingresos_generales' => $ingresos_generales, 'ingresos_eventos' => $ingresos_eventos, 'ingresos_talleres' => $ingresos_talleres, 'ingresos_campanas' => $ingresos_campanas, 'porcentaje_ingreso_general' => $porcentaje_ingreso_general, 'porcentaje_ingreso_evento' => $porcentaje_ingreso_evento, 'porcentaje_ingreso_taller' => $porcentaje_ingreso_taller, 'porcentaje_ingreso_campana' => $porcentaje_ingreso_campana]);
                
            }else if($usuario_tipo == 2 || $usuario_tipo == 4){

                $alumno = Alumno::find($usuario_id);
                
                if(!$alumno){
                    return view('inicio.cuenta-deshabilitada');
                }else{
                    if(Session::has('fecha_comprobacion')){

                        $fecha_comprobacion = Session::get('fecha_comprobacion');
                        $hoy = Carbon::now()->toDateString();

                        if($fecha_comprobacion < $hoy){
                            return $this->inactividad();
                        }
                    }else{
                        return $this->inactividad();
                    }
                }

                //ALUMNOS
                if(Auth::user()->boolean_condiciones){

                    $contador_clase = 0;
                    $contador_taller = 0;
                    $contador_fiesta = 0;
                    $contador_campana = 0;

                    $array=array();

                    $clase_grupal_join = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                        ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
                        ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                        ->select('clases_grupales.*','config_especialidades.nombre as especialidad', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'config_clases_grupales.nombre','config_clases_grupales.descripcion')
                        ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
                        ->where('clases_grupales.boolean_promocionar','=', 1)
                        ->where('clases_grupales.deleted_at', '=', null)
                    ->get();

                    foreach($clase_grupal_join as $clase_grupal){

                        $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
                        $fecha->addDays($clase_grupal->dias_prorroga);
                        if($fecha >= Carbon::now()){
                            $contador_clase = $contador_clase + 1;
                            $disponible = '';
                        }else{
                            $disponible = ' ( No disponible )';
                        }

                        if($clase_grupal->imagen){
                            $imagen = "/assets/uploads/clase_grupal/{$clase_grupal->imagen}";
                        }else{
                            $imagen = '';
                        }

                        $fecha_inicio = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio)->format('d-m-Y');

                        $horarios = HorarioClaseGrupal::where('clase_grupal_id', $clase_grupal->id)->get();
                        $i = 0;
                        $len = count($horarios);
                        $dia_string = '';
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
         
                        $dia_string = $dia_string . $dia;
                        
                        foreach($horarios as $horario){

                            if($dia_string != ''){
                                $dia_string = $dia_string . ', ';
                            }

                            $fecha = Carbon::createFromFormat('Y-m-d', $horario->fecha);
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
                            if ($i != $len - 1) {
                                $dia_string = $dia_string . $dia;
                            }else{
                                $dia_string = $dia_string . 'y ' . $dia;
                            }

                            $i++;

                        }


                        $array[]=array('nombre' => $clase_grupal->nombre , 'descripcion' => $clase_grupal->descripcion ,'imagen' => $imagen , 'url' => "/agendar/clases-grupales/progreso/{$clase_grupal->id}", 'facebook' => "/agendar/clases-grupales/progreso/{$clase_grupal->id}", 'twitter' => "Participa en la clase grupal {$clase_grupal->nombre} te invita @EasyDanceLatino", 'twitter_url' => "/agendar/clases-grupales/progreso/{$clase_grupal->id}", 'creacion' => $clase_grupal->created_at, 'tipo' => 1, 'fecha_inicio' => $fecha_inicio, 'disponible' => $disponible, 'dias' => $dia_string, 'instructor' => $clase_grupal->instructor_nombre . ' ' . $clase_grupal->instructor_apellido, 'hora' => $clase_grupal->hora_inicio . ' - ' . $clase_grupal->hora_final, 'especialidad' => $clase_grupal->especialidad, 'fecha' => $fecha_inicio);

                    }

                    $talleres = Taller::join('config_especialidades', 'talleres.especialidad_id', '=', 'config_especialidades.id')
                        ->join('instructores', 'talleres.instructor_id', '=', 'instructores.id')
                        ->select('talleres.*','config_especialidades.nombre as especialidad', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido')
                        ->where('talleres.academia_id', '=' ,  Auth::user()->academia_id)
                    ->get();

                    foreach($talleres as $taller){

                        $fecha = Carbon::createFromFormat('Y-m-d', $taller->fecha_inicio);

                        if($fecha >= Carbon::now() && $taller->boolean_promocionar == 1){

                            if($taller->imagen){
                                $imagen = "/assets/uploads/taller/{$taller->imagen}";
                            }else{
                                $imagen = '';
                            }

                            $fecha_inicio = Carbon::createFromFormat('Y-m-d', $taller->fecha_inicio)->format('d-m-Y');

                            $horarios = HorarioTaller::where('taller_id', $taller->id)->get();
                            $i = 0;
                            $len = count($horarios);
                            $dia_string = '';
                            $fecha = Carbon::createFromFormat('Y-m-d', $taller->fecha_inicio);
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
             
                            $dia_string = $dia_string . $dia;
                            
                            foreach($horarios as $horario){

                                if($dia_string != ''){
                                    $dia_string = $dia_string . ', ';
                                }

                                $fecha = Carbon::createFromFormat('Y-m-d', $horario->fecha);
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
                                if ($i != $len - 1) {
                                    $dia_string = $dia_string . $dia;
                                }else{
                                    $dia_string = $dia_string . 'y ' . $dia;
                                }

                                $i++;

                            }

                            $array[]=array('nombre' => $taller->nombre , 'descripcion' => $taller->descripcion ,'imagen' => $imagen , 'url' => "/agendar/talleres/progreso/{$taller->id}", 'facebook' => "/agendar/talleres/progreso/{$taller->id}", 'twitter' => "Participa en el taller {$taller->nombre} te invita @EasyDanceLatino", 'twitter_url' => "/agendar/talleres/progreso/{$taller->id}" , 'creacion' => $taller->created_at, 'tipo' => 2, 'fecha_inicio' => $taller->fecha_inicio, 'disponible' => '', 'dias' => $dia_string, 'instructor' => $taller->instructor_nombre . ' ' . $taller->instructor_apellido, 'hora' => $taller->hora_inicio . ' - ' . $taller->hora_final, 'especialidad' => $taller->especialidad, 'fecha' => $fecha_inicio);

                            $contador_taller = $contador_taller + 1;
                        }

                    }

                    $fiestas = Fiesta::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

                    foreach($fiestas as $fiesta){

                        $fecha = Carbon::createFromFormat('Y-m-d', $fiesta->fecha_inicio);

                        if($fecha >= Carbon::now() && $fiesta->boolean_promocionar == 1){

                            if($fiesta->imagen){
                                $imagen = "/assets/uploads/fiesta/{$fiesta->imagen}";
                            }else{
                                $imagen = '';
                            }

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

                            $array[]=array('nombre' => $fiesta->nombre , 'descripcion' => $fiesta->descripcion ,'imagen' => $imagen , 'url' => "/agendar/fiestas/progreso/{$fiesta->id}", 'facebook' => "/agendar/fiesta/progreso/{$fiesta->id}", 'twitter' => "Participa en la fiesta {$fiesta->nombre} te invita @EasyDanceLatino", 'twitter_url' => "/agendar/fiestas/progreso/{$fiesta->id}", 'creacion' => $fiesta->created_at, 'tipo' => 3, 'fiesta' => $fiesta->fecha_inicio, 'disponible' => '', 'dias' => $dia, 'instructor' => '', 'hora' => $fiesta->hora_inicio . ' - ' . $fiesta->hora_final, 'especialidad' => '', 'fecha' => $fecha->format('d-m-Y'));

                            $contador_fiesta = $contador_fiesta + 1;
                        }

                    }

                    $campanas = Campana::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

                    foreach($campanas as $campana){

                        $fecha = Carbon::createFromFormat('Y-m-d', $campana->fecha_final);

                        if($fecha >= Carbon::now()){

                            $contador_campana = $contador_campana + 1;
                        }

                    }

                    $collection = collect($array);

                    $sorted = $collection->sortByDesc('creacion');

                    $i = 0;

                    $arreglo=array();

                    foreach($sorted as $tmp){
                        $tmp['contador'] = $i;
                        $arreglo[$i] = $tmp;
                        $i = $i + 1;
                    }

                    $instructor_contador = Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->where('instructores.boolean_promocionar', 1)->count();
                    $clase_personalizada_contador = ClasePersonalizada::where('academia_id', '=' ,  Auth::user()->academia_id)->count();

                    $perfil = PerfilEvaluativo::where('usuario_id', $usuario_id)->first();

                    if($perfil){
                        $tiene_perfil = 1;
                    }else{
                        $tiene_perfil = 0;
                    }

                    $array_deuda = array();

                    if (!Session::has('fecha_sesion')) {                
                       $fecha_sesion=Carbon::now();
                       Session::put('fecha_sesion',$fecha_sesion);
                    }

                    $credenciales_alumno = CredencialAlumno::join('instructores','credenciales_alumno.instructor_id','=','instructores.id')
                        ->select('credenciales_alumno.*', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id', 'instructores.sexo')
                        ->where('credenciales_alumno.alumno_id',$usuario_id)
                    ->get();

                    $array_credencial = array();
                    $total_credenciales = 0;

                    foreach($credenciales_alumno as $credencial_alumno){

                        $instructor = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                            ->where('usuarios_tipo.tipo',3)
                            ->where('usuarios_tipo.tipo_id',$credencial_alumno->instructor_id)
                        ->first();

                        if($instructor){

                          if($instructor->imagen){
                            $imagen = $instructor->imagen;
                          }else{
                            $imagen = '';
                          }

                        }

                        $collection=collect($credencial_alumno);     
                        $credencial_array = $collection->toArray();
                            
                        $credencial_array['imagen']=$imagen;
                        $array_credencial[$credencial_alumno->id] = $credencial_array;

                        $total_credenciales = $total_credenciales + $credencial_alumno->cantidad;
                    }

                    $puntos_referidos = AlumnoRemuneracion::where('alumno_id',$usuario_id)->sum('remuneracion');

                    $alumno_examenes = Evaluacion::join('alumnos','evaluaciones.alumno_id','=','alumnos.id')
                        ->join('examenes','evaluaciones.examen_id','=','examenes.id')
                        ->select('examenes.nombre','evaluaciones.id')
                        ->where('evaluaciones.alumno_id','=',$usuario_id)
                    ->get();

                    
                    return view('vista_alumno.index')->with(['academia' => $academia, 'enlaces' => $arreglo , 'clases_grupales' => $contador_clase, 'talleres' => $contador_taller , 'fiestas' =>  $contador_fiesta ,'contador_campana' => $contador_campana ,'regalos' => Regalo::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'perfil' => $tiene_perfil, 'instructor_contador' => $instructor_contador, 'clase_personalizada_contador' => $clase_personalizada_contador, 'alumno_examenes' => $alumno_examenes, 'alumno' => $alumno, 'credenciales_alumno' => $array_credencial, 'total_credenciales' => $total_credenciales, 'campanas' => $campanas, 'puntos_referidos' => $puntos_referidos]);  
                    
                }else{
                    return view('vista_alumno.condiciones')->with('academia', $academia);
                }
            }else if($usuario_tipo == 3){


                $instructor = Instructor::find($usuario_id);

                if(!$instructor){
                    return view('inicio.cuenta-deshabilitada');
                }

                return view('vista_instructor.index')->with(['academia' => $academia, 'instructor' => $instructor]);  
            }
        }else{
            return redirect("/seleccionar-tipo");
        }
                           
    }

    public function menu(){

        $datos = $this->getDatosUsuario();

        $usuario_tipo = $datos[0]['usuario_tipo'];

        if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){
            return view('menu.index');
        }else{
            return redirect("/inicio"); 
        }
        
    }

    /**
      * PAGOS RECURRENTES o MENSUALIDADES
      * Var $tipo => Tipo de Accion,
      *     $result => Arreglo donde se guarda
                       la respuesta a mostrar, podria
                       no usuarse mas adelante.
      *     $cantidad => Valor Cantidad de la Base de Datos,
                         en este caso sera una constante.
      *     $ConfigClasesGrupales => consulta al modelo de Configuracion
                                    de clases grupales para obtener los
                                    datos de la clase
            $InscripcionClaseGrupal => Consulta al modelo de Inscripcion de
                                    de clase grupales para verificar si hay
                                    alumnos inscritos, para luego cargarles
                                    una deuda en caso de tenerla
            $FacturaProforma => Consulta al modelo de detalles de
                                Proforma para verificar si hay deuda para
                                no cargarle una misma deuda mas de una vez           
      */
    public function pagorecurrente()
    {
        $result = array();
        $tipo = 4;
        $cantidad = 1;
        $id = 0;
        $academia = Academia::find(Auth::user()->academia_id);
        $academia->fecha_comprobacion = Carbon::now()->toDateString();
        $academia->save();

        $ConfigClasesGrupales = ConfigClasesGrupales::select('config_clases_grupales.id',
                'config_clases_grupales.nombre','config_clases_grupales.costo_inscripcion',
                'config_clases_grupales.costo_mensualidad', 'clases_grupales.id',
                'clases_grupales.fecha_inicio', 'clases_grupales.fecha_final',
                'clases_grupales.fecha_inicio_preferencial', 'clases_grupales.id as clase_grupal_id')
                ->join('clases_grupales', 'clases_grupales.clase_grupal_id','=','config_clases_grupales.id')
                ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
                ->where('clases_grupales.deleted_at', '=', null)
                ->where('clases_grupales.fecha_final', '>', Carbon::now()->format("Y-m-d"))
                ->get();

        $InscripcionClaseGrupal = InscripcionClaseGrupal::select('inscripcion_clase_grupal.clase_grupal_id AS ClaseGrupalID', 
            'inscripcion_clase_grupal.alumno_id AS AlumnoId',
            'inscripcion_clase_grupal.fecha_pago', 
            'alumnos.identificacion AS Identificacion', 'alumnos.nombre AS NombreAlumno', 
            'alumnos.apellido AS ApellidoAlumno', 'alumnos.telefono AS TelefonoAlumno', 
            'alumnos.celular as CelularAlumno','config_clases_grupales.nombre AS ClaseNombre', 'inscripcion_clase_grupal.id as InscripcionID', 'inscripcion_clase_grupal.costo_mensualidad AS Costo')
            ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id','=',
                   'clases_grupales.id')
            ->join('alumnos', 'inscripcion_clase_grupal.alumno_id','=','alumnos.id')
            ->join('config_clases_grupales', 'config_clases_grupales.id','=',
                   'clases_grupales.clase_grupal_id')
            ->where('inscripcion_clase_grupal.deleted_at', '=', null)
        ->get();
        
            //Desgloso la Fecha Preferencial
        foreach ($InscripcionClaseGrupal as $InscripcionClase ) {

            $fecha_cuota_explode=explode('-', $InscripcionClase->fecha_pago);

            foreach ($ConfigClasesGrupales as $configClases) {

                $fecha_inicio_preferencial = Carbon::createFromFormat('Y-m-d', $configClases->fecha_inicio_preferencial);

                if ($fecha_inicio_preferencial <= Carbon::now()){

                    $fecha_inicio_preferencial = $fecha_inicio_preferencial->addMonth()->toDateString();

                    $clase_grupal = ClaseGrupal::find($configClases->clase_grupal_id);
                    $clase_grupal->fecha_inicio_preferencial = $fecha_inicio_preferencial;
                    $clase_grupal->save();

                }

                $fecha_pago = Carbon::createFromFormat('Y-m-d', $InscripcionClase->fecha_pago);

                if ($fecha_pago <= Carbon::now()){

                    if($configClases->id == $InscripcionClase->ClaseGrupalID){

                        $FacturaProforma = ItemsFacturaProforma::select(
                        'items_factura_proforma.tipo', 
                        'items_factura_proforma.usuario_id')
                        ->where('items_factura_proforma.tipo','=',$tipo)
                        ->where('items_factura_proforma.usuario_id', '=', $InscripcionClase->AlumnoId)
                        ->where('items_factura_proforma.item_id', '=', $configClases->clase_grupal_id)
                        ->get()->count();

                        /** AQUI CONVERTIMOS LA FECHA PREFERENCIAL PARA PODER
                            OBTENER LA FECHA LIMITE DE PAGO **/
                        $fecha_cuota = Carbon::create($fecha_cuota_explode[0], $fecha_cuota_explode[1], $fecha_cuota_explode[2],0);

                        /** AQUI CALCULAMOS LA FECHA FECHA LIMITE DE PAGO **/
                        $tolerancia = $fecha_cuota->addDay($configClases->tiempo_tolerancia)->toDateString();
                        
                        if($FacturaProforma == 0 && $InscripcionClase->Costo > 0){

                            $fecha_final = Carbon::createFromFormat('Y-m-d', $configClases->fecha_final);

                            if($fecha_final > Carbon::now()){
                                
                                $fecha_cuota = $fecha_cuota->addMonth()->toDateString();
                                
                                $clasegrupal = InscripcionClaseGrupal::find($InscripcionClase->InscripcionID);

                                $clasegrupal->fecha_pago = $fecha_cuota;
                                $clasegrupal->save();

                                $item_factura = new ItemsFacturaProforma;
                                
                                $item_factura->usuario_id = $InscripcionClase->AlumnoId;
                                $item_factura->usuario_tipo = 1;
                                $item_factura->academia_id = Auth::user()->academia_id;
                                $item_factura->fecha = Carbon::now()->toDateString();
                                $item_factura->item_id = $configClases->id;
                                $item_factura->nombre = 'Cuota ' . $configClases->nombre;
                                $item_factura->tipo = $tipo;
                                $item_factura->cantidad = $cantidad;
                                $item_factura->importe_neto = $InscripcionClase->Costo;
                                $item_factura->fecha_vencimiento = Carbon::now()->toDateString();

                                $item_factura->save();

                            }

                        }
                                        
                    }
                                 
                }    
            }
        }

        return $this->tiempotolerancia();
    }

    public function tiempotolerancia(){

        $academia = Academia::find(Auth::user()->academia_id);
        $contador_clase = 0;
        $contador_taller = 0;
        $contador_fiesta = 0;
        $contador_campana = 0;

        $tipo = 8;

        $ConfigClasesGrupales = ConfigClasesGrupales::select('config_clases_grupales.id',
                'config_clases_grupales.nombre','config_clases_grupales.costo_inscripcion',
                'config_clases_grupales.costo_mensualidad', 'clases_grupales.id',
                'clases_grupales.fecha_inicio', 'clases_grupales.fecha_final',
                'clases_grupales.fecha_inicio_preferencial', 'config_clases_grupales.tiempo_tolerancia', 'config_clases_grupales.porcentaje_retraso')
                        ->join('clases_grupales', 'clases_grupales.clase_grupal_id','=','config_clases_grupales.id')
                        ->get();

        $InscripcionClaseGrupal = InscripcionClaseGrupal::select('inscripcion_clase_grupal.clase_grupal_id AS ClaseGrupalID', 
            'inscripcion_clase_grupal.alumno_id AS AlumnoId',
            'inscripcion_clase_grupal.fecha_pago', 
            'alumnos.identificacion AS Identificacion', 'alumnos.nombre AS NombreAlumno', 
            'alumnos.apellido AS ApellidoAlumno', 'alumnos.telefono AS TelefonoAlumno', 
            'alumnos.celular as CelularAlumno','config_clases_grupales.nombre AS ClaseNombre', 'inscripcion_clase_grupal.id as InscripcionID', 'inscripcion_clase_grupal.costo_mensualidad AS Costo')
                ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id','=',
                       'clases_grupales.id')
                ->join('alumnos', 'inscripcion_clase_grupal.alumno_id','=','alumnos.id')
                ->join('config_clases_grupales', 'config_clases_grupales.id','=',
                       'clases_grupales.clase_grupal_id')
                ->get();
        
        
            //Desgloso la Fecha Preferencial
        foreach ($InscripcionClaseGrupal as $InscripcionClase ) {

            foreach ($ConfigClasesGrupales as $configClases) {

                if($configClases->id == $InscripcionClase->ClaseGrupalID){

                    $FacturaProforma = ItemsFacturaProforma::select(
                    'items_factura_proforma.tipo', 
                    'items_factura_proforma.usuario_id')
                    ->where('items_factura_proforma.tipo','=',$tipo)
                    ->where('items_factura_proforma.usuario_id', '=', $InscripcionClase->AlumnoId)
                    ->get()->count();

                    /** AQUI CONVERTIMOS LA FECHA PREFERENCIAL PARA PODER
                        OBTENER LA FECHA LIMITE DE PAGO **/

                    $fecha_cuota_explode=explode('-', $InscripcionClase->fecha_pago);
                    $fecha_cuota = Carbon::create($fecha_cuota_explode[0], $fecha_cuota_explode[1], $fecha_cuota_explode[2],0);

                    /** AQUI CALCULAMOS LA FECHA FECHA LIMITE DE PAGO **/
                    $tolerancia = $fecha_cuota->addDay($configClases->tiempo_tolerancia)->toDateString();
                    
                        //CONDICION PARA EL TIEMPO DE TOLERANCIA, SI SE CUMPLE
                        //CALCULARA SEGUN EL PORCENTAJE CONFIGURADO Y SE LE SUMARA
                        //AL MONTO DE LA CUOTA
                    $clasegrupal = InscripcionClaseGrupal::find($InscripcionClase->InscripcionID);

                        
                    if($FacturaProforma != 0 && Carbon::now()->addDay() > $tolerancia && $clasegrupal->tiene_mora == 0 && $configClases->porcentaje_retraso){

                        $mora = ($configClases->costo_mensualidad * $configClases->porcentaje_retraso)/100;

                        if($mora > 0)
                        {
                            $item_factura = new ItemsFacturaProforma;
                                                        
                            $item_factura->usuario_id = $InscripcionClase->AlumnoId;
                            $item_factura->usuario_tipo = 1;
                            $item_factura->academia_id = Auth::user()->academia_id;
                            $item_factura->fecha = Carbon::now()->toDateString();
                                                            //$item_factura->item_id = $id;
                            $item_factura->nombre = 'Mora por retraso de pago Cuota ' .  $configClases->nombre;
                            $item_factura->tipo = 4;
                            $item_factura->cantidad = 1;
                            $item_factura->importe_neto = $mora;
                            $item_factura->fecha_vencimiento = Carbon::now()->toDateString();

                            $item_factura->save();

                            $clasegrupal->tiene_mora = 1;
                            $clasegrupal->save();
                        }

                    }
                }
            }
        }

        $acuerdos = Acuerdo::where('academia_id', Auth::user()->academia_id)->get();

        foreach($acuerdos as $acuerdo){

            $proformas = ItemsFacturaProforma::where('tipo',6)->where('item_id', $acuerdo->id)->get();

            foreach($proformas as $proforma){
                $fecha = Carbon::createFromFormat('Y-m-d', $proforma->fecha_vencimiento);

                $fecha->addDays($acuerdo->tiempo_tolerancia);

                if(Carbon::now()->addDay() > $fecha && $proforma->tiene_mora == 0 && $acuerdo->porcentaje_retraso){

                    $mora = ($proforma->importe_neto * $acuerdo->porcentaje_retraso)/100;

                    $item_factura = new ItemsFacturaProforma;
                                                
                    $item_factura->usuario_id = $acuerdo->usuario_id;
                    $item_factura->usuario_id = $acuerdo->usuario_tipo;
                    $item_factura->academia_id = Auth::user()->academia_id;
                    $item_factura->fecha = Carbon::now()->toDateString();
                    $item_factura->nombre = 'Mora por retraso de pago ' .  $proforma->nombre;
                    $item_factura->tipo = 6;
                    $item_factura->cantidad = 1;

                    $item_factura->importe_neto = $mora;
                    $item_factura->fecha_vencimiento = Carbon::now()->toDateString();

                    $item_factura->save();

                    $proforma->tiene_mora = 1;

                    $proforma->save();

                }

            }
            
        }
        return $this->index();
    }

    public function inactividad(){

        $datos = $this->getDatosUsuario();

        $id = $datos[0]['usuario_id'];

        //ARRAY DE BUSQUEDA EN ASISTENCIAS

        $tipo_clase = array(1,2);

        $alumno = Alumno::find($id);

        if($alumno){

            $inasistencias = 0;
            $status = true;

            $clase_grupal = InscripcionClaseGrupal::join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('clases_grupales.fecha_inicio', 'clases_grupales.fecha_final', 'config_clases_grupales.asistencia_rojo', 'config_clases_grupales.asistencia_amarilla', 'inscripcion_clase_grupal.fecha_inscripcion', 'inscripcion_clase_grupal.fecha_a_comprobar', 'clases_grupales.id')
                ->where('inscripcion_clase_grupal.alumno_id', $alumno->id)
                ->where('inscripcion_clase_grupal.boolean_congelacion', 0)
                ->where('clases_grupales.deleted_at', null)
                ->orderBy('inscripcion_clase_grupal.fecha_inscripcion', 'desc')
            ->first();

            if($clase_grupal){

                $fecha_inicio = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);

                if(Carbon::now() > $fecha_inicio){

                    $fecha_final = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_final);

                    //COMPROBAR HASTA QUE DIA SE HARA EL CICLO, SI LA CLASE AUN NO HA FINALIZADO, SE HARA HASTA EL DIA DE HOY

                    if(Carbon::now() <= $fecha_final){
                        $fecha_de_finalizacion = Carbon::now();
                    }else{
                        $fecha_de_finalizacion = $fecha_final;
                    }

                    $dia_inicio_clase = $fecha_inicio->dayOfWeek;

                    if($dia_inicio_clase == 0){
                        $dia_inicio_clase = 7;
                    }

                    //CONFIGURACIONES DE ASISTENCIAS

                    $asistencia_amarilla = $clase_grupal->asistencia_amarilla;
                    $asistencia_roja = $clase_grupal->asistencia_rojo;

                    //CREAR ARREGLO DE CLASES GRUPALES A CONSULTAR EN LA ASISTENCIA

                    $horarios_clases_grupales = HorarioClaseGrupal::where('clase_grupal_id', $clase_grupal->id)
                        ->orderBy('fecha')
                    ->get();

                    //ARRAYS CREADO CON EL FIN DE ESTABLECER LOS SALTOS DE DIAS ENTRE CADA CLASE Y SUS MULTIHORARIOS QUE TENDRA LA CONSULTA DE ASISTENCIA, EL ORGANIZADOR ESTABLECE EN LA PRIMERA POSICIÓN EL PRIMER MULTIHORARIO QUE TENGA, Y DE ULTIMO LA CLASE PRINCIPAL PARA PODER REALIZAR EL CICLO CORRECTAMENTE, EL ARRAY DE DIAS SIMPLEMENTE SE USARA PARA LAS CONSULTAS

                    $array_organizador = array();
                    $array_organizador_before = array();
                    $array_organizador_after = array();
                    $array_dias = array();

                    //ARRAY DE BUSQUEDA EN ASISTENCIAS

                    $tipo_id = array();
                    $tipo_id[] = intval($clase_grupal->id);

                    // 1.1 -- ARRAY CREADO PARA ESTABLECER EL INDEX CON EL QUE SE COMENZARA A REALIZAR LA BUSQUEDA POR SI LA ULTIMA ASISTENCIA FUE REALIZADA EN UN MULTIHORARIO, ESTO CON LA FINALIDAD DE SABER QUE INDEX CORRESPONDE DESPUES EN LA CONSULTA

                    $array_dias_clases = array();
                    $array_dias_clases_before = array();
                    $array_dias_clases_after = array();

                    //ESTABLECE EL DIA PRINCIPAL COMO PRIMER INDEX DEL ARRAY DE DIAS

                    $array_dias_clases[] = $dia_inicio_clase;

                    //SE CREA EL ARRAY ORGANIZADOR Y EL ARRAY DE DIAS

                    foreach($horarios_clases_grupales as $horario){

                        $tipo_id[] = $horario->id;
                        $fecha_horario = Carbon::createFromFormat('Y-m-d', $horario->fecha);
                        $dia_horario = $fecha_horario->dayOfWeek;

                        if($dia_horario == 0){
                            $dia_horario = 7;
                        }

                        if($dia_inicio_clase >= $dia_horario){
                            $array_dias_clases_before[] = $dia_horario;
                            $array_organizador_before[] = $dia_horario;
                        }else{
                            $array_dias_clases_after[] = $dia_horario;
                            $array_organizador_after[] = $dia_horario;
                        }

                    }

                    //SE ORDENA EL ARREGLO DE DIAS ANTERIORES A LA CLASE PRINCIPAL

                    usort($array_dias_clases_before, function($a, $b) {
                        return $a - $b;
                    });

                    usort($array_organizador_before, function($a, $b) {
                        return $a - $b;
                    });

                    //ESTE PROCESO SE HACE PARA QUE LA CLASE PRINCIPAL SEA LA PRIMERA EN CONSULTAR, LUEGO SERAN LAS CLASES POSTERIORES A ELLA Y POR ULTIMO LAS CLASES ANTERIORES, PARA QUE EL CICLO AGREGUE UNA SEMANA ANTES DE CONSULTAR LAS CLASES ANTERIORES

                    $merge = array_merge($array_dias_clases, $array_dias_clases_after);
                    $array_dias_clases = array_merge($merge, $array_dias_clases_before);
                    $array_organizador = array_merge($array_organizador_after, $array_dias_clases_before);

                    //SE ESTABLECE QUE SI NO HAY MULTIHORARIO, EL ARRAY DE DIA SOLO TENDRA UNA POSICIÓN DE 7, PARA QUE LAS CONSULTAS SE HAGAN SEMANALMENTE

                    //SI SOLO TIENE UN MULTIHORARIO, LA PRIMERA POSICIÓN SERA LA CANTIDAD DE DIAS QUE LE FALTA A LA CLASE PRINCIPAL PARA LLEGAR AL DIA DEL MULTIHORARIO, LA ULTIMA SERA LA CANTIDAD DE DIAS PARA LLEGAR DE NUEVO A LA CLASE PRINCIPAL, TENDRA SOLO 2 POSICIONES

                    // SI TIENE MAS DE UN MULTIHORARIO, ESTABLECERA UN CICLO PARA VER CUANTOS DIAS HAY ENTRE CADA MULTIHORARIO, DEJANDO POR ULTIMO LA CLASE PRINCIPAL PARA REPETIR EL CICLO

                    //LA CONSULTA DE LOS MULTIHORARIOS LOS ORDENARA POR FECHA PARA ASI SOLO TENER QUE ESTABLECER LA CANTIDAD DE DIAS ENTRE ELLOS

                    if($array_organizador){

                        $dias_a_sumar = 0;
                        
                        if(count($array_organizador) == 1){

                            $dia_inicio_horario = $array_organizador[0];

                            if($dia_inicio_clase  > $dia_inicio_horario){

                                while ($dia_inicio_clase != 7){
                                    $dias_a_sumar++;
                                    $dia_inicio_clase++;
                                }

                                $array_dias[] = $dias_a_sumar + $dia_inicio_horario;
                                $dia_inicio_clase = $fecha_inicio->dayOfWeek;
                                $dias = abs(intval($dia_inicio_horario) - intval($dia_inicio_clase));
                                $array_dias[] = $dias;

                            }else{

                                $dias = abs(intval($dia_inicio_clase) - intval($dia_inicio_horario));
                                $array_dias[] = $dias;

                                while ($dia_inicio_horario != 7){
                                    $dias_a_sumar++;
                                    $dia_inicio_horario++;
                                }

                                $array_dias[] = $dias_a_sumar + $dia_inicio_clase;
                            }
                        }else{

                            $dias_a_restar = $dia_inicio_clase;

                            foreach($array_organizador as $index => $organizador){

                                //SE MIDE LA CANTIDAD DE DIAS ENTRE LA CLASE PRINCIPAL Y EL PRIMER MULTIHORARIO, Y LUEGO ENTRE CADA UNO DE LOS MULTIHORARIOS

                                if($dias_a_restar < $organizador){
                                    $dias_a_añadir = abs($organizador - $dias_a_restar);
                                }else{
                                    $dias_a_añadir = abs(($organizador + 7) - $dias_a_restar);
                                }

                                $array_dias[] = $dias_a_añadir;
                                $dias_a_restar = $organizador;

                            }

                            if($dias_a_restar > $dia_inicio_clase){
                                $dias_a_sumar = 0;

                                while ($dias_a_restar != 7){
                                    $dias_a_sumar++;
                                    $dias_a_restar++;

                                }

                                $dias_a_sumar = $dias_a_sumar + $dia_inicio_clase;
                            }else{
                                $dias_a_sumar = abs($dias_a_restar - $dia_inicio_clase);
                            }

                            $array_dias[] = $dias_a_sumar;
                        }
                    }else{
                        $array_dias[] = 7;
                    }

                    //CONSULTAR LA ULTIMA ASISTENCIA, EL TIPO ES 1 (CLASE PRINCIPAL) Y 2 (MULTIHORARIO), EL TIPO_ID ES UN ARRAY CON EL ID DE LA CLASE PRINCIPAL Y LOS MULTIHORARIOS QUE POSEA
     
                    $ultima_asistencia = Asistencia::whereIn('tipo',$tipo_clase)
                        ->whereIn('tipo_id',$tipo_id)
                        ->where('alumno_id', $alumno->id)
                        ->orderBy('created_at', 'desc')
                    ->first();

                    //SI POSEE UNA ASISTENCIA, EL COMPARARA DESDE ESE DIA, SINO, ESTE TOMARA EL DIA EN QUE EL ALUMNO SE INSCRIBIO

                    //NOTA IMPORTANTE: PARA NO ROMPER EL CICLO CON LA FECHA DE LA INSCRIPCION, EL PROCESO CONVERTIRA ESTA FECHA A UNA QUE CONCUERDE CON LA CLASE PRINCIPAL O ALGUN MULTIHORARIO, SINO LAS CONSULTAS NUNCA FUNCIONARAN

                    if($ultima_asistencia){
                        $fecha_asistencia_inicio = Carbon::createFromFormat('Y-m-d', $ultima_asistencia->fecha);
                        $j = 0;
                    }else{
                        $fecha_asistencia_inicio = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);     
                        $j = 1;               
                    }

                    $fecha_inscripcion = Carbon::createFromFormat('Y-m-d',$clase_grupal->fecha_inscripcion);
                    $fecha_traspaso_admin = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_a_comprobar);

                    if($fecha_asistencia_inicio > $fecha_inscripcion){
                        $fecha_a_comparar = $fecha_asistencia_inicio;
                    }else{
                        $fecha_a_comparar = $fecha_inscripcion;
                        $j = 1;
                    }

                    if($fecha_traspaso_admin > $fecha_a_comparar){
                        $fecha_a_comparar = $fecha_traspaso_admin;
                        $j = 1;
                    }

                    $dia_a_comparar = $fecha_a_comparar->dayOfWeek;

                    while(!in_array($dia_a_comparar,$array_dias_clases)){

                        $fecha_a_comparar->addDay();
                        $dia_a_comparar = $fecha_a_comparar->dayOfWeek;

                        if($dia_a_comparar != 0){
                            $dia_a_comparar = $fecha_a_comparar->dayOfWeek;
                        }else{
                            $dia_a_comparar = 7;
                        }
                    }

                    //EL INDEX INICIAL SE CREA PARA SABER DESDE DONDE SE COMENZARA A BUSCAR EN EL CICLO FOR DE ABAJO, YA DESCRITO EN LA NOTA 1.1

                    $index_inicial = array_search($dia_a_comparar, $array_dias_clases);

                    //EL CICLO WHILE SE ENCARGA DE ESTABLECER LA CANTIDAD DE INASISTENCIAS QUE POSEE LA PERSONA, ESTE AÑADERA LOS DIAS CORRESPONDIENTES DEL ARRAY DE DIAS CREADO ANTERIORMENTE

                    //1.2 -- EL $J != 0 ESTA ESTABLECIDO PARA QUE SI LA PERSONA POSEE ASISTENCIAS, ESTE NO CONTABILICE LAS INASISTENCIAS DESDE LA PRIMERA FECHA, SINO QUE REALICE UN SALTO AL SIGUIENTE INDEX

                    // if($index_inicial > count($array_dias)){
                    //     $index_inicial = 0;
                    // }

                    // $cantidad_inasistencias = count($array_dias);

                    while($fecha_a_comparar < $fecha_de_finalizacion){
                        if($fecha_a_comparar < Carbon::now()->subDay()){
                            for($i = $index_inicial; $i < count($array_dias); $i++){

                                // $array_fecha_a_comparar[] = $fecha_a_comparar->toDateString();
                                // $array_dias_tmp[] = $array_dias[$i];

                                $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', $fecha_a_comparar)
                                    ->where('fecha_final', '>=', $fecha_a_comparar)
                                    ->where('tipo_id', $clase_grupal->id)
                                    ->where('tipo', 1)
                                ->first();

                                if(!$horario_bloqueado){
                                    if($j != 0){
                                        $inasistencias++;
                                    }
                                }

                                $fecha_a_comparar->addDays($array_dias[$i]);

                                //PARA QUE LAS INASISTENCIAS SE EMPIECEN A CONTABILIZAR 

                                $j++;
                            }
                        }else{
                            break;
                        }

                        //EL INDEX VUELVE A 0 PARA PODER REALIZAR EL CICLO FOR DESDE EL PRINCIPIO HASTA QUE LA FECHA A COMPARAR SEA MAYOR A LA FECHA DE FINALIZACIÓN

                        $index_inicial = 0;
                    }
                    
                    // LA CONFIGURACIÓN DE LAS ASISTENCIAS DEBEN ESTAR ESTABLECIDAS PARA QUE LAS CONTABILIZACIONES SE HAGAN (!= 0)
     
                    if($inasistencias >= $asistencia_roja && $asistencia_roja != 0){
                        $status = false;
                    }
                }
            }

            if($status){
                Session::put('fecha_comprobacion',Carbon::now()->toDateString());
                return $this->index();
            }else{
                return view('inicio.cuenta-deshabilitada');
            }
        }else{
            return view('inicio.cuenta-deshabilitada');
        }
    }

    public function listo()
    {       
        return view('flujo_registro.listo');                    
    }

    public function confirmarVencimiento($id)
    {
        $vencimiento = VencimientoClaseGrupal::find($id);

        if($vencimiento->delete()){
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }
    }
}