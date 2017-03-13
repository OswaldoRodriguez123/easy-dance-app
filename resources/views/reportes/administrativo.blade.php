@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>

<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/moment.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

<script src="{{url('/')}}/assets/vendors/bower_components/flot/jquery.flot.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot/jquery.flot.resize.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot/jquery.flot.pie.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot-orderBars/js/jquery.flot.orderBars.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot.curvedlines/curvedLines.js"></script>                         
<script src="{{url('/')}}/assets/vendors/bower_components/flot-orderBars/js/jquery.flot.orderBars.js"></script>

<script src="{{url('/')}}/assets/js/flot-charts/pie-chart.js"></script>
@stop
@section('content')

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menu Principal</a>
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-reservaciones f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                    </div> 
                    
                    <div class="card">

                        <div class="card-header">
                            <ul class="tab-nav tn-justified" role="tablist">
                                <li class="waves-effect"><a href="{{url('/')}}/administrativo/pagos/generar" aria-controls="home11" onclick="procesando()"><div class="icon_a icon_a-pagar f-30"></div><p style=" margin-bottom: -2px;">Pagos</p></a></li>
                                <li class="waves-effect"><a href="{{url('/')}}/administrativo/acuerdos/generar" aria-controls="home11" onclick="procesando()"><div class="icon_a icon_a-acuerdo-de-pago f-30"></div><p style=" margin-bottom: -2px;">Acuerdos</p></a></li>
                                <li class="waves-effect"><a href="{{url('/')}}/administrativo/presupuestos/generar" aria-controls="home11" onclick="procesando()"><div class="icon_a icon_a-presupuesto f-30"></div><p style=" margin-bottom: -2px;">Presupuestos</p></a></li>
                                <li class="waves-effect active"><a href="{{url('/')}}/reportes/administrativo" aria-controls="home11" onclick="procesando()"><div class="icon_d icon_d-reporte f-30"></div><p style=" margin-bottom: -2px;">Reportes</p></a></li>
                            </ul>
                        </div> 

                        <div class="clearfix"></div>

                        <div class="card-header text-right">
                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_d icon_d-reporte f-25"></i> Informe Administrativo</p>
                            <hr class="linea-morada">
                        </div>

                         <div class="col-sm-12">
                            <form name="formFiltro" id="formFiltro">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" id="boolean_fecha" name="boolean_fecha" value="0">
                                <div class="col-md-4">
                                    <label>Clase Grupal</label>

                                    <div class="fg-line">
                                        <div class="select">
                                            <select class="selectpicker" data-live-search="true" name="clase_grupal_id" id="clase_grupal_id">
                                                <option value="0">Todas</option>
                                                @foreach ($clases_grupales as $clase)
                                                    <?php $id = $clase['id']; ?>
                                                    <option value="{{$id}}">                       
                                                        {{$clase['nombre']}} - {{$clase['dia']}} - 
                                                        {{$clase['hora_inicio']}}/ 
                                                        {{$clase['hora_final']}} -  {{$clase['instructor_nombre']}}
                                                        {{$clase['instructor_apellido']}}
                                                    </option>
                                                @endforeach 
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Servicios</label>

                                    <div class="fg-line">
                                        <div class="select">
                                            <select class="selectpicker" data-live-search="true" name="servicio_id" id="servicio_id">
                                                <option value="0">Todas</option>
                                                @foreach ($servicios as $servicio)
                                                    <option value="{{$servicio->id}}-{{$servicio->tipo}}">
                                                        {{$servicio->nombre}}
                                                    </option>
                                                @endforeach 
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Tipo</label>

                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="tipo" id="tipo" data-live-search="true">
                                            <option value="1">Vencidas</option>
                                            <option value="2">Actuales</option>
                                        </select>
                                    </div>
                                </div>

                       
                                <div class="clearfix m-b-10"></div> 

                                <button type="button" class="btn btn-blanco m-r-10 f-10 guardar" id="guardar" >Filtrar</button>

                                <div class ="clearfix m-b-10"></div>
                                <div class ="clearfix m-b-10"></div>

                            </form>
                        </div>

                        <div class="clearfix"></div>
                        
                        <div class="table-responsive row">
                           <div class="col-md-12">
                                <table class="table table-striped table-bordered text-center " id="tablelistar" >
                                    <thead>
                                        <tr>
                                            <th class="text-center" data-column-id="factura" data-order="asc" id="factura">Factura</th>
                                            <th class="text-center" data-column-id="cliente">Cliente</th>
                                            <th class="text-center" data-column-id="concepto">Concepto</th>
                                            <th class="text-center" data-column-id="fecha" id="fecha">Fecha de Vencimiento</th>
                                            <th class="text-center" data-column-id="total">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                 
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="card-body p-b-20">
                            <div class="row">
                                <div class="container">
                                    <div class="clearfix p-b-15"></div>

                                    <div class="col-sm-12 text-right c-morado">

                                        <div class="col-sm-12">
                                            <span id = "totales" class="f-30">Total</span>

                                            <br><br>

                                            <p>
                                                <span class="f-15">Total</span>
                                                <span class="f-15" id = "total">0</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </div>  
                    </div>
                </div>
            </section>

            <button class="btn btn-float bgm-red m-btn" data-action="print"><i class="zmdi zmdi-print"></i></button>
