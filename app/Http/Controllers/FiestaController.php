<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Fiesta;
use App\Academia;
use App\Boleto;
use App\ConfigBoletos;
use App\DiasDeSemana;
use App\Egreso;
use App\ConfigEgreso;
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
        $fiestas = Fiesta::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

        foreach($fiestas as $fiesta){

            $fecha = Carbon::createFromFormat('Y-m-d', $fiesta->fecha_inicio);

            if($fecha >= Carbon::now()){

                $dias_restantes = $fecha->diffInDays();
                $status = 'Activa';

            }else{
                $dias_restantes = 0;
                $status = 'Vencida';
            }

            $collection=collect($fiesta);  
            $fiesta_array = $collection->toArray();   
            $fiesta_array['status']=$status;
            $fiesta_array['dias_restantes']=$dias_restantes;
            $array[$fiesta->id] = $fiesta_array;
        }

        return view('agendar.fiesta.principal')->with('fiestas', $array);
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

            'config_boleto_id' => 'required',
            'costo' => 'required|numeric',
            'cantidad' => 'required|numeric|min:1',

        ];

        $messages = [

            'config_boleto_id.required' => 'Ups! Nombre es requerido',
            'costo.numeric' => 'Ups! El Costo es invalido, solo se aceptan numeros',
            'costo.min' => 'El mínimo de cantidad permitida es 1',
            'cantidad.required' => 'Ups! La Cantidad es requerida',
            'cantidad.numeric' => 'Ups! La Cantidad es invalida, solo se aceptan numeros',
            'cantidad.min' => 'El mínimo de cantidad permitida es 1',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $config_boleto = ConfigBoletos::find($request->config_boleto_id);
            $nombre = $config_boleto->nombre;
     
            $array = array(['nombre' => $nombre , 'cantidad' => $request->cantidad, 'costo' => $request->costo]);

            Session::push('boleto', $array);

            $item = Session::get('horarios_staff');
            end( $item );
            $contador = key( $item );

             return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'id' => $contador, 200]);

        }
    }

    public function eliminarboleto($id){

        $arreglo = Session::get('boleto');

        unset($arreglo[$id]);
        Session::push('boleto', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function agregarboletofijo(Request $request){
        
        $rules = [

            'config_boleto_id' => 'required',
            'costo' => 'required|numeric',
            'cantidad' => 'required|numeric|min:1',
        ];

        $messages = [

            'config_boleto_id.required' => 'Ups! El Nombre es requerido',
            'costo.required' => 'Ups! El Costo es requerido',
            'costo.numeric' => 'Ups! El Costo es invalido, solo se aceptan numeros',
            'costo.min' => 'El mínimo de cantidad permitida es 1',
            'cantidad.required' => 'Ups! La Cantidad es requerida',
            'cantidad.numeric' => 'Ups! La Cantidad es invalida, solo se aceptan numeros',
            'cantidad.min' => 'El mínimo de cantidad permitida es 1',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $boleto = Boleto::where('config_boleto_id',$request->config_boleto_id)->where('tipo_evento',1)->where('tipo_evento_id',$request->id)->first();

            if($boleto){
                return response()->json(['errores' => ['config_boleto_id' => [0, 'Ups! Ya posee boletos para este tipo de boleto']], 'status' => 'ERROR'],422);
            }

            $config_boleto = ConfigBoletos::find($request->config_boleto_id);
            $array = array(['nombre' => $config_boleto->nombre , 'cantidad' => $request->cantidad, 'costo' => $request->costo]);

            $boleto = new Boleto;
                                            
            $boleto->tipo_evento_id = $request->id;
            $boleto->tipo_evento = 1;
            $boleto->config_boleto_id = $request->config_boleto_id;
            $boleto->cantidad = $request->cantidad;
            $boleto->costo = $request->costo;

            if($boleto->save()){

                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'id' => $boleto->id, 200]);

            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function eliminarboletofijo($id)
    {
        
        $boleto = Boleto::find($id);
        
        if($boleto->delete()){
            return response()->json(['mensaje' => '¡Excelente! El Boleto se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
       
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
        $fiesta->presentacion = $request->presentacion;
        $fiesta->boolean_promocionar = $request->boolean_promocionar;

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

            if($request->imagePresentacionBase64){

                $base64_string = substr($request->imagePresentacionBase64, strpos($request->imagePresentacionBase64, ",")+1);
                $path = storage_path();
                $split = explode( ';', $request->imagePresentacionBase64 );
                $type =  explode( '/',  $split[0]);
                $ext = $type[1];
                
                if($ext == 'jpeg' || 'jpg'){
                    $extension = '.jpg';
                }

                if($ext == 'png'){
                    $extension = '.png';
                }

                $nombre_img = "fiestapresentacion-". $fiesta->id . $extension;
                $image = base64_decode($base64_string);

                // \Storage::disk('campana')->put($nombre_img,  $image);
                $img = Image::make($image)->resize(1440, 500);
                $img->save('assets/uploads/fiesta/'.$nombre_img);

                $fiesta->imagen_presentacion = $nombre_img;
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

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

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

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

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
            $fecha_inicio = Carbon::createFromFormat('d/m/Y', $request->fecha_inicio);

            if($fecha_inicio < Carbon::now()){

                return response()->json(['errores' => ['fecha_inicio' => [0, 'Ups! ha ocurrido un error. La fecha de la fiesta no puede ser menor al dia de hoy']], 'status' => 'ERROR'],422);
            }

            $fiesta = Fiesta::find($request->id);

            $fiesta->fecha_final = $fecha_inicio;
            $fiesta->fecha_inicio = $fecha_inicio;

            if($fiesta->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
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

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

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

    public function updateMostrar(Request $request){

        $fiesta = Fiesta::find($request->id);
        $fiesta->boolean_promocionar = $request->boolean_promocionar;

        if($fiesta->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updatePresentacion(Request $request){

        $rules = [
            'presentacion' => 'min:3|max:1000',
        ];

        $messages = [

            'presentacion.min' => 'El mínimo de caracteres permitidos son 3',
            'presentacion.max' => 'El máximo de caracteres permitidos son 1000',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $fiesta = Fiesta::find($request->id);
            $fiesta->presentacion = $request->presentacion;

            if($fiesta->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateImagenPresentacion(Request $request)
    {           

        $fiesta = Fiesta::find($request->id);
        if($request->imagePresentacionBase64){

            $base64_string = substr($request->imagePresentacionBase64, strpos($request->imagePresentacionBase64, ",")+1);
            $path = storage_path();
            $split = explode( ';', $request->imagePresentacionBase64 );
            $type =  explode( '/',  $split[0]);

            $ext = $type[1];
            
            if($ext == 'jpeg' || 'jpg'){
                $extension = '.jpg';
            }

            if($ext == 'png'){
                $extension = '.png';
            }

            $nombre_img = "fiestapresentacion-". $fiesta->id . $extension;
            $image = base64_decode($base64_string);

            // \Storage::disk('campana')->put($nombre_img,  $image);
            $img = Image::make($image)->resize(1440, 500);
            $img->save('assets/uploads/fiesta/'.$nombre_img);
        }
        else{
            $nombre_img = "";
        }
        
        $fiesta->imagen_presentacion = $nombre_img;
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
            $config_boletos = ConfigBoletos::all();
            $boletos = Boleto::join('config_boletos', 'boletos.config_boleto_id' , '=', 'config_boletos.id')
                ->select('boletos.*', 'config_boletos.nombre')
                ->where('boletos.tipo_evento',1)
                ->where('boletos.tipo_evento_id',$id)
            ->get();
            return view('agendar.fiesta.planilla')->with(['fiesta' => $fiesta, 'config_boletos' => $config_boletos, 'boletos' => $boletos]);
        }else{
            return redirect("agendar/fiestas"); 
        }
    }

    public function egresos($id)
    {
        $fiesta = Fiesta::find($id);

        if($fiesta){

            $config_egresos = ConfigEgreso::all();

            $egresos = Egreso::Leftjoin('config_egresos', 'egresos.config_tipo' , '=', 'config_egresos.id')
                ->select('egresos.*', 'config_egresos.nombre as config_tipo')
                ->where('tipo_id',$id)
                ->where('tipo',2)
            ->get();

            $total = Egreso::Leftjoin('config_egresos', 'egresos.config_tipo' , '=', 'config_egresos.id')
                ->select('egresos.*', 'config_egresos.nombre as config_tipo')
                ->where('tipo_id',$id)
                ->where('tipo',2)
            ->sum('cantidad');
            
            return view('agendar.fiesta.egresos')->with(['fiesta' => $fiesta, 'egresos' => $egresos, 'total' => $total, 'config_egresos' => $config_egresos, 'id' => $id]);
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

    public function progreso($id)
    {

        $fiesta = Fiesta::find($id);

        $fecha_inicio = Carbon::createFromFormat('Y-m-d', $fiesta->fecha_inicio);

        if(Carbon::now() > $fecha_inicio){
            $inicio = 1;
        }else{
            $inicio = 0;
        }

        $academia = Academia::find($fiesta->academia_id);

        if($fiesta->link_video){

            $parts = parse_url($clase_grupal_join->link_video);
            $partes = explode( '=', $parts['query'] );
            $link_video = $partes[1];

        }else{
            $link_video = '';
        }

        if(Auth::check()){

            $usuario_tipo = Session::get('easydance_usuario_tipo');

        }else{
            $usuario_tipo = 0;
        
        }

        return view('agendar.fiesta.reserva')->with(['fiesta' => $fiesta, 'id' => $id, 'link_video' => $link_video, 'academia' => $academia, 'usuario_tipo' => $usuario_tipo, 'inicio' => $inicio]);
    }

}