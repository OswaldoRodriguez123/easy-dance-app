<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\RegistroAsistencia;
use Validator;
use DB;
use Carbon\Carbon;

class CampanaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {

        return view('campana.index')->with('campana', Campaña::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $registroasistencia = new RegistroAsistencia;

        $registroasistencia->clasegrupal_id = $request->clasegrupal_id;
        $registroasistencia->alumno_id = $request->alumno_id;
        $registroasistencia->fecha = $request->fecha;


        if($registroasistencia->save()){
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
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $instructor = Instructor::find($id);
        return view('instructor.editar')->with('instructor', $instructor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $campana = Campana::find($id);
        $campana->delete();
        return view('campaña.index');
    }

}