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

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_b-telefono f-25"></i> Reporte de Valoración</p>
                            <hr class="linea-morada">
                                                         
                        </div>

                        <div class="col-sm-12">
                            <form name="formFiltro" id="formFiltro">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" id="boolean_fecha" name="boolean_fecha" value="0">
                                <div class="col-md-4">
                                    <label>Clase Grupal</label>


                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="clase_grupal_id" id="clase_grupal_id">
                                          <option value="0">Todas</option>
                                          @foreach ( $clases_grupales as $clase_grupal )
                                            <option value = "{{ $clase_grupal->id }}"> {{ $clase_grupal->nombre }} - {{ $clase_grupal->hora_inicio }}  / {{ $clase_grupal->hora_final }} - {{ $clase_grupal->instructor_nombre }}  {{ $clase_grupal->instructor_apellido }} </option>

                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                  

                                    
                                </div>

                                <div class="col-md-4">
                                    <label>Tipo de Valoración</label> &nbsp; &nbsp; &nbsp;

                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="tipo" id="tipo">
                                            <option value="0">Todos</option>
                                            @foreach ( $config_examenes as $tipo_examen )
                                                <option value = "{{ $tipo_examen->id }}"> {{ $tipo_examen->nombre }} </option>
                                            @endforeach
                                        </select>
                                      </div>
                                </div>

                                <div class="col-md-4">

                                    <label>Nombre del diagnóstico</label> &nbsp; &nbsp; &nbsp; 

                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="examen_id" id="examen_id">
                                            <option value="0">Todos</option>
                                        </select>
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

                       
                        <!-- <div class="col-md-6">
                            <h2>Informe de Valoración</h2>
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
                                        <small>Total Valoraciones:</small>
                                        <h2 id="hombres" class="pull-left m-l-30">{{$hombres}}</h2>
                                        <h2 id="mujeres" class="pull-right m-r-30">{{$mujeres}}</h2>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <div class ="clearfix"></div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="activacion"></th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                    <th class="text-center" data-column-id="apellido" data-order="desc">Apellido</th>
                                    <th class="text-center" data-column-id="nac" data-order="desc">Nacimiento</th>                                    
                                    <th class="text-center" data-column-id="celular">Contacto Móvil</th>
                                    <th class="text-center" data-column-id="valoracion">Valoración</th>
                                </tr>
                            </thead>
                            <tbody>
                            {{-- $inscritos --}}
                            @foreach ($inscritos as $inscrito)
                                <?php $id = $inscrito['id']; ?>
                                <tr id="row_{{$id}}" class="seleccion" >
                                    <td class="text-center previa"> @if($inscrito['activacion'] == 0) <i class="zmdi zmdi-alert-circle-o zmdi-hc-fw c-youtube f-20" data-html="true" data-original-title="" data-content="Cuenta sin confirmar" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i> @endif</td>
                                    <td class="text-center previa">{{$inscrito['nombre']}}</td>
                                    <td class="text-center previa">{{$inscrito['apellido']}} </td>
                                    <td class="text-center previa">{{$inscrito['fecha_nacimiento']}} </td>
                                    <td class="text-center previa">{{$inscrito['celular']}} </td>
                                    <td class="text-center previa">{{$inscrito['valoracion']}} </td>
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

        var clases_grupales = <?php echo json_encode($clases_grupales);?>;
        var examenes = <?php echo json_encode($examenes);?>;
        var clase_grupal_array = [];

        route_filtrar="{{url('/')}}/reportes/diagnosticos";
        route_detalle="{{url('/')}}/participante/alumno/detalle";

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
        fnDrawCallback: function() {
          if ("{{count($inscritos)}}" < 25) {
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
    
        });

        $('#clase_grupal_id').on('change', function () {

            $('#examen_id').empty();
            $('#examen_id').append( new Option('Todos',0));

            id = $(this).val()

            $.each(examenes, function (index, array) {
                if(id == array.clase_grupal_id){
                   
                    $('#examen_id').append( new Option(array.nombre +'  -  '+array.fecha,array.id));

                }
            });

            $('#examen_id').selectpicker('refresh');
            
        });

         $("#guardar").click(function(){

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

                        
                    $.each(respuesta.inscritos, function (index, array) {

                        if(array.activacion == 0 )
                        {
                            activacion = '<i class="zmdi zmdi-alert-circle-o zmdi-hc-fw c-youtube f-20" data-html="true" data-original-title="" data-content="Cuenta sin confirmar" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>'
                        }else{
                            activacion = ''
                        };

                        var rowId=array.id;
                        var rowNode=t.row.add( [
                        ''+activacion+'',
                        ''+array.nombre+'',
                        ''+array.apellido+'',
                        ''+array.fecha_nacimiento+'',
                        ''+array.celular+'',
                        ''+array.valoracion+'',
                        ] ).draw(false).node();
                        $( rowNode )
                          .attr('id',rowId)
                          .addClass('seleccion');
             
                    });


                    // datos = JSON.parse(JSON.stringify(respuesta));

                    // $("#mujeres").text(datos.mujeres);
                    // $("#hombres").text(datos.hombres);

                    // var data1 = ''
                    // data1 += '[';
                    // $.each( datos.sexos, function( i, item ) {
                    //     var edad = item[0];
                    //     var cant = item[1];
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
        // var pieData1 = [
        //         @foreach ($sexos as $sexo)
        //             {data: {{$sexo->CantSex}}, label: '{{$sexo->sexo}}'},
        //         @endforeach
        //     ];
        
        // var values = [
        //     @foreach ($sexos as $sexo)        
        //            {{$sexo->CantSex}} ,
        //     @endforeach                    
        //     ];


        // $.plot('#pie-chart-procesos', pieData1, {
        //     series: {
        //         pie: {
        //             show: true,
        //             stroke: { 
        //                 width: 2,
        //             },
        //         },
        //     },
        //     legend: {
        //         container: '.flc-pie',
        //         backgroundOpacity: 0.5,
        //         noColumns: 0,
        //         backgroundColor: "white",
        //         lineWidth: 0
        //     },
        //     grid: {
        //         hoverable: true,
        //         clickable: true
        //     },
        //     tooltip: true,
        //     tooltipOpts: {
        //         content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
        //         shifts: {
        //             x: 20,
        //             y: 0
        //         },
        //         defaultTheme: false,
        //         cssClass: 'flot-tooltip'
        //     }
            
        // });

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