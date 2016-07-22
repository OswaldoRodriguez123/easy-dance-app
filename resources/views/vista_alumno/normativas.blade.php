@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/summernote/dist/summernote.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>

<script src="{{url('/')}}/assets/vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<script src="{{url('/')}}/assets/vendors/summernote/dist/summernote.js"></script>
<!--<script src="{{url('/')}}/assets/vendors/summernote/dist/summernote-updated.min.js"></script>-->
<script src="{{url('/')}}/assets/vendors/summernote/dist/lang/summernote-es-ES.js"></script>

@stop

@section('content')

            <div class="modal fade" id="modalInformacion" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Información <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div class="text-center">
                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>
                        <div align="center"><i class="zmdi zmdi-mood zmdi-hc-fw f-60 c-morado"></i></div>

                        <div class="clearfix p-b-15"></div>
                        
                        <div class="col-md-12">
                         <span class="f-20 opaco-0-8">¡ Desde el  módulo de correos, tienes la oportunidad de enviar los correos prediseñados, con sólo pulsar el botón enviar, se enviará el correo de manera personalizada. !</span>
                         </div>

                         <div class="clearfix p-b-15"></div>
                         <div class="clearfix p-b-15"></div>
                         <div class="clearfix p-b-15"></div>
                         <div class="clearfix p-b-15"></div>
                         <div class="clearfix p-b-15"></div>


                        </div>
                       
                    </div>
                </div>
            </div>

            <!-- MODAL DE CUMPLEAÑOS -->

            <div class="modal fade" id="modalBirthday" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Editor <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div>
                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>
                        <form name="correo_cumpleaños" id="correo_cumpleaños"  >

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <!-- <div class="col-md-12">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="zmdi zmdi-email f-22"></i></span>
                                <div class="dtp-container fg-line">
                                    <input name="email_para" id="email_para" class="form-control proceso" placeholder="Correo Electronico" type="text">
                                </div>
                            </div>

                        </div> -->

   <!--                      <div class="col-sm-6">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo_cumpleaños" id="alumno_cumpleaños" value="alumno_cumpleaños" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Alumnos <i id="alumno_cumpleaños2" class="icon_a-alumnos c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo_cumpleaños" id="clase_cumpleaños" value="clase_cumpleaños" type="radio">
                                        <i class="input-helper"></i>  
                                        Clases Grupales <i id="clase_cumpleaños2" class="icon_a-clases-grupales f-20"></i>
                                    </label>
                                    </div>
                                    
                                 </div>
                                </div> 

                                <div class="clearfix p-b-15"></div>
 -->
                        <div class="col-sm-12">
                                 <input type="hidden" id="birthday_SMS" name="birthday_SMS">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="combo_cumpleaños" id="combo_cumpleaños" data-live-search="true">
                                        <!-- <select class="selectpicker bs-select-hidden" id="combo_cumpleaños" name="combo_cumpleaños" multiple="" data-max-options="5" title="Selecciona"> -->
                                        </select>
                                      </div>
                                    </div>
                                 </div>
                                 <div class="has-error" id="error-combo_cumpleaños">
                                      <span >
                                          <small class="help-block error-span" id="error-combo_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               </form>

                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>                        
                        <div class="col-md-12">
                            <div id="html-cumpleaños"></div>
                        </div>

                         <div class="clearfix p-b-15"></div>
                         <div class="clearfix p-b-15"></div>

                         <div class="modal-footer">
                            <button type="button" class="btn btn-blanco m-r-10 f-14 guardar" id="EnviarCumpleaños" >Enviar</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Cerrar</button>
                        </div>


                        </div>
                       
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalAusencia" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Editor <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div>
                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>
                        <form name="correo_ausencia" id="correo_ausencia"  >

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <!-- <div class="col-md-12">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="zmdi zmdi-email f-22"></i></span>
                                <div class="dtp-container fg-line">
                                    <input name="email_para" id="email_para" class="form-control proceso" placeholder="Correo Electronico" type="text">
                                </div>
                            </div>

                        </div> -->
<!-- 
                        <div class="col-sm-6">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo_ausencia" id="alumno_ausencia" value="alumno_ausencia" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Alumnos <i id="alumno_ausencia2" class="icon_a-alumnos c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo_ausencia" id="clase_ausencia" value="clase_ausencia" type="radio">
                                        <i class="input-helper"></i>  
                                        Clases Grupales <i id="clase_ausencia2" class="icon_a-clases-grupales f-20"></i>
                                    </label>
                                    </div>
                                    
                                 </div>
                                </div> 

                                <div class="clearfix p-b-15"></div> -->

                        <div class="col-sm-12">
                                 <input type="hidden" id="ausencia_SMS" name="ausencia_SMS">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="combo_ausencia" id="combo_ausencia" data-live-search="true">
                                        <!-- <select class="selectpicker bs-select-hidden" id="combo_ausencia" name="combo_ausencia" multiple="" data-max-options="5" title="Selecciona"> -->
                                        </select>
                                      </div>
                                    </div>
                                 </div>
                                 <div class="has-error" id="error-combo_ausencia">
                                      <span >
                                          <small class="help-block error-span" id="error-combo_ausencia_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               </form>

                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>                        
                        <div class="col-md-12">
                            <div id="html-ausencia"></div>
                        </div>

                         <div class="clearfix p-b-15"></div>
                         <div class="clearfix p-b-15"></div>

                         <div class="modal-footer">
                            <button type="button" class="btn btn-blanco m-r-10 f-14 guardar" id="EnviarAusencia" >Enviar</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Cerrar</button>
                        </div>


                        </div>
                       
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalCobro" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Editor <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div>
                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>
                        <form name="correo_cobro" id="correo_cobro"  >

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <!-- <div class="col-md-12">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="zmdi zmdi-email f-22"></i></span>
                                <div class="dtp-container fg-line">
                                    <input name="email_para" id="email_para" class="form-control proceso" placeholder="Correo Electronico" type="text">
                                </div>
                            </div>

                        </div> -->

