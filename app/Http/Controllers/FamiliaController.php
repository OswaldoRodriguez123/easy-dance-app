<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Alumno;
use App\User;
use App\Familia;
use App\Academia;
use App\ItemsFacturaProforma;
use Mail;
use Validator;
use DB;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;

class FamiliaController extends BaseController {

	public function principal()
	{

        $familias = DB::table('familias')
            ->join('users', 'familias.representante_id', '=', 'users.id')
            ->select('familias.*', 'users.nombre as representante_nombre', 'users.apellido as representante_apellido')
            ->where('familias.academia_id' , '=' , Auth::user()->academia_id)
            ->where('familias.deleted_at', '=', null)
        ->get();

        $alumnod = DB::table('alumnos')
            ->join('items_factura_proforma', 'items_factura_proforma.alumno_id', '=', 'alumnos.id')
            ->join('users', 'alumnos.id', '=', 'users.usuario_id')
            ->join('familias', 'familias.id', '=', 'users.familia_id')
            ->select('familias.id as id', 'items_factura_proforma.importe_neto', 'items_factura_proforma.fecha_vencimiento')
            ->where('items_factura_proforma.fecha_vencimiento','<=',Carbon::today())
            ->where('alumnos.academia_id','=', Auth::user()->academia_id)
            ->where('alumnos.deleted_at', '=', null)
        ->get();

        $collection=collect($alumnod);

        $grouped = $collection->groupBy('id');     
        
        $deuda = $grouped->toArray();

        $array = array();

        foreach($familias as $familia){

            $total = User::where('familia_id', '=' ,  $familia->id)->count();
            $collection=collect($familia);     
            $familia_array = $collection->toArray();
            
            $familia_array['total']=$total;
            $array[$familia->id] = $familia_array;

        }

		return view('participante.familia.principal')->with(['familias'=> $array, 'deuda' => $deuda]);
	}

	public function create()
    {
        Session::forget('participantes');
        return view('participante.familia.create');
        
    }

