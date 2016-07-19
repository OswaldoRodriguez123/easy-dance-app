<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use Mail;
use Session;
use App\Academia;
use Illuminate\Support\Facades\Auth;

class EmbajadorController extends BaseController {

    public function index(){

        Session::forget('embajador');

        return view('empresa.invitar');

    }

    public function principal(){

        return view('empresa.embajadores');

    }

    public function enhorabuena(){

        return view('empresa.enhorabuena');

    }

	public function agregarlinea(Request $request){
        
    $rules = [

        'nombre' => 'required',
        'correo' => 'required|email',

    ];

    $messages = [

        'nombre.required' => 'Ups! El Nombre es requerido',
        'correo.required' => 'Ups! El Correo es requerido',
        'correo.email' => 'Ups! El correo tiene una dirección inválida',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $array = array(['nombre' => $request->nombre, 'email' => $request->correo]);

        Session::push('embajador', $array);

        $items = Session::get('embajador');
        end( $items );
        $contador = key( $items );

         return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'id' => $contador, 200]);

        }
    }

    public function eliminarlinea($id){

        $arreglo = Session::get('embajador');

        unset($arreglo[$id]);
        Session::put('embajador', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);

    }

    public function invitar(Request $request){
        
            $embajadores = Session::get('embajador');

            if($embajadores)
            {

                $academia = Academia::find(Auth::user()->academia_id);

                foreach($embajadores as $embajador){

                    $subj =  Auth::user()->nombre . " de la academia " . $academia->nombre . " te recomienda usar Easy Dance por 30 días grátis";
                    
                    $array = [
                       'correo' => $embajador[0]['email'],
                       'academia' => $academia->nombre,
                       'nombre_envio' => Auth::user()->nombre,
                       'nombre_destino' => $embajador[0]['nombre'],
                       'subj' => $subj
                    ];

                     Mail::send('correo.embajador', $array , function($msj) use ($array){
                        $msj->subject($array['subj']);
                        $msj->to($array['correo']);
                    });
                }
               
             return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores' => ['linea' => [0, 'Ups! Debes agregar un correo electrónico primero']], 'status' => 'ERROR'],422);
            }
    }

}