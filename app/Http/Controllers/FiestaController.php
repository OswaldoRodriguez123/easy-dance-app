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
use App\Alumno;
use App\Patrocinador;
use App\PatrocinadorProforma;
use App\ItemsFacturaProforma;
use App\Factura;
use App\ItemsFactura;
use App\UsuarioExterno;
use App\User;
use App\DatosBancarios;
use Validator;
use DB;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;
use Image;
use Mail;

class FiestaController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        $fiestas = Fiesta::where('academia_id', '=' ,  Auth::user()->academia_id)->get();
        $array = array();

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
            $datos = DatosBancarios::where('tipo_evento_id' , $id)->where('tipo_evento',2)->get();
            return view('agendar.fiesta.planilla')->with(['fiesta' => $fiesta, 'config_boletos' => $config_boletos, 'boletos' => $boletos, 'datos' => $datos]);
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
        Session::forget('invitaciones');

        $fiesta = Fiesta::find($id);

        if($fiesta){

            if($fiesta->link_video){

                $parts = parse_url($clase_grupal_join->link_video);
                $partes = explode( '=', $parts['query'] );
                $link_video = $partes[1];

            }else{
                $link_video = '';
            }

            $patrocinadores = DB::table('patrocinadores')
                ->Leftjoin('alumnos', 'patrocinadores.usuario_id', '=', 'alumnos.id')
                ->Leftjoin('usuario_externos','patrocinadores.externo_id', '=', 'usuario_externos.id')
                 //->select('patrocinadores.*', 'alumnos.nombre', 'alumnos.apellido', 'alumnos.id')
                ->selectRaw('patrocinadores.*, IF(alumnos.nombre is null AND alumnos.apellido is null, usuario_externos.nombre, CONCAT(alumnos.nombre, " " , alumnos.apellido)) as Nombres, IF(alumnos.sexo is null, usuario_externos.sexo, alumnos.sexo) as sexo, patrocinadores.created_at, patrocinadores.monto, patrocinadores.tipo_moneda')
                ->where('patrocinadores.tipo_evento_id', '=', $id)
                ->where('patrocinadores.tipo_evento', '=', 2)
                ->orderBy('patrocinadores.created_at', 'desc')
            ->get();

            mb_internal_encoding("UTF-8");

            $array_fecha_de_realizacion = array();
            $now = Carbon::now();
            $recaudado = 0;
            $array_patrocinador = array();

            foreach($patrocinadores as $patrocinador){

                $patrocinador->Nombres = title_case($patrocinador->Nombres);

                $fecha_de_registro = new Carbon($patrocinador->created_at);
                $diferencia_tiempo = $fecha_de_registro->diffInDays($now);

                if($diferencia_tiempo<1){

                    $fecha_de_registro = new Carbon($patrocinador->created_at);
                    $diferencia_tiempo = $fecha_de_registro->diffInHours($now);

                    if($diferencia_tiempo<1){

                        $fecha_de_registro = new Carbon($patrocinador->created_at);
                        $diferencia_tiempo = $fecha_de_registro->diffInMinutes($now);

                        if($diferencia_tiempo<1){

                            $fecha_de_registro = new Carbon($patrocinador->created_at);
                            $diferencia_tiempo = $fecha_de_registro->diffInSeconds($now);

                            if($diferencia_tiempo==1){
                                $fecha_de_realizacion = "hace ".$diferencia_tiempo." segundo";
                            }else{
                                $fecha_de_realizacion = "hace ".$diferencia_tiempo." Segundos";
                            }
                        }else{

                            if($diferencia_tiempo==1){
                                $fecha_de_realizacion = "hace ".$diferencia_tiempo." minuto";
                            }else{
                                $fecha_de_realizacion = "hace ".$diferencia_tiempo." minutos";
                            }
                        }
                    }else{

                        if($diferencia_tiempo==1){
                            $fecha_de_realizacion = "hace ".$diferencia_tiempo." hora";
                        }else{
                            $fecha_de_realizacion = "hace ".$diferencia_tiempo." horas";
                        }
                    }
                }else{

                    if($diferencia_tiempo==1){
                        $hora_segundos = $fecha_de_registro->format('H:i');
                        $fecha_de_realizacion = "Ayer a las ".$hora_segundos;
                    }else{
                        $hora_segundos = $fecha_de_registro->format('H:i');
                        $dia = $fecha_de_registro->format('d');

                        switch ($fecha_de_registro->month) {
                            case 1:
                                $mes = "Enero";
                                break;
                            case 2:
                                $mes = "Febrero";
                                break;
                            case 3:
                                $mes = "Marzo";
                                break;
                            case 4:
                                $mes = "Abril";
                                break;
                            case 5:
                                $mes = "Mayo";
                                break;
                            case 6:
                                $mes = "Junio";
                                break;
                            case 7:
                                $mes = "Julio";
                                break;
                            case 8:
                                $mes = "Agosto";
                                break;
                            case 9:
                                $mes = "Septiembre";
                                break;
                            case 10:
                                $mes = "Octubre";
                                break;
                            case 11:
                                $mes = "Noviembre";
                                break;
                            case 12:
                                $mes = "Diciembre";
                                break;
                        }
                        $fecha_de_realizacion = $dia . " de " . $mes . " a las ".$hora_segundos;
                    }
                }

                $array_fecha_de_realizacion[$patrocinador->id]=$fecha_de_realizacion;

                if($patrocinador->tipo_moneda == 1){
                    $patrocinador_monto = $patrocinador->monto;
                }else{
                    $patrocinador_monto = $patrocinador->monto * 1000;
                }

                $recaudado = $recaudado + $patrocinador->cantidad;

                $array = array(2,4);
                $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                    ->where('usuarios_tipo.tipo_id',$patrocinador->usuario_id)
                    ->whereIn('usuarios_tipo.tipo',$array)
                ->first();

                if($usuario){

                  if($usuario->imagen){
                    $imagen = $usuario->imagen;
                  }else{
                    $imagen = '';
                  }

                }else{
                    $imagen = '';
                }

                $collection=collect($patrocinador);     
                $patrocinador_array = $collection->toArray();
                    
                $patrocinador_array['imagen']=$imagen;
                $array_patrocinador[$patrocinador->id] = $patrocinador_array;
              
            }

            $boletos = Boleto::join('config_boletos', 'boletos.config_boleto_id' , '=', 'config_boletos.id')
                ->select('boletos.*', 'config_boletos.nombre')
                ->where('boletos.tipo_evento',1)
                ->where('boletos.tipo_evento_id',$id)
            ->get();

            $total_boletos = Boleto::join('config_boletos', 'boletos.config_boleto_id' , '=', 'config_boletos.id')
                ->select('boletos.*', 'config_boletos.nombre')
                ->where('boletos.tipo_evento',1)
                ->where('boletos.tipo_evento_id',$id)
            ->sum('cantidad');

            if($total_boletos){
                $porcentaje = intval(($recaudado / $total_boletos) * 100);
            }else{
                $total_boletos = 0;
                $porcentaje = 0;
            }

            $cantidad = Patrocinador::where('tipo_evento_id', '=' ,  $id)->where('tipo_evento',2)->count();
            $academia = Academia::find($fiesta->academia_id);
            $datos = DatosBancarios::where('tipo_evento_id', $fiesta->id)->where('tipo_evento',2)->get();
            $fecha_inicio = Carbon::createFromFormat('Y-m-d', $fiesta->fecha_inicio);

            if(Carbon::now() < $fecha_inicio){
                $activa = 1;
            }else{
                $activa = 0;
            }

            return view('agendar.fiesta.reserva')->with(['fiesta' => $fiesta, 'id' => $id , 'link_video' => $link_video, 'boletos' => $boletos, 'patrocinadores' => $array_patrocinador, 'recaudado' => $recaudado, 'porcentaje' => $porcentaje, 'cantidad' => $cantidad, 'academia' => $academia, 'fecha_de_realizacion' => $array_fecha_de_realizacion, 'datos' => $datos, 'activa' => $activa, 'tipo_evento' => "Fiesta", 'total_boletos' => $total_boletos]);

        }else{
           return redirect("agendar/fiestas"); 
        }
    }

    public function pagarBoleto($id)
    {   

        $boleto = Boleto::join('fiestas', 'boletos.tipo_evento_id' , '=', 'fiestas.id')
            ->join('config_boletos', 'boletos.config_boleto_id' , '=', 'config_boletos.id')
            ->select('boletos.*', 'fiestas.academia_id', 'config_boletos.nombre')
            ->where('boletos.id',$id)
        ->first();

        if($boleto){

            if(Auth::check()){
                $usuario_tipo = Session::get('easydance_usuario_tipo');
                $user_id = Auth::user()->id;
                $usuario_nombre = Auth::user()->nombre . ' ' . Auth::user()->apellido;
                $usuario_id = Auth::user()->usuario_id;
            }else{
                $usuario_tipo = '';
                $user_id = '';
                $usuario_nombre = '';
                $usuario_id = '';
            }

            $academia = Academia::find($boleto->academia_id);

            $fiesta = Fiesta::find($boleto->tipo_evento_id);
            $alumnos = Alumno::where('academia_id', '=' ,  $fiesta->academia_id)->OrderBy('nombre')->get();

            return view('agendar.fiesta.pagar_boleto')->with(['id' => $id, 'boleto' => $boleto, 'academia' => $academia,  'fiesta' => $fiesta, 'alumnos' => $alumnos, 'usuario_tipo' => $usuario_tipo, 'usuario_id' => $usuario_id, 'usuario_nombre' => $usuario_nombre, 'user_id' => $user_id]);
        }else{
             return redirect("agendar/fiestas"); 
        }

    }

    public function storePatrocinador(Request $request)
    {

        $rules = [
            'alumno_id' => 'required',
            'cantidad' => 'required|numeric',
            'boleto_id' => 'required',
            'tipo_evento_id' => 'required',
        ];

        $messages = [
            
            'alumno_id.required' => 'Ups! El patrocinador es requerido',
            'cantidad.required' => 'Ups! La cantidad es requerida',
            'cantidad.numeric' => 'Ups! La cantidad es inválida , debe contener sólo números',
            'boleto_id.required' => 'Ups! El boleto es requerido',
            'tipo_evento_id.required' => 'Ups! La campaña es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $boleto = Boleto::join('config_boletos', 'boletos.config_boleto_id' , '=', 'config_boletos.id')
                ->select('boletos.*', 'config_boletos.nombre')
                ->where('boletos.id',$request->boleto_id)
            ->first();

            $monto = $boleto->costo * $request->cantidad;

            $patrocinador = new Patrocinador;

            $patrocinador->academia_id = Auth::user()->academia_id;
            $patrocinador->tipo_evento_id = $request->tipo_evento_id;
            $patrocinador->tipo_evento = 2;
            $patrocinador->usuario_id = $request->alumno_id;
            $patrocinador->tipo_id = 1;
            $patrocinador->monto = $monto;
            $patrocinador->cantidad = $request->cantidad;

            if($patrocinador->save()){

                $item_factura = new ItemsFacturaProforma;
                
                $item_factura->alumno_id = $request->alumno_id;
                $item_factura->academia_id = Auth::user()->academia_id;
                $item_factura->fecha = Carbon::now()->toDateString();
                $item_factura->item_id = $request->boleto_id;
                $item_factura->nombre = 'Boleto ' . $boleto->nombre;
                $item_factura->tipo = 14;
                $item_factura->cantidad = $request->cantidad;
                $item_factura->precio_neto = 0;
                $item_factura->impuesto = 0;
                $item_factura->importe_neto = $monto;
                $item_factura->fecha_vencimiento = Carbon::now()->toDateString();

                if($item_factura->save()){

                    $patrocinador->item_id = $item_factura->id;
                    $patrocinador->save();

                    return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'id' => $request->alumno_id, 200]);
                }
                else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }

            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }

        }
    }

    public function principalinvitar($id){

        Session::forget('invitaciones');

        return view('agendar.fiesta.invitar')->with('id', $id);

    }

    public function agregarlinea(Request $request){
        
    $rules = [

        'nombre_invitado' => 'required',
        'correo_invitado' => 'required|email',

    ];

    $messages = [

        'nombre_invitado.required' => 'Ups! El Nombre es requerido',
        'correo_invitado.required' => 'Ups! El Correo es requerido',
        'correo_invitado.email' => 'Ups! El correo tiene una dirección inválida',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $array = array(['nombre' => $request->nombre_invitado, 'email' => $request->correo_invitado]);

        Session::push('invitaciones', $array);

        $items = Session::get('invitaciones');
        end( $items );
        $contador = key( $items );

         return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'id' => $contador, 200]);

        }
    }

    public function eliminarlinea($id){

        $arreglo = Session::get('invitaciones');

        unset($arreglo[$id]);
        Session::put('invitaciones', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);

    }

    public function invitar(Request $request){

        if(isset($request->invitacion_nombre))
        {

            $rules = [

                'invitacion_nombre' => 'required',


            ];

            $messages = [

                'invitacion_nombre.required' => 'Ups! El Nombre es requerido',

            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()){

                return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

            }

            $id = $request->id;
            $nombre = $request->invitacion_nombre;

        }else{

            $contribucion = PatrocinadorProforma::find($request->id);
            $id = $contribucion->tipo_evento_id;
            $nombre = $contribucion->nombre;

        }

        $invitaciones = Session::get('invitaciones');

        if($invitaciones)
        {

            foreach($invitaciones as $invitacion){

                $fiesta = Fiesta::find($id);

                $subj =  $nombre . ' te invita a asistir a la fiesta “'.$fiesta->nombre.'”';
                
                $array = [
                   'correo' => $invitacion[0]['email'],
                   'nombre_envio' => $nombre,
                   'nombre_destino' => $invitacion[0]['nombre'],
                   'id' => $id,
                   'subj' => $subj,
                   'fiesta' => $fiesta->nombre,
                   'link' => "http://app.easydancelatino.com/agendar/fiestas/progreso/".$id
                ];

                 Mail::send('correo.invitacion_fiesta', $array , function($msj) use ($array){
                    $msj->subject($array['subj']);
                    $msj->to($array['correo']);
                });
            }
           
         return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores' => ['linea' => [0, 'Ups! Debes agregar un correo electrónico primero']], 'status' => 'ERROR'],422);
        }
    }

    public function enhorabuena_invitacion($id)
    {
        return view('agendar.fiesta.enhorabuena_invitacion')->with('id', $id);
    }

    public function enhorabuena_invitacion_sinid()
    {
        return view('agendar.fiesta.enhorabuena_invitacion');
    }

    public function storeTransferencia(Request $request)
    {

        if($request->tipo_contribuyente == 1)
        {

            $rules = [
                'nombre' => 'required|min:3|max:50|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
                'sexo' => 'required',
                'correo' => 'email',
                'telefono' => 'required',
                'monto' => 'required|numeric',
            ];

            $messages = [
                'nombre.required' => 'Ups! El Nombre del contribuyente es requerido',
                'nombre.min' => 'El mínimo de caracteres permitidos son 5',
                'nombre.max' => 'El máximo de caracteres permitidos son 50',
                'nombre.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
                'sexo.required' => 'Ups! El Sexo  es requerido ',
                'correo.email' => 'Ups! El correo tiene una dirección inválida',
                'telefono.required' => 'Ups! El número telefónico es requerido',
                'monto.required' => 'Ups! El monto es requerido',
                'monto.numeric' => 'Ups! El monto es inválido, debe contener sólo números',
            ];
        }else if($request->tipo_contribuyente == 2){

            $rules = [
                'nombre' => 'required|min:3|max:50|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
                'correo' => 'email',
                'telefono' => 'required',
                'monto' => 'required|numeric',
            ];

            $messages = [
                'nombre.required' => 'Ups! El Apellido es requerido',
                'nombre.min' => 'El mínimo de caracteres permitidos son 5',
                'nombre.max' => 'El máximo de caracteres permitidos son 50',
                'nombre.regex' => 'Ups! El apellido es inválido, debe ingresar sólo letras',
                'correo.email' => 'Ups! El correo tiene una dirección inválida',
                'telefono.required' => 'Ups! El número telefónico es requerido',
                'monto.required' => 'Ups! El monto es requerido',
                'monto.numeric' => 'Ups! El monto es inválido, debe contener sólo números',
            ];
        }else if($request->tipo_contribuyente == 3){

            $rules = [
                'nombre' => 'required|min:3|max:50',
                'correo' => 'email',
                'telefono' => 'required',
                'coordinador' => 'required|min:3|max:50|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
                'monto' => 'required|numeric',
            ];

            $messages = [
                'nombre.required' => 'Ups! El Nombre es requerido',
                'nombre.min' => 'El mínimo de caracteres permitidos son 5',
                'nombre.max' => 'El máximo de caracteres permitidos son 50',
                'correo.email' => 'Ups! El correo tiene una dirección inválida',
                'telefono.required' => 'Ups! El número telefónico es requerido',
                'coordinador.required' => 'Ups! El Patrocinador es requerido',
                'coordinador.min' => 'El mínimo de caracteres permitidos son 5',
                'coordinador.max' => 'El máximo de caracteres permitidos son 50',
                'coordinador.regex' => 'Ups! El Nombre del coordinador es inválido, debe ingresar sólo letras',
                'monto.required' => 'Ups! El monto es requerido',
                'monto.numeric' => 'Ups! El monto es inválido, debe contener sólo números',
            ];
        }else{

            $rules = [
                'monto' => 'required|numeric',
            ];

            $messages = [
                'monto.required' => 'Ups! El monto es requerido',
                'monto.numeric' => 'Ups! El monto es inválido, debe contener sólo números',
            ];
        }

        if($request->tipo_cuenta == 2)
        {

            $rules = [
                'nombre_banco' => 'required',
                'numero_cuenta' => 'required',
            ];

            $messages = [
                'nombre_banco.required' => 'Ups! El Nombre del banco es requerido',
                'numero_cuenta.required' => 'Ups! El Numero de Transferencia es requerido',
            ];
        }


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'form' => $request->form, 'status' => 'ERROR'],422);

        }

        if($request->tipo_contribuyente == 1){
            $sexo = $request->sexo;
            $nombre = $request->nombre;
        }else if($request->tipo_contribuyente == 2){
            $sexo = 'FA';
            $nombre = 'Flia ' . $request->nombre;
        }else if($request->tipo_contribuyente == 3){
            $sexo = 'O';
            $nombre = $request->nombre;
        }else{
            $sexo = 'A';
            $nombre = 'Anónimo';
        }

        Session::put('nombre_contribuyente', $nombre);

        $transferencia = new PatrocinadorProforma;

        $transferencia->tipo_evento_id = $request->id;
        $transferencia->tipo_evento = 2;
        $transferencia->nombre = $nombre;
        $transferencia->sexo = $sexo;
        $transferencia->monto = $request->monto;
        $transferencia->tipo_moneda = $request->tipo_moneda;
        $transferencia->nombre_banco = $request->nombre_banco;
        $transferencia->tipo_cuenta = $request->tipo_cuenta;
        $transferencia->numero_cuenta = $request->numero_cuenta;
        $transferencia->telefono = $request->telefono;
        $transferencia->correo = $request->correo;
        $transferencia->coordinador = $request->correo;

        if($transferencia->save()){

            if($request->correo)
            {
                $fiesta = Fiesta::find($request->id);

                $subj = 'ESTAMOS MUY FELICES CON TU CONTRIBUCIÓN';

                $array = [

                   'nombre' => $request->nombre,
                   'link' => "http://app.easydancelatino.com/agendar/fiestas/progreso/".$request->id,
                   'link_invitar' => "http://app.easydancelatino.com/agendar/fiestas/progreso/".$request->id,
                   'correo' => $transferencia->correo,
                   'subj' => $subj,
                   'id' => $transferencia->id,
                   'fiesta' => $fiesta->nombre

                ];

                Mail::send('correo.confirmacion_fiesta', $array, function($msj) use ($array){
                    $msj->subject($array['subj']);
                    $msj->to($array['correo']);
                });

            }

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
  
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

    public function enhorabuena($id)
    {
        $nombre = Session::get('nombre_contribuyente');
        return view('agendar.fiesta.enhorabuena')->with(['id' => $id, 'nombre' => $nombre]);
    }

    public function principalcontribuciones($id){

        $contribuciones = PatrocinadorProforma::where('tipo_evento_id', $id)
            ->where('tipo_evento',2)
            ->where('status', 0)
        ->get();

        return view('agendar.fiesta.contribucion')->with(['contribuciones' => $contribuciones, 'id' => $id]);

    }

    public function confirmarcontribucion($id)
    {

        $contribucion = PatrocinadorProforma::find($id);

        $contribucion->status = 1;
            
        if($contribucion->save()){

            $fiesta = Fiesta::find($contribucion->tipo_evento_id);

            $numerofactura = Factura::orderBy('created_at', 'desc')
                ->where('facturas.academia_id', '=', $fiesta->academia_id)
            ->first();

            if($numerofactura){
               $numero_factura = $numerofactura->numero_factura + 1;
            }else{
                $academia = Academia::find($fiesta->academia_id);
                    
                if($academia->numero_factura){
                    $numero_factura = $academia->numero_factura;
                }
                else{
                    $numero_factura = 1;
                }
            }

            $UsuarioExterno = new UsuarioExterno;

            $UsuarioExterno->nombre = $contribucion->nombre;
            $UsuarioExterno->sexo = $contribucion->sexo;
            $UsuarioExterno->tipo_evento_id = $contribucion->tipo_evento_id;
            $UsuarioExterno->tipo_evento = 2;
            $UsuarioExterno->monto = $contribucion->monto;
            $UsuarioExterno->correo = $contribucion->correo;

            $UsuarioExterno->save();

            $factura = new Factura;

            $factura->externo_id = $UsuarioExterno->id;
            $factura->academia_id = $fiesta->academia_id;
            $factura->fecha = Carbon::now()->toDateString();
            $factura->hora = Carbon::now()->toTimeString();
            $factura->numero_factura = $numero_factura;
            $factura->concepto = 'Contribucion para la fiesta '. $fiesta->nombre;

            $factura->save();

            $item_factura = new ItemsFactura;

            $item_factura->factura_id = $factura->id;
            $item_factura->item_id = $factura->id;
            $item_factura->nombre = 'Contribucion para la fiesta '. $fiesta->nombre;
            $item_factura->tipo = 12;
            $item_factura->cantidad = 1;
            $item_factura->precio_neto = 0;
            $item_factura->impuesto = 0;
            $item_factura->importe_neto = $contribucion->monto;

            $item_factura->save();

            $patrocinador = new Patrocinador;

            $patrocinador->academia_id = $fiesta->academia_id;
            $patrocinador->tipo_evento_id = $contribucion->tipo_evento_id;
            $patrocinador->tipo_evento = 2;
            $patrocinador->externo_id = $UsuarioExterno->id;
            $patrocinador->tipo_id = 1;
            $patrocinador->tipo_moneda = $contribucion->tipo_moneda;
            $patrocinador->monto = $contribucion->monto;
            $patrocinador->transferencia_id = $contribucion->id;

            $patrocinador->save();

            return response()->json(['mensaje' => '¡Excelente! El Taller se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function eliminarcontribucion($id)
    {

        $contribucion = PatrocinadorProforma::find($id);
            
        if($contribucion->delete()){
            return response()->json(['mensaje' => '¡Excelente! El Taller se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function principalpatrocinadores($id){

         $patrocinadores = Patrocinador::Leftjoin('alumnos', 'patrocinadores.usuario_id', '=', 'alumnos.id')
            ->Leftjoin('usuario_externos','patrocinadores.externo_id', '=', 'usuario_externos.id')
            ->selectRaw('patrocinadores.*, IF(alumnos.nombre is null AND alumnos.apellido is null, usuario_externos.nombre, CONCAT(alumnos.nombre, " " , alumnos.apellido)) as Nombres, IF(alumnos.sexo is null, usuario_externos.sexo, alumnos.sexo) as sexo, patrocinadores.created_at, patrocinadores.monto, patrocinadores.tipo_moneda')
            ->where('patrocinadores.tipo_evento_id', '=', $id)
            ->where('patrocinadores.tipo_evento', '=', 2)
            ->orderBy('patrocinadores.created_at', 'desc')
        ->get();

        return view('agendar.fiesta.patrocinadores')->with(['patrocinadores' => $patrocinadores, 'id' => $id]);

    }

    public function detallepatrocinador($id)
    {

        $patrocinador = DB::table('patrocinadores')
             ->join('usuario_externos','patrocinadores.externo_id', '=', 'usuario_externos.id')
             ->select('patrocinadores.*', 'usuario_externos.nombre')
             ->where('patrocinadores.id', '=', $id)
         ->first();

        if($patrocinador){
           return view('especiales.campana.planilla_patrocinador')->with(['patrocinador' => $patrocinador, 'id' => $id, 'campana_id' => $patrocinador->campana_id]);
        }else{
           return redirect("especiales/campañas"); 
        }
    }

    public function updatePatrocinador(Request $request){

        $rules = [
            'monto' => 'required|numeric',
            'cantidad' => 'required|numeric',
        ];

        $messages = [

            'monto.required' => 'Ups! El monto es requerido',
            'monto.numeric' => 'Ups! El monto es inválido, debe contener sólo números',
            'cantidad.required' => 'Ups! La cantidad es requerida',
            'cantidad.numeric' => 'Ups! La cantidad es inválida, debe contener sólo números',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $patrocinador = Patrocinador::find($request->id);

            $monto_anterior = $patrocinador->monto;
            $cantidad_anterior = $patrocinador->cantidad;

            $patrocinador->cantidad = $request->cantidad;
            $patrocinador->monto = $request->monto;

            if($patrocinador->save()){

                // $item_factura = ItemsFactura::where('item_id',$patrocinador->item_id)->where('tipo',11)->first();

                // if($item_factura){
                //     $item_factura->importe_neto = $request->monto;
                //     $item_factura->save();
                // }

                $proforma = ItemsFacturaProforma::where('item_id',$patrocinador->item_id)->where('tipo',11)->first();

                if($proforma){
                    $proforma->cantidad = $request->cantidad;
                    $proforma->importe_neto = $request->monto;
                    $proforma->save();
                }else{
                    $monto = $request->monto - $monto_anterior;

                    if($cantidad_anterior != $request->cantidad)
                    {
                        $cantidad = $request->cantidad - $cantidad_anterior;
                    }else{
                        $cantidad = $request->cantidad;
                    }
                    
                    if($monto > 0){

                        $item_factura = new ItemsFacturaProforma;
                    
                        $item_factura->alumno_id = $patrocinador->usuario_id;
                        $item_factura->academia_id = Auth::user()->academia_id;
                        $item_factura->fecha = Carbon::now()->toDateString();
                        $item_factura->item_id = $patrocinador->item_id;
                        $item_factura->nombre = 'Campaña - Contribucion';
                        $item_factura->tipo = 11;
                        $item_factura->cantidad = $cantidad;
                        $item_factura->precio_neto = 0;
                        $item_factura->impuesto = 0;
                        $item_factura->importe_neto = $monto;
                        $item_factura->fecha_vencimiento = Carbon::now()->toDateString();
                    }
                    
                }

                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'patrocinador' => $patrocinador, 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateMontoPatrocinador(Request $request){

        $rules = [
            'monto' => 'required|numeric',
        ];

        $messages = [

            'monto.required' => 'Ups! El monto es requerido',
            'monto.numeric' => 'Ups! El monto es inválido, debe contener sólo números',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $patrocinador = Patrocinador::find($request->id);
            $patrocinador->monto = $request->monto;


            if($patrocinador->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateNombrePatrocinador(Request $request){

        $rules = [
            'nombre' => 'required|min:3|max:40',
        ];

        $messages = [

            'nombre.required' => 'Ups! El Nombre es requerido',
            'nombre.min' => 'El mínimo de caracteres permitidos son 3',
            'nombre.max' => 'El máximo de caracteres permitidos son 40',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }


        else{

            $patrocinador = Patrocinador::find($request->id);

            $usuario_externo = UsuarioExterno::find($patrocinador->externo_id);

            $usuario_externo->nombre = $request->nombre;

            if($usuario_externo->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function eliminarpatrocinador($id)
    {

        $patrocinador = Patrocinador::find($id);
        $usuario_externo = UsuarioExterno::find($patrocinador->externo_id);

        if($usuario_externo){
            $usuario_externo->delete();
        }

        $item_factura = ItemsFactura::where('item_id',$patrocinador->item_id)->where('tipo',11)->first();

        if($item_factura){
            $factura = Factura::find($item_factura->factura_id);
            $item_factura->delete();

            $items_factura = ItemsFactura::where('factura_id',$factura->id)->get();
            if(!$items_factura){
                $factura->delete();
            }
        }

        $proforma = ItemsFacturaProforma::where('item_id',$patrocinador->item_id)->where('tipo',11)->first();
        if($proforma){
            $proforma->delete();
        }
        
            
        if($patrocinador->delete()){
            return response()->json(['mensaje' => '¡Excelente! El Taller se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function agregardatosfijos(Request $request){
        
        $rules = [

            'nombre_banco' => 'required',
            'tipo_cuenta' => 'required',
            'numero_cuenta' => 'required',
            'rif' => 'required',
            'nombre_creador' => 'required',
        ];

        $messages = [

            'nombre_banco.required' => 'Ups! El Banco es requerido',
            'tipo_cuenta.required' => 'Ups! El tipo de cuenta es requerida',
            'numero_cuenta.required' => 'Ups! El número de cuenta es requerido',
            'rif.required' => 'Ups! El Rif - Cedula es requerido',
            'nombre_creador.required' => 'Ups! El nombre es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $nombre = title_case($request->nombre_recompensa);

            $datos = New DatosBancarios;

            $datos->tipo_evento_id = $request->id;
            $datos->tipo_evento = 2;
            $datos->nombre_banco = $request->nombre_banco;
            $datos->tipo_cuenta = $request->tipo_cuenta;
            $datos->numero_cuenta = $request->numero_cuenta;
            $datos->rif = $request->rif;
            $datos->nombre = $request->nombre_creador;

            $datos->save();

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $datos, 'id' => $datos->id, 200]);

        }
    }

    public function eliminardatosfijos($id){

        $datos = DatosBancarios::find($id);

        $datos->delete();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

}