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
<!--MERCADO PAGO MODAL -->
<!--<script type="text/javascript" src="http://resources.mlstatic.com/mptools/render.js"></script>-->
@stop
@section('content')

            <section id="content">
                <div class="container">
                  <div class="block-header">
                      <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menu Principal</a>
                      <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                  </div> 
            
                    
                      <div class="card">
                        <div class="card-header text-center">
                            <div class="col-sm-4 text-left">
                            <span class="f-16 p-t-0">Cliente: {{$alumno->nombre}} {{$alumno->apellido}}</span>
                            <div class="clearfix p-b-15"></div>

                            <a id="id-generar" href="{{url('/')}}/administrativo/acuerdos/generar/{{$alumno->id}}"><span class="f-16 p-t-0 text-success" id="acuerdo">Generar acuerdo de pago <i class="icon_a icon_a-acuerdo-de-pago f-14"></i></span></a></div>

                            <div class="col-sm-4 c-morado">
                            </div>
                            <div class="col-sm-4 c-morado text-right">
                            <span class="f-4 p-t-0">Número de Factura {{$numero_factura}}</span>
                            <div class="clearfix p-b-15"></div>
                            <span class="f-16 p-t-0">Total a pagar </span><span class = "f-16" name ="total2" id = "total2"></div>

                            <br><br>
   
                        </div>
                        
                        <div class="card-body p-b-20">
                          <form name="gestionar_pago" id="gestionar_pago">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>

                          
                                    <div class="col-sm-12">
                                    
                                 
                                    <span class="f-30 text-center c-morado">Datos de Pago</span>
                                    


                                    <!-- <hr></hr> -->
                                    
                                    <div class="clearfix p-b-35"></div>

                                   <div class="col-sm-3 text-center">

                                   <span class="f-16 c-morado" id="id-forma_pago_id">Forma de pago</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="bottom" data-content="Selecciona la forma en el que el cliente realizará el pago , esto te servirá de documentación a la hora del cierre" title="" data-original-title="Ayuda"></i>

                                   </div>
                                   <div class="col-sm-3 text-center">

                                   <span class="f-16 c-morado" id="id-linea">Banco</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="bottom" data-content="Ingresa la identidad bancaria de la herramienta de gestión de pago del cliente" title="" data-original-title="Ayuda"></i>

                                   </div>
                                   <div class="col-sm-3 text-center">

                                   <span class="f-16 c-morado">Referencia</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="bottom" data-content="Escribe la referencia del instrumento de pago del cliente, Ej. en caso de ser un cheque, escribe el número de cheque" title="" data-original-title="Ayuda"></i>

                                   </div>
                                   <div class="col-sm-3 text-center">

                                   <span class="f-16 c-morado" id="id-monto">Monto</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="bottom" data-content="Selecciona la cantidad de dinero que realizará el cliente al momento del pago" title="" data-original-title="Ayuda"></i>

                                   </div>

                              <div class="clearfix p-b-35"></div>

                            <div class="col-sm-3 text-center">
                                <div class="select">
                                    <select class="selectpicker" name="forma_pago_id" id="forma_pago_id" data-live-search="true">
                                        <option value="">Selecciona</option>
                                        @foreach ( $formas_pago as $forma )
                                          <option value = "{{ $forma->id }}">{{ $forma->nombre }}</option>
                                        @endforeach       
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-3 text-center">
                                <input type="text" class="form-control input-sm" name="banco" id="banco" placeholder="Ej. Banco del tesoro">
                            </div>

                            <div class="col-sm-3 text-center">
                                <input type="text" class="form-control input-sm" name="referencia" id="referencia" placeholder="Ej. 2356897">
                            </div>

                            <div class="col-sm-3 text-center">
                                <input type="text" class="form-control input-sm" name="monto" id="monto" placeholder="Ej. 100">
                            </div>

                            <div class="clearfix p-b-35"></div>

                            <div class="col-sm-3 text-center">
                                <div class="has-error" id="error-forma_pago_id">
                                      <span >
                                        <small class="help-block error-span" id="error-forma_pago_id_mensaje" ></small>                                           
                                      </span>
                                  </div>
                              </div>

                              <div class="col-sm-6 text-center"></div>

                              <div class="col-sm-3 text-center">
                                <div class="has-error" id="error-monto">
                                      <span >
                                        <small class="help-block error-span" id="error-monto_mensaje" ></small>                                           
                                      </span>
                                  </div>
                              </div>

                                
                                <div class="col-md-2 text-left pull-left">
                                  <button type="button" class="btn btn-blanco m-r-8 f-10 guardar" name= "add" id="add" > Agregar Linea <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>
                                </div>

                                <div class="col-sm-4">
                                  <div class="has-error" id="error-linea">
                                        <span >
                                          <small class="help-block error-span" id="error-linea_mensaje" ></small>                                           
                                        </span>
                                    </div>
                                </div>

                                <div class="clearfix p-b-35"></div>
                      

                          <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="forma_pago">Forma de Pago</th>
                                    <th class="text-center" data-column-id="banco">Banco</th>
                                    <th class="text-center" data-column-id="referencia" data-order="desc">Referencia</th>
                                    <th class="text-center" data-column-id="monto" data-order="desc">Monto</th>
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

                                 
                                    <span class="f-30 text-center c-morado">Totales</span>
                                    
                                    
                                    <hr></hr>

                                    <div class="clearfix p-b-35"></div> 
                                 
                                   <div class="col-sm-12 text-right">
                                    <!-- <p><span class="f-15 c-morado">Sub total</span>
                                    <span class="f-15 c-morado" id = "subtotal"></span>
                                    </p>
                                    <p><span class="f-15 text-right c-morado">Impuesto</span>
                                    <span class="f-15 c-morado" id = "impuestototal"></span></p> -->
                                    <p><span class="f-15 text-right c-morado">Resta Total</span>
                                    <span class="f-15 c-morado" id = "total"></span></p>
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
                            
                            <div class="col-sm-6 text-left"> 
                          
                            </div>


                            <div class="col-sm-6 text-right pull-right" style="padding-right: 0px">  
                              
                              <!--<a href="{{-- $datos['response']['init_point'] --}}" name="MP-Checkout" class="btn btn-blanco m-r-10 f-14 guardar VeOn" mp-mode="modal" onreturn="respuesta_mercadopago">Mercado Pago</a>-->
                              <button type="button" class="btn btn-blanco m-r-10 f-14 guardar" name= "guardar" id="guardar" >Pagar Ya <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>

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

  route_agregar="{{url('/')}}/administrativo/pagos/agregarpago";
  route_principal="{{url('/')}}/administrativo/pagos"; 
  route_factura="{{url('/')}}/administrativo/pagos/factura/";
  route_eliminar="{{url('/')}}/administrativo/pagos/eliminarpago";
  route_cancelar = "{{url('/')}}/administrativo/pagos/cancelargestion";
  route_imprimir="{{url('/')}}/administrativo/factura/";
  //route_mercadopago="{{url('/')}}/administrativo/pagos/facturamercadopago/";

  function formatmoney(n) {
    return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
  }

  $( document ).ready(function() {

     acuerdo = "{{{ $acuerdo or 'Default' }}}";

     if(acuerdo == 1){

        $("#acuerdo").hide();
        
     }

     totalglobal = parseFloat("{{$total}}");
     totaldeuda =  parseFloat("{{$total}}");

     // $("#subtotal").text(formatmoney(subtotalglobal));
     // $("#impuestototal").text(formatmoney(impuestoglobal));
     $("#total").text(formatmoney(totalglobal));
     $("#total2").text(formatmoney(totalglobal));

  });
  
  $("#forma_pago_id").change(function(){

    $("#monto").val(totalglobal);

      if($(this).val() == 1){
        $('#banco').val('');
        $('#referencia').val('');
        $('#banco').prop('readonly', true);
        $('#referencia').prop('readonly', true);

      }
      else{
        $('#banco').prop('readonly', false);
        $('#referencia').prop('readonly', false);
      }

    });

  
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
          }else{
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

                // if(totalglobal == 0){

                  var id = "{{$alumno->id}}";
                  var route = route_factura + id;
                  var token = $('input:hidden[name=_token]').val();
                  var datos = $( "#gestionar_pago" ).serialize(); 
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
                          data: "&total="+totaldeuda+
                          "&id="+id,
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
                            // $("#gestionar_pago")[0].reset();
                            // var nTitle="Ups! ";
                            // var nMensaje=respuesta.mensaje;
                            // window.location = route_imprimir + respuesta.factura;
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
                // }
                // else{

                //   $("#error-linea_mensaje").html("Debes ingresar la cantidad solicitada");
                //   $('html,body').animate({
                //       scrollTop: $("#id-linea").offset().top-90,
                //   }, 1000);   

                // }
            });

        $("#add").click(function(){

          if($("#monto").val() <= totalglobal){

            $("#add").attr("disabled","disabled");
                $("#add").css({
                  "opacity": ("0.2")
            });

            var route = route_agregar;
                  var token = $('input:hidden[name=_token]').val();
                  var datos = $("#gestionar_pago").serialize(); 
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
                            $("#mujer").prop("checked", true);
                            var nTitle="Ups! ";
                            var nMensaje=respuesta.mensaje;

                            var forma_pago = respuesta.array[0].forma_pago;
                            var banco = respuesta.array[0].banco;
                            var referencia = respuesta.array[0].referencia;
                            var monto = respuesta.array[0].monto;

                            totalglobal = totalglobal - parseFloat(monto);

                            var rowId=respuesta.id;
                            var rowNode=t.row.add( [
                            ''+forma_pago+'',
                            ''+banco+'',
                            ''+referencia+'',
                            ''+formatmoney(parseFloat(monto))+'',
                            '<i class="zmdi zmdi-delete f-20 p-r-10"></i>'
                            ] ).draw(false).node();
                            $( rowNode )
                            .attr('id',rowId)
                            // .attr('data-precio',precio_neto)
                            .addClass('seleccion');
                            // impuestotmp = parseFloat(monto) * (porcentaje_impuesto / 100);
                            // subtotaltmp = parseFloat(monto) - impuestotmp;
                            // subtotalglobal = subtotalglobal - subtotaltmp;
                            // impuestoglobal = impuestoglobal - impuestotmp;
                            // // subtotalglobal = subtotalglobal - parseFloat(monto);
                            // // impuesto = subtotalglobal * (porcentaje_impuesto / 100)
                            // total = subtotalglobal + impuestoglobal;

                            // if(impuestoglobal < 0){
                            //   subtotalglobal
                            //   subtotalglobal = subtotalglobal + impuestoglobal;
                            //   impuestoglobal = 0;
                            // }

                            // // console.log(subtotalglobal);
                            // $("#subtotal").text(formatmoney(subtotalglobal));
                            // $("#impuestototal").text(formatmoney(impuestoglobal));
                            $('#forma_pago_id').val('');
                            $('#forma_pago_id').selectpicker('deselectAll');
                            $('#forma_pago_id').selectpicker('render');
                            $('#forma_pago_id').selectpicker('refresh');
                            $('#monto').val('');
                            $('#banco').val('');
                            $('#referencia').val('');
                            $("#total").text(formatmoney(totalglobal));

                            // if(total <= 0){
                            //   $("#subtotal").text(formatmoney(0));
                            //   $("#impuestototal").text(formatmoney(0));
                            //   $("#total").text(formatmoney(0));
                            // }

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
                }
                else{

                  $("#error-monto_mensaje").html("El monto no puede ser mayor a la deuda");
                  
                  $('html,body').animate({
                      scrollTop: $("#id-monto").offset().top-90,
                  }, 1000);   
                }
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

                                  totalglobal = totalglobal + parseFloat(data.monto);

                                  $("#total").text(formatmoney(totalglobal));
                                  // console.log(subtotalglobal);
                                  // totalfinal = subtotalglobal + impuestoglobal;

                                  // subtotalglobal = subtotalglobal + parseFloat(data.monto);
                                  // impuesto = subtotalglobal * (porcentaje_impuesto / 100)
                                  // total = subtotalglobal + impuesto;
                                   
                                  // $("#subtotal").text(subtotalglobal.toFixed(2));
                                  // $("#impuestototal").text(impuesto.toFixed(2));
                                  // $("#total").text(total.toFixed(2));
                                                   
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
        var campo = ["forma_pago_id", "monto"];
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

                    subtotalglobal = subtotalcancelar;
                    totalfinal = subtotalglobal + impuestoglobal;

                    $("#subtotal").text(formatmoney(subtotalglobal));
                    $("#total").text(formatmoney(totalfinal));

                    $("#gestionar_pago")[0].reset();
                    $('#forma_pago_id').selectpicker('render');
                    limpiarMensaje();

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
        scrollTop: $("#id-generar").offset().top-90,
        }, 1000);
      });

      //RETURN DE MERCADOPAGO
      /*function respuesta_mercadopago(json) {

          var nFrom = $(this).attr('data-from');
          var nAlign = $(this).attr('data-align');
          var nIcons = $(this).attr('data-icon');
          var nAnimIn = "animated flipInY";
          var nAnimOut = "animated flipOutY";                       

          var response = JSON.stringify(json);
          //alert(json);
          if (json.collection_status=='approved'){
              //$("#test").html('Pago acreditado');
              //$("#test").addClass('alert alert-success')
              var nTitle = 'Pago acreditado!';
              var nMensaje = ' Hemos recibido su pago satisfactoriamente, gracias';
              var nType = 'success';
          } else if(json.collection_status=='pending'){
              //$("#test").html('El usuario no completó el pago');
              //$("#test").addClass('alert alert-warning')
              var nTitle = 'Oops';
              var nMensaje = ' El usuario no completó el pago';
              var nType = 'warning';              
          } else if(json.collection_status=='in_process'){    
              //$("#test").html('El pago está siendo revisado');
              //$("#test").addClass('alert alert-info')
              var nTitle = 'Pago en Proceso';
              var nMensaje = ' El pago está siendo revisado';
              var nType = 'info';
          } else if(json.collection_status=='rejected'){
              //$("#test").html('El pago fué rechazado, el usuario puede intentar nuevamente el pago');
              //$("#test").addClass('alert alert-danger')
              var nTitle = 'Oops';
              var nMensaje = ' El pago fué rechazado, el usuario puede intentar nuevamente el pago';
              var nType = 'warning';              
          } else if(json.collection_status==null){
              var nTitle = 'Proceso Imcompleto!';
              var nMensaje = ' El usuario no completó el proceso de pago, no se ha generado ningún pago';
              var nType = 'warning';
              
          }
          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
          procesar_mercadopago(json);
      }*/

      /*function procesar_mercadopago(response){

                  var id = "{{--$alumno->id--}}";
                  var numero_factura = "{{--$numero_factura--}}";
                  var route = route_mercadopago;
                  var token = $('input:hidden[name=_token]').val();
                  //var datos = $( "#gestionar_pago" ).serialize(); 
                  //$("#guardar").attr("disabled","disabled");
                  //procesando();
                  //$("#guardar").css({
                  //  "opacity": ("0.2")
                  //});
                  //$(".cancelar").attr("disabled","disabled");
                  //$(".procesando").removeClass('hidden');
                  //$(".procesando").addClass('show');         
                  //limpiarMensaje();
                  $.ajax({
                      url: route,
                          headers: {'X-CSRF-TOKEN': token},
                          type: 'POST',
                          dataType: 'json',
                          //data: "&json="+response+"&alumno="+id,
                          data: {
                              json: response,
                              alumno: id,
                              numero_factura : numero_factura
                          },
                      success:function(respuesta){
                          //alert(respuesta);
                        /*setTimeout(function(){ 
                          var nFrom = $(this).attr('data-from');
                          var nAlign = $(this).attr('data-align');
                          var nIcons = $(this).attr('data-icon');
                          var nAnimIn = "animated flipInY";
                          var nAnimOut = "animated flipOutY"; 
                          if(respuesta.status=="OK"){

                            //window.location = route_principal;
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
                          
                        }, 1000);*/
                      // },
                      /*error:function(msj){
                        /*setTimeout(function(){ 
                        //   if (typeof msj.responseJSON === "undefined") {
                        //   window.location = "{{--url('/')--}}/error";
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
                        }, 1000);*/
                      /*}
                  });


      }*/

</script> 
@stop

