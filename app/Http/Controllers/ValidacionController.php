<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Codigo;

class ValidacionController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function principal()
    {

        return view('validar.validar');
    }

    public function exitoso()
    {

        return view('validar.codigo_validado');
    }

    public function invalido()
    {

        return view('validar.codigo_invalido');
    }

    public function validar(Request $request)
    {

        $tmp = Codigo::where('codigo_validacion', $request->codigo_validacion)->first();

            if($tmp){

                $fecha_creacion = $tmp->created_at;
                $hora_limite = $fecha_creacion->addHours(48);

                if(Carbon::now() > $hora_limite){
                    $valido = null;
                }else{
                    $valido = 'Si';
                }

            }else{
                $valido = null;
            }

            if($valido){
                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
            }
    }

}