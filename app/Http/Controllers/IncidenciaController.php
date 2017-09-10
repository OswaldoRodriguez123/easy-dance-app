<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Academia;
use App\User;
use Validator;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Incidencia;
use App\Staff;
use App\Instructor;
use App\Gravedad;
use App\Notificacion;
use App\NotificacionUsuario;
use DB;

class IncidenciaController extends BaseController {

    public function principal()
    {
        $datos = $this->getDatosUsuario();
        $usuario_tipo = $datos[0]['usuario_tipo'];
        $usuario_id = $datos[0]['usuario_id'];

        if($usuario_tipo == 1 OR $usuario_tipo == 5 OR $usuario_tipo == 6){

            $incidencias = Incidencia::join('gravedades', 'incidencias.gravedad_id', '=', 'gravedades.id')
                ->select('incidencias.*', 'gravedades.nombre as gravedad')
                ->where('academia_id' , Auth::user()->academia_id)
            ->get();

        }else{

            if($usuario_tipo == 8){
                $usuario_tipo = 1;
            }else{
                $usuario_tipo = 2;
            }

            $incidencias = Incidencia::join('gravedades', 'incidencias.gravedad_id', '=', 'gravedades.id')
                ->select('incidencias.*', 'gravedades.nombre as gravedad')
                ->where('usuario_tipo' , $usuario_tipo)
                ->where('usuario_id' , $usuario_id)
            ->get();
        }

        $array = array();

        foreach($incidencias as $incidencia){

            $administrador = User::find($incidencia->administrador_id);

            if($administrador){
                $administrador = $administrador->nombre . ' '. $administrador->apellido;
            }else{
                $administrador = '';
            }

            if($incidencia->usuario_tipo == 1){
                $usuario = Staff::find($incidencia->usuario_id);
            }else{
                $usuario = Instructor::find($incidencia->usuario_id);
            }

            if($usuario){
                $usuario = $usuario->nombre . ' '. $usuario->apellido;
            }else{
                $usuario = '';
            }

            $collection=collect($incidencia);     
            $incidencia_array = $collection->toArray();
            $incidencia_array['administrador']=$administrador;
            $incidencia_array['usuario']=$usuario;
            $array[$incidencia->id] = $incidencia_array;

        }

        return view('incidencia.principal')->with('incidencias', $array);
    }

    public function createconid($id)
    {
        $staff = Staff::find($id);

        return view('incidencia.create')->with('staff', $staff);
    }

    public function create()
    {
        $usuarios = array();

        $staffs = Staff::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

        foreach($staffs as $staff){

            $collection=collect($staff);     
            $usuario_array = $collection->toArray();

            $usuario_array['tipo']=1;
            $usuario_array['id']='1-'.$staff->id;
            $usuario_array['icono']="<i class='icon_f-staff'></i>";
            $usuarios['1-'.$staff->id] = $usuario_array;
        }

        $instructores = Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

        foreach($instructores as $instructor)
        {
            $collection=collect($instructor);     
            $usuario_array = $collection->toArray();

            $usuario_array['tipo']=2;
            $usuario_array['id']='2-'.$instructor->id;
            $usuario_array['icono']="<i class='icon_a-instructor'></i>";
            $usuarios['2-'.$instructor->id] = $usuario_array;
        }

        $gravedades = Gravedad::orderBy('nombre')->get();

        return view('incidencia.create')->with(['usuarios' => $usuarios, 'gravedades' => $gravedades]);
    }


