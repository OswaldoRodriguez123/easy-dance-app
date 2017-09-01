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
<script type="text/javascript" src="{{url('/')}}/assets/js/webcam.min.js"></script>
@stop

@section('content')

            <div class="modal fade" id="modalImagen-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Alumno<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_imagen_alumno" id="edit_imagen_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input type="hidden" name="imageBase64" id="imageBase64">
                           <div class="modal-body">                           
                             <div class="row p-t-20 p-b-0">

                               <div class="col-sm-12">
                                  <div class="form-group">
                                      <label for="p-t-10"></label>
                                      <div class="p-t-10">
                                        <label class="radio radio-inline m-r-20">
                                            <input name="tipo_imagen" id="snapshot" value="1" type="radio" checked>
                                            <i class="input-helper"></i>  
                                            Tomar Foto 
                                        </label>
                                        <label class="radio radio-inline m-r-20 ">
                                            <input name="tipo_imagen" id="upload" value="2" type="radio">
                                            <i class="input-helper"></i>  
                                            Subir Foto 
                                        </label>
                                      </div>
                                   </div>
                                </div>

                              <div class="col-sm-12 snapshot">
                                <div class="p-b-20">
                                  @if($imagen)
                                    <img id="img_snapshot" class="img-responsive" src="{{url('/')}}/assets/uploads/usuario/{{$imagen}}"> 
                                  @else
                                    <img id="img_snapshot" class="img-responsive">
                                  @endif 
                                </div>
                                <div id="webcam"></div>

                                <a class="btn btn-info btn-file" href="#" onClick="take_snapshot()">Tomar Foto</a>
                                @if($imagen)
                                  <a id="delete_snapshot" href="#" class="btn btn-danger">Eliminar</a>
                                @else
                                  <a style="display:none" id="delete_snapshot" href="#" class="btn btn-danger">Eliminar</a>
                                @endif

                              </div>

                              <div class="col-sm-12 upload" style="display: none">

                                <label for="id">Cargar Imagen</label>
                                <div class="clearfix p-b-15"></div>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                  <div id="imagena" class="fileinput-preview thumbnail" data-trigger="fileinput">
                                    @if($imagen)
                                    <img src="{{url('/')}}/assets/uploads/usuario/{{$imagen}}" style="line-height: 150px;">
                                    @endif
                                  </div>

                                  <span class="btn btn-info btn-file">
                                      <span class="fileinput-new">Seleccionar Imagen</span>
                                      <span class="fileinput-exists">Cambiar</span>
                                      <input type="file" name="imagen" id="imagen" >
                                  </span>
                                  <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                </div>
                              </div>
                              
                              <input type="hidden" name="id" value="{{$alumno->id}}"></input>
                              
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

                            <div class="col-sm-12 text-right">                         
                                      
                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_imagen_alumno" data-update="imagen" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalTipoPago-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Alumno<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_tipo_pago_alumno" id="edit_tipo_pago_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Modalidad de Pago</label>

                                      <div class="select">
                                        <select class="selectpicker" name="tipo_pago" id="tipo_pago" data-live-search="true">
                                          <option value = "1">Contado</option>
                                          <option value = "2">Crédito</option>
                                          <option value = "3">Sin Confirmar</option>
                                        </select>
                                      </div>

                                 </div>
                                 <div class="has-error" id="error-tipo_pago">
                                      <span >
                                          <small class="help-block error-span" id="error-tipo_pago_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <input type="hidden" name="id" value="{{$alumno->id}}"></input>
                            

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_tipo_pago_alumno" data-update="tipo_pago" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalPromotor-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Alumno<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_promotor_alumno" id="edit_promotor_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Promotor</label>

                                      <div class="select">
                                          <select class="form-control" id="instructor_id" name="instructor_id">
                                          @foreach ( $instructores as $instructor )
                                          <option value = "{{ $instructor['id'] }}">{{ $instructor['nombre'] }} {{ $instructor['apellido'] }}</option>
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


                               <input type="hidden" name="id" value="{{$alumno->id}}"></input>
                            

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_promotor_alumno" data-update="promotor" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalTipologia-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Alumno<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_tipologia_alumno" id="edit_tipologia_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="tipologia_id">Perfil del Cliente</label>

                                      <div class="select">
                                          <select class="form-control" id="tipologia_id" name="tipologia_id">
                                            <option value="">Selecciona</option>
                                            @foreach ( $tipologias as $tipologia )
                                              <option value = "{{ $tipologia['id'] }}">{{ $tipologia['nombre'] }}</option>
                                            @endforeach 
                                          </select>
                                      </div> 

                                 </div>
                                 <div class="has-error" id="error-tipologia_id">
                                      <span >
                                          <small class="help-block error-span" id="error-tipologia_id_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>


                               <input type="hidden" name="id" value="{{$alumno->id}}"></input>
                            

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_tipologia_alumno" data-update="tipologia" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
     
            <div class="modal fade" id="modalID-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Alumno<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_id_alumno" id="edit_id_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Id - Pasaporte</label>
                                        <input type="text" class="form-control input-sm input-mask" name="identificacion" id="identificacion" data-mask="00000000000000000000" placeholder="Ej: 16133223" value="{{$alumno->identificacion}}">
                                    </div>
                                    <div class="has-error" id="error-identificacion">
                                      <span >
                                          <small id="error-identificacion_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$alumno->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_id_alumno" data-update="identificacion" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalNombre-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Alumno<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_nombre_alumno" id="edit_nombre_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control input-sm" name="nombre" id="nombre" placeholder="Ej. Valeria">
                                 </div>
                                 <div class="has-error" id="error-nombre">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 


                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="apellido">Apellido</label>
                                    <input type="text" class="form-control input-sm" name="apellido" id="apellido" placeholder="Ej. Sánchez">
                                 </div>
                                 <div class="has-error" id="error-apellido">
                                      <span >
                                          <small class="help-block error-span" id="error-apellido_mensaje"  ></small>                                           
                                      </span>
                                  </div>
                               </div>

                               <input type="hidden" name="id" value="{{$alumno->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_nombre_alumno" data-update="nombre" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalFechaNacimiento-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Alumno<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_fecha_nacimiento_alumno" id="edit_fecha_nacimiento_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group fg-line">
                                    <label for="apellido">Fecha de Nacimiento</label>
                                            <div class="dtp-container fg-line">
                                            <input name="fecha_nacimiento" id="fecha_nacimiento" class="form-control date-picker pointer" placeholder="Seleciona" type="text">
                                        </div>
                                    </div>
                                    <div class="has-error" id="error-fecha_nacimiento">
                                      <span >
                                          <small class="help-block error-span" id="error-fecha_nacimiento_mensaje" ></small>                                           
                                      </span>
                                 </div>
                               </div>

                               <input type="hidden" name="id" value="{{$alumno->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_fecha_nacimiento_alumno" data-update="fecha_nacimiento" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalSexo-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Alumno<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_sexo_alumno" id="edit_sexo_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group fg-line ">
                                    <label for="sexo p-t-10">Sexo</label>
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="sexo" id="mujer" value="F" type="radio">
                                        <i class="input-helper"></i>  

                                        Mujer 

                                        @if($edad >= 18)
                                          <i class="zmdi zmdi-female f-25 c-rosado"></i> </span>
                                        @else
                                          <i class="zmdi fa fa-child f-15 c-rosado"></i> </span>
                                        @endif
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="sexo" id="hombre" value="M" type="radio">
                                        <i class="input-helper"></i>  
                                        Hombre 

                                        @if($edad >= 18)
                                          <i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>
                                        @else
                                          <i class="zmdi fa fa-child f-15 c-azul"></i> </span>
                                        @endif
                                    </label>
                                    </div>
                                    
                                 </div>
                                 <div class="has-error" id="error-sexo">
                                      <span >
                                          <small class="help-block error-span" id="error-sexo_mensaje" ></small>                                           
                                      </span>
                                  </div>
                               </div>

                               <input type="hidden" name="id" value="{{$alumno->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_sexo_alumno" data-update="sexo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>
                             
                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalCorreo-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Alumno<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_correo_alumno" id="edit_correo_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="correo">Correo</label>
                                    <input type="text" class="form-control input-sm" name="correo" id="correo" placeholder="Ej. example@correo.com">
                                 </div>
                                 <div class="has-error" id="error-correo">
                                      <span >
                                          <small class="help-block error-span" id="error-correo_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 

                               <input type="hidden" name="id" value="{{$alumno->id}}"></input>

                               
                               
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_correo_alumno" data-update="correo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalTelefono-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Alumno<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_telefono_alumno" id="edit_telefono_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="telefono">Telefono Local</label>
                                    <input type="text" class="form-control input-sm input-mask" name="telefono" id="telefono" data-mask="(000)000-0000" placeholder="Ej: (426)367-0894">
                                 </div>
                                 <div class="has-error" id="error-telefono">
                                      <span >
                                          <small class="help-block error-span" id="error-telefono_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 


                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="celular">Telefono Celular</label>
                                    <input type="text" class="form-control input-sm input-mask" name="celular" id="celular" data-mask="(000)000-0000" placeholder="Ej: (426)367-0894">
                                 </div>
                                 <div class="has-error" id="error-celular">
                                      <span >
                                          <small class="help-block error-span" id="error-celular_mensaje"  ></small>                                           
                                      </span>
                                  </div>
                               </div>

                               <input type="hidden" name="id" value="{{$alumno->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_telefono_alumno" data-update="telefono" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="modalFicha-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Alumno<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_ficha_alumno" id="edit_ficha_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">

                           <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Alergia</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">
                                      
                                      <input type="text" id="alergia" name="alergia" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="alergia-switch" type="checkbox" hidden="hidden">
                                          <label for="alergia-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Asma</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="asma" name="asma" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="asma-switch" type="checkbox" hidden="hidden">
                                          <label for="asma-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Convulsiones</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="convulsiones" name="convulsiones" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="convulsiones-switch" type="checkbox" hidden="hidden">
                                          <label for="convulsiones-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Cefalea</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="cefalea" name="cefalea" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="cefalea-switch" type="checkbox" hidden="hidden">
                                          <label for="cefalea-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Hipertensión</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="hipertension" name="hipertension" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="hipertension-switch" type="checkbox" hidden="hidden">
                                          <label for="hipertension-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Lesiones</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="lesiones" name="lesiones" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="lesiones-switch" type="checkbox" hidden="hidden">
                                          <label for="lesiones-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>


                               <input type="hidden" name="id" value="{{$alumno->id}}"></input>
                              

                               <div class="clearfix"></div> 
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               
                               
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_ficha_alumno" data-update="ficha" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalDireccion-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Alumno<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_direccion_alumno" id="edit_direccion_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="correo">Dirección</label>
                                    <input type="text" class="form-control input-sm" name="direccion" id="direccion" placeholder="Ej. Avenida 10 con Calle 70" maxlength="180" onkeyup="countChar(this)">
                                 </div>
                                 
                                 <div class="opaco-0-8 text-right">Resta <span id="charNum">180</span> Caracteres</div>
                                 <div class="has-error" id="error-direccion">
                                      <span >
                                          <small class="help-block error-span" id="error-direccion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                                     

                               <div class="clearfix"></div> 

                               <input type="hidden" name="id" value="{{$alumno->id}}"></input>

                               
                               
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_direccion_alumno" data-update="direccion" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalClaseGrupal-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Clases Grupales <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div>
                        <div class="clearfix p-b-15"></div>

                        <div class="row p-t-20 p-b-0" style="padding: 2%">

                        @if(!$clases_grupales)

                          <div class="col-sm-10 col-sm-offset-1 error_clase_grupal">


                            <div align="center"><i class="zmdi zmdi-mood-bad zmdi-hc-5x c-morado"></i></div>
                            <div class="c-morado f-30 text-center"> No se encontraron resultados </div>


                          </div>

                        @else
            
                        <div class="show_clase_grupal">
                          
                          @foreach($clases_grupales as $clase_grupal)

                            <div class="col-sm-12">

                              <span class="f-18 opaco-0-8 clase_grupal clase-grupal-{{$clase_grupal['inscripcion_id']}} c-morado pointer f-700" id="{{$clase_grupal['inscripcion_id']}}" data-costo="{{$clase_grupal['costo_mensualidad']}}" data-fecha="{{ \Carbon\Carbon::createFromFormat('Y-m-d',$clase_grupal['fecha_pago'])->format('d/m/Y')}}">{{$clase_grupal['nombre']}} -  {{$clase_grupal['dias_de_semana']}} -  Desde: {{$clase_grupal['hora_inicio']}}  /   Hasta: {{$clase_grupal['hora_final']}}  -  {{$clase_grupal['instructor_nombre']}} {{$clase_grupal['instructor_apellido']}} - Fecha de pago: <span id="fecha_pago_{{$clase_grupal['inscripcion_id']}}"> {{ \Carbon\Carbon::createFromFormat('Y-m-d',$clase_grupal['fecha_pago'])->format('d/m/Y')}} - Dias de vencimiento: {{\Carbon\Carbon::createFromFormat('Y-m-d',$clase_grupal['fecha_pago'])->diffInDays(\Carbon\Carbon::now())}}</span> - Talla: <span class = "talla_franela-{{$clase_grupal['inscripcion_id']}}">{{$clase_grupal['talla_franela']}}</span></span> 

                              @if($clase_grupal['boolean_franela'] && $clase_grupal['boolean_programacion'])
                                <span class = "iconos-{{$clase_grupal['inscripcion_id']}}"> <i class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                              @else
                                @if($clase_grupal['boolean_franela'] == 0 && $clase_grupal['boolean_programacion'] == 0)
                                  <span class = "iconos-{{$clase_grupal['inscripcion_id']}}"> <i class="zmdi c-youtube icon_a-examen zmdi-hc-fw f-16 f-700"></i> <i class="zmdi c-youtube icon_f-productos zmdi-hc-fw f-16 f-700"></i></span>
                             
                                @else
                                    @if($clase_grupal['boolean_franela'])
                                    <span class = "iconos-{{$clase_grupal['inscripcion_id']}}"> <i class="zmdi c-youtube icon_a-examen zmdi-hc-fw"></i></span>
                                  @else
                                    <span class = "iconos-{{$clase_grupal['inscripcion_id']}}"> <i class="zmdi c-youtube icon_f-productos zmdi-hc-fw"></i></span>
                                  @endif
                                @endif
                              @endif



                              <div class="clearfix p-b-15"></div>
                              <div class="clearfix p-b-15"></div>

                            </div>

                          @endforeach

                        </div>

                        @endif

                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>

                        </div>

                        </div>
                       
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalEntrega-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Entrega <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div>
                        <div class="clearfix p-b-15"></div>

                        <div class="row p-t-20 p-b-0" style="padding: 2%">

                        @if(!$clases_grupales)

                          <div class="col-sm-10 col-sm-offset-1 error_clase_grupal">


                            <div align="center"><i class="zmdi zmdi-mood-bad zmdi-hc-5x c-morado"></i></div>
                            <div class="c-morado f-30 text-center"> No se encontraron resultados </div>


                          </div>

                        @else
            
                        <div class="show_clase_grupal">

                          @foreach($clases_grupales as $clase_grupal)

                            <div class="col-sm-12">

                              <span class="f-18 opaco-0-8 entrega clase-grupal-{{$clase_grupal['inscripcion_id']}} c-morado pointer f-700" id="{{$clase_grupal['inscripcion_id']}}" data-franela="{{$clase_grupal['boolean_franela']}}" data-programacion="{{$clase_grupal['boolean_programacion']}}" data-entrega="{{$clase_grupal['razon_entrega']}}" data-talla="{{$clase_grupal['talla_franela']}}">{{$clase_grupal['nombre']}} -  {{$clase_grupal['dias_de_semana']}} - Desde: {{$clase_grupal['hora_inicio']}}  /   Hasta: {{$clase_grupal['hora_final']}}  -  {{$clase_grupal['instructor_nombre']}} {{$clase_grupal['instructor_apellido']}} - Fecha de pago: <span id="fecha_pago_{{$clase_grupal['inscripcion_id']}}"> {{ \Carbon\Carbon::createFromFormat('Y-m-d',$clase_grupal['fecha_pago'])->format('d/m/Y')}} - Dias de vencimiento: {{\Carbon\Carbon::createFromFormat('Y-m-d',$clase_grupal['fecha_pago'])->diffInDays(\Carbon\Carbon::now())}}</span> - Talla: <span class = "talla_franela-{{$clase_grupal['inscripcion_id']}}">{{$clase_grupal['talla_franela']}}</span></span> 

                              @if($clase_grupal['boolean_franela'] && $clase_grupal['boolean_programacion'])
                                <span class = "iconos-{{$clase_grupal['inscripcion_id']}}"> <i class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                              @else
                                @if($clase_grupal['boolean_franela'] == 0 && $clase_grupal['boolean_programacion'] == 0)
                                  <span class = "iconos-{{$clase_grupal['inscripcion_id']}}"> <i class="zmdi c-youtube icon_a-examen zmdi-hc-fw f-16 f-700"></i> <i class="zmdi c-youtube icon_f-productos zmdi-hc-fw f-16 f-700"></i></span>
                             
                                @else
                                    @if($clase_grupal['boolean_franela'])
                                    <span class = "iconos-{{$clase_grupal['inscripcion_id']}}"> <i class="zmdi c-youtube icon_a-examen zmdi-hc-fw"></i></span>
                                  @else
                                    <span class = "iconos-{{$clase_grupal['inscripcion_id']}}"> <i class="zmdi c-youtube icon_f-productos zmdi-hc-fw"></i></span>
                                  @endif
                                @endif
                              @endif

                              <span class="c-azul">Cambiar Talla y Programación</span>

                              <div class="clearfix p-b-15"></div>
                              <div class="clearfix p-b-15"></div>

                            </div>

                          @endforeach
                          
                        </div>

                        @endif

                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>

                        </div>

                        </div>
                       
                    </div>
                </div>
            </div>

           

              <div class="modal fade" id="modalEntrega-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Entrega<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_entrega_clase_grupal" id="edit_entrega_clase_grupal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input type="hidden" class ="inscripcion_id" id="inscripcion_id" name="inscripcion_id" value="">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                            <div class="col-sm-12">

                                  <label for="alumno" class="c-morado f-22">Entrega</label>
                                  <div class="clearfix p-b-35"></div>

                                  <div class="col-sm-6">

                                    <span for="alumno" class="c-morado f-16">Camiseta</span>

                                    <br></br>
                                    <input type="text" id="boolean_franela" name="boolean_franela" value="" hidden="hidden">
                                    <div class="p-t-10">
                                      <div class="toggle-switch" data-ts-color="purple">
                                      <span class="p-r-10 f-700 f-16">No</span><input id="franela-switch" type="checkbox">
                                      
                                      <label for="franela-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                    </div>

                                    <br>

                                    <div class="form-group fg-line">
                                      <label for="talla_franela">Talla de la Camiseta</label>
                                      <input type="text" class="form-control input-sm" name="talla_franela" id="talla_franela" placeholder="Ej. 12">
                                   </div>

                                  </div>

                                  <div class="col-sm-6">

                                    <span for="alumno" class="c-morado f-16">Programación</span>


                                    <br></br>
                                    <input type="text" id="boolean_programacion" name="boolean_programacion" value="" hidden="hidden">
                                    <div class="p-t-10">
                                      <div class="toggle-switch" data-ts-color="purple">
                                      <span class="p-r-10 f-700 f-16">No</span><input id="programacion-switch" type="checkbox">
                                      
                                      <label for="programacion-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                    </div>

                                  </div>

                                </div>

                                <div class="col-sm-12" id="textarea_entrega" style="display:none">

                                  <div class="clearfix p-b-35"></div>
                                 
                                  <label for="razon_entrega" id="id-razon_entrega">Explique las razones por la cual no fue entregado</label>
                                  <br></br>

                                  <div class="fg-line">
                                    <textarea class="form-control" id="razon_entrega" name="razon_entrega" rows="2"></textarea>
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

                              <!-- <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_costo_mensualidad_clase_grupal" data-update="costomensualidad" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a> -->
                              <button type="button" class="btn btn-blanco m-r-10 f-12" id="guardar_entrega" name="guardar_entrega">Guardar</button>

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
                           <input type="hidden" class ="inscripcion_id" id="inscripcion_id" name="inscripcion_id" value="">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                           <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                    <label for="fecha_pago">Fecha de pago</label>
                                    <input type="text" class="form-control date-picker input-sm" name="fecha_pago" id="fecha_pago" placeholder="Ej. 00/00/0000">
                                 </div>
                                    <div class="has-error" id="error-fecha_pago">
                                      <span >
                                          <small id="error-fecha_pago_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="costo">Costo Mensualidad</label>
                                    <input type="text" class="form-control input-sm" name="costo_mensualidad" id="costo_mensualidad" placeholder="Ej. 5000" data-mask="00000000000000000000">
                                 </div>
                                 <div class="has-error" id="error-costo_mensualidad">
                                      <span >
                                          <small class="help-block error-span" id="error-costo_mensualidad_mensaje" ></small>                                
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

                              <!-- <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_costo_mensualidad_clase_grupal" data-update="costomensualidad" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a> -->
                              <button type="button" class="btn btn-blanco m-r-10 f-12" id="guardar_mensualidad" name="guardar_mensualidad">Guardar</button>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <section id="content">
                <div class="container">
              
                    <div class="block-header">
                       <?php $url = "/participante/alumno" ?>

                        <a class="btn-blanco m-r-10 f-16" href="{{ $url }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                    </div> 
                    
                    <div class="card">
    

                      <div class="card-header">
                            
                        <a href="" class="pull-right">
                          @if($imagen)
                            <img id="imagen_perfil" class="img-circle" src="{{url('/')}}/assets/uploads/usuario/{{$imagen}}" alt="" width="70px" height="auto"> 
                          @else
                             @if($alumno->sexo=='F')
                                <img id="imagen_perfil" class="img-responsive img-circle" src="{{url('/')}}/assets/img/profile-pics/1.jpg" alt="">        
                             @else
                                <img id="imagen_perfil" class="img-responsive img-circle" src="{{url('/')}}/assets/img/profile-pics/2.jpg" alt="">
                             @endif
                          @endif
                        </a>
                        
                      </div>
                      <div class="card-body p-b-20">
                        <div class="row">
                        <div class="container">
                         <div class="col-sm-3">
          					        <div class="text-center p-t-30">       
          					          <div class="row p-b-15 ">
          					            <div class="col-md-12" data-src="/assets/img/ayuda-configuracion.jpg">
                                  <ul class="ca-menu-planilla">
                                    <li>
                                        <a href="#" class="mousehand disabled">
                                            <span class="ca-icon-planilla"><i class="icon_a-alumnos"></i></span>
                                            <div class="ca-content-planilla">
                                                <h2 class="ca-main-planilla">Vista Alumno</h2>
                                                <h3 class="ca-sub-planilla">Personaliza el campo alumno</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>

                                  <div class="col-sm-12 text-left"> 

                                  <br></br>
                                   
                                  
                                  <table class="table table-striped table-bordered">
                                    <tr class="detalle historial">
                                      <td></td>
                                      <td class="f-14 m-l-15" data-original-title="" data-content="Ver historial" data-toggle="popover" data-placement="bottom" title="" type="button" data-trigger="hover"><span class="f-12 f-700">Balance E: </span><span class = "f-12 f-700" id="total" name="total"></span> <i class="zmdi zmdi-money {{ empty($total) ? 'c-verde ' : 'c-youtube' }} f-20 m-r-5"></i></td>
                                    </tr>
                                  </table>

                                  <table class="table table-striped table-bordered">
                                    <tr class="detalle remuneracion">
                                      <td></td>
                                      <td class="f-14 m-l-15" data-original-title="" data-content="Ver puntos" data-toggle="popover" data-placement="bottom" title="" type="button" data-trigger="hover"><span class="f-12 f-700">Puntos A: </span><span class = "f-12 f-700" id="puntos_referidos" name="puntos_referidos"></span> <i id="estatus-puntos_referidos" class="zmdi zmdi-money {{ empty($puntos_referidos) ? 'c-youtube ' : 'c-verde' }} f-20 m-r-5"></i></td>
                                    </tr>
                                  </table>

                                  <table class="table table-striped table-bordered">
                                    <tr class="detalle credenciales">
                                      <td></td>
                                      <td class="f-14 m-l-15" data-original-title="" data-content="Ver credenciales" data-toggle="popover" data-placement="bottom" title="" type="button" data-trigger="hover"><span class="f-12 f-700">Credenciales: </span><span class = "f-12 f-700" id="credenciales" name="credenciales">{{$credenciales}}</span></td>
                                    </tr>
                                  </table>


                                  <table class="table table-striped table-bordered">
                                    <tr class="detalle llamadas">
                                      <td></td>
                                      <td class="f-14 m-l-15" data-original-title="" data-content="Ver Llamadas" data-toggle="popover" data-placement="bottom" title="" type="button" data-trigger="hover"><span class="f-12 f-700">Llamadas: </span><span class = "f-12 f-700" id="llamadas" name="llamadas">{{$llamadas}}</span></td>
                                    </tr>
                                  </table>

                                  

                                  </div>

                                  <div class="col-sm-12 text-center"> 

                                  <br>

                                  <span class="f-16 f-700">Acciones</span>

                                  <hr></hr>

                                  @if($total)
                                    <a href="{{url('/')}}/participante/alumno/deuda/{{$id}}"><i class="icon_a-pagar f-20 m-r-5 boton blue sa-warning" data-original-title="Pagar" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                  @endif
                                  
                                  @if($usuario)
                                    <a class="email"><i class="zmdi zmdi-email f-20 m-r-5 boton blue sa-warning" data-original-title="Enviar Correo" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                  @else
                                    <a class="email" style="display:none"><i class="zmdi zmdi-email f-20 m-r-5 boton blue sa-warning" data-original-title="Enviar Correo" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                    <a class="usuario"><i class="zmdi zmdi-alert-circle-o f-20 m-r-5 boton blue sa-warning" data-original-title="Crear Cuenta" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                  @endif
                                  <a href="{{url('/')}}/participante/alumno/transferir/{{$id}}"><i class="zmdi zmdi-trending-up zmdi-hc-fw f-20 m-r-5 boton blue sa-warning" data-original-title="Transferir" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                  <a href="{{url('/')}}/participante/alumno/evaluaciones/{{$id}}"><i class="zmdi glyphicon glyphicon-search f-20 m-r-5 boton blue sa-warning" data-original-title="Valoración" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                  <a class="reservar"><i class="icon_a-reservaciones f-20 m-r-5 boton blue sa-warning" data-original-title="Reservar" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                  <i class="zmdi zmdi-delete boton red f-20 m-r-10 boton red sa-warning" id="{{$alumno->id}}" name="eliminar" data-original-title="Eliminar" data-toggle="tooltip" data-placement="bottom" title=""></i>

                                  <br></br>
                                    
                                   
                                </div>

          					            </div>                
          					          </div>
          					                
          					      </div>
					           </div>

					           	<div class="col-sm-9">

                          <div class="col-sm-12">
                              <p class="text-center opaco-0-8 f-22">Datos del Alumno</p>
                              <p class="text-center opaco-0-8 f-12">Fecha de registro: {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$alumno->created_at)->format('d-m-Y')}}</p>
                             
                          </div>

                        <div class="col-sm-12">
                          <table class="table table-striped table-bordered">
                            <!-- <tr class="detalle" data-toggle="modal" href="#modalPromotor-Alumno">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-instructor_id" class="zmdi {{ empty($alumno->instructor_nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-instructor f-22"></i> </span>
                               <span class="f-14"> Promotor </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="alumno-instructor_id" class="capitalize">{{$alumno->instructor_nombre}} {{$alumno->instructor_apellido}}</span></td>
                            </tr> -->
                            <tr class="detalle" data-toggle="modal" href="#modalTipoPago-Alumno">
                             <td width="50%"> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-tipo_pago" class="zmdi {{ empty($tipo_pago) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>                      
                              <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-money f-22"></i> </span>
                              <span class="f-14">Modalidad de Pago </span>
                             </td>
                              <td class="f-14 m-l-15" id="alumno-tipo_pago">{{$tipo_pago}}<span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalImagen-Alumno">
                             <td width="50%"> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-imagen" class="zmdi {{ empty($imagen) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>                      
                              <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-collection-folder-image f-22"></i> </span>
                              <span class="f-14">Imagen </span>
                             </td>
                             <td class="f-14 m-l-15"><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalID-Alumno">
                             <td width="50%"> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-identificacion" class="zmdi {{ empty($alumno->identificacion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>                      
                              <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-account-box f-22"></i> </span>
                              <span class="f-14">Id / pasaporte </span>
                             </td>
                             <td class="f-14 m-l-15" id="alumno-identificacion">{{$alumno->identificacion}}<span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalNombre-Alumno">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-nombre" class="zmdi {{ empty($alumno->nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-accounts-alt f-22"></i> </span>
                               <span class="f-14"> Nombres </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="alumno-nombre" class="capitalize">{{$alumno->nombre}}</span> <span id="alumno-apellido" class="capitalize">{{$alumno->apellido}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalFechaNacimiento-Alumno">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-fecha_nacimiento" class="zmdi {{ empty($alumno->fecha_nacimiento) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b-fecha-de-nacimiento f-22"></i> </span>
                               <span class="f-14"> Fecha de nacimiento  </span>
                             </td>
                             <td  class="f-14 m-l-15" id="alumno-fecha_nacimiento" >{{ \Carbon\Carbon::createFromFormat('Y-m-d',$alumno->fecha_nacimiento)->format('d/m/Y')}}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                             <tr class="detalle" data-toggle="modal" href="#modalSexo-Alumno">
                             <td> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-sexo" class="zmdi {{ empty($alumno->sexo) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                              <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-male-female f-22"></i> </span>
                              <span class="f-14"> Sexo </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="alumno-sexo" data-valor="{{$alumno->sexo}}">
                               @if($edad >= 18)
                                  @if($alumno->sexo=='F')
                                      <i class="zmdi zmdi-female f-25 c-rosado"></i> </span>
                                  @else
                                      <i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>
                                  @endif
                              @else
                                  @if($alumno->sexo=='F')
                                      <i class="zmdi fa fa-child f-15 c-rosado"></i> </span>
                                  @else
                                      <i class="zmdi fa fa-child f-15 c-azul"></i> </span>
                                  @endif
                              @endif
                             </span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalCorreo-Alumno">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-correo" class="zmdi {{ empty($alumno->correo) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-correo f-22"></i> </span>
                               <span class="f-14"> Correo </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="alumno-correo"><span>{{$alumno->correo}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr id ="tr_contacto" class="detalle" data-toggle="modal" href="#modalTelefono-Alumno" data-valor="{{$alumno->celular}}">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-telefono" class="zmdi {{ empty($alumno->telefono) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b icon_b-telefono f-22"></i> </span>
                               <span class="f-14"> Contacto </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="alumno-telefono">{{$alumno->telefono}}</span> / <span id="alumno-celular">{{$alumno->celular}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalDireccion-Alumno">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-direccion" class="zmdi {{ empty($alumno->direccion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-pin-drop zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Dirección </span>
                             </td>
                             <td id="alumno-direccion" class="f-14 m-l-15 capitalize" data-valor="{{$alumno->direccion}}" >{{ str_limit($alumno->direccion, $limit = 30, $end = '...') }} <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalFicha-Alumno">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-ficha_medica" class="zmdi zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_d-ficha-medica f-22"></i> </span>
                               <span class="f-14"> Ficha Médica </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="alumno-ficha_medica"></span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalClaseGrupal-Alumno">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-telefono" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-clases-grupales f-22"></i> </span>
                               <span class="f-14"> Clases Grupales</span>
                             </td>
                             <td id="alumno-clase_grupal" class="f-14 m-l-15 capitalize" >{{ str_limit($descripcion, $limit = 30, $end = '...') }} <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalEntrega-Alumno">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-telefono" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_f-productos f-22"></i> </span>
                               <span class="f-14">Entrega</span>
                             </td>
                             <td id="alumno-clase_grupal" class="f-14 m-l-15 capitalize" ><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle perfil">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-perfil" class="zmdi {{ empty($perfil) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-alumnos f-22"></i> </span>
                               <span class="f-14"> Perfil Evaluativo </span>
                             </td>
                             <td id="alumno-perfil" class="f-14 m-l-15 capitalize"><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr>
                             <td> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="codigo" class="zmdi {{ empty($alumno->codigo_referido) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                              <span class="m-l-10 m-r-10"> <i class="icon_b-nombres f-22"></i> </span>
                              <span class="f-14"> Codigo para referir </span>
                             </td>
                             <td class="f-14 m-l-15" >
                              <span id="alumno-codigo" data-valor="{{$alumno->codigo_referido}}">{{$alumno->codigo_referido}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalTipologia-Alumno">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-tipologia_id" class="zmdi {{ empty($alumno->tipologia) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-clases-grupales f-22"></i> </span>
                               <span class="f-14"> Perfil del Cliente </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="alumno-tipologia_id" class="capitalize">{{$alumno->tipologia}}</span></td>
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
    route_update="{{url('/')}}/participante/alumno/update";
    route_eliminar="{{url('/')}}/participante/alumno/eliminar/";
    route_principal="{{url('/')}}/participante/alumno";
    route_sesion="{{url('/')}}/participante/alumno/sesion";
    route_historial = "{{url('/')}}/participante/alumno/historial/";
    route_remuneracion = "{{url('/')}}/participante/alumno/puntos-acumulados/";
    route_credenciales = "{{url('/')}}/participante/alumno/credenciales/";
    route_llamadas = "{{url('/')}}/participante/alumno/llamadas/";
    route_email="{{url('/')}}/correo/sesion";
    route_agregar_cantidad="{{url('/')}}/participante/alumno/agregar_cantidad";
    route_eliminar_cantidad="{{url('/')}}/participante/alumno/eliminar_cantidad/";
    route_cancelar_cantidad="{{url('/')}}/participante/alumno/cancelar_cantidad";
    route_agregar="{{url('/')}}/participante/alumno/crear_cuenta/";

    total = "{{$total}}";
    puntos_referidos = "{{$puntos_referidos}}";
    cantidad_actual = 0;

    $(document).ready(function(){

      $('#cantidad_actual').val(0);

      if($('#tr_contacto').data('valor') != ''){
        $("#estatus-telefono").removeClass('c-amarillo zmdi-dot-circle');
        $("#estatus-telefono").addClass('c-verde zmdi-check');
      }

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

      if(total){
        $("#total").text(formatmoney(parseFloat(total)));
      }
      else{
        $("#total").text(formatmoney(0));
      }


      if(puntos_referidos){
        $("#puntos_referidos").text(formatmoney(parseFloat(puntos_referidos)));
      }
      else{
        $("#puntos_referidos").text(0);
      }

      if("{{$alumno->alergia}}" == 1|| "{{$alumno->alergia}}" == 1 || "{{$alumno->alergia}}" == 1 || "{{$alumno->alergia}}" == 1 || "{{$alumno->alergia}}" == 1 || "{{$alumno->alergia}}" == 1){
        $('#estatus-ficha_medica').addClass('c-verde zmdi-check')
      }else{
        $('#estatus-ficha_medica').addClass('c-amarillo zmdi-dot-circle')
      }

      if("{{$alumno->alergia}}" == 1){
          $("#alergia").val('1');  //VALOR POR DEFECTO
          $("#alergia-switch").attr("checked", true); //VALOR POR DEFECTO
        }

        if("{{$alumno->asma}}" == 1){
          $("#asma").val('1');  //VALOR POR DEFECTO
          $("#asma-switch").attr("checked", true); //VALOR POR DEFECTO
        }

        if("{{$alumno->convulsiones}}" == 1){
          $("#convulsiones").val('1');  //VALOR POR DEFECTO
          $("#convulsiones-switch").attr("checked", true); //VALOR POR DEFECTO
        }

        if("{{$alumno->cefalea}}" == 1){
          $("#cefalea").val('1');  //VALOR POR DEFECTO
          $("#cefalea-switch").attr("checked", true); //VALOR POR DEFECTO
        }

        if("{{$alumno->hipertension}}" == 1){
          $("#hipertension").val('1');  //VALOR POR DEFECTO
          $("#hipertension-switch").attr("checked", true); //VALOR POR DEFECTO
        }

        if("{{$alumno->lesiones}}" == 1){
          $("#lesiones").val('1');  //VALOR POR DEFECTO
          $("#lesiones-switch").attr("checked", true); //VALOR POR DEFECTO
        }

        $("#alergia-switch").on('change', function(){
          if ($("#alergia-switch").is(":checked")){
            $("#alergia").val('1');
          }else{
            $("#alergia").val('0');
          }     
        });

      $("#asma-switch").on('change', function(){
          if ($("#asma-switch").is(":checked")){
            $("#asma").val('1');
          }else{
            $("#asma").val('0');
          }     
        });

      $("#convulsiones-switch").on('change', function(){
          if ($("#convulsiones-switch").is(":checked")){
            $("#convulsiones").val('1');
          }else{
            $("#convulsiones").val('0');
          }     
        });

      $("#cefalea-switch").on('change', function(){
          if ($("#cefalea-switch").is(":checked")){
            $("#cefalea").val('1');
          }else{
            $("#cefalea").val('0');
          }     
        });

      $("#lesiones-switch").on('change', function(){
          if ($("#lesiones-switch").is(":checked")){
            $("#lesiones").val('1');
          }else{
            $("#lesiones").val('0');
          }     
        });

      $("#hipertension-switch").on('change', function(){
          if ($("#hipertension-switch").is(":checked")){
            $("#hipertension").val('1');
          }else{
            $("#hipertension").val('0');
          }     
        });


      $('#nombre').mask('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', {'translation': {

        A: {pattern: /[A-Za-záéíóúÁÉÍÓÚ.,@*+_ñÑ ]/}
        }

      });

      $('#apellido').mask('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', {'translation': {

        A: {pattern: /[A-Za-záéíóúÁÉÍÓÚ.,@*+_ñÑ ]/}
        }

      });

        $('body,html').animate({scrollTop : 0}, 500);
        var animation = 'fadeInLeftBig';
        if (animation === "hinge") {
        animationDuration = 3100;
        }
        else {
        animationDuration = 3200;
        }
        $(".container").addClass('animated '+animation);

            setTimeout(function(){
                $(".card-body").removeClass(animation);
            }, animationDuration);

      });

    $('#modalID-Alumno').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#identificacion").val($("#alumno-identificacion").text()); 
    })
    $('#modalNombre-Alumno').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#nombre").val($("#alumno-nombre").text()); 
      $("#apellido").val($("#alumno-apellido").text());
    })
    $('#modalFechaNacimiento-Alumno').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#fecha_nacimiento").val($("#alumno-fecha_nacimiento").text()); 
    })
    $('#modalSexo-Alumno').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var sexo=$("#alumno-sexo").data('valor');
      if(sexo=="M"){
        $("#hombre").prop("checked", true);
      }else{
        $("#mujer").prop("checked", true);
      }
      
    })
    
     $('#modalCorreo-Alumno').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#correo").val($("#alumno-correo").text()); 
    })

    $('#modalTelefono-Alumno').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#telefono").val($("#alumno-telefono").text());
      $("#celular").val($("#alumno-celular").text()); 
    })

    $('#modalDireccion-Alumno').on('show.bs.modal', function (event) {
      limpiarMensaje();
       var direccion=$("#alumno-direccion").data('valor');
       $("#direccion").val(direccion);
    })

    $('#modalCostoMensualidad-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
    })

    $('#modalImagen-Alumno').on('show.bs.modal', function (event) {
      limpiarMensaje();

      Webcam.set({
        width: 300,
        height: 300,
        image_format: 'jpeg',
        jpeg_quality: 90
      });

      Webcam.attach('#webcam');
      $('#snapshot').prop('checked',true)
      
    })

    $('#modalImagen-Alumno').on('hidden.bs.modal', function (event) {
      Webcam.reset();
    })

    function take_snapshot() {
      Webcam.snap(function(data_uri) {
        $('#img_snapshot').attr('src',data_uri)
        $("input:hidden[name=imageBase64]").val(data_uri);
      });
      $('#delete_snapshot').show()
    }

    $("#delete_snapshot").click(function(){
      $('#img_snapshot').attr('src','')
      $("input:hidden[name=imageBase64]").val('');
      $('#delete_snapshot').hide()
    });

     $("input[name=tipo_imagen]").on('change', function(){
      if ($(this).val() == 1){
        Webcam.set({
          width: 300,
          height: 300,
          image_format: 'jpeg',
          jpeg_quality: 90
        });

        Webcam.attach('#webcam');
        $('.snapshot').show()
        $('.upload').hide()

      }else{
        Webcam.reset()
        $('.snapshot').hide()
        $('.upload').show()
      }     
    });

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

    function limpiarMensaje(){
        var campo = ["identificacion", "nombre", "apellido", "fecha_nacimiento", "sexo", "correo", "telefono", "celular", "direccion", "fecha_pago", "costo_mensualidad", 'tipologia_id'];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
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

            if("{{$edad}}" >= 18){

              if(c.value=='M'){ 

                var valor='<i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>';                              
              }else if(c.value=='F'){
                var valor='<i class="zmdi zmdi-female f-25 c-rosado"></i> </span>';
              }
            }else{
              if(c.value=='M'){ 

                var valor='<i class="zmdi fa fa-child f-15 c-azul"></i> </span>';                              
              }else if(c.value=='F'){
                var valor='<i class="zmdi fa fa-child f-15 c-rosado"></i> </span>';
              }
            }
            $("#alumno-"+c.name).data('valor',c.value);
            $("#alumno-"+c.name).html(valor);
          }else if(c.name=='direccion'){
             $("#alumno-"+c.name).data('valor',c.value);
             $("#alumno-"+c.name).html(c.value.toLowerCase().substr(0, 30) + "...");
          }else if(c.name=='instructor_id' || c.name=='tipo_pago' || c.name=='tipologia_id'){
            
            expresion = "#"+c.name+ " option[value="+c.value+"]";
            texto = $(expresion).text();

            $("#alumno-"+c.name).text(texto);

          }else if(c.name=='cantidad_actual'){

            puntos_totales = parseInt(puntos_referidos) + parseInt(c.value)

            $('#puntos_referidos').text(formatmoney(parseFloat(puntos_totales)))
            $("#estatus-puntos_referidos").removeClass('c-youtube');
            $("#estatus-puntos_referidos").addClass('c-verde');

          }else{
            $("#alumno-"+c.name).text(c.value.toLowerCase());
          }

          if(c.value == ''){
            $("#estatus-"+c.name).removeClass('c-verde zmdi-check');
            $("#estatus-"+c.name).addClass('c-amarillo zmdi-dot-circle');
          }
          else{
            $("#estatus-"+c.name).removeClass('c-amarillo zmdi-dot-circle');
            $("#estatus-"+c.name).addClass('c-verde zmdi-check');
          }

          if(c.name == 'celular'){
            $('#tr_contacto').data('valor') == c.value;
          }

          if(c.name == 'celular' && $('#tr_contacto').data('valor') != ''){
            $("#estatus-telefono").removeClass('c-amarillo zmdi-dot-circle');
            $("#estatus-telefono").addClass('c-verde zmdi-check');
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

                  if(update == 'imagen'){
                    if(respuesta.imagen != '')
                    {
                      $('#foto_perfil').attr('src', "{{url('/')}}/assets/uploads/usuario/"+respuesta.imagen+"?timestamp=" + new Date().getTime());
                      $('#imagen_perfil').attr('src', "{{url('/')}}/assets/uploads/usuario/"+respuesta.imagen+"?timestamp=" + new Date().getTime());
                    }            
                    else
                    {
                        if('{{$alumno->sexo}}' =='F')
                        {
                          $('#foto_perfil').attr('src', "{{url('/')}}/assets/img/profile-pics/1.jpg" )
                          $('#imagen_perfil').attr('src', "{{url('/')}}/assets/img/profile-pics/1.jpg" )
                        }              
                        else{
                          $('#foto_perfil').attr('src', "{{url('/')}}/assets/img/profile-pics/2.jpg" )
                          $('#imagen_perfil').attr('src', "{{url('/')}}/assets/img/profile-pics/2.jpg" )
                        } 
                    }
                  }  

                  checkbox = $('input:checkbox:checked')

                  if(checkbox.length > 0){
                    $("#estatus-ficha_medica").removeClass('c-amarillo zmdi-dot-circle');
                    $("#estatus-ficha_medica").addClass('c-verde zmdi-check');
                  }else{
                    $("#estatus-ficha_medica").removeClass('c-verde zmdi-check');
                    $("#estatus-ficha_medica").addClass('c-amarillo zmdi-dot-circle');
                  }
  
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
                // if (typeof msj.responseJSON === "undefined") {
                //   window.location = "{{url('/')}}/error";
                // }
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

  $(".email").click(function(){
     var route = route_email;
     var token = '{{ csrf_token() }}';
            
            $.ajax({
                url: route,
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'POST',
                dataType: 'json',
                data:"&usuario_tipo=1&usuario_id={{$id}}",
                success:function(respuesta){

                    procesando();
                    window.location="{{url('/')}}/correo/{{$id}}"  

                },
                error:function(msj){
                      
                            swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                            }
            });
  });

    $("i[name=eliminar]").click(function(){
                id = this.id;
                swal({   
                    title: "Desea eliminar al alumno?",   
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

            eliminar(id);
          }
                });
      });

    $(".clase_grupal").click(function(){
        id = this.id;

        $('.inscripcion_id').val(id);

        $('#costo_mensualidad').val($(this).data('costo'));
        $('#fecha_pago').val($(this).data('fecha'));

        $('#modalCostoMensualidad-ClaseGrupal').modal('show');
               
      });

    $(".entrega").click(function(){
        id = this.id;

        $('.inscripcion_id').val(id);

        boolean_programacion = $(this).data('programacion')
        boolean_franela = $(this).data('franela')
        razon_entrega = $(this).data('entrega')
        talla_franela = $(this).data('talla')

        $('#boolean_programacion').val(boolean_programacion);
        $('#boolean_franela').val(boolean_franela);
        $('#razon_entrega').val(razon_entrega);
        $('#talla_franela').val(talla_franela);

        if(boolean_programacion == 0 || boolean_franela == 0){
          $('#textarea_entrega').show();
        }else{
          $('#textarea_entrega').hide();
        }

        if(boolean_programacion == 1){
          $("#programacion-switch").attr("checked", true); //VALOR POR DEFECTO
        }else{
          $("#programacion-switch").attr("checked", false); //VALOR POR DEFECTO
        }

        if(boolean_franela == 1){
          $("#franela-switch").attr("checked", true); //VALOR POR DEFECTO
        }else{
          $("#franela-switch").attr("checked", false); //VALOR POR DEFECTO
        }

        $('#modalEntrega-ClaseGrupal').modal('show');
               
      });
    
      function eliminar(id){
         var route = route_eliminar + id;
         var token = '{{ csrf_token() }}';
                
          $.ajax({
              url: route,
                  headers: {'X-CSRF-TOKEN': token},
                  type: 'DELETE',
              dataType: 'json',
              data:id,
              success:function(respuesta){

                  procesando();
                  window.location = route_principal; 

              },
              error:function(msj){

                swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
              }
          });
      }

      $(".historial").click(function(){

          var id = "{{$alumno->id}}";
          window.location = route_historial + id;
          
      }); 

      $(".remuneracion").click(function(){

          var id = "{{$alumno->id}}";
          window.location = route_remuneracion + id;
          
      }); 

      $(".credenciales").click(function(){

          var id = "{{$alumno->id}}";
          window.location = route_credenciales + id;
          
      }); 


      $(".llamadas").click(function(){

          var id = "{{$alumno->id}}";
          window.location = route_llamadas + id;
          
      }); 

      function countChar(val) {
        var len = val.value.length;
        if (len >= 180) {
          val.value = val.value.substring(0, 180);
        } else {
          $('#charNum').text(180 - len);
        }
      };

      $("#guardar_mensualidad").click(function(){
            swal({   
                    title: "¿Seguro deseas modificar los datos de la clase grupal?",   
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
                          
                          $('.clase-grupal-'+respuesta.id).data('costo', respuesta.costo_mensualidad);
                          $('.clase-grupal-'+respuesta.id).data('fecha', respuesta.fecha_pago);
                          $('#fecha_pago_'+respuesta.id).text(respuesta.fecha_pago);


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

        $("#guardar_entrega").click(function(){
            swal({   
                    title: "¿Seguro deseas modificar la entrega?",   
                    text: "Confirmar el cambio",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#ec6c62",   
                    confirmButtonText: "Sí, modificar",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
            if (isConfirm) {

                var route = route_update+"/entrega";
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#edit_entrega_clase_grupal" ).serialize(); 
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
                          
                          $('.clase-grupal-'+respuesta.id).data('programacion', respuesta.boolean_programacion);
                          $('.clase-grupal-'+respuesta.id).data('franela', respuesta.boolean_franela);
                          $('.clase-grupal-'+respuesta.id).data('entrega', respuesta.razon_entrega);
                          $('.clase-grupal-'+respuesta.id).data('talla', respuesta.talla_franela);

                          $('.talla_franela-'+respuesta.id).text(respuesta.talla_franela);


                          if(respuesta.boolean_franela == 1 && respuesta.boolean_programacion == 1){

                            iconos = '<i class="zmdi c-verde zmdi-check zmdi-hc-fw f-16 f-700"></i>'
                            
                          }else{
                            if(respuesta.boolean_franela == 0 && respuesta.boolean_programacion == 0)
                            {
                              iconos = '<i class="zmdi c-youtube icon_a-examen zmdi-hc-fw f-16 f-700"></i>' + ' ' + '<i class="zmdi c-youtube icon_f-productos zmdi-hc-fw f-16 f-700"></i>'
                            }else{
                              if(respuesta.boolean_franela == 1){
                                iconos = '<i class="zmdi c-youtube icon_a-examen zmdi-hc-fw f-16 f-700"></i>'
                              }else{
                                iconos = '<i class="zmdi c-youtube icon_f-productos zmdi-hc-fw f-16 f-700"></i>'
                              }
                            }
                          }

                          $('.iconos-'+respuesta.id).html(iconos);


                          finprocesado();
                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          $('#modalEntrega-ClaseGrupal').modal('hide');
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

    $('.perfil').click(function(){
      window.location = "{{url('/')}}/participante/alumno/perfil-evaluativo/{{$id}}"
    });

    $("#programacion-switch").on('change', function(){
      if ($("#programacion-switch").is(":checked")){
        $("#boolean_programacion").val('1');
      }else{
        $("#boolean_programacion").val('0');
      }  

      if ($("#franela-switch").is(":checked") && $("#programacion-switch").is(":checked")){
        $('#textarea_entrega').hide();
      }else{
        $('#textarea_entrega').show();
      }  
    });

    $("#franela-switch").on('change', function(){
      if ($("#franela-switch").is(":checked")){
        $("#boolean_franela").val('1');
      }else{
        $("#boolean_franela").val('0');
      }  

      if ($("#franela-switch").is(":checked") && $("#programacion-switch").is(":checked")){
        $('#textarea_entrega').hide();
      }else{
        $('#textarea_entrega').show();
      }  
    });

    $("#agregar_cantidad").click(function(){

      var datos = $( "#edit_referido_alumno" ).serialize(); 
      procesando();
      var route = route_agregar_cantidad;
      var token = $('input:hidden[name=_token]').val();
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

              cantidad = respuesta.cantidad;
              referidos = parseInt(respuesta.puntos_referidos);
              cantidad_actual = parseInt($('#cantidad_actual').val());
              cantidad_total = referidos + cantidad_actual;

              $('#cantidad_actual').val(cantidad_total);

              var rowId=respuesta.id;
              var rowNode=t.row.add( [
              ''+cantidad+'',
              '<i class="zmdi zmdi-delete boton red f-20 p-r-10"></i>'
              ] ).draw(false).node();
              $( rowNode )
              .attr('id',rowId)
              .addClass('seleccion');

              $('#cantidad').val('')

            }else{
              var nTitle="Ups! ";
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              var nType = 'danger';
            }                       
            $(".procesando").removeClass('show');
            $(".procesando").addClass('hidden');
            $("#guardar").removeAttr("disabled");
            finprocesado();
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

    $('#tablelistar tbody').on( 'click', 'i.zmdi-delete boton red', function () {
      var padre=$(this).parents('tr');
      var token = $('input:hidden[name=_token]').val();
      var id = $(this).closest('tr').attr('id');
      $.ajax({
        url: route_eliminar_cantidad+id,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',                
        success: function (data) {
          if(data.status=='OK'){

            referidos = parseInt(data.puntos_referidos);
            cantidad_actual = parseInt($('#cantidad_actual').val());
            cantidad_total = cantidad_actual - referidos;
          
            $('#cantidad_actual').val(cantidad_total);

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

    var t=$('#tablelistar').DataTable({
      processing: true,
      serverSide: false, 
      bPaginate: false, 
      bFilter:false, 
      bSort:false, 
      order: [[0, 'asc']],
      fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
        $('td:eq(0),td:eq(1)', nRow).addClass( "text-center" );
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
    
    function formatmoney(n) {
      return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    }

    $(".reservar").click(function(){

        procesando();
        var route = "{{url('/')}}/reservacion/guardar-tipo-usuario/1";
        var token = '{{ csrf_token() }}';
            
        $.ajax({
            url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
            dataType: 'json',
            success:function(respuesta){
                window.location = "{{url('/')}}/agendar/reservaciones/actividades/{{$id}}"

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
                        finprocesado();
                        swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                        }
        });
    });

    $(".usuario").click(function(){
      element = this;
      swal({   
        title: "Desea crearle la cuenta al alumno?",   
        text: "Confirmar creación!",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: "Crear!",  
        cancelButtonText: "Cancelar",         
        closeOnConfirm: true 
      }, function(isConfirm){   
        if (isConfirm) {

          procesando();
          var token = '{{ csrf_token() }}';
          var route = route_agregar + "{{$id}}";
                
          $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            success:function(respuesta){
              finprocesado();
              swal('Exito!','La cuenta ha sido creada','success');
              $(element).hide();
              $('.email').show();

            },
            error:function(msj){
              swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
              finprocesado();
            }
          });
        }
      });
    });


   </script> 
  
		
@stop
