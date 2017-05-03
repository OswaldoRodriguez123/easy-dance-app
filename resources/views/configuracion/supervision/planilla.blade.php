@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
@stop

@section('content')
   
            <div class="modal fade" id="modalSupervisor-Supervision" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Supervisión<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_supervisor_supervision" id="edit_supervisor_supervision"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="apellido">Supervisor</label>

                                      <div class="select">
                                        <select class="form-control selectpicker bs-select-hidden" data-live-search="true" id="supervisor_id" name="supervisor_id">

                                          @foreach ( $staffs as $staff )
                                            <?php $exist = false; ?>
                                              @if($supervision->tipo_staff == 1)
                                                @if ($supervision->staff_id == $staff->id)
                                                  <?php $exist = true; ?>
                                                @endif
                                              @endif
                                            @if ($exist)
                                                <option disabled data-icon = "glyphicon-remove" value = "{{ $staff->id }}">{{ $staff->nombre }} {{ $staff->apellido }}</option>
                                            @else
                                                <option value = "{{ $staff->id }}">{{ $staff->nombre }} {{ $staff->apellido }}</option>
                                            @endif
                                          @endforeach
                                        </select>
                                      </div> 
                                    </div>
                                    <div class="has-error" id="error-supervisor_id">
                                      <span >
                                          <small class="help-block error-span" id="error-supervisor_id_mensaje" ></small>                                           
                                      </span>
                                 </div>
                               </div>

                               <input type="hidden" name="id" id="id" value="{{$supervision->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_supervisor_supervision" data-update="supervisor" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <!-- END -->  

            <div class="modal fade" id="modalCargo-Supervision" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Supervisión<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_cargo_supervision" id="edit_cargo_supervision"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="apellido">Cargo a Supervisar</label>

                                      <div class="select">
                                        <select class="form-control selectpicker bs-select-hidden" data-live-search="true" id="cargo" name="cargo">
                                          @foreach ( $config_staff as $cargo )
              
                                            <option value = "{{ $cargo->id }}">{{ $cargo->nombre }}</option>
                              
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

                               <input type="hidden" name="id" id="id" value="{{$supervision->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_cargo_supervision" data-update="cargo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <!-- END -->  

            <div class="modal fade" id="modalStaff-Supervision" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Supervisión<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_staff_supervision" id="edit_staff_supervision"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="apellido">Staff a Supervisar</label>

                                      <div class="select">
                                        <select class="form-control selectpicker bs-select-hidden" data-live-search="true" id="staff_id" name="staff_id">
                                        @foreach ( $staffs_instructores as $staff_instructor )
                                          <?php 
                                            $exist = false; 
                                            $supervisor_id = $supervision->supervisor_id.'-'.'1';
                                            $id_a_comparar = $staff_instructor['id'].'-'.$staff_instructor['tipo'];

                                          ?>
                                            @if ($supervisor_id == $id_a_comparar)
                                              <?php $exist = true; ?>
                                            @endif
                                          @if($exist)
                                              <option disabled data-icon = "glyphicon-remove" value = "{{$staff_instructor['id']}}-{{$staff_instructor['tipo']}}">{{ $staff_instructor['nombre'] }} / {{ $staff_instructor['cargo'] }}</option>
                                          @else
                                              <option value = "{{$staff_instructor['id']}}-{{$staff_instructor['tipo']}}">{{ $staff_instructor['nombre'] }} / {{ $staff_instructor['cargo'] }}</option>
                                          @endif
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

                               <input type="hidden" name="id" id="id" value="{{$supervision->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_staff_supervision" data-update="staff" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <!-- END -->  
            

            <div class="modal fade" id="modalItems-Supervision" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title bg-gris-oscuro">Editar Supervisión<button type="button" data-dismiss="modal" class="close c-blanco f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_items_supervision" id="edit_items_supervision"  >
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" id="items_a_evaluar" name="items_a_evaluar" value="{{$supervision->items_a_evaluar}}">
                          <input type="hidden" name="id" id="id" value="{{$supervision->id}}"></input>
                        <div class="modal-body">
                          <div class="row p-l-10 p-r-10">
                            <div class="panel-body">

                              @foreach($config_supervision as $supervision)

                                <div class="cargo_{{$supervision->cargo_id}} supervisiones col-sm-6 m-b-20" style="display:none">

                                    <span class="f-15 f-700">

                                      @if(strlen($supervision->nombre) <= 20)

                                        {{$supervision->nombre}}

                                      @else
                                        {{ str_limit($supervision->nombre, $limit = 20, $end = '') }} <span class="mousedefault" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="{{$supervision->nombre}}" title="" data-original-title="Ayuda">... <span class="c-azul">Ver mas</span>
                                      @endif
   

                                    </span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                    <input type="text" id="supervision_{{$supervision->id}}" name="supervision_{{$supervision->id}}" value="" hidden="hidden">

                                    <div class="toggle-switch m-l-10" data-ts-color="purple" style="margin-top: 2px">

                                        <span class="p-r-10 f-700 f-15">No</span>

                                        <input class="supervision" id="switch2_{{$supervision->id}}" data-name="{{$supervision->nombre}}" type="checkbox" hidden="hidden">
                                      
                                        <label for="switch2_{{$supervision->id}}" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                    </div>

                                </div>

                              @endforeach


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
                              <div class="col-sm-12">                            

                                <a class="btn-blanco m-r-5 f-16 guardar" id="guardar" href="#" data-formulario="edit_items_supervision" data-update="items" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>
                              </div>
                            </div>

                          </div>
                      </div></form>
                    </div>
                  </div>
              </div>

                <div class="modal fade" id="modalFecha-Supervision" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Supervisión<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_fecha_supervision" id="edit_fecha_supervision"  >
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="id" id="id" value="{{$supervision->id}}"></input>

                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                    <label for="fecha_inicio">Rango de Fecha</label>
                                    <div class="fg-line">
                                        <input type="text" id="fecha" name="fecha" class="form-control pointer" placeholder="Selecciona la fecha">
                                    </div>
                                 </div>
                                    <div class="has-error" id="error-fecha">
                                      <span >
                                          <small id="error-fecha_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <div class="clearfix p-b-35"></div>
                     
                                    
                              <div class="col-sm-6">
                   
                                <label for="cargo" id="id-frecuencia">Frecuencia</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda" data-trigger="hover" data-toggle="popover" data-placement="bottom" data-content="Indícale al sistema la frecuencia de de las supervisiones" title="" data-original-title="Ayuda"></i>


                                <div class="fg-line">
                                  <div class="select">
                                    <select class="selectpicker bs-select-hidden" name="frecuencia" id="frecuencia" data-live-search="true" disabled>
                                      <option value="">Selecciona</option>
                                      <option value="1">Semanal</option>
                                      <option value="2">Quincenal</option>
                                      <option value="3">Mensual</option>  
                                    </select>
                                  </div>
                                </div>
                                <div class="has-error" id="error-frecuencia">
                                  <span >
                                    <small class="help-block error-span" id="error-frecuencia_mensaje" ></small>                                           
                                  </span>
                                </div>
                              </div>
                            
                             <div class="clearfix p-b-35"></div>

                              @foreach( $dias_de_semana as $dia)
                                <div class="col-sm-3">
                                  <input type="text" id="dia_{{$dia->id}}" name="dia_{{$dia->id}}" value="" hidden="hidden">

                                  <span class="f-20 f-700 p-r-10">{{$dia->nombre}}</span>
                                </div>

                                <div class="col-sm-9">
                                  <div class="toggle-switch" data-ts-color="purple">
                                    <span class="p-r-10 f-700 f-16">No</span>

                                    <input class="frecuencia" id="switch_{{$dia->id}}" data-name="switch_{{$dia->id}}" type="checkbox" hidden="hidden">

                                    <label for="switch_{{$dia->id}}" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>

                                  </div>
                                </div>

                                <div class="clearfix p-b-15"></div>

                              @endforeach
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_fecha_supervision" data-update="fecha" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                       <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/configuracion/supervisiones" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección de Supervisiones</a>
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
                            
                            
                      </div>
                      <div class="card-body p-b-20">
                        <div class="row">
                        <div class="container">
                         <div class="col-sm-3">
                            <div class="text-center p-t-30">       
                              <div class="row p-b-15 ">
                                <div class="col-md-12" data-src="/assets/img/ayuda-configuracion.jpg">
                                  <!--<div class="text-center">
                                    <img src="{{url('/')}}/assets/img/detalle_alumnos.jpg" class="img-responsive img-efecto text-center" alt="">
                                  </div>-->
                                  <ul class="ca-menu-planilla">
                                    <li>
                                        <a href="#" class="disabled">
                                            <span class="ca-icon-planilla"><i class="icon_a-examen"></i></span>
                                            <div class="ca-content-planilla">
                                                <h2 class="ca-main-planilla">Vista Supervisión</h2>
                                                <h3 class="ca-sub-planilla">Personaliza el campo supervisión</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>

                                <div class="col-sm-12 text-center"> 

                                  <br></br>

                                  <span class="f-16 f-700">Acciones</span>

                                  <hr></hr>
                                  
                 
                                  <a class="" href="{{url('/')}}/configuracion/supervisiones/agenda/{{$id}}"><i class="zmdi zmdi-eye f-20 m-r-10 boton red sa-warning" name="Ver Agenda" data-original-title="Ver Agenda" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                  <a class="" href="{{url('/')}}/configuracion/supervisiones/evaluar/{{$id}}"><i class="icon_a icon_a-examen f-20 m-r-10 boton red sa-warning" name="Evaluar" data-original-title="Evaluar" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                  <a class="" href="{{url('/')}}/configuracion/supervisiones/evaluaciones/{{$id}}"><i class="zmdi zmdi-hourglass-alt f-20 m-r-10 boton red sa-warning" name="Historial" data-original-title="Historial" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                  <i class="zmdi zmdi-delete f-20 m-r-10 boton red sa-warning" id="{{$id}}" name="eliminar" data-original-title="Eliminar" data-toggle="tooltip" data-placement="bottom" title=""></i>

                                  <br></br>
                                    
                                   
                                </div>

                                </div>                
                              </div>
                              <!--<p class="text-justify">Desde esta área Easy Dance te brinda la oportunidad de actualizar los datos creados en tu planilla de registro.</p>-->
                                    
                          </div>
                     </div>

					           	<div class="col-sm-9">

                         <div class="col-sm-12">
                              <p class="text-center opaco-0-8 f-22">Datos de la Valoración</p>
                          </div>

                          <div class="col-sm-12">
                           <table class="table table-striped table-bordered">
                            <tr class="detalle" data-toggle="modal" href="#modalSupervisor-Supervision">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-supervisor_id" class="zmdi {{ empty($supervisor) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-examen f-22"></i> </span>
                               <span class="f-14">Supervisor</span>
                             </td>
                             <td class="f-14 m-l-15"><span id="supervision-supervisor_id">{{$supervisor}}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalCargo-Supervision">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-cargo" class="zmdi {{ empty($cargo_a_supervisar) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-examen f-22"></i> </span>
                               <span class="f-14">Cargo a Supervisar</span>
                             </td>
                             <td class="f-14 m-l-15"><span id="supervision-cargo">{{$cargo_a_supervisar}}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalStaff-Supervision">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-staff_id" class="zmdi {{ empty($staff_a_supervisar) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-examen f-22"></i> </span>
                               <span class="f-14">Staff a Supervisar</span>
                             </td>
                             <td class="f-14 m-l-15"><span id="supervision-staff_id">{{$staff_a_supervisar}}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalFecha-Supervision">

                             <td width="50%"> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-fecha" class="zmdi  {{ empty($fecha_inicio) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>                              
                              <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-calendar-check f-22"></i> </span>
                              <span class="f-14">Rango de Fecha</span>
                             </td>
                             <td class="f-14 m-l-15"><span id="supervision-fecha">{{$fecha_inicio}} - {{$fecha_final}}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalItems-Supervision">

                             <td width="50%"> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-items" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>                              
                              <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-calendar-check f-22"></i> </span>
                              <span class="f-14">Ítems a evaluar</span>
                             </td>
                             <td class="f-14 m-l-15"> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
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

    route_update="{{url('/')}}/configuracion/supervisiones/update";
    route_eliminar="{{url('/')}}/configuracion/supervisiones/eliminar/";
    route_principal="{{url('/')}}/configuracion/supervisiones";

    var checkbox;
    var items = <?php echo json_encode($items_a_evaluar);?>;
    var config_supervision = <?php echo json_encode($config_supervision);?>;
    var inputs = $('.supervision');

    $(document).ready(function(){

      $.each(config_supervision, function (index, supervision) {
        $.each(items, function (index2, item) {
        // if($.inArray(items, supervision.nombre)){
        //     $('#supervision_'+supervision.id).val(supervision.nombre);
        //     $('#switch2_'+supervision.id).prop('checked',true)
        // }
          if(item.trim() == supervision.nombre.trim()){
              $('#supervision_'+supervision.id).val(supervision.nombre);
              $('#switch2_'+supervision.id).prop('checked',true)
          }
        });
      });

      $('.cargo_{{$cargo_id}}').show();

      $('input[name="id"]').val("{{$id}}")

      frecuencias = $('input[type="checkbox"].frecuencia');
      supervisiones = $('input[type="checkbox"].supervision');
      var items_a_evaluar = [];

        $('#fecha').daterangepicker({
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

    $('#modalFecha-Supervision').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#fecha").val($("#examen-fecha").text()); 
    })

    function limpiarMensaje(){
        var campo = ["nombre", "descripcion", "fecha", "instructor_id", "genero"];
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
          if(c.name=='supervisor_id' || c.name=='cargo' || c.name=='staff_id' ){
            
            expresion = "#"+c.name+ " option[value="+c.value+"]";
            texto = $(expresion).text();
            
            $("#supervision-"+c.name).text(texto);
            //$("#alumno-"+c.name).text(c.value.substr(0, 30));
          }else{
            $("#supervision-"+c.name).text(c.value);
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
        //$(this).data('formulario');
        var nFrom = $(this).attr('data-from');
        var nAlign = $(this).attr('data-align');
        var nIcons = $(this).attr('data-icon');
        var nAnimIn = "animated flipInY";
        var nAnimOut = "animated flipOutY"; 
        limpiarMensaje();
        $(".guardar").attr("disabled","disabled");
         procesando();
        $("#guardar").css({
            "opacity": ("0.2")
        });
        $(".cancelar").attr("disabled","disabled");
        $(".procesando").removeClass('hidden');
        $(".procesando").addClass('show');
        form=$(this).data('formulario');
        update=$(this).data('update');
        var token = $('input:hidden[name=_token]').val();
        var datos = $( "#"+form ).serialize();
        var datos_array=  $( "#"+form ).serializeArray();
        console.log(datos_array);
        
        var genero = [];
        $('#genero option:selected').each(function() {
          genero.push( $( this ).text() );
        });

        var route = route_update+"/"+update;
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: datos+"&genero="+genero,                
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
                 $(".procesando").removeClass('show');
                 $(".procesando").addClass('hidden');
                 $(".guardar").removeAttr("disabled");
                $("#guardar").css({
                  "opacity": ("1")
                });
                 $(".cancelar").removeAttr("disabled");
                 $('.modal').modal('hide');
              }, 1000);  
            },
            error:function (msj, ajaxOptions, thrownError){
              setTimeout(function(){ 
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
                  $(".procesando").removeClass('show');
                  $(".procesando").addClass('hidden');
                  $(".guardar").removeAttr("disabled");
                  finprocesado();
                  $("#guardar").css({
                    "opacity": ("1")
                  });
                  $(".cancelar").removeAttr("disabled");
              }, 1000);             
            }
        })
       
    })

    $("i[name=eliminar]").click(function(){
            swal({   
                title: "Desea eliminar la supervisión",   
                text: "Confirmar eliminación!",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Eliminar!",  
                cancelButtonText: "Cancelar",         
                closeOnConfirm: true 
            }, function(isConfirm){   
      if (isConfirm) {

                    eliminar();
      }
            });
        });
      function eliminar(){
         var route = route_eliminar + "{{$id}}";
         var token = $('input:hidden[name=_token]').val();
         procesando();
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'DELETE',
                    dataType: 'json',
                    success:function(respuesta){

                        window.location=route_principal; 

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

      $('#supervisor_id').on('change', function(){

        id = $(this).val();

        if(id != ''){
          $("#staff_id option[value='"+id+"-1']").attr("disabled","disabled");
          $("#staff_id option[value='"+id+"-1']").data("icon","glyphicon-remove");
        }

        $("#staff_id option[value!='"+id+"-1']").removeAttr("disabled","disabled");
        $("#staff_id option[value!='"+id+"-1']").data("icon","");

            
        $('#staff_id').selectpicker('refresh');
      });

      $('#staff_id').on('change', function(){

        explode = $(this).val();
        id = explode.split('-')

        if(id != ''){
          if(id[1] == '1'){
            $("#supervisor_id option[value='"+id[0]+"']").attr("disabled","disabled");
            $("#supervisor_id option[value='"+id[0]+"']").data("icon","glyphicon-remove");
            $("#supervisor_id option[value!='"+id[0]+"']").removeAttr("disabled","disabled");
            $("#supervisor_id option[value!='"+id[0]+"']").data("icon","");
          }else{
            $("#supervisor_id option[value!='"+explode+"']").removeAttr("disabled","disabled");
            $("#supervisor_id option[value!='"+explode+"']").data("icon","");
          }
        }

        $('#supervisor_id').selectpicker('refresh');

      });


      $('#cargo').on('change', function(){

        $.each(supervisiones, function (index, array) {
          $(array).prop('checked', false)
          check = $(array).attr('id');
          explode = check.split('_')
          id = explode[1];
          $('#supervision_'+id).val('');
        });

        id = $(this).val();

        $('.supervisiones').hide();
        $('.cargo_'+id).show();

      });

      $('.frecuencia').on('change', function(){

        $('#frecuencia').val('');
        checked = false;
        $.each(frecuencias, function (index, array) {
          check = $(array).attr('id');
          explode = check.split('_')
          id = explode[1];
          if ($(array).is(":checked")){
            checked = true
            $('#dia_'+id).val(1);
            $('#frecuencia').removeAttr('disabled');
          }else{
            $('#dia_'+id).val(0);
            if(checked == false){
              $('#frecuencia').attr('disabled', 'disabled');
            }
          }   
        });


        $('#frecuencia').selectpicker('refresh');

      });

      $('.supervision').on('change', function(){

        nombre = $(this).data('name');
        check = $(this).attr('id');
        explode = check.split('_')
        id = explode[1];

        if ($(this).is(":checked")){
          $('#supervision_'+id).val(nombre);
        }else{
          $('#supervision_'+id).val('');
        }  

        items_a_evaluar = [];

        $.each(inputs, function (index, array) {
          if(array.checked){
            items_a_evaluar.push(array.dataset.name);
          }
        });

        $('#items_a_evaluar').val(items_a_evaluar)

      });

   </script> 

   <!--<script src="{{url('/')}}/assets/js/script/alumno-planilla.js"></script>-->        
		
@stop
