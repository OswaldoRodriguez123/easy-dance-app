@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/farbtastic/farbtastic.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/easy_dance_ico_5.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/farbtastic/farbtastic.min.js"></script>
@stop

@section('content')
     
  <div class="modal fade" id="modalFactura-Egreso" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Egreso<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
        </div>
        <form name="edit_factura_egreso" id="edit_factura_egreso"  >
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="modal-body">                           
              <div class="row p-t-20 p-b-0">
                <div class="col-sm-12">
                  <div class="form-group">
                    <div class="form-group fg-line">
                        <label for="factura" id="id-factura">Factura</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el número de la factura" title="" data-original-title="Ayuda"></i>

                        <input type="text" class="form-control input-sm" name="factura" id="factura" data-mask="00000000000000000000" placeholder="Ej. 16234987" value="{{$egreso->factura}}">
                    </div>
                    <div class="has-error" id="error-factura">
                      <span >
                        <small id="error-factura_mensaje" class="help-block error-span" ></small>                                           
                      </span>
                    </div>
                  </div>
                </div>

                <input type="hidden" name="id" value="{{$egreso->id}}"></input>
                
                <div class="clearfix"></div> 
              </div>
           
            </div>
          </form>
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

              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_factura_egreso" data-update="factura" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

            </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalTipo-Egreso" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Egreso<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
        </div>
        <form name="edit_tipo_egreso" id="edit_tipo_egreso"  >
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="modal-body">                           
              <div class="row p-t-20 p-b-0">
                <div class="col-sm-12">

                  <label for="config_tipo" id="id-config_tipo">Tipo</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el tipo de egreso" title="" data-original-title="Ayuda"></i>

                  <div class="fg-line">
                    <div class="select">
                      <select class="selectpicker" name="config_tipo" id="config_tipo" data-live-search="true">
                        <option value="">Selecciona</option>
                        @foreach ( $config_egresos as $tipo )
                          <option value = "{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="has-error" id="error-config_tipo">
                    <span >
                      <small class="help-block error-span" id="error-config_tipo_mensaje" ></small>                                           
                    </span>
                  </div>
                </div>

                <input type="hidden" name="id" value="{{$egreso->id}}"></input>
                
                <div class="clearfix"></div> 
              </div>
           
            </div>
          </form>
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

              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_tipo_egreso" data-update="tipo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

            </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalProveedor-Egreso" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Egreso<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
        </div>
        <form name="edit_proveedor_egreso" id="edit_proveedor_egreso"  >
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" value="{{$egreso->id}}"></input>
          <div class="modal-body">                           
            <div class="row p-t-20 p-b-0">
              <div class="col-sm-12">
                <div class="form-group">
                  <div class="form-group fg-line">
                      <label for="proveedor" id="id-proveedor">Proveedor</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el proveedor de la factura" title="" data-original-title="Ayuda"></i>

                      <input type="text" class="form-control input-sm" name="proveedor" id="proveedor" placeholder="Ej. Sillas" value="{{$egreso->proveedor}}">
                  </div>
                  <div class="has-error" id="error-proveedor">
                    <span >
                      <small id="error-proveedor_mensaje" class="help-block error-span" ></small>                                           
                    </span>
                  </div>
                </div>
              </div>
              
              <div class="clearfix"></div> 
            </div>
          </div>
        </form>
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

              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_proveedor_egreso" data-update="proveedor" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

            </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalConcepto-Egreso" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Egreso<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
        </div>
        <form name="edit_concepto_egreso" id="edit_concepto_egreso"  >
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" value="{{$egreso->id}}"></input>
          <div class="modal-body">                           
            <div class="row p-t-20 p-b-0">
              <div class="col-sm-12">
                <div class="form-group">
                  <div class="form-group fg-line">
                      <label for="concepto" id="id-concepto">Concepto</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el concepto de la factura" title="" data-original-title="Ayuda"></i>

                      <input type="text" class="form-control input-sm" name="concepto" id="concepto" placeholder="Ej. Sillas">
                  </div>
                  <div class="has-error" id="error-concepto">
                    <span >
                      <small id="error-concepto_mensaje" class="help-block error-span" ></small>                                           
                    </span>
                  </div>
                </div>
              </div>
              
              <div class="clearfix"></div> 
            </div>
          </div>
        </form>
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

              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_concepto_egreso" data-update="concepto" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

            </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalCantidad-Egreso" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Egreso<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
        </div>
        <form name="edit_cantidad_egreso" id="edit_cantidad_egreso"  >
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" value="{{$egreso->id}}"></input>
          <div class="modal-body">                           
            <div class="row p-t-20 p-b-0">
              <div class="col-sm-12">
                <div class="form-group">
                  <div class="form-group fg-line">
                      <label for="cantidad" id="id-cantidad">Cantidad</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el monto" title="" data-original-title="Ayuda"></i>

                      <input type="text" class="form-control input-sm" name="cantidad" id="cantidad" placeholder="Ej. 5000" data-mask="00000000000000000000" value="{{$egreso->cantidad}}">
                  </div>
                  <div class="has-error" id="error-cantidad">
                    <span >
                      <small id="error-cantidad_mensaje" class="help-block error-span" ></small>                                           
                    </span>
                  </div>
                </div>
              </div>
              
              <div class="clearfix"></div> 
            </div>
          </div>
        </form>
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

              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_cantidad_egreso" data-update="cantidad" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

            </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalFecha-Egreso" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Egreso<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
        </div>
        <form name="edit_fecha_egreso" id="edit_fecha_egreso"  >
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" value="{{$egreso->id}}"></input>
          <div class="modal-body">                           
            <div class="row p-t-20 p-b-0">
              <div class="col-sm-12">
                <div class="form-group">
                  <div class="form-group fg-line">
                      <label for="fecha" id="id-fecha">Fecha</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona la fecha en la que se realizó la factura" title="" data-original-title="Ayuda"></i>

                      <div class="dtp-container fg-line">
                        <input name="fecha" id="fecha" class="form-control date-picker proceso pointer" placeholder="Selecciona" type="text">
                      </div>
                  </div>
                  <div class="has-error" id="error-fecha">
                    <span >
                      <small id="error-fecha_mensaje" class="help-block error-span" ></small>                                           
                    </span>
                  </div>
                </div>
              </div>
              
              <div class="clearfix"></div> 
            </div>
          </div>
        </form>
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

              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_fecha_egreso" data-update="fecha" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

            </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalNit-Egreso" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Egreso<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
        </div>
        <form name="edit_nit_egreso" id="edit_nit_egreso"  >
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" value="{{$egreso->id}}"></input>
          <div class="modal-body">                           
            <div class="row p-t-20 p-b-0">
              <div class="col-sm-12">
                <div class="form-group">
                  <div class="form-group fg-line">
                      <label for="nit" id="id-nit">Nit</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nit de la factura" title="" data-original-title="Ayuda"></i>

                      <input type="text" class="form-control input-sm" name="nit" id="nit" placeholder="Ej. Sillas" value="{{$egreso->nit}}">
                  </div>
                  <div class="has-error" id="error-nit">
                    <span >
                      <small id="error-nit_mensaje" class="help-block error-span" ></small>                                           
                    </span>
                  </div>
                </div>
              </div>
              
              <div class="clearfix"></div> 
            </div>
          </div>
        </form>
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

              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_nit_egreso" data-update="nit" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

            </div>
        </div>
      </div>
    </div>
  </div>
  <section id="content">
      <div class="container">
      
          <div class="block-header">
              <?php $url = "/administrativo/egresos" ?>
              <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
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
                                <a href="#" class="disabled">
                                    <span class="ca-icon-planilla"><i class="fa fa-money"></i></span>
                                    <div class="ca-content-planilla">
                                        <h2 class="ca-main-planilla">Vista Egresos</h2>
                                        <h3 class="ca-sub-planilla">Personaliza el campo egreso</h3>
                                    </div>
                                </a>
                            </li>
                          </ul>

                      <div class="col-sm-12 text-center"> 

                        <br></br>

                        <span class="f-16 f-700">Acciones</span>

                        <hr></hr>
                        

                        <i class="zmdi zmdi-delete f-20 m-r-10 boton red sa-warning" name="eliminar" data-original-title="Eliminar" data-toggle="tooltip" data-placement="bottom" title=""></i>




                        <br></br>
                      
                        <hr></hr>

                        <br></br>
                           
                    </div>
                  </div>                
                </div>
              </div>
             </div>

           	<div class="col-sm-9">

               <div class="col-sm-12">
                    <p class="text-center opaco-0-8 f-22">Datos del Egreso</p>
                </div>

                <div class="col-sm-12">
                 <table class="table table-striped table-bordered">

                  <tr class="detalle" data-toggle="modal" href="#modalFactura-Egreso">
                   <td>
                     <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-factura" class="zmdi {{ empty($egreso->factura) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                     <span class="m-l-10 m-r-10"> <i class="fa fa-money f-22"></i> </span>
                     <span class="f-14"> Factura </span>
                   </td>
                   <td class="f-14 m-l-15" ><span id="egreso-factura">{{$egreso->factura}}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                  </tr>
                  <tr class="detalle" data-toggle="modal" href="#modalTipo-Egreso">
                   <td>
                     <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-config_tipo" class="zmdi  {{ empty($egreso->nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                     <span class="m-l-10 m-r-10"> <i class="icon_a-especialidad f-22"></i> </span>
                     <span class="f-14"> Tipo </span>
                   </td>
                   <td class="f-14 m-l-15" ><span id="egreso-config_tipo"><span>{{$egreso->nombre}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                  </tr>
                  <tr class="detalle" data-toggle="modal" href="#modalProveedor-Egreso">
                   <td>
                     <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-proveedor" class="zmdi {{ empty($egreso->proveedor) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                     <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-accounts-alt f-22"></i> </span>
                     <span class="f-14"> Proveedor </span>
                   </td>
                   <td class="f-14 m-l-15" ><span id="egreso-proveedor" class="capitalize">{{$egreso->proveedor}}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                  </tr>
                  <tr class="detalle" data-toggle="modal" href="#modalConcepto-Egreso">
                   <td>
                     <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-concepto" class="zmdi {{ empty($egreso->concepto) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                     <span class="m-l-10 m-r-10"> <i class="icon_b-cuentales-historia f-22"></i> </span>
                     <span class="f-14"> Concepto </span>
                   </td>
                   <td id="egreso-concepto" class="f-14 m-l-15 capitalize" data-valor="{{$egreso->concepto}}" >{{ str_limit($egreso->concepto, $limit = 30, $end = '...') }} <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                  </tr>
                  <tr class="detalle" data-toggle="modal" href="#modalCantidad-Egreso">
                   <td>
                     <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-cantidad" class="zmdi {{ empty($egreso->cantidad) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                     <span class="m-l-10 m-r-10">  <i class="icon_b icon_b-costo f-22"></i> </span>
                     <span class="f-14"> Cantidad </span>
                   </td>
                   <td class="f-14 m-l-15" ><span id="egreso-cantidad"><span>{{$egreso->cantidad}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                  </tr>
                  <tr class="detalle" data-toggle="modal" href="#modalFecha-Egreso">
                   <td>
                     <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-fecha" class="zmdi {{ empty($egreso->fecha) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                     <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-calendar-check f-22"></i> </span>
                     <span class="f-14"> Fecha </span>
                   </td>
                   <td class="f-14 m-l-15"><span id="egreso-fecha">{{ \Carbon\Carbon::createFromFormat('Y-m-d',$egreso->fecha)->format('d/m/Y')}}</span><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></td>
                  </tr>
                  <tr class="detalle" data-toggle="modal" href="#modalNit-Egreso">
                   <td>
                     <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-nit" class="zmdi {{ empty($egreso->nit) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                     <span class="m-l-10 m-r-10">  <i class="icon_b-nombres f-22"></i> </span>
                     <span class="f-14"> Nit </span>
                   </td>
                   <td class="f-14 m-l-15" ><span id="egreso-nit"><span>{{$egreso->nit}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                  </tr>

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
      route_update="{{url('/')}}/administrativo/egresos/update";
      route_eliminar="{{url('/')}}/administrativo/egresos/eliminar";
      route_principal="{{url('/')}}/administrativo/egresos";

      $(document).ready(function(){

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


    $('#modalFecha-Egreso').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#fecha").val($("#egreso-fecha").text()); 
    })
    $('#modalConcepto-Egreso').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var concepto = $("#egreso-concepto").data('valor');
       $("#concepto").val(concepto);
    })

    $('#modalPresentacion-Fiesta').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var presentacion=$("#fiesta-presentacion").data('valor');
       $("#presentacion").val(presentacion);
    })

    function limpiarMensaje(){
        var campo = ["factura", "concepto", "fecha", "proveedor", "cantidad", "nit"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
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
            $("#egreso-"+c.name).data('valor',c.value);
            $("#egreso-"+c.name).html(valor);
          }else if(c.name=='config_tipo'){
            
            expresion = "#"+c.name+ " option[value="+c.value+"]";
            texto = $(expresion).text();
            
            $("#egreso-"+c.name).text(texto);
          }else if(c.name=='concepto'){
             $("#egreso-"+c.name).data('valor',c.value);
             $("#egreso-"+c.name).html(c.value.substr(0, 30) + "...");
          }else{
            $("#egreso-"+c.name).text(c.value);
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
        var nFrom = $(this).attr('data-from');
        var nAlign = $(this).attr('data-align');
        var nIcons = $(this).attr('data-icon');
        var nAnimIn = "animated flipInY";
        var nAnimOut = "animated flipOutY"; 
        limpiarMensaje();
        procesando();
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
                //   window.location = "{{url('/')}}/error";
                // }
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
                finprocesado();
              }, 1000);             
            }
        })
       
    })

    $("i[name=eliminar]").click(function(){
      swal({   
          title: "Para eliminar el egreso necesita colocar la clave de supervisión",   
          text: "Confirmar eliminación!",   
          type: "input",  
          showCancelButton: true,   
          confirmButtonColor: "#DD6B55",   
          confirmButtonText: "Aceptar",  
          cancelButtonText: "Cancelar",         
          closeOnConfirm: false,
          animation: "slide-from-top",
          inputPlaceholder: "Coloque la clave de supervisión"
      }, function(inputValue){
        if (inputValue === false) return false;
        
        if (inputValue === "") {
          swal.showInputError("Ups! La clave de supervisión es requerida");
          return false
        }else{

          var route = route_eliminar;
          var token = $('input:hidden[name=_token]').val();
          var datos = "&id={{$id}}&password_supervision="+inputValue
          procesando();
          
          $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data:datos,
            success:function(respuesta){

              window.location=route_principal; 

            },
            error:function(msj){
              finprocesado();
              if(msj.responseJSON.status == "ERROR-PASSWORD"){
                swal.showInputError("Ups! La clave de supervisión es incorrecta");
              }else{
                swal('Solicitud no procesada','Ups! Ha ocurrido un error, intente nuevamente','error');
              }
            }
          });
        }
      });
  });
    
  </script>  
		
@stop
