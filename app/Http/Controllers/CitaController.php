<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Cita;
use App\ConfigCitas;
use App\Academia;
use App\Alumno;
use App\Instructor;
use App\Asistencia;
use App\LlamadaAlumno;
use App\InscripcionClaseGrupal;
use App\User;
use App\Notificacion;
use App\NotificacionUsuario;
use App\ItemsFacturaProforma;
use Carbon\Carbon;
use Validator;
use DB;
use Mail;
use Session;
use Illuminate\Support\Facades\Auth;
use PulkitJalan\GeoIP\GeoIP;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class CitaController extends BaseController {

	public function calendario(Request $request){

        $citas = Cita::join('alumnos', 'citas.alumno_id', '=', 'alumnos.id')
            ->leftJoin('instructores', 'citas.instructor_id', '=', 'instructores.id')
            ->join('config_citas', 'citas.tipo_id', '=', 'config_citas.id')
            ->select('alumnos.nombre as alumno_nombre', 'alumnos.apellido as alumno_apellido', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','citas.hora_inicio','citas.hora_final', 'citas.id', 'citas.fecha', 'citas.tipo_id', 'config_citas.nombre as tipo_nombre', 'citas.color_etiqueta')
            ->where('citas.academia_id','=', Auth::user()->academia_id)
            ->where('citas.estatus','=','1')
        ->get();

    	return view('agendar.cita.calendario')->with(['citas' => $citas]);
 	}

    public function principal(Request $request){


        $fechaActual = Carbon::now();

        $activas = Cita::where('estatus', 1)->where('academia_id','=', Auth::user()->academia_id)->get();

        foreach($activas as $activa){
            $fecha_inicio = Carbon::createFromFormat('Y-m-d', $activa->fecha);
            if($fecha_inicio <= $fechaActual->format('Y-m-d')){

                if($fecha_inicio < $fechaActual->format('Y-m-d')){
                    $activa->estatus = 2;
                    $activa->save();
                }else{

                    $hora_final = Carbon::createFromFormat('H:i:s', $activa->hora_final);

                    if($hora_final <= $fechaActual->format('H:i:s')){
                        $activa->estatus = 2;
                        $activa->save();
                    }

                }
            }
        }

        $citas = Cita::join('alumnos', 'citas.alumno_id', '=', 'alumnos.id')
            ->leftJoin('instructores', 'citas.instructor_id', '=', 'instructores.id')
            ->join('config_citas', 'citas.tipo_id', '=', 'config_citas.id')
            ->select('citas.*','alumnos.nombre as alumno_nombre', 'alumnos.apellido as alumno_apellido', 'alumnos.sexo', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'config_citas.nombre as tipo_nombre', 'alumnos.fecha_nacimiento', 'alumnos.id as alumno_id', 'alumnos.celular','alumnos.correo')
            ->where('citas.academia_id','=', Auth::user()->academia_id)
        ->get();

        $in = array(2,4);
        $array = array();

        foreach($citas as $cita){

            $edad = Carbon::createFromFormat('Y-m-d', $cita->fecha_nacimiento)->diff(Carbon::now())->format('%y');
            $llamadas = LlamadaAlumno::where('usuario_id',$cita->alumno_id)->where('usuario_tipo',2)->count();

            $inscripcion_clase_grupal = InscripcionClaseGrupal::where('alumno_id',$cita->alumno_id)->first();

            if($inscripcion_clase_grupal){
                if($inscripcion_clase_grupal->tipo_pago == 1){
                    $tipo_pago = 'Contado';
                }else if($inscripcion_clase_grupal->tipo_pago == 2){
                    $tipo_pago = 'Credito';
                }else{
                    $tipo_pago = 'Sin Confirmar';
                }

            }else{
                $tipo_pago = 'Contado';
            }

            $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->where('usuarios_tipo.tipo_id',$cita->alumno_id)
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

            $deuda = ItemsFacturaProforma::where('fecha_vencimiento','<=',Carbon::today())
                ->where('usuario_id','=',$cita->alumno_id)
                ->where('usuario_tipo','=',1)
            ->sum('importe_neto');

            $collection=collect($cita);     
            $cita_array = $collection->toArray();
            $cita_array['edad']=$edad;
            $cita_array['llamadas']=$llamadas;
            $cita_array['tipo_pago']=$tipo_pago;
            $cita_array['imagen']=$imagen;
            $cita_array['deuda']=$deuda;
            $array[$cita->id] = $cita_array;
        }

        $asistencias = Asistencia::where('tipo', '4')->where('academia_id', Auth::user()->academia_id)->get();

        $collection=collect($asistencias);
        $grouped = $collection->groupBy('tipo_id');     
        $asistencias = $grouped->toArray();

        return view('agendar.cita.principal')->with(['citas' => $array, 'asistencias' => $asistencias]);
    }

    public function operar($id){

        $cita = Cita::join('alumnos', 'citas.alumno_id', '=', 'alumnos.id')
            ->leftJoin('instructores', 'citas.instructor_id', '=', 'instructores.id')
            ->join('config_citas', 'citas.tipo_id', '=', 'config_citas.id')
            ->select('alumnos.nombre as alumno_nombre', 'alumnos.apellido as alumno_apellido', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','citas.hora_inicio','citas.hora_final', 'citas.id', 'citas.fecha', 'citas.tipo_id', 'config_citas.nombre as tipo_nombre', 'citas.color_etiqueta')
            ->where('citas.id','=', $id)
        ->first();

        return view('agendar.cita.operacion')->with(['cita' => $cita, 'id' => $id]);
    }

	public function create()
    {

        return view('agendar.cita.create')->with([ 'alumnos' => Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get(), 'instructoresacademia' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'config_citas' => ConfigCitas::all()]);
    }

    public function store(Request $request){

        $rules = [
            'alumno_id' => 'required',
            'fecha' => 'required',
            'hora_inicio' => 'required',
            'hora_final' => 'required',
            'tipo_id' => 'required',
            'instructor_id' => 'required',
        ];

        $messages = [

            'alumno_id.required' => 'Ups! El Cliente es requerido',
            'fecha.required' => 'Ups! La fecha es requerida',
            'hora_inicio.required' => 'Ups! La hora de inicio es requerida',
            'hora_final.required' => 'Ups! La hora final es requerida',
            'tipo_id.required' => 'Ups! El tipo es requerido',
            'instructor_id.required' => 'Ups! El instructor es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{

            $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);

            if($fecha < Carbon::now()){

                return response()->json(['errores' => ['fecha' => [0, 'Ups! ha ocurrido un error. La fecha de inicio no puede ser menor al dia de hoy']], 'status' => 'ERROR'],422);
            }

            $fecha = $fecha->toDateString();

            $academia = Academia::find(Auth::user()->academia_id);

            if($academia->tipo_horario == 2){
                $hora_inicio = Carbon::createFromFormat('H:i',$request->hora_inicio)->toTimeString();
                $hora_final = Carbon::createFromFormat('H:i',$request->hora_final)->toTimeString();
            }else{
                $hora_inicio = Carbon::createFromFormat('H:i a',$request->hora_inicio)->toTimeString();
                $hora_final = Carbon::createFromFormat('H:i a',$request->hora_final)->toTimeString();
            }

            if($hora_inicio > $hora_final){
                return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
            }

            $boolean_mostrar = Session::get('boolean_mostrar');
            if(!$boolean_mostrar){
                $boolean_mostrar = 1;
            }

            $cita = new Cita;
            
            $cita->academia_id = Auth::user()->academia_id;
            $cita->alumno_id = $request->alumno_id;
            $cita->fecha = $fecha;
            $cita->tipo_id = $request->tipo_id;
            $cita->instructor_id = $request->instructor_id;
            $cita->hora_inicio = $hora_inicio;
            $cita->hora_final = $hora_final;
            $cita->color_etiqueta = $request->color_etiqueta;
            $cita->boolean_mostrar = $boolean_mostrar;
            $cita->observacion = $request->observacion;

            if($cita->save()){

                $in = array(2,4);

                $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                    ->select('users.id')
                    ->whereIn('usuarios_tipo.tipo',$in)
                    ->where('usuarios_tipo.tipo_id', '=',$request->alumno_id)
                ->first();
                
                if($usuario){

                    $notificacion = new Notificacion; 

                    $notificacion->tipo_evento = 4;
                    $notificacion->evento_id = Auth::user()->academia_id;
                    $notificacion->mensaje = "Tu academia te ha asignado una cita";
                    $notificacion->titulo = "Nueva Cita";

                    if($notificacion->save()){
                        $usuarios_notificados = new NotificacionUsuario;
                        $usuarios_notificados->id_usuario = $usuario->id;
                        $usuarios_notificados->id_notificacion = $notificacion->id;
                        $usuarios_notificados->visto = 0;
                        $usuarios_notificados->save();
                    }
                }

                $instructor = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                        ->select('users.id')
                        ->where('usuarios_tipo.tipo',3)    
                        ->where('usuarios_tipo.tipo_id',$request->instructor_id) 
                    ->first();

                if($instructor){

                    $notificacion = new Notificacion; 

                    $notificacion->tipo_evento = 4;
                    $notificacion->evento_id = Auth::user()->academia_id;
                    $notificacion->mensaje = "Tu academia te ha asignado una cita";
                    $notificacion->titulo = "Nueva Cita";

                    if($notificacion->save()){

                        $usuarios_notificados = new NotificacionUsuario;
                        $usuarios_notificados->id_usuario = $instructor->id;
                        $usuarios_notificados->id_notificacion = $notificacion->id;
                        $usuarios_notificados->visto = 0;
                        $usuarios_notificados->save();
                    }
                }

                $academia = Academia::find(Auth::user()->academia_id);
                $alumno = Alumno::find($request->alumno_id);
                $instructor = Instructor::find($request->instructor_id);

                if($alumno && $instructor){

                    if($cita->boolean_mostrar == 1){

                        if($academia->correo){

                            $subj = 'Han reservado una Cita';

                            $array = [
                               'nombre_instructor' => $instructor->nombre,
                               'apellido_instructor' => $instructor->apellido,
                               'correo' => $academia->correo,
                               'academia' => $academia->nombre,
                               'nombre_alumno' => $alumno->nombre,
                               'apellido_alumno' => $alumno->apellido,
                               'cedula' => $alumno->identificacion,
                               'hora_inicio' => $request->hora_inicio,
                               'hora_final' => $request->hora_final,
                               'fecha' => $fecha,
                               'subj' => $subj
                            ];

                            Mail::send('correo.cita_academia', $array, function($msj) use ($array){
                                    $msj->subject($array['subj']);
                                    $msj->to($array['correo']);
                            });
                        }

                        if($alumno->correo){

                            $subj2 = 'Has reservado una Cita';

                            $array2 = [
                               'nombre_instructor' => $instructor->nombre,
                               'apellido_instructor' => $instructor->apellido,
                               'correo' => $alumno->correo,
                               'academia' => $academia->nombre,
                               'nombre_alumno' => $alumno->nombre,
                               'hora_inicio' => $request->hora_inicio,
                               'hora_final' => $request->hora_final,
                               'fecha' => $fecha,
                               'subj' => $subj2
                            ];

                            Mail::send('correo.cita_alumno', $array2, function($msj) use ($array2){
                                    $msj->subject($array2['subj']);
                                    $msj->to($array2['correo']);
                            });
                        }

                    }

                    if($alumno->celular){

                        $celular = getLimpiarNumero($alumno->celular);

                        if($academia->pais_id == 11 && strlen($celular) == 10){
                            
                            $mensaje = $alumno->nombre.'. Hemos creado una cita para la fecha '.$fecha.'  a las  '.$request->hora_inicio.'  con el profesor '.$instructor->nombre.' '.$instructor->apellido.', te esperamos. ??Nos encanta verte bailar!.';

                            $client = new Client();
                            $result = $client->get('https://sistemasmasivos.com/c3colombia/api/sendsms/send.php?user=coliseodelasalsa@gmail.com&password=k1-9L6A1rn&GSM='.$celular.'&SMSText='.urlencode($mensaje));

                        }

                    }

                }

                Session::forget('boolean_mostrar');
            	return response()->json(['mensaje' => '??Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
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
                ->leftJoin('instructores', 'citas.instructor_id', '=', 'instructores.id')
                ->select('citas.*', 'alumnos.nombre as alumno_nombre', 'alumnos.apellido as alumno_apellido', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','config_citas.nombre as tipo_nombre')
                ->where('citas.id', '=', $id)
                ->first();

                //dd($clase_grupal_join);

            return view('agendar.cita.planilla')->with(['alumnosacademia' => Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'instructoresacademia' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'cita' => $cita, 'config_citas' => ConfigCitas::all()]);

        }else{
           return redirect("agendar/citas"); 
        }

    }

    public function updateAlumno(Request $request){
        $cita = Cita::find($request->id);
        $cita->alumno_id = $request->alumno_id;

        if($cita->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateInstructor(Request $request){
        $cita = Cita::find($request->id);
        $cita->instructor_id = $request->instructor_id;

        if($cita->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEtiqueta(Request $request){
        $cita = Cita::find($request->id);
        $cita->color_etiqueta = $request->color_etiqueta;

        if($cita->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    public function updateTipo(Request $request){
        $cita = Cita::find($request->id);
        $cita->tipo_id = $request->tipo_id;

        if($cita->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
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
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
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

            $academia = Academia::find(Auth::user()->academia_id);

            if($academia->tipo_horario == 2){
                $hora_inicio = Carbon::createFromFormat('H:i',$request->hora_inicio)->toTimeString();
                $hora_final = Carbon::createFromFormat('H:i',$request->hora_final)->toTimeString();
            }else{
                $hora_inicio = Carbon::createFromFormat('H:i a',$request->hora_inicio)->toTimeString();
                $hora_final = Carbon::createFromFormat('H:i a',$request->hora_final)->toTimeString();
            }

            if($hora_inicio > $hora_final){
                return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
            }

            $cita = Cita::find($request->id);

            $cita->hora_inicio = $hora_inicio;
            $cita->hora_final = $hora_final;

            if($cita->save()){
                return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateObservacion(Request $request){
        $cita = Cita::find($request->id);
        $cita->observacion = $request->observacion;

        if($cita->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function destroy($id)
    {
        $cita = Cita::find($id);
        
        if($cita->delete()){
            $notificacion = Notificacion::where('tipo_evento',4)->where('evento_id',$id)->first();
            if($notificacion){
                $notificacion_usuario = NotificacionUsuario::where('id_notificacion',$notificacion->id)->delete();
                $notificacion->delete();
            }
            return response()->json(['mensaje' => '??Excelente! La Cita se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }


}