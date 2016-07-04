@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/nouislider/distribute/jquery.nouislider.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">


@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/nouislider/distribute/jquery.nouislider.all.min.js"></script>
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
                        <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menú Principal</a>
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 

            <div class="card">

            <div class="card-header">
                    <div class="col-md-12">
                            <ul class="tab-nav tn-justified" role="tablist">
                                    <li class="waves-effect"><a href="{{url('/')}}/administrativo/pagos/generar" aria-controls="home11" onclick="procesando()"><div class="icon_a icon_a-pagar f-30"></div><p style=" margin-bottom: -2px;">Pagos</p></a></li>
                                    <li class="waves-effect"><a href="{{url('/')}}/administrativo/acuerdos/generar" aria-controls="home11" onclick="procesando()"><div class="icon_a icon_a-acuerdo-de-pago f-30"></div><p style=" margin-bottom: -2px;">Acuerdos</p></a></li>
                                    <li class="waves-effect"><a href="{{url('/')}}/administrativo/presupuestos/generar" aria-controls="home11" onclick="procesando()"><div class="icon_a icon_a-presupuesto f-30"></div><p style=" margin-bottom: -2px;">Presupuestos</p></a></li>
                                    <li class="waves-effect active"><a href="{{url('/')}}/reportes" aria-controls="home11" onclick="procesando()"><div class="icon_d icon_d-reporte f-30"></div><p style=" margin-bottom: -2px;">Reportes</p></a></li>
                                    
                            </ul>
                            </div>
                        </div> 

                        <div class="clearfix p-b-15"></div>
                
                <div class="card-header">
                    <div class="col-md-8" style="border-right: 1px solid #CCC !important;">

                        <div class="f-22 f-500">Solo me fio de las estadisticas que he manipulado. (Winston Churchill)</div>

                        <div class="clearfix p-b-15"></div>
                    
                        <div class="f-16 text-justify">Te mantendremos informado durante tu periodo en Easy Dance y nos aseguraremos de brindarte la información que necesitas para el crecimiento de tu academia.</div>
     
                    </div>

                    <div class="col-md-4">
                        <div class="checkbox m-b-15">
                            <label>
                                Mes Actual
                                <input type="checkbox" value="">
                                <i class="input-helper"></i>                                    
                            </label>
                        </div>

                        <div class="checkbox m-b-15">
                            <label>
                                Mes Pasado
                                <input type="checkbox" value="">
                                <i class="input-helper"></i>                                    
                            </label>
                        </div>

                        <div class="checkbox m-b-15">
                            <label>
                                Hoy
                                <input type="checkbox" value="">
                                <i class="input-helper"></i>                                    
                            </label>
                        </div>                            

                        <div class="input-group">
                            <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                            <div class="fg-line">
                                    <input type="text" id="personalizar" class="form-control" placeholder="Personalizar">
                            </div>
                        </div>

                    </div>
                    <div class="clearfix"></div>
                </div>

    
                <div class="card-body card-padding">
                    

                <div class="col-md-12">

                    <hr>
                    <div class="f-30 f-500 text-center">Informes de Procesos Administrativos</div>
                    <hr>
                </div>
                    <div class="col-md-6" style="border-right: 1px solid #CCC !important;">
                        
                        

                        <div class="f-22 f-200 text-center">Procesos de Inscripcion</div>
                        <!-- <hr> -->
                        <br>
                    
                        <div id="pie-chart-procesos" class="flot-chart-pie"></div>
                        <div class="flc-pie hidden-xs"></div>

                    </div>


                    <div class="col-md-6">
                        <div class="f-22 f-200 text-center">Información</div>
                        <!-- <hr> -->
                        <br>
                        
                        <div class="col-md-3">    
                            <i class="zmdi zmdi-male zmdi-hc-5x c-azul"></i>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3">    
                            <i class="m-l-25 zmdi zmdi-female zmdi-hc-5x c-rosado"></i>
                        </div>
                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>   

                        <div class="mini-charts-item bgm-lightgreen"">
                            <div class="clearfix">
                                <div class="chart chart-pie stats-pie"></div>
                                <div class="count">
                                    <small>Percentage</small>
                                    <h2>99.87%</h2>
                                </div>
                            </div>
                        </div>
                            
                    </div>

    
                    <div class="clearfix"></div>

                    <div class="col-md-12">
                        <br><br>
                            <div class="f-22 f-200 text-center">Informe Administrativo</div>

                            <div class="card-body card-padding">


                                <table class="table table-striped table-bordered text-center " id="tablelistar" >
                                <thead>
                                    <tr>
                                        <!--<th class="text-center" data-column-id="id" data-type="numeric">Id</th>
                                        <th class="text-center" data-column-id="sexo">Sexo</th>-->
                                        <th class="text-center" data-column-id="fecha" data-order="desc">Fecha</th>                                 
                                        <th class="text-center" data-column-id="Cliente" data-order="desc">Cliente</th>
                                        <th class="text-center" data-column-id="Factura" data-order="desc">Factura</th>
                                        <th class="text-center" data-column-id="Descripción" data-order="desc">Descripción</th>
                                        <th class="text-center" data-column-id="Cantidad" data-order="desc" >Cantidad</th>
                                        <th class="text-center" data-column-id="Haber" data-order="desc" >Haber</th>
                                        <th class="text-center" data-column-id="Total" data-order="desc" >Total</th>                                   
                                    </tr>
                                </thead>
                                <tbody class="text-center" >
                                </tbody>
                                </table>

                            </div>
                        
                    </div>


                </div>


            <div class="clearfix"></div>    
            </div>




                
            </div>

        </section>


@stop


@section('js') 

<script>

$(document).ready(function() {
    

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



        var pieData = [
            {data: 1, color: '#F44336', label: '3-10'},
            {data: 2, color: '#03A9F4', label: '11-20'},
            {data: 3, color: '#8BC34A', label: '21-35'},
            {data: 4, color: '#FFEB3B', label: '36-50'},
            {data: 4, color: '#009688', label: '51+'},
        ];

        $.plot('#pie-chart-procesos', pieData, {
            series: {
                pie: {
                    show: true,
                    stroke: { 
                        width: 2,
                    },
                },
            },
            legend: {
                container: '.flc-pie',
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
            }
            
        });


});




</script>


@stop