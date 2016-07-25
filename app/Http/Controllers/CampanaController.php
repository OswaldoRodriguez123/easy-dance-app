<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Campana;
use App\Academia;
use App\Recompensa;
use App\Alumno;
use App\Patrocinador;
use App\ItemsFacturaProforma;
use App\Factura;
use App\MercadopagoMovs;
use Validator;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;
use Image;
use MP;

class CampanaController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    
    public function index()
    {

        $campanas = DB::table('campanas')
            ->select('campanas.*')
            ->where('campanas.academia_id' , '=' , Auth::user()->academia_id)
            ->OrderBy('campanas.created_at')
        ->get();

        $array=array();
        $i = 0;
        $cantidad = 0;
        $total = 0;

        foreach($campanas as $campana){
            
            $recaudado = Patrocinador::where('campana_id', '=' ,  $campana->id)->sum('monto');
            $collection=collect($campana);     
            $campana_array = $collection->toArray();
            
            $campana_array['total']=$recaudado;
            $array[$campana->id] = $campana_array;
    
        }

        return view('especiales.campana.principal')->with('campanas', $array);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        Session::forget('recompensa');

        return view('especiales.campana.create');
    }

    public function operar($id)
    {   
        $campana = Campana::find($id);
        return view('especiales.campana.operaciones')->with(['id' => $id, 'campana' => $campana]);        
    }

    public function agregarrecompensa(Request $request){
        
    $rules = [

        'nombre_recompensa' => 'required',
        'cantidad_recompensa' => 'required|numeric',
        'descripcion_recompensa' => 'required',
    ];

    $messages = [

        'nombre_recompensa.required' => 'Ups! La recompensa es  requerida',
        'cantidad_recompensa.required' => 'Ups! La cantidad es  requerida',
        'cantidad_recompensa.numeric' => 'Ups! La cantidad es inválida, debe contener sólo números',
        'descripcion_recompensa.required' => 'Ups! La descripcion es  requerida',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $array = array(['recompensa' => $request->nombre_recompensa, 'cantidad' => $request->cantidad_recompensa, 'descripcion' => $request->descripcion_recompensa]);

        Session::push('recompensa', $array);

        $items = Session::get('recompensa');
        end( $items );
        $contador = key( $items );

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'id' => $contador, 200]);

    }
    }

    public function eliminarrecompensa($id){

        $arreglo = Session::get('recompensa');

        // unset($arreglo[$id]);
        unset($arreglo[$id]);
        Session::put('recompensa', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function agregarrecompensafija(Request $request){
        
    $rules = [

        'nombre_recompensa' => 'required',
        'cantidad_recompensa' => 'required|numeric',
        'descripcion_recompensa' => 'required',
    ];

    $messages = [

        'nombre_recompensa.required' => 'Ups! La recompensa es  requerida',
        'cantidad_recompensa.required' => 'Ups! La cantidad es  requerida',
        'cantidad_recompensa.numeric' => 'Ups! La cantidad es inválida, debe contener sólo números',
        'descripcion_recompensa.required' => 'Ups! La descripcion es  requerida',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->nombre_recompensa))));

        $recompensa = New Recompensa;

        $recompensa->academia_id = Auth::user()->academia_id;
        $recompensa->campana_id = $request->id;
        $recompensa->nombre = $nombre;
        $recompensa->cantidad = $request->cantidad_recompensa;
        $recompensa->descripcion = $request->descripcion_recompensa;

        $recompensa->save();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $recompensa, 'id' => $recompensa->id, 200]);

        }
    }

    public function eliminarrecompensafija($id){

        $recompensa = Recompensa::find($id);

        $recompensa->delete();

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
        //
    

    $rules = [
        'cantidad' => 'required|numeric',
        'nombre' => 'required|min:5|max:40',
        'eslogan' => 'required|min:5|max:30',
        'historia' => 'required|max:1000',
        'plazo' => 'required|numeric',
    ];

    $messages = [
        
        'cantidad.required' => 'Ups! La cantidad de dinero a recaudar es  requerida',
        'cantidad.numeric' => 'Ups! El campo de recaudar es inválido, debe contener sólo números',
        'nombre.required' => 'Ups! El título de la campaña es requerido',
        'nombre.min' => 'El mínimo de caracteres permitidos son 5',
        'nombre.max' => 'El máximo de caracteres permitidos son 40',
        'eslogan.required' => 'Ups! El Eslogan es requerido',
        'eslogan.min' => 'El mínimo de caracteres permitidos son 5',
        'eslogan.max' => 'El máximo de caracteres permitidos son 30', 
        'historia.required' => 'Ups! La Historia es requerida',
        'historia.max' => 'El máximo de caracteres permitidos son 1000', 
        'plazo.required' => 'Ups! El plazo es requerido',
        'plazo.numeric' => 'Ups! El plazo es inválido, debe contener sólo números',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        if($request->plazo <= 45){

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

            $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->nombre))));

            $historia = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->historia))));

            $eslogan = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->eslogan))));

            $campana = new Campana;

            $fecha_inicio = Carbon::now()->toDateString();
            $fecha_final = Carbon::now()->addDays($request->plazo)->toDateString();

            $campana->academia_id = Auth::user()->academia_id;
            $campana->nombre = $nombre;
            $campana->cantidad = $request->cantidad;
            $campana->fecha_inicio = $fecha_inicio;
            $campana->fecha_final = $fecha_final;
            $campana->historia = $historia;
            $campana->eslogan = $eslogan;
            $campana->plazo = $request->plazo;
            $campana->link_video = $request->link_video;
            $campana->correo = $request->correo;
            $campana->nombre_banco = $request->nombre_banco;
            $campana->tipo_cuenta = $request->tipo_cuenta;
            $campana->numero_cuenta = $request->numero_cuenta;
            $campana->rif = $request->rif;
            $campana->condiciones = $request->condiciones;
            $campana->presentacion = $request->presentacion;

            if($campana->save()){

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

                    $nombre_img = "campana-". $campana->id . $extension;
                    $image = base64_decode($base64_string);

                    // \Storage::disk('campana')->put($nombre_img,  $image);
                    $img = Image::make($image)->resize(1440, 500);
                    $img->save('assets/uploads/campana/'.$nombre_img);

                    $campana->imagen = $nombre_img;
                    $campana->save();

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

                    $nombre_img = "campanapresentacion-". $campana->id . $extension;
                    $image = base64_decode($base64_string);

                    // \Storage::disk('campana')->put($nombre_img,  $image);
                    $img = Image::make($image)->resize(1440, 500);
                    $img->save('assets/uploads/campana/'.$nombre_img);

                    $campana->imagen_presentacion = $nombre_img;
                    $campana->save();

                }

                $arreglos = Session::get('recompensa');

                if($arreglos)
                {
                    foreach($arreglos as $arreglo){

                        $recompensa = New Recompensa;

                        $recompensa->academia_id = Auth::user()->academia_id;
                        $recompensa->campana_id = $campana->id;
                        $recompensa->nombre = $arreglo[0]['recompensa'];
                        $recompensa->cantidad = $arreglo[0]['cantidad'];
                        $recompensa->descripcion = $arreglo[0]['descripcion'];

                        $recompensa->save();

                    }
                }

                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }

        }else{

            return response()->json(['errores' => ['plazo' => [0, 'El plazo no puede ser mayor a 45 dias']], 'status' => 'ERROR'],422);
        }
    }
    }

    public function storePatrocinador(Request $request)
    {

        $rules = [
            'alumno_id' => 'required|numeric',
            'recompensa_id' => 'required',
            'campana_id' => 'required',
        ];

        $messages = [
            
            'alumno_id.required' => 'Ups! El patrocinador es requerido',
            'recompensa_id.required' => 'Ups! La recompensa es requerida',
            'campana_id.required' => 'Ups! La campaña es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

                $recompensa = Recompensa::find($request->recompensa_id);

                $patrocinador = new Patrocinador;

                $patrocinador->academia_id = Auth::user()->academia_id;
                $patrocinador->campana_id = $request->campana_id;
                $patrocinador->campana_id = $request->campana_id;
                $patrocinador->usuario_id = $request->alumno_id;
                $patrocinador->tipo_id = 1;
                $patrocinador->monto = $recompensa->cantidad;

                if($patrocinador->save()){

                    $item_factura = new ItemsFacturaProforma;
                    
                    $item_factura->alumno_id = $request->alumno_id;
                    $item_factura->academia_id = Auth::user()->academia_id;
                    $item_factura->fecha = Carbon::now()->toDateString();
                    $item_factura->item_id = $request->recompensa_id;
                    $item_factura->nombre = 'Campaña - Contribucion';
                    $item_factura->tipo = 11;
                    $item_factura->cantidad = 1;
                    $item_factura->precio_neto = 0;
                    $item_factura->impuesto = 0;
                    $item_factura->importe_neto = $recompensa->cantidad;
                    $item_factura->fecha_vencimiento = Carbon::now()->toDateString();

                    if($item_factura->save()){

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

    public function updateCantidad(Request $request){

        $campana = Campana::find($request->id);
        $campana->cantidad = $request->cantidad;

        $rules = [
            'cantidad' => 'required|numeric',
        ];

        $messages = [

            'cantidad.required' => 'Ups! La cantidad de dinero a recaudar es  requerida',
            'cantidad.numeric' => 'Ups! El campo de recaudar es inválido, debe contener sólo números',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            if($campana->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateNombre(Request $request){

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

            $campana = Campana::find($request->id);

            $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->nombre))));

            $campana->nombre = $nombre;

            if($campana->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
            // return redirect("alumno/edit/{$request->id}");
        }
    }

    public function updateEslogan(Request $request){

        $rules = [
            'eslogan' => 'required|min:3|max:100',
        ];

        $messages = [

            'eslogan.required' => 'Ups! El Eslogan es requerido',
            'eslogan.min' => 'El mínimo de caracteres permitidos son 3',
            'eslogan.max' => 'El máximo de caracteres permitidos son 100',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $campana = Campana::find($request->id);
            $eslogan = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->eslogan))));
            $campana->eslogan = $eslogan;

            if($campana->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
            // return redirect("alumno/edit/{$request->id}");
        }
    }

    public function updateHistoria(Request $request){

        $rules = [
            'historia' => 'required|min:3|max:1000',
        ];

        $messages = [

            'historia.required' => 'Ups! La Historia es requerida',
            'historia.min' => 'El mínimo de caracteres permitidos son 3',
            'historia.max' => 'El máximo de caracteres permitidos son 1000',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $campana = Campana::find($request->id);

            $historia = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->historia))));
        
            $campana->historia = $request->historia;

            if($campana->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
            // return redirect("alumno/edit/{$request->id}");
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

            $campana = Campana::find($request->id);

            $presentacion = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->presentacion))));
        
            $campana->presentacion = $request->presentacion;

            if($campana->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
            // return redirect("alumno/edit/{$request->id}");
        }
    }

    
    public function updatePlazo(Request $request){

        $rules = [
            'plazo' => 'required|numeric',
        ];

        $messages = [

            'plazo.required' => 'Ups! El Plazo es requerido',
            'plazo.numeric' => 'Ups! El Plazo es inválido, debe contener sólo números',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            if($request->plazo <= 45){


                $fecha_inicio = Carbon::now()->toDateString();
                $fecha_final = Carbon::now()->addDays($request->plazo)->toDateString();

                $campana = Campana::find($request->id);
                $campana->plazo = $request->plazo;
                $campana->fecha_inicio = $fecha_inicio;
                $campana->fecha_final = $fecha_final;

                if($campana->save()){
                    return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }

            }else{

                return response()->json(['errores' => ['plazo' => [0, 'El plazo no puede ser mayor a 45 dias']], 'status' => 'ERROR'],422);
            }
        }
        // return redirect("alumno/edit/{$request->id}");
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

        $campana = Campana::find($request->id);
        $campana->link_video = $request->link_video;

        if($campana->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateRecompensa(Request $request){
        $campana = Campana::find($request->id);
        $campana->recompensa = $request->recompensa;

        if($campana->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateCorreo(Request $request){
        $campana = Campana::find($request->id);
        $campana->correo = $request->correo;
        if($campana->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateDatosBancarios(Request $request){
        $campana = Campana::find($request->id);
        $campana->nombre_banco = $request->nombre_banco;
        $campana->tipo_cuenta = $request->tipo_cuenta;
        $campana->numero_cuenta = $request->numero_cuenta;
        $campana->rif = $request->rif;
        $campana->correo = $request->correo;

        if($campana->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateImagen(Request $request)
    {           

                $campana = Campana::find($request->id);
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

                    $nombre_img = "campana-". $campana->id . $extension;
                    $image = base64_decode($base64_string);

                    // \Storage::disk('campana')->put($nombre_img,  $image);
                    $img = Image::make($image)->resize(1440, 500);
                    $img->save('assets/uploads/campana/'.$nombre_img);
                }
                else{
                    $nombre_img = "";
                }
                
                $campana->imagen = $nombre_img;
                $campana->save();

                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
    }

    public function updateImagenPresentacion(Request $request)
    {           

                $campana = Campana::find($request->id);
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

                    $nombre_img = "campanapresentacion-". $campana->id . $extension;
                    $image = base64_decode($base64_string);

                    // \Storage::disk('campana')->put($nombre_img,  $image);
                    $img = Image::make($image)->resize(1440, 500);
                    $img->save('assets/uploads/campana/'.$nombre_img);
                }
                else{
                    $nombre_img = "";
                }
                
                $campana->imagen_presentacion = $nombre_img;
                $campana->save();

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
        // $visitante_presencial_join = DB::table('visitantes_presenciales')
        //     ->join('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
        //     ->select('config_especialidades.nombre as especialidad_nombre')
        //     ->get();

        $campana = Campana::find($id);

        if($campana){
            $recompensas = Recompensa::where('campana_id' , $id)->get();
           return view('especiales.campana.planilla')->with(['campana' => $campana, 'recompensas' => $recompensas]);
        }else{
           return redirect("especiales/campañas"); 
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

    public function progreso($id)
    {

         $campaña = Campana::find($id);

         if($campaña->link_video){

            $parts = parse_url($campaña->link_video);
            $partes = explode( '=', $parts['query'] );
            $link_video = $partes[1];

            }
            else{
                $link_video = '';
            }

        $recompensas = Recompensa::where('campana_id', $id)->get();

         // $cantidad_reservaciones = DB::table('reservaciones')
         //     ->select('reservaciones.*')
         //     ->where('tipo_id', '=', $id)
         //     ->where('tipo_reservacion', '=', 1)
         // ->count();

         // if($clase_grupal_join->cupo_reservacion == 0){
         //    $cupo_reservacion = 1;
         // }
         // else{
         //    $cupo_reservacion = $clase_grupal_join->cupo_reservacion;
         // }

         // $porcentaje = intval(($cantidad_reservaciones / $cupo_reservacion) * 100);

         $alumnos = Alumno::where('academia_id', '=' ,  $campaña->academia_id)->get();
         $recaudado = Patrocinador::where('campana_id', '=' ,  $id)->sum('monto');
         $cantidad = Patrocinador::where('campana_id', '=' ,  $id)->count();

         $patrocinadores = DB::table('patrocinadores')
             ->Leftjoin('alumnos', 'patrocinadores.usuario_id', '=', 'alumnos.id')
             ->select('patrocinadores.*', 'alumnos.nombre', 'alumnos.apellido', 'alumnos.id')
             ->where('patrocinadores.campana_id', '=', $id)
             ->orderBy('patrocinadores.monto', 'desc')
         ->get();

         $porcentaje = intval(($recaudado / $campaña->cantidad) * 100);
         $academia = Academia::find($campaña->academia_id);

        return view('especiales.campana.reserva')->with(['campana' => $campaña, 'id' => $id , 'link_video' => $link_video, 'recompensas' => $recompensas, 'patrocinadores' => $patrocinadores, 'recaudado' => $recaudado, 'porcentaje' => $porcentaje, 'cantidad' => $cantidad, 'alumnos' => $alumnos, 'academia' => $academia]);
    }

    public function contribuir($id)
    {   
        $campana = Campana::find($id);
        $academia = Academia::find($campana->academia_id);
        return view('especiales.campana.contribuir')->with(['id' => $id, 'campana' => $campana, 'academia' => $academia]);        
    }

    public function contribuirPagar($id)
    {   
        $recompensa = Recompensa::find($id);
        $academia = Academia::find($recompensa->academia_id);

        $campana = Campana::find($academia->id);
        $alumnos = Alumno::where('academia_id', '=' ,  $campana->academia_id)->get();
        //dd($alumnos->all());
        //MERCADO PAGO
        $preference_data = array(
            "items" => array(
                array(
                //"id" => $array['mov_id'],
                "currency_id" => "VEF",
                "title" => $recompensa->nombre,
                "picture_url" => "http://app.easydancelatino.com/assets/img/EASY_DANCE_3_.jpg",
                "description" => $recompensa->descripcion,
                "quantity" => 1,
                "unit_price" =>  intval($recompensa->cantidad)
                )
            )/*,
            "payer" => array(
              "name" => $alumno->nombre,
              "surname" => $alumno->apellido,
              "email" => $alumno->correo,
              //"date_created" => "2014-07-28T09:50:37.521-04:00"
            )*/
        );
        $preference = MP::create_preference($preference_data);

        return view('especiales.campana.pagar_contribuir')->with(['id' => $id, 'recompensas' => $recompensa, 'academia' => $academia, 'datos' => $preference, 'campana' => $campana, 'alumnos' => $alumnos]);
    }

    //FUNCTION MERADOPAGO
    public function storeMercadopago(Request $request)
    {

        //dd($request->all());
        $numerofactura = DB::table('facturas')
            ->select('facturas.*')
            ->orderBy('created_at', 'desc')
            ->where('facturas.academia_id', '=', Auth::user()->academia_id)
        ->first();

        if($numerofactura){
           $numero_factura = $numerofactura->numero_factura + 1;
        }else{
            $academia = Academia::find(Auth::user()->academia_id);
                
                if($academia->numero_factura){
                    $numero_factura = $academia->numero_factura;
                }
                else{
                    $numero_factura = 1;
                }
        }

        $mercadopago = new MercadopagoMovs;
        $factura = new Factura;
        $patrocinador = new Patrocinador;

        if($request->json['collection_status']!=null){

            $factura->alumno_id = $request->alumno;
            $factura->academia_id = Auth::user()->academia_id;
            $factura->fecha = Carbon::now()->toDateString();
            $factura->hora = Carbon::now()->toTimeString();
            $factura->numero_factura = $numero_factura;
            $factura->concepto = $request->recompensa;

            $factura->save();

            $mercadopago->academia_id = Auth::user()->academia_id;
            $mercadopago->alumno_id = $request->alumno;
            $mercadopago->numero_factura = $numero_factura;
            $mercadopago->status_pago = $request->json['collection_status'];
            $mercadopago->pago_id = $request->json['collection_id'];
            $mercadopago->preference_id = $request->json['preference_id'];
            $mercadopago->tipo_pago = $request->json['payment_type'];

            $mercadopago->save();

            $patrocinador->academia_id = Auth::user()->academia_id;
            $patrocinador->campana_id = $request->campana_id;
            $patrocinador->usuario_id = $request->alumno;
            $patrocinador->tipo_id = 1;
            $patrocinador->monto = $request->monto;

            $patrocinador->save();

            return 'Movimiento Generado en Base de Datos';
        }
        return 'No se genero ningun Registro en Base de Datos';

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {

        $campana = Campana::find($id);

        $fecha_final = Carbon::createFromFormat('Y-m-d', $campana->fecha_final);

        if($fecha_final < Carbon::now()){
            
            if($campana->delete()){
                return response()->json(['mensaje' => '¡Excelente! El Taller se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }else{
            return response()->json(['error_mensaje'=> 'Ups! Esta campaña no puede ser eliminada ya que esta activa' , 'status' => 'ERROR-BORRADO'],422);
        }
    }

}