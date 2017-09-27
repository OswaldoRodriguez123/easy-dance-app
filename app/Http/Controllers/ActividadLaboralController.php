<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\ActividadLaboral;
use Validator;
use Carbon\Carbon;
use Storage;
use Session;
use Illuminate\Support\Facades\Auth;
use DB;
use Image;
use File;
use Illuminate\Support\Facades\Input;

class ActividadLaboralController extends BaseController {

	public function index(){

        $actividades = ActividadLaboral::where('academia_id' , Auth::user()->academia_id)->get();

        return view('configuracion.herramientas.actividades_laborales.principal')->with(['actividades' => $actividades]);
    }

    public function store(Request $request){
        
    $rules = [

        'nombre_actividad' => 'required',
        'descripcion_actividad' => 'required',
        'color_etiqueta' => 'required',
    ];

    $messages = [

        'nombre_actividad.required' => 'Ups! El Nombre es requerido',
        'descripcion_actividad.required' => 'Ups! La Descripción es requerida',
        'color_etiqueta.required' => 'Ups! El color de la etiqueta es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $nombre = title_case($request->nombre_actividad);
        
        $actividad = new ActividadLaboral;
                                        
        $actividad->academia_id = Auth::user()->academia_id;
        $actividad->nombre = $nombre;
        $actividad->descripcion = $request->descripcion_actividad;
        $actividad->color_etiqueta = $request->color_etiqueta;

        $actividad->save();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $actividad, 'id' => $actividad->id, 200]);

        }
    }

    public function edit($id)
    {   
        $actividad = ActividadLaboral::find($id);

        if($actividad){
            
            return view('configuracion.herramientas.actividades_laborales.planilla')->with(['actividad' => $actividad , 'id' => $id]);
        }else{
           return redirect("configuracion/herramientas/actividades-laborales"); 
        }
    }

    public function updateNombre(Request $request){

        $actividad = ActividadLaboral::find($request->id);

        $nombre = title_case($request->nombre);

        $actividad->nombre = $nombre;

        if($actividad->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'nombre' => 'nombre', 'valor' => $nombre, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateDescripcion(Request $request){

        $actividad = ActividadLaboral::find($request->id);

        $descripcion = $request->descripcion;

        $actividad->descripcion = $descripcion;

        if($actividad->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'nombre' => 'descripcion', 'valor' => $descripcion, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEtiqueta(Request $request){

        if($request->color_etiqueta == "#"){
            return response()->json(['errores' => ['color_etiqueta' => [0, 'Ups! El color de la etiqueta es requerido']], 'status' => 'ERROR'],422);
        }
        
        $actividad = ActividadLaboral::find($request->id);
        $actividad->color_etiqueta = $request->color_etiqueta;

        if($actividad->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function destroy($id){

        $actividad = ActividadLaboral::find($id);

        $actividad->delete();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }
}