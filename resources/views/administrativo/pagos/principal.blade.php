@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
@stop
@section('content')

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="/administrativo/pagos/generar" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Pagos</a>
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
                        <div class="card-header text-center">

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-file-text zmdi-hc-fw p-r-5 f-25"></i> Sección de Facturas</p>
                            <hr class="linea-morada">
                                                              
                        </div>

                        <div class="col-sm-12">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="pagadas" value="pagadas" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Pagadas <i id="pagadas2" name="pagadas2" class="zmdi zmdi-money-box zmdi-hc-fw c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="pendientes" value="pendientes" type="radio">
                                        <i class="input-helper"></i>  
                                        Pendientes por Pagar <i id="pendientes2" name="pendientes2" class="zmdi zmdi-forward zmdi-hc-fw f-20"></i>
                                    </label>
                                    </div>
                                    
                                 </div>
                                </div> 

                                <div class="clearfix"></div>

                                <div class="col-sm-12" id="checkbox_tipo" style="display:none">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">

                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo_proforma" id="todos" value="todos" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Todos <i id="todos2" name="todos2" class="zmdi zmdi-money-box zmdi-hc-fw f-20"></i>
                                    </label>


                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo_proforma" id="inscripcion" value="inscripcion" type="radio" >
                                        <i class="input-helper"></i>  
                                        Inscripción <i id="inscripcion2" name="inscripcion2" class="zmdi zmdi-money-box zmdi-hc-fw c-verde f-20"></i>
                                    </label>

                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo_proforma" id="mensualidad" value="mensualidad" type="radio" >
                                        <i class="input-helper"></i>  
                                        Mensualidad <i id="mensualidad2" name="mensualidad2" class="zmdi zmdi-money-box zmdi-hc-fw f-20"></i>
                                    </label>

                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo_proforma" id="acuerdo" value="acuerdo" type="radio" >
                                        <i class="input-helper"></i>  
                                        Acuerdo de Pago <i id="acuerdo2" name="acuerdo2" class="zmdi zmdi-money-box zmdi-hc-fw f-20"></i>
                                    </label>

                                    </div>
                                    
                                 </div>
                                </div> 

                                <div class="clearfix"></div>
                                
                        <div class="col-md-12">
                            <span id="monto" class ="f-700 f-16 opaco-0-8" style="display:none">Pendiente por cobrar : <span id="total">{{ number_format($total, 2) }}</span></span>
                        
                        </div>
                        <br><br>
                                <!-- <div class="clearfix"></div> -->

                        <div class="table-responsive row">
                           <div class="col-md-12">
                                <table class="table table-striped table-bordered text-center " id="tablelistar" >
                                    <thead>
                                        <tr>
                                            <th id="factura" class="text-center" data-column-id="factura" data-order="asc">Factura</th>
                                            <th class="text-center" data-column-id="cliente">Cliente</th>
                                            <th class="text-center" data-column-id="concepto">Concepto</th>
                                            <th class="text-center" data-column-id="fecha" id="fecha">Fecha de Vencimiento</th>
                                            <th class="text-center" data-column-id="total">Total</th>
                                            <th class="text-center" data-column-id="operacion">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($facturas as $factura)
                                            <?php $id = $factura['id']; ?>

                                            <tr id="{{$id}}" class="seleccion">
                                                <td class="text-center previa">{{str_pad($factura['factura'], 10, "0", STR_PAD_LEFT)}}</td>
                                                <td class="text-center previa">{{$factura['nombre']}}</td>
                                                <td class="text-center previa">
                                                {{ str_limit($factura['concepto'], $limit = 50, $end = '...') }}</td>
                                                <td class="text-center previa">{{$factura['fecha']}}</td>
                                                <td class="text-center previa">{{ number_format($factura['total'], 2, '.' , '.') }}</td>
                                                <td class="text-center previa"><i data-toggle="modal" name="correo" class="zmdi zmdi-email f-20 p-r-10"></i></td>
                                              
                                            </tr>

                                        @endforeach
                                                               
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
@stop

