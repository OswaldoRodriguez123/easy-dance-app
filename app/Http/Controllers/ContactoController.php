<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use Mail;

class ContactoController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        return view('contacto.index');
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
    public function send(Request $request)
    {
        //dd($request->all());


    $rules = [
        'nombre' => 'required|min:3|max:16|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'correo' => 'email|max:255',
        'telefono' => 'digits:11',
        'mensaje' => 'required|min:3|max:500',

    ];

    $messages = [

        'nombre.required' => 'Ups! El Nombre  es requerido ',
        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre.max' => 'El máximo de caracteres permitidos son 16',
        'nombre.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
        'telefono.digits' => 'El telefono debe poseer 11 digitos',
        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'correo.max' => 'El máximo de caracteres permitidos son 255',
        'mensaje.required' => 'Ups! El Mensaje  es requerido ',
        'mensaje.min' => 'El mínimo de caracteres permitidos son 3',
        'mensaje.max' => 'El máximo de caracteres permitidos son 500',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
    }

            Mail::send('contacto.index', $request->all(), function($msj) use ($request){
                $msj->subject('Contacto Easy Dance');
                $msj->to('latinoeasydance@gmail.com');

                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
            });
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
        $visitante = Visitante::find($id);
        return view('visitante.editar')->with('visitante', $visitante);
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
        $visitante = Visitante::find($id);
        $visitante->delete();
        return view('visitante.index');
    }

}