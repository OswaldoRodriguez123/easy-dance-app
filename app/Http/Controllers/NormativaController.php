<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\Normativa;
use Validator;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class NormativaController extends BaseController {    

    public function principal(){

        $normativas = Normativa::where('academia_id',Auth::user()->academia_id)->get();

        return view('configuracion.herramientas.normativas.principal')->with(['normativas' => $normativas, 'id' => Auth::user()->academia_id]);

    }

    public function store(Request $request){

        $rules = [
            'nombre' => 'required|min:1',
            'pdf' => 'required|mimes:pdf',
        ];

        $messages = [
            'nombre.required' => 'Ups! El Nombre es requerido',
            'pdf.required' => 'Ups! El PDF es requerido',
            'pdf.mimes' => 'Ups! Solo se aceptan archivos PDF',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $normativa = Normativa::where('academia_id',Auth::user()->academia_id)->where('nombre',$request->nombre)->first();

            if(!$normativa){

                $normativa = new Normativa;
                $normativa->nombre = $request->nombre;
                $normativa->academia_id = Auth::user()->academia_id;

                if($normativa->save()){

                    $extension = $request->pdf->getClientOriginalExtension();
                    $nombre_archivo = $request->nombre.'-'.Auth::user()->academia_id.'.'.$extension;

                    \Storage::disk('normativas')->put($nombre_archivo,  \File::get($request->pdf));

                    return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 'normativa' => $normativa, 200]);
                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
                }
                
            }else{
                return response()->json(['errores' => ['nombre' => [0, 'Ups! Ya posee una normativa con este nombre']], 'status' => 'ERROR'],422);
            }
        }
    }

    public function destroy($id)
    {
        $normativa = Normativa::find($id);
        $nombre = $normativa->nombre;
        
        if($normativa->delete()){

            \Storage::disk('normativas')->delete($nombre.'-'.Auth::user()->academia_id.'.pdf');
            return response()->json(['mensaje' => '¡Excelente! La normativa se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno");
    }

    public function edit(){

        $normativas = Normativa::where('academia_id',Auth::user()->academia_id)->get();

        return view('configuracion.herramientas.normativas.planilla')->with(['normativas' => $normativas]);
        
    }

    public function generales(){
        
        return view('configuracion.herramientas.normativas.generales');

    }

    public function clases_grupales(){
        
        return view('configuracion.herramientas.normativas.clases_grupales');

    }

    public function clases_personalizadas(){
        
        return view('configuracion.herramientas.normativas.clases_personalizadas');

    }

    public function diagnostico(){
        
        return view('configuracion.herramientas.normativas.diagnostico');

    }
}