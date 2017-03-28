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

                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/agendar/clases-grupales/participantes/{{$clase_grupal->id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección de Participantes</a>

                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-reservaciones f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header">

                            Alumno: {{$alumno->nombre}} {{$alumno->apellido}}<br>
                            Clase Grupal: {{$clase_grupal->nombre}}<br>
                            Horario : {{$clase_grupal->hora_inicio}} - {{$clase_grupal->hora_final}}<br>
                            Dia: {{$dia}}<br>
                            Instructor : {{$clase_grupal->instructor_nombre}} {{$clase_grupal->instructor_apellido}}<br>

                            <div class="clearfix"></div>

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-shield-check f-25"></i> Historial de Asistencias</p>
                            <hr class="linea-morada">
                                                         
                        </div>

               <!--          <div class="col-sm-12">
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

                            <div class="col-md-4">
                                <label>Clase Grupal</label>

                                <div class="fg-line">
                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="clase_grupal_id" id="clase_grupal_id">
                                        </select> 
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-4">
                                <label>Tipo</label>

                                <div class="fg-line">
                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="tipo" id="tipo">
                                            <option value="1">General</option>
                                            <option value="2">Valoracion</option>
                                        </select>
                                    </div>
                                </div>    
                            </div>


                            <button type="button" class="btn btn-blanco m-t-10 m-l-10 f-10 guardar" id="guardar" >Filtrar</button>

                            <div class ="clearfix m-b-10"></div>
                            <div class ="clearfix m-b-10"></div>

                            </form>
                        </div> -->

                       
               <!--          <div class="col-md-6">
                            <h2>Informe de Asistencias</h2>
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
                                        <small>Total:</small>
                                        <h2 id="hombres" class="pull-left m-l-30">{hombres}</h2>
                                        <h2 id="mujeres" class="pull-right m-r-30">{mujeres}</h2>
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
                                    <th class="text-center" data-column-id="fecha" data-order="desc">Fecha</th>
                                    <th class="text-center" data-column-id="hora" data-order="desc">Hora</th>
                                    <th class="text-center" data-column-id="dia" data-order="desc">Dia</th>
                                    <th class="text-center" data-column-id="asistio" data-order="desc"></th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($asistencias as $asistencia)
                                <?php $id = $asistencia['id']; ?>
                                <tr id="{{$id}}" class="disabled"> 
                                    <td class="text-center previa">{{$asistencia['fecha']}}</td>
                                    <td class="text-center previa">{{$asistencia['hora']}}</td>
                                    <td class="text-center previa">{{$asistencia['dia']}}</td>
                                    <td class="text-center previa"><i class="{{$asistencia['asistio']}}"></i></td>
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

        route_filtrar="{{url('/')}}/reportes/asistencias";
        route_detalle="{{url('/')}}/participante/alumno/detalle";

        $(document).ready(function(){

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25, 
        order: [[0, 'desc'], [1, 'desc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
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
                            sexo = '<i class="zmdi zmdi-male-alt f-25 c-azul"></i>'
                        }


                        if (typeof array.fecha === "undefined") {
                            fecha = '';
                            hora = '';
                        }else{
                            fecha = array.fecha;
                            hora = array.hora;
                        }

                        if($('#tipo').val() == 1){
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
             
                        }else{
                            var rowId=array.alumno_id;
                            var rowNode=t.row.add( [
                            ''+array.pertenece+'',
                            ''+array.nombre+ ' '+array.apellido+ '',
                            ''+array.identificacion+'',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            ] ).draw(false).node();
                            $( rowNode )
                              .attr('id',rowId)
                              .addClass('seleccion');
                  
                        }
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
                                content: "%p.0%, %s", 
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
                    if (typeof msj.responseJSON === "undefined") {
                      window.location = "{{url('/')}}/error";
                    }
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
        var id = $(t).closest('tr').attr('id');
        var route =route_detalle+"/"+id;
        window.location=route;
      }

</script>

@stop