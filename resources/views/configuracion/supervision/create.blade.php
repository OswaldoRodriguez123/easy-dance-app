@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/farbtastic/farbtastic.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<!--<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.es.js"></script>-->
<script src="{{url('/')}}/assets/vendors/farbtastic/farbtastic.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

@stop
@section('content')

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/configuracion/supervisiones" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Configuración</a>
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            
                        </ul>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-center">
                            <span class="f-25 c-morado"><i class="icon_f-staff f-25" id="id-supervision"></i> Agregar Supervisión</span>                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                          <form name="agregar_supervision" id="agregar_supervision"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>
                                  <div class="col-sm-12">

                                   <div class="form-group">
                                        <label for="id">Cargo</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el cargo de los distintos procedimientos que posees en tu academia" title="" data-original-title="Ayuda"></i>

                                        <div class="input-group">
                                          <span class="input-group-addon"><i class="icon_f-staff f-22"></i></span>
                                          <div class="select">

                                            <select class="selectpicker" name="cargo_supervision" id="cargo_supervision" data-live-search="true">

                                              <option value="">Selecciona</option>
                                              @foreach ( $cargos as $cargo )
                                                <option value = "{{ $cargo['id'] }}">{{ $cargo['nombre'] }}</option>
                                              @endforeach

                                            </select>
                                        </div>
                                    </div>
                                     <div class="has-error" id="error-cargo_supervision">
                                          <span >
                                              <small class="help-block error-span" id="error-cargo_supervision_mensaje" ></small>                               
                                          </span>
                                      </div>
                                   </div>

                                   <div class="clearfix p-b-35"></div>

                                      <label for="nombre" id="id-descripcion">Descripción</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la descripción del cargo" title="" data-original-title="Ayuda"></i>

                                      <br></br>

                                      <div class="fg-line">
                                        <textarea class="form-control" id="descripcion" name="descripcion" rows="8" placeholder="2000 Caracteres" maxlength="2000" onkeyup="countChar(this)"></textarea>
                                      </div>
                                      <div class="opaco-0-8 text-right">Resta <span id="charNum">2000</span> Caracteres</div>
                                   <div class="has-error" id="error-descripcion">
                                        <span >
                                            <small class="help-block error-span" id="error-descripcion_mensaje" ></small>                                
                                        </span>
                                    </div>
                            

                                   <div class="clearfix p-b-15"></div>


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
                            
                              <button type="button" class="cancelar btn btn-default" id="cancelar" name="cancelar">Cancelar</button>
            
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

  route_agregar="{{url('/')}}/configuracion/supervisiones/agregar";
  route_principal="{{url('/')}}/configuracion/supervisiones";
  route_cancelar = "{{url('/')}}/configuracion/supervisiones/cancelar";

    var cargos = <?php echo json_encode($cargos);?>;
    var cargos_usados = <?php echo json_encode($cargos_usados);?>;

    $(document).ready(function(){
      $.each(cargos, function (i, cargo) {
        $.each(cargos_usados, function (j, id) {
          if(cargo.id == id){
            $("#cargo_supervision option[value='"+cargo.id+"']").attr("disabled","disabled");
            $("#cargo_supervision option[value='"+cargo.id+"']").data("icon","glyphicon-remove");
          }
        });
      });

      $('.selectpicker').selectpicker('refresh')

    });

    $("#guardar").click(function(){

      procesando();

      var route = route_agregar;
      var token = $('input:hidden[name=_token]').val();
      var datos = $( "#agregar_supervision" ).serialize(); 

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
                // finprocesado();
                // var nType = 'success';
                // $("#agregar_alumno")[0].reset();
                // var nTitle="Ups! ";
                // var nMensaje=respuesta.mensaje;
                window.location = route_principal;
              }else{
                var nTitle="Ups! ";
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                var nType = 'danger';

                finprocesado();

                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
              }                       
              
            }, 1000);
          },
          error:function(msj){
            setTimeout(function(){ 
              // if (typeof msj.responseJSON === "undefined") {
              //   window.location = "{{url('/')}}/error";
              // }
              if(msj.responseJSON.status=="ERROR"){
                console.log(msj.responseJSON.errores);
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
              notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
            }, 1000);
          }
      });
     
  });

    $("#cancelar").click(function(){

      $("#agregar_supervision")[0].reset();
      $('.selectpicker').selectpicker('refresh')

      $('html,body').animate({
        scrollTop: $("#id-supervision").offset().top-90,
      }, 1500)
    });

    function countChar(val) {
      var len = val.value.length;
      if (len >= 2000) {
        val.value = val.value.substring(0, 2000);
      } else {
        $('#charNum').text(2000 - len);
      }
    };

    function errores(merror){
         $.each(merror, function (n, c) {
             console.log(n);
           $.each(this, function (name, value) {
              //console.log(this);
              var error=value;
              $("#error-"+n+"_mensaje").html(error);
              console.log(value);
           });
        });
      }

    function limpiarMensaje(){
      var campo = ["cargo_supervision","descripcion"];
      fLen = campo.length;
      for (i = 0; i < fLen; i++) {
          $("#error-"+campo[i]+"_mensaje").html('');
      }
    }

</script> 
@stop

