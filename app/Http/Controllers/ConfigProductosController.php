<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\ConfigProductos;
use App\Academia;
use Validator;
use Session;
use Illuminate\Support\Facades\Auth;
use Image;

class ConfigProductosController extends BaseController {

	public function principalproductos()
	{
		return view('configuracion.productos.principal')->with('productos', ConfigProductos::where('academia_id', '=' ,  Auth::user()->academia_id)->get());
	}

    public function agregarproductos()
    {
        $academia = Academia::find(Auth::user()->academia_id);
        
        return view('configuracion.productos.create')->with('incluye_iva', $academia->incluye_iva);
    }

    public function store(Request $request)
    {
        //dd($request->all());


    $rules = [

        'nombre' => 'required',
        'costo' => 'required|numeric',
        'cantidad' => 'required|numeric',

    ];

    $messages = [

        'nombre.required' => 'Ups! El Nombre  es requerido',
        'costo.required' => 'Ups! El costo de la inscripción es requerido',
        'costo.numeric' => 'Ups! El campo del costo de la inscripcion en inválido , debe contener sólo números',
        'cantidad.required' => 'Ups! El cantidad de la inscripción es requerido',
        'cantidad.numeric' => 'Ups! El campo del costo de la inscripcion en inválido , debe contener sólo números',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $nombre = title_case($request->nombre);
        $descripcion = title_case($request->descripcion);
        //$existente=ConfigProductos::where('nombre',$request->nombre)->first();

        /*if($existente){
            $existente->costo = $request->costo;

            $cantidad_actual=$existente->cantidad;
            $cantidad_nueva=$request->cantidad;
            $existente->cantidad = $cantidad_nueva+$cantidad_actual;

            if(!empty($request->imagen)){
                $existente->imagen = $request->imagen;
            }
            if(!empty($request->descripcion)){
                $existente->descripcion = $descripcion;;
            }
            
            $producto->incluye_iva = $request->incluye_iva;
        }else{*/
            $producto = new ConfigProductos;
        
            $producto->academia_id = Auth::user()->academia_id;
            $producto->nombre = $nombre;
            $producto->costo = $request->costo;
            $producto->cantidad = $request->cantidad;
            $producto->imagen = $request->imagen;
            $producto->descripcion = $descripcion;
            $producto->incluye_iva = $request->incluye_iva;
        //}

        if($producto->save()){

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

                $nombre_img = "producto-". $producto->id . $extension;
                $image = base64_decode($base64_string);

                // \Storage::disk('producto')->put($nombre_img,  $image);
                $img = Image::make($image)->resize(640, 480);
                $img->save('assets/uploads/producto/'.$nombre_img);

                $producto->imagen = $nombre_img;
                $producto->save();

            }
            
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    	}
	}

    public function edit($id)
    {   
        $producto = ConfigProductos::find($id);

        if($producto){
            
            return view('configuracion.productos.planilla')->with(['producto' => $producto , 'id' => $id]);
        }else{
           return redirect("configuracion/productos"); 
        }
    }

    public function updateNombre(Request $request){

        $producto = ConfigProductos::find($request->id);

        $nombre = title_case($request->nombre);

        $producto->nombre = $nombre;

        if($producto->save()){
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

        $producto = ConfigProductos::find($request->id);
        $producto->costo = $request->costo;

        if($producto->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        // return redirect("alumno/edit/{$request->id}");
        }
    }

    public function updateCantidad(Request $request){

    $rules = [
        'cantidad' => 'required|numeric',
    ];

    $messages = [
        'cantidad.required' => 'Ups! El cantidad es requerido',
        'cantidad.numeric' => 'Ups! El campo de cantidad es inválido , debe contener sólo números',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){
        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
    }
    else{
        $producto = ConfigProductos::find($request->id);
        $producto->cantidad = $request->cantidad;
        if($producto->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateDescripcion(Request $request){

        $producto = ConfigProductos::find($request->id);

        $descripcion = title_case($request->descripcion);

        $producto->descripcion = $descripcion;

        if($producto->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateImpuesto(Request $request){

        $producto = ConfigProductos::find($request->id);
        $producto->incluye_iva = $request->incluye_iva;

        if($producto->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateImagen(Request $request)
    {
                $producto = ConfigProductos::find($request->id);
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

                    $nombre_img = "producto-". $producto->id . $extension;
                    $image = base64_decode($base64_string);

                    // \Storage::disk('producto')->put($nombre_img,  $image);
                    $img = Image::make($image)->resize(640, 480);
                    $img->save('assets/uploads/producto/'.$nombre_img);

                }else{
                    $nombre_img = "";
                }

                $producto->imagen = $nombre_img;
                $producto->save();

                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
    }

    public function destroy($id)
    {

        $producto = ConfigProductos::find($id);
        
        if($producto->delete()){
            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno");
    }
}