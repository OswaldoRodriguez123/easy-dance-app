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
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/moment.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
@stop

@section('content')

<div class="modal fade" id="modalNombreEvento-Coreografia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Coreografía<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_nombre_evento_coreografia" id="edit_nombre_evento_coreografia"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="apellido">Nombre del evento </label>
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class=" icon_a-fiesta f-22"></i></span>
                                      <div class="fg-line">
                                        <div class="select">
                                          <select class="selectpicker" name="fiesta_id" id="fiesta_id" data-live-search="true">

                                            <!-- <option value="0">Sin Especificar</option> -->
                                            @foreach ( $fiestas as $fiesta )
                                              <option value = "{{ $fiesta->id }}">{{ $fiesta->nombre }}</option>
                                            @endforeach
                                          
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                 </div>
                                 <div class="has-error" id="error-fiesta_id">
                                      <span >
                                          <small class="help-block error-span" id="error-fiesta_id_mensaje"  ></small>                                           
                                      </span>
                                  </div>
                               </div>

                               <input type="hidden" name="id" value="{{$coreografia->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_nombre_evento_coreografia" data-update="nombre_evento" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalNombreCoreografia-Coreografia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Coreografía<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_nombre_coreografia_coreografia" id="edit_nombre_coreografia_coreografia"  >
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <div class="modal-body">                           
                            <div class="row p-t-20 p-b-0">
                              <div class="col-sm-12">
                                <div class="form-group fg-line">
                                    <label for="apellido">Nombre de la coreografía </label>
                                    <input type="text" class="form-control input-sm" name="nombre_coreografia" id="nombre_coreografia" placeholder="Ej. 20">
                                </div>
                                <div class="has-error" id="error-nombre_coreografia">
                                  <span >
                                    <small class="help-block error-span" id="error-nombre_coreografia_mensaje"  ></small>
                                  </span>
                                </div>
                              </div>

                              <input type="hidden" name="id" value="{{$coreografia->id}}"></input>
                            
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_nombre_coreografia_coreografia" data-update="nombre_coreografia" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalTipo-Coreografia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Coreografía<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_tipo_coreografia" id="edit_tipo_coreografia"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="apellido">Tipo de coreografía</label>
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class=" icon_a-especialidad f-22"></i></span>
                                      <div class="fg-line">
                                        <div class="select">
                                          <select class="selectpicker" name="tipo" id="tipo" data-live-search="true">

                                            <option value="">Selecciona</option>
                                            @foreach ( $config_coreografias as $tipo )
                                              <option value = "{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                            @endforeach
                                          
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                 </div>
                                 <div class="has-error" id="error-tipo">
                                      <span >
                                          <small class="help-block error-span" id="error-tipo_mensaje"  ></small>                                           
                                      </span>
                                  </div>
                               </div>

                               <input type="hidden" name="id" value="{{$coreografia->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_tipo_coreografia" data-update="tipo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

        <div class="modal fade" id="modalImagen-Coreografia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Coreografía<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_imagen_coreografia" id="edit_imagen_coreografia"  >
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
                                        <div id="imagena" class="fileinput-preview thumbnail" data-trigger="fileinput">
                                          @if($coreografia->imagen)
                                            <img src="{{url('/')}}/assets/uploads/coreografia/{{$coreografia->imagen}}" style="line-height: 150px;">
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

                               <input type="hidden" name="id" value="{{$coreografia->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_imagen_coreografia" data-update="imagen" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalImagenPresentacion-Coreografia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Coreografía<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_imagen_presentacion_coreografia" id="edit_imagen_presentacion_coreografia"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group text-center">
                                    <div class="form-group fg-line">
                                        <label for="id">Imagen Horizontal</label>
                                        <div class="clearfix p-b-15"></div>
                                        <input type="hidden" name="imagePresentacionBase64" id="imagePresentacionBase64">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div id="imagenb" class="fileinput-preview thumbnail" data-trigger="fileinput" style="width:450px">
                                          @if($coreografia->imagen_presentacion)
                                            <img src="{{url('/')}}/assets/uploads/coreografia/{{$coreografia->imagen_presentacion}}" style="line-height: 150px;">
                                          @endif
                                        </div>
                                        <div>
                                            <span class="btn btn-info btn-file">
                                                <span class="fileinput-new">Seleccionar Imagen</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="imagen_presentacion" id="imagen_presentacion" >
                                            </span>
                                            <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="has-error" id="error-imagen_presentacion">
                                      <span >
                                          <small id="error-imagen_presentacion_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$coreografia->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_imagen_presentacion_coreografia" data-update="imagen_presentacion" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

          
            <div class="modal fade" id="modalCoreografo-Coreografia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Coreografía<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_coreografo_coreografia" id="edit_coreografo_coreografia"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="apellido">Coreógrafo</label>

                                      <div class="select">
                                        <select class="form-control selectpicker" id="instructor_id" name="instructor_id" data-live-search="true">
                                        @foreach ( $instructores as $instructor )
                                        <option value = "{!! $instructor->id !!}">{!! $instructor->nombre !!} {!! $instructor->apellido !!}</option>
                                        @endforeach 
                                        </select>
                                      </div> 
                                    </div>
                                    <div class="has-error" id="error-instructor_id">
                                      <span >
                                          <small class="help-block error-span" id="error-instructor_id_mensaje" ></small>                                           
                                      </span>
                                 </div>
                               </div>

                               <input type="hidden" name="id" value="{{$coreografia->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_coreografo_coreografia" data-update="coreografo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalDuracion-Coreografia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Coreografía<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_duracion_coreografia" id="edit_duracion_coreografia"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                    <label for="telefono">Tiempo aproximado de la coreografía</label>
                                    <div class="form-group">
                                      <div class="col-sm-7">
                                        <label>La coreografía tiene una duración aproximada de  </label>
                                      </div>

                                      <div class="col-sm-1">
                                        <input type="text" class="form-control input-sm input-mask" name="tiempo_duracion" id="tiempo_duracion" data-mask="0000" placeholder="Ej. 10">
                                      </div>

                                      <div class="col-sm-2">
                                        <label>minutos</label>
                                      </div>
                                    </div>
                                  <div class="has-error" id="error-tiempo_duracion">
                                      <span >
                                          <small class="help-block error-span" id="error-tiempo_duracion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 


                               <input type="hidden" name="id" value="{{$coreografia->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_duracion_coreografia" data-update="tiempo_duracion" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>



            <div class="modal fade" id="modalDescripcion-Coreografia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Coreografía<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_descripcion_coreografia" id="edit_descripcion_coreografia"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Concepto o descripción coreográfica</label>
                                    <div class="fg-line">
                                      <textarea class="form-control" id="descripcion" name="descripcion" rows="2" placeholder="500 Caracteres"></textarea>
                                    </div>
                                 </div>
                                    <div class="has-error" id="error-descripcion">
                                      <span >
                                          <small id="error-descripcion_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$coreografia->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_descripcion_coreografia" data-update="descripcion" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalLink-Coreografia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Coreografía<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_link_coreografia" id="edit_link_coreografia"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">


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

                               <input type="hidden" name="id" value="{{$coreografia->id}}"></input>
                              

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
                              
                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_link_coreografia" data-update="video" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalEspecialidades-Coreografia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Coreografía <button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_especialidades_coreografia" id="edit_especialidades_coreografia"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group fg-line">
                                    <label for="apellido">Estilos de baile que se implementará</label>

                                      <div class="select">
                                        <select class="selectpicker bs-select-hidden" id="especialidad_id" name="especialidad_id" multiple="" data-max-options="5" title="Selecciona">
                                        @foreach ( $especialidades as $especialidad )
                                          <option value = "{{$especialidad->nombre}}">{{$especialidad->nombre}}</option>
                                        @endforeach
                                        </select>
                                      </div> 
                                    </div>
                                    <div class="has-error" id="error-especialidades">
                                      <span >
                                          <small class="help-block error-span" id="error-especialidades_mensaje" ></small>                                           
                                      </span>
                                 </div>
                               </div>

                              <input type="hidden" name="id" id="id" value="{{$coreografia->id}}"></input>
                              <input type="hidden" name="especialidades" id="especialidades" value="{{$coreografia->especialidad_id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_especialidades_coreografia" data-update="especialidad" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalTemaMusical-Coreografia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Coreografía<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_tema_musical_coreografia_coreografia" id="edit_tema_musical_coreografia_coreografia"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="apellido">Tema musical principal</label>
                                    <input type="text" class="form-control input-sm" name="tema_musical" id="tema_musical" placeholder="Ej. 20">
                                 </div>
                                 <div class="has-error" id="error-tema_musical">
                                      <span >
                                          <small class="help-block error-span" id="error-tema_musical_mensaje"  ></small>                                           
                                      </span>
                                  </div>
                               </div>

                               <input type="hidden" name="id" value="{{$coreografia->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_tema_musical_coreografia_coreografia" data-update="tema_musical" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                       <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/configuracion/coreografias" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Coreografía</a>
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
                                            <span class="ca-icon-planilla"><i class="icon_d-coreografia"></i></span>
                                            <div class="ca-content-planilla">
                                                <h2 class="ca-main-planilla">Vista Coreografía</h2>
                                                <h3 class="ca-sub-planilla">Personaliza el campo coreografía</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>
                                  


                                  
                              <div class="col-sm-12 text-center"> 

                              <br></br>

                              <span class="f-16 f-700">Acciones</span>

                              <hr></hr>
                              
                              <a href="{{url('/')}}/configuracion/coreografias/participantes/{{$coreografia->id}}"><i class="icon_a-participantes f-16 m-r-5 boton blue"  data-original-title="Participantes" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                              <i class="zmdi zmdi-delete f-20 m-r-10 boton red sa-warning" id="{{$coreografia->id}}" name="eliminar" data-original-title="Eliminar" data-toggle="tooltip" data-placement="bottom" title=""></i>

                              <br></br>
                                
                              <hr></hr>

                              <br></br>
                              
                               
                            </div>
                                </div> 
                              </div>  
                          </div>
                     </div>

					           	<div class="col-sm-9">

                         <div class="col-sm-12">
                              <p class="text-center opaco-0-8 f-22">Datos de la Coreografía</p>
                          </div>

                          <div class="col-sm-12">
                           <table class="table table-striped table-bordered">
                           <tr class="detalle" data-toggle="modal" href="#modalNombreEvento-Coreografia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-fiesta_id" class="zmdi  {{ empty($coreografia->fiesta_id) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw""></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-fiesta f-22"></i> </span>
                               <span class="f-14"> Nombre del evento </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="coreografia-fiesta_id"><span>{{$coreografia->fiesta_nombre}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalNombreCoreografia-Coreografia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-nombre_coreografia" class="zmdi  {{ empty($coreografia->nombre_coreografia) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw""></i></span>
                               <span class="m-l-10 m-r-10"> <i class=" icon_d-coreografia f-22"></i> </span>
                               <span class="f-14"> Nombre de la coreografía </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="coreografia-nombre_coreografia"><span>{{$coreografia->nombre_coreografia}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalTipo-Coreografia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-tipo" class="zmdi  {{ empty($coreografia->tipo) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw""></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-especialidad f-22"></i> </span>
                               <span class="f-14"> Tipo de coreografía </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="coreografia-tipo"><span>{{$coreografia->tipo}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalImagen-Coreografia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-ImageBase64" class="zmdi {{ empty($coreografia->imagen) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-collection-folder-image zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Imagen </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="coreografia-imagen"><span></span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalDescripcion-Coreografia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-descripcion" class="zmdi {{ empty($coreografia->descripcion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b-cuentales-historia f-22"></i> </span>
                               <span class="f-14">Concepto o descripción coreográfica</span>
                             </td>
                             <td id="coreografia-descripcion" class="f-14 m-l-15" data-valor="{{$coreografia->descripcion}}" ><span ><span>{{ str_limit($coreografia->descripcion, $limit = 30, $end = '...') }}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalLink-Coreografia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-link_video" class="zmdi {{ empty($coreografia->link_video) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10">  <i class="zmdi zmdi-videocam f-22"></i> </span>
                               <span class="f-14"> Link Promocional </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="coreografia-link_video"><span>{{$coreografia->link_video}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalImagenPresentacion-Coreografia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-imagen_presentacion" class="zmdi {{ empty($coreografia->imagen_presentacion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-collection-folder-image zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Imagen Horizontal </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="coreografia-ImagePresentacionBase64"><span></span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalEspecialidades-Coreografia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-especialidad_id" class="zmdi {{ empty($coreografia->especialidad_id) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw""></i></span>
                               <span class="m-l-10 m-r-10"> <i class=" icon_a-especialidad f-22"></i> </span>
                               <span class="f-14">Estilos  de baile que se implementará</span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="coreografia-especialidad_id"><span>{{$coreografia->especialidad_id}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalTemaMusical-Coreografia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-tema_musical" class="zmdi {{ empty($coreografia->tema_musical) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw""></i></span>
                               <span class="m-l-10 m-r-10"> <i class=" icon_d-coreografia f-22"></i> </span>
                               <span class="f-14">Tema musical principal</span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="coreografia-tema_musical"><span>{{$coreografia->tema_musical}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalDuracion-Coreografia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-tiempo_duracion" class="zmdi  {{ empty($coreografia->tiempo_duracion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw""></i></span>
                               <span class="m-l-10 m-r-10"> <i class=" zmdi zmdi-time f-22"></i> </span>
                               <span class="f-14"> Tiempo aproximado de la coreografía </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="coreografia-tiempo_duracion">{{$coreografia->tiempo_duracion}}</span> Minutos<span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalCoreografo-Coreografia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-instructor_id" class="zmdi  {{ empty($coreografia->coreografo_nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-instructor f-22"></i> </span>
                               <span class="f-14"> Coreógrafo  </span>
                             </td>
                             <td  class="f-14 m-l-15"><span id="coreografia-instructor_id">{{$coreografia->coreografo_nombre}} {{$coreografia->coreografo_apellido}}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
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
    route_update="{{url('/')}}/configuracion/coreografias/update";
    route_eliminar="{{url('/')}}/configuracion/coreografias/eliminar/";
    route_principal="{{url('/')}}/configuracion/coreografias";

    $(document).ready(function(){

      $("#imagen").bind("change", function() {
        
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

      $("#imagen_presentacion").bind("change", function() {
          
        setTimeout(function(){
          var imagen = $("#imagenb img").attr('src');
          var canvas = document.createElement("canvas");

          var context=canvas.getContext("2d");
          var img = new Image();
          img.src = imagen;
          
          canvas.width  = img.width;
          canvas.height = img.height;

          context.drawImage(img, 0, 0);
   
          var newimage = canvas.toDataURL("image/jpeg", 0.8);
          var image64 = $("input:hidden[name=imagePresentacionBase64]").val(newimage);
          
        },500);

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

    $('#modalNombreCoreografia-Coreografia').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#nombre_coreografia").val($("#coreografia-nombre_coreografia").text()); 
    })

    $('#modalDuracion-Coreografia').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#tiempo_duracion").val($("#coreografia-tiempo_duracion").text()); 
    })

    $('#modalDescripcion-Coreografia').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var descripcion=$("#coreografia-descripcion").data('valor');
       $("#descripcion").val(descripcion);
    })

    $('#modalLink-Coreografia').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#link_video").val($("#coreografia-link_video").text()); 
    })

    $('#modalTemaMusical-Coreografia').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#tema_musical").val($("#coreografia-tema_musical").text()); 
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

            case 'tipo':
            case 'fiesta_id':
            case 'instructor_id':
            case 'especialidad_id':

                expresion = "#"+c.name+ " option[value="+c.value+"]";
                texto = $(expresion).text();
                
                $("#coreografia-"+c.name).text(texto);

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
            case 'descripcion':

              $("#coreografia-"+c.name).data('valor',c.value);
              $("#coreografia-"+c.name).html(c.value.toLowerCase().substr(0, 30) + "...");

              break;

            default:
                console.log("entro");
                $("#coreografia-"+c.name).text(c.value);
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
                //   window.location = "{{url('/')}}/error";
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
                    title: "Desea eliminar la coreografia",   
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
