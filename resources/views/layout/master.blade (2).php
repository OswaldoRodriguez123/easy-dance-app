<!DOCTYPE html>
<html>
    <head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>Material Admin</title>
			
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
      <link href="{{url('/')}}/assets/css/easy_dance_ico_3.css" rel="stylesheet">
			<!-- <link href="{{url('/')}}/assets/css/css_jn.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/css/css_jn_02.css" rel="stylesheet" type="text/css">	 -->
      <link href="{{url('/')}}/assets/css/habana.css" rel="stylesheet">

			@yield('css')
		
	</head>
    <body>
	    
		@include('layout.header') 
		

		<!-- <div class="modal fade" id="modalPrueba" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                                        <h4 class="modal-title c-negro"> <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                                    </div>
									<div class="modal-body">                           
                                    <div class="row p-t-20 p-b-0">
                                    <h4>
									<div class="iconox-icon">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
										<title>Confirma tu academia</title>
										<circle fill="#692A5A" cx="16" cy="16" r="16"/>
                                    <img src="{{url('/')}}/assets/img/icono_easydance2.png"  height="26" width="28" style="margin-top: -30px; margin-left: 3px;"/></svg>
                                    </div>Confirma tu academia </h4>
                                    <form  name="agregar" method="POST" action="configuracion/carga-inicial/primer-paso">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="col-sm-11"><br>
                                    <p align="left" style="font-size: 16px;">Saludos, <b>Valeria </b><br>
                                    <text style="font-size: 13px;">Dedica un momento para ayudarnos a configurar la  cuenta de tu academia.</text></p>
                                    </div>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="col-sm-7">
                                            <div class="form-group ">
                                                <div class="form-group fg-line">
                                                    <label for="id" class="labeli">Nombre de la academia </label> 
                                                    <input type="text" class="form-control input-sm" name="nombre" id="nombre" placeholder="Ej. Baila para todos">
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-sm-7">
                                                       <label class="labeli" >Especialidad </label>
                                                      <div class="form-group">
                                                          <div class="fg-line">
                                                              <div class="select">
                                                                  <select class="form-control" id="como_nos_conociste" name="como_nos_conociste" placeholder="seleccione>>">
                                                                  <option value="Baile">Baile</option>
                                                                  <option value="Otros">Otros</option>
                                                                  </select>
                                                              </div> </div></div> </div>
                                                 <div class="col-sm-7">
                                                       <label class="labeli" >País </label>
                                                      <div class="form-group">
                                                          <div class="fg-line">
                                                              <div class="select">
                                                                  <select class="form-control" id="como_nos_conociste" name="como_nos_conociste" placeholder="seleccione">
                                                                  <option value="Venezuela">Venezuela</option>
                                                                  <option value="Colombia">Colombia</option>
                                                                  <option value="Ecuador">Ecuador</option>
                                                                  <option value="Estados Unidos">Estados Unidos</option>
                                                                  </select>
                                                              </div>
                                                    </div>
                                                </div>
                                             </div> 
                                             <div class="col-sm-7">
                                            <div class="form-group ">
                                                <div class="form-group fg-line">
                                                    <label for="id" class="labeli">Estado / Provincia/  Región </label> 
                                                    <input type="text" class="form-control input-sm" name="nombre" id="nombre" placeholder="Ej. Caracas ">
                                                </div>
                                            </div>
                                </div>
                                 <div class="col-sm-12 col-sd-12 text-center"><br><br><br>
                                  <a class="btn-blanco2 btn-blanco1._largesubmit  m-r-5 f-16 " type="submit"   data-formulario="edit_cupo_taller" data-update="cupo" style=" margin-top: 20px; " >Enviar </a>
                                <br><br><br><br>
                                </div>
                                  </div>
                               </div>
                            </form>
                        </div>
                    </div>
                </div> -->

		<section id="main" data-layout="layout-1">
		
			@include('layout.menu')

			
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
  
                                                <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                                <div class="clearfix p-b-15"></div>
    
                                                <p class="p-l-10" id="asistencia-nombre-alumno"> </p>
                                                  
                                           </div>

                                           <div class="col-sm-5">
                                             <div class="form-group fg-line">
                                                <label for="asistencia-estado_economico">Estado económico</label>
                                                <div class="clearfix p-b-15"></div>
                                                <span class="text-center" id="asistencia-estado_economico"> --</span>
                                              </div>

                                               <div class="clearfix"></div> 

                                               <label for="asistencia-clase_grupal_id">Nombre de la clase</label>
                                               <div class="fg-line">
                                                  <div class="select">
                                                    <select class="selectpickeraaa form-control" name="asistencia_clase_grupal_id" id="asistencia-clase_grupal_id" data-live-search="true">

                                                      <option value="">Selecciona</option>
                                                      
                                                    
                                                    </select>
                                                  </div>
                                                </div>


                                           </div>

                                           <div class="col-sm-4">

                                             <div class="form-group fg-line">
                                                <label for="asistencia-estado_ausencia">Estado de ausencia</label>
                                                <div class="clearfix p-b-15"></div>
                                                <span class="text-center" id="asistencia-estado_ausencia"> --</span>
                                             </div>

                                               <div class="clearfix"></div> 

                                              <div class="form-group fg-line">
                                                <label for="asistencia-horario">Horario</label>
                                                <div class="clearfix p-b-15"></div>
                                                <span class="text-center" id="asistencia-horario"> --</span>
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

                                           <div class="col-sm-5">
                                               <label for="asistencia-clase_grupal_id">Nombre de la clase</label>
                                               <div class="fg-line">
                                                  <div class="select">
                                                    <select class="selectpickeraaa form-control" name="asistencia_clase_grupal_id_instructor" id="asistencia-clase_grupal_id_instructor" data-live-search="true">

                                                      <option value="">Selecciona</option>
                                                      
                                                    
                                                    </select>
                                                  </div>
                                                </div>


                                           </div>

                                           <div class="col-sm-4">

                                            <div class="form-group fg-line">
                                                <label for="asistencia-horario">Horario</label>
                                                <div class="clearfix p-b-15"></div>
                                                <span class="text-center" id="asistencia-horario-instructor"> --</span>
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

                  <span class="f-14 p-t-20 text-success">Ver listado <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-16 "></i></span> <button class="btn btn-default btn-icon waves-effect waves-circle waves-float pull-right"><i class="zmdi zmdi-eye zmdi-hc-fw"></i></button>             
                </div>
                </div>
                

                            <table class="table" id="tablelistar_asistencia" >

                            <thead>
                                <tr class="hidden">    
                                    <th class="text-center" >Nombres</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                            
                            @if(isset($alumno))                            
                            @foreach ($alumno as $alumnos)
                                
                                <?php $id = $alumnos['id']; ?>
                                <tr id="asistencia_alumno_row_{{$id}}" class="" data-id-participante="{{$id}}" data-nombre-participante="{{$alumnos['nombre']}} {{$alumnos['apellido']}}" data-identificacion-participante="{{$alumnos['identificacion']}}" data-tipo-participante="alumno" >
                                    <td class="p-10" >
                                      <div class="listview">
                                      <a class="lv-item" href="javascript:void(0)"  >
                                              <div class="media">
                                                  <div class="pull-left p-relative">
                                                      <img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/4.jpg" alt="">
                                                      <i class="chat-status-busy"></i>
                                                  </div>
                                                  <div class="media-body">
                                                      <div class="lv-title">{{$alumnos['nombre']}} {{$alumnos['apellido']}}</div>
                                                      <small class="lv-small">{{$alumnos['identificacion']}}</small>
                                                  </div>
                                              </div>
                                      </a>
                                      </div>
                                   </td>
                                </tr>
                            @endforeach 
                            @endif
                            
                            @if(isset($instructor))                            
                            @foreach ($instructor as $instructores)
                                
                                <?php $id = $instructores['id']; ?>
                                <tr id="asistencia_instructor_row_{{$id}}" class="" data-id-participante="{{$id}}" data-nombre-participante="{{$instructores['nombre']}} {{$instructores['apellido']}}" data-identificacion-participante="{{$instructores['identificacion']}}" data-tipo-participante="insctructor" >
                                    <td class="p-10" >
                                      <div class="listview">
                                      <a class="lv-item" href="javascript:void(0)"  >
                                              <div class="media">
                                                  <div class="pull-left p-relative">
                                                      <img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/2.jpg" alt="">
                                                      <i class="chat-status-busy"></i>
                                                  </div>
                                                  <div class="media-body">
                                                      <div class="lv-title">{{$instructores['nombre']}} {{$instructores['apellido']}}</div>
                                                      <small class="lv-small">{{$instructores['identificacion']}}</small>
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

            <!--  fin de asistencia -->
		
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
		<script src="{{url('/')}}/assets/vendors/bootgrid/jquery.bootgrid.updated.min.js"></script>
		<script src="{{url('/')}}/assets/vendors/fileinput/fileinput.min.js"></script>
    <script src="{{url('/')}}/assets/vendors/input-mask/input-mask.min.js"></script>

		
        
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

        <!-- <script src="{{url('/')}}/assets/js/loader.js" type="text/javascript"></script>
        <script src="{{url('/')}}/assets/js/loader2.js" type="text/javascript"></script>
        <script type="text/javascript" src="{{url('/')}}/assets/js/materialize.js"></script>
         <script type="text/javascript" src="{{url('/')}}/assets/js/materialize.min.js"></script> -->

		
		<script> 

    route_consultar_cg="{{url('/')}}/asistencia/consulta/clases-grupales";
    route_agregar_asistencia="{{url('/')}}/asistencia/agregar";
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
              $('#modalAsistencia').modal('hide');
              //console.log(repuesta);
              $("#content").toggleClass("opacity-content");
              $("header").toggleClass("abierto");
              $("footer").toggleClass("opacity-content");
              $("#buscar").val(' ');
              $("#chat-trigger").click();
              $("#buscar").focus();


            }else{
              var nType = 'danger';
              var nTitle="Ups! ";
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              var nType = 'danger';
              //console.log(msj);
            }
            notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
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
              var nType = 'warning';
              var nTitle="    Ups! "; 
              var nMensaje="El alumno no se encuentra asociado a la clase"; 
            }else if(msj.responseJSON.status=="ERROR_REGISTRADO"){
              var nType = 'info';
              var nTitle="    Ups! "; 
              var nMensaje="El alumno no ha formalizado su inscripción"; 
            } 
            notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
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
              $('#modalAsistenciaInstructor').modal('hide');
              //console.log(repuesta);
            }else{
              var nType = 'danger';
              var nTitle="Ups! ";
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              var nType = 'danger';
              //console.log(msj);
            }
            notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
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
                  
                  
                  /*var nFrom = $(this).attr('data-from');
                  var nAlign = $(this).attr('data-align');
                  var nIcons = $(this).attr('data-icon');
                  var nType = 'success';
                  var nAnimIn = $(this).attr('data-animation-in');
                  var nAnimOut = $(this).attr('data-animation-out');                  
                  var nTitle="   Ups! "; 
                  var nMensaje="¡Excelente! La Asistencia se han guardado satisfactoriamente";
                  notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);*/
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
              console.log(array.nombre);                      
              $('#asistencia-clase_grupal_id_instructor').append( new Option(array.nombre,array.id+'-Desde:'+array.hora_inicio+' Hasta:'+array.hora_final));
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

        var row = $(t).closest('tr');
        //console.log(row.data());
        console.log(row);

        var id_alumno = $(row).data('id-participante');
        var nombre_alumno = $(row).data('nombre-participante');
        $('#asistencia_id_alumno').val(id_alumno);
        //$("#buscar").val("");
        $('#asistencia-nombre-alumno').text(nombre_alumno);
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
            
            console.log(respuesta.clases_grupales); 
            //$('#asistencia-clase_grupal_id').selectpicker('refresh');  
            $('#asistencia-clase_grupal_id').empty();        
            $('#asistencia-clase_grupal_id').append( new Option("Selecciona",""));
            $.each(respuesta.clases_grupales, function (index, array) { 
              console.log(array.nombre);                      
              $('#asistencia-clase_grupal_id').append( new Option(array.nombre,array.id+'-Desde:'+array.hora_inicio+' Hasta:'+array.hora_final));
            });

            $('#asistencia-estado_economico').text(respuesta.deuda);
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
      })


		$('body').on('click', '#content, footer, header.abierto', function(e){

			$("#content").removeClass("opacity-content");
            $("footer").removeClass("opacity-content");
            $("header").removeClass("abierto");

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
		
		
		@yield('js')
		
       
    </body>
</html>