<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Campana;
use Validator;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;

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
        return view('especiales.campana.create');
    }

    public function operar($id)
    {   
        $campana = Campana::find($id);
        return view('especiales.campana.operaciones')->with(['id' => $id, 'campana' => $campana]);        
    }

    public function agregarrecompensa(Request $request){
        
    $rules = [

        'recompensa' => 'required',
        'cantidad' => 'required|numeric',
    ];

    $messages = [

        'recompensa.required' => 'Ups! La recompensa es  requerida',
        'cantidad.required' => 'Ups! La cantidad es  requerida',
        'cantidad.numeric' => 'Ups! La cantidad es inválida, debe contener sólo números',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $array = array(['recompensa' => $request->recompensa, 'cantidad' => $request->cantidad]);

        Session::push('recompensa', $array);

        $contador = count(Session::get('recompensa'));
        $contador = $contador - 1;

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'id' => $contador, 200]);

    }
    }

    public function eliminarrecompensa($id){

        $arreglo = Session::get('recompensa');

        // unset($arreglo[$id]);
        unset($arreglo[$id]);
        Session::forget('recompensa');
        Session::push('recompensa', $arreglo);

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
        'cantidad' => 'required|numeric',
        'nombre' => 'required',
        'eslogan' => 'required',
        'historia' => 'required',
        'plazo' => 'required|numeric',
    ];

    $messages = [
        
        'cantidad.required' => 'Ups! La cantidad de dinero a recaudar es  requerida',
        'cantidad.numeric' => 'Ups! El campo de recaudar es inválido, debe contener sólo números',
        'nombre.required' => 'Ups! El título de la campaña es requerido',
        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre.max' => 'El máximo de caracteres permitidos son 50',
        'eslogan.required' => 'Ups! El Eslogan es requerido',
        'eslogan.min' => 'El mínimo de caracteres permitidos son 3',
        'eslogan.max' => 'El máximo de caracteres permitidos son 100', 
        'historia.required' => 'Ups! La Historia es requerida',
        'plazo.required' => 'Ups! El plazo es requerido',
        'plazo.numeric' => 'Ups! El plazo es inválido, debe contener sólo números',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->nombre))));

        $campana = new Campana;

        $campana->academia_id = Auth::user()->academia_id;
        $campana->nombre = $nombre;
        $campana->cantidad = $request->cantidad;
        $campana->historia = $request->historia;
        $campana->eslogan = $request->eslogan;
        $campana->plazo = $request->plazo;
        $campana->link_video = $request->link_video;
        $campana->recompensa = $request->recompensa;
        $campana->correo = $request->correo;
        $campana->nombre_banco = $request->nombre_banco;
        $campana->tipo_cuenta = $request->tipo_cuenta;
        $campana->rif = $request->rif;
        $campana->condiciones = $request->condiciones;

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

                \Storage::disk('campana')->put($nombre_img,  $image);

                $campana->imagen = $nombre_img;
                $campana->save();

            }
            
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
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

        $campana = Campana::find($request->id);
        $campana->eslogan = $request->eslogan;

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

            if($campana->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
            // return redirect("alumno/edit/{$request->id}");
        }
    }

    public function updateHistoria(Request $request){

        $campana = Campana::find($request->id);
        $campana->historia = $request->historia;

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

            if($campana->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
            // return redirect("alumno/edit/{$request->id}");
        }
    }

    
    public function updatePlazo(Request $request){

        $campana = Campana::find($request->id);
        $campana->plazo = $request->plazo;

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

            if($campana->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateLink(Request $request){
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
           return view('especiales.campana.planilla')->with('campana', $campana);
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