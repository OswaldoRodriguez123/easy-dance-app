<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Academia;
use App\Staff;
use App\HorarioStaff;
use App\ConfigStaff;
use App\ConfigComision;
use App\ConfigServicios;
use App\ConfigProductos;
use App\Comision;
use App\User;
use App\UsuarioTipo;
use App\DiasDeSemana;
use App\Alumno;
use App\Instructor;
use App\MetaStaff;
use App\ItemsFactura;
use Mail;
use DB;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;

class StaffController extends BaseController
{

	public function principal()
	{

        $staffs = Staff::join('config_staff', 'staff.cargo', '=', 'config_staff.id')
            ->select('staff.*', 'config_staff.nombre as cargo')
            ->where('staff.academia_id', Auth::user()->academia_id)
        ->get();

		return view('configuracion.staff.principal')->with(['staffs' => $staffs]);
	}

	public function create()
    {
        $dia_de_semana = DiasDeSemana::all();

        $config_staff = ConfigStaff::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->orderBy('nombre')->get();

        Session::forget('horarios_staff');
        Session::forget('comisiones');

        $config_servicio=ConfigServicios::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

        foreach($config_servicio as $item){

            $tmp[]=array('id' => $item['id'].'-'.$item['tipo'], 'nombre' => $item['nombre'] , 'tipo' => $item['tipo']);
        }

        //$config_producto=ConfigProductos::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

        //foreach($config_producto as $item){

            //$tmp[]=array('id' => $item['id'], 'nombre' => $item['nombre'] , 'tipo' => $item['tipo']);
           
        //}

        $collection=collect($tmp);   
        $linea_servicio = $collection->toArray();

        return view('configuracion.staff.create')->with(['dias_de_semana' => $dia_de_semana, 'config_staff' => $config_staff, 'linea_servicio' => $linea_servicio]);
    }

    public function store(Request $request)
	{

		$request->merge(array('correo' => trim($request->correo)));

	    $rules = [
	        'identificacion' => 'required|min:7|numeric',
	        'nombre' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
	        'apellido' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
	        'fecha_nacimiento' => 'required',
	        'sexo' => 'required',
	        'cargo' => 'required',
            'correo' => 'email|max:255',
	    ];

	    $messages = [

	        'identificacion.required' => 'Ups! El identificador es requerido',
	        'identificacion.min' => 'El mínimo de numeros permitidos son 5',
	        'identificacion.max' => 'El maximo de numeros permitidos son 20',
	        'identificacion.numeric' => 'Ups! El identificador es inválido , debe contener sólo números',
	        'identificacion.unique' => 'Ups! Ya este usuario ha sido registrado',
	        'nombre.required' => 'Ups! El Nombre  es requerido ',
	        'nombre.min' => 'El mínimo de caracteres permitidos son 3',
	        'nombre.max' => 'El máximo de caracteres permitidos son 20',
	        'nombre.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
	        'apellido.required' => 'Ups! El Apellido  es requerido ',
	        'apellido.min' => 'El mínimo de caracteres permitidos son 3',
	        'apellido.max' => 'El máximo de caracteres permitidos son 20',
	        'apellido.regex' => 'Ups! El apellido es inválido , debe ingresar sólo letras',
	        'sexo.required' => 'Ups! El Sexo  es requerido ',
	        'fecha_nacimiento.required' => 'Ups! La fecha de nacimiento es requerida',
	        'cargo.required' => 'Ups! El cargo es requerido',
            'correo.required' => 'Ups! El correo es requerido',
            'correo.email' => 'Ups! El correo tiene una dirección inválida',
            'correo.max' => 'El máximo de caracteres permitidos son 255',
	    ];

	    $validator = Validator::make($request->all(), $rules, $messages);

	    if ($validator->fails()){

	        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

	    }

	    else{

	        $edad = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->diff(Carbon::now())->format('%y');


	        if($edad < 1){
	            return response()->json(['errores' => ['fecha_nacimiento' => [0, 'Ups! Esta fecha es invalida, debes ingresar una fecha superior a 1 año de edad']], 'status' => 'ERROR'],422);
	        }

	        $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->toDateString();

	        $nombre = title_case($request->nombre);
	        $apellido = title_case($request->apellido);
	        $correo = trim(strtolower($request->correo));

            if($correo){

                $usuario = User::where('email',$correo)->first();

                if($usuario){

                    $usuario_tipo = UsuarioTipo::where('tipo',8)
                        ->where('usuario_id',$usuario->id)
                    ->first();

                    if($usuario_tipo){
                        return response()->json(['errores' => ['correo' => [0, 'Ups! Ups! Ya este correo ha sido registrado']], 'status' => 'ERROR'],422);
                    }
                }
            }

	        if($request->telefono)
	        {
	            $telefono = $request->telefono;

	        }else{
	            $telefono = '';
	        }

	        if($request->direccion)
	        {
	            $direccion = $request->direccion;

	        }else{
	            $direccion = '';
	        }

            $staff = new Staff;

	        $staff->academia_id = Auth::user()->academia_id;
	        $staff->identificacion = $request->identificacion;
	        $staff->nombre = $nombre;
	        $staff->apellido = $apellido;
	        $staff->sexo = $request->sexo;
	        $staff->fecha_nacimiento = $fecha_nacimiento;
	        $staff->correo = $correo;
	        $staff->telefono = $telefono;
	        $staff->celular = $request->celular;
	        $staff->direccion = $direccion;
	        $staff->cargo = $request->cargo;

	        if($staff->save()){

                if($correo){
                    if(!$usuario){

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
                        $usuario->password = bcrypt(str_random(8));
                        $usuario->usuario_id = $staff->id;
                        $usuario->usuario_tipo = 8;

                        $usuario->save();
                    }

                    $usuario_tipo = new UsuarioTipo;
                    $usuario_tipo->usuario_id = $usuario->id;
                    $usuario_tipo->tipo = 8;
                    $usuario_tipo->tipo_id = $staff->id;
                    $usuario_tipo->save();
                }

                $horarios = Session::get('horarios_staff');

                if($horarios){

                    foreach ($horarios as $tmp) {

                        $horario = new HorarioStaff;
                        $horario->staff_id = $staff->id;
                        $horario->dia_de_semana_id = $tmp['dia_de_semana_id'];
                        $horario->hora_inicio = $tmp['hora_inicio'];
                        $horario->hora_final = $tmp['hora_final'];
                        $horario->save();
                        
                        
                    }
                }

                $comisiones = Session::get('comisiones');

                if($comisiones){

                    foreach ($comisiones as $comision) {

                        $config_pago = new ConfigComision;

                        $config_pago->servicio_producto_id = $comision['servicio_producto_id'];
                        $config_pago->servicio_producto_tipo = $comision['servicio_producto_tipo'];
                        $config_pago->usuario_id = $staff->id;
                        $config_pago->usuario_tipo = 1;
                        $config_pago->tipo = $comision['tipo'];
                        $config_pago->monto = $comision['monto'];
                        $config_pago->monto_minimo = $comision['monto_minimo'];
                        $config_pago->monto_porcentaje = $comision['monto_porcentaje'];

                        $config_pago->save();
                    }
                }
         
                Session::forget('horarios_staff');
                Session::forget('comisiones');

	        	return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
	           
	        }else{
	            return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
	        }
	    }
    }

