<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB;
use App\Academia;

class CrmController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // $clases_grupales_join = ClaseGrupal::table('clases_grupales')
        //     ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
        //     ->select('config_clases_grupales.*')
        //     ->get();

        $academias_join = DB::table('academias')
            ->join('paises', 'academias.pais_id', '=', 'paises.id')
            ->select('academias.nombre as nombre', 'paises.nombre as pais', 'academias.estado as estado', 'academias.id')
            ->get();

            // dd($academias_join);

        //return view('crm.index')->with(['academia' => $academias_join]);
        return view('crm.index')->with('academia', $academias_join);
    }

    public function edit($id)
    {

        $find = Academia::find($id);

        if($find){

            $academias_join = DB::table('academias')
                ->join('users', 'academias.id', '=', 'users.academia_id')
                ->join('paises', 'academias.pais_id', '=', 'paises.id')
                ->select('users.nombre as usuario_nombre', 'users.apellido as usuario_apellido' , 'users.email as usuario_email' , 'users.telefono as usuario_telefono', 'academias.nombre as academia_nombre','paises.nombre as pais', 'academias.estado as estado')
                ->where('academias.id', '=', $id)
                ->first();

                //dd($clase_grupal_join);

            // return view('crm.planilla')->with(['config_clases_grupales' => ConfigClasesGrupales::all(), 'config_especialidades' => ConfigEspecialidades::all(), 'config_estudios' => ConfigEstudios::all(), 'config_niveles' => ConfigNiveles::all(), 'instructor' => Instructor::all(), 'clasegrupal' => $clase_grupal_join]);

            return view('crm.planilla')->with('academia', $academias_join);

        }else{
           return redirect("administrar/crm"); 
        }

    }

}