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
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Examen<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
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
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Examen<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
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
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Examen<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_fecha_examen" id="edit_fecha_examen"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group fg-line">
                                    <label for="apellido">Fecha del Examen</label>
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

            <!--
              BEGIN
              MODAL EDITAR INSTRUCTOR
            -->                
            <div class="modal fade" id="modalInstructor-Examen" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Examen<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
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
                                        @foreach ( $instructores as $instructor )
                                        <option value = "{!! $instructor['id'] !!}">{!! $instructor['nombre'] !!} {!! $instructor['apellido'] !!}</option>
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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_instructor_examen" data-update="instructor" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <!-- END -->  

            <div class="modal fade" id="modalItems-Examen" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title bg-gris-oscuro">Editar Examen<button type="button" data-dismiss="modal" class="close c-blanco f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div class="modal-body">
                        <div class="row p-l-10 p-r-10">
                              <div class="panel-body">
                                      

                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-16 f-700">Tiempos musicales</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <li id="switch" type="button" data-toggle="tooltip" data-placement="bottom" title="" >
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
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="condiciones-switch" type="checkbox" hidden="hidden">
                                          <label for="condiciones-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </li>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-16 f-700">Habilidades</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <li id="switch" type="button" data-toggle="tooltip" data-placement="bottom" title="" >
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
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="expresion-switch" type="checkbox" hidden="hidden">
                                          <label for="expresion-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </li>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-16 f-700">Alergia</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <li id="switch" type="button" data-toggle="tooltip" data-placement="bottom" title="" >
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="alergia-switch" type="checkbox" hidden="hidden">
                                          <label for="alergia-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </li>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-16 f-700">Destreza</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <li id="switch" type="button" data-toggle="tooltip" data-placement="bottom" title="" >
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
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="estilo-switch" type="checkbox" hidden="hidden">
                                          <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </li>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
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

                                        <a class="btn-blanco m-r-5 f-16 guardar" id="guardar" href="#" data-formulario="edit_instructor_examen" data-update="instructor" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                                      </div>
                                  </div></form>
                        

                        </div>
                        </div>
                    </div>
                </div>
            </div>          
    
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                       <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/especiales/examenes" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección de Examen</a>
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
                                                <h2 class="ca-main-planilla">Vista Examen</h2>
                                                <h3 class="ca-sub-planilla">Personaliza el campo examen</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>

                                <div class="col-sm-12 text-center"> 

                                  <br></br>

                                  <span class="f-16 f-700">Acciones</span>

                                  <hr></hr>
                                  
                                  <a class="" href="{{url('/')}}/especiales/examenes/evaluar/{{$examen->id}}"><i class="icon_a icon_a-examen f-20 m-r-10 boton red sa-warning" name="Evaluar" data-original-title="Evaluar" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
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
                              <p class="text-center opaco-0-8 f-22">Datos del Examen</p>
                          </div>

                          <div class="col-sm-12">
                           <table class="table table-striped table-bordered">
                            <tr class="detalle" data-toggle="modal" href="#modalNombre-Examen">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-nombre" class="zmdi {{ empty($examen->nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-examen f-22"></i> </span>
                               <span class="f-14"> Nombre del Examen </span>
                             </td>
                             <td id="examen-nombre" class="f-14 m-l-15" data-valor="{{$examen->nombre}}" ><span id="examen-nombre"><span>{{ str_limit($examen->nombre, $limit = 30, $end = '...') }}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                              <tr class="detalle" data-toggle="modal" href="#modalDescripcion-Examen">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-descripcion" class="zmdi {{ empty($examen->descripcion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b-cuentales-historia f-22"></i> </span>
                               <span class="f-14"> Describe tu Examen </span>
                             </td>
                             <td id="examen-descripcion" class="f-14 m-l-15" data-valor="{{$examen->descripcion}}" ><span id="examen-descripcion"><span>{{ str_limit($examen->descripcion, $limit = 30, $end = '...') }}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalFecha-Examen">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-fecha" class="zmdi {{ empty($examen->fecha) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-calendar-check f-22"></i> </span>
                               <span class="f-14"> Fecha del Examen  </span>
                             </td>
                             <td class="f-14 m-l-15"> <span id="examen-fecha">{{$examen->fecha}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
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

    $('#modalInstructor-Examen').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#instructor option:selected").val($("#examen-instructor").text()); 
    })

    function limpiarMensaje(){
        var campo = ["nombre", "descripcion", "fecha", "instructor_id"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
        console.log(merror);
        var campo = ["nombre", "descripcion", "fecha", "instructor_id"];
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
          if(c.name=='sexo'){
            if(c.value=='M'){              
              var valor='<i class="zmdi zmdi-male f-25 c-azul"></i> </span>';                              
            }else if(c.value=='F'){
              var valor='<i class="zmdi zmdi-female f-25 c-rosado"></i> </span>';
            }
            $("#examen-"+c.name).data('valor',c.value);
            $("#examen-"+c.name).html(valor);
          }else if(c.name=='instructor_id'){
            
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
          }else{
            $("#examen-"+c.name).text(c.value);
          }

          $("#estatus-"+c.name).removeClass('c-amarillo');
          $("#estatus-"+c.name).addClass('c-verde');
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
                 $(".procesando").removeClass('show');
                 $(".procesando").addClass('hidden');
                 $(".guardar").removeAttr("disabled");
                 finprocesado();
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
    
   </script> 

   <!--<script src="{{url('/')}}/assets/js/script/alumno-planilla.js"></script>-->        
		
@stop
