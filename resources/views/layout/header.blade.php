<header id="header" class="clearfix" data-current-skin="orange">
            <ul class="header-inner">
            @if(Auth::check() && (Auth::user()->usuario_tipo == 1 || Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6))
                <li id="menu-trigger" data-trigger="#sidebar">
                    <div class="line-wrap" data-original-title="" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="Menú">
                        <div class="line top"></div>
                        <div class="line center"></div>
                        <div class="line bottom"></div>
                    </div>
                </li>
            @endif

                <!--<li class="logo hidden-xs">
                    <a href="index-2.html">Habana Maracaibo</a>
                </li>-->
                <li class="logo hidden-xs" popover-placement="bottom" popover-trigger="mouseenter" popover="Inicio">
                    <a data-ui-sref="home" href="{{ empty(Auth::check()) ? 'http://easydancelatino.com/' : '/inicio'}}"data-ng-click="edctrl.sidebarStat($event)"><!--Easy Dance--> <img src="{{url('/')}}/assets/img/logo.png" class="img-opaco p-b-0 m-b-0 p-r-0 m-r-0" width="90">
                    <sub class="beta text-capitalize f-12 text-right">beta</sub>
                    </a>

                </li>



                <li class="pull-right m-r-5">
                    <ul class="top-menu">

                        @if(Auth::check())

                            @if(Auth::check() && (Auth::user()->usuario_tipo == 1 || Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6))

                                <li class="dropdown" type="button" data-trigger="hover" data-animation="fadeInLeft,fadeOutLeft,600" style="margin-top: 20px; right: 55%">
                                    <a href="{{ empty(Auth::check()) ? 'http://easydancelatino.com/' : '/inicio'}}">
                                       <span class="f-20 text-header f-700">INICIO</span>
                                    </a>
                                </li>

                                <li class="dropdown" type="button" data-trigger="hover" data-animation="fadeInLeft,fadeOutLeft,600" style="margin-top: 20px; right: 50%">
                                    <a href="#" id="menuTopConfig">
                                       <span class="f-20 f-700 text-header">HERRAMIENTAS</span>
                                    </a>
                                    <ul class="dropdown-menu dm-icon pull-right">
                                        <li class="hidden-xs">
                                            <a href="{{url('participante/proveedor')}}"><i class="zmdi zmdi-truck"></i> Proveedores</a>
                                        </li>

                                        <li class="hidden-xs">
                                            <a href="{{url('configuracion/productos')}}"><i class="zmdi zmdi-file-text f-16"></i> Productos</a>
                                        </li>

                                        <li class="hidden-xs">
                                            <a href="{{url('staff')}}"><i class="zmdi zmdi-city f-16"></i> Staff</a>
                                        </li>

                                        <li class="hidden-xs">
                                            <a href="{{url('configuracion/administradores')}}"><i class="zmdi zmdi-city f-16"></i> Administradores</a>
                                        </li>
                                    </ul>
                                </li>

                                 <li class="dropdown" type="button" data-trigger="hover" data-animation="fadeInLeft,fadeOutLeft,600" style="margin-top: 20px; right: 45%">
                                    <a href="#" id="menuTopConfig">
                                       <span class="f-20 f-700 text-header">ACCIONES</span>
                                    </a>
                                    <ul class="dropdown-menu dm-icon pull-right">
                                        <li class="hidden-xs">
                                            <a href="{{url('/')}}/invitar"><i class="zmdi icon_d-invitar"></i> Invitar</a>
                                        </li>
                                        <li class="hidden-xs">
                                            <a href="{{url('validar')}}"><i class="zmdi zmdi-check f-16"></i> Validar</a>
                                        </li>
                                        <li class="hidden-xs">
                                            <a href="{{url('validar')}}"><i class="zmdi zmdi-check f-16"></i> Generar Incidencias</a>
                                        </li>
                                    </ul>
                                </li>
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
                                                    @else

                                                        <a class="lv-item {{ empty($notificacion['visto']) ? 'bgm_notificacion_sin_ver' : '' }}" href="{{url('/')}}/sugerencias/detalle/{{$notificacion['evento_id']}}">
            
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
                                                                @if ($notificacion['tipo_evento'] == 1)
                                                                    <div class="lv-title">Nueva Clase Grupal</div>
                                                                @else
                                                                    <div class="lv-title">Nueva Sugerencia</div>
                                                                @endif
                                                                <small class="lv-small">{{$notificacion['mensaje']}}</small>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                            <!-- <a class="lv-footer" href="#">View Previous</a> -->
                                        </div>
                                    @else
                                        <div class="listview empty" id="notifications">
                                            <div class="lv-header">Notificaciones
                                                <ul class="actions">
                                                    <li class="dropdown"></li>
                                                </ul>
                                            </div>
                                            <div class="lv-body"></div>
                                            <!-- <a class="lv-footer" href="#">View Previous</a> -->
                                        </div>
                                    @endif
                                </div>
                            </li>
              
                            <li class="dropdown" data-original-title="" data-toggle="popover" data-placement="bottom" title="" type="button" data-animation="fadeInLeft,fadeOutLeft,600">
                            <a href="#" style="color:white">

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

                                @if(Auth::check() && (Auth::user()->usuario_tipo == 1 || Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6))

                                    <!-- <li class="hidden-xs">
                                        <a href="{{url('/')}}/invitar"><i class="zmdi icon_d-invitar"></i> Invitar</a>
                                    </li>

                                     <li class="hidden-xs">
                                        <a href=""><i class="zmdi zmdi-help"></i> Ayuda</a>
                                    </li> -->
                                    <li class="hidden-xs">
                                        <a href="{{url('configuracion')}}"><i class="zmdi zmdi-settings"></i> Configuración General</a>
                                    </li>
                                    <!-- <li class="hidden-xs">
                                        <a href="{{url('participante/proveedor')}}"><i class="zmdi zmdi-truck"></i> Proveedores</a>
                                    </li> -->
                                   <!--  <li class="hidden-xs">
                                        <a href="{{url('configuracion/coreografias')}}"><i class="icon_d-coreografia f-16"></i>&nbsp;&nbsp;&nbsp;&nbsp; Coreografías</a>
                                    </li> -->
