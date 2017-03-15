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

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-accounts f-25"></i> Reporte de Presenciales</p>
                            <hr class="linea-morada">
                                                         
                        </div>

                        <div class="col-sm-12">
                            <form name="formFiltro" id="formFiltro">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" id="boolean_fecha" name="boolean_fecha" value="0">

                                <div class="col-md-4">
                                    <label>Promotor</label>


                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="instructor_id" id="instructor_id">
                                          <option value="0">Todos</option>
                                          @foreach ( $promotores as $promotor )
                                            <option value = "{{ $promotor->id }}"> {{ $promotor->nombre }} {{ $promotor->apellido }}</option>

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

                                <div class="col-md-4">
                                    <label>¿Cómo se enteró?</label>


                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="como_nos_conociste_id" id="como_nos_conociste_id">
                                          <option value="0">Todos</option>
                                          @foreach ( $como_nos_conociste as $como_se_entero )
                                            <option value = "{{ $como_se_entero->id }}"> {{ $como_se_entero->nombre }}</option>

                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                </div>

                                <div class="clearfix m-b-20"></div>

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

                       
                        <div class="col-md-6">
                            <h2>Informe de Presenciales</h2>
                            <hr>
                            <div id="pie-chart-procesos" class="flot-chart-pie"></div>
                            <div class="flc-pie hidden-xs"></div>

                        </div>


                        <div class="col-md-6">
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
                                        <small>Total Presenciales:</small>
                                        <h2 id="hombres" class="pull-left m-l-30"></h2>
                                        <h2 id="mujeres" class="pull-right m-r-30"></h2>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix m-b-20"></div>

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

                        <div class ="clearfix"></div>
                        <div class="table-responsive row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered text-center " id="tablelistar" >
                                    <thead>
                                        <tr>
                                            <th class="text-center" data-column-id="cliente"></th>
                                            <th class="text-center" data-column-id="fecha">Fecha</th>
                                            <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                            <th class="text-center" data-column-id="apellido" data-order="desc">Apellido</th>
                                            <th class="text-center" data-column-id="sexo" data-order="desc">Sexo</th>
                                            <th class="text-center" data-column-id="celular">Contacto Móvil</th>
                                            <th class="text-center" data-column-id="especialidad">Especialidad</th>
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

        var clase_grupal_array = [];

        if("{{$sexos[0]->sexo}}" == 'F'){
            color2 = "#2196f3"
            color1 = "#FF4081"
        }else{
            color1 = "#2196f3"
            color2 = "#FF4081"
        }

        route_filtrar="{{url('/')}}/reportes/presenciales";
        route_detalle="{{url('/')}}/participante/visitante/detalle";

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

                            $('#total').text(respuesta.total)
                            finprocesado();

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
                                    sexo = '<i class="zmdi zmdi-male f-25 c-azul"></i> </span>'
                                }

                                if(array.cliente == 1)
                                {
                                    cliente = '<i class="zmdi zmdi-check c-verde f-20" data-html="true" data-original-title="" data-content="Cliente" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>'
                                    cliente_valor = cliente_valor + 1
                                    total = total + 1
                                }else{
                                    cliente = '<i class="zmdi zmdi-dot-circle c-amarillo f-20" data-html="true" data-original-title="" data-content="Visitante" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';
                                    nocliente = nocliente + 1
                                    total = total + 1
                                }

                                var rowNode=t.row.add( [
                                ''+cliente+'',
                                ''+array.fecha+'',
                                ''+array.nombre+'',
                                ''+array.apellido+'',
                                ''+sexo+'',
                                ''+array.celular+'',
                                ''+array.especialidad+'',
                                ] ).draw(false).node();
                                $( rowNode )
                                    .attr('id',array.id)
                                    .addClass('seleccion');
                            });

                            porcentaje = (cliente_valor/total)*100
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
                            $('.total').text(cliente_valor);
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
                              $("#msj_porcentaje").html("Regular");
                            }else if(porcentaje<="30"){
                              $("#barra-progreso").css("background-color","gold");
                              $("#msj_porcentaje").html("Bueno");
                            }else if(porcentaje<"40"){
                              $("#barra-progreso").css("background-color","greenyellow ");
                              $("#msj_porcentaje").html("Muy bueno");
                            }else{
                              $("#barra-progreso").css("background-color","green");
                              $("#msj_porcentaje").html("Excelente");
                            }
    

                            datos = JSON.parse(JSON.stringify(respuesta));

                            $("#mujeres").text(datos.mujeres);
                            $("#hombres").text(datos.hombres);

                            // sexos = respuesta.sexos

                            // if(sexos[1]){
                            //     if(sexos[1][0] == 'F'){
                            //         color1 = "#2196f3"
                            //         color2 = "#FF4081"
                            //     }else{
                            //         color2 = "#2196f3"
                            //         color1 = "#FF4081"
                            //     }
                            // }

                            var data1 = ''
                            data1 += '[';
                            $.each( datos.conociste, function( i, item ) {
                                var label = item[0];
                                var cant = item[1];
                                data1 += '{"data":"'+cant+'","label":"'+label+'"},';
                            });
                            data1 = data1.substring(0, data1.length -1);
                            data1 += ']';

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
                                },
                                colors: ["rgb(237,194,64)", "rgb(175,216,248)", "rgb(203,75,75)", "rgb(77,167,77)", "rgb(148,64,237)", "rgb(31,64,163)", "rgb(140,172,198)"],
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

    // //PLOTS
    //     var pieData1 = [
    //             @foreach ($sexos as $sexo)
    //                 {data: {{$sexo->CantSex}}, label: '{{$sexo->sexo}}'},
    //             @endforeach
    //         ];
        
    //     var values = [
    //         @foreach ($sexos as $sexo)        
    //                {{$sexo->CantSex}} ,
    //         @endforeach                    
    //         ];


    //     $.plot('#pie-chart-procesos', pieData1, {
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
    //         },
    //         colors: [color1, color2],
            
    //     });

     function previa(t){
        var id = $(t).closest('tr').attr('id');
        var route =route_detalle+"/"+id;
        window.location=route;
      }

    // sparklinePie('inscritos-stats-pie', values, 45, 45, ['#fff', 'rgba(255,255,255,0.7)', 'rgba(255,255,255,0.4)', 'rgba(255,255,255,0.2)']);

    //     function sparklinePie(id, values, width, height, sliceColors) {
    //         $('.'+id).sparkline(values, {
    //             type: 'pie',
    //             width: width,
    //             height: height,
    //             sliceColors: sliceColors,
    //             offset: 0,
    //             borderWidth: 0
    //         });
    //     }   
    //     
    
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

</script>

@stop