    public function store(Request $request)
    {

        $rules = [
            'usuario_id' => 'required',
            'gravedad_id' => 'required',
            'fecha' => 'required',
            'mensaje' => 'required',
        ];

        $messages = [
            'usuario_id.required' => 'Ups! El usuario es requerido',
            'gravedad_id.required' => 'Ups! El nivel es requerido',
            'fecha.required' => 'Ups! La Fecha es requerida',
            'mensaje.required' => 'Ups! La incidencia es requerida',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha)->toDateString();

            $explode = explode('-',$request->usuario_id);
            $usuario_tipo = $explode[0];
            $usuario_id = $explode[1];

            $incidencia = new Incidencia;

            $incidencia->academia_id = Auth::user()->academia_id;
            $incidencia->usuario_tipo = $usuario_tipo;
            $incidencia->usuario_id = $usuario_id;
            $incidencia->gravedad_id = $request->gravedad_id;
            $incidencia->administrador_id = Auth::user()->id;
            $incidencia->fecha = $fecha;
            $incidencia->mensaje = $request->mensaje;

            if($incidencia->save()){

                if($usuario_tipo == 1){
                    $usuario_tipo = 8;
                }else{
                    $usuario_tipo = 3;
                }

                $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                    ->select('users.id')
                    ->where('usuarios_tipo.tipo',$usuario_tipo)
                    ->where('usuarios_tipo.tipo_id',$usuario_id)
                ->first();

                if($usuario){

                    $notificacion = new Notificacion; 

                    $notificacion->tipo_evento = 7;
                    $notificacion->evento_id = $incidencia->id;
                    $notificacion->mensaje = "Has recibido una nueva incidencia";
                    $notificacion->titulo = "Nueva Incidencia";

                    if($notificacion->save()){

                        $usuarios_notificados = new NotificacionUsuario;
                        $usuarios_notificados->id_usuario = $usuario->id;
                        $usuarios_notificados->id_notificacion = $notificacion->id;
                        $usuarios_notificados->visto = 0;
                        $usuarios_notificados->save();
                    }

                }

                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
            }

        }
    }

    public function planilla($id)
    {

        $incidencia = Incidencia::join('gravedades', 'incidencias.gravedad_id', '=', 'gravedades.id')
            ->select('incidencias.*', 'gravedades.nombre as gravedad')
            ->where('incidencias.id', '=' , $id)
        ->first();

        if($incidencia){
            
            $administrador = User::find($incidencia->administrador_id);

            if($administrador){
                $administrador = $administrador->nombre . ' '. $administrador->apellido;
            }else{
                $administrador = '';
            }

            if($incidencia->usuario_tipo == 1){
                $usuario = Staff::find($incidencia->usuario_id);
            }else{
                $usuario = Instructor::find($incidencia->usuario_id);
            }

            if($usuario){
                $usuario = $usuario->nombre . ' '. $usuario->apellido;
            }else{
                $usuario = '';
            }

            $usuarios = array();

            $staffs = Staff::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

            foreach($staffs as $staff){

                $collection=collect($staff);     
                $usuario_array = $collection->toArray();

                $usuario_array['tipo']=1;
                $usuario_array['id']='1-'.$staff->id;
                $usuario_array['icono']="<i class='icon_f-staff'></i>";
                $usuarios['1-'.$staff->id] = $usuario_array;
            }

            $instructores = Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

            foreach($instructores as $instructor)
            {
                $collection=collect($instructor);     
                $usuario_array = $collection->toArray();

                $usuario_array['tipo']=2;
                $usuario_array['id']='2-'.$instructor->id;
                $usuario_array['icono']="<i class='icon_a-instructor'></i>";
                $usuarios['2-'.$instructor->id] = $usuario_array;
            }

            $gravedades = Gravedad::orderBy('nombre')->get();

             return view('incidencia.planilla')->with(['incidencia' => $incidencia, 'usuario' => $usuario, 'administrador' => $administrador, 'gravedades' => $gravedades, 'instructores_staffs'=> $usuarios, 'id' => $id]);

        }else{
            return redirect("inicio"); 
        }

    }

    public function visualizar($id){

        $incidencia = Incidencia::join('gravedades', 'incidencias.gravedad_id', '=', 'gravedades.id')
            ->select('incidencias.*', 'gravedades.nombre as gravedad')
            ->where('incidencias.id', '=' , $id)
        ->first();

        if($incidencia){

            $administrador = User::find($incidencia->administrador_id);

            if($incidencia->usuario_tipo == 1){
                $usuario = Staff::find($incidencia->usuario_id);
            }else{
                $usuario = Instructor::find($incidencia->usuario_id);
            }

            $fecha = Carbon::createFromFormat('Y-m-d',$incidencia->fecha)->format('d-m-Y');
            $hora = Carbon::createFromFormat('Y-m-d H:i:s',$incidencia->created_at)->format('H:i:s');

            $academia = Academia::find(Auth::user()->academia_id);

            return view('incidencia.incidencia')->with(['incidencia' => $incidencia, 'usuario' => $usuario, 'administrador' => $administrador, 'fecha' => $fecha, 'hora'=> $hora, 'academia' => $academia]);

        }else{
            return redirect("inicio"); 
        }

    }

    public function updateUsuario(Request $request){

        $rules = [

            'usuario_id' => 'required',
        ];

        $messages = [

            'usuario_id.required' => 'Ups! El usuario es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
        }

        $explode = explode('-',$request->usuario_id);
        $usuario_tipo = $explode[0];
        $usuario_id = $explode[1];

        $incidencia = Incidencia::find($request->id);
        $incidencia->usuario_id = $usuario_id;
        $incidencia->usuario_tipo = $usuario_tipo;

        if($incidencia->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

    public function updateGravedad(Request $request){

        $rules = [

            'gravedad_id' => 'required',
        ];

        $messages = [

            'gravedad_id.required' => 'Ups! El nivel es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
        }

        $incidencia = Incidencia::find($request->id);
        $incidencia->gravedad_id = $request->gravedad_id;

        if($incidencia->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

    public function updateFecha(Request $request){

        $rules = [

            'fecha' => 'required',
        ];

        $messages = [

            'fecha.required' => 'Ups! La fecha es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
        }

        $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha)->toDateString();

        $incidencia = Incidencia::find($request->id);
        $incidencia->fecha = $fecha;

        if($incidencia->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

    public function updateMensaje(Request $request){

        $rules = [

            'mensaje' => 'required',
        ];

        $messages = [

            'mensaje.required' => 'Ups! La incidencia es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
        }

        $incidencia = Incidencia::find($request->id);
        $incidencia->mensaje = $request->mensaje;

        if($incidencia->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }


    public function destroy(Request $request)
    {
        $academia = Academia::find(Auth::user()->academia_id);

        if($academia->password_supervision){
            if(!Hash::check($request->password_supervision, $academia->password_supervision)) {
                return response()->json(['error_mensaje'=> 'Ups! La contraseña no coincide', 'status' => 'ERROR-PASSWORD'],422);
            }
        }
        
        $incidencia = Incidencia::find($request->id);

        if($incidencia->delete()){

            $notificacion = Notificacion::where('tipo_evento',7)->where('evento_id',$request->id)->first();
            if($notificacion){
                $notificacion_usuario = NotificacionUsuario::where('id_notificacion',$notificacion->id)->delete();
                $notificacion->delete();
            }
            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        
    }
}