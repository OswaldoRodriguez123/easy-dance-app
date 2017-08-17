<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Academia;
use App\Acuerdo;
use App\ItemsAcuerdo;
use App\Alumno;
use App\Impuesto;
use App\Instructor;
use App\ConfigProductos;
use App\ClaseGrupal;
use App\HorarioClaseGrupal;
use App\HorarioBloqueado;
use App\Asistencia;
use App\ConfigServicios;
use App\ConfigClasesGrupales;
use App\ConfigEspecialidades;
use App\ConfigEstudios;
use App\ConfigNiveles;
use App\ConfigStaff;
use App\ConfigTipoExamen;
use App\Taller;
use App\Fiesta;
use App\Campana;
use App\ClasePersonalizada;
use App\InscripcionClaseGrupal;
use App\InscripcionClasePersonalizada;
use App\ItemsFacturaProforma;
use App\Paises;
use App\Regalo;
use App\PerfilEvaluativo;
use App\User;
use App\UsuarioTipo;
use App\Factura;
use App\Pago;
use App\ItemsFactura;
use App\ConfigPagosInstructor;
use App\PagoInstructor;
use App\Reservacion;
use App\CredencialAlumno;
use App\Codigo;
use App\Patrocinador;
use App\Egreso;
use App\Puntaje;
use App\ConfigFormulaExito;
use App\VencimientoClaseGrupal;
use Validator;
use Carbon\Carbon;
use Storage;
use Session;
use Illuminate\Support\Facades\Auth;
use DB;
use Image;
use File;
use Illuminate\Support\Facades\Input;

class AcademiaController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function error(){
        
