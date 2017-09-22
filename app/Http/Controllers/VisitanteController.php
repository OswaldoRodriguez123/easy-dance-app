<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Visitante;
use App\Instructor;
use App\ComoNosConociste;
use App\ConfigEspecialidades;
use App\DiasDeInteres;
use App\EncuestaVisitante;
use App\Llamada;
use App\Academia;
use App\Staff;
use App\ClaseGrupal;
use App\Tipologia;
use Validator;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;
use Mail;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use PulkitJalan\GeoIP\GeoIP;

class VisitanteController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index(Request $request)
    {

        $visitantes = Visitante::Leftjoin('staff', 'visitantes_presenciales.instructor_id', '=', 'staff.id')
            ->Leftjoin('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
            ->Leftjoin('config_como_nos_conociste', 'visitantes_presenciales.como_nos_conociste_id', '=', 'config_como_nos_conociste.id')
            ->select('visitantes_presenciales.*', 'staff.nombre as instructor_nombre', 'staff.apellido as instructor_apellido', 'config_como_nos_conociste.nombre as como_se_entero', 'config_especialidades.nombre as especialidad')
            ->where('visitantes_presenciales.academia_id', '=' ,  Auth::user()->academia_id)
            ->OrderBy('visitantes_presenciales.fecha_registro', 'desc')
            ->limit(200)
        ->get();

        $array = array();

        foreach($visitantes as $visitante){

            $collection=collect($visitante);     
            $visitante_array = $collection->toArray();

            if($visitante->especialidad == '' OR $visitante->especialidad == null){
                $visitante_array['especialidad']='Sin Especificar';
            }  

            $edad = Carbon::createFromFormat('Y-m-d', $visitante->fecha_nacimiento)->diff(Carbon::now())->format('%y');

            $tmp = explode(" ", $visitante['nombre']);
            $nombre = $tmp[0];

            $tmp = explode(" ", $visitante['apellido']);
            $apellido= $tmp[0];

            $contenido = '';

            $contenido = '<p class="c-negro">'.$visitante['nombre'] . ' ' . $visitante['apellido'].'<br><br>' .
                'Número Móvil: ' . $visitante['celular'] . '<br>'.
                'Correo Electrónico: ' . $visitante['correo'] . '<br>'.
                'Especialidad de Interés: ' . $visitante['especialidad'] . '<br>'.
            '</p>';

            $visitante_array['nombre']=$nombre;
            $visitante_array['apellido']=$apellido;
            $visitante_array['edad']=$edad;
            $visitante_array['contenido']=$contenido;
            $array[$visitante->id] = $visitante_array;

        }

        return view('participante.visitante.principal')->with(['visitantes' => $array]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $tipologias = Tipologia::orderBy('nombre')->get();

        return view('participante.visitante.create')->with(['como_nos_conociste' => ComoNosConociste::orderBy('nombre')->get(), 'especialidad' => ConfigEspecialidades::all() , 'dia_de_semana' => DiasDeInteres::all(), 'instructores' => Staff::where('cargo',1)->where('academia_id', Auth::user()->academia_id)->get(),'tipologias' => $tipologias]);
    }

    public function operar($id)
    {   
        $visitante = Visitante::find($id);
        return view('participante.visitante.operacion')->with(['id'=> $id , 'visitante' => $visitante]);         
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $request->merge(array('correo' => trim($request->correo)));

        $rules = [
            'nombre' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            'apellido' => 'required|min:3|max:20|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            'fecha_nacimiento' => 'required',
            'sexo' => 'required',
            'correo' => 'email|max:255|unique:visitantes_presenciales,correo'
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
            'sexo.required' => 'Ups! El Sexo  es requerido ',
            'fecha_nacimiento.required' => 'Ups! La fecha de nacimiento es requerida',
            'correo.email' => 'Ups! El correo tiene una dirección inválida',
            'correo.max' => 'El máximo de caracteres permitidos son 255',
            'correo.unique' => 'Ups! Ya este correo ha sido registrado'
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

            $visitante = new Visitante;

            $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->toDateString();

            $nombre = title_case($request->nombre);
            $apellido = title_case($request->apellido);
            $direccion = $request->direccion;

            $correo = strtolower($request->correo);

            $visitante->academia_id = Auth::user()->academia_id;
            $visitante->nombre = $nombre;
            $visitante->apellido = $apellido;
            $visitante->sexo = $request->sexo;
            $visitante->correo = $correo;
            $visitante->telefono = $request->telefono;
            $visitante->celular = $request->celular;
            $visitante->como_nos_conociste_id = $request->como_nos_conociste_id;
            $visitante->fecha_nacimiento = $fecha_nacimiento;
            $visitante->direccion = $direccion;
            $visitante->dias_clase_id = $request->dias_clase_id;
            $visitante->especialidad_id = $request->especialidad_id;
            $visitante->fecha_registro = Carbon::now();
            $visitante->hora_registro = Carbon::now();
            $visitante->instructor_id = $request->instructor_id;
            $visitante->interes_id = $request->interes_id;
            $visitante->tipologia_id = $request->tipologia_id;

            if($visitante->save()){
                return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
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
        $visitante = Visitante::find($request->id);

        $nombre = title_case($request->nombre);
        $apellido = title_case($request->apellido);

        $visitante->nombre = $nombre;
        $visitante->apellido = $apellido;

        if($visitante->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateFecha(Request $request){

        $visitante = Visitante::find($request->id);

        $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->toDateString();

        $visitante->fecha_nacimiento = $fecha_nacimiento;

        if($visitante->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateSexo(Request $request){
        $visitante = Visitante::find($request->id);
        $visitante->sexo = $request->sexo;

        if($visitante->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateDireccion(Request $request){
        $visitante = Visitante::find($request->id);
        $visitante->direccion = $request->direccion;

        if($visitante->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateTelefono(Request $request){

        $visitante = Visitante::find($request->id);
        $visitante->telefono = $request->telefono;
        $visitante->celular = $request->celular;

        if($visitante->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }


    public function updateCorreo(Request $request){

    $rules = [
        'correo' => 'email|max:255|unique:visitantes_presenciales,correo, '.$request->id.'',
    ];

    $messages = [

        'correo.email' => 'Ups! El correo tiene una dirección inválida',
        'correo.max' => 'El máximo de caracteres permitidos son 255',
        'correo.unique' => 'Ups! Ya este correo ha sido registrado',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()){

        return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);

    }

    else{
        $visitante = Visitante::find($request->id);
        $visitante->correo = $request->correo;

        if($visitante->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }
    }

    public function updateComoSeEntero(Request $request){
        $visitante = Visitante::find($request->id);
        $visitante->como_nos_conociste_id = $request->como_nos_conociste_id;

        // return redirect("alumno/edit/{$request->id}");
        if($visitante->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateDiasDeClase(Request $request){
        $visitante = Visitante::find($request->id);
        $visitante->dias_clase_id = $request->dias_clase_id;

        if($visitante->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateEspecialidad(Request $request){
        $visitante = Visitante::find($request->id);
        $visitante->especialidad_id = $request->especialidad_id;

        if($visitante->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updatePromotor(Request $request){
        $visitante = Visitante::find($request->id);
        $visitante->instructor_id = $request->instructor_id;

        if($visitante->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateInteres(Request $request){
        $visitante = Visitante::find($request->id);
        $visitante->interes_id = $request->interes_id;

        // return redirect("alumno/edit/{$request->id}");
        if($visitante->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function updateTipologia(Request $request){
        $visitante = Visitante::find($request->id);
        $visitante->tipologia_id = $request->tipologia_id;

        if($visitante->save()){
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

        $visitante = Visitante::Leftjoin('config_especialidades', 'visitantes_presenciales.especialidad_id', '=', 'config_especialidades.id')
            ->join('config_como_nos_conociste', 'visitantes_presenciales.como_nos_conociste_id', '=', 'config_como_nos_conociste.id')
            ->Leftjoin('dias_de_interes', 'visitantes_presenciales.dias_clase_id', '=', 'dias_de_interes.id')
            ->Leftjoin('staff', 'visitantes_presenciales.instructor_id', '=', 'staff.id')
            ->Leftjoin('tipologias', 'visitantes_presenciales.tipologia_id', '=', 'tipologias.id')
            ->select('visitantes_presenciales.*','config_especialidades.nombre as especialidad_nombre', 'config_especialidades.id as especialidades', 'config_como_nos_conociste.nombre as como_nos_conociste_nombre', 'staff.nombre as instructor_nombre', 'staff.apellido as instructor_apellido', 'dias_de_interes.nombre as dia_nombre', 'tipologias.nombre as tipologia')
            ->where('visitantes_presenciales.id', '=', $id)
        ->first();

        if($visitante){

            $especialidad_id = explode(",", $visitante->especialidades);

            if($especialidad_id[0] != 0)
            {
                $array = array();

                foreach($especialidad_id as $tmp){
                    $especialidad = ConfigEspecialidades::find($tmp);
                    array_push($array, $especialidad->nombre);
                   
                }

                $especialidades = implode(",", $array);

            }else{
                $especialidades = $visitante->especialidad_nombre;
            }

            $tipologias = Tipologia::orderBy('nombre')->get();

            $edad = Carbon::createFromFormat('Y-m-d', $visitante->fecha_nacimiento)->diff(Carbon::now())->format('%y');
 
            return view('participante.visitante.planilla')->with(['como_nos_conociste' => ComoNosConociste::orderBy('nombre')->get(), 'visitante' => $visitante, 'config_especialidades' => ConfigEspecialidades::all(), 'especialidades' => $especialidades, 'dias_de_semana' => DiasDeInteres::all(), 'instructores' => Staff::where('cargo',1)->where('academia_id', Auth::user()->academia_id)->get(), 'tipologias' => $tipologias, 'edad' => $edad, 'id' => $id]);
        }else{
            return redirect("participante/visitante"); 
        }
    }

    public function impresion($id)
    {
        $visitante = Visitante::find($id);

        return view('participante.visitante.impresion')->with(['visitante' => $visitante]);
    }

    public function storeImpresion(Request $request)
    {

        $visitante = Visitante::find($request->id);

        if($visitante){

            $visitante->rapidez = $request->rapidez;
            $visitante->calidad = $request->calidad;
            $visitante->satisfaccion = $request->satisfaccion;
            $visitante->disponibilidad = $request->disponibilidad;

            if($visitante->save()){

                if($visitante->celular){

                    $celular = getLimpiarNumero($visitante->celular);
                    $academia = Academia::find(Auth::user()->academia_id);

                    if($academia->pais_id == 11 && strlen($celular) == 10){
                        
                        $mensaje = $visitante->nombre.'. Gracias por visitarnos, esperamos verte bailando pronto, somos “Tu Clase de Baile”.';

                        $client = new Client(); //GuzzleHttp\Client
                        $result = $client->get('https://sistemasmasivos.com/c3colombia/api/sendsms/send.php?user=coliseodelasalsa@gmail.com&password=k1-9L6A1rn&GSM='.$celular.'&SMSText='.urlencode($mensaje));

                    }

                }

                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
            }
        }else{
            return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);
        }

    }

    public function getEncuesta($id)
    {
        $visitante = Visitante::find($id);

        $academia = Academia::join('paises', 'academias.pais_id', '=', 'paises.id')
            ->select('academias.*','paises.nombre as pais')
            ->where('academias.id', $visitante->academia_id)
        ->first();

        return view('participante.visitante.encuesta')->with(['visitante' => $visitante, 'academia' => $academia]);
    }

    public function enviarCorreo(Request $request){

        $visitante = Visitante::find($request->id);

        if(!$visitante->correo){
            return response()->json(['error_mensaje'=> 'Ups! Este visitante no posee correo electrónico asignado' , 'status' => 'ERROR-CORREO'],422);
        }

        $subj = 'Información';

        $clase_grupal_join = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
            ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
            ->select('config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_grupales.fecha_inicio', 'clases_grupales.id')
            ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
        ->get();

        $array_clase = array();
        $i = 0;

        foreach($clase_grupal_join as $clase_grupal){
            $fecha = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);
            if($fecha > Carbon::now()){
                $array_clase[$i] = $clase_grupal;
                $i = $i + 1;
            }
        }

        $array = [
            'nombre' => $visitante->nombre,
            'email' => $visitante->correo,
            'subj' => $subj,
            'clases_grupales' => $array_clase
        ];

        Mail::send('correo.clases_grupales', $array, function($msj) use ($array){
            $msj->subject($array['subj']);
            $msj->to($array['email']);
        });

        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK',  200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $visitante = Visitante::find($id);
        
        if($visitante->delete()){
            return response()->json(['mensaje' => '¡Excelente! El visitante se ha eliminado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['errores'=>'error', 'status' => 'ERROR-SERVIDOR'],422);
        }
    }

    public function indexLlamada($id){

        $interesado = Visitante::find($id);
        $llamadas = Llamada::where('usuario_id', $id)->where('usuario_tipo',1)->get();

        return view('participante.visitante.llamada.principal')->with(['id' => $id, 'llamadas' => $llamadas, 'interesado' => $interesado]);
    }

    public function createLlamada($id){
      
        $hora_actual = $hora->format('H:i');
        $interesado = Visitante::find($id);
        return view('participante.visitante.llamada.create')->with(['id' => $id, 'interesado' => $interesado, 'hora_actual' => $hora_actual]);
    }

    public function storeLlamada(Request $request){

            $rules = [
                'status' => 'required',
                'hora_llamada' => 'required'

            ];

            $messages = [

                'status.required' => 'Ups! El Estatus es requerido',
                'hora_llamada.required' => 'Ups! La hora es requerida',

            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()){

                return response()->json(['errores'=>$validator->messages(), 'status' => 'ERROR'],422);
            }

            else{


            $academia = Academia::find(Auth::user()->academia_id);
            $fecha_llamada = Carbon::now();

            if($request->fecha_siguiente){

                $fecha_siguiente = Carbon::createFromFormat('d/m/Y', $request->fecha_siguiente);
              
                if($fecha_llamada > $fecha_siguiente ) {

                    return response()->json(['errores' => ['fecha_siguiente' => [0, 'Ups! Esta fecha es invalida, debes ingresar una fecha mayor a hoy']], 'status' => 'ERROR'],422);
                } 

            }else{
                $fecha_siguiente = '';
            }

            if($request->hora_siguiente){
                if($academia->tipo_horario == 1){
                    $hora_siguiente = Carbon::createFromFormat('H:i',$request->hora_siguiente)->toTimeString();
                }else{
                    $hora_siguiente = Carbon::createFromFormat('H:i a',$request->hora_siguiente)->toTimeString();
                }
            }else{
                $hora_siguiente = '';
            }

            if($academia->tipo_horario == 1){
                $hora_llamada = Carbon::createFromFormat('H:i',$request->hora_llamada)->toTimeString();
            }else{
                $hora_llamada = Carbon::createFromFormat('H:i a',$request->hora_llamada)->toTimeString();
            }

            $llamada = new Llamada;
            
            $llamada->usuario_id = $request->id;
            $llamada->usuario_tipo = 1;
            $llamada->observacion = $request->observacion;
            $llamada->status = $request->status;
            $llamada->fecha_llamada = $fecha_llamada;
            $llamada->hora_llamada = $hora_llamada;
            $llamada->fecha_siguiente = $fecha_siguiente;
            $llamada->hora_siguiente = $hora_siguiente;

            if($llamada->save()){

                return response()->json(['mensaje' => '¡Excelente! Los cambios se han actualizado satisfactoriamente', 'status' => 'OK', 200]);

            }else{
                return response()->json(['errores'=>'error', 'status' => 'ERROR'],422);
            }
        }
    }

    public function eliminarLlamada($id){

        $llamada=Llamada::find($id);
        $llamada->delete();
      
        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
    }

}