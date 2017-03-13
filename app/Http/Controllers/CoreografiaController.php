<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Alumno;
use App\Academia;
use App\Fiesta;
use App\ConfigEspecialidades;
use App\ConfigCoreografias;
use App\ConfigNiveles;
use App\Instructor;
use App\Coreografia;
use App\InscripcionCoreografia;
use Carbon\Carbon;
use Validator;
use DB;
use Mail;
use Session;
use Image;
use Illuminate\Support\Facades\Auth;

class CoreografiaController extends BaseController {


 	public function principal(){

        $coreografias = DB::table('coreografias')
            ->join('instructores', 'coreografias.instructor_id', '=', 'instructores.id')
            ->join('config_coreografias', 'coreografias.tipo', '=', 'config_coreografias.id')
            ->join('fiestas', 'coreografias.fiesta_id', '=', 'fiestas.id')
            ->select('coreografias.id as id', 'coreografias.nombre_coreografia', 'instructores.nombre as nombre_coreografo', 'instructores.apellido as apellido_coreografo', 'fiestas.nombre as fiesta_nombre', 'config_coreografias.nombre as tipo')
        ->get();

        // $alumnod = DB::table('inscripcion_coreografia')
        //     ->select('inscripcion_coreografia.alumno_id', 'inscripcion_coreografia.coreografia_id')
        // ->get();

        // $collection=collect($alumnod);
        // $grouped = $collection->groupBy('coreografia_id');     
        // $deuda = $grouped->toArray();

        // $array=array();
        // $i = 0;
       
        // foreach($deuda as $item){
        // 	$total = 0;
        //     foreach($item as $tmp){

        //     	$coreografia_id = $tmp->coreografia_id;
        //     	$total = $total + 1;

        //     }
        //     $coreografia[$i]->cantidad=$total;
        //     $array[$coreografia_id] = $coreografia[$i];

        //     $i = $i + 1;
        // }
        
        return view('configuracion.coreografia.principal')->with('coreografias', $coreografias);

    }

    public function create()
    {
        return view('configuracion.coreografia.create')->with(['instructores' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'config_coreografias' => ConfigCoreografias::all(), 'fiestas' => Fiesta::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'especialidades' => ConfigEspecialidades::all()]);
    }

