<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Alumno;
use App\Instructor;
use App\InscripcionTaller;
use App\InscripcionClaseGrupal;
use App\InscripcionCoreografia;
use App\InscripcionClasePersonalizada;
use App\ClaseGrupal;
use App\HorarioClaseGrupal;
use App\ClasePersonalizada;
use App\ItemsFacturaProforma;
use App\Academia;
use App\Familia;
use App\User;
use App\UsuarioTipo;
use App\PerfilEvaluativo;
use Mail;
use DB;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Visitante;
use App\Paises;
use App\AlumnoRemuneracion;
use App\Evaluacion;
use App\DetalleEvaluacion;
use App\Factura;
use App\ItemsFactura;
use App\Pago;
use App\Acuerdo;
use App\ItemsAcuerdo;
use App\ItemsPresupuesto;
use App\Presupuesto;
use App\Asistencia;
use App\Cita;
use App\Notificacion;
use App\NotificacionUsuario;
use App\Incidencia;
use App\Sugerencia;
use App\Staff;
use App\CredencialAlumno;
use App\Llamada;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Image;


class AlumnoController extends BaseController
{


    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    
    public function principal()
	{

        $in = array(2,4);
        
        $alumnoc = User::join('alumnos', 'alumnos.id', '=', 'users.usuario_id')
            ->join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
            ->select('alumnos.id as id')
            ->where('users.academia_id','=', Auth::user()->academia_id)
            ->where('alumnos.deleted_at', '=', null)
            ->whereIn('usuarios_tipo.tipo', $in)
            ->where('users.confirmation_token', '!=', null)
        ->get();

        $alumnos = Alumno::withTrashed()->where('academia_id', '=' ,  Auth::user()->academia_id)->where('tipo', 1)->orderBy('nombre', 'asc')->get();

        $array = array();

        foreach($alumnos as $alumno){

            $deuda = ItemsFacturaProforma::where('fecha_vencimiento','<=',Carbon::today())
                ->where('usuario_id','=',$alumno->id)
                ->where('usuario_tipo','=',1)
            ->sum('importe_neto');

            $activacion = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->where('usuarios_tipo.tipo_id', $alumno->id)
                ->whereIn('usuarios_tipo.tipo', $in)
                ->where('users.confirmation_token', '!=', null)
            ->first();

            $edad = Carbon::createFromFormat('Y-m-d', $alumno->fecha_nacimiento)->diff(Carbon::now())->format('%y');
            $collection=collect($alumno);     
            $alumno_array = $collection->toArray();

            $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->where('usuarios_tipo.tipo_id',$alumno->id)
                ->whereIn('usuarios_tipo.tipo',$in)
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

            if($activacion){
                $activacion = 1;
            }else{
                $activacion = 0;
            }
            
            $alumno_array['activacion']=$activacion;
            $alumno_array['deuda']=$deuda;
            $alumno_array['imagen']=$imagen;
            $alumno_array['edad']=$edad;
            $array[$alumno->id] = $alumno_array;

        }

        $instructor = Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

		return view('participante.alumno.principal')->with(['alumnos' => $array, 'instructor' => $instructor]);
	}


    public function eliminados()
    {
        $alumnod = DB::table('alumnos')
            ->join('items_factura_proforma', 'items_factura_proforma.usuario_id', '=', 'alumnos.id')
            ->select('alumnos.id as id', 'items_factura_proforma.importe_neto', 'items_factura_proforma.fecha_vencimiento')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
            ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
            ->where('deleted_at', '!=' ,  NULL)
        ->get();

        $collection=collect($alumnod);
        $grouped = $collection->groupBy('id');     
        $deuda = $grouped->toArray();

        $alumno = Alumno::onlyTrashed()
            ->where('academia_id', Auth::user()->academia_id)
            ->whereNotNull('deleted_at')
        ->get();


        return view('participante.alumno.eliminados')->with(['alumnos' => $alumno, 'deuda' => $deuda]);
    }

    public function inactivos()
    {
        $alumnod = DB::table('alumnos')
            ->join('items_factura_proforma', 'items_factura_proforma.usuario_id', '=', 'alumnos.id')
            ->select('alumnos.id as id', 'items_factura_proforma.importe_neto', 'items_factura_proforma.fecha_vencimiento')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
            ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
            ->where('deleted_at', '!=' ,  NULL)
        ->get();

        $collection=collect($alumnod);
        $grouped = $collection->groupBy('id');
        $deuda = $grouped->toArray();


        $alumno = InscripcionClaseGrupal::onlyTrashed()
            ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.*', 'config_clases_grupales.nombre as clase_grupal_nombre', 'inscripcion_clase_grupal.id as inscripcion_id','inscripcion_clase_grupal.deleted_at')
            ->where('alumnos.academia_id', Auth::user()->academia_id)
            ->whereNotNull('inscripcion_clase_grupal.deleted_at')
        ->get();


        return view('participante.alumno.inactivos')->with(['alumnos' => $alumno, 'deuda' => $deuda]);
    }

    public function congelados()
    {
        $alumnod = DB::table('alumnos')
            ->join('items_factura_proforma', 'items_factura_proforma.usuario_id', '=', 'alumnos.id')
            ->select('alumnos.id as id', 'items_factura_proforma.importe_neto', 'items_factura_proforma.fecha_vencimiento')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
            ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
            ->where('deleted_at', '!=' ,  NULL)
        ->get();

        $collection=collect($alumnod);
        $grouped = $collection->groupBy('id');     
        $deuda = $grouped->toArray();
        $alumno = InscripcionClaseGrupal::withTrashed()
            ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.*', 'config_clases_grupales.nombre as clase_grupal_nombre', 'inscripcion_clase_grupal.id as inscripcion_id', 'inscripcion_clase_grupal.fecha_inicio', 'inscripcion_clase_grupal.id as inscripcion_id', 'inscripcion_clase_grupal.fecha_final', 'inscripcion_clase_grupal.razon_congelacion')
            ->where('alumnos.academia_id', Auth::user()->academia_id)
            ->where('inscripcion_clase_grupal.boolean_congelacion',1)
        ->get();


        return view('participante.alumno.congelados')->with(['alumnos' => $alumno, 'deuda' => $deuda]);
    }

