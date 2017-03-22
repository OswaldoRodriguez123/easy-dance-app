@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/easy_dance_ico_5.css" rel="stylesheet">

@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
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
                                       <input type="hidden" name="id" id="id"></input>  
                                       
                                       <div class="modal-body">  

                                       <div class="row p-t-20 p-b-0">

                                           <div class="col-sm-3">
  
                                                <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                                <div class="clearfix p-b-15"></div>
    
                                                <span class="f-15 f-700 span_instructor"></span>

                                                  
                                           </div>

                                           <div class="col-sm-3">
  
                                                <span class="f-15 f-700"></span>

                                                  
                                           </div>

                                           <div class="col-sm-6">
                                             
                                            <p class="f-16"> <span class="f-700 span_hora">Horario: </span></p>

                                            <p class="f-16"> <span class="f-700 span_hora" style="float:left; padding-top: 0.5%">Fecha: 

                                            @if($fecha_inicio)

                                              <input type="hidden" name="fecha_cancelacion" id="fecha_cancelacion" value="{{$fecha_inicio}}"></input>  

                                              {{$fecha_inicio}}

                                            @else

                                              <div class="dtp-container">
                                                <input name="fecha_cancelacion" id="fecha_cancelacion" class="form-control date-picker proceso pointer" placeholder="Seleciona" type="text" style="padding-top: 0; width: 85%">
                                              </div>

                                            @endif



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
                                          <input type="text" id="boolean_mostrar" name="boolean_mostrar" value="" hidden="hidden">
                                          <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="mostrar" type="checkbox">
                                            
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
                                       <input type="hidden" name="id" id="id"></input>  
                                       
                                       <div class="modal-body">  

                                       <div class="row p-t-20 p-b-0">

                                           <div class="col-sm-3">
  
                                                <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                                <div class="clearfix p-b-15"></div>
    
                                                <span class="f-15 f-700 span_instructor"></span>

                                                  
                                           </div>

                                           <div class="col-sm-3">
  
                                                <span class="f-15 f-700 span_clase_grupal"></span>

                                                  
                                           </div>

                                           <div class="col-sm-6">
                                             
                                            <p class="f-16"> <span class="f-700 span_hora">Horario: </span></p>


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
                                          <input type="text" id="boolean_mostrar" name="boolean_mostrar" value="" hidden="hidden">
                                          <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="mostrar" type="checkbox">
                                            
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
                                       <input type="hidden" name="id" id="id"></input>  
                                       
                                       <div class="modal-body">  

                                       <div class="row p-t-20 p-b-0">

                                           <div class="col-sm-3">
  
                                                <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                                <div class="clearfix p-b-15"></div>
    
                                                <span class="f-15 f-700 span_instructor"></span>

                                                  
                                           </div>

                                           <div class="col-sm-3">
  
                                                <span class="f-15 f-700 span_clase_grupal"></span>

                                                  
                                           </div>

                                           <div class="col-sm-6">
                                             
                                            <p class="f-16"> <span class="f-700 span_hora">Horario:</span></p>


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
                                          <input type="text" id="boolean_mostrar" name="boolean_mostrar" value="" hidden="hidden">
                                          <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="mostrar" type="checkbox">
                                            
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




