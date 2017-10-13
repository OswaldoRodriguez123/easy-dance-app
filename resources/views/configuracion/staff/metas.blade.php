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

                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/configuracion/staff/detalle/{{$id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-accounts f-25"></i> Seccion de Metas</p>
                            <hr class="linea-morada">
                                                         
                        </div>

                        <div class="clearfix"></div>

                       
                        @foreach($metas as $meta)
                          <div class="col-md-6 col-md-offset-3">

                            <div class="text-center">
                              <div class="text-center f-700 f-22" >{{$meta['nombre']}}</div>
                              <div class="text-center f-700" >Porcentaje de Efectividad</div>
                              <hr class="linea-morada opaco-0-8">

                              <div class="progress progress-striped m-b-10" style="border:1px solid; color:#4E1E43">
                                <div class="progress-bar progress-bar-morado" id="barra_progreso" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: {{$meta['porcentaje']}}%;"></div>
                              </div>
                              <span class="f-700"><span class="progreso">{{$meta['porcentaje']}}</span>% de Efectividad con <span class="total">{{ number_format($meta['total'], 2, '.' , '.') }}</span>

                              <div class="rating-list text-center">

                                <br>
                                <div class="rl-star">

                                  @if($meta['porcentaje'] >= 10)
                                      <i id="estrella_1" class="zmdi zmdi-star active"></i>
                                  @else
                                      <i id="estrella_1" class="zmdi zmdi-star"></i>
                                  @endif

                                  @if($meta['porcentaje'] >= 20)
                                      <i id="estrella_2" class="zmdi zmdi-star active"></i>
                                  @else
                                      <i id="estrella_2" class="zmdi zmdi-star"></i>
                                  @endif

                                  @if($meta['porcentaje'] >= 30)
                                      <i id="estrella_3" class="zmdi zmdi-star active"></i>
                                  @else
                                      <i id="estrella_3" class="zmdi zmdi-star"></i>
                                  @endif

                                  @if($meta['porcentaje'] >= 40)
                                      <i id="estrella_4" class="zmdi zmdi-star active"></i>
                                  @else
                                      <i id="estrella_4" class="zmdi zmdi-star"></i>
                                  @endif

                                  @if($meta['porcentaje'] >= 50)
                                      <i id="estrella_5" class="zmdi zmdi-star active"></i>
                                  @else
                                      <i id="estrella_5" class="zmdi zmdi-star"></i>
                                  @endif
                                    
                                </div>
                              </div>
                            </div>

                            <div class="clearfix m-b-10"></div>
                          </div>
                        @endforeach

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

        route_filtrar="{{url('/')}}/reportes/presenciales";
        route_detalle="{{url('/')}}/participante/visitante/detalle";
        route_encuesta="{{url('/')}}/participante/visitante/encuesta/";

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

            t=$('#tablelistar').DataTable({
            processing: true,
            serverSide: false,
            pageLength: 25, 
            order: [[1, 'desc']],
            fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
              $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6)', nRow).addClass( "text-center, disabled" );
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

            document.getElementById('cliente').innerHTML = '';

            h=$('#promotores').DataTable({
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

            i=$('#mujeres_hombres').DataTable({
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

            k=$('#adultos_niños').DataTable({
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

            l=$('#dias_de_clase').DataTable({
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

            var route = route_filtrar;
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

                        setTimeout(function(){ 
                            var nFrom = $(this).attr('data-from');
                            var nAlign = $(this).attr('data-align');
                            var nIcons = $(this).attr('data-icon');
                            var nAnimIn = "animated flipInY";
                            var nAnimOut = "animated flipOutY"; 

                            var nType = 'success';
                            var nTitle="Ups! ";
                            var nMensaje=respuesta.mensaje;

                            t.clear().draw();
                            h.clear().draw();

                            total = 0
                            cliente_valor = 0
                            nocliente = 0

                            $.each(respuesta.presenciales, function (index, array) {

                                if(array.sexo=='F')
                                {
                                    sexo = '<i class="zmdi zmdi-female f-25 c-rosado"></i> </span>'
                                }
                                else
                                {
                                    sexo = '<i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>'
                                }

                                if(array.cliente == 1)
                                {
                                    cliente = '<span style="display:none">1</span><i class="zmdi zmdi-check c-verde f-20" data-html="true" data-original-title="" data-content="Cliente" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>'
                                    cliente_valor = cliente_valor + 1
                                    total = total + 1
                                }else{
                                    cliente = '<span style="display:none">0</span><i class="zmdi zmdi-dot-circle c-amarillo f-20" data-html="true" data-original-title="" data-content="Visitante" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';
                                    nocliente = nocliente + 1
                                    total = total + 1
                                }

                                if(array.rapidez != 0 || array.calidad != 0 || array.satisfaccion != 0 || array.disponibilidad != 0){
                                    accion = '<i class="icon_a-examen f-20 boton blue sa-warning pointer encuesta" data-original-title="" data-content="Ver Encuesta" data-toggle="popover" data-placement="top" title="" type="button" data-trigger="hover"></i>'
                                }else{
                                    accion = ''
                                }

                                var rowNode=t.row.add( [
                                ''+cliente+'',
                                ''+array.fecha_registro+'',
                                ''+array.nombre+'',
                                ''+array.apellido+'',
                                ''+sexo+'',
                                ''+array.celular+'',
                                ''+array.especialidad+'',
                                ''+accion+'',
                                ] ).draw(false).node();
                                $( rowNode )
                                    .attr('id',array.id)
                                    .addClass('seleccion');
                            });

                            $('[data-toggle="popover"]').popover();

                            $.each(respuesta.promotores, function (index, array) {

                                var rowNode=h.row.add( [
                                '&nbsp;&nbsp;'+array.nombre+'',
                                ''+array.cantidad+'',
                                ] ).draw(false).node();
                                $( rowNode )
                                    .addClass('seleccion');
                            });

                            var rowNode=h.row.add( [
                                '&nbsp;&nbsp;Total:',
                                ''+respuesta.total_clientes+'',
                                ] ).draw(false).node();
                                $( rowNode )
                                    .addClass('seleccion');

                            porcentaje = (respuesta.total_clientes/total)*100
                            porcentaje = parseInt(porcentaje)

                            if(isNaN(porcentaje)){
                                porcentaje = 0
                            }

                            if(porcentaje >= 100){
                                $("#barra_progreso").removeClass('progress-bar-morado');
                                $("#barra_progreso").addClass('progress-bar-success');
                            }else{
                                $("#barra_progreso").removeClass('progress-bar-success');
                                $("#barra_progreso").addClass('progress-bar-morado');
                            }

                            if(porcentaje >= 10){
                                $('#estrella_1').addClass('active')
                            }else{
                                $('#estrella_1').removeClass('active')
                            }

                            if(porcentaje >= 20){
                                $('#estrella_2').addClass('active')
                            }else{
                                $('#estrella_2').removeClass('active')
                            }

                            if(porcentaje >= 30){
                                $('#estrella_3').addClass('active')
                            }else{
                                $('#estrella_3').removeClass('active')
                            }

                            if(porcentaje >= 40){
                                $('#estrella_4').addClass('active')
                            }else{
                                $('#estrella_4').removeClass('active')
                            }

                            if(porcentaje >= 50){
                                $('#estrella_5').addClass('active')
                            }else{
                                $('#estrella_5').removeClass('active')
                            }
                            
                    
                            $('.progreso').text(porcentaje)
                            $('.total').text(respuesta.total_clientes);
                            $('#barra_progreso').css('width',porcentaje+'%')
        
                            $("#text-progreso").text(porcentaje+"%");
                            $("#barra-progreso").css({
                              "width": (porcentaje + "%")
                            });        
                            
                            if(porcentaje<="10"){
                              $("#barra-progreso").css("background-color","red");
                              $("#msj_porcentaje").html("Debe mejorar");
                            }else if(porcentaje<="20"){
                              $("#barra-progreso").css("background-color","orange");
                              $("#msj_porcentaje").html("Bueno");
                            }else if(porcentaje<="30"){
                              $("#barra-progreso").css("background-color","gold");
                              $("#msj_porcentaje").html("Muy bueno");
                            }else{
                              $("#barra-progreso").css("background-color","green");
                              $("#msj_porcentaje").html("Excelente");
                            }
    

                            datos = JSON.parse(JSON.stringify(respuesta));

                            $("#mujeres").text(datos.mujeres);
                            $("#hombres").text(datos.hombres);
                            $(".total_visitantes").text(datos.total_visitantes);

                            $("#adultos").text(datos.adultos);
                            $("#niños").text(datos.niños);

                            $("#entre_semana").text(datos.entre_semana);
                            $("#fines_de_semana").text(datos.fines_de_semana);
                            $("#ambos").text(datos.ambos);
                            $("#total_dias_clase").text(datos.total_dias_clase);

                            $(".flot-chart").html('');
                            $(".flc-pie").html('');


                            var pieData1 = ''
                            pieData1 += '[';
                            $.each( datos.conociste, function( i, item ) {
                                var label = item[0];
                                var cant = item[1];
                                pieData1 += '{"data":"'+cant+'","label":"'+label+'"},';
                            });
                            pieData1 = pieData1.substring(0, pieData1.length -1);
                            pieData1 += ']';

                            $.plot('#pie-chart-entero', $.parseJSON(pieData1), {
                                series: {
                                    pie: {
                                        show: true,
                                        stroke: { 
                                            width: 2,
                                        },
                                    },
                                },
                                legend: {
                                    container: '#flc-pie-entero',
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

                            // --

                            var pieData2 = ''
                            pieData2 += '[';
                            $.each( datos.edades, function( i, item ) {
                                var label = item[0];
                                var cant = item[1];
                                pieData2 += '{"data":"'+cant+'","label":"'+label+'"},';
                            });
                            pieData2 = pieData2.substring(0, pieData2.length -1);
                            pieData2 += ']';

                            $.plot('#pie-chart-edades', $.parseJSON(pieData2), {
                                series: {
                                    pie: {
                                        show: true,
                                        stroke: { 
                                            width: 2,
                                        },
                                    },
                                },
                                legend: {
                                    container: '#flc-pie-edades',
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

                            // --

                            var pieData3 = ''
                            pieData3 += '[';
                            $.each( datos.dias, function( i, item ) {
                                var label = item[0];
                                var cant = item[1];
                                pieData3 += '{"data":"'+cant+'","label":"'+label+'"},';
                            });
                            pieData3 = pieData3.substring(0, pieData3.length -1);
                            pieData3 += ']';

                            $.plot('#pie-chart-dias', $.parseJSON(pieData3), {
                                series: {
                                    pie: {
                                        show: true,
                                        stroke: { 
                                            width: 2,
                                        },
                                    },
                                },
                                legend: {
                                    container: '#flc-pie-dias',
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

  

                            finprocesado();

                            notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                      }, 1000);
                    },

                    error:function(msj){
                        setTimeout(function(){ 
                            // if (typeof msj.responseJSON === "undefined") {
                            //   window.location = "{{url('/')}}/error";
                            // }
                            if(msj.responseJSON.status=="ERROR"){
                              errores(msj.responseJSON.errores);
                              var nTitle="    Ups! "; 
                              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                            }else{
                              var nTitle="   Ups! "; 
                              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                            }
                            var nType = 'danger';          
                            finprocesado();            
                            notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
                        }, 1000);
                    }
            });

        });

    function errores(merror){

      var elemento="";
      var contador=0;
      $.each(merror, function (n, c) {
          if(contador==0){
          elemento=n;
          }
          contador++;

           $.each(this, function (name, value) {              
              var error=value;
              $("#error-linea_mensaje").html(error);             
           });
        });       

    }

     function previa(t){
        var id = $(t).closest('tr').attr('id');
        var route =route_detalle+"/"+id;
        window.open(route, '_blank');;
      }

    function collapse_minus(collaps){
        $('#'+collaps).collapse('hide');
    }   

    $('#collapseTwo').on('show.bs.collapse', function () {
        $("#boolean_fecha").val('1');
        $("#tipo").attr('disabled',true);
        $("#tipo").addClass('disabled');
        $("#tipo").selectpicker('refresh');
        setTimeout(function(){ 
            $("#fecha").click();
        }, 500);
    })

    $('#collapseTwo').on('hide.bs.collapse', function () {
        $("#tipo").attr('disabled',false);
        $("#tipo").removeClass('disabled');
        $("#tipo").selectpicker('refresh');
        $("#boolean_fecha").val('0');
    })

    $('#tablelistar tbody').on( 'click', 'i.encuesta', function () {
        var id = $(this).closest('tr').attr('id');
        var route =route_encuesta+id;
        window.open(route, '_blank');
    });

</script>

@stop