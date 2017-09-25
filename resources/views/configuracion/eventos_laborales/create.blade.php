@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/farbtastic/farbtastic.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<!--<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.es.js"></script>-->
<script src="{{url('/')}}/assets/vendors/farbtastic/farbtastic.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>

@stop
@section('content')


            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/configuracion/eventos-laborales" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Eventos Laborales</a><ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            
                        </ul>
                        
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-center">
                            <span class="f-25 c-morado" id="id-evento_id"><i class="zmdi zmdi-calendar-check f-25"></i> Crea tu Evento Laboral </span>                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                          <form name="agregar_evento" id="agregar_evento"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>
                                <div class="col-sm-12">
                                 
                                    <label for="cargo" id="id-cargo">Cargo</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el cargo de la actividad" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_f-staff f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="cargo" id="cargo" data-live-search="true">
                                          <option value="">Selecciona</option>
                                          @foreach ( $config_staff as $cargo )
                                          <option value = "{{ $cargo['id'] }}">{{ $cargo['nombre'] }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-cargo">
                                      <span >
                                        <small class="help-block error-span" id="error-cargo_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>
                              </div>

                              <div class="clearfix p-b-35"></div>

                              <div class="col-sm-12">
                                 
                                    <label for="cargo" id="id-staff_id">Staff</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el staff" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_f-staff f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="staff_id" id="staff_id" data-live-search="true">
                                          <option value="">Selecciona</option>
                                          @foreach ( $staffs as $staff )
                                          <option value = "{{ $staff['id'] }}">{{ $staff['nombre'] }} {{ $staff['apellido'] }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-staff_id">
                                      <span >
                                        <small class="help-block error-span" id="error-staff_id_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>
                               </div>

                               <!-- <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-actividad_id">Actividad Laboral</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona la actividad" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-calendar-check f-22"></i></span>
                                      <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="actividad_id" id="actividad_id" data-live-search="true">
                                          <option value="">Selecciona</option>
                                          @foreach ( $actividades as $actividad )
                                          <option value = "{{ $actividad->id }}">{{ $actividad->nombre }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                 <div class="has-error" id="error-actividad_id">
                                      <span >
                                          <small class="help-block error-span" id="error-actividad_id_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">
                                    
                                      <label for="fecha" id="id-fecha">Fecha</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el día de la actividad que vas a crear" title="" data-original-title="Ayuda"></i>
                                      <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-calendar-check f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="fecha" id="fecha" class="form-control date-picker proceso pointer" placeholder="Seleciona" type="text" 

                                              @if (session('fecha_inicio'))
                                                value="{{session('fecha_inicio')}}"
                                              @endif
                                              >
                                          </div>

                                    </div>
                                    <div class="has-error" id="error-fecha">
                                        <span >
                                            <small class="help-block error-span" id="error-fecha_mensaje" ></small>                                           
                                        </span>
                                    </div>
                                </div>

                              <div class="clearfix p-b-35"></div>

                              <div class="col-xs-6">
                                 
                                      <label for="fecha_inicio" id="id-hora_inicio">Horario</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Define la hora de la actividad" title="" data-original-title="Ayuda"></i>

                                      <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-time f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="hora_inicio" id="hora_inicio" class="form-control time-picker pointer" placeholder="Desde" type="text">
                                          </div>
                                    </div>
                                 <div class="has-error" id="error-hora_inicio">
                                      <span >
                                          <small class="help-block error-span" id="error-hora_inicio_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="col-xs-6">
                                      <label for="fecha_inicio" id="id-hora_final">&nbsp;</label>
                                      <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-time f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="hora_final" id="hora_final" class="form-control time-picker pointer" placeholder="Hasta" type="text">
                                          </div>
                                    </div>
                                 <div class="has-error" id="error-hora_final">
                                      <span >
                                          <small class="help-block error-span" id="error-hora_final_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
 -->       

                              <div class="clearfix p-b-35"></div>
                                        
                              <div class="form-group">
                                
                                <div class="col-sm-2">
                                  <label for="actividad_id" id="id-actividad_id">Actividad Laboral </label>
                                </div>
                                <div class="col-sm-2">
                                  <div class="fg-line">
                                    <div class="select">
                                      <select class="selectpicker" name="actividad_id" id="actividad_id" data-live-search="true">
                                        <option value="">Selecciona</option>
                                        @foreach ( $actividades as $actividad )
                                        <option value = "{{ $actividad->id }}">{{ $actividad->nombre }}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                                  <div class="has-error" id="error-actividad_id">
                                      <span >
                                          <small class="help-block error-span" id="error-actividad_id_mensaje" ></small>                                
                                      </span>
                                  </div>
                                </div>
                                <div class="col-sm-1">
                                  <label for="fecha" id="id-fecha">Fecha </label>
                                </div>

                                <div class="col-sm-2">
                                   <div class="dtp-container fg-line">
                                      <input name="fecha" id="fecha" class="form-control date-picker proceso pointer" placeholder="Seleciona" type="text" 

                                      @if (session('fecha_inicio'))
                                        value="{{session('fecha_inicio')}}"
                                      @endif
                                      >
                                  </div>
                                  <div class="has-error" id="error-fecha">
                                      <span >
                                          <small class="help-block error-span" id="error-fecha_mensaje" ></small>                                
                                      </span>
                                  </div>
                                </div>

                                <div class="col-sm-1">
                                  <label for="fecha" id="id-hora_inicio">Horario </label>
                                </div>

                                <div class="col-sm-2">
                                   
                                  <div class="dtp-container fg-line">
                                    <input name="hora_inicio" id="hora_inicio" class="form-control time-picker pointer" placeholder="Desde" type="text">
                                  </div>
                                  <div class="has-error" id="error-hora_inicio">
                                      <span >
                                          <small class="help-block error-span" id="error-hora_inicio_mensaje" ></small>                                
                                      </span>
                                  </div>
                                </div>

                                <div class="col-sm-2" id="id-hora_final">
                                   
                                  <div class="dtp-container fg-line">
                                    <input name="hora_final" id="hora_final" class="form-control time-picker pointer" placeholder="Hasta" type="text">
                                  </div>
                                  <div class="has-error" id="error-hora_final">
                                      <span >
                                          <small class="help-block error-span" id="error-hora_final_mensaje" ></small>                                
                                      </span>
                                  </div>
                                </div>
                              </div>

                              <div class="clearfix p-b-35"></div>

                              <div class="col-md-12 text-left pull-left">
                                <button type="button" class="btn btn-blanco m-r-8 f-10 guardar" name= "add" id="add" > Agregar Linea <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>
                              </div>

                              <div class="clearfix p-b-35"></div>

                              <div class="col-md-12">
                                <div class="table-responsive row">
                                  <div class="col-md-12">
                                    <table class="table table-striped table-bordered text-center " id="tablelistar" >
                                      <thead>
                                        <tr>
                                            <th class="text-center" data-column-id="acepto" data-order="desc"></th>
                                            <th class="text-center" data-column-id="staff" data-order="desc">Staff</th>
                                            <th class="text-center" data-column-id="actividad" data-order="desc">Actividad</th>
                                            <th class="text-center" data-column-id="fecha">Fecha</th>
                                            <th class="text-center" data-column-id="operacion" data-order="desc">Acciones</th>
                                        </tr>
                                      </thead>
                                      <tbody class="text-center" >
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>

                              <div class="clearfix p-b-35"></div>

                          <div class="modal-footer p-b-20 m-b-20">
                            <div class="col-sm-12 text-left">
                              <div class="procesando hidden">
                              <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                              <div class="preloader pls-purple">
                                  <svg class="pl-circular" viewBox="25 25 50 50">
                                      <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                  </svg>
                              </div>
                              </div>
                            </div>
                            <div class="col-sm-12 text-left">                          
                              <button type="button" class="btn btn-blanco m-r-10 f-18 guardar" id="guardar" >Guardar</button>

                              <button type="button" class="cancelar btn btn-default" id="cancelar">Cancelar</button>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div> 

          

                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <nav class="navbar navbar-default navbar-fixed-bottom">
              <div class="container">
                
                <div class="col-xs-1 p-t-15 f-700 text-center" id="text-progreso" >40%</div>
                <div class="col-xs-11">
                  <div class="clearfix p-b-20"></div>
                  <div class="progress-fino progress-striped m-b-10">
                    <div class="progress-bar progress-bar-morado" id="barra-progreso" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                  </div>
                </div>
              </div>
            </nav>
@stop
@section('js') 
<script type="text/javascript">

  route_agregar="{{url('/')}}/configuracion/eventos-laborales/agregar";
  route_principal="{{url('/')}}/configuracion/eventos-laborales";
  route_eliminar="{{url('/')}}/configuracion/eventos-laborales/eliminar/";

  var staffs = <?php echo json_encode($staffs);?>;

  $(document).ready(function(){
        $('body,html').animate({scrollTop : 0}, 500);
        var animation = 'fadeInDownBig';
        //var cardImg = $(this).closest('#content').find('h1');
        if (animation === "hinge") {
        animationDuration = 3100;
        }
        else {
        animationDuration = 3200;
        }
        //$("h1").removeAttr('class');
        $(".container").addClass('animated '+animation);

            setTimeout(function(){
                $(".card-body").removeClass(animation);
            }, animationDuration);


      });

  setInterval(porcentaje, 1000);

  function porcentaje(){
    var campo = ["staff_id", "cargo","actividad_id", "fecha", "hora_inicio", "hora_final"];
    fLen = campo.length;
    var porcetaje=0;
    var cantidad =0;
    var porciento= fLen / fLen;
    for (i = 0; i < fLen; i++) {
      var valor="";
      valor=$("#"+campo[i]).val();
      valor=valor.trim();
      if(campo[i]=="color_etiqueta"){
        if ( valor.length > 6 ){        
          cantidad=cantidad+1;
        }else if (valor.length == 0){
          $("#"+campo[i]).val('#');
        }
      }else{
        if ( valor.length > 0 ){        
          cantidad=cantidad+1;
        }
      }
      
    }

    porcetaje=(cantidad/fLen)*100;
    porcetaje=porcetaje.toFixed(2);
    //console.log(porcetaje);
    $("#text-progreso").text(porcetaje+"%");
    $("#barra-progreso").css({
      "width": (porcetaje + "%")
   });
    

    if(porcetaje=="100" || porcetaje=="100.00"){
      $("#barra-progreso").removeClass('progress-bar-morado');
      $("#barra-progreso").addClass('progress-bar-success');
    }else{
      $("#barra-progreso").removeClass('progress-bar-success');
      $("#barra-progreso").addClass('progress-bar-morado');
    }
    //$("#barra-progreso").s

  }

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

    $("#guardar").click(function(){
      procesando();
      setTimeout(function(){ 
        window.location = route_principal;
      }, 2000); 
    });

    function limpiarMensaje(){
      var campo = ["staff_id", "fecha", "hora_inicio", "hora_final", "cargo", "descripcion"];
      fLen = campo.length;
      for (i = 0; i < fLen; i++) {
          $("#error-"+campo[i]+"_mensaje").html('');
      }
    }

    function errores(merror){
      var elemento="";
      var contador=0;
      $.each(merror, function (n, c) {
      if(contador==0){
      elemento=n;
      }
      contador++;

       $.each(this, function (name, value) {              
          var error=value;
          $("#error-"+n+"_mensaje").html(error);             
       });
    });

      $('html,body').animate({
            scrollTop: $("#id-"+elemento).offset().top-90,
      }, 1000);          

  }

  $( "#cancelar" ).click(function() {
    $("#agregar_evento")[0].reset();
    $('#cargo').selectpicker('refresh')
    $('#staff_id').selectpicker('refresh')
    $('#actividad_id').selectpicker('refresh')
    limpiarMensaje();
    $('html,body').animate({
    scrollTop: $("#id-evento_id").offset().top-90,
    }, 1000);
  });

  $('#cargo').on('change', function(){

      id = $(this).val();
      $('#staff_id').empty();

      var staff = $.grep(staffs, function(e){ return e.cargo == id; });

      $('#staff_id').append( new Option("Selecciona",""));

      $.each(staff, function (index, arreglo) {
        $('#staff_id').append( new Option(arreglo.nombre + ' ' + arreglo.apellido,arreglo.id));
      });
          
      $('#staff_id').selectpicker('refresh');

    });

   function countChar(val) {
    var len = val.value.length;
    if (len >= 250) {
      val.value = val.value.substring(0, 250);
    } else {
      $('#charNum').text(250 - len);
    }
  };

  t=$('#tablelistar').DataTable({
    processing: true,
    serverSide: false,
    pageLength: 25, 
    bPaginate: false, 
    bFilter:false, 
    bSort:false, 
    bInfo:false,
    fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
      $('td:eq(0),td:eq(1),td:eq(2),td:eq(3)', nRow).addClass( "text-center" );
      $('td:eq(0),td:eq(1),td:eq(2),td:eq(3)', nRow).addClass( "disabled" );
    },
    language: {
                    processing:     "Procesando ...",
                    search:         '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>',
                    searchPlaceholder: "BUSCAR",
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

    $("#add").click(function(){

      procesando();

      $("#add").attr("disabled","disabled");
      $("#add").css({
        "opacity": ("0.2")
      });
      $("#guardar").attr("disabled","disabled");
      $(".cancelar").attr("disabled","disabled");

      var route = route_agregar;
      var token = $('input:hidden[name=_token]').val();
      var datos = $("#agregar_evento").serialize(); 
      limpiarMensaje();
      $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data:datos,
        success:function(respuesta){
          setTimeout(function(){ 
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nAnimIn = "animated flipInY";
            var nAnimOut = "animated flipOutY"; 
            if(respuesta.status=="OK"){

              var nType = 'success';
              var nTitle="Ups! ";
              var nMensaje=respuesta.mensaje;

              var rowId=respuesta.evento.id;
              var rowNode=t.row.add( [
              '',
              ''+respuesta.staff+'',
              ''+respuesta.actividad+'',
              ''+respuesta.evento.fecha+'',
              '<i class="zmdi zmdi-delete boton red f-20 p-r-10"></i>'
              ] ).draw(false).node();
              $( rowNode )
                .attr('id',rowId)
                .addClass('seleccion');

              $('#actividad_id').val('')
              $('#actividad_id').selectpicker('refresh')
              $('#fecha').val('')
              $('#hora_inicio').val('')
              $('#hora_final').val('')
              limpiarMensaje();

          
            }else{
              var nTitle="Ups! ";
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              var nType = 'danger';
            }    
            finprocesado();                   
            $("#guardar").removeAttr("disabled");
            $(".cancelar").removeAttr("disabled");
            $("#add").removeAttr("disabled");
            $("#add").css({
              "opacity": ("1")
            });

            notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
          }, 1000);
        },
        error:function(msj){
          setTimeout(function(){ 
            if (typeof msj.responseJSON === "undefined") {
              window.location = "{{url('/')}}/error";
            }
            if(msj.responseJSON.status=="ERROR"){
              console.log(msj.responseJSON.errores);
              errores(msj.responseJSON.errores);
              var nTitle="    Ups! "; 
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
            }else{
              var nTitle="   Ups! "; 
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
            }                        
            $("#guardar").removeAttr("disabled");
            $(".cancelar").removeAttr("disabled");
            $("#add").removeAttr("disabled");
            $("#add").css({
              "opacity": ("1")
            });
            finprocesado();
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nType = 'danger';
            var nAnimIn = "animated flipInY";
            var nAnimOut = "animated flipOutY";                       
            notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
          }, 1000);
        }
      });
    });

    $('#tablelistar tbody').on( 'click', 'i.zmdi-delete', function () {

      var id = $(this).closest('tr').attr('id');
      element = this;

      swal({   
          title: "Desea eliminar el evento?",   
          text: "Confirmar eliminación!",   
          type: "warning",   
          showCancelButton: true,   
          confirmButtonColor: "#DD6B55",   
          confirmButtonText: "Eliminar!",  
          cancelButtonText: "Cancelar",         
          closeOnConfirm: true 
          }, function(isConfirm){   
      if (isConfirm) {
        var nFrom = $(this).attr('data-from');
        var nAlign = $(this).attr('data-align');
        var nIcons = $(this).attr('data-icon');
        var nType = 'success';
        var nAnimIn = $(this).attr('data-animation-in');
        var nAnimOut = $(this).attr('data-animation-out')
        
          eliminar(id, element);
        }
      });
    });

    function eliminar(id, element){
      var route = route_eliminar + id;
      var token = "{{ csrf_token() }}";
      procesando();
        
      $.ajax({
          url: route,
          headers: {'X-CSRF-TOKEN': token},
          type: 'DELETE',
          dataType: 'json',
          data:id,
          success:function(respuesta){
              var nFrom = $(this).attr('data-from');
              var nAlign = $(this).attr('data-align');
              var nIcons = $(this).attr('data-icon');
              var nAnimIn = "animated flipInY";
              var nAnimOut = "animated flipOutY"; 
              if(respuesta.status=="OK"){
                // finprocesado();
                var nType = 'success';
                var nTitle="Ups! ";
                var nMensaje=respuesta.mensaje;

                swal("Exito!","El evento ha sido eliminado!","success");

                t.row( $(element).parents('tr') )
                  .remove()
                  .draw();
                finprocesado();
              }
          },
          error:function(msj){
                      $("#msj-danger").fadeIn(); 
                      var text="";
                      console.log(msj);
                      var merror=msj.responseJSON;
                      text += " <i class='glyphicon glyphicon-remove'></i> Por favor verifique los datos introducidos<br>";
                      $("#msj-error").html(text);
                      setTimeout(function(){
                               $("#msj-danger").fadeOut();
                              }, 3000);
                      finprocesado();
                      }
      });
    }

</script> 
@stop