    public function store(Request $request)
    {
        $request->merge(array('correo' => trim($request->correo)));

    $rules = [
        'apellido_familia' => 'required|min:3|max:16|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'identificacion' => 'required|min:7|numeric|unique:alumnos,identificacion',
        'nombre' => 'required|min:3|max:16|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'apellido' => 'required|min:3|max:16|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'fecha_nacimiento' => 'required',
        'sexo' => 'required',
        'correo' => 'required|email|max:255|unique:users,email, '.$request->id.'',
        'rol' => 'required',
    ];

    $messages = [

        'apellido_familia.required' => 'Ups! El Apellido  es requerido ',
        'apellido_familia.min' => 'El mínimo de caracteres permitidos son 3',
        'apellido_familia.max' => 'El máximo de caracteres permitidos son 16',
        'apellido_familia.regex' => 'Ups! El apellido es inválido , debe ingresar sólo letras',
        'identificacion.required' => 'Ups! El identificador es requerido',
        'identificacion.min' => 'El mínimo de numeros permitidos son 5',
        'identificacion.max' => 'El maximo de numeros permitidos son 20',
        'identificacion.numeric' => 'Ups! El identificador es inválido , debe contener sólo números',
        'identificacion.unique' => 'Ups! Ya este usuario ha sido registrado',
        'nombre.required' => 'Ups! El Nombre  es requerido ',
        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre.max' => 'El máximo de caracteres permitidos son 16',
        'nombre.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
        'apellido.required' => 'Ups! El Apellido  es requerido ',
        'apellido.min' => 'El mínimo de caracteres permitidos son 3',
        'apellido.max' => 'El máximo de caracteres permitidos son 16',
        'apellido.regex' => 'Ups! El apellido es inválido , debe ingresar sólo letras',
        'sexo.required' => 'Ups! El Sexo  es requerido ',
        'fecha_nacimiento.required' => 'Ups! La fecha de nacimiento es requerida',
        'correo.required' => 'Ups! El correo  es requerido ',
        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'correo.max' => 'El máximo de caracteres permitidos son 255',
        'correo.unique' => 'Ups! Ya este correo ha sido registrado',
        'rol.required' => 'Ups! El Rol del representante es requerido ',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        // return redirect("/home")

        // ->withErrors($validator)
        // ->withInput();

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        //dd($validator);

    }

    else{

        $edad = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->diff(Carbon::now())->format('%y');

        if($edad < 1){
            return response()->json(['errores' => ['fecha_nacimiento' => [0, 'Ups! Esta fecha es invalida, debes ingresar una fecha superior a 1 año de edad']], 'status' => 'ERROR'],422);
        }

        $participantes = Session::get('participantes');

        if($participantes){

            foreach($participantes as $participante){
                foreach($participante as $item){
                    if($item['identificacion'] == $request->identificacion){
                        return response()->json(['errores' => ['identificacion' => [0, 'Ups! Ya este identificador ha sido registrado']], 'status' => 'ERROR'],422);
                    }
                }
            }


            foreach($participantes as $participante){
                foreach($participante as $item){
                    if($item['correo'] == $request->correo){
                        return response()->json(['errores' => ['correo' => [0, 'Ups! Ya este correo ha sido registrado']], 'status' => 'ERROR'],422);
                    }
                }
            }
        }


        $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->nombre))));

        $apellido = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->apellido))));

        $direccion = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->direccion))));

        $correo = strtolower($request->correo);

        $usuario = new User;

        $usuario->academia_id = Auth::user()->academia_id;
        $usuario->nombre = $nombre;
        $usuario->apellido = $apellido;
        $usuario->telefono = $request->telefono;
        $usuario->celular = $request->celular;
        $usuario->sexo = $request->sexo;
        $usuario->email = $correo;
        $usuario->como_nos_conociste_id = 1;
        $usuario->direccion = $direccion;
        // $usuario->confirmation_token = str_random(40);
        $usuario->password = bcrypt(str_random(8));
        $usuario->usuario_tipo = 4;

        if($usuario->save()){

            $apellido_familia = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->apellido_familia))));

            $familia = new Familia;

            $familia->academia_id = Auth::user()->academia_id;
            $familia->representante_id = $usuario->id;
            $familia->apellido = $apellido_familia;

            if($familia->save()){

                $usuario->familia_id = $familia->id;
                $usuario->save();


                //     $academia = Academia::find(Auth::user()->academia_id);
                //     $contrasena =  $usuario->password;
                //     $subj = $usuario->nombre . ' , ' . $academia->nombre . ' te ha agregado a Easy Dance, por favor confirma tu correo electronico';

                //     $array = [
                //        'nombre' => $usuario->nombre,
                //        'academia' => $academia->nombre,
                //        'usuario' => $correo,
                //        'contrasena' => $contrasena,
                //        'subj' => $subj
                //     ];

                //     Mail::send('correo.inscripcion', $array, function($msj) use ($array){
                //             $msj->subject($array['subj']);
                //             $msj->to($array['usuario']);
                //         });

                $familia_id = $familia->id;

                 $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->toDateString();
                

                if($request->rol == "1"){

                    $alumno = new Alumno;

                    $alumno->academia_id = Auth::user()->academia_id;
                    $alumno->identificacion = $request->identificacion;
                    $alumno->nombre = $nombre;
                    $alumno->apellido = $apellido;
                    $alumno->sexo = $request->sexo;
                    $alumno->fecha_nacimiento = $fecha_nacimiento;
                    $alumno->correo = $correo;
                    $alumno->telefono = $request->telefono;
                    $alumno->celular = $request->celular;
                    $alumno->direccion = $direccion;
                    $alumno->alergia = 0;
                    $alumno->asma = 0;
                    $alumno->convulsiones = 0;
                    $alumno->cefalea = 0;
                    $alumno->hipertension = 0;
                    $alumno->lesiones = 0;

                    $alumno->save();

                    $usuario->usuario_id = $alumno->id;
                    $usuario->save();

                }

                if($participantes){

                    foreach($participantes as $participante){
                        foreach($participante as $item){

                            if($item['identificacion']){
                                $identificacion = $item['identificacion'];
                            }else{
                                $identificacion = $request->identificacion;
                            }

                            $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $item['fecha_nacimiento'])->toDateString();

                            $nombre = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($item['nombre']))));

                            $apellido = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($item['apellido']))));

                            $correo = strtolower($item['correo']);


                            $alumno = new Alumno;

                            $alumno->academia_id = Auth::user()->academia_id;
                            $alumno->identificacion = $identificacion;
                            $alumno->nombre = $nombre;
                            $alumno->apellido = $apellido;
                            $alumno->sexo = $item['sexo'];
                            $alumno->fecha_nacimiento = $fecha_nacimiento;
                            $alumno->correo = $correo;
                            $alumno->telefono = $request->telefono;
                            $alumno->celular = $item['celular'];
                            $alumno->direccion = $direccion;
                            $alumno->alergia = $item['alergia'];
                            $alumno->asma = $item['asma'];
                            $alumno->convulsiones = $item['convulsiones'];
                            $alumno->cefalea = $item['cefalea'];
                            $alumno->hipertension = $item['hipertension'];
                            $alumno->lesiones = $item['lesiones'];

                            $alumno->save();

                            $usuario = new User;

                            $usuario->academia_id = Auth::user()->academia_id;
                            $usuario->nombre = $nombre;
                            $usuario->apellido = $apellido;
                            $usuario->telefono = $request->telefono;
                            $usuario->celular = $item['celular'];
                            $usuario->sexo = $item['sexo'];
                            $usuario->email = $correo;
                            $usuario->como_nos_conociste_id = 1;
                            $usuario->direccion = $direccion;
                            // $usuario->confirmation_token = str_random(40);
                            $usuario->password = bcrypt(str_random(8));
                            $usuario->usuario_id = $alumno->id;
                            $usuario->usuario_tipo = 2;
                            $usuario->familia_id = $familia_id;

                            $usuario->save();

                            //     $contrasena =  $usuario->password;
                            //     $subj = $usuario->nombre . ' , ' . $academia->nombre . ' te ha agregado a Easy Dance, por favor confirma tu correo electronico';

                            //     $array = [
                            //        'nombre' => $usuario->nombre,
                            //        'academia' => $academia->nombre,
                            //        'usuario' => $correo,
                            //        'contrasena' => $contrasena,
                            //        'subj' => $subj
                            //     ];

                            //     Mail::send('correo.inscripcion', $array, function($msj) use ($array){
                            //             $msj->subject($array['subj']);
                            //             $msj->to($array['usuario']);
                            //         });

                        }
                    }
                }
            }

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
            }
        }
    }

    public function agregarparticipante(Request $request){

    $request->merge(array('correo_participante' => trim($request->correo_participante)));
        
    $rules = [

        'nombre_participante' => 'required|min:3|max:16|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'apellido_participante' => 'required|min:3|max:16|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        'fecha_nacimiento_participante' => 'required',
        'sexo_participante' => 'required',
        'correo_participante' => 'required|email|max:255|unique:users,email, '.$request->id.'',
    ];

    $messages = [

        'nombre_participante.required' => 'Ups! El Nombre  es requerido ',
        'nombre_participante.min' => 'El mínimo de caracteres permitidos son 3',
        'nombre_participante.max' => 'El máximo de caracteres permitidos son 16',
        'nombre_participante.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
        'apellido_participante.required' => 'Ups! El Apellido  es requerido ',
        'apellido_participante.min' => 'El mínimo de caracteres permitidos son 3',
        'apellido_participante.max' => 'El máximo de caracteres permitidos son 16',
        'apellido_participante.regex' => 'Ups! El apellido es inválido , debe ingresar sólo letras',
        'sexo_participante.required' => 'Ups! El Sexo  es requerido ',
        'fecha_nacimiento_participante.required' => 'Ups! La fecha de nacimiento es requerida',
        'correo_participante.required' => 'Ups! El correo  es requerido ',
        'correo_participante.email' => 'Ups! El correo tiene una dirección inválida',
        'correo_participante.max' => 'El máximo de caracteres permitidos son 255',
        'correo_participante.unique' => 'Ups! Ya este correo ha sido registrado',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $edad = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento_participante)->diff(Carbon::now())->format('%y');


        if($edad < 1){
            return response()->json(['errores' => ['fecha_nacimiento_participante' => [0, 'Ups! Esta fecha es invalida, debes ingresar una fecha superior a 1 año de edad']], 'status' => 'ERROR'],422);
        }

        if($request->editar != ''){

            $arreglo = Session::get('participantes');
            if($arreglo){
                unset($arreglo[$request->editar]);
                Session::put('participantes', $arreglo);
            }
        }

        $participantes = Session::get('participantes');

        if($participantes){

            if($request->identificacion_participante){
                foreach($participantes as $participante){
                    foreach($participante as $item){
                        if($item['identificacion'] == $request->identificacion_participante){
                            return response()->json(['errores' => ['identificacion_participante' => [0, 'Ups! Ya este identificador ha sido registrado']], 'status' => 'ERROR'],422);
                        }
                    }
                }
            }

            foreach($participantes as $participante){
                foreach($participante as $item){
                    if($item['correo'] == $request->correo_participante){
                        return response()->json(['errores' => ['correo_participante' => [0, 'Ups! Ya este correo ha sido registrado']], 'status' => 'ERROR'],422);
                    }
                }
            }
        }

        $array = array(['identificacion' => $request->identificacion_participante, 'nombre' => $request->nombre_participante, 'apellido' => $request->apellido_participante, 'sexo' => $request->sexo_participante, 'fecha_nacimiento' => $request->fecha_nacimiento_participante, 'correo' => $request->correo_participante, 'celular' => $request->celular_participante, 'alergia' => $request->alergia, 'asma' => $request->asma, 'convulsiones' => $request->convulsiones, 'cefalea' => $request->cefalea, 'hipertension' => $request->hipertension, 'lesiones' => $request->lesiones]);

        Session::push('participantes', $array);

        $items = Session::get('participantes');
        end( $items );
        $contador = key( $items );

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'id' => $contador, 'editar' => $request->editar, 200]);

        }
    }

    public function eliminarparticipante($id){

        $arreglo = Session::get('participantes');

        unset($arreglo[$id]);

        Session::put('participantes', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function edit($id)
    {   

        $alumnos = DB::table('alumnos')
            ->join('users', 'users.usuario_id', '=', 'alumnos.id')
            ->select('alumnos.*')
            ->where('users.familia_id' , '=' ,$id)
        ->get();

        $i = 0;

        foreach($alumnos as $alumno){


            $total = ItemsFacturaProforma::where('alumno_id', '=' ,  $alumno->id)->sum('importe_neto');
            $collection=collect($alumno);     
            $alumno_array = $collection->toArray();
            
            $alumno_array['total']=$total;
            $array[$i] = $alumno_array;

            $i = $i + 1;

        }

        if($alumnos){

           return view('participante.familia.planilla')->with(['alumno' => $array , 'id' => $id]);

        }else{
           return redirect("participante/familia"); 
        }
    }

    public function operar($id)
    {   
        $familia = Familia::find($id);

        return view('participante.familia.operacion')->with(['id' => $id , 'familia' => $familia]);       
    }


    public function participantes($id)
    {
   
        $participantes = DB::table('users')
            ->join('alumnos', 'users.usuario_id', '=', 'alumnos.id')
            ->select('alumnos.*')
            ->where('users.familia_id' , '=' , $id)
        ->get();

        $familia = Familia::find($id);

        return view('participante.familia.participantes')->with(['participantes' => $participantes, 'familia_id' => $familia->id, 'familia' => $familia]);

    }

    public function destroy($id)
    {
        $familia = Familia::find($id);
        
        if($familia->delete()){
            return response()->json(['mensaje' => '¡Excelente! La Clase Personalizada se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

}
