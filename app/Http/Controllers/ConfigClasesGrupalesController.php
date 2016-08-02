<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\ConfigClasesGrupales;
use App\ConfigServicios;
use App\Academia;
use Validator;
use Session;
use Illuminate\Support\Facades\Auth;

class ConfigClasesGrupalesController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

    public function principalclases()
    {   
        
        return view('configuracion.clases_grupales.principal')->with('clases_grupales', ConfigClasesGrupales::where('academia_id', '=' ,  Auth::user()->academia_id)->get());
    }

    public function agregarclases()
    {   
        $academia = Academia::find(Auth::user()->academia_id);
        
        return view('configuracion.clases_grupales.create')->with('incluye_iva', $academia->incluye_iva);
    }

    public function store(Request $request)
    {
        //dd($request->all());


    $rules = [

        'nombre' => 'required',
        'costo_inscripcion' => 'numeric',
        'costo_mensualidad' => 'numeric',
        'descripcion' => 'required',
        'porcentaje_retraso' => 'numeric',
        'tiempo_tolerancia' => 'numeric',

    ];

    $messages = [

        'nombre.required' => 'Ups! El Nombre  es requerido',
        'costo_inscripcion.numeric' => 'Ups! El campo del costo de la inscripcion es inválido , debe contener sólo números',
        'costo_mensualidad.numeric' => 'Ups! El campo del costo de la mensualidad es inválido , debe contener sólo números',
        'descripcion.required' => 'Ups! La descripción es requerida',  
        'porcentaje_retraso.numeric' => 'Ups! El campo de porcentaje de retraso es inválido , debe contener sólo números',
        'tiempo_tolerancia.numeric' => 'Ups! El campo de tiempo de tolerancia es inválido , debe contener sólo números',      
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->nombre))));
        $costo_inscripcion = trim($request->costo_inscripcion);
        $costo_mensualidad =  trim($request->costo_mensualidad);

        if($costo_inscripcion == ''){
            $costo_inscripcion = 0;
        }

        if($costo_mensualidad == ''){
            $costo_mensualidad = 0;
        }

        $clasegrupal = new ConfigClasesGrupales;
        
        $clasegrupal->academia_id = Auth::user()->academia_id;
        $clasegrupal->nombre = $nombre;
        $clasegrupal->costo_inscripcion = $costo_inscripcion;
        $clasegrupal->costo_mensualidad = $costo_mensualidad;
        $clasegrupal->descripcion = $request->descripcion;
        $clasegrupal->condiciones = $request->condiciones;
        $clasegrupal->incluye_iva = $request->incluye_iva;
        $clasegrupal->porcentaje_retraso = $request->porcentaje_retraso;
        $clasegrupal->tiempo_tolerancia = $request->tiempo_tolerancia;

        if($clasegrupal->save()){

            $servicio = new ConfigServicios;
            
            $servicio->academia_id = Auth::user()->academia_id;
            $servicio->nombre = 'Inscripción ' . $nombre;
            $servicio->costo = $costo_inscripcion;
            $servicio->imagen = '';
            $servicio->descripcion = $request->descripcion;
            $servicio->incluye_iva = $request->incluye_iva;

            $servicio->save();

            $servicio = new ConfigServicios;
            
            $servicio->academia_id = Auth::user()->academia_id;
            $servicio->nombre = 'Mensualidad ' . $nombre;
            $servicio->costo = $costo_mensualidad;
            $servicio->imagen = '';
            $servicio->descripcion = $request->descripcion;
            $servicio->incluye_iva = $request->incluye_iva;

            $servicio->save();
            
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    	}
	}

    public function edit($id)
    {   
        $clasegrupal = ConfigClasesGrupales::find($id);

        if($clasegrupal){
            
            return view('configuracion.clases_grupales.planilla')->with(['clasegrupal' => $clasegrupal , 'id' => $id]);
        }else{
           return redirect("configuracion/clases-grupales"); 
        }
    }

    public function updateNombre(Request $request){

        $clasegrupal = ConfigClasesGrupales::find($request->id);

        $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->nombre))));

        $clasegrupal->nombre = $nombre;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'nombre' => 'nombre', 'valor' => $nombre, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateCostoInscripcion(Request $request){

    $rules = [

        'costo_inscripcion' => 'numeric',

    ];

    $messages = [

        'costo_inscripcion.required' => 'Ups! El costo de la inscripción es requerido',
        'costo_inscripcion.numeric' => 'Ups! El campo del costo de la inscripcion en inválido , debe contener sólo números',

    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $clasegrupal = ConfigClasesGrupales::find($request->id);

        $costo_inscripcion = $request->costo_inscripcion;

        if(trim($costo_inscripcion) == ''){
            $costo_inscripcion = 0;
        }
        
        $clasegrupal->costo_inscripcion = $costo_inscripcion;
        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'nombre' => 'costo_inscripcion', 'valor' => $costo_inscripcion, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        // return redirect("alumno/edit/{$request->id}");
        }
    }

    public function updateCostoMensualidad(Request $request){

    $rules = [

        'costo_mensualidad' => 'numeric',

    ];

    $messages = [

        'costo_mensualidad.required' => 'Ups! El costo de la mensualidad es requerida',
        'costo_mensualidad.numeric' => 'Ups! El campo del costo de la mensualidad en inválido , debe contener sólo números',        
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $clasegrupal = ConfigClasesGrupales::find($request->id);

        $costo_mensualidad = $request->costo_mensualidad;

        if(trim($costo_mensualidad) == ''){
            $costo_mensualidad = 0;
        }
        $clasegrupal->costo_mensualidad = $costo_mensualidad;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'nombre' => 'costo_mensualidad', 'valor' => $costo_mensualidad, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateDescripcion(Request $request){

        $clasegrupal = ConfigClasesGrupales::find($request->id);

        // $descripcion = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->descripcion))));

        $descripcion = $request->descripcion;

        $clasegrupal->descripcion = $descripcion;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'nombre' => 'descripcion', 'valor' => $descripcion, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateImpuesto(Request $request){

        $clasegrupal = ConfigClasesGrupales::find($request->id);
        $clasegrupal->incluye_iva = $request->incluye_iva;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'nombre' => 'incluye_iva', 'valor' => $request->incluye_iva, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateCondiciones(Request $request){
        $clasegrupal = ConfigClasesGrupales::find($request->id);
        $clasegrupal->condiciones = $request->condiciones;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function destroy($id)
    {

        $clasegrupal = ConfigClasesGrupales::find($id);
        
        if($clasegrupal->delete()){
            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno");
    }
}