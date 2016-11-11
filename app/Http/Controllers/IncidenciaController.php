<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Incidencia;
use App\Staff;
use App\Notificacion;
use App\NotificacionUsuario;
use DB;

class IncidenciaController extends BaseController {


    public function create($id)
    {
        $staff = Staff::find($id);

        return view('incidencia.create')->with('staff', $staff);
    }


    public function store(Request $request)
    {

        $rules = [
            'fecha' => 'required',
            'mensaje' => 'required',
        ];

        $messages = [
            'fecha.required' => 'Ups! La fecha es requerida',
            'mensaje.required' => 'Ups! El mensaje es requerido',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha)->toDateString();

            $incidencia = new Incidencia;

            $incidencia->usuario_id = Auth::user()->id;
            $incidencia->fecha = $fecha;
            $incidencia->mensaje = $request->mensaje;
            $incidencia->academia_id = Auth::user()->academia_id;
            $incidencia->staff_id = $request->staff_id;

            if($incidencia->save()){

                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

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