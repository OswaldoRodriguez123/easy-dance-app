@extends('layout.master')

@section('css_vendor')

<link href="{{url('/')}}/assets/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/easy_dance_ico_5.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">



@stop

@section('js_vendor')

<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/moment.min.js"></script>
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
  
                                                <span class="f-15 f-700">{{$clasegrupal->nombre}}</span>

                                                  
                                           </div>

                                           <div class="col-sm-6">
                                             
                                            <p class="f-16"> <span class="f-700 span_hora">Horario: {{$clasegrupal->hora_inicio}} - {{$clasegrupal->hora_final}}</span></p>

                                            <p class="f-16"> <span class="f-700 span_hora" style="float:left; padding-top: 0.5%">Fecha: 

                                            @if($fecha_inicio)

                                              <input type="hidden" name="fecha" id="fecha" value="{{$fecha_inicio}}"></input>  

                                              {{$fecha_inicio}}

                                            @else

                                              <div class="dtp-container">
                                                <input name="fecha" id="fecha" class="form-control date-picker proceso pointer" placeholder="Seleciona" type="text" style="padding-top: 0; width: 85%">
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
                                       <input type="hidden" name="id" id="id" value="{{$id}}"></input>  
                                       
                                       <div class="modal-body">  

                                       <div class="row p-t-20 p-b-0">

                                           <div class="col-sm-3">
  
                                                <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                                <div class="clearfix p-b-15"></div>
    
                                                <span class="f-15 f-700 span_instructor">{{$clasegrupal->instructor_nombre}} {{$clasegrupal->instructor_apellido}}  </span>

                                                  
                                           </div>

                                           <div class="col-sm-3">
  
                                                <span class="f-15 f-700">{{$clasegrupal->nombre}}</span>

                                                  
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
                                       <input type="hidden" name="id" id="id" value="{{$id}}"></input>  
                                       
                                       <div class="modal-body">  

                                       <div class="row p-t-20 p-b-0">

                                           <div class="col-sm-3">
  
                                                <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                                <div class="clearfix p-b-15"></div>
    
                                                <span class="f-15 f-700 span_instructor">{{$clasegrupal->instructor_nombre}} {{$clasegrupal->instructor_apellido}}  </span>

                                                  
                                           </div>

                                           <div class="col-sm-3">
  
                                                <span class="f-15 f-700">{{$clasegrupal->nombre}}</span>

                                                  
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


<div class="modal fade" id="modalTrasladar-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
            </div>
            <form name="form_trasladar" id="form_trasladar"  >
               <input type="hidden" name="_token" value="{{ csrf_token() }}">
               <div class="modal-body">                           
               <div class="row p-t-20 p-b-0">
                   <div class="col-sm-12">
                     <div class="form-group fg-line">
                        <label for="nombre">Clases Grupales</label>

                          <div class="select">
                              <select class="form-control" id="clasegrupal_id" name="clasegrupal_id">
                              @foreach ( $grupales as $grupal )
                              <option value = "{{ $grupal['id'] }}">{{ $grupal['nombre'] }} - {{ $grupal['hora_inicio'] }} / {{ $grupal['hora_final'] }} - {{ $grupal['dia_de_semana'] }} - {{ $grupal['instructor'] }} - {{ $grupal['especialidad'] }}</option>
                              @endforeach 
                              </select>
                          </div> 

                     </div>
                     <div class="has-error" id="error-clasegrupal_id">
                          <span >
                              <small class="help-block error-span" id="error-clasegrupal_id_mensaje" ></small>                                
                          </span>
                      </div>
                   </div>


                   <input type="hidden" name="id" value="{{$id}}"></input>
                

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

                  <a class="btn-blanco m-r-5 f-12 trasladar" href="#">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                </div>
            </div></form>
        </div>
    </div>
</div>

