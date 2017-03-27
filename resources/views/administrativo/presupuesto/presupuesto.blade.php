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
<script src="{{url('/')}}/assets/vendors/input-mask/input-mask.min.js"></script>

@stop
@section('content')

<!-- <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Agregar <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="agregar_alumno" id="agregar_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Id - Pasaporte</label>
                                        <input type="text" class="form-control input-sm" name="identificacion" id="identificacion" placeholder="Ej. 16234987">
                                    </div>
                                    <div class="has-error" id="error-identificacion">
                                      <span >
                                          <small id="error-identificacion_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>
                               <div class="col-sm-6">
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


                               <div class="col-sm-6">
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

                               <div class="col-sm-6">
                                    <div class="form-group fg-line">
                                    <label for="apellido">Fecha de Nacimiento</label>
                                            <div class="dtp-container fg-line">
                                            <input name="fecha_nacimiento" id="fecha_nacimiento" class="form-control date-picker" placeholder="Seleciona" type="text">
                                        </div>
                                    </div>
                                    <div class="has-error" id="error-fecha_nacimiento">
                                      <span >
                                          <small class="help-block error-span" id="error-fecha_nacimiento_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                </div>

                                 <div class="clearfix"></div> 
           
                                    
                               

                               <div class="col-sm-6">
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
                               
                               <div class="clearfix"></div> 

                               
                               
                           </div>
                           
                        </div>
                        <div class="modal-footer p-b-20 m-b-20">
                            <div class="col-sm-7 text-left">
                              <div class="procesando hidden">
                              <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                              <div class="preloader pls-purple">
                                  <svg class="pl-circular" viewBox="25 25 50 50">
                                      <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                  </svg>
                              </div>
                              </div>
                            </div>
                            <div class="col-sm-5">                            
                              <a class="btn-blanco m-r-5 f-16 guardar" id="guardar" data-formulario="edit_id_alumno" data-update="identificacion" >  Acordar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>
                            </div>
                        </div></form>
                    </div>
                </div>
            </div> -->

            <div class="modal fade" id="modalConstruccion" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Información <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div class="text-center">
                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>
                        <div align="center"><i class="zmdi zmdi-wrench zmdi-hc-fw f-60 c-morado"></i></div>

                        <div class="clearfix p-b-15"></div>
                        
                        <div class="col-md-12">
                         <span class="f-20 opaco-0-8">¡ Modulo en construcción. !</span>
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


            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                      <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menú Principal</a>
                      <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-reservaciones f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                      <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 
                    
                      <div class="card">
                        <div class="card-header">
                          
                        <div class="col-xs-12 text-left">
                          <ul class="tab-nav tn-justified" role="tablist">
                              <li class="waves-effect"><a href="{{url('/')}}/administrativo/pagos/generar" aria-controls="home11" onclick="procesando()"><div class="icon_a icon_a-pagar f-30"></div><p style=" margin-bottom: -2px;">Pagos</p></a></li>
                              <li class="waves-effect"><a href="{{url('/')}}/administrativo/acuerdos/generar" aria-controls="home11" onclick="procesando()"><div class="icon_a icon_a-acuerdo-de-pago f-30"></div><p style=" margin-bottom: -2px;">Acuerdos</p></a></li>
                              <li class="waves-effect active"><a href="{{url('/')}}/administrativo/presupuestos/generar" aria-controls="home11" onclick="procesando()"><div class="icon_a icon_a-presupuesto f-30"></div><p style=" margin-bottom: -2px;">Presupuestos</p></a></li>
                              <li class="waves-effect"><a data-toggle="modal" href="{{url('/')}}/administrativo/egresos"><div class="icon_d icon_d-reporte f-30"></div><p style=" margin-bottom: -2px;">Egresos</p></a></li>
                                    
                          </ul>
                        </div>

 <!--                            <div class="col-xs-12 text-right">
                            
                            <a class="f-16 p-t-0 text-right text-success" data-toggle="modal" href="#modalAgregar">Agregar Nuevo Cliente <i class="zmdi zmdi-account-add zmdi-hc-fw f-20 c-verde"></i></a>
                            </div> -->

                            <div class="clearfix p-b-15"></div>

                        </div>
                        


                        <div class="card-body p-b-20">
                          <form name="agregar_item" id="agregar_item"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>


                                    <div class="col-sm-12">
                                 
                                    <span class="f-30 text-center c-morado" id="id-cliente">Cliente</span>
                                

                                    <hr></hr>

                                    <div class="clearfix p-b-35"></div> 
                                 
                                    <div class="col-xs-6">
                                 
                                     <label for="alumno" id="id-alumno_id">Nombre del Cliente</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona un participante al cual generarás el presupuesto" title="" data-original-title="Ayuda"></i>

                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a-alumnos f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="alumno_id" id="alumno_id" data-live-search="true">
                                          <option value="">Selecciona</option>
                                          @foreach ( $alumnos as $alumno )
                                          <option value = "{{ $alumno['id'] }}">{{ $alumno['nombre'] }} {{ $alumno['apellido'] }} {{ $alumno['identificacion'] }}</option>
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
                                
                                <div class="col-xs-6">
                                    
                                      <label for="fecha_nacimiento" id="id-fecha_valida">Válido Hasta</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona la fecha que vence el presupuesto" title="" data-original-title="Ayuda"></i>
                                      <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-calendar-check f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="fecha_valida" id="fecha_valida" class="form-control date-picker proceso" placeholder="Selecciona" type="text">
                                          </div>

                                    </div>
                                    <div class="has-error" id="error-fecha_valida">
                                        <span >
                                            <small class="help-block error-span" id="error-fecha_valida_mensaje" ></small>                                           
                                        </span>
                                    </div>
                                </div>

                               </div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 <div class="col-sm-12">

                                    <label for="nombre" id="id-nota_cliente">Nota cliente</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Redacta alguna nota que desees generar a tu cliente" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="nota_cliente" id="nota_cliente" placeholder="100 Caracteres">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-nota_cliente">
                                      <span >
                                          <small class="help-block error-span" id="error-nota_cliente_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div> 
                               </div>

                               <div class="clearfix p-b-35"></div>
                          
                                    <div class="col-sm-12">
                                    
                                 
                                    <span class="f-30 text-center c-morado">Linea de Presupuesto</span>
                                    


                                    <hr></hr>
                                    
                                    <div class="clearfix p-b-35"></div>

                                    <span class="f-20 text-center" id="id-combo">Producto o Servicio</span><i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Se refiere a todos aquellos servicios y productos que ofreces en tu academia, algunos ejemplos de estos  son, clases personalizadas,  clases  grupales,  secciones de asesoría, , franelas, gorras, gomas de baile entre otros,  los productos y  servicios  que deseas podrán ser agregados en la sección de configuración general en el campo llamado productos  y servicios" title="" data-original-title="Ayuda"></i>

                                    <!-- <hr></hr> -->

                                    <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="servicio" value="servicio" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Servicio <i id="servicio2" class="icon_a-instructor c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="producto" value="producto" type="radio">
                                        <i class="input-helper"></i>  
                                        Producto <i id="producto2" class="icon_a-precios-y-servicios f-20"></i>
                                    </label>
                                    </div>
                                    
                                 </div>
                                </div>                                 <!-- <div class="col-sm-12"> -->
                            <div class="clearfix p-b-35"></div>

                                  <div class="col-sm-2 text-center">

                                   <span class="f-16 c-morado" id="id-combo">Producto o Servicio</span>

                                   </div>
                                   <div class="col-sm-2 text-center">

                                   <span class="f-16 c-morado">Cantidad</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="bottom" data-content="se refiere a la cantidad de productos o servicios que deseas agregar al cliente para la venta" title="" data-original-title="Ayuda"></i>

                                   </div>
                                   <div class="col-sm-2 text-center">

                                   <span class="f-16 c-morado" id ="id-linea">Precio (Neto)</span>

                                   </div>
                                   <div class="col-sm-2 text-center">

                                   <span class="f-16 c-morado">Impuesto</span>

                                   </div>

                                   <div class="col-sm-2 text-center">

                                   <span class="f-16 c-morado">Importe (Neto)</span>

                                   </div>


                              <div class="clearfix p-b-35"></div>

                                    <div class="col-sm-2">
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="form-control" name="combo" id="combo">
                                        </select>
                                      </div>
                                    </div>
                                  </div>

                              <div class="col-sm-2 text-center">
                                <!-- <input type="text" class="form-control input-sm" name="cantidad" id="cantidad" placeholder="Ej. 1"> -->
                                <input autocomplete="off" name="cantidad" id="cantidad" maxlength="5" class="form-control input-mask" data-mask="00000" placeholder="Ej. 10" type="text">
                              </div>

                              <div class="col-sm-2 text-center">
                                <input type="text" class="form-control input-sm text-center" name="precio_neto" id="precio_neto" readonly="readonly" placeholder="Ej. 1" value="0">
                              </div>

                              <div class="col-sm-2">
                                    <div class="fg-line">
                                      <div class="select text-center">
                                        <select class="form-control" name="impuesto" id="impuesto">
                                          <option value="0">0 %</option>
                                          <option value = "{{ $impuesto }}">{{$impuesto}} %</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>

                              <div class="col-sm-2 text-center">
                                <input type="text" class="form-control input-sm text-center" name="importe_neto" id="importe_neto" readonly="readonly" placeholder="Ej. 12" value="0">
                              </div>

                              <div class="clearfix p-b-35"></div>
                              
                              <div class="col-sm-2 text-center">
                                <div class="has-error" id="error-combo">
                                      <span >
                                        <small class="help-block error-span" id="error-combo_mensaje" ></small>                                           
                                      </span>
                                  </div>
                              </div>

                              <div class="col-sm-2 text-center">
                                <div class="has-error" id="error-cantidad">
                                      <span >
                                        <small class="help-block error-span" id="error-cantidad_mensaje" ></small>                                           
                                      </span>
                                  </div>
                              </div>

                              <br><br><br>

                            <!-- <div class="card-header text-left text-success">
                            <span class="f-16 p-t-0">Agregar Linea</span></div> -->
                              <div class="col-sm-2">

                              <button type="button" class="btn btn-blanco m-r-8 f-10 guardar" name= "add" id="add" > Agregar Linea <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>

                              </div>

                              
                              <div class="col-sm-4">
                                <div class="has-error" id="error-linea">
                                      <span >
                                        <small class="help-block error-span" id="error-linea_mensaje" ></small>                                           
                                      </span>
                                  </div>
                              </div>

                              <div class="clearfix p-b-15"></div>
                              
                            
                          <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="combo" data-type="numeric">Producto o Servicio</th>
                                    <th class="text-center" data-column-id="cantidad">Cantidad</th>
                                    <th class="text-center" data-column-id="precio_neto" data-order="desc">Precio (Neto)</th>
                                    <th class="text-center" data-column-id="impuesto" data-order="desc">Impuesto</th>
                                    <th class="text-center" data-column-id="importe_neto" data-order="desc">Importe (Neto)</th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" >Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                                           
                            </tbody>
                          </table>


                        </div>
                        </div>
                        <div class="clearfix p-b-15"></div>


                                    <div class="col-sm-12">

                                 
                                    <span id = "totales" class="f-30 text-center c-morado">Totales</span>
                                    
                                    
                                    <hr></hr>

                                    <div class="clearfix p-b-35"></div> 
                                 
                                    <div class="col-sm-12 text-right">
                                    <p><span class="f-15 c-morado">Sub total</span>
                                    <span class="f-15 c-morado" id = "subtotal">0</span>
                                    </p>
                                    <p><span class="f-15 text-right c-morado">Impuesto</span>
                                    <span class="f-15 c-morado" id = "impuestototal">0</span></p>
                                    <p><span class="f-15 text-right c-morado">Total</span>
                                    <span class="f-15 c-morado" id = "total">0</span></p>
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
                            

                            <div class="col-sm-12"> 
                              <!-- <i class="zmdi zmdi-cloud zmdi-hc-fw f-20 m-r-5 boton blue sa-warning" data-original-title="Guardar" data-toggle="tooltip" data-placement="bottom" title=""></i> -->

                              <div class="text-center">
                                <a href="{{url('/')}}/administrativo/presupuestos"><i class="zmdi zmdi-eye zmdi-hc-fw f-30 boton blue sa-warning"></i></a>

                                <br>

                                <span class="f-700 opaco-0-8 f-16">Sección Presupuesto</span>
                              </div>

                              <div class="text-right">                           
                                <button type="button" class="btn btn-blanco m-r-10 f-14 guardar" name= "pagar" id="pagar" >Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>

                                <button type="button" class="cancelar btn btn-default" name="cancelar" id="cancelar">Cancelar</button>
                              </div>
                              
                               
                            </div>
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