<a href="{{url('/')}}/agendar/clases-grupales/agregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menu Principal</a>
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-reservaciones f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            
                        </ul>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header">

                            <div class="col-sm-6">
                                <i class="zmdi zmdi-label-alt f-25 c-verde"></i> Activos: {{$activos}} 
                                <div class="clearfix"></div>
                                <i class="zmdi zmdi-label-alt f-25 c-amarillo"></i> Riesgo de Ausencial: {{$riesgo}} 
                                <div class="clearfix"></div>
                                Total: {{$activos + $riesgo}}
                            </div>

                            <div class="col-sm-6 text-right">
                                <span class="f-16 p-t-0 text-success">Agregar una Clase Grupal <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span> 
                            </div>

                            <div class="clearfix"></div>

                            <div class="text-center">
                                <p class="opaco-0-8 f-22"><i class="icon_a-clases-grupales f-25"></i> Sección de Clases Grupales</p>

                                <hr class="linea-morada"> 

                                <button class="btn btn-blanco button_izquierda" style="border:none; box-shadow: none"><i class="zmdi zmdi-chevron-left zmdi-hc-fw f-20"></i></button> <span class="span_dia f-20 c-morado">LUNES</span> <button class="btn btn-blanco button_derecha" style="border:none; box-shadow: none"><i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i></button>

                                <div class="clearfix"></div>

                                <button class="no_border_button btn btn-blanco button_dia" value="1">Lun</button> &nbsp; 
                                <button class="btn btn-blanco button_dia no_border_button" value="2">Mar</button> &nbsp; 
                                <button class="btn btn-blanco button_dia no_border_button" value="3">Mier</button> &nbsp; 
                                <button class="btn btn-blanco button_dia no_border_button" value="4">Juev</button> &nbsp; 
                                <button class="btn btn-blanco button_dia no_border_button" value="5">Vier</button> &nbsp; 
                                <button class="btn btn-blanco button_dia no_border_button" value="6">Sab</button> &nbsp; 
                                <button class="btn btn-blanco button_dia no_border_button" value="7">Dom</button>

                            </div>                                                   
                        </div>

                        @if($clase_grupal_join)
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <!--<th class="text-center" data-column-id="id" data-type="numeric">Id</th>
                                    <th class="text-center" data-column-id="sexo">Sexo</th>-->
                                    <th class="text-center" data-column-id="inicio" data-order="desc"></th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                    <th class="text-center" data-column-id="instructor" data-order="desc">Instructor</th>
                                    <th class="text-center" data-column-id="especialidad" data-order="desc">Especialidad</th>
                                    <th class="text-center" data-column-id="hora" data-order="desc">Hora [Inicio - Final]</th>
                                    <!--<th class="text-center" data-column-id="estatu_c" data-order="desc">Estatus C</th>
                                    <th class="text-center" data-column-id="estatu_e" data-order="desc">Estatus E</th>-->
                                    <th class="text-center operacion" data-column-id="operacion" data-order="desc">Operaciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                                                           
                            </tbody>
                        </table>
                         </div>
                        </div>

                        @else

                               <div class="col-sm-10 col-sm-offset-1 error_general" style="padding-bottom: 300px">


                                  <div align="center"><i class="zmdi zmdi-mood-bad zmdi-hc-5x c-morado"></i></div>
                                  <div class="c-morado f-30 text-center"> Ups! lo sentimos, la academia <b>{{$academia->nombre}}</b> actualmente no ha registrado clases grupales. </div>


                             </div>




                            @endif
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

        route_detalle="{{url('/')}}/agendar/clases-grupales/detalle";
        route_operacion="{{url('/')}}/agendar/clases-grupales/operaciones";
        route_progreso="{{url('/')}}/agendar/clases-grupales/progreso";
        route_participantes="{{url('/')}}/agendar/clases-grupales/participantes";
        route_cancelar="{{url('/')}}/agendar/clases-grupales/cancelar";
        route_principal="{{url('/')}}/agendar/clases-grupales";

        var i;
        var hoy;

        $(document).ready(function(){

        i = parseInt("{{$hoy}}");
        hoy = i;
        
        $(".button_izquierda").removeAttr("disabled");
        $(".button_derecha").removeAttr("disabled");


        if( i == 1){
            $(".button_izquierda").attr("disabled","disabled");
        }

        if( i == 7){
            $(".button_derecha").attr("disabled","disabled");
        }

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,   
        order: [[3, 'asc']],
       fnDrawCallback: function() {
        // if ("{{count($clase_grupal_join)}}" < 25) {
        //       $('.dataTables_paginate').hide();
        //       $('#tablelistar_length').hide();
        //   }else{
        //      $('.dataTables_paginate').show();
        //   }
        },
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).attr( "onclick","previa(this)" );
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

                changeSpan();

            });

        $(".button_izquierda").click(function(){

            $(".button_derecha").removeAttr("disabled");

            i = i - 1;

            if( i <= 1){
                $(".button_izquierda").attr("disabled","disabled");
            }else{
                $(".button_izquierda").removeAttr("disabled");
            }
            changeSpan();
        });

        $(".button_derecha").click(function(){

            $(".button_izquierda").removeAttr("disabled");

            i = i + 1;

            if( i >= 7){
                $(".button_derecha").attr("disabled","disabled");
            }else{
                $(".button_derecha").removeAttr("disabled");
            }
            changeSpan();
        });

        $('.button_dia').click(function(){
            i = parseInt($(this).val());

            if( i >= 7){
                $(".button_derecha").attr("disabled","disabled");
            }else{
                $(".button_derecha").removeAttr("disabled");
            }

            if( i <= 1){
                $(".button_izquierda").attr("disabled","disabled");
            }else{
                $(".button_izquierda").removeAttr("disabled");
            }

            changeSpan();

         });

        function changeSpan(){

            if(i == hoy){
                $('.span_dia').text('HOY');
            }
            
            else if(i == 1){

                $('.span_dia').text('LUNES');

            }else if(i == 2){

                $('.span_dia').text('MARTES');

            }else if(i == 3){

                $('.span_dia').text('MIERCOLES');

            }else if(i == 4){

                $('.span_dia').text('JUEVES');

            }else if(i == 5){

                $('.span_dia').text('VIERNES');

            }else if(i == 6){

                $('.span_dia').text('SABADO');

            }else if(i == 7){

                $('.span_dia').text('DOMINGO');

            }

            $(".button_dia").removeAttr("style")

            $(".button_dia[value='"+i+"']").css("background-color", "#2196F3");
            $(".button_dia[value='"+i+"']").css("color", "white");

            rechargeClase();

        }


        function rechargeClase(){

            t.clear().draw();

            var clase_grupal = [];
            var clases_grupales = <?php echo json_encode($clase_grupal_join);?>;

             $.each(clases_grupales, function (index, array) {
                if(i == array.dia_de_semana){
                    clase_grupal.push(array);
                }
                
            });

            var pagina = document.location.origin

            $.each(clase_grupal, function (index, array) {

                    operacion = ''
                    if(array.inicio == 0){
                        inicio = '<i class="zmdi zmdi-star zmdi-hc-fw zmdi-hc-fw c-amarillo f-20" data-html="true" data-original-title="" data-content="Esta clase grupal no ha comenzado" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>'
                    }else{
                        inicio = '';
                    }

                    operacion += '<ul class="top-menu">'
                    operacion += '<li class="dropdown">' 
                    operacion += '<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft">' 
                    operacion += '<span class="f-15 f-700" style="color:black">'
                    operacion += '<i class="zmdi zmdi-wrench f-20 mousedefault" data-toggle="popover" data-placement="top" title="" type="button" data-original-title="" data-content=""></i>'
                    operacion += '</span></a>'
                    operacion += '<div class="dropup">'
                    operacion += '<ul class="dropdown-menu dm-icon pull-right" style="position:absolute;">'
                    operacion += '<li class="hidden-xs">'
                    operacion += '<a onclick="procesando()" href="'+pagina+'/agendar/clases-grupales/nivelaciones/'+array.id+'">'
                    operacion += '<i class="icon_a-niveles f-16 m-r-10 boton blue"></i>'
                    operacion += '&nbsp;Nivelaciones'
                    operacion += '</a></li>'
                    operacion += '<li class="hidden-xs">'
                    operacion += '<a onclick="procesando()" href="'+pagina+'/agendar/clases-grupales/participantes/'+array.id+'">'
                    operacion += '<i class="icon_a-participantes f-16 m-r-10 boton blue"></i>'
                    operacion += 'Participantes'
                    operacion += '</a></li>'
                    operacion += '<li class="hidden-xs">'
                    operacion += '<a onclick="procesando()" href="'+pagina+'/especiales/examenes/agregar/'+array.id+'">'
                    operacion += '<i class="icon_a-examen f-16 m-r-10 boton blue"></i>'
                    operacion += 'Valorar'
                    operacion += '</a></li>'
                    operacion += '<li class="hidden-xs">'
                    operacion += '<a onclick="procesando()" href="'+pagina+'/agendar/clases-grupales/agenda/'+array.id+'">'
                    operacion += '<i class="zmdi zmdi-eye f-16 boton blue"></i>'
                    operacion += 'Ver Agenda'
                    operacion += '</a></li>'
                    operacion += '<li class="hidden-xs"> <a onclick="procesando()" href="'+pagina+'/agendar/clases-grupales/multihorario/'+array.id+'">'
                    operacion += '<i class="zmdi zmdi-calendar-note f-16 boton blue"></i>'
                    operacion += 'Multihorario'
                    operacion += '</a></li>'
                    operacion += '<li class="hidden-xs"> <a onclick="procesando()" href="'+pagina+'/agendar/clases-grupales/progreso/'+array.id+'">'
                    operacion += '<i class="icon_e-ver-progreso f-16 m-r-10 boton blue"></i>' 
                    operacion += 'Ver Progreso'
                    operacion += '</a></li>'
                    operacion += '<li class="hidden-xs"><a class="pointer cancelado">'
                    operacion += '<i class="zmdi zmdi-close-circle-o f-20 boton red sa-warning"></i>'
                    operacion += 'Cancelar Clase'
                    operacion += '</a></li>'
                    operacion += '</ul></div></li></ul>'
       
                    var rowNode=t.row.add( [
                    ''+inicio+'',
                    ''+array.clase_grupal_nombre+'',
                    ''+array.instructor_nombre+ ' ' +array.instructor_apellido+ '',
                    ''+array.especialidad_nombre+'',
                    ''+array.hora_inicio+ ' '+array.hora_final+'',
                    ''+operacion+''
                    ] ).draw(false).node();
                    $( rowNode )
                        .attr('id',array.id)
                        .addClass('seleccion');
                });
        }

    function previa(t){
        var row = $(t).closest('tr').attr('id');

        id_alumno = "{{Session::get('id_alumno')}}";
        if(!id_alumno){
            var route =route_detalle+"/"+row;
        }
        else{
            var route =route_participantes+"/"+row;
        }
        
        window.location=route;
      }

 

    // $('#tablelistar tbody').on( 'hover', 'a.dropdown-toggle', function () {
    //     console.log('entro')

    //   if($('.dropdown').hasClass('open')){

    //   }else{
    //     $( this ).click();
    //   }
     
    // });


     $(".cancelar_una_clase").click(function(){
    
         swal({   
                    title: "Desea bloquear la clase el dia {{$fecha_inicio}}",   
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

                        window.location=route_principal; 

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

                        window.location=route_principal; 

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

                        window.location=route_principal; 

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

  $('#tablelistar tbody').on( 'click', 'a.cancelado', function () {
    var id = $(this).closest('tr').attr('id');
    $('input[name=id]').val(id)
    $('#modalCancelar').modal('show')
  });

    $('#tablelistar tbody').on( 'mouseenter', 'i.zmdi-wrench', function () {

      if($('.dropdown').hasClass('open')){

      }else{
        $( this ).click();
      }
     
    });

    $('.table-responsive').on('show.bs.dropdown', function () {
      $('.table-responsive').css( "overflow", "inherit" );
    });

    $('.table-responsive').on('hide.bs.dropdown', function () {
      $('.table-responsive').css( "overflow", "auto" );
    })

    </script>
@stop