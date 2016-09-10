<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Examen;
use App\Alumno;
use App\Instructor;
use App\ItemsExamenes;
use Validator;
use Session;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class ExamenController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

    
	public function index()
	{

		return view('academia.editar')->with('academia', Academia::all());                      
	}

    public function principal()
    {
        $examen_join = DB::table('examenes')
            ->join('instructores', 'examenes.instructor_id', '=', 'instructores.id')
            ->select('examenes.id as id' , 'examenes.nombre as nombre', 'examenes.fecha as fecha', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id','examenes.academia_id')
            ->where('examenes.academia_id', '=' ,  Auth::user()->academia_id)
        ->get();

        return view('especiales.examen.principal')->with(['examen' => $examen_join]);
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        if (Session::has('nuevo_item')) {
            Session::forget('nuevo_item'); 
        }
		return view('especiales.examen.create')->with('instructor', Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get());
	}

    public function store(Request $request)
    {

        $rules = [
            'nombre' => 'required|min:3|max:80',
            'instructor_id' => 'required',
            'fecha' => 'required',
            'color_etiqueta' => 'required',
            'descripcion' => 'min:3|max:500',

        ];

        $messages = [

            'nombre.required' => 'Ups! El Nombre es requerido ',
            'nombre.min' => 'El mínimo de caracteres permitidos son 3',
            'nombre.max' => 'El máximo de caracteres permitidos son 80',
            'descripcion.min' => 'El mínimo de caracteres permitidos son 3',
            'descripcion.max' => 'El máximo de caracteres permitidos son 500',
            'fecha.required' => 'Ups! La fecha es requerida',
            'color_etiqueta.required' => 'Ups! La etiqueta es  requerida',
            'instructor_id.required' => 'Ups! El instructor es  requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);

            if($fecha < Carbon::now()){

                return response()->json(['errores' => ['fecha' => [0, 'Ups! ha ocurrido un error. La fecha no puede ser menor al dia de hoy']], 'status' => 'ERROR'],422);
            }

            $items = json_decode($request->items);
            $fecha = $fecha->toDateString();
            
            $examen = new Examen;

            $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->nombre))));

            $examen->academia_id = Auth::user()->academia_id;
            $examen->nombre = $nombre;
            $examen->descripcion = $request->descripcion;
            $examen->fecha = $fecha;
            $examen->color_etiqueta = $request->color_etiqueta;
            $examen->instructor_id = $request->instructor_id;
            $examen->condiciones = $request->condiciones;
            $examen->tiempos_musicales = $request->tiempos_musicales;
            $examen->compromiso = $request->compromiso;
            $examen->condicion = $request->condicion;
            $examen->habilidades = $request->habilidades;
            $examen->disciplina = $request->disciplina;
            $examen->expresion_corporal = $request->expresion_corporal;
            $examen->expresion_facial = $request->expresion_facial;
            $examen->destreza = $request->destreza;
            $examen->dedicacion = $request->dedicacion;
            $examen->oido_musical = $request->oido_musical;
            $examen->postura = $request->postura;
            $examen->respeto = $request->respeto;
            $examen->elasticidad = $request->elasticidad;
            $examen->complejidad_de_movimientos = $request->complejidad_de_movimientos;
            $examen->asistencia = $request->asistencia;
            $examen->estilo = $request->estilo;

            if($examen->save()){
                
                $item = Session::get('nuevo_item');

                foreach ($item as $itemsEx) {
                    $ItemsExamenes = new ItemsExamenes;
                    $ItemsExamenes->academia_id = Auth::user()->academia_id;
                    $ItemsExamenes->examen_id = $examen->id;
                    $ItemsExamenes->nombre = $itemsEx;
                    $ItemsExamenes->save();
                }

                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */

    public function updateNombre(Request $request){

        $examen = Examen::find($request->id);

        $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->nombre))));

        $examen->nombre = $nombre;

        $rules = [
            'nombre' => 'required|min:3|max:50',
        ];

        $messages = [

            'nombre.required' => 'Ups! El Nombre es requerido',
            'nombre.min' => 'El mínimo de caracteres permitidos son 3',
            'nombre.max' => 'El máximo de caracteres permitidos son 50',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            if($examen->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
            // return redirect("alumno/edit/{$request->id}");
        }
    }

    public function updateDescripcion(Request $request){

        $examen = Examen::find($request->id);
        $examen->descripcion = $request->descripcion;

        $rules = [
            'descripcion' => 'required|min:3|max:500',
        ];

        $messages = [

            'descripcion.required' => 'Ups! La Descripcion es requerida',
            'descripcion.min' => 'El mínimo de caracteres permitidos son 3',
            'descripcion.max' => 'El máximo de caracteres permitidos son 500',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            if($examen->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
            // return redirect("alumno/edit/{$request->id}");
        }
    }

    public function updateFecha(Request $request){

        $examen = Examen::find($request->id);

        $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha)->toDateString();

        $examen->fecha = $fecha;

        if($examen->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno/edit/{$request->id}");
    }

    public function updateInstructor(Request $request){
        $examen = Examen::find($request->id);
        $examen->instructor_id = $request->instructor_id;

        // return redirect("alumno/edit/{$request->id}");
        if($examen->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateItem(Request $request){
        $examen = Examen::find($request->id);
            $examen->tiempos_musicales = $request->tiempos_musicales;
            $examen->compromiso = $request->compromiso;
            $examen->condicion = $request->condicion;
            $examen->habilidades = $request->habilidades;
            $examen->disciplina = $request->disciplina;
            $examen->expresion_corporal = $request->expresion_corporal;
            $examen->expresion_facial = $request->expresion_facial;
            $examen->destreza = $request->destreza;
            $examen->dedicacion = $request->dedicacion;
            $examen->oido_musical = $request->oido_musical;
            $examen->postura = $request->postura;
            $examen->respeto = $request->respeto;
            $examen->elasticidad = $request->elasticidad;
            $examen->complejidad_de_movimientos = $request->complejidad_de_movimientos;
            $examen->asistencia = $request->asistencia;
            $examen->estilo = $request->estilo;

        // return redirect("alumno/edit/{$request->id}");
        if($examen->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function edit($id)
    {
        // $visitante_presencial_join = DB::table('visitantes_presenciales')
        //     ->join('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
        //     ->select('config_especialidades.nombre as especialidad_nombre')
        //     ->get();

        $examen_join = DB::table('examenes')
            ->join('instructores', 'examenes.instructor_id', '=', 'instructores.id')
            ->select('instructores.nombre as instructor_nombre','instructores.apellido as instructor_apellido', 'examenes.id as id', 'examenes.nombre as nombre', 'examenes.fecha as fecha', 'examenes.descripcion as descripcion', 'examenes.color_etiqueta as etiqueta','examenes.tiempos_musicales as tiempos_musicales','examenes.compromiso as compromiso','examenes.condicion as condicion','examenes.habilidades as habilidades','examenes.disciplina as disciplina','examenes.expresion_corporal as expresion_corporal','examenes.expresion_facial as expresion_facial','examenes.destreza as destreza','examenes.dedicacion as dedicacion','examenes.oido_musical as oido_musical','examenes.postura as postura','examenes.respeto as respeto','examenes.elasticidad as elasticidad','examenes.complejidad_de_movimientos as complejidad_de_movimientos','examenes.asistencia as asistencia', 'examenes.estilo as estilo')
            ->where('examenes.id', '=', $id)
        ->first();

        $item_examen = DB::table('items_examenes')
            ->where('examen_id','=',$id)->get();

        if($examen_join){
           return view('especiales.examen.planilla')->with(['instructor' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'examen' => $examen_join, 'items_examenes'=>$item_examen]);
        }else{
           return redirect("especiales/examenes"); 
        }
    }

    public function operar($id)
    {   
        $examen = Examen::find($id);
        return view('especiales.examen.operacion')->with(['id' => $id, 'examen' => $examen]);        
    }

    public function evaluar($id)
    {   
        $alumnos = Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get();
        //dd($alumnos);
        Session::put('id_evaluar', $id);
        $examen_join = DB::table('examenes')
            ->join('instructores', 'examenes.instructor_id', '=', 'instructores.id')
            ->select('instructores.nombre as instructor_nombre','instructores.apellido as instructor_apellido', 'examenes.id as id', 'examenes.nombre as nombre', 'examenes.fecha as fecha', 'examenes.descripcion as descripcion', 'examenes.color_etiqueta as etiqueta', 'instructores.id as instructor_id', 'examenes.academia_id as academia_id','examenes.tiempos_musicales as tiempos_musicales','examenes.compromiso as compromiso','examenes.condicion as condicion','examenes.habilidades as habilidades','examenes.disciplina as disciplina','examenes.expresion_corporal as expresion_corporal','examenes.expresion_facial as expresion_facial','examenes.destreza as destreza','examenes.dedicacion as dedicacion','examenes.oido_musical as oido_musical','examenes.postura as postura','examenes.respeto as respeto','examenes.elasticidad as elasticidad','examenes.complejidad_de_movimientos as complejidad_de_movimientos','examenes.asistencia as asistencia', 'examenes.estilo as estilo')
            ->where('examenes.id', '=', $id)
        ->first();
        
        $arrays_de_items=array();
        $i=0;

        if($examen_join->tiempos_musicales == 1){
            $arrays_de_items[$i]="Tiempos musicales";
            $i++;
        }
        if($examen_join->compromiso == 1){
            $arrays_de_items[$i]="Compromiso";
            $i++;
        }
        if($examen_join->condicion == 1){
            $arrays_de_items[$i]="Condiciones";
            $i++;
        }
        if($examen_join->habilidades == 1){
            $arrays_de_items[$i]="Habilidades";
            $i++;
        }
        if($examen_join->disciplina == 1){
            $arrays_de_items[$i]="Disciplina";
            $i++;
        }
        if($examen_join->expresion_corporal == 1){
            $arrays_de_items[$i]="Expresion corporal";
            $i++;
        }
        if($examen_join->expresion_facial == 1){
            $arrays_de_items[$i]="Expresion facial";
            $i++;
        }
        if($examen_join->respeto == 1){
            $arrays_de_items[$i]="Respeto";
            $i++;
        }
        if($examen_join->destreza == 1){
            $arrays_de_items[$i]="Destreza";
            $i++;
        }
        if($examen_join->dedicacion == 1){
            $arrays_de_items[$i]="Dedicacion";
            $i++;
        }
        if($examen_join->oido_musical == 1){
            $arrays_de_items[$i]="Oido musical";
            $i++;
        }
        if($examen_join->postura == 1){
            $arrays_de_items[$i]="Postura";
            $i++;
        }
        if($examen_join->elasticidad == 1){
            $arrays_de_items[$i]="Elasticidad";
            $i++;
        }
        if($examen_join->complejidad_de_movimientos == 1){
            $arrays_de_items[$i]="Complejidad de movimientos";
            $i++;
        }
        if($examen_join->asistencia == 1){
            $arrays_de_items[$i]="Asistencia";
            $i++;
        }
        if($examen_join->estilo == 1){
            $arrays_de_items[$i]="Estilo";
            $i++;
        }
        
        $hoy = Carbon::now()->format('m-d-Y');


        $items_examenes = ItemsExamenes::where('examen_id','=',$id)->get();

        foreach ($items_examenes as $key) {
            $arrays_de_items[$i]=$key->nombre;
            $i++;
        }

        //dd($arrays_de_items);

        return view('especiales.examen.evaluar')
               ->with(['alumno' => $alumnos, 'examen' => $examen_join, 'fecha' => $hoy, 'itemsExamenes' => $arrays_de_items, 'id' => $id]);
    }

    public function actualizar_item(Request $request){
        
    $rules = [

        'item_nuevo' => 'required',
    ];

    $messages = [

        'item_nuevo.required' => 'Ups! debe llenar el campo de nombre',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $item_nuevo = new ItemsExamenes;
                                        
        $item_nuevo->academia_id = Auth::user()->academia_id;
        $item_nuevo->nombre = $request->item_nuevo;
        $item_nuevo->examen_id = $request->id;

        $item_nuevo->save();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'item_nuevo' => $request->item_nuevo, 'id' => $item_nuevo->id, 200]);

        }
    }

    public function eliminar_item_fijo($id){


        $item_nuevo = ItemsExamenes::find($id);

        $item_nuevo->delete();

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$examen = Examen::find($id);
		
        if($examen->delete()){
            return response()->json(['mensaje' => '¡Excelente! El Examen se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
		// return redirect("alumno");
	}

    public function agregar_item(Request $request){

        
    $rules = [

        'item_nuevo' => 'required'
    ];

    $messages = [

        'item_nuevo.required' => 'Ups! debe llenar el campo de nombre',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        Session::push('nuevo_item', $request->item_nuevo);

        $item = Session::get('nuevo_item');
        end( $item );
        $contador = key( $item );

         return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'item_nuevo' => $request->item_nuevo, 'id' => $contador, 200]);

        }
    }

    public function eliminar_item($id){

        $arreglo = Session::get('nuevo_item');

        unset($arreglo[$id]);
        Session::put('nuevo_item', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

}
