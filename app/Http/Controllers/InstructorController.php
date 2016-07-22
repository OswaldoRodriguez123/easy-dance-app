<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Instructor;
use App\Academia;
use App\User;
use Mail;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class InstructorController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    
    public function index()
    {

        return view('participante.instructor.principal')->with('instructor', Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //Simple Marker
        $config['center'] = '10.6913156,-71.6800493';
        $config['zoom'] = 14;
        \Gmaps::initialize($config);

        $marker = array();
        $marker['position'] = '10.6913156,-71.6800493';
        $marker['draggable'] = true;
        $marker['ondragend'] = 'addFieldText(event.latLng.lat(), event.latLng.lng());';
        \Gmaps::add_marker($marker);

        $map = \Gmaps::create_map();

        return view('participante.instructor.create' , compact('map'));
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
        'identificacion' => 'required|min:7|numeric|unique:instructores,identificacion',
        'nombre' => 'required|min:3|max:16|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'apellido' => 'required|min:3|max:16|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'fecha_nacimiento' => 'required',
        'sexo' => 'required',
        'correo' => 'required|email|max:255|unique:instructores,correo, '.$request->id.'',
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
        'correo.required' => 'Ups! El correo es requerido',
        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'correo.max' => 'El máximo de caracteres permitidos son 255',
        'correo.unique' => 'Ups! Ya este correo ha sido registrado',
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

        $edad = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->diff(Carbon::now())->format('%y');


        if($edad < 1){
            return response()->json(['errores' => ['fecha_nacimiento' => [0, 'Ups! Esta fecha es invalida, debes ingresar una fecha superior a 1 año de edad']], 'status' => 'ERROR'],422);
        }

        $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->nombre))));

        $apellido = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->apellido))));

        $direccion = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->direccion))));

        $correo = strtolower($request->correo);

        $instructor = new Instructor;

        $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->toDateString();

        $instructor->academia_id = Auth::user()->academia_id;
        $instructor->identificacion = $request->identificacion;
        $instructor->nombre = $nombre;
        $instructor->apellido = $apellido;
        $instructor->sexo = $request->sexo;
        $instructor->fecha_nacimiento = $fecha_nacimiento;
        $instructor->correo = $correo;
        $instructor->telefono = $request->telefono;
        $instructor->celular = $request->celular;
        $instructor->direccion = $direccion;
        $instructor->alergia = $request->alergia;
        $instructor->asma = $request->asma;
        $instructor->convulsiones = $request->convulsiones;
        $instructor->cefalea = $request->cefalea;
        $instructor->hipertension = $request->hipertension;
        $instructor->lesiones = $request->lesiones;

        if($instructor->save()){

            $usuario = new User;

            $usuario->academia_id = Auth::user()->academia_id;
            $usuario->nombre = $nombre;
            $usuario->apellido = $apellido;
            $usuario->telefono = $request->telefono;
            $usuario->celular = $request->celular;
            $usuario->sexo = $request->sexo;
            $usuario->email = $correo;
            $usuario->como_nos_conociste_id = 1;
            $usuario->direccion = $direccion;
            // $usuario->confirmation_token = str_random(40);
            $usuario->password = bcrypt(str_random(8));
            $usuario->usuario_id = $instructor->id;
            $usuario->usuario_tipo = 3;

            if($usuario->save()){

                // $academia = Academia::find(Auth::user()->academia_id);
                // $contrasena = $usuario->password;
                // $subj = $instructor->nombre . ' , ' . $academia->nombre . ' te ha agregado a Easy Dance, por favor confirma tu correo electronico';

                // $array = [
                //    'nombre' => $request->nombre,
                //    'academia' => $academia->nombre,
                //    'usuario' => $request->correo,
                //    'contrasena' => $contrasena,
                //    'subj' => $subj
                // ];

                // Mail::send('correo.inscripcion', $array, function($msj) use ($array){
                //         $msj->subject($array['subj']);
                //         $msj->to($array['usuario']);
                //     });

                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
            }
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function updateID(Request $request){

    $rules = [
        'identificacion' => 'required|min:7|numeric|unique:instructores,identificacion, '.$request->id.'',
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

        // return redirect("alumno/edit/{$request->id}")

        // ->withErrors($validator)
        // ->withInput();
        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }

    else{

        $instructor = Instructor::find($request->id);
        $instructor->identificacion = $request->identificacion;
        
        if($instructor->save()){
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

        // return redirect("alumno/edit/{$request->id}")

        // ->withErrors($validator)
        // ->withInput();
        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }
        $instructor = Instructor::find($request->id);

        $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->nombre))));

        $apellido = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->apellido))));

        $instructor->nombre = $nombre;
        $instructor->apellido = $apellido;

        if($instructor->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateFecha(Request $request){

        $instructor = Instructor::find($request->id);
        
        $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->toDateString();

        $instructor->fecha_nacimiento = $fecha_nacimiento;

        if($instructor->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateSexo(Request $request){
        $instructor = Instructor::find($request->id);
        $instructor->sexo = $request->sexo;

        // return redirect("alumno/edit/{$request->id}");
        if($instructor->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateCorreo(Request $request){

    $rules = [
        'correo' => 'email|max:255|unique:instructores,correo, '.$request->id.'',
    ];

    $messages = [

        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'correo.max' => 'El máximo de caracteres permitidos son 255',
        'correo.unique' => 'Ups! Ya este correo ha sido registrado',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        // return redirect("alumno/edit/{$request->id}")

        // ->withErrors($validator)
        // ->withInput();

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }

    else{
        $instructor = Instructor::find($request->id);
        $correo = strtolower($request->correo);
        $instructor->correo = $correo;

        if($instructor->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function updateTelefono(Request $request){


        $instructor = Instructor::find($request->id);
        $instructor->telefono = $request->telefono;
        $instructor->celular = $request->celular;

        if($instructor->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }


    public function updateDireccion(Request $request){
        $instructor = Instructor::find($request->id);

        $direccion = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->direccion))));

        $instructor->direccion = $direccion;



        if($instructor->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateDiagnostico(Request $request){
        $instructor = Instructor::find($request->id);
        $instructor->experiencia_artistica = $request->experiencia_artistica;
        $instructor->experiencia_laboral = $request->experiencia_laboral;
        $instructor->nivel = $request->nivel;
        $instructor->especialidad = $request->especialidad;
        $instructor->observacion = $request->observacion;

       if($instructor->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateFicha(Request $request){
        $instructor = Instructor::find($request->id);
        $instructor->asma = $request->asma;
        $instructor->alergia = $request->alergia;
        $instructor->convulsiones = $request->convulsiones;
        $instructor->cefalea = $request->cefalea;
        $instructor->hipertension = $request->hipertension;
        $instructor->lesiones = $request->lesiones;

       if($instructor->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEstatus(Request $request){
        $instructor = Instructor::find($request->id);
        $instructor->estatus = $request->estatus;

        if($instructor->save()){
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
        if($instructor){
            $config['center'] = '10.6913156,-71.6800493';
            $config['zoom'] = 14;
            \Gmaps::initialize($config);

            $marker = array();
            $marker['position'] = '10.6913156,-71.6800493';
            $marker['draggable'] = true;
            $marker['ondragend'] = 'addFieldText(event.latLng.lat(), event.latLng.lng());';
            \Gmaps::add_marker($marker);


            $map = \Gmaps::create_map();
 
        //Devolver vista con datos del mapa
           return view('participante.instructor.planilla',['instructor'=>$instructor] ,compact('map'));
        }else{
           return redirect("participante/instructor"); 
        }
    }

    public function operar($id)
    {   
        $instructor = Instructor::find($id);
        
        return view('participante.instructor.operacion')->with(['id' => $id, 'instructor' => $instructor]);       
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

        $instructor = Instructor::find($id);
        
        if($instructor->delete()){
            return response()->json(['mensaje' => '¡Excelente! El instructor se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno");
    }
}