@stop

@section('js') 
            
<script type="text/javascript">

    route_filtrar = "{{url('/')}}/reportes/administrativo";
    route_detalle="{{url('/')}}/administrativo/factura";

    var nFrom = $(this).attr('data-from');
    var nAlign = $(this).attr('data-align');
    var nIcons = $(this).attr('data-icon');
    var nType = 'danger';
    var nAnimIn = "animated flipInY";
    var nAnimOut = "animated flipOutY"; 

    $(document).ready(function(){

        document.getElementById('factura').innerHTML = '#'; 

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 50,
        order: [[0, 'desc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          // $('td:eq(0),td:eq(1),td:eq(2),td:eq(3)', nRow).attr( "onclick","previa(this)" );
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

        //DateRangePicker
        $('#personalizar').daterangepicker({
            "autoApply" : false,
            "opens": "left",
            "applyClass": "bgm-morado waves-effect",
            locale : {
                format: 'DD/MM/YYYY',
                applyLabel : 'Aplicar',
                cancelLabel : 'Cancelar',
                daysOfWeek : [
                    "Dom",
                    "Lun",
                    "Mar",
                    "Mie",
                    "Jue",
                    "Vie",
                    "Sab"
                ],

                monthNames: [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],        
            }
        });
    });


        $("#guardar").click(function(){
            var token = $('input:hidden[name=_token]').val();
            var datos = $( "#formFiltro" ).serialize();
            procesando();
            $.ajax({
                url: route_filtrar,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: datos,
                success:function(respuesta){

                    var nType = 'success';
                    var nTitle="Ups! ";
                    var nMensaje=respuesta.mensaje;

                    t.clear().draw();

                    $.each(respuesta.facturas, function (index, array) {
                        var rowNode=t.row.add( [
                        ''+array.id+'',
                        ''+array.cliente+'',
                        ''+array.nombre+'',
                        ''+array.fecha_vencimiento+'',
                        ''+formatmoney(parseFloat(array.importe_neto))+''
                        ] ).draw(false).node();
                        $( rowNode )
                            .attr('id',array.id)
                            .addClass('seleccion');
                    });


                    $('#total').text(formatmoney(parseFloat(respuesta.total)))

                    finprocesado();                       
                    notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                }
            });
        });

        function pad (str, max) {
          str = str.toString();
          return str.length < max ? pad("0" + str, max) : str;
        }

        function formatmoney(n) {
            return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
        } 

        function previa(t){

            var row = $(t).closest('tr').attr('id');
            var route =route_detalle+"/"+row;
            window.location=route;

        }


        </script>

@stop