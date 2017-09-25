<!DOCTYPE html>
<html>
    <head>

			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>Easy Dance</title>
			
			<!-- Vendor CSS -->

			<link href="{{url('/')}}/assets/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
      <link href="{{url('/')}}/assets/css/bootstrap-dropdownhover.min.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">
			
			@yield('css_vendor')
				
			<!-- CSS -->
      
      <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/stylew.css" />
      <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/stimenu.css" />
      <link href="{{url('/')}}/assets/css/css_jn.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/css/app.min.1.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/css/app.min.2.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/css/easy_dance_ico_0.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/css/easy_dance_ico_1.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/css/easy_dance_ico_2.css" rel="stylesheet">
      <link href="{{url('/')}}/assets/css/easy_dance_ico_4.css" rel="stylesheet">
      <link href="{{url('/')}}/assets/css/easy_dance_ico_6.css" rel="stylesheet">
      <link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
      <link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
      <link href="{{url('/')}}/assets/css/easydance.css" rel="stylesheet">
      <link href="{{url('/')}}/assets/css/font-awesome.min.css" rel="stylesheet">

      <link rel='shortcut icon' type='image/x-icon' href='http://easydancelatino.com/img/easy-dance.ico' />

			@yield('css')
		
	</head>
  <body>

		@include('layout.header') 


		<section id="main" data-layout="layout-1">
	
			@yield('content')
		 
		</section>


    
     <!--                    <aside id="chat" class="sidebar c-overflow">
                          
                          <div class="row">
                            <div class="col-md-12">
                              <br>
                                <div class="chat-search">
                                        <input type="text" id="buscar" class="form-control" placeholder="Buscar Alumno e Instructor">
                                </div>
                                <div class="well p-b-35">

                                  <span class="f-14 p-t-20 text-success">Ver listado <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-16 "></i></span> <button class="btn btn-default btn-icon waves-effect waves-circle waves-float" style="margin-left:10%" name="listado" id="listado"><i class="zmdi zmdi-eye zmdi-hc-fw"></i></button>  

                                </div>

                                <table class="table" id="tablelistar_asistencia" >

                                  <thead>
                                    <tr class="hidden">    
                                      <th class="text-center" >Nombres</th>                                    
                                    </tr>
                                  </thead>
                                  <tbody id="aside_body">
                                  

                                                                   
                                  </tbody>
                                </table>
                              </div>
                          </div>
                        </aside> -->
		
		
		
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

  <div class="modal fade" id="modalParticipantes" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title c-negro">Información <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
        </div>
        <div class="modal-body">
          <div class="text-center icon_a icon_a-participantes f-40" style="color:#2196f3;  margin-bottom: -20px;"><p class="f-18">Gestiona el tipo de participante que desees </p></div>
          <ul id="sti-menu"  class="sti-menu">
            <li class="menu_boton">
              <a href="{{url('/')}}/participante/alumno"><h2 data-type="mText" class="sti-item">Alumno </h2><span data-type="icon" class="sti-icon sti-icon-alumno sti-item menu_boton"></span></a>
            </li>
            
            <li class="menu_boton">
              <a href="{{url('/')}}/participante/instructor"><h2 data-type="mText" class="sti-item" align="center">Instructor </h2><span data-type="icon" class="sti-icon sti-icon-instructores sti-item menu_boton"></span></a>
            </li>

            <li class="menu_boton">
              <a href="{{url('/')}}/participante/visitante"><h2 data-type="mText" class="sti-item ">Visitante Presencial </h2><span data-type="icon" class="sti-icon sti-icon-visitantes sti-item menu_boton"></span></a>
            </li>

            <li class="menu_boton">
              <a a href="{{url('/')}}/participante/familia"><h2 data-type="mText" class="sti-item">Familia </h2><span data-type="icon" class="sti-icon sti-icon-family sti-item menu_boton"></span></a>
            </li>
          </ul>
        </div>
        <div class="modal-footer">

          <div class="clearfix p-b-35"></div>
          <div class="clearfix p-b-35"></div>
          <div class="clearfix p-b-35"></div>
          <div class="clearfix p-b-35"></div>
          
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalAgendar" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title c-negro">Información <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
        </div>
        <div class="modal-body">
          <div class="text-center icon_a icon_a-agendar f-40" style="color:#FFD700; margin-bottom: -20px;"><p class="f-18">Agendar</p></div>
          <ul id="sti-menu"  class="sti-menu">
            <li data-hovercolor="#FFEB3B">
              <a href="{{url('/')}}/agendar/clases-grupales"><h2 data-type="mText" class="sti-item">Clases Grupales </h2><span data-type="icon" class="sti-icon sti-icon-clases-grupales sti-item"></span></a>
            </li>
            
            <li data-hovercolor="#FFEB3B">
              <a href="{{url('/')}}/agendar/clases-personalizadas"><h2 data-type="mText" class="sti-item">Clase Personalizada</h2><span data-type="icon" class="sti-icon sti-icon-clase_p sti-item"></span></a>
            </li>

            <li data-hovercolor="#FFEB3B">
              <a href="{{url('/')}}/agendar/fiestas"><h2 data-type="mText" class="sti-item">Fiesta Eventos </h2><span data-type="icon" class="sti-icon sti-icon-fiesta_eventos sti-item"></span></a>
            </li>

            <li data-hovercolor="#FFEB3B">
              <a href="{{url('/')}}/agendar/talleres"><h2 data-type="mText" class="sti-item">Talleres </h2><span data-type="icon" class="sti-icon sti-icon-talleres sti-item"></span></a>
            </li> 
          </ul>
        </div>
        <div class="modal-footer">

          <div class="clearfix p-b-35"></div>
          <div class="clearfix p-b-35"></div>
          <div class="clearfix p-b-35"></div>
          <div class="clearfix p-b-35"></div>
          
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalEspeciales" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title c-negro">Información <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
        </div>
        <div class="modal-body">
          <div class="text-center icon_a icon_a-especiales f-40" style="color:#e91e63;  margin-bottom: -20px;"><p class="f-18">Especiales</p></div>
          <ul id="sti-menu"  class="sti-menu">
            <li data-hovercolor="#e91e63">
              <a href="{{url('/')}}/especiales/regalos"><h2 data-type="mText" class="sti-item">Tarjeta de Regalo </h2><span data-type="icon" class="sti-icon sti-icon-tjregalo sti-item"></span></a>
            </li>
            <li data-hovercolor="#e91e63">
              <a href="{{url('/')}}/especiales/campañas"><h2 data-type="mText" class="sti-item">Campaña</h2><span data-type="icon" class="sti-icon sti-icon-campana sti-item"></span></a>
            </li>    
            <li data-hovercolor="#e91e63">
              <a href="{{url('/')}}/especiales/promociones"><h2 data-type="mText" class="sti-item">Promocion </h2><span data-type="icon" class="sti-icon sti-icon-promocion sti-item"></span></a>
            </li>
            <li data-hovercolor="#e91e63">
              <a data-toggle="modal" href="{{url('/')}}/especiales/examenes""><h2 data-type="mText" class="sti-item">Valoración</h2><span data-type="icon" class="sti-icon sti-icon-cexamen sti-item"></span></a>
            </li> 
          </ul>
        </div>
        <div class="modal-footer">

        <div class="clearfix p-b-35"></div>
        <div class="clearfix p-b-35"></div>
        <div class="clearfix p-b-35"></div>
        <div class="clearfix p-b-35"></div>
          
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalReportes" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title c-negro">Información <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
        </div>
        <div class="modal-body">
          <div class="text-center icon_d icon_d-reporte f-40" style="color:#f44336;  margin-bottom: -20px;"><p class="f-18">Reportes</p></div>
          <ul id="sti-menu"  class="sti-menu">
            <li data-hovercolor="#f44336">
              <a href="{{url('/')}}/reportes/diagnosticos"><h2 data-type="mText" class="sti-item">Diagnosticos</h2><span data-type="icon" class="sti-icon sti-icon-reportes1 sti-item"></span></a>
            </li>
            <li data-hovercolor="#f44336">
              <a href="{{url('/')}}/reportes/presenciales"><h2 data-type="mText" class="sti-item">Presenciales</h2><span data-type="icon" class="sti-icon sti-icon-reportes2 sti-item"></span></a>
            </li>    
            <li data-hovercolor="#f44336">
              <a href="{{url('/')}}/reportes/promotores"><h2 data-type="mText" class="sti-item">Promotores </h2><span data-type="icon" class="sti-icon sti-icon-reportes3 sti-item"></span></a>
            </li>
            <li data-hovercolor="#f44336">
              <a data-toggle="modal" href="{{url('/')}}/reportes/estatus-alumnos"><h2 data-type="mText" class="sti-item">Estatus de alumnos</h2><span data-type="icon" class="sti-icon sti-icon-reportes4 sti-item"></span></a>
            </li> 
          </ul>
        </div>
        <div class="modal-footer">
          
        </div>
      </div>
    </div>
  </div>
