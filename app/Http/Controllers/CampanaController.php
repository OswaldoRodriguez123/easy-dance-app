<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Campana;
use App\Recompensa;
use App\Alumno;
use Validator;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;
use Image;

class CampanaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {

        return view('especiales.campana.principal')->with('campana', Campana::where('academia_id', '=' ,  Auth::user()->academia_id)->get());
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
        'nombre' => 'required|min:5|max:50',
        'eslogan' => 'required|min:5|max:30',
        'historia' => 'required',
        'plazo' => 'required|numeric',
    ];

    $messages = [
        
        'cantidad.required' => 'Ups! La cantidad de dinero a recaudar es  requerida',
        'cantidad.numeric' => 'Ups! El campo de recaudar es inválido, debe contener sólo números',
        'nombre.required' => 'Ups! El título de la campaña es requerido',
        'nombre.min' => 'El mínimo de caracteres permitidos son 5',
        'nombre.max' => 'El máximo de caracteres permitidos son 50',
        'eslogan.required' => 'Ups! El Eslogan es requerido',
        'eslogan.min' => 'El mínimo de caracteres permitidos son 5',
        'eslogan.max' => 'El máximo de caracteres permitidos son 30', 
        'historia.required' => 'Ups! La Historia es requerida',
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
            'nombre' => 'required|min:3|max:50',
        ];

        $messages = [

            'nombre.required' => 'Ups! El Nombre es requerido',
            'nombre.min' => 'El mínimo de caracteres permitidos son 3',
            'nombre.max' => 'El máximo de caracteres permitidos son 50',
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
            'historia' => 'required|min:3|max:100',
        ];

        $messages = [

            'historia.required' => 'Ups! La Historia es requerida',
            'historia.min' => 'El mínimo de caracteres permitidos son 3',
            'historia.max' => 'El máximo de caracteres permitidos son 100',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $campana = Campana::find($request->id);

            $historia = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->historia))));
        
            $campana->historia = $historia;

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
        $campana->rif = $request->rif;
        $campana->correo_electrico = $request->correo_electrico;

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

         $privilegio = Auth::user()->tipo_usuario;

         if($privilegio == 10){
            $administrador = 1;
         }
         else{
             $administrador = 0;
         }

         $alumnos = Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

        return view('especiales.campana.reserva')->with(['campana' => $campaña, 'id' => $id , 'administrador' => $administrador, 'link_video' => $link_video, 'recompensas' => $recompensas, 'alumnos' => $alumnos]);
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
        
        if($campana->delete()){
            return response()->json(['mensaje' => '¡Excelente! El Taller se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

}