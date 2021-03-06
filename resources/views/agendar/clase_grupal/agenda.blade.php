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
                        <?php $url = "/agendar/clases-grupales/detalle/$id" ?>
                        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                        @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                            <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                                <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                                
                                <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                                
                                <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                                
                                <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                               
                                <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                                
                            </ul>
                        @endif
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">

                            <div class="text-right">
                              <span class="f-15">Realizadas: <span id="horas_asignadas">{{$realizadas}}</span><br>
                              <span class="f-15">Restantes: <span id="horas_restantes">{{$restantes}}</span>
                            </div>
  
                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-clases-grupales f-25"></i> Clase Grupal: {{$nombre}}</p>
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
                                    <th id="fecha" class="text-center" data-column-id="fecha">Fecha</th>
                                    <th class="text-center" data-column-id="dia">D??a</th>
                                    <th class="text-center" data-column-id="horario" data-order="desc">Horario</th>
                                    <th class="text-center" data-column-id="especialidad" data-order="desc">Especialidad</th>
                                    <th class="text-center" data-column-id="instructor" data-order="desc">Instructor</th>
                                    @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                                        <th class="text-center" data-column-id="operacion" data-order="desc" >Acciones</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($activas as $fecha)

                                <tr id = "{{$fecha['id']}}" class="disabled" data-fecha="{{$fecha['fecha_inicio']}}">
                                    <td class="text-center previa">{{$fecha['fecha_inicio']}}</td>
                                    <td class="text-center previa">{{$fecha['dia']}}</td>
                                    <td class="text-center previa">{{$fecha['hora_inicio']}} - {{$fecha['hora_final']}}</td>
                                    <td class="text-center previa">{{$fecha['especialidad']}}</td>
                                    <td class="text-center previa">{{$fecha['instructor']}}</td>
                                    @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                                        <td class="text-center disabled"> 
                                            @if($fecha['tipo'] == 'activa')
                                                <i class="zmdi zmdi-close-circle-o f-20 p-r-10 pointer cancelar" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Cancelar Clase" title="" data-original-title="Ayuda" data-html="true"></i>
                                                
                                            @else
                                                <i name = "pop-activar" id = "pop-activar" aria-describedby="popoveractivar" class="zmdi zmdi-close-circle f-20 c-youtube p-r-10 disabled" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Esta clase ha sido cancelada, si desea activarla haga click en el siguiente enlace <br> 

                                                <div class='text-center'>

                                                    <span id = '{{$fecha['bloqueo_id']}}' class='activar pointer f-700 c-azul'>Activar</span>

                                                </div>" title="" data-original-title="Ayuda" data-html="true"></i>
                                            @endif
                                            
                                        </td>
                                    @endif
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

    route_operacion="{{url('/')}}/agendar/clases-grupales/operaciones/";
    route_eliminar="{{url('/')}}/agendar/clases-grupales/eliminar-cancelacion/";
    route_cancelar="{{url('/')}}/agendar/clases-grupales/canceladas/";

    var finalizadas = <?php echo json_encode($finalizadas);?>;
    var activas = <?php echo json_encode($activas);?>;

    $(document).ready(function(){

        $("#activas").prop("checked", true);

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,   
        order: [[0, 'asc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2)', nRow).addClass( "disabled" );
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
    });


    $('#tablelistar tbody').on( 'click', '.cancelar', function () {

        fecha = $(this).closest('tr').data('fecha')
        id = $(this).closest('tr').attr('id')

        $.ajax({

            url: "{{url('/')}}/guardar-fecha",
            headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}" },
            type: 'POST',
            dataType: 'json',
            data:"fecha_inicio="+fecha,
            success:function(respuesta){

                window.location = route_cancelar + id

            }
        });        
    });

    $("#activas").click(function(){
        $( "#finalizadas2" ).removeClass( "c-verde" );
        $( "#activas2" ).addClass( "c-verde" );
    });

    $("#finalizadas").click(function(){
        $( "#finalizadas2" ).addClass( "c-verde" );
        $( "#activas2" ).removeClass( "c-verde" );
    });


     function rechargeActivas(){

            if(activas.length > 25){
                $('.dataTables_paginate').show();
                $('.dataTables_length').show();
            }else{
                $('.dataTables_paginate').hide();
                $('.dataTables_length').hide();
            }

            $.each(activas, function (index, array) {

                if(array.tipo == 'activa'){
                    opcion = '<i class="zmdi zmdi-close-circle-o f-20 p-r-10 pointer cancelar" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Cancelar Clase" title="" data-original-title="Ayuda" data-html="true"></i>'
                }else{
                    opcion = '<i name = "pop-activar" id = "pop-activar" aria-describedby="popoveractivar" class="zmdi zmdi-close-circle f-20 c-youtube p-r-10 disabled" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Esta clase ha sido cancelada, si desea activarla haga click en el siguiente enlace <br> <div class="text-center"><span id = '+array.bloqueo_id+' class="activar pointer f-700 c-azul">Activar</span></div>" title="" data-original-title="Ayuda" data-html="true"></i>'
                }

                var rowNode=t.row.add( [
                ''+array.fecha_inicio+'',
                ''+array.dia+'',
                ''+array.hora_inicio+' - '+array.hora_final+'' ,
                ''+array.especialidad+'',
                ''+array.instructor+'' ,
                ''+opcion+''
                ] ).draw(false).node();
                $( rowNode )
                    .addClass('disabled')
                    .attr('id', array.id)
                    .attr('data-fecha', array.fecha_inicio);
            });

            $('[data-toggle="popover"]').popover(); 

            if($('#fecha').hasClass('sorting_desc')){
                $('#fecha').click();
            }
        }

        function rechargeFinalizadas(){

            if(finalizadas.length > 25){
                $('.dataTables_paginate').show();
                $('.dataTables_length').show();
            }else{
                $('.dataTables_paginate').hide();
                $('.dataTables_length').hide();
            }

            $.each(finalizadas, function (index, array) {

                var rowNode=t.row.add( [
                ''+array.fecha_inicio+'',
                ''+array.dia+'',
                ''+array.hora_inicio+' - '+array.hora_final+'' ,
                ''+array.especialidad+'',
                ''+array.instructor+'' ,
                ''
                ] ).draw(false).node();
                $( rowNode )
                    .attr('id', array.id)
                    .addClass('disabled')
                    .addClass('seleccion_deleted');
            });

            if($('#fecha').hasClass('sorting_asc')){
                $('#fecha').click();
            }
        }

        function clear(){
            t.clear().draw();
        }

        $('input[name="tipo"]').on('change', function(){
            clear();
            if ($(this).val()=='activas') {
                tipo = 'activas';
                rechargeActivas();
            } else if($(this).val()=='finalizadas')  {
                tipo= 'finalizadas';
                rechargeFinalizadas();
            }
         });

        $('#pop-activar').popover({
                    html: true,
                    trigger: 'manual'
                }).on( "mouseenter", function(e) {

                    $(this).popover('show');

                    e.preventDefault();
          });

        $('body').on('click', function (e) {
            $('[data-toggle="popover"]').each(function () {
                //the 'is' for buttons that trigger popups
                //the 'has' for icons within a button that triggers a popup
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    $(this).popover('hide');
                }
            });
        });

    // $(".activar").click(function(){
    $("html").click(function (e){
        element = e.target
        if($(element).hasClass('activar')){
          swal({   
              title: "Desea activar la clase?",   
              text: "Confirmar activaci??n!",   
              type: "warning",   
              showCancelButton: true,   
              confirmButtonColor: "#DD6B55",   
              confirmButtonText: "Activar!",  
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
              var nTitle="Ups! ";
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              var bloqueo_id = $(element).attr('id');
              var id = $(element).closest('tr').attr('id')
              eliminar(bloqueo_id, id);
            }
          });
        }
    });

    function eliminar(bloqueo_id, id){
      var route = route_eliminar + bloqueo_id;
      var token = "{{ csrf_token() }}";

      procesando();

      $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'DELETE',
        dataType: 'json',
        success:function(respuesta){

          swal("Hecho!","Activada con ??xito!","success");

          $("#"+id).find("td").eq(4).empty();   
          $("#"+id).find("td").eq(4).html('<i class="zmdi zmdi-close-circle-o f-20 p-r-10 pointer cancelar" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Cancelar Clase" title="" data-original-title="Ayuda" data-html="true"></i>');

          $('[data-toggle="popover"]').popover(); 

          finprocesado();

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
    }

    </script>
@stop