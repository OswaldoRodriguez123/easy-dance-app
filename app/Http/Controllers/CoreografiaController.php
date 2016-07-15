<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Alumno;
use App\Academia;
use App\DiasDeSemana;
use App\ConfigEstudios;
use App\ConfigNiveles;
use App\Instructor;
use App\Coreografia;
use App\InscripcionCoreografia;
use Carbon\Carbon;
use Validator;
use DB;
use Mail;
use Session;
use Illuminate\Support\Facades\Auth;

class CoreografiaController extends BaseController {


 	public function principal(){

        $coreografia = DB::table('coreografias')
            ->leftJoin('instructores', 'coreografias.instructor_id', '=', 'instructores.id')
            ->select('coreografias.id as id', 'coreografias.nombre_coreografia', 'instructores.nombre as nombre_coreografo', 'instructores.apellido as apellido_coreografo')
        ->get();

        $alumnod = DB::table('inscripcion_coreografia')
            ->select('inscripcion_coreografia.alumno_id', 'inscripcion_coreografia.coreografia_id')
        ->get();

        $collection=collect($alumnod);
        $grouped = $collection->groupBy('coreografia_id');     
        $deuda = $grouped->toArray();

        $array=array();
        $i = 0;
       
        foreach($deuda as $item){
        	$total = 0;
            foreach($item as $tmp){

            	$coreografia_id = $tmp->coreografia_id;
            	$total = $total + 1;

            }
            $coreografia[$i]->cantidad=$total;
            $array[$coreografia_id] = $coreografia[$i];

            $i = $i + 1;
        }
        
        return view('configuracion.coreografia.principal')->with('coreografias', $coreografia);

    }

    public function create()
    {
        return view('configuracion.coreografia.create')->with(['instructor' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'dias_de_semana' => DiasDeSemana::all(), 'alumnos' => Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'estudio' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get()]);
    }

    public function store(Request $request)
    {

    $rules = [
        'nombre_evento' => 'required',
        'color_etiqueta' => 'required',
    ];

    $messages = [

        'nombre_evento.required' => 'Ups! El Nombre del evento es requerido',
        'color_etiqueta.required' => 'Ups! La etiqueta es requerida',
     
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

    	if($request->fecha)
    	{
    		$fecha = Carbon::createFromFormat('d/m/Y', $request->fecha)->toDateString();
    	}
    	else{
    		$fecha = '';
    	}

        $coreografia = new Coreografia;

        $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->nombre_evento))));
        $nombre2 = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->nombre_evento))));
        
        $coreografia->academia_id = Auth::user()->academia_id;
        $coreografia->nombre_evento = $nombre;
        $coreografia->color_etiqueta = $request->color_etiqueta;
        $coreografia->nombre_coreografia = $nombre2;
        $coreografia->fecha = $fecha;
        $coreografia->cantidad_minima = $request->cantidad_minima;
        $coreografia->cantidad_maxima = $request->cantidad_maxima;
        $coreografia->condiciones = $request->condiciones;
        $coreografia->instructor_id = $request->instructor_id;
        $coreografia->tiempo_duracion = $request->tiempo_duracion;
        $coreografia->descripcion = $request->descripcion;

        if($coreografia->save()){

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function operar($id)
    {   
        $coreografia = Coreografia::find($id);

        return view('configuracion.coreografia.operacion')->with(['id' => $id, 'coreografia' => $coreografia]);        
    }

    public function edit($id)
    {
        $coreografia = DB::table('coreografias')
                ->join('instructores', 'coreografias.instructor_id', '=', 'instructores.id')
                ->select('instructores.nombre as coreografo_nombre', 'instructores.apellido as coreografo_apellido' , 'coreografias.nombre_evento', 'coreografias.nombre_coreografia', 'coreografias.fecha as fecha', 'coreografias.cantidad_minima', 'coreografias.cantidad_maxima', 'coreografias.condiciones', 'coreografias.tiempo_duracion', 'coreografias.descripcion', 'coreografias.id')
                ->where('coreografias.id', '=', $id)
        ->first();

        return view('configuracion.coreografia.planilla')->with(['coreografia' => $coreografia , 'instructor' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get()]);
    }

    public function participantes($id)
    {

        $coreografia = Coreografia::find($id);

        $alumnos_inscritos = DB::table('inscripcion_coreografia')
                ->join('alumnos', 'inscripcion_coreografia.alumno_id', '=', 'alumnos.id')
                ->select('alumnos.*')
                ->where('inscripcion_coreografia.coreografia_id', '=', $id)
        ->get();

        $alumnos = Alumno::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

        return view('configuracion.coreografia.participantes')->with(['alumnos_inscritos' => $alumnos_inscritos, 'id' => $id, 'coreografia' => $coreografia, 'alumnos' => $alumnos]);
    }

    public function storeInscripcion(Request $request)
    {

    $rules = [
        'coreografia_id' => 'required',
        'alumno_id' => 'required',
    ];

    $messages = [

        'coreografia_id.required' => 'Ups! El Nombre  es requerido',
        'alumno_id.required' => 'Ups! El Alumno es requerido',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

            $alumnos = explode('-',$request->alumno_id);

            $array=array();

            for($i = 1 ; $i<count($alumnos) ; $i++)
            {
                $inscripcion = new InscripcionCoreografia;

                $inscripcion->coreografia_id = $request->coreografia_id;
                $inscripcion->alumno_id = $alumnos[$i];

                $inscripcion->save();
                
                $alumno = Alumno::find($alumnos[$i]);

                $array[$i] = $alumno;

            }
       
             return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 200]);
 
        }
    }
}