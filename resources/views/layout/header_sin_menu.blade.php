<header id="header" class="clearfix" data-current-skin="orange">
    <ul class="header-inner">
        <li class="logo hidden-xs" popover-placement="bottom" popover-trigger="mouseenter" popover="Inicio">
            <a data-ui-sref="home" href="{{ empty(Auth::check()) ? 'http://easydancelatino.com/' : '/inicio'}}"data-ng-click="edctrl.sidebarStat($event)"><!--Easy Dance--> <img src="{{url('/')}}/assets/img/logo.png" class="img-opaco p-b-0 m-b-0 p-r-0 m-r-0" width="90">
            <sub class="beta text-capitalize f-12 text-right">beta</sub>
            </a>
        </li>


        <li class="pull-right m-r-5">
            <ul class="top-menu">
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
                        <li>
                            <a href="{{url('/')}}/logout"><i class="zmdi zmdi-time-restore"></i> Cerrar Sesión</a>
                        </li>
                    </ul>
                </li> 
            </ul>
        </li>
    </ul>

</header>