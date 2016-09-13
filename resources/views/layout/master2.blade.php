<!DOCTYPE html>
<html>
    <head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>Easy Dance</title>
			
			<!-- Vendor CSS -->
			<link href="{{url('/')}}/assets/vendors/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">	
			
			@yield('css_vendor')
				
			<!-- CSS -->
			<link href="{{url('/')}}/assets/css/app.min.1.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/css/app.min.2.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/css/easy_dance_ico_0.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/css/easy_dance_ico_1.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/css/easy_dance_ico_2.css" rel="stylesheet">
      <link href="{{url('/')}}/assets/css/easy_dance_ico_4.css" rel="stylesheet">
			<!-- <link href="{{url('/')}}/assets/css/css_jn.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/css/css_jn_02.css" rel="stylesheet" type="text/css">	 -->
      <link href="{{url('/')}}/assets/css/habana.css" rel="stylesheet">
      <link href="{{url('/')}}/assets/css/ripple.css" rel="stylesheet">
      <link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
      <link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">

      <link rel='shortcut icon' type='image/x-icon' href='http://easydancelatino.com/img/easy-dance.ico' />

			@yield('css')
		
	</head>
    <body>
	   

<header id="header" class="clearfix" data-current-skin="orange">
		<nav class="navbar navbar-inverse navbar-blanco navbar-fixed-top" style="background-color: #FFF; border-color: none; min-height: 69px">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Menú</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <li style="list-style: none" class="logo hidden-xs" popover-placement="bottom" popover-trigger="mouseenter" popover="Inicio">
                    <a data-ui-sref="home" href="{{url('/')}}/empresa/sobre-la-empresa" data-ng-click="edctrl.sidebarStat($event)"><!--Easy Dance--> <img src="http://easydancelatino.com/img/correos/logo.png" class="img-opaco p-b-0 m-b-0 p-r-0 m-r-0" width="90">
                    </a>

            </li>
        </div>
        <div id="navbar" class="navbar-collapse collapse" style="border-color: none">
          <ul class="nav navbar-nav" style="margin-top: 5px">
            <li style="padding-left: 50px; margin-top:5px"><a id = "tab_campana" href="#empresa" aria-controls="empresa" role="tab" data-toggle="tab"> <span style="color:#4E1E43; font-size:20px"> Campaña</span></a></li>
            <li style="margin-top:5px"><a id = "tab_patrocinador" href="#nuestro-equipo" aria-controls="nuestro-equipo" role="tab" data-toggle="tab"> <span style="color:#4E1E43; font-size:20px"> Patrocinadores</span></a></li>
            <li style="margin-top:5px"><a id = "tab_datos" href="#datos" aria-controls="datos" role="tab" data-toggle="tab"> <span style="color:#4E1E43; font-size:20px">Datos Bancarios</span></a></li>
            <li style="margin-top:5px"><a id = "tab_invitar" href="#invitar" aria-controls="invitar" role="tab" data-toggle="tab"> <span style="color:#4E1E43; font-size:20px">Invitar</span></a></li>

          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    </header>


		

		<section id="main" data-layout="layout-1" style="padding-bottom: 0px; padding-top:50px">
	

			
			@yield('content')
		 
		</section>

     <div class="modal fade" id="modalAsistencia" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                                        <h4 class="modal-title c-negro"> Registrar asistencia - Alumno (a) <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                                    </div>
                                    <form name="agregar_asistencia" id="agregar_asistencia"  >
                                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                       <div class="modal-body">                           
                                       <div class="row p-t-20 p-b-0">

                                           <div class="col-sm-3">
  
                                                <img name = "alumno_imagen" id ="alumno_imagen" src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                                <div class="clearfix p-b-15"></div>
    
                                                <p class="p-l-10" id="asistencia-nombre-alumno"> </p>

                                                <p class="p-l-10">Participa en :  </p>

                                                <p class="p-l-10" id = "clases_grupales_alumno"></p>

                                                <span class="f-16 f-700" id="acciones" name="acciones">Acciones</span>

                                                <hr id="acciones_linea" name ="acciones_linea"></hr>
                                                
                                                <a id="url_pagar" name="url_pagar"><i class="icon_a-pagar f-25 m-r-5 boton blue sa-warning" data-original-title="Pagar" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                                  
                                           </div>

                                           <div class="col-sm-5">
                                             <div class="form-group fg-line">
                                                <!-- <label for="asistencia-estado_economico">Estado económico</label>
                                                <div class="clearfix p-b-15"></div>
                                                <span class="text-center" id="asistencia-estado_economico"> --</span> -->

                                                <table class="table table-striped table-bordered historial">
                                                 <tr class="detalle historial">
                                                 <td class = "historial"></td>
                                                 <td class="f-14 m-l-15 historial" data-original-title="" data-content="Ver historial" data-toggle="popover" data-placement="bottom" title="" type="button" data-trigger="hover"><span class="f-16 f-700 historial">Balance Económico: </span><span class = "f-16 f-700 historial" id="asistencia-estado_economico" name="asistencia-estado_economico"></span> <i class="zmdi zmdi-money f-20 m-r-5 historial" name="status_economico" id="status_economico"></i></td>
                                                </tr>
                                                </table>
                                              </div>

                                               <!-- <div class="clearfix"></div> 
                                               <div class="clearfix p-b-15"></div>


                                               <label for="asistencia-clase_grupal_id" class="f-16">Nombre de la clase</label>
                                               <div class="fg-line">
                                                  <div class="select">
                                                    <select class="selectpickeraaa form-control" name="asistencia_clase_grupal_id" id="asistencia-clase_grupal_id" data-live-search="true">

                                                      <option value="">Selecciona</option>
                                                      
                                                    
                                                    </select>
                                                  </div>
                                                </div>
 -->

                                           </div>

                                           <div class="col-sm-4">

                                             <div class="form-group fg-line">
                                                <label for="asistencia-estado_ausencia" class="f-16">Estado de ausencia</label>
                                                <div class="clearfix p-b-15"></div>
                                                <span class="text-center" id="asistencia-estado_ausencia"> --</span>
                                             </div>

                                              <!--  <div class="clearfix"></div> 

                                              <div class="form-group fg-line">
                                                <label for="asistencia-horario" class="f-16">Horario</label>
                                                <div class="clearfix p-b-15"></div>
                                                <span class="text-center" id="asistencia-horario"> --</span>
                                             </div> -->
                                             
                                           </div>
                                           

                                           <div class="col-sm-9">


                                               <label for="asistencia-clase_grupal_id" class="f-16">Nombre de la clase</label>
                                               <div class="fg-line">
                                                  <div class="select">
                                                    <select class="selectpickeraaa form-control" name="asistencia_clase_grupal_id" id="asistencia-clase_grupal_id" data-live-search="true">

                                                      <option value="">Selecciona</option>
                                                      
                                                    
                                                    </select>
                                                  </div>
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
                                          <input type="hidden" id="asistencia_id_alumno" name="asistencia_id_alumno" ></input>                          
                                          <button type="button" class="btn-blanco btn m-r-10 f-16" id="permitir" name="permitir" > Permitir <i class="zmdi zmdi-check"></i></button>
                                          <button type="button" class="cancelar btn btn-default" data-dismiss="modal">Cancelar</button>
                                        </div>
                                    </div></form>
                                </div>
                            </div>
                        </div>


    <div class="modal fade" id="modalAsistenciaInstructor" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                                        <h4 class="modal-title c-negro"> Registrar asistencia - Instructor (a) <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                                    </div>
                                    <form name="agregar_asistencia_instructor" id="agregar_asistencia_instructor"  >
                                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                       <div class="modal-body">                           
                                       <div class="row p-t-20 p-b-0">

                                           <div class="col-sm-3">
  
                                                <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                                <div class="clearfix p-b-15"></div>
    
                                                <p class="p-l-10" id="asistencia-nombre-instructor"> </p>
                                                  
                                           </div>

                                           <div class="col-sm-9">
                                               <label for="asistencia-clase_grupal_id" class="f-16">Nombre de la clase</label>
                                               <div class="fg-line">
                                                  <div class="select">
                                                    <select class="selectpickeraaa form-control" name="asistencia_clase_grupal_id_instructor" id="asistencia-clase_grupal_id_instructor" data-live-search="true">

                                                      <option value="">Selecciona</option>
                                                      
                                                    
                                                    </select>
                                                  </div>
                                                </div>


                                           </div>

                                           <!-- <div class="col-sm-4">

                                            <div class="form-group fg-line">
                                                <label for="asistencia-horario" class="f-16">Horario</label>
                                                <div class="clearfix p-b-15"></div>
                                                <span class="text-center" id="asistencia-horario-instructor"> --</span>
                                             </div>
                                             
                                           </div> -->
                                           

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
                                          <input type="hidden" id="asistencia_id_instructor" name="asistencia_id_instructor" ></input>                          
                                          <button type="button" class="btn-blanco btn m-r-10 f-16" id="permitir_instructor" name="permitir_instructor" > Permitir <i class="zmdi zmdi-check"></i></button>
                                          <button type="button" class="cancelar btn btn-default" data-dismiss="modal">Cancelar</button>
                                        </div>
                                    </div></form>
                                </div>
                            </div>
                        </div>

    
    <aside id="chat" class="sidebar c-overflow">

                <div class="col-md-12">
                <br>
                <div class="row">
                <div class="chat-search">
                    <div class="fg-line">
                        <input type="text" id="buscar" class="form-control" placeholder="Buscar Alumno e Instructor">
                    </div>
                </div>
                <div class="well p-b-35">
                  <!--Ver listado-->     

                  <span class="f-14 p-t-20 text-success">Ver listado <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-16 "></i></span> <button class="btn btn-default btn-icon waves-effect waves-circle waves-float" style="margin-left:30%" name="listado" id="listado"><i class="zmdi zmdi-eye zmdi-hc-fw"></i></button>             
                </div>
                </div>
                

                            <table class="table" id="tablelistar_asistencia" >

                            <thead>
                                <tr class="hidden">    
                                    <th class="text-center" >Nombres</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                            
                            @if(isset($alumnosacademia))      
                                                 
                            @foreach ($alumnosacademia as $alumno)
                                
                                <?php $id = $alumno->id ?>
                                <tr id="asistencia_alumno_row_{{$id}}" class="" data-imagen ="{{$alumno->imagen}}" data-id-participante="{{$id}}" data-nombre-participante="{{$alumno->nombre}} {{$alumno->apellido}}" data-identificacion-participante="{{$alumno->identificacion}}" data-tipo-participante="alumno" data-sexo="{{$alumno->sexo}}">
                                    <td class="p-10" >
                                      <div class="listview">
                                      <a class="lv-item" href="javascript:void(0)"  >
                                              <div class="media">
                                                  <div class="pull-left p-relative">

                                                  @if($alumno->imagen)
                                                  
                                                    <img class="lv-img-sm" src="{{url('/')}}/assets/uploads/usuario/{{$alumno->imagen}}" alt="">
  
                                                  @else

                                                      @if($alumno->sexo == 'M')
                                                        <img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/4.jpg" alt="">
                                                      @else
                                                        <img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/5.jpg" alt="">
                                                      @endif
                                                  @endif
                                                      <i class="chat-status-busy"></i>
                                                  </div>
                                                  <div class="media-body">
                                                      <div class="lv-title">{{$alumno->nombre}} {{$alumno->apellido}}</div>
                                                      <small class="lv-small">{{$alumno->identificacion}}</small>
                                                  </div>
                                              </div>
                                      </a>
                                      </div>
                                   </td>
                                </tr>
                            @endforeach 
                            @endif
                            
                            @if(isset($instructores))                            
                            @foreach ($instructores as $instructor)
                                
                                <?php $id = $instructor['id']; ?>
                                <tr id="asistencia_instructor_row_{{$id}}" class="" data-id-participante="{{$id}}" data-nombre-participante="{{$instructor['nombre']}} {{$instructor['apellido']}}" data-identificacion-participante="{{$instructor['identificacion']}}" data-tipo-participante="insctructor" >
                                    <td class="p-10" >
                                      <div class="listview">
                                      <a class="lv-item" href="javascript:void(0)"  >
                                              <div class="media">
                                                  <div class="pull-left p-relative">
                                                      <img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/2.jpg" alt="">
                                                      <i class="chat-status-busy"></i>
                                                  </div>
                                                  <div class="media-body">
                                                      <div class="lv-title">{{$instructor['nombre']}} {{$instructor['apellido']}}</div>
                                                      <small class="lv-small">{{$instructor['identificacion']}} <i class="icon_a-instructor"></i></small>
                                                  </div>
                                              </div>
                                      </a>
                                      </div>
                                   </td>
                                </tr>
                            @endforeach 
                            @endif
                                                           
                            </tbody>
                        </table>
                         </div>

                
            </aside>
		
		
		
		<!-- Page Loader -->
        <div class="page-loader">
            <div class="preloader pls-blue">
                <svg class="pl-circular" viewBox="25 25 50 50">
                    <circle class="plc-path" cx="50" cy="50" r="20" />
                </svg>

                <p>Cargando...</p>
            </div>
        </div>
		
		<!-- Javascript Libraries -->

    <!-- Procesando -->
    <div id="loader-procesando" tg-loader="" class="loader">
      <div class="progress progress-striped active">
        <div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 8px;">
        <span class="sr-only">45% Complete</span>
        </div>
      </div>

    <div class="container">
      <p class="f-25"><div class="clearfix"></div>
      <div class="preloader pl-xl">
        <span class="f-16">Procesando...</span>
        <svg class="pl-circular" viewBox="25 25 50 50">
        <circle class="plc-path" cx="50" cy="50" r="20"></circle>
        </svg>
      </div></p>
      </div>
    </div>
