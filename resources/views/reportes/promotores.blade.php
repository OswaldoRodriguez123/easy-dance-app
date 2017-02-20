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
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 
                    
                    <div class="card">



                        <div class="card-header">

                            <div class="col-md-7">
                                <div class="f-20 f-500">Solo me fio de las estadisticas que he manipulado. (Winston Churchill)</div>                            
                                <div>
                                    <div class="f-16 text-justify">Te mantendremos informado durante tu periodo en Easy Dance y nos aseguraremos de brindarte la información que necesitas para el crecimiento de tu academia.</div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-offset-1">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <label for="especialidad" id="id-instructor_id">Promotor</label><br>
                                <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="instructor_id" id="instructor_id" data-live-search="true">
                                          <option value="">Selecciona</option>
                                          @foreach ( $instructores as $instructor )
                                          <option value = "{{ $instructor['id'] }}">{{ $instructor['nombre'] }} {{ $instructor['apellido'] }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <br>


                                <div class="checkbox m-b-15">
                                    <label>
                                        Hoy
                                        <input type="checkbox" value="" id="today">
                                        <i class="input-helper"></i>                                    
                                    </label>
                                </div>  

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

                                <br>

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
                                                                 

                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                                        <div class="fg-line">
                                                                <input type="text" id="personalizar" class="form-control" placeholder="Personalizar">
                                                        </div>
                                                    </div>

                                                    <br>

                                                    <label for="nombre">Meses</label>
                                                    <div class="input-group">
                                                      <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                                      <div class="fg-line">
                                                      <div class="select">
                                                        <select class="selectpicker" name="meses" id="meses" data-live-search="true">

                                                          <option value="01/01/2017-31/01/2017">Enero</option>
                                                          <option value="01/02/2017-31/02/2017">Febrero</option>
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

                                                    <div class="clearfix p-b-35"></div>
                                                    <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseTwo')" ></i></div> 

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--<a class="btn-blanco m-r-10 f-25" id="personalizar"> Personalizar <i class="zmdi zmdi-calendar"></i></a>-->
                            </div>

                        </div><!-- CARD HEADER 1 -->

                        <div class="col-md-6">
                            <h2>Visitas Presenciales</h2>
                            <h4>Total Transferidos: <span id ="total"> {{$total}}</span></h4>
                            <hr>
                            <!-- <ul class="actions">
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
                            </ul> -->
                            <div id="pie-chart-procesos" class="flot-chart-pie"></div>
                            <div class="flc-pie hidden-xs"></div>

                        </div><!-- COL-MD-6 -->


                        <div class="col-md-6">
                            <h2>Información</h2>
                            <hr>


                            <!-- <ul class="actions">
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
                            </ul> -->
                            
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
                                   <!--  <div class="chart chart-pie inscritos-stats-pie"></div> -->
                                    <div class="count">
                                        <small>Total Visitas:</small>
                                        <h2 id="hombres" class="pull-left m-l-30">{{$hombres}}</h2>
                                        <h2 id="mujeres" class="pull-right m-r-30">{{$mujeres}}</h2>
                                    </div>
                                </div>
                            </div>



 
                        </div><!-- COL-MD-6 -->

                        <div class="clearfix"></div>
                        <div class="clearfix"></div>

                        <div class="card-header text-right">

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-instructor f-25"></i> Informes de Promotores</p>
                            <hr class="linea-morada">
                                                         
                        </div>

                        <div class="col-sm-12">
                         <div class="form-group fg-line ">
                            <div class="p-t-10">
                            <label class="radio radio-inline m-r-20">
                                <input name="tipo" id="todos" value="todos" type="radio" checked >
                                <i class="input-helper"></i>  
                                Todos <i id="todos2" name="todos2" class="icon_a-clases-grupales c-verde f-20"></i>
                            </label>
                            <label class="radio radio-inline m-r-20">
                                <input name="tipo" id="visitantes" value="visitantes" type="radio" >
                                <i class="input-helper"></i>  
                                Visitantes <i id="visitantes2" name="visitantes2" class="icon_a-visitante-presencial f-20"></i>
                            </label>
                            <label class="radio radio-inline m-r-20">
                                <input name="tipo" id="clientes" value="clientes" type="radio">
                                <i class="input-helper"></i>  
                                Clientes <i id="clientes2" name="clientes2" class="icon_a-alumnos f-20"></i>
                            </label>
                            </div>
                            
                         </div>
                        </div> 

                        <div class="clearfix"></div>

                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="cliente"></th>
                                    <th class="text-center" data-column-id="fecha">Fecha</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                    <th class="text-center" data-column-id="apellido" data-order="desc">Apellido</th>
                                    <th class="text-center" data-column-id="celular">Contacto Móvil</th>
                                    <th class="text-center" data-column-id="especialidad">Especialidad</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($visitantes as $visitante)
                                <?php $id = $visitante->id; ?>
                                <tr id="row_{{$id}}" class="seleccion" >
                                    <td class="text-center previa"> 
                                        @if($visitante->cliente)
                                            <i class="zmdi zmdi-check c-verde f-20" data-html="true" data-original-title="" data-content="Cliente" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>
                                        @else
                                            <i class="zmdi zmdi-dot-circle c-amarillo f-20" data-html="true" data-original-title="" data-content="Visitante" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>
                                        @endif
                                    </td>
                                    <td class="text-center previa">{{$visitante->fecha}}</td>
                                    <td class="text-center previa">{{$visitante->nombre}}</td>
                                    <td class="text-center previa">{{$visitante->apellido}} </td>
                                    <td class="text-center previa">{{$visitante->celular}} </td>
                                    <td class="text-center previa">{{$visitante->especialidad}} </td>
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

                <button class="btn btn-float bgm-red m-btn" data-action="print"><i class="zmdi zmdi-print"></i></button>
                
            </section>
@stop

@section('js') 
            
        <script type="text/javascript">
        
        route_filtrar = "{{url('/')}}/reportes/promotores";

        var tipo = 'mesActual'
        var cliente = 1;
        var presenciales = <?php echo json_encode($visitantes);?>;
        
        $(document).ready(function(){

        $('input:checkbox').removeAttr("disabled");

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
        pageLength: 25, 
        order: [[1, 'desc']],
        fnDrawCallback: function() {
          if ("{{count($visitantes)}}" < 25) {
              $('.dataTables_paginate').hide();
              $('#tablelistar_length').hide();
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


             $('#cliente').on('change', function () {

                var token = $('input:hidden[name=_token]').val();
                cliente = $('#cliente').val()
                instructor_id = $('#instructor_id').val()
                if(tipo == 'Fecha'){
                    Fecha = $('#meses').val();
                    datos = "&Fecha="+Fecha+"&cliente="+cliente+"&instructor_id="+instructor_id
                }else if(tipo == 'rango'){
                    fechaInicio = $("input[name=daterangepicker_start]").val();
                    fechaFin = $("input[name=daterangepicker_end]").val();
                    datos = "&fechaInicio="+fechaInicio+"&fechaFin="+fechaFin+"&rango=rango&cliente="+cliente+"&instructor_id="+instructor_id
                }else{
                    datos = "&"+tipo+"="+tipo+"&cliente="+cliente+"&instructor_id="+instructor_id
                }
                procesando();
                $.ajax({
                    url: route_filtrar,
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'POST',
                    dataType: 'json',
                    data: datos,
                    success:function(respuesta){

                        $('#total').text(respuesta.total)
                        finprocesado();

                        t.clear().draw();

                        presenciales = respuesta.presenciales

                        $.each(respuesta.presenciales, function (index, array) {

                            if(array.cliente == 1)
                            {
                                cliente = '<i class="zmdi zmdi-check c-verde f-20" data-html="true" data-original-title="" data-content="Cliente" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>'
                            }else{
                                cliente = '<i class="zmdi zmdi-dot-circle c-amarillo f-20" data-html="true" data-original-title="" data-content="Visitante" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';
                            }
                            var rowNode=t.row.add( [
                            ''+cliente+'',
                            ''+array.fecha+'',
                            ''+array.nombre+'',
                            ''+array.apellido+'',
                            ''+array.celular+'',
                            ''+array.especialidad+'',
                            ] ).draw(false).node();
                            $( rowNode )
                                .attr('id',array.id)
                                .addClass('seleccion');
                        });

                        datos = JSON.parse(JSON.stringify(respuesta));

                        $("#mujeres").text(datos.mujeres);
                        $("#hombres").text(datos.hombres);

                        var data1 = ''
                        data1 += '[';
                        $.each( datos.edades, function( i, item ) {
                            var edad = item.age_range;
                            var cant = item.count
                            data1 += '{"data":"'+cant+'","label":"'+edad+'"},';
                        });
                        data1 = data1.substring(0, data1.length -1);
                        data1 += ']';
                            //GRAFICO FILTRO MES ACTUAL
                            $("#pie-chart-procesos").html('');
                            $(".flc-pie").html('');
                            $.plot('#pie-chart-procesos', $.parseJSON(data1), {
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


                    }
                });
                
            }); 

            $('#instructor_id').on('change', function () {

                $("#todos").click();
                var token = $('input:hidden[name=_token]').val();
                instructor_id = $('#instructor_id').val()
                cliente = $('#cliente').val()
                if(tipo == 'Fecha'){
                    Fecha = $('#meses').val();
                    datos = "&Fecha="+Fecha+"&instructor_id="+instructor_id+"&cliente="+cliente
                }else if(tipo == 'rango'){
                    fechaInicio = $("input[name=daterangepicker_start]").val();
                    fechaFin = $("input[name=daterangepicker_end]").val();
                    datos = "&fechaInicio="+fechaInicio+"&fechaFin="+fechaFin+"&rango=rango&instructor_id="+instructor_id+"&cliente="+cliente
                }else{
                    datos = "&"+tipo+"="+tipo+"&instructor_id="+instructor_id+"&cliente="+cliente
                }
                procesando();
                $.ajax({
                    url: route_filtrar,
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'POST',
                    dataType: 'json',
                    data: datos,
                    success:function(respuesta){

                        $('#total').text(respuesta.total)
                        finprocesado();

                        t.clear().draw();

                        presenciales = respuesta.presenciales

                        $.each(respuesta.presenciales, function (index, array) {

                            if(array.cliente == 1)
                            {
                                cliente = '<i class="zmdi zmdi-check c-verde f-20" data-html="true" data-original-title="" data-content="Cliente" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>'
                            }else{
                                cliente = '<i class="zmdi zmdi-dot-circle c-amarillo f-20" data-html="true" data-original-title="" data-content="Visitante" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';
                            }
                            var rowNode=t.row.add( [
                            ''+cliente+'',
                            ''+array.fecha+'',
                            ''+array.nombre+'',
                            ''+array.apellido+'',
                            ''+array.celular+'',
                            ''+array.especialidad+'',
                            ] ).draw(false).node();
                            $( rowNode )
                                .attr('id',array.id)
                                .addClass('seleccion');
                        });

                        datos = JSON.parse(JSON.stringify(respuesta));

                        $("#mujeres").text(datos.mujeres);
                        $("#hombres").text(datos.hombres);

                        var data1 = ''
                        data1 += '[';
                        $.each( datos.edades, function( i, item ) {
                            var edad = item.age_range;
                            var cant = item.count
                            data1 += '{"data":"'+cant+'","label":"'+edad+'"},';
                        });
                        data1 = data1.substring(0, data1.length -1);
                        data1 += ']';
                            //GRAFICO FILTRO MES ACTUAL
                            $("#pie-chart-procesos").html('');
                            $(".flc-pie").html('');
                            $.plot('#pie-chart-procesos', $.parseJSON(data1), {
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


                    }
                });
                
            }); 

            $('#meses').on('change', function () {
                $("#todos").click();
                var token = $('input:hidden[name=_token]').val();
                var Fecha = $(this).val();
                tipo = 'Fecha'
                procesando();
                $.ajax({
                    url: route_filtrar,
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'POST',
                    dataType: 'json',
                    data: "&Fecha="+Fecha+"&instructor_id="+$('#instructor_id').val()+"&cliente="+$('#cliente').val(),
                    success:function(respuesta){

                        $('#total').text(respuesta.total)
                        finprocesado();

                        presenciales = respuesta.presenciales

                        t.clear().draw();

                        $.each(respuesta.presenciales, function (index, array) {

                            if(array.cliente == 1)
                            {
                                cliente = '<i class="zmdi zmdi-check c-verde f-20" data-html="true" data-original-title="" data-content="Cliente" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>'
                            }else{
                                cliente = '<i class="zmdi zmdi-dot-circle c-amarillo f-20" data-html="true" data-original-title="" data-content="Visitante" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';
                            }
                            var rowNode=t.row.add( [
                            ''+cliente+'',
                            ''+array.fecha+'',
                            ''+array.nombre+'',
                            ''+array.apellido+'',
                            ''+array.celular+'',
                            ''+array.especialidad+'',
                            ] ).draw(false).node();
                            $( rowNode )
                                .attr('id',array.id)
                                .addClass('seleccion');
                        });

                        datos = JSON.parse(JSON.stringify(respuesta));

                        $("#mujeres").text(datos.mujeres);
                        $("#hombres").text(datos.hombres);

                        var data1 = ''
                        data1 += '[';
                        $.each( datos.edades, function( i, item ) {
                            var edad = item.age_range;
                            var cant = item.count
                            data1 += '{"data":"'+cant+'","label":"'+edad+'"},';
                        });
                        data1 = data1.substring(0, data1.length -1);
                        data1 += ']';
                            //GRAFICO FILTRO MES ACTUAL
                            $("#pie-chart-procesos").html('');
                            $(".flc-pie").html('');
                            $.plot('#pie-chart-procesos', $.parseJSON(data1), {
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


                    }
                });
                
            }); //END CLICK FECHA RANGO

            $(".applyBtn").on("click", function(){
                $("#todos").click();
                var token = $('input:hidden[name=_token]').val();
                var fechaInicio = $("input[name=daterangepicker_start]").val();
                var fechaFin = $("input[name=daterangepicker_end]").val();
                tipo = 'rango'
                procesando();
                $.ajax({
                    url: route_filtrar,
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'POST',
                    dataType: 'json',
                    data: "&fechaInicio="+fechaInicio+"&fechaFin="+fechaFin+"&rango=rango&instructor_id="+$('#instructor_id').val()+"&cliente="+$('#cliente').val(),
                    success:function(respuesta){
                        $('#total').text(respuesta.total)
                        finprocesado();

                        presenciales = respuesta.presenciales

                        t.clear().draw();

                        $.each(respuesta.presenciales, function (index, array) {
                            if(array.cliente == 1)
                            {
                                cliente = '<i class="zmdi zmdi-check c-verde f-20" data-html="true" data-original-title="" data-content="Cliente" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>'
                            }else{
                                cliente = '<i class="zmdi zmdi-dot-circle c-amarillo f-20" data-html="true" data-original-title="" data-content="Visitante" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';
                            }
                            var rowNode=t.row.add( [
                            ''+cliente+'',
                            ''+array.fecha+'',
                            ''+array.nombre+'',
                            ''+array.apellido+'',
                            ''+array.celular+'',
                            ''+array.especialidad+'',
                            ] ).draw(false).node();
                            $( rowNode )
                                .attr('id',array.id)
                                .addClass('seleccion');
                        });

                        datos = JSON.parse(JSON.stringify(respuesta));

                        $("#mujeres").text(datos.mujeres);
                        $("#hombres").text(datos.hombres);

                        var data1 = ''
                        data1 += '[';
                        $.each( datos.edades, function( i, item ) {
                            var edad = item.age_range;
                            var cant = item.count
                            data1 += '{"data":"'+cant+'","label":"'+edad+'"},';
                        });
                        data1 = data1.substring(0, data1.length -1);
                        data1 += ']';
                            //GRAFICO FILTRO MES ACTUAL
                            $("#pie-chart-procesos").html('');
                            $(".flc-pie").html('');
                            $.plot('#pie-chart-procesos', $.parseJSON(data1), {
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
                $("#todos").click();
                var token = $('input:hidden[name=_token]').val();
                if ($("#actual_month").is(":checked")){
                    tipo = 'mesActual'
                    $("#mes_actual").val('1');
                        procesando();
                        $.ajax({
                            url: route_filtrar,
                            headers: {'X-CSRF-TOKEN': token},
                            type: 'POST',
                            dataType: 'json',
                            data: "&mesActual=mes_actual&instructor_id="+$('#instructor_id').val()+"&cliente="+$('#cliente').val(),
                            success:function(respuesta){
                                $('#total').text(respuesta.total)
                                finprocesado();

                                t.clear().draw();

                                presenciales = respuesta.presenciales

                                $.each(respuesta.presenciales, function (index, array) {
                                    if(array.cliente == 1)
                                    {
                                        cliente = '<i class="zmdi zmdi-check c-verde f-20" data-html="true" data-original-title="" data-content="Cliente" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>'
                                    }else{
                                        cliente = '<i class="zmdi zmdi-dot-circle c-amarillo f-20" data-html="true" data-original-title="" data-content="Visitante" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';
                                    }
                                    var rowNode=t.row.add( [
                                    ''+cliente+'',
                                    ''+array.fecha+'',
                                    ''+array.nombre+'',
                                    ''+array.apellido+'',
                                    ''+array.celular+'',
                                    ''+array.especialidad+'',
                                    ] ).draw(false).node();
                                    $( rowNode )
                                        .attr('id',array.id)
                                        .addClass('seleccion');
                                });
                                datos = JSON.parse(JSON.stringify(respuesta));
                                //console.log(datos.edades);

                                $("#mujeres").text(datos.mujeres);
                                $("#hombres").text(datos.hombres);

                                var data1 = ''
                                data1 += '[';
                                $.each( datos.edades, function( i, item ) {
                                    var edad = item.age_range;
                                    var cant = item.count
                                    data1 += '{"data":"'+cant+'","label":"'+edad+'"},';
                                });
                                data1 = data1.substring(0, data1.length -1);
                                data1 += ']';
                                    //GRAFICO FILTRO MES ACTUAL
                                    $("#pie-chart-procesos").html('');
                                    $(".flc-pie").html('');
                                    $.plot('#pie-chart-procesos', $.parseJSON(data1), {
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

                            }
                        });
                }else{
                    $("#mes_actual").val('0');
                }
            });//END FILTRO MES ACTUAL


            //FILTRO MES PASADO
            //$("#mes_actual").val('0');
            $("#past_month").on('click', function(){
                $("#todos").click();
                var token = $('input:hidden[name=_token]').val();
                if ($("#past_month").is(":checked")){
                    tipo = 'mesPasado'
                    //$("#mes_actual").val('1');
                        procesando();
                        $.ajax({
                            url: route_filtrar,
                            headers: {'X-CSRF-TOKEN': token},
                            type: 'POST',
                            dataType: 'json',
                            data: "&mesPasado=mes_pasado&instructor_id="+$('#instructor_id').val()+"&cliente="+$('#cliente').val(),
                            success:function(respuesta){
                                $('#total').text(respuesta.total)
                                finprocesado();

                                presenciales = respuesta.presenciales

                                t.clear().draw();

                                $.each(respuesta.presenciales, function (index, array) {
                                    if(array.cliente == 1)
                                    {
                                        cliente = '<i class="zmdi zmdi-check c-verde f-20" data-html="true" data-original-title="" data-content="Cliente" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>'
                                    }else{
                                        cliente = '<i class="zmdi zmdi-dot-circle c-amarillo f-20" data-html="true" data-original-title="" data-content="Visitante" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';
                                    }
                                    var rowNode=t.row.add( [
                                    ''+cliente+'',
                                    ''+array.fecha+'',
                                    ''+array.nombre+'',
                                    ''+array.apellido+'',
                                    ''+array.celular+'',
                                    ''+array.especialidad+'',
                                    ] ).draw(false).node();
                                    $( rowNode )
                                        .attr('id',array.id)
                                        .addClass('seleccion');
                                });

                                datos = JSON.parse(JSON.stringify(respuesta));
                                //console.log(datos.edades);
                                $("#mujeres").text(datos.mujeres);
                                $("#hombres").text(datos.hombres);

                                var data1 = ''
                                data1 += '[';
                                $.each( datos.edades, function( i, item ) {
                                    var edad = item.age_range;
                                    var cant = item.count
                                    data1 += '{"data":"'+cant+'","label":"'+edad+'"},';
                                });
                                data1 = data1.substring(0, data1.length -1);
                                data1 += ']';
                                    //GRAFICO FILTRO MES ACTUAL
                                    $("#pie-chart-procesos").html('');
                                    $(".flc-pie").html('');
                                    $.plot('#pie-chart-procesos', $.parseJSON(data1), {
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

                            }
                        });
                }else{
                    //$("#mes_actual").val('0');
                }
            });



            //FILTRO HOY
            //$("#mes_actual").val('0');
            $("#today").on('click', function(){
                $("#todos").click();
                var token = $('input:hidden[name=_token]').val();
                if ($("#today").is(":checked")){
                    tipo = 'today'
                    //$("#mes_actual").val('1');
                        procesando();
                        $.ajax({
                            url: route_filtrar,
                            headers: {'X-CSRF-TOKEN': token},
                            type: 'POST',
                            dataType: 'json',
                            data: "&today=today&instructor_id="+$('#instructor_id').val()+"&cliente="+$('#cliente').val(),
                            success:function(respuesta){
                                $('#total').text(respuesta.total)
                                finprocesado();

                                presenciales = respuesta.presenciales

                                t.clear().draw();

                                $.each(respuesta.presenciales, function (index, array) {
                                    if(array.cliente == 1)
                                    {
                                        cliente = '<i class="zmdi zmdi-check c-verde f-20" data-html="true" data-original-title="" data-content="Cliente" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>'
                                    }else{
                                        cliente = '<i class="zmdi zmdi-dot-circle c-amarillo f-20" data-html="true" data-original-title="" data-content="Visitante" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';
                                    }
                                    var rowNode=t.row.add( [
                                    ''+cliente+'',
                                    ''+array.fecha+'',
                                    ''+array.nombre+'',
                                    ''+array.apellido+'',
                                    ''+array.celular+'',
                                    ''+array.especialidad+'',
                                    ] ).draw(false).node();
                                    $( rowNode )
                                        .attr('id',array.id)
                                        .addClass('seleccion');
                                });

                                datos = JSON.parse(JSON.stringify(respuesta));
                                //console.log(datos.edades);
                                $("#mujeres").text(datos.mujeres);
                                $("#hombres").text(datos.hombres);

                                var data1 = ''
                                data1 += '[';
                                $.each( datos.edades, function( i, item ) {
                                    var edad = item.age_range;
                                    var cant = item.count
                                    data1 += '{"data":"'+cant+'","label":"'+edad+'"},';
                                });
                                data1 = data1.substring(0, data1.length -1);
                                data1 += ']';
                                    //GRAFICO FILTRO HOY
                                    $("#pie-chart-procesos").html('');
                                    $(".flc-pie").html('');
                                    $.plot('#pie-chart-procesos', $.parseJSON(data1), {
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

                            }
                        });
                }else{
                    //$("#mes_actual").val('0');
                }
            });

        //PLOTS
        var pieData1 = [
                @foreach ($edades as $edad)
                    {data: {{$edad->count}}, label: '{{$edad->age_range}}'},
                @endforeach
            ];
        
        var values = [
            @foreach ($sexos as $sexo)        
                   {{$sexo->CantSex}} ,
            @endforeach                    
            ];


        $.plot('#pie-chart-procesos', pieData1, {
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



      $('#collapseTwo').on('show.bs.collapse', function () {
        $('input:checkbox').attr('checked',false);
        $('input:checkbox').attr("disabled","disabled");
      })

      $('#collapseTwo').on('hide.bs.collapse', function () {
        $('input:checkbox').removeAttr("disabled");
      })

      function collapse_minus(collaps){
       $('#'+collaps).collapse('hide');
      }

      function rechargeVisitantes(){

        setTimeout(function(){
        
            $.each(presenciales, function (index, array) {
                if(array.cliente == 0){
                    var rowNode=t.row.add( [
                    ''+'<i class="zmdi zmdi-dot-circle c-amarillo f-20" data-html="true" data-original-title="" data-content="Visitante" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>'+'',
                    ''+array.fecha+'',
                    ''+array.nombre+'',
                    ''+array.apellido+'',
                    ''+array.celular+'',
                    ''+array.especialidad+'',
                    ] ).draw(false).node();
                    $( rowNode )
                        .attr('id',array.id)
                        .addClass('seleccion');
                }
            });

            finprocesado();
        }, 1000);
    }

    function rechargeClientes(){

        setTimeout(function(){
            
            $.each(presenciales, function (index, array) {
                if(array.cliente == 1){
                    var rowNode=t.row.add( [
                    ''+'<i class="zmdi zmdi-check c-verde f-20" data-html="true" data-original-title="" data-content="Cliente" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>'+'',
                    ''+array.fecha+'',
                    ''+array.nombre+'',
                    ''+array.apellido+'',
                    ''+array.celular+'',
                    ''+array.especialidad+'',
                    ] ).draw(false).node();
                    $( rowNode )
                        .attr('id',array.id)
                        .addClass('seleccion');
                }
            });

            finprocesado();
        }, 1000);
    }

    function rechargeTodos(){

        setTimeout(function(){
        
            $.each(presenciales, function (index, array) {
                if(array.cliente == 1)
                {
                    cliente = '<i class="zmdi zmdi-check c-verde f-20" data-html="true" data-original-title="" data-content="Cliente" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>'
                }else{
                    cliente = '<i class="zmdi zmdi-dot-circle c-amarillo f-20" data-html="true" data-original-title="" data-content="Visitante" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';
                }
                var rowNode=t.row.add( [
                ''+cliente+'',
                ''+array.fecha+'',
                ''+array.nombre+'',
                ''+array.apellido+'',
                ''+array.celular+'',
                ''+array.especialidad+'',
                ] ).draw(false).node();
                $( rowNode )
                    .attr('id',array.id)
                    .addClass('seleccion');
            });

            finprocesado();
        }, 1000);
    }

        $("#visitantes").click(function(){
            $( "#clientes2" ).removeClass( "c-verde" );
            $( "#todos2" ).removeClass( "c-verde" );
            $( "#visitantes2" ).addClass( "c-verde" );
        });

        $("#clientes").click(function(){
            $( "#clientes2" ).addClass( "c-verde" );
            $( "#todos2" ).removeClass( "c-verde" );
            $( "#visitantes2" ).removeClass( "c-verde" );
        });

        $("#todos").click(function(){
            $( "#clientes2" ).removeClass( "c-verde" );
            $( "#todos2" ).addClass( "c-verde" );
            $( "#visitantes2" ).removeClass( "c-verde" );
        });

        $('input[name="tipo"]').on('change', function(){
            procesando();
            t.clear().draw();
            if ($(this).val()=='todos') {
                  tipo = 'todos';
                  rechargeTodos();
            } else if ($(this).val()=='visitantes')  {
                  tipo= 'visitantes';
                  rechargeVisitantes();
            } else  {
                  tipo= 'clientes';
                  rechargeClientes();
            }
         });






        </script>

@stop