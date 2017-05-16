<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Promocion;
use App\Alumno;
use App\ConfigServicios;
use App\CodigoPromocion;
use App\Codigo;
use Validator;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PromocionController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function principal()
    {
        $promociones = Promocion::where('academia_id', '=' ,  Auth::user()->academia_id)->get();
        $array = array();
        
        foreach($promociones as $promocion){
            $fecha = Carbon::createFromFormat('Y-m-d',$promocion->fecha_final);
            if($fecha >= Carbon::now()){

                $dias_restantes = $fecha->diffInDays();

                $status = 'Activa';

            }else{
                $dias_restantes = 0;
                $status = 'Vencida';
            }

            $collection=collect($promocion);     
            $promocion_array = $collection->toArray();
            $promocion_array['status']=$status;
            $promocion_array['dias_restantes']=$dias_restantes;
            $array[$promocion->id] = $promocion_array;
        }

        return view('especiales.promocion.principal')->with(['promociones' => $array]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('especiales.promocion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {


    $rules = [
        'nombre' => 'required|min:3|max:80',
        'numero' => 'required',
        'porcentaje_descuento' => 'required|numeric|max:100',
        'fecha' => 'required',
        'descripcion' => 'min:3|max:500',
        'edad_inicio' => 'numeric',
        'edad_final' => 'numeric',

    ];

    $messages = [

        'nombre.required' => 'Ups! El Nombre es requerido ',
        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre.max' => 'El máximo de caracteres permitidos son 80',
        'numero.required' => 'Ups! El Numero de veces de canjeos permitidos por esta promocion es requerido ',
        'descripcion.min' => 'El mínimo de caracteres permitidos son 3',
        'descripcion.max' => 'El máximo de caracteres permitidos son 500',
        'porcentaje_descuento.required' => 'Ups! El porcentaje de descuento es requerido',
        'porcentaje_descuento.numeric' => 'Ups! El porcentaje de descuento es inválido , debe contener sólo números',
        'porcentaje_descuento.max' => 'Ups! El porcentaje de descuento no puede ser mayor a 100',
        'fecha.required' => 'Ups! La fecha de promoción  es requerida',
        'edad_inicio.numeric' => 'Ups! La edad es inválida , debe contener sólo números',
        'edad_final.numeric' => 'Ups! La edad es inválida , debe contener sólo números',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
    }

    else{

        // if( $request->fecha_inicio > $request->fecha_final)
        // {
        //     return response()->json(['errores' => ['fecha_inicio' => [0, 'Ups! Fecha inválida, la fecha de inicio no debe ser mayor a la fecha final']],  'status' => 'ERROR'],422);
        // }

        // if( $request->edad_inicio > $request->edad_final)
        // {
        //      return response()->json(['errores' => ['edad_inicio' => [0, 'Ups! Edad inválida, la edad de inicio no debe ser mayor a la edad final']],  'status' => 'ERROR'],422);
        // }

        do{
            $codigo_validacion = str_random(8);
            $find = Codigo::where('codigo_validacion', $codigo_validacion)->first();
        }while ($find);

        $fecha = explode(" - ", $request->fecha);

        $fecha_inicio = Carbon::createFromFormat('d/m/Y', $fecha[0]);
        $fechatmp = Carbon::createFromFormat('d/m/Y', $fecha[0]);
        $fecha_final = Carbon::createFromFormat('d/m/Y', $fecha[1]);

        $promocion = new Promocion;

        $nombre = title_case($request->nombre);

        $promocion->academia_id = Auth::user()->academia_id;
        $promocion->nombre = $nombre;
        $promocion->descripcion = $request->descripcion;
        $promocion->porcentaje_descuento = $request->porcentaje_descuento;
        $promocion->fecha_inicio = $fecha_inicio;
        $promocion->fecha_final = $fecha_final;
        $promocion->sexo = $request->sexo;
        $promocion->edad_inicio = $request->edad_inicio;
        $promocion->edad_final = $request->edad_final;
        $promocion->condiciones = $request->condiciones;

        if($promocion->save()){

            $codigo = New Codigo;

            $codigo->academia_id = $promocion->academia_id;
            $codigo->item_id = $promocion->id;
            $codigo->tipo = 2;
            $codigo->codigo_validacion = $codigo_validacion;
            $codigo->estatus = 0;
            $codigo->fecha_vencimiento = Carbon::now()->addMonth()->toDateString();
            $codigo->numero_canjeos = $request->numero;

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

                $nombre_img = "promocion-". $promocion->id . $extension;
                $image = base64_decode($base64_string);

                \Storage::disk('promocion')->put($nombre_img,  $image);

                $promocion->imagen = $nombre_img;
                $promocion->save();

            }
            
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function updateNombre(Request $request){

        $promocion = Promocion::find($request->id);

        $nombre = title_case($request->nombre);

        $promocion->nombre = $nombre;

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

            if($promocion->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
            // return redirect("alumno/edit/{$request->id}");
        }
    }

    public function updateDescripcion(Request $request){

        $promocion = Promocion::find($request->id);
        $promocion->descripcion = $request->descripcion;

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

        else{

            if($promocion->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
            // return redirect("alumno/edit/{$request->id}");
        }
    }

    public function updatePorcentaje(Request $request){

    $rules = [

        'porcentaje_descuento' => 'required|numeric',
    ];

    $messages = [

        'porcentaje_descuento.required' => 'Ups! El porcentaje de descuento es requerido',
        'porcentaje_descuento.numeric' => 'Ups! El porcentaje de descuento es inválido , debe contener sólo números',

    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $promocion = Promocion::find($request->id);
        $promocion->porcentaje_descuento = $request->porcentaje_descuento;

        if($promocion->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateFecha(Request $request){

        $promocion = Promocion::find($request->id);

        $fecha_inicio = Carbon::createFromFormat('d/m/Y', $request->fecha_inicio)->toDateString();
        $fecha_final = Carbon::createFromFormat('d/m/Y', $request->fecha_final)->toDateString();

        $promocion->fecha_inicio = $fecha_inicio;
        $promocion->fecha_final = $fecha_final;

        if($promocion->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateSexo(Request $request){
        $promocion = Promocion::find($request->id);
        $promocion->sexo = $request->sexo;

        // return redirect("alumno/edit/{$request->id}");
        if($promocion->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function GenerarCodigo(Request $request)
    {
        //dd($request->all());


    $rules = [
        'promocion_id' => 'required',
        'alumno_id' => 'required',

    ];

    $messages = [

        'promocion_id.required' => 'Ups! La Promocion es requerido ',
        'alumno_id.required' => 'Ups! El Alumno es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $existe = true;

        while($existe) {

            $codigo = str_random(8);

            $check = DB::table('codigos_promocion')
                ->select('codigos_promocion.*')
                ->where('codigos_promocion.codigo', '=', $codigo)
                ->first();
        
            if(!$check){
                $existe = false;
            }
        
        }
  
        $fecha_vencimiento = Carbon::now()->addMonths(1);
        
        $promocion = new CodigoPromocion;
        $promocion->promocion_id = $request->promocion_id;
        $promocion->alumno_id = $request->alumno_id;
        $promocion->fecha_vencimiento = $fecha_vencimiento;
        $promocion->codigo = $codigo;

        if($promocion->save()){
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
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

    public function operar($id)
    {   
        $promocion = Promocion::find($id);
        return view('especiales.promocion.operacion')->with(['id' => $id, 'promocion' => $promocion]);         
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $promocion = Promocion::find($id);
        return view('especiales.promocion.planilla')->with('promocion', $promocion);
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
        $promocion = Promocion::find($id);
        
        if($promocion->delete()){
            return response()->json(['mensaje' => '¡Excelente! La Promoción se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

}