<!-- Procesando -->
		
        <script src="{{url('/')}}/assets/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="{{url('/')}}/assets/js/bootstrap-dropdownhover.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/moment/min/moment.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/Waves/dist/waves.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bootstrap-growl/bootstrap-growl.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    		<script src="{{url('/')}}/assets/vendors/fileinput/fileinput.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/input-mask/input-mask.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/languages/es.js"></script>
        <script src="{{url('/')}}/assets/js/functions.js"></script>

        
        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->

        
        @yield('js_vendor')

		<script> 
    
      route_consultar_notificacion="{{url('/')}}/notificacion_nueva";

      var ver = "{{{ $sin_ver or '0' }}}";
      
      function notificacion(){
        
        var route = route_consultar_notificacion;
        var token = "{{ csrf_token() }}"
        $.ajax({
          url: route,
          headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          success: function (respuesta) {
              setTimeout(function() {
                var nFrom = $(this).attr('data-from');
                var nAlign = $(this).attr('data-align');
                var nIcons = $(this).attr('data-icon');
                var nAnimIn = "animated flipInY";
                var nAnimOut = "animated flipOutY";
                if(respuesta.status=='OK'){
                  finprocesado();        
                  var nType = 'success';
                  var nTitle="Ups! ";
                  var notificaciones=respuesta.notificaciones;
                  var nMensaje=respuesta.mensaje;
                  
                  if(respuesta.sin_ver> ver){
                    notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                    ver = respuesta.sin_ver;
                  }
                  nuevas_notificaciones(notificaciones, respuesta.sin_ver);
                }
            }, 1000);
          },
          error:function(msj){
            console.log("algo salio mal");
          }
        });
      }

      function nuevas_notificaciones(notificaciones, sin_ver){
        var img;
        var tipo_de_notificacion;
        var mensaje;
        var link;
        var etiqueta_de_contenido;
        var etiqueta_de_img;
        var etiqueta_de_cuerpo;
        var seccion_notifcacion;
                
        etiqueta_de_contenido = '<div class="media">';
        etiqueta_de_img = '<div class="pull-left">';
        etiqueta_de_cuerpo = '<div class="media-body">';

        if(notificaciones){
          $(".lv-body").empty();
          $("#notifications").removeClass("empty");
          for (var i = 0; i < notificaciones.length; i++) {
            if(notificaciones[i]["imagen"]){
              img = '<img class="img-circle" src="{{url('/')}}/assets/uploads/'+notificaciones[i]["imagen"]+'" alt="" width="45px" height="auto">';
            }else{
              img = '<img class="img-circle" src="{{url('/')}}/assets/img/asd_.jpg" alt="" width="45px" height="auto">';
            }

            if(notificaciones[i]["tipo_evento"] == 1){
              link = '<a class="lv-item notificacion->visto) ? "bgm_notificacion_sin_ver" : "" }}" href="{{url('/')}}/agendar/clases-grupales/progreso/'+notificaciones[i]["evento_id"]+'">';
              tipo_de_notificacion = '<div class="lv-title">Nueva Clase Grupal</div>';
              
            }else{
              link = '<a class="lv-item notificacion->visto) ? "bgm_notificacion_sin_ver" : "" }}" href="{{url('/')}}/sugerencias/detalle/'+notificaciones[i]["evento_id"]+'">';
              tipo_de_notificacion = '<div class="lv-title">Nueva Sugerencia</div>';
            }

            mensaje = '<small class="lv-small">'+notificaciones[i]["mensaje"]+'</small>';
            seccion_notifcacion = link+etiqueta_de_contenido+etiqueta_de_img+img+'</div>'+etiqueta_de_cuerpo+tipo_de_notificacion+mensaje+'</div>'+'</div>'+'</a>';
            $(".lv-body").append(seccion_notifcacion);
          }
        }else{
          seccion_notifcacion = '';
        }
        $("#numero_actual").html(sin_ver);
      }     
      
      var route_edit_notificacion="{{url('/')}}/notificacion_revisado";

      $('#numero_de_notificaciones').on('click', function(e){
          $("#numero_actual").text(0);
          var route = route_edit_notificacion;
          var token = "{{ csrf_token() }}"
          $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            success:function(respuesta){  
                console.log(respuesta);             
            },
            error:function(msj){
                console.log(msj);              
            }
          });
      });

    //eliminar notificaciones
    route_eliminar="{{url('/')}}/notificacion_eliminadas";
    
    $("#limpiar_notificaciones").on('click', function(e){
      var route = route_eliminar;
      var token = "{{ csrf_token() }}"
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
          success:function(respuesta){
              window.location = route_principal; 
          },
          error:function(msj){
            swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
            }
      });
    });

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
        //pageLength: 25,
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


    $('.rojo').on('click', function(e) {
      e.preventDefault();
      procesando();
      window.location = "{{url('/')}}/reportes"
    })

    $('.table-responsive').on('show.bs.dropdown', function () {
      $('.table-responsive').css( "overflow", "inherit" );
    });

    $('.table-responsive').on('hide.bs.dropdown', function () {
      $('.table-responsive').css( "overflow", "auto" );
    })

    //Time

    @if(Auth::check())
      if ($('.time-picker')[0]) {
        @if($tipo_horario == 2)
          $('.time-picker').datetimepicker({
              format: 'LT'
          });
        @else
          $('.time-picker').datetimepicker({
              format: 'hh:mm a'
          });
        @endif
      }
    @endif

  </script>
		
	@yield('js')
		
       
    </body>
</html>