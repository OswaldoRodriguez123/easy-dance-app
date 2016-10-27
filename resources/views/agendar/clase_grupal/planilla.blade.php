@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/farbtastic/farbtastic.css" rel="stylesheet">

<link href="{{url('/')}}/assets/css/easy_dance_ico_5.css" rel="stylesheet">

@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/moment.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="{{url('/')}}/assets/vendors/farbtastic/farbtastic.min.js"></script>
@stop

@section('content')

            <!--
              BEGIN
              MODAL EDITAR NOMBRE
            -->     
            <div class="modal fade" id="modalNombre-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_nombre_clasegrupal" id="edit_nombre_clasegrupal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                    <label for="fecha_inicio">Nombre</label>
                                    <div class="select">
                                          <select class="form-control" id="clase_grupal_id" name="clase_grupal_id">
                                          @foreach ( $config_clases_grupales as $clases_grupales )
                                          <option value = "{{ $clases_grupales['id'] }}">{{ $clases_grupales['nombre'] }}</option>
                                          @endforeach 
                                          </select>
                                      </div> 
                                    </div>
                                    <div class="has-error" id="error-nombre">
                                      <span >
                                          <small id="error-nombre_mensaje" class="help-block error-span" ></small>                                           
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

                             <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_nombre_clasegrupal" data-update="nombre" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <!-- END -->

            <div class="modal fade" id="modalImagen-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_imagen_clasegrupal" id="edit_imagen_clasegrupal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group text-center">
                                    <div class="form-group fg-line">
                                        <label for="id">Cargar Imagen</label>
                                        <div class="clearfix p-b-15"></div>
                                        <input type="hidden" name="imageBase64" id="imageBase64">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div id="imagena" class="fileinput-preview thumbnail" data-trigger="fileinput" style="width:450px">
                                          @if($clasegrupal->imagen)
                                          <img src="{{url('/')}}/assets/uploads/clase_grupal/{{$clasegrupal->imagen}}" style="line-height: 150px;">
                                          @endif
                                        </div>
                                        <div>
                                            <span class="btn btn-info btn-file">
                                                <span class="fileinput-new">Seleccionar Imagen</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="imagen" id="imagen" >
                                            </span>
                                            <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="has-error" id="error-imagen">
                                      <span >
                                          <small id="error-imagen_mensaje" class="help-block error-span" ></small>                                           
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

                              <a class="btn-morado m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_imagen_clasegrupal" data-update="imagen" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <!--
              BEGIN
              MODAL EDITAR FECHA INICIO
            -->     
            <div class="modal fade" id="modalFecha-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_fecha_clasegrupal" id="edit_fecha_clasegrupal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                    <label for="fecha_inicio">Fecha</label>
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_fecha_clasegrupal" data-update="fecha" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <!-- END -->

            <!--
              BEGIN
              MODAL EDITAR FECHA INICIO
            -->     
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
                                    <label for="fecha_inicio_preferencial">Fecha de próximo pago</label>
                                    <input type="text" class="form-control date-picker input-sm" name="fecha_inicio_preferencial" id="fecha_inicio_preferencial" placeholder="Ej. 00/00/0000" value="{{$clasegrupal->fecha_inicio_preferencial}}">
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_fecha_cobro_clasegrupal" data-update="fechacobro" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <!-- END

            <!--
              BEGIN
              MODAL EDITAR ESPECIALIDADES
            -->     
            <div class="modal fade" id="modalEspecialidades-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_especialidades_clasegrupal" id="edit_especialidades_clasegrupal"  >
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
                                          <small class="help-block error-span" id="error-edit_especialidades_clasegrupal" ></small>                                
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_especialidades_clasegrupal" data-update="especialidad" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

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
            <div class="modal fade" id="modalInstructor-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_instructor_clasegrupal" id="edit_instructor_clasegrupal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group fg-line">
                                    <label for="apellido">Instructores</label>

                                      <div class="select">
                                        <select class="form-control" id="instructor_id" name="instructor_id">

                                        @foreach ( $instructores as $instructor )
                                        <option value = "{{$instructor['id'] }}">{{$instructor['nombre'] }} {{$instructor['apellido'] }}</option>
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


                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_instructor_clasegrupal" data-update="instructor" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

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
            <div class="modal fade" id="modalNivelBaile-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_nivel_baile_clasegrupal" id="edit_nivel_baile_clasegrupal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="correo">Nivel de Baile</label>
                                    <div class="select">
                                        <select class="form-control" id="nivel_baile_id" name="nivel_baile_id">
                                        @foreach ( $config_niveles as $niveles )
                                        <option value = "{!! $niveles['id'] !!}">{!! $niveles['nombre'] !!}</option>
                                        @endforeach 
                                        </select>
                                      </div> 
                                 </div>
                                 <div class="has-error" id="error-nivel_baile">
                                      <span >
                                          <small class="help-block error-span" id="error-nivel_baile_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 

                               <input type="hidden" name="id" value="{{$clasegrupal->id}}"></input>

                               
                               
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_nivel_baile_clasegrupal" data-update="nivel_baile" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

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
            <div class="modal fade" id="modalHorario-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_horario_clasegrupal" id="edit_horario_clasegrupal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="telefono">Hora de Inicio</label>
                                    <input type="text" class="form-control time-picker input-sm" name="hora_inicio" id="hora_inicio" placeholder="Ej. 00:00">
                                 </div>
                                  <div class="has-error" id="error-hora_inicio">
                                      <span >
                                          <small class="help-block error-span" id="error-hora_inicio_mensaje" ></small>                                
                                      </span>
                                  </div>
                                 <div class="form-group fg-line">
                                    <label for="telefono">Hora Final</label>
                                    <input type="text" class="form-control time-picker input-sm" name="hora_final" id="hora_final" placeholder="Ej. 00:00">
                                 </div>                                 
                                 <div class="has-error" id="error-hora_final">
                                      <span >
                                          <small class="help-block error-span" id="error-hora_final_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 


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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_horario_clasegrupal" data-update="horario" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

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
            <div class="modal fade" id="modalEstudio-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_estudio_clasegrupal" id="edit_estudio_clasegrupal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group fg-line">
                                    <label for="apellido">Sala / Estudio</label>

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_estudio_clasegrupal" data-update="estudio" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>
                              
                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <!-- END --> 

            <div class="modal fade" id="modalLink-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_link_clasegrupal" id="edit_link_clasegrupal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">

                           <div class="col-sm-12">
                                <div class="form-group">
                                 <div class="form-group fg-line">
                                    <label>Titulo del Video Promocional</label>
                                    <br></br>
                                    <input type="text" class="form-control input-sm" name="titulo_video" id="titulo_video" placeholder="Ingresa el titulo" value="{{$clasegrupal->titulo_video}}">
                                 </div>
                                    <div class="has-error" id="error-titulo_video">
                                      <span >
                                          <small id="error-titulo_video_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                                <div class="clearfix p-b-35"></div>
                               <div class="col-sm-12">
                                <div class="form-group">
                                 <div class="form-group fg-line">
                                    <label>Link Promocional</label>
                                    <br></br>
                                    <input type="text" class="form-control caja input-sm" name="link_video" id="link_video" placeholder="Ingresa la url">
                                 </div>
                                    <div class="has-error" id="error-link_video">
                                      <span >
                                          <small id="error-link_video_mensaje" class="help-block error-span" ></small>                                           
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
                              
                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_link_clasegrupal" data-update="video" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalMostrar-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_mostrar_clasegrupal" id="edit_mostrar_clasegrupal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                              <div class="col-sm-12">
                                       <div class="form-group fg-line ">
                                          <label for="">Promocionar en la web</label id="id-boolean_promocionar"> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Mostrar esta clase grupal en la web" title="" data-original-title="Ayuda"></i>
                                          
                                          <br></br>
                                          <input type="text" id="boolean_promocionar" name="boolean_promocionar" value="" hidden="hidden">
                                          <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="promocionar" type="checkbox">
                                            
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                          </div>
                                          
                                       </div>
                                       <div class="has-error" id="error-boolean_promocionar">
                                            <span >
                                                <small class="help-block error-span" id="error-boolean_promocionar_mensaje" ></small>                                           
                                            </span>
                                        </div>
                                     </div>

                                     <div class="col-sm-12">
                                       <div class="form-group fg-line ">
                                          <label for="">Dias de prorroga</label id="id-dias_prorroga"> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la cantidad de dias de prorroga que tendra la clase grupal en la web luego de iniciar" title="" data-original-title="Ayuda"></i>
                                          
                                          <br></br>
                                          <input type="text" class="form-control input-sm input-mask" name="dias_prorroga" id="dias_prorroga" data-mask="000" placeholder="Ej. 7" value="{{$clasegrupal->dias_prorroga}}">
                                       </div>
                                       <div class="has-error" id="error-dias_prorroga">
                                            <span >
                                                <small class="help-block error-span" id="error-dias_prorroga_mensaje" ></small>                                           
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_mostrar_clasegrupal" data-update="mostrar" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalCupo-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_cupo_clasegrupal" id="edit_cupo_clasegrupal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Minimo</label>
                                    <input type="text" class="form-control input-sm input-mask" name="cupo_minimo" id="cupo_minimo" data-mask="000" placeholder="Minimo">
                                 </div>
                                 <div class="has-error" id="error-cupo_minimo">
                                      <span >
                                          <small class="help-block error-span" id="error-cupo_minimo_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 


                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="apellido">Maximo</label>
                                    <input type="text" class="form-control input-sm input-mask" name="cupo_maximo" id="cupo_maximo" data-mask="000" placeholder="Maximo">
                                 </div>
                                 <div class="has-error" id="error-cupo_maximo">
                                      <span >
                                          <small class="help-block error-span" id="error-cupo_maximo_mensaje"  ></small>                                           
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_cupo_clasegrupal" data-update="cupo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalCupoOnline-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_cupo_online_clasegrupal" id="edit_cupo_online_clasegrupal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="apellido">Cantidad de cupos para reserva online </label>
                                    <input type="text" class="form-control input-sm input-mask" name="cupo_reservacion" id="cupo_reservacion" data-mask="000" placeholder="Ej. 20">
                                 </div>
                                 <div class="has-error" id="error-cupo_reservacion">
                                      <span >
                                          <small class="help-block error-span" id="error-cupo_reservacion_mensaje"  ></small>                                           
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_cupo_online_clasegrupal" data-update="cuporeservacion" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalEtiqueta-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_etiqueta_clasegrupal" id="edit_etiqueta_clasegrupal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="cp-container">
                                        <label for="fecha_cobro" id="id-color_etiqueta">Color de etiqueta</label>
                                        <div class="input-group form-group">

                                            <span class="input-group-addon"><i class="zmdi zmdi-invert-colors f-22"></i></span>
                                            <div class="fg-line dropdown">
                                                <input type="text" name="color_etiqueta" id="color_etiqueta" class="form-control cp-value proceso pointer" value="{{$clasegrupal->color_etiqueta}}" data-toggle="dropdown">
                                                    
                                                <div class="dropdown-menu">
                                                    <div class="color-picker" data-cp-default="{{$clasegrupal->color_etiqueta}}"></div>
                                                </div>
                                                
                                                <i class="cp-value"></i>
                                            </div>
                                            <div class="has-error" id="error-color_etiqueta">
                                                <span >
                                                      <small class="help-block error-span" id="error-color_etiqueta_mensaje" ></small>                                           
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                               </div>

                               <div class="clearfix"></div> 

                               <input type="hidden" name="id" value="{{$clasegrupal->id}}"></input>

                               
                               
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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_etiqueta_clasegrupal" data-update="etiqueta" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalCantidad-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_cantidad_clasegrupal" id="edit_cantidad_clasegrupal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Hombres</label>
                                    <input type="text" class="form-control input-sm input-mask" name="cantidad_hombres" id="cantidad_hombres" data-mask="000" placeholder="Minimo">
                                 </div>
                                 <div class="has-error" id="error-cantidad_hombres">
                                      <span >
                                          <small class="help-block error-span" id="error-cantidad_hombres_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 


                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="apellido">Mujeres</label>
                                    <input type="text" class="form-control input-sm input-mask" name="cantidad_mujeres" id="cantidad_mujeres" data-mask="000" placeholder="Maximo">
                                 </div>
                                 <div class="has-error" id="error-cantidad_mujeres">
                                      <span >
                                          <small class="help-block error-span" id="error-cantidad_mujeres_mensaje"  ></small>                                           
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_cantidad_clasegrupal" data-update="cantidad" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

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

                              <a class="btn-blanco m-r-5 f-12 trasladar" href="#">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalMultihorario-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="form_multihorario" id="form_multihorario"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="table-responsive row">
                                   <div class="col-md-12">
                                    <table class="table table-striped table-bordered text-center " id="tablehorario" >
                                    <thead>
                                        <tr>
                                          <th class="text-center" data-column-id="id" data-type="numeric">Instructor</th>
                                          <th class="text-center" data-column-id="sexo">Especialidad</th>
                                          <th class="text-center" data-column-id="sexo">Estudio</th>
                                          <th class="text-center" data-column-id="nombre" data-order="desc">Día</th>
                                          <th class="text-center" data-column-id="estatu_c" data-order="desc">Hora Inicio</th>
                                          <th class="text-center" data-column-id="estatu_e" data-order="desc">Hora Final</th>
                                          <!-- <th class="text-center" data-column-id="operacion" data-order="desc" >Acción</th> -->
                                      </tr>
                                    </thead>
                                    <tbody>

                                      @foreach($arrayHorario as $horario)
                                      
                                        <tr id="$horario['id']}}" class="odd seleccion text-center" role="row">
                                          <td onclick="previa(this)" class="text-center">
                                            {{$horario['instructor']}}
                                          </td>
                                          <td onclick="previa(this)" class="text-center">
                                            {{$horario['especialidad']}}
                                          </td>
                                          <td onclick="previa(this)" class="text-center">
                                            {{$horario['estudio']}}
                                          </td>
                                          <td onclick="previa(this)" class="text-center">
                                            {{$horario['dia_de_semana']}}
                                          </td>
                                          <td onclick="previa(this)" class="text-center">
                                            {{$horario['hora_inicio']}}
                                          </td>
                                          <td onclick="previa(this)" class="text-center">
                                            {{$horario['hora_final']}}
                                          </td>
                                          <!-- <td class="text-center" width="50">
                                          <i class="zmdi zmdi-delete f-20 p-r-10"></i>
                                          </td> -->
                                        </tr>

                                      @endforeach                          
                                                                   
                                    </tbody>
                                </table>
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
                            <!-- <div class="col-sm-12">                            

                              <a class="btn-blanco m-r-5 f-12 trasladar" href="#">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div> -->
                        </div></form>
                    </div>
                </div>
            </div>

            

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                       <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/agendar/clases-grupales" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección clase grupal</a>
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
                                            <span class="ca-icon-planilla"><i class="icon_a-clases-grupales"></i></span>
                                            <div class="ca-content-planilla">
                                                <h2 class="ca-main-planilla">Vista Clase Grupal</h2>
                                                <h3 class="ca-sub-planilla">Personaliza el campo clase grupal</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>
                                  


                                  
                              <div class="col-sm-12 text-center"> 

                              <br></br>

                              <span class="f-16 f-700">Acciones</span>

                              <hr></hr>

                              
                              <a data-toggle="modal" href="#modalTrasladar-ClaseGrupal"><i class="zmdi zmdi-trending-up f-16 m-r-5 boton blue"  data-original-title="Trasladar" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                              <a href="{{url('/')}}/agendar/clases-grupales/multihorario/{{$clasegrupal->id}}"><i class="zmdi zmdi-calendar-note f-16 m-r-5 boton blue"  data-original-title="Multihorario" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                              <a href="{{url('/')}}/agendar/clases-grupales/participantes/{{$clasegrupal->id}}"><i class="icon_a-participantes f-16 m-r-5 boton blue"  data-original-title="Participantes" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                              <a href="{{url('/')}}/agendar/clases-grupales/progreso/{{$clasegrupal->id}}"><i class="icon_e-ver-progreso f-16 m-r-5 boton blue"  data-original-title="Ver Progreso" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                              <i class="zmdi zmdi-delete f-20 m-r-10 boton red sa-warning" id="{{$clasegrupal->id}}" name="eliminar" data-original-title="Eliminar" data-toggle="tooltip" data-placement="bottom" title=""></i>


                              <br></br>
                                
                              <hr></hr>

                              <br></br>

