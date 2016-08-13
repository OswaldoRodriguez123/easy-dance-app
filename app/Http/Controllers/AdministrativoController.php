<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Alumno;
use App\Acuerdo;
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
use App\MercadopagoMovs;
use App\User;
use App\Familia;
//use MP;
use Validator;
use Carbon\Carbon;
use Storage;
use Session;
use DB;
use Mail;
use Redirect;
use Illuminate\Support\Facades\Auth;

class AdministrativoController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    
	public function index()
	{
        if(Auth::user()->usuario_tipo == 2)
        {


		  $factura_join = DB::table('facturas')
            ->join('alumnos', 'facturas.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'facturas.numero_factura as factura', 'facturas.fecha as fecha', 'facturas.id', 'facturas.concepto')
            ->where('facturas.alumno_id' , '=' , Auth::user()->usuario_id)
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

            $proforma_join = DB::table('items_factura_proforma')
                ->join('alumnos', 'items_factura_proforma.alumno_id', '=', 'alumnos.id')
                ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'items_factura_proforma.fecha_vencimiento as fecha_vencimiento', 'items_factura_proforma.id', 'items_factura_proforma.importe_neto as total', 'items_factura_proforma.nombre as concepto', 'items_factura_proforma.cantidad')
                ->where('items_factura_proforma.alumno_id' , '=' , Auth::user()->usuario_id)
            ->get();

            $total = DB::table('items_factura_proforma')
            ->join('alumnos', 'items_factura_proforma.alumno_id', '=', 'alumnos.id')
            ->where('items_factura_proforma.alumno_id', Auth::user()->usuario_id)
            ->where('alumnos.deleted_at' , '=' , null)
            ->sum('.items_factura_proforma.importe_neto');

            return view('vista_alumno.administrativo')->with(['facturas'=> $array, 'proforma' => $proforma_join, 'total' => $total]); 
        }
        else{
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
        // $factura_join = DB::table('facturas')
        //     ->join('alumnos', 'facturas.alumno_id', '=', 'alumnos.id')
        //     ->join('items_factura', 'facturas.id', '=', 'items_factura.factura_id')
        //     ->select('alumnos.nombre as alumno_nombre', 'alumnos.apellido as alumno_apellido', 'facturas.numero_factura as factura', 'facturas.fecha as fecha')
        //     ->orderBy(DB::raw('sum(\'items_factura.importe_neto\')'))
        // ->get();


        //PENDIENTE

        // $total = Factura::with(['items_factura' => function($query){
        //     $query->sum('factura_id');
        // }])->get();


        // for($i=0; $i<=$total.length; $i++)
        // {
        //     for($j=0; $j<=$total[$i]['items_factura'].length; $j++)
        //     {
        //         $total = $total[2]['items_factura'];
        //     }
            
        // }
        

        // $total = DB::table('items_factura')
        // ->orderBy(DB::raw('sum(\'items_factura.factura_id\')'))
        // ->get();

        // $total = Pago::groupBy('id')->sum('monto')->get();

        // $total = Pago::groupBy('factura_id')
        //    ->selectRaw('sum(monto) as sum, factura_id')
        //    ->lists('sum','factura_id');

        // dd($total);

        // $factura_join = DB::table('facturas')
        //     ->join('alumnos', 'facturas.alumno_id', '=', 'alumnos.id')
        //     ->join('pagos', 'facturas.id', '=', 'pagos.factura_id')
        //     ->selectRaw('sum(pagos.monto) as monto')
        //     ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'facturas.fecha as fecha', 'facturas.id', 'facturas.numero_factura', 'sum(monto)')
        //     ->groupBy('factura_id')
        // // ->lists('nombre')
        // ->get();
        // 
        
        $array = array();

        $factura_join = DB::table('facturas')
            ->join('alumnos', 'facturas.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'facturas.numero_factura as factura', 'facturas.fecha as fecha', 'facturas.id', 'facturas.concepto')
            ->where('facturas.academia_id' , '=' , Auth::user()->academia_id)
            ->where('alumnos.deleted_at' , '=' , null)
            ->OrderBy('facturas.created_at')
        ->get();

        foreach($factura_join as $factura){


            $total = ItemsFactura::where('factura_id', '=' ,  $factura->id)->sum('importe_neto');
            $collection=collect($factura);     
            $factura_array = $collection->toArray();
            
            $factura_array['total']=$total;
            $array[$factura->id] = $factura_array;

        }

        $proforma_join = DB::table('items_factura_proforma')
            ->join('alumnos', 'items_factura_proforma.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'items_factura_proforma.fecha_vencimiento as fecha_vencimiento', 'items_factura_proforma.id', 'items_factura_proforma.importe_neto as total', 'items_factura_proforma.nombre as concepto', 'items_factura_proforma.cantidad')
            ->where('items_factura_proforma.academia_id' , '=' , Auth::user()->academia_id)
            ->where('alumnos.deleted_at' , '=' , null)
        ->get();

        $total = DB::table('items_factura_proforma')
        ->join('alumnos', 'items_factura_proforma.alumno_id', '=', 'alumnos.id')
        ->where('items_factura_proforma.academia_id', Auth::user()->academia_id)
        ->where('alumnos.deleted_at' , '=' , null)
        ->sum('.items_factura_proforma.importe_neto');

        return view('administrativo.pagos.principal')->with(['facturas'=> $array, 'proforma' => $proforma_join, 'total' => $total]);
    }

	public function generarpagos()
	{
        // if (Auth::check())
        // {
            $academia = Academia::find(Auth::user()->academia_id);

        // }
        
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

        $config_servicio=ConfigServicios::where('academia_id', '=' ,  Auth::user()->academia_id)->get();
        $servicio=array();

        foreach($config_servicio as $item){

            $iva = $item['costo'] * ($academia->porcentaje_impuesto / 100);
            $tmp[]=array('id' => $item['id'], 'nombre' => $item['nombre'] , 'costo' => $item['costo'], 'iva' => $iva, 'incluye_iva' => $item['incluye_iva']);

            $collection=collect($tmp);
            $grouped = $collection->groupBy('id');     
            $servicio = $grouped->toArray();

            // dd($servicio);

        }

        $config_producto=ConfigProductos::where('academia_id', '=' ,  Auth::user()->academia_id)->get();
        $producto=array();

        foreach($config_producto as $items){

            $iva = $items['costo'] * ($academia->porcentaje_impuesto / 100);
            $tmp2[]=array('id' => $items['id'], 'nombre' => $items['nombre'] , 'costo' => $items['costo'], 'iva' => $iva, 'incluye_iva' => $items['incluye_iva']);

            $collection2=collect($tmp2);
            $grouped2 = $collection2->groupBy('id');     
            $producto = $grouped2->toArray();
        }

		return view('administrativo.pagos.pagos')->with(['alumnos' => Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'servicio' => $servicio, 'producto' => $producto, 'impuesto' => $academia->porcentaje_impuesto]);
	}

    // public function gestion($id)
    // {
    //     $proforma = FacturaProforma::find($id);
    //     $alumno = Alumno::where('id', '=', $proforma->alumno_id)->first();
    //     $academia = Academia::find(Auth::user()->academia_id);

    //     if($proforma)
    //     {

    //         if (Session::has('pagos')) {
    //             Session::forget('pagos'); 
    //         }

    //         $item_factura = ItemsFacturaProforma::where('factura_id', '=', $id)->get();

    //         $factura = DB::table('facturas')->orderBy('created_at', 'desc')->first();

    //         $formas_pago = DB::table('formas_pago')->get();

    //         if($factura){

    //             $numero_factura = $factura->numero_factura + 1;
    //         }
    //         else{

    //             if($academia->numero_factura){
    //                 $numero_factura = $academia->numero_factura;
    //             }
    //             else{
    //                 $numero_factura = 1;
    //             }
                
    //         }
            

    //         $subtotal = 0;
    //         $impuesto = 0;

    //         foreach($item_factura as $item){

    //             $subtotal = $subtotal + $item['importe_neto'];

    //             if($item['impuesto']){
    //                 $impuesto = $impuesto + ($item['importe_neto'] * ($item['impuesto'] / 100));
    //             }

    //         }

    //         $total = $subtotal + $impuesto;

    //         // dd($academia->porcentaje_impuesto);

    //         return view('administrativo.pagos.gestion')->with(['subtotal' => $subtotal, 'impuesto' => $impuesto, 'total' => $total, 'numero_factura' => $numero_factura , 'formas_pago' => $formas_pago, 'id' => $id, 'alumno' => $alumno , 'porcentaje_impuesto' => $academia->porcentaje_impuesto]);
    //     }
    //     return view('menu.index');
    // }

    public function generarpagoscondeuda($id)
    {
        // if (Auth::check())
        // {
            $academia = Academia::find(Auth::user()->academia_id);

        // }
        
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

        $config_servicio=ConfigServicios::where('academia_id', '=' ,  Auth::user()->academia_id)->get();
        $servicio=array();

        foreach($config_servicio as $item){

            $iva = $item['costo'] * ($academia->porcentaje_impuesto / 100);
            $tmp[]=array('id' => $item['id'], 'nombre' => $item['nombre'] , 'costo' => $item['costo'], 'iva' => $iva, 'incluye_iva' => $item['incluye_iva']);

            $collection=collect($tmp);
            $grouped = $collection->groupBy('id');     
            $servicio = $grouped->toArray();

            // dd($servicio);

        }

        $config_producto=ConfigProductos::where('academia_id', '=' ,  Auth::user()->academia_id)->get();
        $producto=array();

        foreach($config_producto as $items){

            $iva = $items['costo'] * ($academia->porcentaje_impuesto / 100);
            $tmp2[]=array('id' => $items['id'], 'nombre' => $items['nombre'] , 'costo' => $items['costo'], 'iva' => $iva, 'incluye_iva' => $items['incluye_iva']);

            $collection2=collect($tmp2);
            $grouped2 = $collection2->groupBy('id');     
            $producto = $grouped2->toArray();
        }

        return view('administrativo.pagos.pagos')->with(['alumno' => Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'servicio' => $servicio, 'producto' => $producto, 'impuesto' => $academia->porcentaje_impuesto, 'id' => $id]);
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

            $item_factura = explode(",", $request->items_factura);

            if($request->alumno_id == ''){
                return response()->json(['errores' => ['alumno_id' => [0, 'Ups! El Cliente es requerido']], 'status' => 'ERROR'],422);
            }

            if($request->items_factura == ''){

                $items_factura = ItemsFacturaProforma::where('alumno_id', '=', $request->alumno_id)->get();

                if($items_factura){

                    foreach($items_factura as $item){

                        $total = $total + $item->importe_neto;
                        Session::push('id_proforma', $item->id);
                    
                    } 

                }else{

                    return response()->json(['errores' => ['combo' => [0, 'Debe seleccionar un item a pagar primero']], 'status' => 'ERROR'],422);
                }

            }else{

                foreach($item_factura as $id){

                    $items_factura = ItemsFacturaProforma::where('id', '=', $id)->first();

                    if($items_factura){

                        $total = $total + $items_factura->importe_neto;
                        Session::push('id_proforma', $items_factura->id);
                    }
     
                }
            }
            $array = array(['total' => $total, 'alumno_id' => $request->alumno_id]);
            Session::put('gestion', $array);

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function gestionar(Request $request){

        if (Session::has('pagos')) {
            Session::forget('pagos'); 
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

            $arreglo = Session::get('gestion');

            $alumno_id = $arreglo[0]['alumno_id'];
            $alumno = Alumno::where('id', '=', $alumno_id)->first();
            $total = $arreglo[0]['total'];

            $acuerdos_pendientes = DB::table('items_factura_proforma')
            ->select('items_factura_proforma.*')
            ->where('alumno_id', '=', $alumno_id )
            ->where('tipo' , '=', 6)
            ->get();

            if($acuerdos_pendientes){
                $acuerdo = 1;
            }else{
                $acuerdo = 0;
            }

        //MERCADO PAGO
        /*$preference_data = array(
        "items" => array(
            array(
            //"id" => $array['mov_id'],
            //"title" => $array['mov_nomplan'].', este paquete incluye '.$array['mov_sms'].' SMS',
            "currency_id" => "VEF",
            "title" => 'Servicio',
            "picture_url" => "http://app.easydancelatino.com/assets/img/EASY_DANCE_3_.jpg",
            "description" => 'Servicio de Baile',
            //"category_id" => "Category",
            "quantity" => 1,
            "unit_price" =>  4 //intval($total)
            )
        ),
            "payer" => array(
              "name" => $alumno->nombre,
              "surname" => $alumno->apellido,
              "email" => $alumno->correo,
              //"date_created" => "2014-07-28T09:50:37.521-04:00"
            )
        );
        $preference = MP::create_preference($preference_data);*/

        return view('administrativo.pagos.gestion')->with(['total' => $total, 'numero_factura' => $numero_factura , 'formas_pago' => $formas_pago, 'alumno' => $alumno , 'porcentaje_impuesto' => $academia->porcentaje_impuesto, 'acuerdo' => $acuerdo/*, 'datos' => $preference*/]);

    }

    public function gestionardeuda($id){

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

            $alumno_id = $factura_proforma->alumno_id;
            $alumno = Alumno::where('id', '=', $alumno_id)->first();
            $total = $factura_proforma->importe_neto;
            Session::push('id_proforma', $id);

        return view('administrativo.pagos.gestion')->with(['total' => $total, 'numero_factura' => $numero_factura , 'formas_pago' => $formas_pago, 'alumno' => $alumno , 'porcentaje_impuesto' => $academia->porcentaje_impuesto]);

    }

    public function agregarpago(Request $request){

        
    $rules = [

        'forma_pago_id' => 'required',
        'monto' => 'required|numeric|min:1',
    ];

    $messages = [

        'forma_pago_id.required' => 'Ups! La forma de pago es requerida',
        'monto.required' => 'Ups! El Monto es invalido, solo se aceptan numeros',
        'monto.numeric' => 'Ups! El Monto es requerido',
        'monto.min' => 'El mínimo de cantidad permitida es 1',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $forma_pago = DB::table('formas_pago')
        ->where('id' , '=' , $request->forma_pago_id)
        ->first();

        $array = array(['forma_pago' => $request->forma_pago_id , 'banco' => $request->banco, 'referencia' => $request->referencia, 'monto' => $request->monto]);

        Session::push('pagos', $array);

        $array2 = array(['forma_pago' => $forma_pago->nombre , 'banco' => $request->banco, 'referencia' => $request->referencia, 'monto' => $request->monto]);

        $items = Session::get('pagos');
        end( $items );
        $contador = key( $items );

         return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array2, 'id' => $contador, 200]);

        }
    }

    public function eliminarpago($id){

        $arreglo = Session::get('pagos');
        $monto = $arreglo[$id][0]['monto'];

        unset($arreglo[$id]);
        Session::put('pagos', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'monto' => $monto, 200]);

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

        $total_proforma = $request->total;
        $total_pago = 0;

        $numerofactura = DB::table('facturas')
            ->select('facturas.*')
            ->orderBy('created_at', 'desc')
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

        $factura->alumno_id = $request->id;
        $factura->academia_id = Auth::user()->academia_id;
        $factura->fecha = Carbon::now()->toDateString();
        $factura->hora = Carbon::now()->toTimeString();
        $factura->numero_factura = $numero_factura;
        $factura->concepto = $concepto;
       
        if($factura->save()){

            $factura_id = $factura->id;


            for($i = 0; $i < count($arreglo) ; $i++)
            
            {

                $forma_pago = $arreglo[$i][0]['forma_pago'];
                $banco = $arreglo[$i][0]['banco'];
                $referencia = $arreglo[$i][0]['referencia'];
                $monto = $arreglo[$i][0]['monto'];
            
                $pago = new Pago;

                $pago->alumno_id = $request->id;
                $pago->academia_id = Auth::user()->academia_id;
                $pago->fecha = Carbon::now()->toDateString();
                $pago->factura_id = $factura->id;
                $pago->monto = $monto;
                $pago->referencia = $referencia;
                $pago->forma_pago = $forma_pago;
                $pago->banco = $banco;
                
                $pago->save();

                $total_pago = $total_pago + $arreglo[$i][0]['monto'];

            }  

            $array_descripcion = array();

            for($i = 0; $i < $contador ; $i++)
            {
                $id = $id_proforma[$i];

                $item_proforma = ItemsFacturaProforma::where('id', '=', $id)->first();

            }

            $descripcion = implode(",", $array_descripcion);

            if($total_proforma <= $total_pago)
            {

                for($i = 0; $i < $contador ; $i++)
                {
                    $id = $id_proforma[$i];

                    $item_proforma = ItemsFacturaProforma::where('id', '=', $id)->first();

                    if($item_proforma){

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
                }

                else{

                    for($i = 0; $i < $contador ; $i++)
                    {
                        $id = $id_proforma[$i];

                        $item_proforma = ItemsFacturaProforma::find($id)->delete();
                    
                    }

                    $deuda = $total_proforma - $total_pago;

                    $item_factura = new ItemsFactura;

                    $item_factura->factura_id = $factura_id;
                    $item_factura->item_id = $factura->id;
                    $item_factura->nombre = 'Abono Factura ' . $numero_factura;
                    $item_factura->tipo = 11;
                    $item_factura->cantidad = 1;
                    $item_factura->precio_neto = 0;
                    $item_factura->impuesto = 0;
                    $item_factura->importe_neto = $total_pago;
                    
                    $item_factura->save();

                    $items_factura_proforma = new ItemsFacturaProforma;

                    $items_factura_proforma->alumno_id = $request->id;
                    $items_factura_proforma->academia_id = Auth::user()->academia_id;
                    $items_factura_proforma->fecha = Carbon::now()->toDateString();
                    $items_factura_proforma->item_id = $factura->id;
                    $items_factura_proforma->nombre = 'Remanente Factura ' . $numero_factura;
                    $items_factura_proforma->tipo = 7;
                    $items_factura_proforma->cantidad = 1;
                    $items_factura_proforma->precio_neto = 0;
                    $items_factura_proforma->impuesto = 0;
                    $items_factura_proforma->importe_neto = $deuda;
                    $items_factura_proforma->fecha_vencimiento = Carbon::now()->toDateString();
                    
                    $items_factura_proforma->save();

                    // return response()->json(['mensaje' => '¡Excelente! El campo se ha eliminado satisfactoriamente', 'status' => 'OK', 'entro' => 'entro', 200]);

                }

                //FINAL

                $academia = Academia::find(Auth::user()->academia_id);
                $usuario = User::where('usuario_id', $request->id)->first();

                if($usuario->familia_id){
                    $es_representante = Familia::where('representante_id', $usuario->id)->first();
                    if($es_representante){
                        $correo = $usuario->email;
                    }else{
                        $familia = Familia::find($usuario->familia_id);
                        $representante = User::find($familia->representante_id);
                        $correo = $representante->email;
                    }
                }else{
                    $correo = $usuario->email;
                }

                $subj = 'Pago realizado exitósamente';

                $array = [

                   'correo_destino' => $correo,
                   'nombre' => $academia->nombre,
                   'correo' => $academia->correo,
                   'telefono' => $academia->celular,
                   'fecha' => Carbon::now()->toDateString(),
                   'hora' => Carbon::now()->toTimeString(),
                   'factura' => $numero_factura,
                   'total' => $total_pago,
                   'descripcion' => $descripcion,
                   'subj' => $subj
                ];

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

     }
        return response()->json(['errores' => ['linea' => [0, 'Ups! ha ocurrido un error, debes agregar una linea de pago']], 'status' => 'ERROR'],422);
    }


    public function enviarfactura($id)
    {
            
            $academia = Academia::find(Auth::user()->academia_id);
            $factura = Factura::find($id);
            $total_pago = Pago::where('factura_id', $id)->sum('monto');
            $alumno = Alumno::find($factura->alumno_id);

            $array_descripcion = array();

            $item_factura = ItemsFactura::where('factura_id', '=', $factura->id)->get();

            foreach($item_factura as $item){

                array_push($array_descripcion, $item->cantidad . ' ' . $item->nombre);
               
            }

            $descripcion = implode(",", $array_descripcion);

            $subj = 'Pago realizado exitósamente';

            $array = [

               'correo_destino' => $alumno->correo,
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

            return response()->json(['mensaje' => '¡Excelente! El campo se ha eliminado satisfactoriamente', 'status' => 'OK', 'factura' => $factura->id, 200]);

    }

    public function principalacuerdo()
    {
        $acuerdo_join = DB::table('acuerdos')
            ->join('alumnos', 'acuerdos.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'acuerdos.*')
        ->get();

        return view('administrativo.acuerdo.principal')->with('acuerdos' , $acuerdo_join);
    }

    public function acuerdo()
    {
        Session::forget('acuerdos');
        
        return view('administrativo.acuerdo.acuerdo')->with(['alumnos' => Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get()]);
    }

    public function acuerdoconalumno($id)
    {
            $total = 0;

            if(Session::has('acuerdos'))
            {
                Session::forget('acuerdos'); 
            }
            
            $items_factura = ItemsFacturaProforma::where('alumno_id', '=', $id)->get();

            foreach($items_factura as $item_factura){

                $total = $total + $item_factura['importe_neto'];

            }

            $acuerdos_pendientes = DB::table('items_factura_proforma')
            ->select('items_factura_proforma.*')
            ->where('alumno_id', '=', $id)
            ->where('tipo' , '=', 6)
            ->get();

            if($acuerdos_pendientes){
                $acuerdo = 1;
            }
            else{
                $acuerdo = 0;
            }
        
        return view('administrativo.acuerdo.acuerdo')->with(['alumnos' => Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'id' => $id, 'total' => $total, 'acuerdo' => $acuerdo]);
    }

    public function principalpresupuesto()
    {
      
        $presupuesto_join = DB::table('presupuestos')
            ->join('alumnos', 'presupuestos.alumno_id', '=', 'alumnos.id')
            // ->join('pagos', 'facturas.id', '=', 'pagos.factura_id')
            ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'presupuestos.fecha as fecha', 'presupuestos.fecha_valida as fecha_valida', 'presupuestos.id as id')
            ->where('presupuestos.academia_id' , '=' , Auth::user()->academia_id)
            ->OrderBy('presupuestos.created_at')
        ->get();

        $items_presupuesto = DB::table('presupuestos')
            ->join('items_presupuesto', 'items_presupuesto.presupuesto_id', '=', 'presupuestos.id')
            ->select('items_presupuesto.importe_neto', 'presupuestos.id')
            ->where('presupuestos.academia_id' , '=' , Auth::user()->academia_id)
            ->OrderBy('presupuestos.created_at')
        ->get();

        $collection=collect($items_presupuesto);
        $grouped = $collection->groupBy('id');     
        $deuda = $grouped->toArray();

        $array=array();
        $i = 0;
        $importe_neto = 0;
        $total = 0;

        foreach($deuda as $item){
            $importe_neto = 0;
            
            foreach($item as $tmp){

            $factura_id = $tmp->id;
            $importe_neto = $importe_neto + $tmp->importe_neto;
            // $id_alumno = $item['']
            // $iva = $item['costo'] * ($academia->porcentaje_impuesto / 100);
            }
            // $factura_join[$i]->setAttribute('total',  $importe_neto);
            // $factura_join[$id]->total = $importe_neto;
            $presupuesto_join[$i]->total=$importe_neto;
            $array[$factura_id] = $presupuesto_join[$i];
            $i = $i + 1;
        }

        return view('administrativo.presupuesto.principal')->with('presupuestos', $array);
    }

    public function presupuesto()
    {
        // if (Auth::check())
        // {
            $academia = Academia::find(Auth::user()->academia_id);

        // }
        
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


        return view('administrativo.presupuesto.presupuesto')->with(['alumnos' => Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'servicio' => $servicio, 'producto' => $producto, 'impuesto' => $academia->porcentaje_impuesto]);
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
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

            // $iva = $precio_neto * ($request->impuestoglobal / 100);
            // $importe_neto = $precio_neto - $iva;

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

            // $iva = $precio_neto * ($request->impuestoglobal / 100);
            // $importe_neto = $precio_neto - $iva;

            $array = array(['id' => $id[0] , 'nombre' => $producto->nombre , 'tipo' => 2, 'cantidad' => $request->cantidad, 'precio_neto' => $producto->costo, 'impuesto' => $request->impuesto, 'importe_neto' => $importe_neto]);
            }


        Session::push('arreglo', $array);

        // $contador = count(Session::get('arreglo'));
        // $contador = $contador - 1;

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

        // unset($arreglo[$id]);
        unset($arreglo[$id]);
        // Session::forget('arreglo');
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
        // return redirect("alumno");
    }


    public function agregaritem(Request $request){
        
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

            $item_factura = new ItemsFacturaProforma;
                        
            $item_factura->alumno_id = $request->alumno_id;
            $item_factura->academia_id = Auth::user()->academia_id;
            $item_factura->fecha = Carbon::now()->toDateString();
            $item_factura->item_id = $id[0];
            $item_factura->nombre = $servicio->nombre;
            $item_factura->tipo = 1;
            $item_factura->cantidad = $request->cantidad;
            $item_factura->precio_neto = $servicio->costo;
            $item_factura->impuesto = $request->impuesto;
            $item_factura->importe_neto = $importe_neto;
            $item_factura->fecha_vencimiento = Carbon::now()->toDateString();
                        
            $item_factura->save();

            $array = array(['id' =>  $item_factura->id, 'item_id' => $id[0] , 'nombre' => $servicio->nombre , 'tipo' => 1, 'cantidad' => $request->cantidad, 'precio_neto' => $servicio->costo, 'impuesto' => $request->impuesto, 'importe_neto' => $importe_neto, 'operacion' => '<i class="zmdi zmdi-delete f-20 p-r-10 pointer"></i>']);

            }else if($request->tipo == "producto"){


                $producto = ConfigProductos::find($id[0]);
                $importe_neto = $producto->costo * $request->cantidad;

                if($request->impuesto == 0 and $producto->incluye_iva == 1){
                     $academia = Academia::find(Auth::user()->academia_id);
                     $iva = $importe_neto * ($academia->porcentaje_impuesto / 100);

                     $importe_neto = $importe_neto - $iva;
                }

                $item_factura = new ItemsFacturaProforma;
                        
                $item_factura->alumno_id = $request->alumno_id;
                $item_factura->academia_id = Auth::user()->academia_id;
                $item_factura->fecha = Carbon::now()->toDateString();
                $item_factura->item_id = $id[0];
                $item_factura->nombre = $producto->nombre;
                $item_factura->tipo = 2;
                $item_factura->cantidad = $request->cantidad;
                $item_factura->precio_neto = $producto->costo;
                $item_factura->impuesto = $request->impuesto;
                $item_factura->importe_neto = $importe_neto;
                $item_factura->fecha_vencimiento = Carbon::now()->toDateString();
                            
                $item_factura->save();

                $array = array(['id' => $item_factura->id, 'item_id' => $id[0] , 'nombre' => $producto->nombre , 'tipo' => 2, 'cantidad' => $request->cantidad, 'precio_neto' => $producto->costo, 'impuesto' => $request->impuesto, 'importe_neto' => $importe_neto , 'operacion' => '<i class="zmdi zmdi-delete f-20 p-r-10 pointer"></i>']);
                }

                 $last_proforma = DB::table('items_factura_proforma')
                    ->where('fecha' , '=', Carbon::now()->toDateString())
                    ->where('academia_id' , '=', Auth::user()->academia_id)
                ->get();

         return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'proforma' => $last_proforma , 200]);

    }
    }

    public function eliminaritem($id){

        $factura_proforma = ItemsFacturaProforma::find($id);

        $impuesto = $factura_proforma->impuesto;
        $importe_neto = $factura_proforma->importe_neto;

        $impuesto_total = $importe_neto * ($impuesto / 100);

        if(ItemsFacturaProforma::find($id)->delete()){

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'impuesto' => $impuesto_total, 'importe_neto' => $importe_neto, 200]);
        }else{

            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);

        }

        

    }

	public function PrimerPaso(Request $request)
	{

        return view('administrativo.segundopaso')->with(['factura' => $request, 'impuesto' => Impuesto::all(), 'config_productos' => ConfigProductos::all()]);

	}


    public function storeProforma(Request $request)
    {
        
    $rules = [

        'alumno_id' => 'required',

    ];

    $messages = [

        'alumno_id.required' => 'Ups! El Cliente es requerido',
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
                    
                    $item_factura->alumno_id = $request->alumno_id;
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

                    Session::push('id_proforma', $item_factura->id);

                    $total = $total + $importe_neto;

                }

                $array = array(['total' => $total , 'alumno_id' => $request->alumno_id]);
                Session::put('gestion', $array);

                return response()->json(['status' => 'OK', 200]);
                
        }
            return response()->json(['errores' => ['linea' => [0, 'DDebe agregar una linea de pago']], 'status' => 'ERROR'],422);
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

    }

    else{

        $fecha_valida = Carbon::createFromFormat('d/m/Y', $request->fecha_valida)->toDateString();
        

        if($fecha_valida < Carbon::now()->toDateString())
        {
            return response()->json(['errores' => ['fecha_valida' => [0, 'Fecha Invalida']],  'status' => 'ERROR'],422);
        }

        if (Session::has('arreglo')) {
               
                $arreglo = Session::get('arreglo');

                if (count($arreglo) == 0){

                    return response()->json(['errores' => ['linea' => [0, 'Debe agregar una linea de pago']], 'status' => 'ERROR'],422);
                }


            $presupuesto = new Presupuesto;

            $presupuesto->alumno_id = $request->alumno_id;
            $presupuesto->academia_id = Auth::user()->academia_id;
            $presupuesto->fecha = Carbon::now()->toDateString();
            $presupuesto->fecha_valida = $fecha_valida;
            $presupuesto->nota_cliente = $request->nota_cliente;


            if($presupuesto->save()){

            $save = true;

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
            
            if($save){

                $total = ItemsPresupuesto::where('id', '=', $presupuesto->id)->sum('precio_neto');

                $alumno = Alumno::find($request->alumno_id);

                return response()->json(['alumno'=> $alumno, 'presupuesto' => $presupuesto->id, 'total' => $total, 'status' => 'OK', 200]);

                // return redirect('administrativo/pagos2/{{$factura->id}}')->with(['alumno'=> $alumno, 'factura' => $factura->id, 'total' => $total]);
                // return redirect("/home")
            
            }else{
                
                // $destroy = FacturaProforma::find($factura->id);
                // $destroy->delete();
                return response()->json(['errores'=>'error', 'status' => 'ERROR-REGISTROITEM'],422);

        }
        
        // return redirect("/home");
        //return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
    }

        return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
    }
        return response()->json(['errores' => ['linea' => [0, 'Debe agregar una linea de pago']], 'status' => 'ERROR'],422);
    }
    }
    

	public function updateContacto(Request $request){

    $rules = [
        'correo' => 'email|max:255',
        'telefono' => 'digits:11',
        'celular' => 'digits:11',
    ];

    $messages = [

        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'correo.max' => 'El máximo de caracteres permitidos son 255',
        'correo.unique' => 'Ups! Ya este correo ha sido registrado',
        'telefono.digits' => 'El telefono local debe poseer 11 digitos',
        'celular.digits' => 'El telefono local debe poseer 11 digitos',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        // return redirect("alumno/edit/{$request->id}")

        // ->withErrors($validator)
        // ->withInput();
        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }

    else{

		$academia = Academia::find($request->academia_id);

        $academia->correo = $request->correo;
        $academia->telefono = $request->telefono;
        $academia->celular = $request->celular;
        $academia->geolocalizacion = $request->geolocalizacion;
        $academia->facebook = $request->facebook;
        $academia->twitter = $request->twitter;
        $academia->linkedin = $request->linkedin;
        $academia->instagram = $request->instagram;
        $academia->pagina_web = $request->pagina_web;
        $academia->youtube = $request->youtube;
		
        if($academia->save()){
            // return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            return view('academia.especiales')->with('academia', $academia);

        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
		// return redirect("alumno/edit/{$request->id}");
		}
	}

	public function updateEspeciales(Request $request){

        $academia = Academia::find($request->academia_id);
        $id = $request->academia_id;

		$normativa = $request->normativa;
		$manual = $request->manual;
        $programacion = $request->programacion;

        $nombre_normativa = $academia->nombre." - ".$id.".pdf";
        $nombre_manual = $academia->nombre." - ".$id.".pdf";
        $nombre_programacion = $academia->nombre." - ".$id.".pdf";

        if (!empty($normativa)) {
            $r_normativa = Storage::disk('normativas')->put($nombre_normativa,  \File::get($normativa));
            if($r_normativa){
                $academia->normativa = "normativas/".$nombre_normativa;
            }
        }
        if (!empty($manual)) {
             $r_manual = Storage::disk('manuales')->put($nombre_manual,  \File::get($manual));
            if($r_manual){
                $academia->manual = "manuales/".$nombre_manual;
            }
        }
        
        if (!empty($programacion)) {
            $r_programacion = Storage::disk('programaciones')->put($nombre_programacion,  \File::get($programacion));
            if($r_programacion){
                $academia->programacion = "programaciones/".$nombre_programacion;
            }
        }
        
       if($academia->save()){
            // return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            return view('academia.administrativo')->with('academia', $academia);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

	}

    public function updateAdministrativo(Request $request){

    $rules = [
        'porcentaje_impuesto' => 'required|numeric',
        'numero_factura' => 'required|numeric',

    ];

    $messages = [
        
        'porcentaje_impuesto.required' => 'Ups! Debes ingresar el campo de Porcentaje de impuesto',
        'porcentaje_impuesto.numeric' => 'Ups! El campo de Porcentaje de impuesto  en inválido , debe contener sólo números',
        'numero_factura.required' => 'Ups! Debes ingresar el campo de Próximo número de factura',
        'numero_factura.numeric' => 'Ups! El campo de “ Próximo número de factura” es inválido, debe contener sólo  números',

    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        // return redirect("alumno/edit/{$request->id}")

        // ->withErrors($validator)
        // ->withInput();
        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }

    else{

        $academia = Academia::find($request->academia_id);

        $academia->porcentaje_impuesto = $request->porcentaje_impuesto;
        $academia->numero_factura = $request->numero_factura;

        
        if($academia->save()){
            // return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            return view('alumno.index')->with('academia', $academia);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
        }
    }

    public function generar_acuerdo(Request $request)
    {
        //dd($request->fecha);


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

            //dd($fecha_acuerdo);

            $dt = Carbon::create($fecha_acuerdo[2], $fecha_acuerdo[1], $fecha_acuerdo[0], 0);
            $arrayAcuerdoFecha=array();
            $arrayAcuerdo=array();
            $ff =Carbon::createFromFormat('Y-m-d', $dt->toDateString())->format('d-m-Y');
            $arrayAcuerdoFecha[]=array("numero"=>1, "fecha_frecuencia"=>$ff, "cantidad"=>number_format($cantidad, 2,'.','') );

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
                
                $arrayAcuerdoFecha[]=array("numero"=>$i+1, "fecha_frecuencia"=>$ff, "cantidad"=>number_format($cantidad, 2,'.','') );

            }

            //dd($arrayAcuerdo);

            $arrayAcuerdo=array('frecuencia'=>$frecuencia, 'partes'=>$partes , 'fechas_acuerdo'=>$arrayAcuerdoFecha);

            Session::put('acuerdos', $arrayAcuerdo); 

            return response()->json(['mensaje' => '¡Excelente! Los acuerdos han sido generados', 'status' => 'OK', 200, 'acuerdos'=>$arrayAcuerdo]);
        }
    }

    public function storeAcuerdo(Request $request)
    {
        
    $rules = [

        'alumno_id' => 'required',

    ];

    $messages = [

        'alumno_id.required' => 'Ups! El Cliente es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
    }

    else{

            if (Session::has('acuerdos')) {
               
                $arreglo = Session::get('acuerdos');

                if (count($arreglo) == 0){

                    return response()->json(['errores' => ['linea' => [0, 'Debes generar un acuerdo primero']], 'status' => 'ERROR'],422);
                }

                $item_proforma = ItemsFacturaProforma::where('alumno_id', '=', $request->alumno_id)->get();

                $delete = ItemsFacturaProforma::where('alumno_id', '=', $request->alumno_id)->delete();

                $array_descripcion = array();

                foreach($item_proforma as $items_proforma){

                    array_push($array_descripcion, $items_proforma->cantidad . ' ' . $items_proforma->nombre);

                }

                $descripcion = implode(",", $array_descripcion);

                $subtotal = 0;
                $impuestototal = 0;
                $total = 0;

                $fechas_acuerdo = $arreglo['fechas_acuerdo'];

                $acuerdo = new Acuerdo;

                $acuerdo->academia_id = Auth::user()->academia_id;
                $acuerdo->alumno_id = $request->alumno_id;
                $acuerdo->fecha_inicio = Carbon::createFromFormat('d-m-Y', $arreglo['fechas_acuerdo'][0]['fecha_frecuencia'])->toDateString();
                $acuerdo->frecuencia = $arreglo['frecuencia'];
                $acuerdo->cuotas = $arreglo['partes'];
                $acuerdo->save();

                foreach($fechas_acuerdo as $fechas){

                    $fecha = Carbon::createFromFormat('d-m-Y', $fechas['fecha_frecuencia'])->toDateString();

                    $id = $acuerdo->id;
                    $nombre = 'Acuerdo de pago para ' . $descripcion;
                    $tipo = 6;
                    $cantidad = 1;
                    $precio_neto = 0;
                    $impuesto = 0;
                    $importe_neto = $fechas['cantidad'];
                    //$fecha_vencimiento = Carbon::create($fecha_acuerdo[2], $fecha_acuerdo[1], $fecha_acuerdo[0], 0)->toDateString();
                
                   $item_factura = new ItemsFacturaProforma;
                    
                    $item_factura->alumno_id = $request->alumno_id;
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

                    $total = $total + $importe_neto;

                }

                $acuerdo->total = $total;

                if($acuerdo->save()){
                    return response()->json(['status' => 'OK', 200]);
                }
                else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-ACUERDO'],422);
                }
                     
        }
            return response()->json(['errores' => ['linea' => [0, 'Debes generar un acuerdo primero']], 'status' => 'ERROR'],422);
        }

    }

    public function eliminaracuerdo($id)
    {
        $items_acuerdo = ItemsFacturaProforma::where('item_id',$id)->where('tipo', 6)->delete();

        $acuerdo = Acuerdo::find($id);
        
        if($acuerdo->delete()){
            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno");
    }

        public function getFactura($id){
        //DATOS DE ENCABEZADO
        
        $factura = Factura::find($id);
        $alumno = DB::table('facturas')->join('alumnos', 'facturas.alumno_id','=','alumnos.id')
                            ->select('alumnos.nombre AS alumno_nombre', 'alumnos.apellido AS alumno_apellido', 'alumnos.identificacion AS dni', 'alumnos.direccion AS direccion', 'alumnos.telefono AS telefono', 'alumnos.correo AS email')
                            ->where('facturas.id','=',$id)
                            ->first();

        $academia = DB::table('facturas')
                            ->join('academias', 'facturas.academia_id','=','academias.id')
                            ->join('paises', 'academias.pais_id','=','paises.id')
                            ->select('academias.nombre AS academia_nombre', 'academias.direccion AS academia_direccion', 'academias.telefono AS academia_telefono', 'academias.correo AS academia_email', 'paises.nombre as academia_pais', 'academias.imagen as imagen_academia', 'academias.porcentaje_impuesto')
                            ->where('facturas.id','=',$id)
                            ->first();

        $PerctIVA = 0;
                            

        // $subtotales = DB::table('facturas')->join('items_factura','facturas.id','=','items_factura.factura_id')
        //             ->select('items_factura.precio_neto AS subtotal')
        //             ->where('facturas.id','=',$id)
        //             ->sum('items_factura.importe_neto');

        // $IvaBs = ($subtotales * $PerctIVA)/100;
        // $subtotales = $subtotales - $IvaBs;
        // $total = $subtotales + $IvaBs;

        // $IvaBs = ($subtotales * $PerctIVA)/100;

        // $total = $subtotales + $IvaBs;

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
                'alumno'            => $alumno, 
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
                            

        // $subtotales = DB::table('facturas')->join('items_factura','facturas.id','=','items_factura.factura_id')
        //             ->select('items_factura.precio_neto AS subtotal')
        //             ->where('facturas.id','=',$id)
        //             ->sum('items_factura.importe_neto');

        // $IvaBs = ($subtotales * $PerctIVA)/100;
        // $subtotales = $subtotales - $IvaBs;
        // $total = $subtotales + $IvaBs;

        // $IvaBs = ($subtotales * $PerctIVA)/100;

        // $total = $subtotales + $IvaBs;

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
        $alumno = DB::table('acuerdos')->join('alumnos', 'acuerdos.alumno_id','=','alumnos.id')
                            ->select('alumnos.nombre AS alumno_nombre', 'alumnos.apellido AS alumno_apellido', 'alumnos.identificacion AS dni', 'alumnos.direccion AS direccion', 'alumnos.telefono AS telefono', 'alumnos.correo AS email')
                            ->where('acuerdos.id','=',$id)
                            ->first();

        $academia = DB::table('acuerdos')
                            ->join('academias', 'acuerdos.academia_id','=','academias.id')
                            ->join('paises', 'academias.pais_id','=','paises.id')
                            ->select('academias.nombre AS academia_nombre', 'academias.direccion AS academia_direccion', 'academias.telefono AS academia_telefono', 'academias.correo AS academia_email', 'paises.nombre as academia_pais', 'academias.imagen as imagen_academia', 'academias.porcentaje_impuesto')
                            ->where('acuerdos.id','=',$id)
                            ->first();

        $PerctIVA = 0;
                            

        // $subtotales = DB::table('facturas')->join('items_factura','facturas.id','=','items_factura.factura_id')
        //             ->select('items_factura.precio_neto AS subtotal')
        //             ->where('facturas.id','=',$id)
        //             ->sum('items_factura.importe_neto');

        // $IvaBs = ($subtotales * $PerctIVA)/100;
        // $subtotales = $subtotales - $IvaBs;
        // $total = $subtotales + $IvaBs;

        // $IvaBs = ($subtotales * $PerctIVA)/100;

        // $total = $subtotales + $IvaBs;

        $subtotal = 0;
        $impuesto = 0;

        //DATOS DE DETALLE
        $detalle = ItemsFacturaProforma::select('id', 'item_id', 'nombre', 'tipo', 
                                        'cantidad', 'precio_neto', 'impuesto', 'importe_neto')
                                ->where('tipo','=', 6)
                                ->where('item_id','=',$id)
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
                'alumno'            => $alumno, 
                'academia'          => $academia, 
                'subtotal'          => $subtotal, 
                'iva'               => $impuesto, 
                'total'             => $total, 
                'porcentajeIVA'     => $PerctIVA,
                'detalleFactura'    => $detalle 
                ]);
    }


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
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

	public function pendientes($id)
    {
            if (Session::has('pendientes')) {
                Session::forget('pendientes'); 
            }

            $items_factura = DB::table('facturas_proforma')
                ->join('items_factura_proforma', 'facturas_proforma.id', '=', 'items_factura_proforma.factura_id')
                ->select('items_factura_proforma.*')
                ->where('facturas_proforma.alumno_id', '=', $id)
            ->get();

            $i = 0;

            foreach($items_factura as $item_factura){

                // $items = Session::get('arreglo');
                // end( $items );
                // $contador = key( $items );

                $array = array(['factura' => $item_factura->id, 'id' => $item_factura->item_id , 'nombre' => $item_factura->nombre  , 'tipo' => $item_factura->tipo , 'cantidad' => $item_factura->cantidad , 'precio_neto' => $item_factura->precio_neto , 'impuesto' => $item_factura->impuesto , 'importe_neto' => $item_factura->importe_neto ]);

                Session::push('pendientes', $array);
                $i = $i + 1;
            }

            
            $arreglo = Session::get('pendientes');

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $arreglo, 200]);

    }

    public function pagospendientes($id)
    {
            $subtotal = 0;
            $impuesto = 0;

            if(Session::has('acuerdos'))
            {
             Session::forget('acuerdos'); 
            }

            $acuerdos_pendientes = DB::table('items_factura_proforma')
            ->select('items_factura_proforma.*')
            ->where('alumno_id', '=', $id)
            ->where('tipo' , '=', 6)
            ->get();

            if($acuerdos_pendientes){
                return response()->json(['errores' => ['alumno_id' => [0, 'No se puede generar un acuerdo de pago, debido a que este participante ya posee uno asignado']], 'status' => 'ERROR'],422);
            }
            
            $items_factura = ItemsFacturaProforma::where('alumno_id', '=', $id)->get();

            $total = 0;

            foreach($items_factura as $item_factura){

                $total = $total + $item_factura['importe_neto'];

            }

            if($total > 0){
                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'total' => $total, 200]);
            }
            else{
                return response()->json(['errores' => ['alumno_id' => [0, 'Este participante no presenta deuda para generar acuerdo de pago, selecciona otro participante']], 'status' => 'ERROR'],422);
            }
    }

    public function itemspendientes($id)
    {
            
            $items_factura = ItemsFacturaProforma::where('alumno_id', '=', $id)->get();

            $total = 0;
            $i = 0;
            $array = array();
            foreach($items_factura as $item_factura){

                $array[] = array(['id' => $item_factura->id, 'item_id' => $item_factura->item_id , 'nombre' => $item_factura->nombre , 'tipo' => $item_factura->tipo, 'cantidad' => $item_factura->cantidad, 'precio_neto' => $item_factura->precio_neto, 'impuesto' => $item_factura->impuesto, 'importe_neto' => $item_factura->importe_neto]);

                $total = $total + $item_factura['importe_neto'];
                $i = $i + 1;
            }

            // dd($array);

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

            $alumno_id = $factura_proforma->alumno_id;
            $alumno = Alumno::where('id', '=', $alumno_id)->first();
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
            $mercadopago->alumno_id = $request->alumno;
            $mercadopago->status_pago = $request->json['collection_status'];
            $mercadopago->pago_id = $request->json['collection_id'];
            $mercadopago->preference_id = $request->json['preference_id'];
            $mercadopago->tipo_pago = $request->json['payment_type'];

            $mercadopago->save();
            return 'Movimiento Generado en Base de Datos';
        }
        return 'No se genero ningun Registro en Base de Datos';

    }

    
}
