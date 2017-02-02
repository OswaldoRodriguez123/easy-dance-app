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

        $codigo = Codigo::where('codigo_validacion', trim($request->codigo_validacion))->first();

            if($codigo){

                $fecha_limite = $codigo->fecha_vencimiento;

                if(Carbon::now() > $fecha_limite){
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