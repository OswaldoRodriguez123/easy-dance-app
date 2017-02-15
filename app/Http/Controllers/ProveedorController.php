<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Proveedor;
use Validator;
use Illuminate\Support\Facades\Auth;

class ProveedorController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    
    public function index()
    {

        return view('participante.proveedor.index')->with('proveedor', Proveedor::where('academia_id', '=' ,  Auth::user()->academia_id)->get());
    }

    public function principal()
    {
        return view('participante.proveedor.principal')->with('proveedor', Proveedor::where('academia_id', '=' ,  Auth::user()->academia_id)->get());
    }

    public function operar($id)
    {   
        $proveedor = Proveedor::find($id);
        return view('participante.proveedor.operacion')->with(['id' => $id, 'proveedor' => $proveedor]);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $config['center'] = '10.6913156,-71.6800493';
        $config['zoom'] = 14;
        \Gmaps::initialize($config);

        $marker = array();
        $marker['position'] = '10.6913156,-71.6800493';
        $marker['draggable'] = true;
        $marker['ondragend'] = 'addFieldText(event.latLng.lat(), event.latLng.lng());';
        \Gmaps::add_marker($marker);


        $map = \Gmaps::create_map();
 
        //Devolver vista con datos del mapa
        return view('participante.proveedor.create' , compact('map'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
       

        $request->merge(array('correo' => trim($request->correo)));
        

    $rules = [
        'nombre' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'apellido' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'sexo' => 'required',
        'celular' => 'required',
        'correo' => 'email',
    ];

    $messages = [

        'nombre.required' => 'Ups! El nombre es requerido',
        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre.max' => 'El máximo de caracteres permitidos son 20',
        'nombre.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
        'apellido.required' => 'Ups! El apellido es requerido',
        'apellido.min' => 'El mínimo de caracteres permitidos son 3',
        'apellido.max' => 'El máximo de caracteres permitidos son 20',
        'apellido.regex' => 'Ups! El apellido es inválido , debe ingresar sólo letras',
        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'celular.required' => 'Ups! El telefono móvil es requerido',
        'sexo.required' => 'Ups! El sexo es requerido',
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

        $proveedor = new Proveedor;

        $nombre = title_case($request->nombre);
        $apellido = title_case($request->apellido);
        $direccion = $request->direccion;

        $correo = strtolower($request->correo);

        $proveedor->academia_id = Auth::user()->academia_id;
        $proveedor->nombre = $nombre;
        $proveedor->apellido = $apellido;
        $proveedor->empresa = $request->empresa;
        $proveedor->correo = $correo;
        $proveedor->telefono = $request->telefono;
        $proveedor->celular = $request->celular;
        $proveedor->sexo = $request->sexo;
        $proveedor->direccion = $direccion;

        if($proveedor->save()){
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("/home");
        //return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
    }
    }

    public function updateNombre(Request $request){

    $rules = [
        'nombre' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'apellido' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
    ];

    $messages = [

        'nombre.required' => 'Ups! El Nombre  es requerido ',
        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre.max' => 'El máximo de caracteres permitidos son 20',
        'nombre.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
        'apellido.required' => 'Ups! El Apellido  es requerido ',
        'apellido.min' => 'El mínimo de caracteres permitidos son 3',
        'apellido.max' => 'El máximo de caracteres permitidos son 20',
        'apellido.regex' => 'Ups! El apellido es inválido , debe ingresar sólo letras',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        // return redirect("alumno/edit/{$request->id}")

        // ->withErrors($validator)
        // ->withInput();
        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }

        $nombre = title_case($request->nombre);
        $apellido = title_case($request->apellido);

        $proveedor = Proveedor::find($request->id);
        $proveedor->nombre = $nombre;
        $proveedor->apellido = $apellido;

        if($proveedor->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateCorreo(Request $request){

        $request->merge(array('correo' => trim($request->correo)));

    $rules = [
        'correo' => 'email|max:255'.$request->id.'',
    ];

    $messages = [

        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'correo.max' => 'El máximo de caracteres permitidos son 255',
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
        $proveedor = Proveedor::find($request->id);
        $correo = strtolower($request->correo);
        $proveedor->correo = $correo;

        if($proveedor->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function updateTelefono(Request $request){

        $proveedor = Proveedor::find($request->id);
        $proveedor->telefono = $request->telefono;

        if($proveedor->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateSexo(Request $request){
        $proveedor = Proveedor::find($request->id);
        $proveedor->sexo = $request->sexo;

        // return redirect("alumno/edit/{$request->id}");
        if($proveedor->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEmpresa(Request $request){
        $proveedor = Proveedor::find($request->id);
        $proveedor->empresa = $request->empresa;

        // return redirect("alumno/edit/{$request->id}");
        if($proveedor->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateDireccion(Request $request){
        $proveedor = Proveedor::find($request->id);

        $direccion = $request->direccion;

        $proveedor->direccion = $direccion;

        // return redirect("alumno/edit/{$request->id}");
        if($proveedor->save()){
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
        $proveedor = Proveedor::find($id);
        if($proveedor){
            $config['center'] = '10.6913156,-71.6800493';
            $config['zoom'] = 14;
            \Gmaps::initialize($config);

            $marker = array();
            $marker['position'] = '10.6913156,-71.6800493';
            $marker['draggable'] = true;
            $marker['ondragend'] = 'addFieldText(event.latLng.lat(), event.latLng.lng());';
            \Gmaps::add_marker($marker);

            $map = \Gmaps::create_map();
 
           return view('participante.proveedor.planilla' , compact('map'))->with('proveedor' , $proveedor);
        }else{
           return redirect("participante/proveedor"); 
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
        $proveedor = Proveedor::find($id);
        
        if($proveedor->delete()){
            return response()->json(['mensaje' => '¡Excelente! El campo se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno");
    }

}
