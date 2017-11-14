@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/summernote/dist/summernote.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script src="{{url('/')}}/assets/vendors/summernote/dist/summernote.js"></script>
<!--<script src="{{url('/')}}/assets/vendors/summernote/dist/summernote-updated.min.js"></script>-->
<script src="{{url('/')}}/assets/vendors/summernote/dist/lang/summernote-es-ES.js"></script>
@stop
@section('content')

    <a href="{{url('/')}}/participante/visitante/llamadas/agregar/{{$id}}" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
    
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <!-- <?php $url = "/participante/visitante/detalle/$id" ?>
                        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a> -->
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/participante/visitante" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Visitante</a>
                        
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            
                        </ul>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header ">

                            <div class="col-sm-6 text-left">
                                <p>Interesado: <b>{{$interesado->nombre}}</b></p>
                                <p>Correo: <b>{{$interesado->correo}}</b></p>
                                <p>Telefono: <b>{{$interesado->telefono_local}}</b></p>
                                <p>Celular: <b>{{$interesado->telefono_movil}}</b></p>
                            </div>

                            <div class="col-sm-6 text-right">
                                <span class="f-16 p-t-0 text-success">Agregar una Llamada <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span>
                            </div>

                            <div class="clearfix"></div>

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-phone f-25"></i> Sección de Llamadas</p>
                            <hr class="linea-morada">                                                         
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" name="tablelistar">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Estatus</th>
                                    <th>Observación</th>
                                    <th>Hora de llamada</th>
                                    <th>Tiempo de Respuesta</th>
                                    <th>Fecha de la proxima llamada</th>
                                    <th>Hora de la proxima llamada</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($llamadas as $llamada)
                                <?php 

                                  \Carbon\Carbon::setLocale('es');

                                  $fecha_llamada = $llamada->created_at;
                                  $tiempo_respuesta = $fecha_llamada->diffForHumans($interesado->created_at); 

                                  $contenido = '';

                                  $contenido = 
                                  '<p class="c-negro">' .
                                      'Observación: ' . $llamada->observacion . '<br>'.
                                  '</p>'; 


                                ?>
                                <?php $id = $llamada->id; ?>
                                <tr data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "{{$contenido}}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "" id="{{$id}}" class="seleccion">

                                  <td><span style="display:none">{{$llamada->fecha_llamada}}</span></td>

                                  <td>

                                  @if($llamada->status == 1)

                                     <label class="label label-success"> </label>

                                  @elseif($llamada->status == 2)

                                    <label class="label label-danger"> </label>

                                  @else

                                    <label class="label label-warning"> </label>

                                  @endif
                                  </td>
                                  <td>{{ str_limit(title_case($llamada->observacion), $limit = 30, $end = '...') }}</td>
                                  <td>

                                    @if($tipo_horario == 2)
                                        {{\Carbon\Carbon::createFromFormat('H:i:s',$llamada->hora_llamada)->format('H:i')}}
                                    @else
                                        {{\Carbon\Carbon::createFromFormat('H:i:s',$llamada->hora_llamada)->format('g:i a')}}
                                    @endif
               
                                  </td>
                                  <td>{{$tiempo_respuesta}}</td>

                                  <td>{{$llamada->fecha_siguiente}}</td>

                                  <td>

                                    @if($llamada->hora_siguiente)
                                      @if($tipo_horario == 2)
                                          {{\Carbon\Carbon::createFromFormat('H:i:s',$llamada->hora_siguiente)->format('H:i')}}
                                      @else
                                          {{\Carbon\Carbon::createFromFormat('H:i:s',$llamada->hora_siguiente)->format('g:i a')}}
                                      @endif
                                    @endif
               
                                  </td>
                                  <td class="text-center disabled"> <i id={{$id}} class="zmdi zmdi-delete boton red f-20 p-r-10 pointer eliminar"></i></td>
                                    
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
@stop

@section('js') 
            
    <script type="text/javascript">

        route_eliminar="{{url('/')}}/participante/visitante/llamadas/eliminar/";
            
    $(document).ready(function() {

      t = $('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,   
        order: [[1, 'desc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)', nRow).addClass("disabled");
        },
        language: {
                       processing:     "Procesando ...",
                       search:         '<span class="glyphicon glyphicon-search"></span>',
                       searchPlaceholder: "Buscar",
                       lengthMenu:     "Mostrar _MENU_ Registros",
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
    } );

    $(".eliminar").click(function(){
                var id = $(this).closest('tr').attr('id');
                element = this;
                swal({   
                    title: "Desea eliminar esta llamada?",   
                    text: "Confirmar eliminación!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Eliminar!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
          if (isConfirm) {
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nType = 'success';
            var nAnimIn = $(this).attr('data-animation-in');
            var nAnimOut = $(this).attr('data-animation-out')

            eliminar(id, element);
          }
                });
            });
      function eliminar(id, element){
         var route = route_eliminar + id;
         var token = '{{ csrf_token() }}';
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'DELETE',
                    dataType: 'json',
                    data:id,
                    success:function(respuesta){

                        swal("Listo!","Ha sido eliminado con exito!","success");
                        t.row( $(element).parents('tr') )
                            .remove()
                            .draw(false);

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
                                //         
                                swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                                }
                });
      }

      function previa(t){
        var row = $(t).closest('tr');
        var observacion = row.data('observacion');
        $('#observacion').text(observacion)
        $('#modalObservacion').modal('show')
      }



    </script>
@stop