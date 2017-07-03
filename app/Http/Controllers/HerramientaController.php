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
use App\ItemsFacturaProforma;
use App\Paises;
use App\Regalo;
use App\PerfilEvaluativo;
use App\User;
use App\Factura;
use App\Pago;
use App\ItemsFactura;
use App\ConfigPagosInstructor;
use App\PagoInstructor;
use App\Codigo;
use App\Patrocinador;
use App\Egreso;
use App\Puntaje;
use App\ConfigFormulaExito;
use Validator;
use Carbon\Carbon;
use Storage;
use Session;
use Illuminate\Support\Facades\Auth;
use DB;
use Image;
use Illuminate\Support\Facades\Input;

class HerramientaController extends BaseController {


    public function index(){

        $academia = Academia::find(Auth::user()->academia_id);

        $estudios = ConfigEstudios::where('academia_id' , Auth::user()->academia_id)->get();
        $niveles = ConfigNiveles::where('academia_id' , Auth::user()->academia_id)->orWhere('academia_id', null)->get();
        $config_staff = ConfigStaff::where('academia_id' , Auth::user()->academia_id)->orWhere('academia_id', null)->get();
        $config_formula = ConfigFormulaExito::where('academia_id' , Auth::user()->academia_id)->get();
        $valoraciones = ConfigTipoExamen::where('academia_id' , Auth::user()->academia_id)->get();
        $puntajes = Puntaje::where('academia_id' , Auth::user()->academia_id)->get();

        return view('configuracion.herramientas.planilla')->with(['academia' => $academia, 'id' => Auth::user()->academia_id, 'niveles' => $niveles, 'estudios' => $estudios, 'config_staff' => $config_staff, 'config_formula' => $config_formula, 'valoraciones' => $valoraciones, 'puntajes' => $puntajes]);

    }


