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


            <a href="{{url('/')}}/participante/visitante/agregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menú Principal</a>
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
                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-visitante-presencial f-25"></i> Sección de Encuestas</p>
                            <hr class="linea-morada">                                                         
                        </div>
                        <div class="table-responsive row">
                          <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" name="tablelistar">
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombres</th>
                                    <th class="text-center" data-column-id="fecha">Fecha</th>
                                    <th class="text-center" data-column-id="hora">Hora</th>
                                    <th class="text-center" data-column-id="dia">Día</th>
                                    <th class="text-center" data-column-id="operaciones">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                              @foreach ($visitantes as $visitante)

                                <?php $id = $visitante['id']; ?>

                                <tr id="{{$id}}" class="seleccion" >
                                  <td class="text-center previa">
                                    {{$visitante['nombre']}} {{$visitante['apellido']}} 
                                  </td>
                                  <td class="text-center previa">{{$visitante['fecha_encuesta']}}</td>
                                  <td class="text-center previa">{{$visitante['hora_encuesta']}}</td>
                                  <td class="text-center previa">
                                    {{$visitante['dia']}}
                                  </td>
                                  <td class="text-center disabled"> 
                                    <a href="{{url('/participante/visitante/encuesta')}}/{{$id}}" target="_blank"><i class="zmdi zmdi-eye f-16" data-original-title="" data-content="Ver Encuesta" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover">
                                  </td>
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
   
        t=$('#tablelistar').DataTable({
          processing: true,
          serverSide: false,
          pageLength: 25,   
          order: [[1, 'desc'],[2, 'desc']],
          fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)', nRow).addClass( "text-center" );
            $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6)', nRow).attr( "onclick","previa(this)" );
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

      function previa(t){
        var id = $(t).closest('tr').attr('id');
        var route =route_detalle+"/"+id;
        window.open(route, '_blank');
      }

      $('#tablelistar tbody').on('mouseenter', 'a.dropdown-toggle', function () {

            var id = $(this).closest('tr').attr('id');
            var dropdown = $(this).closest('.dropdown')
            var dropdown_toggle = $(this).closest('.dropdown-toggle')

            $('.dropdown-toggle').attr('aria-expanded','false')
            $('.dropdown').removeClass('open')
            $('.table-responsive').css( "overflow", "auto" );

            if(!dropdown.hasClass('open')){
                dropdown.addClass('open')
                dropdown_toggle.attr('aria-expanded','true')
                $('.table-responsive').css( "overflow", "inherit" );
            }
         
        });

        $('.table-responsive').on('hide.bs.dropdown', function () {
          $('.table-responsive').css( "overflow", "auto" );
        }) 

        $(".email").click(function(){

            var route = route_email;
            var token = '{{ csrf_token() }}';
            var id = $(this).closest('tr').attr('id');
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    data:"&usuario_tipo=3&usuario_id="+id,
                    success:function(respuesta){

                        procesando();
                        window.location="{{url('/')}}/correo/"+id   

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
      });

      $(".reservar").click(function(){

        procesando();
        var route = "{{url('/')}}/reservacion/guardar-tipo-usuario/2";
        var token = '{{ csrf_token() }}';
        var id = $(this).closest('tr').attr('id');
            
        $.ajax({
            url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
            dataType: 'json',
            success:function(respuesta){
                window.location = "{{url('/')}}/reservaciones/actividades/"+id

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
                        finprocesado();
                        swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                        }
        });
    })

    $(".eliminar").click(function(){
            var id = $(this).closest('tr').attr('id');
            swal({   
                title: "Desea eliminar al visitante?",   
                text: "Confirmar eliminación!",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Eliminar!",  
                cancelButtonText: "Cancelar",         
                closeOnConfirm: true 
            }, function(isConfirm){   
      if (isConfirm) {
        var route = route_eliminar + id;
        var token = '{{ csrf_token() }}';
            
            $.ajax({
                url: route,
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'DELETE',
                dataType: 'json',
                data:id,
                success:function(respuesta){

                    procesando();
                    window.location = route_principal; 

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
        });
    });

    </script>
@stop