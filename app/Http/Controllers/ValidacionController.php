<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Codigo;
use App\Visitante;
use App\Taller;
use App\ClaseGrupal;
use App\InscripcionClaseGrupal;
use App\InscripcionTaller;
use App\ItemsFacturaProforma;
use App\Alumno;
use App\Instructor;
use App\Participante;
use App\Reservacion;
use App\User;
use App\UsuarioTipo;
use Redirect;
use Illuminate\Support\Facades\View;

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
        if($request->validar == 'reservacion'){

            $codigo = Codigo::where('codigo_validacion', trim($request->codigo_validacion))->first();

            if($codigo){

                $fecha_limite = $codigo->fecha_vencimiento;

                if(Carbon::now() < $fecha_limite){

                    if($codigo->tipo == 2)
                    {
                        $reservacion = Reservacion::withTrashed()->find($codigo->item_id);

                        if($reservacion->tipo_usuario == 1){

                            $alumno = Alumno::withTrashed()->find($reservacion->tipo_usuario_id);

                        }else if($reservacion->tipo_usuario == 2){

                            $visitante = Visitante::withTrashed()->find($reservacion->tipo_usuario_id);
                            $alumno = Alumno::withTrashed()->where('correo',$visitante->correo)->first();

                            if(!$alumno){

                                do{
                                    $codigo_referido = str_random(8);
                                    $find = Alumno::where('codigo_referido', $codigo_referido)->first();
                                }while ($find);

                                $alumno = new Alumno;

                                $alumno->academia_id = $visitante->academia_id;
                                $alumno->nombre = $visitante->nombre;
                                $alumno->apellido = $visitante->apellido;
                                $alumno->sexo = $visitante->sexo;
                                $alumno->correo = $visitante->correo;
                                $alumno->telefono = $visitante->telefono;
                                $alumno->celular = $visitante->celular;
                                $alumno->fecha_nacimiento = $visitante->fecha_nacimiento;
                                $alumno->direccion = $visitante->direccion;
                                $alumno->codigo_referido = $codigo_referido;

                                if($alumno->save()){

                                    if($alumno->correo){

                                        $password = str_random(8);

                                        $usuario = new User;

                                        $usuario->academia_id = $visitante->academia_id;
                                        $usuario->nombre = $alumno->nombre;
                                        $usuario->apellido = $alumno->apellido;
                                        $usuario->telefono = $alumno->telefono;
                                        $usuario->celular = $alumno->celular;
                                        $usuario->sexo = $alumno->sexo;
                                        $usuario->email = $alumno->correo;
                                        $usuario->como_nos_conociste_id = 1;
                                        $usuario->direccion = $alumno->direccion;
                                        $usuario->confirmation_token = str_random(40);
                                        $usuario->password = bcrypt($password);
                                        $usuario->usuario_id = $alumno->id;
                                        $usuario->usuario_tipo = 2;

                                        $usuario->save();

                                        $usuario_tipo = new UsuarioTipo;
                                        $usuario_tipo->usuario_id = $usuario->id;
                                        $usuario_tipo->tipo = 2;
                                        $usuario_tipo->tipo_id = $alumno->id;
                                        $usuario_tipo->save();

                                    }

                                }
                            }

                            $visitante->cliente = 1;
                            $visitante->save();

                        }else{

                            $participante = Participante::find($reservacion->tipo_usuario_id);
                            $alumno = Alumno::withTrashed()->where('correo',$participante->correo)->first();

                            if(!$alumno){

                                do{
                                    $codigo_referido = str_random(8);
                                    $find = Alumno::where('codigo_referido', $codigo_referido)->first();
                                }while ($find);

                                $alumno = new Alumno;

                                $alumno->academia_id = Auth::user()->academia_id;
                                $alumno->nombre = $participante->nombre;
                                $alumno->apellido = $participante->apellido;
                                $alumno->sexo = $participante->sexo;
                                $alumno->correo = $participante->correo;
                                $alumno->telefono = $participante->telefono;
                                $alumno->celular = $participante->celular;
                                $alumno->fecha_nacimiento = Carbon::now()->toDateString();
                                $alumno->direccion = '';
                                $alumno->codigo_referido = $codigo_referido;

                                if($alumno->save()){

                                    if($alumno->correo){

                                        $password = str_random(8);

                                        $usuario = new User;

                                        $usuario->academia_id = Auth::user()->academia_id;
                                        $usuario->nombre = $alumno->nombre;
                                        $usuario->apellido = $alumno->apellido;
                                        $usuario->telefono = $alumno->telefono;
                                        $usuario->celular = $alumno->celular;
                                        $usuario->sexo = $alumno->sexo;
                                        $usuario->email = $alumno->correo;
                                        $usuario->como_nos_conociste_id = 1;
                                        $usuario->direccion = $alumno->direccion;
                                        $usuario->confirmation_token = str_random(40);
                                        $usuario->password = bcrypt($password);
                                        $usuario->usuario_id = $alumno->id;
                                        $usuario->usuario_tipo = 2;

                                        $usuario->save();

                                    }

                                }
                            }
                        }
                    
                        if($reservacion->tipo_reservacion == 1){

                            $alumnosclasegrupal = InscripcionClaseGrupal::where('alumno_id', $alumno->id)
                                ->where('clase_grupal_id', $reservacion->tipo_id)
                            ->first();
                            
                            if(!$alumnosclasegrupal){

                                $clasegrupal = ClaseGrupal::join('config_clases_grupales', 'config_clases_grupales.id', '=', 'clases_grupales.clase_grupal_id')
                                    ->select('config_clases_grupales.*', 'clases_grupales.id', 'clases_grupales.fecha_inicio_preferencial', 'clases_grupales.fecha_inicio', 'config_clases_grupales.id as clase_grupal_id')
                                    ->where('clases_grupales.id', $reservacion->tipo_reservacion_id)
                                ->first();

                                $inscripcion = new InscripcionClaseGrupal;

                                $inscripcion->clase_grupal_id = $reservacion->tipo_reservacion_id;
                                $inscripcion->alumno_id = $alumno->id;
                                $inscripcion->fecha_pago = $clasegrupal->fecha_inicio_preferencial;
                                $inscripcion->fecha_inscripcion = Carbon::now()->toDateString();
                                $inscripcion->costo_mensualidad = $clasegrupal->costo_mensualidad;

                                $inscripcion->save();

                                if($clasegrupal->costo_inscripcion != 0)
                                {

                                    $item_factura = new ItemsFacturaProforma;
                                        
                                    $item_factura->usuario_id = $alumno->id;
                                    $item_factura->usuario_tipo = 1;
                                    $item_factura->academia_id =  $alumno->academia_id;
                                    $item_factura->fecha = Carbon::now()->toDateString();
                                    $item_factura->item_id = $clasegrupal->clase_grupal_id;
                                    $item_factura->nombre = 'Inscripcion ' . $clasegrupal->nombre;
                                    $item_factura->tipo = 3;
                                    $item_factura->cantidad = 1;
                                    $item_factura->precio_neto = 0;
                                    $item_factura->impuesto = 0;
                                    $item_factura->importe_neto = $clasegrupal->costo_inscripcion;
                                    $item_factura->fecha_vencimiento = $clasegrupal->fecha_inicio;
                                        
                                    $item_factura->save();

                                }

                                if($clasegrupal->costo_mensualidad != 0)
                                {

                                    $item_factura = new ItemsFacturaProforma;
                                        
                                    $item_factura->usuario_id = $alumno->id;
                                    $item_factura->usuario_tipo = 1;
                                    $item_factura->academia_id = $alumno->academia_id;
                                    $item_factura->fecha = Carbon::now()->toDateString();
                                    $item_factura->item_id = $clasegrupal->clase_grupal_id;
                                    $item_factura->nombre = 'Cuota ' . $clasegrupal->nombre;
                                    $item_factura->tipo = 4;
                                    $item_factura->cantidad = 1;
                                    $item_factura->precio_neto = 0;
                                    $item_factura->impuesto = 0;
                                    $item_factura->importe_neto = $clasegrupal->costo_mensualidad;
                                    $item_factura->fecha_vencimiento = $clasegrupal->fecha_inicio;
                                        
                                    $item_factura->save();

                                }
                            }

                        }else{

                            $alumnostaller = InscripcionTaller::where('alumno_id', $alumno->id)
                                ->where('taller_id', $reservacion->tipo_id)
                            ->first();
                            
                            if(!$alumnostaller){

                                $taller = Taller::find($reservacion->tipo_id);

                                $inscripcion = new InscripcionTaller;

                                $inscripcion->taller_id = $reservacion->tipo_id;
                                $inscripcion->alumno_id = $alumno->id;

                                $inscripcion->save();

                                $item_factura = new ItemsFacturaProforma;
                                    
                                $item_factura->usuario_id = $alumno->id;
                                $item_factura->usuario_tipo = 1;
                                $item_factura->academia_id = $alumno->academia_id;
                                $item_factura->fecha = Carbon::now()->toDateString();
                                $item_factura->item_id = $reservacion->tipo_id;
                                $item_factura->nombre = 'Inscripcion ' . $taller->nombre;
                                $item_factura->tipo = 5;
                                $item_factura->cantidad = 1;
                                $item_factura->precio_neto = 0;
                                $item_factura->impuesto = 0;
                                $item_factura->importe_neto = $taller->costo;
                                $item_factura->fecha_vencimiento = $taller->fecha_inicio;
                                    
                                $item_factura->save();

                            }
                        }
                        
                        $codigo->delete();
                        $reservacion->boolean_confirmacion = 1;
                        $reservacion->save();
                        $reservacion->delete();

                        return redirect('participante/alumno/deuda/'.$alumno->id);

                    }else{
                    
                        return redirect('validar/invalido');
                    }
                }else{
                    
                    return redirect('validar/invalido');
                }

            }else{
                return redirect('validar/invalido');
            }
        }else if($request->validar == 'referido'){

            $alumno = Alumno::where('codigo_referido', trim($request->codigo_validacion))->first();
            
            if($alumno){

                $codigo_referido = trim($request->codigo_validacion);
                $instructores = Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)
                    ->orderBy('nombre', 'asc')
                ->get();

                 return View::make('participante.alumno.create', compact('codigo_referido', 'instructores'));
            }else{
                return redirect('validar/invalido');
            }
        }else if($request->validar == 'regalo'){

            $codigo = Codigo::where('codigo_validacion', trim($request->codigo_validacion))->first();

            if($codigo){

                $fecha_limite = $codigo->fecha_vencimiento;

                if(Carbon::now() < $fecha_limite){
                    return redirect('validar/valido');
                }else{
                    return redirect('validar/invalido');
                }
            }else{
                return redirect('validar/invalido');
            }
            
        }else{
            return redirect('validar/invalido');
        }

    }

}