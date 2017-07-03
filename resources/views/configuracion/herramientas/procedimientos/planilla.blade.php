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
     
          
            <div class="modal fade" id="modalCoordinacion-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Procedimientos<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_coordinacion_academia" id="edit_coordinacion_academia">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <div class="modal-body">                           
                            <div class="row p-t-20 p-b-0">
                              <div class="col-sm-12">
                                <label class="m-b-10">Coordinación de Pista</label> <br>                                    
                                <div id="coordinacion-fileinput" class="fileinput fileinput-new" data-provides="fileinput">
                                    <span class="btn btn-lg btn-file m-r-10">
                                        <span id="coordinacion-fileinput-new" class="fileinput-new"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i> <br><span class="text-capitalize">Seleccionar</span></span>
                                        <span id="coordinacion-fileinput-exists" class="fileinput-exists"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i></span>
                                        <input type="file" name="coordinacion" id="coordinacion">
                                    </span>
                                    <span id="coordinacion-fileinput-filename" class="fileinput-filename"></span>
                                    <a id="coordinacion-fileinput-close" href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>                                   
                                </div>
                                <div class="has-error" id="error-coordinacion">
                                  <span >
                                    <small id="error-coordinacion_mensaje" class="help-block error-span" ></small>                      
                                  </span>
                                </div>
                              </div>
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_coordinacion_academia" data-update="coordinacion" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalEvento-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Procedimientos<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_evento_academia" id="edit_evento_academia">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <div class="modal-body">                           
                            <div class="row p-t-20 p-b-0">
                              <div class="col-sm-12">
                                <label class="m-b-10">Productora de Eventos</label> <br>                                    
                                <div id="evento-fileinput" class="fileinput fileinput-new" data-provides="fileinput">
                                    <span class="btn btn-lg btn-file m-r-10">
                                        <span id="evento-fileinput-new" class="fileinput-new"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i> <br><span class="text-capitalize">Seleccionar</span></span>
                                        <span id="evento-fileinput-exists" class="fileinput-exists"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i></span>
                                        <input type="file" name="evento" id="evento">
                                    </span>
                                    <span id="evento-fileinput-filename" class="fileinput-filename"></span>
                                    <a id="evento-fileinput-close" href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>                                   
                                </div>
                                <div class="has-error" id="error-evento">
                                  <span >
                                    <small id="error-evento_mensaje" class="help-block error-span" ></small>                      
                                  </span>
                                </div>
                              </div>
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_evento_academia" data-update="evento" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalVenta-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Procedimientos<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_venta_academia" id="edit_venta_academia">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <div class="modal-body">                           
                            <div class="row p-t-20 p-b-0">
                              <div class="col-sm-12">
                                <label class="m-b-10">Ventas</label> <br>                                    
                                <div id="venta-fileinput" class="fileinput fileinput-new" data-provides="fileinput">
                                    <span class="btn btn-lg btn-file m-r-10">
                                        <span id="venta-fileinput-new" class="fileinput-new"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i> <br><span class="text-capitalize">Seleccionar</span></span>
                                        <span id="venta-fileinput-exists" class="fileinput-exists"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i></span>
                                        <input type="file" name="venta" id="venta">
                                    </span>
                                    <span id="venta-fileinput-filename" class="fileinput-filename"></span>
                                    <a id="venta-fileinput-close" href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>                                   
                                </div>
                                <div class="has-error" id="error-venta">
                                  <span >
                                    <small id="error-venta_mensaje" class="help-block error-span" ></small>                      
                                  </span>
                                </div>
                              </div>
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_venta_academia" data-update="venta" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalSupervisor-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Procedimientos<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_supervisor_academia" id="edit_supervisor_academia">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <div class="modal-body">                           
                            <div class="row p-t-20 p-b-0">
                              <div class="col-sm-12">
                                <label class="m-b-10">Supervisor</label> <br>                                    
                                <div id="supervisor-fileinput" class="fileinput fileinput-new" data-provides="fileinput">
                                    <span class="btn btn-lg btn-file m-r-10">
                                        <span id="supervisor-fileinput-new" class="fileinput-new"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i> <br><span class="text-capitalize">Seleccionar</span></span>
                                        <span id="supervisor-fileinput-exists" class="fileinput-exists"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i></span>
                                        <input type="file" name="supervisor" id="supervisor">
                                    </span>
                                    <span id="supervisor-fileinput-filename" class="fileinput-filename"></span>
                                    <a id="supervisor-fileinput-close" href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>                                   
                                </div>
                                <div class="has-error" id="error-supervisor">
                                  <span >
                                    <small id="error-supervisor_mensaje" class="help-block error-span" ></small>                      
                                  </span>
                                </div>
                              </div>
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_supervisor_academia" data-update="supervisor" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalRecepcionista-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Procedimientos<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_recepcionista_academia" id="edit_recepcionista_academia">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <div class="modal-body">                           
                            <div class="row p-t-20 p-b-0">
                              <div class="col-sm-12">
                                <label class="m-b-10">Recepcionista</label> <br>                                    
                                <div id="recepcionista-fileinput" class="fileinput fileinput-new" data-provides="fileinput">
                                    <span class="btn btn-lg btn-file m-r-10">
                                        <span id="recepcionista-fileinput-new" class="fileinput-new"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i> <br><span class="text-capitalize">Seleccionar</span></span>
                                        <span id="recepcionista-fileinput-exists" class="fileinput-exists"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i></span>
                                        <input type="file" name="recepcionista" id="recepcionista">
                                    </span>
                                    <span id="recepcionista-fileinput-filename" class="fileinput-filename"></span>
                                    <a id="recepcionista-fileinput-close" href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>                                   
                                </div>
                                <div class="has-error" id="error-recepcionista">
                                  <span >
                                    <small id="error-recepcionista_mensaje" class="help-block error-span" ></small>                      
                                  </span>
                                </div>
                              </div>
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_recepcionista_academia" data-update="recepcionista" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalInstructor-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Procedimientos<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_instructor_academia" id="edit_instructor_academia">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <div class="modal-body">                           
                            <div class="row p-t-20 p-b-0">
                              <div class="col-sm-12">
                                <label class="m-b-10">Instructores</label> <br>                                    
                                <div id="instructor-fileinput" class="fileinput fileinput-new" data-provides="fileinput">
                                    <span class="btn btn-lg btn-file m-r-10">
                                        <span id="instructor-fileinput-new" class="fileinput-new"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i> <br><span class="text-capitalize">Seleccionar</span></span>
                                        <span id="instructor-fileinput-exists" class="fileinput-exists"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i></span>
                                        <input type="file" name="instructor" id="instructor">
                                    </span>
                                    <span id="instructor-fileinput-filename" class="fileinput-filename"></span>
                                    <a id="instructor-fileinput-close" href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>                                   
                                </div>
                                <div class="has-error" id="error-instructor">
                                  <span >
                                    <small id="error-instructor_mensaje" class="help-block error-span" ></small>                      
                                  </span>
                                </div>
                              </div>
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_instructor_academia" data-update="instructor" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalAmbiente-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Procedimientos<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_ambiente_academia" id="edit_ambiente_academia">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <div class="modal-body">                           
                            <div class="row p-t-20 p-b-0">
                              <div class="col-sm-12">
                                <label class="m-b-10">Generar Ambiente</label> <br>                                    
                                <div id="ambiente-fileinput" class="fileinput fileinput-new" data-provides="fileinput">
                                    <span class="btn btn-lg btn-file m-r-10">
                                        <span id="ambiente-fileinput-new" class="fileinput-new"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i> <br><span class="text-capitalize">Seleccionar</span></span>
                                        <span id="ambiente-fileinput-exists" class="fileinput-exists"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i></span>
                                        <input type="file" name="ambiente" id="ambiente">
                                    </span>
                                    <span id="ambiente-fileinput-filename" class="fileinput-filename"></span>
                                    <a id="ambiente-fileinput-close" href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>                                   
                                </div>
                                <div class="has-error" id="error-ambiente">
                                  <span >
                                    <small id="error-ambiente_mensaje" class="help-block error-span" ></small>                      
                                  </span>
                                </div>
                              </div>
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_ambiente_academia" data-update="ambiente" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalRol-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Procedimientos<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_rol_academia" id="edit_rol_academia">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <div class="modal-body">                           
                            <div class="row p-t-20 p-b-0">
                              <div class="col-sm-12">
                                <label class="m-b-10">Roles de la aplicación</label> <br>                                    
                                <div id="rol-fileinput" class="fileinput fileinput-new" data-provides="fileinput">
                                    <span class="btn btn-lg btn-file m-r-10">
                                        <span id="rol-fileinput-new" class="fileinput-new"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i> <br><span class="text-capitalize">Seleccionar</span></span>
                                        <span id="rol-fileinput-exists" class="fileinput-exists"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i></span>
                                        <input type="file" name="rol" id="rol">
                                    </span>
                                    <span id="rol-fileinput-filename" class="fileinput-filename"></span>
                                    <a id="rol-fileinput-close" href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>                                   
                                </div>
                                <div class="has-error" id="error-rol">
                                  <span >
                                    <small id="error-rol_mensaje" class="help-block error-span" ></small>                      
                                  </span>
                                </div>
                              </div>
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_rol_academia" data-update="rol" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalGuia-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Procedimientos<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_guia_academia" id="edit_guia_academia">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <div class="modal-body">                           
                            <div class="row p-t-20 p-b-0">
                              <div class="col-sm-12">
                                <label class="m-b-10">Guia de atención al cliente</label> <br>                                    
                                <div id="guia-fileinput" class="fileinput fileinput-new" data-provides="fileinput">
                                    <span class="btn btn-lg btn-file m-r-10">
                                        <span id="guia-fileinput-new" class="fileinput-new"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i> <br><span class="text-capitalize">Seleccionar</span></span>
                                        <span id="guia-fileinput-exists" class="fileinput-exists"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i></span>
                                        <input type="file" name="guia" id="guia">
                                    </span>
                                    <span id="guia-fileinput-filename" class="fileinput-filename"></span>
                                    <a id="guia-fileinput-close" href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>                                   
                                </div>
                                <div class="has-error" id="error-guia">
                                  <span >
                                    <small id="error-guia_mensaje" class="help-block error-span" ></small>                      
                                  </span>
                                </div>
                              </div>
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_guia_academia" data-update="guia" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalAdministrativo-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Procedimientos<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_administrativo_academia" id="edit_administrativo_academia">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <div class="modal-body">                           
                            <div class="row p-t-20 p-b-0">
                              <div class="col-sm-12">
                                <label class="m-b-10">Administrativo</label> <br>                                    
                                <div id="administrativo-fileinput" class="fileinput fileinput-new" data-provides="fileinput">
                                    <span class="btn btn-lg btn-file m-r-10">
                                        <span id="administrativo-fileinput-new" class="fileinput-new"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i> <br><span class="text-capitalize">Seleccionar</span></span>
                                        <span id="administrativo-fileinput-exists" class="fileinput-exists"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i></span>
                                        <input type="file" name="administrativo" id="administrativo">
                                    </span>
                                    <span id="administrativo-fileinput-filename" class="fileinput-filename"></span>
                                    <a id="administrativo-fileinput-close" href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>                                   
                                </div>
                                <div class="has-error" id="error-administrativo">
                                  <span >
                                    <small id="error-administrativo_mensaje" class="help-block error-span" ></small>                      
                                  </span>
                                </div>
                              </div>
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_administrativo_academia" data-update="administrativo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>


            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/configuracion/herramientas" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Herramientas</a>
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
                                            <span class="ca-icon-planilla"><i class="icon_a-tutoriales"></i></span>
                                            <div class="ca-content-planilla">
                                                <h2 class="ca-main-planilla">Manuales de Procedimientos</h2>
                                                <h3 class="ca-sub-planilla">Sección de Procedimientos</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>

          					            </div>                
          					          </div>
          					          <!--<p class="text-justify">Desde esta área Easy Dance te brinda la oportunidad de actualizar los datos creados en tu planilla de registro.</p>-->
          					                
          					      </div>
					           </div>

					           	<div class="col-sm-9">

                         <div class="col-sm-12">
                              <h4 class="text-center">Manuales de Procedimientos</h4>
                          </div>

                          <div class="col-sm-12">
                            <table class="table table-striped table-bordered">
                              <tr class="detalle" data-toggle="modal" href="#modalCoordinacion-Academia">
                                <td>
                                  <span class="m-l-10 m-r-5 f-16" ><i id="estatus-coordinacion" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                                  <span class="m-l-10 m-r-10">  <i class="icon_a-tutoriales f-22"></i> </span>
                                  <span class="f-14"> Coordinación de Pista </span>
                                </td>
                                <td class="f-14 m-l-15" > <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                              </tr>

                              <tr class="detalle" data-toggle="modal" href="#modalEvento-Academia">
                                <td>
                                  <span class="m-l-10 m-r-5 f-16" ><i id="estatus-evento" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                                  <span class="m-l-10 m-r-10">  <i class="icon_a-tutoriales f-22"></i> </span>
                                  <span class="f-14"> Productora de Eventos</span>
                                </td>
                                <td class="f-14 m-l-15" > <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                              </tr>

                              <tr class="detalle" data-toggle="modal" href="#modalVenta-Academia">
                                <td>
                                  <span class="m-l-10 m-r-5 f-16" ><i id="estatus-venta" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                                  <span class="m-l-10 m-r-10">  <i class="icon_a-tutoriales f-22"></i> </span>
                                  <span class="f-14"> Ventas</span>
                                </td>
                                <td class="f-14 m-l-15" > <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                              </tr>

                              <tr class="detalle" data-toggle="modal" href="#modalSupervisor-Academia">
                                <td>
                                  <span class="m-l-10 m-r-5 f-16" ><i id="estatus-supervisor" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                                  <span class="m-l-10 m-r-10">  <i class="icon_a-tutoriales f-22"></i> </span>
                                  <span class="f-14"> Supervisor</span>
                                </td>
                                <td class="f-14 m-l-15" > <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                              </tr>

                              <tr class="detalle" data-toggle="modal" href="#modalRecepcionista-Academia">
                                <td>
                                  <span class="m-l-10 m-r-5 f-16" ><i id="estatus-recepcionista" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                                  <span class="m-l-10 m-r-10">  <i class="icon_a-tutoriales f-22"></i> </span>
                                  <span class="f-14"> Recepcionista</span>
                                </td>
                                <td class="f-14 m-l-15" > <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                              </tr>

                              <tr class="detalle" data-toggle="modal" href="#modalInstructor-Academia">
                                <td>
                                  <span class="m-l-10 m-r-5 f-16" ><i id="estatus-instructor" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                                  <span class="m-l-10 m-r-10">  <i class="icon_a-tutoriales f-22"></i> </span>
                                  <span class="f-14"> Instructores</span>
                                </td>
                                <td class="f-14 m-l-15" > <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                              </tr>

                              <tr class="detalle" data-toggle="modal" href="#modalAdministrativo-Academia">
                                <td>
                                  <span class="m-l-10 m-r-5 f-16" ><i id="estatus-administrativo" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                                  <span class="m-l-10 m-r-10">  <i class="icon_a-tutoriales f-22"></i> </span>
                                  <span class="f-14"> Administrativo</span>
                                </td>
                                <td class="f-14 m-l-15" > <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                              </tr>

                              <tr class="detalle" data-toggle="modal" href="#modalAmbiente-Academia">
                                <td>
                                  <span class="m-l-10 m-r-5 f-16" ><i id="estatus-ambiente" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                                  <span class="m-l-10 m-r-10">  <i class="icon_a-tutoriales f-22"></i> </span>
                                  <span class="f-14"> Generar Ambiente</span>
                                </td>
                                <td class="f-14 m-l-15" > <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                              </tr>

                              <tr class="detalle" data-toggle="modal" href="#modalRol-Academia">
                                <td>
                                  <span class="m-l-10 m-r-5 f-16" ><i id="estatus-rol" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                                  <span class="m-l-10 m-r-10">  <i class="icon_a-tutoriales f-22"></i> </span>
                                  <span class="f-14"> Roles de la aplicación</span>
                                </td>
                                <td class="f-14 m-l-15" > <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                              </tr>

                              <tr class="detalle" data-toggle="modal" href="#modalGuia-Academia">
                                <td>
                                  <span class="m-l-10 m-r-5 f-16" ><i id="estatus-guia" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                                  <span class="m-l-10 m-r-10">  <i class="icon_a-tutoriales f-22"></i> </span>
                                  <span class="f-14"> Guia de atención al cliente</span>
                                </td>
                                <td class="f-14 m-l-15" > <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                              </tr>

                            </table>
                          </div>
                          
                          
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

    route_update="{{url('/')}}/configuracion/academia/procedimientos/update";
    contenido = true;

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


      function errores(merror){
        console.log(merror);
        var campo = ["correo", "telefono", "celular", "direccion"];
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
            $("#academia-"+c.name).data('valor',c.value);
            $("#academia-"+c.name).html(valor);
          }else{
            $("#academia-"+c.name).text(c.value);
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
        procesando();
        form=$(this).data('formulario');
        update=$(this).data('update');
        var token = $('input:hidden[name=_token]').val();
        var datos = new FormData();
        var variable = document.getElementById(''+update+'');

        if(variable.files[0])
        {
          datos.append(''+update+'', variable.files[0]);
        }

        var datos_array=  $( "#"+form ).serializeArray();
        var route = route_update+"/"+update;

        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: datos,
            processData: false,
            cache: false,
            contentType: false,   
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
                // if (typeof msj.responseJSON === "undefined") {
                //   //window.location = "{{url('/')}}/error";
                // }
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
       //finaliza aqui
    })

    $(".dismiss").click(function(){
      $('.modal').modal('hide');
    });

    function countCharDir(val) {
        var len = val.value.length;
        if (len >= 180) {
          val.value = val.value.substring(0, 180);
        } else {
          $('#charNumDir').text(180 - len);
        }
      };

   </script> 

   <!--<script src="{{url('/')}}/assets/js/script/alumno-planilla.js"></script>-->        
		
@stop
