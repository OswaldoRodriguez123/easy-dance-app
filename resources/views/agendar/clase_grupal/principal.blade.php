@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/easy_dance_ico_5.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
@stop
@section('content')

  <div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
     <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
        <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Error<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
     </div>
                    
              <div class="modal-body">                           
              <div class="row p-t-20 p-b-0">

              <div class="col-md-2"></div>
              <div class="col-md-8">
                <div align="center"><i class="zmdi zmdi-alert-circle-o zmdi-hc-5x c-youtube"></i></div>
                <div class="c-morado f-40 text-center"> ¡Error! </div>
                <div class="clearfix m-20 m-b-25"></div>
                <div class="text-center f-20">Esta clase grupal no posee valoración</div>
                <div class="text-center f-20">No te preocupes, desde aqui puedes crearla</div>

                <div class="clearfix m-20 m-b-25"></div>
                <div class="clearfix m-20 m-b-25"></div>
                
                <div align="center">
                <button type="submit" class="butp button5" onclick="valoracion()">Llevame</button>
                <button type="submit" class="but2 button55" onclick="atras()"><span>En otro momento</span></button><br><br><br>
                </div>
                

                <div class="clearfix m-20 m-b-25"></div>
                <div class="clearfix m-20 m-b-25"></div>
                <div class="clearfix m-20 m-b-25"></div>
                <div class="clearfix m-20 m-b-25"></div>

              </div>
              <div class="col-md-2"></div>


      
              </div>
              </div>
              </div>
      </div>
  </div>


  <div class="modal fade" id="modalTrasladar-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                  <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
              </div>
              <form name="form_trasladar" id="form_trasladar"  >
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">
                 <div class="modal-body">                           
                 <div class="row p-t-20 p-b-0">
                     <div class="col-sm-12">
                       <div class="form-group fg-line">
                          <label for="nombre">Clases Grupales</label>

                            <div class="select">
                                <select class="form-control" id="clase_grupal_id" name="clase_grupal_id">
                                @foreach ($clase_grupal_join as $clase_grupal )
                                  <option value = "{{ $clase_grupal['id'] }}">{{ $clase_grupal['clase_grupal_nombre'] }} - {{ $clase_grupal['hora_inicio'] }} / {{ $clase_grupal['hora_final'] }} - {{ $clase_grupal['dia_de_semana'] }} - {{ $clase_grupal['instructor_nombre'] }} {{ $clase_grupal['instructor_apellido'] }} - {{ $clase_grupal['especialidad_nombre'] }}</option>
                                @endforeach 
                                </select>
                            </div> 

                       </div>
                       <div class="has-error" id="error-clase_grupal_id">
                            <span >
                                <small class="help-block error-span" id="error-clase_grupal_id_mensaje" ></small>                                
                            </span>
                        </div>
                     </div>


                     <input type="hidden" name="id"></input>
                  

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

                    <a class="btn-blanco m-r-5 f-12 trasladar" href="#"> Trasladar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                  </div>
              </div></form>
          </div>
      </div>
  </div>

  <div class="modal fade" id="modalCancelar" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <!--<h4 class="modal-title">Agendar</h4>-->
                                    <i class="icon_a-agendar f-35" ></i>
                                    <button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body m-b-20">
                                    <p class="text-center p-t-0 f-700 opaco-0-8 f-25">Hey {{Auth::user()->nombre}}.</p> 
                                    <p class="text-center p-b-20 f-700 opaco-0-8 f-22">¿Listo para bloquear una clase?...</p>
                                    <form id="frm_agendar" name="frm_agendar" class="addEvent" role="form" method="POST" action="agendar">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="col-sm-4">
                                      <ul class="ca-menu" style="margin: 0 auto;">
                                        <li style="height: 250px;">
                                            <a href="#modalCancelarUna" data-toggle="modal" class="agendar" data-agendar="clases-grupales">
                                                <span class="ca-icon" style="line-height: 60px, top: 35%;"><i class="icon_f-1-una-clase"></i></span>
                                                <div class="ca-content" style="top: 35%;">
                                                    <h2 class="ca-main f-20">Bloquear una clase</h2>
                                                    <h3 class="ca-sub" style="line-height: 20px;">Bloquear!</h3>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    </div>
                                    <div class="col-sm-4">
                                      <ul class="ca-menu" style="margin: 0 auto;">
                                        <li style="height: 250px;">
                                            <a href="#modalCancelarVarias" data-toggle="modal" class="agendar" data-agendar="clases-personalizadas">
                                                <span class="ca-icon" style="line-height: 60px, top: 35%;"><i class="icon_f-varias-clases"></i></span>
                                                <div class="ca-content" style="top: 35%;">
                                                    <h2 class="ca-main f-20">Bloquear varias Clases</h2>
                                                    <h3 class="ca-sub" style="line-height: 20px;">Bloquear!</h3>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    </div>
                                    <div class="col-sm-4">
                                      <ul class="ca-menu" style="margin: 0 auto;">
                                        <li style="height: 250px;">
                                            <a href="#modalCancelarPermanente" data-toggle="modal" class="agendar" data-agendar="talleres" >
                                                <span class="ca-icon" style="line-height: 60px, top: 35%;"><i class="icon_f-eliminar-todas"></i></span>
                                                <div class="ca-content" style="top: 35%;">
                                                    <h2 class="ca-main f-20">Bloquear clases permanentemente</h2>
                                                    <h3 class="ca-sub" style="line-height: 20px;">Bloquear!</h3>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    </div>

                                    <div class="clearfix p-b-10"></div>

                                        
                                        <input type="hidden" id="getStart" name="getStart" />
                                        <input type="hidden" id="getEnd" name="getEnd" />
                                        <input type="hidden" id="agendar" name="agendar" />
                                    </form>
                                </div>
                                
                                <div class="modal-footer">
                                    <!--<button type="submit" class="btn btn-link" id="addEvent">Add Event</button>
                                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>-->
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="modalCancelarUna" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                                        <h4 class="modal-title c-negro"> Bloquear una clase <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                                    </div>
                                    <form name="cancelar_una_clase" id="cancelar_una_clase"  >
                                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                       <input class="id" type="hidden" name="id" id="id"></input>  
                                       
                                       <div class="modal-body">  

                                       <div class="row p-t-20 p-b-0">

                                           <div class="col-sm-3">
  
                                                <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                                <div class="clearfix p-b-15"></div>
    
                                                <span class="f-15 f-700 span_instructor"></span>

                                                  
                                           </div>

                                           <div class="col-sm-3">
  
                                                <span class="f-15 f-700 span_clase_grupal"></span>

                                                  
                                           </div>

                                           <div class="col-sm-6">
                                             
                                            <p class="f-16">Horario: <span class="f-700 span_hora"></span></p>

                                            <p class="f-16"> <span class="f-700" style="float:left; padding-top: 0.5%">Fecha: 

                                            <div class="dtp-container">
                                              <input name="fecha_cancelacion" id="fecha_cancelacion" class="form-control date-picker proceso pointer" placeholder="Seleciona" type="text" style="padding-top: 0; width: 85%">
                                            </div>


                                            </span></p>


                                               <div class="clearfix"></div> 
                                               <div class="clearfix p-b-15"></div>


                                           </div>

                                           
                                       </div>                         

                                       <div class="row p-t-20 p-b-0">

                     

                               <div class="clearfix p-b-35"></div>


            

                                      <div class="col-sm-12">
                                 
                                        <label for="razon_cancelacion" id="id-razon_cancelacion">Razones del bloqueo</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica las razones por el cual estás cancelando o bloqueando la clase" title="" data-original-title="Ayuda"></i>
                                        <br></br>

                                        <div class="fg-line">
                                          <textarea class="form-control" id="razon_cancelacion" name="razon_cancelacion" rows="2" placeholder="Ej. No podré  asistir por razones ajenas a mi voluntad"></textarea>
                                          </div>
                                        <div class="has-error" id="error-razon_cancelacion">
                                          <span >
                                            <small class="help-block error-span" id="error-razon_cancelacion_mensaje" ></small>                                           
                                          </span>
                                        </div>
                                      </div>

                                      <div class="col-sm-12">
                                       <div class="form-group fg-line ">
                                          <label for="">Mostrar bloqueo en la web</label id="id-boolean_mostrar"> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona si los clientes e instructores podrán ver el bloqueo de la clase en el calendario de actividades" title="" data-original-title="Ayuda"></i>
                                          
                                          <br></br>
                                          <input type="text" class="boolean_mostrar" id="boolean_mostrar" name="boolean_mostrar" value="" hidden="hidden">
                                          <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input class ="mostrar" id="mostrar" type="checkbox">
                                            
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                          </div>
                                          
                                       </div>
                                       <div class="has-error" id="error-boolean_mostrar">
                                            <span >
                                                <small class="help-block error-span" id="error-boolean_mostrar_mensaje" ></small>                                           
                                            </span>
                                        </div>
                                     </div>

                                       </div>
                                       
                                    </div>
                                    <div class="modal-footer p-b-20 m-b-20">
                                        <div class="col-sm-6 text-left">
                                          <div class="procesando hidden">
                                          <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                                          <div class="preloader pls-purple">
                                              <svg class="pl-circular" viewBox="25 25 50 50">
                                                  <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                              </svg>
                                          </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-6">                          
                                          <button type="button" class="btn-blanco btn m-r-10 f-16 cancelar_una_clase" > Completar el bloqueo</button>
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Volver</button>
                                        </div>
                                    </div></form>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="modalCancelarVarias" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                                        <h4 class="modal-title c-negro"> Bloquear varias clases <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                                    </div>
                                    <form name="cancelar_varias_clases" id="cancelar_varias_clases"  >
                                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                       <input class="id" type="hidden" name="id" id="id"></input>  
                                       
                                       <div class="modal-body">  

                                       <div class="row p-t-20 p-b-0">

                                           <div class="col-sm-3">
  
                                                <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                                <div class="clearfix p-b-15"></div>
    
                                                <span class="f-15 f-700 span_instructor"></span>

                                                  
                                           </div>

                                           <div class="col-sm-3">
  
                                                <span class="f-15 f-700 span_clase_grupal"></span>

                                                  
                                           </div>

                                           <div class="col-sm-6">
                                             
                                            <p class="f-16">Horario: <span class="f-700 span_hora"></span></p>



                                               <div class="clearfix"></div> 
                                               <div class="clearfix p-b-15"></div>


                                           </div>

                                           
                                       </div>                       

                                       <div class="row p-t-20 p-b-0">

                     

                               <div class="clearfix p-b-35"></div>


            

                                      <div class="col-sm-12">
                                 
                                        <label for="razon_cancelacion" id="id-razon_cancelacion">Razones del bloqueo</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica las razones por el cual estás cancelando o bloqueando la clase" title="" data-original-title="Ayuda"></i>
                                        <br></br>

                                        <div class="fg-line">
                                          <textarea class="form-control" id="razon_cancelacion" name="razon_cancelacion" rows="2" placeholder="Ej. No podré  asistir por razones ajenas a mi voluntad"></textarea>
                                          </div>
                                        <div class="has-error" id="error-razon_cancelacion">
                                          <span >
                                            <small class="help-block error-span" id="error-razon_cancelacion_mensaje" ></small>                                           
                                          </span>
                                        </div>
                                      </div>

                                      <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-group fg-line">
                                            <label for="fecha_inicio">Fecha</label>
                                            <div class="fg-line">
                                                <input type="text" id="fecha2" name="fecha2" class="form-control pointer" placeholder="Selecciona la fecha">
                                            </div>
                                         </div>
                                            <div class="has-error" id="error-fecha2">
                                              <span >
                                                  <small id="error-fecha2_mensaje" class="help-block error-span" ></small>                                           
                                              </span>
                                            </div>
                                        </div>
                                       </div>

                                      <div class="col-sm-12">
                                       <div class="form-group fg-line ">
                                          <label for="">Mostrar bloqueo en la web</label id="id-boolean_mostrar"> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona si los clientes e instructores podrán ver el bloqueo de la clase en el calendario de actividades" title="" data-original-title="Ayuda"></i>
                                          
                                          <br></br>
                                          <input type="text" class="boolean_mostrar" id="boolean_mostrar" name="boolean_mostrar" value="" hidden="hidden">
                                          <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input class ="mostrar" id="mostrar" type="checkbox">
                                            
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                          </div>
                                          
                                       </div>
                                       <div class="has-error" id="error-boolean_mostrar">
                                            <span >
                                                <small class="help-block error-span" id="error-boolean_mostrar_mensaje" ></small>                                           
                                            </span>
                                        </div>
                                     </div>

                                       </div>
                                       
                                    </div>
                                    <div class="modal-footer p-b-20 m-b-20">
                                        <div class="col-sm-6 text-left">
                                          <div class="procesando hidden">
                                          <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                                          <div class="preloader pls-purple">
                                              <svg class="pl-circular" viewBox="25 25 50 50">
                                                  <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                              </svg>
                                          </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-6">                          
                                          <button type="button" class="btn-blanco btn m-r-10 f-16 cancelar_varias_clases" > Completar el bloqueo</button>
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Volver</button>
                                        </div>
                                    </div></form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalCancelarPermanente" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                                        <h4 class="modal-title c-negro"> Bloquear la clase permanentemente <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                                    </div>
                                    <form name="cancelar_permanentemente" id="cancelar_permanentemente"  >
                                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                       <input class="id" type="hidden" name="id" id="id"></input>  
                                       
                                       <div class="modal-body">  

                                       <div class="row p-t-20 p-b-0">

                                           <div class="col-sm-3">
  
                                                <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                                <div class="clearfix p-b-15"></div>
    
                                                <span class="f-15 f-700 span_instructor"></span>

                                                  
                                           </div>

                                           <div class="col-sm-3">
  
                                                <span class="f-15 f-700 span_clase_grupal"></span>

                                                  
                                           </div>

                                           <div class="col-sm-6">
                                             
                                            <p class="f-16">Horario: <span class="f-700 span_hora"></span></p>

                                            <p class="f-16"> <span class="f-700" style="float:left; padding-top: 0.5%">Fecha: 

                                            <div class="dtp-container">
                                              <input name="fecha_cancelacion" id="fecha_cancelacion" class="form-control date-picker proceso pointer" placeholder="Seleciona" type="text" style="padding-top: 0; width: 85%">
                                            </div>


                                            </span></p>


                                               <div class="clearfix"></div> 
                                               <div class="clearfix p-b-15"></div>


                                           </div>

                                           
                                       </div>                          

                                       <div class="row p-t-20 p-b-0">

                     

                               <div class="clearfix p-b-35"></div>


            

                                      <div class="col-sm-12">
                                 
                                        <label for="razon_cancelacion" id="id-razon_cancelacion">Razones del bloqueo</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica las razones por el cual estás cancelando o bloqueando la clase" title="" data-original-title="Ayuda"></i>
                                        <br></br>

                                        <div class="fg-line">
                                          <textarea class="form-control" id="razon_cancelacion" name="razon_cancelacion" rows="2" placeholder="Ej. No podré  asistir por razones ajenas a mi voluntad"></textarea>
                                          </div>
                                        <div class="has-error" id="error-razon_cancelacion">
                                          <span >
                                            <small class="help-block error-span" id="error-razon_cancelacion_mensaje" ></small>                                           
                                          </span>
                                        </div>
                                      </div>

                                      <div class="col-sm-12">
                                       <div class="form-group fg-line ">
                                          <label for="">Mostrar bloqueo en la web</label id="id-boolean_mostrar"> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona si los clientes e instructores podrán ver el bloqueo de la clase en el calendario de actividades" title="" data-original-title="Ayuda"></i>
                                          
                                          <br></br>
                                          <input type="text" class="boolean_mostrar" id="boolean_mostrar" name="boolean_mostrar" value="" hidden="hidden">
                                          <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input class ="mostrar" id="mostrar" type="checkbox">
                                            
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                          </div>
                                          
                                       </div>
                                       <div class="has-error" id="error-boolean_mostrar">
                                            <span >
                                                <small class="help-block error-span" id="error-boolean_mostrar_mensaje" ></small>                                           
                                            </span>
                                        </div>
                                     </div>

                                       </div>
                                       
                                    </div>
                                    <div class="modal-footer p-b-20 m-b-20">
                                        <div class="col-sm-6 text-left">
                                          <div class="procesando hidden">
                                          <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                                          <div class="preloader pls-purple">
                                              <svg class="pl-circular" viewBox="25 25 50 50">
                                                  <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                              </svg>
                                          </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-6">                          
                                          <button type="button" class="btn-blanco btn m-r-10 f-16 cancelar_permanentemente" > Completar el bloqueo</button>
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Volver</button>
                                        </div>
                                    </div></form>
                                </div>
                            </div>
                        </div>




            <a href="{{url('/')}}/agendar/clases-grupales/agregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menú Principal</a>
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

                            <div class="col-sm-6">
                                <i class="zmdi zmdi-label-alt f-25 c-verde"></i> Activos: <span id="activos">0</span>
                                <div class="clearfix"></div>
                                <a href="{{url('/')}}/agendar/clases-grupales/riesgo-ausencia"><i class="zmdi zmdi-label-alt f-25 c-amarillo"></i> Riesgo de Ausencia: <span id="riesgo">0</span></a>
                                <div class="clearfix m-b-20"></div>
                                <span class="f-15">Total: <span id="total">0</span></span>
                            </div>

                            <div class="col-sm-6 text-right">
                                <span class="f-16 p-t-0 text-success">Agregar una Clase Grupal <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span> 
                            </div>

                            <div class="clearfix"></div>

                            <div class="text-center">
                                <p class="opaco-0-8 f-22"><i class="icon_a-clases-grupales f-25"></i> Sección de Clases Grupales</p>

                                <hr class="linea-morada"> 

                                <div class="col-sm-12">
                                    <div class="p-t-10 pull-right">
                                        <label class="radio radio-inline m-r-20">
                                            <input name="tipo" id="activas" value="1" type="radio" checked>
                                            <i class="input-helper"></i>  
                                            Activas <i id="activas2" name="activas2" class="zmdi zmdi-label-alt-outline zmdi-hc-fw c-verde f-20"></i>
                                        </label>
                                        <label class="radio radio-inline m-r-20">
                                            <input name="tipo" id="finalizadas" value="2" type="radio">
                                            <i class="input-helper"></i>  
                                            Finalizadas <i id="finalizadas2" name="finalizadas2" class="zmdi zmdi-check zmdi-hc-fw f-20"></i>
                                        </label>
                                    </div>
                                </div>

                                <button class="btn btn-blanco button_izquierda" style="border:none; box-shadow: none"><i class="zmdi zmdi-chevron-left zmdi-hc-fw f-20"></i></button> <span class="span_dia f-20 c-morado">LUNES</span> <button class="btn btn-blanco button_derecha" style="border:none; box-shadow: none"><i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i></button>

                                <div class="clearfix"></div>

                                <button class="no_border_button btn btn-blanco button_dia" value="1">Lun</button> &nbsp; 
                                <button class="btn btn-blanco button_dia no_border_button" value="2">Mar</button> &nbsp; 
                                <button class="btn btn-blanco button_dia no_border_button" value="3">Mier</button> &nbsp; 
                                <button class="btn btn-blanco button_dia no_border_button" value="4">Juev</button> &nbsp; 
                                <button class="btn btn-blanco button_dia no_border_button" value="5">Vier</button> &nbsp; 
                                <button class="btn btn-blanco button_dia no_border_button" value="6">Sab</button> &nbsp; 
                                <button class="btn btn-blanco button_dia no_border_button" value="7">Dom</button>

                            </div>                                                   
                        </div>

                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="inicio" data-order="desc"></th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                    <th class="text-center" data-column-id="instructor" data-order="desc">Instructor</th>
                                    <th class="text-center" data-column-id="especialidad" data-order="desc">Especialidad</th>
                                    <th class="text-center" data-column-id="hora" data-order="desc">Hora [Inicio - Final]</th>
                                    <th class="text-center operacion" data-column-id="operacion" data-order="desc">Operaciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                              @foreach($clase_grupal_join as $clase_grupal)

                                <?php 
                                  $id = $clase_grupal['id'];

                                  $contenido = 'Salon: ' . $clase_grupal['salon'] . '<br>' . 'Cantidad de Participantes: ' . $clase_grupal['cantidad_participantes'] . '<br>' . 'Nivel: ' . $clase_grupal['nivel'] . '<br>';
                                ?>

                                <tr data-trigger="hover" data-toggle="popover" data-placement="top" data-original-title="Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html="true" data-container="body" title="" data-content="{{$contenido}}" id="{{$id}}" data-imagen="{{$clase_grupal['imagen']}}" data-sexo="{{$clase_grupal['sexo']}}" class="seleccion">
                                  <td>
                                    <span style="display: none">{{$clase_grupal['dia_de_semana']}}</span>
                                    @if($clase_grupal['inicio'] == 1)
                                      <i class="zmdi zmdi-star zmdi-hc-fw zmdi-hc-fw c-amarillo f-20" data-html="true" data-original-title="" data-content="Esta clase grupal no ha comenzado" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>
                                    @endif
                                  </td>
                                  <td>
                                    {{$clase_grupal['clase_grupal_nombre']}}
                                  </td>
                                  <td>
                                    {{$clase_grupal['instructor_nombre']}} {{$clase_grupal['instructor_apellido']}}
                                  </td>
                                  <td>
                                    {{$clase_grupal['especialidad_nombre']}} 
                                  </td>
                                  <td>
                                    {{$clase_grupal['hora_inicio']}} - {{$clase_grupal['hora_final']}}
                                  </td>
                                  <td>
                                    <span style="display: none">{{$clase_grupal['estatus']}}</span>
                                    <ul class="top-menu">
                                      <li id = "dropdown_{{$id}}" class="dropdown">
                                        <a id = "dropdown_toggle_{{$id}}" href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft">
                                          <span class="f-15 f-700" style="color:black">
                                            <i class="zmdi zmdi-wrench f-20 mousedefault" data-toggle="popover" data-placement="top" title="" type="button" data-original-title="" data-content=""></i>
                                          </span>
                                        </a>
                                        <div class="dropup">
                                          <ul class="dropdown-menu dm-icon pull-right" style="position:absolute;">
                                            <li class="hidden-xs">
                                              <a onclick="procesando()" href="{{url('/')}}/agendar/clases-grupales/nivelaciones/{{$id}}">
                                                <i class="icon_a-niveles f-16 m-r-10 boton blue"></i>
                                                &nbsp;Nivelaciones
                                              </a>
                                            </li>
                                            <li class="hidden-xs">
                                              <a onclick="procesando()" href="{{url('/')}}/agendar/clases-grupales/participantes/{{$id}}">
                                                <i class="icon_a-participantes f-16 m-r-10 boton blue"></i>
                                                Participantes
                                              </a>
                                            </li>
                                            <li class="hidden-xs">
                                              <a class="valorar">
                                                <i class="icon_a-examen f-16 m-r-10 boton blue"></i>
                                                Valorar
                                              </a>
                                            </li>
                                            <li class="hidden-xs">
                                              <a onclick="procesando()" href="{{url('/')}}/agendar/clases-grupales/agenda/{{$id}}">
                                                <i class="zmdi zmdi-eye f-16 boton blue"></i>
                                                Ver Agenda
                                              </a>
                                            </li>
                                              <li class="hidden-xs"> <a onclick="procesando()" href="{{url('/')}}/agendar/clases-grupales/multihorario/{{$id}}">
                                                <i class="zmdi zmdi-calendar-note f-16 boton blue"></i>
                                                Multihorario
                                              </a>
                                            </li>
                                            <li class="hidden-xs"> 
                                              <a onclick="procesando()" href="{{url('/')}}/agendar/clases-grupales/progreso/{{$id}}">
                                                <i class="icon_e-ver-progreso f-16 m-r-10 boton blue"></i>
                                                Ver Progreso
                                              </a>
                                            </li>
                                            <li class="hidden-xs cancelar">
                                              <a>
                                                <i class="zmdi zmdi-close-circle-o f-20 boton red sa-warning"></i>
                                                Cancelar Clase
                                              </a>
                                            </li>
                                            <li class="hidden-xs eliminar">
                                              <a class="pointer eliminar">
                                                <i class="zmdi zmdi-delete boton red f-20 boton red sa-warning"></i>
                                                Eliminar Clase
                                              </a>
                                            </li>
                                          </ul>
                                        </div>
                                      </li>
                                    </ul>
                                  </td>
                                </tr>
                              @endforeach

                                                           
                            </tbody>
                        </table>
                         </div>
                        </div>                    
                        <div class="card-body p-b-20">
                            <div class="row">
                              <div class="container">
                                
                              </div>
                            </div>
                        </div>
                        
                        
                    </div>
                    
                    
                </div>
            </section>