@stop
@section('js') 
<script type="text/javascript">

  var impuestoglobal
  var subtotalfinal = 0;
  var impuestofinal = 0;
  var totalfinal = 0;
  var tipo = 'servicio';

  route_principal="{{url('/')}}/administrativo/presupuestos";
  route_agregar="{{url('/')}}/administrativo/presupuestos/agregaritem";
  route_eliminar="{{url('/')}}/administrativo/presupuestos/eliminaritem";
  route_factura="{{url('/')}}/administrativo/presupuestos/generar";
  route_cancelar = "{{url('/')}}/administrativo/pagos/cancelarpago"


  function formatmoney(n) {
    return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
  }

  $( document ).ready(function() {

    rechargeServicio();

    $('body,html').animate({scrollTop : 0}, 2500);
        var animation = 'fadeInUpBig';
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

    $("#impuesto").val($("#impuesto option:first").val());
    $("#combo").val($("#combo option:first").val());
    $('input[name="cantidad"]').val(1)
    $('input[name="importe_neto"]').val(0)
    $('input[name="precio_neto"]').val(0)
    $("#servicio").prop("checked", true);

    // impuestoglobal = $("#impuesto option:selected").val();
    impuestoglobal = 0;
    subtotalglobal = 0;

    setTimeout(function(){ 

      $('html,body').animate({
            scrollTop: $("#id-cliente").offset().top-90,
            }, 1000);

      }, 1000);

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

  $("#pagar").click(function(){

                var route = route_factura;
                var token = $('input:hidden[name=_token]').val();
                // var datos = "&alumno_id="+$("#alumno_id option:selected" ).val();
                var datos = $( "#agregar_item" ).serialize();  
                limpiarMensaje();
                procesando();
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

                          window.location = route_principal;

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }                       
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        // finprocesado();
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
                        finprocesado();
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

    $("#servicio").click(function(){
        $( "#producto2" ).removeClass( "c-verde" );
        $( "#servicio2" ).addClass( "c-verde" );
    });

    $("#producto").click(function(){
        $( "#servicio2" ).removeClass( "c-verde" );
        $( "#producto2" ).addClass( "c-verde" );
    });
    
    //var=ser
    
    function rechargeServicio(){

    var servicio = <?php echo json_encode($servicio);?>;

    $('#combo').append( new Option("Selecciona",""));
    $.each(servicio, function (index, array) {
      $.each(array, function (index, arreglo) {
      
        $('#combo').append( new Option(arreglo.nombre,arreglo.id + "-" + arreglo.costo));
      });
    });
    $('input[name="importe_neto"]').val(0)
    $('input[name="precio_neto"]').val(0)
    $('input[name="cantidad"]').val(1)

    }

    function rechargeProducto(){

    var producto = <?php echo json_encode($producto);?>;

    $('#combo').append( new Option("Selecciona",""));
    // for (i in producto)
    $.each(producto, function (index, array) {
      $.each(array, function (index, arreglo) {
        $('#combo').append( new Option(arreglo.nombre,arreglo.id + "-" + arreglo.costo));
      });
    });

    $('input[name="importe_neto"]').val(0)
    $('input[name="precio_neto"]').val(0)

    } 

    $('input[name="tipo"]').on('change', function(){

    if ($(this).val()=='servicio') {
          tipo = 'servicio';
          $('#combo').empty();
          rechargeServicio();
    } else  {
          tipo = 'producto';
          $('#combo').empty();
          rechargeProducto();
    }
      $('input[name="cantidad"]').val(1)
    });


    $("#combo").change(function(){

      var combo = $(this).val();
      var split = combo.split('-');
      var costo = split[1];
      var index = split[0];
      var cantidad = $('input[name="cantidad"]').val()
      var costo2 = parseFloat(costo);
      var cantidad2 = parseFloat(cantidad);
      var impuesto = $("#impuesto option:selected" ).val();

      var total = costo2 * cantidad2

      if(tipo == 'servicio'){

        var servicio = <?php echo json_encode($servicio);?>;

        console.log(index);

        incluye_iva = servicio[index][0]['incluye_iva'];

        if(incluye_iva){
          $("#impuesto").val("{{$impuesto}}");
        }
        else{
          $("#impuesto").val(0);
        }

      }else{

        var producto = <?php echo json_encode($producto);?>;
        incluye_iva = producto[index][0]['incluye_iva'];

        if(incluye_iva){
          $("#impuesto").val("{{$impuesto}}");
        }
        else{
          $("#impuesto").val(0);
        }

      }

      if(isNaN(total) || total == 0){
        costo2 = 0;
      }

      $('input[name="precio_neto"]').val(formatmoney(costo2))


      if(isNaN(total)){
        total = 0;
      }

      $('input[name="importe_neto"]').val(formatmoney(total))
      $('input[name="cantidad"]').val(1)

    });

    $("#cantidad").change(function(){

      var combo = $("#combo option:selected" ).val();
      var split = combo.split('-');
      var costo = split[1];
      var cantidad = $(this).val();
      var costo2 = parseFloat(costo);
      var cantidad2 = parseFloat(cantidad);
      var impuesto = $("#impuesto option:selected" ).val();

      var total = costo2 * cantidad2

      if(isNaN(total) || total == 0){
        costo2 = 0;
      }

      $('input[name="precio_neto"]').val(formatmoney(costo2))


      if(isNaN(total)){
        total = 0;
      }

      $('input[name="importe_neto"]').val(formatmoney(total))
      
    });

    $("#impuesto").change(function(){

      var combo = $("#combo option:selected" ).val();
      var split = combo.split('-');
      var costo = split[1];
      var cantidad = $('input[name="cantidad"]').val()
      var costo2 = parseFloat(costo);
      var cantidad2 = parseFloat(cantidad);
      var total = costo2 * cantidad2
      var impuesto = $("#impuesto option:selected" ).val();

      if(isNaN(total) || total == 0){
        costo2 = 0;
      }

      $('input[name="precio_neto"]').val(formatmoney(costo2))

      if(isNaN(total)){
        total = 0;
      }

      $('input[name="importe_neto"]').val(formatmoney(total))
      
    });

    $("#add").click(function(){


      $("#add").attr("disabled","disabled");
        $("#add").css({
          "opacity": ("0.2")
        });

      var route = route_agregar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#agregar_item" ).serialize(); 
                limpiarMensaje();

                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data:datos + "&impuestoglobal="+impuestoglobal + "&alumno_id="+alumno_id,
                    success:function(respuesta){
                      setTimeout(function(){ 
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        if(respuesta.status=="OK"){
                          var nType = 'success';
                          $("#mujer").prop("checked", true);
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;

                          // $.each(respuesta.proforma, function (index, array) {
                            // $("#tablelistar tbody").each(function (i, row) {
                            //     var actualrow = $(row);

                            //     console.log(row.attributes);
                                
                                
                              // });

                            // var MyRows = $('#tablelistar');
                            // console.log(MyRows.html());
                            // for (var i = 0; i < MyRows.length; i++) {
                            //   var MyIndexValue = $(MyRows[i]).find('td:eq(0)').html();
                            // }
                           // });

                          // $("#tablelistar").bootgrid().bootgrid("reload");

                          var nombre = respuesta.array[0].nombre;
                          var cantidad = respuesta.array[0].cantidad;
                          var precio_neto = respuesta.array[0].precio_neto;
                          var impuesto = respuesta.array[0].impuesto;
                          var importe_neto = respuesta.array[0].importe_neto;

                          var rowId=respuesta.id;
                          var rowNode=t.row.add( [
                          ''+nombre+'',
                          ''+cantidad+'',
                          ''+formatmoney(parseFloat(precio_neto))+'',
                          ''+impuesto+'',
                          ''+formatmoney(parseFloat(importe_neto))+'',
                          '<i class="zmdi zmdi-delete f-20 p-r-10"></i>'
                          ] ).draw(false).node();
                          $( rowNode )
                          .attr('id',rowId)
                          // .attr('data-precio',precio_neto)
                          .addClass('seleccion');
                          
                          var importe_neto = respuesta.array[0].importe_neto;
                          var impuesto = respuesta.array[0].impuesto;
                          // var preciostring = importe_neto.toString(); 
                          // precioint = preciostring.replace(",", "");

                          subtotalfinal = parseFloat(importe_neto);
                          impuestofinal = parseFloat(subtotalfinal) * (impuesto / 100);

                          subtotalglobal = subtotalglobal + subtotalfinal;
                          impuestoglobal = impuestofinal + impuestoglobal;
                          subtotalglobal = subtotalglobal - impuestofinal;
                          totalfinal = subtotalglobal + impuestoglobal;

                          $("#subtotal").text(formatmoney(subtotalglobal));
                          $("#impuestototal").text(formatmoney(impuestoglobal));
                          $("#total").text(formatmoney(totalfinal));

                          tipo = 'servicio';
                          $("#servicio").prop("checked", true);
                          $('#combo').empty();
                          rechargeServicio();

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
                        $("#add").removeAttr("disabled");
                          $("#add").css({
                            "opacity": ("1")
                          });                        
                        $("#guardar").removeAttr("disabled");
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

    //FUNCION ELIMINAR

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

                      impuesto = data.impuesto;
                      subtotalglobal = subtotalglobal - data.importe_neto + impuesto;
                      impuestoglobal = impuestoglobal - impuesto;
                      totalfinal = subtotalglobal + impuestoglobal;

                      console.log(data.importe_neto);
                      console.log(impuesto);

                      $("#subtotal").text(subtotalglobal.toFixed(2));
                      $("#impuestototal").text(impuestoglobal.toFixed(2));
                      $("#total").text(totalfinal.toFixed(2));

                      // $(row).remove();
                                       
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

    // $("#pagar").click(function(){
    //         var id = 10;
    //         var token = $('input:hidden[name=_token]').val();
    //         $.ajax({
    //              url: route_pagar+"/"+id,
    //              headers: {'X-CSRF-TOKEN': token},
    //              type: 'POST',
    //              dataType: 'json',                
    //             success: function (data) {
    //               if(data.status=='OK'){
                      
    //                   swal('PAGO','error');
                                       
    //               }else{
    //                 swal(
    //                   'Solicitud no procesada',
    //                   'Ha ocurrido un error, intente nuevamente por favor',
    //                   'error'
    //                 );
    //               }
    //             },
    //             error:function (xhr, ajaxOptions, thrownError){
    //               swal('Solicitud no procesada','Ha ocurrido un error, intente nuevamente por favor','error');
    //             }
    //           })

    //           t.row( $(this).parents('tr') )
    //             .remove()
    //             .draw();
    //       });
        

      function limpiarMensaje(){
        var campo = ["alumno_id", "combo", "cantidad"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
      var campo = ["alumno_id", "combo", "cantidad"];
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

  function subir(){
    $('modalAgregar').animate({scrollTop : 0}, 500);
  }

  $( "#cancelar" ).click(function() {

        var padre=$(this).parents('tr');
        var token = $('input:hidden[name=_token]').val();

            $.ajax({
                 url: route_cancelar,
                 headers: {'X-CSRF-TOKEN': token},
                 type: 'POST',
                 dataType: 'json',                
                success: function (data) {
                  if(data.status=='OK'){

                    $("#agregar_item")[0].reset();
                    $('#alumno_id').selectpicker('render');
                    limpiarMensaje();
                    $('#combo').empty();
                    impuestoglobal = 0;
                    subtotalglobal = 0;
                    rechargeServicio();

                    $("#subtotal").text(0);
                    $("#impuestototal").text(0);
                    $("#total").text(0);

                       t
                        .clear()
                        .draw();
                                       
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

        $('html,body').animate({
        scrollTop: $("#id-cliente").offset().top-90,
        }, 1000);
      });



</script> 
@stop

