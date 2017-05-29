<?php 

namespace App\Http\Controllers;

use View;
use App\Alumno;
use App\User;
use App\Academia;
use App\AlumnoRemuneracion;
use App\Instructor;
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

        $usuario = User::find(Auth::user()->id);
        $academia = Academia::find($usuario->academia_id);
        $usuario_tipo = Session::get('easydance_usuario_tipo');
        $usuario_id = Session::get('easydance_usuario_id');

        if($academia->pais_id == 11){

            $timezone = 'America/Bogota';

        }else{

            $timezone = 'America/Caracas';
        }

        date_default_timezone_set($timezone);

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

                if($notificacion->tipo_evento == 5)
                {
                    $usuario = User::join('sugerencias','users.id','=','sugerencias.usuario_id')
                        ->select('users.imagen', 'users.sexo')
                        ->where('sugerencias.id','=',$notificacion->evento_id)
                    ->first();

                    if($usuario){

                        if($usuario->imagen){
                            $notificacion_imagen_array['imagen']= "/assets/uploads/usuario/".$usuario->imagen;
                        }else{
                            if($usuario->sexo == 'F'){

                                $notificacion_imagen_array['imagen']= "/assets/img/profile-pics/1.jpg";
                            }else{
                                $notificacion_imagen_array['imagen']= "/assets/img/profile-pics/2.jpg";
                            }
                        }

                    }

                }else if($notificacion->tipo_evento == 1){

                    
                    $imagen = DB::table('config_clases_grupales')
                        ->join('clases_grupales','config_clases_grupales.id','=','clases_grupales.clase_grupal_id')
                        ->join('notificacion','clases_grupales.id','=','notificacion.evento_id')
                        ->select('config_clases_grupales.imagen')
                        ->where('notificacion.evento_id','=',$notificacion->evento_id)
                    ->first();

                     if($imagen->imagen){
                        $notificacion_imagen_array['imagen']= "/assets/uploads/clase_grupal/".$imagen->imagen;
                    }else{
                        if($notificacion->imagen)
                        {
                            $notificacion_imagen_array['imagen']= "/assets/uploads/academia/".$notificacion->imagen;
                        }else{
                            $notificacion_imagen_array['imagen']= "/assets/img/asd_.jpg";
                        }
                        
                    }

                }else{

                    if($notificacion->imagen)
                    {
                        $notificacion_imagen_array['imagen']= "/assets/uploads/academia/".$notificacion->imagen;
                    }else{
                        $notificacion_imagen_array['imagen']= "/assets/img/asd_.jpg";
                    }

                }
            
                $array[$notificacion->id] = $notificacion_imagen_array;
            }

            if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){
                $puntos_referidos = 0;
            }else{
                $alumno_remuneracion = AlumnoRemuneracion::where('alumno_id', $usuario_id)->first();
                if($alumno_remuneracion){
                    $puntos_referidos = $alumno_remuneracion->remuneracion;
                }else{
                   $puntos_referidos = 0; 
                }
                
                View::share ( 'puntos_referidos', $puntos_referidos);
            }
            
            View::share ( 'notificaciones', $array);
            View::share ( 'usuario_tipo', $usuario_tipo);
            View::share ( 'sin_ver', $numero_de_notificaciones );
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

}