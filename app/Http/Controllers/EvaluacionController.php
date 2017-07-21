<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;

use App\Http\Requests;
use App\ItemsExamenes;
use App\Evaluacion;
use App\User;
use App\Familia;
use App\DetalleEvaluacion;
use App\Examen;
use App\Notificacion;
use App\NotificacionUsuario;
use App\ConfigFormulaExito;
use App\FormulaEvaluacion;
use Validator;
use DB;
use Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EvaluacionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_evaluacion=Session::get('id_evaluar');
        $evaluacion_join = DB::table('evaluaciones')
            ->join('instructores', 'evaluaciones.instructor_id', '=', 'instructores.id')
            ->join('alumnos','evaluaciones.alumno_id','=','alumnos.id')
            ->join('examenes','evaluaciones.examen_id','=','examenes.id')
            ->select('evaluaciones.id as id' , 'examenes.nombre as nombreExamen', 'evaluaciones.created_at as fecha', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id','alumnos.nombre as alumno_nombre','alumnos.apellido as alumno_apellido','evaluaciones.total as nota_total','alumnos.identificacion', 'alumnos.id as alumno_id')
            ->where('evaluaciones.academia_id', '=' ,  Auth::user()->academia_id)
        ->get();

        $array = array(2, 4);

        $alumnoc = User::join('alumnos', 'alumnos.id', '=', 'users.usuario_id')
            ->join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
            ->select('alumnos.id as id')
            ->where('users.academia_id','=', Auth::user()->academia_id)
            ->where('alumnos.deleted_at', '=', null)
            ->whereIn('usuarios_tipo.tipo', $array)
            ->where('users.confirmation_token', '!=', null)
        ->get();

        $collection=collect($alumnoc);
        $grouped = $collection->groupBy('id');     
        $activacion = $grouped->toArray();

        $usuario_tipo = Session::get('easydance_usuario_tipo');

        return view('especiales.evaluaciones.principal')->with(['evaluacion' => $evaluacion_join,'id_evaluacion'=>$id_evaluacion, 'activacion' => $activacion, 'usuario_tipo' => $usuario_tipo]);
    }

    public function evaluaciones($id)
    {
        $evaluacion_join = DB::table('evaluaciones')
            ->join('instructores', 'evaluaciones.instructor_id', '=', 'instructores.id')
            ->join('alumnos','evaluaciones.alumno_id','=','alumnos.id')
            ->join('examenes','evaluaciones.examen_id','=','examenes.id')
            ->select('evaluaciones.id as id' , 'examenes.nombre as nombreExamen', 'evaluaciones.created_at as fecha', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id','alumnos.nombre as alumno_nombre','alumnos.apellido as alumno_apellido','evaluaciones.total as nota_total','alumnos.identificacion', 'alumnos.id as alumno_id')
            ->where('evaluaciones.examen_id', '=' , $id)
        ->get();


        $array = array(2, 4);

        $alumnoc = User::join('alumnos', 'alumnos.id', '=', 'users.usuario_id')
            ->join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
            ->select('alumnos.id as id')
            ->where('users.academia_id','=', Auth::user()->academia_id)
            ->where('alumnos.deleted_at', '=', null)
            ->whereIn('usuarios_tipo.tipo', $array)
            ->where('users.confirmation_token', '!=', null)
        ->get();

        $collection=collect($alumnoc);
        $grouped = $collection->groupBy('id');     
        $activacion = $grouped->toArray();

        $usuario_tipo = Session::get('easydance_usuario_tipo');

        return view('especiales.evaluaciones.principal')->with(['evaluacion' => $evaluacion_join,'id_evaluacion'=>$id, 'activacion' => $activacion, 'usuario_tipo' => $usuario_tipo]);
    }

    public function evaluaciones_vista_alumno()
    {
        $usuario_id = Session::get('easydance_usuario_id');

        $evaluacion_join = DB::table('evaluaciones')
            ->join('instructores', 'evaluaciones.instructor_id', '=', 'instructores.id')
            ->join('alumnos','evaluaciones.alumno_id','=','alumnos.id')
            ->join('examenes','evaluaciones.examen_id','=','examenes.id')
            ->select('evaluaciones.id as id' , 'examenes.nombre as nombreExamen', 'evaluaciones.created_at as fecha', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id','alumnos.nombre as alumno_nombre','alumnos.apellido as alumno_apellido','evaluaciones.total as nota_total','alumnos.identificacion', 'alumnos.id as alumno_id')
            ->where('evaluaciones.alumno_id', '=' , $usuario_id)
        ->get();

        $array = array(2, 4);

        $alumnoc = User::join('alumnos', 'alumnos.id', '=', 'users.usuario_id')
            ->join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
            ->select('alumnos.id as id')
            ->where('users.academia_id','=', Auth::user()->academia_id)
            ->where('alumnos.deleted_at', '=', null)
            ->whereIn('usuarios_tipo.tipo', $array)
            ->where('users.confirmation_token', '!=', null)
        ->get();

        $collection=collect($alumnoc);
        $grouped = $collection->groupBy('id');     
        $activacion = $grouped->toArray();

        $usuario_tipo = Session::get('easydance_usuario_tipo');

        return view('especiales.evaluaciones.principal')->with(['evaluacion' => $evaluacion_join, 'activacion' => $activacion, 'usuario_tipo' => $usuario_tipo]);
    }

    public function evaluaciones_alumno($id)
    {
        $evaluacion_join = DB::table('evaluaciones')
            ->join('instructores', 'evaluaciones.instructor_id', '=', 'instructores.id')
            ->join('alumnos','evaluaciones.alumno_id','=','alumnos.id')
            ->join('examenes','evaluaciones.examen_id','=','examenes.id')
            ->select('evaluaciones.id as id' , 'examenes.nombre as nombreExamen', 'evaluaciones.created_at as fecha', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id','alumnos.nombre as alumno_nombre','alumnos.apellido as alumno_apellido','evaluaciones.total as nota_total','alumnos.identificacion', 'alumnos.id as alumno_id')
            ->where('evaluaciones.alumno_id', '=' , $id)
        ->get();

        $array = array(2, 4);

        $alumnoc = User::join('alumnos', 'alumnos.id', '=', 'users.usuario_id')
            ->join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
            ->select('alumnos.id as id')
            ->where('users.academia_id','=', Auth::user()->academia_id)
            ->where('alumnos.deleted_at', '=', null)
            ->whereIn('usuarios_tipo.tipo', $array)
            ->where('users.confirmation_token', '!=', null)
        ->get();

        $collection=collect($alumnoc);
        $grouped = $collection->groupBy('id');     
        $activacion = $grouped->toArray();

        $usuario_tipo = Session::get('easydance_usuario_tipo');

        return view('especiales.evaluaciones.principal')->with(['evaluacion' => $evaluacion_join, 'id' => $id, 'activacion' => $activacion, 'usuario_tipo' => $usuario_tipo]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'alumno_id' => 'required',
            'total_nota' => 'required',
            'observacion' => 'max:1000',
        ];

        $messages = [

            'alumno_id.required' => 'Ups! Debe seleccionar un Alumno ',
            'total_nota.required' => 'Ups! Debe evaluar para poder guardar',
            'observacion.max' => 'Ups! no pueden ser mas de 1000 caracteres',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{

            $notas=explode(",",$request->nota_detalle);

            $evaluacion = new Evaluacion;

            $evaluacion->academia_id = Auth::user()->academia_id;
            $evaluacion->alumno_id = $request->alumno_id;
            $evaluacion->examen_id = $request->examen_id;
            $evaluacion->instructor_id= $request->instructor_id;
            $evaluacion->total = $request->total_nota;
            $evaluacion->observacion = $request->observacion;
            $evaluacion->porcentaje = $request->barra_de_progreso;

            $evaluacion->cantidad_horas_practica = $request->cantidad_horas_practica;
            $evaluacion->asistencia_taller = $request->taller_formula;
            $evaluacion->practica_horas_personalizadas = $request->personalizada_formula;
            $evaluacion->participacion_evento = $request->evento_formula;
            $evaluacion->participacion_fiesta_social = $request->fiesta_formula;

            if($evaluacion->save()){

                $examen = Examen::find($request->examen_id);

                $i = 0;

                if($examen->tiempos_musicales == 1){
                    $arrays_de_items[$i]="Tiempos musicales";
                    $i++;
                }
                if($examen->compromiso == 1){
                    $arrays_de_items[$i]="Compromiso";
                    $i++;
                }
                if($examen->condicion == 1){
                    $arrays_de_items[$i]="Condiciones";
                    $i++;
                }
                if($examen->habilidades == 1){
                    $arrays_de_items[$i]="Habilidades";
                    $i++;
                }
                if($examen->disciplina == 1){
                    $arrays_de_items[$i]="Disciplina";
                    $i++;
                }
                if($examen->expresion_corporal == 1){
                    $arrays_de_items[$i]="Expresion corporal";
                    $i++;
                }
                if($examen->expresion_facial == 1){
                    $arrays_de_items[$i]="Expresion facial";
                    $i++;
                }
                if($examen->respeto == 1){
                    $arrays_de_items[$i]="Respeto";
                    $i++;
                }
                if($examen->destreza == 1){
                    $arrays_de_items[$i]="Destreza";
                    $i++;
                }
                if($examen->dedicacion == 1){
                    $arrays_de_items[$i]="Dedicacion";
                    $i++;
                }
                if($examen->oido_musical == 1){
                    $arrays_de_items[$i]="Oido musical";
                    $i++;
                }
                if($examen->postura == 1){
                    $arrays_de_items[$i]="Postura";
                    $i++;
                }
                if($examen->elasticidad == 1){
                    $arrays_de_items[$i]="Elasticidad";
                    $i++;
                }
                if($examen->complejidad_de_movimientos == 1){
                    $arrays_de_items[$i]="Complejidad de movimientos";
                    $i++;
                }
                if($examen->asistencia == 1){
                    $arrays_de_items[$i]="Asistencia";
                    $i++;
                }
                if($examen->estilo == 1){
                    $arrays_de_items[$i]="Estilo";
                    $i++;
                }

                $i = 0;

                foreach($arrays_de_items as $item){

                    $detalle = new DetalleEvaluacion;

                    $detalle->nombre = $item;
                    $detalle->nota = intval($notas[$i]);
                    $detalle->evaluacion_id = $evaluacion->id;
                    $detalle->save();

                    $i++;
                }

                $items_a_evaluar = ItemsExamenes::where('examen_id', '=' , $request->examen_id)->get();

                foreach($items_a_evaluar as $item){

                    $detalle = new DetalleEvaluacion;

                    $detalle->nombre = $item->nombre;
                    $detalle->nota = intval($notas[$i]);
                    $detalle->evaluacion_id = $evaluacion->id;
                    $detalle->save();

                    $i++;
                }

                $formulas = ConfigFormulaExito::where('academia_id','=',Auth::user()->academia_id)->get();

                foreach($formulas as $formula){
                    $config_formula = $formula->id."_formula";
                    if($request->$config_formula == 1){

                        $formula_evaluacion = new FormulaEvaluacion;
                        $formula_evaluacion->evaluacion_id = $evaluacion->id;
                        $formula_evaluacion->nombre = $formula->nombre;
                        $formula_evaluacion->save();
                        
                    }
                }

                $notificacion = new Notificacion; 

                $notificacion->tipo_evento = 6;
                $notificacion->evento_id = $evaluacion->id;
                $notificacion->mensaje = "Tienes una nueva valoración. Verifica los resultados";
                $notificacion->titulo = "Nueva Valoración";

                if($notificacion->save()){
                    $in = array(2,4);
                    $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                        ->where('usuarios_tipo.tipo_id',$request->alumno_id)
                        ->whereIn('usuarios_tipo.tipo',$in)
                    ->first();

                    if($usuario){

                      $usuarios_notificados = new NotificacionUsuario;
                      $usuarios_notificados->id_usuario = $usuario->id;
                      $usuarios_notificados->id_notificacion = $notificacion->id;
                      $usuarios_notificados->visto = 0;
                      $usuarios_notificados->save();
                    }
                    
                }

                Session::forget('id_alumno');
                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function getDetalle($id){
        //DATOS DE ENCABEZADO
        
        $nota_final = evaluacion::find($id);
        
        $alumno = DB::table('evaluaciones')
                            ->join('alumnos', 'evaluaciones.alumno_id','=','alumnos.id')
                            ->select('alumnos.nombre', 'alumnos.apellido', 'alumnos.correo', 'alumnos.telefono', 'alumnos.celular', 'alumnos.sexo', 'alumnos.direccion', 'alumnos.fecha_nacimiento', 'alumnos.identificacion', 'alumnos.id', 'alumnos.created_at')
                            ->where('evaluaciones.id','=',$id)
                            ->first();

        $fecha_ingreso = Carbon::createFromFormat('Y-m-d H:i:s', $alumno->created_at)->format('Y-m-d');

        $instructor = DB::table('evaluaciones')
                            ->join('instructores', 'evaluaciones.instructor_id','=','instructores.id')
                            ->select('instructores.nombre AS instructor_nombre', 'instructores.apellido AS instructor_apellido', 'instructores.telefono', 'instructores.celular', 'instructores.facebook', 'instructores.twitter', 'instructores.instagram', 'instructores.linkedin', 'instructores.youtube', 'instructores.pagina_web')
                            ->where('evaluaciones.id','=',$id)
                            ->first();

        $academia = DB::table('evaluaciones')
                            ->join('academias', 'evaluaciones.academia_id','=','academias.id')
                            ->select('academias.nombre AS academia_nombre','academias.imagen as imagen_academia', 'academias.identificacion', 'academias.telefono', 'academias.celular', 'academias.correo', 'academias.direccion')
                            ->where('evaluaciones.id','=',$id)
                            ->first();

        $examen = DB::table('evaluaciones')
                            ->join('examenes', 'evaluaciones.examen_id','=','examenes.id')
                            ->join('instructores', 'evaluaciones.instructor_id','=','instructores.id')
                            ->join('config_tipo_examenes', 'examenes.tipo','=','config_tipo_examenes.id')
                            ->select('evaluaciones.*', 'examenes.genero','evaluaciones.porcentaje', 'config_tipo_examenes.nombre', 'examenes.proxima_fecha', 'instructores.nombre AS instructor_nombre', 'instructores.apellido AS instructor_apellido', 'instructores.telefono', 'instructores.celular', 'instructores.facebook', 'instructores.twitter', 'instructores.instagram', 'instructores.linkedin', 'instructores.youtube', 'instructores.pagina_web', 'examenes.id as examen_id')
                            ->where('evaluaciones.id','=',$id)
                            ->first();

        $clase_grupal = DB::table('alumnos')
                ->join('inscripcion_clase_grupal', 'inscripcion_clase_grupal.alumno_id', '=', 'alumnos.id')
                ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('config_clases_grupales.nombre as nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final', 'clases_grupales.id', 'clases_grupales.fecha_inicio')
                ->where('inscripcion_clase_grupal.alumno_id', $alumno->id)
                ->where('inscripcion_clase_grupal.deleted_at', null)
            ->first();

            if($clase_grupal)
            {

              $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);

              // if($fecha >= Carbon::now()){

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

                $clase_grupal_nombre = $clase_grupal->nombre;
                $instructor = $clase_grupal->instructor_nombre . ' ' . $clase_grupal->instructor_apellido;
                $horario = $dia . ' de ' . $clase_grupal->hora_inicio .' a '. $clase_grupal->hora_final;

              }else{
                $clase_grupal_nombre = '';
                $instructor = '';
                $horario = '';
              }
              

            // }else{

            //   $clase_grupal_nombre = '';
            //   $instructor = '';
            //   $horario = '';

            // }

            
        //DATOS DE DETALLE
        $detalles_notas = DetalleEvaluacion::select('nombre', 'nota')
            ->where('evaluacion_id','=',$id)
        ->get();

        $formulas = FormulaEvaluacion::select('nombre')
            ->where('evaluacion_id','=',$id)
        ->get();

        $edad = Carbon::createFromFormat('Y-m-d', $alumno->fecha_nacimiento)->diff(Carbon::now())->format('%y');
        $usuario_tipo = Session::get('easydance_usuario_tipo');
        
        return view('especiales.evaluaciones.detalle')->with([
            'alumno'                    => $alumno, 
            'academia'                  => $academia, 
            'detalle_notas'             => $detalles_notas,
            'nota_final'                => $nota_final->total,
            'observacion'               => $nota_final->observacion,
            'fecha'                     => $nota_final->created_at,
            'genero_examen'             => $examen->genero,
            'porcentaje'                => $examen->porcentaje,
            'edad'                      => $edad,
            'clase_grupal_nombre'       => $clase_grupal_nombre,
            'instructor'                => $instructor,
            'horario'                   => $horario,
            'fecha_ingreso'             => $fecha_ingreso,
            'fecha_siguiente'           => $examen->proxima_fecha,
            'examen'                    => $examen,
            'formulas'                  => $formulas,
            'usuario_tipo'              => $usuario_tipo
        ]);
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
    public function destroy($id)
    {
        //
    }
}
