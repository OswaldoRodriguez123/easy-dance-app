<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Campana;
use App\User;
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
use App\DatosBancariosCampana;
use App\Egreso;
use App\ConfigEgreso;
use Validator;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;
use Image;
use MP;
use Mail;

class CampanaController extends BaseController {

public function todos_con_robert()
    {
        Session::forget('invitaciones');

        $id = 9;

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

         $alumnos = Alumno::where('academia_id', '=' ,  $campaña->academia_id)->orderBy('nombre', 'asc')->get();
         // $recaudado = Patrocinador::where('campana_id', '=' ,  $id)->sum('monto');
         $cantidad = Patrocinador::where('campana_id', '=' ,  $id)->count();

         $patrocinadores = DB::table('patrocinadores')
             ->Leftjoin('alumnos', 'patrocinadores.usuario_id', '=', 'alumnos.id')
             ->Leftjoin('usuario_externos','patrocinadores.externo_id', '=', 'usuario_externos.id')
             //->select('patrocinadores.*', 'alumnos.nombre', 'alumnos.apellido', 'alumnos.id')
             ->selectRaw('patrocinadores.*, IF(alumnos.nombre is null AND alumnos.apellido is null, usuario_externos.nombre, CONCAT(alumnos.nombre, " " , alumnos.apellido)) as Nombres, IF(alumnos.sexo is null, usuario_externos.sexo, alumnos.sexo) as sexo, patrocinadores.created_at')
             ->where('patrocinadores.campana_id', '=', $id)
             ->orderBy('patrocinadores.created_at', 'desc')
         ->get();

         mb_internal_encoding("UTF-8");

        $fecha_de_realizacion_general = array();
        $now = Carbon::now();

        $recaudado = 0;

         foreach($patrocinadores as $patrocinador){
            // $patrocinador->Nombres = mb_convert_case($patrocinador->Nombres, MB_CASE_TITLE, "utf8");
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
                    // $fecha_de_realizacion = "hace ".$diferencia_tiempo." dia";
                    $hora_segundos = $fecha_de_registro->format('H:i');
                    $fecha_de_realizacion = "Ayer a las ".$hora_segundos;
                 }else{
                    // $fecha_de_realizacion = "hace ".$diferencia_tiempo." dias";
                    $hora_segundos = $fecha_de_registro->format('H:i');
                    $dia = $fecha_de_registro->format('d');
                    $fecha_de_realizacion = $dia . " de septiembre a las ".$hora_segundos;
                 }
            }
            $fecha_de_realizacion_general[$patrocinador->id]=$fecha_de_realizacion;

            if($patrocinador->tipo_moneda == 1){
                $patrocinador_monto = $patrocinador->monto;
            }else{
                $patrocinador_monto = $patrocinador->monto * 1000;
            }

