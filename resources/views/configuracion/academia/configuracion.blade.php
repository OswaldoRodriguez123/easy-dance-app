@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
@stop

@section('css')

<link href="{{url('/')}}/assets/css/easy_dance_ico_3.css" rel="stylesheet">

@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/input-mask/input-mask.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
@stop

@section('content')
  
	<section id="content">
        <div class="container">
        
                    <div class="block-header">
                       <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/configuracion" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menu Configuración</a>
                    </div> 
                    
                    <div class="card">
                      <div class="card-header">
                            
                            
                      </div>
                      <div class="card-body p-b-20">
                        <div class="row">
                        <div class="container">
                         <div class="col-sm-3">
          					        <div class="p-t-30">       
          					          <div class="row p-b-15">
          					            <div class="col-md-12" >
          					              <div class="text-center">
          					                <ul class="ca-menu-planilla">
                                    <li>
                                        <a href="#" class="disabled">
                                            <span class="ca-icon-planilla"><i class="icon_a-alumnos"></i></span>
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
                              <div class="row p-l-10 p-b-0">

                              <hr>

                              <label class="text-left f-16">Nombre de la academia:</label>
                              <p class="text-left" >{{$academia->nombre}}</p>

                              <label class="text-left f-16" >Identidad fiscal:</label>
                              <p class="text-left">{{$academia->identificacion}}</p> 

                              <!--<label class="text-left" >Descripción:</label>
                              <p class="text-left" >...</p> -->

                              </div>

                              <div class="row p-l-0 p-b-0 text-center f-9">
                               <hr>
                               <div class="col-xs-3 p-l-5 p-r-5">
                                 <div><i id="proceso_contacto" class="zmdi zmdi-dot-circle zmdi-hc-fw f-35 c-morado"></i></div>
                                 Contacto
                               </div>
                               <div class="col-xs-3 p-l-5 p-r-5">
                                 <div><i id="proceso_especiales" class="zmdi zmdi-dot-circle zmdi-hc-fw f-35"></i></div>
                                 Especiales
                               </div>

                               <div class="col-xs-3 p-l-5 p-r-5">
                                 <div><i id="proceso_administrativo" class="zmdi zmdi-dot-circle zmdi-hc-fw f-35"></i></div>
                                 <span>Administrativo</span>
                               </div>
                               <div class="col-xs-3 p-l-5 p-r-5">
                                 <div><i id="proceso_categorias" class="zmdi zmdi-dot-circle zmdi-hc-fw f-35"></i></div>
                                 Categorias
                               </div>
                              </div>
          					         
          					                
          					      </div>
					           </div>

					           	<div class="col-sm-9">
                        <div role="tabpanel">
                                <ul class="tab-nav tn-justified" role="tablist">
                                    <li id="tab_contacto" class="active"><div class="icon_b icon_b-telefono f-30"></div><a name="a_contacto" href="#contacto" aria-controls="contacto" role="tab" data-toggle="tab">Contacto</a></li>
                                    <li id="tab_especiales" ><div class="icon_a icon_a-especialidad f-30"></div><a name="a_especiales">Especiales</a></li>
                                    <li id="tab_administrativo"><div class="icon_a icon_a-punto-de-venta f-30"></div><a name="a_administrativo">Administrativo</a></li>
                                    <li id="tab_categorias"><div class="icon_d icon_d-category f-30"></div><a name="a_categorias">Categoria</a></li>
                                </ul>

                                <form name="configurar_academia" id="configurar_academia"  >
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="contacto">

                                    <!-- CONTACTO -->

                                        <div class="row p-t-10 p-b-0">
                                         <div class="clearfix p-b-20"></div>
                                         <div class="col-sm-12">                                         
                                              
                                              <label for="id" id="id-correo">Correo electrónico de la academia</label>
                                               <div class="input-group">
                                                <span class="input-group-addon"><i class="icon_a icon_a-correo f-22"></i></span>
                                                <div class="fg-line">
                                                  <input type="text" class="form-control input-sm" name="correo" id="correo" placeholder="Ej: info@easydancelatino.com">
                                                </div>
                                              </div>
                                              <div class="has-error" id="error-correo">
                                                <span >
                                                    <small id="error-correo_mensaje" class="help-block error-span" ></small>                                           
                                                </span>
                                              </div>
                                          
                                         </div>

                                         <div class="clearfix p-b-35"></div>

                                         <div class="col-sm-12">
                                          
                                              <label for="id" id="id-celular">Teléfono móvil de la academia</label>
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="icon_b icon_b-telefono f-22"></i></span>
                                                 <div class="fg-line">                                                 
                                                  <input type="text" class="form-control input-sm input-mask" name="celular" id="celular" data-mask="(000)000-0000" placeholder="Ej: (426)367-0894">
                                                 </div>
                                              </div>
                                              <div class="has-error" id="error-celular">
                                                <span >
                                                    <small id="error-celular_mensaje" class="help-block error-span" ></small>                                           
                                                </span>
                                              </div>
                                          
                                         </div>

                                         <div class="clearfix p-b-35"></div>

                                         <div class="col-sm-12">
                                              <label for="id" id="id-telefono">Teléfono local de la academia </label>
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="icon_b icon_b-telefono f-22"></i></span>
                                                 <div class="fg-line">                                                  
                                                  <input type="text" class="form-control input-sm input-mask" name="telefono" id="telefono" data-mask="(000)000-0000" placeholder="Ej: (261)367-0894">
                                                 </div>
                                              </div>
                                              <div class="has-error" id="error-telefono">
                                                <span >
                                                    <small id="error-telefono_mensaje" class="help-block error-span" ></small>                                           
                                                </span>
                                              </div>
                                          
                                         </div>

                                         <div class="clearfix p-b-35"></div>


                                    <div class="col-sm-12">
                                    <div class="form-group fg-line">
                                    <label for="direccion" id="id-direccion">Dirección</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la dirección del participante" title="" data-original-title="Ayuda"></i>
                                      <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-pin-drop zmdi-hc-fw f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="direccion" id="direccion" placeholder="Calle santa marta, Av 23">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-direccion">
                                      <span >
                                          <small class="help-block error-span" id="error-direccion_mensaje" ></small>                                
                                      </span>
                                  </div>
                                 </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">

                                <label for="apellido" id="id-imagen">Cargar Logotipo</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Soporta formatos en: JPEG, JPG y PNG. El tamaño de la imagen debe menor o igual a 1 MB. NOTA: Logos grandes o mayor de 230 x 120 se reducirán" title="" data-original-title="Ayuda"></i>
                                
                                <div class="clearfix p-b-15"></div>
                                  
                                  <input type="hidden" name="imageBase64" id="imageBase64">
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
                                  <div class="has-error" id="error-imagen">
                                  <span >
                                      <small class="help-block error-span" id="error-imagen_mensaje"  ></small>
                                  </span>
                                </div>
                              </div>

                               <hr></hr>


                                         <div class="clearfix"></div>

                                         <h4 class="p-l-15 m-t-20">Redes sociales y web <hr></h4>
                                         <p class="p-l-15 p-r-15">Ingresa el link de tus redes sociales, esta información será visualizada por todos los usuarios, así podrás mantener un mejor contacto con tus clientes y seguidores</p>

                                         <div class="col-sm-6">
                                             <label for="id">Facebook  </label>
                                             <div class="input-group">
                                              <span class="input-group-addon">
                                              <i class="zmdi zmdi-facebook-box f-20 c-facebook"></i>
                                              </span>
                                              <div class="fg-line">                       
                                               <input type="text" class="form-control caja input-sm" name="facebook" id="facebook" placeholder="Ingresa la url">
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
                                                  
                                                  <input type="text" class="form-control caja input-sm" name="twitter" id="twitter" placeholder="Ingresa la url">
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
                                                  
                                                  <input type="text" class="form-control caja input-sm" name="instagram" id="instagram" placeholder="Ingresa la url">
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
                                                  <input type="text" class="form-control caja input-sm" name="web" id="web" placeholder="Ej: www.easydancelatino.com">
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
                                                  <input type="text" class="form-control caja input-sm" name="linkedin" id="linkedin" placeholder="Ingresa la url">
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
                                                  <input type="text" class="form-control caja input-sm" name="youtube" id="youtube" placeholder="Ingresa la url">
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
                                             <label for="id">Ingresa url del video promocional</label>
                                             <div class="input-group">
                                              <span class="input-group-addon">
                                              <i class="zmdi zmdi-videocam f-20 c-morado"></i>
                                              </span>                                             
                                              <div class="fg-line">                       
                                                  <input type="text" class="form-control caja input-sm" name="video_promocional" id="video_promocional" placeholder="Ingresa la url">
                                              </div>
                                            </div>
                                              <div class="has-error" id="error-video_promocional">
                                                <span >
                                                    <small id="error-video_promocional_mensaje" class="help-block error-span" ></small>                                           
                                                </span>
                                              </div>
                                          
                                         </div>

                                         <div class="clearfix p-b-20"></div>

                                         <!-- <div class="col-sm-7 text-left">
                                          <div class="procesando hidden">
                                          <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                                          <div class="preloader pls-purple">
                                              <svg class="pl-circular" viewBox="25 25 50 50">
                                                  <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                              </svg>
                                          </div>
                                          </div>
                                        </div> -->
                                        <div class="col-sm-5 col-md-offset-7">                            
                                          <button type="button" class="btn bgm-morado pull-right guardar" data-proceso="contacto" data-siguiente="especiales" >Guardar y Siguiente</button>
                                        </div>

                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="especiales">

                                    <!-- ESPECIALES -->

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
                                          <textarea class="form-control" id="normativa" name="normativa" rows="5" placeholder="Ingresa las normativas de la academia"></textarea>
                                          <div class="has-error" id="error-normativa_movil">
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
                                               <textarea class="form-control" id="manual" name="manual" rows="5" placeholder="Ingresa los manuales de procedimientos de la academia"></textarea>
                                              <div class="has-error" id="error-manual_movil">
                                                <span >
                                                    <small id="error-telefono_manual_mensaje" class="help-block error-span" ></small>                                           
                                                </span>
                                              </div>
                                          </div>
                                         </div>

                                         <div class="clearfix p-b-20"></div>


                                         <div class="col-sm-12">
                                          <div class="form-group">
                                              <label class="m-b-10">Programación de clases</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la programación de clases, de modo que, tu equipo de instructores y alumnos puedan descargar y conocer desde su panel de control las normas que rigen tu institución ingresa el documento en formato PDF" title="" data-original-title="Ayuda"></i><br>                                    
                                              <div class="fileinput fileinput-new" data-provides="fileinput">
                                                  <span class="btn btn-lg btn-file m-r-10">
                                                      <span class="fileinput-new"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i> <br><span class="text-capitalize">Seleccionar</span></span>
                                                      <span class="fileinput-exists"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-100"></i></span>
                                                      <input type="file" name="programacion">
                                                  </span>
                                                  <span class="fileinput-filename"></span>
                                                  <a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>                                   
                                              </div>
                                              <div class="has-error" id="error-programacion">
                                                <span >
                                                    <small id="error-programacion_mensaje" class="help-block error-span" ></small>                                           
                                                </span>
                                              </div>
                                          </div>
                                         </div>

                                         <div class="clearfix p-b-20"></div>
                                        <!--  <div class="clearfix p-b-20"></div>
                                          
                                        <div class="col-sm-12">
                                          <div class="form-group">
                                              <label class="m-b-10">Especialidades</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la programación de clases, de modo que, tu equipo de instructores y alumnos puedan descargar y conocer desde su panel de control las normas que rigen tu institución ingresa el documento en formato PDF" title="" data-original-title="Ayuda"></i><br>

                                         <select class="selectpicker bs-select-hidden" id="especialidades" name="especialidades" multiple="" data-max-options="5" title="Selecciona">

                                         @foreach ( $especialidades as $especialidad )
                                          <option value = "{{ $especialidad['nombre'] }}">{{ $especialidad['nombre'] }}</option>
                                          @endforeach
                                        </select>
                                        <div class="has-error" id="error-programacion">
                                                <span >
                                                    <small id="error-programacion_mensaje" class="help-block error-span" ></small>                                           
                                                </span>
                                              </div>
                                          </div>
                                         </div>

                                        <div class="clearfix p-b-20"></div> -->

                                         <!-- <div class="col-sm-12">
                                               <label class="m-b-10">Estatus de alumnos</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indícale al sistema según tú criterio, cuál sería la cantidad de clases en que el alumno se encuentra en Riego de ausencia, en Easy dance recomendamos que 3 faltas continuas, pudiera representar un alumno en Riego de ausencia y un aproximado de 8 clases se convertirá en un alumno inactivo. Easy Dance actúa para que puedas lograrlo de manera fácil y rápida identificando el estatus que corresponda dependiendo la situación particular de cada academia y participante." title="" data-original-title="Ayuda"></i>                                      
                                               <div class="input-group">
                                                <span class="input-group-addon"><i class="icon_a-estatus-de-clases f-22"></i></span>
                                              <div class="fg-line">
                                                 

                                                  <input type="text" class="form-control input-sm" name="estatu_alumno" id="estatu_alumno" placeholder="Selecciona">
                                              </div>
                                              </div>
                                              <div class="has-error" id="error-estatu_alumno">
                                                <span >
                                                    <small id="error-estatu_alumno_mensaje" class="help-block error-span" ></small>                                           
                                                </span>
                                              </div>
                                          </div> -->

                                          <div class="clearfix p-b-20"></div>

                                         <!-- <div class="col-sm-7 text-left">
                                          <div class="procesando hidden">
                                          <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                                          <div class="preloader pls-purple">
                                              <svg class="pl-circular" viewBox="25 25 50 50">
                                                  <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                              </svg>
                                          </div>
                                          </div>
                                        </div> -->
                                        <div class="col-sm-5 col-md-offset-7">                            
                                          <button type="button" class="btn bgm-morado pull-right guardar" data-proceso="especiales" data-siguiente="administrativo" >Guardar y Siguiente</button>
                                        </div>
                                         

                                       </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="administrativo">

                                    <!-- Administrativo -->
                                     
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

                                     <div class="clearfix p-b-35"></div>

                                     <div class="col-sm-12">
                                          <label for="id" id="id-numero_factura">Próximo número de factura</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="En el caso que estés facturando en tu academia y deseas continuar ,sólo debes indicar el siguiente número y así mantendrás la consecutividad , de igual manera te brindamos la oportunidad de iniciar desde cero (0)" title="" data-original-title="Ayuda"></i>
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="zmdi zmdi-collection-item-1 f-22"></i></span>
                                                 <div class="fg-line"> 
                                                  
                                                  <input type="text" class="form-control input-sm" name="numero_factura" id="numero_factura" placeholder="" value=1>
                                                  </div>
                                                </div>
                                              <div class="has-error" id="error-numero_factura">
                                                <span >
                                                    <small id="error-numero_factura_mensaje" class="help-block error-span" ></small>                                           
                                                </span>
                                              </div>
                                          
                                    </div>


                                    <div class="clearfix p-b-35"></div>

                                    <!-- <div class="col-sm-12">
                                      <label for="apellido">Próxima fecha de pago</label>
                                      <div class="input-group">
                                                <span class="input-group-addon"><i class="zmdi zmdi-calendar-check f-22"></i></span>                                                
                                      
                                              <div class="dtp-container fg-line">
                                                  <input name="fecha_pago" id="fecha_pago" class="form-control date-picker" placeholder="Seleciona" type="text">
                                              </div>
                                      </div>
                                      
                                      <div class="has-error" id="error-fecha_pago">
                                        <span >
                                            <small class="help-block error-span" id="error-fecha_pago_mensaje" ></small>                                           
                                        </span>
                                      </div>
                                    </div>

                                    <div class="clearfix p-b-20"></div> -->

                               <div class="clearfix p-b-35"></div>

                                    



                                         <!-- <div class="col-sm-7 text-left">
                                          <div class="procesando hidden">
                                          <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                                          <div class="preloader pls-purple">
                                              <svg class="pl-circular" viewBox="25 25 50 50">
                                                  <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                              </svg>
                                          </div>
                                          </div>
                                        </div> -->
                                        <div class="col-sm-5 col-md-offset-7">                            
                                          <button type="button" class="btn bgm-morado pull-right guardar" data-proceso="administrativo" data-siguiente="categorias" >Guardar y Siguiente</button>
                                        </div>

                                    </div>

                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="categorias">

                                   <!--  CATEGORIAS -->

                                    <div class="row p-t-30 p-b-0"> 
                                    <div class="col-sm-12">
                                    <div class="form-group fg-line">
                                    <label for="id">Estudios /Salones</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el nombre y la capacidad de personas dentro de tu salón o salones de bailes." title="" data-original-title="Ayuda"></i>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseEstudio" aria-expanded="false" aria-controls="collapseTwo">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>

                                    <div id="collapseEstudio" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    
                                    <div class="panel-body">
                                    
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

                              <button type="button" class="btn btn-blanco m-r-10 f-14" name= "añadirestudio" id="añadirestudio" > Agregar Linea</button>

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
                   
                            </tbody>
                          </table>


                        </div>
                        </div>
                                    <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseEstudio')" ></i></div>

                                    <div class="clearfix p-b-35"></div>
                                      <hr></hr>                                
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                 </div>
                               


                        <div class="clearfix p-b-35"></div>


                                    <div class="col-sm-12">
                                    <div class="form-group fg-line">
                                    <label for="id">Niveles de baile</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el nombre de los distintos niveles de baile que ofreces en tu academia" title="" data-original-title="Ayuda"></i>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseNivel" aria-expanded="false" aria-controls="collapseTwo">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseNivel" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    
                                    <div class="panel-body">
                                    
                                    <label for="nombre_nivel" id="id-nombre_nivel">Nombre</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre de la fiesta o evento" title="" data-original-title="Ayuda"></i>

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
                   
                            </tbody>
                          </table>


                        </div>
                        </div>
                                    <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseNivel')" ></i></div>

                                    <div class="clearfix p-b-35"></div>
                                      <hr></hr>
                                
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                 </div>
                               </div>


                        <div class="clearfix p-b-35"></div>

                               


                                      <div class="clearfix p-b-20"></div>


                                         <!-- <div class="col-sm-7 text-left">
                                          <div class="procesando hidden">
                                          <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                                          <div class="preloader pls-purple">
                                              <svg class="pl-circular" viewBox="25 25 50 50">
                                                  <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                              </svg>
                                          </div>
                                          </div>
                                        </div> -->
                                        <div class="col-sm-5 col-md-offset-7">                            
                                          <button type="button" class="btn bgm-morado pull-right guardar" data-proceso="completar" data-siguiente="completar" data-redirect="completar" id ="guardar" name= "guardar">Guardar</button>
                                        </div>

                                    </div>
                                  </div></form>
                                </div>
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
  //$('.input-mask').mask();

  $(document).ready(function(){

        $("#incluye_iva").val('1');  //VALOR POR DEFECTO
        $("#iva").attr("checked", true); //VALOR POR DEFECTO
        $("#iva").on('change', function(){
          if ($("#iva").is(":checked")){
            $("#incluye_iva").val('1');
          }else{
            $("#incluye_iva").val('0');
          }   
          console.log($("#incluye_iva").val());     
        });
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

  $(".guardar").click(function(){

                proceso=$(this).data('proceso');
                siguiente=$(this).data('siguiente');

                var route = "{{url('/')}}/configuracion/academia/"+proceso;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#configurar_academia" ).serialize(); 
                // $("#guardar").attr("disabled","disabled");
                // procesando();
                // $("#guardar").css({
                //   "opacity": ("0.2")
                // });
                $(".cancelar").attr("disabled","disabled");
                procesando();
                // $(".procesando").removeClass('hidden');
                // $(".procesando").addClass('show');         
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
                          console.log(proceso);
                          if(proceso=="completar"){
                            window.location="{{url('/')}}/configuracion";
                          }

                          finprocesado();
                          $('#proceso_'+siguiente).addClass('c-morado');
                          $('#proceso_'+proceso).removeClass('c-morado');
                          $('#proceso_'+proceso).addClass('c-azul');

                          $('#tab_'+siguiente).html('<a href="#'+siguiente+'" aria-controls="'+siguiente+'" role="tab" data-toggle="tab">'+siguiente+'</a>');

                          $('#tab_'+proceso).html('<a href= "#" aria-controls="#" role="tab" data-toggle="tab">'+proceso+'</a>');

                          $('.tab-nav a[href="#'+siguiente+'"]').tab('show'); 
                          $('body,html').animate({scrollTop : 0}, 500);

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';

                          // $(".procesando").removeClass('show');
                          // $(".procesando").addClass('hidden');
                          // $("#guardar").removeAttr("disabled");
                          // $("#guardar").css({
                          //   "opacity": ("1")
                          // });
                          $(".cancelar").removeAttr("disabled");

                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                        }                       
                        
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        
                          errores(msj.responseJSON.errores);
                          var nTitle="    Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";                                 
                        // $("#guardar").removeAttr("disabled");
                        finprocesado();
                        // $("#guardar").css({
                        //   "opacity": ("1")
                        // });
                        $(".cancelar").removeAttr("disabled");
                        // $(".procesando").removeClass('show');
                        // $(".procesando").addClass('hidden');
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

  $("#añadirestudio").click(function(){

                nombre_estudio = $('#nombre_estudio').val();
                cantidad_estudio = $('#cantidad_estudio').val();

                var route = "{{url('/')}}/configuracion/academia/estudio";
                var token = $('input:hidden[name=_token]').val();
                var datos = "&nombre_estudio="+nombre_estudio+"&cantidad_estudio="+cantidad_estudio;
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

                          var nombre = respuesta.array[0].nombre;
                          var cantidad = respuesta.array[0].cantidad;

                          var rowId=respuesta.id;
                          var rowNode=h.row.add( [
                          ''+nombre+'',
                          ''+cantidad+'',
                          '<i class="zmdi zmdi-delete f-20 p-r-10"></i>'
                          ] ).draw(false).node();
                          $( rowNode )
                          .attr('id',rowId)
                          .addClass('seleccion');

                          // $("#agregar_item")[0].reset();
                          // rechargeServicio();

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }                       
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        $("#guardar").removeAttr("disabled");
                        $(".cancelar").removeAttr("disabled");

                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
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

                nombre_nivel = $('#nombre_nivel').val();

                var route = "{{url('/')}}/configuracion/academia/nivel";
                var token = $('input:hidden[name=_token]').val();
                var datos = "&nombre_nivel="+nombre_nivel;
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

                          var nombre = respuesta.array[0].nombre;

                          var rowId=respuesta.id;
                          var rowNode=t.row.add( [
                          ''+nombre+'',
                          '<i class="zmdi zmdi-delete f-20 p-r-10"></i>'
                          ] ).draw(false).node();
                          $( rowNode )
                          .attr('id',rowId)
                          .addClass('seleccion');

                          // $("#agregar_item")[0].reset();
                          // rechargeServicio();

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }                       
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        $("#guardar").removeAttr("disabled");
                        $(".cancelar").removeAttr("disabled");

                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
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

  
  function limpiarMensaje(){
      var campo = ["correo", "telefono", "celular", "numero_factura", "porcentaje_retraso", "tiempo_tolerancia"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
      var campo = ["correo", "telefono", "celular", "numero_factura", "porcentaje_retraso", "tiempo_tolerancia"];
      var elemento="";
      var contador=0;
      $.each(merror, function (n, c) {
      if(contador==0){
      elemento=n;
      }
      contador++;

       $.each(this, function (name, value) {              
          var error=value;
          $("#error-"+n+"_mensaje").html(error);             
       });
    });

      $('html,body').animate({
            scrollTop: $("#id-"+elemento).offset().top-90,
      }, 1500);          

  }

  $(".add").click(function(){
    nivel=$("#nivel_baile").val();
    var rowNode=t.row.add( [
      ''+nivel+'',
      '<i class="zmdi zmdi-delete f-20 p-r-10"></i>'
    ] ).draw(false).node();
      $( rowNode )
      //.attr('id',rowId)
      .addClass('seleccion');
  });

  $(".eliminar").click(function(){
    //var i = $(this).closest('tr');
    //$(i).remove();

    console.log("a");
  }); 

  function eliminara(el){
   console.log("a"); 
   var row = t.row( $(el).closest('tr') );
   
   row.remove();
   /*var rowNode = row.node();
   var i = $(el).closest('tr');
   $(i).remove();
   */
  }

  $('#tablelistar tbody').on( 'click', 'i.zmdi-delete', function () {
    /*var row = t.row( $(this).parents('tr') );
    var rowNode = row.node();
    row.remove();*/
    t.row( $(this).parents('tr') )
        .remove()
        .draw();
    console.log("entre");
    
  });

  function collapse_minus(collaps){
       $('#'+collaps).collapse('hide');
      }

      $('#collapseDireccion').on('show.bs.collapse', function () {
        $("#guardar").attr("disabled","disabled");
        $("#guardar").css({"opacity": ("0.2")});
      })

      $('#collapseDireccion').on('hide.bs.collapse', function () {
        $("#guardar").removeAttr("disabled");
        $("#guardar").css({"opacity": ("1")});
      })

      $('#collapseNivel').on('show.bs.collapse', function () {
        $("#guardar").attr("disabled","disabled");
        $("#guardar").css({"opacity": ("0.2")});
      })

      $('#collapseNivel').on('hide.bs.collapse', function () {
        $("#guardar").removeAttr("disabled");
        $("#guardar").css({"opacity": ("1")});
      })

      $('#collapseEstudio').on('show.bs.collapse', function () {
        $("#guardar").attr("disabled","disabled");
        $("#guardar").css({"opacity": ("0.2")});
      })

      $('#collapseEstudio').on('hide.bs.collapse', function () {
        $("#guardar").removeAttr("disabled");
        $("#guardar").css({"opacity": ("1")});
      })



</script> 
@stop