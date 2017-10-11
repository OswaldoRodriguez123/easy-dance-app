@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/moment.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
@stop
@section('content')


 <div class="modal fade" id="modalAlumno" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                <h4 class="modal-title c-negro">Participante: <span class="span_alumno"></span> <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
            </div>
               <div class="modal-body">                           
               <div class="row p-t-20 p-b-0">
                  <form name="form_actualizar" id="form_actualizar">
                    <input class ="id_participante" type="hidden" name="id_participante" id="id_participante" value=""></input>
                    <div class="col-sm-6">
                      <label for="nombre" id="id-tipologia_id_participante">Perfil del Cliente</label>
                      <div class="select">
                        <select class="selectpicker" name="tipologia_id_participante" id="tipologia_id_participante" data-live-search="true">
                          <option value="">Selecciona</option>
                          @foreach($tipologias as $tipologia)
                            <option value = "{{$tipologia->id}}">{{$tipologia->nombre}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="has-error" id="error-tipologia_id_participante">
                        <span >
                          <small class="help-block error-span" id="error-tipologia_id_participante_mensaje" ></small>                
                        </span>
                      </div>
                    </div>
                 
                   <div class="clearfix"></div>

                   <div class="col-sm-12">
                     <div class="form-group fg-line">
                        <label for="nombre" id="id-nombre_participante">Nombre</label>
                        <input type="text" class="form-control input-sm" name="nombre_participante" id="nombre_participante" placeholder="Ej. Valeria" disabled>
                     </div>
                   </div>

                   <div class="clearfix"></div> 


                   <div class="col-sm-12">
                     <div class="form-group fg-line">
                        <label for="id-apellido" id="id-apellido_participante">Apellido</label>
                        <input type="text" class="form-control input-sm" name="apellido_participante" id="apellido_participante" placeholder="Ej. Sánchez" disabled>
                     </div>
                   </div>

                   <div class="clearfix"></div> 

                   <div class="col-sm-12">
                        <div class="form-group fg-line">
                        <label for="apellido" id="id-fecha_nacimiento_participante">Fecha de Nacimiento</label>
                                <div class="dtp-container fg-line">
                                <input name="fecha_nacimiento_participante" id="fecha_nacimiento_participante" class="form-control date-picker" placeholder="Seleciona" type="text" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div> 

                                                   
                   <div class="col-sm-12">
                     <div class="form-group fg-line ">
                        <label for="sexo p-t-10" id="id-sexo_participante">Sexo</label>
                        <div class="p-t-10">
                        <label class="radio radio-inline m-r-20">
                            <input name="sexo_participante" id="mujer" value="F" type="radio">
                            <i class="input-helper"></i>  
                            Mujer <i class="zmdi zmdi-female p-l-5 f-20"></i>
                        </label>
                        <label class="radio radio-inline m-r-20 ">
                            <input name="sexo_participante" id="hombre" value="M" type="radio">
                            <i class="input-helper"></i>  
                            Hombre <i class="zmdi zmdi-male-alt p-l-5 f-20"></i>
                        </label>
                        </div>
                        
                     </div>
                   </div>

                   <div class="col-sm-12">

                   <label for="apellido" id="id-correo_participante">Correo Electrónico</label>

                        <div class="form-group fg-line ">
                          <input type="text" class="form-control input-sm proceso" name="correo_participante" id="correo_participante" placeholder="Ej. easydance@gmail.com" disabled>
                          </div>

                   </div>

                   <div class="clearfix"></div> 
                   <br>

                   <div class="col-sm-12">
                     
                        <label for="apellido" id="id-celular_participante">Teléfono Móvil</label>

                        <div class="form-group fg-line ">
                          <input type="text" class="form-control input-sm input-mask" name="celular_participante" id="celular_participante" data-mask="(000)000-0000" placeholder="Ej: (426)367-0894" disabled>
                          </div>
                   </div>

                   <div class="clearfix"></div> 
                   <br>


                   <div class="col-sm-12">
                     
                        <label for="apellido" id="id-telefono_participante">Teléfono Local</label> 

                        <div class="form-group fg-line ">
                          <input disabled type="text" class="form-control input-sm input-mask" name="telefono_participante" id="telefono_participante" data-mask="(000)000-0000" placeholder="Ej: (426)367-0894" disabled>
                          </div>
                   </div>

                </form>
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

                  <a class="btn-blanco m-r-5 f-12" href="#" id="actualizar_participante"> Actualizar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                </div>
            </div>
        </div>
    </div>
</div>

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

  <div class="modal fade" id="modalCongelar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                <h4 class="modal-title c-negro"> Congelar un alumno <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
            </div>
            <form name="congelar_alumno" id="congelar_alumno"  >
               <input type="hidden" name="_token" value="{{ csrf_token() }}">
               <input type="hidden" name="inscripcion_clase_grupal_id" id="inscripcion_clase_grupal_id"></input>  
               <div class="modal-body">                           
               <div class="row p-t-20 p-b-0">

                   <div class="col-sm-3">

                        <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                        <div class="clearfix p-b-15"></div>

                        <span class="f-15 f-700 span_alumno"></span>

                          
                   </div>

               <div class="col-sm-9">
         
                <label for="razon_cancelacion" id="id-razon_congelacion">Razones de congelar el alumno</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica las razones por el cual estás congelando al alumno" title="" data-original-title="Ayuda"></i>
                <br></br>

                <div class="fg-line">
                  <textarea class="form-control" id="razon_congelacion" name="razon_congelacion" rows="2" placeholder="Ej. No podré asistir por razones ajenas a mi voluntad"></textarea>
                  </div>
                <div class="has-error" id="error-razon_congelacion">
                  <span >
                    <small class="help-block error-span" id="error-razon_congelacion_mensaje" ></small>                                           
                  </span>
                </div>
              </div>


              <div class="col-sm-9">
                <div class="form-group">
                    <div class="form-group fg-line">
                    <label for="fecha_inicio">Fecha</label>
                    <div class="fg-line">
                        <input type="text" id="fecha" name="fecha" class="form-control pointer" placeholder="Selecciona la fecha">
                    </div>
                 </div>
                    <div class="has-error" id="error-fecha">
                      <span >
                          <small id="error-fecha_mensaje" class="help-block error-span" ></small>                                           
                      </span>
                    </div>
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
                  <button type="button" class="btn-blanco btn m-r-10 f-16" id="congelar" name="congelar" > Completar la congelación</button>
                  <button type="button" class="cancelar btn btn-default" data-dismiss="modal">Volver</button>
                </div>
            </div></form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCostoInscripcion-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_costo_inscripcion_clase_grupal" id="edit_costo_inscripcion_clase_grupal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="costo">Costo Inscripcion</label>
                                    <input type="text" class="form-control input-sm" name="costo_inscripcion" id="costo_inscripcion" placeholder="Ej. 5000">
                                 </div>
                                 <div class="has-error" id="error-costo_inscripcion">
                                      <span >
                                          <small class="help-block error-span" id="error-costo_inscripcion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>


                               <input type="hidden" name="id" value="{{$clasegrupal->id}}"></input>
                              

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

                              <button type="button" class="btn btn-blanco m-r-10 f-12" id="guardar_inscripcion" name="guardar_inscripcion">Guardar</button>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalCostoMensualidad-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1100 !important;">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_costo_mensualidad_clase_grupal" id="edit_costo_mensualidad_clase_grupal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="costo">Costo Mensualidad</label>
                                    <input type="text" class="form-control input-sm" name="costo_mensualidad" id="costo_mensualidad" placeholder="Ej. 5000">
                                 </div>
                                 <div class="has-error" id="error-costo_mensualidad">
                                      <span >
                                          <small class="help-block error-span" id="error-costo_mensualidad_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>


                               <input type="hidden" name="id" value="{{$clasegrupal->id}}"></input>
                              

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

                              <button type="button" class="btn btn-blanco m-r-10 f-12" id="guardar_mensualidad" name="guardar_mensualidad">Guardar</button>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalFechaCobro-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_fecha_cobro_clasegrupal" id="edit_fecha_cobro_clasegrupal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                    <label for="fecha_inicio_preferencial">Fecha de primer cobro automático</label>
                                    <input type="text" class="form-control date-picker input-sm" name="fecha_pago" id="fecha_pago" placeholder="Ej. 00/00/0000" value="{{$clasegrupal->fecha_inicio_preferencial}}">
                                 </div>
                                    <div class="has-error" id="error-fecha_inicio_preferencial">
                                      <span >
                                          <small id="error-fecha_inicio_preferencial_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$clasegrupal->id}}"></input>
                              

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

                              <button type="button" class="btn btn-blanco m-r-10 f-12" id="guardar_fecha" name="guardar_fecha">Guardar</button>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Agregar <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="agregar_inscripcion" id="agregar_inscripcion">

                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input type="hidden" name="clase_grupal_id" value="{{ $id }}">

                            <div class="row p-l-10 p-r-10">
                              <div class="clearfix p-b-15"></div>
                              <div class="clearfix p-b-15"></div>

                              <div class="col-sm-12">
                                 
                                    <label for="promotor" class="c-morado f-22" id="id-promotor">Promotor</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el promotor" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a-instructor f-22"></i></span>
                                      <div class="select">
                                        <select class="selectpicker bs-select-hidden" multiple="" data-max-options="5" name="promotor" id="promotor" data-live-search="true" title="Selecciona">
                                          @foreach ( $promotores as $promotor )
                                            <option value = "{{ $promotor['id'] }}" data-content="{{ $promotor['nombre'] }} {{ $promotor['apellido'] }} {!!$promotor['icono']!!}"></option>
                                          @endforeach
                                        </select>
                                      </div>
                                      <div class="has-error" id="error-promotor">
                                      <span >
                                        <small class="help-block error-span" id="error-promotor_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>
                               </div>

                               <div class="clearfix p-b-15"></div>

                                <div class="col-sm-12">
                                 
                                     <label for="alumno" class="c-morado f-22" id="id-alumno_id">Seleccionar Alumno</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona un participante al cual deseas asignar a la clase grupal" title="" data-original-title="Ayuda"></i>

                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a-alumnos f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">

                                        <select class="selectpicker" id="alumno_id" name="alumno_id" title="Selecciona" data-live-search="true">

                                         @foreach ( $alumnos as $alumno )
                                          <?php $exist = false; ?>
                                          @foreach ( $alumnos_inscritos as $inscripcion)
                                            @if ($inscripcion['alumno_id']==$alumno['id'] && $inscripcion['tipo'] == 1)
                                              <?php $exist = true; ?>
                                            @endif
                                          @endforeach
                                          @if ($exist)
                                              <option disabled title="Ya esta en la clase grupal" data-content="<span title='Este alumno ya se encuentra en la clase grupal'><i class='glyphicon glyphicon-remove'></i> {{ $alumno['nombre'] }} {{ $alumno['apellido'] }} {{ $alumno['identificacion'] }}</span>" value = "{{ $alumno['id'] }}"></option>
                                          @else
                                              <option value = "{{ $alumno['id'] }}">{{ $alumno['nombre'] }} {{ $alumno['apellido'] }} {{ $alumno['identificacion'] }}</option>
                                          @endif
                                         @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-alumno_id">
                                      <span >
                                        <small class="help-block error-span" id="error-alumno_id_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12 p-20">
                                    <label>Permite Promociones</label> 
                                    
                                    <br></br>
                                    <input type="text" id="boolean_promociones" name="boolean_promociones" value="" hidden="hidden">
                                    <div class="p-t-10">
                                      <div class="toggle-switch" data-ts-color="purple">
                                      <span class="p-r-10 f-700 f-16">No</span><input id="promociones" type="checkbox">
                                      
                                      <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                    </div>
                                
                                  <div id="div_promocion" style="display: none">
                                    <div class="clearfix p-b-35"></div>

                                      <div class="form-group fg-line ">
                                          <div class="p-t-10">
                                          <label class="radio radio-inline m-r-20">
                                              <input name="tipo_promocion" id="ambas" value="T" type="radio" checked >
                                              <i class="input-helper"></i>  
                                              Ambas
                                          </label>
                                          <label class="radio radio-inline m-r-20">
                                              <input name="tipo_promocion" id="inscripcion" value="I" type="radio">
                                              <i class="input-helper"></i>  
                                              Inscripción
                                          </label>
                                          <label class="radio radio-inline m-r-20">
                                              <input name="tipo_promocion" id="mensualidad" value="M" type="radio">
                                              <i class="input-helper"></i>  
                                              Mensualidad
                                          </label>
                                          </div>
                                        </div>

                                      <div class="clearfix p-b-35"></div>

                                      <label>Selecciona la promoción</label> 

                                      <div class="input-group">
                                        <span class="input-group-addon"><i class="icon_a-promocion f-22"></i></span>
                                        <div class="fg-line">
                                        <div class="select">

                                          <select class="selectpicker" id="promocion_id" name="promocion_id" title="Selecciona" data-live-search="true">

                                            <option value = "">Selecciona</option>

                                            @foreach ( $promociones as $promocion )
                                              
                                              <option value = "{{ $promocion->porcentaje_descuento }}">{{ $promocion->nombre}} - {{ $promocion->porcentaje_descuento}}%</option>
                                          
                                            @endforeach
                                          </select>
                                        </div>
                                        </div>
                                        <div class="has-error" id="error-promocion_id">
                                          <span >
                                            <small class="help-block error-span" id="error-promocion_id_mensaje" ></small>                                           
                                          </span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>


                                <div class="clearfix p-b-35"></div>


                               <div class="col-sm-12">

                               <span class="f-22 c-morado"> Datos Administrativos de la Clase Grupal </span>

                               <hr>

                               </div>

                               

                               <br>

                               <div class="col-sm-12">
                            
                                <table class="table table-striped table-bordered">
                               <tr class="detalle" data-toggle="modal" href="#modalCostoInscripcion-ClaseGrupal">
                                 <td width="70%">
                                    <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-costo_inscripcion" class="zmdi  {{ empty($clasegrupal->costo_inscripcion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                                   <span class="m-l-10 m-r-10"> <i class="icon_b icon_b-costo f-22"></i> </span>
                                   <span class="f-14"> Costo Inscripcion </span>
                                 </td>
                                 <td class="f-14 m-l-15" ><span id="clasegrupal-costo_inscripcion">{{$clasegrupal->costo_inscripcion}}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                                </tr>
                                </table>
                                 
                               </div>

                               <br>

                               <div class="col-sm-12">
                                 

                                  <table class="table table-striped table-bordered">
                                   <tr class="detalle" data-toggle="modal" href="#modalCostoMensualidad-ClaseGrupal">
                                     <td width="70%">
                                        <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-costo_mensualidad" class="zmdi  {{ empty($clasegrupal->costo_mensualidad) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                                       <span class="m-l-10 m-r-10"> <i class="icon_b icon_b-costo f-22"></i> </span>
                                       <span class="f-14"> Costo Mensualidad</span>
                                     </td>
                                     <td class="f-14 m-l-15" ><span id="clasegrupal-costo_mensualidad">{{$clasegrupal->costo_mensualidad}}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                                    </tr>
                                  </table>

                               </div>

                               <br>

                               <div class="col-sm-12">

                                    <table class="table table-striped table-bordered">
                                   <tr class="detalle" data-toggle="modal" href="#modalFechaCobro-ClaseGrupal">
                                     <td width="70%">
                                      <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-fecha_inicio_preferencial" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                                      <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-calendar f-22"></i> </span>
                                      <span class="f-14">Fecha de primer cobro automático </span>
                                     </td>
                                     <td class="f-14 m-l-15" id="clasegrupal-fecha_inicio_preferencial" ><span id="clasegrupal-fecha_inicio_preferencial">
                                     {{ $clasegrupal->fecha_inicio_preferencial == 0000-00-00 ? \Carbon\Carbon::createFromFormat('Y-m-d',$clasegrupal->fecha_inicio)->format('d/m/Y') : \Carbon\Carbon::createFromFormat('Y-m-d',$clasegrupal->fecha_inicio_preferencial)->format('d/m/Y') }}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
                                    </tr>
                                    </table>

                                </div>

                                <div class="col-sm-12 p-20" id="textarea_observacion" style="display:none">

                                    <div class="clearfix p-b-10"></div>
                                   
                                    <label for="observacion_cambio_costo" id="id-observacion_cambio_costo">Explique las razones por las que el costo fue cambiado</label>
                                    <br></br>

                                    <div class="fg-line">
                                      <textarea class="form-control" id="observacion_cambio_costo" name="observacion_cambio_costo" rows="2"></textarea>
                                    </div>
                                </div>

                                <div class="clearfix p-b-35"></div>

                                <div class="col-sm-6">

                                  <span for="alumno" class="c-morado f-22">Modalidad de Pago</span>
                                  <hr>
                                  <div class="col-sm-6">
                                    <div class="select">
                                      <select class="selectpicker" name="tipo_pago" id="tipo_pago" data-live-search="true">
                                        <option value = "1">Contado</option>
                                        <option value = "2">Crédito</option>
                                        <option value = "3">Sin Confirmar</option>
                                      </select>
                                    </div>
                                    <div class="has-error" id="error-tipo_pago">
                                      <span >
                                        <small class="help-block error-span" id="error-tipo_pago_mensaje" ></small>                
                                      </span>
                                    </div>
                                  </div>
                                </div>
                                  

                               <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">

                                  <label for="alumno" class="c-morado f-22">Entrega</label>
                                  <hr>

                                  <div class="col-sm-6">

                                    <span for="alumno" class="c-morado f-16">Camiseta</span>

                                    <br></br>
                                    <input type="text" id="boolean_franela" name="boolean_franela" value="" hidden="hidden">
                                    <div class="p-t-10">
                                      <div class="toggle-switch" data-ts-color="purple">
                                      <span class="p-r-10 f-700 f-16">No</span><input id="franela" type="checkbox">
                                      
                                      <label for="franela-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                    </div>

                                    <div class="clearfix p-b-35"></div>

                                    <div class="form-group fg-line">
                                      <label for="talla_franela">Talla de la Camiseta</label>
                                      <input type="text" class="form-control input-sm" name="talla_franela" id="talla_franela" placeholder="Ej. 12">
                                   </div>

                                  </div>

                                  <div class="col-sm-6">

                                    <span for="alumno" class="c-morado f-16">Programación</span>


                                    <br></br>
                                    <input type="text" id="boolean_programacion" name="boolean_programacion" value="" hidden="hidden">
                                    <div class="p-t-10">
                                      <div class="toggle-switch" data-ts-color="purple">
                                      <span class="p-r-10 f-700 f-16">No</span><input id="programacion" type="checkbox">
                                      
                                      <label for="programacion-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                    </div>

                                  </div>

                                </div>


                                <div class="col-sm-12 p-20" id="textarea_entrega" style="display:none">

                                  <div class="clearfix p-b-10"></div>
                                 
                                  <label for="razon_entrega" id="id-razon_entrega">Explique las razones por la cual no fue entregado</label>
                                  <br></br>

                                  <div class="fg-line">
                                    <textarea class="form-control" id="razon_entrega" name="razon_entrega" rows="2"></textarea>
                                    </div>
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
                            <div class="col-sm-12 text-right">                           

                              <button type="button" class="btn btn-blanco m-r-10 f-18 agregar" id="agregar" name="agregar">Guardar<i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>

                            </div>
                        </div>
                      </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalEdicion" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Alumno: <span class="span_alumno" name="span_alumno"></span> <button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edicion_alumno" id="edicion_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">

                             <div class="col-sm-12">
                                   <div class="form-group fg-line">
                                      <label for="costo">Costo Mensualidad</label>
                                      <input type="text" class="form-control input-sm" name="costo_mensualidad_edicion" id="costo_mensualidad_edicion" data-mask="0000000000" placeholder="Ej. 5000">
                                   </div>
                                   <div class="has-error" id="error-costo_mensualidad_edicion">
                                        <span >
                                            <small class="help-block error-span" id="error-costo_mensualidad_edicion_mensaje" ></small>                                
                                        </span>
                                    </div>
                                 </div>
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                    <label for="fecha_pago_edicion">Fecha de primer cobro automático</label>
                                    <input type="text" class="form-control date-picker input-sm" name="fecha_pago_edicion" id="fecha_pago_edicion" placeholder="Ej. 00/00/0000">
                                 </div>
                                    <div class="has-error" id="error-fecha_pago_edicion">
                                      <span >
                                          <small id="error-fecha_pago_edicion_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input class ="id_edicion" type="hidden" name="id_edicion" id="id_edicion" value=""></input>
                              

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

                              <button type="button" class="btn-blanco m-r-5 f-12 guardar_edicion" id="guardar_edicion" name="guardar_edicion">Guardar<i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalCredencial" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Credenciales Alumno: <span id="credencial_alumno" name="credencial_alumno"></span><button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="form_credencial" id="form_credencial"  >
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="alumno_id_credencial" id="alumno_id_credencial"></input>

                          <div class="modal-body">                           
                          <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="cantidad">Ingresa la cantidad de credenciales</label>
                                    <input type="text" class="form-control input-sm input-mask" name="cantidad" id="cantidad" data-mask="0000000" placeholder="Ej: 50">
                                 </div>
                                 <div class="has-error" id="error-cantidad">
                                      <span >
                                          <small class="help-block error-span" id="error-cantidad_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 


                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="dias_vencimiento">Días de caducidad</label>
                                    <input type="text" class="form-control input-sm input-mask" name="dias_vencimiento" id="dias_vencimiento" data-mask="0000000" placeholder="Ej: 25">
                                 </div>
                                 <div class="has-error" id="error-dias_vencimiento">
                                      <span >
                                          <small class="help-block error-span" id="error-dias_vencimiento_mensaje"  ></small>                                           
                                      </span>
                                  </div>
                               </div>

                              <div class="clearfix m-b-30"></div>

                              <div class="col-sm-2">
                                <button type="button" class="btn btn-blanco f-10" name= "agregar_credencial" id="agregar_credencial" > Agregar Linea <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>
                              </div>  

                              <div class="col-sm-10" style="text-align: right;">
                                Total Credenciales: <span id="total_credenciales_alumno">0</span>
                              </div>
                               

                              <div class="clearfix p-b-35"></div>

                              <div class="table-responsive row">
                                <div class="col-md-12">
                                  <table class="table table-striped table-bordered text-center " id="tablecredencial" >
                                    <thead>
                                        <tr>
                                            <th class="text-center" data-column-id="cantidad">Cantidad</th>
                                            <th class="text-center" data-column-id="fecha_vencimiento">Fecha de Vencimiento</th>
                                            <th class="text-center" data-column-id="fecha_vencimiento">Dias de Vencimiento</th>
                                            <th class="text-center" data-column-id="operacion" data-order="desc" >Acciones</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                  </table>
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

                              <a class="btn-blanco m-r-5 f-12 dismiss pointer">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalTransferir" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Transferir Alumno: <span class="span_alumno" id="span_alumno"></span><button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="form_transferir" id="form_transferir"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Clases Grupales</label>

                                      <div class="select">
                                          <select class="form-control" id="clase_grupal_id" name="clase_grupal_id">
                                          @foreach ($clases_grupales as $clase_grupal )
                                            <option value = "{{ $clase_grupal['id'] }}">
                                              {{ $clase_grupal['nombre'] }} - {{ $clase_grupal['hora_inicio'] }} / {{ $clase_grupal['hora_final'] }} - {{ $clase_grupal['dia_de_semana'] }} - {{ $clase_grupal['instructor'] }} - {{ $clase_grupal['especialidad'] }}
                                            </option>
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

                               <input type="hidden" name="transferir_inscripcion_id" id="transferir_inscripcion_id"></input>
                            

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

                              <a class="btn-blanco m-r-5 f-12 transferir" href="#"> Transferir <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalNota" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                      <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                          <h4 class="modal-title c-negro"> Agregar una nota <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                      </div>
                      <form name="agregar_nota" id="agregar_nota"  >
                         <input type="hidden" name="_token" value="{{ csrf_token() }}">
                         <input type="hidden" name="nota_administrativa_inscripcion_clase_grupal_id" id="nota_administrativa_inscripcion_clase_grupal_id"></input>  
                         <div class="modal-body">                           
                         <div class="row p-t-20 p-b-0">

                         <div class="col-sm-12">
                   
                          <label for="nota_administrativa" id="id-nota_administrativa">Nota Administrativa</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la nota administrativa" title="" data-original-title="Ayuda"></i>
                          <br></br>

                          <div class="fg-line">
                            <textarea class="form-control" id="nota_administrativa" name="nota_administrativa" rows="2" placeholder="Ingresa la nota"></textarea>
                            </div>
                          <div class="has-error" id="error-nota_administrativa">
                            <span >
                              <small class="help-block error-span" id="error-nota_administrativa_mensaje" ></small>                                           
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
                            <button type="button" class="btn-blanco btn m-r-10 f-16" id="add_nota" name="add_nota" > Guardar</button>
                            <button type="button" class="cancelar btn btn-default" data-dismiss="modal">Volver</button>
                          </div>
                      </div></form>
                  </div>
              </div>
          </div>


            <section id="content">
                <div class="container">
                
                    <div class="block-header">

                        <?php $url = "/agendar/clases-grupales/detalle/$id" ?>
                        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

                        <!-- <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/agendar/clases-grupales/detalle/{{$id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a> -->
                        
                        @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)

                          <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                              <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                              
                              <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                              
                              <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                              
                              <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                             
                              <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                              
                          </ul>

                        @endif
                    </div>  
                    
                    <div class="card">
                      <div class="card-header">

                        @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)

                          <div class="col-sm-6 text-left">
                            <ul class="top-menu">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft">
                                       <span class="f-15 f-700" style="color:black"> 
                                            <i id ="pop-operaciones" name="pop-operaciones" class="zmdi zmdi-wrench f-20 mousedefault" aria-describedby="popoveroperaciones" data-html="true" data-toggle="popover" data-placement="top" title="" type="button" data-original-title="" data-content=''></i>
                                       </span>
                                    </a>
                                    <ul class="dropdown-menu dm-icon pull-right">
                                        <li class="hidden-xs">
                                            <a onclick="procesando()" href="{{url('/')}}/agendar/clases-grupales/reservaciones/vencidas/{{$id}}"><i name="inactivos" id="inactivos" class="tm-icon zmdi zmdi-label-alt-outline f-25 pointer inactivos detalle"></i> Reservaciones Vencidas</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                          </div>

                          <div class="col-sm-6 text-right">
                            <a class="f-16 p-t-0 text-right text-success" data-toggle="modal" href="#modalAgregar">Agregar Nuevo Participante <i class="zmdi zmdi-account-add zmdi-hc-fw f-20 c-verde"></i></a>
                          </div>

                        @endif



                        <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-clases-grupales p-r-5"></i> Clase: {{$clasegrupal->nombre}}</p>
                        <hr class="linea-morada">

                        <div class="col-sm-6 text-left">
                          <div class="p-t-10"> 
                            <i class="zmdi zmdi-female f-25 c-rosado"></i> <span class="f-15" id="span_mujeres" style="padding-left:5px"> {{$mujeres}}</span>
                            <i class="zmdi zmdi-male-alt p-l-5 f-25 c-azul"></i> <span class="f-15" id="span_hombres" style="padding-left:5px"> {{$hombres}} </span>
                          </div>
                        </div>

                        @if($usuario_tipo == 3)
                          <div class="col-sm-6 text-right">

                            <span class="f-15">Total Credenciales:<span class="f-15" id="total_credenciales">{{$total_credenciales}}</span></span>

                          </div>
                        @endif
                      </div>

                      <div class="clearfix"></div>        

                      <div class="col-sm-12">
                          <div class="form-group fg-line ">
                              <div class="p-t-10">
                              <label class="radio radio-inline m-r-20">
                                  <input name="tipo" id="todos" value="T" type="radio" checked >
                                  <i class="input-helper"></i>  
                                  Todos <i id="todos2" name="todos2" class="zmdi zmdi-male-female zmdi-hc-fw c-verde f-20"></i>
                              </label>
                              <label class="radio radio-inline m-r-20">
                                  <input name="tipo" id="mujeres" value="F" type="radio">
                                  <i class="input-helper"></i>  
                                  Mujeres <i id="mujeres2" name="mujeres2" class="zmdi zmdi-female zmdi-hc-fw f-20"></i>
                              </label>
                              <label class="radio radio-inline m-r-20">
                                  <input name="tipo" id="hombres" value="M" type="radio">
                                  <i class="input-helper"></i>  
                                  Hombres <i id="hombres2" name="hombres2" class="zmdi zmdi-male-alt zmdi-hc-fw f-20"></i>
                              </label>
                              </div>
                              
                          </div>
                        </div>

                        <div class="clearfix p-b-35"></div>

                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="iconos"></th>
                                    <th class="text-center" data-column-id="imagen">Imagen</th>
                                    <th class="text-center" data-column-id="id" data-type="numeric">Id</th>
                                    <th class="text-center" data-column-id="sexo">Sexo</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombres</th>
                                    <th class="text-center" data-column-id="estatu_c" data-order="desc">Estatus C</th>
                                    <th class="text-center" data-column-id="estatu_e" data-order="desc">Balance E</th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" >Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($alumnos_inscritos as $alumno)
                              <?php 
                                
                                $contenido = '';

                                $id = $alumno['inscripcion_id'];
                                $alumno_id = $alumno['id'];

                                if($alumno['imagen']){
                                    $imagen = '/assets/uploads/usuario/'.$alumno['imagen'];
                                }else{
                                    if($alumno['sexo'] == 'F'){
                                        $imagen = '/assets/img/Mujer.jpg';
                                    }else{
                                        $imagen = '/assets/img/Hombre.jpg';
                                    }
                                }

                                if($alumno['tipo'] == 1){

                                 	if($alumno['boolean_franela'] && $alumno['boolean_programacion']){

	                                	$camiseta_programacion = '<i class="zmdi c-verde zmdi-check zmdi-hc-fw f-16 f-700"></i>';
	                                }else{
	                                	if($alumno['boolean_franela'] == 0 && $alumno['boolean_programacion'] == 0){

	                                      	$camiseta_programacion = '<i class="zmdi c-youtube icon_a-examen zmdi-hc-fw f-16 f-700"></i> <i class="zmdi c-youtube icon_f-productos zmdi-hc-fw f-16 f-700"></i>';
	                                    }else{

	                                      	if($alumno['boolean_franela']){
	                                        	$camiseta_programacion = '<i class="zmdi c-youtube icon_a-examen zmdi-hc-fw f-16 f-700"></i>';
	                                      	}else{
	                                        	$camiseta_programacion = '<i class="zmdi c-youtube icon_f-productos zmdi-hc-fw f-16 f-700"></i>';
	                                      	}

	                                    }
	                                }

                                  if($alumno['tipo_pago'] == 1){
                                    $tipo_pago = 'Contado';
                                  }else if($alumno['tipo_pago'] == 2){
                                    $tipo_pago = 'Crédito';
                                  }else{
                                    $tipo_pago = 'Sin Confirmar';
                                  }

	                                $talla_franela = $alumno['talla_franela'];
	                                $deuda = $alumno['deuda'];

                                }else{
                              		$camiseta_programacion = '';
                              		$talla_franela = '';
                              		$deuda = 0;
                                  $tipo_pago = '';
                                }

                                $contenido = 

                                '<p class="c-negro">' .
                                	$alumno['nombre'] . ' ' . $alumno['apellido'] . ' ' . ' ' .  '<img class="lv-img-lg" src="'.$imagen.'" alt=""><br><br>' .

                                	'Camiseta y Programación: ' . $camiseta_programacion . '<br>'.
                                	'Talla: ' . $talla_franela . '<br>'.
                                	'Cantidad que adeuda: ' . number_format($deuda, 2, '.' , '.')  . '<br>'.
                                  'Modalidad de pago: <span id="tipo_pago_'.$id.'">' . $tipo_pago . '</span><br>'.
                                  'Registro de llamada: ' . $alumno['llamadas'] . '<br>'.
                                  // 'Inasistencias: ' . $alumno['inasistencias'] . '<br>'.
                                  // 'Ultima Asistencia: ' . $alumno['ultima_asistencia'] . '<br>'.
                                '</p>';

                              ;?>

                                @if($alumno['tipo'] == 1)
                                  <tr data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "{{$contenido}}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "" id="{{$id}}" class="seleccion" data-tipo ="{{$alumno['tipo']}}" data-id="{{$alumno['id']}}" data-fecha="{{$alumno['fecha_pago']}}" data-mensualidad="{{$alumno['costo_mensualidad']}}" data-nombre="{{$alumno['nombre']}} {{$alumno['apellido']}}" data-sexo="{{$alumno['sexo']}}" data-correo="{{$alumno['correo']}}" data-alumno_id="{{$alumno_id}}" data-fecha_nacimiento="{{$alumno['fecha_nacimiento']}}" data-celular="{{$alumno['celular']}}" data-telefono="{{$alumno['telefono']}}" data-identificacion="{{$alumno['identificacion']}}" data-tipologia_id="{{$alumno['tipologia_id']}}" data-nota_administrativa="{{$alumno['nota_administrativa']}}">

                                      
                                    <td class="text-center previa"> 
                                      <span style="display: none">1</span>
                                      @if($alumno['activacion']) 
                                        <i class="zmdi zmdi-alert-circle-o zmdi-hc-fw c-youtube f-20" data-html="true" data-original-title="" data-content="Cuenta sin confirmar" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>

                                      @endif
                                    </td>
                                    <td class="text-center previa">
                                      @if($alumno['imagen'])
                                        <img class="lv-img" src="{{url('/')}}/assets/uploads/usuario/{{$alumno['imagen']}}" alt="">
                                      @else
                                          @if($alumno['sexo'] == 'M')
                                            <img class="lv-img" src="{{url('/')}}/assets/img/profile-pics/4.jpg" alt="">
                                          @else
                                            <img class="lv-img" src="{{url('/')}}/assets/img/profile-pics/5.jpg" alt="">
                                          @endif
                                      @endif
                                    </td>
                                    <td class="text-center previa">{{$alumno['identificacion']}}</td>
                                    <td class="text-center previa">
                                    @if($alumno['edad'] >= 18)
                                        @if($alumno['sexo']=='F')
                                            <span style="display: none">F</span><i class="zmdi zmdi-female f-25 c-rosado"></i> </span>
                                        @else
                                            <span style="display: none">M</span><i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>
                                        @endif
                                    @else
                                        @if($alumno['sexo']=='F')
                                            <span style="display: none">F</span><i class="zmdi fa fa-child f-15 c-rosado"></i> </span>
                                        @else
                                            <span style="display: none">M</span><i class="zmdi fa fa-child f-15 c-azul"></i> </span>
                                        @endif
                                    @endif
                                    </td>
                                    <td class="text-center previa">{{$alumno['nombre']}} {{$alumno['apellido']}} </td>
                                    <td class="text-center previa">
                                      <span style="display: none">{{$alumno['estatus']}}</span><i class="zmdi zmdi-label-alt-outline f-20 p-r-3 {{$alumno['estatus']}}"></i>
                                    </td>
                                    <td class="text-center previa">
                                      <span style="display: none">{{$alumno['deuda']}}</span><i class="zmdi zmdi-money {{ $alumno['deuda'] ? 'c-youtube ' : 'c-verde' }} zmdi-hc-fw f-20 p-r-3"></i>
                                    </td>
                                    <td class="text-center"> 

                                        <ul class="top-menu">
                                          <li class="dropdown" id="dropdown_{{$id}}">
                                              <a id="dropdown_toggle_{{$id}}" href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft">
                                                 <span class="f-15 f-700" style="color:black"> 
                                                      <i id ="pop-operaciones" name="pop-operaciones" class="zmdi zmdi-wrench f-20 mousedefault" aria-describedby="popoveroperaciones" data-html="true" data-toggle="popover" data-placement="top" title="" type="button" data-original-title="" data-content=''></i>
                                                 </span>
                                              </a>

                                                <div class="dropup" dropdown-append-to-body>
                                                  <ul class="dropdown-menu dm-icon pull-right" style="z-index: 999">

                                                      @if($usuario_tipo != 3)

                                                        @if($alumno['activacion']) 
                                                        
                                                          <li class="hidden-xs">
                                                            <a class="activar"><i class="zmdi zmdi-alert-circle-o f-20"></i> Activar Cuenta</a>
                                                          </li>

                                                        @endif

                                                        <li class="hidden-xs">
                                                            <a class="congelar_alumno"><i class="zmdi zmdi-close-circle-o f-20"></i>&nbsp;Congelar Alumno</a>
                                                        </li>

                                                        <li class="hidden-xs">
                                                            <a class="modal_transferir"><i class="zmdi zmdi-trending-up f-20 p-r-10"></i> Transferir</a>
                                                        </li>
                                                      @endif

                                                      <li class="hidden-xs">
                                                          <a class="credencial"><i class="zmdi icon_a-pagar f-20 p-r-10"></i> Credenciales</a>
                                                      </li>

                                                      <li class="hidden-xs">
                                                          <a class="valorar"><i class="zmdi icon_a-examen f-20"></i> Valorar</a>
                                                      </li>

                                                      <li class="hidden-xs">
                                                          <a href="{{url('/')}}/agendar/clases-grupales/participantes/historial/{{$id}}"><i class="zmdi zmdi-shield-check f-20"></i> Asistencia</a>
                                                      </li>

                                                       <li class="hidden-xs">
                                                            <a href="{{url('/')}}/participante/alumno/llamadas/{{$alumno_id}}"><i class="zmdi zmdi-phone f-20"></i> Llamadas</a>
                                                        </li>

                                                     @if($usuario_tipo != 3)
                                                        <li class="hidden-xs">
                                                            <a class="nota_administrativa"><i class="zmdi zmdi-assignment f-20"></i> Nota Administrativa</a>
                                                        </li>


                                                        <li class="hidden-xs">
                                                            <a class="eliminar"><i class="zmdi zmdi-delete boton red f-20"></i> Eliminar</a>
                                                        </li>
                                                      @endif


                                                  </ul>
                                              </div>
                                          </li>
                                      </ul>
                                    </td>
                                  </tr>
                                @else
                                  <tr data-tipo ="{{$alumno['tipo']}}" data-sexo="{{$alumno['sexo']}}" id="{{$alumno['inscripcion_id']}}" class="seleccion seleccion_deleted">
                                      <td class="text-center previa"><span style="display: none">2</span><span class="c-amarillo"><b>R</b></span></td>
                                      <td class="text-center previa">

                                        @if($alumno['sexo'] == 'M')
                                          <img class="lv-img-lg" src="{{url('/')}}/assets/img/profile-pics/4.jpg" alt="">
                                        @else
                                          <img class="lv-img-lg" src="{{url('/')}}/assets/img/profile-pics/5.jpg" alt="">
                                        @endif

                                      </td>
                                      <td class="text-center previa">{{$alumno['fecha_vencimiento']}}</td>
                                      <td class="text-center previa">
                                      @if($alumno['sexo']=='F')
                                        <span style="display: none">F</span><i class="zmdi zmdi-female f-25 c-rosado"></i> </span>
                                      @else
                                        <span style="display: none">M</span><i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>
                                      @endif
                                      </td>
                                      <td class="text-center previa">{{$alumno['nombre']}} {{$alumno['apellido']}} </td>
                                      <td class="text-center previa">{{$alumno['tiempo_vencimiento']}}</td>
                                      <td class="text-center previa">
                                        <i class="zmdi zmdi-money f-20 p-r-3 c-verde"></i>
                                      </td>
                                      <td class="text-center">
                                        <ul class="top-menu">
                                          <li class="dropdown" id="dropdown_{{$id}}">
                                              <a id="dropdown_toggle_{{$id}}" href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft">
                                                 <span class="f-15 f-700" style="color:black"> 
                                                      <i id ="pop-operaciones" name="pop-operaciones" class="zmdi zmdi-wrench f-20 mousedefault" aria-describedby="popoveroperaciones" data-html="true" data-toggle="popover" data-placement="top" title="" type="button" data-original-title="" data-content=''></i>
                                                 </span>
                                              </a>

                                                <div class="dropup" dropdown-append-to-body>
                                                  <ul class="dropdown-menu dm-icon pull-right" style="z-index: 999">
                                                      <li class="hidden-xs pointer">
                                                          <a class="inscribir"><i class="zmdi zmdi-plus f-20"></i> Inscribir</a>
                                                      </li>


                                                      <li class="hidden-xs pointer">
                                                          <a class="eliminar"><i class="zmdi zmdi-delete boton red f-20"></i> Eliminar</a>
                                                      </li>

                                                  </ul>
                                              </div>
                                          </li>
                                        </ul>
                                      </td>
                                  </tr>
                                @endif
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

        route_agregar="{{url('/')}}/agendar/clases-grupales/inscribir";
        route_eliminar="{{url('/')}}/agendar/clases-grupales/eliminarinscripcion/";
        route_congelar="{{url('/')}}/agendar/clases-grupales/congelar-alumno";
        route_update="{{url('/')}}/agendar/clases-grupales/update";
        route_enhorabuena="{{url('/')}}/agendar/clases-grupales/enhorabuena/";
        route_editar="{{url('/')}}/agendar/clases-grupales/editarinscripcion";
        route_actualizar="{{url('/')}}/agendar/clases-grupales/actualizar_participante";
        route_credencial="{{url('/')}}/agendar/clases-grupales/agregar_credencial";
        route_eliminar_credencial="{{url('/')}}/agendar/clases-grupales/eliminar_credencial/";
        route_detalle="{{url('/')}}/participante/alumno/detalle";
        route_valorar="{{url('/')}}/especiales/examenes/evaluar/";
        route_examen="{{url('/')}}/especiales/examenes/agregar/";
        route_alumno="{{url('/')}}/guardar-alumno";
        route_transferir="{{url('/')}}/agendar/clases-grupales/transferir";
        route_consultar_credencial="{{url('/')}}/agendar/clases-grupales/consultar_credenciales";
        route_consulta_examen="{{url('/')}}/agendar/clases-grupales/consulta_examen/";
        route_nota_administrativa="{{url('/')}}/agendar/clases-grupales/agregar-nota-administrativa";
        route_inscribir="{{url('/')}}/reservaciones/inscribir/";
        route_eliminar_reserva="{{url('/')}}/reservaciones/eliminar/";

        var in_credencial = <?php echo json_encode($in_credencial);?>;

        var hombres = "{{$hombres}}";
        var mujeres = "{{$mujeres}}";
        var permitir = 0;
        var costo_inscripcion = "{{$clasegrupal->costo_inscripcion}}"
        var costo_mensualidad = "{{$clasegrupal->costo_mensualidad}}"

        $(document).ready(function(){

          $('#promotor').val('1-7')
          $('#promotor').selectpicker('refresh')

          id_alumno = "{{Session::get('id_alumno')}}";
        
          if(id_alumno){

            $('#alumno_id > option[value="'+id_alumno+'"]').attr('selected', 'selected');

            setTimeout(function(){ 
                $('#modalAgregar').modal('show');
              }, 2000);
          }


          $('#fecha').daterangepicker({
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

          $("#promociones").attr("checked", false); 
          $("#ambas").attr("checked", true);
          $("#boolean_franela").val('1'); 
          $("#franela").attr("checked", true);
          $("#boolean_programacion").val('1');
          $("#programacion").attr("checked", true);

        });


        t=$('#tablelistar').DataTable({
          processing: true,
          serverSide: false,
          pageLength: 25,  
          paging: false,
          order: [[4, 'asc']],
          fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6),td:eq(7)', nRow).addClass( "text-center" );
            $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6)', nRow).attr( "onclick","previa(this)" );
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

        c=$('#tablecredencial').DataTable({
          processing: true,
          serverSide: false,
          pageLength: 25,  
          paging: false,
          searching:false,
          order: [[0, 'asc']],
          fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            $('td:eq(0),td:eq(1),td:eq(2)', nRow).addClass( "text-center" );
            $('td:eq(0),td:eq(1)', nRow).addClass( "disabled" );
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

        $("#franela").on('change', function(){
          if ($("#franela").is(":checked")){
            $("#boolean_franela").val('1');
          }else{
            $("#boolean_franela").val('0');
          } 

          if($("#franela").is(":checked") && $("#programacion").is(":checked")){

            $('#textarea_entrega').hide();

          }else{
            $('#textarea_entrega').show();
          }  
        });

        $("#programacion").on('change', function(){
          if ($("#programacion").is(":checked")){
            $("#boolean_programacion").val('1');
          }else{
            $("#boolean_programacion").val('0');
          }

          if($("#franela").is(":checked") && $("#programacion").is(":checked")){
            $('#textarea_entrega').hide();
          }else{
            $('#textarea_entrega').show();
          }    
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

        $("#agregar").click(function(){

            var values = $('#promotor').val();
            
            var promotores = '';

            if(values){
              for(var i = 0; i < values.length; i += 1) {
                promotores = promotores + ',' + values[i];
              }
            }

            procesando();
            var route = route_agregar;
            var token = $('input:hidden[name=_token]').val();    
            var costo_inscripcion = $("#clasegrupal-costo_inscripcion").text();
            var costo_mensualidad = $("#clasegrupal-costo_mensualidad").text();
            var fecha_pago = $("#clasegrupal-fecha_inicio_preferencial").text();
            var datos = $("#agregar_inscripcion").serialize();      
            limpiarMensaje();
            
            $.ajax({
                url: route,
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'POST',
                    data: datos+"&costo_inscripcion="+costo_inscripcion+"&costo_mensualidad="+costo_mensualidad+"&fecha_pago="+fecha_pago+"&permitir="+permitir+"&promotores="+promotores,
                success:function(respuesta){
                  setTimeout(function(){ 
                    var nFrom = $(this).attr('data-from');
                    var nAlign = $(this).attr('data-align');
                    var nIcons = $(this).attr('data-icon');
                    var nAnimIn = "animated flipInY";
                    var nAnimOut = "animated flipOutY"; 
                    if(respuesta.status=="OK"){

                      //SI SE ESTA INSCRIBIENDO MAS DE UNA PERSONA
                      // if(respuesta.array){
                        finprocesado();
                        var nType = 'success';
                        var nTitle="Ups! ";
                        var nMensaje=respuesta.mensaje;

                        $("#modalAgregar").modal("hide");

                        alumno = respuesta.alumno;
                        inscripcion = respuesta.inscripcion

                        // $.each(respuesta.array, function (index, array) {
                  

                        if(inscripcion.boolean_franela == 1 && inscripcion.boolean_programacion == 1){

                          iconos = '<i class="zmdi c-verde zmdi-check zmdi-hc-fw f-16 f-700"></i>'
                          
                        }else{

                          if(inscripcion.boolean_franela == 0 && inscripcion.boolean_programacion == 0)
                          {
                            iconos = '<i class="zmdi c-youtube icon_a-examen zmdi-hc-fw f-16 f-700"></i>' + ' ' + '<i class="zmdi c-youtube icon_f-productos zmdi-hc-fw f-16 f-700"></i>'
                          }else{
                            if(inscripcion.boolean_franela == 1){
                              iconos = '<i class="zmdi c-youtube icon_a-examen zmdi-hc-fw f-16 f-700"></i>'
                            }else{
                              iconos = '<i class="zmdi c-youtube icon_f-productos zmdi-hc-fw f-16 f-700"></i>'
                            }
                          }
                        }

                          var identificacion = alumno.identificacion;    
                          var nombre = alumno.nombre;
                          var apellido = alumno.apellido;

                          var talla_franela = inscripcion.talla_franela;
                          
                          if(alumno.sexo=='F')
                          {
                            imagen = '<img class="lv-img-sm" src="/assets/img/profile-pics/5.jpg" alt="">'
                            valor = $('#span_mujeres').html()
                            valor = parseInt(valor) + 1;
                            $('#span_mujeres').html(valor)
                            sexo = '<i class="zmdi zmdi-female f-25 c-rosado"></i> </span>'
                          }
                          else
                          {
                            imagen = '<img class="lv-img-sm" src="/assets/img/profile-pics/4.jpg" alt="">'
                            valor = $('#span_hombres').html()
                            valor = parseInt(valor) + 1;
                            $('#span_hombres').html(valor)
                            sexo = '<i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>'
                          }
                          
                      
                          if(respuesta.deuda > 0){
                            deuda = '<i class="zmdi zmdi-money f-20 p-r-3 c-youtube"></i>'
                          }else{
                            deuda = '<i class="zmdi zmdi-money f-20 p-r-3 c-verde"></i>'
                          }

                          var rowId=inscripcion.id;
                          var rowNode=t.row.add( [
                          '',
                          ''+imagen+'',
                          ''+identificacion+'',
                          ''+sexo+'',
                          ''+nombre+ ' ' +apellido+'',
                          '<i class="zmdi zmdi-label-alt-outline f-20 p-r-3 c-verde"></i>',
                          ''+deuda+'',
                          ''
                          ] ).draw(false).node();
                          $( rowNode )
                          .attr('id',rowId)
                          .data('tipo',1)
                          .data('tipo_pago',inscripcion.tipo_pago)
                          .addClass('seleccion');

                          $('#razon_entrega').val('')
                          $('#talla_franela').val('')
                          $('#observacion_cambio_costo').text('')
                          $('#textarea_observacion').hide();

                          // });
                        // }


                        //SOLO UNA PERSONA
                        // else{

                          window.location = route_enhorabuena + respuesta.id;

                        // }

                    }else{
                      var nTitle="Ups! ";
                      var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                      var nType = 'danger';
                    }                       

                    notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                  }, 1000);
                },
                error:function(msj){
                  setTimeout(function(){ 
                    // if (typeof msj.responseJSON === "undefined") {
                    //   window.location = "{{url('/')}}/error";
                    // }
                    if(msj.responseJSON.status=="ERROR"){
                      console.log(msj.responseJSON.errores);
                      errores(msj.responseJSON.errores);
                      var nTitle="    Ups! "; 
                      var nMensaje="Ha ocurrido un error, intente nuevamente por favor";   
                      var nType = 'danger';         
                    }else if(msj.responseJSON.status=="CANTIDAD-FULL"){
                      swal({   
                      title: msj.responseJSON.mensaje,   
                      text: "Confirmar inscripción!",   
                      type: "warning",   
                      showCancelButton: true,   
                      confirmButtonColor: "#DD6B55",   
                      confirmButtonText: "Inscribir!",  
                      cancelButtonText: "Cancelar",         
                      closeOnConfirm: true 
                      }, function(isConfirm){   
                      if (isConfirm) {
                        permitir = 1;
                        $('#agregar').click();  
                        }
                      });
                    }                        
                    finprocesado();
                    var nFrom = $(this).attr('data-from');
                    var nAlign = $(this).attr('data-align');
                    var nIcons = $(this).attr('data-icon');
                    var nAnimIn = "animated flipInY";
                    var nAnimOut = "animated flipOutY";    

                    notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);                   
              
                  }, 1000);
                }
            });
          // }
          // else{

          //   $("#error-alumno_id_mensaje").html("Debe seleccionar un alumno primero");

          // }
        });

        $("#guardar_inscripcion").click(function(){
            swal({   
                    title: "¿Seguro deseas modificar el costo de la inscripción?",   
                    text: "Confirmar el cambio",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#ec6c62",   
                    confirmButtonText: "Sí, modificar",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
            if (isConfirm) {

                var route = route_update+"/inscripcion";
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#edit_costo_inscripcion_clase_grupal" ).serialize(); 
                procesando();
                $(".procesando").removeClass('hidden');
                $(".procesando").addClass('show');         
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

                          var nType = 'success';
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;
                          
                          var costo_inscripcion = $("#costo_inscripcion").val();
                          $("#clasegrupal-costo_inscripcion").text(costo_inscripcion)
                          $('#textarea_observacion').show();

                          finprocesado();
                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          $('#modalCostoInscripcion-ClaseGrupal').modal('hide');
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';

                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          finprocesado();
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                        }                       
                        
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        if (typeof msj.responseJSON === "undefined") {
                          window.location = "{{url('/')}}/error";
                        }
                        finprocesado();
                        if(msj.responseJSON.status=="ERROR"){
                          console.log(msj.responseJSON.errores);
                          errores(msj.responseJSON.errores);
                          var nTitle="    Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        }else{
                          var nTitle="   Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }            

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
              }
            });
        });

        $("#guardar_mensualidad").click(function(){
            swal({   
                    title: "¿Seguro deseas modificar el costo de la mensualidad?",   
                    text: "Confirmar el cambio",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#ec6c62",   
                    confirmButtonText: "Sí, modificar",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
            if (isConfirm) {

                var route = route_update+"/mensualidad";
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#edit_costo_mensualidad_clase_grupal" ).serialize(); 
                procesando();
                $(".procesando").removeClass('hidden');
                $(".procesando").addClass('show');         
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

                          var nType = 'success';
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;
                          
                          var costo_mensualidad = $("#costo_mensualidad").val();
                          $("#clasegrupal-costo_mensualidad").text(costo_mensualidad)
                          $('#textarea_observacion').show();

                          finprocesado();
                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          $('#modalCostoMensualidad-ClaseGrupal').modal('hide');
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';

                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          finprocesado();
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                        }                       
                        
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        if (typeof msj.responseJSON === "undefined") {
                          window.location = "{{url('/')}}/error";
                        }
                        finprocesado();
                        if(msj.responseJSON.status=="ERROR"){
                          console.log(msj.responseJSON.errores);
                          errores(msj.responseJSON.errores);
                          var nTitle="    Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        }else{
                          var nTitle="   Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }            

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
              }
            });
        });

        $("#guardar_fecha").click(function(){
            swal({   
                    title: "¿Seguro deseas modificar la fecha de primer cobro automático ?",   
                    text: "Confirmar el cambio",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#ec6c62",   
                    confirmButtonText: "Sí, modificar",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
            if (isConfirm) {

                var route = route_update+"/fecha_pago";
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#edit_fecha_cobro_clasegrupal" ).serialize(); 
                procesando();
                $(".procesando").removeClass('hidden');
                $(".procesando").addClass('show');         
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

                          var nType = 'success';
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;
                          
                          var fecha_pago = $("#fecha_pago").val();
                          $("#clasegrupal-fecha_inicio_preferencial").text(fecha_pago)
                          $('#textarea_observacion').show();

                          finprocesado();
                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          $('#modalFechaCobro-ClaseGrupal').modal('hide');
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';

                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          finprocesado();
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                        }                       
                        
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        if (typeof msj.responseJSON === "undefined") {
                          window.location = "{{url('/')}}/error";
                        }
                        finprocesado();
                        if(msj.responseJSON.status=="ERROR"){
                          console.log(msj.responseJSON.errores);
                          errores(msj.responseJSON.errores);
                          var nTitle="    Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        }else{
                          var nTitle="   Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }            

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
              }
            });
        });

        $("#guardar_edicion").click(function(){

                procesando();
                var route = route_editar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#edicion_alumno").serialize();         
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

                          var nType = 'success';
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;
                          var tr_edicion = $("#"+respuesta.inscripcion.id_edicion);

                          $(tr_edicion).data('mensualidad', respuesta.inscripcion.costo_mensualidad_edicion)
                          $(tr_edicion).data('fecha', respuesta.inscripcion.fecha_pago_edicion)

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }                       
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        finprocesado();
                        $('#modalEdicion').modal('hide');
                        $("#guardar").removeAttr("disabled");
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

            $("#actualizar_participante").click(function(){

              procesando();
              var route = route_actualizar;
              var token = $('input:hidden[name=_token]').val();
              var datos = $( "#form_actualizar").serialize();         
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

                        var nType = 'success';
                        var nTitle="Ups! ";
                        var nMensaje=respuesta.mensaje;
                        var row = "#"+respuesta.id;
                        $(row).data('tipologia_id', respuesta.tipologia_id)

                      }else{
                        var nTitle="Ups! ";
                        var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        var nType = 'danger';
                      }                       
                      finprocesado();
                      $('#modalAlumno').modal('hide');
                      notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                    }, 1000);
                  },
                  error:function(msj){
                    setTimeout(function(){ 
                      // if (typeof msj.responseJSON === "undefined") {
                      //   window.location = "{{url('/')}}/error";
                      // }
                      if(msj.responseJSON.status=="ERROR"){
                        console.log(msj.responseJSON.errores);
                        errores(msj.responseJSON.errores);
                        var nTitle="    Ups! "; 
                        var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                      }else{
                        var nTitle="   Ups! "; 
                        var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                      }                        
                      finprocesado();
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

          $(".congelar_alumno").on('click', function(){

              var id = $(this).closest('tr').attr('id');
              var nombre = $(this).closest('tr').data('nombre');


              $('#inscripcion_clase_grupal_id').val(id);
              $('.span_alumno').text(nombre);
              
              $('#modalCongelar').modal('show');
          });


          $("#congelar").click(function(){
            swal({   
                    title: "¿Seguro deseas congelar al alumno ?",   
                    text: "Confirmar la congelación",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#ec6c62",   
                    confirmButtonText: "Sí, congelar",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
            if (isConfirm) {

                var route = route_congelar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#congelar_alumno" ).serialize(); 
                procesando();    
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

                          var nType = 'success';
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;

                          row = $('#'+respuesta.id)
                          
                          t.row($(row))
                            .remove()
                            .draw();

                          finprocesado();
                          $('#modalCongelar').modal('hide');
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';

                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          finprocesado();
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                        }                       
                        
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        if (typeof msj.responseJSON === "undefined") {
                          window.location = "{{url('/')}}/error";
                        }
                        finprocesado();
                        if(msj.responseJSON.status=="ERROR"){
                          console.log(msj.responseJSON.errores);
                          errores(msj.responseJSON.errores);
                          var nTitle="    Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        }else{
                          var nTitle="   Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }            

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
              }
            });
        });

        $(".credencial").on('click', function(){

          var alumno_id = $(this).closest('tr').data('alumno_id');
          var id = $(this).closest('tr').attr('id');
          var nombre = $(this).closest('tr').data('nombre');
          total_credenciales_alumno = 0;

          c.clear().draw();

          var route = route_consultar_credencial;
          var token = $('input:hidden[name=_token]').val();
          procesando();    
          limpiarMensaje();
          $.ajax({
              url: route,
              headers: {'X-CSRF-TOKEN': token},
              type: 'POST',
              dataType: 'json',
              data:'&alumno_id='+alumno_id+'&in_credencial='+in_credencial,
              success:function(respuesta){
                setTimeout(function(){ 
                  var nFrom = $(this).attr('data-from');
                  var nAlign = $(this).attr('data-align');
                  var nIcons = $(this).attr('data-icon');
                  var nAnimIn = "animated flipInY";
                  var nAnimOut = "animated flipOutY"; 
                  if(respuesta.status=="OK"){

                    $.each(respuesta.credenciales, function (index, array) {

                      if({{$usuario_tipo}} != 3){

                        accion = '<i class="zmdi zmdi-delete boton red f-20 p-r-10 pointer">'

                      }else{

                        if(array.instructor_id == "{{$usuario_id}}"){
                          accion = '<i class="zmdi zmdi-delete boton red f-20 p-r-10 pointer">'
                        }else{
                          accion = '<i data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Esta credencial no puede ser eliminada porque fue asignada por un administrador" title="" data-original-title="Ayuda" class="zmdi zmdi-lock-outline f-20 p-r-10 disabled">'
                        }
                      }

                      var rowId=array.id;
                      var rowNode=c.row.add( [
                        ''+array.cantidad+'',
                        ''+array.fecha_vencimiento+'',
                        ''+array.dias_vencimiento+'',
                        ''+accion+''
                      ] ).draw(false).node();

                      $( rowNode )
                        .attr('id',rowId)
                        .addClass('disabled');
                      

                    });

                    $('#total_credenciales_alumno').text(respuesta.total_credenciales)

                    finprocesado();

                  }else{
                    var nTitle="Ups! ";
                    var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                    var nType = 'danger';

                    finprocesado();
                    notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                  }                       
                  
                }, 1000);
              },
              error:function(msj){
                setTimeout(function(){ 
                  // if (typeof msj.responseJSON === "undefined") {
                  //   window.location = "{{url('/')}}/error";
                  // }
                  finprocesado();
                  if(msj.responseJSON.status=="ERROR"){
                    console.log(msj.responseJSON.errores);
                    errores(msj.responseJSON.errores);
                    var nTitle="    Ups! "; 
                    var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                  }else{
                    var nTitle="   Ups! "; 
                    var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                  }            

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
 
          $('[data-toggle="popover"]').popover(); 


          $('#alumno_id_credencial').val(alumno_id);
          $('#credencial_alumno').text(nombre);
          
          setTimeout(function(){ 
            $('#modalCredencial').modal('show');
          }, 1000);

        });

        $("#agregar_credencial").click(function(){

              $("#agregar_credencial").attr("disabled","disabled");
              $("#agregar_credencial").css({
                "opacity": ("0.2")
              });

              var route = route_credencial;
              var token = $('input:hidden[name=_token]').val();
              var datos = $( "#form_credencial" ).serialize();         
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

                      if({{$usuario_tipo}} != 3)

                        accion = '<i class="zmdi zmdi-delete boton red f-20 p-r-10 pointer">'

                      else{
                        if(respuesta.credencial_alumno.instructor_id == "{{$usuario_id}}"){
                          accion = '<i class="zmdi zmdi-delete boton red f-20 p-r-10 pointer">'
                        }else{
                          accion = '<i data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Esta credencial no puede ser eliminada porque fue asignada por un administrador" title="" data-original-title="Ayuda" class="zmdi zmdi-lock-outline f-20 p-r-10 pointer">'
                        }
                      }

                      $('[data-toggle="popover"]').popover(); 

                      var nType = 'success';
                      var nTitle="Ups! ";
                      var nMensaje=respuesta.mensaje;

                      var rowId=respuesta.credencial_alumno.id;
                      var rowNode=c.row.add( [
                        ''+respuesta.credencial_alumno.cantidad+'',
                        ''+respuesta.fecha_vencimiento+'',
                        ''+respuesta.credencial_alumno.dias_vencimiento+'',
                        ''+accion+''
                      ] ).draw(false).node();

                      $( rowNode )
                        .attr('id',rowId)
                        .addClass('disabled');

                      $('#form_credencial')[0].reset();

                      if(respuesta.total_credenciales){
                        $('#total_credenciales').text(respuesta.total_credenciales)
                      }

                      total_credenciales_alumno = parseInt($('#total_credenciales_alumno').text())
                      total_credenciales_alumno = total_credenciales_alumno + parseInt(respuesta.cantidad)

                      $('#total_credenciales_alumno').text(total_credenciales_alumno)
                      
                    }else{
                      var nTitle="Ups! ";
                      var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                      var nType = 'danger';
                    }  

                    $("#agregar_credencial").removeAttr("disabled");
                    $("#agregar_credencial").css({
                      "opacity": ("1")
                    });

                    notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                  }, 1000);
                },
                error:function(msj){
                  setTimeout(function(){ 
                    // if (typeof msj.responseJSON === "undefined") {
                    //   window.location = "{{url('/')}}/error";
                    // }

                    $("#agregar_credencial").removeAttr("disabled");
                    $("#agregar_credencial").css({
                      "opacity": ("1")
                    });

                    swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');

                  }, 1000);
                }
            });
          });

        $('#tablecredencial tbody').on( 'click', 'i.zmdi-delete', function () {

          var id = $(this).closest('tr').attr('id');
          element = this;

          swal({   
            title: '¿Seguro quieres eliminar la credencial?',   
            text: "Confirmar eliminación!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Eliminar!",  
            cancelButtonText: "Cancelar",         
            closeOnConfirm: true 
          }, function(isConfirm){   
            if (isConfirm) {

              procesando()

              var nFrom = $(this).attr('data-from');
              var nAlign = $(this).attr('data-align');
              var nIcons = $(this).attr('data-icon');
              var nType = 'success';
              var nAnimIn = $(this).attr('data-animation-in');
              var nAnimOut = $(this).attr('data-animation-out')
              var route = route_eliminar_credencial + id;
              var token = $('input:hidden[name=_token]').val();

              $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'DELETE',
                dataType: 'json',
                data: id,
                success:function(respuesta){
                  var nFrom = $(this).attr('data-from');
                  var nAlign = $(this).attr('data-align');
                  var nIcons = $(this).attr('data-icon');
                  var nAnimIn = "animated flipInY";
                  var nAnimOut = "animated flipOutY"; 
                  if(respuesta.status=="OK"){
                    var nType = 'success';
                    var nTitle="Ups! ";
                    var nMensaje=respuesta.mensaje;

                    c.row( $(element).parents('tr') )
                      .remove()
                      .draw();

                    swal("Exito!","La credencial ha sido eliminada!","success");

                    if(respuesta.total_credenciales){
                      $('#total_credenciales').text(respuesta.total_credenciales)
                    }

                    total_credenciales_alumno = parseInt($('#total_credenciales_alumno').text())
                    total_credenciales_alumno = total_credenciales_alumno - parseInt(respuesta.cantidad)

                    $('#total_credenciales_alumno').text(total_credenciales_alumno)

                    finprocesado()
                  
                  }
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
          });
        });

        $(".nota_administrativa").on('click', function(){
          var id = $(this).closest('tr').attr('id');
          var nota_administrativa = $(this).closest('tr').data('nota_administrativa');

          $('#nota_administrativa_inscripcion_clase_grupal_id').val(id);
          $('#nota_administrativa').text(nota_administrativa);
          
          $('#modalNota').modal('show');
        });

        function previa(t){

            var id = $(t).closest('tr').attr('id');

            var identificacion = $(t).closest('tr').data('identificacion');
            var nombre_apellido = $(t).closest('tr').data('nombre');
            var apellido_nombre = nombre_apellido.split(" ")
            var correo = $(t).closest('tr').data('correo');
            var fecha_nacimiento = $(t).closest('tr').data('fecha_nacimiento');
            var sexo = $(t).closest('tr').data('sexo');
            var telefono = $(t).closest('tr').data('telefono');
            var celular = $(t).closest('tr').data('celular');
            var tipologia_id = $(t).closest('tr').data('tipologia_id');

            if(sexo=="M"){
              $("#hombre").prop("checked", true);
            }else{
              $("#mujer").prop("checked", true);
            }
            
            $('.span_alumno').text(nombre_apellido)
            $('#id_participante').val(id);
            $('#identificacion_participante').text(identificacion);
            $('#nombre_participante').val(apellido_nombre[0]);
            $('#apellido_participante').val(apellido_nombre[1]);
            $('#correo_participante').val(correo);
            $('#fecha_nacimiento_participante').val(fecha_nacimiento);
            $('#telefono_participante').val(telefono);
            $('#celular_participante').val(celular);
            $('#tipologia_id_participante').val(tipologia_id);

            $('#tipologia_id_participante').selectpicker('refresh');
            
            $('#modalAlumno').modal('show');
        }

        // function previa(t){

        //     var id = $(t).closest('tr').attr('id');
        //     var fecha_pago = $(t).closest('tr').data('fecha');
        //     var costo_mensualidad = $(t).closest('tr').data('mensualidad');
        //     var nombre = $(t).closest('tr').data('nombre');


        //     $('.id_edicion').val(id);
        //     $('#costo_mensualidad_edicion').val(costo_mensualidad);
        //     $('#fecha_pago_edicion').val(fecha_pago);
        //     $('#span_alumno').text(nombre);
            
        //     $('#modalEdicion').modal('show');
        // }

        // function previa(t){
        //   var id = $(t).closest('tr').data('id');
        //   var route =route_detalle+"/"+id;
        //   window.open(route, '_blank');;
        // }


        $('#tablelistar tbody').on( 'click', '.eliminar', function () {

          var id = $(this).closest('tr').attr('id');
          var tipo = $(this).closest('tr').data('tipo');

          if(tipo == 1){
            titulo = 'Desea eliminar al alumno?'
          }else{
            titulo = 'Desea eliminar la reservación?'
          }

          element = this;

          swal({   
              title: titulo,   
              text: "Confirmar eliminación!",   
              type: "warning",   
              showCancelButton: true,   
              confirmButtonColor: "#DD6B55",   
              confirmButtonText: "Eliminar!",  
              cancelButtonText: "Cancelar",         
              closeOnConfirm: true 
          }, function(isConfirm){   
            if (isConfirm) {  
              eliminar(id, element);
            }
          });
        });
      
        function eliminar(id, element){
          procesando()
          var tipo = $(element).closest('tr').data('tipo');
          if(tipo == 1){
            var route = route_eliminar + id;
          }else{
            var route = route_eliminar_reserva + id;
          }
          var token = $('input:hidden[name=_token]').val();
          $.ajax({
            url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
            dataType: 'json',
            data: id,
            success:function(respuesta){
              var nFrom = $(this).attr('data-from');
              var nAlign = $(this).attr('data-align');
              var nIcons = $(this).attr('data-icon');
              var nAnimIn = "animated flipInY";
              var nAnimOut = "animated flipOutY"; 
              if(respuesta.status=="OK"){
                var nType = 'success';
                var nTitle="Ups! ";
                var nMensaje=respuesta.mensaje;

                t.row( $(element).parents('tr') )
                  .remove()
                  .draw();

                swal("Exito!","La reservación ha sido eliminada!","success");
                var sexo = $(element).closest('tr').data('sexo');

                if(sexo == 'F'){

                  mujeres = mujeres - 1

                  $('#span_mujeres').text(mujeres)

                }else{
                  hombres = hombres - 1

                  $('#span_hombres').text(hombres)
                }
                finprocesado()
              
              }
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

    $(document).on({
    'show.bs.modal': function () {
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    },
    'hidden.bs.modal': function() {
        if ($('.modal:visible').length > 0) {
            // restore the modal-open class to the body element, so that scrolling works
            // properly after de-stacking a modal.

          if($('.modal').hasClass('in')) {
            $('body').addClass('modal-open');
          }    

        }
    }
}, '.modal');

    function limpiarMensaje(){
        var campo = ["alumno_id", "instructor_id"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
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

      $('.modal').animate({
            scrollTop: 0,
      }, 1000);          

    }

    $('#modalCostoInscripcion-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#costo_inscripcion").val($("#clasegrupal-costo_inscripcion").text());
    })

    $('#modalCostoMensualidad-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#costo_mensualidad").val($("#clasegrupal-costo_mensualidad").text());
    })

    $('#modalFechaCobro-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var fecha = $("#clasegrupal-fecha_inicio_preferencial").text();
      $("#fecha_pago").val($.trim(fecha));
    })

    // $('#alumno_id').change(function () {

    //   var last = $("option:selected:last",this);
    //   if($(last).hasClass( "inscrito" )){
    //     $(this).attr('disabled', false);
    //     $('#alumno_id').selectpicker('deselectAll');
    //     $('#alumno_id').selectpicker('render');
    //     swal({   
    //       title: "ERROR",   
    //       text: "Ya este alumno esta inscrito",   
    //       type: "warning",   
    //       confirmButtonColor: "#ec6c62",   
    //       confirmButtonText: "Aceptar",  
    //       cancelButtonText: "Cancelar",         
    //       closeOnConfirm: true 
    //     });
    //   }
    // });

    $(".activar").click(function(){

      var correo = $(this).closest('tr').data('correo');
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

          activar(correo);

          
          }
        });
    });


    $(".valorar").click(function(){

      var id = $(this).closest('tr').data('id');
      var token = $('input:hidden[name=_token]').val();
      procesando();

      $.ajax({
        url: route_consulta_examen+"{{$clasegrupal->clase_grupal_id}}",
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        success:function(respuesta){
          if(respuesta.examen){
            examen_id = respuesta.examen
            $.ajax({
              url: route_alumno+"/"+id,
              headers: {'X-CSRF-TOKEN': token},
              type: 'POST',
              dataType: 'json',
              success:function(respuesta){
                var route =route_valorar+examen_id;
                window.location=route;
              },
              error:function(msj){
                finprocesado()
                swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
              }
            });
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

    function activar(correo){

       procesando();

       var route = "{{url('/')}}/activar";
       var token = $('input:hidden[name=_token]').val();
        
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data:"&email="+correo,
            success:function(respuesta){

                swal("Listo!","Correo enviado exitósamente!","success");

            },
            error:function(msj){

                  swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');

                }

            });
        
        finprocesado();
    }


    function valoracion(){
      var route =route_examen+"{{$clasegrupal->clase_grupal_id}}";
      window.open(route, '_blank');
      $('.modal').modal('hide')
    }

    function atras(){
      $('#modalError').modal('hide');
    }

    $('.modal_transferir').click(function(){

      var alumno_id = $(this).closest('tr').data('alumno_id');
      var nombre = $(this).closest('tr').data('nombre');
      var inscripcion_id = $(this).closest('tr').attr('id');

      $('.span_alumno').text(nombre);
      $('input[name=alumno_id]').val(alumno_id)
      $('#transferir_inscripcion_id').val(inscripcion_id)

      $('#modalTransferir').modal('show')

    });

    $(".transferir").click(function(){
      nombre = $('#span_alumno').text();
      swal({   
          title: "Desea transferir a "+nombre+" a la clase grupal seleccionada?",   
          text: "Confirmar transferencia!",     
          type: "warning",   
          showCancelButton: true,   
          confirmButtonColor: "#DD6B55",   
          confirmButtonText: "Transferir!",  
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
                      
            transferir();
            procesando();
            }
        });
    });

    function transferir(){
      var route = route_transferir;
      var token = $('input:hidden[name=_token]').val();
      var datos = $( "#form_transferir" ).serialize();
              
      $.ajax({
          url: route,
              headers: {'X-CSRF-TOKEN': token},
              type: 'POST',
          dataType: 'json',
          data:datos,
          success:function(respuesta){

            element = $('#'+respuesta.id)
                          
            var sexo = $(element).data('sexo');

            t.row($(element))
              .remove()
              .draw();

            if(sexo == 'F'){

              mujeres = mujeres - 1

              $('#span_mujeres').text(mujeres)

            }else{
              hombres = hombres - 1

              $('#span_hombres').text(hombres)
            }

            finprocesado();

            swal("Exito!","El alumno ha sido transferido!","success");

            $('.modal').modal('hide')

          },
          error:function (msj, ajaxOptions, thrownError){
            setTimeout(function(){ 
              // if (typeof msj.responseJSON === "undefined") {
              //   window.location = "{{url('/')}}/error";
              // }

              if(msj.responseJSON.status=="ERROR"){
                errores(msj.responseJSON.errores);
                var nType = 'danger';
                var nFrom = $(this).attr('data-from');
                var nAlign = $(this).attr('data-align');
                var nIcons = $(this).attr('data-icon');
                var nTitle=" Ups! "; 
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
              }

              notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
              finprocesado();
                
            }, 1000);             
          }
      });
    }

    $('input[name="tipo"]').on('change', function(){

        if($(this).val() == 'T'){

            $( "#hombres2" ).removeClass( "c-verde" );
            $( "#mujeres2" ).removeClass( "c-verde" );
            $( "#todos2" ).addClass( "c-verde" );

            t
            .columns(3)
            .search('')
            .draw(); 

        }else if($(this).val() == 'F'){

            $( "#hombres2" ).removeClass( "c-verde" );
            $( "#mujeres2" ).addClass( "c-verde" );
            $( "#todos2" ).removeClass( "c-verde" );

            t
            .columns(3)
            .search($(this).val())
            .draw();

        }else{

            $( "#hombres2" ).addClass( "c-verde" );
            $( "#mujeres2" ).removeClass( "c-verde" );
            $( "#todos2" ).removeClass( "c-verde" );

            t
            .columns(3)
            .search($(this).val())
            .draw();

        }

    });

    $("input[name=tipo_promocion]").on('change', function(){

      if ($("#promociones").is(":checked")){

        if($('#promocion_id').val()){

          valor_promocion = $('#promocion_id').val()

          porcentaje = valor_promocion / 100;
          descuento_inscripcion = costo_inscripcion * porcentaje
          descuento_mensualidad = costo_mensualidad * porcentaje
          costo_inscripcion_nuevo = costo_inscripcion - descuento_inscripcion
          costo_mensualidad_nuevo = costo_mensualidad - descuento_mensualidad

          if($(this).val() == 'T'){

            $('#clasegrupal-costo_inscripcion').text(costo_inscripcion_nuevo)
            $('#clasegrupal-costo_mensualidad').text(costo_mensualidad_nuevo)

          }else{
            if($(this).val() == 'I'){
              $('#clasegrupal-costo_inscripcion').text(costo_inscripcion_nuevo)
              $('#clasegrupal-costo_mensualidad').text(costo_mensualidad)
            }else{
              $('#clasegrupal-costo_inscripcion').text(costo_inscripcion)
              $('#clasegrupal-costo_mensualidad').text(costo_mensualidad_nuevo)
            }

          }

        }else{
          $('#clasegrupal-costo_inscripcion').text(costo_inscripcion)
          $('#clasegrupal-costo_mensualidad').text(costo_mensualidad)
        }
      }else{
        $('#clasegrupal-costo_inscripcion').text(costo_inscripcion)
        $('#clasegrupal-costo_mensualidad').text(costo_mensualidad)
      }

    });


    $("#promocion_id").on('change', function(){

      if ($("#promociones").is(":checked")){

        if($('#promocion_id').val()){

          valor_promocion = $('#promocion_id').val()
          tipo_promocion = $("input[name=tipo_promocion]").val()

          porcentaje = valor_promocion / 100;
          descuento_inscripcion = costo_inscripcion * porcentaje
          descuento_mensualidad = costo_mensualidad * porcentaje
          costo_inscripcion_nuevo = costo_inscripcion - descuento_inscripcion
          costo_mensualidad_nuevo = costo_mensualidad - descuento_mensualidad

          if(tipo_promocion == 'T'){

            $('#clasegrupal-costo_inscripcion').text(costo_inscripcion_nuevo)
            $('#clasegrupal-costo_mensualidad').text(costo_mensualidad_nuevo)

          }else{
            if(tipo_promocion == 'I'){
              $('#clasegrupal-costo_inscripcion').text(costo_inscripcion_nuevo)
              $('#clasegrupal-costo_mensualidad').text(costo_mensualidad)
            }else{
              $('#clasegrupal-costo_inscripcion').text(costo_inscripcion)
              $('#clasegrupal-costo_mensualidad').text(costo_mensualidad_nuevo)
            }

          }

        }else{
          $('#clasegrupal-costo_inscripcion').text(costo_inscripcion)
          $('#clasegrupal-costo_mensualidad').text(costo_mensualidad)
        }
      }else{
        $('#clasegrupal-costo_inscripcion').text(costo_inscripcion)
        $('#clasegrupal-costo_mensualidad').text(costo_mensualidad)
      }

    });


    $("#promociones").on('change', function(){

      if ($("#promociones").is(":checked")){
        $('#div_promocion').show();
      }else{
        $("#ambas").attr("checked", true);
        $('#div_promocion').hide();
        $('#clasegrupal-costo_inscripcion').text(costo_inscripcion)
        $('#clasegrupal-costo_mensualidad').text(costo_mensualidad)
        $('#promocion_id').val('')
        $('#promocion_id').selectpicker('refresh')
      }       
    });

    $(".dismiss").click(function(){
      procesando()
      setTimeout(function(){
        var nFrom = $(this).attr('data-from');
        var nAlign = $(this).attr('data-align');
        var nIcons = $(this).attr('data-icon');
        var nType = 'success';
        var nAnimIn = $(this).attr('data-animation-in');
        var nAnimOut = $(this).attr('data-animation-out')
        var nMensaje="¡Excelente! Los cambios se han actualizado satisfactoriamente";
        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

        $('.modal').modal('hide');
        finprocesado();
      }, 3000);
    });

    $("#add_nota").click(function(){

        procesando();
        var route = route_nota_administrativa;
        var token = $('input:hidden[name=_token]').val();
        var datos = $( "#agregar_nota").serialize();         
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

                  var nType = 'success';
                  var nTitle="Ups! ";
                  var nMensaje=respuesta.mensaje;
                  var row = "#"+respuesta.id;
                  $(row).data('nota_administrativa', respuesta.nota_administrativa)
                  $('#modalNota').modal('hide')

                }else{
                  var nTitle="Ups! ";
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                  var nType = 'danger';
                }                       
                finprocesado();
                $('#modalAlumno').modal('hide');
                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
              }, 1000);
            },
            error:function(msj){
              setTimeout(function(){ 
                // if (typeof msj.responseJSON === "undefined") {
                //   window.location = "{{url('/')}}/error";
                // }
                if(msj.responseJSON.status=="ERROR"){
                  console.log(msj.responseJSON.errores);
                  errores(msj.responseJSON.errores);
                  var nTitle="    Ups! "; 
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                }else{
                  var nTitle="   Ups! "; 
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                }                        
                finprocesado();
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

    $('#modalAgregar').on('hidden.bs.modal', function () {

      $('input[name=boolean_promociones]').prop('checked',false)
      $('input[name=boolean_franela]').prop('checked',true)
      $('input[name=boolean_programacion]').prop('checked',true)

      $('#textarea_entrega').hide();
      $('#textarea_observacion').hide();
      $('#div_promocion').hide();
      $('#agregar_inscripcion')[0].reset()
      $('.selectpicker').selectpicker('refresh')
    });

    $('#tablelistar tbody').on( 'click', '.inscribir', function () {

      var id = $(this).closest('tr').attr('id');

      element = this;

      swal({   
          title: 'Desea inscribir al alumno?',   
          text: "Confirmar inscripción!",   
          type: "warning",   
          showCancelButton: true,   
          confirmButtonColor: "#DD6B55",   
          confirmButtonText: "Inscribir!",  
          cancelButtonText: "Cancelar",         
          closeOnConfirm: true 
      }, function(isConfirm){   
        if (isConfirm) {  
          inscribir(id,element);
        }
      });
    });
  
    function inscribir(id,element){
      procesando()

      var route = route_inscribir + id;
   
      var token = $('input:hidden[name=_token]').val();
      $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: id,
        success:function(respuesta){
          var nFrom = $(this).attr('data-from');
          var nAlign = $(this).attr('data-align');
          var nIcons = $(this).attr('data-icon');
          var nAnimIn = "animated flipInY";
          var nAnimOut = "animated flipOutY"; 
          if(respuesta.status=="OK"){

            finprocesado();
            var nType = 'success';
            var nTitle="Ups! ";
            var nMensaje=respuesta.mensaje;
            notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

            alumno = respuesta.alumno;
            inscripcion = respuesta.inscripcion

            if(inscripcion.boolean_franela == 1 && inscripcion.boolean_programacion == 1){

              iconos = '<i class="zmdi c-verde zmdi-check zmdi-hc-fw f-16 f-700"></i>'
              
            }else{

              if(inscripcion.boolean_franela == 0 && inscripcion.boolean_programacion == 0)
              {
                iconos = '<i class="zmdi c-youtube icon_a-examen zmdi-hc-fw f-16 f-700"></i>' + ' ' + '<i class="zmdi c-youtube icon_f-productos zmdi-hc-fw f-16 f-700"></i>'
              }else{
                if(inscripcion.boolean_franela == 1){
                  iconos = '<i class="zmdi c-youtube icon_a-examen zmdi-hc-fw f-16 f-700"></i>'
                }else{
                  iconos = '<i class="zmdi c-youtube icon_f-productos zmdi-hc-fw f-16 f-700"></i>'
                }
              }
            }

            var identificacion = alumno.identificacion;    
            var nombre = alumno.nombre;
            var apellido = alumno.apellido;
            var talla_franela = inscripcion.talla_franela;
            
            if(alumno.sexo=='F'){
              imagen = '<img class="lv-img-sm" src="/assets/img/profile-pics/5.jpg" alt="">'
              valor = $('#span_mujeres').html()
              valor = parseInt(valor) + 1;
              $('#span_mujeres').html(valor)
              sexo = '<i class="zmdi zmdi-female f-25 c-rosado"></i> </span>'
            }else{
              imagen = '<img class="lv-img-sm" src="/assets/img/profile-pics/4.jpg" alt="">'
              valor = $('#span_hombres').html()
              valor = parseInt(valor) + 1;
              $('#span_hombres').html(valor)
              sexo = '<i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>'
            }
            
            if(respuesta.deuda > 0){
              deuda = '<i class="zmdi zmdi-money f-20 p-r-3 c-youtube"></i>'
            }else{
              deuda = '<i class="zmdi zmdi-money f-20 p-r-3 c-verde"></i>'
            }

            var rowId=inscripcion.id;
            var rowNode=t.row.add( [
            '',
            ''+imagen+'',
            ''+identificacion+'',
            ''+sexo+'',
            ''+nombre+ ' ' +apellido+'',
            '<i class="zmdi zmdi-label-alt-outline f-20 p-r-3 c-verde"></i>',
            ''+deuda+'',
            ''
            ] ).draw(false).node();

            $( rowNode )
              .attr('id',rowId)
              .data('tipo',1)
              .data('tipo_pago',inscripcion.tipo_pago)
              .addClass('seleccion');

            t.row( $(element).parents('tr') )
              .remove()
              .draw();

            window.location = route_enhorabuena + respuesta.id;
          
          }
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

  </script>

@stop