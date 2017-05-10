@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/farbtastic/farbtastic.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/easy_dance_ico_5.css" rel="stylesheet">
<link href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/farbtastic/farbtastic.min.js"></script>
@stop

@section('content')
     
          <div class="modal fade" id="modalTema-Transmision" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Transmisión<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_tema_transmision" id="edit_tema_transmision"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Tema</label>
                                        <input type="text" class="form-control input-sm" name="tema" id="tema" placeholder="50 Caracteres" value="{{$transmision->tema}}">
                                    </div>
                                    <div class="has-error" id="error-tema">
                                      <span >
                                          <small id="error-tema_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$transmision->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_tema_transmision" data-update="tema" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalDesarrollo-Transmision" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Transmisión<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_desarrollo_transmision" id="edit_desarrollo_transmision"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="fg-line">
                                      <textarea class="form-control" id="desarrollo" name="desarrollo" rows="8" placeholder="2000 Caracteres" maxlength="2000" onkeyup="countChar(this)">{{$transmision->desarrollo}}</textarea>
                                    </div>
                                    <div class="opaco-0-8 text-right">Resta <span id="charNum">2000</span> Caracteres</div>
                                    <div class="has-error" id="error-desarrollo">
                                      <span >
                                          <small id="error-desarrollo_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$transmision->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_desarrollo_transmision" data-update="desarrollo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalFecha-Transmision" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Transmisión<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_fecha_transmision" id="edit_fecha_transmision"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                    <label for="fecha">Fecha</label>
                                    <input type="text" class="form-control date-picker input-sm" name="fecha" id="fecha" placeholder="Ej. 00/00/0000" value="{{$transmision->fecha}}">
                                 </div>
                                    <div class="has-error" id="error-fecha">
                                      <span >
                                          <small id="error-fecha_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$transmision->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_fecha_transmision" data-update="fecha" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalHora-Transmision" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Transmisión<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_hora_transmision" id="edit_hora_transmision"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="hora">Hora</label>
                                    <input type="text" class="form-control time-picker input-sm" name="hora" id="hora" placeholder="Ej. 00:00">
                                 </div>
                                 <div class="has-error" id="error-hora">
                                      <span >
                                          <small class="help-block error-span" id="error-hora_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 


                               <input type="hidden" name="id" value="{{$transmision->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_hora_transmision" data-update="hora" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalPresentador-Transmision" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Transmisión<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_presentador_transmision" id="edit_presentador_transmision"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Presentador</label>
                                        <input type="text" class="form-control input-sm" name="presentador" id="presentador" placeholder="50 Caracteres" value="{{$transmision->presentador}}">
                                    </div>
                                    <div class="has-error" id="error-presentador">
                                      <span >
                                          <small id="error-presentador_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$transmision->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_presentador_transmision" data-update="presentador" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalInvitado-Transmision" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Transmisión<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_invitado_transmision" id="edit_invitado_transmision"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Invitado Responsable</label>
                                        <input type="text" class="form-control input-sm" name="invitado" id="invitado" placeholder="50 Caracteres" value="{{$transmision->invitado}}">
                                    </div>
                                    <div class="has-error" id="error-invitado">
                                      <span >
                                          <small id="error-invitado_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$transmision->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_invitado_transmision" data-update="invitado" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

             <div class="modal fade" id="modalEtiqueta-Transmision" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Transmisión<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_etiqueta_transmision" id="edit_etiqueta_transmision"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="cp-container">
                                        <label for="fecha_cobro" id="id-color_etiqueta">Color de etiqueta</label>
                                        <div class="input-group form-group">

                                            <span class="input-group-addon"><i class="zmdi zmdi-invert-colors f-22"></i></span>
                                            <div class="fg-line dropdown">
                                                <input type="text" name="color_etiqueta" id="color_etiqueta" class="form-control cp-value proceso pointer" value="{{$transmision->color_etiqueta}}" data-toggle="dropdown">
                                                    
                                                <div class="dropdown-menu">
                                                    <div class="color-picker" data-cp-default="{{$transmision->color_etiqueta}}"></div>
                                                </div>
                                                
                                                <i class="cp-value"></i>
                                            </div>
                                            <div class="has-error" id="error-color_etiqueta">
                                                <span >
                                                      <small class="help-block error-span" id="error-color_etiqueta_mensaje" ></small>                                           
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                               </div>

                               <div class="clearfix"></div> 

                               <input type="hidden" name="id" value="{{$transmision->id}}"></input>

                               
                               
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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_etiqueta_transmision" data-update="etiqueta" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                      @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                       <!-- <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/agendar/transmisiones" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Transmisión</a> -->
                        <?php $url = "/agendar/transmisiones" ?>
                        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                        
                       <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-reservaciones f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                      @else
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/inicio" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Inicio</a>
                      @endif


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
                                            <span class="ca-icon-planilla"><i class="zmdi zmdi-camera-add"></i></span>
                                            <div class="ca-content-planilla">
                                                <h2 class="ca-main-planilla">Vista Transmisión</h2>
                                                <h3 class="ca-sub-planilla">Personaliza el campo transmisión</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>

                                  @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)

                                  <div class="col-sm-12 text-center"> 

                                    <br></br>

                                    <span class="f-16 f-700">Acciones</span>

                                    <hr></hr>

                                    <i class="zmdi zmdi-delete f-20 m-r-10 boton red sa-warning" id="{{$transmision->id}}" name="eliminar" data-original-title="Eliminar" data-toggle="tooltip" data-placement="bottom" title=""></i>



                                    <br></br>
                                  
                                    <hr></hr>

                                    <br></br>
                                   
                                  </div>

                                  @endif

                                </div>                
                              </div>
                              </div>
                              </div>

					           	<div class="col-sm-9">

                         <div class="col-sm-12">
                              <p class="text-center opaco-0-8 f-22">Datos de la Transmisión</p>
                          </div>

                          <div class="col-sm-12">
                           <table class="table table-striped table-bordered">

                           @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                              <tr class="detalle" data-toggle="modal" href="#modalTema-Transmision">

                            @else

                              <tr class="disabled">

                            @endif
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-tema" class="zmdi {{ empty($transmision->tema) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a icon_a-campana f-22"></i> </span>
                               <span class="f-14"> Tema </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="transmision-tema" class="capitalize" data-valor="{{$transmision->tema}}" >{{ str_limit($transmision->tema, $limit = 30, $end = '...') }}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                              <tr class="detalle" data-toggle="modal" href="#modalDesarrollo-Transmision">

                            @else

                              <tr class="disabled">

                            @endif
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-desarrollo" class="zmdi {{ empty($transmision->desarrollo) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b-cuentales-historia f-22"></i> </span>
                               <span class="f-14"> Descripción </span>
                             </td>
                             <td id="transmision-desarrollo" class="f-14 m-l-15 capitalize" data-valor="{{$transmision->desarrollo}}" >{{ str_limit($transmision->desarrollo, $limit = 30, $end = '...') }} <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                              <tr class="detalle" data-toggle="modal" href="#modalFecha-Transmision">

                            @else

                              <tr class="disabled">

                            @endif
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-fecha" class="zmdi {{ empty($transmision->fecha) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-calendar-check f-22"></i> </span>
                               <span class="f-14"> Fecha </span>
                             </td>
                             <td class="f-14 m-l-15"><span id="transmision-fecha">{{ \Carbon\Carbon::createFromFormat('Y-m-d',$transmision->fecha)->format('d/m/Y')}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
                            </tr>
                            @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                              <tr class="detalle" data-toggle="modal" href="#modalHora-Transmision">

                            @else

                              <tr class="disabled">

                            @endif
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-hora" class="zmdi {{ empty($transmision->hora) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-alarm f-22"></i> </span>
                               <span class="f-14"> Hora </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="transmision-hora">{{$transmision->hora}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                              <tr class="detalle" data-toggle="modal" href="#modalPresentador-Transmision">

                            @else

                              <tr class="disabled">

                            @endif
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-presentador" class="zmdi {{ empty($transmision->presentador) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a icon_a-estudio-salon f-22"></i> </span>
                               <span class="f-14"> Presentador </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="transmision-presentador" data-valor="{{$transmision->presentador}}" >{{ str_limit($transmision->presentador, $limit = 30, $end = '...') }}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                              <tr class="detalle" data-toggle="modal" href="#modalInvitado-Transmision">

                            @else

                              <tr class="disabled">

                            @endif
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-invitado" class="zmdi {{ empty($transmision->invitado) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a icon_a-estudio-salon f-22"></i> </span>
                               <span class="f-14"> Invitado Responsable </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="transmision-invitado" data-valor="{{$transmision->invitado}}" >{{ str_limit($transmision->invitado, $limit = 30, $end = '...') }} <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                              <tr class="detalle" data-toggle="modal" href="#modalEtiqueta-Transmision">

                            @else

                              <tr class="disabled">

                            @endif
                               <td>
                                 <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-color_etiqueta" class="zmdi  {{ empty($transmision->color_etiqueta) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                                 <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-invert-colors f-22"></i> </span>
                                 <span class="f-14"> Color de Etiqueta  </span>
                               </td>
                               <td  class="f-14 m-l-15">
                                <span id="transmision-color_etiqueta">{{$transmision->color_etiqueta}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span>
                               
                                </td>
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
    route_update="{{url('/')}}/agendar/transmisiones/update";
    route_eliminar="{{url('/')}}/agendar/transmisiones/eliminar/";
    route_principal="{{url('/')}}/agendar/transmisiones";

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

    $('#modalFecha-Transmision').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#fecha").val($("#transmision-fecha").text()); 
    })
    $('#modalHora-Fiesta').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#hora").val($("#transmision-hora").text()); 
    })
    $('#modalDesarrollo-Transmision').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var desarrollo=$("#transmision-desarrollo").data('valor');
       $("#desarrollo").val(desarrollo);
    })
    $('#modalPresentador-Transmision').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#presentador").val($("#transmision-presentador").text()); 
    })
    $('#modalInvitado-Transmision').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#invitado").val($("#transmision-invitado").text()); 
    })

    function limpiarMensaje(){
        var campo = ["fecha", "hora", "tema", "desarrollo", "presentador", "invitado", "empresa"];
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
          if(c.name=='desarrollo' || c.name=='invitado' || c.name=='presentador' || c.name=='tema'){
             $("#transmision-"+c.name).data('valor',c.value);
             $("#transmision-"+c.name).html(c.value.substr(0, 30) + "...");
          }else{
            $("#transmision-"+c.name).text(c.value);
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
                finprocesado();
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
                finprocesado();
              }, 1000);             
            }
        })
       
    })

    $("i[name=eliminar]").click(function(){
                id = this.id;
                swal({   
                    title: "Desea eliminar la transmisión",   
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
      function eliminar(id){
         var route = route_eliminar + id;
         procesando();
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

      function countChar(val) {
        var len = val.value.length;
        if (len >= 2000) {
          val.value = val.value.substring(0, 2000);
        } else {
          $('#charNum').text(2000 - len);
        }
      };

   </script> 

   <!--<script src="{{url('/')}}/assets/js/script/alumno-planilla.js"></script>-->        
		
@stop