    public function store(Request $request)
    {

    $rules = [
        'fiesta_id' => 'required',
        'nombre_coreografia' => 'required',
        'tipo' => 'required',
        'instructor_id' => 'required',
    ];

    $messages = [

        'fiesta_id.required' => 'Ups! El Nombre del evento es requerido',
        'nombre_coreografia.required' => 'Ups! El Nombre de la coreografia es requerido',
        'tipo.required' => 'Ups! El tipo es requerido',
        'instructor_id.required' => 'Ups! El Coreografo es requerido',

     
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

    	if($request->link_video){

            $parts = parse_url($request->link_video);

            if(isset($parts['host']))
            {
                if($parts['host'] == "www.youtube.com" || $parts['host'] == "www.youtu.be"){

                
                }else{
                    return response()->json(['errores' => ['link_video' => [0, 'Ups! ha ocurrido un error, debes ingresar un enlace de YouTube']], 'status' => 'ERROR'],422);
                }
            }else{
                    return response()->json(['errores' => ['link_video' => [0, 'Ups! ha ocurrido un error, debes ingresar un enlace de YouTube']], 'status' => 'ERROR'],422);
            }
            
        }

        $coreografia = new Coreografia;
        
        $coreografia->academia_id = Auth::user()->academia_id;
        $coreografia->fiesta_id = $request->fiesta_id;
        $coreografia->nombre_coreografia = $request->nombre_coreografia;
        $coreografia->tipo = $request->tipo;
        $coreografia->descripcion = $request->descripcion;
        $coreografia->link_video = $request->link_video;
        $coreografia->especialidad_id = $request->especialidad;
        $coreografia->tema_musical = $request->tema_musical;
        $coreografia->tiempo_duracion = $request->tiempo_duracion;
        $coreografia->instructor_id = $request->instructor_id;
        $coreografia->boolean_promocionar = $request->boolean_promocionar;


        if($coreografia->save()){

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

                $nombre_img = "coreografia-". $coreografia->id . $extension;
                $image = base64_decode($base64_string);

                // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
                $img = Image::make($image)->resize(300, 300);
                $img->save('assets/uploads/coreografia/'.$nombre_img);

                $coreografia->imagen = $nombre_img;
                $coreografia->save();

            }

            if($request->imagePresentacionBase64){

                $base64_string = substr($request->imagePresentacionBase64, strpos($request->imagePresentacionBase64, ",")+1);
                $path = storage_path();
                $split = explode( ';', $request->imagePresentacionBase64 );
                $type =  explode( '/',  $split[0]);
                $ext = $type[1];
                
                if($ext == 'jpeg' || 'jpg'){
                    $extension = '.jpg';
                }

                if($ext == 'png'){
                    $extension = '.png';
                }

                $nombre_img = "coreografia2-". $coreografia->id . $extension;
                $image = base64_decode($base64_string);

                // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
                $img = Image::make($image)->resize(1440, 500);
                $img->save('assets/uploads/coreografia/'.$nombre_img);

                $coreografia->imagen_presentacion = $nombre_img;
                $coreografia->save();

            }

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function operar($id)
    {   
        $coreografia = Coreografia::find($id);

        return view('configuracion.coreografia.operacion')->with(['id' => $id, 'coreografia' => $coreografia]);        
    }

    public function edit($id)
    {
        $coreografia = DB::table('coreografias')
            ->join('instructores', 'coreografias.instructor_id', '=', 'instructores.id')
            ->join('config_coreografias', 'coreografias.tipo', '=', 'config_coreografias.id')
            ->join('fiestas', 'coreografias.fiesta_id', '=', 'fiestas.id')
            ->select('coreografias.*','instructores.nombre as coreografo_nombre', 'instructores.apellido as coreografo_apellido', 'fiestas.nombre as fiesta_nombre', 'config_coreografias.nombre as tipo')
            ->where('coreografias.id', '=', $id)
        ->first();

        return view('configuracion.coreografia.planilla')->with(['coreografia' => $coreografia , 'instructores' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'fiestas' => Fiesta::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'especialidades' => ConfigEspecialidades::all(), 'config_coreografias' => ConfigCoreografias::all()]);
    }

    public function participantes($id)
    {

        $coreografia = Coreografia::find($id);

        $alumnos_inscritos = DB::table('inscripcion_coreografia')
                ->join('alumnos', 'inscripcion_coreografia.alumno_id', '=', 'alumnos.id')
                ->select('alumnos.*')
                ->where('inscripcion_coreografia.coreografia_id', '=', $id)
        ->get();

        $alumnos = Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

        return view('configuracion.coreografia.participantes')->with(['alumnos_inscritos' => $alumnos_inscritos, 'id' => $id, 'coreografia' => $coreografia, 'alumnos' => $alumnos]);
    }

    public function storeInscripcion(Request $request)
    {

    $rules = [
        'coreografia_id' => 'required',
        'alumno_id' => 'required',
    ];

    $messages = [

        'coreografia_id.required' => 'Ups! El Nombre  es requerido',
        'alumno_id.required' => 'Ups! El Alumno es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

            $alumnos = explode('-',$request->alumno_id);

            $array=array();

            for($i = 1 ; $i<count($alumnos) ; $i++)
            {
                $inscripcion = new InscripcionCoreografia;

                $inscripcion->coreografia_id = $request->coreografia_id;
                $inscripcion->alumno_id = $alumnos[$i];

                $inscripcion->save();
                
                $alumno = Alumno::find($alumnos[$i]);

                $array[$i] = $alumno;

            }
       
             return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 200]);
 
        }
    }