            $recaudado = $recaudado + $patrocinador_monto;
         }

         $porcentaje = intval(($recaudado / $campaña->cantidad) * 100);
         $academia = Academia::find($campaña->academia_id);

         $datos = DatosBancariosCampana::where('campana_id', $campaña->id)->get();

        return view('especiales.campana.reserva')->with(['campana' => $campaña, 'id' => $id , 'link_video' => $link_video, 'recompensas' => $recompensas, 'patrocinadores' => $patrocinadores, 'recaudado' => $recaudado, 'porcentaje' => $porcentaje, 'cantidad' => $cantidad, 'alumnos' => $alumnos, 'academia' => $academia, 'fecha_de_realizacion' => $fecha_de_realizacion_general, 'datos' => $datos]);
    }

    public function index(){

        $campanas = Campana::where('campanas.academia_id' , '=' , Auth::user()->academia_id)
            ->OrderBy('campanas.created_at')
        ->get();

        $array=array();
        $i = 0;
        $cantidad = 0;
        $total = 0;

        $academia = Academia::find(Auth::user()->academia_id);

        if(Auth::user()->usuario_tipo == 1 OR Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6){

            foreach($campanas as $campana){

                $recaudado = 0;
                $patrocinador_monto = 0;

                $patrocinadores = Patrocinador::where('campana_id', '=' ,  $campana->id)->get();

                foreach($patrocinadores as $patrocinador){

                    if($patrocinador->tipo_moneda == 1){
                        $patrocinador_monto = $patrocinador->monto;
                    }else{
                        $patrocinador_monto = $patrocinador->monto * 1000;
                    }

                    $recaudado = $recaudado + $patrocinador_monto;

                }
                
                $collection=collect($campana);     
                $campana_array = $collection->toArray();
                
                $campana_array['total']=$recaudado;
                $array[$campana->id] = $campana_array;
        
            }

            return view('especiales.campana.principal')->with(['campanas' => $array, 'academia' => $academia]);

        }else{

            foreach($campanas as $campana){

                $fecha = Carbon::createFromFormat('Y-m-d', $campana->fecha_final);

                if($fecha > Carbon::now()){

                    $recaudado = 0;
                    $patrocinador_monto = 0;

                    $patrocinadores = Patrocinador::where('campana_id', '=' ,  $campana->id)->get();

                    foreach($patrocinadores as $patrocinador){

                        if($patrocinador->tipo_moneda == 1){
                            $patrocinador_monto = $patrocinador->monto;
                        }else{
                            $patrocinador_monto = $patrocinador->monto * 1000;
                        }

                        $recaudado = $recaudado + $patrocinador_monto;

                    }
                    
                    $collection=collect($campana);     
                    $campana_array = $collection->toArray();
                    
                    $campana_array['total']=$recaudado;
                    $array[$campana->id] = $campana_array;
            
                }
            }


             return view('especiales.campana.principal')->with(['campanas' => $array, 'academia' => $academia]);

        }
    }

    public function principalpatrocinadores($id){

        $patrocinadores = DB::table('patrocinadores')
            // ->join('usuario_externos','patrocinadores.externo_id', '=', 'usuario_externos.id')
            ->join('alumnos','patrocinadores.usuario_id', '=', 'alumnos.id')
            ->select('patrocinadores.*', 'alumnos.nombre', 'alumnos.apellido')
            ->where('patrocinadores.campana_id', '=', $id)
         ->get();

        return view('especiales.campana.patrocinadores')->with(['patrocinadores' => $patrocinadores, 'id' => $id]);

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
        Session::forget('datos_bancarios');

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

        $nombre = title_case($request->nombre);

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

            $nombre = title_case($request->nombre);
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

                $arreglos = Session::get('datos_bancarios');

                if($arreglos)
                {
                    foreach($arreglos as $arreglo){

                        $dato = New DatosBancariosCampana;

                        $dato->campana_id = $campana->id;
                        $dato->nombre_banco = $arreglo[0]['nombre_banco'];
                        $dato->tipo_cuenta = $arreglo[0]['tipo_cuenta'];
                        $dato->numero_cuenta = $arreglo[0]['numero_cuenta'];
                        $dato->rif = $arreglo[0]['rif'];
                        $dato->nombre = $arreglo[0]['nombre'];

                        $dato->save();

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
            'alumno_id' => 'required',
            'cantidad' => 'required|numeric',
            'recompensa_id' => 'required',
            'campana_id' => 'required',
        ];

        $messages = [
            
            'alumno_id.required' => 'Ups! El patrocinador es requerido',
            'cantidad.required' => 'Ups! La cantidad es requerida',
            'cantidad.numeric' => 'Ups! La cantidad es inválida , debe contener sólo números',
            'recompensa_id.required' => 'Ups! La recompensa es requerida',
            'campana_id.required' => 'Ups! La campaña es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

                $recompensa = Recompensa::find($request->recompensa_id);
                $monto = $recompensa->cantidad * $request->cantidad;

                $patrocinador = new Patrocinador;

                $patrocinador->academia_id = Auth::user()->academia_id;
                $patrocinador->campana_id = $request->campana_id;
                $patrocinador->usuario_id = $request->alumno_id;
                $patrocinador->tipo_id = 1;
                $patrocinador->monto = $monto;
                $patrocinador->cantidad = $request->cantidad;

                if($patrocinador->save()){

                    $item_factura = new ItemsFacturaProforma;
                    
                    $item_factura->alumno_id = $request->alumno_id;
                    $item_factura->academia_id = Auth::user()->academia_id;
                    $item_factura->fecha = Carbon::now()->toDateString();
                    $item_factura->item_id = $request->recompensa_id;
                    // $item_factura->nombre = 'Campaña - Contribucion';
                    $item_factura->nombre = $recompensa->nombre;
                    $item_factura->tipo = 11;
                    $item_factura->cantidad = $request->cantidad;
                    $item_factura->precio_neto = 0;
                    $item_factura->impuesto = 0;
                    $item_factura->importe_neto = $monto;
                    $item_factura->fecha_vencimiento = Carbon::now()->toDateString();

                    if($item_factura->save()){

                        $item_factura->item_id = $item_factura->id;
                        $item_factura->save();
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
    }else if($request->tipo_contribuyente == 2)
    {

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
    }else if($request->tipo_contribuyente == 3)
    {

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
    }else
    {

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

        }if($request->tipo_contribuyente == 1){
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

        $transferencia = new TransferenciaCampana;

        $transferencia->campana_id = $request->id;
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
                $campaña = Campana::find($transferencia->campana_id);

                $subj = 'ESTAMOS MUY FELICES CON TU CONTRIBUCIÓN';

                $array = [

                   'nombre' => $request->nombre,
                   'link' => "http://app.easydancelatino.com/especiales/campañas/progreso/".$request->id,
                   'correo' => $transferencia->correo,
                   'subj' => $subj,
                   'id' => $transferencia->id,
                   'campaña' => $campaña->nombre

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

    public function enhorabuena($id)
    {
        $nombre = Session::get('nombre_contribuyente');
        return view('especiales.campana.enhorabuena')->with(['id' => $id, 'nombre' => $nombre]);
    }

    public function updateCantidad(Request $request){

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

            $campana = Campana::find($request->id);
            $campana->cantidad = $request->cantidad;


            if($campana->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
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

            $nombre = title_case($request->nombre);

            $campana->nombre = $nombre;

            if($campana->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
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
            $eslogan = $request->eslogan;
            
            $campana->eslogan = $eslogan;

            if($campana->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
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

            $historia = $request->historia;
     
            $campana->historia = $historia;

            if($campana->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
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

            $presentacion = $request->presentacion;
        
            $campana->presentacion = $presentacion;

            if($campana->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
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

        $campana = Campana::find($id);

        if($campana){
            $recompensas = Recompensa::where('campana_id' , $id)->get();
            $datos = DatosBancariosCampana::where('campana_id' , $id)->get();
           return view('especiales.campana.planilla')->with(['campana' => $campana, 'recompensas' => $recompensas, 'datos' => $datos]);
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

        $alumnos = Alumno::where('academia_id', '=' ,  $campaña->academia_id)->orderBy('nombre', 'asc')->get();
         // $recaudado = Patrocinador::where('campana_id', '=' ,  $id)->sum('monto');
        $cantidad = Patrocinador::where('campana_id', '=' ,  $id)->count();

        $patrocinadores = DB::table('patrocinadores')
            ->Leftjoin('alumnos', 'patrocinadores.usuario_id', '=', 'alumnos.id')
            ->Leftjoin('usuario_externos','patrocinadores.externo_id', '=', 'usuario_externos.id')
             //->select('patrocinadores.*', 'alumnos.nombre', 'alumnos.apellido', 'alumnos.id')
            ->selectRaw('patrocinadores.*, IF(alumnos.nombre is null AND alumnos.apellido is null, usuario_externos.nombre, CONCAT(alumnos.nombre, " " , alumnos.apellido)) as Nombres, IF(alumnos.sexo is null, usuario_externos.sexo, alumnos.sexo) as sexo, patrocinadores.created_at, patrocinadores.monto, patrocinadores.tipo_moneda')
            ->where('patrocinadores.campana_id', '=', $id)
            ->orderBy('patrocinadores.created_at', 'desc')
        ->get();

        mb_internal_encoding("UTF-8");

        $fecha_de_realizacion_general = array();
        $now = Carbon::now();
        $recaudado = 0;
        $array = array(2,4);
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
                    // $fecha_de_realizacion = "hace ".$diferencia_tiempo." dia";
                    $hora_segundos = $fecha_de_registro->format('H:i');
                    $fecha_de_realizacion = "Ayer a las ".$hora_segundos;
                }else{
                    // $fecha_de_realizacion = "hace ".$diferencia_tiempo." dias";
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
            $fecha_de_realizacion_general[$patrocinador->id]=$fecha_de_realizacion;

            if($patrocinador->tipo_moneda == 1){
                $patrocinador_monto = $patrocinador->monto;
            }else{
                $patrocinador_monto = $patrocinador->monto * 1000;
            }

            $recaudado = $recaudado + $patrocinador_monto;

            $usuario = User::where('usuario_id',$patrocinador->usuario_id)->whereIn('usuario_tipo',$array)->first();

            if($usuario){

              if($usuario->imagen){
                $imagen = $usuario->imagen;
              }else{
                $imagen = '';
              }

            }

            $collection=collect($patrocinador);     
            $patrocinador_array = $collection->toArray();
                
            $patrocinador_array['imagen']=$imagen;
            $array_patrocinador[$patrocinador->id] = $patrocinador_array;
          
        }

        $porcentaje = intval(($recaudado / $campaña->cantidad) * 100);
        $academia = Academia::find($campaña->academia_id);

        $datos = DatosBancariosCampana::where('campana_id', $campaña->id)->get();

        return view('especiales.campana.reserva')->with(['campana' => $campaña, 'id' => $id , 'link_video' => $link_video, 'recompensas' => $recompensas, 'patrocinadores' => $array_patrocinador, 'recaudado' => $recaudado, 'porcentaje' => $porcentaje, 'cantidad' => $cantidad, 'alumnos' => $alumnos, 'academia' => $academia, 'fecha_de_realizacion' => $fecha_de_realizacion_general, 'datos' => $datos]);
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
        $alumnos = Alumno::where('academia_id', '=' ,  $campana->academia_id)->orderBy('nombre', 'asc')->get();

        $academia = Academia::find($campana->academia_id);
        return view('especiales.campana.contribuir_campana')->with(['id' => $id, 'campana' => $campana, 'academia' => $academia, 'usuario_tipo' => $usuario_tipo, 'usuario_id' => $usuario_id, 'usuario_nombre' => $usuario_nombre, 'alumnos' => $alumnos]);        
    }

    public function contribuirRecompensa($id)
    {   

        if(Auth::check()){
            $usuario_tipo = Auth::user()->usuario_tipo;
            $user_id = Auth::user()->id;
            $usuario_nombre = Auth::user()->nombre . ' ' . Auth::user()->apellido;
            $usuario_id = Auth::user()->usuario_id;
        }else{
            $usuario_tipo = '';
            $user_id = '';
            $usuario_nombre = '';
            $usuario_id = '';
        }

        $recompensa = Recompensa::find($id);
        $academia = Academia::find($recompensa->academia_id);

        $campana = Campana::find($recompensa->campana_id);
        $alumnos = Alumno::where('academia_id', '=' ,  $campana->academia_id)->OrderBy('nombre')->get();
        //dd($alumnos->all());
        //MERCADO PAGO
        // $preference_data = array(
        //     "items" => array(
        //         array(
        //         //"id" => $array['mov_id'],
        //         "currency_id" => "VEF",
        //         "title" => $recompensa->nombre,
        //         "picture_url" => "http://app.easydancelatino.com/assets/img/EASY_DANCE_3_.jpg",
        //         "description" => $recompensa->descripcion,
        //         "quantity" => 1,
        //         "unit_price" =>  intval($recompensa->cantidad)
        //         )
        //     )/*,
        //     "payer" => array(
        //       "name" => $alumno->nocontribuimbre,
        //       "surname" => $alumno->apellido,
        //       "email" => $alumno->correo,
        //       //"date_created" => "2014-07-28T09:50:37.521-04:00"
        //     )*/
        // );
        // $preference = MP::create_preference($preference_data);

        // 'datos' => $preference,

        return view('especiales.campana.contribuir_recompensa')->with(['id' => $id, 'recompensas' => $recompensa, 'academia' => $academia,  'campana' => $campana, 'alumnos' => $alumnos, 'usuario_tipo' => $usuario_tipo, 'usuario_id' => $usuario_id, 'usuario_nombre' => $usuario_nombre, 'user_id' => $user_id]);
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

                    $campaña = Campana::find($campana_id);

                    $subj =  $nombre . ' te invita a contribuir con la campaña “'.$campaña->nombre.'”';
                    
                    $array = [
                       'correo' => $invitacion[0]['email'],
                       'nombre_envio' => $nombre,
                       'nombre_destino' => $invitacion[0]['nombre'],
                       'id' => $campana_id,
                       'subj' => $subj,
                       'campaña' => $campaña->nombre,
                       'link' => "http://app.easydancelatino.com/especiales/campañas/progreso/".$campana_id
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
    {
        return view('especiales.campana.enhorabuena_invitacion')->with('id', $id);
    }

    public function enhorabuena_invitacion_sinid()
    {
        return view('especiales.campana.enhorabuena_invitacion');
    }


    public function agregardatos(Request $request){
        
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

            $array = array(['nombre_banco' => $request->nombre_banco, 'tipo_cuenta' => $request->tipo_cuenta, 'numero_cuenta' => $request->numero_cuenta, 'rif' => $request->rif, 'nombre' => $request->nombre_creador]);

            Session::push('datos_bancarios', $array);

            $items = Session::get('datos_bancarios');
            end( $items );
            $contador = key( $items );

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'id' => $contador, 200]);

        }
    }

    public function eliminardatos($id){

        $arreglo = Session::get('datos_bancarios');

        // unset($arreglo[$id]);
        unset($arreglo[$id]);
        Session::put('datos_bancarios', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

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

        $datos = New DatosBancariosCampana;

        $datos->campana_id = $request->id;
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

        $datos = DatosBancariosCampana::find($id);

        $datos->delete();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function ReenviarCorreoPatrocinador($id){
            
        $patrocinador = DB::table('patrocinadores')
            // ->join('usuario_externos','patrocinadores.externo_id', '=', 'usuario_externos.id')
            ->join('alumnos','patrocinadores.usuario_id', '=', 'alumnos.id')
            ->join('campanas','patrocinadores.campana_id', '=', 'campanas.id')
            ->select('patrocinadores.*', 'alumnos.nombre', 'alumnos.apellido', 'alumnos.id', 'alumnos.correo', 'campanas.nombre as campana_nombre')
            // ->select('patrocinadores.*', 'usuario_externos.nombre', 'usuario_externos.correo', 'campanas.nombre as campana_nombre')
            ->where('patrocinadores.id', '=', $id)
         ->first();

        if($patrocinador){

            if($patrocinador->correo){

                if($patrocinador->transferencia_id){
                    $link = 'http://app.easydancelatino.com/especiales/campañas/invitar/'.$patrocinador->transferencia_id;
                }else{
                    $link = "http://app.easydancelatino.com/especiales/campañas/progreso/".$patrocinador->campana_id;
                }
                
                $subj = 'ESTAMOS MUY FELICES CON TU CONTRIBUCIÓN';

                $array = [

                   'nombre' => $patrocinador->nombre . ' ' .$patrocinador->apellido,
                   'link' => "http://app.easydancelatino.com/especiales/campañas/progreso/".$patrocinador->campana_id,
                   'correo' => $patrocinador->correo,
                   'subj' => $subj,
                   'link_invitar' => $link,
                   'campaña' => $patrocinador->campana_nombre

                ];

                Mail::send('correo.confirmacion_campana', $array, function($msj) use ($array){
                    $msj->subject($array['subj']);
                    $msj->to($array['correo']);
                });

                return response()->json(['mensaje' => '¡Excelente! El campo se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);

                }else{
                    return response()->json(['error_mensaje'=> 'Ups! Este patrocinador no posee correo electrónico', 'status' => 'ERROR-ENVIO'],422);
                }

            }else{
                return response()->json(['error_mensaje'=> 'Ups! ha ocurrido un error', 'status' => 'ERROR-ENVIO'],422);
            }

    }

    public function egresos($id)
    {
        $campana = Campana::find($id);

        if($campana){

            $config_egresos = ConfigEgreso::all();

            $egresos = Egreso::Leftjoin('config_egresos', 'egresos.config_tipo' , '=', 'config_egresos.id')
                ->select('egresos.*', 'config_egresos.nombre as config_tipo')
                ->where('tipo_id',$id)
                ->where('tipo',4)
            ->get();

            $total = Egreso::Leftjoin('config_egresos', 'egresos.config_tipo' , '=', 'config_egresos.id')
                ->select('egresos.*', 'config_egresos.nombre as config_tipo')
                ->where('tipo_id',$id)
                ->where('tipo',4)
            ->sum('cantidad');

            return view('especiales.campana.egresos')->with(['campana' => $campana, 'egresos' => $egresos, 'total' => $total, 'config_egresos' => $config_egresos, 'id' => $id]);
        }else{
           return redirect("especiales/campañas"); 
        }
    }

}