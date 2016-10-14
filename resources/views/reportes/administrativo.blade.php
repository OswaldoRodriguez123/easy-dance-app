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
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 
                    
                    <div class="card">

                    <div class="card-header">
                    <div class="col-md-12">
                            <ul class="tab-nav tn-justified" role="tablist">
                                    <li class="waves-effect"><a href="{{url('/')}}/administrativo/pagos/generar" aria-controls="home11" onclick="procesando()"><div class="icon_a icon_a-pagar f-30"></div><p style=" margin-bottom: -2px;">Pagos</p></a></li>
                                    <li class="waves-effect"><a href="{{url('/')}}/administrativo/acuerdos/generar" aria-controls="home11" onclick="procesando()"><div class="icon_a icon_a-acuerdo-de-pago f-30"></div><p style=" margin-bottom: -2px;">Acuerdos</p></a></li>
                                    <li class="waves-effect"><a href="{{url('/')}}/administrativo/presupuestos/generar" aria-controls="home11" onclick="procesando()"><div class="icon_a icon_a-presupuesto f-30"></div><p style=" margin-bottom: -2px;">Presupuestos</p></a></li>
                                    <li class="waves-effect active"><a href="{{url('/')}}/reportes/administrativo" aria-controls="home11" onclick="procesando()"><div class="icon_d icon_d-reporte f-30"></div><p style=" margin-bottom: -2px;">Reportes</p></a></li>
                                    
                            </ul>
                            </div>
                        </div> 

                        <div class="clearfix p-b-15"></div>

                        <div class="card-header">

                            <div class="col-md-8">
                                <div class="f-20 f-500">Solo me fio de las estadisticas que he manipulado. (Winston Churchill)</div>                            
                                <div>
                                    <div class="f-16 text-justify">Te mantendremos informado durante tu periodo en Easy Dance y nos aseguraremos de brindarte la información que necesitas para el crecimiento de tu academia.</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="checkbox m-b-15">
                                    <label>
                                        Mes Actual
                                        <input type="checkbox" value="" id="actual_month" name="actual_month">
                                        <i class="input-helper"></i>
                                        <input type="hidden" name="mes_actual" id="mes_actual">                             
                                    </label>
                                </div>

                                <div class="checkbox m-b-15">
                                    <label>
                                        Mes Pasado
                                        <input type="checkbox" value="" id="past_month">
                                        <i class="input-helper"></i>                                    
                                    </label>
                                </div>

                                <div class="checkbox m-b-15">
                                    <label>
                                        Hoy
                                        <input type="checkbox" value="" id="today">
                                        <i class="input-helper"></i>                                    
                                    </label>
                                </div>                            

                                <div class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                    <div class="fg-line">
                                            <input type="text" id="personalizar" class="form-control" placeholder="Personalizar">
                                    </div>
                                </div>

                                <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                      <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="meses" id="meses" data-live-search="true">

                                          <option value="01/01/2016-31/01/2016">Enero</option>
                                          <option value="01/02/2016-31/02/2016">Febrero</option>
                                          <option value="01/03/2016-31/03/2016">Marzo</option>
                                          <option value="01/04/2016-31/04/2016">Abril</option>
                                          <option value="01/05/2016-31/05/2016">Mayo</option>
                                          <option value="01/06/2016-31/06/2016">Junio</option>
                                          <option value="01/07/2016-31/07/2016">Julio</option>
                                          <option value="01/08/2016-31/08/2016">Agosto</option>
                                          <option value="01/09/2016-31/09/2016">Septiembre</option>
                                          <option value="01/10/2016-31/10/2016">Octubre</option>
                                          <option value="01/11/2016-31/11/2016">Noviembre</option>
                                          <option value="01/12/2016-31/12/2016">Diciembre</option>
                                        
                                        </select>
                                      </div>
                                    </div>
                                </div>
                                <!--<a class="btn-blanco m-r-10 f-25" id="personalizar"> Personalizar <i class="zmdi zmdi-calendar"></i></a>-->
                            </div>

                        </div><!-- CARD HEADER 1 -->

                       <!--  <div class="col-md-6">
                            <h2>Procesos de Inscripcion</h2>
                            <hr>
                            <div id="pie-chart-procesos" class="flot-chart-pie"></div>
                            <div class="flc-pie hidden-xs"></div>

                        </div> -->


                        <!-- <div class="col-md-6">
                            <h2>Información</h2>
                            <hr>

                            <div class="col-md-3">    
                                <i class="m-l-25 zmdi zmdi-male-alt zmdi-hc-5x c-azul"></i>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3">    
                                <i class="m-r-25 zmdi zmdi-female zmdi-hc-5x c-rosado pull-right"></i>
                            </div>
                            <div class="clearfix"></div>    

                            <div class="mini-charts-item bgm-blue">
                                <div class="clearfix">
                                    <div class="count">
                                        <small>Total Inscritos:</small>
                                        <h2 id="hombres" class="pull-left m-l-30">$hombres}}</h2>
                                        <h2 id="mujeres" class="pull-right m-r-30">$mujeres}}</h2>
                                    </div>
                                </div>
                            </div>

                        </div> -->



                        <div class="clearfix"></div>
                        <div class="clearfix"></div>

                        <div class="card-header text-right">
                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-alumnos f-25"></i> Informe Administrativo</p>
                            <hr class="linea-morada">
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="factura" data-order="asc">&nbsp;&nbsp;#&nbsp;&nbsp;</th>
                                    <th class="text-center" data-column-id="cliente">Cliente</th>
                                    <th class="text-center" data-column-id="concepto">Concepto</th>
                                    <th class="text-center" data-column-id="fecha" id="fecha">Fecha de Vencimiento</th>
                                    <th class="text-center" data-column-id="total">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            {{-- $inscritos --}}
                             @foreach($facturas as $factura)
                                    <?php $id = $factura['id']; ?>

                                    <tr id="{{$id}}" class="seleccion">
                                        <td class="text-center previa">{{str_pad($factura['factura'], 10, "0", STR_PAD_LEFT)}}</td>
                                        <td class="text-center previa">{{$factura['nombre']}}</td>
                                        <td class="text-center previa">{{$factura['concepto']}}</td>
                                        <td class="text-center previa">{{$factura['fecha']}}</td>
                                        <td class="text-center previa">{{ number_format($factura['total'], 2, '.' , '.') }}</td>
                                      
                                    </tr>

                                @endforeach
                                                           
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

    route_filtrar = "{{url('/')}}/reportes/administrativo";
    route_detalle="{{url('/')}}/administrativo/factura";

    var nFrom = $(this).attr('data-from');
    var nAlign = $(this).attr('data-align');
    var nIcons = $(this).attr('data-icon');
    var nType = 'danger';
    var nAnimIn = "animated flipInY";
    var nAnimOut = "animated flipOutY"; 

    $(document).ready(function(){

        $('input[type=checkbox]').change(function()
        {
            if (this.checked)
            {
                $('input[type=checkbox]').not(this).attr('checked',false);
            }
        });

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 50, 
        // paging:false, 
        order: [[0, 'desc']],
        fnDrawCallback: function() {
        if ($('#tablelistar tr').length < 50) {
              $('.dataTables_paginate').hide();
          }
          else{
             $('.dataTables_paginate').show();
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


        /*if($('.chosen')[0]) {
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
        }*/

            //Basic Example
            $("#data-table-basica").bootgrid({
                css: {
                    icon: 'zmdi icon',
                    iconColumns: 'zmdi-view-module',
                    iconDown: 'zmdi-expand-more',
                    iconRefresh: 'zmdi-refresh',
                    iconUp: 'zmdi-expand-less'
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

            $('#meses').on('change', function () {
                var token = $('input:hidden[name=_token]').val();
                var Fecha = $(this).val();
                procesando();
                $.ajax({
                    url: route_filtrar,
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'POST',
                    dataType: 'json',
                    data: { Fecha: Fecha},
                    success:function(respuesta){

                        var nType = 'success';
                        var nTitle="Ups! ";
                        var nMensaje=respuesta.mensaje;

                        // datos = JSON.parse(JSON.stringify(respuesta));
                        //console.log(datos.edades);
                        
                        var nType = 'success';
                        var nTitle="Ups! ";
                        var nMensaje=respuesta.mensaje;

                        t.clear().draw();

                        $.each(respuesta.facturas, function (index, array) {
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

                        // $("#mujeres").text(datos.mujeres);
                        // $("#hombres").text(datos.hombres);

                        // var data1 = ''
                        // data1 += '[';
                        // $.each( datos.edades, function( i, item ) {
                        //     var edad = item.age_range;
                        //     var cant = item.count
                        //     data1 += '{"data":"'+cant+'","label":"'+edad+'"},';
                        // });
                        // data1 = data1.substring(0, data1.length -1);
                        // data1 += ']';
                        //     //GRAFICO FILTRO MES ACTUAL
                        //     $("#pie-chart-procesos").html('');
                        //     $(".flc-pie").html('');
                        //     $.plot('#pie-chart-procesos', $.parseJSON(data1), {
                        //         series: {
                        //             pie: {
                        //                 show: true,
                        //                 stroke: { 
                        //                     width: 2,
                        //                 },
                        //             },
                        //         },
                        //         legend: {
                        //             container: '.flc-pie',
                        //             backgroundOpacity: 0.5,
                        //             noColumns: 0,
                        //             backgroundColor: "white",
                        //             lineWidth: 0
                        //         },
                        //         grid: {
                        //             hoverable: true,
                        //             clickable: true
                        //         },
                        //         tooltip: true,
                        //         tooltipOpts: {
                        //             content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                        //             shifts: {
                        //                 x: 20,
                        //                 y: 0
                        //             },
                        //             defaultTheme: false,
                        //             cssClass: 'flot-tooltip'
                        //         }
                                
                        //     });

                        finprocesado();                       

                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                    }
                });
                
            }); //END CLICK FECHA RANGO


            $(".applyBtn").on("click", function(){
                var token = $('input:hidden[name=_token]').val();
                var fechaInicio = $("input[name=daterangepicker_start]").val();
                var fechaFin = $("input[name=daterangepicker_end]").val();
                procesando();
                $.ajax({
                    url: route_filtrar,
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'POST',
                    dataType: 'json',
                    data: { fechaInicio:fechaInicio, fechaFin:fechaFin, rango : 'rango' },
                    success:function(respuesta){

                        var nType = 'success';
                        var nTitle="Ups! ";
                        var nMensaje=respuesta.mensaje;

                        datos = JSON.parse(JSON.stringify(respuesta));
                        //console.log(datos.edades);

                        t.clear().draw();

                        $.each(respuesta.facturas, function (index, array) {
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

                        // $("#mujeres").text(datos.mujeres);
                        // $("#hombres").text(datos.hombres);

                        // var data1 = ''
                        // data1 += '[';
                        // $.each( datos.edades, function( i, item ) {
                        //     var edad = item.age_range;
                        //     var cant = item.count
                        //     data1 += '{"data":"'+cant+'","label":"'+edad+'"},';
                        // });
                        // data1 = data1.substring(0, data1.length -1);
                        // data1 += ']';
                        //     //GRAFICO FILTRO MES ACTUAL
                        //     $("#pie-chart-procesos").html('');
                        //     $(".flc-pie").html('');
                        //     $.plot('#pie-chart-procesos', $.parseJSON(data1), {
                        //         series: {
                        //             pie: {
                        //                 show: true,
                        //                 stroke: { 
                        //                     width: 2,
                        //                 },
                        //             },
                        //         },
                        //         legend: {
                        //             container: '.flc-pie',
                        //             backgroundOpacity: 0.5,
                        //             noColumns: 0,
                        //             backgroundColor: "white",
                        //             lineWidth: 0
                        //         },
                        //         grid: {
                        //             hoverable: true,
                        //             clickable: true
                        //         },
                        //         tooltip: true,
                        //         tooltipOpts: {
                        //             content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                        //             shifts: {
                        //                 x: 20,
                        //                 y: 0
                        //             },
                        //             defaultTheme: false,
                        //             cssClass: 'flot-tooltip'
                        //         }
                                
                        //     });

                        finprocesado();                       

                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                    }
                });
                
            }); //END CLICK FECHA RANGO



    });
/*****************************************
FILTROS PARA GRAFCAS
*****************************************/
            //FILTRO MES ACTUAL
            $("#mes_actual").val('0');
            $("#actual_month").on('click', function(){
                var token = $('input:hidden[name=_token]').val();
                if ($("#actual_month").is(":checked")){
                    $("#mes_actual").val('1');
                    procesando();
                        $.ajax({
                            url: route_filtrar,
                            headers: {'X-CSRF-TOKEN': token},
                            type: 'POST',
                            dataType: 'json',
                            data: { mesActual: 'mes_actual' },
                            success:function(respuesta){

                                var nType = 'success';
                                var nTitle="Ups! ";
                                var nMensaje=respuesta.mensaje;

                                t.clear().draw();

                                $.each(respuesta.facturas, function (index, array) {
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

                                // datos = JSON.parse(JSON.stringify(respuesta));
                                // //console.log(datos.edades);

                                // $("#mujeres").text(datos.mujeres);
                                // $("#hombres").text(datos.hombres);

                                // var data1 = ''
                                // data1 += '[';
                                // $.each( datos.edades, function( i, item ) {
                                //     var edad = item.age_range;
                                //     var cant = item.count
                                //     data1 += '{"data":"'+cant+'","label":"'+edad+'"},';
                                // });
                                // data1 = data1.substring(0, data1.length -1);
                                // data1 += ']';
                                //     //GRAFICO FILTRO MES ACTUAL
                                //     $("#pie-chart-procesos").html('');
                                //     $(".flc-pie").html('');
                                //     $.plot('#pie-chart-procesos', $.parseJSON(data1), {
                                //         series: {
                                //             pie: {
                                //                 show: true,
                                //                 stroke: { 
                                //                     width: 2,
                                //                 },
                                //             },
                                //         },
                                //         legend: {
                                //             container: '.flc-pie',
                                //             backgroundOpacity: 0.5,
                                //             noColumns: 0,
                                //             backgroundColor: "white",
                                //             lineWidth: 0
                                //         },
                                //         grid: {
                                //             hoverable: true,
                                //             clickable: true
                                //         },
                                //         tooltip: true,
                                //         tooltipOpts: {
                                //             content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                                //             shifts: {
                                //                 x: 20,
                                //                 y: 0
                                //             },
                                //             defaultTheme: false,
                                //             cssClass: 'flot-tooltip'
                                //         }
                                        
                                //     });
                                finprocesado();                       

                                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                            }
                        });
                }else{
                    $("#mes_actual").val('0');
                }
            });//END FILTRO MES ACTUAL


            //FILTRO MES PASADO
            //$("#mes_actual").val('0');
            $("#past_month").on('click', function(){
                var token = $('input:hidden[name=_token]').val();
                if ($("#past_month").is(":checked")){
                    procesando();
                    //$("#mes_actual").val('1');
                        $.ajax({
                            url: route_filtrar,
                            headers: {'X-CSRF-TOKEN': token},
                            type: 'POST',
                            dataType: 'json',
                            data: { mesPasado: 'mes_pasado' },
                            success:function(respuesta){

                                var nType = 'success';
                                var nTitle="Ups! ";
                                var nMensaje=respuesta.mensaje;

                                t.clear().draw();

                                $.each(respuesta.facturas, function (index, array) {
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

                                // datos = JSON.parse(JSON.stringify(respuesta));
                                // //console.log(datos.edades);
                                // $("#mujeres").text(datos.mujeres);
                                // $("#hombres").text(datos.hombres);

                                // var data1 = ''
                                // data1 += '[';
                                // $.each( datos.edades, function( i, item ) {
                                //     var edad = item.age_range;
                                //     var cant = item.count
                                //     data1 += '{"data":"'+cant+'","label":"'+edad+'"},';
                                // });
                                // data1 = data1.substring(0, data1.length -1);
                                // data1 += ']';
                                //     //GRAFICO FILTRO MES ACTUAL
                                //     $("#pie-chart-procesos").html('');
                                //     $(".flc-pie").html('');
                                //     $.plot('#pie-chart-procesos', $.parseJSON(data1), {
                                //         series: {
                                //             pie: {
                                //                 show: true,
                                //                 stroke: { 
                                //                     width: 2,
                                //                 },
                                //             },
                                //         },
                                //         legend: {
                                //             container: '.flc-pie',
                                //             backgroundOpacity: 0.5,
                                //             noColumns: 0,
                                //             backgroundColor: "white",
                                //             lineWidth: 0
                                //         },
                                //         grid: {
                                //             hoverable: true,
                                //             clickable: true
                                //         },
                                //         tooltip: true,
                                //         tooltipOpts: {
                                //             content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                                //             shifts: {
                                //                 x: 20,
                                //                 y: 0
                                //             },
                                //             defaultTheme: false,
                                //             cssClass: 'flot-tooltip'
                                //         }
                                        
                                //     });
                                finprocesado();                       

                                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                            }
                        });
                }else{
                    //$("#mes_actual").val('0');
                }
            });



            //FILTRO HOY
            //$("#mes_actual").val('0');
            $("#today").on('click', function(){
                var token = $('input:hidden[name=_token]').val();
                if ($("#today").is(":checked")){
                    procesando();
                    //$("#mes_actual").val('1');
                        $.ajax({
                            url: route_filtrar,
                            headers: {'X-CSRF-TOKEN': token},
                            type: 'POST',
                            dataType: 'json',
                            data: { today: 'today' },
                            success:function(respuesta){

                                var nType = 'success';
                                var nTitle="Ups! ";
                                var nMensaje=respuesta.mensaje;

                                t.clear().draw();

                                $.each(respuesta.facturas, function (index, array) {
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

                                // datos = JSON.parse(JSON.stringify(respuesta));
                                // //console.log(datos.edades);
                                // $("#mujeres").text(datos.mujeres);
                                // $("#hombres").text(datos.hombres);

                                // var data1 = ''
                                // data1 += '[';
                                // $.each( datos.edades, function( i, item ) {
                                //     var edad = item.age_range;
                                //     var cant = item.count
                                //     data1 += '{"data":"'+cant+'","label":"'+edad+'"},';
                                // });
                                // data1 = data1.substring(0, data1.length -1);
                                // data1 += ']';
                                //     //GRAFICO FILTRO MES ACTUAL
                                //     $("#pie-chart-procesos").html('');
                                //     $(".flc-pie").html('');
                                //     $.plot('#pie-chart-procesos', $.parseJSON(data1), {
                                //         series: {
                                //             pie: {
                                //                 show: true,
                                //                 stroke: { 
                                //                     width: 2,
                                //                 },
                                //             },
                                //         },
                                //         legend: {
                                //             container: '.flc-pie',
                                //             backgroundOpacity: 0.5,
                                //             noColumns: 0,
                                //             backgroundColor: "white",
                                //             lineWidth: 0
                                //         },
                                //         grid: {
                                //             hoverable: true,
                                //             clickable: true
                                //         },
                                //         tooltip: true,
                                //         tooltipOpts: {
                                //             content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                                //             shifts: {
                                //                 x: 20,
                                //                 y: 0
                                //             },
                                //             defaultTheme: false,
                                //             cssClass: 'flot-tooltip'
                                //         }
                                        
                                //     });
                                finprocesado();                       

                                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                            }
                        });
                }else{
                    //$("#mes_actual").val('0');
                }
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