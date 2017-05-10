<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use Mail;
use Session;
use App\Academia;
use App\Alumno;
use Illuminate\Support\Facades\Auth;

class EmbajadorController extends BaseController {

    public function index(){

        Session::forget('embajador');
        $usuario_tipo = Session::get('easydance_usuario_tipo');

        if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){

            return view('empresa.invitar');

        }
        else{

            $academia = Academia::find(Auth::user()->academia_id);

            return view('vista_alumno.invitar')->with('academia',$academia->nombre);
        }

    }

    public function principal(){

        return view('empresa.embajadores');

    }

    public function enhorabuena(){

        $usuario_tipo = Session::get('easydance_usuario_tipo');

        if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){

            return view('empresa.enhorabuena');
        }

        else{

            $academia = Academia::find(Auth::user()->academia_id);

            return view('vista_alumno.enhorabuena')->with('academia',$academia->nombre);
        }

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
            $usuario_tipo = Session::get('easydance_usuario_tipo');
            $usuario_id = Session::get('easydance_usuario_id');

            if($embajadores)
            {

                $academia = Academia::find(Auth::user()->academia_id);

                if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){

                    $subj =  Auth::user()->nombre . " de la academia " . $academia->nombre . " te recomienda usar Easy Dance por 30 días grátis";
                }else{
                    $subj =  Auth::user()->nombre . " te recomienda bailar en " . $academia->nombre;
                    $alumno = Alumno::find($usuario_id);
                    $codigo = $alumno->codigo_referido;
                }

                foreach($embajadores as $embajador){

                    if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){
                    
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

                    }else{
                       $array = [
                           'correo' => $embajador[0]['email'],
                           'academia' => $academia->nombre,
                           'nombre_envio' => Auth::user()->nombre,
                           'nombre_destino' => $embajador[0]['nombre'],
                           'subj' => $subj,
                           'codigo' => $codigo
                        ]; 

                        Mail::send('correo.referido', $array , function($msj) use ($array){
                            $msj->subject($array['subj']);
                            $msj->to($array['correo']);
                        });
                    }

                }
               
                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores' => ['linea' => [0, 'Ups! Debes agregar un correo electrónico primero']], 'status' => 'ERROR'],422);
            }
    }

}