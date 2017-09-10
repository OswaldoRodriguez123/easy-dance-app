@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
@stop
@section('content')

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        @if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/administrativo/egresos" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            
                        </ul>
                        @else
                            <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/inicio" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Inicio</a>
                        @endif
                        
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-campana f-25"></i> Selecciona una Campaña</p>
                            <hr class="linea-morada">                                                         
                        </div>
                        @if($campanas)
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                    <th class="text-center" data-column-id="fecha_inicio" data-order="desc">Fecha Inicio</th>
                                    <th class="text-center" data-column-id="fecha_final" data-order="desc">Fecha Final</th>
                                    <th class="text-center" data-column-id="meta" data-order="desc">Meta</th>
                                    <th class="text-center" data-column-id="actual" data-order="desc">Actual</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($campanas as $campana)

                                <?php $id = $campana['id']; ?>
                                <tr id="{{$id}}" class="seleccion" >
                                    <td class="text-center previa">{{$campana['nombre']}}</td>
                                    <td class="text-center previa">{{$campana['fecha_inicio']}}</td>
                                    <td class="text-center previa">{{$campana['fecha_final']}}</td>
                                    <td class="text-center previa">{{ number_format($campana['cantidad'], 2, '.' , '.') }} </td>
                                    <td class="text-center previa">{{ number_format($campana['total'], 2, '.' , '.') }}</td>
                                  </tr>
                            @endforeach 
                                                           
                            </tbody>
                        </table>
                         </div>
                        </div>

                        @else

                               <div class="col-sm-10 col-sm-offset-1 error_general" style="padding-bottom: 300px">


                                  <div align="center"><i class="zmdi zmdi-mood-bad zmdi-hc-5x c-morado"></i></div>
                                  <div class="c-morado f-30 text-center"> Ups! lo sentimos, la academia <b>{{$academia->nombre}}</b> actualmente no ha registrado campañas. </div>


                             </div>




                            @endif
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

        route_detalle="{{url('/')}}/especiales/campañas/egresos";

        $(document).ready(function(){

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,
        //bPaginate: false,    
        order: [[0, 'asc']],
        fnDrawCallback: function() {
        if ("{{count($campanas)}}" < 25) {
              $('.dataTables_paginate').hide();
              $('#tablelistar_length').hide();
          }else{
             $('.dataTables_paginate').show();
          }
        },
        pageLength: 25,
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).attr( "onclick","previa(this)" );
        },
        language: {
                        processing:     "Procesando ...",
                        search:         '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>',
                        searchPlaceholder: "BUSCAR",
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

            });

    function previa(t){
        var row = $(t).closest('tr').attr('id');
        if("{{$usuario_tipo}}" == 1 || "{{$usuario_tipo}}" == 5 || "{{$usuario_tipo}}" == 6)
        {
            var route =route_detalle+"/"+row;
        }else{
            var route =route_progreso+"/"+row;
        }
        window.open(route, '_blank');;
      }

      $("i[name=operacion").click(function(){
            var route =route_operacion+"/"+this.id;
            window.open(route, '_blank');;
        });

      $('#tablelistar tbody').on( 'click', 'i.zmdi-delete', function () {

                var id = $(this).closest('tr').attr('id');
                // var temp = row.split('_');
                // var id = temp[1];
                element = this;

                swal({   
                    title: "Desea eliminar la campaña?",   
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
                        
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
                        eliminar(id, element);
          }
                });
            });
      
        function eliminar(id, element){
         var route = route_eliminar + id;
         var token = "{{ csrf_token() }}";
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'DELETE',
                    dataType: 'json',
                    data:id,
                    success:function(respuesta){
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        if(respuesta.status=="OK"){
                          // finprocesado();
                          var nType = 'success';
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;

                          t.row( $(element).parents('tr') )
                            .remove()
                            .draw();

                        swal("Exito!","La campaña ha sido eliminada!","success");
                        
                        }
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


        </script>
@stop