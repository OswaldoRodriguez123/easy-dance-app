<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Examen;
use App\Alumno;
use App\Instructor;
use App\ItemsExamenes;
use Validator;
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
            ->select('examenes.id as id' , 'examenes.nombre as nombre', 'examenes.fecha as fecha', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido')
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
		return view('especiales.examen.create')->with('instructor', Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get());
	}

    public function store(Request $request)
    {
        // dd($request->all());


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

        $examen = new Examen;

        $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->nombre))));

        $examen->academia_id = Auth::user()->academia_id;
        $examen->nombre = $nombre;
        $examen->descripcion = $request->descripcion;
        $examen->fecha= $request->fecha;
        $examen->color_etiqueta = $request->color_etiqueta;
        $examen->instructor_id = $request->instructor_id;
        $examen->condiciones = $request->condiciones;

        if($examen->save()){
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
            ->select('instructores.nombre as instructor_nombre','instructores.apellido as instructor_apellido', 'examenes.id as id', 'examenes.nombre as nombre', 'examenes.fecha as fecha', 'examenes.descripcion as descripcion', 'examenes.color_etiqueta as etiqueta')
            ->where('examenes.id', '=', $id)
        ->first();

        $examen = Examen::find($id);

        if($examen){
           return view('especiales.examen.planilla')->with(['instructor' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'examen' => $examen_join]);
        }else{
           return redirect("participante/visitante"); 
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
        $examen_join = DB::table('examenes')
            ->join('instructores', 'examenes.instructor_id', '=', 'instructores.id')
            ->select('instructores.nombre as instructor_nombre','instructores.apellido as instructor_apellido', 'examenes.id as id', 'examenes.nombre as nombre', 'examenes.fecha as fecha', 'examenes.descripcion as descripcion', 'examenes.color_etiqueta as etiqueta')
            ->where('examenes.id', '=', $id)
        ->first();
  
        $hoy = Carbon::now()->format('m-d-Y');


        $items_examenes = ItemsExamenes::where('examen_id','=',$id)->get();

        //dd($items_examenes);

        return view('especiales.examen.evaluar')
               ->with(['alumno' => $alumnos, 'examen' => $examen_join, 'fecha' => $hoy, 'itemsExamenes' => $items_examenes]);
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

}
