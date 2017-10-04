<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\ConfigClasesGrupales;
use App\ConfigServicios;
use App\ClaseGrupal;
use App\InscripcionClaseGrupal;
use App\Academia;
use App\Notificacion;
use App\NotificacionUsuario;
use Validator;
use Session;
use DB;
use Illuminate\Support\Facades\Auth;
use Image;

class ConfigClasesGrupalesController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

    public function principalclases()
    {   
        
        return view('configuracion.clases_grupales.principal')->with('clases_grupales', ConfigClasesGrupales::where('academia_id', '=' ,  Auth::user()->academia_id)->get());
    }

    public function agregarclases()
    {   
        $academia = Academia::find(Auth::user()->academia_id);
        
        return view('configuracion.clases_grupales.create')->with('incluye_iva', $academia->incluye_iva);
    }

    public function store(Request $request)
    {
        //dd($request->all());


    $rules = [

        'nombre' => 'required',
        'costo_inscripcion' => 'numeric',
        'costo_mensualidad' => 'numeric',
        'descripcion' => 'required',
        'porcentaje_retraso' => 'numeric',
        'tiempo_tolerancia' => 'numeric',
        'asistencia_rojas' => 'numeric',
        'asistencia_amarillas' => 'numeric',
    ];

    $messages = [

        'nombre.required' => 'Ups! El Nombre  es requerido',
        'costo_inscripcion.numeric' => 'Ups! El campo del costo de la inscripcion es inválido , debe contener sólo números',
        'costo_mensualidad.numeric' => 'Ups! El campo del costo de la mensualidad es inválido , debe contener sólo números',
        'descripcion.required' => 'Ups! La descripción es requerida',  
        'porcentaje_retraso.numeric' => 'Ups! El campo de porcentaje de retraso es inválido , debe contener sólo números',
        'tiempo_tolerancia.numeric' => 'Ups! El campo de tiempo de tolerancia es inválido , debe contener sólo números',
        'asistencia_rojas.numeric' => 'Ups! el campo de inasistencias maximas solo debe contener numeros',
        'asistencia_amarillas.numeric' => 'Ups! el campo de inasistencias minimas solo debe contener numeros',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $nombre = $this->slugify($request->nombre);
        $nombre = title_case($nombre);
        $costo_inscripcion = trim($request->costo_inscripcion);
        $costo_mensualidad =  trim($request->costo_mensualidad);

        if($costo_inscripcion == ''){
            $costo_inscripcion = 0;
        }

        if($costo_mensualidad == ''){
            $costo_mensualidad = 0;
        }

        $clasegrupal = new ConfigClasesGrupales;
        
        $clasegrupal->academia_id = Auth::user()->academia_id;
        $clasegrupal->nombre = $nombre;
        $clasegrupal->costo_inscripcion = $costo_inscripcion;
        $clasegrupal->costo_mensualidad = $costo_mensualidad;
        $clasegrupal->descripcion = $request->descripcion;
        $clasegrupal->incluye_iva = $request->incluye_iva;
        $clasegrupal->porcentaje_retraso = $request->porcentaje_retraso;
        $clasegrupal->tiempo_tolerancia = $request->tiempo_tolerancia;
        $clasegrupal->asistencia_rojo = $request->asistencia_rojas;
        $clasegrupal->asistencia_amarilla = $request->asistencia_amarillas;
        $clasegrupal->boolean_promociones = $request->boolean_promociones;
        // $clasegrupal->condiciones = $request->condiciones;

        if($clasegrupal->save()){

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

                $nombre_img = "clasegrupal2-". $clasegrupal->id . $extension;
                $image = base64_decode($base64_string);

                // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
                $img = Image::make($image)->resize(300, 300);
                $img->save('assets/uploads/clase_grupal/'.$nombre_img);

                $clasegrupal->imagen = $nombre_img;
                $clasegrupal->save();
            }

            $servicio = new ConfigServicios;
            
            $servicio->academia_id = Auth::user()->academia_id;
            $servicio->nombre = 'Inscripción ' . $nombre;
            $servicio->costo = $costo_inscripcion;
            $servicio->imagen = '';
            $servicio->descripcion = $request->descripcion;
            $servicio->incluye_iva = $request->incluye_iva;
            $servicio->tipo = 3;
            $servicio->tipo_id = $clasegrupal->id;

            $servicio->save();

            $clasegrupal->servicio_id = $servicio->id;
            $clasegrupal->save();

            $servicio = new ConfigServicios;
            
            $servicio->academia_id = Auth::user()->academia_id;
            $servicio->nombre = 'Cuota ' . $nombre;
            $servicio->costo = $costo_mensualidad;
            $servicio->imagen = '';
            $servicio->descripcion = $request->descripcion;
            $servicio->tipo = 4;
            $servicio->tipo_id = $clasegrupal->id;

            $servicio->save();
            
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $clasegrupal, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    	}
	}

    public function edit($id)
    {   
        $clasegrupal = ConfigClasesGrupales::find($id);

        if($clasegrupal){
            
            return view('configuracion.clases_grupales.planilla')->with(['clasegrupal' => $clasegrupal , 'id' => $id]);
        }else{
           return redirect("configuracion/clases-grupales"); 
        }
    }

    public function updateNombre(Request $request){

        $clasegrupal = ConfigClasesGrupales::find($request->id);

        $nombre = $this->slugify($request->nombre);
        $nombre = title_case($nombre);

        $clasegrupal->nombre = $nombre;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'nombre' => 'nombre', 'valor' => $nombre, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateCostoInscripcion(Request $request){

    $rules = [

        'costo_inscripcion' => 'numeric',

    ];

    $messages = [

        'costo_inscripcion.required' => 'Ups! El costo de la inscripción es requerido',
        'costo_inscripcion.numeric' => 'Ups! El campo del costo de la inscripcion en inválido , debe contener sólo números',

    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $clasegrupal = ConfigClasesGrupales::find($request->id);

        $costo_inscripcion = $request->costo_inscripcion;

        if(trim($costo_inscripcion) == ''){
            $costo_inscripcion = 0;
        }
        
        $clasegrupal->costo_inscripcion = $costo_inscripcion;
        
        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'nombre' => 'costo_inscripcion', 'valor' => $costo_inscripcion, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        // return redirect("alumno/edit/{$request->id}");
        }
    }

    public function updateCostoMensualidad(Request $request){

    $rules = [

        'costo_mensualidad' => 'numeric',

    ];

    $messages = [

        'costo_mensualidad.required' => 'Ups! El costo de la mensualidad es requerida',
        'costo_mensualidad.numeric' => 'Ups! El campo del costo de la mensualidad en inválido , debe contener sólo números',        
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $clasegrupal = ConfigClasesGrupales::find($request->id);
        
        $costo_mensualidad = $request->costo_mensualidad;

        if(trim($costo_mensualidad) == ''){
            $costo_mensualidad = 0;
        }

        $clasegrupal->costo_mensualidad = $costo_mensualidad;

        if($clasegrupal->save()){

            $clases_grupales = ClaseGrupal::where('clase_grupal_id', $request->id)->get();

            foreach($clases_grupales as $clase_grupal){

                $inscripcion_clase_grupal = InscripcionClaseGrupal::where('clase_grupal_id', $clase_grupal->id)->get();

                foreach ($inscripcion_clase_grupal as $inscripcion) {

                    $inscripcion->costo_mensualidad = $costo_mensualidad;
                    $inscripcion->save();

                }
            }


            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'nombre' => 'costo_mensualidad', 'valor' => $costo_mensualidad, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateAsistencias(Request $request){

    $rules = [
        'asistencia_rojas' => 'numeric',
        'asistencia_amarillas' => 'numeric',
    ];

    $messages = [
        'asistencia_rojas.numeric' => 'Ups! El campo inasistencias maxima debe contener sólo números',
        'asistencia_amarillas.numeric' => 'Ups! El campo inasistencias minima debe contener sólo números',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
    }

    else{
        $clasegrupal = ConfigClasesGrupales::find($request->id);

        $asistencia_roja = $request->asistencia_rojas;
        $asistencia_amarillo = $request->asistencia_amarillas;

        if($asistencia_roja < 0){
            $asistencia_roja = 0;
        }
        if($asistencia_amarillo < 0){
            $asistencia_amarillo = 0;
        }
        
        $clasegrupal->asistencia_rojo = $asistencia_roja;
        $clasegrupal->asistencia_amarilla = $asistencia_amarillo;
        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'nombre' => 'asistencia_roja', 'valor' => $asistencia_amarillo, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        // return redirect("alumno/edit/{$request->id}");
        }
    }

    public function updateDescripcion(Request $request){

        $clasegrupal = ConfigClasesGrupales::find($request->id);

        $descripcion = $request->descripcion;

        $clasegrupal->descripcion = $descripcion;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'nombre' => 'descripcion', 'valor' => $descripcion, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateImpuesto(Request $request){

        $clasegrupal = ConfigClasesGrupales::find($request->id);
        $clasegrupal->incluye_iva = $request->incluye_iva;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'nombre' => 'incluye_iva', 'valor' => $request->incluye_iva, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updatePromocion(Request $request){

        $clasegrupal = ConfigClasesGrupales::find($request->id);
        $clasegrupal->boolean_promociones = $request->boolean_promociones;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'nombre' => 'boolean_promociones', 'valor' => $request->boolean_promociones, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateCondiciones(Request $request){
        $clasegrupal = ConfigClasesGrupales::find($request->id);
        $clasegrupal->condiciones = $request->condiciones;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateImagen(Request $request)
    {
                $clasegrupal = ConfigClasesGrupales::find($request->id);
                
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

                    $nombre_img = "clasegrupal2-". $clasegrupal->id . $extension;
                    $image = base64_decode($base64_string);

                    // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
                    $img = Image::make($image)->resize(300, 300);
                    $img->save('assets/uploads/clase_grupal/'.$nombre_img);
                }
                else{
                    $nombre_img = "";
                }

                $clasegrupal->imagen = $nombre_img;
                $clasegrupal->save();

                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
    }

    public function updateAvanzado(Request $request){

    $rules = [

        'porcentaje_retraso' => 'numeric',
        'tiempo_tolerancia' => 'numeric',
    ];

    $messages = [

        'porcentaje_retraso.numeric' => 'Ups! El campo de porcentaje de retraso es inválido , debe contener sólo números',
        'tiempo_tolerancia.numeric' => 'Ups! El campo de tiempo de tolerancia es inválido , debe contener sólo números',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $clasegrupal = ConfigClasesGrupales::find($request->id);

        $porcentaje_retraso = $request->porcentaje_retraso;
        $tiempo_tolerancia = $request->tiempo_tolerancia;

        if(trim($porcentaje_retraso) == ''){
            $porcentaje_retraso = 0;
        }

        if(trim($tiempo_tolerancia) == ''){
            $tiempo_tolerancia = 0;
        }

        $clasegrupal->porcentaje_retraso = $porcentaje_retraso;
        $clasegrupal->tiempo_tolerancia = $tiempo_tolerancia;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function destroy($id)
    {

        $clasegrupal = ConfigClasesGrupales::find($id);
        
        if($clasegrupal->delete()){

            $in = array(3,4);

            $delete = ConfigServicios::whereIn('tipo',$in)->where('tipo_id',$id)->delete();
            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno");
    }
}