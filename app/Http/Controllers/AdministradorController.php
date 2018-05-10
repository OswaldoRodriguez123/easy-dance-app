<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\UsuarioTipo;
use App\Sucursal;
use App\Academia;

use App\ItemsFacturaProforma;
use App\Evaluacion;
use App\DetalleEvaluacion;
use App\AlumnoRemuneracion;
use App\Factura;
use App\ItemsFactura;
use App\Pago;
use App\Acuerdo;
use App\ItemsAcuerdo;
use App\Presupuesto;
use App\ItemsPresupuesto;
use App\InscripcionTaller;
use App\InscripcionClaseGrupal;
use App\InscripcionCoreografia;
use App\InscripcionClasePersonalizada;
use App\HorarioClasePersonalizada;
use App\Asistencia;
use App\Cita;
use App\PerfilEvaluativo;
use App\CredencialAlumno;
use App\Visitante;
use App\Alumno;
use App\Instructor;
use App\CredencialInstructor;
use App\Staff;
use App\AsistenciaStaff;
use App\Notificacion;
use App\NotificacionUsuario;
use App\Incidencia;
use App\Sugerencia;
use App\VencimientoClaseGrupal;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use Mail;
use Carbon\Carbon;

class AdministradorController extends BaseController
{

    public function principal()
    {

        $academia = Academia::find(Auth::user()->academia_id);
        $array = array(1, 5, 6);

        $usuarios = User::join('academias', 'users.academia_id', '=', 'academias.id')
            ->join('sucursales', 'academias.sucursal_id', '=', 'sucursales.id')
            ->join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
            ->select('academias.nombre as nombre_academia', 'users.*', 'users.usuario_tipo')
            ->where('sucursales.id','=', $academia->sucursal_id)
            ->where('users.id','!=',Auth::user()->id)
            ->whereIn('usuarios_tipo.tipo', $array)
            ->distinct('users.id')
        ->get();

        return view('configuracion.administradores.principal')->with('usuarios', $usuarios);
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
        return view('configuracion.administradores.create');
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

            'email' => 'required|email|max:255|confirmed',
            'email_confirmation' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'responsable' => 'required|min:3|max:40|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            'usuario_tipo' => 'required',

        ];

