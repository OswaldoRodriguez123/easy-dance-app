<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Paquete;
use App\Academia;
use App\ConfigServicios;
use Validator;
use DB;
use Image;
use Illuminate\Support\Facades\Auth;

class PaqueteController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function principal()
    {
        return view('configuracion.paquetes.principal')->with('paquetes', Paquete::where('academia_id',Auth::user()->academia_id)->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        $academia = Academia::find(Auth::user()->academia_id);
        
        return view('configuracion.paquetes.create')->with('incluye_iva', $academia->incluye_iva);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    
    public function store(Request $request)
    {

        $rules = [
            'nombre' => 'required|min:3|max:50',
            'costo' => 'required|numeric',
            'cantidad_clases_grupales' => 'required|numeric',
            'descripcion' => 'required|min:3|max:500',
        ];

        $messages = [

            'nombre.required' => 'Ups! El Nombre es requerido ',
            'nombre.min' => 'El mínimo de caracteres permitidos son 3',
            'nombre.max' => 'El máximo de caracteres permitidos son 50',
            'costo.required' => 'Ups! El Costo es requerido',
            'costo.numeric' => 'Ups! El Costo es inválido , debe contener sólo números',
            'cantidad_clases_grupales.required' => 'Ups! La cantidad es requerida',
            'cantidad_clases_grupales.numeric' => 'Ups! La cantidad es inválida , debe contener sólo números',
            'descripcion.required' => 'Ups! La Descripcion es requerida',
            'descripcion.min' => 'El mínimo de caracteres permitidos son 3',
            'descripcion.max' => 'El máximo de caracteres permitidos son 500',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $nombre = title_case($request->nombre);

            $paquete = new Paquete;

            $paquete->academia_id = Auth::user()->academia_id;
            $paquete->nombre = $nombre;
            $paquete->descripcion = $request->descripcion;
            $paquete->costo = $request->costo;
            $paquete->cantidad_clases_grupales = $request->cantidad_clases_grupales;

            if($paquete->save()){

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

                    $nombre_img = "paquete-". $paquete->id . $extension;
                    $image = base64_decode($base64_string);

                    // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
                    $img = Image::make($image)->resize(300, 300);
                    $img->save('assets/uploads/paquete/'.$nombre_img);

                    $paquete->imagen = $nombre_img;
                    $paquete->save();
                }

                $servicio = new ConfigServicios;
                
                $servicio->academia_id = Auth::user()->academia_id;
                $servicio->nombre = $nombre;
                $servicio->costo = $request->costo;
                $servicio->descripcion = $request->descripcion;
                $servicio->incluye_iva = $request->incluye_iva;
                $servicio->tipo = 15;
                $servicio->tipo_id = $paquete->id;

                $servicio->save();

                $paquete->servicio_id = $servicio->id;
                $paquete->save();

                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateNombre(Request $request){

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

            $paquete = Paquete::find($request->id);
            $paquete->nombre = $request->nombre;

            if($paquete->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateDescripcion(Request $request){

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

            $paquete = Paquete::find($request->id);
            $paquete->descripcion = $request->descripcion;

            if($paquete->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateCosto(Request $request){

        $rules = [

            'costo' => 'numeric',

        ];

        $messages = [

            'costo.required' => 'Ups! El costo es requerido',
            'costo.numeric' => 'Ups! El costo es inválido , debe contener sólo números',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{

            $paquete = Paquete::find($request->id);
            $paquete->costo = $request->costo;

            if($paquete->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateCantidad(Request $request){


        $rules = [

            'cantidad_clases_grupales' => 'numeric',

        ];

        $messages = [

            'cantidad_clases_grupales.required' => 'Ups! La cantidad es requerida',
            'cantidad_clases_grupales.numeric' => 'Ups! La cantidad es inválida , debe contener sólo números',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{

            $paquete = Paquete::find($request->id);

            $paquete->cantidad_clases_grupales = $request->cantidad_clases_grupales;

            if($paquete->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateImagen(Request $request)
    {
        $paquete = Paquete::find($request->id);
        
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

            $nombre_img = "paquete-". $paquete->id . $extension;
            $image = base64_decode($base64_string);

            // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
            $img = Image::make($image)->resize(300, 300);
            $img->save('assets/uploads/paquete/'.$nombre_img);
        }
        else{
            $nombre_img = "";
        }

        $paquete->imagen = $nombre_img;
        $paquete->save();

        return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {   
        $paquete = Paquete::find($id);

        if($paquete){
            return view('configuracion.paquetes.planilla')->with(['paquete' => $paquete , 'id' => $id]);
        }else{
           return redirect("configuracion/paquetes"); 
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

        $paquete = Paquete::find($id);
        
        if($paquete->delete()){
            $delete = ConfigServicios::where('tipo',15)->where('tipo_id',$id)->delete();
            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno");
    }

}