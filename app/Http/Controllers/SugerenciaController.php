<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Sugerencia;
use App\Notificacion;
use App\Instructor;
use App\NotificacionUsuario;
use DB;

class SugerenciaController extends BaseController {

    public function instructor(){

        $usuarios = Instructor::where('academia_id', Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

        $usuarios = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
            ->select('users.*')
            ->where('usuarios_tipo.tipo',3)
            ->where('users.academia_id', Auth::user()->academia_id)
            ->orderBy('users.nombre', 'asc')
            ->distinct('users.id')
        ->get();

        return view('sugerencia.create')->with(['usuarios' => $usuarios, 'tipo' => 1]);
    }

    public function recepcion(){

        $in = array(1,5,6);

        $usuarios = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
            ->select('users.*')
            ->whereIn('usuarios_tipo.tipo',$in)
            ->where('users.academia_id', Auth::user()->academia_id)
            ->orderBy('users.nombre', 'asc')
            ->distinct('users.id')
        ->get();

        return view('sugerencia.create')->with(['usuarios' => $usuarios, 'tipo' => 2]);
    }


    public function store(Request $request)
    {

        $rules = [
            'id' => 'required',
            'mensaje' => 'required',
        ];

        $messages = [
            'id.required' => 'Ups! El Usuario es requerido',
            'mensaje.required' => 'Ups! El mensaje es requerido',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $sugerencia = new Sugerencia;

            $sugerencia->usuario_id = Auth::user()->id;
            $sugerencia->fecha = Carbon::now();
            $sugerencia->mensaje = $request->mensaje;
            $sugerencia->academia_id = Auth::user()->academia_id;

            if($sugerencia->save()){

                $usuario = User::find(Auth::user()->id);

                $notificacion = new Notificacion; 

                $notificacion->tipo_evento = 5;
                $notificacion->evento_id = $sugerencia->id;
                $notificacion->mensaje = $usuario->nombre . " " . $usuario->apellido . " ha creado una nueva consulta";
                $notificacion->titulo = "Nueva Sugerencia";

                if($notificacion->save()){

                    $usuarios_notificados = new NotificacionUsuario;
                    $usuarios_notificados->id_usuario = $request->id;
                    $usuarios_notificados->id_notificacion = $notificacion->id;
                    $usuarios_notificados->visto = 0;
                    $usuarios_notificados->save();

                }

                return response()->json(['mensaje' => '¡Excelente! La consulta ha sido enviada satisfactoriamente', 'status' => 'OK', 200]);

            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
            }

        }
    }

    public function planilla($id)
    {

        $sugerencia = Sugerencia::join('users', 'sugerencias.usuario_id', '=', 'users.id')
            ->select('sugerencias.*', 'users.nombre as nombre', 'users.apellido as apellido')
            ->where('sugerencias.id', '=' , $id)
        ->first();

        if($sugerencia){

            return view('sugerencia.planilla')->with(['sugerencia' => $sugerencia]);

        }else{
           return redirect("inicio"); 
        }

    }


}