<section id="content">
        <div class="container">
           <div class="block-header">
                <div class="col-sm-6">
                <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/agendar/clases-grupales"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección clase grupal</a>
                </div>
                <div class="col-sm-6 text-right">
                <a class="btn-blanco m-r-10 f-16" style="text-align: right" href="{{url('/')}}/agendar/clases-grupales/detalle/{{$id}}"> Vista Previa <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>
                </div>
            </div> 

            <br>
            
            <h4 class ="c-morado text-right">Clase Grupal: {{$clasegrupal->nombre}}</h4> 
            <br><br><h1 class="text-center c-morado"><i class="zmdi zmdi-wrench p-r-5"></i> Sección de Operaciones</h1>
            <hr class="linea-morada">
            <br>
            <div class="card-body p-b-20">
            <div>

            <div class = "col-sm-2"></div>

			<ul class="ca-menu-c col-sm-8" style="width: 720px;">

                <li data-ripplecator class ="dark-ripples">
                        <a data-toggle="modal" href="#modalTrasladar-ClaseGrupal">
                            <span class="ca-icon-c"><i class="zmdi zmdi-trending-up f-35 boton blue sa-warning" data-original-title="Trasladar" type="button" data-toggle="tooltip" data-placement="bottom" title=""></i></span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c f-20">Trasladar</h2>
                                <h3 class="ca-sub-c"></h3>
                            </div>
                        </a>
                </li>

                <li data-ripplecator class ="dark-ripples">
                        <a class="multihorario">
                            <span class="ca-icon-c"><i class="zmdi zmdi-calendar-note f-35 boton blue sa-warning" data-original-title="Ver Multihorario" type="button" data-toggle="tooltip" data-placement="bottom" title=""></i></span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c f-20">Multihorario</h2>
                                <h3 class="ca-sub-c"></h3>
                            </div>
                        </a>
                </li>
        		<li data-ripplecator class ="dark-ripples">
                        <a class="participantes">
                            <span class="ca-icon-c"><i class="icon_a-participantes f-35 boton blue sa-warning" data-original-title="Ver Participantes" type="button" data-toggle="tooltip" data-placement="bottom" title=""></i></span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c f-20">Participantes</h2>
                                <h3 class="ca-sub-c"></h3>
                            </div>
                        </a>
                    </li>

                    <div class="clearfix"></div>

                    <li data-ripplecator class ="dark-ripples">
                        <a class = "progreso">
                            <span class="ca-icon-c"><i class="icon_e-ver-progreso f-35 boton blue sa-warning" 
                                   data-original-title="Progreso" data-toggle="tooltip" data-placement="bottom" title=""></i></span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c">Ver Progreso</h2>
                                <h3 class="ca-sub-c"></h3>
                            </div>
                        </a>
                    </li>

                    <li data-ripplecator class ="dark-ripples">
                        <a class = "valorar">
                            <span class="ca-icon-c"><i class="icon_a-examen f-35 boton blue sa-warning" 
                                   data-original-title="Valorar" data-toggle="tooltip" data-placement="bottom" title=""></i></span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c">Valorar</h2>
                                <h3 class="ca-sub-c"></h3>
                            </div>
                        </a>
                    </li>

                    <li data-ripplecator class ="dark-ripples">
                        <a data-toggle="modal" href="#modalCancelar">
                            <span class="ca-icon-c"><i  class="zmdi zmdi-close-circle-o f-35 boton red sa-warning" name="eliminar" id="{{$id}}" data-original-title="Cancelar Clase" data-toggle="tooltip" data-placement="bottom" title=""  ></i></span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c">Cancelar Clase</h2>
                                <h3 class="ca-sub-c"></h3>
                            </div>
                        </a>
                    </li>

                    <!--<li>
                        <a href="#">
                            <span class="ca-icon-c">A</span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c">Exceptional Service</h2>
                                <h3 class="ca-sub-c">Personalized to your needs</h3>
                            </div>
                        </a>
                    </li>-->
                    


                    
                </ul>

                <div class = "col-sm-1"></div>
                
                </div>
            </div>
        </div>
