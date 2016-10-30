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

                                    <select name="estatus_alumno_id" id="estatus_alumno_id">
                                      <option value="1">Activos</option>
                                      <option value="2">Riesgo de ausencia</option>
                                      <option value="3">Inactivos</option>
                                    </select>

                                &nbsp; &nbsp; &nbsp; <label>Clase Grupal</label> &nbsp; &nbsp; &nbsp;


                                <select name="clase_grupal_id" id="clase_grupal_id">
                                    @foreach ($clases_grupales as $clase)
                                        <?php $id = $clase['id']; ?>
                                        <option value="{{$id}}">                       
                                            {{$clase['nombre']}} - {{$clase['dia']}} - 
                                            {{$clase['hora_inicio']}}/ 
                                            {{$clase['hora_final']}} -  {{$clase['instructor_nombre']}}
                                            {{$clase['instructor_apellido']}}
                                        </option>
                                    @endforeach                                
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
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombres</th>
                                    <th class="text-center" data-column-id="cedula" data-order="desc">Cedula</th>
                                    <th class="text-center" data-column-id="fecha_nacimiento" data-order="desc">Fecha Nacimiento</th>
                                    <th class="text-center" data-column-id="estatus_e">Estatus de Alumno</th>
                                    <th class="text-center" data-column-id="clase_grupal" data-order="desc">Clase Grupal</th>
                                    <th class="text-center" data-column-id="celular">Contacto Móvil</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($alumnos as $alumno)
                                <?php $id = $alumno->inscripcion_id; ?>
                                <tr id="{{$id}}" class="seleccion">
                                    <td class="text-center previa">{{$reporte_datos[$id]['alumno_nombre']}} {{$reporte_datos[$id]['alumno_apellido']}}</td>
                                    <td class="text-center previa">{{$reporte_datos[$id]['alumno_identificacion']}}</td>
                                    <td class="text-center previa">{{$reporte_datos[$id]['alumno_nacimiento']}}</td>
                                    <td class="text-center previa"><label class="label estatusc-verde f-16"><i data-toggle="modal" href="#" class="zmdi zmdi-label-alt-outline f-20 p-r-3 operacionModal {{$reporte_datos[$id]['estatus_alumno']}}"></i></label></td>
                                    <td class="text-center previa">{{$reporte_datos[$id]['clase_grupal']}}</td>
                                    <td class="text-center previa">{{$reporte_datos[$id]['alumno_celular']}}</td>
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

        route_filtrar="{{url('/')}}/reportes/estatus_alumnos/filtrar";

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 50, 
        // paging:false, 
        order: [[0, 'desc']],
        fnDrawCallback: function() {
          $('.dataTables_paginate').show();
          /*if ($('#tablelistar tr').length < 25) {
              $('.dataTables_paginate').hide();
          }
          else{
             $('.dataTables_paginate').show();
          }*/
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

                        var rowId=array.id;
                        var rowNode=t.row.add( [
                        ''+array.alumno_nombre+ ' '+array.alumno_apellido+ '',
                        ''+array.alumno_identificacion+'',
                        ''+array.alumno_nacimiento+'',
                        ''+"<i data-toggle='modal' href='#' class='zmdi zmdi-label-alt-outline f-20 p-r-3 operacionModal "+array.estatus_alumno+"'></i>",
                        ''+array.clase_grupal+'',
                        ''+array.alumno_celular+'',
                        ] ).draw(false).node();
                        $( rowNode )
                          .attr('id',rowId)
                          .addClass('seleccion');
                    });

                    datos = JSON.parse(JSON.stringify(respuesta));

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
</script>

@stop