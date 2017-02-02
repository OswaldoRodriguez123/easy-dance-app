<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Regalo;
use App\Academia;
use App\ItemsFacturaProforma;
use App\Alumno;
use App\Codigo;
use Validator;
use DB;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Image;

class RegaloController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {

        $academia = Academia::find(Auth::user()->academia_id);

        if(Auth::user()->usuario_tipo != 2){

            return view('especiales.regalo.principal')->with(['regalos' => Regalo::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'academia' => $academia]);

        }else{

            return view('especiales.regalo.principal_alumno')->with(['regalos' => Regalo::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'academia' => $academia]);

        }
    }

    public function indexconacademia($id)
    {

        $academia = Academia::find($id);

        return view('especiales.regalo.principal_alumno')->with(['regalos' => Regalo::where('academia_id', '=' ,  $id)->get(), 'academia' => $academia]);

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
        'costo' => 'required',
        'descripcion' => 'required|min:3|max:250',
        // 'dirigido_a' => 'required|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        // 'alumno_id' => 'required',
        // 'correo' => 'required|email',
    ];

    $messages = [

        'nombre.required' => 'Ups! El Nombre es requerido ',
        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre.max' => 'El máximo de caracteres permitidos son 50',
        'descripcion.required' => 'Ups! La Descripcion es requerida',
        'descripcion.min' => 'El mínimo de caracteres permitidos son 3',
        'descripcion.max' => 'El máximo de caracteres permitidos son 250',
        'costo.required' => 'Ups! El Costo es requerido',
        // 'correo.required' => 'Ups! El Correo es requerido ',
        // 'correo.email' => 'Ups! El correo tiene una dirección inválida',
        // 'alumno_id.required' => 'Ups! El campo “de parte de” es requerido',
        // 'dirigido_a.required' => 'Ups! El campo “dirigido a” es requerido',
        // 'dirigido_a.regex' => 'Ups! El campo “dirigido a” es inválido, debe contener sólo letras',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $regalo = new Regalo;

        // $correo = strtolower($request->correo);

        $regalo->academia_id = Auth::user()->academia_id;
        $regalo->nombre = $request->nombre;
        $regalo->descripcion = $request->descripcion;
        $regalo->costo = $request->costo;
        // $regalo->dirigido_a = $request->dirigido_a;
        // $regalo->de_parte_de = $request->alumno_id;
        // $regalo->correo = $correo;

        if($regalo->save()){

            if($request->imageBase64){

                $base64_string = substr($request->imageBase64, strpos($request->imageBase64, ",")+1);
                $path = storage_path();
                $split = explode( ';', $request->imageBase64 );
                $type =  explode( '/',  $split[0]);
                $ext = $type[1];
                
                if($ext == 'jpeg' || 'jpg'){
                    $extension = '.jpg';
                }

                if($ext == 'png'){
                    $extension = '.png';
                }

                $nombre_img = "regalo-". $regalo->id . $extension;
                $image = base64_decode($base64_string);

                // \Storage::disk('taller')->put($nombre_img,  $image);
                $img = Image::make($image)->resize(640, 480);
                $img->save('assets/uploads/regalo/'.$nombre_img);

                $regalo->imagen = $nombre_img;
                $regalo->save();

            }

            // $academia = Academia::find(Auth::user()->academia_id);

            // $subj = 'FELICIDADES, HAS RECIBIDO UNA TARJETA DE REGALO';

            // $alumno = Alumno::find($request->alumno_id);

            // $array = [

            //    'correo' => $request->correo,
            //    'academia' => $academia->nombre,
            //    'dirigido_a' => $request->dirigido_a,
            //    'de_parte_de' => $alumno->nombre . " " . $alumno->apellido,
            //    'subj' => $subj
            // ];

            // Mail::send('correo.regalo', $array, function($msj) use ($array){
            //         $msj->subject($array['subj']);
            //         $msj->to($array['correo']);
            //     });

            // $item_factura = new ItemsFacturaProforma;
                    
            //     $item_factura->alumno_id = $request->alumno_id;
            //     $item_factura->academia_id = Auth::user()->academia_id;
            //     $item_factura->fecha = Carbon::now()->toDateString();
            //     $item_factura->item_id = $regalo->id;
            //     $item_factura->nombre = 'Regalo para ' . $regalo->dirigido_a;
            //     $item_factura->tipo = 10;
            //     $item_factura->cantidad = 1;
            //     $item_factura->precio_neto = 0;
            //     $item_factura->impuesto = 0;
            //     $item_factura->importe_neto = $regalo->costo;
            //     $item_factura->fecha_vencimiento = Carbon::now()->toDateString();
                    
            //     $item_factura->save();

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }
    }

    public function operar($id)
    {   
        $regalo = Regalo::find($id);
        if($regalo){

            return view('especiales.regalo.operaciones')->with(['id' => $id, 'regalo' => $regalo]);    
        }else{
            return redirect("especiales/regalos"); 
        }
    }

    public function verify(Request $request)
    {
        //dd($request->all());

    $request->merge(array('correo' => trim($request->correo)));


    $rules = [
        
        'dirigido_a' => 'required|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'correo' => 'required|email',
    ];

    $messages = [

        'correo.required' => 'Ups! El Correo es requerido ',
        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'dirigido_a.required' => 'Ups! El campo “dirigido a” es requerido',
        'dirigido_a.regex' => 'Ups! El campo “dirigido a” es inválido, debe contener sólo letras',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

       
        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'id' => $request->alumno_id, 200]);

    }
    }

    public function verificarconalumno(Request $request)
    {
        //dd($request->all());

    $request->merge(array('correo' => trim($request->correo)));


    $rules = [
        
        'alumno_id' => 'required',
        'dirigido_a' => 'required|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'correo' => 'required|email',
        
    ];

    $messages = [

        'alumno_id.required' => 'Ups! El campo “de parte de” es requerido',
        'correo.required' => 'Ups! El Correo es requerido ',
        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'dirigido_a.required' => 'Ups! El campo “dirigido a” es requerido',
        'dirigido_a.regex' => 'Ups! El campo “dirigido a” es inválido, debe contener sólo letras',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

       
        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'id' => $request->alumno_id, 200]);

    }
    }

    public function updateNombre(Request $request){

        $rules = [
            'nombre' => 'required|min:3|max:40',
        ];

        $messages = [

            'nombre.required' => 'Ups! El Nombre es requerido',
            'nombre.min' => 'El mínimo de caracteres permitidos son 3',
            'nombre.max' => 'El máximo de caracteres permitidos son 40',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }


        else{

            $regalo = Regalo::find($request->id);

            $nombre = title_case($request->nombre);

            $regalo->nombre = $nombre;

            if($regalo->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
            // return redirect("alumno/edit/{$request->id}");
        }
    }

    public function updateDescripcion(Request $request){

        $rules = [
            'descripcion' => 'required|min:3|max:1000',
        ];

        $messages = [

            'descripcion.required' => 'Ups! La Descripción es requerida',
            'descripcion.min' => 'El mínimo de caracteres permitidos son 3',
            'descripcion.max' => 'El máximo de caracteres permitidos son 1000',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $regalo = Regalo::find($request->id);

            $descripcion = title_case($request->descripcion);
        
            $regalo->descripcion = $request->descripcion;

            if($regalo->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
            // return redirect("alumno/edit/{$request->id}");
        }
    }

    public function updateCosto(Request $request){

        $rules = [
            'costo' => 'required|numeric',
        ];

        $messages = [

            'costo.required' => 'Ups! El costo es requerido',
            'costo.numeric' => 'Ups! El costo es inválido, debe contener sólo números',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $regalo = Regalo::find($request->id);
            $regalo->costo = $request->costo;

            if($regalo->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateImagen(Request $request)
    {
                $regalo = Regalo::find($request->id);
                
                if($request->imageBase64){
                    $base64_string = substr($request->imageBase64, strpos($request->imageBase64, ",")+1);
                    $path = storage_path();
                    $split = explode( ';', $request->imageBase64 );
                    $type =  explode( '/',  $split[0]);

                    $ext = $type[1];
                    
                    if($ext == 'jpeg' || 'jpg'){
                        $extension = '.jpg';
                    }

                    if($ext == 'png'){
                        $extension = '.png';
                    }

                    $nombre_img = "regalo-". $regalo->id . $extension;
                    $image = base64_decode($base64_string);

                    // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
                    $img = Image::make($image)->resize(300, 300);
                    $img->save('assets/uploads/regalo/'.$nombre_img);
                }
                else{
                    $nombre_img = "";
                }

                $regalo->imagen = $nombre_img;
                $regalo->save();

                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
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
        // $visitante_presencial_join = DB::table('visitantes_presenciales')
        //     ->join('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
        //     ->select('config_especialidades.nombre as especialidad_nombre')
        //     ->get();

        $regalo = Regalo::find($id);

        if($regalo){
           return view('especiales.regalo.planilla')->with(['regalo' => $regalo]);
        }else{
           return redirect("especiales/regalos"); 
        }
    }

    public function CrearRegaloUsuario($id)
    {
        $regalo = Regalo::find($id);

        if($regalo){

            if(Auth::check())
            {


                if(Auth::user()->usuario_tipo == 1 || Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6){

                    $alumnos = Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get();
                    return view('especiales.regalo.vender')->with(['regalo' => $regalo, 'alumnos' => $alumnos]);
                }else{
                   return view('especiales.regalo.enviar')->with(['regalo' => $regalo]);
                }

            }else{
                return view('especiales.regalo.enviar')->with(['regalo' => $regalo]);
            }
        }else{
           return redirect("especiales/regalos"); 
        }
    }

    public function EnviarRegaloUsuario(Request $request)
    {
        //dd($request->all());

    $request->merge(array('correo' => trim($request->correo)));

    $rules = [

        'dirigido_a' => 'required|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'correo' => 'required|email',
    ];

    $messages = [

        'correo.required' => 'Ups! El Correo es requerido ',
        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'dirigido_a.required' => 'Ups! El campo “dirigido a” es requerido',
        'dirigido_a.regex' => 'Ups! El campo “dirigido a” es inválido, debe contener sólo letras',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        if($request->alumno_id){
            $alumno_id = $request->alumno_id;
        }else{
            $alumno_id = Auth::user()->usuario_id;
        }

        $regalo = Regalo::find($request->id);

        $item_factura = new ItemsFacturaProforma;
                    
        $item_factura->alumno_id = $alumno_id;
        $item_factura->academia_id = Auth::user()->academia_id;
        $item_factura->fecha = Carbon::now()->toDateString();
        $item_factura->item_id = $regalo->id;
        $item_factura->nombre = 'Regalo para ' . $request->dirigido_a;
        $item_factura->tipo = 10;
        $item_factura->cantidad = 1;
        $item_factura->precio_neto = 0;
        $item_factura->impuesto = 0;
        $item_factura->importe_neto = $regalo->costo;
        $item_factura->fecha_vencimiento = Carbon::now()->toDateString();
                    
        if($item_factura->save()){

            $academia = Academia::find(Auth::user()->academia_id);

            do{

                $codigo_validacion = str_random(8);
                $find = Codigo::where('codigo_validacion', $codigo_validacion)->first();

            }while ($find);

            $codigo = New Codigo;

            $codigo->academia_id = $regalo->academia_id;
            $codigo->item_id = $regalo->id;
            $codigo->tipo = 3;
            $codigo->codigo_validacion = $codigo_validacion;
            $codigo->fecha_vencimiento = Carbon::now()->addMonth()->toDateString();

            if($codigo->save()){

                $subj = 'FELICIDADES, HAS RECIBIDO UNA TARJETA DE REGALO';

                $array = [

                   'correo' => $request->correo,
                   'academia' => $academia->nombre,
                   'dirigido_a' => $request->dirigido_a,
                   'de_parte_de' => Auth::user()->nombre . " " . Auth::user()->apellido,
                   'subj' => $subj,
                   'costo' => $regalo->costo,
                   'regalo_nombre' => $regalo->nombre,
                   'imagen' => $regalo->imagen,
                   'codigo_validacion' => $codigo->codigo_validacion
                ];

                Mail::send('correo.regalo', $array, function($msj) use ($array){
                        $msj->subject($array['subj']);
                        $msj->to($array['correo']);
                    });

                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'id' => $alumno_id, 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function progreso($id)
    {

        $academia = Academia::find($id);

        if($academia){

            return view('especiales.regalo.promocionar')->with(['academia' => $academia, 'id' => $id]);

        }else{
            return redirect("especiales/regalos");
        }
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
            
        if($regalo->delete()){
            return response()->json(['mensaje' => '¡Excelente! El Regalo se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
       
    }

}