	public function store(Request $request)
	{
        
		$request->merge(array('correo' => trim($request->correo)));

    $rules = [
        'identificacion' => 'required|min:7|numeric',
        'nombre' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'apellido' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'fecha_nacimiento' => 'required',
        'sexo' => 'required',
        'correo' => 'email|max:255',
    ];

    $messages = [
        'identificacion.required' => 'Ups! El identificador es requerido',
        'identificacion.min' => 'El mínimo de numeros permitidos son 5',
        'identificacion.max' => 'El maximo de numeros permitidos son 20',
        'identificacion.numeric' => 'Ups! El identificador es inválido , debe contener sólo números',
        'identificacion.unique' => 'Ups! Ya este usuario ha sido registrado',
        'nombre.required' => 'Ups! El Nombre  es requerido ',
        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre.max' => 'El máximo de caracteres permitidos son 20',
        'nombre.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
        'apellido.required' => 'Ups! El Apellido  es requerido ',
        'apellido.min' => 'El mínimo de caracteres permitidos son 3',
        'apellido.max' => 'El máximo de caracteres permitidos son 20',
        'apellido.regex' => 'Ups! El apellido es inválido , debe ingresar sólo letras',
        'sexo.required' => 'Ups! El Sexo  es requerido ',
        'fecha_nacimiento.required' => 'Ups! La fecha de nacimiento es requerida',
        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'correo.max' => 'El máximo de caracteres permitidos son 255',
        // 'correo.unique' => 'Ups! Ya este correo ha sido registrado',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        // return redirect("/home")

        // ->withErrors($validator)
        // ->withInput();

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }

    else{

        $edad = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->diff(Carbon::now())->format('%y');


        if($edad < 1){
            return response()->json(['errores' => ['fecha_nacimiento' => [0, 'Ups! Esta fecha es invalida, debes ingresar una fecha superior a 1 año de edad']], 'status' => 'ERROR'],422);
        }

        $nombre = title_case($request->nombre);
        $apellido = title_case($request->apellido);
        $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->toDateString();

        if($request->correo){
            $correo = trim(strtolower($request->correo)); 
            $usuario = User::where('email',$correo)->first();

            if($usuario){
                $tipos_usuario = UsuarioTipo::where('usuario_id',$usuario->id);
                foreach($tipos_usuario as $tipo){

                    if($tipo == 2){

                        return response()->json(['errores' => ['correo' => [0, 'Ups! Ups! Ya este correo ha sido registrado']], 'status' => 'ERROR'],422);
                    }
                }
            }
        }else{
            $correo = '';
        }
       
        if($request->telefono)
        {
            $telefono = $request->telefono;
        }else{
            $telefono = '';
        }

        if($request->direccion)
        {
            $direccion = $request->direccion;

        }else{
            $direccion = '';
        }

        // if($request->instructor_id){
        //     $instructor_id = $request->instructor_id;
        // }else{
        //     $instructor_id = null;
        // }

        do{
            $codigo_referido = str_random(8);
            $find = Alumno::where('codigo_referido', $codigo_referido)->first();
        }while ($find);

        $alumno = new Alumno;

        $alumno->academia_id = Auth::user()->academia_id;
        $alumno->identificacion = $request->identificacion;
        $alumno->nombre = $nombre;
        $alumno->apellido = $apellido;
        $alumno->sexo = $request->sexo;
        $alumno->fecha_nacimiento = $fecha_nacimiento;
        $alumno->correo = $correo;
        $alumno->telefono = $telefono;
        $alumno->celular = $request->celular;
        $alumno->direccion = $direccion;
        $alumno->alergia = $request->alergia;
        $alumno->asma = $request->asma;
        $alumno->convulsiones = $request->convulsiones;
        $alumno->cefalea = $request->cefalea;
        $alumno->hipertension = $request->hipertension;
        $alumno->lesiones = $request->lesiones;
        $alumno->codigo_referido = $codigo_referido;

        if($alumno->save()){

            if($request->visitante_id){
                
                $visitante = Visitante::find($request->visitante_id);
                $visitante->alumno_id = $alumno->id;

                $visitante->save();
            }

            if($request->codigo){
                $referido=DB::table('alumnos')
                    ->select('alumnos.*')
                    ->where('alumnos.codigo_referido','=',$request->codigo)
                    ->where('alumnos.academia_id','=',Auth::user()->academia_id)
                ->first();
                if($referido){

                    $alumno->referido_id = $referido->id;
                    $alumno->save();

                    $remuneracion = new AlumnoRemuneracion;
                    $academia=Academia::where('id', Auth::user()->academia_id)->first();

                    $remuneracion->alumno_id = $alumno->id;
                    $remuneracion->remuneracion = $academia->puntos_referidos;
                    $remuneracion->save();
                    
                    $remuneracion_codigo=AlumnoRemuneracion::where('alumno_id', $referido->id)->first();

                    if($remuneracion_codigo){
                        $suma = $remuneracion_codigo->remuneracion;
                        $suma += $academia->puntos_referencia;
                        $remuneracion_codigo->remuneracion = $suma;
                        $remuneracion_codigo->save();
                    }else{
                        $remuneracion = new AlumnoRemuneracion;
                        // do{
                        //     $codigo_validacion = str_random(8);
                        //     $find = Alumno::where('codigo_referido', $codigo_validacion)->first();
                        // }while ($find);
                        $remuneracion->alumno_id = $referido->id;
                        $remuneracion->remuneracion = $academia->puntos_referencia;
                        $remuneracion->save();
                    }
                }else{
                    return response()->json(['errores' => ['codigo' => [0, 'Ups! Este código no pertenece a ningun estudiante']], 'status' => 'ERROR'],422);
                }
            }

            if($correo){

                if(!$usuario){

                    $password = str_random(8);
                    
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
                    $usuario->confirmation_token = str_random(40);
                    $usuario->password = bcrypt($password);
                    $usuario->usuario_id = $alumno->id;
                    $usuario->usuario_tipo = 2; 

                    $usuario->save();

                    $usuario_tipo = new UsuarioTipo;
                    $usuario_tipo->usuario_id = $usuario->id;
                    $usuario_tipo->tipo = 2;
                    $usuario_tipo->tipo_id = $alumno->id;
                    $usuario_tipo->save();

                }

               

            }
            
            // if($request->correo){

            //     $academia = Academia::find(Auth::user()->academia_id);
            //     $subj = $alumno->nombre . ' , ' . $academia->nombre . ' te ha agregado a Easy Dance, por favor confirma tu correo electronico';
            //     $link = route('confirmacion', ['token' => $usuario->confirmation_token]);

            //     $array = [
            //        'nombre' => $request->nombre,
            //        'academia' => $academia->nombre,
            //        'usuario' => $request->correo,
            //        'contrasena' => $password,
            //        'subj' => $subj,
            //        'link' => $link
            //     ];


            //     Mail::send('correo.inscripcion', $array, function($msj) use ($array){
            //             $msj->subject($array['subj']);
            //             $msj->to($array['usuario']);
            //         });
            // }

            //Envio de Sms

            if($request->celular)
            {

                $celular = getLimpiarNumero($request->celular);
                $academia = Academia::find(Auth::user()->academia_id);
                if($academia->pais_id == 11 && strlen($celular) == 10){

                    $mensaje = $request->nombre.'. Subiste a bordo a la tripulacion de "Tu Clase de Baile", gracias por unirte a nosotros. ¡Nos encanta verte bailar!.';

                    $client = new Client(); //GuzzleHttp\Client
                    $result = $client->get('https://sistemasmasivos.com/c3colombia/api/sendsms/send.php?user=coliseodelasalsa@gmail.com&password=k1-9L6A1rn&GSM='.$celular.'&SMSText='.urlencode($mensaje));

                }

                // $array_prefix = array('424', '414', '426', '416', '412');
                // $prefix = substr($request->celular, 1, 3);

                // if (in_array($prefix, $array_prefix)) {
          
                //     $data = collect([
                //         'nombre' => $request->nombre,
                //         'apellido' => $request->apellido,
                //         'celular' => $request->celular
                //     ]);
                    
                    
                    // $sms = $this->sendAlumno($data, $msg);

                // }
            }

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'id'=>$alumno->id, 'alumno' => $alumno, 200]);
            
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
        }
        // return redirect("/home");
        //return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
    }

    }

    public function create()
    {
 
        return view('participante.alumno.create')->with(['instructores' => Staff::where('cargo',1)->where('academia_id', Auth::user()->academia_id)->get()]);
    }

    public function agregarvisitante($id)
    {

        $visitante = Visitante::find($id);
 
        return view('participante.alumno.create')->with(['visitante' => $visitante, 'instructores' => Staff::where('cargo',1)->where('academia_id', Auth::user()->academia_id)->get()]);
    }

    public function edit($id)
    {   

        Session::forget('puntos_referidos');

        $alumno = Alumno::Leftjoin('staff', 'alumnos.instructor_id', '=', 'staff.id')
            ->select('alumnos.*','staff.nombre as instructor_nombre','staff.apellido as instructor_apellido')
            ->where('alumnos.id',$id)
        ->first();

        if($alumno){

            $clases_grupales = InscripcionClaseGrupal::join('alumnos', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
                ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('config_clases_grupales.nombre as nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final', 'clases_grupales.id', 'inscripcion_clase_grupal.fecha_pago', 'inscripcion_clase_grupal.costo_mensualidad', 'inscripcion_clase_grupal.id as inscripcion_id', 'inscripcion_clase_grupal.fecha_pago', 'inscripcion_clase_grupal.boolean_programacion', 'inscripcion_clase_grupal.boolean_franela', 'inscripcion_clase_grupal.razon_entrega',  'inscripcion_clase_grupal.talla_franela')
                ->where('inscripcion_clase_grupal.alumno_id', $id)
                ->where('clases_grupales.deleted_at', null)
            ->get();

            $array_descripcion = array();

            foreach($clases_grupales as $clase){

                array_push($array_descripcion, $clase->nombre);
               
            }

            $descripcion = implode(", ", $array_descripcion);

            $total =ItemsFacturaProforma::where('usuario_id', '=', $id)
                ->where('usuario_tipo','=',1)
                ->where('fecha_vencimiento','<=',Carbon::today())
            ->sum('importe_neto');

            $puntos_referidos = AlumnoRemuneracion::where('alumno_id',$id)->sum('remuneracion');
            $edad = Carbon::createFromFormat('Y-m-d', $alumno->fecha_nacimiento)->diff(Carbon::now())->format('%y');
            $credenciales = CredencialAlumno::where('alumno_id',$id)->sum('cantidad');

            $perfil = PerfilEvaluativo::join('alumnos', 'perfil_evaluativo.usuario_id', '=', 'alumnos.id')
                ->select('perfil_evaluativo.*', 'alumnos.id as alumno_id')
                ->where('alumnos.id', $id)
            ->first();

            if($perfil){
                $tiene_perfil = 1;
            }else{
                $tiene_perfil = 0;
            }

            $in = array(2,4);

            $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->where('usuarios_tipo.tipo_id',$id)
                ->whereIn('usuarios_tipo.tipo',$in)
            ->first();

            if($usuario){
                $imagen = $usuario->imagen;
            }else{
                $imagen = '';
            }

            $inscripcion_clase_grupal = InscripcionClaseGrupal::where('alumno_id',$id)->first();

            if($inscripcion_clase_grupal){
                if($inscripcion_clase_grupal->tipo_pago == 1){
                    $tipo_pago = 'Contado';
                }else{
                    $tipo_pago = 'Credito';
                }

            }else{
                $tipo_pago = 'Contado';
            }

            return view('participante.alumno.planilla')->with(['alumno' => $alumno , 'id' => $id, 'total' => $total, 'clases_grupales' => $clases_grupales, 'descripcion' => $descripcion, 'perfil' => $tiene_perfil, 'imagen' => $imagen, 'puntos_referidos' => $puntos_referidos, 'instructores' => Staff::where('cargo',1)->where('academia_id', Auth::user()->academia_id)->get(), 'edad' => $edad, 'tipo_pago' => $tipo_pago, 'credenciales' => $credenciales, 'usuario' => $usuario]);
        }else{
           return redirect("participante/alumno"); 
        }
    }

    public function puntos_acumulados($id)
    {   

        $alumno = Alumno::find($id);


        if($alumno){

            $puntos_referidos = 0;

            $alumno_remuneracion = AlumnoRemuneracion::where('alumno_id',$id)->where('remuneracion' ,">", 0)->get();

            foreach($alumno_remuneracion as $remuneracion){
                $puntos_referidos = $puntos_referidos + $remuneracion->remuneracion;
            }

            return view('participante.alumno.puntos_acumulados')->with(['alumno' => $alumno , 'id' => $id, 'puntos_referidos' => $puntos_referidos, 'alumno_remuneracion' => $alumno_remuneracion]);
        }else{
           return redirect("participante/alumno"); 
        }
    }

     public function credenciales($id)
    {   

        $alumno = Alumno::find($id);

        if($alumno){

            $total = 0;

            $credenciales = CredencialAlumno::leftJoin('instructores', 'credenciales_alumno.instructor_id', '=', 'instructores.id')
                ->select('credenciales_alumno.*', 'instructores.nombre', 'instructores.apellido')
                ->where('credenciales_alumno.alumno_id',$id)
                ->where('credenciales_alumno.cantidad' ,">", 0)
            ->get();

            $asistencias = Asistencia::join('alumnos', 'asistencias.alumno_id', '=', 'alumnos.id')
                ->join('clases_grupales', 'asistencias.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('asistencias.fecha', 'asistencias.hora', 'config_clases_grupales.nombre as clase', 'alumnos.nombre', 'alumnos.apellido', 'asistencias.tipo', 'asistencias.tipo_id', 'asistencias.clase_grupal_id as clase_grupal_id', 'asistencias.id', 'alumnos.id as alumno_id')
                ->where('alumnos.academia_id','=',Auth::user()->academia_id)
                ->where('asistencias.alumno_id',$id)
                ->orderBy('asistencias.created_at','desc')
            ->get();

            $array = array();

            foreach($asistencias as $asistencia){

              if($asistencia->tipo == 1)
              {
                $clasegrupal = ClaseGrupal::find($asistencia->clase_grupal_id);
                if($clasegrupal){
                  $instructor = Instructor::find($clasegrupal->instructor_id);
                }
                
              }else{
                $clasegrupal = HorarioClaseGrupal::find($asistencia->tipo_id);
                if($clasegrupal){
                  $instructor = Instructor::find($clasegrupal->instructor_id);
                }
              }

              $fecha = Carbon::createFromFormat('Y-m-d', $asistencia->fecha);
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

              if($clasegrupal)
              {
                $collection=collect($asistencia);     
                $asistencia_array = $collection->toArray();
                
                $asistencia_array['dia']=$dia;
                $asistencia_array['instructor']=$instructor->nombre . ' ' . $instructor->apellido;
                $asistencia_array['hora']=$asistencia->hora;
                $array[] = $asistencia_array;
              }
            }

            foreach($credenciales as $credencial){
                $total = $total + $credencial->cantidad;
            }

            return view('participante.alumno.credenciales')->with(['alumno' => $alumno , 'id' => $id, 'credenciales' => $credenciales, 'total' => $total, 'asistencias' => $array]);
        }else{
            return redirect("participante/alumno"); 
        }
    }

    public function operar($id)
    {   
        $item_factura = DB::table('items_factura_proforma')
            ->select('items_factura_proforma.*')
            ->where('items_factura_proforma.usuario_id', '=', $id)
            ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
        ->get();

        $total = 0;

        foreach($item_factura as $items_factura){

                $total = $total + $items_factura->importe_neto;
                
        }
        $in = array(2,4);

        $alumno = Alumno::find($id);
        $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
            ->where('usuarios_tipo.tipo_id',$alumno->id)
            ->whereIn('usuarios_tipo.tipo',$in)
        ->first();
        return view('participante.alumno.operacion')->with(['id' => $id, 'alumno' => $alumno, 'total' => $total, 'usuario' => $usuario]);        
    }

    public function deuda($id)
    {   
        $alumno = Alumno::find($id);

        if($alumno){

            $proforma = ItemsFacturaProforma::join('alumnos', 'items_factura_proforma.usuario_id', '=', 'alumnos.id')
                ->select('items_factura_proforma.*')
                ->where('alumnos.id', '=', $id)
            ->get();

            return view('participante.alumno.deuda')->with(['alumno' => $alumno , 'id' => $id, 'proforma' => $proforma]);

        }else{
           return redirect("participante/alumno"); 
        }
    }

    public function historial($id)
    {   
        $alumno = Alumno::find($id);

        if($alumno){


            $facturas = Factura::join('alumnos', 'facturas.usuario_id', '=', 'alumnos.id')
                ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'facturas.numero_factura', 'facturas.fecha as fecha', 'facturas.id')
                ->where('alumnos.id', '=', $id)
            ->get();

            $array=array();

            foreach($facturas as $factura){

                $total = ItemsFactura::where('factura_id',$factura->id)->sum('importe_neto');

                $collection=collect($factura);     
                $factura_array = $collection->toArray();
                $factura_array['total']=$total;
                $array[$factura->id] = $factura_array;
            }

            return view('participante.alumno.historial')->with(['facturas' => $array, 'alumno' => $alumno]);

        }else{
            return redirect("participante/alumno"); 
        }
    }

    public function sesion($id)
    {   
        $alumno = Alumno::find($id);
        Session::put('alumno', $alumno);

        return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
    }

    public function updateImagen(Request $request)
    {  
        $in = array(2,4);

        $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
            ->where('usuarios_tipo.tipo_id',$request->id)
            ->whereIn('usuarios_tipo.tipo',$in)
        ->first();

        if($usuario){
                 
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

        return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'imagen' => $nombre_img, 200]);
    }

    public function updatePromotor(Request $request){
        $alumno = Alumno::find($request->id);
        $alumno->instructor_id = $request->instructor_id;

        if($alumno->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

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
            $alumno = Alumno::withTrashed()->find($request->id);
            $alumno->identificacion = $request->identificacion;        
            if($alumno->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateNombre(Request $request){

        $rules = [
            'nombre' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            'apellido' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        ];

        $messages = [

            'nombre.required' => 'Ups! El Nombre  es requerido ',
            'nombre.min' => 'El mínimo de caracteres permitidos son 3',
            'nombre.max' => 'El máximo de caracteres permitidos son 20',
            'nombre.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
            'apellido.required' => 'Ups! El Apellido  es requerido ',
            'apellido.min' => 'El mínimo de caracteres permitidos son 3',
            'apellido.max' => 'El máximo de caracteres permitidos son 20',
            'apellido.regex' => 'Ups! El apellido es inválido , debe ingresar sólo letras',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }
        $alumno = Alumno::withTrashed()->find($request->id);


        $nombre = title_case($request->nombre);
        $apellido = title_case($request->apellido);


        $alumno->nombre = $nombre;
        $alumno->apellido = $apellido;

        if($alumno->save()){

            $in = array(2,4);
            $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->where('usuarios_tipo.tipo_id',$request->id)
                ->whereIn('usuarios_tipo.tipo',$in)
            ->first();

            if($usuario){

                $usuario->nombre = $nombre;
                $usuario->apellido = $apellido;

                if($usuario->save()){
                    return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }

            }else{
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }
            

        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateFecha(Request $request){


        $alumno = Alumno::withTrashed()->find($request->id);
        $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->toDateString();
        $alumno->fecha_nacimiento = $fecha_nacimiento;

        if($alumno->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }
    public function updateSexo(Request $request){

        $alumno = Alumno::withTrashed()->find($request->id);
        $alumno->sexo = $request->sexo;

        // return redirect("alumno/edit/{$request->id}");
        if($alumno->save()){

            $in = array(2,4);
            $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->where('usuarios_tipo.tipo_id',$request->id)
                ->whereIn('usuarios_tipo.tipo',$in)
            ->first();

            if($usuario){

                $usuario->sexo = $request->sexo;

                if($usuario->save()){
                    return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }

            }else{
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }

        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateCorreo(Request $request){

        $rules = [
            'correo' => 'required|email|max:255|unique:users,email, '.$request->id.',usuario_id',
        ];

        $messages = [
            'correo.required' => 'Ups! El correo es requerido',
            'correo.email' => 'Ups! El correo tiene una dirección inválida',
            'correo.max' => 'El máximo de caracteres permitidos son 255',
            'correo.unique' => 'Ups! Ya este correo ha sido registrado',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $alumno = Alumno::withTrashed()->find($request->id);
            $correo = strtolower($request->correo);
            $alumno->correo = $correo;

            if($alumno->save()){

                $in = array(2,4);
                $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                    ->where('usuarios_tipo.tipo_id',$request->id)
                    ->whereIn('usuarios_tipo.tipo',$in)
                ->first();

                if($usuario){

                    $usuario->email = $correo;

                    if($usuario->save()){
                        return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                    }else{
                        return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                    }

                }else{
                    return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                }
                
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateTelefono(Request $request){

        $alumno = Alumno::withTrashed()->find($request->id);
        $alumno->telefono = $request->telefono;
        $alumno->celular = $request->celular;

        if($alumno->save()){

            $in = array(2,4);
            $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->where('usuarios_tipo.tipo_id',$request->id)
                ->whereIn('usuarios_tipo.tipo',$in)
            ->first();

            if($usuario){

                $usuario->telefono = $request->telefono;
                $usuario->celular = $request->celular;

                if($usuario->save()){
                    return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }

            }else{
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }

        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateDireccion(Request $request){
        $alumno = Alumno::withTrashed()->find($request->id);

        $direccion = $request->direccion;

        $alumno->direccion = $direccion;
        
        if($alumno->save()){

            $in = array(2,4);
            $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->where('usuarios_tipo.tipo_id',$request->id)
                ->whereIn('usuarios_tipo.tipo',$in)
            ->first();
     
            if($usuario){

                $usuario->direccion = $direccion;

                if($usuario->save()){
                    return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }
             
            }else{
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }

        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateFicha(Request $request){
        $alumno = Alumno::withTrashed()->find($request->id);
        $alumno->asma = $request->asma;
        $alumno->alergia = $request->alergia;
        $alumno->convulsiones = $request->convulsiones;
        $alumno->cefalea = $request->cefalea;
        $alumno->hipertension = $request->hipertension;
        $alumno->lesiones = $request->lesiones;

       if($alumno->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateRol(Request $request){
        
        $alumno = Alumno::withTrashed()->find($request->id);

        if($request->rol == 0){
            $alumno->tipo = 2;
        }
        else{
            $alumno->tipo = 1;
        }
        
        // return redirect("alumno/edit/{$request->id}");
        if($alumno->save()){

                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateCostoMensualidad(Request $request){
    $rules = [

        'fecha_pago' => 'required',
        'costo_mensualidad' => 'numeric',

    ];

    $messages = [

        'fecha_pago.required' => 'Ups! La fecha de pago es requerida',
        'costo_mensualidad.numeric' => 'Ups! El campo del costo de la mensualidad en inválido , debe contener sólo números',        
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{


        $fecha_pago = Carbon::createFromFormat('d/m/Y', $request->fecha_pago);


        if($fecha_pago < Carbon::now()){
            return response()->json(['errores' => ['fecha_pago' => [0, 'Ups! Esta fecha es invalida, debes ingresar una fecha mayor a hoy']], 'status' => 'ERROR'],422);
        }

        $fecha_pago = $fecha_pago->toDateString();

        $inscripcion_clase_grupal = InscripcionClaseGrupal::find($request->inscripcion_id);
        $inscripcion_clase_grupal->costo_mensualidad = $request->costo_mensualidad;
        $inscripcion_clase_grupal->fecha_pago = $fecha_pago;

       if($inscripcion_clase_grupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'id' => $request->inscripcion_id, 'costo_mensualidad' => $request->costo_mensualidad, 'fecha_pago' => $request->fecha_pago, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        }
    }

    public function updateEntrega(Request $request){

        $inscripcion_clase_grupal = InscripcionClaseGrupal::find($request->inscripcion_id);
        $inscripcion_clase_grupal->boolean_franela = $request->boolean_franela;
        $inscripcion_clase_grupal->boolean_programacion = $request->boolean_programacion;
        $inscripcion_clase_grupal->razon_entrega = $request->razon_entrega;
        $inscripcion_clase_grupal->talla_franela = $request->talla_franela;

       if($inscripcion_clase_grupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'id' => $request->inscripcion_id, 'boolean_franela' => $request->boolean_franela, 'boolean_programacion' => $request->boolean_programacion, 'razon_entrega' => $request->razon_entrega, 'talla_franela' => $request->talla_franela, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        
    }

    public function agregar_remuneracion(Request $request){


        $rules = [
            'concepto' => 'required',
            'remuneracion' => 'required|numeric',
            'fecha_vencimiento' => 'required',
        ];

        $messages = [

            'concepto.required' => 'Ups! El concepto es requerido ',
            'remuneracion.required' => 'Ups! El cantidad es requerida',
            'remuneracion.numeric' => 'Ups! La cantidad es inválida , debe contener sólo números',
            'fecha_vencimiento.required' => 'Ups! La fecha de vencimiento es requerida ',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{


            $fecha_vencimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_vencimiento);

            if($fecha_vencimiento < Carbon::now()){

                return response()->json(['errores' => ['fecha_vencimiento' => [0, 'Ups! Esta fecha es invalida, debes ingresar una fecha superior a hoy']], 'status' => 'ERROR'],422);
            }

            $fecha_vencimiento = $fecha_vencimiento->toDateString();

            $remuneracion = AlumnoRemuneracion::where('alumno_id',$request->id)->first();

            if(!$remuneracion){

                $remuneracion = new AlumnoRemuneracion;

                $remuneracion->alumno_id = $request->id;
                $remuneracion->concepto = $request->concepto;
            }

            $remuneracion->remuneracion = $request->remuneracion;
            $remuneracion->fecha_vencimiento = $fecha_vencimiento;

            if($remuneracion->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'array' => $remuneracion, 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function eliminar_remuneracion($id)
    {
        
        $remuneracion = AlumnoRemuneracion::find($id);

        $cantidad = $remuneracion->remuneracion;
        
        if($remuneracion->delete()){

            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 'cantidad' => $cantidad, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }


    public function eliminar_credencial($id)
    {
        
        $credencial = CredencialAlumno::find($id);

        $cantidad = $credencial->remuneracion;
        
        if($credencial->delete()){

            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 'cantidad' => $cantidad, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

    public function destroy($id)
    {
        
        $alumno = Alumno::find($id);
        
        if($alumno->delete()){
            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

    public function restore($id)
    {
            
        $alumno = Alumno::withTrashed()->find($id);
        
        if($alumno->restore()){
            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

    public function activar($id)
    {
        
        $alumno = InscripcionClaseGrupal::withTrashed()->find($id);
        
        if($alumno->restore()){
            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

    public function descongelar($id)
    {
            
        $alumno = InscripcionClaseGrupal::withTrashed()->find($id);

        $alumno->boolean_congelacion = 0;
        
        if($alumno->save()){
            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

    public function eliminar_inscripcion($id)
    {
            
        $alumno = InscripcionClaseGrupal::withTrashed()->find($id);
        
        if($alumno->forceDelete()){
            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }


    public function perfil_evaluativo($id)
    {
        // $perfil = PerfilEvaluativo::where('usuario_id', $usuario->id)->first();

        $perfil = DB::table('perfil_evaluativo')
            ->join('alumnos', 'perfil_evaluativo.usuario_id', '=', 'alumnos.id')
            ->select('perfil_evaluativo.*', 'alumnos.id as alumno_id')
            ->where('perfil_evaluativo.usuario_id', $id)
        ->first();

        if(!$perfil){
            $perfil = new PerfilEvaluativo;
            $perfil->usuario_id = $id;
            $perfil->save();
        }

        return view('usuario.planilla_evaluacion')->with('perfil', $perfil);
    }

    public function transferir($id){
        Session::put('id_alumno', $id);
        return view('guia.transferir')->with('id', Session::get('id_alumno'));
    }

    public function guardarAlumno($id){
        Session::put('id_alumno', $id);

         return response()->json(['mensaje' => '¡Excelente! El alumno se ha guardado satisfactoriamente', 'status' => 'OK', 200]);
    }

    public function enhorabuena($id){
        Session::put('id_alumno', $id);
        return view('guia.index');
    }

    public function eliminar_permanentemente($id){
        $delete = ItemsFacturaProforma::where('usuario_id',$id)->where('usuario_tipo',1)->forceDelete();
        $evaluaciones = Evaluacion::where('alumno_id',$id)->get();

        foreach($evaluaciones as $evaluacion){
            $detalle_evaluacion = DetalleEvaluacion::where('evaluacion_id',$evaluacion->id)->forceDelete();
        }

        $delete = Evaluacion::where('alumno_id',$id)->forceDelete();        
        $delete = AlumnoRemuneracion::where('alumno_id', $id)->forceDelete();

        $facturas = Factura::where('usuario_id',$id)->where('usuario_tipo',1)->get();

        foreach($facturas as $factura)
        {
            $delete = ItemsFactura::where('factura_id',$factura->id)->forceDelete();
            $delete = Pago::where('factura_id',$factura->id)->forceDelete();
        }

        $delete = Factura::where('usuario_id',$id)->where('usuario_tipo',1)->forceDelete();

        $acuerdos = Acuerdo::where('usuario_id',$id)->where('usuario_tipo',1)->get();

        foreach($acuerdos as $acuerdo)
        {
            $delete = ItemsAcuerdo::where('acuerdo_id',$acuerdo->id)->forceDelete();
        }

        $delete = Acuerdo::where('usuario_id',$id)->where('usuario_tipo',1)->forceDelete();

        $presupuestos = Presupuesto::where('alumno_id',$id)->get();

        foreach($presupuestos as $presupuesto)
        {
            $delete = ItemsPresupuesto::where('presupuesto_id',$presupuesto->id)->forceDelete();
        }

        $delete = Acuerdo::where('usuario_id',$id)->where('usuario_tipo',1)->forceDelete();
        $delete = Presupuesto::where('alumno_id',$id)->forceDelete();
        $delete = InscripcionClaseGrupal::where('alumno_id',$id)->forceDelete();
        $delete = InscripcionTaller::where('alumno_id',$id)->forceDelete();
        $delete = InscripcionClasePersonalizada::where('alumno_id',$id)->forceDelete();
        // $delete = InscripcionCoreografia::where('alumno_id',$id)->forceDelete();
        $delete = Asistencia::where('alumno_id',$id)->forceDelete();
        $delete = Cita::where('alumno_id',$id)->forceDelete();
        $array = array(2, 4);
        $delete = PerfilEvaluativo::where('usuario_id', $id)->forceDelete();
        $delete = CredencialAlumno::where('alumno_id',$id)->forceDelete();

        $alumno = Alumno::withTrashed()->find($id);

        if($alumno->familia_id){
            $es_representante = Familia::where('representante_id', $alumno->id)->first();
            if($es_representante){
                $hijos =  Alumno::withTrashed()->where('familia_id',$alumno->familia_id)->get();
                foreach($hijos as $hijo)
                {
                    $delete = ItemsFacturaProforma::where('alumno_id',$hijo->id)->forceDelete();
                    $evaluaciones = Evaluacion::where('alumno_id',$hijo->id)->get();
                    foreach($evaluaciones as $evaluacion){
                        $detalle_evaluacion = DetalleEvaluacion::where('evaluacion_id',$evaluacion->id)->forceDelete();
                    }
                    $delete = Evaluacion::where('alumno_id',$hijo->id)->forceDelete();
                    $delete = AlumnoRemuneracion::where('alumno_id', $hijo->id)->forceDelete();
                    $facturas = Factura::where('usuario_id',$hijo->id)->where('usuario_tipo',1)->get();
                    foreach($facturas as $factura)
                    {
                        $delete = ItemsFactura::where('factura_id',$factura->id)->forceDelete();
                        $delete = Pago::where('factura_id',$factura->id)->forceDelete();
                    }
                    $delete = Factura::where('usuario_id',$hijo->id)->forceDelete();
                    $acuerdos = Acuerdo::where('usuario_id',$hijo->id)->where('usuario_tipo',1)->get();

                    foreach($acuerdos as $acuerdo)
                    {
                        $delete = ItemsAcuerdo::where('acuerdo_id',$acuerdo->id)->forceDelete();
                    }

                    $delete = Acuerdo::where('usuario_id',$hijo->id)->where('usuario_tipo',1)->forceDelete();

                    $presupuestos = Presupuesto::where('alumno_id',$hijo->id)->get();

                    foreach($presupuestos as $presupuesto)
                    {
                        $delete = ItemsPresupuesto::where('presupuesto_id',$presupuesto->id)->forceDelete();
                    }

                    $delete = Presupuesto::where('alumno_id',$hijo->id)->forceDelete();
                    $delete = InscripcionClaseGrupal::where('alumno_id',$hijo->id)->forceDelete();
                    $delete = InscripcionTaller::where('alumno_id',$hijo->id)->forceDelete();
                    $delete = InscripcionClasePersonalizada::where('alumno_id',$hijo->id)->forceDelete();
                    $delete = Asistencia::where('alumno_id',$hijo->id)->forceDelete();
                    $delete = Cita::where('alumno_id',$hijo->id)->forceDelete();
                    $delete = PerfilEvaluativo::where('usuario_id', $hijo->id)->forceDelete();
                    $delete = CredencialAlumno::where('alumno_id',$hijo->id)->forceDelete();

                    $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                        ->where('usuarios_tipo.tipo_id',$hijo->id)
                        ->whereIn('usuarios_tipo.tipo',$in)
                    ->first();

                    if($usuario){
                        $notificaciones_usuarios = NotificacionUsuario::where('id_usuario', $usuario->id)->get();
                        foreach($notificaciones_usuarios as $notificacion_usuario)
                        {
                            $notificacion = Notificacion::find($notificacion_usuario->id_notificacion);
                            if($notificacion->tipo_evento == 5){
                                $notificacion->delete();
                            }
                        }
                        $delete = NotificacionUsuario::where('id_usuario', $usuario->id)->forceDelete();
                        $delete = Incidencia::where('usuario_id', $usuario->id)->forceDelete();
                        $delete = Sugerencia::where('usuario_id', $usuario->id)->forceDelete();

                        $delete = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                            ->where('usuarios_tipo.tipo_id',$id)
                            ->whereIn('usuarios_tipo.tipo',$array)
                        ->forceDelete();

                    }
                    $delete = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                        ->where('usuarios_tipo.tipo_id',$hijo->id)
                        ->whereIn('usuarios_tipo.tipo',$array)
                    ->forceDelete();
                    $delete = Alumno::withTrashed()->where('id',$hijo->id)->forceDelete();
                }
            }
        }

        $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
            ->where('usuarios_tipo.tipo_id',$id)
            ->whereIn('usuarios_tipo.tipo',$in)
        ->first();

        if($usuario){

            $delete = Familia::where('representante_id',$usuario->id)->forceDelete();

            $notificaciones_usuarios = NotificacionUsuario::where('id_usuario', $usuario->id)->get();
            foreach($notificaciones_usuarios as $notificacion_usuario)
            {
                $notificacion = Notificacion::find($notificacion_usuario->id_notificacion);
                if($notificacion->tipo_evento == 5){
                    $notificacion->delete();
                }
            }

            $delete = NotificacionUsuario::where('id_usuario', $usuario->id)->forceDelete();
            $delete = Incidencia::where('usuario_id', $usuario->id)->forceDelete();
            $delete = Sugerencia::where('usuario_id', $usuario->id)->forceDelete();

        }

        $delete = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
            ->where('usuarios_tipo.tipo_id',$id)
            ->whereIn('usuarios_tipo.tipo',$array)
        ->forceDelete();
        $delete = Alumno::withTrashed()->where('id',$id)->forceDelete();


        return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        
    }


    public function agregar_cantidad(Request $request){
        
        $rules = [

            'cantidad' => 'required|numeric|min:1',
        ];

        $messages = [

            'cantidad.required' => 'Ups! El Cantidad es invalido, solo se aceptan numeros',
            'cantidad.numeric' => 'Ups! El Cantidad es requerido',
            'cantidad.min' => 'El mínimo de cantidad permitida es 1',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $academia = Academia::find(Auth::user()->academia_id);

            $puntos_referidos = $academia->puntos_referencia * $request->cantidad;

            Session::push('puntos_referidos', $request->cantidad);

            $items = Session::get('puntos_referidos');
            end( $items );
            $contador = key( $items );

             return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'cantidad' => $request->cantidad, 'puntos_referidos' => $puntos_referidos, 'id' => $contador, 200]);

        }
    }

    public function eliminar_cantidad($id){

        $arreglo = Session::get('puntos_referidos');

        $cantidad = $arreglo[$id];

        $academia = Academia::find(Auth::user()->academia_id);

        $puntos_referidos = $academia->puntos_referencia * $cantidad;

        unset($arreglo[$id]);
        Session::put('puntos_referidos', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'cantidad' => $cantidad, 'puntos_referidos' => $puntos_referidos, 200]);

    }

    public function cancelar_cantidad(){

        Session::forget('puntos_referidos');

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function indexLlamada($id){

      $interesado = Alumno::find($id);

      $llamadas = Llamada::where('usuario_id', $id)->where('usuario_tipo',2)->get();

      return view('participante.alumno.llamada.principal')->with(['id' => $id, 'llamadas' => $llamadas, 'interesado' => $interesado]);
    }

    public function createLlamada($id){
        $academia = Academia::find(Auth::user()->academia_id);
        if($academia->pais_id == 11){
            $hora = Carbon::now('America/Bogota');  
        }else{
            $hora = Carbon::now('America/Caracas');
        }
      $hora_actual = $hora->format('H:i');
      // $hora_actual = $hora->sub(new DateInterval('PT30H'))->format('H:i');
      $interesado = Visitante::find($id);
      return view('participante.alumno.llamada.create')->with(['id' => $id, 'interesado' => $interesado, 'hora_actual' => $hora_actual]);
    }

    public function storeLlamada(Request $request){

      $rules = [
          'status' => 'required',
          'hora_llamada' => 'required'

      ];

      $messages = [

          'status.required' => 'Ups! El Estatus es requerido',
          'hora_llamada.required' => 'Ups! La hora es requerida',

      ];

      $validator = Validator::make($request->all(), $rules, $messages);

      if ($validator->fails()){

          return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
      }

      else{


        $academia = Academia::find(Auth::user()->academia_id);
        if($academia->pais_id == 11){
            $fecha_llamada = Carbon::now('America/Bogota');  
        }else{
            $fecha_llamada = Carbon::now('America/Caracas');
        }

        if($request->fecha_siguiente){

          $fecha_siguiente = Carbon::createFromFormat('d/m/Y', $request->fecha_siguiente);
          
          if($fecha_llamada > $fecha_siguiente ) {

             return response()->json(['errores' => ['fecha_siguiente' => [0, 'Ups! Esta fecha es invalida, debes ingresar una fecha mayor a hoy']], 'status' => 'ERROR'],422);
           } 

         }else{
          $fecha_siguiente = '';
         }

         if($request->hora_siguiente){
          $hora_siguiente = $request->hora_siguiente;
         }else{
          $hora_siguiente = '';
         }

        $llamada = new Llamada;
        
        $llamada->usuario_id = $request->id;
        $llamada->usuario_tipo = 2;
        $llamada->observacion = $request->observacion;
        $llamada->status = $request->status;
        $llamada->fecha_llamada = $fecha_llamada;
        $llamada->hora_llamada = $request->hora_llamada;
        $llamada->fecha_siguiente = $fecha_siguiente;
        $llamada->hora_siguiente = $hora_siguiente;

        if($llamada->save()){

            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
        }
      }
    }

    public function eliminarLlamada($id){

      $llamada=Llamada::find($id);
      $llamada->delete();
      
      return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
    }

    public function crearCuenta($id){

        $alumno = Alumno::find($id);

        if($alumno){

            if($alumno->correo){

                $in = array(2,4);

                $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                    ->where('usuarios_tipo.tipo_id',$alumno->id)
                    ->whereIn('usuarios_tipo.tipo',$in)
                ->first();

                if(!$usuario){

                    $password = str_random(8);
                                
                    $usuario = new User;

                    $usuario->academia_id = Auth::user()->academia_id;
                    $usuario->nombre = $alumno->nombre;
                    $usuario->apellido = $alumno->apellido;
                    $usuario->telefono = $alumno->telefono;
                    $usuario->celular = $alumno->celular;
                    $usuario->sexo = $alumno->sexo;
                    $usuario->email = $alumno->correo;
                    $usuario->como_nos_conociste_id = 1;
                    $usuario->direccion = $alumno->direccion;
                    $usuario->confirmation_token = str_random(40);
                    $usuario->password = bcrypt($password);
                    $usuario->usuario_id = $alumno->id;
                    $usuario->usuario_tipo = 2; 

                    $usuario->save();

                    $usuario_tipo = new UsuarioTipo;
                    $usuario_tipo->usuario_id = $usuario->id;
                    $usuario_tipo->tipo = 2;
                    $usuario_tipo->tipo_id = $alumno->id;
                    $usuario_tipo->save();
                  
                    return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

                }else{
                    return response()->json(['error_mensaje' => 'Ups! El alumno ya posee una cuenta'], 422);
                }

            }else{
                return response()->json(['error_mensaje' => 'Ups! El alumno no posee correo electronico para crear su cuenta'], 422);
            }

        }else{
            return response()->json(['error_mensaje' => 'Ups! No Hemos encontrado la siguiente información del identificador asociada a tu cuenta', 'status' => 'ERROR'],422);
        }
    }

}
