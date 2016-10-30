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

            <div class="modal fade" id="modalFecha-Acuerdo" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Acuerdo de Pago<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_fecha" id="edit_fecha"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                    <label for="fecha" id="id-fecha_actualizada">Fecha</label>
                                    <div class="fg-line">
                                        <input name="fecha_actualizada" id="fecha_actualizada" class="form-control date-picker pointer" placeholder="Seleciona" type="text">
                                    </div>
                                 </div>
                                    <div class="has-error" id="error-fecha_actualizada">
                                      <span >
                                          <small id="error-fecha_actualizada_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value=""></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 pointer" id="actualizar">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <!-- END -->

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
                                    <li class="waves-effect"><a href="{{url('/')}}/administrativo/pagos/generar" aria-controls="home11" onclick="procesando()"><div class="icon_a icon_a-pagar f-30"></div><p style=" margin-bottom: -2px;">Pagos</p></a></li>
                                    <li class="waves-effect active"><a href="{{url('/')}}/administrativo/acuerdos/generar" aria-controls="home11" onclick="procesando()"><div class="icon_a icon_a-acuerdo-de-pago f-30"></div><p style=" margin-bottom: -2px;">Acuerdos</p></a></li>
                                    <li class="waves-effect"><a href="{{url('/')}}/administrativo/presupuestos/generar" aria-controls="home11" onclick="procesando()"><div class="icon_a icon_a-presupuesto f-30"></div><p style=" margin-bottom: -2px;">Presupuestos</p></a></li>
                                    <li class="waves-effect"><a href="{{url('/')}}/reportes/administrativo" onclick="procesando()"><div class="icon_d icon_d-reporte f-30"></div><p style=" margin-bottom: -2px;">Reportes</p></a></li>
                                    
                            </ul>
                            </div>
                            
                            <div class="clearfix p-b-15"></div>
                 

                        </div>
                        


                        <div class="card-body p-b-20">
                          <!--<form name="agregar_campana" id="agregar_campana"  >-->
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>


                                    <div class="col-sm-12">
                                 
                                    <span class="f-30 text-center c-morado" id="id-cliente">Cliente</span>
                                

                                    <hr>

                                    <div class="clearfix p-b-35"></div> 
                                 
                                    <div class="col-sm-12">
                                 
                                     <label for="alumno" id="id-alumno_id">Nombre del Cliente</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona un participante al cual gestionarás su pago" title="" data-original-title="Ayuda"></i>
                                     </div>
                                    
                                    <div class="col-xs-6">
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
                                  <div class="col-xs-6 text-center c-morado">
                                  <span class="f-16 p-t-0">Debe </span><span class="f-16 p-t-0" id="total2" name="total2">0</span></div> 
                              </div>

                              <div class="clearfix p-b-35"></div>
                          
                              <div class="col-sm-12">

                                  <form name="generar_acuerdo" id="generar_acuerdo" method="POST" action="{{url('/')}}/administrativo/acuerdo/generar">

                                   <input type="hidden" name="_token" value="{{ csrf_token() }}">                                    
                                 
                                    <span class="f-30 text-center c-morado" id="id-linea">Linea de Acuerdos de Pago</span>
                                    
                                    <hr>
                                    
                                    <div class="clearfix p-b-35"></div>

                                   <div class="col-sm-4 text-center">

                                   <span class="f-16 c-morado" id="id-fecha">Fecha del primer pago</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda" data-trigger="hover" data-toggle="popover" data-placement="bottom" data-content=" Indícale al sistema cuando será la primera fecha de pago del acuerdo que estás gestionando" title="" data-original-title="Ayuda"></i>

                                   </div>
                                   <div class="col-sm-4 text-center">

                                   <span class="f-16 c-morado" id="id-frecuencia">Frecuencia</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda" data-trigger="hover" data-toggle="popover" data-placement="bottom" data-content="Indícale al sistema la frecuencia de pago que estás gestionando" title="" data-original-title="Ayuda"></i>

                                   </div>
                                   <div class="col-sm-4 text-center">

                                   <span class="f-16 c-morado" id="id-partes">Partes</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda" data-trigger="hover" data-toggle="popover" data-placement="bottom" data-content="Indícale al sistema la cantidad de cuotas que estás gestionando" title="" data-original-title="Ayuda"></i>

                                   </div>

                              <div class="clearfix p-b-35"></div>

                            <div class="col-sm-4 text-center">
                                <input name="fecha" id="fecha" class="form-control date-picker proceso pointer" placeholder="Selecciona" type="text">
                            </div>

                            <div class="col-sm-4 text-center">
                                <div class="select">
                                    <select class="selectpicker" name="frecuencia" id="frecuencia" data-live-search="true">
                                        <option value="">Selecciona</option>
                                        <option value="Semanal">Semanal</option>
                                        <option value="Quincenal">Quincenal</option>
                                        <option value="Mensual">Mensual</option>        
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4 text-center">
                                <input type="text" class="form-control input-sm" name="partes" id="partes" placeholder="Ej. 4">
                            </div>

                              <br><br>
                              
                              <div class="col-sm-4 text-center">
                                <div class="has-error" id="error-fecha">
                                      <span >
                                        <small class="help-block error-span" id="error-fecha_mensaje" ></small>                                           
                                      </span>
                                  </div>
                              </div>

                              <div class="col-sm-4 text-center">
                                <div class="has-error" id="error-frecuencia">
                                      <span >
                                        <small class="help-block error-span" id="error-frecuencia_mensaje" ></small>                                           
                                      </span>
                                  </div>
                              </div>

                              <div class="col-sm-4 text-center">
                                <div class="has-error" id="error-partes">
                                      <span >
                                        <small class="help-block error-span" id="error-partes_mensaje" ></small>                                           
                                      </span>
                                  </div>
                              </div>

                              <br>

                              <div class="col-sm-2">

                              <button type="button" class="btn btn-blanco m-r-8 f-10 guardar" name= "generar" id="generar" > Procesar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>

                              </div>

                              <div class="col-sm-4">
                                <div class="has-error" id="error-linea">
                                      <span >
                                        <small class="help-block error-span" id="error-linea_mensaje" ></small>                                           
                                      </span>
                                  </div>
                              </div>


                              </form>

                            </div>

          
                        <div class="clearfix p-b-35"></div>

                              <!--<div class="clearfix p-b-35"></div>-->

                          <div class="table-responsive">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="id" data-type="forma_pago">No</th>
                                    <th class="text-center" data-column-id="fecha">Fecha de frecuencia <span id="span_frecuencia"></span></th>
                                    <th class="text-center" data-column-id="cantidad" data-order="desc">Cantidad de <span id="span_partes"></span> partes</th>
                                    <th class="text-center" data-column-id="operaciones" data-type="operaciones">Operaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                                           
                            </tbody>
                          </table>

                        </div>
                        </div>
                        <div class="clearfix p-b-15"></div>


                                    <div class="col-sm-12">

                                    <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Opciones Avanzadas</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Desde esta sección de opción avanzada podrás generar una mora por retraso de pago e incluir el porcentaje que consideres pertinente" title="" data-original-title="Ayuda"></i>
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

                                    <div class="col-sm-12">
                                          <label for="id" id="id-porcentaje_retraso">Porcentaje de retraso de pago</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa un porcentaje de mora por retraso de pago correspondiente al servicio que ofreces" title="" data-original-title="Ayuda"></i>
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="zmdi zmdi-collection-item-1 f-22"></i></span>
                                                 <div class="fg-line"> 
                                                  
                                                  <input type="text" class="form-control input-sm input-mask" name="porcentaje_retraso" id="porcentaje_retraso" data-mask="00" placeholder="Ej. 20">

                                                  </div>
                                                </div>
                                              <div class="has-error" id="error-porcentaje_retraso">
                                                <span >
                                                    <small id="error-porcentaje_retraso_mensaje" class="help-block error-span" ></small>                                           
                                                </span>
                                              </div>
                                          
                                      </div>

                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-12">
                                          <label for="id" id="id-tiempo_tolerancia">Tiempo de Tolerancia</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa los días de tolerancia que ofreces a tus clientes para la gestión del pago del servicio, al vencerse dicha fecha el sistema generará una mora por retraso de pago, según el porcentaje que hayas indicado" title="" data-original-title="Ayuda"></i>
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="zmdi zmdi-collection-item-1 f-22"></i></span>
                                                 <div class="fg-line"> 
                                                  <input type="text" class="form-control input-sm input-mask" name="tiempo_tolerancia" id="tiempo_tolerancia" data-mask="00" placeholder="Ej. 20">
                                                  </div>
                                                </div>
                                              <div class="has-error" id="error-tiempo_tolerancia">
                                                <span >
                                                    <small id="error-tiempo_tolerancia_mensaje" class="help-block error-span" ></small>                                           
                                                </span>
                                              </div>
                                          
                                      </div>

                                      <div class="clearfix p-b-20"></div>


                            <div class="clearfix p-b-35"></div>
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


                                 
                                    <!-- <span class="f-30 text-center c-morado">Totales</span>
                                    
                                    
                                    <hr></hr>

                                    <div class="clearfix p-b-35"></div> 
                                 
                                    <div class="col-sm-12 text-right">
                                    <p><span class="f-15 c-morado">Sub total</span>
                                    <span class="f-15 c-morado">2800</span>
                                    </p>
                                    <p><span class="f-15 text-right c-morado">Impuesto</span>
                                    <span class="f-15 c-morado">1200</span></p>
                                    <p><span class="f-15 text-right c-morado">Total VEF</span>
                                    <span class="f-15 c-morado">400</span></p>
                                    </div> -->
                                   

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
                                <a href="{{url('/')}}/administrativo/acuerdos"><i class="zmdi zmdi-eye zmdi-hc-fw f-30 boton blue sa-warning"></i></a>

                                <br>

                                <span class="f-700 opaco-0-8 f-16">Sección Acuerdo</span>
                              </div>

                              <div class="text-right">                           
                                <button type="button" class="btn btn-blanco m-r-10 f-14 guardar" name= "guardar" id="guardar" >Acordar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>

                                <button type="button" class="cancelar btn btn-default" name="cancelar" id="cancelar">Cancelar</button>
                              </div>
                              
                               
                            </div>


                            
                            </div>
                        </div><!--</form>-->
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

  var route_agregar="{{url('/')}}/administrativo/acuerdo/guardar";
  var route_actualizar="{{url('/')}}/administrativo/acuerdo/actualizar";
  var route_pendientes="{{url('/')}}/administrativo/pagos/pendiente/";
  var router_generar_acuerdo="{{url('/')}}/administrativo/acuerdo/generar";
  var route_principal="{{url('/')}}/participante/alumno/deuda/";

  var totalglobal = 0;

  $('#alumno_id').selectpicker('deselectAll');
  $('#frecuencia').selectpicker('deselectAll');
  $('#fecha').val('');
  $('#partes').val('');
  $('#alumno_id').selectpicker('refresh');
  $('#frecuencia').selectpicker('refresh');

  $('#fecha').prop('readonly', true);
  $("#frecuencia").attr("disabled","disabled");
  $('#partes').prop('readonly', true);
  $("#generar").attr("disabled","disabled");
  $("#guardar").attr("disabled","disabled");
  $("#generar").css({
    "opacity": ("0.2")
  });
  $("#guardar").css({
    "opacity": ("0.2")
  });
  // $('#someid').removeProp('readonly');

  function formatmoney(n) {
    return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
  }

  $( document ).ready(function() {

    tmp = "{{{ $acuerdo or 'Default' }}}";

    if(tmp == 0 && tmp != 'Default'){

      totalglobal = parseFloat("{{{$total or 'Default' }}}");

      $("#alumno_id").val("{{{$id or 'Default' }}}");
      $('#alumno_id').selectpicker('refresh');
      $("#total2").text(formatmoney(totalglobal));

      $('#fecha').prop('readonly', false);
      $('#frecuencia').removeAttr('disabled');
      $('#frecuencia').selectpicker('refresh');
      $('#partes').prop('readonly', false);
      $('#generar').removeAttr('disabled');
      $('#guardar').removeAttr('disabled');

      $("#generar").css({
        "opacity": ("1")
      });

      $("#guardar").css({
        "opacity": ("1")
      });
    }

    $('body,html').animate({scrollTop : 0}, 2000);
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

    setTimeout(function(){ 

    $('html,body').animate({
        scrollTop: $("#id-cliente").offset().top-90,
        }, 1000);

    }, 1000);
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
        /*if ($('{ { count(acuerdos) } }').length < 25) {
              $('.dataTables_paginate').hide();
          }
          else{
             $('.dataTables_paginate').show();
          }*/
        },
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3)', nRow).attr( "onclick","previa(this)" );
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

  $("#generar").click(function(){

    $("#generar").attr("disabled","disabled");
      $("#generar").css({
      "opacity": ("0.2")
    });
    var route = router_generar_acuerdo;
    var token = $('input:hidden[name=_token]').val();
    var datos = $( "#generar_acuerdo" ).serialize(); 

    $(".generar_acuerdo").attr("disabled","disabled");
    $.ajax({
      url: route,
      headers: {'X-CSRF-TOKEN': token},
      type: 'POST',
      dataType: 'json',
      data:datos +"&total="+totalglobal,
      success:function(respuesta){
        console.log(respuesta);
        setTimeout(function(){ 
          $(".generar_acuerdo").removeAttr("disabled");
          var nFrom = $(this).attr('data-from');
          var nAlign = $(this).attr('data-align');
          var nIcons = $(this).attr('data-icon');
          var nAnimIn = "animated flipInY";
          var nAnimOut = "animated flipOutY"; 
          if(respuesta.status=="OK"){
            var nType = 'success';
            $('#fecha').val('');
            $('#partes').val('');
            $('#frecuencia').selectpicker('render');
            $('#frecuencia').selectpicker('refresh');
            $('#span_frecuencia').text(respuesta.acuerdos.frecuencia);
            $('#span_partes').text(respuesta.acuerdos.partes);
            var nTitle="Ups! ";
            var nMensaje=respuesta.mensaje;

            t
              .clear()
              .draw();

            acuerdo(respuesta.acuerdos);
          }else{
            var nTitle="Ups! ";
            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
            var nType = 'danger';
          }     
          $("#generar").removeAttr("disabled");
             $("#generar").css({
            "opacity": ("1")
          });                  
          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
        }, 1000);
        
      },
      error:function(msj){
        setTimeout(function(){ 
          // if (typeof msj.responseJSON === "undefined") {
          //                 window.location = "{{url('/')}}/error";
          //               }
          $(".generar_acuerdo").removeAttr("disabled");
          if(msj.responseJSON.status=="ERROR"){
            console.log(msj.responseJSON.errores);
            errores(msj.responseJSON.errores);
            var nTitle="    Ups! "; 
            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
          }else{
            var nTitle="   Ups! "; 
            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
          }                        
          //$(".generar_acuerdo").removeAttr("disabled");
          $("#generar").removeAttr("disabled");
             $("#generar").css({
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

  $("#guardar").click(function(){

                id = $("#alumno_id").val()
                porcentaje_retraso = $("#porcentaje_retraso").val()
                tiempo_tolerancia = $("#tiempo_tolerancia").val()

                var route = route_agregar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#generar_acuerdo" ).serialize(); 
                $("#guardar").attr("disabled","disabled");
                $(".cancelar").attr("disabled","disabled");
                $(".procesando").removeClass('hidden');
                $(".procesando").addClass('show');         
                limpiarMensaje();
                procesando();
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data:"&alumno_id="+id+"&porcentaje_retraso="+porcentaje_retraso+"&tiempo_tolerancia="+tiempo_tolerancia,
                    success:function(respuesta){
                      setTimeout(function(){ 
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        if(respuesta.status=="OK"){

                          window.location = route_principal + id;

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }                       
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        $("#guardar").removeAttr("disabled");
                        $(".cancelar").removeAttr("disabled");

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

    $("#actualizar").click(function(){


        var route = route_actualizar;
        var token = $('input:hidden[name=_token]').val();
        var datos = $( "#edit_fecha" ).serialize();         
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
                finprocesado();
                if(respuesta.status=="OK"){

                  var nType = 'success';
                  var nTitle="Ups! ";
                  var nMensaje=respuesta.mensaje;

                  $('#'+respuesta.i).find('td:eq(1)').text(respuesta.fecha);
                  $('.modal').modal('hide');

                }else{
                  var nTitle="Ups! ";
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                  var nType = 'danger';
                }                       
                $(".procesando").removeClass('show');
                $(".procesando").addClass('hidden');
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

      function limpiarMensaje(){
        var campo = ["alumno_id", "linea", "fecha", "frecuencia", "partes"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
      var campo = ["alumno_id", "linea", "fecha", "frecuencia", "partes"];
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


                    $("#generar_acuerdo")[0].reset();
                    $('#alumno_id').selectpicker('render');
                    limpiarMensaje();
                    $('#frecuencia').selectpicker('render');

                    $('#alumno_id').selectpicker('deselectAll');
                    $('#frecuencia').selectpicker('deselectAll');
                    $('#fecha').val('');
                    $('#partes').val('');
                    $('#total2').text('');
                    $('#alumno_id').selectpicker('refresh');
                    $('#frecuencia').selectpicker('refresh');

                    $('#fecha').prop('readonly', true);
                    $("#frecuencia").attr("disabled","disabled");
                    $('#partes').prop('readonly', true);
                    $("#generar").attr("disabled","disabled");
                    $("#guardar").attr("disabled","disabled");
                    $("#generar").css({
                      "opacity": ("0.2")
                    });
                    $("#guardar").css({
                      "opacity": ("0.2")
                    });

                    $("#subtotal").text(0);
                    $("#impuestototal").text(0);
                    $("#total").text(0);

                       t
                        .clear()
                        .draw();

        $('html,body').animate({
        scrollTop: $("#id-cliente").offset().top-90,
        }, 1000);
      });

  function acuerdo(acuerdo){
    var acuerdo_fechas=acuerdo.fechas_acuerdo;
    console.log(t);
    $.each(acuerdo_fechas, function (n, c) {  

      var numero = acuerdo_fechas[n].numero;
      var fecha_frecuencia = acuerdo_fechas[n].fecha_frecuencia;
      var cantidad = acuerdo_fechas[n].cantidad;
      var rowId=numero;
        var rowNode=t.row.add( [
        ''+numero+'',
        ''+fecha_frecuencia+'',
        ''+cantidad+'',
        '<i class="zmdi zmdi-edit m-r-5 f-20"></i>'
        ] ).draw(false).node();
        $( rowNode )
        .attr('id',rowId)       
        .addClass('seleccion');
      console.log(c);
    });  

    $('html,body').animate({
        scrollTop: $("#fecha").offset().top-90,
        }, 1000);
    
  }

  $("#alumno_id").change(function(){

    procesando();

    id = $(this).val();
    limpiarMensaje();
    var route = route_pendientes + id;
    console.log(route);
    var token = $('input:hidden[name=_token]').val();
    $.ajax({
      url: route,
      headers: {'X-CSRF-TOKEN': token},
      type: 'POST',
      dataType: 'json',
      success:function(respuesta){
        console.log(respuesta);
        setTimeout(function(){ 
          var nFrom = $(this).attr('data-from');
          var nAlign = $(this).attr('data-align');
          var nIcons = $(this).attr('data-icon');
          var nAnimIn = "animated flipInY";
          var nAnimOut = "animated flipOutY"; 
          if(respuesta.status=="OK"){

            t
              .clear()
              .draw();



              $('#fecha').prop('readonly', false);
              $('#frecuencia').removeAttr('disabled');
              $('#frecuencia').selectpicker('refresh');
              $('#partes').prop('readonly', false);;
              $('#generar').removeAttr('disabled');
              $('#guardar').removeAttr('disabled');
              $("#generar").css({
                "opacity": ("1")
              });
              $("#guardar").css({
                "opacity": ("1")
              });

              $('html,body').animate({
                scrollTop: $("#id-linea").offset().top-90,
              }, 1000);

            $("#total2").text(formatmoney(respuesta.total));
            totalglobal = respuesta.total;

          }else{
            var nTitle="Ups! ";
            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
            var nType = 'danger';
          } 
          finprocesado();                      
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

          finprocesado();

          $('#fecha').prop('readonly', true);
          $("#frecuencia").attr("disabled","disabled");
          $('#frecuencia').selectpicker('refresh');
          $('#partes').prop('readonly', true);
          $("#generar").attr("disabled","disabled");
          $("#guardar").attr("disabled","disabled");
          $("#generar").css({
            "opacity": ("0.2")
          });
          $("#guardar").css({
            "opacity": ("0.2")
          }); 
                                
          var nFrom = $(this).attr('data-from');
          var nAlign = $(this).attr('data-align');
          var nIcons = $(this).attr('data-icon');
          var nType = 'danger';
          var nAnimIn = "animated flipInY";
          var nAnimOut = "animated flipOutY";
          $("#total2").text(0);
          totalglobal = 0;                       
          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
        }, 1000);
     }
   });
  });

  function collapse_minus(collaps){
       $('#'+collaps).collapse('hide');
      }

      // $('#collapseTwo').on('show.bs.collapse', function () {
      //   $("#guardar").attr("disabled","disabled");
      //   $("#guardar").css({"opacity": ("0.2")});
      // })

      // $('#collapseTwo').on('hide.bs.collapse', function () {
      //   $("#guardar").removeAttr("disabled");
      //   $("#guardar").css({"opacity": ("1")});
      // })
      function previa(t){
        //$('#tablelistar tbody').on( 'click', 'i.zmdi-edit', function () {
        var padre=$(t).closest('tr');
        console.log(padre);
        var td_fecha = $(padre).find('td:eq(1)').text();
        var fecha = td_fecha.split("-")
        $('#fecha_actualizada').val(fecha[0]+'/'+fecha[1]+'/'+fecha[2]);
        $('input[name=id]').val($(t).closest('tr').attr('id'));
        $('#modalFecha-Acuerdo').modal('show');
        //});
      }

</script> 
@stop

