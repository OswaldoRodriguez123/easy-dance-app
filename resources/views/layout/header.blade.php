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
                                    <a href="{{url('configuracion/proveedor')}}"><i class="zmdi zmdi-truck"></i> Proveedores</a>
                                </li>

                                <li class="hidden-xs">
                                    <a href="{{url('configuracion/productos')}}"><i class="zmdi icon_f-productos f-16"></i> Productos</a>
                                </li>

                                <li class="hidden-xs">
                                    <a href="{{url('configuracion/servicios')}}"><i class="zmdi icon_f-servicios f-16"></i> Servicios</a>
                                </li>


                                <li class="hidden-xs">
                                    <a href="{{url('configuracion/paquetes')}}"><i class="zmdi icon_a-paquete f-16"></i> Paquetes</a>
                                </li>

                                <li class="hidden-xs">
                                    <a href="{{url('configuracion/staff')}}"><i class="zmdi icon_f-staff f-16"></i> Staff</a>
                                </li>

                                <li class="hidden-xs">
                                    <a href="{{url('configuracion/administradores')}}"><i class="zmdi zmdi-key f-16"></i> Administradores</a>
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
                                <li class="hidden-xs">
                                    <a href="{{url('/')}}/invitar"><i class="zmdi icon_d-invitar"></i> Invitar</a>
                                </li>
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
                                    <a href="{{url('incidencias')}}"><i class="zmdi icon_f-incidencias f-16"></i> Generar Incidencias</a>
                                </li>
                                <li class="hidden-xs">
                                    <a href="{{url('agendar/citas')}}"><i class="zmdi zmdi-calendar-check f-16"></i> Citas y Llamadas</a>
                                </li>
                                <li class="hidden-xs">
                                    <a href="{{url('agendar/transmisiones')}}"><i class="zmdi zmdi-camera-add f-16"></i> Generar Transmisiones</a>
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

                            <li style="margin-top: 26px; right: 50%">
                                <a class="f-15 text-header f-700" href="{{url('/')}}/programacion"><span class="f-15 text-header f-700">PASO A PASO</span></a>
                            </li>
                        @endif
                    @endif

                    <li class="dropdown">
                        <a data-toggle="dropdown" id="numero_de_notificaciones" href="#">
                            <i class="tm-icon zmdi zmdi-notifications"></i>
                            <i class="tmn-counts" id="numero_actual">{{$sin_ver}}</i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg pull-right">
                            @if(!empty($notificaciones))
                                <div class="listview" id="notifications">
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
                                            @if ($notificacion['tipo_evento'] == 1)
                                                <a class="lv-item {{ empty($notificacion['visto']) ? 'bgm_notificacion_sin_ver' : '' }}" href="{{url('/')}}/agendar/clases-grupales/progreso/{{$notificacion['evento_id']}}">
                                            @elseif ($notificacion['tipo_evento'] == 5)
                                                <a class="lv-item {{ empty($notificacion['visto']) ? 'bgm_notificacion_sin_ver' : '' }}" href="{{url('/')}}/notificaciones">
                                            @elseif($notificacion['tipo_evento'] == 6)
                                                <a class="lv-item {{ empty($notificacion['visto']) ? 'bgm_notificacion_sin_ver' : '' }}" href="{{url('/')}}/evaluaciones/detalle/{{$notificacion['evento_id']}}">
                                            @else
                                                <a class="lv-item {{ empty($notificacion['visto']) ? 'bgm_notificacion_sin_ver' : '' }}" href="{{url('/')}}/incidencias">
                                            @endif
                                                <div class="media">
                                                    <div class="pull-left">
                                                        <!-- if($notificacion->imagen) -->
                                                            <img class="img-circle" src="{{url('/')}}{{$notificacion['imagen']}}" alt="" width="45px" height="auto">
                                                       <!--  else
                                                            <img class="img-circle" src="{{url('/')}}/assets/img/asd_.jpg" alt="" width="45px" height="auto">
                                                        endif -->
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="lv-title">{{$notificacion['titulo']}}</div>
                                                        <small class="lv-small">{{$notificacion['mensaje']}}</small>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="listview empty" id="notifications">
                                    <div class="lv-header">Notificaciones
                                        <ul class="actions">
                                            <li class="dropdown"></li>
                                        </ul>
                                    </div>
                                    <div class="lv-body"></div>
                                </div>
                            @endif
                        </div>
                    </li>
      
                    <li class="dropdown">

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

                            <?php $tmp = explode(" ", Auth::user()->nombre);
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
                                @if($usuario_tipo == 3)
                                    <li class="hidden-xs">
                                        <a href="{{url('perfil-profesional')}}"><i class="zmdi zmdi-account"></i> Perfil Profesional</a>
                                    </li>
                                @endif
                            @endif

                            @if(Auth::check())
                                @if($usuario_tipo == 3 || $usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
                                    <li class="hidden-xs">
                                        <a href="{{url('configuracion/eventos-laborales')}}"><i class="zmdi zmdi-calendar-check f-16"></i> Calendario Laboral</a>
                                    </li>
                                @endif
                            @endif

                            @if(Auth::check())
                                @if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
                                    <li class="hidden-xs">
                                        <a href="{{url('supervisiones')}}"><i class="zmdi icon_f-staff f-16"></i> Supervisiones</a>
                                    </li>

                                    <li class="hidden-xs">
                                        <a href="{{url('configuracion')}}"><i class="zmdi zmdi-settings"></i> Configuración General</a>
                                    </li>
                                @endif

                                @if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6 || $usuario_tipo == 3)
                                    <li class="hidden-xs">
                                        <a href="{{url('procedimientos')}}"><i class="zmdi icon_a-tutoriales"></i> Manuales de Procedimientos</a>
                                    </li>
                                @endif

                                @if($usuario_tipo)
                                    <li class="hidden-xs">
                                        <a href="{{url('normativas')}}"><i class="zmdi icon_a-tutoriales"></i> Normativas</a>
                                    </li>
                                @endif

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