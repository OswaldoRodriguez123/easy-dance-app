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

    public function principal()
    {
        $incidencias = Incidencia::join('staff', 'incidencias.staff_id', '=', 'staff.id')
            ->select('incidencias.*', 'staff.nombre', 'staff.apellido')
            ->where('incidencias.academia_id' , Auth::user()->academia_id)
        ->get();

        return view('incidencia.principal')->with('incidencias', $incidencias);
    }

    public function createconid($id)
    {
        $staff = Staff::find($id);

        return view('incidencia.create')->with('staff', $staff);
    }

    public function create()
    {
        $staff = Staff::where('academia_id' , Auth::user()->academia_id)->get();

        return view('incidencia.create')->with('staffs', $staff);
    }


    public function store(Request $request)
    {

        $rules = [
            'staff_id' => 'required',
            'fecha' => 'required',
            'mensaje' => 'required',
        ];

        $messages = [
            'staff_id.required' => 'Ups! El staff es requerido',
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

        $incidencia = Incidencia::join('staff', 'incidencias.staff_id', '=', 'staff.id')
            ->where('incidencias.id', '=' , $id)
        ->first();

        if($incidencia){

            return view('incidencia.planilla')->with(['incidencia' => $incidencia]);

        }else{
           return redirect("inicio"); 
        }

    }


    public function destroy($id)
    {

        $incidencia = Incidencia::find($id);
        
        if($incidencia->delete()){
            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno");
    }


}