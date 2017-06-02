<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\Alumno;
use App\Academia;
use App\UsuarioTipo;
use App\CredencialAlumno;
use App\ClaseGrupal;
use App\ConfigClasesGrupales;
use App\VencimientoClaseGrupal;
use App\Reservacion;
use App\ConfigPagosInstructor;
use App\Paises;
use App\ConfigEspecialidades;
use App\InscripcionClaseGrupal;
use App\HorarioClaseGrupal;
use App\HorarioBloqueado;
use App\Asistencia;
use App\Evaluacion;
use App\Taller;
use App\Fiesta;
use App\Campana;
use App\Instructor;
use App\ClasePersonalizada;
use App\PerfilEvaluativo;
use App\Regalo;
use Validator;
use Carbon\Carbon;
use Storage;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Session;

class LoginController extends BaseController {

	// use RedirectsUsers;

	// public function __construct()
 //    {
 //        $this->middleware('guest', ['except' => ['getLogout', 'checkSession']]);
 //    }

    protected $redirectPath = '/inicio';
    protected $redirectTo = '/inicio';

	public function getLogin()
    {
        // return $this->showLoginForm();
        return view('login.index');
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $view = property_exists($this, 'loginView')
                    ? $this->loginView : 'auth.authenticate';

        if (view()->exists($view)) {
            return view($view);
        }

        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        return $this->login($request);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
    
    $messages = [

        'email.required' => 'Ups! El correo  es requerido ',
        'password.required' => 'Ups! La contraseña es requerida',
        
    ];

        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ], $messages);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool  $throttles
     * @return \Illuminate\Http\Response
     */
    protected function handleUserWasAuthenticated(Request $request, $throttles)
    {
        if ($throttles) {
            $this->clearLoginAttempts($request);
        }

        if (method_exists($this, 'authenticated')) {
            return $this->authenticated($request, Auth::guard($this->getGuard())->user());
        }

        // return redirect()->intended('/inicio');
        return redirect()->to('/inicio');
        // return Redirect::to('home');
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => 'El usuario o la contraseña es incorrecta.',
            ]);
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
                ? Lang::get('auth.failed')
                : 'El usuario o la contraseña es incorrecta.';
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return $request->only($this->loginUsername(), 'password');
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        return $this->logout();
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::guard($this->getGuard())->logout();
        Session::flush();

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/login');
    }

    /**
     * Get the guest middleware for the application.
     */
    public function guestMiddleware()
    {
        $guard = $this->getGuard();

        return $guard ? 'guest:'.$guard : 'guest';
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return property_exists($this, 'username') ? trim($this->username) : 'email';
    }

    /**
     * Determine if the class is using the ThrottlesLogins trait.
     *
     * @return bool
     */
    protected function isUsingThrottlesLoginsTrait()
    {
        return in_array(
            ThrottlesLogins::class, class_uses_recursive(static::class)
        );
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return string|null
     */
    protected function getGuard()
    {
        return property_exists($this, 'guard') ? $this->guard : null;
    }

    public function restablecer(){
        return view('login.contrasena.restablecer');
    }

    public function restablecerfallo(){
        return view('login.contrasena.fallo');
    }

    public function restablecercompletado(){
        return view('login.contrasena.completado');
    }

    public function restablecerconfirmar(){
        return view('login.contrasena.salvavidas');
    }

    public function seleccionar_tipo()
    {
        $usuario_tipo = Session::get('easydance_usuario_tipo');
        
        if(!$usuario_tipo){
            $tipos = UsuarioTipo::where('usuario_id',Auth::user()->id)->get();
            foreach($tipos as $tipo){
                $usuario_tipo = $tipo->tipo;
                $usuario_id = $tipo->tipo_id;
            }

            if(count($tipos) > 1){
                return view('login.seleccionar-tipo')->with('tipos',$tipos);
            }else{
                Session::put('easydance_usuario_tipo',$usuario_tipo);
                Session::put('easydance_usuario_id',$usuario_id);
                return redirect('/inicio');
            }
        }else{
            return redirect('/inicio');
        }
    }

    public function PostSeleccionar($id)
    {
        $tipos = UsuarioTipo::where('usuario_id',Auth::user()->id)->get();
        $i = 0;
        foreach($tipos as $tipo){
            if($tipo->tipo == $id){
                Session::put('easydance_usuario_id',$tipo->tipo_id);
                break;
            }
        }
        Session::put('easydance_usuario_tipo',$id);
        return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
    }

    public function index()
	{
        $academia = Academia::find(Auth::user()->academia_id);
        $usuario_tipo = Session::get('easydance_usuario_tipo');
        $usuario_id = Session::get('easydance_usuario_id');

        if($usuario_tipo){

            //ADMINISTRADOR
            if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){

                $fecha_comprobacion = Carbon::createFromFormat('Y-m-d', $academia->fecha_comprobacion);
                $hoy = Carbon::now();

                if($fecha_comprobacion < $hoy){

                    $credenciales_vencidas = CredencialAlumno::where('cantidad', '<=', 0)->delete();

                    $clases_grupales = ClaseGrupal::where('boolean_vencimiento',0)->where('academia_id',Auth::user()->academia_id)->get();

                    foreach($clases_grupales as $clase_grupal){
                        $fecha_final = Carbon::createFromFormat('Y-m-d',$clase_grupal->fecha_final);


                        if(Carbon::now()->addMonth() > $fecha_final && $fecha_final > Carbon::now()){
                            $usuarios = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                                ->select('users.id','usuarios_tipo.tipo')
                                ->where('academia_id',Auth::user()->academia_id)
                            ->get();
                            foreach($usuarios as $usuario){

                                if($usuario->tipo == 1 OR $usuario->tipo == 3 OR $usuario->tipo == 5 OR $usuario->tipo == 6){
                                    $vencimiento = new VencimientoClaseGrupal;

                                    $vencimiento->clase_grupal_id = $clase_grupal->id;
                                    $vencimiento->usuario_id = $usuario->id;
                                    $vencimiento->save();

                                    break;
                                }
                                
                            }
                        }

                        $clase_grupal->boolean_vencimiento = 1;
                        $clase_grupal->save();
                    }

                    $reservaciones = Reservacion::all();

                    foreach($reservaciones as $reservacion){
                        $fecha_vencimiento = Carbon::parse($reservacion->fecha_vencimiento);
                        if(Carbon::now() > $fecha_vencimiento){
                            $reservacion->deleted_at = Carbon::now();
                            $reservacion->save();
                        }

                    }

                    if($hoy == $hoy->lastOfMonth()){

                        $config_pagos = ConfigPagosInstructor::where('tipo', 2)->get();

                        foreach($config_pagos as $config_pago){
                            $pago = new PagoInstructor;

                            $pago->instructor_id=$config_pago->instructor_id;
                            $pago->tipo=$config_pago->tipo;
                            $pago->monto=$config_pago->monto;
                            $pago->clase_grupal_id=$config_pago->clase_grupal_id;

                            $pago->save();
                        }

                    }

                    return $this->pagorecurrente();
                }


                $vencimiento = VencimientoClaseGrupal::join('clases_grupales', 'vencimiento_clases_grupales.clase_grupal_id', '=', 'clases_grupales.id')
                    ->join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                    ->join('config_especialidades', 'clases_grupales.especialidad_id', '=', 'config_especialidades.id')
                    ->join('instructores', 'clases_grupales.instructor_id', '=', 'instructores.id')
                    ->select('config_especialidades.nombre as especialidad_nombre', 'config_clases_grupales.nombre as clase_grupal_nombre', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'clases_grupales.hora_inicio','clases_grupales.hora_final','clases_grupales.fecha_inicio', 'clases_grupales.fecha_final','vencimiento_clases_grupales.id')
                    ->where('vencimiento_clases_grupales.usuario_id','=', Auth::user()->id)
                ->first();

                return view('inicio.index')->with(['paises' => Paises::all() , 'especialidades' => ConfigEspecialidades::all(), 'academia' => $academia, 'vencimiento' => $vencimiento]); 
                
            }else if($usuario_tipo == 2 || $usuario_tipo == 4){

                $alumno = Alumno::find($usuario_id);
                
                if(!$alumno){
                    return view('inicio.cuenta-deshabilitada');
                }else{
                    if(Session::has('fecha_comprobacion')){
                        $fecha_comprobacion = Session::get('fecha_comprobacion');
                        $hoy = Carbon::now()->toDateString();

                        if($fecha_comprobacion < $hoy){
                            return $this->inactividad();
                        }

                    }else{
                        return $this->inactividad();
                    }
                }


                //ALUMNOS
                if(Auth::user()->boolean_condiciones){

                    $contador_clase = 0;
                    $contador_taller = 0;
                    $contador_fiesta = 0;
                    $contador_campana = 0;

                    $array=array();

                    $clase_grupal_join = ClaseGrupal::join('config_clases_grupales', 'clases_grupales.clase_grupal_id', '=', 'config_clases_grupales.id')
                        ->select('config_clases_grupales.nombre','clases_grupales.id', 'config_clases_grupales.descripcion', 'clases_grupales.imagen', 'clases_grupales.created_at', 'clases_grupales.fecha_inicio', 'clases_grupales.dias_prorroga')
                        ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
                        ->where('clases_grupales.boolean_promocionar','=', 1)
                        ->where('clases_grupales.deleted_at', '=', null)
                    ->get();

                    $alumno_examenes = Evaluacion::join('alumnos','evaluaciones.alumno_id','=','alumnos.id')
                        ->join('examenes','evaluaciones.examen_id','=','examenes.id')
                        ->select('examenes.nombre','evaluaciones.id')
                        ->where('evaluaciones.alumno_id','=',$usuario_id)
                    ->get();


                    foreach($clase_grupal_join as $clase){

                        $fecha = Carbon::createFromFormat('Y-m-d', $clase->fecha_inicio);
                        $fecha->addDays($clase->dias_prorroga);
                        if($fecha >= Carbon::now()){
                            $contador_clase = $contador_clase + 1;
                            $disponible = '';
                        }else{
                            $disponible = ' ( No disponible )';
                        }

                        
                        if($clase->imagen){
                            $imagen = "/assets/uploads/clase_grupal/{$clase->imagen}";
                        }else{
                            $imagen = '';
                        }

                        $fecha_inicio = Carbon::createFromFormat('Y-m-d', $clase->fecha_inicio)->format('d-m-Y');


                        $array[]=array('nombre' => $clase->nombre , 'descripcion' => $clase->descripcion ,'imagen' => $imagen , 'url' => "/agendar/clases-grupales/progreso/{$clase->id}", 'facebook' => "/agendar/clases-grupales/progreso/{$clase->id}", 'twitter' => "Participa en la clase grupal {$clase->nombre} te invita @EasyDanceLatino", 'twitter_url' => "/agendar/clases-grupales/progreso/{$clase->id}", 'creacion' => $clase->created_at, 'tipo' => 1, 'fecha_inicio' => $fecha_inicio, 'disponible' => $disponible);

                    }

                    $talleres = Taller::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

                    foreach($talleres as $taller){

                        $fecha = Carbon::createFromFormat('Y-m-d', $taller->fecha_inicio);

                       if($fecha >= Carbon::now() && $taller->boolean_promocionar == 1){

                            if($taller->imagen){
                                $imagen = "/assets/uploads/taller/{$taller->imagen}";
                            }else{
                                $imagen = '';
                            }

                            $array[]=array('nombre' => $taller->nombre , 'descripcion' => $taller->descripcion ,'imagen' => $imagen , 'url' => "/agendar/talleres/progreso/{$taller->id}", 'facebook' => "/agendar/talleres/progreso/{$taller->id}", 'twitter' => "Participa en el taller {$taller->nombre} te invita @EasyDanceLatino", 'twitter_url' => "/agendar/talleres/progreso/{$taller->id}" , 'creacion' => $taller->created_at, 'tipo' => 2, 'fecha_inicio' => $taller->fecha_inicio, 'disponible' => '');

                            $contador_taller = $contador_taller + 1;
                        }

                    }

                    $fiestas = Fiesta::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

                    foreach($fiestas as $fiesta){

                        $fecha = Carbon::createFromFormat('Y-m-d', $fiesta->fecha_inicio);

                        if($fecha >= Carbon::now() && $fiesta->boolean_promocionar == 1){

                            if($fiesta->imagen){
                                $imagen = "/assets/uploads/fiesta/{$fiesta->imagen}";
                            }else{
                                $imagen = '';
                            }

                            $array[]=array('nombre' => $fiesta->nombre , 'descripcion' => $fiesta->descripcion ,'imagen' => $imagen , 'url' => "/agendar/fiestas/progreso/{$fiesta->id}", 'facebook' => "/agendar/fiesta/progreso/{$fiesta->id}", 'twitter' => "Participa en la fiesta {$fiesta->nombre} te invita @EasyDanceLatino", 'twitter_url' => "/agendar/fiestas/progreso/{$fiesta->id}", 'creacion' => $fiesta->created_at, 'tipo' => 3, 'fiesta' => $fiesta->fecha_inicio, 'disponible' => '');

                            $contador_fiesta = $contador_fiesta + 1;
                        }

                    }

                    $campanas = Campana::where('academia_id', '=' ,  Auth::user()->academia_id)->get();

                    foreach($campanas as $campana){

                        $fecha = Carbon::createFromFormat('Y-m-d', $campana->fecha_final);

                        if($fecha >= Carbon::now()){

                            $contador_campana = $contador_campana + 1;
                        }

                    }

                    $collection = collect($array);

                    $sorted = $collection->sortByDesc('creacion');

                    $i = 0;

                    $arreglo=array();

                    foreach($sorted as $tmp){

                        $tmp['contador'] = $i;
                        $arreglo[$i] = $tmp;
                        $i = $i + 1;

                    }

                    $instructor_contador = Instructor::where('academia_id', '=' ,  Auth::user()->academia_id)->where('instructores.boolean_promocionar', 1)->count();
                    $clase_personalizada_contador = ClasePersonalizada::where('academia_id', '=' ,  Auth::user()->academia_id)->count();

                    $perfil = PerfilEvaluativo::where('usuario_id', $usuario_id)->first();

                    if($perfil){
                        $tiene_perfil = 1;
                    }else{
                        $tiene_perfil = 0;
                    }

                    $array_deuda = array();

                    if (!Session::has('fecha_sesion')) {                
                       $fecha_sesion=Carbon::now();
                       Session::put('fecha_sesion',$fecha_sesion);
                    }

                    $credenciales_alumno = CredencialAlumno::join('instructores','credenciales_alumno.instructor_id','=','instructores.id')
                        ->select('credenciales_alumno.*', 'instructores.nombre as instructor_nombre', 'instructores.apellido as instructor_apellido', 'instructores.id as instructor_id', 'instructores.sexo')
                        ->where('credenciales_alumno.alumno_id',$usuario_id)
                    ->get();

                    $array_credencial = array();
                    $total_credenciales = 0;

                    foreach($credenciales_alumno as $credencial_alumno){

                        $instructor = User::join('usuarios_tipo', 'usuarios_tipo.usuario_id', '=', 'users.id')
                            ->where('usuarios_tipo.tipo',3)
                            ->where('usuarios_tipo.tipo_id',$credencial_alumno->instructor_id)
                        ->first();

                        if($instructor){

                          if($instructor->imagen){
                            $imagen = $instructor->imagen;
                          }else{
                            $imagen = '';
                          }

                        }

                        $collection=collect($credencial_alumno);     
                        $credencial_array = $collection->toArray();
                            
                        $credencial_array['imagen']=$imagen;
                        $array_credencial[$credencial_alumno->id] = $credencial_array;

                        $total_credenciales = $total_credenciales + $credencial_alumno->cantidad;
                    }
                    
                    return view('vista_alumno.index')->with(['academia' => $academia, 'enlaces' => $arreglo , 'clases_grupales' => $contador_clase, 'talleres' => $contador_taller , 'fiestas' =>  $contador_fiesta ,'contador_campana' => $contador_campana ,'regalos' => Regalo::where('academia_id', '=' ,  Auth::user()->academia_id)->get(), 'perfil' => $tiene_perfil, 'instructor_contador' => $instructor_contador, 'clase_personalizada_contador' => $clase_personalizada_contador, 'alumno_examenes' => $alumno_examenes, 'alumno' => $alumno, 'credenciales_alumno' => $array_credencial, 'total_credenciales' => $total_credenciales, 'campanas' => $campanas]);  
                    
                }else{
                    return view('vista_alumno.condiciones')->with('academia', $academia);
                }
            }else if($usuario_tipo == 3){


                $instructor = Instructor::find($usuario_id);

                if(!$instructor){
                    return view('inicio.cuenta-deshabilitada');
                }

                return view('vista_instructor.index')->with(['academia' => $academia, 'instructor' => $instructor]);  
            }
        }else{
            return redirect("/seleccionar-tipo");
        }
                           
	}

    public function menu(){

        $usuario_tipo = Session::get('easydance_usuario_tipo');

        if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6){
            return view('menu.index');
        }else{
            return redirect("/inicio"); 
        }
        
    }

    /**
      * PAGOS RECURRENTES o MENSUALIDADES
      * Var $tipo => Tipo de Accion,
      *     $result => Arreglo donde se guarda
                       la respuesta a mostrar, podria
                       no usuarse mas adelante.
      *     $cantidad => Valor Cantidad de la Base de Datos,
                         en este caso sera una constante.
      *     $ConfigClasesGrupales => consulta al modelo de Configuracion
                                    de clases grupales para obtener los
                                    datos de la clase
            $InscripcionClaseGrupal => Consulta al modelo de Inscripcion de
                                    de clase grupales para verificar si hay
                                    alumnos inscritos, para luego cargarles
                                    una deuda en caso de tenerla
            $FacturaProforma => Consulta al modelo de detalles de
                                Proforma para verificar si hay deuda para
                                no cargarle una misma deuda mas de una vez           
      */
    public function pagorecurrente()
    {
        $result = array();
        $tipo = 4;
        $cantidad = 1;
        $id = 0;
        $academia = Academia::find(Auth::user()->academia_id);
        $academia->fecha_comprobacion = Carbon::now()->toDateString();
        $academia->save();

        $ConfigClasesGrupales = ConfigClasesGrupales::select('config_clases_grupales.id',
                'config_clases_grupales.nombre','config_clases_grupales.costo_inscripcion',
                'config_clases_grupales.costo_mensualidad', 'clases_grupales.id',
                'clases_grupales.fecha_inicio', 'clases_grupales.fecha_final',
                'clases_grupales.fecha_inicio_preferencial', 'clases_grupales.id as clase_grupal_id')
                ->join('clases_grupales', 'clases_grupales.clase_grupal_id','=','config_clases_grupales.id')
                ->where('clases_grupales.academia_id','=', Auth::user()->academia_id)
                ->where('clases_grupales.deleted_at', '=', null)
                ->where('clases_grupales.fecha_final', '>', Carbon::now()->format("Y-m-d"))
                ->get();

        $InscripcionClaseGrupal = InscripcionClaseGrupal::select('inscripcion_clase_grupal.clase_grupal_id AS ClaseGrupalID', 
            'inscripcion_clase_grupal.alumno_id AS AlumnoId',
            'inscripcion_clase_grupal.fecha_pago', 
            'alumnos.identificacion AS Identificacion', 'alumnos.nombre AS NombreAlumno', 
            'alumnos.apellido AS ApellidoAlumno', 'alumnos.telefono AS TelefonoAlumno', 
            'alumnos.celular as CelularAlumno','config_clases_grupales.nombre AS ClaseNombre', 'inscripcion_clase_grupal.id as InscripcionID', 'inscripcion_clase_grupal.costo_mensualidad AS Costo')
            ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id','=',
                   'clases_grupales.id')
            ->join('alumnos', 'inscripcion_clase_grupal.alumno_id','=','alumnos.id')
            ->join('config_clases_grupales', 'config_clases_grupales.id','=',
                   'clases_grupales.clase_grupal_id')
            ->where('inscripcion_clase_grupal.deleted_at', '=', null)
        ->get();
        
            //Desgloso la Fecha Preferencial
        foreach ($InscripcionClaseGrupal as $InscripcionClase ) {

            $fecha_cuota_explode=explode('-', $InscripcionClase->fecha_pago);

            foreach ($ConfigClasesGrupales as $configClases) {

                $fecha_inicio_preferencial = Carbon::createFromFormat('Y-m-d', $configClases->fecha_inicio_preferencial);

                if ($fecha_inicio_preferencial <= Carbon::now()){

                    $fecha_inicio_preferencial = $fecha_inicio_preferencial->addMonth()->toDateString();

                    $clase_grupal = ClaseGrupal::find($configClases->clase_grupal_id);
                    $clase_grupal->fecha_inicio_preferencial = $fecha_inicio_preferencial;
                    $clase_grupal->save();

                }

                $fecha_pago = Carbon::createFromFormat('Y-m-d', $InscripcionClase->fecha_pago);

                if ($fecha_pago <= Carbon::now()){

                    if($configClases->id == $InscripcionClase->ClaseGrupalID){

                        $FacturaProforma = ItemsFacturaProforma::select(
                        'items_factura_proforma.tipo', 
                        'items_factura_proforma.usuario_id')
                        ->where('items_factura_proforma.tipo','=',$tipo)
                        ->where('items_factura_proforma.usuario_id', '=', $InscripcionClase->AlumnoId)
                        ->where('items_factura_proforma.item_id', '=', $configClases->clase_grupal_id)
                        ->get()->count();

                        /** AQUI CONVERTIMOS LA FECHA PREFERENCIAL PARA PODER
                            OBTENER LA FECHA LIMITE DE PAGO **/
                        $fecha_cuota = Carbon::create($fecha_cuota_explode[0], $fecha_cuota_explode[1], $fecha_cuota_explode[2],0);

                        /** AQUI CALCULAMOS LA FECHA FECHA LIMITE DE PAGO **/
                        $tolerancia = $fecha_cuota->addDay($configClases->tiempo_tolerancia)->toDateString();
                        
                        if($FacturaProforma == 0 && $InscripcionClase->Costo > 0){

                            $fecha_final = Carbon::createFromFormat('Y-m-d', $configClases->fecha_final);

                            if($fecha_final > Carbon::now()){
                                
                                $fecha_cuota = $fecha_cuota->addMonth()->toDateString();
                                
                                $clasegrupal = InscripcionClaseGrupal::find($InscripcionClase->InscripcionID);

                                $clasegrupal->fecha_pago = $fecha_cuota;
                                $clasegrupal->save();

                                $item_factura = new ItemsFacturaProforma;
                                
                                $item_factura->usuario_id = $InscripcionClase->AlumnoId;
                                $item_factura->usuario_tipo = 1;
                                $item_factura->academia_id = Auth::user()->academia_id;
                                $item_factura->fecha = Carbon::now()->toDateString();
                                $item_factura->item_id = $configClases->id;
                                $item_factura->nombre = 'Cuota ' . $configClases->nombre;
                                $item_factura->tipo = $tipo;
                                $item_factura->cantidad = $cantidad;
                                $item_factura->importe_neto = $InscripcionClase->Costo;
                                $item_factura->fecha_vencimiento = Carbon::now()->toDateString();

                                $item_factura->save();

                            }

                        }
                                        
                    }
                                 
	            }    
	        }
	    }

        return $this->tiempotolerancia();
    }

    public function tiempotolerancia(){

        $academia = Academia::find(Auth::user()->academia_id);
        $contador_clase = 0;
        $contador_taller = 0;
        $contador_fiesta = 0;
        $contador_campana = 0;

        $tipo = 8;

        $ConfigClasesGrupales = ConfigClasesGrupales::select('config_clases_grupales.id',
                'config_clases_grupales.nombre','config_clases_grupales.costo_inscripcion',
                'config_clases_grupales.costo_mensualidad', 'clases_grupales.id',
                'clases_grupales.fecha_inicio', 'clases_grupales.fecha_final',
                'clases_grupales.fecha_inicio_preferencial', 'config_clases_grupales.tiempo_tolerancia', 'config_clases_grupales.porcentaje_retraso')
                        ->join('clases_grupales', 'clases_grupales.clase_grupal_id','=','config_clases_grupales.id')
                        ->get();

        $InscripcionClaseGrupal = InscripcionClaseGrupal::select('inscripcion_clase_grupal.clase_grupal_id AS ClaseGrupalID', 
            'inscripcion_clase_grupal.alumno_id AS AlumnoId',
            'inscripcion_clase_grupal.fecha_pago', 
            'alumnos.identificacion AS Identificacion', 'alumnos.nombre AS NombreAlumno', 
            'alumnos.apellido AS ApellidoAlumno', 'alumnos.telefono AS TelefonoAlumno', 
            'alumnos.celular as CelularAlumno','config_clases_grupales.nombre AS ClaseNombre', 'inscripcion_clase_grupal.id as InscripcionID', 'inscripcion_clase_grupal.costo_mensualidad AS Costo')
                ->join('clases_grupales', 'inscripcion_clase_grupal.clase_grupal_id','=',
                       'clases_grupales.id')
                ->join('alumnos', 'inscripcion_clase_grupal.alumno_id','=','alumnos.id')
                ->join('config_clases_grupales', 'config_clases_grupales.id','=',
                       'clases_grupales.clase_grupal_id')
                ->get();
        
        
            //Desgloso la Fecha Preferencial
        foreach ($InscripcionClaseGrupal as $InscripcionClase ) {

        	foreach ($ConfigClasesGrupales as $configClases) {

                if($configClases->id == $InscripcionClase->ClaseGrupalID){

                    $FacturaProforma = ItemsFacturaProforma::select(
                    'items_factura_proforma.tipo', 
                    'items_factura_proforma.usuario_id')
                    ->where('items_factura_proforma.tipo','=',$tipo)
                    ->where('items_factura_proforma.usuario_id', '=', $InscripcionClase->AlumnoId)
                    ->get()->count();

                    /** AQUI CONVERTIMOS LA FECHA PREFERENCIAL PARA PODER
                        OBTENER LA FECHA LIMITE DE PAGO **/

                    $fecha_cuota_explode=explode('-', $InscripcionClase->fecha_pago);
                    $fecha_cuota = Carbon::create($fecha_cuota_explode[0], $fecha_cuota_explode[1], $fecha_cuota_explode[2],0);

                    /** AQUI CALCULAMOS LA FECHA FECHA LIMITE DE PAGO **/
                    $tolerancia = $fecha_cuota->addDay($configClases->tiempo_tolerancia)->toDateString();
                    
                        //CONDICION PARA EL TIEMPO DE TOLERANCIA, SI SE CUMPLE
                        //CALCULARA SEGUN EL PORCENTAJE CONFIGURADO Y SE LE SUMARA
                        //AL MONTO DE LA CUOTA
                    $clasegrupal = InscripcionClaseGrupal::find($InscripcionClase->InscripcionID);

                        
                   	if($FacturaProforma != 0 && Carbon::now()->format('Y-m-d') > $tolerancia && $clasegrupal->tiene_mora == 0 && $configClases->porcentaje_retraso){

                        $mora = ($configClases->costo_mensualidad * $configClases->porcentaje_retraso)/100;

                        if($mora > 0)
                        {
                            $item_factura = new ItemsFacturaProforma;
                                                        
                            $item_factura->usuario_id = $InscripcionClase->AlumnoId;
                            $item_factura->usuario_tipo = 1;
                            $item_factura->academia_id = Auth::user()->academia_id;
                            $item_factura->fecha = Carbon::now()->toDateString();
                                                            //$item_factura->item_id = $id;
                            $item_factura->nombre = 'Mora por retraso de pago Cuota ' .  $configClases->nombre;
                            $item_factura->tipo = 4;
                            $item_factura->cantidad = 1;
                            $item_factura->importe_neto = $mora;
                            $item_factura->fecha_vencimiento = Carbon::now()->toDateString();

                            $item_factura->save();

                            $clasegrupal->tiene_mora = 1;
                            $clasegrupal->save();
                        }

                    }
                }
            }
        }

        $acuerdos = Acuerdo::where('academia_id', Auth::user()->academia_id)->get();

        foreach($acuerdos as $acuerdo){

            $proformas = ItemsFacturaProforma::where('tipo',6)->where('item_id', $acuerdo->id)->get();

            foreach($proformas as $proforma){
                $fecha = Carbon::createFromFormat('Y-m-d', $proforma->fecha_vencimiento);

                $fecha->addDays($acuerdo->tiempo_tolerancia);

                if(Carbon::now() > $fecha && $proforma->tiene_mora == 0 && $acuerdo->porcentaje_retraso){

                    $mora = ($proforma->importe_neto * $acuerdo->porcentaje_retraso)/100;

                    $item_factura = new ItemsFacturaProforma;
                                                
                    $item_factura->usuario_id = $acuerdo->usuario_id;
                    $item_factura->usuario_id = $acuerdo->usuario_tipo;
                    $item_factura->academia_id = Auth::user()->academia_id;
                    $item_factura->fecha = Carbon::now()->toDateString();
                    $item_factura->nombre = 'Mora por retraso de pago ' .  $proforma->nombre;
                    $item_factura->tipo = 6;
                    $item_factura->cantidad = 1;

                    $item_factura->importe_neto = $mora;
                    $item_factura->fecha_vencimiento = Carbon::now()->toDateString();

                    $item_factura->save();

                    $proforma->tiene_mora = 1;

                    $proforma->save();

                }

            }
            
        }
        return $this->index();
    }

    public function inactividad(){

        $id = Session::get('easydance_usuario_id');
        $alumno = Alumno::find($id);

        if($alumno){

            $inscripciones = InscripcionClaseGrupal::where('alumno_id',$id)->get();
            $fecha_registro = Carbon::createFromFormat('Y-m-d H:i:s', $alumno->created_at);
            $asistencia_roja = 6;
            $in = array(1,2);
            $status = true;

            foreach($inscripciones as $inscripcion_clase_grupal){

                $inasistencias = 0;

                $clase_grupal = ClaseGrupal::find($inscripcion_clase_grupal->clase_grupal_id);

                if($clase_grupal){

                    $horario = HorarioClaseGrupal::where('clase_grupal_id',$clase_grupal->clase_grupal_id)->first();
                    $fecha_clase = Carbon::createFromFormat('Y-m-d', $clase_grupal->fecha_inicio);

                    if($fecha_registro > $fecha_clase){
                        $fecha_clase = $fecha_registro;
                    }

                    // CASO ESPECIFICO, SI TRANSFIEREN A UN ALUMNO DE CLASE GRUPAL A OTRA, ESTE QUEDA COMO INACTIVO Y NO PUEDE ACCEDER AL SISTEMA, EN ESTE CASO SE LE AÑADE UNA FECHA PRORROGA PARA ACCEDER AL SISTEMA

                    if($inscripcion_clase_grupal->fecha_a_comparar){
                        $fecha_a_comparar = Carbon::createFromFormat('Y-m-d', $inscripcion_clase_grupal->fecha_a_comparar);
                        if($fecha_a_comparar > $fecha_clase){
                            $fecha_clase = $fecha_a_comparar;
                        }
                    }

                    if($fecha_clase <= Carbon::now()){

                        if($horario){

                            $fecha_horario = Carbon::createFromFormat('Y-m-d', $horario->fecha);
                            $dia_clase = $fecha_clase->dayOfWeek;
                            $dia_horario = $fecha_horario->dayOfWeek;

                            $dias = abs($dia_clase - $dia_horario);

                        }else{
                            $dias = 7;
                        }

                        $ultima_asistencia_clase = Asistencia::where('tipo',1)->where('alumno_id',$id)->orderBy('created_at', 'desc')->first();

                        $ultima_asistencia_horario = Asistencia::where('tipo',2)->where('alumno_id',$id)->orderBy('created_at', 'desc')->first();

                        if($ultima_asistencia_horario OR $ultima_asistencia_clase){

                            if($ultima_asistencia_horario){
                                if($ultima_asistencia_clase){
                                    $fecha_horario = Carbon::createFromFormat('Y-m-d', $ultima_asistencia_horario->fecha);
                                    $fecha_clase = Carbon::createFromFormat('Y-m-d', $ultima_asistencia_clase->fecha);

                                    if($fecha_clase > $fecha_horario){
                                        $fecha = Carbon::createFromFormat('Y-m-d', $ultima_asistencia_clase->fecha);
                                    }else{
                                        $fecha = Carbon::createFromFormat('Y-m-d', $ultima_asistencia_horario->fecha);
                                    }

                                }else{
                                    $fecha = Carbon::createFromFormat('Y-m-d', $ultima_asistencia_horario->fecha);
                                }

                            }else{
                                $fecha = Carbon::createFromFormat('Y-m-d', $ultima_asistencia_clase->fecha);
                            }
                        }else{
                            $fecha = $fecha_clase;
                        }

                        while($fecha <= Carbon::now())
                        {
                            $fecha_a_comparar = $fecha->toDateString();

                            $horario_bloqueado = HorarioBloqueado::where('fecha_inicio', '<=', $fecha_a_comparar)
                                ->where('fecha_final', '>=', $fecha_a_comparar)
                                ->where('tipo_id', $clase_grupal->id)
                                ->whereIn('tipo', $in)
                            ->first();

                            if(!$horario_bloqueado){
                                $fecha->addDays($dias);
                                $inasistencias++;
                            }
                            
                        }
                        
                        if($inasistencias <= $asistencia_roja){
                            $status = true;
                            break;
                        }else{
                            $status = false;
                        }

                    }
                    
                }

            }

            if($status){
                Session::put('fecha_comprobacion',Carbon::now()->toDateString());
                return $this->index();
            }else{
                return view('inicio.cuenta-deshabilitada');
            }
        }else{
            return view('inicio.cuenta-deshabilitada');
        }
    }

    public function listo()
    {       
        return view('flujo_registro.listo');                    
    }

    public function confirmarVencimiento($id)
    {
        $vencimiento = VencimientoClaseGrupal::find($id);

        if($vencimiento->delete()){
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }else{
            return response()->json(['mensaje' => '¡Excelente! Los campos se han guardado satisfactoriamente', 'status' => 'OK', 200]);
        }
    }
}
