<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Cita;
use App\Alumno;
use App\Instructor;
use Carbon\Carbon;
use Validator;
use DB;
use Mail;
use Session;
use Illuminate\Support\Facades\Auth;

class CitaController extends BaseController {

	public function principal(Request $request){

        $citas = DB::table('citas')
            ->join('alumnos', 'citas.alumno_id', '=', 'alumnos.id')
            ->join('instructores', 'citas.instructor_id', '=', 'instructores.id')
            ->join('config_citas', 'citas.tipo_id', '=', 'config_citas.id')
            ->select('alumnos.nombre as alumno_nombre', 'alumnos.apellido as alumno_apellido', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','citas.hora_inicio','citas.hora_final', 'citas.id', 'citas.fecha', 'citas.tipo_id', 'config_citas.nombre as tipo_nombre')
            ->where('citas.academia_id','=', Auth::user()->academia_id)
        ->get();

    	return view('agendar.cita.principal')->with(['citas' => $citas]);
 	}

	public function create()
    {

        return view('agendar.cita.create')->with([ 'alumnos' => Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'instructoresacademia' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get()]);
    }

    public function store(Request $request)
    {

    $rules = [
        'alumno_id' => 'required',
        'fecha' => 'required',
        'hora_inicio' => 'required',
        'hora_final' => 'required',
        'tipo_id' => 'required',
        'instructor_id' => 'required',
    ];

    $messages = [

        'alumno_id.required' => 'Ups! El Cliente  es requerido',
        'fecha.required' => 'Ups! La fecha es requerida',
        'hora_inicio.required' => 'Ups! La hora de inicio es requerida',
        'hora_final.required' => 'Ups! La hora final es requerida',
        'tipo_id.required' => 'Ups! El tipo es requerido',
        'instructor_id.required' => 'Ups! El instructor es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);

        if($fecha < Carbon::now()){

            return response()->json(['errores' => ['fecha' => [0, 'Ups! ha ocurrido un error. La fecha de inicio no puede ser menor al dia de hoy']], 'status' => 'ERROR'],422);
        }

        $fecha = $fecha->toDateString();

        $hora_inicio = strtotime($request->hora_inicio);
        $hora_final = strtotime($request->hora_final);

        if($hora_inicio > $hora_final)
        {

            return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
        }

        $cita = new Cita;
        
        $cita->academia_id = Auth::user()->academia_id;
        $cita->alumno_id = $request->alumno_id;
        $cita->fecha = $fecha;
        $cita->tipo_id = $request->tipo_id;
        $cita->instructor_id = $request->instructor_id;
        $cita->hora_inicio = $request->hora_inicio;
        $cita->hora_final = $request->hora_final;

        if($cita->save()){
        	return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
   	}
   }

   public function edit($id)
    {

        $find = Cita::find($id);

        if($find){

            $cita = DB::table('citas')
                ->join('config_citas', 'citas.tipo_id', '=', 'config_citas.id')
                ->join('alumnos', 'citas.alumno_id', '=', 'alumnos.id')
                ->join('instructores', 'citas.instructor_id', '=', 'instructores.id')
                ->select('alumnos.nombre as alumno_nombre', 'alumnos.apellido as alumno_apellido', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','config_citas.nombre as tipo_nombre', 'citas.fecha', 'citas.hora_inicio','citas.hora_final', 'citas.id')
                ->where('citas.id', '=', $id)
                ->first();

                //dd($clase_grupal_join);

            return view('agendar.cita.planilla')->with(['alumnosacademia' => Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'instructoresacademia' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'cita' => $cita]);

        }else{
           return redirect("agendar/citas"); 
        }

    }

    public function updateAlumno(Request $request){
        $cita = Cita::find($request->id);
        $cita->alumno_id = $request->alumno_id;

        if($cita->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateInstructor(Request $request){
        $cita = Cita::find($request->id);
        $cita->instructor_id = $request->instructor_id;

        if($cita->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateTipo(Request $request){
        $cita = Cita::find($request->id);
        $cita->tipo_id = $request->tipo_id;

        if($cita->save()){
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

    else{

            
        $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);

        if($fecha < Carbon::now()){

            return response()->json(['errores' => ['fecha' => [0, 'Ups! ha ocurrido un error. La fecha no puede ser menor al dia de hoy']], 'status' => 'ERROR'],422);
        }

        $fecha = $fecha->toDateString();

        $cita = Cita::find($request->id);

        $cita->fecha = $fecha;

        if($cita->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateHorario(Request $request){

    $rules = [
        'hora_inicio' => 'required',
        'hora_final' => 'required',
    ];

    $messages = [

        'hora_inicio.required' => 'Ups! La hora de inicio es requerida',
        'hora_final.required' => 'Ups! La hora final es requerida',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $hora_inicio = strtotime($request->hora_inicio);
        $hora_final = strtotime($request->hora_final);

        if($hora_inicio > $hora_final)
        {

            return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
        }

        $cita = Cita::find($request->id);

        $cita->hora_inicio = $request->hora_inicio;
        $cita->hora_final = $request->hora_final;

        if($cita->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function operar($id)
    {   
        $cita = Cita::find($id);

        return view('agendar.fiesta.operacion')->with(['id' => $id , 'cita' => $cita]);       
    }

    public function destroy($id)
    {
        $cita = Cita::find($id);
        
        if($cita->delete()){
            return response()->json(['mensaje' => '¡Excelente! La Cita se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }


}