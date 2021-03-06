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
                        <a class="btn-blanco m-r-10 f-16" href="/inicio" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Inicio</a>
                        
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-center">

                        <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a icon_a-punto-de-venta f-25"></i> Sección Administrativa</p>
                        <hr class="linea-morada">
                                                              
                        </div>

                        <div class="col-sm-5">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="pendientes" value="pendientes" type="radio">
                                        <i class="input-helper"></i>  
                                        Pendientes por Pagar <i id="pendientes2" name="pendientes2" class="zmdi zmdi-forward zmdi-hc-fw c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="pagadas" value="pagadas" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Balance <i id="pagadas2" name="pagadas2" class="zmdi zmdi-money-box zmdi-hc-fw f-20"></i>
                                    </label>
                                    </div>
                                    
                                 </div>
                                </div> 

                                 <div class="clearfix"></div>
                                
                                <div class="col-md-12">
                                <span id="monto" class ="f-700 f-16 opaco-0-8">Pendiente por pagar : {{ number_format($total, 2) }} 
                                @if($fecha_vencimiento)
                                    y la siguente fecha de pago es el {{$fecha_vencimiento}}

                                @endif

                                </span>
                                </div>
                                <br><br>
                                <!-- <div class="clearfix"></div> -->

                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="factura" data-order="asc">&nbsp;&nbsp;#&nbsp;&nbsp;</th>
                                    <th class="text-center" data-column-id="concepto">Concepto</th>
                                    <th class="text-center" data-column-id="fecha" id="fecha">Fecha</th>
                                    <th class="text-center" data-column-id="total">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                                           
                            </tbody>
                        </table>
                         </div>
                        </div>
                        <div class="card-body p-b-20">
                            <div class="row">
                              <div class="container">
                                
                              </div>
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
            route_gestion="{{url('/')}}/administrativo/pagar/";
            route_eliminar="{{url('/')}}/administrativo/pagos/eliminardeuda/";

        tipo = 'proformas';

        function formatmoney(n) {
            return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
        } 

        $(document).ready(function(){

        $("#pendientes").prop("checked", true);

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 50, 
        // paging:false, 
        order: [[0, 'desc']],
        fnDrawCallback: function() {
        if ("{{count($facturas)}}" < 50) {
              $('.dataTables_paginate').hide();
              $('#tablelistar_length').hide();
          }

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
    

            if($('.chosen')[0]) {
                $('.chosen').chosen({
                    width: '100%',
                    allow_single_deselect: true
                });
            }
            if ($('.date-time-picker')[0]) {
               $('.date-time-picker').datetimepicker();
            }

            if ($('.date-picker')[0]) {
                $('.date-picker').datetimepicker({
                    format: 'DD/MM/YYYY'
                });
            }

                rechargeProforma();
            });

        function previa(t){

            if(tipo =='pagadas'){

                var row = $(t).closest('tr').attr('id');
                var route =route_detalle+"/"+row;
                window.open(route, '_blank');;
            }

        }

         $("i[name=operacion").click(function(){
            var route =route_operacion+"/"+this.id;
            window.open(route, '_blank');;
         });

         function clear(){

            t.clear().draw();
            // t.destroy();
         }

         $('input[name="tipo"]').on('change', function(){
            clear();
            if ($(this).val()=='pagadas') {
                  tipo = 'pagadas';
                  rechargeFactura();
            } else  {
                  tipo= 'proformas';
                  rechargeProforma();
            }
         });

        function rechargeFactura(){
            var factura = <?php echo json_encode($facturas);?>;
            $('#monto').css('opacity', '0');

            document.getElementById('fecha').innerHTML = 'Fecha'; 

            $.each(factura, function (index, array) {

                var rowNode=t.row.add( [
                ''+pad(array.factura, 10)+'',
                ''+array.concepto+'',
                ''+array.fecha+'',
                ''+formatmoney(parseFloat(array.total))+''
                ] ).draw(false).node();
                $( rowNode )
                    .attr('id',array.id)
                    .addClass('seleccion');
            });
        }

        function rechargeProforma(){
            var proforma = <?php echo json_encode($proforma);?>;
            $('#monto').css('opacity', '1');

            document.getElementById('fecha').innerHTML = 'Fecha de Vencimiento'; 

            $.each(proforma, function (index, array) {
                var rowNode=t.row.add( [
                ''+array.id+'',
                ''+array.cantidad+ ' ' +array.concepto+'',
                ''+array.fecha_vencimiento+'',
                ''+formatmoney(parseFloat(array.total))+''
                ] ).draw(false).node();
                $( rowNode )
                    .attr('id',array.id)
                    .addClass('seleccion');
            });
        }

        $("#pagadas").click(function(){
            $( "#pendientes2" ).removeClass( "c-verde" );
            $( "#pagadas2" ).addClass( "c-verde" );
        });

        $("#pendientes").click(function(){
            $( "#pagadas2" ).removeClass( "c-verde" );
            $( "#pendientes2" ).addClass( "c-verde" );
        });

        function pad (str, max) {
          str = str.toString();
          return str.length < max ? pad("0" + str, max) : str;
        }

        </script>

@stop