<!-- Procesando -->
		
        <script src="{{url('/')}}/assets/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        
        <script src="{{url('/')}}/assets/vendors/bower_components/flot/jquery.flot.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/flot/jquery.flot.resize.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/flot.curvedlines/curvedLines.js"></script>
        <script src="{{url('/')}}/assets/vendors/sparklines/jquery.sparkline.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
        
        <script src="{{url('/')}}/assets/vendors/bower_components/moment/min/moment.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/Waves/dist/waves.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bootstrap-growl/bootstrap-growl.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    		<script src="{{url('/')}}/assets/vendors/bootgrid/jquery.bootgrid.min.js"></script>
    		<script src="{{url('/')}}/assets/vendors/fileinput/fileinput.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/input-mask/input-mask.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/languages/es.js"></script>

		
        
        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->

        
        
        <script src="{{url('/')}}/assets/js/flot-charts/curved-line-chart.js"></script>
        <script src="{{url('/')}}/assets/js/flot-charts/line-chart.js"></script>
        <script src="{{url('/')}}/assets/js/charts.js"></script>
        
        <script src="{{url('/')}}/assets/js/charts.js"></script>
        @yield('js_vendor')

        <script type="text/javascript">
        	

        </script>

        <script src="{{url('/')}}/assets/js/functions.js"></script>
        <script src="{{url('/')}}/assets/js/demo.js"></script>
        <script src="{{url('/')}}/assets/js/jquery.floating-social-share.js"></script>
        <script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>

        <!-- <script src="{{url('/')}}/assets/js/loader.js" type="text/javascript"></script>
        <script src="{{url('/')}}/assets/js/loader2.js" type="text/javascript"></script>
        <script type="text/javascript" src="{{url('/')}}/assets/js/materialize.js"></script>
         <script type="text/javascript" src="{{url('/')}}/assets/js/materialize.min.js"></script> -->

		
		<script> 

    route_consultar_cg="{{url('/')}}/asistencia/consulta/clases-grupales";
    route_agregar_asistencia="{{url('/')}}/asistencia/agregar";
    route_agregar_asistencia_permitir="{{url('/')}}/asistencia/agregar/permitir";
    route_agregar_asistencia_instructor="{{url('/')}}/asistencia/agregar/instructor";
    route_agregar_asistencia_instructor_permitir="{{url('/')}}/asistencia/agregar/instructor/permitir";

    function notify(from, align, icon, type, animIn, animOut, mensaje, titulo){
                $.growl({
                    icon: icon,
                    title: titulo,
                    message: mensaje,
                    url: ''
                },{
                        element: 'body',
                        type: type,
                        allow_dismiss: true,
                        placement: {
                                from: from,
                                align: align
                        },
                        offset: {
                            x: 20,
                            y: 85
                        },
                        spacing: 10,
                        z_index: 1070,
                        delay: 2500,
                        timer: 2000,
                        url_target: '_blank',
                        mouse_over: false,
                        animate: {
                                enter: animIn,
                                exit: animOut
                        },
                        icon_type: 'class',
                        template: '<div data-growl="container" class="alert" role="alert">' +
                                        '<button type="button" class="close" data-growl="dismiss">' +
                                            '<span aria-hidden="true">&times;</span>' +
                                            '<span class="sr-only">Close</span>' +
                                        '</button>' +
                                        '<span data-growl="icon"></span>' +
                                        '<span data-growl="title"></span>' +
                                        '<span data-growl="message"></span>' +
                                        '<a href="#" data-growl="url"></a>' +
                                    '</div>'
                });
            };

    function procesando(){
      $("body").addClass('loader-active');
      $("#loader-procesando").addClass('active');
    }

    function finprocesado(){
      $("body").removeClass('loader-active');
      $("#loader-procesando").removeClass('active');
    }

    var asistencia=$('#tablelistar_asistencia').DataTable({
        
        processing: true,
        serverSide: false,    
        order: [[0, 'asc']],
        paging: false,  
        fnDrawCallback: function() {
          //if ($('#tablelistar_asistencia tr').length < 25) {
              $('.dataTables_paginate').hide();
          //}
          $("#tablelistar_asistencia_info").hide();
          $("#tablelistar_asistencia_filter").hide();
        },   
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {          
          $('td:eq(0)', nRow).attr( "onclick","buscar(this)" );
        },  
        language: {
                        processing:     "Procesando ...",
                        search:         "",
                        lengthMenu:     "Mostrar _MENU_ Registros",
                        info:           "Mostrando _START_ a _END_ de _TOTAL_ Registros",
                        infoEmpty:      "Mostrando 0 a 0 de 0 Registros",
                        infoFiltered:   "(filtrada de _MAX_ registros en total)",
                        infoPostFix:    "",
                        loadingRecords: "...",
                        zeroRecords:    "No se encontraron registros coincidentes",
                        emptyTable:     "No hay datos disponibles en la tabla",
                        paginate: {
                            first:      "Primero",
                            previous:   "Anterior",
                            next:       "Siguiente",
                            last:       "Ultimo"
                        },
                        aria: {
                            sortAscending:  ": habilitado para ordenar la columna en orden ascendente",
                            sortDescending: ": habilitado para ordenar la columna en orden descendente"
                        }
                    }
        });

        $('#buscar').on( 'keyup', function () {
          asistencia.search( this.value ).draw();
      } );

    $("#listado").on('click',function(){
      window.location = "{{url('/')}}/asistencia";
    });
    $("#permitir").on('click',function(){
      var route = route_agregar_asistencia;
      var token = $('input:hidden[name=_token]').val();
      var datos = $( "#agregar_asistencia" ).serialize(); 
      //$("#permitir").attr("disabled","disabled");
      /*$("#permitir").css({
        "opacity": ("0.2")
      });*/
      //$(".cancelar").attr("disabled","disabled");
      //$(".procesando").removeClass('hidden');
      //$(".procesando").addClass('show');         
      //limpiarMensaje();
      //procesando();
      $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data:datos,
          success:function(respuesta){            
            if(respuesta.status=="OK"){
              var nType = 'success';
              $("#agregar_asistencia")[0].reset();
              $("#asistencia-horario").text("---");
              var nFrom = $(this).attr('data-from');
              var nAlign = $(this).attr('data-align');
              var nIcons = $(this).attr('data-icon');
              var nAnimIn = "animated flipInY";
              var nAnimOut = "animated flipOutY"; 
              var nTitle="Ups! ";
              var nMensaje=respuesta.mensaje;
              //$('#modalAsistencia').modal('hidden');
              // $('#modalAsistencia').modal('hide');
              // //console.log(repuesta);
              // $("#content").toggleClass("opacity-content");
              // $("header").toggleClass("abierto");
              // $("footer").toggleClass("opacity-content");
              // $("#buscar").val(' ');
              // $("#chat-trigger").click();
              // $("#buscar").focus();

              $('#modalAsistencia').modal('hide');
              swal("Permitido!", respuesta.mensaje, "success");
              $("#content").toggleClass("opacity-content");
              $("header").toggleClass("abierto");
              $("footer").toggleClass("opacity-content");


            }else{
              var nType = 'danger';
              var nTitle="Ups! ";
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              var nType = 'danger';
              //console.log(msj);
              // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
            }
            
          },
          error:function(msj){
            var nType = 'danger';
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nAnimIn = "animated flipInY";
            var nAnimOut = "animated flipOutY"; 
            var nTitle="Ups! ";
            if(msj.responseJSON.status=="ERROR"){
              var nTitle="    Ups! "; 
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
            }else if(msj.responseJSON.status=="ERROR_ASOCIADO"){
              swal({   
                    title: "¿Desea permitir la entrada?",   
                    text: "El alumno no se encuentra asociado a esta clase!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Permitir!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: false 
                }, function(isConfirm){   
                if (isConfirm) {
                    var route = route_agregar_asistencia_permitir;
                    var token = $('input:hidden[name=_token]').val();
                    var datos = $( "#agregar_asistencia" ).serialize(); 
                    $.ajax({
                      url: route,
                      headers: {'X-CSRF-TOKEN': token},
                      type: 'POST',
                      dataType: 'json',
                      data:datos,
                        success:function(respuesta){  
                          console.log(respuesta)          
                          if(respuesta.status=="OK"){
                            $('#modalAsistencia').modal('hide');
                            swal("Permitido!", respuesta.mensaje, "success");
                            $("#content").toggleClass("opacity-content");
                            $("header").toggleClass("abierto");
                            $("footer").toggleClass("opacity-content");                                              
                          }else{
                            var nType = 'danger';
                            var nTitle="Ups! ";
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                            var nType = 'danger';
                            // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                            //console.log(msj);
                          }
                          
                        },
                        error:function(msj){
                          var nType = 'danger';
                          var nFrom = $(this).attr('data-from');
                          var nAlign = $(this).attr('data-align');
                          var nIcons = $(this).attr('data-icon');
                          var nAnimIn = "animated flipInY";
                          var nAnimOut = "animated flipOutY"; 
                          var nTitle="Ups! ";
                          if(msj.responseJSON.status=="ERROR"){
                            var nTitle="    Ups! "; 
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";  
                            // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);          
                          }else{

                           
                          }
                          
                        }
                        
                      });
                  
                  
                }
              });

            }else if(msj.responseJSON.status=="ERROR_REGISTRADO"){
              var nType = 'info';
              var nTitle="    Ups! "; 
              var nMensaje="El alumno no ha formalizado su inscripción"; 
            } 
            // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
          }
          
        });
    });


    $("#permitir_instructor").on('click',function(){
      var route = route_agregar_asistencia_instructor;
      var token = $('input:hidden[name=_token]').val();
      var datos = $( "#agregar_asistencia_instructor" ).serialize(); 
      $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data:datos,
          success:function(respuesta){  
            console.log(respuesta)          
            if(respuesta.status=="OK"){
              var nType = 'success';
              $("#agregar_asistencia_instructor")[0].reset();
              $("#asistencia-horario-instructor").text("---");
              var nFrom = $(this).attr('data-from');
              var nAlign = $(this).attr('data-align');
              var nIcons = $(this).attr('data-icon');
              var nAnimIn = "animated flipInY";
              var nAnimOut = "animated flipOutY"; 
              var nTitle="Ups! ";
              var nMensaje=respuesta.mensaje;
              //$('#modalAsistencia').modal('hidden');
              // $('#modalAsistenciaInstructor').modal('hide');
              //console.log(repuesta);

              $('#modalAsistenciaInstructor').modal('hide');
              swal("Permitido!", respuesta.mensaje, "success");
              $("#content").toggleClass("opacity-content");
              $("header").toggleClass("abierto");
              $("footer").toggleClass("opacity-content"); 
            }else{
              var nType = 'danger';
              var nTitle="Ups! ";
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              var nType = 'danger';
              //console.log(msj);
            }
            // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
          },
          error:function(msj){
            var nType = 'danger';
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nAnimIn = "animated flipInY";
            var nAnimOut = "animated flipOutY"; 
            var nTitle="Ups! ";
            if(msj.responseJSON.status=="ERROR"){
              var nTitle="    Ups! "; 
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";  
              // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);          
            }else if(msj.responseJSON.status=="ERROR_ASOCIADO"){

              swal({   
                    title: "¿Desea permitir la entrada como suplente?",   
                    text: "El instructor no se encuentra asociado a esta clase!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Permitir!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: false 
                }, function(isConfirm){   
                if (isConfirm) {
                    var route = route_agregar_asistencia_instructor_permitir;
                    var token = $('input:hidden[name=_token]').val();
                    var datos = $( "#agregar_asistencia_instructor" ).serialize(); 
                    $.ajax({
                      url: route,
                      headers: {'X-CSRF-TOKEN': token},
                      type: 'POST',
                      dataType: 'json',
                      data:datos,
                        success:function(respuesta){  
                          console.log(respuesta)          
                          if(respuesta.status=="OK"){
                            $('#modalAsistenciaInstructor').modal('hide');
                            swal("Permitido!", respuesta.mensaje, "success");
                            $("#content").toggleClass("opacity-content");
                            $("header").toggleClass("abierto");
                            $("footer").toggleClass("opacity-content");                                              
                          }else{
                            var nType = 'danger';
                            var nTitle="Ups! ";
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                            var nType = 'danger';
                            // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                            //console.log(msj);
                          }
                          
                        },
                        error:function(msj){
                          var nType = 'danger';
                          var nFrom = $(this).attr('data-from');
                          var nAlign = $(this).attr('data-align');
                          var nIcons = $(this).attr('data-icon');
                          var nAnimIn = "animated flipInY";
                          var nAnimOut = "animated flipOutY"; 
                          var nTitle="Ups! ";
                          if(msj.responseJSON.status=="ERROR"){
                            var nTitle="    Ups! "; 
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";  
                            // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);          
                          }else{

                           
                          }
                          
                        }
                        
                      });
                  
                  
                }
              });
              /*
              var nType = 'warning';
              var nTitle="    Ups! "; 
              var nMensaje="El instructor no se encuentra asociado a la clase"; 
              */
            }
            //notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
          }
          
        });
    });
    

    $('#asistencia-clase_grupal_id').on('change', function(){
      if ($(this).val()=='') {
        $("#asistencia-horario").text("---");           
      }else{
        $var = valor=$(this).val().split('-');
        $("#asistencia-horario").text(valor[1]);
      }
    });


     $('#asistencia-clase_grupal_id_instructor').on('change', function(){
      if ($(this).val()=='') {
        $("#asistencia-horario-instructor").text("---");           
      }else{
        $var = valor=$(this).val().split('-');
        $("#asistencia-horario-instructor").text(valor[1]);
      }
    });


      function buscar(t){
        var row = $(t).closest('tr');
        //console.log(row.data());
        var tipo= $(row).data('tipo-participante');
        if(tipo=="alumno"){
          buscarAlumno(t);
        }else if(tipo=="insctructor"){
          buscarInstructor(t);
        }
      }

      function buscarInstructor(t){
        procesando();

        var row = $(t).closest('tr');
        //console.log(row.data());
        console.log(row);

        var id_instructor = $(row).data('id-participante');
        var nombre_instructor = $(row).data('nombre-participante');

        console.log(nombre_instructor);

        $('#asistencia_id_instructor').val(id_instructor);
        $('#asistencia-nombre-instructor').text(nombre_instructor);
        $("#asistencia-horario-instructor").text("---");

        var route = route_consultar_cg;
        var token = $('input:hidden[name=_token]').val();
        $.ajax({
          url: route,
          headers: {'X-CSRF-TOKEN': token},
          type: 'GET',
          dataType: 'json',
          success:function(respuesta){
            
            console.log(respuesta.clases_grupales); 
            //$('#asistencia-clase_grupal_id').selectpicker('refresh');  
            $('#asistencia-clase_grupal_id_instructor').empty();        
            $('#asistencia-clase_grupal_id_instructor').append( new Option("Selecciona",""));
            $.each(respuesta.clases_grupales, function (index, array) { 
              // console.log(array);                      
              $('#asistencia-clase_grupal_id_instructor').append( new Option(array.nombre +'  -   Desde:'+array.hora_inicio+'  /   Hasta:'+array.hora_final + '  -  ' + array.instructor,array.id+'-Desde:'+array.hora_inicio+' Hasta:'+array.hora_final));

            });

            finprocesado();
            $('#modalAsistenciaInstructor').modal('show');
          },
          error:function(msj){
            finprocesado();
            console.log(msj);

          } 
        });
      }


      function buscarAlumno(t){
        procesando();
        $('#clases_grupales_alumno').empty();

        var row = $(t).closest('tr');
        //console.log(row.data());
        console.log(row);

        var id_alumno = $(row).data('id-participante');
        var nombre_alumno = $(row).data('nombre-participante');
        var imagen = $(row).data('imagen');
        var sexo = $(row).data('sexo');

        if(imagen){
          $('#alumno_imagen').attr('src', "{{url('/')}}/assets/uploads/usuario/"+imagen)
        }else{
          if(sexo == 'M'){
            $('#alumno_imagen').attr('src', "{{url('/')}}/assets/img/Hombre.jpg")
          }else{
            console.log(sexo);
            $('#alumno_imagen').attr('src', "{{url('/')}}/assets/img/Mujer.jpg")
          }
        }

        $('#asistencia_id_alumno').val(id_alumno);
        //$("#buscar").val("");
        $('#asistencia-nombre-alumno').text(nombre_alumno);
        $("#url_pagar").attr("href", "{{url('/')}}/participante/alumno/deuda/"+id_alumno);

        $("#asistencia-horario").text("---");
        //var route =route_verificar+"/"+id_alumno[1];
        //window.location=route;
        //alert(id_alumno);
        var route = route_consultar_cg;
        var token = $('input:hidden[name=_token]').val();
        $.ajax({
          url: route+"/"+id_alumno,
          headers: {'X-CSRF-TOKEN': token},
          type: 'GET',
          dataType: 'json',
          success:function(respuesta){
            $.each(respuesta.inscripciones, function (index, array) { 
              $('#clases_grupales_alumno').append('<p>' + array.nombre + ' <br> Desde:' + array.hora_inicio + ' Hasta: ' + array.hora_final + ' <br> ' + array.dia + '</p>')
            });
            
            console.log(respuesta.clases_grupales); 
            //$('#asistencia-clase_grupal_id').selectpicker('refresh');  
            $('#asistencia-clase_grupal_id').empty();        
            $('#asistencia-clase_grupal_id').append( new Option("Selecciona",""));
            $.each(respuesta.clases_grupales, function (index, array) {                   
              $('#asistencia-clase_grupal_id').append( new Option(array.nombre +'  -   Desde:'+array.hora_inicio+'  /   Hasta:'+array.hora_final + '  -  ' + array.instructor,array.id+'-Desde:'+array.hora_inicio+' Hasta:'+array.hora_final));
            });

            $('#asistencia-estado_economico').text(respuesta.deuda);
            if(respuesta.deuda > 0){
              $( "#url_pagar" ).show();
              $( "#acciones" ).show();
              $( "#acciones_linea" ).show();
              $("#status_economico").removeClass("c-verde");
              $("#status_economico").addClass("c-youtube");
            }else{
              $( "#url_pagar" ).hide();
              $( "#acciones" ).hide();
              $( "#acciones_linea" ).hide();
              $("#status_economico").removeClass("c-youtube");
              $("#status_economico").addClass("c-verde");
            }
            finprocesado();
            $('#modalAsistencia').modal('show');
          },
          error:function(msj){
            finprocesado();
            console.log(msj);

          } 
        });

        //$('#modalAsistencia').modal('show');
        //$('#asistencia-estado_economico').text('--');
      }


      function permitir_instructor(){
        var route = route_agregar_asistencia_instructor_permitir;
        var token = $('input:hidden[name=_token]').val();
        var datos = $( "#agregar_asistencia_instructor" ).serialize(); 
        $.ajax({
          url: route,
          headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:datos,
            success:function(respuesta){  
              console.log(respuesta)          
              if(respuesta.status=="OK"){
                /*var nType = 'success';
                $("#agregar_asistencia_instructor")[0].reset();
                $("#asistencia-horario-instructor").text("---");
                var nFrom = $(this).attr('data-from');
                var nAlign = $(this).attr('data-align');
                var nIcons = $(this).attr('data-icon');
                var nAnimIn = "animated flipInY";
                var nAnimOut = "animated flipOutY"; 
                var nTitle="Ups! ";
                var nMensaje=respuesta.mensaje;
                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);*/
                $('#modalAsistencia').modal('hidden');
                
              }else{
                var nType = 'danger';
                var nTitle="Ups! ";
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                var nType = 'danger';
                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                //console.log(msj);
              }
              
            },
            error:function(msj){
              var nType = 'danger';
              var nFrom = $(this).attr('data-from');
              var nAlign = $(this).attr('data-align');
              var nIcons = $(this).attr('data-icon');
              var nAnimIn = "animated flipInY";
              var nAnimOut = "animated flipOutY"; 
              var nTitle="Ups! ";
              if(msj.responseJSON.status=="ERROR"){
                var nTitle="    Ups! "; 
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";  
                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);          
              }else{

               
              }
              
            }
            
          });
      }

      $('#modalAsistencia').on('hidden.bs.modal', function (e) {
        $("#content").removeClass("opacity-content");
        $("header").removeClass("abierto");
        $("footer").removeClass("opacity-content");
        $("#main").removeClass("opacity-content");
        $("#chat").removeClass("toggled");
        $("#what_we_do").removeClass("opacity-content");
      })

      $('#modalAsistenciaInstructor').on('hidden.bs.modal', function (e) {
        $("#content").removeClass("opacity-content");
        $("header").removeClass("abierto");
        $("footer").removeClass("opacity-content");
        $("#main").removeClass("opacity-content");
        $("#chat").removeClass("toggled");
        $("#what_we_do").removeClass("opacity-content");
      })


    $('body').on('click', '#what_we_do, #menuTopConfig, #main,#content, footer, header.abierto', function(e){

            $("#content").removeClass("opacity-content");
            $("footer").removeClass("opacity-content");
            $("header").removeClass("abierto");
            $("#main").removeClass("opacity-content");
            $("#chat").removeClass("toggled");
            $("#what_we_do").removeClass("opacity-content");

            //$("footer").toggleClass("opacity-content");
            //$("header").toggleClass("abierto");


            //$("#content").removeClass("opacity-content");
            //$("footer").removeClass("opacity-content");

        });
        $('body').on('change', '#menu-trigger.open', function(e){

            $("#content").addClass("opacity-content");
            $("footer").addClass("opacity-content");
            $("header").addClass("abierto");

            //$("footer").toggleClass("opacity-content");
            //$("header").toggleClass("abierto");


            //$("#content").removeClass("opacity-content");
            //$("footer").removeClass("opacity-content");

        });

       
    </script>

    <script>

      //setInterval(notificacion, 240000);

      var route_consultar_notificacion="{{url('/')}}/notificacion";

      //setInterval(notificacion,120000);      

      function notificacion (){        
        
        //alert('hola');
        console.log('Hola Mundo');
        var route = route_consultar_notificacion;
        console.log(route_consultar_notificacion);
        var token = $('input:hidden[name=_token]').val();
        console.log(token);
         
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'GET',
            dataType: 'json',
            success:function(respuesta){  
                console.log(respuesta);             
            },
            error:function(msj){
                console.log(msj);              
            }
        });
      }

    </script>		
		
		@yield('js')
		
       
    </body>
</html>