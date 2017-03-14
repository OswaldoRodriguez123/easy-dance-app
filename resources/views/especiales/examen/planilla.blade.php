@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
@stop

@section('content')
     
            
            <div class="modal fade" id="modalNombre-Examen" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Valoración<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_nombre_examen" id="edit_nombre_examen"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control input-sm" name="nombre" id="nombre" placeholder="Ej. Examen Basico">
                                 </div>
                                 <div class="has-error" id="error-nombre">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <input type="hidden" name="id" value="{{$examen->id}}"></input>
                              

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

                               <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_nombre_examen" data-update="nombre" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>


              <div class="modal fade" id="modalDescripcion-Examen" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Valoración<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_descripcion_examen" id="edit_descripcion_examen"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="edad">Descripcion</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="2" placeholder="250 Caracteres"></textarea>
                                 </div>
                                 <div class="has-error" id="error-descripcion">
                                      <span >
                                          <small class="help-block error-span" id="error-descripcion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 

                               <input type="hidden" name="id" value="{{$examen->id}}"></input>

                               
                               
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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_descripcion_examen" data-update="descripcion" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalFecha-Examen" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Valoración<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_fecha_examen" id="edit_fecha_examen"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group fg-line">
                                    <label for="apellido">Fecha de la Valoración</label>
                                            <div class="dtp-container fg-line">
                                            <input name="fecha" id="fecha" class="form-control date-picker" placeholder="Selecciona" type="text">
                                        </div>
                                    </div>
                                    <div class="has-error" id="error-fecha">
                                      <span >
                                          <small class="help-block error-span" id="error-fecha_mensaje" ></small>                                           
                                      </span>
                                 </div>
                               </div>

                               <input type="hidden" name="id" value="{{$examen->id}}"></input>
                              

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

                               <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_fecha_examen" data-update="fecha" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalFechaProxima-Examen" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Valoración<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_proxima_fecha_examen" id="edit_proxima_fecha_examen"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group fg-line">
                                    <label for="apellido">Proxima Fecha de Valoración</label>
                                            <div class="dtp-container fg-line">
                                            <input name="proxima_fecha" id="proxima_fecha" class="form-control date-picker" placeholder="Selecciona" type="text">
                                        </div>
                                    </div>
                                    <div class="has-error" id="error-proxima_fecha">
                                      <span >
                                          <small class="help-block error-span" id="error-proxima_fecha_mensaje" ></small>                                           
                                      </span>
                                 </div>
                               </div>

                               <input type="hidden" name="id" value="{{$examen->id}}"></input>
                              

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

                               <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_proxima_fecha_examen" data-update="proxima_fecha" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <!--
              BEGIN
              MODAL EDITAR INSTRUCTOR
            -->                
            <div class="modal fade" id="modalInstructor-Examen" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Valoración<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_instructor_examen" id="edit_instructor_examen"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group fg-line">
                                    <label for="apellido">Instructores</label>

                                      <div class="select">
                                        <select class="form-control" id="instructor_id" name="instructor_id">
                                        @foreach ( $instructor as $instruct )
                                        <option value = "{!! $instruct['id'] !!}">{!! $instruct['nombre'] !!} {!! $instruct['apellido'] !!}</option>
                                        @endforeach 
                                        </select>
                                      </div> 
                                    </div>
                                    <div class="has-error" id="error-instructor">
                                      <span >
                                          <small class="help-block error-span" id="error-instructor_mensaje" ></small>                                           
                                      </span>
                                 </div>
                               </div>

                               <input type="hidden" name="id" id="id" value="{{$examen->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_instructor_examen" data-update="instructor" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <!-- END -->  
            
            <!-- edit generos de baile -->
            <div class="modal fade" id="modalGeneros" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Valoración <button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_generos_musicales" id="edit_generos_musicales"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group fg-line">
                                    <label for="apellido">Generos</label>

                                      <div class="select">
                                        <select class="selectpicker bs-select-hidden" id="genero" name="genero" multiple="" data-max-options="5" title="Selecciona">
                                        @foreach ( $genero as $generos )
                                        <option value = "{{$generos->nombre}}">{{$generos->nombre}}</option>
                                        @endforeach
                                        </select>
                                      </div> 
                                    </div>
                                    <div class="has-error" id="error-genero">
                                      <span >
                                          <small class="help-block error-span" id="error-genero_mensaje" ></small>                                           
                                      </span>
                                 </div>
                               </div>

                               <input type="hidden" name="id" id="id" value="{{$examen->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_generos_musicales" data-update="generos" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <!-- end -->

            <!-- edit tipo de evaluacion -->
            <div class="modal fade" id="modalTiposDeEvaluacion" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Valoración <button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_tipos_de_evaluacion" id="edit_tipos_de_evaluacion"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                  <label for="nombre" id="id-tipo">Tipo de evaluacion</label> 
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="icon_a-especialidad f-22"></i></span>
                                    <div class="fg-line">
                                    <div class="select">
                                      <select class="selectpicker" name="tipo" id="tipo" data-live-search="true" >

                                        @foreach ( $config_examenes as $tipo )
                                          <option value = "{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                        @endforeach
                                      
                                      </select>
                                    </div>
                                  </div>
                                  </div>
                                  <div class="has-error" id="error-tipo">
                                    <span>
                                        <small class="help-block error-span" id="error-tipo_mensaje" ></small>  
                                    </span>
                                  </div>
                               </div>

                               <input type="hidden" name="id" id="id" value="{{$examen->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_tipos_de_evaluacion" data-update="tipos_de_evaluacion" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <!-- end -->

            <div class="modal fade" id="modalItems-Examen" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title bg-gris-oscuro">Editar Valoración<button type="button" data-dismiss="modal" class="close c-blanco f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_items_examen" id="edit_items_examen"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="modal-body">
                        <div class="row p-l-10 p-r-10">
                              <div class="panel-body">
                                      <input type="hidden" name="id" id="id" value="{{$examen->id}}"></input>

                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-16 f-700">Tiempos musicales</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                        <li id="switch" type="button" data-toggle="tooltip" data-placement="bottom" title="" >

                                        <input type="text" id="tiempos_musicales" name="tiempos_musicales" value="" hidden="hidden">
                                        <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="tiempos-switch" type="checkbox" hidden="hidden">
                                            <label for="tiempos-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                        </div>
                                        </li>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-16 f-700">Compromiso</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <li id="switch" type="button" data-toggle="tooltip" data-placement="bottom" title="" >

                                      <input type="text" id="compromiso" name="compromiso" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="compromiso-switch" type="checkbox" hidden="hidden">
                                          <label for="compromiso-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </li>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-16 f-700">Condiciones</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <li id="switch" type="button" data-toggle="tooltip" data-placement="bottom" title="" >

                                      <input type="text" id="condicion" name="condicion" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="condicion-switch" type="checkbox" hidden="hidden">
                                          <label for="condicion-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </li>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-16 f-700">Habilidades</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <li id="switch" type="button" data-toggle="tooltip" data-placement="bottom" title="" >

                                      <input type="text" id="habilidades" name="habilidades" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="habilidades-switch" type="checkbox" hidden="hidden">
                                          <label for="habilidades-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </li>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-16 f-700">Disciplina</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <li id="switch" type="button" data-toggle="tooltip" data-placement="bottom" title="" >

                                      <input type="text" id="disciplina" name="disciplina" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="disciplina-switch" type="checkbox" hidden="hidden">
                                          <label for="disciplina-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </li>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-16 f-700">Expresión corporal</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <li id="switch" type="button" data-toggle="tooltip" data-placement="bottom" title="" >

                                      <input type="text" id="expresion_corporal" name="expresion_corporal" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="expresion-corporal-switch" type="checkbox" hidden="hidden">
                                          <label for="expresion-corporal-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </li>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-16 f-700">Expresión facial</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <li id="switch" type="button" data-toggle="tooltip" data-placement="bottom" title="" >

                                      <input type="text" id="expresion_facial" name="expresion_facial" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="expresion-facial-switch" type="checkbox" hidden="hidden">
                                          <label for="expresion-facial-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </li>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-16 f-700">Destreza</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <li id="switch" type="button" data-toggle="tooltip" data-placement="bottom" title="" >

                                      <input type="text" id="destreza" name="destreza" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="destreza-switch" type="checkbox" hidden="hidden">
                                          <label for="destreza-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </li>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-16 f-700">Dedicación</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <li id="switch" type="button" data-toggle="tooltip" data-placement="bottom" title="" >

                                      <input type="text" id="dedicacion" name="dedicacion" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="dedicacion-switch" type="checkbox" hidden="hidden">
                                          <label for="dedicacion-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </li>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-16 f-700">Oído musical</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <li id="switch" type="button" data-toggle="tooltip" data-placement="bottom" title="" >

                                      <input type="text" id="oido_musical" name="oido_musical" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="oido-switch" type="checkbox" hidden="hidden">
                                          <label for="oido-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </li>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-16 f-700">Postura</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <li id="switch" type="button" data-toggle="tooltip" data-placement="bottom" title="" >

                                      <input type="text" id="postura" name="postura" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="postura-switch" type="checkbox" hidden="hidden">
                                          <label for="postura-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </li>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-16 f-700">Respeto</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <li id="switch" type="button" data-toggle="tooltip" data-placement="bottom" title="" >

                                      <input type="text" id="respeto" name="respeto" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="respeto-switch" type="checkbox" hidden="hidden">
                                          <label for="respeto-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </li>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-16 f-700">Elasticidad</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <li id="switch" type="button" data-toggle="tooltip" data-placement="bottom" title="" >

                                      <input type="text" id="elasticidad" name="elasticidad" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="elasticidad-switch" type="checkbox" hidden="hidden">
                                          <label for="elasticidad-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </li>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-16 f-700">Complejidad de movimientos</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <li id="switch" type="button" data-toggle="tooltip" data-placement="bottom" title="" >

                                      <input type="text" id="complejidad_de_movimientos" name="complejidad_de_movimientos" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="complejidad-switch" type="checkbox" hidden="hidden">
                                          <label for="complejidad-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </li>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-16 f-700">Asistencia</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <li id="switch" type="button" data-toggle="tooltip" data-placement="bottom" title="" >

                                      <input type="text" id="asistencia" name="asistencia" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="asistencia-switch" type="checkbox" hidden="hidden">
                                          <label for="asistencia-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </li>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-16 f-700">Estilo</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <li id="switch" type="button" data-toggle="tooltip" data-placement="bottom" title="" >

                                      <input type="text" id="estilo" name="estilo" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="estilo-switch" type="checkbox" hidden="hidden">
                                          <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </li>

                                      </div>
                    
                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3">
                                      <label for="nombre" id="id-item_nuevo">Nombre</label>
                                      <input type="text" class="form-control input-sm" name="item_nuevo" id="item_nuevo" placeholder="Ej. ritmo">
                                      </div>
                                      <div class="clearfix p-b-35"></div>
                                      <div class="col-md-2">
                                  <button type="button" class="btn btn-blanco m-r-8 f-10" name= "add" id="add" > Agregar Linea <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>
                                </div>

                                <div class="col-sm-4">
                                  <div class="has-error" id="error-item_nuevo">
                                        <span >
                                          <small class="help-block error-span" id="error-item_nuevo_mensaje" ></small>                                           
                                        </span>
                                    </div>
                                </div>

                                <div class="clearfix p-b-35"></div>
                      

                          <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="forma_pago">nombre</th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($items_examenes as $items)
                                <?php $id = $items->id; ?>
                                <tr id="{{$id}}" class="seleccion" >
                                    <td class="text-center previa">{{$items->nombre}}</td>
                                    <td class="text-center"> <i class="zmdi zmdi-delete f-20 p-r-10"></i></i></td>
                                  </tr>
                            @endforeach 
                         
                            </tbody>
                          </table>

                        </div>
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

                                        <a class="btn-blanco m-r-5 f-16 guardar" id="guardar" href="#" data-formulario="edit_items_examen" data-update="items" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                                      </div>
                                  </div></form>
                        

                        </div>
                        </div>
                    </div>
                </div>
            </div>   

             <div class="modal fade" id="modalClaseGrupal-Examen" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Valoración <button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_clase_grupal_examen" id="edit_clase_grupal_examen"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                  <div class="clearfix"></div>
                                  <label for="boolean_grupal" id="id-boolean_grupal">A quien va dirigido:</label>
                                  <div class="clearfix"></div>
                                  <div class="input-group">
                                      <!-- <span class="input-group-addon"><i class="icon_b icon_b-sexo f-22"></i></span> -->
                                      <div class="p-t-10">
                                      <label class="radio radio-inline m-r-20 ">
                                          <input checked="checked" name="boolean_grupal" id="general" value="0" type="radio">
                                          <i class="input-helper"></i>  
                                          General
                                      </label>
                                      <label class="radio radio-inline m-r-20">
                                          <input name="boolean_grupal" id="clase_grupal" value="1" type="radio">
                                          <i class="input-helper"></i>  
                                          Clase Grupal
                                      </label>
                                     
                                    </div>
                                  </div>
                                  </div>

                                <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12 clase_grupal" style="display:none">

                                  <label for="nombre" id="id-clase_grupal_id">Clase Grupal</label> <span class="c-morado f-700 f-16">*</span>
                                      <div class="input-group">
                                        <span class="input-group-addon"><i class="icon_a icon_a-clases-grupales f-22"></i></span>
                                        <div class="fg-line">
                                        <div class="select">
                                          <select class="selectpicker" name="clase_grupal_id" id="clase_grupal_id" data-live-search="true" >

                                            <option value="">Selecciona</option>
                                            @foreach ( $clases_grupales as $clase_grupal )
                                              <option value = "{{ $clase_grupal['id'] }}">{{ $clase_grupal['clase_grupal_nombre'] }} - {{ $clase_grupal['dia_de_semana'] }} - {{ $clase_grupal['hora_inicio'] }} / {{ $clase_grupal['hora_final'] }} - {{ $clase_grupal['instructor_nombre'] }} {{ $clase_grupal['instructor_apellido'] }}</option>
                                            @endforeach
                                          
                                          </select>
                                        </div>
                                      </div>
                                      </div>
                                   <div class="has-error" id="error-clase_grupal_id">
                                        <span >
                                            <small class="help-block error-span" id="error-clase_grupal_id_mensaje" ></small>                                
                                        </span>
                                    </div>
                               </div>

                               <input type="hidden" name="id" id="id" value="{{$examen->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_clase_grupal_examen" data-update="clase_grupal" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>       
    
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                       <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/especiales/examenes" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección de Valoración</a>
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
                                                <h2 class="ca-main-planilla">Vista Valoración</h2>
                                                <h3 class="ca-sub-planilla">Personaliza el campo valoración</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>

                                <div class="col-sm-12 text-center"> 

                                  <br></br>

                                  <span class="f-16 f-700">Acciones</span>

                                  <hr></hr>
                                  
                                  <a class="" href="{{url('/')}}/especiales/examenes/evaluar/{{$examen->id}}"><i class="icon_a icon_a-examen f-20 m-r-10 boton red sa-warning" name="Evaluar" data-original-title="Evaluar" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                  <a class="" href="{{url('/')}}/especiales/evaluaciones/{{$examen->id}}"><i class="zmdi zmdi-hourglass-alt f-20 m-r-10 boton red sa-warning" name="Evaluar" data-original-title="Historial" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                  <i class="zmdi zmdi-delete f-20 m-r-10 boton red sa-warning" id="{{$examen->id}}" name="eliminar" data-original-title="Eliminar" data-toggle="tooltip" data-placement="bottom" title=""></i>

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
                            <tr class="detalle" data-toggle="modal" href="#modalNombre-Examen">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-nombre" class="zmdi {{ empty($examen->nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-examen f-22"></i> </span>
                               <span class="f-14"> Nombre de la Valoración </span>
                             </td>
                             <td id="examen-nombre" class="f-14 m-l-15" data-valor="{{$examen->nombre}}" ><span id="examen-nombre"><span>{{ str_limit($examen->nombre, $limit = 30, $end = '...') }}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                              <tr class="detalle" data-toggle="modal" href="#modalDescripcion-Examen">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-descripcion" class="zmdi {{ empty($examen->descripcion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b-cuentales-historia f-22"></i> </span>
                               <span class="f-14"> Describe tu Valoración </span>
                             </td>
                             <td id="examen-descripcion" class="f-14 m-l-15" data-valor="{{$examen->descripcion}}" ><span id="examen-descripcion"><span>{{ str_limit($examen->descripcion, $limit = 30, $end = '...') }}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalFecha-Examen">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-fecha" class="zmdi {{ empty($examen->fecha) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-calendar-check f-22"></i> </span>
                               <span class="f-14"> Fecha de la Valoración  </span>
                             </td>
                             <td class="f-14 m-l-15"> <span id="examen-fecha">{{$examen->fecha}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalFechaProxima-Examen">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-proxima_fecha" class="zmdi {{ empty($examen->proxima_fecha) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-calendar-check f-22"></i> </span>
                               <span class="f-14"> Proxima Fecha de la Valoración  </span>
                             </td>
                             <td class="f-14 m-l-15"> <span id="examen-proxima_fecha">{{$examen->proxima_fecha}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
                            </tr>
                              <!-- <tr class="detalle" data-toggle="modal" href="#modalColor-Examen">
                               <td>
                                 <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-instructor" class="zmdi zmdi-dot-circle zmdi-hc-fw {{ empty($examen->instructor_nombre) ? 'c-amarillo' : 'c-verde' }}"></i></span>
                                 <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-invert-colors f-22"></i> </span>
                                 <span class="f-14"> Color de Etiqueta  </span>
                               </td>
                               <td  class="f-14 m-l-15" id="examen-color_etiqueta" >

                               <div class="fg-line dropdown">
                                  <input type="text" name="color_etiqueta" id="color_etiqueta" class="form-control cp-value proceso" value="#de87b4" data-toggle="dropdown">
                                   
                                   <div class="dropdown-menu">
                                       <div class="color-picker" data-cp-default="#de87b4"></div>
                                   </div>
                                                
                                    <i class="cp-value"></i>
                                  </div> 

                                  </td>
                              </tr> -->
                              <tr class="detalle" data-toggle="modal" href="#modalInstructor-Examen">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-instructor_id" class="zmdi {{ empty($examen->instructor_nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-instructor f-22"></i> </span>
                               <span class="f-14"> Instructor a Cargo  </span>
                             </td>
                             <td  class="f-14 m-l-15" id="examen-instructor_id" >{{$examen->instructor_nombre}} {{$examen->instructor_apellido}}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>

                            <tr class="detalle" data-toggle="modal" href="#modalItems-Examen">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-instructor_id" class="zmdi {{ empty($examen->instructor_nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-examen f-22"></i> </span>
                               <span class="f-14"> Ítems a Evaluar  </span>
                             </td>
                             <td  class="f-14 m-l-15" id="examen-instructor" ></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>

                            <tr class="detalle" data-toggle="modal" href="#modalGeneros">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-generos" class="zmdi {{ empty($examen->generos) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-instructor f-22"></i> </span>
                               <span class="f-14"> Generos Musicales </span>
                             </td>
                             <td  class="f-14 m-l-15" id="examen-genero" >{{$examen->generos}}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>

                            <tr class="detalle" data-toggle="modal" href="#modalTiposDeEvaluacion">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-tipo" class="zmdi {{ empty($examen->tipo) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-especialidad f-22"></i></span>
                               <span class="f-14"> Tipo de Evaluación </span>
                             </td>
                             <td  class="f-14 m-l-15" id="examen-tipo">{{$examen->tipo}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalClaseGrupal-Examen">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-clase_grupal" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-clases-grupales f-22"></i> </span>
                               <span class="f-14"> A quien va dirigido </span>
                             </td>
                             <td  class="f-14 m-l-15" id="examen-boolean_grupal" data-valor="{{$examen->boolean_grupal}}">
                                @if($examen->boolean_grupal==0)
                                  General
                                @else
                                  Clase Grupal
                                @endif    
                             </span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
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
    route_update="{{url('/')}}/especiales/examenes/update";
    route_eliminar="{{url('/')}}/especiales/examenes/eliminar/";
    route_principal="{{url('/')}}/especiales/examenes";
    route_edit="{{url('/')}}/especiales/examenes/actualizar_item"
    route_eliminar_item="{{url('/')}}/especiales/examenes/eliminar_item_fijo";

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

          if("{{$examen->boolean_grupal}}" == 1){
        
            $('#clase_grupal_id').val("{{$examen->clase_grupal_id}}")
            $('#clase_grupal_id').selectpicker('render')
            $(".clase_grupal").show();  
          }

          if("{{$examen->tiempos_musicales}}" == 1){
          $("#tiempos_musicales").val('1');  
          $("#tiempos-switch").attr("checked", true);}

          if("{{$examen->compromiso}}" == 1){
          $("#compromiso").val('1');  
          $("#compromiso-switch").attr("checked", true);}

          if("{{$examen->condicion}}" == 1){
          $("#condicion").val('1');  
          $("#condicion-switch").attr("checked", true);}

          if("{{$examen->habilidades}}" == 1){
          $("#habilidades").val('1');  
          $("#habilidades-switch").attr("checked", true);}

          if("{{$examen->disciplina}}" == 1){
          $("#disciplina").val('1');  
          $("#disciplina-switch").attr("checked", true);}

          if("{{$examen->expresion_corporal}}" == 1){
          $("#expresion_corporal").val('1');  
          $("#expresion-corporal-switch").attr("checked", true);}

          if("{{$examen->expresion_facial}}" == 1){
          $("#expresion_facial").val('1');  
          $("#expresion-facial-switch").attr("checked", true);}

          if("{{$examen->destreza}}" == 1){
          $("#destreza").val('1');  
          $("#destreza-switch").attr("checked", true);}

          if("{{$examen->dedicacion}}" == 1){
          $("#dedicacion").val('1');  
          $("#dedicacion-switch").attr("checked", true);}

          if("{{$examen->oido_musical}}" == 1){
          $("#oido_musical").val('1');  
          $("#oido-switch").attr("checked", true);}

          if("{{$examen->postura}}" == 1){
          $("#postura").val('1');  
          $("#postura-switch").attr("checked", true);}

          if("{{$examen->respeto}}" == 1){
          $("#respeto").val('1');  
          $("#respeto-switch").attr("checked", true);}

          if("{{$examen->elasticidad}}" == 1){
          $("#elasticidad").val('1');  
          $("#elasticidad-switch").attr("checked", true);}

          if("{{$examen->complejidad_de_movimientos}}" == 1){
          $("#complejidad_de_movimientos").val('1');  
          $("#complejidad-switch").attr("checked", true);}

          if("{{$examen->asistencia}}" == 1){
          $("#asistencia").val('1');  
          $("#asistencia-switch").attr("checked", true);}

          if("{{$examen->estilo}}" == 1){
          $("#estilo").val('1');  
          $("#estilo-switch").attr("checked", true);}   
    });

    $('#modalNombre-Examen').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var nombre=$("#examen-nombre").data('valor');
       $("#nombre").val(nombre); 
    })

    $('#modalDescripcion-Examen').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var descripcion=$("#examen-descripcion").data('valor');
       $("#descripcion").val(descripcion);
    })

    $('#modalFecha-Examen').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#fecha").val($("#examen-fecha").text()); 
    })
    $('#modalFechaProxima-Examen').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#proxima_fecha").val($("#examen-proxima_fecha").text()); 
    })

    $('#modalInstructor-Examen').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#instructor option:selected").val($("#examen-instructor").text()); 
    })

    $('#modalGeneros').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#genero option:selected").val($("#examen-generos").text()); 
    })

    $('#modalTiposDeEvaluacion').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#tipos_de_evaluacion option:selected").val($("#examen-tipos_de_evaluacion").data('valor')); 
    })

    $('#modalTiposDeEvaluacion').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var tipo=$("#examen-tipos_de_evaluacion").data('valor');
      if(tipo=="1"){
        $("#evaluacion").prop("checked", true);
      }else if(tipo=="2"){
        $("#clase").prop("checked", true);
      }else if(tipo=="3"){
        $("#casting").prop("checked", true);
      }else{
        $("#otros").prop("checked", true);
      }
      
    })

    $('#modalClaseGrupal-Examen').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var grupal=$("#examen-boolean_grupal").data('valor');
      if(grupal=="0"){
        $("#general").prop("checked", true);
      }else{
        $("#clase_grupal").prop("checked", true);
      }
      
    })

    $("#tiempos-switch").on('change', function(){
          if ($("#tiempos-switch").is(":checked")){
            $("#tiempos_musicales").val('1');
          }else{
            $("#tiempos_musicales").val('0');
          }
          console.log($("#tiempos_musicales").val());     
        });

      $("#compromiso-switch").on('change', function(){
          if ($("#compromiso-switch").is(":checked")){
            $("#compromiso").val('1');
          }else{
            $("#compromiso").val('0');
          }     
        });

      $("#condicion-switch").on('change', function(){
          if ($("#condicion-switch").is(":checked")){
            $("#condicion").val('1');
          }else{
            $("#condicion").val('0');
          }     
        });

      $("#habilidades-switch").on('change', function(){
          if ($("#habilidades-switch").is(":checked")){
            $("#habilidades").val('1');
          }else{
            $("#habilidades").val('0');
          }     
        });

      $("#disciplina-switch").on('change', function(){
          if ($("#disciplina-switch").is(":checked")){
            $("#disciplina").val('1');
          }else{
            $("#disciplina").val('0');
          }     
        });

      $("#expresion-corporal-switch").on('change', function(){
          if ($("#expresion-corporal-switch").is(":checked")){
            $("#expresion_corporal").val('1');
          }else{
            $("#expresion_corporal").val('0');
          }     
        });

      $("#expresion-facial-switch").on('change', function(){
          if ($("#expresion-facial-switch").is(":checked")){
            $("#expresion_facial").val('1');
          }else{
            $("#expresion_facial").val('0');
          }     
        });

      $("#destreza-switch").on('change', function(){
          if ($("#destreza-switch").is(":checked")){
            $("#destreza").val('1');
          }else{
            $("#destreza").val('0');
          }     
        });

      $("#dedicacion-switch").on('change', function(){
          if ($("#dedicacion-switch").is(":checked")){
            $("#dedicacion").val('1');
          }else{
            $("#dedicacion").val('0');
          }     
        });

      $("#oido-switch").on('change', function(){
          if ($("#oido-switch").is(":checked")){
            $("#oido_musical").val('1');
          }else{
            $("#oido_musical").val('0');
          }     
        });

      $("#postura-switch").on('change', function(){
          if ($("#postura-switch").is(":checked")){
            $("#postura").val('1');
          }else{
            $("#postura").val('0');
          }     
        });

      $("#respeto-switch").on('change', function(){
          if ($("#respeto-switch").is(":checked")){
            $("#respeto").val('1');
          }else{
            $("#respeto").val('0');
          }     
        });

      $("#elasticidad-switch").on('change', function(){
          if ($("#elasticidad-switch").is(":checked")){
            $("#elasticidad").val('1');
          }else{
            $("#elasticidad").val('0');
          }     
        });

      $("#complejidad-switch").on('change', function(){
          if ($("#complejidad-switch").is(":checked")){
            $("#complejidad_de_movimientos").val('1');
          }else{
            $("#complejidad_de_movimientos").val('0');
          }     
        });

      $("#asistencia-switch").on('change', function(){
          if ($("#asistencia-switch").is(":checked")){
            $("#asistencia").val('1');
          }else{
            $("#asistencia").val('0');
          }     
        });

      $("#estilo-switch").on('change', function(){
          if ($("#estilo-switch").is(":checked")){
            $("#estilo").val('1');
          }else{
            $("#estilo").val('0');
          }     
        });

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
          if(c.name=='boolean_grupal'){
            if(c.value=='0'){              
              var valor='General </span>';                              
            }else if(c.value=='1'){
              var valor='Clase Grupal </span>';
            }
            $("#examen-"+c.name).data('valor',c.value);
            $("#examen-"+c.name).html(valor);
          }else if(c.name=='instructor_id' || c.name=='tipo'){
            
            expresion = "#"+c.name+ " option[value="+c.value+"]";
            texto = $(expresion).text();
            
            $("#examen-"+c.name).text(texto);
            //$("#alumno-"+c.name).text(c.value.substr(0, 30));
          }else if(c.name=='descripcion'){
             $("#examen-"+c.name).data('valor',c.value);
             $("#examen-"+c.name).html(c.value.substr(0, 30) + "...");
            //$("#alumno-"+c.name).text(c.value.substr(0, 30));
          }else if(c.name=='nombre'){
             $("#examen-"+c.name).data('valor',c.value);
             $("#examen-"+c.name).html(c.value.substr(0, 30) + "...");
            //$("#alumno-"+c.name).text(c.value.substr(0, 30));
          }else if(c.name=='genero'){
            $("#examen-"+c.name).data('valor',c.value);
            $("#examen-"+c.name).html(c.value.substr(0, 30) + "...");

          }else{
            $("#examen-"+c.name).text(c.value);
          }

          $("#estatus-"+c.name).removeClass('c-amarillo');
          $("#estatus-"+c.name).addClass('c-verde');
        });
      }

      var t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        bPaginate: false,
        bInfo:false,
        bFilter:false,
        pageLength: 25,   
        order: [[0, 'desc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
        },
        language: {
                        processing:     "Procesando ...",
                        search:         "Buscar:",
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

              var route = route_edit;
                  var token = $('input:hidden[name=_token]').val();
                  var datos = '&item_nuevo='+ $('#item_nuevo').val()+'&id='+$('#id').val(); 
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

                            var item_nuevo = respuesta.item_nuevo;

                            var rowId=respuesta.id;
                            var rowNode=t.row.add( [
                            ''+item_nuevo+'',
                            '<i class="zmdi zmdi-delete f-20 p-r-10"></i>'
                            ] ).draw(false).node();
                            $( rowNode )
                            .attr('id',rowId)
                            .addClass('seleccion');

                          }else{
                            var nTitle="Ups! ";
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                            var nType = 'danger';
                          }                       
                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
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
                        //   if (typeof msj.responseJSON === "undefined") {
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
                          $("#add").removeAttr("disabled");
                          $("#add").css({
                            "opacity": ("1")
                          });
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

$('#tablelistar tbody').on( 'click', 'i.zmdi-delete', function () {
                  var padre=$(this).parents('tr');
                  var token = $('input:hidden[name=_token]').val();
                  var id = $(this).closest('tr').attr('id');
                        $.ajax({
                             url: route_eliminar_item+"/"+id,
                             headers: {'X-CSRF-TOKEN': token},
                             type: 'POST',
                             dataType: 'json',                
                            success: function (data) {
                              if(data.status=='OK'){

                                                                            
                              }else{
                                swal(
                                  'Solicitud no procesada',
                                  'Ha ocurrido un error, intente nuevamente por favor',
                                  'error'
                                );
                              }
                            },
                            error:function (xhr, ajaxOptions, thrownError){
                              swal('Solicitud no procesada','Ha ocurrido un error, intente nuevamente por favor','error');
                            }
                          })

                        t.row( $(this).parents('tr') )
                                .remove()
                                .draw();   

                          
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
                id = this.id;
                swal({   
                    title: "Desea eliminar el examen",   
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
         var route = route_eliminar + id;
         var token = $('input:hidden[name=_token]').val();
                
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

      $('input[name="boolean_grupal"]').on('change', function(){
          if ($(this).val()=='0') {
                $('.clase_grupal').hide();
          } else  {
                $('.clase_grupal').show();
          }
       });
    
   </script> 

   <!--<script src="{{url('/')}}/assets/js/script/alumno-planilla.js"></script>-->        
		
@stop
