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
     
          
            <div class="modal fade" id="modalContacto-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Academia<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_contacto_academia" id="edit_contacto_academia"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">

                            <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="telefono">Teléfono Local</label>
                                    <div class="input-group">
                                              <span class="input-group-addon">
                                              <i class="icon_b icon_b-telefono f-20"></i>
                                              </span>
                                              <div class="fg-line">                       
                                              <input type="text" class="form-control input-sm input-mask" name="telefono" id="telefono" data-mask="(000)000-0000" placeholder="Ej: (426)367-0894" value="{{$academia->telefono}}">
                                              </div>
                                            </div>
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
                                    <label for="celular">Teléfono Móvil</label>
                                    <div class="input-group">
                                              <span class="input-group-addon">
                                              <i class="icon_b icon_b-telefono f-20"></i>
                                              </span>
                                              <div class="fg-line">                       
                                              <input type="text" class="form-control input-sm input-mask" name="celular" id="celular" data-mask="(000)000-0000" placeholder="Ej: (426)367-0894" value="{{$academia->celular}}">
                                              </div>
                                            </div>
                                 </div>
                                 <div class="has-error" id="error-celular">
                                      <span >
                                          <small class="help-block error-span" id="error-celular_mensaje"  ></small>                                           
                                      </span>
                                  </div>
                               </div>
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="correo">Correo electrónico</label>
                                    
                                    <div class="input-group">
                                              <span class="input-group-addon">
                                              <i class="icon_a icon_a-correo f-20"></i>
                                              </span>
                                              <div class="fg-line">                       
                                              <input type="text" class="form-control input-sm" name="correo" id="correo" placeholder="Ej. example@correo.com" value="{{$academia->correo}}">
                                              </div>
                                            </div>
                                 </div>
                                 <div class="has-error" id="error-correo">
                                      <span >
                                          <small class="help-block error-span" id="error-correo_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="correo">Dirección</label>
                                    <div class="input-group">
                                              <span class="input-group-addon">
                                              <i class="zmdi zmdi-pin-drop zmdi-hc-fw f-20"></i>
                                              </span>
                                              <div class="fg-line">                       
                                              <textarea class="form-control" id="direccion" name="direccion" rows="1" placeholder="Ej. Avenida 10 con Calle 70" value="{{$academia->direccion}}"  maxlength="180" onkeyup="countCharDir(this)"></textarea>
                                              </div>
                                              <div class="opaco-0-8 text-right">Resta <span id="charNumDir">180</span> Caracteres</div>
                                            </div>
                                 </div>
                                 <div class="has-error" id="error-direccion">
                                      <span >
                                          <small class="help-block error-span" id="error-direccion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 

                               <input type="hidden" name="id" value="{{$academia->id}}"></input>

                               
                               
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_contacto_academia" data-update="contacto" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalRedes-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Academia<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_redes_academia" id="edit_redes_academia"  >
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
                                               <input type="text" class="form-control caja input-sm" name="facebook" id="facebook" placeholder="Ingresa la url" value="{{$academia->facebook}}">
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
                                                  
                                                  <input type="text" class="form-control caja input-sm" name="twitter" id="twitter" placeholder="Ingresa la url" value="{{$academia->twitter}}">
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
                                                  
                                                  <input type="text" class="form-control caja input-sm" name="instagram" id="instagram" placeholder="Ingresa la url" value="{{$academia->instagram}}">
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
                                                  <input type="text" class="form-control caja input-sm" name="pagina_web" id="pagina_web" placeholder="Ej: www.easydancelatino.com" value="{{$academia->pagina_web}}">
                                              </div>
                                            </div>
                                              <div class="has-error" id="error-pagina_web">
                                                <span >
                                                    <small id="error-pagina_web_mensaje" class="help-block error-span" ></small>                                           
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
                                                  <input type="text" class="form-control caja input-sm" name="linkedin" id="linkedin" placeholder="Ingresa la url" value="{{$academia->linkedin}}">
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
                                                  <input type="text" class="form-control caja input-sm" name="youtube" id="youtube" placeholder="Ingresa la url" value="{{$academia->youtube}}">
                                              </div>
                                            </div>
                                              <div class="has-error" id="error-youtube">
                                                <span >
                                                    <small id="error-youtube_mensaje" class="help-block error-span" ></small>                                           
                                                </span>
                                              </div>
                                         </div>

                                         <div class="clearfix p-b-35"></div>

                                         <div class="col-sm-12">
                                          <div class="form-group">
                                           <div class="form-group fg-line">
                                              <label for="link_video">Link Promocional</label>
                                              <div class="input-group">
                                              <span class="input-group-addon">
                                              <i class="zmdi zmdi-videocam f-20 c-morado"></i>
                                              </span>
                                              <div class="fg-line">                       
                                                  <input type="text" class="form-control caja input-sm" name="link_video" id="link_video" placeholder="http://youtube.com" value="{{$academia->link_video}}">
                                              </div>
                                            </div>

                                           </div>
                                              <div class="has-error" id="error-link">
                                                <span >
                                                    <small id="error-link_mensaje" class="help-block error-span" ></small>                                           
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_redes_academia" data-update="redes" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalImagen-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Academia<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_imagen_academia" id="edit_imagen_academia"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group text-center">
                                    <div class="form-group fg-line">
                                        <label for="id">Cargar Logotipo</label>
                                        <div class="clearfix p-b-15"></div>
                                        <input type="hidden" name="imageBase64" id="imageBase64">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div id="imagena" class="fileinput-preview thumbnail" data-trigger="fileinput">
                                        @if($academia->imagen)
                                          <img src="{{url('/')}}/assets/uploads/academia/{{$academia->imagen}}" style="line-height: 150px;">
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

                               <input type="hidden" name="id" value="{{$academia->id}}"></input>
                              

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

                              <a class="btn-morado m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_imagen_academia" data-update="imagen" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalImagenHorizontal-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Academia<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_imagen_horizontal_academia" id="edit_imagen_horizontal_academia"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group text-center">
                                    <div class="form-group fg-line">
                                        <label for="id">Cargar Imagen Horizontal</label>
                                        <div class="clearfix p-b-15"></div>
                                        <input type="hidden" name="imageHorizontalBase64" id="imageHorizontalBase64">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div id="imagenb" class="fileinput-preview thumbnail" data-trigger="fileinput" style="width:450px">
                                        @if($academia->imagen_horizontal)
                                          <img src="{{url('/')}}/assets/uploads/academia/{{$academia->imagen_horizontal}}" style="line-height: 150px;">
                                        @endif
                                        </div>
                                        <div>
                                            <span class="btn btn-info btn-file">
                                                <span class="fileinput-new">Seleccionar Imagen</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="imagen_horizontal" id="imagen_horizontal" >
                                            </span>
                                            <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="has-error" id="error-imagen_horizontal">
                                      <span >
                                          <small id="error-imagen_horizontal_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$academia->id}}"></input>
                              

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

                              <a class="btn-morado m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_imagen_horizontal_academia" data-update="imagen_horizontal" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalEspeciales-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Academia<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_especiales_academia" id="edit_especiales_academia"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                          <label class="m-b-10">Normativas de la academia</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa las normativas de tu academia, de modo que, tus alumnos puedan descargar y conocer desde su panel de control las normas que rigen tu institución, este
                                          soporta sólo el tipo de documento en formato PDF" title="" data-original-title="Ayuda"></i><br>                                    
                                          <div id="normativa-fileinput" class="fileinput fileinput-new" data-provides="fileinput">
                                              <span class="btn btn-lg btn-file m-r-10">
                                                  <span id="normativa-fileinput-new" class="fileinput-new"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i> <br><span class="text-capitalize">Seleccionar</span></span>
                                                  <span id="normativa-fileinput-exists" class="fileinput-exists"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i></span>
                                                  <input type="file" name="normativa" id="normativa">
                                              </span>
                                              <span id="normativa-fileinput-filename" class="fileinput-filename"></span>
                                              <a id="normativa-fileinput-close" href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>                                   
                                          </div>
                                          <div class="has-error" id="error-normativa">
                                            <span >
                                              <small id="error-normativa_mensaje" class="help-block error-span" ></small>                      
                                            </span>
                                          </div>

                                         </div>

                                         <div class="clearfix p-b-20"></div>


                                         <div class="col-sm-12">
                                          <div class="form-group">
                                              <label class="m-b-10">Manuales de procedimientos de instructores</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa los manuales de procedimiento de tu equipo de trabajo, de modo que, tu equipo de instructores pueda descargar y conocer desde su panel de control las normas que rigen tu institución ingresa el documento en formato PDF" title="" data-original-title="Ayuda"></i><br>                                    
    
                                              <div id="manual-fileinput" class="fileinput fileinput-new" data-provides="fileinput">
                                                  <span class="btn btn-lg btn-file m-r-10">
                                                      <span id="manual-fileinput-new" class="fileinput-new"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i> <br><span class="text-capitalize">Seleccionar</span></span>
                                                      <span id="manual-fileinput-exists" class="fileinput-exists"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i></span>
                                                      <input type="file" name="manual" id="manual">
                                                  </span>
                                                  <span id="manual-fileinput-filename" class="fileinput-filename"></span>
                                                  <a id="manual-fileinput-close" href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>                                   
                                              </div>
                                              <div class="has-error" id="error-manual">
                                                <span >
                                                    <small id="error-manual_mensaje" class="help-block error-span" ></small>                                           
                                                </span>
                                              </div>
                                          </div>
                                         </div>

                                         <div class="clearfix p-b-20"></div>


                                         <div class="col-sm-12">
                                          <div class="form-group">
                                              <label class="m-b-10">Programación de clases</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la programación de clases, de modo que, tu equipo de instructores y alumnos puedan descargar y conocer desde su panel de control las normas que rigen tu institución ingresa el documento en formato PDF" title="" data-original-title="Ayuda"></i><br>
                                              <div id="programacion-fileinput" class="fileinput fileinput-new" data-provides="fileinput">
                                                  <span class="btn btn-lg btn-file m-r-10">
                                                      <span id="programacion-fileinput-new" class="fileinput-new"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i> <br><span class="text-capitalize">Seleccionar</span></span>
                                                      <span id="programacion-fileinput-exists" class="fileinput-exists"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i></span>
                                                      <input type="file" name="programacion" id="programacion">
                                                  </span>
                                                  <span id="programacion-fileinput-filename" class="fileinput-filename"></span>
                                                  <a id="programacion-fileinput-close" href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>                                   
                                              </div>
                                              <div class="has-error" id="error-programacion">
                                                <span >
                                                    <small id="error-programacion_mensaje" class="help-block error-span" ></small>                                           
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_especiales_academia" data-update="especiales" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalAdministrativo-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Academia<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_administrativo_academia" id="edit_administrativo_academia"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                       <div class="form-group fg-line ">
                                          <label for="">Incluye impuestos fiscales (IVA)</label id="id-iva"> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica si manejas impuestos o no aplica" title="" data-original-title="Ayuda"></i>
                                          
                                          <br></br>
                                          <input type="text" id="incluye_iva" name="incluye_iva" value="" hidden="hidden">
                                          <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="iva" type="checkbox">
                                            
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                          </div>
                                          
                                       </div>
                                       <div class="has-error" id="error-impuesto">
                                            <span >
                                                <small class="help-block error-span" id="error-impuesto_mensaje" ></small>                                           
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

            <div class="modal fade" id="modalContrasena-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Academia<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_password_academia" id="edit_password_academia"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12 ">
                                 <div class="form-group">
                                    <label for="correo">Contraseña</label>
                                    <span class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-lock f-22"></i></span>
                                    <div class="fg-line">
                                    <input type="password_supervision" class="form-control input-sm" name="password_supervision" id="password" placeholder="Mínimo de 6 caracteres">
                                    </div>
                                    </span>
                                 </div>
                                 <div class="has-error" id="error-password_supervision">
                                    <span >
                                     <small id="error-password_supervision_mensaje" class="help-block error-span" ></small>
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
                                    <input type="password" class="form-control input-sm" name="password_supervision_confirmation" id="password_supervision_confirmation" placeholder="Repite tu contraseña">
                                    </div>
                                    </span>
                                 </div>
                                 <div class="has-error" id="error-password_supervision_confirmation">
                                    <span >
                                     <small id="error-password_supervision_confirmation_mensaje" class="help-block error-span" ></small>
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_password_academia" data-update="password" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalHorario-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Academia<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_horario_academia" id="edit_horario_academia"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                  <div class="form-group fg-line ">
                                    <label for="tipo_horario p-t-10">Tipo de Horario</label>
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="tipo_horario" id="12_horas" value="1" type="radio">
                                        <i class="input-helper"></i>  
                                        12 Horas
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo_horario" id="24_horas" value="2" type="radio">
                                        <i class="input-helper"></i>  
                                        24 Horas
                                    </label>
                                    </div>
                                    
                                  </div>
                                  <div class="has-error" id="error-tipo_horario">
                                        <span >
                                            <small class="help-block error-span" id="error-tipo_horario_mensaje" ></small>                                           
                                        </span>
                                  </div>
                                </div>

                               <input type="hidden" name="id" value="{{$academia->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_horario_academia" data-update="horario" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>
                             
                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalDias-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Academia<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_dias_academia" id="edit_dias_academia"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Dias de recompra</label>
                                        <input type="text" class="form-control input-sm input-mask" name="dias_recompra" id="dias_recompra" data-mask="00000000000000000000" placeholder="Ej: 15" value="{{$academia->dias_recompra}}">
                                    </div>
                                    <div class="has-error" id="error-dias_recompra">
                                      <span >
                                          <small id="error-dias_recompra_mensaje" class="help-block error-span" ></small>                                           
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_dias_academia" data-update="dias" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>


            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/configuracion" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menu Configuración</a>
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
                                        <a href="#" class="disabled">
                                            <span class="ca-icon-planilla"><i class="icon_d-personaliza"></i></span>
                                            <div class="ca-content-planilla">
                                                <h2 class="ca-main-planilla">Vista Academia</h2>
                                                <h3 class="ca-sub-planilla">Personaliza el campo academia</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>

          					            </div>                
          					          </div>
          					      </div>
					           </div>

					           	<div class="col-sm-9">

                         <div class="col-sm-12">
                              <h4 class="text-center">Datos de la Academia</h4>
                          </div>

                          <div class="col-sm-12">
                            <table class="table table-striped table-bordered">
                              <tr class="disabled" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Si deseas cambiar estos datos ponte en contacto con el administrador" title="" data-original-title="Ayuda">
                                <td>
                                  <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-nombre" class="zmdi {{ empty($academia->nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                                  <span class="m-l-10 m-r-10"> <i class="icon_b icon_b-nombres f-22"></i> </span>
                                  <span class="f-14"> Nombre </span>
                                </td>
                                <td class="f-14 m-l-15" ><span id="academia-nombre">{{$academia->nombre}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
                              </tr>

                              <tr class="disabled" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Si deseas cambiar estos datos ponte en contacto con el administrador" title="" data-original-title="Ayuda">
                                <td>
                                  <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-identificacion" class="zmdi {{ empty($academia->identificacion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                                  <span class="m-l-10 m-r-10"> <i class="icon_b icon_b-nombres f-22"></i> </span>
                                  <span class="f-14"> Identificación </span>
                                </td>
                                <td class="f-14 m-l-15" ><span id="academia-identificacion">{{$academia->identificacion}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
                              </tr>

                              <tr class="disabled" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Si deseas cambiar estos datos ponte en contacto con el administrador" title="" data-original-title="Ayuda">
                                <td>
                                  <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-especialidades_id" class="zmdi {{ empty($academia->especialidades_id) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                                  <span class="m-l-10 m-r-10"> <i class="icon_b icon_a-especialidad f-22"></i> </span>
                                  <span class="f-14"> Especialidad </span>
                                </td>
                                <td class="f-14 m-l-15" ><span id="academia-especialidades_id">{{$academia->especialidades_id}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
                              </tr>


                              <tr class="disabled" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Si deseas cambiar estos datos ponte en contacto con el administrador" title="" data-original-title="Ayuda">
                                <td>
                                  <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-pais_id" class="zmdi {{ empty($academia->pais_id) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                                  <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-flag f-22"></i> </span>
                                  <span class="f-14"> Pais </span>
                                </td>
                                <td class="f-14 m-l-15" ><span id="academia-pais_id">{{$academia->pais_id}}</span> / <span id="academia-estado">{{$academia->estado}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
                              </tr>


                            <tr class="detalle" data-toggle="modal" href="#modalContacto-Academia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-correo" class="zmdi {{ empty($academia->correo) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b icon_b-telefono f-22"></i> </span>
                               <span class="f-14"> Contacto </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="academia-contacto"> </span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalRedes-Academia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-redes" class="zmdi {{ empty($academia->facebook) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-share zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Redes Sociales </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="academia-redes"></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalImagen-Academia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-imageBase64" class="zmdi {{ empty($academia->imagen) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-collection-folder-image zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Logotipo </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="academia-imagen"><span></span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalImagenHorizontal-Academia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-imageHorizontalBase64" class="zmdi {{ empty($academia->imagen_horizontal) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-collection-folder-image zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Imagen Horizontal </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="academia-imagen_horizontal"><span></span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
<!--                             <tr class="detalle" data-toggle="modal" href="#modalEspeciales-Academia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-normativa" class="zmdi {{ empty($academia->normativa) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10">  <i class="icon_a-especialidad f-22"></i> </span>
                               <span class="f-14"> Especiales </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="academia-especiales"></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>  -->
                            <tr class="detalle" data-toggle="modal" href="#modalAdministrativo-Academia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-administrativo" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10">  <i class="icon_a-punto-de-venta f-22"></i> </span>
                               <span class="f-14"> Administrativo </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="academia-administrativo"></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr> 
                            <tr class="detalle" data-toggle="modal" href="#modalContrasena-Academia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-password_supervision" class="zmdi {{ empty($academia->password_supervision) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-lock-outline zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Contraseña </span>
                             </td>
                             <td class="f-14 m-l-15" > <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalHorario-Academia">
                             <td> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-tipo_horario" class="zmdi {{ empty($academia->tipo_horario) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                              <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-time f-22"></i> </span>
                              <span class="f-14"> Tipo de Horario </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="academia-tipo_horario" data-valor="{{$academia->tipo_horario}}">
                               @if($academia->tipo_horario=='1')
                                 12 Horas </span>
                               @else
                                 24 Horas </span>
                               @endif
                             </span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalDias-Academia">
                             <td> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-dias_recompra" class="zmdi {{ empty($academia->dias_recompra) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                              <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-calendar-check f-22"></i> </span>
                              <span class="f-14"> Días de recompra </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="academia-dias_recompra">
                              {{$academia->dias_recompra}}
                             </span> Días <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
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

    route_update="{{url('/')}}/configuracion/academia/update";
    contenido = true;

    $(document).ready(function(){

      if("{{$academia->normativa}}"){
        $('#normativa-fileinput').removeClass('fileinput-new')
        $("input[name=normativa]").attr('name','')
        $('#normativa').attr('name','normativa')
        $('#normativa-fileinput').addClass('fileinput-exists')
        $('#normativa-fileinput-new').hide();
        $('#normativa-fileinput-exists').show();
        $('#normativa-fileinput-filename').text("{{$academia->normativa}}");
        $('#normativa-fileinput-close').show();
      }

      if("{{$academia->manual}}"){
        $('#manual-fileinput').removeClass('fileinput-new')
        $("input[name=manual]").attr('name','')
        $('#manual').attr('name','manual')
        $('#manual-fileinput').addClass('fileinput-exists')
        $('#manual-fileinput-new').hide();
        $('#manual-fileinput-exists').show();
        $('#manual-fileinput-filename').text("{{$academia->manual}}");
        $('#manual-fileinput-close').show();
      }

      if("{{$academia->programacion}}"){
        $('#programacion-fileinput').removeClass('fileinput-new')
        $("input[name=programacion]").attr('name','')
        $('#programacion').attr('name','programacion')
        $('#programacion-fileinput').addClass('fileinput-exists')
        $('#programacion-fileinput-new').hide();
        $('#programacion-fileinput-exists').show();
        $('#programacion-fileinput-filename').text("{{$academia->programacion}}");
        $('#programacion-fileinput-close').show();
      }

      $("#normativa").on("DOMAttrModified", function (e) {

        if($(this).attr('name') != ''){
          $('#normativa-fileinput-new').hide();
        }else{
          $('#normativa-fileinput-new').show();
        }

      });

      $("#manual").on("DOMAttrModified", function (e) {

        if($(this).attr('name') != ''){
          $('#manual-fileinput-new').hide();
        }else{
          $('#manual-fileinput-new').show();
        }

      });

      $("#programacion").on("DOMAttrModified", function (e) {

        if($(this).attr('name') != ''){
          $('#programacion-fileinput-new').hide();
        }else{
          $('#programacion-fileinput-new').show();
        }

      });

      if("{{$academia->incluye_iva}}" == 1){
          $("#incluye_iva").val('1');  //VALOR POR DEFECTO
          $("#iva").attr("checked", true); //VALOR POR DEFECTO
      }
        $("#iva").on('change', function(){
          if ($("#iva").is(":checked")){
            $("#incluye_iva").val('1');
          }else{
            $("#incluye_iva").val('0');
          }   
          console.log($("#incluye_iva").val());     
        });

      $("#imagen").bind("change", function() {
            
            setTimeout(function(){
              var imagen = $("#imagena img").attr('src');
              var extension = imagen.substring("data:image/".length, imagen.indexOf(";base64"))
              
              if(extension == 'jpeg'){
                extension = "image/jpeg"
              }else{
                extension = "image/png"
              }

              var canvas = document.createElement("canvas");
     
              var context=canvas.getContext("2d");
              var img = new Image();
              img.src = imagen;
              
              canvas.width  = img.width;
              canvas.height = img.height;

              context.drawImage(img, 0, 0);
       
              var newimage = canvas.toDataURL(extension, 0.8);
              var image64 = $("input:hidden[name=imageBase64]").val(newimage);
            },500);

        });

        $("#imagen_horizontal").bind("change", function() {
            
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
              var image64 = $("input:hidden[name=imageHorizontalBase64]").val(newimage);
            },500);

        });

        $("#telefono").val("{{$academia->telefono}}");
        $("#celular").val("{{$academia->celular}}");
        $("#direccion").val("{{$academia->direccion}}");

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

    $('#modalHorario-Academia').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var valor=$("#academia-tipo_horario").data('valor');
      if(valor=="1"){
        $("#12_horas").prop("checked", true);
      }else{
        $("#24_horas").prop("checked", true);
      }
    })

    function limpiarMensaje(){
        var campo = ["correo", "telefono", "celular", "direccion"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

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
          if(c.name=='tipo_horario'){
            if(c.value=='1'){              
              var valor='12 Horas </span>';                              
            }else{
              var valor='24 Horas </span>';
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
        limpiarMensaje();
        procesando();
        form=$(this).data('formulario');
        update=$(this).data('update');
        var token = $('input:hidden[name=_token]').val();
        if(form != 'edit_especiales_academia'){

          var datos = $( "#"+form ).serialize();
          tipo = 'PUT';
          $.ajaxSetup({cache:false, contentType:"application/x-www-form-urlencoded; charset=UTF-8"});

        }
        else{

          tipo = 'POST';
          var datos = new FormData();
          var normativa = document.getElementById('normativa');
          var manual = document.getElementById('manual');
          var programacion = document.getElementById('programacion');

          if(normativa.files[0])
          {
            datos.append('normativa', normativa.files[0]);
          }

          if(manual.files[0])
          {
            datos.append('manual', manual.files[0]);
          }

          if(programacion.files[0])
          {
            datos.append('programacion', programacion.files[0]);
          }

          $.ajaxSetup({cache:false, contentType: false})
        }
        
        var datos_array=  $( "#"+form ).serializeArray();
        var route = route_update+"/"+update;

        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: tipo,
            dataType: 'json',
            data: datos,
            processData: false,
                            
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
