@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/farbtastic/farbtastic.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<!--<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.es.js"></script>-->
<script src="{{url('/')}}/assets/vendors/farbtastic/farbtastic.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/moment.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

@stop
@section('content')


            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/agendar/clases-grupales" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección clase grupal</a><ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            
                        </ul>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-center">
                            <span class="f-25 c-morado"><i class="icon_a-clases-grupales f-25" id="id-clase_grupal_id"></i> Agregar clase grupal </span>                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                          <form name="agregar_clase_grupal" id="agregar_clase_grupal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>
                              <div class="col-sm-12">
                                 
                                    <label for="nombre">Nombre</label> <span class="c-morado f-700 f-16">*</span> <i name = "pop-nombre_clase" id = "pop-nombre_clase" aria-describedby="popoversalon" class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el nombre de la clase grupal, en caso de no haberla registrado o deseas crear un nuevo registro, debes dirigirte al área de configuración general en la sección de clases grupales y procede a crear el registro. Desde esta sección podemos redireccionarte <br> <a href='{{url('/')}}/configuracion/clases-grupales/agregar' class='redirect pointer'> Llévame <i class='icon_b icon_b-nombres f-22'></i></a>" title="" data-original-title="Ayuda" data-html="true"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a-clases-grupales f-22"></i></span>
                                      <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="clase_grupal_id" id="clase_grupal_id" data-live-search="true" onchange="porcentaje" >

                                          <option value="">Selecciona</option>
                                          @foreach ( $config_clases_grupales as $clases_grupales )
                                          <option value = "{{ $clases_grupales['id'] }}">{{ $clases_grupales['nombre'] }}</option>
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
                               </div>

                               <div class="clearfix p-b-35"></div>

                               
                               <div class="col-sm-12">
                                 
                                      <label for="fecha_inicio" id="id-fecha">Fecha</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Define la fecha de inicio y final de la clase grupal" title="" data-original-title="Ayuda"></i>

                                      <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-calendar-check f-22"></i></span>
                                      <div class="fg-line">
                                              <input type="text" id="fecha" name="fecha" class="form-control pointer" placeholder="Selecciona la fecha"
                                              @if (session('fecha_inicio'))
                                                  value="{{session('fecha_inicio')}} - {{session('fecha_inicio')}}"
                                              @endif
                                              >
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-fecha">
                                      <span >
                                          <small class="help-block error-span" id="error-fecha_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
    
                               <div class="clearfix p-b-35"></div>

                                <div class="col-xs-6">
                                 
                                      <label for="fecha_inicio" id="id-hora_inicio">Horario</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Define la hora de inicio y final de la clase grupal" title="" data-original-title="Ayuda"></i>

                                      <div class="input-group col-xs-12">
                                      <span class="input-group-addon"><i class="zmdi zmdi-time f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="hora_inicio" id="hora_inicio" class="form-control time-picker" placeholder="Desde" type="text">
                                          </div>
                                    </div>
                                 <div class="has-error" id="error-hora_inicio">
                                      <span >
                                          <small class="help-block error-span" id="error-hora_inicio_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="col-xs-6">
                                      <label for="fecha_inicio" id="id-hora_final">&nbsp;</label>
                                      <div class="input-group col-xs-12">
                                      <span class="input-group-addon"><i class="zmdi zmdi-time f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="hora_final" id="hora_final" class="form-control time-picker" placeholder="Hasta" type="text">
                                          </div>
                                    </div>
                                 <div class="has-error" id="error-hora_final">
                                      <span >
                                          <small class="help-block error-span" id="error-hora_final_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">
                                    <div class="cp-container">
                                        <label for="fecha_cobro" id="id-color_etiqueta">Color de etiqueta</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona un color de etiqueta para la clase grupal que será visualizado por tus alumnos e instructores en el calendario de eventos" title="" data-original-title="Ayuda"></i>
                                        <div class="input-group form-group">

                                            <span class="input-group-addon"><i class="zmdi zmdi-invert-colors f-22"></i></span>
                                            <div class="fg-line dropdown">
                                                <input type="text" name="color_etiqueta" id="color_etiqueta" class="form-control cp-value proceso pointer" value="#de87b4" data-toggle="dropdown">
                                                    
                                                <div class="dropdown-menu">
                                                    <div class="color-picker" data-cp-default="#de87b4"></div>
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

                                <div class="clearfix p-b-35"></div>
                                <div class="col-sm-12">
                                 
                                     <label for="fecha_cobro" id="id-especialidad_id">Especialidad</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Easy dance te ofrece una selección de diversas especialidades" title="" data-original-title="Ayuda"></i>

                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a icon_a-especialidad f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="especialidad_id" id="especialidad_id" data-live-search="true" onchange="porcentaje" >

                                          <option value="">Selecciona</option>
                                          @foreach ( $config_especialidades as $especialidades )
                                          <option value = "{{ $especialidades['id'] }}">{{ $especialidades['nombre'] }}</option>
                                          @endforeach
                                        
                                        </select>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-especialidad_id">
                                      <span >
                                        <small class="help-block error-span" id="error-especialidad_id_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                                <div class="col-sm-12">
                                 
                                     <label for="nivel_baile" id="id-nivel_baile_id">Nivel de baile</label> <span class="c-morado f-700 f-16">*</span> <i name = "pop-nivel" id = "pop-nivel" aria-describedby="popoversalon" class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Easy dance te ofrece una selección de distintos niveles, en caso que desees asignar uno nuevo, debes dirigirte a la sección de configuración general y personalizar nuevos niveles. Desde esta sección podemos redireccionarte <br> <a href='{{url('/')}}/configuracion/academia' class='redirect pointer'> Llévame <i class='icon_a-niveles f-22'></i></a>" title="" data-original-title="Ayuda" data-html="true"></i>

                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a-niveles f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="nivel_baile_id" id="nivel_baile_id" data-live-search="true">

                                          <option value="">Selecciona</option>
                                          @foreach ( $config_niveles as $niveles )
                                          <option value = "{{ $niveles['id'] }}">{{ $niveles['nombre'] }}</option>
                                          @endforeach

                                        </select>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-nivel_baile_id">
                                      <span >
                                        <small class="help-block error-span" id="error-nivel_baile_id_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>
                                <div class="col-sm-12">
                                 
                                     <label for="nivel_baile" id="id-instructor_id">Instructor</label> <span class="c-morado f-700 f-16">*</span> <i name = "pop-instructor" id = "pop-instructor" aria-describedby="popoverinstructor" class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona un instructor, en caso de no poseerlo o deseas crear un nuevo registro, dirígete a la sección de instructores y procede a registrarlo. Desde esta sección podemos redireccionarte <br> <a href='{{url('/')}}/participante/instructor/agregar' class='redirect pointer'> Llévame <i class='icon_a-instructor f-22'></i></a>" title="" data-original-title="Ayuda" data-html="true"></i>

                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a-instructor f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="instructor_id" id="instructor_id" data-live-search="true">

                                          <option value="">Selecciona</option>
                                          @foreach ( $instructores as $instructor )
                                          <option value = "{{$instructor['id'] }}">{{$instructor['nombre'] }} {{$instructor['apellido'] }}</option>
                                          @endforeach 
                                          
                                        
                                        </select>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-instructor_id">
                                      <span >
                                        <small class="help-block error-span" id="error-instructor_id_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>
                                <div class="col-sm-12">
                                 
                                     <label for="nivel_baile" id="id-estudio_id">Sala / Estudio</label> <span class="c-morado f-700 f-16">*</span> <i name = "pop-salon" id = "pop-salon" aria-describedby="popoversalon" class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la sala o estudio de tu academia, en caso de no haberla asignado o deseas crear un nuevo registro, dirígete a la sección de sala o estudio e ingresa la información en el área de configuración general. Desde esta sección podemos redireccionarte <br> <a href='{{url('/')}}/configuracion/academia' class='redirect pointer'> Llévame <i class='icon_a-estudio-salon f-22'></i></a>" title="" data-original-title="Ayuda" data-html="true"></i>

                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a-estudio-salon f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" id="estudio_id" name="estudio_id" data-live-search="true">

                                          <option value="">Selecciona</option>
                                          @foreach ( $config_estudios as $estudios )
                                          <option value = "{{ $estudios['id'] }}">{{ $estudios['nombre'] }}</option>
                                          @endforeach

                                        </select>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-estudio_id">
                                      <span >
                                        <small class="help-block error-span" id="error-estudio_id_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-xs-12">
                              <label for="nombre" id="id-cupo_minimo">Cantidad de Cupos</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la cantidad de cupos mínimos y máximos permitidos en la clase grupal" title="" data-original-title="Ayuda"></i>
                              </div>

                                          <div class="col-xs-6">
                                            <div class="input-group col-xs-12">
                                            <div class="dtp-container fg-line">
                                                    <!-- <input name="cupo_minimo" id="cupo_minimo" class="form-control" placeholder="Minimo" type="text"> -->

                                                    <input type="text" class="form-control input-sm input-mask" name="cupo_minimo" id="cupo_minimo" data-mask="000" placeholder="Minimo">
                                                </div>
                                          </div>
                                       <div class="has-error" id="error-cupo_minimo">
                                            <span >
                                                <small class="help-block error-span" id="error-cupo_minimo_mensaje" ></small>                                
                                            </span>
                                        </div>
                                     </div>

                                     <div class="col-xs-6" id="id-cupo_maximo">
                                            <div class="input-group col-xs-12">
                                            <div class="dtp-container fg-line">
                                                    <input type="text" class="form-control input-sm input-mask" name="cupo_maximo" id="cupo_maximo" data-mask="000" placeholder="Maximo">
                                                </div>
                                          </div>
                                       <div class="has-error" id="error-cupo_maximo">
                                            <span >
                                                <small class="help-block error-span" id="error-cupo_maximo_mensaje" ></small>                                
                                            </span>
                                        </div>
                                      </div>


                               <div class="clearfix p-b-35"></div>

                                <div class="col-xs-12">
                                <label for="nombre" id="id-cantidad_hombres">Cantidad de Participantes</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la cantidad de participantes permitidos en la clase grupal" title="" data-original-title="Ayuda"></i>
                               </div>

                                          <div class="col-xs-6" id="id-cantidad_mujeres">
                                            <div class="input-group col-xs-12">
                                            <div class="dtp-container fg-line">
                                                    <!-- <input name="cupo_minimo" id="cupo_minimo" class="form-control" placeholder="Minimo" type="text"> -->

                                                    <input type="text" class="form-control input-sm input-mask" name="cantidad_hombres" id="cantidad_hombres" data-mask="000" placeholder="Hombres">
                                                </div>
                                          </div>
                                       <div class="has-error" id="error-cantidad_hombres">
                                            <span >
                                                <small class="help-block error-span" id="error-cantidad_hombres_mensaje" ></small>                                
                                            </span>
                                        </div>
                                     </div>

                                     <div class="col-xs-6" id="id-cupo_maximo">
                                            <div class="input-group col-xs-12">
                                            <div class="dtp-container fg-line">
                                                    <input type="text" class="form-control input-sm input-mask" name="cantidad_mujeres" id="cantidad_mujeres" data-mask="000" placeholder="Mujeres">
                                                </div>
                                          </div>
                                       <div class="has-error" id="error-cantidad_mujeres">
                                            <span >
                                                <small class="help-block error-span" id="error-cantidad_mujeres_mensaje" ></small>                                
                                            </span>
                                        </div>
                                      </div>


                               <div class="clearfix p-b-35"></div>                 

                               <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-cupo_reservacion">Cantidad de cupos para reserva online</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la cantidad de cupos que podrán ser ofrecidos como ticket de reservación por via online" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_d icon_d-reporte f-22"></i></span>
                                      <div class="fg-line">
                                        <input type="text" class="form-control input-sm input-mask" name="cupo_reservacion" id="cupo_reservacion" data-mask="000" placeholder="Ej. 20">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-cupo_reservacion">
                                      <span >
                                          <small class="help-block error-span" id="error-cupo_reservacion_mensaje" ></small>                                
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
      

                               <!-- <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Multihorarios</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Desde este campo podrás crear distintos instructores, especialidades, horarios y días de la semana de la clase grupal" title="" data-original-title="Ayuda"></i>
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

                                    <div class="col-sm-2 text-center">
                                    
                                    <span class="f-16 c-morado">Instructor</span>

                                   </div>
                                   <div class="col-sm-2 text-center">

                                   <span class="f-16 c-morado">Especialidad</span>

                                   </div>
                                   <div class="col-sm-2 text-center">

                                   <span class="f-16 c-morado">Día de la semana</span>

                                   </div>
                                   <div class="col-sm-2 text-center">

                                   <span class="f-16 c-morado">Hora Desde</span>

                                   </div>

                                   <div class="col-sm-2 text-center">

                                   <span class="f-16 c-morado">Hora Hasta</span>

                                   </div>


                              <div class="clearfix p-b-35"></div>

                                    <div class="col-sm-2">
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="instructor_acordeon_id" id="instructor_acordeon_id" data-live-search="true">
                                          <option value="">Selecciona</option>
                                          @foreach ( $instructores as $instructor )
                                          <option value = "{{ $instructor['id'] }}">{{ $instructor['nombre'] }} {{ $instructor['apellido'] }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                  </div>

                              <div class="col-sm-2 text-center">
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="especialidad_acordeon_id" id="especialidad_acordeon_id" data-live-search="true">

                                          <option value="">Selecciona</option>
                                          @foreach ( $config_especialidades as $especialidades )
                                          <option value = "{{ $especialidades['id'] }}">{{ $especialidades['nombre'] }}</option>
                                          @endforeach
                                        
                                        </select>
                                      </div>
                                    </div>
                              </div>

                              <div class="col-sm-2 text-center">
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
                              </div>

                              <div class="col-sm-2 text-center">
                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-time f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="hora_inicio_acordeon" id="hora_inicio_acordeon" class="form-control time-picker" placeholder="Desde" type="text">
                                          </div>
                                    </div>
                              </div>

                              <div class="col-sm-2 text-center">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-time f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="hora_final_acordeon" id="hora_final_acordeon" class="form-control time-picker" placeholder="Hasta" type="text">
                                          </div>
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
                                    <th class="text-center" data-column-id="sexo"></th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc"></th>
                                    <th class="text-center" data-column-id="estatu_c" data-order="desc"></th>
                                    <th class="text-center" data-column-id="estatu_e" data-order="desc"></th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" ></th>
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
                               </div> -->

<!-- 
                    
                               <div class="clearfix p-b-35"></div> -->

                                 <div class="col-sm-12">
                                  <label for="id" id="id-link_video">Ingresa el link del video promocional</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Haz un video promocional no mayor a dos minutos, mientras mejor desarrolles tu video, tendrás  más oportunidad de persuadir a tus clientes a contribuir con el logro de tus objetivos" title="" data-original-title="Ayuda"></i>
                                  
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                     <i class="zmdi zmdi-videocam f-20 c-morado"></i>
                                    </span>  

                                    <div class="fg-line">                       
                                      <input type="text" class="form-control caja input-sm" name="link_video" id="link_video" placeholder="Ingresa el link">
                                    </div>
                                   </div>
                                   
                                   <div class="has-error" id="error-link_video">
                                    <span >
                                     <small id="error-link_video_mensaje" class="help-block error-span" ></small>                                           
                                    </span>
                                    </div>                                          
                                </div>

                                <div class="clearfix p-b-35"></div>  

                                <div class="col-sm-12">
                                  <label for="id" id="id-titulo_video">Ingresa un título al video promocional</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el título del video promocional" title="" data-original-title="Ayuda"></i>
                                  
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                     <i class="zmdi zmdi-edit f-20"></i>
                                    </span>  

                                    <div class="fg-line">                       
                                      <input type="text" class="form-control input-sm" name="titulo_video" id="titulo_video" placeholder="Ingresa el título">
                                    </div>
                                   </div>
                                   
                                   <div class="has-error" id="error-titulo_video">
                                    <span >
                                     <small id="error-titulo_video_mensaje" class="help-block error-span" ></small>                                           
                                    </span>
                                    </div>                                          
                                </div>

                                <div class="clearfix p-b-35"></div>     


                                <div class="col-sm-12">
                                       <div class="form-group fg-line ">
                                          <label for="">Promocionar en la web</label id="id-boolean_promocionar"> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Mostrar la clase grupal en la web" title="" data-original-title="Ayuda"></i>
                                          
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
                                          <label for="">Días de prórroga</label id="id-dias_prorroga"> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la cantidad de días de prórroga que tendrá la clase grupal en la web luego de iniciar" title="" data-original-title="Ayuda"></i>
                                          
                                          <br></br>
                                          <input type="text" class="form-control input-sm input-mask" name="dias_prorroga" id="dias_prorroga" data-mask="000" placeholder="Ej. 7">
                                       </div>
                                       <div class="has-error" id="error-dias_prorroga">
                                            <span >
                                                <small class="help-block error-span" id="error-dias_prorroga_mensaje" ></small>                                           
                                            </span>
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

                              <!-- <a class="btn-blanco m-r-10 f-18 guardar" id="guardar" href="#">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a> -->

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

  route_agregar="{{url('/')}}/agendar/clases-grupales/agregar";
  route_principal="{{url('/')}}/agendar/clases-grupales";
  route_horario="{{url('/')}}/agendar/clases-grupales/agregarhorario";
  route_eliminar="{{url('/')}}/agendar/clases-grupales/eliminarhorario";

  $(document).ready(function(){


      $("#boolean_promocionar").val('1');  //VALOR POR DEFECTO
      $("#promocionar").attr("checked", true); //VALOR POR DEFECTO

      $("#promocionar").on('change', function(){
          if ($("#promocionar").is(":checked")){
            $("#boolean_promocionar").val('1');
          }else{
            $("#boolean_promocionar").val('0');
          }    
        });

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

      });

  setInterval(porcentaje, 1000);

  function porcentaje(){
    var campo = ["clase_grupal_id", "fecha", "color_etiqueta", "especialidad_id", "nivel_baile_id", "instructor_id", "estudio_id", "hora_inicio", "hora_final", "link_video", "imagen"];
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

  var t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,
        //bPaginate: false, 
        bFilter:false, 
        bSort:false, 
        bInfo:false,
        order: [[0, 'asc']],
        fnDrawCallback: function() {
          $('.dataTables_paginate').show();
          /*if ($('#tablelistar tr').length < 25) {
              $('.dataTables_paginate').hide();
          }
          else{
             $('.dataTables_paginate').show();
          }*/
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
                var datos = $( "#agregar_clase_grupal" ).serialize(); 
                $("#guardar").attr("disabled","disabled");
                procesando();
                $("#guardar").css({
                  "opacity": ("0.2")
                });
                $(".cancelar").attr("disabled","disabled");
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
                          // finprocesado();
                          // var nType = 'success';
                          // $("#agregar_alumno")[0].reset();
                          // var nTitle="Ups! ";
                          // var nMensaje=respuesta.mensaje;
                          window.location = route_principal;
                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';

                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          $("#guardar").removeAttr("disabled");
                          finprocesado();
                          $("#guardar").css({
                            "opacity": ("1")
                          });
                          $(".cancelar").removeAttr("disabled");

                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                        }                       
                        
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
                        finprocesado();
                        $("#guardar").css({
                          "opacity": ("1")
                        });
                        $(".cancelar").removeAttr("disabled");
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

      $("#add").click(function(){

                var route = route_horario;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#agregar_clase_grupal" ).serialize(); 

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

                          var instructor_id = respuesta.array[0].instructor;
                          var especialidad_id = respuesta.array[0].especialidad;
                          var dia_de_semana_id = respuesta.array[0].dia_de_semana;
                          var hora_inicio = respuesta.array[0].hora_inicio;
                          var hora_final = respuesta.array[0].hora_final;

                          var rowId=respuesta.id;
                          var rowNode=t.row.add( [
                          ''+instructor_id+'',
                          ''+especialidad_id+'',
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

      function limpiarMensaje(){
      var campo = ["clase_grupal_id", "fecha", "color_etiqueta", "especialidad_id", "nivel_baile_id", "instructor_id", "estudio_id", "hora_inicio", "hora_final", "link_video", "imagen"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
      var campo = ["clase_grupal_id", "fecha", "color_etiqueta", "especialidad_id", "nivel_baile_id", "instructor_id", "estudio_id", "hora_inicio", "hora_final", "link_video", "imagen"];
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

      $( "#cancelar" ).click(function() {
        $("#agregar_clase_grupal")[0].reset();
        $('#especialidad_id').selectpicker('render');
        $('#estudio_id').selectpicker('render');
        $('#nivel_baile_id').selectpicker('render');
        $('#clase_grupal_id').selectpicker('render');
        $('#instructor_id').selectpicker('render');
        limpiarMensaje();
        $('html,body').animate({
          scrollTop: $("#id-clase_grupal_id").offset().top-90,
        }, 1500);
        $("#pop-nombre_clase").focus();
      });

      $('#pop-nombre_clase').popover({
                    html: true,
                    trigger: 'manual'
                }).on( "mouseenter", function(e) {

                    $(this).popover('show');
                    
                    e.preventDefault();
          });

      $('#pop-instructor').popover({
                    html: true,
                    trigger: 'manual'
                }).on( "mouseenter", function(e) {

                    $(this).popover('show');
                    
                    e.preventDefault();
          });

          $('#pop-salon').popover({
                    html: true,
                    trigger: 'manual'
                }).on( "mouseenter", function(e) {

                    $(this).popover('show');

                    e.preventDefault();
          });

          $('#pop-nivel').popover({
                    html: true,
                    trigger: 'manual'
                }).on( "mouseenter", function(e) {

                    $(this).popover('show');

                    e.preventDefault();
          });

          $('body').on('click', function (e) {
            $('[data-toggle="popover"]').each(function () {
                //the 'is' for buttons that trigger popups
                //the 'has' for icons within a button that triggers a popup
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    $(this).popover('hide');
                }
            });
        });

        $('.ayuda').on('mouseenter', function(e) {
          $('.ayuda').not(this).popover('hide')
        })


        $("#clase_grupal_id").on('change', function(){
          nombre = $("#clase_grupal_id option:selected").text();
          if(nombre == 'Cef'){
            $('#color_etiqueta').val('#dae316')
            $('.cp-value').css('background-color',"#dae316")
          }else if(nombre == 'Ciclo Basico'){
            $('#color_etiqueta').val('#14a927')
            $('.cp-value').css('background-color',"#14a927")
          }else if(nombre == 'Ciclo Intermedio'){
            $('#color_etiqueta').val('#387993')
            $('.cp-value').css('background-color',"#387993")
          }else if(nombre == 'Chiquibaile'){
            $('#color_etiqueta').val('#8c1fd1')
            $('.cp-value').css('background-color',"#8c1fd1")
          }else if(nombre == 'Repaso'){
            $('#color_etiqueta').val('#882f0c')
            $('.cp-value').css('background-color',"#882f0c")
          }

        });

</script> 
@stop

