<header id="header" class="clearfix" data-current-skin="purple">
    <ul class="header-inner">
        @if(Auth::check())
            @if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
                <li id="menu-trigger" data-trigger="#sidebar">
                    <div class="line-wrap" data-original-title="" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="Menú">
                        <div class="line top"></div>
                        <div class="line center"></div>
                        <div class="line bottom"></div>
                    </div>
                </li>
            @endif
        @endif

        <li class="logo hidden-xs" popover-placement="bottom" popover-trigger="mouseenter" popover="Inicio">
            <a data-ui-sref="home" href="{{ empty(Auth::check()) ? 'http://easydancelatino.com/' : '/inicio'}}"><img src="{{url('/')}}/assets/img/logo.png" class="img-opaco p-b-0 m-b-0 p-r-0 m-r-0" width="90">
            <sub class="beta text-capitalize f-12 text-right">beta</sub></a>
        </li>

        <li class="pull-right m-r-5">
            <ul class="top-menu">

                @if(Auth::check())
                    @if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)

                        <li class="dropdown" type="button" data-trigger="hover" data-animation="fadeInLeft,fadeOutLeft,600" style="margin-top: 26px; right: 60%">
                            <a href="{{ empty(Auth::check()) ? 'http://easydancelatino.com/' : '/inicio'}}">
                               <span class="f-15 text-header f-700">INICIO</span>
                            </a>
                        </li>

                        <li class="dropdown" style="margin-top: 26px; right: 55%">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft">
                               <span class="f-15 f-700 text-header">HERRAMIENTAS</span>
                            </a>
                            <ul class="dropdown-menu dm-icon pull-right">
                                <li class="hidden-xs">
                                    <a href="{{url('proveedores')}}"><i class="zmdi zmdi-truck"></i> Proveedores</a>
                                </li>

                                <li class="hidden-xs">
                                    <a href="{{url('productos')}}"><i class="zmdi icon_f-productos f-16"></i> Productos</a>
                                </li>

                                <li class="hidden-xs">
                                    <a href="{{url('servicios')}}"><i class="zmdi icon_f-servicios f-16"></i> Servicios</a>
                                </li>


                                <li class="hidden-xs">
                                    <a href="{{url('paquetes')}}"><i class="zmdi icon_a-paquete f-16"></i> Paquetes</a>
                                </li>

                                <li class="hidden-xs">
                                    <a href="{{url('blog')}}"><i class="zmdi glyphicon glyphicon-book f-16"></i> Blog</a>
                                </li>
                            </ul>
                        </li>

                         <li class="dropdown" style="margin-top: 26px; right: 50%">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft">
                               <span class="f-15 f-700 text-header">ACCIONES</span>
                            </a>
                            <ul class="dropdown-menu dm-icon pull-right">

                                @if($usuario_tipo == 1 || $usuario_tipo == 5)
                                    <li class="hidden-xs">
                                        <a href="{{url('/')}}/invitar"><i class="zmdi icon_d-invitar"></i> Invitar</a>
                                    </li>
                                @endif
                                <li class="hidden-xs">
                                    <a href="{{url('validar')}}"><i class="zmdi zmdi-check f-16"></i> Validar</a>
                                </li>
                                <li class="hidden-xs">
                                    <a href="{{url('correo')}}"><i class="zmdi zmdi-email f-16"></i> Enviar Correo</a>
                                </li>
                                <li class="hidden-xs">
                                    <a href="{{url('mensajes')}}"><i class="zmdi zmdi-smartphone f-16"></i> Enviar Mensaje</a>
                                </li>
                                <li class="hidden-xs">
                                    <a href="{{url('agendar/citas')}}"><i class="zmdi zmdi-calendar-check f-16"></i> Citas y Llamadas</a>
                                </li>
                                <li class="hidden-xs">
                                    <a href="{{url('agendar/transmisiones')}}"><i class="zmdi zmdi-camera-add f-16"></i> Generar Transmisiones</a>
                                </li>
                                <li class="hidden-xs">
                                    <a href="{{url('administrativo/comisiones')}}"><i class="zmdi icon_a-pagar f-16"></i> Pagos de Staff</a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if(Auth::check())
                        @if($usuario_tipo == 2 || $usuario_tipo == 4)
                            <li class="dropdown" type="button" data-trigger="hover" data-animation="fadeInLeft,fadeOutLeft,600" style="margin-top: 26px; right: 60%">
                                <a href="{{ empty(Auth::check()) ? 'http://easydancelatino.com/' : '/inicio'}}">
                                   <span class="f-15 text-header f-700">INICIO</span>
                                </a>
                            </li>

                            <li style="margin-top: 26px; right: 55%">
                                <a class="f-15 text-header f-700" href="{{url('/')}}/progreso"><span class="f-15 text-header f-700">MI PROGRESO</span></a>
                            </li>

                            <li class="dropdown" style="margin-top: 26px; right: 50%">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft">
                                   <span class="f-15 f-700 text-header">PASO A PASO</span>
                                </a>
                                <ul class="dropdown-menu dm-icon pull-right">
                                    <li class="hidden-xs">
                                        <a href="{{url('programacion/salsa')}}"><i class="zmdi icon_a-instructor"></i> Salsa</a>
                                    </li>

                                    <li class="hidden-xs">
                                        <a href="{{url('programacion/bachata')}}"><i class="zmdi icon_a-clase-personalizada f-16"></i> Bachata</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    @endif

                    <li class="dropdown">
                        <a data-toggle="dropdown" id="numero_de_notificaciones" href="#">
                            <i class="tm-icon zmdi zmdi-notifications"></i>
                            @if($notificaciones_pendientes > 0)
                                <i class="tmn-counts" id="numero_actual">{{$notificaciones_pendientes}}</i>
                            @else
                                <i class="tmn-counts" id="numero_actual" style="background: #5e5e5e">{{$notificaciones_pendientes}}</i>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg pull-right">
                            <div class="listview {{ empty($notificaciones) ? 'empty' : ''}}" id="notifications">
                                <div class="lv-header">Notificaciones
                                    <ul class="actions">
                                        <li class="dropdown">
                                            <a href="#" data-clear="notification" id="limpiar_notificaciones">
                                                <i class="zmdi zmdi-check-all"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="lv-body">
                                    @foreach( $notificaciones as $notificacion)
                                        <a class="lv-item {{ empty($notificacion['visto']) ? 'bgm_notificacion_sin_ver' : '' }}" href="{{url('/')}}/{{$notificacion['url']}}">
                                            <div class="media" style="border-bottom: 1px solid #F0F0F0">
                                                <div class="pull-left">
                                                    <img class="img-circle" src="{{url('/')}}{{$notificacion['imagen']}}" alt="" width="45px" height="auto">
                                                </div>
                                                <div class="media-body">
                                                    <div class="lv-title">{{$notificacion['titulo']}}</div>
                                                    <small class="lv-small" style="padding-bottom: 15px">
                                                        {{$notificacion['mensaje']}}
                                                        <br><br>
                                                        {{$notificacion['fecha_de_realizacion']}}
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="text-center m-5">
                                <a href="{{url('/')}}/notificaciones"><b>Ver Todos</b></a>
                            </div>
                        </div>
                    </li>
      
                    <li class="dropdown" id="dropdown_perfil">

                        <a href="#" style="color:white" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft">

                            @if(Auth::user()->imagen)
                                <img id="foto_perfil" class="img-circle" src="{{url('/')}}/assets/uploads/usuario/{{Auth::user()->imagen}}" alt="" width="45px" height="auto">  
                            @else
                                @if(Auth::user()->sexo=='F')
                                    <img id="foto_perfil" class="img-circle" src="{{url('/')}}/assets/img/profile-pics/1.jpg" alt="" width="45px" height="auto">        
                                @else
                                    <img id="foto_perfil" class="img-circle" src="{{url('/')}}/assets/img/profile-pics/2.jpg" alt="" width="45px" height="auto">
                                @endif
                            @endif

                            <br>
                            
                            <span class="f-700 f-14"> 
                                <?php 
                                    $tmp = explode(" ", Auth::user()->nombre);
                                    $nombre_usuario = $tmp[0];

                                    $tmp = explode(" ", Auth::user()->apellido);
                                    $apellido_usuario = $tmp[0];
                                ?>

                                {{$nombre_usuario}} {{$apellido_usuario}} 
                            </span>

                        </a>
                        <ul class="dropdown-menu dm-icon pull-right">
                            <li class="hidden-xs">
                                <a href="{{url('/')}}/perfil"><i class="zmdi zmdi-account"></i> Mi Perfil</a>
                            </li>


                            @if(Auth::check())
                                @if($usuario_tipo == 1 || $usuario_tipo == 5)
                                    <li class="hidden-xs">
                                        <a href="{{url('configuracion/administradores')}}"><i class="zmdi zmdi-key f-16"></i> Administradores</a>
                                    </li>
                                @endif

                                @if($usuario_tipo == 3)
                                    <li class="hidden-xs">
                                        <a href="{{url('perfil-profesional')}}"><i class="zmdi zmdi-account"></i> Perfil Profesional</a>
                                    </li>
                                @endif
                            @endif

                            @if(Auth::check())
                                @if($usuario_tipo == 1 || $usuario_tipo == 5)
                                    <li class="hidden-xs">
                                        <a href="{{url('configuracion')}}"><i class="zmdi zmdi-settings"></i> Configuración General</a>
                                    </li>
                                @endif

                                <li class="sub-menu pointer">
                                    <a><i class="zmdi fa fa-tasks f-16"></i> Registros</a>
                                    <ul class="ul_sub-menu" style="border-top: 1px solid #F0F0F0; border-bottom: 1px solid #F0F0F0">   

                                        <li class="hidden-xs">
                                            <a href="{{url('supervisiones')}}"><i class="zmdi icon_f-staff f-16"></i> <span class="m-l-5">Reservaciones</span></a>
                                        </li>

                                        <li class="hidden-xs">
                                            <a href="{{url('configuracion/staff')}}"><i class="zmdi icon_f-staff f-16"></i> <span class="m-l-5">Credenciales</span></a>
                                        </li>

                                        <li class="hidden-xs">
                                            <a href="{{url('incidencias')}}"><i class="zmdi icon_f-incidencias f-16"></i> <span class="m-l-5">Puntos</span></a>
                                        </li>
               
  
                                        <li class="hidden-xs">
                                            <a href="{{url('configuracion/eventos-laborales')}}"><i class="zmdi zmdi-calendar-check f-16"></i> <span class="m-l-5">Notas de alumnos</span></a>
                                        </li>

                                        <li class="hidden-xs">
                                            <a href="{{url('procedimientos')}}"><i class="zmdi icon_a-tutoriales"></i> <span class="m-l-5">Encuestas realizadas</span></a>
                                        </li>

                                        <li class="hidden-xs">
                                            <a href="{{url('llamadas')}}"><i class="zmdi zmdi-phone f-16"></i> <span class="m-l-5">Registro de llamadas</span></a>
                                        </li>
                       
                                        <li class="hidden-xs">
                                            <a href="{{url('participante/alumno/congelados')}}"><i class="zmdi icon_a-tutoriales"></i> <span class="m-l-5">Congelados</span></a>
                                        </li>

                                         <li class="hidden-xs">
                                            <a href="{{url('participante/alumno')}}"><i class="zmdi icon_a-tutoriales"></i> <span class="m-l-5">Cuentas activas</span></a>
                                        </li>
                                 
          
                                    </ul>
                                </li>
               

                                <li class="sub-menu pointer">
                                    <a><i class="zmdi icon_f-staff f-16"></i> Sección Laboral</a>
                                    <ul class="ul_sub-menu" style="border-top: 1px solid #F0F0F0; border-bottom: 1px solid #F0F0F0">   
                                        @if($usuario_tipo == 1 || $usuario_tipo == 5)

                                            <li>
                                                <a href="{{url('supervisiones')}}"><i class="zmdi icon_f-staff f-16"></i> <span class="m-l-5">Supervisiones</span></a>
                                            </li>

                                            <li class="hidden-xs">
                                                <a href="{{url('configuracion/staff')}}"><i class="zmdi icon_f-staff f-16"></i> <span class="m-l-5">Staff</span></a>
                                            </li>

                                            <li class="hidden-xs">
                                                <a href="{{url('incidencias')}}"><i class="zmdi icon_f-incidencias f-16"></i> <span class="m-l-5">Generar Incidencias</span></a>
                                            </li>
                                        @endif
      
                                        @if($usuario_tipo == 3 || $usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
                                            <li class="hidden-xs">
                                                <a href="{{url('configuracion/eventos-laborales')}}"><i class="zmdi zmdi-calendar-check f-16"></i> <span class="m-l-5">Calendario Laboral</span></a>
                                            </li>

                                            <li class="hidden-xs">
                                                <a href="{{url('procedimientos')}}"><i class="zmdi icon_a-tutoriales"></i> <span class="m-l-5">Manuales de Procedimientos</span></a>
                                            </li>
                                        @endif

                                        @if($usuario_tipo)
                                            <li class="hidden-xs">
                                                <a href="{{url('normativas')}}"><i class="zmdi icon_a-tutoriales"></i> <span class="m-l-5">Normativas</span></a>
                                            </li>
                                        @endif
          
                                    </ul>
                                </li>

                            @endif 

                            <li>
                                <a href="{{url('/')}}/logout"><i class="zmdi zmdi-time-restore"></i> Cerrar Sesión</a>
                            </li>
                        </ul>
                    </li> 

                    @if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
                        <li data-content="Asistencia" data-toggle="popover" data-trigger="hover" type="button" data-toggle="tooltip" data-placement="bottom" title="" class="pointer" >
                                <a class="tm-config" href="{{url('/')}}/asistencia/generar" target="_blank"><i class="tm-icon zmdi zmdi-shield-check f-18 f-18"></i></a>
                        </li>
                    @endif
                @endif
            </ul>
        </li>
    </ul>

    <div id="top-search-wrap">
        <div class="tsw-inner">
            <i id="top-search-close" class="zmdi zmdi-arrow-left"></i>
            <input type="text">
        </div>
    </div>
</header>