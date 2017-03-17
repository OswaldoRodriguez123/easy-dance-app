@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>


<script src="{{url('/')}}/assets/vendors/bower_components/flot/jquery.flot.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot/jquery.flot.resize.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot/jquery.flot.pie.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot-orderBars/js/jquery.flot.orderBars.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot.curvedlines/curvedLines.js"></script>                         
<script src="{{url('/')}}/assets/vendors/bower_components/flot-orderBars/js/jquery.flot.orderBars.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

<script src="{{url('/')}}/assets/js/flot-charts/pie-chart.js"></script>

@stop
@section('content')

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <!-- <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/asistencia" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección de Asistencias</a> -->

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

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_d-reporte f-25"></i> Reporte Master</p>
                            <hr class="linea-morada">
                                                         
                        </div>

                         <div class="col-sm-12">
                            <form name="formFiltro" id="formFiltro">

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" id="boolean_fecha" name="boolean_fecha" value="0">

                                <div class="col-md-6">
                                    <label>Fecha</label> &nbsp; &nbsp; &nbsp;

                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="tipo" id="tipo">
                                            <option value="2">Mes Actual</option>
                                            <option value="3">Mes Pasado</option>
                                        </select>
                                      </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group fg-line">
                                        <label for="nombre">Personalizar</label>
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

                                                        <div class="clearfix m-b-20"></div>
                                                    

                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                                            <div class="fg-line">
                                                                    <input type="text" name = "fecha" id="fecha" class="form-control" placeholder="Personalizar">
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


                        <div class ="clearfix"></div>

                        <div class="table-responsive">
                            <div class="col-md-12">
                                <table class="table display cell-border" id="tablelistar" >
                                    <thead>
                                        <tr>
                                            <th class="text-center" data-column-id="generales">Ingresos Generales</th>
                                            <th class="text-center"></th>
                                            <th class="text-center" data-column-id="apellido">Egresos Generales</th>
                                            <th class="text-center"></th>                                    
                                            <th class="text-center" data-column-id="total">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php 
                                            $total = $generales + $talleres + $eventos + $campanas;
                                            $total_egresos = $egresos_generales + $egresos_talleres + $egresos_eventos + $egresos_campanas;
                                        ?>

                                        <tr>
                                            <td><span style="padding-left: 3%">Ingresos academia</span></td>
                                            <td id="generales">{{ number_format($generales, 2, '.' , '.') }}</td>
                                            <td>Egresos academia</td>
                                            <td id="egresos_generales">{{ number_format($egresos_generales, 2, '.' , '.') }}</td>
                                            <td id="total_generales">{{ number_format($generales - $egresos_generales, 2, '.' , '.') }}</td>
                                        </tr>

                                        <tr>
                                            <td><span style="padding-left: 3%">Ingresos eventos</span></td>
                                            <td id="eventos">{{ number_format($eventos, 2, '.' , '.') }}</td>
                                            <td>Egresos eventos</td>
                                            <td id="egresos_eventos">{{ number_format($egresos_eventos, 2, '.' , '.') }}</td>
                                            <td id="total_eventos">{{ number_format($eventos - $egresos_eventos, 2, '.' , '.') }}</td>
                                        </tr>

                                        <tr>
                                            <td><span style="padding-left: 3%">Ingresos talleres</span></td>
                                            <td id="talleres">{{ number_format($talleres, 2, '.' , '.') }}</td>
                                            <td>Egresos talleres</td>
                                            <td id="egresos_talleres">{{ number_format($egresos_talleres, 2, '.' , '.') }}</td>
                                            <td id="total_talleres">{{ number_format($talleres - $egresos_talleres, 2, '.' , '.') }}</td>
                                        </tr>

                                        <tr>
                                            <td><span style="padding-left: 3%">Ingresos campañas</span></td>
                                            <td id="campanas">{{ number_format($campanas, 2, '.' , '.') }}</td>
                                            <td>Egresos campañas</td>
                                            <td id="egresos_campanas">{{ number_format($egresos_campanas, 2, '.' , '.') }}</td>
                                            <td id="total_campanas">{{ number_format($campanas - $egresos_campanas, 2, '.' , '.') }}</td>
                                        </tr>

                                        <tr>
                                            <td><span style="padding-left: 3%">TOTALES:</span></td>
                                            <td id="total_ingresos">{{number_format($total, 2, '.' , '.')}}</td>
                                            <td>TOTALES:</td>
                                            <td id="total_egresos">{{number_format($total_egresos, 2, '.' , '.')}}</td>
                                            <td id="total">{{number_format($total - $total_egresos, 2, '.' , '.') }}</td>
                                        </tr>     
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="clearfix"></div>
                        
                        <div class="col-md-4" style="margin-top: 11%">

                            <table class="table display cell-border" id="visitantes" >
                                <thead>
                                    <tr>
                                        <th class="text-center" data-column-id="visitantes">Visitantes Presenciales</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td><span style="padding-left: 3%"><i class="zmdi zmdi-female c-rosado f-25" style="padding-right: 2%"></i> <span id="visitantes_mujeres">{{$visitantes_mujeres}}</span></span></td>
                                    </tr>

                                    <tr>
                                        <td><span style="padding-left: 3%"><i class="zmdi zmdi-male-alt c-azul f-25" style="padding-right: 2%"></i> <span id="visitantes_hombres">{{$visitantes_hombres}}</span></span></td>
                                    </tr>

                                    <tr>
                                        <td><span style="padding-left: 3%">TOTAL: <span id="visitantes_totales">{{$visitantes_hombres + $visitantes_mujeres}}</span></span></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
       

                        <div class="col-md-6 col-md-offset-2">
                            <h2 class="text-center">Informe de Visitantes</h2>
                            <hr>
                            <div id="pie-chart-visitantes" class="flot-chart"></div>
                            <div  id="flc-pie-visitantes" class="flc-pie hidden-xs"></div>

                        </div>

                        <div class="clearfix m-b-30"></div>
                        
                        <div class="col-md-4" style="margin-top: 11%">
                            <div>
                                <table class="table display cell-border" id="inscritos" >
                                    <thead>
                                        <tr>
                                            <th class="text-center" data-column-id="visitantes">Inscritos</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td><span style="padding-left: 3%"><i class="zmdi zmdi-female c-rosado f-25" style="padding-right: 2%"></i> <span id="inscritos_mujeres">{{$inscritos_mujeres}}</span></span></td>
                                        </tr>

                                        <tr>
                                            <td><span style="padding-left: 3%"><i class="zmdi zmdi-male-alt c-azul f-25" style="padding-right: 2%"></i> <span id="inscritos_hombres">{{$inscritos_hombres}}</span></span></td>
                                        </tr>

                                        <tr>
                                            <td><span style="padding-left: 3%">TOTAL: <span id="inscritos_totales">{{$inscritos_mujeres + $inscritos_hombres}}</span></span></td>
                                        </tr>
    
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6 col-md-offset-2">
                            <h2 class="text-center">Informe de Inscritos</h2>
                            <hr>
                            <div id="pie-chart-inscritos" class="flot-chart"></div>
                            <div id="flc-pie-inscritos" class="flc-pie hidden-xs"></div>

                        </div>

                        <div class="clearfix m-b-30"></div>
                        
                        <div class="col-md-4" style="margin-top: 11%">
                            <div>
                                <table class="table display cell-border" id="referidos" >
                                    <thead>
                                        <tr>
                                            <th class="text-center" data-column-id="visitantes">Referidos</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td><span style="padding-left: 3%"><i class="zmdi zmdi-female c-rosado f-25" style="padding-right: 2%"></i> <span id="referidos_mujeres">{{$referidos_mujeres}}</span></span></td>
                                        </tr>

                                        <tr>
                                            <td><span style="padding-left: 3%"><i class="zmdi zmdi-male-alt c-azul f-25" style="padding-right: 2%"></i> <span id="referidos_hombres">{{$referidos_hombres}}</span></span></td>
                                        </tr>

                                        <tr>
                                            <td><span style="padding-left: 3%">TOTAL: <span id="referidos_totales">{{$referidos_mujeres + $referidos_hombres}}</span></span></td>
                                        </tr>
    
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6 col-md-offset-2">
                            <h2 class="text-center">Informe de Referidos</h2>
                            <hr>
                            <div id="pie-chart-referidos" class="flot-chart"></div>
                            <div  id="flc-pie-referidos" class="flc-pie hidden-xs"></div>

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

            <button class="btn btn-float bgm-red m-btn" data-action="print"><i class="zmdi zmdi-print"></i></button>
