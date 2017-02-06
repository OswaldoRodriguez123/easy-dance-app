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


<a href="{{url('/')}}/agendar/citas/calendario" class="btn bgm-blue btn-float waves-effect m-btn" data-trigger="hover" data-toggle="popover" data-placement="left" data-content="" title="" data-original-title="Calendario"><i class="zmdi zmdi-calendar"></i></a>
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menu Principal</a>
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
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
                            <span class="f-16 p-t-0 text-success">Agregar una Cita <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span>

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-calendar-check f-25"></i> Sección de Citas</p>
                            <hr class="linea-morada">  

                            <div class="col-sm-12">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="activas" value="activas" type="radio">
                                        <i class="input-helper"></i>  
                                        Activas <i id="activas2" name="activas2" class="zmdi zmdi-label-alt-outline zmdi-hc-fw c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="finalizadas" value="finalizadas" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Finalizadas <i id="finalizadas2" name="finalizadas2" class="zmdi zmdi-check zmdi-hc-fw f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="canceladas" value="canceladas" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Canceladas <i id="canceladas2" name="canceladas2" class="zmdi zmdi-close zmdi-hc-fw f-20"></i>
                                    </label>
                                    </div>
                                    
                                 </div>
                                </div> 

                                 <div class="clearfix"></div>                                                         
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="acepto" data-order="desc"></th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Cliente</th>
                                    <th class="text-center" data-column-id="fecha">Fecha</th>
                                    <th class="text-center" data-column-id="horario" data-order="desc">Horario</th>
                                    <th class="text-center" data-column-id="tipo" data-order="desc">Tipo</th>
                                    <th class="text-center" data-column-id="instructor" data-order="desc">Instructor</th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" >Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                                                           
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

        route_detalle="{{url('/')}}/agendar/citas/detalle";
        route_operacion="{{url('/')}}/agendar/citas/operaciones";
        route_eliminar="{{url('/')}}/agendar/citas/eliminar/";

        var finalizadas = <?php echo json_encode($finalizadas);?>;
        var activas = <?php echo json_encode($activas);?>;
        var canceladas = <?php echo json_encode($canceladas);?>;
        var asistencias = <?php echo json_encode($asistencias);?>;

        tipo = 'activas';

        $(document).ready(function(){

        $("#activas").prop("checked", true);

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,   
        order: [[0, 'asc']],
        fnDrawCallback: function() {
        if ("{{count($activas)}}" < 25) {
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

            rechargeActivas();


            });

    function previa(t){
            var row = $(t).closest('tr');

            if(tipo == 'activas')
            {

              var id = $(row).attr('id');
              var route =route_detalle+"/"+id;
              window.location=route;


            }else if(tipo == 'canceladas'){

              var fecha = $(row).find('td').eq(4).html();
              var hora = $(row).find('td').eq(5).html();
              var instructor = $(row).find('td').eq(3).html();
              var cancelacion = row.data('cancelacion');
              $('.span_fecha').text(fecha)
              $('.span_hora').text(hora)
              $('.span_instructor').text(instructor)
              $('#razon_cancelacion').text(cancelacion)
              $("#modalCancelar" ).modal('show');

            }
      }

      $('#tablelistar tbody').on( 'click', 'i.zmdi-delete', function () {

                var id = $(this).closest('tr').attr('id');
                // var temp = row.split('_');
                // var id = temp[1];
                element = this;

                swal({   
                    title: "Desea eliminar la cita?",   
                    text: "Confirmar eliminación!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Eliminar!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: false 
                }, function(isConfirm){   
          if (isConfirm) {
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nType = 'success';
            var nAnimIn = $(this).attr('data-animation-in');
            var nAnimOut = $(this).attr('data-animation-out')
                        swal("Exito!","La fiesta o evento ha sido eliminada!","success");
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
                        
                        }
                    },
                    error:function(msj){
                                $("#msj-danger").fadeIn(); 
                                var text="";
                                console.log(msj);
                                var merror=msj.responseJSON;
                                text += " <i class='glyphicon glyphicon-remove'></i> Por favor verifique los datos introducidos<br>";
                                $("#msj-error").html(text);
                                setTimeout(function(){
                                         $("#msj-danger").fadeOut();
                                        }, 3000);
                                }
                });

        $("#activas").click(function(){
            $( "#finalizadas2" ).removeClass( "c-verde" );
            $( "#canceladas2" ).removeClass( "c-verde" );
            $( "#activas2" ).addClass( "c-verde" );
        });

        $("#finalizadas").click(function(){
            $( "#finalizadas2" ).addClass( "c-verde" );
            $( "#canceladas2" ).removeClass( "c-verde" );
            $( "#activas2" ).removeClass( "c-verde" );
        });

        $("#canceladas").click(function(){
            $( "#finalizadas2" ).removeClass( "c-verde" );
            $( "#canceladas2" ).addClass( "c-verde" );
            $( "#activas2" ).removeClass( "c-verde" );
        });
      }


      function clear(){

            t.clear().draw();
            // t.destroy();
         }

         $('input[name="tipo"]').on('change', function(){
            clear();
            if ($(this).val()=='activas') {
                  tipo = 'activas';
                  rechargeActivas();
            } else if($(this).val()=='finalizadas')  {
                  tipo= 'finalizadas';
                  rechargeFinalizadas();
            }else{
                  tipo= 'canceladas';
                  rechargeCanceladas();
            }
         });

         function rechargeActivas(){

            $.each(activas, function (index, array) {

                var rowNode=t.row.add( [
                '',
                ''+array.alumno_nombre+' '+array.alumno_apellido+'' ,
                ''+array.fecha+'',
                ''+array.hora_inicio+' - '+array.hora_final+'' ,
                ''+array.tipo_nombre+'',
                ''+array.instructor_nombre+' '+array.instructor_apellido+'' ,
                '<i data-toggle="modal" class="zmdi zmdi-delete eliminar f-20 p-r-10">'
                ] ).draw(false).node();
                $( rowNode )
                    .attr('id',array.id)
                    .addClass('seleccion');
            });
        }

        function rechargeFinalizadas(){

            $.each(finalizadas, function (index, array) {

              if(asistencias[array.id]){
                acepto = '<i class="zmdi c-verde zmdi-check zmdi-hc-fw f-20"></i>'
              }else{
                acepto = '<i class="zmdi c-youtube zmdi-close zmdi-hc-fw f-20"></i>';
              }

                var rowNode=t.row.add( [
                ''+acepto+'' ,
                ''+array.alumno_nombre+' '+array.alumno_apellido+'' ,
                ''+array.fecha+'',
                ''+array.hora_inicio+' - '+array.hora_final+'' ,
                ''+array.tipo_nombre+'',
                ''+array.instructor_nombre+' '+array.instructor_apellido+'' ,
                ''
                ] ).draw(false).node();
                $( rowNode )
                    .attr('id',array.id)
                    .addClass('seleccion');
            });
        }

        function rechargeCanceladas(){
    
            $.each(canceladas, function (index, array) {

                var rowNode=t.row.add( [
                '' ,
                ''+array.alumno_nombre+' '+array.alumno_apellido+'' ,
                ''+array.fecha+'',
                ''+array.hora_inicio+' - '+array.hora_final+'' ,
                ''+array.tipo_nombre+'',
                ''+array.instructor_nombre+' '+array.instructor_apellido+'' ,
                ''
                ] ).draw(false).node();
                $( rowNode )
                    .attr('id',array.id)
                    .attr('data-cancelacion',array.razon_cancelacion)
                    .addClass('seleccion');
            });
        }

    </script>
@stop