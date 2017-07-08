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

                        <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker id" name="id" id="id" data-live-search="true">
                                        <!-- <select class="selectpicker bs-select-hidden" id="combo_ausencia" name="combo_ausencia" multiple="" data-max-options="5" title="Selecciona"> -->
                                        </select>
                                      </div>
                                    </div>
                                 </div>
                                 <div class="has-error" id="error-id">
                                      <span >
                                          <small class="help-block error-span" id="error-id_mensaje" ></small>                                
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


                        <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker id" name="id" id="id" data-live-search="true">
                                        <!-- <select class="selectpicker bs-select-hidden" id="combo_cobro" name="combo_cobro" multiple="" data-max-options="5" title="Selecciona"> -->
                                        </select>
                                      </div>
                                    </div>
                                 </div>
                                 <div class="has-error" id="error-id">
                                      <span >
                                          <small class="help-block error-span" id="error-id_mensaje" ></small>                                
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

                        <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker id" name="id" id="id" data-live-search="true">
                                        <!-- <select class="selectpicker bs-select-hidden" id="combo_suspension" name="combo_suspension" multiple="" data-max-options="5" title="Selecciona"> -->
                                        </select>
                                      </div>
                                    </div>
                                 </div>
                                 <div class="has-error" id="error-id">
                                      <span >
                                          <small class="help-block error-span" id="error-id_mensaje" ></small>                                
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

                        <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker id" name="id" id="id" data-live-search="true">
                                        <!-- <select class="selectpicker bs-select-hidden" id="combo_adelanto" name="combo_adelanto" multiple="" data-max-options="5" title="Selecciona"> -->
                                        </select>
                                      </div>
                                    </div>
                                 </div>
                                 <div class="has-error" id="error-id">
                                      <span >
                                          <small class="help-block error-span" id="error-id_mensaje" ></small>                                
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

        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menu Principal</a>

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
                            <div class="p-t-30">       
                              <div class="row p-b-15 ">
                                <div class="col-md-12" data-src="/assets/img/ayuda-configuracion.jpg">
                                  <ul class="ca-menu-planilla">
                                    <li>
                                        <a href="#" class="disabled">
                                            <span class="ca-icon-planilla"><i class="zmdi zmdi-email zmdi-hc-fw"></i></span>
                                            <div class="ca-content-planilla">
                                                <h2 class="ca-main-planilla">Envío de correos</h2>
                                                <h3 class="ca-sub-planilla">Personaliza tus envíos</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>

                                  <div class="clearfix p-b-15"></div>
                                  <div class="clearfix p-b-15"></div>
                                   
                              </div>
                            </div>                
                          </div>      
                        </div>

                        <div class="pm-body clearfix col-sm-9">
                            <div class="timeline">

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a-pagar f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">PERSONALIZADO </strong>

                                        </div>
                                    </div>
                                    <div class="tv-body">
                                        
                                        <br>

                                        <div class="text-right">
                                            <span data-toggle="modal" id="modalPe" href="#modalPersonalizado" class="f-18 p-t-0 c-morado pointer">Enviar Correo</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a-pagar f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">AVISO DE COBRO </strong>
                                        </div>
                                    </div>
                                    <div class="tv-body">
                                        <p class="f-14" id="Cobro">Hola, el siguiente comunicado es para informarte que para la fecha del (_/_/_/) deberás realizar el pago de los servicios ofrecidos y así seguir disfrutando de nuestras clases.</p>
                                    
                                        <div class="clearfix"></div>
                                        
                                        <br>

                                        <div class="text-right">
                                            <span data-toggle="modal" id="modalCo" href="#modalCobro" class="f-18 p-t-0 c-morado pointer">Enviar Correo</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="zmdi zmdi-cake zmdi-hc-fw f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">FELIZ CUMPLEAÑOS   </strong>
                                        </div>
                                    </div>
                                    <div class="tv-body">
                                        <p class="f-14" id="happyBirth">¡Feliz cumpleaños!. En este día tan especial para ti, deseamos que pases un cumpleaños lleno de mucha alegría y prosperidad; y que la vida te brinde muchos años más al lado de tus seres queridos.</p>
                                    
                                        <div class="clearfix"></div>
                                        
                                        <br>

                                        <div class="text-right">
                                            <span data-toggle="modal" id="modalHappyBirth" href="#modalBirthday" class="f-18 p-t-0 c-morado pointer">Enviar Correo</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="zmdi zmdi-close-circle zmdi-hc-fw f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">SUSPENSIÓN DE CLASES    </strong>                                          
                                        </div>
                                    </div>
                                    <div class="tv-body">
                                        <p class="f-14" id="Suspension">Saludos, te informamos que por razones ajenas a nuestra voluntad la clase establecida para la fecha (_/_/_/) ha sido pospuesta, te pedimos disculpas por los cambios realizados y esperamos verte en la siguiente clase para seguir bailando.</p>
                                    
                                        <div class="clearfix"></div>
                                        
                                        <br>

                                        <div class="text-right">
                                            <span data-toggle="modal" id="modalSu" href="#modalSuspension" class="f-18 p-t-0 c-morado pointer">Enviar Correo</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="zmdi zmdi-rotate-right zmdi-hc-fw f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">ADELANTO DE  NUEVAS APERTURAS</strong>

                                        </div>
                                    </div>
                                    <div class="tv-body">
                                        <p class="f-14" id="Adelanto">Hola te informamos que el inicio de nivel establecido para la fecha (_/_/_/) lo adelantaremos para la fecha (_/_/_/) debido a que los cupos ofrecidos fueron ocupados rápidamente, por tal motivo la organización toma la iniciativa de empezar su nivel antes del tiempo previsto, esperamos verte en clases.</p>
                                    
                                        <div class="clearfix"></div>
                                        
                                        <br>

                                        <div class="text-right">
                                            <span data-toggle="modal" id="modalAd" href="#modalAdelanto" class="f-18 p-t-0 c-morado pointer">Enviar Correo</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="zmdi zmdi-label zmdi-hc-fw f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">RIESGO DE AUSENCIA     </strong>

                                        </div>
                                    </div>
                                    <div class="tv-body">
                                        <p class="f-14" id="Ausencia">Hola, el motivo de nuestro mensaje es que notamos con preocupación que no has asistido a las clases últimamente. Te invitamos a ponerte en contacto con nosotros para brindarte el apoyo y que puedas recuperar las clases perdidas.</p>
                                    
                                        <div class="clearfix"></div>
                                        
                                        <br>

                                        <div class="text-right">
                                            <span data-toggle="modal" id="modalAu" href="#modalAusencia" class="f-18 p-t-0 c-morado pointer">Enviar Correo</span>
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

                                <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker id" name="id" id="id" data-live-search="true">
                                        </select>
                                      </div>
                                    </div>
                                 </div>
                                 <div class="has-error" id="error-id">
                                      <span >
                                          <small class="help-block error-span" id="error-id_mensaje" ></small>                                
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

            <div class="modal fade" id="modalPersonalizado" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Editor <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div>
                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>
                        <form name="correo_personalizado" id="correo_personalizado"  >

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="col-sm-12">
                                 
                                  <label for="tipo" id="id-tipo">Modo de envio</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona a quienes le llegara el correo" title="" data-original-title="Ayuda" data-html="true"></i>

                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="icon_a-especialidad f-22"></i></span>
                                    <div class="fg-line">
                                    <div class="select">
                                      <select class="selectpicker" name="tipo" id="tipo" data-live-search="true">

                                        <option value="3">Correo</option>
                                        <option value="2">Mensaje</option>
                                        <option value="1">Ambos</option>
                                        
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                 <div class="has-error" id="error-tipo">
                                      <span >
                                          <small class="help-block error-span" id="error-tipo_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                            <div class="col-sm-12">
                                 
                                  <label for="dirigido">A quien va dirigido</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona a quienes le llegara el correo" title="" data-original-title="Ayuda" data-html="true"></i>

                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="icon_a-especialidad f-22"></i></span>
                                    <div class="fg-line">
                                    <div class="select">
                                      <select class="selectpicker" name="dirigido" id="dirigido" data-live-search="true">

                                        <option value="1">Todos</option>
                                        <option value="2">Visitantes Presenciales</option>
                                        <option value="3">Alumnos</option>
                                        
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                 <div class="has-error" id="error-dirigido">
                                      <span >
                                          <small class="help-block error-span" id="error-dirigido_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                              <div class="col-sm-12">
                                  <label for="id" id="id-url">Ingresa url de la imagen</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Haz un video promocional no mayor a dos minutos, mientras mejor desarrolles tu video, tendrás  más oportunidad de persuadir a tus clientes a contribuir con el logro de tus objetivos" title="" data-original-title="Ayuda"></i>

                                  <br><br>
                                  
                     
                                  <input type="text" class="form-control caja input-sm" name="url" id="url" placeholder="Ingresa la url">
                                   
                                   
                                   <div class="has-error" id="error-url">
                                    <span >
                                     <small id="error-url_mensaje" class="help-block error-span" ></small>                                           
                                    </span>
                                    </div>                                          
                                </div>

                                <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">

                                <br><br>
                                 
                                    <label for="nombre" id="id-subj">Titulo</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre de la clase personalizada" title="" data-original-title="Ayuda"></i>


                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="subj" id="subj" placeholder="Ej. Información">
                                      </div>
                                      <div class="has-error" id="error-subj">
                                      <span >
                                          <small class="help-block error-span" id="error-subj_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                          <div class="col-sm-12">
                            <label for="apellido" id="id-imagen">Cargar Imagen</label></label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Carga una imagen horizontal  para que sea utilizada cuando compartes en Facebook.  Resolución recomendada: 1200 x 630, resolución mínima: 600 x 315" title="" data-original-title="Ayuda"></i>
                            
                            <div class="clearfix p-b-15"></div>
                              
                            <input type="hidden" name="imageBase64" id="imageBase64">
                              <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div id="imagena" class="fileinput-preview thumbnail" data-trigger="fileinput" style="width:450px"></div>
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

                              <div class="clearfix p-b-35"></div>


         

                        </form>

                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div> 

                        <div class="col-md-12">
                          <label for="id" id="id-msj_html">Mensaje</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Haz un video promocional no mayor a dos minutos, mientras mejor desarrolles tu video, tendrás  más oportunidad de persuadir a tus clientes a contribuir con el logro de tus objetivos" title="" data-original-title="Ayuda"></i>

                          <br><br>
                          <div id="html-personalizado"></div>
                          <div class="has-error" id="error-msj_html">
                            <span >
                                <small class="help-block error-span" id="error-msj_html_mensaje" ></small>
                            </span>
                          </div>
                        </div>

                         <div class="clearfix p-b-15"></div>
                         <div class="clearfix p-b-15"></div>

                         <div class="modal-footer">
                            <button type="button" class="btn btn-blanco m-r-10 f-14 guardar" id="EnviarPersonalizado" >Enviar</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Cerrar</button>
                        </div>


                        </div>
                       
                    </div>
                </div>
            </div>




