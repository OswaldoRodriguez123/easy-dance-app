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

            <!--
              BEGIN
              MODAL EDITAR FECHA INICIO
            -->     
            <div class="modal fade" id="modalFecha-ClasePersonalizada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Fecha<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_fecha_clasepersonalizada" id="edit_fecha_clasepersonalizada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="fecha">Fecha de la Clase</label>
                                        <input type="text" class="form-control date-picker input-sm" name="fecha_inicio" id="fecha_inicio" placeholder="Ej. 00/00/0000" value="{{$clasepersonalizada->fecha_inicio}}">
                                 </div>
                                    <div class="has-error" id="error-fecha_inicio">
                                      <span >
                                          <small id="error-fecha_inicio_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$clasepersonalizada->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_fecha_clasepersonalizada" data-update="fecha" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <!-- END -->


            <!--
              BEGIN
              MODAL EDITAR NIVEL DE BAILE
            -->    
            <div class="modal fade" id="modalAlumno-ClasePersonalizada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Alumno<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_alumno_clasepersonalizada" id="edit_alumno_clasepersonalizada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="alumno">Alumno</label>
                                    <div class="select">
                                        <select class="form-control" id="alumno_id" name="alumno_id">
                                        @foreach ( $alumno as $alumnos )
                                        <option value = "{!! $alumnos['id'] !!}">{!! $alumnos->nombre !!} {!! $alumnos->apellido !!}</option>
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

                               <div class="clearfix"></div> 

                               <input type="hidden" name="id" value="{{$clasepersonalizada->id}}"></input>
                               
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_alumno_clasepersonalizada" data-update="alumno" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <!-- END  -->


            <!--
              BEGIN
              MODAL EDITAR HORA INICIO
            -->                
            <div class="modal fade" id="modalHorario-ClasePersonalizada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Hora de Inicio<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_horario_clasepersonalizada" id="edit_horario_clasepersonalizada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="hora_inicio">Hora de Inicio</label>
                                    <input type="text" class="form-control time-picker input-sm" name="hora_inicio" id="hora_inicio" placeholder="Ej. 00:00">
                                 </div>
                                 <div class="form-group fg-line">
                                    <label for="hora_final">Hora Final</label>
                                    <input type="text" class="form-control time-picker input-sm" name="hora_final" id="hora_final" placeholder="Ej. 00:00">
                                 </div>                                 
                                 <div class="has-error" id="error-horario">
                                      <span >
                                          <small class="help-block error-span" id="error-horario_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 


                               <input type="hidden" name="id" value="{{$clasepersonalizada->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_horario_clasepersonalizada" data-update="horario" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <!-- END -->

            <!--
              BEGIN
              MODAL EDITAR INSTRUCTOR
            -->                
            <div class="modal fade" id="modalInstructor-ClasePersonalizada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Instructor<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_instructor_clasepersonalizada" id="edit_instructor_clasepersonalizada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group fg-line">
                                    <label for="instructores">Instructores</label>

                                      <div class="select">
                                        <select class="form-control" id="instructor_id" name="instructor_id">
                                        @foreach ( $instructor as $instructores )
                                        <option value = "{!! $instructores['id'] !!}">{!! $instructores['nombre'] !!} {!! $instructores['apellido'] !!}</option>
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

                               <input type="hidden" name="id" value="{{$clasepersonalizada->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_instructor_clasepersonalizada" data-update="instructor" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <!-- END -->            

            <!--
              BEGIN
              MODAL EDITAR ESPECIALIDADES
            -->     
            <div class="modal fade" id="modalEspecialidades-ClasePersonalizada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Especialidad<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_especialidades_clasepersonalizada" id="edit_especialidades_clasepersonalizada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Especialidades</label>

                                      <div class="select">
                                          <select class="form-control" id="especialidad_id" name="especialidad_id">
                                          @foreach ( $config_especialidades as $especialidades )
                                          <option value = "{{ $especialidades['id'] }}">{{ $especialidades['nombre'] }}</option>
                                          @endforeach 
                                          </select>
                                      </div> 

                                 </div>
                                 <div class="has-error" id="error-especialidades">
                                      <span >
                                          <small class="help-block error-span" id="error-edit_especialidades_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>


                               <input type="hidden" name="id" value="{{$clasepersonalizada->id}}"></input>
                            

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_especialidades_clasepersonalizada" data-update="especialidad" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <!-- END -->



            <!--
              BEGIN
              MODAL EDITAR ESTUDIO
            -->                
            <div class="modal fade" id="modalEstudio-ClasePersonalizada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Estudio<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_estudio_clasepersonalizada" id="edit_estudio_clasepersonalizada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group fg-line">
                                    <label for="sala_estudio">Sala / Estudio</label>

                                      <div class="select">
                                        <select class="form-control" id="estudio_id" name="estudio_id">
                                        @foreach ( $config_estudios as $estudios )
                                        <option value = "{!! $estudios['id'] !!}">{!! $estudios['nombre'] !!}</option>
                                        @endforeach 
                                        </select>
                                      </div> 
                                    </div>
                                    <div class="has-error" id="error-estudio">
                                      <span >
                                          <small class="help-block error-span" id="error-estudio_mensaje" ></small>                                           
                                      </span>
                                 </div>
                               </div>

                               <input type="hidden" name="id" value="{{$clasepersonalizada->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_estudio_clasepersonalizada" data-update="estudio" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>
                              
                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <!-- END --> 

            <div class="modal fade" id="modalDescripcion-ClasePersonalizada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Personalizada<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_descripcion_clasepersonalizada" id="edit_descripcion_clasepersonalizada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="edad">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="2" placeholder="250 Caracteres"></textarea>
                                 </div>
                                 <div class="has-error" id="error-descripcion">
                                      <span >
                                          <small class="help-block error-span" id="error-descripcion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 

                               <input type="hidden" name="id" value="{{$clasepersonalizada->id}}"></input>

                               
                               
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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_descripcion_clasepersonalizada" data-update="descripcion" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalCondiciones-ClasePersonalizada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Personalizada<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_condiciones_clasepersonalizada" id="edit_condiciones_clasepersonalizada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="edad">Condiciones y Normativas</label>
                                    <textarea class="form-control" id="condiciones" name="condiciones" rows="2" placeholder="250 Caracteres"></textarea>
                                 </div>
                                 <div class="has-error" id="error-condiciones">
                                      <span >
                                          <small class="help-block error-span" id="error-condiciones_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 

                               <input type="hidden" name="id" value="{{$clasepersonalizada->id}}"></input>

                               
                               
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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_condiciones_clasepersonalizada" data-update="condiciones" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>



            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                       <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/agendar/clases-personalizadas" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección clase personalizada</a>
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
                                            <span class="ca-icon-planilla"><i class="icon_a-clase-personalizada"></i></span>
                                            <div class="ca-content">
                                                <h2 class="ca-main-planilla">Vista Clase Personalizada</h2>
                                                <h3 class="ca-sub-planilla">Personaliza el campo clase personalizada</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>

                                  <div class="col-sm-12 text-center"> 

                                  <br></br>

                                  <span class="f-16 f-700">Acciones</span>

                                  <hr></hr>
                                  
                                  <i class="zmdi zmdi-email f-20 m-r-5 boton blue sa-warning" data-original-title="Enviar Correo" data-toggle="tooltip" data-placement="bottom" title=""></i>
                                  <i class="zmdi zmdi-delete f-20 m-r-10 boton red sa-warning" id="{{$clasepersonalizada->id}}" name="eliminar" data-original-title="Eliminar" data-toggle="tooltip" data-placement="bottom" title=""></i>

                                  <br></br>
                                    
                                   
                                </div>

                                </div>                
                              </div>
                              <!--<p class="text-justify">Desde esta área Easy Dance te brinda la oportunidad de actualizar los datos creados en tu planilla de registro.</p>-->
                                    
                          </div>
                     </div>

					           	<div class="col-sm-9">

                         <div class="col-sm-12">
                              <p class="text-center opaco-0-8 f-22">Datos de la Clase Personalizada</p>
                          </div>

                          <div class="col-sm-12">
                           <table class="table table-striped table-bordered">
                            <tr class="detalle" data-toggle="modal" href="#modalAlumno-ClasePersonalizada">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-alumno_id" class="zmdi {{ empty($clasepersonalizada->alumno_nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-accounts-alt f-22"></i> </span>
                               <span class="f-14"> Alumno </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="clasepersonalizada-alumno_id"><span>{{$clasepersonalizada->alumno_nombre}} {{$clasepersonalizada->alumno_apellido}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalDescripcion-ClasePersonalizada">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-descripcion" class="zmdi {{ empty($clasepersonalizada->descripcion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b-cuentales-historia f-22"></i> </span>
                               <span class="f-14"> Descripción </span>
                             </td>
                             <td id="clasepersonalizada-descripcion" class="f-14 m-l-15 capitalize" data-valor="{{$clasepersonalizada->descripcion}}" >{{ str_limit($clasepersonalizada->descripcion, $limit = 30, $end = '...') }} <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalFecha-ClasePersonalizada">
                             <td width="50%"> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-fecha_inicio" class="zmdi  {{ empty($clasepersonalizada->fecha_inicio) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>                              
                              <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-calendar-check f-22"></i> </span>
                              <span class="f-14">Fecha de la Clase </span>
                             </td>
                             <td class="f-14 m-l-15" id="clasepersonalizada-fecha_inicio"><span id="clasepersonalizada-fecha_inicio">{{\Carbon\Carbon::createFromFormat('Y-m-d',$clasepersonalizada->fecha_inicio)->format('d/m/Y')}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalColor-ClasePersonalizada">
                               <td>
                                 <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-color_etiqueta" class="zmdi  {{ empty($clasepersonalizada->color_etiqueta) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                                 <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-invert-colors f-22"></i> </span>
                                 <span class="f-14"> Color de Etiqueta  </span>
                               </td>
                               <td  class="f-14 m-l-15" id="clasepersonalizada-color_etiqueta" >

                               
                                </td>
                              </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalEspecialidades-ClasePersonalizada">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-especialidad_id" class="zmdi  {{ empty($clasepersonalizada->especialidad_nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-especialidad f-22"></i> </span>
                               <span class="f-14"> Especialidad </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="clasepersonalizada-especialidad_id"><span id="clasepersonalizada-especialidad_id">{{$clasepersonalizada->especialidad_nombre}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalInstructor-ClasePersonalizada">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-instructor_id" class="zmdi {{ empty($instructores->nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-instructor f-22"></i> </span>
                               <span class="f-14"> Instructor  </span>
                             </td>
                             <td  class="f-14 m-l-15" id="clasepersonalizada-instructor_id" >{{$clasepersonalizada->instructor_nombre}} {{$clasepersonalizada->instructor_apellido}}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr> 
                            <tr class="detalle" data-toggle="modal" href="#modalHorario-ClasePersonalizada">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-hora_inicio" class="zmdi {{ empty($clasepersonalizada->hora_inicio) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-alarm f-22"></i> </span>
                               <span class="f-14"> Horario </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="clasepersonalizada-hora_inicio">{{$clasepersonalizada->hora_inicio}}</span> - <span id="clasepersonalizada-hora_final">{{$clasepersonalizada->hora_final}}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalEstudio-ClasePersonalizada">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-estudio_id" class="zmdi {{ empty($clasepersonalizada->estudio_nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-estudio-salon f-22"></i> </span>
                               <span class="f-14"> Estudio </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="clasepersonalizada-estudio_id"><span>{{$clasepersonalizada->estudio_nombre}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalCondiciones-ClasePersonalizada">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-condiciones" class="zmdi {{ empty($clasepersonalizada->condiciones) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b-cuentales-historia f-22"></i> </span>
                               <span class="f-14"> Condiciones y Normativas </span>
                             </td>
                             <td id="clasepersonalizada-condiciones" class="f-14 m-l-15" data-valor="{{$clasepersonalizada->condiciones}}" ><span id="clasepersonalizada-condiciones"><span>{{ str_limit($clasepersonalizada->condiciones, $limit = 30, $end = '...') }}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
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
    route_update="{{url('/')}}/agendar/clases-personalizadas/update";
    route_eliminar="{{url('/')}}/agendar/clases-personalizadas/eliminar/";
    route_principal="{{url('/')}}/agendar/clases-personalizadas";

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


    $('#modalDescripcion-ClasePersonalizada').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var descripcion=$("#clasepersonalizada-descripcion").data('valor');
       $("#descripcion").val(descripcion);
    })
    $('#modalCondiciones-ClasePersonalizada').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var condiciones=$("#clasepersonalizada-condiciones").data('valor');
       $("#condiciones").val(condiciones);
    })
    $('#modalFecha-ClasePersonalizada').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#fecha").val($("#clasepersonalizada-fecha").text()); 
    })
    $('#modalEspecialidades-ClasePersonalizada').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#especialidades option:selected").val($("#clasepersonalizada-especialidad_id").text()); 

    })
    $('#modalInstructor-ClasePersonalizada').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#instructor option:selected").val($("#clasepersonalizada-instructor").text()); 
    })

    $('#modalAlumno-ClasePersonalizada').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#alumno option:selected").val($("#clasepersonalizada-alumno").text()); 
    })

    $('#modalHorario-ClasePersonalizada').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#hora_inicio").val($("#clasepersonalizada-hora_inicio").text());
      $("#hora_final").val($("#clasepersonalizada-hora_final").text());
    })

    $('#modalEstudio-ClasePersonalizada').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#estudio option:selected").val($("#clasepersonalizada-estudio_id").text()); 
    })

    function limpiarMensaje(){
        var campo = ["nombre","fecha", "especialidades", "instructor", "alumno_id", "hora_inicio", "hora_final", "estudio"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
        console.log(merror);
        var campo = ["nombre","fecha", "especialidades", "instructor", "alumno_id", "hora_inicio", "hora_final", "estudio"];
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
          //alert(n +' '+ c.name);
          if(c.name=='sexo'){
            if(c.value=='M'){              
              var valor='<i class="zmdi zmdi-male f-25 c-azul"></i> </span>';                              
            }else if(c.value=='F'){
              var valor='<i class="zmdi zmdi-female f-25 c-rosado"></i> </span>';
            }
            $("#clasepersonalizada-"+c.name).data('valor',c.value);
            $("#clasepersonalizada-"+c.name).html(valor);
          }else if(c.name=='descripcion'){
             $("#clasepersonalizada-"+c.name).data('valor',c.value);
             $("#clasepersonalizada-"+c.name).html(c.value.toLowerCase().substr(0, 30) + "...");
            //$("#alumno-"+c.name).text(c.value.substr(0, 30));
          }else if(c.name=='condiciones'){
             $("#clasepersonalizada-"+c.name).data('valor',c.value);
             $("#clasepersonalizada-"+c.name).html(c.value.substr(0, 30) + "...");
            //$("#alumno-"+c.name).text(c.value.substr(0, 30));
          }else if(c.name=='especialidad_id' || c.name=='estudio_id' || c.name=='instructor_id' || c.name=='alumno_id'){
            
            expresion = "#"+c.name+ " option[value="+c.value+"]";
            texto = $(expresion).text();
            
            $("#clasepersonalizada-"+c.name).text(texto);
            //$("#alumno-"+c.name).text(c.value.substr(0, 30));
          }else{
            $("#clasepersonalizada-"+c.name).text(c.value);
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
                    title: "Desea eliminar la clase personalizada",   
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
