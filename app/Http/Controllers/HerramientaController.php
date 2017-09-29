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
use App\ManualProcedimiento;
use App\HorarioVisitante;
use Validator;
use Carbon\Carbon;
use Storage;
use Session;
use Illuminate\Support\Facades\Auth;
use DB;
use Image;
use File;
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

    public function principal_procedimientos(){

        $procedimientos = ManualProcedimiento::where('academia_id',Auth::user()->academia_id)->get();

        return view('configuracion.herramientas.procedimientos.principal')->with(['procedimientos' => $procedimientos, 'id' => Auth::user()->academia_id]);
        
    }

    public function planilla_procedimientos(){

        $procedimientos = ManualProcedimiento::where('academia_id',Auth::user()->academia_id)->get();

        return view('configuracion.herramientas.procedimientos.planilla')->with(['procedimientos' => $procedimientos]);
        
    }

    public function agregarProcedimiento(Request $request){

        $rules = [
            'nombre' => 'required|min:1',
            'pdf' => 'required|mimes:pdf',
        ];

        $messages = [
            'nombre.required' => 'Ups! El Nombre es requerido',
            'pdf.required' => 'Ups! El PDF es requerido',
            'pdf.mimes' => 'Ups! Solo se aceptan archivos PDF',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $procedimiento = ManualProcedimiento::where('academia_id',Auth::user()->academia_id)->where('nombre',$request->nombre)->first();

            if(!$procedimiento){

                $procedimiento = new ManualProcedimiento;
                $procedimiento->nombre = $request->nombre;
                $procedimiento->academia_id = Auth::user()->academia_id;

                if($procedimiento->save()){

                    $extension = $request->pdf->getClientOriginalExtension();
                    $nombre_archivo = $request->nombre.'-'.Auth::user()->academia_id.'.'.$extension;

                    \Storage::disk('procedimientos')->put($nombre_archivo,  \File::get($request->pdf));

                    return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'procedimiento' => $procedimiento, 200]);
                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
                }
                
            }else{
                return response()->json(['errores' => ['nombre' => [0, 'Ups! Ya posee un manual de procedimientos con este nombre']], 'status' => 'ERROR'],422);
            }
        }
    }

    public function eliminarProcedimiento($id)
    {
        $procedimiento = ManualProcedimiento::find($id);
        $nombre = $procedimiento->nombre;
        
        if($procedimiento->delete()){

            \Storage::disk('procedimientos')->delete($nombre.'-'.Auth::user()->academia_id.'.pdf');
            return response()->json(['mensaje' => '¡Excelente! El Manual de procedimientos se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno");
    }

    public function actualizarProcedimiento(Request $request){

        $rules = [
            'nombre' => 'required|min:1',
            'pdf2' => 'required|mimes:pdf',
        ];

        $messages = [
            'nombre.required' => 'Ups! El Nombre es requerido',
            'pdf2.required' => 'Ups! El PDF es requerido',
            'pdf2.mimes' => 'Ups! Solo se aceptan archivos PDF',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $procedimiento = ManualProcedimiento::where('academia_id',Auth::user()->academia_id)
                ->where('nombre',$request->nombre)
                ->where('id','!=',$request->id)
            ->first();

            if(!$procedimiento){

                $procedimiento = ManualProcedimiento::find($request->id);

                $nombre_archivo_viejo = $procedimiento->nombre.'-'.Auth::user()->academia_id.'.pdf';

                $procedimiento->nombre = $request->nombre;
                $procedimiento->academia_id = Auth::user()->academia_id;

                if($procedimiento->save()){

                    File::delete("assets/uploads/procedimientos/".$nombre_archivo_viejo);

                    $extension = $request->pdf2->getClientOriginalExtension();
                    $nombre_archivo = $request->nombre.'-'.Auth::user()->academia_id.'.'.$extension;

                    \Storage::disk('procedimientos')->put($nombre_archivo,  \File::get($request->pdf2));

                    return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'procedimiento' => $procedimiento, 200]);
                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
                }
                
            }else{
                return response()->json(['errores' => ['nombre' => [0, 'Ups! Ya posee una normativa con este nombre']], 'status' => 'ERROR'],422);
            }
        }
    }

    public function principal_horarios(){

        $horarios = HorarioVisitante::where('academia_id',Auth::user()->academia_id)->get();
        $academia = Academia::find(Auth::user()->academia_id);
        $array = array();

        foreach($horarios as $horario){

            if($academia->tipo_horario == 2){
                $hora_inicio = Carbon::createFromFormat('H:i:s',$horario->hora_inicio)->toTimeString();
                $hora_final = Carbon::createFromFormat('H:i:s',$horario->hora_final)->toTimeString();
            }else{
                $hora_inicio = Carbon::createFromFormat('H:i:s',$horario->hora_inicio)->format('g:i a');
                $hora_final = Carbon::createFromFormat('H:i:s',$horario->hora_final)->format('g:i a');
            }

            $collection=collect($horario);     
            $horario_array = $collection->toArray();

            $horario_array['hora_inicio']=$hora_inicio;
            $horario_array['hora_final']=$hora_final;
            $array[] = $horario_array;
        }

        return view('configuracion.herramientas.horarios_visitantes_presenciales.principal')->with(['horarios' => $array, 'id' => Auth::user()->academia_id]);
        
    }

    public function agregarHorario(Request $request){

        $rules = [
            'nombre' => 'required|min:1',
            'hora_inicio' => 'required',
            'hora_final' => 'required',
        ];

        $messages = [
            'nombre.required' => 'Ups! El Nombre es requerido',
            'hora_inicio.required' => 'Ups! La hora de inicio es requerida',
            'hora_final.required' => 'Ups! La hora final es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $academia = Academia::find(Auth::user()->academia_id);

            if($academia->tipo_horario == 2){
                $hora_inicio = Carbon::createFromFormat('H:i',$request->hora_inicio)->toTimeString();
                $hora_final = Carbon::createFromFormat('H:i',$request->hora_final)->toTimeString();
            }else{
                $hora_inicio = Carbon::createFromFormat('H:i a',$request->hora_inicio)->toTimeString();
                $hora_final = Carbon::createFromFormat('H:i a',$request->hora_final)->toTimeString();
            }

            if($hora_inicio > $hora_final){
                return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
            }

            $horario = new HorarioVisitante;
            $horario->nombre = $request->nombre;
            $horario->academia_id = Auth::user()->academia_id;
            $horario->hora_inicio = $request->hora_inicio;
            $horario->hora_final = $request->hora_final;

            if($horario->save()){

                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'nombre' => $request->nombre, 'hora_inicio' => $request->hora_inicio, 'hora_final' => $request->hora_final, 'id' => $horario->id, 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
            }
           
        }
    }

    public function eliminarHorario($id)
    {
        $horario = HorarioVisitante::find($id);
        
        if($horario->delete()){
            return response()->json(['mensaje' => '¡Excelente! El registro se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno");
    }
}