        $messages = [

            'email.required' => 'Ups! El Correo es requerido',
            'email.email' => 'Ups! El Correo tiene una dirección inválida',
            'email.max' => 'El máximo de caracteres permitidos son 255',
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
            'usuario_tipo.required' => 'Ups! El Tipo es requerido',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{

            $correo = trim(strtolower($request->email)); 
            $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->select('users.id','users.estatus')
                ->where('users.email',$correo)
                ->where('usuarios_tipo.tipo',$request->usuario_tipo)
            ->first();

            if($usuario){
                if($usuario->estatus){
                    return response()->json(['errores' => ['email' => [0, 'Ups! Ups! Ya este correo ha sido registrado']], 'status' => 'ERROR'],422);
                }else{
                    
                    $usuario->estatus = 1;
                    $usuario->save();

                    return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);   
                }
            }

            if($request->usuario_tipo == 5){
                $sucursal = Academia::select('academias.sucursal_id')
                    ->where('academias.id','=',Auth::user()->academia_id)
                ->first();

                $academia = new Academia;
                $academia->sucursal_id = $sucursal->sucursal_id;
                $academia->save();

                $academia_id = $academia->id;

            }else{
                $academia_id = Auth::user()->academia_id;
            }

            $usuario = User::where('email',$correo)->first();

            if(!$usuario){

                $nombre = title_case($request->responsable);

                $usuario = new User;

                $usuario->academia_id = $academia_id;
                $usuario->nombre = $nombre;
                $usuario->email = $correo;
                $usuario->como_nos_conociste_id = 1;
                // $usuario->confirmation_token = str_random(40);
                $usuario->password = bcrypt($request->password);
                $usuario->usuario_tipo = $request->usuario_tipo;

                $usuario->save();
            }

            $usuario_tipo = new UsuarioTipo;
            $usuario_tipo->usuario_id = $usuario->id;
            $usuario_tipo->tipo = $request->usuario_tipo;
            $usuario_tipo->tipo_id = 0;
            $usuario_tipo->save();

            $link = "confirmacion/?token=".$usuario->confirmation_token;

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
            
        }
        
    }


    public function eliminados()
    {

        $academia = Academia::find(Auth::user()->academia_id);
        $in = array(1, 5, 6);

        $usuarios = User::join('academias', 'users.academia_id', '=', 'academias.id')
            ->join('sucursales', 'academias.sucursal_id', '=', 'sucursales.id')
            ->join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
            ->select('users.*', 'academias.nombre as nombre_academia', 'users.usuario_tipo')
            ->where('sucursales.id','=', $academia->sucursal_id)
            ->where('users.id','!=',Auth::user()->id)
            ->where('users.estatus',0)
            ->whereIn('usuarios_tipo.tipo', $in)
            ->distinct('users.id')
        ->get();

        $array = array();

        foreach($usuarios as $usuario){

            $administrador = User::find($usuario->deleted_at_usuario_id);

            if($administrador){
                $administrador = $administrador->nombre . ' ' . $administrador->apellido;
            }else{
                $administrador = '';
            }

            $collection=collect($usuario);     
            $usuario_array = $collection->toArray();
            $usuario_array['administrador']=$administrador;
            $array[] = $usuario_array;
        }

        return view('configuracion.administradores.eliminados')->with('usuarios', $array);
    }

    public function restore($id)
    {
        $usuario = User::find($id);
        $usuario->deleted_at_usuario_id = '';
        $usuario->deleted_at_fecha = '';
        $usuario->estatus = 1;

        if($usuario->save()){
            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
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

    public function deshabilitar($id)
    {

        $usuario = User::find($id);
        $usuario->estatus = 0;
        $usuario->deleted_at_usuario_id = Auth::user()->id;
        $usuario->deleted_at_fecha = Carbon::now()->toDateString();
        
        if($usuario->save()){
            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function destroy($id){

        $usuario = User::find($id);

        if($usuario){

            $usuarios_tipo = UsuarioTipo::where('usuario_id',$usuario->id)->get();

            foreach($usuarios_tipo as $usuario_tipo){
                if($usuario_tipo->tipo == 2 || $usuario_tipo->tipo == 4){

                    $alumno_id = $usuario_tipo->tipo_id;

                    $in = array(2,4);
                    $delete = ItemsFacturaProforma::where('usuario_id',$alumno_id)->where('usuario_tipo',1)->forceDelete();
                    $evaluaciones = Evaluacion::where('alumno_id',$alumno_id)->get();

                    foreach($evaluaciones as $evaluacion){
                        $detalle_evaluacion = DetalleEvaluacion::where('evaluacion_id',$evaluacion->id)->forceDelete();
                    }

                    $delete = Evaluacion::where('alumno_id',$alumno_id)->forceDelete();        
                    $delete = AlumnoRemuneracion::where('alumno_id', $alumno_id)->forceDelete();

                    $facturas = Factura::where('usuario_id',$alumno_id)->where('usuario_tipo',1)->get();

                    foreach($facturas as $factura)
                    {
                        $delete = ItemsFactura::where('factura_id',$factura->id)->forceDelete();
                        $delete = Pago::where('factura_id',$factura->id)->forceDelete();
                    }

                    $delete = Factura::where('usuario_id',$alumno_id)->where('usuario_tipo',1)->forceDelete();

                    $acuerdos = Acuerdo::where('usuario_id',$alumno_id)->where('usuario_tipo',1)->get();

                    foreach($acuerdos as $acuerdo)
                    {
                        $delete = ItemsAcuerdo::where('acuerdo_id',$acuerdo->id)->forceDelete();
                    }

                    $delete = Acuerdo::where('usuario_id',$alumno_id)->where('usuario_tipo',1)->forceDelete();

                    $presupuestos = Presupuesto::where('alumno_id',$alumno_id)->get();

                    foreach($presupuestos as $presupuesto)
                    {
                        $delete = ItemsPresupuesto::where('presupuesto_id',$presupuesto->id)->forceDelete();
                    }
                    $delete = Presupuesto::where('alumno_id',$alumno_id)->forceDelete();
                    $delete = InscripcionClaseGrupal::where('alumno_id',$alumno_id)->forceDelete();
                    $delete = InscripcionTaller::where('alumno_id',$alumno_id)->forceDelete();
                    $clases_personalizadas = InscripcionClasePersonalizada::where('alumno_id',$alumno_id)->get();
                    foreach($clases_personalizadas as $clase_personalizada)
                    {
                        $delete = HorarioClasePersonalizada::where('clase_personalizada_id',$clase_personalizada->id)->forceDelete();
                    }

                    $delete = InscripcionClasePersonalizada::where('alumno_id',$alumno_id)->forceDelete();
                    $delete = Asistencia::where('alumno_id',$alumno_id)->forceDelete();
                    $delete = Cita::where('alumno_id',$alumno_id)->forceDelete();
                    $delete = PerfilEvaluativo::where('usuario_id', $alumno_id)->forceDelete();
                    $delete = CredencialAlumno::where('alumno_id',$alumno_id)->forceDelete();
                    $delete = Visitante::where('alumno_id',$alumno_id)->forceDelete();

                    $delete = Alumno::withTrashed()->where('id',$alumno_id)->forceDelete();
                }else if($usuario_tipo->tipo == 3){

                    $instructor_id = $usuario_tipo->tipo_id;

                    $delete = CredencialInstructor::where('instructor_id',$instructor_id)->delete();
                    $delete = Instructor::withTrashed()->where('id',$instructor_id)->forceDelete();
                }else if($usuario_tipo->tipo == 8){

                    $staff_id = $usuario_tipo->tipo_id;
                    $delete = AsistenciaStaff::withTrashed()->where('staff_id',$staff_id)->delete();
                    $delete = Staff::withTrashed()->where('id',$staff_id)->forceDelete();
                }
            }

            // $delete = Familia::where('representante_id',$usuario->id)->forceDelete();

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
            $delete = VencimientoClaseGrupal::where('usuario_id', $usuario->id)->forceDelete();
            $delete = UsuarioTipo::where('usuario_id', $usuario->id)->delete();
            
            if($usuario->delete()){
                return response()->json(['mensaje' => '¡Excelente! El usuario ha sido eliminado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
            }
        }else{
            return response()->json(['mensaje' => '¡Excelente! El usuario ha sido eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }
    }
}
