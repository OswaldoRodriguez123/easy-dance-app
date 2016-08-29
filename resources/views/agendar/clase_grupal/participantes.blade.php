@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
@stop
@section('content')

<div class="modal fade" id="modalCostoInscripcion-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_costo_inscripcion_clase_grupal" id="edit_costo_inscripcion_clase_grupal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="costo">Costo Inscripcion</label>
                                    <input type="text" class="form-control input-sm" name="costo_inscripcion" id="costo_inscripcion" placeholder="Ej. 5000">
                                 </div>
                                 <div class="has-error" id="error-costo_inscripcion">
                                      <span >
                                          <small class="help-block error-span" id="error-costo_inscripcion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>


                               <input type="hidden" name="id" value="{{$clasegrupal->id}}"></input>
                              

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

                              <button type="button" class="btn btn-blanco m-r-10 f-12" id="guardar_inscripcion" name="guardar_inscripcion">Guardar</button>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalCostoMensualidad-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_costo_mensualidad_clase_grupal" id="edit_costo_mensualidad_clase_grupal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="costo">Costo Mensualidad</label>
                                    <input type="text" class="form-control input-sm" name="costo_mensualidad" id="costo_mensualidad" placeholder="Ej. 5000">
                                 </div>
                                 <div class="has-error" id="error-costo_mensualidad">
                                      <span >
                                          <small class="help-block error-span" id="error-costo_mensualidad_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>


                               <input type="hidden" name="id" value="{{$clasegrupal->id}}"></input>
                              

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

                              <!-- <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_costo_mensualidad_clase_grupal" data-update="costomensualidad" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a> -->
                              <button type="button" class="btn btn-blanco m-r-10 f-12" id="guardar_mensualidad" name="guardar_mensualidad">Guardar</button>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalFechaCobro-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_fecha_cobro_clasegrupal" id="edit_fecha_cobro_clasegrupal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                    <label for="fecha_inicio_preferencial">Fecha de primer cobro automático</label>
                                    <input type="text" class="form-control date-picker input-sm" name="fecha_pago" id="fecha_pago" placeholder="Ej. 00/00/0000" value="{{$clasegrupal->fecha_inicio_preferencial}}">
                                 </div>
                                    <div class="has-error" id="error-fecha_inicio_preferencial">
                                      <span >
                                          <small id="error-fecha_inicio_preferencial_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$clasegrupal->id}}"></input>
                              

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

                              <!-- <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="fecha_inicio_preferencial" data-update="fechacobro" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a> -->

                              <button type="button" class="btn btn-blanco m-r-10 f-12" id="guardar_fecha" name="guardar_fecha">Guardar</button>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Agregar <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="agregar_inscripcion" id="agregar_inscripcion">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input type="hidden" name="clase_grupal_id" value="{{ $id }}">
                            <div class="row p-l-10 p-r-10">
                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>
                                <div class="col-sm-12">
                                 
                                     <label for="alumno" class="c-morado f-22">Seleccionar Alumno</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona un participante al cual deseas asignar a la clase grupal" title="" data-original-title="Ayuda"></i>

                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a-alumnos f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">
                                        <!-- <select class="selectpicker" name="alumno_id" id="alumno_id" data-live-search="true">
                                          <option value="">Selecciona</option>
                                          @foreach ( $alumnos as $alumno )
                                          <option value = "{{ $alumno['id'] }}">{{ $alumno['nombre'] }} {{ $alumno['apellido'] }} {{ $alumno['identificacion'] }}</option>
                                          @endforeach
                                        </select>
 -->
                                        <!-- <select class="selectpicker bs-select-hidden" id="alumno_id" name="alumno_id" multiple="" data-max-options="5" title="Selecciona"> -->

                                        <select class="selectpicker" id="alumno_id" name="alumno_id" title="Selecciona" data-live-search="true">

                                         @foreach ( $alumnos as $alumno )
                                          <option value = "{{ $alumno['id'] }}">{{ $alumno['nombre'] }} {{ $alumno['apellido'] }} {{ $alumno['identificacion'] }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-alumno_id">
                                      <span >
                                        <small class="help-block error-span" id="error-alumno_id_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>


                               <div class="col-sm-12">

                               <span class="f-22 c-morado"> Datos Administrativos de la Clase Grupal </span>

                               <hr>

                               </div>

                               

                               <br>

                               <div class="col-sm-12">
                            
                                <table class="table table-striped table-bordered">
                               <tr class="detalle" data-toggle="modal" href="#modalCostoInscripcion-ClaseGrupal">
                                 <td>
                                    <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-costo_inscripcion" class="zmdi  {{ empty($clasegrupal->costo_inscripcion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                                   <span class="m-l-10 m-r-10"> <i class="icon_b icon_b-costo f-22"></i> </span>
                                   <span class="f-14"> Costo Inscripcion </span>
                                 </td>
                                 <td class="f-14 m-l-15" ><span id="clasegrupal-costo_inscripcion"><span>{{$clasegrupal->costo_inscripcion}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                                </tr>
                                </table>
                                 
                                    <!-- <label for="costo_inscripcion">Costo de la Inscripcion</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Desde este campo podras modificar de manera personal (por alumno) el costo de la inscripción" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="costo_inscripcion" id="costo_inscripcion" placeholder="Ej. 5000" value="{{ $clasegrupal->costo_inscripcion }}">
                                      </div>
                                    </div> -->
                                 <!-- <div class="has-error" id="error-costo_inscripcion">
                                      <span >
                                          <small class="help-block error-span" id="error-costo_inscripcion_mensaje" ></small>                        
                                      </span>
                                  </div> -->
                               </div>

                               <br>

                               <div class="col-sm-12">
                                 
                                    <!-- <label for="pago_recurrente">Pago Mensualidad</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Desde este campo podras modificar de manera personal (por alumno) el costo de la mensualidad" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="costo_mensualidad" id="costo_mensualidad" placeholder="Ej. 1000" value="{{ $clasegrupal->costo_mensualidad }}">
                                      </div>
                                    </div> -->

                                    <table class="table table-striped table-bordered">
                                   <tr class="detalle" data-toggle="modal" href="#modalCostoMensualidad-ClaseGrupal">
                                     <td>
                                        <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-costo_mensualidad" class="zmdi  {{ empty($clasegrupal->costo_mensualidad) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                                       <span class="m-l-10 m-r-10"> <i class="icon_b icon_b-costo f-22"></i> </span>
                                       <span class="f-14"> Costo Mensualidad</span>
                                     </td>
                                     <td class="f-14 m-l-15" ><span id="clasegrupal-costo_mensualidad"><span>{{$clasegrupal->costo_mensualidad}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                                    </tr>
                                    </table>
                                 
                                 <!-- <div class="has-error" id="error-costo_mensualidad">
                                      <span >
                                          <small class="help-block error-span" id="error-costo_mensualidad_mensaje" ></small>                        
                                      </span>
                                  </div> -->
                               </div>

                               <br>

                               <div class="col-sm-12">
                                    
                                      <!-- <label for="fecha_pago">Fecha de primer cobro automático</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Desde este campo podrás gestionar una fecha de pago por alumno de manera particular, en caso que desees mantener la fecha seleccionada en la planilla de registro, debes dejar el campo sin operación, es decir, sin gestionarlo" title="" data-original-title="Ayuda"></i>
                                      <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-calendar-check f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="fecha_pago" id="fecha_pago" class="form-control date-picker proceso" placeholder="Selecciona" type="text" value="{{ $clasegrupal->fecha_inicio_preferencial}}">
                                          </div>

                                    </div> -->

                                    <table class="table table-striped table-bordered">
                                   <tr class="detalle" data-toggle="modal" href="#modalFechaCobro-ClaseGrupal">
                                     <td width="70%">
                                      <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-fecha_inicio_preferencial" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                                      <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-calendar f-22"></i> </span>
                                      <span class="f-14">Fecha de primer cobro automático </span>
                                     </td>
                                     <td class="f-14 m-l-15" id="clasegrupal-fecha_inicio_preferencial" ><span id="clasegrupal-fecha_inicio_preferencial">
                                     {{ $clasegrupal->fecha_inicio_preferencial == 0000-00-00 ? \Carbon\Carbon::createFromFormat('Y-m-d',$clasegrupal->fecha_inicio)->format('d/m/Y') : \Carbon\Carbon::createFromFormat('Y-m-d',$clasegrupal->fecha_inicio_preferencial)->format('d/m/Y') }}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
                                    </tr>
                                    </table>

                                    <!-- <div class="has-error" id="error-fecha_pago">
                                        <span >
                                            <small class="help-block error-span" id="error-fecha_pago_mensaje" ></small>                                           
                                        </span>
                                    </div> -->
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
                            <div class="col-sm-12 text-right">                           

                              <!-- <a class="btn-blanco m-r-10 f-18 guardar" href="#" id="guardar" name="guardar">  Agregar </a> -->

                              <button type="button" class="btn btn-blanco m-r-10 f-18 agregar" id="agregar" name="agregar">Guardar<i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>

                            </div>
                        </div>
                      </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalEdicion" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Alumno: <span id="span_alumno" name="span_alumno"></span> <button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edicion_alumno" id="edicion_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">

                             <div class="col-sm-12">
                                   <div class="form-group fg-line">
                                      <label for="costo">Costo Mensualidad</label>
                                      <input type="text" class="form-control input-sm" name="costo_mensualidad_edicion" id="costo_mensualidad_edicion" data-mask="0000000000" placeholder="Ej. 5000">
                                   </div>
                                   <div class="has-error" id="error-costo_mensualidad_edicion">
                                        <span >
                                            <small class="help-block error-span" id="error-costo_mensualidad_edicion_mensaje" ></small>                                
                                        </span>
                                    </div>
                                 </div>
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                    <label for="fecha_pago_edicion">Fecha de primer cobro automático</label>
                                    <input type="text" class="form-control date-picker input-sm" name="fecha_pago_edicion" id="fecha_pago_edicion" placeholder="Ej. 00/00/0000">
                                 </div>
                                    <div class="has-error" id="error-fecha_pago_edicion">
                                      <span >
                                          <small id="error-fecha_pago_edicion_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id_edicion" id="id_edicion" value=""></input>
                              

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

                              <button type="button" class="btn-blanco m-r-5 f-12 guardar_edicion" id="guardar_edicion" name="guardar_edicion">Guardar<i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <section id="content">
                <div class="container">
                
                    <div class="block-header">

                        <?php $url = "/agendar/clases-grupales/detalle/$id" ?>
                        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 
                    
                    <div class="card">
                        <div class="card-header">



                            <div class="text-right">
                            <a class="f-16 p-t-0 text-right text-success" data-toggle="modal" href="#modalAgregar">Agregar Nuevo Participante <i class="zmdi zmdi-account-add zmdi-hc-fw f-20 c-verde"></i></a>

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-clases-grupales p-r-5"></i> Clase: {{$clasegrupal->nombre}}</p>
                            <hr class="linea-morada">

                            <div class="col-sm-5 text-left">
                                      <div class="p-t-10"> 
                                        <i class="zmdi zmdi-female f-25 c-rosado"></i> <span class="f-15" style="padding-left:5px"> {{$mujeres}}</span>
                                        <i class="zmdi zmdi-male-alt p-l-5 f-25 c-azul"></i> <span class="f-15" style="padding-left:5px"> {{$hombres}} </span>
                                    </div>
                            </div> 

                            </div>                                                        
                        </div>

                        <div class="clearfix p-b-35"></div>

                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="id" data-type="numeric">Id</th>
                                    <th class="text-center" data-column-id="sexo">Sexo</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombres</th>
                                    <th class="text-center" data-column-id="estatu_c" data-order="desc">Estatus C</th>
                                    <th class="text-center" data-column-id="estatu_e" data-order="desc">Balance E</th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" >Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($alumnos_inscritos as $alumno)
                                <?php $id = $alumno->inscripcion_id; ?>
                                <tr id="{{$id}}" class="seleccion" data-id="{{$alumno->id}}" data-fecha="{{$alumno->fecha_pago}}" data-mensualidad="{{$alumno->costo_mensualidad}}" data-nombre="{{$alumno->nombre}} {{$alumno->apellido}}">
                                    <td class="text-center previa">{{$alumno->identificacion}}</td>
                                    <td class="text-center previa">
                                    @if($alumno->sexo=='F')
                                    <i class="zmdi zmdi-female f-25 c-rosado"></i> </span>
                                    @else
                                    <i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>
                                    @endif
                                    </td>
                                    <td class="text-center previa">{{$alumno->nombre}} {{$alumno->apellido}} </td>
                                    <td class="text-center previa"><label class="label estatusc-verde f-16"><i data-toggle="modal" href="#" class="zmdi zmdi-label-alt-outline f-20 p-r-3 operacionModal c-verde"></i></label></td>
                                    <td class="text-center previa"><label class="label estatusc-verde f-16"><i data-toggle="modal" href="#" class="zmdi zmdi-money f-20 p-r-3 operacionModal c-verde"></i></label></td>
                                    <!--<td class="text-center"> <i data-toggle="modal" href="#modalOperacion" class="zmdi zmdi-filter-list f-20 p-r-10 operacionModal"></i></td>-->
                                    <!-- <td class="text-center"> <a href="{{url('/')}}/participante/alumno/operaciones/{{$id}}"><i class="zmdi zmdi-filter-list f-20 p-r-10"></i></a></td> -->
                                    <td class="text-center"> <i data-toggle="modal" class="zmdi zmdi-delete eliminar f-20 p-r-10"></i></td>
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

        route_agregar="{{url('/')}}/agendar/clases-grupales/inscribir";
        route_eliminar="{{url('/')}}/agendar/clases-grupales/eliminarinscripcion/";
        route_update="{{url('/')}}/agendar/clases-grupales/update";
        route_enhorabuena="{{url('/')}}/agendar/clases-grupales/enhorabuena/";
        route_editar="{{url('/')}}/agendar/clases-grupales/editarinscripcion";
        route_detalle="{{url('/')}}/participante/alumno/detalle";

        $(document).ready(function(){

        $('#alumno_id > option[value="{{ Session::get('id_alumno') }}"]').attr('selected', 'selected');

        id_alumno = "{{Session::get('id_alumno')}}";
        
        if(id_alumno){

          setTimeout(function(){ 
              $('#modalAgregar').modal('show');
            }, 2000);
        }

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,    
        order: [[0, 'asc']],
        fnDrawCallback: function() {
        if ($('#tablelistar tr').length < 25) {
              $('.dataTables_paginate').hide();
          }
        },
        pageLength: 25,
        paging: false,
        language: {
              searchPlaceholder: "Buscar"
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
    

            if($('.chosen')[0]) {
                $('.chosen').chosen({
                    width: '100%',
                    allow_single_deselect: true
                });
            }
            if ($('.date-time-picker')[0]) {
               $('.date-time-picker').datetimepicker();
            }

            if ($('.date-picker')[0]) {
                $('.date-picker').datetimepicker({
                    format: 'DD/MM/YYYY'
                });
            }

                //Basic Example
                $("#data-table-basica").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
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

        $("#agregar").click(function(){

                var costo_inscripcion = $("#clasegrupal-costo_inscripcion").text();
                var costo_mensualidad = $("#clasegrupal-costo_mensualidad").text();
                var fecha_pago = $("#clasegrupal-fecha_inicio_preferencial").text();

                var values = $('#alumno_id').val();

                if(values){
                
                // var alumno = '';
                
                // for(var i = 0; i < values.length; i += 1) {

                // alumno = alumno + '-' + values[i];

                // }

                procesando();
                var route = route_agregar;
                var token = $('input:hidden[name=_token]').val();
                var clase_grupal_id = $('input:hidden[name=clase_grupal_id]').val();
                var datos = $( "#agregar_inscripcion" ).serialize(); 
                $("#guardar").attr("disabled","disabled");
                $(".cancelar").attr("disabled","disabled");
                $(".procesando").removeClass('hidden');
                $(".procesando").addClass('show');         
                limpiarMensaje();
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data:"&clase_grupal_id="+clase_grupal_id+"&alumno_id="+values+"&costo_inscripcion="+costo_inscripcion+"&costo_mensualidad="+costo_mensualidad+"&fecha_pago="+fecha_pago,
                    success:function(respuesta){
                      setTimeout(function(){ 
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        if(respuesta.status=="OK"){
                          if(respuesta.array){

                            var nType = 'success';
                            // $("#agregar_inscripcion")[0].reset();
                            var nTitle="Ups! ";
                            var nMensaje=respuesta.mensaje;

                            $("#modalAgregar").modal("hide");

                            $.each(respuesta.array, function (index, array) {
                            console.log(index + ' ' +array);

                              var identificacion = array.identificacion;
                              
                              if(array.sexo=='F')
                              {
                                sexo = '<i class="zmdi zmdi-female f-25 c-rosado"></i> </span>'
                              }
                              else
                              {
                                sexo = '<i class="zmdi zmdi-male f-25 c-azul"></i> </span>'
                              }
                             
                              var nombre = array.nombre;
                              var apellido = array.apellido;

                              var rowId=array.id;
                              var rowNode=t.row.add( [
                              ''+identificacion+'',
                              ''+sexo+'',
                              ''+nombre+ ' ' +apellido+'',
                              '<label class="label estatusc-verde f-16"><i data-toggle="modal" href="#" class="zmdi zmdi-label-alt-outline f-20 p-r-3 operacionModal c-verde"></i></label>',
                              '<label class="label estatusc-verde f-16"><i data-toggle="modal" href="#" class="zmdi zmdi-money f-20 p-r-3 operacionModal c-verde"></i></label>',
                              '<i data-toggle="modal" class="zmdi zmdi-delete eliminar f-20 p-r-10"></i>'
                              ] ).draw(false).node();
                              $( rowNode )
                              .attr('id',rowId)
                              .addClass('seleccion');

                              });
                            }
                            else{

                              window.location = route_enhorabuena + respuesta.id;

                            }

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }                       
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        // finprocesado();
                        $("#guardar").removeAttr("disabled");
                        $(".cancelar").removeAttr("disabled");

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
                        finprocesado();
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
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
              }
              else{

                $("#error-alumno_id_mensaje").html("Debe seleccionar un alumno primero");

              }
            });

        $("#guardar_inscripcion").click(function(){
            swal({   
                    title: "¿Seguro deseas modificar el costo de la inscripción?",   
                    text: "Confirmar el cambio",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#ec6c62",   
                    confirmButtonText: "Sí, modificar",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
            if (isConfirm) {

                var route = route_update+"/inscripcion";
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#edit_costo_inscripcion_clase_grupal" ).serialize(); 
                procesando();
                $(".procesando").removeClass('hidden');
                $(".procesando").addClass('show');         
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
                          
                          var costo_inscripcion = $("#costo_inscripcion").val();
                          $("#clasegrupal-costo_inscripcion").text(costo_inscripcion)

                          finprocesado();
                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          $('#modalCostoInscripcion-ClaseGrupal').modal('hide');
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';

                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          finprocesado();
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                        }                       
                        
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        if (typeof msj.responseJSON === "undefined") {
                          window.location = "{{url('/')}}/error";
                        }
                        finprocesado();
                        if(msj.responseJSON.status=="ERROR"){
                          console.log(msj.responseJSON.errores);
                          errores(msj.responseJSON.errores);
                          var nTitle="    Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        }else{
                          var nTitle="   Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }            

                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
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
              }
            });
        });

        $("#guardar_mensualidad").click(function(){
            swal({   
                    title: "¿Seguro deseas modificar el costo de la mensualidad?",   
                    text: "Confirmar el cambio",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#ec6c62",   
                    confirmButtonText: "Sí, modificar",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
            if (isConfirm) {

                var route = route_update+"/mensualidad";
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#edit_costo_mensualidad_clase_grupal" ).serialize(); 
                procesando();
                $(".procesando").removeClass('hidden');
                $(".procesando").addClass('show');         
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
                          
                          var costo_mensualidad = $("#costo_mensualidad").val();
                          $("#clasegrupal-costo_mensualidad").text(costo_mensualidad)

                          finprocesado();
                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          $('#modalCostoMensualidad-ClaseGrupal').modal('hide');
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';

                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          finprocesado();
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                        }                       
                        
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        if (typeof msj.responseJSON === "undefined") {
                          window.location = "{{url('/')}}/error";
                        }
                        finprocesado();
                        if(msj.responseJSON.status=="ERROR"){
                          console.log(msj.responseJSON.errores);
                          errores(msj.responseJSON.errores);
                          var nTitle="    Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        }else{
                          var nTitle="   Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }            

                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
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
              }
            });
        });

        $("#guardar_fecha").click(function(){
            swal({   
                    title: "¿Seguro deseas modificar la fecha de primer cobro automático ?",   
                    text: "Confirmar el cambio",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#ec6c62",   
                    confirmButtonText: "Sí, modificar",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
            if (isConfirm) {

                var route = route_update+"/fecha_pago";
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#edit_fecha_cobro_clasegrupal" ).serialize(); 
                procesando();
                $(".procesando").removeClass('hidden');
                $(".procesando").addClass('show');         
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
                          
                          var fecha_pago = $("#fecha_pago").val();
                          $("#clasegrupal-fecha_inicio_preferencial").text(fecha_pago)

                          finprocesado();
                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          $('#modalFechaCobro-ClaseGrupal').modal('hide');
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';

                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          finprocesado();
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                        }                       
                        
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        if (typeof msj.responseJSON === "undefined") {
                          window.location = "{{url('/')}}/error";
                        }
                        finprocesado();
                        if(msj.responseJSON.status=="ERROR"){
                          console.log(msj.responseJSON.errores);
                          errores(msj.responseJSON.errores);
                          var nTitle="    Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        }else{
                          var nTitle="   Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }            

                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
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
              }
            });
        });

        $("#guardar_edicion").click(function(){

                procesando();
                var route = route_editar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#edicion_alumno" ).serialize();         
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
                          var tr_edicion = $("#"+respuesta.inscripcion.id_edicion);

                          $(tr_edicion).data('mensualidad', respuesta.inscripcion.costo_mensualidad_edicion)
                          $(tr_edicion).data('fecha', respuesta.inscripcion.fecha_pago_edicion)

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }                       
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        finprocesado();
                        $('#modalEdicion').modal('hide');
                        $("#guardar").removeAttr("disabled");
                        $(".cancelar").removeAttr("disabled");

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
                        finprocesado();
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
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

        function previa(t){

            var id = $(t).closest('tr').attr('id');
            var fecha_pago = $(t).closest('tr').data('fecha');
            var costo_mensualidad = $(t).closest('tr').data('mensualidad');
            var nombre = $(t).closest('tr').data('nombre');


            $('#id_edicion').val(id);
            $('#costo_mensualidad_edicion').val(costo_mensualidad);
            $('#fecha_pago_edicion').val(fecha_pago);
            $('#span_alumno').text(nombre);
            
            $('#modalEdicion').modal('show');
        }

        $('#tablelistar tbody').on( 'click', 'i.zmdi-delete', function () {

                var id = $(this).closest('tr').attr('id');
                // var temp = row.split('_');
                // var id = temp[1];
                element = this;

                swal({   
                    title: "Desea eliminar al alumno?",   
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
                        swal("Exito!","El alumno ha sido eliminado!","success");
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
                        eliminar(id, element);
          }
                });
            });
      
        function eliminar(id, element){
         var route = route_eliminar + id;
         var token = "{{ csrf_token() }}";
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    data: id,
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

                          t.row( $(element).parents('tr') )
                            .remove()
                            .draw();
                        
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
                                }
                });
      }

    // $('#modalCosto-Producto').on('show', function() {
    //     console.log("entro");
    //     $('#modalAgregar').css('opacity', .5);
    // });

    $(document)  
      .on('show.bs.modal', '.modal', function(event) {
        $(this).appendTo($('body'));
      })
      .on('shown.bs.modal', '.modal.in', function(event) {
        setModalsAndBackdropsOrder();
      })
      .on('hidden.bs.modal', '.modal', function(event) {
        setModalsAndBackdropsOrder();
      });

    function setModalsAndBackdropsOrder() {  
      var modalZIndex = 1040;
      $('.modal.in').each(function(index) {
        var $modal = $(this);
        modalZIndex++;
        $modal.css('zIndex', modalZIndex);
        $modal.next('.modal-backdrop.in').addClass('hidden').css('zIndex', modalZIndex - 1);
    });
      $('.modal.in:visible:last').focus().next('.modal-backdrop.in').removeClass('hidden');
    }

    function limpiarMensaje(){
        var campo = ["alumno_id"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
        console.log(merror);
        var campo = ["alumno_id"];
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

    $('#modalCostoInscripcion-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#costo_inscripcion").val($("#clasegrupal-costo_inscripcion").text());
    })

    $('#modalCostoMensualidad-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#costo_mensualidad").val($("#clasegrupal-costo_mensualidad").text());
    })

    $('#modalFechaCobro-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var fecha = $("#clasegrupal-fecha_inicio_preferencial").text();
      $("#fecha_pago").val($.trim(fecha));
    })

    // $('#alumno_id').change(function(){

    //     var values = $('#alumno_id').val();
    //     var valor = '';
    //     for(var i = 0; i < values.length; i += 1) {

    //     valor = valor + ' ' + values[i];
    //     }

    //     console.log(valor);

    // });

    $('#alumno_id').change(function () {


    // var selectedOptionValue = $(this).find("option:selected").text();

    var last = $("option:selected:last",this);

    console.log(last);

    if($(last).hasClass( "inscrito" )){
        // $(this).removeAttr("selected");
        $(this).attr('disabled', false);
        // .trigger("liszt:updated");
        $('#alumno_id').selectpicker('deselectAll');
        $('#alumno_id').selectpicker('render');
        swal({   
                    title: "ERROR",   
                    text: "Ya este alumno esta inscrito",   
                    type: "warning",   
                    confirmButtonColor: "#ec6c62",   
                    confirmButtonText: "Aceptar",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
        });
    }

    // for (var i = 0; i < selectedOptionValue.length; i++) {

    // var val = selectedOptionValue[i]; 
    // var txt = $("#alumno_id option[value='"+val+"']").text();

    //     // sendRequest.products.push({
    //     //     'productId': val ,
    //     //     'productName': txt 
    //     // });
    //     console.log(txt);
    // }

    
        // $(".test").text(selectedText);
    });

    function previa(t){

            var id = $(t).closest('tr').data('id');
            var route =route_detalle+"/"+id;
            window.location=route;
        }



    </script>

@stop