<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Fiesta;
use App\ConfigEstudios;
use App\ConfigBoletos;
use App\DiasDeSemana;
use App\ConfigEspecialidades;
use App\Instructor;
use Validator;
use DB;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;
use Image;

class FiestaController extends BaseController {

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

        return view('agendar.fiesta.principal')->with('fiesta', Fiesta::where('academia_id', '=' ,  Auth::user()->academia_id)->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (Session::has('boleto')) {
            Session::forget('boleto'); 
        }

        if (Session::has('multi')) {
            Session::forget('multi'); 
        }

        return view('agendar.fiesta.create')->with(['dias_de_semana' => DiasDeSemana::all() , 'boleto' => ConfigBoletos::all()]);
    }

    public function agregarboleto(Request $request){

    $rules = [

        'tipo' => 'required',
        'cantidad' => 'required|numeric|min:1',
        'costo' => 'required|numeric',
    ];

    $messages = [

        'tipo.required' => 'Ups! El Tipo de Boleto es requerido',
        'cantidad.required' => 'Ups! La Cantidad es requerida',
        'costo.required' => 'Ups! El Costo es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $find = ConfigBoletos::find($request->tipo);
        $tipo = $find->nombre;
 
        $array = array(['tipo' => $tipo , 'cantidad' => $request->cantidad, 'costo' => $request->costo]);

        Session::push('boleto', $array);

        $contador = count(Session::get('horario'));
        $contador = $contador - 1;

         return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'id' => $contador, 200]);

    }
    }

    public function eliminarboleto($id){

        $arreglo = Session::get('boleto');

        // unset($arreglo[$id]);
        unset($arreglo[$id]);
        Session::forget('boleto');
        Session::push('boleto', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function agregarhorario(Request $request){

    $rules = [

        'lugar' => 'required',
        'dia_de_semana_id' => 'required',
        'hora_inicio_acordeon' => 'required',
        'hora_final_acordeon' => 'required',
    ];

    $messages = [

        'lugar.required' => 'Ups! El Lugar es requerido',
        'dia_de_semana_id.required' => 'Ups! El Dia es requerido',
        'hora_inicio_acordeon.required' => 'Ups! La hora de inicio es requerida',
        'hora_final_acordeon.required' => 'Ups! La hora final es requerida',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $find = DiasDeSemana::find($request->dia_de_semana_id);
        $dia_de_semana = $find->nombre;
 
        $array = array(['lugar' => $request->lugar , 'dia_de_semana' => $dia_de_semana, 'hora_inicio' => $request->hora_inicio_acordeon, 'hora_final' => $request->hora_final_acordeon]);

        Session::push('multi', $array);

        $contador = count(Session::get('multi'));
        $contador = $contador - 1;

         return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'id' => $contador, 200]);

    }
    }

    public function eliminarhorario($id){

        $arreglo = Session::get('multi');

        // unset($arreglo[$id]);
        unset($arreglo[$id]);
        Session::forget('multi');
        Session::push('multi', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

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
        'fecha' => 'required',
        'hora_inicio' => 'required',
        'hora_final' => 'required',
        'color_etiqueta' => 'required',
        'lugar' => 'required|min:3|max:200',
    ];

    $messages = [

        'nombre.required' => 'Ups! El Nombre es requerido ',
        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre.max' => 'El máximo de caracteres permitidos son 50',
        'fecha.required' => 'Ups! La fecha es requerida',
        'lugar.required' => 'Ups! El Lugar o sitio es requerido',
        'lugar.min' => 'El mínimo de caracteres permitidos son 3',
        'lugar.max' => 'El máximo de caracteres permitidos son 200',
        'hora_inicio.required' => 'Ups! El horario es requerido',
        'hora_final.required' => 'Ups! El horario es requerido',
        'etiqueta.required' => 'Ups! El color de la etiqueta es requerido',
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

        $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha); 

        if($fecha < Carbon::now()){

            return response()->json(['errores' => ['fecha' => [0, 'Ups! ha ocurrido un error. La fecha de la fiesta no puede ser menor al dia de hoy']], 'status' => 'ERROR'],422);
        }

        $fecha = $fecha->toDateString();

        $hora_inicio = strtotime($request->hora_inicio);
        $hora_final = strtotime($request->hora_final);

        if($hora_inicio > $hora_final)
        {

            return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
        }


        $fiesta = new Fiesta;

        $nombre = title_case($request->nombre);
        $lugar = title_case($request->lugar);
        $descripcion = $request->descripcion;

        $fiesta->academia_id = Auth::user()->academia_id;
        $fiesta->nombre = $nombre;
        $fiesta->descripcion = $descripcion;
        $fiesta->lugar = $lugar;
        $fiesta->fecha_inicio = $fecha;
        $fiesta->fecha_final = $fecha;
        $fiesta->hora_inicio = $request->hora_inicio;
        $fiesta->hora_final = $request->hora_final;
        $fiesta->color_etiqueta = $request->color_etiqueta;
        $fiesta->link_video = $request->link_video;
        $fiesta->condiciones = $request->condiciones;

        // return redirect("/home");
        if($fiesta->save()){

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

                $nombre_img = "fiesta-". $fiesta->id . $extension;
                $image = base64_decode($base64_string);

                // \Storage::disk('fiesta')->put($nombre_img,  $image);
                $img = Image::make($image)->resize(640, 480);
                $img->save('assets/uploads/fiesta/'.$nombre_img);

                $fiesta->imagen = $nombre_img;
                $fiesta->save();

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

        'nombre.required' => 'Ups! El Nombre  es requerido ',
        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre.max' => 'El máximo de caracteres permitidos son 50',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        // return redirect("alumno/edit/{$request->id}")

        // ->withErrors($validator)
        // ->withInput();
        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }
        $fiesta = Fiesta::find($request->id);

        $nombre = title_case($request->nombre);

        $fiesta->nombre = $nombre;

        if($fiesta->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateDescripcion(Request $request){

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

        // return redirect("alumno/edit/{$request->id}")

        // ->withErrors($validator)
        // ->withInput();
        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }
        $fiesta = Fiesta::find($request->id);

        $descripcion = $request->descripcion;

        $fiesta->descripcion = $descripcion;

        if($fiesta->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
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

            if($request->fecha_inicio < Carbon::now()){

                return response()->json(['errores' => ['fecha_inicio' => [0, 'Ups! ha ocurrido un error. La fecha de la fiesta no puede ser menor al dia de hoy']], 'status' => 'ERROR'],422);
            }

            $fiesta = Fiesta::find($request->id);

            $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha_inicio)->toDateString();

            $fiesta->fecha_final = $fecha;
            $fiesta->fecha_inicio = $fecha;

            if($fiesta->save()){
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

            $fiesta = Fiesta::find($request->id);

            $fiesta->hora_inicio = $request->hora_inicio;
            $fiesta->hora_final = $request->hora_final;

            if($fiesta->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateLugar(Request $request){

    $rules = [
        'lugar' => 'required|min:3|max:200',
    ];

    $messages = [

        'lugar.required' => 'Ups! El Lugar o sitio es requerido',
        'lugar.min' => 'El mínimo de caracteres permitidos son 3',
        'lugar.max' => 'El máximo de caracteres permitidos son 200',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        // return redirect("alumno/edit/{$request->id}")

        // ->withErrors($validator)
        // ->withInput();
        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }
        $fiesta = Fiesta::find($request->id);

        $lugar = title_case($request->lugar);

        $fiesta->lugar = $lugar;

        if($fiesta->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEtiqueta(Request $request){
        $fiesta = Fiesta::find($request->id);
        $fiesta->color_etiqueta = $request->color_etiqueta;

        if($fiesta->save()){
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

        $fiesta = Fiesta::find($request->id);
        $fiesta->link_video = $request->link_video;

        if($fiesta->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateCondiciones(Request $request){
        $fiesta = Fiesta::find($request->id);
        $fiesta->condiciones = $request->condiciones;

        if($fiesta->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateImagen(Request $request)
    {
                $fiesta = Fiesta::find($request->id);
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

                    $nombre_img = "fiesta-". $fiesta->id . $extension;
                    $image = base64_decode($base64_string);

                    // \Storage::disk('fiesta')->put($nombre_img,  $image);
                    $img = Image::make($image)->resize(640, 480);
                    $img->save('assets/uploads/fiesta/'.$nombre_img);
                    
                }else{
                    $nombre_img = "";
                }

                $fiesta->imagen = $nombre_img;
                $fiesta->save();

                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
    }

    public function operar($id)
    {   
        $fiesta = Fiesta::find($id);

        return view('agendar.fiesta.operacion')->with(['id' => $id , 'fiesta' => $fiesta]);       
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
        $fiesta = Fiesta::find($id);

        if($fiesta){
           return view('agendar.fiesta.planilla')->with('fiesta' , $fiesta);
        }else{
           return redirect("agendar/fiestas"); 
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
        $fiesta = Fiesta::find($id);
        
        if($fiesta->delete()){
            return response()->json(['mensaje' => '¡Excelente! La Fiesta o Evento se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

}