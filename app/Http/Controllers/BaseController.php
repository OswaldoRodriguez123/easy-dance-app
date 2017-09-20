<?php 

namespace App\Http\Controllers;

use View;
use App\Alumno;
use App\User;
use App\Academia;
use App\AlumnoRemuneracion;
use App\ConfigClasesGrupales;
use App\Taller;
use App\Instructor;
use App\Notificacion;
use Illuminate\Support\Facades\Auth;
use DB;
use App\CentauroSMS\CentauroSMS;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Session;


class BaseController extends Controller {

    public function __construct(Request $request) {

        if (Auth::check()) { 

            $academia = Academia::find(Auth::user()->academia_id);
            $datos = $this->getDatosUsuario();

            $usuario_id = $datos[0]['usuario_id'];
            $usuario_tipo = $datos[0]['usuario_tipo'];

            if($academia->pais_id == 11){

                $timezone = 'America/Bogota';

            }else{

                $timezone = 'America/Caracas';
            }

            date_default_timezone_set($timezone);

            $notificaciones = Notificacion::join('notificacion_usuario','notificacion_usuario.id_notificacion', '=','notificacion.id')
                ->select('notificacion.*','notificacion_usuario.visto as visto')
                ->where('notificacion_usuario.id_usuario','=',Auth::user()->id)
                ->orderBy('notificacion_usuario.created_at','desc')
                ->limit(10)
            ->get();

            $array = array();
            $numero_de_notificaciones = 0;

            foreach ($notificaciones as $notificacion) {

                if($notificacion->visto == 0){
                    $numero_de_notificaciones++;
                }

                $collection=collect($notificacion);     
                $notificacion_imagen_array = $collection->toArray();

                // if($notificacion->tipo_evento != 1){
                //     if(Auth::user()->imagen){
                //         $notificacion_imagen_array['imagen']= "/assets/uploads/usuario/".Auth::user()->imagen;
                //     }else{
                        
                //         if(Auth::user()->sexo == 'F'){
                //             $notificacion_imagen_array['imagen']= "/assets/img/profile-pics/1.jpg";
                //         }else{
                //             $notificacion_imagen_array['imagen']= "/assets/img/profile-pics/2.jpg";
                //         }
                //     }
                // }else 

                if($notificacion->tipo_evento == 1){

                    $clase_grupal = ConfigClasesGrupales::join('clases_grupales','config_clases_grupales.id','=','clases_grupales.clase_grupal_id')
                        ->select('config_clases_grupales.imagen')
                        ->where('clases_grupales.id',$notificacion->evento_id)
                    ->first();

                    if($clase_grupal){

	                    if($clase_grupal->imagen){
	                        $notificacion_imagen_array['imagen']= "/assets/uploads/clase_grupal/".$clase_grupal->imagen;
	                    }else{
	                        
	                        if($academia->imagen){
	                            $notificacion_imagen_array['imagen']= "/assets/uploads/academia/".$academia->imagen;
	                        }else{
	                            $notificacion_imagen_array['imagen']= "/assets/img/asd_.jpg";
	                        }
	                    }
                	}else{
                	
                        if($academia->imagen){
                            $notificacion_imagen_array['imagen']= "/assets/uploads/academia/".$academia->imagen;
                        }else{
                            $notificacion_imagen_array['imagen']= "/assets/img/asd_.jpg";
                        }
                	}
                }else if($notificacion->tipo_evento == 2){

                    $taller = Taller::find($notificacion->evento_id);

                    if($taller){

                        if($taller->imagen){
                            $notificacion_imagen_array['imagen']= "/assets/uploads/taller/".$taller->imagen;
                        }else{
                            
                            if($academia->imagen){
                                $notificacion_imagen_array['imagen']= "/assets/uploads/academia/".$academia->imagen;
                            }else{
                                $notificacion_imagen_array['imagen']= "/assets/img/asd_.jpg";
                            }
                        }
                    }else{
                    
                        if($academia->imagen){
                            $notificacion_imagen_array['imagen']= "/assets/uploads/academia/".$academia->imagen;
                        }else{
                            $notificacion_imagen_array['imagen']= "/assets/img/asd_.jpg";
                        }
                    }
                }else{
                    if($academia->imagen){
                        $notificacion_imagen_array['imagen']= "/assets/uploads/academia/".$academia->imagen;
                    }else{
                        $notificacion_imagen_array['imagen']= "/assets/img/asd_.jpg";
                    }
                }
                
                $array[$notificacion->id] = $notificacion_imagen_array;
            }

            View::share ('notificaciones', $array);
            View::share ('usuario_tipo', $usuario_tipo);
            View::share ('usuario_id', $usuario_id);
            View::share ('tipo_horario', $academia->tipo_horario);
            View::share ('sin_ver', $numero_de_notificaciones );
   		}

    }

    public function enviarMensaje($numero, $mensaje)
    {

        $numero = getLimpiarNumero($numero);

        $client = new Client(); //GuzzleHttp\Client
        $result = $client->get('https://sistemasmasivos.com/c3colombia/api/sendsms/send.php?user=coliseodelasalsa@gmail.com&password=k1-9L6A1rn&GSM='.$numero.'&SMSText='.$mensaje);

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

    function cut_html($value, $limit)
    {
        $value = html_entity_decode($value);

        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }

        // Strip text with HTML tags, sum html len tags too.
        // Is there another way to do it?
        do {
            $len          = mb_strwidth($value, 'UTF-8');
            $len_stripped = mb_strwidth(strip_tags($value), 'UTF-8');
            $len_tags     = $len - $len_stripped;

            $value = mb_strimwidth($value, 0, $limit + $len_tags, '', 'UTF-8');
        } while ($len_stripped > $limit);

        // Load as HTML ignoring errors
        $dom = new \DOMDocument();
        @$dom->loadHTML('<?xml encoding="utf-8" ?>'.$value, LIBXML_HTML_NODEFDTD);

        // Fix the html errors
        $value = $dom->saveHtml($dom->getElementsByTagName('body')->item(0));

        // Remove body tag
        $value = mb_strimwidth($value, 6, mb_strwidth($value, 'UTF-8') - 13, '', 'UTF-8'); // <body> and </body>
        // Remove empty tags
        return preg_replace('/<(\w+)\b(?:\s+[\w\-.:]+(?:\s*=\s*(?:"[^"]*"|"[^"]*"|[\w\-.:]+))?)*\s*\/?>\s*<\/\1\s*>/', '', $value);
    }

    function getSQL($builder) {
      $sql = $builder->toSql();
      foreach ( $builder->getBindings() as $binding ) {
        $value = is_numeric($binding) ? $binding : "'".$binding."'";
        $sql = preg_replace('/\?/', $value, $sql, 1);
      }
      return $sql;
    }

    function getDatosUsuario(){

        $usuario_tipo = Session::get('easydance_usuario_tipo');
        $usuario_id = Session::get('easydance_usuario_id');

        // if(!$usuario_tipo){
        //     Session::put('easydance_usuario_tipo',Auth::user()->usuario_tipo);
        //     Session::put('easydance_usuario_id',Auth::user()->usuario_id);
        //     $usuario_tipo = Auth::user()->usuario_tipo;
        //     $usuario_id = Auth::user()->usuario_id;
        // }

        return array(['usuario_tipo' => $usuario_tipo, 'usuario_id' => $usuario_id]);

    }

    public static function generarCodigoReferido($length)
    {
        $pool = 'abcdefghijklmnopqrstuvwxyz';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    public static function sortByName($a, $b) {
      return strcmp($a["nombre"], $b["nombre"]);
    }

}