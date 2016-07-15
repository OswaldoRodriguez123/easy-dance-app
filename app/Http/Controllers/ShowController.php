<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Show;
use App\ConfigServicios;
use Validator;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ShowController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    
    public function index()
    {
        // $taller_join = DB::table('talleres')
        //     ->join('config_especialidades', 'talleres.especialidad_id', '=', 'config_especialidades.id')
        //     ->join('config_estudios', 'talleres.estudio_id', '=', 'config_estudios.id')
        //     ->join('instructores', 'talleres.instructor_id', '=', 'instructores.id')
        //     ->select('config_especialidades.nombre as especialidad_nombre', 'instructores.nombre as instructor_nombre', 'config_estudios.nombre as estudio_nombre', 'talleres.hora_inicio','talleres.hora_final')
        //     ->get();

            //dd($clase_grupal_join);

        return view('show.index')->with(['show' => Show::all(), 'config_servicios' => ConfigServicios::all()]);
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


    $rules = [
        'nombre' => 'required|min:3|max:50',
        'descripcion' => 'required|min:3|max:500',
        'fecha' => 'required',
        'hora_inicio' => 'required',
        'hora_final' => 'required',
        'lugar' => 'required',
        'etiqueta' => 'required',
    ];

    $messages = [

        'nombre.required' => 'Ups! El Nombre es requerido ',
        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre.max' => 'El máximo de caracteres permitidos son 50',
        'nombre.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
        'descripcion.required' => 'Ups! La Descripcion es requerida',
        'descripcion.min' => 'El mínimo de caracteres permitidos son 3',
        'descripcion.max' => 'El máximo de caracteres permitidos son 500',
        'fecha.required' => 'Ups! La fecha es requerida',
        'hora_inicio.required' => 'Ups! El horario es requerido',
        'hora_final.required' => 'Ups! El horario es requerido',
        'lugar.required' => 'Ups! lugar es requerido',
        'etiqueta.required' => 'Ups! El color de la etiqueta es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $show = new Show;

        $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha)->toDateString();

        $show->academia_id = Auth::user()->academia_id;
        $show->nombre = $request->nombre;
        $show->descripcion = $request->descripcion;
        $show->fecha = $fecha;
        $show->hora_inicio = $request->hora_inicio;
        $show->hora_final = $request->hora_final;
        $show->lugar = $request->lugar;
        $show->etiqueta = $request->etiqueta;

        if($show->save()){
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function updateNombre(Request $request){

        $show = Show::find($request->id);
        $show->nombre = $request->nombre;

        $rules = [
            'nombre' => 'required|min:3|max:50',
        ];

        $messages = [

            'nombre.required' => 'Ups! El Nombre es requerido',
            'nombre.min' => 'El mínimo de caracteres permitidos son 3',
            'nombre.max' => 'El máximo de caracteres permitidos son 50',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            if($show->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
            // return redirect("alumno/edit/{$request->id}");
        }
    }

    public function updateDescripcion(Request $request){

        $show = Show::find($request->id);
        $show->descripcion = $request->descripcion;

        $rules = [
            'descripcion' => 'required|min:3|max:500',
        ];

        $messages = [

            'descripcion.required' => 'Ups! La Descripcion es requerida',
            'descripcion.min' => 'El mínimo de caracteres permitidos son 3',
            'descripcion.max' => 'El máximo de caracteres permitidos son 500',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            if($show->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
            // return redirect("alumno/edit/{$request->id}");
        }
    }


    public function updateFecha(Request $request){

        $show = Show::find($request->id);

        $fecha_inicio = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->toDateString();

        $show->fecha_inicio = $fecha_inicio;

        if($show->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateHorario(Request $request){
        $show = Show::find($request->id);
        $show->horario_inicio = $request->horario_inicio;
        $show->horario_final = $request->horario_final;

        if($show->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEtiqueta(Request $request){
        $show = Show::find($request->id);
        $show->etiqueta = $request->etiqueta;

        if($show->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateLugar(Request $request){
        
        $show = Show::find($request->id);
        $show->descripcion = $request->descripcion;

        $rules = [
            'lugar' => 'required',
        ];

        $messages = [

            'lugar.required' => 'Ups! El Lugar es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

        if($show->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        }
    }

    public function updateRepresentante(Request $request){
        
        $show = Show::find($request->id);
        $show->nombre_representante = $request->nombre_representante;
        $show->telefono_representante = $request->telefono_representante;
        $show->celular_representante = $request->celular_representante;
        $show->correo_representante = $request->correo_representante;

        if($show->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
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
        $show = Show::find($id);
        $show->delete();
        return view('show.index');
    }

}