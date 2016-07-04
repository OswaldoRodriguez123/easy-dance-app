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

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="f-20 f-500">Solo me fio de las estadisticas que he manipulado. (Winston Churchill)</div>
                        </div>
                        <div class="card-body card-padding">
                            <div class="f-16 text-justify">Te mantendremos informado durante tu periodo en Easy Dance y nos aseguraremos de brindarte la información que necesitas para el crecimiento de tu academia.</div>
                        </div>
                    </div>    
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body card-padding">

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

                            <!--<a class="btn-blanco m-r-10 f-25" id="personalizar"> Personalizar <i class="zmdi zmdi-calendar"></i></a>-->

                        </div>
                    </div>                        
                </div>
    
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="f-22 f-300 text-center">Informes de Procesos de Inscripcion</div>
                        </div>
                    </div>    
                </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h2>Procesos de Inscripcion</h2>
                                <hr>
                                <ul class="actions">
                                    <li class="dropdown action-show">
                                        <a href="#" data-toggle="dropdown">
                                            <i class="zmdi zmdi-more-vert"></i>
                                        </a>
                        
                                        <div class="dropdown-menu pull-right">
                                            <p class="p-20">
                                                You can put anything here
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="card-body card-padding">
                                <div id="pie-chart-procesos" class="flot-chart-pie"></div>
                                <div class="flc-pie hidden-xs"></div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h2>Información</h2>
                                <hr>

                                
                                <div class="col-md-3">    
                                    <i class="zmdi zmdi-male zmdi-hc-5x c-azul"></i>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3">    
                                    <i class="m-l-25 zmdi zmdi-female zmdi-hc-5x c-rosado"></i>
                                </div>
                                <div class="clearfix"></div>    

                                <div class="mini-charts-item bgm-lightgreen"">
                                    <div class="clearfix">
                                        <div class="chart chart-pie stats-pie"></div>
                                        <div class="count">
                                            <small>Percentage</small>
                                            <h2>99.87%</h2>
                                        </div>
                                    </div>
                                </div>

                                <ul class="actions">
                                    <li class="dropdown action-show">
                                        <a href="#" data-toggle="dropdown">
                                            <i class="zmdi zmdi-more-vert"></i>
                                        </a>
                        
                                        <div class="dropdown-menu pull-right">
                                            <p class="p-20">
                                                You can put anything here
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            

                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h2>Procesos de Inscripcion</h2>
                                <ul class="actions">
                                    <li class="dropdown action-show">
                                        <a href="#" data-toggle="dropdown">
                                            <i class="zmdi zmdi-more-vert"></i>
                                        </a>
                        
                                        <div class="dropdown-menu pull-right">
                                            <p class="p-20">
                                                You can put anything here
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>        
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h2>Procesos de Inscripcion</h2>
                                <ul class="actions">
                                    <li class="dropdown action-show">
                                        <a href="#" data-toggle="dropdown">
                                            <i class="zmdi zmdi-more-vert"></i>
                                        </a>
                        
                                        <div class="dropdown-menu pull-right">
                                            <p class="p-20">
                                                You can put anything here
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="card-body card-padding">


                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <!--<th class="text-center" data-column-id="id" data-type="numeric">Id</th>
                                    <th class="text-center" data-column-id="sexo">Sexo</th>-->
                                    <th class="text-center" data-column-id="fecha" data-order="desc">Fecha</th>                                 
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                    <th class="text-center" data-column-id="apellido" data-order="desc">Apellido</th>
                                    <th class="text-center" data-column-id="ContactoMovil" data-order="desc">Contacto Movil</th>
                                    <th class="text-center" data-column-id="especialidad" data-order="desc" >Especialidad</th>
                                    <th class="text-center" data-column-id="curso" data-order="desc" >Curso</th>                                    
                                </tr>
                            </thead>
                            <tbody class="text-center" >
                            </tbody>
                            </table>


                            </div>
                        </div>
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