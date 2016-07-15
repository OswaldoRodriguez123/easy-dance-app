<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Taller;
use App\Alumno;
use App\Academia;
use App\ConfigEstudios;
use App\ConfigEspecialidades;
use App\ConfigNiveles;
use App\Instructor;
use App\DiasDeSemana;
use App\InscripcionTaller;
use App\ItemsFacturaProforma;
use Validator;
use DB;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;
use Image;

class TallerController extends BaseController {

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

        return view('agendar.taller.principal')->with(['taller' => Taller::where('academia_id', '=' ,  Auth::user()->academia_id)->get()]);
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

        return view('agendar.taller.create')->with(['especialidad' => ConfigEspecialidades::all(), 'dias_de_semana' => DiasDeSemana::all(), 'nivel_baile' => ConfigNiveles::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->get(), 'estudio' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'instructor' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get()]);
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
        'costo' => 'required|numeric',
        'fecha' => 'required',
        'hora_inicio' => 'required',
        'hora_final' => 'required',
        'color_etiqueta' => 'required',
        'especialidad_id' => 'required',
        'nivel_baile_id' => 'required',
        'instructor_id' => 'required',
        'estudio_id' => 'required',
        'cupo_minimo' => 'numeric',
        'cupo_maximo' => 'numeric',
        'cupo_reservacion' => 'numeric',
        
        
    ];

    $messages = [

        'nombre.required' => 'Ups! El Nombre es requerido ',
        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre.max' => 'El máximo de caracteres permitidos son 50',
        'costo.required' => 'Ups! El Costo es requerido',
        'costo.numeric' => 'Ups! El Costo es inválido , debe contener sólo números',
        'fecha.required' => 'Ups! La fecha es requerida',
        'hora_inicio.required' => 'Ups! El horario es requerido',
        'hora_final.required' => 'Ups! El horario es requerido',
        'especialidad_id.required' => 'Ups! La especialidad es requerida',
        'nivel_baile_id.required' => 'Ups! El nivel de baile es requerido ',
        'instructor_id.required' => 'Ups! El Instructor es requerido',
        'estudio_id.required' => 'Ups! La Sala o Estudio requerida',
        'etiqueta.required' => 'Ups! El color de la etiqueta es requerido',
        'cupo_minimo.numeric' => 'Ups! La cantidad de cupos es inválido , debe contener sólo números',
        'cupo_maximo.numeric' => 'Ups! La cantidad de cupos es inválido , debe contener sólo números',
        'cupo_reservacion.numeric' => 'Ups! La cantidad de cupos  para reservacion es inválido , debe contener sólo números',

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

        $fecha = explode(" - ", $request->fecha);

        $fecha_inicio = Carbon::createFromFormat('d/m/Y', $fecha[0])->toDateString();
        $fecha_final = Carbon::createFromFormat('d/m/Y', $fecha[1])->toDateString();

        if($fecha_inicio > $fecha_final)
        {
            return response()->json(['errores' => ['fecha' => [0, 'Ups! La fecha de inicio es mayor a la fecha final']], 'status' => 'ERROR'],422);
        }

        $hora_inicio = strtotime($request->hora_inicio);
        $hora_final = strtotime($request->hora_final);

        if($hora_inicio > $hora_final)
        {

            return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
        }

        if($request->cupo_minimo > $request->cupo_maximo)
        {

            return response()->json(['errores' => ['cupo_minimo' => [0, 'Ups! El cupo minimo es mayor al cupo maximo']], 'status' => 'ERROR'],422);
        }

        if($request->link_video){

            $parts = parse_url($request->link_video);

            if(isset($parts['host']))
            {
                if($parts['host'] == "www.youtube.com" || $parts['host'] == "www.youtu.be"){

                
                }else{
                    return response()->json(['errores' => ['link_video' => [0, 'Ups! ha ocurrido un error, debes ingresar un enlace de YouTube']], 'status' => 'ERROR'],422);
                }
            }else{
                    return response()->json(['errores' => ['link_video' => [0, 'Ups! ha ocurrido un error, debes ingresar un enlace de YouTube']], 'status' => 'ERROR'],422);
                }
            
            }

        $taller = new Taller;

        $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->nombre))));

        $descripcion = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->descripcion))));


        $taller->academia_id = Auth::user()->academia_id;
        $taller->descripcion = $descripcion;
        $taller->nombre = $nombre;
        $taller->costo = $request->costo;
        $taller->fecha_inicio = $fecha_inicio;
        $taller->fecha_final = $fecha_final;
        $taller->hora_inicio = $request->hora_inicio;
        $taller->hora_final = $request->hora_final;
        $taller->especialidad_id = $request->especialidad_id;
        $taller->instructor_id = $request->instructor_id;
        $taller->estudio_id = $request->estudio_id;
        $taller->color_etiqueta = $request->color_etiqueta;
        $taller->cupo_minimo = $request->cupo_minimo;
        $taller->cupo_maximo = $request->cupo_maximo;
        $taller->cupo_reservacion = $request->cupo_reservacion;
        $taller->condiciones = $request->condiciones;
        $taller->link_video = $request->link_video;

        // return redirect("/home");
        if($taller->save()){

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

                $nombre_img = "taller-". $taller->id . $extension;
                $image = base64_decode($base64_string);

                // \Storage::disk('taller')->put($nombre_img,  $image);
                $img = Image::make($image)->resize(1440, 500);
                $img->save('assets/uploads/taller/'.$nombre_img);

                $taller->imagen = $nombre_img;
                $taller->save();

            }
            
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

     public function updateNombre(Request $request){

    $rules = [
        'nombre' => 'required|min:3|max:50',

    ];

    $messages = [

        'nombre.required' => 'Ups! El Nombre es requerido ',
        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre.max' => 'El máximo de caracteres permitidos son 50',

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

        $taller = Taller::find($request->id);

        $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->nombre))));

        $taller->nombre = $nombre;

        if($taller->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateCosto(Request $request){

    $rules = [
      
        'costo' => 'required|numeric',

    ];

    $messages = [

        'costo.required' => 'Ups! El Costo es requerido',
        'costo.numeric' => 'Ups! El Costo es inválido , debe contener sólo números',

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

        $taller = Taller::find($request->id);
        $taller->costo = $request->costo;

        if($taller->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
        // return redirect("alumno/edit/{$request->id}");
    }


    public function updateDescripcion(Request $request){

    $rules = [

        'descripcion' => 'required',
    ];

    $messages = [

        'descripcion.required' => 'Ups! La Descripcion es requerida',

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

        $taller = Taller::find($request->id);

        $descripcion = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->descripcion))));

        $taller->descripcion = $descripcion;

        if($taller->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        }
        // return redirect("alumno/edit/{$request->id}");
    }


    public function updateFecha(Request $request){

    $rules = [

        'fecha_inicio' => 'required',

    ];

    $messages = [

        'fecha_inicio.required' => 'Ups! La fecha de inicio es requerida',

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


        $taller = Taller::find($request->id);

        $fecha_inicio = Carbon::createFromFormat('d/m/Y', $request->fecha_inicio)->toDateString();

        $taller->fecha_inicio = $fecha_inicio;

        if($taller->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
        // return redirect("alumno/edit/{$request->id}");
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

        $taller = Taller::find($request->id);
        $taller->hora_inicio = $request->hora_inicio;
        $taller->hora_final = $request->hora_final;

        if($taller->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function updateEspecialidad(Request $request){
        $taller = Taller::find($request->id);
        $taller->especialidad_id = $request->especialidad_id;

        if($taller->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateInstructor(Request $request){
        $taller = Taller::find($request->id);
        $taller->instructor_id = $request->instructor_id;

        if($taller->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEstudio(Request $request){
        $taller = Taller::find($request->id);
        $taller->estudio_id = $request->estudio_id;

        if($taller->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateCupos(Request $request){

    $rules = [

        'cupo_minimo' => 'required|numeric',
        'cupo_maximo' => 'required|numeric',
    ];

    $messages = [

        'cupo_minimo.required' => 'Ups! La cantidad de cupos son requerido',
        'cupo_maximo.required' => 'Ups! La cantidad de cupos son requerido',
        'cupo_minimo.numeric' => 'Ups! La cantidad de cupos es inválido , debe contener sólo números',
        'cupo_maximo.numeric' => 'Ups! La cantidad de cupos es inválido , debe contener sólo números',
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

        $taller = Taller::find($request->id);
        $taller->cupo_minimo = $request->cupo_minimo;
        $taller->cupo_maximo = $request->cupo_maximo;

        if( $request->cupo_minimo > $request->cupo_maximo)
        {
            return response()->json(['errores'=>'Cupo Minimo Mayor', 'status' => 'ERROR-SERVIDOR'],422);
        }

        if($taller->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        }

    }

    public function updateCuposOnline(Request $request){

    $rules = [

        'cupo_reservacion' => 'required|numeric',
    ];

    $messages = [

        'cupo_reservacion.required' => 'Ups! La cantidad de cupos son requerido',
        'cupo_reservacion.numeric' => 'Ups! La cantidad de cupos es inválido , debe contener sólo números',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        // return redirect("/home")

        // ->withErrors($validator)
        // ->withInput();

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }

        $taller = Taller::find($request->id);
        $taller->cupo_reservacion = $request->cupo_reservacion;


        if($taller->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

    public function updateEtiqueta(Request $request){
        $taller = Taller::find($request->id);
        $taller->etiqueta = $request->etiqueta;

        if($taller->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateLink(Request $request){

        if($request->link_video){

            $parts = parse_url($request->link_video);

            if(isset($parts['host']))
            {
                if($parts['host'] == "www.youtube.com" || $parts['host'] == "www.youtu.be"){

                
                }else{
                    return response()->json(['errores' => ['link_video' => [0, 'Ups! ha ocurrido un error, debes ingresar un enlace de YouTube']], 'status' => 'ERROR'],422);
                }
            }else{
                    return response()->json(['errores' => ['link_video' => [0, 'Ups! ha ocurrido un error, debes ingresar un enlace de YouTube']], 'status' => 'ERROR'],422);
                }
            
            }

        $taller = Taller::find($request->id);
        $taller->link_video = $request->link_video;

        if($taller->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateCostoTaller(Request $request){

    $rules = [

        'costo' => 'required|numeric',
    ];

    $messages = [

        'costo.required' => 'Ups! El costo es requerido',
        'costo.numeric' => 'Ups! El costo es inválido , debe contener sólo números',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function updateImagen(Request $request)
    {
                $taller = Taller::find($request->id);
                
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

                    $nombre_img = "taller-". $taller->id . $extension;
                    $image = base64_decode($base64_string);

                    // \Storage::disk('taller')->put($nombre_img,  $image);
                    $img = Image::make($image)->resize(1440, 500);
                    $img->save('assets/uploads/taller/'.$nombre_img);

                }else{
                    $nombre_img = "";
                }

                $taller->imagen = $nombre_img;
                $taller->save();

                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
    }

    public function participantes($id)
    {

        $taller = Taller::find($id);

        $alumnos_inscritos = DB::table('inscripcion_taller')
                ->join('alumnos', 'inscripcion_taller.alumno_id', '=', 'alumnos.id')
                ->select('alumnos.*')
                ->where('inscripcion_taller.taller_id', '=', $id)
                ->where('inscripcion_taller.deleted_at', '=', null)
        ->get();

        $alumnos = Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

        return view('agendar.taller.participantes')->with(['alumnos_inscritos' => $alumnos_inscritos, 'id' => $id, 'taller' => $taller, 'alumnos' => $alumnos]);
    }

    public function storeInscripcion(Request $request)
    {

    Session::forget('id_alumno');

    $rules = [
        'taller_id' => 'required',
        'alumno_id' => 'required',
        'costo' => 'required|numeric',
    ];

    $messages = [

        'taller_id.required' => 'Ups! El Nombre es requerido',
        'alumno_id.required' => 'Ups! El Alumno es requerido',
        'costo.required' => 'Ups! El costo es requerido',
        'costo.numeric' => 'Ups! El costo es inválido , debe contener sólo números',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

            // $alumnos = explode('-',$request->alumno_id);

        $alumnostaller = DB::table('inscripcion_taller') 
            ->select('inscripcion_taller.*')
            ->where('inscripcion_taller.alumno_id', '=', $request->alumno_id)
            ->where('inscripcion_taller.taller_id', '=', $request->taller_id)
            ->where('inscripcion_taller.deleted_at', '=', null)
            ->first(); 

        // comprobar si esta inscrito
        if(!$alumnostaller){ 

            $taller = Taller::find($request->taller_id);

            $array=array();

            // for($i = 1 ; $i<count($alumnos) ; $i++)
            // {
                $inscripcion = new InscripcionTaller;

                $inscripcion->taller_id = $request->taller_id;
                $inscripcion->alumno_id = $request->alumno_id;

                $inscripcion->save();

                $item_factura = new ItemsFacturaProforma;
                    
                $item_factura->alumno_id = $request->alumno_id;
                $item_factura->academia_id = Auth::user()->academia_id;
                $item_factura->fecha = Carbon::now()->toDateString();
                $item_factura->item_id = $request->taller_id;
                $item_factura->nombre = 'Inscripcion ' . $taller->nombre;
                $item_factura->tipo = 5;
                $item_factura->cantidad = 1;
                $item_factura->precio_neto = 0;
                $item_factura->impuesto = 0;
                $item_factura->importe_neto = $request->costo;
                $item_factura->fecha_vencimiento = Carbon::now()->toDateString();
                    
                $item_factura->save();

                $alumno = Alumno::find($request->alumno_id);

                // $array[$i] = $alumno;

            // }

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'uno' => 'uno', 'id' => $alumno->id, 200]);

            // if(count($alumnos) > 2)
            // {
            //     return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 200]);
            // }
            // else{
            //     return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'uno' => 'uno', 'id' => $array[1]->id, 200]);
            // }
            }
            return response()->json(['errores' => ['alumno_id' => [0, 'Ya este alumno esta inscrito']], 'status' => 'ERROR'],422);
        }
    }

    public function eliminarinscripcion(Request $request)
    {
        // $inscripcion = InscripcionClaseGrupal::find($id);
        $inscripcion = InscripcionTaller::where('alumno_id', $request->alumno_id)->where('taller_id', $request->taller_id)->first();
        
        if($inscripcion->delete()){
            return response()->json(['mensaje' => '¡Excelente! El Taller se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

    public function progreso($id)
    {

        $taller_join = DB::table('talleres')
            ->join('config_especialidades', 'talleres.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_estudios', 'talleres.estudio_id', '=', 'config_estudios.id')
            ->join('instructores', 'talleres.instructor_id', '=', 'instructores.id')
            ->join('academias', 'talleres.academia_id', '=', 'academias.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'talleres.nombre as taller_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'config_estudios.nombre as estudio_nombre', 'talleres.hora_inicio','talleres.hora_final', 'talleres.id', 'talleres.cupo_reservacion', 'talleres.fecha_inicio', 'talleres.imagen', 'talleres.descripcion', 'academias.imagen as imagen_academia', 'talleres.link_video', 'talleres.condiciones', 'academias.direccion', 'academias.estado', 'academias.facebook', 'academias.twitter', 'academias.instagram', 'academias.linkedin', 'academias.youtube', 'academias.pagina_web', 'academias.nombre as academia_nombre')
            ->where('talleres.id','=', $id)
        ->first();

        $academia = Academia::find(Auth::user()->academia_id);

        if($taller_join->link_video){

            $parts = parse_url($taller_join->link_video);
            $partes = explode( '=', $parts['query'] );
            $link_video = $partes[1];

            }
            else{
                $link_video = '';
            }

         $cantidad_reservaciones = DB::table('reservaciones')
             ->select('reservaciones.*')
             ->where('tipo_id', '=', $id)
             ->where('tipo_reservacion', '=', 2)
         ->count();

         if($taller_join->cupo_reservacion == 0){
            $cupo_reservacion = 1;
         }
         else{
            $cupo_reservacion = $taller_join->cupo_reservacion;
         }

         $cupos_restantes = $cupo_reservacion - $cantidad_reservaciones;

         if($cupos_restantes < 0){
            $cupos_restantes = 0;
         }

         $porcentaje = intval(($cantidad_reservaciones / $cupo_reservacion) * 100);

         $privilegio = Auth::user()->tipo_usuario;

         if($privilegio == 10){
            $administrador = 1;
         }
         else{
             $administrador = 0;
         }

        return view('agendar.taller.reserva')->with(['taller' => $taller_join, 'id' => $id, 'porcentaje' => $porcentaje, 'administrador' => $administrador, 'link_video' => $link_video, 'academia' => $academia, 'cupos_restantes' => $cupos_restantes]);
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

    public function operar($id)
    {   
        $taller = Taller::find($id);
        return view('agendar.taller.operacion')->with(['id'=> $id , 'taller' => $taller]);         
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    
    public function edit($id)
    {

        $find = Taller::find($id);

        if($find){

            $taller_join = DB::table('talleres')
                ->join('config_especialidades', 'talleres.especialidad_id', '=', 'config_especialidades.id')
                ->join('config_estudios', 'talleres.estudio_id', '=', 'config_estudios.id')
                ->join('instructores', 'talleres.instructor_id', '=', 'instructores.id')
                ->select('config_especialidades.nombre as especialidad_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','config_estudios.nombre as estudio_nombre', 'talleres.fecha_inicio as fecha_inicio', 'talleres.hora_inicio','talleres.hora_final', 'talleres.id', 'talleres.id', 'talleres.nombre', 'talleres.costo', 'talleres.descripcion', 'talleres.cupo_minimo', 'talleres.cupo_maximo' , 'talleres.cupo_reservacion', 'talleres.link_video', 'talleres.imagen')
                ->where('talleres.id', '=', $id)
                ->first();

                //dd($clase_grupal_join);

            return view('agendar.taller.planilla')->with(['config_especialidades' => ConfigEspecialidades::all(), 'config_estudios' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'instructor' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'taller' => $taller_join]);

        }else{
           return redirect("agendar/talleres"); 
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
        $exist = InscripcionTaller::where('taller_id', $id)->first();

        if(!$exist)
        {
            $taller = Taller::find($id);
            
            if($taller->delete()){
                return response()->json(['mensaje' => '¡Excelente! El Taller se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }

        }else{
            return response()->json(['error_mensaje'=> 'Ups! Este taller no puede ser eliminado ya que posee alumnos registrados' , 'status' => 'ERROR-BORRADO'],422);
        }
    }

}