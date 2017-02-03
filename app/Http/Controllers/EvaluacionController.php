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
            ->select('evaluaciones.id as id' , 'examenes.nombre as nombreExamen', 'evaluaciones.created_at as fecha', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id','alumnos.nombre as alumno_nombre','alumnos.apellido as alumno_apellido','evaluaciones.total as nota_total','alumnos.identificacion')
            ->where('evaluaciones.academia_id', '=' ,  Auth::user()->academia_id)
        ->get();

        return view('especiales.evaluaciones.principal')->with(['evaluacion' => $evaluacion_join,'id_evaluacion'=>$id_evaluacion]);
    }

    public function evaluaciones($id)
    {
        $evaluacion_join = DB::table('evaluaciones')
            ->join('instructores', 'evaluaciones.instructor_id', '=', 'instructores.id')
            ->join('alumnos','evaluaciones.alumno_id','=','alumnos.id')
            ->join('examenes','evaluaciones.examen_id','=','examenes.id')
            ->select('evaluaciones.id as id' , 'examenes.nombre as nombreExamen', 'evaluaciones.created_at as fecha', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id','alumnos.nombre as alumno_nombre','alumnos.apellido as alumno_apellido','evaluaciones.total as nota_total','alumnos.identificacion')
            ->where('evaluaciones.examen_id', '=' , $id)
        ->get();

        return view('especiales.evaluaciones.principal')->with(['evaluacion' => $evaluacion_join,'id_evaluacion'=>$id]);
    }

    public function evaluaciones_vista_alumno()
    {
        $evaluacion_join = DB::table('evaluaciones')
            ->join('instructores', 'evaluaciones.instructor_id', '=', 'instructores.id')
            ->join('alumnos','evaluaciones.alumno_id','=','alumnos.id')
            ->join('examenes','evaluaciones.examen_id','=','examenes.id')
            ->select('evaluaciones.id as id' , 'examenes.nombre as nombreExamen', 'evaluaciones.created_at as fecha', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id','alumnos.nombre as alumno_nombre','alumnos.apellido as alumno_apellido','evaluaciones.total as nota_total','alumnos.identificacion')
            ->where('evaluaciones.alumno_id', '=' , Auth::user()->usuario_id)
        ->get();

        return view('especiales.evaluaciones.principal')->with(['evaluacion' => $evaluacion_join]);
    }

    public function evaluaciones_alumno($id)
    {
        $evaluacion_join = DB::table('evaluaciones')
            ->join('instructores', 'evaluaciones.instructor_id', '=', 'instructores.id')
            ->join('alumnos','evaluaciones.alumno_id','=','alumnos.id')
            ->join('examenes','evaluaciones.examen_id','=','examenes.id')
            ->select('evaluaciones.id as id' , 'examenes.nombre as nombreExamen', 'evaluaciones.created_at as fecha', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id','alumnos.nombre as alumno_nombre','alumnos.apellido as alumno_apellido','evaluaciones.total as nota_total','alumnos.identificacion')
            ->where('evaluaciones.alumno_id', '=' , $id)
        ->get();

        return view('especiales.evaluaciones.principal')->with(['evaluacion' => $evaluacion_join, 'id' => $id]);
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
            //'alumno_id.unique' => 'Ups! Este alumno ya ha sido evaluado ',
            //'alumno_id.in' => 'Error, usuario seleccionado no existe!',
            'total_nota.required' => 'Ups! Debe evaluar para poder guardar',
            'observacion.max' => 'Ups! no pueden ser mas de 1000 caracteres',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{
            $detalle_nota=explode(",",$request->nota_detalle);
            $detalle_nombre=explode(",",$request->nombre_detalle);

            $evaluacion = new Evaluacion;

            $evaluacion->academia_id = $request->academia;
            $evaluacion->alumno_id = $request->alumno_id;
            $evaluacion->examen_id = $request->examen;
            $evaluacion->instructor_id= $request->instructor;
            $evaluacion->total = $request->total_nota;
            $evaluacion->observacion = $request->observacion;
            $evaluacion->porcentaje = $request->barra_de_progreso;

            $evaluacion->cantidad_horas_practica = $request->cantidad_horas_practica;
            $evaluacion->asistencia_taller = $request->asistencia_taller;
            $evaluacion->practica_horas_personalizadas = $request->practica_horas_personalizadas;
            $evaluacion->participacion_evento = $request->participacion_evento;
            $evaluacion->participacion_fiesta_social = $request->participacion_fiesta_social;

            if($evaluacion->save()){
                $items_examenes = ItemsExamenes::where('examen_id', '=' , $request->examen)->get();
                for ($i=0; $i < count($detalle_nota)-1; $i++) {
                    $detalles = new DetalleEvaluacion;

                    $detalles->nombre = $detalle_nombre[$i];//$items_examenes[$i]->nombre;
                    $detalles->nota = $detalle_nota[$i];
                    $detalles->evaluacion_id = $evaluacion->id;
                    $detalles->save();
                }

                $notificacion = new Notificacion; 

                $notificacion->tipo_evento = 6;
                $notificacion->evento_id = $evaluacion->id;
                $notificacion->mensaje = "Tienes una nueva valoración. Verifica los resultados";
                $notificacion->titulo = "Nueva Valoración";

                if($notificacion->save()){

                  $tmp = User::where('usuario_id', $request->alumno_id)->first();

                  if($tmp){
                    $es_representante = Familia::where('representante_id', $tmp->id)->first();

                    if(!$es_representante){
                        $usuario = User::where('usuario_id' , $request->alumno_id)->where('usuario_tipo', 2)->first();
                    }
                    else{
                        $usuario = User::where('usuario_id' , $request->alumno_id)->where('usuario_tipo', 4)->first();
                    }

                    if($usuario){

                      $usuarios_notificados = new NotificacionUsuario;
                      $usuarios_notificados->id_usuario = $usuario->id;
                      $usuarios_notificados->id_notificacion = $notificacion->id;
                      $usuarios_notificados->visto = 0;
                      $usuarios_notificados->save();
                    }
                  }
                    
                }
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
                            ->select('instructores.nombre AS instructor_nombre', 'instructores.apellido AS instructor_apellido')
                            ->where('evaluaciones.id','=',$id)
                            ->first();

        $academia = DB::table('evaluaciones')
                            ->join('academias', 'evaluaciones.academia_id','=','academias.id')
                            ->select('academias.nombre AS academia_nombre','academias.imagen as imagen_academia', 'academias.identificacion')
                            ->where('evaluaciones.id','=',$id)
                            ->first();

        $examen = DB::table('evaluaciones')
                            ->join('examenes', 'evaluaciones.examen_id','=','examenes.id')
                            ->join('config_tipo_examenes', 'examenes.tipo','=','config_tipo_examenes.id')
                            ->select('evaluaciones.*', 'examenes.genero','evaluaciones.porcentaje', 'config_tipo_examenes.nombre', 'evaluaciones.created_at')
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
                ->where('clases_grupales.fecha_final', '<=', Carbon::now())
            ->first();

            if($clase_grupal)
            {

              $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
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

            
        //DATOS DE DETALLE
        $detalles_notas = DetalleEvaluacion::select('nombre', 'nota')
                            ->where('evaluacion_id','=',$id)
                            ->get();
        $edad = Carbon::createFromFormat('Y-m-d', $alumno->fecha_nacimiento)->diff(Carbon::now())->format('%y');
        $fecha_siguiente = Carbon::createFromFormat('Y-m-d H:i:s', $examen->created_at)->addMonth(1)->format('Y-m-d');
        
        return view('especiales.evaluaciones.detalle')->with([
                'alumno'           => $alumno, 
                'academia'         => $academia, 
                'detalle_notas'    => $detalles_notas,
                'nota_final'       => $nota_final->total,
                'observacion'      => $nota_final->observacion,
                'fecha'            => $nota_final->created_at,
                'genero_examen'    => $examen->genero,
                'porcentaje'       => $examen->porcentaje,
                'edad'             => $edad,
                'clase_grupal_nombre'     => $clase_grupal_nombre,
                'instructor'              => $instructor,
                'horario'          => $horario,
                'fecha_ingreso'    => $fecha_ingreso,
                'fecha_siguiente'  => $fecha_siguiente,
                'examen' => $examen
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
