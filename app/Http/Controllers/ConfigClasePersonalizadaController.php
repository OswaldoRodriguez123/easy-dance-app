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
use App\ConfigServicios;
use App\Instructor;
use App\Alumno;
use App\Academia;
use App\CitaClasePersonalizada;
use App\CostoClasePersonalizada;
use App\ItemsFacturaProforma;
use App\InscripcionClasePersonalizada;
use Mail;
use Validator;
use DB;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;
use Image;

class ConfigClasePersonalizadaController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {

        $clases_personalizadas = ClasePersonalizada::where('academia_id', Auth::user()->academia_id)->get();

        $config_clase_personalizada = ConfigClasesPersonalizadas::where('academia_id', Auth::user()->academia_id)->first();

        if(!$config_clase_personalizada)
        {
            $config_clase_personalizada = new ConfigClasesPersonalizadas;

            $config_clase_personalizada->academia_id = Auth::user()->academia_id;
            $config_clase_personalizada->imagen_principal = '';
            $config_clase_personalizada->descripcion = '';
            $config_clase_personalizada->video_promocional = '';
            $config_clase_personalizada->imagen1 = '';
            $config_clase_personalizada->imagen2 = '';
            $config_clase_personalizada->imagen3 = '';
            $config_clase_personalizada->ventajas = '';
            $config_clase_personalizada->condiciones = '';

            $config_clase_personalizada->save();
            
        }