        return view('errors.error_sistema');
    }

    public function principal()
    {
        // $academia= Academia::where('id',Auth::user()->academia_id)
        //            ->select('nombre', 'imagen', 'descripcion', 'telefono', 'celular', 'correo', 'direccion', 'normativa' , 'manual', 'programacion','link_video')
        //            ->get();

        // $academiaRedes= Academia::where('id',Auth::user()->academia_id)
        //            ->select('facebook','twitter','linkedin','instagram','pagina_web','youtube')
        //            ->get();

        // $academiaEstudios= ConfigEstudios::where('academia_id',Auth::user()->academia_id)
        //            ->get();

        // $academiaNiveles= ConfigNiveles::where('academia_id',Auth::user()->academia_id)
        //            ->get();

        $academiaGrupales= ConfigClasesGrupales::where('academia_id',Auth::user()->academia_id)
                   ->count();
        
        $academiaServicios= ConfigServicios::where('academia_id',Auth::user()->academia_id)
                   ->count();

        $clasepersonalizada= ClasePersonalizada::where('academia_id',Auth::user()->academia_id)
                   ->count();


        // $collection = collect($academia[0]);
        // $keys = $collection->keys();
        // $arrayCampos=$keys->all();

        // $collectionRedes = collect($academiaRedes[0]);
        // $keysRedes = $collection->keys();
        // $arrayCamposRedes=$keysRedes->all();

        // $cantCampos=count($arrayCampos)+4;

        // $lleno=1;
        // $vacio=0;
        // $redes=1;

        // if(!collect($academiaEstudios)->isEmpty()){
        //     $lleno=$lleno+1;
        // }else{
        //     $vacio=$vacio+1;
        // } 

        // if(!collect($academiaNiveles)->isEmpty()){
        //     $lleno=$lleno+1;
        // }else{
        //     $vacio=$vacio+1;
        // }    

        // foreach ($arrayCampos as $campo) {
        //     if($academia[0]->$campo!=""){
        //         $lleno=$lleno+1;
        //     }else{
        //         $vacio=$vacio+1;
        //     }
        // }

        // foreach ($arrayCamposRedes as $campo) {
        //     if($academiaRedes[0]->$campo!=""){
        //         $lleno=$lleno+1;
        //         $redes=0;
        //         breack;
        //     }
        // }

        // if($redes!=0){
        //     $vacio=$vacio+$redes;
        // }        
        

        // $porcentajeAcademia=($lleno/$cantCampos)*100;

        // $porcentajeAcademia=round($porcentajeAcademia,2);


        // if(!collect($academiaGrupales)->isEmpty()){
        //     $porcentajeGrupales=100;
        // }else{
        //     $porcentajeGrupales=0;
        // } 


        // if(!collect($academiaServicios)->isEmpty()){
        //     $porcentajeServicios=100;
        // }else{
        //     $porcentajeServicios=0;
        // } 


        // $porcentajeTotal=(($porcentajeAcademia+$porcentajeGrupales+$porcentajeServicios)/300)*100;

        // $porcentajeTotal=round($porcentajeTotal,2);

        // //dd(round($porcentaje,2));

        // //dd($vacio);


        //$= ClasePersonalizada::where('academia_id',Auth::user()->academia_id)->get();
        $campos_array=array("imagen","telefono","celular","correo","direccion","facebook","twitter","linkedin","instagram","pagina_web","youtube","normativa","manual","programacion","incluye_iva","link_video");
        $porcentajeAcademia=0;
        $campos_ocupados=0;

        $academias_datos = Academia::find(Auth::user()->academia_id);

        $info_de_academias=DB::getSchemaBuilder()->getColumnListing('academias');

        for ($i=0; $i < count($info_de_academias); $i++) {

             for ($j=0; $j < count($campos_array); $j++) { 

                 if($info_de_academias[$i]==$campos_array[$j]){

                    if($academias_datos['attributes'][$info_de_academias[$i]])
                    {
                        $campos_ocupados++;
                    }
                 }
             }
         }

        $porcentajeAcademia=($campos_ocupados*100)/count($campos_array);

        if($academiaGrupales){
             $porcentajeGrupales=100;
        }else{
             $porcentajeGrupales=0;
        }

        if($clasepersonalizada){
             $porcentajePersonalizado=100;
        }else{
             $porcentajePersonalizado=0;
        }

        if($academiaServicios){
             $porcentajeServicios=100;
        }else{
             $porcentajeServicios=0;
        }
        
        return view('configuracion.index',compact('porcentajeGrupales','porcentajeServicios','porcentajePersonalizado','porcentajeAcademia'));                  
    }

    public function configuracion(){

        $academia = Academia::find(Auth::user()->academia_id);

        $estudios = ConfigEstudios::where('academia_id' , Auth::user()->academia_id)->get();
        $niveles = ConfigNiveles::where('academia_id' , Auth::user()->academia_id)->get();
        $config_staff = ConfigStaff::where('academia_id' , Auth::user()->academia_id)->get();
        $config_formula = ConfigFormulaExito::where('academia_id' , Auth::user()->academia_id)->get();
        $valoraciones = ConfigTipoExamen::where('academia_id' , Auth::user()->academia_id)->get();


        if($academia->correo)
        {
            return view('configuracion.academia.planilla')->with(['academia' => $academia, 'id' => Auth::user()->academia_id, 'niveles' => $niveles, 'estudios' => $estudios, 'config_staff' => $config_staff, 'config_formula' => $config_formula, 'valoraciones' => $valoraciones]);
        }

        else{

            return view('configuracion.academia.configuracion')->with(['academia' => $academia , 'especialidades' => ConfigEspecialidades::all(), 'estudios' => $estudios, 'niveles' => $niveles, 'config_staff' => $config_staff, 'config_formula' => $config_formula, 'valoraciones' => $valoraciones]);
        }

    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */

    public function updateReferido(Request $request){
    
    $rules = [

        'puntos_referencia' => 'numeric',
        'puntos_referidos' => 'numeric',
    ];

    $messages = [

        'puntos_referencia.numeric' => 'Ups! El campo de “ Promotor ” es inválido, debe contener sólo  números',
        'puntos_referidos.numeric' => 'Ups! El campo de “ Receptor ” es inválido, debe contener sólo  números',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $academia = Academia::find(Auth::user()->academia_id);
        $academia->puntos_referencia = $request->puntos_referencia;
        $academia->puntos_referidos = $request->puntos_referidos;

        if($academia->save()){
       
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        
        }
    }

    public function store(Request $request)
    {

        $request->merge(array('correo' => trim($request->correo)));

        $rules = [
            'correo' => 'required|email|max:255',
            'celular' => 'required',
            'numero_factura' => 'numeric',
            'puntos_referencia' => 'numeric',
            'puntos_referidos' => 'numeric',
        ];


        $messages = [

            'correo.required' => 'Ups! El correo es requerido',
            'correo.email' => 'Ups! El correo tiene una dirección inválida',
            'correo.max' => 'El máximo de caracteres permitidos son 255',
            'telefono.required' => 'Ups! El Teléfono Local es requerido',
            'celular.required' => 'Ups! El Teléfono Móvil es requerido',
            'numero_factura.numeric' => 'Ups! El campo de “ Próximo número de factura ” es inválido, debe contener sólo  números',
            'puntos_referencia.numeric' => 'Ups! El campo de “ Promotor ” es inválido, debe contener sólo  números',
            'puntos_referidos.numeric' => 'Ups! El campo de “ Receptor ” es inválido, debe contener sólo  números',
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

            if($request->numero_factura){
                $numero_factura = $request->numero_factura;
            }
            else{
                $numero_factura = 1;
            }

            $correo = strtolower($request->correo);
            $direccion = $request->direccion;

            $academia = Academia::find(Auth::user()->academia_id);

            $academia->correo = $correo;
            $academia->telefono = $request->telefono;
            $academia->celular = $request->celular;
            $academia->direccion = $direccion;
            $academia->facebook = $request->facebook;
            $academia->twitter = $request->twitter;
            $academia->linkedin = $request->linkedin;
            $academia->instagram = $request->instagram;
            $academia->pagina_web = $request->pagina_web;
            $academia->youtube = $request->youtube;
            $academia->link_video = $request->link_video;
            $academia->normativa = $request->normativa;
            $academia->manual = $request->manual;
            $academia->numero_factura = $numero_factura;
            $academia->incluye_iva = $request->incluye_iva;
            $academia->puntos_referencia = $request->puntos_referencia;
            $academia->puntos_referidos = $request->puntos_referidos;
            
            if($academia->save()){

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

                    $nombre_img = "academia-". $academia->id . $extension;
                    $image = base64_decode($base64_string);

                    // \Storage::disk('academia')->put($nombre_img,  $image);
                    $img = Image::make($image)->resize(640, 480);
                    $img->save('assets/uploads/academia/'.$nombre_img);

                    $academia->imagen = $nombre_img;
                    $academia->save();

                }


                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function CargaInicial(Request $request)
    {


        $rules = [
            'nombre' => 'required|min:3|max:60',
            'identificacion' => 'min:6|max:20',
            'especialidades_id' => 'required',
            'pais_id' => 'required',
            'estado' => 'required|min:3|max:40',
        ];

        $messages = [

            'nombre.required' => 'Ups! El campo Nombre es requerido',
            'nombre.min' => 'El mínimo de caracteres permitidos son 3',
            'nombre.max' => 'El maximo de caracteres permitidos son 60',
            'indentificacion.min' => 'El mínimo de caracteres permitidos son 6',
            'indentificacion.max' => 'El maximo de caracteres permitidos son 20',
            'especialidades_id.required' => 'Ups! La Especialidad es requerida',
            'pais_id.required' => 'Ups! El Pais es requerido',
            'estado.required' => 'Ups! El Estado es requerido',
            'estado.min' => 'El mínimo de caracteres permitidos son 3',
            'estado.max' => 'El máximo de caracteres permitidos son 40',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $academia = Academia::find(Auth::user()->academia_id);

            $pais = Paises::find($request->pais_id);

            $porcentaje_impuesto = Impuesto::where('pais_id' , '=', $request->pais_id)->first();

            $nombre = title_case($request->nombre);

            $academia->nombre = $nombre;
            $academia->identificacion = $request->identificacion;
            $academia->especialidades_id = $request->especialidades_id;
            $academia->pais_id = $request->pais_id;
            $academia->estado = $request->estado;
            $academia->moneda = $pais->moneda;
            $academia->porcentaje_impuesto = $porcentaje_impuesto->impuesto;

            if($academia->save()){
                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

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

    public function updateContacto(Request $request){

    $rules = [
        'correo' => 'required|email|max:255',
        'celular' => 'required',
    ];

    $messages = [
        'correo.required' => 'Ups! El correo es requerido',
        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'correo.max' => 'El máximo de caracteres permitidos son 255',
        'celular.required' => 'Ups! El Teléfono Móvil es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $direccion = $request->direccion;

        $correo = strtolower($request->correo);

        $academia = Academia::find(Auth::user()->academia_id);
        $academia->correo = $correo;
        $academia->telefono = $request->telefono;
        $academia->celular = $request->celular;
        $academia->direccion = $direccion;

        if($academia->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function updateImagen(Request $request)
    {       
            
        if($request->imageBase64){
            $base64_string = substr($request->imageBase64, strpos($request->imageBase64, ",")+1);
            $path = storage_path();
            $split = explode( ';', $request->imageBase64 );
            $type =  explode( '/',  $split[0]);

            $ext = $type[1];
            
            if($ext == 'jpeg' || 'jpg'){
                $extension = '.jpg';
            }elseif($ext == 'png'){
                $extension = '.png';
            }

            $nombre_img = "academia-". Auth::user()->academia_id . $extension;
            $image = base64_decode($base64_string);

            // \Storage::disk('academia')->put($nombre_img,  $image);

            $img = Image::make($image)->resize(640, 480);
            $img->save('assets/uploads/academia/'.$nombre_img);

        }else{
            $nombre_img = "";
        }

        $academia = Academia::find(Auth::user()->academia_id);

        $academia->imagen = $nombre_img;
        $academia->save();

        return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
    }

    public function updateRedes(Request $request){

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

        $academia = Academia::find(Auth::user()->academia_id);
        $academia->facebook = $request->facebook;
        $academia->twitter = $request->twitter;
        $academia->instagram = $request->instagram;
        $academia->pagina_web = $request->pagina_web;
        $academia->linkedin = $request->linkedin;
        $academia->youtube = $request->youtube;
        $academia->link_video = $request->link_video;
        
        if($academia->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEspeciales(Request $request){

        $rules = [

            'normativa' => 'mimes:pdf',
            'manual' => 'mimes:pdf',
            'programacion' => 'mimes:pdf',

        ];

        $messages = [
            'normativa.mimes' => 'Ups! Solo se aceptan archivos PDF',
            'manual.mimes' => 'Ups! Solo se aceptan archivos PDF',
            'programacion.mimes' => 'Ups! Solo se aceptan archivos PDF',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $academia = Academia::find(Auth::user()->academia_id);

            if($request->normativa){

                $extension = $request->normativa->getClientOriginalExtension();
                $nombre_archivo = 'normativa-'.Auth::user()->academia_id.'.'.$extension;

                \Storage::disk('normativa')->put($nombre_archivo,  \File::get($request->normativa));

                $academia->normativa = $nombre_archivo;
            }else{
                $academia->normativa = '';
            }

            if($request->manual){

                $extension = $request->manual->getClientOriginalExtension();
                $nombre_archivo = 'manual-'.Auth::user()->academia_id.'.'.$extension;

                \Storage::disk('manual')->put($nombre_archivo,  \File::get($request->manual));

                $academia->manual = $nombre_archivo;
            }else{
                $academia->manual = '';
            }

            if($request->programacion){

                $extension = $request->programacion->getClientOriginalExtension();
                $nombre_archivo = 'programacion-'.Auth::user()->academia_id.'.'.$extension;

                \Storage::disk('programacion')->put($nombre_archivo,  \File::get($request->programacion));

                $academia->programacion = $nombre_archivo;
            }else{
                $academia->programacion = '';
            }
            
            if($academia->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateAdministrativo(Request $request){

        $academia = Academia::find(Auth::user()->academia_id);
        $academia->incluye_iva = $request->incluye_iva;
        
        if($academia->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updatePassword(Request $request){

        $rules = [
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ];

        $messages = [

            'password.required' => 'Ups! La contraseña es requerida',
            'password.confirmed' => 'Ups! Las contraseñas introducidas no coinciden, intenta de nuevo',
            'password.min' => 'Ups! La contraseña debe contener un mínimo de 6 caracteres',
            'password_confirmation.required' => 'Ups! La contraseña es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{
            
            $academia = Academia::find(Auth::user()->academia_id);
            $academia->password_supervision = bcrypt($request->password);

            if($academia->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateHorario(Request $request){

        $academia = Academia::find(Auth::user()->academia_id);
        $academia->tipo_horario = $request->tipo_horario;
        
        if($academia->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

}
