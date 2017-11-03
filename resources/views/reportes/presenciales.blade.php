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
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-accounts f-25"></i> Reporte de Presenciales</p>
                            <hr class="linea-morada">
                                                         
                        </div>

                        <div class="col-sm-12">
                            <form name="formFiltro" id="formFiltro">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" id="boolean_fecha" name="boolean_fecha" value="0">

                                <div class="col-md-4">
                                    <label>Promotor</label>
                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="instructor_id" id="instructor_id">
                                          <option value="0">Todos</option>
                                          @foreach ( $promotores as $promotor )
                                            <option value = "{{ $promotor->id }}"> {{ $promotor->nombre }} {{ $promotor->apellido }}</option>

                                          @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Sexo</label>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="sexo" id="sexo">
                                          <option value="0">Todos</option>
                                          <option value="M">Masculino</option>
                                          <option value="F">Femenino</option>
                                        </select>
                                      </div>
                                    </div>                          
                                </div>

                                <div class="col-md-4">
                                    <label>¿Cómo se enteró?</label>
                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="como_nos_conociste_id" id="como_nos_conociste_id">
                                          <option value="0">Todos</option>
                                          @foreach ( $como_nos_conociste as $como_se_entero )
                                            <option value = "{{ $como_se_entero->id }}"> {{ $como_se_entero->nombre }}</option>

                                          @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="clearfix m-b-20"></div>

                                <div class="col-md-4">
                                    <label>Especialidad de interés</label>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" id="especialidad_id" name="especialidad_id">
                                          <option value="0">Todos</option>
                                          @foreach ( $especialidades as $especialidad )
                                          <option value = "{{ $especialidad['id'] }}">{{ $especialidad['nombre'] }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Días de interés</label>

                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="dias_clase_id" id="dias_clase_id" data-live-search="true">
                                          <option value="0">Todos</option>
                                          @foreach ( $dias_de_semana as $dias )
                                            <option value = "{{ $dias['id'] }}">{{ $dias['nombre'] }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Tipo de Interes</label>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="interes_id" id="interes_id">
                                          <option value="0">Todos</option>
                                          <option value="1">Adulto</option>
                                          <option value="2">Niño</option>
                                        </select>
                                      </div>
                                    </div>                          
                                </div>

                                <div class="clearfix m-b-20"></div>

                                <div class="col-md-4">
                                    <label>Perfil del Cliente</label>

                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="tipologia_id" id="tipologia_id" data-live-search="true">
                                          <option value="0">Todos</option>
                                          @foreach ( $tipologias as $tipologia )
                                            <option value = "{{ $tipologia->id }}">{{ $tipologia->nombre }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <label>Fecha</label> &nbsp; &nbsp; &nbsp;
                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="tipo" id="tipo">
                                            <option value="1">Hoy</option>
                                            <option value="2">Mes Actual</option>
                                            <option value="3">Mes Pasado</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
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
                                



                                 <!-- <div class="clearfix m-b-10"></div> -->

                                 

                                 <button type="button" class="btn btn-blanco m-r-10 f-10 guardar" id="guardar" >Filtrar</button>

                                <div class ="clearfix m-b-10"></div>
                                <div class ="clearfix m-b-10"></div>

                            </form>
                        </div>

                        <div class="clearfix"></div>

                       
                        <div class="col-md-4">

                            <table class="table display cell-border" id="promotores">
                                <thead>
                                    <tr>
                                        <th class="text-center" data-column-id="promotores">Promotores</th>
                                        <th class="text-center" data-column-id="cantidad"></th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <tr>
                                        <td>
                                            <span style="padding-left: 3%">Total</span>
                                        </td>

                                        <td>
                                            <span style="padding-left: 3%">0</span>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6 col-md-offset-2">

                            <div class="text-center">
                                <div class="text-center f-700" >Porcentaje de Efectividad</div>
                                <hr class="linea-morada opaco-0-8">

                                <div class="progress progress-striped m-b-10" style="border:1px solid; color:#4E1E43">
                                    <div class="progress-bar progress-bar-morado" id="barra_progreso" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                </div>
                                <span class="f-700"><span class="progreso">0</span>% de Efectividad con <span class="total">0</span> inscritos</span>

                                 <div class="rating-list text-center">

                                      <br>
                                      <div class="rl-star">

                                        <i id="estrella_1" class="zmdi zmdi-star"></i>
                                        <i id="estrella_2" class="zmdi zmdi-star"></i>
                                        <i id="estrella_3" class="zmdi zmdi-star"></i>
                                        <i id="estrella_4" class="zmdi zmdi-star"></i>
                                        <i id="estrella_5" class="zmdi zmdi-star"></i>
                                          
                                      </div>
                                  </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-4" style="margin-top: 11%">


                            <table class="table display cell-border" id="mujeres_hombres">
                                <thead>
                                    <tr>
                                        <th class="text-center" data-column-id="mujeres_hombres">Interesado en clases para:</th>
                                        <th class="text-center" data-column-id="cantidad"></th>
                                    </tr>
                                </thead>

                                <tbody>


                                    <tr>
                                        <td>
                                            <span style="padding-left: 3%"><i class="zmdi zmdi-female c-rosado f-25" style="padding-right: 2%"></i></span>
                                        </td>

                                        <td>
                                            <span style="padding-left: 3%" id="mujeres">0</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <span style="padding-left: 3%"><i class="zmdi zmdi-male-alt c-azul f-25" style="padding-right: 2%"></i></span>
                                        </td>

                                        <td>
                                            <span style="padding-left: 3%" id="hombres">0</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <span style="padding-left: 3%">Total</span>
                                        </td>

                                        <td>
                                            <span style="padding-left: 3%" class="total_visitantes" id="total_visitantes">0</span>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6 col-md-offset-2">
                         
                            <h2 class="text-center">Informe de Como se enteró</h2>
                            <hr>
                            <div id="pie-chart-entero" class="flot-chart"></div>
                            <div  id="flc-pie-entero" class="flc-pie hidden-xs"></div>
                        </div>


                        <div class="clearfix"></div>

                        <div class="col-md-4" style="margin-top: 11%">

                            <table class="table display cell-border" id="adultos_niños" >
                                <thead>
                                    <tr>
                                        <th class="text-center" data-column-id="adultos_niños">Interesado en clases para:</th>
                                        <th class="text-center" data-column-id="cantidad"></th>
                                    </tr>
                                </thead>

                                <tbody>


                                    <tr>
                                        <td>
                                            <span style="padding-left: 3%">Adultos</span>
                                        </td>

                                        <td>
                                            <span style="padding-left: 3%" id="adultos">0</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <span style="padding-left: 3%">Niños</span>
                                        </td>

                                        <td>
                                            <span style="padding-left: 3%" id="niños">0</span>
                                        </td>
                                    </tr>



                                    <tr>
                                        <td>
                                            <span style="padding-left: 3%">Total</span>
                                        </td>

                                        <td>
                                            <span style="padding-left: 3%" class ="total_visitantes" id="total_visitantes">0</span>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6 col-md-offset-2">

                            <h2 class="text-center">Informe por Edades</h2>
                            <hr>
                            <div id="pie-chart-edades" class="flot-chart"></div>
                            <div  id="flc-pie-edades" class="flc-pie hidden-xs"></div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-4" style="margin-top: 11%">

                            <table class="table display cell-border" id="dias_de_clase" >
                                <thead>
                                    <tr>
                                        <th class="text-center" data-column-id="dias_de_clase">Interesados en los días de  clases  :</th>
                                        <th class="text-center" data-column-id="cantidad"></th>
                                    </tr>
                                </thead>

                                <tbody>


                                    <tr>
                                        <td>
                                            <span style="padding-left: 3%">Entre Semana</span>
                                        </td>

                                        <td>
                                            <span style="padding-left: 3%" id="entre_semana">0</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <span style="padding-left: 3%">Fines de Semana</span>
                                        </td>

                                        <td>
                                            <span style="padding-left: 3%" id="fines_de_semana">0</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <span style="padding-left: 3%">Ambos</span>
                                        </td>

                                        <td>
                                            <span style="padding-left: 3%" id="ambos">0</span>
                                        </td>
                                    </tr>



                                    <tr>
                                        <td>
                                            <span style="padding-left: 3%">Total</span>
                                        </td>

                                        <td>
                                            <span style="padding-left: 3%" id="total_dias_clase">0</span>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                        </div>
                        
                        <div class="col-md-6 col-md-offset-2">

                            <h2 class="text-center">Informe de Dias de clase</h2>
                            <hr>
                            <div id="pie-chart-dias" class="flot-chart"></div>
                            <div  id="flc-pie-dias" class="flc-pie hidden-xs"></div>

                        </div>

                        <div class ="clearfix"></div>

                        <div class="table-responsive row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered text-center " id="tablelistar" >
                                    <thead>
                                        <tr>
                                            <th class="text-center" data-column-id="cliente" id="cliente">Cli</th>
                                            <th class="text-center" data-column-id="fecha">Fecha</th>
                                            <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                            <th class="text-center" data-column-id="apellido" data-order="desc">Apellido</th>
                                            <th class="text-center" data-column-id="sexo" data-order="desc">Sexo</th>
                                            <th class="text-center" data-column-id="celular">Contacto Móvil</th>
                                            <th class="text-center" data-column-id="especialidad">Especialidad</th>
                                            <th class="text-center" data-column-id="acciones">Operaciones</th>
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


                        <nav class="navbar navbar-default navbar-fixed-bottom">
                            <div class="container">
                                <div class="col-xs-1 p-t-15 f-700 text-center" id="text-progreso" >0%</div>
                                <div class="col-xs-11">
                                    <div class="clearfix p-b-20"></div>
                                    <div class="progress-fino progress-striped m-b-10">
                                        <div class="progress-bar progress-bar-morado" id="barra-progreso" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                        <div class="clearfix"></div>
                                        <input type="hidden" name="barra_de_progreso" id="barra_de_progreso">
                                        <div id="msj_porcentaje" class="m-b-20 m-l-25" style="text-align: center">0% de inscritos</div>
                                    </div>
                                </div>
                            </div>
                        </nav>
                        
                        
                    </div>
                    
                    
                </div>
            </section>

            <button class="btn btn-float bgm-red m-btn" data-action="print"><i class="zmdi zmdi-print"></i></button>
@stop

@section('js') 
            
    <script type="text/javascript">

        var pagina = document.location.origin

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
              $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6)', nRow).addClass( "text-center" );
              $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6)', nRow).attr( "onclick","previa(this)" );
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

                                // if(array.rapidez != 0 || array.calidad != 0 || array.satisfaccion != 0 || array.disponibilidad != 0){
                                //     accion = '<i class="icon_a-examen f-20 boton blue sa-warning pointer encuesta" data-original-title="" data-content="Ver Encuesta" data-toggle="popover" data-placement="top" title="" type="button" data-trigger="hover"></i>'
                                // }else{
                                //     accion = ''
                                // }

                                operacion = ''

                                operacion += '<ul class="top-menu">'
                                operacion += '<li id = dropdown_'+array.id+' class="dropdown">' 
                                operacion += '<a id = dropdown_toggle_'+array.id+' href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft">' 
                                operacion += '<span class="f-15 f-700" style="color:black">'
                                operacion += '<i class="zmdi zmdi-wrench f-20 mousedefault" data-toggle="popover" data-placement="top" title="" type="button" data-original-title="" data-content=""></i>'
                                operacion += '</span></a>'
                                operacion += '<div class="dropup">'
                                operacion += '<ul class="dropdown-menu dm-icon pull-right" style="position:absolute;">'

                                if(array.correo){
                                  operacion += '<li class="hidden-xs email">'
                                  operacion += '<a onclick="procesando()">'
                                  operacion += '<i class="zmdi zmdi-email f-16 boton blue"></i>'
                                  operacion += 'Enviar Correo'
                                  operacion += '</a></li>'
                                }

                                operacion += '<li class="hidden-xs">'
                                operacion += '<a onclick="procesando()" href="'+pagina+'/participante/visitante/impresion/'+array.id+'">'
                                operacion += '<i class="zmdi icon_a-examen f-20 boton blue"></i>'
                                operacion += 'Realizar encuesta'
                                operacion += '</a></li>'

                                operacion += '<li class="hidden-xs">'
                                operacion += '<a onclick="procesando()" href="'+pagina+'/participante/alumno/agregar/'+array.id+'">'
                                operacion += '<i class="zmdi zmdi-trending-up f-20 boton blue"></i>'
                                operacion += 'Transferir'
                                operacion += '</a></li>'

                                operacion += '<li class="hidden-xs">'
                                operacion += '<a onclick="procesando()" href="'+pagina+'/participante/visitante/llamadas/'+array.id+'">'
                                operacion += '<i class="zmdi zmdi-phone f-20 boton blue"></i>'
                                operacion += 'Llamadas'
                                operacion += '</a></li>'

                                operacion += '<li class="hidden-xs reservar">'
                                operacion += '<a onclick="procesando()">'
                                operacion += '<i class="zmdi icon_a-reservaciones f-16 boton blue"></i>'
                                operacion += 'Reservar'
                                operacion += '</a></li>'

                                operacion += '<li class="hidden-xs eliminar"><a class="pointer eliminar">'
                                operacion += '<i class="zmdi zmdi-delete boton red f-20 boton red sa-warning"></i>'
                                operacion += 'Eliminar'
                                operacion += '</a></li>'
                                operacion += '</ul></div></li></ul>'

                                var rowNode=t.row.add( [
                                ''+cliente+'',
                                ''+array.fecha_registro+'',
                                ''+array.nombre+'',
                                ''+array.apellido+'',
                                ''+sexo+'',
                                ''+array.celular+'',
                                ''+array.especialidad+'',
                                ''+operacion+'',
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

    $('#tablelistar tbody').on('click', '.email', function(){

      var route = route_email;
      var token = '{{ csrf_token() }}';
      var id = $(this).closest('tr').attr('id');
          
          $.ajax({
              url: route,
                  headers: {'X-CSRF-TOKEN': token},
                  type: 'POST',
              dataType: 'json',
              data:"&usuario_tipo=3&usuario_id="+id,
              success:function(respuesta){

                  procesando();
                  window.location="{{url('/')}}/correo/"+id   

              },
              error:function(msj){
                          // $("#msj-danger").fadeIn(); 
                          // var text="";
                          // console.log(msj);
                          // var merror=msj.responseJSON;
                          // text += " <i class='glyphicon glyphicon-remove'></i> Por favor verifique los datos introducidos<br>";
                          // $("#msj-error").html(text);
                          // setTimeout(function(){
                          //          $("#msj-danger").fadeOut();
                          //         }, 3000);
                          swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                          }
          });
      });

      $('#tablelistar tbody').on('click', '.reservar', function(){

        procesando();
        var route = "{{url('/')}}/reservacion/guardar-tipo-usuario/2";
        var token = '{{ csrf_token() }}';
        var id = $(this).closest('tr').attr('id');
            
        $.ajax({
            url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
            dataType: 'json',
            success:function(respuesta){
                window.location = "{{url('/')}}/reservaciones/actividades/"+id

            },
            error:function(msj){
                        // $("#msj-danger").fadeIn(); 
                        // var text="";
                        // console.log(msj);
                        // var merror=msj.responseJSON;
                        // text += " <i class='glyphicon glyphicon-remove'></i> Por favor verifique los datos introducidos<br>";
                        // $("#msj-error").html(text);
                        // setTimeout(function(){
                        //          $("#msj-danger").fadeOut();
                        //         }, 3000);
                        finprocesado();
                        swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                        }
        });
    })

    $('#tablelistar tbody').on('click', '.eliminar', function(){
            var id = $(this).closest('tr').attr('id');
            swal({   
                title: "Desea eliminar al visitante?",   
                text: "Confirmar eliminación!",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Eliminar!",  
                cancelButtonText: "Cancelar",         
                closeOnConfirm: true 
            }, function(isConfirm){   
      if (isConfirm) {
        var route = route_eliminar + id;
        var token = '{{ csrf_token() }}';
            
            $.ajax({
                url: route,
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'DELETE',
                dataType: 'json',
                data:id,
                success:function(respuesta){

                    procesando();
                    window.location = route_principal; 

                },
                error:function(msj){
                            // $("#msj-danger").fadeIn(); 
                            // var text="";
                            // console.log(msj);
                            // var merror=msj.responseJSON;
                            // text += " <i class='glyphicon glyphicon-remove'></i> Por favor verifique los datos introducidos<br>";
                            // $("#msj-error").html(text);
                            // setTimeout(function(){
                            //          $("#msj-danger").fadeOut();
                            //         }, 3000);
                            swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                            }
            });
            }
        });
    });

    $('#tablelistar tbody').on('mouseenter', 'a.dropdown-toggle', function () {

      var id = $(this).closest('tr').attr('id');
      var dropdown = $(this).closest('.dropdown')
      var dropdown_toggle = $(this).closest('.dropdown-toggle')

      $('.dropdown-toggle').attr('aria-expanded','false')
      $('.dropdown').removeClass('open')
      $('.table-responsive').css( "overflow", "auto" );

      if(!dropdown.hasClass('open')){
          dropdown.addClass('open')
          dropdown_toggle.attr('aria-expanded','true')
          $('.table-responsive').css( "overflow", "inherit" );
      }
   
    });

    $('.table-responsive').on('hide.bs.dropdown', function () {
      $('.table-responsive').css( "overflow", "auto" );
    }) 

</script>

@stop