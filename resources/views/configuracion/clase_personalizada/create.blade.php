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
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/configuracion/clases-personalizadas" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw" ></i> Sección clase personalizada</a>
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-reservaciones f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-center">
                            <span class="f-25 c-morado"><i class="icon_a-clase-personalizada f-25" id="id-clase_grupal_id"></i> Agregar clase personalizada </span>                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                          <form name="agregar_clasepersonalizada" id="agregar_clasepersonalizada">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>

                            <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-nombre">Nombre</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre de la clase personalizada" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a icon_a-clase-personalizada f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="nombre" id="nombre" placeholder="Ej. Salsa Casino">
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
                                 
                                    <label for="nombre" id="id-costo">Costo</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el valor o precio el cual estara sujetado la clase personalizada" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-costo f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="costo" id="costo" data-mask="0000000000" placeholder="Ej. 2500">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-costo">
                                      <span >
                                          <small class="help-block error-span" id="error-costo_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="descripcion" id="id-descripcion">Descripción</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Presenta los objetivos de la clase grupal e infórmale de los beneficios que recibirán al momento de realizarla" title="" data-original-title="Ayuda"></i>
                                    <div class="fg-line">
                                      <textarea class="form-control" id="descripcion" name="descripcion" rows="8" placeholder="2000 Caracteres" maxlength="2000" onkeyup="countChar(this)"></textarea>
                                    </div>
                                    <div class="opaco-0-8 text-right">Resta <span id="charNum">2000</span> Caracteres</div>
                                 </div>
                                 <div class="has-error" id="error-descripcion">
                                      <span >
                                          <small class="help-block error-span" id="error-descripcion_mensaje"  ></small>                                           
                                      </span>
                                  </div>
                               </div>
                               
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                <label for="apellido" id="id-imagen">Cargar Imagen</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Carga una imagen horizontal  para que sea utilizada cuando compartes en Facebook.  Resolución recomendada: 1200 x 630, resolución mínima: 600 x 315" title="" data-original-title="Ayuda"></i>
                                
                                <div class="clearfix p-b-15"></div>
                                  
                                  <input type="hidden" name="imageBase64" id="imageBase64">
                                  <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div id="imagena" class="fileinput-preview thumbnail" data-trigger="fileinput"></div>
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
                                    <div class="cp-container">
                                        <label for="fecha_cobro" id="id-color_etiqueta">Color de etiqueta</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona un color de etiqueta para la clase personalizada que será visualizado por tus alumnos e instructores en el calendario de eventos" title="" data-original-title="Ayuda"></i>
                                        <div class="input-group form-group">

                                            <span class="input-group-addon"><i class="zmdi zmdi-invert-colors f-22"></i></span>
                                            <div class="fg-line dropdown">
                                                <input type="text" name="color_etiqueta" id="color_etiqueta" class="form-control cp-value proceso pointer" value="#ec89df" data-toggle="dropdown">
                                                    
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
                                        
                                    <div class="form-group">

                                    <div class="col-sm-12">
                                        <label for="tiempo_expiracion" id="id-tiempo_expiracion">Cancelación temprana/ tardía</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-html="true" data-content=" * <span class='f-700 f-16'>Cancelación temprana:</span> sucede cuando el alumno ha cancelado o suspendido en un tiempo prudente la reserva de una clase personalizada, brindando la oportunidad a la academia de suspender la clase, sin que se genere dificultad alguna. En este caso el alumno, tendrá la oportunidad de reprograma su clase. <br> <br>
                                        
                                        * <span class='f-700 f-16'>Cancelación tardía:</span> sucede cuando el alumno ha cancelado o suspendido en un tiempo muy próximo o cercano a la  clase personalizada, dejando imposibilitada a la academia a suspender sin dificultad alguna dicha clase.  En este caso el alumno, no tendrá la oportunidad de reprograma su clase y deberá gestionar el pago de la misma." title="" data-original-title="Ayuda"></i>
                                      </div>

                                        <div class="clearfix p-b-35"></div>
                                        
                                        <div class="col-sm-4" style="width:35%">
                                        <label for="tiempo_expiracion" id="id-tiempo_expiracion">Culmina el plazo de cancelación temprana en </label>
                                        </div>
                                        <div class="col-sm-1">
                                        <input type="text" class="form-control input-sm input-mask" name="tiempo_expiracion" id="tiempo_expiracion" data-mask="00" placeholder="Ej. 24">
                                        </div>

                                        <div class="col-sm-5">
                                        <label for="tiempo_expiracion"> horas antes del inicio de la clase personalizada</label>

                                      </div>

                                      <br><br>
                                  <div class="col-sm-12">
                                    <div class="has-error" id="error-tiempo_expiracion">
                                      <span >
                                          <small id="error-tiempo_expiracion_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>
                               <div class="clearfix p-b-35"></div>


                                <div class="clearfix p-b-35"></div>

                                 <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Opciones Avanzadas</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Configura nuevos paquetes" title="" data-original-title="Ayuda"></i>
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

                                    
                                      <div class="col-sm-6">
                                        <label for="nombre" id="id-participantes">Ingresa la cantidad de participantes</label>
                                        <input type="text" class="form-control input-sm" name="participantes" id="participantes" data-mask="0000" placeholder="Ej. 3" value="">
                                      </div>

                                      <div class="col-sm-6">
                                        <label for="nombre" id="id-precio">Ingresa el precio</label>
                                        <input type="text" class="form-control input-sm" name="precio" id="precio" data-mask="0000000000" placeholder="Ej. 35000" value="">
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="col-md-2">
                                  <button type="button" class="btn btn-blanco m-r-8 f-10 guardar" name= "add" id="add" > Agregar Linea <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>
                                </div>

                                <div class="col-sm-6">
                                  <div class="has-error" id="error-participantes">
                                        <span >
                                          <small class="help-block error-span" id="error-participantes_mensaje" ></small>                                           
                                        </span>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                  <div class="has-error" id="error-precio">
                                        <span >
                                          <small class="help-block error-span" id="error-precio_mensaje" ></small>                                           
                                        </span>
                                    </div>
                                </div>

                                <div class="clearfix p-b-35"></div>
                      

                          <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="participantes">Participantes</th>
                                    <th class="text-center" data-column-id="precio">Precio</th>
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


                               <!-- <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Multihorarios</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Desde este campo podrás crear distintos instructores, especialidades, horarios y días de la semana de la clase personalizada" title="" data-original-title="Ayuda"></i>
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
                                          @foreach ( $instructor as $instructores )
                                          <option value = "{{ $instructores['id'] }}">{{ $instructores['nombre'] }} {{ $instructores['apellido'] }}</option>
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
                                          @foreach ( $especialidad as $especialidades )
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
                              <div class="clearfix p-b-35"></div>

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
                               </div>

                               <div class="clearfix p-b-35"></div> -->
            

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

                              <button type="button" class="btn btn-blanco m-r-10 f-18 guardar" id="guardar" >Guardar</button>

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

  route_agregar="{{url('/')}}/configuracion/clases-personalizadas/agregar";
  route_principal="{{url('/')}}/configuracion/clases-personalizadas";
  // route_horario="{{url('/')}}/agendar/clases-grupales/agregarhorario";
  // route_eliminar="{{url('/')}}/agendar/clases-grupales/eliminarhorario";


  route_add="{{url('/')}}/configuracion/clases-personalizadas/agregar_costo";
  route_eliminar="{{url('/')}}/configuracion/clases-personalizadas/eliminar_costo";

  $(document).ready(function(){

      $("#agregar_clasepersonalizada")[0].reset();


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
    var campo = ["nombre", "color_etiqueta", "costo", "tiempo_expiracion", "imagen"];
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
        bPaginate: false, 
        bFilter:false, 
        bSort:false, 
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
                var datos = $( "#agregar_clasepersonalizada" ).serialize(); 
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
                          $("#agregar_clasepersonalizada")[0].reset();
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

  //       $("#add").click(function(){

  //               var route = route_horario;
  //               var token = $('input:hidden[name=_token]').val();
  //               var datos = $( "#agregar_clasepersonalizada" ).serialize(); 

  //               $.ajax({
  //                   url: route,
  //                       headers: {'X-CSRF-TOKEN': token},
  //                       type: 'POST',
  //                       dataType: 'json',
  //                       data:datos,
  //                   success:function(respuesta){
  //                     setTimeout(function(){ 
  //                       var nFrom = $(this).attr('data-from');
  //                       var nAlign = $(this).attr('data-align');
  //                       var nIcons = $(this).attr('data-icon');
  //                       var nAnimIn = "animated flipInY";
  //                       var nAnimOut = "animated flipOutY"; 
  //                       if(respuesta.status=="OK"){
  //                         var nType = 'success';
  //                         var nTitle="Ups! ";
  //                         var nMensaje=respuesta.mensaje;

  //                         var instructor_id = respuesta.array[0].instructor;
  //                         var especialidad_id = respuesta.array[0].especialidad;
  //                         var dia_de_semana_id = respuesta.array[0].dia_de_semana;
  //                         var hora_inicio = respuesta.array[0].hora_inicio;
  //                         var hora_final = respuesta.array[0].hora_final;

  //                         var rowId=respuesta.id;
  //                         var rowNode=t.row.add( [
  //                         ''+instructor_id+'',
  //                         ''+especialidad_id+'',
  //                         ''+dia_de_semana_id+'',
  //                         ''+hora_inicio+'',
  //                         ''+hora_final+'',
  //                         '<i class="zmdi zmdi-delete f-20 p-r-10"></i>'
  //                         ] ).draw(false).node();
  //                         $( rowNode )
  //                         .attr('id',rowId)
  //                         .addClass('seleccion');

  //                       }else{
  //                         var nTitle="Ups! ";
  //                         var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
  //                         var nType = 'danger';
  //                       }                       
  //                       $(".procesando").removeClass('show');
  //                       $(".procesando").addClass('hidden');
  //                       $("#guardar").removeAttr("disabled");
  //                       $(".cancelar").removeAttr("disabled");

  //                       notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
  //                     }, 1000);
  //                   },
  //                   error:function(msj){
  //                     setTimeout(function(){ 
  //                       if (typeof msj.responseJSON === "undefined") {
  //                         window.location = "{{url('/')}}/error";
  //                       }
  //                       if(msj.responseJSON.status=="ERROR"){
  //                         console.log(msj.responseJSON.errores);
  //                         errores(msj.responseJSON.errores);
  //                         var nTitle="    Ups! "; 
  //                         var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
  //                       }else{
  //                         var nTitle="   Ups! "; 
  //                         var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
  //                       }                        
  //                       $("#guardar").removeAttr("disabled");
  //                       $(".cancelar").removeAttr("disabled");
  //                       $(".procesando").removeClass('show');
  //                       $(".procesando").addClass('hidden');
  //                       var nFrom = $(this).attr('data-from');
  //                       var nAlign = $(this).attr('data-align');
  //                       var nIcons = $(this).attr('data-icon');
  //                       var nType = 'danger';
  //                       var nAnimIn = "animated flipInY";
  //                       var nAnimOut = "animated flipOutY";                       
  //                       notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
  //                     }, 1000);
  //                   }
  //               });

  //   });

  // $('#tablelistar tbody').on( 'click', 'i.zmdi-delete', function () {
  //       var padre=$(this).parents('tr');
  //       var token = $('input:hidden[name=_token]').val();
  //       var id = $(this).closest('tr').attr('id');
  //             $.ajax({
  //                  url: route_eliminar+"/"+id,
  //                  headers: {'X-CSRF-TOKEN': token},
  //                  type: 'POST',
  //                  dataType: 'json',                
  //                 success: function (data) {
  //                   if(data.status=='OK'){
                        
                      
                                         
  //                   }else{
  //                     swal(
  //                       'Solicitud no procesada',
  //                       'Ha ocurrido un error, intente nuevamente por favor',
  //                       'error'
  //                     );
  //                   }
  //                 },
  //                 error:function (xhr, ajaxOptions, thrownError){
  //                   swal('Solicitud no procesada','Ha ocurrido un error, intente nuevamente por favor','error');
  //                 }
  //               })

  //               t.row( $(this).parents('tr') )
  //                 .remove()
  //                 .draw();
  //           });
  //           
    

    $("#add").click(function(){

              var route = route_add;
                  var token = $('input:hidden[name=_token]').val();
                  var datos = '&participantes='+ $('#participantes').val()+'&precio='+ $('#precio').val(); 
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

                            $("#participantes").val('');
                            $("#precio").val('');

                            var participantes = respuesta.participantes;
                            var precio = respuesta.precio;

                            var rowId=respuesta.id;
                            var rowNode=t.row.add( [
                            ''+participantes+'',
                            ''+precio+'',
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
        var campo = ["nombre", "color_etiqueta", "costo", "tiempo_expiracion", "imagen", "participantes", "precio"];
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
        $("#agregar_clasepersonalizada")[0].reset();
        limpiarMensaje();
        $('html,body').animate({
        scrollTop: $("#id-clase_grupal_id").offset().top-90,
        }, 1500);
        $("#id-nombre").focus();
      });

                 $('#pop-instructor').popover({
                    html: true,
                    trigger: 'manual'
                }).click(function(e) {

                  if($('.popover').hasClass('in')){
                     $(this).popover('hide');
                  } else {
                    $(this).popover('show');
                    $('.popover-content').append('<br> <a class="redirect pointer"> Llévame <i class="icon_a-instructor f-22"></i></a>');
                  }
            
                    $('.redirect').click(function(e){
                        window.location = "{{url('/')}}/participante/instructor/agregar";
                    });
                    e.preventDefault();
          });

          $('#pop-salon').popover({
                    html: true,
                    trigger: 'manual'
                }).click(function(e) {

                  if($('.popover').hasClass('in')){
                     $(this).popover('hide');
                  } else {
                    $(this).popover('show');
                    $('.popover-content').append('<br> <a class="redirect pointer"> Llévame <i class="icon_a-estudio-salon f-22"></i></a>');
                  }
            
                    $('.redirect').click(function(e){
                        window.location = "{{url('/')}}/configuracion/academia";
                    });
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

      function countChar(val) {
        var len = val.value.length;
        if (len >= 2000) {
          val.value = val.value.substring(0, 2000);
        } else {
          $('#charNum').text(2000 - len);
        }
      };

</script> 
@stop

