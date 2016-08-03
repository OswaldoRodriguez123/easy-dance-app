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

class MultihorarioController extends Controller
{
    public function principal($id){
    	// $clasegrupal = ClaseGrupal::find($id);
    	Session::forget('horario');

        $clasegrupal = DB::table('config_clases_grupales')
                ->join('clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('config_clases_grupales.*', 'clases_grupales.fecha_inicio_preferencial', 'clases_grupales.fecha_inicio')
                ->where('clases_grupales.id', '=', $id)
        ->first();

        $dias_de_semana = DiasDeSemana::all();
        $config_especialidades = ConfigEspecialidades::all();
        $config_estudios = ConfigEstudios::where('academia_id', '=' ,  Auth::user()->academia_id)->get();        
        $instructores = Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

        return view(
        	'agendar.clase_grupal.multihorario', 
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
            'dia_de_semana_id' => 'required',
            'hora_inicio_acordeon' => 'required',
            'hora_final_acordeon' => 'required',
        ];

        $messages = [

            'instructor_acordeon_id.required' => 'Ups! El Instructor es requerido',
            'dia_de_semana_id.required' => 'Ups! El Dia es requerido',
            'especialidad_acordeon_id.required' => 'Ups! La Especialidad es requerida',
            'hora_inicio_acordeon.required' => 'Ups! La hora de inicio es requerida',
            'hora_final_acordeon.required' => 'Ups! La hora final es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }else{
            $find = Instructor::find($request->instructor_acordeon_id);
            $instructor = $find->nombre . " " . $find->apellido;

            $find = DiasDeSemana::find($request->dia_de_semana_id);
            $dia_de_semana = $find->nombre;

            $find = ConfigEspecialidades::find($request->especialidad_acordeon_id);
            $especialidad = $find->nombre;

            $fecha_clasegrupal=ClaseGrupal::find($request->id);
            $fecha_clasegrupal_inicio=$fecha_clasegrupal->fecha_inicio;
            $fecha_clasegrupal_final=$fecha_clasegrupal->fecha_final;


            $cart = array();
            if (Session::has('horario')) {
                $cart = Session::get('horario');
                $cart1 = Session::get('horario');
            }
            $stringKey = str_random(20);
            
            $hora_inicio=$request->hora_inicio_acordeon;
            $hora_final=$request->hora_final_acordeon;
            $new_hora_i=$hora_inicio.':'.'00';
            $new_hora_f=$hora_final.':'.'00';

            $dia="";

            if($dia_de_semana=="Domingo"){
                $dia="6";
                $dia_n="SUNDAY";
            }elseif($dia_de_semana=="Lunes"){
                $dia="0";
                $dia_n="MONDAY";
            }elseif($dia_de_semana=="Martes"){
                $dia="1";
                $dia_n="TUESDAY";
            }elseif($dia_de_semana=="Míercoles"){
                $dia="2";
                $dia_n="WEDNESDAY";
            }elseif($dia_de_semana=="Jueves"){
                $dia="3";
                $dia_n="THURSDAY";
            }elseif($dia_de_semana=="Viernes"){
                $dia="4";
                $dia_n="FRIDAY";
            }elseif($dia_de_semana=="Sábado"){
                $dia="5";
                $dia_n="SATURDAY";
            }


            $fc=explode('-',$fecha_clasegrupal_inicio);
            $fecha_curso=Carbon::create($fc[0], $fc[1], $fc[2], 00, 00, 00);
            $dia_curso = $fecha_curso->format('L');


            Carbon::setTestNow($fecha_curso); 

            $fd=new Carbon('this '.$dia_n); 

            Carbon::setTestNow();

            if(count($cart)>0){
                foreach ($cart as $multH) {

                    $fecha_new=explode('-',$fd->toDateString());

                    $hora_fist_new=explode(':',$new_hora_i);

                    $hora_second_new=explode(':',$new_hora_f);

                    //---------------------------------------------

                    $fecha_fist=explode('-',$multH['fecha']);

                    $hora_fist=explode(':',$multH['new_hora_inicio']);

                    $hora_second=explode(':',$multH['new_hora_final']);

                    $first = Carbon::create($fecha_fist[0], $fecha_fist[1], $fecha_fist[2],$hora_fist[0],$hora_fist[1],$hora_fist[2]);
                    //dd('a');
                    $second = Carbon::create($fecha_fist[0], $fecha_fist[1], $fecha_fist[2],$hora_second[0],$hora_second[1],$hora_second[2]);

                    
                    $first_inv = Carbon::create($fecha_new[0], $fecha_new[1], $fecha_new[2],$hora_fist_new[0],$hora_fist_new[1],$hora_fist_new[2]);
                    //dd('aa');
                    $second_inv = Carbon::create($fecha_new[0], $fecha_new[1], $fecha_new[2],$hora_second_new[0],$hora_second_new[1],$hora_second_new[2]);
                    

                    $comparacion_inicio=Carbon::create($fecha_new[0], $fecha_new[1], $fecha_new[2],$hora_fist_new[0],$hora_fist_new[1],$hora_fist_new[2])->between($first, $second);

                    $comparacion_final=Carbon::create($fecha_new[0], $fecha_new[1], $fecha_new[2],$hora_second_new[0],$hora_second_new[1],$hora_second_new[2])->between($first, $second);
                    
                    $comparacion_inicio_inv=Carbon::create($fecha_fist[0], $fecha_fist[1], $fecha_fist[2],$hora_fist[0],$hora_fist[1],$hora_fist[2])->between($first_inv, $second_inv);

                    $comparacion_final_inv=Carbon::create($fecha_fist[0], $fecha_fist[1], $fecha_fist[2],$hora_second[0],$hora_second[1],$hora_second[2])->between($first_inv, $second_inv);

                    if($comparacion_inicio){
                        return response()->json(['mensaje' => '¡choque hora inicio', 'status' => 'DUPLICADO', 'h'=>Session::get('horario'), 'cart'=>$cart, 'id' => $stringKey, 200]);
                        //dd("choque hora inicio");
                    }elseif($comparacion_final){
                        return response()->json(['mensaje' => '¡choque hora final', 'status' => 'DUPLICADO', 'h'=>Session::get('horario'), 'cart'=>$cart, 'id' => $stringKey, 200]);
                        //dd("choque hora final");
                    }elseif($comparacion_inicio_inv){
                        return response()->json(['mensaje' => '¡choque hora inicio_inv', 'status' => 'DUPLICADO', 'h'=>Session::get('horario'), 'cart'=>$cart, 'id' => $stringKey, 200]);
                        //dd("choque hora inicio_inv");
                    }elseif($comparacion_final_inv){
                        return response()->json(['mensaje' => '¡choque hora final_inv', 'status' => 'DUPLICADO', 'h'=>Session::get('horario'), 'cart'=>$cart, 'id' => $stringKey, 200]);
                        //dd("choque hora final_inv");
                    }
                

                }

                $horario_clase_grupal = new HorarioClaseGrupal();
                $horario_clase_grupal->fecha=$fd->toDateString();
                $horario_clase_grupal->hora_inicio=$new_hora_i;
                $horario_clase_grupal->hora_final=$new_hora_f;
                $horario_clase_grupal->instructor_id=$request->instructor_acordeon_id;
                $horario_clase_grupal->especialidad_id=$request->especialidad_acordeon_id;
                $horario_clase_grupal->clase_grupal_id=$request->id;

                $horario_clase_grupal->save();

                $array=array(
                    'instructor' => $instructor , 
                    'dia_de_semana' => $dia_de_semana,
                    'new_dia_de_semama'=>$dia_n, 
                    'especialidad' => $especialidad,
                    'hora_inicio' => $request->hora_inicio_acordeon,
                    'new_hora_inicio' => $new_hora_i,
                    'hora_final' => $request->hora_final_acordeon,
                    'new_hora_final' => $new_hora_f,
                    'fecha'=> $fd->toDateString(),
                    'id'=>$horario_clase_grupal->id
                );

                $cart[$stringKey] = array(
                    'instructor' => $instructor ,
                    'dia_de_semana' => $dia_de_semana,
                    'new_dia_de_semama'=>$dia_n,
                    'especialidad' => $especialidad,
                    'hora_inicio' => $request->hora_inicio_acordeon,
                    'new_hora_inicio' => $new_hora_i,
                    'hora_final' => $request->hora_final_acordeon,
                    'new_hora_final' => $new_hora_f,
                    'fecha'=> $fd->toDateString(),
                    'id'=>$horario_clase_grupal->id

                );

                Session::put('horario', $cart);

                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'h'=>Session::get('horario'), 'cart'=>$cart, 'id' => $stringKey, 200]);
            }else{

                $horario_clase_grupal = new HorarioClaseGrupal();
                $horario_clase_grupal->fecha=$fd->toDateString();
                $horario_clase_grupal->hora_inicio=$new_hora_i;
                $horario_clase_grupal->hora_final=$new_hora_f;
                $horario_clase_grupal->instructor_id=$request->instructor_acordeon_id;
                $horario_clase_grupal->especialidad_id=$request->especialidad_acordeon_id;
                $horario_clase_grupal->clase_grupal_id=$request->id;

                $horario_clase_grupal->save();

                $array=array(
                    'instructor' => $instructor , 
                    'dia_de_semana' => $dia_de_semana,
                    'new_dia_de_semama'=>$dia_n, 
                    'especialidad' => $especialidad,
                    'hora_inicio' => $request->hora_inicio_acordeon,
                    'new_hora_inicio' => $new_hora_i,
                    'hora_final' => $request->hora_final_acordeon,
                    'new_hora_final' => $new_hora_f,
                    'fecha'=> $fd->toDateString(),
                    'id'=>$horario_clase_grupal->id
                );

                $cart[$stringKey] = array(
                    'instructor' => $instructor ,
                    'dia_de_semana' => $dia_de_semana,
                    'new_dia_de_semama'=>$dia_n,
                    'especialidad' => $especialidad,
                    'hora_inicio' => $request->hora_inicio_acordeon,
                    'new_hora_inicio' => $new_hora_i,
                    'hora_final' => $request->hora_final_acordeon,
                    'new_hora_final' => $new_hora_f,
                    'fecha'=> $fd->toDateString(),
                    'id'=>$horario_clase_grupal->id
                );

                Session::put('horario', $cart);

                //Carbon::setTestNow();                                  

                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'h'=>Session::get('horario'), 'cart'=>$cart, 'id' => $stringKey, 200]);


            }




        }

    }

    public function agregarhorario(Request $request){
        
    $rules = [

        'instructor_acordeon_id' => 'required',
        'especialidad_acordeon_id' => 'required',
        'dia_de_semana_id' => 'required',
        'hora_inicio_acordeon' => 'required',
        'hora_final_acordeon' => 'required',
    ];

    $messages = [

        'instructor_acordeon_id.required' => 'Ups! El Instructor es requerido',
        'dia_de_semana_id.required' => 'Ups! El Dia es requerido',
        'especialidad_acordeon_id.required' => 'Ups! La Especialidad es requerida',
        'hora_inicio_acordeon.required' => 'Ups! La hora de inicio es requerida',
        'hora_final_acordeon.required' => 'Ups! La hora final es requerida',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }else{


        $find = Instructor::find($request->instructor_acordeon_id);
        $instructor = $find->nombre . " " . $find->apellido;

        $find = DiasDeSemana::find($request->dia_de_semana_id);
        $dia_de_semana = $find->nombre;

        $find = ConfigEspecialidades::find($request->especialidad_acordeon_id);
        $especialidad = $find->nombre;

        $fecha_clasegrupal=ClaseGrupal::find($request->id);
        $fecha_clasegrupal_inicio=$fecha_clasegrupal->fecha_inicio;
        $fecha_clasegrupal_final=$fecha_clasegrupal->fecha_final;


        $cart = array();
        if (Session::has('horario')) {
            $cart = Session::get('horario');
            $cart1 = Session::get('horario');
        }
        $stringKey = str_random(20);

        $hora_inicio=$request->hora_inicio_acordeon;
        $hora_final=$request->hora_final_acordeon;

        //dd($request->all());

        $new_hora_i=$hora_inicio.':'.'00';
        $new_hora_f=$hora_final.':'.'00';

        /*if($hora_inicio[1]=="PM"){
            $hora_i=explode(':',$hora_inicio[0]);
            if($hora_i[0]==12){
                $new_hora_i="".$hora_inicio[0].':'.'00';
            }else{                
                $suma=$hora_i[0]+12;
                $new_hora_i="".$suma.':'.$hora_i[1].':'.'00';
            }
        }else{
            $new_hora_i="".$hora_inicio[0].':'.'00';
        }*/

        //dd($new_hora_i);

        /*if($hora_final[1]=="PM"){
            $hora_f=explode(':',$hora_final[0]);
            if($hora_f[0]==12){
                $new_hora_f="".$hora_final[0].':'.'00';
            }else{                
                $suma=$hora_f[0]+12;
                $new_hora_f="".$suma.':'.$hora_i[1].':'.'00';
            }            
        }else{
            $new_hora_f="".$hora_final[0].':'.'00';
        }*/

        //dd($new_hora_f);


        /*foreach ($cart as $multH) {
            //$time=Carbon::createFromFormat('H:m:s', $multH['new_hora_inicio'])->toDateTimeString(); 
            //dd($multH['new_hora_inicio']);
            $time_inicio=explode(":", $multH['new_hora_inicio']);
            $time=Carbon::createFromTime($time_inicio[0], $time_inicio[1], 0);

            dd($time);
        }*/

        $dia="";


        if($dia_de_semana=="Domingo"){
            $dia="6";
            $dia_n="SUNDAY";
        }elseif($dia_de_semana=="Lunes"){
            $dia="0";
            $dia_n="MONDAY";
        }elseif($dia_de_semana=="Martes"){
            $dia="1";
            $dia_n="TUESDAY";
        }elseif($dia_de_semana=="Míercoles"){
            $dia="2";
            $dia_n="WEDNESDAY";
        }elseif($dia_de_semana=="Jueves"){
            $dia="3";
            $dia_n="THURSDAY";
        }elseif($dia_de_semana=="Viernes"){
            $dia="4";
            $dia_n="FRIDAY";
        }elseif($dia_de_semana=="Sábado"){
            $dia="5";
            $dia_n="SATURDAY";
        }




        //$fc=explode('/',$request->fecha);

        //dd($fc);

        //$anio=explode(' - ',$fc[2]);

        $fc=explode('-',$fecha_clasegrupal_inicio);

        $fecha_curso=Carbon::create($fc[0], $fc[1], $fc[2], 00, 00, 00);

        $dia_curso = $fecha_curso->format('L'); 

        



        //dd($dia." - ".$fecha_curso->format('l'));

        //if($dia==$dia_curso){
            //return response()->json(['errores'=>['dia_de_semana_id'=>[0=>'El dia de la semana ya a sido elegido']], 'status' => 'ERROR'],422);
        //}

        //dd($dia);

        $knownDate = Carbon::create($fc[0], $fc[1], $fc[2], 12); 
        
        //$knownDate = Carbon::create(2016, 06, 13, 12);
        //dd(Session::get('horario'));
        if(count($cart)>0){
        foreach ($cart as $multH) {

            //dd($anio[0].'-'.$fc[1].'-'.$fc[0].' '.$new_hora_f);

            $fparse_ci=Carbon::parse($fc[0].'-'.$fc[1].'-'.$fc[2].' '.$new_hora_i);

            $fparse_cf=Carbon::parse($fc[0].'-'.$fc[1].'-'.$fc[2].' '.$new_hora_f);

            //dd('a');



            /*if($dia==$dia_curso){

                
            }else{ */
                Carbon::setTestNow($knownDate); 


                
                //if($dia_curso<$dia){    


                $fd=new Carbon('this '.$dia_n); 




                $fparse_cdi=Carbon::parse($fd->toDateString().' '.$new_hora_i);

                $fparse_cdf=Carbon::parse($fd->toDateString().' '.$new_hora_f);

                

                $fda=new Carbon('this '.$multH['new_dia_de_semama']); 

                $fparse_ciMultH=Carbon::parse($fda->toDateString().' '.$multH['new_hora_inicio']);

                $fparse_cfMultH=Carbon::parse($fda->toDateString().' '.$multH['new_hora_final']);
                
                

                if($fparse_cdi->timestamp>$fparse_ciMultH->timestamp && $fparse_cdi->timestamp<$fparse_cfMultH->timestamp){
                    //dd('duplicado1');
                }elseif($fparse_cdf->timestamp>$fparse_cfMultH->timestamp && $fparse_cdf->timestamp<$fparse_cfMultH->timestamp){
                    //dd('duplicado2');
                }

                //dd($fparse_cdi->toDateString());

                $fecha_new=explode('-',$fd->toDateString());

                $hora_fist_new=explode(':',$new_hora_i);

                $hora_second_new=explode(':',$new_hora_f);

                //dd($hora_second_new);


                $fecha_fist=explode('-',$fda->toDateString());

                $hora_fist=explode(':',$multH['new_hora_inicio']);

                $hora_second=explode(':',$multH['new_hora_final']);

                //dd('a');

                //dd($fecha_fist[0].'-'.$fecha_fist[1].'-'.$fecha_fist[2].' '.$hora_fist[0].':'.$hora_fist[1].':'.$hora_fist[2]);

                $first = Carbon::create($fecha_fist[0], $fecha_fist[1], $fecha_fist[2],$hora_fist[0],$hora_fist[1],$hora_fist[2]);
                //dd('a');
                $second = Carbon::create($fecha_fist[0], $fecha_fist[1], $fecha_fist[2],$hora_second[0],$hora_second[1],$hora_second[2]);

                
                $first_inv = Carbon::create($fecha_new[0], $fecha_new[1], $fecha_new[2],$hora_fist_new[0],$hora_fist_new[1],$hora_fist_new[2]);
                //dd('aa');
                $second_inv = Carbon::create($fecha_new[0], $fecha_new[1], $fecha_new[2],$hora_second_new[0],$hora_second_new[1],$hora_second_new[2]);
                

                $comparacion_inicio=Carbon::create($fecha_new[0], $fecha_new[1], $fecha_new[2],$hora_fist_new[0],$hora_fist_new[1],$hora_fist_new[2])->between($first, $second);

                $comparacion_final=Carbon::create($fecha_new[0], $fecha_new[1], $fecha_new[2],$hora_second_new[0],$hora_second_new[1],$hora_second_new[2])->between($first, $second);
                
                $comparacion_inicio_inv=Carbon::create($fecha_fist[0], $fecha_fist[1], $fecha_fist[2],$hora_fist[0],$hora_fist[1],$hora_fist[2])->between($first_inv, $second_inv);

                $comparacion_final_inv=Carbon::create($fecha_fist[0], $fecha_fist[1], $fecha_fist[2],$hora_second[0],$hora_second[1],$hora_second[2])->between($first_inv, $second_inv);

                if($comparacion_inicio){
                    return response()->json(['mensaje' => '¡choque hora inicio', 'status' => 'DUPLICADO', 'h'=>Session::get('horario'), 'cart'=>$cart, 'id' => $stringKey, 200]);
                    //dd("choque hora inicio");
                }elseif($comparacion_final){
                    return response()->json(['mensaje' => '¡choque hora final', 'status' => 'DUPLICADO', 'h'=>Session::get('horario'), 'cart'=>$cart, 'id' => $stringKey, 200]);
                    //dd("choque hora final");
                }elseif($comparacion_inicio_inv){
                    return response()->json(['mensaje' => '¡choque hora inicio_inv', 'status' => 'DUPLICADO', 'h'=>Session::get('horario'), 'cart'=>$cart, 'id' => $stringKey, 200]);
                    //dd("choque hora inicio_inv");
                }elseif($comparacion_final_inv){
                    return response()->json(['mensaje' => '¡choque hora final_inv', 'status' => 'DUPLICADO', 'h'=>Session::get('horario'), 'cart'=>$cart, 'id' => $stringKey, 200]);
                    //dd("choque hora final_inv");
                }
                

                // return bool(true)

                //dd($fparse_cdi->timestamp.' - '.$fparse_cdf->timestamp.' fecha de comienzo '.$fparse_ciMultH->timestamp.' - '.$fparse_cfMultH->timestamp);
                


                //}else{
                    //dd( new Carbon('this'.$dia_n)); 
                //}

            
            }  
        }       



        $array=array('instructor' => $instructor , 'dia_de_semana' => $dia_de_semana, 'new_dia_de_semama'=>$dia_n, 'especialidad' => $especialidad, 'hora_inicio' => $request->hora_inicio_acordeon, 'new_hora_inicio' => $new_hora_i, 'hora_final' => $request->hora_final_acordeon, 'new_hora_final' => $new_hora_f);

        $cart[$stringKey] = array('instructor' => $instructor , 'dia_de_semana' => $dia_de_semana, 'new_dia_de_semama'=>$dia_n, 'especialidad' => $especialidad, 'hora_inicio' => $request->hora_inicio_acordeon, 'new_hora_inicio' => $new_hora_i, 'hora_final' => $request->hora_final_acordeon, 'new_hora_final' => $new_hora_f);
        Session::put('horario', $cart);
        
        //Session::forget('horario');
        

        //if(Session::get('horario')){
          /*$arrayH=array();
          $arrayH=Session::get('horario');
          $array = ['instructor' => $instructor , 'dia_de_semana' => $dia_de_semana, 'especialidad' => $especialidad, 'hora_inicio' => $request->hora_inicio_acordeon, 'hora_final' => $request->hora_final_acordeon];
          
          Session::push('horario', $array);*/
        //}else{
        //     $array = array(['instructor' => $instructor , 'dia_de_semana' => $dia_de_semana, 'especialidad' => $especialidad, 'hora_inicio' => $request->hora_inicio_acordeon, 'hora_final' => $request->hora_final_acordeon]);
        //    Session::put('horario', $array);

        //}


        //dd(Session::get('horario'));

        //Session::push('horario', $array);

        //dd(Session::get('horario'));

        //$contador = count(Session::get('horario'));
        //$contador = $contador - 1;

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'h'=>Session::get('horario'), 'cart'=>$cart, 'id' => $stringKey, 200]);

    }
   }



    public function eliminar(Request $request,  $id){

        $arreglo = array();
        if (Session::has('horario')) {
            $arreglo = Session::get('horario');
        }
        $id_table=$arreglo[$id]['id'];
        $horario=HorarioClaseGrupal::find($id_table);
        $horario->delete();
        unset($arreglo[$id]);

        //Session::forget('horario');
        Session::put('horario', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han eliminado satisfactoriamente', 'status' => 'OK', 'h'=>Session::get('horario'), 200]);

    }


    public function eliminarhorario(Request $request,  $id){

        $arreglo = array();
        if (Session::has('horario')) {
            $arreglo = Session::get('horario');
        }
        unset($arreglo[$id]);

        //Session::forget('horario');
        Session::put('horario', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han eliminado satisfactoriamente', 'status' => 'OK', 'h'=>Session::get('horario'), 200]);

    }

}