    public function operar($id)
    {   
        $staff = Staff::find($id);

        if($staff){
        	return view('configuracion.staff.operacion')->with(['id' => $id, 'staff' => $staff]);   
        }else{
           return redirect("staff"); 
        }     
    }

    public function edit($id)
    {   
        $staff = Staff::join('config_staff', 'staff.cargo', '=', 'config_staff.id')
            ->select('staff.*', 'config_staff.nombre as cargo')
            ->where('staff.id', $id)
        ->first();

        if($staff){

            $dia_de_semana = DiasDeSemana::all();

            $config_staff = ConfigStaff::where('academia_id', Auth::user()->academia_id)->orWhere('academia_id', null)->orderBy('nombre')->get();

            $horarios = HorarioStaff::join('dias_de_semana', 'horarios_staff.dia_de_semana_id', '=', 'dias_de_semana.id')
                ->join('staff', 'horarios_staff.staff_id', '=', 'staff.id')
                ->select('horarios_staff.*', 'dias_de_semana.nombre as dia')
                ->where('staff.id' , $id)
            ->get();

            $comisiones = ConfigComision::where('config_comisiones.usuario_id', $id)
                ->where('config_comisiones.usuario_tipo',1)
            ->get();

            $tmp = array();
            $tmp2 = array();

            $config_servicio=ConfigServicios::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

            foreach($config_servicio as $item){

                $tmp[]=array('id' => '1-'.$item['id'], 'nombre' => $item['nombre'] , 'tipo' => $item['tipo'], 'costo' => $item['costo']);
            }

            $config_producto=ConfigProductos::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

            foreach($config_producto as $item){

                $tmp[]=array('id' => '2-'.$item['id'], 'nombre' => $item['nombre'] , 'tipo' => $item['tipo'], 'costo' => $item['costo']);
               
            }

            foreach($comisiones as $pago){
               
                if($pago->servicio_producto_tipo == 1){
                    $servicio_producto = ConfigServicios::find($pago->servicio_producto_id);
                }else{
                    $servicio_producto = ConfigProductos::find($pago->servicio_producto_id);
                }

                if($servicio_producto){

                    $tmp2[]=array('id' => $pago->id, 'nombre' => $servicio_producto->nombre , 'tipo' => $pago->tipo, 'monto' => $pago->monto, 'monto_porcentaje' => $pago->monto_porcentaje, 'servicio_producto_id' => $pago->servicio_producto_id, 'servicio_producto_tipo' => $pago->servicio_producto_tipo, 'monto_minimo' => $pago->monto_minimo);
                }

            }

            $collection=collect($tmp);   
            $linea_servicio = $collection->toArray();
            $collection=collect($tmp2);   
            $pagos = $collection->toArray();

            $metas = MetaStaff::where('staff_id',$id)->get();

            return view('configuracion.staff.planilla')->with(['alumno' => $staff, 'id' => $id, 'horarios' => $horarios, 'dias_de_semana' => $dia_de_semana, 'config_staff' => $config_staff, 'comisiones' => $pagos,  'linea_servicio' => $linea_servicio, 'metas' => $metas]);
        }else{
           return redirect("/configuracion/staff"); 
        }
    }