<!--                         <div class="col-sm-6">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo_cobro" id="alumno_cobro" value="alumno_cobro" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Alumnos <i id="alumno_cobro2" class="icon_a-alumnos c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo_cobro" id="clase_cobro" value="clase_cobro" type="radio">
                                        <i class="input-helper"></i>  
                                        Clases Grupales <i id="clase_cobro2" class="icon_a-clases-grupales f-20"></i>
                                    </label>
                                    </div>
                                    
                                 </div>
                                </div> 

                                <div class="clearfix p-b-15"></div> -->

                        <div class="col-sm-12">
                                <input type="hidden" id="cobro_SMS" name="cobro_SMS">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="combo_cobro" id="combo_cobro" data-live-search="true">
                                        <!-- <select class="selectpicker bs-select-hidden" id="combo_cobro" name="combo_cobro" multiple="" data-max-options="5" title="Selecciona"> -->
                                        </select>
                                      </div>
                                    </div>
                                 </div>
                                 <div class="has-error" id="error-combo_cobro">
                                      <span >
                                          <small class="help-block error-span" id="error-combo_cobro_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               </form>

                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>                        
                        <div class="col-md-12">
                            <div id="html-cobro"></div>
                        </div>

                         <div class="clearfix p-b-15"></div>
                         <div class="clearfix p-b-15"></div>

                         <div class="modal-footer">
                            <button type="button" class="btn btn-blanco m-r-10 f-14 guardar" id="EnviarCobro" >Enviar</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Cerrar</button>
                        </div>


                        </div>
                       
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalSuspension" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Editor <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div>
                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>
                        <form name="correo_suspension" id="correo_suspension"  >

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <!-- <div class="col-md-12">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="zmdi zmdi-email f-22"></i></span>
                                <div class="dtp-container fg-line">
                                    <input name="email_para" id="email_para" class="form-control proceso" placeholder="Correo Electronico" type="text">
                                </div>
                            </div>

                        </div> -->

                        <!-- <div class="col-sm-6">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo_suspension" id="alumno_suspension" value="alumno_suspension" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Alumnos <i id="alumno_suspension2" class="icon_a-alumnos c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo_suspension" id="clase_suspension" value="clase_suspension" type="radio">
                                        <i class="input-helper"></i>  
                                        Clases Grupales <i id="clase_suspension2" class="icon_a-clases-grupales f-20"></i>
                                    </label>
                                    </div>
                                    
                                 </div>
                                </div> 

                                <div class="clearfix p-b-15"></div> -->

                        <div class="col-sm-12">
                                 <input type="hidden" id="suspension_SMS" name="suspension_SMS">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="combo_suspension" id="combo_suspension" data-live-search="true">
                                        <!-- <select class="selectpicker bs-select-hidden" id="combo_suspension" name="combo_suspension" multiple="" data-max-options="5" title="Selecciona"> -->
                                        </select>
                                      </div>
                                    </div>
                                 </div>
                                 <div class="has-error" id="error-combo_suspension">
                                      <span >
                                          <small class="help-block error-span" id="error-combo_suspension_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               </form>

                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>                        
                        <div class="col-md-12">
                            <div id="html-suspension"></div>
                        </div>

                         <div class="clearfix p-b-15"></div>
                         <div class="clearfix p-b-15"></div>

                         <div class="modal-footer">
                            <button type="button" class="btn btn-blanco m-r-10 f-14 guardar" id="EnviarSuspension" >Enviar</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Cerrar</button>
                        </div>


                        </div>
                       
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalAdelanto" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Editor <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div>
                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>
                        <form name="correo_adelanto" id="correo_adelanto"  >

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <!-- <div class="col-md-12">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="zmdi zmdi-email f-22"></i></span>
                                <div class="dtp-container fg-line">
                                    <input name="email_para" id="email_para" class="form-control proceso" placeholder="Correo Electronico" type="text">
                                </div>
                            </div>

                        </div> -->

                        <!-- <div class="col-sm-6">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo_adelanto" id="alumno_adelanto" value="alumno_adelanto" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Alumnos <i id="alumno_adelanto2" class="icon_a-alumnos c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo_adelanto" id="clase_adelanto" value="clase_adelanto" type="radio">
                                        <i class="input-helper"></i>  
                                        Clases Grupales <i id="clase_adelanto2" class="icon_a-clases-grupales f-20"></i>
                                    </label>
                                    </div>
                                    
                                 </div>
                                </div> 

                                <div class="clearfix p-b-15"></div>
 -->
                        <div class="col-sm-12">
                                 <input type="hidden" id="adelanto_SMS" name="adelanto_SMS">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="combo_adelanto" id="combo_adelanto" data-live-search="true">
                                        <!-- <select class="selectpicker bs-select-hidden" id="combo_adelanto" name="combo_adelanto" multiple="" data-max-options="5" title="Selecciona"> -->
                                        </select>
                                      </div>
                                    </div>
                                 </div>
                                 <div class="has-error" id="error-combo_adelanto">
                                      <span >
                                          <small class="help-block error-span" id="error-combo_adelanto_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               </form>

                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>                        
                        <div class="col-md-12">
                            <div id="html-adelanto"></div>
                        </div>

                         <div class="clearfix p-b-15"></div>
                         <div class="clearfix p-b-15"></div>

                         <div class="modal-footer">
                            <button type="button" class="btn btn-blanco m-r-10 f-14 guardar" id="EnviarAdelanto" >Enviar</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Cerrar</button>
                        </div>


                        </div>
                       
                    </div>
                </div>
            </div>


