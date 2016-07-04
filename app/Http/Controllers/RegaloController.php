<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Regalo;
use App\Academia;
use Validator;
use DB;
use Mail;
use Illuminate\Support\Facades\Auth;

class RegaloController extends Controller {

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

        return view('especiales.regalo.index')->with('regalo', Regalo::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */

    public function create()
    {
        return view('especiales.regalo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $request->merge(array('correo' => trim($request->correo)));


    $rules = [
        'nombre' => 'required|min:3|max:50',
        'costo' => 'required|numeric',
        'descripcion' => 'required|min:3|max:500',
        'dirigido_a' => 'required|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'de_parte_de' => 'required|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'correo' => 'required|email',
    ];

    $messages = [

        'nombre.required' => 'Ups! El Nombre es requerido ',
        'correo.required' => 'Ups! El Correo es requerido ',
        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre.max' => 'El máximo de caracteres permitidos son 50',
        'descripcion.required' => 'Ups! La Descripcion es requerida',
        'descripcion.min' => 'El mínimo de caracteres permitidos son 3',
        'descripcion.max' => 'El máximo de caracteres permitidos son 500',
        'costo.required' => 'Ups! El Costo es requerido',
        'costo.numeric' => 'Ups! El Costo es inválido , debe contener sólo números',
        'de_parte_de.required' => 'Ups! El campo “de parte de” es requerido',
        'dirigido_a.required' => 'Ups! El campo “dirigido a” es requerido',
        'dirigido_a.regex' => 'Ups! El campo “dirigido a” es inválido, debe contener sólo letras',
        'de_parte_de.regex' => 'Ups! El campo “de parte de” es inválido, debe contener sólo letras',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $regalo = new Regalo;

        $regalo->academia_id = Auth::user()->academia_id;
        $regalo->nombre = $request->nombre;
        $regalo->descripcion = $request->descripcion;
        $regalo->costo = $request->costo;
        $regalo->dirigido_a = $request->dirigido_a;
        $regalo->de_parte_de = $request->de_parte_de;
        $regalo->correo = $request->correo;

        if($regalo->save()){

            $academia = Academia::find(Auth::user()->academia_id);

            $subj = 'FELICIDADES, HAS RECIBIDO UNA TARJETA DE REGALO';

            $array = [

               'correo' => $request->correo,
               'academia' => $academia->nombre,
               'dirigido_a' => $request->dirigido_a,
               'de_parte_de' => $request->de_parte_de,
               'subj' => $subj
            ];

            Mail::send('correo.regalo', $array, function($msj) use ($array){
                    $msj->subject($array['subj']);
                    $msj->to($array['correo']);
                });

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
        $regalo = Regalo::find($id);
        $regalo->delete();
        return view('especiales.regalo.index');
    }

}