    public function updateID(Request $request){

        $rules = [
            'identificacion' => 'required|min:7|numeric',
        ];

        $messages = [
            'identificacion.required' => 'Ups! El identificador es requerido',
            'identificacion.min' => 'El mínimo de numeros permitidos son 5',
            'identificacion.max' => 'El maximo de numeros permitidos son 20',
            'identificacion.numeric' => 'Ups! El identificador es inválido , debe contener sólo números',
            'identificacion.unique' => 'Ups! Ya este usuario ha sido registrado',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
        }else{

            $alumno = Staff::withTrashed()->find($request->id);
            $alumno->identificacion = $request->identificacion;

            if($alumno->save()){

                $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                    ->select('users.id')
                    ->where('usuarios_tipo.tipo_id',$request->id)
                    ->where('usuarios_tipo.tipo',8)
                ->first();

                if($usuario){

                    $usuario->identificacion = $request->identificacion;  

                    if($usuario->save()){

                        $usuarios_tipo = UsuarioTipo::where('usuario_id',$usuario->id)->get();

                        foreach($usuarios_tipo as $tipo_usuario){

                            if($tipo_usuario->tipo == 2 OR $tipo_usuario->tipo == 4){

                                $usuario = Alumno::find($tipo_usuario->tipo_id);

                                if($usuario){

                                    $usuario->identificacion = $request->identificacion;

                                    $usuario->save();

                                     
                                }

                            }else if($tipo_usuario->tipo == 3){

                               $usuario = Instructor::find($tipo_usuario->tipo_id);

                                if($usuario){

                                    $usuario->identificacion = $request->identificacion;

                                    $usuario->save();

                                     
                                } 
                            }else if($tipo_usuario->tipo == 8){

                               $usuario = Staff::find($tipo_usuario->tipo_id);

                                if($usuario){

                                    $usuario->identificacion = $request->identificacion;

                                    $usuario->save();

                                     
                                } 
                            }            
                        }
                        return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                    }else{
                        return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                    }

                }else{
                    return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                }
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateNombre(Request $request){

        $rules = [
            'nombre' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            'apellido' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
        ];

        $messages = [

            'nombre.required' => 'Ups! El Nombre  es requerido ',
            'nombre.min' => 'El mínimo de caracteres permitidos son 3',
            'nombre.max' => 'El máximo de caracteres permitidos son 20',
            'nombre.regex' => 'Ups! El nombre es inválido ,debe ingresar sólo letras',
            'apellido.required' => 'Ups! El Apellido  es requerido ',
            'apellido.min' => 'El mínimo de caracteres permitidos son 3',
            'apellido.max' => 'El máximo de caracteres permitidos son 20',
            'apellido.regex' => 'Ups! El apellido es inválido , debe ingresar sólo letras',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }
        $alumno = Staff::withTrashed()->find($request->id);


        $nombre = title_case($request->nombre);
        $apellido = title_case($request->apellido);


        $alumno->nombre = $nombre;
        $alumno->apellido = $apellido;

        if($alumno->save()){

            
        	$usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->select('users.id')
                ->where('usuarios_tipo.tipo_id',$request->id)
                ->where('usuarios_tipo.tipo',8)
            ->first();

            if($usuario){

                $usuario->nombre = $nombre;
                $usuario->apellido = $apellido;

                if($usuario->save()){

                    $usuarios_tipo = UsuarioTipo::where('usuario_id',$usuario->id)->get();

                    foreach($usuarios_tipo as $tipo_usuario){

                        if($tipo_usuario->tipo == 2 OR $tipo_usuario->tipo == 4){

                            $usuario = Alumno::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->nombre = $nombre;
                                $usuario->apellido = $apellido;

                                $usuario->save();

                                 
                            }

                        }else if($tipo_usuario->tipo == 3){

                           $usuario = Instructor::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->nombre = $nombre;
                                $usuario->apellido = $apellido;

                                $usuario->save();

                                 
                            } 
                        }else if($tipo_usuario->tipo == 8){

                           $usuario = Staff::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->nombre = $nombre;
                                $usuario->apellido = $apellido;

                                $usuario->save();

                                 
                            } 
                        }            
                    }
                    return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }

            }else{
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }
            
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateFecha(Request $request){


        $alumno = Staff::withTrashed()->find($request->id);
        $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->toDateString();
        $alumno->fecha_nacimiento = $fecha_nacimiento;

        if($alumno->save()){

            $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->select('users.id')
                ->where('usuarios_tipo.tipo_id',$request->id)
                ->where('usuarios_tipo.tipo',8)
            ->first();

            if($usuario){

                $usuario->fecha_nacimiento = $fecha_nacimiento;  

                if($usuario->save()){

                    $usuarios_tipo = UsuarioTipo::where('usuario_id',$usuario->id)->get();

                    foreach($usuarios_tipo as $tipo_usuario){

                        if($tipo_usuario->tipo == 2 OR $tipo_usuario->tipo == 4){

                            $usuario = Alumno::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->fecha_nacimiento = $fecha_nacimiento;

                                $usuario->save();

                                 
                            }

                        }else if($tipo_usuario->tipo == 3){

                           $usuario = Instructor::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->fecha_nacimiento = $fecha_nacimiento;

                                $usuario->save();

                                 
                            } 
                        }else if($tipo_usuario->tipo == 8){

                           $usuario = Staff::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->fecha_nacimiento = $fecha_nacimiento;

                                $usuario->save();

                                 
                            } 
                        }            
                    }
                    return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }

            }else{
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    public function updateSexo(Request $request){

        $alumno = Staff::withTrashed()->find($request->id);
        $alumno->sexo = $request->sexo;

        if($alumno->save()){

        	$usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->select('users.id')
                ->where('usuarios_tipo.tipo_id',$request->id)
                ->where('usuarios_tipo.tipo',8)
            ->first();

            if($usuario){

                $usuario->sexo = $request->sexo; 

                if($usuario->save()){

                    $usuarios_tipo = UsuarioTipo::where('usuario_id',$usuario->id)->get();

                    foreach($usuarios_tipo as $tipo_usuario){

                        if($tipo_usuario->tipo == 2 OR $tipo_usuario->tipo == 4){

                            $usuario = Alumno::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->sexo = $request->sexo;

                                $usuario->save();

                                 
                            }

                        }else if($tipo_usuario->tipo == 3){

                           $usuario = Instructor::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->sexo = $request->sexo;

                                $usuario->save();

                                 
                            } 
                        }else if($tipo_usuario->tipo == 8){

                           $usuario = Staff::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->sexo = $request->sexo;

                                $usuario->save();

                                 
                            } 
                        }            
                    }
                    return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }

            }else{
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }
            
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateCorreo(Request $request){

        $rules = [
            'correo' => 'required|email|max:255|unique:users,email',
        ];

        $messages = [
            'correo.required' => 'Ups! El correo es requerido',
            'correo.email' => 'Ups! El correo tiene una dirección inválida',
            'correo.max' => 'El máximo de caracteres permitidos son 255',
            'correo.unique' => 'Ups! Ya este correo ha sido registrado',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $alumno = Staff::withTrashed()->find($request->id);
            $correo = strtolower($request->correo);
            $alumno->correo = $correo;

            if($alumno->save()){

                $usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                    ->select('users.id')
                    ->where('usuarios_tipo.tipo_id',$request->id)
                    ->where('usuarios_tipo.tipo',8)
                ->first();

                if($usuario){

                    $usuario->email = $correo; 

                    if($usuario->save()){

                        $usuarios_tipo = UsuarioTipo::where('usuario_id',$usuario->id)->get();

                        foreach($usuarios_tipo as $tipo_usuario){

                            if($tipo_usuario->tipo == 2 OR $tipo_usuario->tipo == 4){

                                $usuario = Alumno::find($tipo_usuario->tipo_id);

                                if($usuario){

                                    $usuario->correo = $correo;

                                    $usuario->save();

                                     
                                }

                            }else if($tipo_usuario->tipo == 3){

                               $usuario = Instructor::find($tipo_usuario->tipo_id);

                                if($usuario){

                                    $usuario->correo = $correo;

                                    $usuario->save();

                                     
                                } 
                            }else if($tipo_usuario->tipo == 8){

                               $usuario = Staff::find($tipo_usuario->tipo_id);

                                if($usuario){

                                    $usuario->correo = $correo;

                                    $usuario->save();

                                     
                                } 
                            }            
                        }
                        return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                    }else{
                        return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                    }

                }else{
                    return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                }
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
            }
        }
    }

    public function updateTelefono(Request $request){

        $alumno = Staff::withTrashed()->find($request->id);
        $alumno->telefono = $request->telefono;
        $alumno->celular = $request->celular;

        if($alumno->save()){
           
        	$usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->select('users.id')
                ->where('usuarios_tipo.tipo_id',$request->id)
                ->where('usuarios_tipo.tipo',8)
            ->first();

            if($usuario){

                $usuario->telefono = $request->telefono;
                $usuario->celular = $request->celular;

                if($usuario->save()){

                    $usuarios_tipo = UsuarioTipo::where('usuario_id',$usuario->id)->get();

                    foreach($usuarios_tipo as $tipo_usuario){

                        if($tipo_usuario->tipo == 2 OR $tipo_usuario->tipo == 4){

                            $usuario = Alumno::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->telefono = $request->telefono;
                                $usuario->celular = $request->celular;

                                $usuario->save();

                                 
                            }

                        }else if($tipo_usuario->tipo == 3){

                           $usuario = Instructor::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->telefono = $request->telefono;
                                $usuario->celular = $request->celular;

                                $usuario->save();

                                 
                            } 
                        }else if($tipo_usuario->tipo == 8){

                           $usuario = Staff::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->telefono = $request->telefono;
                                $usuario->celular = $request->celular;

                                $usuario->save();

                                 
                            } 
                        }            
                    }
                    return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }

            }else{
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }
        

        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateDireccion(Request $request){

        $alumno = Staff::withTrashed()->find($request->id);

        $direccion = $request->direccion;

        $alumno->direccion = $direccion;
        
        if($alumno->save()){


        	$usuario = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                ->select('users.id')
                ->where('usuarios_tipo.tipo_id',$request->id)
                ->where('usuarios_tipo.tipo',8)
            ->first();

            if($usuario){

                $usuario->direccion = $direccion;  

                if($usuario->save()){

                    $usuarios_tipo = UsuarioTipo::where('usuario_id',$usuario->id)->get();

                    foreach($usuarios_tipo as $tipo_usuario){

                        if($tipo_usuario->tipo == 2 OR $tipo_usuario->tipo == 4){

                            $usuario = Alumno::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->direccion = $direccion;

                                $usuario->save();

                                 
                            }

                        }else if($tipo_usuario->tipo == 3){

                           $usuario = Instructor::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->direccion = $direccion;

                                $usuario->save();

                                 
                            } 
                        }else if($tipo_usuario->tipo == 8){

                           $usuario = Staff::find($tipo_usuario->tipo_id);

                            if($usuario){

                                $usuario->direccion = $direccion;

                                $usuario->save();

                                 
                            } 
                        }            
                    }
                    return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }

            }else{
                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            }
            

        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateCargo(Request $request){

        $rules = [
            'cargo' => 'required',
        ];

        $messages = [

            'cargo.required' => 'Ups! El Cargo  es requerido ',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        $alumno = Staff::withTrashed()->find($request->id);
        $cargo = title_case($request->cargo);

        $alumno->cargo = $cargo;

        if($alumno->save()){
     
        	return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateHorario(Request $request){

        $rules = [
            'hora_inicio' => 'required',
        	'hora_final' => 'required',
        ];

        $messages = [

            'hora_inicio.required' => 'Ups! La hora de inicio es requerida',
        	'hora_final.required' => 'Ups! La hora final es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        $academia = Academia::find(Auth::user()->academia_id);

        if($academia->tipo_horario == 2){
            $hora_inicio = Carbon::createFromFormat('H:i',$request->hora_inicio)->toTimeString();
            $hora_final = Carbon::createFromFormat('H:i',$request->hora_final)->toTimeString();
        }else{
            $hora_inicio = Carbon::createFromFormat('H:i a',$request->hora_inicio)->toTimeString();
            $hora_final = Carbon::createFromFormat('H:i a',$request->hora_final)->toTimeString();
        }

        if($hora_inicio > $hora_final){
            return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
        }

        $alumno = Staff::withTrashed()->find($request->id);

        $alumno->hora_inicio = $hora_inicio;
        $alumno->hora_final = $hora_final;

        if($alumno->save()){
     
        	return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
            
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function agregar_horario_fijo(Request $request){
        
        $rules = [

            'dia_de_semana_id' => 'required',
            'hora_inicio' => 'required',
            'hora_final' => 'required',
        ];

        $messages = [

            'dia_de_semana_id.required' => 'Ups! El Dia es requerido',
            'hora_inicio.required' => 'Ups! La hora de inicio es requerida',
            'hora_final.required' => 'Ups! La hora final es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $horario = HorarioStaff::where('staff_id',$request->id)->where('dia_de_semana_id',$request->dia_de_semana_id)->first();

            if(!$horario){

                $academia = Academia::find(Auth::user()->academia_id);

                if($academia->tipo_horario == 2){
                    $hora_inicio = Carbon::createFromFormat('H:i',$request->hora_inicio)->toTimeString();
                    $hora_final = Carbon::createFromFormat('H:i',$request->hora_final)->toTimeString();
                }else{
                    $hora_inicio = Carbon::createFromFormat('H:i a',$request->hora_inicio)->toTimeString();
                    $hora_final = Carbon::createFromFormat('H:i a',$request->hora_final)->toTimeString();
                }

                if($hora_inicio > $hora_final){
                    return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
                }

                $horario = new HorarioStaff;

                $horario->staff_id = $request->id;                   
                $horario->dia_de_semana_id = $request->dia_de_semana_id;
                $horario->hora_inicio = $hora_inicio;
                $horario->hora_final = $hora_final;

                if($horario->save()){

                    $dia_de_semana = DiasDeSemana::find($request->dia_de_semana_id);

                    $array=array('dia_de_semana' => $dia_de_semana->nombre, 'hora_inicio' => $request->hora_inicio , 'hora_final' => $request->hora_final);

                    return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'id' => $horario->id, 200]);
                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }
            }else{
                return response()->json(['errores' => ['dia_de_semana_id' => [0, 'Ups! Ya posee un horario configurado para este día']], 'status' => 'ERROR'],422);
            }
        }
    }

    public function eliminar_horario_fijo($id){

        $horario = HorarioStaff::find($id);

        if($horario->delete()){
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

    public function agregar_horario(Request $request){

        
    $rules = [

        'dia_de_semana_id' => 'required',
        'hora_inicio' => 'required',
        'hora_final' => 'required',
    ];

    $messages = [

        'dia_de_semana_id.required' => 'Ups! El Dia es requerido',
        'hora_inicio.required' => 'Ups! La hora de inicio es requerida',
        'hora_final.required' => 'Ups! La hora final es requerida',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{

        $academia = Academia::find(Auth::user()->academia_id);

        if($academia->tipo_horario == 2){
            $hora_inicio = Carbon::createFromFormat('H:i',$request->hora_inicio)->toTimeString();
            $hora_final = Carbon::createFromFormat('H:i',$request->hora_final)->toTimeString();
        }else{
            $hora_inicio = Carbon::createFromFormat('H:i a',$request->hora_inicio)->toTimeString();
            $hora_final = Carbon::createFromFormat('H:i a',$request->hora_final)->toTimeString();
        }

        if($hora_inicio > $hora_final){
            return response()->json(['errores' => ['hora_inicio' => [0, 'Ups! La hora de inicio es mayor a la hora final']], 'status' => 'ERROR'],422);
        }

        $horarios = Session::get('horarios_staff');

        if($horarios){
            foreach ($horarios as $horario) {
                if($horario['dia_de_semana_id'] == $request->dia_de_semana_id){
                    return response()->json(['errores' => ['dia_de_semana_id' => [0, 'Ups! Ya posee un horario configurado para este día']], 'status' => 'ERROR'],422);
                }

            }
        }

        $dia_de_semana = DiasDeSemana::find($request->dia_de_semana_id);
        $array=array('dia_de_semana_id' => $request->dia_de_semana_id, 'dia_de_semana' => $dia_de_semana->nombre, 'hora_inicio' => $request->hora_inicio , 'hora_final' => $request->hora_final);

        Session::push('horarios_staff', $array);

        $item = Session::get('horarios_staff');
        end( $item );
        $contador = key( $item );

         return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 'id' => $contador, 200]);

        }
    }

    public function eliminar_horario($id){

        $arreglo = Session::get('horarios_staff');

        unset($arreglo[$id]);
        Session::put('horarios_staff', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }

    public function destroy($id)
    {
        
        $staff = Staff::withTrashed()->find($id);

        if($staff->correo){

            $usuario = User::where('email',$staff->correo)->first();

            if($usuario){

                $usuario_tipo = UsuarioTipo::where('tipo',8)
                    ->where('usuario_id',$usuario->id)
                ->first();

                if($usuario_tipo){
                    $usuario_tipo->delete();
                }
            }
        }
        
        if($staff->delete()){
            return response()->json(['mensaje' => '¡Excelente! El staff ha sido eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function agregarpago(Request $request)
    {
        
        $rules = [
            'monto' => 'required|min:1',
            'tipo_pago' => 'required'
        ];

        $messages = [

            'monto.required' => 'Ups! El Monto es requerido',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $monto = floatval(str_replace(',', '', $request->monto));

            if($request->tipo_pago == 1){
                if($monto > 100){
                    return response()->json(['errores' => ['monto' => [0, 'Ups! El porcentaje no puede ser mayor a 100']], 'status' => 'ERROR'],422);
                }
            }

            $array = array();

            if($request->monto_minimo){

                $monto_minimo = floatval(str_replace(',', '', $request->monto_minimo));

            }else{
                $monto_minimo = '';
            }

            if($request->servicio_producto_id != 'null'){

                $explode = explode(",", $request->servicio_producto_id);

                foreach($explode as $id){

                    $tmp = explode('-',$id);
                    $servicio_producto_id = $tmp[0];
                    $servicio_producto_tipo = $tmp[1];

                    if($servicio_producto_tipo == 1){
                        $servicio_producto = ConfigServicios::withTrashed()->find($servicio_producto_id);
                    }else{
                        $servicio_producto = ConfigProductos::withTrashed()->find($servicio_producto_id);
                    }

                    if($monto  > $servicio_producto->costo){
                        return response()->json(['errores' => ['monto' => [0, 'Ups! La comisión no puede ser mayor al costo']], 'status' => 'ERROR'],422);
                    }

                    if($monto_minimo  > $servicio_producto->costo){
                        return response()->json(['errores' => ['monto_minimo' => [0, 'Ups! El monto mínimo no puede ser mayor al costo']], 'status' => 'ERROR'],422);
                    }

                    if($request->tipo_pago == 1){
                        $porcentaje = $monto / 100;
                        $monto_porcentaje = $servicio_producto->costo * $porcentaje;
                    }else{
                        $monto_porcentaje = '';
                    }

                    $config_pagos=array('servicio_producto_id' => $servicio_producto_id, 'tipo' => $request->tipo_pago, 'monto' => $monto , 'servicio_producto_tipo' => $servicio_producto_tipo, 'nombre' => $servicio_producto->nombre, 'monto_minimo' => $monto_minimo, 'monto_porcentaje' => $monto_porcentaje, 'servicio_producto_costo' => $servicio_producto->costo);

                    Session::push('comisiones', $config_pagos);

                    $item = Session::get('comisiones');
                    end( $item );
                    $contador = key( $item );

                    $config_pagos['id'] = $contador;

                    array_push($array, $config_pagos);


                }

            }else{

                $servicios = ConfigServicios::where('academia_id', Auth::user()->academia_id)
                    ->get();

                foreach($servicios as $servicio){

                    if($request->tipo_pago == 1){
                        $porcentaje = $monto / 100;
                        $monto_porcentaje = $servicio->costo * $porcentaje;
                    }else{
                        $monto_porcentaje = '';
                    }

                    $config_pagos=array('servicio_producto_id' => $servicio->id, 'tipo' => $request->tipo_pago, 'monto' => $monto , 'servicio_producto_tipo' => $servicio->tipo, 'nombre' => $servicio->nombre, 'monto_minimo' => $monto_minimo, 'monto_porcentaje' => $monto_porcentaje,'servicio_producto_costo' => $servicio->costo);

                    Session::push('comisiones', $config_pagos);

                    $item = Session::get('comisiones');
                    end( $item );
                    $contador = key( $item );

                    $config_pagos['id'] = $contador.'-'.$tipo_servicio;

                    array_push($array, $config_pagos);


                }

                $productos = ConfigProductos::where('academia_id', Auth::user()->academia_id)
                    ->get();

                foreach($productos as $producto){

                    if($request->tipo_pago == 1){
                        $porcentaje = $monto / 100;
                        $monto_porcentaje = $producto->costo * $porcentaje;
                    }else{
                        $monto_porcentaje = '';
                    }

                    $config_pagos=array('servicio_producto_id' => $producto->id, 'tipo' => $request->tipo_pago, 'monto' => $monto , 'servicio_producto_tipo' => $producto->tipo, 'nombre' => $producto->nombre, 'monto_minimo' => $monto_minimo, 'monto_porcentaje' => $monto_porcentaje, 'servicio_producto_costo' => $producto->costo);

                    Session::push('comisiones', $config_pagos);

                    $item = Session::get('comisiones');
                    end( $item );
                    $contador = key( $item );

                    $config_pagos['id'] = $contador.'-'.$tipo_servicio;

                    array_push($array, $config_pagos);


                }

            }

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 200]);   
        }
    }

    public function eliminarpago($id){

        $arreglo = Session::get('comisiones');

        $tmp = explode('-',$id);
        $servicio_producto_id = $tmp[0];

        unset($arreglo[$servicio_producto_id]);
        Session::put('comisiones', $arreglo);

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);

    }
      

    public function agregarpagofijo(Request $request)
    {
        
        $rules = [
            'monto' => 'required|min:1',
            'tipo_pago' => 'required',
            'servicio_producto_id' => 'required',
        ];

        $messages = [

            'monto.required' => 'Ups! El Monto es requerido',
            'monto.numeric' => 'Ups! El Monto es invalido, solo se aceptan numeros',
            'servicio_producto_id.required' => 'Ups! El Servicio es requerido',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $explode = explode('-',$request->servicio_producto_id);

            $servicio_producto_tipo = $explode[0];
            $servicio_producto_id = $explode[1];
            $monto = floatval(str_replace(',', '', $request->monto));

            if($servicio_producto_tipo == 1){
                $servicio_producto = ConfigServicios::withTrashed()->find($servicio_producto_id);
            }else{
                $servicio_producto = ConfigProductos::withTrashed()->find($servicio_producto_id);
            }

            if($request->tipo_pago == 1){
                if($monto > 100){
                    return response()->json(['errores' => ['monto' => [0, 'Ups! El porcentaje no puede ser mayor a 100']], 'status' => 'ERROR'],422);
                }
            }

            if($request->servicio_producto_id == '0-0' || !$request->servicio_producto_id){
                return response()->json(['errores' => ['servicio_producto_id' => [0, 'Ups! Debe seleccionar un servicio']], 'status' => 'ERROR'],422);
            }

            if($monto  > $servicio_producto->costo){
                return response()->json(['errores' => ['monto' => [0, 'Ups! La comisión no puede ser mayor al costo']], 'status' => 'ERROR'],422);
            }

            if($request->monto_minimo){

                $monto_minimo = floatval(str_replace(',', '', $request->monto_minimo));

                if($monto_minimo  > $servicio_producto->costo){
                    return response()->json(['errores' => ['monto_minimo' => [0, 'Ups! El monto mínimo no puede ser mayor al costo']], 'status' => 'ERROR'],422);
                }
            }else{
                $monto_minimo = '';
            }

            $array = array();

            $config_pagos = ConfigComision::where('usuario_id', $request->id)
                ->where('usuario_tipo',1)
                ->where('servicio_producto_id', $servicio_producto_id)
                ->where('servicio_producto_tipo', $servicio_producto_tipo)
            ->first();

            if(!$config_pagos){
                $config_pagos = new ConfigComision;
            }

            if($request->tipo_pago == 1){
                $porcentaje = $monto / 100;
                $monto_porcentaje = $servicio_producto->costo * $porcentaje;
            }else{
                $monto_porcentaje = '';
            }

            $config_pagos->servicio_producto_id = $servicio_producto_id;
            $config_pagos->servicio_producto_tipo = $servicio_producto_tipo;
            $config_pagos->usuario_id = $request->id;
            $config_pagos->usuario_tipo = 1;
            $config_pagos->tipo = $request->tipo_pago;
            $config_pagos->monto = $monto;
            $config_pagos->monto_porcentaje = $monto_porcentaje;
            $config_pagos->monto_minimo = $monto_minimo;

            $config_pagos->save();
            
            $config_pagos['nombre'] = $servicio_producto->nombre;

            array_push($array, $config_pagos);

            // if($request->servicio_id != 'null'){

            //     $servicios = explode(",", $request->servicio_id);

            //     foreach($servicios as $servicio){

            //         $tmp = explode('-',$servicio);
            //         $servicio_id = $tmp[0];
            //         $tipo_servicio = $tmp[1];

            //         $posee_pago = ConfigPagosStaff::where('staff_id', $request->id)
            //             ->where('servicio_id', $servicio_id)
            //         ->first();


            //         if(!$posee_pago){

            //             $monto = floatval(str_replace(',', '', $request->cantidad));
            //             $servicio = ConfigServicios::find($servicio_id);

            //             if($monto  > $servicio->costo){
            //                 return response()->json(['errores' => ['cantidad' => [0, 'Ups! La comisión no puede ser mayor al costo']], 'status' => 'ERROR'],422);
            //             }

            //             $config_pagos = new ConfigPagosStaff;

            //             $config_pagos->servicio_id = $servicio_id;
            //             $config_pagos->staff_id = $request->id;
            //             $config_pagos->tipo = $request->tipo_pago;
            //             $config_pagos->monto = $monto;
            //             $config_pagos->tipo_servicio = $tipo_servicio;

            //             $config_pagos->save();

            //             if($config_pagos->tipo == 1){
            //                 $porcentaje = $config_pagos->monto / 100;
            //                 $monto_porcentaje = $servicio->costo * $porcentaje;
            //             }else{
            //                 $monto_porcentaje = '';
            //             }
                        
            //             $config_pagos['monto_porcentaje'] = $monto_porcentaje;
            //             $config_pagos['nombre'] = $servicio->nombre;

            //             array_push($array, $config_pagos);


            //         }

            //     }


            // }else{

            //     $servicios = ConfigServicios::where('academia_id', Auth::user()->academia_id)
            //         ->get();

            //     foreach($servicios as $servicio){

            //         $posee_pago = ConfigPagosStaff::where('staff_id', $request->id)
            //             ->where('servicio_id', $servicio)
            //         ->first();

            //         if(!$posee_pago){

            //             $monto = floatval(str_replace(',', '', $request->cantidad));

            //             $servicio = ConfigServicios::find($servicio_id);

            //             if($monto  > $servicio->costo){
            //                 return response()->json(['errores' => ['cantidad' => [0, 'Ups! La comisión no puede ser mayor al costo']], 'status' => 'ERROR'],422);
            //             }

            //             $config_pagos = new ConfigPagosStaff;

            //             $config_pagos->servicio_id = $servicio;
            //             $config_pagos->staff_id = $request->id;
            //             $config_pagos->tipo = $request->tipo_pago;
            //             $config_pagos->monto = $monto;

            //             $config_pagos->save();

                        

            //             if($config_pagos->tipo == 1){
            //                 $porcentaje = $config_pagos->monto / 100;
            //                 $monto_porcentaje = $servicio->costo * $porcentaje;
            //             }else{
            //                 $monto_porcentaje = '';
            //             }
                        
            //             $config_pagos['monto_porcentaje'] = $monto_porcentaje;
            //             $config_pagos['nombre'] = $servicio->nombre;

            //             array_push($array, $config_pagos);


            //         }

            //     }

            // }

            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $array, 200]);   
        }
    }

    public function eliminarpagofijo($id)
    {

        $comision_explode = explode('-',$id);
        $comision_id = $comision_explode[0];

        $comision = ConfigComision::find($comision_id);
        
        if($comision->delete()){

            return response()->json(['mensaje' => '¡Excelente! El alumno ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
        // return redirect("alumno");
    }

    public function principalpagos($id)
    {

        $staff = Staff::find($id);

        if($staff)
        {

            $comisiones = Comision::join('staff', 'comisiones.usuario_id', '=', 'staff.id')
                ->select('comisiones.*', 'comisiones.hora','staff.nombre as nombre_staff', 'staff.apellido as apellido_staff')
                ->where('comisiones.usuario_id', $id)
                ->where('comisiones.usuario_tipo',1)
                ->limit(100)
            ->get();

            $array = array();

            foreach($comisiones as $comision){

                if($comision->servicio_producto_tipo == 1){
                    $servicio_producto = ConfigServicios::find($comision->servicio_producto_id);
                }else{
                    $servicio_producto = ConfigProductos::find($comision->servicio_producto_id);
                }

                if($servicio_producto){

                    if($comision->cliente_tipo == 1){
                        $usuario = Alumno::find($comision->cliente_id);
                    }else{
                        $usuario = Staff::find($comision->cliente_id);
                    }

                    if($usuario){
                        $cliente = $usuario->nombre . ' ' . $usuario->apellido;
                    }else{
                        $cliente = '';
                    }

                    $fecha = Carbon::createFromFormat('Y-m-d', $comision->fecha);
                    $i = $fecha->dayOfWeek;

                    if($i == 1){

                        $dia = 'Lunes';

                    }else if($i == 2){

                        $dia = 'Martes';

                    }else if($i == 3){

                        $dia = 'Miercoles';

                    }else if($i == 4){

                        $dia = 'Jueves';

                    }else if($i == 5){

                        $dia = 'Viernes';

                    }else if($i == 6){

                        $dia = 'Sabado';

                    }else if($i == 0){

                        $dia = 'Domingo';

                    }

                    $collection=collect($comision);     
                    $comision_array = $collection->toArray();
                    
                    $comision_array['servicio_producto']=$servicio_producto->nombre;
                    $comision_array['dia']=$dia;
                    $comision_array['cliente']=$cliente;
                    $array[$comision->id] = $comision_array;
                }
            }

            $total = Comision::where('usuario_id', $id)
                ->where('usuario_tipo',1)
                ->where('boolean_pago', 0)
            ->sum('monto');

            $usuario_tipo = Session::get('easydance_usuario_tipo');

            return view('configuracion.staff.pagos')->with(['comisiones'=> $array, 'total' => $total, 'staff' => $staff, 'id' => $id, 'usuario_tipo' => $usuario_tipo]);
        }else{ 

            return redirect("configuracion/staff"); 
        }
    }

    public function pagar(Request $request)
    {
        $rules = [
            'pagos' => 'required',
        ];

        $messages = [

            'pagos.required' => 'Ups! Debe seleccionar un pago',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){


            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{
        
            $pagos = explode(",", $request->pagos);
            $array = array();

            foreach($pagos as $pago_staff)
            {
                if($pago_staff != ''){

                    $pago = Comision::find($pago_staff);
                    $pago->boolean_pago = 1;
                    $pago->fecha = Carbon::now()->toDateString();
                    $pago->hora = Carbon::now()->toTimeString();

                    $pago->save();

                    array_push($array,$pago_staff);

                }
            }


            return response()->json(['mensaje' => '¡Excelente! El pago ha sido realizado satisfactoriamente', 'status' => 'OK', 'array' => $array, 200]);

        }
    }

    public function principalmetas($id)
    {

        $staff = Staff::find($id);

        if($staff){

            $metas = MetaStaff::where('staff_id',$id)->get();
            $academia = Academia::find(Auth::user()->academia_id);

            if($academia->dias_recompra){
                $dias_recompra = $academia->dias_recompra;
            }else{
                $dias_recompra = 90;
            }

            $array = array();

            foreach($metas as $meta){

                if($meta->servicio_id == 1){
                    $total = 0;
                    $facturas = ItemsFactura::join('facturas', 'items_factura.factura_id', '=', 'facturas.id')
                        ->select('items_factura.*', 'facturas.usuario_id')
                        ->where('items_factura.tipo_promotor',1)
                        ->where('items_factura.promotor_id',$id)
                        ->where('items_factura.servicio_producto',1)
                        ->where('items_factura.tipo',3)
                    ->get();

                    foreach($facturas as $factura){

                        $factura_before = ItemsFactura::join('facturas', 'items_factura.factura_id', '=', 'facturas.id')
                            ->where('items_factura.tipo_promotor',1)
                            ->where('items_factura.promotor_id',$id)
                            ->where('items_factura.servicio_producto',1)
                            ->where('items_factura.tipo',3)
                            ->where('items_factura.id','!=',$factura->id)
                            ->where('items_factura.created_at','<',$factura->created_at)
                        ->first(); 

                        if(!$factura_before){
                            $total += $factura->importe_neto;
                        }
                    }

                    $porcentaje = intval(($total / $meta->monto) * 100);
                    
                    $collection=collect($meta);     
                    $meta_array = $collection->toArray();
                    
                    $meta_array['nombre']='Inscripción';

                }else if($meta->servicio_id == 2){

                    $total = 0;
                    $facturas = ItemsFactura::join('facturas', 'items_factura.factura_id', '=', 'facturas.id')
                        ->select('items_factura.*', 'facturas.usuario_id')
                        ->where('items_factura.tipo_promotor',1)
                        ->where('items_factura.promotor_id',$id)
                        ->where('items_factura.servicio_producto',1)
                        ->where('items_factura.tipo',3)
                    ->get();

                    foreach($facturas as $factura){

                        $factura_before = ItemsFactura::join('facturas', 'items_factura.factura_id', '=', 'facturas.id')
                            ->where('items_factura.tipo_promotor',1)
                            ->where('items_factura.promotor_id',$id)
                            ->where('items_factura.servicio_producto',1)
                            ->where('items_factura.tipo',3)
                            ->where('items_factura.id','!=',$factura->id)
                            ->where('items_factura.created_at','<',$factura->created_at)
                        ->first(); 

                        if($factura_before){
                            $total += $factura->importe_neto;
                        }
                    }

                    $porcentaje = intval(($total / $meta->monto) * 100);

                    $collection=collect($meta);     
                    $meta_array = $collection->toArray();
                    
                    $meta_array['nombre']='Recompra';

                }else{

                    $total = ItemsFactura::where('tipo_promotor',1)->where('promotor_id',$id)->where('servicio_producto',1)->where('tipo',9)->sum('importe_neto');

                    $porcentaje = intval(($total / $meta->monto) * 100);
                    
                    $collection=collect($meta);     
                    $meta_array = $collection->toArray();
                    
                    $meta_array['nombre']='Clases Personalizadas';

                }

                $meta_array['total']=$total;
                $meta_array['porcentaje']=$porcentaje;
                $array[$meta->id] = $meta_array;
            }

            return view('configuracion.staff.metas')->with(['id' => $id, 'metas' => $array]);
        }else{ 

            return redirect("configuracion/staff"); 
        }
    }

    public function agregar_meta(Request $request){
        
        $rules = [
            'servicio_id' => 'required',
            'monto_meta' => 'required',
        ];

        $messages = [

            'servicio_id.required' => 'Ups! El Servicio es requerido',
            'monto_meta.required' => 'Ups! El monto es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){

            return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

        }

        else{

            $meta = MetaStaff::where('staff_id',$request->id)->where('servicio_id',$request->servicio_id)->first();

            if(!$meta){

                $monto = floatval(str_replace(',', '', $request->monto_meta));

                $meta = new MetaStaff;

                $meta->staff_id = $request->id;                   
                $meta->servicio_id = $request->servicio_id;
                $meta->monto = $monto;

                if($meta->save()){

                    return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'array' => $meta, 'id' => $meta->id, 200]);
                }else{
                    return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
                }

            }else{
                return response()->json(['errores' => ['servicio_id' => [0, 'Ups! Ya posee una meta configurada para este servicio']], 'status' => 'ERROR'],422);
            }          
        }
    }

    public function eliminar_meta($id){

        $meta = MetaStaff::find($id);

        if($meta->delete()){
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }

    }

}