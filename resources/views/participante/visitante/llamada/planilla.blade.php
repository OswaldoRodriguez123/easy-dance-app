@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/farbtastic/farbtastic.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/easy_dance_ico_5.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/farbtastic/farbtastic.min.js"></script>
@stop

@section('content')
     
            <div class="modal fade" id="modalStatus-Llamada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Llamada<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_status_llamada" id="edit_status_llamada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-status">Estatus</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el status de la llamada" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-label-alt-outline f-22"></i></span>
                                      <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="status" id="informacion_efectiva" value="1" type="radio">
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

                               <input type="hidden" name="id" value="{{$llamada->id}}"></input>
                              

                               <div class="clearfix"></div> 

                               
                               
                           </div>
                           
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
                            <div class="col-sm-12">                            

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_status_llamada" data-update="status" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalObservacion-Llamada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Llamada<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_observacion_llamada" id="edit_observacion_llamada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="edad">Observación</label>
                                    <textarea class="form-control" id="observacion" name="observacion" rows="8" placeholder="250 Caracteres"></textarea>
                                 </div>
                                 <div class="has-error" id="error-observacion">
                                      <span >
                                          <small class="help-block error-span" id="error-observacion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 

                               <input type="hidden" name="id" value="{{$llamada->id}}"></input>

                               
                               
                           </div>
                           
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
                            <div class="col-sm-12">                            

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" href="#" data-formulario="edit_observacion_llamada" data-update="observacion" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalFechaProxima-Llamada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Llamada<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_fecha_siguiente_llamada" id="edit_fecha_siguiente_llamada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                    <label for="fecha_siguiente">Fecha de la próxima llamada</label>
                                    <input type="text" class="form-control date-picker input-sm" name="fecha_siguiente" id="fecha_siguiente" placeholder="Ej. 00/00/0000">
                                 </div>
                                    <div class="has-error" id="error-fecha_siguiente">
                                      <span >
                                          <small id="error-fecha_siguiente_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$llamada->id}}"></input>
                              

                               <div class="clearfix"></div> 
                               
                           </div>
                           
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
                            <div class="col-sm-12">                            

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_fecha_siguiente_llamada" data-update="fecha_siguiente" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalHoraProxima-Llamada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Llamada<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_hora_siguiente_llamada" id="edit_hora_siguiente_llamada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="hora_siguiente">Hora de la próxima llamada</label>
                                    <input type="text" class="form-control time-picker input-sm" name="hora_siguiente" id="hora_siguiente" placeholder="Ej. 00:00">
                                 </div>
                                 <div class="has-error" id="error-hora_siguiente">
                                      <span >
                                          <small class="help-block error-span" id="error-hora_siguiente_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 


                               <input type="hidden" name="id" value="{{$llamada->id}}"></input>
                              

                               <div class="clearfix"></div> 
                              
                           </div>
                           
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
                            <div class="col-sm-12">                            

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_hora_siguiente_llamada" data-update="hora_siguiente" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                      @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                       <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/participante/visitante/llamadas/{{$llamada->visitante_id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Llamadas</a>
                        
                       <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                      @else
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/inicio" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Inicio</a>
                      @endif


                    </div> 
                    
                    <div class="card">
                      <div class="card-header">
                            
                            
                      </div>
                      <div class="card-body p-b-20">
                        <div class="row">
                        <div class="container">
                         <div class="col-sm-3">
                            <div class="text-center p-t-30">       
                              <div class="row p-b-15 ">
                                <div class="col-md-12" data-src="/assets/img/ayuda-configuracion.jpg">
                                  <ul class="ca-menu-planilla">
                                    <li>
                                        <a href="#" class="disabled">
                                            <span class="ca-icon-planilla"><i class="zmdi zmdi-phone"></i></span>
                                            <div class="ca-content-planilla">
                                                <h2 class="ca-main-planilla">Vista Llamadas</h2>
                                                <h3 class="ca-sub-planilla">Personaliza el campo llamadas</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>

                                  @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)

                                  <div class="col-sm-12 text-center"> 

                                    <br></br>

                                    <span class="f-16 f-700">Acciones</span>

                                    <hr></hr>

                                    <i class="zmdi zmdi-delete boton red f-20 m-r-10 boton red sa-warning" id="{{$llamada->id}}" name="eliminar" data-original-title="Eliminar" data-toggle="tooltip" data-placement="bottom" title=""></i>



                                    <br></br>
                                  
                                    <hr></hr>

                                    <br></br>
                                   
                                  </div>

                                  @endif

                                </div>                
                              </div>
                              </div>
                              </div>

					           	<div class="col-sm-9">

                         <div class="col-sm-12">
                              <p class="text-center opaco-0-8 f-22">Datos de la Llamada</p>
                          </div>

                          <div class="col-sm-12">
                           <table class="table table-striped table-bordered">


                            @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                              <tr class="detalle" data-toggle="modal" href="#modalStatus-Llamada">

                            @else

                              <tr class="disabled">

                            @endif
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-status" class="zmdi {{ empty($llamada->status) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b-cuentales-historia f-22"></i> </span>
                               <span class="f-14"> Estatus </span>
                             </td>
                             <td>
                              <span id="llamada-status" class="f-14 m-l-15 capitalize" data-valor="{{$llamada->status}}">
                                @if($llamada->status == 1)
                                  <label class="label label-success"> </label>
                                @elseif($llamada->status == 2)
                                  <label class="label label-danger"> </label>
                                @else
                                  <label class="label label-warning"> </label>
                                @endif
                              </span>
                              <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> 
                              </td>
                            </tr>

                            @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                              <tr class="detalle" data-toggle="modal" href="#modalObservacion-Llamada">

                            @else

                              <tr class="disabled">

                            @endif
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-observacion" class="zmdi {{ empty($llamada->observacion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b-cuentales-historia f-22"></i> </span>
                               <span class="f-14"> Observación </span>
                             </td>
                             <td id="llamada-observacion" class="f-14 m-l-15 capitalize" data-valor="{{$llamada->observacion}}" >{{ str_limit($llamada->observacion, $limit = 30, $end = '...') }} <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                              <tr class="detalle" data-toggle="modal" href="#modalFechaProxima-Llamada">

                            @else

                              <tr class="disabled">

                            @endif
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-fecha_siguiente" class="zmdi {{ empty($llamada->fecha_siguiente) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-calendar-check f-22"></i> </span>
                               <span class="f-14"> Fecha de la próxima llamada </span>
                             </td>
                             <td class="f-14 m-l-15"><span id="llamada-fecha_siguiente">
                              @if($llamada->fecha_siguiente != '0000-00-00')
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d',$llamada->fecha_siguiente)->format('d/m/Y')}}
                              @endif
                            </span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
                            </tr>
                            @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                              <tr class="detalle" data-toggle="modal" href="#modalHoraProxima-Llamada">

                            @else

                              <tr class="disabled">

                            @endif
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-hora_siguiente" class="zmdi {{ empty($llamada->hora_siguiente) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-alarm f-22"></i> </span>
                               <span class="f-14"> Hora de la próxima llamada </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="llamada-hora_siguiente">
                                @if($llamada->hora_siguiente != '00:00:00')
                                  @if($tipo_horario == 2)
                                      {{\Carbon\Carbon::createFromFormat('H:i:s',$llamada->hora_siguiente)->format('H:i')}}
                                  @else
                                      {{\Carbon\Carbon::createFromFormat('H:i:s',$llamada->hora_siguiente)->format('g:i a')}}
                                  @endif
                                @endif
                              </span> </span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                        

                           </table>

                          
                          <div class="clearfix"></div>   
               
           
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
    route_update="{{url('/')}}/participante/visitante/llamadas/update";
    route_eliminar="{{url('/')}}/participante/visitante/llamadas/eliminar/";
    route_principal="{{url('/')}}/participante/visitante/llamadas/{{$llamada->visitante_id}}";

    $(document).ready(function(){

        $('body,html').animate({scrollTop : 0}, 500);
        var animation = 'fadeInLeftBig';
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

    $('#modalObservacion-Llamada').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var observacion=$("#llamada-observacion").data('valor');
       $("#observacion").val(observacion);
    })

    $('#modalFechaProxima-Llamada').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#fecha_siguiente").val($("#llamada-fecha_siguiente").text().trim()); 
    })
    $('#modalHoraProxima-Llamada').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#hora_siguiente").val($("#llamada-hora_siguiente").text().trim()); 
    })

    function limpiarMensaje(){
        var campo = ["observacion", "fecha_siguiente", "hora_siguiente", "estatus"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
        console.log(merror);
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

      function campoValor(form){
        $.each(form, function (n, c) {
          if(c.name=='observacion'){
             $("#llamada-"+c.name).data('valor',c.value);
             $("#llamada-"+c.name).html(c.value.toLowerCase().substr(0, 30) + "...");
            //$("#alumno-"+c.name).text(c.value.substr(0, 30));
          }else if(c.name=='status'){

            if(c.value=='1'){ 

              var valor='<label class="label label-success"> </label> </span>';                              
            }else if(c.value=='2'){
              var valor='<label class="label label-danger"> </label> </span>';
            }else{
              var valor='<label class="label label-warning"> </label> </span>';
            }

            $("#llamada-"+c.name).data('valor',c.value);
            $("#llamada-"+c.name).html(valor);
          }else{
            $("#llamada-"+c.name).text(c.value);
          }

          if(c.value == ''){
            $("#estatus-"+c.name).removeClass('c-verde zmdi-check');
            $("#estatus-"+c.name).addClass('c-amarillo zmdi-dot-circle');
          }
          else{
            $("#estatus-"+c.name).removeClass('c-amarillo zmdi-dot-circle');
            $("#estatus-"+c.name).addClass('c-verde zmdi-check');
          }
          
        });
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
                        template: '<div data-growl="container" class="alert f-700" role="alert">' +
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

    $(".guardar").click(function(){
        var nFrom = $(this).attr('data-from');
        var nAlign = $(this).attr('data-align');
        var nIcons = $(this).attr('data-icon');
        var nAnimIn = "animated flipInY";
        var nAnimOut = "animated flipOutY"; 
        limpiarMensaje();
        procesando();
        form=$(this).data('formulario');
        update=$(this).data('update');
        var token = $('input:hidden[name=_token]').val();
        var datos = $( "#"+form ).serialize();
        var datos_array=  $( "#"+form ).serializeArray();
        console.log(datos_array);
        
        var route = route_update+"/"+update;
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: datos,                
            success: function (respuesta) {
              setTimeout(function() {
                if(respuesta.status=='OK'){
                  finprocesado(); 
                  campoValor(datos_array);            
                  var nType = 'success';
                  var nTitle="Ups! ";
                  var nMensaje=respuesta.mensaje;                                      
                }else{
                  var nTitle="Ups! ";
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                  var nType = 'danger';
                }

                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                finprocesado();
                $('.modal').modal('hide');
              }, 1000);  
            },
            error:function (msj, ajaxOptions, thrownError){
              setTimeout(function(){ 
                if (typeof msj.responseJSON === "undefined") {
                          window.location = "{{url('/')}}/error";
                        }
                var nType = 'danger';
                if(msj.responseJSON.status=="ERROR"){
                  console.log(msj.responseJSON.errores);
                  errores(msj.responseJSON.errores);
                  var nTitle=" Ups! "; 
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                }else{
                  var nTitle=" Ups! "; 
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                }
                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                finprocesado();
              }, 1000);             
            }
        })
       
    })

    $("i[name=eliminar]").click(function(){
                id = this.id;
                swal({   
                    title: "Desea eliminar la llamada",   
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
                        eliminar(id);
          }
                });
          });
      function eliminar(id){
         var route = route_eliminar + id;
         procesando();
         var token = $('input:hidden[name=_token]').val();
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'DELETE',
                    dataType: 'json',
                    data:id,
                    success:function(respuesta){

                        window.location = route_principal; 

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
                                }
                });
      }

   </script> 

@stop
