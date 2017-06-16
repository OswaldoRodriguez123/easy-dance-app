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
                          <div class="modal-body">                           
                            <div class="row p-t-20 p-b-0">

                              <div class="col-sm-12">
                                  <div class="form-group fg-line ">
                                    <label for="sexo p-t-10">Tipo</label>
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="pagos_comisiones" id="pagos2" value="1" type="radio" checked>
                                        <i class="input-helper"></i>  
                                        Pagos
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="pagos_comisiones" id="comisiones2" value="2" type="radio">
                                        <i class="input-helper"></i>  
                                        Comisiones
                                    </label>
                                    </div>
                                    
                                  </div>
                                </div>
                               
                              <div class="col-sm-12" id="pagos">
                                <form name="form_pago" id="form_pago"  >
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                  <input type="hidden" name="id" value="{{ $instructor->id }}">
                                  <div class="clearfix p-b-35"></div>

                                    <label for="clase_grupal_id" id="id-clase_grupal_id">Ingresa la clase</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="El título para esta recompensa es lo que aparecerá en tu página de la campaña de Easy Dance . Crear un título que describa bien el contenido de lo que ofrece esta recompensa" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a icon_a-estudio-salon f-22"></i></span>
                                      <div class="fg-line">
                                          <div class="select">
                                            <select class="selectpicker bs-select-hidden" id="clase_grupal_id" name="clase_grupal_id" multiple="" data-max-options="5" title="Todas">

                                             @foreach ( $clases_grupales as $clase_grupal )
                                              <?php $exist = false; ?>
                                              @foreach ( $pagos_instructor as $pagos)
                                                @if ($pagos->clase_grupal_id==$clase_grupal['id'] )
                                                  <?php $exist = true; ?>
                                                @endif
                                              @endforeach
                                              @if ($exist)

                                                  <option value = "{{ $clase_grupal['id'] }}" disabled="" data-icon="glyphicon-remove"> {{ $clase_grupal['clase_grupal_nombre'] }} - {{ $clase_grupal['hora_inicio'] }}  / {{ $clase_grupal['hora_final'] }} - {{ $clase_grupal['dia'] }}</option>
                                              @else
                                                  <option value = "{{ $clase_grupal['id'] }}"> {{ $clase_grupal['clase_grupal_nombre'] }} - {{ $clase_grupal['hora_inicio'] }}  / {{ $clase_grupal['hora_final'] }} - {{ $clase_grupal['dia'] }}</option>
                                              @endif
                                             @endforeach
                                            </select>
                                          </div>
                                    </div>
                                    </div>
                                     <div class="has-error" id="error-clase_grupal_id">
                                          <span >
                                              <small class="help-block error-span" id="error-clase_grupal_id_mensaje" ></small>                               
                                          </span>
                                      </div>

                                  <div class="clearfix p-b-35"></div>

                               
                                  <label for="apellido" id="id-tipo">Tipo</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el tipo de pago" title="" data-original-title="Ayuda"></i>

                                  <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                      <label class="radio radio-inline m-r-20">
                                          <input name="tipo_pago" id="monto" value="1" type="radio" checked>
                                          <i class="input-helper"></i>  
                                          Por Clase 
                                      </label>
                                      <label class="radio radio-inline m-r-20 ">
                                          <input name="tipo_pago" id="porcentaje" value="2" type="radio">
                                          <i class="input-helper"></i>  
                                          Mensual 
                                      </label>
                                  </div>
                                  </div>
                               <div class="has-error" id="error-tipo">
                                    <span >
                                        <small class="help-block error-span" id="error-tipo_mensaje" ></small>                                
                                    </span>
                                </div>

                               <div class="clearfix p-b-35"></div>

                                    <div class="form-group">
                                        <label for="cantidad" id="id-cantidad">Monto</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el monto a pagar por clase grupal" title="" data-original-title="Ayuda"></i>
                                        
                                      <div class="input-group">
                                        <span class="input-group-addon"><i class="icon_b icon_b-costo f-22"></i></span>
                                        <div class="fg-line">
                                        <input type="text" class="form-control input-sm input-mask" name="cantidad" id="cantidad" data-mask="00000000" placeholder="Ej. 5000">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-cantidad">
                                      <span >
                                          <small id="error-cantidad_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>

                                  <div class="clearfix p-b-35"></div>

                                 
                              <div class="card-header text-left">
                              <button type="button" class="btn btn-blanco m-r-10 f-10" id="add" >Agregar Linea</button>
                              </div>

                              <br></br>

                              <div class="table-responsive row">
                                 <div class="col-md-12">
                                  <table class="table table-striped table-bordered text-center " id="tablepagos" >
                                    <thead>
                                        <tr>
                                            
                                            <th class="text-center" data-column-id="clase_grupal">Clase Grupal</th>
                                            <th class="text-center" data-column-id="tipo" data-type="numeric">Tipo</th>
                                            <th class="text-center" data-column-id="monto" data-type="numeric">Monto</th>
                                            <th class="text-center" data-column-id="operaciones">Operaciones</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($pagos_instructor as $pagos)
                                        <?php $id = $pagos->id; ?>
                                        <tr id="{{$id}}" class="seleccion" >
                                            <td class="text-center">{{$pagos->nombre}}</td>
                                            <td class="text-center">

                                            @if($pagos->tipo == 1)

                                              Por Clase
                                            @else

                                              Mensual

                                            @endif

    
                                            </td>
                                            <td class="text-center">{{$pagos->monto}}</td>
                                            <td class="text-center"> <i class="zmdi zmdi-delete f-20 p-r-10"></i></td>
                                          </tr>
                                    @endforeach 
                                                                   
                                    </tbody>
                                  </table>

                                </div>
                              </div> <!-- TABLE RESPONSIVE -->
                              </form>
                            </div><!--  COL-SM-12 -->

                            <div class="col-sm-12" id="comisiones" style="display: none">
                              <form name="form_comision" id="form_comision"  >
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <input type="hidden" name="id" value="{{ $instructor->id }}">
                              <input type="hidden" id="servicio_producto_id" name="servicio_producto_id" value="">
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

                             
                                <label for="apellido" id="id-tipo">Tipo</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el tipo de pago" title="" data-original-title="Ayuda"></i>

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
                             <div class="has-error" id="error-tipo">
                                  <span >
                                      <small class="help-block error-span" id="error-tipo_mensaje" ></small>                                
                                  </span>
                              </div>

                             <div class="clearfix p-b-35"></div>

                                  <div class="form-group">
                                      <label for="cantidad" id="id-cantidad">Monto</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el monto a pagar por clase grupal" title="" data-original-title="Ayuda"></i>
                                      
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-costo f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="cantidad" id="cantidad" data-mask="000,000,000,000" data-mask-reverse="true" placeholder="Ej. 5000">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="has-error" id="error-cantidad">
                                    <span >
                                        <small id="error-cantidad_mensaje" class="help-block error-span" ></small>                                           
                                    </span>
                                  </div>

                                <div class="clearfix p-b-35"></div>

                               
                            <div class="card-header text-left">
                            <button type="button" class="btn btn-blanco m-r-10 f-10" id="addcomision" >Agregar Linea</button>
                            </div>

                            <br></br>

                            <div class="table-responsive row">
                               <div class="col-md-12">
                                <table class="table table-striped table-bordered text-center " id="tablecomisiones" >
                                  <thead>
                                      <tr>
                                          
                                          <th class="text-center" data-column-id="servicio_producto">Servicio / Producto</th>
                                          <th class="text-center" data-column-id="tipo" data-type="numeric">Tipo</th>
                                          <th class="text-center" data-column-id="monto" data-type="numeric">Monto</th>
                                          <th class="text-center" data-column-id="monto_porcentaje" data-type="numeric">Monto Porcentaje</th>
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
                                          <td class="text-center"> <i class="zmdi zmdi-delete f-20 p-r-10"></i></td>
                                        </tr>
                                  @endforeach 
                                                                 
                                  </tbody>
                                </table>

                              </div>
                            </div> <!-- TABLE RESPONSIVE -->
                            </form>
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
                    </div>
                </div>
            </div>
        </div>

     
            <div class="modal fade" id="modalID-Instructor" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Instructor<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_id_instructor" id="edit_id_instructor"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Id - Pasaporte</label>
                                        <input type="text" class="form-control input-sm" name="identificacion" id="identificacion" data-mask="00000000000000000000" placeholder="Ej. 16234987" value="{{$instructor->identificacion}}">
                                    </div>
                                    <div class="has-error" id="error-identificacion">
                                      <span >
                                          <small id="error-identificacion_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$instructor->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_id_instructor" data-update="identificacion" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalNombre-Instructor" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Instructor<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_nombre_instructor" id="edit_nombre_instructor"  >
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

                               <input type="hidden" name="id" value="{{$instructor->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_nombre_instructor" data-update="nombre" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalFechaNacimiento-Instructor" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Instructor<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_fecha_nacimiento_instructor" id="edit_fecha_nacimiento_instructor"  >
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

                               <input type="hidden" name="id" value="{{$instructor->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_fecha_nacimiento_instructor" data-update="fecha_nacimiento" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalSexo-Instructor" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Instructor<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_sexo_instructor" id="edit_sexo_instructor"  >
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

                               <input type="hidden" name="id" value="{{$instructor->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_sexo_instructor" data-update="sexo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>
                             
                            </div>
                        </div></form>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="modalCorreo-Instructor" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Instructor<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_correo_instructor" id="edit_correo_instructor"  >
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

                               <input type="hidden" name="id" value="{{$instructor->id}}"></input>

                               
                               
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_correo_instructor" data-update="correo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalTelefono-Instructor" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Instructor<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_telefono_instructor" id="edit_telefono_instructor"  >
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

                               <input type="hidden" name="id" value="{{$instructor->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_telefono_instructor" data-update="telefono" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalCredencial-Instructor" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Instructor<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_credencial_instructor" id="edit_credencial_instructor"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
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

                               <input type="hidden" name="id" value="{{$instructor->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_credencial_instructor" data-update="credencial" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalDireccion-Instructor" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Instructor<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_direccion_instructor" id="edit_direccion_instructor"  >
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

                               <input type="hidden" name="id" value="{{$instructor->id}}"></input>

                               
                               
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_direccion_instructor" data-update="direccion" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalFicha-Instructor" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Instructor<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_ficha_instructor" id="edit_ficha_instructor"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">

                           <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Alergia</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">
                                      
                                      <input type="text" id="alergia" name="alergia" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="alergia-switch" type="checkbox" hidden="hidden">
                                          <label for="alergia-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Asma</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="asma" name="asma" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="asma-switch" type="checkbox" hidden="hidden">
                                          <label for="asma-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Convulsiones</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="convulsiones" name="convulsiones" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="convulsiones-switch" type="checkbox" hidden="hidden">
                                          <label for="convulsiones-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Cefalea</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="cefalea" name="cefalea" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="cefalea-switch" type="checkbox" hidden="hidden">
                                          <label for="cefalea-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Hipertensión</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="hipertension" name="hipertension" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="hipertension-switch" type="checkbox" hidden="hidden">
                                          <label for="hipertension-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Lesiones</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="lesiones" name="lesiones" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="lesiones-switch" type="checkbox" hidden="hidden">
                                          <label for="lesiones-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>


                               <input type="hidden" name="id" value="{{$instructor->id}}"></input>
                              

                               <div class="clearfix"></div> 
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               
                               
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_ficha_instructor" data-update="ficha" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalEstatus-Instructor" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Instructor<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_estatus_instructor" id="edit_estatus_instructor"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group fg-line ">
                                    <label for="estatus p-t-10">Estatus</label>
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="estatus" id="activo" value="1" type="radio">
                                        <i class="input-helper"></i>  
                                        Activo
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="estatus" id="inactivo" value="0" type="radio">
                                        <i class="input-helper"></i>  
                                        Inactivo
                                    </label>
                                    </div>
                                    
                                 </div>
                                 <div class="has-error" id="error-estatus">
                                      <span >
                                          <small class="help-block error-span" id="error-estatus_mensaje" ></small>                                           
                                      </span>
                                  </div>
                               </div>

                               <input type="hidden" name="id" value="{{$instructor->id}}"></input>
                              

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
                            
                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_estatus_instructor" data-update="estatus" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>
                             
                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalRedes-Instructor" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Instructor<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_redes_instructor" id="edit_redes_instructor"  >
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
                                               <input type="text" class="form-control caja input-sm" name="facebook" id="facebook" placeholder="Ingresa la url" value="{{$instructor->facebook}}">
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
                                                  
                                                  <input type="text" class="form-control caja input-sm" name="twitter" id="twitter" placeholder="Ingresa la url" value="{{$instructor->twitter}}">
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
                                                  
                                                  <input type="text" class="form-control caja input-sm" name="instagram" id="instagram" placeholder="Ingresa la url" value="{{$instructor->instagram}}">
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
                                                  <input type="text" class="form-control caja input-sm" name="web" id="web" placeholder="Ej: www.easydancelatino.com" value="{{$instructor->pagina_web}}">
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
                                                  <input type="text" class="form-control caja input-sm" name="linkedin" id="linkedin" placeholder="Ingresa la url" value="{{$instructor->linkedin}}">
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
                                                  <input type="text" class="form-control caja input-sm" name="youtube" id="youtube" placeholder="Ingresa la url" value="{{$instructor->youtube}}">
                                              </div>
                                            </div>
                                              <div class="has-error" id="error-youtube">
                                                <span >
                                                    <small id="error-youtube_mensaje" class="help-block error-span" ></small>                                           
                                                </span>
                                              </div>
                                         </div>


                                        <input type="hidden" name="id" value="{{$instructor->id}}"></input>


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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_redes_instructor" data-update="redes" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalAvanzado-Instructor" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Instructor<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_avanzado_instructor" id="edit_avanzado_instructor"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                                <div class="col-sm-12">
                                    <label for="apellido" id="id-imagen">Imagen artística</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Carga una imagen horizontal  para que sea utilizada cuando compartes en Facebook.  Resolución recomendada: 1200 x 630, resolución mínima: 600 x 315" title="" data-original-title="Ayuda"></i>
                                    
                                    <div class="clearfix p-b-15"></div>
                                      
                                      <input type="hidden" name="imageBase64" id="imageBase64">
                                      <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div id="imagena" class="fileinput-preview thumbnail" data-trigger="fileinput" style="width:450px">
                                        @if($instructor->imagen_artistica)
                                          <img src="{{url('/')}}/assets/uploads/instructor/{{$instructor->imagen_artistica}}" style="line-height: 150px;">
                                        @endif</div>
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

                                  <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-descripcion">Perfil del instructor</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Describe tu perfil como instructor, habla de tu personalidad en el baile, ¿cómo iniciaste? en que te has especializado?   Porqué te gusta enseñar o bailar, cuéntales a tus clientes y público en general cuáles son tus fortalezas  al momento de enseñar o bailar" title="" data-original-title="Ayuda"></i>

                                    <br></br>

                                    <div class="fg-line">
                                      <textarea class="form-control caja" id="descripcion" name="descripcion" rows="8" placeholder="2000 Caracteres" style="height:100%" onkeyup="countChar2(this)">{{$instructor->descripcion}}</textarea>
                                    </div>
                                    <div class="opaco-0-8 text-right">Resta <span id="charNum2">2000</span> Caracteres</div>
                                 <div class="has-error" id="error-descripcion">
                                      <span >
                                          <small class="help-block error-span" id="error-descripcion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                  <label for="id" id="id-video_promocional">Ingresa url del video promocional</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa un video promocional de tus clases de baile como instructor o bailarín, esmérate en hacer una buena producción visual, de esa forma te ayudaremos a impulsar tu marca personal de mejor manera" title="" data-original-title="Ayuda"></i>
                                  
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                     <i class="zmdi zmdi-videocam f-20 c-morado"></i>
                                    </span>  

                                    <div class="fg-line">                       
                                      <input type="text" class="form-control caja input-sm" name="video_promocional" id="video_promocional" placeholder="Ingresa la url" value="{{$instructor->video_promocional}}">
                                    </div>
                                   </div>
                                   
                                   <div class="has-error" id="error-video_promocional">
                                    <span >
                                     <small id="error-video_promocional_mensaje" class="help-block error-span" ></small>                                           
                                    </span>
                                    </div>                                          
                                </div>

                              <div class="clearfix p-b-35"></div>

                              <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-resumen_artistico">Resumen artístico</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Describe tu perfil como instructor, habla de tu personalidad en el baile, ¿cómo iniciaste? en que te has especializado?   Porqué te gusta enseñar o bailar, cuéntales a tus clientes y público en general cuáles son tus fortalezas  al momento de enseñar o bailar" title="" data-original-title="Ayuda"></i>

                                    <br></br>

                                    <div class="fg-line">
                                      <textarea class="form-control caja" id="resumen_artistico" name="resumen_artistico" rows="8" style="height:100%" placeholder="2000 Caracteres" onkeyup="countChar3(this)">{{$instructor->resumen_artistico}}</textarea>
                                    </div>
                                    <div class="opaco-0-8 text-right">Resta <span id="charNum3">2000</span> Caracteres</div>
                                 <div class="has-error" id="error-resumen_artistico">
                                      <span >
                                          <small class="help-block error-span" id="error-resumen_artistico_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">
                                  <label for="id" id="id-video_testimonial">Ingresa url del video testimonial</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Haz un video promocional de tus alumnos , maestros , directores de academias ,personas influyentes , seguidores  entre otros , no mayor a 4  minutos , en el que ellos inviten  a seguir  tu trabajo. No olvides que la mejor publicidad proviene de las recomendaciones de terceros" title="" data-original-title="Ayuda"></i>
                                  
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                     <i class="zmdi zmdi-videocam f-20 c-morado"></i>
                                    </span>  

                                    <div class="fg-line">                       
                                      <input type="text" class="form-control caja input-sm" name="video_testimonial" id="video_testimonial" placeholder="Ingresa la url" value="{{$instructor->video_testimonial}}">
                                    </div>
                                   </div>
                                   
                                   <div class="has-error" id="error-video_testimonial">
                                    <span >
                                     <small id="error-video_testimonial_mensaje" class="help-block error-span" ></small>                                           
                                    </span>
                                    </div>                                          
                                </div>

                              <div class="clearfix p-b-35"></div>

                              <div class="col-sm-12">
                                       <div class="form-group fg-line ">
                                          <label for="">Promocionar en la web</label id="id-boolean_promocionar"> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Los clientes  podrán ver tu perfil como bailarín o instructor  al compartir las actividades en las res sociales" title="" data-original-title="Ayuda"></i>
                                          
                                          <br></br>
                                          <input type="text" id="boolean_promocionar" name="boolean_promocionar" value="" hidden="hidden">
                                          <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="promocionar" type="checkbox">
                                            
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                          </div>
                                          
                                       </div>
                                       <div class="has-error" id="error-boolean_promocionar">
                                            <span >
                                                <small class="help-block error-span" id="error-boolean_promocionar_mensaje" ></small>                                           
                                            </span>
                                        </div>
                                     </div>

                                     <div class="clearfix p-b-35"></div>

                                     <div class="col-sm-12">
                                       <div class="form-group fg-line ">
                                          <label for="">Permitir Reservar Clases Personalizadas</label id="id-boolean_disponibilidad"> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Los clientes  podrán ver tu perfil como bailarín o instructor  al compartir las actividades en las res sociales" title="" data-original-title="Ayuda"></i>
                                          
                                          <br></br>
                                          <input type="text" id="boolean_disponibilidad" name="boolean_disponibilidad" value="" hidden="hidden">
                                          <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="disponibilidad" type="checkbox">
                                            
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                          </div>
                                          
                                       </div>
                                       <div class="has-error" id="error-boolean_disponibilidad">
                                            <span >
                                                <small class="help-block error-span" id="error-boolean_disponibilidad_mensaje" ></small>                                           
                                            </span>
                                        </div>
                                     </div>

                                     <div class="clearfix p-b-35"></div>

                                     <div class="col-sm-12">
                                       <div class="form-group fg-line ">
                                          <label for="">Mostrar todas las clases grupales en el sistema</label id="id-boolean_disponibilidad"> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="El instructor al entrar en el sistema, podra administrar todas las clases grupales indistintamente sean de el o no" title="" data-original-title="Ayuda"></i>
                                          
                                          <br></br>
                                          <input type="text" id="boolean_administrador" name="boolean_administrador" value="" hidden="hidden">
                                          <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="administrador" type="checkbox">
                                            
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                          </div>
                                          
                                       </div>
                                       <div class="has-error" id="error-boolean_administrador">
                                            <span >
                                                <small class="help-block error-span" id="error-boolean_administrador_mensaje" ></small>                                           
                                            </span>
                                        </div>
                                     </div>


                               <input type="hidden" name="id" value="{{$instructor->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_avanzado_instructor" data-update="avanzado" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalImagen-Instructor" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Instructor<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_imagen_instructor" id="edit_imagen_instructor"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group text-center">
                                    <div class="form-group fg-line">
                                        <label for="id">Cargar Imagen</label>
                                        <div class="clearfix p-b-15"></div>
                                        <input type="hidden" name="imagePerfilBase64" id="imagePerfilBase64">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div id="imagenb" class="fileinput-preview thumbnail" data-trigger="fileinput">
                                          @if($instructor->imagen)
                                          <img src="{{url('/')}}/assets/uploads/instructor/{{$instructor->imagen}}" style="line-height: 150px;">
                                          @endif
                                        </div>
                                        <div>
                                            <span class="btn btn-info btn-file">
                                                <span class="fileinput-new">Seleccionar Imagen</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="imagen_perfil" id="imagen_perfil" >
                                            </span>
                                            <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="has-error" id="error-imagen_perfil">
                                      <span >
                                          <small id="error-imagen_perfil_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$instructor->id}}"></input>
                              

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

                              <a class="btn-morado m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_imagen_instructor" data-update="imagen" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>


            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                       <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/participante/instructor" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Instructor</a>
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

                      <div class="col-xs-12 text-left">
                          <ul class="tab-nav tn-justified" role="tablist">
                                    <li class="waves-effect active"><a href="{{url('/')}}/participante/instructor/detalle/{{$instructor->id}}" aria-controls="home11" onclick="procesando()"><div class="zmdi zmdi-account f-30"></div><p style="margin-top:10px">Perfil</p></a></li>
                                    <li class="waves-effect"><a href="{{url('/')}}/participante/instructor/experiencia/{{$instructor->id}}" aria-controls="home11" onclick="procesando()"><div class="icon_a-instructor f-30"></div><p style=" margin-bottom: -2px;">Experiencia como Instructor</p></a></li>
                                    
                            </ul>
                            </div>

                            <div class="clearfix p-b-15"></div>
                            
                        <a href="" class="pull-right">
                          @if($imagen)
                            <img id="foto_perfil" class="img-circle" src="{{url('/')}}/assets/uploads/usuario/{{$imagen}}" alt="" width="70px" height="auto"> 
                          @else
                             @if($instructor->sexo=='F')
                                <img class="img-responsive img-circle" src="{{url('/')}}/assets/img/profile-pics/1.jpg" alt="">        
                             @else
                                <img class="img-responsive img-circle" src="{{url('/')}}/assets/img/profile-pics/2.jpg" alt="">
                             @endif
                          @endif
                        </a>

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
                                            <span class="ca-icon-planilla"><i class="icon_a-instructor"></i></span>
                                            <div class="ca-content-planilla">
                                                <h2 class="ca-main-planilla">Vista Instructor</h2>
                                                <h3 class="ca-sub-planilla">Personaliza el campo instructor</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>

                                  <div class="col-sm-12 text-center"> 

                                  <br></br>

                                  <span class="f-16 f-700">Acciones</span>

                                  <hr></hr>

                                  <a href="{{url('/')}}/participante/instructor/pagos/{{$instructor->id}}"><i class="zmdi zmdi-money f-20 m-r-5 boton blue sa-warning" data-original-title="Pagos" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                  <a class="email"><i class="zmdi zmdi-email f-20 m-r-5 boton blue sa-warning" data-original-title="Enviar Correo" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                  <i class="zmdi zmdi-delete f-20 m-r-10 boton red sa-warning" id="{{$instructor->id}}" name= "eliminar" data-original-title="Eliminar" data-toggle="tooltip" data-placement="bottom" title=""></i>

                                  <br></br>
                                    
                                   
                                </div>

                                </div>                
                              </div>
                              <!--<p class="text-justify">Desde esta área Easy Dance te brinda la oportunidad de actualizar los datos creados en tu planilla de registro.</p>-->
                                    
                          </div>
                     </div>

					           	<div class="col-sm-9">

                         <div class="col-sm-12">
                              <p class="text-center opaco-0-8 f-22">Datos del Instructor</p>
                          </div>

                          <div class="col-sm-12">
                           <table class="table table-striped table-bordered">
                            <tr class="detalle" data-toggle="modal" href="#modalID-Instructor">
                             <td width="50%"> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-identificacion" class="zmdi {{ empty($instructor->identificacion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>                      
                              <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-account-box f-22"></i> </span>
                              <span class="f-14">Id / pasaporte </span>
                             </td>
                             <td class="f-14 m-l-15" id="instructor-identificacion">{{$instructor->identificacion}}<span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalNombre-Instructor">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-nombre" class="zmdi {{ empty($instructor->nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-accounts-alt f-22"></i> </span>
                               <span class="f-14"> Nombres </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="instructor-nombre" class="capitalize">{{$instructor->nombre}}</span> <span id="instructor-apellido" class="capitalize">{{$instructor->apellido}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalFechaNacimiento-Instructor">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-fecha_nacimiento" class="zmdi {{ empty($instructor->fecha_nacimiento) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b-fecha-de-nacimiento f-22"></i> </span>
                               <span class="f-14"> Fecha de nacimiento  </span>
                             </td>
                             <td  class="f-14 m-l-15" id="instructor-fecha_nacimiento" >{{ \Carbon\Carbon::createFromFormat('Y-m-d',$instructor->fecha_nacimiento)->format('d/m/Y')}}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                             <tr class="detalle" data-toggle="modal" href="#modalSexo-Instructor">
                             <td> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-sexo" class="zmdi {{ empty($instructor->sexo) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                              <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-male-female f-22"></i> </span>
                              <span class="f-14"> Sexo </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="instructor-sexo" data-valor="{{$instructor->sexo}}">
                               @if($instructor->sexo=='F')
                                  <i class="zmdi zmdi-female f-25 c-rosado"></i> </span>
                               @else
                                  <i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>
                               @endif
                             </span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalCorreo-Instructor">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-correo" class="zmdi {{ empty($instructor->correo) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-correo f-22"></i> </span>
                               <span class="f-14"> Correo </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="instructor-correo"><span>{{$instructor->correo}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalTelefono-Instructor">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-telefono" class="zmdi {{ empty($instructor->telefono) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b icon_b-telefono f-22"></i> </span>
                               <span class="f-14"> Contacto </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="instructor-telefono">{{$instructor->telefono}}</span> / <span id="instructor-celular">{{$instructor->celular}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalDireccion-Instructor">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-direccion" class="zmdi {{ empty($instructor->direccion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-pin-drop zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Dirección </span>
                             </td>
                             <td id="instructor-direccion" class="f-14 m-l-15 capitalize" data-valor="{{$instructor->direccion}}" >{{ str_limit($instructor->direccion, $limit = 30, $end = '...') }} <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalImagen-Instructor">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-imagePerfilBase64" class="zmdi {{ empty($instructor->imagen) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-collection-folder-image zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Imagen de Perfil</span>
                             </td>
                             <td class="f-14 m-l-15" > <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalFicha-Instructor">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-ficha" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_d-ficha-medica f-22"></i> </span>
                               <span class="f-14"> Ficha Médica </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="alumno-telefono"></span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalEstatus-Instructor">
                             <td> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-estatus" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                              <span class="m-l-10 m-r-10"> <i class="icon_a-estatus-de-clases f-20"></i> </span>
                              <span class="f-14"> Estatus </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="instructor-estatus" data-valor="{{$instructor->estatus}}">
                               @if($instructor->estatus==1)
                                  <i class="zmdi zmdi-mood zmdi-hc-fw f-22 c-verde"></i> </span>
                               @else
                                  <i class="zmdi zmdi-mood-bad zmdi-hc-fw f-22 c-youtube"></i></span>
                               @endif
                             </span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalRedes-Instructor">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-facebook" class="zmdi {{ empty($instructor->facebook) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-share zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Redes Sociales </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="instructor-facebook"></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalAvanzado-Instructor">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-ficha" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_d-ficha-medica f-22"></i> </span>
                               <span class="f-14"> Opciones Avanzadas </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="alumno-telefono"></span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalCredencial-Instructor">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-cantidad" class="zmdi {{ empty($credencial->cantidad) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-pagar f-22"></i> </span>
                               <span class="f-14"> Credenciales </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="instructor-cantidad">{{$credencial->cantidad}}</span> Credenciales - <span id="instructor-dias_vencimiento">{{$credencial->dias_vencimiento}}</span> Dias de Vencimiento<span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                              <tr class="detalle" data-toggle="modal" id="modalPe" href="#modalPago">
                               <td>
                                 <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-pago" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                                 <span class="m-l-10 m-r-10"> <i class="icon_a-pagar f-22"></i> </span>
                                 <span class="f-14">Configurar Pago</span>
                               </td>
                               <td class="f-14 m-l-15" ><span id="instructor-pago"></span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
                              </tr>
                            @endif

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

  route_update="{{url('/')}}/participante/instructor/update";
  route_eliminar="{{url('/')}}/participante/instructor/eliminar/";
  route_principal="{{url('/')}}/participante/instructor";
  route_email="{{url('/')}}/correo/sesion/";

  route_agregar_pago="{{url('/')}}/participante/instructor/agregarpago";
  route_eliminar_pago="{{url('/')}}/participante/instructor/eliminarpago/";

  route_agregar_comision="{{url('/')}}/participante/instructor/agregarcomisionfija";
  route_eliminar_comision="{{url('/')}}/participante/instructor/eliminarcomisionfija/";

  var linea_servicio = <?php echo json_encode($linea_servicio);?>;

  $(document).ready(function(){

    $('#clase_grupal_id').val('');
    $("#form_pago")[0].reset();
    $("#form_comision")[0].reset();
    $('#clase_grupal_id').selectpicker('refresh');

    $("#imagen").bind("change", function() {
            //alert('algo cambio');
            
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

    $("#imagen_perfil").bind("change", function() {
            //alert('algo cambio');
            
            setTimeout(function(){
              var imagen = $("#imagenb img").attr('src');
              var canvas = document.createElement("canvas");
     
              var context=canvas.getContext("2d");
              var img = new Image();
              img.src = imagen;
              
              canvas.width  = img.width;
              canvas.height = img.height;

              context.drawImage(img, 0, 0);
       
              var newimage = canvas.toDataURL("image/jpeg", 0.8);
              var image64 = $("input:hidden[name=imagePerfilBase64]").val(newimage);
            },500);

        });

    if("{{$instructor->boolean_promocionar}}" == 1){
          $("#boolean_promocionar").val('1');  //VALOR POR DEFECTO
          $("#promocionar").attr("checked", true); //VALOR POR DEFECTO
        }

      $("#promocionar").on('change', function(){
          if ($("#promocionar").is(":checked")){
            $("#boolean_promocionar").val('1');
          }else{
            $("#boolean_promocionar").val('0');
          }    
        });

      if("{{$instructor->boolean_disponibilidad}}" == 1){
        $("#boolean_disponibilidad").val('1');  //VALOR POR DEFECTO
        $("#disponibilidad").attr("checked", true); //VALOR POR DEFECTO
      }

      $("#disponibilidad").on('change', function(){
        if ($("#disponibilidad").is(":checked")){
          $("#boolean_disponibilidad").val('1');
        }else{
          $("#boolean_disponibilidad").val('0');
        }    
      });

      if("{{$instructor->boolean_administrador}}" == 1){
        $("#boolean_administrador").val('1');  //VALOR POR DEFECTO
        $("#administrador").attr("checked", true); //VALOR POR DEFECTO
      }

      $("#administrador").on('change', function(){
        if ($("#administrador").is(":checked")){
          $("#boolean_administrador").val('1');
        }else{
          $("#boolean_administrador").val('0');
        }    
      });

    if("{{$instructor->alergia}}" == 1){
          $("#alergia").val('1');  //VALOR POR DEFECTO
          $("#alergia-switch").attr("checked", true); //VALOR POR DEFECTO
        }

        if("{{$instructor->asma}}" == 1){
          $("#asma").val('1');  //VALOR POR DEFECTO
          $("#asma-switch").attr("checked", true); //VALOR POR DEFECTO
        }

        if("{{$instructor->convulsiones}}" == 1){
          $("#convulsiones").val('1');  //VALOR POR DEFECTO
          $("#convulsiones-switch").attr("checked", true); //VALOR POR DEFECTO
        }

        if("{{$instructor->cefalea}}" == 1){
          $("#cefalea").val('1');  //VALOR POR DEFECTO
          $("#cefalea-switch").attr("checked", true); //VALOR POR DEFECTO
        }

        if("{{$instructor->hipertension}}" == 1){
          $("#hipertension").val('1');  //VALOR POR DEFECTO
          $("#hipertension-switch").attr("checked", true); //VALOR POR DEFECTO
        }

        if("{{$instructor->lesiones}}" == 1){
          $("#lesiones").val('1');  //VALOR POR DEFECTO
          $("#lesiones-switch").attr("checked", true); //VALOR POR DEFECTO
        }

        $("#alergia-switch").on('change', function(){
          if ($("#alergia-switch").is(":checked")){
            $("#alergia").val('1');
          }else{
            $("#alergia").val('0');
          }     
        });

      $("#asma-switch").on('change', function(){
          if ($("#asma-switch").is(":checked")){
            $("#asma").val('1');
          }else{
            $("#asma").val('0');
          }     
        });

      $("#convulsiones-switch").on('change', function(){
          if ($("#convulsiones-switch").is(":checked")){
            $("#convulsiones").val('1');
          }else{
            $("#convulsiones").val('0');
          }     
        });

      $("#cefalea-switch").on('change', function(){
          if ($("#cefalea-switch").is(":checked")){
            $("#cefalea").val('1');
          }else{
            $("#cefalea").val('0');
          }     
        });

      $("#lesiones-switch").on('change', function(){
          if ($("#lesiones-switch").is(":checked")){
            $("#lesiones").val('1');
          }else{
            $("#lesiones").val('0');
          }     
        });

      $("#hipertension-switch").on('change', function(){
          if ($("#hipertension-switch").is(":checked")){
            $("#hipertension").val('1');
          }else{
            $("#hipertension").val('0');
          }     
        });

    $('#nombre').mask('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', {'translation': {

        A: {pattern: /[A-Za-záéíóúÁÉÍÓÚ.,@*+_ñÑ ]/}
        }

      });

      $('#apellido').mask('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', {'translation': {

        A: {pattern: /[A-Za-záéíóúÁÉÍÓÚ.,@*+_ñÑ ]/}
        }

      });

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

    $('#modalID-Instructor').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#identificacion").val($("#instructor-identificacion").text()); 
    })
    $('#modalNombre-Instructor').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#nombre").val($("#instructor-nombre").text()); 
      $("#apellido").val($("#instructor-apellido").text());
    })
    $('#modalFechaNacimiento-Instructor').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#fecha_nacimiento").val($("#instructor-fecha_nacimiento").text()); 
    })
    $('#modalSexo-Instructor').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var sexo=$("#instructor-sexo").data('valor');
      if(sexo=="M"){
        $("#hombre").prop("checked", true);
      }else{
        $("#mujer").prop("checked", true);
      }
      
    })

    $('#modalCorreo-Instructor').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#correo").val($("#instructor-correo").text()); 
    })

    $('#modalTelefono-Instructor').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#telefono").val($("#instructor-telefono").text());
      $("#celular").val($("#instructor-celular").text()); 
    })

    $('#modalCredencial-Instructor').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#cantidad").val($("#instructor-cantidad").text());
      $("#dias_vencimiento").val($("#instructor-dias_vencimiento").text()); 
    })

    $('#modalDireccion-Instructor').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var direccion=$("#instructor-direccion").data('valor');
       $("#direccion").val(direccion);
    })

    $('#modalEstatus-Instructor').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var status= $("#instructor-estatus").data('valor');
      if(status==1){
        $("#activo").prop("checked", true);
      }else{
        $("#inactivo").prop("checked", true);
      }
      
    })

    function limpiarMensaje(){
        var campo = ["identificacion", "nombre", "apellido", "fecha_nacimiento", "sexo", "correo", "telefono", "celular", "direccion", "estatus"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
        console.log(merror);
        var campo = ["identificacion", "nombre", "apellido", "fecha_nacimiento", "sexo", "correo", "telefono", "celular", "direccion", "estatus"];
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
            $("#instructor-"+c.name).data('valor',c.value);
            $("#instructor-"+c.name).html(valor);
          }else if(c.name=='estatus'){
            if(c.value==1){              
              var valor='<i class="zmdi zmdi-mood zmdi-hc-fw f-22 c-verde"></i>';                              
            }else if(c.value==0){
              var valor='<i class="zmdi zmdi-mood-bad zmdi-hc-fw f-22 c-youtube"></i>';
            }
            $("#instructor-"+c.name).data('valor',c.value);
            $("#instructor-"+c.name).html(valor);
          }else if(c.name=='direccion'){
             $("#instructor-"+c.name).data('valor',c.value);
             $("#instructor-"+c.name).html(c.value.toLowerCase().substr(0, 30) + "...");
            //$("#alumno-"+c.name).text(c.value.substr(0, 30));
          }else{
            $("#instructor-"+c.name).text(c.value.toLowerCase());
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
                
                // if (typeof msj.responseJSON === "undefined") {
                //           window.location = "{{url('/')}}/error";
                //         }
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
       
    })

   $("i[name=eliminar]").click(function(){
                id = this.id;
                swal({   
                    title: "Desea eliminar al instructor?",   
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

      $(".email").click(function(){
         var route = route_email + 2;
         var token = '{{ csrf_token() }}';
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    success:function(respuesta){

                        procesando();
                        window.location="{{url('/')}}/correo/{{$instructor->id}}"  

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

      function countChar(val) {
        var len = val.value.length;
        if (len >= 180) {
          val.value = val.value.substring(0, 180);
        } else {
          $('#charNum').text(180 - len);
        }
      };
      
      function countChar2(val) {
        var len = val.value.length;
        if (len >= 2000) {
          val.value = val.value.substring(0, 2000);
        } else {
          $('#charNum2').text(2000 - len);
        }
      };

      function countChar3(val) {
        var len = val.value.length;
        if (len >= 2000) {
          val.value = val.value.substring(0, 2000);
        } else {
          $('#charNum3').text(2000 - len);
        }
      };

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
                        swal("Exito!","La configuración ha sido eliminada!","success");
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
                        eliminar_pago(id, element);
          }
                });
            });
      
        function eliminar_pago(id, element){
         var route = route_eliminar_pago + id;
         var token = "{{ csrf_token() }}";
                
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
                          // finprocesado();
                          var nType = 'success';
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;

                          $("#clase_grupal_id option[value='"+respuesta.id+"']").removeAttr("disabled");
                          $("#clase_grupal_id option[value='"+respuesta.id+"']").data("icon","");

                          $('#clase_grupal_id').selectpicker('refresh');

                          h.row( $(element).parents('tr') )
                            .remove()
                            .draw();
                        
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


    $("#add").click(function(){


      $("#add").attr("disabled","disabled");
        $("#add").css({
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
              data:datos+"&clase_grupal_id="+$("#clase_grupal_id").val(),
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

                  if(array.tipo == 1){
                    tipo = 'Por Clase'
                  }else{
                    tipo = 'Mensual'
                  }

                  var rowId=array.id;
                  var rowNode=h.row.add( [
                  ''+array.nombre+'',
                  ''+tipo+'',
                  ''+array.monto+'',
                  '<i class="zmdi zmdi-delete f-20 p-r-10"></i>'
                  ] ).draw(false).node();
                  $( rowNode )
                  .attr('id',rowId)
                  // .attr('data-precio',precio_neto)
                  .addClass('seleccion');

                  $("#clase_grupal_id option[value='"+array.clase_grupal_id+"']").attr("disabled","disabled");
                  $("#clase_grupal_id option[value='"+array.clase_grupal_id+"']").data("icon","glyphicon-remove");

                  

                });

                $('#clase_grupal_id').val('');
                $('#clase_grupal_id').selectpicker('refresh');
                

              }else{
                var nTitle="Ups! ";
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                var nType = 'danger';
              }                       
              $("#add").removeAttr("disabled");
                $("#add").css({
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

    h=$('#tablepagos').DataTable({
      processing: true,
      serverSide: false,
      pageLength: 50, 
      order: [[0, 'desc']],
      fnDrawCallback: function() {
      if ("{{count($pagos_instructor)}}" < 50) {
            $('.dataTables_paginate').hide();
            $('#tablelistar_length').hide();
        }
      },
      fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
        $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
      },
      language: {
                      processing:     "Procesando ...",
                      search:         '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>',
                      searchPlaceholder: "BUSCAR",
                      lengthMenu:     " ",
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

    var k=$('#tablecomisiones').DataTable({
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

    $("#addcomision").click(function(){


      $("#addcomision").attr("disabled","disabled");
        $("#addcomision").css({
          "opacity": ("0.2")
        });

      var route = route_agregar_comision;
      var token = $('input:hidden[name=_token]').val();
      var datos = $( "#form_comision" ).serialize(); 
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
                $("#form_comision")[0].reset();

                $.each(respuesta.array, function (index, array) {

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
                  var rowNode=k.row.add( [
                  ''+array.nombre+'',
                  ''+tipo+'',
                  ''+monto+'',
                  ''+monto_porcentaje+'',
                  '<i class="zmdi zmdi-delete f-20 p-r-10"></i>'
                  ] ).draw(false).node();
                  $( rowNode )
                  .attr('id',rowId)
                  .attr('data-tipo_servicio',array.tipo_servicio)
                  .addClass('seleccion');

                });

              }else{
                var nTitle="Ups! ";
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                var nType = 'danger';
              }                       
              $("#addcomision").removeAttr("disabled");
                $("#addcomision").css({
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
              $("#addcomision").removeAttr("disabled");
                $("#addcomision").css({
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

  $('#tablecomisiones tbody').on( 'click', 'i.zmdi-delete', function () {

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
                    eliminar_comision(id, element);
      }
   });
  });

  function eliminar_comision(id, element){
    var route = route_eliminar_comision + id;
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

                k.row( $(element).parents('tr') )
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

    function formatmoney(n) {
      return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    } 

    $("input[name=pagos_comisiones]").on('change', function(){
      if ($(this).val() == 1){
        $("#pagos").show();
        $("#comisiones").hide();
      }else{
        $("#comisiones").show();
        $("#pagos").hide();
      }    
    });

   </script> 
@stop