@stop

@section('js') 

      <script type="text/javascript">


          route_cumpleaños="{{url('/')}}/correo/cumpleaños";
          route_ausencia="{{url('/')}}/correo/ausencia";
          route_cobro="{{url('/')}}/correo/cobro";
          route_suspension="{{url('/')}}/correo/suspension";
          route_adelanto="{{url('/')}}/correo/adelanto";
          route_personalizado="{{url('/')}}/correo/personalizado";

            $(document).ready(function() {
              
              rechargeAlumno();

              id = "{{{$id or 'Default'}}}";

              if(id != 'Default')
              {

                $(".id").val("{{{$id or 'Default' }}}");
                $('.selectpicker').selectpicker('refresh');

              }

               $("#modalPe").on("click", function(){
                  $('#html-personalizado').summernote({
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
                  $('#html-personalizado').summernote('code', '');                
              });


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
            });
 

            $("#EnviarPersonalizado").on('click', function(){

                procesando();

                // Aqui se enviara el correo y el mensaje
                // $html guardara toda la configuracion html y css que contenga
                // el mensaje para poder ser enviada al correo y que mantenga
                // el estilo
                // var html = $("div.note-editable.panel-body").html();
                var datos = $( "#correo_personalizado" ).serialize();
                var html = $('#html-personalizado').summernote('code');
                // var combo = $("#combo").val();
                // var tipo = $("#tipo").val();
                var token = $('input:hidden[name=_token]').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    url: route_personalizado,
                    type: 'POST',
                    dataType: 'json',
                    data: datos+"&msj_html="+html,
                    success:function(respuesta){
                      setTimeout(function(){ 
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        if(respuesta.status=="OK"){
                          var nFrom = $(this).attr('data-from');
                          var nAlign = $(this).attr('data-align');
                          var nIcons = $(this).attr('data-icon');
                          var nAnimIn = "animated flipInY";
                          var nAnimOut = "animated flipOutY"; 
                          var nType = 'success';
                          var nTitle="Ups! ";
                          var nMensaje="Tu correo ha sido enviado exitósamente";

                      finprocesado();
                      $('#modalPersonalizado').modal('hide');

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }                       
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        finprocesado();
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

             
             $("#EnviarCumpleaños").on('click', function(){
                var datos = $( "#correo_cumpleaños" ).serialize();
                var values = $('#combo_cumpleaños').val();

                procesando();

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
                    data: datos + "&msj_html="+html,
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
                        
            });

            $("#EnviarAusencia").on('click', function(){
                var datos = $( "#correo_ausencia" ).serialize();
                var values = $('#combo_ausencia').val();

                procesando();

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
                    data: datos + "&msj_html="+html,
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
                        
            }); 

            $("#EnviarSuspension").on('click', function(){
                var datos = $( "#correo_suspension" ).serialize();
                var values = $('#combo_suspension').val();

                procesando();

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
                    data: datos +"&msj_html="+html,
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
                        
            }); 

            $("#EnviarCobro").on('click', function(){
                var datos = $( "#correo_cobro" ).serialize();
                var values = $('#combo_cobro').val();

                procesando();

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
                    data: datos + "&msj_html="+html,
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
                        
            });

            $("#EnviarAdelanto").on('click', function(){
                var datos = $( "#correo_adelanto" ).serialize();
                var values = $('#combo_adelanto').val();

                procesando();

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
                    data: datos+"&msj_html="+html,
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

                        
            });

            function rechargeAlumno(){

              var alumnos = <?php echo json_encode($alumnos);?>;  

              $.each(alumnos, function (index, array) {
                $('.id').append( new Option(array.nombre + " " + array.apellido + " " + array.identificacion,array.id));
              });

              // $('#combo_cumpleaños').append( new Option("Selecciona",""));
              // $.each(alumnos, function (index, array) {
              //   $('#combo_cumpleaños').append( new Option(array.nombre + " " + array.apellido + " " + array.identificacion,array.id));
              // });

              // $('#combo_ausencia').append( new Option("Selecciona",""));

              // $.each(alumnos, function (index, array) {
              //   $('#combo_ausencia').append( new Option(array.nombre + " " + array.apellido + " " + array.identificacion,array.id));
              // });

              // $('#combo_cobro').append( new Option("Selecciona",""));

              // $.each(alumnos, function (index, array) {
              //   $('#combo_cobro').append( new Option(array.nombre + " " + array.apellido + " " + array.identificacion,array.id));
              // });

              // $('#combo_suspension').append( new Option("Selecciona",""));

              // $.each(alumnos, function (index, array) {
              //   $('#combo_suspension').append( new Option(array.nombre + " " + array.apellido + " " + array.identificacion,array.id));
              // });

              // $('#combo_adelanto').append( new Option("Selecciona",""));
              // $.each(alumnos, function (index, array) {
                
              //   $('#combo_adelanto').append( new Option(array.nombre + " " + array.apellido + " " + array.identificacion,array.id));
              // });

              $('.selectpicker').selectpicker('render');
              $('.selectpicker').selectpicker('refresh');

            }

            function errores(merror){
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
            

        </script>
@stop        