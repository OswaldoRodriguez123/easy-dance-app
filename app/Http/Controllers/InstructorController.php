<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Instructor;
use App\Academia;
use App\User;
use App\PerfilInstructor;
use Mail;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Image;
use DB;
use Illuminate\Support\Facades\Session;
use App\ConfigPagosInstructor;
use App\AsistenciaInstructor;
use App\PagoInstructor;

class InstructorController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    
    public function index()
    {

        if(Auth::user()->usuario_tipo != 2 AND Auth::user()->usuario_tipo != 4){

            return view('participante.instructor.principal')->with('instructores', Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get());
        }else{

             $academia = Academia::find(Auth::user()->academia_id);
             $instructor = Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->where('instructores.boolean_promocionar', 1)->get();

            return view('participante.instructor.principal_alumno')->with(['instructor_reserva' => $instructor, 'academia' => $academia]);

        }

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        return view('participante.instructor.create');
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
        'nombre' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'apellido' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'fecha_nacimiento' => 'required',
        'sexo' => 'required',
        'correo' => 'required|email|max:255|unique:users,email, '.$request->id.'',
    ];

    $messages = [

        'identificacion.required' => 'Ups! El identificador es requerido',
        'identificacion.min' => 'El mínimo de numeros permitidos son 5',
        'identificacion.max' => 'El maximo de numeros permitidos son 20',
        'identificacion.numeric' => 'Ups! El identificador es inválido , debe contener sólo números',
        'identificacion.unique' => 'Ups! Ya este usuario ha sido registrado',
        'nombre.required' => 'Ups! El Nombre  es requerido ',
        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre.max' => 'El máximo de caracteres permitidos son 20',
        'nombre.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
        'apellido.required' => 'Ups! El Apellido  es requerido ',
        'apellido.min' => 'El mínimo de caracteres permitidos son 3',
        'apellido.max' => 'El máximo de caracteres permitidos son 20',
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

        if($request->video_promocional){

            $parts = parse_url($request->video_promocional);

            if(isset($parts['host']))
            {
                if($parts['host'] == "www.youtube.com" || $parts['host'] == "www.youtu.be"){

                
                }else{
                    return response()->json(['errores' => ['video_promocional' => [0, 'Ups! ha ocurrido un error, debes ingresar un enlace de YouTube']], 'status' => 'ERROR'],422);
                }
            }else{
                    return response()->json(['errores' => ['video_promocional' => [0, 'Ups! ha ocurrido un error, debes ingresar un enlace de YouTube']], 'status' => 'ERROR'],422);
                }
            
            }

            if($request->video_testimonial){

            $parts = parse_url($request->video_testimonial);

            if(isset($parts['host']))
            {
                if($parts['host'] == "www.youtube.com" || $parts['host'] == "www.youtu.be"){

                
                }else{
                    return response()->json(['errores' => ['video_testimonial' => [0, 'Ups! ha ocurrido un error, debes ingresar un enlace de YouTube']], 'status' => 'ERROR'],422);
                }
            }else{
                    return response()->json(['errores' => ['video_testimonial' => [0, 'Ups! ha ocurrido un error, debes ingresar un enlace de YouTube']], 'status' => 'ERROR'],422);
                }
            
            }

        $edad = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->diff(Carbon::now())->format('%y');


        if($edad < 1){
            return response()->json(['errores' => ['fecha_nacimiento' => [0, 'Ups! Esta fecha es invalida, debes ingresar una fecha superior a 1 año de edad']], 'status' => 'ERROR'],422);
        }

        $nombre = title_case($request->nombre);
        $apellido = title_case($request->apellido);
        $direccion = $request->direccion;

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
        $instructor->descripcion = $request->descripcion;
        $instructor->video_promocional = $request->video_promocional;
        $instructor->resumen_artistico = $request->resumen_artistico;
        $instructor->video_testimonial = $request->video_testimonial;
        $instructor->boolean_promocionar = $request->boolean_promocionar;
        $instructor->boolean_disponibilidad = $request->boolean_disponibilidad;
        $instructor->boolean_administrador = $request->boolean_administrador;

        if($instructor->save()){

            if($request->imageBase64){

                $base64_string = substr($request->imageBase64, strpos($request->imageBase64, ",")+1);
                $path = storage_path();
                $split = explode( ';', $request->imageBase64 );
                $type =  explode( '/',  $split[0]);
                $ext = $type[1];
                
                if($ext == 'jpeg' || 'jpg'){
                    $extension = '.jpg';
                }

                if($ext == 'png'){
                    $extension = '.png';
                }

                $nombre_img = "instructor-". $instructor->id . $extension;
                $image = base64_decode($base64_string);

                // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
                $img = Image::make($image)->resize(1440, 500);
                $img->save('assets/uploads/instructor/'.$nombre_img);

                $instructor->imagen_artistica = $nombre_img;
                $instructor->save();

            }

            if($request->imagePerfilBase64){

                $base64_string = substr($request->imagePerfilBase64, strpos($request->imagePerfilBase64, ",")+1);
                $path = storage_path();
                $split = explode( ';', $request->imagePerfilBase64 );
                $type =  explode( '/',  $split[0]);
                $ext = $type[1];
                
                if($ext == 'jpeg' || 'jpg'){
                    $extension = '.jpg';
                }

                if($ext == 'png'){
                    $extension = '.png';
                }

                $nombre_img = "instructorp-". $instructor->id . $extension;
                $image = base64_decode($base64_string);

                // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
                $img = Image::make($image)->resize(300, 300);
                $img->save('assets/uploads/instructor/'.$nombre_img);

                $instructor->imagen = $nombre_img;
                $instructor->save();

            }

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

                if($request->imagePerfilBase64){

                    $nombre_img = "usuario-". $usuario->id . $extension;
                    $image = base64_decode($base64_string);

                    // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
                    $img = Image::make($image)->resize(300, 300);
                    $img->save('assets/uploads/usuario/'.$nombre_img);

                    $usuario->imagen = $nombre_img;
                    $usuario->save();

                }

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

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $instructor = Instructor::find($request->id);
        $instructor->identificacion = $request->identificacion;
        
        if($instructor->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        }
    }

    public function updateNombre(Request $request){

    $rules = [
        'nombre' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'apellido' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
    ];

    $messages = [

        'nombre.required' => 'Ups! El Nombre  es requerido ',
        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre.max' => 'El máximo de caracteres permitidos son 20',
        'nombre.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
        'apellido.required' => 'Ups! El Apellido  es requerido ',
        'apellido.min' => 'El mínimo de caracteres permitidos son 3',
        'apellido.max' => 'El máximo de caracteres permitidos son 20',
        'apellido.regex' => 'Ups! El apellido es inválido , debe ingresar sólo letras',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }
        $instructor = Instructor::find($request->id);

        $nombre = title_case($request->nombre);
        $apellido = title_case($request->apellido);

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
    }

    public function updateSexo(Request $request){
        $instructor = Instructor::find($request->id);
        $instructor->sexo = $request->sexo;

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

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

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

        $direccion = $request->direccion;

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

    public function updateRedes(Request $request){

        $instructor = Instructor::find($request->id);
        $instructor->facebook = $request->facebook;
        $instructor->twitter = $request->twitter;
        $instructor->instagram = $request->instagram;
        $instructor->pagina_web = $request->pagina_web;
        $instructor->linkedin = $request->linkedin;
        $instructor->youtube = $request->youtube;
        
        if($instructor->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateAvanzado(Request $request){
        $instructor = Instructor::find($request->id);

        $instructor->descripcion = $request->descripcion;
        $instructor->video_promocional = $request->video_promocional;
        $instructor->resumen_artistico = $request->resumen_artistico;
        $instructor->video_testimonial = $request->video_testimonial;
        $instructor->boolean_promocionar = $request->boolean_promocionar;
        $instructor->boolean_disponibilidad = $request->boolean_disponibilidad;
        $instructor->boolean_administrador = $request->boolean_administrador;

        if($request->imageBase64){

                $base64_string = substr($request->imageBase64, strpos($request->imageBase64, ",")+1);
                $path = storage_path();
                $split = explode( ';', $request->imageBase64 );
                $type =  explode( '/',  $split[0]);
                $ext = $type[1];
                
                if($ext == 'jpeg' || 'jpg'){
                    $extension = '.jpg';
                }

                if($ext == 'png'){
                    $extension = '.png';
                }

                $nombre_img = "instructor-". $instructor->id . $extension;
                $image = base64_decode($base64_string);

                // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
                $img = Image::make($image)->resize(1440, 500);
                $img->save('assets/uploads/instructor/'.$nombre_img);

                $instructor->imagen_artistica = $nombre_img;

        }

        if($instructor->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateImagen(Request $request)
    {
        $instructor = Instructor::find($request->id);
        
        if($request->imagePerfilBase64){
            $base64_string = substr($request->imagePerfilBase64, strpos($request->imagePerfilBase64, ",")+1);
            $path = storage_path();
            $split = explode( ';', $request->imagePerfilBase64 );
            $type =  explode( '/',  $split[0]);

            $ext = $type[1];
            
            if($ext == 'jpeg' || 'jpg'){
                $extension = '.jpg';
            }

            if($ext == 'png'){
                $extension = '.png';
            }

            $nombre_img = "instructorp-". $instructor->id . $extension;
            $image = base64_decode($base64_string);

            // \Storage::disk('taller')->put($nombre_img,  $image);
            $img = Image::make($image)->resize(300, 300);
            $img->save('assets/uploads/instructor/'.$nombre_img);

        }else{
            $nombre_img = "";
        }

        $instructor->imagen = $nombre_img;
        $instructor->save();

        $usuario = User::where('usuario_tipo',3)->where('usuario_id', $request->id)->first();

        if($usuario){

            if($request->imageBase64 AND $request->imageBase64 != 'data:,'){

                $nombre_img = "usuario-". Auth::user()->id . $extension;
                $image = base64_decode($base64_string);

                // \Storage::disk('usuario')->put($nombre_img,  $image);
                $img = Image::make($image)->resize(300, 300);
                $img->save('assets/uploads/usuario/'.$nombre_img);

            }else{
                $nombre_img = "";
            }

            $usuario->imagen = $nombre_img;
            $usuario->save();

        }

        return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
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

    public function perfil_evaluativo($id)
    {
        $perfil = PerfilInstructor::where('instructor_id', $id)->first();

        if(!$perfil){
            $perfil = new PerfilInstructor;
            $perfil->instructor_id = $id;
            $perfil->save();
        }

        return view('participante.instructor.planilla_evaluacion')->with(['id' => $id, 'perfil' => $perfil]);
    }

    public function perfil_instructor()
    {

        $instructores = DB::table('instructores')
            ->Leftjoin('perfil_instructor', 'perfil_instructor.instructor_id', '=', 'instructores.id')
            ->select('instructores.*' , 'perfil_instructor.*', 'instructores.id as id')
            ->where('instructores.id', Auth::user()->usuario_id)
        ->first();

        $academia = Academia::find($instructores->academia_id);

  
        return view('participante.instructor.promocionar')->with(['academia' => $academia, 'instructores_academia' => $instructores, 'id' => Auth::user()->usuario_id]);
    }

    public function storeExperiencia(Request $request)
    {
        
    $rules = [
        'tiempo_experiencia_instructor' => 'numeric',
        'genero_instructor' => 'numeric',
        'cantidad_horas' => 'numeric',
        'titulos_instructor' => 'numeric',
        'invitacion_evento' => 'numeric',
        'organizador' => 'numeric',
        'tiempo_experiencia_bailador' => 'numeric',
        'genero_bailador' => 'numeric',
        'participacion_coreografia' => 'numeric',
        'montajes' => 'numeric',
        'titulos_bailador' => 'numeric',
        'participacion_escenario' => 'numeric',
        
    ];

    $messages = [

        'tiempo_experiencia_instructor.numeric' => 'Ups! El campo es inválido , debe contener sólo números',
        'genero_instructor.numeric' => 'Ups! El campo es inválido , debe contener sólo números',
        'cantidad_horas.numeric' => 'Ups! El campo es inválido , debe contener sólo números',
        'titulos_instructor.numeric' => 'Ups! El campo es inválido , debe contener sólo números',
        'invitacion_evento.numeric' => 'Ups! El campo es inválido , debe contener sólo números',
        'organizador.numeric' => 'Ups! El campo es inválido , debe contener sólo números',
        'tiempo_experiencia_bailador.numeric' => 'Ups! El campo es inválido , debe contener sólo números',
        'genero_bailador.numeric' => 'Ups! El campo es inválido , debe contener sólo números',
        'participacion_coreografia.numeric' => 'Ups! El campo es inválido , debe contener sólo números',
        'montajes.numeric' => 'Ups! El campo es inválido , debe contener sólo números',
        'titulos_bailador.numeric' => 'Ups! El campo es inválido , debe contener sólo números',
        'participacion_escenario.numeric' => 'Ups! El campo es inválido , debe contener sólo números',

 
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

        $instructor = PerfilInstructor::where('instructor_id' , $request->id)->first();

        if(!$instructor){

            $instructor = new PerfilInstructor;
        }

        $instructor->instructor_id = $request->id;
        $instructor->tiempo_experiencia_instructor = $request->tiempo_experiencia_instructor;
        $instructor->genero_instructor = $request->genero_instructor;
        $instructor->cantidad_horas = $request->cantidad_horas;
        $instructor->titulos_instructor = $request->titulos_instructor;
        $instructor->invitacion_evento = $request->invitacion_evento;
        $instructor->organizador = $request->organizador;
        $instructor->tiempo_experiencia_bailador = $request->tiempo_experiencia_bailador;
        $instructor->genero_bailador = $request->genero_bailador;
        $instructor->participacion_coreografia = $request->participacion_coreografia;
        $instructor->montajes = $request->montajes;
        $instructor->titulos_bailador = $request->titulos_bailador;
        $instructor->participacion_escenario = $request->participacion_escenario;

        if($instructor->save()){
            return response()->json(['mensaje' => '¡Excelente! El instructor se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function operar($id)
    {   
        $instructor = Instructor::find($id);
        
        return view('participante.instructor.operacion')->with(['id' => $id, 'instructor' => $instructor]);       
    }

    public function progreso($id)
    {

        $instructores = DB::table('instructores')
            ->Leftjoin('perfil_instructor', 'perfil_instructor.instructor_id', '=', 'instructores.id')
            ->select('instructores.*' , 'perfil_instructor.*', 'instructores.id as id')
            ->where('instructores.id', $id)
        ->first();

        $academia = Academia::find($instructores->academia_id);

  
        return view('participante.instructor.promocionar')->with(['academia' => $academia, 'instructores_academia' => $instructores, 'id' => $id]);
    }

    public function sesion(Request $request)
    {

        Session::put('instructor_id', $request->instructor_id);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

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

    public function pagos_vista_instructor()
    {

        $instructor = Instructor::find(Auth::user()->usuario_id);

        if($instructor)
        {

            $pagadas = DB::table('pagos_instructor')
                ->join('clases_grupales', 'pagos_instructor.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('pagos_instructor.created_at as fecha', 'config_clases_grupales.nombre as clase', 'instructores.nombre as nombre_instructor', 'instructores.apellido as apellido_instructor', 'pagos_instructor.monto', 'pagos_instructor.tipo')
                ->where('instructores.id', Auth::user()->usuario_id)
                ->where('pagos_instructor.boolean_clase_pagada', 1)
            ->get();


            $por_pagar = DB::table('pagos_instructor')
                ->join('clases_grupales', 'pagos_instructor.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('pagos_instructor.created_at as fecha', 'config_clases_grupales.nombre as clase', 'instructores.nombre as nombre_instructor', 'instructores.apellido as apellido_instructor',  'pagos_instructor.monto', 'pagos_instructor.id', 'pagos_instructor.tipo')
                ->where('instructores.id', Auth::user()->usuario_id)
                ->where('pagos_instructor.boolean_clase_pagada', 0)
                ->where('pagos_instructor.monto', '>', 0)
            ->get();

            $total = DB::table('pagos_instructor')
                ->select('pagos_instructor.*')
                ->where('pagos_instructor.instructor_id', Auth::user()->usuario_id)
                ->where('pagos_instructor.boolean_clase_pagada', 0)
            ->sum('pagos_instructor.monto');

            $pagos_instructor = DB::table('configuracion_pagos_instructor')
                ->join('clases_grupales', 'configuracion_pagos_instructor.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('configuracion_pagos_instructor.id', 'configuracion_pagos_instructor.monto', 'config_clases_grupales.nombre as nombre', 'configuracion_pagos_instructor.clase_grupal_id as clase_grupal_id', 'configuracion_pagos_instructor.tipo as tipo')
                ->where('instructores.id', Auth::user()->usuario_id)
            ->get();

            $clase_grupal_join = DB::table('clases_grupales')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('clases_grupales.id', 'config_clases_grupales.nombre')
                ->where('clases_grupales.instructor_id', Auth::user()->usuario_id)
            ->get();

            return view('participante.instructor.pagos')->with(['pagadas'=> $pagadas, 'por_pagar' => $por_pagar, 'total' => $total, 'instructor' => $instructor, 'pagos_instructor' => $pagos_instructor, 'clases_grupales' => $clase_grupal_join, 'id' => Auth::user()->usuario_id ]);
        }else{ 

            return redirect("participante/instructor"); 
        }
    }

    public function principalpagos($id)
    {

        $instructor = Instructor::find($id);

        if($instructor)
        {

            $pagadas = DB::table('pagos_instructor')
                ->join('clases_grupales', 'pagos_instructor.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('pagos_instructor.created_at as fecha', 'config_clases_grupales.nombre as clase', 'instructores.nombre as nombre_instructor', 'instructores.apellido as apellido_instructor', 'pagos_instructor.monto', 'pagos_instructor.tipo')
                ->where('instructores.id', $id)
                ->where('pagos_instructor.boolean_clase_pagada', 1)
            ->get();


            $por_pagar = DB::table('pagos_instructor')
                ->join('clases_grupales', 'pagos_instructor.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('pagos_instructor.created_at as fecha', 'config_clases_grupales.nombre as clase', 'instructores.nombre as nombre_instructor', 'instructores.apellido as apellido_instructor',  'pagos_instructor.monto', 'pagos_instructor.id', 'pagos_instructor.tipo')
                ->where('instructores.id', $id)
                ->where('pagos_instructor.boolean_clase_pagada', 0)
                ->where('pagos_instructor.monto', '>', 0)
            ->get();

            $total = DB::table('pagos_instructor')
                ->select('pagos_instructor.*')
                ->where('pagos_instructor.instructor_id', $id)
                ->where('pagos_instructor.boolean_clase_pagada', 0)
            ->sum('pagos_instructor.monto');

            $pagos_instructor = DB::table('configuracion_pagos_instructor')
                ->join('clases_grupales', 'configuracion_pagos_instructor.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                ->select('configuracion_pagos_instructor.id', 'configuracion_pagos_instructor.monto', 'config_clases_grupales.nombre as nombre', 'configuracion_pagos_instructor.clase_grupal_id as clase_grupal_id', 'configuracion_pagos_instructor.tipo as tipo')
                ->where('instructores.id', $id)
            ->get();

            $clase_grupal_join = DB::table('clases_grupales')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('clases_grupales.id', 'config_clases_grupales.nombre')
                ->where('clases_grupales.instructor_id', $id)
            ->get();

            return view('participante.instructor.pagos')->with(['pagadas'=> $pagadas, 'por_pagar' => $por_pagar, 'total' => $total, 'instructor' => $instructor, 'pagos_instructor' => $pagos_instructor, 'clases_grupales' => $clase_grupal_join, 'id' => $id ]);
        }else{ 

            return redirect("participante/instructor"); 
        }
    }


    public function agregarpago(Request $request)
    {
        
        $rules = [
            'cantidad' => 'required|numeric',
            'tipo_pago' => 'required'
        ];

        $messages = [

            'cantidad.required' => 'Ups! El Monto es requerido',
            'cantidad.numeric' => 'Ups! El Monto es invalido, solo se aceptan numeros',
            
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

            $array = array();

            if($request->clase_grupal_id != 'null'){

                $clases_grupales = explode(",", $request->clase_grupal_id);

                foreach($clases_grupales as $clase_grupal){

                    $posee_pago = DB::table('configuracion_pagos_instructor')
                        ->select('configuracion_pagos_instructor.*')
                        ->where('configuracion_pagos_instructor.instructor_id', $request->id)
                        ->where('configuracion_pagos_instructor.clase_grupal_id', $clase_grupal)
                    ->first();


                    if(!$posee_pago){

                        $config_pagos = new ConfigPagosInstructor;

                        $config_pagos->clase_grupal_id = $clase_grupal;
                        $config_pagos->instructor_id = $request->id;
                        $config_pagos->tipo = $request->tipo_pago;
                        $config_pagos->monto = $request->cantidad;

                        $config_pagos->save();

                        $clase_grupal_join = DB::table('clases_grupales')
                            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                            ->select('config_clases_grupales.nombre')
                            ->where('clases_grupales.id', $clase_grupal)
                        ->first();

                        $config_pagos['nombre'] = $clase_grupal_join->nombre;

                        array_push($array, $config_pagos);


                    }

                }


            }else{

                $clases_grupales = DB::table('clases_grupales')
                        ->select('clases_grupales.id')
                        ->where('clases_grupales.instructor_id', $request->id)
                    ->get();

                foreach($clases_grupales as $clase_grupal){

                    $posee_pago = DB::table('configuracion_pagos_instructor')
                        ->select('configuracion_pagos_instructor.*')
                        ->where('configuracion_pagos_instructor.instructor_id', $request->id)
                        ->where('configuracion_pagos_instructor.clase_grupal_id', $clase_grupal->id)
                    ->first();

                    if(!$posee_pago){

                        $config_pagos = new ConfigPagosInstructor;

                        $config_pagos->clase_grupal_id = $clase_grupal->id;
                        $config_pagos->instructor_id = $request->id;
                        $config_pagos->tipo = $request->tipo_pago;
                        $config_pagos->monto = $request->cantidad;

                        $config_pagos->save();

                        $clase_grupal_join = DB::table('clases_grupales')
                            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                            ->select('config_clases_grupales.nombre')
                            ->where('clases_grupales.id', $clase_grupal->id)
                        ->first();

                        $config_pagos['nombre'] = $clase_grupal_join->nombre;

                        array_push($array, $config_pagos);


                    }

                }

            }

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 200]);   
        }
    }

    public function eliminarpago($id)
    {

        $pago = ConfigPagosInstructor::find($id);
        
        if($pago->delete()){
            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 'id' => $pago->clase_grupal_id, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno");
    }

    public function pagar(Request $request)
    {
        $rules = [
            'asistencias' => 'required',
        ];

        $messages = [

            'asistencias.required' => 'Ups! Debe seleccionar un pago',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){


            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{
        
            $asistencias = explode(",", $request->asistencias);
            $array = array();

            foreach($asistencias as $asistencia)
            {
                if($asistencia != ''){

                    $pago = PagoInstructor::find($asistencia);
                    $pago->boolean_clase_pagada = 1;

                    $pago->save();

                    array_push($array,$asistencia);

                }
            }


            return response()->json(['mensaje' => '¡Excelente! El pago ha sido realizado satisfactoriamente', 'status' => 'OK', 'array' => $array, 200]);

        }
    }
}