    public function updateNombreEvento(Request $request){
        
        $rules = [
            'fiesta_id' => 'required',

        ];

        $messages = [
            'fiesta_id.required' => 'Ups! El Nombre del evento es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $coreografia = Coreografia::find($request->id);

            $coreografia->fiesta_id = $request->fiesta_id;

            if($coreografia->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateNombreCoreografia(Request $request){

        $rules = [
            'nombre_coreografia' => 'required',

        ];

        $messages = [
            'nombre_coreografia.required' => 'Ups! El Nombre de la coreografia es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $coreografia = Coreografia::find($request->id);

            $coreografia->nombre_coreografia = $request->nombre_coreografia;

            if($coreografia->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateTipo(Request $request){

        $rules = [
            'tipo' => 'required',

        ];

        $messages = [
            'tipo.required' => 'Ups! El Tipo es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $coreografia = Coreografia::find($request->id);

            $coreografia->nombre_coreografia = $request->nombre_coreografia;

            if($coreografia->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateImagen(Request $request)
    {
        $coreografia = Coreografia::find($request->id);
        
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

            $nombre_img = "coreografia-". $coreografia->id . $extension;
            $image = base64_decode($base64_string);

            // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
            $img = Image::make($image)->resize(300, 300);
            $img->save('assets/uploads/coreografia/'.$nombre_img);
        }
        else{
            $nombre_img = "";
        }

        $coreografia->imagen = $nombre_img;
        $coreografia->save();

        return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
    }

    public function updateImagenPresentacion(Request $request)
    {
        $coreografia = Coreografia::find($request->id);
        
        if($request->imagePresentacionBase64){
            $base64_string = substr($request->imagePresentacionBase64, strpos($request->imagePresentacionBase64, ",")+1);
            $path = storage_path();
            $split = explode( ';', $request->imagePresentacionBase64 );
            $type =  explode( '/',  $split[0]);

            $ext = $type[1];
            
            if($ext == 'jpeg' || 'jpg'){
                $extension = '.jpg';
            }

            if($ext == 'png'){
                $extension = '.png';
            }

            $nombre_img = "coreografia2-". $coreografia->id . $extension;
            $image = base64_decode($base64_string);

            // \Storage::disk('clase_grupal')->put($nombre_img,  $image);
            $img = Image::make($image)->resize(1440, 500);
            $img->save('assets/uploads/coreografia/'.$nombre_img);
        }
        else{
            $nombre_img = "";
        }

        $coreografia->imagen_presentacion = $nombre_img;
        $coreografia->save();

        return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
    }

    public function updateLink(Request $request){

        if($request->link_video){

            $parts = parse_url($request->link_video);

            if(isset($parts['host']))
            {
                if($parts['host'] == "www.youtube.com" || $parts['host'] == "www.youtu.be"){

                
                }else{
                    return response()->json(['errores' => ['link_video' => [0, 'Ups! ha ocurrido un error, debes ingresar un enlace de YouTube']], 'status' => 'ERROR'],422);
                }
            }else{
                    return response()->json(['errores' => ['link_video' => [0, 'Ups! ha ocurrido un error, debes ingresar un enlace de YouTube']], 'status' => 'ERROR'],422);
                }
            
            }

        $coreografia = Coreografia::find($request->id);
        $coreografia->link_video = $request->link_video;

        if($coreografia->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateDescripcion(Request $request){

   
        $coreografia = Coreografia::find($request->id);

        $coreografia->descripcion = $request->descripcion;

        if($coreografia->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        
    }

    public function updateTemaMusical(Request $request){

   
        $coreografia = Coreografia::find($request->id);

        $coreografia->tema_musical = $request->tema_musical;

        if($coreografia->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        
    }

    public function updateTiempoDuracion(Request $request){

   
        $coreografia = Coreografia::find($request->id);

        $coreografia->tiempo_duracion = $request->tiempo_duracion;

        if($coreografia->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        
    }

    public function updateEspecialidad(Request $request){

   
        $coreografia = Coreografia::find($request->id);

        $coreografia->especialidad_id = $request->especialidad;

        if($coreografia->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        
    }

    public function updateCoreografo(Request $request){

        $rules = [
            'instructor_id' => 'required',

        ];

        $messages = [
            'instructor_id.required' => 'Ups! El Coreografo es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $coreografia = Coreografia::find($request->id);

            $coreografia->instructor_id = $request->instructor_id;

            if($coreografia->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function destroy($id)
    {

        // $exist = InscripcionCoreografia::where('coreografia_id', $id)->first();

        // if(!$exist)
        // {
        $coreografia = Coreografia::find($id);
    
        if($coreografia->delete()){
            return response()->json(['mensaje' => '¡Excelente! La Coreografia se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // }
        // else{
        //     return response()->json(['error_mensaje'=> 'Ups! Esta coreografia no puede ser eliminada ya que posee alumnos registrados' , 'status' => 'ERROR-BORRADO'],422);
        // }
    }

}