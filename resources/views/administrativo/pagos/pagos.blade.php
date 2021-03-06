@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/farbtastic/farbtastic.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/app.min.1.css">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/farbtastic/farbtastic.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script src="{{url('/')}}/assets/vendors/input-mask/input-mask.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bootgrid/jquery.bootgrid.min.js"></script>

@stop


@section('content')

          <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Agregar <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">??</span></button></h4>
                        </div>
                        <form name="form_agregar" id="form_agregar"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input type="hidden" id="editar" name="editar" value="">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id" id="id-identificacion">Id - Pasaporte</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el n??mero de c??dula o pasaporte del participante" title="" data-original-title="Ayuda"></i>
                                        <input type="text" class="form-control input-sm" name="identificacion" id="identificacion" data-mask="00000000000000000000" placeholder="Ej. 16234987">
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
                                    <label for="nombre" id="id-nombre">Nombre</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del participante" title="" data-original-title="Ayuda"></i>
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
                                    <label for="id-apellido" id="id-apellido">Apellido</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el apellido del participante" title="" data-original-title="Ayuda"></i> 
                                    <input type="text" class="form-control input-sm" name="apellido" id="apellido" placeholder="Ej. S??nchez">
                                 </div>
                                 <div class="has-error" id="error-apellido">
                                      <span >
                                          <small class="help-block error-span" id="error-apellido_mensaje"  ></small>                                           
                                      </span>
                                  </div>
                               </div>

                               <div class="col-sm-6">
                                    <div class="form-group fg-line">
                                    <label for="apellido" id="id-fecha_nacimiento">Fecha de Nacimiento</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la fecha de nacimiento del participante" title="" data-original-title="Ayuda"></i>
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
                                    <label for="sexo p-t-10" id="id-sexo">Sexo</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el sexo del participante" title="" data-original-title="Ayuda"></i>
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

                               <div class="col-sm-6">

                               <label for="apellido" id="id-correo">Correo Electr??nico</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el correo electr??nico del participante" title="" data-original-title="Ayuda"></i>

                                    <div class="form-group fg-line ">
                                      <input type="text" class="form-control input-sm proceso" name="correo" id="correo" placeholder="Ej. easydance@gmail.com">
                                      </div>
                                 <div class="has-error" id="error-correo">
                                      <span >
                                          <small class="help-block error-span" id="error-correo_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 
                               <br>

                               <div class="col-sm-6">
                                 
                                    <label for="apellido" id="id-celular">Tel??fono M??vil</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el n??mero del tel??fono movil del participante" title="" data-original-title="Ayuda"></i>

                                    <div class="form-group fg-line ">
                                      <input type="text" class="form-control input-sm input-mask" name="celular" id="celular" data-mask="(000)000-0000" placeholder="Ej: (426)367-0894">
                                      </div>
                                 <div class="has-error" id="error-celular">
                                      <span >
                                          <small class="help-block error-span" id="error-celular_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="col-sm-6">
                                 
                                    <label for="apellido" id="id-telefono">Tel??fono Local</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el n??mero del tel??fono local del participante" title="" data-original-title="Ayuda"></i>

                                    <div class="form-group fg-line ">
                                      <input type="text" class="form-control input-sm input-mask" name="telefono" id="telefono" data-mask="(000)000-0000" placeholder="Ej: (426)367-0894">
                                      </div>
                                 <div class="has-error" id="error-telefono">
                                      <span >
                                          <small class="help-block error-span" id="error-telefono_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 
                               <br>

                               <div class="col-sm-12">
                                 <div class="form-group">
                                    <label for="direccion" id="id-direccion">Direcci??n</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la direcci??n del participante" title="" data-original-title="Ayuda"></i>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="direccion" id="direccion" placeholder="Calle santa marta, Av 23">
                                    </div>
                                 <div class="has-error" id="error-direccion">
                                      <span >
                                          <small class="help-block error-span" id="error-direccion_mensaje" ></small>                                
                                      </span>
                                  </div>
                                </div>
                              </div>

                              <div class="clearfix"></div> 
                               <br>


                          <div class="col-sm-12">
                                 
                                    <label for="rol" id="id-rol">Rol del cliente dentro de la academia</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ind??canos si el cliente ser?? exclusivamente el responsable de la cuenta o tambi??n tendr?? participaci??n como alumno dentro de las clases de baile" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="rol" id="representante" value="0" type="radio">
                                        <i class="input-helper"></i>  
                                        S??lo cliente  <i class="zmdi zmdi-male-alt p-l-5 f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="rol" id="alumno" value="1" type="radio">
                                        <i class="input-helper"></i>  
                                        Tambi??n participa como alumno activo <i class="icon_a-instructor p-l-5 f-20"></i>
                                    </label>
                                    </div>
                                    </div>
                                 <div class="has-error" id="error-rol">
                                      <span >
                                          <small class="help-block error-span" id="error-rol_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               

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
                              <button type="button" class="btn btn-blanco m-r-5 f-16 agregar" id="agregar" >Guardar</button>
                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                      <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Men?? Principal</a>
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

                          <div class="col-xs-12 text-left">
                          <ul class="tab-nav tn-justified" role="tablist">
                              <li class="waves-effect active"><a href="{{url('/')}}/administrativo/pagos/generar" aria-controls="home11"><div class="icon_a icon_a-pagar f-30"></div><p style=" margin-bottom: -2px;">Pagos</p></a></li>
                              <li class="waves-effect"><a href="{{url('/')}}/administrativo/acuerdos/generar" aria-controls="home11"><div class="icon_a icon_a-acuerdo-de-pago f-30"></div><p style=" margin-bottom: -2px;">Acuerdos</p></a></li>
                              <li class="waves-effect"><a href="{{url('/')}}/administrativo/presupuestos/generar" aria-controls="home11"><div class="icon_a icon_a-presupuesto f-30"></div><p style=" margin-bottom: -2px;">Presupuestos</p></a></li>
                              <li class="waves-effect"><a href="{{url('/')}}/administrativo/egresos"><div class="fa fa-money f-30"></div><p style=" margin-bottom: -2px;">Egresos</p></a></li>
                                    
                            </ul>
                            </div>

                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>


                        </div>
                        


                        <div class="card-body p-b-20">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>

                                    <div class="col-sm-12">

  
                                    <div class="col-sm-6" style="padding-left: 0px">
                                 
                                    <span class="f-30 text-center c-morado"> Cliente</span>

                                    </div>

                                    <div class="col-sm-6 text-right">

                                      <a  id="id-cliente" class="f-16 p-t-0 text-right text-success" data-toggle="modal" href="#modalAgregar">Agregar Nuevo Cliente <i class="zmdi zmdi-account-add zmdi-hc-fw f-20 c-verde"></i></a>

                                    </div>

                                

                                    <hr></hr>

                                    <div class="clearfix p-b-35"></div> 
                                 
                                    <div class="col-sm-12">
                                 
                                     <label for="alumno" id = "id-usuario_id">Nombre del Cliente</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona un participante al cual gestionar??s su pago" title="" data-original-title="Ayuda"></i>

                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a-alumnos f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="usuario_id" id="usuario_id" data-live-search="true">
                                          <option value="">Selecciona</option>
                                          @foreach ( $usuarios as $usuario )
                                            <option data-content = "{{ $usuario['nombre'] }} {{ $usuario['apellido'] }} {{ $usuario['identificacion']}} - Debe: {{ number_format($usuario['total'], 2, '.' , '.')}} <i class='zmdi zmdi-money {{ empty($usuario['deuda']) ? 'c-verde ' : 'c-youtube' }} f-20'></i>" value = "{{ $usuario['id'] }}"></option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-usuario_id">
                                      <span >
                                        <small class="help-block error-span" id="error-usuario_id_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>
                               </div>
                                   
                              </div>

                              <div class="clearfix p-b-35"></div>
                          
                              <div class="col-sm-12">
                                    
                                 
                                <span class="f-30 text-center c-morado">Linea de Pago</span>
                                


                                <hr></hr>
                                
                                <div class="clearfix p-b-35"></div>
                                <form name="agregar_item" id="agregar_item"  >

                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                  
                                  <div class="clearfix p-b-35"></div>

                                  <div class="col-sm-2 text-center">

                                   <span class="f-16 c-morado" id="id-combo">Producto o Servicio</span>

                                   </div>
                                   <div class="col-sm-2 text-center">

                                   <span class="f-16 c-morado" id="id-cantidad">Cantidad</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="bottom" data-content="se refiere a la cantidad de productos o servicios que deseas agregar al cliente para la venta" title="" data-original-title="Ayuda"></i>

                                   </div>
                                   <div class="col-sm-2 text-center" id="disponibilidad_productos">

                                   <span class="f-16 c-morado" id="id-cantidad">Disponibilidad</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="bottom" data-content="se refiere a la cantidad de productos disponibles en estos momentos" title="" data-original-title="Ayuda"></i>

                                   </div>
                                   <div class="col-sm-2 text-center" id ="id-linea">

                                   <span class="f-16 c-morado">Precio (Neto)</span>

                                   </div>
                                   <div class="col-sm-2 text-center">

                                   <span class="f-16 c-morado">Impuesto</span>

                                   </div>

                                   <div class="col-sm-2 text-center">

                                   <span class="f-16 c-morado">Importe (Neto)</span>

                                   </div>


                              <div class="clearfix p-b-35"></div>

                              <div class="col-sm-2">

                                <div class="dropdown" id="dropdown_boton">
                                  <a id="detalle_boton" role="button" data-toggle="dropdown" class="btn btn-blanco">
                                      Seleccione <span class="caret"></span>
                                  </a>
                                  <ul id="dropdown_principal" class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">

                                    <li class="dropdown-submenu pointer">
                                      <a>Clases Grupales</a>
                                      <ul class="dropdown-menu">

                                        @foreach ( $servicios_productos as $servicio_producto ) 
                                          @if($servicio_producto['tipo'] == 3 || $servicio_producto['tipo']== 4)
                                            <li class = "pointer servicio_detalle" data-nombre="{{$servicio_producto['nombre']}}" data-servicio_producto="{{$servicio_producto['servicio_producto']}}" id="{{$servicio_producto['id']}}-{{$servicio_producto['costo']}}-{{$servicio_producto['tipo']}}-{{$servicio_producto['servicio_producto']}}-{{$servicio_producto['incluye_iva']}}-{{$servicio_producto['disponibilidad']}}"><a>{{$servicio_producto['nombre']}}</a></li>
                                          @endif                   
                                        @endforeach

                                      </ul>
                                    </li>

                                    <li class="dropdown-submenu pointer">
                                      <a>Clases Personalizadas</a>
                                      <ul class="dropdown-menu">

                                        @foreach ( $servicios_productos as $servicio_producto ) 
                                          @if($servicio_producto['tipo'] == 9)
                                          
                                            <li class = "dropdown-submenu pointer">
                                              <a>{{$servicio_producto['nombre']}}</a>
                                              <ul class="dropdown-menu">

                                                @foreach ( $costos_clases_personalizadas as $costo ) 
                                                  @if($servicio_producto['tipo_id'] == $costo['clase_personalizada_id'])
                                                    <li class = "pointer servicio_detalle" data-nombre="{{$costo['nombre']}}" data-servicio_producto="{{$costo['servicio_producto']}}" id="{{$costo['id']}}-{{$costo['costo']}}-{{$costo['tipo']}}-{{$costo['servicio_producto']}}-{{$costo['incluye_iva']}}-{{$costo['disponibilidad']}}"><a>{{$costo['nombre']}}</a></li>
                                                  @endif                   
                                                @endforeach
                                              </ul>
                                            </li>
                                          @endif                   
                                        @endforeach

                                      </ul>
                                    </li>

                                    <li class="dropdown-submenu pointer">
                                      <a>Productos</a>
                                      <ul class="dropdown-menu">

                                        @foreach ( $servicios_productos as $servicio_producto ) 
                                          @if($servicio_producto['tipo'] == 2)
                                            <li class = "pointer servicio_detalle" data-nombre="{{$servicio_producto['nombre']}}" data-servicio_producto="{{$servicio_producto['servicio_producto']}}" id="{{$servicio_producto['id']}}-{{$servicio_producto['costo']}}-{{$servicio_producto['tipo']}}-{{$servicio_producto['servicio_producto']}}-{{$servicio_producto['incluye_iva']}}-{{$servicio_producto['disponibilidad']}}"><a>{{$servicio_producto['nombre']}}</a></li>
                                          @endif                   
                                        @endforeach

                                      </ul>
                                    </li>

                                    <li class="dropdown-submenu pointer">
                                      <a>Servicios</a>
                                      <ul class="dropdown-menu">'

                                        @foreach ( $servicios_productos as $servicio_producto ) 
                                          @if($servicio_producto['tipo'] == 1)
                                            <li class = "pointer servicio_detalle" data-nombre="{{$servicio_producto['nombre']}}" data-servicio_producto="{{$servicio_producto['servicio_producto']}}" id="{{$servicio_producto['id']}}-{{$servicio_producto['costo']}}-{{$servicio_producto['tipo']}}-{{$servicio_producto['servicio_producto']}}-{{$servicio_producto['incluye_iva']}}-{{$servicio_producto['disponibilidad']}}"><a>{{$servicio_producto['nombre']}}</a></li>
                                          @endif                   
                                        @endforeach

                                      </ul>
                                    </li>

                                    <li class="dropdown-submenu pointer">
                                      <a>Paquetes</a>
                                      <ul class="dropdown-menu">'

                                        @foreach ( $servicios_productos as $servicio_producto ) 
                                          @if($servicio_producto['tipo'] == 15)
                                            <li class = "pointer servicio_detalle" data-nombre="{{$servicio_producto['nombre']}}" data-servicio_producto="{{$servicio_producto['servicio_producto']}}" id="{{$servicio_producto['id']}}-{{$servicio_producto['costo']}}-{{$servicio_producto['tipo']}}-{{$servicio_producto['servicio_producto']}}-{{$servicio_producto['incluye_iva']}}-{{$servicio_producto['disponibilidad']}}"><a>{{$servicio_producto['nombre']}}</a></li>
                                          @endif                   
                                        @endforeach

                                      </ul>
                                    </li>

                                    <li class="dropdown-submenu pointer">
                                      <a>Campa??as</a>
                                      <ul class="dropdown-menu">

                                        @foreach ( $servicios_productos as $servicio_producto ) 
                                          @if($servicio_producto['tipo'] == 11)
                                          
                                            <li class = "dropdown-submenu pointer">
                                              <a>{{$servicio_producto['nombre']}}</a>
                                              <ul class="dropdown-menu">

                                                @foreach ( $recompensas as $recompensa ) 
                                                  @if($servicio_producto['tipo_id'] == $recompensa['campana_id'])
                                                    <li class = "pointer servicio_detalle" data-nombre="{{$recompensa['nombre']}}" data-servicio_producto="{{$recompensa['servicio_producto']}}" id="{{$recompensa['id']}}-{{$recompensa['costo']}}-{{$recompensa['tipo']}}-{{$costo['servicio_producto']}}-{{$recompensa['incluye_iva']}}-{{$recompensa['disponibilidad']}}"><a>{{$recompensa['nombre']}}</a></li>
                                                  @endif                   
                                                @endforeach
                                              </ul>
                                            </li>
                                          @endif                   
                                        @endforeach

                                      </ul>
                                    </li>

                                  </ul>
                                </div>

                                <!-- <div class="fg-line">
                                  <div class="select">
                                    <select class="form-control" name="combo" id="combo">
                                      <option value="">Selecciona</option>
                                      @foreach ( $servicios_productos as $servicio_producto )


                       
                                        <option @if($servicio_producto['tipo'] == '2') style="display:none" @endif value = "{{$servicio_producto['id']}}-{{$servicio_producto['costo']}}-{{$servicio_producto['tipo']}}-{{$servicio_producto['servicio_producto']}}-{{$servicio_producto['incluye_iva']}}-{{$servicio_producto['disponibilidad']}}">{{$servicio_producto['nombre']}}</option>

                                      @endforeach
                                    </select>
                                  </div>
                                </div> -->
                              </div>

                              <div class="col-sm-2 text-center">
                                <input name="cantidad" id="cantidad" class="form-control input-mask" maxlength="5" data-mask="00000" placeholder="Ej. 10" type="text" >
                              </div>

                              <div class="col-sm-2 text-center" id="disponibilidad_productos_campo">
                                <input type="text" class="form-control input-sm text-center" name="campo_disponibilidad" id="campo_disponibilidad" readonly="readonly" placeholder="Ej. 1" value="0">
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

                              <div class="clearfix p-b-10"></div>
                              
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

                            <div class="clearfix"></div>

                            <div class="col-sm-3">
                                <label class="c-morado f-15">Promotor</label>
                                <div class="select">
                                  <select class="selectpicker bs-select-hidden" multiple="" data-max-options="5" name="promotor_id" id="promotor_id"  data-live-search="true" title="Selecciona">
                                  </select>
                                </div>
                              </div>

                            <div class="clearfix m-b-30"></div>

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
                                    <th class="text-center"><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
                                    <th class="text-center" data-column-id="nombre">Producto o Servicio</th>
                                    <th class="text-center" data-column-id="cantidad">Cantidad</th>
                                    <th class="text-center" data-column-id="precio_neto" data-order="desc">Precio (Neto)</th>
                                    <th class="text-center" data-column-id="impuesto" data-order="desc">Impuesto</th>
                                    <th class="text-center" data-column-id="importe_neto" data-order="desc">Importe (Neto)</th>
                                    <th class="text-center" data-column-id="estatus" data-order="desc">Estatus</th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc">Acciones</th>
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

                        <br>
                     
                        <div class="col-sm-12 text-right">
                          <p><span class="f-15 c-morado">Sub total</span>
                          <span class="f-15 c-morado" id = "subtotal">0</span>
                          </p>
                          <p><span class="f-15 text-right c-morado">Impuesto</span>
                          <span class="f-15 c-morado" id = "impuestototal">0</span></p>
                          <p><span class="f-15 text-right c-morado">Total</span>
                          <span class="f-15 c-morado" id = "total">0</span></p>
                        </div>
                                   

                         <br>
                            
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
                            
                            <div class="col-sm-4 text-left"> 
                          
                            </div>

                            <div class="col-sm-4 text-center">
                             

                              <a href="{{url('/')}}/administrativo/pagos"><i class="zmdi zmdi-eye zmdi-hc-fw f-30 boton blue sa-warning"></i></a>

                              <br>

                              <span class="f-700 opaco-0-8 f-16">Secci??n Factura</span>
                              
                               
                            </div>


                            <div class="col-sm-4 text-right pull-right" style="padding-right: 0px">                          

                              <button type="button" class="btn btn-blanco m-r-10 f-14 guardar" name= "pagar" id="pagar" >Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>

                              <button type="button" class="cancelar btn btn-default" name="cancelar" id="cancelar">Cancelar</button>
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
    var impuestoglobal = 0;
    var subtotalglobal = 0;
    var totalfinal = 0;
    var usuario_id = '';
    var checked = [];
    var promotores = <?php echo json_encode($promotores);?>;
    var servicio_producto_id = 0;
    var items_factura_proforma = []

    route_agregar="{{url('/')}}/administrativo/pagos/agregaritem";
    route_factura="{{url('/')}}/administrativo/pagos/gestion";
    route_eliminar="{{url('/')}}/administrativo/pagos/eliminaritem";
    route_pagar="{{url('/')}}/administrativo/pagos/factura";
    route_cancelar = "{{url('/')}}/administrativo/pagos/cancelarpago"
    route_proforma="{{url('/')}}/administrativo/pagos/pendiente/";
    route_pendientes="{{url('/')}}/administrativo/pagos/itemspendientes/";
    route_alumno="{{url('/')}}/participante/alumno/deuda/";
    route_agregar_cliente="{{url('/')}}/administrativo/pagos/agregarcliente";

    $( document ).ready(function() {

      $('#nombre').mask('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', {'translation': {

        A: {pattern: /[A-Za-z????????????????????.,@*+_???? ]/}
        }

      });

      $('#apellido').mask('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', {'translation': {

        A: {pattern: /[A-Za-z????????????????????.,@*+_???? ]/}
        }

      });


      $('body,html').animate({scrollTop : 0}, 2000);
          var animation = 'fadeInUpBig';
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

      $("#agregar_item")[0].reset();
      $('#usuario_id').val('');
      usuario_id = '';
      $('#usuario_id').selectpicker('render');

      id = "{{{ $id or 'Default' }}}";
      $('#disponibilidad_productos').hide();
      $('#disponibilidad_productos_campo').hide();

      if(id != 'Default'){

        $("#usuario_id").val("{{{ $id or 'Default' }}}");
        $('#usuario_id').selectpicker('refresh');
        usuario_id = id;

        var route = route_pendientes + id;
        var token = $('input:hidden[name=_token]').val();
        $.ajax({
          url: route,
          headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          success:function(respuesta){
            setTimeout(function(){ 
              var nFrom = $(this).attr('data-from');
              var nAlign = $(this).attr('data-align');
              var nIcons = $(this).attr('data-icon');
              var nAnimIn = "animated flipInY";
              var nAnimOut = "animated flipOutY"; 
              if(respuesta.status=="OK"){

                items_factura_proforma = respuesta.items

                $.each(respuesta.items, function (index, array) {

                  nombre = array[0].nombre;

                  if(nombre.length > 15){
                    nombre = nombre.substr(0, 30) + "..."
                  }

                  var rowId=array[0].id;
                  var rowNode=t.row.add( [
                  ''+'<input name="select_check" id="select_check" type="checkbox" />'+'',  
                  ''+nombre+'',
                  ''+array[0].cantidad+'',
                  ''+formatmoney(parseFloat(array[0].precio_neto))+'',
                  ''+array[0].impuesto+'',
                  ''+formatmoney(parseFloat(array[0].importe_neto))+'',
                  ''+ ' ' +''
                  ] ).draw(false).node();
                  $( rowNode )
                    .attr('id',rowId)
                    .attr('fecha_vencimiento',array[0].fecha_vencimiento)
                    .attr('tipo',array[0].tipo)
                    .addClass('seleccion')
                    .attr('data-trigger','hover')
                    .attr('data-toggle','popover')
                    .attr('data-placement','top')
                    .attr('data-content','<p class="c-negro">'+array[0].nombre+'</p>')
                    .attr('data-original-title','Ayuda &nbsp;&nbsp;&nbsp;')
                    .attr('data-container','body')
                    .attr('data-html','true')
                    .attr('title','');

                });

                $('[data-toggle="popover"]').popover();

                var importe_neto = respuesta.total;
                var impuesto = "{{$impuesto}}";
                impuestoglobal = parseFloat(importe_neto) * (impuesto / 100);
                subtotalglobal = parseFloat(importe_neto) - impuestoglobal;

                totalfinal = subtotalglobal + impuestoglobal;

                $("#subtotal").text(formatmoney(subtotalglobal));
                $("#impuestototal").text(formatmoney(impuestoglobal));
                $("#total").text(formatmoney(totalfinal));

              }else{
                var nTitle="Ups! ";
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                var nType = 'danger';
              }                       
            }, 1000);
            
          },
          error:function(msj){
            setTimeout(function(){ 
              if (typeof msj.responseJSON === "undefined") {
                window.location = "{{url('/')}}/error";
              }
              if(msj.responseJSON.status=="ERROR"){
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

      setTimeout(function(){ 

        $('html,body').animate({
              scrollTop: $("#id-combo").offset().top-90,
              }, 1000);

        }, 1000);
      }

      else{

        $("#add").attr("disabled","disabled");
          $("#add").css({
            "opacity": ("0.2")
          });

          setTimeout(function(){ 

          $('html,body').animate({
              scrollTop: $("#content").offset().top-90,
              }, 1000);

          }, 1000);
      }

    t=$('#tablelistar').DataTable({
        "columnDefs": [ {
          "targets": [ 0 ],
          "orderable": false
        } ],
        processing: true,
        serverSide: false,
        bPaginate: false,
        bInfo:false,
        order: [[1, 'desc']],
        language: {
              searchPlaceholder: "Buscar"
        },
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6)', nRow).addClass( "text-center" );
          $('td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)', nRow).addClass( "disabled");
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

    });

    function formatmoney(n) {
      return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    }

    $('#example-select-all').on('click', function(){
        // Check/uncheck all checkboxes in the table
        var rows = t.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);

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

      var checked = getChecked();

        var route = route_factura;
        var token = $('input:hidden[name=_token]').val();
        var datos = "&usuario_id="+usuario_id+"&items_factura="+checked;
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
                  window.location = route_factura;

                }else{
                  var nTitle="Ups! ";
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                  var nType = 'danger';
                }                       
                // finprocesado();

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

    $("#cantidad").change(function(){

      var cantidad = parseFloat($(this).val())

      if(servicio_producto_id){
        var split = servicio_producto_id.split('-');
        var incluye_iva = split[4];
        var disponibilidad = split[5];
        var costo = parseFloat(split[1]);
      }else{
        var incluye_iva = 0
        var disponibilidad = 0
        var costo = 0
      }

      if(incluye_iva == 0){
        $("#impuesto").val($('#impuesto option').first().val());
      }
      else{
        $("#impuesto").val($('#impuesto option').last().val());
      }

      var total = costo * cantidad

      $('input[name="precio_neto"]').val(formatmoney(costo))
      $('input[name="importe_neto"]').val(formatmoney(total))
      $('input[name="cantidad"]').val(cantidad)
      $('input[name="campo_disponibilidad"]').val(disponibilidad)
      
    });

    $("#impuesto").change(function(){

      if(servicio_producto_id){
        var split = servicio_producto_id.split('-');
        var incluye_iva = split[4];
        var disponibilidad = split[5];
        var costo = parseFloat(split[1]);
        var cantidad = parseFloat($('input[name="cantidad"]').val())
      }else{
        var incluye_iva = 0
        var disponibilidad = 0
        var costo = 0
        var cantidad = 0
      }

      var total = costo * cantidad

      $('input[name="precio_neto"]').val(formatmoney(costo))
      $('input[name="importe_neto"]').val(formatmoney(total))
      $('input[name="cantidad"]').val(cantidad)
      $('input[name="campo_disponibilidad"]').val(disponibilidad)
      
    });

    function getChecked(){
      var checked = [];
      $('#tablelistar tr').each(function (i, row) {
          var actualrow = $(row);
          checkbox = actualrow.find('input:checked').val();
          if(checkbox == 'on')
          {
            var id = $(actualrow).attr('id');
            checked[i] = id;
          }
      });

      return checked;
    }

    // LINEA AGREGAR

    $("#add").click(function(){

      $('#disponibilidad_productos').hide();
      $('#disponibilidad_productos_campo').hide();

      $("#add").attr("disabled","disabled");
      $("#add").css({
        "opacity": ("0.2")
      });

      var route = route_agregar;
      var token = $('input:hidden[name=_token]').val();
      var datos = $( "#agregar_item" ).serialize(); 
      limpiarMensaje();

      usuario_id = $("#usuario_id").val();
      var values = $('#promotor_id').val();
      var promotores = '';
      
      if(values){
        for(var i = 0; i < values.length; i += 1) {
          promotores = promotores + ',' + values[i];
        }
      }

      $.ajax({
          url: route,
              headers: {'X-CSRF-TOKEN': token},
              type: 'POST',
              dataType: 'json',
              data:datos + "&impuestoglobal="+impuestoglobal+"&usuario_id="+usuario_id+"&promotores="+promotores+"&combo="+servicio_producto_id,
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

                nombre = respuesta.array[0].nombre;

                if(nombre.length > 15){
                  nombre = nombre.substr(0, 30) + "..."
                }

                var rowId=respuesta.array[0].id;
                var rowNode=t.row.add( [
                ''+'<input name="select_check" id="select_check" type="checkbox" />'+'',
                ''+nombre+'',
                ''+respuesta.array[0].cantidad+'',
                ''+formatmoney(parseFloat(respuesta.array[0].precio_neto))+'',
                ''+respuesta.array[0].impuesto+'',
                ''+formatmoney(parseFloat(respuesta.array[0].importe_neto))+'',
                ''+'Por Cobrar'+'',
                '<i class="zmdi zmdi-delete boton red f-20 p-r-10"></i>'
                ] ).draw(false).node();
                $( rowNode )
                .attr('id',rowId)
                .attr('fecha_vencimiento',respuesta.array[0].fecha_vencimiento)
                .attr('tipo',respuesta.array[0].tipo)
                .addClass('seleccion')
                .attr('data-trigger','hover')
                .attr('data-toggle','popover')
                .attr('data-placement','top')
                .attr('data-content','<p class="c-negro">'+respuesta.array[0].nombre+'</p>')
                .attr('data-original-title','Ayuda &nbsp;&nbsp;&nbsp;')
                .attr('data-container','body')
                .attr('data-html','true')
                .attr('title','');

                $('[data-toggle="popover"]').popover();
                
                var importe_neto = respuesta.array[0].importe_neto;
                var impuesto = respuesta.array[0].impuesto;

                subtotalfinal = parseFloat(importe_neto);
                impuestofinal = parseFloat(subtotalfinal) * (impuesto / 100);

                subtotalglobal = subtotalglobal + subtotalfinal;
                impuestoglobal = impuestofinal + impuestoglobal;
                subtotalglobal = subtotalglobal - impuestofinal;
                totalfinal = subtotalglobal + impuestoglobal;

                $("#subtotal").text(formatmoney(subtotalglobal));
                $("#impuestototal").text(formatmoney(impuestoglobal));
                $("#total").text(formatmoney(totalfinal));

                $('#agregar_item')[0].reset()
                $('#promotor_id').empty()
                $('.selectpicker').selectpicker('refresh')

                $('#detalle_boton').text('Seleccione')
                servicio_producto_id = ''

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

    //FUNCION ELIMINAR

    $('#tablelistar tbody').on( 'click', 'i.zmdi-delete', function () {
    
      var id = $(this).closest('tr').attr('id');
      var element = $(this)
      var token = $('input:hidden[name=_token]').val();

      swal({   
          title: "Desea eliminar la proforma?",   
          text: "Confirmar eliminaci??n!",   
          type: "warning",   
          showCancelButton: true,   
          confirmButtonColor: "#DD6B55",   
          confirmButtonText: "Eliminar!",  
          cancelButtonText: "Cancelar",         
          closeOnConfirm: true 
      }, function(isConfirm){   
        if (isConfirm) {
          procesando();
          $.ajax({
             url: route_eliminar+"/"+id,
             headers: {'X-CSRF-TOKEN': token},
             type: 'POST',
             dataType: 'json',                
            success: function (data) {
              if(data.status=='OK'){


                  t.row(element.parents('tr'))
                    .remove()
                    .draw();

                  impuesto = data.impuesto;
                  subtotalglobal = subtotalglobal - data.importe_neto + impuesto;
                  impuestoglobal = impuestoglobal - impuesto;
                  totalfinal = subtotalglobal + impuestoglobal;

                  $("#subtotal").text(subtotalglobal.toFixed(2));
                  $("#impuestototal").text(impuestoglobal.toFixed(2));
                  $("#total").text(totalfinal.toFixed(2));
                  finprocesado();
                  swal("Exito!","La proforma ha sido eliminada!","success");

                                   
              }else{
                finprocesado();
                swal(
                  'Solicitud no procesada',
                  'Ha ocurrido un error, intente nuevamente por favor',
                  'error'
                );
              }
            },
            error:function (xhr, ajaxOptions, thrownError){
              finprocesado();
              swal('Solicitud no procesada','Ha ocurrido un error, intente nuevamente por favor','error');
            }
          })
        }
      });
    });
  
    function limpiarMensaje(){
      var campo = ["usuario_id", "combo", "cantidad", "linea"];
      fLen = campo.length;
      for (i = 0; i < fLen; i++) {
          $("#error-"+campo[i]+"_mensaje").html('');
      }
    }

    function errores(merror){
      var campo = ["usuario_id", "combo", "cantidad", "linea"];
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

              usuario_id = '';
              limpiarMensaje();
              impuestoglobal = 0;
              subtotalglobal = 0;
              $('#agregar_item')[0].reset()
              $('#promotor_id').empty()
              $('.selectpicker').selectpicker('refresh')

              $('#detalle_boton').text('Seleccione')
              servicio_producto_id = ''

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
        scrollTop: $("#id-usuario_id").offset().top-90,
      }, 1000);
    });

    $("#usuario_id").change(function(){

      t
        .clear()
        .draw();

      procesando();

      usuario_id = $("#usuario_id").val();

      if($("#usuario_id").val() != ""){

        $("#add").removeAttr("disabled");
        $("#add").css({
          "opacity": ("1")
         });
          
      }

      else{

        $("#add").attr("disabled","disabled");
        $("#add").css({
          "opacity": ("0.2")
        });
      }

      id = $(this).val();
      limpiarMensaje();
      var route = route_pendientes + id;
      var token = $('input:hidden[name=_token]').val();
      $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        success:function(respuesta){
          setTimeout(function(){ 
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nAnimIn = "animated flipInY";
            var nAnimOut = "animated flipOutY"; 
            if(respuesta.status=="OK"){

              finprocesado();
              $('html,body').animate({
                scrollTop: $("#id-combo").offset().top-90,
              }, 1000);

              total = 0;

              items_factura_proforma = respuesta.items

              $.each(respuesta.items, function (index, array) {

                if(array[0].estatus == 0){
                  estatus = '<span class="c-youtube">Vencida</span>'
                }else{
                  estatus = '<span>Por Cobrar</span>'
                }

                nombre = array[0].nombre;

                if(nombre.length > 15){
                  nombre = nombre.substr(0, 30) + "..."
                }

                var rowId=array[0].id;
                var rowNode=t.row.add( [
                ''+'<input name="select_check" id="select_check" type="checkbox" />'+'',  
                ''+nombre+'',
                ''+array[0].cantidad+'',
                ''+formatmoney(parseFloat(array[0].precio_neto))+'',
                ''+array[0].impuesto+'',
                ''+formatmoney(parseFloat(array[0].importe_neto))+'',
                ''+estatus+'',
                ''+'<i class="zmdi zmdi-delete boton red f-20 p-r-10"></i>'+''
                ] ).draw(false).node();
                $( rowNode )
                .attr('id',rowId)
                .attr('fecha_vencimiento',array[0].fecha_vencimiento)
                .attr('tipo',array[0].tipo)
                .addClass('seleccion')
                .attr('data-trigger','hover')
                .attr('data-toggle','popover')
                .attr('data-placement','top')
                .attr('data-content','<p class="c-negro">'+array[0].nombre+'</p>')
                .attr('data-original-title','Ayuda &nbsp;&nbsp;&nbsp;')
                .attr('data-container','body')
                .attr('data-html','true')
                .attr('title','');
           
              });

              $('[data-toggle="popover"]').popover();

              total = respuesta.total;

              $("#subtotal").text(formatmoney(total));
              $("#total").text(formatmoney(total));
              subtotalglobal = total;
              totalglobal = total;

            }else{
              var nTitle="Ups! ";
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              var nType = 'danger';
            }                       
          }, 1000);
          
        },
        error:function(msj){
          setTimeout(function(){ 
            if (typeof msj.responseJSON === "undefined") {
              window.location = "{{url('/')}}/error";
            }
            if(msj.responseJSON.status=="ERROR"){
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
    });

    $("#agregar").click(function(){

      var route = route_agregar_cliente;
      var token = $('input:hidden[name=_token]').val();
      var datos = $( "#form_agregar" ).serialize(); 
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

              $('#usuario_id').prepend( new Option(respuesta.alumno.nombre + ' ' + respuesta.alumno.apellido + ' ' + respuesta.alumno.identificacion + ' - Debe: 0','1-'+respuesta.alumno.id));
              $('#usuario_id').val(respuesta.alumno.id);
              $('#usuario_id').selectpicker('render');
              $('#usuario_id').selectpicker('refresh');

              $('.modal').modal('hide');
           

            }else{
              var nTitle="Ups! ";
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              var nType = 'danger';
            }                       

            finprocesado();

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
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nType = 'danger';
            var nAnimIn = "animated flipInY";
            var nAnimOut = "animated flipOutY"; 
            finprocesado();
                    
            notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
          }, 1000);
        }
      });
    });

    $('body').on('click','.servicio_detalle', function(e){

      var servicio_producto = $(this).data('servicio_producto')
      var nombre = $(this).data('nombre')
      if(nombre.length > 15){
        nombre = nombre.substr(0, 15) + "..."
      }

      $('#detalle_boton').text(nombre)

      $('#dropdown_boton').removeClass('open')
      $('#detalle_boton').attr('aria-expanded',false);

      if(servicio_producto == 1){
        $('#disponibilidad_productos').hide();
        $('#disponibilidad_productos_campo').hide();
      }else{
        $('#disponibilidad_productos').show();
        $('#disponibilidad_productos_campo').show();
      }

      servicio_producto_id = $(this).attr('id')
      var split = servicio_producto_id.split('-');  
      var incluye_iva = split[4];
      var disponibilidad = split[5];
      var costo = parseFloat(split[1]);
      var cantidad = 1
      var tipo = split[3];
      var id = split[0];

      if(incluye_iva == 0){
        $("#impuesto").val($('#impuesto option').first().val());
      }
      else{
        $("#impuesto").val($('#impuesto option').last().val());
      }

      var total = costo * cantidad

      $('input[name="precio_neto"]').val(formatmoney(costo))
      $('input[name="importe_neto"]').val(formatmoney(total))
      $('input[name="cantidad"]').val(1)
      $('input[name="campo_disponibilidad"]').val(disponibilidad)

      $('#promotor_id').empty()

      $.each(promotores, function (index, array) {
        $.each(array.config_comisiones, function (i, comision) {
          if(comision.servicio_producto_id == id && comision.servicio_producto_tipo == tipo){

            explode = index.split('-')
            tipo = explode[0]

            if(tipo == 1){
              icono = "<i class='icon_f-staff'></i>"
            }else{
              icono = "<i class='icon_a-instructor'></i>"
            }

            $('#promotor_id').append('<option value="'+array.id+'" data-content="'+ array.nombre + ' ' + array.apellido + ' ' + ' ' + icono +'"></option>');
            return false;
          }
        });
      });

      $('#promotor_id').selectpicker('refresh');

    });

    $(document).on('change', 'input[type=checkbox]', function() {

      checkbox = $(this)
      var tipo = $(this).closest('tr').attr('tipo');
      var id = $(this).closest('tr').attr('id');
      var fecha_vencimiento = $(this).closest('tr').attr('fecha_vencimiento');

      if($(this).is(":checked") && tipo == 6) {
        $.each(items_factura_proforma, function (index, array) {

          if(id != array[0].id && array[0].tipo == 6){
            fecha_vencimiento_checkbox = new Date(fecha_vencimiento)
            fecha_vencimiento_array = new Date(array[0].fecha_vencimiento)

            if(fecha_vencimiento_checkbox > fecha_vencimiento_array){
              $(checkbox).attr('checked', false);
              swal("Ups!","No puede seleccionar esta cuota sin haber pagado la anterior!","error");
            }
          }
        })
      }
    });

  </script> 
@stop