@section('js') 
            
        <script type="text/javascript">
            route_detalle="{{url('/')}}/administrativo/factura";
            route_enviar="{{url('/')}}/administrativo/factura/enviar/";
            route_gestion="{{url('/')}}/administrativo/pagos/gestion/";
            route_eliminar="{{url('/')}}/administrativo/pagos/eliminardeuda/";

        tipo = 'pagadas';

        

        var proforma = <?php echo json_encode($proforma);?>;
        var factura = <?php echo json_encode($facturas);?>;

        function formatmoney(n) {
            return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
        }

        t=$('#tablelistar').DataTable({
            processing: true,
            serverSide: false,
            pageLength: 25, 
            order: [[0, 'desc']],
            fnDrawCallback: function() {
                $('.dataTables_paginate').show();
              /*if ("{{count($proforma)}}" < 25) {
                  $('.dataTables_paginate').hide();
                  $('#tablelistar_length').hide();
              }else{
                  $('.dataTables_paginate').show();
              }*/
            },
            fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
              $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
              $('td:eq(0),td:eq(1),td:eq(2),td:eq(3)', nRow).attr( "onclick","previa(this)" );
            },
            language: {
                            processing:     "Procesando ...",
                            search:         '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>',
                            searchPlaceholder: "BUSCAR",
                            lengthMenu:     " ",
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

        $(document).ready(function(){

           $("#pagadas").prop("checked", true);
            
            document.getElementById('fecha').innerHTML = 'Fecha';
            document.getElementById('factura').innerHTML = '#'; 
        });

        function previa(t){

            if(tipo =='pagadas'){

                var row = $(t).closest('tr').attr('id');
                var route =route_detalle+"/"+row;
                window.location=route;
            }

        }

         $('input[name="tipo"]').on('change', function(){
            procesando();
            t.clear().draw();
            if ($(this).val()=='pagadas') {
                  tipo = 'pagadas';
                  rechargeFactura();
            } else  {
                  tipo= 'proformas';
                  rechargeProforma();
            }
         });

         $('input[name="tipo_proforma"]').on('change', function(){
            procesando();
            t.clear().draw();
            if ($(this).val()=='inscripcion') {
                  tipo_proforma = 'inscripcion';
                  rechargeInscripcion();
            }else if ($(this).val()=='mensualidad') {
                  tipo_proforma = 'mensualidad';
                  rechargeMensualidad();
            }else if ($(this).val()=='acuerdo') {
                  tipo_proforma = 'acuerdo';
                  rechargeAcuerdo();
            }else {
                  tipo_proforma = 'todos';
                  rechargeProforma();
            } 
         });

        function rechargeFactura(){

            setTimeout(function(){
                $('#monto').hide();

                $('#checkbox_tipo').hide();

                document.getElementById('fecha').innerHTML = 'Fecha'; 

                $.each(factura, function (index, array) {
                    concepto = array.concepto;
                    if(concepto.length > 50)
                    {
                        concepto = concepto.substr(0, 50) + "...";
                    }
                    var rowNode=t.row.add( [
                    ''+pad(array.factura, 10)+'',
                    ''+array.nombre+'',
                    ''+concepto+'',
                    ''+array.fecha+'',
                    ''+formatmoney(parseFloat(array.total))+'',
                    '<i data-toggle="modal" name="correo" class="zmdi zmdi-email f-20 p-r-10"></i>'
                    ] ).draw(false).node();
                    $( rowNode )
                        .attr('id',array.id)
                        .addClass('seleccion');
                });

                finprocesado();

             }, 1000);

            
        }

        function rechargeProforma(){

            setTimeout(function(){
            
                $('#monto').show();

                document.getElementById('fecha').innerHTML = 'Fecha de Vencimiento';

                var total = 0 

                $.each(proforma, function (index, array) {

                    total = total + parseFloat(array.total)
                    concepto = array.concepto;
                    var rowNode=t.row.add( [
                    ''+array.id+'',
                    ''+array.nombre+ ' '+array.apellido+'',
                    ''+array.cantidad+ ' ' +concepto+'',
                    ''+array.fecha_vencimiento+'',
                    ''+formatmoney(parseFloat(array.total))+'',
                    '<i data-toggle="modal" name="pagar" class="icon_a-pagar f-20 p-r-10 pointer"></i> <i data-toggle="modal" name="eliminar" class="zmdi zmdi-delete f-20 p-r-10 pointer"></i>'
                    ] ).draw(false).node();
                    $( rowNode )
                        .attr('id',array.id)
                        .addClass('text-center');
                });

                $('#total').text(formatmoney(total))

                $('#todos').click();
                $('#checkbox_tipo').show();

                finprocesado();

            }, 1000);

        }

        function rechargeInscripcion(){

            setTimeout(function(){

                var tmp = $.grep(proforma, function(e){ return e.tipo == 3; });

                var total = 0;

                $.each(tmp, function (index, array) {

                    total = total + parseFloat(array.total)

                    concepto = array.concepto;
                    var rowNode=t.row.add( [
                    ''+array.id+'',
                    ''+array.nombre+ ' '+array.apellido+'',
                    ''+array.cantidad+ ' ' +concepto+'',
                    ''+array.fecha_vencimiento+'',
                    ''+formatmoney(parseFloat(array.total))+'',
                    '<i data-toggle="modal" name="pagar" class="icon_a-pagar f-20 p-r-10 pointer"></i> <i data-toggle="modal" name="eliminar" class="zmdi zmdi-delete f-20 p-r-10 pointer"></i>'
                    ] ).draw(false).node();
                    $( rowNode )
                        .attr('id',array.id)
                        .addClass('text-center');
                });

                $('#total').text(formatmoney(total))

                finprocesado();

            }, 1000);

        }

        function rechargeMensualidad(){

            setTimeout(function(){

                var total = 0

                var tmp = $.grep(proforma, function(e){ return e.tipo == 4; });

                $.each(tmp, function (index, array) {

                    total = total + parseFloat(array.total)

                    concepto = array.concepto;
                    var rowNode=t.row.add( [
                    ''+array.id+'',
                    ''+array.nombre+ ' '+array.apellido+'',
                    ''+array.cantidad+ ' ' +concepto+'',
                    ''+array.fecha_vencimiento+'',
                    ''+formatmoney(parseFloat(array.total))+'',
                    '<i data-toggle="modal" name="pagar" class="icon_a-pagar f-20 p-r-10 pointer"></i> <i data-toggle="modal" name="eliminar" class="zmdi zmdi-delete f-20 p-r-10 pointer"></i>'
                    ] ).draw(false).node();
                    $( rowNode )
                        .attr('id',array.id)
                        .addClass('text-center');
                });

                $('#total').text(formatmoney(total))

                finprocesado();

            }, 1000);

        }

        function rechargeAcuerdo(){

            setTimeout(function(){

                var total = 0
                var tmp = $.grep(proforma, function(e){ return e.tipo == 6; });

                $.each(tmp, function (index, array) {

                    total = total + parseFloat(array.total)

                    concepto = array.concepto;
                    var rowNode=t.row.add( [
                    ''+array.id+'',
                    ''+array.nombre+ ' '+array.apellido+'',
                    ''+array.cantidad+ ' ' +concepto+'',
                    ''+array.fecha_vencimiento+'',
                    ''+formatmoney(parseFloat(array.total))+'',
                    '<i data-toggle="modal" name="pagar" class="icon_a-pagar f-20 p-r-10 pointer"></i> <i data-toggle="modal" name="eliminar" class="zmdi zmdi-delete f-20 p-r-10 pointer"></i>'
                    ] ).draw(false).node();
                    $( rowNode )
                        .attr('id',array.id)
                        .addClass('text-center');
                });

                $('#total').text(formatmoney(total))

                finprocesado();

            }, 1000);

        }

        $("#pagadas").click(function(){
            $( "#pendientes2" ).removeClass( "c-verde" );
            $( "#pagadas2" ).addClass( "c-verde" );
        });

        $("#pendientes").click(function(){
            $( "#pagadas2" ).removeClass( "c-verde" );
            $( "#pendientes2" ).addClass( "c-verde" );
        });

        $("#inscripcion").click(function(){
            $( "#todos2" ).removeClass( "c-verde" );
            $( "#mensualidad2" ).removeClass( "c-verde" );
            $( "#acuerdo2" ).removeClass( "c-verde" );
            $( "#inscripcion2" ).addClass( "c-verde" );
        });

        $("#mensualidad").click(function(){
            $( "#todos2" ).removeClass( "c-verde" );
            $( "#mensualidad2" ).addClass( "c-verde" );
            $( "#acuerdo2" ).removeClass( "c-verde" );
            $( "#inscripcion2" ).removeClass( "c-verde" );
        });

        $("#acuerdo").click(function(){
            $( "#todos2" ).removeClass( "c-verde" );
            $( "#mensualidad2" ).removeClass( "c-verde" );
            $( "#acuerdo2" ).addClass( "c-verde" );
            $( "#inscripcion2" ).removeClass( "c-verde" );
        });

        $("#todos").click(function(){
            $( "#todos2" ).addClass( "c-verde" );
            $( "#mensualidad2" ).removeClass( "c-verde" );
            $( "#acuerdo2" ).removeClass( "c-verde" );
            $( "#inscripcion2" ).removeClass( "c-verde" );
        });

        $('#tablelistar tbody').on( 'click', 'i.icon_a-pagar', function () {
            var id = $(this).closest('tr').attr('id');
            window.location = route_gestion + id;
        });

        $('#tablelistar tbody').on( 'click', 'i.zmdi-email', function () {

                var id = $(this).closest('tr').attr('id');
                element = this;

                swal({   
                    title: "Desea re-enviar la factura por correo electrónico?",   
                    text: "Confirmar re-envio!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Re-Enviar!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: false 
                }, function(isConfirm){   
          if (isConfirm) {
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nType = 'success';
            var nAnimIn = $(this).attr('data-animation-in');
            var nAnimOut = $(this).attr('data-animation-out')
                        swal("Exito!","El correo ha sido enviado!","success");
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
                        enviar(id, element);
          }
                });
            });
      
        function enviar(id, element){
         var route = route_enviar + id;
         var token = "{{ csrf_token() }}";
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
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

                          // t.row( $(element).parents('tr') )
                          //   .remove()
                          //   .draw();
                        
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

      $('#tablelistar tbody').on( 'click', 'i.zmdi-delete', function () {

                var id = $(this).closest('tr').attr('id');
                // var temp = row.split('_');
                // var id = temp[1];
                element = this;

                swal({   
                    title: "Desea eliminar la proforma?",   
                    text: "Confirmar eliminación!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Eliminar!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: false 
                }, function(isConfirm){   
          if (isConfirm) {
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nType = 'success';
            var nAnimIn = $(this).attr('data-animation-in');
            var nAnimOut = $(this).attr('data-animation-out')
                        swal("Exito!","La campaña ha sido eliminada!","success");
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
                        eliminar(id, element);
          }
                });
            });
      
        function eliminar(id, element){
         var route = route_eliminar + id;
         var token = "{{ csrf_token() }}";
                
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

                          t.row( $(element).parents('tr') )
                            .remove()
                            .draw();
                        
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

      function pad (str, max) {
      str = str.toString();
      return str.length < max ? pad("0" + str, max) : str;
    }

        </script>
@stop