@stop

@section('js') 
            
    <script type="text/javascript">

        route_detalle="{{url('/')}}/agendar/clases-grupales/detalle";
        route_operacion="{{url('/')}}/agendar/clases-grupales/operaciones";
        route_progreso="{{url('/')}}/agendar/clases-grupales/progreso";
        route_participantes="{{url('/')}}/agendar/clases-grupales/participantes";
        route_principal="{{url('/')}}/agendar/clases-grupales";
        route_eliminar="{{url('/')}}/agendar/clases-grupales/eliminar/";
        route_consulta="{{url('/')}}/agendar/clases-grupales/consulta-estatus-alumnos";
        route_cancelar="{{url('/')}}/agendar/clases-grupales/cancelar";
        route_consulta_examen="{{url('/')}}/agendar/clases-grupales/consulta_examen/";
        route_valorar="{{url('/')}}/especiales/examenes/evaluar/";
        route_examen="{{url('/')}}/especiales/examenes/agregar/";

        var clases_grupales = <?php echo json_encode($clase_grupal_join);?>;

        var dia;
        var estatus = 1
        var hoy;
        var pagina = document.location.origin
        var clase_grupal_id

        $(document).ready(function(){

            $(".boolean_mostrar").val('1');  //VALOR POR DEFECTO
            $(".mostrar").attr("checked", true); //VALOR POR DEFECTO

            $(".mostrar").on('change', function(){
              if ($(this).is(":checked")){
                $(".boolean_mostrar").val('1');
              }else{
                $(".boolean_mostrar").val('0');
              }    
            });

            $('#fecha2').daterangepicker({
              "autoApply" : false,
              "opens": "left",
              "applyClass": "bgm-morado waves-effect",
              locale : {
                  format: 'DD/MM/YYYY',
                  applyLabel : 'Aplicar',
                  cancelLabel : 'Cancelar',
                  daysOfWeek : [
                      "Dom",
                      "Lun",
                      "Mar",
                      "Mie",
                      "Jue",
                      "Vie",
                      "Sab"
                  ],
                  monthNames: [
                      "Enero",
                      "Febrero",
                      "Marzo",
                      "Abril",
                      "Mayo",
                      "Junio",
                      "Julio",
                      "Agosto",
                      "Septiembre",
                      "Octubre",
                      "Noviembre",
                      "Diciembre"
                  ],        
              }
          });

            dia = parseInt("{{$hoy}}");
            hoy = dia;
            
            $(".button_izquierda").removeAttr("disabled");
            $(".button_derecha").removeAttr("disabled");


            if(dia == 1){
                $(".button_izquierda").attr("disabled","disabled");
            }

            if(dia == 7){
                $(".button_derecha").attr("disabled","disabled");
            }

            t=$('#tablelistar').DataTable({
                processing: true,
                serverSide: false,
                pageLength: 25,   
                paginate: false,   
                bInfo: false,  
                order: [[4, 'asc']],
                fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                  $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)', nRow).addClass( "text-center" );
                  $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).attr( "onclick","previa(this)" );
                },
                language: {
                                processing:     "Procesando ...",
                                search:         '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>',
                                searchPlaceholder: "BUSCAR",
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

            changeSpan();

            setTimeout(function(){ 
                consulta_estatus_alumnos();
            }, 1000); 

        });

        $(".button_izquierda").click(function(){

            $(".button_derecha").removeAttr("disabled");

            dia = dia - 1;

            if( dia <= 1){
                $(".button_izquierda").attr("disabled","disabled");
            }else{
                $(".button_izquierda").removeAttr("disabled");
            }
            changeSpan();
        });

        $(".button_derecha").click(function(){

            $(".button_izquierda").removeAttr("disabled");

            dia = dia + 1;

            if( dia >= 7){
                $(".button_derecha").attr("disabled","disabled");
            }else{
                $(".button_derecha").removeAttr("disabled");
            }
            changeSpan();
        });

        $('.button_dia').click(function(){
            dia = parseInt($(this).val());

            if( dia >= 7){
                $(".button_derecha").attr("disabled","disabled");
            }else{
                $(".button_derecha").removeAttr("disabled");
            }

            if( dia <= 1){
                $(".button_izquierda").attr("disabled","disabled");
            }else{
                $(".button_izquierda").removeAttr("disabled");
            }

            changeSpan();

         });

        function changeSpan(){

            if(dia == hoy){
                $('.span_dia').text('HOY');
            }
            
            else if(dia == 1){

                $('.span_dia').text('LUNES');

            }else if(dia == 2){

                $('.span_dia').text('MARTES');

            }else if(dia == 3){

                $('.span_dia').text('MIERCOLES');

            }else if(dia == 4){

                $('.span_dia').text('JUEVES');

            }else if(dia == 5){

                $('.span_dia').text('VIERNES');

            }else if(dia == 6){

                $('.span_dia').text('SABADO');

            }else if(dia == 7){

                $('.span_dia').text('DOMINGO');

            }

            $(".button_dia").removeAttr("style")

            $(".button_dia[value='"+dia+"']").css("background-color", "#2196F3");
            $(".button_dia[value='"+dia+"']").css("color", "white");

            t
            .columns(0,5)
            .search(dia,estatus)
            .draw();

        }

    function previa(t){
        var row = $(t).closest('tr').attr('id');

        id_alumno = "{{Session::get('id_alumno')}}";
        if(!id_alumno){
            var route =route_detalle+"/"+row;
        }
        else{
            var route =route_participantes+"/"+row;
        }
        
        window.open(route, '_blank');
      }

    $(".trasladar").click(function(){
      id = this.id;
      swal({   
          title: "Desea trasladar todos los alumnos inscritos a la clase grupal seleccionada?",   
          text: "Tenga en cuenta que la otra clase grupal sera eliminada",   
          type: "warning",   
          showCancelButton: true,   
          confirmButtonColor: "#DD6B55",   
          confirmButtonText: "Trasladar!",  
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
                      
            trasladar();
            }
        });
    });

    function trasladar(){
      var route = route_trasladar;
      var token = $('input:hidden[name=_token]').val();
      var datos = $( "#form_trasladar" ).serialize();

      procesando();
              
      $.ajax({
          url: route,
              headers: {'X-CSRF-TOKEN': token},
              type: 'POST',
          dataType: 'json',
          data:datos,
          success:function(respuesta){

              window.location = route_principal; 

          },
          error:function (msj, ajaxOptions, thrownError){
            setTimeout(function(){ 
              if (typeof msj.responseJSON === "undefined") {
                window.location = "{{url('/')}}/error";
              }
              var nType = 'danger';
              if(msj.responseJSON.status=="ERROR"){
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
      });
    }

  $('#tablelistar tbody').on( 'click', '.cancelar', function () {

    var row = $(this).closest('tr')
    var id = $(row).attr('id');
    var nombre = $(row).find('td:eq(1)').text();
    var instructor = $(row).find('td:eq(2)').text();
    var hora = $(row).find('td:eq(4)').text();
    var imagen = $(row).data('imagen');
    var sexo = $(row).data('sexo');

    $('.id').val(id);
    $('.span_clase_grupal').text(nombre)
    $('.span_hora').text(hora)
    $('.span_instructor').text(instructor)

    if(imagen){

        $('#imagen').attr('src', "{{url('/')}}/assets/uploads/instructor/"+imagen)

    }else{
        if(sexo == 'F'){
            $('#imagen').attr('src', "{{url('/')}}/assets/img/Mujer.jpg")
        }else{
            $('#imagen').attr('src', "{{url('/')}}/assets/img/Hombre.jpg")
        }
    }

    $('#modalCancelar').modal('show')

  });

  $(".cancelar_una_clase").click(function(){


        fecha_inicio = $('#fecha_cancelacion').val();

        swal({   
                    title: "Desea bloquear la clase el dia "+fecha_inicio,   
                    text: "Confirmar bloqueo!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Confirmar bloqueo!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
          if (isConfirm) {
          procesando();
          var route = route_cancelar;
          var token = '{{ csrf_token() }}';
          var datos = $( "#cancelar_una_clase" ).serialize(); 
          $.ajax({
            url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
            dataType: 'json',
            data:datos+"&tipo=1",
            success:function(respuesta){
               setTimeout(function(){ 

                var nFrom = $(this).attr('data-from');
                var nAlign = $(this).attr('data-align');
                var nIcons = $(this).attr('data-icon');
                var nAnimIn = "animated flipInY";
                var nAnimOut = "animated flipOutY"; 
                var nType = 'success';
                var nTitle="Ups! ";
                var nMensaje="¡Excelente! El registro se ha guardado satisfactoriamente";

                $('.modal').modal('hide');

                finprocesado();

                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
              }, 1000);

            },
            error:function(msj){

            setTimeout(function(){ 
              if (typeof msj.responseJSON === "undefined") {
                window.location = "{{url('/')}}/error";
              }
              var nType = 'danger';
              if(msj.responseJSON.status=="ERROR"){
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
               });
              }
            });
          });

      $(".cancelar_varias_clases").click(function(){
    
         swal({   
                    title: "Desea bloquear la clase desde el " + $('#fecha2').val(),   
                    text: "Confirmar bloqueo!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Confirmar bloqueo!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
          if (isConfirm) {
          procesando();
         var route = route_cancelar;
         var token = '{{ csrf_token() }}';
         var datos = $( "#cancelar_varias_clases" ).serialize(); 
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    data:datos+"&tipo=2",
                    success:function(respuesta){
                     setTimeout(function(){ 

                      var nFrom = $(this).attr('data-from');
                      var nAlign = $(this).attr('data-align');
                      var nIcons = $(this).attr('data-icon');
                      var nAnimIn = "animated flipInY";
                      var nAnimOut = "animated flipOutY"; 
                      var nType = 'success';
                      var nTitle="Ups! ";
                      var nMensaje="¡Excelente! El registro se ha guardado satisfactoriamente";

                      $('.modal').modal('hide');

                      finprocesado();

                      notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                    }, 1000);

                  },
                  error:function(msj){

                    setTimeout(function(){ 
                    if (typeof msj.responseJSON === "undefined") {
                      window.location = "{{url('/')}}/error";
                    }
                    var nType = 'danger';
                    if(msj.responseJSON.status=="ERROR"){
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
         });
        }
      });
    });

      $(".cancelar_permanentemente").click(function(){
    
         swal({   
                    title: "Desea bloquear la clase permanentemente",   
                    text: "Confirmar bloqueo!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Confirmar bloqueo!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
          if (isConfirm) {
          procesando();
         var route = route_cancelar;
         var token = '{{ csrf_token() }}';
         var datos = $( "#cancelar_varias_clases" ).serialize(); 
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    data:datos+"&tipo=3",
                    success:function(respuesta){

                      window.location = route_principal;

                    },
                    error:function(msj){

                    setTimeout(function(){ 
                    if (typeof msj.responseJSON === "undefined") {
                      window.location = "{{url('/')}}/error";
                    }
                    var nType = 'danger';
                    if(msj.responseJSON.status=="ERROR"){
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
         });
        }
      });
    });

  $('#tablelistar tbody').on( 'click', 'a.modal_trasladar', function () {
    var id = $(this).closest('tr').attr('id');
    $('input[name=id]').val(id)
    $('#modalTrasladar-ClaseGrupal').modal('show')
  });

  $('#tablelistar tbody').on( 'click', 'a.eliminar', function () {
        var id = $(this).closest('tr').attr('id');
                swal({   
                    title: "Desea eliminar la clase grupal",   
                    text: "Tenga en cuenta que los horarios creados para esta clase grupal tambien seran eliminados!",   
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
                        // swal("Done!","It was succesfully deleted!","success");
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
                        eliminar(id);
          }
                });
            });
      function eliminar(id){
         var route = route_eliminar + id;
         var token = $('input:hidden[name=_token]').val();
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
                                // $("#msj-danger").fadeIn(); 
                                // var text="";
                                // console.log(msj);
                                // var merror=msj.responseJSON;
                                // text += " <i class='glyphicon glyphicon-remove'></i> Por favor verifique los datos introducidos<br>";
                                // $("#msj-error").html(text);
                                // setTimeout(function(){
                                //          $("#msj-danger").fadeOut();
                                //         }, 3000);
                                swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                                }
                });
      }

    function consulta_estatus_alumnos(){
      var route = route_consulta;
      var token = "{{ csrf_token() }}";

      $.ajax({
          url: route,
              headers: {'X-CSRF-TOKEN': token},
              type: 'POST',
          dataType: 'json',
          success:function(respuesta){

              $('#activos').text(respuesta.activos)
              $('#riesgo').text(respuesta.riesgo)
              $('#total').text(parseInt(respuesta.activos + respuesta.riesgo))

          },
          error:function (msj, ajaxOptions, thrownError){
            setTimeout(function(){ 
              // if (typeof msj.responseJSON === "undefined") {
              //   window.location = "{{url('/')}}/error";
              // }
              var nType = 'danger';
              if(msj.responseJSON.status=="ERROR"){
                errores(msj.responseJSON.errores);
                var nTitle=" Ups! "; 
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
              }else{
                var nTitle=" Ups! "; 
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              }
              notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                
            }, 1000);             
          }
      });
    }

    $('#tablelistar tbody').on('mouseenter', 'a.dropdown-toggle', function () {

        var id = $(this).closest('tr').attr('id');
        var dropdown = $(this).closest('.dropdown')
        var dropdown_toggle = $(this).closest('.dropdown-toggle')

        $('.dropdown-toggle').attr('aria-expanded','false')
        $('.dropdown').removeClass('open')
        $('.table-responsive').css( "overflow", "auto" );

        if(!dropdown.hasClass('open')){
            dropdown.addClass('open')
            dropdown_toggle.attr('aria-expanded','true')
            $('.table-responsive').css( "overflow", "inherit" );
        }
     
    });

    $('.table-responsive').on('hide.bs.dropdown', function () {
        $('.table-responsive').css( "overflow", "auto" );
    })

    $('#tablelistar tbody').on('click', '.valorar', function () {

      var id = $(this).closest('tr').attr('id');
      var token = "{{ csrf_token() }}"
      clase_grupal_id = id
      procesando();

      $.ajax({
        url: route_consulta_examen+id,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        success:function(respuesta){
          if(respuesta.examen){
            examen_id = respuesta.examen
            var route =route_valorar+examen_id;
            window.location=route;
          }else{
            finprocesado();
             $('#modalError').modal('show');
          }
        },
        error:function(msj){
          swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
        }
      });
    });

    function atras(){
      $('#modalError').modal('hide');
    }

    function valoracion(){
      var route =route_examen+clase_grupal_id;
      window.open(route, '_blank');
      $('.modal').modal('hide')
    }


    $("#activas").click(function(){
        $( "#finalizadas2" ).removeClass( "c-verde" );
        $( "#activas2" ).addClass( "c-verde" );
    });

    $("#finalizadas").click(function(){
        $( "#finalizadas2" ).addClass( "c-verde" );
        $( "#activas2" ).removeClass( "c-verde" );
    });

    $("input[name='tipo']").on('change', function(){
      
      estatus = $(this).val()  

      t
        .columns(0,5)
        .search(dia,estatus)
        .draw();
    });

    </script>
@stop