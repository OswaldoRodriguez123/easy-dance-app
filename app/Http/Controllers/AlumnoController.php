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
use App\ClasePersonalizada;
use App\ItemsFacturaProforma;
use App\Academia;
use App\Familia;
use App\User;
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
use App\ItemsPresupuesto;
use App\Presupuesto;
use App\Asistencia;
use App\Cita;
use App\Notificacion;
use App\NotificacionUsuario;
use App\Incidencia;
use App\Sugerencia;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;


class AlumnoController extends BaseController
{


    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    
    public function principal()
	{
        $alumnod = DB::table('alumnos')
            ->join('items_factura_proforma', 'items_factura_proforma.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.id as id', 'items_factura_proforma.importe_neto', 'items_factura_proforma.fecha_vencimiento')
            ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
            ->where('alumnos.deleted_at', '=', null)
        ->get();

        $alumnoc = DB::table('users')
            ->join('alumnos', 'alumnos.id', '=', 'users.usuario_id')
            ->select('alumnos.id as id')
            ->where('users.academia_id','=', Auth::user()->academia_id)
            ->where('alumnos.deleted_at', '=', null)
            ->where('users.usuario_tipo', '=', 2)
            ->where('users.confirmation_token', '!=', null)
        ->get();

        $collection=collect($alumnod);
        $grouped = $collection->groupBy('id');     
        $deuda = $grouped->toArray();

        $collection=collect($alumnoc);
        $grouped = $collection->groupBy('id');     
        $activacion = $grouped->toArray();

        $alumnos = Alumno::withTrashed()->where('academia_id', '=' ,  Auth::user()->academia_id)->where('tipo', 1)->get();

        $array = array();

        foreach($alumnos as $alumno){

            $edad = Carbon::createFromFormat('Y-m-d', $alumno->fecha_nacimiento)->diff(Carbon::now())->format('%y');
            $collection=collect($alumno);     
            $alumno_array = $collection->toArray();
            
            $alumno_array['edad']=$edad;
            $array[$alumno->id] = $alumno_array;

        }

        $instructor = Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

		return view('participante.alumno.principal')->with(['alumnos' => $array, 'instructor' => $instructor,'deuda' => $deuda, 'activacion' => $activacion, 'edad' => '']);
	}


    public function inactivos()
    {
        $alumnod = DB::table('alumnos')
            ->join('items_factura_proforma', 'items_factura_proforma.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.id as id', 'items_factura_proforma.importe_neto', 'items_factura_proforma.fecha_vencimiento')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
            ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
            ->where('deleted_at', '!=' ,  NULL)
        ->get();

        $collection=collect($alumnod);

        $grouped = $collection->groupBy('id');     
        
        $deuda = $grouped->toArray();

        // $alumno = DB::table('alumnos')
        //     ->select('alumnos.*')
        //     ->where('academia_id', '=' ,  Auth::user()->academia_id)
        //     ->where('deleted_at', '!=' ,  NULL)
        // ->get();

        $alumno = Alumno::onlyTrashed()
                ->where('academia_id', Auth::user()->academia_id)
                ->whereNotNull('deleted_at')
            ->get();

        // $proforma = DB::table('items_factura_proforma')
        //     ->groupBy('alumno_id')

        // ->get();

        // $total = ItemsFacturaProforma::groupBy('alumno_id')
        //    ->selectRaw('sum(importe_neto) as sum, *');
        //    // ->lists('sum','alumno_id');
        // dd($total);


        return view('participante.alumno.bandeja')->with(['alumnos' => $alumno, 'deuda' => $deuda]);
    }

