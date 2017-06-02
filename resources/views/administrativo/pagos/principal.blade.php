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
                                        Cuentas por Cobrar <i id="pendientes2" name="pendientes2" class="zmdi zmdi-forward zmdi-hc-fw f-20"></i>
                                    </label>
                                    </div>
                                    
                                 </div>
                                </div> 

                                <div class="clearfix"></div>

                                <div class="col-sm-12" id="checkbox_tipo" style="display:none">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">

                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo_proforma" id="todos" type="radio" value="0">
                                        <i class="input-helper"></i>  
                                        Todos <i id="todos2" name="todos2" class="zmdi zmdi-money-box zmdi-hc-fw f-20"></i>
                                    </label>


                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo_proforma" id="inscripcion" type="radio" value="3" >
                                        <i class="input-helper"></i>  
                                        Inscripción <i id="inscripcion2" name="inscripcion2" class="zmdi zmdi-money-box zmdi-hc-fw c-verde f-20"></i>
                                    </label>

                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo_proforma" id="mensualidad" type="radio" value="4" >
                                        <i class="input-helper"></i>  
                                        Mensualidad <i id="mensualidad2" name="mensualidad2" class="zmdi zmdi-money-box zmdi-hc-fw f-20"></i>
                                    </label>

                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo_proforma" id="acuerdo" type="radio" value="6" >
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
                                            <th class="text-center" data-column-id="cliente">Tipo de Pago</th>
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
                                                <td class="text-center previa">{{str_pad($factura['numero_factura'], 10, "0", STR_PAD_LEFT)}}</td>
                                                <td class="text-center previa">{{$factura['nombre']}}</td>
                                                <td class="text-center previa">{{$factura['tipo_pago']}}</td>
                                                <td class="text-center previa">{{ str_limit($factura['concepto'], $limit = 50, $end = '...') }}
                                                </td>
                                                <td class="text-center previa">{{$factura['fecha']}}</td>
                                                <td class="text-center previa">{{ number_format($factura['total'], 2, '.' , '.') }}</td>
                                                <td class="text-center previa">
                                                    <i name="correo" class="zmdi zmdi-email f-20 p-r-10"></i>
                                                    <i class="zmdi zmdi-delete f-20 p-r-10 pointer eliminar_factura"></i>
                                                </td>
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
        route_eliminar_factura="{{url('/')}}/administrativo/pagos/eliminar-factura/";

        var proformas = <?php echo json_encode($proformas);?>;
        var facturas = <?php echo json_encode($facturas);?>;

        function formatmoney(n) {
            return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
        }

        t=$('#tablelistar').DataTable({
            processing: true,
            serverSide: false,
            pageLength: 25, 
            order: [[0, 'desc']],
            fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
              $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)', nRow).addClass( "text-center" );
              $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)', nRow).attr( "onclick","previa(this)" );
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

            if($('input[name=tipo]').val() == 'pagadas'){

                var row = $(t).closest('tr').attr('id');
                var route =route_detalle+"/"+row;
                window.location=route;
            }

        }

         $('input[name="tipo"]').on('change', function(){

            if ($(this).val()=='pagadas') {
                  rechargeFactura();
            } else  {
                 $('#todos').click()
            }
         });

         $('input[name="tipo_proforma"]').on('change', function(){

            t.clear().draw();
            procesando();

            tipo = $(this).val()
            
            setTimeout(function(){
            
                var total = 0 

                $.each(proformas, function (index, array) {

                    if(array.tipo == tipo || tipo == 0){

                        nombre = array.nombre

                        if(nombre.length > 50)
                        {
                            nombre = nombre.substr(0, 50) + "...";
                        }

                        total = total + parseFloat(array.importe_neto)
                        var rowNode=t.row.add( [
                        ''+array.id+'',
                        ''+array.usuario+'',
                        '',
                        ''+nombre+'',
                        ''+array.fecha_vencimiento+'',
                        ''+formatmoney(parseFloat(array.importe_neto))+'',
                        '<i name="pagar" class="icon_a-pagar f-20 p-r-10 pointer"></i> <i class="eliminar zmdi zmdi-delete f-20 p-r-10 pointer"></i>'
                        ] ).draw(false).node();
                        $( rowNode )
                            .attr('id',array.id)
                            .addClass('text-center');
                    }
                });
            

                $('#total').text(formatmoney(total))
                $('#checkbox_tipo').show();
                $('#monto').show();
                t.column(2).visible(false);
                document.getElementById('fecha').innerHTML = 'Fecha de Vencimiento';

                finprocesado();
            }, 1000);
         });

        function rechargeFactura(){

            t.clear().draw();
            procesando();

            setTimeout(function(){

                $('#monto').hide();
                $('#checkbox_tipo').hide();

                t.column(2).visible(true);

                document.getElementById('fecha').innerHTML = 'Fecha'; 

                $.each(facturas, function (index, array) {
                    concepto = array.concepto;
                    if(concepto.length > 50)
                    {
                        concepto = concepto.substr(0, 50) + "...";
                    }
                    var rowNode=t.row.add( [
                    ''+pad(array.numero_factura, 10)+'',
                    ''+array.nombre+'',
                    ''+array.tipo_pago+'',
                    ''+concepto+'',
                    ''+array.fecha+'',
                    ''+formatmoney(parseFloat(array.total))+'',
                    '<i name="correo" class="zmdi zmdi-email f-20 p-r-10"></i> <i class="eliminar_factura zmdi zmdi-delete f-20 p-r-10 pointer"></i>'
                    ] ).draw(false).node();
                    $( rowNode )
                        .attr('id',array.id)
                        .addClass('seleccion');
                });

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
                    closeOnConfirm: true 
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

    $('#tablelistar tbody').on( 'click', 'i.eliminar_factura', function () {

        var id = $(this).closest('tr').attr('id');
        element = this;

        swal({   
            title: "Desea eliminar la factura?",   
            text: "Confirmar eliminación!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Eliminar!",  
            cancelButtonText: "Cancelar",         
            closeOnConfirm: true 
        }, function(isConfirm){   
            if (isConfirm) {
                var nFrom = $(this).attr('data-from');
                var nAlign = $(this).attr('data-align');
                var nIcons = $(this).attr('data-icon');
                var nType = 'success';
                var nAnimIn = $(this).attr('data-animation-in');
                var nAnimOut = $(this).attr('data-animation-out')

                eliminar_factura(id, element);
            }
        });
    });
      
    function eliminar_factura(id, element){
        var route = route_eliminar_factura + id;
        var token = "{{ csrf_token() }}";
        procesando();
                
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
                  finprocesado();
                  var nType = 'success';
                  var nTitle="Ups! ";
                  var nMensaje=respuesta.mensaje;

                  swal("Exito!","La factura ha sido eliminada!","success");

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

      $('#tablelistar tbody').on( 'click', 'i.eliminar', function () {

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
                    closeOnConfirm: true 
                }, function(isConfirm){   
          if (isConfirm) {
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nType = 'success';
            var nAnimIn = $(this).attr('data-animation-in');
            var nAnimOut = $(this).attr('data-animation-out')
                        swal("Exito!","La proforma ha sido eliminada!","success");
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