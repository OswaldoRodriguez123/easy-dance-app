<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Regalo;
use App\Academia;
use App\ItemsFacturaProforma;
use App\Alumno;
use Validator;
use DB;
use Mail;
use Carbon\Carbon;
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
        return view('especiales.regalo.create')->with('alumnos' , Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get());
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
        'costo' => 'required',
        'descripcion' => 'required|min:3|max:500',
        'dirigido_a' => 'required|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'alumno_id' => 'required',
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
        'alumno_id.required' => 'Ups! El campo “de parte de” es requerido',
        'dirigido_a.required' => 'Ups! El campo “dirigido a” es requerido',
        'dirigido_a.regex' => 'Ups! El campo “dirigido a” es inválido, debe contener sólo letras',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $regalo = new Regalo;

        $costo = str_replace(".", "", $request->costo);
        $correo = strtolower($request->correo);

        $regalo->academia_id = Auth::user()->academia_id;
        $regalo->nombre = $request->nombre;
        $regalo->descripcion = $request->descripcion;
        $regalo->costo = $costo;
        $regalo->dirigido_a = $request->dirigido_a;
        $regalo->de_parte_de = $request->alumno_id;
        $regalo->correo = $correo;

        if($regalo->save()){

            $academia = Academia::find(Auth::user()->academia_id);

            $subj = 'FELICIDADES, HAS RECIBIDO UNA TARJETA DE REGALO';

            $alumno = Alumno::find($request->alumno_id);

            $array = [

               'correo' => $request->correo,
               'academia' => $academia->nombre,
               'dirigido_a' => $request->dirigido_a,
               'de_parte_de' => $alumno->nombre . " " . $alumno->apellido,
               'subj' => $subj
            ];

            Mail::send('correo.regalo', $array, function($msj) use ($array){
                    $msj->subject($array['subj']);
                    $msj->to($array['correo']);
                });

            $item_factura = new ItemsFacturaProforma;
                    
                $item_factura->alumno_id = $request->alumno_id;
                $item_factura->academia_id = Auth::user()->academia_id;
                $item_factura->fecha = Carbon::now()->toDateString();
                $item_factura->item_id = $regalo->id;
                $item_factura->nombre = 'Regalo para ' . $regalo->dirigido_a;
                $item_factura->tipo = 10;
                $item_factura->cantidad = 1;
                $item_factura->precio_neto = 0;
                $item_factura->impuesto = 0;
                $item_factura->importe_neto = $regalo->costo;
                $item_factura->fecha_vencimiento = Carbon::now()->toDateString();
                    
                $item_factura->save();

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'id' => $request->alumno_id, 200]);
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