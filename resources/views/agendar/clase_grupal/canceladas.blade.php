@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
@stop
@section('content')


            <div class="modal fade" id="modalCancelar" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <!--<h4 class="modal-title">Agendar</h4>-->
                                    <i class="icon_a-agendar f-35" ></i>
                                    <button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body m-b-20">
                                    <p class="text-center p-t-0 f-700 opaco-0-8 f-25">Hey {{Auth::user()->nombre}}.</p> 
                                    <p class="text-center p-b-20 f-700 opaco-0-8 f-22">¿Listo para bloquear una clase?...</p>
                                    <form id="frm_agendar" name="frm_agendar" class="addEvent" role="form" method="POST" action="agendar">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="col-sm-4">
                                      <ul class="ca-menu" style="margin: 0 auto;">
                                        <li style="height: 250px;">
                                            <a href="#modalCancelarUna" data-toggle="modal" class="agendar" data-agendar="clases-grupales">
                                                <span class="ca-icon" style="line-height: 60px, top: 35%;"><i class="icon_f-1-una-clase"></i></span>
                                                <div class="ca-content" style="top: 35%;">
                                                    <h2 class="ca-main f-20">Bloquear una clase</h2>
                                                    <h3 class="ca-sub" style="line-height: 20px;">Bloquear!</h3>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    </div>
                                    <div class="col-sm-4">
                                      <ul class="ca-menu" style="margin: 0 auto;">
                                        <li style="height: 250px;">
                                            <a href="#modalCancelarVarias" data-toggle="modal" class="agendar" data-agendar="clases-personalizadas">
                                                <span class="ca-icon" style="line-height: 60px, top: 35%;"><i class="icon_f-varias-clases"></i></span>
                                                <div class="ca-content" style="top: 35%;">
                                                    <h2 class="ca-main f-20">Bloquear varias Clases</h2>
                                                    <h3 class="ca-sub" style="line-height: 20px;">Bloquear!</h3>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    </div>
                                    <div class="col-sm-4">
                                      <ul class="ca-menu" style="margin: 0 auto;">
                                        <li style="height: 250px;">
                                            <a href="#modalCancelarPermanente" data-toggle="modal" class="agendar" data-agendar="talleres" >
                                                <span class="ca-icon" style="line-height: 60px, top: 35%;"><i class="icon_f-eliminar-todas"></i></span>
                                                <div class="ca-content" style="top: 35%;">
                                                    <h2 class="ca-main f-20">Bloquear clases permanentemente</h2>
                                                    <h3 class="ca-sub" style="line-height: 20px;">Bloquear!</h3>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    </div>

                                    <div class="clearfix p-b-10"></div>

                                        
                                        <input type="hidden" id="getStart" name="getStart" />
                                        <input type="hidden" id="getEnd" name="getEnd" />
                                        <input type="hidden" id="agendar" name="agendar" />
                                    </form>
                                </div>
                                
                                <div class="modal-footer">
                                    <!--<button type="submit" class="btn btn-link" id="addEvent">Add Event</button>
                                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>-->
                                </div>
                            </div>
                        </div>
                    </div>


