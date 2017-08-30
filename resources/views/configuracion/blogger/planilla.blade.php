@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/summernote/dist/summernote.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/summernote/dist/summernote.js"></script>
<script src="{{url('/')}}/assets/vendors/summernote/dist/lang/summernote-es-ES.js"></script>
@stop

@section('content')

          
            <div class="modal fade" id="modal-Nombre" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Blogger<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_nombre" id="edit_nombre"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group">
                                    <label for="nombre">Titulo</label>
                                    <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="nombre" id="nombre" placeholder="Ej: Valeria Zambrano">
                                    </div>
                                  </div>
                                 <div class="has-error" id="error-nombre">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>


                               <input type="hidden" name="id" value="{{$blogger->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_nombre" data-update="nombre" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-Imagen" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Blogger<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_imagen" id="edit_imagen"  >
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
                                          @if($blogger->imagen)
                                            <img src="{{url('/')}}/assets/uploads/bloggers/{{$blogger->imagen}}" style="line-height: 150px;">
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

                               <input type="hidden" name="id" value="{{$blogger->id}}"></input>
                              

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

                              <a class="btn-morado m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_imagen" data-update="imagen" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-Descripcion" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Blogger<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_descripcion" id="edit_descripcion"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group">
                                    <label for="correo">Descripción</label>
                                    <div class="fg-line">
                                      <textarea class="form-control" id="descripcion" name="descripcion" rows="8" placeholder="350 Caracteres" maxlength="350" onkeyup="countChar(this)"></textarea>
                                    </div>
                                 </div>
                                 
                                 <div class="opaco-0-8 text-right">Resta <span id="charNum">350</span> Caracteres</div>
                                 <div class="has-error" id="error-descripcion">
                                      <span >
                                          <small class="help-block error-span" id="error-descripcion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                                     

                               <div class="clearfix"></div> 

                               <input type="hidden" name="id" value="{{$blogger->id}}"></input>

                               
                               
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_descripcion" data-update="descripcion" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-Redes" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Blogger<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_redes" id="edit_redes"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input type="hidden" name="id" value="{{$blogger->id}}"></input>
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-6">
                                             <label for="id">Facebook  </label>
                                             <div class="input-group">
                                              <span class="input-group-addon">
                                              <i class="zmdi zmdi-facebook-box f-20 c-facebook"></i>
                                              </span>
                                              <div class="fg-line">                       
                                               <input type="text" class="form-control caja input-sm" name="facebook" id="facebook" placeholder="Ingresa la url" value="{{$blogger->facebook}}">
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
                                                  
                                                  <input type="text" class="form-control caja input-sm" name="twitter" id="twitter" placeholder="Ingresa la url" value="{{$blogger->twitter}}">
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
                                                  
                                                  <input type="text" class="form-control caja input-sm" name="instagram" id="instagram" placeholder="Ingresa la url" value="{{$blogger->instagram}}">
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
                                                  <input type="text" class="form-control caja input-sm" name="pagina_web" id="pagina_web" placeholder="Ej: www.easydancelatino.com" value="{{$blogger->pagina_web}}">
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
                                                  <input type="text" class="form-control caja input-sm" name="linkedin" id="linkedin" placeholder="Ingresa la url" value="{{$blogger->linkedin}}">
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
                                                  <input type="text" class="form-control caja input-sm" name="youtube" id="youtube" placeholder="Ingresa la url" value="{{$blogger->youtube}}">
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_redes" data-update="redes" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <section id="content">
                <div class="container">
                


                    <div class="block-header">
                       <?php $url = "/blog" ?>
                        <a onclick="procesando()" class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                    </div> 
                    
                    <div class="card">
    
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
                                        <a href="#" class="mousehand disabled">
                                            <span class="ca-icon-planilla"><i class="glyphicon glyphicon-book"></i></span>
                                            <div class="ca-content-planilla">
                                                <h2 class="ca-main-planilla">Vista Blogero</h2>
                                                <h3 class="ca-sub-planilla">Personaliza el campo blogero</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>

                                  <div class="col-sm-12 text-center"> 

                                  <br>

                                  <span class="f-16 f-700">Acciones</span>

                                  <hr>
                                  
                                  <!-- <a class="email"><i class="zmdi zmdi-email f-20 m-r-5 boton blue sa-warning" data-original-title="Enviar Correo" data-toggle="tooltip" data-placement="bottom" title=""></i></a> -->
                                  <i class="zmdi zmdi-delete f-20 m-r-10 boton red sa-warning" name="eliminar" data-original-title="Eliminar" data-toggle="tooltip" data-placement="bottom" title=""></i>

                                  <br></br>
                                    
                                   
                                  </div>

          					            </div>                
          					          </div>
          					          <!--<p class="text-justify">Desde esta área Easy Dance te brinda la oportunidad de actualizar los datos creados en tu planilla de registro.</p>-->
          					                
          					      </div>
					           </div>

					           	<div class="col-sm-9">

                        <div class="col-sm-12">
                            <p class="text-center opaco-0-8 f-22">Datos del Blogero</p>
                        </div>

                        <div class="col-sm-12">
                          <table class="table table-striped table-bordered">
                            <tr class="detalle" data-toggle="modal" href="#modal-Nombre">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-nombre" class="zmdi {{ empty($blogger->nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-accounts-alt f-22"></i> </span>
                               <span class="f-14"> Nombre </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="blogger-nombre" class="capitalize">{{$blogger->nombre}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modal-Descripcion">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-descripcion" class="zmdi {{ empty($blogger->descripcion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b-cuentales-historia f-22"></i> </span>
                               <span class="f-14"> Descripción </span>
                             </td>
                             <td id="blogger-descripcion" class="f-14 m-l-15" data-valor="{{$blogger->descripcion}}" >{{ str_limit($blogger->descripcion, $limit = 30, $end = '...') }} <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modal-Imagen">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-imageBase64" class="zmdi {{ empty($blogger->imagen) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-collection-folder-image zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Imagen </span>
                             </td>
                             <td class="f-14 m-l-15" ><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modal-Redes">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-facebook" class="zmdi {{ empty($blogger->facebook) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-share zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Redes Sociales </span>
                             </td>
                             <td class="f-14 m-l-15" ><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
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
    route_update="{{url('/')}}/configuracion/blogeros/update";
    route_eliminar="{{url('/')}}/configuracion/blogeros/eliminar/";
    route_principal="{{url('/')}}/configuracion/blogeros";

    $(document).ready(function(){

      $('#nombre').mask('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', {'translation': {

        A: {pattern: /[A-Za-záéíóúÁÉÍÓÚ.,@*+_ñÑ ]/}
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

    $('#modal-Nombre').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#nombre").val($("#blogger-nombre").text()); 
    })

    $('#modal-Descripcion').on('show.bs.modal', function (event) {
      limpiarMensaje();
       var descripcion=$("#blogger-descripcion").data('valor');
       $("#descripcion").val(descripcion);
    })

    function limpiarMensaje(){
        var campo = ["nombre", "descripcion", "imagen"];
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
          if(c.name=='descripcion'){
             $("#blogger-"+c.name).data('valor',c.value);
             $("#blogger-"+c.name).html(c.value.substr(0, 30) + "...");
           }else{
            $("#blogger-"+c.name).text(c.value);
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
        var datos = $( "#"+form ).serialize();
        
        var token = $('input:hidden[name=_token]').val();
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
                finprocesado();
              }, 1000);             
            }
        })
       
    })

    $("i[name=eliminar]").click(function(){
      swal({   
          title: "Desea eliminar al blogero?",   
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

        eliminar();
      }
    });
  });
    
    function eliminar(){
       var route = route_eliminar + "{{$id}}";
       var token = '{{ csrf_token() }}';
       procesando();
              
      $.ajax({
          url: route,
              headers: {'X-CSRF-TOKEN': token},
              type: 'DELETE',
          dataType: 'json',
          success:function(respuesta){

              window.location = route_principal; 

          },
          error:function(msj){

            swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
          }
      });
    }

  function countChar(val) {
    var len = val.value.length;
    if (len >= 350) {
      val.value = val.value.substring(0, 350);
    } else {
      $('#charNum').text(350 - len);
    }
  };

   </script> 
  
		
@stop
