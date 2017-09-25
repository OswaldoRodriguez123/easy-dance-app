<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use DB;
use App\Academia;
use App\DiasDeSemana;
use App\ConfigEspecialidades;
use App\ConfigEstudios;
use App\Instructor;
use App\Taller;
use App\HorarioTaller;
use Validator;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MultihorarioTallerController extends BaseController
{


    public function principal($id){

    	Session::forget('horarios');

        $taller = Taller::find($id);

        if($taller){

            $config_especialidades = ConfigEspecialidades::all();
            $config_estudios = ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get();        
            $instructores = Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

            return view(
            	'agendar.taller.multihorario.multihorario', 
            	compact('id','taller',
            		    'config_especialidades',
            		    'config_estudios',
            		    'instructores'
            		   )
            	);
        }
    }

    public function agregar(Request $request){
        
        $rules = [

            'instructor_acordeon_id' => 'required',
            'especialidad_acordeon_id' => 'required',
            'estudio_id' => 'required',
            'fecha' => 'required',
            'hora_inicio_acordeon' => 'required',
            'hora_final_acordeon' => 'required',
        ];

        $messages = [

            'instructor_acordeon_id.required' => 'Ups! El Instructor es requerido',
            'fecha.required' => 'Ups! La fecha es requerida',
            'especialidad_acordeon_id.required' => 'Ups! La Especialidad es requerida',
            'estudio_id.required' => 'Ups! El Estudio es requerido',
            'hora_inicio_acordeon.required' => 'Ups! La hora de inicio es requerida',
            'hora_final_acordeon.required' => 'Ups! La hora final es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{

            $academia = Academia::find(Auth::user()->academia_id);
            if($academia->tipo_horario == 2){
                $hora_inicio = Carbon::createFromFormat('H:i',$request->hora_inicio_acordeon)->toTimeString();
                $hora_final = Carbon::createFromFormat('H:i',$request->hora_final_acordeon)->toTimeString();
            }else{
                $hora_inicio = Carbon::createFromFormat('H:i a',$request->hora_inicio_acordeon)->toTimeString();
                $hora_final = Carbon::createFromFormat('H:i a',$request->hora_final_acordeon)->toTimeString();
            }

            if($hora_inicio > $hora_final)
            {
                return response()->json(['errores' => ['hora_inicio_acordeon' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
            }

            $fecha = Carbon::createFromFormat('d/m/Y',$request->fecha)->toDateString();

            $find = Instructor::find($request->instructor_acordeon_id);
            $instructor = $find->nombre . " " . $find->apellido;

            $find = ConfigEspecialidades::find($request->especialidad_acordeon_id);
            $especialidad = $find->nombre;

            $find = ConfigEstudios::find($request->estudio_id);
            $estudio = $find->nombre;

            $array = array(['instructor' => $request->instructor_acordeon_id , 'fecha' => $fecha, 'especialidad' => $request->especialidad_acordeon_id, 'estudio' => $request->estudio_id, 'hora_inicio' => $request->hora_inicio_acordeon, 'hora_final' => $request->hora_final_acordeon, 'color_etiqueta' => $request->color_etiqueta]);


            Session::push('horarios', $array);

            $items = Session::get('horarios');
            end( $items );
            $contador = key( $items );

            $array=array(
                'instructor' => $instructor, 
                'fecha' => $fecha,
                'especialidad' => $especialidad,
                'estudio' => $estudio,
                'hora_inicio' => $request->hora_inicio_acordeon,
                'hora_final' => $request->hora_final_acordeon,
                'id'=>$contador
            );                                 

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 200]);


        }
    }


    public function eliminar($id){

        $arreglo = Session::get('horarios');
        unset($arreglo[$id]);
        Session::put('horarios', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han eliminado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function CancelarHorarios(){   
        if (Session::has('horarios')) {

            Session::forget('horarios');
            return response()->json(['status' => 'OK', 200]);  
        }else{
            return response()->json(['status' => 'OK', 200]);
        }
    }

    public function GuardarHorarios(Request $request)
    {   
        $horarios = Session::get('horarios');

        if (count($horarios) > 0){
            foreach($horarios as $tmp){
                foreach($tmp as $horario){

                    $academia = Academia::find(Auth::user()->academia_id);
                    
                    if($academia->tipo_horario == 2){
                        $hora_inicio = Carbon::createFromFormat('H:i',$horario['hora_inicio'])->toTimeString();
                        $hora_final = Carbon::createFromFormat('H:i',$horario['hora_final'])->toTimeString();
                    }else{
                        $hora_inicio = Carbon::createFromFormat('H:i a',$horario['hora_inicio'])->toTimeString();
                        $hora_final = Carbon::createFromFormat('H:i a',$horario['hora_final'])->toTimeString();
                    }

                    $horario_taller = new HorarioTaller();

                    $horario_taller->fecha=$horario['fecha'];
                    $horario_taller->hora_inicio=$hora_inicio;
                    $horario_taller->hora_final=$hora_final;
                    $horario_taller->instructor_id=$horario['instructor'];
                    $horario_taller->especialidad_id=$horario['especialidad'];
                    $horario_taller->estudio_id=$horario['estudio'];
                    $horario_taller->color_etiqueta=$horario['color_etiqueta'];
                    $horario_taller->taller_id=$request->id;

                    $horario_taller->save();

                       
                }
            }

            return response()->json(['mensaje' => '¡Excelente! Los campos se han eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores' => ['linea' => [0, 'Ups! ha ocurrido un error, debes agregar un horario']], 'status' => 'ERROR'],422);
        }
    }

    public function edit($id)
    {

        $horario = HorarioTaller::join('talleres', 'horarios_talleres.taller_id', '=', 'talleres.id')
            ->join('config_especialidades', 'horarios_talleres.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_estudios', 'horarios_talleres.estudio_id', '=', 'config_estudios.id')
            ->join('instructores', 'horarios_talleres.instructor_id', '=', 'instructores.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','config_estudios.nombre as estudio_nombre', 'horarios_talleres.hora_inicio','horarios_talleres.hora_final', 'horarios_talleres.id' , 'horarios_talleres.fecha', 'talleres.id as taller_id', 'horarios_talleres.color_etiqueta')
            ->where('horarios_talleres.id', '=', $id)
        ->first();

        if($horario){

            $fecha = Carbon::createFromFormat('Y-m-d', $horario->fecha);

            return view('agendar.taller.multihorario.planilla')->with(['config_especialidades' => ConfigEspecialidades::all(), 'config_estudios' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'instructores' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get(), 'horario' => $horario,  'id' => $id, 'fecha' => $fecha]);

        }else{
           return redirect("agendar/talleres"); 
        }

    }

    public function updateEspecialidad(Request $request){
        $horario = HorarioTaller::find($request->id);
        $horario->especialidad_id = $request->especialidad_id;

        if($horario->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateDia(Request $request){
        
        $horario = HorarioTaller::find($request->id);

        $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);

        $horario->fecha = $fecha;

        if($horario->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateInstructor(Request $request){
        $horario = HorarioTaller::find($request->id);
        $horario->instructor_id = $request->instructor_id;

        if($horario->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEstudio(Request $request){
        $horario = HorarioTaller::find($request->id);
        $horario->estudio_id = $request->estudio_id;

        if($horario->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEtiqueta(Request $request){
        $horario = HorarioTaller::find($request->id);
        $horario->color_etiqueta = $request->color_etiqueta;

        if($horario->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateHorario(Request $request){

        $rules = [
            'hora_inicio' => 'required',
            'hora_final' => 'required',
        ];

        $messages = [

            'hora_inicio.required' => 'Ups! La hora de inicio es requerida',
            'hora_final.required' => 'Ups! La hora final es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $horario = HorarioTaller::find($request->id);

            $academia = Academia::find(Auth::user()->academia_id);

            if($academia->tipo_horario == 2){
                $hora_inicio = Carbon::createFromFormat('H:i',$request->hora_inicio)->toTimeString();
                $hora_final = Carbon::createFromFormat('H:i',$request->hora_final)->toTimeString();
            }else{
                $hora_inicio = Carbon::createFromFormat('H:i a',$request->hora_inicio)->toTimeString();
                $hora_final = Carbon::createFromFormat('H:i a',$request->hora_final)->toTimeString();
            }

            if($hora_inicio > $hora_final)
            {
                return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
            }

            $horario->hora_inicio = $hora_inicio;
            $horario->hora_final = $hora_final;

            if($horario->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function destroy($id)
    {

        $horario = HorarioTaller::find($id);
    
        if($horario->delete()){
            return response()->json(['mensaje' => '¡Excelente! El horario se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

}