        return view('configuracion.clase_personalizada.index')->with(['clases_personalizadas' => $clases_personalizadas, 'config_clase_personalizada' => $config_clase_personalizada]);
        
    }

    public function indexconacademia($id)
    {

        $clases_personalizadas = ClasePersonalizada::where('academia_id', $id)->get();

        $config_clase_personalizada = ConfigClasesPersonalizadas::where('academia_id', $id)->first();

        if(!$config_clase_personalizada)
        {
            $config_clase_personalizada = new ConfigClasesPersonalizadas;

            $config_clase_personalizada->academia_id = $id;
            $config_clase_personalizada->imagen_principal = '';
            $config_clase_personalizada->descripcion = '';
            $config_clase_personalizada->video_promocional = '';
            $config_clase_personalizada->imagen1 = '';
            $config_clase_personalizada->imagen2 = '';
            $config_clase_personalizada->imagen3 = '';
            $config_clase_personalizada->ventajas = '';
            $config_clase_personalizada->condiciones = '';

            $config_clase_personalizada->save();
            
        }

        $academia = Academia::find($id);

        return view('agendar.clase_personalizada.principal_alumno')->with(['clases_personalizadas' => $clases_personalizadas, 'academia' => $academia]);

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // if (Session::has('horario')) {
        //     Session::forget('horario'); 
        // }

        if (Session::has('precios')) {
            Session::forget('precios'); 
        }

        return view('configuracion.clase_personalizada.create')->with(['alumnos' => Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get(), 'dias_de_semana' => DiasDeSemana::all(), 'especialidad' => ConfigEspecialidades::all(), 'estudio' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'instructor' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get()]);

    }

    public function reservacion($id)
    {
        $clase_personalizada = ClasePersonalizada::find($id);
        $academia_id = $clase_personalizada->academia_id;
        $config_clase_personalizada = ConfigClasesPersonalizadas::where('academia_id', $academia_id)->first();
        
        if(!$config_clase_personalizada)
        {

            $config_clase_personalizada = new ConfigClasesPersonalizadas;

            $config_clase_personalizada->academia_id = $academia_id;
            $config_clase_personalizada->imagen_principal = '';
            $config_clase_personalizada->descripcion = '';
            $config_clase_personalizada->video_promocional = '';
            $config_clase_personalizada->imagen1 = '';
            $config_clase_personalizada->imagen2 = '';
            $config_clase_personalizada->imagen3 = '';
            $config_clase_personalizada->ventajas = '';
            $config_clase_personalizada->condiciones = '';

            $config_clase_personalizada->save();
            
        }

        $instructor_id = Session::get('instructor_id');

        $academia_id = Auth::user()->academia_id;
        $usuario_tipo = Session::get('easydance_usuario_tipo');

        return view('agendar.clase_personalizada.reservar')->with(['especialidad' => ConfigEspecialidades::all(), 'instructor' => Instructor::where('academia_id', '=' ,  $academia_id)->get(), 'condiciones' => $config_clase_personalizada->condiciones, 'clases_personalizadas' => ClasePersonalizada::where('academia_id', '=' ,  $academia_id)->get(), 'id' => $academia_id, 'clase_personalizada_id' => $id, 'instructor_id' => $instructor_id, 'usuario_tipo' => $usuario_tipo]);
        
    }

    public function operar($id)
    {   

        $clase_personalizada = ClasePersonalizada::find($id);

        if($clase_personalizada)
        {

            return view('configuracion.clase_personalizada.operacion')->with(['id' => $id, 'clase_personalizada' => $clase_personalizada]); 

        }else{
            return redirect("agendar/clases-personalizadas"); 
        }    
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

        'nombre' => 'required',
        'costo' => 'required|numeric',
        'cantidad_horas' => 'required|numeric',
        'color_etiqueta' => 'required',
        'tiempo_expiracion' => 'numeric',

    ];

    $messages = [

        'nombre.required' => 'Ups! El Nombre  es requerido',
        'costo.numeric' => 'Ups! El costo es inv??lido, debe contener s??lo n??meros',
        'costo.required' => 'Ups! El costo es requerido',
        'cantidad_horas.numeric' => 'Ups! La cantidad de horas es inv??lida, debe contener s??lo n??meros',
        'cantidad_horas.required' => 'Ups! La cantidad de horas son requeridas',
        'color_etiqueta.required' => 'Ups! La etiqueta es requerida',
        'tiempo_expiracion.numeric' => 'Ups! El Tiempo de expiraci??n es inv??lido, debe contener s??lo  n??meros',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        if($request->color_etiqueta == "#"){
            return response()->json(['errores' => ['color_etiqueta' => [0, 'Ups! El color de la etiqueta es requerido']], 'status' => 'ERROR'],422);
        }

        $nombre = $this->slugify($request->nombre);
        $nombre = title_case($nombre);

        $clasepersonalizada = new ClasePersonalizada;

        $clasepersonalizada->academia_id = Auth::user()->academia_id;
        $clasepersonalizada->nombre = $nombre;
        $clasepersonalizada->costo = $request->costo;
        $clasepersonalizada->cantidad_horas = $request->cantidad_horas;
        $clasepersonalizada->descripcion = $request->descripcion;
        $clasepersonalizada->color_etiqueta = $request->color_etiqueta;
        $clasepersonalizada->tiempo_expiracion = $request->tiempo_expiracion;

        // return redirect("/home")
        if($clasepersonalizada->save()){

            $servicio = new ConfigServicios;
            
            $servicio->academia_id = Auth::user()->academia_id;
            $servicio->nombre = $nombre;
            $servicio->costo = $request->costo;
            $servicio->imagen = '';
            $servicio->descripcion = $request->descripcion;
            $servicio->incluye_iva = 0;
            $servicio->tipo = 9;
            $servicio->tipo_id = $clasepersonalizada->id;

            $servicio->save();

            $clasepersonalizada->servicio_id = $servicio->id;
            $clasepersonalizada->save();

            $precios = Session::get('precios');

            if(count($precios) > 0){

                foreach ($precios as $precio) {

                    $costo = new CostoClasePersonalizada;

                    $costo->clase_personalizada_id = $clasepersonalizada->id;
                    $costo->participantes = $precio[0]['participantes'];
                    $costo->precio = $precio[0]['precio'];
                    $costo->save();
                }

            }


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

                $nombre_img = "clasepersonalizada2-". $clasepersonalizada->id . $extension;
                $image = base64_decode($base64_string);

                // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
                $img = Image::make($image)->resize(300, 300);
                $img->save('assets/uploads/clase_personalizada/'.$nombre_img);

                $clasepersonalizada->imagen = $nombre_img;
                $clasepersonalizada->save();

            }

            if (Session::has('precios')) {
                Session::forget('precios'); 
            }

           
            return response()->json(['mensaje' => '??Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

     public function updateNombre(Request $request){

        $clasepersonalizada = ClasePersonalizada::find($request->id);
        $nombre = $this->slugify($request->nombre);
        $nombre = title_case($nombre);
        $clasepersonalizada->nombre = $nombre;

        if($clasepersonalizada->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'nombre' => 'nombre', 'valor' => $nombre, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateCosto(Request $request){

    $rules = [

        'costo' => 'required|numeric',

    ];

    $messages = [

        'costo.numeric' => 'Ups! El costo es inv??lido, debe contener s??lo  n??meros',
        'costo.required' => 'Ups! El costo es requerido',

    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

            $clasepersonalizada = ClasePersonalizada::find($request->id);
            $clasepersonalizada->costo = $request->costo;

            if($clasepersonalizada->save()){
                return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateHora(Request $request){

    $rules = [

        'cantidad_horas' => 'required|numeric',

    ];

    $messages = [

        'cantidad_horas.numeric' => 'Ups! La cantidad de horas es inv??lida, debe contener s??lo n??meros',
        'cantidad_horas.required' => 'Ups! La cantidad de horas son requeridas',

    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

            $clasepersonalizada = ClasePersonalizada::find($request->id);
            $clasepersonalizada->cantidad_horas = $request->cantidad_horas;

            if($clasepersonalizada->save()){
                return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateImagen(Request $request)
    {
                $clasepersonalizada = ClasePersonalizada::find($request->id);
                
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

                    $nombre_img = "clasepersonalizada2-". $clasepersonalizada->id . $extension;
                    $image = base64_decode($base64_string);

                    // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
                    $img = Image::make($image)->resize(300, 300);
                    $img->save('assets/uploads/clase_personalizada/'.$nombre_img);
                }
                else{
                    $nombre_img = "";
                }

                $clasepersonalizada->imagen = $nombre_img;
                $clasepersonalizada->save();

                return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
    }

    public function updateFecha(Request $request){

    $request->merge(array('fecha_inicio' => trim($request->fecha_inicio)));

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

            $fecha_inicio = Carbon::createFromFormat('d/m/Y', $request->fecha_inicio);

            if($fecha_inicio < Carbon::now()){

                return response()->json(['errores' => ['fecha_inicio' => [0, 'Ups! ha ocurrido un error. La fecha de la clase no puede ser menor al dia de hoy']], 'status' => 'ERROR'],422);
            }

            $clasepersonalizada = ClasePersonalizada::find($request->id);

            $fecha_inicio = $fecha_inicio->toDateString();

            $clasepersonalizada->fecha_inicio = $fecha_inicio;
            $clasepersonalizada->fecha_final = $fecha_inicio;

            if($clasepersonalizada->save()){
                return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateEspecialidad(Request $request){
        $clasepersonalizada = ClasePersonalizada::find($request->id);
        $clasepersonalizada->especialidad_id = $request->especialidad_id;

        if($clasepersonalizada->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateAlumno(Request $request){
        $clasepersonalizada = ClasePersonalizada::find($request->id);
        $clasepersonalizada->alumno_id = $request->alumno_id;

        if($clasepersonalizada->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateInstructor(Request $request){
        $clasepersonalizada = ClasePersonalizada::find($request->id);
        $clasepersonalizada->instructor_id = $request->instructor_id;

        if($clasepersonalizada->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEstudio(Request $request){
        $clasepersonalizada = ClasePersonalizada::find($request->id);
        $clasepersonalizada->estudio_id = $request->estudio_id;

        if($clasepersonalizada->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEtiqueta(Request $request){

        if($request->color_etiqueta == "#"){
            return response()->json(['errores' => ['color_etiqueta' => [0, 'Ups! El color de la etiqueta es requerido']], 'status' => 'ERROR'],422);
        }
        
        $clasepersonalizada = ClasePersonalizada::find($request->id);
        $clasepersonalizada->color_etiqueta = $request->color_etiqueta;

        if($clasepersonalizada->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
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
                return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }


    public function updateExpiracion(Request $request){

    $rules = [

        'tiempo_expiracion' => 'numeric',

    ];

    $messages = [

        'tiempo_expiracion.numeric' => 'Ups! El Tiempo de expiraci??n es inv??lido, debe contener s??lo  n??meros',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

            $clasepersonalizada = ClasePersonalizada::find($request->id);
            $clasepersonalizada->tiempo_expiracion = $request->tiempo_expiracion;

            if($clasepersonalizada->save()){
                return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateDescripcion(Request $request){

        $clasepersonalizada = ClasePersonalizada::find($request->id);
        $clasepersonalizada->descripcion = $request->descripcion;

        if($clasepersonalizada->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'nombre' => 'nombre', 'valor' => $nombre, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function configuracion(Request $request){

        $config_clase_personalizada = ConfigClasesPersonalizadas::where('academia_id', Auth::user()->academia_id)->first();

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

                    $nombre_img = "clasepersonalizada-". $config_clase_personalizada->academia_id . $extension;
                    $image = base64_decode($base64_string);

                    // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
                    $img = Image::make($image)->resize(1440, 500);
                    $img->save('assets/uploads/clase_personalizada/'.$nombre_img);
                }
                else{
                    $nombre_img = "";
            }

        if($config_clase_personalizada)
        {
            $config_clase_personalizada->imagen_principal = $nombre_img;
            $config_clase_personalizada->descripcion = $request->descripcion;
            $config_clase_personalizada->video_promocional =  $request->video_promocional;
            $config_clase_personalizada->ventajas = $request->ventajas;
            $config_clase_personalizada->condiciones = $request->condiciones;
        }else{

            $config_clase_personalizada = new ConfigClasesPersonalizadas;

            $config_clase_personalizada->academia_id = Auth::user()->academia_id;
            $config_clase_personalizada->imagen_principal = '';
            $config_clase_personalizada->descripcion = '';
            $config_clase_personalizada->video_promocional = '';
            $config_clase_personalizada->imagen1 = '';
            $config_clase_personalizada->imagen2 = '';
            $config_clase_personalizada->imagen3 = '';
            $config_clase_personalizada->ventajas = '';
            $config_clase_personalizada->condiciones = '';
        }


        if($config_clase_personalizada->save()){
            return response()->json(['mensaje' => '??Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
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
        $find = ClasePersonalizada::find($id);

        if ($find) {
            // $clase_personalizada_join = DB::table('clases_personalizadas')
            // ->join('config_especialidades', 'clases_personalizadas.especialidad_id', '=', 'config_especialidades.id')
            // ->join('config_estudios', 'clases_personalizadas.estudio_id', '=', 'config_estudios.id')
            // ->leftJoin('instructores', 'clases_personalizadas.instructor_id', '=', 'instructores.id')
            // ->join('alumnos', 'clases_personalizadas.alumno_id', '=', 'alumnos.id')
            // ->select('config_especialidades.nombre as especialidad_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','config_estudios.nombre as estudio_nombre' , 'clases_personalizadas.fecha_inicio as fecha_inicio', 'clases_personalizadas.hora_inicio','clases_personalizadas.hora_final', 'alumnos.nombre as alumno_nombre', 'alumnos.apellido as alumno_apellido', 'clases_personalizadas.id', 'clases_personalizadas.color_etiqueta', 'clases_personalizadas.tiempo_expiracion')
            // ->where('clases_personalizadas.id', '=', $id)
            // ->first();

            // $hora_string = $find->fecha_inicio . ' ' . $find->hora_inicio;
        
            // $hora = Carbon::createFromFormat('Y-m-d H:i:s', $hora_string);
            // $hora_limite = $hora->subHours($find->tiempo_expiracion);

            // if(Carbon::now() > $hora_limite)
            // {
            //     $cancelacion = 'Cancelaci??n Tardia';
            // }else{
            //     $cancelacion = 'Cancelaci??n Temprana';
            // }

            $precios = CostoClasePersonalizada::where('clase_personalizada_id','=',$id)->get();

            return view('configuracion.clase_personalizada.planilla')->with(['config_especialidades' => ConfigEspecialidades::all(), 'config_estudios' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'alumno' => Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'instructor' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'clasepersonalizada' => $find, 'precios' => $precios]);

        }else{
           return redirect("configuracion/clases-personalizadas"); 
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function participantes($id)
    {

        $clasepersonalizada = ClasePersonalizada::find($id);

        $activas = DB::table('inscripcion_clase_personalizada')
                ->join('alumnos', 'inscripcion_clase_personalizada.alumno_id', '=', 'alumnos.id')
                ->select('alumnos.*', 'inscripcion_clase_personalizada.id as clase_personalizada_id')
                ->where('inscripcion_clase_personalizada.clase_personalizada_id', '=', $id)
                ->where('inscripcion_clase_personalizada.estatus', 1)
        ->get();


        $canceladas = DB::table('inscripcion_clase_personalizada')
                ->join('alumnos', 'inscripcion_clase_personalizada.alumno_id', '=', 'alumnos.id')
                ->select('alumnos.*', 'inscripcion_clase_personalizada.id as clase_personalizada_id')
                ->where('inscripcion_clase_personalizada.clase_personalizada_id', '=', $id)
                ->where('inscripcion_clase_personalizada.estatus', 0)
        ->get();


        $alumnos = Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

        return view('configuracion.clase_personalizada.participantes')->with(['alumnos' => $alumnos, 'activas' => $activas, 'canceladas' => $canceladas, 'id' => $id, 'clasepersonalizada' => $clasepersonalizada, 'config_especialidades' => ConfigEspecialidades::all(), 'config_estudios' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'instructor' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get()]);
    }

    public function storeInscripcion(Request $request)
    {

    Session::forget('id_alumno');

    $rules = [
        'clase_personalizada_id' => 'required',
        'alumno_id' => 'required',
        'fecha_inicio' => 'required',
        'hora_inicio' => 'required',
        'hora_final' => 'required',
        'especialidad_id' => 'required',
        'instructor_id' => 'required',
        'estudio_id' => 'required',
        
    ];

    $messages = [
        'clase_personalizada_id.required' => 'Ups! El Nombre es requerido',
        'alumno_id.required' => 'Ups! El Alumno es requerido',
        'fecha_inicio.required' => 'Ups! La fecha es requerida',
        'instructor_id.required' => 'Ups! El instructor es requerido',
        'hora_inicio.required' => 'Ups! La hora de inicio es requerida',
        'hora_final.required' => 'Ups! La hora final es requerida',
        'especialidad_id.required' => 'Ups! La especialidad es requerida ',
        'estudio_id.required' => 'Ups! El estudio o sal??n es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $hora_inicio = strtotime($request->hora_inicio);
        $hora_final = strtotime($request->hora_final);
        $fecha_inicio = Carbon::createFromFormat('d/m/Y', $request->fecha_inicio);

        if($hora_inicio > $hora_final)
        {

            return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
        }

        if($fecha_inicio < Carbon::now()){

            return response()->json(['errores' => ['fecha_inicio' => [0, 'Ups! ha ocurrido un error. La fecha de la clase no puede ser menor al dia de hoy']], 'status' => 'ERROR'],422);
        }

        $clasepersonalizada = new InscripcionClasePersonalizada;
        
        $fecha_inicio = $fecha_inicio->toDateString();

        $clasepersonalizada->clase_personalizada_id =  $request->clase_personalizada_id;
        $clasepersonalizada->fecha_inicio = $fecha_inicio;
        $clasepersonalizada->fecha_final = $fecha_inicio;
        $clasepersonalizada->instructor_id = $request->instructor_id;
        $clasepersonalizada->hora_inicio = $request->hora_inicio;
        $clasepersonalizada->hora_final = $request->hora_final;
        $clasepersonalizada->alumno_id = $request->alumno_id;
        $clasepersonalizada->especialidad_id = $request->especialidad_id;
        $clasepersonalizada->estudio_id = $request->estudio_id;

        // return redirect("/home");
        if($clasepersonalizada->save()){

            $clase_personalizada = ClasePersonalizada::find($request->clase_personalizada_id);

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
            $item_factura->importe_neto = $clase_personalizada->costo;
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
               'subj' => $subj2,
               'id' => $clasepersonalizada->id
            ];

            Mail::send('correo.clase_personalizada_instructor', $array, function($msj) use ($array){
                    $msj->subject($array['subj']);
                    $msj->to($array['correo']);
                });

            Mail::send('correo.clase_personalizada_alumno', $array2, function($msj) use ($array2){
                    $msj->subject($array2['subj']);
                    $msj->to($array2['correo']);
                });

            return response()->json(['mensaje' => '??Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'id' => $request->alumno_id, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */

    public function cancelar(Request $request)
    {
        $inscripcion_clase_personalizada = InscripcionClasePersonalizada::find($request->clasepersonalizada_id);

        $clasepersonalizada = ClasePersonalizada::find($inscripcion_clase_personalizada->clase_personalizada_id);

        $hora_string = $inscripcion_clase_personalizada->fecha_inicio . ' ' . $inscripcion_clase_personalizada->hora_inicio;
        
        $hora = Carbon::createFromFormat('Y-m-d H:i:s', $hora_string);
        $hora_limite = $hora->subHours($clasepersonalizada->tiempo_expiracion);

        if(Carbon::now() < $hora_limite)
        {
            $item_proforma = ItemsFacturaProforma::where('tipo', 9)->where('item_id', $request->id)->first();

            if($item_proforma){
                if($item_proforma->delete()){

                    $inscripcion_clase_personalizada->estatus = 0;
                    $inscripcion_clase_personalizada->razon_cancelacion = $request->razon_cancelacion;
                    
                    if($inscripcion_clase_personalizada->save()){
                        return response()->json(['mensaje' => '??Excelente! La Clase Personalizada se ha cancelado satisfactoriamente', 'status' => 'OK', 200]);
                    }else{
                        return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                    }
                }
            }else{
                    $inscripcion_clase_personalizada->estatus = 0;
                    $inscripcion_clase_personalizada->razon_cancelacion = $request->razon_cancelacion;
                    
                    if($inscripcion_clase_personalizada->save()){
                        return response()->json(['mensaje' => '??Excelente! La Clase Personalizada se ha cancelado satisfactoriamente', 'status' => 'OK', 200]);
                    }else{
                        return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                    }
            }
        }else{
            return response()->json(['error_mensaje'=> 'Ups! Esta clase personalizada no puede ser cancelada ya que posee cancelaci??n tardia' , 'status' => 'ERROR-BORRADO'],422);
        }
    }

    public function cancelarpermitir(Request $request)
    {
        $inscripcion_clase_personalizada = InscripcionClasePersonalizada::find($request->id);

        $inscripcion_clase_personalizada->estatus = 0;
        $inscripcion_clase_personalizada->razon_cancelacion = $request->razon_cancelacion;
            
        if($inscripcion_clase_personalizada->save()){
            return response()->json(['mensaje' => '??Excelente! La Clase Personalizada se ha cancelado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function progreso($id)
    {

        $academia = Academia::find($id);
        $usuario_tipo = Session::get('easydance_usuario_tipo');

        $instructores = Instructor::Leftjoin('perfil_instructor', 'perfil_instructor.instructor_id', '=', 'instructores.id')
            ->select('instructores.*' , 'perfil_instructor.*', 'instructores.id as id')
            ->where('academia_id', $id)
            ->where('boolean_promocionar', 1)
            ->orderBy('instructores.nombre', 'asc')
        ->get();

        $config_clase_personalizada = ConfigClasesPersonalizadas::where('academia_id', $id)->first();

        if(!$config_clase_personalizada)
        {
            $config_clase_personalizada = new ConfigClasesPersonalizadas;

            $config_clase_personalizada->academia_id = Auth::user()->academia_id;
            $config_clase_personalizada->imagen_principal = '';
            $config_clase_personalizada->descripcion = '';
            $config_clase_personalizada->video_promocional = '';
            $config_clase_personalizada->imagen1 = '';
            $config_clase_personalizada->imagen2 = '';
            $config_clase_personalizada->imagen3 = '';
            $config_clase_personalizada->ventajas = '';
            $config_clase_personalizada->condiciones = '';

            $config_clase_personalizada->save();
            
        }


        if($config_clase_personalizada->video_promocional){
            $parts = parse_url($config_clase_personalizada->video_promocional);
            $partes = explode( '=', $parts['query'] );
            $link_video = $partes[1];
        }else{
            $link_video = '';
        }

        return view('configuracion.clase_personalizada.promocionar')->with(['link_video' => $link_video, 'academia' => $academia, 'instructores' => $instructores, 'id' => $id, 'config_clase_personalizada' => $config_clase_personalizada, 'usuario_tipo' => $usuario_tipo]);
    }

    public function destroy($id)
    {
        $clasepersonalizada = ClasePersonalizada::find($id);
        
        if($clasepersonalizada->delete()){

            $delete = ConfigServicios::where('tipo',9)->where('tipo_id',$id)->delete();
            return response()->json(['mensaje' => '??Excelente! La Clase Personalizada se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function agregar_costo(Request $request){

        
    $rules = [

        'participantes' => 'required|numeric',
        'precio' => 'required|numeric',
    ];

    $messages = [

        'participantes.required' => 'Ups! La cantidad de participantes es requerida',
        'precio.required' => 'Ups! El Costo es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $array = array(['participantes' => $request->participantes, 'precio' => $request->precio]);

        Session::push('precios', $array);

        $item = Session::get('precios');
        end( $item );
        $contador = key( $item );

         return response()->json(['mensaje' => '??Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'participantes' => $request->participantes, 'precio' => $request->precio, 'id' => $contador, 200]);

        }
    }

    public function eliminar_costo($id){

        $arreglo = Session::get('precios');

        unset($arreglo[$id]);
        Session::put('precios', $arreglo);

        return response()->json(['mensaje' => '??Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function agregar_costo_fijo(Request $request){
        
    $rules = [

        'participantes' => 'required|numeric',
        'precio' => 'required|numeric',
    ];

    $messages = [

        'participantes.required' => 'Ups! La cantidad de participantes es requerida',
        'precio.required' => 'Ups! El Costo es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $costo = new CostoClasePersonalizada;
                                        
        $costo->clase_personalizada_id = $request->id;
        $costo->participantes = $request->participantes;
        $costo->precio = $request->precio;

        if($costo->save()){
            return response()->json(['mensaje' => '??Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'participantes' => $request->participantes, 'precio' => $request->precio, 'id' => $costo->id, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

        }
    }

    public function eliminar_costo_fijo($id){

        $costo = CostoClasePersonalizada::find($id);

        if($costo->delete()){
            return response()->json(['mensaje' => '??Excelente! La Clase Personalizada se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

}