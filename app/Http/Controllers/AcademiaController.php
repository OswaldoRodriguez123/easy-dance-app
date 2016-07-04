<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Academia;
use App\Paises;
use Validator;
use Carbon\Carbon;
use Storage;

class AcademiaController extends Controller {

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

		return view('academia.editar')->with('academia', Academia::all());                      
	}

	public function plantilla()
	{
		return view('alumno.plantilla');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */

    public function PrimerPaso(Request $request)
    {
        //dd($request->all());


    $rules = [
        'nombre' => 'required|min:3|max:30',
        'especialidades_id' => 'required',
        'pais_id' => 'required',
        'estado' => 'required|min:3|max:30',
    ];

    $messages = [

        'nombre.required' => 'Ups! El campo Nombre es requerido',
        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre.max' => 'El maximo de caracteres permitidos son 20',
        'especialidades_id.required' => 'Ups! La Especialidad es requerida',
        'pais_id.required' => 'Ups! El Pais es requerido',
        'estado.required' => 'Ups! El Estado es requerido',
        'estado.min' => 'El mínimo de caracteres permitidos son 3',
        'estado.max' => 'El máximo de caracteres permitidos son 300',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $academia = new Academia;

        $pais = Paises::find($request->pais_id);

        $academia->usuario_id = $request->usuario_id;
        $academia->nombre = $request->nombre;
        $academia->especialidades_id = $request->especialidades_id;
        $academia->pais_id = $request->pais_id;
        $academia->estado = $request->estado;
        $academia->moneda = $pais->moneda;

        if($academia->save()){
            // return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
            return view('academia.segundopaso')->with('academia', $academia);

        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("/home");
        //return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
    }
    }

	public function SegundoPaso(Request $request)
	{
		//dd($request->all());

    $rules = [
    	'identificacion' => 'required|min:8|max:20|unique:academias,identificacion',
        'imagen' => 'required',
        'descripcion' => 'required|min:3|max:300',
    ];

    $messages = [

        'identificacion.required' => 'Ups! El campo RIF es requerido',
        'identificacion.min' => 'El mínimo de caracteres permitidos son 8',
        'identificacion.max' => 'El maximo de caracteres permitidos son 20',
        'identificacion.unique' => 'Ups! Ya el campo RIF esta registrado, intente con otra identidad fiscal.',
        'imagen.required' => 'Ups! La imagen es requerida',
        'descripcion.required' => 'Ups! La Descripcion es requerida',
        'descripcion.min' => 'El mínimo de caracteres permitidos son 3',
        'descripcion.max' => 'El máximo de caracteres permitidos son 300',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        // return redirect("/home")

        // ->withErrors($validator)
        // ->withInput();

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }

    else{

        $academia = Academia::find($request->academia_id);

		$academia->identificacion = $request->identificacion;
		$academia->imagen = $request->imagen;
		$academia->descripcion = $request->descripcion;

		if($academia->save()){
            // return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
            return view('academia.contacto')->with('academia', $academia);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
		// return redirect("/home");
		//return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
	}
	}

	public function updateContacto(Request $request){

    $rules = [
        'correo' => 'email|max:255',
        'telefono' => 'digits:11',
        'celular' => 'digits:11',
    ];

    $messages = [

        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'correo.max' => 'El máximo de caracteres permitidos son 255',
        'correo.unique' => 'Ups! Ya este correo ha sido registrado',
        'telefono.digits' => 'El telefono local debe poseer 11 digitos',
        'celular.digits' => 'El telefono local debe poseer 11 digitos',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        // return redirect("alumno/edit/{$request->id}")

        // ->withErrors($validator)
        // ->withInput();
        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }

    else{

		$academia = Academia::find($request->academia_id);

        $academia->correo = $request->correo;
        $academia->telefono = $request->telefono;
        $academia->celular = $request->celular;
        $academia->geolocalizacion = $request->geolocalizacion;
        $academia->facebook = $request->facebook;
        $academia->twitter = $request->twitter;
        $academia->linkedin = $request->linkedin;
        $academia->instagram = $request->instagram;
        $academia->pagina_web = $request->pagina_web;
        $academia->youtube = $request->youtube;
		
        if($academia->save()){
            // return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            return view('academia.especiales')->with('academia', $academia);

        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
		// return redirect("alumno/edit/{$request->id}");
		}
	}

	public function updateEspeciales(Request $request){

        $academia = Academia::find($request->academia_id);
        $id = $request->academia_id;

		$normativa = $request->normativa;
		$manual = $request->manual;
        $programacion = $request->programacion;

        $nombre_normativa = $academia->nombre." - ".$id.".pdf";
        $nombre_manual = $academia->nombre." - ".$id.".pdf";
        $nombre_programacion = $academia->nombre." - ".$id.".pdf";

        if (!empty($normativa)) {
            $r_normativa = Storage::disk('normativas')->put($nombre_normativa,  \File::get($normativa));
            if($r_normativa){
                $academia->normativa = "normativas/".$nombre_normativa;
            }
        }
        if (!empty($manual)) {
             $r_manual = Storage::disk('manuales')->put($nombre_manual,  \File::get($manual));
            if($r_manual){
                $academia->manual = "manuales/".$nombre_manual;
            }
        }
        
        if (!empty($programacion)) {
            $r_programacion = Storage::disk('programaciones')->put($nombre_programacion,  \File::get($programacion));
            if($r_programacion){
                $academia->programacion = "programaciones/".$nombre_programacion;
            }
        }
        
       if($academia->save()){
            // return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            return view('academia.administrativo')->with('academia', $academia);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

	}

    public function updateAdministrativo(Request $request){

    $rules = [
        'porcentaje_impuesto' => 'required|numeric',
        'numero_factura' => 'required|numeric',

    ];

    $messages = [
        
        'porcentaje_impuesto.required' => 'Ups! Debes ingresar el campo de Porcentaje de impuesto',
        'porcentaje_impuesto.numeric' => 'Ups! El campo de Porcentaje de impuesto  en inválido , debe contener sólo números',
        'numero_factura.required' => 'Ups! Debes ingresar el campo de Próximo número de factura',
        'numero_factura.numeric' => 'Ups! El campo de “ Próximo número de factura” es inválido, debe contener sólo  números',

    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        // return redirect("alumno/edit/{$request->id}")

        // ->withErrors($validator)
        // ->withInput();
        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }

    else{

        $academia = Academia::find($request->academia_id);

        $academia->porcentaje_impuesto = $request->porcentaje_impuesto;
        $academia->numero_factura = $request->numero_factura;

        
        if($academia->save()){
            // return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            return view('alumno.index')->with('academia', $academia);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
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
		$alumno = Alumno::find($id);
		return view('alumno.editar')->with('alumno', $alumno);
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
		$alumno = Alumno::find($id);
		
        if($alumno->delete()){
            return response()->json(['mensaje' => '¡Excelente! El campo se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
		// return redirect("alumno");
	}

}
