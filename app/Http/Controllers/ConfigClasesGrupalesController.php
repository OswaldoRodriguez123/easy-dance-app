<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\ConfigClasesGrupales;
use App\Academia;
use Validator;
use Session;
use Illuminate\Support\Facades\Auth;

class ConfigClasesGrupalesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

    public function __construct()
    {
        $this->middleware('auth');
    }

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
        'costo_inscripcion' => 'required|numeric',
        'costo_mensualidad' => 'required|numeric',
        'descripcion' => 'required',
        'porcentaje_retraso' => 'numeric',
        'tiempo_tolerancia' => 'numeric',

    ];

    $messages = [

        'nombre.required' => 'Ups! El Nombre  es requerido',
        'costo_inscripcion.required' => 'Ups! El costo de la inscripción es requerido',
        'costo_mensualidad.required' => 'Ups! El costo de la mensualidad es requerida',
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

        $clasegrupal = new ConfigClasesGrupales;
        
        $clasegrupal->academia_id = Auth::user()->academia_id;
        $clasegrupal->nombre = $nombre;
        $clasegrupal->costo_inscripcion = $request->costo_inscripcion;
        $clasegrupal->costo_mensualidad = $request->costo_mensualidad;
        $clasegrupal->descripcion = $request->descripcion;
        $clasegrupal->condiciones = $request->condiciones;
        $clasegrupal->incluye_iva = $request->incluye_iva;
        $clasegrupal->porcentaje_retraso = $request->porcentaje_retraso;
        $clasegrupal->tiempo_tolerancia = $request->tiempo_tolerancia;

        if($clasegrupal->save()){
            
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
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateCostoInscripcion(Request $request){

    $rules = [

        'costo_inscripcion' => 'required|numeric',

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
        $clasegrupal->costo_inscripcion = $request->costo_inscripcion;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        // return redirect("alumno/edit/{$request->id}");
        }
    }

    public function updateCostoMensualidad(Request $request){

    $rules = [

        'costo_mensualidad' => 'required|numeric',

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
        $clasegrupal->costo_mensualidad = $request->costo_mensualidad;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateDescripcion(Request $request){

        $clasegrupal = ConfigClasesGrupales::find($request->id);
        $clasegrupal->descripcion = $request->descripcion;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateImpuesto(Request $request){

        $clasegrupal = ConfigClasesGrupales::find($request->id);
        $clasegrupal->incluye_iva = $request->incluye_iva;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
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