<!-- 
                                    <li class="hidden-xs">
                                        <a href="{{url('configuracion/productos')}}"><i class="zmdi zmdi-file-text f-16"></i> Productos</a>
                                    </li>

                                    <li class="hidden-xs">
                                        <a href="{{url('validar')}}"><i class="zmdi zmdi-check f-16"></i> Validar</a>
                                    </li> -->
                                @endif 

                                <!-- if(Auth::user()->usuario_tipo == 1)
        
                                    <li class="hidden-xs">
                                        <a href="{{url('configuracion/administradores')}}"><i class="zmdi zmdi-city f-16"></i> Administradores</a>
                                    </li>

                                endif -->

                                @if(Auth::user()->usuario_tipo == 2 || Auth::user()->usuario_tipo == 4)
        
                                    <li class="hidden-xs">
                                        <a href="{{url('sugerencias/generar')}}"><i class="zmdi zmdi-email f-16"></i> Buzón de Sugerencia</a>
                                    </li>
                                @endif

                                <li>
                                    <a href="{{url('/')}}/logout"><i class="zmdi zmdi-time-restore"></i> Cerrar Sesión</a>
                                </li>
                            </ul>

                        </li> 

                        @endif

                        @if(Auth::check() && (Auth::user()->usuario_tipo == 1 || Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6))

                            <li data-content="Asistencia" data-toggle="popover" data-trigger="hover" type="button" data-toggle="tooltip" data-placement="bottom" title="" class="pointer" >
                                    <a class="tm-config" href="{{url('/')}}/asistencia/generar" target="_blank"><i class="tm-icon zmdi zmdi-shield-check f-18 f-18"></i></a>
                            </li>  

                        @endif

                        <!-- @if(Auth::check() && Auth::user()->usuario_tipo == 2)


                            <li class="dropdown" data-original-title="" data-content="Administrativo" data-toggle="popover" data-placement="bottom" title="" type="button" data-trigger="hover" style="height:36px">
                                <a href="{{url('/')}}/administrativo" style="height:36px">
                                    <i class="tm-icon icon_a icon_a-punto-de-venta f-18"></i>
                                </a>
                            </li>

                            <li class="dropdown" data-original-title="" data-content="Asistencia" data-toggle="popover" data-placement="bottom" title="" type="button" data-trigger="hover">
                                <a href="{{url('/')}}/asistencia">
                                    <i class="tm-icon zmdi zmdi-shield-check f-18 f-18"></i>
                                </a>
                            </li>

                            <li class="dropdown" data-original-title="" data-content="Documentos y normativas" data-toggle="popover" data-placement="bottom" title="" type="button" data-trigger="hover">
                                <a href="{{url('/')}}/documentos">
                                    <i class="tm-icon zmdi zmdi-file-text f-18 f-18"></i>
                                </a>
                            </li>

                            <li class="dropdown" data-original-title="" data-content="Cerrar sesion" data-toggle="popover" data-placement="bottom" title="" type="button" data-trigger="hover">
                                    <a href="{{url('/')}}/logout"><i class="tm-icon zmdi zmdi-time-restore f-18 f-18"></i></a>
                                </li>

                        @endif -->
