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
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>

                                    <br>

    
                                       <label for="nombre" class="f-14">{{$usuario->nombre}} {{$usuario->apellido}} </label>
                                        <!-- <select class="selectpicker bs-select-hidden" id="combo_cumpleaños" name="combo_cumpleaños" multiple="" data-max-options="5" title="Selecciona"> -->

                                    </div>
                                 <div class="has-error" id="error-combo_cumpleaños">
                                      <span >
                                          <small class="help-block error-span" id="error-combo_cumpleaños_mensaje" ></small>                                
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
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>

                                    <br>
                                    <label for="nombre" class="f-14">{{$usuario->nombre}} {{$usuario->apellido}} </label>
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
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <br>
                                    <label for="nombre" class="f-14">{{$usuario->nombre}} {{$usuario->apellido}} </label>
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
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <br>
                                    <label for="nombre" class="f-14">{{$usuario->nombre}} {{$usuario->apellido}} </label>
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
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <br>
                                    <label for="nombre" class="f-14">{{$usuario->nombre}} {{$usuario->apellido}} </label>
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

        <a class="btn-blanco m-r-10 f-16" onclick="procesando()" style="opacity: 0.001"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                            
            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                            
            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                            
            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                           
            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-reservaciones f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
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
                                  <!--<div class="text-center">
                                    <img src="{{url('/')}}/assets/img/detalle_alumnos.jpg" class="img-responsive img-efecto text-center" alt="">
                                  </div>-->
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


                                  <div class="text-center">

                                    <!-- <span data-toggle="modal" id="modalAgregarBtn" href="#modalInformacion" class="f-18 p-t-0 c-azul pointer">Ver más información</span>

                                    <br><br> -->

                                    @if(!$tiene_cuenta && ($tipo == 1 OR $tipo == 2)) 
                                      <i class="zmdi zmdi-alert-circle-o zmdi-hc-fw c-youtube f-20 mousedefault" data-html="true" data-original-title="" data-content="Cuenta sin confirmar" data-toggle="popover" data-placement="top" title="" type="button" data-trigger="hover"></i> <a class="btn-morado m-r-5 f-15 pointer confirmacion"> Enviar confirmación</a>  
                                    @endif

                                  </div> 
                                   
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
                                            <strong class="d-block f-20">AVISO DE COBRO </strong>
                                        </div>
                                    </div>
                                    <div class="tv-body">
                                        <p class="f-14" id="Cobro">Hola, el siguiente comunicado es para informarte que para la fecha del (_/_/_/) deberás realizar el pago de los servicios ofrecidos y así seguir disfrutando de nuestras clases.</p>
                                    
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
                                            <strong class="d-block f-20">ADELANTO DE  NUEVAS APERTURAS     </strong>
                                        </div>
                                    </div>
                                    <div class="tv-body">
                                        <p class="f-14" id="Adelanto">Hola te informamos que el inicio de nivel establecido para la fecha (_/_/_/) lo adelantaremos para la fecha (_/_/_/) debido a que los cupos ofrecidos fueron ocupados rápidamente, por tal motivo la organización toma la iniciativa de empezar su nivel antes del tiempo previsto, esperamos verte en clases.</p>
                                    
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

            // rechargeAlumno();

            // id = "{{{$id or 'Default'}}}";

            // if(id != 'Default')
            // {

            //   $("#combo_cumpleaños").val("{{{$id or 'Default' }}}");
            //   $('#combo_cumpleaños').selectpicker('refresh');
            //   $("#combo_adelanto").val("{{{$id or 'Default' }}}");
            //   $('#combo_adelanto').selectpicker('refresh');
            //   $("#combo_ausencia").val("{{{$id or 'Default' }}}");
            //   $('#combo_ausencia').selectpicker('refresh');
            //   $("#combo_cobro").val("{{{$id or 'Default' }}}");
            //   $('#combo_cobro').selectpicker('refresh');
            //   $("#combo_suspension").val("{{{$id or 'Default' }}}");
            //   $('#combo_suspension').selectpicker('refresh');

            // }

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

                procesando();
                limpiarMensaje();

                // Aqui se enviara el correo y el mensaje
                // $html guardara toda la configuracion html y css que contenga
                // el mensaje para poder ser enviada al correo y que mantenga
                // el estilo
                // var html = $("div.note-editable.panel-body").html();
                var html = $('#html-cumpleaños').summernote('code');
                // var combo = $("#combo").val();
                // var tipo = $("#tipo").val();
                var token = $('input:hidden[name=_token]').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    url: route_cumpleaños,
                    type: 'POST',
                    dataType: 'json',
                    data: datos + "&msj_html="+html + "&id={{$id}}",
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
                      $('#modalBirthday').modal('hide');

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

            $("#EnviarAusencia").on('click', function(){
                
                var datos = $( "#correo_ausencia" ).serialize();

                procesando();
                limpiarMensaje();

                // Aqui se enviara el correo y el mensaje
                // $html guardara toda la configuracion html y css que contenga
                // el mensaje para poder ser enviada al correo y que mantenga
                // el estilo
                // var html = $("div.note-editable.panel-body").html();
                var html = $('#html-ausencia').summernote('code');
                // var combo = $("#combo").val();
                // var tipo = $("#tipo").val();
                var token = $('input:hidden[name=_token]').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    url: route_ausencia,
                    type: 'POST',
                    dataType: 'json',
                    data: datos + "&msj_html="+html + "&id={{$id}}",
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
                      $('#modalAusencia').modal('hide');

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

            $("#EnviarSuspension").on('click', function(){
                var datos = $( "#correo_suspension" ).serialize();

                procesando();
                limpiarMensaje();

                var html = $('#html-suspension').summernote('code');

                // Aqui se enviara el correo y el mensaje
                // $html guardara toda la configuracion html y css que contenga
                // el mensaje para poder ser enviada al correo y que mantenga
                // el estilo
                // var html = $("div.note-editable.panel-body").html();
                console.log(html);
                // var combo = $("#combo").val();
                // var tipo = $("#tipo").val();
                var token = $('input:hidden[name=_token]').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    url: route_suspension,
                    type: 'POST',
                    dataType: 'json',
                    data: datos + "&msj_html="+html + "&id={{$id}}",
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
                      $('#modalSuspension').modal('hide');

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

            $("#EnviarCobro").on('click', function(){
                
                var datos = $( "#correo_cobro" ).serialize();

                procesando();
                limpiarMensaje();

                // Aqui se enviara el correo y el mensaje
                // $html guardara toda la configuracion html y css que contenga
                // el mensaje para poder ser enviada al correo y que mantenga
                // el estilo
                // var html = $("div.note-editable.panel-body").html();
                var html = $('#html-cobro').summernote('code');
                // var combo = $("#combo").val();
                // var tipo = $("#tipo").val();
                var token = $('input:hidden[name=_token]').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    url: route_cobro,
                    type: 'POST',
                    dataType: 'json',
                    data: datos + "&msj_html="+html + "&id={{$id}}",
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
                      $('#modalCobro').modal('hide');

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

            $("#EnviarAdelanto").on('click', function(){
               
               var datos = $( "#correo_adelanto" ).serialize();

                procesando();
                limpiarMensaje();

                // Aqui se enviara el correo y el mensaje
                // $html guardara toda la configuracion html y css que contenga
                // el mensaje para poder ser enviada al correo y que mantenga
                // el estilo
                // var html = $("div.note-editable.panel-body").html();
                var html = $('#html-adelanto').summernote('code');
                // var combo = $("#combo").val();
                // var tipo = $("#tipo").val();
                var token = $('input:hidden[name=_token]').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    url: route_adelanto,
                    type: 'POST',
                    dataType: 'json',
                    data: datos + "&msj_html="+html + "&id={{$id}}",
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
                      $('#modalAdelanto').modal('hide');

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

            });
            

        function errores(merror){
          var campo = ["combo_cobro", "combo_cumpleaños", "combo_suspension", "combo_adelanto", "combo_ausencia"];
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

      }

      function limpiarMensaje(){
        var campo = ["combo_cobro", "combo_cumpleaños", "combo_suspension", "combo_adelanto", "combo_ausencia"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }


      $(".confirmacion").click(function(){
                swal({   
                    title: "Desea enviar el correo de confirmación",   
                    text: "Confirmar envio!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Enviar!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
          if (isConfirm) {

               procesando();

               var route = "{{url('/')}}/activar";
               var token = $('input:hidden[name=_token]').val();
                
                $.ajax({
                    url: route,
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'POST',
                    dataType: 'json',
                    data:"&email={{$usuario->correo}}",
                    success:function(respuesta){

                        swal("Listo!","Correo enviado exitósamente!","success");

                    },
                    error:function(msj){

                          swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');

                        }

                    });
                
                    finprocesado();
                  }
                });
            });
      function eliminar(id){
         
      }

            
        </script>
@stop        