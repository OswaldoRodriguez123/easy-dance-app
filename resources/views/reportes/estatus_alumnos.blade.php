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

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-label-alt-outline f-25"></i> Reporte de Estatus de Alumno</p>
                            <hr class="linea-morada">
                                                         
                        </div>
                        <!--here-->
                        <div class="col-sm-12">
                            <form name="formFiltro" id="formFiltro">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                

                                <div class="col-sm-6">
                                    <label>Participantes</label>
                                    <div class="fg-line">
                                        <div class="select">
                                            <select class="selectpicker" name="estatus_alumno_id" id="estatus_alumno_id" data-live-search="true">
                                              <option value="1">Activos</option>
                                              <option value="2">Riesgo de ausencia</option>
                                              <option value="3">Inactivos</option>
                                              <option value="0">Todos</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-sm-6">
                                    <label>Clase Grupal</label>
                                    <div class="fg-line">
                                        <div class="select">
                                            <select class="selectpicker" name="clase_grupal_id" id="clase_grupal_id" data-live-search="true">

                                                <option value="0">Todas</option>
                                                @foreach ($clases_grupales as $clase_grupal)
                                                    <?php $id = $clase_grupal['id']; ?>
                                                    <option value="{{$id}}">                       
                                                        {{$clase_grupal['nombre']}} - {{$clase_grupal['dia']}} - 
                                                        {{$clase_grupal['hora_inicio']}} / 
                                                        {{$clase_grupal['hora_final']}} -  {{$clase_grupal['instructor_nombre']}}
                                                        {{$clase_grupal['instructor_apellido']}}
                                                    </option>
                                                @endforeach                                
                                            </select> 
                                        </div>
                                    </div>
                                </div>
                                 
                                <div class ="clearfix m-b-20"></div>

                                <button type="button" class="btn btn-blanco m-r-10 f-10 guardar" id="guardar" >Filtrar</button>

                                <div class ="clearfix m-b-10"></div>
                                <div class ="clearfix m-b-10"></div>

                            </form>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-6 estatus" style="display: none">
                            <h2>Informe de Estatus</h2>
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

                        <div class ="clearfix"></div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="imagen">Imagen</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombres</th>
                                    <th class="text-center" data-column-id="fecha_nacimiento" data-order="desc">Fecha Nacimiento</th>
                                    <th class="text-center" data-column-id="estatus_e">Estatus de Alumno</th>
                                    <th class="text-center" data-column-id="clase_grupal" data-order="desc">Clase Grupal</th>
                                    <th class="text-center" data-column-id="celular">Contacto Móvil</th>
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

        route_filtrar="{{url('/')}}/reportes/estatus-alumnos";
        route_detalle="{{url('/')}}/agendar/clases-grupales/participantes/historial/";

        var pagina = document.location.origin

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 50, 
        order: [[0, 'desc']],
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

                      $.each(respuesta.reporte_datos, function (index, array) {

                        if(array.imagen){
                            imagen = pagina+'/assets/uploads/usuario/'+array.imagen;
                        }else{
                            if(array.sexo == 'M'){
                                imagen = pagina+"/assets/img/Hombre.jpg"
                            }else{
                                imagen = pagina+"/assets/img/Mujer.jpg"
                            }
                        }

                        var rowId=array.inscripcion_id;
                        var rowNode=t.row.add( [
                            ''+'<img class="lv-img" src="'+imagen+'" alt="">'+'',
                            ''+array.nombre+ ' '+array.apellido+ '',
                            ''+array.fecha_nacimiento+'',
                            ''+"<i class='zmdi zmdi-label-alt-outline f-20 p-r-3 "+array.estatus+"'></i>",
                            ''+array.clase_nombre+'',
                            ''+array.celular+'',
                        ] ).draw(false).node();
                        $( rowNode )
                          .attr('id',rowId)
                          .addClass('seleccion');
                    });

                    datos = JSON.parse(JSON.stringify(respuesta));

                    // estatus = respuesta.estatus

                    // if(estatus[1]){
                    //     if(estatus[1][0] == 'A'){
                            color1 = "#E22C29"
                            color2 = "#FFC107"
                            color3 = "#4CAF50"
                    //     }else{
                    //         color2 = "#2196f3"
                    //         color1 = "#FF4081"
                    //     }
                    // }

                    var data1 = ''
                    data1 += '[';
                    $.each( datos.estatus, function( i, item ) {
                        var estatus = item[0];
                        var cant = item[1];
                        data1 += '{"data":"'+cant+'","label":"'+estatus+'"},';
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
                                content: "Cantidad: %n ... %p.0%, %s", // show percentages, rounding to 2 decimal places
                                shifts: {
                                    x: 20,
                                    y: 0
                                },
                                defaultTheme: false,
                                cssClass: 'flot-tooltip'
                            },
                            colors: [color1, color2, color3],

                            
                        });

                        if($('#estatus_alumno_id').val() == 0){
                          $('.estatus').show()
                        }else{
                          $('.estatus').hide()
                        }

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

    function previa(t){
        procesando()
        var id = $(t).closest('tr').attr('id');
        var route = route_detalle+id;
        window.open(route, '_blank');
    }

</script>

@stop