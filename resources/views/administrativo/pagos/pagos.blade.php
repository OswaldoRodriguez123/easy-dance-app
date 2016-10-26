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
<!--<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.es.js"></script>-->
<script src="{{url('/')}}/assets/vendors/farbtastic/farbtastic.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script src="{{url('/')}}/assets/vendors/input-mask/input-mask.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bootgrid/jquery.bootgrid.min.js"></script>

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
                              <a class="btn-blanco m-r-5 f-16 guardar" id="guardar" data-formulario="edit_id_alumno" data-update="identificacion" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>
                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
 -->
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
                      <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menu Principal</a>
                      <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                      </div> 
                    
                      <div class="card">
                        <div class="card-header">

                          <div class="col-xs-12 text-left">
                          <ul class="tab-nav tn-justified" role="tablist">
                                    <li class="waves-effect active"><a href="{{url('/')}}/administrativo/pagos/generar" aria-controls="home11" onclick="procesando()"><div class="icon_a icon_a-pagar f-30"></div><p style=" margin-bottom: -2px;">Pagos</p></a></li>
                                    <li class="waves-effect"><a href="{{url('/')}}/administrativo/acuerdos/generar" aria-controls="home11" onclick="procesando()"><div class="icon_a icon_a-acuerdo-de-pago f-30"></div><p style=" margin-bottom: -2px;">Acuerdos</p></a></li>
                                    <li class="waves-effect"><a href="{{url('/')}}/administrativo/presupuestos/generar" aria-controls="home11" onclick="procesando()"><div class="icon_a icon_a-presupuesto f-30"></div><p style=" margin-bottom: -2px;">Presupuestos</p></a></li>
                                    <li class="waves-effect"><a data-toggle="modal" href="#modalConstruccion"><div class="icon_d icon_d-reporte f-30"></div><p style=" margin-bottom: -2px;">Reportes</p></a></li>
                                    
                            </ul>
                            </div>

                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>

                            <!-- <p class="text-right">
                            
                              <a class="f-16 p-t-0 text-right text-success" data-toggle="modal" href="#modalAgregar">Agregar Nuevo Cliente <i class="zmdi zmdi-account-add zmdi-hc-fw f-20 c-verde"></i></a>

                            </p> -->

                        </div>
                        


                        <div class="card-body p-b-20">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>


                                    <div class="col-sm-12">
                                 
                                    <span class="f-30 text-center c-morado" id="id-cliente"> Cliente</span>
                                

                                    <hr></hr>

                                    <div class="clearfix p-b-35"></div> 
                                 
                                    <div class="col-sm-12">
                                 
                                     <label for="alumno" id = "id-alumno_id">Nombre del Cliente</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona un participante al cual gestionarás su pago" title="" data-original-title="Ayuda"></i>

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
                                   
                               </div>
                               <div class="clearfix p-b-35"></div>
                          
                                    <div class="col-sm-12">
                                    
                                 
                                    <span class="f-30 text-center c-morado">Linea de Pago</span>
                                    


                                    <hr></hr>
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <form name="agregar_item" id="agregar_item"  >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <span class="f-20 text-center" id="id-producto-servicio">Producto o Servicio</span><i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Se refiere a todos aquellos servicios y productos que ofreces en tu academia, algunos ejemplos de estos  son, clases personalizadas,  clases  grupales,  secciones de asesoría, , franelas, gorras, gomas de baile entre otros,  los productos y  servicios  que deseas podrán ser agregados en la sección de configuración general en el campo llamado productos  y servicios" title="" data-original-title="Ayuda"></i>

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
                                </div>                                
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
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="form-control" name="combo" id="combo">
                                        </select>
                                      </div>
                                    </div>
                                  </div>

                              <div class="col-sm-2 text-center">
                                <!-- <input type="text" class="form-control input-sm" name="cantidad" id="cantidad" placeholder="Ej. 1"> -->
                                <input autocomplete="off" name="cantidad" id="cantidad" maxlength="5" class="form-control input-mask" data-mask="00000" placeholder="Ej. 10" type="text" >
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
                                          <option value = "{{ $impuesto }}">{{$impuesto}} %</option>
                                          <option value="0">0%</option>
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

                            <!-- <div class="card-header text-left text-success">
                            <span class="f-16 p-t-0">Agregar Linea</span></div> -->

                            <br><br><br>

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
                                    <th style="width:7%"><input style="margin-left:49%" name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
                                    <th class="text-center" data-column-id="id" data-identifier="true" data-order="desc">#</th>
                                    <th class="text-center" data-column-id="nombre">Producto o Servicio</th>
                                    <th class="text-center" data-column-id="cantidad">Cantidad</th>
                                    <th class="text-center" data-column-id="precio_neto" data-order="desc">Precio (Neto)</th>
                                    <th class="text-center" data-column-id="impuesto" data-order="desc">Impuesto</th>
                                    <th class="text-center" data-column-id="importe_neto" data-order="desc">Importe (Neto)</th>
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

                              <span class="f-700 opaco-0-8 f-16">Sección Factura</span>
                              
                               
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
  var totalfinal = 0;
  var alumno_id = '';
  var tipo = 'servicio';
  var checked = [];

  route_agregar="{{url('/')}}/administrativo/pagos/agregaritem";
  route_factura="{{url('/')}}/administrativo/pagos/gestion";
  route_eliminar="{{url('/')}}/administrativo/pagos/eliminaritem";
  route_pagar="{{url('/')}}/administrativo/pagos/factura";
  route_cancelar = "{{url('/')}}/administrativo/pagos/cancelarpago"
  route_proforma="{{url('/')}}/administrativo/pagos/pendiente/";
  route_pendientes="{{url('/')}}/administrativo/pagos/itemspendientes/";
  route_alumno="{{url('/')}}/participante/alumno/deuda/";

  function formatmoney(n) {
    return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
  }


  $( document ).ready(function() {

    
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
    $('#alumno_id').val('');
    alumno_id = '';
    $('#alumno_id').selectpicker('render');

    id = "{{{ $id or 'Default' }}}";
    $('#disponibilidad_productos').toggleClass("disponibilidad_productos_no");
    $('#disponibilidad_productos_campo').toggleClass("disponibilidad_productos_no");

    if(id != 'Default'){

      $("#alumno_id").val("{{{ $id or 'Default' }}}");
      $('#alumno_id').selectpicker('refresh');
      alumno_id = id;

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

              $.each(respuesta.items, function (index, array) {

                  var rowId=array[0].id;
                          var rowNode=t.row.add( [
                          ''+'<input name="select_check" id="select_check" type="checkbox" />'+'',  
                          ''+array[0].id+'',
                          ''+array[0].nombre+'',
                          ''+array[0].cantidad+'',
                          ''+array[0].precio_neto+'',
                          ''+array[0].impuesto+'',
                          ''+array[0].importe_neto+'',
                          ''+ ' ' +''
                          ] ).draw(false).node();
                          $( rowNode )
                          .attr('id',rowId)
                          // .attr('data-precio',precio_neto)
                          .addClass('seleccion');

              });

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
            scrollTop: $("#id-cliente").offset().top-90,
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
        order: [[1, 'desc']],
        paging:false,
        pageLength: 25,
        language: {
              searchPlaceholder: "Buscar"
        },
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6),td:eq(7)', nRow).addClass( "text-center" );
          $('td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6)', nRow).addClass( "disabled");
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

    $('#example-select-all').on('click', function(){
      // Check/uncheck all checkboxes in the table
      var rows = t.rows({ 'search': 'applied' }).nodes();
      $('input[type="checkbox"]', rows).prop('checked', this.checked);

   });

    $("#agregar_item")[0].reset();
    rechargeServicio();

      // $("#impuesto").val($("#impuesto option:first").val());
      // $("#combo").val($("#combo option:first").val());
      // $('input[name="cantidad"]').val(1)
      // $('input[name="importe_neto"]').val(0)
      // $('input[name="precio_neto"]').val(0)
      // $("#servicio").prop("checked", true);
      // $('#alumno_id').selectpicker('render');

    // impuestoglobal = $("#impuesto option:selected").val();
    impuestoglobal = 0;
    subtotalglobal = 0;

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
      // var datos = "&alumno_id="+$("#alumno_id option:selected" ).val();
      // var datos = $( "#agregar_item" ).serialize();
      var datos = "&alumno_id="+alumno_id+"&items_factura="+checked;
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
                window.location = "{{url('/')}}/administrativo/pagos/gestion";

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
                //window.location = "{{url('/')}}/error";
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

    $("#servicio").click(function(){
        $( "#producto2" ).removeClass( "c-verde" );
        $( "#servicio2" ).addClass( "c-verde" );
    });

    $("#producto").click(function(){
        $( "#servicio2" ).removeClass( "c-verde" );
        $( "#producto2" ).addClass( "c-verde" );
    });
    
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
          $('#disponibilidad_productos').toggleClass("disponibilidad_productos_no");
          $('#disponibilidad_productos_campo').toggleClass("disponibilidad_productos_no");
    } else  {
          tipo = 'producto';
          $('#combo').empty();
          rechargeProducto();
          $('#disponibilidad_productos').toggleClass("disponibilidad_productos_no");
          $('#disponibilidad_productos_campo').toggleClass("disponibilidad_productos_no");
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

      if(tipo == 'servicio'){

        var servicio = <?php echo json_encode($servicio);?>;

        incluye_iva = servicio[index][0]['incluye_iva'];
        console.log(incluye_iva);

        if(incluye_iva != 0){
          $("#impuesto").val($('#impuesto option').first().val());
        }
        else{
          $("#impuesto").val($('#impuesto option').last().val());
        }

      }else{

        var producto = <?php echo json_encode($producto);?>;
        incluye_iva = producto[index][0]['incluye_iva'];
        var disponible = producto[index][0]['disponibilidad'];
        console.log(incluye_iva);

        if(incluye_iva != 0){
          $("#impuesto").val($('#impuesto option').first().val());
        }
        else{
          $("#impuesto").val($('#impuesto option').last().val());
        }

      }

      var total = costo2 * cantidad2

      if(isNaN(total) || total == 0){
        costo2 = 0;
      }

      $('input[name="precio_neto"]').val(formatmoney(costo2))


      if(isNaN(total)){
        total = 0;
      }

      $('input[name="importe_neto"]').val(formatmoney(total))
      $('input[name="cantidad"]').val(1)
      $('input[name="campo_disponibilidad"]').val(disponible)
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

                          var rowId=respuesta.array[0].id;
                          var rowNode=t.row.add( [
                          ''+'<input name="select_check" id="select_check" type="checkbox" />'+'',
                          ''+respuesta.array[0].id+'',
                          ''+respuesta.array[0].nombre+'',
                          ''+respuesta.array[0].cantidad+'',
                          ''+formatmoney(parseFloat(respuesta.array[0].precio_neto))+'',
                          ''+respuesta.array[0].impuesto+'',
                          ''+formatmoney(parseFloat(respuesta.array[0].importe_neto))+'',
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
    
      var id = $(this).closest('tr').attr('id');

      var token = $('input:hidden[name=_token]').val();
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
        var campo = ["alumno_id", "combo", "cantidad", "linea"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
      var campo = ["alumno_id", "combo", "cantidad", "linea"];
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
                    $('#alumno_id').val('');
                    alumno_id = '';
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
        scrollTop: $("#id-alumno_id").offset().top-90,
        }, 1000);
      });

  $("#alumno_id").change(function(){

    t
      .clear()
      .draw();

    procesando();

    alumno_id = $("#alumno_id").val();

      if($("#alumno_id").val() != ""){

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

              // if(respuesta.items.length > 0){
              //   window.location = route_alumno + alumno_id;
              // }
              // else{
              //   finprocesado();
              //   $('html,body').animate({
              //     scrollTop: $("#id-producto-servicio").offset().top-90,
              //   }, 1000);
              // }
              // 
              finprocesado();
              $('html,body').animate({
                scrollTop: $("#id-producto-servicio").offset().top-90,
              }, 1000);

              total = 0;

              $.each(respuesta.items, function (index, array) {


                          var rowId=array[0].id;
                          var rowNode=t.row.add( [
                          ''+'<input name="select_check" id="select_check" type="checkbox" />'+'',  
                          ''+array[0].id+'',
                          ''+array[0].nombre+'',
                          ''+array[0].cantidad+'',
                          ''+formatmoney(array[0].precio_neto)+'',
                          ''+array[0].impuesto+'',
                          ''+formatmoney(array[0].importe_neto)+'',
                          ''+ ' ' +''
                          ] ).draw(false).node();
                          $( rowNode )
                          .attr('id',rowId)
                          // .attr('data-precio',precio_neto)
                          .addClass('seleccion');

                          // total = total + array[0].importe_neto;
                 
                    });

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

</script> 
@stop

