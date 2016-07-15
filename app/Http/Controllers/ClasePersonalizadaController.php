<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\DiasDeSemana;
use App\ClasePersonalizada;
use App\ConfigEstudios;
use App\ConfigEspecialidades;
use App\ConfigClasesPersonalizadas;
use App\ConfigNiveles;
use App\Instructor;
use App\Alumno;
use App\Academia;
use App\ItemsFacturaProforma;
use Mail;
use Validator;
use DB;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;

class ClasePersonalizadaController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {

        $clase_personalizada_join = DB::table('clases_personalizadas')
            ->join('config_especialidades', 'clases_personalizadas.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_estudios', 'clases_personalizadas.estudio_id', '=', 'config_estudios.id')
            ->join('instructores', 'clases_personalizadas.instructor_id', '=', 'instructores.id')
            ->join('alumnos', 'clases_personalizadas.alumno_id', '=', 'alumnos.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'alumnos.nombre as alumno_nombre', 'alumnos.apellido as alumno_apellido', 'config_estudios.nombre as estudio_nombre', 'clases_personalizadas.hora_inicio','clases_personalizadas.hora_final', 'clases_personalizadas.id', 'clases_personalizadas.fecha_inicio')
            ->where('clases_personalizadas.academia_id', '=' ,  Auth::user()->academia_id)
            ->where('clases_personalizadas.deleted_at', '=', null)
            ->get();

        return view('agendar.clase_personalizada.index')->with(['config_especialidades' => ConfigEspecialidades::all(), 'config_estudios' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'config_niveles' => ConfigNiveles::all(), 'instructor' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'alumnos' => Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'clase_personalizada_join' => $clase_personalizada_join]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (Session::has('horario')) {
            Session::forget('horario'); 
        }

        return view('agendar.clase_personalizada.create')->with(['alumnos' => Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'dias_de_semana' => DiasDeSemana::all(), 'especialidad' => ConfigEspecialidades::all(), 'estudio' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'instructor' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get()]);
    }

    public function operar($id)
    {   
        $alumno = DB::table('clases_personalizadas')
            ->join('alumnos', 'clases_personalizadas.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido')
            ->where('clases_personalizadas.id', '=', $id)
            ->first();

        return view('agendar.clase_personalizada.operacion')->with(['id' => $id, 'alumno' => $alumno]);        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

    // dd($request->all());
    

    $rules = [

        'alumno_id' => 'required',
        'costo' => 'required|numeric',
        'fecha_inicio' => 'required',
        'color_etiqueta' => 'required',
        'especialidad_id' => 'required',
        'instructor_id' => 'required',
        'estudio_id' => 'required',
        'hora_inicio' => 'required',
        'hora_final' => 'required',
    ];

    $messages = [

        'costo.numeric' => 'Ups! El costo es inválido, debe contener sólo  números',
        'costo.required' => 'Ups! El costo es requerido',
        'fecha_inicio.required' => 'Ups! La fecha es requerida',
        'color_etiqueta.required' => 'Ups! La etiqueta es requerida',
        'instructor_id.required' => 'Ups! El instructor es requerido',
        'hora_inicio.required' => 'Ups! La hora de inicio es requerida',
        'hora_final.required' => 'Ups! La hora final es requerida',
        'alumno_id.required' => 'Ups! El Alumno es requerido',
        'especialidad_id.required' => 'Ups! La especialidad es requerida ',
        'estudio_id.required' => 'Ups! El estudio o salón es requerido',
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

        $descripcion = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->descripcion))));

        $clasepersonalizada = new ClasePersonalizada;
        
        $fecha_inicio = Carbon::createFromFormat('d/m/Y', $request->fecha_inicio)->toDateString();

        // $clasepersonalizada->costo = $request->costo;
        $clasepersonalizada->academia_id = Auth::user()->academia_id;
        $clasepersonalizada->fecha_inicio = $fecha_inicio;
        $clasepersonalizada->fecha_final = $fecha_inicio;
        $clasepersonalizada->instructor_id = $request->instructor_id;
        $clasepersonalizada->color_etiqueta = $request->color_etiqueta;
        $clasepersonalizada->hora_inicio = $request->hora_inicio;
        $clasepersonalizada->hora_final = $request->hora_final;
        $clasepersonalizada->alumno_id = $request->alumno_id;
        $clasepersonalizada->especialidad_id = $request->especialidad_id;
        $clasepersonalizada->estudio_id = $request->estudio_id;
        $clasepersonalizada->condiciones = $request->condiciones;
        $clasepersonalizada->descripcion = $descripcion;

        // return redirect("/home");
        if($clasepersonalizada->save()){

            $item_factura = new ItemsFacturaProforma;
                    
            $item_factura->alumno_id = $request->alumno_id;
            $item_factura->academia_id = Auth::user()->academia_id;
            $item_factura->fecha = Carbon::now()->toDateString();
            $item_factura->item_id = $clasepersonalizada->id;
            $item_factura->nombre = 'Costo Clase Personalizada ' . $clasepersonalizada->id;
            $item_factura->tipo = 9;
            $item_factura->cantidad = 1;
            $item_factura->precio_neto = 0;
            $item_factura->impuesto = 0;
            $item_factura->importe_neto = $request->costo;
            $item_factura->fecha_vencimiento = Carbon::now()->toDateString();

            $item_factura->save();

            $academia = Academia::find(Auth::user()->academia_id);
            $alumno = Alumno::find($request->alumno_id);
            $instructor = Instructor::find($request->instructor_id);

            $subj = 'Te han asignado una Clase Personalizada';
            $subj2 = 'Has confirmado una Clase Personalizada';

            $array = [
               'nombre_instructor' => $instructor->nombre,
               'correo' => $instructor->correo,
               'academia' => $academia->nombre,
               'nombre_alumno' => $alumno->nombre,
               'apellido_alumno' => $alumno->apellido,
               'hora_inicio' => $request->hora_inicio,
               'hora_final' => $request->hora_final,
               'fecha' => $fecha_inicio,
               'subj' => $subj
            ];

            $array2 = [
               'nombre_instructor' => $instructor->nombre,
               'apellido_instructor' => $instructor->apellido,
               'correo' => $alumno->correo,
               'academia' => $academia->nombre,
               'nombre_alumno' => $alumno->nombre,
               'hora_inicio' => $request->hora_inicio,
               'hora_final' => $request->hora_final,
               'fecha' => $fecha_inicio,
               'subj' => $subj2
            ];

            Mail::send('correo.clase_personalizada_instructor', $array, function($msj) use ($array){
                    $msj->subject($array['subj']);
                    $msj->to($array['correo']);
                });

            Mail::send('correo.clase_personalizada_alumno', $array2, function($msj) use ($array2){
                    $msj->subject($array2['subj']);
                    $msj->to($array2['correo']);
                });

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

     public function updateNombre(Request $request){

        $clasepersonalizada = ClasePersonalizada::find($request->id);
        $clasepersonalizada->clase_personalizada_id = $request->clase_personalizada_id;

        if($clasepersonalizada->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'nombre' => 'nombre', 'valor' => $nombre, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateFecha(Request $request){

    $rules = [
        'fecha_inicio' => 'required',
    ];

    $messages = [

        'fecha_inicio.required' => 'Ups! La fecha es requerida',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

            $clasepersonalizada = ClasePersonalizada::find($request->id);

            $fecha_inicio = Carbon::createFromFormat('d/m/Y', $request->fecha_inicio)->toDateString();

            $clasepersonalizada->fecha_inicio = $fecha_inicio;
            $clasepersonalizada->fecha_final = $fecha_inicio;

            if($clasepersonalizada->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateEspecialidad(Request $request){
        $clasepersonalizada = ClasePersonalizada::find($request->id);
        $clasepersonalizada->especialidad_id = $request->especialidad_id;

        if($clasepersonalizada->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateAlumno(Request $request){
        $clasepersonalizada = ClasePersonalizada::find($request->id);
        $clasepersonalizada->alumno_id = $request->alumno_id;

        if($clasepersonalizada->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateInstructor(Request $request){
        $clasepersonalizada = ClasePersonalizada::find($request->id);
        $clasepersonalizada->instructor_id = $request->instructor_id;

        if($clasepersonalizada->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEstudio(Request $request){
        $clasepersonalizada = ClasePersonalizada::find($request->id);
        $clasepersonalizada->estudio_id = $request->estudio_id;

        if($clasepersonalizada->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEtiqueta(Request $request){
        $clasepersonalizada = ClasePersonalizada::find($request->id);
        $clasepersonalizada->etiqueta = $request->etiqueta;

        if($clasepersonalizada->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateHorario(Request $request){

    $rules = [

        'hora_inicio' => 'required',
        'hora_final' => 'required',

    ];

    $messages = [

        'hora_inicio.required' => 'Ups! El horario es requerido',
        'hora_final.required' => 'Ups! El horario es requerido',

    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        // return redirect("/home")

        // ->withErrors($validator)
        // ->withInput();

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }

    else{

            $hora_inicio = strtotime($request->hora_inicio);
            $hora_final = strtotime($request->hora_final);

            if($hora_inicio > $hora_final)
            {

                return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
            }

            $clasepersonalizada = ClasePersonalizada::find($request->id);
            $clasepersonalizada->hora_inicio = $request->hora_inicio;
            $clasepersonalizada->hora_final = $request->hora_final;

            if($clasepersonalizada->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateDescripcion(Request $request){

        $clasepersonalizada = ClasePersonalizada::find($request->id);

        $descripcion = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->descripcion))));

        $clasepersonalizada->descripcion = $descripcion;

        if($clasepersonalizada->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateCondiciones(Request $request){

        $clasepersonalizada = ClasePersonalizada::find($request->id);
        $clasepersonalizada->condiciones = $request->condiciones;

        if($clasepersonalizada->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
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
        $find = ClasePersonalizada::find($id);
        //dd($find);

        if ($find) {
            $clase_personalizada_join = DB::table('clases_personalizadas')
            ->join('config_especialidades', 'clases_personalizadas.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_estudios', 'clases_personalizadas.estudio_id', '=', 'config_estudios.id')
            ->join('instructores', 'clases_personalizadas.instructor_id', '=', 'instructores.id')
            ->join('alumnos', 'clases_personalizadas.alumno_id', '=', 'alumnos.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','config_estudios.nombre as estudio_nombre' , 'clases_personalizadas.fecha_inicio as fecha_inicio', 'clases_personalizadas.hora_inicio','clases_personalizadas.hora_final', 'alumnos.nombre as alumno_nombre', 'alumnos.apellido as alumno_apellido', 'clases_personalizadas.id', 'clases_personalizadas.descripcion','clases_personalizadas.condiciones')
            ->where('clases_personalizadas.id', '=', $id)
            ->first();

            return view('agendar.clase_personalizada.planilla')->with(['config_especialidades' => ConfigEspecialidades::all(), 'config_estudios' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'alumno' => Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'instructor' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'clasepersonalizada' => $clase_personalizada_join]);

        }else{
           return redirect("agendar/clases-personalizadas"); 
        }

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
        $clasepersonalizada = ClasePersonalizada::find($id);
        
        if($clasepersonalizada->delete()){
            return response()->json(['mensaje' => '¡Excelente! La Clase Personalizada se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

}