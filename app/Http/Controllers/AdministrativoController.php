<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Alumno;
use App\AlumnoRemuneracion;
use App\Staff;
use App\Acuerdo;
use App\ItemsAcuerdo;
use App\Pago;
use App\Academia;
use App\Paises;
use App\Impuesto;
use App\Factura;
use App\FacturaProforma;
use App\ItemsFactura;
use App\ItemsFacturaProforma;
use App\Presupuesto;
use App\ItemsPresupuesto;
use App\ConfigProductos;
use App\ConfigServicios;
use App\ClaseGrupal;
use App\MercadopagoMovs;
use App\User;
use App\UsuarioTipo;
use App\UsuarioExterno;
use App\Familia;
use App\Paquete;
use App\CredencialAlumno;
use App\InscripcionClaseGrupal;
//use MP;
use Validator;
use Carbon\Carbon;
use Storage;
use Session;
use DB;
use Mail;
use Redirect;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\ConfigPagosStaff;
use App\PagoStaff;
use App\Transferencia;
use App\Sugerencia;
use App\Notificacion;
use App\NotificacionUsuario;

class AdministrativoController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    
	public function index()
	{
        $usuario_tipo = Session::get('easydance_usuario_tipo');
        $usuario_id = Session::get('easydance_usuario_id');

        if($usuario_tipo == 2 OR $usuario_tipo == 4)
        {


            $factura_join = Factura::join('alumnos', 'facturas.usuario_id', '=', 'alumnos.id')
                ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'facturas.numero_factura as factura', 'facturas.fecha as fecha', 'facturas.id', 'facturas.concepto')
                ->where('facturas.usuario_id' , '=' , $usuario_id)
                ->OrderBy('facturas.created_at')
            ->get();

            $array=array();

            foreach($factura_join as $factura){


                $total = ItemsFactura::where('factura_id', '=' ,  $factura->id)->sum('importe_neto');
                $collection=collect($factura);     
                $factura_array = $collection->toArray();
                
                $factura_array['total']=$total;
                $array[$factura->id] = $factura_array;

            }

            $proforma_join = ItemsFacturaProforma::join('alumnos', 'items_factura_proforma.usuario_id', '=', 'alumnos.id')
                ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'items_factura_proforma.fecha_vencimiento as fecha_vencimiento', 'items_factura_proforma.id', 'items_factura_proforma.importe_neto as total', 'items_factura_proforma.nombre as concepto', 'items_factura_proforma.cantidad')
                ->where('items_factura_proforma.usuario_id' , '=' , $usuario_id)
            ->get();

            $total = ItemsFacturaProforma::join('alumnos', 'items_factura_proforma.usuario_id', '=', 'alumnos.id')
                ->where('items_factura_proforma.usuario_id', $usuario_id)
                ->where('alumnos.deleted_at' , '=' , null)
            ->sum('items_factura_proforma.importe_neto');

            $fecha_vencimiento = null;
            $primera_fecha = false;

            foreach($proforma_join as $proforma){
                $fecha = Carbon::createFromFormat('Y-m-d',$proforma->fecha_vencimiento);

                if($fecha > Carbon::now() && $primera_fecha == false){
                    $primera_fecha = true;
                    $fecha_vencimiento = $fecha;
                }

                if($fecha < $fecha_vencimiento && $fecha > Carbon::now()){
                    $fecha_vencimiento = $fecha;
                }
            }

            if($fecha_vencimiento){
                $fecha_vencimiento = $fecha_vencimiento->format('d-m-Y');
            }



            return view('vista_alumno.administrativo.administrativo')->with(['facturas'=> $array, 'proforma' => $proforma_join, 'total' => $total, 'fecha_vencimiento' => $fecha_vencimiento]); 
        }else{
            return redirect("/"); 
        }                   
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */

    public function prueba1()
    {
        return view('administrativo.pagosubscripcion1');
    }

    public function prueba2()
    {
        return view('administrativo.pagosubscripcion2');
    }

    public function prueba3()
    {
        return view('administrativo.pagosubscripcion3');
    }

    public function principalpagos()
    {

        $array_factura = array();
        $array_proforma = array();

        // $factura_join = DB::table('facturas')
        //     ->Leftjoin('alumnos', 'facturas.alumno_id', '=', 'alumnos.id')
        //     ->Leftjoin('usuario_externos','facturas.externo_id', '=', 'usuario_externos.id')
        //     // ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'facturas.numero_factura as factura', 'facturas.fecha as fecha', 'facturas.id', 'facturas.concepto')
        //     ->selectRaw('IF(alumnos.nombre is null AND alumnos.apellido is null, usuario_externos.nombre, CONCAT(alumnos.nombre, " " , alumnos.apellido)) as nombre, facturas.numero_factura as factura, facturas.fecha as fecha, facturas.id, facturas.concepto')
        //     ->where('facturas.academia_id' , '=' , Auth::user()->academia_id)
        //     ->OrderBy('facturas.created_at')
        // ->get();

        // $patrocinadores = DB::table('patrocinadores')
        //      ->Leftjoin('alumnos', 'patrocinadores.usuario_id', '=', 'alumnos.id')
        //      ->Leftjoin('usuario_externos','patrocinadores.externo_id', '=', 'usuario_externos.id')
        //      //->select('patrocinadores.*', 'alumnos.nombre', 'alumnos.apellido', 'alumnos.id')
        //      ->selectRaw('patrocinadores.*, IF(alumnos.nombre is null AND alumnos.apellido is null, usuario_externos.nombre, CONCAT(alumnos.nombre, " " , alumnos.apellido)) as Nombres, IF(alumnos.sexo is null, usuario_externos.sexo, alumnos.sexo) as sexo, alumnos.id')
        //      ->where('patrocinadores.campana_id', '=', $id)
        //      ->orderBy('patrocinadores.monto', 'desc')
        //  ->get();

        $facturas = Factura::where('academia_id' , '=' , Auth::user()->academia_id)
            ->OrderBy('created_at', 'desc')
            ->limit(150)
        ->get();

        foreach($facturas as $factura){

            $tipos_pago = Pago::join('formas_pago', 'pagos.forma_pago', '=', 'formas_pago.id')
                ->where('factura_id', $factura->id)
            ->get();

            $pago = '';

            if($tipos_pago){

                foreach($tipos_pago as $tipo_pago){

                    if(!$pago){
                        $pago = $tipo_pago->nombre;
                    }
                    
                }

            }else{
                $pago = 'Efectivo';
            }

            $total = ItemsFactura::where('factura_id', '=' ,  $factura->id)->sum('importe_neto');

            if($factura->usuario_tipo == 1){
                $usuario = Alumno::withTrashed()->find($factura->usuario_id);

            }else{
                $usuario = Staff::withTrashed()->find($factura->usuario_id);
            }

            if($usuario){

                $collection=collect($factura);     
                $factura_array = $collection->toArray();
                
                $factura_array['nombre'] = $usuario->nombre . ' '. $usuario->apellido;
                $factura_array['total']=$total;
                $factura_array['tipo_pago']=$pago;
                $array_factura[$factura->id] = $factura_array;
            }

        }

        $proformas = ItemsFacturaProforma::where('academia_id' , '=' , Auth::user()->academia_id)
        ->get();

        foreach($proformas as $proforma){

            if($proforma->usuario_tipo == 1){
                $usuario = Alumno::withTrashed()->find($proforma->usuario_id);

            }else{
                $usuario = Staff::withTrashed()->find($proforma->usuario_id);
            }

            $collection=collect($proforma);     
            $proforma_array = $collection->toArray();
            
            $proforma_array['nombre']= $usuario->nombre . ' '. $usuario->apellido;
            $array_proforma[$proforma->id] = $proforma_array;

        }

        $total = ItemsFacturaProforma::where('academia_id', Auth::user()->academia_id)->sum('importe_neto');

        return view('administrativo.pagos.principal')->with(['facturas'=> $array_factura, 'proformas' => $array_proforma, 'total' => $total]);
    }

	public function generarpagos()
	{
     
        $academia = Academia::find(Auth::user()->academia_id);

        if (Session::has('arreglo')) {
            Session::forget('arreglo'); 
        }

        if (Session::has('pagos')) {
            Session::forget('pagos'); 
        }

        if (Session::has('id_proforma')) {
            Session::forget('id_proforma'); 
        }

        if (Session::has('gestion')) {
            Session::forget('gestion'); 
        }

        $servicios_productos = array();

        $config_servicio=ConfigServicios::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre','asc')->get();

        foreach($config_servicio as $servicio){

            $iva = $servicio['costo'] * ($academia->porcentaje_impuesto / 100);

            $servicios_productos['1-'.$servicio->id]=array('id' => $servicio['id'], 'nombre' => $servicio['nombre'] , 'costo' => $servicio['costo'], 'iva' => $iva, 'incluye_iva' => $servicio['incluye_iva'], 'tipo' => $servicio['tipo'], 'disponibilidad' => 0, 'servicio_producto' => 1);

        }

        $config_producto=ConfigProductos::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre','asc')->get();

        foreach($config_producto as $producto){

            $iva = $producto['costo'] * ($academia->porcentaje_impuesto / 100);
            $servicios_productos['2-'.$producto->id]=array('id' => $producto['id'], 'nombre' => $producto['nombre'] , 'costo' => $producto['costo'], 'iva' => $iva, 'incluye_iva' => $producto['incluye_iva'], 'disponibilidad' => $producto['cantidad'], 'tipo' => $producto['tipo'], 'servicio_producto' => 2);

        }

        $proforma_join = ItemsFacturaProforma::join('alumnos', 'items_factura_proforma.usuario_id', '=', 'alumnos.id')
            ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'items_factura_proforma.fecha_vencimiento as fecha_vencimiento', 'items_factura_proforma.id', 'items_factura_proforma.importe_neto as total', 'items_factura_proforma.nombre as concepto', 'items_factura_proforma.cantidad')
            ->where('items_factura_proforma.academia_id' , '=' , Auth::user()->academia_id)
            ->where('alumnos.deleted_at' , '=' , null)
        ->get();

        $array = array();

        $alumnos = Alumno::withTrashed()->where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

        foreach($alumnos as $alumno)
        {
            $total = ItemsFacturaProforma::where('usuario_id', $alumno->id)->where('usuario_tipo',1)->sum('importe_neto');

            if(!$total){
                $total = 0;
            }

            $deuda = ItemsFacturaProforma::where('fecha_vencimiento','<=',Carbon::today())
                ->where('usuario_id','=',$alumno->id)
                ->where('usuario_tipo',1)
            ->first();

            $collection=collect($alumno);     
            $alumno_array = $collection->toArray();
            
            $alumno_array['id']='1-'.$alumno->id;
            $alumno_array['deuda']=$deuda;
            $alumno_array['total']=$total;
            $array['1-'.$alumno->id] = $alumno_array;
        }

        $staffs = Staff::withTrashed()->where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

        foreach($staffs as $staff)
        {
            $total = ItemsFacturaProforma::where('usuario_id', $staff->id)->where('usuario_tipo',2)->sum('importe_neto');

            if(!$total){
                $total = 0;
            }

            $deuda = ItemsFacturaProforma::where('fecha_vencimiento','<=',Carbon::today())
                ->where('usuario_id','=',$staff->id)
                ->where('usuario_tipo',2)
            ->first();

            $collection=collect($staff);     
            $staff_array = $collection->toArray();

            $staff_array['id']='2-'.$staff->id;
            $staff_array['identificacion']='';
            $staff_array['deuda']=$deuda;
            $staff_array['total']=$total;
            $array['2-'.$staff->id] = $staff_array;
        }

		return view('administrativo.pagos.pagos')->with(['usuarios' => $array, 'servicios_productos' => $servicios_productos, 'impuesto' => $academia->porcentaje_impuesto]);
	}

    public function generarpagoscondeuda($id)
    {
    
        $academia = Academia::find(Auth::user()->academia_id);

        if (Session::has('arreglo')) {
            Session::forget('arreglo'); 
        }

        if (Session::has('pagos')) {
            Session::forget('pagos'); 
        }

        if (Session::has('id_proforma')) {
            Session::forget('id_proforma'); 
        }

        if (Session::has('gestion')) {
            Session::forget('gestion'); 
        }

        $servicios_productos = array();

        $config_servicio=ConfigServicios::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre','asc')->get();

        foreach($config_servicio as $servicio){

            $iva = $servicio['costo'] * ($academia->porcentaje_impuesto / 100);

            $servicios_productos['1-'.$servicio->id]=array('id' => $servicio['id'], 'nombre' => $servicio['nombre'] , 'costo' => $servicio['costo'], 'iva' => $iva, 'incluye_iva' => $servicio['incluye_iva'], 'tipo' => $servicio['tipo'], 'disponibilidad' => 0, 'servicio_producto' => 1);

        }

        $config_producto=ConfigProductos::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre','asc')->get();

        foreach($config_producto as $producto){

            $iva = $producto['costo'] * ($academia->porcentaje_impuesto / 100);
            $servicios_productos['2-'.$producto->id]=array('id' => $producto['id'], 'nombre' => $producto['nombre'] , 'costo' => $producto['costo'], 'iva' => $iva, 'incluye_iva' => $producto['incluye_iva'], 'disponibilidad' => $producto['cantidad'], 'tipo' => $producto['tipo'], 'servicio_producto' => 2);

        }

        $alumnos = Alumno::withTrashed()->where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

        foreach($alumnos as $alumno)
        {
            $total = ItemsFacturaProforma::where('usuario_id', $alumno->id)->where('usuario_tipo',1)->sum('importe_neto');

            if(!$total){
                $total = 0;
            }

            $deuda = ItemsFacturaProforma::where('fecha_vencimiento','<=',Carbon::today())
                ->where('usuario_id','=',$alumno->id)
                ->where('usuario_tipo',1)
            ->first();

            $collection=collect($alumno);     
            $alumno_array = $collection->toArray();
            
            $alumno_array['id']='1-'.$alumno->id;
            $alumno_array['deuda']=$deuda;
            $alumno_array['total']=$total;
            $array['1-'.$alumno->id] = $alumno_array;
        }

        $staffs = Staff::withTrashed()->where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

        foreach($staffs as $staff)
        {
            $total = ItemsFacturaProforma::where('usuario_id', $staff->id)->where('usuario_tipo',2)->sum('importe_neto');

            if(!$total){
                $total = 0;
            }

            $deuda = ItemsFacturaProforma::where('fecha_vencimiento','<=',Carbon::today())
                ->where('usuario_id','=',$staff->id)
                ->where('usuario_tipo',2)
            ->first();

            $collection=collect($staff);     
            $staff_array = $collection->toArray();

            $staff_array['id']='2-'.$staff->id;
            $staff_array['identificacion']='';
            $staff_array['deuda']=$deuda;
            $staff_array['total']=$total;
            $array['2-'.$staff->id] = $staff_array;
        }

        return view('administrativo.pagos.pagos')->with(['usuarios' => $array, 'servicios_productos' => $servicios_productos, 'impuesto' => $academia->porcentaje_impuesto, 'id' => $id]);
    }

    public function gestion(Request $request)
    {

        if (Session::has('gestion')) {
            Session::forget('gestion'); 
        }

        if (Session::has('id_proforma')) {
            Session::forget('id_proforma'); 
        }

        $subtotal = 0;
        $impuesto = 0;
        $total = 0;

        $items_factura = explode(",", $request->items_factura);

        if($request->usuario_id == ''){
            return response()->json(['errores' => ['usuario_id' => [0, 'Ups! El Cliente es requerido']], 'status' => 'ERROR'],422);
        }

        $explode = explode("-", $request->usuario_id);
        $usuario_tipo = $explode[0];
        $usuario_id = $explode[1];

        if($request->items_factura == ''){

            $items_factura = ItemsFacturaProforma::where('usuario_id', '=', $usuario_id)->where('usuario_tipo', '=', $usuario_tipo)->get();

            if($items_factura){

                foreach($items_factura as $item){

                    $total = $total + $item->importe_neto;
                    Session::push('id_proforma', $item->id);
                
                } 

            }else{

                return response()->json(['errores' => ['combo' => [0, 'Debe seleccionar un item a pagar primero']], 'status' => 'ERROR'],422);
            }

        }else{

            foreach($items_factura as $id){

                $item_factura = ItemsFacturaProforma::where('id', '=', $id)->first();

                if($item_factura){

                    $total = $total + $item_factura->importe_neto;
                    Session::push('id_proforma', $item_factura->id);
                }
 
            }
        }

        $explode = explode("-", $request->usuario_id);
        $usuario_tipo = $explode[0];
        $usuario_id = $explode[1];

        $array = array(['total' => $total, 'usuario_id' => $usuario_id, 'usuario_tipo' => $usuario_tipo]);
        Session::put('gestion', $array);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function gestionar(Request $request){

        if (Session::has('pagos')) {
            Session::forget('pagos'); 
        }

        if (Session::has('puntos_referidos')) {
            Session::forget('puntos_referidos'); 
        }

        $academia = Academia::find(Auth::user()->academia_id);

        $factura = Factura::orderBy('created_at', 'desc')
            ->where('academia_id', '=', Auth::user()->academia_id)
        ->first();

        $formas_pago = DB::table('formas_pago')->get();

        if($factura){

            $tmp = $factura->numero_factura + 1;
            $numero_factura =  str_pad($tmp, 10, "0", STR_PAD_LEFT);
        }
        else{

            if($academia->numero_factura){
                $tmp = $academia->numero_factura;
                $numero_factura =  str_pad($tmp, 10, "0", STR_PAD_LEFT);
            }
            else{
                $tmp = 1;
                $numero_factura =  str_pad($tmp, 10, "0", STR_PAD_LEFT);
            }
            
        }

        $arreglo = Session::get('gestion');

        $usuario_id = $arreglo[0]['usuario_id'];
        $usuario_tipo = $arreglo[0]['usuario_tipo'];

        if($usuario_tipo == 1){
            $usuario = Alumno::withTrashed()->find($usuario_id);

            $alumno_remuneracion = AlumnoRemuneracion::where('alumno_id', $usuario_id)->first();
            if($alumno_remuneracion){
                $puntos_referidos = $alumno_remuneracion->remuneracion;
            }else{
                $puntos_referidos = 0;
            }

        }else{
            $usuario = Staff::withTrashed()->find($usuario_id);
            $puntos_referidos = 0;
        }
        
        $total = $arreglo[0]['total'];

        $acuerdo = ItemsFacturaProforma::where('usuario_id', '=', $usuario_id)
            ->where('tipo' , '=', 6)
            ->where('usuario_tipo' , '=', $usuario_tipo)
        ->count();

        return view('administrativo.pagos.gestion')->with(['total' => $total, 'numero_factura' => $numero_factura , 'formas_pago' => $formas_pago, 'usuario' => $usuario , 'porcentaje_impuesto' => $academia->porcentaje_impuesto, 'acuerdo' => $acuerdo, 'puntos_referidos' => $puntos_referidos, 'usuario_tipo' => $usuario_tipo, 'usuario_id' => $usuario_id]);

    }

    public function gestionardeuda($id){

        if (Session::has('pagos')) {
            Session::forget('pagos'); 
        }

        if (Session::has('id_proforma')) {
            Session::forget('id_proforma'); 
        }

        if (Session::has('puntos_referidos')) {
            Session::forget('puntos_referidos'); 
        }
        
        $academia = Academia::find(Auth::user()->academia_id);
        $factura = Factura::orderBy('created_at', 'desc')
            ->where('academia_id', '=', Auth::user()->academia_id)
        ->first();

        $formas_pago = DB::table('formas_pago')->get();

        if($factura){

            $tmp = $factura->numero_factura + 1;
            $numero_factura =  str_pad($tmp, 10, "0", STR_PAD_LEFT);
        }
        else{

            if($academia->numero_factura){
                $tmp = $academia->numero_factura;
                $numero_factura =  str_pad($tmp, 10, "0", STR_PAD_LEFT);
            }
            else{
                $tmp = 1;
                $numero_factura =  str_pad($tmp, 10, "0", STR_PAD_LEFT);
            }
            
        }

        $factura_proforma = ItemsFacturaProforma::find($id);

        $usuario_id = $factura_proforma->usuario_id;
        $usuario_tipo = $factura_proforma->usuario_tipo;

        if($usuario_tipo == 1){
            $usuario = Alumno::withTrashed()->find($usuario_id);

            $alumno_remuneracion = AlumnoRemuneracion::where('alumno_id', $usuario_id)->first();

            if($alumno_remuneracion){
                $puntos_referidos = $alumno_remuneracion->remuneracion;
            }else{
                $puntos_referidos = 0;
            }

        }else{
            $usuario = Staff::withTrashed()->find($usuario_id);
            $puntos_referidos = 0;
        }

        $total = $factura_proforma->importe_neto;

        $acuerdo = ItemsFacturaProforma::where('usuario_id', '=', $usuario_id)
            ->where('tipo' , '=', 6)
            ->where('usuario_tipo' , '=', $usuario_tipo)
        ->count();
   
        Session::push('id_proforma', $id);

        return view('administrativo.pagos.gestion')->with(['total' => $total, 'numero_factura' => $numero_factura , 'formas_pago' => $formas_pago, 'usuario' => $usuario , 'porcentaje_impuesto' => $academia->porcentaje_impuesto, 'puntos_referidos' => $puntos_referidos, 'usuario_tipo' => $usuario_tipo, 'usuario_id' => $usuario_id, 'acuerdo' => $acuerdo]);

    }

    public function agregarpago(Request $request){

        
    $rules = [

        'forma_pago_id' => 'required',
        'monto' => 'required|min:1',
    ];

    $messages = [

        'forma_pago_id.required' => 'Ups! La forma de pago es requerida',
        'monto.required' => 'Ups! El Monto es invalido, solo se aceptan numeros',
        'monto.min' => 'El mínimo de cantidad permitida es 1',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $monto = str_replace(',', '', $request->monto);

        if($request->forma_pago_id == 4){
            $alumno_remuneracion = AlumnoRemuneracion::where('alumno_id',$request->usuario_id)->first();
            if($alumno_remuneracion){
                $puntos_referidos = Session::get('puntos_referidos');
                $puntos_totales = $alumno_remuneracion->remuneracion - $puntos_referidos;
                if($puntos_totales >= $monto){
                    $puntos_referidos = $puntos_referidos + $monto;
                    Session::put('puntos_referidos', $puntos_referidos);
                }else{
                    return response()->json(['errores' => ['monto' => [0, 'Ups! No tienes suficientes puntos acumulados']], 'status' => 'ERROR'],422);
                }
            }else{
                return response()->json(['errores' => ['monto' => [0, 'Ups! No tienes suficientes puntos acumulados']], 'status' => 'ERROR'],422);
            }
        }

        $forma_pago = DB::table('formas_pago')
        ->where('id' , '=' , $request->forma_pago_id)
        ->first();

        $array = array(['forma_pago' => $request->forma_pago_id , 'banco' => $request->banco, 'referencia' => $request->referencia, 'monto' => $monto]);

        Session::push('pagos', $array);

        $array2 = array(['forma_pago' => $forma_pago->nombre , 'banco' => $request->banco, 'referencia' => $request->referencia, 'monto' => $monto]);

        $items = Session::get('pagos');
        end( $items );
        $contador = key( $items );

         return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array2, 'id' => $contador, 200]);

        }
    }

    public function eliminarpago($id){

        $arreglo = Session::get('pagos');
        $monto = $arreglo[$id][0]['monto'];
        $forma_pago = $arreglo[$id][0]['forma_pago'];

        if($forma_pago == 4){

            $puntos_referidos = Session::get('puntos_referidos');
            $puntos_referidos = $puntos_referidos - $monto;
            Session::put('puntos_referidos', $puntos_referidos);
               
        }

        unset($arreglo[$id]);
        Session::put('pagos', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'monto' => $monto, 'forma_pago' => $forma_pago, 200]);

    }

    public function eliminardeuda($id)
    {

        $factura_proforma = ItemsFacturaProforma::find($id);
        
        if($factura_proforma->delete()){
            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno");
    }

    public function CancelarGestion()
    {   
        if (Session::has('pagos')) {

            Session::forget('pagos');
            return response()->json(['status' => 'OK', 200]);  
        }
        else
        {
            return response()->json(['status' => 'OK', 200]);
        }
    }

    public function storeFactura(Request $request)
    {
       
        if (Session::has('pagos')) {
           
            $arreglo = Session::get('pagos');

            if (count($arreglo) == 0){

                return response()->json(['errores' => ['linea' => [0, 'Ups! ha ocurrido un error, debes agregar una linea de pago']], 'status' => 'ERROR'],422);

            }

             if($request->usuario_tipo == 1){
                $usuario = Alumno::withTrashed()->find($request->usuario_id);

            }else{
                $usuario = Staff::withTrashed()->find($request->usuario_id);
            }
     
            $total_proforma = $request->total;
            $total_pago = 0;

            $numerofactura = Factura::orderBy('created_at', 'desc')
                ->where('facturas.academia_id', '=', Auth::user()->academia_id)
            ->first();

            if($numerofactura){
               $tmp = $numerofactura->numero_factura + 1;
               $numero_factura =  str_pad($tmp, 10, "0", STR_PAD_LEFT);
            }
            else
            {
                $academia = Academia::find(Auth::user()->academia_id);
                if($academia->numero_factura){
                    $tmp = $academia->numero_factura;
                    $numero_factura =  str_pad($tmp, 10, "0", STR_PAD_LEFT);
                }
                else{
                    $tmp = 1;
                    $numero_factura =  str_pad($tmp, 10, "0", STR_PAD_LEFT);
                }
            }

            $id_proforma = Session::get('id_proforma');
            $contador = count($id_proforma);

            $id = $id_proforma[0];
            $item_proforma = ItemsFacturaProforma::where('id', '=', $id)->first();

            if($contador > 1){
                $concepto = $item_proforma->cantidad . ' ' . $item_proforma->nombre . '...';
            }
            else{
                $concepto = $item_proforma->cantidad . ' ' . $item_proforma->nombre;
            }

            $factura = new Factura;

            $factura->usuario_id = $request->usuario_id;
            $factura->usuario_tipo = $request->usuario_tipo;
            $factura->academia_id = Auth::user()->academia_id;
            $factura->fecha = Carbon::now()->toDateString();
            $factura->hora = Carbon::now()->toTimeString();
            $factura->numero_factura = $numero_factura;
            $factura->concepto = $concepto;
           
            if($factura->save()){

                $factura_id = $factura->id;

                //CREAR PAGOS Y GUARDAR EL TOTAL DE LA FACTURA

                for($i = 0; $i < count($arreglo) ; $i++)
                {

                    $forma_pago = $arreglo[$i][0]['forma_pago'];
                    $banco = $arreglo[$i][0]['banco'];
                    $referencia = $arreglo[$i][0]['referencia'];
                    $monto = $arreglo[$i][0]['monto'];


                    if($forma_pago == 4){
                        $alumno_remuneracion = AlumnoRemuneracion::where('alumno_id', $request->id)->first();
                        $alumno_remuneracion->remuneracion = $alumno_remuneracion->remuneracion - $monto;
                        $alumno_remuneracion->save();
                    }
                
                    $pago = new Pago;

                    $pago->academia_id = Auth::user()->academia_id;
                    $pago->fecha = Carbon::now()->toDateString();
                    $pago->factura_id = $factura->id;
                    $pago->monto = $monto;
                    $pago->referencia = $referencia;
                    $pago->forma_pago = $forma_pago;
                    $pago->banco = $banco;
                    
                    $pago->save();

                    $total_pago = $total_pago + $monto;

                }

                //SI SE PAGO TODA LA FACTURA

                if($total_proforma <= $total_pago)
                {

                    for($i = 0; $i < $contador ; $i++)
                    {
                        $id = $id_proforma[$i];

                        $item_proforma = ItemsFacturaProforma::where('id', '=', $id)->first();

                        if($item_proforma){

                            $tipo = $item_proforma->tipo;

                            if($item_proforma->tipo == 6){

                                $acuerdo = Acuerdo::find($item_proforma->item_id);
                                if($acuerdo){

                                    $fecha_vencimiento = Carbon::createFromFormat('Y-m-d', $item_proforma->fecha_vencimiento);
                                    $fecha_limite = $fecha_vencimiento->addDays($acuerdo->tiempo_tolerancia);

                                    if($fecha_limite < Carbon::now())
                                    {
                                        $mora = ($item_proforma->importe_neto * $acuerdo->porcentaje_retraso)/100;

                                        $item_factura = new ItemsFacturaProforma;
                                                                                    
                                        $item_factura->usuario_id = $request->usuario_id;
                                        $item_factura->usuario_tipo = $request->usuario_tipo;
                                        $item_factura->academia_id = Auth::user()->academia_id;
                                        $item_factura->fecha = Carbon::now()->toDateString();
                                        $item_factura->item_id = $item_proforma->item_id;
                                        $item_factura->nombre = 'Retraso de pago ' .  $item_proforma->nombre;
                                        $item_factura->tipo = $tipo;
                                        $item_factura->cantidad = 1;
                                        $item_factura->importe_neto = $mora;
                                        $item_factura->fecha_vencimiento = Carbon::now()->toDateString();

                                        $item_factura->save();
                                    }
                                }
                            }
                            else if($item_proforma->tipo == 3 OR $item_proforma->tipo == 4){

                                if($factura->usuario_tipo == 1){

                                    $inscripcion_clase_grupal = ClaseGrupal::withTrashed()->join('inscripcion_clase_grupal', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
                                        ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                                        ->join('config_servicios', 'config_servicios.tipo_id', '=', 'config_clases_grupales.id')
                                        ->select('inscripcion_clase_grupal.instructor_id as staff_id', 'config_servicios.id as servicio_id', 'config_servicios.tipo as tipo_servicio')
                                        ->where('inscripcion_clase_grupal.alumno_id', $request->usuario_id)
                                        ->where('config_servicios.tipo_id',$item_proforma->item_id)
                                        ->where('config_servicios.tipo',$item_proforma->tipo)
                                    ->first();

                                    if($inscripcion_clase_grupal){

                                        $config_pago = ConfigPagosStaff::where('servicio_id',$inscripcion_clase_grupal->servicio_id)
                                            ->where('tipo_servicio',$inscripcion_clase_grupal->tipo_servicio)
                                            ->where('staff_id',$inscripcion_clase_grupal->staff_id)
                                        ->first();

                                        if($config_pago){

                                            if($config_pago->tipo == 1){

                                                $porcentaje = $config_pago->monto / 100;
                                                $monto = $item_proforma->importe_neto * $porcentaje;

                                                if($monto > 0 ){

                                                    $pago = new PagoStaff;

                                                    $pago->staff_id=$inscripcion_clase_grupal->staff_id;
                                                    $pago->tipo=$config_pago->tipo;
                                                    $pago->monto=$monto;
                                                    $pago->servicio_id=$inscripcion_clase_grupal->servicio_id;

                                                    $pago->save();
                                                }
                                               
                                            }else{

                                                $pago = new PagoStaff;

                                                $pago->staff_id=$inscripcion_clase_grupal->staff_id;
                                                $pago->tipo=$config_pago->tipo;
                                                $pago->monto=$config_pago->monto;
                                                $pago->servicio_id=$inscripcion_clase_grupal->servicio_id;

                                                $pago->save();
                                                
                                            }
                                        }
                                    }
                                }   
                            }
                            else if ($item_proforma->tipo == 15) {

                                if($factura->usuario_tipo == 1){

                                    $servicio = ConfigServicios::withTrashed()->find($item_proforma->item_id);
                                    $paquete = Paquete::withTrashed()->find($servicio->tipo_id);

                                    $credencial = new CredencialAlumno;

                                    $credencial->cantidad = $paquete->cantidad_clases_grupales;
                                    $credencial->alumno_id = $request->usuario_id;

                                    $credencial->save();
                                }
                            }
                            
                            $item_factura = new ItemsFactura;

                            $item_factura->factura_id = $factura_id;
                            $item_factura->item_id = $item_proforma->item_id;
                            $item_factura->nombre = $item_proforma->nombre;
                            $item_factura->tipo = $item_proforma->tipo;
                            $item_factura->cantidad = $item_proforma->cantidad;
                            $item_factura->precio_neto = $item_proforma->precio_neto;
                            $item_factura->impuesto = $item_proforma->impuesto;
                            $item_factura->importe_neto = $item_proforma->importe_neto;

                            $item_factura->save();

                            $item_proforma = ItemsFacturaProforma::find($id)->delete();
                            
                        }
                    }
                }else{

                    for($i = 0; $i < $contador ; $i++)
                    {
                        $id = $id_proforma[$i];

                        $item_proforma = ItemsFacturaProforma::find($id);

                        $tipo = $item_proforma->tipo;

                        if($item_proforma->tipo == 6){

                            $acuerdo = Acuerdo::find($item_proforma->item_id);

                            if($acuerdo){
                                $fecha_vencimiento = Carbon::createFromFormat('Y-m-d', $item_proforma->fecha_vencimiento);
                                $fecha_limite = $fecha_vencimiento->addDays($acuerdo->tiempo_tolerancia);

                                if($fecha_limite < Carbon::now())
                                {
                                    $mora = ($item_proforma->importe_neto * $acuerdo->porcentaje_retraso)/100;

                                    $item_factura = new ItemsFacturaProforma;
                                                                                
                                    $item_factura->usuario_id = $request->usuario_id;
                                    $item_factura->usuario_tipo = $request->usuario_tipo;
                                    $item_factura->academia_id = Auth::user()->academia_id;
                                    $item_factura->fecha = Carbon::now()->toDateString();
                                    $item_factura->item_id = $item_proforma->item_id;
                                    $item_factura->nombre = 'Retraso de pago ' .  $item_proforma->nombre;
                                    $item_factura->tipo = $tipo;
                                    $item_factura->cantidad = 1;
                                    $item_factura->importe_neto = $mora;
                                    $item_factura->fecha_vencimiento = Carbon::now()->toDateString();

                                    $item_factura->save();
                                }
                            }

                        }
                        else if($item_proforma->tipo == 3 OR $item_proforma->tipo == 4){

                            if($factura->usuario_tipo == 1){

                                $inscripcion_clase_grupal = ClaseGrupal::withTrashed()->join('inscripcion_clase_grupal', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
                                    ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                                    ->join('config_servicios', 'config_servicios.tipo_id', '=', 'config_clases_grupales.id')
                                    ->select('inscripcion_clase_grupal.instructor_id as staff_id', 'config_servicios.id as servicio_id', 'config_servicios.tipo as tipo_servicio')
                                    ->where('inscripcion_clase_grupal.alumno_id', $request->usuario_id)
                                    ->where('config_servicios.tipo_id',$item_proforma->item_id)
                                    ->where('config_servicios.tipo',$item_proforma->tipo)
                                ->first();

                                if($inscripcion_clase_grupal){

                                    $config_pago = ConfigPagosStaff::where('servicio_id',$inscripcion_clase_grupal->servicio_id)
                                        ->where('tipo_servicio',$inscripcion_clase_grupal->tipo_servicio)
                                        ->where('staff_id',$inscripcion_clase_grupal->staff_id)
                                    ->first();

                                    if($config_pago){

                                        if($config_pago->tipo == 1){

                                            $porcentaje = $config_pago->monto / 100;
                                            $monto = $item_proforma->importe_neto * $porcentaje;

                                            if($monto > 0 ){

                                                $pago = new PagoStaff;

                                                $pago->staff_id=$inscripcion_clase_grupal->staff_id;
                                                $pago->tipo=$config_pago->tipo;
                                                $pago->monto=$monto;
                                                $pago->servicio_id=$inscripcion_clase_grupal->servicio_id;

                                                $pago->save();
                                            }
                                           
                                        }else{

                                            $pago = new PagoStaff;

                                            $pago->staff_id=$inscripcion_clase_grupal->staff_id;
                                            $pago->tipo=$config_pago->tipo;
                                            $pago->monto=$config_pago->monto;
                                            $pago->servicio_id=$inscripcion_clase_grupal->servicio_id;

                                            $pago->save();
                                            
                                        }
                                    }
                                }
                            }
                                    
                        }else if ($item_proforma->tipo == 15) {
                            if($factura->usuario_tipo == 1){

                                $servicio = ConfigServicios::withTrashed()->find($item_proforma->item_id);
                                $paquete = Paquete::withTrashed()->find($servicio->tipo_id);

                                $credencial = new CredencialAlumno;

                                $credencial->cantidad = $paquete->cantidad_clases_grupales;
                                $credencial->alumno_id = $request->usuario_id;

                                $credencial->save();
                            }
                        }

                        $item_proforma->delete();
                    
                    }

                    $deuda = $total_proforma - $total_pago;

                    $item_factura = new ItemsFactura;

                    $item_factura->factura_id = $factura_id;
                    $item_factura->item_id = $factura->id;
                    $item_factura->nombre = 'Abono Factura ' . $numero_factura;
                    $item_factura->tipo = $tipo;
                    $item_factura->cantidad = 1;
                    $item_factura->precio_neto = 0;
                    $item_factura->impuesto = 0;
                    $item_factura->importe_neto = $total_pago;
                    
                    $item_factura->save();

                    $items_factura_proforma = new ItemsFacturaProforma;

                    $items_factura_proforma->usuario_id = $request->usuario_id;
                    $items_factura_proforma->usuario_tipo = $request->usuario_tipo;
                    $items_factura_proforma->academia_id = Auth::user()->academia_id;
                    $items_factura_proforma->fecha = Carbon::now()->toDateString();
                    $items_factura_proforma->item_id = $factura->id;
                    $items_factura_proforma->nombre = 'Remanente Factura ' . $numero_factura;
                    $items_factura_proforma->tipo = $tipo;
                    $items_factura_proforma->cantidad = 1;
                    $items_factura_proforma->precio_neto = 0;
                    $items_factura_proforma->impuesto = 0;
                    $items_factura_proforma->importe_neto = $deuda;
                    $items_factura_proforma->fecha_vencimiento = Carbon::now()->toDateString();
                    
                    $items_factura_proforma->save();

                }

                //FINAL

                if($request->usuario_tipo == 1){
                    $in = array(2,4);
                }else{
                    $in = array(3);
                }

                $academia = Academia::find(Auth::user()->academia_id);
                $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                    ->whereIn('usuarios_tipo.tipo', $in)
                    ->where('usuarios_tipo.tipo_id', $request->usuario_id)
                ->first();

                if($usuario){

                    if($usuario->familia_id){
                        $es_representante = Familia::where('representante_id', $usuario->id)->first();
                        if($es_representante){
                            $correo = $usuario->email;
                            $celular = getLimpiarNumero($usuario->celular);
                        }else{
                            $familia = Familia::find($usuario->familia_id);
                            $representante = User::find($familia->representante_id);
                            $correo = $representante->email;
                            $celular = getLimpiarNumero($representante->celular);
                        }
                    }else{
                        $correo = $usuario->email;
                        $celular = getLimpiarNumero($usuario->celular);
                    }

                }else{
                    $correo = $alumno->correo;
                    $celular = getLimpiarNumero($alumno->celular);
                }

                if($academia->pais_id == 11 && strlen($celular) == 10){
                    
                    $mensaje = $alumno->nombre.'. hemos registrado satisfactoriamente tu pago, gracias por usar nuestros servicios. ¡Nos encanta verte bailar!.';

                    $client = new Client(); //GuzzleHttp\Client
                    $result = $client->get('https://sistemasmasivos.com/c3colombia/api/sendsms/send.php?user=coliseodelasalsa@gmail.com&password=k1-9L6A1rn&GSM='.$celular.'&SMSText='.urlencode($mensaje));

                }

                // $subj = 'Pago realizado exitósamente';

                // $array = [

                //    'correo_destino' => $correo,
                //    'nombre' => $academia->nombre,
                //    'correo' => $academia->correo,
                //    'telefono' => $academia->celular,
                //    'fecha' => Carbon::now()->toDateString(),
                //    'hora' => Carbon::now()->toTimeString(),
                //    'factura' => $numero_factura,
                //    'total' => $total_pago,
                //    'descripcion' => $descripcion,
                //    'subj' => $subj
                // ];

                // Mail::send('correo.factura', $array, function($msj) use ($array){
                //         $msj->subject($array['subj']);
                //         $msj->to($array['correo_destino']);
                // });
            }else{

                return response()->json(['errores' => ['linea' => [0, 'Ups! ha ocurrido un error con la factura']], 'status' => 'ERRORFACTURA'],422);
            }

            Session::forget('id_proforma');
            Session::forget('pagos');
            Session::forget('gestion');
            Session::forget('pendientes');

            return response()->json(['mensaje' => '¡Excelente! El campo se ha eliminado satisfactoriamente', 'status' => 'OK', 'factura' => $factura->id, 200]);

        }else{
             return response()->json(['errores' => ['linea' => [0, 'Ups! ha ocurrido un error, debes agregar una linea de pago']], 'status' => 'ERROR'],422);
        }
    }

    public function eliminar_factura($id)
    {

        $factura = Factura::find($id);

        if($factura){

            $pagos = Pago::where('factura_id',$id)->delete();
            $items_factura = ItemsFactura::where('factura_id',$id)->delete();
            
            if($factura->delete()){
                return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }


    public function enviarfactura($id)
    {
        
        $academia = Academia::find(Auth::user()->academia_id);
        $factura = Factura::find($id);
        $total_pago = Pago::where('factura_id', $id)->sum('monto');

        if($factura->usuario_tipo == 1){
            $usuario = Alumno::withTrashed()->find($factura->usuario_id);
        }else{
            $usuario = Staff::withTrashed()->find($factura->usuario_id);
        }

        if($usuario->correo){

            $array_descripcion = array();

            $item_factura = ItemsFactura::where('factura_id', '=', $factura->id)->get();

            foreach($item_factura as $item){

                array_push($array_descripcion, $item->cantidad . ' ' . $item->nombre);
               
            }

            $descripcion = implode(",", $array_descripcion);

            $subj = 'Pago realizado exitósamente';

            $array = [

               'correo_destino' => $usuario->correo,
               'nombre' => $academia->nombre,
               'correo' => $academia->correo,
               'telefono' => $academia->celular,
               'fecha' => $factura->fecha,
               'hora' => $factura->hora,
               'factura' => $factura->numero_factura,
               'total' => $total_pago,
               'descripcion' => $descripcion,
               'subj' => $subj
            ];

            Mail::send('correo.factura', $array, function($msj) use ($array){
                $msj->subject($array['subj']);
                $msj->to($array['correo_destino']);
            });
        }

        return response()->json(['mensaje' => '¡Excelente! El campo se ha eliminado satisfactoriamente', 'status' => 'OK', 'factura' => $factura->id, 200]);

    }

    public function principalacuerdo()
    {
        $acuerdos = Acuerdo::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

        $array = array();

        foreach($acuerdos as $acuerdo){

            if($acuerdo->usuario_tipo == 1){
                $usuario = Alumno::withTrashed()->find($acuerdo->usuario_id);

            }else{
                $usuario = Staff::withTrashed()->find($acuerdo->usuario_id);
            }

            $collection=collect($acuerdo);     
            $acuerdo_array = $collection->toArray();
            
            $acuerdo_array['nombre'] = $usuario->nombre . ' '. $usuario->apellido;
            $array[$acuerdo->id] = $acuerdo_array;

        }

        return view('administrativo.acuerdo.principal')->with('acuerdos' , $array);
    }

    public function acuerdo()
    {
        Session::forget('acuerdos');

        $array = array();

        $alumnos = Alumno::withTrashed()->where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

        foreach($alumnos as $alumno)
        {
            $total = ItemsFacturaProforma::where('usuario_id', $alumno->id)->where('usuario_tipo',1)->sum('importe_neto');

            if(!$total){
                $total = 0;
            }

            $deuda = ItemsFacturaProforma::where('fecha_vencimiento','<=',Carbon::today())
                ->where('usuario_id','=',$alumno->id)
                ->where('usuario_tipo',1)
            ->first();

            $collection=collect($alumno);     
            $alumno_array = $collection->toArray();
            
            $alumno_array['id']='1-'.$alumno->id;
            $alumno_array['deuda']=$deuda;
            $alumno_array['total']=$total;
            $array['1-'.$alumno->id] = $alumno_array;
        }

        $staffs = Staff::withTrashed()->where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

        foreach($staffs as $staff)
        {
            $total = ItemsFacturaProforma::where('usuario_id', $staff->id)->where('usuario_tipo',2)->sum('importe_neto');

            if(!$total){
                $total = 0;
            }

            $deuda = ItemsFacturaProforma::where('fecha_vencimiento','<=',Carbon::today())
                ->where('usuario_id','=',$staff->id)
                ->where('usuario_tipo',2)
            ->first();

            $collection=collect($staff);     
            $staff_array = $collection->toArray();

            $staff_array['id']='2-'.$staff->id;
            $staff_array['identificacion']='';
            $staff_array['deuda']=$deuda;
            $staff_array['total']=$total;
            $array['2-'.$staff->id] = $staff_array;
        }
        
        return view('administrativo.acuerdo.acuerdo')->with(['usuarios' => $array]);
    }

    public function acuerdoconid($id)
    {
        $total = 0;

        if(Session::has('acuerdos'))
        {
            Session::forget('acuerdos'); 
        }

        $id_proforma = Session::get('id_proforma');

        if($id_proforma){

            foreach($id_proforma as $proforma_id){

                $items_factura = ItemsFacturaProforma::find($proforma_id);

                $total = $total + $items_factura['importe_neto'];

            }

        }else{
        
            $items_factura = ItemsFacturaProforma::where('usuario_id', '=', $id)->get();

            foreach($items_factura as $item_factura){

                $total = $total + $item_factura['importe_neto'];

            }

        }

        $explode = explode("-", $id);
        $usuario_tipo = $explode[0];
        $usuario_id = $explode[1];

        $acuerdo = ItemsFacturaProforma::where('usuario_id', '=', $usuario_id)
            ->where('tipo' , '=', 6)
            ->where('usuario_tipo' , '=', $usuario_tipo)
        ->count();

        $array = array();

        $alumnos = Alumno::withTrashed()->where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

        foreach($alumnos as $alumno)
        {
            $total = ItemsFacturaProforma::where('usuario_id', $alumno->id)->where('usuario_tipo',1)->sum('importe_neto');

            if(!$total){
                $total = 0;
            }

            $deuda = ItemsFacturaProforma::where('fecha_vencimiento','<=',Carbon::today())
                ->where('usuario_id','=',$alumno->id)
                ->where('usuario_tipo',1)
            ->first();

            $collection=collect($alumno);     
            $alumno_array = $collection->toArray();
            
            $alumno_array['id']='1-'.$alumno->id;
            $alumno_array['deuda']=$deuda;
            $alumno_array['total']=$total;
            $array['1-'.$alumno->id] = $alumno_array;
        }

        $staffs = Staff::withTrashed()->where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

        foreach($staffs as $staff)
        {
            $total = ItemsFacturaProforma::where('usuario_id', $staff->id)->where('usuario_tipo',2)->sum('importe_neto');

            if(!$total){
                $total = 0;
            }

            $deuda = ItemsFacturaProforma::where('fecha_vencimiento','<=',Carbon::today())
                ->where('usuario_id','=',$staff->id)
                ->where('usuario_tipo',2)
            ->first();

            $collection=collect($staff);     
            $staff_array = $collection->toArray();

            $staff_array['id']='2-'.$staff->id;
            $staff_array['identificacion']='';
            $staff_array['deuda']=$deuda;
            $staff_array['total']=$total;
            $array['2-'.$staff->id] = $staff_array;
        }

        return view('administrativo.acuerdo.acuerdo')->with(['usuarios' => $array, 'id' => $id, 'total' => $total, 'acuerdo' => $acuerdo]);
    }

    public function principalpresupuesto()
    {
      
        $presupuestos = Presupuesto::join('alumnos', 'presupuestos.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'presupuestos.fecha as fecha', 'presupuestos.fecha_valida as fecha_valida', 'presupuestos.id as id')
            ->where('presupuestos.academia_id' , '=' , Auth::user()->academia_id)
            ->OrderBy('presupuestos.created_at')
        ->get();

        $array=array();

        foreach($presupuestos as $presupuesto){

            $total = ItemsPresupuesto::where('presupuesto_id' , $presupuesto->id)->sum('importe_neto');
            
            $collection=collect($presupuesto);
            $presupuesto_array = $collection->toArray();

            $presupuesto_array['total']=$total;
            $array[$presupuesto->id] = $presupuesto_array;
        }

        return view('administrativo.presupuesto.principal')->with('presupuestos', $array);
    }

    public function presupuesto()
    {
       
        $academia = Academia::find(Auth::user()->academia_id);

        if (Session::has('arreglo')) {
            Session::forget('arreglo'); 
        }

        $config_servicio=ConfigServicios::where('academia_id', '=' ,  Auth::user()->academia_id)->get();
        $servicio=array();

        foreach($config_servicio as $item){

            $iva = $item['costo'] * ($academia->porcentaje_impuesto / 100);
            $tmp[]=array('id' => $item['id'], 'nombre' => $item['nombre'] , 'costo' => $item['costo'], 'iva' => $iva , 'incluye_iva' => $item['incluye_iva']);

            $collection=collect($tmp);
            $grouped = $collection->groupBy('id');     
            $servicio = $grouped->toArray();
        }

        $config_producto=ConfigProductos::where('academia_id', '=' ,  Auth::user()->academia_id)->get();
        $producto=array();

        foreach($config_producto as $item){

            $iva = $item['costo'] * ($academia->porcentaje_impuesto / 100);
            $tmp2[]=array('id' => $item['id'], 'nombre' => $item['nombre'] , 'costo' => $item['costo'], 'iva' => $iva, 'incluye_iva' => $item['incluye_iva']);

            $collection2=collect($tmp2);
            $grouped2 = $collection2->groupBy('id');     
            $producto = $grouped2->toArray();
        }


        return view('administrativo.presupuesto.presupuesto')->with(['alumnos' => Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get(), 'servicio' => $servicio, 'producto' => $producto, 'impuesto' => $academia->porcentaje_impuesto]);
    }

    public function agregaritempresupuesto(Request $request){
        
        $rules = [

            'combo' => 'required',
            'cantidad' => 'required|numeric|min:1',
        ];

        $messages = [

            'combo.required' => 'Ups! El Producto o Servicio es requerido',
            'cantidad.required' => 'Ups! El Cantidad es invalido, solo se aceptan numeros',
            'cantidad.numeric' => 'Ups! El Cantidad es requerido',
            'cantidad.min' => 'El mínimo de cantidad permitida es 1',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $array = array();

            $id = explode("-", $request->combo);


            if($request->tipo == "servicio"){
                $servicio = ConfigServicios::find($id[0]);
                $importe_neto = $servicio->costo * $request->cantidad;

                if($request->impuesto == 0 and $servicio->incluye_iva == 1){
                     $academia = Academia::find(Auth::user()->academia_id);
                     $iva = $importe_neto * ($academia->porcentaje_impuesto / 100);

                     $importe_neto = $importe_neto - $iva;
                }

                $array = array(['id' => $id[0] , 'nombre' => $servicio->nombre , 'tipo' => 1, 'cantidad' => $request->cantidad, 'precio_neto' => $servicio->costo, 'impuesto' => $request->impuesto, 'importe_neto' => $importe_neto]);
                }

            if($request->tipo == "producto"){

                $producto = ConfigProductos::find($id[0]);
                $importe_neto = $producto->costo * $request->cantidad;

                if($request->impuesto == 0 and $producto->incluye_iva == 1){
                     $academia = Academia::find(Auth::user()->academia_id);
                     $iva = $importe_neto * ($academia->porcentaje_impuesto / 100);

                     $importe_neto = $importe_neto - $iva;
                }

                $array = array(['id' => $id[0] , 'nombre' => $producto->nombre , 'tipo' => 2, 'cantidad' => $request->cantidad, 'precio_neto' => $producto->costo, 'impuesto' => $request->impuesto, 'importe_neto' => $importe_neto]);
                }


            Session::push('arreglo', $array);
            $items = Session::get('arreglo');
            end( $items );
            $contador = key( $items );

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'id' => $contador, 200]);

        }
    }

    public function eliminaritempresupuesto($id){

        $arreglo = Session::get('arreglo');

        $impuesto = $arreglo[$id][0]['impuesto'];
        $importe_neto = $arreglo[$id][0]['importe_neto'];

        $impuesto_total = $importe_neto * ($impuesto / 100);

        unset($arreglo[$id]);
        Session::put('arreglo', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'impuesto' => $impuesto_total, 'importe_neto' => $importe_neto, 200]);

    }

    public function eliminarpresupuesto($id)
    {
        $items_presupuesto = ItemsPresupuesto::where('presupuesto_id',$id)->delete();

        $presupuesto = Presupuesto::find($id);
        
        if($presupuesto->delete()){
            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function agregaritem(Request $request){
        
        $rules = [
            'usuario_id' => 'required',
            'combo' => 'required',
            'cantidad' => 'required|numeric|min:1',
        ];

        $messages = [
            'usuario_id.required' => 'Ups! El Cliente es requerido',
            'combo.required' => 'Ups! El Producto o Servicio es requerido',
            'cantidad.required' => 'Ups! El Cantidad es invalido, solo se aceptan numeros',
            'cantidad.numeric' => 'Ups! El Cantidad es requerido',
            'cantidad.min' => 'El mínimo de cantidad permitida es 1',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $array = array();
            $explode = explode("-", $request->combo);
            $item_id = $explode[0];
            $tipo = $explode[2];

            $explode = explode("-", $request->usuario_id);
            $usuario_tipo = $explode[0];
            $usuario_id = $explode[1];

            if($request->tipo == "servicio"){

                $producto_servicio = ConfigServicios::find($item_id);
                $importe_neto = $producto_servicio->costo * $request->cantidad;

                if($request->impuesto == 0 and $producto_servicio->incluye_iva == 1){
                    $academia = Academia::find(Auth::user()->academia_id);
                    $iva = $importe_neto * ($academia->porcentaje_impuesto / 100);

                    $importe_neto = $importe_neto - $iva;
                }

            }else{

                $producto_servicio = ConfigProductos::find($item_id);
                $importe_neto = $producto_servicio->costo * $request->cantidad;

                if($request->impuesto == 0 and $producto_servicio->incluye_iva == 1){
                     $academia = Academia::find(Auth::user()->academia_id);
                     $iva = $importe_neto * ($academia->porcentaje_impuesto / 100);

                     $importe_neto = $importe_neto - $iva;
                }
            }

            $item_factura = new ItemsFacturaProforma;
                        
            $item_factura->usuario_id = $usuario_id;
            $item_factura->usuario_tipo = $usuario_tipo;
            $item_factura->academia_id = Auth::user()->academia_id;
            $item_factura->fecha = Carbon::now()->toDateString();
            $item_factura->item_id = $item_id;
            $item_factura->nombre = $producto_servicio->nombre;
            $item_factura->tipo = $tipo;
            $item_factura->cantidad = $request->cantidad;
            $item_factura->precio_neto = $producto_servicio->costo;
            $item_factura->impuesto = $request->impuesto;
            $item_factura->importe_neto = $importe_neto;
            $item_factura->fecha_vencimiento = Carbon::now()->toDateString();
                        
            if($item_factura->save()){

                if($tipo == 2){

                    $inventario = ConfigProductos::find($item_id);

                    if($inventario){

                        $cantidad_actual = $inventario->cantidad;
                        $cantidad_vendida = $request->cantidad;

                        $inventario->cantidad = $cantidad_actual - $cantidad_vendida;

                        $inventario->save();
                    }
                }

                $array = array(['id' => $item_factura->id, 'item_id' => $item_id , 'nombre' => $producto_servicio->nombre , 'tipo' => $tipo, 'cantidad' => $request->cantidad, 'precio_neto' => $producto_servicio->costo, 'impuesto' => intval($request->impuesto), 'importe_neto' => $importe_neto, 'operacion' => '<i class="zmdi zmdi-delete f-20 p-r-10 pointer"></i>']);

                $last_proforma = ItemsFacturaProforma::where('fecha' , '=', Carbon::now()->toDateString())
                    ->where('academia_id' , '=', Auth::user()->academia_id)
                ->get();

                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'proforma' => $last_proforma , 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }

        }
    }

    public function eliminaritem($id){

        $factura_proforma = ItemsFacturaProforma::find($id);

        $impuesto = $factura_proforma->impuesto;
        $importe_neto = $factura_proforma->importe_neto;

        $impuesto_total = $importe_neto * ($impuesto / 100);

        if($factura_proforma->delete()){

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'impuesto' => $impuesto_total, 'importe_neto' => $importe_neto, 200]);
        }else{

            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);

        }

    }

    public function storeProforma(Request $request)
    {
        
    $rules = [

        'usuario_id' => 'required',

    ];

    $messages = [

        'usuario_id.required' => 'Ups! El Cliente es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
    }

    else{

            if (Session::has('arreglo')) {
               
                $arreglo = Session::get('arreglo');

                if (count($arreglo) == 0){

                    return response()->json(['errores' => ['linea' => [0, 'Debe agregar una linea de pago']], 'status' => 'ERROR'],422);
                }

                $total = 0;

                for($i = 0; $i < count($arreglo) ; $i++)
                {

                    $item_id = $arreglo[$i][0]['item_id'];
                    $nombre = $arreglo[$i][0]['nombre'];
                    $tipo = $arreglo[$i][0]['tipo'];
                    $cantidad = $arreglo[$i][0]['cantidad'];
                    $precio_neto = $arreglo[$i][0]['precio_neto'];
                    $impuesto = $arreglo[$i][0]['impuesto'];
                    $importe_neto = $arreglo[$i][0]['importe_neto'];
                
                    $item_factura = new ItemsFacturaProforma;
                    
                    $item_factura->usuario_id = $request->usuario_id;
                    $item_factura->academia_id = Auth::user()->academia_id;
                    $item_factura->fecha = Carbon::now()->toDateString();
                    $item_factura->item_id = $item_id;
                    $item_factura->nombre = $nombre;
                    $item_factura->tipo = $tipo;
                    $item_factura->cantidad = $cantidad;
                    $item_factura->precio_neto = $precio_neto;
                    $item_factura->impuesto = $impuesto;
                    $item_factura->importe_neto = $importe_neto;
                    $item_factura->fecha_vencimiento = Carbon::now()->toDateString();
                    
                    $item_factura->save();

                    if($tipo == 2){

                        $inventario = ConfigProductos::find($item_id);

                        if($inventario){

                            $cantidad_actual = $inventario->cantidad;
                            $cantidad_vendida = $cantidad;

                            $inventario->cantidad = $cantidad_actual - $cantidad_vendida;

                            $inventario->save();
                        }
                    }

                    Session::push('id_proforma', $item_factura->id);

                    $total = $total + $importe_neto;

                }

                $explode = explode("-", $request->usuario_id);
                $usuario_tipo = $explode[0];
                $usuario_id = $explode[1];

                $array = array(['total' => $total , 'usuario_id' => $usuario_id , 'usuario_tipo' => $usuario_tipo]);
                Session::put('gestion', $array);

                return response()->json(['status' => 'OK', 200]);
                
            }else{
                return response()->json(['errores' => ['linea' => [0, 'Debe agregar una linea de pago']], 'status' => 'ERROR'],422);
            }
        }
    }

    public function GenerarPresupuesto(Request $request)
    {
        
        $rules = [
            'alumno_id' => 'required',
            'fecha_valida' => 'required',
            'nota_cliente' => 'required',

        ];

        $messages = [

            'alumno_id.required' => 'Ups! El Cliente es requerido',
            'fecha_valida.required' => 'Ups! El Campo Valido Hasta? es requerido',
            'nota_cliente.required' => 'Ups! El Campo Nota Cliente es requerido'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{

            if(Session::has('arreglo')) {
                   
                $arreglo = Session::get('arreglo');

                $fecha_valida = Carbon::createFromFormat('d/m/Y', $request->fecha_valida);
            
                if($fecha_valida < Carbon::now())
                {
                    return response()->json(['errores' => ['fecha_valida' => [0, 'Fecha Invalida']],  'status' => 'ERROR'],422);
                }

                $presupuesto = new Presupuesto;

                $presupuesto->alumno_id = $request->alumno_id;
                $presupuesto->academia_id = Auth::user()->academia_id;
                $presupuesto->fecha = Carbon::now()->toDateString();
                $presupuesto->fecha_valida = $fecha_valida;
                $presupuesto->nota_cliente = $request->nota_cliente;

                if($presupuesto->save()){

                    for($i = 0; $i < count($arreglo) ; $i++)
                    {

                        $id = $arreglo[$i][0]['id'];
                        $nombre = $arreglo[$i][0]['nombre'];
                        $tipo = $arreglo[$i][0]['tipo'];
                        $cantidad = $arreglo[$i][0]['cantidad'];
                        $precio_neto = $arreglo[$i][0]['precio_neto'];
                        $impuesto = $arreglo[$i][0]['impuesto'];
                        $importe_neto = $arreglo[$i][0]['importe_neto'];
                    
                        $item_presupuesto = new ItemsPresupuesto;
                        
                        $item_presupuesto->presupuesto_id = $presupuesto->id;
                        $item_presupuesto->item_id = $id;
                        $item_presupuesto->nombre = $nombre;
                        $item_presupuesto->tipo = $tipo;
                        $item_presupuesto->cantidad = $cantidad;
                        $item_presupuesto->precio_neto = $precio_neto;
                        $item_presupuesto->impuesto = $impuesto;
                        $item_presupuesto->importe_neto = $importe_neto;

                        $item_presupuesto->save();
                    }
                    

                    $total = ItemsPresupuesto::where('id', '=', $presupuesto->id)->sum('precio_neto');
                    $alumno = Alumno::find($request->alumno_id);

                    return response()->json(['alumno'=> $alumno, 'presupuesto' => $presupuesto->id, 'total' => $total, 'status' => 'OK', 200]);
              
                }

            }else{
                return response()->json(['errores' => ['linea' => [0, 'Debe agregar una linea de pago']], 'status' => 'ERROR'],422);
            }
        }
    }
    
    public function generar_acuerdo(Request $request)
    {

        $rules = [        
        
            'fecha' => 'required',
            'frecuencia' => 'required',
            'partes' => 'required|numeric',

        ];

        $messages = [

            'fecha.required' => 'Ups! La Fecha es requerida ',
            'frecuencia.required' => 'Ups! La Frecuencia es requerida',
            'partes.required' => 'Ups! La Partes es requerido',
            'costo.numeric' => 'Ups! Las Partes es inválido , debe contener sólo números',
        ];    

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{

            $monto= $request->total;
            $fecha_acuerdo=explode('/',$request->fecha);
            $frecuencia=$request->frecuencia;
            $partes=$request->partes;
            $cantidad=$monto/$request->partes;

            $dt = Carbon::create($fecha_acuerdo[2], $fecha_acuerdo[1], $fecha_acuerdo[0], 0);
            $arrayAcuerdoFecha=array();
            $arrayAcuerdo=array();
            $ff =Carbon::createFromFormat('Y-m-d', $dt->toDateString())->format('d-m-Y');
            $arrayAcuerdoFecha[]=array("numero"=>1, "fecha_frecuencia"=>$ff, "cantidad"=>$cantidad );

            for($i=1; $i<$partes; $i++) {
                
               $fecha="";
               if($frecuencia=='Semanal'){
                   $fecha=$dt->addWeek()->toDateString(); 
               }elseif($frecuencia=="Mensual"){
                   $fecha=$dt->addMonth()->toDateString(); 
               }else{
                   $fecha=$dt->addDays(15)->toDateString(); 
               }
               
               $ff = Carbon::createFromFormat('Y-m-d', $dt->toDateString())->format('d-m-Y');
                
                $arrayAcuerdoFecha[]=array("numero"=>$i+1, "fecha_frecuencia"=>$ff, "cantidad"=>$cantidad);

            }


            $arrayAcuerdo=array('frecuencia'=>$frecuencia, 'partes'=>$partes , 'fechas_acuerdo'=>$arrayAcuerdoFecha);

            Session::put('acuerdos', $arrayAcuerdo); 

            return response()->json(['mensaje' => '¡Excelente! Los acuerdos han sido generados', 'status' => 'OK', 200, 'acuerdos'=>$arrayAcuerdo]);
        }
    }

    public function updateAcuerdo(Request $request)
    {

        $rules = [        
        
            'fecha_actualizada' => 'required',

        ];

        $messages = [

            'fecha_actualizada.required' => 'Ups! La Fecha es requerida ',
        ];    

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{

            $i = $request->id - 1;
            $acuerdo = Session::get('acuerdos');
            $fecha_actualizada = Carbon::createFromFormat('d/m/Y', $request->fecha_actualizada);

            if($i == 0){
                $tmp = $acuerdo['fechas_acuerdo'][$i + 1]['fecha_frecuencia'];
                $fecha = Carbon::createFromFormat('d-m-Y', $tmp);
                if($fecha_actualizada > $fecha){
                    return response()->json(['errores' => ['fecha_actualizada' => [0, 'Ups! Debes ingresar una fecha menor a la segunda fecha']], 'status' => 'ERROR'],422);
                }
            }else if($i == count($acuerdo['fechas_acuerdo']) - 1){
                $tmp = $acuerdo['fechas_acuerdo'][$i - 1]['fecha_frecuencia'];
                $fecha = Carbon::createFromFormat('d-m-Y', $tmp);
                if($fecha_actualizada < $fecha){
                    return response()->json(['errores' => ['fecha_actualizada' => [0, 'Ups! Debes ingresar una fecha mayor a la penultima fecha']], 'status' => 'ERROR'],422);
                }
            }else{
                $tmp1 = $acuerdo['fechas_acuerdo'][$i - 1]['fecha_frecuencia'];
                $tmp2 = $acuerdo['fechas_acuerdo'][$i + 1]['fecha_frecuencia'];
                $fecha_min = Carbon::createFromFormat('d-m-Y', $tmp1);
                $fecha_max = Carbon::createFromFormat('d-m-Y', $tmp2);

                if(!$fecha_actualizada->between($fecha_min, $fecha_max)){
                    return response()->json(['errores' => ['fecha_actualizada' => [0, 'Ups! Debes ingresar una fecha menor a la siguiente fecha y mayor a la fecha anterior']], 'status' => 'ERROR'],422);
                }
            }

            $fecha = $fecha_actualizada->format('d-m-Y');
            $acuerdo['fechas_acuerdo'][$i]['fecha_frecuencia'] = $fecha;
            Session::put('acuerdos', $acuerdo); 

            return response()->json(['mensaje' => '¡Excelente! Los acuerdos han sido actualizados', 'status' => 'OK', 200, 'fecha'=>$fecha, 'i' => $i + 1]);
        }
    }

    public function storeAcuerdo(Request $request)
    {
        
        $rules = [

            'usuario_id' => 'required',
            'porcentaje_retraso' => 'numeric',
            'tiempo_tolerancia' => 'numeric',

        ];

        $messages = [

            'usuario_id.required' => 'Ups! El Cliente es requerido',
            'porcentaje_retraso.numeric' => 'Ups! El campo de porcentaje de retraso es inválido , debe contener sólo números',
            'tiempo_tolerancia.numeric' => 'Ups! El campo de tiempo de tolerancia es inválido , debe contener sólo números',  
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
        }

        else{

            if (Session::has('acuerdos')) {
               
                $arreglo = Session::get('acuerdos');
                $id_proforma = Session::get('id_proforma');
                $array_descripcion = array();

                if($id_proforma){

                    foreach($id_proforma as $proforma_id)
                    {

                        $item_proforma = ItemsFacturaProforma::find($proforma_id);

                        array_push($array_descripcion, $item_proforma->cantidad . ' ' . $item_proforma->nombre);

                    }

                }else{

                    $item_proforma = ItemsFacturaProforma::where('usuario_id', '=', $request->usuario_id)->get();

                    foreach($item_proforma as $items_proforma){

                        array_push($array_descripcion, $items_proforma->cantidad . ' ' . $items_proforma->nombre);

                    }

                }

                $descripcion = implode(",", $array_descripcion);
                $total = 0;

                $fechas_acuerdo = $arreglo['fechas_acuerdo'];
                $frecuencia = $arreglo['frecuencia'];
                $partes = $arreglo['partes'];
                $fecha_inicio = $arreglo['fechas_acuerdo'][0]['fecha_frecuencia'];

                $explode = explode("-", $request->usuario_id);
                $usuario_tipo = $explode[0];
                $usuario_id = $explode[1];

                $acuerdo = new Acuerdo;

                $acuerdo->academia_id = Auth::user()->academia_id;
                $acuerdo->usuario_id = $usuario_id;
                $acuerdo->usuario_tipo = $usuario_tipo;
                $acuerdo->fecha_inicio = Carbon::createFromFormat('d-m-Y', $fecha_inicio)->toDateString();
                $acuerdo->frecuencia = $frecuencia;
                $acuerdo->cuotas = $partes;
                $acuerdo->tipo = $request->tipo;
                $acuerdo->porcentaje_retraso = $request->porcentaje_retraso;
                $acuerdo->tiempo_tolerancia = $request->tiempo_tolerancia;

                if($acuerdo->save())
                {

                    foreach($fechas_acuerdo as $fechas){

                        $fecha = Carbon::createFromFormat('d-m-Y', $fechas['fecha_frecuencia'])->toDateString();

                        $id = $acuerdo->id;
                        $nombre = 'Acuerdo de pago para ' . $descripcion;
                        $tipo = $request->tipo;
                        $cantidad = 1;
                        $precio_neto = 0;
                        $impuesto = 0;
                        $importe_neto = $fechas['cantidad'];

                    
                        $item_factura = new ItemsFacturaProforma;
                        
                        $item_factura->usuario_id = $usuario_id;
                        $item_factura->usuario_tipo = $usuario_tipo;
                        $item_factura->academia_id = Auth::user()->academia_id;
                        $item_factura->fecha = Carbon::now()->toDateString();
                        $item_factura->item_id = $id;
                        $item_factura->nombre = $nombre;
                        $item_factura->tipo = $tipo;
                        $item_factura->cantidad = $cantidad;
                        $item_factura->precio_neto = $precio_neto;
                        $item_factura->impuesto = $impuesto;
                        $item_factura->importe_neto = $importe_neto;
                        $item_factura->fecha_vencimiento = $fecha;

                        $item_factura->save();


                        $item_acuerdo = new ItemsAcuerdo;
                        
                        $item_acuerdo->acuerdo_id = $id;
                        $item_acuerdo->fecha = Carbon::now()->toDateString();
                        $item_acuerdo->item_id = $item_factura->id;
                        $item_acuerdo->nombre = $nombre;
                        $item_acuerdo->tipo = $tipo;
                        $item_acuerdo->cantidad = $cantidad;
                        $item_acuerdo->precio_neto = $precio_neto;
                        $item_acuerdo->impuesto = $impuesto;
                        $item_acuerdo->importe_neto = $importe_neto;
                        $item_acuerdo->fecha_vencimiento = $fecha;

                        $item_acuerdo->save();

                        $total = $total + $importe_neto;

                    }

                    $acuerdo->total = $total;
                    $acuerdo->save();

                    if($id_proforma){

                        foreach($id_proforma as $proforma_id)
                        {
                            $delete = ItemsFacturaProforma::find($proforma_id)->delete();
                        }

                    }else{

                        $delete = ItemsFacturaProforma::where('usuario_id', '=', $request->usuario_id)->delete();

                    }

                    return response()->json(['status' => 'OK', 'usuario_id' => $usuario_id, 'usuario_tipo' => $usuario_tipo, 200]);

                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-ACUERDO'],422);
                }  
            }else{
                return response()->json(['errores' => ['linea' => [0, 'Debes generar un acuerdo primero']], 'status' => 'ERROR'],422);
            }
        }
    }

    public function eliminaracuerdo($id)
    {
       

        $acuerdo = Acuerdo::find($id);

        if($acuerdo){

             $items_acuerdo = ItemsAcuerdo::where('acuerdo_id',$id)->get();
        
            foreach($items_acuerdo as $item){
                $proforma = ItemsFacturaProforma::find($item->item_id)->delete();
                $item->delete();
            }
            
            if($acuerdo->delete()){
                return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function getFactura($id){
        
        //DATOS DE ENCABEZADO
        
        $factura = Factura::find($id);

        // $alumno = Factura::Leftjoin('alumnos', 'facturas.alumno_id', '=', 'alumnos.id')
        //     ->Leftjoin('usuario_externos','facturas.externo_id', '=', 'usuario_externos.id')
        //     ->selectRaw('IF(alumnos.nombre is null AND alumnos.apellido is null, usuario_externos.nombre, CONCAT(alumnos.nombre, " " , alumnos.apellido)) as nombre, alumnos.identificacion AS dni, IF(alumnos.correo is null, usuario_externos.correo, alumnos.correo) as email, alumnos.direccion AS direccion, alumnos.telefono AS telefono')
        //     ->where('facturas.id','=',$id)
        // ->first();

        if($factura->usuario_id){

            if($factura->usuario_tipo == 1){
                $usuario = Alumno::withTrashed()->find($factura->usuario_id);
            }else{
                $usuario = Staff::withTrashed()->find($factura->usuario_id);
            }            
        }else{
            $usuario = UsuarioExterno::withTrashed()->find($factura->externo_id);
        }


        $academia = DB::table('facturas')
            ->join('academias', 'facturas.academia_id','=','academias.id')
            ->join('paises', 'academias.pais_id','=','paises.id')
            ->select('academias.nombre AS academia_nombre',
                     'academias.direccion AS academia_direccion',
                     'academias.telefono AS academia_telefono',
                     'academias.correo AS academia_email',
                     'paises.nombre as academia_pais',
                     'paises.abreviatura as pais_abreviatura',
                     'paises.moneda as pais_moneda',
                     'academias.imagen as imagen_academia',
                     'academias.porcentaje_impuesto')
            ->where('facturas.id','=',$id)
        ->first();

        $PerctIVA = 0;  
        $subtotal = 0;
        $impuesto = 0;

        //DATOS DE DETALLE
        $detalle = ItemsFactura::select('factura_id', 'item_id', 'nombre', 'tipo', 
                                        'cantidad', 'precio_neto', 'impuesto', 'importe_neto')
                                ->where('factura_id','=',$id)
        ->get();

        foreach($detalle as $tmp){

            $subtotal = $subtotal + $tmp->importe_neto;
            if($tmp->impuesto != 0){
                $impuesto = $impuesto + ($tmp->importe_neto * ($tmp->impuesto / 100));
                $subtotal = $subtotal - $impuesto;
                $PerctIVA = $academia->porcentaje_impuesto;
            }
        }

        $total = $subtotal + $impuesto;

        return view('administrativo.factura')->with([
                'facturas'          => $factura, 
                'usuario'           => $usuario, 
                'academia'          => $academia, 
                'subtotal'          => $subtotal, 
                'iva'               => $impuesto, 
                'total'             => $total, 
                'porcentajeIVA'     => $PerctIVA,
                'detalleFactura'    => $detalle 
                ]);
    }

    public function detallepresupuesto($id){
        //DATOS DE ENCABEZADO
        
        $presupuesto = Presupuesto::find($id);
        $alumno = DB::table('presupuestos')->join('alumnos', 'presupuestos.alumno_id','=','alumnos.id')
                            ->select('alumnos.nombre AS alumno_nombre', 'alumnos.apellido AS alumno_apellido', 'alumnos.identificacion AS dni', 'alumnos.direccion AS direccion', 'alumnos.telefono AS telefono', 'alumnos.correo AS email')
                            ->where('presupuestos.id','=',$id)
                            ->first();

        $academia = DB::table('presupuestos')
                            ->join('academias', 'presupuestos.academia_id','=','academias.id')
                            ->join('paises', 'academias.pais_id','=','paises.id')
                            ->select('academias.nombre AS academia_nombre', 'academias.direccion AS academia_direccion', 'academias.telefono AS academia_telefono', 'academias.correo AS academia_email', 'paises.nombre as academia_pais', 'academias.imagen as imagen_academia', 'academias.porcentaje_impuesto')
                            ->where('presupuestos.id','=',$id)
                            ->first();

        $PerctIVA = 0;            
        $subtotal = 0;
        $impuesto = 0;

        //DATOS DE DETALLE
        $detalle = ItemsPresupuesto::select('presupuesto_id', 'item_id', 'nombre', 'tipo', 
                                        'cantidad', 'precio_neto', 'impuesto', 'importe_neto')
                                ->where('presupuesto_id','=',$id)
                                ->get();
        foreach($detalle as $tmp){

            $subtotal = $subtotal + $tmp->importe_neto;
            if($tmp->impuesto != 0){
                $impuesto = $impuesto + ($tmp->importe_neto * ($tmp->impuesto / 100));
                $subtotal = $subtotal - $impuesto;
                $PerctIVA = $academia->porcentaje_impuesto;
                
            }
        }

        $total = $subtotal + $impuesto;

        return view('administrativo.presupuesto.planilla')->with([
                'facturas'          => $presupuesto, 
                'alumno'            => $alumno, 
                'academia'          => $academia, 
                'subtotal'          => $subtotal, 
                'iva'               => $impuesto, 
                'total'             => $total, 
                'porcentajeIVA'     => $PerctIVA,
                'detalleFactura'    => $detalle 
                ]);
    }

    public function detalleacuerdo($id){

        //DATOS DE ENCABEZADO
        
        $acuerdo = Acuerdo::find($id);

        if($acuerdo->usuario_id){

            if($acuerdo->usuario_tipo == 1){
                $usuario = Alumno::withTrashed()->find($acuerdo->usuario_id);
            }else{
                $usuario = Staff::withTrashed()->find($acuerdo->usuario_id);
            }            
        }else{
            $usuario = UsuarioExterno::withTrashed()->find($acuerdo->externo_id);
        }

        $academia = DB::table('acuerdos')
            ->join('academias', 'acuerdos.academia_id','=','academias.id')
            ->join('paises', 'academias.pais_id','=','paises.id')
            ->select('academias.nombre AS academia_nombre', 'academias.direccion AS academia_direccion', 'academias.telefono AS academia_telefono', 'academias.correo AS academia_email', 'paises.nombre as academia_pais', 'academias.imagen as imagen_academia', 'academias.porcentaje_impuesto')
            ->where('acuerdos.id','=',$id)
        ->first();

        $PerctIVA = 0;
        $subtotal = 0;
        $impuesto = 0;

        //DATOS DE DETALLE
        $detalle = ItemsAcuerdo::select('id', 'item_id', 'nombre', 'tipo', 
                'cantidad', 'precio_neto', 'impuesto', 'importe_neto')
            ->where('acuerdo_id','=',$id)
        ->get();

        foreach($detalle as $tmp){

            $subtotal = $subtotal + $tmp->importe_neto;
            if($tmp->impuesto != 0){
                $impuesto = $impuesto + ($tmp->importe_neto * ($tmp->impuesto / 100));
                $subtotal = $subtotal - $impuesto;
                $PerctIVA = $academia->porcentaje_impuesto;
                
            }
        }

        $total = $subtotal + $impuesto;

        return view('administrativo.acuerdo.planilla')->with([
            'facturas'          => $acuerdo, 
            'usuario'           => $usuario, 
            'academia'          => $academia, 
            'subtotal'          => $subtotal, 
            'iva'               => $impuesto, 
            'total'             => $total, 
            'porcentajeIVA'     => $PerctIVA,
            'detalleFactura'    => $detalle 
        ]);
    }

	public function CancelarPago()
	{	
		if (Session::has('arreglo')) {

            Session::forget('arreglo');
            return response()->json(['status' => 'OK', 200]);  
        }
        else
        {
            return response()->json(['status' => 'OK', 200]);
        }
	}

    public function pagospendientes($id)
    {
        $subtotal = 0;
        $impuesto = 0;

        if(Session::has('acuerdos'))
        {
         Session::forget('acuerdos'); 
        }

        $explode = explode("-", $id);
        $usuario_tipo = $explode[0];
        $usuario_id = $explode[1];

        $acuerdos_pendientes = ItemsFacturaProforma::where('usuario_id', '=', $usuario_id)
            ->where('tipo' , '=', 6)
            ->where('usuario_tipo' , '=', $usuario_tipo)
        ->count();

        if($acuerdos_pendientes){
            return response()->json(['errores' => ['usuario_id' => [0, 'No se puede generar un acuerdo de pago, debido a que este participante ya posee uno asignado']], 'status' => 'ERROR'],422);
        }
        
        $items_factura = ItemsFacturaProforma::where('usuario_id', '=', $usuario_id)->where('usuario_tipo',$usuario_tipo)->get();

        $total = 0;

        foreach($items_factura as $item_factura){

            $total = $total + $item_factura['importe_neto'];

        }

        if($total > 0){
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'total' => $total, 200]);
        }else{
            return response()->json(['errores' => ['usuario_id' => [0, 'Este participante no presenta deuda para generar acuerdo de pago, selecciona otro participante']], 'status' => 'ERROR'],422);
        }
    }

    public function itemspendientes($id)
    {
        
        $explode = explode("-", $id);
        $usuario_tipo = $explode[0];
        $usuario_id = $explode[1];

        $items_factura = ItemsFacturaProforma::where('usuario_id', '=', $usuario_id)->where('usuario_tipo',$usuario_tipo)->get();

        $total = 0;
        $i = 0;
        $array = array();
        foreach($items_factura as $item_factura){

            $array[] = array(['id' => $item_factura->id, 'item_id' => $item_factura->item_id , 'nombre' => $item_factura->nombre , 'tipo' => $item_factura->tipo, 'cantidad' => $item_factura->cantidad, 'precio_neto' => $item_factura->precio_neto, 'impuesto' => intval($item_factura->impuesto), 'importe_neto' => $item_factura->importe_neto]);

            $total = $total + $item_factura['importe_neto'];
            $i = $i + 1;
        }

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'total' => $total, 'items' => $array , 200]);

    }

    public function pagar($id){

        if (Session::has('pagos')) {
            Session::forget('pagos'); 
        }

        if (Session::has('id_proforma')) {
            Session::forget('id_proforma'); 
        }
        
        $academia = Academia::find(Auth::user()->academia_id);
        $factura = DB::table('facturas')->orderBy('created_at', 'desc')->where('academia_id', '=', Auth::user()->academia_id)->first();

        $formas_pago = DB::table('formas_pago')->get();

        if($factura){

            $tmp = $factura->numero_factura + 1;
            $numero_factura =  str_pad($tmp, 10, "0", STR_PAD_LEFT);
        }
        else{

            if($academia->numero_factura){
                $tmp = $academia->numero_factura;
                $numero_factura =  str_pad($tmp, 10, "0", STR_PAD_LEFT);
            }
            else{
                $tmp = 1;
                $numero_factura =  str_pad($tmp, 10, "0", STR_PAD_LEFT);
            }
            
        }

        $factura_proforma = ItemsFacturaProforma::find($id);

        $usuario_id = $factura_proforma->usuario_id;
        $alumno = Alumno::where('id', '=', $usuario_id)->first();
        $total = $factura_proforma->importe_neto;
        Session::push('id_proforma', $id);

        return view('vista_alumno.pagar')->with(['total' => $total, 'numero_factura' => $numero_factura , 'formas_pago' => $formas_pago, 'alumno' => $alumno , 'porcentaje_impuesto' => $academia->porcentaje_impuesto]);

    }

    //FUNCTION MERADOPAGO
    public function storeMercadopago(Request $request)
    {

        $mercadopago = new MercadopagoMovs;

        if($request->json['collection_status']!=null){

            $mercadopago->academia_id = Auth::user()->academia_id;
            $mercadopago->usuario_id = $request->alumno;
            $mercadopago->status_pago = $request->json['collection_status'];
            $mercadopago->pago_id = $request->json['collection_id'];
            $mercadopago->preference_id = $request->json['preference_id'];
            $mercadopago->tipo_pago = $request->json['payment_type'];

            $mercadopago->save();
            return 'Movimiento Generado en Base de Datos';
        }
        return 'No se genero ningun Registro en Base de Datos';

    }

    public function AgregarCliente(Request $request)
    {
        $request->merge(array('correo' => trim($request->correo)));

        $rules = [
            'identificacion' => 'required|min:7|numeric',
            'nombre' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            'apellido' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            'sexo' => 'required',
            'rol' => 'required'
        ];

        $messages = [

            'identificacion.required' => 'Ups! El identificador es requerido',
            'identificacion.min' => 'El mínimo de numeros permitidos son 5',
            'identificacion.max' => 'El maximo de numeros permitidos son 20',
            'identificacion.numeric' => 'Ups! El identificador es inválido , debe contener sólo números',
            'identificacion.unique' => 'Ups! Ya este usuario ha sido registrado',
            'nombre.required' => 'Ups! El Nombre  es requerido ',
            'nombre.min' => 'El mínimo de caracteres permitidos son 3',
            'nombre.max' => 'El máximo de caracteres permitidos son 20',
            'nombre.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
            'apellido.required' => 'Ups! El Apellido  es requerido ',
            'apellido.min' => 'El mínimo de caracteres permitidos son 3',
            'apellido.max' => 'El máximo de caracteres permitidos son 20',
            'apellido.regex' => 'Ups! El apellido es inválido , debe ingresar sólo letras',
            'sexo.required' => 'Ups! El Sexo  es requerido ',
            'rol.required' => 'Ups! El Rol del representante es requerido ',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            if($request->fecha_nacimiento){

                $edad = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->diff(Carbon::now())->format('%y');

                if($edad < 1){
                    return response()->json(['errores' => ['fecha_nacimiento' => [0, 'Ups! Esta fecha es invalida, debes ingresar una fecha superior a 1 año de edad']], 'status' => 'ERROR'],422);
                }

                $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->toDateString();

            }else{
                $fecha_nacimiento = '';
            }

            $nombre = title_case($request->nombre);
            $apellido = title_case($request->apellido);
            $direccion = $request->direccion;
            $correo = strtolower($request->correo);
            

            $alumno = new Alumno;

            $alumno->academia_id = Auth::user()->academia_id;
            $alumno->identificacion = $request->identificacion;
            $alumno->nombre = $nombre;
            $alumno->apellido = $apellido;
            $alumno->sexo = $request->sexo;
            $alumno->fecha_nacimiento = $fecha_nacimiento;
            $alumno->correo = $correo;
            $alumno->telefono = $request->telefono;
            $alumno->celular = $request->celular;
            $alumno->direccion = $direccion;
            $alumno->alergia = 0;
            $alumno->asma = 0;
            $alumno->convulsiones = 0;
            $alumno->cefalea = 0;
            $alumno->hipertension = 0;
            $alumno->lesiones = 0;

            if($request->rol == "0"){

                $alumno->tipo = 2;

            }

            if($alumno->save()){

                if($correo){

                    $usuario = new User;

                    $usuario->academia_id = Auth::user()->academia_id;
                    $usuario->nombre = $nombre;
                    $usuario->apellido = $apellido;
                    $usuario->telefono = $request->telefono;
                    $usuario->celular = $request->celular;
                    $usuario->sexo = $request->sexo;
                    $usuario->email = $correo;
                    $usuario->como_nos_conociste_id = 1;
                    $usuario->direccion = $direccion;
                    // $usuario->confirmation_token = str_random(40);
                    $usuario->password = bcrypt(str_random(8));
                    $usuario->usuario_tipo = 2;
                    $usuario->usuario_id = $alumno->id;

                    if($usuario->save()){

                        $usuario_tipo = new UsuarioTipo;
                        $usuario_tipo->usuario_id = $usuario->id;
                        $usuario_tipo->tipo = 2;
                        $usuario_tipo->tipo_id = $alumno->id;
                        $usuario_tipo->save();

                        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'alumno' => $alumno, 200]);
                    }else{
                        return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
                    }

                }else{
                    return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'alumno' => $alumno, 200]);
                }
          
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
            }
        }
    }

    public function principalTransferencias()
    {
        return view('vista_alumno.administrativo.transferencias');
    }

    public function confirmarTransferencia()
    {
        return view('vista_alumno.administrativo.confirmar');
    }

    public function storeTransferencia(Request $request)
    {

        $rules = [
            'banco' => 'required|min:3|max:20',
            'referencia' => 'required|min:3|max:20',
            'cantidad' => 'required',
        ];

        $messages = [

            'banco.required' => 'Ups! El banco es requerido ',
            'banco.min' => 'El mínimo de caracteres permitidos son 3',
            'banco.max' => 'El máximo de caracteres permitidos son 20',
            'referencia.required' => 'Ups! La referencia es requerido ',
            'referencia.min' => 'El mínimo de caracteres permitidos son 3',
            'referencia.max' => 'El máximo de caracteres permitidos son 20',
            'cantidad.required' => 'Ups! El monto es requerida',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $usuario_tipo = Session::get('easydance_usuario_tipo');
            $usuario_id = Session::get('easydance_usuario_id');

            $transferencia = new Transferencia;

            $transferencia->academia_id = Auth::user()->academia_id;
            $transferencia->banco = $request->banco;
            $transferencia->referencia = $request->referencia;
            $transferencia->cantidad = $request->cantidad;
            $transferencia->usuario_tipo = $usuario_tipo;
            $transferencia->usuario_id = $usuario_id;

            if($transferencia->save()){

                $sugerencia = new Sugerencia;

                $sugerencia->usuario_id = Auth::user()->id;
                $sugerencia->fecha = Carbon::now();
                $sugerencia->mensaje = Auth::user()->nombre . " " . Auth::user()->apellido . " ha realizado una transferencia al banco " . $request->banco . " con el numero de referencia " . $request->referencia . " por un monto de " . number_format($request->cantidad, 2, '.' , '.');
                $sugerencia->academia_id = Auth::user()->academia_id;

                if($sugerencia->save()){

                    $notificacion = new Notificacion; 

                    $notificacion->tipo_evento = 5;
                    $notificacion->evento_id = $sugerencia->id;
                    $notificacion->mensaje = Auth::user()->nombre . " " . Auth::user()->apellido . " ha realizado una transferencia";
                    $notificacion->titulo = "Nueva Transferencia";

                    if($notificacion->save()){

                        $not_in = array(2,4);
                        $usuarios = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                            ->whereNotIn('usuarios_tipo.tipo', $not_in)
                            ->where('academia_id',Auth::user()->academia_id)
                        ->get();
                        
                        $correos = array();

                        foreach($usuarios as $usuario){

                            $usuarios_notificados = new NotificacionUsuario;
                            $usuarios_notificados->id_usuario = $usuario->id;
                            $usuarios_notificados->id_notificacion = $notificacion->id;
                            $usuarios_notificados->visto = 0;
                            $usuarios_notificados->save();

                            $correos[] = $usuario->email;
                        }

                        $array = [
                            'nombre' => Auth::user()->nombre . " " . Auth::user()->apellido,
                            'email' => $correos,
                            'banco' => $request->banco,
                            'referencia' => $request->referencia,
                            'cantidad' => $request->cantidad,
                            'subj' => 'Han realizado una transferencia'
                        ];

                        Mail::send('correo.transferencia', $array, function($msj) use ($array){
                            $msj->subject($array['subj']);
                            $msj->to($array['email']);
                        });
                          
                        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
                    }else{
                        return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                    }
                }
            }
        }
    }
}
