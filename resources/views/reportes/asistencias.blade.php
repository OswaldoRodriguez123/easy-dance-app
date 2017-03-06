@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

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

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_b-telefono f-25"></i> Reporte de Asistencias</p>
                            <hr class="linea-morada">
                                                         
                        </div>

                        <div class="col-sm-12">
                            <form name="formFiltro" id="formFiltro">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="col-md-4">
                                <label>Participantes</label>

                                <div class="fg-line">
                                  <div class="select">
                                    <select class="selectpicker" data-live-search="true" name="participante_id" id="participante_id">
                                        <option value="1">Asistentes</option>
                                        <option value="2">Inasistentes</option>
                                        <option value="0">Todos</option>
                                    </select>
                                  </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label>Alumnos</label>

                                <div class="fg-line">
                                  <div class="select">
                                    <select class="selectpicker" data-live-search="true" name="alumno_id" id="alumno_id">
                                        <option value="0">Todos</option>
                                        @foreach($alumnos as $alumno)
                                            <option value="{{$alumno->id}}">{{$alumno->nombre}} {{$alumno->apellido}} {{$alumno->identificacion}}</option>
                                        @endforeach
                                        
                                    </select>
                                  </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label>Fecha</label>

                                <div class="fg-line">
                                    <input type="text" id="fecha" name="fecha" class="date-picker form-control input-sm proceso pointer" value="{{ \Carbon\Carbon::now()->format('d/m/Y')}}" placeholder="Selecciona la fecha"> 
                                </div>
                                <div class="has-error" id="error-linea">
                                  <span>
                                      <small class="help-block error-span" id="error-linea_mensaje" ></small>      
                                  </span>
                                 </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-4">
                                <label>Clase Grupal</label>

                                <div class="fg-line">
                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="clase_grupal_id" id="clase_grupal_id">
                                        </select> 
                                    </div>
                                </div>
                            </div>

                   <!--          <div class="col-md-4">
                                <label>Tipo</label>

                                <div class="fg-line">
                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="tipo" id="tipo">
                                            <option value="1">General</option>
                                            <option value="2">Valoracion</option>
                                        </select>
                                    </div>
                                </div>    
                            </div> -->


                            <button type="button" class="btn btn-blanco m-r-10 f-10 guardar" id="guardar" >Filtrar</button>

                            <div class ="clearfix m-b-10"></div>
                            <div class ="clearfix m-b-10"></div>

                            </form>
                        </div>

                       
                        <div class="col-md-6">
                            <h2>Informe de Asistencias</h2>
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
                                        <small>Total:</small>
                                        <h2 id="hombres" class="pull-left m-l-30">{{$hombres}}</h2>
                                        <h2 id="mujeres" class="pull-right m-r-30">{{$mujeres}}</h2>
                                    </div>
                                </div>
                            </div>



 
                        </div><!-- COL-MD-6 -->

                        <div class ="clearfix"></div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="pertenece" data-order="desc"></th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombres</th>
                                    <th class="text-center" data-column-id="cedula" data-order="desc">Cedula</th>
                                    <th class="text-center" data-column-id="fecha_nacimiento" data-order="desc"><span class="ocultar">Fecha Nacimiento</span></th>
                                    <th class="text-center" data-column-id="estatus_e"><span class="ocultar">Estatus E</span></th>
                                    <th class="text-center" data-column-id="celular"><span class="ocultar">Contacto Móvil</span></th>
                                    <th class="text-center" data-column-id="sexo"><span class="ocultar">Sexo</span></th>
                                    <th class="text-center" data-column-id="fecha"><span class="ocultar">Fecha</span></th>
                                    <th class="text-center" data-column-id="hora"><span class="ocultar">Hora</span></th>                                                                                                            
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
                        
                        
                    </div>
                    
                    
                </div>
            </section>

            <button class="btn btn-float bgm-red m-btn" data-action="print"><i class="zmdi zmdi-print"></i></button>
@stop