<!-- 
                        @if(Auth::check() && (Auth::user()->usuario_tipo == 1 || Auth::user()->usuario_tipo == 5)) -->

                        <!-- <li class="dropdown" data-original-title="" data-content="Calendario" data-toggle="popover" data-placement="bottom" title="" type="button" data-trigger="hover">
                            <a href="{{url('/')}}/agendar">
                                <i class="tm-icon zmdi zmdi-calendar-check f-18 f-18"></i>
                            </a>
                        </li> -->
<!-- 
                        <li class="dropdown" data-original-title="" data-content="Configuración" data-toggle="popover" data-placement="bottom" title="" type="button" data-trigger="hover" data-animation="fadeInLeft,fadeOutLeft,600">
                            <a data-toggle="dropdown" href="#" id="menuTopConfig">
                                <i class="tm-icon zmdi zmdi-settings f-18"></i>
                            </a>
                            <ul class="dropdown-menu dm-icon pull-right">
                                {{-- <li class="hidden-xs">
                                    <a href=""><i class="zmdi zmdi-help"></i> Ayuda</a>
                                </li> --}}
                                <li class="hidden-xs">
                                    <a href="{{url('configuracion')}}"><i class="zmdi zmdi-settings"></i> Configuración General</a>
                                </li>
                                <li class="hidden-xs">
                                    <a href="{{url('participante/proveedor')}}"><i class="zmdi zmdi-truck"></i> Proveedores</a>
                                </li>
                                {{-- <li class="hidden-xs">
                                    <a href="{{url('configuracion/coreografias')}}"><i class="icon_d-coreografia f-16"></i>&nbsp;&nbsp;&nbsp;&nbsp; Coreografías</a>
                                </li> --}}

                                <li class="hidden-xs">
                                    <a href="{{url('configuracion/productos')}}"><i class="zmdi zmdi-file-text zmdi-hc-fw p-r-5 f-16"></i> Productos</a>
                                </li>

                                @if(Auth::user()->usuario_tipo == 1)
        
                                    <li class="hidden-xs">
                                        <a href="{{url('configuracion/sucursales')}}"><i class="zmdi zmdi-city zmdi-hc-fw p-r-5 f-16"></i> Sucursales</a>
                                    </li>
                                @endif
                                
                            </ul>

                        </li>  -->


                        @endif

                           
                        <!-- <li class="dropdown" data-original-title="" data-content="Asistencia" data-toggle="popover" data-placement="bottom" title="" type="button" data-trigger="hover" data-animation="fadeInLeft,fadeOutLeft,600">
                            <a data-toggle="dropdown" href="#">
                                <i class="tm-icon icon_a icon_a-checador f-18"></i>
                            </a>
                            <ul class="dropdown-menu dm-icon pull-right">
                                <li class="hidden-xs">
                                    <a href=""><i class="zmdi zmdi-account"></i> Mi Perfil</a>
                                </li>
                                <li class="hidden-xs">
                                    <a href=""><i class="zmdi zmdi-help"></i> Ayuda</a>
                                </li>
                                <li class="hidden-xs">
                                    <a href=""><i class="zmdi zmdi-settings"></i> Configuracin General</a>
                                </li>
                                <li class="hidden-xs">
                                    <a href=""><i class="zmdi zmdi-truck"></i> Proveedores</a>
                                </li>
                            </ul>

                        </li>      -->   


                        <!-- <li data-toggle="modal" href="#modalPrueba" data-content="Asistencia" data-toggle="popover" data-original-title="Asistencia" type="button" data-toggle="tooltip" data-placement="bottom" title="" >
                            <a  class="tm-config"  ><i class="tm-icon icon_a icon_a-checador f-18"></i></a>
                        </li> 

                        <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                        <h4 class="modal-title c-negro"> Registrar asistencia - Alumno (a) <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="agregar_asistencia" id="agregar_asistencia" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="modal-body">
                        <div class="row p-t-20 p-b-0">

                                       <div class="col-sm-3">

                                            <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                            <div class="clearfix p-b-15"></div>

                                            <span class="text-center" id="nombre-alumno"> Oswaldo Rodriguez</span>

                                       </div>

                                       <div class="col-sm-5">
                                         <div class="form-group fg-line">
                                            <label for="">Estado económico</label>
                                            <div class="clearfix p-b-15"></div>
                                            <span class="text-center" id="estado_economico"> </span>
                                          </div>

                                           <div class="clearfix"></div> 

                                           <label for="nombre-clase">Nombre de la clase</label>
                                           <div class="fg-line">
                                              <div class="select">
                                                <select class="selectpicker" name="id_clase_grupal" id="id_clase_grupal" data-live-search="true">

                                                  <option value="">Selecciona</option>


                                                </select>
                                              </div>
                                            </div>


                                       </div>

                                       <div class="col-sm-4">

                                         <div class="form-group fg-line">
                                            <label for="apellido">Estado de ausencia</label>
                                            <div class="clearfix p-b-15"></div>
                                            <span class="text-center" id="estado_ausencia"> --</span>
                                         </div>

                                           <div class="clearfix"></div> 

                                          <div class="form-group fg-line">
                                            <label for="apellido">Horario</label>
                                            <div class="clearfix p-b-15"></div>
                                            <span class="text-center" id="estado_ausencia"> --</span>
                                         </div>

                                       </div>


                                       <div class="clearfix"></div> 



                                   </div>

                                </div>
                                <div class="modal-footer p-b-20 m-b-20">
                                    <div class="col-sm-7 text-left">
                                      <div class="procesando hidden">
                                      <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                                      <div class="preloader pls-purple">
                                          <svg class="pl-circular" viewBox="25 25 50 50">
                                              <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                          </svg>
                                      </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-5">                            
                                      <a class="btn-blanco m-r-10 f-16" id="enviar" name="enviar" href="#" > Permitir <i class="zmdi zmdi-check"></i></a>
                                      <button type="button" class="cancelar btn btn-default" data-dismiss="modal">Cancelar</button>
                                    </div>
                                </div></form>
                            </div>
                        </div>
                    </div> -->
                            
                         

                        <!--<li id="top-search">
                            <a href="#"><i class="tm-icon zmdi zmdi-search"></i></a>
                        </li>

                        <li class="dropdown">
                            <a data-toggle="dropdown" href="#">
                                <i class="tm-icon zmdi zmdi-email"></i>
                                <i class="tmn-counts">6</i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg pull-right">
                                <div class="listview">
                                    <div class="lv-header">
                                        Messages
                                    </div>
                                    <div class="lv-body">
                                        <a class="lv-item" href="#">
                                            <div class="media">
                                                <div class="pull-left">
                                                    <img class="lv-img-sm" src="img/profile-pics/1.jpg" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="lv-title">David Belle</div>
                                                    <small class="lv-small">Cum sociis natoque penatibus et magnis dis parturient montes</small>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="lv-item" href="#">
                                            <div class="media">
                                                <div class="pull-left">
                                                    <img class="lv-img-sm" src="img/profile-pics/2.jpg" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="lv-title">Jonathan Morris</div>
                                                    <small class="lv-small">Nunc quis diam diamurabitur at dolor elementum, dictum turpis vel</small>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="lv-item" href="#">
                                            <div class="media">
                                                <div class="pull-left">
                                                    <img class="lv-img-sm" src="img/profile-pics/3.jpg" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="lv-title">Fredric Mitchell Jr.</div>
                                                    <small class="lv-small">Phasellus a ante et est ornare accumsan at vel magnauis blandit turpis at augue ultricies</small>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="lv-item" href="#">
                                            <div class="media">
                                                <div class="pull-left">
                                                    <img class="lv-img-sm" src="img/profile-pics/4.jpg" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="lv-title">Glenn Jecobs</div>
                                                    <small class="lv-small">Ut vitae lacus sem ellentesque maximus, nunc sit amet varius dignissim, dui est consectetur neque</small>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="lv-item" href="#">
                                            <div class="media">
                                                <div class="pull-left">
                                                    <img class="lv-img-sm" src="img/profile-pics/4.jpg" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="lv-title">Bill Phillips</div>
                                                    <small class="lv-small">Proin laoreet commodo eros id faucibus. Donec ligula quam, imperdiet vel ante placerat</small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <a class="lv-footer" href="#">View All</a>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a data-toggle="dropdown" href="#">
                                <i class="tm-icon zmdi zmdi-notifications"></i>
                                <i class="tmn-counts">9</i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg pull-right">
                                <div class="listview" id="notifications">
                                    <div class="lv-header">
                                        Notification

                                        <ul class="actions">
                                            <li class="dropdown">
                                                <a href="#" data-clear="notification">
                                                    <i class="zmdi zmdi-check-all"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="lv-body">
                                        <a class="lv-item" href="#">
                                            <div class="media">
                                                <div class="pull-left">
                                                    <img class="lv-img-sm" src="img/profile-pics/1.jpg" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="lv-title">David Belle</div>
                                                    <small class="lv-small">Cum sociis natoque penatibus et magnis dis parturient montes</small>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="lv-item" href="#">
                                            <div class="media">
                                                <div class="pull-left">
                                                    <img class="lv-img-sm" src="img/profile-pics/2.jpg" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="lv-title">Jonathan Morris</div>
                                                    <small class="lv-small">Nunc quis diam diamurabitur at dolor elementum, dictum turpis vel</small>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="lv-item" href="#">
                                            <div class="media">
                                                <div class="pull-left">
                                                    <img class="lv-img-sm" src="img/profile-pics/3.jpg" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="lv-title">Fredric Mitchell Jr.</div>
                                                    <small class="lv-small">Phasellus a ante et est ornare accumsan at vel magnauis blandit turpis at augue ultricies</small>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="lv-item" href="#">
                                            <div class="media">
                                                <div class="pull-left">
                                                    <img class="lv-img-sm" src="img/profile-pics/4.jpg" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="lv-title">Glenn Jecobs</div>
                                                    <small class="lv-small">Ut vitae lacus sem ellentesque maximus, nunc sit amet varius dignissim, dui est consectetur neque</small>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="lv-item" href="#">
                                            <div class="media">
                                                <div class="pull-left">
                                                    <img class="lv-img-sm" src="img/profile-pics/4.jpg" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="lv-title">Bill Phillips</div>
                                                    <small class="lv-small">Proin laoreet commodo eros id faucibus. Donec ligula quam, imperdiet vel ante placerat</small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <a class="lv-footer" href="#">View Previous</a>
                                </div>

                            </div>
                        </li>
                        <li class="dropdown hidden-xs">
                            <a data-toggle="dropdown" href="#">
                                <i class="tm-icon zmdi zmdi-view-list-alt"></i>
                                <i class="tmn-counts">2</i>
                            </a>
                            <div class="dropdown-menu pull-right dropdown-menu-lg">
                                <div class="listview">
                                    <div class="lv-header">
                                        Tasks
                                    </div>
                                    <div class="lv-body">
                                        <div class="lv-item">
                                            <div class="lv-title m-b-5">HTML5 Validation Report</div>

                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="width: 95%">
                                                    <span class="sr-only">95% Complete (success)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lv-item">
                                            <div class="lv-title m-b-5">Google Chrome Extension</div>

                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                                    <span class="sr-only">80% Complete (success)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lv-item">
                                            <div class="lv-title m-b-5">Social Intranet Projects</div>

                                            <div class="progress">
                                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lv-item">
                                            <div class="lv-title m-b-5">Bootstrap Admin Template</div>

                                            <div class="progress">
                                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                                    <span class="sr-only">60% Complete (warning)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lv-item">
                                            <div class="lv-title m-b-5">Youtube Client App</div>

                                            <div class="progress">
                                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                                    <span class="sr-only">80% Complete (danger)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <a class="lv-footer" href="#">View All</a>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a data-toggle="dropdown" href="#"><i class="tm-icon zmdi zmdi-more-vert"></i></a>
                            <ul class="dropdown-menu dm-icon pull-right">
                                <li class="skin-switch hidden-xs">
                                    <span class="ss-skin bgm-lightblue" data-skin="lightblue"></span>
                                    <span class="ss-skin bgm-bluegray" data-skin="bluegray"></span>
                                    <span class="ss-skin bgm-cyan" data-skin="cyan"></span>
                                    <span class="ss-skin bgm-teal" data-skin="teal"></span>
                                    <span class="ss-skin bgm-orange" data-skin="orange"></span>
                                    <span class="ss-skin bgm-blue" data-skin="blue"></span>
                                </li>
                                <li class="divider hidden-xs"></li>
                                <li class="hidden-xs">
                                    <a data-action="fullscreen" href="#"><i class="zmdi zmdi-fullscreen"></i> Toggle Fullscreen</a>
                                </li>
                                <li>
                                    <a data-action="clear-localstorage" href="#"><i class="zmdi zmdi-delete"></i> Clear Local Storage</a>
                                </li>
                                <li>
                                    <a href="#"><i class="zmdi zmdi-face"></i> Privacy Settings</a>
                                </li>
                                <li>
                                    <a href="#"><i class="zmdi zmdi-settings"></i> Other Settings</a>
                                </li>
                            </ul>
                        </li>
                        <li class="hidden-xs" id="chat-trigger" data-trigger="#chat">
                            <a href="#"><i class="tm-icon zmdi zmdi-comment-alt-text"></i></a>
                        </li>
                    </ul>
                </li>
            </ul>-->

            </ul>

            <!-- Top Search Content -->
            <div id="top-search-wrap">
                <div class="tsw-inner">
                    <i id="top-search-close" class="zmdi zmdi-arrow-left"></i>
                    <input type="text">
                </div>
            </div>
        </header>