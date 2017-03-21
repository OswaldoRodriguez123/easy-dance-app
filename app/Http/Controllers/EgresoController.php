<?php namespace App\Http\Controllers;

use App\Egreso;
use App\Taller;
use App\Campana;
use App\Patrocinador;
use App\Fiesta;
use App\Academia;
use App\ConfigEgreso;
use Illuminate\Support\Facades\Auth;

class EgresoController extends BaseController {

	public function principal(){

        return view('administrativo.egresos.index');

    }

    public function generales()
    {
        $config_egresos = ConfigEgreso::all();

        $egresos = Egreso::Leftjoin('config_egresos', 'egresos.tipo' , '=', 'config_egresos.id')
            ->select('egresos.*', 'config_egresos.nombre as config_tipo')
            ->where('academia_id',Auth::user()->academia_id)
            ->where('tipo_id',Auth::user()->academia_id)
            ->where('tipo',1)
        ->get();

        $total = Egreso::Leftjoin('config_egresos', 'egresos.tipo' , '=', 'config_egresos.id')
            ->select('egresos.*', 'config_egresos.nombre as config_tipo')
            ->where('academia_id',Auth::user()->academia_id)
            ->where('tipo_id',Auth::user()->academia_id)
            ->where('tipo',1)
        ->sum('cantidad');

        return view('administrativo.egresos.generales')->with(['egresos' => $egresos, 'total' => $total, 'config_egresos' => $config_egresos]);
          
    }

    public function fiestas()
    {
    	$academia = Academia::find(Auth::user()->academia_id);

        return view('administrativo.egresos.fiestas')->with('fiestas', Fiesta::where('academia_id', '=' ,  Auth::user()->academia_id)->get());
    }

     public function talleres(){

     	$academia = Academia::find(Auth::user()->academia_id);

        $talleres = Taller::where('academia_id', '=' ,  Auth::user()->academia_id)->OrderBy('talleres.hora_inicio')->get();

        return view('administrativo.egresos.talleres')->with(['talleres' => $talleres, 'academia' => $academia]);
    }

    public function campanas(){

        $campanas = Campana::where('campanas.academia_id' , '=' , Auth::user()->academia_id)
            ->OrderBy('campanas.created_at')
        ->get();

        $array=array();
        $i = 0;
        $cantidad = 0;
        $total = 0;

        $academia = Academia::find(Auth::user()->academia_id);


        foreach($campanas as $campana){

            $recaudado = 0;
            $patrocinador_monto = 0;

            $patrocinadores = Patrocinador::where('campana_id', '=' ,  $campana->id)->get();

            foreach($patrocinadores as $patrocinador){

                if($patrocinador->tipo_moneda == 1){
                    $patrocinador_monto = $patrocinador->monto;
                }else{
                    $patrocinador_monto = $patrocinador->monto * 1000;
                }

                $recaudado = $recaudado + $patrocinador_monto;

            }
            
            $collection=collect($campana);     
            $campana_array = $collection->toArray();
            
            $campana_array['total']=$recaudado;
            $array[$campana->id] = $campana_array;
    
        }

        return view('administrativo.egresos.campanas')->with(['campanas' => $array, 'academia' => $academia]);

    }
}