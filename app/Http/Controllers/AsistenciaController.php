<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Taller;

use App\ClaseGrupal;

use App\InscripcionClaseGrupal;

use App\Asistencia;

use App\Instructor;

use App\AsistenciaInstructor;

use App\ConfigPagosInstructor;

use App\Alumno;

use App\HorarioClaseGrupal;

use Carbon\Carbon;

use DB;

use Validator;

use Illuminate\Support\Facades\Auth;

use PulkitJalan\GeoIP\GeoIP;

class AsistenciaController extends BaseController
{

    public function principal()
    {
        // $alumnos = Asistencia::where('academia_id','=', Auth::user()->academia_id)->get();

      if(Auth::user()->usuario_tipo == 1 || Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6)
      {
        $alumnos = DB::table('alumnos')
            ->join('asistencias', 'asistencias.alumno_id', '=', 'alumnos.id')
            ->join('clases_grupales', 'asistencias.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('academias', 'asistencias.academia_id', '=', 'academias.id')
            ->select('asistencias.fecha', 'asistencias.hora', 'config_clases_grupales.nombre as clase', 'alumnos.nombre', 'alumnos.apellido', 'asistencias.tipo', 'asistencias.tipo_id', 'asistencias.clase_grupal_id as clase_grupal_id')
            ->where('academias.id','=',Auth::user()->academia_id)
        ->get();

        $instructores = DB::table('asistencias_instructor')
            ->join('clases_grupales', 'asistencias_instructor.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('academias', 'asistencias_instructor.academia_id', '=', 'academias.id')
            ->join('instructores', 'asistencias_instructor.instructor_id', '=', 'instructores.id')
            ->select('asistencias_instructor.fecha', 'asistencias_instructor.hora', 'config_clases_grupales.nombre as clase', 'instructores.nombre as nombre_instructor', 'instructores.apellido as apellido_instructor', 'asistencias_instructor.hora_salida')
            ->where('academias.id','=',Auth::user()->academia_id)
        ->get();

        $array = array();

        foreach($alumnos as $asistencia){

          if($asistencia->tipo == 1)
          {
            $clasegrupal = ClaseGrupal::find($asistencia->clase_grupal_id);
            if($clasegrupal){
              $instructor = Instructor::find($clasegrupal->instructor_id);
            }
            
          }else{
            $clasegrupal = HorarioClaseGrupal::find($asistencia->tipo_id);
            if($clasegrupal){
              $instructor = Instructor::find($clasegrupal->instructor_id);
            }
          }

          if($clasegrupal)
          {
            $collection=collect($asistencia);     
            $asistencia_array = $collection->toArray();
                
            $asistencia_array['nombre_instructor']=$instructor->nombre;
            $asistencia_array['apellido_instructor']=$instructor->apellido;
            $array[$asistencia->id] = $asistencia_array;
          }
        }



        return view('inicio.asistencia')->with(['alumnos_asistencia' => $array, 'instructores_asistencia' => $instructores]);   
        }  

        if(Auth::user()->usuario_tipo == 2)
        {       

          $alumnos = DB::table('alumnos')
            ->join('asistencias', 'asistencias.alumno_id', '=', 'alumnos.id')
            ->join('clases_grupales', 'asistencias.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('academias', 'asistencias.academia_id', '=', 'academias.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('asistencias.fecha', 'asistencias.hora', 'config_clases_grupales.nombre as clase', 'instructores.nombre as nombre_instructor', 'instructores.apellido as apellido_instructor', 'alumnos.nombre', 'alumnos.apellido')
            ->where('alumnos.id','=',Auth::user()->usuario_id)
        ->get();

          return view('vista_alumno.asistencia')->with(['alumnos_asistencia' => $alumnos]); 

        }        
    }

    private function deuda($id){
        $alumnod = DB::table('alumnos')
            ->join('items_factura_proforma', 'items_factura_proforma.alumno_id', '=', 'alumnos.id')
            ->select('alumnos.id as id', 'items_factura_proforma.importe_neto', 'items_factura_proforma.fecha_vencimiento')
            ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
            ->where('items_factura_proforma.alumno_id', $id)
        ->get();

        if(count($alumnod)>0){
            $collection = collect($alumnod);
            $cuenta=$collection->sum('importe_neto');
        }else{
            $cuenta=0;
        }

        return $cuenta;

    }

    public function consulta_clase_grupales()
    {
      //$ClaseGrupal=ClaseGrupal::all();

      $claseGrupal= DB::table('clases_grupales')
            ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as nombre', 'config_clases_grupales.descripcion as descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido',  'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.fecha_inicio','clases_grupales.fecha_final', 'clases_grupales.color_etiqueta', 'clases_grupales.id')
            ->where('clases_grupales.deleted_at', '=', null)
            ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
      ->get();

      $horarios_clase_grupales= DB::table('horario_clase_grupales')
            ->join('config_especialidades', 'horario_clase_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_estudios', 'horario_clase_grupales.estudio_id', '=', 'config_estudios.id')
            ->join('instructores', 'horario_clase_grupales.instructor_id', '=', 'instructores.id')
            ->join('clases_grupales', 'horario_clase_grupales.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as nombre', 'config_clases_grupales.descripcion as descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido',  'config_estudios.nombre as estudio_nombre', 'horario_clase_grupales.hora_inicio','horario_clase_grupales.hora_final', 'horario_clase_grupales.fecha as fecha_inicio','clases_grupales.fecha_final', 'clases_grupales.color_etiqueta', 'clases_grupales.id', 'horario_clase_grupales.id as horario_id')
            ->where('horario_clase_grupales.deleted_at', '=', null)
            ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
        ->get();



     // dd($claseGrupal);

      $arrayClaseGrupal=array();

      $fechaActual = Carbon::now();
      $diaActual = $fechaActual->dayOfWeek;

      $collection = collect($claseGrupal);


      foreach ($claseGrupal as $grupal) {

        $fecha_start=explode('-',$grupal->fecha_inicio);
        $fecha_end=explode('-',$grupal->fecha_final);
        $id=$grupal->id;
        $nombre=$grupal->nombre;
        $descripcion=$grupal->descripcion;
        $hora_inicio=$grupal->hora_inicio;
        $hora_final=$grupal->hora_final;
        $etiqueta=$grupal->color_etiqueta;
        $instructor=$grupal->instructor_nombre . ' ' . $grupal->instructor_apellido;

        // $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);

        // $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0); 

        $fecha_inicio = Carbon::createFromFormat('Y-m-d', $grupal->fecha_inicio);
        $dia_de_semana = $fecha_inicio->dayOfWeek;

        if($diaActual==$dia_de_semana){      

          $arrayClaseGrupal[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$grupal->fecha_inicio,"fecha_final"=>$grupal->fecha_final, "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta, "instructor" => $instructor, 'tipo' => 1, 'tipo_id' => $id);

          }
        }

        foreach ($horarios_clase_grupales as $grupal) {

          $fecha_start=explode('-',$grupal->fecha_inicio);
          $fecha_end=explode('-',$grupal->fecha_final);
          $id=$grupal->id;
          $nombre=$grupal->nombre;
          $descripcion=$grupal->descripcion;
          $hora_inicio=$grupal->hora_inicio;
          $hora_final=$grupal->hora_final;
          $etiqueta=$grupal->color_etiqueta;
          $instructor=$grupal->instructor_nombre . ' ' . $grupal->instructor_apellido;


          $fecha_inicio = Carbon::createFromFormat('Y-m-d', $grupal->fecha_inicio);
          $dia_de_semana = $fecha_inicio->dayOfWeek;

          if($diaActual==$dia_de_semana){       

            $arrayClaseGrupal[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$grupal->fecha_inicio,"fecha_final"=>$grupal->fecha_final, "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta, "instructor" => $instructor, 'tipo' => 2, 'tipo_id' => $grupal->horario_id);

          }
        
      }

      //dd($arrayClaseGrupal);
      return response()->json(['status' => 'OK', 'clases_grupales'=>$arrayClaseGrupal, 200]);


    }

    public function consulta_clase_grupales_alumno($id_alumno)
    {
    	
        $clases_grupales= DB::table('clases_grupales')
            ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('config_estudios', 'clases_grupales.estudio_id', '=', 'config_estudios.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as nombre', 'config_clases_grupales.descripcion as descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido',  'config_estudios.nombre as estudio_nombre', 'clases_grupales.hora_inicio','clases_grupales.hora_final', 'clases_grupales.fecha_inicio','clases_grupales.fecha_final', 'clases_grupales.color_etiqueta', 'clases_grupales.id')
            ->where('clases_grupales.deleted_at', '=', null)
            ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
        ->get();

        $horarios_clase_grupales= DB::table('horario_clase_grupales')
            ->join('config_especialidades', 'horario_clase_grupales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_estudios', 'horario_clase_grupales.estudio_id', '=', 'config_estudios.id')
            ->join('instructores', 'horario_clase_grupales.instructor_id', '=', 'instructores.id')
            ->join('clases_grupales', 'horario_clase_grupales.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as nombre', 'config_clases_grupales.descripcion as descripcion', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido',  'config_estudios.nombre as estudio_nombre', 'horario_clase_grupales.hora_inicio','horario_clase_grupales.hora_final', 'horario_clase_grupales.fecha as fecha_inicio','clases_grupales.fecha_final', 'clases_grupales.color_etiqueta', 'clases_grupales.id', 'horario_clase_grupales.id as horario_id')
            ->where('horario_clase_grupales.deleted_at', '=', null)
            ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
        ->get();

         $inscripciones = DB::table('inscripcion_clase_grupal')
                ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
                ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                ->select('config_clases_grupales.nombre', 'clases_grupales.hora_inicio', 'clases_grupales.hora_final', 'clases_grupales.fecha_inicio', 'inscripcion_clase_grupal.id')
                ->where('inscripcion_clase_grupal.alumno_id', '=', $id_alumno)
                ->where('inscripcion_clase_grupal.deleted_at', '=', null)
          ->get();

      $array = array();

      foreach($inscripciones as $inscripcion){

      $fecha = Carbon::createFromFormat('Y-m-d', $inscripcion->fecha_inicio);
      
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

        $collection=collect($inscripcion);     
        $inscripcion_array = $collection->toArray();
            
        $inscripcion_array['dia']=$dia;
        $array[$inscripcion->id] = $inscripcion_array;
      }

     	$alumno=Alumno::all();
  
	    $arrayClases=array();

      $fechaActual = Carbon::now();
      $diaActual = $fechaActual->dayOfWeek;

      $collection = collect($clases_grupales);

     	foreach ($clases_grupales as $grupal) {

     		$fecha_start=explode('-',$grupal->fecha_inicio);
     		$fecha_end=explode('-',$grupal->fecha_final);
     		$id=$grupal->id;
     		$nombre=$grupal->nombre;
     		$descripcion=$grupal->descripcion;
     		$hora_inicio=$grupal->hora_inicio;
     		$hora_final=$grupal->hora_final;
     		$etiqueta=$grupal->color_etiqueta;
        $instructor=$grupal->instructor_nombre . ' ' . $grupal->instructor_apellido;


        $fecha_inicio = Carbon::createFromFormat('Y-m-d', $grupal->fecha_inicio);
        $dia_de_semana = $fecha_inicio->dayOfWeek;

        if($diaActual==$dia_de_semana){   		

     			$arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$grupal->fecha_inicio,"fecha_final"=>$grupal->fecha_final, "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta, "instructor" => $instructor, 'tipo' => 1, 'tipo_id' => $id);

     	  }
		    
		}

    foreach ($horarios_clase_grupales as $grupal) {

        $fecha_start=explode('-',$grupal->fecha_inicio);
        $fecha_end=explode('-',$grupal->fecha_final);
        $id=$grupal->id;
        $nombre=$grupal->nombre;
        $descripcion=$grupal->descripcion;
        $hora_inicio=$grupal->hora_inicio;
        $hora_final=$grupal->hora_final;
        $etiqueta=$grupal->color_etiqueta;
        $instructor=$grupal->instructor_nombre . ' ' . $grupal->instructor_apellido;


        $fecha_inicio = Carbon::createFromFormat('Y-m-d', $grupal->fecha_inicio);
        $dia_de_semana = $fecha_inicio->dayOfWeek;

        if($diaActual==$dia_de_semana){       

          $arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$grupal->fecha_inicio,"fecha_final"=>$grupal->fecha_final, "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta, "instructor" => $instructor, 'tipo' => 2, 'tipo_id' => $grupal->horario_id);

        }
        
    }

    $deuda=$this->deuda($id_alumno);

		return response()->json(['status' => 'OK', 'clases_grupales'=>$arrayClases, 'deuda'=>$deuda, 'inscripciones' => $array, 200]);



    	//return ['talleres' => $arrayTalleres];
    	
    }



    public function store(Request $request)
    {


        $rules = [

        'asistencia_clase_grupal_id' => 'required',
        'asistencia_id_alumno' => 'required',
        ];

        $messages = [

            'asistencia_clase_grupal_id.required' => 'Ups! La Clase Grupal es requerida',
            'asistencia_id_alumno.required' => 'Ups! El Alumno es requerido',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            
            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);           

        }else{

            $clase=$request->asistencia_clase_grupal_id;
            $id_alumno=$request->asistencia_id_alumno;

            $ClasesAsociadas=InscripcionClaseGrupal::where('alumno_id',$id_alumno)->get();

            //dd($ClasesAsociadas);
            //dd($clase);
            $clase_id=explode('-', $clase);

            if(count($ClasesAsociadas)>0){
              $estatu="no_asociado";
              foreach ($ClasesAsociadas as $clasegrupal) {
                if($clasegrupal->clase_grupal_id==$clase_id[0]){
                  // if($clasegrupal->estatu=="inscrito" && $clasegrupal->clase_grupal_id==$clase_id[0]){
                    $estatu="inscrito";
                }
                // elseif($clasegrupal->estatu=="registrado" && $clasegrupal->clase_grupal_id==$clase_id[0]){
                //     $estatu="registrado";
                // }
                //dd($clasegrupal->estatu ."-".  $clasegrupal->clase_grupal_id."-".$estatu);
              }


              //dd($estatu);
            }else{
                return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR_ASOCIADO'],422);
            }
              
            if($estatu=="no_asociado"){
              return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR_ASOCIADO'],422);
            }elseif($estatu=="registrado"){
              return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR_REGISTRADO'],422);
            }elseif($estatu=="inscrito") {
              $actual = Carbon::now();
              $geoip = new GeoIP();
              $geoip->setIp($request->ip());

              // $actual->tz = 'America/Caracas';
              // $actual->tz = $request->timezone;
              $actual->tz = $geoip->getTimezone();

              
              $fecha_actual=$actual->toDateString();
              $hora_actual=$actual->toTimeString();

              $asistencia = new Asistencia;
              $asistencia->fecha=$fecha_actual;
              $asistencia->hora=$hora_actual;
              $asistencia->clase_grupal_id=$clase;
              $asistencia->alumno_id=$id_alumno;
              $asistencia->academia_id=Auth::user()->academia_id;
              $asistencia->tipo = $clase_id[2];
              $asistencia->tipo_id = $clase_id[3];

              $asistencia->save();

              return response()->json(['mensaje' => '¡Excelente! La Asistencia se han guardado satisfactoriamente','status' => 'OK', 200]);
            }
            /*
            $actual = Carbon::now();
            $actual->tz = 'America/Caracas';
            
            $fecha_actual=$actual->toDateString();
            $hora_actual=$actual->toTimeString();

            $asistencia = new Asistencia;
            $asistencia->fecha=$fecha_actual;
            $asistencia->hora=$hora_actual;
            $asistencia->clase_grupal_id=$clase;
            $asistencia->alumno_id=$id_alumno;

            $asistencia->save();
            */

            

        }

    }

    public function storePermitir(Request $request)
    {

        $rules = [

        'asistencia_clase_grupal_id' => 'required',
        'asistencia_id_alumno' => 'required',

        ];

        $messages = [

            'asistencia_clase_grupal_id.required' => 'Ups! La Clase Grupal es requerida',
            'asistencia_id.required' => 'Ups! El alumno es requerido',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            
            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);           

        }else{

            $clase=$request->asistencia_clase_grupal_id;
            $alumno_id=$request->asistencia_id_alumno;

            $clase_id=explode('-', $clase);

                $actual = Carbon::now();
                $geoip = new GeoIP();
                $geoip->setIp($request->ip());

                // $actual->tz = 'America/Caracas';
                // $actual->tz = $request->timezone;
                $actual->tz = $geoip->getTimezone();
                
                $fecha_actual=$actual->toDateString();
                $hora_actual=$actual->toTimeString();

                $asistencia = new Asistencia;
                $asistencia->fecha=$fecha_actual;
                $asistencia->hora=$hora_actual;
                $asistencia->clase_grupal_id=$clase_id[0];
                $asistencia->alumno_id=$alumno_id;
                $asistencia->academia_id=Auth::user()->academia_id;
                $asistencia->tipo = $clase_id[2];
                $asistencia->tipo_id = $clase_id[3];

                $asistencia->save();

                return response()->json(['mensaje' => '¡Excelente! La Asistencia se ha guardado satisfactoriamente','status' => 'OK', 200]);
              
       }

    }


    public function storeInstructor(Request $request)
    {


        $rules = [

        'asistencia_clase_grupal_id_instructor' => 'required',
        'asistencia_id_instructor' => 'required',
        ];

        $messages = [

            'asistencia_clase_grupal_id_instructor.required' => 'Ups! La Clase Grupal es requerida',
            'asistencia_id_instructor.required' => 'Ups! El Instructor es requerido',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            
            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);           

        }else{

            $clase=$request->asistencia_clase_grupal_id_instructor;
            $id_instructor=$request->asistencia_id_instructor;

            $clase_id=explode('-', $clase);

            if($clase_id[2] == '2'){
              $ClasesAsociadas=HorarioClaseGrupal::where('instructor_id',$id_instructor)
              ->where('id',$clase_id[3])
              ->get();
            }else{
              $ClasesAsociadas=ClaseGrupal::where('instructor_id',$id_instructor)
              ->where('id',$clase_id[0])
              ->get();
            }
            

            // dd(count($id_instructor));

            
            $estatu="no_asociado";
            if(count($ClasesAsociadas)>0){              
              $estatu="asociado";              
            }
              
             if($estatu=="asociado") {

                $check = AsistenciaInstructor::where('instructor_id', $id_instructor)->where('hora_salida', '00:00:00')->where('clase_grupal_id' , '=', $clase_id[0])->first();

                  $actual = Carbon::now();
                  // $actual->tz = 'America/Caracas';
                  $geoip = new GeoIP();
                  $geoip->setIp($request->ip());

                  // $actual->tz = 'America/Caracas';
                  // $actual->tz = $request->timezone;
                  $actual->tz = $geoip->getTimezone();
                  
                  $fecha_actual=$actual->toDateString();
                  $hora_actual=$actual->toTimeString();

                  if($check)
                  {
                    $check->hora_salida = $hora_actual;
                    $check->save();
                  }
                  else{

                  $asistencia = new AsistenciaInstructor;
                  $asistencia->fecha=$fecha_actual;
                  $asistencia->hora=$hora_actual;
                  $asistencia->clase_grupal_id=$clase_id[0];
                  $asistencia->instructor_id=$id_instructor;
                  $asistencia->academia_id=Auth::user()->academia_id;

                  $config_pago = ConfigPagosInstructor::where('clase_grupal_id', $clase_id[0])->where('instructor_id', $id_instructor)->first();

                  if($config_pago){
                    if($config_pago->tipo == 1)
                    {
                      $asistencia->monto = $config_pago->monto;
                    }
                  }

                  $asistencia->save();

                }


                return response()->json(['mensaje' => '¡Excelente! La Asistencia se ha guardado satisfactoriamente','status' => 'OK', 200]);
              }elseif($estatu="no_asociado"){
                return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR_ASOCIADO'],422);
              }
       }

    }

    public function storeInstructorPermitir(Request $request)
    {
        $rules = [

        'asistencia_clase_grupal_id_instructor' => 'required',
        'asistencia_id_instructor' => 'required',
        ];

        $messages = [

            'asistencia_clase_grupal_id_instructor.required' => 'Ups! La Clase Grupal es requerida',
            'asistencia_id_instructor.required' => 'Ups! El Instructor es requerido',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            
            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);           

        }else{

            $clase=$request->asistencia_clase_grupal_id_instructor;
            $id_instructor=$request->asistencia_id_instructor;

            $clase_id=explode('-', $clase);

                $actual = Carbon::now();
                // $actual->tz = 'America/Caracas';
                $geoip = new GeoIP();
                $geoip->setIp($request->ip());

                // $actual->tz = 'America/Caracas';
                // $actual->tz = $request->timezone;
                $actual->tz = $geoip->getTimezone();
                
                $fecha_actual=$actual->toDateString();
                $hora_actual=$actual->toTimeString();

                $check = AsistenciaInstructor::where('instructor_id', $id_instructor)->where('hora_salida', '00:00:00')->where('clase_grupal_id' , '=', $clase_id[0])->first();

                if($check)
                {
                  $check->hora_salida = $hora_actual;
                  $check->save();
                }
                else{

                  $asistencia = new AsistenciaInstructor;
                  $asistencia->fecha=$fecha_actual;
                  $asistencia->hora=$hora_actual;
                  $asistencia->clase_grupal_id=$clase_id[0];
                  $asistencia->instructor_id=$id_instructor;
                  $asistencia->academia_id=Auth::user()->academia_id;

                  $config_pago = ConfigPagosInstructor::where('clase_grupal_id', $clase_id[0])->where('instructor_id', $id_instructor)->first();

                  if($config_pago){
                    if($config_pago->tipo == 1)
                    {
                      $asistencia->monto = $config_pago->monto;
                    }
                  }

                  $asistencia->save();

                }

                return response()->json(['mensaje' => '¡Excelente! La Asistencia se ha guardado satisfactoriamente','status' => 'OK', 200]);
              
       }

    }

}