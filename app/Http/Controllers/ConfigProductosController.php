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
        $tmp = ConfigProductos::where('academia_id', '=' ,  Auth::user()->academia_id)->get();
        $productos = array();

        foreach($tmp as $producto){

            if($producto->tipo == 14){
                $tipo = 'Fiestas y Eventos';
            }else if($producto->tipo == 5){
                $tipo = 'Talleres';
            }else if($producto->tipo == 11){
                $tipo = 'Campañas';
            }else if($producto->tipo == 9){
                $tipo = "Clases Personalizadas";
            }else if($producto->tipo == 15){
                $tipo = "Paquetes";
            }else{
                $tipo = 'Productos';
            }

            $collection=collect($producto);     
            $array = $collection->toArray();
            
            $array['tipo']=$tipo;
            $productos[$producto->id] = $array;
        }
        
		return view('configuracion.productos.principal')->with('productos', $productos);
	}

    public function agregarproductos()
    {
        $academia = Academia::find(Auth::user()->academia_id);
        
        return view('configuracion.productos.create')->with('incluye_iva', $academia->incluye_iva);
    }

    public function store(Request $request)
    {

    $rules = [

        'nombre' => 'required',
        'costo' => 'required|numeric',
        'cantidad' => 'required|numeric',

    ];

    $messages = [

        'nombre.required' => 'Ups! El Nombre  es requerido',
        'costo.required' => 'Ups! El costo es requerido',
        'costo.numeric' => 'Ups! El costo es inválido , debe contener sólo números',
        'cantidad.required' => 'Ups! La cantidad es requerida',
        'cantidad.numeric' => 'Ups! La cantidad es inválida , debe contener sólo números',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $nombre = title_case($request->nombre);
        $descripcion = $request->descripcion;
    
        $producto = new ConfigProductos;
    
        $producto->academia_id = Auth::user()->academia_id;
        $producto->nombre = $nombre;
        $producto->costo = $request->costo;
        $producto->cantidad = $request->cantidad;
        $producto->imagen = $request->imagen;
        $producto->descripcion = $descripcion;
        $producto->incluye_iva = $request->incluye_iva;
        $producto->tipo = $request->tipo;
        $producto->boolean_promocionar = $request->boolean_promocionar;

        if($producto->save()){

            $producto->tipo_id = $producto->id;
            $producto->save();

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

        Session::forget('cantidad_productos');

        if($producto){

            if($producto->tipo == 5){
                $tipo = "Taller";
            }else if($producto->tipo == 14){
                $tipo = "Fiesta y Eventos";
            }else if($producto->tipo == 11){
                $tipo = "Campaña";
            }else if($producto->tipo == 9){
                $tipo = "Clase Personalizada";
            }else{
                $tipo = "Producto";
            }
            return view('configuracion.productos.planilla')->with(['producto' => $producto , 'id' => $id, 'tipo' => $tipo]);
        }else{
           return redirect("productos"); 
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
        'costo.numeric' => 'Ups! El costo es inválido , debe contener sólo números',

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
        }
    }

    public function updateCantidad(Request $request){

    $rules = [
        'cantidad' => 'required|numeric',
    ];

    $messages = [
        'cantidad.required' => 'Ups! La cantidad es requerida',
        'cantidad.numeric' => 'Ups! La cantidad es inválida, debe contener sólo números',
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

        $descripcion = $request->descripcion;

        $producto->descripcion = $descripcion;

        if($producto->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateImpuesto(Request $request){

        $producto = ConfigProductos::find($request->id);
        $producto->incluye_iva = $request->incluye_iva;

        if($producto->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
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

    public function updateTipo(Request $request){

        $producto = ConfigProductos::find($request->id);
        $producto->tipo = $request->tipo;

        if($producto->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateMostrar(Request $request){

        $producto = ConfigProductos::find($request->id);
        $producto->boolean_promocionar = $request->boolean_promocionar;

        if($producto->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function destroy($id)
    {

        $producto = ConfigProductos::find($id);
        
        if($producto->delete()){
            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function agregar_cantidad(Request $request){
        
        $rules = [

            'cantidad_producto' => 'required|numeric|min:1',
        ];

        $messages = [

            'cantidad_producto.required' => 'Ups! El Cantidad es invalido, solo se aceptan numeros',
            'cantidad_producto.numeric' => 'Ups! El Cantidad es requerido',
            'cantidad_producto.min' => 'El mínimo de cantidad permitida es 1',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            Session::push('cantidad_productos', $request->cantidad_producto);

            $items = Session::get('cantidad_productos');
            end( $items );
            $contador = key( $items );

             return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'cantidad' => $request->cantidad_producto, 'id' => $contador, 200]);

        }
    }

    public function eliminar_cantidad($id){

        $arreglo = Session::get('cantidad_productos');

        $cantidad = $arreglo[$id];

        unset($arreglo[$id]);
        Session::put('cantidad_productos', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'cantidad' => $cantidad, 200]);

    }
}