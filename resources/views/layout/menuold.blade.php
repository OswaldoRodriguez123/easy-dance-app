<aside id="sidebar" class="sidebar c-overflow">
                <div class="profile-menu">
                    <a href="#">
                        <div class="profile-pic">
                            <img src="{{url('')}}/assets/img/profile-pics/1.jpg" alt="">
                        </div>

                        <div class="profile-info">
                            Malinda Hollaway

                            <i class="zmdi zmdi-caret-down"></i>
                        </div>
                    </a>

                    <!--<ul class="main-menu">
                        <li>
                            <a href="profile-about.html"><i class="zmdi zmdi-account"></i> View Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="zmdi zmdi-input-antenna"></i> Privacy Settings</a>
                        </li>
                        <li>
                            <a href="#"><i class="zmdi zmdi-settings"></i> Settings</a>
                        </li>
                        <li>
                            <a href="#"><i class="zmdi zmdi-time-restore"></i> Logout</a>
                        </li>
                    </ul>-->
                </div>

                <ul class="main-menu">
                    <!--<li class="active">
                        <a href=""><i class="zmdi zmdi-home"></i> Inicio</a>
                    </li> -->
                    
                    <li class="sub-menu">
                        <a href="#"><i class="zmdi zmdi-accounts-alt"></i> Participantes</a>

                        <ul>
                            <li><a href="{{url('participante/alumno')}}"><i class="zmdi zmdi-caret-right"></i> Alumnos</a></li>
                            <li><a href="{{url('participante/instructor')}}"><i class="zmdi zmdi-caret-right"></i> Instructores</a></li>
                            <li><a href="{{url('participante/visitante')}}"><i class="zmdi zmdi-caret-right"></i> Visitantes</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="#"><i class="icon_a-agendar"></i> Agendar</a>

                        <ul>
                            <li><a href="{{url('agendar/clases-grupales')}}"><i class="zmdi zmdi-caret-right"></i> Clases Grupales</a></li>
                            <li><a href="{{url('agendar/clases-personalizadas')}}"><i class="zmdi zmdi-caret-right"></i> Clases Personalizadas</a></li>
                            <li><a href="{{url('agendar/talleres')}}"><i class="zmdi zmdi-caret-right"></i> Talleres</a></li>
                            <li><a href="{{url('agendar/fiestas')}}"><i class="zmdi zmdi-caret-right"></i> Fiestas o Eventos</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="#"><i class="icon_a-especiales"></i> Especiales</a>

                        <ul>
                            <li><a href="{{url('especiales/promociones')}}"><i class="zmdi zmdi-caret-right"></i> Promociones</a></li>
                            <li><a href="{{url('especiales/examenes')}}"><i class="zmdi zmdi-caret-right"></i> Examenes</a></li>
                            <li><a href="{{url('especiales/campañas')}}"><i class="zmdi zmdi-caret-right"></i> Campañas</a></li>
                            <li><a href="{{url('especiales/regalos/agregar')}}"><i class="zmdi zmdi-caret-right"></i> Tarjeta de Regalo</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{url('guia/validar')}}"><i class="zmdi zmdi-check"></i> Validar</a>
                    </li> 

                    <li>
                        <a href="{{url('administrativo/pagos')}}"><i class="icon_a-punto-de-venta"></i> Punto de Venta</a>
                    </li> 
                    <li>
                        <a href=""><i class="icon_a-consultas-y-reportes"></i> Reporte</a>
                    </li> 

                    <li>
                        <a href="/logout"><i class="zmdi zmdi-time-restore"></i> Cerrar Sesión</a>
                    </li>

                    <!--<li>
                        <a href="#"><i class="zmdi zmdi-time-restore"></i> Cerrar Sesión</a>
                    </li>-->					
                </ul>
            </aside>        
        