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
use App\ItemsFactura;
use App\MercadopagoMovs;
use App\UsuarioExterno;
use App\TransferenciaCampana;
use Validator;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;
use Image;
use MP;
use Mail;

class CampanaController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    
    // public function index()
    // {

    //     $campanas = DB::table('campanas')
    //         ->select('campanas.*')
    //         ->where('campanas.academia_id' , '=' , Auth::user()->academia_id)
    //         ->OrderBy('campanas.created_at')
    //     ->get();

    //     $array=array();
    //     $i = 0;
    //     $cantidad = 0;
    //     $total = 0;

    //     foreach($campanas as $campana){
            
    //         $recaudado = Patrocinador::where('campana_id', '=' ,  $campana->id)->sum('monto');
    //         $collection=collect($campana);     
    //         $campana_array = $collection->toArray();
            
    //         $campana_array['total']=$recaudado;
    //         $array[$campana->id] = $campana_array;
    
    //     }

    //     return view('especiales.campana.principal')->with('campanas', $array);
    // }

    public function index(){

        $campanas = DB::table('campanas')
            ->select('campanas.*')
            ->where('campanas.academia_id' , '=' , Auth::user()->academia_id)
            ->OrderBy('campanas.created_at')
        ->get();

        $array=array();
        $i = 0;
        $cantidad = 0;
        $total = 0;

        $academia = Academia::find(Auth::user()->academia_id);

        if(Auth::user()->usuario_tipo == 1 OR Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6){

            foreach($campanas as $campana){
            
                $recaudado = Patrocinador::where('campana_id', '=' ,  $campana->id)->sum('monto');
                $collection=collect($campana);     
                $campana_array = $collection->toArray();
                
                $campana_array['total']=$recaudado;
                $array[$campana->id] = $campana_array;
        
            }

            return view('especiales.campana.principal')->with(['campanas' => $array, 'academia' => $academia]);

        }else{

            foreach($campanas as $campana){

                $fecha = Carbon::createFromFormat('Y-m-d', $campana->fecha_inicio);

                if($fecha > Carbon::now()){

                    $recaudado = Patrocinador::where('campana_id', '=' ,  $campana->id)->sum('monto');
                    $collection=collect($campana);     
                    $campana_array = $collection->toArray();
                    
                    $campana_array['total']=$recaudado;
                    $array[$campana->id] = $campana_array;
                }
            }

             return view('especiales.campana.principal')->with(['campanas' => $array, 'academia' => $academia]);

        }
    }

    public function principalcontribuciones($id){

        $contribuciones = TransferenciaCampana::where('campana_id', $id)->where('status', 0)->get();

        return view('especiales.campana.contribucion')->with(['contribuciones' => $contribuciones, 'id' => $id]);

    }

    public function indexconacademia($id)
    {

        $campanas = DB::table('campanas')
            ->select('campanas.*')
            ->where('campanas.academia_id' , '=' , $id)
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
        'eslogan' => 'required|min:5|max:100',
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
        'eslogan.max' => 'El máximo de caracteres permitidos son 100', 
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

        if($request->plazo <= 60){

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

            // $historia = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->historia))));

            // $eslogan = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->eslogan))));

            $historia = $request->historia;
            $eslogan = $request->eslogan;

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

            return response()->json(['errores' => ['plazo' => [0, 'El plazo no puede ser mayor a 60 dias']], 'status' => 'ERROR'],422);
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

    public function storeTransferencia(Request $request)
    {

    $rules = [
        'nombre' => 'required|min:3|max:50|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'sexo' => 'required',
        'monto' => 'required|numeric',
        'nombre_banco' => 'required',
        'numero_cuenta' => 'required',
        'rif' => 'required|min:7',
        'correo' => 'required|email|max:255',
    ];

    $messages = [
        
        'nombre.required' => 'Ups! El Nombre del contribuyente es requerido',
        'nombre.min' => 'El mínimo de caracteres permitidos son 5',
        'nombre.max' => 'El máximo de caracteres permitidos son 50',
        'nombre.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
        'sexo.required' => 'Ups! El Sexo  es requerido ',
        'monto.required' => 'Ups! El monto es requerido',
        'monto.numeric' => 'Ups! El monto es inválido, debe contener sólo números',
        'nombre_banco.required' => 'Ups! El Nombre del banco es requerido',
        'numero_cuenta.required' => 'Ups! El Numero de Transferencia es requerido',
        'rif.required' => 'Ups! La Cedula - Pasaporte es requerido',
        'rif.min' => 'El mínimo de numeros permitidos son 7',
        'correo.required' => 'Ups! El correo  es requerido ',
        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'correo.max' => 'El máximo de caracteres permitidos son 255',
    ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

                Session::put('nombre_contribuyente', $request->nombre);

                $transferencia = new TransferenciaCampana;

                $transferencia->campana_id = $request->id;
                $transferencia->nombre = $request->nombre;
                $transferencia->sexo = $request->sexo;
                $transferencia->monto = $request->monto;
                $transferencia->nombre_banco = $request->nombre_banco;
                $transferencia->numero_cuenta = $request->numero_cuenta;
                $transferencia->rif = $request->rif;
                $transferencia->correo = $request->correo;

                if($transferencia->save()){

                    if($request->correo)
                    {

                        $subj = 'ESTAMOS MUY FELICES CON TU CONTRIBUCIÓN';

                        $array = [

                           'nombre' => $request->nombre,
                           'link' => "http://app.easydancelatino.com/especiales/campañas/progreso/".$request->id,
                           'correo' => $transferencia->correo = $request->correo,
                           'subj' => $subj,
                           'id' => $transferencia->id

                        ];

                        Mail::send('correo.confirmacion_campana', $array, function($msj) use ($array){
                                $msj->subject($array['subj']);
                                $msj->to($array['correo']);
                            });

                    }

                    return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
          
                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }

            }
        }

    public function enhorabuena($id)
    {
        $nombre = Session::get('nombre_contribuyente');
        return view('especiales.campana.enhorabuena')->with(['id' => $id, 'nombre' => $nombre]);
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
            // $eslogan = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->eslogan))));

            $eslogan = $request->eslogan;
            
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

            // $historia = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->historia))));

            $historia = $request->historia;
        
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

    public function updateCondiciones(Request $request){
        $campana = Campana::find($request->id);
        $campana->condiciones = $request->condiciones;

        if($campana->save()){
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
        Session::forget('invitaciones');

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
             ->Leftjoin('usuario_externos','patrocinadores.externo_id', '=', 'usuario_externos.id')
             //->select('patrocinadores.*', 'alumnos.nombre', 'alumnos.apellido', 'alumnos.id')
             ->selectRaw('patrocinadores.*, IF(alumnos.nombre is null AND alumnos.apellido is null, usuario_externos.nombre, CONCAT(alumnos.nombre, " " , alumnos.apellido)) as Nombres, IF(alumnos.sexo is null, usuario_externos.sexo, alumnos.sexo) as sexo, alumnos.id')
             ->where('patrocinadores.campana_id', '=', $id)
             // ->orderBy('patrocinadores.monto', 'desc')
         ->get();

         $porcentaje = intval(($recaudado / $campaña->cantidad) * 100);
         $academia = Academia::find($campaña->academia_id);

        return view('especiales.campana.reserva')->with(['campana' => $campaña, 'id' => $id , 'link_video' => $link_video, 'recompensas' => $recompensas, 'patrocinadores' => $patrocinadores, 'recaudado' => $recaudado, 'porcentaje' => $porcentaje, 'cantidad' => $cantidad, 'alumnos' => $alumnos, 'academia' => $academia]);
    }

    public function contribuirCampana($id)
    {   
        if(Auth::check()){
            $usuario_tipo = Auth::user()->usuario_tipo;
            $usuario_id = Auth::user()->id;
            $usuario_nombre = Auth::user()->nombre . ' ' . Auth::user()->apellido;
        }else{
            $usuario_tipo = '';
            $usuario_id = '';
            $usuario_nombre = '';
        }

        $campana = Campana::find($id);
        $alumnos = Alumno::where('academia_id', '=' ,  $campana->academia_id)->get();

        $academia = Academia::find($campana->academia_id);
        return view('especiales.campana.contribuir_campana')->with(['id' => $id, 'campana' => $campana, 'academia' => $academia, 'usuario_tipo' => $usuario_tipo, 'usuario_id' => $usuario_id, 'usuario_nombre' => $usuario_nombre, 'alumnos' => $alumnos]);        
    }

    public function contribuirRecompensa($id)
    {   

        if(Auth::check()){
            $usuario_tipo = Auth::user()->usuario_tipo;
            $usuario_id = Auth::user()->id;
            $usuario_nombre = Auth::user()->nombre . ' ' . Auth::user()->apellido;
        }else{
            $usuario_tipo = '';
            $usuario_id = '';
            $usuario_nombre = '';
        }

        $recompensa = Recompensa::find($id);
        $academia = Academia::find($recompensa->academia_id);

        $campana = Campana::find($recompensa->campana_id);
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
              "name" => $alumno->nocontribuimbre,
              "surname" => $alumno->apellido,
              "email" => $alumno->correo,
              //"date_created" => "2014-07-28T09:50:37.521-04:00"
            )*/
        );
        $preference = MP::create_preference($preference_data);

        return view('especiales.campana.contribuir_recompensa')->with(['id' => $id, 'recompensas' => $recompensa, 'academia' => $academia, 'datos' => $preference, 'campana' => $campana, 'alumnos' => $alumnos, 'usuario_tipo' => $usuario_tipo, 'usuario_id' => $usuario_id, 'usuario_nombre' => $usuario_nombre]);
    }

    //VISTA PARA PAGOS DE CONTRIBUCION / DONACION PARTICIPANTES EXTERNOS
    public function contribuirExterno(Request $request){

        $rules = [
            'nombre' => 'required|min:3|max:40',
            'monto' => 'required|numeric',
        ];

        $messages = [

            'nombre.required' => 'Ups! El Nombre es requerido',
            'nombre.min' => 'El mínimo de caracteres permitidos son 3',
            'nombre.max' => 'El máximo de caracteres permitidos son 40',
            'monto.numeric' => 'Ups! El costo es inválido, debe contener sólo  números',
            'monto.required' => 'Ups! El costo es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        if(!Auth::check())
        {

            $rules = [
                'email_externo' => 'required|email',
            ];

            $messages = [
                'email_externo.required' => 'Ups! El correo  es requerido ',
                'email_externo.email' => 'Ups! El correo tiene una dirección inválida',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()){

                return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

            }

        }

        if(Auth::check()){

            if($request->alumno_id){
                $alumno = Alumno::find($request->alumno_id);
                $nombre = $alumno->nombre . ' ' . $alumno->apellido;
                $email = $alumno->correo;
            }else{
                $nombre = Auth::user()->nombre;
                $email = Auth::user()->email;
            }
            
            $request->merge(array('nombre' => $nombre));
            $request->merge(array('email_externo' => $email));

        }else{
            $nombre = $request->nombre;
            $email = $request->email_externo;
        }

        $preference_data = array(
            "items" => array(
                array(
                //"id" => $array['mov_id'],
                "currency_id" => "VEF",
                "title" => "Contribucion Campaña ".$request->campana_nombre,
                "picture_url" => "http://app.easydancelatino.com/assets/img/EASY_DANCE_3_.jpg",
                "description" => 'Contribucion para la campaña '. $request->campana_nombre,
                "quantity" => 1,
                "unit_price" =>  intval($request->monto)
                )
            ),
            "payer" => array(
              "name" => $nombre,
              /*"surname" => $alumno->apellido,*/
              "email" => $email,
              //"date_created" => "2014-07-28T09:50:37.521-04:00"
            )
        );

        $preference = MP::create_preference($preference_data);
        Session::put('data_pago', $preference);
        Session::put('data_user', $request->all());

        if(isset($request,$preference)){
            return response()->json(['mensaje' => 'Preferencia de pago creada', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }
    //RETORNO A VISTA PARA PAGAR
    public function procesarExterno()
    {
        return view('especiales.campana.contribuir_participante_externo')->with(['datos' => Session::get('data_pago'), 'usuario_ext' => Session::get('data_user')]);
    }

    //FUNCTION MERADOPAGO
    public function storeMercadopago(Request $request)
    {
        //SI EL USUARIO ESTA LOGEADO (SI LA SESION EXISTE)
        if(Auth::check()){

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

                if($request->alumno_id){
                    $array = array(2, 4);
                    $alumno_id = $request->alumno_id;
                    $alumno = Alumno::find($request->alumno_id);
                    $usuario = User::where('usuario_id', $alumno->id)->whereIn('usuario_tipo', $array)->first();
                    $usuario_id = $usuario->id;
                }else{
                    $alumno_id = Auth::user()->usuario_id;
                    $usuario_id = Auth::user()->id;
                }

                //$factura->alumno_id = $request->alumno;
                $factura->alumno_id = $alumno_id;
                $factura->academia_id = Auth::user()->academia_id;
                $factura->fecha = Carbon::now()->toDateString();
                $factura->hora = Carbon::now()->toTimeString();
                $factura->numero_factura = $numero_factura;
                $factura->concepto = 'Contribucion para la campaña '. $request->campana_nombre;

                $factura->save();

                $item_factura = new ItemsFactura;

                $item_factura->factura_id = $factura->id;
                $item_factura->item_id = $factura->id;
                $item_factura->nombre = 'Contribucion para la campaña '. $request->campana_nombre;
                $item_factura->tipo = 12;
                $item_factura->cantidad = 1;
                $item_factura->precio_neto = 0;
                $item_factura->impuesto = 0;
                $item_factura->importe_neto = $request->monto;

                $item_factura->save();

                $mercadopago->academia_id = Auth::user()->academia_id;
                $mercadopago->alumno_id = $alumno_id;
                $mercadopago->numero_factura = $numero_factura;
                $mercadopago->status_pago = $request->json['collection_status'];
                $mercadopago->pago_id = $request->json['collection_id'];
                $mercadopago->preference_id = $request->json['preference_id'];
                $mercadopago->tipo_pago = $request->json['payment_type'];

                $mercadopago->save();

                $patrocinador->academia_id = Auth::user()->academia_id;
                $patrocinador->campana_id = $request->campana_id;
                $patrocinador->usuario_id = $usuario_id;
                $patrocinador->tipo_id = 1;
                $patrocinador->monto = $request->monto;

                $patrocinador->save();

                return 'Movimiento Generado en Base de Datos';
            }
            return 'No se genero ningun Registro en Base de Datos';
        
        }else{//USUARIOS EXTERNOS (CUANDO NO HAY SESION)

            $numerofactura = DB::table('facturas')
                ->select('facturas.*')
                ->orderBy('created_at', 'desc')
                ->where('facturas.academia_id', '=', $request->academia_id)
            ->first();

            if($numerofactura){
               $numero_factura = $numerofactura->numero_factura + 1;
            }else{
                $academia = Academia::find($request->academia_id);
                    
                    if($academia->numero_factura){
                        $numero_factura = $academia->numero_factura;
                    }
                    else{
                        $numero_factura = 1;
                    }
            }
            //INSTANCIAMOS LOS OBJETOS
            $UsuarioExterno = new UsuarioExterno;
            $mercadopago = new MercadopagoMovs;
            $factura = new Factura;
            $patrocinador = new Patrocinador;

            if($request->json['collection_status']!=null){

                $UsuarioExterno->nombre = $request->nombre;
                $UsuarioExterno->sexo = $request->sexo;
                $UsuarioExterno->campana_id = $request->campana_id;
                $UsuarioExterno->monto = $request->monto;
                $UsuarioExterno->correo = $request->email_externo;

                $UsuarioExterno->save();

                $factura->externo_id = $UsuarioExterno->id;
                $factura->academia_id = $request->academia_id;
                $factura->fecha = Carbon::now()->toDateString();
                $factura->hora = Carbon::now()->toTimeString();
                $factura->numero_factura = $numero_factura;
                $factura->concepto = 'Contribucion para la campaña '. $request->campana_nombre;

                $factura->save();

                $item_factura = new ItemsFactura;

                $item_factura->factura_id = $factura->id;
                $item_factura->item_id = $factura->id;
                $item_factura->nombre = 'Contribucion para la campaña '. $request->campana_nombre;
                $item_factura->tipo = 12;
                $item_factura->cantidad = 1;
                $item_factura->precio_neto = 0;
                $item_factura->impuesto = 0;
                $item_factura->importe_neto = $request->monto;

                $item_factura->save();

                $mercadopago->academia_id = $request->academia_id;
                $mercadopago->externo_id = $UsuarioExterno->id;
                $mercadopago->numero_factura = $numero_factura;
                $mercadopago->status_pago = $request->json['collection_status'];
                $mercadopago->pago_id = $request->json['collection_id'];
                $mercadopago->preference_id = $request->json['preference_id'];
                $mercadopago->tipo_pago = $request->json['payment_type'];

                $mercadopago->save();

                $patrocinador->academia_id = $request->academia_id;
                $patrocinador->campana_id = $request->campana_id;
                $patrocinador->externo_id = $UsuarioExterno->id;
                $patrocinador->tipo_id = 1;
                $patrocinador->monto = $request->monto;

                $patrocinador->save();

                return 'Movimiento Generado en Base de Datos';
            }

            Session::forget('data_user');
            Session::forget('data_pago');
            
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

    public function confirmarcontribucion($id)
    {

        $contribucion = TransferenciaCampana::find($id);

        $contribucion->status = 1;
            
        if($contribucion->save()){

            $campana = Campana::find($contribucion->campana_id);

            $numerofactura = DB::table('facturas')
                ->select('facturas.*')
                ->orderBy('created_at', 'desc')
                ->where('facturas.academia_id', '=', $campana->academia_id)
            ->first();

            if($numerofactura){
               $numero_factura = $numerofactura->numero_factura + 1;
            }else{
                $academia = Academia::find($campana->academia_id);
                    
                    if($academia->numero_factura){
                        $numero_factura = $academia->numero_factura;
                    }
                    else{
                        $numero_factura = 1;
                    }
            }

            $UsuarioExterno = new UsuarioExterno;
            $factura = new Factura;
            $patrocinador = new Patrocinador;

            $UsuarioExterno->nombre = $contribucion->nombre;
            $UsuarioExterno->sexo = $contribucion->sexo;
            $UsuarioExterno->campana_id = $contribucion->campana_id;
            $UsuarioExterno->monto = $contribucion->monto;
            $UsuarioExterno->correo = $contribucion->correo;

            $UsuarioExterno->save();

            $factura->externo_id = $UsuarioExterno->id;
            $factura->academia_id = $campana->academia_id;
            $factura->fecha = Carbon::now()->toDateString();
            $factura->hora = Carbon::now()->toTimeString();
            $factura->numero_factura = $numero_factura;
            $factura->concepto = 'Contribucion para la campaña '. $campana->nombre;

            $factura->save();

            $item_factura = new ItemsFactura;

            $item_factura->factura_id = $factura->id;
            $item_factura->item_id = $factura->id;
            $item_factura->nombre = 'Contribucion para la campaña '. $campana->nombre;
            $item_factura->tipo = 12;
            $item_factura->cantidad = 1;
            $item_factura->precio_neto = 0;
            $item_factura->impuesto = 0;
            $item_factura->importe_neto = $contribucion->monto;

            $item_factura->save();

            $patrocinador->academia_id = $campana->academia_id;
            $patrocinador->campana_id = $contribucion->campana_id;
            $patrocinador->externo_id = $UsuarioExterno->id;
            $patrocinador->tipo_id = 1;
            $patrocinador->monto = $contribucion->monto;

            $patrocinador->save();

            return response()->json(['mensaje' => '¡Excelente! El Taller se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function eliminarcontribucion($id)
    {

        $contribucion = TransferenciaCampana::find($id);
            
        if($contribucion->delete()){
            return response()->json(['mensaje' => '¡Excelente! El Taller se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function principalinvitar($id){

        Session::forget('invitaciones');

        return view('especiales.campana.invitar')->with('id', $id);

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

            $campana_id = $request->id;
            $nombre = $request->invitacion_nombre;

        }else{

            $contribucion = TransferenciaCampana::find($request->id);
            $campana_id = $contribucion->campana_id;
            $nombre = $contribucion->nombre;

        }

        
            $invitaciones = Session::get('invitaciones');

            if($invitaciones)
            {

                foreach($invitaciones as $invitacion){

                    $subj =  $nombre . ' te invita a contribuir con la campaña “TODOS CON ROBERT”';
                    
                    $array = [
                       'correo' => $invitacion[0]['email'],
                       'nombre_envio' => $nombre,
                       'nombre_destino' => $invitacion[0]['nombre'],
                       'id' => $campana_id,
                       'subj' => $subj
                    ];

                     Mail::send('correo.invitacion_campana', $array , function($msj) use ($array){
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
    {;
        return view('especiales.campana.enhorabuena_invitacion')->with('id', $id);
    }

}