<div class="container">

<div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/inicio" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Inicio</a>
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 
    
    <div class="card">
                <div class="card-body p-b-20">
                    <div class="row">
                        <div class="container">
                          <div class="col-sm-3">
                            <div class="p-t-30">       
                              <div class="row p-b-15 ">
                                <div class="col-md-12" data-src="/assets/img/ayuda-configuracion.jpg">
                                  <!--<div class="text-center">
                                    <img src="{{url('/')}}/assets/img/detalle_alumnos.jpg" class="img-responsive img-efecto text-center" alt="">
                                  </div>-->
                                  <ul class="ca-menu-planilla">
                                    <li>
                                        <a href="#" class="disabled">
                                            <span class="ca-icon-planilla"><i class="icon_a icon_a-tutoriales"></i></span>
                                            <div class="ca-content-planilla">
                                                <h2 class="ca-main-planilla">Normativas</h2>
                                                <h3 class="ca-sub-planilla">Sección de reglamentos</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>

                                  <div class="clearfix p-b-15"></div>
                                  <div class="clearfix p-b-15"></div>


                                    
                                   
                                </div>

                                </div>                
                              </div>
                              <!--<p class="text-justify">Desde esta área Easy Dance te brinda la oportunidad de actualizar los datos creados en tu planilla de registro.</p>-->
                                    
                          </div>

                        <div class="pm-body clearfix col-sm-9">
                            <div class="timeline">
                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a icon_a-tutoriales f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">REGLAMENTOS GENERALES </strong>

                                        </div>
                                    </div>
                                    <div class="tv-body">
               
                                    
                                        <div class="clearfix"></div>

<!--                                         <span class="f-700 f-16 opaco-0-8"> Automatizar</span>

                                        <br>
                                    
                                        <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="estilo-switch" type="checkbox" hidden="hidden">
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                        </div> -->
                                        
                                        <br>

                                        <div class="text-right">
                                            <span data-toggle="modal" id="modalCo" href="#modalCobro" class="f-18 p-t-0 c-morado pointer"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-25"></i> Descargar PDF</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a icon_a-clases-grupales f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">CLASES GRUPALES   </strong>


                                        </div>
                                    </div>
                                    <div class="tv-body">
                
                                        <div class="clearfix"></div>

                                        <!-- <span class="f-700 f-16 opaco-0-8"> Automatizar</span>

                                        <br>
                                    
                                        <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="estilo-switch" type="checkbox" hidden="hidden">
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                        </div> -->
                                        
                                        <br>

                                        <div class="text-right">
                                            <span data-toggle="modal" id="modalCo" href="#modalCobro" class="f-18 p-t-0 c-morado pointer"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-25"></i> Descargar PDF</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a icon_a-clase-personalizada f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">CLASES PERSONALIZADAS    </strong>
                                          
                                        </div>
                                    </div>
                                    <div class="tv-body">
      
                                        <div class="clearfix"></div>

                                        <!-- <span class="f-700 f-16 opaco-0-8"> Automatizar</span>

                                        <br>
                                    
                                        <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="estilo-switch" type="checkbox" hidden="hidden">
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                        </div> -->
                                        
                                        <br>

                                        <div class="text-right">
                                            <span data-toggle="modal" id="modalCo" href="#modalCobro" class="f-18 p-t-0 c-morado pointer"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-25"></i> Descargar PDF</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a icon_a-fiesta f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">FIESTA EVENTOS</strong>

 
                                        </div>
                                    </div>
                                    <div class="tv-body">
                                       
                                    
                                        <div class="clearfix"></div>

                                        <!-- <span class="f-700 f-16 opaco-0-8"> Automatizar</span>

                                        <br>
                                    
                                        <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="estilo-switch" type="checkbox" hidden="hidden">
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                        </div> -->
                                        
                                        <br>

                                        <div class="text-right">
                                            <span data-toggle="modal" id="modalCo" href="#modalCobro" class="f-18 p-t-0 c-morado pointer"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-25"></i> Descargar PDF</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a icon_a-talleres f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">TALLERES     </strong>


                                        </div>
                                    </div>
                                    <div class="tv-body">
                                       
                                    
                                        <div class="clearfix"></div>

                                        <!-- <span class="f-700 f-16 opaco-0-8"> Automatizar</span>

                                        <br>
                                    
                                        <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="estilo-switch" type="checkbox" hidden="hidden">
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                        </div> -->
                                        
                                        <br>

                                        <div class="text-right">
                                            <span data-toggle="modal" id="modalCo" href="#modalCobro" class="f-18 p-t-0 c-morado pointer"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw f-25"></i> Descargar PDF</span>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




