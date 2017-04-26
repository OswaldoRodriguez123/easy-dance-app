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
use App\Factura;
use App\Pago;
use App\ItemsFactura;
use App\ConfigPagosInstructor;
use App\PagoInstructor;
use App\ReservacionVisitante;
use App\CredencialAlumno;
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

class AcademiaController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index()
	{
        $academia = Academia::find(Auth::user()->academia_id);

        // $inscripciones = InscripcionClaseGrupal::all();

        // foreach($inscripciones as $inscripcion){
        //     $clase_grupal = ClaseGrupal::withTrashed()->find($inscripcion->clase_grupal_id);
            
        //     $inscripcion->clase_grupal_id = $clase_grupal->clase_grupal_id;
        //     $inscripcion->save();
            
        // }

        // foreach($clases_personalizadas as $clase_personalizada){

        //     $servicio = new ConfigServicios;
            
        //     $servicio->academia_id = $clase_personalizada->academia_id;
        //     $servicio->nombre = $clase_personalizada->nombre;
        //     $servicio->costo = $clase_personalizada->costo;
        //     $servicio->imagen = '';
        //     $servicio->descripcion = $clase_personalizada->descripcion;
        //     $servicio->incluye_iva = 0;
        //     $servicio->tipo = 9;

        //     $servicio->save();
        // }

        $servicios = ConfigServicios::all();

        foreach($servicios as $servicio){

            if(!$servicio->tipo_id){
                $servicio->tipo_id = $servicio->id;
                $servicio->save();
            }
        }

        $productos = ConfigProductos::all();

        foreach($productos as $producto){
            if(!$producto->tipo_id){
                $producto->tipo_id = $producto->id;
                $producto->save();
            }
        }


        // $patrocinadores = Patrocinador::all();

        // foreach($patrocinadores as $patrocinador){

        // 	$cantidad = intval($patrocinador->monto) / 10000;
        // 	$patrocinador->cantidad = $cantidad;
        // 	$patrocinador->save();
        // }

        // $facturas = ItemsFactura::all();

        // foreach($facturas as $factura){

        //     if($factura->tipo == 4){

        //         $explode = explode(' ', $factura->nombre);

        //         if($explode[0] != 'Remanente' && $explode[0] != 'Abono'){

        //             $factura->nombre = 'Cuota ' . $factura->nombre;
        //             $factura->save();

        //         }
                
        //     }
        // }

        // $facturas = ItemsFacturaProforma::all();

        // foreach($facturas as $factura){

        //     if($factura->tipo == 3){

        //         $explode = explode(' ', $factura->nombre);

        //         if($explode[0] == 'Inscripción'){

        //             if($explode[1] == 'Remanente' OR $explode[1] == 'Abono'){

        //                 $nombre = '';

        //                 foreach($explode as $tmp){

        //                     if($tmp != 'Inscripción'){
        //                         $nombre = $nombre . ' ' . $tmp;
        //                     }
        //                 }

        //                 $factura->nombre = $nombre;
        //                 $factura->save();
        //             }
        //         }
        
        //     }
        // }

        // $facturas = ItemsFacturaProforma::all();

        // foreach($facturas as $factura){

        //     if($factura->tipo == 3){

        //         $explode = explode(' ', $factura->nombre);

        //         if($explode[0] == 'Inscripción'){

        //             if($explode[1] == 'Remanente' OR $explode[1] == 'Abono'){

        //                 $nombre = '';

        //                 foreach($explode as $tmp){

        //                     if($tmp != 'Inscripción'){
        //                         $nombre = $nombre . ' ' . $tmp;
        //                     }
        //                 }

        //                 $factura->nombre = $nombre;
        //                 $factura->save();
        //             }
        //         }
        
        //     }
        // }

        // $facturas = ConfigProductos::all();

        // foreach($facturas as $factura){
        //     $nombre = explode(" ", $factura->nombre);

        //     if($nombre[0] == "Boleta" OR $factura->nombre == "Inscripción Del Evento"){
        //         $factura->tipo = 14;
        //         $factura->save();
        //     }
        // }

        // $egresos = Egreso::all();

        // foreach($egresos as $egreso){
        //     $egreso->fecha = $egreso->created_at;
        //     $egreso->save();
        // }
        
        // $facturas = ItemsFacturaProforma::where('tipo',6)->get();

        // foreach($facturas as $factura){
            
        //     $item_acuerdo = new ItemsAcuerdo;
                        
        //     $item_acuerdo->acuerdo_id = $factura->item_id;
        //     $item_acuerdo->fecha = $factura->fecha;
        //     $item_acuerdo->item_id = $factura->id;
        //     $item_acuerdo->nombre = $factura->nombre;
        //     $item_acuerdo->tipo = $factura->tipo;
        //     $item_acuerdo->cantidad = $factura->cantidad;
        //     $item_acuerdo->precio_neto = $factura->precio_neto;
        //     $item_acuerdo->impuesto = $factura->impuesto;
        //     $item_acuerdo->importe_neto = $factura->importe_neto;
        //     $item_acuerdo->fecha_vencimiento = $factura->fecha_vencimiento;

        //     $item_acuerdo->save();

        // }

        //ADMINISTRADOR
        if(Auth::user()->usuario_tipo == 1 || Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6){

            $fecha_comprobacion = Carbon::createFromFormat('Y-m-d', $academia->fecha_comprobacion);
            $hoy = Carbon::now();

            if($fecha_comprobacion < $hoy){

                $reservaciones = ReservacionVisitante::all();

                foreach($reservaciones as $reservacion){
                    $fecha_vencimiento = Carbon::parse($reservacion->fecha_vencimiento);
                    if(Carbon::now() > $fecha_vencimiento){
                        $reservacion->deleted_at = Carbon::now();
                        $reservacion->save();
                    }

                }

                if($hoy == $hoy->lastOfMonth()){

                    $config_pagos = ConfigPagosInstructor::where('tipo', 2)->get();

                    foreach($config_pagos as $config_pago){
                        $pago = new PagoInstructor;

                        $pago->instructor_id=$config_pago->instructor_id;
                        $pago->tipo=$config_pago->tipo;
                        $pago->monto=$config_pago->monto;
                        $pago->clase_grupal_id=$config_pago->clase_grupal_id;

                        $pago->save();
                    }

                }

                return $this->pagorecurrente();
            }

            return view('inicio.index')->with(['paises' => Paises::all() , 'especialidades' => ConfigEspecialidades::all(), 'academia' => $academia]); 
        }

        if(Auth::user()->usuario_tipo == 2 || Auth::user()->usuario_tipo == 4){

            $alumno = Alumno::find(Auth::user()->usuario_id);

            if(!$alumno){
                return view('inicio.cuenta-deshabilitada');
            }else{
                if(Session::has('fecha_comprobacion')){
                    $fecha_comprobacion = Session::get('fecha_comprobacion');
                    $hoy = Carbon::now()->toDateString();

                    if($fecha_comprobacion < $hoy){
                        return $this->inactividad();
                    }

                }else{
                    return $this->inactividad();
                }
            }


            //ALUMNOS
            if(Auth::user()->boolean_condiciones){

                $contador_clase = 0;
                $contador_taller = 0;
                $contador_fiesta = 0;
                $contador_campana = 0;

                $array=array();

                $clase_grupal_join = DB::table('clases_grupales')
                    ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                    ->select('config_clases_grupales.nombre','clases_grupales.id', 'config_clases_grupales.descripcion', 'clases_grupales.imagen', 'clases_grupales.created_at', 'clases_grupales.fecha_inicio', 'clases_grupales.dias_prorroga')
                    ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
                    ->where('clases_grupales.boolean_promocionar','=', 1)
                    ->where('clases_grupales.deleted_at', '=', null)
                ->get();

                $alumno_examenes = DB::table('evaluaciones')
                    ->join('alumnos','evaluaciones.alumno_id','=','alumnos.id')
                    ->join('examenes','evaluaciones.examen_id','=','examenes.id')
                    ->select('examenes.nombre','evaluaciones.id')
                    ->where('evaluaciones.alumno_id','=',Auth::user()->usuario_id)
                ->get();


                foreach($clase_grupal_join as $clase){

                    $fecha = Carbon::createFromFormat('Y-m-d', $clase->fecha_inicio);
                    $fecha->addDays($clase->dias_prorroga);
                    if($fecha >= Carbon::now()){
                        $contador_clase = $contador_clase + 1;
                        $disponible = '';
                    }else{
                        $disponible = ' ( No disponible )';
                    }

                    
                    if($clase->imagen){
                        $imagen = "/assets/uploads/clase_grupal/{$clase->imagen}";
                    }else{
                        $imagen = '';
                    }

                    $fecha_inicio = Carbon::createFromFormat('Y-m-d', $clase->fecha_inicio)->format('d-m-Y');


                    $array[]=array('nombre' => $clase->nombre , 'descripcion' => $clase->descripcion ,'imagen' => $imagen , 'url' => "/agendar/clases-grupales/progreso/{$clase->id}", 'facebook' => "/agendar/clases-grupales/progreso/{$clase->id}", 'twitter' => "Participa en la clase grupal {$clase->nombre} te invita @EasyDanceLatino", 'twitter_url' => "/agendar/clases-grupales/progreso/{$clase->id}", 'creacion' => $clase->created_at, 'tipo' => 1, 'fecha_inicio' => $fecha_inicio, 'disponible' => $disponible);

                }

                $talleres = Taller::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

                foreach($talleres as $taller){

                    $fecha = Carbon::createFromFormat('Y-m-d', $taller->fecha_inicio);

                   if($fecha >= Carbon::now() && $taller->boolean_promocionar == 1){

                        if($taller->imagen){
                            $imagen = "/assets/uploads/taller/{$taller->imagen}";
                        }else{
                            $imagen = '';
                        }

                        $array[]=array('nombre' => $taller->nombre , 'descripcion' => $taller->descripcion ,'imagen' => $imagen , 'url' => "/agendar/talleres/progreso/{$taller->id}", 'facebook' => "/agendar/talleres/progreso/{$taller->id}", 'twitter' => "Participa en el taller {$taller->nombre} te invita @EasyDanceLatino", 'twitter_url' => "/agendar/talleres/progreso/{$taller->id}" , 'creacion' => $taller->created_at, 'tipo' => 2, 'fecha_inicio' => $taller->fecha_inicio, 'disponible' => '');

                        $contador_taller = $contador_taller + 1;
                    }

                }

                $fiestas = Fiesta::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

                foreach($fiestas as $fiesta){

                    $fecha = Carbon::createFromFormat('Y-m-d', $fiesta->fecha_inicio);

                    if($fecha >= Carbon::now() && $fiesta->boolean_promocionar == 1){

                        if($fiesta->imagen){
                            $imagen = "/assets/uploads/fiesta/{$fiesta->imagen}";
                        }else{
                            $imagen = '';
                        }

                        $array[]=array('nombre' => $fiesta->nombre , 'descripcion' => $fiesta->descripcion ,'imagen' => $imagen , 'url' => "/agendar/fiestas/progreso/{$fiesta->id}", 'facebook' => "/agendar/fiesta/progreso/{$fiesta->id}", 'twitter' => "Participa en la fiesta {$fiesta->nombre} te invita @EasyDanceLatino", 'twitter_url' => "/agendar/fiestas/progreso/{$fiesta->id}", 'creacion' => $fiesta->created_at, 'tipo' => 3, 'fiesta' => $fiesta->fecha_inicio, 'disponible' => '');

                        $contador_fiesta = $contador_fiesta + 1;
                    }

                }

                $campanas = Campana::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

                foreach($campanas as $campana){

                    $fecha = Carbon::createFromFormat('Y-m-d', $campana->fecha_final);

                    if($fecha >= Carbon::now()){

                        $contador_campana = $contador_campana + 1;
                    }

                }

                $collection = collect($array);

                $sorted = $collection->sortByDesc('creacion');

                $i = 0;

                $arreglo=array();

                foreach($sorted as $tmp){

                    $tmp['contador'] = $i;
                    $arreglo[$i] = $tmp;
                    $i = $i + 1;

                }

                $instructor_contador = Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->where('instructores.boolean_promocionar', 1)->count();
                $clase_personalizada_contador = ClasePersonalizada::where('academia_id', '=' ,  Auth::user()->academia_id)->count();

                $perfil = PerfilEvaluativo::where('usuario_id', Auth::user()->usuario_id)->first();

                if($perfil){
                    $tiene_perfil = 1;
                }else{
                    $tiene_perfil = 0;
                }

                $array_deuda = array();

                if (!Session::has('fecha_sesion')) {                
                   $fecha_sesion=Carbon::now();
                   Session::put('fecha_sesion',$fecha_sesion);
                }

                $credenciales_alumno = CredencialAlumno::join('instructores','credenciales_alumno.instructor_id','=','instructores.id')
                    ->select('credenciales_alumno.*', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id', 'instructores.sexo')
                    ->where('credenciales_alumno.alumno_id',Auth::user()->usuario_id)
                ->get();

                $array_credencial = array();
                $total_credenciales = 0;

                foreach($credenciales_alumno as $credencial_alumno){

                    $instructor = User::where('usuario_tipo',3)->where('usuario_id',$credencial_alumno->instructor_id)->first();

                    if($instructor){

                      if($instructor->imagen){
                        $imagen = $instructor->imagen;
                      }else{
                        $imagen = '';
                      }

                    }

                    $collection=collect($credencial_alumno);     
                    $credencial_array = $collection->toArray();
                        
                    $credencial_array['imagen']=$imagen;
                    $array_credencial[$credencial_alumno->id] = $credencial_array;

                    $total_credenciales = $total_credenciales + $credencial_alumno->cantidad;
                }
                
                return view('vista_alumno.index')->with(['academia' => $academia, 'enlaces' => $arreglo , 'clases_grupales' => $contador_clase, 'talleres' => $contador_taller , 'fiestas' =>  $contador_fiesta ,'contador_campana' => $contador_campana ,'regalos' => Regalo::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'perfil' => $tiene_perfil, 'instructor_contador' => $instructor_contador, 'clase_personalizada_contador' => $clase_personalizada_contador, 'alumno_examenes' => $alumno_examenes, 'alumno' => $alumno, 'credenciales_alumno' => $array_credencial, 'total_credenciales' => $total_credenciales, 'campanas' => $campanas]);  
                
            }else{
                return view('vista_alumno.condiciones')->with('academia', $academia);
            }
        }


        if(Auth::user()->usuario_tipo == 3){


            $instructor = Instructor::find(Auth::user()->usuario_id);

            if(!$instructor){
                return view('inicio.cuenta-deshabilitada');
            }

            return view('vista_instructor.index')->with(['academia' => $academia, 'instructor' => $instructor]);  
        }
                           
	}

    public function menu(){

        if(Auth::user()->usuario_tipo == 1 || Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6){

        return view('menu.index');
        }else{
            return redirect("/inicio"); 
        }
        
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

    public function listo()
    {       
        return view('flujo_registro.listo');                    
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

    public function error(){
        
        return view('errors.error_sistema');
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



    /**
      * PAGOS RECURRENTES o MENSUALIDADES
      * Var $tipo => Tipo de Accion,
      *     $result => Arreglo donde se guarda
                       la respuesta a mostrar, podria
                       no usuarse mas adelante.
      *     $cantidad => Valor Cantidad de la Base de Datos,
                         en este caso sera una constante.
      *     $ConfigClasesGrupales => consulta al modelo de Configuracion
                                    de clases grupales para obtener los
                                    datos de la clase
            $InscripcionClaseGrupal => Consulta al modelo de Inscripcion de
                                    de clase grupales para verificar si hay
                                    alumnos inscritos, para luego cargarles
                                    una deuda en caso de tenerla
            $FacturaProforma => Consulta al modelo de detalles de
                                Proforma para verificar si hay deuda para
                                no cargarle una misma deuda mas de una vez           
      */
    public function pagorecurrente()
    {
        $result = array();
        $tipo = 4;
        $cantidad = 1;
        $id = 0;
        $academia = Academia::find(Auth::user()->academia_id);
        $academia->fecha_comprobacion = Carbon::now()->toDateString();
        $academia->save();

        $ConfigClasesGrupales = ConfigClasesGrupales::select('config_clases_grupales.id',
                'config_clases_grupales.nombre','config_clases_grupales.costo_inscripcion',
                'config_clases_grupales.costo_mensualidad', 'clases_grupales.id',
                'clases_grupales.fecha_inicio', 'clases_grupales.fecha_final',
                'clases_grupales.fecha_inicio_preferencial', 'clases_grupales.id as clase_grupal_id')
                ->join('clases_grupales', 'clases_grupales.clase_grupal_id','=','config_clases_grupales.id')
                ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
                ->where('clases_grupales.deleted_at', '=', null)
                ->where('clases_grupales.fecha_final', '>', Carbon::now()->format("Y-m-d"))
                ->get();

        $InscripcionClaseGrupal = InscripcionClaseGrupal::select('inscripcion_clase_grupal.clase_grupal_id AS ClaseGrupalID', 
            'inscripcion_clase_grupal.alumno_id AS AlumnoId',
            'inscripcion_clase_grupal.fecha_pago', 
            'alumnos.identificacion AS Identificacion', 'alumnos.nombre AS NombreAlumno', 
            'alumnos.apellido AS ApellidoAlumno', 'alumnos.telefono AS TelefonoAlumno', 
            'alumnos.celular as CelularAlumno','config_clases_grupales.nombre AS ClaseNombre', 'inscripcion_clase_grupal.id as InscripcionID', 'inscripcion_clase_grupal.costo_mensualidad AS Costo')
                ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id','=',
                       'clases_grupales.id')
                ->join('alumnos', 'inscripcion_clase_grupal.alumno_id','=','alumnos.id')
                ->join('config_clases_grupales', 'config_clases_grupales.id','=',
                       'clases_grupales.clase_grupal_id')
                ->where('inscripcion_clase_grupal.deleted_at', '=', null)
                ->get();
        
            //Desgloso la Fecha Preferencial
            foreach ($InscripcionClaseGrupal as $InscripcionClase ) {

                $fecha_cuota_explode=explode('-', $InscripcionClase->fecha_pago);

                foreach ($ConfigClasesGrupales as $configClases) {

                    $fecha_inicio_preferencial = Carbon::createFromFormat('Y-m-d', $configClases->fecha_inicio_preferencial);

                    if ($fecha_inicio_preferencial <= Carbon::now()){

                        $fecha_inicio_preferencial = $fecha_inicio_preferencial->addMonth()->toDateString();

                        $clase_grupal = ClaseGrupal::find($configClases->clase_grupal_id);
                        $clase_grupal->fecha_inicio_preferencial = $fecha_inicio_preferencial;
                        $clase_grupal->save();

                    }

                    $fecha_pago = Carbon::createFromFormat('Y-m-d', $InscripcionClase->fecha_pago);

                    if ($fecha_pago <= Carbon::now()){

                        if($configClases->id == $InscripcionClase->ClaseGrupalID){

                            $FacturaProforma = ItemsFacturaProforma::select(
                            'items_factura_proforma.tipo', 
                            'items_factura_proforma.alumno_id')
                            ->where('items_factura_proforma.tipo','=',$tipo)
                            ->where('items_factura_proforma.alumno_id', '=', $InscripcionClase->AlumnoId)
                            ->where('items_factura_proforma.item_id', '=', $configClases->clase_grupal_id)
                            ->get()->count();

                            /** AQUI CONVERTIMOS LA FECHA PREFERENCIAL PARA PODER
                                OBTENER LA FECHA LIMITE DE PAGO **/
                            $fecha_cuota = Carbon::create($fecha_cuota_explode[0], $fecha_cuota_explode[1], $fecha_cuota_explode[2],0);

                            /** AQUI CALCULAMOS LA FECHA FECHA LIMITE DE PAGO **/
                            $tolerancia = $fecha_cuota->addDay($configClases->tiempo_tolerancia)->toDateString();
                            
                            if($FacturaProforma == 0 && $InscripcionClase->Costo > 0){

                                $fecha_final = Carbon::createFromFormat('Y-m-d', $configClases->fecha_final);

                                if($fecha_final > Carbon::now()){
                                    
                                    $fecha_cuota = $fecha_cuota->addMonth()->toDateString();
                                    
                                    $clasegrupal = InscripcionClaseGrupal::find($InscripcionClase->InscripcionID);

                                    $clasegrupal->fecha_pago = $fecha_cuota;
                                    $clasegrupal->save();

                                    $item_factura = new ItemsFacturaProforma;
                                    
                                    $item_factura->alumno_id = $InscripcionClase->AlumnoId;
                                    $item_factura->academia_id = Auth::user()->academia_id;
                                    $item_factura->fecha = Carbon::now()->toDateString();
                                    $item_factura->item_id = $configClases->id;
                                    $item_factura->nombre = 'Cuota ' . $configClases->nombre;
                                    $item_factura->tipo = $tipo;
                                    $item_factura->cantidad = $cantidad;
                                    $item_factura->importe_neto = $InscripcionClase->Costo;
                                    $item_factura->fecha_vencimiento = Carbon::now()->toDateString();

                                    $item_factura->save();

                                }

                            }
                                            
                        }
                                     
		            }    
		        }
		    }

        return $this->tiempotolerancia();
        
    }

    public function tiempotolerancia(){

        $academia = Academia::find(Auth::user()->academia_id);
        $contador_clase = 0;
        $contador_taller = 0;
        $contador_fiesta = 0;
        $contador_campana = 0;

        $tipo = 8;

        $ConfigClasesGrupales = ConfigClasesGrupales::select('config_clases_grupales.id',
                'config_clases_grupales.nombre','config_clases_grupales.costo_inscripcion',
                'config_clases_grupales.costo_mensualidad', 'clases_grupales.id',
                'clases_grupales.fecha_inicio', 'clases_grupales.fecha_final',
                'clases_grupales.fecha_inicio_preferencial', 'config_clases_grupales.tiempo_tolerancia', 'config_clases_grupales.porcentaje_retraso')
                        ->join('clases_grupales', 'clases_grupales.clase_grupal_id','=','config_clases_grupales.id')
                        ->get();

        $InscripcionClaseGrupal = InscripcionClaseGrupal::select('inscripcion_clase_grupal.clase_grupal_id AS ClaseGrupalID', 
            'inscripcion_clase_grupal.alumno_id AS AlumnoId',
            'inscripcion_clase_grupal.fecha_pago', 
            'alumnos.identificacion AS Identificacion', 'alumnos.nombre AS NombreAlumno', 
            'alumnos.apellido AS ApellidoAlumno', 'alumnos.telefono AS TelefonoAlumno', 
            'alumnos.celular as CelularAlumno','config_clases_grupales.nombre AS ClaseNombre', 'inscripcion_clase_grupal.id as InscripcionID', 'inscripcion_clase_grupal.costo_mensualidad AS Costo')
                ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id','=',
                       'clases_grupales.id')
                ->join('alumnos', 'inscripcion_clase_grupal.alumno_id','=','alumnos.id')
                ->join('config_clases_grupales', 'config_clases_grupales.id','=',
                       'clases_grupales.clase_grupal_id')
                ->get();
        
        
            //Desgloso la Fecha Preferencial
        foreach ($InscripcionClaseGrupal as $InscripcionClase ) {

        	foreach ($ConfigClasesGrupales as $configClases) {

                if($configClases->id == $InscripcionClase->ClaseGrupalID){

                    $FacturaProforma = ItemsFacturaProforma::select(
                    'items_factura_proforma.tipo', 
                    'items_factura_proforma.alumno_id')
                    ->where('items_factura_proforma.tipo','=',$tipo)
                    ->where('items_factura_proforma.alumno_id', '=', $InscripcionClase->AlumnoId)
                    ->get()->count();

                    /** AQUI CONVERTIMOS LA FECHA PREFERENCIAL PARA PODER
                        OBTENER LA FECHA LIMITE DE PAGO **/

                    $fecha_cuota_explode=explode('-', $InscripcionClase->fecha_pago);
                    $fecha_cuota = Carbon::create($fecha_cuota_explode[0], $fecha_cuota_explode[1], $fecha_cuota_explode[2],0);

                    /** AQUI CALCULAMOS LA FECHA FECHA LIMITE DE PAGO **/
                    $tolerancia = $fecha_cuota->addDay($configClases->tiempo_tolerancia)->toDateString();
                    
                        //CONDICION PARA EL TIEMPO DE TOLERANCIA, SI SE CUMPLE
                        //CALCULARA SEGUN EL PORCENTAJE CONFIGURADO Y SE LE SUMARA
                        //AL MONTO DE LA CUOTA
                    $clasegrupal = InscripcionClaseGrupal::find($InscripcionClase->InscripcionID);

                        
                   	if($FacturaProforma != 0 && Carbon::now()->format('Y-m-d') > $tolerancia && $clasegrupal->tiene_mora == 0 && $configClases->porcentaje_retraso){

                        $mora = ($configClases->costo_mensualidad * $configClases->porcentaje_retraso)/100;

                        if($mora > 0)
                        {
                            $item_factura = new ItemsFacturaProforma;
                                                        
                            $item_factura->alumno_id = $InscripcionClase->AlumnoId;
                            $item_factura->academia_id = Auth::user()->academia_id;
                            $item_factura->fecha = Carbon::now()->toDateString();
                                                            //$item_factura->item_id = $id;
                            $item_factura->nombre = 'Mora por retraso de pago Cuota ' .  $configClases->nombre;
                            $item_factura->tipo = 8;
                            $item_factura->cantidad = 1;
                            $item_factura->importe_neto = $mora;
                            $item_factura->fecha_vencimiento = Carbon::now()->toDateString();

                            $item_factura->save();

                            $clasegrupal->tiene_mora = 1;
                            $clasegrupal->save();
                        }

                    }
                }
            }
        }

        $acuerdos = Acuerdo::where('academia_id', Auth::user()->academia_id)->get();

        foreach($acuerdos as $acuerdo){

            $proformas = ItemsFacturaProforma::where('tipo',6)->where('item_id', $acuerdo->id)->get();

            foreach($proformas as $proforma){
                $fecha = Carbon::createFromFormat('Y-m-d', $proforma->fecha_vencimiento);

                $fecha->addDays($acuerdo->tiempo_tolerancia);

                if(Carbon::now() > $fecha && $proforma->tiene_mora == 0 && $acuerdo->porcentaje_retraso){

                    $mora = ($proforma->importe_neto * $acuerdo->porcentaje_retraso)/100;

                    $item_factura = new ItemsFacturaProforma;
                                                
                    $item_factura->alumno_id = $acuerdo->alumno_id;
                    $item_factura->academia_id = Auth::user()->academia_id;
                    $item_factura->fecha = Carbon::now()->toDateString();
                    $item_factura->nombre = 'Mora por retraso de pago ' .  $proforma->nombre;
                    $item_factura->tipo = 8;
                    $item_factura->cantidad = 1;

                    $item_factura->importe_neto = $mora;
                    $item_factura->fecha_vencimiento = Carbon::now()->toDateString();

                    $item_factura->save();

                    $proforma->tiene_mora = 1;

                    $proforma->save();

                }

            }
            
        }

        return $this->index();

    }

    public function inactividad(){

        $id = Auth::user()->usuario_id;

        $asistencia_roja = 6;
        $inscripciones = InscripcionClaseGrupal::where('alumno_id',$id)->get();
        $in = array(1,2);
        $status = true;

        foreach($inscripciones as $inscripcion_clase_grupal){

            $inasistencias = 0;

            $clase_grupal = ClaseGrupal::find($inscripcion_clase_grupal->clase_grupal_id);

            if($clase_grupal)
            {

                $horario = HorarioClaseGrupal::where('clase_grupal_id',$clase_grupal->clase_grupal_id)->first();
                $fecha_clase = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);

                if($horario){

                    $fecha_horario = Carbon::createFromFormat('Y-m-d', $horario->fecha);
                    $dia_clase = $fecha_clase->dayOfWeek;
                    $dia_horario = $fecha_horario->dayOfWeek;

                    $dias = abs($dia_clase - $dia_horario);

                }else{
                    $dias = 7;
                }

                $ultima_asistencia_clase = Asistencia::where('tipo',1)->where('alumno_id',$id)->orderBy('created_at', 'desc')->first();

                $ultima_asistencia_horario = Asistencia::where('tipo',2)->where('alumno_id',$id)->orderBy('created_at', 'desc')->first();

                if($ultima_asistencia_horario OR $ultima_asistencia_clase){

                    if($ultima_asistencia_horario){
                        if($ultima_asistencia_clase){
                            $fecha_horario = Carbon::createFromFormat('Y-m-d', $ultima_asistencia_horario->fecha);
                            $fecha_clase = Carbon::createFromFormat('Y-m-d', $ultima_asistencia_clase->fecha);

                            if($fecha_clase > $fecha_horario){
                                $fecha = Carbon::createFromFormat('Y-m-d', $ultima_asistencia_clase->fecha);
                            }else{
                                $fecha = Carbon::createFromFormat('Y-m-d', $ultima_asistencia_horario->fecha);
                            }

                        }else{
                            $fecha = Carbon::createFromFormat('Y-m-d', $ultima_asistencia_horario->fecha);
                        }

                    }else{
                        $fecha = Carbon::createFromFormat('Y-m-d', $ultima_asistencia_clase->fecha);
                    }
                }else{
                    $fecha = $fecha_clase;
                }

                while($fecha <= Carbon::now())
                {
                    $fecha_a_comparar = $fecha->toDateString();

                    $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', $fecha_a_comparar)
                        ->where('fecha_final', '>=', $fecha_a_comparar)
                        ->where('tipo_id', $clase_grupal->id)
                        ->whereIn('tipo', $in)
                    ->first();

                    if(!$horario_bloqueado){
                        $fecha->addDays($dias);
                        $inasistencias++;
                    }
                    
                }
                
                if($inasistencias <= $asistencia_roja){
                    $status = true;
                    break;
                }else{
                    $status = false;
                }
                
            }

        }

        if($status){
            Session::put('fecha_comprobacion',Carbon::now()->toDateString());
            return $this->index();
        }else{
            return view('inicio.cuenta-deshabilitada');
        }

    }


}
