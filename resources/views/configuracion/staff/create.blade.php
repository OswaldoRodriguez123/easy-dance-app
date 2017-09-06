@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/farbtastic/farbtastic.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<!--<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.es.js"></script>-->
<script src="{{url('/')}}/assets/vendors/farbtastic/farbtastic.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>

@stop
@section('content')


            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/configuracion/staff" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Staff</a>
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            
                        </ul>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-center">
                            <span class="f-25 c-morado"><i class="icon_f-staff f-25" id="id-staff"></i> Agregar Staff</span>                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                          <form name="agregar_staff" id="agregar_staff"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>
                              <div class="col-sm-12">
                                 
                                    <label for="identificacion" id="id-identificacion">Id - Pasaporte</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el número de cédula o pasaporte del participante" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="identificacion" id="identificacion" data-mask="00000000000000000000" placeholder="Ej: 16133223">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-identificacion">
                                      <span >
                                          <small class="help-block error-span" id="error-identificacion_mensaje" ></small>                        
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                              <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-nombre">Nombre</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del participante" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="nombre" id="nombre" placeholder="Ej. Valeria" value="{{ empty($visitante->nombre) ? '' : $visitante->nombre }}">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-nombre">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-apellido">Apellido</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el apellido del participante" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="apellido" id="apellido" placeholder="Ej. Zambrano" value="{{ empty($visitante->apellido) ? '' : $visitante->apellido }}">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-apellido">
                                      <span >
                                          <small class="help-block error-span" id="error-apellido_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="col-sm-12">
                                    
                                      <label for="fecha_nacimiento" id="id-fecha_nacimiento">Fecha de Nacimiento</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la fecha de nacimiento del participante" title="" data-original-title="Ayuda"></i>
                                      <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-calendar-check f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="fecha_nacimiento" id="fecha_nacimiento" class="form-control date-picker proceso pointer" placeholder="Selecciona" type="text" value="{{ empty($visitante->fecha_nacimiento) ? '' : \Carbon\Carbon::createFromFormat('Y-m-d',$visitante->fecha_nacimiento)->format('d/m/Y') }}">
                                          </div>

                                    </div>
                                    <div class="has-error" id="error-fecha_nacimiento">
                                        <span >
                                            <small class="help-block error-span" id="error-fecha_nacimiento_mensaje" ></small>                                           
                                        </span>
                                    </div>
                                </div>
                                <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-sexo">Sexo</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el sexo del participante" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-sexo f-22"></i></span>
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

                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">

                               <label for="apellido" id="id-correo">Correo Electrónico</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el correo electrónico del participante" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a icon_a-correo f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="correo" id="correo" placeholder="Ej. easydance@gmail.com" value="{{ empty($visitante->correo) ? '' : $visitante->correo }}">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-correo">
                                      <span >
                                          <small class="help-block error-span" id="error-correo_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                              <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">
                                 
                                    <label for="cargo" id="id-cargo">Cargo</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el cargo del participante" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a-instructor f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="cargo" id="cargo" data-live-search="true">
                                          <option value="">Selecciona</option>
                                          @foreach ( $config_staff as $cargo )
                                          <option value = "{{ $cargo['id'] }}">{{ $cargo['nombre'] }}</option>
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
                               </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-celular">Teléfono Móvil</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el número del teléfono movil del participante" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-telefono f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="celular" id="celular" data-mask="(000)000-0000" placeholder="Ej: (426)367-0894" value="{{ empty($visitante->celular) ? '' : $visitante->celular }}">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-celular">
                                      <span >
                                          <small class="help-block error-span" id="error-celular_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">

                                <label for="apellido" id="id-telefono">Teléfono Local</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el número del teléfono local del participante" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-telefono f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="telefono" id="telefono" data-mask="(000)000-0000" placeholder="Ej: (426)367-0894" value="{{ empty($visitante->telefono) ? '' : $visitante->telefono }}">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-telefono">
                                      <span >
                                          <small class="help-block error-span" id="error-telefono_mensaje" ></small>                                
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
                                      <input type="text" class="form-control input-sm proceso" name="direccion" id="direccion" placeholder="Calle santa marta, Av 23" maxlength="180" onkeyup="countChar(this)" value="{{ empty($visitante->direccion) ? '' : $visitante->direccion }}">
                                      </div>
                                     <div class="opaco-0-8 text-right">Resta <span id="charNum">180</span> Caracteres</div>
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
                                 <div class="form-group fg-line">
                                    <label for="nombre">Horario</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Desde este campo podrás crear distintos instructores, especialidades, horarios y días de la semana de la clase grupal" title="" data-original-title="Ayuda"></i>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>

                                    <div class="col-sm-4 text-center">
                                    
                                    <span class="f-16 c-morado" id="id-dia_de_semana_id">Dia de Semana</span>

                                   </div>
                                   <div class="col-sm-4 text-center">

                                   <span class="f-16 c-morado" id="id-hora_inicio">Hora Desde</span>

                                   </div>
                                   <div class="col-sm-4 text-center">

                                   <span class="f-16 c-morado" id="id-hora_final">Hora Hasta</span>

                                   </div>
                                   

                              <div class="clearfix p-b-35"></div>

                              <div class="col-sm-4 text-center">
                                <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="dia_de_semana_id" id="dia_de_semana_id" data-live-search="true">

                                          <option value="">Selecciona</option>
                                          @foreach ( $dias_de_semana as $dias )
                                          <option value = "{{ $dias['id'] }}">{{ $dias['nombre'] }}</option>
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

                              <div class="col-sm-4 text-center">
                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-time f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="hora_inicio" id="hora_inicio" class="form-control time-picker" placeholder="Desde" type="text">
                                          </div>
                                    </div>
                                    <div class="has-error" id="error-hora_inicio">
                                      <span >
                                          <small id="error-hora_inicio_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                              </div>

                              <div class="col-sm-4 text-center">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-time f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="hora_final" id="hora_final" class="form-control time-picker" placeholder="Hasta" type="text">
                                          </div>
                                    </div>
                                    <div class="has-error" id="error-hora_final">
                                      <span >
                                          <small id="error-hora_final_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                              </div>

                              <div class="clearfix p-b-35"></div>

                              <div class="card-header text-left">

                              <button type="button" class="btn btn-blanco m-r-10 f-12 guardar" id="add" >Agregar Linea</button>
                              
                              </div>

                              <br>

                          <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="id" data-type="numeric"></th>
                                    <th class="text-center" data-column-id="dia_de_semana_id" data-order="desc"></th>
                                    <th class="text-center" data-column-id="hora_inicio" data-order="desc"></th>
                                    <th class="text-center" data-column-id="hora_final_acordeon" data-order="desc" ></th>
                                </tr>
                            </thead>
                            <tbody>
                                                           
                            </tbody>
                            </table>

                            </div>
                            </div>

                            <div class="clearfix p-b-35"></div>
                            <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseTwo')" ></i></div>

                            <div class="clearfix p-b-35"></div>
                                      <hr></hr>


                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                 </div>
                               </div>


                        <div class="clearfix p-b-35"></div>


                         <div class="col-sm-12">
                                    <div class="form-group fg-line">
                                    <label for="id">Comisiones</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Configura las comisones del staff" title="" data-original-title="Ayuda"></i>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsePago" aria-expanded="false" aria-controls="collapsePago">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapsePago" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    
                                    <div class="panel-body">
                                    
                                     <div class="col-sm-12">
                                    <div class="clearfix p-b-35"></div>

                                        <label for="clase_grupal_id" id="id-clase_grupal_id">Linea de Servicio</label>

                                        <div class="input-group">
                                          <span class="input-group-addon"><i class="icon_a icon_a-estudio-salon f-22"></i></span>
                                          <div class="fg-line">
                                              <div class="select">
                                                <div class="select">
                                                  <select class="selectpicker" data-live-search="true" name="tipo_servicio" id="tipo_servicio" data-live-search="true">
                                                      <option value="0">Todas</option>
                                                      <option value="99">Academia</option>
                                                      <option value="1">Servicio</option>
                                                      <option value="2">Producto</option>
                                                      <option value="3">Inscripción y Mensualidad</option>
                                                      <option value="9">Clase Personalizada</option>
                                                      <option value="14">Fiestas y Eventos</option>
                                                      <option value="5">Talleres</option>
                                                      <option value="11">Campañas</option>
                                                  </select>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="has-error" id="error-clase_grupal_id">
                                              <span >
                                                  <small class="help-block error-span" id="error-clase_grupal_id_mensaje" ></small>                               
                                              </span>
                                          </div>
                                        </div>

                                      <div class="clearfix p-b-35"></div>
                                   
                                   
                                  <div class="col-sm-12">
                                    <div class="clearfix p-b-35"></div>

                                        <label for="tipo_id" id="id-tipo_id">Detalle</label>

                                        <div class="input-group">
                                          <span class="input-group-addon"><i class="icon_a icon_f-servicios f-22"></i></span>
                                          <div class="fg-line">
                                              <div class="select">
                                                <select class="selectpicker bs-select-hidden" id="tipo_id" name="tipo_id" multiple="" data-max-options="5" title="Todas">

                                                 @foreach ( $linea_servicio as $servicio )
              
                                                    <option value = "{{ $servicio['id'] }}"> {{ $servicio['nombre'] }}</option>
        
                                                 @endforeach
                                                </select>
                                              </div>
                                        </div>
                                        </div>
                                         <div class="has-error" id="error-tipo_id">
                                              <span >
                                                  <small class="help-block error-span" id="error-tipo_id_mensaje" ></small>                               
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
                                            <label for="monto" id="id-monto">Monto</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el monto a pagar por clase grupal" title="" data-original-title="Ayuda"></i>
                                            
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
                                                                       
                                        </tbody>
                                      </table>

                                    </div>
                                  </div> <!-- TABLE RESPONSIVE -->
                                </div><!--  COL-SM-12 -->
                                
                        <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapsePago')" ></i></div>

                        <div class="clearfix p-b-35"></div>

                          <hr></hr>
                    
                            </div>
                        </div>
                        </div>
                        </div>
                     </div>



                        <div class="clearfix p-b-35"></div>

                    
  

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
                            <div class="col-sm-12 text-left">                           

                              <!-- <a class="btn-blanco m-r-10 f-18 guardar" href="#" id="guardar">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a> -->

                              <button type="button" class="btn btn-blanco m-r-10 f-18 guardar" id="guardar" >Guardar</button>

                              <button type="button" class="cancelar btn btn-default" id="cancelar" name="cancelar">Cancelar</button>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div> 

          

                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <nav class="navbar navbar-default navbar-fixed-bottom">
              <div class="container">
                
                <div class="col-xs-1 p-t-15 f-700 text-center" id="text-progreso" >40%</div>
                <div class="col-xs-11">
                  <div class="clearfix p-b-20"></div>
                  <div class="progress-fino progress-striped m-b-10">
                    <div class="progress-bar progress-bar-morado" id="barra-progreso" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                  </div>
                </div>
              </div>
            </nav>
