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

              <div class="modal fade" id="modalPago" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                                <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Pago<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                            </div>
                            <form name="form_pago" id="form_pago"  >
                               <input type="hidden" name="_token" value="{{ csrf_token() }}">
                               <input type="hidden" name="id" value="{{ $alumno->id }}">
                               <input type="hidden" id="servicio_producto_id" name="servicio_producto_id" value="">
                               <div class="modal-body">                           
                               <div class="row p-t-20 p-b-0">

                                  <div class="col-sm-12">
                                    <div class="clearfix p-b-35"></div>

                                      <label for="clase_grupal_id" id="id-clase_grupal_id">Linea de Servicio</label>

                                      <div class="input-group">
                                        <span class="input-group-addon"><i class="icon_a icon_a-estudio-salon f-22"></i></span>
                                        <div class="fg-line">
                                            <div class="select">
                                              <div class="select">
                                                <select class="selectpicker" data-live-search="true" name="tipo_servicio" id="tipo_servicio" data-live-search="true">
                                                    <option value="0">Seleccione</option>
                                                    <option value="99">Academia Recepción</option>
                                                    <option value="14">Fiestas y Eventos</option>
                                                    <option value="5">Talleres</option>
                                                    <option value="11">Campañas</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="clearfix p-b-35"></div>
                                   
                                   
                                  <div class="col-sm-12">
                                    <div class="clearfix p-b-35"></div>

                                        <label for="tipo_id" id="id-tipo_id">Detalle</label><br>

                                        <div class="dropdown" id="dropdown_boton">
                                            <a id="detalle_boton" role="button" data-toggle="dropdown" class="btn btn-blanco">
                                                Pulsa Aqui <span class="caret"></span>
                                            </a>
                                            <ul id="dropdown_principal" class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            </ul>
                                        </div>
                                        <div class="has-error" id="error-servicio_producto_id">
                                            <span >
                                                <small class="help-block error-span" id="error-servicio_producto_id_mensaje" ></small>                               
                                            </span>
                                        </div>              
                                      </div>


                                      <div class="clearfix p-b-35"></div>

                                   
                                      <label for="apellido" id="id-tipo_pago">Tipo</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el tipo de pago" title="" data-original-title="Ayuda"></i>

                                      <div class="form-group fg-line ">
                                        <div class="p-t-10">
                                          <label class="radio radio-inline m-r-20">
                                              <input name="tipo_pago" id="porcentaje" value="1" type="radio" checked>
                                              <i class="input-helper"></i>  
                                              Porcentaje 
                                          </label>
                                          <label class="radio radio-inline m-r-20 ">
                                              <input name="tipo_pago" id="tasa_fija" value="2" type="radio">
                                              <i class="input-helper"></i>  
                                              Tasa Fija 
                                          </label>
                                      </div>
                                      </div>
                                   <div class="has-error" id="error-tipo_pago">
                                        <span >
                                            <small class="help-block error-span" id="error-tipo_pago_mensaje" ></small>                                
                                        </span>
                                    </div>

                                   <div class="clearfix p-b-35"></div>

                                        <div class="form-group">
                                            <label for="monto" id="id-monto">Monto</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el monto a pagar por comisión" title="" data-original-title="Ayuda"></i>
                                            
                                          <div class="input-group">
                                            <span class="input-group-addon"><i class="icon_b icon_b-costo f-22"></i></span>
                                            <div class="fg-line">
                                            <input type="text" class="form-control input-sm input-mask" name="monto" id="monto" placeholder="Ej. 10" maxlength="2" size="2">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="has-error" id="error-monto">
                                          <span >
                                              <small id="error-monto_mensaje" class="help-block error-span" ></small>                                           
                                          </span>
                                        </div>

                                      <div class="clearfix p-b-35"></div>

                                      <div class="form-group">
                                            <label for="monto_minimo" id="id-monto_minimo">Monto Mínimo</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el monto mínimo que debe pagar para que la comisión se realice" title="" data-original-title="Ayuda"></i>
                                            
                                          <div class="input-group">
                                            <span class="input-group-addon"><i class="icon_b icon_b-costo f-22"></i></span>
                                            <div class="fg-line">
                                            <input type="text" class="form-control input-sm" name="monto_minimo" id="monto_minimo" placeholder="Ej. 2500">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="has-error" id="error-monto_minimo">
                                          <span >
                                              <small id="error-monto_minimo_mensaje" class="help-block error-span" ></small>                                           
                                          </span>
                                        </div>

                                        <div class="clearfix p-b-35"></div>

                                     
                                  <div class="card-header text-left">
                                  <button type="button" class="btn btn-blanco m-r-10 f-10" id="addpago" >Agregar Linea</button>
                                  </div>

                                  <br></br>

                                  <div class="table-responsive row">
                                     <div class="col-md-12">
                                      <table class="table table-striped table-bordered text-center " id="tablepagos" >
                                        <thead>
                                            <tr>
                                                
                                                <th class="text-center" data-column-id="servicio_producto">Servicio / Producto</th>
                                                <th class="text-center" data-column-id="tipo" data-type="numeric">Tipo</th>
                                                <th class="text-center" data-column-id="monto" data-type="numeric">Monto</th>
                                                <th class="text-center" data-column-id="monto_porcentaje" data-type="numeric">Monto Porcentaje</th>
                                                <th class="text-center" data-column-id="monto_porcentaje" data-type="numeric">Monto Mínimo</th>
                                                <th class="text-center" data-column-id="operaciones">Operaciones</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                        @foreach ($comisiones as $comision)
                                            <?php $id = $comision['id']; ?>
                                            <tr id="{{$id}}" class="seleccion">
                                                <td class="text-center">{{$comision['nombre']}}</td>
                                                <td class="text-center">

                                                @if($comision['tipo'] == 1)

                                                  Porcentaje
                                                @else

                                                  Tasa Fija

                                                @endif

        
                                                </td>
                                                <td class="text-center">

                                                  @if($comision['tipo'] == 1)

                                                    {{$comision['monto']}}%
                                                  @else

                                                    {{ number_format($comision['monto'], 2, '.' , '.') }}

                                                  @endif

                                                  

                                                </td>
                                                <td class="text-center">{{ number_format($comision['monto_porcentaje'], 2, '.' , '.') }}</td>
                                                <td class="text-center">{{ number_format($comision['monto_minimo'], 2, '.' , '.') }}</td>
                                                <td class="text-center"> <i class="zmdi zmdi-delete f-20 p-r-10"></i></td>
                                              </tr>
                                        @endforeach 
                                                                       
                                        </tbody>
                                      </table>

                                    </div>
                                  </div> <!-- TABLE RESPONSIVE -->
                                </div><!--  COL-SM-12 -->
                              </div><!-- ROW -->

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

                                  <a class="btn-blanco m-r-5 f-12 dismiss" href="#">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                                  <div class="clearfix p-b-35"></div>

                                </div>
                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
     
            <div class="modal fade" id="modalID-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Staff<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_id_alumno" id="edit_id_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Id - Pasaporte</label>
                                        <input type="text" class="form-control input-sm input-mask" name="identificacion" id="identificacion" data-mask="00000000000000000000" placeholder="Ej: 16133223" value="{{$alumno->identificacion}}">
                                    </div>
                                    <div class="has-error" id="error-identificacion">
                                      <span >
                                          <small id="error-identificacion_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$alumno->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_id_alumno" data-update="identificacion" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalNombre-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Staff<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_nombre_alumno" id="edit_nombre_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control input-sm" name="nombre" id="nombre" placeholder="Ej. Valeria">
                                 </div>
                                 <div class="has-error" id="error-nombre">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 


                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="apellido">Apellido</label>
                                    <input type="text" class="form-control input-sm" name="apellido" id="apellido" placeholder="Ej. Sánchez">
                                 </div>
                                 <div class="has-error" id="error-apellido">
                                      <span >
                                          <small class="help-block error-span" id="error-apellido_mensaje"  ></small>                                           
                                      </span>
                                  </div>
                               </div>

                               <input type="hidden" name="id" value="{{$alumno->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_nombre_alumno" data-update="nombre" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalFechaNacimiento-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Staff<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_fecha_nacimiento_alumno" id="edit_fecha_nacimiento_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group fg-line">
                                    <label for="apellido">Fecha de Nacimiento</label>
                                            <div class="dtp-container fg-line">
                                            <input name="fecha_nacimiento" id="fecha_nacimiento" class="form-control date-picker pointer" placeholder="Seleciona" type="text">
                                        </div>
                                    </div>
                                    <div class="has-error" id="error-fecha_nacimiento">
                                      <span >
                                          <small class="help-block error-span" id="error-fecha_nacimiento_mensaje" ></small>                                           
                                      </span>
                                 </div>
                               </div>

                               <input type="hidden" name="id" value="{{$alumno->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_fecha_nacimiento_alumno" data-update="fecha_nacimiento" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalSexo-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Staff<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_sexo_alumno" id="edit_sexo_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group fg-line ">
                                    <label for="sexo p-t-10">Sexo</label>
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="sexo" id="mujer" value="F" type="radio">
                                        <i class="input-helper"></i>  
                                        Mujer <i class="zmdi zmdi-female p-l-5 f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="sexo" id="hombre" value="M" type="radio">
                                        <i class="input-helper"></i>  
                                        Hombre <i class="zmdi zmdi-male-alt p-l-5 f-20"></i>
                                    </label>
                                    </div>
                                    
                                 </div>
                                 <div class="has-error" id="error-sexo">
                                      <span >
                                          <small class="help-block error-span" id="error-sexo_mensaje" ></small>                                           
                                      </span>
                                  </div>
                               </div>

                               <input type="hidden" name="id" value="{{$alumno->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_sexo_alumno" data-update="sexo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>
                             
                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalCorreo-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Alumno<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_correo_alumno" id="edit_correo_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="correo">Correo</label>
                                    <input type="text" class="form-control input-sm" name="correo" id="correo" placeholder="Ej. example@correo.com">
                                 </div>
                                 <div class="has-error" id="error-correo">
                                      <span >
                                          <small class="help-block error-span" id="error-correo_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 

                               <input type="hidden" name="id" value="{{$alumno->id}}"></input>

                               
                               
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_correo_alumno" data-update="correo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalTelefono-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Staff<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_telefono_alumno" id="edit_telefono_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="telefono">Telefono Local</label>
                                    <input type="text" class="form-control input-sm input-mask" name="telefono" id="telefono" data-mask="(000)000-0000" placeholder="Ej: (426)367-0894">
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
                                    <label for="celular">Telefono Celular</label>
                                    <input type="text" class="form-control input-sm input-mask" name="celular" id="celular" data-mask="(000)000-0000" placeholder="Ej: (426)367-0894">
                                 </div>
                                 <div class="has-error" id="error-celular">
                                      <span >
                                          <small class="help-block error-span" id="error-celular_mensaje"  ></small>                                           
                                      </span>
                                  </div>
                               </div>

                               <input type="hidden" name="id" value="{{$alumno->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_telefono_alumno" data-update="telefono" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalDireccion-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Staff<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_direccion_alumno" id="edit_direccion_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="correo">Dirección</label>
                                    <input type="text" class="form-control input-sm" name="direccion" id="direccion" placeholder="Ej. Avenida 10 con Calle 70" maxlength="180" onkeyup="countChar(this)">
                                 </div>
                                 
                                 <div class="opaco-0-8 text-right">Resta <span id="charNum">180</span> Caracteres</div>
                                 <div class="has-error" id="error-direccion">
                                      <span >
                                          <small class="help-block error-span" id="error-direccion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                                     

                               <div class="clearfix"></div> 

                               <input type="hidden" name="id" value="{{$alumno->id}}"></input>

                               
                               
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_direccion_alumno" data-update="direccion" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalCargo-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Staff<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_cargo_alumno" id="edit_cargo_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Cargo</label>

                                      <div class="select">
                                          <select class="form-control" id="cargo" name="cargo">
                                          @foreach ( $config_staff as $cargo )
                                          <option value = "{{ $cargo->id }}">{{ $cargo->nombre }} </option>
                                          @endforeach 
                                          </select>
                                      </div> 

                                 </div>
                                 <div class="has-error" id="error-cargo">
                                      <span >
                                          <small class="help-block error-span" id="error-cargo_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>


                               <input type="hidden" name="id" value="{{$alumno->id}}"></input>
                            

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_cargo_alumno" data-update="cargo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalMultihorario-Alumno" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Staff<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="form_multihorario" id="form_multihorario"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                           <div class="col-sm-12">
                           <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                    <label for="fecha_inicio">Día de semana</label>
                                    <div class="select">
                                          <select class="form-control" id="dia_de_semana_id" name="dia_de_semana_id">
                                          @foreach ( $dias_de_semana as $dia )
                                          <option value = "{{ $dia->id}}">{{ $dia->nombre }}</option>
                                          @endforeach 
                                          </select>
                                      </div> 
                                    </div>
                                    <div class="has-error" id="error-dia_de_semana_id">
                                      <span >
                                          <small id="error-dia_de_semana_id_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                                <div class="clearfix p-b-15"></div>

                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="telefono">Hora de Inicio</label>
                                    <input type="text" class="form-control time-picker input-sm" name="hora_inicio" id="hora_inicio" placeholder="Ej. 00:00">
                                 </div>
                                  <div class="has-error" id="error-hora_inicio">
                                      <span >
                                          <small class="help-block error-span" id="error-hora_inicio_mensaje" ></small>                                
                                      </span>
                                  </div>

                                   <div class="clearfix p-b-15"></div>

                                 <div class="form-group fg-line">
                                    <label for="telefono">Hora Final</label>
                                    <input type="text" class="form-control time-picker input-sm" name="hora_final" id="hora_final" placeholder="Ej. 00:00">
                                 </div>                                 
                                 <div class="has-error" id="error-hora_final">
                                      <span >
                                          <small class="help-block error-span" id="error-hora_final_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               

                              <div class="card-header text-left">
                              <div class="clearfix p-b-15"></div>
                              <button type="button" class="btn btn-blanco m-r-10 f-10" id="add" name="add" >Agregar Linea</button>
                              </div>

                             <div class="clearfix p-b-15"></div>

                               <div class="table-responsive row">
                                   <div class="col-md-12">
                                    <table class="table table-striped table-bordered text-center " id="tablelistar" >
                                    <thead>
                                        <tr>
                                          <th class="text-center" data-column-id="nombre" data-order="desc">Día</th>
                                          <th class="text-center" data-column-id="estatu_c" data-order="desc">Hora Inicio</th>
                                          <th class="text-center" data-column-id="estatu_e" data-order="desc">Hora Final</th>
                                          <th class="text-center" data-column-id="operacion" data-order="desc" >Acción</th>
                                      </tr>
                                    </thead>
                                    <tbody>

                                      @foreach($horarios as $horario)
                                      
                                        <tr id="{{$horario['id']}}" class="odd seleccion text-center" role="row">
                                          <td class="text-center">
                                            {{$horario->dia}}
                                          </td>
                                          <td class="text-center">
                                            {{$horario->hora_inicio}}
                                          </td>
                                          <td class="text-center">
                                            {{$horario->hora_final}}
                                          </td>

                                          <td class="text-center" width="50">
                                          <i class="zmdi zmdi-delete f-20 p-r-10"></i>
                                          </td>
                                        </tr>

                                      @endforeach                          
                                                                   
                                    </tbody>
                                </table>
                                 </div>
                                </div>
                                </div>


                               <input type="hidden" name="id" value="{{$alumno->id}}"></input>


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

                              <a class="btn-blanco m-r-5 f-12 dismiss" href="#">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                            
                        </div></form>
                    </div>
                </div>
            </div>


            <section id="content">
                <div class="container">
                


                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/configuracion/staff"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
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
                                  <ul class="ca-menu-planilla">
                                    <li>
                                        <a href="#" class="mousehand disabled">
                                            <span class="ca-icon-planilla"><i class="icon_f-staff"></i></span>
                                            <div class="ca-content-planilla">
                                                <h2 class="ca-main-planilla">Vista Staff</h2>
                                                <h3 class="ca-sub-planilla">Personaliza el campo staff</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>

                                  <div class="col-sm-12 text-center"> 

                                    <br>
                                    <span class="f-16 f-700">Acciones</span>

                                    <hr></hr>
                                    
      
                                    <a href="{{url('/')}}/configuracion/staff/pagos/{{$alumno->id}}"><i class="zmdi zmdi-money f-20 m-r-5 boton blue sa-warning" data-original-title="Pagos" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                    <a href="{{url('/')}}/incidencias/generar/{{$id}}"><i class="icon_f-incidencias f-20 m-r-5 boton blue sa-warning" data-original-title="Incidencia" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                    <i class="zmdi zmdi-delete f-20 m-r-10 boton red sa-warning" id="{{$alumno->id}}" name="eliminar" data-original-title="Eliminar" data-toggle="tooltip" data-placement="bottom" title=""></i>

                                    <br></br>
                                </div>

          					            </div>                
          					          </div> 
          					      </div>
					           </div>

					           	<div class="col-sm-9">

                         <div class="col-sm-12">
                              <p class="text-center opaco-0-8 f-22">Datos del Staff</p>
                          </div>

                          <div class="col-sm-12">
                           <table class="table table-striped table-bordered">
                            <tr class="detalle" data-toggle="modal" href="#modalID-Alumno">
                             <td width="50%"> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-identificacion" class="zmdi {{ empty($alumno->identificacion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>                      
                              <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-account-box f-22"></i> </span>
                              <span class="f-14">Id / pasaporte </span>
                             </td>
                             <td class="f-14 m-l-15" id="alumno-identificacion">{{$alumno->identificacion}}<span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalNombre-Alumno">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-nombre" class="zmdi {{ empty($alumno->nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-accounts-alt f-22"></i> </span>
                               <span class="f-14"> Nombres </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="alumno-nombre" class="capitalize">{{$alumno->nombre}}</span> <span id="alumno-apellido" class="capitalize">{{$alumno->apellido}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalFechaNacimiento-Alumno">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-fecha_nacimiento" class="zmdi {{ empty($alumno->fecha_nacimiento) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-calendar-check f-22"></i> </span>
                               <span class="f-14"> Fecha de nacimiento  </span>
                             </td>
                             <td  class="f-14 m-l-15" id="alumno-fecha_nacimiento" >{{ \Carbon\Carbon::createFromFormat('Y-m-d',$alumno->fecha_nacimiento)->format('d/m/Y')}}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                             <tr class="detalle" data-toggle="modal" href="#modalSexo-Alumno">
                             <td> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-sexo" class="zmdi {{ empty($alumno->sexo) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                              <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-male-female f-22"></i> </span>
                              <span class="f-14"> Sexo </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="alumno-sexo" data-valor="{{$alumno->sexo}}">
                               @if($alumno->sexo=='F')
                                  <i class="zmdi zmdi-female f-25 c-rosado"></i> </span>
                               @else
                                  <i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>
                               @endif
                             </span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalCorreo-Alumno">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-correo" class="zmdi {{ empty($alumno->correo) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-correo f-22"></i> </span>
                               <span class="f-14"> Correo </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="alumno-correo"><span>{{$alumno->correo}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr id ="tr_contacto" class="detalle" data-toggle="modal" href="#modalTelefono-Alumno" data-valor="{{$alumno->celular}}">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-telefono" class="zmdi {{ empty($alumno->telefono) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b icon_b-telefono f-22"></i> </span>
                               <span class="f-14"> Contacto </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="alumno-telefono">{{$alumno->telefono}}</span> / <span id="alumno-celular">{{$alumno->celular}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalDireccion-Alumno">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-direccion" class="zmdi {{ empty($alumno->direccion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-pin-drop zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Dirección </span>
                             </td>
                             <td id="alumno-direccion" class="f-14 m-l-15 capitalize" data-valor="{{$alumno->direccion}}" >{{ str_limit($alumno->direccion, $limit = 30, $end = '...') }} <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalCargo-Alumno">
                             <td width="50%"> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-cargo" class="zmdi {{ empty($alumno->cargo) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>                      
                              <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-account-box f-22"></i> </span>
                              <span class="f-14">Cargo </span>
                             </td>
                             <td class="f-14 m-l-15" id="alumno-cargo">{{$alumno->cargo}}<span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalMultihorario-Alumno">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-horario" class="zmdi  {{ empty($horarios) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw""></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-alarm f-22"></i> </span>
                               <span class="f-14"> Horario </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="alumno-horario"></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" id="modalPe" href="#modalPago">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-pago" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-pagar f-22"></i> </span>
                               <span class="f-14">Comisiones</span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="instructor-pago"></span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
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
    route_update="{{url('/')}}/configuracion/staff/update";
    route_eliminar="{{url('/')}}/configuracion/staff/eliminar/";
    route_principal="{{url('/')}}/configuracion/staff";
    route_email="{{url('/')}}/correo/sesion/";
    route_eliminarhorario="{{url('/')}}/configuracion/staff/eliminarhorariofijo";
    route_agregarhorario="{{url('/')}}/configuracion/staff/agregarhorariofijo/";

    route_agregar_pago="{{url('/')}}/configuracion/staff/agregarpagofijo";
    route_eliminar_pago="{{url('/')}}/configuracion/staff/eliminarpagofijo/";

    var linea_servicio = <?php echo json_encode($linea_servicio);?>;

    $(document).ready(function(){

      if($('#tr_contacto').data('valor') != ''){
        $("#estatus-telefono").removeClass('c-amarillo zmdi-dot-circle');
        $("#estatus-telefono").addClass('c-verde zmdi-check');
      }


      $('#nombre').mask('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', {'translation': {

        A: {pattern: /[A-Za-záéíóúÁÉÍÓÚ.,@*+_ñÑ ]/}
        }

      });

      $('#apellido').mask('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', {'translation': {

        A: {pattern: /[A-Za-záéíóúÁÉÍÓÚ.,@*+_ñÑ ]/}
        }

      });

      $('#monto_minimo').mask('000,000,000,000', {reverse: true});

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

    $('#modalID-Alumno').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#identificacion").val($("#alumno-identificacion").text()); 
    })
    $('#modalNombre-Alumno').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#nombre").val($("#alumno-nombre").text()); 
      $("#apellido").val($("#alumno-apellido").text());
    })
    $('#modalFechaNacimiento-Alumno').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#fecha_nacimiento").val($("#alumno-fecha_nacimiento").text()); 
    })
    $('#modalSexo-Alumno').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var sexo=$("#alumno-sexo").data('valor');
      if(sexo=="M"){
        $("#hombre").prop("checked", true);
      }else{
        $("#mujer").prop("checked", true);
      }
    })

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
       var direccion=$("#alumno-direccion").data('valor');
       $("#direccion").val(direccion);
      //$("#direccion").val($("#alumno-direccion").text());
    })

    $('#modalHorario-Alumno').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#hora_inicio").val($("#alumno-hora_inicio").text());
      $("#hora_final").val($("#alumno-hora_final").text());
    })

    $('.modal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $('#form_pago')[0].reset();
      $('#tipo_servicio').selectpicker('refresh')
      $('#tipo_id').selectpicker('refresh')

    })

    function limpiarMensaje(){
        var campo = ["identificacion", "nombre", "apellido", "fecha_nacimiento", "sexo", "correo", "telefono", "celular", "direccion", "cargo", "hora_inicio", "hora_final", "monto", "monto_minimo"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
        console.log(merror);
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
              var valor='<i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>';                              
            }else if(c.value=='F'){
              var valor='<i class="zmdi zmdi-female f-25 c-rosado"></i> </span>';
            }
            $("#alumno-"+c.name).data('valor',c.value);
            $("#alumno-"+c.name).html(valor);
          }else if(c.name=='direccion'){
             $("#alumno-"+c.name).data('valor',c.value);
             $("#alumno-"+c.name).html(c.value.toLowerCase().substr(0, 30) + "...");
            //$("#alumno-"+c.name).text(c.value.substr(0, 30));
          }else if(c.name=='cargo'){
            
            expresion = "#"+c.name+ " option[value="+c.value+"]";
            texto = $(expresion).text();

             $("#alumno-"+c.name).text(texto);
            //$("#alumno-"+c.name).text(c.value.substr(0, 30));
          }else{

            $("#alumno-"+c.name).text(c.value.toLowerCase());
            
          }
          if(c.value == ''){
            $("#estatus-"+c.name).removeClass('c-verde zmdi-check');
            $("#estatus-"+c.name).addClass('c-amarillo zmdi-dot-circle');
          }
          else{
            $("#estatus-"+c.name).removeClass('c-amarillo zmdi-dot-circle');
            $("#estatus-"+c.name).addClass('c-verde zmdi-check');
          }

          if(c.name == 'celular'){
            $('#tr_contacto').data('valor') == c.value;
          }

          if(c.name == 'celular' && $('#tr_contacto').data('valor') != ''){
            $("#estatus-telefono").removeClass('c-amarillo zmdi-dot-circle');
            $("#estatus-telefono").addClass('c-verde zmdi-check');
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
        //$(this).data('formulario');
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
       
    })

    $(".email").click(function(){
         var route = route_email + 5;
         var token = '{{ csrf_token() }}';
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    success:function(respuesta){

                        procesando();
                        window.location="{{url('/')}}/correo/{{$id}}"  

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
      });

    $("i[name=eliminar]").click(function(){
                id = this.id;
                swal({   
                    title: "Desea eliminar al staff?",   
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
                        // swal("Done!","It was succesfully deleted!","success");
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
                        eliminar(id);
          }
                });
      });

      function eliminar(id){
         var route = route_eliminar + id;
         var token = '{{ csrf_token() }}';
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'DELETE',
                    dataType: 'json',
                    data:id,
                    success:function(respuesta){

                        procesando();
                        window.open(route, '_blank');_principal; 

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

      function countChar(val) {
        var len = val.value.length;
        if (len >= 180) {
          val.value = val.value.substring(0, 180);
        } else {
          $('#charNum').text(180 - len);
        }
      };

      $("#add").click(function(){

                $("#add").attr("disabled","disabled");
                $("#add").css({
                    "opacity": ("0.2")
                }); 

                var route = route_agregarhorario;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#form_multihorario" ).serialize(); 

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

                          $("#add").removeAttr("disabled");
                          $("#add").css({
                              "opacity": ("1")
                          });

                          $("#form_multihorario")[0].reset();

                          var nType = 'success';
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;

                          var dia_de_semana_id = respuesta.array.dia_de_semana;
                          var hora_inicio = respuesta.array.hora_inicio;
                          var hora_final = respuesta.array.hora_final;

                          var rowId=respuesta.id;
                          var rowNode=t.row.add( [
                          ''+dia_de_semana_id+'',
                          ''+hora_inicio+'',
                          ''+hora_final+'',
                          '<i class="zmdi zmdi-delete f-20 p-r-10"></i>'
                          ] ).draw(false).node();
                          $( rowNode )
                          .attr('id',rowId)
                          .addClass('seleccion');

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
                        }else{
                          var nTitle="   Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }   
                        $("#add").removeAttr("disabled");
                        $("#add").css({
                          "opacity": ("1")
                        });                     
  
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

  $('#tablelistar tbody').on( 'click', 'i.zmdi-delete', function () {
        var padre=$(this).parents('tr');
        var token = $('input:hidden[name=_token]').val();
        var id = $(this).closest('tr').attr('id');
              $.ajax({
                   url: route_eliminarhorario+"/"+id,
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


  var t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,
        bPaginate: false, 
        bFilter:false, 
        bSort:false, 
        bInfo:false,
        order: [[0, 'asc']],
        fnDrawCallback: function() {
          $('.dataTables_paginate').hide();
        },
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
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

  var h=$('#tablepagos').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,
        bPaginate: false, 
        bFilter:false, 
        bSort:false, 
        bInfo:false,
        order: [[0, 'asc']],
        fnDrawCallback: function() {
          $('.dataTables_paginate').hide();
        },
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
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

    $("#addpago").click(function(){


      $("#addpago").attr("disabled","disabled");
        $("#addpago").css({
          "opacity": ("0.2")
        });

      var route = route_agregar_pago;
      var token = $('input:hidden[name=_token]').val();
      var datos = $( "#form_pago" ).serialize(); 
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
                $("#form_pago")[0].reset();

                $.each(respuesta.array, function (index, array) {

                  monto_minimo = formatmoney(parseFloat(array.monto_minimo));

                  if(array.tipo == 1){
                    tipo = 'Porcentaje'
                    monto = array.monto+"%"
                    monto_porcentaje = formatmoney(parseFloat(array.monto_porcentaje));
                  }else{
                    tipo = 'Tasa Fija'
                    monto = formatmoney(parseFloat(array.monto))
                    monto_porcentaje = 0
                  }

                  var rowId=array.id;
                  var rowNode=h.row.add( [
                  ''+array.nombre+'',
                  ''+tipo+'',
                  ''+monto+'',
                  ''+monto_porcentaje+'',
                  ''+monto_minimo+'',
                  '<i class="zmdi zmdi-delete f-20 p-r-10"></i>'
                  ] ).draw(false).node();
                  $( rowNode )
                  .attr('id',rowId)
                  .attr('data-tipo_servicio',array.tipo_servicio)
                  .addClass('seleccion');

                  // $("#tipo_id option[value='"+array.servicio_id+"-"+array.tipo_servicio+"']").attr("disabled","disabled");
                  // $("#tipo_id option[value='"+array.servicio_id+"-"+array.tipo_servicio+"']").data("icon","glyphicon-remove");

                  

                });

                // $('#tipo_id').val('');
                // $('#tipo_id').selectpicker('refresh');
                

              }else{
                var nTitle="Ups! ";
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                var nType = 'danger';
              }                       
              $("#addpago").removeAttr("disabled");
                $("#addpago").css({
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
              if(msj.responseJSON.status=="ERROR"){
                console.log(msj.responseJSON.errores);
                errores(msj.responseJSON.errores);
                var nTitle="    Ups! "; 
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
              }else{
                var nTitle="   Ups! "; 
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              }
              $("#addpago").removeAttr("disabled");
                $("#addpago").css({
                  "opacity": ("1")
                });                        
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

  $('#tablepagos tbody').on( 'click', 'i.zmdi-delete', function () {

                var id = $(this).closest('tr').attr('id');
                element = this;

                swal({   
                    title: "Desea eliminar esta configuración?",   
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
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
                        eliminar_pago(id, element);
          }
                });
  });
      
        function eliminar_pago(id, element){
         var route = route_eliminar_pago + id;
         var token = "{{ csrf_token() }}";
         procesando();
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'DELETE',
                    dataType: 'json',
                    data:id,
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

                          // $("#tipo_id option[value='"+respuesta.id+"']").removeAttr("disabled");
                          // $("#tipo_id option[value='"+respuesta.id+"']").data("icon","");

                          // $('#tipo_id').selectpicker('refresh');

                          h.row( $(element).parents('tr') )
                            .remove()
                            .draw();

                          swal("Exito!","La configuración ha sido eliminada!","success");
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

    $(".dismiss").click(function(){
      procesando();
      setTimeout(function(){ 
        var nFrom = $(this).attr('data-from');
        var nAlign = $(this).attr('data-align');
        var nIcons = $(this).attr('data-icon');
        var nAnimIn = "animated flipInY";
        var nAnimOut = "animated flipOutY"; 
        var nType = 'success';
        var nTitle="Ups! ";
        var nMensaje="¡Excelente! Los campos se han guardado satisfactoriamente";
        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
        finprocesado();
        $('.modal').modal('hide');
      }, 2000);
    });

    $('#tipo_servicio').on('change', function(){

      $('#tipo_id').val('')
      options = $('#tipo_id option');
      id = $(this).val();
      $('#detalle_boton').text('Pulsa Aqui')
      $('#dropdown_principal').empty();

      if(id != 0){
        $.each(options, function (index, array) {  
          tmp = array.value
          tmp2 =  tmp.split('-')
          value = tmp2[0]
          tipo = tmp2[1]
          option = $("#tipo_id option[value='"+array.value+"']")

          if(id == 99){

            not_in = [1,2,3,4,9,5,11,14]
            if(!$.inArray(tipo, not_in)){
                option.show();
            }else{  
                option.hide();
            } 

          }else{

            if(id != 3){


              if(tipo == id){
                  option.show();
              }else{  
                  option.hide();
              }  

            }else{    

              if(tipo == 3 || tipo == 4){
                  option.show();
              }else{  
                  option.hide();
              }  
            }          
          }
        });
      }else{
        options.show();
      }

      if(id == 99){

        contenido = '';

        contenido += '<li class="dropdown-submenu pointer" data-tipo_dropdown="1" data-tipo_servicio="3" data-nombre_servicio="Clases Grupales" data-servicio_producto_id ="3">'
        contenido += '<a>Clases Grupales</a>'
        contenido += '<ul class="dropdown-menu">'

        $.each(linea_servicio, function (index, array) {  
            if(array.tipo == 3 || array.tipo == 4){
                contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-tipo_servicio="'+array.tipo+'" data-nombre_servicio="'+array.nombre+'" data-servicio_producto_id="'+array.id+'"><a>'+array.nombre+'</a></li>'
            }                   
        });

        contenido += '</ul></li>'

        $('#dropdown_principal').append(contenido);

        contenido = '';
    
        contenido += '<li class="dropdown-submenu pointer" data-tipo_dropdown="1" data-tipo_servicio="9" data-nombre_servicio="Clases Personalizadas" data-servicio_producto_id ="9">'
        contenido += '<a>Clases Personalizadas</a>'
        contenido += '<ul class="dropdown-menu">'

        $.each(linea_servicio, function (index, array) {  
            if(array.tipo == 9){
                contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-tipo_servicio="'+array.tipo+'" data-nombre_servicio="'+array.nombre+'" data-servicio_producto_id="'+array.id+'"><a>'+array.nombre+'</a></li>'
            }                   
        });

        contenido += '</ul></li>'

        $('#dropdown_principal').append(contenido);

        contenido = '';

        contenido += '<li class="dropdown-submenu pointer" data-tipo_dropdown="1" data-tipo_servicio="2" data-nombre_servicio="Productos" data-servicio_producto_id ="2">'
        contenido += '<a>Productos</a>'
        contenido += '<ul class="dropdown-menu">'

        $.each(linea_servicio, function (index, array) {  
            if(array.tipo == 2){
                contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-tipo_servicio="'+array.tipo+'" data-nombre_servicio="'+array.nombre+'" data-servicio_producto_id="'+array.id+'"><a>'+array.nombre+'</a></li>'
            }                   
        });

        contenido += '</ul></li>'

        $('#dropdown_principal').append(contenido);

        contenido = '';

        contenido += '<li class="dropdown-submenu pointer" data-tipo_dropdown="1" data-tipo_servicio="1" data-nombre_servicio="Servicios" data-servicio_producto_id ="1">'
        contenido += '<a>Servicios</a>'
        contenido += '<ul class="dropdown-menu">'

        $.each(linea_servicio, function (index, array) {  
            if(array.tipo == 1){
                contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-tipo_servicio="'+array.tipo+'" data-nombre_servicio="'+array.nombre+'" data-servicio_producto_id="'+array.id+'"><a>'+array.nombre+'</a></li>'
            }                   
        });

        contenido += '</ul></li>'

        $('#dropdown_principal').append(contenido);

        contenido = '';

        contenido += '<li class="dropdown-submenu pointer" data-tipo_dropdown="1" data-tipo_servicio="15" data-nombre_servicio="Paquetes" data-servicio_producto_id ="15">'
        contenido += '<a>Paquetes</a>'
        contenido += '<ul class="dropdown-menu">'

        $.each(linea_servicio, function (index, array) {  
            if(array.tipo == 15){
                contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-tipo_servicio="'+array.tipo+'" data-nombre_servicio="'+array.nombre+'" data-servicio_producto_id="'+array.id+'"><a>'+array.nombre+'</a></li>'
            }                   
        });

        contenido += '</ul></li>'

        $('#dropdown_principal').append(contenido);

        contenido = '';
    

      }else if(id == 14){
          
        $.each(linea_servicio, function (index, array) {  

            if(array.tipo == 14){

                contenido = '';

                contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-tipo_servicio="'+array.tipo+'" data-nombre_servicio="'+array.nombre+'" data-servicio_producto_id="'+array.id+'"><a>'+array.nombre+'</a></li>';

                $('#dropdown_principal').append(contenido);

            }                   
        });
          
      }else if(id == 5){

        $.each(linea_servicio, function (index, array) {  

            if(array.tipo == 5){

                contenido = '';

                contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-tipo_servicio="'+array.tipo+'" data-nombre_servicio="'+array.nombre+'" data-servicio_producto_id="'+array.id+'"><a>'+array.nombre+'</a></li>';

                $('#dropdown_principal').append(contenido);

            }                   
        });
      }else if(id == 11){

        $.each(linea_servicio, function (index, array) {  

            if(array.tipo == 11){

                contenido = '';

                contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-tipo_servicio="'+array.tipo+'" data-nombre_servicio="'+array.nombre+'" data-servicio_producto_id="'+array.id+'"><a>'+array.nombre+'</a></li>';

                $('#dropdown_principal').append(contenido);

            }                   
        });
      }

      $('#tipo_id').selectpicker('refresh');
    });

    $('body').on('click','.servicio_detalle',function(e){
        
      $('#servicio_producto_id').val($(this).data('servicio_producto_id'))
      nombre_servicio = $(this).data('nombre_servicio')
      $('#detalle_boton').text(nombre_servicio)

      $('#dropdown_boton').removeClass('open')
      $('#detalle_boton').attr('aria-expanded',false);
    });

    function formatmoney(n) {
      return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    } 

    $('input[name=tipo_pago]').on('change', function(){
      if($(this).val() == 1){
        $('#monto').mask('00', {reverse: true});
        $('#monto').attr("placeholder", "Ej. 10");
      }else{
        $('#monto').mask('000,000,000,000', {reverse: true});
        $('#monto').attr("placeholder", "Ej. 5000");
      }
    });

   </script> 
		
@stop