@stop

@section('js') 

        <!-- Following is only for demo purpose. You may ignore this when you implement -->
        <script type="text/javascript">

            route_cumpleaños="{{url('/')}}/correo/cumpleaños";
            route_ausencia="{{url('/')}}/correo/ausencia";
            route_cobro="{{url('/')}}/correo/cobro";
            route_suspension="{{url('/')}}/correo/suspension";
            route_adelanto="{{url('/')}}/correo/adelanto";

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
                        template: '<div data-growl="container" class="alert" role="alert">' +
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
            
            $(document).ready(function() {

            rechargeAlumno();

            id = "{{{$id or 'Default'}}}";

            if(id != 'Default')
            {

              $("#combo_cumpleaños").val("{{{$id or 'Default' }}}");
              $('#combo_cumpleaños').selectpicker('refresh');
              $("#combo_adelanto").val("{{{$id or 'Default' }}}");
              $('#combo_adelanto').selectpicker('refresh');
              $("#combo_ausencia").val("{{{$id or 'Default' }}}");
              $('#combo_ausencia').selectpicker('refresh');
              $("#combo_cobro").val("{{{$id or 'Default' }}}");
              $('#combo_cobro').selectpicker('refresh');
              $("#combo_suspension").val("{{{$id or 'Default' }}}");
              $('#combo_suspension').selectpicker('refresh');

            }

            //******HABILITACION DE MENSAJES DE TEXTO******//
            $("#cobro_SMS").val('0'); //Valor por Defecto
            $("#cobroSMS-switch").on('change', function(){
              if ($("#cobroSMS-switch").is(":checked")){
                $("#cobro_SMS").val('1');
              }else{
                $("#cobro_SMS").val('0');
              }     
            });

            $("#birthday_SMS").val('0'); //Valor por Defecto
            $("#birthdaySMS-switch").on('change', function(){
              if ($("#birthdaySMS-switch").is(":checked")){
                $("#birthday_SMS").val('1');
              }else{
                $("#birthday_SMS").val('0');
              }     
            });

            $("#suspension_SMS").val('0'); //Valor por Defecto
            $("#suspensionSMS-switch").on('change', function(){
              if ($("#suspensionSMS-switch").is(":checked")){
                $("#suspension_SMS").val('1');
              }else{
                $("#suspension_SMS").val('0');
              }     
            });

            $("#adelanto_SMS").val('0'); //Valor por Defecto
            $("#adelantoSMS-switch").on('change', function(){
              if ($("#adelantoSMS-switch").is(":checked")){
                $("#adelanto_SMS").val('1');
              }else{
                $("#adelanto_SMS").val('0');
              }     
            });

            $("#ausencia_SMS").val('0'); //Valor por Defecto
            $("#ausenciaSMS-switch").on('change', function(){
              if ($("#ausenciaSMS-switch").is(":checked")){
                $("#ausencia_SMS").val('1');
              }else{
                $("#ausencia_SMS").val('0');
              }     
            });


             //EDICION DE TEXTO DE CUMPLEAÑOS
             //AGREGADO EL 15-06-2016


            $("#modalHappyBirth").on("click", function(){
                $('#html-cumpleaños').summernote({
                        height: 150,
                        toolbar: [
                          // [groupName, [list of button]]
                          ['style', ['bold', 'italic', 'underline']],
                          ['fontsize', ['fontsize']],
                          ['color', ['color']],
                          ['para', ['ul', 'ol', 'paragraph']],
                          ['height', ['height']],
                          ['link', ['link']],
                        ],
                        lang: 'es-ES'

                    });
                $('#html-cumpleaños').summernote('code', $('#happyBirth').text());                
            }); 

            $("#modalAu").on("click", function(){
                $('#html-ausencia').summernote({
                        height: 150,
                        toolbar: [
                          // [groupName, [list of button]]
                          ['style', ['bold', 'italic', 'underline']],
                          ['fontsize', ['fontsize']],
                          ['color', ['color']],
                          ['para', ['ul', 'ol', 'paragraph']],
                          ['height', ['height']],
                          ['link', ['link']],
                        ],
                        lang: 'es-ES'

                    });
                $('#html-ausencia').summernote('code', $('#Ausencia').text());                
            }); 

            $("#modalCo").on("click", function(){
                $('#html-cobro').summernote({
                        height: 150,
                        toolbar: [
                          // [groupName, [list of button]]
                          ['style', ['bold', 'italic', 'underline']],
                          ['fontsize', ['fontsize']],
                          ['color', ['color']],
                          ['para', ['ul', 'ol', 'paragraph']],
                          ['height', ['height']],
                          ['link', ['link']],
                        ],
                        lang: 'es-ES'

                    });
                $('#html-cobro').summernote('code', $('#Cobro').text());                
            }); 

            $("#modalSu").on("click", function(){
                $('#html-suspension').summernote({
                        height: 150,
                        toolbar: [
                          // [groupName, [list of button]]
                          ['style', ['bold', 'italic', 'underline']],
                          ['fontsize', ['fontsize']],
                          ['color', ['color']],
                          ['para', ['ul', 'ol', 'paragraph']],
                          ['height', ['height']],
                          ['link', ['link']],
                        ],
                        lang: 'es-ES'

                    });
                $('#html-suspension').summernote('code', $('#Suspension').text());                
            });

            $("#modalAd").on("click", function(){
                $('#html-adelanto').summernote({
                        height: 150,
                        toolbar: [
                          // [groupName, [list of button]]
                          ['style', ['bold', 'italic', 'underline']],
                          ['fontsize', ['fontsize']],
                          ['color', ['color']],
                          ['para', ['ul', 'ol', 'paragraph']],
                          ['height', ['height']],
                          ['link', ['link']],
                        ],
                        lang: 'es-ES'

                    });
                $('#html-adelanto').summernote('code', $('#Adelanto').text());                
            });  
             
             $("#EnviarCumpleaños").on('click', function(){
                var datos = $( "#correo_cumpleaños" ).serialize();
                var values = $('#combo_cumpleaños').val();

                procesando();

                if(values){
                
                var arreglo = '';
                
                for(var i = 0; i < values.length; i += 1) {

                    arreglo = arreglo + '-' + values[i];

                } 
                // Aqui se enviara el correo y el mensaje
                // $html guardara toda la configuracion html y css que contenga
                // el mensaje para poder ser enviada al correo y que mantenga
                // el estilo
                var html = $("div.note-editable.panel-body").html();
                // var combo = $("#combo").val();
                // var tipo = $("#tipo").val();
                var token = $('input:hidden[name=_token]').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    url: route_cumpleaños,
                    type: 'POST',
                    dataType: 'json',
                    data: datos + "&arreglo="+ arreglo + "&msj_html="+html,
                    // {
                    //         msj_html: html, 
                    //         combo: combo,
                    //         tipo: tipo
                    //     }
                })
                .done(function() {
                    // finprocesado();
                    // setTimeout(function(){ 
                    //     var nFrom = $(this).attr('data-from');
                    //     var nAlign = $(this).attr('data-align');
                    //     var nIcons = $(this).attr('data-icon');
                    //     var nAnimIn = "animated flipInY";
                    //     var nAnimOut = "animated flipOutY"; 
                    //     var nType = 'success';
                    //     var nTitle="Ups! ";
                    //     var nMensaje="Tu correo ha sido enviado exitósamente";

                    //     notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                    //   }, 1000);
                    // console.log("success");
                    // $('#modalBirthday').modal('hide');
                })
                .fail(function() {
                    // $('#modalBirthday').modal('hide');
                    // finprocesado();
                    // console.log("fail")
                })
                .always(function() {

                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        var nType = 'success';
                        var nTitle="Ups! ";
                        var nMensaje="Tu correo ha sido enviado exitósamente";

                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                    finprocesado();
                    $('#modalBirthday').modal('hide');
                    console.log("always")
                });

            }else{

                $("#error-combo_cumpleaños_mensaje").html("Debe seleccionar un alumno primero");

              }
                        
            });

            $("#EnviarAusencia").on('click', function(){
                var datos = $( "#correo_ausencia" ).serialize();
                var values = $('#combo_ausencia').val();

                procesando();

                if(values){
                
                var arreglo = '';
                
                for(var i = 0; i < values.length; i += 1) {

                    arreglo = arreglo + '-' + values[i];

                } 
                // Aqui se enviara el correo y el mensaje
                // $html guardara toda la configuracion html y css que contenga
                // el mensaje para poder ser enviada al correo y que mantenga
                // el estilo
                var html = $("div.note-editable.panel-body").html();
                // var combo = $("#combo").val();
                // var tipo = $("#tipo").val();
                var token = $('input:hidden[name=_token]').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    url: route_ausencia,
                    type: 'POST',
                    dataType: 'json',
                    data: datos + "&arreglo="+ arreglo + "&msj_html="+html,
                    // {
                    //         msj_html: html, 
                    //         combo: combo,
                    //         tipo: tipo
                    //     }
                })
                .done(function() {
                    // finprocesado();
                    // setTimeout(function(){ 
                    //     var nFrom = $(this).attr('data-from');
                    //     var nAlign = $(this).attr('data-align');
                    //     var nIcons = $(this).attr('data-icon');
                    //     var nAnimIn = "animated flipInY";
                    //     var nAnimOut = "animated flipOutY"; 
                    //     var nType = 'success';
                    //     var nTitle="Ups! ";
                    //     var nMensaje="Tu correo ha sido enviado exitósamente";

                    //     notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                    //   }, 1000);
                    // console.log("success");
                    // $('#modalBirthday').modal('hide');
                })
                .fail(function() {
                    // $('#modalBirthday').modal('hide');
                    // finprocesado();
                    // console.log("fail")
                })
                .always(function() {

                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        var nType = 'success';
                        var nTitle="Ups! ";
                        var nMensaje="Tu correo ha sido enviado exitósamente";

                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                    finprocesado();
                    $('#modalAusencia').modal('hide');
                    console.log("always")
                });

            }else{

                $("#error-combo_ausencia_mensaje").html("Debe seleccionar una opcion primero");

              }
                        
            }); 

            $("#EnviarSuspension").on('click', function(){
                var datos = $( "#correo_suspension" ).serialize();
                var values = $('#combo_suspension').val();

                procesando();

                if(values){
                
                var arreglo = '';
                
                for(var i = 0; i < values.length; i += 1) {

                    arreglo = arreglo + '-' + values[i];

                } 
                // Aqui se enviara el correo y el mensaje
                // $html guardara toda la configuracion html y css que contenga
                // el mensaje para poder ser enviada al correo y que mantenga
                // el estilo
                var html = $("div.note-editable.panel-body").html();
                // var combo = $("#combo").val();
                // var tipo = $("#tipo").val();
                var token = $('input:hidden[name=_token]').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    url: route_suspension,
                    type: 'POST',
                    dataType: 'json',
                    data: datos + "&arreglo="+ arreglo + "&msj_html="+html,
                    // {
                    //         msj_html: html, 
                    //         combo: combo,
                    //         tipo: tipo
                    //     }
                })
                .done(function() {
                    // finprocesado();
                    // setTimeout(function(){ 
                    //     var nFrom = $(this).attr('data-from');
                    //     var nAlign = $(this).attr('data-align');
                    //     var nIcons = $(this).attr('data-icon');
                    //     var nAnimIn = "animated flipInY";
                    //     var nAnimOut = "animated flipOutY"; 
                    //     var nType = 'success';
                    //     var nTitle="Ups! ";
                    //     var nMensaje="Tu correo ha sido enviado exitósamente";

                    //     notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                    //   }, 1000);
                    // console.log("success");
                    // $('#modalBirthday').modal('hide');
                })
                .fail(function() {
                    // $('#modalBirthday').modal('hide');
                    // finprocesado();
                    // console.log("fail")
                })
                .always(function() {

                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        var nType = 'success';
                        var nTitle="Ups! ";
                        var nMensaje="Tu correo ha sido enviado exitósamente";

                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                    finprocesado();
                    $('#modalSuspension').modal('hide');
                    console.log("always")
                });

            }else{

                $("#error-combo_suspension_mensaje").html("Debe seleccionar una opcion primero");

              }
                        
            }); 

            $("#EnviarCobro").on('click', function(){
                var datos = $( "#correo_cobro" ).serialize();
                var values = $('#combo_cobro').val();

                procesando();

                if(values){
                
                var arreglo = '';
                
                for(var i = 0; i < values.length; i += 1) {

                    arreglo = arreglo + '-' + values[i];

                } 
                // Aqui se enviara el correo y el mensaje
                // $html guardara toda la configuracion html y css que contenga
                // el mensaje para poder ser enviada al correo y que mantenga
                // el estilo
                var html = $("div.note-editable.panel-body").html();
                // var combo = $("#combo").val();
                // var tipo = $("#tipo").val();
                var token = $('input:hidden[name=_token]').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    url: route_cobro,
                    type: 'POST',
                    dataType: 'json',
                    data: datos + "&arreglo="+ arreglo + "&msj_html="+html,
                    // {
                    //         msj_html: html, 
                    //         combo: combo,
                    //         tipo: tipo
                    //     }
                })
                .done(function() {
                    // finprocesado();
                    // setTimeout(function(){ 
                    //     var nFrom = $(this).attr('data-from');
                    //     var nAlign = $(this).attr('data-align');
                    //     var nIcons = $(this).attr('data-icon');
                    //     var nAnimIn = "animated flipInY";
                    //     var nAnimOut = "animated flipOutY"; 
                    //     var nType = 'success';
                    //     var nTitle="Ups! ";
                    //     var nMensaje="Tu correo ha sido enviado exitósamente";

                    //     notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                    //   }, 1000);
                    // console.log("success");
                    // $('#modalBirthday').modal('hide');
                })
                .fail(function() {
                    // $('#modalBirthday').modal('hide');
                    // finprocesado();
                    // console.log("fail")
                })
                .always(function() {

                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        var nType = 'success';
                        var nTitle="Ups! ";
                        var nMensaje="Tu correo ha sido enviado exitósamente";

                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                    finprocesado();
                    $('#modalCobro').modal('hide');
                    console.log("always")
                });

            }else{

                $("#error-combo_cobro_mensaje").html("Debe seleccionar una opcion primero");

              }
                        
            });

            $("#EnviarAdelanto").on('click', function(){
                var datos = $( "#correo_adelanto" ).serialize();
                var values = $('#combo_adelanto').val();

                procesando();

                if(values){
                
                var arreglo = '';
                
                for(var i = 0; i < values.length; i += 1) {

                    arreglo = arreglo + '-' + values[i];

                } 
                // Aqui se enviara el correo y el mensaje
                // $html guardara toda la configuracion html y css que contenga
                // el mensaje para poder ser enviada al correo y que mantenga
                // el estilo
                var html = $("div.note-editable.panel-body").html();
                // var combo = $("#combo").val();
                // var tipo = $("#tipo").val();
                var token = $('input:hidden[name=_token]').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    url: route_adelanto,
                    type: 'POST',
                    dataType: 'json',
                    data: datos + "&arreglo="+ arreglo + "&msj_html="+html,
                    // {
                    //         msj_html: html, 
                    //         combo: combo,
                    //         tipo: tipo
                    //     }
                })
                .done(function() {
                    // finprocesado();
                    // setTimeout(function(){ 
                    //     var nFrom = $(this).attr('data-from');
                    //     var nAlign = $(this).attr('data-align');
                    //     var nIcons = $(this).attr('data-icon');
                    //     var nAnimIn = "animated flipInY";
                    //     var nAnimOut = "animated flipOutY"; 
                    //     var nType = 'success';
                    //     var nTitle="Ups! ";
                    //     var nMensaje="Tu correo ha sido enviado exitósamente";

                    //     notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                    //   }, 1000);
                    // console.log("success");
                    // $('#modalBirthday').modal('hide');
                })
                .fail(function() {
                    // $('#modalBirthday').modal('hide');
                    // finprocesado();
                    // console.log("fail")
                })
                .always(function() {

                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        var nType = 'success';
                        var nTitle="Ups! ";
                        var nMensaje="Tu correo ha sido enviado exitósamente";

                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                    finprocesado();
                    $('#modalAdelanto').modal('hide');
                    console.log("always")
                });

            }else{

                $("#error-combo_adelanto_mensaje").html("Debe seleccionar una opcion primero");

              }
                        
            });

            });

            function rechargeAlumno(){

            var alumnos = <?php echo json_encode($alumnos);?>;  

            $('#combo_cumpleaños').append( new Option("Selecciona",""));
            $.each(alumnos, function (index, array) {
              
                $('#combo_cumpleaños').append( new Option(array.nombre + " " + array.apellido + " " + array.identificacion,array.id));
              });

            $('#combo_cumpleaños').selectpicker('render');
            $('#combo_cumpleaños').selectpicker('refresh');

            $('#combo_ausencia').append( new Option("Selecciona",""));
            $.each(alumnos, function (index, array) {
              
                $('#combo_ausencia').append( new Option(array.nombre + " " + array.apellido + " " + array.identificacion,array.id));
              });

            $('#combo_ausencia').selectpicker('render');
            $('#combo_ausencia').selectpicker('refresh');

            $('#combo_cobro').append( new Option("Selecciona",""));
            $.each(alumnos, function (index, array) {
              
                $('#combo_cobro').append( new Option(array.nombre + " " + array.apellido + " " + array.identificacion,array.id));
              });

            $('#combo_cobro').selectpicker('render');
            $('#combo_cobro').selectpicker('refresh');

            $('#combo_suspension').append( new Option("Selecciona",""));
            $.each(alumnos, function (index, array) {
              
                $('#combo_suspension').append( new Option(array.nombre + " " + array.apellido + " " + array.identificacion,array.id));
              });

            $('#combo_suspension').selectpicker('render');
            $('#combo_suspension').selectpicker('refresh');

            $('#combo_adelanto').append( new Option("Selecciona",""));
            $.each(alumnos, function (index, array) {
              
                $('#combo_adelanto').append( new Option(array.nombre + " " + array.apellido + " " + array.identificacion,array.id));
              });

            $('#combo_adelanto').selectpicker('render');
            $('#combo_adelanto').selectpicker('refresh');

            }

            function rechargeClase(){

            var clasegrupal = <?php echo json_encode($clasegrupal);?>;

            $('#combo_cumpleaños').append( new Option("Selecciona",""));
            // for (i in producto)
            $.each(clasegrupal, function (index, array) {
                $('#combo_cumpleaños').append( new Option(array.nombre,array.id));
              });

            $('#combo_cumpleaños').selectpicker('render');
            $('#combo_cumpleaños').selectpicker('refresh');

             $('#combo_ausencia').append( new Option("Selecciona",""));
            // for (i in producto)
            $.each(clasegrupal, function (index, array) {
                $('#combo_ausencia').append( new Option(array.nombre,array.id));
              });

            $('#combo_ausencia').selectpicker('render');
            $('#combo_ausencia').selectpicker('refresh');

            $('#combo_cobro').append( new Option("Selecciona",""));
            // for (i in producto)
            $.each(clasegrupal, function (index, array) {
                $('#combo_cobro').append( new Option(array.nombre,array.id));
              });

            $('#combo_cobro').selectpicker('render');
            $('#combo_cobro').selectpicker('refresh');

            $('#combo_suspension').append( new Option("Selecciona",""));
            // for (i in producto)
            $.each(clasegrupal, function (index, array) {
                $('#combo_suspension').append( new Option(array.nombre,array.id));
              });

            $('#combo_suspension').selectpicker('render');
            $('#combo_suspension').selectpicker('refresh');

            $('#combo_adelanto').append( new Option("Selecciona",""));
            // for (i in producto)
            $.each(clasegrupal, function (index, array) {
                $('#combo_adelanto').append( new Option(array.nombre,array.id));
              });

            $('#combo_adelanto').selectpicker('render');
            $('#combo_adelanto').selectpicker('refresh');

            }


            $('input[name="tipo_cumpleaños"]').on('change', function(){

                if ($(this).val()=='alumno_cumpleaños') {
                      tipo_cumpleaños = 'alumno';
                      $('#combo_cumpleaños').empty();
                      rechargeAlumno();
                } else  {
                      tipo_cumpleaños = 'clase';
                      $('#combo_cumpleaños').empty();
                      rechargeClase();
                }

            });

            $('input[name="tipo_ausencia"]').on('change', function(){

                if ($(this).val()=='alumno_ausencia') {
                      tipo_ausencia = 'alumno';
                      $('#combo_ausencia').empty();
                      rechargeAlumno();
                } else  {
                      tipo_ausencia = 'clase';
                      $('#combo_ausencia').empty();
                      rechargeClase();
                }

            });  

            $('input[name="tipo_cobro"]').on('change', function(){

                if ($(this).val()=='alumno_cobro') {
                      tipo_cobro = 'alumno';
                      $('#combo_cobro').empty();
                      rechargeAlumno();
                } else  {
                      tipo_cobro = 'clase';
                      $('#combo_cobro').empty();
                      rechargeClase();
                }

            }); 

            $('input[name="tipo_suspension"]').on('change', function(){

                if ($(this).val()=='alumno_suspension') {
                      tipo_suspension = 'alumno';
                      $('#combo_suspension').empty();
                      rechargeAlumno();
                } else  {
                      tipo_suspension = 'clase';
                      $('#combo_suspension').empty();
                      rechargeClase();
                }

            }); 

            $('input[name="tipo_adelanto"]').on('change', function(){

                if ($(this).val()=='alumno_adelanto') {
                      tipo_adelanto = 'alumno';
                      $('#combo_adelanto').empty();
                      rechargeAlumno();
                } else  {
                      tipo_adelanto = 'clase';
                      $('#combo_adelanto').empty();
                      rechargeClase();
                }

            }); 

            $("#alumno_cumpleaños").click(function(){
                $( "#clase_cumpleaños2" ).removeClass( "c-verde" );
                $( "#alumno_cumpleaños2" ).addClass( "c-verde" );
            });

            $("#clase_cumpleaños").click(function(){
                $( "#alumno_cumpleaños2" ).removeClass( "c-verde" );
                $( "#clase_cumpleaños2" ).addClass( "c-verde" );
            });  

            $("#alumno_ausencia").click(function(){
                $( "#clase_ausencia2" ).removeClass( "c-verde" );
                $( "#alumno_ausencia2" ).addClass( "c-verde" );
            });

            $("#clase_ausencia").click(function(){
                $( "#alumno_ausencia2" ).removeClass( "c-verde" );
                $( "#clase_ausencia2" ).addClass( "c-verde" );
            });

            $("#alumno_cobro").click(function(){
                $( "#clase_cobro2" ).removeClass( "c-verde" );
                $( "#alumno_cobro2" ).addClass( "c-verde" );
            });

            $("#clase_cobro").click(function(){
                $( "#alumno_cobro2" ).removeClass( "c-verde" );
                $( "#clase_cobro2" ).addClass( "c-verde" );
            }); 

            $("#alumno_suspension").click(function(){
                $( "#clase_suspension2" ).removeClass( "c-verde" );
                $( "#alumno_suspension2" ).addClass( "c-verde" );
            });

            $("#clase_suspension").click(function(){
                $( "#alumno_suspension2" ).removeClass( "c-verde" );
                $( "#clase_suspension2" ).addClass( "c-verde" );
            })

            $("#alumno_adelanto").click(function(){
                $( "#clase_adelanto2" ).removeClass( "c-verde" );
                $( "#alumno_adelanto2" ).addClass( "c-verde" );
            });

            $("#clase_adelanto").click(function(){
                $( "#alumno_adelanto2" ).removeClass( "c-verde" );
                $( "#clase_adelanto2" ).addClass( "c-verde" );
            })

        </script>
@stop        