<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Transmision;
use Validator;
use DB;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;
use Image;

class TransmisionController extends BaseController {

	public function index()
    {
        return view('agendar.transmision.principal')->with('transmisiones', Transmision::where('academia_id', '=' ,  Auth::user()->academia_id)->get());
    }

	public function create()
    {
        return view('agendar.transmision.create')->with([]);
    }

    public function store(Request $request)
    {

	    $rules = [
	        'tema' => 'required',
	        'fecha' => 'required',
	        'hora' => 'required',
	        'presentador' => 'required',
	        'invitado' => 'required',
	        'color_etiqueta' => 'required',
	    ];

	    $messages = [

	        'tema.required' => 'Ups! El tema es requerido ',
	        'fecha.required' => 'Ups! La fecha es requerida',
	        'hora.required' => 'Ups! La hora es requerida',
	        'presentador.required' => 'Ups! El presentador es requerido',
	        'invitado.required' => 'Ups! El invitado es requerido',
	        'color_etiqueta.required' => 'Ups! El color de la etiqueta es requerido',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

	    else{

	        $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha); 

	        if($fecha < Carbon::now()){

	            return response()->json(['errores' => ['fecha' => [0, 'Ups! ha ocurrido un error. La fecha de la transmisión no puede ser menor al dia de hoy']], 'status' => 'ERROR'],422);
	        }

	        $fecha = $fecha->toDateString();
	        // $hora = strtotime($request->hora);

	        $transmision = new Transmision;

	        $transmision->academia_id = Auth::user()->academia_id;
	        $transmision->tema = $request->tema;
	        $transmision->fecha = $fecha;
	        $transmision->hora = $request->hora;
	        $transmision->color_etiqueta = $request->color_etiqueta;
	        $transmision->presentador = $request->presentador;
	        $transmision->invitado = $request->invitado;
	        $transmision->desarrollo = $request->desarrollo;

	        if($transmision->save()){
	            
	            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
	    }
    }

    public function edit($id)
    {
        $transmision = Transmision::find($id);

        if($transmision){
           return view('agendar.transmision.planilla')->with('transmision' , $transmision);
        }else{
           return redirect("agendar/transmisiones"); 
        }
    }

    public function updateTema(Request $request){

	    $rules = [
	        'tema' => 'required',
	    ];

	    $messages = [

	        'tema.required' => 'Ups! El tema es requerido',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

	    else{

	        $transmision = Transmision::find($request->id);

	        $transmision->tema = $request->tema;

	        if($transmision->save()){
	            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
	    }
    }

    public function updatePresentador(Request $request){

	    $rules = [
	        'presentador' => 'required',
	    ];

	    $messages = [

	        'presentador.required' => 'Ups! El presentador es requerido',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

	    else{

	        $transmision = Transmision::find($request->id);

	        $transmision->presentador = $request->presentador;

	        if($transmision->save()){
	            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
	    }
    }

    public function updateInvitado(Request $request){

	    $rules = [
	        'invitado' => 'required',
	    ];

	    $messages = [

	        'invitado.required' => 'Ups! El tema es requerido',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

	    else{

	        $transmision = Transmision::find($request->id);

	        $transmision->invitado = $request->invitado;

	        if($transmision->save()){
	            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
	    }
    }

    public function updateHora(Request $request){

	    $rules = [
	        'hora' => 'required',
	    ];

	    $messages = [

	        'hora.required' => 'Ups! La hora es requerida',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

	    else{

	        $transmision = Transmision::find($request->id);

	        $transmision->hora = $request->hora;

	        if($transmision->save()){
	            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
	    }
    }

    public function updateFecha(Request $request){

	    $rules = [
	        'fecha' => 'required',
	    ];

	    $messages = [

	        'fecha.required' => 'Ups! La fecha es requerida',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

	    else{

	    	$fecha = Carbon::createFromFormat('d/m/Y', $request->fecha); 

	        if($fecha < Carbon::now()){

	            return response()->json(['errores' => ['fecha' => [0, 'Ups! ha ocurrido un error. La fecha de la transmisión no puede ser menor al dia de hoy']], 'status' => 'ERROR'],422);
	        }

	        $fecha = $fecha->toDateString();

	        $transmision = Transmision::find($request->id);

	        $transmision->fecha = $fecha;

	        if($transmision->save()){
	            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
	    }
    }

    public function updateEtiqueta(Request $request){

	    $rules = [
	        'color_etiqueta' => 'required',
	    ];

	    $messages = [

	        'color_etiqueta.required' => 'Ups! La etiqueta es requerida',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

	    else{

	        $transmision = Transmision::find($request->id);

	        $transmision->color_etiqueta = $request->color_etiqueta;

	        if($transmision->save()){
	            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
	        }
	    }
    }

    public function updateDesarrollo(Request $request){

        $transmision = Transmision::find($request->id);

        $transmision->desarrollo = $request->desarrollo;

        if($transmision->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
	    
    }

    public function destroy($id)
    {
        
        $transmision = Transmision::find($id);
        
        if($transmision->delete()){
            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }


}