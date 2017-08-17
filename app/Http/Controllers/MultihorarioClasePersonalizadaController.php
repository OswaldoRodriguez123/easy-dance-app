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
use App\ClasePersonalizada;
use App\HorarioClasePersonalizada;
use App\InscripcionClasePersonalizada;
use Validator;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MultihorarioClasePersonalizadaController extends BaseController
{


    public function principal($id){

    	Session::forget('horarios');

        $clasepersonalizada = ClasePersonalizada::join('inscripcion_clase_personalizada', 'inscripcion_clase_personalizada.clase_personalizada_id', '=', 'clases_personalizadas.id')
            ->select('inscripcion_clase_personalizada.*', 'clases_personalizadas.cantidad_horas as horas_asignadas', 'clases_personalizadas.nombre')
            ->where('inscripcion_clase_personalizada.id', $id)
        ->first();

        if($clasepersonalizada){

            $agendadas = 0;

            $hie = explode(':',$clasepersonalizada->hora_inicio);
            $hora_inicio = Carbon::createFromTime($hie[0], $hie[1], $hie[2]);

            $hfe = explode(':',$clasepersonalizada->hora_final);
            $hora_final = Carbon::createFromTime($hfe[0], $hfe[1], $hfe[2]);

            $hora_asignada = $hora_inicio->diffInHours($hora_final);
            $agendadas = $agendadas + $hora_asignada;

            $horarios = HorarioClasePersonalizada::where('clase_personalizada_id',$clasepersonalizada->id)->get();

            foreach($horarios as $horario){
                $hie = explode(':',$horario->hora_inicio);
                $hora_inicio = Carbon::createFromTime($hie[0], $hie[1], $hie[2]);

                $hfe = explode(':',$horario->hora_final);
                $hora_final = Carbon::createFromTime($hfe[0], $hfe[1], $hfe[2]);

                $hora_asignada = $hora_inicio->diffInHours($hora_final);
                $agendadas = $agendadas + $hora_asignada;
            }

            $asignadas = $clasepersonalizada->horas_asignadas;
            $por_agendar = $clasepersonalizada->horas_asignadas - $agendadas;

            $dias_de_semana = DiasDeSemana::all();
            $config_especialidades = ConfigEspecialidades::all();
            $config_estudios = ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get();        
            $instructores = Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get();

            Session::put('por_agendar', $por_agendar);

            return view(
            	'agendar.clase_personalizada.multihorario.multihorario', 
            	compact('id','clasepersonalizada',
            		    'dias_de_semana',
            		    'config_especialidades',
            		    'config_estudios',
            		    'instructores',
                        'asignadas',
                        'agendadas',
                        'por_agendar'
            		   )
            	);
        }else{
            return redirect("agendar/clases-personalizadas"); 
        }
    }

    public function agregar(Request $request){
        
        $rules = [

            'instructor_acordeon_id' => 'required',
            'especialidad_acordeon_id' => 'required',
            'estudio_id' => 'required',
            'fecha' => 'required',
            // 'dia_de_semana_id' => 'required',
            'hora_inicio_acordeon' => 'required',
            'hora_final_acordeon' => 'required',
        ];

        $messages = [

            'instructor_acordeon_id.required' => 'Ups! El Instructor es requerido',
            'fecha.required' => 'Ups! La fecha es requerida',
            // 'dia_de_semana_id.required' => 'Ups! El Dia es requerido',
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
                if($academia->tipo_horario == 1){
                    $hora_inicio = Carbon::createFromFormat('H:i',$request->hora_inicio_acordeon)->toTimeString();
                    $hora_final = Carbon::createFromFormat('H:i',$request->hora_final_acordeon)->toTimeString();
                }else{
                    $hora_inicio = Carbon::createFromFormat('H:i a',$request->hora_inicio_acordeon);
                    $hora_final = Carbon::createFromFormat('H:i a',$request->hora_final_acordeon);
                }

                if($hora_inicio > $hora_final){
                    return response()->json(['errores' => ['hora_inicio_acordeon' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
                }

                $horarios = Session::get('horarios');
                
                $fecha_inicio = Carbon::createFromFormat('d/m/Y', $request->fecha);

                $comparacion_clase = InscripcionClasePersonalizada::find($request->id);

                $fecha_inicio_clase = Carbon::createFromFormat('Y-m-d', $comparacion_clase->fecha_inicio);
                $fecha_final_clase = Carbon::createFromFormat('Y-m-d', $comparacion_clase->fecha_final);

                if($fecha_inicio->between($fecha_inicio_clase, $fecha_final_clase)){

                    $hora_asignada = $hora_inicio->diffInHours($hora_final);

                    $por_agendar = Session::get('por_agendar');

                    if($hora_asignada <= $por_agendar){

                        $por_agendar = $por_agendar - $hora_asignada;

                        Session::put('por_agendar', $por_agendar);

                        $find = Instructor::find($request->instructor_acordeon_id);
                        $instructor = $find->nombre . " " . $find->apellido;
                        $dia_de_semana = $fecha_inicio->toDateString();

                        $find = ConfigEspecialidades::find($request->especialidad_acordeon_id);
                        $especialidad = $find->nombre;

                        $find = ConfigEstudios::find($request->estudio_id);
                        $estudio = $find->nombre;

                        $array = array(['instructor' => $request->instructor_acordeon_id , 'fecha_inicio' => $fecha_inicio, 'especialidad' => $request->especialidad_acordeon_id, 'estudio' => $request->estudio_id, 'hora_inicio' => $request->hora_inicio_acordeon, 'hora_final' => $request->hora_final_acordeon, 'color_etiqueta' => $request->color_etiqueta, 'hora_asignada' => $hora_asignada]);


                        Session::push('horarios', $array);

                        $items = Session::get('horarios');
                        end( $items );
                        $contador = key( $items );

                        $array=array(
                            'instructor' => $instructor, 
                            'dia_de_semana' => $dia_de_semana,
                            'especialidad' => $especialidad,
                            'estudio' => $estudio,
                            'hora_inicio' => $request->hora_inicio_acordeon,
                            'hora_final' => $request->hora_final_acordeon,
                            'hora_asignada' => $hora_asignada,
                            'id'=>$contador
                        );                                  

                        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 200]);
                    }else{
                        return response()->json(['errores' => ['hora_inicio_acordeon' => [0, 'Ups! Has superado el límite de horas asignadas']], 'status' => 'ERROR'],422);
                    }
            }else{
                return response()->json(['errores' => ['fecha' => [0, 'Ups! Esta fecha no esta dentro del rango']], 'status' => 'ERROR'],422);
            }
        }
    }

   



    public function eliminar($id){

        $arreglo = Session::get('horarios');
        $hora_asignada = $arreglo[$id][0]['hora_asignada'];
        $por_agendar = Session::get('por_agendar');
        $por_agendar = intval($por_agendar + $hora_asignada);
        unset($arreglo[$id]);
        Session::put('horarios', $arreglo);
        Session::put('por_agendar', $por_agendar);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han eliminado satisfactoriamente', 'status' => 'OK', 'hora_asignada' => $hora_asignada, 200]);

    }

    public function CancelarHorarios()
    {   
        if (Session::has('horarios')) {

            Session::forget('horarios');
            return response()->json(['status' => 'OK', 200]);  
        }
        else
        {
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
                    
                    if($academia->tipo_horario == 1){
                        $hora_inicio = Carbon::createFromFormat('H:i',$horario['hora_inicio'])->toTimeString();
                        $hora_final = Carbon::createFromFormat('H:i',$horario['hora_final'])->toTimeString();
                    }else{
                        $hora_inicio = Carbon::createFromFormat('H:i a',$horario['hora_inicio'])->toTimeString();
                        $hora_final = Carbon::createFromFormat('H:i a',$horario['hora_final'])->toTimeString();
                    }

                    $horario_clase_grupal = new HorarioClasePersonalizada();

                    $horario_clase_grupal->fecha=$horario['fecha_inicio'];
                    $horario_clase_grupal->hora_inicio=$hora_inicio;
                    $horario_clase_grupal->hora_final=$hora_final;
                    $horario_clase_grupal->instructor_id=$horario['instructor'];
                    $horario_clase_grupal->especialidad_id=$horario['especialidad'];
                    $horario_clase_grupal->estudio_id=$horario['estudio'];
                    $horario_clase_grupal->color_etiqueta=$horario['color_etiqueta'];
                    $horario_clase_grupal->clase_personalizada_id=$request->id;

                    $horario_clase_grupal->save();

                       
                }
            }

            return response()->json(['mensaje' => '¡Excelente! Los campos se han eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores' => ['linea' => [0, 'Ups! ha ocurrido un error, debes agregar un horario']], 'status' => 'ERROR'],422);
        }
    }

    public function edit($id)
    {

        $clase_personalizada_join = DB::table('horarios_clases_personalizadas')
            ->join('inscripcion_clase_personalizada', 'horarios_clases_personalizadas.clase_personalizada_id', '=', 'inscripcion_clase_personalizada.id')
            ->join('config_especialidades', 'horarios_clases_personalizadas.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_estudios', 'horarios_clases_personalizadas.estudio_id', '=', 'config_estudios.id')
            ->join('instructores', 'horarios_clases_personalizadas.instructor_id', '=', 'instructores.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','config_estudios.nombre as estudio_nombre', 'horarios_clases_personalizadas.hora_inicio','horarios_clases_personalizadas.hora_final', 'horarios_clases_personalizadas.id' , 'horarios_clases_personalizadas.fecha', 'inscripcion_clase_personalizada.id as clase_personalizada_id', 'horarios_clases_personalizadas.color_etiqueta')
            ->where('horarios_clases_personalizadas.id', '=', $id)
        ->first();

        if($clase_personalizada_join){

            $fecha = Carbon::createFromFormat('Y-m-d', $clase_personalizada_join->fecha);

            $i = $fecha->dayOfWeek;

            if($i == 1){

              $dia = 'Lunes';

            }else if($i == 2){

              $dia = 'Martes';

            }else if($i == 3){

              $dia = 'Miercoles';

            }else if($i == 4){

              $dia = 'Jueves';

            }else if($i == 5){

              $dia = 'Viernes';

            }else if($i == 6){

              $dia = 'Sabado';

            }else if($i == 0){

              $dia = 'Domingo';

            }

            $dia = $clase_personalizada_join->fecha;

            return view('agendar.clase_personalizada.multihorario.planilla')->with(['config_especialidades' => ConfigEspecialidades::all(), 'config_estudios' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'instructores' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->orderBy('nombre', 'asc')->get(), 'clasegrupal' => $clase_personalizada_join,  'id' => $id, 'dias_de_semana' => DiasDeSemana::all(), 'dia_de_semana' => $dia]);

        }else{
           return redirect("agendar/clases-personalizadas"); 
        }

    }

    public function updateEspecialidad(Request $request){
        $clasegrupal = HorarioClasePersonalizada::find($request->id);
        $clasegrupal->especialidad_id = $request->especialidad_id;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateDia(Request $request){

        $rules = [
            'fecha' => 'required',
        ];

        $messages = [

            'fecha.required' => 'Ups! La fecha es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{
        
            $clasegrupal = HorarioClasePersonalizada::find($request->id);
            $fecha_inicio = Carbon::createFromFormat('d/m/Y', $request->fecha);

            $comparacion_clase = InscripcionClasePersonalizada::find($clasegrupal->clase_personalizada_id);

            $fecha_inicio_clase = Carbon::createFromFormat('Y-m-d', $comparacion_clase->fecha_inicio);
            $fecha_final_clase = Carbon::createFromFormat('Y-m-d', $comparacion_clase->fecha_final);

            if($fecha_inicio->between($fecha_inicio_clase, $fecha_final_clase)){

                // $fecha_inicio = Carbon::createFromFormat('Y-m-d', $clasegrupal->fecha);
                // $dia_de_semana = $fecha_inicio->dayOfWeek;

                // if(intval($request->dia_de_semana_id) >= $dia_de_semana){
                //     $dias = intval($request->dia_de_semana_id) - intval($dia_de_semana);
                //     $fecha_inicio->addDays($dias)->toDateString();
                // }else{
                //     $dias = intval($dia_de_semana) - intval($request->dia_de_semana_id);
                //     $fecha_inicio->addWeek();
                //     $fecha_inicio->subDays($dias)->toDateString();
                    
                // }

                $clasegrupal->fecha = $fecha_inicio;

                if($clasegrupal->save()){
                    return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }
            }else{
                return response()->json(['errores' => ['fecha' => [0, 'Ups! Esta fecha no esta dentro del rango']], 'status' => 'ERROR'],422);
            }
        }
    }

    public function updateInstructor(Request $request){
        $clasegrupal = HorarioClasePersonalizada::find($request->id);
        $clasegrupal->instructor_id = $request->instructor_id;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEstudio(Request $request){
        $clasegrupal = HorarioClasePersonalizada::find($request->id);
        $clasegrupal->estudio_id = $request->estudio_id;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEtiqueta(Request $request){
        $clasegrupal = HorarioClasePersonalizada::find($request->id);
        $clasegrupal->color_etiqueta = $request->color_etiqueta;

        if($clasegrupal->save()){
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

            $clasegrupal = HorarioClasePersonalizada::find($request->id);

            $academia = Academia::find(Auth::user()->academia_id);

            if($academia->tipo_horario == 1){
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

            $clasegrupal->hora_inicio = $hora_inicio;
            $clasegrupal->hora_final = $hora_final;

            if($clasegrupal->save()){
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

}
