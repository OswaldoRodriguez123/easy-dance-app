<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Academia;
use App\InscripcionClaseGrupal;
use App\Progreso;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Session;

class ProgresoController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    
    public function index()
    {

        $clase_grupal_join = DB::table('clases_grupales')
        	->join('inscripcion_clase_grupal', 'inscripcion_clase_grupal.clase_grupal_id', '=', 'clases_grupales.id')
            ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->select('config_clases_grupales.nombre as clase_grupal_nombre', 'clases_grupales.id', 'config_clases_grupales.imagen', 'config_clases_grupales.descripcion')
            ->where('inscripcion_clase_grupal.alumno_id','=', Auth::user()->usuario_id)
            ->where('clases_grupales.deleted_at', '=', null)
            ->OrderBy('clases_grupales.hora_inicio')
        ->get();

        $academia = Academia::find(Auth::user()->academia_id);


         return view('progreso.principal')->with(['clase_grupal_join' => $clase_grupal_join]);

        
    
    }

    public function progreso($id)
    {
    	$find = InscripcionClaseGrupal::where('clase_grupal_id', $id)->where('alumno_id',Auth::user()->usuario_id)->first();

    	if($find){

    		$progreso = Progreso::where('clase_grupal_id',$id)->first();

    		if($progreso){
    			$clase_1 = Progreso::where('clase_grupal_id',$id)->where('tipo',1)->first();
    			$clase_2 = Progreso::where('clase_grupal_id',$id)->where('tipo',2)->first();
    			$clase_3 = Progreso::where('clase_grupal_id',$id)->where('tipo',3)->first();
    			$clase_4 = Progreso::where('clase_grupal_id',$id)->where('tipo',4)->first();
    			$clase_5 = Progreso::where('clase_grupal_id',$id)->where('tipo',5)->first();
    			$clase_6 = Progreso::where('clase_grupal_id',$id)->where('tipo',6)->first();
    			$clase_7 = Progreso::where('clase_grupal_id',$id)->where('tipo',7)->first();
    			$clase_8 = Progreso::where('clase_grupal_id',$id)->where('tipo',8)->first();
    			$clase_9 = Progreso::where('clase_grupal_id',$id)->where('tipo',9)->first();
    			$clase_10 = Progreso::where('clase_grupal_id',$id)->where('tipo',10)->first();
    			$clase_11 = Progreso::where('clase_grupal_id',$id)->where('tipo',11)->first();
    			$clase_12 = Progreso::where('clase_grupal_id',$id)->where('tipo',12)->first();
    			// $clase_13 = Progreso::where('clase_grupal_id',$id)->where('tipo',13)->first();
    			// $clase_14 = Progreso::where('clase_grupal_id',$id)->where('tipo',14)->first();
    			// $clase_15 = Progreso::where('clase_grupal_id',$id)->where('tipo',15)->first();
    			// $clase_16 = Progreso::where('clase_grupal_id',$id)->where('tipo',16)->first();
    			
    		}
    		else{

    			$clase_1 = new Progreso;
    			$clase_1->clase_grupal_id = $id;
    			$clase_1->tipo = 1;
    			$clase_1->save();

    			$clase_2 = new Progreso;
    			$clase_2->clase_grupal_id = $id;
    			$clase_2->tipo = 2;
    			$clase_2->save();

    			$clase_3 = new Progreso;
    			$clase_3->clase_grupal_id = $id;
    			$clase_3->tipo = 3;
    			$clase_3->save();

    			$clase_4 = new Progreso;
    			$clase_4->clase_grupal_id = $id;
    			$clase_4->tipo = 4;
    			$clase_4->save();

    			$clase_5 = new Progreso;
    			$clase_5->clase_grupal_id = $id;
    			$clase_5->tipo = 5;
    			$clase_5->save();

    			$clase_6 = new Progreso;
    			$clase_6->clase_grupal_id = $id;
    			$clase_6->tipo = 6;
    			$clase_6->save();

    			$clase_7 = new Progreso;
    			$clase_7->clase_grupal_id = $id;
    			$clase_7->tipo = 7;
    			$clase_7->save();

    			$clase_8 = new Progreso;
    			$clase_8->clase_grupal_id = $id;
    			$clase_8->tipo = 8;
    			$clase_8->save();

    			$clase_9 = new Progreso;
    			$clase_9->clase_grupal_id = $id;
    			$clase_9->tipo = 9;
    			$clase_9->save();

    			$clase_10 = new Progreso;
    			$clase_10->clase_grupal_id = $id;
    			$clase_10->tipo = 10;
    			$clase_10->save();

    			$clase_11 = new Progreso;
    			$clase_11->clase_grupal_id = $id;
    			$clase_11->tipo = 11;
    			$clase_11->save();

    			$clase_12 = new Progreso;
    			$clase_12->clase_grupal_id = $id;
    			$clase_12->tipo = 12;
    			$clase_12->save();

    			// $clase_13 = new Progreso;
    			// $clase_13->clase_grupal_id = $id;
    			// $clase_13->tipo = 13;
    			// $clase_13->save();

    			// $clase_14 = new Progreso;
    			// $clase_14->clase_grupal_id = $id;
    			// $clase_14->tipo = 14;
    			// $clase_14->save();

    			// $clase_15 = new Progreso;
    			// $clase_15->clase_grupal_id = $id;
    			// $clase_15->tipo = 15;
    			// $clase_15->save();

    			// $clase_16 = new Progreso;
    			// $clase_16->clase_grupal_id = $id;
    			// $clase_16->tipo = 16;
    			// $clase_16->save();
    		}

	        return view('progreso.progreso')->with(['clase_1' => $clase_1, 'clase_2' => $clase_2, 'clase_3' => $clase_3, 'clase_4' => $clase_4, 'clase_5' => $clase_5, 'clase_6' => $clase_6, 'clase_7' => $clase_7, 'clase_8' => $clase_8, 'clase_9' => $clase_9, 'clase_10' => $clase_10, 'clase_11' => $clase_11, 'clase_12' => $clase_12, 'id' => $id]);

        }else{
       		return redirect("progreso"); 
       	}
        
    
    }

    public function programacion($id)
    {
        $find = InscripcionClaseGrupal::where('clase_grupal_id', $id)->where('alumno_id',Auth::user()->usuario_id)->first();

        if($find){

            $progreso = Progreso::where('clase_grupal_id',$id)->first();

            if($progreso){
                $clase_1 = Progreso::where('clase_grupal_id',$id)->where('tipo',1)->first();
                $clase_2 = Progreso::where('clase_grupal_id',$id)->where('tipo',2)->first();
                $clase_3 = Progreso::where('clase_grupal_id',$id)->where('tipo',3)->first();
                $clase_4 = Progreso::where('clase_grupal_id',$id)->where('tipo',4)->first();
                $clase_5 = Progreso::where('clase_grupal_id',$id)->where('tipo',5)->first();
                $clase_6 = Progreso::where('clase_grupal_id',$id)->where('tipo',6)->first();
                $clase_7 = Progreso::where('clase_grupal_id',$id)->where('tipo',7)->first();
                $clase_8 = Progreso::where('clase_grupal_id',$id)->where('tipo',8)->first();
                $clase_9 = Progreso::where('clase_grupal_id',$id)->where('tipo',9)->first();
                $clase_10 = Progreso::where('clase_grupal_id',$id)->where('tipo',10)->first();
                $clase_11 = Progreso::where('clase_grupal_id',$id)->where('tipo',11)->first();
                $clase_12 = Progreso::where('clase_grupal_id',$id)->where('tipo',12)->first();
                // $clase_13 = Progreso::where('clase_grupal_id',$id)->where('tipo',13)->first();
                // $clase_14 = Progreso::where('clase_grupal_id',$id)->where('tipo',14)->first();
                // $clase_15 = Progreso::where('clase_grupal_id',$id)->where('tipo',15)->first();
                // $clase_16 = Progreso::where('clase_grupal_id',$id)->where('tipo',16)->first();
                
            }
            else{

                $clase_1 = new Progreso;
                $clase_1->clase_grupal_id = $id;
                $clase_1->tipo = 1;
                $clase_1->save();

                $clase_2 = new Progreso;
                $clase_2->clase_grupal_id = $id;
                $clase_2->tipo = 2;
                $clase_2->save();

                $clase_3 = new Progreso;
                $clase_3->clase_grupal_id = $id;
                $clase_3->tipo = 3;
                $clase_3->save();

                $clase_4 = new Progreso;
                $clase_4->clase_grupal_id = $id;
                $clase_4->tipo = 4;
                $clase_4->save();

                $clase_5 = new Progreso;
                $clase_5->clase_grupal_id = $id;
                $clase_5->tipo = 5;
                $clase_5->save();

                $clase_6 = new Progreso;
                $clase_6->clase_grupal_id = $id;
                $clase_6->tipo = 6;
                $clase_6->save();

                $clase_7 = new Progreso;
                $clase_7->clase_grupal_id = $id;
                $clase_7->tipo = 7;
                $clase_7->save();

                $clase_8 = new Progreso;
                $clase_8->clase_grupal_id = $id;
                $clase_8->tipo = 8;
                $clase_8->save();

                $clase_9 = new Progreso;
                $clase_9->clase_grupal_id = $id;
                $clase_9->tipo = 9;
                $clase_9->save();

                $clase_10 = new Progreso;
                $clase_10->clase_grupal_id = $id;
                $clase_10->tipo = 10;
                $clase_10->save();

                $clase_11 = new Progreso;
                $clase_11->clase_grupal_id = $id;
                $clase_11->tipo = 11;
                $clase_11->save();

                $clase_12 = new Progreso;
                $clase_12->clase_grupal_id = $id;
                $clase_12->tipo = 12;
                $clase_12->save();

            //     $clase_13 = new Progreso;
            //     $clase_13->clase_grupal_id = $id;
            //     $clase_13->tipo = 13;
            //     $clase_13->save();

            //     $clase_14 = new Progreso;
            //     $clase_14->clase_grupal_id = $id;
            //     $clase_14->tipo = 14;
            //     $clase_14->save();

            //     $clase_15 = new Progreso;
            //     $clase_15->clase_grupal_id = $id;
            //     $clase_15->tipo = 15;
            //     $clase_15->save();

            //     $clase_16 = new Progreso;
            //     $clase_16->clase_grupal_id = $id;
            //     $clase_16->tipo = 16;
            //     $clase_16->save();
            }

    	   return view('progreso.programacion')->with(['clase_1' => $clase_1, 'clase_2' => $clase_2, 'clase_3' => $clase_3, 'clase_4' => $clase_4, 'clase_5' => $clase_5, 'clase_6' => $clase_6, 'clase_7' => $clase_7, 'clase_8' => $clase_8, 'clase_9' => $clase_9, 'clase_10' => $clase_10, 'clase_11' => $clase_11, 'clase_12' => $clase_12]);
        }
    }

}