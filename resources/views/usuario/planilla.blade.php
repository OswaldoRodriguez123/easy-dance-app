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
            <div class="modal fade" id="modalNombre-Usuario" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Usuario<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_nombre_usuario" id="edit_nombre_usuario"  >
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_nombre_usuario" data-update="nombre" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalFechaNacimiento-Usuario" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Usuario<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_fecha_nacimiento_usuario" id="edit_fecha_nacimiento_usuario"  >
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_fecha_nacimiento_usuario" data-update="fecha_nacimiento" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalSexo-Usuario" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Usuario<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_sexo_usuario" id="edit_sexo_usuario"  >
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
                                        Mujer <i class="zmdi zmdi-female p-l-5 f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="sexo" id="hombre" value="M" type="radio">
                                        <i class="input-helper"></i>  
                                        Hombre <i class="zmdi zmdi-male-alt p-l-5 f-20"></i>
                                    </label>
                                    </div>
                                    
                                 </div>
                                 <div class="has-error" id="error-sexo">
                                      <span >
                                          <small class="help-block error-span" id="error-sexo_mensaje" ></small>                                           
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_sexo_usuario" data-update="sexo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>
                             
                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalCorreo-Usuario" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Usuario<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_correo_usuario" id="edit_correo_usuario"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="correo">Correo</label>
                                    <input type="text" class="form-control input-sm" name="email" id="email" placeholder="Ej. example@correo.com">
                                 </div>
                                 <div class="has-error" id="error-email">
                                      <span >
                                          <small class="help-block error-span" id="error-email_mensaje" ></small>                                
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_correo_usuario" data-update="correo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalTelefono-Usuario" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Usuario<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_telefono_usuario" id="edit_telefono_usuario"  >
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_telefono_usuario" data-update="telefono" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalDireccion-Usuario" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Usuario<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_direccion_usuario" id="edit_direccion_usuario"  >
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_direccion_usuario" data-update="direccion" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalRedes-Usuario" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Usuario<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_redes_usuario" id="edit_redes_usuario"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-6">
                                             <label for="id">Facebook  </label>
                                             <div class="input-group">
                                              <span class="input-group-addon">
                                              <i class="zmdi zmdi-facebook-box f-20 c-facebook"></i>
                                              </span>
                                              <div class="fg-line">                       
                                               <input type="text" class="form-control caja input-sm" name="facebook" id="facebook" placeholder="Ingresa la url" value = "{{Auth::user()->facebook}}">
                                              </div>
                                            </div>
                                              <div class="has-error" id="error-facebook">
                                                <span >
                                                    <small id="error-facebook_mensaje" class="help-block error-span" ></small>                                           
                                                </span>
                                              </div>
                                          
                                         </div>
                                         <div class="col-sm-6">
                                              <label for="id">Twitter</label>
                                              <div class="input-group">
                                              <span class="input-group-addon">
                                              <i class="zmdi zmdi-twitter-box f-20 c-twitter"></i>
                                              </span>
                                              <div class="fg-line">
                                                  
                                                  <input type="text" class="form-control caja input-sm" name="twitter" id="twitter" placeholder="Ingresa la url" value = "{{Auth::user()->twitter}}">
                                              </div>
                                              </div>
                                              <div class="has-error" id="error-twitter">
                                                <span >
                                                    <small id="error-twitter_mensaje" class="help-block error-span" ></small>                                           
                                                </span>
                                              </div>
                                          
                                         </div>

                                         <div class="clearfix p-b-35"></div>

                                         <div class="col-sm-6">
                                          <label for="id">Instagram</label>
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                              <i class="zmdi zmdi-instagram f-20 c-instagram"></i>
                                              </span>
                                              <div class=" fg-line">
                                                  
                                                  <input type="text" class="form-control caja input-sm" name="instagram" id="instagram" placeholder="Ingresa la url" value = "{{Auth::user()->instagram}}">
                                              </div>
                                            </div>
                                              <div class="has-error" id="error-instagram">
                                                <span >
                                                    <small id="error-instagram_mensaje" class="help-block error-span" ></small>                                           
                                                </span>
                                              </div>
                                          
                                         </div>
                                         <div class="col-sm-6">
                                            <label for="id">Página web</label>
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                              <i class="zmdi zmdi-link f-20 c-morado"></i>
                                              </span>
                                              <div class="fg-line">                       
                                                  <input type="text" class="form-control caja input-sm" name="web" id="web" placeholder="Ej: www.easydancelatino.com" value = "{{Auth::user()->pagina_web}}">
                                              </div>
                                            </div>
                                              <div class="has-error" id="error-web">
                                                <span >
                                                    <small id="error-web_mensaje" class="help-block error-span" ></small>                                           
                                                </span>
                                              </div>
                                          
                                         </div>

                                         <div class="clearfix p-b-35"></div>

                                         <div class="col-sm-6">
                                            <label for="id">Linkedin</label>
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                              <i class="zmdi zmdi-linkedin-box f-20 c-linkedin"></i>
                                              </span>
                                              <div class="fg-line">                       
                                                  <input type="text" class="form-control caja input-sm" name="linkedin" id="linkedin" placeholder="Ingresa la url" value = "{{Auth::user()->linkedin}}">
                                              </div>
                                            </div>
                                              <div class="has-error" id="error-linkedin">
                                                <span >
                                                    <small id="error-linkedin_mensaje" class="help-block error-span" ></small>                                           
                                                </span>
                                              </div>
                                          
                                         </div>
                                         <div class="col-sm-6">
                                              
                                            <label for="id">Youtube</label>
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                              <i class="zmdi zmdi-collection-video f-20 c-youtube"></i>
                                              </span>
                                              <div class="fg-line">                       
                                                  <input type="text" class="form-control caja input-sm" name="youtube" id="youtube" placeholder="Ingresa la url" value = "{{Auth::user()->youtube}}">
                                              </div>
                                            </div>
                                              <div class="has-error" id="error-youtube">
                                                <span >
                                                    <small id="error-youtube_mensaje" class="help-block error-span" ></small>                                           
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_redes_usuario" data-update="redes" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalContrasena-Usuario" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Usuario<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_password_usuario" id="edit_password_usuario"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12 ">
                                 <div class="form-group">
                                    <label for="correo">Contraseña</label>
                                    <span class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-lock f-22"></i></span>
                                    <div class="fg-line">
                                    <input type="password" class="form-control input-sm" name="password" id="password" placeholder="Mínimo de 6 caracteres">
                                    </div>
                                    </span>
                                 </div>
                                 <div class="has-error" id="error-password">
                                    <span >
                                     <small id="error-password_mensaje" class="help-block error-span" ></small>
                                    </span>
                                    </div>
                               </div>

                               <div class="clearfix"></div> 

                                <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="direccion">Confirmar tu contraseña</label>
                                    <span class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-lock f-22"></i></span>
                                    <div class="fg-line">
                                    <input type="password" class="form-control input-sm" name="password_confirmation" id="password_confirmation" placeholder="Repite tu contraseña">
                                    </div>
                                    </span>
                                 </div>
                                 <div class="has-error" id="error-password_confirmation">
                                    <span >
                                     <small id="error-password_confirmation_mensaje" class="help-block error-span" ></small>
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_password_usuario" data-update="password" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalImagen-Usuario" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Usuario<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_imagen_usuario" id="edit_imagen_usuario"  >
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
                                          @if(Auth::user()->imagen)
                                            <img src="{{url('/')}}/assets/uploads/usuario/{{Auth::user()->imagen}}" style="line-height: 150px;">
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_imagen_usuario" data-update="imagen" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            
     
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                      @if(Auth::user()->usuario_tipo == 1 OR Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6)
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-reservaciones f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>

                         <br><br>
                        @endif
                    </div>
                    
                    <div class="card">
                      <div class="card-header">

                      @if(Auth::user()->usuario_tipo == 2 OR Auth::user()->usuario_tipo == 4)

                        <div class="card-header text-center">

                          <div class="col-xs-12 text-left">
                            <ul class="tab-nav tn-justified" role="tablist">
                                      <li class="waves-effect active"><a href="{{url('/')}}/perfil" aria-controls="home11" onclick="procesando()"><div class="zmdi zmdi-account f-30" style="margin-top:10px"></div><p>Perfil</p></a></li>
                                      <li class="waves-effect"><a href="{{url('/')}}/perfil-evaluativo" aria-controls="home11" onclick="procesando()"><div class="icon_a-alumnos f-30"></div><p style=" margin-bottom: -2px;">Perfil Evaluativo</p></a></li>
                                      
                              </ul>
                              </div>

                              <div class="clearfix p-b-15"></div>
                                                                                       
                          </div>

                        @endif
                            
                            
                      </div>
                      <div class="card-body p-b-20">
                        <div class="row">
                        <div class="container">
                         <div class="col-sm-3">
                            <div class="p-t-30">       
                              <div class="row p-b-15 ">
                                <div class="col-md-12" data-src="/assets/img/ayuda-configuracion.jpg">
                                  <div class="text-center col-md-offset-2">


                                      @if(Auth::user()->imagen)
                                        <img id="imagen_perfil" src="{{url('/')}}/assets/uploads/usuario/{{Auth::user()->imagen}}" class="img-responsive">
                                      @else
                                        @if(Auth::user()->sexo =='F')

                                        <img id="imagen_perfil" src="{{url('/')}}/assets/img/profile-pics/1.jpg" height="300" width="300" class="img-responsive">
                                        @else
                                        <img id="imagen_perfil" src="{{url('/')}}/assets/img/profile-pics/2.jpg" height="300" width="300" class="img-responsive">
                                        @endif
                                      @endif

                                      <div class="clearfix p-b-35"></div>

                                      <div class="text-center">
                                        <a data-toggle="modal" href="#modalImagen-Usuario" class="btn-blanco m-r-10 f-16" href="{{url('/')}}/especiales/campañas">Cambiar Imagen</a>
                                      </div>
              
                                  </div>

                              </div>                
                            </div>
                          </div>
                        </div>

                      <div class="col-sm-9">

                         <div class="col-sm-12">
                              <p class="text-center opaco-0-8 f-22">Datos del Usuario</p>
                          </div>

                          <div class="col-sm-12">
                           <table class="table table-striped table-bordered">
                            <tr class="detalle" data-toggle="modal" href="#modalNombre-Usuario">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-nombre" class="zmdi {{ empty(Auth::user()->nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-accounts-alt f-22"></i> </span>
                               <span class="f-14"> Nombres </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="usuario-nombre" class="capitalize">{{Auth::user()->nombre}}</span> <span id="usuario-apellido" class="capitalize">{{Auth::user()->apellido}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                             <tr class="detalle" data-toggle="modal" href="#modalSexo-Usuario">
                             <td> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-sexo" class="zmdi {{ empty(Auth::user()->sexo) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                              <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-male-female f-22"></i> </span>
                              <span class="f-14"> Sexo </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="usuario-sexo" data-valor="{{Auth::user()->sexo}}">
                               @if(Auth::user()->sexo=='F')
                                  <i class="zmdi zmdi-female f-25 c-rosado"></i> </span>
                               @else
                                  <i class="zmdi zmdi-male f-25 c-azul"></i> </span>
                               @endif
                             </span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalCorreo-Usuario">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-correo" class="zmdi {{ empty(Auth::user()->email) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-correo f-22"></i> </span>
                               <span class="f-14"> Correo </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="usuario-email"><span>{{Auth::user()->email}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalTelefono-Usuario">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-telefono" class="zmdi {{ empty(Auth::user()->telefono) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b icon_b-telefono f-22"></i> </span>
                               <span class="f-14"> Contacto </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="usuario-telefono">{{Auth::user()->telefono}}</span> / <span id="usuario-celular">{{Auth::user()->celular}}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalDireccion-Usuario">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-direccion" class="zmdi {{ empty(Auth::user()->direccion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-pin-drop zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Dirección </span>
                             </td>
                             <td id="usuario-direccion" class="f-14 m-l-15 capitalize" data-valor="{{Auth::user()->direccion}}" >{{ str_limit(Auth::user()->direccion, $limit = 30, $end = '...') }}<span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalRedes-Usuario">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-facebook" class="zmdi {{ empty(Auth::user()->facebook) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-share zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Redes Sociales </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="usuario-redes"></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalContrasena-Usuario">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-empresa" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-lock-outline zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Contraseña </span>
                             </td>
                             <td class="f-14 m-l-15" > <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            @if(isset($alumno))
                            <tr class="disabled">
                             <td> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="codigo" class="zmdi {{ empty($alumno->codigo_referido) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                              <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-male-female f-22"></i> </span>
                              <span class="f-14"> Codigo para referir </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="alumno-codigo" data-valor="{{$alumno->codigo_referido}}">
                              <span id="alumno-nombre" class="capitalize">{{$alumno->codigo_referido}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            @endif

                           </table>

                          
                          <div class="clearfix"></div>   
               
           
                          </div>
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
    route_update="{{url('/')}}/perfil/update";

    var image64 = '';

    $(document).ready(function(){

      $('#nombre').mask('AAAAAAAAAAAAAAAAAAAA', {'translation': {

        A: {pattern: /[A-Za-záéíóúÁÉÍÓÚ.,@*+_ñÑ ]/}
        }

      });

      $('#apellido').mask('AAAAAAAAAAAAAAAAAAAA', {'translation': {

        A: {pattern: /[A-Za-záéíóúÁÉÍÓÚ.,@*+_ñÑ ]/}
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

    $('#modalNombre-Usuario').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#nombre").val($("#usuario-nombre").text()); 
      $("#apellido").val($("#usuario-apellido").text());
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

    $('#modalCorreo-Usuario').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#email").val($("#usuario-email").text()); 
    })

    $('#modalTelefono-Usuario').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#telefono").val($("#usuario-telefono").text());
      $("#celular").val($("#usuario-celular").text()); 
    })

    $('#modalDireccion-Usuario').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var direccion=$("#usuario-direccion").data('valor');
       $("#direccion").val(direccion);
    })

    $('#modalSexo-Usuario').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var sexo=$("#usuario-sexo").data('valor');
      if(sexo=="M"){
        $("#hombre").prop("checked", true);
      }else{
        $("#mujer").prop("checked", true);
      }
      
    })

    function limpiarMensaje(){
        var campo = ["nombre", "apellido", "sexo", "email", "telefono", "celular", "direccion", "password", "password_confirmation"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
        console.log(merror);
        var campo = ["nombre", "apellido", "sexo", "email", "telefono", "celular", "direccion", "password", "password_confirmation"];
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
            $("#usuario-"+c.name).data('valor',c.value);
            $("#usuario-"+c.name).html(valor);
          }else if(c.name=='direccion'){
             $("#usuario-"+c.name).data('valor',c.value);
             $("#usuario-"+c.name).html(c.value.toLowerCase().substr(0, 30) + "...");
            //$("#alumno-"+c.name).text(c.value.substr(0, 30));
          }else{
            $("#usuario-"+c.name).text(c.value.toLowerCase());
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

    // OBSERVER: ESTE OBSERVER SE HACE CON LA FINALIDAD DE DETECTAR CUANDO SE CAMBIA LA IMAGEN, ESTE MODIFIQUE EL IMAGEBASE64
    // var target = $('#imagena')[0];

    // var observer = new MutationObserver(function(mutations) {
    //   mutations.forEach(function(mutation) {
    //     if(mutation.type == 'childList' && mutation.addedNodes.length > 0)
    //     {
    //       procesando();
          
    //       setTimeout(function(){ 
    //         var imagen = $("#imagena img").attr('src');
    //         var canvas = document.createElement("canvas");

    //         var context=canvas.getContext("2d");
    //         var img = new Image();
    //         img.src = imagen;
            
    //         canvas.width  = img.width;
    //         canvas.height = img.height;

    //         context.drawImage(img, 0, 0);
     
    //         var newimage = canvas.toDataURL("image/jpeg", 0.8);
    //         var image64 = $("input:hidden[name=imageBase64]").val(newimage).trigger('change');

    //       }, 1000);

    //     }
    //   });    
    // });
     
    // var config = { attributes: true, childList: true, characterData: true };
    // observer.observe(target, config);

    //FIN OBSERVER
  
    //  $('#imageBase64').change(function(){
          
    //   var route = route_update + "/imagen";
    //   var token = $('input:hidden[name=_token]').val();
    //   var datos = $( "#form_imagen" ).serialize();
    //   $("#guardar").attr("disabled","disabled");
    //   $("#guardar").css({
    //     "opacity": ("0.2")
    //   });
    //   $(".cancelar").attr("disabled","disabled");
    //   $(".procesando").removeClass('hidden');
    //   $(".procesando").addClass('show');         
    //   limpiarMensaje();
    //   $.ajax({
    //       url: route,
    //           headers: {'X-CSRF-TOKEN': token},
    //           type: 'PUT',
    //           dataType: 'json',
    //           data:datos,
    //       success:function(respuesta){
    //         setTimeout(function(){ 
    //           var nFrom = $(this).attr('data-from');
    //           var nAlign = $(this).attr('data-align');
    //           var nIcons = $(this).attr('data-icon');
    //           var nAnimIn = "animated flipInY";
    //           var nAnimOut = "animated flipOutY"; 
    //           if(respuesta.status=="OK"){
    //             finprocesado();
    //             var nType = 'success';
    //             var nTitle="Ups! ";
    //             var nMensaje=respuesta.mensaje;

    //             console.log(respuesta.imagen)
    //             if(respuesta.imagen != '')
    //             {
    //               $('#foto_perfil').attr('src', "{{url('/')}}/assets/uploads/usuario/"+respuesta.imagen+"?timestamp=" + new Date().getTime());
    //             }            
    //             else
    //             {
    //                 if('{{Auth::user()->sexo}}' =='F')
    //                 {
    //                   $('#foto_perfil').attr('src', "{{url('/')}}/assets/img/profile-pics/1.jpg" )
    //                 }              
    //                 else{
    //                   $('#foto_perfil').attr('src', "{{url('/')}}/assets/img/profile-pics/2.jpg" )
    //                 } 
    //             }
                
    //           }else{
    //             var nTitle="Ups! ";
    //             var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
    //             var nType = 'danger';

    //             $(".procesando").removeClass('show');
    //             $(".procesando").addClass('hidden');
    //             $("#guardar").removeAttr("disabled");
    //             finprocesado();
    //             $("#guardar").css({
    //               "opacity": ("1")
    //             });
    //             $(".cancelar").removeAttr("disabled");

    //           } 

    //           notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);                      
              
    //         }, 3000);
    //       },
    //       error:function(msj){
    //         setTimeout(function(){ 
    //           if (typeof msj.responseJSON === "undefined") {
    //             window.location = "{{url('/')}}/error";
    //           }
    //           if(msj.responseJSON.status=="ERROR"){
    //             console.log(msj.responseJSON.errores);
    //             errores(msj.responseJSON.errores);
    //             var nTitle="    Ups! "; 
    //             var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
    //           }else{
    //             var nTitle="   Ups! "; 
    //             var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
    //           }                        
    //           $("#guardar").removeAttr("disabled");
    //           finprocesado();
    //           $("#guardar").css({
    //             "opacity": ("1")
    //           });
    //           $(".cancelar").removeAttr("disabled");
    //           $(".procesando").removeClass('show');
    //           $(".procesando").addClass('hidden');
    //           var nFrom = $(this).attr('data-from');
    //           var nAlign = $(this).attr('data-align');
    //           var nIcons = $(this).attr('data-icon');
    //           var nType = 'danger';
    //           var nAnimIn = "animated flipInY";
    //           var nAnimOut = "animated flipOutY";                       
    //           notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
    //         }, 1000);
    //       }
    //   });      
    // });

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

                  if(update == 'imagen'){
                    if(respuesta.imagen != '')
                    {
                      $('#foto_perfil').attr('src', "{{url('/')}}/assets/uploads/usuario/"+respuesta.imagen+"?timestamp=" + new Date().getTime());
                      $('#imagen_perfil').attr('src', "{{url('/')}}/assets/uploads/usuario/"+respuesta.imagen+"?timestamp=" + new Date().getTime());
                    }            
                    else
                    {
                        if('{{Auth::user()->sexo}}' =='F')
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
                if (typeof msj.responseJSON === "undefined") {
                          window.location = "{{url('/')}}/error";
                        }
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

    function countChar(val) {
        var len = val.value.length;
        if (len >= 180) {
          val.value = val.value.substring(0, 180);
        } else {
          $('#charNum').text(180 - len);
        }
      };
    
   </script>   
    
@stop