@section('js') 
            
        <script type="text/javascript">

        var clases_grupales = <?php echo json_encode($clases_grupales);?>;
        var instructores = <?php echo json_encode($instructores);?>;
        var clase_grupal_array = [];
        var sortable = [];

        if("{{$sexos[0]->sexo}}" == 'F'){
            color2 = "#2196f3"
            color1 = "#FF4081"
        }else{
            color1 = "#2196f3"
            color2 = "#FF4081"
        }

        route_filtrar="{{url('/')}}/reportes/asistencias/filtrar";
        route_detalle="{{url('/')}}/participante/alumno/detalle";

        $(document).ready(function(){

        var hoy = moment().format('DD/MM/YYYY');

        $.each(clases_grupales, function (index, array) {
            sortable.push(array);
        });

        sortable.sort(function(a, b) {

            var c = new Date(hoy + ' ' + a.hora_inicio)
            var d = new Date(hoy + ' ' + b.hora_inicio)

            if (c.getTime() > d.getTime()) {
                retorno = 1;
            } else if (c.getTime() > d.getTime()) {
                retorno = -1;
            }
            else {
                retorno =  0;
            }

            return retorno
        })

        $('.icon_f-consultarle-al-instructor').popover();

        $("#formFiltro")[0].reset();
        $('#clase_grupal_id').empty();
        $('#instructor_id').empty();

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25, 
        order: [[7, 'desc'], [8, 'desc']],
        fnDrawCallback: function() {
          if ("{{count($asistencias)}}" < 25) {
              $('.dataTables_paginate').hide();
          }
          else{
             $('.dataTables_paginate').show();
          }
        },
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6),td:eq(7)', nRow).attr( "onclick","previa(this)" );
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
    

            if($('.chosen')[0]) {
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
            }

                rechargeClase()
            });

        function rechargeClase(){

            $('#clase_grupal_id').empty();
            clase_grupal_array = [];

            var tmp = $("#fecha").val().split("/");
            var hoy = new Date();
            var fecha_seleccionada = new Date(tmp[2]+'-'+tmp[1]+'-'+tmp[0]);
            var dia = fecha_seleccionada.getDay() + 1;

            $('#clase_grupal_id').append( new Option('Todas',0));

            $.each(sortable, function (index, array) {
                if(array.dia == dia){

                    clase_grupal_array.push(array); 
                   
                    $('#clase_grupal_id').append( new Option(array.clase_grupal_nombre +'  -  '+array.hora_inicio+' / '+array.hora_final + '  -  ' + array.instructor_nombre + ' ' + array.instructor_apellido,array.clase_grupal_id));

                }
            });

            $('#clase_grupal_id').selectpicker('refresh');
        }

        $("#fecha").on("dp.change", function (e) {

            $( "#clase_grupal_id" ).focus();

            rechargeClase();
            
        });

         $("#guardar").click(function(){

            $('#error-linea_mensaje').text('')

            var route = route_filtrar;
            var token = $('input:hidden[name=_token]').val();
            var datos = $( "#formFiltro" ).serialize();

            procesando(); 

            t.clear().draw();


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

                      if($('#tipo').val() == 1){
                        $('.ocultar').show()
                      }else{
                        $('.ocultar').hide()
                      }

                        
                    $.each(respuesta.array, function (index, array) {

                        if(array.sexo=='F'){
                            sexo = '<i class="zmdi zmdi-female f-25 c-rosado"></i>'
                        }
                        else{
                            sexo = '<i class="zmdi zmdi-male f-25 c-azul"></i>'
                        }


                        if (typeof array.fecha === "undefined") {
                            fecha = '';
                            hora = '';
                        }else{
                            fecha = array.fecha;
                            hora = array.hora;
                        }

                        // if($('#tipo').val() == 1){
                        var rowId=array.alumno_id;
                        var rowNode=t.row.add( [
                        ''+array.pertenece+'',
                        ''+array.nombre+ ' '+array.apellido+ '',
                        ''+array.identificacion+'',
                        ''+array.fecha_nacimiento+'',
                        ''+array.deuda+'',
                        ''+array.celular+'',
                        ''+sexo+'',
                        ''+fecha+'',
                        ''+hora+'',
                        ] ).draw(false).node();
                        $( rowNode )
                          .attr('id',rowId)
                          .addClass('seleccion');
             
                        // }else{
                        //     var rowId=array.alumno_id;
                        //     var rowNode=t.row.add( [
                        //     ''+array.pertenece+'',
                        //     ''+array.nombre+ ' '+array.apellido+ '',
                        //     ''+array.identificacion+'',
                        //     '',
                        //     '',
                        //     '',
                        //     '',
                        //     '',
                        //     '',
                        //     ] ).draw(false).node();
                        //     $( rowNode )
                        //       .attr('id',rowId)
                        //       .addClass('seleccion');
                  
                        // }
                    });




                    datos = JSON.parse(JSON.stringify(respuesta));

                    $("#mujeres").text(datos.mujeres);
                    $("#hombres").text(datos.hombres);

                    sexos = respuesta.sexos

                    if(sexos[1]){
                        if(sexos[1][0] == 'F'){
                            color1 = "#2196f3"
                            color2 = "#FF4081"
                        }else{
                            color2 = "#2196f3"
                            color1 = "#FF4081"
                        }
                    }

                    var data1 = ''
                    data1 += '[';
                    $.each( datos.sexos, function( i, item ) {
                        var edad = item[0];
                        var cant = item[1];
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
                            },
                            colors: [color1, color2],

                            
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

    //PLOTS
        var pieData1 = [
                @foreach ($sexos as $sexo)
                    {data: {{$sexo->CantSex}}, label: '{{$sexo->sexo}}'},
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
            },
            colors: [color1, color2],
            
        });

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

</script>

@stop