</section>
@stop
@section('js') 
	<script type="text/javascript">

    route_eliminar="{{url('/')}}/agendar/clases-grupales/eliminar/";
    route_principal="{{url('/')}}/agendar/clases-grupales";
    route_trasladar="{{url('/')}}/agendar/clases-grupales/trasladar";
    route_cancelar="{{url('/')}}/agendar/clases-grupales/cancelar";
    route_valorar="{{url('/')}}/especiales/examenes/agregar";

    $(document).ready(function(){

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

      $("#boolean_mostrar").val('1');  //VALOR POR DEFECTO
      $("#mostrar").attr("checked", true); //VALOR POR DEFECTO

      $("#mostrar").on('change', function(){
          if ($("#mostrar").is(":checked")){
            $("#boolean_mostrar").val('1');
          }else{
            $("#boolean_mostrar").val('0');
          }    
        });


        $('body,html').animate({scrollTop : 0}, 500);
        var animation = 'fadeInUpBig';
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
		function setAnimation(animation, target) {
             $('#'+target).addClass(animation);

            setTimeout(function(){
              $('#'+target).removeClass(animation);
            }, 2000); 

            console.log("entro");
  }

  function setAnimationRapido(animation, target) {
             $('#'+target).addClass(animation);

            setTimeout(function(){
              $('#'+target).removeClass(animation);
            }, 500); 
  }

  $(".multihorario").click(function(){
               
    window.location = "{{url('/')}}/agendar/clases-grupales/multihorario/{{$id}}";

  });

  $(".participantes").click(function(){
               
    window.location = "{{url('/')}}/agendar/clases-grupales/participantes/{{$id}}";

    });

  $(".progreso").click(function(){
               
    window.location = "{{url('/')}}/agendar/clases-grupales/progreso/{{$id}}";

    });

  $(".valorar").click(function(){
               
    window.location = "{{url('/')}}/especiales/examenes/agregar/{{$id}}";

    });

  $(".eliminar").click(function(){
                console.log(this.id);
                id = this.id;
                swal({   
                    title: "Desea eliminar la clase grupal?",   
                    text: "Confirmar eliminación!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Eliminar!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: false 
                }, function(isConfirm){   
          if (isConfirm) {
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nType = 'success';
            var nAnimIn = $(this).attr('data-animation-in');
            var nAnimOut = $(this).attr('data-animation-out')
                        // swal("Done!","It was succesfully deleted!","success");
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
                        eliminar(id);
          }
                });
            });
      function eliminar(id){
         var route = route_eliminar + "{{$id}}";
         var token = '{{ csrf_token() }}';
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'DELETE',
                    dataType: 'json',
                    data:id,
                    success:function(respuesta){

                        window.location=route_principal; 

                    },
                    error:function(msj){
                                // $("#msj-danger").fadeIn(); 
                                // var text="";
                                // console.log(msj);
                                // var merror=msj.responseJSON;
                                // text += " <i class='glyphicon glyphicon-remove'></i> Por favor verifique los datos introducidos<br>";
                                // $("#msj-error").html(text);
                                // setTimeout(function(){
                                //          $("#msj-danger").fadeOut();
                                //         }, 3000);
                                //         
                                swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                                }
                });
      }

      $(".trasladar").click(function(){
      id = this.id;
      swal({   
          title: "Desea trasladar todos los alumnos inscritos a la clase grupal seleccionada?",   
          text: "Tenga en cuenta que la otra clase grupal sera eliminada",   
          type: "warning",   
          showCancelButton: true,   
          confirmButtonColor: "#DD6B55",   
          confirmButtonText: "Trasladar!",  
          cancelButtonText: "Cancelar",         
          closeOnConfirm: false 
      }, function(isConfirm){   
          if (isConfirm) {
            $(".sweet-alert").hide();
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nType = 'success';
            var nAnimIn = $(this).attr('data-animation-in');
            var nAnimOut = $(this).attr('data-animation-out')
                      
            trasladar();
            }
        });
    });
      function trasladar(){
        var route = route_trasladar;
        var token = $('input:hidden[name=_token]').val();
        var datos = $( "#form_trasladar" ).serialize();

        procesando();
                
        $.ajax({
            url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
            dataType: 'json',
            data:datos,
            success:function(respuesta){

                window.location=route_principal; 

            },
            error:function (msj, ajaxOptions, thrownError){
              setTimeout(function(){ 
                // if (typeof msj.responseJSON === "undefined") {
                //           window.location = "{{url('/')}}/error";
                //         }
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
                  // if (typeof msj.responseJSON === "undefined") {
                  //           window.location = "{{url('/')}}/error";
                  //         }
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
                  // if (typeof msj.responseJSON === "undefined") {
                  //           window.location = "{{url('/')}}/error";
                  //         }
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
                  // if (typeof msj.responseJSON === "undefined") {
                  //           window.location = "{{url('/')}}/error";
                  //         }
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


  
  setAnimation('fadeInUp', 'content');
	</script>
@stop