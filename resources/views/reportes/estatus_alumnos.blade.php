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
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Regresar al Menu</a>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_b-telefono f-25"></i> Estatus de Alumno</p>
                            <hr class="linea-morada">
                                                         
                        </div>
                        <!--here-->
                        <div class="col-sm-12">
                            <form name="formFiltro" id="formFiltro">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <label>Participantes</label>

                                    <select name="participante_id" id="participante_id">
                                      <option value="1">Activos</option>
                                      <option value="2">Riesgo de ausencia</option>
                                      <option value="3">Inactivos</option>
                                    </select>

                                &nbsp; &nbsp; &nbsp; <label>Clase Grupal</label> &nbsp; &nbsp; &nbsp;


                                <select name="clase_grupal_id" id="clase_grupal_id">
                                </select> 
                                
                                 <div class="clearfix m-b-10"></div>
                                 <div class="has-error" id="error-linea">
                                  <span>
                                      <small class="help-block error-span" id="error-linea_mensaje" ></small>      
                                  </span>
                                 </div>

                                 <div class="clearfix m-b-10"></div> 

                                 <button type="button" class="btn btn-blanco m-r-10 f-10 guardar" id="guardar" >Filtrar</button>

                                <div class ="clearfix m-b-10"></div>
                                <div class ="clearfix m-b-10"></div>

                            </form>
                        </div>

                        <div class ="clearfix"></div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="pertenece" data-order="desc"></th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombres</th>
                                    <th class="text-center" data-column-id="cedula" data-order="desc">Cedula</th>
                                    <th class="text-center" data-column-id="fecha_nacimiento" data-order="desc">Fecha Nacimiento</th>
                                    <th class="text-center" data-column-id="estatus_e">Estatus de Alumno</th>
                                    <th class="text-center" data-column-id="clase_grupal" data-order="desc">Clase Grupal</th>
                                    <th class="text-center" data-column-id="celular">Contacto Móvil</th>
                                    <th class="text-center" data-column-id="sexo">Sexo</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($alumnos as $alumno)
                                <?php $id = $alumno->inscripcion_id; ?>
                                <tr id="{{$id}}" class="seleccion">
                                    <td class="text-center previa"></td>
                                    <td class="text-center previa">{{$reporte_datos[$id]['alumno_nombre']}} {{$reporte_datos[$id]['alumno_apellido']}}</td>
                                    <td class="text-center previa">{{$reporte_datos[$id]['alumno_identificacion']}}</td>
                                    <td class="text-center previa">{{$reporte_datos[$id]['alumno_nacimiento']}}</td>
                                    <td class="text-center previa"><label class="label estatusc-verde f-16"><i data-toggle="modal" href="#" class="zmdi zmdi-label-alt-outline f-20 p-r-3 operacionModal {{$alumno[$id]['estatus_alumno']}}"></i></label></td>
                                    <td class="text-center previa">{{$reporte_datos[$id]['clase_grupal']}}</td>
                                    <td class="text-center previa">{{$reporte_datos[$id]['alumno_celular']}}</td>

                                    <td class="text-center previa">
                                </tr>
                            @endforeach  
                                                           
                            </tbody>
                        </table><!--here-->
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
@stop

@section('js') 
            
        <script type="text/javascript">

        var clases_grupales = <?php echo json_encode($clases_grupales);?>;
        var instructores = <?php echo json_encode($instructores);?>;
        var clase_grupal_array = [];

        route_filtrar="{{url('/')}}/reportes/asistencias/filtrar";

        $(document).ready(function(){

        var hoy = moment().format('DD/MM/YYYY');

        $("#formFiltro")[0].reset();
        $('#clase_grupal_id').empty();
        $('#instructor_id').empty();

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 50, 
        // paging:false, 
        order: [[7, 'desc'], [8, 'desc']],
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

                rechargeClase()
            });

        function rechargeClase(){

            $('#clase_grupal_id').empty();
            clase_grupal_array = [];
                     
            $.each(clases_grupales, function (index, array) {
                clase_grupal_array.push(array); 
                   
                $('#clase_grupal_id').append( new Option(array.clase_grupal_nombre +'  -  '+array.hora_inicio+' / '+array.hora_final + '  -  ' + array.instructor_nombre + ' ' + array.instructor_apellido,array.clase_grupal_id));
            });
        }

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


                        var rowId=array.id;
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
                    });

                    datos = JSON.parse(JSON.stringify(respuesta));

                    $("#mujeres").text(datos.mujeres);
                    $("#hombres").text(datos.hombres);

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
                            }
                            
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
            }
            
        });

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