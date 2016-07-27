<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;

use App\Http\Requests;
use App\Evaluacion;
use Validator;
use DB;
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
        $evaluacion_join = DB::table('evaluaciones')
            ->join('instructores', 'evaluaciones.instructor_id', '=', 'instructores.id')
            ->join('alumnos','evaluaciones.alumno_id','=','alumnos.id')
            ->join('examenes','evaluaciones.examen_id','=','examenes.id')
            ->select('examenes.id as id' , 'examenes.nombre as nombreExamen', 'examenes.fecha as fecha', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id','alumnos.nombre as alumno_nombre','alumnos.apellido as alumno_apellido','evaluaciones.total as nota_total')
            ->where('evaluaciones.academia_id', '=' ,  Auth::user()->academia_id)
        ->get();        //

        return view('especiales.evaluaciones.principal')->with('evaluacion', $evaluacion_join);
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
        ];

        $messages = [

            'alumno_id.required' => 'Ups! Debe seleccionar un Alumno ',
            //'alumno_id.unique' => 'Ups! Este alumno ya ha sido evaluado ',
            //'alumno_id.in' => 'Error, usuario seleccionado no existe!',
            'total_nota.required' => 'Ups! Debe evaluar para poder guardar',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{

            $evaluacion = new Evaluacion;

            $evaluacion->academia_id = $request->academia;
            $evaluacion->alumno_id = $request->alumno_id;
            $evaluacion->examen_id = $request->examen;
            $evaluacion->instructor_id= $request->instructor;
            $evaluacion->total = $request->total_nota;

            if($evaluacion->save()){
                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
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
    public function destroy($id)
    {
        //
    }
}