@stop
@section('js') 
<script type="text/javascript">

  route_agregar="{{url('/')}}/configuracion/staff/agregar";
  route_enhorabuena="{{url('/')}}/configuracion/staff";
  route_horario="{{url('/')}}/configuracion/staff/agregarhorario";
  route_eliminar="{{url('/')}}/configuracion/staff/eliminarhorario";
  route_agregar_pago="{{url('/')}}/configuracion/staff/agregarpago";
  route_eliminar_pago="{{url('/')}}/configuracion/staff/eliminarpago/";
  
  $(document).ready(function(){

      $('#monto_minimo').mask('000,000,000,000', {reverse: true});


      $('#nombre').mask('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', {'translation': {

        A: {pattern: /[A-Za-záéíóúÁÉÍÓÚ.,@*+_ñÑ ]/}
        }

      });

      $('#apellido').mask('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', {'translation': {

        A: {pattern: /[A-Za-záéíóúÁÉÍÓÚ.,@*+_ñÑ ]/}
        }

      });

      
        $('body,html').animate({scrollTop : 0}, 500);
        var animation = 'fadeInDownBig';
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

        document.getElementById("identificacion").focus();

      });

  setInterval(porcentaje, 1000);

   function porcentaje(){
    var campo = ["identificacion", "nombre", "apellido", "fecha_nacimiento", "telefono", "celular", "direccion", "cargo","correo"];
    fLen = campo.length;
    var porcetaje=0;
    var cantidad =0;
    var porciento= fLen / fLen;
    for (i = 0; i < fLen; i++) {
      var valor="";
      valor=$("#"+campo[i]).val();
      valor=valor.trim();
      if(campo[i]=="color_etiqueta"){
        if ( valor.length > 6 ){        
          cantidad=cantidad+1;
        }else if (valor.length == 0){
          $("#"+campo[i]).val('#');
        }
      }else{
        if ( valor.length > 0 ){        
          cantidad=cantidad+1;
        }
      }
      
    }

    porcetaje=(cantidad/fLen)*100;
    porcetaje=porcetaje.toFixed(2);
    //console.log(porcetaje);
    $("#text-progreso").text(porcetaje+"%");
    $("#barra-progreso").css({
      "width": (porcetaje + "%")
   });
    

    if(porcetaje=="100" || porcetaje=="100.00"){
      $("#barra-progreso").removeClass('progress-bar-morado');
      $("#barra-progreso").addClass('progress-bar-success');
    }else{
      $("#barra-progreso").removeClass('progress-bar-success');
      $("#barra-progreso").addClass('progress-bar-morado');
    }
    //$("#barra-progreso").s

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

            $("#guardar").click(function(){

                var route = route_agregar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#agregar_staff" ).serialize();
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
                          $("#agregar_staff")[0].reset();
                          window.location = route_enhorabuena;
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

      function limpiarMensaje(){
      var campo = ["identificacion", "nombre", "apellido", "fecha_nacimiento", "sexo", "telefono", "celular", "direccion", "hora_inicio", "hora_final", "correo"];
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

      $('html,body').animate({
            scrollTop: $("#id-"+elemento).offset().top-90,
      }, 1000);      
    }    

  

    function countChar(val) {
        var len = val.value.length;
        if (len >= 180) {
          val.value = val.value.substring(0, 180);
        } else {
          $('#charNum').text(180 - len);
        }
      };

      $( "#cancelar" ).click(function() {
        $("#agregar_staff")[0].reset();
        limpiarMensaje();
        $('html,body').animate({
        scrollTop: $("#id-staff").offset().top-90,
        }, 1500);
        $("#id-identificacion").focus();
      });

      $("#add").click(function(){

                $("#add").attr("disabled","disabled");
                $("#add").css({
                    "opacity": ("0.2")
                }); 

                var route = route_horario;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#agregar_staff" ).serialize(); 

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
                          '<i class="zmdi zmdi-delete boton red f-20 p-r-10"></i>'
                          ] ).draw(false).node();
                          $( rowNode )
                          .attr('id',rowId)
                          .addClass('seleccion');

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }          

                        $('#dia_de_semana_id').val('')
                        $('#hora_inicio').val('')      
                        $('#hora_final').val('')    
                        $('.selectpicker').selectpicker('refresh')    
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        $("#guardar").removeAttr("disabled");
                        $("#guardar").css({
                          "opacity": ("1")
                        });
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
                        $("#guardar").css({
                          "opacity": ("1")
                        });
                        $(".cancelar").removeAttr("disabled");
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
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
                   url: route_eliminar+"/"+id,
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
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).attr( "onclick","previa(this)" );
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

  function collapse_minus(collaps){
   $('#'+collaps).collapse('hide');
  }

  $('#collapseTwo').on('show.bs.collapse', function () {
    $("#guardar").attr("disabled","disabled");
    $("#guardar").css({"opacity": ("0.2")});
  })

  $('#collapseTwo').on('hide.bs.collapse', function () {
    $("#guardar").removeAttr("disabled");
    $("#guardar").css({"opacity": ("1")});
  })


  $("#addpago").click(function(){


      $("#addpago").attr("disabled","disabled");
        $("#addpago").css({
          "opacity": ("0.2")
        });

      var route = route_agregar_pago;
      var token = $('input:hidden[name=_token]').val();
      var datos = $( "#agregar_staff" ).serialize(); 
      limpiarMensaje();

      $.ajax({
          url: route,
              headers: {'X-CSRF-TOKEN': token},
              type: 'POST',
              dataType: 'json',
              data:datos+"&servicio_producto_id="+$("#tipo_id").val(),
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
                $('#tipo_servicio').val(0)
                $('#tipo_id').val(0)
                $('#monto').val('')
                $('#monto_minimo').val('')
                $('#tipo_servicio').selectpicker('refresh')
                $('#tipo_id').selectpicker('refresh')

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
                  '<i class="zmdi zmdi-delete boton red f-20 p-r-10"></i>'
                  ] ).draw(false).node();

                  $( rowNode )
                  .attr('id',rowId)
                  .attr('data-tipo_servicio',array.tipo_servicio)
                  // .attr('data-precio',precio_neto)
                  .addClass('seleccion');

                  $("#tipo_id option[value='"+array.servicio_id+"-"+array.tipo_servicio+"']").attr("disabled","disabled");
                  $("#tipo_id option[value='"+array.servicio_id+"-"+array.tipo_servicio+"']").data("icon","glyphicon-remove");

                  

                });

                $('#tipo_id').val('');
                $('#tipo_id').selectpicker('refresh');
                

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

                var id = $(this).closest('tr').attr('id') + '-' + $(this).closest('tr').data('tipo_servicio');
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
         procesando()
                
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
                          console.log(respuesta.id)

                          $("#tipo_id option[value='"+respuesta.id+"']").removeAttr("disabled");
                          $("#tipo_id option[value='"+respuesta.id+"']").data("icon","");

                          $('#tipo_id').selectpicker('refresh');

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

      $('#tipo_servicio').on('change', function(){
        $('#tipo_id').val('')
        options = $('#tipo_id option');
        id = $(this).val();

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

        $('#tipo_id').selectpicker('refresh');
    });

    $('input[name=tipo_pago]').on('change', function(){
      if($(this).val() == 1){
        $('#monto').mask('00', {reverse: true});
        $('#monto').attr("placeholder", "Ej. 10");
      }else{
        $('#monto').mask('000,000,000,000', {reverse: true});
        $('#monto').attr("placeholder", "Ej. 5000");
      }
    });

    function formatmoney(n) {
      return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    } 


</script> 
@stop

