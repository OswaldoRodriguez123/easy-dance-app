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
                                                  <input type="text" class="form-control caja input-sm" name="web" id="web" placeholder="Ej: www.easydancelatino.com" value="{{$academia->pagina_web}}">
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
                                          <!-- <div class="fileinput fileinput-new" data-provides="fileinput">
                                              <span class="btn btn-lg btn-file m-r-10">
                                                  <span class="fileinput-new"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i> <br><span class="text-capitalize">Selecionar</span></span>
                                                  <span class="fileinput-exists"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i></span>
                                                  <input type="file" name="normativa">
                                              </span>
                                              <span class="fileinput-filename"></span>
                                              <a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>                                   
                                          </div> -->
                                          <textarea class="form-control caja" style="height: 100%" id="normativa" name="normativa" rows="5" placeholder="Ingresa las normativas de la academia">{{$academia->normativa}}</textarea>
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
                                              <!-- <div class="fileinput fileinput-new" data-provides="fileinput">
                                                  <span class="btn btn-lg btn-file m-r-10">
                                                      <span class="fileinput-new"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i> <br><span class="text-capitalize">Selecionar</span></span>
                                                      <span class="fileinput-exists"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i></span>
                                                      <input type="file" name="manual">
                                                  </span>
                                                  <span class="fileinput-filename"></span>
                                                  <a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>                                   
                                              </div> -->
                                               <textarea class="form-control caja" style="height: 100%" id="manual" name="manual" rows="5" placeholder="Ingresa los manuales de procedimientos de la academia">{{$academia->manual}}</textarea>
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
                                              <div id="fileinput" class="fileinput fileinput-new" data-provides="fileinput">
                                                  <span class="btn btn-lg btn-file m-r-10">
                                                      <span id="fileinput-new" class="fileinput-new"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i> <br><span class="text-capitalize">Seleccionar</span></span>
                                                      <span id="fileinput-exists" class="fileinput-exists"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i></span>
                                                      <input type="file" name="programacion" id="programacion">
                                                  </span>
                                                  <span id="fileinput-filename" class="fileinput-filename"></span>
                                                  <a id="fileinput-close" href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>                                   
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

            <div class="modal fade" id="modalEstudio-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Academia<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_estudio_academia" id="edit_estudio_academia"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               
                              
                               
                          <div class="col-sm-12">
                                    <div class="form-group fg-line">
                                    <label for="id">Estudios /Salones</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el nombre y la capacidad de personas dentro de tu salón o salones de bailes." title="" data-original-title="Ayuda"></i>

                                    <div class="clearfix p-b-35"></div>
                                
                                    
                                    <label for="nombre_estudio" id="id-nombre_estudio">Nombre</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del Salón" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a icon_a-estudio-salon f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="nombre_estudio" id="nombre_estudio" placeholder="Ej. Salón">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-nombre_estudio">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_estudio_mensaje" ></small>                               
                                      </span>
                                  </div>

                                  <div class="clearfix p-b-35"></div>

                                  <label for="cantidad_estudio" id="id-cantidad_estudio">Cantidad</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la cantidad de personas del Salón" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-collection-item-1 f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="cantidad_estudio" id="cantidad_estudio" placeholder="Ej. 50">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-cantidad_estudio">
                                      <span >
                                          <small class="help-block error-span" id="error-cantidad_estudio_mensaje" ></small>                               
                                      </span>
                                  </div>
                               </div>

                              <br>

                              <div class="card-header text-left">

                              <button type="button" class="btn btn-blanco m-r-10 f-10" name= "añadirestudio" id="añadirestudio" > Agregar Linea</button>

                              </div>
                              <div class="clearfix p-b-35"></div>

                          <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tableestudio" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="nombre"></th>
                                    <th class="text-center" data-column-id="cantidad"></th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" ></th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($estudios as $estudio)
                                <?php $id = $estudio->id; ?>
                                <tr id="{{$id}}" class="seleccion" >
                                    <td class="text-center previa">{{$estudio->nombre}}</td>
                                    <td class="text-center previa">{{$estudio->capacidad}}</td>
                                    <td class="text-center"> <i class="zmdi zmdi-delete f-20 p-r-10"></i></td>
                                  </tr>
                            @endforeach 
                   
                            </tbody>
                          </table>


                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                      
                      <div class="clearfix p-b-35"></div>

                      <div class="clearfix"></div> 
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

                              <a class="btn-blanco m-r-5 f-12 dismiss" href="#" id="dismiss" name="dismiss" data-formulario="edit_administrativo_academia" data-update="administrativo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                              <div class="clearfix p-b-35"></div>
                      

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalNivel-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Academia<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_nivel_academia" id="edit_nivel_academia"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               

                                    <div class="col-sm-12">
                                    <div class="form-group fg-line">
                                    <label for="id">Niveles de baile</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el nombre de los distintos niveles de baile que ofreces en tu academia" title="" data-original-title="Ayuda"></i>

                                    <div class="clearfix p-b-35"></div>
                                    
                                    <label for="nombre_nivel" id="id-nombre_nivel">Nombre</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del nivel que deseas asignar" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a icon_a-niveles f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="nombre_nivel" id="nombre_nivel" placeholder="Ej. Basico">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-nombre_nivel">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_nivel_mensaje" ></small>                               
                                      </span>
                                  </div>
                               </div>

                              <br>

                              <div class="card-header text-left">
                              <button type="button" class="btn btn-blanco m-r-10 f-10" id="añadirniveles" name="añadirniveles" >Agregar Linea</button>
                              </div>
                              <div class="clearfix p-b-35"></div>

                          <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tableniveles" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="nombre"></th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" ></th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($niveles as $nivel)
                                <?php $id = $nivel->id; ?>
                                <tr id="{{$id}}" class="seleccion" >
                                    <td class="text-center previa">{{$nivel->nombre}}</td>
                                    <td class="text-center"> <i class="zmdi zmdi-delete f-20 p-r-10"></i></i></td>
                                  </tr>
                            @endforeach 
                   
                            </tbody>
                          </table>


                        </div>
                        </div>
                        </div>
                        </div>
                        </div>


                    <div class="clearfix p-b-35"></div>

                      <div class="clearfix"></div> 
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

                              <a class="btn-blanco m-r-5 f-12 dismiss" href="#" id="dismiss" name="dismiss" data-formulario="edit_administrativo_academia" data-update="administrativo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                              <div class="clearfix p-b-35"></div>
                      

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalReferir-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                      <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Academia<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                    </div>
                    <form name="edit_referido_academia" id="edit_referido_academia">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="modal-body">                           
                          <div class="row p-t-20 p-b-0">
                            <div class="col-sm-12">
                              <div class="form-group fg-line">
                                  <label for="puntos_referencia" id="id-puntos_referencia">Promotor</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el número de puntos que obtendrá un alumno al referir su código para generar una inscripción. (El número de puntos equivale al valor monetario) es decir, si la moneda de uso es el peso, y el puntaje seleccionado son 10.000 puntos, el alumno recibirá el crédito equivalente a  10.000 pesos por generar la referencia." title="" data-original-title="Ayuda"></i>
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="icon_a icon_a-niveles f-22"></i></span>
                                    <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="puntos_referencia" id="puntos_referencia" placeholder="Ej. 10000" value="{{$academia->puntos_referencia}}" data-mask="00000000000">
                                    </div>
                                  </div>
                                  <div class="has-error" id="error-puntos_referencia">
                                    <span >
                                      <small class="help-block error-span" id="error-puntos_referencia_mensaje"></small>
                                    </span>
                                  </div>
                                  <div class="clearfix p-b-35"></div>
                                  <label for="puntos_referidos" id="id-puntos_referidos">Destinatario</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el número de puntos que obtendrá el nuevo participante que realizará el proceso de inscripción, gracias a la referencia obtenida de parte del código de un amigo. (El número de puntos equivale al valor monetario) es decir, si la moneda de uso es el peso, y el puntaje seleccionado son 10.000 puntos, el alumno recibirá el crédito equivalente a  10.000 pesos por generar la referencia." title="" data-original-title="Ayuda"></i>
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="icon_a icon_a-niveles f-22"></i></span>
                                    <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="puntos_referidos" id="puntos_referidos" placeholder="Ej. 5000" value="{{$academia->puntos_referidos}}" data-mask="00000000000">
                                    </div>
                                  </div>
                                  <div class="has-error" id="error-puntos_referidos">
                                    <span >
                                      <small class="help-block error-span" id="error-puntos_referidos_mensaje"></small>
                                    </span>
                                  </div>
                                </div>
                                <br>
                              </div>
                            </div>
                          </div>
                        <div class="clearfix p-b-35"></div>
                        <div class="clearfix"></div> 
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
                            <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_referido_academia" data-update="referido" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>
                            <div class="clearfix p-b-35"></div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <div class="modal fade" id="modalCargo-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Academia<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_cargo_academia" id="edit_cargo_academia"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               

                                    <div class="col-sm-12">
                                    <div class="form-group fg-line">
                                    <label for="id">Cargo</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el nombre de los distintos cargos que posees en tu academia" title="" data-original-title="Ayuda"></i>

                                    <div class="clearfix p-b-35"></div>
                                    
                                    <label for="nombre_nivel" id="id-nombre_cargo">Nombre</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del cargo que deseas agregar" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_f-staff f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="nombre_cargo" id="nombre_cargo" placeholder="Ej. Vigilante">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-nombre_cargo">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_cargo_mensaje" ></small>                               
                                      </span>
                                  </div>
                               </div>

                              <br>

                              <div class="card-header text-left">
                              <button type="button" class="btn btn-blanco m-r-10 f-10" id="añadircargo" name="añadircargo" >Agregar Linea</button>
                              </div>
                              <div class="clearfix p-b-35"></div>

                          <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablecargo" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="nombre"></th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" ></th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($config_staff as $staff)
                                <?php $id = $staff->id; ?>
                                <tr id="{{$id}}" class="seleccion" >
                                    <td class="text-center previa">{{$staff->nombre}}</td>
                                    <td class="text-center"> <i class="zmdi zmdi-delete f-20 p-r-10"></i></i></td>
                                  </tr>
                            @endforeach 
                   
                            </tbody>
                          </table>

                          </div>
                        </div>
                        </div>
                        </div>
                        </div>

        <div class="clearfix p-b-35"></div>

                      <div class="clearfix"></div> 
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

                              <a class="btn-blanco m-r-5 f-12 dismiss" href="#" id="dismiss" name="dismiss" data-formulario="edit_administrativo_academia" data-update="administrativo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                              <div class="clearfix p-b-35"></div>
                      

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

              <div class="modal fade" id="modalFormula-Academia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Academia<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_formula_academia" id="edit_formula_academia"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               

                                    <div class="col-sm-12">
                                    <div class="form-group fg-line">
                                    <label for="id">Formula de Exito</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el nombre de las distintas formulas de exito que posees en tu academia" title="" data-original-title="Ayuda"></i>

                                    <div class="clearfix p-b-35"></div>
                                    
                                    <label for="nombre_formula" id="id-nombre_formula">Nombre</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre de la formula que deseas agregar" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_f-staff f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="nombre_formula" id="nombre_formula" placeholder="Ej. Vigilante">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-nombre_formula">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_formula_mensaje" ></small>                               
                                      </span>
                                  </div>
                               </div>

                              <br>

                              <div class="card-header text-left">
                              <button type="button" class="btn btn-blanco m-r-10 f-10" id="añadirformula" name="añadirformula" >Agregar Linea</button>
                              </div>
                              <div class="clearfix p-b-35"></div>

                          <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tableformula" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="nombre"></th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" ></th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($config_formula as $formula)
                                <?php $id = $formula->id; ?>
                                <tr id="{{$id}}" class="seleccion" >
                                    <td class="text-center previa">{{$formula->nombre}}</td>
                                    <td class="text-center"> <i class="zmdi zmdi-delete f-20 p-r-10"></i></i></td>
                                  </tr>
                            @endforeach 
                   
                            </tbody>
                          </table>

                          </div>
                        </div>
                        </div>
                        </div>
                        </div>



                    <div class="clearfix p-b-35"></div>

                      <div class="clearfix"></div> 
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

                              <a class="btn-blanco m-r-5 f-12 dismiss" href="#" id="dismiss" name="dismiss">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                              <div class="clearfix p-b-35"></div>
                      

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
          					          <!--<p class="text-justify">Desde esta área Easy Dance te brinda la oportunidad de actualizar los datos creados en tu planilla de registro.</p>-->
          					                
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
                               <span class="f-14"> Imagen </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="academia-imagen"><span></span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalEspeciales-Academia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-normativa" class="zmdi {{ empty($academia->normativa) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10">  <i class="icon_a-especialidad f-22"></i> </span>
                               <span class="f-14"> Especiales </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="academia-especiales"></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr> 
                            <tr class="detalle" data-toggle="modal" href="#modalAdministrativo-Academia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-administrativo" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10">  <i class="icon_a-punto-de-venta f-22"></i> </span>
                               <span class="f-14"> Administrativo </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="academia-administrativo"></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr> 
                            <tr class="detalle" data-toggle="modal" href="#modalEstudio-Academia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-administrativo" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10">  <i class="icon_a-estudio-salon f-22"></i> </span>
                               <span class="f-14"> Estudios /Salones </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="academia-administrativo"></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr> 
                            <tr class="detalle" data-toggle="modal" href="#modalNivel-Academia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-administrativo" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10">  <i class="icon_a-niveles f-22"></i> </span>
                               <span class="f-14"> Niveles de baile </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="academia-administrativo"></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalCargo-Academia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10">  <i class="icon_f-staff f-22"></i> </span>
                               <span class="f-14"> Cargos de Staff </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="academia-administrativo"></span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalFormula-Academia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10">  <i class="icon_f-staff f-22"></i> </span>
                               <span class="f-14"> Formula de Exito </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="academia-administrativo"></span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalReferir-Academia">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-administrativo" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10">  <i class="icon_a-niveles f-22"></i> </span>
                               <span class="f-14"> Sección de Referidos </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="academia-administrativo"></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
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

      console.log("{{$academia->programacion}}")
      if("{{$academia->programacion}}" || "{{$academia->programacion}}" != 'undefined'){
        $('#fileinput').removeClass('fileinput-new')
        $("input[name=programacion]").attr('name','')
        $('#programacion').attr('name','programacion')
        $('#fileinput').addClass('fileinput-exists')
        $('#fileinput-new').hide();
        $('#fileinput-exists').show();
        $('#fileinput-filename').text("{{$academia->programacion}}");
        $('#fileinput-close').show();
      }

      $("#programacion").on("DOMAttrModified", function (e) {

        if($(this).attr('name') != ''){
          $('#fileinput-new').hide();
        }else{
          $('#fileinput-new').show();
        }

      });

      $("#nombre_estudio").val('');
      $("#nombre_nivel").val('');
      $("#cantidad_estudio").val('');

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

     var t=$('#tableniveles').DataTable({
        processing: true,
        serverSide: false, 
        bPaginate: false, 
        bFilter:false, 
        bSort:false, 
        order: [[0, 'asc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1)', nRow).addClass( "text-center" );
          //$('td:eq(1)', nRow).attr("onClick","eliminar(this)" );
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

  var h=$('#tableestudio').DataTable({
        processing: true,
        serverSide: false, 
        bPaginate: false, 
        bFilter:false, 
        bSort:false, 
        order: [[0, 'asc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1)', nRow).addClass( "text-center" );
          //$('td:eq(1)', nRow).attr("onClick","eliminar(this)" );
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

      var k=$('#tablecargo').DataTable({
        processing: true,
        serverSide: false, 
        bPaginate: false, 
        bFilter:false, 
        bSort:false, 
        order: [[0, 'asc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1)', nRow).addClass( "text-center" );
          //$('td:eq(1)', nRow).attr("onClick","eliminar(this)" );
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

      var l=$('#tableformula').DataTable({
        processing: true,
        serverSide: false, 
        bPaginate: false, 
        bFilter:false, 
        bSort:false, 
        order: [[0, 'asc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1)', nRow).addClass( "text-center" );
          //$('td:eq(1)', nRow).attr("onClick","eliminar(this)" );
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
      $("#direccion").val($("#alumno-direccion").text());
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
        if(form != 'edit_especiales_academia'){
          var datos = $( "#"+form ).serialize();
          tipo = 'PUT';
          $.ajaxSetup({cache:false, contentType:"application/x-www-form-urlencoded; charset=UTF-8"});
        }
        else{
          tipo = 'POST';
          var data = new FormData();
          var programacion = document.getElementById('programacion');
          if(programacion.files[0])
          {
            data.append('programacion', programacion.files[0]);
          }
          data.append('normativa', $('#normativa').val());
          data.append('manual', $('#manual').val());
          var datos = data;
          $.ajaxSetup({cache:false, contentType: false})
        }
        
        var datos_array=  $( "#"+form ).serializeArray();
        
        var route = route_update+"/"+update;
        //inicia aqui
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
                          //window.location = "{{url('/')}}/error";
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
       //finaliza aqui
    })

    $(".dismiss").click(function(){
      $('.modal').modal('hide');
    });

    $("#añadirestudio").click(function(){

                var datos = $( "#edit_estudio_academia" ).serialize(); 
                procesando();
                var route = "{{url('/')}}/configuracion/academia/estudio";
                var token = $('input:hidden[name=_token]').val();
                var datos = datos;
                limpiarMensaje();
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data: datos ,
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

                          var nombre = respuesta.array.nombre;
                          var capacidad = respuesta.array.capacidad;

                          var rowId=respuesta.id;
                          var rowNode=h.row.add( [
                          ''+nombre+'',
                          ''+capacidad+'',
                          '<i class="zmdi zmdi-delete f-20 p-r-10"></i>'
                          ] ).draw(false).node();
                          $( rowNode )
                          .attr('id',rowId)
                          .addClass('seleccion');

                          $("#edit_estudio_academia")[0].reset();
                          // rechargeServicio();

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

    $("#añadirniveles").click(function(){

                var datos = $( "#edit_nivel_academia" ).serialize(); 
                procesando();
                var route = "{{url('/')}}/configuracion/academia/nivel";
                var token = $('input:hidden[name=_token]').val();
                var datos = datos;
                limpiarMensaje();
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data: datos ,
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

                          var nombre = respuesta.array.nombre;

                          var rowId=respuesta.id;
                          var rowNode=t.row.add( [
                          ''+nombre+'',
                          '<i class="zmdi zmdi-delete f-20 p-r-10"></i>'
                          ] ).draw(false).node();
                          $( rowNode )
                          .attr('id',rowId)
                          .addClass('seleccion');

                          $("#edit_nivel_academia")[0].reset();
                          // rechargeServicio();

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

    $('#tableniveles tbody').on( 'click', 'i.zmdi-delete', function () {
      var padre=$(this).parents('tr');
      var token = $('input:hidden[name=_token]').val();
      var id = $(this).closest('tr').attr('id');
            $.ajax({
                 url: "{{url('/')}}/configuracion/academia/eliminarnivel/"+id,
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

    $('#tableestudio tbody').on( 'click', 'i.zmdi-delete', function () {
      var padre=$(this).parents('tr');
      var token = $('input:hidden[name=_token]').val();
      var id = $(this).closest('tr').attr('id');
            $.ajax({
                 url: "{{url('/')}}/configuracion/academia/eliminarestudio/"+id,
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

              h.row( $(this).parents('tr') )
                .remove()
                .draw();
          });


    $("#añadircargo").click(function(){

                var datos = $( "#edit_cargo_academia" ).serialize(); 
                procesando();
                var route = "{{url('/')}}/configuracion/academia/cargo";
                var token = $('input:hidden[name=_token]').val();
                var datos = datos;
                limpiarMensaje();
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data: datos ,
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

                          var nombre = respuesta.array.nombre;

                          var rowId=respuesta.id;
                          var rowNode=k.row.add( [
                          ''+nombre+'',
                          '<i class="zmdi zmdi-delete f-20 p-r-10"></i>'
                          ] ).draw(false).node();
                          $( rowNode )
                          .attr('id',rowId)
                          .addClass('seleccion');

                          $("#edit_cargo_academia")[0].reset();
                          // rechargeServicio();

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

    $('#tablecargo tbody').on( 'click', 'i.zmdi-delete', function () {
      var padre=$(this).parents('tr');
      var token = $('input:hidden[name=_token]').val();
      var id = $(this).closest('tr').attr('id');
            $.ajax({
                 url: "{{url('/')}}/configuracion/academia/eliminarcargo/"+id,
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

              k.row( $(this).parents('tr') )
                .remove()
                .draw();
          });

      $("#añadirformula").click(function(){

                var datos = $( "#edit_formula_academia" ).serialize(); 
                procesando();
                var route = "{{url('/')}}/configuracion/academia/formula";
                var token = $('input:hidden[name=_token]').val();
                var datos = datos;
                limpiarMensaje();
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data: datos ,
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

                          var nombre = respuesta.array.nombre;

                          var rowId=respuesta.id;
                          var rowNode=l.row.add( [
                          ''+nombre+'',
                          '<i class="zmdi zmdi-delete f-20 p-r-10"></i>'
                          ] ).draw(false).node();
                          $( rowNode )
                          .attr('id',rowId)
                          .addClass('seleccion');

                          $("#edit_formula_academia")[0].reset();

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

    $('#tableformula tbody').on( 'click', 'i.zmdi-delete', function () {
      var padre=$(this).parents('tr');
      var token = $('input:hidden[name=_token]').val();
      var id = $(this).closest('tr').attr('id');
            $.ajax({
                 url: "{{url('/')}}/configuracion/academia/eliminarformula/"+id,
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

              l.row( $(this).parents('tr') )
                .remove()
                .draw();
          });



    // $(document).on("change", function(e){
    // $("#programacion").bind("change", function() {
  
    //   var miurl="{{url('/')}}/configuracion/academia/update/especiales";

    //   var data = new FormData();
    //   var programacion = document.getElementById('programacion');
    //   var files = programacion.files;
    //   data.append('programacion', files);
    
    //   console.log(data);

    //   $.ajaxSetup({
    //       headers: {
    //           'X-CSRF-TOKEN': $('input:hidden[name=_token]').val()
    //       }
    //   });

    //  $.ajax({
    //         url: miurl, 
    //         type: 'POST',
    
    //         // Form data
    //         //datos del formulario
    //         data: data,
    //         //necesario para subir archivos via ajax
    //         cache: false,
    //         contentType: false,
    //         processData: false,

    //         //una vez finalizado correctamente
    //         success: function(data){
    //           var codigo='<div class="mailbox-attachment-info"><a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i>'+ data +'</a><span class="mailbox-attachment-size"> </span></div>';
    //           $("#"+divresul+"").html(codigo);
                       
    //         },
    //         //si ha ocurrido un error
    //         error: function(data){
    //            $("#"+divresul+"").html(data);
               
    //         }
    //     });
    // })
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