<!--                               <button type="button" class="btn btn-blanco m-r-10 f-16" id="{{$id}}" name="progreso"> Ver Progreso <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button> -->
                              
                               
                            </div>
                                </div> 
                              </div>
                              <!--<p class="text-justify">Desde esta área Easy Dance te brinda la oportunidad de actualizar los datos creados en tu planilla de registro.</p>-->
                                    
                          </div>
                     </div>

					           	<div class="col-sm-9">

                         <div class="col-sm-12">
                              <p class="text-center opaco-0-8 f-22">Datos de la Clase Grupal</p>
                          </div>

                          <div class="col-sm-12">
                           <table class="table table-striped table-bordered">
                           <tr class="detalle" data-toggle="modal" href="#modalNombre-ClaseGrupal">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-clase_grupal_id" class="zmdi  {{ empty($clasegrupal->clase_grupal_nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw""></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-accounts-alt f-22"></i> </span>
                               <span class="f-14"> Nombre </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="clasegrupal-clase_grupal_id"><span>{{$clasegrupal->clase_grupal_nombre}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalImagen-ClaseGrupal">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-imagen" class="zmdi {{ empty($clasegrupal->imagen) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-collection-folder-image zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Imagen </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="clasegrupal-imagen"><span></span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalFecha-ClaseGrupal">
                             <td width="50%"> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-fecha_inicio" class="zmdi  {{ empty($clasegrupal->fecha_inicio) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>                              
                              <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-calendar-check f-22"></i> </span>
                              <span class="f-14">Fecha Desde / Hasta</span>
                             </td>
                             <td class="f-14 m-l-15" id="clasegrupal-fecha" ><span id="clasegrupal-fecha_inicio">{{ \Carbon\Carbon::createFromFormat('Y-m-d',$clasegrupal->fecha_inicio)->format('d/m/Y')}}</span> - <span id="clasegrupal-fecha_final">{{ \Carbon\Carbon::createFromFormat('Y-m-d',$clasegrupal->fecha_final)->format('d/m/Y')}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalFechaCobro-ClaseGrupal">
                             <td width="50%"> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-fecha_inicio" class="zmdi  {{ empty($clasegrupal->fecha_inicio_preferencial) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>                              
                              <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-calendar f-22"></i> </span>
                              <span class="f-14">Fecha de próximo pago </span>
                             </td>
                             <td class="f-14 m-l-15" id="clasegrupal-fecha_inicio_preferencial"> {{ empty($clasegrupal->fecha_inicio_preferencial) ? '' :  \Carbon\Carbon::createFromFormat('Y-m-d',$clasegrupal->fecha_inicio_preferencial)->format('d/m/Y') }}<span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalCupo-ClaseGrupal">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-cupo_minimo" class="zmdi {{ empty($clasegrupal->cupo_minimo) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"><i class="zmdi zmdi-border-color zmdi-hc-fw f-18"></i></span>
                               <span class="f-14"> Cantidad de Cupos  </span>
                             </td>
                             <td  class="f-14 m-l-15"> <span id="clasegrupal-cupo_minimo">{{$clasegrupal->cupo_minimo}}</span> - <span id="clasegrupal-cupo_maximo">{{$clasegrupal->cupo_maximo}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalCupoOnline-ClaseGrupal">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-cupo_reservacion" class="zmdi {{ empty($clasegrupal->cupo_reservacion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"><i class="icon_a icon_a-reservaciones f-18"></i></span>
                               <span class="f-14"> Cantidad de cupos para reserva online  </span>
                             </td>
                             <td  class="f-14 m-l-15"> <span id="clasegrupal-cupo_reservacion">{{$clasegrupal->cupo_reservacion}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalEtiqueta-ClaseGrupal">
                               <td>
                                 <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-color_etiqueta" class="zmdi  {{ empty($clasegrupal->color_etiqueta) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                                 <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-invert-colors f-22"></i> </span>
                                 <span class="f-14"> Color de Etiqueta  </span>
                               </td>
                               <td  class="f-14 m-l-15">
                                <span id="clasegrupal-color_etiqueta">{{$clasegrupal->color_etiqueta}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span>
                               
                                </td>
                              </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalEspecialidades-ClaseGrupal">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-especialidad_id" class="zmdi  {{ empty($clasegrupal->especialidad_nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-especialidad f-22"></i> </span>
                               <span class="f-14"> Especialidad </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="clasegrupal-especialidad_id"><span>{{$clasegrupal->especialidad_nombre}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalInstructor-ClaseGrupal">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-instructor_id" class="zmdi  {{ empty($clasegrupal->instructor_nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-instructor f-22"></i> </span>
                               <span class="f-14"> Instructor  </span>
                             </td>
                             <td  class="f-14 m-l-15" id="clasegrupal-instructor_id" ><span id="clasegrupal-instructor_id">{{$clasegrupal->instructor_nombre}} {{$clasegrupal->instructor_apellido}}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                             
                            <tr class="detalle" data-toggle="modal" href="#modalNivelBaile-ClaseGrupal">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-nivel_baile_id" class="zmdi  {{ empty($clasegrupal->nivel_nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-niveles f-22"></i> </span>
                               <span class="f-14"> Nivel de Baile </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="clasegrupal-nivel_baile_id"><span>{{$clasegrupal->nivel_nombre}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalHorario-ClaseGrupal">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-hora_inicio" class="zmdi  {{ empty($clasegrupal->hora_inicio) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw""></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-alarm f-22"></i> </span>
                               <span class="f-14"> Horario </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="clasegrupal-hora_inicio">{{$clasegrupal->hora_inicio}}</span> - <span id="clasegrupal-hora_final">{{$clasegrupal->hora_final}}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalEstudio-ClaseGrupal">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-estudio_id" class="zmdi  {{ empty($clasegrupal->estudio_nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-estudio-salon f-22"></i> </span>
                               <span class="f-14"> Estudio </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="clasegrupal-estudio_id"><span>{{$clasegrupal->estudio_nombre}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalLink-ClaseGrupal">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-link_video" class="zmdi {{ empty($clasegrupal->link_video) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10">  <i class="zmdi zmdi-videocam f-22"></i> </span>
                               <span class="f-14"> Link Promocional </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="clasegrupal-link_video"><span>{{$clasegrupal->link_video}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalCantidad-ClaseGrupal">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-cantidad" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"><i class="zmdi zmdi-border-color zmdi-hc-fw f-18"></i></span>
                               <span class="f-14"> Cantidad de Participantes  </span>
                             </td>
                             <td  class="f-14 m-l-15"> <span id="clasegrupal-cantidad_hombres">{{$clasegrupal->cantidad_hombres}}</span> - <span id="clasegrupal-cantidad_mujeres">{{$clasegrupal->cantidad_mujeres}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalMostrar-ClaseGrupal">
                             <td> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-estatus" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                              <span class="m-l-10 m-r-10"> <i class="icon_a-estatus-de-clases f-20"></i> </span>
                              <span class="f-14"> Mostrar en la Web </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="clasegrupal-boolean_promocionar" data-valor="{{$clasegrupal->boolean_promocionar}}">
                               @if($clasegrupal->boolean_promocionar==1)
                                  <i class="zmdi zmdi-mood zmdi-hc-fw f-22 c-verde"></i> </span>
                               @else
                                  <i class="zmdi zmdi-mood-bad zmdi-hc-fw f-22 c-youtube"></i></span>
                               @endif
                             <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalMultihorario-ClaseGrupal">
                             <td width="50%"> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-multihorarios" class="zmdi {{ empty($arrayHorario) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>                              
                              <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-calendar f-22"></i> </span>
                              <span class="f-14">Multihorarios </span>
                             </td>
                             <td class="f-14 m-l-15" id="clasegrupal-multihorarios" ><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
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
    route_update="{{url('/')}}/agendar/clases-grupales/update";
    route_eliminar="{{url('/')}}/agendar/clases-grupales/eliminar/";
    route_principal="{{url('/')}}/agendar/clases-grupales";
    route_progreso="{{url('/')}}/agendar/clases-grupales/progreso/";
    route_trasladar="{{url('/')}}/agendar/clases-grupales/trasladar";

    $(document).ready(function(){

      if("{{$clasegrupal->boolean_promocionar}}" == 1){
        $("#boolean_promocionar").val('1');  //VALOR POR DEFECTO
        $("#promocionar").attr("checked", true); //VALOR POR DEFECTO
      }

      $("#imagen").bind("change", function() {
            //alert('algo cambio');
            
            setTimeout(function(){
              var imagen = $("#imagena img").attr('src');
              var canvas = document.createElement("canvas");
     
              var context=canvas.getContext("2d");
              var img = new Image();
              img.src = imagen;
              
              canvas.width  = img.width;
              canvas.height = img.height;

              context.drawImage(img, 0, 0);
       
              var newimage = canvas.toDataURL("image/jpeg", 0.8);
              var image64 = $("input:hidden[name=imageBase64]").val(newimage);

            },500);

        });

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

    var t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,
        //bPaginate: false, 
        bFilter:false, 
        bSort:false, 
        bInfo:false,
        order: [[0, 'asc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).attr( "onclick","previa(this)" );
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

    var h=$('#tablehorario').DataTable({
        processing: true,
        serverSide: false, 
        bPaginate: false, 
        bFilter:false, 
        bSort:false, 
        bInfo:false,
        order: [[0, 'asc']],
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

    $('#modalNombre-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#nombre").val($("#clasegrupal-clase_grupal_id").text()); 
    })
    $('#modalFechaInicio-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#fecha").val($("#clasegrupal-fecha_inicio").text() + '-' + $("#clasegrupal-fecha_final").text()); 
    })
    $('#modalFechaCobro-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#fecha_inicio_preferencial").val($("#clasegrupal-fecha_inicio_preferencial").text()); 
    })
    $('#modalEspecialidades-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#especialidades option:selected").val($("#clasegrupal-especialidad_id").text()); 

    })
    $('#modalInstructor-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#instructor option:selected").val($("#clasegrupal-instructor_id").text()); 
    })


    $('#modalNivelBaile-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#nivel_baile option:selected").val($("#clasegrupal-nivel_baile_id").text()); 
    })

    $('#modalHorario-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#hora_inicio").val($("#clasegrupal-hora_inicio").text());
      $("#hora_final").val($("#clasegrupal-hora_final").text());
    })

    $('#modalEstudio-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#estudio option:selected").val($("#clasegrupal-estudio_id").text()); 
    })

    $('#modalCupo-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#cupo_minimo").val($("#clasegrupal-cupo_minimo").text());
      $("#cupo_maximo").val($("#clasegrupal-cupo_maximo").text()); 
    })

    $('#modalCupoOnline-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#cupo_reservacion").val($("#clasegrupal-cupo_reservacion").text());
    })

    $('#modalLink-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#link_video").val($("#clasegrupal-link_video").text()); 
    })

    $('#modalCantidad-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#cantidad_hombres").val($("#clasegrupal-cantidad_hombres").text());
      $("#cantidad_mujeres").val($("#clasegrupal-cantidad_mujeres").text()); 
    })

    function limpiarMensaje(){
        var campo = ["fecha_inicio", "especialidades", "instructor", "nivel_baile", "hora_inicio", "hora_final"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
        console.log(merror);
        var campo = ["fecha_inicio", "especialidades", "instructor", "nivel_baile", "hora_inicio", "hora_final"];
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

          switch(c.name) {
            case 'sexo':
                if(c.value=='M'){              
                  var valor='<i class="zmdi zmdi-male f-25 c-azul"></i> </span>';                              
                }else if(c.value=='F'){
                  var valor='<i class="zmdi zmdi-female f-25 c-rosado"></i> </span>';
                }
                
                $("#clasegrupal-"+c.name).data('valor',c.value);
                $("#clasegrupal-"+c.name).html(valor);
                break;

            case 'nivel_baile_id':
            case 'especialidad_id':
            case 'estudio_id':
            case 'instructor_id':
            case 'clase_grupal_id':

                expresion = "#"+c.name+ " option[value="+c.value+"]";
                texto = $(expresion).text();
                
                $("#clasegrupal-"+c.name).text(texto);

                break;
            case 'fecha':

                if(n == 1)
                {
                  var tmp = c.value;
                  var fecha = tmp.split(' - ');

                  $("#clasegrupal-fecha_inicio").text(fecha[0]);
                  $("#clasegrupal-fecha_final").text(fecha[1]);
                }

                break;

                case 'boolean_promocionar':
                if(c.value==1){              
                  var valor='<i class="zmdi zmdi-mood zmdi-hc-fw f-22 c-verde"></i>';                              
                }else{
                  var valor='<i class="zmdi zmdi-mood-bad zmdi-hc-fw f-22 c-youtube"></i>';
                }

                $("#clasegrupal-"+c.name).html(valor);

                break;

            default:
                console.log("entro");
                $("#clasegrupal-"+c.name).text(c.value);
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
                // if (typeof msj.responseJSON === "undefined") {
                //           window.location = "{{url('/')}}/error";
                //         }
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
                    title: "Desea eliminar la clase grupal",   
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
                                // $("#msj-danger").fadeIn(); 
                                // var text="";
                                // console.log(msj);
                                // var merror=msj.responseJSON;
                                // text += " <i class='glyphicon glyphicon-remove'></i> Por favor verifique los datos introducidos<br>";
                                // $("#msj-error").html(text);
                                // setTimeout(function(){
                                //          $("#msj-danger").fadeOut();
                                //         }, 3000);
                                swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                                }
                });
      }

    $(".progreso").click(function(){
               
      window.location = "{{url('/')}}/agendar/clases-grupales/progreso/{{$id}}";

    });

          $("#promocionar").on('change', function(){
          if ($("#promocionar").is(":checked")){
            $("#boolean_promocionar").val('1');
          }else{
            $("#boolean_promocionar").val('0');
          }    
        });

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

   </script> 

   <!--<script src="{{url('/')}}/assets/js/script/alumno-planilla.js"></script>-->        
		
@stop