@stop

@section('js') 
            
<script type="text/javascript">

    route_filtrar="{{url('/')}}/reportes/master";

    color2 = "#2196f3"
    color1 = "#FF4081"

    $(document).ready(function(){


        //DateRangePicker
        $('#fecha').daterangepicker({
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

        var pieData1 = [
            
            @foreach ($array_visitante as $data)
                {data: {{$data[1]}}, label: '{{$data[0]}}'},
            @endforeach
            
        ];

        var pieData2 = [
            
            @foreach ($array_inscrito as $data)
                {data: {{$data[1]}}, label: '{{$data[0]}}'},
            @endforeach
            
        ];

        var pieData3 = [
            
            @foreach ($array_referido as $data)
                {data: {{$data[1]}}, label: '{{$data[0]}}'},
            @endforeach
            
        ];
        
        // var values = [
        //     {{$visitantes_mujeres}},
        //     {{$visitantes_hombres}}
                         
        // ];


        $.plot('#pie-chart-visitantes', pieData1, {
            series: {
                pie: {
                    show: true,
                    stroke: { 
                        width: 2,
                    },
                },
            },
            legend: {
                container: '#flc-pie-visitantes',
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
            colors: ["rgb(237,194,64)", "rgb(175,216,248)", "rgb(203,75,75)", "rgb(77,167,77)", "rgb(148,64,237)", "rgb(31,64,163)", "rgb(140,172,198)"],
            
        });

        $.plot('#pie-chart-inscritos', pieData2, {
            series: {
                pie: {
                    show: true,
                    stroke: { 
                        width: 2,
                    },
                },
            },
            legend: {
                container: '#flc-pie-inscritos',
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

        $.plot('#pie-chart-referidos', pieData3, {
            series: {
                pie: {
                    show: true,
                    stroke: { 
                        width: 2,
                    },
                },
            },
            legend: {
                container: '#flc-pie-referidos',
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


    });

    t=$('#tablelistar').DataTable({
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

    h=$('#visitantes').DataTable({
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

    i=$('#inscritos').DataTable({
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

    j=$('#referidos').DataTable({
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

    function collapse_minus(collaps){
        $('#'+collaps).collapse('hide');
    }   

    $('#collapseTwo').on('show.bs.collapse', function () {
        $("#boolean_fecha").val('1');
        setTimeout(function(){ 
            $("#fecha").click();
        }, 500);
    })

    $('#collapseTwo').on('hide.bs.collapse', function () {
        $("#boolean_fecha").val('0');
    })


    $("#guardar").click(function(){

            var route = route_filtrar;
            var token = $('input:hidden[name=_token]').val();
            var datos = $( "#formFiltro" ).serialize();

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

                    $('#talleres').text(formatmoney(respuesta.talleres))
                    $('#campanas').text(formatmoney(respuesta.campanas))
                    $('#eventos').text(formatmoney(respuesta.eventos))
                    $('#generales').text(formatmoney(respuesta.generales))

                    $('#egresos_generales').text(formatmoney(respuesta.egresos_generales))
                    $('#egresos_campanas').text(formatmoney(respuesta.egresos_campanas))
                    $('#egresos_talleres').text(formatmoney(respuesta.egresos_talleres))
                    $('#egresos_eventos').text(formatmoney(respuesta.egresos_eventos))

                    total_generales = parseFloat(respuesta.generales - respuesta.egresos_generales);
                    total_campanas = parseFloat(respuesta.campanas - respuesta.egresos_campanas);
                    total_eventos = parseFloat(respuesta.eventos - respuesta.egresos_eventos);
                    total_talleres = parseFloat(respuesta.talleres - respuesta.egresos_talleres);

                    $('#total_generales').text(formatmoney(total_generales))
                    $('#total_campanas').text(formatmoney(total_campanas))
                    $('#total_eventos').text(formatmoney(total_eventos))
                    $('#total_talleres').text(formatmoney(total_talleres))

                    $('#total_ingresos').text(formatmoney(respuesta.talleres + respuesta.campanas + respuesta.eventos + respuesta.generales))
                    $('#total_egresos').text(formatmoney(respuesta.egresos_generales + respuesta.egresos_campanas + respuesta.egresos_eventos + respuesta.egresos_talleres))
                    $('#total').text(formatmoney(total_generales + total_campanas + total_eventos + total_talleres))

                    $('#visitantes_mujeres').text(respuesta.visitantes_mujeres);
                    $('#visitantes_hombres').text(respuesta.visitantes_hombres);
                    $('#visitantes_totales').text(parseInt(respuesta.visitantes_mujeres + respuesta.visitantes_hombres));

                    $('#inscritos_mujeres').text(respuesta.inscritos_mujeres);
                    $('#inscritos_hombres').text(respuesta.inscritos_hombres);
                    $('#inscritos_totales').text(parseInt(respuesta.inscritos_mujeres + respuesta.inscritos_hombres));

                    $('#referidos_mujeres').text(respuesta.referidos_mujeres);
                    $('#referidos_hombres').text(respuesta.referidos_hombres);
                    $('#referidos_totales').text(parseInt(respuesta.referidos_mujeres + respuesta.referidos_hombres));


                    datos = JSON.parse(JSON.stringify(respuesta));

                    var pieData1 = ''
                    pieData1 += '[';
                    $.each( datos.array_visitante, function( i, item ) {
                        var label = item[0];
                        var cant = item[1];
                        pieData1 += '{"data":"'+cant+'","label":"'+label+'"},';
                    });
                    pieData1 = pieData1.substring(0, pieData1.length -1);
                    pieData1 += ']';

                    // --

                    var pieData2 = ''
                    pieData2 += '[';
                    $.each( datos.array_inscrito, function( i, item ) {
                        var label = item[0];
                        var cant = item[1];
                        pieData2 += '{"data":"'+cant+'","label":"'+label+'"},';
                    });
                    pieData2 = pieData2.substring(0, pieData2.length -1);
                    pieData2 += ']';

                    // --

                    var pieData3 = ''
                    pieData3 += '[';
                    $.each( datos.array_referido, function( i, item ) {
                        var label = item[0];
                        var cant = item[1];
                        pieData3 += '{"data":"'+cant+'","label":"'+label+'"},';
                    });
                    pieData3 = pieData3.substring(0, pieData3.length -1);
                    pieData3 += ']';

                    $(".flot-chart").html('');
                    $(".flc-pie").html('');

                    $.plot('#pie-chart-visitantes', $.parseJSON(pieData1), {
                        series: {
                            pie: {
                                show: true,
                                stroke: { 
                                    width: 2,
                                },
                            },
                        },
                        legend: {
                            container: '#flc-pie-visitantes',
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
                        colors: ["rgb(237,194,64)", "rgb(175,216,248)", "rgb(203,75,75)", "rgb(77,167,77)", "rgb(148,64,237)", "rgb(31,64,163)", "rgb(140,172,198)"],
                        
                    });

                    $.plot('#pie-chart-inscritos', $.parseJSON(pieData2), {
                        series: {
                            pie: {
                                show: true,
                                stroke: { 
                                    width: 2,
                                },
                            },
                        },
                        legend: {
                            container: '#flc-pie-inscritos',
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

                    $.plot('#pie-chart-referidos', $.parseJSON(pieData3), {
                        series: {
                            pie: {
                                show: true,
                                stroke: { 
                                    width: 2,
                                },
                            },
                        },
                        legend: {
                            container: '#flc-pie-referidos',
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

    function formatmoney(n) {
        n = parseFloat(n)
        return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    }

</script>

@stop