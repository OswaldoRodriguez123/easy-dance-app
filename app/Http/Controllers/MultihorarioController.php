<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use DB;
use App\DiasDeSemana;
use App\ConfigEspecialidades;
use App\ConfigEstudios;
use App\Instructor;
use App\ClaseGrupal;
use App\HorarioClaseGrupal;
use Validator;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MultihorarioController extends BaseController
{


    public function principal($id){

    	Session::forget('horarios');

        $clasegrupal = DB::table('config_clases_grupales')
                ->join('clases_grupales', 
                    'clases_grupales.clase_grupal_id', 
                    '=', 
                    'config_clases_grupales.id')
                ->select('config_clases_grupales.*',
                 'clases_grupales.fecha_inicio_preferencial',
                 'clases_grupales.fecha_inicio as fecha_inicio',
                 'clases_grupales.fecha_final as fecha_final')
                ->where('clases_grupales.id', '=', $id)
        ->first();

        $dias_de_semana = DiasDeSemana::all();
        $config_especialidades = ConfigEspecialidades::all();
        $config_estudios = ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get();        
        $instructores = Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

        // $horario_clase_grupal=HorarioClaseGrupal::where('clase_grupal_id',$id)
        //     ->join('config_especialidades', 
        //         'horario_clase_grupales.especialidad_id',
        //         '=', 
        //         'config_especialidades.id'
        //         )
        //     ->join('instructores', 
        //         'horario_clase_grupales.instructor_id',
        //         '=',
        //         'instructores.id'
        //          )
        //     ->join('config_estudios', 
        //         'horario_clase_grupales.estudio_id',
        //         '=',
        //         'config_estudios.id'
        //          )
        //     ->select('horario_clase_grupales.*', 
        //         'instructores.nombre as instructor_nombre',
        //         'instructores.apellido as instructor_apellido',
        //         'config_especialidades.nombre as especialidad_nombre', 
        //         'config_estudios.nombre as estudio_nombre'
        //          )
        //     ->get();

        // $arrayHorario= array();

        // foreach ($horario_clase_grupal as $horario) {
        //     $instructor=$horario->instructor_nombre.' '.$horario->instructor_apellido;
        //     $especialidad=$horario->especialidad_nombre;
        //     $estudio = $horario->estudio_nombre;
        //     $fecha=$horario->fecha;
        //     $hora_inicio=$horario->hora_inicio;
        //     $hora_final=$horario->hora_final;
        //     $id_horario=$horario->id;

        //     $fc=explode('-',$fecha);
        //     $fecha_curso=Carbon::create($fc[0], $fc[1], $fc[2], 00, 00, 00);
        //     $dia_curso = $fecha_curso->format('l');

        //     $dia_de_semana="";

        //     $dia_curso=strtoupper($dia_curso);

        //     if($dia_curso=="SUNDAY")
        //     {
        //         $dia="6";
        //         $dia_de_semana="Domingo";
        //     }
        //     elseif($dia_curso=="MONDAY")
        //     {
        //         $dia="0";
        //         $dia_de_semana="Lunes";
        //     }
        //     elseif($dia_curso=="TUESDAY")
        //     {
        //         $dia="1";
        //         $dia_de_semana="Martes";

        //     }
        //     elseif($dia_curso=="WEDNESDAY")
        //     {
        //         $dia="2";
        //         $dia_de_semana="Míercoles";                
        //     }
        //     elseif($dia_curso=="THURSDAY")
        //     {
        //         $dia="3";
        //         $dia_de_semana="Jueves";                
        //     }
        //     elseif($dia_curso=="FRIDAY")
        //     {
        //         $dia="4";
        //         $dia_de_semana="Viernes";
        //     }
        //     elseif($dia_curso=="SATURDAY")
        //     {
        //         $dia="5";
        //         $dia_de_semana="Sábado";
        //     }

        //     $arrayHorario[$id_horario] = array(
        //             'instructor' => $instructor,
        //             'dia_de_semana' => $dia_de_semana,
        //             'new_dia_de_semama'=>$dia_curso,
        //             'especialidad' => $especialidad,
        //             'estudio' => $estudio,
        //             'hora_inicio' => $hora_inicio,
        //             'new_hora_inicio' => $hora_inicio,
        //             'hora_final' => $hora_final,
        //             'new_hora_final' => $hora_final,
        //             'fecha'=> $fecha,
        //             'id'=>$id_horario
        //     );
        // }

        return view(
        	'agendar.multihorario.multihorario', 
        	compact('id','clasegrupal',
        		    'dias_de_semana',
        		    'config_especialidades',
        		    'config_estudios',
        		    'instructores'
        		   )
        	);
    }

    public function agregar(Request $request){
        
        $rules = [

            'instructor_acordeon_id' => 'required',
            'especialidad_acordeon_id' => 'required',
            'estudio_id' => 'required',
            'dia_de_semana_id' => 'required',
            'hora_inicio_acordeon' => 'required',
            'hora_final_acordeon' => 'required',
        ];

        $messages = [

            'instructor_acordeon_id.required' => 'Ups! El Instructor es requerido',
            'dia_de_semana_id.required' => 'Ups! El Dia es requerido',
            'especialidad_acordeon_id.required' => 'Ups! La Especialidad es requerida',
            'estudio_id.required' => 'Ups! El Estudio es requerido',
            'hora_inicio_acordeon.required' => 'Ups! La hora de inicio es requerida',
            'hora_final_acordeon.required' => 'Ups! La hora final es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{

                $hora_inicio = strtotime($request->hora_inicio_acordeon);
                $hora_final = strtotime($request->hora_final_acordeon);

                if($hora_inicio > $hora_final)
                {

                    return response()->json(['errores' => ['hora_inicio_acordeon' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
                }

                $comparacion_instructor_clase = ClaseGrupal::where('instructor_id', $request->instructor_acordeon_id)->get();

                foreach($comparacion_instructor_clase as $comparacion){
                    $fecha_inicio = Carbon::createFromFormat('Y-m-d', $comparacion->fecha_inicio);
                    $dia_de_semana = $fecha_inicio->dayOfWeek;

                    if(intval($request->dia_de_semana_id) == $dia_de_semana){

                        $hora_inicio = Carbon::createFromFormat('H:i:s', $comparacion->hora_inicio);
                        $hora_final = Carbon::createFromFormat('H:i:s', $comparacion->hora_final);

                        
                        $hora_inicio_ingresada = Carbon::createFromFormat('H:i', $request->hora_inicio_acordeon);
                        $hora_final_ingresada = Carbon::createFromFormat('H:i', $request->hora_final_acordeon);

                        // dd($hora_inicio->toTimeString() . ' ' . $hora_final->toTimeString() . ' ' . $hora_inicio_ingresada->toTimeString());

                        if($hora_inicio_ingresada->between($hora_inicio, $hora_final) OR $hora_final_ingresada->between($hora_inicio, $hora_final)){
                            return response()->json(['errores' => ['hora_inicio_acordeon' => [0, 'Ups! El instructor tiene una clase asignada a esta hora']], 'status' => 'ERROR'],422);
                        }

                        if($hora_inicio->between($hora_inicio_ingresada, $hora_final_ingresada) OR $hora_final->between($hora_inicio_ingresada, $hora_final_ingresada)){
                            return response()->json(['errores' => ['hora_inicio_acordeon' => [0, 'Ups! El instructor tiene una clase asignada a esta hora']], 'status' => 'ERROR'],422);
                        }            
                    }
                }

                $comparacion_instructor_horario = HorarioClaseGrupal::where('instructor_id', $request->instructor_acordeon_id)->get();

                foreach($comparacion_instructor_horario as $comparacion){
                    $fecha_inicio = Carbon::createFromFormat('Y-m-d', $comparacion->fecha);
                    $dia_de_semana = $fecha_inicio->dayOfWeek;

                    if(intval($request->dia_de_semana_id) == $dia_de_semana){

                        $hora_inicio = Carbon::createFromFormat('H:i:s', $comparacion->hora_inicio);
                        $hora_final = Carbon::createFromFormat('H:i:s', $comparacion->hora_final);

                        
                        $hora_inicio_ingresada = Carbon::createFromFormat('H:i', $request->hora_inicio_acordeon);
                        $hora_final_ingresada = Carbon::createFromFormat('H:i', $request->hora_final_acordeon);

                        if($hora_inicio_ingresada->between($hora_inicio, $hora_final) OR $hora_final_ingresada->between($hora_inicio, $hora_final)){
                            return response()->json(['errores' => ['hora_inicio_acordeon' => [0, 'Ups! El instructor tiene una clase asignada a esta hora']], 'status' => 'ERROR'],422);
                        } 

                        if($hora_inicio->between($hora_inicio_ingresada, $hora_final_ingresada) OR $hora_final->between($hora_inicio_ingresada, $hora_final_ingresada)){
                            return response()->json(['errores' => ['hora_inicio_acordeon' => [0, 'Ups! El instructor tiene una clase asignada a esta hora']], 'status' => 'ERROR'],422);
                        }         
                    }
                }

                $comparacion_estudio_clase = ClaseGrupal::where('estudio_id', $request->estudio_id)->get();

                foreach($comparacion_estudio_clase as $comparacion){
                    $fecha_inicio = Carbon::createFromFormat('Y-m-d', $comparacion->fecha_inicio);
                    $dia_de_semana = $fecha_inicio->dayOfWeek;

                    if(intval($request->dia_de_semana_id) == $dia_de_semana){

                        $hora_inicio = Carbon::createFromFormat('H:i:s', $comparacion->hora_inicio);
                        $hora_final = Carbon::createFromFormat('H:i:s', $comparacion->hora_final);

                        
                        $hora_inicio_ingresada = Carbon::createFromFormat('H:i', $request->hora_inicio_acordeon);
                        $hora_final_ingresada = Carbon::createFromFormat('H:i', $request->hora_final_acordeon);

                        if($hora_inicio_ingresada->between($hora_inicio, $hora_final) OR $hora_final_ingresada->between($hora_inicio, $hora_final)){
                            return response()->json(['errores' => ['hora_inicio_acordeon' => [0, 'Ups! El estudio tiene una clase asignada a esta hora']], 'status' => 'ERROR'],422);
                        }

                        if($hora_inicio->between($hora_inicio_ingresada, $hora_final_ingresada) OR $hora_final->between($hora_inicio_ingresada, $hora_final_ingresada)){
                            return response()->json(['errores' => ['hora_inicio_acordeon' => [0, 'Ups! El estudio tiene una clase asignada a esta hora']], 'status' => 'ERROR'],422);
                        }          
                    }
                }

                $comparacion_estudio_horario = HorarioClaseGrupal::where('estudio_id', $request->estudio_id)->get();

                foreach($comparacion_estudio_horario as $comparacion){
                    $fecha_inicio = Carbon::createFromFormat('Y-m-d', $comparacion->fecha);
                    $dia_de_semana = $fecha_inicio->dayOfWeek;

                    if(intval($request->dia_de_semana_id) == $dia_de_semana){

                        $hora_inicio = Carbon::createFromFormat('H:i:s', $comparacion->hora_inicio);
                        $hora_final = Carbon::createFromFormat('H:i:s', $comparacion->hora_final);

                        
                        $hora_inicio_ingresada = Carbon::createFromFormat('H:i', $request->hora_inicio_acordeon);
                        $hora_final_ingresada = Carbon::createFromFormat('H:i', $request->hora_final_acordeon);

                        if($hora_inicio_ingresada->between($hora_inicio, $hora_final) OR $hora_final_ingresada->between($hora_inicio, $hora_final)){
                            return response()->json(['errores' => ['hora_inicio_acordeon' => [0, 'Ups! El estudio tiene una clase asignada a esta hora']], 'status' => 'ERROR'],422);
                        }

                        if($hora_inicio->between($hora_inicio_ingresada, $hora_final_ingresada) OR $hora_final->between($hora_inicio_ingresada, $hora_final_ingresada)){
                            return response()->json(['errores' => ['hora_inicio_acordeon' => [0, 'Ups! El estudio tiene una clase asignada a esta hora']], 'status' => 'ERROR'],422);
                        }          
                    }
                }

                $horarios = Session::get('horarios');

                if($horarios)
                {
                    foreach($horarios as $tmp){
                        foreach($tmp as $horario){

                            $fecha_inicio = $horario['fecha_inicio'];
                            $dia_de_semana = $fecha_inicio->dayOfWeek;

                            if(intval($request->dia_de_semana_id) == $dia_de_semana){

                                $hora_inicio = Carbon::createFromFormat('H:i', $horario['hora_inicio']);
                                $hora_final = Carbon::createFromFormat('H:i', $horario['hora_final']);

                                $hora_inicio_ingresada = Carbon::createFromFormat('H:i', $request->hora_inicio_acordeon);
                                $hora_final_ingresada = Carbon::createFromFormat('H:i', $request->hora_final_acordeon);


                                if($hora_inicio_ingresada->between($hora_inicio, $hora_final) OR $hora_final_ingresada->between($hora_inicio, $hora_final)){

                                    if($request->estudio_id == $horario['estudio']){
                                       return response()->json(['errores' => ['hora_inicio_acordeon' => [0, 'Ups! El estudio tiene una clase asignada a esta hora']], 'status' => 'ERROR'],422); 
                                    }

                                    if($request->instructor_acordeon_id == $horario['instructor']){
                                       return response()->json(['errores' => ['hora_inicio_acordeon' => [0, 'Ups! El instructor tiene una clase asignada a esta hora']], 'status' => 'ERROR'],422); 
                                    }
                                }

                                if($hora_inicio->between($hora_inicio_ingresada, $hora_final_ingresada) OR $hora_final->between($hora_inicio_ingresada, $hora_final_ingresada)){

                                    if($request->estudio_id == $horario['estudio']){
                                       return response()->json(['errores' => ['hora_inicio_acordeon' => [0, 'Ups! El estudio tiene una clase asignada a esta hora']], 'status' => 'ERROR'],422); 
                                    }

                                    if($request->instructor_acordeon_id == $horario['instructor']){
                                       return response()->json(['errores' => ['hora_inicio_acordeon' => [0, 'Ups! El instructor tiene una clase asignada a esta hora']], 'status' => 'ERROR'],422); 
                                    }
                                }  
                            }        
                        }
                    }
                }

                //$time=Carbon::createFromFormat('H:m:s', $multH['new_hora_inicio'])->toDateTimeString(); 

                $fecha_inicio = Carbon::now();
                $dia_de_semana = $fecha_inicio->dayOfWeek;

                if(intval($request->dia_de_semana_id) >= $dia_de_semana){
                    $dias = intval($request->dia_de_semana_id) - intval($dia_de_semana);
                    $fecha_inicio->addDays($dias)->toDateString();
                }else{
                    $dias = intval($dia_de_semana) - intval($request->dia_de_semana_id);
                    $fecha_inicio->addWeek();
                    $fecha_inicio->subDays($dias)->toDateString();
                    
                }

                $find = Instructor::find($request->instructor_acordeon_id);
                $instructor = $find->nombre . " " . $find->apellido;

                $find = DiasDeSemana::find($request->dia_de_semana_id);
                $dia_de_semana = $find->nombre;

                $find = ConfigEspecialidades::find($request->especialidad_acordeon_id);
                $especialidad = $find->nombre;

                $find = ConfigEstudios::find($request->estudio_id);
                $estudio = $find->nombre;

                // $fecha_clasegrupal=ClaseGrupal::find($request->id);
                // $fecha_clasegrupal_inicio=$fecha_clasegrupal->fecha_inicio;
                // $fecha_clasegrupal_final=$fecha_clasegrupal->fecha_final;


                // $horario_clase_grupal = new HorarioClaseGrupal();
                // $horario_clase_grupal->fecha=$fecha_inicio;
                // $horario_clase_grupal->hora_inicio=$request->hora_inicio_acordeon;
                // $horario_clase_grupal->hora_final=$request->hora_final_acordeon;
                // $horario_clase_grupal->instructor_id=$request->instructor_acordeon_id;
                // $horario_clase_grupal->especialidad_id=$request->especialidad_acordeon_id;
                // $horario_clase_grupal->estudio_id=$request->estudio_id;
                // $horario_clase_grupal->clase_grupal_id=$request->id;

                // $horario_clase_grupal->save();
                
               


                $array = array(['instructor' => $request->instructor_acordeon_id , 'fecha_inicio' => $fecha_inicio, 'especialidad' => $request->especialidad_acordeon_id, 'estudio' => $request->estudio_id, 'hora_inicio' => $request->hora_inicio_acordeon, 'hora_final' => $request->hora_final_acordeon, 'color_etiqueta' => $request->color_etiqueta]);


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
                    'id'=>$contador
                );

                // $cart[$stringKey] = array(
                //     'instructor' => $instructor ,
                //     'dia_de_semana' => $dia_de_semana,
                //     'new_dia_de_semama'=>$dia_n,
                //     'especialidad' => $especialidad,
                //     'hora_inicio' => $request->hora_inicio_acordeon,
                //     'new_hora_inicio' => $new_hora_i,
                //     'hora_final' => $request->hora_final_acordeon,
                //     'new_hora_final' => $new_hora_f,
                //     'fecha'=> $fd->toDateString(),
                //     'id'=>$horario_clase_grupal->id
                // );

                // Session::put('horario', $cart);

                //Carbon::setTestNow();                                  

                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 200]);


            // }
        }
    }

   



    public function eliminar($id){

        // $horario=HorarioClaseGrupal::find($id);
        // $horario->delete();

        $arreglo = Session::get('horarios');
        unset($arreglo[$id]);
        Session::put('horarios', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han eliminado satisfactoriamente', 'status' => 'OK', 200]);

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

                    $horario_clase_grupal = new HorarioClaseGrupal();

                    $horario_clase_grupal->fecha=$horario['fecha_inicio'];
                    $horario_clase_grupal->hora_inicio=$horario['hora_inicio'];
                    $horario_clase_grupal->hora_final=$horario['hora_final'];
                    $horario_clase_grupal->instructor_id=$horario['instructor'];
                    $horario_clase_grupal->especialidad_id=$horario['especialidad'];
                    $horario_clase_grupal->estudio_id=$horario['estudio'];
                    $horario_clase_grupal->color_etiqueta=$horario['color_etiqueta'];
                    $horario_clase_grupal->clase_grupal_id=$request->id;

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

        $clase_grupal_join = DB::table('horario_clase_grupales')
            ->join('clases_grupales', 'horario_clase_grupales.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_especialidades', 'horario_clase_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_estudios', 'horario_clase_grupales.estudio_id', '=', 'config_estudios.id')
            ->join('instructores', 'horario_clase_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido','config_estudios.nombre as estudio_nombre', 'horario_clase_grupales.hora_inicio','horario_clase_grupales.hora_final', 'horario_clase_grupales.id' , 'horario_clase_grupales.fecha', 'clases_grupales.id as clase_grupal_id', 'horario_clase_grupales.color_etiqueta')
            ->where('horario_clase_grupales.id', '=', $id)
        ->first();

        if($clase_grupal_join){

            $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal_join->fecha);

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

            return view('agendar.multihorario.planilla')->with(['config_especialidades' => ConfigEspecialidades::all(), 'config_estudios' => ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'instructores' => Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'clasegrupal' => $clase_grupal_join,  'id' => $id, 'dias_de_semana' => DiasDeSemana::all(), 'dia_de_semana' => $dia]);

        }else{
           return redirect("agendar/clases-grupales"); 
        }

    }

    public function updateEspecialidad(Request $request){
        $clasegrupal = HorarioClaseGrupal::find($request->id);
        $clasegrupal->especialidad_id = $request->especialidad_id;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateDia(Request $request){
        
        $clasegrupal = HorarioClaseGrupal::find($request->id);

        $fecha_inicio = Carbon::createFromFormat('Y-m-d', $clasegrupal->fecha);
        $dia_de_semana = $fecha_inicio->dayOfWeek;

        if(intval($request->dia_de_semana_id) >= $dia_de_semana){
            $dias = intval($request->dia_de_semana_id) - intval($dia_de_semana);
            $fecha_inicio->addDays($dias)->toDateString();
        }else{
            $dias = intval($dia_de_semana) - intval($request->dia_de_semana_id);
            $fecha_inicio->addWeek();
            $fecha_inicio->subDays($dias)->toDateString();
            
        }

        $clasegrupal->fecha = $fecha_inicio;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateInstructor(Request $request){
        $clasegrupal = HorarioClaseGrupal::find($request->id);
        $clasegrupal->instructor_id = $request->instructor_id;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEstudio(Request $request){
        $clasegrupal = HorarioClaseGrupal::find($request->id);
        $clasegrupal->estudio_id = $request->estudio_id;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEtiqueta(Request $request){
        $clasegrupal = HorarioClaseGrupal::find($request->id);
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

        $clasegrupal = HorarioClaseGrupal::find($request->id);

        $hora_inicio = strtotime($request->hora_inicio);
        $hora_final = strtotime($request->hora_final);

        if($hora_inicio > $hora_final)
        {
            return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
        }

        $clasegrupal->hora_inicio = $request->hora_inicio;
        $clasegrupal->hora_final = $request->hora_final;

        if($clasegrupal->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

}
