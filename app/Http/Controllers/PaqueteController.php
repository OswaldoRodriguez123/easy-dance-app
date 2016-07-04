<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Paquete;
use App\CaracteristicasPaquete;
use Validator;
use DB;

class PaqueteController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // $paquete_join = DB::table('paquetes')
        //     ->join('caracteristicas_paquete', 'paquetes.id', '=', 'caracteristicas_paquete.paquete_id')
        //     ->select('caracteristicas_paquete.*', 'paquetes.*')
        //     ->get();

        // return view('paquete.index')->with(['paquete_join' => $paquete_join]);
        
        return view('paquete.index')->with('paquete', Paquete::all());
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
    public function store(Request $request)
    {
        //dd($request->all());


    $rules = [
        'nombre' => 'required|min:3|max:50|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'descripcion' => 'required|min:3|max:500',
        'costo' => 'required|numeric',
        'etiqueta' => 'required',
    ];

    $messages = [

        'nombre.required' => 'Ups! El Nombre es requerido ',
        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre.max' => 'El máximo de caracteres permitidos son 50',
        'nombre.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
        'descripcion.required' => 'Ups! La Descripcion es requerida',
        'descripcion.min' => 'El mínimo de caracteres permitidos son 3',
        'descripcion.max' => 'El máximo de caracteres permitidos son 500',
        'costo.required' => 'Ups! El Costo es requerido',
        'costo.numeric' => 'Ups! El Costo es inválido , debe contener sólo números',
        'etiqueta.required' => 'Ups! El color de la etiqueta es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $paquete = new Paquete;

        $paquete->nombre = $request->nombre;
        $paquete->descripcion = $request->descripcion;
        $paquete->costo = $request->costo;
        $paquete->etiqueta = $request->etiqueta;
        $paquete->cantidad_clases_grupales = $request->cantidad_clases_grupales;
        $paquete->cantidad_clases_personalizadas = $request->cantidad_clases_personalizadas;
        $paquete->cantidad_fiestas = $request->cantidad_fiestas;
        $paquete->cantidad_talleres = $request->cantidad_talleres;

        if($paquete->save()){
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function updateNombre(Request $request){

        $paquete = Paquete::find($request->id);
        $paquete->nombre = $request->nombre;

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

            if($paquete->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
            // return redirect("alumno/edit/{$request->id}");
        }
    }

    public function updateDescripcion(Request $request){

        $paquete = Paquete::find($request->id);
        $paquete->descripcion = $request->descripcion;

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

            if($paquete->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
            // return redirect("alumno/edit/{$request->id}");
        }
    }

    public function updateCosto(Request $request){

        $paquete = Paquete::find($request->id);
        $paquete->costo = $request->costo;

        if($paquete->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }


    public function updateEtiqueta(Request $request){
        $paquete = Paquete::find($request->id);
        $paquete->etiqueta = $request->etiqueta;

        if($paquete->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateCantidad(Request $request){

        $paquete = Paquete::find($request->id);

        $paquete->cantidad_clases_grupales = $request->cantidad_clases_grupales;
        $paquete->cantidad_clases_personalizadas = $request->cantidad_clases_personalizadas;
        $paquete->cantidad_fiestas = $request->cantidad_fiestas;
        $paquete->cantidad_talleres = $request->cantidad_talleres;

        if($paquete->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
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
        $instructor = Instructor::find($id);
        return view('instructor.editar')->with('instructor', $instructor);
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
        $paquete = Paquete::find($id);
        $paquete->delete();
        return view('paquete.index');
    }

}