<div class="modal fade" id="modalCancelarUna" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                                        <h4 class="modal-title c-negro"> Bloquear una clase <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                                    </div>
                                    <form name="cancelar_una_clase" id="cancelar_una_clase"  >
                                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                       <input type="hidden" name="id" id="id" value="{{$id}}"></input>  
                                       
                                       <div class="modal-body">  

                                       <div class="row p-t-20 p-b-0">

                                           <div class="col-sm-3">
  
                                                <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                                <div class="clearfix p-b-15"></div>
    
                                                <span class="f-15 f-700 span_instructor">{{$clasegrupal->instructor_nombre}} {{$clasegrupal->instructor_apellido}}  </span>

                                                  
                                           </div>

                                           <div class="col-sm-3">
  
                                                <span class="f-15 f-700">{{$clasegrupal->clase_grupal_nombre}}</span>

                                                  
                                           </div>

                                           <div class="col-sm-6">
                                             
                                            <p class="f-16"> <span class="f-700 span_hora">Horario: {{$clasegrupal->hora_inicio}} - {{$clasegrupal->hora_final}}</span></p>

                                            <p class="f-16"> <span class="f-700 span_hora" style="float:left; padding-top: 0.5%">Fecha: 

                                            <div class="dtp-container">
                                              <input name="fecha_cancelacion" id="fecha_cancelacion" class="form-control date-picker proceso pointer" placeholder="Seleciona" type="text" style="padding-top: 0; width: 85%" value="{{$fecha_inicio}}">
                                            </div>


                                            </span></p>


                                               <div class="clearfix"></div> 
                                               <div class="clearfix p-b-15"></div>


                                           </div>

                                           
                                       </div>                         

                                       <div class="row p-t-20 p-b-0">

                     

                               <div class="clearfix p-b-35"></div>


            

                                      <div class="col-sm-12">
                                 
                                        <label for="razon_cancelacion" id="id-razon_cancelacion">Razones del bloqueo</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica las razones por el cual estás cancelando o bloqueando la clase" title="" data-original-title="Ayuda"></i>
                                        <br></br>

                                        <div class="fg-line">
                                          <textarea class="form-control" id="razon_cancelacion" name="razon_cancelacion" rows="2" placeholder="Ej. No podré  asistir por razones ajenas a mi voluntad"></textarea>
                                          </div>
                                        <div class="has-error" id="error-razon_cancelacion">
                                          <span >
                                            <small class="help-block error-span" id="error-razon_cancelacion_mensaje" ></small>                                           
                                          </span>
                                        </div>
                                      </div>

                                      <div class="col-sm-12">
                                       <div class="form-group fg-line ">
                                          <label for="">Mostrar bloqueo en la web</label id="id-boolean_mostrar"> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona si los clientes e instructores podrán ver el bloqueo de la clase en el calendario de actividades" title="" data-original-title="Ayuda"></i>
                                          
                                          <br></br>
                                          <input type="text" class="boolean_mostrar" id="boolean_mostrar" name="boolean_mostrar" value="" hidden="hidden">
                                          <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input class ="mostrar" id="mostrar" type="checkbox">
                                            
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                          </div>
                                          
                                       </div>
                                       <div class="has-error" id="error-boolean_mostrar">
                                            <span >
                                                <small class="help-block error-span" id="error-boolean_mostrar_mensaje" ></small>                                           
                                            </span>
                                        </div>
                                     </div>

                                       </div>
                                       
                                    </div>
                                    <div class="modal-footer p-b-20 m-b-20">
                                        <div class="col-sm-6 text-left">
                                          <div class="procesando hidden">
                                          <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                                          <div class="preloader pls-purple">
                                              <svg class="pl-circular" viewBox="25 25 50 50">
                                                  <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                              </svg>
                                          </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-6">                          
                                          <button type="button" class="btn-blanco btn m-r-10 f-16 cancelar_una_clase" > Completar el bloqueo</button>
                                          <button type="button" class="cancelar btn btn-default" data-dismiss="modal">Volver</button>
                                        </div>
                                    </div></form>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="modalCancelarVarias" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                                        <h4 class="modal-title c-negro"> Bloquear varias clases <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                                    </div>
                                    <form name="cancelar_varias_clases" id="cancelar_varias_clases"  >
                                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                       <input type="hidden" name="id" id="id" value="{{$id}}"></input>  
                                       
                                       <div class="modal-body">  

                                       <div class="row p-t-20 p-b-0">

                                           <div class="col-sm-3">
  
                                                <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                                <div class="clearfix p-b-15"></div>
    
                                                <span class="f-15 f-700 span_instructor">{{$clasegrupal->instructor_nombre}} {{$clasegrupal->instructor_apellido}}  </span>

                                                  
                                           </div>

                                           <div class="col-sm-3">
  
                                                <span class="f-15 f-700">{{$clasegrupal->clase_grupal_nombre}}</span>

                                                  
                                           </div>

                                           <div class="col-sm-6">
                                             
                                            <p class="f-16"> <span class="f-700 span_hora">Horario: {{$clasegrupal->hora_inicio}} - {{$clasegrupal->hora_final}}</span></p>


                                               <div class="clearfix"></div> 
                                               <div class="clearfix p-b-15"></div>


                                           </div>

                                           
                                       </div>                         

                                       <div class="row p-t-20 p-b-0">

                     

                               <div class="clearfix p-b-35"></div>


            

                                      <div class="col-sm-12">
                                 
                                        <label for="razon_cancelacion" id="id-razon_cancelacion">Razones del bloqueo</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica las razones por el cual estás cancelando o bloqueando la clase" title="" data-original-title="Ayuda"></i>
                                        <br></br>

                                        <div class="fg-line">
                                          <textarea class="form-control" id="razon_cancelacion" name="razon_cancelacion" rows="2" placeholder="Ej. No podré  asistir por razones ajenas a mi voluntad"></textarea>
                                          </div>
                                        <div class="has-error" id="error-razon_cancelacion">
                                          <span >
                                            <small class="help-block error-span" id="error-razon_cancelacion_mensaje" ></small>                                           
                                          </span>
                                        </div>
                                      </div>

                                      <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-group fg-line">
                                            <label for="fecha_inicio">Fecha</label>
                                            <div class="fg-line">
                                                <input type="text" id="fecha2" name="fecha2" class="form-control pointer" placeholder="Selecciona la fecha">
                                            </div>
                                         </div>
                                            <div class="has-error" id="error-fecha2">
                                              <span >
                                                  <small id="error-fecha2_mensaje" class="help-block error-span" ></small>                                           
                                              </span>
                                            </div>
                                        </div>
                                       </div>

                                      <div class="col-sm-12">
                                       <div class="form-group fg-line ">
                                          <label for="">Mostrar bloqueo en la web</label id="id-boolean_mostrar"> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona si los clientes e instructores podrán ver el bloqueo de la clase en el calendario de actividades" title="" data-original-title="Ayuda"></i>
                                          
                                          <br></br>
                                          <input type="text" class="boolean_mostrar" id="boolean_mostrar" name="boolean_mostrar" value="" hidden="hidden">
                                          <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input class ="mostrar" id="mostrar" type="checkbox">
                                            
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                          </div>
                                          
                                       </div>
                                       <div class="has-error" id="error-boolean_mostrar">
                                            <span >
                                                <small class="help-block error-span" id="error-boolean_mostrar_mensaje" ></small>                                           
                                            </span>
                                        </div>
                                     </div>

                                       </div>
                                       
                                    </div>
                                    <div class="modal-footer p-b-20 m-b-20">
                                        <div class="col-sm-6 text-left">
                                          <div class="procesando hidden">
                                          <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                                          <div class="preloader pls-purple">
                                              <svg class="pl-circular" viewBox="25 25 50 50">
                                                  <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                              </svg>
                                          </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-6">                          
                                          <button type="button" class="btn-blanco btn m-r-10 f-16 cancelar_varias_clases" > Completar el bloqueo</button>
                                          <button type="button" class="cancelar btn btn-default" data-dismiss="modal">Volver</button>
                                        </div>
                                    </div></form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalCancelarPermanente" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                                        <h4 class="modal-title c-negro"> Bloquear la clase permanentemente <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                                    </div>
                                    <form name="cancelar_permanentemente" id="cancelar_permanentemente"  >
                                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                       <input type="hidden" name="id" id="id" value="{{$id}}"></input>  
                                       
                                       <div class="modal-body">  

                                       <div class="row p-t-20 p-b-0">

                                           <div class="col-sm-3">
  
                                                <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                                <div class="clearfix p-b-15"></div>
    
                                                <span class="f-15 f-700 span_instructor">{{$clasegrupal->instructor_nombre}} {{$clasegrupal->instructor_apellido}}  </span>

                                                  
                                           </div>

                                           <div class="col-sm-3">
  
                                                <span class="f-15 f-700">{{$clasegrupal->clase_grupal_nombre}}</span>

                                                  
                                           </div>

                                           <div class="col-sm-6">
                                             
                                            <p class="f-16"> <span class="f-700 span_hora">Horario: {{$clasegrupal->hora_inicio}} - {{$clasegrupal->hora_final}}</span></p>


                                               <div class="clearfix"></div> 
                                               <div class="clearfix p-b-15"></div>


                                           </div>

                                           
                                       </div>                         

                                       <div class="row p-t-20 p-b-0">

                     

                               <div class="clearfix p-b-35"></div>


            

                                      <div class="col-sm-12">
                                 
                                        <label for="razon_cancelacion" id="id-razon_cancelacion">Razones del bloqueo</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica las razones por el cual estás cancelando o bloqueando la clase" title="" data-original-title="Ayuda"></i>
                                        <br></br>

                                        <div class="fg-line">
                                          <textarea class="form-control" id="razon_cancelacion" name="razon_cancelacion" rows="2" placeholder="Ej. No podré  asistir por razones ajenas a mi voluntad"></textarea>
                                          </div>
                                        <div class="has-error" id="error-razon_cancelacion">
                                          <span >
                                            <small class="help-block error-span" id="error-razon_cancelacion_mensaje" ></small>                                           
                                          </span>
                                        </div>
                                      </div>

                                      <div class="col-sm-12">
                                       <div class="form-group fg-line ">
                                          <label for="">Mostrar bloqueo en la web</label id="id-boolean_mostrar"> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona si los clientes e instructores podrán ver el bloqueo de la clase en el calendario de actividades" title="" data-original-title="Ayuda"></i>
                                          
                                          <br></br>
                                          <input type="text" class="boolean_mostrar" id="boolean_mostrar" name="boolean_mostrar" value="" hidden="hidden">
                                          <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input class ="mostrar" id="mostrar" type="checkbox">
                                            
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                          </div>
                                          
                                       </div>
                                       <div class="has-error" id="error-boolean_mostrar">
                                            <span >
                                                <small class="help-block error-span" id="error-boolean_mostrar_mensaje" ></small>                                           
                                            </span>
                                        </div>
                                     </div>

                                       </div>
                                       
                                    </div>
                                    <div class="modal-footer p-b-20 m-b-20">
                                        <div class="col-sm-6 text-left">
                                          <div class="procesando hidden">
                                          <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                                          <div class="preloader pls-purple">
                                              <svg class="pl-circular" viewBox="25 25 50 50">
                                                  <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                              </svg>
                                          </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-6">                          
                                          <button type="button" class="btn-blanco btn m-r-10 f-16 cancelar_permanentemente" > Completar el bloqueo</button>
                                          <button type="button" class="cancelar btn btn-default" data-dismiss="modal">Volver</button>
                                        </div>
                                    </div></form>
                                </div>
                            </div>
                        </div>

            <a data-toggle="modal" href="#modalCancelar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/agendar/clases-grupales/detalle/{{$id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            
                        </ul>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">

                            <span class="f-16 p-t-0 text-success">Cancelar una clase<i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span>

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-clases-grupales p-r-5"></i> Clase: {{$clasegrupal->nombre}}</p>
                            <hr class="linea-morada">                                                          
                        </div>

                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="fecha_inicio" data-order="desc">Fecha Inicio</th>
                                    <th class="text-center" data-column-id="fecha_final" data-order="desc">Fecha Final</th>
                                    <th class="text-center" data-column-id="costo" data-order="desc">Mostrar en la Web</th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" >Operaciones</th>
                                    
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($canceladas as $cancelada)
                                <?php $id = $cancelada->id; ?>
                                <tr id="{{$id}}" class="seleccion">
                                    <td class="text-center previa">{{$cancelada->fecha_inicio}}</td>
                                    <td class="text-center previa">{{$cancelada->fecha_final}}</td>
                                    <td class="text-center previa">
                                      @if($cancelada->boolean_mostrar)
                                        Si
                                      @else
                                        No
                                      @endif
                                    </td>
                                    <td class="text-center disabled"> <i name="eliminar" id={{$id}} class="zmdi zmdi-delete boton red f-20 p-r-10 pointer acciones"></i></td>
                             
                                </tr>
                            @endforeach  
                                                           
                            </tbody>
                        </table>
                         </div>
                        </div>
                        <div class="card-body p-b-20">
                            <div class="row">
                              <div class="container">
                                
                              </div>
                            </div>
                        </div>
                        
                        
                    </div>
                    
                    
                </div>
            </section>
