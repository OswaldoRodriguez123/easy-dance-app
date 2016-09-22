<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;

use App\Http\Requests;
use App\ItemsExamenes;
use App\Evaluacion;
use App\DetalleEvaluacion;
use App\Examen;
use Validator;
use DB;
use Session;
use Illuminate\Support\Facades\Auth;

class EvaluacionController extends Controller
{

    function __construct(Route $route)
    {
        $this->route = $route;
    }
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
            ->select('evaluaciones.id as id' , 'examenes.nombre as nombreExamen', 'examenes.fecha as fecha', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id','alumnos.nombre as alumno_nombre','alumnos.apellido as alumno_apellido','evaluaciones.total as nota_total','alumnos.identificacion')
            ->where('evaluaciones.academia_id', '=' ,  Auth::user()->academia_id)
        ->get();

        return view('especiales.evaluaciones.principal')->with(['evaluacion' => $evaluacion_join,'id_evaluacion'=>$id_evaluacion]);
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

            if($evaluacion->save()){
                $items_examenes = ItemsExamenes::where('examen_id', '=' , $request->examen)->get();
                for ($i=0; $i < count($detalle_nota)-1; $i++) {
                    $detalles = new DetalleEvaluacion;

                    $detalles->nombre = $detalle_nombre[$i];//$items_examenes[$i]->nombre;
                    $detalles->nota = $detalle_nota[$i];
                    $detalles->evaluacion_id = $evaluacion->id;
                    $detalles->save();
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
                            ->select('alumnos.nombre AS alumno_nombre', 'alumnos.apellido AS alumno_apellido')
                            ->where('evaluaciones.id','=',$id)
                            ->first();

        $instructor = DB::table('evaluaciones')
                            ->join('instructores', 'evaluaciones.instructor_id','=','instructores.id')
                            ->select('instructores.nombre AS instructor_nombre', 'instructores.apellido AS instructor_apellido')
                            ->where('evaluaciones.id','=',$id)
                            ->first();

        $academia = DB::table('evaluaciones')
                            ->join('academias', 'evaluaciones.academia_id','=','academias.id')
                            ->select('academias.nombre AS academia_nombre','academias.imagen as imagen_academia')
                            ->where('evaluaciones.id','=',$id)
                            ->first();

        $genero_examen = DB::table('evaluaciones')
                            ->join('examenes', 'evaluaciones.examen_id','=','examenes.id')
                            ->select('examenes.genero','evaluaciones.porcentaje')
                            ->where('evaluaciones.id','=',$id)
                            ->first();

        //DATOS DE DETALLE
        $detalles_notas = DetalleEvaluacion::select('nombre', 'nota')
                            ->where('evaluacion_id','=',$id)
                            ->get();
        
        return view('especiales.evaluaciones.detalle')->with([
                'instructor'       => $instructor, 
                'alumno'           => $alumno, 
                'academia'         => $academia, 
                'detalle_notas'    => $detalles_notas,
                'nota_final'       => $nota_final->total,
                'observacion'      => $nota_final->observacion,
                'fecha'            => $nota_final->created_at,
                'genero_examen'    => $genero_examen->genero,
                'porcentaje'       => $genero_examen->porcentaje,
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
