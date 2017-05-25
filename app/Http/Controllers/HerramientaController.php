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
use App\ConfigSupervision;
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
        $niveles = ConfigNiveles::where('academia_id' , Auth::user()->academia_id)->get();
        $config_staff = ConfigStaff::where('academia_id' , Auth::user()->academia_id)->get();
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

}