@stop

@section('js') 
            
  <script type="text/javascript">

    route_principal="{{url('/')}}/agendar";
    route_cancelar="{{url('/')}}/agendar/clases-grupales/cancelar";
    route_eliminar="{{url('/')}}/agendar/clases-grupales/eliminar-cancelacion/";

    $(document).ready(function(){

      if("{{$fecha_inicio}}"){
        setTimeout(function(){ 
          $('#modalCancelarUna').modal('show');
        }, 2000); 
      }

      $('#fecha2').daterangepicker({
          "autoApply" : false,
          "opens": "left",
          "applyClass": "bgm-morado waves-effect",
          locale : {
              format: 'DD/MM/YYYY',
              applyLabel : 'Aplicar',
              cancelLabel : 'Cancelar',
              daysOfWeek : [
                  "Dom",
                  "Lun",
                  "Mar",
                  "Mie",
                  "Jue",
                  "Vie",
                  "Sab"
              ],
              monthNames: [
                  "Enero",
                  "Febrero",
                  "Marzo",
                  "Abril",
                  "Mayo",
                  "Junio",
                  "Julio",
                  "Agosto",
                  "Septiembre",
                  "Octubre",
                  "Noviembre",
                  "Diciembre"
              ],        
          }
      });


      t=$('#tablelistar').DataTable({
      processing: true,
      serverSide: false,
      pageLength: 25,    
      order: [[0, 'asc']],
      fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
        $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
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
    });

    $('#tablelistar tbody').on( 'click', 'i.zmdi-delete boton red', function () {
      var id = $(this).closest('tr').attr('id');
      element = this;
      swal({   
          title: "Desea eliminar la cancelación?",   
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
          var nTitle="Ups! ";
          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";

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

          swal("Hecho!","Eliminado con éxito!","success");

          t.row( $(element).parents('tr') )
            .remove()
            .draw();
          finprocesado();

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

    $(".cancelar_una_clase").click(function(){


        fecha_inicio = $('#fecha_cancelacion').val();

        swal({   
                    title: "Desea bloquear la clase el dia "+fecha_inicio,   
                    text: "Confirmar bloqueo!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Confirmar bloqueo!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
          if (isConfirm) {
          procesando();
          var route = route_cancelar;
          var token = '{{ csrf_token() }}';
          var datos = $( "#cancelar_una_clase" ).serialize(); 
          $.ajax({
            url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
            dataType: 'json',
            data:datos+"&tipo=1",
            success:function(respuesta){
               setTimeout(function(){ 

                var nFrom = $(this).attr('data-from');
                var nAlign = $(this).attr('data-align');
                var nIcons = $(this).attr('data-icon');
                var nAnimIn = "animated flipInY";
                var nAnimOut = "animated flipOutY"; 

                $("#cancelar_una_clase")[0].reset();

                var nType = 'success';
                var nTitle="Ups! ";
                var nMensaje=respuesta.mensaje;

                if(respuesta.cancelada.boolean_mostrar){
                  boolean_mostrar = 'Si'
                }else{
                  boolean_mostrar = 'No'
                }

                var rowId=respuesta.cancelada.id;

                var rowNode=t.row.add( [
                ''+respuesta.fecha_inicio+'',
                ''+respuesta.fecha_final+'',
                ''+boolean_mostrar+'',
                '<i name="eliminar" id={{$id}} class="zmdi zmdi-delete boton red f-20 p-r-10 pointer acciones"></i>'
                ] ).draw(false).node();
                $( rowNode )
                .attr('id',rowId)
                .addClass('seleccion');

                $('.modal').modal('hide');

                finprocesado();

                window.location = route_principal;
                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
              }, 1000);

            },
            error:function(msj){

            setTimeout(function(){ 
              if (typeof msj.responseJSON === "undefined") {
                window.location = "{{url('/')}}/error";
              }
              var nType = 'danger';
              if(msj.responseJSON.status=="ERROR"){
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
               });
              }
            });
          });

      $(".cancelar_varias_clases").click(function(){
    
         swal({   
                    title: "Desea bloquear la clase desde el " + $('#fecha2').val(),   
                    text: "Confirmar bloqueo!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Confirmar bloqueo!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
          if (isConfirm) {
          procesando();
         var route = route_cancelar;
         var token = '{{ csrf_token() }}';
         var datos = $( "#cancelar_varias_clases" ).serialize(); 
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    data:datos+"&tipo=2",
                    success:function(respuesta){
                     setTimeout(function(){ 

                      var nFrom = $(this).attr('data-from');
                      var nAlign = $(this).attr('data-align');
                      var nIcons = $(this).attr('data-icon');
                      var nAnimIn = "animated flipInY";
                      var nAnimOut = "animated flipOutY"; 

                      $("#cancelar_una_clase")[0].reset();

                      var nType = 'success';
                      var nTitle="Ups! ";
                      var nMensaje=respuesta.mensaje;

                      if(respuesta.cancelada.boolean_mostrar){
                        boolean_mostrar = 'Si'
                      }else{
                        boolean_mostrar = 'No'
                      }

                      var rowId=respuesta.cancelada.id;

                      var rowNode=t.row.add( [
                      ''+respuesta.fecha_inicio+'',
                      ''+respuesta.fecha_final+'',
                      ''+boolean_mostrar+'',
                      '<i name="eliminar" id={{$id}} class="zmdi zmdi-delete boton red f-20 p-r-10 pointer acciones"></i>'
                      ] ).draw(false).node();
                      $( rowNode )
                      .attr('id',rowId)
                      .addClass('seleccion');

                      $('.modal').modal('hide');

                      finprocesado();
                      window.location = route_principal; 

                      notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                    }, 1000);

                  },
                  error:function(msj){

                    setTimeout(function(){ 
                    if (typeof msj.responseJSON === "undefined") {
                      window.location = "{{url('/')}}/error";
                    }
                    var nType = 'danger';
                    if(msj.responseJSON.status=="ERROR"){
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
         });
        }
      });
    });

      $(".cancelar_permanentemente").click(function(){
    
         swal({   
                    title: "Desea bloquear la clase permanentemente",   
                    text: "Confirmar bloqueo!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Confirmar bloqueo!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
          if (isConfirm) {
          procesando();
         var route = route_cancelar;
         var token = '{{ csrf_token() }}';
         var datos = $( "#cancelar_varias_clases" ).serialize(); 
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    data:datos+"&tipo=3",
                    success:function(respuesta){

                      window.location = route_principal;

                    },
                    error:function(msj){

                    setTimeout(function(){ 
                    if (typeof msj.responseJSON === "undefined") {
                      window.location = "{{url('/')}}/error";
                    }
                    var nType = 'danger';
                    if(msj.responseJSON.status=="ERROR"){
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
         });
        }
      });
    });

    $(".boolean_mostrar").val('1');  //VALOR POR DEFECTO
    $(".mostrar").attr("checked", true); //VALOR POR DEFECTO

    $(".mostrar").on('change', function(){
      if ($(this).is(":checked")){
        $(".boolean_mostrar").val('1');
      }else{
        $(".boolean_mostrar").val('0');
      }    
    });

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

      // $('html,body').animate({
      //       scrollTop: $("#id-"+elemento).offset().top-90,
      // }, 1500);          

  }

  </script>
@stop