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
use App\ReservacionVisitante;
use App\Alumno;
use App\User;

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
        $route = 0;
        $alumno_id = 0;
        $codigo = Codigo::where('codigo_validacion', trim($request->codigo_validacion))->first();

            if($codigo){

                $fecha_limite = $codigo->fecha_vencimiento;

                if(Carbon::now() < $fecha_limite){
                    $valido = true;
                    if($codigo->tipo == 2)
                    {
                        $reservacion = ReservacionVisitante::find($codigo->item_id);

                        $visitante = Visitante::find($reservacion->visitante_id);

                        $alumno = Alumno::where('correo',$visitante->correo)->first();

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

                                }

                            }
                        }

                        $visitante->cliente = 1;
                        $visitante->save();
                    
                        if($reservacion->tipo_reservacion == 1){

                            $clasegrupal = ClaseGrupal::join('config_clases_grupales', 'config_clases_grupales.id', '=', 'clases_grupales.clase_grupal_id')
                                ->select('config_clases_grupales.*', 'clases_grupales.id', 'clases_grupales.fecha_inicio_preferencial', 'clases_grupales.fecha_inicio')
                                ->where('clases_grupales.id', $reservacion->tipo_id)
                            ->first();

                            $inscripcion = new InscripcionClaseGrupal;

                            $inscripcion->clase_grupal_id = $reservacion->tipo_id;
                            $inscripcion->alumno_id = $alumno->id;
                            $inscripcion->fecha_pago = $clasegrupal->fecha_inicio_preferencial;
                            $inscripcion->fecha_inscripcion = Carbon::now()->toDateString();
                            $inscripcion->costo_mensualidad = $clasegrupal->costo_mensualidad;

                            $inscripcion->save();

                            if($clasegrupal->costo_inscripcion != 0)
                            {

                                $item_factura = new ItemsFacturaProforma;
                                    
                                $item_factura->alumno_id = $alumno->id;
                                $item_factura->academia_id =  $alumno->academia_id;
                                $item_factura->fecha = Carbon::now()->toDateString();
                                $item_factura->item_id = $reservacion->tipo_id;
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
                                    
                                $item_factura->alumno_id = $alumno->id;
                                $item_factura->academia_id = $alumno->academia_id;
                                $item_factura->fecha = Carbon::now()->toDateString();
                                $item_factura->item_id = $reservacion->tipo_id;
                                $item_factura->nombre = 'Cuota ' . $clasegrupal->nombre;
                                $item_factura->tipo = 4;
                                $item_factura->cantidad = 1;
                                $item_factura->precio_neto = 0;
                                $item_factura->impuesto = 0;
                                $item_factura->importe_neto = $clasegrupal->costo_mensualidad;
                                $item_factura->fecha_vencimiento = $clasegrupal->fecha_inicio;
                                    
                                $item_factura->save();

                            }

                        }else{

                            $taller = Taller::find($reservacion->tipo_id);

                            $inscripcion = new InscripcionTaller;

                            $inscripcion->taller_id = $reservacion->tipo_id;
                            $inscripcion->alumno_id = $alumno->id;

                            $inscripcion->save();

                            $item_factura = new ItemsFacturaProforma;
                                
                            $item_factura->alumno_id = $alumno->id;
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

                        $alumno_id = $alumno->id;
                        $route = 1;
                    }
                }else{
                    
                    $valido = null;
                }

            }else{
                $valido = null;
            }

            if($valido){
                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 'route' => $route, 'alumno_id' => $alumno_id, 200]);
            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
            }
    }

}