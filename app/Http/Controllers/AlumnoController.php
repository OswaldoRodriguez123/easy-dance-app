<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Alumno;
use App\Instructor;
use App\InscripcionTaller;
use App\InscripcionClaseGrupal;
use App\InscripcionCoreografia;
use App\ClasePersonalizada;
use App\ItemsFacturaProforma;
use App\Academia;
use Mail;
use DB;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;

class AlumnoController extends BaseController
{


    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    
    public function principal()
	{
        $alumnod = DB::table('alumnos')
            ->join('items_factura_proforma', 'items_factura_proforma.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.id as id', 'items_factura_proforma.importe_neto', 'items_factura_proforma.fecha_vencimiento')
            ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
            ->where('alumnos.deleted_at', '=', null)
        ->get();

        $collection=collect($alumnod);

        $grouped = $collection->groupBy('id');     
        
        $deuda = $grouped->toArray();

        $alumno = Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

        $instructor = Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

        // dd($alumno);

        // $proforma = DB::table('items_factura_proforma')
        //     ->groupBy('alumno_id')

        // ->get();

        // $total = ItemsFacturaProforma::groupBy('alumno_id')
        //    ->selectRaw('sum(importe_neto) as sum, *');
        //    // ->lists('sum','alumno_id');
        // dd($total);

        


		return view('participante.alumno.principal')->with(['alumnos' => $alumno, 'instructor' => $instructor,'deuda' => $deuda]);
	}


    public function inactivos()
    {
        $alumnod = DB::table('alumnos')
            ->join('items_factura_proforma', 'items_factura_proforma.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.id as id', 'items_factura_proforma.importe_neto', 'items_factura_proforma.fecha_vencimiento')
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
            ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
            ->where('deleted_at', '!=' ,  NULL)
        ->get();

        $collection=collect($alumnod);

        $grouped = $collection->groupBy('id');     
        
        $deuda = $grouped->toArray();

        // $alumno = DB::table('alumnos')
        //     ->select('alumnos.*')
        //     ->where('academia_id', '=' ,  Auth::user()->academia_id)
        //     ->where('deleted_at', '!=' ,  NULL)
        // ->get();

        $alumno = Alumno::onlyTrashed()
                ->where('academia_id', Auth::user()->academia_id)
                ->whereNotNull('deleted_at')
            ->get();

        // $proforma = DB::table('items_factura_proforma')
        //     ->groupBy('alumno_id')

        // ->get();

        // $total = ItemsFacturaProforma::groupBy('alumno_id')
        //    ->selectRaw('sum(importe_neto) as sum, *');
        //    // ->lists('sum','alumno_id');
        // dd($total);


        return view('participante.alumno.bandeja')->with(['alumnos' => $alumno, 'deuda' => $deuda]);
    }