	public function store(Request $request)
	{
        
		$request->merge(array('correo' => trim($request->correo)));

    $rules = [
        'identificacion' => 'required|min:7|numeric|unique:alumnos,identificacion',
        'nombre' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'apellido' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'fecha_nacimiento' => 'required',
        'sexo' => 'required',
        'correo' => 'required|email|max:255|unique:users,email',
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
        'correo.required' => 'Ups! El correo  es requerido ',
        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'correo.max' => 'El máximo de caracteres permitidos son 255',
        'correo.unique' => 'Ups! Ya este correo ha sido registrado',
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

        if($request->visitante_id){
            $visitante = Visitante::find($request->visitante_id);
            $visitante->cliente = 1;

            $visitante->save();
        }

        $alumno = new Alumno;

        $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->toDateString();

        $nombre = title_case($request->nombre);
        $apellido = title_case($request->apellido);

        $correo = strtolower($request->correo);

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

        do{
            $codigo_referido = str_random(8);
            $find = Alumno::where('codigo_referido', $codigo_referido)->first();
        }while ($find);

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
        $alumno->instructor_id = $request->instructor_id;

        if($alumno->save()){

            if($request->codigo){
                $referido=DB::table('alumnos')
                    ->select('alumnos.*')
                    ->where('alumnos.codigo_referido','=',$request->codigo)
                    ->where('alumnos.academia_id','=',Auth::user()->academia_id)
                ->first();
                if($referido){

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
                        do{
                            $codigo_validacion = str_random(8);
                            $find = Alumno::where('codigo_referido', $codigo_validacion)->first();
                        }while ($find);
                        $remuneracion->alumno_id = $referido->id;
                        $remuneracion->remuneracion = $academia->puntos_referencia;
                        $remuneracion->save();
                    }
                }else{
                    return response()->json(['errores' => ['codigo' => [0, 'Ups! Este código no pertenece a ningun estudiante']], 'status' => 'ERROR'],422);
                }
            }

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

            if($usuario->save()){
            
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

                        $mensaje = $request->nombre.'. Subiste a bordo a la tripulación de tu clase de baile, gracias por unirte a nosotros. Nos encanta verte bailar.';

                        $client = new Client(); //GuzzleHttp\Client
                        $result = $client->get('https://sistemasmasivos.com/c3colombia/api/sendsms/send.php?user=coliseodelasalsa@gmail.com&password=k1-9L6A1rn&GSM='.$celular.'&SMSText='.$mensaje);

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
            }
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
        }
        // return redirect("/home");
        //return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
    }

    }

    public function create()
    {
 
        return view('participante.alumno.create')->with(['instructores' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get()]);
    }

    public function agregarvisitante($id)
    {

        $visitante = Visitante::find($id);
 
        return view('participante.alumno.create')->with(['visitante' => $visitante, 'instructores' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get()]);
    }

    public function edit($id)
    {   
        $alumno = Alumno::Leftjoin('instructores', 'alumnos.instructor_id', '=', 'instructores.id')
            ->select('alumnos.*','instructores.nombre as instructor_nombre','instructores.apellido as instructor_apellido')
            ->where('alumnos.id',$id)
        ->first();

        if($alumno){

            // $clases_grupales = InscripcionClaseGrupal::where('alumno_id', $id)->get();

            $clases_grupales = DB::table('alumnos')
                ->join('inscripcion_clase_grupal', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
                ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('config_clases_grupales.nombre as nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final', 'clases_grupales.id', 'inscripcion_clase_grupal.fecha_pago', 'inscripcion_clase_grupal.costo_mensualidad', 'inscripcion_clase_grupal.id as inscripcion_id', 'inscripcion_clase_grupal.fecha_pago', 'inscripcion_clase_grupal.boolean_programacion', 'inscripcion_clase_grupal.boolean_franela', 'inscripcion_clase_grupal.razon_entrega',  'inscripcion_clase_grupal.talla_franela')
                ->where('inscripcion_clase_grupal.alumno_id', $id)
                ->where('inscripcion_clase_grupal.deleted_at', null)
            ->get();

            $array_descripcion = array();

            foreach($clases_grupales as $clase){

                array_push($array_descripcion, $clase->nombre);
               
            }

            $descripcion = implode(", ", $array_descripcion);

            $subtotal = 0;
            $impuesto = 0;

            $item_factura = DB::table('items_factura_proforma')
            ->select('items_factura_proforma.*')
            ->where('items_factura_proforma.alumno_id', '=', $id)
            ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
            ->get();

            foreach($item_factura as $items_factura){

                    $subtotal = $subtotal + $items_factura->importe_neto;
                    
            }

            $perfil = DB::table('perfil_evaluativo')
                ->join('alumnos', 'perfil_evaluativo.usuario_id', '=', 'alumnos.id')
                ->select('perfil_evaluativo.*', 'alumnos.id as alumno_id')
                ->where('alumnos.id', $id)
            ->first();

            $usuario = DB::table('users')
                ->join('alumnos', 'users.usuario_id', '=', 'alumnos.id')
                ->select('users.imagen')
                ->where('alumnos.id', $id)
            ->first();

            if($perfil){
                $tiene_perfil = 1;
            }else{
                $tiene_perfil = 0;
            }

            if($usuario){
                $imagen = $usuario->imagen;
            }else{
                $imagen = '';
            }

            $alumno_remuneracion = AlumnoRemuneracion::where('alumno_id',$id)->first();

            if($alumno_remuneracion){
                $puntos_referidos = $alumno_remuneracion->remuneracion;
            }else{
                $puntos_referidos = 0;
            }

           return view('participante.alumno.planilla')->with(['alumno' => $alumno , 'id' => $id, 'total' => $subtotal, 'clases_grupales' => $clases_grupales, 'descripcion' => $descripcion, 'perfil' => $tiene_perfil, 'imagen' => $imagen, 'puntos_referidos' => $puntos_referidos, 'instructores' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get()]);
        }else{
           return redirect("participante/alumno"); 
        }
    }

    public function operar($id)
    {   
        $alumno = Alumno::find($id);
        return view('participante.alumno.operacion')->with(['id' => $id, 'alumno' => $alumno]);        
    }

    public function deuda($id)
    {   
        $alumno = DB::table('alumnos')
            ->select('alumnos.*')
            ->where('alumnos.id', '=', $id)
        ->first();

        $proforma = DB::table('items_factura_proforma')
            ->join('alumnos', 'items_factura_proforma.alumno_id', '=', 'alumnos.id')
            ->select('items_factura_proforma.*')
            ->where('alumnos.id', '=', $id)
        ->get();

        foreach($proforma as $proformas){
            if($proformas->fecha_vencimiento <= Carbon::today()){
                $proformas->vencido = true;
            }
        }
        
        if($alumno){

           return view('participante.alumno.deuda')->with(['alumno' => $alumno , 'id' => $id, 'proforma' => $proforma]);

        }else{
           return redirect("participante/alumno/detalle/"+$id); 
        }
    }

    public function historial($id)
    {   
        $alumno = Alumno::find($id);

        $factura_join = DB::table('facturas')
            ->join('alumnos', 'facturas.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'facturas.numero_factura as factura', 'facturas.fecha as fecha', 'facturas.id')
            ->where('alumno_id', '=', $id)
        ->get();

        $alumnod = DB::table('facturas')
            ->join('items_factura', 'items_factura.factura_id', '=', 'facturas.id')
            ->select('items_factura.importe_neto', 'facturas.id')
            ->where('facturas.alumno_id','=',$id)
        ->get();

        if($alumnod){

            $collection=collect($alumnod);
            $grouped = $collection->groupBy('id');     
            $facturado = $grouped->toArray();

            $array=array();
            $i = 0;
            $importe_neto = 0;

            foreach($facturado as $item){
                $importe_neto = 0;
                foreach($item as $tmp){

                $factura_id = $tmp->id;
                $importe_neto = $importe_neto + $tmp->importe_neto;
                // $id_alumno = $item['']
                // $iva = $item['costo'] * ($academia->porcentaje_impuesto / 100);
                }

                // $factura_join[$i]->setAttribute('total',  $importe_neto);
                // $factura_join[$id]->total = $importe_neto;
                $factura_join[$i]->total=$importe_neto;
                $array[$factura_id] = $factura_join[$i];
                $i = $i + 1;
            }

            if($factura_join){

               return view('participante.alumno.historial')->with(['facturas' => $array, 'alumno' => $alumno]);

            }else{
               return redirect("participante/alumno/detalle/"+$id); 
            }
        }
        else{
            return view('participante.alumno.historial')->with(['alumno' => $alumno, 'facturas' => array()]);
        }
    }

    public function sesion($id)
    {   
        $alumno = Alumno::find($id);
        Session::put('alumno', $alumno);

        return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
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
            'identificacion' => 'required|min:7|numeric|unique:alumnos,identificacion, '.$request->id.'',
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

            $tmp = User::where('usuario_id', $request->id)->first();

            if($tmp){
                $es_representante = Familia::where('representante_id', $tmp->id)->first();

                if(!$es_representante){
                    $usuario = User::where('usuario_id' , $alumno->id)->where('usuario_tipo', 2)->first();
                }
                else{
                    $usuario = User::where('usuario_id' , $alumno->id)->where('usuario_tipo', 4)->first();
                }

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

            $tmp = User::where('usuario_id', $request->id)->first();

            if($tmp){
                $es_representante = Familia::where('representante_id', $tmp->id)->first();

                if(!$es_representante){
                    $usuario = User::where('usuario_id' , $alumno->id)->where('usuario_tipo', 2)->first();
                }
                else{
                    $usuario = User::where('usuario_id' , $alumno->id)->where('usuario_tipo', 4)->first();
                }

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
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }

        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateCorreo(Request $request){

    $rules = [
        'correo' => 'email|max:255|unique:users,email, '.$request->id.'',
    ];

    $messages = [

        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'correo.max' => 'El máximo de caracteres permitidos son 255',
        'correo.unique' => 'Ups! Ya este correo ha sido registrado',
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
        $alumno = Alumno::withTrashed()->find($request->id);
        $correo = strtolower($request->correo);
        $alumno->correo = $correo;

        if($alumno->save()){

            $tmp = User::where('usuario_id', $request->id)->first();

            if($tmp){
                $es_representante = Familia::where('representante_id', $tmp->id)->first();

                if(!$es_representante){
                    $usuario = User::where('usuario_id' , $alumno->id)->where('usuario_tipo', 2)->first();
                }
                else{
                    $usuario = User::where('usuario_id' , $alumno->id)->where('usuario_tipo', 4)->first();
                }

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

            $tmp = User::where('usuario_id', $request->id)->first();

            if($tmp){
                $es_representante = Familia::where('representante_id', $tmp->id)->first();

                if(!$es_representante){
                    $usuario = User::where('usuario_id' , $alumno->id)->where('usuario_tipo', 2)->first();
                }
                else{
                    $usuario = User::where('usuario_id' , $alumno->id)->where('usuario_tipo', 4)->first();
                }

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

            $tmp = User::where('usuario_id', $request->id)->first();

            if($tmp){
                $es_representante = Familia::where('representante_id', $tmp->id)->first();

                if(!$es_representante){
                    $usuario = User::where('usuario_id' , $alumno->id)->where('usuario_tipo', 2)->first();
                }
                else{
                    $usuario = User::where('usuario_id' , $alumno->id)->where('usuario_tipo', 4)->first();
                }

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

    public function destroy($id)
    {
        // $total = 0;

        
        // $mensaje = 'Ups! Este alumno no puede ser eliminado ya que se encuentra registrado en alguna';
        
        // $exist = InscripcionClaseGrupal::where('alumno_id', $id)->first();

        // if($exist)
        // {
        //     $total = 1;

        //     $mensaje = $mensaje . ' clase grupal';
        // }

        // $exist = InscripcionTaller::where('alumno_id',$id)->first();
        
        // if($exist)
        // {
        //     $total = 1;

        //     $mensaje = $mensaje . ', taller';
        // }

        // $exist = InscripcionCoreografia::where('alumno_id',$id)->first();
        
        // if($exist)
        // {
        //     $total = 1;

        //     $mensaje = $mensaje . ' o coreografia';
        // }

        // $mensaje = $mensaje . ', para deshabilitarlo debe eliminarlo de la actividad donde se encuentra registrado';

        // if($total == 0){

            $alumno = Alumno::find($id);
            
            if($alumno->delete()){
                return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        // }
        // else
        // {
        //     return response()->json(['error_mensaje'=> $mensaje , 'status' => 'ERROR-INSCRIPCION'],422);
        // }

        // return redirect("alumno");
    }

    public function restore($id)
    {
            
            $alumno = Alumno::onlyTrashed()
                ->where('id', $id)
                ->first();
            
            if($alumno->restore()){
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

    public function enhorabuena($id){
        Session::put('id_alumno', $id);
        return view('guia.index');
    }

    public function eliminar_permanentemente($id){
        $delete = ItemsFacturaProforma::where('alumno_id',$id)->forceDelete();
        $evaluaciones = Evaluacion::where('alumno_id',$id)->get();
        foreach($evaluaciones as $evaluacion){
            $detalle_evaluacion = DetalleEvaluacion::where('evaluacion_id',$evaluacion->id)->forceDelete();
        }
        $delete = Evaluacion::where('alumno_id',$id)->forceDelete();
        $facturas = Factura::where('alumno_id',$id)->get();
        foreach($facturas as $factura)
        {
            $delete = ItemsFactura::where('factura_id',$factura->id)->forceDelete();
            $delete = Pago::where('factura_id',$factura->id)->forceDelete();
        }
        $delete = AlumnoRemuneracion::where('alumno_id', $id)->forceDelete();
        $delete = Factura::where('alumno_id',$id)->forceDelete();
        $delete = Acuerdo::where('alumno_id',$id)->forceDelete();

        $presupuestos = Factura::where('alumno_id',$id)->get();
        foreach($presupuestos as $presupuesto)
        {
            $delete = ItemsPresupuesto::where('presupuesto_id',$presupuesto->id)->forceDelete();
        }
        $delete = Presupuesto::where('alumno_id',$id)->forceDelete();
        $delete = InscripcionClaseGrupal::where('alumno_id',$id)->forceDelete();
        $delete = InscripcionTaller::where('alumno_id',$id)->forceDelete();
        $delete = InscripcionClasePersonalizada::where('alumno_id',$id)->forceDelete();
        $delete = InscripcionCoreografia::where('alumno_id',$id)->forceDelete();
        $delete = Asistencia::where('alumno_id',$id)->forceDelete();
        $delete = Cita::where('alumno_id',$id)->forceDelete();
        $array = array(2, 4);
        $delete = PerfilEvaluativo::where('usuario_id', $id)->forceDelete();

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
                    $facturas = Factura::where('alumno_id',$hijo->id)->get();
                    foreach($facturas as $factura)
                    {
                        $delete = ItemsFactura::where('factura_id',$factura->id)->forceDelete();
                        $delete = Pago::where('factura_id',$factura->id)->forceDelete();
                    }
                    $delete = AlumnoRemuneracion::where('alumno_id', $hijo->id)->forceDelete();
                    $delete = Factura::where('alumno_id',$hijo->id)->forceDelete();
                    $delete = Acuerdo::where('alumno_id',$hijo->id)->forceDelete();

                    $presupuestos = Factura::where('alumno_id',$hijo->id)->get();
                    foreach($presupuestos as $presupuesto)
                    {
                        $delete = ItemsPresupuesto::where('presupuesto_id',$presupuesto->id)->forceDelete();
                    }
                    $delete = Presupuesto::where('alumno_id',$hijo->id)->forceDelete();
                    $delete = InscripcionClaseGrupal::where('alumno_id',$hijo->id)->forceDelete();
                    $delete = InscripcionTaller::where('alumno_id',$hijo->id)->forceDelete();
                    $delete = InscripcionClasePersonalizada::where('alumno_id',$hijo->id)->forceDelete();
                    $delete = InscripcionCoreografia::where('alumno_id',$hijo->id)->forceDelete();
                    $delete = Asistencia::where('alumno_id',$hijo->id)->forceDelete();
                    $delete = Cita::where('alumno_id',$hijo->id)->forceDelete();
                    $delete = PerfilEvaluativo::where('usuario_id', $hijo->id)->forceDelete();

                    $usuario = User::where('usuario_id', $hijo->id)->whereIn('usuario_tipo', $array)->first();

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

                        $delete = User::where('usuario_id', $id)->whereIn('usuario_tipo', $array)->forceDelete();

                    }

                    $delete = User::where('usuario_id', $hijo->id)->whereIn('usuario_tipo', $array)->forceDelete();
                    $delete = Alumno::withTrashed()->where('id',$hijo->id)->forceDelete();
                }
            }
        }

        $usuario = User::where('usuario_id', $id)->whereIn('usuario_tipo', $array)->first();

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

        $delete = User::where('usuario_id', $id)->whereIn('usuario_tipo', $array)->forceDelete();
        $delete = Alumno::withTrashed()->where('id',$id)->forceDelete();


        return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        
    }


}
