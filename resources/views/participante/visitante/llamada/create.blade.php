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
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/participante/visitante/llamadas/{{$id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Llamada</a><ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            
                        </ul>
                        
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-center">
                            <span class="f-25 c-morado"><i class="zmdi zmdi-phone f-25" id="id-visitante_id"></i> Agregar Llamada</span>                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                          <form name="form_guardar" id="form_guardar"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input type="hidden" id ="id" name="id" value="{{$id}}"></input>
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-status">Estatus</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el status de la llamada" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-label-alt-outline f-22"></i></span>
                                      <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="status" id="informacion_efectiva" value="1" type="radio" checked>
                                        <i class="input-helper"></i>  
                                          Información efectiva 
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="status" id="sin_comunicacion" value="2" type="radio">
                                        <i class="input-helper"></i>  
                                        Sin comunicación
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="status" id="llamarlo_luego" value="3" type="radio">
                                        <i class="input-helper"></i>  
                                       Llamarlo luego
                                    </label>
                                    </div>
                                    </div>
                                 <div class="has-error" id="error-status">
                                      <span >
                                          <small class="help-block error-span" id="error-status_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-observacion">Observación</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Crea una buena primera impresión  presenta los objetivos de tu fiesta  y persuade a tus  clientes  para que obtengan más información. Esta información básica será vista por todos tus alumnos" title="" data-original-title="Ayuda"></i>

                                    <br></br>

                                    <div class="fg-line">
                                      <textarea class="form-control" id="observacion" name="observacion" rows="8" placeholder="2000 Caracteres" maxlength="2000" onkeyup="countChar(this)"></textarea>
                                    </div>
                                    <div class="opaco-0-8 text-right">Resta <span id="charNum">2000</span> Caracteres</div>
                                 <div class="has-error" id="error-observacion">
                                      <span >
                                          <small class="help-block error-span" id="error-observacion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                                  

                              <div class="clearfix p-b-35"></div>


                              <div id="div_reprogramar" style="display: none">
                               
                                <div class="col-sm-12">
                                 
                                  <label for="fecha_siguiente" id="id-fecha_siguiente">Fecha de la Proxima Llamada</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la fecha" title="" data-original-title="Ayuda"></i>

                                  <div class="input-group">
                                  <span class="input-group-addon"><i class="zmdi zmdi-calendar-check f-22"></i></span>
                                  <div class="dtp-container fg-line">
                                      <input name="fecha_siguiente" id="fecha_siguiente" class="form-control date-picker proceso pointer" placeholder="Selecciona" type="text">
                                  </div>
                                </div>
                                 <div class="has-error" id="error-fecha_siguiente">
                                      <span >
                                          <small class="help-block error-span" id="error-fecha_siguiente_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
    
                              <div class="clearfix p-b-35"></div>

                              <div class="col-sm-12">
                           
                                <label for="hora_siguiente" id="id-hora_siguiente">Hora de la Proxima Llamada</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la hora" title="" data-original-title="Ayuda"></i>

                                <div class="input-group col-xs-12">
                                <span class="input-group-addon"><i class="zmdi zmdi-time f-22"></i></span>
                                <div class="dtp-container fg-line">
                                        <input name="hora_siguiente" id="hora_siguiente" class="form-control time-picker" placeholder="Hora" type="text">
                                    </div>
                                </div>
                             <div class="has-error" id="error-hora_siguiente">
                                  <span >
                                      <small class="help-block error-span" id="error-hora_siguiente_mensaje" ></small>                                
                                  </span>
                              </div>
                             </div>

                             <div class="clearfix p-b-35"></div>
                          </div>

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

@stop
@section('js') 
<script type="text/javascript">

  route_principal="{{url('/')}}/participante/visitante/llamadas/{{$id}}";
  route_agregar="{{url('/')}}/participante/visitante/llamadas/agregar";
  
  $(document).ready(function(){

    $('input[name=status]').change(function() {
        val = $(this).val();
        if(val == 1){
          $("#div_reprogramar").hide();
        }else{
          $("#div_reprogramar").show();
        }
    });
  });

    $("#guardar").click(function(){

        var route = route_agregar;
        var token = $('input:hidden[name=_token]').val();
        var datos = $( "#form_guardar" ).serialize(); 
        procesando(); 
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
                  var nTitle="Exito! ";
                  var nMensaje=respuesta.mensaje;

                  
                  window.location = route_principal;
                  
              
                }else{
                  var nTitle="Ups! ";
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                  var nType = 'danger';
                }

                finprocesado();

                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);                       
                
              }, 1000);
            },
            error:function(msj){
              setTimeout(function(){ 
                if(msj.responseJSON.status=="ERROR"){
                  errores(msj.responseJSON.errores);
                  var nTitle="    Ups! "; 
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                }else{
                  var nTitle="   Ups! "; 
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                }                        
                finprocesado();
                var nFrom = $(this).attr('data-from');
                var nAlign = $(this).attr('data-align');
                var nIcons = $(this).attr('data-icon');
                var nType = 'danger';
                var nAnimIn = "animated flipInY";
                var nAnimOut = "animated flipOutY";
                var nTitle = 'Error!';               
                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
              }, 1000);
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

      function limpiarMensaje(){
      var campo = ["status", "observacion", "fecha_siguiente", "hora_siguiente"];
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
    $("#form_guardar")[0].reset();
    limpiarMensaje();
    $('html,body').animate({
    scrollTop: $("#id-status").offset().top-90,
    }, 1000);
  });

  function countChar(val) {
    var len = val.value.length;
    if (len >= 180) {
      val.value = val.value.substring(0, 180);
    } else {
      $('#charNum').text(180 - len);
    }
  };
</script> 
@stop

