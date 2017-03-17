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

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_f-productos f-25"></i> Reporte Master</p>
                            <hr class="linea-morada">
                                                         
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
                                            <td>{{ number_format($generales, 2, '.' , '.') }}</td>
                                            <td>Egresos academia</td>
                                            <td>{{ number_format($egresos_generales, 2, '.' , '.') }}</td>
                                            <td>{{ number_format($generales - $egresos_generales, 2, '.' , '.') }}</td>
                                        </tr>

                                        <tr>
                                            <td><span style="padding-left: 3%">Ingresos eventos</span></td>
                                            <td>{{ number_format($eventos, 2, '.' , '.') }}</td>
                                            <td>Egresos eventos</td>
                                            <td>{{ number_format($egresos_eventos, 2, '.' , '.') }}</td>
                                            <td>{{ number_format($eventos - $egresos_eventos, 2, '.' , '.') }}</td>
                                        </tr>

                                        <tr>
                                            <td><span style="padding-left: 3%">Ingresos talleres</span></td>
                                            <td>{{ number_format($talleres, 2, '.' , '.') }}</td>
                                            <td>Egresos talleres</td>
                                            <td>{{ number_format($egresos_talleres, 2, '.' , '.') }}</td>
                                            <td>{{ number_format($talleres - $egresos_talleres, 2, '.' , '.') }}</td>
                                        </tr>

                                        <tr>
                                            <td><span style="padding-left: 3%">Ingresos campañas</span></td>
                                            <td>{{ number_format($campanas, 2, '.' , '.') }}</td>
                                            <td>Egresos campañas</td>
                                            <td>{{ number_format($egresos_campanas, 2, '.' , '.') }}</td>
                                            <td>{{ number_format($campanas - $egresos_campanas, 2, '.' , '.') }}</td>
                                        </tr>

                                        <tr>
                                            <td><span style="padding-left: 3%">TOTALES:</span></td>
                                            <td>{{number_format($total, 2, '.' , '.')}}</td>
                                            <td>TOTALES:</td>
                                            <td>{{number_format($total_egresos, 2, '.' , '.')}}</td>
                                            <td>{{number_format($total - $total_egresos, 2, '.' , '.') }}</td>
                                        </tr>     
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="clearfix"></div>
                        
                        <div class="col-md-4">
                            <div>
                                <table class="table display cell-border" id="visitantes" >
                                    <thead>
                                        <tr>
                                            <th class="text-center" data-column-id="visitantes">Visitantes Presenciales</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td><span style="padding-left: 3%">Mujer: {{$visitantes_mujeres}}</span></td>
                                        </tr>

                                        <tr>
                                            <td><span style="padding-left: 3%">Hombre: {{$visitantes_hombres}}</span></td>
                                        </tr>

                                        <tr>
                                            <td><span style="padding-left: 3%">TOTAL: {{$visitantes_hombres + $visitantes_mujeres}}</span></td>
                                        </tr>
    
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        
                        <div class="col-md-4">
                            <div>
                                <table class="table display cell-border" id="inscritos" >
                                    <thead>
                                        <tr>
                                            <th class="text-center" data-column-id="visitantes">Inscritos</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td><span style="padding-left: 3%">Mujer: {{$inscritos_mujeres}}</span></td>
                                        </tr>

                                        <tr>
                                            <td><span style="padding-left: 3%">Hombre: {{$inscritos_hombres}}</span></td>
                                        </tr>

                                        <tr>
                                            <td><span style="padding-left: 3%">TOTAL: {{$inscritos_mujeres + $inscritos_hombres}}</span></td>
                                        </tr>
    
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        
                        <div class="col-md-4">
                            <div>
                                <table class="table display cell-border" id="referidos" >
                                    <thead>
                                        <tr>
                                            <th class="text-center" data-column-id="visitantes">Referidos</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td><span style="padding-left: 3%">Mujer: {{$referidos_mujeres}}</span></td>
                                        </tr>

                                        <tr>
                                            <td><span style="padding-left: 3%">Hombre: {{$referidos_hombres}}</span></td>
                                        </tr>

                                        <tr>
                                            <td><span style="padding-left: 3%">TOTAL: {{$referidos_mujeres + $referidos_hombres}}</span></td>
                                        </tr>
    
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

            <button class="btn btn-float bgm-red m-btn" data-action="print"><i class="zmdi zmdi-print"></i></button>
@stop

@section('js') 
            
        <script type="text/javascript">

        $(document).ready(function(){


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



        });

</script>

@stop