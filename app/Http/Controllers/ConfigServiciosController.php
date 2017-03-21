<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\ConfigServicios;
use App\Academia;
use Validator;
use Session;
use Illuminate\Support\Facades\Auth;
use Image;

class ConfigServiciosController extends BaseController {


	public function principalservicios()
    {
        return view('configuracion.servicios.principal')->with('servicios', ConfigServicios::where('academia_id', '=' ,  Auth::user()->academia_id)->get());
    }

    public function agregarservicios()
    {
        $academia = Academia::find(Auth::user()->academia_id);
        
        return view('configuracion.servicios.create')->with('incluye_iva', $academia->incluye_iva);

    }

    public function store(Request $request)
    {
        //dd($request->all());


    $rules = [

        'nombre' => 'required',
        'costo' => 'required|numeric',
        'cantidad_sesiones' => 'numeric',
        'meses_expiracion' => 'numeric',


    ];

    $messages = [

        'nombre.required' => 'Ups! El Nombre  es requerido',
        'costo.required' => 'Ups! El costo de la inscripción es requerido',
        'costo.numeric' => 'Ups! El campo de costo es inválido , debe contener sólo números',
        'cantidad_sesiones.numeric' => 'Ups! El campo de Número de Sesiones es inválido , debe contener sólo números',  
        'meses_expiracion.numeric' => 'Ups! El campo es inválido , debe contener sólo números',    
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $nombre = title_case($request->nombre);

        $servicio = new ConfigServicios;
        
        $servicio->academia_id = Auth::user()->academia_id;
        $servicio->nombre = $nombre;
        $servicio->costo = $request->costo;
        $servicio->imagen = $request->imagen;
        $servicio->descripcion = $request->descripcion;
        $servicio->cantidad_sesiones = $request->cantidad_sesiones;
        $servicio->meses_expiracion = $request->meses_expiracion;
        $servicio->meses_despues = $request->meses_despues;
        $servicio->incluye_iva = $request->incluye_iva;
        $servicio->tipo = $request->tipo;

        if($servicio->save()){

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

                $nombre_img = "servicio-". $servicio->id . $extension;
                $image = base64_decode($base64_string);

                // \Storage::disk('servicio')->put($nombre_img,  $image);

                $img = Image::make($image)->resize(640, 480);
                $img->save('assets/uploads/servicio/'.$nombre_img);

                $servicio->imagen = $nombre_img;
                $servicio->save();

            }

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    	}
	}

    public function edit($id)
    {   
        $servicio = ConfigServicios::find($id);

        if($servicio){

            if($servicio->tipo == 5){
                $tipo = "Taller";
            }else if($servicio->tipo == 14){
                $tipo = "Fiesta";
            }else if($servicio->tipo == 11){
                $tipo = "Campaña";
            }else{
                $tipo = "Academia";
            }
            
            return view('configuracion.servicios.planilla')->with(['servicio' => $servicio , 'id' => $id, 'tipo' => $tipo]);
        }else{
           return redirect("configuracion/servicios"); 
        }
    }

    public function updateNombre(Request $request){

        $servicio = ConfigServicios::find($request->id);

        $nombre = title_case($request->nombre);

        $servicio->nombre = $nombre;

        if($servicio->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateCosto(Request $request){

    $rules = [

        'costo' => 'required|numeric',

    ];

    $messages = [

        'costo.required' => 'Ups! El costo es requerido',
        'costo.numeric' => 'Ups! El campo de costo es inválido , debe contener sólo números',

    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $servicio = ConfigServicios::find($request->id);
        $servicio->costo = $request->costo;

        if($servicio->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        // return redirect("alumno/edit/{$request->id}");
        }
    }

    public function updateDescripcion(Request $request){

        $servicio = ConfigServicios::find($request->id);
        $servicio->descripcion = $request->descripcion;

        if($servicio->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateOpciones(Request $request){

    $rules = [

        'cantidad_sesiones' => 'numeric',
        'meses_expiracion' => 'numeric',

    ];

    $messages = [

        'cantidad_sesiones.numeric' => 'Ups! El campo de Número de Sesiones es inválido , debe contener sólo números',  
        'meses_expiracion.numeric' => 'Ups! El campo es inválido , debe contener sólo números', 

    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $servicio = ConfigServicios::find($request->id);
        $servicio->cantidad_sesiones = $request->cantidad_sesiones;
        $servicio->meses_expiracion = $request->meses_expiracion;

        if($servicio->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        // return redirect("alumno/edit/{$request->id}");
        }
    }

    public function updateImpuesto(Request $request){

        $servicio = ConfigServicios::find($request->id);
        $servicio->incluye_iva = $request->incluye_iva;

        if($servicio->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateImagen(Request $request)
    {
                $servicio = ConfigServicios::find($request->id);
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

                    $nombre_img = "servicio-". $servicio->id . $extension;
                    $image = base64_decode($base64_string);

                    // \Storage::disk('servicio')->put($nombre_img,  $image);
                    $img = Image::make($image)->resize(640, 480);
                    $img->save('assets/uploads/servicio/'.$nombre_img);

                }else{
                    $nombre_img = "";
                }

                $servicio->imagen = $nombre_img;
                $servicio->save();

                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
    }

    public function updateTipo(Request $request){

        $servicio = ConfigServicios::find($request->id);
        $servicio->tipo = $request->tipo;

        if($servicio->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    
    public function destroy($id)
    {

        $servicio = ConfigServicios::find($id);
        
        if($servicio->delete()){
            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno");
    }

}