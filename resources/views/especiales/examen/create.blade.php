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

                        <?php $url = "/especiales/examenes" ?>
                        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

                        @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)

	                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

	                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
	                                            
	                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
	                                            
	                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
	                                            
	                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
	                                           
	                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
	                            
	                        </ul>
                        @endif
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-center">
                            <span class="f-25 c-morado"><i class="icon_a-examen f-25" id="valoracion_id"></i> Crea una Valoración </span>                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                          <form name="agregar_examen" id="agregar_examen"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>
                                <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-nombre"> ¿Cuál es el nombre de la valoración? </label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre de la valoración que deseas realizar" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a icon_a-examen f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="nombre" id="nombre" placeholder="Ej. Prueba final">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-nombre">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>

                               @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)

                               <div class="col-sm-12">
                                 
                                     <label for="nivel_baile" id="id-instructor_id">Instructor a Cargo</label> <span class="c-morado f-700 f-16">*</span> <i name = "pop-instructor" id = "pop-instructor" aria-describedby="popoverinstructor" class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona un instructor, en caso de no poseerlo o deseas crear un nuevo registro, dirígete a la sección de instructores y procede a registrarlo. Desde esta sección podemos redireccionarte <br> <a href='{{url('/')}}/participante/instructor/agregar' class='redirect pointer'> Llévame <i class='icon_a-instructor f-22'></i></a>" title="" data-original-title="Ayuda" data-html="true"></i>
                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a-instructor f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="instructor_id" id="instructor_id" data-live-search="true">

                                          <option value="">Selecciona</option>
                                          @foreach ( $instructores as $instructor )
                                          <option value = "{{ $instructor['id'] }}">{{ $instructor['nombre'] }} {{ $instructor['apellido'] }}</option>
                                          @endforeach
                                        
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="has-error" id="error-instructor_id">
                                      <span >
                                        <small class="help-block error-span" id="error-instructor_id_mensaje" ></small>                                           
                                      </span>
                                    </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               @else

                               	<input type="hidden" id="instructor_id" name="instructor_id" value="{{ Auth::user()->usuario_id }}">

                               @endif

                               <div class="col-sm-12">
                                    
                                      <label for="fecha_inicio" id="id-fecha"> ¿Cuándo será la fecha de la valoración?</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la fecha de inicio de la valoración" title="" data-original-title="Ayuda"></i>
                                      <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-calendar-check f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="fecha" id="fecha" class="form-control date-picker proceso" placeholder="Selecciona" type="text">
                                          </div>

                                    </div>
                                    <div class="has-error" id="error-fecha">
                                        <span >
                                            <small class="help-block error-span" id="error-fecha_mensaje" ></small>                                           
                                        </span>
                                    </div>
                                </div>
                                <div class="clearfix p-b-35"></div>

                                 <div class="col-sm-12">
                                     <label for="nivel_baile" id="id-genero">Especialidad</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Easy dance te ofrece una selección de diversas especialidades" title="" data-original-title="Ayuda"></i>

                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a-instructor f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker bs-select-hidden" id="genero" name="genero" multiple="" data-max-options="5" title="Selecciona">

                                          <option value="">Selecciona</option>
                                          @foreach ( $generos_musicales as $generos )
                                          <option value = "{{$generos->nombre}}">{{$generos->nombre}}</option>
                                          @endforeach
                                        
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                    <div class="has-error" id="error-genero">
                                      <span >
                                        <small class="help-block error-span" id="error-genero_mensaje" ></small>                                           
                                      </span>
                                    </div>
                               </div>

                                <div class="clearfix p-b-35"></div>

                                @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)

                                
                                <div class="col-sm-12">
                                  <div class="clearfix"></div>
                                  <label for="boolean_grupal" id="id-boolean_grupal">A quien va dirigido:</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona si la valoración es dirigida para todos los alumnos de la academia o un grupo en específico" title="" data-original-title="Ayuda"></i>
                                  <div class="clearfix"></div>
                                  <div class="input-group">
                                      <!-- <span class="input-group-addon"><i class="icon_b icon_b-sexo f-22"></i></span> -->
                                      <div class="p-t-10">
                                      <label class="radio radio-inline m-r-20 ">
                                          <input checked="checked" name="boolean_grupal" id="general" value="0" type="radio">
                                          <i class="input-helper"></i>  
                                          General
                                      </label>
                                      <label class="radio radio-inline m-r-20">
                                          <input name="boolean_grupal" id="clase_grupal" value="1" type="radio">
                                          <i class="input-helper"></i>  
                                          Clase Grupal
                                      </label>
                                     
                                    </div>
                                  </div>

                                  <div class="clearfix p-b-35"></div>
                                </div>

                                @else

                                	<input type="hidden" name="boolean_grupal" id="boolean_grupal" value="1">

                                @endif
                                
                                

                                @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)

	                                <div class="col-sm-12 clase_grupal" style="display:none">

	                                  <label for="nombre" id="id-clase_grupal_id">Clase Grupal</label> <span class="c-morado f-700 f-16">*</span>
	                                      <div class="input-group">
	                                        <span class="input-group-addon"><i class="icon_a icon_a-clases-grupales f-22"></i></span>
	                                        <div class="fg-line">
	                                        <div class="select">
	                                          <select class="selectpicker" name="clase_grupal_id" id="clase_grupal_id" data-live-search="true" >

	                                            <option value="">Selecciona</option>
	                                            @foreach ( $clases_grupales as $clase_grupal )
	                                              <option value = "{{ $clase_grupal['id'] }}">{{ $clase_grupal['clase_grupal_nombre'] }} - {{ $clase_grupal['dia_de_semana'] }} - {{ $clase_grupal['hora_inicio'] }} / {{ $clase_grupal['hora_final'] }} - {{ $clase_grupal['instructor_nombre'] }} {{ $clase_grupal['instructor_apellido'] }}</option>
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
	                               </div>

	                            @else

	                           		<input type="hidden" name="clase_grupal_id" id="clase_grupal_id">

                               @endif

                               <div class="col-sm-12">

                                    <label for="nombre" id="id-tipo">Tipo de evaluacion</label> <span class="c-morado f-700 f-16">*</span>
                                        <div class="input-group">
                                          <span class="input-group-addon"><i class="icon_a-especialidad f-22"></i></span>
                                          <div class="fg-line">
                                          <div class="select">
                                            <select class="selectpicker" name="tipo" id="tipo" data-live-search="true" >

                                              @foreach ( $config_examenes as $tipo )
                                                <option value = "{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                              @endforeach
                                            
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
                                    <div class="cp-container">
                                        <label for="fecha_cobro" id="id-color_etiqueta">Color de etiqueta</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona un color de etiqueta para la clase grupal que será visualizado por tus alumnos e instructores en el calendario de eventos" title="" data-original-title="Ayuda"></i>
                                        <div class="input-group form-group">

                                            <span class="input-group-addon"><i class="zmdi zmdi-invert-colors f-22"></i></span>
                                            <div class="fg-line dropdown">
                                                <input type="text" name="color_etiqueta" id="color_etiqueta" class="form-control cp-value proceso" value="#de87b4" data-toggle="dropdown">
                                                    
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
                                 <div class="form-group fg-line">
                                    <label for="nombre">Ítems a Evaluar</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona los ítems a evaluar que te ofrece Easy Dance, además encontrarás en la parte inferior de la planilla un campo para agregar nuevos ítems en caso de necesitarlo" title="" data-original-title="Ayuda"></i>
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

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Tiempos musicales</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="tiempos_musicales" name="tiempos_musicales" value="" hidden="hidden">

                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span>

                                          <input id="tiempos-switch" data-name="Tiempos musicales" type="checkbox" hidden="hidden">

                                          <label for="tiempos-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>

                                      </div>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Compromiso</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="compromiso" name="compromiso" value="" hidden="hidden">

                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span>

                                          <input id="compromiso-switch" data-name="Compromiso" type="checkbox" hidden="hidden">

                                          <label for="compromiso-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Condiciones</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="condicion" name="condicion" value="" hidden="hidden">

                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span>

                                          <input id="condiciones-switch" data-name="Condiciones" type="checkbox" hidden="hidden">
                                          
                                          <label for="condiciones-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Habilidades</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="habilidades" name="habilidades" value="" hidden="hidden">

                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span>
                                          <input id="habilidades-switch" data-name="Habilidades" type="checkbox" hidden="hidden">
                                          <label for="habilidades-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Disciplina</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="disciplina" name="disciplina" value="" hidden="hidden">

                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="disciplina-switch" data-name="Disciplina" type="checkbox" hidden="hidden">
                                          <label for="disciplina-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Expresión corporal</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="expresion_corporal" name="expresion_corporal" value="" hidden="hidden">

                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="expresion-corporal-switch" data-name="Expresión corporal" type="checkbox" hidden="hidden">
                                          <label for="expresion-corporal-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Expresión facial</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="expresion_facial" name="expresion_facial" value="" hidden="hidden">

                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="expresion-facial-switch" data-name="Expresión facial" type="checkbox" hidden="hidden">
                                          <label for="expresion-facial-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Destreza</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="destreza" name="destreza" value="" hidden="hidden">

                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="destreza-switch" data-name="Destreza" type="checkbox" hidden="hidden">
                                          <label for="destreza-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Dedicación</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="dedicacion" name="dedicacion" value="" hidden="hidden">

                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="dedicacion-switch" data-name="Dedicación" type="checkbox" hidden="hidden">
                                          <label for="dedicacion-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Oído musical</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="oido_musical" name="oido_musical" value="" hidden="hidden">

                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="oido-switch" data-name="Oído musical" type="checkbox" hidden="hidden">
                                          <label for="oido-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Postura</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">ç

                                      <input type="text" id="postura" name="postura" value="" hidden="hidden">

                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="postura-switch" data-name="Postura" type="checkbox" hidden="hidden">
                                          <label for="postura-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Respeto</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="respeto" name="respeto" value="" hidden="hidden">

                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="respeto-switch" data-name="Respeto" type="checkbox" hidden="hidden">
                                          <label for="respeto-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Elasticidad</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="elasticidad" name="elasticidad" value="" hidden="hidden">

                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="elasticidad-switch" data-name="Elasticidad" type="checkbox" hidden="hidden">
                                          <label for="elasticidad-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-16 f-700">Complejidad de movimientos</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="complejidad_de_movimientos" name="complejidad_de_movimientos" value="" hidden="hidden">

                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="complejidad-switch" data-name="Complejidad de movimientos" type="checkbox" hidden="hidden">
                                          <label for="complejidad-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Asistencia</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="asistencia" name="asistencia" value="" hidden="hidden">

                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="asistencia-switch" data-name="Asistencia" type="checkbox" hidden="hidden">
                                          <label for="asistencia-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Estilo</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="estilo" name="estilo" value="" hidden="hidden">

                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="estilo-switch" data-name="Estilo" type="checkbox" hidden="hidden">
                                          <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>
                                      <div class="col-sm-3">
                                      <label for="nombre" id="id-item_nuevo">Nombre</label>
                                      <input type="text" class="form-control input-sm" name="item_nuevo" id="item_nuevo" placeholder="Ej. Ritmo" value="">
                                      </div>
                                      <div class="clearfix p-b-35"></div>
                                      <div class="col-md-2">
                                  <button type="button" class="btn btn-blanco m-r-8 f-10 guardar" name= "add" id="add" > Agregar Linea <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>
                                </div>

                                <div class="col-sm-4">
                                  <div class="has-error" id="error-item_nuevo">
                                        <span >
                                          <small class="help-block error-span" id="error-item_nuevo_mensaje" ></small>                                           
                                        </span>
                                    </div>
                                </div>

                                <div class="clearfix p-b-35"></div>
                      

                          <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="forma_pago">nombre</th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc">Acciones</th>
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
                                 <div class="has-error" id="error-nombre">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-descripcion">Concepto General</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Reseña el concepto general, del desarrollo y objetivos de la valoración" title="" data-original-title="Ayuda"></i>

                                    <br></br>

                                    <div class="fg-line">
                                      <textarea class="form-control" id="descripcion" name="descripcion" rows="2" placeholder="300 Caracteres"></textarea>
                                    </div>
                                 <div class="has-error" id="error-descripcion">
                                      <span >
                                          <small class="help-block error-span" id="error-descripcion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="condiciones" id="id-condiciones">Condiciones y Normativas</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa las condiciones necesarias, dichas condiciones serán vistas por tus clientes y de esa forma podrás mantener una comunicación clara y transparente en cuanto a las normativas que rigen en tus actividades" title="" data-original-title="Ayuda"></i>
                                    <br></br>

                                    <div class="fg-line">
                                      <textarea class="form-control" id="condiciones" name="condiciones" rows="2" placeholder="1500 Caracteres"></textarea>
                                      </div>
                                    <div class="has-error" id="error-condiciones">
                                      <span >
                                        <small class="help-block error-span" id="error-condiciones_mensaje" ></small>                                           
                                      </span>
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

                            <div class="clearfix p-b-35"></div>
                            
                            <div class="col-sm-12 text-left">    

                              <button type="button" class="btn btn-blanco m-r-10 f-18 guardar" id="guardar" >Crear una Valoración</button>

                              <button type="button" class="cancelar btn btn-default" id="cancelar">Cancelar</button>

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
            <!-- <input type="text" id="dataItems"> -->
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

  route_agregar="{{url('/')}}/especiales/examenes/agregar";
  route_principal="{{url('/')}}/especiales/examenes";
  route_add="{{url('/')}}/especiales/examenes/agregar_item";
  route_eliminar="{{url('/')}}/especiales/examenes/eliminar_item";
  $(document).ready(function(){

    clase_grupal_id = "{{{ $clase_grupal_id or 'Default' }}}";

     if(clase_grupal_id != 'Default'){
        $('#clase_grupal_id').val(clase_grupal_id)
        $('#clase_grupal_id').selectpicker('refresh')
        $('#clase_grupal').click();
        
     }

        document.getElementById("nombre").focus();
        $('body,html').animate({scrollTop : 0}, 500);
        var animation = 'fadeInDownBig';
        $("#item_nuevo").val('');
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



 
   $("#guardar").click(function(){

        //RECORRIDO DE LOS CHECKBOX
        //-------------------------
          var inputs = document.getElementById("agregar_examen").getElementsByTagName("input");
          var dataItems = '';
          for(var i = 0 ; i < inputs.length ; i++){
              if (inputs[i].type=='checkbox'){
                  if(inputs[i].checked){
                      dataItems += '{"id" : "'+inputs[i].dataset.name+'"},';
                  }
              }
          }
          dataItems = dataItems.substring(0, dataItems.length -1);
          dataItems = '['+dataItems+']';
        //--------------------------  
                var route = route_agregar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#agregar_examen" ).serialize();
                        //+'&items='+dataItems; 
                $("#guardar").attr("disabled","disabled");
                procesando();
                $("#guardar").css({
                  "opacity": ("0.2")
                });
                $(".cancelar").attr("disabled","disabled");
                $(".procesando").removeClass('hidden');
                $(".procesando").addClass('show');

                var genero = [];
                $('#genero option:selected').each(function() {
                  genero.push( $( this ).text() );
                });
               
                limpiarMensaje();
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data:datos+"&genero="+genero+"&clase_grupal_id="+$('#clase_grupal_id').val(),
                    success:function(respuesta){
                      setTimeout(function(){ 
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
                          // 
                          if("{{$usuario_tipo}}" != 3){
                          	window.location = route_principal;
                          }else{
                          	window.location = "{{$_SERVER['HTTP_REFERER']}}"
                          }
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

                        }
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
  });

  setInterval(porcentaje, 1000);

  function porcentaje(){
    var campo = ["nombre", "fecha", "descripcion", "instructor_id", "color_etiqueta", "condiciones"];
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




      function limpiarMensaje(){
        var campo = ["nombre", "fecha", "descripcion", "instructor_id", "color_etiqueta", "genero", "condiciones", "clase_grupal_id"];
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
      }, 800);          

    }

      function collapse_minus(collaps){
       $('#'+collaps).collapse('hide');
      }

      $("#tiempos-switch").on('change', function(){
          if ($("#tiempos-switch").is(":checked")){
            $("#tiempos_musicales").val('1');
          }else{
            $("#tiempos_musicales").val('0');
          }
          console.log($("#tiempos_musicales").val());     
        });

      $("#compromiso-switch").on('change', function(){
          if ($("#compromiso-switch").is(":checked")){
            $("#compromiso").val('1');
          }else{
            $("#compromiso").val('0');
          }     
        });

      $("#condiciones-switch").on('change', function(){
          if ($("#condiciones-switch").is(":checked")){
            $("#condicion").val('1');
          }else{
            $("#condicion").val('0');
          }     
        });

      $("#habilidades-switch").on('change', function(){
          if ($("#habilidades-switch").is(":checked")){
            $("#habilidades").val('1');
          }else{
            $("#habilidades").val('0');
          }     
        });

      $("#disciplina-switch").on('change', function(){
          if ($("#disciplina-switch").is(":checked")){
            $("#disciplina").val('1');
          }else{
            $("#disciplina").val('0');
          }     
        });

      $("#expresion-corporal-switch").on('change', function(){
          if ($("#expresion-corporal-switch").is(":checked")){
            $("#expresion_corporal").val('1');
          }else{
            $("#expresion_corporal").val('0');
          }     
        });

      $("#expresion-facial-switch").on('change', function(){
          if ($("#expresion-facial-switch").is(":checked")){
            $("#expresion_facial").val('1');
          }else{
            $("#expresion_facial").val('0');
          }     
        });

      $("#destreza-switch").on('change', function(){
          if ($("#destreza-switch").is(":checked")){
            $("#destreza").val('1');
          }else{
            $("#destreza").val('0');
          }     
        });

      $("#dedicacion-switch").on('change', function(){
          if ($("#dedicacion-switch").is(":checked")){
            $("#dedicacion").val('1');
          }else{
            $("#dedicacion").val('0');
          }     
        });

      $("#oido-switch").on('change', function(){
          if ($("#oido-switch").is(":checked")){
            $("#oido_musical").val('1');
          }else{
            $("#oido_musical").val('0');
          }     
        });

      $("#postura-switch").on('change', function(){
          if ($("#postura-switch").is(":checked")){
            $("#postura").val('1');
          }else{
            $("#postura").val('0');
          }     
        });

      $("#respeto-switch").on('change', function(){
          if ($("#respeto-switch").is(":checked")){
            $("#respeto").val('1');
          }else{
            $("#respeto").val('0');
          }     
        });

      $("#elasticidad-switch").on('change', function(){
          if ($("#elasticidad-switch").is(":checked")){
            $("#elasticidad").val('1');
          }else{
            $("#elasticidad").val('0');
          }     
        });

      $("#complejidad-switch").on('change', function(){
          if ($("#complejidad-switch").is(":checked")){
            $("#complejidad_de_movimientos").val('1');
          }else{
            $("#complejidad_de_movimientos").val('0');
          }     
        });

      $("#asistencia-switch").on('change', function(){
          if ($("#asistencia-switch").is(":checked")){
            $("#asistencia").val('1');
          }else{
            $("#asistencia").val('0');
          }     
        });

      $("#estilo-switch").on('change', function(){
          if ($("#estilo-switch").is(":checked")){
            $("#estilo").val('1');
          }else{
            $("#estilo").val('0');
          }     
        });
      $('#collapseTwo').on('show.bs.collapse', function () {
        $("#guardar").attr("disabled","disabled");
        $("#guardar").css({"opacity": ("0.2")});
      })

      $('#collapseTwo').on('hide.bs.collapse', function () {
        $("#guardar").removeAttr("disabled");
        $("#guardar").css({"opacity": ("1")});
      })

       $( "#cancelar" ).click(function() {
        $("#agregar_examen")[0].reset();
        $('#instructor_id').selectpicker('render');
        limpiarMensaje();
        $('html,body').animate({
        scrollTop: $("#valoracion_id").offset().top-90,
        }, 1500);
        $("#nombre").focus();
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
          /*if ($('#tablelistar tr').length < 25) {
              $('.dataTables_paginate').hide();
          }
          else{
             $('.dataTables_paginate').show();
          }*/
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

       $("#add").click(function(){

              var route = route_add;
                  var token = $('input:hidden[name=_token]').val();
                  var datos = '&item_nuevo='+ $('#item_nuevo').val(); 
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

                            $("#item_nuevo").val('');

                            var item_nuevo = respuesta.item_nuevo;

                            var rowId=respuesta.id;
                            var rowNode=t.row.add( [
                            ''+item_nuevo+'',
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
                          $(".cancelar").removeAttr("disabled");
                          $("#add").removeAttr("disabled");
                          $("#add").css({
                            "opacity": ("1")
                          });

                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                        }, 1000);
                      },
                      error:function(msj){
                        setTimeout(function(){ 
                        //   if (typeof msj.responseJSON === "undefined") {
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

$('#tablelistar tbody').on( 'click', 'i.zmdi-delete boton red', function () {
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

      $('input[name="boolean_grupal"]').on('change', function(){
          if ($(this).val()=='0') {
                $('.clase_grupal').hide();
          } else  {
                $('.clase_grupal').show();
          }
       });

      $('#pop-instructor').popover({
                html: true,
                trigger: 'manual'
            }).on( "mouseenter", function(e) {

                $(this).popover('show');
                
                e.preventDefault();
      });

      $('.ayuda').on('mouseenter', function(e) {
        $('.ayuda').not(this).popover('hide')
      })

</script> 
@stop