	public function agregarestudio(Request $request){
        
    $rules = [

        'nombre_estudio' => 'required',
        'cantidad_estudio' => 'required|numeric|min:1',
    ];

    $messages = [

        'nombre_estudio.required' => 'Ups! El Nombre es requerido',
        'cantidad_estudio.required' => 'Ups! La Cantidad es requerida',
        'cantidad_estudio.numeric' => 'Ups! La Cantidad es invalida, solo se aceptan numeros',
        'cantidad_estudio.min' => 'El mínimo de cantidad permitida es 1',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $nombre = title_case($request->nombre_estudio);
        
        $array = array(['nombre' => $nombre , 'cantidad' => $request->cantidad_estudio]);

        $estudio = new ConfigEstudios;
                                        
        $estudio->academia_id = Auth::user()->academia_id;
        $estudio->nombre = $nombre;
        $estudio->capacidad = $request->cantidad_estudio;

        $estudio->save();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $estudio, 'id' => $estudio->id, 200]);

        }
    }

    public function agregarnivel(Request $request){
        
    $rules = [

        'nombre_nivel' => 'required',
    ];

    $messages = [

        'nombre_nivel.required' => 'Ups! El Nombre es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $nombre = title_case($request->nombre_nivel);

        $nivel = new ConfigNiveles;
                                        
        $nivel->academia_id = Auth::user()->academia_id;
        $nivel->nombre = $nombre;

        $nivel->save();

         return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $nivel, 'id' => $nivel->id, 200]);

        }
    }

    public function eliminarestudio($id){

        $estudio = ConfigEstudios::find($id);

        $estudio->delete();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function eliminarniveles($id){

        $nivel = ConfigNiveles::find($id);

        $nivel->delete();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    Public function agregarcargo(Request $request){
        
    $rules = [

        'nombre_cargo' => 'required',
    ];

    $messages = [

        'nombre_cargo.required' => 'Ups! El Nombre es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $nombre = title_case($request->nombre_cargo);

        $staff = new ConfigStaff;
                                        
        $staff->academia_id = Auth::user()->academia_id;
        $staff->nombre = $nombre;

        $staff->save();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $staff, 'id' => $staff->id, 200]);

        }
    }

    public function eliminarcargo($id){

        $staff = ConfigStaff::find($id);

        $staff->delete();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    Public function agregarformula(Request $request){
        
    $rules = [

        'nombre_formula' => 'required',
    ];

    $messages = [

        'nombre_formula.required' => 'Ups! El Nombre es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $nombre = title_case($request->nombre_formula);

        $formula = new ConfigFormulaExito;
                                        
        $formula->academia_id = Auth::user()->academia_id;
        $formula->nombre = $nombre;

        $formula->save();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $formula, 'id' => $formula->id, 200]);

        }
    }

    public function eliminarformula($id){

        $formula = ConfigFormulaExito::find($id);

        $formula->delete();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    Public function agregarvaloracion(Request $request){
        
    $rules = [

        'nombre_valoracion' => 'required',
    ];

    $messages = [

        'nombre_valoracion.required' => 'Ups! El Nombre es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $nombre = title_case($request->nombre_valoracion);

        $valoracion = new ConfigTipoExamen;
                                        
        $valoracion->academia_id = Auth::user()->academia_id;
        $valoracion->nombre = $nombre;

        $valoracion->save();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $valoracion, 'id' => $valoracion->id, 200]);

        }
    }

    public function eliminarvaloracion($id){

        $valoracion = ConfigTipoExamen::find($id);

        $valoracion->delete();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function agregarpuntaje(Request $request){
        
    $rules = [

        'nombre_puntaje' => 'required',
        'cantidad_puntaje' => 'required|numeric|min:1',
        'fecha_vencimiento_puntaje' => 'required',
    ];

    $messages = [

        'nombre_puntaje.required' => 'Ups! El Nombre es requerido',
        'cantidad_puntaje.required' => 'Ups! El Cantidad es invalida, solo se aceptan numeros',
        'cantidad_puntaje.numeric' => 'Ups! La Cantidad es requerida',
        'cantidad_puntaje.min' => 'El mínimo de cantidad permitida es 1',
        'fecha_vencimiento_puntaje.required' => 'Ups! La fecha de vencimiento es requerida',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $nombre = title_case($request->nombre_puntaje);

        $fecha_vencimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_vencimiento_puntaje);

        if($fecha_vencimiento < Carbon::now()){
        	return response()->json(['errores' => ['fecha_vencimiento' => [0, 'Ups! Esta fecha es invalida, debes ingresar una fecha superior a hoy']], 'status' => 'ERROR'],422);
        }

        $fecha_vencimiento = $fecha_vencimiento->toDateString();
        
        $puntaje = new Puntaje;
                                        
        $puntaje->academia_id = Auth::user()->academia_id;
        $puntaje->nombre = $nombre;
        $puntaje->cantidad = $request->cantidad_puntaje;
        $puntaje->fecha_vencimiento = $fecha_vencimiento;

        $puntaje->save();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $puntaje, 'id' => $puntaje->id, 200]);

        }
    }

    public function eliminarpuntaje($id){

        $puntaje = Puntaje::find($id);

        $puntaje->delete();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function planilla_procedimientos(){

        $academia = Academia::find(Auth::user()->academia_id);
        return view('configuracion.herramientas.procedimientos.planilla')->with(['academia' => $academia]);
        
        
    }

    public function principal_procedimientos(){

        $id = Auth::user()->academia_id;

        $file = File::exists('assets/uploads/procedimientos/coordinacion-de-pista-'.$id.'.pdf');

        if($file){
            $coordinacion = 'assets/uploads/procedimientos/coordinacion-de-pista-'.$id.'.pdf';
        }else{
            $coordinacion = '';
        }

        $file = File::exists('assets/uploads/procedimientos/productora-de-eventos-'.$id.'.pdf');

        if($file){
            $evento = 'assets/uploads/procedimientos/productora-de-eventos-'.$id.'.pdf';
        }else{
            $evento = '';
        }


        $file = File::exists('assets/uploads/procedimientos/ventas-'.$id.'.pdf');

        if($file){
            $venta = 'assets/uploads/procedimientos/ventas-'.$id.'.pdf';
        }else{
            $venta = '';
        }

        $file = File::exists('assets/uploads/procedimientos/supervisores-'.$id.'.pdf');

        if($file){
            $supervisor = 'assets/uploads/procedimientos/supervisores-'.$id.'.pdf';
        }else{
            $supervisor = '';
        }

        $file = File::exists('assets/uploads/procedimientos/recepcionistas-'.$id.'.pdf');

        if($file){
            $recepcionista = 'assets/uploads/procedimientos/recepcionistas-'.$id.'.pdf';
        }else{
            $recepcionista = '';
        }

        $file = File::exists('assets/uploads/procedimientos/instructores-'.$id.'.pdf');

        if($file){
            $instructor = 'assets/uploads/procedimientos/instructores-'.$id.'.pdf';
        }else{
            $instructor = '';
        }

        $file = File::exists('assets/uploads/procedimientos/administrativo-'.$id.'.pdf');

        if($file){
            $administrativo = 'assets/uploads/procedimientos/administrativo-'.$id.'.pdf';
        }else{
            $administrativo = '';
        }

        $file = File::exists('assets/uploads/procedimientos/ambiente-'.$id.'.pdf');

        if($file){
            $ambiente = 'assets/uploads/procedimientos/ambiente-'.$id.'.pdf';
        }else{
            $ambiente = '';
        }

        $file = File::exists('assets/uploads/procedimientos/roles-de-aplicacion-'.$id.'.pdf');

        if($file){
            $rol = 'assets/uploads/procedimientos/roles-de-aplicacion-'.$id.'.pdf';
        }else{
            $rol = '';
        }

        $file = File::exists('assets/uploads/procedimientos/guia-de-atencion-al-cliente-'.$id.'.pdf');

        if($file){
            $guia = 'assets/uploads/procedimientos/guia-de-atencion-al-cliente-'.$id.'.pdf';
        }else{
            $guia = '';
        }


        return view('configuracion.herramientas.procedimientos.principal')->with(['id' => $id, 'coordinacion' => $coordinacion, 'evento' => $evento, 'venta' => $venta, 'supervisor' => $supervisor, 'recepcionista' => $recepcionista, 'instructor' => $instructor, 'administrativo' => $administrativo, 'ambiente' => $ambiente, 'rol' => $rol, 'guia' => $guia]);
        
    }

    public function updateCoordinacion(Request $request){

        $rules = [

            'coordinacion' => 'mimes:pdf',

        ];

        $messages = [
            'coordinacion.mimes' => 'Ups! Solo se aceptan archivos PDF',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $academia = Academia::find(Auth::user()->academia_id);

            if($request->coordinacion){

                $extension = $request->coordinacion->getClientOriginalExtension();
                $nombre_archivo = 'coordinacion-de-pista-'.Auth::user()->academia_id.'.'.$extension;

                \Storage::disk('procedimientos')->put($nombre_archivo,  \File::get($request->coordinacion));

            }

            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

        }
    }

    public function updateEvento(Request $request){

        $rules = [

            'evento' => 'mimes:pdf',

        ];

        $messages = [
            'evento.mimes' => 'Ups! Solo se aceptan archivos PDF',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $academia = Academia::find(Auth::user()->academia_id);

            if($request->evento){

                $extension = $request->evento->getClientOriginalExtension();
                $nombre_archivo = 'productora-de-eventos-'.Auth::user()->academia_id.'.'.$extension;

                \Storage::disk('procedimientos')->put($nombre_archivo,  \File::get($request->evento));

            }

            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

        }
    }

    public function updateVenta(Request $request){

        $rules = [

            'venta' => 'mimes:pdf',

        ];

        $messages = [
            'venta.mimes' => 'Ups! Solo se aceptan archivos PDF',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $academia = Academia::find(Auth::user()->academia_id);

            if($request->venta){

                $extension = $request->venta->getClientOriginalExtension();
                $nombre_archivo = 'ventas-'.Auth::user()->academia_id.'.'.$extension;

                \Storage::disk('procedimientos')->put($nombre_archivo,  \File::get($request->venta));

            }

            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

        }
    }

    public function updateSupervisor(Request $request){

        $rules = [

            'supervisor' => 'mimes:pdf',

        ];

        $messages = [
            'supervisor.mimes' => 'Ups! Solo se aceptan archivos PDF',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $academia = Academia::find(Auth::user()->academia_id);

            if($request->supervisor){

                $extension = $request->supervisor->getClientOriginalExtension();
                $nombre_archivo = 'supervisores-'.Auth::user()->academia_id.'.'.$extension;

                \Storage::disk('procedimientos')->put($nombre_archivo,  \File::get($request->supervisor));

            }

            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

        }
    }

    public function updateRecepcionista(Request $request){

        $rules = [

            'recepcionista' => 'mimes:pdf',

        ];

        $messages = [
            'recepcionista.mimes' => 'Ups! Solo se aceptan archivos PDF',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $academia = Academia::find(Auth::user()->academia_id);

            if($request->recepcionista){

                $extension = $request->recepcionista->getClientOriginalExtension();
                $nombre_archivo = 'recepcionistas-'.Auth::user()->academia_id.'.'.$extension;

                \Storage::disk('procedimientos')->put($nombre_archivo,  \File::get($request->recepcionista));

            }

            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

        }
    }

    public function updateInstructor(Request $request){

        $rules = [

            'instructor' => 'mimes:pdf',

        ];

        $messages = [
            'instructor.mimes' => 'Ups! Solo se aceptan archivos PDF',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $academia = Academia::find(Auth::user()->academia_id);

            if($request->instructor){

                $extension = $request->instructor->getClientOriginalExtension();
                $nombre_archivo = 'instructores-'.Auth::user()->academia_id.'.'.$extension;

                \Storage::disk('procedimientos')->put($nombre_archivo,  \File::get($request->instructor));

            }

            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

        }
    }

    public function updateAdministrativoProcedimiento(Request $request){

        $rules = [

            'administrativo' => 'mimes:pdf',

        ];

        $messages = [
            'administrativo.mimes' => 'Ups! Solo se aceptan archivos PDF',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $academia = Academia::find(Auth::user()->academia_id);

            if($request->administrativo){

                $extension = $request->administrativo->getClientOriginalExtension();
                $nombre_archivo = 'administrativo-'.Auth::user()->academia_id.'.'.$extension;

                \Storage::disk('procedimientos')->put($nombre_archivo,  \File::get($request->administrativo));

            }

            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

        }
    }

    public function updateAmbiente(Request $request){

        $rules = [

            'ambiente' => 'mimes:pdf',

        ];

        $messages = [
            'ambiente.mimes' => 'Ups! Solo se aceptan archivos PDF',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $academia = Academia::find(Auth::user()->academia_id);

            if($request->ambiente){

                $extension = $request->ambiente->getClientOriginalExtension();
                $nombre_archivo = 'ambiente-'.Auth::user()->academia_id.'.'.$extension;

                \Storage::disk('procedimientos')->put($nombre_archivo,  \File::get($request->ambiente));

            }

            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

        }
    }

    public function updateRol(Request $request){

        $rules = [

            'rol' => 'mimes:pdf',

        ];

        $messages = [
            'rol.mimes' => 'Ups! Solo se aceptan archivos PDF',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $academia = Academia::find(Auth::user()->academia_id);

            if($request->rol){

                $extension = $request->rol->getClientOriginalExtension();
                $nombre_archivo = 'roles-de-aplicacion-'.Auth::user()->academia_id.'.'.$extension;

                \Storage::disk('procedimientos')->put($nombre_archivo,  \File::get($request->rol));

            }

            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

        }
    }

    public function updateGuia(Request $request){

        $rules = [

            'guia' => 'mimes:pdf',

        ];

        $messages = [
            'guia.mimes' => 'Ups! Solo se aceptan archivos PDF',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $academia = Academia::find(Auth::user()->academia_id);

            if($request->guia){

                $extension = $request->guia->getClientOriginalExtension();
                $nombre_archivo = 'guia-de-atencion-al-cliente-'.Auth::user()->academia_id.'.'.$extension;

                \Storage::disk('procedimientos')->put($nombre_archivo,  \File::get($request->guia));

            }

            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

        }
    }

}