<?php namespace App\Http\Controllers;

use App\Egreso;
use App\Taller;
use App\Campana;
use App\Patrocinador;
use App\Fiesta;
use App\Academia;
use App\ConfigEgreso;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Session;

class EgresoController extends BaseController {

	public function principal(){

        return view('administrativo.egresos.index');

    }

    public function generales()
    {
        $config_egresos = ConfigEgreso::all();

        $egresos = Egreso::Leftjoin('config_egresos', 'egresos.tipo' , '=', 'config_egresos.id')
            ->select('egresos.*', 'config_egresos.nombre as config_tipo')
            ->where('academia_id',Auth::user()->academia_id)
            ->where('tipo_id',Auth::user()->academia_id)
            ->where('tipo',1)
        ->get();

        $total = Egreso::Leftjoin('config_egresos', 'egresos.tipo' , '=', 'config_egresos.id')
            ->select('egresos.*', 'config_egresos.nombre as config_tipo')
            ->where('academia_id',Auth::user()->academia_id)
            ->where('tipo_id',Auth::user()->academia_id)
            ->where('tipo',1)
        ->sum('cantidad');

        return view('administrativo.egresos.generales')->with(['egresos' => $egresos, 'total' => $total, 'config_egresos' => $config_egresos, 'id' => Auth::user()->academia_id]);
          
    }

    public function fiestas()
    {
    	$academia = Academia::find(Auth::user()->academia_id);
        $usuario_tipo = Session::get('easydance_usuario_tipo');

        return view('administrativo.egresos.fiestas')->with(['fiestas' => Fiesta::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'usuario_tipo' => $usuario_tipo]);
    }

     public function talleres(){

     	$academia = Academia::find(Auth::user()->academia_id);
        $usuario_tipo = Session::get('easydance_usuario_tipo');

        $talleres = Taller::where('academia_id', '=' ,  Auth::user()->academia_id)->OrderBy('talleres.hora_inicio')->get();

        return view('administrativo.egresos.talleres')->with(['talleres' => $talleres, 'academia' => $academia, 'usuario_tipo' => $usuario_tipo]);
    }

    public function campanas(){

        $campanas = Campana::where('campanas.academia_id' , '=' , Auth::user()->academia_id)
            ->OrderBy('campanas.created_at')
        ->get();
        $usuario_tipo = Session::get('easydance_usuario_tipo');

        $array=array();
        $i = 0;
        $cantidad = 0;
        $total = 0;

        $academia = Academia::find(Auth::user()->academia_id);


        foreach($campanas as $campana){

            $recaudado = 0;
            $patrocinador_monto = 0;

            $patrocinadores = Patrocinador::where('tipo_evento_id', '=' ,  $campana->id)
                ->where('tipo_evento', '=', 1)
            ->get();

            foreach($patrocinadores as $patrocinador){

                if($patrocinador->tipo_moneda == 1){
                    $patrocinador_monto = $patrocinador->monto;
                }else{
                    $patrocinador_monto = $patrocinador->monto * 1000;
                }

                $recaudado = $recaudado + $patrocinador_monto;

            }
            
            $collection=collect($campana);     
            $campana_array = $collection->toArray();
            
            $campana_array['total']=$recaudado;
            $array[$campana->id] = $campana_array;
    
        }

        return view('administrativo.egresos.campanas')->with(['campanas' => $array, 'academia' => $academia, 'usuario_tipo' => $usuario_tipo]);

    }


    public function store(Request $request)
    {

        $rules = [
            'factura' => 'required',
            'config_tipo' => 'required',
            'proveedor' => 'required',
            'concepto' => 'required',
            'cantidad' => 'required',
        ];

        $messages = [

            'factura.required' => 'Ups! La factura es requerida ',
            'config_tipo.required' => 'Ups! El tipo es requerido',
            'proveedor.required' => 'Ups! El proveedor es requerido',
            'concepto.required' => 'Ups! El concepto es requerido',
            'cantidad.required' => 'Ups! La cantidad es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            if($request->fecha){
                $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);
            }else{
                $fecha = '';
            }

            $egreso = new Egreso;

            $egreso->academia_id = Auth::user()->academia_id;
            $egreso->factura = $request->factura;
            $egreso->config_tipo = $request->config_tipo;
            $egreso->proveedor = $request->proveedor;
            $egreso->concepto = $request->concepto;
            $egreso->cantidad = $request->cantidad;
            $egreso->fecha = $fecha;
            $egreso->hora = Carbon::now()->toTimeString();
            $egreso->nit = $request->nit;
            $egreso->tipo = $request->tipo;
            $egreso->tipo_id = $request->tipo_id;
            $egreso->administrador_id = Auth::user()->id;

            if($egreso->save()){
                
                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $egreso, 'fecha' => $fecha->toDateString(), 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateFactura(Request $request){

        $rules = [
            'factura' => 'required',
        ];

        $messages = [

            'factura.required' => 'Ups! La factura es requerida ',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $egreso = Egreso::find($request->id);
            $egreso->factura = $request->factura;

            if($egreso->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateTipo(Request $request){
   
        $egreso = Egreso::find($request->id);
        $egreso->config_tipo = $request->config_tipo;

        if($egreso->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        
    }

    public function updateProveedor(Request $request){

        $rules = [
            'proveedor' => 'required',
        ];

        $messages = [

            'proveedor.required' => 'Ups! El proveedor es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $egreso = Egreso::find($request->id);
            $egreso->proveedor = $request->proveedor;

            if($egreso->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateConcepto(Request $request){

        $rules = [
            'concepto' => 'required',
        ];

        $messages = [

            'concepto.required' => 'Ups! El concepto es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $egreso = Egreso::find($request->id);
            $egreso->concepto = $request->concepto;

            if($egreso->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateCantidad(Request $request){

        $rules = [
            'cantidad' => 'required',
        ];

        $messages = [

            'cantidad.required' => 'Ups! La cantidad es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $egreso = Egreso::find($request->id);
            $egreso->cantidad = $request->cantidad;

            if($egreso->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateFecha(Request $request){

        if($request->fecha){
            $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);
        }else{
            $fecha = '';
        }
   
        $egreso = Egreso::find($request->id);
        $egreso->fecha = $fecha;

        if($egreso->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        
    }

    public function updateNit(Request $request){
   
        $egreso = Egreso::find($request->id);
        $egreso->nit = $request->nit;

        if($egreso->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        
    }

    public function destroy(Request $request)
    {
        $academia = Academia::find(Auth::user()->academia_id);

        if($academia->password_supervision){
            if(!Hash::check($request->password_supervision, $academia->password_supervision)) {
                return response()->json(['error_mensaje'=> 'Ups! La contraseña no coincide', 'status' => 'ERROR-PASSWORD'],422);
            }
        }

        $egreso = Egreso::find($request->id);

        $cantidad = $egreso->cantidad;
        
        if($egreso->delete()){
            return response()->json(['mensaje' => '¡Excelente! La Fiesta o Evento se ha eliminado satisfactoriamente', 'status' => 'OK', 'cantidad' => $cantidad, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function edit($id)
    {   
        $egreso = Egreso::Leftjoin('config_egresos', 'egresos.tipo' , '=', 'config_egresos.id')
            ->select('egresos.*','config_egresos.nombre')
            ->where('egresos.id',$id)
        ->first();

        if($egreso){
            $config_egresos = ConfigEgreso::all();
            return view('administrativo.egresos.planilla')->with(['egreso' => $egreso, 'config_egresos' => $config_egresos, 'id' => $id]);
        }else{
           return redirect("administrativo/egresos"); 
        }
    }
}