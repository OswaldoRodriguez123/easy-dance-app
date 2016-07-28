<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Taller;

use DB;

use Carbon\Carbon;

use Redirect;

use Illuminate\Support\Facades\Auth;

class AgendarController extends BaseController
{

    
    public function index()
    {
        $arrayTalleres=array();
        $arrayClases=array();
        $arrayClasespersonalizadas=array();
        $arrayFiestas=array();

        if(Auth::user()->usuario_tipo == 1 || Auth::user()->usuario_tipo == 5)
        {

        	$talleres=Taller::where('academia_id', '=' ,  Auth::user()->academia_id)->get();
        	foreach ($talleres as $taller) {
        		$fecha_start=explode('-',$taller['fecha_inicio']);
        		$fecha_end=explode('-',$taller['fecha_final']);
        		$id=$taller['id'];
        		$nombre=$taller['nombre'];
        		$descripcion=$taller['descripcion'];
        		$hora_inicio=$taller['hora_inicio'];
        		$hora_final=$taller['hora_final'];
        		$etiqueta=$taller['color_etiqueta'];

        		$dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);

        		$df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

        		$arrayTalleres[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/talleres/operaciones/".$id);

    			$c=0;

    			
    			while($dt->timestamp<$df->timestamp){
    				$fecha="";
    				$fecha=$dt->addWeek()->toDateString();
    				$arrayTalleres[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/talleres/operaciones/".$id);
    				$c++;
    			}

    		}

    		// $clases_grupales=ClaseGrupal::where('academia_id', '=' ,  Auth::user()->academia_id)->get();


    		$clasegrupal = DB::table('config_clases_grupales')
                    ->join('clases_grupales', 'config_clases_grupales.id', '=', 'clases_grupales.clase_grupal_id')
                    ->select('clases_grupales.*', 'config_clases_grupales.nombre', 'config_clases_grupales.descripcion')
                    ->where('clases_grupales.academia_id', '=' ,  Auth::user()->academia_id)
                    ->where('clases_grupales.deleted_at', '=', null)
            ->get();

        	foreach ($clasegrupal as $clase) {
        		$fecha_start=explode('-',$clase->fecha_inicio);
        		$fecha_end=explode('-',$clase->fecha_final);
        		$id=$clase->id;
        		$nombre=$clase->nombre;
        		$descripcion=$clase->descripcion;
        		$hora_inicio=$clase->hora_inicio;
        		$hora_final=$clase->hora_final;
        		$etiqueta=$clase->color_etiqueta;

        		$dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);

        		$df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

        		$arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-grupales/operaciones/".$id);

    			$c=0;

    			
    			while($dt->timestamp<$df->timestamp){
    				$fecha="";
    				$fecha=$dt->addWeek()->toDateString();
    				$arrayClases[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-grupales/operaciones/".$id);
    				$c++;
    			}

    		}

            // dd($arrayClases);

    		$clasespersonalizadas = DB::table('clases_personalizadas')
    				->join('alumnos', 'alumnos.id', '=', 'clases_personalizadas.alumno_id')
                    ->select('clases_personalizadas.*' , 'alumnos.nombre', 'alumnos.apellido')
                    ->where('clases_personalizadas.academia_id', '=' ,  Auth::user()->academia_id)
                    ->where('clases_personalizadas.deleted_at', '=', null)
            ->get();

        	foreach ($clasespersonalizadas as $clasepersonalizada) {
        		$fecha_start=explode('-',$clasepersonalizada->fecha_inicio);
        		$fecha_end=explode('-',$clasepersonalizada->fecha_final);
        		$id=$clasepersonalizada->id;
        		$nombre= 'Clase P ' . $clasepersonalizada->nombre . ' ' . $clasepersonalizada->apellido;
        		$descripcion=$clasepersonalizada->descripcion;
        		$hora_inicio=$clasepersonalizada->hora_inicio;
        		$hora_final=$clasepersonalizada->hora_final;
        		$etiqueta=$clasepersonalizada->color_etiqueta;

        		$dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);

        		$df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

        		$arrayClasespersonalizadas[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-personalizadas/operaciones/".$id);

    			$c=0;
    			
    			while($dt->timestamp<$df->timestamp){
    				$fecha="";
    				$fecha=$dt->addWeek()->toDateString();
    				$arrayClasespersonalizadas[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-personalizadas/operaciones/".$id);
    				$c++;
    			}

    		}

    		$fiestas = DB::table('fiestas')
                    ->select('fiestas.*')
                    ->where('fiestas.academia_id', '=' ,  Auth::user()->academia_id)
                    ->where('fiestas.deleted_at', '=', null)
            ->get();

        	foreach ($fiestas as $fiesta) {
        		$fecha_start=explode('-',$fiesta->fecha_inicio);
        		$fecha_end=explode('-',$fiesta->fecha_final);
        		$id=$fiesta->id;
        		$nombre= $fiesta->nombre;
        		$descripcion=$fiesta->descripcion;
        		$hora_inicio=$fiesta->hora_inicio;
        		$hora_final=$fiesta->hora_final;
        		$etiqueta=$fiesta->color_etiqueta;

        		$dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);

        		$df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

        		$arrayFiestas[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/fiestas/operaciones/".$id);

    			$c=0;
    			
    			while($dt->timestamp<$df->timestamp){
    				$fecha="";
    				$fecha=$dt->addWeek()->toDateString();
    				$arrayFiestas[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/fiestas/operaciones/".$id);
    				$c++;
    			}

    		}

            return view('agendar.index')->with(['talleres' => $arrayTalleres, 'clases_grupales' => $arrayClases, 'clases_personalizadas' => $arrayClasespersonalizadas, 'fiestas' => $arrayFiestas]);

        }
        else{


            $talleres = DB::table('talleres')
                ->join('inscripcion_taller', 'inscripcion_taller.taller_id', '=', 'talleres.id')
                ->select('talleres.*')
                ->where('inscripcion_taller.alumno_id', Auth::user()->usuario_id)
                ->where('talleres.deleted_at', '=', null)
            ->get();

            foreach ($talleres as $taller) {

                $fecha_start=explode('-',$taller->fecha_inicio);
                $fecha_end=explode('-',$taller->fecha_final);
                $id=$taller->id;
                $nombre=$taller->nombre;
                $descripcion=$taller->descripcion;
                $hora_inicio=$taller->hora_inicio;
                $hora_final=$taller->hora_final;
                $etiqueta=$taller->color_etiqueta;

                $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);

                $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

                $arrayTalleres[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/talleres/progreso/".$id);

                $c=0;

                
                while($dt->timestamp<$df->timestamp){
                    $fecha="";
                    $fecha=$dt->addWeek()->toDateString();
                    $arrayTalleres[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/talleres/progreso/".$id);
                    $c++;
                }

            }

            // $clases_grupales=ClaseGrupal::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

            $clasegrupal = DB::table('config_clases_grupales')
                ->join('clases_grupales', 'config_clases_grupales.id', '=', 'clases_grupales.clase_grupal_id')
                ->join('inscripcion_clase_grupal', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
                ->select('clases_grupales.*', 'config_clases_grupales.nombre', 'config_clases_grupales.descripcion')
                ->where('inscripcion_clase_grupal.alumno_id', Auth::user()->usuario_id)
                ->where('clases_grupales.deleted_at', '=', null)
            ->get();

            foreach ($clasegrupal as $clase) {

                $fecha_start=explode('-',$clase->fecha_inicio);
                $fecha_end=explode('-',$clase->fecha_final);
                $id=$clase->id;
                $nombre=$clase->nombre;
                $descripcion=$clase->descripcion;
                $hora_inicio=$clase->hora_inicio;
                $hora_final=$clase->hora_final;
                $etiqueta=$clase->color_etiqueta;

                $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);

                $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

                $arrayClases[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-grupales/progreso/".$id);

                $c=0;

                
                while($dt->timestamp<$df->timestamp){
                    $fecha="";
                    $fecha=$dt->addWeek()->toDateString();
                    $arrayClases[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-grupales/progreso/".$id);
                    $c++;
                }

            }

            // dd($arrayClases);

            $clasespersonalizadas = DB::table('clases_personalizadas')
                    ->join('alumnos', 'alumnos.id', '=', 'clases_personalizadas.alumno_id')
                    ->select('clases_personalizadas.*' , 'alumnos.nombre', 'alumnos.apellido')
                    ->where('clases_personalizadas.alumno_id', '=' ,  Auth::user()->usuario_id)
                    ->where('clases_personalizadas.deleted_at', '=', null)
            ->get();

            foreach ($clasespersonalizadas as $clasepersonalizada) {
                $fecha_start=explode('-',$clasepersonalizada->fecha_inicio);
                $fecha_end=explode('-',$clasepersonalizada->fecha_final);
                $id=$clasepersonalizada->id;
                $nombre= 'Clase P ' . $clasepersonalizada->nombre . ' ' . $clasepersonalizada->apellido;
                $descripcion=$clasepersonalizada->descripcion;
                $hora_inicio=$clasepersonalizada->hora_inicio;
                $hora_final=$clasepersonalizada->hora_final;
                $etiqueta=$clasepersonalizada->color_etiqueta;

                $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);

                $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

                $arrayClasespersonalizadas[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-personalizadas/progreso/".Auth::user()->academia_id);

                $c=0;
                
                while($dt->timestamp<$df->timestamp){
                    $fecha="";
                    $fecha=$dt->addWeek()->toDateString();
                    $arrayClasespersonalizadas[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/clases-personalizadas/progreso/".Auth::user()->academia_id);
                    $c++;
                }

            }

            $fiestas = DB::table('fiestas')
                    ->select('fiestas.*')
                    ->where('fiestas.academia_id', '=' ,  Auth::user()->academia_id)
                    ->where('fiestas.deleted_at', '=', null)
            ->get();

            foreach ($fiestas as $fiesta) {
                $fecha_start=explode('-',$fiesta->fecha_inicio);
                $fecha_end=explode('-',$fiesta->fecha_final);
                $id=$fiesta->id;
                $nombre= $fiesta->nombre;
                $descripcion=$fiesta->descripcion;
                $hora_inicio=$fiesta->hora_inicio;
                $hora_final=$fiesta->hora_final;
                $etiqueta=$fiesta->color_etiqueta;

                $dt = Carbon::create($fecha_start[0], $fecha_start[1], $fecha_start[2], 0);

                $df = Carbon::create($fecha_end[0], $fecha_end[1], $fecha_end[2], 0);

                $arrayFiestas[]=array("id"=>$id,"nombre"=>$nombre, "descripcion"=>$descripcion,"fecha_inicio"=>$dt->toDateString(),"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/fiestas/progreso/".$id);

                $c=0;
                
                while($dt->timestamp<$df->timestamp){
                    $fecha="";
                    $fecha=$dt->addWeek()->toDateString();
                    $arrayFiestas[]=array("id"=>$id,"nombre"=>$nombre,"descripcion"=>$descripcion, "fecha_inicio"=>$fecha,"fecha_final"=>$df->toDateString(), "hora_inicio"=>$hora_inicio, 'hora_final'=>$hora_final, "etiqueta"=>$etiqueta,"url"=>"/agendar/fiestas/progreso/".$id);
                    $c++;
                }

            }

            return view('vista_alumno.agendar')->with(['talleres' => $arrayTalleres, 'clases_grupales' => $arrayClases, 'clases_personalizadas' => $arrayClasespersonalizadas, 'fiestas' => $arrayFiestas]);
        }
    	

    }

    public function store(Request $request)
	{
		//dd($request->all());
		/*$date = Carbon::now($request->getStart);
 		$date = $date->format('l jS \\of F Y h:i:s A');
 		echo $date;*/

 		$fecha =explode("GMT", $request->getStart);

 		$dt = new \DateTime($fecha[0]); // <== instance from another API
		$fecha_carbon = Carbon::instance($dt);
		//echo get_class($carbon);                               // 'Carbon\Carbon'
		//echo $carbon->format('d-m-Y'); 

	    //return redirect('home/dashboard'); 
	    $fecha_inicio= $fecha_carbon->format('d-m-Y');

        //dd($fecha_inicio);

	    if($request->agendar=="clases-grupales"){
			return redirect('agendar/clases-grupales/agregar')->with('fecha_inicio', $fecha_inicio);
	    }elseif($request->agendar=="clases-personalizadas"){
	    	return redirect('agendar/clases-personalizadas/agregar')->with(compact('fecha_inicio'));
	    }elseif($request->agendar=="talleres"){
	    	return redirect('agendar/talleres/agregar')->with(compact('fecha_inicio'));
	    }elseif($request->agendar=="fiestas-eventos"){
	    	return redirect('agendar/fiestas/agregar')->with(compact('fecha_inicio'));
	    }else{
	    	return redirect('agendar');
	    }
	}
}
