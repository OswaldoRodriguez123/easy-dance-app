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
     
          <div class="modal fade" id="modalNombre-Campana" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Campaña<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_nombre_campana" id="edit_nombre_campana"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Nombre</label>
                                        <input type="text" class="form-control input-sm" name="nombre" id="nombre" placeholder="50 Caracteres" value="{{$campana->nombre}}">
                                    </div>
                                    <div class="has-error" id="error-nombre">
                                      <span >
                                          <small id="error-nombre_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$campana->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" data-formulario="edit_nombre_campana" data-update="nombre" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalEslogan-Campana" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Campaña<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_eslogan_campana" id="edit_eslogan_campana"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Eslogan</label>
                                        <input type="text" class="form-control input-sm" name="eslogan" id="eslogan" placeholder="Todos unidos por una sola causa" value="{{$campana->eslogan}}">
                                    </div>
                                    <div class="has-error" id="error-eslogan">
                                      <span >
                                          <small id="error-eslogan_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$campana->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" data-formulario="edit_eslogan_campana" data-update="eslogan" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalHistoria-Campana" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Campaña<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_historia_campana" id="edit_historia_campana"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="edad">Historia</label>
                                    <textarea class="form-control" id="historia" name="historia" rows="2" placeholder="250 Caracteres"></textarea>
                                 </div>
                                 <div class="has-error" id="error-historia">
                                      <span >
                                          <small class="help-block error-span" id="error-historia_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 

                               <input type="hidden" name="id" value="{{$campana->id}}"></input>

                               
                               
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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_historia_campana" data-update="historia" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalCantidad-Campana" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Campaña<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_cantidad_campana" id="edit_cantidad_campana"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Cantidad</label>
                                        <input type="text" class="form-control input-sm input-mask" name="cantidad" id="cantidad" data-mask="0000000000" placeholder="Ej. 50000" value="{{$campana->cantidad}}">
                                    </div>
                                    <div class="has-error" id="error-cantidad">
                                      <span >
                                          <small id="error-cantidad_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$campana->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" data-formulario="edit_cantidad_campana" data-update="cantidad" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalPlazo-Campana" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Campaña<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_plazo_campana" id="edit_plazo_campana"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Plazo</label>
                                        <input type="text" class="form-control input-sm input-mask" name="plazo" id="plazo" data-mask="00" placeholder="Ej. 35" value="{{$campana->plazo}}">
                                    </div>
                                    <div class="has-error" id="error-plazo">
                                      <span >
                                          <small id="error-plazo_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$campana->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" data-formulario="edit_plazo_campana" data-update="plazo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalImagen-Campana" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Campaña<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_imagen_campana" id="edit_imagen_campana"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group text-center">
                                    <div class="form-group fg-line">
                                        <label for="id">Cargar Imagen</label>
                                        <div class="clearfix p-b-15"></div>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div id="imagena" class="fileinput-preview thumbnail" data-trigger="fileinput"></div>
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

                               <input type="hidden" name="id" value="{{$campana->id}}"></input>
                              

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

                              <a class="btn-morado m-r-5 f-12 guardar" id="guardar" data-formulario="edit_imagen_campana" data-update="imagen" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalLink-Campana" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Campaña<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_link_campana" id="edit_link_campana"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Link Promocional</label>
                                        <div class="fg-line">                       
                                        <input type="text" class="form-control caja input-sm" name="link_video" id="link_video" placeholder="Ingresa la url" value="{{$campana->link_video}}">
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-link_video">
                                      <span >
                                          <small id="error-link_video_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$campana->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" data-formulario="edit_link_campana" data-update="video" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalDatos-Campana" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Editar Campaña<button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>

                        <form name="edit_datos_campana" id="edit_datos_campana"  >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="modal-body">
                        
                          <div class="row p-t-20 p-b-0">
                            
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Nombre del Banco</label>
                                        <div class="fg-line">                       
                                        <input type="text" class="form-control input-sm" name="nombre_banco" id="nombre_banco" placeholder="Banco del Tesoro" value="{{$campana->nombre_banco}}">
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-nombre_banco">
                                      <span >
                                          <small id="error-nombre_banco_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>
                                     

                                    <div class="clearfix p-b-35"></div>

                                    <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-group fg-line">
                                            <label for="id">Tipo de Cuenta</label>
                                            <div class="fg-line">                       
                                            <input type="text" class="form-control input-sm" name="tipo_cuenta" id="tipo_cuenta" placeholder="Cuenta Corriente" value="{{$campana->tipo_cuenta}}">
                                          </div>
                                        </div>
                                        <div class="has-error" id="error-tipo_cuenta">
                                          <span >
                                              <small id="error-tipo_cuenta_mensaje" class="help-block error-span" ></small>                                           
                                          </span>
                                        </div>
                                    </div>
                                   </div>

                               <div class="clearfix p-b-35"></div>

                                    <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-group fg-line">
                                            <label for="id">Número de Cuenta</label>
                                            <div class="fg-line">                       
                                            <input type="text" class="form-control input-sm input-mask" name="numero_cuenta" id="numero_cuenta" data-mask="0000-0000-00-0000000000" placeholder="Ingresa Número de Cuenta" value="{{$campana->numero_cuenta}}">
                                          </div>
                                        </div>
                                        <div class="has-error" id="error-numero_cuenta">
                                          <span >
                                              <small id="error-numero_cuenta_mensaje" class="help-block error-span" ></small>                                           
                                          </span>
                                        </div>
                                    </div>
                                   </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-group fg-line">
                                            <label for="id">Rif - Cédula</label>
                                            <div class="fg-line">                       
                                            <input type="text" class="form-control input-sm" name="rif" id="rif" placeholder="Ingresa Numero de Cuenta" value="{{$campana->rif}}">
                                          </div>
                                        </div>
                                        <div class="has-error" id="error-rif">
                                          <span >
                                              <small id="error-rif_mensaje" class="help-block error-span" ></small>                                           
                                          </span>
                                        </div>
                                    </div>
                                   </div>

                               <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-group fg-line">
                                            <label for="id">Correo Electrónico</label>
                                            <div class="fg-line">                       
                                            <input type="text" class="form-control input-sm" name="correo" id="correo" placeholder="Ej. easydance@gmail.com" value="{{$campana->correo}}">
                                          </div>
                                        </div>
                                        <div class="has-error" id="error-correo">
                                          <span >
                                              <small id="error-correo_mensaje" class="help-block error-span" ></small>                                           
                                          </span>
                                        </div>
                                    </div>
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

                            <input type="hidden" name="id" value="{{$campana->id}}"></input>
                            
                            <div class="col-sm-12">                            

                              <a class="btn-blanco m-r-5 f-16 guardar" id="guardar" data-formulario="edit_datos_campana" data-update="datos" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>

                        </div>
                        </div>
                        </div></form>
                    </div>
                </div>
            </div>
            
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                       <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/especiales/campañas" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Campaña</a>
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
                                            <span class="ca-icon-planilla"><i class="icon_a icon_a-campana"></i></span>
                                            <div class="ca-content-planilla">
                                                <h2 class="ca-main-planilla">Vista Campaña</h2>
                                                <h3 class="ca-sub-planilla">Personaliza el campo campaña</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>

                                  <div class="col-sm-12 text-center"> 

                                  <br></br>

                                  <span class="f-16 f-700">Acciones</span>

                                  <hr></hr>
                                  
                                  <i class="zmdi zmdi-delete f-20 m-r-10 boton red sa-warning" id="{{$campana->id}}" name="eliminar" data-original-title="Eliminar" data-toggle="tooltip" data-placement="bottom" title=""></i>

                                  <br></br>
                                
                                  <hr></hr>

                                  <br></br>
                                  <a class="btn-blanco m-r-10 f-18 guardar" id="guardar"> Ver Progreso <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>
                                   
                                </div>

                                </div>                
                              </div>
                              </div>
                              </div>

					           	<div class="col-sm-9">

                         <div class="col-sm-12">
                              <p class="text-center opaco-0-8 f-22"><i class="icon_a-campana f-25"></i> Datos de la Campaña</p>
                          </div>

                          <div class="col-sm-12">
                           <table class="table table-striped table-bordered">
                            <tr class="detalle" data-toggle="modal" href="#modalNombre-Campana">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-nombre" class="zmdi {{ empty($campana->nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a icon_a-campana f-22"></i> </span>
                               <span class="f-14"> Nombre </span>
                             </td>
                             <td id="campana-nombre" class="f-14 m-l-15" data-valor="{{$campana->nombre}}" ><span id="campana-nombre"><span>{{ str_limit($campana->nombre, $limit = 30, $end = '...') }}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalHistoria-Campana">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-historia" class="zmdi {{ empty($campana->historia) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b-cuentales-historia f-22"></i> </span>
                               <span class="f-14"> Historia </span>
                             </td>
                             <td id="campana-historia" class="f-14 m-l-15" data-valor="{{$campana->historia}}" ><span id="campana-historia"><span>{{ str_limit($campana->historia, $limit = 30, $end = '...') }}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalEslogan-Campana">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-eslogan" class="zmdi {{ empty($campana->eslogan) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-flash zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Eslogan </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="campana-eslogan"><span>{{$campana->eslogan}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalCantidad-Campana">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-cantidad" class="zmdi {{ empty($campana->cantidad) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a icon_a-pagar f-22"></i> </span>
                               <span class="f-14"> Cantidad a Recaudar </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="campana-cantidad"><span>{{$campana->cantidad}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalPlazo-Campana">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-plazo" class="zmdi {{ empty($campana->nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-hourglass-alt zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Plazo de Financiamiento </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="campana-plazo"><span>{{$campana->plazo}} Dias</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalImagen-Campana">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-imagen" class="zmdi {{ empty($campana->imagen) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-collection-folder-image zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Imagen </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="campana-imagen"><span></span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalLink-Campana">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-link_video" class="zmdi {{ empty($campana->link_video) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10">  <i class="zmdi zmdi-videocam f-22"></i> </span>
                               <span class="f-14"> Link Promocional </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="campana-link"><span>{{$campana->link_video}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalDatos-Campana">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-correo" class="zmdi {{ empty($campana->correo) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_c-piggy-bank f-22"></i> </span>
                               <span class="f-14"> Datos Bancaríos </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="campana-datos"><span></span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
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
    route_update="{{url('/')}}/especiales/campañas/update";
    route_eliminar="{{url('/')}}/especiales/campañas/eliminar/";
    route_principal="{{url('/')}}/especiales/campañas";

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

    $('#modalHistoria-Campana').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var historia=$("#campana-historia").data('valor');
       $("#historia").val(historia);
    })

    $('#modalNombre-Proveedor').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#nombre").val($("#proveedor-nombre").text()); 
      $("#apellido").val($("#proveedor-apellido").text());
    })
    $('#modalFechaNacimiento-Proveedor').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#fecha_nacimiento").val($("#proveedor-fecha_nacimiento").text()); 
    })
    $('#modalSexo-Proveedor').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var sexo=$("#proveedor-sexo").data('valor');
      if(sexo=="M"){
        $("#hombre").prop("checked", true);
      }else{
        $("#mujer").prop("checked", true);
      }
      
    })

    $('#modalCorreo-Proveedor').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#correo").val($("#proveedor-correo").text()); 
    })

    $('#modalTelefono-Proveedor').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#telefono").val($("#proveedor-telefono").text());
      $("#celular").val($("#proveedor-celular").text()); 
    })

    $('#modalEmpresa-Proveedor').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#empresa").val($("#proveedor-empresa").text());
    })


    function limpiarMensaje(){
        var campo = ["nombre", "apellido", "sexo", "correo", "telefono", "celular", "empresa"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
        console.log(merror);
        var campo = ["nombre", "apellido", "sexo", "correo", "telefono", "celular", "empresa"];
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
            $("#campana-"+c.name).data('valor',c.value);
            $("#campana-"+c.name).html(valor);
          }else if(c.name=='historia'){
             $("#campana-"+c.name).data('valor',c.value);
             $("#campana-"+c.name).html(c.value.substr(0, 30) + "...");
            //$("#alumno-"+c.name).text(c.value.substr(0, 30));
          }else if(c.name=='nombre'){
             $("#campana-"+c.name).data('valor',c.value);
             $("#campana-"+c.name).html(c.value.substr(0, 30) + "...");
            //$("#alumno-"+c.name).text(c.value.substr(0, 30));
          }else{
            $("#campana-"+c.name).text(c.value);
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
                    title: "Desea eliminar la campaña",   
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
