<?php 

namespace App\Http\Controllers;

use View;
use App\Alumno;
use App\Instructor;
use Illuminate\Support\Facades\Auth;
use DB;
use App\CentauroSMS\CentauroSMS;
use PulkitJalan\GeoIP\GeoIP;
use Carbon\Carbon;


class BaseController extends Controller {

    public function __construct() {

    if (Auth::check()) { 

	   $array = array(2, 4);

        if (in_array(Auth::user()->usuario_tipo, $array))
        {

            $notificaciones = DB::table('notificacion_usuario')
                ->join('notificacion','notificacion_usuario.id_notificacion', '=','notificacion.id')
                ->join('users','notificacion_usuario.id_usuario','=','users.id')
                ->select('notificacion.*','notificacion_usuario.visto as visto')
                ->where('notificacion_usuario.id_usuario','=',Auth::user()->id)
                ->orderBy('notificacion_usuario.created_at','desc')
            ->get();




            $numero_de_notificaciones = 0;

            foreach( $notificaciones as $notificacion){
                if($notificacion->visto == 0){
                    $numero_de_notificaciones++;
                }
            }

            $notificaciones = DB::table('notificacion_usuario')
                ->join('notificacion','notificacion_usuario.id_notificacion', '=','notificacion.id')
                ->join('users','notificacion_usuario.id_usuario','=','users.id')
                ->join('academias','users.academia_id','=','academias.id')
                ->select('notificacion.*','notificacion_usuario.visto as visto','academias.imagen as imagen')
                ->where('notificacion_usuario.id_usuario','=',Auth::user()->id)
                ->orderBy('notificacion_usuario.created_at','desc')
                ->limit(10)
            ->get();

            $array = array();

            foreach ($notificaciones as $notificacion) {
                $collection=collect($notificacion);     
                $notificacion_imagen_array = $collection->toArray();
                    
                    $imagen = DB::table('config_clases_grupales')
                        ->join('clases_grupales','config_clases_grupales.id','=','clases_grupales.clase_grupal_id')
                        ->join('notificacion','clases_grupales.id','=','notificacion.evento_id')
                        ->select('config_clases_grupales.imagen')
                        ->where('notificacion.evento_id','=',$notificacion->evento_id)
                    ->first();

                if($imagen->imagen){
                    $notificacion_imagen_array['imagen']= "/assets/uploads/clase_grupal/".$imagen->imagen;
                }else{
                    $notificacion_imagen_array['imagen']= "/assets/img/asd_.jpg";
                }
                
                $array[$notificacion->id] = $notificacion_imagen_array;
            }

            }else{
                $array = array();
                $numero_de_notificaciones = 0;
            }

           View::share ( 'notificaciones', $array);
           View::share ( 'sin_ver', $numero_de_notificaciones );
   		}

    }
    //SMS
    public function sendAlumno($request, $mensaje)
    {
        $user = Auth::user();
        $SMS = new CentauroSMS(env('CENTAURO_KEY'), env('CENTAURO_SECRET'));

        //Mensajes a un solo Destinatario
        $destinatarios = array("id" => "0","cel" => getLimpiarNumero($request['celular']),"nom" => $request['nombre'].' '.$request['apellido']);
        $msg = $mensaje;
        $js = json_encode($destinatarios);
        $result = $SMS->set_sms_send($js,$msg); // Comando para enviar SMS Normales
        if($result['status']=='200'){

            $nombre = $result['response'][0]['datos'][0]['Nom'];
            $celular = $result['response'][0]['datos'][0]['Cel'];
            $Messageid = $result['response'][0]['datos'][0]['Messageid'];
            $StatusText = $result['response'][0]['datos'][0]['StatusText'];
            $Msg = $result['response'][0]['datos'][0]['Msg'];

            return response()->json([
                    'nombre' => $nombre, 
                    'celular' => $celular,
                    'mensaje_id' => $Messageid,
                    'status_text' => $StatusText,
                    'mensaje' => $Msg, 
                    'status' => 'OK', 200
                ]);
        }else{
            //RESPUESTA DE ERROR DEL SERVER
            if ($result['status']=='305'){ 
                return response()->json(['mensaje' => "No tiene SMS disponibles para realizar este envio", 'status' => 305, 305]);
            }
            if ($result['status']=='304'){ 
                return response()->json(['mensaje' => "Los parametros no son correctos por favor no modifique la API", 'status' => 304, 304]);
            }
            if ($result['status']=='303'){ 
                return response()->json(['mensaje' => "Error grave no se recibio parametro de la API", 'status' => 303, 303]);
            }
            if ($result['status']=='302'){ 
                return response()->json(['mensaje' => "Servidores fuera de linea", 'status' => 302, 302]);
            }
            if ($result['status']=='301'){ 
                return response()->json(['mensaje' => "Error de credenciales", 'status' => 301, 301]);
            }
            if ($result['status']=='300'){ 
                return response()->json(['mensaje' => "No se recibieron los parametros necesarios", 'status' => 300, 300]);
            }

        }

    }    


}