	public function store(Request $request)
	{
		$request->merge(array('correo' => trim($request->correo)));

    $rules = [
        'identificacion' => 'required|min:7|numeric|unique:alumnos,identificacion',
        'nombre' => 'required|min:3|max:16|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'apellido' => 'required|min:3|max:16|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'fecha_nacimiento' => 'required',
        'sexo' => 'required',
        'correo' => 'required|email|max:255|unique:alumnos,correo, '.$request->id.'',
    ];

    $messages = [

        'identificacion.required' => 'Ups! El identificador es requerido',
        'identificacion.min' => 'El mínimo de numeros permitidos son 5',
        'identificacion.max' => 'El maximo de numeros permitidos son 20',
        'identificacion.numeric' => 'Ups! El identificador es inválido , debe contener sólo números',
        'identificacion.unique' => 'Ups! Ya este usuario ha sido registrado',
        'nombre.required' => 'Ups! El Nombre  es requerido ',
        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre.max' => 'El máximo de caracteres permitidos son 16',
        'nombre.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
        'apellido.required' => 'Ups! El Apellido  es requerido ',
        'apellido.min' => 'El mínimo de caracteres permitidos son 3',
        'apellido.max' => 'El máximo de caracteres permitidos son 16',
        'apellido.regex' => 'Ups! El apellido es inválido , debe ingresar sólo letras',
        'sexo.required' => 'Ups! El Sexo  es requerido ',
        'fecha_nacimiento.required' => 'Ups! La fecha de nacimiento es requerida',
        'correo.required' => 'Ups! El correo  es requerido ',
        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'correo.max' => 'El máximo de caracteres permitidos son 255',
        'correo.unique' => 'Ups! Ya este correo ha sido registrado',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        // return redirect("/home")

        // ->withErrors($validator)
        // ->withInput();

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }

    else{

        $edad = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->diff(Carbon::now())->format('%y');


        if($edad < 1){
            return response()->json(['errores' => ['fecha_nacimiento' => [0, 'Ups! Esta fecha es invalida, debes ingresar una fecha superior a 1 año de edad']], 'status' => 'ERROR'],422);
        }

        $alumno = new Alumno;

        $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->toDateString();

        $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->nombre))));

        $apellido = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->apellido))));

        $direccion = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->direccion))));

        $correo = strtolower($request->correo);

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
        $alumno->alergia = $request->alergia;
        $alumno->asma = $request->asma;
        $alumno->convulsiones = $request->convulsiones;
        $alumno->cefalea = $request->cefalea;
        $alumno->hipertension = $request->hipertension;
        $alumno->lesiones = $request->lesiones;

        if($alumno->save()){
            
            // if($request->correo){

            //     $academia = Academia::find(Auth::user()->academia_id);
            //     $contrasena = str_random(6);
            //     $subj = $alumno->nombre . ' , ' . $academia->nombre . ' te ha agregado a Easy Dance, por favor confirma tu correo electronico';

            //     $array = [
            //        'nombre' => $request->nombre,
            //        'academia' => $academia->nombre,
            //        'usuario' => $request->correo,
            //        'contrasena' => $contrasena,
            //        'subj' => $subj
            //     ];

            //     Mail::send('correo.inscripcion', $array, function($msj) use ($array){
            //             $msj->subject($array['subj']);
            //             $msj->to($array['usuario']);
            //         });
            // }

            //Envio de Sms
            $data = collect([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'celular' => $request->celular
            ]);
            $academia = Academia::find($alumno->academia_id);
            $msg = 'Bienvenido a bordo '.$request->nombre.', '.$academia->nombre.' te brinda la bienvenida a nuestras clases de baile';
            $sms = $this->sendAlumno($data, $msg);


            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'id'=>$alumno->id, 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
        }
        // return redirect("/home");
        //return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
    }

    }

    public function create()
    {
        //Simple Marker
        $config['center'] = '10.6913156,-71.6800493';
        $config['zoom'] = 14;
        \Gmaps::initialize($config);

        $marker = array();
        $marker['position'] = '10.6913156,-71.6800493';
        $marker['draggable'] = true;
        $marker['ondragend'] = 'addFieldText(event.latLng.lat(), event.latLng.lng());';
        \Gmaps::add_marker($marker);

        $map = \Gmaps::create_map();
 
        //Devolver vista con datos del mapa
        return view('participante.alumno.create' , compact('map'));
    }

    public function edit($id)
    {   
        $alumno = Alumno::find($id);

        if($alumno){

            $subtotal = 0;
            $impuesto = 0;
            
            $config['center'] = '10.6913156,-71.6800493';
            $config['zoom'] = 14;
            \Gmaps::initialize($config);

            $marker = array();
            $marker['position'] = '10.6913156,-71.6800493';
            $marker['draggable'] = true;
            $marker['ondragend'] = 'addFieldText(event.latLng.lat(), event.latLng.lng());';
            \Gmaps::add_marker($marker);

            $map = \Gmaps::create_map();

            $item_factura = DB::table('items_factura_proforma')
            ->select('items_factura_proforma.*')
            ->where('items_factura_proforma.alumno_id', '=', $id)
            ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
            ->get();

            foreach($item_factura as $items_factura){

                    $subtotal = $subtotal + $items_factura->importe_neto;
                    
            }

           return view('participante.alumno.planilla', compact('map'))->with(['alumno' => $alumno , 'id' => $id, 'total' => $subtotal]);
        }else{
           return redirect("participante/alumno"); 
        }
    }

    public function operar($id)
    {   
        $alumno = Alumno::find($id);
        return view('participante.alumno.operacion')->with(['id' => $id, 'alumno' => $alumno]);        
    }

    public function deuda($id)
    {   
        $alumno = DB::table('alumnos')
            ->select('alumnos.*')
            ->where('alumnos.id', '=', $id)
        ->first();

        $proforma = DB::table('items_factura_proforma')
            ->join('alumnos', 'items_factura_proforma.alumno_id', '=', 'alumnos.id')
            ->select('items_factura_proforma.*')
            ->where('alumnos.id', '=', $id)
        ->get();

        foreach($proforma as $proformas){
            if($proformas->fecha_vencimiento <= Carbon::today()){
                $proformas->vencido = true;
            }
        }
        
        if($alumno){

           return view('participante.alumno.deuda')->with(['alumno' => $alumno , 'id' => $id, 'proforma' => $proforma]);

        }else{
           return redirect("participante/alumno/detalle/"+$id); 
        }
    }

    public function historial($id)
    {   
        $alumno = Alumno::find($id);

        $factura_join = DB::table('facturas')
            ->join('alumnos', 'facturas.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.nombre as nombre', 'alumnos.apellido as apellido', 'facturas.numero_factura as factura', 'facturas.fecha as fecha', 'facturas.id')
            ->where('alumno_id', '=', $id)
        ->get();

        $alumnod = DB::table('facturas')
            ->join('items_factura', 'items_factura.factura_id', '=', 'facturas.id')
            ->select('items_factura.importe_neto', 'facturas.id')
            ->where('facturas.alumno_id','=',$id)
        ->get();

        if($alumnod){

            $collection=collect($alumnod);
            $grouped = $collection->groupBy('id');     
            $facturado = $grouped->toArray();

            $array=array();
            $i = 0;
            $importe_neto = 0;

            foreach($facturado as $item){
                $importe_neto = 0;
                foreach($item as $tmp){

                $factura_id = $tmp->id;
                $importe_neto = $importe_neto + $tmp->importe_neto;
                // $id_alumno = $item['']
                // $iva = $item['costo'] * ($academia->porcentaje_impuesto / 100);
                }

                // $factura_join[$i]->setAttribute('total',  $importe_neto);
                // $factura_join[$id]->total = $importe_neto;
                $factura_join[$i]->total=$importe_neto;
                $array[$factura_id] = $factura_join[$i];
                $i = $i + 1;
            }

            if($factura_join){

               return view('participante.alumno.historial')->with(['facturas' => $array, 'alumno' => $alumno]);

            }else{
               return redirect("participante/alumno/detalle/"+$id); 
            }
        }
        else{
            return view('participante.alumno.historial')->with(['alumno' => $alumno, 'facturas' => array()]);
        }
    }

    public function sesion($id)
    {   
        $alumno = Alumno::find($id);
        Session::put('alumno', $alumno);

        return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
    }

    public function updateID(Request $request){
        $rules = [
            'identificacion' => 'required|min:7|numeric|unique:alumnos,identificacion, '.$request->id.'',
        ];

        $messages = [
            'identificacion.required' => 'Ups! El identificador es requerido',
            'identificacion.min' => 'El mínimo de numeros permitidos son 5',
            'identificacion.max' => 'El maximo de numeros permitidos son 20',
            'identificacion.numeric' => 'Ups! El identificador es inválido , debe contener sólo números',
            'identificacion.unique' => 'Ups! Ya este usuario ha sido registrado',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
        }else{
            $alumno = Alumno::find($request->id);
            $alumno->identificacion = $request->identificacion;        
            if($alumno->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateNombre(Request $request){

        $rules = [
            'nombre' => 'required|min:3|max:16|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            'apellido' => 'required|min:3|max:16|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        ];

        $messages = [

            'nombre.required' => 'Ups! El Nombre  es requerido ',
            'nombre.min' => 'El mínimo de caracteres permitidos son 3',
            'nombre.max' => 'El máximo de caracteres permitidos son 16',
            'nombre.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
            'apellido.required' => 'Ups! El Apellido  es requerido ',
            'apellido.min' => 'El mínimo de caracteres permitidos son 3',
            'apellido.max' => 'El máximo de caracteres permitidos son 16',
            'apellido.regex' => 'Ups! El apellido es inválido , debe ingresar sólo letras',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }
        $alumno = Alumno::find($request->id);

        $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->nombre))));

        $apellido = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->apellido))));

        $alumno->nombre = $nombre;
        $alumno->apellido = $apellido;

        if($alumno->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateFecha(Request $request){


        $alumno = Alumno::find($request->id);
        $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->toDateString();
        $alumno->fecha_nacimiento = $fecha_nacimiento;

        if($alumno->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }
    public function updateSexo(Request $request){
        $alumno = Alumno::find($request->id);
        $alumno->sexo = $request->sexo;

        // return redirect("alumno/edit/{$request->id}");
        if($alumno->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateCorreo(Request $request){

    $rules = [
        'correo' => 'email|max:255|unique:alumnos,correo, '.$request->id.'',
    ];

    $messages = [

        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'correo.max' => 'El máximo de caracteres permitidos son 255',
        'correo.unique' => 'Ups! Ya este correo ha sido registrado',
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
        $alumno = Alumno::find($request->id);
        $correo = strtolower($request->correo);
        $alumno->correo = $correo;

        if($alumno->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function updateTelefono(Request $request){

        $alumno = Alumno::find($request->id);
        $alumno->telefono = $request->telefono;
        $alumno->celular = $request->celular;

        if($alumno->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateDireccion(Request $request){
        $alumno = Alumno::find($request->id);

        $direccion = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->direccion))));

        $alumno->direccion = $direccion;
        
        if($alumno->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateFicha(Request $request){
        $alumno = Alumno::find($request->id);
        $alumno->asma = $request->asma;
        $alumno->alergia = $request->alergia;
        $alumno->convulsiones = $request->convulsiones;
        $alumno->cefalea = $request->cefalea;
        $alumno->hipertension = $request->hipertension;
        $alumno->lesiones = $request->lesiones;

       if($alumno->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function destroy($id)
    {
        $total = 0;

        
        $mensaje = 'Ups! Este alumno no puede ser eliminado ya que se encuentra registrado en alguna';
        
        $exist = InscripcionClaseGrupal::where('alumno_id', $id)->first();

        if($exist)
        {
            $total = 1;

            $mensaje = $mensaje . ' clase grupal';
        }

        $exist = ClasePersonalizada::where('alumno_id',$id)->first();
        
        if($exist)
        {
            $total = 1;

            $mensaje = $mensaje . ', clase personalizada';
        }

        $exist = InscripcionTaller::where('alumno_id',$id)->first();
        
        if($exist)
        {
            $total = 1;

            $mensaje = $mensaje . ', taller';
        }

        $exist = InscripcionCoreografia::where('alumno_id',$id)->first();
        
        if($exist)
        {
            $total = 1;

            $mensaje = $mensaje . ' o coreografia';
        }

        $mensaje = $mensaje . ', para deshabilitarlo debe eliminarlo de la actividad donde se encuentra registrado';

        if($total == 0){

            $alumno = Alumno::find($id);
            
            if($alumno->delete()){
                return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
        else
        {
            return response()->json(['error_mensaje'=> $mensaje , 'status' => 'ERROR-INSCRIPCION'],422);
        }

        // return redirect("alumno");
    }

    public function restore($id)
    {
            
            $alumno = Alumno::onlyTrashed()
                ->where('id', $id)
                ->first();
            
            if($alumno->restore()){
                return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }

    }
}
