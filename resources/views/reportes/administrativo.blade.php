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
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/reportes" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección de Reportes</a>
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-reservaciones f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                    </div> 
                    
                    <div class="card">

                        <div class="card-header text-right">
                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a icon_a-punto-de-venta f-25"></i> Informe Administrativo</p>
                            <hr class="linea-morada">
                        </div>

                         <div class="col-sm-12">
                            <form name="formFiltro" id="formFiltro">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" id="boolean_fecha" name="boolean_fecha" value="0">

                                <div class="col-md-4">
                                    <label>Tipo</label>

                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="tipo" id="tipo" data-live-search="true">
                                            <option value="2">Ingresos</option>
                                            <option value="3">Egresos</option>
                                            <option value="4">Cuentas por Cobrar</option>
                                            <option value="1">Todo</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Linea de Servicio</label>

                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="tipo_servicio" id="tipo_servicio" data-live-search="true">
                                            <option value="0">Todo</option>
                                            <option value="99">Academia Recepción</option>
                                            <option value="14">Fiestas y Eventos</option>
                                            <option value="5">Talleres</option>
                                            <option value="11">Campañas</option>
                                        </select>
                                    </div>
                                </div>

                                
                                 <div class="col-md-4">
                                    <label>Fecha</label>

                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="fecha" id="fecha">
                                            <option value="1">Hoy</option>
                                            <option value="2">Mes Actual</option>
                                            <option value="3">Mes Pasado</option>
                                        </select>
                                      </div>
                                </div>

                                <div class="clearfix m-b-20"></div> 


                                <div class="col-md-4">
                                    <label>Clase Grupal</label>

                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="clase_grupal_id" id="clase_grupal_id" disabled>
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

                                <div class="col-md-4">
                                    <label>Detalle</label>

                                    <!-- <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="tipo_id" id="tipo_id" multiple="" data-max-options="5" title="Todas"> 
                                        

                                            foreach ($linea_servicio as $servicio)
                                                <php 
                                                    $id = servicio['id']; 
                                                    $tipo = servicio['tipo'];
                                                >
                                                <option value="id-tipo">                       
                                                    servicio['nombre']
                                                </option>
                                            endforeach 
                                        </select>
                                    </div> -->

                                    <!-- <div class="dropdown">
                                        <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-primary" data-target="#">
                                            Dropdown <span class="caret"></span>
                                        </a>
                                        <ul id="dropdown_principal" class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                          
                                        </ul>
                                    </div> -->



                                    <div class="dropdown" id="dropdown_boton">
                                        <a id="detalle_boton" role="button" data-toggle="dropdown" class="btn btn-blanco">
                                            Todos <span class="caret"></span>
                                        </a>
                                        <ul id="dropdown_principal" class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                        </ul>
                                    </div>
             

                                </div>


                                <div class="col-sm-4">
                                    <div class="form-group fg-line">
                                        <label for="nombre">Personalizar</label>
                                        <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                            <div class="panel panel-collapse">
                                                <div class="panel-heading" role="tab" id="headingTwo">
                                                    <h4 class="panel-title">
                                                        <a id="personalizar" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                          <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                                        </a>
                                                    </h4>
                                                </div>

                                                <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                    <div class="panel-body">

                                                        <div class="clearfix m-b-20"></div>
                                                    

                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                                            <div class="fg-line">
                                                                    <input type="text" name = "fecha2" id="fecha2" class="form-control" placeholder="Personalizar">
                                                            </div>
                                                        </div>

            

                                                        
                                                    </div>

                                                    <div class="clearfix p-b-35"></div>
                                                    <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseTwo')" ></i></div>   

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                       
                                <div class="clearfix m-b-10"></div> 

                                <button type="button" class="btn btn-blanco m-r-10 f-10 guardar" id="guardar" >Filtrar</button>

                                <div class ="clearfix m-b-10"></div>
                                <div class ="clearfix m-b-10"></div>

                            </form>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-6 ingresos" style="display:none">
                            <h2>Informe de Ingresos</h2>
                            <hr>
                            <div id="pie-chart-ingresos" class="flot-chart-pie"></div>
                            <div id="flc-pie-ingresos" class="flc-pie hidden-xs"></div>
                        </div>

                        <div class="col-md-6 ingresos" style="display:none">
                            <h2>Informe de Ingresos</h2>
                            <hr>
                            <div id="pie-chart-ingresos2" class="flot-chart-pie"></div>
                            <div id="flc-pie-ingresos2" class="flc-pie hidden-xs"></div>
                        </div>

                        <div class="col-md-4 egresos" style="display: none">

                            <table class="table display cell-border" id="table_egresos">
                                <thead>
                                    <tr>
                                        <th class="text-center" data-column-id="nombre">Nombre</th>
                                        <th class="text-center" data-column-id="cantidad">Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6 col-sm-offset-2 egresos" style="display:none">
                            <h2>Informe de Egresos</h2>
                            <hr>
                            <div id="pie-chart-egresos" class="flot-chart-pie"></div>
                            <div id="flc-pie-egresos" class="flc-pie hidden-xs"></div>
                        </div>

                        <div class="clearfix"></div>
                        
                        <div class="table-responsive row">
                           <div class="col-md-12">
                                <table class="table table-striped table-bordered text-center " id="tablelistar" >
                                    <thead>
                                        <tr>
                                            <th class="text-center" data-column-id="fecha">Fecha</th>
                                            <th class="text-center" data-column-id="hora">Hora</th>
                                            <th class="text-center" data-column-id="cliente">Cliente</th>
                                            <th class="text-center" data-column-id="tipo">Tipo</th>
                                            <th class="text-center" data-column-id="concepto">Concepto</th>
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

                                            <br>

                                            <span class="f-15">Totales</span>

                                            <div class="ingresos" style="display:none">
                                                <br>
                                                <span class="f-15" id = "total_ingreso">0</span>
                                            </div>

                                            <div class="egresos" style="display:none">
                                                <br>
                                                <span class="f-15" id = "total_egreso">0</span>
                                            </div>
                                            <div class="proforma" style="display:none">
                                                <br>
                                                <span class="f-15" id="total_proforma">0</span>
                                            </div>
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

    var linea_servicio = <?php echo json_encode($linea_servicio);?>;
    var config_egresos = <?php echo json_encode($config_egresos);?>;

    tipo_dropdown = ''
    tipo_servicio = ''
    nombre_servicio = ''
    servicio_id = ''

    var nFrom = $(this).attr('data-from');
    var nAlign = $(this).attr('data-align');
    var nIcons = $(this).attr('data-icon');
    var nType = 'danger';
    var nAnimIn = "animated flipInY";
    var nAnimOut = "animated flipOutY"; 

    $(document).ready(function(){


        //DateRangePicker
        $('#fecha2').daterangepicker({
            "autoApply" : false,
            "opens": "right",
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

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 50,
        order: [[0, 'desc'], [1, 'desc']],
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

        h=$('#table_egresos').DataTable({
                processing: true,
                serverSide: false,
                pageLength: 25, 
                bPaginate: false,
                bInfo: false,
                bFilter:false, 
                bSort:false, 
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
    });

        $("#guardar").click(function(){
            var token = $('input:hidden[name=_token]').val();
            var datos = $( "#formFiltro" ).serialize();

            // var nombre = [];

            // $('#tipo_id option:selected').each(function() {
            //   nombre.push($(this).text());
            // });

            procesando();
            $.ajax({
                url: route_filtrar,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: datos+"&nombre_servicio="+nombre_servicio+"&servicio_tipo="+tipo_servicio+"&tipo_dropdown="+tipo_dropdown+"&servicio_id="+servicio_id,
                success:function(respuesta){

                    var nType = 'success';
                    var nTitle="Ups! ";
                    var nMensaje=respuesta.mensaje;

                    t.clear().draw();

                    $.each(respuesta.facturas, function (index, array) {

                        concepto = toTitleCase(array.nombre)
                        concepto_completo = concepto

                        if(concepto.length > 30){
                            concepto = concepto.substr(0, 30) + "..."
                        }

                        if(array.tipo == 1){
                            monto = '+'+formatmoney(parseFloat(array.importe_neto))
                        }else if(array.tipo == 2){
                            monto = '-'+formatmoney(parseFloat(array.importe_neto))
                        }else{
                            monto = formatmoney(parseFloat(array.importe_neto))
                        }

                        var rowNode=t.row.add( [
                            ''+array.fecha+'',
                            ''+array.hora+'',
                            ''+array.cliente+'',
                            ''+array.tipo_pago+'',
                            ''+'<span class="capitalize">'+concepto+'</span>'+'',
                            ''+monto+''
                        ] ).draw(false).node();

                        $( rowNode )
                            .attr('data-trigger','hover')
                            .attr('data-toggle','popover')
                            .attr('data-placement','top')
                            .attr('data-original-title','Ayuda &nbsp;&nbsp;&nbsp;&nbsp;')
                            .attr('data-html','true')
                            .attr('data-container','body')
                            .attr('title','')
                            .attr('data-content',concepto_completo)
                            .attr('id',array.id)
                            .data('tipo',array.tipo)

                        if(array.tipo == 1)
                            $(rowNode).addClass('seleccion');
                        else{
                            $(rowNode).addClass('disabled');
                        }
                    });

                    $('[data-toggle="popover"]').popover(); 

                    datos = JSON.parse(JSON.stringify(respuesta));

                    tipo = $('#tipo').val();

                    if(tipo == 1 || tipo == 2){

                        $('#total_ingreso').text('+'+formatmoney(parseFloat(respuesta.total_ingreso)))

                        $("#pie-chart-ingresos").html('');
                        $("#flc-pie-ingresos").html('');
                        $("#pie-chart-ingresos2").html('');
                        $("#flc-pie-ingresos2").html('');

                        var pieData1 = ''
                        pieData1 += '[';

                        $.each( datos.array_pago, function( i, item ) {
                            var label = item.nombre;
                            var cant = item.cantidad;
                            pieData1 += '{"data":"'+cant+'","label":"'+label+'"},';
                        });

                        pieData1 = pieData1.substring(0, pieData1.length -1);
                        pieData1 += ']';

                        $.plot('#pie-chart-ingresos', $.parseJSON(pieData1), {
                            series: {
                                pie: {
                                    show: true,
                                    stroke: { 
                                        width: 2,
                                    },
                                },
                            },
                            legend: {
                                container: '#flc-pie-ingresos',
                                backgroundOpacity: 0.5,
                                noColumns: 0,
                                backgroundColor: "white",
                                lineWidth: 0
                            },
                            grid: {
                                hoverable: true,
                                clickable: true
                            },
                            tooltip: true,
                            tooltipOpts: {
                                content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                                shifts: {
                                    x: 20,
                                    y: 0
                                },
                                defaultTheme: false,
                                cssClass: 'flot-tooltip'
                            },
                            
                        });

                        // ----- //

                        var pieData1 = ''
                        pieData1 += '[';

                        $.each( datos.array_ingreso, function( i, item ) {
                            var label = item.nombre;
                            var cant = item.cantidad;
                            pieData1 += '{"data":"'+cant+'","label":"'+label+'"},';
                        });

                        pieData1 = pieData1.substring(0, pieData1.length -1);
                        pieData1 += ']';

                        $.plot('#pie-chart-ingresos2', $.parseJSON(pieData1), {
                            series: {
                                pie: {
                                    show: true,
                                    stroke: { 
                                        width: 2,
                                    },
                                },
                            },
                            legend: {
                                container: '#flc-pie-ingresos2',
                                backgroundOpacity: 0.5,
                                noColumns: 0,
                                backgroundColor: "white",
                                lineWidth: 0
                            },
                            grid: {
                                hoverable: true,
                                clickable: true
                            },
                            tooltip: true,
                            tooltipOpts: {
                                content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                                shifts: {
                                    x: 20,
                                    y: 0
                                },
                                defaultTheme: false,
                                cssClass: 'flot-tooltip'
                            },
                            
                        });

                        $('.ingresos').show();
                        $('.egresos').hide();
                        $('.proforma').hide();

                    }

                    if(tipo == 1 || tipo == 3){

                        $("#pie-chart-egresos").html('');
                        $("#flc-pie-egresos").html('');

                        $('#total_egreso').text('-'+formatmoney(parseFloat(respuesta.total_egreso)))
                        h.clear().draw();

                        $.each(respuesta.config_egreso, function (index, array) {

                            var rowNode=h.row.add( [
                                '&nbsp;&nbsp;'+array.nombre+'',
                                ''+formatmoney(parseFloat(array.cantidad))+'',
                            ] ).draw(false).node();
                            
                            $( rowNode )
                                .addClass('seleccion');
                        });

                        var pieData2 = ''
                        pieData2 += '[';
                        $.each( datos.config_egreso, function( i, item ) {
                            var label = item.nombre;
                            var cant = item.cantidad;
                            pieData2 += '{"data":"'+cant+'","label":"'+label+'"},';
                        });
                        pieData2 = pieData2.substring(0, pieData2.length -1);
                        pieData2 += ']';

                        $.plot('#pie-chart-egresos', $.parseJSON(pieData2), {
                            series: {
                                pie: {
                                    show: true,
                                    stroke: { 
                                        width: 2,
                                    },
                                },
                            },
                            legend: {
                                container: '#flc-pie-egresos',
                                backgroundOpacity: 0.5,
                                noColumns: 0,
                                backgroundColor: "white",
                                lineWidth: 0
                            },
                            grid: {
                                hoverable: true,
                                clickable: true
                            },
                            tooltip: true,
                            tooltipOpts: {
                                content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                                shifts: {
                                    x: 20,
                                    y: 0
                                },
                                defaultTheme: false,
                                cssClass: 'flot-tooltip'
                            },
                            
                        });

                        $('.egresos').show();
                        $('.ingresos').hide();
                        $('.proforma').hide();

                    }

                    if(tipo == 1 || tipo == 4){

                        $('.egresos').hide();
                        $('.ingresos').hide();
                        $('.proforma').show();
                        $('.total_proforma').text(formatmoney(parseFloat(respuesta.total_proforma)))
                    }

                    if(tipo == 1){
                        $('.egresos').show();
                        $('.ingresos').show();
                        $('.proforma').show();
                    }

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

        $('body').on('click','.servicio_detalle',function(e){
            
            tipo_dropdown = $(this).data('tipo_dropdown')
            tipo_servicio = $(this).data('tipo_servicio')
            nombre_servicio = $(this).data('nombre_servicio')
            servicio_id = $(this).data('servicio_id')

            $('#detalle_boton').text(nombre_servicio)

            $('#dropdown_boton').removeClass('open')
            $('#detalle_boton').attr('aria-expanded',false);
        });

        $('#tipo').on('change', function(){

            tipo = $(this).val();
            contenido = '';
            nombre = '';
            tipo_dropdown = ''
            servicio_id = ''

            $('#dropdown_principal').empty()
            $('#detalle_boton').text('Todos')

            if(tipo == 2 || tipo == 4){
                $("#clase_grupal_id").removeAttr("disabled");
            }else{
                $('#clase_grupal_id').attr('disabled','disabled')
            }

            if(tipo == 3){

                $.each(config_egresos, function (index, array) {

                    contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-tipo_servicio="'+array.id+'" data-nombre_servicio="'+array.nombre+'" data-servicio_id="'+array.id+'"><a>'+array.nombre+'</a></li>'
                })

                $('#dropdown_principal').append(contenido);

            }

            if(tipo == 4){
                $('#fecha').attr('disabled','disabled')
                $('#personalizar').addClass('disabled')
                $('#personalizar').attr('href','')
            }else{
                $("#fecha").removeAttr("disabled");
                $("#personalizar").removeClass("disabled");
                $('#personalizar').attr('href','#collapseTwo')
            }

            $('#fecha').selectpicker('refresh');
            $('#clase_grupal_id').selectpicker('refresh');
        });

        // $('#tipo_servicio').on('change', function(){

        //     id = $(this).val();

        //     if(id != 0){
        //         tmp = [];

        //         if(id == 99){
        //             $.each(linea_servicio, function (index, array) {  
        //                 not_in = [5,11,14]
        //                 tipo = array.tipo
        //                 if($.inArray(tipo, not_in)){
        //                     tmp.push(array);
        //                 }                   
        //             });
        //         }else{
        //             $.each(linea_servicio, function (index, array) {  
        //                 if(array.tipo == id){
        //                     tmp.push(array);
        //                 }                   
        //             });
        //         }
        //     }else{
        //         tmp = linea_servicio
        //     }

        //     $('#tipo_id').empty();

        //     $.each(tmp, function (index, array) {                     
        //       $('#tipo_id').append( new Option(array.nombre,array.id+'-'+array.tipo));
        //     });

        //     $('#tipo_id').selectpicker('refresh');
        // });

        // $('#tipo_servicio').on('change', function(){

        //     id = $(this).val();
        //     $('#tipo_id').empty();

        //     if(id == 99){
        //         $('#tipo_id').append( new Option('Clases Grupales',3));
        //         $('#tipo_id').append( new Option('Clases Personalizadas',9));
        //         $('#tipo_id').append( new Option('Productos',2));
        //         $('#tipo_id').append( new Option('Servicios',1));
        //     }else if(id == 14){
        //         $('#tipo_id').append( new Option('Productos',14));
        //         $('#tipo_id').append( new Option('Servicios',14));
        //     }else if(id == 5){
        //         $('#tipo_id').append( new Option('Productos',5));
        //         $('#tipo_id').append( new Option('Servicios',5));
        //     }else if(id == 11){
        //         $('#tipo_id').append( new Option('Productos',11));
        //         $('#tipo_id').append( new Option('Servicios',11));
        //     }
            
        //     $('#tipo_id').selectpicker('refresh');
        // });

        $('#tipo_servicio').on('change', function(){

            tipo = $('#tipo').val();

            if(tipo == 2){

                tipo_servicio = $(this).val();
                nombre = '';
                tipo_dropdown = ''
                servicio_id = ''

                $('#detalle_boton').text('Todos')

                id = $(this).val();
                $('#dropdown_principal').empty();

                if(id == 99){

                    contenido = '';

                    contenido += '<li class="dropdown-submenu pointer servicio_detalle" data-tipo_dropdown="1" data-tipo_servicio="3" data-nombre_servicio="Clases Grupales" data-servicio_id ="3">'
                    contenido += '<a>Clases Grupales</a>'
                    contenido += '<ul class="dropdown-menu">'

                    $.each(linea_servicio, function (index, array) {  
                        if(array.tipo == 3 || array.tipo == 4){
                            contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-tipo_servicio="'+array.tipo+'" data-nombre_servicio="'+array.nombre+'" data-servicio_id="'+array.id+'"><a>'+array.nombre+'</a></li>'
                        }                   
                    });

                    contenido += '</ul></li>'

                    $('#dropdown_principal').append(contenido);

                    contenido = '';
                
                    contenido += '<li class="dropdown-submenu pointer servicio_detalle" data-tipo_dropdown="1" data-tipo_servicio="9" data-nombre_servicio="Clases Personalizadas" data-servicio_id ="9">'
                    contenido += '<a>Clases Personalizadas</a>'
                    contenido += '<ul class="dropdown-menu">'

                    $.each(linea_servicio, function (index, array) {  
                        if(array.tipo == 9){
                            contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-tipo_servicio="'+array.tipo+'" data-nombre_servicio="'+array.nombre+'" data-servicio_id="'+array.id+'"><a>'+array.nombre+'</a></li>'
                        }                   
                    });

                    contenido += '</ul></li>'

                    $('#dropdown_principal').append(contenido);

                    contenido = '';

                    contenido += '<li class="dropdown-submenu pointer servicio_detalle" data-tipo_dropdown="1" data-tipo_servicio="2" data-nombre_servicio="Productos" data-servicio_id ="2">'
                    contenido += '<a>Productos</a>'
                    contenido += '<ul class="dropdown-menu">'

                    $.each(linea_servicio, function (index, array) {  
                        if(array.tipo == 2){
                            contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-tipo_servicio="'+array.tipo+'" data-nombre_servicio="'+array.nombre+'" data-servicio_id="'+array.id+'"><a>'+array.nombre+'</a></li>'
                        }                   
                    });

                    contenido += '</ul></li>'

                    $('#dropdown_principal').append(contenido);

                    contenido = '';

                    contenido += '<li class="dropdown-submenu pointer servicio_detalle" data-tipo_dropdown="1" data-tipo_servicio="1" data-nombre_servicio="Servicios" data-servicio_id ="1">'
                    contenido += '<a>Servicios</a>'
                    contenido += '<ul class="dropdown-menu">'

                    $.each(linea_servicio, function (index, array) {  
                        if(array.tipo == 1){
                            contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-tipo_servicio="'+array.tipo+'" data-nombre_servicio="'+array.nombre+'" data-servicio_id="'+array.id+'"><a>'+array.nombre+'</a></li>'
                        }                   
                    });

                    contenido += '</ul></li>'

                    $('#dropdown_principal').append(contenido);

                    contenido = '';
                

                }else if(id == 14){
                        

                    $.each(linea_servicio, function (index, array) {  

                        if(array.tipo == 14){

                            contenido = '';

                            contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-tipo_servicio="'+array.tipo+'" data-nombre_servicio="'+array.nombre+'" data-servicio_id="'+array.id+'"><a>'+array.nombre+'</a></li>';

                            $('#dropdown_principal').append(contenido);

                        }                   
                    });
                    
                }else if(id == 5){

                    $.each(linea_servicio, function (index, array) {  

                        if(array.tipo == 5){

                            contenido = '';

                            contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-tipo_servicio="'+array.tipo+'" data-nombre_servicio="'+array.nombre+'" data-servicio_id="'+array.id+'"><a>'+array.nombre+'</a></li>';

                            $('#dropdown_principal').append(contenido);

                        }                   
                    });
                }else if(id == 11){

                    $.each(linea_servicio, function (index, array) {  

                        if(array.tipo == 11){

                            contenido = '';

                            contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-tipo_servicio="'+array.tipo+'" data-nombre_servicio="'+array.nombre+'" data-servicio_id="'+array.id+'"><a>'+array.nombre+'</a></li>';

                            $('#dropdown_principal').append(contenido);

                        }                   
                    });
                    
                }
            }
        });

        function collapse_minus(collaps){
            $('#'+collaps).collapse('hide');
        }   

        $('#collapseTwo').on('show.bs.collapse', function () {
            $("#boolean_fecha").val('1');
            $("#fecha").attr('disabled',true);
            $("#fecha").addClass('disabled');
            $("#fecha").selectpicker('refresh');
            setTimeout(function(){ 
                $("#fecha2").click();
            }, 500);
        })

        $('#collapseTwo').on('hide.bs.collapse', function () {
            $("#fecha").attr('disabled',false);
            $("#fecha").removeClass('disabled');
            $("#fecha").selectpicker('refresh');
            $("#boolean_fecha").val('0');
        })

        function previa(t){

            var row = $(t).closest('tr');
            var tipo = row.data('tipo')

            console.log(tipo)

            if(tipo == 1){
                var id = row.attr('id');
                var route =route_detalle+"/"+id;
                window.location=route;
            }
        }

        function toTitleCase(str)
        {
            return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
        }

        </script>

@stop