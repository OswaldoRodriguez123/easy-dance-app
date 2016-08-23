<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Visitante;
use App\ComoNosConociste;
use App\ConfigEspecialidades;
use App\DiasDeInteres;
use App\EncuestaVisitante;
use Validator;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;
use Mail;

class VisitanteController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {

        return view('participante.visitante.principal')->with(['visitante' => Visitante::where('academia_id', '=' ,  Auth::user()->academia_id)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        return view('participante.visitante.create')->with(['como_nos_conociste' => ComoNosConociste::all(), 'especialidad' => ConfigEspecialidades::all() , 'dia_de_semana' => DiasDeInteres::all()]);;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $request->merge(array('correo' => trim($request->correo)));


    $rules = [
        'identificacion' => 'required|min:7|numeric|unique:visitantes_presenciales,identificacion',
        'nombre' => 'required|min:3|max:16|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'apellido' => 'required|min:3|max:16|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'fecha_nacimiento' => 'required',
        'sexo' => 'required',
        'como_nos_conociste_id' => 'required',
        'correo' => 'email|max:255|unique:visitantes_presenciales,correo, '.$request->id.'',
        
    ];

    $messages = [

        'identificacion.required' => 'Ups! El identificador es requerido',
        'identificacion.min' => 'El mínimo de numeros permitidos son 5',
        'identificacion.max' => 'El maximo de numeros permitidos son 20',
        'identificacion.numeric' => 'Ups! El identificador es inválido , debe contener sólo números',
        'identificacion.unique' => 'Ups! Ya este usuario ha sido registrado',
        'nombre.required' => 'Ups! El Nombre  es requerido ',
        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre.max' => 'El máximo de caracteres permitidos son 16',
        'nombre.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
        'apellido.required' => 'Ups! El Apellido  es requerido ',
        'apellido.min' => 'El mínimo de caracteres permitidos son 3',
        'apellido.max' => 'El máximo de caracteres permitidos son 16',
        'apellido.regex' => 'Ups! El apellido es inválido , debe ingresar sólo letras',
        'sexo.required' => 'Ups! El Sexo  es requerido ',
        'fecha_nacimiento.required' => 'Ups! La fecha de nacimiento es requerida',
        'como_nos_conociste_id.required' => 'Ups! La pregunta de ¿Cómo se enteró? es requerida ',
        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'correo.max' => 'El máximo de caracteres permitidos son 255',
        'correo.unique' => 'Ups! Ya este correo ha sido registrado',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
    }

    else{

        $edad = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->diff(Carbon::now())->format('%y');


        if($edad < 1){
            return response()->json(['errores' => ['fecha_nacimiento' => [0, 'Ups! Esta fecha es invalida, debes ingresar una fecha superior a 1 año de edad']], 'status' => 'ERROR'],422);
        }

        $visitante = new Visitante;

        $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->toDateString();

        $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->nombre))));

        $apellido = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->apellido))));

        $direccion = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->direccion))));

        $correo = strtolower($request->correo);

        $visitante->academia_id = Auth::user()->academia_id;
        $visitante->nombre = $nombre;
        $visitante->apellido = $apellido;
        $visitante->sexo = $request->sexo;
        $visitante->correo = $correo;
        $visitante->telefono = $request->telefono;
        $visitante->celular = $request->celular;
        $visitante->como_nos_conociste_id = $request->como_nos_conociste_id;
        $visitante->fecha_nacimiento = $fecha_nacimiento;
        $visitante->direccion = $direccion;
        $visitante->dias_clase_id = $request->dias_clase_id;
        $visitante->especialidad_id = $request->especialidad_id;
        $visitante->fecha_registro = Carbon::now();


        if($visitante->save()){
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function updateID(Request $request){

    $rules = [
        'identificacion' => 'required|min:7|numeric|unique:visitantes_presenciales,identificacion, '.$request->id.'',
    ];

    $messages = [

        'identificacion.required' => 'Ups! El identificador es requerido',
        'identificacion.min' => 'El mínimo de numeros permitidos son 5',
        'identificacion.max' => 'El maximo de numeros permitidos son 20',
        'identificacion.numeric' => 'Ups! El identificador es inválido , debe contener sólo números',
        'identificacion.unique' => 'Ups! Ya este usuario ha sido registrado',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $visitante = Visitante::find($request->id);
        $visitante->identificacion = $request->identificacion;
        
        if($visitante->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
        }
    }

    public function updateNombre(Request $request){

    $rules = [
        'nombre' => 'required|min:3|max:16|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'apellido' => 'required|min:3|max:16|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
    ];

    $messages = [

        'nombre.required' => 'Ups! El Nombre  es requerido ',
        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre.max' => 'El máximo de caracteres permitidos son 16',
        'nombre.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
        'apellido.required' => 'Ups! El Apellido  es requerido ',
        'apellido.min' => 'El mínimo de caracteres permitidos son 3',
        'apellido.max' => 'El máximo de caracteres permitidos son 16',
        'apellido.regex' => 'Ups! El apellido es inválido , debe ingresar sólo letras',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }
        $visitante = Visitante::find($request->id);

        $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->nombre))));

        $apellido = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->apellido))));

        $visitante->nombre = $nombre;
        $visitante->apellido = $apellido;

        if($visitante->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateFecha(Request $request){

        $visitante = Visitante::find($request->id);

        $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->toDateString();

        $visitante->fecha_nacimiento = $fecha_nacimiento;

        if($visitante->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateSexo(Request $request){
        $visitante = Visitante::find($request->id);
        $visitante->sexo = $request->sexo;

        // return redirect("alumno/edit/{$request->id}");
        if($visitante->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateDireccion(Request $request){
        $visitante = Visitante::find($request->id);
        $visitante->direccion = $request->direccion;

        if($visitante->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateTelefono(Request $request){

        $visitante = Visitante::find($request->id);
        $visitante->telefono = $request->telefono;
        $visitante->celular = $request->celular;

        if($visitante->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }


    public function updateCorreo(Request $request){

    $rules = [
        'correo' => 'email|max:255|unique:visitantes_presenciales,correo, '.$request->id.'',
    ];

    $messages = [

        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'correo.max' => 'El máximo de caracteres permitidos son 255',
        'correo.unique' => 'Ups! Ya este correo ha sido registrado',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{
        $visitante = Visitante::find($request->id);
        $visitante->correo = $request->correo;

        if($visitante->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function updateComoSeEntero(Request $request){
        $visitante = Visitante::find($request->id);
        $visitante->como_nos_conociste_id = $request->como_nos_conociste_id;

        // return redirect("alumno/edit/{$request->id}");
        if($visitante->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateDiasDeClase(Request $request){
        $visitante = Visitante::find($request->id);
        $visitante->dias_clase = $request->dias_clase;

        if($visitante->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEspecialidad(Request $request){
        $visitante = Visitante::find($request->id);
        $visitante->especialidad_id = $request->especialidad_id;

        if($visitante->save()){
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
        // $visitante_presencial_join = DB::table('visitantes_presenciales')
        //     ->join('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
        //     ->select('config_especialidades.nombre as especialidad_nombre')
        //     ->get();

        $visitante_join = DB::table('visitantes_presenciales')
            ->Leftjoin('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_como_nos_conociste', 'visitantes_presenciales.como_nos_conociste_id', '=', 'config_como_nos_conociste.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'config_como_nos_conociste.nombre as como_nos_conociste_nombre', 'visitantes_presenciales.id as id', 'visitantes_presenciales.nombre as nombre', 'visitantes_presenciales.apellido as apellido', 'visitantes_presenciales.fecha_nacimiento as fecha_nacimiento', 'visitantes_presenciales.sexo as sexo', 'visitantes_presenciales.correo as correo', 'visitantes_presenciales.telefono as telefono', 'visitantes_presenciales.celular as celular', 'visitantes_presenciales.direccion as direccion')
            ->where('visitantes_presenciales.id', '=', $id)
        ->first();

        if($visitante_join){
            $config['center'] = '10.6913156,-71.6800493';
            $config['zoom'] = 14;
            \Gmaps::initialize($config);

            $marker = array();
            $marker['position'] = '10.6913156,-71.6800493';
            $marker['draggable'] = true;
            $marker['ondragend'] = 'addFieldText(event.latLng.lat(), event.latLng.lng());';
            \Gmaps::add_marker($marker);


            $map = \Gmaps::create_map();
 
           return view('participante.visitante.planilla' , compact('map'))->with(['como_nos_conociste' => ComoNosConociste::all(), 'visitante' => $visitante_join, 'config_especialidades' => ConfigEspecialidades::all()]);
        }else{
           return redirect("participante/visitante"); 
        }
    }

    public function impresion($id)
    {
        $visitante = EncuestaVisitante::where('visitante_id', $id)->first();


        if(!$visitante){
            $visitante = new EncuestaVisitante;
            $visitante->visitante_id = $id;
            $visitante->save();
        }

        $visitante_presencial = Visitante::find($id);

        return view('participante.visitante.planilla_encuesta')->with(['visitante' => $visitante, 'visitante_presencial' => $visitante_presencial]);
    }

    public function storeImpresion(Request $request)
    {

        $visitante = EncuestaVisitante::where('visitante_id', $request->visitante_id)->first();

        if(!$visitante){
            
            $visitante = new EncuestaVisitante;
        }

        $visitante->visitante_id = $request->visitante_id;
        $visitante->rapidez = $request->rapidez;
        $visitante->calidad = $request->calidad;
        $visitante->satisfaccion = $request->satisfaccion;
        $visitante->disponibilidad = $request->disponibilidad;

        if($visitante->save()){

            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
        }

    }

    public function enviar(Request $request){

        $visitante = Visitante::find($request->id);

        if(!$visitante->correo){
            return response()->json(['error_mensaje'=> 'Ups! Este visitante no posee correo electrónico asignado' , 'status' => 'ERROR-CORREO'],422);
        }

        $subj = 'Información';

        $clase_grupal_join = DB::table('clases_grupales')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_grupales.fecha_inicio', 'clases_grupales.id')
            ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
            ->where('clases_grupales.deleted_at', '=', null)
        ->get();

        $array_clase = array();
        $i = 0;

        foreach($clase_grupal_join as $clase_grupal){
            $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
            if($fecha < Carbon::now()){
                $array_clase[$i] = $clase_grupal;
                $i = $i + 1;
            }
        }


        $array = [
            'nombre' => $visitante->nombre,
            'email' => $visitante->correo,
            'subj' => $subj,
            'clases_grupales' => $clase_grupal_join
        ];

        Mail::send('correo.clases_grupales', $array, function($msj) use ($array){
            $msj->subject($array['subj']);
            $msj->to($array['email']);
        });

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $visitante = Visitante::find($id);
        $visitante->delete();
        return view('visitante.index');
    }

}